<?php

use GB\Components\ViewsPublic\Types\Giveaway;

if(!defined('ABSPATH')) { exit; }

if(!function_exists('gb_is_giveaway_ended')) {
	/**
	 * Returns true if the giveaway's end datetime is in the past and false otherwise.
	 *
	 * @param int|WP_Post $giveaway The giveaway to query the ending status of.
	 * @return bool True if the giveaway has ended and false otherwise.
	 */
	function gb_is_giveaway_ended($giveaway) {
		$giveaway = gb_get_giveaway($giveaway);

		if(false === $giveaway) { return false; }

		$datetime_end = gb_get_date(gb_get_giveaway_settings($giveaway, 'datetime_end'));
		$datetime_now = gb_get_date();

		return $datetime_now > $datetime_end;
	}
}

if(!function_exists('gb_get_giveaway_entry_context')) {
	/**
	 * Returns the entry within the current context.
	 *
	 * @param int|WP_Post $giveaway The giveaway to retrieve the entry for based on context.
	 * @return false|WP_Post False if there is no entry based on the current context and an
	 * appropriate WP_Post object if one exists.
	 */
	function gb_get_giveaway_entry_context($giveaway = null) {
		$giveaway = is_null($giveaway) ? get_queried_object_id() : $giveaway;
		$giveaway = gb_get_giveaway($giveaway);

		if(false === $giveaway) { return false; }

		$tracking = gb_getcookie(sprintf('%s_%d', GB__COOKIE_NAME__TRACKING, $giveaway->ID), ['email' => '']);
		$address  = gb_get_ipaddress();
		$email    = isset($tracking['email']) ? $tracking['email'] : '';
		$token    = isset($_GET['entry']) ? stripslashes($_GET['entry']) : '';

		return gb_get_entry_existing($giveaway, $address, $email, $token);
	}
}

if(!function_exists('gb_get_giveaway_entry_context_errors')) {
	/**
	 * Returns any errors from the current context.
	 *
	 * @return false|WP_Error False if there are no errors and a WP_Error object with the errors
	 * if there are.
	 */
	function gb_get_giveaway_entry_context_errors() {
		return apply_filters('gb_get_giveaway_entry_context_errors', Giveaway::get_errors());
	}
}

if(!function_exists('gb_get_giveaway_entry_share_url')) {
	/**
	 * Returns the tokenized url for a specific entry's share action.
	 *
	 * @param int|WP_Post $entry The entry to retrieve the share url for.
	 * @return string The share url for the specified entry.
	 */
	function gb_get_giveaway_entry_share_url($entry) {
		$entry = gb_get_entry($entry);

		if(false === $entry) { return home_url('/'); }

		return add_query_arg('token', gb_get_entry_token($entry), get_permalink($entry->post_parent));
	}
}

if(!function_exists('gb_get_giveaway_templates')) {
	/**
	 * Return an array of templates available for use with the Giveaway post type. Each array item
	 * contains the following keys:
	 * - $name string The name of the template
	 * - $image string The url of the preview image for the template
	 * - $controls array An array of controls available for customizing the template
	 * -- $name string The name of the control - must be all lowercase alphanumeric characters or underscores
	 * -- $type string The type of control
	 * -- $selector string The CSS selector that the control styles
	 * -- $property string The property that is controlled by the control
	 * -- $default string The default value for the control
	 * --
	 *
	 * @param bool $reload Whether to reload the templates by bypassing the transient.
	 * @return array An array of templates that are available.
	 */
	function gb_get_giveaway_templates($reload = false) {
		return apply_filters('gb_get_giveaway_templates', Giveaway::get_templates($reload), $reload);
	}
}

if(!function_exists('gb_output_giveaway_body')) {
	/**
	 * Calls `do_action('gb_output_giveaway_body', $giveaway)` so that the plugin
	 * can output giveaway body markup.
	 *
	 * @param int|WP_Post $giveaway The giveaway to output body markup for. Optional.
	 * @return void
	 */
	function gb_output_giveaway_body($giveaway = null) {
		$giveaway = is_null($giveaway) ? get_queried_object_id() : $giveaway;
		$giveaway = gb_get_giveaway($giveaway);

		if(false === $giveaway) { return; }

		do_action('gb_output_giveaway_body', $giveaway);
	}
}

if(!function_exists('gb_output_giveaway_entry_methods')) {
	/**
	 * Calls `do_action('gb_output_giveaway_entry_methods', $giveaway)` so that the plugin can
	 * output entry method markup.
	 *
	 * @param int|WP_Post $giveaway The giveaway to output markup for. Optional.
	 * @return void
	 */
	function gb_output_giveaway_entry_methods($giveaway = null) {
		$giveaway = is_null($giveaway) ? get_queried_object_id() : $giveaway;
		$giveaway = gb_get_giveaway($giveaway);

		if(false === $giveaway) { return; }

		do_action('gb_output_giveaway_entry_methods', $giveaway);
	}
}
