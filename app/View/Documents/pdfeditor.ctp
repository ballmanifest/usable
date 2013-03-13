<?php
	if(!empty($viewer_info)) {
	$mytmp = 0;
		$auth_id = CakeSession::read('Auth.User.id');
                echo $this->Html->css( array('document_view') );
				if(!empty($viewer_info['auth_key'])){
		                $file_id = "";
						$secret = $viewer_info['auth_key'];
						$space = 'company';
		          $folder_id = 1;
                  $shares = 0;
		          $mytmp = 1;
		}
		else
		{
		if(!empty($share_info)) {
			$is_printable = (int)$share_info[0]['Share']['is_printable'];
			$is_downloadable = (int)$share_info[0]['Share']['is_downloadable'];
			$is_readonly = (int)$share_info[0]['Share']['is_readonly'];
			$is_writable = (int)$share_info[0]['Share']['is_writable'];
		} else {
			$is_printable = $is_downloadable = $is_readonly = $is_writable = 1;
		}
		
                $file_id = $viewer_info['doc_detail']['Document']['id'];
		$secret = $viewer_info['doc_detail']['User']['auth_key'];
                $space = $viewer_info['doc_detail']['Folder']['name'];
		//$share = $viewer_info['doc_detail']['Share']['id'];
                $folder_id = $viewer_info['doc_detail']['Document']['folder_id'];
                $is_subscribed = count($viewer_info['doc_detail']['Subscription']);
		$version = $viewer_info['doc_detail']['Document']['version'];
		$created_by = $viewer_info['doc_detail']['User']['first_name'] . ' ' . $viewer_info['doc_detail']['User']['last_name'];
		$created = date('m-d-Y H:i', strtotime($viewer_info['doc_detail']['Document']['created']));
		$tasks = count($viewer_info['doc_detail']['CalendarEvent']);
		$comments = count($viewer_info['doc_detail']['Comment']);
		$shares = count($viewer_info['doc_detail']['Share']);
		}
?>
<?php if($mytmp == 1) { ?>

<div class="adeptol_viewer">
				<iframe name="ajaxdocumentviewer" src="https://secure.filocity.com/app/webroot/pdfeditor/Main.html?id=<?php echo $file_id;?>&space=<?php echo "company";//echo $space;?>&secret=<?php echo $secret;?>&share=<?php echo  $shares;?>&folder=<?php echo $folder_id;?>" border="1" height="870" width="940" scrolling="no" align="left" frameborder="0" marginwidth="1" marginheight="1" style="border: 1px solid #ccc;padding:5px;border-radius: 5px;margin-bottom:20px;">Your browser does not support inline frames or is currently configured not to display inline frames.</iframe>
</div>
<?php } elseif($mytmp == 0) { ?>
<div class="doc_header_des clearfix">
			<p class="related_to_doc me_right">
				<?php echo $this->Html->link('Tasks ('. $tasks .')', 'javascript:void(1)', array('class' => 'task_pill green_pill'));?>
				<?php echo $this->Html->link('Shares ('. $shares .')', 'javascript:void(1)', array('class' => 'share_pill green_pill'));?>
				</p>
			<h2>
			<a class="subscription_star" data-subscription="folder_<?php echo $viewer_info['doc_detail']['Document']['id'];?>" title="Subscribe" href="javascript:void(1)">
				<?php 
					$iname = 'star.png';
					if($is_subscribed) $iname= 'star2.png';
					echo $this->Html->image($iname);
				?>
			</a>
			<?php echo $viewer_info['doc_detail']['Document']['name'] . '.' . $viewer_info['doc_detail']['Document']['ext'];?>
			</h2>
			<p><span class="version">
				<strong>Version: <?php echo $version;?></strong></span>,
				<strong>Created By: <?php echo $created_by;?></strong></span>,
				<strong>Created on: <?php echo $created;?></strong></span>
			</p>
		</div>
<div class="adeptol_viewer">
				<iframe name="ajaxdocumentviewer" src="https://secure.filocity.com/app/webroot/pdfeditor/Main.html?id=<?php echo $file_id;?>&space=<?php echo "company";//echo $space;?>&secret=<?php echo $secret;?>&share=<?php echo  $shares;?>&folder=<?php echo $folder_id;?>" border="1" height="870" width="940" scrolling="no" align="left" frameborder="0" marginwidth="1" marginheight="1" style="border: 1px solid #ccc;padding:5px;border-radius: 5px;margin-bottom:20px;">Your browser does not support inline frames or is currently configured not to display inline frames.</iframe>
</div>

<?php
	}	
	} else {
		echo '<div id="flashMessage">No document to show.</div>';
	}
?>

