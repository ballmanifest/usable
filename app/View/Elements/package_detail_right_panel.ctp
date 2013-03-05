<div id="registration_panel_package_info">
	<?php 
		$nameSize = '38px;';
		$name = $package['Package']['public_name'];
		if(strtolower($name) == 'enterprise') $nameSize = '35px;';
	?>
	<div class="heading_about" style="font-size:<?php echo $nameSize;?>">	
		<?php echo $name;?>
		<p class="small_heading">ACCOUNT</p>
	</div>
	<?php 
		$tail = '';
		$size = 100;
		if($package['Package']['storage'] > 50) {
			$tail = 'SPACE!';
			$size = 48;
		}
	?>
	<div class="package_size" style="font-size:<?php echo $size. 'px;';?>">
		<?php
			echo $package['Package']['storage_to_show'] . '<br>' . $tail; 
		?>
	</div>
	<div class="descritions_paragraph">
		<p><?php echo $package['Package']['description'];?></p>
	</div>
	<ul class="features">
		<li>This is a <?php echo $package['Package']['max_member'];?> user account.</li>
		<li>Unlimited Projects.</li>
	</ul>
	<div class="change_package">
		<?php echo $this->Html->link('CHANGE<br>PACKAGE', 'http://www.filocity.com/pricing/', array('escape' => false));?>
	</div>
</div>