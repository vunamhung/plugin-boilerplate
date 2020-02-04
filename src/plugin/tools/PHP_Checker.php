<?php

namespace vnh_namespace\tools;

use vnh_namespace\tools\contracts\Bootable;

use const vnh_namespace\MIN_PHP_VERSION;
use const vnh_namespace\PLUGIN_BASE;

class PHP_Checker implements Bootable {
	public $min_php = MIN_PHP_VERSION;

	public function boot() {
		add_action('admin_init', [$this, 'maybe_deactivate_plugin']);
	}

	public function maybe_deactivate_plugin() {
		if (version_compare(PHP_VERSION, $this->min_php, '>=') || !is_plugin_active(PLUGIN_BASE)) {
			return;
		}

		deactivate_plugins(PLUGIN_BASE);

		add_action('admin_notices', [$this, 'disabled_notice']);

		if (isset($_GET['activate'])) {
			unset($_GET['activate']);
		}
	}

	public function php_version_too_low() {
		wp_die(
			sprintf(
				esc_html__('%s requires PHP version %s or higher and cannot be activated. You are currently running version %s.', 'vnh_textdomain'),
				'vnh_name',
				esc_html($this->min_php),
				PHP_VERSION
			)
		);
	}

	public function is_compatible_check() {
		if (version_compare(PHP_VERSION, $this->min_php, '<')) {
			return false;
		}

		return true;
	}

	public function disabled_notice() {
		$html = '<div class="updated" style="border-left: 4px solid #ffba00;"><p>';
		$html .= sprintf(
			esc_html__(
				'%s requires PHP version %s or higher to run and has been deactivated. You are currently running version %s.',
				'vnh_textdomain'
			),
			'vnh_name',
			$this->min_php,
			PHP_VERSION
		);
		$html .= '</p></div>';

		echo $html;
	}
}
