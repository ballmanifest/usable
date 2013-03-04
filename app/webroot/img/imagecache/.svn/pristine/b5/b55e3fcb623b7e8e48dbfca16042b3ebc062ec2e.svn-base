<?php 
	echo $this->Html->css('permissions');
	echo $this->Html->script( array('permissions', 'common', 'jquery-ui-1.8.23.custom.min') );
?>
<div class="main_permission me_relative">
	<div class="add_members_modal the_add_modal the_modal me_absolute">
		<div class="permission_cross"><div class="btn_container me_absolute"><div class="btn_wrapper"><div class="btn_self"><span class="cross_icon">&nbsp;</span></div></div></div></div>
		<div class="add_members_modal_wrapper">
			<input type="text" placeholder="Search for member or group by name..." name="member_search" class="member_search">
			<ul class="members_list">
				<li class="each_member">
					<img src="http://filocitydev.com/img/resources_temp/abdullah.jpg" width="46" height="52" class="member_thumb">
					<p class="member_info">
						<span class="member_name me_clear"><a href="">Abdullah Yousuf</a> Developer</span> 
						<span class="tasks me_clear"><strong>7</strong> tasks assigned, <strong>3</strong> active</span>
						<span class="budget_spent me_clear">Budget Spent: <strong>75%</strong></span>
					<p>
				</li>
			</ul>
		</div>
	</div>
	<div class="visibility_selection the_visibility_modal the_modal me_absolute">
		<div class="visibility_selection_wrapper">
			<div id="directory_dd_container">
				<div id="directory_dd" class="me_relative">
					<input type="hidden" value="<?php echo $visibilities[0]['value']; ?>" name="category" class="selected_category">
					<input type="hidden" value="" name="current_project_id" class="selected_project_id">
					<a class="dd_select"><?php echo $visibilities[0]['text']; ?></a>
					<span class="me_absolute dd_pointer dd_pointer_down"></span>
				</div>
				<ul id="directory_dd_options">
					<?php
						foreach($visibilities as $key => $visibility):
							$value = $visibility['value'];
							$text = $visibility['text'];
					?>
					<li data-vistype="<?php echo $value;?>">
					  <input type="hidden" value="<?php echo $value;?>">
					  <a class="dd_option"><?php echo $text;?></a>
					</li>
					<?php
						endforeach;
					?>
				</ul>
		  </div>
		</div>
	</div>
	<h2 class="subtitle">Project Permissions</h2>
		<?php 
			foreach($projects_detail as $x => $project) {
				$tags_block = '<div class="permission_holders_tags clearfix" id="'. $project['Project']['id'] .'"><input type="hidden" class="project_id_holder" value="'. $project['Project']['id'] .'">';
		?>		
				<div class="revamp_content">
					<p class="next_sub" id="<?php echo  $project['Project']['id'];?>"><?php echo  $project['Project']['name'];?></p>
						<div class="sub_content">
							<input type="hidden" class="project_id_holder" value="<?php echo  $project['Project']['id'];?>">
							<input type="hidden" class="project_visibility_holder" value="<?php echo  $project['Project']['visibility'];?>">
									<div class="name">
										<label>PM:</label>
										<a href="#" id="manager_<?php echo  $project['Project']['id'];?>" style="display:none"></a>
										<?php 
											foreach($project['Share'] as $share) {
												$PM = '<a href="#"></a>';
												if($share['access'] == 'project_manager') { 
													$PM = '<a href="#" id="manager_' . $project['Project']['id'] . '">' . $share['User']['first_name'] . ' ' .  $share['User']['last_name'] .'</a>';
													echo $PM;
												} else if($share['access'] == 'member') {
													$tags_block .= '<div class="permission_tag" data-access="'. $share['access'] .'" data-userid="'. $share['User']['id'] .'" data-shareid="'. $share['id'] .'">' .
														'<span class="cross_tag">&#x2715;</span>'.
														'<span class="name_tag">'. $share['User']['last_name'] .', '. ucfirst(substr($share['User']['first_name'],0,1)) .'.</span>'.
													'</div>';
												}
											}
										?>
										<a class="edit" href="#">edit</a>
									</div>
									<div class="name">
										<label>Visibility:</label>
										<a href="#" class="member_visibility" data-projectid="<?php echo $project['Project']['id'];?>"><?php echo $visibilities[$project['Project']['visibility']]['text']; ?>:</a>
									</div>
								</div>
						<?php
							echo $tags_block;
						?>
						<div class="permission_add"><a href="#" class="add">+ add</a></div>
					</div>
				</div>
		<?php } ?>
</div>	
