<?php
	echo $this->Html->scriptBlock('var user_id = 0; users_ids= [];');
	echo $this->Html->css( array('jstree.layout', 'ui-lightness/jquery-ui-1.8.23.custom', 'fancybox/jquery.fancybox.css', 'jquery.mCustomScrollbar.css', 'cabinet', 'guest')) ;
	echo $this->Html->script(array('jquery.hotkeys', 'jquery.cookie', 'jquery.client', 'utils', 'jquery.jstree','jquery.form', 'jquery-ui-1.8.23.custom.min', 'fancybox/jquery.fancybox', 'multiselect', '../multipowupload/Extra/swfobject.js',  'jquery.mCustomScrollbar.js', 'common', 'cabinet'));
?>
<input type="hidden" readonly="readonly" class="guest_id" value="<?php echo $guest['id'];?>">
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

<?php if(!empty($folders)): ?>
<div id="interactive" class="clearfix"> 
	<!--<h3 class="nav_section_title">Folder Shared</h3>-->
    <div id="directory_dd_n_explorer" class="me_left">    
        <!------------------------------------------------------ 
            Parent Directory Drop Down - start 
        ------------------------------------------------------->
        <div id="directory_dd_container">
            <div id="directory_dd" class="me_relative">
            <?php 
                echo $this->Html->link("Shared with me", "javascript:void(1)", array("class"=>"dd_selected"));
            ?>
            <span class="me_absolute dd_pointer dd_pointer_down"></span>
			</div>
        </div>
        <!------------------------------------------------------ 
            Parent Directory Drop Down - end 
        ------------------------------------------------------->
		
        <!------------------------------------------------------ 
            Tree View Explorer - start 
        ------------------------------------------------------->
     
        <div id="explorer">
            <span class="loader" style="display:block"><?php echo $this->Html->image("ajax-loader.gif");?> Loading...</span>
			<!-- TESTING------------->
		   <ul id="explorer_tree">
                <?php 
					foreach ($folders as $folder):
						$name = $folder['Folder']['name'];
						$id = $folder['Folder']['id'];
						$folder_type = $folder['Folder']['folder_type'];
				?>     
                <li class="<?php echo strtolower(str_replace(" ","",$name));?>" data-name="<?php echo $name;?>">
                    <?php 
                        echo $this->Html->link($name, "javascript:void(0)", array("class"=>"dd_option no_border", "data-projfldr" => $id, "folder_id" => $id, "paramid" => $id, "id" => "mechild_" . $id));
                        echo $this->Form->hidden($id, array("value"=>$id));
                    ?>
                </li>
              <?php endforeach; ?>
            </ul>
        </div>
     
		
        <!------------------------------------------------------ 
            Tree View Explorer - end 
        ------------------------------------------------------->
	</div>

	<div id="detail_view" class="me_left">
		<div id="detail_view_content_wrapper">

			<!------------------------------------------------------ 
				Header Info Section - start 
			------------------------------------------------------->
			<div id="info_n_tools">
				<div id="directory_avatar" class="me_left" style="width:60px;">
				  <div class="folder_img"></div>
				</div>
				<div id="directory_details" class="me_left" style="width:auto;line-height:38px;font-size:23px">
				  <div class="directory_heading directoryHeader">Loading...</div>
				  
				</div>
			</div>
			<!------------------------------------------------------ 
				Header Info Section - end 
			------------------------------------------------------->

			<!-- GALLERY -->
			<div id="gallery">
				<!-- View Changer -->
				<div id="view_changer_icons" class="me_relative">
					<div id="search_container" class="me_absolute">
						<div class="search_input">
							<input type="text" name="file_search" placeholder="Search" class="search_input_box" >
							<a href="javascript:void(1)" class="cancelSearch hide"><?php echo $this->Html->image('search_cancel.png');?></a>
							<span class="search_result_display hide"><b>0</b> results</span>
						</div>
					</div>
					<span class="list_view me_absolute view_change_icon current_view" data-target="gallery_item_listview" data-hide="image_holder" style="font-size:16px"><i class="icon-list"></i></span>
					<span class="thumbnail_view me_absolute view_change_icon" data-target="image_holder" data-hide="gallery_item_listview" style="font-size:16px"><i class="icon-th"></i></span>
				</div>
				<!-- Gallery Item container -->
				<div id="gallery_item_container" class="me_relative"><!-- Ajax--></div>
			</div>
		</div>
	</div>
</div>
<?php endif;?>
<!--
	Display document List 
-->
<?php if(!empty($documents)): ?>
<div class="shared_document_list_container">
	<div class="document_list me_left">
		<h3 class="document_section_title">Shared Documents</h3>
		<ul class="document_shared_listing">
			<?php 
				foreach($documents as $key => $doc):
					$document = $doc['Document'];
					$user = $doc['User'];
					$ext = $document['ext'];
					$this_document_shares = Set::extract('/Share[document_id='. $document['id'] .']', $shared_with_guest);
					
					$is_downloadable = (int)$this_document_shares[0]['Share']['is_downloadable'];
					$is_printable = (int)$this_document_shares[0]['Share']['is_printable'];
					$is_writable = (int)$this_document_shares[0]['Share']['is_writable'];
					$is_readonly = (int)$this_document_shares[0]['Share']['is_readonly'];
			?>
			<li class="list_view_each_item me_relative" searchdata="<?php echo $document["name"]?>">
				<div class="file_item_block">
					<input type="checkbox" name="file_selected[]" value="<?php echo $document["id"]?>" class="me_hide">
					<div class="list_item_selection">&nbsp;</div>
					<div class="file_title_author me_left">
						<span class="file_title ft<?php echo $document["id"];?>">
							<?php 
								$img = $this->Html->image('Transparent.png');
								if(in_array(strtolower($ext), array('jpg', 'jpeg', 'png', 'gif'))) {
									if(file_exists(WWW_ROOT . DS . 'img' . DS . 'imagecache' . DS . $document["file"])) {
										$img = $this->Html->image("?img=/imagecache/".$document["file"]."&height=16&cropratio=2:2", array());
									}
								} elseif(in_array(strtolower($ext), array('doc', 'docx', 'pdf', 'txt'))) {
									if(file_exists(WWW_ROOT . DS . 'img' . DS . $ext . ".png")) {
										$img = $this->Html->image($ext . ".png", array());
									}
								}
								echo $img;
							?> 	
							<span>
								<?php 
									$count = strlen($document["name"]);
									$name = $document["name"];
									if($count >=60) {
										$name = substr($document["name"],0,50) . "...";
									}
									echo $name; 
								?>
							</span>
							
						</span>
						<span class="updatedby"> via <?php echo ucwords($user["first_name"][0] . $user["last_name"][0])?></span>	
						<div class="hide me_hide">
							<?php echo $this->Form->input("name", array("label"=>false,"value"=>$document["name"],"class"=>"input-edit","div"=>false));?>
							<a href="javascript:void(0)" class="saveInfo" paramId="<?php echo $document["id"]?>">save</a>
							<?php echo $this->Html->image('ajax-loader.gif', array('class' => 'loader'));?>
						</div>		
					</div>
					<div class="rolling_container me_relative roll_over">
						<div class="roll_over_file_processing me_absolute">
							<span class="file_viewer" style="font-size:16px">
								<?php 
									if(in_array(strtolower($ext), array('jpg', 'jpeg', 'png', 'gif'))) {
										echo $this->Html->link('', 'javascript:void(0)', array('class' => 'icon-eye-open', 'style' => 'color: #0665a5', 'data-relatedthumb' => 'img_' . $document['id'] ));
									} else {
										echo $this->Html->link('',array('controller' => 'guests', 'action' => 'view', 'id' => $document['id']), array('target' => '_blank', 'class' => 'icon-eye-open', 'style' => 'color: #0665a5', 'data-relatedthumb' => $ext . '_' . $document['id'] ));
									}
								?>
							</span>
							<span class="file_comment" style="font-size:16px">
								<?php 
									if(!empty($guest_id)){
										echo $this->Html->link('', array('controller' => 'documents', 'action' => 'comments', $document["id"], 'guest' => $guest_id), array('class' => 'fancyboxComment docComment icon-comments', 'style' => 'color: #45c5f6'));
									} else {
										echo $this->Html->link('', array('controller' => 'documents', 'action' => 'comments', $document["id"]), array('class' => 'fancyboxComment docComment icon-comments', 'style' => 'color: #45c5f6'));
									}
								?>
							</span>
							<?php if($is_downloadable):?>
							<span class="file_download" style="font-size:16px">
								<?php 
									echo $this->Html->link('', array('controller' => 'guests', 'action' => 'download', $document["id"]), array('target'=> '_blank', 'class' => 'icon-download', 'style' => 'color: #45c5f6'));
								?>
							</span>
							<?php endif;?>
						</div>
					</div>
				</div>
			</li>
			<?php endforeach;?>
		</ul>
		<!-- Thumb view -->
		<ul id="image_holder" class="clearfix gallery_items_thumbnail_view" style="display: none">
			<?php 	
			foreach ($documents as $results):
				$document = $results["Document"];
				$user = $results["User"]; 
				$ext = $document['ext'];
				
				if(in_array(strtolower($ext), array('jpg', 'jpeg', 'png', 'gif'))) {
					if(file_exists(WWW_ROOT . DS . 'img' . DS . 'imagecache' . DS . $document["file"])) {
						$view = "../img/?img=/imagecache/".$document["file"]."&height=800";
						$doc_name = $document["name"];
						$image = $document["file"];
						$img =  $this->Html->image("?img=/imagecache/".$document["file"]."&height=173", array());
					} else {
						$view = "../img/notFound.png";
						$doc_name = 'N/A';
						$img =  $this->Html->image('notFound.png', array('width' => '600', 'height' => '600'));
					}
			?>
			<li class="each_item me_left me_relative t<?php echo $document["id"]?>" data-description="" searchdata="<?php echo $document["name"]?>">
				<div class="thumb-content">
					<?php 
						echo $this->Html->link($img, array('action' =>$view),array("class"=>"fancybox img_" . $document["id"],"escape"=>false,"rel"=>"gallery",)); 
					?>	
				</div>
				<div class="image_overlay_with_title me_absolute">
					<div class="image_overlay_title me_absolute abs">
					<strong><?php echo $doc_name ?></strong><br />
					Updated <?php echo $this->Time->timeAgoInWords($document["created"])?> by <span class="auth_name">
					<?php echo $user["first_name"] . " " . $user["last_name"]?></span>
					</div>
				</div>
				<input type="hidden" value="<?php echo $document["id"]?>" >
			</li>
			<?php 
				}
			?>
		<?php endforeach; ?>    
		</ul>
	</div>
</div>
<?php endif;?>

<!------------------------------------------------------ 
    Dialog
------------------------------------------------------->
<div id="dialog" title="Dialog" class="dialog hide">
    <p></p>
</div>
<script type="text/javascript">
	$(function() {
		$('.fancybox').fancybox();
	});
</script>