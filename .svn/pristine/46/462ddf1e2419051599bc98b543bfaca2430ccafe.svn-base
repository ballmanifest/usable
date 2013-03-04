<?php 
	$this->start('css');
		echo $this->Html->css(array('grid','users_managemembers'));
	$this->end(); 
	$this->start('script');
		echo $this->Html->script(array('users_managemembers'));
	$this->end();
?>

<div id="manage_members">
	<div class="row-fluid">
		<div class="span6">
			<h3 class="header">Manage Company Members</h3>
			<?php
				echo $this->element('users'.DS.'managemembers', array('memberlist' => $admins, 'currentadmin' => $currentadmin)); 
				echo $this->element('users'.DS.'managemembers', array('memberlist' => $users, 'currentadmin' => $currentadmin)); 
			?>
				<?php echo $this->Html->link("+ New Member", '/users/addmember', array("class" => "add_member")); ?>
		</div>
		<div class="span6">
			<div id="frame_container">
				<iframe class="autoHeight" scrolling="auto" frameborder="0" id="member_frame"></iframe>
			</div>
		</div>
	</div>
</div>