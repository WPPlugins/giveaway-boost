<?php

namespace GB\Components\ViewsPublicAdditions\Types\Giveaway\EntryMethods;

if(!defined('ABSPATH')) { exit; }

class Referral {
	public static function init() {
		self::add_actions();
		self::add_filters();
	}

	private static function add_actions() {
		if(is_admin()) {

		} else {
			add_action('gb_output_giveaway_entry_methods', [__CLASS__, 'markup'], 500);
		}

	}

	private static function add_filters() {
		if(is_admin()) {

		} else {

		}

	}

	#region Markup

	public static function markup($giveaway) {
		if(gb_is_giveaway_ended($giveaway)) { return; }

		$entry = gb_get_giveaway_entry_context($giveaway);
		$url   = gb_get_giveaway_entry_share_url($entry);

		printf('<div class="entry-method-referral"><div class="entry-input-container"><input type="text" class="entry-input" id="entry-input-referral" value="%s" readonly /></div><button class="entry-submit" id="entry-submit-copy" style="display:none;">%s</button><div class="entry-referral-copied highlight" style="padding:10px 0;opacity:0;">%s</div></div>', esc_attr($url), esc_html__('Copy Link'), esc_html__('Copied to Clipboard!'));
	}

	#endregion Markup
}

Referral::init();
