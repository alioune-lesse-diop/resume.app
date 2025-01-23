<?php

// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Methods: POST,GET,OPTIONS");
// header('Access-Control-Allow-Credentials: true');
// header('Access-Control-Allow-Headers: Origin,Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With,Access-Control-Allow-Credentials');

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);


// Replace this with your own email address
$siteOwnersEmail = 'contact@diopsoft.com';


if($_POST) {

   $name = trim(stripslashes($_POST['contactName']));
   $email = trim(stripslashes($_POST['contactEmail']));
   $subject = trim(stripslashes($_POST['contactSubject']));
   $contact_message = trim(stripslashes($_POST['contactMessage']));

   // Check Name
	if (strlen($name) < 2) {
		$error['name'] = "Veuillez saisir votre nom.";
	}
	// Check Email
	if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
		$error['email'] = "Veuillez saisir une adresse mail valide.";
	}
	// Check Message
	if (strlen($contact_message) < 15) {
		$error['message'] = "Veuillez écrire votre message. Il doit comporter au moins 15 caractères.";
	}
   // Subject
	if ($subject == '') { $subject = "Contact Form Submission"; }
	
	$subject = "FROM MY WEBSITE - " . $subject;


   // Set Message
   $message .= "Email from: <i>" . $name . "</i><br />";
	$message .= "Email address: <i>" . $email . "</i><br />";
   $message .= "Message: <br />";
   $message .= "<i>" . $contact_message . "</i>";
   $message .= "<br /><hr /> Ce message a été envoyé depuis le formulaire de contact de votre site personnel. <br />";

   // Set From: header
   $from =  $name . " <" . $email . ">";

   // Email Headers
	$headers = "From: " . $from . "\r\n";
	$headers .= "Reply-To: ". $email . "\r\n";
 	$headers .= "MIME-Version: 1.0\r\n";
	//$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";


   if (!$error) {

      ini_set("sendmail_from", $siteOwnersEmail); // for windows server
      $mail = mail($siteOwnersEmail, $subject, $message, $headers);

		if ($mail) { echo "OK"; }
      else { echo "Something went wrong. Please try again."; }
		
	} # end if - no validation error

	else {

		$response = (isset($error['name'])) ? $error['name'] . "<br /> \n" : null;
		$response .= (isset($error['email'])) ? $error['email'] . "<br /> \n" : null;
		$response .= (isset($error['message'])) ? $error['message'] . "<br />" : null;
		
		echo $response;

	} # end if - there was a validation error

}

?>