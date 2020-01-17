<?php

namespace vnh_namespace;

defined('WPINC') || die();

$plugin_data = get_plugin_data(PLUGIN_FILE);

define(__NAMESPACE__ . '\PLUGIN_NAME', $plugin_data['Name']);
define(__NAMESPACE__ . '\PLUGIN_DESCRIPTION', $plugin_data['Description']);
define(__NAMESPACE__ . '\PLUGIN_URI', $plugin_data['PluginURI']);
define(__NAMESPACE__ . '\PLUGIN_VERSION', $plugin_data['Version']);
define(__NAMESPACE__ . '\PLUGIN_AUTHOR', $plugin_data['Author']);
define(__NAMESPACE__ . '\PLUGIN_AUTHOR_URI', $plugin_data['AuthorURI']);
define(__NAMESPACE__ . '\PLUGIN_TEXT_DOMAIN', $plugin_data['TextDomain']);
define(__NAMESPACE__ . '\PLUGIN_SLUG', basename(PLUGIN_DIR));
define(__NAMESPACE__ . '\PLUGIN_BASE', plugin_basename(PLUGIN_FILE));
define(__NAMESPACE__ . '\PLUGIN_PATH', trailingslashit(PLUGIN_DIR));
define(__NAMESPACE__ . '\PLUGIN_URL', esc_url(plugin_dir_url(PLUGIN_FILE)));
define(__NAMESPACE__ . '\PLUGIN_DOCUMENT_URI', esc_url(get_file_data(PLUGIN_FILE, ['Document URI'])[0]));

const DS = '/';
const DEV_MODE = 'vnh_dev_mode';
const WPORG = false;
const PREMIUM_URL = 'https://geargag.com/';
const MENU_SLUG = 'geargag_plugins';
const PLUGINS_LIST_FILE = 'https://geargag.com/geargag_plugins.json';
