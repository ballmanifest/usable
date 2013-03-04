var full_calendar_options={};
var full_calendar_current_event=null;
$(document).ready(function() {
	
	/*
	 *  Custom components
	 */
	$.myCalendar = function() {
		
		var self = this,
		sel = $('.the_popup:visible'),
		start = $('.my_date_start'),
		end = $('.my_date_end'),
		methods = {
			
			nope: function() {},
			togglePopup: function(callBack) {
				if (sel.length) {
					$(sel).slideUp(100, callBack);
				} else callBack();
			},
			addCalendarEvent: function() {
				$.post(_ROOT + 'calendar_events/add_calendar_event', $('form.event_create_popup:visible').serialize(),
				function(response) {
					if (response.status == 'y') {
						$('img.loader_img').addClass('me_hide');
						$('.button, img', 'div.sdd_panel').toggle(20);
						$('.my-overlay-info').hide(0);
						$('form.event_create_popup:visible').find('input.event_title').val('').end().find('select').prop('selectedIndex', 0);
						//$('.the_popup:visible').slideUp(200);
						$('#fancybox-close').click();
						if($('input:hidden.this_controller').val() != 'cabinets') {
							$('#calendar').fullCalendar('renderEvent', response.event[0]);
						}
						//location.reload();
					} else {
						alert('Event not saved. Please try again.');
					}
				},
				'json');
			},
			editCalendarEvent: function() {
				$.post(_ROOT + 'calendar_events/edit_calendar_event', $('form.event_create_popup:visible').serialize(),
				function(response) {
					if (response.status == 'y') {
						$('img.loader_img').addClass('me_hide');
						$('.button, img', 'div.sdd_panel').toggle(20);
						$('form.event_create_popup:visible').find('input.event_title').val('').end().find('select').prop('selectedIndex', 0);
						$('.the_popup:visible').slideUp(200);
						
						for(var x in response.event[0]){
							full_calendar_current_event[x]=response.event[0][x];
						}
						$('#calendar').fullCalendar('updateEvent', full_calendar_current_event);
					} else {
						alert('Event not saved. Please try again.');
					}
				},
				'json');
			},
			deleteCalendarEvent: function(id) {
				$.get(_ROOT + 'calendar_events/delete_calendar_event/' + id, function(response) {
					if( response.status == 'y') {
						$('.the_popup:visible').slideUp(200);
						$('#calendar').fullCalendar('removeEvents', id);
					}
				}, 'json');
			},
			updateEvent: function(data) {
				$.post(_ROOT + 'calendar_events/edit_calendar_event', data, function(response) {
					if(response.status == 'y') {
						$('#calendar').fullCalendar('updateEvent', response.event[0]);
					} else {
						alert('Event fails to update');
					}
				}, 'json');
			},
			dateObject: function(date) {
				return Date.parse(date);
			},
			displayDate: function(date1, date2) {
				var dstr = '';
				if(date1 && !date2) {
					dstr = new Date(date1).toString('ddd, MMMM dd') + ', ' + new Date().toString("hh:mm tt");
				} else if(date1 && date2) {
					dstr = new Date(date1).toString('ddd, MMMM dd, hh:mm tt') + ' - ' + new Date(date2).toString('ddd, MMMM dd, hh:mm tt');
				}
				return dstr;
			},
			onPickerSelect: function(date, inst) {
				if ($(this).hasClass('my_date_start')) {
					end.datetimepicker('option', 'minDate', start.datetimepicker('getDate'));
				}
				methods.updateHiddenField($(this), date);
			},
			onPickerClose: function(date, inst) {
				var sdate = start.datetimepicker('getDate');
				if (end.val() != '') {
					var edate = end.datetimepicker('getDate');
					if (sdate > edate) {
						end.datetimepicker('setDate', sdate);
						methods.updateHiddenField($('.my_date_end'), new Date(sdate).addHours(1));
					}
				} else {
					end.datetimepicker('setDate', new Date(sdate).addHours(1));
					methods.updateHiddenField($('.my_date_end'), new Date(sdate).addHours(1));
				}
			},
			pickerConfig: {
				showTimezone: true,
				timezoneList: [{
					value: 'ET',
					label: 'EST(GMT -0500)'
				}],
				timezone: 'ET',
				controlType: 'select',
				ampm: true,
				alwaysSetTime: true
			},
			updateHiddenField: function($el, date) {
				if ($el.hasClass('my_date_start')) {
					$('.date_start').val(new Date(date).toString('yyyy-MM-dd hh:mm:ss'));
				} else if ($el.hasClass('my_date_end')) {
					$('.date_end').val(new Date(date).toString('yyyy-MM-dd hh:mm:ss'));
				}
			},
			popupPosAndMatrix: function($el, e, extend) {
				return {
					eventPop: $el,
					popHeight: $el.height() + extend,
					left: e.clientX - $el.width() / 2,
					top: e.clientY,
					handlerHeight: $(e.target).height(),
					handlerTop: $(e.target).offset().top
				};
			},
			setEditModel: function(empty, event){
				var editor = $('.manage_event'),
					fields = ['calendar_id', 'title', 'date_start', 'date_end', 'is_all_day', 'is_repeat', 'location', 'lat', 'lng', 'description', 'color', 'availability', 'privacy'];
				if(empty) {
					$('input[type=text]', editor).val('');
					$('select', editor).prop('selectedIndex', 0);
					$('input[type=radio], input[type=checkbox]', editor).prop('checked', false);
				} else if(!empty && event) {
					editor.find('input.calendar_event_id').val(event.id);
					$.each(fields, function(i, name) {
						switch(name) {
							case 'date_start':
							case 'date_end':
								$('.my_' + name).datetimepicker('setDate', $.myCalendar().dateObject(event[name]));
								$('[name="data[CalendarEvent]['+ name +']"]').val(event[name]);
								break;
							case 'is_all_day':
							case 'is_repeat':
								editor.find('input[type="checkbox"][name="data[CalendarEvent]['+ name +']"]').prop('checked', event[name]).change();
								break;
							case 'availability':
							case 'privacy':
							case 'color':
								editor.find('input[type="radio"][name="user_'+ name +'"][value="'+ event[name].replace('#','') +'"]').prop('checked', true);
								editor.find('input[name="data[CalendarEvent]['+ name +']"]').val(event[name].replace('#',''));
								break;
							case 'lat':
							case 'lng':
								$('#event_map_'+name).val(event[name]);
								break;
							default:
								editor.find('[name="data[CalendarEvent]['+ name +']"]').val(event[name]);
								break;
						}
					});
				}
			},
			buildReqURI: function() {
				var uri = _ROOT + 'calendar_events/get_calendar_events/'+ user_id;
				if(users_ids.length>0) {
					uri = _ROOT + 'calendar_events/get_calendar_events/' + new Array(users_ids).join(',');
				}
				return uri;
			},
			reloadCalendarEvents: function() {
				$('#calendar').fullCalendar('removeEvents').fullCalendar('removeAllEventSources').fullCalendar('addEventSource', $.myCalendar().buildReqURI());
				$('#miniCalendar').fullCalendar('removeEvents').fullCalendar('removeAllEventSources').fullCalendar('addEventSource', $.myCalendar().buildReqURI());
				$('#calendar').fullCalendar('refetchEvents');
				$('#miniCalendar').fullCalendar('refetchEvents');
			}
		};
		return methods;
	}
	/*
	*  Calendar Activation
	*/
	var viewName = (agenda != 'undefined' && agenda.length) ? agenda : 'month';
	full_calendar_options={
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,agendaWeek,agendaDay'
		},
		editable: true,
		defaultView: viewName,
		eventSources:[
			$.myCalendar().buildReqURI()
		],
		dayClick: function(date, allDay, e, view) {
			var pop = $.myCalendar().popupPosAndMatrix($('.space_popup'), e, 20);
			$.myCalendar().togglePopup(function() {
				if (pop.top < pop.popHeight) {
					pop.top = pop.handlerTop + pop.handlerHeight / 4;
					$('.event_bottom_bar').css({
						display: 'none'
					});
					$('.event_top_bar').css({
						display: 'block'
					});
				} else {
					pop.top = (pop.handlerTop + pop.handlerHeight / 2) - pop.popHeight;
					$('.event_bottom_bar').css({
						display: 'block'
					});
					$('.event_top_bar').css({
						display: 'none'
					});
				}
				pop.eventPop.find('.calendar_date').empty().html($.myCalendar().displayDate(date)).end().find('input.date_start').val(new Date(date).toString('yyyy-MM-dd') + ' ' + new Date().toString("HH:mm:ss")).end().find('input.date_end').val(new Date(date).toString('yyyy-MM-dd 00:00:00')).end().css({
					'left': pop.left + 'px',
					'top': pop.top + 'px'
				}).slideDown(200);
			});
		},
		eventClick: function(event, e, view) {
			full_calendar_current_event=event;
			var pop = $.myCalendar().popupPosAndMatrix($('.event_display_popup'), e, 10);
			$.myCalendar().togglePopup(function() {
				pop.top = pop.top < pop.popHeight ? (pop.handlerTop + pop.handlerHeight + 5) : (pop.handlerTop - pop.popHeight);
				pop.eventPop.find('.event_title').html(event.title).end().find('.event_time').html($.myCalendar().displayDate(event.start, event.end)).end().find('.event_location').html(event.location).end().css({
					'left': pop.left + 'px',
					'top': pop.top + 'px'
				}).slideDown(200, $.myCalendar().setEditModel(false, event));
			});
		},
		eventResize: function(event, dayDelta, minuteDelta, revertFunc, jsEvent, ui, view) {
			var data = {
				'data[CalendarEvent][event_id]' : event.id,
				'data[CalendarEvent][date_end]' : new Date(event.end).toString('yyyy-MM-dd hh:mm:ss')
			};
			$.myCalendar().updateEvent(data);
		},
		eventDrop: function( event, dayDelta, minuteDelta, allDay, revertFunc, jsEvent, ui, view ) {
			if(!event.end) {
				end = new Date(event.start).clone();
			} else {
				end = new Date(event.end).clone();
			}
			var data = {
				'data[CalendarEvent][event_id]' : event.id,
				'data[CalendarEvent][date_start]' : new Date(event.start).clone().toString('yyyy-MM-dd hh:mm:ss'),
				'data[CalendarEvent][date_end]' : end.toString('yyyy-MM-dd hh:mm:ss')
			};
			$.myCalendar().updateEvent(data);
		},
		complete : function() {
			
		}
	};
	
	$('#calendar').fullCalendar(full_calendar_options);
	/*
	*  Small Calendar Activation
	*/
	
	mini_calendar_options={
		theme: false,
		header: {
			left: 'prev',
			center: 'title',
			right: 'next'
		},
		buttonText : {
			prev: '',
			next: ''
		},
		dayNamesShort : ['S', 'M', 'T', 'W', 'T', 'F', 'S'],
		editable:true,
		draggable:false,
		disableDragging:true,
		disableResizing:true,
		lazyFetching:false,
		allDaySlot:true,            
		defaultView:'month',
		events: {
			url: $.myCalendar().buildReqURI(),
			cache: true,
			lazyFetching:true,
			type: 'POST',
			error: function() {
				
			}
		},
		selectable: true,
		selectHelper: true,
		select: function(start, end, allDay) {
			$("#calendar").fullCalendar( 'gotoDate', start);
		},
		eventClick: function(calEvent, jsEvent, view) {
			$("#calendar").fullCalendar( 'gotoDate', calEvent.start);
		},
		eventMouseover: function(event, jsEvent, view) {
			if (view.name !== 'agendaDay') {
				$(jsEvent.target).attr('title', event.title);
			}
		},
		dayClick: function(date, allDay, e, view) {
			$(this).addClass('selected-date-cell');
			$.fancybox({
				href: '#eventPopulateModal',
				width: 560,
				height: 390,
				autoDimensions: false,
				onComplete : function(handler) {
					$('input.my_date_start').datetimepicker('setDate', date);
					$('input.my_date_end').datetimepicker('option', 'minDate', new Date(date).add(1).days());
					$('input.date_start').val(new Date(date).toString('yyyy-MM-dd') + ' ' + new Date().toString("HH:mm:ss"));
					$('input.date_end').val(new Date(date).add(1).days().toString('yyyy-MM-dd') + ' ' + new Date().toString("HH:mm:ss"));
				},
				onStart : function() {
					$('.event_create_popup')[0].reset();
				},
				onClearup : function() {
					$('.event_create_popup')[0].reset();
				},
				onClosed : function() {
					// Update Event List
					$.eventsList('#event_lists').generateList();
					// remove date cell selection
					$('.selected-date-cell').removeClass('selected-date-cell');
					// Redrew Mini Calendar
					$('#miniCalendar').fullCalendar('removeEvents').fullCalendar('removeAllEventSources').fullCalendar('addEventSource', $.myCalendar().buildReqURI());
					$('#miniCalendar').fullCalendar('refetchEvents');
				}
			});
		}
    };
	
	$('#miniCalendar').fullCalendar(mini_calendar_options);
	
	/*
	 *  Date & Timepicker Binding
	 */
	$('.my_date_start, .my_date_end').datetimepicker($.extend($.myCalendar().pickerConfig, {
		onSelect: $.myCalendar().onPickerSelect,
		onClose: $.myCalendar().onPickerClose
	}));
	/*
	 *  Event Add
	 */
	$('.calendar_event_submit').on({
		click: function(e) {
			e.preventDefault();
			$.myCalendar().addCalendarEvent();
		}
	});
	/*
	 *  Event Edit
	 */
	$('body').on({
		click: function(e) {
			e.preventDefault();
			$('.button, img', 'div.sdd_panel').toggle(20);
			$('img.loader_img').removeClass('me_hide');
			if( $('.calendar_event_id').val() ) {
				$.myCalendar().editCalendarEvent();
			} else {
				$.myCalendar().addCalendarEvent();
			}
		}
	}, '.full_event_edit');
	/*
	 *  Event Delete
	 */
	$('.calendar_event_delete').on({
		click: function() {
			var id = $('.calendar_event_id').val();
			$.myCalendar().deleteCalendarEvent(id);
		}
	});
	/*
	 *  Modal close
	 */
	$('.calender_cross').on('click',
	function() {
		$('.the_popup:visible').slideUp(200);
	});
	/*
	 *  Switch to Detail Event modal
	 */
	$('.calendar_event_edit').on('click',
	function(e) {
		e.preventDefault();
		var position = $('.the_popup:visible').offset(),
		left = position.left,
		top = position.top,
		title = $('.the_popup:visible input.event_title').val(),
		start = $('.the_popup:visible input.date_start').val();
		$.myCalendar().togglePopup(function() {
			$('input.my_date_start').datetimepicker('setDate', $.myCalendar().dateObject(start));
			$('input.my_date_end').datetimepicker('option', 'minDate', $('input.my_date_start').datetimepicker('getDate'));
			$.myCalendar().onPickerClose();
			$('.manage_event').find('input.event_title').val(title).end().find('input.date_start').val(start);
			/*.end().css({
				left: left + 'px',
				top: top + 'px'
			});*/
			$.fancybox({
				'href': '#eventPopulateModal', 
				width: 560,
				height: 440,
				autoDimensions: false,
				onComplete : function(handler) {
					//$('input.my_date_start').datetimepicker('setDate', $.myCalendar().dateObject(start));
					//$('input.my_date_end').datetimepicker('option', 'minDate', $.myCalendar().dateObject(start));
				}			
			});
			//.parent().removeClass('me_hide').slideDown(200);
			$('.manage_event input.calendar_event_id').val('');
		});
	});
	/*
	 *  Edit existing event with Detail Event Modal
	 */
	$('.calendar_edit').on('click',
	function(e) {
		e.preventDefault();
		var position = $('.the_popup:visible').offset(),
		left = position.left,
		top = position.top;
		$.myCalendar().togglePopup(function() {
			$('.manage_event').css({
				left: left + 'px',
				top: top + 'px'
			}).slideDown(200);
		});
	});
	/*
	 *  Close Detail Event Modal
	 */
	$('.event_exit').on('click',
	function() {
		$('.calendar_event_id').val('');
		$('.manage_event:visible').slideUp(200, $.myCalendar().setEditModel(true));
	});
	/*
	 * Set User's Event Color, Status and Privacy
	 */
	$('body').on({
		change: function() {
			$('input[name="data[CalendarEvent][' + this.name.replace('user_', '') + ']"]').val(this.value);
		}
	},'input[name="user_color"], input[name="user_availability"], input[name="user_privacy"]');
	/*
	 *	Draw event list
	 */
	$.eventsList('.calender_footer', null, 'big').generateList();
	
	/**
	*	Share Section within File cabinet
	*	Event/ Task Modal
	*/
	$.shareForFileCabTaskModal = function() {
		var _r = this;
		_r.found = false;
		_r.rowShared = 0;
		_r.validate_email = /^([a-z0-9._%+-]+)\@([a-z0-9-]+\.)+([a-z0-9]{2,4})$/i;
		this.init = function() {
			//_r.onAddShareButtonClick();
			_r.onSelectEventColor();
			return _r;
		};
		this.onSelectEventColor = function() {
			$('div.check_event_color').on('click', function() {
				var $s = $(this);
				$('.event_color_selected').removeClass('event_color_selected');
				$s.addClass('event_color_selected');
				$('input[type="radio"].user_color').prop('checked', false);
				$s.find('input[type="radio"]').prop('checked', true);
				$('input:hidden[name="data[CalendarEvent][color]"]').val($s.find('input[type="radio"]').attr('value'));
			});
		};
		this.init();
	};
	$.shareForFileCabTaskModal();
	
	/**
	*	Set nice scroll bar to 
	*	Event Modal Container
	*/
	$('ul.search_result_container').mCustomScrollbar();
	
	/*
	 * Map Location
	 */
	 /*
	$('body').on('click', '#event_map_picker', show_map_picker);
	$('#event_map_picker').mapPicker(function(){
		$('#lat').val($('#event_map_lat').val());
		$('#lng').val($('#event_map_lng').val());
		$('#addresspicker_map').val($('#event_map_location').val());
	},function(){
		$('#event_map_lat').val($('#lat').val());
		$('#event_map_lng').val($('#lng').val());
		$('#event_map_location').val($('#addresspicker_map').val());
	});*/
});

/*
function getLatLong(address, cb) {
	var geocoder = new google.maps.Geocoder();
	var result = "";
	geocoder.geocode( { 'address': address, 'region': 'uk' }, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			result['lat'] = results[0].geometry.location.Pa;
			result['lng'] = results[0].geometry.location.Qa;
		} else {
			result = "Unable to find address: " + status;
		}
		cb(result);
	});
}
*/

/**
*	Map Picker 
*/
/*
$.MapPicker = {
	gmarker : null,
	addresspickerMap : null,
	hide_map_picker : function() {
		$('#map_picker_container').hide();
		$('#map_picker_container .input input').val('');
	},
	show_map_picker : function() {
		$.MapPicker.before_show_map_callback();
		$.MapPicker.addresspickerMap = $( "#addresspicker_map" ).addresspicker({
			regionBias: null,
			elements: {
				map:      "#map",
				lat:      "#lat",
				lng:      "#lng",
				locality: '#locality',
				administrative_area_level_2: '#administrative_area_level_2',
				administrative_area_level_1: '#administrative_area_level_1',
				country:  '#country',
				postal_code: '#postal_code',
				type:    '#type' 
			}
		});
		$.MapPicker.gmarker = $.MapPicker.addresspickerMap.addresspicker( "marker");
		$.MapPicker.gmarker.setVisible(true);
		$.MapPicker.addresspickerMap.addresspicker( "updatePosition");
		$('#map_picker_container').show();
	},
	before_show_map_callback : function() {
		$('#lat').val($('#event_map_lat').val());
		$('#lng').val($('#event_map_lng').val());
		$('#addresspicker_map').val($('#event_map_location').val());
	},
	ok_btn_callback : function() {
		$('#event_map_lat').val($('#lat').val());
		$('#event_map_lng').val($('#lng').val());
		$('#event_map_location').val($('#addresspicker_map').val());
	},
	mapPickerOkEvent : function() {
		$('body').on('click', '#map_picker_ok_button', function(){
			$.MapPicker.ok_btn_callback();
			$.MapPicker.hide_map_picker();
		});
	},
	mapPickerCancelEvent : function() {
		$('body').on('click', '#map_picker_cancel_button', function(){
			$.MapPicker.hide_map_picker();
		});
	},
	bindMapPicker : function() {
		$('body').on('click', '#event_map_picker', $.MapPicker.show_map_picker);
	},
	init : function() {
		$.MapPicker.bindMapPicker();
		$.MapPicker.mapPickerOkEvent();
		$.MapPicker.mapPickerCancelEvent();
	}
};

$.MapPicker.init();
*/
/*
$.fn.mapPicker=function(before_show_map_callback, ok_btn_callback){
	
	var gmarker;
	var addresspickerMap;
	
	function hide_map_picker(){
		$('#map_picker_container').hide();
		$('#map_picker_container .input input').val('');
	}
	
	function show_map_picker(){
		
		before_show_map_callback();
		
		addresspickerMap = $( "#addresspicker_map" ).addresspicker({
			regionBias: null,
			elements: {
				map:      "#map",
				lat:      "#lat",
				lng:      "#lng",
				locality: '#locality',
				administrative_area_level_2: '#administrative_area_level_2',
				administrative_area_level_1: '#administrative_area_level_1',
				country:  '#country',
				postal_code: '#postal_code',
				type:    '#type' 
			}
		});
		
		
		gmarker = addresspickerMap.addresspicker( "marker");
		gmarker.setVisible(true);
		addresspickerMap.addresspicker( "updatePosition");
		$('#map_picker_container').show();
	}
	
	//$('body').on('click', this, show_map_picker);
	
	$('#map_picker_ok_button').click(function(){
		ok_btn_callback();
		$('#map_picker_cancel_button').click();
	});
	$('#map_picker_cancel_button').click(function(){
		hide_map_picker();
	});
	
}*/
$(function(){
	
	$('#calendar .fc-header-right').prepend('<span id="task_list_button" class="fc-button fc-button-agenda fc-state-default fc-corner-left"><span class="fc-button-inner"><span class="fc-button-content">Task List</span><span class="fc-button-effect"><span></span></span></span></span>');
         
	$('#my_calendar_button').click(function(){
		$('#users-calenders-list input[type="checkbox"]').removeAttr('checked').change();
	});

	$('#add_event_button').click(function(){
		$('.fc-day8').click();
	});
	
	$('[data-checkbox-id]').change(function(){
		var checkbox_id=$(this).attr('data-checkbox-id');
		var is_checked=$(this).is(':checked');
		var el_display=$('[data-for-checkbox-id="'+checkbox_id+'"]');
		if(is_checked){
			$(el_display).removeClass('checkbox').addClass('checkbox-checked');
		}else{
			$(el_display).removeClass('checkbox-checked').addClass('checkbox');
		}
	}).change();
	$('[data-for-checkbox-id]').click(function(){
		var checkbox_id=$(this).attr('data-for-checkbox-id');
		var el_hidden=$('[data-checkbox-id="'+checkbox_id+'"]');
		var is_checked=$(el_hidden).is(':checked');
		if(is_checked){
			$(el_hidden).removeAttr('checked');
		}else{
			$(el_hidden).attr('checked','checked');
		}
		$(el_hidden).change();
		return false;
	});
	$('input[data-cal-user-id]').change(function(){
		updatediv();
		var cals_users=$('input:checked[data-cal-user-id]');
		var users=[];
		for(var i=0;i<cals_users.length;i++){
			users.push($(cals_users[i]).attr('data-cal-user-id'));
		}
		users_ids=users;
		$.myCalendar().reloadCalendarEvents();
	});
});


 function updatediv() {         
     var allVals = [];
     $('#users-calenders-list :checked').each(function() {
       allVals.push($(this).val());
     });
     if(allVals=='')
     {
     	 var main=$('#main_user').val();
     	$('#calender_name').html('<h2>'+main+'</h2>')
     }
     else
     {
     $('#calender_name').html('<h2>'+allVals+'</h2>')
     }
     
  }
 $(function() {
   $('#users-calenders-list input').click(updatediv);
   updatediv();
 });
