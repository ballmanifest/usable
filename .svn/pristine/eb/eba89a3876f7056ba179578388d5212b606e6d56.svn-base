$(function() {	

	/**
	*		File Sharing JS
	*/

	$.FileSharing = {
		seachResultContainer: $('<ul/>', {'class': 'search_result_container me_hide', html: ''}),
		showSearchResult: null,
		data : {},
		shareType : null,
		isTargetFound : false,
		isValidEmail : false,
		validate_email : /^([a-z0-9._%+-]+)\@([a-z0-9-]+\.)+([a-z0-9]{2,4})$/i,
		hideSuggestion: function() {
			$('.search_result_container:visible').slideUp(0);
		},
		getData : function() {
			$.post(
				_ROOT + 'users/get_everything',
				{},
				function(response) {
				if(response.status == 'y') {
					$.FileSharing.seachResultContainer.html(response.html);
				}
			},
			'json');
		},
		addSpecificShareRow: function(e) {
			e.preventDefault();
			var config = $.FileSharing.data;
			if(!$('.doc-share:visible input[type="text"]').val().length) {
				alert('Choose some item');
				return false;
			}
			
			if(!$.FileSharing.isTargetFound && $.FileSharing.isValidEmail) {
				config = { 
					id : ++$('.doc-share:visible input:hidden[name="guest_id"]').length,
					type : 'guest',
					text : $('.doc-share:visible input[type="text"]').val(),
					itemId : $('.doc-share:visible').attr('id').replace(/(share)|(folder_share)/, ''),
				};
			}
			var share_type = $.FileSharing.shareType,
			row = 
			'<div class="row" data-type="'+ config.type +'" data-id="'+ config.id +'">'+
				'<div class="left strong">'+ config.text +'</div>'+
				'<div class="right"> <input name="rwx_'+ config.id +'" type="radio" value="r" class="read" checked></div>'+
				'<div class="right"> <input name="rwx_'+ config.id +'" type="radio" value="w" class="write"></div>'+
				'<div class="right"> <input type="checkbox" value="s" class="share"></div>'+
				'<input type="hidden" name="'+ config.type + '_id' +'" value="'+ config.id +'">'+
				'<input type="hidden" name="'+ share_type +'_id" value="'+ config.itemId +'">'+
				'<input type="hidden" name="guest_email" value="'+ config.text +'">'+
				'<input type="hidden" name="item_name" value="'+ $('.doc-share:visible input:hidden.itemaization_of_item').val() +'">'+
				'<input type="hidden" name="access" value="" class="access">'+
			'</div>';
			$('.doc-share:visible div.step2 form.permission_form div.row.first').after(row);
			$.FileSharing.data = {};
			$('.doc-share:visible input[type="text"]').val('');
		},
		setPremission : function() {
			var value = [];
			$(this).closest('div.row').find('input[type="checkbox"], input[type="radio"]').each(function(i) {
				value += (this.checked && this.value || '_') + (i != 2 ? '-' : '');
			});
			$(this).closest('div.row').find('input:hidden.access').val(value);
		},
		addShare: function(e) {
			e.preventDefault();
			var result = {};
			$($(this).find('a, img')).toggle();
			$('div.row:not(.first):visible').each(function(i, el) {
				result['Share_' + i] = {};
				$('input:hidden', this).each(function() {
					result['Share_' + i][this.name] = this.value;
				});
			});
			if(!Object.keys(result).length) {
				alert('Nothing to share.');
				$($(this).find('a, img')).toggle();
				return 0;
			}

			setTimeout(function() {
				$.post(
					_ROOT + 'shares/add_share',
					result,
					function(response) {
						if(response.status == 'y') {
							$('div.step2:visible form div.row:gt(1)').remove();
							$('div.overlay-info:visible, div.my-overlay-info:visible').click();
						}
					},
					'json'
				);
			},50);
		},
		onSearch: function(e) {
			if(e.which == 13) return false;
			var target = $(e.target),
			clue = target.val().trim().toLowerCase();
			$.FileSharing.shareType = $(this).data('sharetype');
			$('.search_result_container:visible li').hide(0);
			if(!target.closest('.doc-share').find('.search_result_container').length) {
				target.closest('.doc-share').append($.FileSharing.seachResultContainer.slideDown(50));
			} else {
				$('.doc-share:visible').find('.search_result_container').slideDown(0);
			}
			if(clue.length) {
				var found = $('.search_result_container:visible li').filter(function() {
					var pattern = new RegExp(clue, 'ig');
					return !!$(this).text().match(pattern);
				});
				if(found.length) {
					$.FileSharing.isTargetFound = true;
					found.show();
				} else {
					$.FileSharing.isTargetFound = false;
					$.FileSharing.hideSuggestion();
				}
				if($.FileSharing.validate_email.test(clue)) {
					$.FileSharing.isValidEmail = true;
				} else {
					$.FileSharing.isValidEmail = true;
				}
			} else {
				$.FileSharing.hideSuggestion();
			}
		},
		onItemSelect: function(e) {
			var item = $(this),
			type = item.data('type'),
			id = item.data('id'),
			item_id = item.closest('.doc-share:visible').attr('id').replace(($.FileSharing.shareType == 'document' ? 'share' : 'folder_share'),'');
			item.closest('.doc-share:visible').find('input[type="text"]').val(item.text());
			$.FileSharing.hideSuggestion();
			$.FileSharing.data = { text: item.text(), type: type, id: id, itemId : item_id };
		},
		launch: function() {
			$.FileSharing.getData();
			var grandParent = $('#main_container');
			grandParent.on('keyup', '.doc-share:visible input[type="text"]', $.FileSharing.onSearch);
			grandParent.on('click', '.search_result_container:visible li', $.FileSharing.onItemSelect);
			grandParent.on('click', '.doc-share:visible div.accept', $.FileSharing.addShare);
			grandParent.on('click', 'div.step1:visible a', $.FileSharing.addSpecificShareRow);
			grandParent.on('click', 'div.step2:visible form.permission_form input[type="checkbox"], div.step2:visible form.permission_form input[type="radio"]', $.FileSharing.setPremission);
		}
	};
	$.FileSharing.launch();
});