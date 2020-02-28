<?php

namespace vnh_namespace;

use vnh\Allowed_HTML;
use vnh\Checker;
use vnh\License_Management;
use vnh_namespace\admin\Admin;
use vnh_namespace\admin\Admin_Menu;
use vnh_namespace\admin\Settings;
use vnh_namespace\settings_page\CMB2_Settings_Page;
use vnh_namespace\settings_page\Settings_Page;
use vnh_namespace\tools\Config_CMB2;
use vnh_namespace\tools\Register_Assets;

trait Plugin_Variables {
	/**
	 * @var License_Management
	 */
	public $license;

	/**
	 * @var Allowed_HTML
	 */
	public $allow_html;

	/**
	 * @var Checker
	 */
	public $php_checker;

	/**
	 * @var Checker
	 */
	public $wp_checker;

	/**
	 * @var Settings
	 */
	public $settings;

	/**
	 * @var Settings_Page
	 */
	public $settings_page;

	/**
	 * @var CMB2_Settings_Page
	 */
	public $cmb2_settings_page;

	/**
	 * @var Admin_Menu
	 */
	public $admin_menus;

	/**
	 * @var Admin
	 */
	public $admin;

	/**
	 * @var Register_Assets
	 */
	public $register_backend_assets;

	/**
	 * @var Register_Assets
	 */
	public $register_frontend_assets;

	/**
	 * @var Config_CMB2
	 */
	public $config_cmb2;
}
