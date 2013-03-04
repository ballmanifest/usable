<?php 
	echo $this->Html->css(array('add_another_calendar'));
	echo $this->Html->script(array('user_list'));
?>
<div class="visibility_selection the_visibility_modal the_modal me_absolute">
	<div class="cancel_btn"><span class="cancel icon-remove-sign"></span></div>
	<div class="visibility_selection_wrapper">
		<div id="directory_dd_container">
			<div id="directory_dd" class="me_relative">
				<input type="hidden" value="" name="category" class="selected_category">
				<input type="hidden" value="<?php echo $this->Session->read('Auth.User.id');?>" class="auth_id">
				<a class="dd_select">Please Select</a>
				<span class="me_absolute dd_pointer dd_pointer_down"></span>
			</div>
			<ul id="directory_dd_options" class="me-relative">
				<?php
					foreach($users as $user) {
						$id = $user['User']['id'];
						$name = $user['User']['name'];
				?>
					<li data-userid="<?php echo $id;?>" data-username="<?php echo $name;?>">
					  <input type="hidden" value="<?php echo $id; ?>">
					  <a class="dd_option"><?php echo $name;?></a>
					</li>
				<?php
					}
				?>
			</ul>		
			<div class="btn_n_msg clearfix">
				<span class="done btn btn-success" href="#">Add</span>
				<span class="err_msg">Please select some user </span>
			</div>
	  </div>
	</div>
</div>