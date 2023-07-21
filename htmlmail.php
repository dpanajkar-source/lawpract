<?php 

$PageSecurity = 2;

include('includes/session.php');

include('macaddress.php');
include('htmlMimeMail5.php');
    
  $mail = new htmlMimeMail5();                               // Create the email object
    $mail->setFrom('dinesh@lawpract.com');           // Set the From: address
    $mail->setCc('dinesh <dpanajkar@rediffmail.com>');        // Set the Cc: address (es)
    //$mail->setBcc('Fred <fred@example.com>');                  // Set the Bcc: address(es)
    $mail->setSubject('Test email');                           // Set the subject
    $mail->setPriority('high');                                // Set the priority
    $mail->setText('Hi how are you Dinesh');                             // Set the text
   // $mail->setHTML('<b>Sample HTML</b> Hello vidula!');         // Set the HTML (optional)
    //$mail->setReceipt('dpanajkar@rediffmail.com');                        // Set a receipt
	
    $mail->addAttachment(new FileAttachment('bills/receipt.doc')); // Add a file to the email
	
	$mail->setSMTPParams('send.one.com', 587, 'dinesh', true, 'dinesh@lawpract.com', 'Server!00');
	 
	//$addresses=array('dpanajkar@rediffmail.com');
	
	
		
	$result = $mail->send(array('dpanajkar@rediffmail.com'), 'mail');	
	
	// These errors are only set if you're using SMTP to send the message
		if (!$result) {
			print_r($mail->errors);
		} else {
			echo 'Mail sent!';
		}
	
	
?> 



