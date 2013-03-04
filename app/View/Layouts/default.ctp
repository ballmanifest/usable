<?php
$cakeDescription = 'Filocity 2.0';
?>
<!doctype html>
<html>
    <head>
	<?php echo $this->Html->charset(); ?>
	<title>
	    <?php echo $cakeDescription ?>:
	    <?php echo $title_for_layout; ?>
	</title>
	<?php
	echo $this->Html->meta('icon');
	echo $this->Html->css(array('reset', 'normalize', 'formalize', 'font-awesome-css/font-awesome.css', 'header', 'common'));
	echo $this->Html->script(array('jquery', 'jquery.formalize.min'));
	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');
	
	$no_cc_class = '';
	$action = $this->action;
	
	if(!empty($this->request->params['pass'])) :
		$param = $this->request->params['pass'][0];
		if($param == '14-day-free-trial' || $param == '14-day-free-trial-cc') :
		$no_cc_class = 'bg_for_no_cc';
	?>
	<style type="text/css">
		#link_header {
			display: none !important;
		}
		#wrapper_to_container_elements {
			background: none !important;
			border: none !important;
			box-shadow: none !important;
		}
	</style>
	<?php
		endif;
	elseif ('login' === $action) :
			$no_cc_class = 'bg_for_no_cc';
	endif;
	?>
	<script type="text/javascript">
	    var _ROOT = "<?php echo $this->Html->url('/', true); ?>";
		var _controller = "<?php echo $this->request->params['controller'];?>";
		var _user_role = "<?php echo $this->Session->read('Auth.User.role');?>";
		var agenda = "";
	</script>
    </head>
    <body>
	<?php
	$controller = $this->request->params['controller'];
	$action = $this->request->params['action'];
	?>
	<?php if($controller =='' || 'index') { ?>
		<div id="grand_container" class="clearfix <?php echo $no_cc_class;?>">
		<div id="main_container" class="<?php echo $no_cc_class;?>">
	<?php } else { ?>
	<div class="main_container">
		<div class="main_container2 clearfix">  
	<?php } ?>
			<div class="header_nav_container">
				<?php 
					if(2 == (int) $this->Session->read('Auth.User.role')) {
						echo $this->element('guest_header'); 
					} else if($action == 'registration' && empty($this->request->params['pass'])) {
						echo $this->element('pricing_header'); 
					} else {
						echo $this->element('header'); 
					}
				?>		
			</div>
		<?php if($this->params['controller']=='users' and $this->params['action']=='login' and !$this->request->is('post')) { 
			echo $this->Session->flash();
		    echo $this->fetch('content');
		 } else { 
		?>
			<div id="wrapper_to_container_elements" class="clearfix">
			<?php
				echo $this->Session->flash();
				echo $this->fetch('content');
			?>
			</div>
		<?php } ?>
	    </div>
		<?php echo $this->element('footer');?>
	</div>
	<?php
		//echo $this->element('sql_dump'); 
	?>
	<div id="filocity_modal_dialog_outer" style="top:0;left:0;width:100%;height:100%;position:fixed;display:none;"></div>
    </body>
</html>
