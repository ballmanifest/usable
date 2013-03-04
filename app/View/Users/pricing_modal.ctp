<?php
	echo $this->Html->css(array('pricing_modal'));
	App::uses('CakeTime', 'Utility');
?>
<div id="pricingInfoModal" class="pricingInfoModal pricing_modal_container me_relative">
	<div id="pricing_modal_wrapper">
		<h3 class="pricing_header">Pricing Information</h3>
		<!-- IF no information found this panel will display -->
		<div class="no_records_found me_hide">
			No record found
		</div><!-- .no_records_found -->
		<!-- ELSE this panel will display -->
		<div class="customer_billing_info">
			<div class="payment_info">
				<p>Next Payment of <strong>$<?php echo $payment['PaymentLog']['next_payment_amount']; ?></strong> due on  <strong><?php echo CakeTime::format('F d, Y', $payment['PaymentLog']['next_payment_date']);?></strong></p>
				<p><?php ucfirst($user['User']['card_name']); ?> xxxx-xxxx-xxxx-1234 Exp <?php echo $user['User']['card_expiration_date'];?></p>
			</div>
			<div class="payment_tools"><a href="">Update/Change Payment Type</a>&nbsp; | &nbsp;<a href="" class="make_payment_link">Make Payment</a></div>
		</div><!-- .customer_billing_info -->
		<!-- Customer Support & Close account -->
		<div class="customer_support">
			<p>Customer Support: 900.790.9095</p>
			<p><a href="javascript::void(0)" id="closeUserAccount">Close this account</a></p>
		</div>
	</div><!-- #pricing_modal_wrapper -->
	<div id="confirm_window_container" class="me_hide">
		<div class="confirm_window me_absolute shadow">
			<h5>Confirm<span class="icon-remove close-confirm-window"></span></h5>
			<div style="height: 20px;">Please confirm payment of $<?php echo $payment['PaymentLog']['next_payment_amount']; ?></div>
			<div>
				<a class="btn btn-danger cancel_payment_btn" href="#">Cancel</a>
				<a class="btn btn-success" id="do_my_payment" href="#">OK</a>
			</div>
		</div>
	</div>
</div><!-- #pricingInfo.pricing_modal_container -->
<div id="modal_overlay" class="me_absolute me_hide"></div>
