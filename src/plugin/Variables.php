<?php

namespace vnh_namespace;

use vnh_namespace\settings_page\Settings_Page;
use vnh_namespace\tools\Register_Assets;

trait Variables {
	public $plugin_file;
	public $plugin_dir;
	public static $info;

	/**
	 * @var Settings_Page
	 */
	public $settings_page;

	/**
	 * @var Admin_Notices
	 */
	public $admin_notices;

	/**
	 * @var Register_Assets
	 */
	public $frontend_assets;

	/**
	 * @var Register_Assets
	 */
	public $backend_assets;
}
