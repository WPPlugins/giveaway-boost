<?php

namespace GB\Components\Data\Metadata\Giveaway;

if(!defined('ABSPATH')) { exit; }

class Finished {
	public static function init() {
		self::add_actions();
		self::add_filters();
	}

	private static function add_actions() {
		if(is_admin()) {

		} else {

		}

	}

	private static function add_filters() {
		if(is_admin()) {

		} else {

		}

	}

	#region Public API

	public static function is($giveaway) {
		$giveaway = gb_get_giveaway($giveaway);

		if(false === $giveaway) { return false; }

		return 1 === intval(get_post_meta($giveaway->ID, GB__DATA_META__GIVEAWAY_FINISHED, true));
	}

	public static function set($giveaway, $finished) {
		$giveaway  = gb_get_giveaway($giveaway);
		$finished = !!$finished;

		if(false === $giveaway) { return; }

		if(true === $finished) {
			update_post_meta($giveaway->ID, GB__DATA_META__GIVEAWAY_FINISHED, 1);
		} else {
			delete_post_meta($giveaway->ID, GB__DATA_META__GIVEAWAY_FINISHED);
		}
	}

	#endregion Public API
}

require_once(path_join(dirname(__FILE__), 'functions/finished.functions.php'));

Finished::init();
