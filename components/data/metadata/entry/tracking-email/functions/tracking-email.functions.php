<?php

use GB\Components\Data\Metadata\Entry\TrackingEmail;

if(!function_exists('gb_get_entry_tracking_email')) {
	/**
	 * Returns the stored tracking email for an entry.
	 *
	 * @param int|WP_Post $entry The entry to return the email for.
	 * @return string The email for the specified entry.
	 */
	function gb_get_entry_tracking_email($entry) {
		return apply_filters('gb_get_entry_tracking_email', TrackingEmail::get($entry), $entry);
	}
}

if(!function_exists('gb_set_entry_tracking_email')) {
	/**
	 * Stores the tracking email for an entry.
	 *
	 * @param int|WP_Post $entry The entry to set the email for.
	 * @param string $email The email to store for the specified entry.
	 * @return void
	 */
	function gb_set_entry_tracking_email($entry, $email) {
		return apply_filters('gb_set_entry_tracking_email', TrackingEmail::set($entry, $email), $entry, $email);
	}
}
