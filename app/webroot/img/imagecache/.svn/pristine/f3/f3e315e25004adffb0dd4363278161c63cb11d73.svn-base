<div class="calendarShares index">
	<h2><?php echo __('Calendar Shares'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('requester'); ?></th>
			<th><?php echo $this->Paginator->sort('acceptor'); ?></th>
			<th><?php echo $this->Paginator->sort('approved'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('calendar_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($calendarShares as $calendarShare): ?>
	<tr>
		<td><?php echo h($calendarShare['CalendarShare']['id']); ?>&nbsp;</td>
		<td><?php echo h($calendarShare['CalendarShare']['requester']); ?>&nbsp;</td>
		<td><?php echo h($calendarShare['CalendarShare']['acceptor']); ?>&nbsp;</td>
		<td><?php echo h($calendarShare['CalendarShare']['approved']); ?>&nbsp;</td>
		<td><?php echo h($calendarShare['CalendarShare']['created']); ?>&nbsp;</td>
		<td><?php echo h($calendarShare['CalendarShare']['modified']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($calendarShare['Calendar']['name'], array('controller' => 'calendars', 'action' => 'view', $calendarShare['Calendar']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $calendarShare['CalendarShare']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $calendarShare['CalendarShare']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $calendarShare['CalendarShare']['id']), null, __('Are you sure you want to delete # %s?', $calendarShare['CalendarShare']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Calendar Share'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Calendars'), array('controller' => 'calendars', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Calendar'), array('controller' => 'calendars', 'action' => 'add')); ?> </li>
	</ul>
</div>
