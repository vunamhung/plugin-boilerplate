<?php

namespace vnh_namespace\tools;

use vnh\checker\Plugin_Checker;
use vnh\contracts\Initable;
use const vnh_namespace\MIN_WC_VERSION;
use const vnh_namespace\PLUGIN_FILE;

class WooCommerce_Checker extends Plugin_Checker implements Initable {
	public function __construct() {
		$this->file = PLUGIN_FILE;
		$this->require_version = MIN_WC_VERSION;
		$this->current_version = \WC_VERSION;
		$this->context = 'WooCommerce';
	}

	public function init() {
		$this->show_admin_notice();
		$this->maybe_deactivate_plugin();
		$this->version_too_low();
	}
}
