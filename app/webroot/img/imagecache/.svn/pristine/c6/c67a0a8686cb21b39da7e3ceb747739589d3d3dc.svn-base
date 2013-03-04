<?php
	echo $this->Html->css('members');
	echo $this->Html->script(array('jquery-ui-1.8.23.custom.min','multiselect','resources'), array('inline' => false));
	App::uses('CakeTime', 'Utility');
	App::uses('Sanitize', 'Utility');
?>

<div id="members_and_tasks_container">
                    <?php 
						
						$user_count = count($project_members);
						$member_list = '';
						foreach($project_members as $members){
							foreach($project_members_details as $member_details){
								if ($members['ProjectsUser']['user_id'] == $member_details['User']['id']){
									$user_task_count = 0;
									$user_task_active_count = 0;
									foreach($project_details[0]['Task'] as $user_tasks){
										if ($members['ProjectsUser']['user_id'] == $user_tasks['ownerid']){
											$user_task_count += 1;
											if($user_tasks['status'] == 2 ){
												$user_task_active_count += 1;
											}
										}
									}
                                    $member_list .= '<div class="member">
                                        <div class="photo">
                                            <img src="images/resources_temp/abdullah.jpg" />
                                        </div>
                                        <div class="info">
                                            <a class="name" href="#">'.$member_details['User']['first_name'].' '.$member_details['User']['last_name'].'</a> '.$member_details['User']['position'].'<br />
                                            '.$user_task_count.' tasks assigned, '.$user_task_active_count.' active<br />
                                            Budget Spent: <strong>75%</strong> <a href="#">edit</a>
                                        </div>
                                    </div>';
									
								}
							}
						}
					
					?>
                    
                    
                    
					<div id="board_header">
						<div class="resources_page_header">
							<span>Resources for</span> <span style="color:#5391be;"><?php echo $project_details[0]['Project']['name']; ?></span><br>
						</div>
					</div>
					<div id="active_team_members_container" class="me_left">
						<div class="row">
							<span class="column_title">Active Team Members <a href="#">manage</a></span>
						</div>
						<div class="row">
						Team Members: <strong><?php echo $user_count; ?></strong><br />
						Total Budget Use: <strong>69%</strong>
						</div>
						<div id="members">
							<?php echo $member_list;?>
						</div>
					</div>
					<div id="active_tasks_container">
						<div class="task_header_row">
							<span class="column_title">Active Tasks</span>
						</div>
						<div id="active_tasks">
							
                            <?php
                            //print_r($comments);								
									foreach($project_tasks as $task) {
										if ($task['Task']['status'] != 1) {
											
											if ($task['Task']['id'] == 1){
												$task_color = 'red'	;
											}
											if ($task['Task']['id'] == 2){
												$task_color = 'green';	
											}
											if ($task['Task']['id'] == 3){
												$task_color = 'blue';
											}
											if ($task['Task']['id'] == 4){
												$task_color = 'gray';	
											}
										
										$comment_count = 0;
										$task_comments_list = '';
										
										foreach($comments as $comment) {
											
											$comment_user_name = '';
											if ($task['Task']['id'] == $comment['Comment']['task_id']) {
												$comment_count += 1;
												$task_comments_list .='<li class="activity_list box_radius clearfix">
                                                     <div class="contents">
                                                        <div class="created_at">'.date('M. jS',$this->Time->toUnix($comment['Comment']['created'])).'</div>
                                                        <div class="author">'.$comment['User']['first_name'].'</div>
                                                        <div class="text ">'.$comment['Comment']['comment'].'</div>
                                                        <div class="attachments clearfix" style="display: block;"></div>
                                                      </div>
                                                </li>';
											}
										}
							
							?>
                            
                            <!--Task-->
                            <div id="<?php echo $task['Task']['id']; ?>" class="task <?php echo $task_color; ?>">
                            	
                                <div class="taskPreview" style="display:block;"><!--task preview-->
                                    <a class="arrow" href="#" onClick="toggle_task('<?php echo $task['Task']['id']; ?>');"></a>
                                    <span class="description" onclick="toggle_task('<?php echo $task['Task']['id']; ?>');"><?php echo $task['Task']['title']; ?> 
                                    	<a href="#">
                                        	<?php
											foreach($project_members_details as $member_details){
												if ($task['Task']['ownerid'] == $member_details['User']['id']){
													echo substr($member_details['User']['first_name'],0,1). '' . substr($member_details['User']['last_name'],0,1);
												}
											}
											?>
                                        </a>
                                    </span>
                                    <div class="icons">
                                        <a class="star" href="#"></a>
                                        <a class="num" href="#">5</a>
                                        <a class="comment" rel="<?php echo $task['Task']['id']; ?>" href="#"></a>
                                    </div>
                                    <div class="clear"></div>
                                </div><!--task preview-->
                                
                                <div class="taskDetails clearfix" style="display:none;"><!--task details-->
                                	<a class="arrow_expanded" href="#" onClick="toggle_task('<?php echo $task['Task']['id']; ?>');"></a>
                                    <textarea class="task_title"><?php echo $task['Task']['title']; ?></textarea>
                                     <div class="task_details box_radius clearfix"><!--task id details-->
                                            <ul>
                                                <li><a id="<?php echo $task['Task']['id']; ?>_copy" class="link_button copy_to_clipboard" title="Copy to clipboard"></a></li>
                                                <li>
                                                    <div>
                                                        <div class="button">
                                                        <span class="id_label link_button">ID</span>
                                                        <input type="text" tabindex="-1" value="<?php echo $task['Task']['id']; ?>" size="9" maxlength="9" readonly="true">
                                                      </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div><!--task id details-->
                                     <div class="task_details box_radius clearfix save_controls control_bar"><!--task id details-->
                                    	<ul>
                                            <li>
                                              <a class="save" tabindex="-1" href="#">Save</a>
                                            </li>
                                            <li>
                                              <div class="cancel_or_close"><em><a onclick="toggle_task('<?php echo $task['Task']['id']; ?>');" class="close" tabindex="-1" href="#">Close</a></em></div>
                                            </li>
                                          </ul>
                                    </div><!--task id details-->
                                     <div class="task_configuration box_radius clearfix"><!--task config-->
                                        
                                            <div class="task_configuration_item clearfix"><!--configuration item-->
                                                <div class="item_title">TASK TYPE</div><!--configuration item title-->
                                                
                                                <div class="taskconfiguration_dd_container"><!--configuration item dropdown-->
                                                 
                                                  <div id="task_type_<?php echo $task['Task']['id']; ?>" class="me_relative config_dropdwon">
                                                  	<?php
														$task_type_list = '';
														foreach($tasks_types as $task_type) {
															foreach($task_type as $types) {
																if ($task['Task']['task_type'] == $types['id']) {
																	$task_type_value = $types['id'];
																	$task_type_text = $types['title'];
																}
																$task_type_list .= '<li>
																					  <input type="hidden" value="'.$types['id'].'">
																					  <a class="dd_option">'.$types['title'].'</a>
																					</li>';
															}
														}
													?>
                                                    <input type="hidden" value="<?php echo $task_type_value; ?>" name="task_type_<?php echo $task['Task']['id']; ?>_value" class="selected_task_type">
                                                    <a class="dd_select"><?php echo $task_type_text; ?></a>
                                                    <span class="me_absolute dd_pointer dd_pointer_down"></span>
                                                  </div>
                                                  
                                                  <ul id="task_type_<?php echo $task['Task']['id']; ?>_options" class="config_dropdwon_options" style="display:none;">
                                                  <?php echo $task_type_list; ?>
                                                  </ul>
                                               </div><!--configuration item dropdown-->
                                              
                                            </div><!--configuration item-->
                                            
                                            <div class="task_configuration_item clearfix">
                                                <div class="item_title">POINTS</div>
                                                
                                                <div class="taskconfiguration_dd_container"><!--configuration item dropdown-->
                                                  <div id="points_<?php echo $task['Task']['id']; ?>" class="me_relative config_dropdwon">
                                                  	
                                                    <input type="hidden" value="<?php echo $task['Task']['points']; ?>" name="points_<?php echo $task['Task']['id']; ?>_value" class="selected_task_type">
                                                    <a class="dd_select"><?php echo $task['Task']['points']; ?> pt</a>
                                                    <span class="me_absolute dd_pointer dd_pointer_down"></span>
                                                  </div>
                                                  
                                                  <ul id="points_<?php echo $task['Task']['id']; ?>_options" class="config_dropdwon_options" style="display:none;">
                                                    <li>
                                                      <input type="hidden" value="1">
                                                      <a class="dd_option">1 pt</a>
                                                    </li>
                                                    <li>
                                                      <input type="hidden" value="2">
                                                      <a class="dd_option">2 pts</a>
                                                    </li>
                                                    <li>
                                                      <input type="hidden" value="3">
                                                      <a class="dd_option">3 pts</a>
                                                    </li>
                                                    <li>
                                                      <input type="hidden" value="4">
                                                      <a class="dd_option">4 pts</a>
                                                    </li>
                                                    <li>
                                                      <input type="hidden" value="5">
                                                      <a class="dd_option">5 pts</a>
                                                    </li>
                                                  </ul>
                                               </div><!--configuration item dropdown-->
                                               
                                            </div>
                                            <div class="task_configuration_item">
                                                <div class="item_title">STATE</div>
                                                
                                                <div class="taskconfiguration_dd_container"><!--configuration item dropdown-->
                                                  <div id="state_<?php echo $task['Task']['id']; ?>" class="me_relative config_dropdwon">
                                                  	<?php
														$task_status_list = '';
														foreach($tasks_statuses as $status) {
															foreach($status as $stats) {
																if ($task['Task']['status'] == $stats['id']) {
																	$task_status_value = $stats['id'];
																	$task_status_text = $stats['title'];
																}
																$task_status_list .= '<li>
																					  <input type="hidden" value="'.$stats['id'].'">
																					  <a class="dd_option">'.$stats['title'].'</a>
																					</li>';
															}
														}
													?>
                                                     <input type="hidden" value="<?php echo $task_status_value; ?>" name="status_<?php echo $task['Task']['id']; ?>_value" class="selected_task_type">
                                                    <a class="dd_select"><?php echo $task_status_text; ?> pt</a>
                                                    <span class="me_absolute dd_pointer dd_pointer_down"></span>
                                                  </div>
                                                  
                                                  <ul id="state_<?php echo $task['Task']['id']; ?>_options" class="config_dropdwon_options" style="display:none;">
                                                     <?php echo $task_status_list; ?>
                                                  </ul>
                                               </div><!--configuration item dropdown-->
                                                
                                            </div>
                                            <div class="task_configuration_item">
                                                <div class="item_title">REQUESTER</div>
                                                
                                                <div class="taskconfiguration_dd_container"><!--configuration item dropdown-->
                                                  <div id="requeter_<?php echo $task['Task']['id']; ?>" class="me_relative config_dropdwon">
                                                  	<?php
														$task_requester_list = '';
														foreach($project_members as $project_member) {
															if ($task['Task']['project_id'] == $project_member['ProjectsUser']['project_id']) {

																foreach($project_members_details as $project_members_detail) {
																	  if ($project_member['ProjectsUser']['user_id'] == $project_members_detail['User']['id'] ) {
																		  $task_requester_list .= '<li>
																				<input type="hidden" value="'.$project_members_detail['User']['id'].'">
																				<a class="dd_option">'.$project_members_detail['User']['first_name'].' '.$project_members_detail['User']['last_name'].'</a>
																			  </li>';
																	  }
																	   if ($task['Task']['requesterid'] == $project_members_detail['User']['id']) {
																		  	$task_requester_value = $project_members_detail['User']['id'];
																			$task_requester_text = $project_members_detail['User']['first_name'].' '.$project_members_detail['User']['last_name'];
																	  }
																  }
																
															}
														}
													?>
                                                    <input type="hidden" value="<?php echo $task_requester_value; ?>" name="requester_<?php echo $task['Task']['id']; ?>_value" class="selected_task_type">
                                                    <a class="dd_select"><?php echo $task_requester_text; ?></a>
                                                    <span class="me_absolute dd_pointer dd_pointer_down"></span>
                                                  </div>
                                                  
                                                  <ul id="requeter_<?php echo $task['Task']['id']; ?>_options" class="config_dropdwon_options" style="display:none;">
                                                    <?php echo $task_requester_list; ?>
                                                  </ul>
                                               </div><!--configuration item dropdown-->
                                                
                                            </div>
                                            <div class="task_configuration_item">
                                                <div class="item_title">OWNER</div>
                                                
                                                <div class="taskconfiguration_dd_container"><!--configuration item dropdown-->
                                                  <div id="owner_<?php echo $task['Task']['id']; ?>" class="me_relative config_dropdwon">
                                                  	<?php
														$task_owner_list = '';
														foreach($project_members as $project_member) {
															if ($task['Task']['project_id'] == $project_member['ProjectsUser']['project_id']) {

																foreach($project_members_details as $project_members_detail) {
																	  if ($project_member['ProjectsUser']['user_id'] == $project_members_detail['User']['id'] ) {
																		  $task_owner_list .= '<li>
																				<input type="hidden" value="'.$project_members_detail['User']['id'].'">
																				<a class="dd_option">'.$project_members_detail['User']['first_name'].' '.$project_members_detail['User']['last_name'].'</a>
																			  </li>';
																	  }
																	  if ($task['Task']['ownerid'] == $project_members_detail['User']['id']) {
																		  	$task_owner_value = $project_members_detail['User']['id'];
																			$task_owner_text = $project_members_detail['User']['first_name'].' '.$project_members_detail['User']['last_name'];
																	  }
																  }
																
															}
														}
													?>
                                                    <input type="hidden" value="<?php echo $task_owner_value; ?>" name="owner_<?php echo $task['Task']['id']; ?>_value" class="selected_task_type">
                                                    <a class="dd_select"><?php echo $task_owner_text; ?></a>
                                                    <span class="me_absolute dd_pointer dd_pointer_down"></span>
                                                  </div>
                                                  
                                                  <ul id="owner_<?php echo $task['Task']['id']; ?>_options" class="config_dropdwon_options" style="display:none;">
                                                     <?php echo $task_owner_list; ?>
                                                  </ul>
                                               </div><!--configuration item dropdown-->
                                                
                                            </div>
                                        </div><!--task config-->
                                    <div><!--task description-->
                                    	<div>Description</div>
                                    	<div class="task_description_div box_radius">
                                        	<p><?php echo $task['Task']['description']; ?></p>
                                        	<textarea class="task_description_text" style="display:none;"></textarea>
                                        </div>
                                    </div><!--task description-->
                                    
                                    <div><!--task description-->
                                    	<div>Sub Tasks</div>
                                        <ol id="<?php echo $task['Task']['id']; ?>_subtask_list" class="subtask_list_container">
                                           <?php
                                                foreach($project_subtasks as $subtask) {
													if($subtask['Subtask']['task_id'] == $task['Task']['id']) {
												?>
                                                <li class="subtask_list box_radius clearfix">
                                                    <input type="checkbox" /> <label><?php echo $subtask['Subtask']['description']; ?></label>
                                                </li>
                                                <?php
													}
												}
												?>
                                        </ol>
                                    	<div class="subtask_entry_div box_radius clearfix">
                                                <textarea id="<?php echo $task['Task']['id']; ?>_subtask_text" class="subtask_details_text"></textarea>
                                                <input id="<?php echo $task['Task']['id']; ?>_add_subtask" name="<?php echo $task['Task']['id']; ?>_add_subtask" type="submit" class="link_button" value="Add" onclick="add_subtask('<?php echo $task['Task']['id']; ?>');" />
                                        </div>
                                    </div><!--task description-->
                                    
                                    <div><!--task activity-->
                                    	<div>Activity</div>
                                        <ol id="<?php echo $task['Task']['id']; ?>_activity_list" class="activity_list_container">
                                            <?php echo $task_comments_list;?>
                                        </ol>
                                    	<div class="activity_entry_div box_radius clearfix">
                                              <textarea id="<?php echo $task['Task']['id']; ?>_activity_text" class="activity_details_text"></textarea>
                                              <input id="<?php echo $task['Task']['id']; ?>_add_activity" name="<?php echo $task['Task']['id']; ?>_add_activity" type="submit" class="link_button" value="Add" onclick="add_activity('<?php echo $task['Task']['id']; ?>');" />
                                        </div>
                                    </div><!--task activity-->
                                                                        
                                </div><!--task details-->
                                
                                <div id="<?php echo $task['Task']['id']; ?>_comments" class="taskComments clearfix" style="display:none;"><!--task comments-->
                                	<div><!--task description-->
                                    	<div>Description</div>
                                    	<div class="task_description_div_static box_radius">
                                        	<p>This is a lengthier task description that will have links</p>
                                        </div>
                                    </div><!--task description-->
                                    <div><!--task activity-->
                                    	<div>Activity</div>
                                        <ol id="<?php echo $task['Task']['id']; ?>_activity_list" class="activity_list_container">
                                            <li class="activity_list box_radius clearfix">
                                                 <div class="contents">
                                                    <div class="created_at">6 Oct 2012, 4:09pm</div>
                                                    <div class="author">Bryan Potts</div>
                                                    <div class="text ">A sample activity comment</div>
                                                    <div class="attachments clearfix" style="display: block;"></div>
                                                  </div>
                                            </li>
                                        </ol>
                                    </div><!--task activity-->
                                </div><!--task comments--> 
                                
							</div>
                            <!--Task-->
                            
                            <?php
                            
									}
									}
							?>
                            
							
							<div class="tasks_shadow"></div>
						</div>
					</div>
					<div id="pending_tasks_container">
						<div class="task_header_row">
							<span class="column_title">Pending Tasks</span>
						</div>
						<div id="pending_tasks">
							 <?php
                            //print_r($comments);								
									foreach($project_tasks as $task) {
										if ($task['Task']['status'] == 1) {
											
											if ($task['Task']['id'] == 1){
												$task_color = 'red'	;
											}
											if ($task['Task']['id'] == 2){
												$task_color = 'green';	
											}
											if ($task['Task']['id'] == 3){
												$task_color = 'blue';
											}
											if ($task['Task']['id'] == 4){
												$task_color = 'gray';	
											}
										
										$comment_count = 0;
										$task_comments_list = '';
										
										foreach($comments as $comment) {
											
											$comment_user_name = '';
											if ($task['Task']['id'] == $comment['Comment']['task_id']) {
												$comment_count += 1;
												$task_comments_list .='<li class="activity_list box_radius clearfix">
                                                     <div class="contents">
                                                        <div class="created_at">'.date('M. jS',$this->Time->toUnix($comment['Comment']['created'])).'</div>
                                                        <div class="author">'.$comment['User']['first_name'].'</div>
                                                        <div class="text ">'.$comment['Comment']['comment'].'</div>
                                                        <div class="attachments clearfix" style="display: block;"></div>
                                                      </div>
                                                </li>';
											}
										}
							
							?>
                            
                            <!--Task-->
                            <div id="<?php echo $task['Task']['id']; ?>" class="task <?php echo $task_color; ?>">
                            	
                                <div class="taskPreview" style="display:block;"><!--task preview-->
                                    <a class="arrow" href="#" onClick="toggle_task('<?php echo $task['Task']['id']; ?>');"></a>
                                    <span class="description" onclick="toggle_task('<?php echo $task['Task']['id']; ?>');"><?php echo $task['Task']['title']; ?> 
                                    	<a href="#">
                                        <?php
											foreach($project_members_details as $member_details){
												if ($task['Task']['ownerid'] == $member_details['User']['id']){
													echo substr($member_details['User']['first_name'],0,1). '' . substr($member_details['User']['last_name'],0,1);
												}
											}
											?>
                                        </a>
                                    </span>
                                    <div class="icons">
                                        <a class="star" href="#"></a>
                                        <a class="num" href="#">5</a>
                                        <a class="comment" rel="<?php echo $task['Task']['id']; ?>" href="#"></a>
                                    </div>
                                    <div class="clear"></div>
                                </div><!--task preview-->
                                
                                <div class="taskDetails clearfix" style="display:none;"><!--task details-->
                                	<a class="arrow_expanded" href="#" onClick="toggle_task('<?php echo $task['Task']['id']; ?>');"></a>
                                    <textarea class="task_title"><?php echo $task['Task']['title']; ?></textarea>
                                     <div class="task_details box_radius clearfix"><!--task id details-->
                                            <ul>
                                                <li><a id="<?php echo $task['Task']['id']; ?>_copy" class="link_button copy_to_clipboard" title="Copy to clipboard"></a></li>
                                                <li>
                                                    <div>
                                                        <div class="button">
                                                        <span class="id_label link_button">ID</span>
                                                        <input type="text" tabindex="-1" value="<?php echo $task['Task']['id']; ?>" size="9" maxlength="9" readonly="true">
                                                      </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div><!--task id details-->
                                     <div class="task_details box_radius clearfix save_controls control_bar"><!--task id details-->
                                    	<ul>
                                            <li>
                                              <a class="save" tabindex="-1" href="#">Save</a>
                                            </li>
                                            <li>
                                              <div class="cancel_or_close"><em><a onclick="toggle_task('<?php echo $task['Task']['id']; ?>');" class="close" tabindex="-1" href="#">Close</a></em></div>
                                            </li>
                                          </ul>
                                    </div><!--task id details-->
                                     <div class="task_configuration box_radius clearfix"><!--task config-->
                                        
                                            <div class="task_configuration_item clearfix"><!--configuration item-->
                                                <div class="item_title">TASK TYPE</div><!--configuration item title-->
                                                
                                                <div class="taskconfiguration_dd_container"><!--configuration item dropdown-->
                                                 
                                                  <div id="task_type_<?php echo $task['Task']['id']; ?>" class="me_relative config_dropdwon">
                                                  	<?php
														$task_type_list = '';
														foreach($tasks_types as $task_type) {
															foreach($task_type as $types) {
																if ($task['Task']['task_type'] == $types['id']) {
																	$task_type_value = $types['id'];
																	$task_type_text = $types['title'];
																}
																$task_type_list .= '<li>
																					  <input type="hidden" value="'.$types['id'].'">
																					  <a class="dd_option">'.$types['title'].'</a>
																					</li>';
															}
														}
													?>
                                                    <input type="hidden" value="<?php echo $task_type_value; ?>" name="task_type_<?php echo $task['Task']['id']; ?>_value" class="selected_task_type">
                                                    <a class="dd_select"><?php echo $task_type_text; ?></a>
                                                    <span class="me_absolute dd_pointer dd_pointer_down"></span>
                                                  </div>
                                                  
                                                  <ul id="task_type_<?php echo $task['Task']['id']; ?>_options" class="config_dropdwon_options" style="display:none;">
                                                  <?php echo $task_type_list; ?>
                                                  </ul>
                                               </div><!--configuration item dropdown-->
                                              
                                            </div><!--configuration item-->
                                            
                                            <div class="task_configuration_item clearfix">
                                                <div class="item_title">POINTS</div>
                                                
                                                <div class="taskconfiguration_dd_container"><!--configuration item dropdown-->
                                                  <div id="points_<?php echo $task['Task']['id']; ?>" class="me_relative config_dropdwon">
                                                  	
                                                    <input type="hidden" value="<?php echo $task['Task']['points']; ?>" name="points_<?php echo $task['Task']['id']; ?>_value" class="selected_task_type">
                                                    <a class="dd_select"><?php echo $task['Task']['points']; ?> pt</a>
                                                    <span class="me_absolute dd_pointer dd_pointer_down"></span>
                                                  </div>
                                                  
                                                  <ul id="points_<?php echo $task['Task']['id']; ?>_options" class="config_dropdwon_options" style="display:none;">
                                                    <li>
                                                      <input type="hidden" value="1">
                                                      <a class="dd_option">1 pt</a>
                                                    </li>
                                                    <li>
                                                      <input type="hidden" value="2">
                                                      <a class="dd_option">2 pts</a>
                                                    </li>
                                                    <li>
                                                      <input type="hidden" value="3">
                                                      <a class="dd_option">3 pts</a>
                                                    </li>
                                                    <li>
                                                      <input type="hidden" value="4">
                                                      <a class="dd_option">4 pts</a>
                                                    </li>
                                                    <li>
                                                      <input type="hidden" value="5">
                                                      <a class="dd_option">5 pts</a>
                                                    </li>
                                                  </ul>
                                               </div><!--configuration item dropdown-->
                                               
                                            </div>
                                            <div class="task_configuration_item">
                                                <div class="item_title">STATE</div>
                                                
                                                <div class="taskconfiguration_dd_container"><!--configuration item dropdown-->
                                                  <div id="state_<?php echo $task['Task']['id']; ?>" class="me_relative config_dropdwon">
                                                  	<?php
														$task_status_list = '';
														foreach($tasks_statuses as $status) {
															foreach($status as $stats) {
																if ($task['Task']['status'] == $stats['id']) {
																	$task_status_value = $stats['id'];
																	$task_status_text = $stats['title'];
																}
																$task_status_list .= '<li>
																					  <input type="hidden" value="'.$stats['id'].'">
																					  <a class="dd_option">'.$stats['title'].'</a>
																					</li>';
															}
														}
													?>
                                                     <input type="hidden" value="<?php echo $task_status_value; ?>" name="status_<?php echo $task['Task']['id']; ?>_value" class="selected_task_type">
                                                    <a class="dd_select"><?php echo $task_status_text; ?> pt</a>
                                                    <span class="me_absolute dd_pointer dd_pointer_down"></span>
                                                  </div>
                                                  
                                                  <ul id="state_<?php echo $task['Task']['id']; ?>_options" class="config_dropdwon_options" style="display:none;">
                                                     <?php echo $task_status_list; ?>
                                                  </ul>
                                               </div><!--configuration item dropdown-->
                                                
                                            </div>
                                            <div class="task_configuration_item">
                                                <div class="item_title">REQUESTER</div>
                                                
                                                <div class="taskconfiguration_dd_container"><!--configuration item dropdown-->
                                                  <div id="requeter_<?php echo $task['Task']['id']; ?>" class="me_relative config_dropdwon">
                                                  	<?php
														$task_requester_list = '';
														foreach($project_members as $project_member) {
															if ($task['Task']['project_id'] == $project_member['ProjectsUser']['project_id']) {

																foreach($project_members_details as $project_members_detail) {
																	  if ($project_member['ProjectsUser']['user_id'] == $project_members_detail['User']['id'] ) {
																		  $task_requester_list .= '<li>
																				<input type="hidden" value="'.$project_members_detail['User']['id'].'">
																				<a class="dd_option">'.$project_members_detail['User']['first_name'].' '.$project_members_detail['User']['last_name'].'</a>
																			  </li>';
																	  }
																	   if ($task['Task']['requesterid'] == $project_members_detail['User']['id']) {
																		  	$task_requester_value = $project_members_detail['User']['id'];
																			$task_requester_text = $project_members_detail['User']['first_name'].' '.$project_members_detail['User']['last_name'];
																	  }
																  }
																
															}
														}
													?>
                                                    <input type="hidden" value="<?php echo $task_requester_value; ?>" name="requester_<?php echo $task['Task']['id']; ?>_value" class="selected_task_type">
                                                    <a class="dd_select"><?php echo $task_requester_text; ?></a>
                                                    <span class="me_absolute dd_pointer dd_pointer_down"></span>
                                                  </div>
                                                  
                                                  <ul id="requeter_<?php echo $task['Task']['id']; ?>_options" class="config_dropdwon_options" style="display:none;">
                                                    <?php echo $task_requester_list; ?>
                                                  </ul>
                                               </div><!--configuration item dropdown-->
                                                
                                            </div>
                                            <div class="task_configuration_item">
                                                <div class="item_title">OWNER</div>
                                                
                                                <div class="taskconfiguration_dd_container"><!--configuration item dropdown-->
                                                  <div id="owner_<?php echo $task['Task']['id']; ?>" class="me_relative config_dropdwon">
                                                  	<?php
														$task_owner_list = '';
														foreach($project_members as $project_member) {
															if ($task['Task']['project_id'] == $project_member['ProjectsUser']['project_id']) {

																foreach($project_members_details as $project_members_detail) {
																	  if ($project_member['ProjectsUser']['user_id'] == $project_members_detail['User']['id'] ) {
																		  $task_owner_list .= '<li>
																				<input type="hidden" value="'.$project_members_detail['User']['id'].'">
																				<a class="dd_option">'.$project_members_detail['User']['first_name'].' '.$project_members_detail['User']['last_name'].'</a>
																			  </li>';
																	  }
																	  if ($task['Task']['ownerid'] == $project_members_detail['User']['id']) {
																		  	$task_owner_value = $project_members_detail['User']['id'];
																			$task_owner_text = $project_members_detail['User']['first_name'].' '.$project_members_detail['User']['last_name'];
																	  }
																  }
																
															}
														}
													?>
                                                    <input type="hidden" value="<?php echo $task_owner_value; ?>" name="owner_<?php echo $task['Task']['id']; ?>_value" class="selected_task_type">
                                                    <a class="dd_select"><?php echo $task_owner_text; ?></a>
                                                    <span class="me_absolute dd_pointer dd_pointer_down"></span>
                                                  </div>
                                                  
                                                  <ul id="owner_<?php echo $task['Task']['id']; ?>_options" class="config_dropdwon_options" style="display:none;">
                                                     <?php echo $task_owner_list; ?>
                                                  </ul>
                                               </div><!--configuration item dropdown-->
                                                
                                            </div>
                                        </div><!--task config-->
                                    <div><!--task description-->
                                    	<div>Description</div>
                                    	<div class="task_description_div box_radius">
                                        	<p><?php echo $task['Task']['description']; ?></p>
                                        	<textarea class="task_description_text" style="display:none;"></textarea>
                                        </div>
                                    </div><!--task description-->
                                    
                                    <div><!--task description-->
                                    	<div>Sub Tasks</div>
                                        <ol id="<?php echo $task['Task']['id']; ?>_subtask_list" class="subtask_list_container">
                                           <?php
                                                foreach($project_subtasks as $subtask) {
													if($subtask['Subtask']['task_id'] == $task['Task']['id']) {
												?>
                                                <li class="subtask_list box_radius clearfix">
                                                    <input type="checkbox" /> <label><?php echo $subtask['Subtask']['description']; ?></label>
                                                </li>
                                                <?php
													}
												}
												?>
                                        </ol>
                                    	<div class="subtask_entry_div box_radius clearfix">
                                                <textarea id="<?php echo $task['Task']['id']; ?>_subtask_text" class="subtask_details_text"></textarea>
                                                <input id="<?php echo $task['Task']['id']; ?>_add_subtask" name="<?php echo $task['Task']['id']; ?>_add_subtask" type="submit" class="link_button" value="Add" onclick="add_subtask('<?php echo $task['Task']['id']; ?>');" />
                                        </div>
                                    </div><!--task description-->
                                    
                                    <div><!--task activity-->
                                    	<div>Activity</div>
                                        <ol id="<?php echo $task['Task']['id']; ?>_activity_list" class="activity_list_container">
                                            <?php echo $task_comments_list;?>
                                        </ol>
                                    	<div class="activity_entry_div box_radius clearfix">
                                              <textarea id="<?php echo $task['Task']['id']; ?>_activity_text" class="activity_details_text"></textarea>
                                              <input id="<?php echo $task['Task']['id']; ?>_add_activity" name="<?php echo $task['Task']['id']; ?>_add_activity" type="submit" class="link_button" value="Add" onclick="add_activity('<?php echo $task['Task']['id']; ?>');" />
                                        </div>
                                    </div><!--task activity-->
                                                                        
                                </div><!--task details-->
                                
                                <div id="<?php echo $task['Task']['id']; ?>_comments" class="taskComments clearfix" style="display:none;"><!--task comments-->
                                	<div><!--task description-->
                                    	<div>Description</div>
                                    	<div class="task_description_div_static box_radius">
                                        	<p>This is a lengthier task description that will have links</p>
                                        </div>
                                    </div><!--task description-->
                                    <div><!--task activity-->
                                    	<div>Activity</div>
                                        <ol id="<?php echo $task['Task']['id']; ?>_activity_list" class="activity_list_container">
                                            <li class="activity_list box_radius clearfix">
                                                 <div class="contents">
                                                    <div class="created_at">6 Oct 2012, 4:09pm</div>
                                                    <div class="author">Bryan Potts</div>
                                                    <div class="text ">A sample activity comment</div>
                                                    <div class="attachments clearfix" style="display: block;"></div>
                                                  </div>
                                            </li>
                                        </ol>
                                    </div><!--task activity-->
                                </div><!--task comments--> 
                                
							</div>
                            <!--Task-->
                            
                            <?php
                            
									}
									}
							?>
							<div class="tasks_shadow"></div>
						</div>
					</div>
				</div>