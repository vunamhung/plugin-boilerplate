<?php

namespace vnh_namespace\settings_page;

use vnh\contracts\Bootable;

use const vnh_namespace\PLUGIN_DESCRIPTION;
use const vnh_namespace\PLUGIN_NAME;
use const vnh_namespace\PLUGIN_SLUG;
use const vnh_namespace\PLUGIN_VERSION;

class CMB2_Settings_Page implements Bootable {
	public function boot() {
		add_action('cmb2_admin_init', [$this, 'fields']);
	}

	public function fields() {
		$cmb = new_cmb2_box([
			'id' => PLUGIN_SLUG,
			'title' => sprintf(
				'<h1>' . __('Getting Started with <strong>%1$s</strong> <code>%2$s</code>', 'vnh_textdomain') . '</h1>',
				PLUGIN_NAME,
				PLUGIN_VERSION
			),
			'description' => PLUGIN_DESCRIPTION,
			'object_types' => ['options-page'],
			'option_key' => PLUGIN_SLUG . '_options',
			'menu_title' => esc_html__('CMB2 Page Options', 'vnh_textdomain'), // Falls back to 'title' (above).
			'parent_slug' => PLUGIN_SLUG,
			'capability' => 'manage_options',
			'display_cb' => [$this, 'display_cb'],
			'save_button' => esc_html__('Save Plugin Options', 'vnh_textdomain'),
			// 'disable_settings_errors' => true, // On settings pages (not options-general.php sub-pages), allows disabling.
			// 'message_cb'      => 'yourprefix_options_page_message_callback',
			// 'icon_url'        => '', // Menu icon. Only applicable if 'parent_slug' is left empty.
			// 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
			// 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
		]);

		$cmb->add_field([
			'name' => __('Enable', 'vnh_textdomain'),
			'id' => 'enable',
			'type' => 'toggle',
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
			'type' => 'select2',
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
			'attributes' => [
				'required' => true, // Will be required only if visible.
				'data-conditional-id' => 'file_name',
			],
		]);
	}

	public function display_cb(\CMB2_Options_Hookup $object) {
		$html = '<div class="wrapper">';
		$html .= $object->cmb->prop('title') ? sprintf('<h1>%s</h1>', $object->cmb->prop('title')) : null;
		$html .= $object->cmb->prop('description') ? sprintf('<p class="about-text">%s</p>', $object->cmb->prop('description')) : null;
		$html .= sprintf('<div class="wrap cmb2-options-page option-%s">', esc_attr(sanitize_html_class($object->option_key)));
		$html .= sprintf(
			'<form class="cmb-form" action="%s" method="POST" id="%s" enctype="multipart/form-data" encoding="multipart/form-data">',
			admin_url('admin-post.php'),
			$object->cmb->cmb_id
		);
		$html .= sprintf('<input type="hidden" name="action" value="%s">', esc_attr($object->option_key));
		ob_start();
		$object->options_page_metabox();
		$html .= ob_get_clean();
		$html .= get_submit_button(esc_attr($object->cmb->prop('save_button')), 'primary', 'submit-cmb');
		$html .= '</form>';
		$html .= '</div>';

		echo $html;
	}
}
