<?php

use GB\Components\Data\Metadata\Entry\Chances;

if(!function_exists('gb_add_entry_chances')) {
	/**
	 * Adds the specified number of chances to the stored number of chances accumulated for an entry.
	 *
	 * @param int|WP_Post $entry The entry to add chances to.
	 * @param int $chances The number of chances to add to the stored chances for the specified entry.
	 * @return void
	 */
	function gb_add_entry_chances($entry, $chances) {
		return apply_filters('gb_add_entry_chances', gb_set_entry_chances($entry, gb_get_entry_chances($entry) + $chances), $entry);
	}
}

if(!function_exists('gb_get_entry_chances')) {
	/**
	 * Returns the stored number of chances accumulated for an entry.
	 *
	 * @param int|WP_Post $entry The entry to return the chances for.
	 * @return int The chances for the specified entry.
	 */
	function gb_get_entry_chances($entry) {
		return apply_filters('gb_get_entry_chances', Chances::get($entry), $entry);
	}
}

if(!function_exists('gb_set_entry_chances')) {
	/**
	 * Stores the number of chances accumulated for an entry.
	 *
	 * @param int|WP_Post $entry The entry to set the chances for.
	 * @param int $chances The chances to store for the specified entry.
	 * @return void
	 */
	function gb_set_entry_chances($entry, $chances) {
		return apply_filters('gb_set_entry_chances', Chances::set($entry, $chances), $entry, $chances);
	}
}
