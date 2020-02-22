<?php

namespace vnh_namespace\admin\menu;

use function vnh\request;
use function vnh_namespace\get_plugin_url;

use const vnh_namespace\PLUGINS_LIST_FILE;

class Our_Plugins {
	public function __toString() {
		return $this->render();
	}

	public function render() {
		$html = '<div class="plugins-list info-tab-content">';
		foreach ($this->get_plugins_list() as $plugin) {
			$html .= sprintf(
				'<div class="card">
                  <div class="card-image"><img class="img-responsive" src="%s" alt="%s"></div>
                  <div class="card-header">
                    <a href="%s" target="_blank"><button class="btn btn-primary float-right">%s</button></a>
                    <div class="card-title h5">%s</div>
                    <div class="card-subtitle text-gray">%s</div>
                  </div>
                  <div class="card-body">%s</div>
                </div>',
				!empty($plugin['img']) ? $plugin['img'] : get_plugin_url('assets/images/plugin-banner.svg'),
				$plugin['name'],
				$plugin['link'],
				__('More info', 'vnh_textdomain'),
				$plugin['name'],
				__('by ', 'vnh_textdomain') . $plugin['author'],
				$plugin['description']
			);
		}
		$html .= '</div>';

		return $html;
	}

	protected function get_plugins_list() {
		$cached_plugins_list = get_transient('plugins_list');

		if (!empty($cached_plugins_list)) {
			return $cached_plugins_list;
		}

		$response = '';
		if (!is_wp_error($response)) {
			$response = request(PLUGINS_LIST_FILE);
		}

		set_transient('plugins_list', $response, DAY_IN_SECONDS * 7);

		return $response;
	}
}
