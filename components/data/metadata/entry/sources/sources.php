<?php

namespace GB\Components\Data\Metadata\Entry;

if(!defined('ABSPATH')) { exit; }

class Sources {
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

		if(false === $entry) { return []; }

		return array_unique(get_post_meta($entry->ID, GB__DATA_META__ENTRY_SOURCE));
	}

	public static function set($entry, $sources) {
		$entry = gb_get_entry($entry);

		if(false === $entry) { return; }

		delete_post_meta($entry->ID, GB__DATA_META__ENTRY_SOURCE);

		$sources = is_array($sources) ? array_unique($sources) : [];

		foreach($sources as $source) {
			add_post_meta($entry->ID, GB__DATA_META__ENTRY_SOURCE, $source);
		}
	}

	#endregion Public API
}

require_once(path_join(dirname(__FILE__), 'functions/sources.functions.php'));

Sources::init();
