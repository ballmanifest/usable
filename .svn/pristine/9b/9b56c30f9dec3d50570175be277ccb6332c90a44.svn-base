<div class="purchaseLogs form">
<?php echo $this->Form->create('PurchaseLog'); ?>
	<fieldset>
		<legend><?php echo __('Edit Purchase Log'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('full_name');
		echo $this->Form->input('email');
		echo $this->Form->input('business_plan');
		echo $this->Form->input('price');
		echo $this->Form->input('member_since');
		echo $this->Form->input('last_payment');
		echo $this->Form->input('expires_on');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('PurchaseLog.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('PurchaseLog.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Purchase Logs'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
