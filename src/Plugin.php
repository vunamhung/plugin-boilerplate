<?php
/**
 * Plugin Name: vnh_name
 * Description: vnh_description
 * Version: vnh_version
 * Tags: vnh_tags
 * Author: vnh_author
 * Author URI: vnh_author_uri
 * License: vnh_license
 * License URI: vnh_license_uri
 * Document URI: vnh_document_uri
 * Text Domain: vnh_textdomain
 * Tested up to: WordPress vnh_tested_up_to
 * WC requires at least: vnh_wc_requires
 * WC tested up to: vnh_wc_tested_up_to
 */

namespace vnh_namespace;

use vnh\Allowed_HTML;
use vnh\contracts\Loadable;
use vnh\Plugin_Action_Links;
use vnh\Plugin_Row_Meta;
use vnh_namespace\admin\Our_Plugins_Menu;
use vnh_namespace\admin\Settings;
use vnh_namespace\settings_page\CMB2_Settings_Page;
use vnh_namespace\settings_page\Settings_Page;
use vnh_namespace\tools\Config_CMB2;
use vnh_namespace\tools\PHP_Checker;
use vnh_namespace\tools\WordPress_Checker;
use function vnh\plugin_languages_path;

const PLUGIN_FILE = __FILE__;
const PLUGIN_DIR = __DIR__;

require_once PLUGIN_DIR . '/vendor/autoload.php';

final class Plugin implements Loadable {
	use Constants;
	use Helpers;

	public function __construct() {
		$this->load();
		$this->boot();
	}

	public function load() {
		$services = Container::instance()->services;

		$services->get(PHP_Checker::class)->init();
		$services->get(WordPress_Checker::class)->init();

		$services->get(Allowed_HTML::class)->boot();
		$services->get(Enqueue_Frontend_Assets::class)->boot();
		$services->get(Config_CMB2::class)->boot();

		if (is_admin()) {
			$services->get(Our_Plugins_Menu::class)->boot();
			$services->get(Plugin_Action_Links::class)->boot();
			$services->get(Plugin_Row_Meta::class)->boot();

			$services->get(Settings::class)->init();
			$services->get(Settings::class)->boot();

			$services->get(CMB2_Settings_Page::class)->boot();
			$services->get(Settings_Page::class)->boot();

			$services->get(Enqueue_Backend_Assets::class)->boot();
		}
	}

	public function boot() {
		add_action('plugin_loaded', [$this, 'plugin_loaded']);
	}

	public function plugin_loaded() {
		load_plugin_textdomain('vnh_textdomain', false, plugin_languages_path(PLUGIN_FILE));
	}
}

new Plugin();
