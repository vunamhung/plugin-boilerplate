<?php

namespace vnh_namespace\admin;

defined('ABSPATH') || die();

use vnh\Plugin_Action_Links;
use vnh\Plugin_Row_Meta;
use vnh\contracts\Initable;
use WP_Review_Me;

use const vnh_namespace\PLUGIN_BASE;
use const vnh_namespace\PLUGIN_DOCUMENT_URI;
use const vnh_namespace\PLUGIN_SLUG;

class Admin implements Initable {
	public $action_link;
	public $row_data;
	public $activate_woo;

	public function __construct() {
		$this->action_link = new Plugin_Action_Links(PLUGIN_BASE, PLUGIN_SLUG);
		$this->row_data = new Plugin_Row_Meta(PLUGIN_BASE, PLUGIN_DOCUMENT_URI);
		$this->activate_woo = new Activate_Woo_Notice();
	}

	public function init() {
		new WP_Review_Me(['days_after' => 10, 'type' => 'plugin', 'slug' => PLUGIN_SLUG]);
		$this->action_link->boot();
		$this->row_data->boot();
		$this->activate_woo->boot();
	}
}
