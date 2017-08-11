function initializeControls() {
	var $controls = jQuery('.gb-template-control');

	$controls.each(function(index, control) {
		var $control = jQuery(control),
			$input   = $control.find('input,select,button');

		if($input.is('.gb-control-colorpicker')) {
			$input.wpColorPicker({

			});
		}
	});
};

jQuery(document).ready(function($) {
	(function() {
		var request = null;

		$('.gb-template-radio').change(function(event) {
			var $template  = $(this),
				$container = $template.parents('tr');
				$giveaway  = $('#post_ID'),
				$spinner   = $container.find('.spinner').css('visibility', 'visible');

			// Remove the existing controls
			$container.siblings('.gb-template-themes, .gb-template-control').remove();

			if(request) { request.abort(); }

			request = $.post(ajaxurl, {
				action:   GB_VIEWSADMIN_TYPES_GIVEAWAY_EDIT.actionTemplateControls,
				giveaway: $giveaway.val(),
				template: $template.val()
			}, function(data, status) {
				request = null;

				if(data.error) {
					alert(data.message);
				} else {
					$.each(data.controls, function(index, control) {
						$container.parents('tbody').append($(control));
					});

					initializeControls();
					initializeMediaPickers();
				}

				$spinner.css('visibility', 'hidden');
			}, 'json');
		});

		$(document).on('change', '.gb-template-themes', function(event) {
			var values = $(this).find('option:selected').data('values');

			if('undefined' !== typeof values) {
				$.each(values, function(property, value) {
					var $controls = $('.gb-template-control [data-id="' + property + '"]').val(value);

					$controls.filter('.gb-control-colorpicker').wpColorPicker('color', value);
				});
			}
		});

		initializeControls();
	}());

	(function() {
		$('[data-gb_dependent][data-gb_dependent_value]').each(function(index, element) {
			var $element  = $(element),
				dependent = $element.data('gb_dependent'),
				value     = $element.data('gb_dependent_value');

			$(dependent).change(function(event) {
				var $this = $(this),
					show  = $this.is('[type="checkbox"]') ? $this.is(':checked') : value === $this.val();

				$element.toggle(show);
			}).trigger('change');
		});
	}());
});
