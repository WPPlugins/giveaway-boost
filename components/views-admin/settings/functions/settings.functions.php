<?php

use GB\Components\ViewsAdmin\Settings;

if(!defined('ABSPATH')) { exit; }

if(!function_exists('gb_get_setting_field_id')) {
	/**
	 * Returns a string used to uniquely identify a field for a particular setting.
	 *
	 * @param string $setting_name The name of the setting to retrieve the field id for.
	 * @return string The id of the field in question.
	 */
	function gb_get_setting_field_id($setting_name) {
		return apply_filters('gb_get_setting_field_id', Settings::get_field_id($setting_name), $setting_name);
	}
}

if(!function_exists('gb_get_setting_field_name')) {
	/**
	 * Returns a string used to name a field for a particular setting.
	 *
	 * @param string $setting_name The name of the setting to retrieve the field name for.
	 * @param bool $multiple True if the setting name should account for multiple fields. Optional.
	 * @return string The name of the field in question.
	 */
	function gb_get_setting_field_name($setting_name, $multiple = false) {
		return apply_filters('gb_get_setting_field_name', Settings::get_field_name($setting_name, $multiple), $setting_name, $multiple);
	}
}

if(!function_exists('gb_get_settings_url')) {
	/**
	 * Returns an unescaped URL for navigation to the "Giveaways > Settings" page.
	 *
	 * @param array $query_args An array of query arguments to add to the URL. Optional.
	 * @return string The URL of the "Giveaways > Settings" page, with any optional query arguments added.
	 */
	function gb_get_settings_url(array $query_args = []) {
		return apply_filters('gb_get_settings_url', Settings::get_url($query_args), $query_args);
	}
}
