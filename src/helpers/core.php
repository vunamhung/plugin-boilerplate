<?php

namespace vnh_namespace;

defined('ABSPATH') || die();

function is_plugin_settings_page() {
	return strpos(get_current_screen()->id, MENU_SLUG) !== false || strpos(get_current_screen()->id, PLUGIN_SLUG) !== false;
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
