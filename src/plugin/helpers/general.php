<?php

namespace vnh_namespace;

defined('ABSPATH') || die();

function handle($name) {
	return PLUGIN_SLUG . '-' . $name;
}

function set_cookie($name, $value, $time = DAY_IN_SECONDS, $path = '/') {
	setcookie($name, $value, time() + $time, $path);
	$_COOKIE[$name] = $value;
}
