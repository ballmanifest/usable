$(function() {
	var drop = false,
		fileNames = ''
	var tree = $("#explorer").jstree({
		"dnd": {
			"drop_finish": function() {},
			"drag_check": function(data) {
				if (data.r.attr("id") == "phtml_1") {
					return false;
				}
				return {
					after: false,
					before: false,
					inside: true
				};
			},
			"drag_finish": function(data) {}
		},
		"plugins": ["themes", "html_data", "dnd", "ui"]
	});
	tree.bind("loaded.jstree",
	function(event, data) {
		tree.jstree("open_all");
	});
	tree.bind("refresh.jstree",
	function(event, data) {
		tree.jstree("open_all");
	});;
	$('.each_item').on({
		mouseenter: function() { 
			//$('.tips', this).slideDown(100).width($(this).width() - 20);
		},
		mouseleave: function() { 
			//$('.tips', this).slideUp(100);
		}
	});
	$('#directory_dd').on({
		click: function() {
			$('#directory_dd_options').slideToggle(300);
			$(this).find('.dd_pointer').toggleClass('dd_pointer_up');
		}
	});
	$('#directory_dd_options li').on({
		click: function() {
			var text = $('a', this).text(),
			value = $('input:hidden', this).val();
			$('.dd_select').text(text);
			$('input.selected_category').val(value);
			$('#directory_dd').click();
		}
	});
	$.fn.dropzone.uploadStarted = function(fileIndex, file) {};
	$.fn.dropzone.uploadFinished = function(fileIndex, file, duration) {};
	$.fn.dropzone.fileUploadProgressUpdated = function(fileIndex, file, newProgress) {};
	$.fn.dropzone.fileUploadSpeedUpdated = function(fileIndex, file, KBperSecond) {};
	$.fn.dropzone.newFilesDropped = function() {};
	$("#explorer").dropzone({
		url: "upload.php",
		printLogs: true,
		uploadRateRefreshTime: 500,
		numConcurrentUploads: 2
	});
	$('#explorer').droppable({
		tolerance: "pointer",
		accept: 'li.each_item',
		hoverClass: "cell-highlght",
		over: function(event, ui) {},
		drop: function(event, ui) {
			drop = true;
		}
	});
	$('#explorer').on('hover', 'li[id^=phtml_], li[id^=phtml_] > a',
	function(e) {
		if (drop) {
			drop = false;
			var dropTarget = e.target,
			folderName = $(dropTarget).closest('li').data('name');
			$('#message').html(fileNames + '>> are posted to >> ' + folderName);
		}
	});
	$('#image_holder').multiSelect({
		unselectOn: 'body',
        keepSelection: false
	});
	$('#image_holder li.each_item').draggable({
		helper: function(){
			fileNames = ''
			var selected = $('#image_holder li.each_item.ui-selected');
			if (selected.length === 0) {
			  selected = $(this);
			}
			selected.each(function() {
				fileNames += $(this).data('description') + ' | ';
			});
			var container = $('<div/>').attr('id', 'draggingContainer');
			container.append(selected.clone());
			return container; 
		},
		revert: 'invalid',
		opacity: 0.5,
		start: function(event, ui) {},
		stop: function() {},
		drag: function(event, ui) {	}
	});
	/* filecabinet roll-over */	
	$('.file_title_author').on({
		mouseenter: function() {
			$(this).next('.rolling_container').animate({
				top: '-41px'
			}, 200);
			$(this).closest('li.list_view_each_item').addClass('rollovered');
		}
	});
	
	$('#gallery_item_listview').on({
		mouseleave: function() {
			$('.rolling_container', this).animate({
				top: 0
			}, 200)
			$(this).removeClass('rollovered');
		}
	}, 'li.list_view_each_item.rollovered');
	/* view changer */
	$('.view_change_icon').on('click', function() {
		var target = $(this).data('target'),
			toHide = $(this).data('hide');
		$('#' + toHide).hide();
		$('#' + target).show();
		$(this).add('.current_view').toggleClass('current_view');
	});
	/* listview item selection */
	$('.list_item_selection').on('click', function() {
		$(this)
			.toggleClass('completed_task');
			
		$(this)
			.prev('input[type=checkbox][name^=file_selected]')
			.prop('checked', function(i, checked) { 
				return !checked; 
			});
	});
	$('.check_uncheck').on('click', function(e) {
		e.preventDefault();
		var isAllChecked = $(this).find('a').data('ischecked');
		$('.list_item_selection')[isAllChecked ? 'addClass' : 'removeClass']('completed_task');
		$('input[type=checkbox][name^=file_selected]').prop('checked', +isAllChecked);
	});
	/* favorite selection */
	$('.file_favorite').on('click', function() {
		$(this).toggleClass('favorite');
		$('input[type=checkbox]', this).prop('checked', $(this).hasClass('favorite'));
	});
});