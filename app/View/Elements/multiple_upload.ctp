<?php 
	echo $this->Html->script('plupload/js/plupload.full.js'); 
	echo $this->Html->script('plupload/js/jquery.ui.plupload/jquery.ui.plupload.js'); 
	echo $this->Html->css('plupload/jquery.ui.plupload.css');
?>
<!--  Multiple Upload -->
<div class="hide">
	<div id="multipleUpload" title="multipleUpload" class="multipleUpload" style="width:600px;" >
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
							up.refresh();
						});
						uploader.refresh();
						uploader.start();
					});
				</script> 
			</div>
			<!-- TAB 2:	Advance Uploader -->
			<div id="tabs-2" style="height:303px;">	
			<style type="text/css">
				.upload_button_applet {
					background: none repeat scroll 0 0 #3099E5 !important;
					padding: 5px 10px;
					height: 20px;
					color: #fff !important;
					line-height: 20px;
					border-radius: 5px;
					margin-top: 6px;
					display: block;
					width: 60px;
					float: right;	
					text-align: center;
				}
			</style>
			<applet 
				code="com.elementit.JavaPowUpload.Manager"
				archive="/javapowupload/lib/JavaPowUpload.jar,/javapowupload/lib/commons-httpclient.jar"
				width="573"
				height="300"
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
				<param name="Common.ProgressArea.DownloadButton.Visible" value="true">
				<param name="Common.UploadButton.Visible" value="true">
				<param name="Upload.HttpUpload.FieldName.FilePath" value="SelectedPath_#COUNTER#">
				<param name="Upload.PersistFilesList.AskToRestore" value="false">
				
				<param name="Upload.HttpUpload.FormName" value="formupload">
				<param name="Upload.HttpUpload.AddFormValuesToPostFields" value="false">
				<param name="Upload.HttpUpload.AddFormValuesToHeaders" value="false">
				<param name="Upload.HttpUpload.AddFormValuesToQueryString" value="false">
				<param name="Upload.HttpUpload.AddFormValuesToPostFields" value="true">
				
				<!--<param name="Common.SkinLF.ThemepackURL" value="/javapowupload/lib/themepack.zip">-->
				  
				<!-- This text will be shown if applet not working or Java not installed-->
				<span>You should <b>enable applets</b> running at browser and to have the 
				<b>Java</b> (JRE) version &gt;= 1.5.<br />If applet is not displaying properly, 
				please check <a target="_blank" href="http://java.com/en/download/help/testvm.xml" 
				title="Check Java applets">additional configurations</a></span>
			</applet>

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
			</form>	
			<script type="text/javascript">
				JavaPowUpload = document.getElementById('JavaPowUpload');
				var JavaPowUpload_onServerResponse = function(status, response) {
					var currentFolderId = jQuery.cookie("currentFolderId");
					$.fancybox.close();
					location.reload(true);
				}

				var JavaPowUpload_onUploadStart = function(up) {
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
			</script>
			</div>  
		</div>         	
	</div>
</div>