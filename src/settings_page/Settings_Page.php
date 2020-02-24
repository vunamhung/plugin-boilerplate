<?php

namespace vnh_namespace\settings_page;

defined('ABSPATH') || die();

use vnh_namespace\admin\Settings;
use vnh\contracts\Bootable;

use function vnh_namespace\is_plugin_settings_page;

use const vnh_namespace\PLUGIN_DESCRIPTION;
use const vnh_namespace\PLUGIN_NAME;
use const vnh_namespace\PLUGIN_SLUG;
use const vnh_namespace\PLUGIN_VERSION;

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

		add_submenu_page(
			PLUGIN_SLUG,
			esc_html__('Changelog', 'vnh_textdomain'),
			esc_html__('Changelog', 'vnh_textdomain'),
			$this->capacity,
			PLUGIN_SLUG . '_changelog',
			[$this, 'changelog_page']
		);
	}

	public function setting_page() {
		$html = '<div class="wrapper">';
		$html .= sprintf(
			'<h1>' . __('Getting Started with <strong>%1$s</strong> <code>%2$s</code>', 'vnh_textdomain') . '</h1>',
			PLUGIN_NAME,
			PLUGIN_VERSION
		);
		$html .= sprintf('<div class="about-text">%s</div>', PLUGIN_DESCRIPTION);
		$html .= new Settings();
		$html .= '</div>';

		echo $html;
	}

	public function changelog_page() {
		$html = '<div class="wrapper">';
		$html .= sprintf('<h1>' . __('Changelog of <strong>%s</strong>', 'vnh_textdomain') . '</h1>', PLUGIN_NAME);
		$html .= '<p>' . __('Get all info about changelog here', 'vnh_textdomain') . '</p>';
		$html .= new Changelog_Page();
		$html .= '</div>';

		echo $html;
	}
}
