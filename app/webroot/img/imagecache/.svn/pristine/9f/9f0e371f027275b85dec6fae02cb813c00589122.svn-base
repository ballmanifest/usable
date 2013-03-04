<?php
	echo $this->Html->css( array('account') );
	echo $this->Html->script( array('plupload.full.js', 'account') );
?>
<div class="account-container">
	<div class="account-wrapper">
	<?php echo $this->Form->create('User', array('type' => 'file'));?>
		<div class="account-header">
			<h2>My Account Page</h2>
		</div>	
		<div class="account-content clearfix">
			<div class="form_detail_section">
				<div class="personal_detail">
					<h4 class="section_header">Personal Details</h4>
					<div style="float:left;width:357px;">
						<?php
							echo $this->Form->input('email', array('label' => 'Email'));
							echo $this->Form->input('password', array('label' => 'Password'));
							echo $this->Form->input('confirm_password', array('type' => 'password', 'label' => 'Password (repeat)'));
							echo $this->Form->input('id', array('type' => 'hidden'));
							echo $this->Form->input('first_name', array('label' => 'First Name'));
							echo $this->Form->input('last_name', array('label' => 'Last Name'));
							echo $this->Form->input('title', array('label' => 'Title'));						
						?>
						
						<div id="account_photo_pane" style="float:left;clear:both;background:#fafafa;border:1px solid #c0c0c0;">
							<div class="profile_image" style="padding:1px;float:left;height:51px;border-right:1px solid #c0c0c0;">
								<img id="new_member_profile_photo" width="46" height="51" border="0" src="image/profile/<?php echo $current_user_id;?>/small.jpg" alt="Photo" />
							</div>
							<div style="float:left;height:64px;line-height:53px;height:53px;width:305px;text-align:center;"><input type="button" id="filepick" value="Browse" /></div>
							<input type="hidden" id="new_member_temp_photo_name" name="data[User][profile_thumb_temp]" />
						</div>
					</div>
					<div style="float:left;width:357px;margin-left:50px;">
						<?php
							echo $this->Form->input('mail_address_1', array('label' => 'Address Line 1'));
							echo $this->Form->input('mail_address_2', array('label' => 'Address Line 2'));
							echo $this->Form->input('city', array('label' => 'City'));
							echo $this->Form->input('state_id', array('type' => 'select', 'label' => 'State', 'options' => $state));
							echo $this->Form->input('zip', array('label' => 'Zip'));
							echo $this->Form->input('office_phone', array('label' => 'Phone (office)'));
							echo $this->Form->input('mobile', array('label' => 'Phone (mobile)'));
							echo $this->Form->input('home_phone', array('label' => 'Phone (home)'));
						?>
					</div>
				</div>
			</div>
		</div>
		<div style="float:right;clear:both;">
		<?php echo $this->Form->end(__('Save Details'));?>
		</div>
	</div>
</div>