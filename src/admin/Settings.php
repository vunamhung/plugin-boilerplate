<?php

namespace vnh_namespace\admin;

defined('ABSPATH') || die();

use vnh\Register_Settings;

use function vnh\all_currencies;

use const vnh_namespace\PLUGIN_SLUG;

class Settings extends Register_Settings {
	public function __construct() {
		$this->prefix = PLUGIN_SLUG;

		$this->default_settings = [
			'enable' => true,
			'currency_options' => [
				[
					'currency' => get_option('woocommerce_currency'),
					'rate' => 1,
					'decimals' => get_option('woocommerce_price_num_decimals'),
				],
			],
		];

		$this->setting_fields = [
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
						'id' => 'currency_options',
						'name' => __('Currency Options', 'vnh_textdomain'),
						'type' => 'repeater',
						'options' => [
							'add_button' => __('Add Currency', 'vnh_textdomain'),
							'remove_button' => __('Remove', 'vnh_textdomain'),
							'action_buttons' => [
								[
									'text' => __('Update Rate', 'vnh_textdomain'),
									'custom_attributes' => [
										'class' => 'button button-secondary update-rate',
									],
								],
							],
						],
						'children' => [
							'currency' => [
								'name' => __('Currency', 'vnh_textdomain'),
								'type' => 'select',
								'width' => 37,
								'options' => all_currencies(),
							],
							'rate' => [
								'name' => __('Rate + Fee', 'vnh_textdomain'),
								'type' => 'currency_rate',
								'width' => 20,
								'description' => __('Rate plus exchange free rate', 'vnh_textdomain'),
								'custom_attributes' => [
									'min' => '0',
									'step' => '0.01',
								],
							],
							'decimals' => [
								'name' => __('Decimals', 'vnh_textdomain'),
								'type' => 'number',
								'width' => 11,
								'description' => __('Number of decimals', 'vnh_textdomain'),
								'custom_attributes' => [
									'min' => '0',
									'max' => '5',
									'step' => '1',
								],
							],
							'custom_symbol' => [
								'name' => __('Custom Symbol', 'vnh_textdomain'),
								'type' => 'text',
								'width' => 13,
								'custom_attributes' => [
									'placeholder' => __('eg: CAD $', 'vnh_textdomain'),
								],
							],
						],
					],
				],
			],
		];
	}
}
