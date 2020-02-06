<?php

namespace vnh_namespace\settings_page;

defined('ABSPATH') || die();

use vnh_namespace\admin\Settings;
use vnh_namespace\tools\contracts\Bootable;

use vnh_namespace\tools\contracts\Initable;

use function vnh_namespace\is_plugin_settings_page;

use const vnh_namespace\MENU_SLUG;
use const vnh_namespace\PLUGIN_DESCRIPTION;
use const vnh_namespace\PLUGIN_NAME;
use const vnh_namespace\PLUGIN_SLUG;
use const vnh_namespace\PLUGIN_VERSION;

class Settings_Page implements Initable, Bootable {
	public $icon_url = 'dashicons-carrot';
	public $capacity = 'manage_options';
	public $settings;

	public function init() {
		$cmb2 = new CMB2_Settings_Page();
		$cmb2->boot();
	}

	public function boot() {
		add_action('init', [$this, 'init_settings']);
		add_filter('admin_body_class', [$this, 'body_class'], 10, 2);
		add_action('admin_menu', [$this, 'add_menu_page']);
	}

	public function init_settings() {
		$this->settings = new Settings();
		$this->settings->init();
		$this->settings->boot();
	}

	public function body_class($classes) {
		if (is_plugin_settings_page()) {
			$classes .= 'settings-page';
		}

		return $classes;
	}

	public function add_menu_page() {
		global $submenu;

		$geargag_menu_not_exist = empty($submenu['index.php'][11]);

		if ($geargag_menu_not_exist) {
			add_submenu_page(
				'index.php',
				esc_html__('GearGag Plugins', 'vnh_textdomain'),
				esc_html__('GearGag Plugins', 'vnh_textdomain'),
				$this->capacity,
				MENU_SLUG,
				[$this, 'our_plugins_page'],
				11
			);

			add_submenu_page(
				'index.php',
				esc_html__('System Status', 'vnh_textdomain'),
				esc_html__('System Status', 'vnh_textdomain'),
				$this->capacity,
				MENU_SLUG . '_diagnostic',
				[$this, 'diagnostic_page'],
				12
			);
		}

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

	public function our_plugins_page() {
		$html = '<div class="wrapper">';
		$html .= '<h1>' . __('Welcome to <strong>GearGag Plugins Ecosystem</strong>', 'vnh_textdomain') . '</h1>';
		$html .= '<p>';
		$html .= sprintf(
			__(
				'Thanks for choosing our plugins for your website! If you are satisfied, please reward it a full five-star %s rating.',
				'vnh_textdomain'
			),
			'<span style="color:#ffb900">★★★★★</span>'
		);
		$html .= '</p>';
		$html .= new Our_Plugins_Page();
		$html .= '</div>';

		echo $html;
	}

	public function diagnostic_page() {
		$html = '<div class="wrapper">';
		$html .= '<h1>' . __('Your Website <strong>Status</strong>', 'vnh_textdomain') . '</h1>';
		$html .= '<p>' . __('Get all info about your system here', 'vnh_textdomain') . '</p>';
		$html .= new Diagnostic_Page();
		$html .= '</div>';

		echo $html;
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
