<?php

namespace vnh_namespace;

defined('WPINC') || die();

function is_plugin_settings_page() {
	return strpos(get_current_screen()->id, MENU_SLUG) !== false;
}

function get_plugin_path($dir = null) {
	if (empty($dir)) {
		return trailingslashit(PLUGIN_DIR);
	}

	return trailingslashit(PLUGIN_DIR) . $dir;
}

function get_plugin_url($dir = null) {
	if (empty($dir)) {
		return plugin_dir_url(PLUGIN_FILE);
	}

	return plugin_dir_url(PLUGIN_FILE) . $dir;
}

function is_dev() {
	return (defined(__NAMESPACE__ . '\DEV_MODE') && DEV_MODE !== 'disable' && !empty(DEV_MODE)) || isset($_GET['dev']);
}
