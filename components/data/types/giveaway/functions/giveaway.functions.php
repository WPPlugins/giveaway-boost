<?php

use GB\Components\Data\Types\Giveaway;

if(!defined('ABSPATH')) { exit; }

if(!function_exists('gb_get_giveaway')) {
	/**
	 * Returns a giveaway or false if the parameter does not correspond to one.
	 *
	 * @param int|WP_Post $giveaway The giveaway to return.
	 * @return false|WP_Post False if the giveaway doesn't exist and an appropriate WP_Post object if it does.
	 */
	function gb_get_giveaway($giveaway) {
		return apply_filters('gb_get_giveaway', Giveaway::get($giveaway), $giveaway);
	}
}

if(!function_exists('gb_get_giveaway_algorithms')) {
	/**
	 * Returns an array of algorithms available for a giveaway.
	 *
	 * @return array An array of algorithm id => algorithm name.
	 */
	function gb_get_giveaway_algorithms() {
		return apply_filters('gb_get_giveaway_algorithms', ['weighted_random' => __('Weighted Random Choice (more entries increase chance of winning)')]);
	}
}
