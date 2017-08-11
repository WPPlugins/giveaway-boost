<?php

namespace GB\Components\ViewsAdmin\SettingsSections;

if(!defined('ABSPATH')) { exit; }

class Content {
	public static function init() {
		self::add_actions();
		self::add_filters();
	}

	private static function add_actions() {
		if(is_admin()) {
			add_action('\GB\Components\ViewsAdmin\Settings::load', [__CLASS__, 'add_controls'], 22);
		} else {

		}

	}

	private static function add_filters() {
		if(is_admin()) {

		} else {

		}

		add_filter('\GB\Components\Data\Options\Settings::get_defaults', [__CLASS__, 'add_defaults']);
		add_filter('\GB\Components\Data\Options\Settings::sanitize',     [__CLASS__, 'sanitize_settings'], 11, 3);
	}

	#region Settings Section

	public static function add_controls($slug) {
		add_settings_section(GB__PAGE_SECT__CONTENT, __('Giveaway Content'), [__CLASS__, 'display'], $slug);

		add_settings_field('disclaimer', __('Giveaway Rules'), [__CLASS__, 'field_disclaimer'], $slug, GB__PAGE_SECT__CONTENT, [
			'label_for' => gb_get_setting_field_id('disclaimer'),
		]);
	}

	public static function display() {
		printf('<p>%s</p>', __('Your giveaway rules are presented with every giveaway. This setting applies site wide.'));
	}

	#endregion Settings Section

	#region Settings Fields

	public static function field_disclaimer($args) {
		$field_id    = gb_get_setting_field_id('disclaimer');
		$field_name  = gb_get_setting_field_name('disclaimer');
		$field_value = gb_get_settings('disclaimer');

		wp_editor($field_value, $field_id, [
			'textarea_name' => $field_name,
			'textarea_rows' => 10,
			'media_buttons' => false,
		]);
	}

	#endregion Settings Fields

	#region Settings

	public static function add_defaults($defaults) {
		$defaults['disclaimer'] = '';

		return $defaults;
	}

	public static function sanitize_settings($settings, $settings_raw, $settings_defaults) {
		$settings['disclaimer'] = isset($settings['disclaimer']) ? wp_kses_post($settings['disclaimer']) : $settings_defaults['disclaimer'];

		return $settings;
	}

	#endregion Settings
}

Content::init();
