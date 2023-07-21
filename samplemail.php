<?php
/*
From http://www.html-form-guide.com 
This is the simplest emailer one can have in PHP.
If this does not work, then the PHP email configuration is bad!
*/
$msg="";
if(isset($_POST['submit']))
{

$file_dir  = "upload";    

    for ($x = 0; $x < count($_FILES['file']['name']); $x++) {               

      $file_name   = $_FILES['file']['name'][$x];
      $file_tmp    = $_FILES['file']['tmp_name'][$x];

      /* location file save */
      $file_target = $file_dir . DIRECTORY_SEPARATOR . $file_name; /* DIRECTORY_SEPARATOR = / or \ */

      if (move_uploaded_file($file_tmp, $file_target)) {                        
        echo "{$file_name} has been uploaded. <br />";                      
      } else {                      
        echo "Sorry, there was an error uploading {$file_name}.";                               
      }                 

    }               
     
    /* ****Important!****
    replace name@your-web-site.com below 
    with an email address that belongs to 
    the website where the script is uploaded.
    For example, if you are uploading this script to
    www.my-web-site.com, then an email like
    form@my-web-site.com is good.
    */

	$from_add = "name@your-web-site.com"; 

	$to_add = "someone@gmail.com"; //<-- put your yahoo/gmail email address here

	$subject = "Test Subject";
	$message = "Test Message";
	
	$headers = "From: $from_add \r\n";
	$headers .= "Reply-To: $from_add \r\n";
	$headers .= "Return-Path: $from_add\r\n";
	$headers .= "X-Mailer: PHP \r\n";
	
	
	/*if(mail($to_add,$subject,$message,$headers)) 
	{
		$msg = "Mail sent OK";
	} 
	else 
	{
 	   $msg = "Error sending email!";
	}*/
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html>
<head>
	<title>Test form to email</title>
</head>

<body>
<?php echo $msg ?>
<p>
<form enctype="multipart/form-data" action="post_upload.php" method="POST">
<form action='<?php echo htmlentities($_SERVER['PHP_SELF']); ?>' method='post'>
<input type="file" name="file[]" id="file" multiple="true" >
<input type='submit' name='submit' value='Submit'>
</form>
</p>


</body>
</html>