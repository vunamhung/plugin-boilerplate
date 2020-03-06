<?php

namespace vnh_namespace\admin;

use vnh\contracts\Bootable;
use vnh\Our_Plugins;
use vnh_namespace\Container;
use const vnh_namespace\MENU_SLUG;

class Our_Plugins_Menu implements Bootable {
	public $capacity = 'manage_options';

	public function boot() {
		add_action('admin_menu', [$this, 'add_menus']);
	}

	public function add_menus() {
		global $submenu;

		if (empty($submenu['index.php'][11])) {
			add_submenu_page(
				'index.php',
				esc_html__('GearGag Plugins', 'vnh_textdomain'),
				esc_html__('GearGag Plugins', 'vnh_textdomain'),
				$this->capacity,
				MENU_SLUG,
				[$this, 'our_plugins'],
				11
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
		$html .= Container::instance()->services->get(Our_Plugins::class);
		$html .= '</div>';

		echo $html;
	}
}
