<?php

namespace vnh_namespace\settings_page;

defined('WPINC') || die();

use vnh_namespace\tools\contracts\Bootable;
use vnh_namespace\tools\contracts\Initable;
use WP_Error;
use function vnh_namespace\get_plugin_url;
use function vnh_namespace\is_plugin_settings_page;
use const vnh_namespace\PLUGIN_DESCRIPTION;
use const vnh_namespace\PLUGIN_NAME;
use const vnh_namespace\PLUGIN_SLUG;
use const vnh_namespace\PLUGIN_VERSION;
use const vnh_namespace\PLUGINS_LIST_FILE;
use const vnh_namespace\PREMIUM_URL;

class Settings_Page implements Initable, Bootable {
	public $premium_url = PREMIUM_URL;
	public $icon_url = 'dashicons-carrot';
	public $capacity = 'manage_options';
	public $settings;

	const MENU_SLUG = 'geargag_plugins';
	const PLUGIN_PAGE_SLUG = self::MENU_SLUG . '_' . PLUGIN_SLUG;

	public function init() {
		$this->settings = new Tab_Settings();
		$this->settings->init();
		$this->settings->boot();
	}

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
		global $menu;
		$geargag_menu_exist = false;
		foreach ($menu as $item) {
			if ($item[2] === self::MENU_SLUG) {
				$geargag_menu_exist = true;
			}
		}
		if (!$geargag_menu_exist) {
			add_menu_page(
				esc_html__('GearGag Plugins', 'vnh_textdomain'),
				esc_html__('GearGag', 'vnh_textdomain'),
				$this->capacity,
				self::MENU_SLUG,
				[$this, 'our_plugins'],
				$this->icon_url,
				2
			);
			add_submenu_page(
				self::MENU_SLUG,
				esc_html__('Our Plugins', 'vnh_textdomain'),
				esc_html__('Our Plugins', 'vnh_textdomain'),
				$this->capacity,
				self::MENU_SLUG,
				[$this, 'our_plugins']
			);
			add_submenu_page(
				self::MENU_SLUG,
				esc_html__('System Status', 'vnh_textdomain'),
				esc_html__('System Status', 'vnh_textdomain'),
				$this->capacity,
				self::MENU_SLUG . '_diagnostic',
				[$this, 'diagnostic_page']
			);
		}

		add_submenu_page(
			self::MENU_SLUG,
			esc_html__('vnh_short_name', 'vnh_textdomain'),
			esc_html__('vnh_short_name', 'vnh_textdomain'),
			$this->capacity,
			self::PLUGIN_PAGE_SLUG,
			[$this, 'plugin_page']
		);
	}

	public function general_info() {
		$html = sprintf(
			'<h1>' . __('Getting Started with <strong>%1$s</strong> <code>%2$s</code>', 'vnh_textdomain') . '</h1>',
			PLUGIN_NAME,
			PLUGIN_VERSION
		);
		$html .= sprintf('<div class="about-text">%s</div>', PLUGIN_DESCRIPTION);

		return $html;
	}

	public function plugin_page() {
		$active_tab = isset($_GET['tab']) ? sanitize_text_field(wp_unslash($_GET['tab'])) : null;

		$html = '<div class="wrapper">';
		$html .= $this->general_info();
		$html .= '<div class="nav-tab-wrapper">';
		$html .= $this->get_nav_link(null, $active_tab, __('Settings', 'vnh_textdomain'));
		$html .= $this->get_nav_link('changelog', $active_tab, __('Changelog', 'vnh_textdomain'));
		$html .= sprintf('<a href="%s" target="_blank" class="nav-tab">%s</a>', $this->premium_url, __('Premium Version', 'vnh_textdomain'));
		$html .= '</div>';

		if ($active_tab === null) {
			$html .= new Tab_Settings();
		} elseif ($active_tab === 'changelog') {
			$html .= new Tab_Changelog();
		}

		$html .= '</div>';

		echo $html;
	}

	public function diagnostic_page() {
		$active_tab = isset($_GET['tab']) ? sanitize_text_field(wp_unslash($_GET['tab'])) : null;

		$html = '<div class="wrapper">';
		$html .= '<h1>Your Website <strong>Status</strong></h1>';
		$html .= '<p>Get all info about your system here</p>';
		$html .= '<div class="nav-tab-wrapper">';
		$html .= $this->get_nav_link(null, $active_tab, __('Diagnostic Info', 'vnh_textdomain'));
		$html .= '</div>';

		if ($active_tab === null) {
			$html .= new Tab_Diagnostic_Info();
		}

		$html .= '</div>';

		echo $html;
	}

	public function our_plugins() {
		$active_tab = isset($_GET['tab']) ? sanitize_text_field(wp_unslash($_GET['tab'])) : null; //phpcs:disable

		$html = '<div class="wrapper">';
		$html .= '<h1>Welcome to <strong>GearGag Plugins Ecosystem</strong></h1>';
		$html .=
			'<p>Thanks for choosing our plugins for your website! If you are satisfied, please reward it a full five-star <span style="color:#ffb900">★★★★★</span> rating.</p>';
		$html .= '<div class="nav-tab-wrapper">';
		$html .= $this->get_nav_link(null, $active_tab, __('Hot plugins', 'vnh_textdomain'));
		$html .= '</div>';
		$html .= '<div class="plugins-list">';
		foreach ($this->get_plugins_list() as $plugin) {
			$html .= sprintf(
				'<div class="card">
                  <div class="card-image"><img class="img-responsive" src="%s" alt="%s"></div>
                  <div class="card-header">
                    <a href="%s" target="_blank"><button class="btn btn-primary float-right">%s</button></a>
                    <div class="card-title h5">%s</div>
                    <div class="card-subtitle text-gray">%s</div>
                  </div>
                  <div class="card-body">%s</div>
                </div>',
				!empty($plugin['img']) ? $plugin['img'] : get_plugin_url('assets/images/plugin-banner.svg'),
				$plugin['name'],
				$plugin['link'],
				__('More info', 'vnh_textdomain'),
				$plugin['name'],
				__('by ', 'vnh_textdomain') . $plugin['author'],
				$plugin['description']
			);
		}
		$html .= '</div>';
		$html .= '</div>';

		echo $html;
	}

	protected function get_plugins_list() {
		$cached_plugins_list = get_transient('geargag_plugins_list');

		if (!is_wp_error($cached_plugins_list) && !empty($cached_plugins_list)) {
			return $cached_plugins_list;
		}

		$remote = wp_remote_get(PLUGINS_LIST_FILE);

		if (!$remote) {
			return new WP_Error('failed_to_connect', __('Failed to connect to the server', 'vnh_textdomain'));
		}

		if (is_wp_error($remote)) {
			return $remote;
		}

		if (wp_remote_retrieve_response_code($remote) !== 200) {
			return new WP_Error('invalid_status', __('Invalid Status code.', 'vnh_textdomain'), compact('remote'));
		}

		$response = wp_remote_retrieve_body($remote);

		$response = json_decode($response, true);

		set_transient('geargag_plugins_list', $response, DAY_IN_SECONDS * 7);

		return $response;
	}

	protected function get_nav_link($tab, $active_tab, $name) {
		return sprintf(
			'<a href="%s" class="nav-tab %s">%s</a>',
			add_query_arg(['page' => self::PLUGIN_PAGE_SLUG, 'tab' => $tab], admin_url('admin.php')),
			$active_tab === $tab ? 'nav-tab-active' : null,
			$name
		);
	}
}
