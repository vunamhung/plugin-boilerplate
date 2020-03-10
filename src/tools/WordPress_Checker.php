<?php

namespace vnh_namespace\tools;

use vnh\checker\Plugin_Checker;
use vnh\contracts\Initable;
use const vnh_namespace\MIN_WP_VERSION;
use const vnh_namespace\PLUGIN_FILE;

class WordPress_Checker extends Plugin_Checker implements Initable {
	public function __construct() {
		$this->file = PLUGIN_FILE;
		$this->require_version = MIN_WP_VERSION;
		$this->current_version = get_bloginfo('version');
		$this->context = 'WordPress';
	}

	public function init() {
		$this->show_admin_notice();
		$this->maybe_deactivate_plugin();
		$this->version_too_low();
	}
}
