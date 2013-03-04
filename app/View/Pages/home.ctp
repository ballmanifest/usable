<h3>This is Home Page</h3>
<?php
	echo $this->Html->link('Login', array('controller' => 'users', 'action' => 'login'));
	echo '<br><br>If not a member yet? <br><br>';
	echo $this->Html->link('Register', array('controller' => 'users', 'action' => 'register'));
?>

<div>
	<p style="margin: 20px;font-size:20px;">Coming soon...</p>
</div>