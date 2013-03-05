<?php
	if(!empty($viewer_info)) {
		$auth_id = CakeSession::read('Auth.User.id');
		echo $this->Html->css( array('document_view') );
		if(!empty($share_info)) {
			$is_printable = (int)$share_info[0]['Share']['is_printable'];
			$is_downloadable = (int)$share_info[0]['Share']['is_downloadable'];
			$is_readonly = (int)$share_info[0]['Share']['is_readonly'];
			$is_writable = (int)$share_info[0]['Share']['is_writable'];
		} else {
			$is_printable = $is_downloadable = $is_readonly = $is_writable = 1;
		}
		$is_subscribed = count($viewer_info['doc_detail']['Subscription']);
		$version = $viewer_info['doc_detail']['Document']['version'];
		$created_by = $viewer_info['doc_detail']['User']['first_name'] . ' ' . $viewer_info['doc_detail']['User']['last_name'];
		$created = date('m-d-Y H:i', strtotime($viewer_info['doc_detail']['Document']['created']));
		$tasks = count($viewer_info['doc_detail']['CalendarEvent']);
		$comments = count($viewer_info['doc_detail']['Comment']);
		$shares = count($viewer_info['doc_detail']['Share']);
?>
		<!-- Description About Current Viewing Doc -->
		<div class="doc_header_des clearfix">
			<p class="related_to_doc me_right">
				<?php echo $this->Html->link('Tasks ('. $tasks .')', 'javascript:void(1)', array('class' => 'task_pill green_pill'));?>
				<?php echo $this->Html->link('Shares ('. $shares .')', 'javascript:void(1)', array('class' => 'share_pill green_pill'));?>
				<?php echo $this->Html->link('Edit PDF', 'javascript:void(1)', array('class' => 'edit_pdf_pill'));?>
				<?php echo $this->Html->link('Comments ('. $comments .')', 'javascript:void(1)', array('class' => 'comment_pill green_pill'));?>
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
<?php
		$adeptol = false;
		/*
		*	Crocodoc Viewer
		*/
			if( $viewer_info['viewer'] == 'crocodocc' &&  !empty($viewer_info['doc_detail']['Document']['crocodoc_uuid']) ) {
				$uuid1 = '057d6c6a-1589-4a8a-9e2e-61d873a0a2db';
				$uuid2 = '82be5a5d-1c85-4d58-9d17-79af97e52b73';
				$uuid3 = ' ec2cd1b2-ee0d-445c-9290-c34debf80e15';
				$uuid = $viewer_info['doc_detail']['Document']['crocodoc_uuid'];

				$this->loadHelper("Crocodoc");
				$status = $this->Crocodoc->setToken('suJGtmrvpCjEVNWfIAy0LXdh')->setUUID($uuid)->getStatus();
				if($status['viewable'] && strtolower($status['status']) == 'done') {
					$sessionKey = $this->Crocodoc->setToken('suJGtmrvpCjEVNWfIAy0LXdh')->setUUID($uuid)->createSession(); 
					echo $this->Html->script( array('crocodoc', '//crocodoc.com/webservice/document.js?session=' . $sessionKey, 'document_view') );
	?>
				<!-- Crocodoc Viewer -->
				<div id="document_viewer_wrapper me_relative">
					<div class="toolbar me_relative">
						<div class="zoom-btns me_absolute">
						  <button class="zoom-out">-</button>
						  <button class="zoom-in">+</button>
						</div>
						<div class="page-nav me_absolute">
						  <button class="prev"><</button>
						  <span class="label">Page <span class="num">1</span>/<span class="numpages">1</span></span>
						  <button class="next">></button>
						</div>
					</div>
					<div id="DocViewer"></div>
				</div>
<?php 
			} else $adeptol = true;
		} else $adeptol = true;
		
		if($adeptol) {
			/*
			*	Adeptol Viewer
			*/
			$adeptol_key = 'PR9LPQEC68D7EMGKS2D631520WXVBY3K';
			$url = $this->Html->url('/uploads/user_' . $auth_id . '/' .  $viewer_info['doc_detail']['Document']['file'], true);
			$save_button = $is_downloadable? 'Yes' : 'No';
			$print_button = $is_printable? 'Yes' : 'No';
			$copy_text_button = $is_readonly ? 'No' : 'Yes';
?>
			<div class="adeptol_viewer">
				<iframe name="ajaxdocumentviewer" src="//connect.ajaxdocumentviewer.com?key=<?php echo $adeptol_key;?>&document=<?php echo $url;?>&viewerheight=905&viewerwidth=980&copytextButton=<?php echo $copy_text_button;?>&startPage=1&saveButton=<?php echo $save_button;?>&printButton=<?php echo $print_button;?>&quality=high" border="1" height="870" width="940" scrolling="no" align="left" frameborder="0" marginwidth="1" marginheight="1" style="border: 1px solid #ccc;padding:5px;border-radius: 5px;margin-bottom:20px;">Your browser does not support inline frames or is currently configured not to display inline frames.</iframe>
			</div>
<?php
		}
	} else {
		echo '<div id="flashMessage">No document to show.</div>';
	}
?>

