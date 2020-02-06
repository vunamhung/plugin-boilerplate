<?php

namespace vnh_namespace\tools;

use vnh_namespace\tools\contracts\Bootable;

use function vnh_namespace\get_plugin_url;

use const vnh_namespace\PLUGIN_SLUG;

class Config_CMB2 implements Bootable {
	public function boot() {
		add_filter('cmb2_meta_box_url', [$this, 'url']);
	}

	public function url() {
		return get_plugin_url('vendor/cmb2/cmb2');
	}
}
