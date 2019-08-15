<?php

namespace vnh_namespace;

define(__NAMESPACE__ . '\PLUGIN_NAME', Core::$plugin['name']);
define(__NAMESPACE__ . '\PLUGIN_DESC', Core::$plugin['description']);
define(__NAMESPACE__ . '\PLUGIN_URI', Core::$plugin['uri']);
define(__NAMESPACE__ . '\PLUGIN_VERSION', Core::$plugin['version']);
define(__NAMESPACE__ . '\PLUGIN_TITLE', Core::$plugin['title']);
define(__NAMESPACE__ . '\PLUGIN_BASE', Core::$plugin['base']);
define(__NAMESPACE__ . '\PLUGIN_SLUG', Core::$plugin['slug']);
define(__NAMESPACE__ . '\PLUGIN_TEXT_DOMAIN', Core::$plugin['textdomain']);
define(__NAMESPACE__ . '\PLUGIN_AUTHOR', Core::$plugin['author']);
define(__NAMESPACE__ . '\PLUGIN_AUTHOR_NAME', Core::$plugin['author_name']);
define(__NAMESPACE__ . '\PLUGIN_AUTHOR_URI', Core::$plugin['author_uri']);

const DS = DIRECTORY_SEPARATOR;
const DEV_MODE = 'vnh_dev_mode';

const ASSETS_DIR = 'assets/';
const LIBS_DIR = ASSETS_DIR . 'libs/';

class Constants {
}
