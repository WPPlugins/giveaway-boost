<?php

namespace GB\Components\Data\Metadata\Giveaway;

if(!defined('ABSPATH')) { exit; }

class Settings {
	public static function init() {
		self::add_actions();
		self::add_filters();
	}

	private static function add_actions() {
		if(is_admin()) {
			add_action('admin_init', [__CLASS__, 'register']);
		} else {

		}

	}

	private static function add_filters() {
		if(is_admin()) {

		} else {

		}

		add_filter('\GB\Components\Data\Metadata\Giveaway\Settings::sanitize', [__CLASS__, 'sanitize_basic'], 10, 3);

	}

	#region Registration and Callbacks

	public static function register() {
		register_meta('post', GB__DATA_META__GIVEAWAY_SETTINGS, [
			'sanitize_callback' => [__CLASS__, 'sanitize'],
			'single'            => true,
			'type'              => 'array',
		]);
	}

	public static function sanitize($settings) {
		$settings = is_array($settings) ? $settings : [];
		$defaults = gb_get_giveaway_settings_defaults();
		$settings = apply_filters('\GB\Components\Data\Metadata\Giveaway\Settings::sanitize', $settings, $settings, $defaults);

		return shortcode_atts($defaults, $settings);
	}

	public static function sanitize_basic($settings, $settings_orig, $settings_defs) {
		// Algorithm must be within the set of algorithms
		$settings['algorithm'] = isset($settings['algorithm']) && in_array($settings['algorithm'], array_keys(gb_get_giveaway_algorithms())) ? $settings['algorithm'] : $settings_defs['algorithm'];

		// Number of winners must be an integer greater than 1
		$settings['number_winners'] = isset($settings['number_winners']) ? intval(filter_var($settings['number_winners'], FILTER_SANITIZE_NUMBER_INT)) : $settings_defs['number_winners'];
		$settings['number_winners'] = max([$settings['number_winners'], 1]);

		// Referral entries must be a non-negative integer
		$settings['referral_entries'] = isset($settings['referral_entries']) ? intval(filter_var($settings['referral_entries'], FILTER_SANITIZE_NUMBER_INT)) : $settings_defs['referral_entries'];
		$settings['referral_entries'] = max([$settings['referral_entries'], 0]);

		// Number of winners display and value prize display can only be 'n' or 'y'
		$settings['number_winners_d'] = isset($settings['number_winners_d']) && in_array($settings['number_winners_d'], ['n', 'y']) ? $settings['number_winners_d'] : $settings_defs['number_winners_d'];
		$settings['value_prize_d']    = isset($settings['value_prize_d'])    && in_array($settings['value_prize_d'], ['n', 'y'])    ? $settings['value_prize_d']    : $settings_defs['value_prize_d'];

		// Verification can only be 'n' or 'y'
		$settings['verification'] = isset($settings['verification']) && in_array($settings['verification'], ['n', 'y']) ? $settings['verification'] : $settings_defs['verification'];

		// Make sure this is actually a date
		$settings['datetime_end'] = isset($settings['datetime_end']) ? gb_get_date($settings['datetime_end'])->format('Y-m-d H:i:s') : $settings_defs['datetime_end'];

		// Run all text fields through the wp_kses_post function
		$settings['message_default'] = isset($settings['message_default']) ? wp_kses_post($settings['message_default']) : $settings_defs['message_default'];
		$settings['message_ended']   = isset($settings['message_ended'])   ? wp_kses_post($settings['message_ended'])   : $settings_defs['message_ended'];
		$settings['message_entry']   = isset($settings['message_entry'])   ? wp_kses_post($settings['message_entry'])   : $settings_defs['message_entry'];

		// Strip all the tags from these two elements which should be plain text
		$settings['button_text'] = isset($settings['button_text']) ? wp_strip_all_tags($settings['button_text']) : $settings_defs['button_text'];
		$settings['value_prize'] = isset($settings['value_prize']) ? wp_strip_all_tags($settings['value_prize']) : $settings_defs['value_prize'];

		return $settings;
	}

	#endregion Registration and Callbacks

	#region Public API

	public static function get_defaults() {
		$templates = gb_get_giveaway_templates();
		$templated = array_filter($templates, function($template) { return $template['default']; });
		$template  = empty($templated) ? key($templates) : key($templated);

		return apply_filters('\GB\Components\Data\Metadata\Giveaway\Settings::get_defaults', [
			'errors'            => [],
			'algorithm'         => 'weighted_random',
			'button_text'       => __('Enter to Win'),
			'datetime_end'      => gb_get_date()->add(new \DateInterval('P7D'))->setTime(12, 0, 0)->format('Y-m-d H:i:s'),
			'message_default'   => __('Enter now to win a great prize!'),
			'message_ended'     => __('This giveaway has ended.'),
			'message_entry'     => __('Thanks for entering! Make sure you spread the word.'),
			'number_winners'    => 1,
			'number_winners_d'  => 'y',
			'referral_entries'  => 3,
			'template'          => $template,
			'template_settings' => wp_list_pluck($templates[$template]['controls'], 'default'),
			'value_prize'       => '',
			'value_prize_d'     => 'y',
			'verification'      => gb_get_settings('default_verification'),
		]);
	}

	public static function get($giveaway, $key) {
		$giveaway = gb_get_giveaway($giveaway);

		if(false === $giveaway) { return gb_get_giveaway_settings_defaults(); }

		$settings = get_post_meta($giveaway->ID, GB__DATA_META__GIVEAWAY_SETTINGS, true);
		$settings = is_array($settings) ? $settings : gb_get_giveaway_settings_defaults();

		if(is_null($key)) {
			return $settings;
		} else {
			return gb_deep_access($settings, $key);
		}
	}

	public static function set($giveaway, $settings) {
		$giveaway = gb_get_giveaway($giveaway);

		if(false === $giveaway) { return; }

		update_post_meta($giveaway->ID, GB__DATA_META__GIVEAWAY_SETTINGS, $settings);
	}

	#endregion Public API
}

require_once(path_join(dirname(__FILE__), 'functions/settings.functions.php'));

Settings::init();
