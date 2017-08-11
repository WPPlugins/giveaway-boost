<?php

namespace GB\Components\Data\Metadata\Entry;

if(!defined('ABSPATH')) { exit; }

class TrackingReferrer {
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

	public static function get($entry) {
		$entry = gb_get_entry($entry);

		if(false === $entry) { return ''; }

		return gb_get_entry(get_post_meta($entry->ID, GB__DATA_META__ENTRY_TRACKING_REFERRER, true));
	}

	public static function set($entry, $referrer) {
		$entry    = gb_get_entry($entry);
		$referrer = gb_get_entry($referrer);

		if(false === $entry || false === $referrer) { return; }

		update_post_meta($entry->ID, GB__DATA_META__ENTRY_TRACKING_REFERRER, $referrer->ID);
	}

	#endregion Public API
}

require_once(path_join(dirname(__FILE__), 'functions/tracking-referrer.functions.php'));

TrackingReferrer::init();
