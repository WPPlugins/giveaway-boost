<?php

namespace GB\Components\Data\Metadata\Entry;

if(!defined('ABSPATH')) { exit; }

class Token {
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

		return get_post_meta($entry->ID, GB__DATA_META__ENTRY_TOKEN, true);
	}

	public static function set($entry, $token) {
		$entry = gb_get_entry($entry);

		if(false === $entry) { return; }

		update_post_meta($entry->ID, GB__DATA_META__ENTRY_TOKEN, $token);
	}

	#endregion Public API
}

require_once(path_join(dirname(__FILE__), 'functions/token.functions.php'));

Token::init();
