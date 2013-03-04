<div class="calendars view">
<h2><?php  echo __('Calendar'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($calendar['Calendar']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($calendar['Calendar']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($calendar['Calendar']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($calendar['Calendar']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Calendar'), array('action' => 'edit', $calendar['Calendar']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Calendar'), array('action' => 'delete', $calendar['Calendar']['id']), null, __('Are you sure you want to delete # %s?', $calendar['Calendar']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Calendars'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Calendar'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Calendar Events'), array('controller' => 'calendar_events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Calendar Event'), array('controller' => 'calendar_events', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Calendar Events'); ?></h3>
	<?php if (!empty($calendar['CalendarEvent'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Calendar Id'); ?></th>
		<th><?php echo __('Title'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Date Start'); ?></th>
		<th><?php echo __('Date End'); ?></th>
		<th><?php echo __('Timezone'); ?></th>
		<th><?php echo __('Is All Day'); ?></th>
		<th><?php echo __('Is Repeat'); ?></th>
		<th><?php echo __('Location'); ?></th>
		<th><?php echo __('Color'); ?></th>
		<th><?php echo __('Availability'); ?></th>
		<th><?php echo __('Privacy'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($calendar['CalendarEvent'] as $calendarEvent): ?>
		<tr>
			<td><?php echo $calendarEvent['id']; ?></td>
			<td><?php echo $calendarEvent['calendar_id']; ?></td>
			<td><?php echo $calendarEvent['title']; ?></td>
			<td><?php echo $calendarEvent['description']; ?></td>
			<td><?php echo $calendarEvent['date_start']; ?></td>
			<td><?php echo $calendarEvent['date_end']; ?></td>
			<td><?php echo $calendarEvent['timezone']; ?></td>
			<td><?php echo $calendarEvent['is_all_day']; ?></td>
			<td><?php echo $calendarEvent['is_repeat']; ?></td>
			<td><?php echo $calendarEvent['location']; ?></td>
			<td><?php echo $calendarEvent['color']; ?></td>
			<td><?php echo $calendarEvent['availability']; ?></td>
			<td><?php echo $calendarEvent['privacy']; ?></td>
			<td><?php echo $calendarEvent['created']; ?></td>
			<td><?php echo $calendarEvent['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'calendar_events', 'action' => 'view', $calendarEvent['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'calendar_events', 'action' => 'edit', $calendarEvent['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'calendar_events', 'action' => 'delete', $calendarEvent['id']), null, __('Are you sure you want to delete # %s?', $calendarEvent['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Calendar Event'), array('controller' => 'calendar_events', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
