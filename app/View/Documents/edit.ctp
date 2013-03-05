<?php 
	echo $this->Html->css('document_view');
	$doc = $document['Document']; 
	$tasks = count($document['CalendarEvent']);
	$shares = count($document['Share']);
	$comments = count($document['Comment']);
	$version = $doc['version'];
	$created_by = $document['User']['first_name'] . ' ' . $document['User']['last_name'];
	$created = date('m-d-Y H:i', strtotime($doc['created']));
	$is_subscribed = count($document['Subscription']);
	if(!empty($share_info)) {
		$is_printable = (int)$share_info[0]['Share']['is_printable'];
		$is_downloadable = (int)$share_info[0]['Share']['is_downloadable'];
		$is_readonly = (int)$share_info[0]['Share']['is_readonly'];
		$is_writable = (int)$share_info[0]['Share']['is_writable'];
	} else {
		$is_printable = $is_downloadable = $is_readonly = $is_writable = 1;
	}
?>
<div id="DocEditor" class="container_to_editor">
		<!-- Description About Current Viewing Doc -->
		<div class="doc_header_des clearfix">
			<p class="related_to_doc me_right">
				<?php echo $this->Html->link('Tasks ('. $tasks .')', 'javascript:void(1)', array('class' => 'task_pill green_pill'));?>
				<?php echo $this->Html->link('Shares ('. $shares .')', 'javascript:void(1)', array('class' => 'share_pill green_pill'));?>
				<?php echo $this->Html->link('Edit PDF', 'javascript:void(1)', array('class' => 'edit_pdf_pill'));?>
				<?php echo $this->Html->link('Comments ('. $comments .')', 'javascript:void(1)', array('class' => 'comment_pill green_pill'));?>
			</p>
			<h2>
			<a class="subscription_star" data-subscription="folder_<?php echo $doc['id'];?>" title="Subscribe" href="javascript:void(1)">
				<?php 
					$iname = 'star.png';
					if($is_subscribed) $iname= 'star2.png';
					echo $this->Html->image($iname);
				?>
			</a>
			<?php echo $doc['name'] . '.' . $doc['ext'];?>
			</h2>
			<p><span class="version">
				<strong>Version: <?php echo $version;?></strong></span>,
				<strong>Created By: <?php echo $created_by;?></strong></span>,
				<strong>Created on: <?php echo $created;?></strong></span>
			</p>
		</div>
<?php
	$baseUrl = $this->Html->url('/uploads/user_' . CakeSession::read('Auth.User.id') . '/', true);
	$file = $doc['file'];;
	$ext = strtolower($doc['ext']);
	$fileName = $doc['name'] . '.' . $ext;
	$docId = time();
	$saveUrl = $this->Html->url(array('controller' => 'documents', 'action' => 'savedoc', $doc['id'], CakeSession::read('Auth.User.id')), true);
	
	/**
	*	Call Zoho API
	*/
	$this->loadHelper('Zoho');
	$viewer_url = $this->Zoho->openEditor($baseUrl, $file, $fileName, $ext, $docId, $saveUrl);
	
	/**
	*	If Zoho is OK
	*/
	if($viewer_url && $viewer_url != 'ext_fail'):
?>
		<iframe src="<?php echo $viewer_url;?>" seamless border="1" height="860" width="950" scrolling="no" align="middle" frameborder="0" marginwidth="1" marginheight="1" style="border: 1px solid #ccc;border-radius:5px;">
<?php
	/**
	*	If not appropriate extension for Zoho
	*/
	elseif($viewer_url == 'ext_fail'):
		echo '<h2>Sorry, failed to open this extension</h2>';
	/**
	*	If no return from Zoho
	*/
	else:
		echo '<h2>Sorry, failed to open this document</h2>';
	endif;
?>
</div>