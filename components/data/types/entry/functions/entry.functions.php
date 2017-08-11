<?php

use GB\Components\Data\Types\Entry;

if(!defined('ABSPATH')) { exit; }

if(!function_exists('gb_create_entry')) {
	/**
	 * Creates and returns an entry for a giveaway and specific set of tracking
	 * information. If an entry already exists for a giveaway and tracking email or
	 * IP address, then returns that entry instead of creating a new one. Returns
	 * false if any of the parameters are invalid.
	 *
	 * @param int|WP_Post $giveaway The giveaway to create the entry for.
	 * @param string $address The IP address to use for tracking.
	 * @param string $email The email to use for tracking.
	 * @param string $name The name to use for tracking.
	 * @param WP_Post|int $referrer The entry that referred the entry being created.
	 * @param int $chances The number of chances to award initially.
	 * @return WP_Post|WP_Error An entry object if one is found or created and a WP_Error object if anything is invalid.
	 */
	function gb_create_entry($giveaway, $address, $email, $name, $referrer, $chances) {
		return apply_filters('gb_create_entry', Entry::create($giveaway, $address, $email, $name, $referrer, $chances), $giveaway, $address, $email, $name, $referrer, $chances);
	}
}

if(!function_exists('gb_get_entry')) {
	/**
	 * Returns an entry or false if the parameter does not correspond to one.
	 *
	 * @param int|WP_Post $entry The entry to return.
	 * @return false|WP_Post False if the entry doesn't exist and an appropriate WP_Post object if it does.
	 */
	function gb_get_entry($entry) {
		return apply_filters('gb_get_entry', Entry::get($entry), $entry);
	}
}

if(!function_exists('gb_get_entry_existing')) {
	/**
	 * Returns an entry if it exists for the specified giveaway and address, email, or token.
	 *
	 * @param int|WP_Post $giveaway The giveaway to find the entry for.
	 * @param string $address The IP address to use for searching.
	 * @param string $email The email to use for searching.
	 * @param string $token The token to use for searching.
	 * @return WP_Post|false An entry object if one is found or false if one is not found.
	 */
	function gb_get_entry_existing($giveaway, $address, $email, $token) {
		return apply_filters('gb_get_entry_existing', Entry::get_existing($giveaway, $address, $email, $token), $giveaway, $address, $email, $token);
	}
}

if(!function_exists('gb_get_entries')) {
	/**
	 * Returns all entries for a specified giveaway.
	 *
	 * @param int|WP_Post $giveaway The giveaway to return entries for.
	 * @param array $query_args An associative array of additional query args for filtering. Optional.
	 * @return array An array of WP_Post objects for the specified giveaway.
	 */
	function gb_get_giveaway_entries($giveaway, $query_args = []) {
		return apply_filters('gb_get_giveaway_entries', Entry::get_for_giveaway($giveaway, $query_args), $giveaway, $query_args);
	}
}
