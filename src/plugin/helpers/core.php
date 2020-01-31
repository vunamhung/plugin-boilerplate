<?php

namespace vnh_namespace;

defined('ABSPATH') || die();

function is_plugin_settings_page() {
	return strpos(get_current_screen()->id, MENU_SLUG) !== false;
}

function get_plugin_path($dir = null) {
	if (empty($dir)) {
		return trailingslashit(Plugin::DIR);
	}

	return trailingslashit(Plugin::DIR) . $dir;
}

function get_plugin_url($dir = null) {
	if (empty($dir)) {
		return plugin_dir_url(Plugin::FILE);
	}

	return plugin_dir_url(Plugin::FILE) . $dir;
}

function is_dev() {
	return (defined(__NAMESPACE__ . '\DEV_MODE') && DEV_MODE !== 'disable' && !empty(DEV_MODE)) || isset($_GET['dev']);
}
