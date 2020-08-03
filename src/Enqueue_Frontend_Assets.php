<?php

namespace vnh_namespace;

use vnh\contracts\Enqueueable;
use vnh\Register_Assets;

class Enqueue_Frontend_Assets extends Register_Assets implements Enqueueable {
	public function __construct() {
		$this->scripts = [
			PLUGIN_SLUG => [
				'src' => get_plugin_url('build/frontend.js'),
				'deps' => ['wp-element'],
				'localize_script' => [
					'apiUrl' => esc_url_raw(get_rest_url()),
					'wcStoreApiNonce' => esc_js(wp_create_nonce('wc_store_api')),
					'wcCartUrl' => get_permalink(get_option('woocommerce_cart_page_id')),
					'wcCheckoutUrl' => get_permalink(get_option('woocommerce_checkout_page_id')),
					'plugin' => [
						'settings' => Settings::get_settings(),
					],
				],
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
