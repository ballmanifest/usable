<?php
	echo $this->Html->css(array('jquery.mCustomScrollbar.css','projects', 'user_list', 'add_project_member'));
	echo $this->Html->script(array('jquery-ui-1.8.23.custom.min', 'jquery.mousewheel.min.js', 'jquery.mCustomScrollbar.js','date', 'timespan', 'miniCalendar', 'eventsList', 'user_list', 'projects', 'add_project', 'add_project_member'));
?>
<div id="project_page_container" class="me_relative">
	<?php echo $this->element('add_project', array('auth_id' => $auth_id, 'future_manager' => $get_company_members));?>
	<?php echo $this->element('add_project_member', array('auth_id' => $auth_id, 'project_member' => $get_company_members));?>
	<div id="board_header">
		<div class="target_and_share me_right">
			<div>Target:&nbsp;&nbsp;<strong>11/15/12</strong></div>
			<div><?php echo $this->Html->link('Share<span class="expand_icon"></span>', array('controller' => 'shares', 'action' => 'index'), array('escape' => false)); ?></div>
		</div>
		<div class="project_page_header">
			<span class="project_main_title">Project Page Revamp</span><br>
			<span class="project_page_admin">By Bryan Potts on 9/12/12</span>
		</div>
	</div>        
	<div id="project_files_members_and_budget" class="me_left">
		<div class="projects_segment">
			<div class="header_title"><span class="add_new_blue_button add_project_button">New</span><span class="title">My Projects</span></div>
			<div class="files_list">
				<ul class="files">
					<?php foreach($active_projects as $project):?>
					<li><?php echo $this->Html->link($project['name'], array('controller' => 'projects', 'action' => 'view', $project['id']));?></li>
					<?php endforeach;?>
				</ul>
			</div>
		</div>
		<div class="files_segment">
			<div class="header_title"><span class="title">Recent Project Files</span><span class="expand_icon"></span></div>
			<div class="files_list">
				<ul class="files">
					<li><a href="#">Modal-Projects-1.jpg</a></li>
					<li><a href="#">New-Proj-Page-Ideas.pdf</a></li>
					<li><a href="#">Modal-All-Views.pdf</a></li>
					<li><a href="#">Proj-page-mock.psd</a></li>
					<li class="add_files"><a href="#">+add files</a></li>
				</ul>
			</div>
		</div>
		<div class="members_segment">
			<div class="header_title"><span class="title">Project Members</span><span class="expand_icon"></span></div>
			<div class="members_list">
				<ul class="members">
					<li><a class="member_name">Bryan Potts</a><span class="member_role">(admin)</span><a href="#" class="member_file">files</a><a href="#" class="member_task">tasks</a></li>
					<li><a class="member_name">Doug Thaler</a><span class="member_role">(admin)</span><a href="#" class="member_file">files</a><a href="#" class="member_task">tasks</a></li>
					<li><a class="member_name">Abdullah Yousuf</a><a href="#" class="member_file">files</a><a href="#" class="member_task">tasks</a></li>
					<li><a class="member_name">Cesar Espinosa</a><a href="#" class="member_file">files</a><a href="#" class="member_task">tasks</a></li>
					<li class="add_members"><a href="#">+add members</a></li>
				</ul>
			</div>
		</div>
		<div class="tasks_segment">
			<div class="header_title">
				<span class="title">Tasks</span>
				<a class="all_tasks link_selected me_right" href="#">all tasks</a>
				<a class="mine_tasks me_right" href="#">mine</a>
			</div>
			<div class="tasks_list_container">
				<ul class="tasks_list">
					<li class="each_task selected_task completed_task">
						Create HTML/CSS code for projectpage mockups. <span class="task_owner">AY</span>
					</li>
					<li class="each_task">
						Generate some ideas of your own for once...jk. <span class="task_owner">AY</span>
					</li>
					<li class="each_task declined_task">
						Test the site and report how bad.<span class="task_owner">BP</span>
					</li>
					<li class="each_task completed_task">
						Create HTML/CSS code for projectpage mockups. <span class="task_owner">AY</span>
					</li>
					<li class="each_task completed_task">
						Create HTML/CSS code for projectpage mockups. <span class="task_owner">AY</span>
					</li>
					<li class="each_task">
						Test the site and report how bad.<span class="task_owner">BP</span>
					</li>
					<li class="each_task">
						Generate some ideas of your own for once...jk. <span class="task_owner">AY</span>
					</li>
					<li class="add_tasks"><a href="#">manage tasks</a><span class="cabinet_icon">&nbsp;</span></li>
				</ul>
			</div>
		</div>
		<div class="budgets_segment">
			<div class="header_title">
				<span class="title">Budget</span>
			</div>
			<div class="budgets_list_container">
				<ul class="budgets_list">
					<table>
						<tbody>
							<tr>
								<td class="budget_sector boldify">Project</td>
								<td class="indicator_bar">
									<div class="me_relative data_progress task_completion_bar">
										<span data-completed="2" data-total="3" class="progress_percentile"></span>
									</div>
								</td>
								<td class="percentile">0%</td>
							</tr>
							<tr>
								<td class="budget_sector">Bryan P.</td>
								<td class="indicator_bar">
									<div class="me_relative data_progress task_completion_bar">
										<span data-completed="5" data-total="10" class="progress_percentile"></span>
									</div>
								</td>
								<td class="percentile">0%</td>
							</tr>
							<tr>
								<td class="budget_sector">Abdullah.</td>
								<td class="indicator_bar">
									<div class="me_relative data_progress task_completion_bar">
										<span data-completed="3" data-total="15" class="progress_percentile"></span>
									</div>
								</td>
								<td class="percentile">0%</td>
							</tr>
							<tr>
								<td class="budget_sector">Doug T.</td>
								<td class="indicator_bar">
									<div class="me_relative data_progress task_completion_bar">
										<span data-completed="23" data-total="24" class="progress_percentile"></span>
									</div>
								</td>
								<td class="percentile">0%</td>
							</tr>
							<tr>
								<td colspan="3" class="add_tasks"><a href="#">manage budget</a><span class="cabinet_icon">&nbsp;</span></td>
							</tr>
						</tbody>
					</table>
				</ul>
			</div>
		</div>
	</div>
	<div id="events_and_notice_container" class="me_left">
		<!--
		<div id="board_header">
			<div class="target_and_share me_right">
				<div>Target:&nbsp;&nbsp;<strong>11/15/12</strong></div>
				<div><?php echo $this->Html->link('Share<span class="expand_icon"></span>', array('controller' => 'shares', 'action' => 'index'), array('escape' => false)); ?></div>
			</div>
			<div class="project_page_header">
				<span class="project_main_title">Project Page Revamp</span><br>
				<span class="project_page_admin">By Bryan Potts on 9/12/12</span>
			</div>
		</div>
		-->
		<div id="notice_board" class="me_left">
			<div class="notice_wrapper">
				<div class="header_title notice_title">
					<span class="title">Notices</span>
					<a href="#" class="file_cabinet">File Cabinet<span class="cabinet_icon">&nbsp;</span></a>
					<span class="notice_sorting"><span class="sort_by descending_sort">Sort by: <strong>Date</strong></span></span>
					<span class="sorting_type_n_member"><a href="" class="member_file">Type</a><a href="" class="member_task">Member</a></span>
				</div>
				
				<div class="notices_container">
					<ul class="notice">
						<?php foreach($get_notices as $notice){?>
							<li class="each_notice notice_<?php echo $notice['Notice']['id']; ?> notice_type_<?php echo $notice['Notice']['notice_type']; ?>" data-id="<?php echo $notice['Notice']['id']; ?>" data-noticetype="<?php echo $notice['Notice']['notice_type']; ?>">
								<p>
									<?php echo htmlspecialchars_decode($notice['Notice']['message']); ?>
								</p>
								<p class="more_todo"><a href="#" onclick="return show_notice_comments_dialog(<?php echo $notice['Notice']['id']; ?>);">comment</a><a href="">share</a><a href="">view all</a><a href="">edit as pdf</a></p>
							</li>
						<?php } ?>
						<?php 
							if( count($get_notices) > 0 ) { 
						?>
							<li class="each_notice" style="list-style: none;"><a href="#" class="load_more">Load More</a></li>
						<?php 
							} else { 
						?>
							<li class="each_notice" style="list-style: none;font-weight: bold; font-size: 13px; border: none; color: #1F5175">No Available Notice to show.</li>
						<?php
							}
						?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div id="dates_and_events" class="me_left">
		<div id="event_calendar">
			<?php
				$this->loadHelper("MiniCalendars");
				echo $this->MiniCalendars->drawCalendar(); 
			?>
			<div id="events_to_a_date">
				<div class="event_date clearfix">
					<div class="the_date me_left" data-date="Sep. 22nd"><?php echo date('M. dS');?></div>
					<div class="d_m_y me_left">
						<span>Days</span>
						<span>Months</span>
						<span>Years</span>
					</div>
				</div>
			</div>
			<div id="members_and_event">
				<ul class="members_event_list">
				</ul>
			</div>
			<div id="more_calender_with_expand_view" class="clearfix">
				<div class="add_calender handler_to_user_list me_left">+ add another calendar</div>
				<?php 
					echo $this->Html->link(
						'Expand<span class="expand_icon"></span>',
						array('controller' => 'calendars', 'action' => 'index'),
						array('escape' => false, 'class' => 'expand_view me_left')
					);
				?>
			</div>
			<div class="user_add_to_calendar">
				<?php
					echo $this->element('user_list', array('users' => $get_users_has_calendar));
				?>
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
</div>