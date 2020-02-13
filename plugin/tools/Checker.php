<?php

namespace vnh_namespace\tools;

use vnh_namespace\tools\contracts\Bootable;

use const vnh_namespace\PLUGIN_BASE;

class Checker implements Bootable {
	public $compare_version;
	public $min_version;
	public $name;

	public function __construct($compare_version, $min_version, $name) {
		$this->min_version = $min_version;
		$this->compare_version = $compare_version;
		$this->name = $name;
	}

	public function boot() {
		add_action('admin_init', [$this, 'maybe_deactivate_plugin']);
	}

	public function maybe_deactivate_plugin() {
		if (version_compare($this->compare_version, $this->min_version, '>=') || !is_plugin_active(PLUGIN_BASE)) {
			return;
		}

		deactivate_plugins(PLUGIN_BASE);

		add_action('admin_notices', [$this, 'disabled_notice']);

		if (isset($_GET['activate'])) {
			unset($_GET['activate']);
		}
	}

	public function version_too_low() {
		wp_die(
			sprintf(
				esc_html__('%s requires %s version %s or higher and cannot be activated. You are currently running version %s.', 'vnh_textdomain'),
				'vnh_name',
				esc_html($this->name),
				esc_html($this->min_version),
				$this->compare_version
			)
		);
	}

	public function is_compatible_check() {
		if (version_compare($this->compare_version, $this->min_version, '<')) {
			return false;
		}

		return true;
	}

	public function disabled_notice() {
		$html = '<div class="updated" style="border-left: 4px solid #ffba00;"><p>';
		$html .= sprintf(
			esc_html__(
				'%s requires %s version %s or higher to run and has been deactivated. You are currently running version %s.',
				'vnh_textdomain'
			),
			'vnh_name',
			esc_html($this->name),
			$this->min_version,
			$this->compare_version
		);
		$html .= '</p></div>';

		echo $html;
	}
}
