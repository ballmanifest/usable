<?php
	echo $this->Html->css('forgot_password');
?>


<div class="forgot_wraper">
<h1>Please enter yor login Email</h1>
<?php echo $this->Form->create('User', array('action' => 'forgot_password', 'inputDefaults' => array('label' => false,'div' => false ))); ?>


		<?php
		    echo '<label>Email Id</label>';
			echo $this->Form->input('email', array('value' => '', 'id' => 'txtusername',  'default' => ''));
			
			echo '<div style="width:100%;margin-bottom: 18px;">';
			
		    echo "</div>";
			?>
   
			
	<div id="buttons">
		<?php
		
			echo $this->Form->submit('',array('id' => 'submit_btn'));
			
		?>
	</div>


<?php echo $this->Form->end(); ?>
</div>