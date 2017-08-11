<?php

use GB\Components\Data\Metadata\Entry\Sources;

if(!function_exists('gb_add_entry_sources')) {
	/**
	 * Adds the specified sources to the stored sources for an entry.
	 *
	 * @param int|WP_Post $entry The entry to add sources to.
	 * @param array $sources The sources to add to the stored sources for the specified entry.
	 * @return void
	 */
	function gb_add_entry_sources($entry, array $sources) {
		return apply_filters('gb_add_entry_sources', gb_set_entry_sources($entry, array_merge(gb_get_entry_sources($entry), $sources)), $entry);
	}
}

if(!function_exists('gb_get_entry_sources')) {
	/**
	 * Returns the stored sources for an entry.
	 *
	 * @param int|WP_Post $entry The entry to return the sources for.
	 * @return string The sources for the specified entry.
	 */
	function gb_get_entry_sources($entry) {
		return apply_filters('gb_get_entry_sources', Sources::get($entry), $entry);
	}
}

if(!function_exists('gb_set_entry_sources')) {
	/**
	 * Stores the sources for an entry.
	 *
	 * @param int|WP_Post $entry The entry to set the sources for.
	 * @param array $sources The sources to store for the specified entry.
	 * @return void
	 */
	function gb_set_entry_sources($entry, array $sources) {
		return apply_filters('gb_set_entry_sources', Sources::set($entry, $sources), $entry, $sources);
	}
}
