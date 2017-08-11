<?php

namespace GB\Components\Data\Metadata\Entry;

if(!defined('ABSPATH')) { exit; }

class Winner {
	public static function init() {
		self::add_actions();
		self::add_filters();
	}

	private static function add_actions() {
		if(is_admin()) {

		} else {

		}

		add_action('pre_get_posts', [__CLASS__, 'modify_query']);
	}

	private static function add_filters() {
		if(is_admin()) {

		} else {

		}

	}

	#region Query Modification

	public static function modify_query($query) {
		if(true === $query->get('gb_winner')) {
			$meta_query = $query->get('meta_query');
			$meta_query = is_array($meta_query) ? $meta_query : [];
			$meta_query = array_merge($meta_query, [
				[
					'key'     => GB__DATA_META__ENTRY_WINNER,
					'compare' => 'EXISTS',
				],
			]);
		}
	}

	#endregion Query Modification

	#region Public API

	public static function is($entry) {
		$entry = gb_get_entry($entry);

		if(false === $entry) { return false; }

		return 1 === intval(get_post_meta($entry->ID, GB__DATA_META__ENTRY_WINNER, true));
	}

	public static function set($entry, $winner) {
		$entry  = gb_get_entry($entry);
		$winner = !!$winner;

		if(false === $entry) { return; }

		if(true === $winner) {
			update_post_meta($entry->ID, GB__DATA_META__ENTRY_WINNER, 1);
		} else {
			delete_post_meta($entry->ID, GB__DATA_META__ENTRY_WINNER);
		}
	}

	#endregion Public API
}

require_once(path_join(dirname(__FILE__), 'functions/winner.functions.php'));

Winner::init();
