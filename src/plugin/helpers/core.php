<?php

namespace vnh_namespace;

use vnh_namespace\settings_page\Settings_Page;

defined('WPINC') || die();

/*
 * GENERAL
 */
function set_cookie($name, $value, $time = DAY_IN_SECONDS, $path = '/') {
	setcookie($name, $value, time() + $time, $path);
	$_COOKIE[$name] = $value;
}

/*
 * WOOCOMMERCE
 */
function all_currencies() {
	$all = [];
	foreach (get_woocommerce_currencies() as $code => $currency) {
		$all[$code] = sprintf('%s - %s (%s)', $code, $currency, get_woocommerce_currency_symbol($code));
	}

	return $all;
}

function is_woocommerce_active() {
	return is_plugin_active('woocommerce/woocommerce.php');
}

/*
 * CORE
 */
function is_plugin_settings_page() {
	return strpos(get_current_screen()->id, MENU_SLUG) !== false;
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
