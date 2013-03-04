$(function() {
	/**
	*	Render Add Project Member modal
	*/
	$.addProjectMemberModal = {
		addMemberForm: $('#ProjectMemberAdd'),
		errorMessage: $('#add_proj_member_form .display_message .error'),
		successMessage: $('#add_proj_member_form .display_message .success'),
		mask: $('#filocity_modal_dialog_outer'),
		showAddMemberModal : function(e) {
			e.preventDefault();
			var project_id = $('input:hidden.project_id').length ? $('input:hidden.project_id').val() : '',
				$this = this;
			$($this).hide().next('img.loader_img').show();
			$.get(_ROOT + 'projects_users/add_project_member/' + project_id, function(response) {
				if($('#add_project_member_modal').length) {
					$('#add_project_member_modal').remove();
				}
				$('#project_page_container').append(response);
				$('#add_project_member_modal, #filocity_modal_dialog_outer').show();
				$('#ProjectsUserUserId, #ProjectIsAdmin').change();
				$($this).show().next('img.loader_img').hide();
			}, 
			'html');
		},
		submitForm: function() {
			$('.loader_container').show();
			$.post(_ROOT + 'projects_users/add',  $('#add_project_member_modal #ProjectMemberAdd').serializeArray(),
			function(response) {
				if(response.status == 'y') {
					$.addProjectMemberModal.errorMessage.hide(50);
					$.addProjectMemberModal.successMessage.show(50);
					window.location.reload();
				} else {
					$.addProjectMemberModal.successMessage.hide(100);
					$.addProjectMemberModal.errorMessage.show(100);
					$('.loader_container').hide();
					$('#add_proj_member_form_buttons').show();
				}
			},
			'json');
		},
		init : function() {
			$('#grand_container').on({
				click: $.addProjectMemberModal.submitForm
			},'#add_proj_member_form_buttons button.done');
			$('#grand_container').on({
				click: function() {
					$('#add_project_member_modal:visible').hide(0);
					$.addProjectMemberModal.mask.fadeOut(0);
				}
			}, '#add_project_member_modal .cross_icon, #add_proj_member_form_buttons button.cancel');
			$('#grand_container').on({
				change : function() {
					$('#ShareUser2Id').val(this.value);
				}
			}, '#ProjectsUserUserId');
			$('#grand_container').on({
					change : function() {
						$('#ShareIsAdmin').val(this.value);
					}
			}, '#ProjectIsAdmin');
			$('.add_project_member_button').on({
				click: $.addProjectMemberModal.showAddMemberModal
			});
		}
	};
	$.addProjectMemberModal.init();
});