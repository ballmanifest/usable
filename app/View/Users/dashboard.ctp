<?php
	$user_id = $this->Session->read('Auth.User.id');
	echo $this->Html->scriptBlock('var user_id = ' . $user_id . ', users_ids= [], agenda="";');
	echo $this->Html->css( array('ui-lightness/jquery-ui-1.8.23.custom', 'monthcalendar', 'timepicker', 'calendar') );
	echo $this->Html->css(array('jquery.mCustomScrollbar.css', 'dashboard', 'user_list', 'package_upgrade', 'filocity-dialog-helper', 'filocity-tasks-helper', 'fancybox/jquery.fancybox.css'));
	echo $this->Html->script( array('monthcalendar', 'jquery-ui-1.8.23.custom.min', 'timepicker', 'date', 'eventsList', 'share_modal') );
	echo $this->Html->script(array('jquery.mousewheel.min', 'jquery.mCustomScrollbar.js', 'plupload.full.js', 'multiselect', 'timespan', 'miniCalendar', 'filocity_validation', 'package_upgrade', 'filocity-dialog-helper', 'filocity-tasks-helper', 'fancybox/jquery.fancybox', 'common', 'link_to_popup', 'calendar', 'dashboard'), array('inline' => false));
	App::uses('CakeTime', 'Utility');
	App::uses('Sanitize', 'Utility');
	App::uses('File', 'Utility');
?>
<!--Edit event menu-->
	<?php echo $this->element('calendar_event_edit', array('allEmails' => $allEmails));?>
<!--End edit event-->
<?php
	$cur_user_data_used = 0;
	if (!empty($user['Document'])) {
		$cur_user_data_used = ceil((int) $user['Document'][0]['Document'][0]['total_used']);
	}
	echo $this->element('package_upgrade', array('packages' => $all_available_packages, 'cur_user' => $user));
	$package_storage = $user['Company']['Package']['storage'];
?>
<a href="#eventPopulateModal" class="eventPopulateModal me_hide"></a>
<div class="np_m1"></div>
<div class="dashboard_page_container np_m2">
	<div id="events_and_notice_container" class="me_left me_relative">
		<input type="hidden" readonly name="data[User][id]" value="<?php echo $user['User']['id']; ?>" >
		<input type="hidden" readonly name="data[Company][id]" value="<?php echo $user['Company']['id']; ?>" >
		<input type="hidden" readonly name="data[Package][id]" value="<?php echo $user['Company']['package_id']; ?>">

		<input type="hidden" class="package_max_member" readonly value="<?php echo $user['Company']['Package']['max_member']; ?>">
		<div id="board_header">
			<div class="border_header_wrapper">
				<div id="user_profile_image_thumb" class="header_image me_relative">
					<?php
						$path = WWW_ROOT . DS . 'img' . DS . 'filocity_img' . DS . 'user_' . $user['User']['id'] . DS . 'profile.jpg';
						$profile_thumb = $this->Html->url(array('controller' => 'image', 'action' => 'profile', $user['User']['id'], 'thumb.jpg', '?'=> time()), true);
						$file = file_exists($path);
						if($file) {
							echo $this->Html->image($profile_thumb, array('class' => 'my_thumb', 'escape' => false));
						} else {
							echo $this->Html->image('default_profile_thumb.png', array('class' => 'my_thumb', 'width' => '147', 'height' => '166'));
						}
					?>
				</div>
				<!--<button class="change_profile_image_link me_absolute me_hide" id="filePickForProfileThumb">Update photo</button>-->
				<!-- Display Company Admin info -->
				<div class="header_content">
					<h1 class="project_main_title"><?php echo $user['User']['first_name'] . ' ' . $user['User']['last_name']; ?>,&nbsp;<?php echo $user['User']['position']; ?></h1>
					<h2 class="project_page_admin"><?php echo $user['Company']['name']; ?></h2>
					<!-- Section for update company logo -->
					<div class="upload_photo_for_project_and_deal_room">
						<h3>Add Company Logo</h3>
						<div class="upload-link"><a href="#" class="upload_company_logo">Upload</a></div>
					</div><!-- .upload_photo_for_project_and_deal_room -->
				</div><!-- .header_content -->
				
				<!-- Company Member Count and Data Usage -->
				<div id="member_info_and_data_usage_block" class="db_plan_box">
					<div class="db_plan_box2">
					  <div class="plan"><span>Current Plan:</span> <?php echo ucfirst(strtolower($user['Company']['Package']['public_name'])); ?></div>
					  <div class="plan"><span>Current Plan:</span> <?php echo count($package); ?> user (s), <?php echo $cur_user_data_used; ?> gb &dollar;<?php echo $user['Company']['Package']['price']; ?></div>
					  <div class="plan_user1 member_progress_bar data_progress storage_usage">
						<span class="progress_percentile" data-total="<?php echo $user['Company']['Package']['max_member']; ?>" data-completed="<?php echo count($package); ?>"></span>
					  </div>
					  <p><?php echo count($package); ?> of <?php echo $user['Company']['Package']['max_member']; ?> useres.</p>
					  <div class="plan_user1 storage_usage_by_user data_progress storage_usage">
						<span class="progress_percentile" data-total="<?php echo $package_storage; ?>" data-completed="<?php echo $cur_user_data_used; ?>"></span>
					  </div>
					  <p><?php echo $cur_user_data_used; ?> of <?php echo $package_storage; ?> gb.</p>
					  <div class="upgrade"><a href="#packageUpgradeModal" class="packageUpgradeModal upgrade_user_package">Upgrade</a></div>
					</div>
					<!-- Two links: Manage Member and Price Info -->
					<ul class="db_plan_box3">
						<li><?php echo $this->Html->link('Manage Members', array('controller' => 'contacts'));?></li>
						<li><?php echo $this->Html->link('Payment Information', array('controller' => 'users', 'action' => 'pricing_info'), array('class' => 'pricingInfoModalLink'));?></li>
					</ul><!-- #manage_member_and_price_info_links -->
				</div><!-- #member_info_and_data_usage_block -->
			</div>
		</div>
		<div class="db_body2">
			<div id="notice_board" class="db_body2_left">
				<h1 class="title">My Recent Activity</h1>
				<div class="notices_container db_body2_mra">
				<?php
					$display_date = '';
					foreach($activities_by_date as $dateToShow => $activities):
						$display_date = $dateToShow;
						echo '<div class="my_recent_activities">';
							echo '<div class="recent_act_date '. (CakeTime::isToday($display_date) ? 'today' : '') .'">'. CakeTime::format('d M, Y', $display_date) .'</div>';
							foreach($activities as $activity):
								echo htmlspecialchars_decode($activity['Notice']['short_message']);
							endforeach;
						echo '</div>';
					endforeach;
				?>
				</div>
			</div>
			<div id="project_files_members_and_budget" class="me_right me_relative">
				<div class="files_segment">
					<div class="header_title map_pan">
						<h1 class="title">My Active Projects</h1>
						<div class="adnew">
						<?php echo $this->Html->link($this->Html->image('new_btn.png'), array('controller' => 'projects', 'action' => 'add'), array('escape' => false, 'class' => 'add_new_blue_button add_project_button fancyboxFrame', 'data-width' => '415', 'data-height' => '386'));?>
						</div>
					</div>
					<div class="db_body2_map">
						<?php
						if (!empty($my_active_projects)):
							foreach ($my_active_projects as $project) {
								?>
								<div class="each_active_project_holder">
								<div class="pre_vamp_title">
									<div class="pre_vamp">
										<h2><?php echo $project['name'];?></h2>
										<?php echo $this->Html->link($this->Html->image('openproj.png'), array('controller' => 'projects', 'action' => 'view', $project['id']), array('escape' => false));?>
									</div>
									<!-- <div class="pre_vamp_date">(<?php echo $project['start']; ?>)</div> -->
								</div>
								<div class="active_member_list md6">
									<div class="active_member"><span>Members:&nbsp;</span><?php echo $project['members']; ?></div>
									<div class="member_task"><span>Tasks:</span><?php echo $project['tasks']; ?></div>
									<div class="completion">Complete:</div>
									<!-- <div class="data_progress task_completion_bar">
									<span class="progress_percentile" data-total="<?php echo $project['slider']['total']; ?>" data-completed="<?php echo $project['slider']['completed']; ?>">0%</span>
									</div> -->
								</div>
								</div>
								<?php
							}
						else:
						?>
							<p class="noActivity">No projects yet!</p>
						<?php
						endif;
						?>
					</div>
				</div>
				<!---->
				<div class="tasks_segment">
					<div class="header_title map_pan">
						<h1 class="title">My Top Tasks</h1>
						<div class="adnew"><?php echo $this->Html->link('<span class="add_new_blue_button add_task_button" data-show-task="0">' . $this->Html->image('new_btn.png') . '</span>', 'javascript::void(0)', array('escape' => false, 'class' => 'add_new_blue_button add_task_button'));?></div>
						<div class="adnew"><?php echo $this->Html->link($this->Html->image('all_tasks_btn.png'), array('controller' => 'users', 'action' => 'resources'), array('escape' => false, 'class' => 'all_tasks link_selected me_right'));?></div>
					</div>
					<div class="tasks_list_container db_body2_map">
						<?php if (!empty($my_top_tasks['tasks'])): ?>
						<ul class="tasks_list">
						<?php
						for ($i = 0, $iCount = count($my_top_tasks['tasks']); $i < $iCount; $i++) {
							$task_id = $my_top_tasks['tasks'][$i]['Task']['id'];
							?>
							<li class="each_task selected_task completed_task db_body2_map2">
								<div class="md8">
									<h4 class="task_description_summary"><?php echo $my_top_tasks['tasks'][$i]['Task']['title']; ?></h4>
									<p><a class="comments-link" data-show-task-comments="<?php echo $task_id; ?>" href="#">Comments(<span data-count-task-comments="<?php echo $task_id; ?>"><?php echo isset($my_top_tasks['num_comments'][$task_id]) ? $my_top_tasks['num_comments'][$task_id] : 0; ?></span>)</a>&nbsp;<a href="#" data-show-task="<?php echo $task_id; ?>">View</a></p>
								</div>
							</li>
						<?php }
						?>
						</ul>
					<?php else: ?>
						<p class="noActivity">No tasks yet!</p>
				<?php endif; ?>
					</div>
				</div>
				<!---->
				<div class="tasks_segment">
					<div class="header_title map_pan">
						<h1 class="title">My Recent Files</h1>
						<div class="adnew"><?php echo $this->Html->link('<span class="add_new_blue_button add_task_button" data-show-task="0">' . $this->Html->image('new_btn.png') . '</span>', 'javascript::void(0)', array('escape' => false, 'class' => 'add_new_blue_button add_task_button'));?></div>
						<div class="adnew"><?php echo $this->Html->link($this->Html->image('all_tasks_btn.png'), array('controller' => 'users', 'action' => 'resources'), array('escape' => false, 'class' => 'all_tasks link_selected me_right'));?></div>
					</div>
					<div class="tasks_list_container db_body2_map  db_body2_map_last">
					<?php
					if (!empty($recent_documents)):
						foreach ($recent_documents as $document) {
						$file_name = $document['Document']['name'];
						$file_ext = $document['Document']['ext'];
						$file_created = $document['Document']['created'];
						$view = "../img/?img=/imagecache/" . $document['Document']["file"] . "&height=800";
						$file_modified = $document['Document']['modified'];
						if (!empty($file_ext)) {
							// not display files without extension
							?>

							<div class="end_task_panel db_body2_map2">
								<div class="<?php echo $file_ext; ?>_tag task_tag">
									<span>
									<?php
									$ext = $document['Document']["ext"];
									if (in_array(strtolower($ext), array('jpg', 'jpeg', 'png', 'gif'))) {
										$img = $this->Html->image("?img=/imagecache/" . $document['Document']["file"] . "&height=28&cropratio=2:2", array());
										echo $this->Html->link($img, array('action' => $view), array("class" => "fancybox", "escape" => false));
									} elseif (in_array(strtolower($ext), array('doc', 'docx', 'pdf', 'txt'))) {
										$img = $this->Html->image($ext . ".png", array());
										echo $this->Html->link($img, array("controller" => "documents", "action" => "view", "id" => $document['Document']["id"]), array("target" => "_blank", "class" => "fancybox", "escape" => false));
									}
									?>
									</span>
								</div>
								<div class="end_task_text md10">
									<?php
									$conf = array();
									$action = array();
									if (in_array(strtolower($ext), array('jpg', 'jpeg', 'png', 'gif'))) {
									$action = array('action' => $view);
									} elseif (in_array(strtolower($ext), array('doc', 'docx', 'pdf', 'txt'))) {
									$action = array("controller" => "documents", "action" => "view", "id" => $document['Document']["id"]);
									$conf = array("target" => "_blank");
									}
									?>
									<h4><?php echo Sanitize::html($file_name); ?></h4>
									<p>Added on <?php echo date('M. jS', $this->Time->toUnix($file_created)); ?>, Updated on <?php echo date('M. jS', $this->Time->toUnix($file_modified)); ?></p>
								</div>
							</div>
							<?php
						}
						}
					else:
						?>
						<p class="noActivity">No recent files yet!</p>
				<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- First part start-->
	<div id="dates_and_events" class="np_m2_right">
		<div id="event_calendar" class="calendar">
		<div id="miniCalendar"></div>
		<div id="events_to_a_date">
			<div class="event_date clearfix">
				<div class="d_m_y me_right">
					<span><?php echo $this->Html->link('Days', array('controller' => 'calendars', 'action' => 'index', 'agenda' => 'day'))?></span>
					<span><?php echo $this->Html->link('Weeks', array('controller' => 'calendars', 'action' => 'index', 'agenda' => 'week'))?></span>
					<span><?php echo $this->Html->link('Month', array('controller' => 'calendars', 'action' => 'index', 'agenda' => 'month'))?></span>
				</div>
				<div class="the_date me_left" data-date="Sep. 22nd"><?php echo date('M. dS'); ?></div>
			</div>
		</div>
		<div id="members_and_event">
			<ul class="members_event_list">
			</ul>
		</div>
		<div id="more_calender_with_expand_view" class="clearfix">	
			<?php echo $this->Html->link('Expand<span class="expand_icon"></span>', array('controller' => 'calendars', 'action' => 'index'), array('escape' => false, 'class' => 'expand_view me_right'));?>
			<div class="add_calender handler_to_user_list me_left">+ add another calendar</div>
		</div>
		<div class="user_add_to_calendar">
			<?php echo $this->element('user_list', array('users' => $get_users_has_calendar));?>
		</div>
		</div>
		<div id="event_selection">
		<a href="#" class="my_events selected" data-eventcat="my">My Events</a>
		<a href="#" class="all_events" data-eventcat="all">All Events</a>
		</div>
		<div id="event_list_container">
		<ul id="event_lists"></ul>
		</div>
	</div>
	<!-- First part end-->	
	<!-- Map Picker start -->
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
	<!-- Map Picker end -->
</div>
<div class="np_m3"></div>

<!-- Alert Box -->
<div class="me_hide">
	<div id="fancyAlertBox" class="fancyAlertBox">
		<h5>Message</h5>
		<div class="alert_message"></div>
	</div>
</div>