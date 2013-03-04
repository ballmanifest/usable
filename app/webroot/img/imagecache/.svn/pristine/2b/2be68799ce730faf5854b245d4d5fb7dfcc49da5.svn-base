<div id="add_project_member_modal" class="me_absolute me_hide">
	<div id="add_proj_member_modal_container" class="me_relative shadow">
		<div class="btn_container me_absolute"><div class="btn_wrapper"><div class="btn_self"><span class="cross_icon">&nbsp;</span></div></div></div>
		<div id="add_proj_member_modal_wrapper">
			<div id="add_proj_member_header">
				<h3 class="add_proj_member_title">Add New Member to "<?php echo $project_name;?>"</h3>
			</div>
			<div id="add_proj_member_form">
				<input type="hidden" value="<?php echo $auth_id?>" readonly="readonly" class="auth_id">
				<input type="hidden" value="<?php echo $project_id;?>" readonly="readonly" class="project_id">
				<input type="hidden" value="<?php echo $company_id;?>" readonly="readonly" class="company_id">
				<?php
					echo $this->Form->create('ProjectsUser', array('id' => 'ProjectMemberAdd'));
					echo $this->form->input('ProjectsUser.user_id', array('label' => 'Member Name', 'type' => 'select', 'options' => Set::combine($project_member, '{n}.User.id', array('{1}, {0}', '{n}.User.first_name', '{n}.User.last_name')), 'class' => 'required'));
					echo $this->form->input('ProjectsUser.project_id', array('type' => 'hidden', 'value' => $project_id));
					echo $this->form->input('ProjectsUser.is_admin', array('label' => 'Is this member an admin?', 'type' => 'select', 'options' => array('0' => 'No', '1' => 'Yes')));
					echo $this->form->input('ProjectsUser.budget', array('type' => 'text', 'label' => 'Budget ($)', 'placeholder' => '0.00', 'class' => 'member_budget'));
					echo $this->form->input('Share.project_id', array('type' => 'hidden', 'value' => $project_id));
					echo $this->form->input('Share.user_id', array('type' => 'hidden', 'value' => $auth_id));
					echo $this->form->input('Share.user2_id', array('type' => 'hidden', 'value' => '0'));
					echo $this->form->input('Share.is_admin', array('type' => 'hidden', 'value' => '0'));
					echo $this->form->input('Share.folder_id', array('type' => 'hidden', 'value' => $the_project['Folder']['id']));
					
					//echo $this->form->input('Share.is_able_to_add_other', array('label' => 'Can this member add others?', 'type' => 'select', 'options' => array('0' => 'No', '1' => 'Yes')));
					echo $this->Form->end();
				?>
				<div class="display_message">
					<div class="success me_hide">Member has been successfully added!</div>
					<div class="error me_hide">Add Member Failed</div>
				</div>
				<div class="loader_container me_hide">
					<span class="loader">&nbsp;</span>
				</div>
				<div id="add_proj_member_form_buttons">
					<button class="done">Done</button>
					<button class="cancel">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</div>