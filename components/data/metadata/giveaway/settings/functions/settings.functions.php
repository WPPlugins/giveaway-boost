<?php

use GB\Components\Data\Metadata\Giveaway\Settings;

if(!function_exists('gb_get_giveaway_settings')) {
	/**
	 * Returns the default settings data as an assocative array.
	 *
	 * @return mixed An associative array of default settings data.
	 */
	function gb_get_giveaway_settings_defaults() {
		return apply_filters('gb_get_giveaway_settings_defaults', Settings::get_defaults());
	}
}

if(!function_exists('gb_get_giveaway_settings')) {
	/**
	 * Returns the stored settings data as an assocative array with varying keys.
	 *
	 * @param int|WP_Post $giveaway The giveaway to return settings for.
	 * @param string $key A particular setting to retrieve. Optional.
	 * @return mixed An associative array of settings data or a single value if $key is provided.
	 */
	function gb_get_giveaway_settings($giveaway, $key = null) {
		return apply_filters('gb_get_giveaway_settings', Settings::get($giveaway, $key), $giveaway, $key);
	}
}

if(!function_exists('gb_set_giveaway_settings')) {
	/**
	 * Stores sanitized settings data.
	 *
	 * @param int|WP_Post $giveaway The giveaway to set settings for.
	 * @param array $settings An associative array of settings data to store.
	 * @return void
	 */
	function gb_set_giveaway_settings($giveaway, array $settings) {
		return apply_filters('gb_set_giveaway_settings', Settings::set($giveaway, $settings), $giveaway, $settings);
	}
}
