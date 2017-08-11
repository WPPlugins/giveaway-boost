function initializeMediaPickers() {
	if('undefined' !== typeof wp && 'undefined' !== typeof wp.media) {
		jQuery('.gb-media-selector-container').each(function(index, container) {
			var $container = jQuery(container),
				$actions   = $container.find('.gb-media-selector-action'),
				$button    = $container.find('.gb-media-selector-button'),
				$remove    = $actions.filter('.gb-media-selector-action-remove'),
				$view      = $actions.filter('.gb-media-selector-action-view'),
				$value     = $container.find('.gb-media-selector-value'),
				textButton = $button.data('text-button'),
				textTitle  = $button.data('text-title');

			$button.click(function(event) {
				event.preventDefault();

				var frame = wp.media({
					frame: 'select',

					multiple: false,

					title: textTitle,

					library: {
						type: 'image'
					},

					button: {
						text: textButton
					}
				});

				frame.on('select', function(){
					var media_attachment = frame.state().get('selection').first().toJSON();

					$view.attr('href', media_attachment.url);
					$value.val(media_attachment.id).trigger('change');
				});

				frame.open();
			});

			$remove.click(function(event) {
				event.preventDefault();

				$value.val(0).trigger('change');
			});

			$value.change(function(event) {
				var id = $value.val();

				$actions.toggle(0 != id);
			}).trigger('change');
		});
	}
}

jQuery(document).ready(function($) {
	$('.gb-datetimepicker').datetimepicker({
		dateFormat: 'yy-mm-dd',
		timeFormat: 'HH:mm:ss'
	});

	$('.gb-confirm').click(function(event) {
		event.preventDefault();

		// Append the confirmable dialog if it hasn't previously been appended
		if(0 === $('.gb-notification-dialog-wrap').length) {
			$('body').append(GB_RESOURCES_ADMIN.confirmDialog);
		}

		var $clicked   = $(this),
			$dialog    = $('.gb-notification-dialog-wrap'),
			$cancel    = $dialog.find('[data-cancel]'),
			$confirm   = $dialog.find('[data-confirm]'),
			$markup    = $dialog.find('[data-markup]'),
			$message   = $dialog.find('[data-message]'),
			txtCancel  = $clicked.data('cancel'),
			txtConfirm = $clicked.data('confirm'),
			txtMarkup  = $clicked.data('markup'),
			txtMessage = $clicked.data('message');


		if(txtCancel)  { $cancel.text(txtCancel);   }
		if(txtConfirm) { $confirm.text(txtConfirm); }
		if(txtMarkup)  { $markup.html(txtMarkup);   }
		if(txtMessage) { $message.text(txtMessage); }

		$cancel.one('click', function(event) {
			event.preventDefault();

			$confirm.off('click');
			$dialog.hide();
		})

		$confirm.one('click', function(event) {
			event.preventDefault();

			$cancel.off('click');
			$dialog.hide();

			$clicked.off('click').get(0).click();
		});

		$dialog.show();
	});

	initializeMediaPickers();
});
