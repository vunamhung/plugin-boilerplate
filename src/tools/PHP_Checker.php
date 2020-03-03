<?php

namespace vnh_namespace\tools;

use vnh\checker\Plugin_Checker;

use const vnh_namespace\MIN_PHP_VERSION;
use const vnh_namespace\PLUGIN_FILE;

class PHP_Checker extends Plugin_Checker {
	public function __construct() {
		$this->file = PLUGIN_FILE;
		$this->require_version = MIN_PHP_VERSION;
		$this->current_version = PHP_VERSION;
		$this->context = 'PHP';
	}
}
