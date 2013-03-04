;(function($) {
	/*
	*  Mini Calendar
	*/
	$.miniCalendar = function(settings) {
		var C = this,
		sel = $('#calender_itself > tbody'),
		options = {
			url: _ROOT + 'calendar_events/minicalendar_events.json', 
			type: 'POST',
			dataType: 'json',
			data : {
				'data[CalendarEvent][date_start]' : sel.find('td:first').data('mydate'),
				'data[CalendarEvent][date_end]' : sel.find('td:last').data('mydate')
			}
		};
		if(settings) {
			this.settings = $.extend(settings, options);
		} else {
			this.settings = $.extend({}, options);
		}
		var Fn = {
			init: function() {
				$('.members_event_list').on({
					mouseenter: function() {
						$('.cross', this).show();
					},
					mouseleave: function() {
						$('.cross:visible', this).hide();
					}
				}, '.each_member_event_count');
				
				$('.members_event_list').on({
					click: function(e) {
						e.stopImmediatePropagation();
						var target = $(this).parent('li').data('userid');
						if( target == $('input.auth_id').val()) {
							alert('You can\'t delete your own calendar.');
							return false;
						} else {
							Fn.deleteUserFromCalendar(target);
						}
					}
				}, '.each_member_event_count .cross:visible');
			},
			D: function(dateStr) {
				return new Date(dateStr);
			},
			dateDiff: function(start, end) {
				return new TimeSpan( new Date(end) - new Date(start) ).getDays();
			},
			getSQLDate: function(dateObj) {
				return dateObj.toString('yyyy-MM-dd');
			}, 
			setEvents: function(response) {
				sel.find('span.dot').remove();
				$('#calender_itself tbody td').each(function(i, el) {
					var date = $(el).data('mydate'),
						events = response.events.byDate[date];
					if(events) {
						$.each(events, function(i, data) {
							var color = !data.color ? '1F5175' : data.color,
								diff = Fn.dateDiff(data.start_date, data.end_date);
							for( var x = 0; x <= diff; x++ ) {
								var t = Fn.getSQLDate(Fn.D(data.start_date).add(x).days());
								sel.find('td[data-mydate="'+ t +'"]').append('<span class="dot" style="background-color:#'+ color +'"></span>');
							}
						});
					}
				});
			},
			userListing: function(response) {
				var user_listing = '';
				if(!response.events.length) return 0;
				$.each(response.events.byUser, function(i, user) {
					var name = user.User.first_name + ' ' + user.User.last_name.substr(0, 1).toUpperCase() + '.',
					color = user.User.color;
					user_listing += '<li class="each_member_event_count" data-userid="'+ user.User.id +'">' +
											'<span class="dot" style="background-color:#'+ color +'"> </span>' +
											'<a href="'+ _ROOT +'calendars/index/'+ user.User.id +'" class="member_name" data-userid="'+ user.User.id +'">'+ name +'</a>' + 
											'<span class="event_count">- <strong>'+ user[0].event_count +'</strong> events</span>' + 
											(user.User.id == response.auth_id ? '' : '<span class="delete_user cross">&nbsp;</span>')+
										'</li>';
				});
				$('ul.members_event_list').empty().html(user_listing);
			},
			drawCalendar: function() {
				$.ajax(C.settings).done(function(response) {
					if(response.status == 'y') {
						Fn.userListing(response);
						Fn.setEvents(response);
					}
				});
			},
			redraw : function() {
				Fn.drawCalendar();
			},
			deleteUserFromCalendar: function(target) {
				$.ajax({
					url : _ROOT + 'calendar_adds/delete',
					type: 'POST',
					data : {
						'data[CalendarAdd][user_add]' : target,
						'data[CalendarAdd][user_id]' : $('input.auth_id').val()
					},
					dataType: 'json'
				}).done(function(response) {
					if(response.status == 'y') {
						Fn.redraw();
					}
				});
			}
		};
		Fn.init();
		return Fn;
	};
})(jQuery);
