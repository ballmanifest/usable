<?php	
	$this->loadHelper("Number");
	$this->loadHelper("Cabinet");
	
	$document = $documents["Document"];
    $user = $documents["User"];
	$folder = $documents["Folder"];
	
	$size = $this->Number->toReadableSize($document["size"]);
	$view = "../img/?img=/imagecache/".$document["file"]."&height=400";
	$totalComment = 0;
?>
<li class="breadcrumbs listView">
		<?php echo $this->Html->image("cabinets/folder-small.jpg");?> 
        <span> 
            <?php echo $this->Cabinet->createBreadCrumb($treeFolders, $folder["name"])?>
        </span>
        <?php echo " / ".  $folder["name"] ?>
</li> 
               
<li class="list_view_each_item me_relative listView" searchdata="<?php echo $document["name"]?>">
        <div class="file_item_block">
            <input type="checkbox" name="file_selected[]" value="<?php echo $document["id"]?>" class="me_hide">
            <div class="list_item_selection">&nbsp;</div>
            <div class="file_title_author me_left">
                <span class="file_title ft<?php echo $document["id"]?>">
					<?php 
						$img = $this->Html->image("?img=/imagecache/".$document["file"]."&height=16&cropratio=2:2", array());
						echo $img;
					?> 	
                    <span>
                    	<?php 
							$count = strlen($document["name"]);
							$name = $document["name"];
							if($count >=26) {
								$name = substr($document["name"],0,26) . "...";
							}
							echo $name; 
						?>
                    </span>    
                </span>
                <span class="updatedby"> via <?php echo ucwords($user["first_name"][0] . $user["last_name"][0])?></span>
                
                <div class="hide">
					<?php echo $this->Form->input("name", array("label"=>false,"value"=>$document["name"],"class"=>"input-edit","div"=>false));?>
                	<a href="javascript:void(0)" class="saveInfo" paramId="<?php echo $document["id"]?>">save</a>
                    <?php echo $this->Html->image('ajax-loader.gif', array('class' => 'loader'));?>
                </div>		
            </div>
            
            <div class="rolling_container me_relative roll_over">
                <div class="roll_over_file_processing me_absolute">
                    <span class="file_size">
						<?php echo $size?>
                    </span>
                    <span class="file_comment">
						 <a class="fancyboxComment" href="/documents/comments/<?php echo $document["id"]?>">
						 	<?php echo $this->Html->image("cabinets/icon-comment.jpg");?>
                         </a>
                         <a class="abs fancyboxComment" href="/documents/comments/<?php echo $document["id"]?>">
						 <?php echo $totalComment?></a>
                    </span>
                    <span class="file_task">
						<?php echo $this->Html->image("cabinets/icon-task.jpg");?> 
                    </span>
                    <span class="file_edit">
                         <a class="editInfo" href="javascript:void(1)"  paramId="edit<?php echo $document["id"]?>">
						 <?php echo $this->Html->image("cabinets/icon-edit.jpg");?></a>
                    </span>
                    <span class="file_share">
						 <a class="shareDoc" href="javascript:void(1)"  paramId="share<?php echo $document["id"]?>">
						 	<?php echo $this->Html->image("cabinets/icon-share.jpg");?> 
                         </a>
                    </span>
                    <span class="file_info">
                        <a class="showInfo" href="javascript:void(1)" paramId="info<?php echo $document["id"]?>">
                        	<?php echo $this->Html->image("cabinets/icon-info.jpg");?>
                        </a>
                    </span>
                   
                </div>
            </div>
            
        </div>
        
        <!-- Share Section-->
            <div id="share<?php echo $document["id"]?>" class="doc-share hide corner">
                <div class="head">
                	<span>Share</span> <i>Itemization of items</i>
                </div>
                
                <div class="step1">
                	<strong>Step 1:</strong> Share document with any member,<br />
                    group, project, task or calendar event:
                    <input name="" type="text" /> <a href="">add</a>
                </div>
                <div class="step2">
                	<div class="row first">
                        <div class="left"> <strong>Step 2:</strong> Assign specific share details: </div>
                        <div class="right"> Read Only </div>	
                        <div class="right"> Read/Edit </div>	
                        <div class="right">Shareable </div>	
                    </div>
                    <div class="row">
                        <div class="left strong">Bryan Potts - Member</div>
                        <div class="right"> <input type="checkbox" name="file_selected[]" value="" ></div>
                        <div class="right"> <input type="checkbox" name="file_selected[]" value="" ></div>
                        <div class="right"> <input type="checkbox" name="file_selected[]" value="" ></div>
                	</div>
                    
                     <div class="row">
                        <div class="left strong">Project Potts - Member</div>
                        <div class="right"> <input type="checkbox" name="file_selected[]" value="" ></div>
                        <div class="right"> <input type="checkbox" name="file_selected[]" value="" ></div>
                        <div class="right"> <input type="checkbox" name="file_selected[]" value="" ></div>
                	</div>
                </div>
                <div class="accept">
                	<a href="javascript:void(0)"><?php echo __("Accept and Submit Shares");?></a>
                </div>
            </div>
            
            <!-- Edit Section-->
            <div id="edit<?php echo $document["id"]?>" class="doc-edit hide corner">
                <ul>
                    <li> 	<?php echo $this->Form->input("name", array("label"=>false,"value"=>$document["name"],
                            "class"=>"input-edit","div"=>false,"maxlength"=>26));?> 
                            <a href="javascript:void(0)" class="saveInfo" paramId="<?php echo $document["id"]?>">save</a> 
							<?php echo $this->Html->image('ajax-loader.gif', array('class' => 'loader', 'style' => 'margin-top:11px; float:right'));?>
                    </li>
                </ul>
            </div>
            
            <!-- Info Section-->
            <div id="info<?php echo $document["id"]?>" class="doc-info hide corner">
                <ul>
                    <li><span>Created On:</span> <?php echo $this->Time->timeAgoInWords($document["created"])?></li>
                    <li><span>Created By:</span> <?php echo $user["first_name"] . " " . $user["last_name"]?></li>
                    <li><span>Last Update:</span> <?php echo $this->Time->timeAgoInWords($document["modified"])?></li>
                    <li><span>Current Version:</span> - </li>
                    <li><hr /></li>
                    <li><span>Options:</span> </li>
                    <li> <a href="javascript:void(0)" class="renameFile"><?php echo __("rename file");?></a> </li>
                    <li> <a><?php echo __("edit as PDF");?></a> </li>
                    <li> <a href="/img/?img=/imagecache/<?php echo $document["file"]?>" target="_blank"><?php echo __("download file");?></a> </li>
                    <li> <a><?php echo __("see version history");?></a> </li>
                    <li> <a href="javascript:void(0)" class="delete deleteDoc" paramId="<?php echo $document["id"]?>">
					<?php echo __("delete this file");?></a> </li>
                </ul>
            </div>
          
    </li>


    <li class="each_item me_left me_relative thumbView t<?php echo $document["id"]?>" data-description="" searchdata="<?php echo $document["name"]?>">
          <div class="thumb-content">
                <?php 
                    $image = $document["file"];
                    $img = $this->Html->image("?img=/imagecache/".$document["file"]."&height=173", array());
					echo $this->Html->link($img, array('action' =>$view),array("class"=>"fancybox","escape"=>false)); 
                ?>	
           </div>
          <div class="image_overlay_with_title me_absolute" style="background:url();">
            <div class="image_overlay_title me_absolute abs"> 
            <strong><?php echo $document["name"] ?></strong><br />
            Updated <?php echo $this->Time->timeAgoInWords($document["created"])?> by <span class="auth_name"> <?php echo $user["first_name"] . " " . $user["last_name"] . " "?></span> </div>
          </div>
          <input type="hidden" value="<?php echo $document["id"]?>" >
    </li>
