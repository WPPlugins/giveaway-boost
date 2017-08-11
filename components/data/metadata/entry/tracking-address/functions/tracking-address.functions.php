<?php

use GB\Components\Data\Metadata\Entry\TrackingAddress;

if(!function_exists('gb_get_entry_tracking_address')) {
	/**
	 * Returns the stored tracking address for an entry.
	 *
	 * @param int|WP_Post $entry The entry to return the address for.
	 * @return string The address for the specified entry.
	 */
	function gb_get_entry_tracking_address($entry) {
		return apply_filters('gb_get_entry_tracking_address', TrackingAddress::get($entry), $entry);
	}
}

if(!function_exists('gb_set_entry_tracking_address')) {
	/**
	 * Stores the tracking address for an entry.
	 *
	 * @param int|WP_Post $entry The entry to set the address for.
	 * @param string $address The address to store for the specified entry.
	 * @return void
	 */
	function gb_set_entry_tracking_address($entry, $address) {
		return apply_filters('gb_set_entry_tracking_address', TrackingAddress::set($entry, $address), $entry, $address);
	}
}
