<?php echo $this->Html->css('login');?>
<div class="login_wrapper me_absolute shadow">
	<?php echo $this->Html->link('', 'http://filocity.com', array('class' => 'login_modal_close icon-remove me_absolute shadow', 'escape' =>  false));?>
	<?php echo $this->Html->link('Sign Up', array('controller' => 'users', 'action' => 'registration/14-day-free-trial-cc' ), array('class' => 'me_absolute', 'id' => 'link_signup'));?>
	<div class="login_background">
		<div class="mini_logo">
			<?php echo $this->Html->image('logo.png');?>
		</div>
		<h2 class="sign_in">Sign In</h2>
		<div class="right_cantainer me_relative">
			<div id="login_form">
				<?php 
					echo $this->Form->create('User', array('action' => 'login'));
					echo $this->Form->input('email', array('label' => 'Email', 'value' => '', 'id' => 'txtusername',  'default' => ''));
					echo $this->Form->input('password', array('label' => 'Password', 'value' => '', 'id' => 'txtpassword',  'default' => ''));
					echo $this->Form->input('checkbox', array('label' => 'Remember me', 'type'=>'checkbox',  'default' => ''));
					echo $this->Form->submit('Sign In',array('id' => 'submit_login', 'div' => false));
					echo $this->Form->end();					
				?>
			</div>
			<?php echo $this->Html->link('Forgot Password', array('controller' => 'users', 'action' => 'forgot_password'), array('class' => 'me_absolute', 'id' => 'forgot_password'));?>
	 </div>
	</div>
</div>
<script type="text/javascript">
	$(function() {
		$('.login_modal_close').on('click', function() {
			$('.login_wrapper').hide();
		});
	});
</script>