<?php

namespace vnh_namespace\tools;

defined('ABSPATH') || die();

use vnh\contracts\Bootable;
use vnh\Register_Script;
use vnh\Register_Style;

class Register_Assets implements Bootable {
	public $scripts;
	public $styles;
	public $context;

	public function __construct($assets, $context = 'frontend') {
		$this->context = $context;
		$this->scripts = apply_filters("$context/register/scripts", $assets['scripts']);
		$this->styles = apply_filters("$context/register/styles", $assets['styles']);
	}

	public function boot() {
		if ($this->context === 'backend') {
			add_action('admin_enqueue_scripts', [$this, 'register_scripts']);
			add_action('admin_enqueue_scripts', [$this, 'register_styles']);
		} elseif ($this->context === 'block') {
			add_action('enqueue_block_assets', [$this, 'register_scripts']);
			add_action('enqueue_block_assets', [$this, 'register_styles']);
		} elseif ($this->context === 'editor') {
			add_action('enqueue_block_editor_assets', [$this, 'register_scripts']);
			add_action('enqueue_block_editor_assets', [$this, 'register_styles']);
		} else {
			add_action('wp_enqueue_scripts', [$this, 'register_scripts']);
			add_action('wp_enqueue_scripts', [$this, 'register_styles']);
		}
	}

	public function register_scripts() {
		if (empty($this->scripts)) {
			return;
		}

		foreach ($this->scripts as $handle => $args) {
			$register = new Register_Script($handle, $args);
			$register->register_script();
		}
	}

	public function register_styles() {
		if (empty($this->styles)) {
			return;
		}

		foreach ($this->styles as $handle => $args) {
			$register = new Register_Style($handle, $args);
			$register->register_style();
		}
	}
}
