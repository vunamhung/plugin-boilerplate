<?php

namespace vnh_namespace\tools;

use vnh\checker\Plugin_Checker;
use vnh\contracts\Initable;
use function vnh\is_woo;
use const vnh_namespace\PLUGIN_FILE;
use const vnh_namespace\PLUGIN_NAME;

class WooCommerce_Required extends Plugin_Checker implements Initable {
	public function __construct() {
		$this->file = PLUGIN_FILE;
	}

	public function init() {
		$this->show_admin_notice();
		$this->maybe_deactivate_plugin();
	}

	public function disabled_notice() {
		$html = '<div class="updated" style="border-left: 4px solid #ffba00;"><p>';
		$html .= sprintf(esc_html__('%s requires WooCommerce to run. Please install and active it.', 'vnh_textdomain'), 'vnh_name', PLUGIN_NAME);
		$html .= '</p></div>';

		echo $html;
	}

	public function is_not_compatible(): bool {
		return !is_woo();
	}
}
