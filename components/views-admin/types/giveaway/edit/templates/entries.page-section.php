<?php if(!defined('ABSPATH')) { exit; } ?>

<h3><?php _e('Entries'); ?></h3>

<?php do_action('\GB\Components\ViewsAdmin\Types\Giveaway\Edit::display_entries::before_table', $giveaway); ?>

<div class="tablenav top">
	<div class="alignleft actions gb-actions"><?php echo implode(' ', $actions); ?></div>

	<div class="tablenav-pages">
		<?php printf(_n('%s Entry', '%s Entries', count($entries)), number_format_i18n(count($entries))); ?>
	</div>
</div>

<table class="widefat fixed striped">
	<thead>
		<tr>
			<th scope="col"><?php _e('Email'); ?></th>
			<th scope="col"><?php _e('Name'); ?></th>
			<th scope="col"><?php _e('Entered'); ?></th>
			<th scope="col"><?php _e('Chances'); ?></th>
			<th scope="col"><?php _e('Sources'); ?></th>
		</tr>
	</thead>
	<tbody>

		<?php if(empty($entries)) { ?>

		<tr>
			<td colspan="5"><?php _e('No entries have been received for this giveaway'); ?></td>
		</tr>

		<?php } else { foreach($entries as $entry) { ?>

		<tr>
			<td>
				<?php printf('<a href="mailto:%s">%s</a>', esc_attr(gb_get_entry_tracking_email($entry)), esc_html(gb_get_entry_tracking_email($entry))); ?>

				<div>
					<?php
					echo implode(' | ', array_filter([
						gb_is_entry_winner($entry) ? sprintf('<strong>%s</strong>', esc_html__('Winner')) : false,
						// sprintf('<a href="%s" class="gb-confirm">%s</a>', '#', esc_html__('Invalidate')),
					]));
					?>
				</div>
			</td>
			<td><?php echo esc_attr(gb_get_entry_tracking_name($entry)); ?></td>
			<td>
				<?php echo gb_get_date($entry->post_date)->format(get_option('date_format')); ?><br />
				<?php echo gb_get_date($entry->post_date)->format(get_option('time_format')); ?>
			</td>
			<td><?php echo number_format_i18n(gb_get_entry_chances($entry)) ?></td>
			<td><?php echo implode('<br />', array_map('esc_html', array_map('ucwords', gb_get_entry_sources($entry)))); ?></td>
		</tr>

		<?php } } ?>

	</tbody>
</table>

<div class="tablenav bottom">
	<div class="alignleft actions gb-actions"><?php echo implode(' ', $actions); ?></div>

	<div class="tablenav-pages">
		<?php printf(_n('%s Entry', '%s Entries', count($entries)), number_format_i18n(count($entries))); ?>
	</div>
</div>

<?php do_action('\GB\Components\ViewsAdmin\Types\Giveaway\Edit::display_entries::after_table', $giveaway); ?>
