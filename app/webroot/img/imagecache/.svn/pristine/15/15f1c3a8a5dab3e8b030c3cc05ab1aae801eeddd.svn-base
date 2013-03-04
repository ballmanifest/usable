<!--<div id="comment_container_block" style="z-index: 20000;position: absolute; left: 50%; width:600px;margin-left: -300px;background-color: #fff;padding: 20px; min-height: 350px;top: 250px; border-radius: 5px">-->
<?php 
	$count = count($comments);
	$style = "style='width:600px'";
	if(!$count):
		$style = "style='height:100px;width:600px'";
	endif;
?>
<?php if(!isset($isNewAdded)): ?>
        <div class="ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix" style="padding:5px;margin-bottom:15px">
            <span class="ui-dialog-title" id="ui-dialog-title-dialog">
                <?php 
                    $title = !empty($title) ? $title : str_replace("s","",$this->params["controller"]);
                    if($title == "cabinet"):
                        $title = "Folder";
                    endif;
                    echo ucfirst($title) . " " .  __("Comments");
                ?>
            </span>
         	<a href="#" class="ui-dialog-titlebar-close ui-corner-all" role="button"></a>
        </div>
		
        <div class="me_left" id="directory_avatar" style="width:590px;font-size: 15px;font-weight: bold;margin-left:5px;text-align:center">
			  <?php echo htmlspecialchars_decode($notice['Notice']['message']); ?>
		</div>
		
        <div class="me_left" id="directoryDetails">
			  <div class="directory_heading directoryHeader"></div>
		</div>
        <div class="message" style="width:585px;"></div>
          
        <div class="comment-wrapper" <?php echo $style?>>
<?php endif; ?>

<?php
	foreach($comments as $results):
		$comment = $results["Comment"];
		$user = $results["User"];
		$name = $user["first_name"] . " " . $user["last_name"]; 
		$photo = "filocity_img/user_" . $user["id"] . "/profile.jpg";
?>
	<div class="message">
          <div class="left"> 
                <?php echo $this->Html->image($photo, array("width"=>48,"height"=>48));?>
          </div>
          <div class="right marginbottom5">
		  <?php echo $this->Html->link($name.'.', array('controller' => 'users', 'action' => 'resources/member', $user["id"]),array('class' => 'strong'));?>
          <span class="paragraph"> <?php echo $comment["comment"] ?></span>
            <div class="cleared"> </div>
            <ul class="inline">
              <li class="ago small">on <?php echo $this->Time->timeAgoInWords($comment["created"])?></li>
            </ul>
          </div>
    </div>
<?php endforeach;	?>    

<?php if(!isset($isNewAdded)): 
			$controller = $this->params["controller"];
?>
			<?php echo $this->Form->create('Comment', array('url' => array('controller' => 'comments', 'action' => 'addComment'), 'type' => 'post', 'class' => 'formComments'));?>
				<span class="add-new-comment">Add new comment :  <?php echo $this->Html->image('ajax-loader.gif', array('class' => 'loader', 'style' => 'display:none'));?></span>
				<textarea name="data[Comment][comment]" class="textarea" ></textarea>
				<input type="hidden" readonly="readonly" value="<?php echo $target_id;?>" name="data[Comment][<?php echo $comment_for;?>]" />
				<input type="hidden" readonly="readonly" value="<?php echo $auth_id;?>" name="data[Comment][user_id]" />
				<span class="ajaxTarget hide"></span>
            <?php echo $this->Form->end();?>
        </div>
<?php endif;?> 
<!--</div>-->