<?php

namespace vnh_namespace\settings_page;

defined('WPINC') || die();

use vnh_namespace\tools\contracts\Renderable;
use function vnh_namespace\get_plugin_path;

class Tab_Changelog implements Renderable {
	public function __toString() {
		return $this->render();
	}

	public function render() {
		$html = '<div class="changelog info-tab-content">';
		$html .= $this->get_changelog();
		$html .= '</div>';

		return $html;
	}

	private function get_changelog() {
		$changelog = get_transient('vnh_prefix_changelog');
		$path = get_plugin_path('readme.txt');

		if (!file_exists($path)) {
			return __('No changelog found', 'vnh_textdomain');
		}

		$mtime = filemtime($path);

		if (isset($changelog['mtime']) && $mtime === $changelog['mtime']) {
			return $changelog['content'];
		}

		$changelog['mtime'] = $mtime;

		$readme_content = file($path, FILE_SKIP_EMPTY_LINES);

		$changelog['content'] = '';
		foreach ($readme_content as $readme_line) {
			if (preg_match('/=\s*[\d.]+/', (string) $readme_line, $matches) === 1) {
				$changelog_line = str_replace(['= ', ' ='], ['Version ', ''], $readme_line);

				$changelog['content'] .= "<h3>$changelog_line</h3>";
			}

			if (strpos($readme_line, '*') === 0) {
				$changelog_line = str_replace('*', '-', $readme_line);

				$changelog['content'] .= "<p>$changelog_line</p>";
			}
		}

		set_transient('vnh_prefix_changelog', $changelog);

		return $changelog['content'];
	}
}
