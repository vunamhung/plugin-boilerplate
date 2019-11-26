<?php

namespace vnh_namespace;

use vnh_namespace\tools\contracts\Bootable;

class Admin_Notices implements Bootable {
	public function boot() {
		add_action('admin_notices', [$this, 'global_note']);
	}

	public function global_note() {
		if (!is_plugin_active('woocommerce/woocommerce.php')) {
			printf(
				'<div id="message" class="error"><p>%s</p></div>',
				esc_html__('Please install and activate WooCommerce to use vnh_title plugin.', 'vnh_textdomain')
			);
		}
		if (is_plugin_active('vnh_name-pro/index.php')) {
			deactivate_plugins(PLUGIN_BASE);
			unset($_GET['activate']);
		}
	}
}
