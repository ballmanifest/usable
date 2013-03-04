<?php
	echo $this->Html->css(array('share_modal.css?' . time()));
	echo $this->Html->script(array('share_modal.js?' . time()));
	$item = $itemDetail[$Model];
?>
<div id="share_modal_container" class="share_modal_container me_absolute">
	<input type="hidden" id="is_share_exists" value="<?php echo $is_share_exists;?>" readonly>
	<ul class="search_result_container me_absolute me_hide">
	<?php echo $resultHtml;?>
	</ul>
	<input type="hidden" class="auth_id" value="<?php echo $auth_id?>" readonly>
	<div id="share_modal_header">
		<h2>Sharing <span style="color: #57b1f0" class="file_name_to_share"><?php echo $item['name'];?></span></h2>
	</div>
	<div id="share_modal_wrapper">
		<!-- Modal Tabs -->
		<div id="share_modal_tabs">
			<ul class="share_modal_tabs_container clearfix">
				<li class="contacts_tab me_left"><a data-tabpanel="contact_tab_panel" class="tabs_tab active_tab" data-name="contacts">CONTACTS</a></li>
				<li class="existing_shares_tab me_left"><a data-tabpanel="existing_shares_tab_panel" class="tabs_tab" data-name="existing_shares">EXISTING SHARES</a></li>
			</ul>
		</div>
		<!-- Container to tabs -->
		<div id="share_modal_tabs_container">
			<!-- Container for CONTACT tab -->
			<div id="contact_tab_panel" class="tab_panel">
				<div id="quick_note_find_share_panel">
					<!-- Quick note panel -->
					<div id="quick_note_panel">
						<h4>Note: <span style="color:#888282">(optional)</span></h4>
						<input type="text" class="quick_note_box" value="">
					</div>
					<!-- Find share panel -->
					<div id="find_share_panel">
						<h4 class="share_with">
							Share with: 
							<span class="me_right" style="font-weight:normal">
								Quick Select:&nbsp;
								<?php echo $this->Html->link('Contacts/Groups', array('controller' => 'contacts', 'action' => 'contact_modal'), array('id'  => 'contact_modal_link', 'data-name' => 'contacts'));?>
							</span>
						</h4>
						<input type="text" class="share_target_input" value="" data-itemkey="<?php echo $item_key;?>" data-itemkeyval="<?php echo $item_key_val;?>" placeholder="Example: Groups, Events, Members, Contacts, Email Addresses">
						<input type="hidden" readonly value="" class="share_with_key">
						<input type="hidden" readonly value="" class="share_with_value">
						<a class="btn btn-success add_share" href="#">Add</a>
					</div>
				</div>
				<!-- Display Selected users list -->
				<div id="display_selected_users">
					<form class="submit_shares_form">
						<input type="hidden" class="quick_note" name="data[quick_note]">
						<table class="selected_users_list" width="100%" border="0">
							<thead>
								<tr>
									<th width="50%" style="text-align:left;padding-left:3px">Sharing options:</th>
									<th>View</th>
									<th>Edit</th>
									<th>Download</th>
									<th>Print</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</form>
				</div>
				<!-- Notification link, Share and cancel buttons panel -->
				<div class="notification_share_cancel_panel clearfix">
					<button class="cancel_btn me_right">Cancel</button>
					<button class="share_btn me_right inactive_button">Share</button>
					<?php echo $this->Html->image('ajax-loader-trans.gif', array('class' => 'me_right me_hide'));?>
					<label><input type="checkbox" name="data[notify]">&nbsp;Notify them upon updates.</label>
				</div>
			</div>
			
			<!-- Container for EXISTING SHARES tab -->
			<div id="existing_shares_tab_panel" style="display:none;width:560px" class="tab_panel">
				<h4>Existing Shares</h4>
				<div id="display_existing_users">
					<table class="existing_users_list" width="100%" border="0">
						<thead>
							<tr>
								<th width="40%" style="text-align:left;padding-left:3px">User</th>
								<th>Type</th>
								<th>Print</th>
								<th>Write</th>
								<th>Download</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody class="loading_content">
							
						</tbody>
					</table>
				</div>
				<!-- Notification link, Share and cancel buttons panel -->
				<!--<div class="notification_share_cancel_panel clearfix">
					<button class="cancel_btn  me_right">Cancel</button>
					<button class="share_btn me_right inactive_button">Share</button>
					<label><input type="checkbox" name="data[notify]">&nbsp;Notify them upon updates.</label>
				</div>-->
			</div>
		</div>
	</div>
</div>

<!-- Show Contacts / Groups Panel -->
<div id="contacts_and_groups_container" class="me_absolute" data-render="n"></div>
