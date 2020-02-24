<?php

namespace vnh_namespace\admin;

use vnh\contracts\Bootable;

use function vnh\is_woocommerce_active;

class Activate_Woo_Notice implements Bootable {
	public function boot() {
		add_action('admin_notices', [$this, 'notice']);
	}

	public function notice() {
		if (is_woocommerce_active()) {
			return;
		}

		printf(
			'<div id="message" class="notice notice-error"><p>%s</p></div>',
			esc_html__('Please install and activate WooCommerce to use vnh_name plugin.', 'vnh_textdomain')
		);
	}
}
