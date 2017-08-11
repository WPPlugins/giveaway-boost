<?php

namespace GB\Components\Actions\Admin;

if(!defined('ABSPATH')) { exit; }

class EntriesWinners {
	public static function init() {
		self::add_actions();
		self::add_filters();
	}

	private static function add_actions() {
		if(is_admin()) {
			add_action(sprintf('admin_action_%s', GB__ACTION_NAME__ENTRIES_WINNERS), [__CLASS__, 'process']);
		} else {

		}

	}

	private static function add_filters() {
		if(is_admin()) {

		} else {

		}

	}

	#region Utility

	private static function choose_winners($giveaway) {
		$algorithm = gb_get_giveaway_settings($giveaway, 'algorithm');
		$number    = gb_get_giveaway_settings($giveaway, 'number_winners');

		if(gb_is_giveaway_finished($giveaway)) {
			$winners = gb_get_giveaway_entries($giveaway, ['gb_winner' => true]);
		} else {
			$winners = apply_filters("\GB\Components\Actions\EntriesWinners::choose_winners::{$algorithm}", false, $giveaway, $number);

			if(false === $winners) {
				$entries = gb_get_giveaway_entries($giveaway);
				$chooser = [];
				$winners = [];

				foreach($entries as $entry) {
					$chances = gb_get_entry_chances($entry);

					for($i = 0; $i < $chances; $i++) {
						$chooser[] = $entry->ID;
					}
				}

				for($i = 0; $i < $number; $i++) {
					shuffle($chooser);

					$winner  = array_shift($chooser);
					$chooser = array_diff($chooser, [$winner]);

					$winners[] = $winner;
				}
			}

			$winners = empty($winners) ? [] : gb_get_giveaway_entries($giveaway, ['post__in' => $winners]);
		}

		return $winners;
	}

	#endregion Utility

	#region Process

	public static function process() {
		$data     = stripslashes_deep($_REQUEST);
		$giveaway = isset($data['giveaway']) ? gb_get_giveaway($data['giveaway']) : false;

		if(false === $giveaway) { wp_die(__('Invalid giveaway specified.')); }

		$nonce_a = sprintf('%s_%d',       GB__ACTION_NAME__ENTRIES_WINNERS, $giveaway->ID);
		$nonce_k = sprintf('%s_%d_nonce', GB__ACTION_NAME__ENTRIES_WINNERS, $giveaway->ID);
		$nonce_v = isset($data[$nonce_k]) && wp_verify_nonce($data[$nonce_k], $nonce_a);
		$permit  = $nonce_v && current_user_can('edit_post', $giveaway->ID);

		if($permit) {
			$entries = self::choose_winners($giveaway);

			foreach($entries as $entry) {
				gb_set_entry_winner($entry, true);
			}

			gb_set_giveaway_finished($giveaway, true);

			gb_redirect(get_edit_post_link($giveaway->ID, 'raw'));
		} else {
			wp_die(__('Cheatin&#8217; uh?'));
		}
	}

	#endregion Process
}

EntriesWinners::init();
