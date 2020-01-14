<?php

namespace vnh_namespace;

use vnh_namespace\settings_page\Settings_Page;

defined('WPINC') || die();

function is_woocommerce_active() {
	return is_plugin_active('woocommerce/woocommerce.php');
}

function is_plugin_settings_page() {
	return strpos(get_current_screen()->id, Settings_Page::MENU_SLUG) !== false;
}

function get_plugin_path($dir = null) {
	if (empty($dir)) {
		return PLUGIN_PATH;
	}

	return PLUGIN_PATH . $dir;
}

function get_plugin_url($dir = null) {
	if (empty($dir)) {
		return PLUGIN_URL;
	}

	return PLUGIN_URL . $dir;
}

function is_dev() {
	return (defined(__NAMESPACE__ . '\DEV_MODE') && DEV_MODE !== 'disable') || isset($_GET['dev']);
}
