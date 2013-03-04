$(function() {
	$.addProjectModal = {
		projectForm: $('#ProjectAddForm'),
		errorMessage: $('.display_message .error'),
		successMessage: $('.display_message .success'),
		mask: $('#filocity_modal_dialog_outer'),
		pickerChange: function(dateText, inst) {
		
			 var startDate = $('#ProjectDateStart').datepicker('getDate') ? $('#ProjectDateStart').datepicker('getDate') : new Date();
			// endDate = $('#ProjectDateEnd').datepicker('getDate') ? $('#ProjectDateEnd').datepicker('getDate') : new Date(),
			// id = this.id;
			//if (id == 'ProjectDateStart' && startDate.getTime() >= endDate.getTime()) {
			// if (id == 'ProjectDateStart' && $('#ProjectDateEnd').val()=="") {
				// $('#ProjectDateEnd').datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay));
			// }
			// if (id == 'ProjectDateEnd' && $('#ProjectDateStart').val()=="") {

				// $('#ProjectDateStart').datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, inst.selectedDay));
			// }
			// var startDate = $('#ProjectDateStart').datepicker('getDate');
			// var endDate = $('#ProjectDateEnd').datepicker('getDate');
			// if(startDate==null ||(endDate!=null && endDate < startDate))
			// {
			
			// alert(endDate);
			// alert(1);
			// }
		},
		validateBudget: function() {
			var val = $.trim(this.value);
			$.addProjectModal.errorMessage.empty().hide();
			if ((val.length && !$.isNumeric(val)) || ($.isNumeric(val) && val <= 0)) {
				$.addProjectModal.errorMessage.html('Budget should be Non-zero Numeric.').show();
				$(this).val('');
				return false;
			}
			return true;
		},
		validateDate: function() {		
			var startDate = $('#ProjectDateStart').datepicker('getDate');
			var endDate = $('#ProjectDateEnd').datepicker('getDate');
			if(startDate==null)
			{
			 $.addProjectModal.errorMessage.html('Please select project\'s start date.').show();
			 return false;
			}
			if(endDate!=null && endDate < startDate)
			{
			 $.addProjectModal.errorMessage.html('End date should be greater than start date.').show();
			 return false;
			}
			return true;
		},
		isEmptyExists: function() {
			return $.addProjectModal.projectForm.find('input[type="text"]').filter(function() {
				return ! this.value.replace(/^\s\s*/, '').replace(/\s\s*$/, '');
			}).length === 0;
		},
		redirectToProjectPage: function(project_id) {
			window.location.href = _ROOT + 'projects/view/' + project_id;
		},
		submitForm: function() {
 			if ($('#ProjectName').val()!="" ) {		
			     if($('#ProjectManagerId').val()=="")
				 {
				 $.addProjectModal.errorMessage.html('Please select project manager.').show();
				 return false;
				 }
				
				if($.addProjectModal.validateDate() && $.addProjectModal.validateBudget())
				{
				  $.addProjectModal.projectForm.submit();	
				}				
				/* $('#form_buttons').hide();
				$('.loader_container').show();
				$.post(_ROOT + 'projects/add', $.addProjectModal.projectForm.serialize(),
				function(response) {
					if (response.status == 'y') {
						$.addProjectModal.successMessage.html('Your Project has been added successfully.').show();
						$.addProjectModal.resetForm();
						$('.loader_container').hide();
						$.addProjectModal.redirectToProjectPage(response.project_id);
					} else {
						$.addProjectModal.successMessage.empty().hide();
						$.addProjectModal.errorMessage.html('Project creating failed. Please Try Again.').show();
						$.addProjectModal.resetForm();
						$('.loader_container').hide();
						$('#form_buttons').show();
					}
				},
				'json'); */				               		
				
			} else {
				$.addProjectModal.errorMessage.html('Please fill up all fields.').show();
			}
		},
		resetForm: function() {
			$.addProjectModal.projectForm.find('input, select').val('');
		},
		init: function() {
			// $('#project_files_members_and_budget .add_project_button').on({
				// click: function(e) {
					// $.addProjectModal.mask.fadeIn(0);
					// if( $('#add_project_modal:visible').length ) {
						// $('#add_project_modal:visible').hide(0, function() {
							// $.addProjectModal.resetForm();
							// $('#add_project_modal').show(0);
						// })
					// } else {
						// $('#add_project_modal').show(0);
					// }
				// }
			// });
			$('#ProjectDateStart').datepicker({
				dateFormat: 'mm/dd/yy',
				defaultDate: new Date(),
				constrainInput: true,
				onSelect: $.addProjectModal.pickerChange
			});
			$('#ProjectDateEnd').datepicker({
				dateFormat: 'mm/dd/yy',
				defaultDate: '',
				constrainInput: true,
				onSelect: $.addProjectModal.pickerChange
			});
			$('input#ProjectBudget').on({
				keyup: $.addProjectModal.validateBudget,
				blur: $.addProjectModal.validateBudget,
			});
			$('#form_buttons .done').on({
				click: $.addProjectModal.submitForm
			});
			$('#form_buttons .cancel').on({
				click: function() {
					parent.jQuery.fancybox.close();
				}
			});
		}
	};
	$.addProjectModal.init();
});