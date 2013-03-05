<?php 
echo $this->Html->script('plupload/js/plupload.full.js'); 
echo $this->Html->script('plupload/js/jquery.ui.plupload/jquery.ui.plupload.js'); 
echo $this->Html->css('plupload/jquery.ui.plupload.css');
?>

<!------------------------------------------------------ 
    Multiple Upload 
------------------------------------------------------->
<div class="hide">
    <div id="multipleUpload" title="multipleUpload" class="multipleUpload" style="width:630px" >
        <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix" style="padding:5px;margin-bottom:5px">
            <span class="ui-dialog-title" id="ui-dialog-title-dialog">
                <?php   echo __("Multiple Upload"); ?>
            </span>
             <a href="#" class="ui-dialog-titlebar-close ui-corner-all" role="button"></a>
        </div>
       	  
		<!-- TABS CONTAINERS -->
		<div id="tabs">
		
			<!-- TABS -->
            <ul>
                <li><a href="#tabs-1">Basic Upload </a></li>
                <li><a href="#tabs-2">Advanced Upload (Java Upload)</a></li>
            </ul>
			
			<!-- TAB 1:	Basic Uploader -->
			<div id="tabs-1">
				<form id="uploadform" action="<?php echo $this->Html->url(array('controller' => 'cabinets', 'action' => 'saveUploadedImage'));?>" method="post" enctype="multipart/form-data"> 
					<div id="uploader">
						<p>You browser doesn't have Flash, Silverlight, Gears, BrowserPlus or HTML5 support.</p>
					</div> 
					<?php	
						foreach ($params as $p => $v):
							echo $this->Form->hidden("{$p}", array("value"=>"{$v}", "name"=>"{$p}"));
						endforeach;
						$session = $this->Session->read('Auth.User.id');
						echo $this->Form->hidden("userId", array("value"=>$session, "name"=>"user_id"));
						echo $this->Form->hidden("currentFolderId", array("class"=>"currentFolderId", "name"=>"folder_id"));
						echo $this->Form->hidden("sessionId", array("class"=>"sessionId", "value"=>session_id(), "name"=>"session_id"));
						echo $this->Form->hidden("folderStructure", array("class"=>"folderStructure", "name"=>"folders"));
					?>
				</form>       
				<script type="text/javascript">
					$(function() { 
						$("#uploader").plupload({  
							runtimes : 'gears,flash,silverlight,browserplus,html5',
							url : _ROOT +'cabinets/uploader',
							max_file_size : '1000mb',
							//chunk_size : '1mb',
							unique_names : true,
							multipart: true,
							urlstream_upload:true,
							resize : {width : 320, height : 240, quality : 90},
							//autostart : true,
							/*
							filters : [
								{title : "Image files", extensions : "jpg,gif,png"},
								{title : "Zip files", extensions : "zip,tar,gz"},
								{title: "Document files", extensions: "pdf"},
								{title : "Words files", extensions : "doc,docx"},
								{title: "Excel Files", extensions: "xls,xslx,csv"}
							],*/
							flash_swf_url : "<?php echo $this->Html->url('/js/plupload/js/plupload.flash.swf');?>",
							silverlight_xap_url : "<?php echo $this->Html->url('/js/plupload/js/plupload.silverlight.xap'); ?>"
						});
						
						var uploader = $('#uploader').plupload('getUploader');
						uploader.bind('BeforeUpload', function(up, files) {
							if (files.lenggth == 0) {
								$.fancybox({
									href: '#fancyAlertBox',
									width: 300,
									height: 150,
									autoDimensions: false,
									onComplete : function() {
										$('#fancyAlertBox .alert_message').html('You must at least upload one file..');
									}
								});
							}
						});
						uploader.bind('FilesAdded', function(up, files) {
							for(var i=0; i <= files.length; i++) {
								if(files[i] && files[i] != undefined) {
									var name = files[i].name,
									found = name.match(/(\.exe)/g);
									if(found && found.length) {
										uploader.removeFile(files[i]);
									}
								}
							}
						});
						uploader.bind('StateChanged', function() {
							if (uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {
								$('#uploadform').submit();
							}
						});
						uploader.bind('Error', function(up, err) {
							$.fancybox({
								href: '#fancyAlertBox',
								width: 300,
								height: 150,
								autoDimensions: false,
								onComplete : function() {
									$('#fancyAlertBox .alert_message').html("Message: " + err.message + (err.file ? ", File: " + err.file.name : ""));
								},
								onClosed : function() {
									up.refresh();
								}
							});
						});
						uploader.refresh();
						uploader.start();
					});
				</script> 
			</div>
			
			<!-- TAB 2:	Advance Uploader -->
			<div id="tabs-2">
				<form id="formupload" name="formupload" method="post">
					<?php	
					foreach ($params as $p => $v):
						echo $this->Form->hidden("{$p}", array("value"=>"{$v}", "name"=>"{$p}"));
					endforeach;
					$session = $this->Session->read('Auth.User.id');
					echo $this->Form->hidden("userId", array("value"=>$session, "name"=>"user_id"));
					echo $this->Form->hidden("currentFolderId", array("class"=>"currentFolderId", "name"=>"folder_id"));
					echo $this->Form->hidden("sessionId", array("class"=>"sessionId", "value"=>session_id(), "name"=>"session_id"));
					echo $this->Form->hidden("folderStructure", array("class"=>"folderStructure", "name"=>"folders"));
					?>
					<applet 
						code="com.elementit.JavaPowUpload.Manager"
						archive="/javapowupload/lib/JavaPowUpload.jar,/javapowupload/lib/skinlf.jar,/javapowupload/lib/commons-httpclient.jar"
						width="560"
						height="200"
						name="data[file]"
						id="JavaPowUpload"
						mayscript="true"
						alt=""
						VIEWASTEXT>

						<!-- Java Plug-In Options -->
						<param name="progressbar" value="true">
						<param name="boxmessage" value="Loading Applet ...">

						<param name="Common.SerialNumber" value="00728632746176146256524262640246927771110209">
						<!--Enable upload mode -->
						<param name="Common.UploadMode" value="true">
						<!--Enable JavaPowUpload events and functions to use in JavaScript -->
						<param name="Common.UseLiveConnect" value="true"> 
						<!--Set url to file processing script -->
						<param name="Upload.UploadUrl" value="<?php echo $this->Html->url('/cabinets/multipleUpload', true);?>">
						<!--Hide download button. So, user can start uplod process only by pressing html button-->
						<param name="Common.ProgressArea.DownloadButton.Visible" value="false"> 
						<param name="Common.UploadButton.Visible" value="false"> 
						<param name="Upload.HttpUpload.FieldName.FilePath" value="SelectedPath_#COUNTER#">

						<param name="Common.SkinLF.ThemepackURL" value="/javapowupload/lib/themepack.zip">  
						  
						<!-- This text will be shown if applet not working or Java not installed-->
						<span>You should <b>enable applets</b> running at browser and to have the 
						<b>Java</b> (JRE) version &gt;= 1.5.<br />If applet is not displaying properly, 
						please check <a target="_blank" href="http://java.com/en/download/help/testvm.xml" 
						title="Check Java applets">additional configurations</a></span>
					</applet>
					<button name="submitbtn" type="submit" value="Upload"> <!-- onClick="return Cabinet.Process.onUploadDocument.javaUpload();"  -->
						<?php echo $this->Html->image("up_alt.png", array());?> Upload
					</button>
				</form>
			</div>  
		</div>         	
    </div>
</div>  

<script type="text/javascript">
	/* Script For Flash and Java Upload */
	var totalFiles = 0;
	var incrementUpload = 0;
	var isDirectoryStructure = false;
	function serverResponse() {
		++incrementUpload; 
		//console.log(totalFiles);
		if (incrementUpload >= totalFiles) {
			totalFiles = 0;
			incrementUpload = 0;
			$.fancybox.close();
			var currentFolderId = jQuery.cookie("currentFolderId");
			if (currentFolderId) {
				$("a#mechild_" + currentFolderId).trigger("click");
			} else {
				location.reload();
			}
		}
	}
	function MultiPowUpload_onServerResponse(li) {
		serverResponse();
	}
	function MultiPowUpload_onListChange() {
		totalFiles = MultiPowUpload.getFilesCount();
	}
	function JavaPowUpload_onServerResponse(status, response) {
		$.fancybox.close();
		var currentFolderId = jQuery.cookie("currentFolderId");
		if (currentFolderId) {
			var t = $("#directory_dd").find("a").text();
			var r = t.replace(" ", "");
			var f = r.toLowerCase();
			if (isDirectoryStructure) {
				$("li." + f).find("a").trigger("click");
				$(".dd_selected").trigger("click");
			} else {
				$("a#mechild_" + currentFolderId).trigger("click");
			}
		} else {
			location.reload();
		}
	}
	function JavaPowUpload_onUploadStart() {
		totalFiles = JavaPowUpload.getProgressInfo().getSelectedFilesCount();
		var fs = new Array();
		for (i = 0; i < totalFiles; ++i) {
			var fullPath = JavaPowUpload.getFiles().get(i).getPath();
			if (fullPath.length >= 3) {
				isDirectoryStructure = true;
			}
			fs[i] = fullPath;
		}
		var joined = fs.join();
		$("input.folderStructure").val(joined);
	}
	function JavaPowUpload_onUploadFinish() {
		
	}
	function MultiPowUpload_onComplete() {
		$('#fancybox-overlay').click();
		var projectId = parseInt(jQuery.cookie('projectId'), 10),
		autoActiveMultiUpload = parseInt(jQuery.cookie('autoActiveMultiUpload'), 10);
		
		if( autoActiveMultiUpload && projectId > 0) {
			jQuery.cookie('autoActiveMultiUpload', 0);
			jQuery.cookie('projectId', 0);
			location.href = _ROOT + 'projects/view/' + projectId;
			return false;
		} else {
			setTimeout(function() {
				jQuery.cookie('autoActiveMultiUpload', 0);
				jQuery.cookie('projectId', 0);
				var loc = location.href.split('#');
				location.href = loc[0];
				//var currentFolderId = $.cookie('currentFolderId');
				//$("a#mechild_" + currentFolderId).trigger("click");
			},50);
		}
	}
</script>
