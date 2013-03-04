$(document).ready(function() {
	$('.prevent_selection').off();
	$('.list li.available_to_select .checkbox:not(.enterprise)').on({
		click : function() {
			$('.active_package').removeClass('active_package');
			$(this).parent().toggleClass('active_package');
		}
	});
	$('input.storage_amount').on({
		keyup : function() {
			var value= this.value.replace(/^\s\s*/, '').replace(/\s\s*$/, ''),
			multiplier = +$(this).data('multiply'),
			intTest = /^\d+$/,
			isInt = intTest.test(value);
			$('.error_message:visible').hide(100);
			if( value && isInt) {
				if(1 <= value && value <= 999) {
					var cost = value * multiplier;
					$('.total_storage_cost').empty().text( cost );
				} else {
					$('.total_storage_cost').empty();
					$(this).val('');
					$('.error_message:hidden').show(200);
				}
			} else if ( value && !isInt ) {
				$('.total_storage_cost').empty();
				$(this).val('');
				$('.error_message:hidden').show(200);
			} else {
				$('.total_storage_cost').empty();
			}
		}
	});
	$('body').on({
		click : function() {
			var package_id = $(this).parent().find('input:hidden.package_id').val(),
			company_id = $('input[name="data[Company][id]"]').val(),
			user_id = $('input[name="data[User][id]"]').val(),
			package_price = $(this).parent().find('input:hidden.package_price').val();
			$('table.package_listing tbody td button.active').prop('disabled', true);
			if(confirm('Your new pricing will go into effect immediately.Your first bill will be prorated and future bill will be $'+ package_price +' per month.')) {
				$.ajax({
					url : _ROOT + 'companies/update_package',
					type : 'POST',
					dataType : 'json',
					data : {
						'data[Company][package_id]' : package_id,
						'data[Company][id]' : company_id,
						'data[User][id]' : user_id
					},
					success : function(response) {
						if(response.status == 'y') {
							$('.update_package_change_button').hide().removeClass('update_processing');
							$('.package_update_successful_msg').fadeIn(100);
							window.location.reload();
						}
					}
				});
			} else {
				$('table.package_listing tbody td button.active').prop('disabled', false);
			}
		}
	}, 'button.active');
	$('#package_upgrade_modal_container .cross_icon').on({
		click : function() {
			$('#filocity_modal_dialog_outer, #package_upgrade_modal_container:visible').fadeOut(100);
		}
	});
});
