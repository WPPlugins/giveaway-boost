<?php

namespace GB\Components\Data\Types;

if(!defined('ABSPATH')) { exit; }

class Entry {
	public static function init() {
		self::add_actions();
		self::add_filters();
	}

	private static function add_actions() {
		if(is_admin()) {

		} else {

		}

		add_action('init', [__CLASS__, 'register_type'], 0);
	}

	private static function add_filters() {
		if(is_admin()) {

		} else {

		}

	}

	#region Registration

	public static function register_type() {
		$labels = [
			'name'                  => __('Entries'),
			'singular_name'         => __('Entry'),
			'add_new'               => __('Add New'),
			'add_new_item'          => __('Add New Entry'),
			'edit_item'             => __('Edit Entry'),
			'new_item'              => __('New Entry'),
			'view_item'             => __('View Entry'),
			'view_items'            => __('View Entries'),
			'search_items'          => __('Search Entries'),
			'not_found'             => __('No entries found.'),
			'not_found_in_trash'    => __('No entries found in Trash.'),
			'parent_item_colon'     => null,
			'all_items'             => __('All Entries'),
			'archives'              => __('Entry Archives'),
			'attributes'            => __('Entry Attributes'),
			'insert_into_item'      => __('Insert into entry'),
			'uploaded_to_this_item' => __('Uploaded to this entry'),
			'featured_image'        => __('Featured Image'),
			'set_featured_image'    => __('Set featured image'),
			'remove_featured_image' => __('Remove featured image'),
			'use_featured_image'    => __('Use as featured image'),
			'filter_items_list'     => __('Filter entries list'),
			'items_list_navigation' => __('Entries list navigation'),
			'items_list'            => __('Entries list'),
			'menu_name'             => __('Entries'),
		];

		$supports = ['nothing'];

		register_post_type(GB__DATA_TYPE__ENTRY, [
			'can_export'          => false,
			'description'         => __('Post type by which entries can be managed'),
			'exclude_from_search' => true,
			'has_archive'         => false,
			'hierarchical'        => false,
			'label'               => $labels['name'],
			'labels'              => $labels,
			'public'              => false,
			'publicly_queryable'  => false,
			'rewrite'             => false,
			'show_in_admin_bar'   => false,
			'show_in_menu'        => false,
			'show_in_nav_menus'   => false,
			'show_ui'             => false,
			'supports'            => $supports,
			'taxonomies'          => [],
		]);
	}

	#endregion Registration

	#region Public API

	public static function create($giveaway, $address, $email, $name, $referrer, $chances) {
		$giveaway = gb_get_giveaway($giveaway);

		if(false === $giveaway) { return new \WP_Error('invalid_giveaway', __('Invalid giveaway specified.')); }

		$address  = trim($address);
		$email    = trim($email);
		$name     = trim($name);
		$referrer = gb_get_entry($referrer);
		$chances  = intval($chances);

		$errors = new \WP_Error;

		if(empty($email)) {
			$errors->add('invalid_email', __('You must provide an email'));
		} else if(!is_email($email)) {
			$errors->add('invalid_email', __('You must provide a valid email'));
		}

		if(empty($name)) {
			$errors->add('invalid_name', __('You must provide a name'));
		}

		if($errors->get_error_code()) { return $errors; }

		$entry = gb_get_entry_existing($giveaway, $address, $email, '');

		if(false !== $entry) { return $entry; }

		$entry_id = wp_insert_post([
			'post_author' => 0,
			'post_parent' => $giveaway->ID,
			'post_status' => 'inherit',
			'post_type'   => GB__DATA_TYPE__ENTRY,
		], true);

		if(is_wp_error($entry_id)) { return false; }

		gb_set_entry_chances($entry_id, $chances);
		gb_set_entry_sources($entry_id, ['standard']);
		gb_set_entry_tracking_address($entry_id, $address);
		gb_set_entry_tracking_email($entry_id, $email);
		gb_set_entry_tracking_name($entry_id, $name);

		if(false !== $referrer) {
			gb_set_entry_tracking_referrer($entry_id, $referrer->ID);
			gb_add_entry_chances($referrer, gb_get_giveaway_settings($giveaway, 'referral_entries'));
			gb_add_entry_sources($referrer, ['referral']);
		}

		do {
			$token = wp_generate_password(12, false, false);
			$exist = gb_get_entry_existing($giveaway, '', '', $token);
		} while(false !== $exist);

		gb_set_entry_token($entry_id, $token);

		return gb_get_entry($entry_id);
	}

	public static function get($entry) {
		if(empty($entry)) { return false; }

		$entry = get_post($entry);

		if(null === $entry || GB__DATA_TYPE__ENTRY !== $entry->post_type) { return false; }

		return $entry;
	}

	public static function get_existing($giveaway, $address, $email, $token) {
		$giveaway = gb_get_giveaway($giveaway);

		if(false === $giveaway) { return false; }

		// Sanitize the address depending on whether we're allowing for use of it
		$address = GB__CONF__ADDRESS_TRACKING ? $address : false;
		$email   = trim($email);
		$token   = trim($token);

		if(empty($address) && empty($email) && empty($token)) { return false; }

		$meta_query = array_filter([
			'relation' => 'OR',

			empty($token) ? false : [
				'compare' => '=',
				'key'     => GB__DATA_META__ENTRY_TOKEN,
				'value'   => $token,
			],

			empty($address) ? false : [
				'compare' => '=',
				'key'     => GB__DATA_META__ENTRY_TRACKING_ADDRESS,
				'value'   => $address,
			],

			empty($email) ? false : [
				'compare' => '=',
				'key'     => GB__DATA_META__ENTRY_TRACKING_EMAIL,
				'value'   => $email,
			],
		]);

		$entries = get_posts([
			'orderby'        => 'ID',
			'order'          => 'ASC',
			'posts_per_page' => 1,
			'post_parent'    => $giveaway->ID,
			'post_status'    => ['inherit'],
			'post_type'      => [GB__DATA_TYPE__ENTRY],
			'meta_query'     => $meta_query,
		]);

		return empty($entries) ? false : gb_get_entry(array_shift($entries));
	}

	public static function get_for_giveaway($giveaway, $query_args) {
		$giveaway   = gb_get_giveaway($giveaway);
		$query_args = is_array($query_args) ? $query_args : [];

		if(false === $giveaway) { return []; }

		$entries = array_map('gb_get_entry', get_posts(array_merge([
			'fields'      => 'ids',
			'nopaging'    => true,
			'orderby'     => 'ID',
			'order'       => 'ASC',
			'post_status' => 'inherit',
			'post_type'   => GB__DATA_TYPE__ENTRY,
			'post_parent' => $giveaway->ID,
		], $query_args)));

		usort($entries, function($a, $b) {
			$a_winner = gb_is_entry_winner($a);
			$b_winner = gb_is_entry_winner($b);

			// If both winner or both not winner, sort by the ID
			if(($a_winner && $b_winner) || (!$a_winner && !$b_winner)) {
				return $a->ID === $b->ID ? 0 : ($a->ID > $b->ID ? 1 : -1);
			} else if($a_winner) {
				return -1;
			} else if($b_winner) {
				return 1;
			}
		});

		return $entries;
	}

	#endregion Public API
}

require_once(path_join(dirname(__FILE__), 'functions/entry.functions.php'));

Entry::init();
