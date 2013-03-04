<?php	
	echo $this->Html->scriptBlock('var user_id = ' . $user_id . ', users_ids= [], agenda = "'. $agenda .'";');
	echo $this->Html->css( array('ui-lightness/jquery-ui-1.8.23.custom', 'monthcalendar', 'timepicker', 'fancybox/jquery.fancybox.css', 'calendar') );
	echo $this->Html->script( array('monthcalendar', 'fancybox/jquery.fancybox', 'jquery-ui-1.8.23.custom.min', '//maps.google.com/maps/api/js?sensor=false', 'jquery.ui.addresspicker.js', 'timepicker', 'date', 'eventsList', 'calendar') );
?>
	
<!-- page content go here -->
<!--pop up mennu for squire-->

<div class="space_popup me_absolute the_popup">
	<?php 
		echo $this->Form->create('CalendarEvent', array('id' => false, 'class' => 'event_create_popup', 'inputDefaults' => array('id' => false, 'div' => false, 'label' => false))); 
		echo $this->Form->input('user_id', array('type' => 'hidden', 'value' => $this->Session->read('Auth.User.id')));
	?>
	<div class="calendar_space_popup">
		<div class="event_top_bar"></div>
		<div>
			<div class="calender_event_title">
				<span>Events</span>&nbsp;|&nbsp;<span class="appointment">Appointment Slots</span>
			</div>
			<div class="calender_cross"><div class="btn_container me_absolute"><div class="btn_wrapper"><div class="btn_self"><span class="cross_icon">&nbsp;</span></div></div></div></div>
		</div>		
		<div class="calender_event_time">
			<div class="calender_when">When:</div>
			<div class="calendar_date">Mon, Octobor 15, 7am-8am</div>
			<?php
				echo $this->Form->input('date_start', array('type' => 'text', 'class' => 'date_start', 'div' => array('class' => 'me_hide'))); 
			?>
		</div>
		<div class="calender_event_what">
			<div class="calender_what">What:</div>
			<div class="calendar_input">
				<?php
					echo $this->Form->input('title', array('type' => 'text', 'class' => 'event_title'));
				?>
				<p>e.g., Breakfast at Tiffany's</p>
			</div>
		</div>
		<div class="calendar_owner">
			<div class="owner_name">Calendar:</div>
			<div class="select_owner">
				<?php
					echo $this->Form->input('calendar_id', array('type' => 'select', 'options' => $calendars, 'class' => 'calendar_owner_list'));
				?>
			</div>
		</div>
		<div class="calendar_event_action">
			<div class="calender_submit">
				<input type="submit" value="Create event" class="calendar_event_submit">
			</div>
			<div class="calendar_event_edit"><a href="#"><span>Event edit &gt;&gt;</span></a></div>
		</div>
		<div class="event_bottom_bar"></div>
	</div>
	<?php echo $this->Form->end(); ?>
</div>
<!-- squire end-->
<!--Event click pop up-->
<div class="event_display_popup me_absolute the_popup">
	<div class="calendar_event_popup">
			<div>
				<div class="calender_event_heading">
					<div class="event_click_button"></div>
					<span class="event_title">Bryan's Test Event</span>
				</div>
				<div class="calender_cross"><div class="btn_container me_absolute"><div class="btn_wrapper"><div class="btn_self"><span class="cross_icon">&nbsp;</span></div></div></div></div>
			</div>		
			<div class="calender_event_when">
				<div class="event_time">Mon, Octobor 15, 7am-8am</div>
			</div>
			<div class="calendar_event_where">
				<div class="event_location">NYC Appartment &nbsp;<a href="#">map</a></div>
			</div>
			<div class="calendar_action">
				<div class="calender_delete">
					<input type="submit" value="Delete" class="calendar_event_delete">
				</div>
				<div class="calendar_edit"><a href="#">Event edit >></a></div>
			</div>
		<div class="event_separator"></div>
	</div>
		<div class="event_bar"></div>
</div>	
<!--Event click end-->
<!--Edit event menu-->
<?php echo $this->element('calendar_event_edit');?>
<!--End edit event-->

<div class="calender_container">
	<div id="calendar_sidebar">
		<div id="miniCalendar"></div>
		<a href="#" class="title" id="add_event_button">Add Event</a>
		<a href="#" class="title" id="my_calendar_button">My Calendar</a>
		<div class="panel">
			<div class="title">
				<div style="float:right;">
					<span id="users_calendars_count" style="float:left;"><?php echo count($users);?></span><span class="icon down-arrow" style="margin:5px 0 0 3px;"></span>
				</div>
				Users Calendars
			</div>
			
			<div class="content">
				<ul id="users-calenders-list">
					<?php /*
					<li><a class="icon checkbox" href="#" data-for-checkbox-id="1"></a><input type="checkbox" data-checkbox-id="1" style="display:none;" checked="checked" /> Thaler, Doug</li>
					<li><a class="icon checkbox" href="#" data-for-checkbox-id="2"></a><input type="checkbox" data-checkbox-id="2" style="display:none;" /> Potts, Bryan</li>
					*/ ?>

					<?php for($i=0, $iCount=count($users);$i<$iCount;$i++){ ?>
					<li><a class="icon checkbox" href="#" data-for-checkbox-id="<?php echo $users[$i]['User']['id'];?>"></a><input type="checkbox" data-cal-user-id="<?php echo $users[$i]['User']['id'];?>" data-checkbox-id="<?php echo $users[$i]['User']['id'];?>" style="display:none;" <?php if($user_id==$users[$i]['User']['id']) echo 'checked="checked"';?> value="<?php echo ' ',$users[$i]['User']['first_name'],' Calendar';?>"/> <?php echo $users[$i]['User']['last_name'],', ',$users[$i]['User']['first_name'];?></li>
					<?php if($user_id==$users[$i]['User']['id']) echo '<input type="hidden" id="main_user" value="'.$users[$i]['User']['first_name'],' Calendar'.'">';?> 
					<?php } ?>
				</ul>
			</div>
		</div>
		<div class="title">
			<div style="float:right;">
				<span id="event_tasks_count" style="float:left;">1</span><span class="icon down-arrow" style="margin:5px 0 0 3px;"></span>
			</div>
			Event Tasks
		</div>
		<div href="#" class="title">Event Files</div>
	</div>
	<div id='calender_name'></div>
	<div id="calender_body" class="calender_body">
	
		<div id='calendar'></div>
	</div>
</div>
<div class="calender_footer me_relative"></div>
<!--End Calendar-->
<div id="map_picker_container" class="me_absolute the_popup" style="display:none;">
	<div class='input'>
	    <label>Address : </label> <input id="addresspicker_map" />   <br/>
			<label>Locality: </label> <input id="locality" disabled=disabled> <br/>
			<label>District: </label> <input id="administrative_area_level_2" disabled=disabled> <br/>
			<label>State/Province: </label> <input id="administrative_area_level_1" disabled=disabled> <br/>
			<label>Country:  </label> <input id="country" disabled=disabled> <br/>
			<label>Postal Code: </label> <input id="postal_code" disabled=disabled> <br/>
			<label>Lat:      </label> <input id="lat" disabled=disabled> <br/>
			<label>Lng:      </label> <input id="lng" disabled=disabled> <br/>
      <label>Type:     </label> <input id="type" disabled=disabled /> <br/>
    </div>
    <div id="map"></div>
	<div style="text-align:right;">
		<a id="map_picker_ok_button" href="#">ok</a>
		<a id="map_picker_cancel_button" href="#">cancel</a>
	</div>
</div>