<?php

use GB\Components\Data\Metadata\Entry\Token;

if(!function_exists('gb_get_entry_token')) {
	/**
	 * Returns the stored number of token accumulated for an entry.
	 *
	 * @param int|WP_Post $entry The entry to return the token for.
	 * @return string The token for the specified entry.
	 */
	function gb_get_entry_token($entry) {
		return apply_filters('gb_get_entry_token', Token::get($entry), $entry);
	}
}

if(!function_exists('gb_set_entry_token')) {
	/**
	 * Stores the number of token accumulated for an entry.
	 *
	 * @param int|WP_Post $entry The entry to set the token for.
	 * @param string $token The token to store for the specified entry.
	 * @return void
	 */
	function gb_set_entry_token($entry, $token) {
		return apply_filters('gb_set_entry_token', Token::set($entry, $token), $entry, $token);
	}
}
