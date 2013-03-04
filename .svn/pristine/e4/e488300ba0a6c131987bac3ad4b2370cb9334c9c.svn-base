<?php
	$controller = $this->params['controller'];
	$action = $this->params['action'];
	$activeClass = "active_menu";
?>
<div id="main_header">
	<div id="header_menu">
		<?php if ($this->Session->read('Auth.User.id') && $this->Session->read('Auth.User.status') && (int)$this->Session->read('Auth.User.role') == 2) { ?>
		<ul id="menu_items" class="clearfix" style="float:right">
			<li class="a_menu_item">
				<?php echo $this->Html->link('Dashboard', array('controller' => 'users', 'action' => 'warning'), array('class' => 'warningModal'));?>
			</li>
			<li class="a_menu_item <?php echo ($controller == 'cabinets' && $action == 'index') ? $activeClass : ''; ?>">
			<?php echo $this->Html->link('File Cabinet', array('controller' => 'cabinets', 'action' => 'index')); ?>
			</li>
			<li class="a_menu_item">
				<?php echo $this->Html->link('Apps', array('controller' => 'users', 'action' => 'warning'), array('class' => 'warningModal'));?>
			</li>
			<li class="a_menu_item">
			<?php echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout')); ?>
			</li>
			<li class="a_menu_item" style="width:1px">&nbsp;</li>
		</ul>
		<?php } ?>
		<?php  if($this->params['action']!='login') echo $this->Html->image('logo.png', array('id' => 'logo'));?>
	</div>
</div>
