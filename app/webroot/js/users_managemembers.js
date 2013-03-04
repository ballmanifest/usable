$(function(){
	$("a.edit, a.add_member").on("click", function(event){
		event.preventDefault();
		var _this = this;
		$("#member_frame").attr('src', $(_this).attr('href'));
	});
});