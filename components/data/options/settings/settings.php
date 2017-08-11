<?php

namespace GB\Components\Data\Options;

if(!defined('ABSPATH')) { exit; }

class Settings {
	public static function init() {
		self::add_actions();
		self::add_filters();
	}

	private static function add_actions() {
		if(is_admin()) {
			add_action('admin_init', [__CLASS__, 'register']);
		} else {

		}

	}

	private static function add_filters() {
		if(is_admin()) {

		} else {

		}

		add_filter(sprintf('pre_update_option_%s', GB__DATA_OPTS__SETTINGS), [__CLASS__, 'timestamped'], 10);
	}

	#region Registration and Callbacks

	public static function register() {
		register_setting(GB__PAGE_SLUG__SETTINGS, GB__DATA_OPTS__SETTINGS, [
			'sanitize_callback' => [__CLASS__, 'sanitize'],
			'type'              => 'array',
		]);
	}

	public static function sanitize($settings) {
		$settings = is_array($settings) ? $settings : [];
		$defaults = gb_get_settings_defaults();
		$settings = apply_filters('\GB\Components\Data\Options\Settings::sanitize', $settings, $settings, $defaults);

		return shortcode_atts($defaults, $settings);
	}

	public static function timestamped($value) {
		if(is_array($value)) {
			$value['timestamp'] = gb_get_date()->getTimestamp();
		}

		return $value;
	}

	#endregion Registration and Callbacks

	#region Public API

	public static function get_defaults() {
		return apply_filters('\GB\Components\Data\Options\Settings::get_defaults', [
			'errors' => [],
		]);
	}

	public static function get($key) {
		$settings = get_option(GB__DATA_OPTS__SETTINGS, gb_get_settings_defaults());

		if(is_null($key)) {
			return $settings;
		} else {
			return gb_deep_access($settings, $key);
		}
	}

	public static function set($settings) {
		update_option(GB__DATA_OPTS__SETTINGS, $settings);
	}

	#endregion Public API
}

require_once(path_join(dirname(__FILE__), 'functions/settings.functions.php'));

Settings::init();
