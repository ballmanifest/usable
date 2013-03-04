<?php
	echo $this->Html->css(array('ui-lightness/jquery-ui-1.8.23.custom', 'add_project'));
	echo $this->Html->script(array('jquery-ui-1.8.23.custom.min', 'date', 'add_project'));
?>
<div id="add_project_modal" class="me_absolute me_hide">
	<div id="add_proj_modal_container" class="me_relative shadow">
		<div class="btn_container me_absolute"><div class="btn_wrapper"><div class="btn_self"><span class="cross_icon">&nbsp;</span></div></div></div>
		<div id="add_proj_modal_wrapper">
			<div id="add_proj_header">
				<h3 class="add_proj_title">Add New Project</h3>
			</div>
			<div id="add_proj_form">
				<?php 
					echo $this->Form->create('Project', array('action' => 'add'));
					echo $this->form->input('user_id', array('type' => 'hidden', 'value' => $auth_id, 'name' => 'data[Project][user_id]'));
					echo $this->form->input('name', array('label' => 'Name', 'name' => 'data[Project][name]'));
					echo $this->form->input('manager_id', array('label' => 'Manger', 'type' => 'select', 'options' => Set::combine($future_manager, '{n}.User.id', array('{0} {1}', '{n}.User.first_name', '{n}.User.last_name')), 'name' => 'data[Project][manager_id]'));
					echo $this->form->input('start', array('label' => 'Start Date', 'readonly' => true, 'name' => 'data[Project][start]'));
					echo $this->form->input('end', array('label' => 'End Date', 'readonly' => true, 'name' => 'data[Project][end]'));
					echo $this->form->input('budget', array('label' => 'Budget&nbsp;($)', 'placeholder' => '0.00', 'name' => 'data[Project][budget]'));
					echo $this->Form->end();
				?>
				<div class="display_message">
					<div class="success me_hide">This is success message</div>
					<div class="error me_hide">This is error message</div>
				</div>
				<div class="loader_container me_hide">
					<span class="loader">&nbsp;</span>
				</div>
				<div id="form_buttons">
					<button class="cancel">Cancel</button>
					<button class="done">Done</button>
				</div>
			</div>
		</div>
	</div>
</div>