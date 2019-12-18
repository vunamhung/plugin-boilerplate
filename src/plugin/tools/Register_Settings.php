<?php

namespace vnh_namespace\tools;

defined('WPINC') || die();

use vnh_namespace\tools\contracts\Bootable;
use vnh_namespace\tools\contracts\Initable;
use vnh_namespace\tools\contracts\Renderable;
use const vnh_namespace\PLUGIN_SLUG;

abstract class Register_Settings implements Initable, Bootable, Renderable {
	public $default_settings;
	public $setting_fields;
	public static $option_name = PLUGIN_SLUG . '_settings';

	public function __construct() {
		$this->setting_fields = apply_filters('vnh_prefix/settings', $this->register_setting_fields());
	}

	public function init() {
		if (!empty($this->default_settings) && empty(get_option(self::$option_name))) {
			add_option(self::$option_name, apply_filters('vnh_prefix/settings/defaults', $this->default_settings));
		}
	}

	public function boot() {
		add_action('admin_init', [$this, 'build_settings']);
	}

	public function __toString() {
		return $this->render();
	}

	public function render() {
		$html = '<div class="settings info-tab-content">';
		$html .= '<form method="post" action="options.php" id="settings-tab" enctype="multipart/form-data">';
		ob_start();
		foreach ($this->setting_fields as $section => $values) {
			$option_group = PLUGIN_SLUG . '_settings_' . $section;
			$page = $option_group;
			settings_fields($option_group);
			do_settings_sections($page);
		}
		$html .= ob_get_clean();
		$html .= get_submit_button();
		$html .= '</form>';
		$html .= '</div>';
		$html .= '<div id="saveResult"></div>';

		return $html;
	}

	abstract public function register_setting_fields();

	public function build_settings() {
		if (empty($this->setting_fields)) {
			return;
		}

		foreach ($this->setting_fields as $section_id => $section_values) {
			$section = $option_group = $page = PLUGIN_SLUG . '_settings_' . $section_id;

			$callback = function () use ($section_values) {
				if (!empty($section_values['description'])) {
					printf('<p class="subheading">%s</p>', esc_html($section_values['description']));
				}
			};
			$title = !empty($section_values['title']) ? $section_values['title'] : null;
			add_settings_section($section, $title, $callback, $page);

			register_setting($option_group, self::$option_name);

			if (empty($section_values['fields'])) {
				return;
			}

			foreach ($section_values['fields'] as $field) {
				$id = sprintf('%s[%s]', self::$option_name, $field['id']);
				$args['field'] = $field;

				add_settings_field($id, esc_html($field['name']), [$this, 'display_field'], $page, $section, $args);
			}
		}
	}

	/**
	 * Output setting field
	 *
	 * @param $args
	 * @uses display_field_toggle(), display_field_text(), display_field_textarea(), display_field_select(), display_field_number(), display_field_repeater()
	 */
	public function display_field($args) {
		$field = $args['field'];

		$option = get_option(self::$option_name);
		$display_field = "display_field_{$field['type']}";

		if (method_exists($this, $display_field)) {
			$this->$display_field($field, $option);
		}
	}

	public function display_field_toggle($field, $option) {
		$description = !empty($field['description'])
			? sprintf('<a class="hint--top hint--medium" aria-label="%s"><span class="woocommerce-help-tip"></span></a>', $field['description'])
			: null;
		$label =
			'<label for="%1$s" class="toggle"><span><svg width="10px" height="10px" ><path d="M5,1 L5,1 C2.790861,1 1,2.790861 1,5 L1,5 C1,7.209139 2.790861,9 5,9 L5,9 C7.209139,9 9,7.209139 9,5 L9,5 C9,2.790861 7.209139,1 5,1 L5,9 L5,1 Z"></path></svg></span></label>';

		$output = sprintf(
			$description . '<input type="checkbox" name="%1$s" class="input-toggle" id="%1$s" value="true" %2$s/>' . $label,
			$this->get_name_attr($field),
			!empty($option[$field['id']]) ? 'checked' : null
		);

		echo $output;
	}

	public function display_field_text($field, $option) {
		$description = !empty($field['description'])
			? sprintf('<a class="hint--top hint--medium" aria-label="%s"><span class="woocommerce-help-tip"></span></a>', $field['description'])
			: null;

		$output = sprintf(
			$description . '<input type="text" name="%1$s" id="%1$s" %3$s value="%2$s"/>',
			$this->get_name_attr($field),
			!empty($option[$field['id']]) ? esc_attr($option[$field['id']]) : null,
			$this->get_custom_attribute_html($field)
		);

		echo $output;
	}

	public function display_field_textarea($field, $option) {
		$description = !empty($field['description'])
			? sprintf('<a class="hint--top hint--medium" aria-label="%s"><span class="woocommerce-help-tip"></span></a>', $field['description'])
			: null;

		$output = sprintf(
			$description . '<textarea name="%1$s" id="%1$s" %3$s >%2$s</textarea>',
			$this->get_name_attr($field),
			!empty($option[$field['id']]) ? esc_attr($option[$field['id']]) : null,
			$this->get_custom_attribute_html($field)
		);

		echo $output;
	}

	public function display_field_select($field, $option) {
		$description = !empty($field['description'])
			? sprintf('<a class="hint--top hint--medium" aria-label="%s"><span class="woocommerce-help-tip"></span></a>', $field['description'])
			: null;

		$options = '';
		foreach ($field['options'] as $value => $label) {
			$options .= sprintf(
				'<option %1$s value="%2$s">%3$s</option>',
				isset($option[$field['id']]) && $option[$field['id']] === $value ? 'selected="selected"' : '',
				$value,
				$label
			);
		}
		$output = sprintf(
			$description . '<select type="text" name="%1$s" id="%1$s" %2$s>%3$s</select>',
			$this->get_name_attr($field),
			!empty($field['placeholder']) ? sprintf('placeholder="%s"', esc_attr($field['placeholder'])) : null,
			$options
		);

		echo $output;
	}

	public function display_field_number($field, $option) {
		$description = !empty($field['description'])
			? sprintf('<a class="hint--top hint--medium" aria-label="%s"><span class="woocommerce-help-tip"></span></a>', $field['description'])
			: null;

		$output = sprintf(
			$description . '<input type="number" name="%1$s" id="%1$s" %3$s %4$s %5$s %6$s value="%2$s"/>',
			$this->get_name_attr($field),
			isset($option[$field['id']]) ? esc_attr($option[$field['id']]) : null,
			isset($field['options']['min']) ? sprintf('min="%s"', esc_attr($field['options']['min'])) : null,
			isset($field['options']['max']) ? sprintf('max="%s"', esc_attr($field['options']['max'])) : null,
			isset($field['options']['step']) ? sprintf('step="%s"', esc_attr($field['options']['step'])) : null,
			!empty($field['placeholder']) ? sprintf('placeholder="%s"', esc_attr($field['placeholder'])) : null
		);

		echo $output;
	}

	public function display_field_repeater($field, $option) {
		$html = '<table class="repeat-table wp-list-table widefat striped">';
		$html .= '<colgroup>';
		foreach ($field['children'] as $child) {
			$html .= sprintf('<col span="1" style="width: %s%s">', $child['width'], '%');
		}
		$html .= '</colgroup>';
		$html .= '<thead><tr>';
		$html .= '<thead><tr>';

		foreach ($field['children'] as $child) {
			$html .= sprintf(
				'<th>%s %s</th>',
				$child['title'],
				!empty($child['description'])
					? sprintf(
						'<a class="hint--top hint--medium" aria-label="%s"><span class="woocommerce-help-tip"></span></a>',
						$child['description']
					)
					: null
			);
		}

		$html .= sprintf('<th>%s</th>', __('Action', 'vnh_textdomain'));
		$html .= '</tr></thead>';
		$html .= sprintf('<tbody data-repeater-list="%s[%s]">', self::$option_name, $field['id']);

		if (!empty($option[$field['id']])) {
			foreach ($option[$field['id']] as $index => $value) {
				$html .= $this->build_repeat_field($field, $option, $index);
			}
		} else {
			$html .= $this->build_repeat_field($field, $option, 0);
		}
		$html .= '</tbody>';
		$html .= '<tfoot><tr><th class="add-row">';
		$html .= sprintf(
			'<input data-repeater-create type="button" class="button button-primary" value="%s"/>',
			$field['options']['add_button']
		);
		$html .= '</th></tr></tfoot>';
		$html .= '</table>';

		echo $html;
	}

	protected function build_repeat_field($field, $option, $index) {
		$html = '<tr class="repeating" data-repeater-item>';
		foreach ($field['children'] as $key => $child) {
			$html .= sprintf('<td class="%s">', $child['type']);
			switch ($child['type']) {
				case 'text':
					$html .= sprintf(
						'<input type="text" name="%s" value="%s"/>',
						$key,
						!empty($option[$field['id']][$index][$key]) ? $option[$field['id']][$index][$key] : null
					);

					break;
				case 'checkbox':
					$html .= sprintf(
						'<input type="checkbox" name="%s" value="true" %s/>',
						$key,
						!empty($option[$field['id']][$index][$key]) ? 'checked' : null
					);

					break;
				case 'select':
					$options = '';
					foreach ($child['options'] as $value => $label) {
						$options .= sprintf(
							'<option %s value="%s">%s</option>',
							isset($option[$field['id']][$index][$key]) && $option[$field['id']][$index][$key] === $value ? 'selected' : '',
							$value,
							$label
						);
					}
					$html .= sprintf(
						'<select class="select" name="%s" %s>%s</select>',
						$key,
						!empty($child['placeholder']) ? sprintf('placeholder="%s"', esc_attr($child['placeholder'])) : null,
						$options
					);

					break;
				case 'number':
					$html .= sprintf(
						'<input type="number" min="0" max="100" name="%s" value="%s" %s/>',
						$key,
						!empty($option[$field['id']][$index][$key]) ? $option[$field['id']][$index][$key] : null,
						$this->get_custom_attribute_html($child)
					);

					break;
			}
			$html .= '</td>';
		}
		$html .= '<td><input data-repeater-delete type="button" class="button button-secondary" value="Delete"/></td>';
		$html .= '</tr>';

		return $html;
	}

	protected function get_name_attr($field) {
		return sprintf('%s[%s]', self::$option_name, esc_html($field['id']));
	}

	protected function get_custom_attribute_html($data) {
		$custom_attributes = array();

		if (!empty($data['custom_attributes']) && is_array($data['custom_attributes'])) {
			foreach ($data['custom_attributes'] as $attribute => $attribute_value) {
				$custom_attributes[] = esc_attr($attribute) . '="' . esc_attr($attribute_value) . '"';
			}
		}

		return implode(' ', $custom_attributes);
	}

	public static function get_option($id) {
		return get_option(self::$option_name)[$id];
	}
}
