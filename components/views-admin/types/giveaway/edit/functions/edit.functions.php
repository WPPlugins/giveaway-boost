<?php

use GB\Components\ViewsAdmin\Types\Giveaway\Edit;

if(!defined('ABSPATH')) { exit; }

if(!function_exists('gb_get_giveaway_setting_field_id')) {
	/**
	 * Returns a string used to uniquely identify a field for a particular giveaway setting.
	 *
	 * @param string $setting_name The name of the giveaway setting to retrieve the field id for.
	 * @return string The id of the field in question.
	 */
	function gb_get_giveaway_setting_field_id($setting_name) {
		return apply_filters('gb_get_giveaway_setting_field_id', Edit::get_field_id($setting_name), $setting_name);
	}
}

if(!function_exists('gb_get_giveaway_setting_field_name')) {
	/**
	 * Returns a string used to name a field for a particular giveaway setting.
	 *
	 * @param string $setting_name The name of the giveaway setting to retrieve the field name for.
	 * @param bool $multiple True if the giveaway setting name should account for multiple fields. Optional.
	 * @return string The name of the field in question.
	 */
	function gb_get_giveaway_setting_field_name($setting_name, $multiple = false) {
		return apply_filters('gb_get_giveaway_setting_field_name', Edit::get_field_name($setting_name, $multiple), $setting_name, $multiple);
	}
}

if(!function_exists('gb_get_giveaway_template_controls')) {
	/**
	 * Returns an array of table rows markup containing controls for the specificed giveaway and template.
	 *
	 * @param int|WP_Post $giveaway The giveaway to return controls for.
	 * @param array $template The template to return controls for.
	 * @return array An array of table rows markup.
	 */
	function gb_get_giveaway_template_controls($giveaway, $template) {
		return apply_filters('gb_get_giveaway_template_controls', Edit::get_template_controls($giveaway, $template), $giveaway, $template);
	}
}
