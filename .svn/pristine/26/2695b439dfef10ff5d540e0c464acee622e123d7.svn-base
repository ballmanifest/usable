$(function() {
	var addTarget = null,
	theText = null,
	handler = null;;
	function toggleModal(left, top) {
		$('.the_add_modal').css({
			top: top + 5,
			left: left + 60
		}).slideDown(200);
	}
	function toggleVisibilityModal(left, top, el) {
		$('.the_visibility_modal').css({
			top: top + 5,
			left: left + $(el).outerWidth() + 10
		}).slideDown(200);
	}
	function textChanger(el) {
		el.text(function() {
			return this.className.indexOf('add') <= 0 ? '+ add': 'edit';
		}).removeClass('cancel_task');
	}
	function updateModal() {
		$.ajax({
			type: 'POST',
			url: _ROOT + 'shares/update_modal',
			data : {
				'data[Share][vistype]' : $('input.selected_category').val(),
				'data[Share][project_id]' : $('input.selected_project_id:hidden').val()
			},
			dataType: 'JSON',
			success: function(data) {
				console.log(data);
				if(data.status == 'y' && data.data) {
					$('.add_members_modal_wrapper .members_list').empty();
					var members_html = '',
					users = data.data,
					projectID = $('input.selected_project_id:hidden').val(),
					memberClass = 'profile_name';
					for (var x in users) {
						console.log(users[x]);
						members_html += '<li>'+
									'<div class="project_member">'+
										'<div class="member_photo">'+
											'<img src="' + _ROOT + 'img/filocity_img/user_' + users[x]['User']['id'] + '/profile.jpg">'+
										'</div>'+
										'<div class="member_info" id="' + projectID + '">'+
											'<a href="#" class="' + memberClass + '" id="' + users[x]['User']['id'] + '">' + users[x]['User']['first_name'] + ' ' + users[x]['User']['last_name'] + '</a> ' + users[x]['User']['department'] + '<br>'+
											users[x]['Task']['count'] + ' tasks assigned, ' + users[x]['Task']['active'] + ' active<br>'+
											'Budget Spent: <strong>75%</strong>'+
										'</div>'+
									'</div>'+
								'</li>';
					}
					$('.add_members_modal_wrapper .members_list').append(members_html);
				}
			}
		});
	}
	$('body').on('click', '.permission_add a.add, a.edit',
	function(e) {
		e.preventDefault();
		$('.active_permission_add').removeClass('active_permission_add');
		$(this).addClass('active_permission_add');
		var pos = $(this).position(),
		left = pos.left,
		top = pos.top,
		visibleModal = $('.the_add_modal:visible');
		theText = $(this);
		if ($('.the_modal:visible').length) {
			$('.the_modal:visible').slideUp(200);
		}
		if ($(addTarget).is(this)) {
			textChanger(theText);
			visibleModal.slideUp(200);
			addTarget = null;
			return false;
		}
		if (visibleModal.length) {
			textChanger($('.cancel_task'));
			visibleModal.slideUp(200,
			function() {
				toggleModal(left, top)
			});
		} else toggleModal(left, top);
		addTarget = this;
		var projectID = null,
		memberClass = null;
		if ($(this).attr('class').substring(0, 4) == 'edit') {
			projectID = $(this).parents('.name').siblings('input.project_id_holder').val();
			memberClass = 'project_manager';
		} else {
			projectID = $(this).parents('.permission_holders_tags').find('input.project_id_holder').val();
			memberClass = 'profile_name';
		}
	});
	$('body').on('click', '.project_manager',
	function(e) {
		e.preventDefault();
		var user_id = $(this).attr('id');
		var project_id = $(this).closest('div').attr('id');
		$.ajax({
			url: _ROOT + 'shares/add_new_manager',
			type: 'POST',
			dataType: 'JSON',
			data: {
				'data[User][id]': user_id,
				'data[Project][id]': project_id
			},
			success: function(res) {
				if (res != 'exist') {
					$('.name').children('a[id^=\'manager_' + project_id + '\']').text(' ');
					$('.name').children('a[id^=\'manager_' + project_id + '\']').text(res[0]['User']['first_name'] + ' ' + res[0]['User']['last_name']);
				} else {
					alert('Already exit!');
				}
			}
		});
	});
	$('body').on('click', '.profile_name',
	function(e) {
		e.preventDefault();
		var user_id = $(this).attr('id');
		var project_id = $(this).closest('div').attr('id');
		$.ajax({
			url: _ROOT + 'shares/add_new_permission',
			type: 'POST',
			dataType: 'JSON',
			data: {
				'data[User][id]': user_id,
				'data[Project][id]': project_id
			},
			success: function(res) {
				if (res != 'exist') {
					var last_name = res[0]['User']['first_name'];
					$('.active_permission_add').parents('.permission_holders_tags').children('.permission_add').before('\
						<div class="permission_tag">\
							<span class="cross_tag" id="' + res[0]['User']['id'] + '">&#x2715</span>\
							<span class="name_tag">' + res[0]['User']['last_name'] + ', ' + last_name.charAt(0) + '.' + '</span>\
						</div>\
					');
				} else {
					alert('Already exist!');
				}
			}
		});
	});
	$('body').on('click', '.cross_tag',
	function() {
		var user_id = $(this).parent().data('userid'),
		share_id = $(this).parent().data('shareid');
		$(this).parent('.permission_tag').remove();
		$.ajax({
			url: _ROOT + 'shares/delete_permission',
			type: 'POST',
			dataType: 'JSON',
			data: {
				'data[User][id]': user_id,
				'data[Share][id]': share_id,
			},
			success: function(data) {}
		});
	});
	$('.member_visibility').on('click',
	function(e) {
		e.preventDefault();
		var pos = $(this).position(),
		left = pos.left,
		top = pos.top,
		visibleModal = $('.the_visibility_modal:visible'),
		el = this;
		$('input.selected_project_id:hidden').val($(this).data('projectid'));
		if ($('.the_modal:visible').length) {
			$('.the_modal:visible').slideUp(200);
			textChanger($('.cancel_task'));
		}
		$('#directory_dd_options:visible').slideUp(200,
		function() {
			$('#directory_dd').find('.dd_pointer').removeClass('dd_pointer_up');
		});
		if ($(handler).is(this)) {
			visibleModal.slideUp(200);
			handler = null;
			return false;
		}
		if (visibleModal.length) {
			visibleModal.slideUp(200,
			function() {
				toggleVisibilityModal(left, top, el)
			});
		} else toggleVisibilityModal(left, top, el);
		handler = this;
	});
	$('#directory_dd').on({
		click: function() {
			var vis = $('#directory_dd_options');
			if (vis.is(':visible')) {
				vis.slideUp(200,
				function() {
					$('.the_visibility_modal:visible').slideUp(200);
				});
				$(this).find('.dd_pointer').removeClass('dd_pointer_up');
			} else {
				vis.slideDown(200);
				$(this).find('.dd_pointer').addClass('dd_pointer_up');
			}
		}
	});
	$('#directory_dd_options li').on({
		click: function() {
			var text = $('a', this).text(),
			value = $('input:hidden', this).val();
			$('.dd_select').html(text);
			$(handler).html(text + ':');
			handler = null;
			$('#directory_dd').click();
			if( $('input.selected_category').val() != value ) {
				$('input.selected_category').val(value);
				updateModal();
			}
		}
	});
	$(".member_search").autocomplete({
		source: _ROOT + '/shares/search_project_member',
		delay: 100,
		select: function(event, ui) {
			$(this).parent().parent().children("input").val(ui.item.id);
		},
		open: function(event, ui) {
			$(this).parent().parent().children("input").val(0);
			$('.ui-corner-all').css({
				'display': 'none'
			});
			$('.members_list li').each(function(e) {
				var d1 = $(this).find('.profile_name').text().charAt(0);
				var d2 = $('.ui-menu-item a.ui-corner-all').text().charAt(0);
				if (d1 == d2) {
					$(this).closest('li').siblings('li').remove();
					$('.members_list').append($(this));
				} else {
					$(this).parentsUntil('.members_list').children('li').remove();
				}
			});
		}
	});
});