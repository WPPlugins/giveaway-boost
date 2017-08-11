<?php

namespace GB\Components\Data\Metadata\Entry;

if(!defined('ABSPATH')) { exit; }

class TrackingAddress {
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

		return get_post_meta($entry->ID, GB__DATA_META__ENTRY_TRACKING_ADDRESS, true);
	}

	public static function set($entry, $address) {
		$entry = gb_get_entry($entry);

		if(false === $entry) { return; }

		update_post_meta($entry->ID, GB__DATA_META__ENTRY_TRACKING_ADDRESS, $address);
	}

	#endregion Public API
}

require_once(path_join(dirname(__FILE__), 'functions/tracking-address.functions.php'));

TrackingAddress::init();
