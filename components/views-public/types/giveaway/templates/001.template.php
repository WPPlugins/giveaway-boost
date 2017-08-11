<?php

if(!defined('ABSPATH')) { exit; }

/*
 * Name:  Default
 * Image: images/screenshot-001.jpg
 * Controls: [{"default":"#000000","id":"background_color","name":"Background Color - Main","property":"background-color","selector":"html,body,.disclaimer-message","type":"colorpicker"},{"default":"#dcb200","id":"background_color_button","name":"Background Color - Button","property":"background-color","selector":".entry-submit","type":"colorpicker"},{"default":"#ffffff","id":"text_color_primary","name":"Text Color - Primary","property":"color","selector":"html,body","type":"colorpicker"},{"default":"#dcb200","id":"text_color_secondary","name":"Text Color - Secondary","property":"color","selector":"a,.highlight","type":"colorpicker"},{"default":"#ffffff","id":"text_color_button","name":"Text Color - Button","property":"color","selector":".entry-submit","type":"colorpicker"},{"default":"#ffffff","id":"border_color","name":"Border Color - Images","property":"border-color","selector":".image-embellishment","type":"colorpicker"},{"default":"0","description":"Upload or select a solid photo of the prize being offered","id":"featured_image","name":"Featured Image","property":"","selector":"","type":"image"},{"default":"0","description":"Choose up to four secondary images to highlight - your images should be the same size and, preferably, square","id":"secondary_image_01","name":"Secondary Image (1)","property":"","selector":"","type":"image"},{"default":"0","id":"secondary_image_02","name":"Secondary Image (2)","property":"","selector":"","type":"image"},{"default":"0","id":"secondary_image_03","name":"Secondary Image (3)","property":"","selector":"","type":"image"},{"default":"0","id":"secondary_image_04","name":"Secondary Image (4)","property":"","selector":"","type":"image"}]
 * Themes: [{"id":"dark","name":"Dark","values":{"background_color":"#000000","background_color_button":"#dcb200","text_color_primary":"#ffffff","text_color_secondary":"#dcb200","text_color_button":"#ffffff","border_color":"#ffffff"}},{"id":"light","name":"Light","values":{"background_color":"#ffffff","background_color_button":"#dcb200","text_color_primary":"#000000","text_color_secondary":"#dcb200","text_color_button":"#ffffff","border_color":"#ffffff"}},{"id":"beauty","name":"Beauty","values":{"background_color":"#ffe0ed","background_color_button":"#923650","text_color_primary":"#000000","text_color_secondary":"#923650","text_color_button":"#ffffff","border_color":"#923650"}},{"id":"hipster","name":"Hipster","values":{"background_color":"#dfdbd6","background_color_button":"#553724","text_color_primary":"#000000","text_color_secondary":"#553724","text_color_button":"#ffffff","border_color":"#ffffff"}}]
 */

$token = isset($_GET['token']) ? stripslashes($_GET['token']) : '';

while(have_posts()) {
	the_post();

	$giveaway = gb_get_giveaway(get_the_ID());
	$datetime = gb_get_date(gb_get_giveaway_settings($giveaway, 'datetime_end'));
	$entry    = gb_get_giveaway_entry_context();
	$ended    = gb_is_giveaway_ended($giveaway);
	$errors   = gb_get_giveaway_entry_context_errors();
?>
<!DOCTYPE html>
<html lang="en" itemscope itemtype="http://schema.org/Article">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<title><?php the_title(); ?></title>

		<?php wp_head(); ?>
	</head>
	<body>
		<?php gb_output_giveaway_body(); ?>

		<div class="container">
			<div class="header">
				<h1 class="giveaway-prize highlight"><?php the_title(); ?></h1>

				<?php
				$value_prize_d    = 'y' === gb_get_giveaway_settings($giveaway, 'value_prize_d');
				$value_prize      = gb_get_giveaway_settings($giveaway, 'value_prize');
				$number_winners_d = 'y' === gb_get_giveaway_settings($giveaway, 'number_winners_d');
				$number_winners   = gb_get_giveaway_settings($giveaway, 'number_winners');
				?>

				<?php if(($number_winners_d && $number_winners) || ($value_prize_d && $value_prize)) { ?>
				<div class="details">
					<?php if($number_winners_d && $number_winners) { ?>
					<div class="details-line"><?php printf(__('Number of Winners: %s'), number_format_i18n($number_winners)); ?></div>
					<?php } ?>

					<?php if($value_prize_d && $value_prize) { ?>
					<div class="details-line"><?php printf(__('Total Prize Value: %s'), esc_html($value_prize)); ?></div>
					<?php } ?>
				</div>
				<?php } ?>
			</div>

			<?php if(($featured_image = gb_get_giveaway_settings($giveaway, 'template_settings.featured_image')) && ($featured_image_src = wp_get_attachment_image_src($featured_image, 'full'))) { ?>
			<div class="container-inner">
				<div class="image-container">
					<?php printf('<img alt="" class="image-featured" src="%s" />', esc_url($featured_image_src[0])); ?>
					<div class="image-embellishment"></div>
				</div>
			</div>
			<?php } ?>

			<?php if(false === $ended) { ?>

			<div class="countdown-container">
				<div class="countdown-container-row">
					<div class="countdown-container-cell"><span class="countdown-item highlight"><?php _e('Only'); ?></span></div>

					<div class="countdown-container-cell countdown-container-cell-countdown">
						<span class="countdown-item">
							<span class="countdown-item-value" data-value="%-D">0</span>
							<span class="countdown-item-label highlight">D</span>
						</span>

						<span class="countdown-item">
							<span class="countdown-item-value">:</span>
							<span class="countdown-item-label highlight">&nbsp;</span>
						</span>

						<span class="countdown-item">
							<span class="countdown-item-value" data-value="%H">0</span>
							<span class="countdown-item-label highlight">H</span>
						</span>

						<span class="countdown-item">
							<span class="countdown-item-value">:</span>
							<span class="countdown-item-label highlight">&nbsp;</span>
						</span>

						<span class="countdown-item">
							<span class="countdown-item-value" data-value="%M">0</span>
							<span class="countdown-item-label highlight">M</span>
						</span>

						<span class="countdown-item">
							<span class="countdown-item-value">:</span>
							<span class="countdown-item-label highlight">&nbsp;</span>
						</span>

						<span class="countdown-item">
							<span class="countdown-item-value" data-value="%S">0</span>
							<span class="countdown-item-label highlight">S</span>
						</span>
					</div>

					<div class="countdown-container-cell"><span class="countdown-item highlight"><?php _e('Left'); ?></span></div>
				</div>
			</div>

			<?php } else { ?>

			<div class="countdown-container countdown-container-init">
				<div class="countdown-container-row">
					<div class="countdown-container-cell"><span class="countdown-item"><?php printf(__('Ended %s at %s'), $datetime->format(get_option('date_format')), $datetime->format(get_option('time_format'))); ?></span></div>
				</div>
			</div>

			<?php } ?>

			<div class="container-inner">

				<?php if(false === $ended) { ?>

					<?php if(false === $entry) { ?>

						<form action="<?php the_permalink(); ?>" class="entry-form" method="post">

							<?php if(is_wp_error($errors)) { printf('<p class="message highlight">%s</p>', implode('<br />', array_map('esc_html', $errors->get_error_messages()))); } ?>

							<div class="entry-input-containers">
								<div class="entry-input-containers-row">
									<div class="entry-input-containers-cell">
										<label class="entry-input-container">
											<input type="text" class="entry-input" id="gb_n" name="gb_n" placeholder="<?php _e('First Name'); ?>" value="" required />
											<span class="entry-input-required">*</span>
										</label>
									</div>

									<div class="entry-input-containers-cell">
										<label class="entry-input-container">
											<input type="email" class="entry-input" id="gb_e" name="gb_e" placeholder="<?php _e('Email'); ?>" value="" required />
											<span class="entry-input-required">*</span>
										</label>
									</div>
								</div>
							</div>

							<?php if('y' === gb_get_giveaway_settings($giveaway, 'verification')) { ?>

							<div class="entry-input-container">
								<div class="entry-recaptcha" id="recaptcha"></div>
							</div>

							<?php } ?>

							<div class="entry-input-container">
								<?php wp_nonce_field(sprintf('gb_entry_%d', $giveaway->ID), sprintf('gb_entry_%d_nonce', $giveaway->ID)); ?>

								<input type="hidden" id="gb_r" name="gb_r" value="<?php echo esc_attr($token); ?>" />
								<input type="submit" class="entry-submit" id="gb_s" name="gb_s"  value="<?php echo esc_attr(gb_get_giveaway_settings($giveaway, 'button_text')); ?>" />
							</div>
						</form>

					<?php } else { ?>

						<div class="entry-chances">
							<div class="chances-notice"><?php printf(__('You have <span class="highlight">%s</span> %s in this giveaway.'), number_format_i18n(gb_get_entry_chances($entry)), _n('entry', 'entries', gb_get_entry_chances($entry))); ?></div>

							<div class="chances-prompt"><?php _e('Earn more entries when your friends sign up. Share this giveaway:');  ?></div>
						</div>

						<div class="entry-methods"><?php gb_output_giveaway_entry_methods($giveaway); ?></div>

					<?php } ?>

					<div class="message">
						<?php
						if(gb_is_giveaway_ended($giveaway)) {
							$message = gb_get_giveaway_settings($giveaway, 'message_ended');
						} else if(false === $entry) {
							$message = gb_get_giveaway_settings($giveaway, 'message_default');
						} else {
							$message = gb_get_giveaway_settings($giveaway, 'message_entry');
						}

						echo wpautop($message);
						?>
					</div>

				<?php } else { // end is_ended ?>

				<div class="message"><?php echo gb_get_giveaway_settings($giveaway, 'message_ended'); ?></div>

				<?php } ?>

				<?php

				$image_urls = wp_list_pluck(array_filter(array_map('wp_get_attachment_image_src', [
					gb_get_giveaway_settings($giveaway, 'template_settings.secondary_image_01'),
					gb_get_giveaway_settings($giveaway, 'template_settings.secondary_image_02'),
					gb_get_giveaway_settings($giveaway, 'template_settings.secondary_image_03'),
					gb_get_giveaway_settings($giveaway, 'template_settings.secondary_image_04'),
				], array_fill(0, 4, 'full'))), 0);

				if($image_urls) {
					printf('<div class="images images-%02d"><div class="images-row">%s</div></div>', count($image_urls), implode('', array_map(function($image_url) {
						return sprintf('<div class="images-cell"><div class="image-container"><img alt="" class="image" src="%s" /><div class="image-embellishment"></div></div></div>', esc_url($image_url));
					}, $image_urls)));
				}

				?>

				<?php if(($disclaimer = gb_get_settings('disclaimer'))) { ?>
				<div class="disclaimer">
					<?php if($entry) { ?>
					<a href="#" class="disclaimer-toggle"><?php esc_html_e('Giveaway Rules'); ?></a>
					<?php } else { ?>
					<a href="#" class="disclaimer-toggle"><?php esc_html_e('By entering, you agree to the giveaway rules.'); ?></a>
					<?php } ?>

					<div class="disclaimer-message"><?php echo wpautop($disclaimer); ?></div>
				</div>
				<?php } ?>
			</div>
		</div>

		<?php wp_footer(); ?>
	</body>
</html>
<?php } ?>
