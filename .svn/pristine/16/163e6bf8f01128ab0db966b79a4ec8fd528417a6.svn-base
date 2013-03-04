var filocity_debug_mode=false;
var current_group_info={};

$(function() {
/*
FILOCITY DIALOG LOADING INDICATOR
************************************************/

$.fn.dialogAttachLoadingIndicator=function(txt, show_close_button){
	if(show_close_button!=true){
		$(this).parent().find('.ui-dialog-titlebar-close').hide();
	}
	$(this).css('visibility','hidden');
	if($(this).parent().find('.loading').length<1){
		$(this).parent().append('<div style="width:100%;height:100%;position:absolute;top:50%;left:0;background:transparent;text-align:center;" class="loading">'+txt+'</div>');
		$(this).parent().find('.ui-dialog-titlebar').append('<span class="progress" style="width:16px;height:16px;position:absolute;right:5px;top:5px;background:url(\''+_ROOT+'img/ajax-loader-snake-5da1d1.gif\')"></span>');
	}else{
		$(this).parent().find('.loading').html(txt);
	}
}

$.fn.dialogRemoveLoadingIndicator=function(){
	$(this).parent().find('.ui-dialog-titlebar-close').show();
	$(this).css('visibility','visible');
	$(this).parent().find('.loading, .progress').remove();
}

/*
AJAX LOADING INDICATOR
************************************************/

var ajax_loader_num=0;
function AjaxLoadingIndicator(gif_url,w,h){
	ajax_loader_num++;
	var loader_id='ajax_loader_'+ajax_loader_num;
	var target_el=null;
	var p_right=null;
	var p_top=null;
	var p_left=null;
	var p_bottom=null;
	
	//preload animated gif
	$('<img/>').attr('src',gif_url);
	
	//append gif container after the page loads
		$('body').append('<div id="'+loader_id+'" style="display:none;"></div>');
		$('#'+loader_id).css({
			position:'absolute',
			top:0,
			left:0,
			width:w+'px',
			height:h+'px',
			background:'url('+gif_url+')'
		});
	
	//realign the floating gif
	$(window).resize(function(){
		self.reposition();
	});
	
	var self={
		setTarget:function(el){
			target_el=el;
		},
		reposition:function(){
			var el_top=$(target_el).position().top;
			var el_left=$(target_el).position().left;
			var el_width=$(target_el).outerWidth();
			var el_height=$(target_el).outerHeight();
			var t=0;
			var l=0;
			
			if(p_left==null && p_right==null){
				l=Math.round(el_width/2)-Math.round(w/2);
			}
			
			if(p_top==null && p_bottom==null){
				t=Math.round(el_height/2)-Math.round(h/2);
			}
			if(p_top!=null){
				t=p_top;
			}
			if(p_bottom!=null){
				t=el_height-h-p_bottom;
			}
			if(p_left!=null){
				l=p_left;
			}
			if(p_right!=null){
				l=el_width-w-p_right;
			}
			
			$('#'+loader_id).css({
				top:el_top+t,
				left:el_left+l
			});
		},
		show:function(){
			self.reposition();
			$('#'+loader_id).css('display','block');
		},
		top:function(add){
			add=add==undefined?0:parseInt(add);
			p_top=add;
			p_bottom=null;
		},
		bottom:function(add){
			add=add==undefined?0:parseInt(add);
			p_bottom=add;
			p_top=null;
		},
		left:function(add){
			add=add==undefined?0:parseInt(add);
			p_left=add;
			p_right=null;
		},
		right:function(add){
			add=add==undefined?0:parseInt(add);
			p_right=add;
			p_left=null;
		},
		middle:function(){
			p_top=null;
			p_bottom=null;
		},
		center:function(){
			p_left=null;
			p_right=null;
		},
		hide:function(){
			$('#'+loader_id).css('display','none');
		}
	};
	return self;
}

var display_contact_group_info=function(){
	if($('#contact_list .ui-selected').length==1){
		$('#group_info_container').hide();
		$('#contact_info_container').show();
		var contact_id=$('#contact_list .ui-selected').attr('data-contact-id');
		var user_id=$('#contact_list .ui-selected').attr('data-user-id')
		if(user_id!=undefined){
			displayContactInfo(null, user_id);
		}else{
			displayContactInfo(contact_id);
		}
	}else{
		$('#group_info_container').show();
		$('#contact_info_container').hide();
	}
}

/*
SELECT / DESELECT ALL CONTACTS LIST
************************************************/

function select_all_contacts(){
	$('#contact_list li').each(function(){
		$(this).addClass('ui-selected');
	});
	display_contact_group_info();
	return false;
}

function deselect_all_contacts(){
	$('#contact_list li').each(function(){
		$(this).removeClass('ui-selected');
	});
	display_contact_group_info();
	return false;
}

/*
MENU SELECTS
************************************************/




/*
CONTACTS LIST
************************************************/

var current_ajax_loader=null;


	var menu_list_ajax_loader=new AjaxLoadingIndicator(_ROOT+'img/ajax-loader-snake-5da1d1.gif',16,16);
	
	function start_current_ajax_loader(){
		if(current_ajax_loader!=null){
			current_ajax_loader.abort();
			current_ajax_loader=null;
		}
		//$('#contact_list_container').hide();
		//$('#contact_group_info_container').hide();
		$('#group_info_container').hide();
		$('#contact_info_container').hide();
		$('.group-panel').css('visibility','hidden');
	}

	function end_current_ajax_loader(){
		menu_list_ajax_loader.hide();
		current_ajax_loader=null;
		$('#contact_list_container').show();
		$('#contact_group_info_container').show();
		$('#group_info_container').show();
		$('.group-panel').css('visibility','visible');
		$('#contact_list .scroller').mCustomScrollbar('update');
	}

	$('#sort_first_name_link').click(function(){
		contacts_sort_by='first_name';
		$('.current-contact-group').click();
	});
	$('#sort_last_name_link').click(function(){
		contacts_sort_by='last_name';
		$('.current-contact-group').click();
	});
	$('#contacts-filter').change(function(){
		$('.current-contact-group').click();
	});
	$('#contact_list ul').selectable({
		filter:'li',
		stop:function(){
			display_contact_group_info();
			$('#contact_list .ui-selected input', this).each(function() {
				this.checked= !this.checked;
			});
		}
	});
	$(document).on('click', '.contact-group a', function(){
		$('.current-contact-group').removeClass('current-contact-group');
		$(this).addClass('current-contact-group');
		menu_list_ajax_loader.setTarget($('.current-contact-group'));
		menu_list_ajax_loader.right();
		menu_list_ajax_loader.middle();
		menu_list_ajax_loader.show();
	});
	$('.current-contact-group').eq(0).click();
	
	var contacts_sort_by='last_name';
var listName=function(info){
	var display='';
	var filter=$.trim($('#contacts-filter').val());
	var RegExpEscape= function(s) {
		return s.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&')
	};
	if(contacts_sort_by=='last_name'){
		if(info['last_name']!=''){
			display+=info['last_name'].replace(new RegExp('^('+RegExpEscape(filter)+')','gi'),'<span style="color:blue;">$1</span>');
		}
		if(info['first_name']!=''){
			display+=', '+info['first_name'].replace(new RegExp('^('+RegExpEscape(filter)+')','gi'),'<span style="color:blue;">$1</span>');;
		}
	}else{
		if(info['first_name']!=''){
			display+=info['first_name'].replace(new RegExp('^('+RegExpEscape(filter)+')','gi'),'<span style="color:blue;">$1</span>');;
		}
		if(info['last_name']!=''){
			display+=' '+info['last_name'].replace(new RegExp('^('+RegExpEscape(filter)+')','gi'),'<span style="color:blue;">$1</span>');;
		}
	}
	if(info['first_name']!='' || info['last_name']!=''){
		display+=' &lt;';
	}
	display+=info['email'].replace(new RegExp('^('+RegExpEscape(filter)+')','gi'),'<span style="color:blue;">$1</span>');;
	if(info['first_name']!='' || info['last_name']!=''){
		display+='&gt;';
	}
	return $.trim(display);
}

var display_contacts_interval=null;
function display_contacts(data){
	if(data['list']==undefined){
		data['list']=[];
	}
	
	if(display_contacts_interval!=null){
		clearInterval(display_contacts_interval);
		display_contacts_interval=null;
	}
	
	$('#contact_list .scroller ul').html('');
	$('#contact_group_name').html(($.trim($('#contacts-filter').val())!=''?'Filtered: ':'')+data['name']);
	$('#contact_group_count').html(data['list'].length);
	$('#contact_group_description').html(data['purpose']);
	
	var x=0;
	var loop=function(){
		var html=[];
		for(var i=x;i<data['list'].length && i-x<100;i++){
			var tbl='Contact';
			if(data['list'][i]['User']!=undefined){
				tbl='User';
			}
			var display=listName(data['list'][i][tbl]);
			html.push('<li data-'+tbl.toLowerCase()+'-id="'+data['list'][i][tbl]['id']+'">'+display+'</li>');
		}
		x=i;
		$('#contact_list .scroller ul').append(html.join(' '));
		$('#contact_list .scroller').mCustomScrollbar('update');
		html=null;
		
		if(x>=data['list'].length){
			clearInterval(display_contacts_interval);
			display_contacts_interval=null;
		}
	}
	display_contacts_interval=setInterval(loop,10);
	

	if(data['folder_id']==null || data['folder_id']==0){
		$('#create_group_folder_link')
			.html('Create Group Folder')
			.attr('data-group-id', data['id'])
			.attr('href', '#')
			.removeAttr('target');
	}else{
		$('#create_group_folder_link')
			.html('View Folder')
			.removeAttr('data-group-id')
			.attr('href',_ROOT+'cabinets/folder/'+data['folder_id'])
			.attr('target','_blank');
	}
	
}

var show_groups=function(){
	$('#custom-contact-group-list li').hide();
	if(cgroups_list_only_account_users){
		$('#custom-contact-group-list a[data-for-users="false"]').parent().show();
		$('#contact_group_links_container .left-container-title').html('Users Groups');
	}else{
		$('#custom-contact-group-list a[data-for-users="false"]').parent().show();
		$('#contact_group_links_container #name_of_groups').html('Contacts Groups ');
	}
}

function list_contacts(class_, group_id){
	start_current_ajax_loader();
	var view=null;
	if(class_!='group'){
		url=_ROOT+'contacts/view/'+class_;
		$('#group_actions').hide();
	}else{
		if(cgroups_list_only_account_users){
			url=_ROOT+'contacts/view/group/'+group_id+'/users';
		}else{
			url=_ROOT+'contacts/view/group/'+group_id;
		}
		$('#group_actions').show();
	}
	cgroups_list_only_account_users=false;
	if(class_=='account-users'){
		cgroups_list_only_account_users=true;
	}else if(class_=='group'){
		cgroups_list_only_account_users=$('#custom-contact-group-list a[data-group-id="'+group_id+'"]').attr('data-for-users')=='true';
	}
	show_groups();
	var data={data:{sort:contacts_sort_by,filter:$.trim($('#contacts-filter').val())}};
	current_ajax_loader=$.ajax({
		url: url,
		data: data,
		type: 'POST',
		dataType: 'JSON',
		success:function(data){
			if(group_id!=null){
				current_group_info=data;
			}else{
				current_group_info={};
			}
			display_contacts(data);
			show_contacts_list_actions(class_);
			end_current_ajax_loader();
		},
		error:function(err){
			if(err.responseText!=null){
				filocityDebug('Error','<pre>'+err.responseText+'</pre>');
			}
		},
		complete: function(){
			
		}
	});
}


function attach_contacts_list_actions(){
	//share contacts
	$(document).on('click','.contacts-list-actions .selected-share',function(){
		var contacts=$('#contact_list .ui-selected');
		if(contacts.length<1){
			return;
		}
		var dialog_id=filocityConfirmDialog('Share Selected Contacts','Are you sure you would like to share the selected contacts?');
		$('#'+dialog_id).find('.yes-button').click(function(){
			$('#'+dialog_id).dialogAttachLoadingIndicator('Sharing Selected Contacts...');
			var data_=[];
			for(var i=0;i<contacts.length;i++){
				data_.push($(contacts[i]).attr('data-contact-id'));
			}
			var update_contact_ajax=$.ajax({
				url: _ROOT+'contacts/share_multi',
				data: {data:{contact_ids:data_}},
				type: 'POST',
				dataType: 'JSON',
				success: function(data){
					
				},
				error: function(err){
					if(err.responseText!=null){
						filocityDebug('Error','<pre>'+err.responseText+'</pre>');
					}
				},
				complete:function(){
					$('#'+dialog_id).dialog('close');
					$('#private_contacts_group_link').click();
				}
			});
		});
	});
	
	//delete contacts
	
	$(document).on('click','.contacts-list-actions .selected-delete',function(){
		var contacts=$('#contact_list .ui-selected');
		delete_contacts('Delete Selected Contacts','Are you sure you would like to delete the selected contacts?','Deleting Selected Contacts...',contacts,function(){
			$('.current-contact-group').click();
		});
	});
	
	//add to a group
	$(document).on('click','.contacts-list-actions .selected-add-to-group',function(){
		newFilocityAddToGroupDialog();
	});
	
	//remove contacts from a group
	$(document).on('click','.contacts-list-actions .selected-remove-from-group',function(){
		var group_id=current_group_info['id'];
		var contacts=$('#contact_list .ui-selected');
		if(contacts.length<1){
			return;
		}
		var dialog_id=filocityConfirmDialog('Remove Selected Group Contacts','Are you sure you would like to remove the selected contacts from this group?');
		$('#'+dialog_id).find('.yes-button').click(function(){
			
			
			var data_=[];
			var url, data;
			if(cgroups_list_only_account_users){
				$('#'+dialog_id).dialogAttachLoadingIndicator('Removing Selected Users...');
				for(var i=0;i<contacts.length;i++){
					data_.push($(contacts[i]).attr('data-user-id'));
				}
				url=_ROOT+'users_groups/delete_multi';
				data={data:{group_id:group_id, user_ids:data_}};
			}else{
				$('#'+dialog_id).dialogAttachLoadingIndicator('Removing Selected Contacts...');
				for(var i=0;i<contacts.length;i++){
					data_.push($(contacts[i]).attr('data-contact-id'));
				}
				url=_ROOT+'contacts_groups/delete_multi';
				data={data:{group_id:group_id, contact_ids:data_}};
			}
			
			var remove_contacts_ajax=$.ajax({
				url: url,
				data: data,
				type: 'POST',
				dataType: 'JSON',
				success: function(data){
					
				},
				error: function(err){
					if(err.responseText!=null){
						filocityDebug('Error','<pre>'+err.responseText+'</pre>');
					}	
				},
				complete:function(){
					$('#'+dialog_id).dialog('close');
					$('#custom-contact-group-list a[data-group-id="'+group_id+'"]').click();
				}
			});
		});
	});
}
var dialog_num=0;
var newFilocityAddToGroupDialog=function(){
	var contacts=$('#contact_list .ui-selected');
	if(contacts.length<1){
		return;
	}
	dialog_num++;
	var dialog_id='dialog_'+dialog_num;
	
	$('body').append('<div id="'+dialog_id+'" class="add_to_a_group_dialog">'+$('#add_to_a_group_dialog').html()+'</div>');
	
	filocityDialog('#'+dialog_id,true);
	
	$('#'+dialog_id+' select[name="data[Group][id]"]').html('');
	for(var i=0;i<cgroups_list.length;i++){
		if(cgroups_list_only_account_users!=cgroups_list[i]['Group']['is_for_account_users']){
			continue;
		}
		$('#'+dialog_id+' select[name="data[Group][id]"]').append('<option value="'+cgroups_list[i]['Group']['id']+'">'+cgroups_list[i]['Group']['name']+'</option>');
	}
	if(cgroups_list_only_account_users){
		$('#'+dialog_id).dialog('option','title','Add Selected Users to a Group');
	}else{
		$('#'+dialog_id).dialog('option','title','Add Selected Contacts to a Group');
	}
	$('#'+dialog_id).dialog('option','width',331);
	$('#'+dialog_id).dialog('open');
	
	//add contacts to a group
	$('#'+dialog_id+' .save-button').click(function(){
		var group_id=$('#'+dialog_id+' select[name="data[Group][id]"]').val();
		var contacts=$('#contact_list .ui-selected');
		if(group_id<1 || contacts.length<1){
			return;
		}
		
		var data_=[];
		var url, data;
		if(cgroups_list_only_account_users){
			for(var i=0;i<contacts.length;i++){
				data_.push($(contacts[i]).attr('data-user-id'));
			}
			$('#'+dialog_id).dialogAttachLoadingIndicator('Adding selected users to the group...');
			url=_ROOT+'users_groups/add_multi';
			data={data:{group_id:group_id, user_ids:data_}};
		}else{
			for(var i=0;i<contacts.length;i++){
				data_.push($(contacts[i]).attr('data-contact-id'));
			}
			$('#'+dialog_id).dialogAttachLoadingIndicator('Adding selected contacts to the group...');
			url=_ROOT+'contacts_groups/add_multi';
			data={data:{group_id:group_id, contact_ids:data_}};
		}
		
		var group_contacts_ajax=$.ajax({
			url: url,
			data: data,
			type: 'POST',
			dataType: 'JSON',
			success: function(data){
				
			},
			error: function(err){
				if(err.responseText!=null){
					filocityDebug('Error','<pre>'+err.responseText+'</pre>');
				}
			},
			complete:function(){
				$('#'+dialog_id+' .cancel-button').click();
				$('#custom-contact-group-list a[data-group-id="'+group_id+'"]').click();
			}
		});
	});
	
	$('#'+dialog_id+' .cancel-button').click(function(){
		$('#'+dialog_id).dialogRemoveLoadingIndicator();
		$('#'+dialog_id).dialog('close');
	});
	
}
function delete_contacts(dialog_title, dialog_message, deleting_message, contacts, callback_func){
	if(contacts.length<1){
		return;
	}
	var dialog_id=filocityConfirmDialog(dialog_title,dialog_message);
	$('#'+dialog_id).find('.yes-button').click(function(){
		$('#'+dialog_id).dialogAttachLoadingIndicator(deleting_message);
		var data_=[];
		for(var i=0;i<contacts.length;i++){
			data_.push($(contacts[i]).attr('data-contact-id'));
		}
		var delete_contact_ajax=$.ajax({
			url: _ROOT+'contacts/delete_multi',
			data: {data:{contact_ids:data_}},
			type: 'POST',
			dataType: 'JSON',
			success: function(data){
				
			},
			error: function(err){
				if(err.responseText!=null){
					filocityDebug('Error','<pre>'+err.responseText+'</pre>');
				}
			},
			complete:function(){
				callback_func(dialog_id);
				$('#'+dialog_id).dialogRemoveLoadingIndicator();
				$('#'+dialog_id).dialog('close');
			}
		});
	});
}

function show_contacts_list_actions(class_){
	$('.contacts-list-actions li').removeClass('active');
	$('.contacts-list-actions .label').html('Select groups below and contacts on the right and click');
	if(class_=='account-users'){
		$('.contacts-list-actions .for-users').addClass('active');
		$('.contacts-list-actions .label').html('Selected Users:');
	}else if(class_=='private-contacts'){
		$('.contacts-list-actions .for-private').addClass('active');
	}else if(class_=='shared-contacts'){
		$('.contacts-list-actions .for-shared').addClass('active');
	}else if(class_=='all-contacts'){
		$('.contacts-list-actions .for-all').addClass('active');
	}else if(class_=='group'){
		$('.contacts-list-actions .for-group').addClass('active');
	}
	if($('.contacts-list-actions .active').length>0){
		$('.contacts-list-actions').show();
	}else{
		$('.contacts-list-actions').hide();
	}
}

var current_contact_hovered=null;

	$('#contact_info_link').click(function(){
		if($(current_contact_hovered).attr('data-user-id')!=null){
			var user_id=$(current_contact_hovered).attr('data-user-id');
			newContactInfoDialog(null, user_id);
		}else{
			var contact_id=$(current_contact_hovered).attr('data-contact-id');
			newContactInfoDialog(contact_id);
		}
		return false;
	});
	$('#contact_list .scroller').mCustomScrollbar();
	$(document).on('mouseenter','#contact_list ul li',function(){
		if($(this).attr('data-contact-id')!=undefined || $(this).attr('data-user-id')!=undefined){
			var t=$(this).position().top;
			$('#contact_links').css({top:(t+4)+'px'});
			//$('#contact_links').show();
			current_contact_hovered=this;
		}else{
			current_contact_hovered=null;
		}
		$('#contact_list li.mouseenter').removeClass('mouseenter');
		$(this).addClass('mouseenter');
	});
	//$(document).on('mouseleave','#contact_list ul li',function(){
	//	$(this).removeClass('mouseenter');
	//});
	$(document).on('mouseleave','#contact_list .mCSB_container',function(){
		$('#contact_links').hide();
		$('#contact_list li.mouseenter').removeClass('mouseenter');
	});
	attach_contacts_list_actions();


/*
ADD CONTACT
************************************************/

var active_filocity_contact_dialog_num=0;
var newFilocityContactDialog=function(contact_id, contact_info, callbacks){
	active_filocity_contact_dialog_num++;
	if(callbacks==null){
		callbacks={};
	}
	var dialog_id='filocity_contact_dialog_'+active_filocity_contact_dialog_num;
	if(contact_id!=null){
		dialog_id='filocity_contact_dialog_edit_'+contact_id;
	}
	
	if($('#'+dialog_id).length>0){
		$('#'+dialog_id).dialog('moveToTop');
		return dialog_id;
	}
	
	$('body').append('<div id="'+dialog_id+'" class="contact_dialog"></div>');
	$('#'+dialog_id).append($('#contact_dialog').html());
	filocityDialog('#'+dialog_id);

	if(contact_id==undefined){
		$('#'+dialog_id).dialog('option','title','Add Contact');
	}else{
		$('#'+dialog_id).dialog('option','title','Edit Contact');
		var tbl='Contact';
		for(var x in contact_info[0][tbl]){
			if(false){
				//todo: for photo & country
			}else{
				$('#'+dialog_id).find('*[name="data['+tbl+']['+x+']"]').val(contact_info[0][tbl][x]);
			}
		}
	}
	$('#'+dialog_id).dialog('option','width',700);
	$('#'+dialog_id).dialog('open');
	$('#'+dialog_id+' .cancel-button').click(function(){
		$('#'+dialog_id).dialog('close');
	});
	
	var dialog_ajax=null;
	
	$('#'+dialog_id+' .save-button').click(function(){
		var data=$('#'+dialog_id+' form').serializeArray();
		var url;
		if(contact_id==undefined){
			url=_ROOT+'contacts/add_contact';
			$('#'+dialog_id).dialogAttachLoadingIndicator('Adding Contact...');
		}else{
			url=_ROOT+'contacts/edit_contact/'+contact_id;
			$('#'+dialog_id).dialogAttachLoadingIndicator('Updating Contact...');
		}
		dialog_ajax=$.ajax({
			url: url,
			data: data,
			type:'POST',
			dataType: 'JSON',
			success: function(data){
				if(data['error']!=undefined){
					
				}else{
					$('#'+dialog_id).dialog('close');
					if(callbacks['success']!=null){
						callbacks['success'](contact_id);
					}else{
						$('#all_contacts_group_link').click();
					}
				}
			},
			error: function(err){
				if(err.responseText!=null){
					filocityDebug('Error','<pre>'+err.responseText+'</pre>');
				}			
			},
			complete: function(){
				$('#'+dialog_id).dialogRemoveLoadingIndicator();
			}
		});
	});
	
	$('#'+dialog_id+' .cancel-button').click(function(){
		if(callbacks['cancel']!=null){
			callbacks['cancel'](contact_id);
		}
	});
	
	return dialog_id;
}

	$('#add_contact_link').click(function(){
		newFilocityContactDialog();
		return false;
	});

/*
CONTACT GROUPS
************************************************/

var cgroups_ajax=null;
var cgroups_ajax_loading_indicator=new AjaxLoadingIndicator(_ROOT+'img/ajax-loader-snake-fg1F5175.gif',16,16);
var cgroups_list=null;
var cgroups_list_only_account_users=false;

$('.contact_group_type').on('click', function() {
	list_contacts($(this).attr('data-contactgroup'));
})

function list_contact_groups(){
	cgroups_ajax_loading_indicator.setTarget('#contact_group_links_container .left-container-title');
	cgroups_ajax_loading_indicator.top(-2);
	cgroups_ajax_loading_indicator.right();
	cgroups_ajax_loading_indicator.show();
	cgroups_ajax=$.ajax({
	url: _ROOT+'groups/get_groups',
		dataType: 'JSON',
		type: 'POST',
		success:function(data){
			$('#custom-contact-group-list').html('');
			for(var i in data){
				$('#custom-contact-group-list').append('<li><a class="list_item_of_contact" href="#" data-group-id="'+data[i]['Group']['id']+'" data-for-users="'+data[i]['Group']['is_for_account_users']+'">'+data[i]['Group']['name']+'</a></li>');
			}
			$('#custom-contact-group-list').on('click', '.list_item_of_contact', function() {
				list_contacts('group', $(this).attr('data-group-id'))
			});
			$('#custom-contact-group-list').show();
			if(current_group_info['id']!='undefined'){
				$('.current-contact-group').removeClass('current-contact-group');
				$('#custom-contact-group-list a[data-group-id="'+current_group_info['id']+'"]').addClass('current-contact-group');
			}
			cgroups_list=data;
			show_groups();
		},
		error:function(err){
			if(err.responseText!=null){
				filocityDebug('Error','<pre>'+err.responseText+'</pre>');
			}
		},
		complete:function(){
			cgroups_ajax_loading_indicator.hide();
		}
	});
}


	list_contact_groups();

/*
DELETE CONTACT GROUP
************************************************/


	$(document).on('click','#delete_group_link',function(){
		var dialog_id=filocityConfirmDialog('Delete Group','Are you sure you would like to delete this contact group?');
		$('#'+dialog_id).find('.yes-button').click(function(){
			$('#'+dialog_id).dialogAttachLoadingIndicator('Deleting Group...');
			var delete_group_ajax=$.ajax({
				url: _ROOT+'groups/delete_group/'+current_group_info['id'],
				type: 'POST',
				dataType: 'JSON',
				success: function(data){
					if(data['error']==undefined){
						$('#all_contacts_group_link').click();
					}else{
						filocityDebug('Error',data['error']);
					}
				},
				error: function(err){
					if(err.responseText!=null){
						filocityDebug('Error','<pre>'+err.responseText+'</pre>');
					}
				},
				complete: function(){
					list_contact_groups();
					$('#'+dialog_id).dialog('close');
				}
			});
		});
		return false;
	});

/*
ADD CONTACT GROUP
************************************************/

var active_filocity_group_dialog_num=0;
var newFilocityGroupDialog=function(group_id){
	var group_info=current_group_info;
	active_filocity_group_dialog_num++;
	
	var dialog_ajax=null;
	var dialog_id='filocity_group_dialog_'+active_filocity_group_dialog_num;
	
	$('body').append('<div id="'+dialog_id+'" data-edit-group-id="'+group_id+'" class="group_dialog"></div>');
	$('#'+dialog_id).append($('#group_dialog').html());
	filocityDialog('#'+dialog_id);
	
	if(group_id==undefined){
		$('#'+dialog_id).dialog('option','title','Add Group');
	}else{
		$('#'+dialog_id).dialog('option','title','Edit Group');
		$('#'+dialog_id).find('input[name="data[Group][name]"]').val(group_info['name']);
		$('#'+dialog_id).find('textarea[name="data[Group][purpose]"]').val(group_info['purpose']);
		
		if(group_info['is_for_account_users']==true){
			$('#'+dialog_id).find('input[name="data[Group][is_for_account_users]"]').remove();
		}else{
			$('#'+dialog_id).find('.if-account-users').remove();
		}
		/*
		if(group_info['has_smart_filing_category']==1){
			$('#'+dialog_id).find('input[name="data[Group][has_smart_filing_category]"]').attr('checked','checked');
		}else{
			$('#'+dialog_id).find('input[name="data[Group][has_smart_filing_category]"]').removeAttr('checked');
		}
		*/
	}
	$('#'+dialog_id).dialog('option','width',355);
	$('#'+dialog_id).dialog('open');

	$('#'+dialog_id+' .cancel-button').click(function(){
		$('#'+dialog_id).dialog('close');
	});
	
	$('#'+dialog_id+' .save-button').click(function(){
		var data=$('#'+dialog_id+' form').serializeArray();
		var url;
		if(group_id==undefined){
			url=_ROOT+'groups/add_group';
			$('#'+dialog_id).dialogAttachLoadingIndicator('Creating Group...');
		}else{
			url=_ROOT+'groups/edit_group/'+group_id;
			$('#'+dialog_id).dialogAttachLoadingIndicator('Updating Group...');
		}
		dialog_ajax=$.ajax({
			url: url,
			data: data,
			type:'POST',
			dataType: 'JSON',
			success: function(data){
				if(data['error']!=undefined){
				}else{
					$('#'+dialog_id).dialog('close');
					list_contact_groups();
					if(group_id!=null && group_id==current_group_info['id']){
						$('.current-contact-group').click();
					}
				}
			},
			error: function(err){
				if(err.responseText!=null){
					filocityDebug('Error','<pre>'+err.responseText+'</pre>');
				}
			},
			complete: function(){
				$('#'+dialog_id).dialogRemoveLoadingIndicator();
			}
		});
	});
}


	$('#add_group_link').click(function(){
		newFilocityGroupDialog();
		return false;
	});
	$('#new_user_group').click(function(){
		newFilocityGroupDialog();
		return false;
	});
	$('#edit_group_link').click(function(){
		var group_id=current_group_info['id'];
		//bring the opened edit dialog of a group to be updated forward
		if($('div[ data-edit-group-id="'+group_id+'"]').length>0){
			$('div[ data-edit-group-id="'+group_id+'"]').dialog('moveToTop');
			return false;
		}
		newFilocityGroupDialog(group_id);
		return false;
	});
	$('#create_group_folder_link').click(function(){
		var group_id=$(this).attr('data-group-id');
		if(group_id==null || group_id==''){
			return;
		}
		var select_folder_dialog_id=newFilocitySelectFolderDialog('create_group_folder_'+group_id,false,
		function(folder_id, folder_name){
			$('#'+select_folder_dialog_id).dialogAttachLoadingIndicator('Creating Group Folder...');
			var create_folder_ajax=$.ajax({
				url: _ROOT+'groups/create_group_folder',
				data: {group_id:group_id,folder_id:folder_id},
				type: 'POST',
				dataType: 'JSON',
				success: function(data){
					$('#'+select_folder_dialog_id).dialog('close');
					if(group_id==current_group_info['id']){
						$('.current-contact-group').click();
					}
				},
				error: function(err){
					if(err.responseText!=null){
						filocityDebug('Error','<pre>'+err.responseText+'</pre>');
					}	
				},
				complete: function(){
					contact_info_ajax=null;
					$('#'+select_folder_dialog_id).dialogRemoveLoadingIndicator();
				}
			});
			
		},
		function(){
		
		});
		return false;
	});


/*
IMPORT CONTACTS
************************************************/
var import_contacts_dialog_num=0;
var newFilocityImportContactsDialog=function(){
	import_contacts_dialog_num++;
	var dialog_id='import_contact_dialog_'+import_contacts_dialog_num;
	$('body').append('<div id="'+dialog_id+'" class="import_contacts_dialog">'+$('#import_contacts_dialog').html()+'</div>');
	$('#'+dialog_id).find('.import_csv_button').attr('id','import_csv_button'+import_contacts_dialog_num);
	$('#'+dialog_id).find('.import_csv_button_container').attr('id','import_csv_button_container'+import_contacts_dialog_num);
	filocityDialog('#'+dialog_id);
	//--------------------------------------------------------------
	// CSV Uploader
	//--------------------------------------------------------------
	var uploader, uploader_file;
	uploader = new plupload.Uploader({
		runtimes : 'gears,html5,flash,silverlight',
		browse_button : 'import_csv_button'+import_contacts_dialog_num,
		container: 'import_csv_button_container'+import_contacts_dialog_num,
		max_file_size : '10mb',
		url : _ROOT+'contacts/import_contacts/outlook_csv',
		flash_swf_url : _ROOT+'files/plupload.flash.swf',
		silverlight_xap_url : _ROOT+'files/plupload.silverlight.xap',
		filters : [
			{title: "Comma Separated Values File", extensions : "csv"}
		],
		multi_selection:false,
		file_data_name: 'data[Contact][outlook_csv]'
	});
	
	uploader.bind('Init', function(up, params) {

	});

	uploader.init();

	uploader.bind('FilesAdded', function(up, files) {
		uploader_file=files[0];
		$('#'+dialog_id+' .import_contact_file_name').html(uploader_file['name']);
	});

	uploader.bind('UploadProgress', function(up, file) {
		$('#'+dialog_id).dialogAttachLoadingIndicator('Uploading ('+file.percent+'%)...');
	});

	uploader.bind('Error', function(up, err) {
		/*
		$('#filelist').append("<div>Error: " + err.code +
			", Message: " + err.message +
			(err.file ? ", File: " + err.file.name : "") +
			"</div>"
		);
		*/

		filocityDebug('Error '+err.status,'<pre>'+err.message+'</pre>');
		up.refresh(); // Reposition Flash/Silverlight
	});

	uploader.bind('FileUploaded', function(up, file, serv) {
		$('#'+dialog_id).dialogAttachLoadingIndicator('Uploading (100%)...');
		//filocityDebug('Error','<pre>'+serv['response']+'</pre>');
		serv['response']=$.parseJSON(serv['response']);
		if(serv['response']['error']==undefined){
			$('#all_contacts_group_link').click();
		}else{
			filocityDebug('Error','<pre>'+serv['response']['error']+'</pre>');
		}
		$('#'+dialog_id).dialogRemoveLoadingIndicator();
		$('#'+dialog_id).dialog('close');
		
	});
	//--------------------------------------------------------------
	
	
	$('#'+dialog_id+' .import_contact_file_name').html('No File Selected');
	$('#'+dialog_id).dialog('option','title','Import Contacts');
	$('#'+dialog_id).dialog('option','width',331);
	$('#'+dialog_id).dialog('open');
	$('#'+dialog_id).dialog('moveToTop');
	
	$('#'+dialog_id+' .provider_box').change(function(){
		if($(this).val()=='outlook_csv'){
			$('#'+dialog_id+' .from-mail-server').hide();
			$('#'+dialog_id+' .from-file').show();
		}else if($(this).val()==''){
			$('#'+dialog_id+' .from-mail-server').hide();
			$('#'+dialog_id+' .from-file').hide();
		}else{
			$('#'+dialog_id+' .from-mail-server').show();
			$('#'+dialog_id+' .from-file').hide();
		}
		$('#'+dialog_id+'').dialog('moveToTop');
		$('#'+dialog_id+'').dialog('option','position','center');
		uploader.refresh();
	});
	
	$('#'+dialog_id+' .provider_box').change();
	
	
	$('#'+dialog_id+' .save-button').click(function(){
		if($('#'+dialog_id+' .provider_box').val()=='outlook_csv'){
			if(uploader_file!=undefined){
				uploader.start();
				$('#'+dialog_id).dialogAttachLoadingIndicator('Uploading CSV...');
			}
		}
	});
	
	$('#'+dialog_id+' .cancel-button').click(function(){
		$('#'+dialog_id).dialogRemoveLoadingIndicator();
		$('#'+dialog_id).dialog('close');
	});
}


	$('#import_contacts_link').click(function(){
		newFilocityImportContactsDialog();
		return false;
	});

/*
DIALOG
************************************************/

var filocityDialog=function(selector, isModal){
	if($(selector).hasClass('filocity-dialog')){
		$(selector).dialog('moveToTop');
		return;
	}

	$(selector).addClass('filocity-dialog');
	$(selector).dialog({
		autoOpen:false,
		maxHeight:500,
		minHeight:50,
		closeText:'',
		modal:isModal,
		open: function(e, ui){
			$(this).hide();
			$(this).stop().fadeIn();
			var self=this;
			var heightFix=function(){
				//height fix
				var h=$(self).outerHeight();
				var max_h=$(self).dialog('option','maxHeight');
				if($(window).height()<max_h && $(self).parent().css('position')=='fixed'){
					max_h=$(window).height()-40;
				}
				if(h>max_h){
					$(self).css({'height': max_h}); 
				}
				//update custom scroll bar
				$(self).mCustomScrollbar('update');					
				//center the dialog
				$(self).dialog('option','position','center');
			}
			heightFix();
			
			//attach-once events
			if($(this).attr('data-event-attached')!=1){
				$(window).resize(function(){
					heightFix();
				});
				$(this).attr('data-event-attached',1);
			}
			
		}
	});
	$(selector).bind('dialogclose', function(){
		$(this).dialog('destroy').remove();
	});
	$('.ui-dialog-content').mCustomScrollbar();
}

var filocityDebugNum=0;
var filocityDebug=function(title, html, buttons){
	if(!filocity_debug_mode){
		return;
	}
	filocityDebugNum++;
	var dialog_id='filocity_debug_'+filocityDebugNum;
	$('body').append('<div id="'+dialog_id+'"><div class="div" style="width:100%;height:500px;overflow:scroll;"></div></div>');
	$('#'+dialog_id+' .div').html(html);
	if(buttons=undefined){
		buttons={
			'OK': function(){
				$(this).dialog('close');
			}
		}
	}
	$('#'+dialog_id).dialog({
		resizable:false,
		modal:true,
		buttons:buttons,
		closeText:'',
		title:title,
		width:800
	});
	$('#'+dialog_id).bind('dialogclose', function(){
		$('#'+dialog_id).dialog('destroy').remove();
	});
	return dialog_id;
}

var filocityConfirmDialogNum=0;
var filocityConfirmDialog=function(title, content, is_modal){
	filocityConfirmDialogNum++;
	var dialog_id='filocity_confirm_dialog_'+filocityConfirmDialogNum;
	$('body').append('<div id="'+dialog_id+'">\
		<div class="content" style="padding:10px 0;text-align:center;"></div>\
		<div style="clear:both;"></div>\
		<div class="buttons" style="float:right;">\
			<input type="button" value="Yes" class="yes-button filocity-modal-button" />\
			<input type="button" value="No" class="no-button filocity-modal-button pink" style="margin-left:5px;" />\
		</div>\
	</div>');
	filocityDialog('#'+dialog_id, is_modal==undefined?true:is_modal);
	$('#'+dialog_id).dialog('option','title',title);
	$('#'+dialog_id+' .content').html(content);
	$('#'+dialog_id).find('.no-button').click(function(){
		$('#'+dialog_id).dialog('close');
	});
	$('#'+dialog_id).dialog('open');
	$('.ui-widget-overlay').css({opacity:0.35});
	return dialog_id;
}
/*
CONTACT INFO DIALOG
************************************************/
/*
var newContactInfoDialog=function(contact_id, user_id){
	var dialog_id='filocity_contact_info_dialog_'+contact_id;
	if(user_id!=null){
		dialog_id='filocity_user_info_dialog_'+user_id;
	}
	if($('#'+dialog_id).length>0){
		$('#'+dialog_id).dialog('moveToTop');
		return;
	}
	$('body').append('<div id="'+dialog_id+'" class="contact_info_dialog">'+$('#contact_info_dialog').html()+'</div>');
	$('#'+dialog_id).find('.row').hide();
	filocityDialog('#'+dialog_id);
	$('#'+dialog_id).dialog('option','width',630);
	$('#'+dialog_id).dialog('open');
	$('#'+dialog_id).bind('dialogclose', function(){
		if(contact_info_ajax!=null){
			contact_info_ajax.abort();
			contact_info_ajax=null;
		}
	});
	var url=null;
	if(user_id!=null){
		$('#'+dialog_id).dialogAttachLoadingIndicator('Loading User Info...',true);
		url=_ROOT+'users/get_user_info/'+user_id;
	}else{
		$('#'+dialog_id).dialogAttachLoadingIndicator('Loading Contact Info...',true);
		url=_ROOT+'contacts/get_contact_info/'+contact_id;
	}
	
	var contact_info=[];
	var contact_info_ajax=$.ajax({
		url: url,
		data: {},
		type:'POST',
		dataType: 'JSON',
		success: function(data){
			contact_info=data;
			var tbl='Contact';
			if(data[0]['User']!=undefined){
				tbl='User';
			}
			for(var x in data[0][tbl]){
				if(data[0][tbl][x]==null || data[0][tbl][x]==''){
					continue;
				}
				$('#'+dialog_id+' .'+x+' .info').html(data[0][tbl][x]);
				$('#'+dialog_id+' .'+x).show();
			}
			if(data[0][tbl]['email']!=''){
				$('#'+dialog_id).dialog('option','title',data[0][tbl]['email']+' - '+tbl+' Info');
				$('#'+dialog_id+' .email-link').attr('href','mailto:'+data[0][tbl]['email']);
			}
			if(tbl=='User'){
				$('#'+dialog_id+' .groups-link').hide();
			}else{
				$('#'+dialog_id+' .groups-link').show();
				$('#'+dialog_id+' .groups-link').click(function(){
					newFilocityContactGroupsDialog(contact_id);
					return false;
				});
			}
			
			$('#'+dialog_id+' .shares-link').click(function(){
				newFilocityContactSharesDialog(contact_id);
				return false;
			});
			
			var allow_write=true;
			if(allow_write){
				if(tbl=='User'){
					$('#'+dialog_id+' .edit-contact-link').hide();
					$('#'+dialog_id+' .delete-contact-link').hide();
				}else{
					$('#'+dialog_id+' .edit-contact-link').show();
					$('#'+dialog_id+' .edit-contact-link').click(function(){
						$('#'+dialog_id).dialog('close');
						newFilocityContactDialog(contact_id, contact_info);
						return false;
					});
					$('#'+dialog_id+' .delete-contact-link').show();
					$('#'+dialog_id+' .delete-contact-link').attr('data-contact-id',contact_id);
					$('#'+dialog_id+' .delete-contact-link').click(function(){
						delete_contacts('Delete Contact', 'Are you sure you would like to delete this contact?', 'Deleting Contact...', $('#'+dialog_id+' .delete-contact-link'), function(){
							$('#'+dialog_id).dialog('close');
							$('.current-contact-group').click();
						});
						return false;
					});
				}
				
				if(data[0][tbl]['folder_id']==0){
					$('#'+dialog_id+' .contact-folder-link')
						.html('Create a Folder')
						.click(function(){
							$('#'+dialog_id).dialog('close');
							var select_folder_id=tbl+'_'+(tbl=='Contact'?contact_id:user_id);
							var select_folder_dialog_id=newFilocitySelectFolderDialog('create_contact_folder_'+select_folder_id,false,
							function(folder_id, folder_name){
								$('#'+select_folder_dialog_id).dialogAttachLoadingIndicator('Creating '+tbl+' Folder...');
								var url;
								if(tbl=='User'){
									url=_ROOT+'users/create_user_folder';
									data={user_id:user_id,folder_id:folder_id};
								}else{
									url=_ROOT+'contacts/create_contact_folder';
									data={contact_id:contact_id,folder_id:folder_id};
								}
								var create_folder_ajax=$.ajax({
									url: url,
									data: data,
									type: 'POST',
									dataType: 'JSON',
									success: function(data){
										$('#'+select_folder_dialog_id).dialog('close');
										newContactInfoDialog(contact_id,user_id);
									},
									error: function(err){
										if(err.responseText!=null){
											filocityDebug('Error','<pre>'+err.responseText+'</pre>');
										}
									},
									complete: function(){
										contact_info_ajax=null;
										$('#'+select_folder_dialog_id).dialogRemoveLoadingIndicator();
									}
								});
								
							},
							function(){
								newContactInfoDialog(contact_id,user_id);
							});
							return false;
						});
				}else{
					$('#'+dialog_id+' .contact-folder-link')
						.attr('href',_ROOT+'cabinets/folder/'+data[0][tbl]['folder_id'])
						.attr('target','_blank')
						.html('View Folder');
				}
			}else{
				$('#'+dialog_id+' .edit-contact-link').hide();
				$('#'+dialog_id+' .delete-contact-link').hide();
			}
			$('#'+dialog_id).dialog('option','position','center');
			if(data['error']!=undefined){
				
			}else{
				
			}
		},
		error: function(err){
			if(err.responseText!=null){
				filocityDebug('Error','<pre>'+err.responseText+'</pre>');
			}
		},
		complete: function(){
			contact_info_ajax=null;
			$('#'+dialog_id).dialogRemoveLoadingIndicator();
		}
	});
}
*/
/*
DISPLAY CONTACT INFO
************************************************/
var contact_info_ajax=null;
var current_contact_info=null;
var displayContactInfo=function(contact_id, user_id){
	if(contact_info_ajax!=null){
		contact_info_ajax.abort();
		contact_info_ajax=null;
	}
	var dialog_id='contact_info_container';
	var url=null;
	if(user_id!=null){
		url=_ROOT+'users/get_user_info/'+user_id;
		$('#contact_info_container .left-container-title').html('User Info');
	}else{
		url=_ROOT+'contacts/get_contact_info/'+contact_id;
		$('#contact_info_container .left-container-title').html('Contact Info');
	}
	var contact_info=[];
	$('#'+dialog_id+' .row').hide();
	$('#'+dialog_id+' form').hide();
	contact_info_ajax=$.ajax({
		url: url,
		data: {},
		type:'POST',
		dataType: 'JSON',
		success: function(data){
			contact_info=data;
			var tbl='Contact';
			if(data[0]['User']!=undefined){
				tbl='User';
			}
			
			for(var x in data[0][tbl]){
				if(data[0][tbl][x]==null || data[0][tbl][x]==''){
					continue;
				}
				$('#'+dialog_id+' .'+x+' .info').html(data[0][tbl][x]);
				$('#'+dialog_id+' .'+x).show();
			}
			if(data[0][tbl]['email']!=''){
				$('#'+dialog_id).dialog('option','title',data[0][tbl]['email']+' - '+tbl+' Info');
				$('#'+dialog_id+' .email-link').attr('href','mailto:'+data[0][tbl]['email']);
			}
			
			$('#'+dialog_id+' .groups-link').show();
			$('#'+dialog_id+' .groups-link').unbind('click').bind('click',function(){
				if(tbl=='User'){
					newFilocityContactGroupsDialog(null, user_id);
				}else{
					newFilocityContactGroupsDialog(contact_id);
				}
				return false;
			});
			
			$('#contact_list li[data-'+tbl.toLowerCase()+'-id="'+data[0][tbl]['id']+'"]').html(listName(data[0][tbl]));
			
			$('#'+dialog_id+' .shares-link').click(function(){
				return false;
			});
			
			var allow_write=true;
			if(allow_write){
				if(tbl=='User'){
					$('#'+dialog_id+' .edit-contact-link').hide();
					$('#'+dialog_id+' .delete-contact-link').hide();
				}else{
					$('#'+dialog_id+' .edit-contact-link').show();
					$('#'+dialog_id+' .edit-contact-link').unbind('click').bind('click',function(){
						newFilocityContactDialog(contact_id, contact_info, {
							success: function(contact_id){
								if($('#contact_list .ui-selected').length==1 && $('#contact_list li[data-contact-id="'+contact_id+'"]').hasClass('ui-selected')){
									displayContactInfo(contact_id);
								}
							}
						});
						return false;
					});
					$('#'+dialog_id+' .delete-contact-link').show();
					$('#'+dialog_id+' .delete-contact-link').attr('data-contact-id',contact_id);
					$('#'+dialog_id+' .delete-contact-link').unbind('click').bind('click',function(){
						delete_contacts('Delete Contact', 'Are you sure you would like to delete this contact?', 'Deleting Contact...', $('#'+dialog_id+' .delete-contact-link'), function(){
							$('.current-contact-group').click();
						});
						return false;
					});
				}
				
				var url;
				if(tbl=='User'){
					url=_ROOT+'users/get_folder_id/'+data[0][tbl]['id'];
				}else{
					url=_ROOT+'contacts/get_folder_id/'+data[0][tbl]['id'];
				}
				
				$('#'+dialog_id+' .contact-folder-link').show();
				var tbl_folder_id=data[0]['Share']['folder_id'];
				if(tbl_folder_id==0){
					$('#'+dialog_id+' .contact-folder-link')
						.html('Create a Folder')
						.unbind('click').bind('click',function(){
							var select_folder_id=tbl+'_'+(tbl=='Contact'?contact_id:user_id);
							var select_folder_dialog_id=newFilocitySelectFolderDialog('create_contact_folder_'+select_folder_id,false,
							function(folder_id, folder_name){
								$('#'+select_folder_dialog_id).dialogAttachLoadingIndicator('Creating '+tbl+' Folder...');
								var url;
								if(tbl=='User'){
									url=_ROOT+'users/create_user_folder';
									data={user_id:user_id,folder_id:folder_id};
								}else{
									url=_ROOT+'contacts/create_contact_folder';
									data={contact_id:contact_id,folder_id:folder_id};
								}
								var create_folder_ajax=$.ajax({
									url: url,
									data: data,
									type: 'POST',
									dataType: 'JSON',
									success: function(data){
										$('#'+select_folder_dialog_id).dialog('close');
										displayContactInfo(contact_id,user_id);
									},
									error: function(err){
										if(err.responseText!=null){
											filocityDebug('Error','<pre>'+err.responseText+'</pre>');
										}						
									},
									complete: function(){
										$('#'+select_folder_dialog_id).dialogRemoveLoadingIndicator();
									}
								});
								
							},
							function(){
								//newContactInfoDialog(contact_id,user_id);
							});
							return false;
						});
				}else{
					$('#'+dialog_id+' .contact-folder-link')
						.unbind('click')
						.attr('href',_ROOT+'cabinets/folder/'+tbl_folder_id)
						.attr('target','_blank')
						.html('View Folder');
				}
				$('#'+dialog_id+' form').show();
			}else{
				$('#'+dialog_id+' .edit-contact-link').hide();
				$('#'+dialog_id+' .delete-contact-link').hide();
			}
			if(data['error']!=undefined){
				
			}else{
				
			}
		},
		error: function(err){
			if(err.responseText!=null){
				filocityDebug('Error','<pre>'+err.responseText+'</pre>');
			}
		},
		complete: function(){
			contact_info_ajax=null;
			$('#'+dialog_id).dialogRemoveLoadingIndicator();
		}
	});
}
/*
SELECT FOLDER DIALOG
************************************************/
var filocitySelectFolderDialogNum=0;
var newFilocitySelectFolderDialog=function(dialog_id, is_modal, select_cb, cancel_cb){
	if(dialog_id==null){
		filocitySelectFolderDialogNum++;
		dialog_id='filocitySelectFolderDialog_'+filocitySelectFolderDialogNum;
	}else if($('#'+dialog_id).length>0){
		$('#'+dialog_id).dialog('moveToTop');
		return;
	}
	$('body').append('<div id="'+dialog_id+'">'+$('#select_folder_dialog').html()+'</div>');
	filocityDialog('#'+dialog_id, is_modal);
	$('#'+dialog_id).dialog('option','title','Select Target Folder');
	var folder_id=null, folder_name=null;
	$('#'+dialog_id+' .select-button').click(function(){
		if(folder_id==null || folder_id==0){
			return;
		}
		select_cb(folder_id, folder_name);
	});
	$('#'+dialog_id+' .cancel-button').click(function(){
		cancel_cb();
		$('#'+dialog_id).dialog('close');
	});
	$('#'+dialog_id).dialog('option','width',400);
	
	$('#'+dialog_id+' .folder_browser:first-child')
		.jstree({
			"plugins" : ["themes","json_data","ui"],
			"json_data" : {
				"ajax" : {
					"url" : _ROOT+"folders/list_folder_contents",
					"data" : function (n) { 
						return {
							"data[parent_id]" : n.attr ? n.attr("id").replace("node_","") : 0
						}; 
					},
					"error" : function (err) {
						if(err.responseText!=null){
							//filocityDebug('Error','<pre>'+err.responseText+'</pre>');
						}		
					},
					"type" : "POST"
				}
			}
		})
		.bind("loaded.jstree", function (event, data) {
			
		})
		.one("reopen.jstree", function (event, data) { })
		.one("reselect.jstree", function (event, data) { })
		.bind("select_node.jstree", function (event, data) { 
			folder_id=data.rslt.obj.attr("id").replace('node_','');
			folder_name=data.rslt.obj.attr("name");
		})
		.delegate("a", "click", function (event, data) { event.preventDefault(); });
	
	$('#'+dialog_id).dialog('open');
	
	return dialog_id;
}

var newFilocityContactGroupsDialog=function(contact_id, user_id){
	var dialog_id='contact_groups_'+contact_id;
	if($('#'+dialog_id).length>0){
		$('#'+dialog_id).dialog('moveToTop');
		return;
	}
	
	$('body').append('<div id="'+dialog_id+'" class="contact_groups_dialog">'+$('#contact_groups_dialog').html()+'</div>');
	filocityDialog('#'+dialog_id);
	$('#'+dialog_id).dialog('option','width',400);
	$('#'+dialog_id).dialog('option','minHeight',200);
	var url;
	if(user_id!=null){
		url=_ROOT+'users/get_user_groups/'+user_id;
		$('#'+dialog_id).dialog('option','title','User Groups');
		$('#'+dialog_id).dialogAttachLoadingIndicator('Loading User Groups...');
	}else{
		url=_ROOT+'contacts/get_contact_groups/'+contact_id;
		$('#'+dialog_id).dialog('option','title','Contact Groups');
		$('#'+dialog_id).dialogAttachLoadingIndicator('Loading Contact Groups...');
	}
	
	var contact_groups_ajax=$.ajax({
		url: url,
		type: 'POST',
		dataType: 'JSON',
		success: function(data){
			for(var x in data){
				$('#'+dialog_id+' ul').append('<li>'+data[x]['Group']['name']+'</li>');
			}
		},
		error: function(err){
			if(err.responseText!=null){
				filocityDebug('Error','<pre>'+err.responseText+'</pre>');
			}
		},
		complete: function(){
			contact_groups_ajax=null;
			$('#'+dialog_id).dialogRemoveLoadingIndicator();
		}
	});
	
	$('#'+dialog_id).dialog('open');
}

var newFilocityContactSharesDialog=function(contact_id){
	filocityDialog('#contact_shares_dialog');
	$('#contact_shares_dialog').dialog('option','title','Contact Shares');
	$('#contact_shares_dialog').dialog('open');
}

});