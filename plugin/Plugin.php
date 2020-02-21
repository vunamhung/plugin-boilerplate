<?php
/**
 * Plugin Name: vnh_name
 * Description: vnh_description
 * Version: vnh_version
 * Tags: vnh_tags
 * Author: vnh_author
 * Author URI: vnh_author_uri
 * License: vnh_license
 * License URI: vnh_license_uri
 * Document URI: vnh_document_uri
 * Text Domain: vnh_textdomain
 * Tested up to: WordPress vnh_tested_up_to
 * WC requires at least: vnh_wc_requires
 * WC tested up to: vnh_wc_tested_up_to
 */

namespace vnh_namespace;

defined('ABSPATH') || die();

use vnh\Plugin_Checker;
use vnh\Singleton;
use vnh_namespace\admin\Admin;
use vnh_namespace\admin\menu\Admin_Menu;
use vnh_namespace\settings_page\Settings_Page;
use vnh_namespace\tools\Config_CMB2;
use vnh_namespace\tools\KSES;
use vnh_namespace\tools\Register_Assets;

use function vnh\is_woocommerce_active;

const PLUGIN_FILE = __FILE__;
const PLUGIN_DIR = __DIR__;

require_once __DIR__ . '/vendor/autoload.php';

final class Plugin extends Singleton {
	public $php_checker;
	public $wp_checker;
	public $settings_page;
	public $admin_menus;
	public $admin_notices;
	public $frontend_assets;
	public $backend_assets;
	public $widgets;
	public $config_cmb2;

	protected function __construct() {
		$this->php_checker = new Plugin_Checker(MIN_PHP_VERSION, 'PHP', PLUGIN_FILE);
		$this->wp_checker = new Plugin_Checker(MIN_WP_VERSION, 'WordPress', PLUGIN_FILE);
		$this->admin_menus = new Admin_Menu();
		$this->admin_notices = new Admin();
		$this->settings_page = new Settings_Page();
		$this->config_cmb2 = new Config_CMB2();
		$this->backend_assets = new Register_Assets($this->register_backend_assets(), 'backend');
		$this->frontend_assets = new Register_Assets($this->register_frontend_assets(), 'frontend');
	}

	public function init() {
		new KSES();

		$this->php_checker->init();
		$this->wp_checker->init();

		$this->frontend_assets->boot();

		if (is_admin()) {
			$this->backend_assets->boot();

			$this->admin_menus->boot();

			$this->admin_notices->init();
			$this->admin_notices->boot();

			$this->settings_page->init();
			$this->settings_page->boot();

			$this->config_cmb2->boot();
		}
	}

	public function core() {
		if (!is_woocommerce_active()) {
			return;
		}
	}

	public function register_backend_assets() {
		return [
			'styles' => [
				handle('settings-page') => [
					'src' => get_plugin_url('assets/css/settings_page.css'),
				],
			],
			'scripts' => [
				handle('settings-page') => [
					'src' => get_plugin_url('assets/js/dist/settings_page.js'),
					'deps' => ['jquery', 'jquery-form', 'jquery-ui-sortable'],
					'localize_script' => [
						'settingsPage' => [
							'saveMessage' => esc_html__('Settings Saved Successfully', 'vnh_textdomain'),
						],
					],
				],
			],
		];
	}

	public function register_frontend_assets() {
		return [
			'styles' => [],
			'scripts' => [
				PLUGIN_SLUG => [
					'src' => get_plugin_url('assets/js/dist/frontend.js'),
					'deps' => ['jquery'],
				],
			],
		];
	}

	public function boot() {
		add_action('plugin_loaded', [$this, 'load_plugin_textdomain']);
		add_action('admin_enqueue_scripts', [$this, 'enqueue_backend_assets']);
		add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_assets']);
	}

	public function load_plugin_textdomain() {
		load_plugin_textdomain('vnh_textdomain', false, plugin_languages_path(PLUGIN_FILE));
	}

	public function enqueue_backend_assets() {
		if (is_plugin_settings_page()) {
			wp_enqueue_style(handle('settings-page'));
			wp_enqueue_script(handle('settings-page'));
		}
	}

	public function enqueue_frontend_assets() {
		wp_enqueue_script(PLUGIN_SLUG);
	}
}

Plugin::instance();
Plugin::instance()->init();
Plugin::instance()->core();
Plugin::instance()->boot();
