<?php

namespace GB\Components\ViewsPublicAdditions\Types\Giveaway;

if(!defined('ABSPATH')) { exit; }

class Verification {
	public static function init() {
		self::add_actions();
		self::add_filters();
	}

	private static function add_actions() {
		if(is_admin()) {

		} else {
			add_action('wp_footer', [__CLASS__, 'footer']);
		}

	}

	private static function add_filters() {
		if(is_admin()) {

		} else {

		}

		add_filter('\GB\Components\ViewsPublic\Types\Giveaway::template::$permit', [__CLASS__, 'permit'], 10, 3);
	}

	#region Scripts

	public static function footer() {
		if(false !== ($giveaway = gb_get_giveaway(get_queried_object_id()))) {
			$entry = gb_get_giveaway_entry_context($giveaway);

			if(false === $entry && 'y' === gb_get_giveaway_settings($giveaway, 'verification') && ($site_key = gb_get_settings('recaptcha_sitekey')) && ($secret_key = gb_get_settings('recaptcha_secretkey'))) {
				include(path_join(dirname(__FILE__), 'templates/verification.script.php'));
			}
		}
	}

	#endregion Scripts

	#region Permit Entry

	public static function permit($permit, $giveaway, $data) {
		if('y' === gb_get_giveaway_settings($giveaway, 'verification') && ($site_key = gb_get_settings('recaptcha_sitekey')) && ($secret_key = gb_get_settings('recaptcha_secretkey'))) {
			$response = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', [
				'body' => [
					'secret'   => $secret_key,
					'response' => $data['g-recaptcha-response'],
					'address'  => gb_get_ipaddress(),
				],
			]);
			$response = is_wp_error($response) ? ['success' => false] : json_decode(wp_remote_retrieve_body($response), true);

			if(false === $response['success']) {
				$permit->add('invalid_verification', __('You must correctly complete the reCAPTCHA field'));
			}
		}

		return $permit;
	}

	#endregion Permit Entry
}

Verification::init();
