<?php

namespace vnh_namespace\admin;

use vnh\contracts\Bootable;
use vnh\Our_Plugins;
use vnh\System_Status;

use const vnh_namespace\MENU_SLUG;
use const vnh_namespace\PLUGIN_SLUG;
use const vnh_namespace\PLUGINS_LIST_FILE;
use const vnh_namespace\SYSTEM_STATUS;

class Admin_Menu implements Bootable {
	public $capacity = 'manage_options';

	public function boot() {
		add_action('admin_menu', [$this, 'add_menus']);
	}

	public function add_menus() {
		global $submenu;

		$menu_not_exist = empty($submenu['index.php'][11]);

		if ($menu_not_exist) {
			add_submenu_page(
				'index.php',
				esc_html__('GearGag Plugins', 'vnh_textdomain'),
				esc_html__('GearGag Plugins', 'vnh_textdomain'),
				$this->capacity,
				MENU_SLUG,
				[$this, 'our_plugins'],
				11
			);

			add_submenu_page(
				'index.php',
				esc_html__('System Status', 'vnh_textdomain'),
				esc_html__('System Status', 'vnh_textdomain'),
				$this->capacity,
				SYSTEM_STATUS,
				[$this, 'system_status'],
				12
			);
		}
	}

	public function our_plugins() {
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
		$html .= new Our_Plugins(PLUGINS_LIST_FILE, PLUGIN_SLUG . '-plugin-list');
		$html .= '</div>';

		echo $html;
	}

	public function system_status() {
		$html = '<div class="wrapper">';
		$html .= '<h1>' . __('Your Website <strong>Status</strong>', 'vnh_textdomain') . '</h1>';
		$html .= '<p>' . __('Get all info about your system here', 'vnh_textdomain') . '</p>';
		$html .= new System_Status([
			'menu_slug' => SYSTEM_STATUS,
		]);
		$html .= '</div>';

		echo wp_kses($html, 'default');
	}
}
