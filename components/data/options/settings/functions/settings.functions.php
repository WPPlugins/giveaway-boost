<?php

use GB\Components\Data\Options\Settings;

if(!function_exists('gb_get_settings')) {
	/**
	 * Returns the default settings data as an assocative array.
	 *
	 * @return mixed An associative array of default settings data.
	 */
	function gb_get_settings_defaults() {
		return apply_filters('gb_get_settings_defaults', Settings::get_defaults());
	}
}

if(!function_exists('gb_get_settings')) {
	/**
	 * Returns the stored settings data as an assocative array with varying keys.
	 *
	 * @param string $key A particular setting to retrieve. Optional.
	 * @return mixed An associative array of settings data or a single value if $key is provided.
	 */
	function gb_get_settings($key = null) {
		return apply_filters('gb_get_settings', Settings::get($key), $key);
	}
}

if(!function_exists('gb_set_settings')) {
	/**
	 * Stores sanitized settings data.
	 *
	 * @param $settings array An associative array of settings data to store.
	 * @return void
	 */
	function gb_set_settings(array $settings) {
		return apply_filters('gb_set_settings', Settings::set($settings), $settings);
	}
}
