<div class="purchaseLogs view">
<h2><?php  echo __('Purchase Log'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($purchaseLog['PurchaseLog']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($purchaseLog['User']['title'], array('controller' => 'users', 'action' => 'view', $purchaseLog['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Full Name'); ?></dt>
		<dd>
			<?php echo h($purchaseLog['PurchaseLog']['full_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($purchaseLog['PurchaseLog']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Business Plan'); ?></dt>
		<dd>
			<?php echo h($purchaseLog['PurchaseLog']['business_plan']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Price'); ?></dt>
		<dd>
			<?php echo h($purchaseLog['PurchaseLog']['price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Member Since'); ?></dt>
		<dd>
			<?php echo h($purchaseLog['PurchaseLog']['member_since']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Payment'); ?></dt>
		<dd>
			<?php echo h($purchaseLog['PurchaseLog']['last_payment']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Expires On'); ?></dt>
		<dd>
			<?php echo h($purchaseLog['PurchaseLog']['expires_on']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($purchaseLog['PurchaseLog']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($purchaseLog['PurchaseLog']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Purchase Log'), array('action' => 'edit', $purchaseLog['PurchaseLog']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Purchase Log'), array('action' => 'delete', $purchaseLog['PurchaseLog']['id']), null, __('Are you sure you want to delete # %s?', $purchaseLog['PurchaseLog']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Purchase Logs'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Purchase Log'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
