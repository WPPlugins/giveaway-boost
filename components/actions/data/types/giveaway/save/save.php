<?php

namespace GB\Components\Actions\Data\Types\Giveaway;

if(!defined('ABSPATH')) { exit; }

class Save {
	public static function init() {
		self::add_actions();
		self::add_filters();
	}

	private static function add_actions() {
		if(is_admin()) {
			add_action(sprintf('save_post_%s', GB__DATA_TYPE__GIVEAWAY), [__CLASS__, 'save']);
		} else {

		}

	}

	private static function add_filters() {
		if(is_admin()) {

		} else {

		}

	}

	#region Save

	public static function save($giveaway) {
		$data    = stripslashes_deep($_POST);
		$giveaway = gb_get_giveaway($giveaway);

		if(false === $giveaway) { return; }

		$nonce_a = sprintf('edit_%s_%d', GB__DATA_TYPE__GIVEAWAY, $giveaway->ID);
		$nonce_k = sprintf('edit_%s_%d_nonce', GB__DATA_TYPE__GIVEAWAY, $giveaway->ID);
		$nonce_v = isset($data[$nonce_k]) && wp_verify_nonce($data[$nonce_k], $nonce_a);

		if($nonce_v) {
			$settings = isset($data['gb_giveaway']) && is_array($data['gb_giveaway']) ? $data['gb_giveaway'] : [];

			gb_set_giveaway_settings($giveaway, $settings);
		}
	}

	#endregion Save

}

Save::init();
