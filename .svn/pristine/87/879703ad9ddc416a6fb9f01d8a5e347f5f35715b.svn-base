<?php
	if(!$isValidPackage) return false;
	echo $this->Html->css( array('ui-lightness/jquery-ui-1.8.23.custom', 'registration') );
	echo $this->Html->script( array('date', 'jquery.mtz.monthpicker', 'registration') );
	$card_names = array('master' => 'Master Card', 'visa' => 'Visa Card', 'disc' => 'Discover Card', 'amex' => 'American Express Card');
	$monthNames = array('01' => '01 - January', '02' => '02 - February', '03' => '03 - March', '04' => '04 - April', '05' => '05 - May', '06' => '06 - June', '07' => '07 - July', '08' => '08 - August', '09' => '09 - September', '10' => '10 - October', '11' => '11 - November', '12' => '12 - December');
	if($package_name == '14-day-free-trial' || $package_name == '14-day-free-trial-cc' ) {
	echo $this->Html->script('filocity_validation');
?>
	<style type="text/css">
		div.error-message {
			clear: both;
			margin: 3px 0 0;
			width: 300px;
		}
		#UserStateId {
			font-family: Arial;
			height: 32px;
			margin-bottom: 0;
			margin-top: 0;
			width: 200px !important;
		}
		.expdate {
			width: 50% !important; 
			float:left;
		}
		.state {
			margin-left: 82px !important;
		}
		.expdate input {
			 width: 190px !important;
		}
		.zip input {
			margin-left: 0px !important;
			width: 158px !important;
		}
		.cvv input {
			margin-left: 25px !important;
			width: 165px !important;
		}
		#filocity_registration_no_cc_form_wrapper .is_agreed {
			left: 65px;
			bottom: 125px;
		}
		#UserCardExpirationDateMonth, #UserCardExpirationDateYear {
			border: 1px solid #CCCCCC;
			border-radius: 5px 5px 5px 5px;
			height: 28px;
			margin-right: 3px !important;
		}
		#UserCardExpirationDateYear {
			margin-left: 3px !important;
		}
		div.input.date {
			float: left;
			margin: 15px 0 0 45px;
			width: 203px;
			line-height: 25px;
		}
		#UserSecurityCode {
			margin-left: 10px !important;
		}
		div.free-trial-cc {
			padding-top: 8px;
		}
	</style>

	<div id="filocity_registration_no_cc_form">
		<div id="filocity_modal_dialog" class="shadow">
			<div class="btn_container me_absolute">
				<div class="btn_wrapper">
					<div class="btn_self">
						<span class="cross_icon">&nbsp;</span>
					</div>
				</div>
			</div>
		</div>
		<div id="filocity_registration_no_cc_form_wrapper" class="relative">
			<?php echo $this->Form->create('User', array('inputDefaults' => array('class' => 'required', 'label' => false, 'readonly' => !$isValidPackage), 'data-trial' => 'trial', 'data-step' => 'step1' )); ?>
			<?php if($package_name == '14-day-free-trial'  ) : ?><p class="no_cc_req">No Credit Card Required</p><input type="hidden" readonly class="no_cc_required" value="1"><?php endif; ?>
			<div class="error-message me_hide">* Please complete all required fields.</div>
			<div id="14-day-free-trial">
			<?php	                
				echo $this->Form->input('first_name', array('placeholder' => 'First Name*'));
				echo $this->Form->input('last_name', array('placeholder' => 'Last Name*'));
				echo $this->Form->input('company_name', array('placeholder' => 'Company or organization*'));
				echo $this->Form->input('package_id', array('type' => 'hidden', 'value' => !empty($package_id) ? $package_id : ''));
				echo $this->Form->input('email', array('placeholder' => 'Email*'));	
				echo $this->Form->input('password', array('placeholder' => 'Password*', 'value' => ''));
				echo $this->Form->input('confirm_password', array('type' => 'password', 'placeholder' => 'Confirm password*', 'value' => ''));
			?>
			</div>
			<?php if ( $package_name == '14-day-free-trial-cc') : ?>
			<div id="14-day-free-trial-cc" class="free-trial-cc me_hide">
				<div class="cc-validity-error-message me_hide">*Invalid Credit Card expiration date.</div>
				<?php 
					echo $this->Form->input('card_name', array('label' => false,'options' => $card_names, 'value' => 'master', 'div' => 'registration_select_container'));                                 
					echo $this->Form->input('card_number', array('type' => 'text', 'placeholder' => 'Card Number*', 'maxlength' => '19'));
					echo $this->Form->input('card_expiration_date', array('label' => false, 'type' => 'date', 'dateFormat' => 'MY', 'default' => date('Y-m-d', strtotime('+1 months')), 'minYear' => date('Y'), 'maxYear' => date('Y', strtotime("+10 years")), 'orderYear' => 'asc', 'separator' => '/', 'monthNames' => $monthNames));
					echo $this->Form->input('security_code', array('type' => 'text', 'maxlength' => '4', 'placeholder' => 'Security Code*', 'div' => 'cvv input text'));
					echo $this->Form->input('country_id', array('label' => false, 'value' => '223', 'div' => 'registration_select_container country' ));										
					echo $this->Form->input('mail_address_1', array('placeholder' => 'Address*'));
					echo $this->Form->input('mail_address_2', array('placeholder' => 'Address 2'));
					echo $this->Form->input('city', array('placeholder' => 'City*', 'div' => 'city'));							
					echo $this->Form->input('state_id', array('empty' => 'State...', 'div' => 'registration_select_container state' ));					
					echo $this->Form->input('zip', array('placeholder' => 'Zip*', 'div' => 'zip'));					
					echo $this->Form->input('phone', array('placeholder' => 'Phone'));					
					echo $this->Form->input('is_agreed', array('label' => false, 'after' => '<span class="caption">By signing up I agree to abide by the '. $this->Html->link('Terms of Service', array('controller' => 'pages', 'action' => 'terms')) .'</span>', 'div' => array('class' => 'is_agreed input checkbox')));
					echo $this->Form->input('role', array('type' => 'hidden', 'value' => '1'));										
				?>
			</div>
			<?php endif; ?>
			<?php 
				echo $this->Form->end(__(' ')); 
				echo $this->Html->image('ajax-loader.gif', array('class' => 'loader_to_modal'));
			?>
			<p id="trial_cc_no_bill_notice">Your credit card will not be billed for 14 days.  Cancel at any time. Read Terms of Service <?php echo $this->Html->link('HERE', array('controller' => 'pages', 'action' => 'terms'))?>. </p>
		</div> <!-- /filocity_registration_no_cc_form_wrapper -->
	</div>
	
	<script type="text/javascript">
		$(function() {
			$('span.cross_icon').on('click', function() {
				$('#filocity_registration_no_cc_form, #filocity_modal_dialog_outer').hide(10, function() {
					window.location.href = 'http://www.filocity.com/pricing/';
				});
			});
		});
	</script>
<?php } else { 
	echo $this->Html->script( array('jquery-ui-1.8.23.custom.min', 'registration', 'jquery.monthpicker') );
?>
	<div class="users form">
		<?php echo $this->element('package_detail_right_panel', array('package' => $my_package));?>
		<div id="registration_form_container">
			<div class="registration_form_wrapper">
				<?php echo $this->Form->create('User', array('inputDefaults' => array('readonly' => !$isValidPackage))); ?>
				<div class="reg_form_header">
					<h1 class="reg_form_heading">Signup - Create your Filocity Account</h1>
					<h1 class="reg_form_title">Personal Information</h1>
					<span class="reg_form_note"><strong>Bold</strong> fields with (*) are mandatory.</span>
				</div>
				<div class="reg_form_sections clearfix">
					<div class="reg_form_left_section form_section">
						<div class="personal_info_section">
							<h3 class="section_header">Personal Information</h3>
							<?php
								echo $this->Form->input('first_name', array('label' => 'First Name*'));
								echo $this->Form->input('last_name', array('label' => 'Last Name*'));
								echo $this->Form->input('email', array('label' => 'Email Address*', 'placeholder' => '(Login)', 'div' => array('class' => 'input error email_div')));						
							?>
						</div>
						<div class="personal_info_section_mailing">
							<h3 class="section_header">Personal Information</h3>
							<?php
								echo $this->Form->input('mail_address_1', array('label' => 'Mail Address 1*'));
								echo $this->Form->input('mail_address_2', array('label' => 'Mail Address 2'));
								echo $this->Form->input('city', array('label' => 'City*'));
								echo $this->Form->input('state_id', array('label' => 'State*', 'value' => '33'));
								echo $this->Form->input('zip', array('label' => 'Zip*'));
								echo $this->Form->input('country_id', array('label' => 'Country*', 'value' => '223'));
								//echo $this->Form->input('has_personal_address', array('label' => false, 'after' => '<span class="caption">My billing address is different from my <br>personal address.</span>', 'div' => array('class' => 'has_personal_address input checkbox')));
								echo $this->Form->input('is_corporate_account', array('label' => false, 'after' => '<p class="caption">Check if billing is under my business name.<br>(Corporate Account)</p>', 'div' => array('class' => 'is_corporate_account input checkbox')));
							?>
						</div>
					</div>
					<div class="reg_form_right_section form_section">
						<div class="login_info">
							<h3 class="section_header">Login Information</h3>
							<p class="note_to_login_info">Your email address will be your login name.</p>
							<?php
								echo $this->Form->input('password', array('label' => 'Password*'));
								echo $this->Form->input('confirm_password', array('type' => 'password', 'label' => 'Confirm Password*','value' => '', 'div' => array('class' => 'input password required confirm_pass')));
							?>
						</div>
						<div class="credit_card_info">
							<h3 class="section_header">Credit Card Information</h3>
							<div class="package_pricing" style="height:40px;color:#5A5A5A"><label>Your Total</label><strong>$<?php echo $my_package['Package']['price']; ?></strong><small>/mo</small></div>
							<?php	
								echo $this->Form->input('card_name', array('label' => 'Your Card*','options' => $card_names, 'value' => 'master'));
								echo $this->Form->input('card_number', array('type' => 'text', 'label' => 'Card Number*', 'maxlength' => '19'));
								echo $this->Form->input('card_expiration_date', array('label' => 'Expiration Date*', 'type' => 'date', 'dateFormat' => 'MY', 'default' => date('Y-m-d', strtotime('+1 months')), 'minYear' => date('Y'), 'maxYear' => date('Y', strtotime("+10 years")), 'orderYear' => 'asc', 'separator' => '/', 'monthNames' => $monthNames));
								echo $this->Form->input('security_code', array('type' => 'text', 'maxlength' => '4', 'label' => 'Security Code*', 'before' => $this->Html->image('signup_creditcart_code.png', array('width' => '60', 'height' => '37', 'class' => 'security_code_img')), 'div' => 'security_code_holder input text'));
								echo $this->Form->input('company_name', array('label' => 'Company Name*'));
								echo $this->Form->input('package_id', array('type' => 'hidden', 'value' => !empty($package_id) ? $package_id : ''));
								echo $this->Form->input('is_agreed', array('label' => false, 'after' => '<p class="caption">'. $this->Html->link('I have read the terms & condition and I agree. ', array('controller' => 'users', 'action' => 'terms')) .'</p>', 'div' => array('class' => 'is_agreed input checkbox')));
								echo $this->Form->input('role', array('type' => 'hidden', 'value' => '1'));
								echo $this->Form->end(__('Submit'));
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>