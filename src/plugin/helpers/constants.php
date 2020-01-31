<?php

namespace vnh_namespace;

defined('WPINC') || die();

define(__NAMESPACE__ . '\PLUGIN_DATA', get_plugin_data(PLUGIN_FILE));
define(__NAMESPACE__ . '\PLUGIN_SLUG', basename(PLUGIN_DIR));
define(__NAMESPACE__ . '\PLUGIN_BASE', plugin_basename(PLUGIN_FILE));
define(__NAMESPACE__ . '\PLUGIN_DOCUMENT_URI', get_file_data(PLUGIN_FILE, ['Document URI'])[0]);

const PLUGIN_NAME = PLUGIN_DATA['Name'];
const PLUGIN_DESCRIPTION = PLUGIN_DATA['Description'];
const PLUGIN_URI = PLUGIN_DATA['PluginURI'];
const PLUGIN_VERSION = PLUGIN_DATA['Version'];
const PLUGIN_AUTHOR = PLUGIN_DATA['Author'];
const PLUGIN_AUTHOR_URI = PLUGIN_DATA['AuthorURI'];
const PLUGIN_TEXT_DOMAIN = PLUGIN_DATA['TextDomain'];

const DS = '/';
const DEV_MODE = 'vnh_dev_mode';
const WPORG = false;

const PREMIUM_URL = 'https://geargag.com/';
const MENU_SLUG = 'geargag_plugins';
const PLUGINS_LIST_FILE = 'https://geargag.com/geargag_plugins.json';
