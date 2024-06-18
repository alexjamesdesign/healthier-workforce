<?php
session_start();
//****CONFIG****//

$companyName = $_SESSION['companyName'];
$emailTo = $_SESSION['emailTo'];
$successMsg = $_SESSION['successMsg'];

//message to be displayed to the user

// MAILCHIMP
if(isset($_SESSION['mailchimpApi'])) {
    $mailchimpApi = $_SESSION['mailchimpApi'];
    // MailChimp List ID
    $mailchimpListId = $_SESSION['mailchimpListId'];
}
else {
    $mailchimpApi = '';
    $mailchimpListId = '';
}

//IF SUBSCRIPTION
if(isset($_POST['subscription'])) {
    $subscription = $_POST['subscription'];
}
else {
    $subscription = '';
}

//Date and time stamp to create reference number:
date_default_timezone_set('Europe/London');
$date = new DateTime();
$referenceNo = $date->format('si / hd - my');

//ATTACHMENTS
//set max size
$maxsize = 2 * 1024 * 1024; // 2 MB

//set allowed file types
$types = array(
	'image/png',
	'image/jpeg',
	'image/gif',
	'application/msword',
	'application/pdf'
);

if($_POST) {

	//check if its an ajax request, exit if not
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
        $output = json_encode(array( //create JSON data
            'type'=>'error',
            'text' => 'Sorry Request must be Ajax POST'
        ));
        die($output); //exit script outputting json data
    }

    //set the email from addresses
    if(isset($_POST['Email'])) {
    	$emailFrom = $_POST["Email"];
    }
    elseif(isset($_POST["Callback_Email"])) {
    	$emailFrom = $_POST["Callback_Email"];
    }
    else {
    	$emailFrom = $emailTo;
    }
    
    $formName = $_POST['form_name'];
    $emailSubject = ucwords("Adtrak Website - $formName Enquiry");

	//require the mailer
	require_once("assets/class.phpmailer.php");
	require_once("assets/class.smtp.php");

	//initialise a mail() instance

    //SendInBlue SMTP Settings
    $mail=new PHPMailer();
    $mail->IsSMTP();                                            // Set mailer to use SMTP
    $mail->Host = 'smtp-relay.sendinblue.com';                          // Specify main and backup server
    $mail->Port = 587;                                          // Set the SMTP port
    $mail->SMTPAuth = true;                                     // Enable SMTP authentication
    $mail->Username = 'emailforms@adtrak.co.uk';       // SMTP username
    $mail->Password = '80ULwzNKFIgms1f7';       // LIVE API KEY
    $mail->SMTPSecure = 'tls';                                  // Enable encryption, 'ssl' also accepted]

    $mailCustomer =new PHPMailer();
    $mailCustomer->IsSMTP();                                        // Set mailer to use SMTP
    $mailCustomer->Host = 'smtp-relay.sendinblue.com';                      // Specify main and backup server
    $mailCustomer->Port = 587;                                      // Set the SMTP port
    $mailCustomer->SMTPAuth = true;                                 // Enable SMTP authentication
    $mailCustomer->Username = 'emailforms@adtrak.co.uk';   // SMTP username
    $mailCustomer->Password = '80ULwzNKFIgms1f7';   // LIVE API KEY
    $mailCustomer->SMTPSecure = 'tls';                              // Enable encryption, 'ssl' also accepted    
    
	//set variables
	//subject
	$mail->Subject = $emailSubject;
	$mailCustomer->Subject = "$companyName | Thanks for getting in touch!";
	//destination email address
    $mail->AddAddress($emailTo, $emailTo);
    $mail->AddAddress("xavier.hodgetts@adtrak.co.uk", "xavier.hodgetts@adtrak.co.uk");
	$mailCustomer->AddAddress($emailFrom, $emailFrom);
	//sender Email address
    //$mail->SetFrom("noreply@emailforms.adtrak.co.uk", $companyName);
    //$mailCustomer->SetFrom("noreply@emailforms.adtrak.co.uk", $companyName);
    //sender Name
    $mail->FromName = $companyName;
    $mailCustomer->FromName = $companyName;
	//reply to Email address
	$mail->AddReplyTo($emailFrom, $emailFrom);
	$mailCustomer->AddReplyTo($emailTo, $emailTo);

	//create the mail message to go to the client
	$msg = "<html><body style=\"font-family:Arial, sans-serif; font-size:12px; padding: 0; margin: 0px; color:#555;\"><div style=\"padding: 20px\">";
	$msg .= "<h1 style=\"font-family:Arial, sans-serif; font-size: 16px;\">$companyName | $emailSubject</h1>";
	$msg .= "<h2 style=\"font-family:Arial, sans-serif; font-size: 14px;\">from $emailFrom | Reference Number: $referenceNo</h2>";
	
	$msg .= "<table style=\"padding:2%; margin:0; width: 96%; background-color: #fafafa;\" >";

	//customer copy
	$msgCustomer = "<html><body style=\"font-family:Arial, sans-serif; font-size:12px; padding: 0; margin: 0px; color:#555;\">";
	$msgCustomer .= "<h1 style=\"font-family:Arial, sans-serif; font-size: 16px;\">$companyName | $emailSubject</h1>";
	$msgCustomer .= "<h2 style=\"font-family:Arial, sans-serif; font-size: 14px;\">from $emailTo | Reference Number: $referenceNo</h2>";
	$msgCustomer .= "<p style=\"font-family:Arial, sans-serif; font-size: 12px;\">Thanks for getting in touch. We have received your message and we'll get back to you as soon as possible. </p>";
	$msgCustomer .= "<p style=\"font-family:Arial, sans-serif; font-size: 12px;\">A copy of your message is included below.</p>";
	$msgCustomer .= "<table style=\"padding:2%; margin:0; width: 96%; background-color: #fafafa;\" >";

	//loop through posted data
	foreach($_POST as $data => $value) {
		//debugging

		if($data !== "form_name" && $data != "upload") {		
			$i = str_replace("_"," ",ucfirst($data));
			$msg .= "<tr style=\"border-bottom: 1px solid #ccc;\">";
			$msg .= "<td valign=\"center\" style=\"width: 20%; background-color: #fff; font-family:Arial, sans-serif; padding:8px 10px; margin:0; font-size:12px; font-weight: bold;\">". str_replace(" $value"," ",$i) ."</td>\n";
			
			$msg .= "<td valign=\"center\" style=\"width: 65%; background-color: #fff; font-family:Arial, sans-serif; font-size: 12px; padding:8px 10px;margin:0;\">".$value."</td>\n";
			$msg .= "</tr>"; 

			//customer copy
			$msgCustomer .= "<tr style=\"border-bottom: 1px solid #ccc;\">";
			$msgCustomer .= "<td valign=\"center\" style=\"width: 20%; background-color: #fff; font-family:Arial, sans-serif; padding:8px 10px; margin:0; font-size:12px; font-weight: bold;\">". str_replace(" $value"," ",$i) ."</td>\n";	
			$msgCustomer .= "<td valign=\"center\" style=\"width: 65%; background-color: #fff; font-family:Arial, sans-serif; font-size: 12px; padding:8px 10px;margin:0;\">".$value."</td>\n";
			$msgCustomer .= "</tr>"; 

		}	


	}//endforeach

	$msg .= "</table>
	<p style=\"display: block; font-family: Arial; font-size: 12px;\">This email has come from your <a href=\"http://www.adtrak.co.uk\">Adtrak</a> Website</p></body></html>";
	//customer copy
	$msgCustomer .= "</table>
	<p style=\"display: block; font-family: Arial; font-size: 12px;\">You have received this Email because you completed a form on our website.</p></div></body></html>";

	//set the email message to $msg
	$mail->MsgHTML($msg);
	//customer copy
	$mailCustomer->MsgHTML($msgCustomer);

    if($_FILES) {
        //attachment information
        for($i=0; $i < count($_FILES["upload"]); $i++) // This loop will upload all the files you have 

        foreach(array_keys($_FILES['upload']['name']) as $key) {
            $source = $_FILES['upload']['tmp_name'][$key]; // location of PHP's temporary file for this.
            $filename = $_FILES['upload']['name'][$key]; // original filename from the client
            $filesize = $_FILES['upload']['size'][$key]; // original file size from the client
            $filetype = $_FILES['upload']['type'][$key]; // original file type from the client

            if($filesize <= $maxsize && in_array($filetype, $types)) {
                //attach file if the filesize is smaller than the max size
                $mail->AddAttachment($source, $filename);
                $mailCustomer->AddAttachment($source, $filename); 
            }
         }// endforeach 
     }    

	// SUBSCRIBE TO MAILING LIST OPTION - ADD TO MAILCHIMP USING API (only if mailchimp is set)

    if($subscription !== '') {
        if ($subscription == 'Email_Updates' || $subscription == 'Telephone_and_Email_Updates' ) {
            
            // Include Mailchimp API class
            require_once('assets/MCAPI.class.php');
         
            // Your API Key: http://admin.mailchimp.com/account/api/
            $api = new MCAPI($mailchimpApi);
         
            // Your List Unique ID: http://admin.mailchimp.com/lists/ (Click "settings")
            $list_id = $mailchimpListId;
         
            // Variables in your form that match up to variables on your subscriber
            // list. You might have only a single 'name' field, no fields at all, or more
            // fields that you want to sync up.
            if ($subscription == 'Telephone_and_Email_Updates'){
                $merge_vars = array(
                    'NAME' => $_POST['Name'],
                    'EMAIL' => $_POST['Email'],
                    'TELEPHONE' => $_POST['Telephone']
                );
            }
            elseif ($subscription == 'Email_Updates'){
                $merge_vars = array(
                    'FNAME' => $_POST['Name'],
                    'EMAIL' => $_POST['Email']          
                );
            }
            
            // SUBSCRIBE TO LIST
            if ( $api->listSubscribe($list_id, $_POST['Email'], $merge_vars) === true ){
                $mailchimp_result = 'Success! Check your email to confirm sign up.';
                }
            else {
                $mailchimp_result = 'Error: ' . $api->errorMessage;
            }
        }//end mailchimp
    }

	


	if(!$mail->Send()) {
		//If mail couldn't be sent output error.
        $output = json_encode(array('type'=>'error', 'text' => 'Could not send mail! Please check your PHP mail configuration.'));
        die($output);
	} 
	else {
		if($emailTo !== $emailFrom) {
			$mailCustomer->Send();
		}
		$output = json_encode(array('type'=>'message', 'text' => $successMsg));
	    die($output);    	
	}	



}

?>

