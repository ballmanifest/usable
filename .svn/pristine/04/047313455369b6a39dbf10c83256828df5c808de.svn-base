$.fn.multiSelect = function(o) {
	var defaults = {
		multiselect: true,
		selected: 'ui-selected',
		filter: ' > *',
		unselectOn: false,
		keepSelection: true,
		list: $(this).selector,
		e: null,
		element: null,
		start: false,
		stop: false,
		unselecting: false
	}
	return this.each(function(k, v) {
		var options = $.extend({},
		defaults, o || {});
		$(document).on('mousedown', options.list + options.filter,
		function(e) {
			if (e.which == 1) {
				if (options.handle != undefined && !$(e.target).is(options.handle)) { }
				options.e = e;
				options.element = $(this);
				multiSelect(options);
			}
			return true;
		});
		if (options.unselectOn) {
			$(document).on('mousedown', options.unselectOn,
			function(e) {
				if (!$(e.target).parents().is(options.list) && e.which != 3) {
					$(options.list + ' .' + options.selected).removeClass(options.selected);
					if (options.unselecting != false) {
						options.unselecting();
					}
				}
			});
		}
	});
}
function multiSelect(o) {
	var target = o.e.target;
	var element = o.element;
	var list = o.list;
	if ($(element).hasClass('ui-sortable-helper')) {
		return false;
	}
	if (o.start != false) {
		var start = o.start(o.e, $(element));
		if (start == false) {
			return false;
		}
	}
	if (o.e.shiftKey && o.multiselect) { 
		$(element).addClass(o.selected);
		first = $(o.list).find('.' + o.selected).first().index();
		last = $(o.list).find('.' + o.selected).last().index(); 
		if (last < first) {
			firstHolder = first;
			first = last;
			last = firstHolder;
		}
		if (first == -1 || last == -1) {
			return false;
		}
		$(o.list).find('.' + o.selected).removeClass(o.selected);
		var num = last - first;
		var x = first;
		for (i = 0; i <= num; i++) {
			$(list).find(o.filter).eq(x).addClass(o.selected);
			x++;
		}
	} else if ((o.e.ctrlKey || o.e.metaKey) && o.multiselect) { 
		if ($(element).hasClass(o.selected)) {
			$(element).removeClass(o.selected);
		} else {
			$(element).addClass(o.selected);
		}
	} else { 
		if (o.keepSelection && !$(element).hasClass(o.selected)) {
			$(list).find('.' + o.selected).removeClass(o.selected);
			$(element).addClass(o.selected);
		} else {
			$(list).find('.' + o.selected).removeClass(o.selected);
			$(element).addClass(o.selected);
		}
	}
	if (o.stop != false) {
		o.stop($(list).find('.' + o.selected), $(element));
	}
}