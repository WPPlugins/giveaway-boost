<?php

use GB\Components\Data\Metadata\Entry\Winner;

if(!function_exists('gb_is_entry_winner')) {
	/**
	 * Returns true if an entry is a giveaway winner and false otherwise.
	 *
	 * @param int|WP_Post $entry The entry to check the winning status for.
	 * @return bool True if the entry is a winner and false otherwise.
	 */
	function gb_is_entry_winner($entry) {
		return apply_filters('gb_is_entry_winner', Winner::is($entry), $entry);
	}
}

if(!function_exists('gb_set_entry_winner')) {
	/**
	 * Stores the winning status for a specified entry.
	 *
	 * @param int|WP_Post $entry The entry to set the winning status for.
	 * @param bool $winner True if the entry is a winner and false otherwise.
	 * @return void
	 */
	function gb_set_entry_winner($entry, $winner) {
		return apply_filters('gb_set_entry_winner', Winner::set($entry, $winner), $entry, $winner);
	}
}
