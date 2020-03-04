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

use DI\ContainerBuilder;
use vnh\Allowed_HTML;
use vnh\contracts\Enqueueable;
use vnh\contracts\Loadable;
use vnh\Our_Plugins;
use vnh\Plugin_Action_Links;
use vnh\Plugin_Row_Meta;
use vnh\Singleton;
use vnh_namespace\admin\Our_Plugins_Menu;
use vnh_namespace\admin\Settings;
use vnh_namespace\settings_page\CMB2_Settings_Page;
use vnh_namespace\settings_page\Settings_Page;
use vnh_namespace\tools\Config_CMB2;
use vnh_namespace\tools\PHP_Checker;
use vnh_namespace\tools\Register_Backend_Assets;
use vnh_namespace\tools\Register_Frontend_Assets;
use vnh_namespace\tools\WordPress_Checker;
use WP_Review_Me;
use function DI\autowire;
use function DI\create;
use function vnh\plugin_languages_path;

const PLUGIN_FILE = __FILE__;
const PLUGIN_DIR = __DIR__;

require_once PLUGIN_DIR . '/vendor/autoload.php';

final class Plugin extends Singleton implements Loadable, Enqueueable {
	public $builder;
	public $container;

	protected function __construct() {
		$this->builder = new ContainerBuilder();
		$this->builder->addDefinitions(
			apply_filters('vnh_prefix/definitions', [
				PHP_Checker::class => create(),
				WordPress_Checker::class => create(),
				Our_Plugins::class => create()->constructor(PLUGINS_LIST_URL),
				Our_Plugins_Menu::class => autowire(),
				Allowed_HTML::class => create(),
				WP_Review_Me::class => create()->constructor(['days_after' => 10, 'type' => 'plugin', 'slug' => PLUGIN_SLUG]),
				Plugin_Action_Links::class => create()->constructor(PLUGIN_BASE, PLUGIN_SLUG),
				Plugin_Row_Meta::class => create()->constructor(PLUGIN_BASE, PLUGIN_SLUG),
				Config_CMB2::class => create(),
				CMB2_Settings_Page::class => create(),
				Settings::class => create(),
				Settings_Page::class => create(),
				Register_Backend_Assets::class => create(),
				Register_Frontend_Assets::class => create(),
			])
		);

		$this->container = $this->builder->build();
	}

	public function load() {
		$this->container->get(PHP_Checker::class)->init();
		$this->container->get(WordPress_Checker::class)->init();

		$this->container->get(Allowed_HTML::class)->boot();
		$this->container->get(Register_Frontend_Assets::class)->boot();
		$this->container->get(Config_CMB2::class)->boot();
		if (is_admin()) {
			$this->container->get(Register_Backend_Assets::class)->boot();
			$this->container->get(Our_Plugins_Menu::class)->boot();
			$this->container->get(WP_Review_Me::class);
			$this->container->get(Plugin_Action_Links::class)->boot();
			$this->container->get(Plugin_Row_Meta::class)->boot();

			$this->container->get(Settings::class)->init();
			$this->container->get(Settings::class)->boot();

			$this->container->get(CMB2_Settings_Page::class)->boot();
			$this->container->get(Settings_Page::class)->boot();
		}
	}

	public function boot() {
		add_action('plugin_loaded', [$this, 'plugin_loaded']);
		add_action('admin_enqueue_scripts', [$this, 'enqueue_backend_assets']);
		add_action('wp_enqueue_scripts', [$this, 'enqueue']);
	}

	public function plugin_loaded() {
		load_plugin_textdomain('vnh_textdomain', false, plugin_languages_path(PLUGIN_FILE));
	}

	public function enqueue_backend_assets() {
		if (is_plugin_settings_page()) {
			wp_enqueue_style(handle('settings-page'));
		}
	}

	public function enqueue() {
		wp_enqueue_script(PLUGIN_SLUG);
	}
}

Plugin::instance();
do_action('vnh_prefix/before/load');
Plugin::instance()->load();
do_action('vnh_prefix/after/load');
Plugin::instance()->boot();
