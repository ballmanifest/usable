<?php 
	echo $this->Html->css('purchaselogs');
?>
<script type="text/javascript">
$(document).ready(function(){
	$("tr:even").css("background-color", "#EFEFEF");
	$("tr:odd").css("background-color", "#FDFDFD");
});
</script>
<div class="purchaseLogs index">
	<h2 style="color:#4690C5">Purchase Logs</h2>
	<table cellpadding="0" cellspacing="0" border="1" style="width:965px; text-align:left; border-color:#D0D0D0; border-style:groove;">
	<tr>
			<th><?php echo $this->Paginator->sort('full_name'); ?></th>
			<th><?php echo $this->Paginator->sort('email'); ?></th>
			<th><?php echo $this->Paginator->sort('business_plan'); ?></th>
			<th><?php echo $this->Paginator->sort('price'); ?></th>
			<th><?php echo $this->Paginator->sort('member_since'); ?></th>
			<th><?php echo $this->Paginator->sort('user #'); ?></th>
			<th><?php echo $this->Paginator->sort('last_payment'); ?></th>
			<th><?php echo $this->Paginator->sort('expires_on'); ?></th>
			<th class="actions"><?php echo __(' '); ?></th>
	</tr>
	<?php
	foreach ($purchaseLogs as $purchaseLog): ?>
	<tr>
		<td><?php echo h($purchaseLog['PurchaseLog']['full_name']); ?>&nbsp;</td>
		<td><?php echo h($purchaseLog['PurchaseLog']['email']); ?>&nbsp;</td>
		<td><?php echo h($purchaseLog['PurchaseLog']['business_plan']); ?>&nbsp;</td>
		<td><?php echo '$'.h($purchaseLog['PurchaseLog']['price']); ?>&nbsp;</td>
		<td><?php echo h(date('M d Y', strtotime($purchaseLog['PurchaseLog']['member_since']))); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($purchaseLog['User']['id'], array('controller' => 'users', 'action' => 'view', $purchaseLog['User']['id'])); ?>
		</td>
		<td><?php echo '$'.h($purchaseLog['PurchaseLog']['last_payment']); ?>&nbsp;</td>
		<td><?php echo h(date('M d Y', strtotime($purchaseLog['PurchaseLog']['expires_on']))); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('History |'), array('action' => 'edit', $purchaseLog['PurchaseLog']['id']));?>
			<?php echo $this->Html->link(__('Detail'), array('action' => 'view', $purchaseLog['PurchaseLog']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<div class="page-nav">
		<div class="records">
			<p>
			<?php
			echo $this->Paginator->counter(array(
			'format' => __('Showing {:start}-{:current} Records of {:count}')
			));
			?>	</p>
		</div>

		<div class="paging">
		<?php
			echo $this->Paginator->prev('<< ' . __('previous  '), array(), null, array('class' => 'prev disabled'));
			echo $this->Paginator->numbers(array('separator' => ''));
			echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'next disabled'));
		?>
		</div>
	</div>
</div>
