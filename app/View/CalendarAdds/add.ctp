<div class="calendarAdds form">
<?php echo $this->Form->create('CalendarAdd'); ?>
	<fieldset>
		<legend><?php echo __('Add Calendar Add'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('user_add');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Calendar Adds'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
