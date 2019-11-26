<?php

namespace vnh_namespace\settings_page;

use vnh_namespace\tools\Register_Settings;

class Tab_Settings extends Register_Settings {
	public $prefix = 'performance';
	public $default_settings = [
		'disable_xmlrpc' => true,
		'hide_wp_version' => true,
		'disable_emoji' => true,
		'disable_self_pingbacks' => true,
		'disable_dashicons' => true,
		'remove_shortlink' => true,
		'remove_jquery_migrate' => true,
		'remove_query_strings' => true,
		'remove_rsd_link' => true,
		'remove_wlwmanifest_link' => true,
	];

	public function register_setting_fields() {
		return [
			'head' => [
				'title' => __('Head', 'vnh_textdomain'),
				'description' => __(
					'Select head options you would like to enable and your site\'s head will be clean and more security',
					'vnh_textdomain'
				),
				'fields' => [
					[
						'id' => 'disable_xmlrpc',
						'name' => __('Disable XML-RPC', 'vnh_textdomain'),
						'tooltip' => __('Disables WordPress XML-RPC functionality.', 'vnh_textdomain'),
						'type' => 'toggle',
					],
					[
						'id' => 'hide_wp_version',
						'name' => __('Hide WordPress Version', 'vnh_textdomain'),
						'tooltip' => __('Removes WordPress version meta tag.', 'vnh_textdomain'),
						'type' => 'toggle',
					],
					[
						'id' => 'remove_rss_feed_links',
						'name' => __('Remove RSS Feed Links', 'vnh_textdomain'),
						'tooltip' => __('Disable WordPress generated RSS feed link tags.', 'vnh_textdomain'),
						'type' => 'toggle',
					],
					[
						'id' => 'remove_shortlink',
						'name' => __('Remove Shortlink', 'vnh_textdomain'),
						'tooltip' => __('Remove Shortlink link tag.', 'vnh_textdomain'),
						'type' => 'toggle',
					],
					[
						'id' => 'remove_wlwmanifest_link',
						'name' => __('Remove wlwmanifest Link', 'vnh_textdomain'),
						'tooltip' => __('Remove wlwmanifest (Windows Live Writer) link tag.', 'vnh_textdomain'),
						'type' => 'toggle',
					],
					[
						'id' => 'remove_rsd_link',
						'name' => __('Remove RSD Link', 'vnh_textdomain'),
						'tooltip' => __('Remove RSD (Real Simple Discovery) link tag.', 'vnh_textdomain'),
						'type' => 'toggle',
					],
					[
						'id' => 'enable_blank_favicon',
						'name' => __('Enable Blank Favicon', 'vnh_textdomain'),
						'tooltip' => __('Adds a blank favicon will prevent 404 error from speed testing tools.', 'vnh_textdomain'),
						'type' => 'toggle',
					],
				],
			],
			'comments' => [
				'title' => __('Comments', 'vnh_textdomain'),
				'description' => __('Select comments options you would like to enable.', 'vnh_textdomain'),
				'fields' => [
					[
						'id' => 'disable_comments',
						'name' => __('Disable Comments', 'vnh_textdomain'),
						'tooltip' => __('Disables WordPress comments across your entire site.', 'vnh_textdomain'),
						'type' => 'toggle',
					],
					[
						'id' => 'remove_comment_urls',
						'name' => __('Remove Comment URLs', 'vnh_textdomain'),
						'tooltip' => __('Removes the comment author link and website field from blog posts.', 'vnh_textdomain'),
						'type' => 'toggle',
					],
				],
			],
			'general' => [
				'title' => __('General', 'vnh_textdomain'),
				'description' => __('Select general options you would like to enable.', 'vnh_textdomain'),
				'fields' => [
					[
						'id' => 'disable_embeds',
						'name' => __('Disable Embeds', 'vnh_textdomain'),
						'tooltip' => __('Removes WordPress Embed JavaScript file (wp-embed.min.js).', 'vnh_textdomain'),
						'type' => 'toggle',
					],
					[
						'id' => 'disable_emoji',
						'name' => __('Disable Emoji', 'vnh_textdomain'),
						'tooltip' => __('Removes WordPress Emoji JavaScript file (wp-emoji-release.min.js).', 'vnh_textdomain'),
						'type' => 'toggle',
					],
					[
						'id' => 'disable_self_pingbacks',
						'name' => __('Disable Self Pingbacks', 'vnh_textdomain'),
						'tooltip' => __('Disable Self Pingbacks (generated when linking to a post on your own blog).', 'vnh_textdomain'),
						'type' => 'toggle',
					],
					[
						'id' => 'disable_dashicons',
						'name' => __('Disable Dashicons', 'vnh_textdomain'),
						'tooltip' => __('Disables dashicons on the front end when not logged in.', 'vnh_textdomain'),
						'type' => 'toggle',
					],
					[
						'id' => 'remove_query_strings',
						'name' => __('Remove Query Strings', 'vnh_textdomain'),
						'tooltip' => __('Remove query strings from static resources (CSS, JS).', 'vnh_textdomain'),
						'type' => 'toggle',
					],
					[
						'id' => 'remove_rest_api_links',
						'name' => __('Remove REST API Links', 'vnh_textdomain'),
						'tooltip' => __('Removes REST API link tag from the front end from page requests.', 'vnh_textdomain'),
						'type' => 'toggle',
					],
					[
						'id' => 'remove_jquery_migrate',
						'name' => __('Remove jQuery Migrate', 'vnh_textdomain'),
						'tooltip' => __('Removes jQuery Migrate JavaScript file (jquery-migrate.min.js).', 'vnh_textdomain'),
						'type' => 'toggle',
					],
				],
			],
		];
	}
}
