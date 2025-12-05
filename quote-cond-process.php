<?php
	$errormsg = "";
	
	if (empty($_POST["opsys"])) {
		$errormsg .= "OS required. ";
	} else {
		$opsys = filter_var($_POST['opsys'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
		
	if ( $_POST["opsys"] == "Android" ) {
		
		if (empty($_POST["androidreqsevice"])) {
			$errormsg .= "Android Service required. ";
		} else {
			$androidreqsevice = filter_var($_POST['androidreqsevice'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}
		if (empty($_POST["androidreqfeatures"])) {
			$errormsg .= "Android Features required. ";
		} else {
			$androidreqfeatures = implode(", ",$_POST['androidreqfeatures']);
			$androidreqfeatures = filter_var($androidreqfeatures, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}
		
	}
	elseif ( $_POST["opsys"] == "Apple" ) {
		
		if (empty($_POST["applereqsevice"])) {
			$errormsg .= "Apple Service required. ";
		} else {
			$applereqsevice = filter_var($_POST['applereqsevice'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}
		if (empty($_POST["applereqfeatures"])) {
			$errormsg .= "Apple Features required. ";
		} else {
			$applereqfeatures = implode(", ",$_POST['applereqfeatures']);
			$applereqfeatures = filter_var($applereqfeatures, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}
		
	}
	else {
		
		if (empty($_POST["windowsreqsevice"])) {
			$errormsg .= "Windows Service required. ";
		} else {
			$windowsreqsevice = filter_var($_POST['windowsreqsevice'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}
		if (empty($_POST["windowsreqfeatures"])) {
			$errormsg .= "Windows Features required. ";
		} else {
			$windowsreqfeatures = implode(", ",$_POST['windowsreqfeatures']);
			$windowsreqfeatures = filter_var($windowsreqfeatures, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}
		
	}	
	
	if (empty($_POST["probudget"])) {
		$errormsg .= "Budget required. ";
	} else {
		$probudget = filter_var($_POST['probudget'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	if (empty($_POST["priority"])) {
		$errormsg .= "Priority required. ";
	} else {
		$priority = filter_var($_POST['priority'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	if (empty($_POST["launchdate"])) {
		$errormsg .= "Estimated Launch Date required. ";
	} else {
		$launchdate = filter_var($_POST['launchdate'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	if (empty($_POST["fname"])) {
		$errormsg .= "First Name required. ";
	} else {
		$fname = filter_var($_POST['fname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	if (empty($_POST["lname"])) {
		$errormsg .= "Last Name required. ";
	} else {
		$lname = filter_var($_POST['lname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	if (empty($_POST["gender"])) {
		$errormsg .= "Gender required. ";
	} else {
		$gender = filter_var($_POST['gender'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	if (empty($_POST["address"])) {
		$errormsg .= "Address required. ";
	} else {
		$address = filter_var($_POST['address'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
	if (empty($_POST["email"])) {
		$errormsg .= "Valid Email required. ";
	} else {
		$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
	}
	if (empty($_POST["phone"])) {
		$errormsg .= "Phone required. ";
	} else {
		$phone = filter_var($_POST['phone'], FILTER_SANITIZE_NUMBER_INT);
	}
	if (empty($_POST["requirementdetails"])) {
		$errormsg .= "Requirement Details required. ";
	} else {
		$requirementdetails = filter_var($_POST['requirementdetails'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$requirementdetails = nl2br($requirementdetails);
	}
	if (empty($_POST["preferedcontact"])) {
		$errormsg .= "Prefered Contact Method required. ";
	} else {
		$preferedcontact = filter_var($_POST['preferedcontact'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}
		
	$additionalinfo = filter_var($_POST['additionalinfo'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$additionalinfo = nl2br($additionalinfo);
		
	if (!empty($_FILES['userfile']['name'])) {
		if ($_FILES['userfile']['size'] > 1048576) {
			$errormsg .= "Attachment is greter than 1 MB. ";
		}
		
		$allowed =  array('doc','docx','pdf','png');
		$filename = $_FILES['userfile']['name'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		if(!in_array($ext,$allowed) ) {
			$errormsg .= "Attachment alowed only doc/docx/pdf/png. ";
		}
	}
	
	$fullname = $fname . " " . $lname;
	
	$success = '';
	if (!$errormsg){
		
		require_once "mgs-functions.php";
		
		//email subject (Change here)
		$subject = "New Multi-Step-Form Demo Quote Request Submitted";
		$mail->Subject = htmlspecialchars($subject, ENT_QUOTES);
		
		$mgsetemple = true;		//Boolean true/false	true: email template	false: plain text email
		$body_message = "";
		if(!$mgsetemple) {
			//prepare email body [for Plain email use this]
			$body_message .= "Sender IP: " . get_client_ip() ."<br>";
			$body_message .= "Selected OS: " . $opsys ."<br>";
				
			if ( $opsys == "Android" ) {			
				$body_message .= "Required Android Service: " . $androidreqsevice ."<br>";
				$body_message .= "Required Android Features: " . $androidreqfeatures ."<br>";
			}
			elseif ( $opsys == "Apple" ) {
				$body_message .= "Required Apple Service: " . $applereqsevice ."<br>";
				$body_message .= "Required Apple Features: " . $applereqfeatures ."<br>";
			}
			else {
				$body_message .= "Required Windows Service: " . $windowsreqsevice ."<br>";
				$body_message .= "Required Windows Features: " . $windowsreqfeatures ."<br>";
			}
			
			$body_message .= "Project Budget: " . $probudget ."<br>";
			$body_message .= "Priority: " . $priority ."<br>";
			$body_message .= "Estimated Launch Date: " . $launchdate ."<br>";
			$body_message .= "Sender First Name: " . $fname ."<br>";
			$body_message .= "Sender Last Name: " . $lname ."<br>";
			$body_message .= "Sender Full Name: " . $fullname ."<br>";
			$body_message .= "Sender Gender: " . $gender ."<br>";
			$body_message .= "Sender Address: " . $address ."<br>";
			$body_message .= "Sender email: " . $email ."<br>";
			$body_message .= "Sender Phone: " . $phone ."<br>";
			$body_message .= "Prefered Contact Method: " . $preferedcontact ."<br>";
			$body_message .= "\n\n";
			$body_message .= "Requirement Details: " . $requirementdetails ."<br><br>";
			$body_message .= "Additional Info: " . $additionalinfo ."<br>";
		}
		else{			
			//prepare email body [Using email template]
			if ( $opsys == "Android" ) {			
				$body_message = file_get_contents('mgsc-email-template/mgsc-email-template-andro.php');			
				$mgsemailshorttag = array("[mgs-sender-ip]", "[mgs-sender-selected-os]", "[mgs-sender-required-android-service]", "[mgs-sender-required-android-features]", "[mgs-sender-project-budget]", "[mgs-sender-priority]", "[mgs-sender-launch-date]", "[mgs-sender-first-name]", "[mgs-sender-last-name]", "[mgs-sender-full-name]", "[mgs-sender-gender]", "[mgs-sender-address]", "[mgs-sender-email]", "[mgs-sender-phone]", "[mgs-sender-prefered-contact-method]", "[mgs-sender-requirement-details]", "[mgs-sender-additional-info]");
				$mgsemailshorttagvalue   = array(get_client_ip(), $opsys, $androidreqsevice, $androidreqfeatures, $probudget, $priority, $launchdate, $fname, $lname, $fullname, $gender, $address, $email, $phone, $preferedcontact, $requirementdetails, $additionalinfo);
				$body_message = str_replace($mgsemailshorttag, $mgsemailshorttagvalue, $body_message);			
			}
			elseif ( $opsys == "Apple" ) {
				$body_message = file_get_contents('mgsc-email-template/mgsc-email-template-apple.php');			
				$mgsemailshorttag = array("[mgs-sender-ip]", "[mgs-sender-selected-os]", "[mgs-sender-required-apple-service]", "[mgs-sender-required-apple-features]", "[mgs-sender-project-budget]", "[mgs-sender-priority]", "[mgs-sender-launch-date]", "[mgs-sender-first-name]", "[mgs-sender-last-name]", "[mgs-sender-full-name]", "[mgs-sender-gender]", "[mgs-sender-address]", "[mgs-sender-email]", "[mgs-sender-phone]", "[mgs-sender-prefered-contact-method]", "[mgs-sender-requirement-details]", "[mgs-sender-additional-info]");
				$mgsemailshorttagvalue   = array(get_client_ip(), $opsys, $applereqsevice, $applereqfeatures, $probudget, $priority, $launchdate, $fname, $lname, $fullname, $gender, $address, $email, $phone, $preferedcontact, $requirementdetails, $additionalinfo);
				$body_message = str_replace($mgsemailshorttag, $mgsemailshorttagvalue, $body_message);			
			}
			else {
				$body_message = file_get_contents('mgsc-email-template/mgsc-email-template-wind.php');			
				$mgsemailshorttag = array("[mgs-sender-ip]", "[mgs-sender-selected-os]", "[mgs-sender-required-windows-service]", "[mgs-sender-required-windows-features]", "[mgs-sender-project-budget]", "[mgs-sender-priority]", "[mgs-sender-launch-date]", "[mgs-sender-first-name]", "[mgs-sender-last-name]", "[mgs-sender-full-name]", "[mgs-sender-gender]", "[mgs-sender-address]", "[mgs-sender-email]", "[mgs-sender-phone]", "[mgs-sender-prefered-contact-method]", "[mgs-sender-requirement-details]", "[mgs-sender-additional-info]");
				$mgsemailshorttagvalue   = array(get_client_ip(), $opsys, $windowsreqsevice, $windowsreqfeatures, $probudget, $priority, $launchdate, $fname, $lname, $fullname, $gender, $address, $email, $phone, $preferedcontact, $requirementdetails, $additionalinfo);
				$body_message = str_replace($mgsemailshorttag, $mgsemailshorttagvalue, $body_message);			
			}
		}
		
		$mail->Body = $body_message;
		
		$uploadfile = "";
		if (!empty($_FILES['userfile']['name'])) {
			
			$ext = pathinfo($_FILES['userfile']['name'], PATHINFO_EXTENSION);
			$sname = strtolower(str_replace(" ", "-", $fname));
			$uploadfile = 'uploads/' . substr( base_convert( time(), 10, 36 ) . md5( microtime() ), 0, 8 ). '-' . $sname . '.' . $ext;
			if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
				// Attach the uploaded file
				$mail->addAttachment($uploadfile, $sname .'file-'. $_FILES['userfile']['name']);
			}
			
		}
		
		//send mail
		if(!$mail->send()) {			
			//delete files from server
			if (file_exists($uploadfile)){
				unlink($uploadfile);
			}	
			echo "Mailer Error: " . $mail->ErrorInfo;
		} 
		else {
			//delete files from server
			if (file_exists($uploadfile)){
				unlink($uploadfile);
			}
			//send confirmation email
			if($mgssendconfirmation){
				require_once "mgs-send-confirmation.php";
			}
			echo "success";		//DO NOT CHNAGE THIS LINE (required)
		}
		
	}
	else {
		echo "Something went wrong: ".$errormsg;
	} 
?>
