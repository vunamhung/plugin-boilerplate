<?php

namespace vnh_namespace\tools;

use vnh\contracts\Bootable;

use function vnh_namespace\get_plugin_url;

class Config_CMB2 implements Bootable {
	public function boot() {
		add_filter('cmb2_meta_box_url', [$this, 'meta_box_url']);
	}

	public function meta_box_url() {
		return get_plugin_url('vendor/cmb2/cmb2');
	}
}
