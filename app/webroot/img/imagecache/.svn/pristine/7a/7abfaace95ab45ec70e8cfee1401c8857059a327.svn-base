;(function($) {
	
	/*
	*	Events List
	*/
	
	$.eventsList = function(sel, event_settings, cal_type) {
		var E = this,
		list = sel ? $(sel) : $('#event_lists'),
		cal_type = cal_type,
		options = {
			url: _ROOT + 'calendar_events/get_events_list.json', 
			type: 'POST',
			dataType: 'json'
		};
		if(event_settings) {
			this.event_settings = $.extend(event_settings, options);
		} else {
			this.event_settings = $.extend({}, options);
		}
		var Fn = {
			displayDate: function(dateStr) {
				return new Date(dateStr).toString('M/dd/yy');
			},
			displayTime: function(dateStr) {
				return new Date(Date(dateStr)).toString('h:mm tt').replace(/[A-Z]/g, function(s) { return s.toLowerCase(); });
			},
			truncate: function(str) {
				return str.length > 100 ? str.substr(0, 100).concat('...') : str;
			},
			renderList: function(events) {
				var item = '',
					count = 0;
				$.each(events, function(date, collection) {
					if(cal_type == 'big') {
						item += '<div class="each_event_block me_absolute" style="left: '+ (235 * count)+'px">' + 
									'<div class="event_date" data-date="'+  date +'">'+  Fn.displayDate(date) +'</div>';
									$.each(collection, function(i, data) {
										item += '<div class="event_text">' + 
													'<div class="event_time" data-eventid="'+ data.id +'"><a href="#">'+ Fn.displayTime(data.date_start) +'</a> - </div>' + 
													'<p>'+ Fn.truncate(data.description ? data.description : data.title) +'</p>' + 
												'</div><br>';
									});
						item += 	'</div>';
						count++;
					} else {
						item += '<li class="each_list">'+
										'<div class="event_date clearfix">'+
											'<div class="the_date me_left" data-date="'+ date +'">'+ Fn.displayDate(date) +'</div>'+
											'<div class="gray_line me_left">&nbsp;</div>'+
										'</div>';
						item += 	'<div class="events_detail">';
						$.each(collection, function(i, data) {
							item += '<p class="event_description" data-eventid="'+ data.id +'"><span class="time"><strong>'+ Fn.displayTime(data.date_start) +' -</strong></span> '+ Fn.truncate(data.description ? data.description : data.title) +'</p>';
						});
						item += 	'</div>'+
									'</li>';
					}
				});
				if(item){
                     list.empty().append(item);
                }else{
                    list.empty().append('<span class="emptylist">No scheduled events</span>');
                }

			},
			generateList: function(cat) {
				$.ajax(E.event_settings).done(function(response) {
					if(response.status == 'y') {
						Fn.renderList(response.events);
					}
				});
			}
		};
		return Fn;
	};
})(jQuery);