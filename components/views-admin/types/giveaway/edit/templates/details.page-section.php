<?php if(!defined('ABSPATH')) { exit; } ?>

<h3><?php _e('Details'); ?></h3>

<?php do_action('\GB\Components\ViewsAdmin\Types\Giveaway\Edit::display_details::before_table', $giveaway); ?>

<table class="form-table">
	<tbody>
		<?php do_action('\GB\Components\ViewsAdmin\Types\Giveaway\Edit::display_details::rows_beg', $giveaway); ?>

		<?php if(count($algorithms) > 1) { ?>

		<tr>
			<th scope="row"><label for="<?php echo gb_get_giveaway_setting_field_id('algorithm'); ?>"><?php _e('Winner Algorithm'); ?></label></th>
			<td>
				<select id="<?php echo gb_get_giveaway_setting_field_id('algorithm'); ?>" name="<?php echo gb_get_giveaway_setting_field_name('algorithm'); ?>">
					<?php foreach($algorithms as $algorithm_id => $algorithm_name) { ?>
					<option <?php selected($algorithm_id, gb_get_giveaway_settings($giveaway, 'algorithm')); ?> value="<?php echo esc_attr($algorithm_id); ?>"><?php echo esc_html($algorithm_name); ?></option>
					<?php } ?>
				</select>

				<p class="description"><?php _e('Enter the algorithm used to choose winners from all entrants'); ?></p>
			</td>
		</tr>

		<?php } ?>

		<tr>
			<th scope="row"><label for="<?php echo gb_get_giveaway_setting_field_id('number_winners'); ?>"><?php _e('Number of Winners'); ?></label></th>
			<td>
				<input type="text" class="code regular-text" id="<?php echo gb_get_giveaway_setting_field_id('number_winners'); ?>" name="<?php echo gb_get_giveaway_setting_field_name('number_winners'); ?>" placeholder="<?php echo esc_attr(gb_get_giveaway_settings_defaults()['number_winners']); ?>" value="<?php echo esc_attr(gb_get_giveaway_settings($giveaway, 'number_winners')); ?>" />

				<p class="description"><?php _e('This field is required and must be at least one'); ?></p>
			</td>
		</tr>

		<tr>
			<th scope="row"><label for="<?php echo gb_get_giveaway_setting_field_id('number_winners_d'); ?>"><?php _e('Display Number of Winners'); ?></label></th>
			<td>
				<input type="hidden" name="<?php echo gb_get_giveaway_setting_field_name('number_winners_d'); ?>" value="n" />

				<label>
					<input type="checkbox" <?php checked(gb_get_giveaway_settings($giveaway, 'number_winners_d'), 'y'); ?> id="<?php echo gb_get_giveaway_setting_field_id('number_winners_d'); ?>" name="<?php echo gb_get_giveaway_setting_field_name('number_winners_d'); ?>" value="y" />
					<?php esc_html_e('Yes, display the number of winners on the giveaway page'); ?>
				</label>
			</td>
		</tr>

		<tr>
			<th scope="row"><label for="<?php echo gb_get_giveaway_setting_field_id('value_prize'); ?>"><?php _e('Prize Value'); ?></label></th>
			<td>
				<input type="text" class="code regular-text" id="<?php echo gb_get_giveaway_setting_field_id('value_prize'); ?>" name="<?php echo gb_get_giveaway_setting_field_name('value_prize'); ?>" placeholder="<?php echo esc_attr(gb_get_giveaway_settings_defaults()['value_prize']); ?>" value="<?php echo esc_attr(gb_get_giveaway_settings($giveaway, 'value_prize')); ?>" />

				<p class="description"><?php _e('Enter the prize value to be displayed on the giveaway page'); ?></p>
			</td>
		</tr>

		<tr>
			<th scope="row"><label for="<?php echo gb_get_giveaway_setting_field_id('value_prize_d'); ?>"><?php _e('Display Prize Value'); ?></label></th>
			<td>
				<input type="hidden" name="<?php echo gb_get_giveaway_setting_field_name('value_prize_d'); ?>" value="n" />

				<label>
					<input type="checkbox" <?php checked(gb_get_giveaway_settings($giveaway, 'value_prize_d'), 'y'); ?> id="<?php echo gb_get_giveaway_setting_field_id('value_prize_d'); ?>" name="<?php echo gb_get_giveaway_setting_field_name('value_prize_d'); ?>" value="y" />
					<?php esc_html_e('Yes, display the prize value on the giveaway page'); ?>
				</label>
			</td>
		</tr>

		<tr>
			<th scope="row"><label for="<?php echo gb_get_giveaway_setting_field_id('referral_entries'); ?>"><?php _e('Referral Entries'); ?></label></th>
			<td>
				<input type="text" class="code regular-text" id="<?php echo gb_get_giveaway_setting_field_id('referral_entries'); ?>" name="<?php echo gb_get_giveaway_setting_field_name('referral_entries'); ?>" placeholder="<?php echo esc_attr(gb_get_giveaway_settings_defaults()['referral_entries']); ?>" value="<?php echo esc_attr(gb_get_giveaway_settings($giveaway, 'referral_entries')); ?>" />

				<p class="description"><?php _e('Enter the number of entries you wish a giveaway participant to receive when they successfully refer another person'); ?></p>
			</td>
		</tr>

		<tr>
			<th scope="row"><label for="<?php echo gb_get_giveaway_setting_field_id('datetime_end'); ?>"><?php _e('Giveaway Ends'); ?></label></th>
			<td>
				<input type="text" class="code regular-text gb-datetimepicker" id="<?php echo gb_get_giveaway_setting_field_id('datetime_end'); ?>" name="<?php echo gb_get_giveaway_setting_field_name('datetime_end'); ?>" placeholder="<?php echo esc_attr(gb_get_giveaway_settings_defaults()['datetime_end']); ?>" readonly="readonly" value="<?php echo esc_attr(gb_get_giveaway_settings($giveaway, 'datetime_end')); ?>" />
				<p class="description"><?php _e('This corresponds to your site\'s currently configured timezone'); ?></p>
			</td>
		</tr>

		<tr>
			<th scope="row"><label for="<?php echo esc_attr(gb_get_giveaway_setting_field_id('verification')); ?>"><?php _e('Require Verification'); ?></label></th>
			<td>
				<input type="hidden" name="<?php echo gb_get_giveaway_setting_field_name('verification'); ?>" value="n" />

				<label>
					<input type="checkbox" <?php checked('y', gb_get_giveaway_settings($giveaway, 'verification')); ?> id="<?php echo esc_attr(gb_get_giveaway_setting_field_id('verification')); ?>" name="<?php echo esc_attr(gb_get_giveaway_setting_field_name('verification')); ?>" value="y" />
					<?php _e('Require entry verification using Google reCAPTCHA'); ?>
				</label>

				<p class="description"><strong><?php esc_html_e('Important'); ?>:</strong> <?php printf(__('You must provide your <a href="%s" target="_blank">Google reCAPTCHA credentials</a> to enable entry verification'), esc_url(gb_get_settings_url()));; ?></p>
			</td>
		</tr>

		<tr>
			<th scope="row"><label for="<?php echo gb_get_giveaway_setting_field_id('message_default'); ?>"><?php _e('Default Messaging'); ?></label></th>
			<td>
				<textarea class="code large-text" id="<?php echo gb_get_giveaway_setting_field_id('message_default'); ?>" name="<?php echo gb_get_giveaway_setting_field_name('message_default'); ?>" placeholder="<?php echo esc_attr(gb_get_giveaway_settings_defaults()['message_default']); ?>" rows="5"><?php echo esc_textarea(gb_get_giveaway_settings($giveaway, 'message_default')); ?></textarea>

				<p class="description"><?php _e('This message is displayed to visitors before they have entered before the giveaway has ended'); ?></p>
			</td>
		</tr>

		<tr>
			<th scope="row"><label for="<?php echo gb_get_giveaway_setting_field_id('message_entry'); ?>"><?php _e('Messaging After Entry'); ?></label></th>
			<td>
				<textarea class="code large-text" id="<?php echo gb_get_giveaway_setting_field_id('message_entry'); ?>" name="<?php echo gb_get_giveaway_setting_field_name('message_entry'); ?>" placeholder="<?php echo esc_attr(gb_get_giveaway_settings_defaults()['message_entry']); ?>" rows="5"><?php echo esc_textarea(gb_get_giveaway_settings($giveaway, 'message_entry')); ?></textarea>

				<p class="description"><?php _e('This message is displayed to visitors after they have entered and before the giveaway has ended'); ?></p>
			</td>
		</tr>

		<tr>
			<th scope="row"><label for="<?php echo gb_get_giveaway_setting_field_id('message_ended'); ?>"><?php _e('Messaging After End'); ?></label></th>
			<td>
				<textarea class="code large-text" id="<?php echo gb_get_giveaway_setting_field_id('message_ended'); ?>" name="<?php echo gb_get_giveaway_setting_field_name('message_ended'); ?>" placeholder="<?php echo esc_attr(gb_get_giveaway_settings_defaults()['message_ended']); ?>" rows="5"><?php echo esc_textarea(gb_get_giveaway_settings($giveaway, 'message_ended')); ?></textarea>

				<p class="description"><?php _e('This message is displayed to visitors after the giveaway has ended'); ?></p>
			</td>
		</tr>

		<?php do_action('\GB\Components\ViewsAdmin\Types\Giveaway\Edit::display_details::rows_end', $giveaway); ?>
	</tbody>
</table>

<?php do_action('\GB\Components\ViewsAdmin\Types\Giveaway\Edit::display_details::after_table', $giveaway); ?>
