/**
*	Action on Folder(breadcrumb) row hover (AY)
*/
$(function() {
	var $share_modal_fancybox = null,
		handlerToThisComment = null,
		handlerToThisShare = null;
	$.FolderAction = {
		setMask: function() {
			var height = $('#main_container').height() + 10;
			$('body').append('<div class="my-overlay-info me_hide" style="opacity: 0; display: none;height: ' + height + 'px"></div>');
		},
		showMask: function() {
			if ($('.my-overlay-info').is('visible')) {
				$('.my-overlay-info').fadeOut(50,
				function() {
					$('.my-overlay-info').fadeIn(50);
				});
			} else $('.my-overlay-info').fadeIn(50);
		},
		hideMask: function() {
			if( $('#file_cabinet_first_visit_popup_container:visible').length ) { return false;}
			$.FolderAction.hideVisibleModal();
			$('.my-overlay-info:visible, div.manage_event:visible, div.folder-info').fadeOut(0);
			
		},
		hideVisibleModal: function() {
			if ($('.the_folder_active_modal:visible').length) {
				$('.the_folder_active_modal:visible').fadeOut(0);
			}
			return 1;
		},
		getTargetModal: function(el) {
			return $('#' + $(el).data('target'));
		},
		onMaskClick: function() {
			$('body').on('click', '.my-overlay-info:visible', $.FolderAction.hideMask);
		},
		onFolderViewClick: function() {},
		onFolderTaskClick: function() {},
		onFolderShareClick: function() {
			$('body').on('click', '.shareFolder',
			function() {
				$.FolderAction.hideVisibleModal();
				$.FolderAction.showMask();
				$('div.step2 form div.row:gt(1)').remove();
				$.FolderAction.getTargetModal(this).fadeIn(50);
			});
		},
		onShowFolderInfoClick: function() {
			$('body').on('click', 'a.showFolderInfo',
			function(e) {
				$.FolderAction.hideVisibleModal();
				$.FolderAction.showMask();
				$.FolderAction.getTargetModal(this).fadeIn(50);
			});
		},
		init: function() {
			$.FolderAction.onShowFolderInfoClick();
			$.FolderAction.onFolderShareClick();
			$.FolderAction.setMask();
			$.FolderAction.onMaskClick();
		}
	};
	$.FolderAction.init();
});
/**
*	Cabinet JS (CN)
*/
var Cabinet = {
	Tree: {
		drop: false,
		fileNames: "",
		/**
        * Get all necessary functions to be ready
        *
        * @param none
        * @return void
        */
		Ready: function() {
			this.Bind();
			this.OnEachItem();
			this.OnDirectoryDDClick();
			this.OnDirectoryDDOptionsClick();
			/* this.InitializeDropZone(); unused */
			/* this.OnExplorerEvent();    unused */
			this.OnImageHolder();
			/* this.onFileTitleAuthor();  unused */
			this.onGalleryListView();
			this.onViewChangeIcon();
			this.onListItemSelection();
			/* this.onCheckUncheck(); unused */
			/* this.onFileFavorite(); unused */
			/* this.onFileMore();     unused */
			setTimeout(function() {
				$('#explorer li:first a').click();
			},500);
		},
		/**
        * Initialize the JSTree Plugin
        *
        * @param none
        * @return void
        */
		InitializeTree: function() {
			var currentFolderId = jQuery.cookie("currentFolderId");
			$.jstree._themes = _ROOT + "js/themes/";
			var tree = $("#explorer").jstree({
				"dnd": {
					"drop_finish": function() {},
					"drag_check": function(data) {
						if (data.r.attr("id") == "phtml_1") {
							return false;
						}
						return {
							after: true,
							before: true,
							inside: true
						};
					},
					"drag_finish": function(data) {}
				},
				"plugins": ["themes", "html_data", "crrm", "cookies", "dnd", "ui", "json_data", "types", "hotkeys", "contextmenu"],
				"core": {
					"initially_open": ["#mechild_" + currentFolderId]
				},
				"ui": {
					"initially_select": ["#mechild_" + currentFolderId]
				}
			});
			return tree;
		},
		/**
        * Bind events to JSTree Plugin
        *
        * @param none
        * @return void
        */
		Bind: function() {
			var tree = this.InitializeTree();
			tree.bind("loaded.jstree",
			function(event, data) {
				var currentFolderId = jQuery.cookie("currentFolderId");
				var prevNode = $('a#mechild_' + currentFolderId);
				if(prevNode.is(':visible')) {
					//prevNode.trigger('click');
				} else {
					//$("#explorer ul li:first a").trigger("click");
				}
				tree.jstree("open_all");
			});
			tree.bind("refresh.jstree",
			function(event, data) {
				tree.jstree("open_all");
			});
			tree.bind("move_node.jstree",
			function(event, data) {
				var parentId = data.rslt.r.find("a").attr("paramid");
				var sourceId = data.rslt.o.find("a").attr("paramid");
				var action = data.rslt.r.attr("class").split(" ");
				Cabinet.Process.updateTreeOrder(parentId, sourceId, action[0]);
			});
			tree.bind("select_node.jstree",
			function(event, data) {
				if ($(".manageFolder").is(":visible") || $("span.loader").is(":visible") || $(".loader.upl").is(":visible")) {
					return false;
				}
				var sourceId = data.rslt.obj.find("a").attr("paramid");
				jQuery.cookie("currentFolderId", sourceId);
				Cabinet.Process.setPageHeaders(data);
				Cabinet.Process.onViewDocuments(sourceId, false);
			});
			tree.bind("create.jstree",
			function(e, data) {
				$.post(_ROOT + "cabinets/create", {
					"operation": "create_node",
					"folder_id": data.rslt.parent.attr("id").replace("node_", ""),
					"position": data.rslt.position,
					"title": data.rslt.name,
					"type": data.rslt.obj.attr("rel")
				},
				function(r) {
					var r = jQuery.parseJSON(r);
					if (r.status) {
						$(data.rslt.obj).attr("id", "phtml_" + r.id).attr('data-name', data.rslt.name);
						$(data.rslt.obj).find("a").attr("id", "mechild_" + r.id).attr('data-fullname', data.rslt.name);
						$(data.rslt.obj).find("a").attr("paramid", r.id);
						$.cookie('currentFolderId', r.id);
					} else {
						$.jstree.rollback(data.rlbk);
					}
					$('a#mechild_' + r.id).click();
				});
			}).bind("remove.jstree",
			function(e, data) {
				var message = "Are you sure you want to delete this folder?";
				var yesFunction = function(data) {
					data.rslt.obj.each(function() {
						$.ajax({
							async: false,
							type: 'POST',
							url: _ROOT + "cabinets/delete",
							data: {
								"operation": "remove_node",
								"folder_id": this.id.replace("node_", "")
							},
							success: function(r) {
								var r = jQuery.parseJSON(r);
								if (!r.status) {
									data.inst.refresh();
								}
							}
						});
					});
				}
				Cabinet.Process.Initialize.UIDialog("Delete", message, "confirm", yesFunction, data);
			}).bind("rename.jstree",
			function(e, data) {
				$.post(_ROOT + "cabinets/rename", {
					"operation": "rename_node",
					"folder_id": data.rslt.obj.attr("id").replace("node_", ""),
					"title": data.rslt.new_name
				},
				function(r) {
					var r = jQuery.parseJSON(r);
					if (!r.status) {
						$.jstree.rollback(data.rlbk);
					} else { 
						$(data.rslt.obj).attr("data-name", data.rslt.new_name);
						$(data.rslt.obj).find('a').attr('data-fullname', data.rslt.new_name).trigger('click');
					}
				});
			});/*.bind('hover_node.jstree', 
			function(node, data) {
				var node = data.rslt.obj,
				nodeName = node.data('name');
				node.find('a:first').addClass('no_ellipsis').html(function(i, html) {
					node.data('tempname', html);
					return '<ins class="jstree-icon">&nbsp;</ins>' + nodeName;
				});
			}).bind('dehover_node.jstree', 
			function(node, data) {
				var node = data.rslt.obj,
				nodeName = node.data('tempname');
				node.find('a:first').removeClass('no_ellipsis').html(function(i, html) {
					node.data('tempname', html);
					return nodeName;
				});
			});*/
		},
		OnEachItem: function() {
			$('.each_item').on({
				mouseenter: function() { //$('.tips', this).slideDown(100).width($(this).width() - 20);
				},
				mouseleave: function() { //$('.tips', this).slideUp(100);
				}
			});
		},
		OnDirectoryDDClick: function() {
			$('#directory_dd').on({
				click: function() {
					$('#directory_dd_options').slideToggle(300);
					$(this).find('.dd_pointer').toggleClass('dd_pointer_up');
				}
			});
		},
		OnDirectoryDDOptionsClick: function() {
			$('#directory_dd_options li').on({
				click: function() {
					var text = $('a', this).text(),
					value = $('input:hidden', this).val();
					$('.dd_selected').text(text);
					$('input.selected_category').val(value);
					$('#directory_dd').click();
				}
			});
		},
		InitializeDropZone: function() {
			$.fn.dropzone.uploadStarted = function(fileIndex, file) {};
			$.fn.dropzone.uploadFinished = function(fileIndex, file, duration) {};
			$.fn.dropzone.fileUploadProgressUpdated = function(fileIndex, file, newProgress) {};
			$.fn.dropzone.fileUploadSpeedUpdated = function(fileIndex, file, KBperSecond) {};
			$.fn.dropzone.newFilesDropped = function() {};
		},
		OnExplorerEvent: function() {
			var parent = this;
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
					parent.drop = true;
				}
			});
			$('#explorer').on('hover', 'li[id^=phtml_], li[id^=phtml_] > a',
			function(e) {
				if (parent.drop) {
					parent.drop = false;
					var dropTarget = e.target,
					folderName = $(dropTarget).closest('li').data('name');
					$('#message').html(parent.fileNames + '>> are posted to >> ' + folderName);
				}
			});
		},
		OnImageHolder: function() {
			var parent = this;
			$('#image_holder').multiSelect({
				unselectOn: 'body',
				keepSelection: false
			});
			$('#image_holder li.each_item').draggable({
				helper: function() {
					parent.fileNames = ''
					var selected = $('#image_holder li.each_item.ui-selected');
					if (selected.length === 0) {
						selected = $(this);
					}
					selected.each(function() {
						parent.fileNames += $(this).data('description') + ' | ';
					});
					var container = $('<div/>').attr('id', 'draggingContainer');
					container.append(selected.clone());
					return container;
				},
				revert: 'invalid',
				opacity: 0.5,
				start: function(event, ui) {},
				stop: function() {},
				drag: function(event, ui) {}
			});
		},
		onFileTitleAuthor: function() {
			$('.file_title_author').on({
				mouseenter: function() {
					/*
                    $(this).next('.rolling_container').animate({
                        top: '-41px'
                    }, 200);
                    $(this).closest('div.list_view_each_item').addClass('rollovered');
                    */
					$(this).prev(".list_item_selection").css("opacity", 100);
				},
				mouseleave: function() {
					var isOpacity = $(this).prev(".list_item_selection").is(".completed_task");
					if (!isOpacity) {
						$(this).prev(".list_item_selection").css("opacity", "0.28");
					}
				}
			});
			$('.list_item_selection').on({
				mouseenter: function() {
					$(this).css("opacity", 100);
				},
				mouseleave: function() {
					var isOpacity = $(this).is(".completed_task");
					if (!isOpacity) {
						$(this).css("opacity", "0.28");
					}
				}
			});
		},
		onGalleryListView: function() {
			$('#gallery_item_listview').on({
				mouseleave: function() {
					if ($('.popup_for_more_link:visible').length) {
						$('.popup_for_more_link:visible').slideUp(100);
					}
					$('div.list_view_each_item .rolling_container span', this).animate({
						top: 0
					},
					200);
					$(this).removeClass('rollovered');
				}
			},
			'div.list_view_each_item.rollovered');
		},
		onViewChangeIcon: function() {
			$('.view_change_icon').on('click',
			function() {
				var target = $(this).data('target'),
				toHide = $(this).data('hide');
				$('#' + toHide).hide();
				$('#' + target).show();
				$(this).add('.current_view').toggleClass('current_view');
				var type = $(this).attr("class");
				var splits = type.split(" ");
				var view = 1;
				if ($.trim(splits[0]) == "thumbnail_view") {
					view = 2;
				}
				jQuery.cookie("viewType", view);
			});
		},
		onListItemSelection: function() {
			$('.list_item_selection').live('click',
			function() {
				$(this).toggleClass('completed_task');
				$(this).prev('input[type=checkbox][name^=file_selected]').prop('checked',
				function(i, checked) {
					return ! checked;
				});
			});
		},
		onCheckUncheck: function() {
			$('.check_uncheck').live('click',
			function(e) {
				e.preventDefault();
				var isAllChecked = $(this).find('a').data('ischecked');
				$('.list_item_selection')[isAllChecked ? 'addClass': 'removeClass']('completed_task');
				$('input[type=checkbox][name^=file_selected]').prop('checked', +isAllChecked);
			});
		},
		onFileFavorite: function() {
			$('.file_favorite').on('click',
			function() {
				$(this).toggleClass('favorite');
				$('input[type=checkbox]', this).prop('checked', $(this).hasClass('favorite'));
			});
		},
		onFileMore: function() {
			$('.file_more').on({
				click: function(e) {
					e.preventDefault();
					var offset = $(this).offset(),
					x = offset.left - 45,
					y = offset.top + $(this).outerHeight() - 10;
					$('.popup_for_more_link').css({
						left: x,
						top: y
					})[$('.popup_for_more_link:visible').length ? 'slideUp': 'slideDown'](150);
				}
			});
		}
	},
	Process: {
		currentFolderId: 0,
		isMultipleUploadActive : 0,
		/**
     * Global error checking for ajax process
     *
     * @param none
     * @return void
     */
		AjaxSetup: function() {
			/*
			$.ajaxSetup({
				error: function(jqXHR, exception) {
					if (jqXHR.status === 0) {
						var message = 'Not connected. Verify Network.';
						Cabinet.Process.Initialize.UIDialog("Not Connected", message);
						//window.location.href = _ROOT + "users/dashboard";
					} else if (jqXHR.status == 404) {
						var message = 'Requested page not found. [404]';
						Cabinet.Process.Initialize.UIDialog("404 Not Found", message);
					} else if (jqXHR.status == 500) {
						var message = 'Internal Server Error [500].'; //Cabinet.Process.Initialize.UIDialog("500 Server Error", message);
						//window.location.href = _ROOT + "users/dashboard";
					} else if (exception === 'parsererror') {
						var message = 'Requested JSON parse failed.';
						Cabinet.Process.Initialize.UIDialog("JSON Failed", message);
					} else if (exception === 'timeout') {
						var message = 'Time out error.';
						Cabinet.Process.Initialize.UIDialog("Error", message);
						//window.location.href = _ROOT + "users/dashboard";
					} else if (exception === 'abort') {
						var message = 'Ajax request aborted.';
						Cabinet.Process.Initialize.UIDialog("Error Aborted", message);
					} else {
						var message = 'Uncaught Error:' + jqXHR.responseText; //Cabinet.Process.Initialize.UIDialog("Uncaught Error", message);
						//window.location.href = _ROOT + "users/dashboard";
					}
				}
			});
			*/
		},
		/**
     * Should put here all the initialization for jquery plugins
     *
     * @param none
     * @return void
     */
		Initialize: {
			FancyBoxUpload : function() {
				$('.fancyboxUpload').fancybox({
					width: 600,
					transitionIn : 'none',
					transitionOut: 'none',
					onStart : function(handler) {
						var type = $(handler).data('uploadtype');
						$('#tabs ul li:eq(0), #tabs ul li:eq(1)').show(0);
						if(type == 'documents') {
							$('#tabs ul li:eq(0)').show(0).find('a').click();
							$('#tabs ul li:eq(1)').hide(0);
						} else if(type == 'folders') {
							$('#tabs ul li:eq(0)').hide(0);
							$('#tabs ul li:eq(1)').show(0).find('a').click();
						}
					}
				});
			},
			FancyBox: function() {
				var parent = this;
				var unique = true;
				$('.fancyboxFolder').fancybox({
					transitionIn : 'none',
					transitionOut: 'none',
					onClosed: function() {
						Cabinet.Process.onManageFolderProcess.onFancyBoxClose();
						$("div.cover").hide();
						$(".manFolder").hide();
						var currentFolderId = $.cookie('currentFolderId');
						$('a#mechild_' + currentFolderId).click();
					},
					onStart: function() {
						if ($("div.cover").length <= 0) {
							var cv = $("<div class='cover'></div>");
							cv = $(cv).css("width", "243px").css("height", "740px").css("float", "left");
							$("#interactive").before($(cv));
						} else {
							$("div.cover").show();
						}
						$("#interactive").css({height: "450px", width: "450px"}).css("overflow", "hidden");
						$(".manFolder").show();
					},
					onComplete: function() {
						$("#interactive").css("height", "450px").css("overflow", "hidden");
					}
				});
				$('.fancyboxComment').fancybox({
					autoDimensions: true,
					width: 600,
					height: 400,
					titleShow : false,
					transitionIn : 'none',
					transitionOut: 'none',
					onComplete: function(handler) {
						var title = $.cookie("lastviewedFolderPath");
						$("span#ui-dialog-title-dialog").html(title + " - Comments");
						$("#CommentComment").blur();
						Cabinet.Process.DocumentComments.autoScrollBottom();
						if(unique == true){ 
							$("#CommentComment").val("Add new Comment: ").blur(); 
			            }
						handlerToThisComment = handler;
					}
				});
				$("body").on("click", "#CommentComment", function(event){ 
				    if(unique == true){ 
						$(this).val(''); 
						unique = false; 
				    } 
				}); 
				$('.fancyboxShowInfo').fancybox({
					autoDimensions: false,
					width: 600,
					transitionIn : 'none',
					transitionOut: 'none',
					onComplete: function() {
						$("#fancybox-wrap").css({
							'top': '0px',
							'bottom': 'auto'
						});
					}
				});
				$share_modal_fancybox = $('.fancyboxShareModal').fancybox({
					autoDimensions: false,
					width: 570,
					height: 395,
					transitionIn : 'none',
					transitionOut: 'none',
					titleShow: false,
					onStart : function() {
					
					},
					onComplete: function(handler) {
						handlerToThisShare = handler;
					}
				});
				Cabinet.Process.Initialize.FancyBoxUpload();
				$('.fancybox').fancybox();
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
					"z-index": 1100
				});
			},
			Tabs: function() {
				$("#tabs").tabs();
			}
		},
		/**
     * Calls all functions that initialize, holds live events and ready events
     *
     * @param none
     * @return void
     */
		Ready: function() {
			Cabinet.Process.onSelectParentFolder();
			Cabinet.Process.onDeleteDoc();
			Cabinet.Process.onEditInfo();
			Cabinet.Process.onRenameFile();
			Cabinet.Process.onShowInfo.ready();
			Cabinet.Process.onHoverOption();
			Cabinet.Process.onShareDoc.ready();
			Cabinet.Process.onManageFolder();
			Cabinet.Process.SearchDocument.ready();
			Cabinet.Process.AjaxSetup();
			Cabinet.Process.onClickImageOverlay();
			Cabinet.Process.DocumentComments.ready();
			Cabinet.Process.FolderComments.ready();
			Cabinet.Process.getDefaultSelectedNode();
			Cabinet.Process.Initialize.Tabs();
			Cabinet.Process.triggerSpaceClick();
			Cabinet.Process.OnListViewViewIconClick();
			Cabinet.Process.OnBreadCrumbHover();
			Cabinet.Process.onTaskIconClick();
			Cabinet.Process.onSubscriptionStarClick();
		},
		onSubscriptionStarClick : function() {
			$('body').on('click', '.folder_star, .file_star', function(e) {
				var subs = $(this).data('subscription'),
				data = {},
				el = this;
				e.preventDefault();
				$(el).off('click');
				if(subs.indexOf('document_') >= 0) {
					data = {
						'data[Subscription][document_id]' : subs.replace('document_', ''),
						'data[Subscription][user_id]' :  user_id
					};
				} else if(subs.indexOf('folder_') >= 0) {
					data = {
						'data[Subscription][folder_id]' : subs.replace('folder_', ''),
						'data[Subscription][user_id]' :  user_id
					};
				}
				$.post(_ROOT + 'subscriptions/subscribe', data, function(response) {
					if( response.status == 'y') {
						if(response.type == 'A') {
							$(el).find('img').attr('src', function(i, oldSrc) {
								return oldSrc.replace('star', 'star2');
							});
						} else {
							$(el).find('img').attr('src', function(i, oldSrc) {
								return oldSrc.replace('star2', 'star');
							})
						}
					}
					$(el).on('click');
				}, 'json');
			});
		},
		onTaskIconClick : function(e) {
			$('body').on('click', 'a.file_task, a.folder_task', function(e) {
				e.preventDefault();
				var type = $(this).data('type'),
				id = $(this).data('id'),
				itemname = $(this).parent().data('itemname'),
				target = this;
				$.fancybox({
					href: '#eventPopulateModal',
					width: 580,
					height:440,
					autoDimensions: false,
					transitionIn : 'none',
					transitionOut: 'none',
					onComplete : function(handler) {
						$('input.my_date_start').datetimepicker('setDate', new Date());
						$('input.my_date_end').datetimepicker('option', 'minDate', new Date());
						$('.calendar_event_folder_id, .calendar_event_document_id').val(0);
						$('.calendar_event_'+ type +'_id:hidden').val(id);
						$('span.document_or_folder_name').html(itemname);
						$('input:hidden.share_with_key').val(type + '_id');
						$('input:hidden.share_with_value').val(id);
						$('input.invite_to').attr('data-itemkey', type + '_id').attr('data-itemkeyval', id);
					},
					onStart : function() {
						$('.event_create_popup')[0].reset();
						$('.display_share_permissions').hide(0).find('table tbody').empty();
					},
					onClearup : function() {
						$('.event_create_popup')[0].reset();
					},
					onClosed : function() {
						var counter = $(target).prev('.counter');
						if(counter.length && $.trim(counter.text())) {
							var count = parseInt(counter.text(), 10);
							counter.text(++count);
						} else {
							$(target).before('<a class="counter">1</a>');
						}
					}
				});
			});
		},
		triggerSpaceClick: function() {
			var location = window.location.href,
			queryParts = location.split('#'),
			sourceId = 0,
			projectId = 0;
			Cabinet.Process.isMultipleUploadActive = queryParts[1] === 'multipleUpload' ? 1 : 0;
			if(queryParts[0].indexOf('?') >= 0) {
				var secondQuery = queryParts[0].split('?'),
				params = secondQuery[1].split('=')
				sourceId = params[1];
				projectId = params[0].replace('project_','');
				jQuery.cookie('projectId', projectId);
			}
			if(sourceId) {
				$("#directory_dd_options a[data-projfldr=" + sourceId + "]").trigger("click");
			} else {
				$("#directory_dd_options").find("li").first().find("a").trigger("click");
			}
			$("span.dd_pointer_up").trigger("click");
		},
		/**
     * Gets current selected tree node
     *
     * @param none
     * @return void
     */
		getDefaultSelectedNode: function() { //var defaults = $('#explorer').jstree('get_selected').attr('id');
			//$("#explorer").find("ul").find("li:first").find("a.parent").trigger("click");
		},
		/**
     * Sets document header titles and information
     *
     * @param Tree Object $data Object the holds the JsTree current events
     * @return void
     */
		setPageHeaders: function(data) {
			if (typeof(data) != "undefined") {
				var name = data.rslt.obj.attr("data-name");
				$(".directoryHeader").text(name);
			}
			var auth = $("span.auth_name").first().text();
			var totalActive = parseInt($("#image_holder").find("li.each_item").length) - 1;
			if (auth.length <= 0) {
				auth = "Updated By - No Records";
			} else {
				auth = "Updated By " + auth;
			}
			$(".activeFiles").text(totalActive);
			$(".directoryInfo").text(auth)
		},
		/**
     * Manage folders
     *
     * @param none
     * @return void
     */
		onManageFolder: function() {
			$(".manageFolder button").live("click",
			function() {
				switch (this.id) {
				case "add_default":
				case "add_folder":
					$("#explorer").jstree("create", null, "last", {
						"attr": {
							"rel": this.id.toString().replace("add_", "")
						}
					});
					break;
				case "text":
					break;
				default:
					$("#explorer").jstree(this.id);
					break;
				}
			});
		},
		onSelectParentFolder: function() {
			$('#directory_dd_container').find("li").find("a").live('click',
			function() {
				$("#explorer").html('<span class="loader"><img src="' + _ROOT + 'img/ajax-loader.gif" /> Loading...</span>');
				var parent = this;
				var folderId = $(this).next().val();
				$.get(_ROOT + 'cabinets/folders', {
					folderId: folderId
				},
				function(data) {
					$("#explorer").html(data);
					var currentFolderId = $.cookie('currentFolderId');
					/*
					if(currentFolderId) {
						$('a#mechild_' + currentFolderId).click();
						return 1;
					}*/
					/*
					if($("#explorer").find("ul").find("li:first").find("a.parent").length) {
						$("#explorer").find("ul").find("li:first").find("a.parent").trigger("click");
					} else {
						$("#explorer").find("ul").find("li:first").find("a").trigger("click");
					}*/
					Cabinet.Tree.Bind();
				});
				$("input.folderId").val('');
			});
		},
		updateTreeOrder: function(parentId, sourceId, action) {
			$.get(_ROOT + 'cabinets/orders', {
				parentId: parentId,
				sourceId: sourceId,
				action: action
			},
			function(data) {});
		},
		onClickImageOverlay: function() {
			$("div.image_overlay_with_title").live("click",
			function() {
				$(this).prev().find("a").trigger("click");
			});
		},
		onViewDocuments: function(sourceId, limit) {
		
			Cabinet.Process.currentFolderId = sourceId;
			var parent = this;
			if ($(".manageFolder").is(":visible") || $("span.loader").is(":visible")) {
				Cabinet.Process.onManageFolderProcess.prepareFolderId(sourceId);
				return true;
			}
			/*hide gallery to prevent mess*/
			$("#gallery_item_container").empty();
			if ($("#gallery_item_container").prev("span.loader").length <= 0) {
				$('<span class="loader"><img src="' + _ROOT + 'img/ajax-loader.gif" /> Loading...</span>').insertAfter("#view_changer_icons").show();
			} else {
				$("#gallery_item_container").prev("span.loader").show();
			}
			
			// Get Folder permission and Toggle Upload Button
			$.post(_ROOT  + 'cabinets/get_folder_permissoin', {'folderId' : sourceId}, function(r) {
				if(r.status == 'y') {
					if(r.is_writable) {
						$('.directory_upload_button').find('.fancyboxUpload.btn.btn-success').remove().end().prepend(r.upload_button);
						Cabinet.Process.Initialize.FancyBoxUpload();
					} else {
						$('.directory_upload_button').find('.fancyboxUpload.btn.btn-success').remove();
						return 0;
					}
				}
			}, 'json');
			
			// Retrieving Documents
			$.get(_ROOT + 'cabinets/documents', {
				sourceId: sourceId,
				limit : limit ? limit : '',
				guest : _controller == 'guests' ? '1' : 0,
				guest_id : $('input:hidden.guest_id').val() ? $('input:hidden.guest_id').val() : ''
			},
			function(data) {
				var dataHolder = $(data);
				var listView = dataHolder.html();
				var thumbView = dataHolder.html();
				$("#view_changer_icons").next("span").hide();
				$("#gallery_item_container").html(data);
				$("#gallery_item_container").show();
				Cabinet.Process.onUploadDocument.ready();
				Cabinet.Tree.onGalleryListView();
				Cabinet.Tree.onFileTitleAuthor();
				Cabinet.Process.Initialize.FancyBox();
				Cabinet.Process.onManageFolderProcess.ready();
				Cabinet.Process.setPageHeaders(); //Cabinet.Process.setDefaultView();
				Cabinet.Process.checkRecords(); // Cabinet.Process.onHoverOption();
				$("input.currentFolderId").val(sourceId);
				$('#gallery_item_listview').mCustomScrollbar({
					theme:"dark-thin"
				});
				jQuery.cookie("currentFolderId", sourceId);
				if (Cabinet.Process.isMultipleUploadActive) {
					$('.fancyboxUpload').trigger('click');
					jQuery.cookie("autoActiveMultiUpload", 1);
				}
			});
		},
		checkRecords: function() {
			var isVisible = $(".alert.not-found").is(":visible");
			var isVisibleListView = $("#gallery_item_listview").is(":visible");
			if (isVisible && isVisibleListView) { //$("span.thumbnail_view").trigger("click");
			}
		},
		setDefaultView: function() {
			var viewType = jQuery.cookie("viewType");
			$(".list_view").removeClass("current_view");
			$(".thumbnail_view").removeClass("current_view");
			if (viewType == 1) {
				$(".list_view").trigger("click");
				$(".list_view").add('.current_view');
			} else {
				$(".thumbnail_view").trigger("click");
				$(".thumbnail_view").add('.current_view');
			}
		},
		/**
     * Uploads document
     *
     * @param none
     * @return void
     */
		onUploadDocument: {
			ready: function() {
				var form = $(".formUpload");
				var file = "";
				var parent = this;
				$('.upload-file').change(function(e) {
					var val = $(this).val();
					file = val;
					if (val.length >= 1) {
						$(form).find(".loader").show();
						Form.submit(form, parent.request, parent.response);
					}
				});
				$(form).ajaxStart(function() {}).ajaxStop(function() {
					$(".loader").hide();
				});
			},
			request: function(formData, jqForm, options) {
				$(jqForm).find(".loader").show();
				if (!Cabinet.Process.onUploadDocument.validate()) {
					$(jqForm).find(".loader").hide();
					return false;
				}
			},
			response: function(responseText, statusText, xhr, $form) {
				if (responseText.length <= 30) {
					var json = $.parseJSON(responseText);
					if (typeof(json.error) != "undefined") {
						Cabinet.Process.Initialize.UIDialog("Error", json.error);
						$($form).find(".loader").hide();
						return false;
					}
				}
				var $response = $(responseText);
				var listView = $response.filter('li.listView');
				var thumbView = $response.filter('li.thumbView');
				$(".upload-holder").before(thumbView);
				$(listView).appendTo('#gallery_item_listview');
				$(".alert.not-found").hide();
				Cabinet.Tree.onFileTitleAuthor();
				Cabinet.Tree.onGalleryListView();
				Cabinet.Process.Initialize.FancyBox();
			},
			validate: function() {
				if (!/(\.(gif|jpg|jpeg|png))$/i.test($("#fileUpload").val())) {
					var message = "Invalid file type.Please attach a valid image file.";
					Cabinet.Process.Initialize.UIDialog("Invalid Document", message);
					return false;
				}
				return true;
			},
			javaUpload: function() {
				var Java;
				var FormObj = $("#formupload");
				var FormValues = '';
				Java = document.getElementById("JavaPowUpload");
				Java.setParam("Upload.HttpUpload.FormName", "formupload");
				Java.setParam("Upload.HttpUpload.AddFormValuesToPostFields", "false");
				Java.setParam("Upload.HttpUpload.AddFormValuesToHeaders", "false");
				Java.setParam("Upload.HttpUpload.AddFormValuesToQueryString", "false");
				Java.setParam("Upload.HttpUpload.AddFormValuesToPostFields", "true");

				Java.startUpload();
				return false;
			}
		},
		/**
     * Deletes folder's document
     *
     * @param none
     * @return void
     */
		onDeleteDoc: function() {
			$("a.deleteDoc").live("click",
			function() {
				var parent = this;
				var message = "Are you sure you want to delete this document?";
				var yesFunction = function(parent) {
					$(parent).parent().parent().parent().parent().css("background", "#FFFFE8");
					var paramId = $(parent).attr("paramId");
					$.post(_ROOT + 'cabinets/deleteDocument', {
						id: paramId,
						folderId: $.cookie('currentFolderId')
					},
					function(data) {
						$(parent).parent().parent().parent().parent().css("background", "#FFFFE8").fadeOut();
						$("#image_holder").find("li.t" + paramId).remove();
						$(".overlay-info").hide();
					});
				};
				Cabinet.Process.Initialize.UIDialog("Delete document", message, "confirm", yesFunction, this);
			});
		},
		onDeleteCheckedDoc: function() {
			$("a.deleteChecked").live("click",
			function() {
				/*this will delete all checked documents*/
			});
		},
		
	/**
     * Inline edit of document name and saving it
     *
     * @param none
     * @return void
     */
		onRenameFile: function() {
			$("body").on("click", "a.renameFile", function() {
				var paramId = $(this).attr("paramId");
				$("#" + paramId).fadeIn(50);
			});
		},
		onEditInfo: function() {
			$("body").on("click", ".list_view_each_item .saveInfo", 
			function() {
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
						$(".doc-edit").fadeOut();
						$(parent).next(".loader").hide();
						$(parent).show();
					});
				}
			});
		},
		onHoverOption: function() {
			/*
			var parent = this;
			$("body").on({
				mouseenter : function() {
					$(this).find('.rolling_container').show(0);
				},
				mouseleave : function() {
					if( !$('.doc-info:visible').length && !$('.doc-edit:visible').length) {
						$(this).find('.rolling_container').hide(0);
					}
				}
			}, "div.list_view_each_item");
			*/
		},
		OnBreadCrumbHover: function() {
			/*
			$("li.breadcrumbs").live("mouseenter",
			function() {
				$(this).find('.rolling_container').show();
			});
			$("li.breadcrumbs").live("mouseleave",
			function() {
				if ($(".doc-info").is(":visible") == false && $(".doc-share").is(":visible") == false && $(".doc-edit").is(":visible") == false) {
					var isOpacity = $(this).find(".list_item_selection").is(".completed_task");
					if (!isOpacity) {
						$(this).find('.rolling_container').hide();
					}
				}
			});*/
		},
		onHoverChangeOpacity: function(parent, opacity) {
			if (parent == "") {
				parent = "#gallery_item_listview";
			}
			$(parent).find("span.file_size").css("opacity", opacity);
			$(parent).find("span.file_comment").css("opacity", opacity);
			$(parent).find("span.file_task").css("opacity", opacity);
			$(parent).find("span.file_edit").css("opacity", opacity);
			$(parent).find("span.file_share").css("opacity", opacity);
			$(parent).find("span.file_info").css("opacity", opacity);
			$(parent).find("span.file_comment.none-opacity").css("opacity", 100);
		},
		/**
     * Shows info
     *
     * @param none
     * @return void
     */
		onShowInfo: {
			ready: function() {
				var parent = this;
				this.onOverlayClick();
				$("div.list_view_each_item a.showInfo").live("click",
				function() {
					var paramId = $(this).attr("paramId");
					var offset = $(this).offset();
					$("#" + paramId).css({
						top: offset.top - 180,
					}).show(0);
					parent.createOverlay();
					parent.highLight(this);
				})
			},
			highLight: function(elem) {
				$(elem).closest("li").css("z-index", "1002");
			},
			createOverlay: function() {
				if ($(".overlay-info").length <= 0) {
					var bHeight = $('#main_container').height() + 10;
					$('body').append("<div class='overlay-info' style='opacity: 0'></div>");
					$(".overlay-info").css("height", bHeight + "px");
				} else {
					$(".overlay-info").show();
				}
			},
			onOverlayClick: function() {
				$(".overlay-info").live("click",
				function() {
					$(this).hide(0);
					$(".doc-info, .doc-edit").fadeOut(0);
					$("div.list_view_each_item").css("z-index", "100");
				})
			}
		},
		/**
     * Shares Document
     *
     * @param none
     * @return void
     */
		onShareDoc: {
			ready: function() {
				var parent = this;
				parent.onOverlayClick();
				$("div.list_view_each_item a.shareDoc").live("click",
				function() {
					//$('div.step2 form div.row:gt(1)').remove();
					var paramId = $(this).attr("paramid");
					var offset = $(this).position();
					$(".doc-edit, .doc-info").fadeOut(0);
					$("#" + paramId).css({
						top: offset.top + 35,
						left: 0
					});
					/**
					*	Get all shared list
					*/
					var itemId = paramId.replace(/(share)|(folder_share)/,''),
						shareType = $(this).data('sharetype');
					$.get(_ROOT + 'shares/get_all_shares_listing/' + shareType + '/' + itemId + '/' + $(this).parent().closest('.rolling_container').closest('li').attr('searchdata'), function(response) {
						$("#" + paramId).find('div.step2 form.permission_form div.row.first').nextAll().remove();
						$("#" + paramId).find('div.step2 form.permission_form div.row.first').after(response);
					}, 'html');
					$("#" + paramId).fadeIn(50);
					Cabinet.Process.onShowInfo.createOverlay();
					Cabinet.Process.onShowInfo.highLight(this);
					$('html, body').animate({
						scrollTop: $("#" + paramId).offset().top - 110
					},
					500);
				})
			},
			onOverlayClick: function() {
				$(".overlay-info").live("click",
				function() {
					$(this).hide();
					$(".doc-share").fadeOut();
					$("div.list_view_each_item").css("z-index", "100"); //Cabinet.Process.onHoverChangeOpacity("", "0.1");
				})
			}
		},
		/**
     * Search document name
     *
     * @param none
     * @return void
     */
		SearchDocument: {
			ready: function() {			
				$("input.search_input_box").on("keyup",
				function() {
					var search = $.trim($(this).val().toUpperCase()),
					viewType = "#gallery_item_listview",
					target = 'div.list_view_each_item';
					if ($(".gallery_items_thumbnail_view").is(":visible")) {
						viewType = ".gallery_items_thumbnail_view";
						target = 'li.each_item';
					}
					if(!search.length) {
						$(target + ':hidden').show(0);
						return false;
					} else $(target).hide(0);
					$(target).filter(function() {
						return $(this).attr('searchdata').toUpperCase().indexOf(search) >= 0;
					}).show(0);
				});
			}
		},
		/**
     * Folder management
     *
     * @param none
     * @return void
     */
		onManageFolderProcess: {
			currentParentId: 0,
			currentName: "",
			ready: function() {
				var form = $(".formCreateFolder");
				var parent = this;
				this.onFancyBoxClose();
				this.onCreate();
			},
			onCreate: function() {
				$("a.add_folder").live("click",
				function() {
					$(".manageFolder").show();
				})
			},
			request: function(formData, jqForm, options) {
				$(".loader").show();
				var p = $("input.folderId").val();
				var n = $("input.inputName").val();
				if (n.length <= 0) {
					Cabinet.Process.Initialize.UIDialog("Invalid", "Please enter folder name");
					return false;
					$(".loader").hide();
				}
				if (p.length <= 0) {
					alert("Please select a folder from the left side.");
					return false;
					$(".loader").hide();
				}
				Cabinet.Process.onManageFolderProcess.currentParentId = p;
				Cabinet.Process.onManageFolderProcess.currentName = n;
			},
			response: function(responseText, statusText, xhr, $form) {
				var currentPid = Cabinet.Process.onManageFolderProcess.currentParentId;
				var currentNam = Cabinet.Process.onManageFolderProcess.currentName;
				var li = '';
				var ulExist = $("#mechild_" + currentPid).next("ul").length;
				if (ulExist) {
					$("#mechild_" + currentPid).next("ul").append(li);
				} else {
					$("#mechild_" + currentPid).parent("li").after(li);
				}
			},
			prepareFolderId: function(sourceId) {
				$("input.folderId").val(sourceId);
				this.currentParentId = sourceId;
			},
			onFancyBoxClose: function() {
				$("#interactive").parent("div").removeAttr("style");
				$(".manageFolder").hide();
				$("#interactive").removeAttr("style");
			}
		},
		/**
     * Document Comments
     *
     * @param none
     * @return void
     */
		DocumentComments: {
			commentCounterElement: "",
			ready: function() {
				var parent = this;
				$("textarea.textarea").live("keypress",
				function(e) {
					if (e.which == 13) {
						var form = $(".formComments");
						Form.submit(form, Cabinet.Process.DocumentComments.request, Cabinet.Process.DocumentComments.response);
					}
				});
				$("a.docComment").live("click",
				function(e) {
					$.cookie("lastviewedFolderPath", $(this).data('folder'));
					Cabinet.Process.DocumentComments.commentCounterElement = $(this).parent().find(".abs");
					return false;
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
				var currentCommentElement = Cabinet.Process.DocumentComments.commentCounterElement;
				var total = $(currentCommentElement).text();
				$(currentCommentElement).text(parseInt(total) + 1);
				$(currentCommentElement).parent().addClass("none-opacity").css("opacity", 100);
				$($form).find(".loader").hide();
				$($form).before(responseText);
				Cabinet.Process.DocumentComments.autoScrollBottom();
				$(".comment-wrapper").removeAttr("style");
				$.fancybox.center();
				// show comment count
				var counter = $(handlerToThisComment).prev('.counter');
				if(counter.length) {
					counter.text(function(i, oldText) {
						var count = parseInt(oldText, 10);
						return ++count;
					});
				} else {
					$(handlerToThisComment).prepend('<a class="counter">1</a>');
				}
				handlerToThisComment = null;
			},
			autoScrollBottom: function() {
				if (typeof $('.comment-wrapper')[0] != "undefined") {
					$(".comment-wrapper").animate({
						scrollTop: $(".comment-wrapper")[0].scrollHeight,
					},
					1800);
					$(".formComments").find(".textarea").focus();
				}
			}
		},
		/**
     * Folder Comments
     * will re-use the DocumentComments
     * @param none
     * @return void
     */
		FolderComments: {
			ready: function() {
				$('.comment.tool_link').live('click',
				function(e) {
					var link = _ROOT + "cabinets/comments/" + Cabinet.Process.currentFolderId;
					$(".showFolderComment").attr("href", link);
					$(".showFolderComment").trigger("click");
					return false;
				});
			}
		},
		/**
		*	Click event for List View Eye Icon
		*	for display image in FancyBox
		*/
		OnListViewViewIconClick: function() {
			$('body').on('click', '#gallery_item_listview a.fancyImageView',
			function() {
				var targetImage = $(this).data('relatedthumb');
				$('a.fancybox.' + targetImage).trigger('click');
			});
		}
	}
}
/**
  * Jquery Form Plugin binding
  *
  * @param none
  * @return void
  */
var Form = {
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
}
/* Deploying Cabinet Tree Functionality */
$(document).ready(function() {

	/**
	*	Display Hover Effect to popup
	*	on Uploader option for first time visitor 
	*	in file cabinet page
	*/
	if( $('#file_cabinet_first_visit_popup_container:visible').length ) {
		$('div.my-overlay-info').show(0).css({opacity: 0.5});
		$('div.place_holder_each').on({
			mouseenter : function() {
				$('.place_holder_each_overlay, a.fancyboxUpload', this).show(0);
			},
			mouseleave : function() {
				$('.place_holder_each_overlay, a.fancyboxUpload', this).hide(0);
			}
		});
	}
	
	//$.cookie('currentFolderId','');
	Cabinet.Tree.Ready();
	Cabinet.Process.Ready();
	$.ShareModal().init();
	$('.click_here, .upload_placeholder').on('click', function() {
		var user_id = $('input:hidden.auth_user_id').val();
		$('#file_cabinet_first_visit_popup_container').hide(0);
		$.get(_ROOT + 'users/file_cab_visited/' + user_id, function(response) {
			if(response.status == 'y') {
				$('#file_cabinet_first_visit_popup_container').remove();
				$('div.my-overlay-info').hide(0).css({opacity: 0});
			} else {
				$('#file_cabinet_first_visit_popup_container').show(0);
			}
		}, 'json');
	});
	
	// Warning Message for Guest
	$('.warningModal').fancybox({
		width: 450,
		height: 450,
		transitionIn : 'none',
		transitionOut: 'none',
		autoDimensions: false
	});
});