<?php
	echo $this->Html->css(array('share_modal'));
	//echo $this->Html->script(array('share_modal'), array('inline' => false));
?>
<div id="share_modal_container" class="share_modal_container me_absolute">
	<div id="share_modal_header">
		<h2>Shares</h2>
	</div>
	<div id="share_modal_wrapper">
		<!-- Modal Tabs -->
		<div id="share_modal_tabs">
			<ul class="share_modal_tabs_container clearfix">
				<li class="contacts_tab me_left"><a data-tabpanel="contact_tab_panel" class="tabs_tab blue_tab">CONTACTS</a></li>
				<li class="existing_shares_tab me_left"><a data-tabpanel="existing_shares_tab_panel" class="tabs_tab">EXISTING SHARES</a></li>
			</ul>
		</div>
		<!-- Container to tabs -->
		<div id="share_modal_tabs_container">
			<!-- Container for CONTACT tab -->
			<div id="contact_tab_panel" class="tab_panel">
				<div id="quick_note_find_share_panel">
					<!-- Quick note panel -->
					<div id="quick_note_panel">
						<h4>Quick Notes</h4>
						<input type="text" name="data[quick_note]" class="quick_note_box" value="">
					</div>
					<!-- Find share panel -->
					<div id="find_share_panel">
						<h4>Share: <span class="file_name_to_share">my_image_002</span></h4>
						<input type="text" name="data[user2_id]" class="share_target_input" value="">
						<a class="btn btn-success add_share" href="#">Add</a>
						<a href="" class="view_all_contacts_link">View all Contacts/Groups</a>
					</div>
				</div>
				<!-- Display Selected users list -->
				<h4>Selected Users</h4>
				<div id="display_selected_users">
					<form class="submit_shares_form">
						<table class="selected_users_list" width="100%" border="0">
							<thead>
								<tr>
									<th width="50%" style="text-align:left;padding-left:3px">Shared with<br><input type="checkbox" class="all_readonly">All none</th>
									<th>View<br><input type="checkbox" class="all_readonly"></th>
									<th>Download<br><input type="checkbox" class="all_downloadable"></th>
									<th>Print<br><input type="checkbox" class="all_printable"></th>
									<th>Edit<br><input type="checkbox" class="all_writable"></th>
									<th>Action<br><input type="checkbox" style="visibility:hidden"></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="user_name">Md. Abdullah Yousuf<input type="hidden" name="data[0][Share][user2_id]" value="1"><input type="hidden" name="data[0][Share][document_id]" value="55"/></td>
									<td><input type="checkbox" name="data[0][Share][is_readonly]" value="0"></td>
									<td><input type="checkbox" name="data[0][Share][is_downloadable]" value="0"></td>
									<td><input type="checkbox" name="data[0][Share][is_printable]" value="0"></td>
									<td><input type="checkbox" name="data[0][Share][is_writeable]" value="0"></td>
									<td><a class="delete_icon"></a></td>
								</tr>
								<tr>
									<td class="user_name">Bryan Potts<input type="hidden" name="data[1][Share][user2_id]" value="2"><input type="hidden" name="data[1][Share][document_id]" value="66"/></td>
									<td><input type="checkbox" name="data[1][Share][is_readonly]" value="0"></td>
									<td><input type="checkbox" name="data[1][Share][is_downloadable]" value="0"></td>
									<td><input type="checkbox" name="data[1][Share][is_printable]" value="0"></td>
									<td><input type="checkbox" name="data[1][Share][is_writeable]" value="0"></td>
									<td><a class="delete_icon"></a></td>
								</tr>
							</tbody>
						</table>
					</form>
				</div>
				<!-- Notification link, Share and cancel buttons panel -->
				<div class="notification_share_cancel_panel clearfix">
					<button class="cancel_btn me_right">Cancel</button>
					<button class="share_btn me_right">Share</button>
					<label><input type="checkbox" name="data[notify]">&nbsp;Notify them upon updates.</label>
				</div>
			</div>
			
			<!-- Container for EXISTING SHARES tab -->
			<div id="existing_shares_tab_panel" style="display:none" class="tab_panel">
				<h4>Existing Shares</h4>
				<div id="display_existing_users">
					<table class="existing_users_list" width="100%" border="0">
						<thead>
							<tr>
								<th width="50%" style="text-align:left;padding-left:3px">User</th>
								<th>Type</th>
								<th>Print</th>
								<th>Write</th>
								<th>Download</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="user_name">Md. Abdullah Yousuf</td>
								<td>Folder</td>
								<td>Y</td>
								<td>N</td>
								<td>Y</td>
								<td>Pending</td>
								<td><a class="delete_icon"></a><a class="email_icon"></a></td>
							</tr>
						</tbody>
					</table>
				</div>
				<!-- Notification link, Share and cancel buttons panel -->
				<div class="notification_share_cancel_panel clearfix">
					<button class="cancel_btn  me_right">Cancel</button>
					<button class="share_btn me_right">Share</button>
					<label><input type="checkbox" name="data[notify]">&nbsp;Notify them upon updates.</label>
				</div>
			</div>
		</div>
	</div>
</div>