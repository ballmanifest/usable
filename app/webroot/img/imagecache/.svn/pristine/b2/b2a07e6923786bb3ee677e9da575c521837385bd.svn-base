<?php
	echo $this->Html->css(array('contact_modal.css?' . time()));
	echo $this->Html->script(array('contact_modal'));
?>
<div id="contact_modal_container">
	<!-- Share Contact modal -->
	<div id="contact_modal_wrapper">
		<div id="contact_modal_header">
			<p>Select Contacts to share <span style="color: #57b1f0">ExampleFilename001.jpg</span></p>
		</div>
		<div id="contacts_and_groups_list" class="clearfix">
			<!-- Contact/Group left navigation -->
			<div id="contact_left_container" class="me_left">
				<div id="contact_filter_links_container" class="first">
					<ul class="contact-contact">
						<li class="contact_type selected_contact_type"><a href="#" id="get_all_members_and_contact" data-filter="all-members-contacts">Members, Contacts</a></li>
						<li class="contact_type"><a href="#" id="account_users_group_link" data-filter="account-users">Members</a></li>
						<li class="contact_type"><a href="#" id="all_contacts_group_link" data-filter="all-contacts" class="current-contact-group">Contacts</a></li>
					</ul>
					<h4 class="groups_title">Groups</h4>
					<ul class="contact-group" id="custom-contact-group-list" style="">
						<li><?php echo $this->Html->image('ajax-loader-trans.gif')?></li>
					</ul>
					<div id="create_new_group">
						<a id="create_new_group_link">Create New Group</a>
						<p><strong>Note:</strong> You can create a group and add contacts to make future sharing easy.</p>
					</div>
				</div>
			</div>
			<!-- Contact/Group display list for selection  -->
			<div id="contact_list_container" class="me_left">
				<!-- Sorting tools -->
				<div id="sort_types">
					Sort by:
					<a href="#" id="sort_first_name_link">First Name</a>, <a href="#" id="sort_last_name_link">Last Name</a>, <a href="#" id="sort_email_link" class="current_sort">Email</a>
				</div>
				<!-- Listing -->
				<div class="group-panel">
					
				</div>
				<!-- Share and cancel buttons panel for contacts/group  -->
				<div class="contact_share_buttons clearfix">
					<p class="error_message me_left me_hide">Please select some item to share.</p>
					<button class="cancel_btn me_right">Cancel</button>
					<button class="share_btn me_right inactive_button">Share</button>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Create Group modal -->
	<div id="create_group_modal" class="me_absolute me_hide">
		<h2>Create Group</h2>
		<!-- Group name input box with header-->
		<div id="group_name_input">
			<h6 class="auxiliary_header">Name</h6>
			<input type="text" name="data[Group][name]" id="created_group_name" placeholder="Example: Human Resources, Accounting">
		</div>
		<!-- Add Initial memeber block with header -->
		<div id="add_initial_member">
			<div class="add_initial_member_header">
				<div id="sort_types_for_create_group" class="me_right" style="border: none">
					Sort by:
					<a href="#" id="sort_first_name_link">First Name</a>, <a href="#" id="sort_last_name_link">Last Name</a>, <a href="#" id="sort_email_link" class="current_sort">Email</a>
				</div>
				<h6 class="auxiliary_header">Add Initial Members</h6>
			</div>
			<!-- Listing -->
			<form class="save_contacts_group">
				<div class="show_contacts_for_create_group"></div>
			</form>
			<!-- Create and Cancel buttons panel for Create New Gropu  -->
				<div class="create_group_button clearfix">
					<p class="success_message me_left"></p>
					<?php echo $this->Html->image('ajax-loader-trans.gif', array('class' => 'me_right'));?>
					<button class="cancel_btn cancel_create_group me_right">Cancel</button>
					<button class="share_btn create_group me_right">Create</button>
				</div>
		</div>
	</div>
</div>
