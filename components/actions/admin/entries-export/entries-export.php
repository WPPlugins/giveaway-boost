<?php

namespace GB\Components\Actions\Admin;

if(!defined('ABSPATH')) { exit; }

class EntriesExport {
	public static function init() {
		self::add_actions();
		self::add_filters();
	}

	private static function add_actions() {
		if(is_admin()) {
			add_action(sprintf('admin_action_%s', GB__ACTION_NAME__ENTRIES_EXPORT), [__CLASS__, 'process']);
		} else {

		}

	}

	private static function add_filters() {
		if(is_admin()) {

		} else {

		}

	}

	#region Process

	public static function process() {
		$data     = stripslashes_deep($_REQUEST);
		$giveaway = isset($data['giveaway']) ? gb_get_giveaway($data['giveaway']) : false;

		if(false === $giveaway) { wp_die(__('Invalid giveaway specified.')); }

		$nonce_a = sprintf('%s_%d',       GB__ACTION_NAME__ENTRIES_EXPORT, $giveaway->ID);
		$nonce_k = sprintf('%s_%d_nonce', GB__ACTION_NAME__ENTRIES_EXPORT, $giveaway->ID);
		$nonce_v = isset($data[$nonce_k]) && wp_verify_nonce($data[$nonce_k], $nonce_a);
		$permit  = $nonce_v && current_user_can('edit_post', $giveaway->ID);

		if($permit) {
			$entries = gb_get_giveaway_entries($giveaway);

			gb_send_csv(sprintf('giveaway-%d-entries', $giveaway->ID), [
				__('Name'),
				__('Email'),
				__('IP Address'),
				__('Chances'),
				__('Entered At'),
				__('Winner'),
			], array_map(function($entry) {
				return [
					gb_get_entry_tracking_name($entry),
					gb_get_entry_tracking_email($entry),
					gb_get_entry_tracking_address($entry),
					gb_get_entry_chances($entry),
					gb_get_date($entry->post_date)->format('Y-m-d H:i:s'),
					gb_is_entry_winner($entry) ? __('Yes') : __('No'),
				];
			}, $entries));
		} else {
			wp_die(__('Cheatin&#8217; uh?'));
		}
	}

	#endregion Process
}

EntriesExport::init();
