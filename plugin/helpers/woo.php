<?php

namespace vnh_namespace;

defined('ABSPATH') || die();

function is_woocommerce_active() {
	return is_plugin_active('woocommerce/woocommerce.php');
}

function all_currencies() {
	$all = [];

	if (is_woocommerce_active()) {
		foreach (get_woocommerce_currencies() as $code => $currency) {
			$all[$code] = sprintf('%s - %s (%s)', $code, $currency, get_woocommerce_currency_symbol($code));
		}
	}

	return $all;
}
