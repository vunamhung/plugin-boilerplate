<?php

namespace vnh_namespace;

use vnh_namespace\tools\contracts\Bootable;
use vnh_namespace\tools\contracts\Initable;
use vnh_namespace\tools\KSES;
use vnh_namespace\tools\Register_Assets;
use vnh_namespace\tools\Singleton;

abstract class Core extends Singleton implements Bootable, Initable {
	use Core_Variables;

	protected function __construct($plugin_file) {
		$this->plugin_file = $plugin_file;
		$this->plugin_dir = dirname($plugin_file);

		$this->prepare();
		$this->init();
		$this->register_core();
		$this->boot();
	}

	public function prepare() {
		register_activation_hook($this->plugin_file, [$this, 'install']);
		register_deactivation_hook($this->plugin_file, [$this, 'uninstall']);

		if (empty($GLOBALS['wp_filesystem'])) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
			WP_Filesystem();
		}

		if (!function_exists('get_plugin_data')) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$plugin = get_plugin_data($this->plugin_file);

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
			'base' => plugin_basename($this->plugin_file),
			'slug' => basename($this->plugin_dir),
			'path' => trailingslashit($this->plugin_dir),
			'url' => plugin_dir_url($this->plugin_file),
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
