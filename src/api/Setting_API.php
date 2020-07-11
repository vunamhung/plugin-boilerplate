<?php

namespace vnh_namespace\api;

use vnh\contracts\Bootable;
use vnh_namespace\Settings;
use const vnh_namespace\PLUGIN_SLUG;

class Setting_API implements Bootable {
	public function boot() {
		add_action('rest_api_init', [$this, 'register_routes']);
	}

	/**
	 * @uses update_settings, permissions, get_settings
	 */
	public function register_routes() {
		register_rest_route(PLUGIN_SLUG . '/v1', '/settings', [
			'methods' => 'POST',
			'callback' => [$this, 'update_settings'],
			'permissions_callback' => [$this, 'permissions'],
		]);
		register_rest_route(PLUGIN_SLUG . '/v1', '/settings', [
			'methods' => 'GET',
			'callback' => [$this, 'get_settings'],
			'permissions_callback' => [$this, 'permissions'],
		]);
	}

	public function permissions() {
		return current_user_can('manage_options');
	}

	public function update_settings(\WP_REST_Request $request) {
		$settings = $request->get_body();
		$settings = json_decode($settings, true);

		Settings::save_settings($settings);

		return rest_ensure_response(Settings::get_settings())->set_status(201);
	}

	public function get_settings(\WP_REST_Request $request) {
		return rest_ensure_response(Settings::get_settings());
	}
}
