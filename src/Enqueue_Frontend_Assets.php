<?php

namespace vnh_namespace;

use vnh\contracts\Enqueueable;
use vnh\Register_Assets;

class Enqueue_Frontend_Assets extends Register_Assets implements Enqueueable {
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
		add_action('wp_enqueue_scripts', [$this, 'enqueue']);
	}

	public function enqueue() {
		wp_enqueue_script(PLUGIN_SLUG);
	}
}
