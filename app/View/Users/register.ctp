<div class="users form">
<?php echo $this->Form->create('User', array('action' => 'register')); ?>
	<fieldset>
		<legend><?php echo __('Add User'); ?></legend>
	<?php
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
		echo $this->Form->input('email');
		echo $this->Form->input('password', array('value' => ''));
		echo $this->Form->input('department');
		echo $this->Form->input('position');
		echo $this->Form->input('title');
		echo $this->Form->input('state');
		echo $this->Form->input('city');
		echo $this->Form->input('country');
		echo $this->Form->input('zip');
		echo $this->Form->input('trial_end');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
