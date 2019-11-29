<?php

namespace vnh_namespace\settings_page;

defined('WPINC') || die();

use vnh_namespace\tools\contracts\Initable;
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

	const MENU_SLUG = PLUGIN_SLUG;

	public function __construct() {
		$this->page_title = sprintf(esc_html__('Welcome to %s', 'vnh_textdomain'), PLUGIN_NAME);
		$this->menu_title = esc_html__('vnh_short_name', 'vnh_textdomain');
		$this->sub_menu_title = esc_html__('Settings', 'vnh_textdomain');
	}

	public function init() {
		$this->settings = new Tab_Settings();
		$this->settings->init();
		$this->settings->boot();
	}

	public function boot() {
		add_action('admin_menu', [$this, 'add_menu_page']);
	}

	public function add_menu_page() {
		global $submenu;
		add_menu_page($this->page_title, $this->menu_title, $this->capacity, self::MENU_SLUG, [$this, 'display'], $this->icon_url, 2);
		add_submenu_page(self::MENU_SLUG, $this->page_title, $this->sub_menu_title, $this->capacity, PLUGIN_SLUG, [$this, 'display']);
		$submenu[self::MENU_SLUG][] = [esc_html__('Try Premium Version', 'vnh_textdomain'), $this->capacity, $this->premium_url];
	}

	public function general_info() {
		$html = '<div class="wrap about-wrap theme_info_wrapper">';
		$html .= sprintf('<h1>' . esc_html__('Welcome to %1$s - Version %2$s', 'vnh_textdomain') . '</h1>', PLUGIN_NAME, PLUGIN_VERSION);
		$html .= sprintf('<div class="about-text">%s</div>', PLUGIN_DESCRIPTION);

		return $html;
	}

	public function display() {
		$active_tab = isset($_GET['tab']) ? sanitize_text_field(wp_unslash($_GET['tab'])) : null; //phpcs:disable

		$html = $this->general_info();
		$html .= sprintf('<div class="nav-tab-wrapper">%s</div>', $this->render_tabs_navigation($active_tab));

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

	public function render_tabs_navigation($active_tab) {
		$tabs = sprintf(
			'<a href="%s" class="nav-tab %s">%s</a>',
			add_query_arg(['page' => PLUGIN_SLUG], admin_url('admin.php')),
			$active_tab === null ? 'nav-tab-active' : null,
			__('Settings', 'vnh_textdomain')
		);

		$tabs .= sprintf(
			'<a href="%s" class="nav-tab %s">%s</a>',
			add_query_arg(['page' => PLUGIN_SLUG, 'tab' => 'changelog'], admin_url('admin.php')),
			$active_tab === 'changelog' ? 'nav-tab-active' : null,
			__('Changelog', 'vnh_textdomain')
		);

		$tabs .= sprintf(
			'<a href="%s" class="nav-tab %s">%s</a>',
			add_query_arg(['page' => PLUGIN_SLUG, 'tab' => 'diagnostic'], admin_url('admin.php')),
			$active_tab === 'diagnostic' ? 'nav-tab-active' : null,
			__('Diagnostic Info', 'vnh_textdomain')
		);

		return $tabs;
	}
}
