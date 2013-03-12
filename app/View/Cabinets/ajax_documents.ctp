<?php
	$this->loadHelper("Time");
	$this->loadHelper("Number");
	$this->loadHelper("Cabinet");
	$count = 0;
	$auth_id = $this->Session->read('Auth.User.id');
?>

<!-- List view -->
<div id="gallery_item_listview" style="padding-bottom: 30px">
<?php 
	$folderId = "";

	foreach($allFolders as $myfolder):
		$folder = $myfolder['Folder'];
		$folderId = $folder['id'];
		$folder_comments = $myfolder["Comment"];
		$folder_shares= $myfolder["Share"];
		$folderCalendarEvent = $myfolder['CalendarEvent'];
		$folder_subscription = !empty($myfolder['Subscription']) ? 1 : 0;
		$folderComments = count($folder_comments);
		$folderCalendarEventCount = count($folderCalendarEvent);
		$folderShares = count(Set::extract('/Share[user_id='. $auth_id .']', $myfolder));
		$user = $myfolder['User'];
		
		if(($role == 2 || $role == 0) && !empty($folder_shares)) {
			/**
			*	If user is Member / Guest
			* 	then set permission for "My Share" folder
			*/
			$is_downloadable = $folder_shares[0]['is_downloadable'];
			$is_readonly = $folder_shares[0]['is_readonly'];
			$is_writable = $folder_shares[0]['is_writable'];
			$is_printable = $folder_shares[0]['is_printable'];
		} else {
			$is_downloadable = $is_readonly = $is_writable = $is_printable = 1;
		}
?>

	<div class="breadcrumbs sharing_projects_pan me_relative">
		<div class="folder_item_block clearfix">
			
			<!-- Show File Name and other tools -->
			<div class="file_name_header">
				<h2>
					<span> 
						<?php
							$root = $this->Cabinet->createBreadCrumb($treeFolders, $folder["name"]);
							echo $root;
						?>
					</span>
					<?php 
						if($role == 2 && $folder_name != $root){
							echo " / ".  $folder_name;
						} elseif($role != 2) {
							echo " / ".  $folder["name"]; 
						}
					?>
					<?php if($role == 2 && $folder_type != 'share'):?>
					<span class="updatedby">
						shared by
						<strong><?php echo $user["first_name"][0] . $user["last_name"][0];?></strong>
						<?php echo ' | ' . $this->Time->format('F jS, Y', $folder_shares[0]['created']) ;?>
					</span>	
					<?php endif;?>
				</h2>
				<ul>
					<li><a href="javascript::void(0)"><?php echo $this->Html->image('share.png');?></a></li>
					<li><a href="javascript::void(0)">Active 0- Pending 0</a></li>
					<li><a href="javascript::void(0)" class="me_hide"><?php echo $this->Html->image('pending.png');?></a></li>
				</ul>
			</div>
			
			<div class="file_title_pane">
			
				<!-- Author and created date for folder -->
				<ul class="title">
					<li><?php echo $user['first_name'] . ' ' . $user['last_name'];?></li> 
					<li><?php echo date('m/d/Y', strtotime($folder['created']));?></li>
				</ul>
				
				<!-- action icons for folder -->
				<ul class="icons">
					<li>
						<!-- Comment Icon -->
						<?php if($is_readonly || $is_downloadable) { ?>
							<?php if($folderComments > 0): ?><a class="counter"><?php echo $folderComments;?></a><?php endif;?>
							<?php echo $this->Html->link($this->Html->image('comments.png'), array('controller' => 'folders', 'action' => 'comments', $folder["id"]), array('escape' => false, 'title' => 'Comments', 'class' => 'fancyboxComment docComment', 'data-folder' => $this->Cabinet->createBreadCrumb($treeFolders, $folder["name"])." / ".  $folder["name"]));?>
						<?php } else { 
							echo $this->Html->link($this->Html->image('comments.png'), 'javascript::void(0)', array('escape' => false));
						} ?>
					</li>
					<li>
						<!-- Share Icon -->
						<?php if($is_readonly && $is_downloadable && $is_printable & $is_writable) {?>
							<?php if($folderShares > 0): ?><a class="counter"><?php echo $folderShares;?></a> <?php endif;?>
							<a title="Share" class="fancyboxShareModal" href="<?php echo $this->Html->url(array('controller' => 'shares', 'action' => 'share_modal', 'type' => 'folder', 'id' => $folder['id']), true)?>"  paramId="<?php echo $folder["id"]?>" data-sharetype="folder"><?php echo $this->Html->image('share2.png');?></a>
						<?php } else { 
							echo $this->Html->link($this->Html->image('share2.png'), 'javascript::void(0)', array('escape' => false));
						} ?>
					</li>
					<li>
						<!-- Task Icon -->
						<?php if($role != 2) { ?>
							<?php if($folderCalendarEventCount > 0) : ?><a class="counter"><?php echo $folderCalendarEventCount;?></a> <?php endif;?>
							<a class="folder_task" href="javascript:void(0)" data-type="folder" data-id="<?php echo $folder["id"];?>" data-itemname="<?php echo $folder["name"];?>" data-calevent="folder_<?php echo $folder["id"];?>" title="Task"><?php echo $this->Html->image('calendar.png');?></a>
						<?php } else { 
							echo $this->Html->link($this->Html->image('calendar.png'), 'javascript::void(0)', array('escape' => false));
						} ?>
					</li>
					<li>
						<!-- Subscription Icon -->
						<?php if($role != 2) { 
								$iname = 'star.png';
								$class = '';
								if($folder_subscription) {
									$class = 'should_visible';
									$iname= 'star2.png';
								}
						?>
							<a class="folder_star subscription_star <?php echo $class;?>" data-subscription="folder_<?php echo $folder['id'];?>" title="Subscribe" href="javascript:void(1)">
								<?php 
									echo $this->Html->image($iname);
								?>
							</a>
						<?php } else { 
							echo $this->Html->link($this->Html->image('star.png'), 'javascript::void(0)', array('escape' => false));
						} ?>
					</li>
					<li>
						<!-- More Icons -->
						<?php if($role != 2) { ?>
							<a class="showFolderInfo" title="More" href="javascript:void(1)" data-target="folder_info<?php echo $folder["id"]?>"><?php echo $this->Html->image('list_icon.png'); ?></a>
						<?php } else {
							echo $this->Html->link($this->Html->image('list_icon.png'), 'javascript::void(0)', array('escape' => false));
						} ?>
					</li>
				</ul>
			</div>
		</div>
		<!-- More Icons -->
		<div id="folder_info<?php echo $folder["id"]?>" class="folder-info doc-info hide me_hide corner shadow">
			<ul>
				<!-- Remane Icon -->
				<?php if($role == 1) { ?>
				<li> <a href="javascript:void(0)" class="renameFolder" paramId="edit<?php echo $folder["id"]?>"><i class="icon-pencil"></i><?php echo __("Rename");?></a></li>
				<?php } else { ?>
				<li class="inactive_icon"> <a href="javascript:void(0)"><i class="icon-pencil"></i><?php echo __("Rename");?></a></li>
				<?php } ?>
				
				<!-- Delete Icon -->
				<?php if($role != 2) { ?>
				<li> <a href="javascript:void(0)" class="delete deleteDoc" paramId="<?php echo $folder["id"]?>"><i class="icon-trash"></i><?php echo __("Delete");?></a> </li>
				<?php } else { ?>
				<li class="inactive_icon"><a href="javascript:void(0)"><i class="icon-trash"></i><?php echo __("Delete");?></a></li>
				<?php } ?>
			</ul>
		</div>
		<!-- Edit Section-->
		<div id="folder_edit<?php echo $folder["id"]?>" class="doc-edit hide me_hide corner the_folder_active_modal">
			<ul>
				<li> 	
					<?php echo $this->Form->input("name", array("label"=>false,"value"=>$folder["name"],"class"=>"input-edit","div"=>false,"maxlength"=>26));?> 
					<a href="javascript:void(0)" class="saveInfo" paramId="<?php echo $folder["id"]?>">save</a> 
					<?php echo $this->Html->image('ajax-loader.gif', array('class' => 'loader me_hide', 'style' => 'margin-top:11px; float:right'));?>
				</li>
			</ul>
		</div>
	</div> 

	<!-- Document List start herer -->
	<?php
		$count = count($myfolder['Document']);
		$height = $count == 0 ? '30px' : 'auto';
	?>
	<div class="docs_listing" style="height:<?php echo $height;?>;">
<?php
	if($count == 0) :
?>
	<div class="alert not-found">
		 No Documents Found
	</div>
<?php
	else:
	foreach ($myfolder['Document'] as $results):
	 	$document = $results;
		$user = $results["User"];
		$doc_shares = $results["Share"];
		$doc_comments = $results["Comment"];		
		$documentCalendarEvent = $results['CalendarEvent'];
		$ext = $document['ext'];
		$document_subscription = !empty($results['Subscription']) ? 1 : 0;		
		$size = $this->Number->toReadableSize($document["size"]);
		$documentComments  = count($doc_comments);
		$documentShares = count(Set::extract('/Share[user_id='. $auth_id .']', $results));
		$documentCalendarEventCount = count($documentCalendarEvent);
		$folderId = $document["folder_id"];
		$the_share = array();
		$the_share = Set::extract('/Share[user2_id='. $auth_id .']', $results);
		$is_exists = count($the_share) > 0 ? 1 : 0;
		if(($role == 2 || $role == 0) && $is_exists){
			$is_downloadable = $the_share[0]['Share']['is_downloadable'];
			$is_readonly = $the_share[0]['Share']['is_readonly'];
			$is_writable = $the_share[0]['Share']['is_writable'];
			$is_printable = $the_share[0]['Share']['is_printable'];
		} else {
			$is_downloadable = $is_readonly =$is_writable = $is_printable = 1;
		}
?>	

		<div class="list_view_each_item sharing_pan clearfix" searchdata="<?php echo $document["name"]?>" data-info='{"id":<?php echo $document['id']?>,"type":"document","parent_id":<?php echo $folderId?>}'>
		
			<!-- Docuement Row Left Panel -->
			<div class="sharing_pan1">
				<div class="check_box"><input type="checkbox" name="file_selected[]" value="<?php echo $document["id"]?>" class="checkbox2"></div>
				<div class="image">
					<?php 
						$ext = strtolower($ext);
						$img = $this->Html->image('Transparent.png');
						if(file_exists(WWW_ROOT . 'img' . DS . 'icons' . DS . $ext . '.png')) {
							$img = $this->Html->image('icons/' . $ext . ".png", array());
						} else {
							$img = $this->Html->image('default-image-icon.png');
						}
						echo $img;
					?> 	
				</div>
				<div class="box_data">
				  <h3 data-extension="<?php echo $ext;?>">
					<?php 
						$count = strlen($document["name"]);
						$name = $document["name"];
						if($count >=60) {
							$name = substr($document["name"],0,50) . "...";
						}
						echo $name; 
					?>
				  </h3>
				  <p class="me_hide">This file name is <?php echo $document['name'] . '.' . $ext; ?>.</p>
				  <ul class="sharing1 clearfix">
					  <li>
						<?php
							if($document['version'] ==1 ) {
								echo 'version ('. $document['version'] . ')'; 
							} else {
								echo $this->Html->link( 'version ('. $document['version'] . ')', array('controller' => 'cabinets', 'action'=> 'versions', $document['version_document_id']), array('class' => 'fancyboxUpload', 'id'=>'versionNo','escape' => false));                 
							}
						?>
					</li>
					  <li><a href="javascript::void(0)"><?php echo $this->Html->image('share.png');?></a></li>
					  <li><a href="#">Active 0- Pending 0</a></li>
					  <li><a href="javascript::void(0)" class="me_hide"><?php echo $this->Html->image('pending.png');?></a></li>
				  </ul>
				</div>
				<div class="hide me_hide">
					<?php echo $this->Form->input('name', array('label'=>false,'value'=>$document["name"],'class'=>'input-edit','div'=>false));?>
					<a href="javascript:void(0)" class="saveInfo" paramId="<?php echo $document['id']?>">save</a>
					<?php echo $this->Html->image('ajax-loader.gif', array('class' => 'loader'));?>
				</div>	
			</div>
			  
			<!-- Docuement Row Right Panel -->
			<div class="sharing_pan2">
				<ul class="titles clearfix">
					<li><a href="#"><?php echo $user["first_name"] . ' ' . $user["last_name"];?></a></li>
					<li><a href="#"><?php  echo date('m/d/Y', strtotime($document['created'])); ?></a></li>
					<li><a href="#"><?php  echo date('h:iA', strtotime($document['created'])); ?></a></li>
					<li class="nrm"><a href="#">EDT</a></li>
				</ul>
				<ul class="icons2 clearfix rolling_container">
					<!-- File View Icon -->
					<li>
						<?php if($is_readonly || $is_downloadable) {?>
							<?php 
								if(in_array(strtolower($ext), array('jpg', 'jpeg', 'png', 'gif'))) {   
									echo $this->Html->link($this->Html->image('eye.png'), 'javascript:void(0)', array('escape' => false, 'class' => 'fancyImageView', 'title' => 'View', 'data-relatedthumb' => 'img_' . $document['id'] ));
								} else {  
									echo $this->Html->link($this->Html->image('eye.png'),array('controller' => 'documents', 'action' => 'view', 'id' => $document['id']), array('escape' => false, 'target' => '_blank', 'data-relatedthumb' => $ext . '_' . $document['id'] ));
								}
							?>
						<?php } else {
							echo $this->Html->link($this->Html->image('eye.png'), 'javascript::void(0)', array('escape' => false));
						} ?>
					</li>
					
					<!-- Comment Icon -->
					<li>
						<?php if($is_readonly || $is_downloadable) {?>
							<?php if($documentComments > 0): ?><a class="counter"><?php echo $documentComments;?></a><?php endif;?>
							<?php 
								echo $this->Html->link($this->Html->image('comments.png'), array('controller' => 'documents', 'action' => 'comments', $document["id"]), array('escape' => false, 'title' => 'Comment', 'class' => 'fancyboxComment docComment', 'data-folder' => $this->Cabinet->createBreadCrumb($treeFolders, $folder["name"])." / ".  $folder["name"]));
							?>
						<?php } else {
							echo $this->Html->link($this->Html->image('comments.png'), 'javascript::void(0)', array('escape' => false));
						} ?>
					</li>
					
					<!-- File Share -->
					<li>
						<?php if($is_readonly && $is_downloadable && $is_printable & $is_writable) {?>
						<span class="file_share me_relative" style="font-size: 16px;" title="Share">
							<?php if($documentShares > 0) : ?><a class="counter"><?php echo $documentShares;?></a> <?php endif;?>
							<a class="fancyboxShareModal" href="<?php echo $this->Html->url(array('controller' => 'shares', 'action' => 'share_modal', 'type' => 'document', 'id' => $document['id']), true)?>"  paramId="<?php echo $document["id"]?>" data-sharetype="document"><?php echo $this->Html->image('share2.png');?></a>
						</span>
						<?php } else {
							echo $this->Html->link($this->Html->image('share2.png'), 'javascript::void(0)', array('escape' => false));
						} ?>
					</li>
					
					<!-- Task Icon -->
					<li>
						<?php if($is_readonly && $is_downloadable && $is_printable & $is_writable) {?>
							<?php if($documentCalendarEventCount > 0) : ?><a class="counter"><?php echo $documentCalendarEventCount;?></a> <?php endif;?>
							<a class="file_task" data-type="document" data-id="<?php echo $document["id"];?>" data-show-task="1" data-calevent="document_<?php echo $document['id'];?>" title="Task" data-itemname="<?php echo $document["name"];?>"><?php echo $this->Html->image('calendar.png');?></a>
						<?php } else {
							echo $this->Html->link($this->Html->image('calendar.png'), 'javascript::void(0)', array('escape' => false));
						} ?>
					</li>
					
					<!-- Subscription Icon -->
					<li>
						<?php if($role != 2) { 
								$iname = 'star.png';
								$class= '';
								if($document_subscription) {
									$iname= 'star2.png'; 
									$class = 'should_visible';
								}
						?>
							<a class="file_star subscription_star <?php echo $class;?>" data-subscription="document_<?php echo $folder['id'];?>" title="Subscribe" href="javascript:void(1)">
								<?php 
									echo $this->Html->image($iname);
								?>
							</a>
						<?php } else { 
							echo $this->Html->link($this->Html->image('star.png'), 'javascript::void(0)', array('escape' => false));
						} ?>
					</li>
					
					<!-- PDF Tool -->
					<?php if($ext == 'pdf'): ?>
					<li>
						<?php  echo $this->Html->link($this->Html->image('pdf.png'),array('controller' => 'documents', 'action' => 'pdfeditor', 'id' => $document['id']), array('escape' => false, 'target' => '_blank', 'data-relatedthumb' => $ext . '_' . $document['id'] )); ?>
					</li>
					<?php endif;?>
					
					<!-- File info / More Icon -->
					<li>
						<span class="file_info" style="font-size: 16px;" title="Info" title="More">
							<a class="showInfo" href="javascript:void(1)" paramId="info<?php echo $document["id"]?>" style="color: #5e5e5e"><?php echo $this->Html->image('list_icon.png');?></a>
						</span>
					</li>
				</ul>
			</div>
			<!-- More Icons -->
			<div id="info<?php echo $document["id"]?>" class="doc-info hide me_hide corner shadow">
				<ul>
					<!-- Edit Icon -->
                                        <?php if( !in_array(strtolower($ext), array('gif', 'jpg', 'jpeg', 'png')) ):?>
					<?php if($role == 1 || $is_writable) { ?>
                                           <?php if($ext == 'pdf'){?>
                                        <li> <?php echo $this->Html->link('<i class="icon-edit"></i>' . __('Edit'), array('controller' => 'documents', 'action' => 'pdfeditor', 'id' => $document['id']), array('target' => '_blank', 'paramId' => $document['id'], 'class' => 'editDoc', 'escape' => false));?></li>
                                            <?php } else { ?>
					<li> <?php echo $this->Html->link('<i class="icon-edit"></i>' . __('Edit'), array('controller' => 'documents', 'action' => 'edit', $document['id']), array('target' => '_blank', 'paramId' => $document['id'],'class' => 'editDoc', 'escape' => false));?></li>
					<?php } ?>
                                        <?php } else { ?>
					<li class="inactive_icon"><a href="javascript:void(0)"><i class="icon-edit"></i><?php echo __("Edit");?></a></li>
					<?php } ?>
                                        <?php endif;?>
					
					<!-- Remane Icon -->
					<?php if($role == 1) { ?>
					<li> <a href="javascript:void(0)" class="renameFile" paramId="edit<?php echo $document["id"]?>"><i class="icon-pencil"></i><?php echo __("Rename");?></a></li>
					<?php } else { ?>
					<li class="inactive_icon"> <a href="javascript:void(0)"><i class="icon-pencil"></i><?php echo __("Rename");?></a></li>
					<?php } ?>
					
					<!-- Move Icon -->
					<?php if($role == 1 || $role == 0) { ?>
					<li> <?php echo $this->Html->link('<i class="icon-move"></i>' . __('Move'), 'javascript:void(0)', array('paramId' => $document['id'],'class' => 'fancyMoveDoc', 'escape' => false));?></li>
					<?php } else { ?>
					<li class="inactive_icon"><a href="javascript:void(0)"><i class="icon-move"></i><?php echo __("Move");?></a></li>
					<?php } ?>
					
					<!-- Download Icon -->
					<?php if($is_downloadable) { ?>
					<li><?php echo $this->Html->link('<i class="icon-download-alt"></i>Download', array('controller' => 'documents', 'action' => 'download', $document["id"]), array('escape' => false, 'title' => 'Download'));?></li>
					<?php } else { ?>
					<li class="inactive_icon"><a href="javascript:void(0)"><i class="icon-download-alt"></i><?php echo __("Download");?></a></li>
					<?php } ?>
					
					<!-- Delete Icon -->
					<?php if($role != 2) { ?>
					<li> <a href="javascript:void(0)" class="delete deleteDoc" paramId="<?php echo $document["id"]?>"><i class="icon-trash"></i><?php echo __("Delete");?></a> </li>
					<?php } else { ?>
					<li class="inactive_icon"><a href="javascript:void(0)"><i class="icon-trash"></i><?php echo __("Delete");?></a></li>
					<?php } ?>
					
					<!-- Permalink Icon -->
					<?php if($role == 1 || $role == 0) { ?>
					<li> 
						<input type="hidden" class="permalink_holder" value="">
						<?php echo $this->Html->link('<i class="icon-globe"></i>' . __('Permalink'), 'javascript:void(1)', array('data-type' => 'documents', 'paramId' => $document['id'],'class' => 'doc_permalink fancyboxPermalink', 'escape' => false));?>
					</li>
					<?php } else { ?>
					<li class="inactive_icon"><a href="javascript:void(0)"><i class="icon-globe"></i><?php echo __("Permalink");?></a></li>
					<?php } ?>
					
					<!-- Version Icon --> 
					<li>
					<?php echo $this->Html->link('<i class="icon-file"></i>' . __('Versions'), array('controller' => 'cabinets', 'action'=> 'versions', $document["version_document_id"]), array('class' => 'fancyboxUpload', 'escape' => false));?>
					</li> 
					
				</ul>
			</div>
			<!-- Edit Section-->
			<div id="edit<?php echo $document["id"]?>" class="doc-edit hide me_hide corner">
				<ul>
					<li> 	<?php echo $this->Form->input("name", array("label"=>false,"value"=>$document["name"],
							"class"=>"input-edit","div"=>false,"maxlength"=>26));?> 
							<a href="javascript:void(0)" class="saveInfo" paramId="<?php echo $document["id"]?>">save</a> 
							<?php echo $this->Html->image('ajax-loader.gif', array('class' => 'loader me_hide', 'style' => 'margin-top:11px; float:right'));?>
					</li>
				</ul>
			</div>
		</div>
<?php 
		endforeach; 
	endif;
?>
	</div>
<?php
	endforeach;
?>
</div>

<!-- Thumb view -->
<ul id="image_holder" class="clearfix gallery_items_thumbnail_view me_hide">
<?php 	
	foreach ($documents as $results):
		$document = $results["Document"];
		$user = $results["User"]; 
		$ext = $document['ext'];
		
		if(in_array(strtolower($ext), array('jpg', 'jpeg', 'png', 'gif'))) {
			$path = FILOCITY_STORE . $document["file"]; //WWW_ROOT . DS . 'uploads' . DS . 'user_' . $auth_id . DS . $document["file"];
?>
		<li class="each_item me_left me_relative t<?php echo $document["id"]?>" data-description="" searchdata="<?php echo $document["name"]?>">
			<div class="thumb-content">
				<?php 
					$size = getimagesize($path);
					$width = $size[0];
					$height = $size[1];
					$thumb = $this->Html->url(array('controller' => 'image', 'action' => 'cabimage', 'thumb', $document['file']), true);
					$large = $this->Html->url(array('controller' => 'image', 'action' => 'cabimage', 'large', $document["file"]), true);
					
					$img = $this->Html->image($thumb, array('class' => 'my_thumb', 'escape' => false));
					echo $this->Html->link($img, $large ,array("class"=>"fancybox img_" . $document["id"],"escape"=>false,"rel"=>"gallery")); 
				?>	
			</div>
			<div class="image_overlay_with_title me_absolute">
				<div class="image_overlay_title me_absolute abs">
				<strong><?php echo $document["name"] ?></strong><br />
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
	<li class="each_item me_left me_relative upload-holder">
		<?php 
			$url = $this->Html->url(array('controller' => 'cabinets', 'action' => 'uploadToS3'), true);
			$agent = env('HTTP_USER_AGENT');
			$style = "";
			if(strlen(strstr($agent,"Firefox")) > 0 ): 
				$style = "position:absolute;left: -450px;font-size: 40px;";
			endif;
		?>
		<form class="formUpload" accept-charset="utf-8" method="post" enctype="multipart/form-data" action="<?php echo $url?>">
			<?php	
				
				foreach ($params as $p => $v):
					echo $this->Form->hidden("{$p}", array("value"=>"{$v}", "name"=>"{$p}"));
				endforeach;
				echo $this->Form->hidden('folder_id', array('value'=> CakeSession::read('currentFolderId'), 'name' => 'folder_id'));
				echo $this->Form->file('fileUpload', array("class"=>"upload-file","name"=>"data[file]","style"=>$style));
				echo $this->Html->tag("span", "", array("class"=>"ajaxTarget hide me_hide"));
				echo $this->Form->submit("Upload", array("class"=>"hide me_hide", "div" => "me_hide"));
			 ?>
			<span class="loader upl me_hide"><?php echo $this->Html->image('ajax-loader.gif');?> Uploading...</span>
		</form>
	</li>
</ul>
<!-- Permalink Display Box -->
<div class="me_hide">
	<div id="fancyboxPermalink" class="fancyboxPermalink">
		<h2>Permalink</h2>
		<div class="fancyboxPermalink_wrapper">
			<div>You can share this file with your associates using this link and they can download it without any restriction</div>
			<input type="text" class="permalink_container me_hide">
			<?php echo $this->Html->image('ajax-loader.gif', array('style' => 'margin: 10px auto'))?>
		</div>
	</div>
</div>

<!-- Alert Box -->
<div class="me_hide">
	<div id="fancyAlertBox" class="fancyAlertBox">
		<h5>Message</h5>
		<div class="alert_message"></div>
	</div>
</div>
