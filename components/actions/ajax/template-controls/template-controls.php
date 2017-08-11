<?php

namespace GB\Components\Actions\Ajax;

if(!defined('ABSPATH')) { exit; }

class TemplateControls {
	public static function init() {
		self::add_actions();
		self::add_filters();
	}

	private static function add_actions() {
		if(is_admin()) {
			add_action(sprintf('wp_ajax_%s', GB__AJAX_NAME__TEMPLATE_CONTROLS), [__CLASS__, 'process']);
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
		$template = isset($data['template']) ? $data['template'] : false;

		if(false === $giveaway || false === $template) { wp_send_json(['error' => true, 'message' => __('Invalid giveaway specified.')]); }

		$permit = current_user_can('edit_post', $giveaway->ID);

		if(false === $permit) { wp_send_json(['error' => true, 'message' => __('Invalid giveaway specified.')]); }

		$templates = gb_get_giveaway_templates();
		$template  = isset($templates[$template]) ? $templates[$template] : false;

		if(false === $template) { wp_send_json(['error' => true, 'message' => __('Invalid template specified.')]); }

		wp_send_json([
			'error'    => false,
			'controls' => gb_get_giveaway_template_controls($giveaway, $template),
		]);
	}

	#endregion Process
}

TemplateControls::init();
