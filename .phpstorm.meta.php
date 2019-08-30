<?php

namespace PHPSTORM_META {
	registerArgumentsSet('textdomain_values', 'vnh_textdomain');
	expectedArguments(\__(), 1, argumentsSet("textdomain_values"));
	expectedArguments(\_nx(), 4, argumentsSet("textdomain_values"));
	expectedArguments(\esc_html__(), 1, argumentsSet("textdomain_values"));
	expectedArguments(\esc_attr__(), 1, argumentsSet("textdomain_values"));
	expectedArguments(\esc_attr_e(), 1, argumentsSet("textdomain_values"));
	expectedArguments(\esc_html_e(), 1, argumentsSet("textdomain_values"));
	expectedArguments(\_n(), 3, argumentsSet("textdomain_values"));
	expectedArguments(\load_plugin_textdomain(), 0, argumentsSet("textdomain_values"));

	expectedArguments(
		\get_option(),
		0,
		'siteurl',
		'stylesheet',
		'template',
		'thread_comments',
		'active_plugins',
		'timezone_string',
		'require_name_email',
		'gmt_offset',
		'date_format'
	);
	expectedArguments(\get_bloginfo(), 0, 'version');
	expectedArguments(\class_exists(), 0, 'WP_CLI', 'Jetpack', 'Freemius');
	expectedArguments(
		\wp_kses(),
		1,
		'default',
		'image',
		'widget_field',
		'svg',
		'svg_content',
		'breadcrumb',
		'title',
		'price',
		'heading',
		'link',
		'iframe'
	);
	registerArgumentsSet(
		'trailingslashit',
		get_template_directory(),
		get_template_directory_uri(),
		get_stylesheet_directory(),
		get_stylesheet_directory_uri()
	);
	expectedArguments(\trailingslashit(), 0, argumentsSet("trailingslashit"));
	expectedArguments(\untrailingslashit(), 0, argumentsSet("trailingslashit"));
}
