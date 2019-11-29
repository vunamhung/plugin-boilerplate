<?php

namespace vnh_namespace;

defined('WPINC') || die();

use vnh_namespace\settings_page\Settings_Page;
use vnh_namespace\tools\contracts\Bootable;
use vnh_namespace\tools\contracts\Initable;
use vnh_namespace\tools\contracts\Loadable;
use vnh_namespace\tools\KSES;
use vnh_namespace\tools\Register_Assets;
use vnh_namespace\tools\Singleton;

final class Plugin extends Singleton implements Loadable, Bootable, Initable {
	use Variables;

	protected function __construct() {
		$this->load();
		$this->init();
		$this->core();
		$this->register_assets();
		$this->boot();
	}

	public function load() {
		if (!function_exists('is_plugin_active')) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
	}

	public function init() {
		new KSES();

		if (is_admin()) {
			$this->admin_notices = new Admin_Notices();
			$this->admin_notices->boot();

			$this->settings_page = new Settings_Page();
			$this->settings_page->init();
			$this->settings_page->boot();
		}
	}

	public function core() {
		if (!is_plugin_active('woocommerce/woocommerce.php')) {
			return;
		}
	}

	public function register_assets() {
		$this->backend_assets = new Register_Assets($this->register_backend_assets(), 'backend');
		$this->backend_assets->boot();

		//$this->frontend_assets = new Register_Assets($this->register_frontend_assets(), 'frontend');
		//$this->frontend_assets->boot();
	}

	public function register_backend_assets() {
		return [
			'styles' => [
				PLUGIN_SLUG . '-settings-page' => [
					'src' => get_plugin_url('assets/css/settings_page.css'),
				],
			],
			'scripts' => [
				PLUGIN_SLUG . '-settings-page' => [
					'src' => get_plugin_url('assets/js/settings-page.js'),
					'deps' => ['jquery', 'jquery-form'],
					'localize_script' => [
						'settingsPage' => [
							'saveMessage' => esc_html__('Settings Saved Successfully', 'vnh_textdomain'),
						],
					],
				],
			],
		];
	}

	public function boot() {
		add_action('plugin_loaded', [$this, 'load_plugin_textdomain']);
		add_action('admin_enqueue_scripts', [$this, 'enqueue_backend_assets']);
		//add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_assets']);
	}

	public function load_plugin_textdomain() {
		load_plugin_textdomain('vnh_textdomain');
	}

	public function enqueue_backend_assets() {
		if (is_plugin_settings_page()) {
			wp_enqueue_style(PLUGIN_SLUG . '-settings-page');
			wp_enqueue_script(PLUGIN_SLUG . '-settings-page');
		}
	}
}
