<div class="subtasks index">
	<h2><?php echo __('Subtasks'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('task_id'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($subtasks as $subtask): ?>
	<tr>
		<td><?php echo h($subtask['Subtask']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($subtask['Task']['title'], array('controller' => 'tasks', 'action' => 'view', $subtask['Task']['id'])); ?>
		</td>
		<td><?php echo h($subtask['Subtask']['description']); ?>&nbsp;</td>
		<td><?php echo h($subtask['Subtask']['created']); ?>&nbsp;</td>
		<td><?php echo h($subtask['Subtask']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $subtask['Subtask']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $subtask['Subtask']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $subtask['Subtask']['id']), null, __('Are you sure you want to delete # %s?', $subtask['Subtask']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Subtask'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Tasks'), array('controller' => 'tasks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Task'), array('controller' => 'tasks', 'action' => 'add')); ?> </li>
	</ul>
</div>