<?php

namespace vnh_namespace\admin;

defined('ABSPATH') || die();

use vnh\Plugin_Action_Links;
use vnh\Plugin_Row_Meta;
use vnh\contracts\Bootable;
use vnh\contracts\Initable;
use WP_Review_Me;

use function vnh\is_woocommerce_active;

use const vnh_namespace\PLUGIN_BASE;
use const vnh_namespace\PLUGIN_DOCUMENT_URI;
use const vnh_namespace\PLUGIN_SLUG;

class Admin implements Initable, Bootable {
	public $action_link;
	public $row_data;

	public function __construct() {
		$this->action_link = new Plugin_Action_Links(PLUGIN_BASE, PLUGIN_SLUG);
		$this->row_data = new Plugin_Row_Meta(PLUGIN_BASE, PLUGIN_DOCUMENT_URI);
	}

	public function init() {
		new WP_Review_Me(['days_after' => 10, 'type' => 'plugin', 'slug' => PLUGIN_SLUG]);
		$this->action_link->boot();
		$this->row_data->boot();
	}

	public function boot() {
		add_action('admin_notices', [$this, 'global_note']);
	}

	public function global_note() {
		if (!is_woocommerce_active()) {
			printf(
				'<div id="message" class="notice notice-error"><p>%s</p></div>',
				esc_html__('Please install and activate WooCommerce to use vnh_name plugin.', 'vnh_textdomain')
			);
		}
	}
}
