<?php

// Address to send the form to.
$webmaster_email = "i12b3games@gmail.com";

// URLs of supporting pages.
$contact_page = "contact.html";
$error_page = "feedback_error.html";
$thank_you_page = "feedback_thank_you.html";

// Load the form data into variables.
$user_name = $_REQUEST['name'] ;
$user_email = $_REQUEST['email'] ;
$user_message = $_REQUEST['message'] ;
$feedback =
"Name: " . $user_name . "\r\n" .
"Email: " . $user_email . "\r\n" .
"Message: " . $user_message ;


/*
The following function checks for email injection.
Specifically, it checks for carriage returns - typically used by spammers to inject a CC list.
*/
function isInjected($str) {
	$injections = array('(\n+)',
	'(\r+)',
	'(\t+)',
	'(%0A+)',
	'(%0D+)',
	'(%08+)',
	'(%09+)'
	);
	$inject = join('|', $injections);
	$inject = "/$inject/i";
	if(preg_match($inject,$str)) {
		return true;
	}
	else {
		return false;
	}
}

// If the user tries to access this script directly, redirect them to the feedback form.
if (!isset($_REQUEST['email'])) {
    header( "Location: $contact_page" );
}
// If the form fields are empty, redirect to the error page.
elseif (empty($user_name) || empty($user_email)) {
    header("Location: $error_page");
}
// If email injection is detected, redirect to the error page.
elseif ( isInjected($user_email) || isInjected($user_name)  || isInjected($user_message) ) {
    header("Location: $error_page");
}
// If we passed all previous tests, send the email then redirect to the thank you page.
else {
	mail("$webmaster_email", "Feedback Form Results", $feedback);
	header("Location: $thank_you_page");
}
?>
