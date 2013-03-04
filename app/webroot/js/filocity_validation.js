$(function() {
	$.validateForm = function(form) {
		var self = this,
		step = 1,
		valid = false;
		this.onSubmitForm = function() {
			$(form).submit(function(e) {
				if(valid) return valid;
				e.preventDefault();
				$('div.submit input[type="submit"]').prop('disabled', true);
				$('img.loader_to_modal,  div.submit').toggle(0);
				
				var validation = $(form).serialize();
				$.post(_ROOT + 'users/validation/' + step, validation, function(response) {
					if(!response.isvalid) {
						$.each(response.errors, function(field, errorName) {
							if(field == 'is_agreed') {
								$('div.is_agreed.input.checkbox.required span.caption').css('color', '#f00');
							} else if(field == 'card_expiration_date') {
								$('div.cc-validity-error-message').show();
								$('#UserCardExpirationDateMonth, #UserCardExpirationDateYear').addClass('error');
							} else {
								$('input[name="data[User]['+ field +']"]').val('').attr('placeholder', function(i, oldPlaceholder) {
									return oldPlaceholder.replace(/\s\[.*?\]/g, '') + '  [' + errorName + ']';
								}).addClass('error');
							}
						});
					} else {
						if(step == 1) {
							if($('input:hidden.no_cc_required').length) {
								valid = true;
								$(form).submit();
							} else {
								$('#trial_cc_no_bill_notice').css('bottom', '30px');
								$('img.loader_to_modal').css('bottom', '75px');
								$('#filocity_registration_no_cc_form_wrapper div.submit').css('top', '35px');
								$('#14-day-free-trial:visible').addClass('me_hide').next('#14-day-free-trial-cc:hidden').removeClass('me_hide');
								$('#filocity_registration_no_cc_form_wrapper, #filocity_registration_no_cc_form').addClass('step2');
								step = 2;
							}
						} else if(step == 2) {
							valid = true;
							$(form).submit();
						}
					}
					$('div.submit input[type="submit"]').prop('disabled', false);
					$('img.loader_to_modal,  div.submit').toggle(0);
					
				},'json');
				return false;
			});
		};
		this.onInputWrite = function() {
			$(form).on('focus', 'input.error', function() {
				$(this).removeClass('error')
			});
			$('div.is_agreed.input.checkbox.required input[type="checkbox"]').on('change', function() {
				if(this.checked) {
					$(this).parent().find('span.caption').css('color', 'gray');
				} else {
					$(this).parent().find('span.caption').css('color', '#f00');
					$(this).parent().find('span.caption').css('color', '#f00');
				}
			});
			$('#UserCardExpirationDateMonth, #UserCardExpirationDateYear').on('change', function() {
				$('#UserCardExpirationDateMonth, #UserCardExpirationDateYear').removeClass('error');
			});
		};
		this.onSubmitForm();
		this.onInputWrite();
	};
	$.validateForm('#UserRegistrationForm');
});