<?php

namespace GB\Components\ViewsAdmin;

if(!defined('ABSPATH')) { exit; }

class Settings {
	public static function init() {
		self::add_actions();
		self::add_filters();
	}

	private static function add_actions() {
		if(is_admin()) {
			add_action('admin_menu', [__CLASS__, 'register'], 100);
		} else {

		}

	}

	private static function add_filters() {
		if(is_admin()) {

		} else {

		}

	}

	#region Page Display

	public static function display() {
		$settings = gb_get_settings();
		$errors   = $settings['errors'];

		include(path_join(dirname(__FILE__), 'templates/settings.page.php'));
	}

	#endregion Page Display

	#region Page Load

	public static function load() {
		wp_enqueue_script('gb_resources_admin');
		wp_enqueue_style('gb_resources_admin');

		do_action('\GB\Components\ViewsAdmin\Settings::load', GB__PAGE_SLUG__SETTINGS);
	}

	#endregion Page Load

	#region Page Registration

	public static function register() {
		$page = add_submenu_page(sprintf('edit.php?post_type=%s', GB__DATA_TYPE__GIVEAWAY), __('Giveaways - Settings'), __('Settings'), GB__USER_CAPS__SETTINGS, GB__PAGE_SLUG__SETTINGS, [__CLASS__, 'display']);

		add_action("load-{$page}", [__CLASS__, 'load']);
	}

	#endregion Page Registration

	#region Public API

	public static function get_field_id($setting_name) {
		return sprintf('%s-%s', GB__DATA_OPTS__SETTINGS, $setting_name);
	}

	public static function get_field_name($setting_name, $multiple = false) {
		return sprintf('%s[%s]%s', GB__DATA_OPTS__SETTINGS, $setting_name, ($multiple ? '[]' : ''));
	}

	public static function get_url(array $query_args) {
		return add_query_arg(array_merge($query_args, [
			'post_type' => GB__DATA_TYPE__GIVEAWAY,
			'page'      => GB__PAGE_SLUG__SETTINGS,
		]), admin_url('edit.php'));
	}

	#endregion Public API
}

require_once(path_join(dirname(__FILE__), 'functions/settings.functions.php'));

Settings::init();
