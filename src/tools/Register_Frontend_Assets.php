<?php

namespace vnh_namespace\tools;

use vnh\Register_Assets;
use function vnh_namespace\get_plugin_url;
use const vnh_namespace\PLUGIN_SLUG;

class Register_Frontend_Assets extends Register_Assets {
	public $scripts;
	public $styles;

	public function __construct() {
		$this->scripts = [
			PLUGIN_SLUG => [
				'src' => get_plugin_url('assets/js/dist/frontend.js'),
				'deps' => ['jquery'],
			],
		];
	}

	public function boot() {
		add_action('wp_enqueue_scripts', [$this, 'register_scripts']);
		add_action('wp_enqueue_scripts', [$this, 'register_styles']);
	}
}
