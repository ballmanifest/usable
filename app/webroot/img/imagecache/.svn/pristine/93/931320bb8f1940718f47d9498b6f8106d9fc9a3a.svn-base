<div class="calendarShares view">
<h2><?php  echo __('Calendar Share'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($calendarShare['CalendarShare']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Requester'); ?></dt>
		<dd>
			<?php echo h($calendarShare['CalendarShare']['requester']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Acceptor'); ?></dt>
		<dd>
			<?php echo h($calendarShare['CalendarShare']['acceptor']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Approved'); ?></dt>
		<dd>
			<?php echo h($calendarShare['CalendarShare']['approved']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($calendarShare['CalendarShare']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($calendarShare['CalendarShare']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Calendar'); ?></dt>
		<dd>
			<?php echo $this->Html->link($calendarShare['Calendar']['name'], array('controller' => 'calendars', 'action' => 'view', $calendarShare['Calendar']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Calendar Share'), array('action' => 'edit', $calendarShare['CalendarShare']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Calendar Share'), array('action' => 'delete', $calendarShare['CalendarShare']['id']), null, __('Are you sure you want to delete # %s?', $calendarShare['CalendarShare']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Calendar Shares'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Calendar Share'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Calendars'), array('controller' => 'calendars', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Calendar'), array('controller' => 'calendars', 'action' => 'add')); ?> </li>
	</ul>
</div>
