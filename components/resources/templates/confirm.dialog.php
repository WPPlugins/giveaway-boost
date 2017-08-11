<?php if(!defined('ABSPATH')) { exit; } ?>

<div class="notification-dialog-wrap gb-notification-dialog-wrap">
	<div class="notification-dialog-background"></div>

	<div class="notification-dialog">
		<div class="post-locked-message">
			<p class="currently-editing wp-tab-first" data-message><?php _e('Are you sure you want to do this?'); ?></p>

			<div data-markup></div>

			<p>
				<a class="button button-primary" href="#" data-confirm><?php _e('Confirm'); ?></a>

				<a class="button" href="#" data-cancel><?php _e('Cancel'); ?></a>
			</p>
		</div>
	</div>
</div>
