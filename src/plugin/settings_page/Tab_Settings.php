<?php

namespace vnh_namespace\settings_page;

use vnh_namespace\tools\Register_Settings;

class Tab_Settings extends Register_Settings {
	public $prefix = 'vnh_prefix_settings';
	public $default_settings = [
		'enable' => true,
	];

	public function register_setting_fields() {
		return [
			'head' => [
				'title' => __('General', 'vnh_textdomain'),
				'description' => __('General settings', 'vnh_textdomain'),
				'fields' => [
					[
						'id' => 'enable',
						'name' => __('Enable', 'vnh_textdomain'),
						'tooltip' => __('On/off global', 'vnh_textdomain'),
						'type' => 'toggle',
					],
				],
			],
		];
	}
}
