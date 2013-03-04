<?php for($i = 0; $i < count($memberlist); $i++){ ?>
	<div class="member clearfix">
		<?php echo $this->Html->image($memberlist[$i]['User']['profile_picture'], array('class' => 'profile_picture')); ?><?php echo $memberlist[$i]['User']['first_name']." ".$memberlist[$i]['User']['last_name']; ?> 
		
		<?php if($memberlist[$i]['User']['role'] == 1) { ?>
			<span class="role administrator">Administrator</span>
		<?php }elseif($memberlist[$i]['User']['status'] == 0) {?>
			<span class="role unactivated">Unactivated - <a href="#" data-user-id="<?php echo $memberlist[$i]['User']['id']; ?>" class="resend_auth_mail">Resend Activation Email</a></span>
		<?php } ?>
		
		<div class="detail"><?php echo count($memberlist[$i]['Task']); ?> tasks assigned, <?php echo $memberlist[$i]['User']['active_tasks']; ?> active</div>
		<div class="detail">Budget Spent: <b>0%</b>
			<?php if($currentadmin == true){ ?>
				<?php echo $this->Html->link("edit", array('action' => 'editmember', $memberlist[$i]['User']['id']), array('class' => 'edit')); ?>
			<?php } ?>
		</div>
	</div>
<?php } ?>