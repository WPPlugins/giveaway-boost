<?php

use GB\Components\Data\Metadata\Giveaway\Finished;

if(!function_exists('gb_is_giveaway_finished')) {
	/**
	 * Returns true if a giveaway is a giveaway finished and false otherwise.
	 *
	 * @param int|WP_Post $giveaway The giveaway to check the finished status for.
	 * @return bool True if the giveaway is finished and false otherwise.
	 */
	function gb_is_giveaway_finished($giveaway) {
		return apply_filters('gb_is_giveaway_finished', Finished::is($giveaway), $giveaway);
	}
}

if(!function_exists('gb_set_giveaway_finished')) {
	/**
	 * Stores the finished status for a specified giveaway.
	 *
	 * @param int|WP_Post $giveaway The giveaway to set the finished status for.
	 * @param bool $finished True if the giveaway is finished and false otherwise.
	 * @return void
	 */
	function gb_set_giveaway_finished($giveaway, $finished) {
		return apply_filters('gb_set_giveaway_finished', Finished::set($giveaway, $finished), $giveaway, $finished);
	}
}
