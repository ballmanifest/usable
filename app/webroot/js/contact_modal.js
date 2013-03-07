$(function() {

	/**
	*	Add Contacts / Groups Modal
	*/
	
	$.ContactsModal = function() {
		var _r = this,
		html = '';
		_r.rowShared = 0;
		_r.newGroupAdd = false;
		this.init = function() {
			if( $.cookie('cotactModalLoad') == 'n') {
				_r.setNavigation();
				_r.onContactLinkClick();
				_r.onGroupLinkClick();
				_r.createNewGroupLinkOnClick();
				_r.createGroupCancelButtonClick();
				_r.contactShareCancelButtonClick();
				_r.contactShareAddShareButtonClick();
				_r.createGroupButtonClick();
				_r.onItemSelection();
				$.cookie('cotactModalLoad', 'y');
			}
			_r.initTrigger();
			_r.getGroups();
		};
		this.initTrigger= function() {
			$('.contact-contact .contact_type:first a').click();
		};
		this.setNavigation = function() {
			$('body').on('click', 'li.contact_type a', function(e) {
				e.preventDefault();
				$('.selected_contact_type').removeClass('selected_contact_type');
				$(this).parent('li').addClass('selected_contact_type');
			});
		};
		this.renderContacts = function(collections) {
			html = '';
			$.each(collections, function(i, item) {
				var key = Object.keys(item)[0];
				html += '<label class="each_contact"><input type="checkbox" value="1" class="contact-choose" data-email="'+ item[key].email +'" data-id="'+ item[key].id +'" data-type="'+ key +'"><span>'+ item[key].email +'</span></label>';
			});
			return html;
		};
		this.renderContactsForCreateGroup = function(collections) {
			var contacts = '';
			$.each(collections, function(i, item) {
				var key = Object.keys(item)[0];
				contacts += 
					'<label class="each_contact">' + 
					'<input type="hidden" name="data['+ i +'][ContactsGroup][contact_id]" value="'+ item[key].id +'">' +
					'<input type="hidden" name="data['+ i +'][ContactsGroup][group_id]" value="0" class="group_id_for_create_group">' +
					'<input type="checkbox" value="1" class="contact-choose" data-id="'+ item[key].id +'" data-type="'+ key +'"><span>'+ item[key].email +'</span></label>';
			});
			return contacts;
		};
		this.onItemSelection = function() {
			$('body').on('click', '.group-panel .each_contact, .show_contacts_for_create_group .each_contact', function() {
				var selectedContacts = $(this).parent().find('input.contact-choose:checked');
				if(selectedContacts.length) {
					$('button.share_btn.inactive_button:visible').removeClass('inactive_button');
				} else {
					$('button.share_btn:visible').addClass('inactive_button');
				}
			});
		};
		this.getGroups = function() {			
			$.get(_ROOT + 'groups/get_groups', function(response) {
				var html = '';
				$.each(response, function(i, item) {
					var key = Object.keys(item)[0];
					html += '<li class="contact_type"><a href="#" data-id="'+ item[key].id +'" data-type="'+ key +'">'+ item[key].name +'</a></li>';
				});
				$('ul.contact-group').html(html);
				if(_r.newGroupAdd) {
					$('li.contact_type:last a[data-id="'+ _r.newGroupAdd +'"]').click();
					_r.newGroupAdd = false;
				}
			}, 'json')
		};
		this.onGroupLinkClick = function() {
			$('body').on('click', '.contact-group li a', function() {	
				$('.group-panel').empty();
				$(this).parent().addClass('loading_content');
				$.post(_ROOT + 'contacts/view/group/' + $(this).data('id'), {
					'data[sort]' : 'last_name'
				}, function(response) {
					var dhtml = _r.renderContacts(response.list);
					$('.group-panel').html(dhtml);
					$('.loading_content').removeClass('loading_content');
				}, 'json');
			});
		};
		this.onContactLinkClick = function() {
			$('body').on('click', '.contact-contact .contact_type a', function(e) {
				e.preventDefault();
				$('.group-panel').empty();
				$(this).parent().addClass('loading_content');
				var filter =  $(this).data('filter');
				$.post(_ROOT + 'contacts/view/' + filter, {
					'data[sort]' : 'first_name'
				}, function(response) {
					if(filter == 'all-members-contacts') {
						$('.group-panel').empty();
						$.each(response.list, function(i, item){
							var dhtml = _r.renderContacts(item);
							$('.group-panel').append(dhtml);
							html = '';
						});
					} else {
						var dhtml = _r.renderContacts(response.list);
						$('.group-panel').html(dhtml);
						html = '';
					}
					$('.loading_content').removeClass('loading_content');
				}, 'json');
			});
		};
		this.createNewGroupLinkOnClick = function() {
			$('body').on('click', '#create_new_group_link', function() {
				$('.success_message').empty();
				$('#contacts_and_groups_container').animate({
					left: '-560px'
				}, 200, function() {
					$('#create_group_modal').removeClass('me_hide');
					$('#fancybox-content').animate({
						width: 405,
						height: 405
					},200);
					
					$('#fancybox-wrap').animate({
						width: 425,
					},200, function() {
						_r.loadContacts();
						$(this).css('overflow', 'none !important');
					});
				});
			});
		};
		this.loadContacts = function() {
			$.post(_ROOT + 'contacts/view/all-contacts', {
				'data[sort]' : 'last_name'
			}, function(response) {
				var dhtml = _r.renderContactsForCreateGroup(response.list);
				$('.show_contacts_for_create_group').html(dhtml);
			}, 'json');
		};
		this.createGroupCancelButtonClick = function() {
			$('body').on('click', 'button.cancel_create_group', function() {
				$('#create_group_modal').addClass('me_hide');
				$('#contacts_and_groups_container').animate({
					left: 0
				}, 200, function() {
					$('#fancybox-content').animate({
						width: 550,
						height: 550
					},200);
					
					$('#fancybox-wrap').animate({
						width: 570,
					},200, function() {
						$(this).css('overflow', 'none !important');
					});
				});
			});
		};
		this.contactShareCancelButtonClick = function() {
			$('body').on('click', '.contact_share_buttons button.cancel_btn', function() {
				$('#contacts_and_groups_container').hide(0, function() {
					$('#share_modal_container').animate({
						left: 0
					}, 200, function() {
						$('#fancybox-content, #fancybox-content > div').animate({
							width: 570,
							height: 395
						},200);
						$('#fancybox-wrap,').animate({
							width: 590
						},200, function() {
							$(this).css('overflow', 'none');
						})
					});
				});
			});
		};
		this.contactShareAddShareButtonClick = function() {
			$('body').on('click', '.contact_share_buttons button.share_btn', function() {
				var tr = '',
				selectedContacts = $('.group-panel input.contact-choose:checked');
				_r.rowShared = $('.selected_users_list tbody tr').length;
				console.log(selectedContacts.length);
				if(selectedContacts.length) {
					selectedContacts.each(function() {
						var T = $(this),
							$input = $('input.share_target_input'),
							shared_with = T.data('type').toLowerCase(),
							shared_with_value = T.data('id'),
							searchItem = T.data('email') ;
						tr += 
							'<tr data-type="'+ shared_with +'" data-id="'+ shared_with_value +'">' + 
								'<td class="user_name">'+ 
									searchItem + 
									'<input type="hidden" readonly name="data['+ _r.rowShared +'][Share][item_name]" value="'+  $('.file_name_to_share').text() +'">' + 
									'<input type="hidden" name="data['+ _r.rowShared +'][Share]['+ shared_with +'_id]" value="'+ shared_with_value +'">' +
									'<input type="hidden" name="data['+ _r.rowShared +'][Share]['+  $input.data('itemkey')  +']" value="'+  $input.data('itemkeyval')  +'"/>' +
									'<input type="hidden" name="data['+ _r.rowShared +'][Share][item_shared]" value="'+  $input.data('itemkey').replace('_id', '')  +'"/>' +
									'<input type="hidden" name="data['+ _r.rowShared +'][Share][notification]" value="'+  $('#contact_tab_panel input[type="checkbox"][name="data[notify]"]').prop('checked')  +'"/>' +
								'</td>' +
								'<td><input type="checkbox" name="data['+ _r.rowShared +'][Share][is_readonly]" value="1" class="is_readonly"></td>' +
								'<td><input type="checkbox" name="data['+ _r.rowShared +'][Share][is_writable]" value="1" class="is_writable"></td>' +
								'<td><input type="checkbox" name="data['+ _r.rowShared +'][Share][is_downloadable]" value="1" class="is_downloadable"></td>' +
								'<td><input type="checkbox" name="data['+ _r.rowShared +'][Share][is_printable]" value="1" class="is_printable"></td>' + 
								'<td><a class="delete_icon"></a></td>' +
							'</tr>';
						_r.rowShared++;
					});
					$('.selected_users_list tbody').append(tr);
					$('.contact_share_buttons .cancel_btn').click();
				} else {
					$('.contact_share_buttons p.error_message').removeClass('me_hide');
				}
			});
		};
		this.createGroupButtonClick = function() {
			var input = $('#created_group_name');
			input.on('keyup', function(){
				if($.trim(this.value)) {
					$(this).css('border-color', '#a8a8a8');
				} else {
					$(this).css('border-color', '#f00');
				}
			});
			
			$('body').on('click', 'button.create_group', function() {
				value = $.trim(input.val());
				if(!value.length) {
					input.css('border-color', '#f00');
					return false;
				}
				var data = {
					'data[Group][name]' : value,
					'data[Group][purpose]' : value
				};
				$('button, img', '.create_group_button').toggle();
				var is_group_already_created = +$('input:hidden.group_id_for_create_group:first').val();
				if(!is_group_already_created) {
					$.post(_ROOT + 'groups/create_group', data, function(response) {
						if(response.status == 'y' && response.group_id) {
							$('.success_message').html('Group <strong>' + value + '</strong> has been created.');
							var group_id = response.group_id,
							selectedContacts = $('.show_contacts_for_create_group input[type="checkbox"]:checked');
							$('input:hidden.group_id_for_create_group').val(group_id);
							if(selectedContacts.length) {
								_r.addContactsToGroup(group_id);
							} else {
								$('.success_message').html('Add some contacts to <strong>' + value + '</strong>' );
								$('button, img', '.create_group_button').toggle();
							}
						}
					}, 'json');
				} else {
					_r.addContactsToGroup(is_group_already_created);
				}
			});
		};
		this.addContactsToGroup = function(group_id) {
			var data = [];
			$('form.save_contacts_group div.show_contacts_for_create_group label').each(function(i) {
				if( $('input[type="checkbox"]', this).is(':checked')) {
					$('input:hidden', this).each(function() {
						var name = this.name, value = this.value, obj = {'name' : name, 'value' : value};
						data.push(obj);
					})
				}
			});
			$.post(_ROOT + 'contacts_groups/save_contacts_groups', data, function(response) {
				if(response.status == 'y') {
					$('.success_message').html('Successfull. Thanks!').show();
					$('button, img', '.create_group_button').toggle();
					_r.getGroups();
					$('button.cancel_create_group').click();
					_r.newGroupAdd = group_id;
				}
			}, 'json');
		};
		this.init();
	};
	$.ContactsModal();	
});