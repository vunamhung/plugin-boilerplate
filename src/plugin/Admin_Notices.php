<?php

namespace vnh_namespace;

defined('WPINC') || die();

use PAnD;
use vnh_namespace\tools\contracts\Bootable;

class Admin_Notices implements Bootable {
	public function boot() {
		add_action('admin_init', ['PAnD', 'init']);
		add_action('admin_notices', [$this, 'global_note']);
	}

	public function global_note() {
		if (!is_plugin_active('woocommerce/woocommerce.php')) {
			if (!PAnD::is_admin_notice_active('disable-woo-forever')) {
				return;
			}

			printf(
				'<div id="message" data-dismissible="disable-woo-forever" class="notice notice-error is-dismissible"><p>%s</p></div>',
				esc_html__('Please install and activate WooCommerce to use vnh_name plugin.', 'vnh_textdomain')
			);
		}
		if (is_plugin_active('vnh_slug-pro/index.php')) {
			deactivate_plugins('vnh_slug/index.php');
			unset($_GET['activate']);
		}
	}
}
