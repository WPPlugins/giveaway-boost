<?php

namespace GB\Components\ViewsAdmin\SettingsSections;

if(!defined('ABSPATH')) { exit; }

class Recaptcha {
	public static function init() {
		self::add_actions();
		self::add_filters();
	}

	private static function add_actions() {
		if(is_admin()) {
			add_action('\GB\Components\ViewsAdmin\Settings::load', [__CLASS__, 'add_controls'], 20);
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
		add_settings_section(GB__PAGE_SECT__RECAPTCHA, __('Google reCAPTCHA'), [__CLASS__, 'display'], $slug);

		add_settings_field('recaptcha_sitekey', __('Site Key'), [__CLASS__, 'field_recaptcha_sitekey'], $slug, GB__PAGE_SECT__RECAPTCHA, [
			'label_for' => gb_get_setting_field_id('recaptcha_sitekey'),
		]);

		add_settings_field('recaptcha_secretkey', __('Secret Key'), [__CLASS__, 'field_recaptcha_secretkey'], $slug, GB__PAGE_SECT__RECAPTCHA, [
			'label_for' => gb_get_setting_field_id('recaptcha_secretkey'),
		]);
	}

	public static function display() {
		printf('<p>%s</p>', __('If you would like to use Google\'s reCAPTCHA for entry verification, please enter your reCAPTCHA credentials below.'));
	}

	#endregion Settings Section

	#region Settings Fields

	public static function field_recaptcha_sitekey($args) {
		printf('<input type="text" class="code large-text" id="%s" name="%s" %s value="%s" />', esc_attr(gb_get_setting_field_id('recaptcha_sitekey')), esc_attr(gb_get_setting_field_name('recaptcha_sitekey')), (defined('GB__CONF__RECAPTCHA_SITEKEY') ? 'readonly="readonly"' : ''), esc_attr(gb_get_settings('recaptcha_sitekey')));
		printf('<p class="description"><a href="%s" target="_blank">%s</a> %s</p>', esc_url('https://developers.google.com/recaptcha/'), esc_html__('Click here'), esc_html__('to set up or retrieve your Google reCAPTCHA credentials'));
	}

	public static function field_recaptcha_secretkey($args) {
		printf('<input type="text" class="code large-text" id="%s" name="%s" %s value="%s" />', esc_attr(gb_get_setting_field_id('recaptcha_secretkey')), esc_attr(gb_get_setting_field_name('recaptcha_secretkey')), (defined('GB__CONF__RECAPTCHA_SECRETKEY') ? 'readonly="readonly"' : ''), esc_attr(gb_get_settings('recaptcha_secretkey')));
	}

	#endregion Settings Fields

	#region Settings

	public static function add_defaults($defaults) {
		$defaults['recaptcha_sitekey']   = defined('GB__CONF__RECAPTCHA_SITEKEY')   ? GB__CONF__RECAPTCHA_SITEKEY   : '';
		$defaults['recaptcha_secretkey'] = defined('GB__CONF__RECAPTCHA_SECRETKEY') ? GB__CONF__RECAPTCHA_SECRETKEY : '';

		return $defaults;
	}

	public static function sanitize_settings($settings, $settings_raw, $settings_defaults) {
		$settings['recaptcha_sitekey']   = defined('GB__CONF__RECAPTCHA_SITEKEY')   ? GB__CONF__RECAPTCHA_SITEKEY   : (isset($settings['recaptcha_sitekey'])   ? trim($settings['recaptcha_sitekey'])   : '');
		$settings['recaptcha_secretkey'] = defined('GB__CONF__RECAPTCHA_SECRETKEY') ? GB__CONF__RECAPTCHA_SECRETKEY : (isset($settings['recaptcha_secretkey']) ? trim($settings['recaptcha_secretkey']) : '');

		return $settings;
	}

	#endregion Settings
}

Recaptcha::init();
