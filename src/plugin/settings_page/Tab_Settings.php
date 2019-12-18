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
				'fields' => [
					[
						'id' => 'enable',
						'name' => __('Toggle', 'vnh_textdomain'),
						'description' => __('On/off global', 'vnh_textdomain'),
						'type' => 'toggle',
					],
					[
						'id' => 'text',
						'name' => __('Text', 'vnh_textdomain'),
						'description' => __('On/off global', 'vnh_textdomain'),
						'type' => 'text',
						'custom_attributes' => [
							'placeholder' => __('Enter your text here', 'vnh_textdomain'),
						],
					],
					[
						'id' => 'textarea',
						'name' => __('Textarea', 'vnh_textdomain'),
						'description' => __('On/off global', 'vnh_textdomain'),
						'type' => 'textarea',
						'custom_attributes' => [
							'placeholder' => __('Enter your text here', 'vnh_textdomain'),
						],
					],
					[
						'id' => 'select',
						'name' => __('Select', 'vnh_textdomain'),
						'description' => __('On/off global', 'vnh_textdomain'),
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
						'description' => __('On/off global', 'vnh_textdomain'),
						'type' => 'number',
						'options' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						],
						'custom_attributes' => [
							'placeholder' => __('Enter your number here', 'vnh_textdomain'),
						],
					],
					[
						'id' => 'repeater',
						'name' => __('Repeater', 'vnh_textdomain'),
						'description' => __('On/off global', 'vnh_textdomain'),
						'type' => 'repeater',
						'options' => [
							'add_button' => __('Add Row', 'vnh_textdomain'),
							'remove_button' => __('Remove', 'vnh_textdomain'),
						],
						'children' => [
							'condition' => [
								'title' => __('Condition', 'vnh_textdomain'),
								'type' => 'select',
								'width' => 40,
								'description' => __('Condition vs. destination', 'vnh_textdomain'),
								'options' => [
									'' => __('None', 'vnh_textdomain'),
									'items' => __('Item count', 'vnh_textdomain'),
								],
							],
							'break' => [
								'title' => __('Break', 'vnh_textdomain'),
								'type' => 'checkbox',
								'width' => 9,
								'description' => __(
									'Break at this point. For per-order rates, no rates other than this will be offered. For calculated rates, this will stop any further rates being matched.',
									'vnh_textdomain'
								),
							],
							'per_item' => [
								'title' => __('Item Cost', 'vnh_textdomain'),
								'type' => 'number',
								'width' => 12,
								'description' => __('Cost per item.', 'vnh_textdomain'),
								'custom_attributes' => [
									'min' => '0',
									'step' => '0.01',
								],
							],
							'shipping_label' => [
								'title' => __('Label', 'vnh_textdomain'),
								'type' => 'text',
								'width' => 30,
								'description' => __('Label for the shipping method which the user will be presented.', 'vnh_textdomain'),
							],
						],
					],
				],
			],
		];
	}
}
