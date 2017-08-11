<?php if(!defined('ABSPATH')) { exit; } ?>

<div class="wrap">
	<h1><?php _e('Giveaways - Settings'); ?></h1>

	<?php settings_errors(); ?>

	<?php if(count($errors)) { ?>

	<div class="error"><p><strong><?php _e('Warning!'); ?></strong> <?php _e('Some errors were detected with your settings. Please fix the indicated problems.'); ?></p></div>

	<?php } ?>

	<form action="options.php" method="post">
		<?php do_settings_sections(GB__PAGE_SLUG__SETTINGS); ?>

		<p class="submit submit-bp-settings">
			<?php settings_fields(GB__PAGE_SLUG__SETTINGS); ?>
			<input type="submit" class="button button-primary" value="<?php _e('Save Changes'); ?>" />
		</p>
	</form>
</div>
