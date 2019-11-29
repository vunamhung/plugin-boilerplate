<?php

namespace vnh_namespace;

define(__NAMESPACE__ . '\PLUGIN_SLUG', basename(__DIR__));
define(__NAMESPACE__ . '\PLUGIN_PATH', trailingslashit(__DIR__));
define(__NAMESPACE__ . '\PLUGIN_URL', plugin_dir_url(__FILE__));

const DS = '/';

const PLUGIN_NAME = 'vnh_name';
const PLUGIN_DESCRIPTION = 'vnh_description';
const PLUGIN_URI = 'vnh_uri';
const PLUGIN_VERSION = 'vnh_version';
const PLUGIN_TEXT_DOMAIN = 'vnh_slug';
const PLUGIN_AUTHOR = 'vnh_author';
const PLUGIN_AUTHOR_URI = 'vnh_author_uri';
const PLUGIN_DOCUMENT_URI = 'vnh_document_uri';

const DEV_MODE = 'vnh_dev_mode';
const WPORG = false;

const PREMIUM_URL = 'http://geargag.com/';
