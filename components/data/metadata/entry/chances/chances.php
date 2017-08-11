<?php

namespace GB\Components\Data\Metadata\Entry;

if(!defined('ABSPATH')) { exit; }

class Chances {
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

		if(false === $entry) { return 0; }

		return intval(get_post_meta($entry->ID, GB__DATA_META__ENTRY_CHANCES, true));
	}

	public static function set($entry, $chances) {
		$entry = gb_get_entry($entry);

		if(false === $entry) { return; }

		update_post_meta($entry->ID, GB__DATA_META__ENTRY_CHANCES, $chances);
	}

	#endregion Public API
}

require_once(path_join(dirname(__FILE__), 'functions/chances.functions.php'));

Chances::init();
