<div class="me_hide">
	<div class="manage_event eventPopulateModal me_relative" style="background-color: #fff" id="eventPopulateModal">
		<ul class="search_result_container me_absolute me_hide">
		<?php echo $allEmails;?>
		</ul>
		<input type="hidden" class="this_controller" value="<?php echo $this->params->controller;?>" readonly="readonly">
		<input type="hidden" class="share_with_key" value="">
		<input type="hidden" class="share_with_value" value="">
		<?php
			echo $this->Form->create('CalendarEvent', array('id' => false, 'class' => 'file_cab_event_create_form event_create_popup', 'inputDefaults' => array('id' => false, 'div' => false, 'label' => false)));
			echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id')));
			echo $this->Form->input('event_id', array('type' => 'hidden', 'class' => 'calendar_event_id'));
			echo $this->Form->input('folder_id', array('type' => 'hidden', 'class' => 'calendar_event_folder_id', 'value' => '0'));
			echo $this->Form->input('document_id', array('type' => 'hidden', 'class' => 'calendar_event_document_id', 'value' => '0'));
		?>
		<div class="manage_event_content edit_event_border">
			<div class="event_modal_header">
				<h3>Event</h3>
			</div>	
			<div class="title_change_cancel">
				<div class="title_modify">
					<h4>Event Name</h4>
					<?php echo $this->Form->input('title', array('type' => 'text', 'class' => 'event_title')); ?>
				</div>
			</div>
			<div class="status_group_one clearfix">
				<div class="time_standard" style="float:left;">
					<div class="time_zone">
						<label style="float:left;">
						<h4>Start Time</h4>
						<?php echo $this->Form->input('my_date_start', array('type' => 'text', 'class' => 'my_date_start', 'div' => false)); ?>
						</label>
						<label style="float:left;margin-left:5px;">
						<h4>End Time</h4>
						<?php echo $this->Form->input('my_date_end', array('type' => 'text', 'class' => 'my_date_end', 'div' => false, 'before' => ''));?>
						</label>
						<?php
							echo $this->Form->input('date_start', array('type' => 'text', 'class' => 'date_start', 'div' => false, 'hidden' => true)); 
							echo $this->Form->input('date_end', array('type' => 'text', 'class' => 'date_end', 'div' => false, 'hidden' => true)); 
						?>
					</div>
				</div>
				<div class="remainder_event">
					<div class="remainder_label">Reminder</div>
					<div class="event_timeout" style="width:auto;float:left;">
						<select style="float:left;margin-right:3px;">
							<option>Pop-up</option>
							<option>Email</option>
						</select>
						<input type="text" class="remainder_time_log" />
						<select style="float:left;margin-left:3px;">
							<option>minutes</option>
							<option>hours</option>
							<option>days</option>
							<option>weeks</option>
						</select>
						<div class="calender_event_cross" style="display:none;">X</div>
						<div class="addremainder" style="display:none;">
							<a href="#">Add a Remainder</a>
						</div>
					</div>
				</div>
			</div>
			<div class="status_and_day_repeat clearfix">		
				<div class="day_repeat" style="float:left;width:auto;">
					<?php
						echo $this->Form->input('availability', array('label' => 'Show me as busy', 'type' => 'checkbox', 'value' => 1));
						echo $this->Form->input('is_all_day', array('class' => 'day_check', 'label' => 'All Day Event'));
						echo $this->Form->input('is_repeat', array('class' => 'day_repeat_chk', 'label' => 'Recurring'));
					?>
				</div>
			</div>
			<div class="find_atime_event" style="display:none;">
				<div class="event_details">Event Details</div>
				<div class="find_atime"><a href="">Find a Time</a></div>
			</div>
			
			<div class="edit_event_where">
				<!--
				<div class="event_place" style="float:left;width:auto;">
					<div class="event_map">
						<a href="#" id="event_map_picker">map</a>
						<?php echo $this->Form->input('lat', array('type' => 'hidden', 'id'=>'event_map_lat'));?>
						<?php echo $this->Form->input('lng', array('type' => 'hidden', 'id'=>'event_map_lng'));?>
					</div>
					<div class="event_where"><strong>Where</strong></div><br />
					<div class="event_where_input">
						<?php echo $this->Form->input('location', array('type' => 'text', 'id'=>'event_map_location'));?>
					</div>
				</div>
				<div class="add_google_plus" style="display:none;">
					<div class="vedio_call">Video call</div>
					<div class="add_plus_handout" style=""><a href="#">Add a Google+ handout</a></div>
				</div>
				<div class="calendar_edit_owner" style="float:left;width:auto;display:none;">
					<div class="editcalendar"><strong>Calendar</strong></div><br />
					<div class="cal_owner">
						<?php
							echo $this->Form->input('calendar_id', array('type' => 'select', 'options' => $calendars, 'class' => 'select_calenderowner'));
						?>
					</div>
				</div>-->
				<?php if( $this->params->controller !== 'users'):?>
				<div class="document_or_folder_share_segment">
					<div class="document_or_folder_name_that_attached">
						<strong>Attach File or Folder :</strong><span class="document_or_folder_name"></span>
					</div>
					<div class="enter_invitee_name">
						<label>Assign / Invite</label>
						<input type="text" name="inivitee_name" class="invite_to"  placeholder="Enter Email address">
						<a href="" class="btn btn-info btn-small filebcab_share_add">Add</a>
						<a href="" class="view_all_contacts">View all Contacts/Group</a>
					</div>
					<div class="display_share_permissions">
						<table style="width: 100%" class="add_share_for_event_modal">	
							<thead>
								<th>
									<h4>Files / Folder Share Permissions<label style="margin-left:5px;"><input type="checkbox" name="select[all]" class="permission_all">Select all</label></h4>
								</th>
								<th>
									View<br>
									<!--<input type="checkbox" name="select[view]" class="permission_view">-->
								</th>
								<th>
									Edit<br>
									<!--<input type="checkbox" name="select[edit]" class="permission_edit">-->
								</th>
								<th>
									Download<br>
									<!--<input type="checkbox" name="select[download]" class="permission_download">-->
								</th>
								<th>
									Print<br>
									<!--<input type="checkbox" name="select[print]" class="permission_print">-->
								</th>
								<th>Remove</th>
							</thead>
							<tbody>
								
							</tbody>
						</table>
					</div>
				</div>
				<?php endif;?>
				<div class="event_decription" style="float:left;width:auto;">
					<div class="event_description_label"><h4>Description</h4></div><br />
					<div class="event_description_area">
						<?php 
							echo $this->Form->input('description', array('class' => 'event_description'));
						?>
					</div>
				</div>
				<div class="show_my_privacy">
					<div class="privacy_state">
						<?php echo $this->Form->input('privacy', array('hidden' => true, 'value' => 1));?>
						<label>
							<input type="radio" name="user_privacy" value="1" checked="checked">
							<label>Public</label>
						</label>
						<label>
							<input type="radio" name="user_privacy" value="2">
							<label>Private</label>
						</label>
					</div>
					<div class="learn_more" style="display:none;">
						<a href="#" class="learn_more_text">Learn more about private vs public events</a>
						<a href="#" class="learn_more_publish">Publish event</a>
					</div>
				</div>
				<div class="event_color" style="float:left;width:auto;">
					<div class="color_title"><h4>Event Color</h4></div><br />
					<div class="color_name">
						<?php echo $this->Form->input('color', array('type' => 'hidden'));?>
						<div class="chkcolor_color_1 me_absolute check_event_color"><input class="me_hide" value="A8A6FF" type="radio" name="user_color"></div>
						<div class="chkcolor_color_2 check_event_color"><input class="me_hide" value="5181EF" type="radio" name="user_color" ></div>
						<div class="chkcolor_color_3 check_event_color"><input class="me_hide" value="A3BBFE"  type="radio" name="user_color"></div>
						<div class="chkcolor_color_4 check_event_color"><input class="me_hide" value="3BD6DC"  type="radio" name="user_color"></div>
						<div class="chkcolor_color_5 check_event_color"><input class="me_hide" value="74E8BE"  type="radio" name="user_color"></div>
						<div class="chkcolor_color_6 check_event_color"><input class="me_hide" value="4BB842"  type="radio" name="user_color"></div>
						<div class="chkcolor_color_7 check_event_color"><input class="me_hide" value="FCD74E"  type="radio" name="user_color"></div>
						<div class="chkcolor_color_8 check_event_color"><input class="me_hide" value="FFB871"  type="radio" name="user_color"></div>
						<div class="chkcolor_color_9 check_event_color"><input class="me_hide" value="FF8678"  type="radio" name="user_color"></div>
						<div class="chkcolor_color_10 check_event_color"><input class="me_hide" value="DE1D1D"  type="radio" name="user_color"></div>
						<div class="chkcolor_color_11 check_event_color"><input class="me_hide" value="DBAAFF"  type="radio" name="user_color"></div>
						<div class="chkcolor_color_12 check_event_color"><input class="me_hide" value="E1E1E1"  type="radio" name="user_color"></div>
					</div>
				</div>
			</div>
			<div class="sdd_panel">
				<div class="sdd_panel_save button"><input type="button" value="Submit" class="full_event_edit"></div>
				<div class="sdd_panel_discard"><input type="button" value="Cancel"></div>
				<div class="event_exit"><a href="#"></a></div>
				<?php echo $this->Html->image('ajax-loader.gif', array('class' => 'loader_img me_hide', 'style' => 'margin-top:8px'));?>
			</div>
			<div style="clear:both;"></div>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>