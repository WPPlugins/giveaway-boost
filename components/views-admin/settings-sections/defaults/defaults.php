<?php

namespace GB\Components\ViewsAdmin\SettingsSections;

if(!defined('ABSPATH')) { exit; }

class Defaults {
	public static function init() {
		self::add_actions();
		self::add_filters();
	}

	private static function add_actions() {
		if(is_admin()) {
			add_action('\GB\Components\ViewsAdmin\Settings::load', [__CLASS__, 'add_controls'], 15);
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
		add_settings_section(GB__PAGE_SECT__DEFAULTS, __('Giveaway Defaults'), [__CLASS__, 'display'], $slug);

		add_settings_field('default_verification', __('Require Verification'), [__CLASS__, 'field_default_verification'], $slug, GB__PAGE_SECT__DEFAULTS, [
			'label_for' => gb_get_setting_field_id('default_verification'),
		]);
	}

	public static function display() {
		printf('<p>%s</p>', __('Set your defaults for newly created giveaways. Existing giveaways will not be effected by changes to these settings.'));
	}

	#endregion Settings Section

	#region Settings Fields

	public static function field_default_verification($args) {
		$field_id    = gb_get_setting_field_id('default_verification');
		$field_name  = gb_get_setting_field_name('default_verification');
		$field_value = gb_get_settings('default_verification');

		printf('<input type="hidden" name="%s" value="n" />', esc_attr($field_name));
		printf('<label><input type="checkbox" %s id="%s" name="%s" value="y" /> %s</label>', checked('y', $field_value, false), esc_attr($field_id), esc_attr($field_name), esc_html__('Require entry verification using Google reCAPTCHA'));
		printf('<p class="description"><strong>%s:</strong> %s</p>', esc_html__('Important'), esc_html__('You must provide your Google reCAPTCHA credentials to enable entry verification'));
	}

	#endregion Settings Fields

	#region Settings

	public static function add_defaults($defaults) {
		$defaults['default_verification'] = 'n';

		return $defaults;
	}

	public static function sanitize_settings($settings, $settings_raw, $settings_defaults) {
		$settings['default_verification'] = isset($settings['default_verification']) && in_array($settings['default_verification'], ['n', 'y']) ? $settings['default_verification'] : $settings_defaults['default_verification'];

		return $settings;
	}

	#endregion Settings
}

Defaults::init();
