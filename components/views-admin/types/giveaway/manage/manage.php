<?php

namespace GB\Components\ViewsAdmin\Types\Giveaway;

if(!defined('ABSPATH')) { exit; }

class Manage {
	public static function init() {
		self::add_actions();
		self::add_filters();
	}

	private static function add_actions() {
		if(is_admin()) {
			add_action('admin_notices', [__CLASS__, 'upsell']);
			add_action(sprintf('manage_%s_posts_custom_column', GB__DATA_TYPE__GIVEAWAY), [__CLASS__, 'output_columns'], 10, 2);
		} else {

		}

	}

	private static function add_filters() {
		if(is_admin()) {
			add_filter('bulk_post_updated_messages', [__CLASS__, 'updated_messages'], 11, 2);
			add_filter(sprintf('manage_%s_posts_columns', GB__DATA_TYPE__GIVEAWAY), [__CLASS__, 'add_columns']);
		} else {

		}

	}

	#region Columns

	public static function add_columns($columns) {
		unset($columns['date']);

		$columns['title']                    = __('Prize');
		$columns['gb_giveaway_entries']      = __('Entries');
		$columns['gb_giveaway_datetime_end'] = __('Ends At');

		return $columns;
	}

	public static function output_columns($column, $giveaway) {
		$giveaway = gb_get_giveaway($giveaway);

		if(false === $giveaway) { return; }

		switch($column) {
			case 'gb_giveaway_entries':
				$entries = gb_get_giveaway_entries($giveaway);

				echo esc_html(number_format_i18n(count($entries)));
				break;

			case 'gb_giveaway_datetime_end':
				echo esc_html(gb_get_date(gb_get_giveaway_settings($giveaway, 'datetime_end'))->format(implode(' ', [get_option('date_format'), get_option('time_format')])));
				break;
		}
	}

	#endregion Columns

	#region Messages

	public static function updated_messages($messages, $counts) {
		$messages[GB__DATA_TYPE__GIVEAWAY] = [
			'updated'   => _n('%s giveaway updated.', '%s giveaways updated.', $counts['updated']),
			'locked'    => (1 == $counts['locked']) ? __('1 giveaway not updated, somebody is editing it.') : _n('%s giveaway not updated, somebody is editing it.', '%s giveaways not updated, somebody is editing them.', $counts['locked']),
			'deleted'   => _n('%s giveaway permanently deleted.', '%s giveaways permanently deleted.', $counts['deleted']),
			'trashed'   => _n('%s giveaway moved to the Trash.', '%s giveaways moved to the Trash.', $counts['trashed']),
			'untrashed' => _n('%s giveaway restored from the Trash.', '%s giveaways restored from the Trash.', $counts['untrashed']),
		];

		return $messages;
	}

	#endregion Messages

	#region Upsell

	public static function upsell() {
		$screen = get_current_screen();

		if(isset($screen->post_type) && GB__DATA_TYPE__GIVEAWAY === $screen->post_type && 'edit' === $screen->base) {
			$url = 'http://go.giveawayboost.com/get-giveawayboost?utm_source=giveawayboostplugin&utm_medium=link&utm_campaign=giveawayboostgiveaways';

			printf('<div class="updated"><p>%s - <a href="%s" target="_blank">%s</a></p></div>', esc_html__('Create more effective giveaways and get more entries when you use Giveaway Boost Pro'), esc_url($url), esc_html__('click here to learn more'));
		}
	}

	#endregion Upsell
}

Manage::init();
