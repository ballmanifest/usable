$(function() {
	$.linkToPopup = {
		noticeBoard: $('#notice_board'),
		link: $('#notice_board a'),
		init: function() {
			$.linkToPopup.link.on({
				click: $.linkToPopup.listener
			});
		},
		listener: function(e) {
			e.preventDefault();
			var linkInfo = this.href.replace(_ROOT,'').split('/');
			noticeType = $(this).closest('.notice_des').data('noticetype'),
			$.linkToPopup.generatePopup(noticeType, linkInfo);
		},
		generatePopup: function(noticeType, linkInfo) {
			switch(noticeType) {
				case 'add':
					break;
					
				case 'edit':
					break;
					
				case 'delete':
					break;
				
				case 'comment':
					if(linkInfo[0]=='tasks'){
						if(linkInfo[1]=='view'){
							FilocityTasksHelper.showTaskDialog(linkInfo[2]);
						}
					}
					break;
				
				case 'share':
					break;
					
				case 'view':
					
					break;
					
				case 'join':
					break;
			}
		}
	};
	$.linkToPopup.init();
});