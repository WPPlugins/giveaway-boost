<?php

namespace GB\Components\ViewsAdmin\SettingsSections;

if(!defined('ABSPATH')) { exit; }

class Rewrites {
	public static function init() {
		self::add_actions();
		self::add_filters();
	}

	private static function add_actions() {
		if(is_admin()) {
			add_action('\GB\Components\ViewsAdmin\Settings::load', [__CLASS__, 'add_controls'], 10);
		} else {

		}

	}

	private static function add_filters() {
		if(is_admin()) {

		} else {

		}

		add_filter('\GB\Components\Data\Options\Settings::get_defaults', [__CLASS__, 'add_defaults']);
		add_filter('\GB\Components\Data\Options\Settings::sanitize',     [__CLASS__, 'sanitize_settings'], 11, 3);
	}

	#region Settings Section

	public static function add_controls($slug) {
		add_settings_section(GB__PAGE_SECT__REWRITES, __('Giveaway URLs'), [__CLASS__, 'display'], $slug);

		add_settings_field('rewrite_base', __('Giveaways Base'), [__CLASS__, 'field_rewrite_base'], $slug, GB__PAGE_SECT__REWRITES, [
			'label_for' => gb_get_setting_field_id('rewrite_base'),
		]);
	}

	public static function display() { }

	#endregion Settings Section

	#region Settings Fields

	public static function field_rewrite_base($args) {
		printf('<code>%s</code><input type="text" class="code regular-text" id="%s" name="%s" %s value="%s" /><code>/giveaway-slug/</code>', esc_html(home_url('/')), esc_attr(gb_get_setting_field_id('rewrite_base')), esc_attr(gb_get_setting_field_name('rewrite_base')), (defined('GB__CONF__REWRITE_BASE') ? 'readonly="readonly"' : ''), esc_attr(gb_get_settings('rewrite_base')));
	}

	#endregion Settings Fields

	#region Settings

	public static function add_defaults($defaults) {
		$defaults['rewrite_base'] = defined('GB__CONF__REWRITE_BASE') ? GB__CONF__REWRITE_BASE : 'giveaway';

		return $defaults;
	}

	public static function sanitize_settings($settings, $settings_raw, $settings_defaults) {
		$settings['rewrite_base'] = defined('GB__CONF__REWRITE_BASE') ? GB__CONF__REWRITE_BASE : (isset($settings['rewrite_base']) ? trim($settings['rewrite_base']) : '');

		return $settings;
	}

	#endregion Settings
}

Rewrites::init();
