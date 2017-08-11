<?php

use GB\Components\Data\Metadata\Entry\TrackingName;

if(!function_exists('gb_get_entry_tracking_name')) {
	/**
	 * Returns the stored tracking name for an entry.
	 *
	 * @param int|WP_Post $entry The entry to return the name for.
	 * @return string The name for the specified entry.
	 */
	function gb_get_entry_tracking_name($entry) {
		return apply_filters('gb_get_entry_tracking_name', TrackingName::get($entry), $entry);
	}
}

if(!function_exists('gb_set_entry_tracking_name')) {
	/**
	 * Stores the tracking name for an entry.
	 *
	 * @param int|WP_Post $entry The entry to set the name for.
	 * @param string $name The name to store for the specified entry.
	 * @return void
	 */
	function gb_set_entry_tracking_name($entry, $name) {
		return apply_filters('gb_set_entry_tracking_name', TrackingName::set($entry, $name), $entry, $name);
	}
}
