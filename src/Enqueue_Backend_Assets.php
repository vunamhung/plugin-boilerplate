<?php

namespace vnh_namespace;

use vnh\contracts\Enqueueable;
use vnh\Register_Assets;

class Enqueue_Backend_Assets extends Register_Assets implements Enqueueable {
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
		add_action('admin_enqueue_scripts', [$this, 'enqueue']);
	}

	public function enqueue() {
		if (is_plugin_settings_page()) {
			wp_enqueue_style(handle('settings-page'));
		}
	}
}
