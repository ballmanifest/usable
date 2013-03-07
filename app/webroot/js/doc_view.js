/**
*	This file posses all JS functionalities 
*	related to Comment, Share, Create Task for Document View page
*/

var $share_modal_fancybox = null,
	handlerToThisComment = null,
	handlerToThisShare = null,
	documentMoveActivate = false;
$(function() {
	var handlerToThisComment = false, parent = this, unique = true;
	
	$.viewPage = {
		init : function() {
			$.cookie('cotactModalLoad', 'n');
			/**
			*	Fancybox for comment
			*/
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
					$.viewPage.DocumentComments.autoScrollBottom();
					handlerToThisComment = handler;
				}
			});
			/**
			*	Fancy box Share Modal
			*/
			$('.fancyboxShareModal').fancybox({
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
			$.viewPage.DocumentComments.ready();
			$.ShareModal().init();
		},
		bindForm : {
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
						$.viewPage.bindForm.submit(form, $.viewPage.DocumentComments.request, $.viewPage.DocumentComments.response);
					}
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
				var currentCommentElement = $.viewPage.DocumentComments.commentCounterElement;
				var total = $(currentCommentElement).text();
				$(currentCommentElement).text(parseInt(total) + 1);
				$(currentCommentElement).parent().addClass("none-opacity").css("opacity", 100);
				$($form).find(".loader").hide();
				//$($form).before(responseText);
				$(".comment-wrapper").append(responseText).removeAttr("style");
				$.viewPage.DocumentComments.autoScrollBottom();
				$.fancybox.center();
				// show comment count
				var counter = $(handlerToThisComment).find('.dcounter');
				if(counter.length) {
					counter.text(function(i, oldText) {
						var count = parseInt(oldText, 10);
						return ++count;
					});
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
		}
	};
	$.viewPage.init();
});
