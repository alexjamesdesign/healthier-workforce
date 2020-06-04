<?php

// *********** CONFIG OPTIONS ***********

//****Set session variables for posting config to the mailer****//
$_SESSION['companyName'] 	 = get_field('company_name', 'option');
$_SESSION['emailTo'] 		 = get_field('company_email_address', 'option');
$_SESSION['successMsg'] 	 = get_field('success_message', 'option');

//Do you need Data Capture?
$dataCapture = false;

// *********** END OF CONFIG ***********

?>

<form class="callback-form" name="Callback_Form" method="post" action="#" enctype="multipart/form-data">

	<label for="Callback_Name">
		<input type="text" name="Callback_Name" class="name validate focus" id="Callback_Name" data-validate="letters" placeholder="Name *" />
		<span class="message" data-default="This field is required." data-issue="Something doesn't look right." data-success="Great!"></span>
	</label>

	<label for="Callback_Telephone">
		<input type="tel" name="Callback_Telephone" class="phone validate focus" id="Callback_Telephone" data-validate="phone" placeholder="Telephone *" />
		<span class="message" data-default="This field is required." data-issue="That doesn't look like a valid number." data-success="Nice one."></span>
	</label>

	<label for="Callback_Email">
		<input type="email" name="Callback_Email" class="email validate focus" id="Callback_Email" data-validate="email" placeholder="Email *" />
		<span class="message" data-default="This field is required." data-issue="Incorrect email address." data-success="Looks good!"></span>
	</label>

<!-- 	<label for="Callback_Time">Callback Time
		<select name="Callback_Time">
			<option value="Morning">Morning</option>
			<option value="Afternoon">Afternoon</option>
			<option value="Evening">Evening</option>
		</select>
	</label> -->

<?php
//data capture
if($dataCapture == true) : ?>
	<h2 class="clearfix">Subscribe for our special offers?</h2>
	<label class="data-capture">
		<label><input class="radio" type="radio" value="No_Thanks" name="subscription" />No Thanks!</label>

		<label><input class="radio" type="radio" value="Email_Updates" name="subscription" />Subscribe to Special Offers</label>
	</label>
<?php endif; ?>

<input name="submit_callback_form" class="submit" type="submit" value="Contact Us" <?php /* Check if Kenshoo is enabled */ if (get_field('kenshoo','options' )): ?>onclick="javascript:kenshoo_conv('Conv','','','','GBP')"<?php endif; ?> />

<!-- Loading spinner. Add class of "white" to .loading element to make it white -->
<p class="loading">Sending <span class="loader"></span></p>

</form>