<?php

namespace vnh_namespace\tools;

use vnh\checker\Plugin_Checker;

use const vnh_namespace\MIN_WP_VERSION;
use const vnh_namespace\PLUGIN_FILE;

class WordPress_Checker extends Plugin_Checker {
	public function __construct() {
		global $wp_version;
		$this->file = PLUGIN_FILE;
		$this->require_version = MIN_WP_VERSION;
		$this->current_version = $wp_version;
		$this->context = 'WordPress';
	}
}
