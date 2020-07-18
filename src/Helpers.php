<?php

namespace vnh_namespace;

function get_rest_url($blog_id = null, $path = '/', $scheme = 'rest') {
	if (empty($path)) {
		$path = '/';
	}

	$path = '/' . ltrim($path, '/');

	if ((is_multisite() && get_blog_option($blog_id, 'permalink_structure')) || get_option('permalink_structure')) {
		global $wp_rewrite;

		if (!is_null($wp_rewrite) && $wp_rewrite->using_index_permalinks()) {
			$url = get_home_url($blog_id, $wp_rewrite->index . '/' . rest_get_url_prefix(), $scheme);
		} else {
			$url = get_home_url($blog_id, rest_get_url_prefix(), $scheme);
		}

		$url .= $path;
	} else {
		$url = trailingslashit(get_home_url($blog_id, '', $scheme));
		// nginx only allows HTTP/1.0 methods when redirecting from / to /index.php.
		// To work around this, we manually add index.php to the URL, avoiding the redirect.
		if ('index.php' !== substr($url, 9)) {
			$url .= 'index.php';
		}

		$url = add_query_arg('rest_route', $path, $url);
	}

	if (is_ssl() && isset($_SERVER['SERVER_NAME'])) {
		// If the current host is the same as the REST URL host, force the REST URL scheme to HTTPS.
		if (parse_url(get_home_url($blog_id), PHP_URL_HOST) === $_SERVER['SERVER_NAME']) {
			$url = set_url_scheme($url, 'https');
		}
	}

	if (is_admin() && force_ssl_admin()) {
		/*
		 * In this situation the home URL may be http:, and `is_ssl()` may be false,
		 * but the admin is served over https: (one way or another), so REST API usage
		 * will be blocked by browsers unless it is also served over HTTPS.
		 */
		$url = set_url_scheme($url, 'https');
	}

	/**
	 * Filters the REST URL.
	 *
	 * Use this filter to adjust the url returned by the get_rest_url() function.
	 *
	 * @since 4.4.0
	 *
	 * @param string $url     REST URL.
	 * @param string $path    REST route.
	 * @param int    $blog_id Blog ID.
	 * @param string $scheme  Sanitization scheme.
	 */
	return apply_filters('rest_url', $url, $path, $blog_id, $scheme);
}

function handle($name) {
	return PLUGIN_SLUG . '-' . $name;
}

function set_cookie($name, $value, $time = DAY_IN_SECONDS, $path = '/') {
	setcookie($name, $value, time() + $time, $path);
	$_COOKIE[$name] = $value;
}

function is_plugin_settings_page() {
	return strpos(get_current_screen()->id, PLUGIN_SLUG) !== false;
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

trait Helpers {
}
