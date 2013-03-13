<?php
echo $this->Html->css(array('jquery.mCustomScrollbar.css', 'contacts', 'fancybox/jquery.fancybox'));
echo $this->Html->script(array('jquery-ui-1.8.23.custom.min', 'jquery.mousewheel.min.js', 'jquery.mCustomScrollbar.js', 'plupload.full.js', 'jquery.jstree.js', 'fancybox/jquery.fancybox', 'contacts'), array('inline' => false));
?>
<div id="contact_actions_container">
	<a href="#" id="add_contact_link">Add Contact</a>
	<a href="#" id="add_group_link">Add Group</a>
	<a href="#" id="import_contacts_link">Import Contacts</a>
	<div style="float:right;">
		<label for="contacts-filter" id="contacts-filter-label">FILTER:</label> <input id="contacts-filter" />
		<div style="clear:both;"></div>
	</div>
	<div class="clear"></div>
</div>


<div id="contact_left_container">
	<div id="contact_filter_links_container" class="left-container first">
		<ul class="contact-group">
			<li><a href="#" id="account_users_group_link" data-contactgroup="account-users" class="contact_group_type">Account Users</a></li>
			<li><a href="#" id="all_contacts_group_link" data-contactgroup="all-contacts" class="current-contact-group contact_group_type">All Contacts</a></li>
			<li><a href="#" id="shared_contacts_group_link" data-contactgroup="shared-contacts" class="contact_group_type">Shared Contacts</a></li>
			<li><a href="#" id="private_contacts_group_link" data-contactgroup="private-contacts" class="contact_group_type">My Private Contacts</a></li>
		</ul>
	</div>
	<div id="contact_group_links_container" class="left-container">
		<div class="left-container-title"><div id="name_of_groups">Groups</div><a href="#" id="new_user_group">+New</a>
		<div class="contacts-list-actions selected_contacts_action">
			<span class="label">Select groups below and contacts on the right and click</span>
			</br>
			<div >
				<ul id="groups_edit_links">
					<li class="selected-share for-private"><a href="#">Share to other users</a></li>
					<li class="selected-add-to-group for-shared for-private for-all for-group for-users"><a href="#">Add to group</a></li>
					<li class="selected-remove-from-group for-group"><a href="#">Remove from group</a></li>
					<li class="selected-delete for-private"><a href="#">Delete</a></li>
				</ul>
			</div>
		</div>
		
		</div>
		<ul class="contact-group" id="custom-contact-group-list"></ul>
	</div>
</div>


<div id="contact_list_container">
	
	Select:
	<a href="#" onclick="return select_all_contacts();">All</a>
	<a href="#" onclick="return deselect_all_contacts();">None</a>
	Sort by:
	<a href="#" id="sort_first_name_link">First Name</a>
	<a href="#" id="sort_last_name_link">Last Name</a>
	<div class="group-panel" style="visibility:hidden;padding-top:10px;">
		<div id="contact_list">
			<div class="scroller"><ul class="list-style-1"></ul><div id="contact_links" style="display:none;"><a href="#" id="contact_info_link">Info</a></div></div>
		</div>
		
	</div>
</div>


<div id="contact_group_info_container">
	<div class="group-panel" style="visibility:hidden;">
		<div id="group_info_container" style="display:none;">
			<div class="left-container-title"><span id="contact_group_name">...</span> (<span id="contact_group_count">0</span>)</div>
			<div id="group_actions" class="right clear">
				<a href="#" id="create_group_folder_link" class="button-link">Create Group Folder</a>
				<a href="#" id="edit_group_link" class="button-link">Edit Group</a>
				<a href="#" id="delete_group_link" class="button-link" style="margin-right:0;">Delete Group</a>
			</div>
			<div id="contact_group_description"></div>
		</div>
		<div id="contact_info_container" style="display:none;">
			<div class="left-container-title">Contact Info</div>
			<form>
				<div style="padding-bottom:10px;">
					<a href="#" class="edit-contact-link button-link">Edit Contact</a>
					<a href="#" class="delete-contact-link button-link" style="margin:0;">Delete Contact</a>
					&nbsp;
					<div style="float:right;">
						<a href="#" class="contact-folder-link button-link" style="margin:0 0 0 5px;">Create a Folder</a>
						<a href="#" class="email-link button-link" style="margin:0 0 0 5px;">Email</a>
						<a href="#" class="groups-link button-link" style="margin:0 0 0 5px;">Groups</a>
					</div>
					<div style="clear:both;"></div>
				</div>
				<div style="float:left;width:315px;">
					<div class="row first_name">
						<div class="label">First Name:</div>
						<div class="info first_name"></div>
					</div>
					
					<div class="row last_name">
						<div class="label">Last Name:</div>
						<div class="info"></div>
					</div>
					
					<div class="row email">
						<div class="label">Email:</div>
						<div class="info"></div>
					</div>
					
					<div class="row company_name">
						<div class="label">Company:</div>
						<div class="info"></div>
					</div>
					
					<div class="row job_title">
						<div class="label">Title:</div>
						<div class="info"></div>
					</div>
					
					<div class="row title">
						<div class="label">Title:</div>
						<div class="info"></div>
					</div>
					
					<div class="row job_position">
						<div class="label">Position:</div>
						<div class="info"></div>
					</div>
					
					<div class="row position">
						<div class="label">Position:</div>
						<div class="info"></div>
					</div>
					
					<div class="row department">
						<div class="label">Department:</div>
						<div class="info"></div>
					</div>
					
					<div class="row street_1">
						<div class="label">Street:</div>
						<div class="info"></div>
					</div>
					
					<div class="row street_2">
						<div class="label">Street 2:</div>
						<div class="info"></div>
					</div>
					
					<div class="row city">
						<div class="label">City:</div>
						<div class="info"></div>
					</div>
					
					<div class="row state">
						<div class="label">State:</div>
						<div class="info"></div>
					</div>
					
					<div class="row zip">
						<div class="label">Zip:</div>
						<div class="info"></div>
					</div>
					
					<div class="row country">
						<div class="label">Country:</div>
						<div class="info"></div>
					</div>
					
					<div class="row work_phone">
						<div class="label">Work Phone:</div>
						<div class="info"></div>
					</div>
					
					<div class="row mobile_phone">
						<div class="label">Mobile Phone:</div>
						<div class="info"></div>
					</div>
					
					<div class="row home_phone">
						<div class="label">Home Phone:</div>
						<div class="info"></div>
					</div>
					
					<div class="row toll_free_phone">
						<div class="label">Toll-free Phone:</div>
						<div class="info"></div>
					</div>
					
					<div class="row work_fax">
						<div class="label">Work Fax:</div>
						<div class="info"></div>
					</div>
					
					<div class="row mail_address_1">
						<div class="label">Mail Address:</div>
						<div class="info"></div>
					</div>
					
					<div class="row main_address_2">
						<div class="label">Mail Address 2:</div>
						<div class="info"></div>
					</div>
					
					<div class="row website">
						<div class="label">Website:</div>
						<div class="info"></div>
					</div>
					
				</div>
				<div style="float:left;width:100px;height:100px;background:gray;padding-left:10px;" class="photo"></div>
				<div style="clear:both;">
					<a href="#" class="shares-link">Shares</a>
				</div>
			</form>
		</div>
	</div>
</div>


<div id="contact_dialog" style="display:none;">
	<form>
	<p style="padding-left:0;">
		<label class="required" for="firstname">First Name</label>
		<input type="text" class="inputText" value="" id="firstname" name="data[Contact][first_name]" />

		<label class="required" for="lastname">Last Name</label>
		<input type="text" class="inputText" value="" id="lastname" name="data[Contact][last_name]" />  

		<label class="optional" for="company">Company Name</label>
		<input type="text" class="inputText" value="" id="company" name="data[Contact][company_name]" />  

		<label class="optional" for="jobtitle">Job Title</label>
		<input type="text" class="inputText" value="" id="jobtitle" name="data[Contact][job_title]" />

		<label class="required" for="email">Email</label>
		<input type="text" class="inputText" value="" id="email" name="data[Contact][email]" />

		<label class="optional" for="type">Contact Type</label>
		<select id="type" name="data[Contact][contact_type]">
		<option label="Private" value="0">Private</option>
		<option label="Public" value="1">Public</option>
		</select>                

		<label class="optional" title="Use this space if the contact has an Account number or other Unique identifier." for="company_id">Contact Id</label>
		<input type="text" class="inputText" value="" id="company_id" name="data[Contact][user_id2]" />
	</p>
	
	<p>
		<label class="optional" for="street1">Street 1</label>
		<input type="text" class="inputText" value="" id="street1" name="data[Contact][street_1]" />

		<label class="optional" for="street2">Street 2</label>
		<input type="text" class="inputText" value="" id="street2" name="data[Contact][street_2]" />

		<label class="optional" for="city">City</label>	
		<input type="text" class="inputText" value="" id="city" name="data[Contact][city]" />

		<label class="optional" for="state">State</label>
		<select id="state" name="data[Contact][state_id]">
			<option value="0">Other</option><option value="1">Alabama</option><option value="2">Alaska</option><option value="3">Arizona</option><option value="4">Arkansas</option><option value="5">California</option><option value="6">Colorado</option><option value="7">Connecticut</option><option value="8">Delaware</option><option value="9">District of Columbia</option><option value="10">Florida</option><option value="11">Georgia</option><option value="12">Hawaii</option><option value="13">Idaho</option><option value="14">Illinois</option><option value="15">Indiana</option><option value="16">Iowa</option><option value="17">Kansas</option><option value="18">Kentucky</option><option value="19">Louisiana</option><option value="20">Maine</option><option value="21">Maryland</option><option value="22">Massachusetts</option><option value="23">Michigan</option><option value="24">Minnesota</option><option value="25">Mississippi</option><option value="26">Missouri</option><option value="27">Montana</option><option value="28">Nebraska</option><option value="29">Nevada</option><option value="30">New Hampshire</option><option value="31">New Jersey</option><option value="32">New Mexico</option><option value="33">New York</option><option value="34">North Carolina</option><option value="35">North Dakota</option><option value="36">Ohio</option><option value="37">Oklahoma</option><option value="38">Oregon</option><option value="39">Pennsylvania</option><option value="40">Rhode Island</option><option value="41">South Carolina</option><option value="42">South Dakota</option><option value="43">Tennessee</option><option value="44">Texas</option><option value="45">Utah</option><option value="46">Vermont</option><option value="47">Virginia</option><option value="48">Washington</option><option value="49">West Virginia</option><option value="50">Wisconsin</option><option value="51">Wyoming</option>
		</select>

		<label class="optional" for="zip">Zip</label>
		<input type="text" class="inputText" value="" id="zip" name="data[Contact][zip]" />

		<label class="optional" for="country">Country</label>
		<select id="country" name="data[Contact][country_id]">
			<option value="223" selected="selected">United States</option><option value="36">Canada</option><option value="3">Afghanistan</option><option value="6">Albania</option><option value="60">Algeria</option><option value="12">American Samoa</option><option value="1">Andorra</option><option value="9">Angola</option><option value="5">Anguilla</option><option value="10">Antarctica</option><option value="4">Antigua and Barbuda</option><option value="11">Argentina</option><option value="7">Armenia</option><option value="15">Aruba</option><option value="14">Australia</option><option value="13">Austria</option><option value="16">Azerbaijan</option><option value="30">Bahamas</option><option value="23">Bahrain</option><option value="19">Bangladesh</option><option value="18">Barbados</option><option value="34">Belarus</option><option value="20">Belgium</option><option value="35">Belize</option><option value="25">Benin</option><option value="26">Bermuda</option><option value="31">Bhutan</option><option value="28">Bolivia</option><option value="17">Bosnia and Herzegovina</option><option value="33">Botswana</option><option value="32">Bouvet Island</option><option value="29">Brazil</option><option value="102">British Indian Ocean Territory</option><option value="27">Brunei Darussalam</option><option value="22">Bulgaria</option><option value="21">Burkina Faso</option><option value="24">Burundi</option><option value="112">Cambodia</option><option value="45">Cameroon</option><option value="51">Cape Verde</option><option value="119">Cayman Islands</option><option value="39">Central African Republic</option><option value="205">Chad</option><option value="44">Chile</option><option value="46">China</option><option value="52">Christmas Island</option><option value="37">Cocos (Keeling) Islands</option><option value="47">Colombia</option><option value="114">Comoros</option><option value="40">Congo</option><option value="38">Congo, the Democratic Republic of the</option><option value="43">Cook Islands</option><option value="48">Costa Rica</option><option value="42">Cote D'Ivoire</option><option value="95">Croatia</option><option value="50">Cuba</option><option value="53">Cyprus</option><option value="54">Czech Republic</option><option value="57">Denmark</option><option value="56">Djibouti</option><option value="58">Dominica</option><option value="59">Dominican Republic</option><option value="61">Ecuador</option><option value="63">Egypt</option><option value="201">El Salvador</option><option value="85">Equatorial Guinea</option><option value="65">Eritrea</option><option value="62">Estonia</option><option value="67">Ethiopia</option><option value="70">Falkland Islands (Malvinas)</option><option value="72">Faroe Islands</option><option value="69">Fiji</option><option value="68">Finland</option><option value="73">France</option><option value="78">French Guiana</option><option value="168">French Polynesia</option><option value="206">French Southern Territories</option><option value="74">Gabon</option><option value="82">Gambia</option><option value="77">Georgia</option><option value="55">Germany</option><option value="79">Ghana</option><option value="80">Gibraltar</option><option value="86">Greece</option><option value="81">Greenland</option><option value="76">Grenada</option><option value="84">Guadeloupe</option><option value="89">Guam</option><option value="88">Guatemala</option><option value="83">Guinea</option><option value="90">Guinea-Bissau</option><option value="91">Guyana</option><option value="96">Haiti</option><option value="93">Heard Island and Mcdonald Islands</option><option value="226">Holy See (Vatican City State)</option><option value="94">Honduras</option><option value="92">Hong Kong</option><option value="97">Hungary</option><option value="105">Iceland</option><option value="101">India</option><option value="98">Indonesia</option><option value="104">Iran, Islamic Republic of</option><option value="103">Iraq</option><option value="99">Ireland</option><option value="100">Israel</option><option value="106">Italy</option><option value="107">Jamaica</option><option value="109">Japan</option><option value="108">Jordan</option><option value="120">Kazakhstan</option><option value="110">Kenya</option><option value="113">Kiribati</option><option value="116">Korea, Democratic People's Republic of</option><option value="117">Korea, Republic of</option><option value="118">Kuwait</option><option value="111">Kyrgyzstan</option><option value="121">Lao People's Democratic Republic</option><option value="130">Latvia</option><option value="122">Lebanon</option><option value="127">Lesotho</option><option value="126">Liberia</option><option value="131">Libyan Arab Jamahiriya</option><option value="124">Liechtenstein</option><option value="128">Lithuania</option><option value="129">Luxembourg</option><option value="141">Macao</option><option value="137">Macedonia, the Former Yugoslav Republic of</option><option value="135">Madagascar</option><option value="149">Malawi</option><option value="151">Malaysia</option><option value="148">Maldives</option><option value="138">Mali</option><option value="146">Malta</option><option value="136">Marshall Islands</option><option value="143">Martinique</option><option value="144">Mauritania</option><option value="147">Mauritius</option><option value="236">Mayotte</option><option value="150">Mexico</option><option value="71">Micronesia, Federated States of</option><option value="134">Moldova, Republic of</option><option value="133">Monaco</option><option value="140">Mongolia</option><option value="145">Montserrat</option><option value="132">Morocco</option><option value="152">Mozambique</option><option value="139">Myanmar</option><option value="153">Namibia</option><option value="162">Nauru</option><option value="161">Nepal</option><option value="159">Netherlands</option><option value="8">Netherlands Antilles</option><option value="154">New Caledonia</option><option value="164">New Zealand</option><option value="158">Nicaragua</option><option value="155">Niger</option><option value="157">Nigeria</option><option value="163">Niue</option><option value="156">Norfolk Island</option><option value="142">Northern Mariana Islands</option><option value="160">Norway</option><option value="165">Oman</option><option value="171">Pakistan</option><option value="178">Palau</option><option value="176">Palestinian Territory, Occupied</option><option value="166">Panama</option><option value="169">Papua New Guinea</option><option value="179">Paraguay</option><option value="167">Peru</option><option value="170">Philippines</option><option value="174">Pitcairn</option><option value="172">Poland</option><option value="177">Portugal</option><option value="175">Puerto Rico</option><option value="180">Qatar</option><option value="181">Reunion</option><option value="182">Romania</option><option value="183">Russian Federation</option><option value="184">Rwanda</option><option value="191">Saint Helena</option><option value="115">Saint Kitts and Nevis</option><option value="123">Saint Lucia</option><option value="173">Saint Pierre and Miquelon</option><option value="227">Saint Vincent and the Grenadines</option><option value="234">Samoa</option><option value="196">San Marino</option><option value="200">Sao Tome and Principe</option><option value="185">Saudi Arabia</option><option value="197">Senegal</option><option value="49">Serbia and Montenegro</option><option value="187">Seychelles</option><option value="195">Sierra Leone</option><option value="190">Singapore</option><option value="194">Slovakia</option><option value="192">Slovenia</option><option value="186">Solomon Islands</option><option value="198">Somalia</option><option value="237">South Africa</option><option value="87">South Georgia and the South Sandwich Islands</option><option value="66">Spain</option><option value="125">Sri Lanka</option><option value="188">Sudan</option><option value="199">Suriname</option><option value="193">Svalbard and Jan Mayen</option><option value="203">Swaziland</option><option value="189">Sweden</option><option value="41">Switzerland</option><option value="202">Syrian Arab Republic</option><option value="218">Taiwan, Province of China</option><option value="209">Tajikistan</option><option value="219">Tanzania, United Republic of</option><option value="208">Thailand</option><option value="211">Timor-Leste</option><option value="207">Togo</option><option value="210">Tokelau</option><option value="214">Tonga</option><option value="216">Trinidad and Tobago</option><option value="213">Tunisia</option><option value="215">Turkey</option><option value="212">Turkmenistan</option><option value="204">Turks and Caicos Islands</option><option value="217">Tuvalu</option><option value="221">Uganda</option><option value="220">Ukraine</option><option value="2">United Arab Emirates</option><option value="75">United Kingdom</option><option value="222">United States Minor Outlying Islands</option><option value="224">Uruguay</option><option value="225">Uzbekistan</option><option value="232">Vanuatu</option><option value="228">Venezuela</option><option value="231">Viet Nam</option><option value="229">Virgin Islands, British</option><option value="230">Virgin Islands, U.s.</option><option value="233">Wallis and Futuna</option><option value="64">Western Sahara</option><option value="235">Yemen</option><option value="238">Zambia</option><option value="239">Zimbabwe</option>
		</select>
		
		<label for="photo" class="optional">Photo</label>
		<input type="file" class="inputText" name="data[Contact][photo]" />
	</p>
	
	<p>
		<label class="optional" for="workphone">Work Phone</label>
		<input type="text" class="inputText" value="" id="workphone" name="data[Contact][work_phone]" />

		<label class="optional" for="mobilephone">Mobile Phone</label>
		<input type="text" class="inputText" value="" id="mobilephone" name="data[Contact][mobile_phone]" />

		<label class="optional" for="homephone">Home Phone</label>
		<input type="text" class="inputText" value="" id="homephone" name="data[Contact][home_phone]" />

		<label class="optional" for="tollfreephone">Toll Free Phone</label>
		<input type="text" class="inputText" value="" id="tollfreephone" name="data[Contact][toll_free_phone]" />

		<label class="optional" for="workfax">Work Fax</label>
		<input type="text" class="inputText" value="" id="workfax" name="data[Contact][work_fax]" />

		<label class="optional" for="url">Website</label>
		<input type="text" class="inputText" value="" id="url" name="data[Contact][website]" />
	</p>
	
	<div style="clear:both;"></div>
	<div style="float:right;clear:both;">
		<input type="button" class="save-button filocity-modal-button" style="margin-right:5px;" value="Save" />
		<input type="button" class="cancel-button filocity-modal-button pink" style="width:auto;" value="Cancel" />
	</div>
	
	</form>
	
</div>


<div id="group_dialog" title="Add Group" style="display:none;">
	<form>
		<p>
			<label class="label">Name:</label> <input class="input" name="data[Group][name]" />
		</p>
		<p>
			<label class="label" for="purpose_text_area">Purpose:</label>
			<textarea id="purpose_text_area" class="input" name="data[Group][purpose]"></textarea><br />
		</p>
		<label class="if-account-users" style="text-align: center;"><input type="checkbox" name="data[Group][is_for_account_users]" value="true" /> <span style="vertical-align: top; float: none; line-height: 17px; height: 17px;">Members of this group are Account Users</span></label><br />
		<?php /*
		<label><input type="checkbox" name="data[Group][has_smart_filing_category]" value="1" /> Create a Smart Filing Category for this Group</label><br />
		*/?>
		<div style="float:right;clear:both;">
			<input type="button" class="save-button filocity-modal-button" value="Save" />
			<input type="button" class="cancel-button filocity-modal-button pink" value="Cancel" />
		</div>
	</form>
</div>


<div id="import_contacts_dialog" title="Import Contacts" style="display:none;">
	<form>
	<div style="height:30px;">
		<label for="provider_box">Email provider:</label>
		<select class="provider_box" name="provider_box" style="float:right;">
			<option value=""></option>
			<option value="outlook_csv">CSV</option>
			<option value="aol">AOL</option>
			<option value="gmail">GMail</option>
			<option value="hotmail">Live/Hotmail</option>
			<option value="yahoo">Yahoo!</option>
		</select>
	</div>
	<div class="from-mail-server">
		<label for="email_box">Email Address:</label>
		<input type="text" value="" name="email_box" class="email_box" style="float:right;width:196px;" />
	</div>
	<div class="from-mail-server">
		<label for="password_box">Password:</label>
		<input type="password" value="" name="password_box" class="password_box" style="float:right;width:196px;" />
	</div>
	<div class="from-file">
		<label for="file" style="width:70px;">CSV File:</label>
		<div style="float:right;" class="import_csv_button_container" style="width:230px;">
			<input style="float:right;" type="button" value="Browse" class="filocity-modal-button import_csv_button" style="position: relative; z-index: 0;" />
			<div class="import_contact_file_name" style="float:right;">No File Selected</div>
		</div>
	</div>
	<div style="clear:both;float:right;">
		<input type="button" value="Submit" class="save-button filocity-modal-button" style="margin-right:5px;" />
		<input type="button" value="Cancel" class="cancel-button filocity-modal-button pink" />
	</div>
	</form>
</div>

<div id="add_to_a_group_dialog" class="add_to_a_group_dialog" title="Add to a Group" style="display:none;">
	<form>
	<label>Group Name:</label>
	<select name="data[Group][id]" style="float:right;"></select>
	<div style="clear:both;float:right;">
		<input type="button" value="Submit" class="save-button filocity-modal-button" style="margin-right:5px;" />
		<input type="button" value="Cancel" class="cancel-button filocity-modal-button pink" />
	</div>
	</form>
</div>
<div id="contact_info_dialog" title="Contact Info" class="contact_info_dialog" style="display:none;">
	<form>
		<div class="left">
			<div class="photo"></div>
			<!--
			<div class="link facebook">facebook</div>
			<div class="link linkedin">linkedIn</div>-->
		</div>
		<div class="left" style="padding-left:10px;padding-bottom:10px;width:499px;">
			<a href="#" class="edit-contact-link">Edit Contact</a>
			<a href="#" class="delete-contact-link">Delete Contact</a>
			<div style="float:right;">
				<a href="#" class="contact-folder-link">Create a Folder</a>
				<a href="#" class="email-link">Email</a>
				<a href="#" class="groups-link">Groups</a>
				<a href="#" class="shares-link">Shares</a>
			</div>
		</div>
		<div class="left" style="padding-left:10px;">
			
			<div class="row first_name">
				<div class="label">First Name:</div>
				<div class="info first_name"></div>
			</div>
			
			<div class="row last_name">
				<div class="label">Last Name:</div>
				<div class="info"></div>
			</div>
			
			<div class="row email">
				<div class="label">Email:</div>
				<div class="info"></div>
			</div>
			
			<div class="row company_name">
				<div class="label">Company:</div>
				<div class="info"></div>
			</div>
			
			<div class="row job_title">
				<div class="label">Title:</div>
				<div class="info"></div>
			</div>
			
			<div class="row title">
				<div class="label">Title:</div>
				<div class="info"></div>
			</div>
			
			<div class="row job_position">
				<div class="label">Position:</div>
				<div class="info"></div>
			</div>
			
			<div class="row position">
				<div class="label">Position:</div>
				<div class="info"></div>
			</div>
			
			<div class="row department">
				<div class="label">Department:</div>
				<div class="info"></div>
			</div>
			
			<div class="row street_1">
				<div class="label">Street:</div>
				<div class="info"></div>
			</div>
			
			<div class="row street_2">
				<div class="label">Street 2:</div>
				<div class="info"></div>
			</div>
			
			<div class="row city">
				<div class="label">City:</div>
				<div class="info"></div>
			</div>
			
			<div class="row state">
				<div class="label">State:</div>
				<div class="info"></div>
			</div>
			
			<div class="row zip">
				<div class="label">Zip:</div>
				<div class="info"></div>
			</div>
			
			<div class="row country">
				<div class="label">Country:</div>
				<div class="info"></div>
			</div>
			
			<div class="row work_phone">
				<div class="label">Work Phone:</div>
				<div class="info"></div>
			</div>
			
			<div class="row mobile_phone">
				<div class="label">Mobile Phone:</div>
				<div class="info"></div>
			</div>
			
			<div class="row home_phone">
				<div class="label">Home Phone:</div>
				<div class="info"></div>
			</div>
			
			<div class="row toll_free_phone">
				<div class="label">Toll-free Phone:</div>
				<div class="info"></div>
			</div>
			
			<div class="row work_fax">
				<div class="label">Work Fax:</div>
				<div class="info"></div>
			</div>
			
			<div class="row mail_address_1">
				<div class="label">Mail Address:</div>
				<div class="info"></div>
			</div>
			
			<div class="row main_address_2">
				<div class="label">Mail Address 2:</div>
				<div class="info"></div>
			</div>
			
			<div class="row website">
				<div class="label">Website:</div>
				<div class="info"></div>
			</div>
			
		</div>
		
	</form>
</div>

<div id="select_folder_dialog" style="display:none;">
	<div class="folder_browser" style="min-height:300px;background:#ffffff;"></div>
	<div style="clear:both;height:5px;">&nbsp;</div>
	<div style="float:right;">
		<input type="button" class="select-button filocity-modal-button" value="Select" style="margin:0;margin-right:5px;" />
		<input type="button" class="cancel-button filocity-modal-button pink" value="Cancel" style="margin:0;" />
	</div>
</div>

<div id="contact_groups_dialog" style="display:none;">
	<div class="list" style="background:#ffffff;">
		<ul class="list-style-1"></ul>
	</div>
</div>

<div id="contact_shares_dialog" style="display:none;">
	<div class="list" style="background:#ffffff;">
		<ul>
			<li>Share 1</li>
			<li>Share 2</li>
		</ul>
	</div>
</div>

<!-- Alert Box -->
<div class="me_hide">
	<div id="fancyAlertBox" class="fancyAlertBox">
		<h5>Message</h5>
		<div class="alert_message"></div>
	</div>
</div>