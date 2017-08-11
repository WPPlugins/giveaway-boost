<?php if(!defined('ABSPATH')) { exit; } ?>

<h3><?php _e('Design'); ?></h3>

<?php do_action('\GB\Components\ViewsAdmin\Types\Giveaway\Edit::display_design::before_table', $giveaway); ?>

<table class="form-table">
	<tbody>
		<?php do_action('\GB\Components\ViewsAdmin\Types\Giveaway\Edit::display_design::rows_end', $giveaway); ?>

		<tr>
			<th scope="row">
				<?php esc_html_e('Select Layout'); ?><br />
				<span class="spinner gb-spinner"></span>
			</th>
			<td>
				<div class="gb-templates">
					<?php foreach($templates as $template_key => $template) { ?>

					<label class="gb-template">
						<img alt="<?php echo esc_attr($template['name']); ?>" class="gb-template-image" src="<?php echo esc_url($template['image']); ?>" />
						<input type="radio" class="gb-template-radio" <?php checked($template_key, $settings['template']); ?> id="<?php echo gb_get_giveaway_setting_field_id(sprintf('template_%s', $template_key)); ?>" name="<?php echo gb_get_giveaway_setting_field_name('template'); ?>" value="<?php echo esc_attr($template_key); ?>" />
						<div class="gb-template-selected"></div>
					</label>

					<?php } ?>
				</div>
			</td>
		</tr>

		<?php echo implode("\n\n", gb_get_giveaway_template_controls($giveaway, $settings['template'])); ?>

		<?php do_action('\GB\Components\ViewsAdmin\Types\Giveaway\Edit::display_design::rows_end', $giveaway); ?>
	</tbody>
</table>

<?php do_action('\GB\Components\ViewsAdmin\Types\Giveaway\Edit::display_design::after_table', $giveaway); ?>
