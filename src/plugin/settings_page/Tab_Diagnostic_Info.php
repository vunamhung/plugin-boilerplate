<?php

namespace vnh_namespace\settings_page;

defined('WPINC') || die();

use vnh_namespace\tools\contracts\Renderable;
use function vnh_namespace\get_plugin_details;
use function vnh_namespace\is_open_ssl_enabled;
use const vnh_namespace\DS;
use const vnh_namespace\PLUGIN_NAME;
use const vnh_namespace\PLUGIN_SLUG;

class Tab_Diagnostic_Info implements Renderable {
	public $download_button_text;
	public $debug_file_url;

	public function __construct() {
		$this->download_button_text = esc_attr_x('Download', 'Download log file to your computer', 'vnh_textdomain');

		$query = ['page' => PLUGIN_SLUG, 'tab' => 'diagnostic', 'download-log' => true, 'nonce' => wp_create_nonce('download-log')];
		$this->debug_file_url = add_query_arg($query, admin_url('admin.php'));
		$this->http_prepare_download_log();
	}

	public function __toString() {
		return $this->render();
	}

	public function render() {
		$html = '<div class="diagnostic info-tab-content">';
		$html .= '<textarea class="debug-log-textarea" readonly>';
		$html .= $this->render_diagnostic_info();
		$html .= '</textarea>';
		$html .= sprintf('<a href="%s" class="button">%s</a>', $this->debug_file_url, $this->download_button_text);
		$html .= '</div>';

		return wp_kses($html, 'default');
	}

	public function http_prepare_download_log() {
		if (isset($_GET['download-log']) && wp_verify_nonce($_GET['nonce'], 'download-log')) {
			$url = wp_parse_url(home_url());
			$host = sanitize_file_name($url['host']);
			$filename = sprintf('%s-diagnostic-log-%s.txt', $host, date('YmdHis'));
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Length: ' . strlen($this->render_diagnostic_info()));
			header('Content-Disposition: attachment; filename=' . $filename);
			ob_clean();
			echo wp_kses($this->render_diagnostic_info(), 'default');
			exit();
		}
	}

	public function render_diagnostic_info($html = '') {
		foreach ($this->get_diagnostic_info() as $section):
			$key_lengths = array_map('strlen', array_keys($section));
			$max_key_length = max($key_lengths);

			foreach ($section as $key => $value):
				if ($key === 0) {
					$html .= $value . "\r\n";
					continue;
				}

				if (is_array($value)) {
					foreach ($value as $subsection => $subval):
						$html .= ' - ';
						if (!preg_match('/^\d+$/', $subsection)) {
							$html .= "$subsection: ";
						}
						$html .= "$subval\r\n";
					endforeach;
					continue;
				}

				if (!preg_match('/^\d+$/', $key)) {
					$pad_chr = '.';
					if ($max_key_length + 6 - strlen($key) < 3) {
						$pad_chr = ' ';
					}
					$html .= str_pad("$key: ", $max_key_length + 6, $pad_chr);
				}

				$html .= " $value\r\n";
			endforeach;
			$html .= "\r\n";
		endforeach;

		return $html;
	}

	public function get_diagnostic_info() {
		global $wpdb;

		$theme_dir = wp_get_theme()->get_stylesheet_directory();
		$parent_theme_dir = wp_get_theme()->get('Template');

		$enable = __('Enabled', 'vnh_textdomain');
		$disable = __('Disabled', 'vnh_textdomain');
		$yes = __('Yes', 'vnh_textdomain');
		$no = __('No', 'vnh_textdomain');
		$not_defined = __('Not defined', 'vnh_textdomain');

		$diagnostic_info = []; // group display sections into arrays

		$diagnostic_info['basic-info'] = [
			'site_url()' => site_url(),
			'home_url()' => home_url(),
		];

		$diagnostic_info['multi_site'] = [
			__('Multisite', 'vnh_textdomain') => is_multisite() ? $yes : $no,
		];

		$diagnostic_info['db-info'] = [
			__('Database Name', 'vnh_textdomain') => $wpdb->dbname,
			__('Table Prefix', 'vnh_textdomain') => $wpdb->base_prefix,
		];

		$response = wp_remote_get(site_url() . '/license.txt');
		$response_code = !is_wp_error($response) && $response['response']['code'] >= 200 && $response['response']['code'] < 300;
		$not_available = __('n/a', 'vnh_textdomain');

		$front_page_id = get_option('page_on_front');
		$blog_page_id = get_option('page_for_posts');
		$front_page_title = sprintf('%s(#%s)', get_the_title($front_page_id), $front_page_id);
		$blog_page_title = sprintf('%s(#%s)', get_the_title($blog_page_id), $blog_page_id);

		$diagnostic_info['wp-version'] = [
			__('WordPress Version', 'vnh_textdomain') => get_bloginfo('version'),
			__('WordPress Remote', 'vnh_textdomain') => $response_code ? __('true', 'vnh_textdomain') : __('false', 'vnh_textdomain'),
			__('Permalink', 'vnh_textdomain') => get_option('permalink_structure'),
		];

		$diagnostic_info['wp-version'][__('Show On Front', 'vnh_textdomain')] = get_option('show_on_front');
		if (get_option('show_on_front') !== 'posts') {
			$diagnostic_info['wp-version'][__('Page On Front', 'vnh_textdomain')] = $front_page_id ? $front_page_title : $not_defined;
			$diagnostic_info['wp-version'][__('Page For Posts', 'vnh_textdomain')] = $blog_page_id ? $blog_page_title : $not_defined;
		}

		$diagnostic_info['wp-version'][__('Total Users', 'vnh_textdomain')] = count(get_users());

		if (wp_script_is('jquery', 'registered')) {
			$diagnostic_info['wp-version'][__('jQuery Version', 'vnh_textdomain')] = wp_scripts()->registered['jquery']->ver;
		}

		$diagnostic_info['post_types'] = [
			__('Registered Post Types', 'vnh_textdomain') => implode(', ', get_post_types()),
		];

		if (defined('WP_ACCESSIBLE_HOSTS') && WP_ACCESSIBLE_HOSTS) {
			$access = sprintf(__('Partially (Accessible Hosts: %s)', 'vnh_textdomain'), WP_ACCESSIBLE_HOSTS);
		} else {
			$access = __('All', 'vnh_textdomain');
		}

		$diagnostic_info['server-info'] = [
			__('Web Server', 'vnh_textdomain') => !empty($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : $not_available,
			__('PHP', 'vnh_textdomain') => function_exists('phpversion') ? PHP_VERSION : $not_available,
			__('WP Memory Limit', 'vnh_textdomain') => WP_MEMORY_LIMIT,
			__('PHP Time Limit', 'vnh_textdomain') => function_exists('ini_get') ? ini_get('max_execution_time') : $not_available,
			__('Blocked External HTTP Requests', 'vnh_textdomain') =>
				!defined('WP_HTTP_BLOCK_EXTERNAL') || !WP_HTTP_BLOCK_EXTERNAL ? __('None', 'vnh_textdomain') : $access,
			'fsockopen' => function_exists('fsockopen') ? $enable : $disable,
			'OpenSSL' => is_open_ssl_enabled() ? OPENSSL_VERSION_TEXT : $disable,
			'cURL' => function_exists('curl_init') ? $enable : $disable,
			__('Opcache Enabled', 'vnh_textdomain') => function_exists('ini_get') && ini_get('opcache.enable') ? $enable : $disable,
		];

		$diagnostic_info['db-server-info'] = [
			'MySQL' => mysqli_get_server_info($wpdb->dbh),
			'ext/mysqli' => !empty($wpdb->use_mysqli) ? __('yes', 'vnh_textdomain') : __('no', 'vnh_textdomain'),
			'WP Locale' => get_locale(),
			'DB Charset' => DB_CHARSET,
		];

		$diagnostic_info['debug-settings'] = [
			__('Debug Mode', 'vnh_textdomain') => defined('WP_DEBUG') && WP_DEBUG ? $yes : $no,
			__('Debug Log', 'vnh_textdomain') => defined('WP_DEBUG_LOG') && WP_DEBUG_LOG ? $yes : $no,
			__('Debug Display', 'vnh_textdomain') => defined('WP_DEBUG_DISPLAY') && WP_DEBUG_DISPLAY ? $yes : $no,
			__('Script Debug', 'vnh_textdomain') => defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? $yes : $no,
			__('PHP Error Log', 'vnh_textdomain') => function_exists('ini_get') ? ini_get('error_log') : $not_available,
		];

		$diagnostic_info['server-limits'] = [
			__('WP Max Upload Size', 'vnh_textdomain') => size_format(wp_max_upload_size()),
			__('PHP Post Max Size', 'vnh_textdomain') => size_format($this->get_post_max_size()),
			__('Max Execution Time', 'vnh_textdomain') => ini_get('max_execution_time'),
			__('Max Input Vars', 'vnh_textdomain') => ini_get('max_input_vars'),
		];

		$diagnostic_info['constants'] = [
			'WP_HOME' => defined('WP_HOME') && WP_HOME ? WP_HOME : $not_defined,
			'WP_SITEURL' => defined('WP_SITEURL') && WP_SITEURL ? WP_SITEURL : $not_defined,
			'WP_CONTENT_URL' => defined('WP_CONTENT_URL') && WP_CONTENT_URL ? WP_CONTENT_URL : $not_defined,
			'WP_CONTENT_DIR' => defined('WP_CONTENT_DIR') && WP_CONTENT_DIR ? WP_CONTENT_DIR : $not_defined,
			'WP_PLUGIN_DIR' => defined('WP_PLUGIN_DIR') && WP_PLUGIN_DIR ? WP_PLUGIN_DIR : $not_defined,
			'WP_PLUGIN_URL' => defined('WP_PLUGIN_URL') && WP_PLUGIN_URL ? WP_PLUGIN_URL : $not_defined,
		];

		$theme_info_log = [
			__('Active Theme Name', 'vnh_textdomain') => PLUGIN_NAME,
			__('Active Theme Folder', 'vnh_textdomain') => $theme_dir,
		];

		if ($parent_theme_dir) {
			$theme_info_log[__('Parent Theme Folder', 'vnh_textdomain')] = $parent_theme_dir;
		}

		if (!file_exists($theme_dir)) {
			$theme_info_log[__('WARNING', 'vnh_textdomain')] = __('Active Theme Folder Not Found', 'vnh_textdomain');
		}

		$diagnostic_info['theme-info'] = $theme_info_log;

		$active_plugins = (array) get_option('active_plugins');
		if (!empty($active_plugins)) {
			$active_plugins_log = [__('Active Plugins:', 'vnh_textdomain')];
			foreach ($active_plugins as $plugin) {
				$active_plugins_log[1][] = get_plugin_details(WP_PLUGIN_DIR . DS . $plugin);
			}
			$diagnostic_info['active-plugins'] = $active_plugins_log;
		}

		return $diagnostic_info;
	}

	public function get_post_max_size() {
		$bytes = max(wp_convert_hr_to_bytes(trim(ini_get('post_max_size'))), wp_convert_hr_to_bytes(trim(ini_get('hhvm.server.max_post_size'))));

		return $bytes;
	}
}
