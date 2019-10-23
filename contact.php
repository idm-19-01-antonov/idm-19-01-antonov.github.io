<?php
	if(!$_POST) exit;
	
	//PHP Mailer
	require_once(dirname(__FILE__)."/layout/plugins/phpmailer/class.phpmailer.php");
	
	///////////////////////////////////////////////////////////////////////////

		//Enter name & email address that you want to emails to be sent to.
		
		$toName = "Prizm";
		$toAddress = "email@sitename.com";
		
	///////////////////////////////////////////////////////////////////////////
	
	//Only edit below this line if either instructed to do so by the author or have extensive PHP knowledge.
	
	//Form Fields
	$name = htmlspecialchars(trim($_POST["name"]));
	$email = htmlspecialchars(trim($_POST["email"]));
	$message = htmlspecialchars(trim($_POST["message"]));
	
	//Error variable
	$error = "";
	
	//Check name
	if(!$name) {
		$error .= "Please enter your name.<br />";
	}

	//Check if email is valid
	if(empty($email)) {
		$error .= "Please enter your e-mail.<br />";
	}
	
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$error .= "Please enter a valid email address.<br />";
	}
	
	//Check message
	if(get_magic_quotes_gpc()) {
		$message = stripslashes($message);
	}
	
	if(!$message) {
		$error .= "Please enter the message.<br />";
	}
	
	//Result
	if(!$error) {
		$subject = "New Message";
		
		$body = "<p>You have been contacted by <b>".$name."</b>. The message is as follows.</p>
					<p>----------</p>
					<p>".preg_replace("/[\r\n]/i", "<br />", $message)."</p>
					<p>----------</p>
					<p>
						E-mail Address: <a href=\"mailto:".$email."\">".$email."</a>
					</p>";
					
		$objmail = new PHPMailer();
	
		//Use this line if you want to use PHP mail() function
		$objmail->IsMail();
		
		//Use the codes below if you want to use SMTP mail
		/*			
		$objmail->IsSMTP();
		$objmail->SMTPAuth = true;
		$objmail->Host = "mail.yourdomain.com";
		$objmail->Port = 587;	//You can remove that line if you don't need to set the SMTP port
		$objmail->Username = "example@yourdomain.com";
		$objmail->Password = "email_address_password";
		*/
		
		$objmail->SetFrom($email, $name);
		$objmail->AddAddress($toAddress, $toName);		
		$objmail->Subject = $subject;
		$objmail->MsgHTML($body);
		
		if(!$objmail->Send()) {
			echo "Message sending error: ".$objmail->ErrorInfo;
		} else {
			echo "ok";
		}
	} else {
		echo '<div class="notification_error"></div>';
	}
?>