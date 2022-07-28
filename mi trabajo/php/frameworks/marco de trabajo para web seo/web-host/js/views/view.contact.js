/*
Name: 			View - Contact
Written by: 	Okler Themes - (http://www.okler.net)
Version: 		4.4.0
*/

(function($) {

	'use strict';

	/*
	Contact Form: Basic
	*/
	$('#contactForm:not([data-type=advanced])').validate({
		submitHandler: function(form) {

			var $form = $(form),
				$messageSuccess = $('#contactSuccess'),
				$messageError = $('#contactError'),
				$submitButton = $(this.submitButton);

			$submitButton.button('loading');
 
			$.ajax({
				type: 'POST',
				url: $form.attr('action'),
				data: {
					nombre: $form.find('#nombre').val(),
					apellidos: $form.find('#apellidos').val(),
					email: $form.find('#email').val(),
					servicios: $form.find('#servicio').val(),
					telefono: $form.find('#telefono').val(),
					mensaje: $form.find('#mensaje').val()
				},
				dataType: 'json',
				complete: function(data) {
				
					if (typeof data.responseJSON === 'object') {
						if (data.responseJSON.response == 'success') {

							$messageSuccess.removeClass('hidden');
							$messageError.addClass('hidden');
 
							$form.find('.form-control')
								.val('')
								.blur()
								.parent()
								.removeClass('has-success')
								.removeClass('has-error')
								.find('label.error')
								.remove();

							if (($messageSuccess.offset().top - 80) < $(window).scrollTop()) {
								$('html, body').animate({
									scrollTop: $messageSuccess.offset().top - 80
								}, 300);
							}

							$submitButton.button('reset');
							
							return;

						}
					}

					$messageError.removeClass('hidden');
					$messageSuccess.addClass('hidden');

					if (($messageError.offset().top - 80) < $(window).scrollTop()) {
						$('html, body').animate({
							scrollTop: $messageError.offset().top - 80
						}, 300);
					}

					$form.find('.has-success')
						.removeClass('has-success');
						
					$submitButton.button('reset');

				}
			});
		}
	});

	/*
	Contact Form: Advanced
	*/
	$('#Spresupuesto, #contactForm[data-type=advanced]').validate({
		onkeyup: false,
		onclick: false,
		onfocusout: false,
		rules: {
			'captcha': {
				captcha: false
			},
			'checkboxes[]': {
				required: false
			},
			'radios': {
				required: false
			}
		},
		errorPlacement: function(error, element) {
			if (element.attr('type') == 'radio' || element.attr('type') == 'checkbox') {
				error.appendTo(element.parent().parent());
			} else {
				error.insertAfter(element);
			}
		}
	});

}).apply(this, [jQuery]);