<?php
	echo $this->Html->scriptBlock('var user_id = ' . $this->Session->read('Auth.User.id') . '; users_ids= [];');
	echo $this->Html->css( array('ui-lightness/jquery-ui-1.8.23.custom', 'monthcalendar', 'timepicker', 'jquery.mCustomScrollbar.css', 'calendar') );
	echo $this->Html->css( array('jstree.layout', 'fancybox/jquery.fancybox.css', 'cabinet', 'versions')) ;
	echo $this->Html->script( array('monthcalendar', 'jquery-ui-1.8.23.custom.min', 'timepicker', 'date', 'eventsList', 'jquery.mousewheel.min', 'jquery.mCustomScrollbar.js'), array('inline' => false) );
	echo $this->Html->script(array('jquery.hotkeys', 'jquery.cookie', 'jquery.client', 'utils', 'jquery.jstree','jquery.form', 'fancybox/jquery.fancybox', 'multiselect', '../multipowupload/Extra/swfobject.js', 'share_modal', 'common', 'calendar', 'cabinet'), array('inline' => false));
	$role = intval($this->Session->read('Auth.User.role'));
?>
<input type="hidden" readonly="readonly" value="<?php echo $this->Session->read('Auth.User.id');?>" class="auth_user_id">

<!-- Add Tesk section {Add Calendar event} -->
<?php echo $this->element('calendar_event_edit', array('allEmails' => $allEmails)); ?>

<!-- popup link on More... hover -->
<div class="popup_for_more_link me_absolute">
	<div class="upper_arrow me_absolute">&nbsp;</div>
	<div class="popup_for_more_link_wrapper me_absolute">
		<span>File Delete</span>
		<span>Tasks</span>
		<span>History</span>
		<span class="more_link_delete">Delete</span>
	</div>
</div>

<div class="cabinet_panels_container clearfix">

	<!-- Left Navigation Panel -->
	<div id="interactive">
		
		<!-- Popup Apper when user try to Create New Folder -->
		<div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix manFolder hide" style="padding:5px;">
			<span class="ui-dialog-title" id="ui-dialog-title-dialog"><?php echo __("Manage Folder");?></span>
			<a href="#" class="ui-dialog-titlebar-close ui-corner-all" role="button"></a>
		</div>	
		<div class="manage-folder manageFolder"> 
			<h3>Manage Folders</h3>
			<button type="button" id="add_folder"><?php echo $this->Html->image("folder_create.png");?> New Folder</button>
			<button type="button" id="rename"><?php echo $this->Html->image("folder_rename.png");?> Rename Folder</button>
			<button type="button" id="remove"><?php echo $this->Html->image("folder_delete.png");?> Delete Folder</button> 
		</div>
	
		<!-- Left Panel Content -->
		<div class="bodyPanLeft1"></div>
		<div class="bodyPanLeft2">
			<div id="directory_dd_n_explorer">    
				<!-- Parent Directory Drop Down -->
				<div id="directory_dd_container">
					<div id="directory_dd" class="me_relative">
					<?php 
						$temp = $folders['spaces'];
						$keys = array_keys($temp);
						$values = array_values($temp);
						echo $this->Form->hidden("", array("value"=>$keys[0], "class"=>"selected_category"));
						echo $this->Html->link($values[0], "javascript:void(1)", array("class"=>"dd_selected"));
					?>
					<span class="me_absolute dd_pointer dd_pointer_down"></span>
					</div>
					<ul id="directory_dd_options">
					  <?php foreach ($folders['spaces'] as $id => $name):?>     
						<li class="<?php echo strtolower(str_replace(" ","",$name));?>">
							<?php 
								echo $this->Html->link($name, "javascript:void(0)", array("class"=>"dd_option no_border", "data-projfldr" => $id));
								echo $this->Form->hidden($id, array("value"=>$id));
							?>
						</li>
					  <?php endforeach; ?>
					  <li><hr/></li>
					  <?php foreach($folders['projects'] as $pid => $pname) :?>
						<li class="<?php echo strtolower(str_replace(" ","",$pname));?>">
							<?php 
								echo $this->Html->link($pname, "javascript:void(0)", array("class"=>"dd_option no_border", "data-projfldr" => $pid));
								echo $this->Form->hidden($pid, array("value"=>$pid));
							?>
						</li>
					  <?php endforeach;?>
				   </ul> 
				</div>
				
				<!-- Create New Folder Link -->
				<div class="add_item_to_selected_folder">
					<?php echo $this->Html->link($this->Html->image('filocity_new_btn.jpg'), '#interactive', array('escape' => false, 'class' => 'add_folder tool_link fancyboxFolder')); ?>
				</div>
				
				<!-- Tree View Explorer -->
				<div id="explorer">
					<span class="loader" style="display:block"><?php echo $this->Html->image("ajax-loader.gif");?> Loading...</span>
					<ul id="explorer_tree"></ul>
				</div>
			</div>
		</div>
		<div class="bodyPanLeft3"></div>
	</div>
    
	<!-- Right Panel Detail View -->    
	<div id="detail_view" class="bodyPanRight">
		<div class="bodyPanRight1"></div>
		
		<div id="detail_view_content_wrapper" class="bodyPanRight2">
			<!-- Header Info Section -->
			<div id="info_n_tools" class="company_space_pan clearfix">
				<!-- Big Folder Icon with Folder Name -->
				<div id="directory_details">
					<div class="directory_heading directoryHeader">Loading...</div>
				</div>
				
				<!-- Upload Icon and PDF Tools -->
				<div class="company_space_pan2">
					<p><?php echo date('l, F dS, Y: h:ia');?></p>
					<ul class="company_space_pan3 clearfix">
						<li><a class="share tool_link fancyboxUpload upload" href="#multipleUpload" style="margin-left:90px;">Upload</a></li>
						<!--<li><a class="pdf_tool" href="javascript::void(0)">PDF Tools</a></li>-->
					</ul>
				</div>	
			</div>
			
			<!-- View Changer and Search Panel -->
			<div id="view_changer_icons" class="searchPan clearfix me_relative">
				<div id="search_container" class="me_absolute">
					<div class="search_input">
						<input type="text" name="file_search" placeholder="Search" class="search_input_box inputField" >
					</div>
				</div>
				<ul class="images_view">
					<li><span class="list_view me_absolute view_change_icon current_view" data-target="gallery_item_listview" data-hide="image_holder"><?php echo $this->Html->image('list_view.jpg');?></span></li>
					<li><span class="thumbnail_view me_absolute view_change_icon" data-target="image_holder" data-hide="gallery_item_listview"><?php echo $this->Html->image('thumbnails.jpg');?></span></li>
				</ul>
			</div>
					
			<!-- GALLERY -->
			<div id="gallery">
				<div id="gallery_item_container" class="me_relative"><!-- Ajax--></div>
			</div>
		</div>
		<div class="bodyPanRight3"></div>
	</div>
</div>

<!-- Dialog -->
<div id="dialog" title="Dialog" class="dialog hide"><p></p></div>

<!-- Multiple Uploader Container -->
<?php echo $this->element('multiple_upload', array('params' => $params));?>  

<?php
	/* minified JS and put them into 1 generated file for faster and optimized page loading*/
	//$this->loadHelper("Jquery");
	//echo $this->Jquery->link();
?>

<!-- File Cabinet Fist visit popup -->
<?php if(!$this->Session->read('Auth.User.cabinet_visited') && intval($this->Session->read('Auth.User.role')) != 2):?>
<div id="file_cabinet_first_visit_popup_container" class="me_absolute">
	<div id="file_cabinet_first_visit_popup_wrapper">
		<p class="first_visit_header"><strong>Welcome to Filocity!</strong> To Begin, start uploading your documents.</p>
		<div class="first_visit_placeholders me_relative" style="padding-left: 45px">
			<div class="place_holder_each me_absolute">
				<a href="#multipleUpload" class="fancyboxUpload click_here me_hide" style="left:85px" data-uploadtype="documents"><?php echo $this->Html->image('welcome-to-gray-click-here.png');?></a>
				<div class="place_holder_each_overlay me_absolute me_hide" style="left:2px;top:4px"></div>
				<a class="upload_your_files_placeholder me_left" style="margin-right: 20px"><?php echo $this->Html->image('filecabpop_btn2.png');?></a>
			</div>
			<div class="place_holder_each folder_uploader me_absolute">
				<a href="#multipleUpload" class="fancyboxUpload click_here me_hide" style="left:85px" data-uploadtype="folders"><?php echo $this->Html->image('welcome-to-gray-click-here.png');?></a>
				<div class="place_holder_each_overlay me_absolute me_hide" style="left:2px;top:4px"></div>
				<a class="upload_your_folder_placeholder upload_placeholder"><?php echo $this->Html->image('filecabpop_btn1.png', array('style' => 'margin-top:4px'));?></a>
			</div>
		</div>
	</div>
</div>
<?php endif;?>
