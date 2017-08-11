<?php

namespace GB\Components\ViewsAdmin\Types\Giveaway;

if(!defined('ABSPATH')) { exit; }

class Edit {
	public static function init() {
		self::add_actions();
		self::add_filters();
	}

	private static function add_actions() {
		if(is_admin()) {
			add_action(sprintf('add_meta_boxes_%s', GB__DATA_TYPE__GIVEAWAY), [__CLASS__, 'add_meta_boxes']);
			add_action('admin_enqueue_scripts', [__CLASS__, 'enqueue_resources']);
			add_action('edit_form_top', [__CLASS__, 'output_nonce']);

			// Upsells
			add_action('\GB\Components\ViewsAdmin\Types\Giveaway\Edit::display_design::before_table',  [__CLASS__, 'upsell_design']);
			add_action('\GB\Components\ViewsAdmin\Types\Giveaway\Edit::display_details::after_table',  [__CLASS__, 'upsell_details']);
			add_action('\GB\Components\ViewsAdmin\Types\Giveaway\Edit::display_entries::before_table', [__CLASS__, 'upsell_entries']);
			add_action('edit_form_after_title',                                                        [__CLASS__, 'upsell_title']);
		} else {

		}

	}

	private static function add_filters() {
		if(is_admin()) {
			add_filter('enter_title_here',      [__CLASS__, 'override_title_placeholder'], 10, 2);
			add_filter('post_updated_messages', [__CLASS__, 'updated_messages']);
		} else {

		}

	}

	#region Upsells

	public static function upsell_design($giveaway) {
		$url = 'http://go.giveawayboost.com/get-giveawayboost?utm_source=giveawayboostplugin&utm_medium=link&utm_campaign=giveawayboostaddnewdesign';

		printf('<p>%s - <a href="%s" target="_blank">%s</a></p>', esc_html__('Add a background image and choose from more design layouts in Giveaway Boost Pro'), esc_url($url), esc_html__('click here to learn more'));
	}

	public static function upsell_details($giveaway) {
		$url = 'http://go.giveawayboost.com/get-giveawayboost?utm_source=giveawayboostplugin&utm_medium=link&utm_campaign=giveawayboostaddnewtracking';

		printf('<p>%s - <a href="%s" target="_blank">%s</a></p>', esc_html__('Implement a Facebook tracking pixel or other code to use paid advertising or track the effectiveness of your giveaways with Giveaway Boost Pro'), esc_url($url), esc_html__('click here to learn more'));
	}

	public static function upsell_entries($giveaway) {
		$url = 'http://go.giveawayboost.com/get-giveawayboost?utm_source=giveawayboostplugin&utm_medium=link&utm_campaign=giveawayboostaddnewentries';

		printf('<p>%s - <a href="%s" target="_blank">%s</a></p>', esc_html__('Save time and build your email list by automatically adding entries to Aweber, MailChimp, and more with Giveaway Boost Pro'), esc_url($url), esc_html__('click here to learn more'));
	}

	public static function upsell_title($giveaway) {
		$url = 'http://go.giveawayboost.com/get-giveawayboost?utm_source=giveawayboostplugin&utm_medium=link&utm_campaign=giveawayboostaddnewtop';

		printf('<p>%s - <a href="%s" target="_blank">%s</a></p>', esc_html__('Upgrade to Giveaway Boost Pro to help create more successful giveaways'), esc_url($url), esc_html__('click here to find out more'));
	}

	#endregion Upsells

	#region Messages

	public static function updated_messages($messages) {
		$messages[GB__DATA_TYPE__GIVEAWAY] = [
			 0 => '', // Unused. Messages start at index 1.
			 1 => __('Giveaway updated.'),
			 4 => __('Giveaway updated.'),
			 6 => __('Giveaway published.'),
			 7 => __('Giveaway saved.'),
			 8 => __('Giveaway submitted.'),
			 9 => __('Giveaway scheduled.'),
			10 => __('Giveaway draft updated.'),
		];

		return $messages;
	}

	#endregion Messages

	#region Title Placeholder

	public static function override_title_placeholder($title, $giveaway) {
		$giveaway = gb_get_giveaway($giveaway);

		if(false === $giveaway) { return $title; }

		return __('Enter prize name here');
	}

	#endregion Title Placeholder

	#region Meta Boxes

	public static function add_meta_boxes($giveaway) {
		$giveaway = gb_get_giveaway($giveaway);

		add_action('edit_form_after_title', [__CLASS__, 'display_details']);
		add_action('edit_form_after_title', [__CLASS__, 'display_design']);
		add_action('edit_form_after_title', [__CLASS__, 'display_entries']);
	}

	public static function display_design($giveaway) {
		$settings  = gb_get_giveaway_settings($giveaway);
		$templates = gb_get_giveaway_templates();

		include(path_join(dirname(__FILE__), 'templates/design.page-section.php'));
	}

	public static function display_details($giveaway) {
		$algorithms = gb_get_giveaway_algorithms();
		$giveaway   = gb_get_giveaway($giveaway);
		$settings   = gb_get_giveaway_settings($giveaway);

		include(path_join(dirname(__FILE__), 'templates/details.page-section.php'));
	}

	public static function display_entries($giveaway) {
		$giveaway = gb_get_giveaway($giveaway);
		$entries  = gb_get_giveaway_entries($giveaway);
		$actions  = [];

		// Admin action URL for the entry export
		$nonce_a    = sprintf('%s_%d', GB__ACTION_NAME__ENTRIES_EXPORT, $giveaway->ID);
		$nonce_k    = sprintf('%s_%d_nonce', GB__ACTION_NAME__ENTRIES_EXPORT, $giveaway->ID);
		$export_url = add_query_arg([
			'action'   => GB__ACTION_NAME__ENTRIES_EXPORT,
			'giveaway' => $giveaway->ID,
			$nonce_k   => wp_create_nonce($nonce_a),
		], admin_url('admin.php'));

		$actions['export'] = sprintf('<a class="button button-secondary gb-action" href="%s">%s</a>', esc_url($export_url), __('Export'));

		if(false === gb_is_giveaway_finished($giveaway)) {
			// Admin action URL for the entry export
			$nonce_a     = sprintf('%s_%d', GB__ACTION_NAME__ENTRIES_WINNERS, $giveaway->ID);
			$nonce_k     = sprintf('%s_%d_nonce', GB__ACTION_NAME__ENTRIES_WINNERS, $giveaway->ID);
			$winners_url = add_query_arg([
				'action'   => GB__ACTION_NAME__ENTRIES_WINNERS,
				'giveaway' => $giveaway->ID,
				$nonce_k   => wp_create_nonce($nonce_a),
			], admin_url('admin.php'));

			$algorithms = gb_get_giveaway_algorithms();
			$algorithm  = gb_get_giveaway_settings($giveaway, 'algorithm');
			$algorithmn = isset($algorithms[$algorithm]) ? $algorithms[$algorithm] : reset($algorithms);
			$number     = intval(gb_get_giveaway_settings($giveaway, 'number_winners'));
			$message    = sprintf(__('Are you sure you want to choose the winners for this giveaway? This action is irreversible.'));
			$markup     = sprintf(__('<strong>%s %s</strong> will be selected based on your chosen algorithm: <div><em>%s</em></div>'), number_format_i18n($number), _n('winner', 'winners', $number), $algorithmn);

			$actions['winners'] = sprintf('<a class="button button-secondary gb-action gb-confirm" href="%s" data-markup="%s" data-message="%s">%s</a>', esc_url($winners_url), esc_attr($markup), esc_attr($message), __('Select Winners'));
		}

		$actions = apply_filters('\GB\Components\ViewsAdmin\Types\Giveaway\Edit::display_entries::$actions', $actions);

		include(path_join(dirname(__FILE__), 'templates/entries.page-section.php'));
	}

	#endregion Meta Boxes

	#region Nonce

	public static function output_nonce($giveaway) {
		wp_nonce_field(sprintf('edit_%s_%d', GB__DATA_TYPE__GIVEAWAY, $giveaway->ID), sprintf('edit_%s_%d_nonce', GB__DATA_TYPE__GIVEAWAY, $giveaway->ID));
	}

	#endregion Nonce

	#region Scripts and Styles

	public static function enqueue_resources() {
		$screen = get_current_screen();

		if(isset($screen->post_type) && GB__DATA_TYPE__GIVEAWAY === $screen->post_type && 'post' === $screen->base) {
			wp_enqueue_media();

			wp_enqueue_script('gb_viewsadmin_types_giveaway_edit', plugins_url('resources/edit.js', __FILE__), ['jquery', 'jquery-ui-datepicker', 'wp-color-picker', 'gb_resources_admin'], GB__PLUGIN__VERSION, true);
			wp_enqueue_style('gb_viewsadmin_types_giveaway_edit', plugins_url('resources/edit.css', __FILE__), ['wp-color-picker', 'gb_resources_admin'], GB__PLUGIN__VERSION);

			wp_localize_script('gb_viewsadmin_types_giveaway_edit', 'GB_VIEWSADMIN_TYPES_GIVEAWAY_EDIT', [
				'actionTemplateControls' => GB__AJAX_NAME__TEMPLATE_CONTROLS
			]);
		}
	}

	#endregion Scripts and Styles

	#region Public API

	public static function get_field_id($setting_name) {
		return sprintf('%s-%s', GB__DATA_TYPE__GIVEAWAY, $setting_name);
	}

	public static function get_field_name($setting_name, $multiple = false) {
		return sprintf('%s[%s]%s', GB__DATA_TYPE__GIVEAWAY, $setting_name, (true === $multiple ? '[]' : (is_string($multiple) && !empty($multiple) ? "[{$multiple}]" : '')));
	}

	public static function get_template_controls($giveaway, $template) {
		$giveaway  = gb_get_giveaway($giveaway);
		$templates = gb_get_giveaway_templates();
		$template  = is_string($template) && isset($templates[$template]) ? $templates[$template] : $template;
		$controls  = is_array($template) && isset($template['controls']) && is_array($template['controls']) ? $template['controls'] : [];
		$controls  = apply_filters('\GB\ViewsAdmin\Type\Giveaway\Edit::get_template_controls::controls', $controls, $giveaway, $template);
		$values    = gb_get_giveaway_settings($giveaway, 'template_settings');

		return array_merge([
			self::get_template_themes($template),
		], array_map(function($control_id, $control) use($giveaway) {
			$control_key = sprintf("template_settings.%s", $control_id);
			$field_id    = gb_get_giveaway_setting_field_id($control_key);
			$field_name  = gb_get_giveaway_setting_field_name('template_settings', $control_id);
			$default_val = $control['default'];
			$field_value = gb_get_giveaway_settings($giveaway, $control_key);
			$field_value = empty($field_value) ? $default_val : $field_value;
			$description = isset($control['description']) && !empty($control['description']) ? sprintf('<p class="description">%s</p>', esc_html($control['description'])) : '';

			switch($control['type']) {
				case 'image':
					$input_html = gb_get_media_picker($field_value, $field_id, $field_name, __('Select Image'), __('Select Image'));
					break;

				case 'select':
					$input_opts = is_array($control['meta']) ? array_map(function($item) { return shortcode_atts(['label' => '', 'value' => ''], $item); }, $control['meta']) : [['label' => __('Choose...'), 'value' => '']];
					$input_html = sprintf('<select id="%s" name="%s">%s</select>', $field_id, $field_name, implode("\n", array_map(function($option) use($field_value) { return sprintf('<option %s value="%s">%s</option>', selected(true, $field_value === $option['value'], false), esc_attr($option['value']), esc_html($option['label'])); }, $input_opts)));
					break;

				case 'checkbox':

					break;

				default:
					$input_html = apply_filters('\GB\ViewsAdmin\Data\Types\Giveaway\Edit::get_template_controls::input_html', '', $control_key, $field_id, $field_name, $field_value);
					$input_html = empty($input_html) ? sprintf('<input type="text" class="code regular-text gb-control-%s" id="%s" name="%s" value="%s" data-id="%s" />', esc_attr($control['type']), $field_id, $field_name, esc_attr($field_value), esc_attr($control_id)) : $input_html;

					break;
			}


			return sprintf('<tr class="gb-template-control"><th scope="row"><label for="%s">%s</label></th><td>%s%s</td></tr>', $field_id, esc_html($control['name']), $input_html, $description);
		}, array_keys($controls), $controls));
	}

	public static function get_template_themes($template) {
		$templates = gb_get_giveaway_templates();
		$template  = is_string($template) && isset($templates[$template]) ? $templates[$template] : $template;
		$themes    = is_array($template) && isset($template['themes']) && is_array($template['themes']) ? $template['themes'] : [];
		$themes    = apply_filters('\GB\ViewsAdmin\Type\Giveaway\Edit::get_template_themes::themes', $themes, $template);

		if(empty($themes)) {
			return '';
		} else {
			$input_html = sprintf('<select class="gb-template-themes">%s</select>', implode("\n", array_merge([
				sprintf('<option>%s</option>', esc_html__('Choose a theme')),
			], array_map(function($theme) {
				return sprintf('<option data-values="%s">%s</option>', esc_attr(json_encode($theme['values'])), esc_html($theme['name']));
			}, $themes))));

			return sprintf('<tr class="gb-template-themes"><th scope="row">%s</th><td>%s<p class="description">%s</p></td></tr>', esc_html__('Theme'), $input_html, esc_html__('Optional: Select a pre-configured theme'));
		}
	}

	#endregion Public API
}

require_once(path_join(dirname(__FILE__), 'functions/edit.functions.php'));

Edit::init();
