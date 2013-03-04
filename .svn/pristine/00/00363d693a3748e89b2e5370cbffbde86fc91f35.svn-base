<?php
/**
 * Demonstrates the Direct Post Method.
 *
 * To implement the Direct Post Method you need to implement 3 steps:
 *
 * Step 1: Add necessary hidden fields to your checkout form and make your form is set to post to AuthorizeNet.
 *
 * Step 2: Receive a response from AuthorizeNet, do your business logic, and return
 *         a relay response snippet with a url to redirect the customer to.
 *
 * Step 3: Show a receipt page to your customer.
 *
 * This class is more for demonstration purposes than actual production use.
 *
 *
 * @package    AuthorizeNet
 * @subpackage AuthorizeNetDPM
 */

/**
 * A class that demonstrates the DPM method.
 *
 * @package    AuthorizeNet
 * @subpackage AuthorizeNetDPM
 */
class AuthorizeNetDPM extends AuthorizeNetSIM_Form
{

    const LIVE_URL = 'https://secure.authorize.net/gateway/transact.dll';
    const SANDBOX_URL = 'https://test.authorize.net/gateway/transact.dll';

    /**
     * Implements all 3 steps of the Direct Post Method for demonstration
     * purposes.
     */
    public static function directPostDemo($url, $api_login_id, $transaction_key, $amount = "0.00", $md5_setting = "")
    {
        
        // Step 1: Show checkout form to customer.
        if (!count($_POST) && !count($_GET))
        {
            $fp_sequence = time(); // Any sequential number like an invoice number.
            echo AuthorizeNetDPM::getCreditCardForm($amount, $fp_sequence, $url, $api_login_id, $transaction_key);
        }
        // Step 2: Handle AuthorizeNet Transaction Result & return snippet.
        elseif (count($_POST)) 
        {
            $response = new AuthorizeNetSIM($api_login_id, $md5_setting);
            if ($response->isAuthorizeNet()) 
            {
                if ($response->approved) 
                {
                    // Do your processing here.
                    $redirect_url = $url . '?response_code=1&transaction_id=' . $response->transaction_id; 
                }
                else
                {
                    // Redirect to error page.
                    $redirect_url = $url . '?response_code='.$response->response_code . '&response_reason_text=' . $response->response_reason_text;
                }
                // Send the Javascript back to AuthorizeNet, which will redirect user back to your site.
                echo AuthorizeNetDPM::getRelayResponseSnippet($redirect_url);
            }
            else
            {
                echo "Error -- not AuthorizeNet. Check your MD5 Setting.";
            }
        }
        // Step 3: Show receipt page to customer.
        elseif (!count($_POST) && count($_GET))
        {
            if ($_GET['response_code'] == 1)
            {
                echo "Thank you for your purchase! Transaction id: " . htmlentities($_GET['transaction_id']);
            }
            else
            {
              echo "Sorry, an error occurred: " . htmlentities($_GET['response_reason_text']);
            }
        }
    }
    
    /**
     * A snippet to send to AuthorizeNet to redirect the user back to the
     * merchant's server. Use this on your relay response page.
     *
     * @param string $redirect_url Where to redirect the user.
     *
     * @return string
     */
    public static function getRelayResponseSnippet($redirect_url)
    {
        return "<html><head><script language=\"javascript\">
                <!--
                window.location=\"{$redirect_url}\";
                //-->
                </script>
                </head><body><noscript><meta http-equiv=\"refresh\" content=\"1;url={$redirect_url}\"></noscript></body></html>";
    }
    
    /**
     * Generate a sample form for use in a demo Direct Post implementation.
     *
     * @param string $amount                   Amount of the transaction.
     * @param string $fp_sequence              Sequential number(ie. Invoice #)
     * @param string $relay_response_url       The Relay Response URL
     * @param string $api_login_id             Your API Login ID
     * @param string $transaction_key          Your API Tran Key.
     * @param bool   $test_mode                Use the sandbox?
     * @param bool   $prefill                  Prefill sample values(for test purposes).
     *
     * @return string
     */
    public static function getCreditCardForm($amount, $fp_sequence, $relay_response_url, $api_login_id, $transaction_key, $test_mode = true, $prefill = true)
    {
        $time = time();
		$date = date('Y-m-d');
        $fp = self::getFingerprint($api_login_id, $transaction_key, $amount, $fp_sequence, $time);
        $sim = new AuthorizeNetSIM_Form(
            array(
            'x_amount'        => $amount,
            'x_fp_sequence'   => $fp_sequence,
            'x_fp_hash'       => $fp,
            'x_fp_timestamp'  => $time,
            'x_relay_response'=> "TRUE",
            'x_relay_url'     => $relay_response_url,
            'x_login'         => $api_login_id,
            )
        );
        $hidden_fields = $sim->getHiddenFieldString();
        $post_url = ($test_mode ? self::SANDBOX_URL : self::LIVE_URL);
        
        $form = '
        <style>
        fieldset {
            overflow: auto;
            border: 0;
            margin: 0;
            padding: 0; }
		.heading_secton{
			color:#fff;
			background:#9bb9db;
		}
		.heading_secton h3{
			padding:10px;
			font-size:15px;
			margin:0;
		}
		.main_purchase_form{
			margin:0 10px 10px 10px;
			border:1px solid #9bb9db;
			min-height:950px;
			background:#eff8ff;
		}
		.purchase_wrapper{
			padding:50px;
		}
		.naming_customer, .card_type{
			float:left;
			margin-left:10px;
			font-weight:bold;
			font-size:14px;
		}
		.naming_customer fieldset div, locate_customer fieldset div{
			clear:both;
		}
		.locate_customer, .card_security_code{
			display:inline-block;
			margin-left:50px;
			font-weight:bold;
			font-size:14px;
		}
		.card_detail_container{
			margin-top:50px;
		}
		.label_for_input{float:left; margin-right:20px; width:115px;}
		.input_value{display:inline-block;}
		.payment_header{
			font-size:20px;
			font-weight:bold;
			color:#8c8c8c;
			margin-bottom:20px;
		}
		.order_date{
			width:80px;
			border:1px solid #000;
			-moz-border-radius:4px;
			-webkit-border-radius:4px;
			border-radius:4px;
		}
		.visa_card{
			background:url(\'http://filocitydev.com/img/visa.png\') no-repeat;
			height:25px;
			width:50px;
			float:left;
			margin-right:10px;
		}
		.master_card{
			background:url(\'http://filocitydev.com/img/master.png\') no-repeat;
			height:25px;
			width:50px;
			display:inline-block;
			margin-right:5px;
		}
		.american_express{
			background:url(\'http://filocitydev.com/img/american.png\') no-repeat;
			height:25px;
			width:50px;
			display:inline-block;
			margin-right:10px;
		}
		.discover{
			background:url(\'http://filocitydev.com/img/discover.png\') no-repeat;
			height:25px;
			width:50px;
			display:inline-block;
		}
		.copyright{
			width:85px;
			margin:40px 0 0 20px;
		}
		.thawte{
			background:url(\'http://filocitydev.com/img/thawte.png\') no-repeat;
			height:50px;
			width:60px;
		}
		.card_sample{
			width:265px;
			margin:0 0 5px 133px;
		}
        fieldset div {
            clear: both; }

        fieldset.centered div {
            text-align: center; }

        label {
            color: #183b55;
            display: block;
            margin-bottom: 5px; }

        label img {
            display: block;
            margin-bottom: 5px; }

        input.text {
            border: 1px solid #bfbab4;
            margin: 0 4px 8px 0;
            padding: 6px;
            color: #1e1e1e;
			width:250px;
            -webkit-box-shadow: inset 0px 5px 5px #eee;
            -moz-box-shadow: inset 0px 5px 5px #eee;
            box-shadow: inset 0px 5px 5px #eee; }
        .submit {
            display: block;
            background-color: #83abcf;
            border: 1px solid #766056;
			font-weight:bold;
            color: #fff;
			float:right;
            margin-right:7px;
			margin-top:50px;
            padding: 8px 16px;
            font-size: 14px;
            -webkit-box-shadow: inset 3px -3px 3px rgba(0,0,0,.5), inset 0 3px 3px rgba(255,255,255,.5), inset -3px 0 3px rgba(255,255,255,.75);
            -moz-box-shadow: inset 3px -3px 3px rgba(0,0,0,.5), inset 0 3px 3px rgba(255,255,255,.5), inset -3px 0 3px rgba(255,255,255,.75);
            box-shadow: inset 3px -3px 3px rgba(0,0,0,.5), inset 0 3px 3px rgba(255,255,255,.5), inset -3px 0 3px rgba(255,255,255,.75); }
        </style>
		
			<form method="post" action="'.$post_url.'">
					'.$hidden_fields.'
				<div class="main_purchase_form">	
					<div class="heading_secton"><h3>Required field are marked with <span style="color:#f00">*</span></h3></div>	
					<div class="purchase_wrapper">
					<div class="addressing_part">
						<div class="naming_customer">
							<fieldset>
								<div>
									<div class="label_for_input">First Name: <span style="color:#f00">*</span></div>
									<div class="input_value"><input type="text" class="text" size="15" name="x_first_name" value="'.($prefill ? 'John' : '').'"></input></div>
								</div>
								<div>
									<div class="label_for_input">Last Name: <span style="color:#f00">*</span></div>
									<div class="input_value"><input type="text" class="text" size="14" name="x_last_name" value="'.($prefill ? 'Doe' : '').'"></input></div>
								</div>
								<div>
									<div class="label_for_input">Email: <span style="color:#f00">*</span></div>
									<div class="input_value"><input type="text" class="text" size="26" name="x_email" value="'.($prefill ? 'sandip.abcoder@gmail.com' : '').'"></input></div>
								</div>
								<div>
									<div class="label_for_input">Address: <span style="color:#f00">*</span></div>
									<div class="input_value"><input type="text" class="text" size="26" name="x_address" value="'.($prefill ? '123 Main Street' : '').'"></input></div>
								</div>
							</fieldset>	
						</div>
						<div class="locate_customer">
							<fieldset>
								<div>
									<div class="label_for_input">City: <span style="color:#f00">*</span></div>
									<div class="input_value"><input type="text" class="text" size="15" name="x_city" value="'.($prefill ? 'Boston' : '').'"></input></div>
								</div>
								<div>
									<div class="label_for_input">State: <span style="color:#f00">*</span></div>
									<div class="input_value"><input type="text" class="text" size="4" name="x_state" value="'.($prefill ? 'MA' : '').'"></input></div>
								</div>
								<div>
									<div class="label_for_input">Zip Code: <span style="color:#f00">*</span></div>
									<div class="input_value"><input type="text" class="text" size="9" name="x_zip" value="'.($prefill ? '02142' : '').'"></input></div>
								</div>
								<div>
									<div class="label_for_input">Country: <span style="color:#f00">*</span></div>
									<div class="input_value"><input type="text" class="text" size="22" name="x_country" value="'.($prefill ? 'US' : '').'"></input></div>
								</div>
							</fieldset>
						</div>
					</div>
					<div class="card_detail_container">
						<div class="payment_header">Payment Information</div>
						<div class="card_type">
							<fieldset>
								<div>
									<div class="label_for_input">Credit Type: <span style="color:#f00">*</span></div>
									<div class="input_value"><input type="text" class="text" size="15" name="x_card_type" value="'.($prefill ? '6011000000000012' : '').'"></input></div>
								</div>
								<div class="card_sample">
									<div class="visa_card"></div>
									<div class="master_card"></div>
									<div class="american_express"></div>
									<div class="discover"></div>
								</div>
								<div>
									<div class="label_for_input">Credit Card Number: <span style="color:#f00">*</span></div>
									<div class="input_value"><input type="text" class="text" size="15" name="x_card_num" value="'.($prefill ? '6011000000000012' : '').'"></input></div>
								</div>
							</fieldset>
						</div>	
						<div class="card_security_code">
							<fieldset>
								<div>
									<div class="label_for_input">Exp: <span style="color:#f00">*</span></div>
									<div class="input_value"><input type="text" class="text" size="4" name="x_exp_date" value="'.($prefill ? '04/17' : '').'"></input></div>
								</div>
								<div>
									<div class="label_for_input">Security Code: <span style="color:#f00">*</span><a href="#">?</a></div>
									<div class="input_value"><input type="text" class="text" size="4" name="x_card_code" value="'.($prefill ? '782' : '').'"></input></div>
								</div>
							</fieldset>
						</div>	
					</div>
					<input type="submit" value="Order Now" class="submit buy">
					<div class="copyright">
					<div class="thawte"></div>
					<div class="order_date">'.$date.'</div>
					</div>
				</div>	
			</div>	
			</form>';
        return $form;
    }

}