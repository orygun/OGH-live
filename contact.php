<?php 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
	//$company = trim($_POST["company"]);
    $message = trim($_POST["message"]);

   if (!isset($error_message)) {
        foreach( $_POST as $value ){
            if( stripos($value,'Content-Type:') !== FALSE ){
                $error_message = "There was a problem with the information you entered.";
            }
        }
    }

	
    if ($_POST["address"] != "") {
        $error_message = "Your form submission has an error.";
    }

    require 'inc/phpmailer/PHPMailerAutoload.php';
    $mail = new PHPMailer();
	
	if (!$mail->ValidateAddress($email)) {
		$error_message = "Please enter a valid name, email, and message.";
	}
	
	if (!isset($error_message)) {
		$email_body = "" . "\r\n";
		$email_body = $email_body . "Name: " . $name . "\r\n";
		$email_body = $email_body . "Email: " . $email . "\r\n";
		$email_body = $email_body . "Message: " . $message . "\r\n";

		$mail->SetFrom($email, $name);
		$address = "sales@oregongreenhost.com";
		$mail->addAddress($address, "Oregon Green Host");
		$mail->addAddress($email, $name);

		$mail->Subject = "Oregon Green Host - Contact Us | " . $name;
		$mail->Body = "Thank you for contacting us! " . $email_body ;

		if($mail->Send()) {
			header("Location: contact.php?status=thanks");
			exit;
		} else {
			$error_message = "There was a problem sending the email: " . $mail->ErrorInfo;
		}
    }
}


?>



<!DOCTYPE html>
<html>
<head>
	<title>Contact Us | Oregon Green Host</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
	<link href='http://fonts.googleapis.com/css?family=Electrolize' rel='stylesheet' type='text/css'>
<style>	
label, th {
	vertical-align:top;}
	</style>
</head>
<body>

<?php 
$pageTitle = "Contact Us";
$section = "contact";
include('inc/header.php'); ?>
  <div class="main">
  	 <div class="content">
  	   <div class="wrap">
  	 	<div class="support">
  	 		   <!--<p></p>-->
			   <div class="section group">
				<div class="col span_2_of_3">
				  <div class="contact-form">
				  	<h3>Leave Us a message</h3>



    <div class="section page">
        <div class="wrapper">

            <?php if (isset($_GET["status"]) AND $_GET["status"] == "thanks") { ?>
                <p>Thanks for the email! We&rsquo;ll be in touch shortly!</p>
            <?php } else { ?>

                <?php
					if (!isset($error_message)) {
					echo '<p>Complete the form to send us an email.</p><br>';
					} else {	
						echo '<p class="message">' . $error_message . '</p>';
					}
				?>
				<span>
                <form method="post" action="contact.php">

                    <table>
                        <tr>
                            <th>
                                <label for="name">Name</label>
                            </th>
                            <td>
                                <input type="text" name="name" id="name" value="<?php if (isset($name)) { echo htmlspecialchars($name); } ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="email">Email</label>
                            </th>
                            <td>
			<input type="text" name="email" id="email" value="<?php if(isset($email)) { echo htmlspecialchars($email); } ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                <label for="message">Message</label>
                            </th>
                            <td>
                                <textarea name="message" id="message"><?php if(isset($message)) { echo htmlspecialchars($message); } ?></textarea>
                            </td>
                        </tr> 
                        <tr style="display: none;">
                            <th>
                                <label for="address">Address</label>
                            </th>
                            <td>
                                <input type="text" name="address" id="address">
                                <p>Please leave this field blank.</p>
                            </td>
                        </tr>                   
                    </table>
                    <input type="submit" value="Send">

                </form>
</span>
            <?php } ?>

        </div>

    </div>
				  </div>
  				</div>
				<div class="col span_1_of_3">
					<div class="contact_info">
    	 				<h3>Find Us Here</h3>
					    	  <div class="map">
							   	    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d91740.55948196012!2d-122.98213573733776!3d44.06492872252183!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x54c0de472e7002bf%3A0x536dbe99c4a3fd6!2sSpringfield%2C+OR!5e0!3m2!1sen!2sus!4v1427097732549" width="100%" frameborder="0" style="border:0"></iframe>
							  </div>
      				</div>
      				<div class="company_address">
				     	<h3>Company Information :</h3>
						  <h4>Oregon Green Host LLC</h4>
							<p>Springfield, Oregon</p>
						  <p>USA</p>
				   		<p>Email: <a href=mailto:"sales@oregongreenhost.com">sales@oregongreenhost.com</a></p>
							<p>Web: <a href="http://oregongreenhost.com">oregongreenhost.com</a></p>
				   	</div>
				 </div>
			  </div>
  	   </div>  	  
  	  </div>  	     
    </div>         
  </div>
 <?php include("inc/footer.php"); ?>
</body>
</html>

