<?php

namespace vnh_namespace;

defined('WPINC') || die();

define(__NAMESPACE__ . '\PLUGIN_NAME', 'vnh_name');
define(__NAMESPACE__ . '\PLUGIN_DESCRIPTION', 'vnh_description');
define(__NAMESPACE__ . '\PLUGIN_URI', 'vnh_uri');
define(__NAMESPACE__ . '\PLUGIN_VERSION', 'vnh_version');
define(__NAMESPACE__ . '\PLUGIN_TEXT_DOMAIN', 'vnh_slug');
define(__NAMESPACE__ . '\PLUGIN_AUTHOR', 'vnh_author');
define(__NAMESPACE__ . '\PLUGIN_AUTHOR_NAME', 'vnh_author_name');
define(__NAMESPACE__ . '\PLUGIN_AUTHOR_URI', 'vnh_author_uri');
define(__NAMESPACE__ . '\PLUGIN_DOCUMENT_URI', 'vnh_document_uri');
define(__NAMESPACE__ . '\PLUGIN_SLUG', Core::$plugin['slug']);
define(__NAMESPACE__ . '\PLUGIN_BASE', Core::$plugin['base']);

const DS = DIRECTORY_SEPARATOR;
const DEV_MODE = 'vnh_dev_mode';
const WPORG = false;

const ASSETS_DIR = 'assets/';
const LIBS_DIR = ASSETS_DIR . 'libs/';

class Constants {
}
