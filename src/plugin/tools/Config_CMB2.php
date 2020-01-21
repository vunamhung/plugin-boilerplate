<?php

namespace vnh_namespace\tools;

use vnh_namespace\tools\contracts\Bootable;

use function vnh_namespace\get_plugin_url;

use const vnh_namespace\PLUGIN_SLUG;

class Config_CMB2 implements Bootable {
	public $tab;

	public function boot() {
		add_filter('cmb2_meta_box_url', [$this, 'url']);
		add_action('cmb2_admin_init', [$this, 'fields']);
	}

	public function url() {
		return get_plugin_url('vendor/cmb2/cmb2');
	}

	public function fields() {
		$cmb = new_cmb2_box([
			'id' => PLUGIN_SLUG,
			'title' => __('Settings', 'vnh_textdomain'),
			'object_types' => ['post', 'page'], // Post type
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true, // Show field names on the left
			'vertical_tabs' => true, // Set vertical tabs, default false
			'tabs' => [
				[
					'id' => 'tab-1',
					'icon' => 'dashicons-admin-site',
					'title' => 'Tab 1',
					'fields' => ['description', 'style'],
				],
				[
					'id' => 'tab-2',
					'icon' => 'dashicons-align-left',
					'title' => 'Tab 2',
					'fields' => ['file_name', 'gender'],
				],
			],
		]);

		$cmb->add_field([
			'name' => __('Product Description', 'vnh_textdomain'),
			'desc' => __(
				'Add description for each product, can use [title], [color], [size] for generate dynamic product title, color, size',
				'vnh_textdomain'
			),
			'id' => 'description',
			'type' => 'textarea_small',
			'default' => '[title] - [color],[size]',
			'attributes' => [
				'placeholder' => __('Enter your placeholder here.', 'vnh_textdomain'),
				'required' => 'required',
			],
		]);

		$cmb->add_field([
			'name' => __('Styles', 'vnh_textdomain'),
			'desc' => __('Choose a style to filter result', 'vnh_textdomain'),
			'id' => 'style',
			'type' => 'select',
			'options' => [
				'Guys Tee' => __('Guys Tee', 'vnh_textdomain'),
				'Hoodie' => __('Hoodie', 'vnh_textdomain'),
				'Guys V-Neck' => __('Guys V-Neck', 'vnh_textdomain'),
				'Ladies Flowy Tank' => __('Ladies Flowy Tank', 'vnh_textdomain'),
				'Ladies Tee' => __('Ladies Tee', 'vnh_textdomain'),
				'Ladies V-Neck' => __('Ladies V-Neck', 'vnh_textdomain'),
				'Sweat Shirt' => __('Sweat Shirt', 'vnh_textdomain'),
				'Unisex Long Sleeve' => __('Unisex Long Sleeve', 'vnh_textdomain'),
				'Unisex Tank Top' => __('Unisex Tank Top', 'vnh_textdomain'),
				'Youth Tee' => __('Youth Tee', 'vnh_textdomain'),
				'Baby Onesie' => __('Baby Onesie', 'vnh_textdomain'),
				'Coffee Mug (colored)' => __('Coffee Mug (colored)', 'vnh_textdomain'),
				'Coffee Mug (white)' => __('Coffee Mug (white)', 'vnh_textdomain'),
			],
		]);

		$cmb->add_field([
			'name' => __('File Name', 'vnh_textdomain'),
			'desc' => __('Name of csv products feed file', 'vnh_textdomain'),
			'id' => 'file_name',
			'type' => 'text',
			'attributes' => [
				'placeholder' => __('products_feed', 'vnh_textdomain'),
				'required' => 'required',
			],
		]);

		$cmb->add_field([
			'name' => __('Gender', 'vnh_textdomain'),
			'id' => 'gender',
			'type' => 'select',
			'options' => [
				'male' => __('Male', 'vnh_textdomain'),
				'female' => __('Female', 'vnh_textdomain'),
				'unisex' => __('Unisex', 'vnh_textdomain'),
			],
		]);
	}
}
