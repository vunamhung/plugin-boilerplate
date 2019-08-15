<?php

namespace vnh_namespace;

use vnh_namespace\tools\contracts\Bootable;
use vnh_namespace\tools\contracts\Initable;
use vnh_namespace\tools\Register_Assets;

abstract class Core implements Bootable, Initable {
	public $main_plugin_file;
	public $main_plugin_dir;
	public static $plugin;

	/**
	 * @var Register_Assets
	 */
	public $frontend_assets;

	/**
	 * @var Register_Assets
	 */
	public $backend_assets;

	public function __clone() {
		_doing_it_wrong(__FUNCTION__, esc_html__('Cheatin&#8217; huh?', 'vnh_textdomain'), '1,0');
	}

	public function __wakeup() {
		_doing_it_wrong(__FUNCTION__, esc_html__('Cheatin&#8217; huh?', 'vnh_textdomain'), '1,0');
	}

	protected function __construct($main_plugin_file) {
		$this->main_plugin_file = $main_plugin_file;
		$this->main_plugin_dir = dirname($main_plugin_file);
		$this->prepare();
		$this->init();
		$this->register_core();
		$this->boot();
	}

	public function prepare() {
		if (empty($GLOBALS['wp_filesystem'])) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
			WP_Filesystem();
		}

		if (!function_exists('get_plugin_data')) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$plugin = get_plugin_data($this->main_plugin_file);

		self::$plugin = [
			'name' => $plugin['Name'],
			'description' => $plugin['Description'],
			'uri' => $plugin['PluginURI'],
			'version' => $plugin['Version'],
			'author_name' => $plugin['AuthorName'],
			'author_uri' => $plugin['AuthorURI'],
			'textdomain' => $plugin['TextDomain'],
			'author' => $plugin['Author'],
			'title' => $plugin['Title'],
			'base' => plugin_basename($this->main_plugin_file),
			'slug' => basename($this->main_plugin_file),
			'path' => trailingslashit($this->main_plugin_dir),
			'url' => plugin_dir_url($this->main_plugin_file),
		];
	}

	public function init() {
		new Helpers();
		new Helpers_Global();
		new KSES();
		new Constants();
	}

	abstract public function register_frontend_assets();

	abstract public function register_backend_assets();

	public function register_core() {
		$this->frontend_assets = new Register_Assets($this->register_frontend_assets(), 'frontend');
		$this->frontend_assets->boot();

		$this->backend_assets = new Register_Assets($this->register_backend_assets(), 'backend');
		$this->backend_assets->boot();
	}

	public function boot() {
		add_action('plugin_loaded', [$this, 'load_plugin_textdomain']);

		register_activation_hook($this->main_plugin_file, [$this, 'install']);
		register_deactivation_hook($this->main_plugin_file, [$this, 'uninstall']);

		add_action('admin_enqueue_scripts', [$this, 'enqueue_backend_assets']);
		add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_assets']);
	}

	public function load_plugin_textdomain() {
		load_plugin_textdomain('vnh_textdomain');
	}

	public function install() {
		do_action('vnh_prefix_install');
	}

	public function uninstall() {
		do_action('vnh_prefix_uninstall');
	}

	abstract public function enqueue_frontend_assets();

	abstract public function enqueue_backend_assets();
}
