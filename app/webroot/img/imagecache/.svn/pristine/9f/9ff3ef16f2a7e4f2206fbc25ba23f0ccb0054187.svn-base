$(function(){
	//photo uploader
	var uploader = new plupload.Uploader({
		runtimes : 'gears,html5,flash,silverlight',
		browse_button : 'filepick',
		container: 'account_photo_pane',
		max_file_size : '10mb',
		url : _ROOT+'users/upload_photo',
		flash_swf_url : _ROOT+'files/plupload.flash.swf',
		silverlight_xap_url : _ROOT+'files/plupload.silverlight.xap',
		filters : [
			{title : "Image files", extensions : "jpg,gif,png"}
		],
		resize : {width : 1024, height : 768, quality : 90},
		multi_selection:false,
		multipart:true
	});

	uploader.bind('Init', function(up, params) {
		
	});

	uploader.init();

	uploader.bind('FilesAdded', function(up, files) {
		//$('#new_member_profile_photo_container').append('<div id="member_photo_upload_indicator" style="position:absolute;top:1px;left:1px;width:100%;height:100%;line-height:166px;text-align:center;background:#fff;"><span>0%</span></div>');
		uploader.start();
	});

	uploader.bind('UploadProgress', function(up, file) {
		//$('#' + file.id + " b").html(file.percent + "%");
		$('#member_photo_upload_indicator span').html(file.percent + "%");
	});

	uploader.bind('Error', function(up, err) {
		/*
		$('#filelist').append("<div>Error: " + err.code +
			", Message: " + err.message +
			(err.file ? ", File: " + err.file.name : "") +
			"</div>"
		);
		*/
		//alert(err.message);
		up.refresh(); // Reposition Flash/Silverlight
	});

	uploader.bind('FileUploaded', function(up, file, serv) {
		$('#member_photo_upload_indicator span').html("100%");
		serv['response']=$.parseJSON(serv['response']);
		if(serv['response']['error']==undefined){
			//error
		}
		var user_id=serv['response']['user_id'];
		var filename=serv['response']['filename'];
		$('#new_member_temp_photo_name').val(filename);
		$('#new_member_profile_photo').attr('src',_ROOT+'image/temp/'+filename+'/small.jpg');
		$('#member_photo_upload_indicator').remove();
	});
});