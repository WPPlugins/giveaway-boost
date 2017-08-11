<?php

namespace GB\Components;

if(!defined('ABSPATH')) { exit; }

class Resources {
	public static function init() {
		self::add_actions();
		self::add_filters();
	}

	private static function add_actions() {
		if(is_admin()) {

		} else {

		}

		add_action('init', [__CLASS__, 'register']);
	}

	private static function add_filters() {
		if(is_admin()) {

		} else {

		}

	}

	#region Utility

	private static function get_confirm_dialog() {
		ob_start();

		include(path_join(dirname(__FILE__), 'templates/confirm.dialog.php'));

		return ob_get_clean();
	}

	#endregion Utility

	#region Register

	public static function register() {
		wp_register_style('gb_jquery_ui', plugins_url('vendor-assets/jquery-ui/jquery-ui.min.css', GB__PLUGIN__FILEPATH), [], '1.12.1');

		wp_register_script('gb_jquery_ui_datetimepicker', plugins_url('vendor-assets/timepicker-addon/timepicker-addon.min.js', GB__PLUGIN__FILEPATH), ['jquery', 'jquery-ui-datepicker'], '1.6.3', true);
		wp_register_style('gb_jquery_ui_datetimepicker', plugins_url('vendor-assets/timepicker-addon/timepicker-addon.min.css', GB__PLUGIN__FILEPATH), ['gb_jquery_ui'], '1.6.3');

		wp_register_script('gb_resources_admin', plugins_url('resources/admin.js', __FILE__), ['jquery', 'gb_jquery_ui_datetimepicker'], GB__PLUGIN__VERSION, true);
		wp_register_style('gb_resources_admin', plugins_url('resources/admin.css', __FILE__), ['gb_jquery_ui_datetimepicker'], GB__PLUGIN__VERSION);

		wp_localize_script('gb_resources_admin', 'GB_RESOURCES_ADMIN', [
			'confirmDialog' => self::get_confirm_dialog(),
		]);
	}

	#endregion Register

	#region Public API

	public static function get_media_picker($image_id, $field_id, $field_name, $text_button, $text_title) {
		$image_src = $image_id ? wp_get_attachment_image_src($image_id, 'full') : false;
		$image_url = is_array($image_src) && isset($image_src[0]) ? $image_src[0] : '#';

		$button_select = sprintf('<a class="button button-primary gb-media-selector-button" id="%s" href="#" data-text-button="%s" data-text-title="%s">%s</a>', esc_attr($field_id), esc_attr($text_button), esc_attr($text_title), esc_html($text_button));
		$button_view   = sprintf('<a class="button gb-media-selector-action gb-media-selector-action-view" href="%s" target="_blank">%s</a>', esc_url($image_url), esc_html__('View'));
		$button_remove = sprintf('<a class="button gb-media-selector-action gb-media-selector-action-remove" href="#">%s</a>', esc_html__('Remove'));
		$icon_success  = '<span class="gb-success gb-media-selector-action dashicons dashicons-yes"></span>';
		$input_value   = sprintf('<input type="hidden" class="gb-media-selector-value" name="%s" value="%d" />', $field_name, $image_id);

		return sprintf('<div class="gb-media-selector-container">%s%s%s%s%s</div>', $button_select, $button_view, $button_remove, $icon_success, $input_value);
	}

	#endregion Public API
}

require_once(path_join(dirname(__FILE__), 'includes/resources.functions.php'));

Resources::init();
