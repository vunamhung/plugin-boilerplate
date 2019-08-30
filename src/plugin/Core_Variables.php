<?php

namespace vnh_namespace;

use vnh_namespace\tools\Register_Assets;

trait Core_Variables {
	public $main_plugin_file;
	public $main_plugin_dir;
	public static $plugin;
	/**
	 * @var Register_Assets
	 */
	public $frontend_assets;

	/**
	 * @var Register_Assets
	 */
	public $backend_assets;
}
