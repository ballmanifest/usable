<div class="subtasks view">
<h2><?php  echo __('Subtask'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($subtask['Subtask']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Task'); ?></dt>
		<dd>
			<?php echo $this->Html->link($subtask['Task']['title'], array('controller' => 'tasks', 'action' => 'view', $subtask['Task']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($subtask['Subtask']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($subtask['Subtask']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($subtask['Subtask']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Subtask'), array('action' => 'edit', $subtask['Subtask']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Subtask'), array('action' => 'delete', $subtask['Subtask']['id']), null, __('Are you sure you want to delete # %s?', $subtask['Subtask']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Subtasks'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Subtask'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tasks'), array('controller' => 'tasks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Task'), array('controller' => 'tasks', 'action' => 'add')); ?> </li>
	</ul>
</div>
