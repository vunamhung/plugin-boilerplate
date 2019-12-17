<?php

namespace vnh_namespace\settings_page;

defined('WPINC') || die();

use vnh_namespace\tools\Register_Settings;

class Tab_Settings extends Register_Settings {
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
						'name' => __('Toggle', 'vnh_textdomain'),
						'tooltip' => __('On/off global', 'vnh_textdomain'),
						'type' => 'toggle',
					],
					[
						'id' => 'text',
						'name' => __('Text', 'vnh_textdomain'),
						'tooltip' => __('On/off global', 'vnh_textdomain'),
						'placeholder' => __('Enter your text here', 'vnh_textdomain'),
						'type' => 'text',
					],
					[
						'id' => 'textarea',
						'name' => __('Textarea', 'vnh_textdomain'),
						'tooltip' => __('On/off global', 'vnh_textdomain'),
						'placeholder' => __('Enter your text here', 'vnh_textdomain'),
						'type' => 'textarea',
					],
					[
						'id' => 'select',
						'name' => __('Select', 'vnh_textdomain'),
						'tooltip' => __('On/off global', 'vnh_textdomain'),
						'type' => 'select',
						'options' => [
							'option_1' => __('Option 1', 'vnh_textdomain'),
							'option_2' => __('Option 2', 'vnh_textdomain'),
							'option_3' => __('Option 3', 'vnh_textdomain'),
						],
					],
					[
						'id' => 'number',
						'name' => __('Number', 'vnh_textdomain'),
						'tooltip' => __('On/off global', 'vnh_textdomain'),
						'placeholder' => __('Enter your number here', 'vnh_textdomain'),
						'type' => 'number',
						'options' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						],
					],
					[
						'id' => 'repeater',
						'name' => __('Repeater', 'vnh_textdomain'),
						'tooltip' => __('On/off global', 'vnh_textdomain'),
						'type' => 'repeater',
						'options' => [
							'add_button' => __('Add Row', 'vnh_textdomain'),
							'remove_button' => __('Remove', 'vnh_textdomain'),
						],
						'children' => [
							[
								'id' => 'number',
								'name' => __('Number', 'vnh_textdomain'),
								'type' => 'number',
							],
							[
								'id' => 'text',
								'name' => __('Text', 'vnh_textdomain'),
								'type' => 'text',
							],
						],
					],
				],
			],
		];
	}
}
