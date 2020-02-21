<?php

namespace vnh_namespace;

use vnh\contracts\Bootable;

class Register_Widgets implements Bootable {
	public $registry = [];

	public function boot() {
		add_action('widgets_init', [$this, 'register_widgets']);
	}

	public function register_widgets() {
		foreach ($this->registry as $widget) {
			register_widget($widget);
		}
	}
}
