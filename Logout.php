<?php
/* $Revision: 1.17 $ */
$PageSecurity =2;

include('includes/session.php');

/*include ($rootpath . '/bower_components/jtable/lib/themes/basic/chkset.php');

	if(!($myrowchk[0]===$hfile) || !($myrowchk[1]===$lfile) )
	{
	         echo 'Security breached';
	 
			 echo '<div style="text-align:center">This software is not Licensed to be use on this machine. If you wish to purchase Lawpract Software Click on following link to claim your Lawpract genuine Software Copy. For any query email us on support@lawpract.com</div>';
			 
			 unlink('lic.txt');
			 
			 unlink($rootpath . '/bower_components/jtable/lib/themes/basic/lwtables.php');
			 
			 echo '<a href="lawpract.com/shop">  </a>';
			 

	
	}else
	{ */
	
if (isset ($_SESSION['UsersRealName']) && $_SESSION['UsersRealName']!='') {
$sql="UPDATE www_users U set loggedin='no' WHERE U.realname='" . DB_escape_string($_SESSION['UsersRealName']) . "'";
			$Auth_Result = DB_query($sql, $db);
	
	unset($sql);
	unset($Auth_result);
	
	}
	
							// Define the folder to clean
// (keep trailing slashes)
$captchaFolder  = '';
 
// Filetypes to check (you can also use *.*)
$fileTypes      = '*.tmp';
 
// Here you can define after how many
// minutes the files should get deleted
$expire_time    = 5; 
 
// Find all files of the given file type
foreach (glob($captchaFolder . $fileTypes) as $Filename) {
 
    // Read file creation time
    $FileCreationTime = filectime($Filename);
 
    // Calculate file age in seconds
    $FileAge = time() - $FileCreationTime; 
 
    // Is the file older than the given time span?
    if ($FileAge > ($expire_time * 60)){
 
        // Now do something with the olders files... 
        // For example deleting files:
        unlink($Filename);
    }
 
}//end of temp file deletion

?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>    

    <link rel="icon" type="image/png" href="assets/img/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="assets/img/favicon-32x32.png" sizes="32x32">

   <title><?php echo $_SESSION['CompanyRecord']['coyname'];?> - <?php echo _('Log Off'); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo _('ISO-8859-1'); ?>" />

     <!-- additional styles for plugins -->
    
    <!-- uikit -->
    <link rel="stylesheet" href="bower_components/uikit/css/uikit.almost-flat.min.css" media="all">

   <!-- altair admin -->
    <link rel="stylesheet" href="assets/css/main.css" media="all">

  </head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<div id="container">
	
	<div align="center" id="login_box">
	<form action=" <?php echo $rootpath;?>/index.php" name="loginform" method="post">
	
	<input type="submit" value="<?php echo _('Login Again'); ?>" name="SubmitUser" class="md-btn md-btn-primary" />
	</form>
	</div>
</div>

</body>
</html>

<?php
	// Cleanup
	
	session_start();
	session_unset();
	session_destroy();
	
	
	//}
?>
</body>
</html>


