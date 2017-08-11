<?php

namespace GB\Components\ViewsPublicAdditions\Types\Giveaway\EntryMethods;

if(!defined('ABSPATH')) { exit; }

class Facebook {
	public static function init() {
		self::add_actions();
		self::add_filters();
	}

	private static function add_actions() {
		if(is_admin()) {

		} else {
			add_action('gb_output_giveaway_entry_methods', [__CLASS__, 'entry_methods']);
		}

	}

	private static function add_filters() {
		if(is_admin()) {

		} else {

		}

	}

	#region Entry Methods

	public static function entry_methods($giveaway) {
		if(gb_is_giveaway_ended($giveaway)) { return; }

		$entry = gb_get_giveaway_entry_context($giveaway);
		$share = gb_get_giveaway_entry_share_url($entry);
		$url   = add_query_arg([
			'u' => urlencode($share),
			'p' => urlencode($giveaway->post_title),
		], 'https://www.facebook.com/sharer.php');

		printf('<a class="entry-method-social entry-method-social-facebook" href="%s" target="_blank"><i class="fa fa-facebook"></i></a>', esc_url($url));
	}

	#endregion Entry Methods
}

Facebook::init();
