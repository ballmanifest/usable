	<script type="text/javascript">
		$(document).ready(function() {
			$('#menu_items > li').bind('mouseover', openSubMenu);
			$('#menu_items > li').bind('mouseout', closeSubMenu);
			function openSubMenu() {
				$(this).find('ul').css('visibility', 'visible');	
			};
			function closeSubMenu() {
				$(this).find('ul').css('visibility', 'hidden');	
			};
		});
	</script>
	<?php
		$controller = $this->params['controller'];
		$action = $this->params['action'];
		$activeClass = "active_menu";
		$role = (int)$this->Session->read('Auth.User.role');
	?>
    <div id="main_header" class="clearfix top_panel">
		<?php if($this->Session->read('Auth.User.id')): ?>
		<div class="logo"></div>
		<?php endif;?>
        <?php  if($this->params['action']!='login')
		 //echo $this->Html->image('logo.png', array('id' => 'logo'));
		?>
		<?php if ($this->Session->read('Auth.User.id') && $this->Session->read('Auth.User.status')) { ?>
			<ul id="menu_items" class="clearfix top_panel_nav">
				<li class="a_menu_item <?php echo ($controller == 'users' && $action == 'dashboard') ? $activeClass : ''; ?>">
				<?php echo $this->Html->link('Dashboard', array('controller' => 'users', 'action' => 'dashboard')); ?>
				</li>
				<li class="a_menu_item <?php echo ($controller == 'cabinets' && $action == 'index') ? $activeClass : ''; ?>">
				<?php echo $this->Html->link('File Cabinet', array('controller' => 'cabinets', 'action' => 'index')); ?>
				</li>
				<?php if($role == 22): //if($role != 2):?>
				<li class="a_menu_item <?php echo ($controller == 'projects' && $action == 'view') ? $activeClass : ''; ?>">
				<?php echo $this->Html->link('Projects', array('controller' => 'projects', 'action' => 'view')); ?>
				</li>
				<?php endif;?>
				<?php if($role != 2): ?>
				<li class="a_menu_item <?php echo $controller == 'contacts' ? $activeClass : ''; ?>">
				<?php echo $this->Html->link('Contacts', array('controller' => 'contacts', 'action' => 'index')); ?>
				</li>
				<?php endif;?>
				<?php if($role != 2): ?>
				<li class="a_menu_item <?php echo ($controller == 'calendars' && $action == 'index') ? $activeClass : ''; ?>">
				<?php echo $this->Html->link('Calendar', array('controller' => 'calendars', 'action' => 'index')); ?>
				</li>
				<?php endif;?>
				<?php if($role == 22): //if($role != 2): ?>
				<li class="a_menu_item <?php echo ($controller == 'users' && $action == 'resources') ? $activeClass : ''; ?>">
				<?php echo $this->Html->link('Task Tracker', array('controller' => 'users', 'action' => 'resources')); ?>
				</li>
				<?php endif;?>
				<li id="apps" class="a_menu_item <?php echo $action == 'apps' ? $activeClass : ''; ?>">
					<?php echo $this->Html->link('Apps', 'http://www.filocity.com/apps/'); ?>
					<ul>
						<div class="shadow">
							<li>
								<?php echo $this->Html->link('Cloud Connect for PC', 'https://secure.filocity.com/office_cloud.zip'); ?>
							</li>
						</div>
					</ul>
				</li>
				<?php if($role != 2): ?>
				<li id="navgear">
					<a href="javascript::void(0)" class="setting" id="gear"></a>
					<ul>
						<div class="shadow">
							<li>
								<?php echo $this->Html->link('Account Settings', array('controller' => 'users', 'action' => 'dashboard')); ?>							
							</li>
							<li>
								<?php echo $this->Html->link('Manage Members', array('controller' => 'users', 'action' => 'managemembers')); ?>							
							</li>
							<li>
								<?php echo $this->Html->link('Upgrade Account', array('controller' => 'users', 'action' => 'dashboard'), array('class' => 'data_uses_title')); ?>							
							</li>		
							<li>
								<?php echo $this->Html->link('Help and Support', 'http://help.filocity.com', array('target' => '_new')); ?>							
							</li>		
							<li>
								<?php echo $this->Html->link('Billing Info', array('controller' => 'users', 'action' => 'dashboard', '#'=>'billing_info')); ?>							
							</li>
							<li>		
								<?php echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout')); ?>
							</li>
						</div>
					</ul>
				</li>
				<?php endif;?>
				<?php if($role == 2): ?>
				<li class="a_menu_item" style="width: 1px">&nbsp;</li>
				<?php endif;?>
			</ul>
			<?php } ?>
    </div>
	<?php if ($action != 'registration') 
	{ 
	?>
    <div id="link_header">
	<?php
	//echo $this->Html->link('Sign Up', array('controller' => 'users', 'action' => 'registration'), array('class' => 'highlight'));
	?>
    </div>
<?php } else { ?>
    <div id="link_header">
	<?php
	//echo $this->Html->link('Log In', array('controller' => 'users', 'action' => 'login'), array('class' => 'highlight'));
	?>
    </div>
<?php } ?>