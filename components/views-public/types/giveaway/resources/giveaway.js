jQuery(document).ready(function($) {
	// Disclaimer initialization
	(function() {
		$(document).on('click', '.disclaimer-toggle, .disclaimer-cover', function(event) {
			event.preventDefault();

			if($(event.target).is('.disclaimer-toggle, .disclaimer-cover')) {
				$('.disclaimer-cover').toggle();
				$('body').toggleClass('noscroll');
			}
		});

		$('.disclaimer-message').wrap('<div class="disclaimer-cover"></div>');
		$('.disclaimer-toggle').css('display', 'inline');
	}());

	// Countdown initialization
	(function() {
		$('.countdown-container-cell-countdown').each(function(i, container) {
			var $container = $(container);

			$container.countdown(GB_VIEWSPUBLIC_GIVEAWAY.end).on('update.countdown', function(event) {
				$container.find('[data-value]').each(function(j, value) {
					var $value = $(value);

					$value.text(event.strftime($value.data('value')));
				});
			}).on('finish.countdown', function(event) {
				document.location.reload();
			}).parents('.countdown-container').addClass('countdown-container-init');
		});
	}());

	// Entry method popups
	(function() {
		jQuery(document).ready(function($) {
			$('.entry-method-social').click(function(event) {
				event.preventDefault();

				var $link  = $(this),
					height = $link.data('height'),
					width  = $link.data('width'),
					props  = {},
					specs  = '',
					url    = $link.attr('href');

				height = 'undefined' === typeof height ? 600 : height;
				width  = 'undefined' === typeof width  ? 600 : width;

				props.height     = height;
				props.scrollbars = 0;
				props.status     = 0;
				props.width      = width;

				specs = $.map(props, function(value, index) {
					return index + '=' + value;
				}).join(',');

				window.open(url, '_blank', specs);
			});
		});
	}());

	// Copy link with token
	(function() {
		if('undefined' == typeof document.queryCommandSupported || !document.queryCommandSupported('copy')) { return; }

		$('#entry-submit-copy').click(function(event) {
			event.preventDefault();

			$('#entry-input-referral').get(0).select();

			try {
				document.execCommand('copy');

				$('.entry-referral-copied').animate({opacity: 1}, 250, function() {
					setTimeout(function() { $('.entry-referral-copied').animate({opacity: 0}, 250); }, 5000);
				});
			} catch(error) {

			}
		}).css('display', 'inline-block');
	}());
});
