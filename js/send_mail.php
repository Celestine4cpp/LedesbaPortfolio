<?php
/*
This first bit sets the email address that you want the form to be submitted to.
You will need to change this value to a valid email address that you can access.
*/
$webmaster_email = "celestineakpanoko@gmail.com";

/*
This bit sets the URLs of the supporting pages.
If you change the names of any of the pages, you will need to change the values here.
*/
$about = "about.html";
$error_message = "error_message.html";
$thank_you = "thank_you.html";

/*
This next bit loads the form field data into variables.
If you add a form field, you will need to add it here.
*/
$your_email = $_REQUEST['your_email'] ;
$comments = $_REQUEST['comments'] ;
$your_name = $_REQUEST['your_name'] ;
$msg = 
"First Name: " . $your_name . "\r\n" . 
"Email: " . $your_email . "\r\n" . 
"Comments: " . $comments ;

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

// If the user tries to access this script directly, redirect them to the feedback form,
if (!isset($_REQUEST['your_email'])) {
header( "Location: $about" );
}

// If the form fields are empty, redirect to the error page.
elseif (empty($your_name) || empty($your_email)) {
header( "Location: $error_message" );
}

/* 
If email injection is detected, redirect to the error page.
If you add a form field, you should add it here.
*/
elseif ( isInjected($your_email) || isInjected($your_name)  || isInjected($comments) ) {
header( "Location: $error_message" );
}

// If we passed all previous tests, send the email then redirect to the thank you page.
else {

	mail( "$webmaster_email", "Submitted", $msg );

	header( "Location: $thank_you" );
}
?>