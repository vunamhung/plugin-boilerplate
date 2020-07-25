<?php

namespace vnh_namespace;

use DI\ContainerBuilder;
use vnh\Allowed_HTML;
use vnh\Plugin_Action_Links;
use vnh\Plugin_Row_Meta;
use vnh\Singleton;
use vnh_namespace\api\Setting_API;
use vnh_namespace\tools\PHP_Checker;
use vnh_namespace\tools\WooCommerce_Checker;
use vnh_namespace\tools\WordPress_Checker;
use function DI\create;

final class Container extends Singleton {
	public $services;

	protected function __construct() {
		$builder = new ContainerBuilder();
		$builder->addDefinitions(
			apply_filters('vnh_prefix/definitions', [
				PHP_Checker::class => create(),
				WordPress_Checker::class => create(),
				WooCommerce_Checker::class => create(),
				Allowed_HTML::class => create(),
				Plugin_Action_Links::class => create()->constructor(PLUGIN_BASE, PLUGIN_SLUG),
				Plugin_Row_Meta::class => create()->constructor(PLUGIN_BASE, PLUGIN_DOCUMENT_URI),
				Setting_API::class => create(),
				Settings_Page::class => create(),
				Enqueue_Backend_Assets::class => create(),
				Enqueue_Frontend_Assets::class => create(),
			])
		);

		$this->services = $builder->build();
	}
}
