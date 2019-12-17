<?php

namespace vnh_namespace\admin;

defined('WPINC') || die();

use vnh_namespace\tools\contracts\Bootable;
use vnh_namespace\tools\contracts\Initable;
use WP_Review_Me;
use function vnh_namespace\is_woocommerce_active;
use const vnh_namespace\PLUGIN_BASE;
use const vnh_namespace\PLUGIN_SLUG;

class Notices implements Initable, Bootable {
	public function init() {
		new WP_Review_Me(['days_after' => 10, 'type' => 'plugin', 'slug' => PLUGIN_SLUG]);
	}

	public function boot() {
		add_action('admin_notices', [$this, 'global_note']);
	}

	public function global_note() {
		if (!is_woocommerce_active()) {
			printf(
				'<div id="message" class="notice notice-error is-dismissible"><p>%s</p></div>',
				esc_html__('Please install and activate WooCommerce to use vnh_name plugin.', 'vnh_textdomain')
			);
		}

		if (is_plugin_active('vnh_slug-pro/index.php')) {
			deactivate_plugins(PLUGIN_BASE);
			unset($_GET['activate']);
		}
	}
}
