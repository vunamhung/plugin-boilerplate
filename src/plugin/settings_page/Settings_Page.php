<?php

namespace vnh_namespace\settings_page;

defined('WPINC') || die();

use vnh_namespace\tools\contracts\Initable;
use function vnh_namespace\get_plugin_url;
use function vnh_namespace\is_plugin_settings_page;
use const vnh_namespace\PLUGIN_DESCRIPTION;
use const vnh_namespace\PLUGIN_NAME;
use const vnh_namespace\PLUGIN_SLUG;
use const vnh_namespace\PLUGIN_VERSION;
use const vnh_namespace\PREMIUM_URL;

class Settings_Page implements Initable {
	public $page_title;
	public $menu_title;
	public $sub_menu_title;
	public $premium_url = PREMIUM_URL;
	public $icon_url = 'dashicons-carrot';
	public $capacity = 'manage_options';
	public $settings;
	public $plugins_list;

	const MENU_SLUG = PLUGIN_SLUG;

	public function __construct() {
		$this->page_title = sprintf(esc_html__('Welcome to %s', 'vnh_textdomain'), PLUGIN_NAME);
		$this->menu_title = esc_html__('vnh_short_name', 'vnh_textdomain');
		$this->sub_menu_title = esc_html__('Get Started', 'vnh_textdomain');
		$this->plugins_list = [
			[
				'name' => __('GearGag Feed', 'vnh_textdomain'),
				'author' => __('GearGag Team', 'vnh_textdomain'),
				'description' => __('Interdum sagittis facilisis cras feugiat lacus nisi sociosqu fringilla.', 'vnh_textdomain'),
				'link' => 'https://geargag.com',
			],
			[
				'name' => __('GearGag Feed', 'vnh_textdomain'),
				'author' => __('GearGag Team', 'vnh_textdomain'),
				'description' => __('Interdum sagittis facilisis cras feugiat lacus nisi sociosqu fringilla.', 'vnh_textdomain'),
				'link' => 'https://geargag.com',
			],
			[
				'name' => __('GearGag Feed', 'vnh_textdomain'),
				'author' => __('GearGag Team', 'vnh_textdomain'),
				'description' => __('Interdum sagittis facilisis cras feugiat lacus nisi sociosqu fringilla.', 'vnh_textdomain'),
				'link' => 'https://geargag.com',
			],
			[
				'name' => __('GearGag Feed', 'vnh_textdomain'),
				'author' => __('GearGag Team', 'vnh_textdomain'),
				'description' => __('Interdum sagittis facilisis cras feugiat lacus nisi sociosqu fringilla.', 'vnh_textdomain'),
				'link' => 'https://geargag.com',
			],
			[
				'name' => __('GearGag Feed', 'vnh_textdomain'),
				'author' => __('GearGag Team', 'vnh_textdomain'),
				'description' => __('Interdum sagittis facilisis cras feugiat lacus nisi sociosqu fringilla.', 'vnh_textdomain'),
				'link' => 'https://geargag.com',
			],
			[
				'name' => __('GearGag Feed', 'vnh_textdomain'),
				'author' => __('GearGag Team', 'vnh_textdomain'),
				'description' => __('Interdum sagittis facilisis cras feugiat lacus nisi sociosqu fringilla.', 'vnh_textdomain'),
				'link' => 'https://geargag.com',
			],
		];
	}

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
		global $submenu;
		add_menu_page($this->page_title, $this->menu_title, $this->capacity, self::MENU_SLUG, [$this, 'display'], $this->icon_url, 2);
		add_submenu_page(self::MENU_SLUG, $this->page_title, $this->sub_menu_title, $this->capacity, PLUGIN_SLUG, [$this, 'display']);
		add_submenu_page(
			self::MENU_SLUG,
			esc_html__('Our plugins', 'vnh_textdomain'),
			esc_html__('Our plugins', 'vnh_textdomain'),
			$this->capacity,
			'extra',
			[$this, 'extra']
		);
		$submenu[self::MENU_SLUG][] = [esc_html__('Try Premium Version', 'vnh_textdomain'), $this->capacity, $this->premium_url];
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

	public function display() {
		$active_tab = isset($_GET['tab']) ? sanitize_text_field(wp_unslash($_GET['tab'])) : null;

		$html = '<div class="wrapper">';
		$html .= $this->general_info();
		$html .= '<div class="nav-tab-wrapper">';
		$html .= $this->get_nav_link(null, $active_tab, __('Settings', 'vnh_textdomain'));
		$html .= $this->get_nav_link('changelog', $active_tab, __('Changelog', 'vnh_textdomain'));
		$html .= $this->get_nav_link('diagnostic', $active_tab, __('Diagnostic Info', 'vnh_textdomain'));
		$html .= '</div>';

		if ($active_tab === null) {
			$html .= new Tab_Settings();
		} elseif ($active_tab === 'changelog') {
			$html .= new Tab_Changelog();
		} elseif ($active_tab === 'diagnostic') {
			$html .= new Tab_Diagnostic_Info();
		}

		$html .= '</div>';

		echo $html;
	}

	public function extra() {
		$active_tab = isset($_GET['tab']) ? sanitize_text_field(wp_unslash($_GET['tab'])) : null; //phpcs:disable

		$html = '<div class="wrapper">';
		$html .= $this->general_info();
		$html .= '<div class="nav-tab-wrapper">';
		$html .= $this->get_nav_link(null, $active_tab, __('Hot plugins', 'vnh_textdomain'));
		$html .= '</div>';
		$html .= '<div class="plugins-list">';
		foreach ($this->plugins_list as $plugin) {
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

	protected function get_nav_link($tab, $active_tab, $name) {
		return sprintf(
			'<a href="%s" class="nav-tab %s">%s</a>',
			add_query_arg(['page' => PLUGIN_SLUG, 'tab' => $tab], admin_url('admin.php')),
			$active_tab === $tab ? 'nav-tab-active' : null,
			$name
		);
	}
}
