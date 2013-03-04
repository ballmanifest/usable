$(function() {
	$('.tasks_list li').on('click', function() {
		$(this).toggleClass('completed_task');
	});




	FilocityModal.init();
	
	/*
	*	Mini Calendar Call
	*/
	$.miniCalendar().drawCalendar();

	/*
	*	Set Events List under
	*/
	$.eventsList('#event_lists').generateList();
	
	/*
	*	Show User selection list
	*/
	
	//$.userSelectionList();
	
	/*
	*	Toggle Events List
	*/


	$('#event_selection a').on({
		click: function(e) {
			e.preventDefault();
			var ref = $(this),
			eventsType = $.trim( ref.data('eventcat') );
			ref.parent().find('a.selected').removeClass('selected');
			ref.addClass('selected');
			if( eventsType == 'all') {
				$.eventsList('#event_lists', {
					data: {
						'data[CalendarEvent][type]' : 'all'
					}
				}).generateList();
			} else {
				$.eventsList().generateList();
			}
		}
	});
	
	/*
	*	Get data for Budget progress bar
	*/
	
	$('.task_completion_bar .progress_percentile').each(function() {
		var _ref = $(this),
		width = _ref.width(),
		left = +_ref.css('left').replace('px', ''),
		completed = +_ref.data('completed'),
		total = +_ref.data('total'),
		ratio = total == 0 ? 0 : (completed / total),
		percentile = Math.floor(parseInt( ratio * 100 )),
		pos = left + Math.floor((Math.abs(left) / total)) * completed;
		_ref.animate({
			left: pos
		}, 1000, function() {
			$(this).closest('td.indicator_bar').next('td.percentile').text(percentile + '%');
		});
	});
	
	/**
	*	Change Task View
	*/
	$('.all_tasks').on({
		click: function(e) {
			$('.header_title a.selected').removeClass('selected');
			$(this).addClass('selected');
			e.preventDefault();
			$('ul.tasks_list li[data-userid]').show();
		}
	});
	$('.mine_tasks').on({
		click: function(e) {
			e.preventDefault();
			$('.header_title a.selected').removeClass('selected');
			$(this).addClass('selected');
			$('ul.tasks_list li[data-userid]').hide(0);
			$('ul.tasks_list li[data-userid="'+ $('input.auth_id').val() +'"]').show();
		}
	});
	
	/**
	 *	Get Recent Project Files
	 */
	
	$.get(_ROOT + 'cabinets/documents', {
				sourceId: $('input:hidden.folder_id').val(),
				limit : 5
			},
			function(data) {
				var html = $('<div/>').html(data);
				if(html.find('div.not-found').length) {
					data  += '<a href="'+ _ROOT + 'cabinets?projfldr='+ $('input:hidden.folder_id').val() +'#multipleUpload" style="text-decoration: none; color: #39A2EC; float:right">Add project files</a>';
				}
				$('#recent_file_box').html(data);
                $('#recent_file_box').mCustomScrollbar('update');
				/**
				*		Fancybox Image Viewer and Comment
				*/
				
				$('.fancyboxComment').fancybox({
					autoDimensions: true,
					width: 600,
					onComplete: function(handler) {
						$.RecentProjectFilesAction.DocumentComments.autoScrollBottom();
						var commentType = $(handler).data('commenttype');
						if(commentType != 'notice') {
							$("#directoryDetails").find(".directoryHeader").text($('span.project_main_title').text());
							$('.add-new-comment img.loader:visible').hide(0);
						}
					}
				});
				$.RecentProjectFilesAction.DocumentComments.ready();
			},
			'html'
		);
		
	/**
	 *	Recent File Checkbox click
	 */
	$('#recent_file_box_for_current_projects').on('click','.list_item_selection',function() {
		$(this).toggleClass('completed_task');
		$(this).prev('input[type=checkbox][name^=file_selected]').prop('checked',function(i, checked) {
			return ! checked;
		});
	});
	
	/**
	*	Project Files Actions
	*/
	
	$.RecentProjectFilesAction = {
		setMask: function() {
			var height = $('#main_container').height() + 10;
			$('body').append('<div class="overlay-info me_hide" style="background-color: #777; opacity: 0.7; display: none;height: ' + height + 'px"></div>');
		},
		UIDialog: function(title, message, type, yesFunction, element) {
			var buttons = {};
			if (typeof(type) != "undefined" && type == "confirm") {
				var buttons = {
					Yes: function() {
						$(this).dialog("close");
						yesFunction(element);
					},
					No: function() {
						$(this).dialog("close");
					}
				};
			}
			$("#dialog").find("p").text(message);
			$("#dialog").attr("title", title);
			$("#dialog").dialog({
				buttons: buttons,
				modal: true,
				"width": 440,
				"z-index": 1100,
				"left" : 200
			});
		},
		Form : {
			submit: function(form, showRequest, showResponse, reset) {
				if (typeof(reset) == "undefined") {
					reset = true;
				}
				var options = {
					target: $(form).find('.ajaxTarget'),
					beforeSubmit: showRequest,
					success: showResponse,
					resetForm: reset
				};
				$(form).ajaxSubmit(options);
			},
			bind: function(form, showRequest, showResponse, reset) {
				if (typeof(reset) == "undefined") {
					reset = true;
				}
				var options = {
					target: $(form).find('.ajaxTarget'),
					beforeSubmit: showRequest,
					success: showResponse,
					resetForm: reset
				};
				$(form).ajaxForm(options);
			}
		},
		DocumentComments: {
			commentCounterElement: "",
			ready: function() {
				var parent = this;
				$("textarea.textarea").live("keypress",
					function(e) {
						if (e.which == 13) {
							var form = $(".formComments");
							$.RecentProjectFilesAction.Form.submit(form, $.RecentProjectFilesAction.DocumentComments.request, $.RecentProjectFilesAction.DocumentComments.response);
						}
					}
				);
				$("body").on("click", "a.docComment",
				function(e) {
					e.preventDefault();
					$.RecentProjectFilesAction.DocumentComments.commentCounterElement = $(this).parent().find(".abs");
				});
			},
			request: function(formData, jqForm, options) {
				$(jqForm).find(".loader").show();
				if ($(jqForm).find("textarea.textarea").val().length <= 1) {
					$(jqForm).find(".loader").hide();
					return false;
				}
				return true;
			},
			response: function(responseText, statusText, xhr, $form) {
				var currentCommentElement = $.RecentProjectFilesAction.DocumentComments.commentCounterElement;
				var total = $(currentCommentElement).text();
				$(currentCommentElement).text(parseInt(total) + 1);
				$(currentCommentElement).parent().addClass("none-opacity").css("opacity", 100);
				$($form).find(".loader").hide();
				$($form).before(responseText);
				$.RecentProjectFilesAction.DocumentComments.autoScrollBottom();
				$(".comment-wrapper").removeAttr("style");
				$.fancybox.center();
			},
			autoScrollBottom: function() {
				if (typeof $('.comment-wrapper')[0] != "undefined") {
					$(".comment-wrapper").animate({
						scrollTop: $('#fancybox-content')[0].scrollHeight + 100
					},
					1800);
					$(".formComments").find(".textarea").focus();
				}
			}
		},
		initEvents : function() {
			this.container = $('#recent_file_box');
			this.listItem = '.list_view_each_item';
			this.docViewerIcon = 'li.list_view_each_item a.icon-eye-open:visible';
			this.shareDocIcon = 'li.list_view_each_item a.shareDoc:visible';
			this.showInfoIcon= 'li.list_view_each_item a.showInfo:visible';
			this.editIcon = 'li.list_view_each_item .editInfo';
			this.saveIcon = 'li.list_view_each_item .saveInfo';
			this.renameIcon = 'li.list_view_each_item  a.renameFile';
			this.deleteIcon = 'li.list_view_each_item a.deleteDoc';
			this.overLay = '.overlay-info';
			var $this = this;
			
			/**
			*	On overlay Click
			*/
			$('body').on({
				click : function () {
					$('.doc-info:visible, .doc-share:visible, .doc-edit:visible, .overlay-info:visible, .rolling_container:visible').fadeOut();
				}
			}, this.overLay);
			
			/*
			*	On List Hover
			*/
			$(this.container).on({
				mouseenter : function(e) {
					$('.rolling_container', this).show();
				},
				mouseleave : function(e) {
					if( !$('.doc-info:visible').length && !$('.doc-share:visible').length && !$('.doc-edit:visible').length ) {
						$('.rolling_container', this).hide();
					}
				}
			}, this.listItem);
			
			/**
			*	On Eye Click
			*/
			$(this.container).on({
				click : function() {
					var targetImage = $(this).data('relatedthumb');
					$('a.fancybox.' + targetImage).trigger('click');
				}
			},this.docViewerIcon);
			
			/**
			*	On Share Click
			*/
			$(this.container).on({
				click : function() {
					var target = $(this).attr('paramid');
					$(['#'+ target, $this.overLay].join(',')).fadeIn();
				}
			},this.shareDocIcon);
			
			/**
			*	On Show Info Click
			*/
			$(this.container).on({
				click : function() {
					var target = $(this).attr('paramid');
					$(['#'+ target, $this.overLay].join(',')).fadeIn();
				}
			},this.showInfoIcon);
			
			/**
			*	On Edit Info Click
			*/
			$(this.container).on({
				click: function() {
					var target = $(this).attr("paramId");
					$(['#'+ target, $this.overLay].join(',')).fadeIn();
				}
			}, this.editIcon);
			
			/**
			*	On Save Button Click
			*/
			$(this.container).on({
				click : function() {
					var id = $(this).attr("paramId");
					var name = $(this).prev("input").val();
					var parent = this;
					if (name.length >= 1) {
						$(this).hide();
						$(this).next(".loader").show();
						$.post(_ROOT + 'cabinets/updateInfo', {
							id: id,
							name: name
						},
						function(data) {
							$(".file_title.ft" + id).find("span").text(name);
							$(".doc-edit:visible, .overlay-info:visible").fadeOut();
							$(parent).next(".loader").hide();
							$(parent).show();
						});
					}
				}
			}, this.saveIcon);
			
			/**
			*	On Rename File Link Click
			*/
			$(this.container).on({
				click:  function() {
					$(".doc-info:visible").fadeOut(10);
					$(this).parent().parent().parent().parent().find(".editInfo").trigger("click");
				}
			}, this.renameIcon);
			
			/**
			*	On Delete Doc 
			*/
			$(this.container).on({
				click : function() {
					var parent = this;
					var message = "Are you sure you want to delete this document?";
					var yesFunction = function(parent) {
						$(parent).parent().parent().parent().parent().css("background", "#FFFFE8");
						var paramId = $(parent).attr("paramId");
						$.post(_ROOT + 'cabinets/deleteDocument', {
							id: paramId
						},
						function(data) {
							$(parent).parent().parent().parent().parent().css("background", "#FFFFE8").fadeOut();
							$("#image_holder").find("li.t" + paramId).remove();
							$(".overlay-info").hide();
						});
					};
					$.RecentProjectFilesAction.UIDialog("Delete document", message, "confirm", yesFunction, this);
				}
			}, this.deleteIcon);
			
		},
		init : function() {
			$.RecentProjectFilesAction.initEvents();
			$.RecentProjectFilesAction.setMask();
		}
	};
	
	$.RecentProjectFilesAction.init();
	$('.files .fancybox').fancybox();
	$('.files').on({
		click : function() {
			var targetImage = $(this).data('relatedthumb');
			$('.files a.fancybox.' + targetImage).trigger('click');
		}
	},'.image_view');
	
	/**
	*	Add project modal
	*/
	$(".fancyboxFrame").on("click", function(event){
		var _this = this;
		event.preventDefault();
		$.fancybox({
			padding: 0,
			type: 'iframe',
			href: this.href,
			autoScale: false,
			width: $(_this).data('width'),
			height: $(_this).data('height')
		});
	});
	
});

var FilocityModal={
	dialog: null,
	maxHeight: null,
	show: function(){
		$('#filocity_modal_progress').hide();
		$('#filocity_modal_dialog_outer').show();
		this.dialog.css({
			'display':'block',
			'position':'fixed',
			'opacity':0,
			'padding':'10px'
		});
		FilocityModal.alignCenter();
		this.current_dialog.mCustomScrollbar();
		$('.mCSB_draggerContainer').css({
			'opacity':0.4
		});
		this.dialog.animate({
			'opacity':1
		},200,function(){
		
		});
	},
	setMaxHeight:function(h){
		this.maxHeight=h;
	},
	showProgress:function(){
		this.dialog.css({'display':'none'});
		$('#filocity_modal_dialog_outer').show();
		$('#filocity_modal_progress').show();
	},
	scrollBottom:function(){

		//this.current_dialog.stop().animate({'scrollTop':this.current_dialog.prop('scrollHeight')},0);
		this.current_dialog.mCustomScrollbar('scrollTo','bottom');
	},
	alignCenter: function(){
		if(this.maxHeight>$(window).height()-40){
			this.maxHeight=$(window).height()-40;
		}
		if(this.current_dialog.height()>=this.maxHeight){
			this.current_dialog.css({
				'height': this.maxHeight
			});
		}
		var t=Math.max(0, (($(window).height() - this.dialog.outerHeight()) / 2));
		var l=Math.max(0, (($(window).width() - this.dialog.outerWidth()) / 2));
		this.dialog.css({
			'left': l + 'px',
			'top': t + 'px'
		});
		this.current_dialog.mCustomScrollbar('update');
	},
	close: function(){
		this.onClose();
		this.dialog.hide();
		$('#filocity_modal_dialog_outer, #add_project_modal:visible, #comment_container_block:visible').hide();
		this.onClose=function(){};
		return false;
	},
	setContent: function(html){
		this.current_dialog.html(html);

	},
	init: function(){
		$('body').append('<div id="filocity_modal_dialog_outer" style="top:0;left:0;width:100%;height:100%;position:fixed;display:none;"></div>');
		$('body').append('<div id="filocity_modal_dialog" class="shadow"><div class="btn_container me_absolute"><div class="btn_wrapper"><div class="btn_self"><span class="cross_icon">&nbsp;</span></div></div></div></div>')
		$('body').append('<div id="filocity_modal_progress" style="display:none;position:fixed;top:0;left:0;">Loading...</div>');
		
		$('#filocity_modal_dialog_outer').css({
			backgroundColor:'#000000',
			opacity:0.5
		});
		this.dialog=$('#filocity_modal_dialog');
		this.dialog.hide();
		this.dialog.css('display','none');
		$('#filocity_modal_dialog_outer').click(function(){
			FilocityModal.close();
		});
		$(document).keyup(function(e) {
			if (e.keyCode == 27) {
				FilocityModal.close();
			}
		});
	},
	dialogs:{},
	current_dialog:null,
	setCurrent: function(dialog_id){
		this.maxHeight=$(window).height()-40;
		if(this.dialogs[dialog_id]==undefined){
			this.dialog.append('<div class="dialog-content" id="filocity_modal_dialog_'+dialog_id+'"></div>');
			this.dialogs[dialog_id]=$('#filocity_modal_dialog_'+dialog_id);
		}
		$('#filocity_modal_dialog .dialog-content').css('display','none');
		this.dialogs[dialog_id].css({
			'display':'block',
			'overflowX':'hidden',
			'overflowY':'auto'
		});
		this.current_dialog=this.dialogs[dialog_id];
	},
	onClose: function(){},
};


function show_notice_comments_dialog(task_id){
	FilocityModal.setCurrent('comments');
	FilocityModal.setMaxHeight(500);
	var html='\
		<div style="width:515px;float:left; height: 300px;">\
			<div id="comments_comments"></div>\
			<div id="comments_comment_box">\
				<textarea></textarea>\
			</div>\
		</div>\
	</div>\
	';

	FilocityModal.setContent(html);
	var ajaxLoader=$.ajax({
		url: _ROOT+'noticescomments/show_comments',
		type:'POST',
		dataType: 'JSON',
		data: {notice_id:task_id},
		success: function(data){
			for(var i in data){
				$('#comments_comments').append('\
					<div class="comment">\
						<div class="photo">\
							<img src="'+_ROOT+'img/filocity_img/user_'+data[i]['User']['id']+'/profile.jpg" alt="Photo" />\
						</div>\
						<div class="comment-text">'+data[i]['NoticesComment']['comment']+'</div>\
						<div class="date-posted"><a href="#">'+data[i]['User']['first_name']+'</a> posted '+data[i]['NoticesComment']['created']+'</div>\
					</div>\
				');
					
			}
		},
		error: function(){
			
		},
		complete: function(){
			
			if(task_comments_task_id!=null){
				FilocityModal.alignCenter();
				FilocityModal.show();
				FilocityModal.scrollBottom();
			}
		}
	});

	task_comments_task_id=task_id;
	FilocityModal.onClose=function(){
		ajaxLoader.abort();
		task_comments_task_id=null;
	};
	FilocityModal.showProgress();
	return false;
}

/*date format*/
var dateFormat = function () {
	var	token = /d{1,4}|m{1,4}|yy(?:yy)?|([HhMsTt])\1?|[LloSZ]|"[^"]*"|'[^']*'/g,
		timezone = /\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g,
		timezoneClip = /[^-+\dA-Z]/g,
		pad = function (val, len) {
			val = String(val);
			len = len || 2;
			while (val.length < len) val = "0" + val;
			return val;
		};

	// Regexes and supporting functions are cached through closure
	return function (date, mask, utc) {
		var dF = dateFormat;

		// You can't provide utc if you skip other args (use the "UTC:" mask prefix)
		if (arguments.length == 1 && Object.prototype.toString.call(date) == "[object String]" && !/\d/.test(date)) {
			mask = date;
			date = undefined;
		}

		// Passing date through Date applies Date.parse, if necessary
		date = date ? new Date(date) : new Date;
		if (isNaN(date)) throw SyntaxError("invalid date");

		mask = String(dF.masks[mask] || mask || dF.masks["default"]);

		// Allow setting the utc argument via the mask
		if (mask.slice(0, 4) == "UTC:") {
			mask = mask.slice(4);
			utc = true;
		}

		var	_ = utc ? "getUTC" : "get",
			d = date[_ + "Date"](),
			D = date[_ + "Day"](),
			m = date[_ + "Month"](),
			y = date[_ + "FullYear"](),
			H = date[_ + "Hours"](),
			M = date[_ + "Minutes"](),
			s = date[_ + "Seconds"](),
			L = date[_ + "Milliseconds"](),
			o = utc ? 0 : date.getTimezoneOffset(),
			flags = {
				d:    d,
				dd:   pad(d),
				ddd:  dF.i18n.dayNames[D],
				dddd: dF.i18n.dayNames[D + 7],
				m:    m + 1,
				mm:   pad(m + 1),
				mmm:  dF.i18n.monthNames[m],
				mmmm: dF.i18n.monthNames[m + 12],
				yy:   String(y).slice(2),
				yyyy: y,
				h:    H % 12 || 12,
				hh:   pad(H % 12 || 12),
				H:    H,
				HH:   pad(H),
				M:    M,
				MM:   pad(M),
				s:    s,
				ss:   pad(s),
				l:    pad(L, 3),
				L:    pad(L > 99 ? Math.round(L / 10) : L),
				t:    H < 12 ? "a"  : "p",
				tt:   H < 12 ? "am" : "pm",
				T:    H < 12 ? "A"  : "P",
				TT:   H < 12 ? "AM" : "PM",
				Z:    utc ? "UTC" : (String(date).match(timezone) || [""]).pop().replace(timezoneClip, ""),
				o:    (o > 0 ? "-" : "+") + pad(Math.floor(Math.abs(o) / 60) * 100 + Math.abs(o) % 60, 4),
				S:    ["th", "st", "nd", "rd"][d % 10 > 3 ? 0 : (d % 100 - d % 10 != 10) * d % 10]
			};

		return mask.replace(token, function ($0) {
			return $0 in flags ? flags[$0] : $0.slice(1, $0.length - 1);
		});
	};
}();

// Some common format strings
dateFormat.masks = {
	"default":      "ddd mmm dd yyyy HH:MM:ss",
	shortDate:      "m/d/yy",
	mediumDate:     "mmm d, yyyy",
	longDate:       "mmmm d, yyyy",
	fullDate:       "dddd, mmmm d, yyyy",
	shortTime:      "h:MM TT",
	mediumTime:     "h:MM:ss TT",
	longTime:       "h:MM:ss TT Z",
	isoDate:        "yyyy-mm-dd",
	isoTime:        "HH:MM:ss",
	isoDateTime:    "yyyy-mm-dd'T'HH:MM:ss",
	isoUtcDateTime: "UTC:yyyy-mm-dd'T'HH:MM:ss'Z'"
};

// Internationalization strings
dateFormat.i18n = {
	dayNames: [
		"Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat",
		"Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"
	],
	monthNames: [
		"Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
		"January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
	]
};

// For convenience...
Date.prototype.format = function (mask, utc) {
	return dateFormat(this, mask, utc);
};


$(window).load(function() {

    $('#recent_file_box').mCustomScrollbar();
});









