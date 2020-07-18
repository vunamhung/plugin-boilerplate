<?php

namespace vnh_namespace\api;

use vnh\api\Route;
use vnh_namespace\Settings;
use WP_REST_Server;
use const vnh_namespace\PLUGIN_SLUG;

class Setting_API extends Route {
	public function get_namespace() {
		return PLUGIN_SLUG;
	}

	public function get_path() {
		return '/settings';
	}

	public function get_args() {
		return [
			[
				'methods' => WP_REST_Server::CREATABLE,
				'callback' => [$this, 'get_response'],
			],
			[
				'methods' => WP_REST_Server::READABLE,
				'callback' => [$this, 'get_response'],
			],
		];
	}

	public function get_route_post_response($request) {
		$settings = $request->get_body();
		$settings = json_decode($settings, true);

		Settings::save_settings($settings);

		return rest_ensure_response(Settings::get_settings())->set_status(201);
	}

	public function get_route_response($request) {
		return rest_ensure_response(Settings::get_settings());
	}
}
