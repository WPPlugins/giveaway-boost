<?php

namespace GB\Components\ViewsPublic\Types;

if(!defined('ABSPATH')) { exit; }

class Giveaway {
	public static function init() {
		self::add_actions();
		self::add_filters();
	}

	private static function add_actions() {
		if(is_admin()) {

		} else {
			add_action('template_include',  [__CLASS__, 'template_include'], 10000);
			add_action('template_redirect', [__CLASS__, 'template_redirect'], -5);
		}

	}

	private static function add_filters() {
		if(is_admin()) {

		} else {

		}

	}

	#region Resources

	public static function resources() {
		// First, remove every single script and style currently enqueued
		foreach(wp_styles()->queue      as $handle) { wp_dequeue_style($handle);  }
		foreach(wp_scripts()->queue     as $handle) { wp_dequeue_script($handle); }
		foreach(wp_scripts()->in_footer as $handle) { wp_dequeue_script($handle); }

		// Giveaway
		$giveaway = gb_get_giveaway(get_queried_object_id());

		wp_enqueue_script('jquery-countdown', plugins_url('vendor-assets/jquery-countdown/jquery-countdown.min.js', GB__PLUGIN__FILEPATH), ['jquery'], '2.2.0', true);
		wp_enqueue_script('gb_viewspublic_giveaway', plugins_url('resources/giveaway.js', __FILE__), ['jquery', 'jquery-countdown'], GB__PLUGIN__VERSION, true);
		wp_localize_script('gb_viewspublic_giveaway', 'GB_VIEWSPUBLIC_GIVEAWAY', [
			'end' => gb_get_giveaway_settings($giveaway, 'datetime_end'),
		]);

		wp_enqueue_style('font-awesome', plugins_url('vendor-assets/font-awesome/css/font-awesome.min.css', GB__PLUGIN__FILEPATH), [], '4.5.0');
		wp_enqueue_style('normalize', plugins_url('vendor-assets/normalize-css/normalize.min.css', GB__PLUGIN__FILEPATH), [], GB__PLUGIN__VERSION);

		if(self::$template && file_exists(self::$template)) {
			wp_enqueue_script('html5shivjs', 'https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js', [], '3.7.3', false);
			wp_enqueue_script('responsejs', 'https://oss.maxcdn.com/respond/1.4.2/respond.min.js', [], '1.4.2', false);
			wp_script_add_data('html5shivjs', 'conditional', 'lt IE 9');
			wp_script_add_data('responsejs', 'conditional', 'lt IE 9');

			wp_enqueue_style('gb_viewspublic_giveaway_template', plugins_url(sprintf('resources/css/%s.css', current(explode('.', basename(self::$template)))), self::$template), [], GB__PLUGIN__VERSION);
		}

		do_action('\GB\Components\ViewsPublic\Types\Giveaway::resources', $giveaway);
	}

	#endregion Resources

	#region Styles

	public static function styles() {
		$giveaway  = gb_get_giveaway(get_queried_object_id());
		$templates = gb_get_giveaway_templates();
		$template  = gb_get_giveaway_settings($giveaway, 'template');
		$template  = isset($templates[$template]) ? $templates[$template] : [];
		$controls  = isset($template['controls']) && is_array($template['controls']) ? $template['controls'] : [];
		$settings  = gb_get_giveaway_settings($giveaway, 'template_settings');
		$selectors = [];

		foreach($controls as $control_key => $control) {
			if(empty($control['selector']) || empty($control['property'])) { continue; }

			$selector = $control['selector'];
			$property = $control['property'];

			$value = isset($settings[$control_key]) ? $settings[$control_key] : $control['default'];

			if(!empty($selector) && !empty($property) && !empty($value)) {
				if(!isset($selectors[$selector])) { $selectors[$selector] = []; }

				$selectors[$selector][$property] = $value;
			}
		}

		printf('<style type="text/css">%s</style>', implode("\n", array_map(function($selector, $properties) {
			return sprintf('%s{%s}', $selector, implode(' ', array_map(function($property, $value) {
				return sprintf('%s:%s;', $property, $value);
			}, array_keys($properties), $properties)));
		}, array_keys($selectors), $selectors)));

		printf('<style type="text/css">html,body{margin:%dpx;padding:%dpx;</style>', 0, 0);

		do_action('\GB\Components\ViewsPublic\Types\Giveaway::styles', $giveaway);
	}

	#endregion Styles

	#region Template

	private static $template = null;

	public static function template_include($template_orig) {
		if(is_singular(GB__DATA_TYPE__GIVEAWAY)) {
			$data = stripslashes_deep($_POST);

			if(isset($data['gb_n']) && isset($data['gb_e']) && isset($data['gb_s']) && ($giveaway = gb_get_giveaway(get_queried_object_id()))) {
				$nonce_a = sprintf('gb_entry_%d', $giveaway->ID);
				$nonce_k = sprintf('%s_nonce', $nonce_a);
				$nonce_v = isset($data[$nonce_k]) && wp_verify_nonce($data[$nonce_k], $nonce_a);
				$permit  = apply_filters('\GB\Components\ViewsPublic\Types\Giveaway::template::$permit', new \WP_Error, $giveaway, $data);

				if($permit->get_error_code()) {
					self::$errors = $permit;
				} else if(false === $nonce_v) {
					self::$errors = new \WP_Error('invalid_nonce', __('Something went wrong - please try again.'));
				} else if(true === $nonce_v) {
					$address  = gb_get_ipaddress();
					$email    = isset($data['gb_e']) ? wp_strip_all_tags($data['gb_e']) : '';
					$name     = isset($data['gb_n']) ? wp_strip_all_tags($data['gb_n']) : '';
					$referrer = isset($data['gb_r']) ? gb_get_entry_existing($giveaway, '', '', wp_strip_all_tags($data['gb_r'])) : false;
					$entry    = gb_create_entry($giveaway, $address, $email, $name, $referrer, 1);

					if(is_wp_error($entry)) {
						self::$errors = $entry;
					} else {
						gb_setcookie(sprintf('%s_%d', GB__COOKIE_NAME__TRACKING, $giveaway->ID), [
							'address' => $address,
							'email'   => $email,
						], time() + 5 * YEAR_IN_SECONDS);

						gb_redirect(add_query_arg('entry', gb_get_entry_token($entry), get_permalink(get_queried_object_id())));
					}
				}
			}

			$templates     = gb_get_giveaway_templates();
			$template_key  = gb_get_giveaway_settings(get_queried_object_id(), 'template');
			$template_data = isset($templates[$template_key]) ? $templates[$template_key] : reset($templates);
			$template_orig = $template_data['file'];

			self::$template = $template_orig;

			add_action('wp_enqueue_scripts', [__CLASS__, 'resources'], PHP_INT_MAX);
			add_action('wp_head',            [__CLASS__, 'styles'], PHP_INT_MAX - 2);
		}

		return $template_orig;
	}

	public static function template_redirect() {
		if(is_singular(GB__DATA_TYPE__GIVEAWAY)) {
			add_filter('show_admin_bar', '__return_false', PHP_INT_MAX);
		}
	}

	#endregion Template

	#region Public API

	private static $errors = false;

	public static function get_errors() {
		return self::$errors;
	}

	private static $templates = null;

	public static function get_templates($reload) {
		if(is_null(self::$templates) && true !== $reload) {
			self::$templates = get_transient(GB__DATA_TRANS__TEMPLATES);
			self::$templates = is_array(self::$templates) ? self::$templates : null;
		}

		if(is_null(self::$templates) || true === $reload) {
			$templates = apply_filters('\GB\Components\ViewsPublic\Types\Giveaway::get_templates::files', glob(path_join(dirname(__FILE__), 'templates/*.template.php')));
			$templates = array_combine(array_map('md5', $templates), array_map(function($file) {
				$contents = file_get_contents($file);

				$data = get_file_data($file, [
					'name'     => 'Name',
					'image'    => 'Image',
					'controls' => 'Controls',
					'themes'   => 'Themes',
					'default'  => 'Default',
				]);

				// Add the file and file key
				$data['file'] = $file;

				// Normalize the image to a relative path based on the template location
				$data['image'] = plugins_url($data['image'], $file);

				// Controls should be a JSON encoded string - decode it into something usable and normalize it
				$data['controls'] = json_decode($data['controls'], true);
				$data['controls'] = is_array($data['controls']) ? $data['controls'] : [];
				$data['controls'] = array_filter(array_map(function($control) {
					$control['id'] = isset($control['id']) && !empty($control['id']) ? $control['id'] : md5($control['name']);

					return isset($control['name']) && !empty($control['name']) ? shortcode_atts([
						'id'          => '',
						'name'        => '',
						'description' => '',
						'meta'        => '',
						'default'     => '',
						'property'    => '',
						'selector'    => '',
						'type'        => '',
					], $control) : false;
				}, $data['controls']));
				$data['controls'] = empty($data['controls']) ? $data['controls'] : array_combine(wp_list_pluck($data['controls'], 'id'), $data['controls']);

				// Themes should be a decoded JSON encoded string - decode it into something usable and normalize it
				$data['themes'] = json_decode($data['themes'], true);
				$data['themes'] = is_array($data['themes']) ? $data['themes'] : [];
				$data['themes'] = array_filter(array_map(function($theme) {
					$theme['id'] = isset($theme['id']) && !empty($theme['id']) ? $theme['id'] : md5($theme['name']);

					return isset($theme['name']) && !empty($theme['name']) ? shortcode_atts([
						'id'          => '',
						'name'        => '',
						'values'      => [],
					], $theme) : false;
				}, $data['themes']));
				$data['themes'] = empty($data['themes']) ? $data['themes'] : array_combine(wp_list_pluck($data['themes'], 'id'), $data['themes']);

				// Is this the default template?
				$data['default'] = isset($data['default']) && 'Yes' === $data['default'];

				return $data;
			}, $templates));

			// Cache the templates in memory
			self::$templates = apply_filters('\GB\Components\ViewsPublic\Types\Giveaway::get_templates::templates', $templates);

			// Cache the templates in a transient
			set_transient(GB__DATA_TRANS__TEMPLATES, self::$templates, apply_filters('\GB\Components\ViewsPublic\Types\Giveaway::get_templates::transient_timeout', 30 * MINUTE_IN_SECONDS));
		}

		return self::$templates;
	}

	#endregion Public API
}

require_once(path_join(dirname(__FILE__), 'functions/giveaway.functions.php'));

Giveaway::init();
