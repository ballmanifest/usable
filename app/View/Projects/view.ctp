<?php   $user_id = $this->Session->read('Auth.User.id');
	echo $this->Html->scriptBlock('var user_id = ' . $user_id . ', users_ids= [], agenda="";');
	echo $this->Html->css(array('ui-lightness/jquery-ui-1.8.23.custom','jquery.mCustomScrollbar.css',  'monthcalendar', 'fancybox/jquery.fancybox.css', 'cabinet', 'projects', 'user_list', 'add_project_member','calendar'));
	echo $this->Html->script(array('monthcalendar', 'jquery-ui-1.8.23.custom.min',  '//maps.google.com/maps/api/js?sensor=false', 'jquery.ui.addresspicker.js', 'timepicker', 'jquery.mousewheel.min', 'jquery.mCustomScrollbar.js', 'multiselect', 'date', 'timespan', 'miniCalendar', 'filocity_validation', 'package_upgrade', 'filocity-dialog-helper', 'filocity-tasks-helper', 'fancybox/jquery.fancybox', 'common', 'link_to_popup',  'eventsList', 'calendar', /*'dashboard',*/ 'projects', 'add_project','add_project_member'), array('inline' => false));
        echo $this->element('calendar_event_edit');
        ?>
<script>
function newEvent()
{
    	$(this).addClass('selected-date-cell');
			$.fancybox({
				href: '#eventPopulateModal',
				width: 550,
				height: 490,
				autoDimensions: false,
				onComplete : function(handler) {
					$('input.my_date_start').datetimepicker('setDate', date);
					$('input.my_date_end').datetimepicker('option', 'minDate', date);
				},
				onStart : function() {
					$('.event_create_popup')[0].reset();
				},
				onClearup : function() {
					$('.event_create_popup')[0].reset();
				},
				onClosed : function() {
					// Update Event List
					$.eventsList('#event_lists').generateList();
					// remove date cell selection
					$('.selected-date-cell').removeClass('selected-date-cell');
				}
			});
}
</script>
<div id="project_page_container" class="me_relative">
	<?php //echo $this->element('add_project', array('auth_id' => $auth_id, 'future_manager' => $get_company_members));?>
	<?php //echo $this->element('add_project_member', array('auth_id' => $auth_id, 'project_member' => $get_company_members, 'project' => $the_project));?>
	<input type="hidden" value="<?php echo $auth_id?>" readonly="readonly" class="auth_id">
	<input type="hidden" value="<?php echo $the_project['Project']['id'];?>" readonly="readonly" class="project_id">
	<input type="hidden" value="<?php echo $the_project['Folder']['id'];?>" readonly="readonly" class="folder_id">
	<input type="hidden" value="<?php echo $company_id;?>" readonly="readonly" class="company_id">
	<div id="board_header">
		<div class="target_and_share me_right">
			<div>Target:&nbsp;&nbsp;<strong><?php echo date('d/m/Y', strtotime($the_project['Project']['end']))?></strong></div>
			<div><?php echo $this->Html->link('Share<span class="expand_icon"></span>', array('controller' => 'shares', 'action' => 'index'), array('escape' => false)); ?></div>
		</div>
		<div class="project_page_header">
			<span class="project_main_title"><?php echo $the_project['Project']['name'];?></span><br>
			<span class="project_page_admin">By <?php echo $the_project['User']['first_name']. ' ' . $the_project['User']['last_name'];?> on <?php echo date('d/m/Y', strtotime($the_project['Project']['created']));?></span>
		</div>
	</div>        
	<div id="project_files_members_and_budget" class="me_left">
		<div class="projects_segment">                   
			<div class="header_title"><a style="margin:0;float:right;" href= "<?php echo $this->webroot; ?>projects/add/<?php echo $the_project['Project']['id'];  ?>" data-width="415" data-height="386" class="fancyboxFrame">New</a><span class="title">My Projects</span></div>
			<div class="files_list">                            
				<ul class="files">
					<?php foreach($active_projects as $active_project):?>
                                    <li <?php if($project_id==$active_project['Project']['id']){  ?> style="background-color:#d9ebf8;"  <?php } ?> >
                                        <?php // #05b4e8 echo $this->Html->link($active_project['Project']['name'], array( 'controller' => 'projects', 'action' => 'view', $active_project['Project']['id']));?>
                                    <a <?php if($project_id==$active_project['Project']['id']){  ?> style="color:#0c203f;"  <?php } ?> href="<?php echo $this->webroot;?>projects/view/<?php echo  $active_project['Project']['id'] ;?>"><?php echo $active_project['Project']['name']; ?></a>
                                    </li>
					<?php endforeach;?>
				</ul>
			</div>
		</div>
<!--		<div class="files_segment">
			<div class="header_title">
				<span class="title">Recent Proj. Files</span>
				<span class="add_project_file_button" style="text-decoration: none; color: #39A2EC; float:right;">
					<?php echo $this->Html->link('Add', $this->Html->url(array('controller' => 'cabinets', '?' => array('project_' . $the_project['Project']['id'] => $the_project['Folder']['id'] ), '#' => 'multipleUpload'), true));?>
				</span>
				<span class="expand_icon"></span>
			</div>
			<div class="files_list">
				<ul class="files">
					<?php 
//						foreach($get_project_files as $key => $my_file):
//							if($key < 10):
					?>
							<li class="list_view_each_item" style="line-height: 20px;">
							<?php 
//									$doc_id = $my_file['Document']['id'];;
//									$fullname = $my_file['Document']['file'];
//									$part = explode('.', $fullname);
//									$name = $part[0];
//									$ext = $part[1];
//									$count = strlen($my_file['Document']["name"]);
//									$name = $my_file['Document']["name"];
//									if($count >=21) {
//										$name = substr($my_file['Document']["name"],0,21) . "...";
//									}
//									
//									if(in_array(strtolower($ext), array('jpg', 'jpeg', 'png', 'gif'))) {
//										$img_ico = $this->Html->image("?img=/imagecache/".$fullname."&height=16&cropratio=2:2", array('class' => 'img_ico'));
//										echo $img_ico . ' ' . $this->Html->link($name, 'javascript:void(0)', array('class' => 'image_view', 'data-relatedthumb' => 'img_' . $doc_id ));
//										$view = '../img/?img=/imagecache/'.$fullname.'&height=800';
//										$image = $fullname;
//										$img =  $this->Html->image('?img=/imagecache/'.$fullname.'&height=173', array());
//										echo $this->Html->link($img, array('action' =>$view),array('class'=>'me_hide fancybox img_' . $doc_id,'escape'=>false,'rel'=>'gallery',)); 
//									} elseif(in_array(strtolower($ext), array('doc', 'docx', 'pdf', 'txt'))) {
//										$img_ico = $this->Html->image($ext . ".png", array());
//										echo $img_ico . ' ' . $this->Html->link($name,array('controller' => 'documents', 'action' => 'view', 'id' => $doc_id), array('target' => '_blank', 'class' => '', 'data-relatedthumb' => $ext . '_' . $doc_id ));
//									}
							?>
							</li>
					<?php 
//							endif;
//						endforeach;
					?>
					<li class="add_files"><a href="#">+add files</a></li>
				</ul>
			</div>
		</div>-->
		<div class="members_segment">
			<div class="header_title"><span class="title">Project Members</span><span class="add_project_member_button"><a style="text-decoration: none; color: #39A2EC; float:right" href="javascript:void(0);">Add</a></span><?php echo $this->Html->image('ajax-loader.gif', array('width' => '16', 'height' => '16', 'class' => 'loader_img me_hide'));?><!--<span class="expand_icon"></span>--></div>
			<div class="members_list">
				<ul class="members">
					<?php 
						foreach($get_project_members as $project_member):
					?>
					<li>
						<?php echo $this->Html->link($project_member['User']['first_name']. ' ' . substr(ucfirst($project_member['User']['last_name']),0,1) . '. ', array('controller' => 'users', 'action' => 'resources', 'member', $project_member['User']['id']), array('class' => 'member_name'));?>
						<span class="member_role"><?php echo $project_member['User']['role'] == 1 ? '(admin)' : '';?></span>
						<?php 
							echo $this->Html->link('files', array('controller' => 'document', 'action' => 'index'), array('class' => 'member_file'));
							echo $this->Html->link('tasks', array('controller' => 'users', 'action' => 'resources/member', $project_member['User']['id']), array('class' => 'member_task'));
						?>
					</li>
					<?php
						endforeach;
					?>
					<!--<li class="add_members"><a href="#">+add members</a></li>-->
				</ul>
			</div>
		</div>
		<div class="tasks_segment">
			<div class="header_title">
				<span class="title">Tasks</span>
				<span style="text-decoration: none; color: #39A2EC; float:right;"><?php echo $this->Html->link('Manage', array('controller' => 'users', 'action' => 'resources', 'project', $the_project['Project']['id'])); ?></span>
				<!--
				<a class="all_tasks link_selected me_right" href="#">all tasks</a>
				<a class="mine_tasks me_right selected" href="#">mine</a>
				-->
			</div>
			<div class="tasks_list_container">
				<ul class="tasks_list">
					<?php foreach($get_project_tasks as $project_task): ?>
					<li class="each_task <?php echo ($project_task['Task']['user_id'] != $auth_id) ? 'me_hide' : ''?>" data-taskid="<?php echo $project_task['Task']['id'];?>" data-userid="<?php echo $project_task['Task']['user_id'];?>">
						<?php echo $project_task['Task']['description']; ?> <span class="task_owner"><?php echo $project_task['Task']['owner'];?></span>
					</li>
					<?php endforeach;?>
					<!--
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
					-->
					<!--<li class="add_tasks"><span class="add_new_blue_button add_project_button" style="width:60px"><a href="#">Manage</a></span><span class="cabinet_icon">&nbsp;</span></li>-->
				</ul>
			</div>
		</div>
<!--		<div class="budgets_segment ">
			<div class="header_title">
				<span class="title">Budget</span>
				<span class="add_project_button" style="color: #39A2EC; float:right;"><a href="#">Manage</a></span>
			</div>
			<div class="budgets_list_container">
				<ul class="budgets_list">
					<table>
						<tbody>
                                                    
                                                    <tr>
								<td class="budget_sector"><?php echo $project_manager_details['User']['first_name'].' '.substr(ucfirst($project_manager_details['User']['last_name']),0,1).'..'; ?></td>
								<td class="indicator_bar">
									<div class="me_relative data_progress task_completion_bar">
										<span data-completed="2" data-total="3" class="progress_percentile"></span>
									</div>
								</td>
								<td class="percentile">0%</td>
							</tr>
							  <?php  foreach($get_project_users as $get_project_user) { ?>
                                                    
							<tr>
								<td class="budget_sector"><?php echo $get_project_user['User']['first_name'].' '.substr(ucfirst($get_project_user['User']['last_name']),0,1).'..'; ?></td>
								<td class="indicator_bar">
									<div class="me_relative data_progress task_completion_bar">
										<span data-completed="<?php echo $get_project_user['ProjectsUser']['budget'] ;?>" data-total="<?php echo $get_project_user['Project']['budget'] ;?>" class="progress_percentile"></span>
									</div>
								</td>
								<td class="percentile">0%</td>
							</tr>
                                                        <?php } ?>
						</tbody>
					</table>
				</ul>
			</div>
		</div>-->
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
		<!-- Recent File Box for Viewing Projects -->
		<div id="recent_file_box_for_current_projects">
			<div class="file_box_title">
				     <span style="margin-left:330px;position: absolute;">
                                         <?php echo $this->Html->link('Add', $this->Html->url(array('controller' => 'cabinets', '?' => array('project_' . $the_project['Project']['id'] => $the_project['Folder']['id'] ), '#' => 'multipleUpload'), true),array('class'=>'file_cabinet') );?>
                                         
                                     </span>
                            
                                   <?php  echo $this->Html->link('File Cabinet<span class="cabinet_icon">&nbsp;</span>', $this->Html->url(array('controller' => 'cabinets', '?' => array('project_' . $the_project['Project']['id'] => $the_project['Folder']['id'] )), true), array('class' => 'file_cabinet', 'escape' => false));?>
					<div class="title me_right">Recent Project Files</div>
				<div class="small_folder_img me_left">
					<?php echo $this->Html->image('big-folder.png', array('width' => '25', 'height' => '20'))?>
				</div>
			</div>
			 <ul class="files">
					<?php //echo "<pre>";print_r($get_project_files);exit;
						foreach($get_project_files as $key => $my_file):							 
					?>
							<li class="list_view_each_item" style="line-height: 20px;">
							<?php 
									$doc_id = $my_file['Document']['id'];;
									$fullname = $my_file['Document']['file'];
									$part = explode('.', $fullname);
									$name = $part[0];
									$ext = $part[1];
									$count = strlen($my_file['Document']["name"]);
									$name = $my_file['Document']["name"];
									if($count >=21) {
										$name = substr($my_file['Document']["name"],0,21) . "...";
									}
									
									if(in_array(strtolower($ext), array('jpg', 'jpeg', 'png', 'gif'))) {
										$img_ico = $this->Html->image("?img=/imagecache/".$fullname."&height=16&cropratio=2:2", array('class' => 'img_ico'));
										echo $img_ico . ' ' . $this->Html->link($name, 'javascript:void(0)', array('class' => 'image_view', 'data-relatedthumb' => 'img_' . $doc_id ));
										$view = '../img/?img=/imagecache/'.$fullname.'&height=800';
										$image = $fullname;
										$img =  $this->Html->image('?img=/imagecache/'.$fullname.'&height=173', array());
										echo $this->Html->link($img, array('action' =>$view),array('class'=>'me_hide fancybox img_' . $doc_id,'escape'=>false,'rel'=>'gallery',)); 
									} elseif(in_array(strtolower($ext), array('doc', 'docx', 'pdf', 'txt'))) {
										$img_ico = $this->Html->image($ext . ".png", array());
										echo $img_ico . ' ' . $this->Html->link($name,array('controller' => 'documents', 'action' => 'view', 'id' => $doc_id), array('target' => '_blank', 'class' => '', 'data-relatedthumb' => $ext . '_' . $doc_id ));
									}
							?>
							</li>
					<?php 
							
						endforeach;
					?>
					<!--<li class="add_files"><a href="#">+add files</a></li>-->
				</ul>
                       
		</div>
		<div id="notice_board" class="me_left">
			<div class="notice_wrapper">
				<div class="header_title notice_title">
					<div class="notice_sorting_tools">
						<span class="notice_sorting"><span class="sort_by descending_sort">Sort by: <strong>Date</strong></span></span>
						<span class="sorting_type_n_member"><a href="" class="member_file">Type</a><a href="" class="member_task">Member</a></span>
					</div>
					<span class="title">Notices</span>
				</div>
				
				<div class="notices_container">
					<ul class="notice">
						<?php foreach($get_notices as $notice){?>
							<li class="each_notice notice_<?php echo $notice['Notice']['id']; ?> notice_type_<?php echo $notice['Notice']['notice_type']; ?>" data-id="<?php echo $notice['Notice']['id']; ?>" data-noticetype="<?php echo $notice['Notice']['notice_type']; ?>">
								<p>
									<?php echo htmlspecialchars_decode($notice['Notice']['message']); ?>
								</p>
								<p class="more_todo">
									<!--<a class="fancyboxComment see_comment" data-commenttype="notice" data-targetid="<?php echo $notice['Notice']['id']; ?>" href="#">comment</a>-->
									<?php echo $this->Html->link('comments', array('controller' => 'comments', 'action' => 'notice_comment', $notice['Notice']['id']), array('data-commenttype' => 'notice', 'data-targetid' => $notice['Notice']['id'], 'class' => 'fancyboxComment see_comment'));?>
									<a href="">share</a>
									<a href="">view all</a>
									<a href="">edit as pdf</a>
								</p>
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
		<div id="miniCalendar"></div>
		<!--<div id="event_calendar">
			<?php
				//$this->loadHelper("MiniCalendars");
				//echo $this->MiniCalendars->drawCalendar(); 
			?>-->
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
                         <a href="#"  onclick="newEvent();" >New</a>
                         
		</div>
		<div id="event_list_container">
			<ul id="event_lists"></ul>
		</div>
	</div>
</div>
<!------------------------------------------------------ 
    Dialog
------------------------------------------------------->
<div id="dialog" title="Dialog" class="dialog hide">
    <p></p>
</div>
