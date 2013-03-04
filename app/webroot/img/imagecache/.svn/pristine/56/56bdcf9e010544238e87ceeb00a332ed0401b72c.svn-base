var FilocityDialogHelper={
	filocityConfirmDialogNum: 0,
	confirm: function(options){
		options=options==undefined?{}:options;
		options['title']==undefined?'Confirm':options['title'];
		options['yes']=options['yes']==undefined?function(){}:options['yes'];
		options['no']=options['no']==undefined?function(){}:options['no'];
		options['message']==undefined?'Are you sure?':options['message'];
		FilocityDialogHelper.filocityConfirmDialogNum++;
		var dialog_id='filocity_confirm_dialog_'+FilocityDialogHelper.filocityConfirmDialogNum;
		$('body').append('<div id="'+dialog_id+'">\
			<div style="padding:10px 10px 0 10px;text-align:center;">'+options['message']+'</div>\
			<div style="clear:both;"></div>\
			<div class="buttons" style="float:right;padding:0 10px 10px 10px;">\
				<input type="button" value="Yes" class="yes-button filocity-modal-button" style="padding:0 10px 10px 10px;margin:0;" />\
				<input type="button" value="No" class="no-button filocity-modal-button pink" style="padding:0 10px 10px 10px;margin:0;margin-left:5px;" />\
			</div>\
		</div>');
		FilocityDialogHelper.dialog('#'+dialog_id, {
			modal:true,
			positionFixed:true
		});
		$('#'+dialog_id).dialog('option','title',options['title']);
		$('#'+dialog_id).find('.yes-button').click(function(){
			options['yes']();
			$('#'+dialog_id).dialog('close');
		});
		$('#'+dialog_id).find('.no-button').click(function(){
			options['no']();
			$('#'+dialog_id).dialog('close');
		});
		$('#'+dialog_id).dialog('open');
		$('.ui-widget-overlay').css({opacity:0.35});
		return dialog_id;
	},
	
	alert: function(options){
		options=options==undefined?{}:options;
		options['title']==undefined?'Confirm':options['title'];
		options['ok']=options['no']==undefined?function(){}:options['no'];
		options['message']==undefined?'Are you sure?':options['message'];
		FilocityDialogHelper.filocityConfirmDialogNum++;
		var dialog_id='filocity_confirm_dialog_'+FilocityDialogHelper.filocityConfirmDialogNum;
		$('body').append('<div id="'+dialog_id+'">\
			<div style="padding:10px 10px 0 10px;text-align:center;">'+options['message']+'</div>\
			<div style="clear:both;"></div>\
			<div class="buttons" style="float:right;padding:0 10px 10px 10px;">\
				<input type="button" value="Ok" class="ok-button filocity-modal-button" style="padding:0 10px 10px 10px;margin:0;" />\
			</div>\
		</div>');
		FilocityDialogHelper.dialog('#'+dialog_id, {
			modal:true,
			positionFixed:true
		});
		$('#'+dialog_id).dialog('option','title',options['title']);
		$('#'+dialog_id).find('.ok-button').click(function(){
			options['ok']();
			$('#'+dialog_id).dialog('close');
		});
		$('#'+dialog_id).dialog('open');
		$('.ui-widget-overlay').css({opacity:0.35});
	},
	
	dialog: function(selector, options){
		if(options==undefined){
			options={};
		}
		var isModal=options['modal']!=undefined && options['modal']==true;
		var positionFixed=options['positionFixed']!=undefined && options['positionFixed']==true;
		
		$(selector).dialog({
			dialogClass: 'fc-dialog',
			resizable:false,
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
					$(window).on('resize',function(){
						heightFix();
					});
					$(this).attr('data-event-attached',1);
				}
				
			}
		});
		$(selector).bind('dialogclose', function(){
			$(this).dialog('destroy').remove();
		});
		$(selector).mCustomScrollbar();
		if(positionFixed){
			$(selector).parent().addClass('fc-dialog-fixed-position');
		}
	},
	init: function(){
	
	}
}
FilocityDialogHelper.init();
