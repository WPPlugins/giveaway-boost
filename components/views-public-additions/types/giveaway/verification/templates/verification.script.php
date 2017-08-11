<?php if(!defined('ABSPATH')) { exit; } ?>

<!-- Google Recaptcha -->
<script type="text/javascript">
var recaptchaCallback = function() {
	grecaptcha.render('recaptcha', {
		sitekey: '<?php echo esc_attr($site_key); ?>'
	});
};
</script>
<script type="text/javascript" src="https://www.google.com/recaptcha/api.js?onload=recaptchaCallback&render=explicit"></script>
