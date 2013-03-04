<div class="calendarEvents view">
<h2><?php  echo __('Calendar Event'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($calendarEvent['CalendarEvent']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Calendar'); ?></dt>
		<dd>
			<?php echo $this->Html->link($calendarEvent['Calendar']['name'], array('controller' => 'calendars', 'action' => 'view', $calendarEvent['Calendar']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($calendarEvent['CalendarEvent']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($calendarEvent['CalendarEvent']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date Start'); ?></dt>
		<dd>
			<?php echo h($calendarEvent['CalendarEvent']['date_start']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date End'); ?></dt>
		<dd>
			<?php echo h($calendarEvent['CalendarEvent']['date_end']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Timezone'); ?></dt>
		<dd>
			<?php echo h($calendarEvent['CalendarEvent']['timezone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is All Day'); ?></dt>
		<dd>
			<?php echo h($calendarEvent['CalendarEvent']['is_all_day']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Repeat'); ?></dt>
		<dd>
			<?php echo h($calendarEvent['CalendarEvent']['is_repeat']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Location'); ?></dt>
		<dd>
			<?php echo h($calendarEvent['CalendarEvent']['location']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Color'); ?></dt>
		<dd>
			<?php echo h($calendarEvent['CalendarEvent']['color']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Availability'); ?></dt>
		<dd>
			<?php echo h($calendarEvent['CalendarEvent']['availability']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Privacy'); ?></dt>
		<dd>
			<?php echo h($calendarEvent['CalendarEvent']['privacy']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($calendarEvent['CalendarEvent']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($calendarEvent['CalendarEvent']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Calendar Event'), array('action' => 'edit', $calendarEvent['CalendarEvent']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Calendar Event'), array('action' => 'delete', $calendarEvent['CalendarEvent']['id']), null, __('Are you sure you want to delete # %s?', $calendarEvent['CalendarEvent']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Calendar Events'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Calendar Event'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Calendars'), array('controller' => 'calendars', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Calendar'), array('controller' => 'calendars', 'action' => 'add')); ?> </li>
	</ul>
</div>
