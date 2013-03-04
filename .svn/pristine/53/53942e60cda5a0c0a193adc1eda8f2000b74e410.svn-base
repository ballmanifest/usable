<div class="calendarEvents form">
<?php echo $this->Form->create('CalendarEvent'); ?>
	<fieldset>
		<legend><?php echo __('Edit Calendar Event'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('calendar_id');
		echo $this->Form->input('title');
		echo $this->Form->input('description');
		echo $this->Form->input('date_start');
		echo $this->Form->input('date_end');
		echo $this->Form->input('timezone');
		echo $this->Form->input('is_all_day');
		echo $this->Form->input('is_repeat');
		echo $this->Form->input('location');
		echo $this->Form->input('color');
		echo $this->Form->input('availability');
		echo $this->Form->input('privacy');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('CalendarEvent.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('CalendarEvent.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Calendar Events'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Calendars'), array('controller' => 'calendars', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Calendar'), array('controller' => 'calendars', 'action' => 'add')); ?> </li>
	</ul>
</div>
