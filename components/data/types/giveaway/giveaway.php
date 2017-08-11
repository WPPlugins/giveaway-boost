<?php

namespace GB\Components\Data\Types;

if(!defined('ABSPATH')) { exit; }

class Giveaway {
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
			'name'                  => __('Giveaways'),
			'singular_name'         => __('Giveaway'),
			'add_new'               => __('Add New'),
			'add_new_item'          => __('Add New Giveaway'),
			'edit_item'             => __('Edit Giveaway'),
			'new_item'              => __('New Giveaway'),
			'view_item'             => __('View Giveaway'),
			'view_items'            => __('View Giveaways'),
			'search_items'          => __('Search Giveaways'),
			'not_found'             => __('No giveaways found.'),
			'not_found_in_trash'    => __('No giveaways found in Trash.'),
			'parent_item_colon'     => null,
			'all_items'             => __('All Giveaways'),
			'archives'              => __('Giveaway Archives'),
			'attributes'            => __('Giveaway Attributes'),
			'insert_into_item'      => __('Insert into giveaway'),
			'uploaded_to_this_item' => __('Uploaded to this giveaway'),
			'featured_image'        => __('Featured Image'),
			'set_featured_image'    => __('Set featured image'),
			'remove_featured_image' => __('Remove featured image'),
			'use_featured_image'    => __('Use as featured image'),
			'filter_items_list'     => __('Filter giveaways list'),
			'items_list_navigation' => __('Giveaways list navigation'),
			'items_list'            => __('Giveaways list'),
			'menu_name'             => __('Giveaways'),
		];

		$capabilities = [];

		$supports = [
			'title'
		];

		$rewrite = [
			'slug'       => 'giveaway',
			'with_front' => false,
			'feeds'      => false,
			'pages'      => false,
		];

		register_post_type(GB__DATA_TYPE__GIVEAWAY, [
			'can_export'          => true,
			'capabilities'        => $capabilities,
			'description'         => __('Post type by which giveaways can be managed'),
			'exclude_from_search' => true,
			'has_archive'         => false,
			'hierarchical'        => false,
			'label'               => $labels['name'],
			'labels'              => $labels,
			'menu_icon'           => GB__CONF__MENUICON,
			'menu_position'       => GB__CONF__POSITION,
			'public'              => true,
			'publicly_queryable'  => true,
			'rewrite'             => $rewrite,
			'show_in_admin_bar'   => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_ui'             => true,
			'supports'            => $supports,
			'taxonomies'          => [],
		]);
	}

	#endregion Registration

	#region Public API

	public static function get($giveaway) {
		if(empty($giveaway)) { return false; }

		$giveaway = get_post($giveaway);

		if(null === $giveaway || GB__DATA_TYPE__GIVEAWAY !== $giveaway->post_type) { return false; }

		return $giveaway;
	}

	#endregion Public API
}

require_once(path_join(dirname(__FILE__), 'functions/giveaway.functions.php'));

Giveaway::init();
