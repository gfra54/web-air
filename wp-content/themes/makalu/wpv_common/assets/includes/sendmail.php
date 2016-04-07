<?php

// sends an email to $_POST['to'], nothing fancy

require_once( '../../../../../../wp-load.php' );

$sitename = get_bloginfo('name');
$siteurl =  home_url();

$to = isset($_POST['to'])? trim($_POST['to']) : '';
$name = isset($_POST['name'])? trim($_POST['name']) : '';
$email = isset($_POST['email'])? trim($_POST['email']) : '';
$content = isset($_POST['content'])? trim($_POST['content']) : '';

$error = false;
$error = ($to === '' || $email === '' || $content === '' || $name === '') || 
	     (!preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $email)) ||
	     (!preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $to));

if($error == false){
	$subject = "$sitename's message from $name";
	$body = "Site: $sitename ($siteurl) \n\nName: $name \n\nEmail: $email \n\nMessage: $content";
	$headers = "From: $name ($sitename) <$email>\r\nReply-To: $email\r\n";
	
	wp_mail($to, $subject, $body, $headers);
}