<?php
	echo $this->Html->css(array('jquery.mCustomScrollbar', 'jquery-ui-fc', 'resources', 'filocity-dialog-helper', 'filocity-tasks-helper'));
	echo $this->Html->script(array('jquery-ui-1.8.23.custom.min', 'jquery.mousewheel.min.js', 'jquery.mCustomScrollbar.js', 'plupload.full.js', 'multiselect', 'filocity-dialog-helper', 'filocity-tasks-helper', 'resources', 'common','jquery.upload'), array('inline' => false));
	App::uses('CakeTime', 'Utility');
	App::uses('Sanitize', 'Utility');
?>
	<script type="text/javascript">
		$(function(){
			FilocityTasks.view='<?php echo $view;?>';
			FilocityTasks.viewed_id='<?php echo $viewed_id;?>';
            FilocityTasks.sort_by='<?php echo $order_by;?>';
			FilocityTasks.init();
		});
	</script>
	<div id="members_and_tasks_container">
		<div id="board_header">
			<div class="resources_page_header" style="position:relative;">
				<span>Resources for</span>
				<span style="color:#5391be;"></span>
				<select id="projects_dropdown">
					<optgroup label="Projects">
						<option value="project-0">All Projects</option>
						<?php
						for($i=0;$i<count($projects);$i++){
							echo '<option value="project-'.$projects[$i]['Project']['id'].'"'.($view.'-'.$projects[$i]['Project']['id']=='project-'.$viewed_id?'selected="selected" ':'').'>'.$projects[$i]['Project']['name'].'</option>';
						}
						?>
					</optgroup>
					<optgroup label="Members">
						<?php
						for($i=0;$i<count($members);$i++){
							echo '<option value="member-'.$members[$i]['User']['id'].'"'.($view.'-'.$members[$i]['User']['id']=='member-'.$viewed_id?'selected="selected" ':'').'>'.$members[$i]['User']['first_name'].' '.$members[$i]['User']['last_name'].'</option>';
						}
						?>
					</optgroup>
				</select>
                                 
                                    <span style="margin-left:260px; font-size: 10px;color:black;"  >Sorted By</span>
                                    <span class="column_title" style="font-size: 10px;color:black;"> 
                                        <select id="tasks_dropdown">                                  
                                            <option value="created"> Deliver</option>
                                            <option value="task_type"> Task Type</option>
                                            <option value="points">Points</option>
                                             <option value="comment_count">Comments</option>
                                                
                                        </select>
                                    </span>
                             
                                <div style="position:absolute;top:0;right:0;"><a href="#" id="new_task_link" style="font-size:12px;color:blue;">New Task</a></div>
			</div>
		</div>
		<div id="active_team_members_container" class="me_left">
			<div class="row">
				<span class="column_title">Active Team Members <!--<a href="#">manage</a>--></span>
			</div>
			<div class="row">
			Team Members: <strong><?php echo count($project_members); ?></strong><br />
			Total Budget Use: <strong>0%</strong>
			</div>
			<?php 
			
		     if(isset($max_members) && $max_members==true){
						?>
			<div id="flashMessage" class="flash_error message" style="font-size: 80%;;">
			<i class="icon-exclamation-sign"></i>Unfortunately you have exceeded your current package. Please upgrade your <a href="/users/dashboard">package</a> to add more members. 
			
			</div>		 
             <?php } ?>
			<div id="members">
			<?php for($i=0,$iCount=count($project_members);$i<$iCount;$i++){ ?>
				<div class="member">
					<div class="photo">
						<?php echo $this->Html->image('/image/profile/'.$project_members[$i]['User']['id'].'/small.jpg?' . time(), array('alt' => 'Photo'));?>
					</div>
					<div class="info">
						<a class="name" href="#"><?php echo $project_members[$i]['User']['first_name'].' '.$project_members[$i]['User']['last_name'];?></a> <?php echo $project_members[$i]['User']['position'];?><br />
						<?php if(isset($project_members[$i]['Task'])) {echo count($project_members[$i]['Task']);} else{ echo '0' ;} ?> tasks assigned <?php if(isset($project_members[$i]['Task'])){ echo ",".count($project_members[$i]['Task'])." active"; } ?><br />
					<?php if(isset($project_detail['Project']) && isset($project_members[$i]['ProjectsUser']) && $project_members[$i]['ProjectsUser']['budget']>0 && $project_detail['Project']['budget']>0){ echo "Budget Asssigned: <strong>".intval(100*($project_members[$i]['ProjectsUser']['budget']/$project_detail['Project']['budget']))."%</strong>" ;} ?>
						
						<a href="#">edit</a>
					</div>
				</div>
			<?php }?>
			<?php if(!empty($member_info)){ ?>
				<div class="member">
					<div class="photo">
						<?php echo $this->Html->image('filocity_img/user_'.$member_info[$i]['User']['id'].'/profile.jpg', array('alt' => 'Photo'));?>
					</div>
					<div class="info">
						<a class="name" href="#"><?php echo $member_info[$i]['User']['first_name'].' '.$member_info[$i]['User']['last_name'];?></a> <?php echo $member_info[$i]['User']['position'];?><br />
						<?php if(isset($member_info[$i]['Task'])) {echo count($member_info[$i]['Task']);} else{ echo '0' ;} ?> tasks assigned <?php if(isset($member_info[$i]['Task'])){ echo ",".count($member_info[$i]['Task'])." active"; } ?><br /><br />
						<?php if(isset($project_detail['Project']) && isset($member_info[$i]['ProjectsUser'])){ echo "Budget Asssigned: <strong>".intval(100*($project_detail['Project']['budget']/$member_info[$i]['ProjectsUser']['budget']))."%</strong>" ;} ?> <a href="#">edit</a>
					</div>
				</div>
			<?php } ?>
			<?php /*
				<div class="member">
					<div class="photo">
						<img src="images/resources_temp/abdullah.jpg" />
					</div>
					<div class="info">
						<a class="name" href="#">Abdullah Yousuf</a> Developer<br />
						7 tasks assigned, 3 active<br />
						Budget Spent: <strong>75%</strong> <a href="#">edit</a>
					</div>
				</div>
				<div class="member">
					<div class="photo">
						<img src="images/resources_temp/thaler.jpg" />
					</div>
					<div class="info">
						<a class="name" href="#">Doug Thaler</a> Owner<br />
						11 tasks assigned, 3 active<br />
						Budget Spent: <strong>22%</strong> <a href="#">edit</a>
					</div>
				</div>
				<div class="member">
					<div class="photo">
						<img src="images/resources_temp/hamrick.jpg" />
					</div>
					<div class="info">
						<a class="name" href="#">Dana Hamrick</a> Sexy Lady<br />
						7 tasks assigned, 3 active<br />
						Budget Spent: <strong>75%</strong> <a href="#">edit</a>
					</div>
				</div>
				<div class="member">
					<div class="photo">
						<img src="images/resources_temp/hauty.jpg" />
					</div>
					<div class="info">
						<a class="name" href="#">Sherry Hauty</a> Manager<br />
						11 tasks assigned, 3 active<br />
						Budget Spent: <strong>22%</strong> <a href="#">edit</a>
					</div>
				</div>
				<div class="member">
					<div class="photo">
						<img src="images/resources_temp/abdullah.jpg" />
					</div>
					<div class="info">
						<a class="name" href="#">Abdullah Yousuf</a> Developer<br />
						7 tasks assigned, 3 active<br />
						Budget Spent: <strong>75%</strong> <a href="#">edit</a>
					</div>
				</div>
				<div class="member">
					<div class="photo">
						<img src="images/resources_temp/hamrick.jpg" />
					</div>
					<div class="info">
						<a class="name" href="#">Dana Hamrick</a> Sexy Lady<br />
						7 tasks assigned, 3 active<br />
						Budget Spent: <strong>75%</strong> <a href="#">edit</a>
					</div>
				</div>
				<div class="member">
					<div class="photo">
						<img src="images/resources_temp/potts.jpg" />
					</div>
					<div class="info">
						<a class="name" href="#">Bryan Potts</a> Manager<br />
						11 tasks assigned, 3 active<br />
						Budget Spent: <strong>22%</strong> <a href="#">edit</a>
					</div>
				</div>
				<div class="add-member">
					<div class="photo">
						<img src="images/resources_temp/default-photo.jpg" />
					</div>
					<div class="link">
						<span>+</span> <a href="#">Add Member</a>
					</div>
				</div>
			*/ ?>
			</div>
		</div>
		<div id="active_tasks_container">
			<div class="task_header_row">
				<span class="column_title">Active Tasks</span> 
			</div>
			<div id="active_tasks">
				<ul class="container">
					
				</ul>
				<div class="tasks_shadow"></div>
			</div>
		</div>
		<div id="pending_tasks_container">
			<div class="task_header_row">
				<span class="column_title">Pending Tasks</span>
                               
                               
                               
			</div>
			<div id="pending_tasks">
				<ul class="container">
				
				</ul>
				<div class="tasks_shadow"></div>
			</div>
		</div>
	</div>
	
	