<?php
	$controller = $this->params['controller'];
	$action = $this->params['action'];
	$activeClass = "active_menu";
	echo $this->Html->css(array('header','menu'));
?>
<div class="header">
	<div id="inner-header" class="clearfix">
		<div class="fivecol first clearfix">
			<div class="h1" id="logo">
				<?php echo $this->Html->link($this->Html->image('big-logo.png'), 'http://filocity.com', array('escape' => false));?>
			</div>					
		</div>
		<div class="sevencol last clearfix">
			<div class="topheader-outer-fix clearfix">
				<div class="topheader-menu-outer">
					<div class="topheader-left-corner"></div>
					<div class="topheader-menu">
						<ul>
							<li><a href="http://www.filocity.com/pricing/" class=""><span>Buy It Now</span></a>&nbsp; &nbsp;|</li>
							<li><a href="https://secure.filocity.com/users/registration/14-day-free-trial-cc" class=""><span>Try It Free</span></a>&nbsp; &nbsp;|</li>
							<li><a href="https://secure.filocity.com/" class=""><span>Login Now</span></a></li>
						</ul>							
					</div>
					<div class="topheader-right-corner"></div>
					<div class="div-addthis">
						<div class="addthis_toolbox addthis_default_style "></div>
					</div>
				</div>
			</div>
			<div class="div-addthis"></div>
		</div>
		<div class="clearfix"></div>
		<nav role="navigation">
			<ul class="nav top-nav clearfix" id="menu-main">
				<li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-home menu-item-1006" id="menu-item-1006"><a href="http://www.filocity.com/">Home</a></li>
				<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-978" id="menu-item-978"><a href="http://www.filocity.com/apps/">Apps</a></li>
				<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-986" id="menu-item-986"><a href="http://www.filocity.com/feature/online-document-management/">Features</a></li>
				<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-977" id="menu-item-977"><a href="http://www.filocity.com/solutions/">Solutions</a></li>
				<li class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-12 current_page_item menu-item-976" id="menu-item-976"><a href="http://www.filocity.com/pricing/">Pricing</a></li>
			</ul>
		</nav>
	</div>
</div>

