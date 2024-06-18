<?php

// *********** CONFIG OPTIONS ***********

//****Set session variables for posting config to the mailer****//
$_SESSION['companyName'] 	 = get_field('company_name', 'option');
$_SESSION['emailTo'] 		 = get_field('company_email_address', 'option');
$_SESSION['successMsg'] 	 = get_field('success_message', 'option');


//Set up attachments from WP options
$attachments = get_field('tf_attachments', 'option');

if($attachments == true) {
	if(get_field('number_of_attachments', 'option')) {
		$attachmentCount = get_field('number_of_attachments', 'option');			
	}
}

//Set up Data Capture from WP options

$dataCapture = get_field('tf_data_capture', 'option');

if($dataCapture == true) {
	$_SESSION['mailchimpApi'] = get_field('mailchimp_api', 'option');
	$_SESSION['mailchimpListId'] = get_field('mailchimp_list_id', 'option');
}

$services = array();
while( has_sub_field('services_list', 'options') ) {
	// print_r(get_sub_field('services', 'options'));
	$services[] = get_sub_field('services', 'options');
}

// *********** END OF CONFIG *********** //

?>

<form class="contact-form" name="Contact_Form" method="post" action="#" enctype="multipart/form-data">

	<label for="Name"> Name *
		<input type="text" name="Name" class="name validate focus" id="Name" data-validate="letters" />
		<span class="message" data-default="This field is required." data-issue="Something doesn't look right." data-success="Great!"></span>
	</label>

	<label for="Telephone">Phone Number *
		<input type="tel" name="Telephone" class="phone validate focus" id="Telephone" data-validate="phone" />
		<span class="message" data-default="This field is required." data-issue="That doesn't look like a valid number." data-success="Nice one."></span>
	</label>

	<label for="Postcode">Postcode
		<input type="text" name="Postcode" class="postcode focus" id="Postcode"/>
	</label>

	<label for="Email">E-mail *
		<input type="email" name="Email" class="email validate focus" id="Email" data-validate="email" />
		<span class="message" data-default="This field is required." data-issue="Incorrect email address." data-success="Looks good!"></span>
	</label>

<?php
//services
if(isset($services)): ?>
	<?php foreach($services as $service): ?>
				<label for="<?php echo str_replace(" ", "_", $service); ?>">
					<input type="checkbox" value="<?php echo $service; ?>" name="Looking For" id="<?php echo str_replace(" ", "_", $service); ?>" />
					<?php echo $service; ?>
				</label>
	<?php endforeach; ?>
<?php endif; ?>

<label class="further-details">Further details &#42; :
    <textarea name="Enquiry" class="email validate" rows="6" data-validate="text" ></textarea>
    <span class="message" data-default="This field is required." data-issue="Keep it clean please." data-success="All done."></span>
</label>

<?php
//attachments
if($attachments == true) : ?>
	<p class="clearfix">Attachments: (must be .gif, .jpg, .png, .pdf or .doc &amp; no larger than 2 MB)</p>
	<?php
		$count = 0;
		while($count < $attachmentCount) : ?>
		<label class="success">
			<input class="fileInput focus" type="file" name="upload[]" />
		</label>
		<?php $count++; ?>
	<?php endwhile; ?>
<?php endif; ?>

<?php
//data capture
if($dataCapture == true) : ?>
	<h2 class="clearfix">Subscribe for our special offers?</h2>
	<label class="data-capture">
		<label><input class="radio" type="radio" value="No_Thanks" name="subscription" />No Thanks!</label>

		<label><input class="radio" type="radio" value="Email_Updates" name="subscription" />Subscribe to Special Offers</label>
	</label>
<?php endif; ?>

<input name="submit_contact_form" class="submit" type="submit" value="Contact Us" <?php /* Check if Kenshoo is enabled */ if (get_field('kenshoo','options' )): ?>onclick="javascript:kenshoo_conv('Conv','','','','GBP')"<?php endif; ?> />

<!-- Loading spinner. Add class of "white" to .loading element to make it white -->
<p class="loading">Sending <span class="loader"></span></p>

</form>