<?php

namespace vnh_namespace;

use vnh\contracts\Bootable;

class Settings_Page implements Bootable {
	public $icon_url = 'dashicons-carrot';
	public $capacity = 'manage_options';
	public $settings;

	public function boot() {
		add_filter('admin_body_class', [$this, 'body_class'], 10, 2);
		add_action('admin_menu', [$this, 'add_menu_page']);
	}

	public function body_class($classes) {
		if (is_plugin_settings_page()) {
			$classes .= 'settings-page';
		}

		return $classes;
	}

	public function add_menu_page() {
		add_menu_page(
			esc_html__('vnh_short_name', 'vnh_textdomain'),
			esc_html__('vnh_short_name', 'vnh_textdomain'),
			$this->capacity,
			PLUGIN_SLUG,
			[$this, 'setting_page'],
			$this->icon_url,
			2
		);

		add_submenu_page(
			PLUGIN_SLUG,
			esc_html__('Getting Started', 'vnh_textdomain'),
			esc_html__('Getting Started', 'vnh_textdomain'),
			$this->capacity,
			PLUGIN_SLUG,
			[$this, 'setting_page']
		);
	}

	public function setting_page() {
		echo '<div class="wrapper"><div id="plugin"></div></div>';
	}
}
