<?php

namespace vnh_namespace\api;

use vnh\REST_Controller;
use vnh_namespace\Settings;
use WP_REST_Server;
use const vnh_namespace\PLUGIN_SLUG;

class Setting_API extends REST_Controller {
	public $prefix = PLUGIN_SLUG;
	public $route = '/settings';

	/**
	 * @uses update_settings, permissions, get_settings
	 */
	public function register_routes() {
		register_rest_route($this->namespace, $this->route, [
			'methods' => WP_REST_Server::CREATABLE,
			'callback' => [$this, 'update_settings'],
			'permissions_callback' => [$this, 'permissions'],
		]);
		register_rest_route($this->namespace, $this->route, [
			'methods' => WP_REST_Server::READABLE,
			'callback' => [$this, 'get_settings'],
			'permissions_callback' => [$this, 'permissions'],
		]);
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

	protected function permissions() {
		return current_user_can('manage_options');
	}
}
