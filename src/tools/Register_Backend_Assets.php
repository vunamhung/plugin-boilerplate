<?php

namespace vnh_namespace\tools;

use vnh\Register_Assets;
use function vnh_namespace\get_plugin_url;
use function vnh_namespace\handle;

class Register_Backend_Assets extends Register_Assets {
	public $scripts;
	public $styles;

	public function __construct() {
		$this->scripts = [
			handle('settings-page') => [
				'src' => get_plugin_url('assets/js/dist/settings_page.js'),
				'deps' => ['jquery', 'jquery-form', 'jquery-ui-sortable'],
				'localize_script' => [
					'settingsPage' => [
						'saveMessage' => esc_html__('Settings Saved Successfully', 'vnh_textdomain'),
					],
				],
			],
		];
		$this->styles = [
			handle('settings-page') => [
				'src' => get_plugin_url('assets/css/settings_page.css'),
			],
		];
	}

	public function boot() {
		add_action('admin_enqueue_scripts', [$this, 'register_scripts']);
		add_action('admin_enqueue_scripts', [$this, 'register_styles']);
	}
}
