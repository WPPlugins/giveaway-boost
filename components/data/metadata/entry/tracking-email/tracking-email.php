<?php

namespace GB\Components\Data\Metadata\Entry;

if(!defined('ABSPATH')) { exit; }

class TrackingEmail {
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

		return get_post_meta($entry->ID, GB__DATA_META__ENTRY_TRACKING_EMAIL, true);
	}

	public static function set($entry, $email) {
		$entry = gb_get_entry($entry);

		if(false === $entry) { return; }

		update_post_meta($entry->ID, GB__DATA_META__ENTRY_TRACKING_EMAIL, $email);
	}

	#endregion Public API
}

require_once(path_join(dirname(__FILE__), 'functions/tracking-email.functions.php'));

TrackingEmail::init();
