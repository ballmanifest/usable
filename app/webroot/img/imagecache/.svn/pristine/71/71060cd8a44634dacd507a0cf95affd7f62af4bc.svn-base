<?php
	if(!$this->Session->read('Auth.User.id')) return 0;
	echo $this->Html->css('forgot_password');
?>
<div class="forgot_wraper">
<h1>Change Password</h1>
<?php echo $this->Form->create('User', array('inputDefaults' => array())); ?>
		<?php
		    echo '<div class="input"><label>Email Id:</label> <strong>'. $email .'</strong></div>';
			echo $this->Form->input('id', array('type' => 'hidden', 'value' => $user_id));
			echo $this->Form->input('password', array('label' => 'New Password', 'value' => '', 'id' => 'user_password'));
			echo $this->Form->input('confirm_password', array('type' => 'password', 'label' => 'Repeat New Password', 'value' => '', 'id' => 'confirm_password'));
			echo '<div style="width:100%;margin-bottom: 18px;">';
		    echo "</div>";
		?>
	<div id="submit_button">
		<?php		
			echo $this->Form->submit('',array('id' => 'change_password'));			
		?>
	</div>
<?php echo $this->Form->end(); ?>
</div>