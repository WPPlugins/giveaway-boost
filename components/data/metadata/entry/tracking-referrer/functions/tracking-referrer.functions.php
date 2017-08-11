<?php

use GB\Components\Data\Metadata\Entry\TrackingReferrer;

if(!function_exists('gb_get_entry_tracking_referrer')) {
	/**
	 * Returns the stored tracking referrer for an entry.
	 *
	 * @param int|WP_Post $entry The entry to return the referrer for.
	 * @return string The referrer for the specified entry.
	 */
	function gb_get_entry_tracking_referrer($entry) {
		return apply_filters('gb_get_entry_tracking_referrer', TrackingReferrer::get($entry), $entry);
	}
}

if(!function_exists('gb_set_entry_tracking_referrer')) {
	/**
	 * Stores the tracking referrer for an entry.
	 *
	 * @param int|WP_Post $entry The entry to set the referrer for.
	 * @param int $referrer The referrer to store for the specified entry. Must correspond to an entry's id.
	 * @return void
	 */
	function gb_set_entry_tracking_referrer($entry, $referrer) {
		return apply_filters('gb_set_entry_tracking_referrer', TrackingReferrer::set($entry, $referrer), $entry, $referrer);
	}
}
