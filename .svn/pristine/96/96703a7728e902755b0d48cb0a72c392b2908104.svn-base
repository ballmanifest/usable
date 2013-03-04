$(function() {

	/**
	*	Share Modal
	*/
	$.ShareModal = function() {
		var _r = this;
		_r.serializeData = {};
		_r.found = false;
		_r.rowShared = 0;
		_r.validate_email = /^([a-z0-9._%+-]+)\@([a-z0-9-]+\.)+([a-z0-9]{2,4})$/i;
		_r.newShared = true;
		this.init = function() {
			_r.setTabs();
			_r.onSubmitButtonClick();
			_r.onCancelButtonClick();
			_r.onQuickNoteWrite();
			_r.onSeachBoxWrite();
			_r.onItemSelect();
			_r.addShare();
			_r.deleteShare();
			_r.onHeaderCheckBoxClick();
			_r.eachCheckBoxClick();
			_r.deleteExistingShare();
			_r.onContactLinkClick();
			_r.loadExistingShareIfExists();
			_r.onNotificationChecked();
		};
		this.onNotificationChecked = function() {
			$('body').on('change', 'input[name="data[notify]"]', function() {
				if(this.checked) {
					$('input.each_item_notification').val(1)
				} else {
					$('input.each_item_notification').val(0)
				}
			});
		};
		this.onContactLinkClick = function() {
			$('body').on('click', '#contact_modal_link', function(e) {
				e.preventDefault();
				$('#share_modal_container').animate({
					left: '-580px'
				}, 200, function() {
					$('#fancybox-content, #fancybox-content > div').animate({
						width: 550,
						height: 550
					},200);
					$('#fancybox-wrap, ').animate({
						width: 570
					},200, function() {
						$(this).css('overflow', 'none !important');
					});
					if( $('#contacts_and_groups_container').attr('data-render') == 'n' ) {
						$.get(_ROOT + 'contacts/contact_modal', function(html) {
							$('#contacts_and_groups_container').html(html).show();
							$('#contacts_and_groups_container').attr('data-render', 'y');
						});
					} else {
						$('#contacts_and_groups_container').show();
					}
				});
			});
		};
		this.loadExistingShareIfExists = function() {
			var is_share_exists = +$('#is_share_exists').val();
			if(is_share_exists > 0) {
				//$('a[data-name="existing_shares"].tabs_tab').click();
			}
		};
		this.setTabs = function() {
			$('body').on({
				click : function(e) {
					e.preventDefault();
					var tab_panel = $(this).data('tabpanel');
					var current_tab = $('.active_tab').data('tabpanel');
					if(tab_panel == current_tab) return false;
					$('.tab_panel:visible').hide(0,function() {
						$('#' + tab_panel).show();
						if(tab_panel == 'existing_shares_tab_panel') {
							$('.search_result_container').hide(0);
							if(_r.newShared) {
								$('.existing_users_list tbody').html('');
								$('#display_existing_users').addClass('loading_content');
								$.get(_ROOT + 'shares/get_all_shares_listing/' + $('input.share_target_input').data('itemkey').replace('_id', '') + '/' + $('input.share_target_input').data('itemkeyval'), function(html) {
									$('#display_existing_users').removeClass('loading_content');
									$('.existing_users_list tbody').html(html);
									_r.newShared = false;
								}, 'html');
							}
						} else {
							if( $('input.share_target_input').val().length > 0 ) {
								$('input.share_target_input').keyup();
							}
						}
					});
					$('.tabs_tab').toggleClass('active_tab');
				}
			}, '.tabs_tab');
		};
		this.onHeaderCheckBoxClick = function() {
			$('body').on({
				click : function() {
					if( $('.selected_users_list tbody tr').length > 0 ) {
						$('.selected_users_list tbody input[type="checkbox"].' + this.className).prop('checked', this.checked);
					}
				}
			}, '.selected_users_list thead input[type="checkbox"]');
		};
		this.eachCheckBoxClick = function() {
			$('body').on({
				click : function() {
					var unchecked = $(this).parent().closest('tbody').find('input[type="checkbox"].' + this.className).filter(function() { return !this.checked;}).length === 0;
					$('.selected_users_list thead input[type="checkbox"].' + this.className).prop('checked', unchecked);
				}
			}, '.selected_users_list tbody input[type="checkbox"]');
		};
		this.onSeachBoxWrite = function() {
			$('body').on({
				keyup : function(e) {
					$('p.error_message:visible').slideUp(0);
					_r.found = false;
					var value = $.trim(this.value);
					if(!value.length) {
						$('.search_result_container:visible').hide(0);
						return false;
					}
					$('.search_result_container li').hide(0).find('span').each(function() {
						$(this).replaceWith($(this).text());
					});
					var pattern = new RegExp(value, 'ig');
					var matched = $('.search_result_container').slideDown(0).find('li').filter(function() {
						return !!$(this).text().match(pattern);
					});
					if(matched.length) {
						console.log(matched);
						matched.html(function(index,oldhtml) {
							return oldhtml.replace(pattern,"<span style='color:#39A2EC'>"+ value +"</span>");
						}).show(0);
					} else  {
						$('.search_result_container:visible').hide(0);
					}
					if(e.which == 13) {		
						$('.search_result_container:visible').hide(0);
						$('.btn.add_share:visible, .btn.filebcab_share_add:visible').click();
					}
				}
			}, 'input.share_target_input:visible, input.invite_to:visible');
		};
		this.onQuickNoteWrite = function() {
			$('input.quick_note_box').on('keyup', function() {
				$('input:hidden[name="data[quick_note]"]').val(this.value);
			});
		};
		this.onItemSelect = function() {
			$('body').on({
				click : function() {
					$('p.error_message:visible').slideUp(0);
					var item = $(this),
					type = item.data('type'),
					id = item.data('id');
					$('input.share_target_input, input.invite_to').val(item.text());
					$('input:hidden.share_with_key').val(type + '_id');
					$('input:hidden.share_with_value').val(id);
					$('.search_result_container:visible').hide(0);
					_r.found = true;
				}
			}, '.search_result_container li');
		};
		this.addShare = function() {
			$('body').on({
				click : function(e) {
					e.preventDefault();
					var $input = $('input.share_target_input:visible, input.invite_to:visible'), 
						searchItem = $input.val();
						
					if(!searchItem.length) {
						$('p.error_message').html('No item to share').slideDown(0);
						return false;
					} else {
						if(!_r.found && !_r.validate_email.test(searchItem)) {
							$('p.error_message').html('Please Choose any Item or insert a valid email address for guest share').slideDown(0);							
							return false;
						}
						
						var tbody = $('.selected_users_list tbody');
						if($('#eventPopulateModal').is(':visible')) {
							tbody = $('.add_share_for_event_modal tbody');
						}
						var shared_with = _r.found ? $('input.share_with_key').val() : 'guest_id',
						shared_with_value = _r.found ? $('input.share_with_value').val() :  _r.rowShared;
						$('.search_result_container li[data-id="'+ shared_with_value +'"][data-type="'+ shared_with.replace('_id','' ) +'"]').addClass('add_to_share');
						
						_r.rowShared = $('tr', tbody).length;
						var	tr = 
							'<tr data-type="'+ shared_with.replace('_id','' ) +'" data-id="'+ _r.rowShared +'" data-itemid="'+ shared_with_value +'">' + 
								'<td class="user_name">'+ 
									searchItem + 
									'<input type="hidden" readonly name="data['+ _r.rowShared +'][Share][item_name]" value="'+ $('.file_name_to_share').text() +'">' + 
									'<input type="hidden" name="data['+ _r.rowShared +'][Share]['+ (shared_with == 'user_id' ? 'user2' : shared_with) +']" value="'+ _r.rowShared +'">' +
									'<input type="hidden" name="data['+ _r.rowShared +'][Share]['+  $input.data('itemkey')  +']" value="'+  $input.data('itemkeyval')  +'"/>' +
									'<input type="hidden" name="data['+ _r.rowShared +'][Share][item_shared]" value="'+  $input.data('itemkey').replace('_id', '')  +'"/>' +
									'<input type="hidden" class="each_item_notification" name="data['+ _r.rowShared +'][Share][notification]" value="'+ ($('input[name="data[notify]"]').prop('checked') ? 1 : 0 )+'"/>' +
									(!_r.found && shared_with == 'guest_id' ? '<input type="hidden" name="data['+ _r.rowShared +'][Share][guest_email]" value="'+ searchItem +'">' : '') + 
								'</td>' +
								'<td><input type="checkbox" name="data['+ _r.rowShared +'][Share][is_readonly]" value="1" class="is_readonly"></td>' +
								'<td><input type="checkbox" name="data['+ _r.rowShared +'][Share][is_writable]" value="1" class="is_writable"></td>' +
								'<td><input type="checkbox" name="data['+ _r.rowShared +'][Share][is_downloadable]" value="1" class="is_downloadable"></td>' +
								'<td><input type="checkbox" name="data['+ _r.rowShared +'][Share][is_printable]" value="1" class="is_printable"></td>' + 
								'<td><a class="delete_icon"></a></td>' +
							'</tr>';
							
						tbody.append(tr);
						if($('#eventPopulateModal').is(':visible')) {
							$('.display_share_permissions').show(0);
						}	
						$('.notification_share_cancel_panel button.share_btn, .btn.filebcab_share_add').removeClass('inactive_button');
						$('input:hidden.share_with_value, input.share_target_input, input.invite_to, input:hidden.share_with_key').val('');		
						_r.found = false;
					}
				}
			}, '.btn.add_share:visible, .btn.filebcab_share_add:visible');
		};
		this.deleteShare = function() {
			$('body').on({
				click : function() {
					var row = $(this).parent().closest('tr'),
					type = row.data('type'),
					id = row.data('itemid');
					$('.search_result_container li[data-id="'+ id +'"][data-type="'+ type +'"]').removeClass('add_to_share');
					_r.rowShared = $('.selected_users_list:visible tbody tr, .add_share_for_event_modal:visible tbody tr').length;
					row.remove();
					_r.rowShared--;
					if(_r.rowShared <= 0) {
						$('.notification_share_cancel_panel button.share_btn, .btn.filebcab_share_add').addClass('inactive_button');
					}	
				}
			}, '#display_selected_users:visible .delete_icon, .document_or_folder_share_segment:visible .delete_icon');
		};
		this.refreshShareAutofillList = function() {
			var itemKey = $('input.share_target_input').data('itemkey'),
			itemId = $('input.share_target_input').data('itemkeyval');
			$.get(_ROOT + 'shares/refresh_share_autofill_list/' + itemKey + '/' + itemId, function(html){
				if(html.length) {
					$('.search_result_container').html(html);
				}
			}, 'html')
		};
		this.deleteExistingShare = function() {
			$('body').on({
				click : function() {
					var ref = this;
					$(this).addClass('deleting');
					$.get(_ROOT + 'shares/delete/' + this.id.replace('s_',''), function(response) {
						if(response.status == 'y') {
							$(ref).parent().closest('tr').remove();
							_r.refreshShareAutofillList();
						}
					}, 'json');
				}
			}, '#display_existing_users .delete_icon');
		};
		this.submitShareForm = function(e) {
			if($('.active_tab').data('name') == 'contacts' &&  $('.selected_users_list:visible tbody tr').length > 0) {
				$('button, img', '.notification_share_cancel_panel').toggle();
				$.post(_ROOT + 'shares/add_share', $('form.submit_shares_form').serialize(), function(response) {
					if(response.status == 'y') {
						// update counter
						var counter = $(handlerToThisShare).prev('.counter');
						if(counter.length) {
							counter.text(function(i, oldText) {
								var count = parseInt(oldText, 10);
								count = count + $('.selected_users_list tbody tr').length;
								return count;
							});
						} else {
							$(handlerToThisShare).parent().prepend('<a class="counter">'+ $('.selected_users_list tbody tr').length +'</a>');
						}
						handlerToThisShare = null;
						$('button, img', '.notification_share_cancel_panel').toggle();
						_r.newShared = true;
						$('.selected_users_list input[type="checkbox"], input[name="data[notify]"]').prop('checked', 0);
						$(e.target).parent('.notification_share_cancel_panel').find('button').show(0).end().find('img').addClass('me_hide');
						$('.selected_users_list tbody').empty();
						$('.notification_share_cancel_panel button.cancel_btn').click();
					}
				}, 'json');
			}
		};
		this.onSubmitButtonClick = function() {
			$('body').on('click', '.notification_share_cancel_panel button.share_btn', _r.submitShareForm);
		};
		this.onCancelButtonClick = function() {
			$('body').on('click', '.notification_share_cancel_panel button.cancel_btn', function() {
				$('#fancybox-close').click();
			});
		};
		return this;
	};
});