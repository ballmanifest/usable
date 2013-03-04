<div class="calendarAdds view">
<h2><?php  echo __('Calendar Add'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($calendarAdd['CalendarAdd']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($calendarAdd['User']['title'], array('controller' => 'users', 'action' => 'view', $calendarAdd['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User Add'); ?></dt>
		<dd>
			<?php echo h($calendarAdd['CalendarAdd']['user_add']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($calendarAdd['CalendarAdd']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($calendarAdd['CalendarAdd']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Calendar Add'), array('action' => 'edit', $calendarAdd['CalendarAdd']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Calendar Add'), array('action' => 'delete', $calendarAdd['CalendarAdd']['id']), null, __('Are you sure you want to delete # %s?', $calendarAdd['CalendarAdd']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Calendar Adds'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Calendar Add'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
