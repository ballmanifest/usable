<div class="notices view">
<h2><?php  echo __('Notice'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($notice['Notice']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($notice['User']['id'], array('controller' => 'users', 'action' => 'view', $notice['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Notice Type'); ?></dt>
		<dd>
			<?php echo h($notice['Notice']['notice_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Itemid'); ?></dt>
		<dd>
			<?php echo h($notice['Notice']['itemid']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Item Type'); ?></dt>
		<dd>
			<?php echo h($notice['Notice']['item_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($notice['Notice']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($notice['Notice']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($notice['Notice']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Notice'), array('action' => 'edit', $notice['Notice']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Notice'), array('action' => 'delete', $notice['Notice']['id']), null, __('Are you sure you want to delete # %s?', $notice['Notice']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Notices'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Notice'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>