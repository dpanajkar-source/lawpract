<?php

if (isset($_POST['Submit'])) 
{

// Enter your MySQL access data  
  $host= 'localhost';         
  $user= 'root';               
  $pass= "Server!00@#$";
  $db='lawpract';
  $sqlFileName='backup/lawpract.sql';

$mysqlDumpCommand = 'C:\xampp\mysql\bin\mysqldump --opt --user=root --host=localhost --password="Server!00@#$" lawpract'.' > '.$sqlFileName;
system($mysqlDumpCommand); 

$filename = 'backup/lawpract.sql';
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));

fclose($handle);

//send dump file to the output

$filename="lawpract";

header('Content-Description:File Transfer');
header('Content-Type:application/octet-stream');
header('Content-Disposition: attachment; filename=' . $filename . "_" . date("Y-m-d_H-i-s") . ".sql");
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0'); 
header('Pragma: public');

echo $contents;
exit;

}
?>


<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>

     <link rel="icon" type="image/png" href="assets/img/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="assets/img/favicon-32x32.png" sizes="32x32">

    <title>LawPract&trade;</title>

    <!-- additional styles for plugins -->
   
    
    <!-- uikit -->
    <link rel="stylesheet" href="bower_components/uikit/css/uikit.almost-flat.min.css" media="all">

    <!-- flag icons -->
    <link rel="stylesheet" href="assets/icons/flags/flags.min.css" media="all">

    <!-- altair admin -->
    <link rel="stylesheet" href="assets/css/main.css" media="all">
    
     <!-- Live Search Styles -->
    <link rel="stylesheet" href="css/fontello.css">
    <link rel="stylesheet" href="css/animation.css">
    <!--[if IE 7]>
    <link rel="stylesheet" href="css/fontello-ie7.css">
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="css/ajaxlivesearch.min.css">

    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
    <![endif]-->

</head>
<body class=" sidebar_main_open sidebar_main_swipe">
<?php
    $PageSecurity = 3;
     include('includes/session.php');
	 include("header.php");  
     include("menu.php");   
	 
	 ?>
    <div id="page_content">
        <div id="page_content_inner">
            <div class="md-card">
                <div class="md-card-content">
                    <h3 class="heading_a">Backup Database</h3>
                  	<form action="<?php echo $_SERVER['PHP_SELF'] . '?' . SID; ?>" method="post">
					<div class="uk-width-medium-1-3">
                         <div class="uk-form-row">
                              <div class="uk-grid">
                              
                              <div class="uk-text-center">
                                <img class="md-user-image" src="databackup.png" alt=""/>
                                <br><label> Click Submit to backup your Database </label>
                   				<br><label> We recommend that Save your Lawpract database backup</label>
                    			<br><label> on another drive than C drive( ex D:, E:, F:) or external drive.</label> 
                                <br><label> Please copy database with filename lawpract.sql (text file) from physical location (mostly check your browser's download folder to locate the file)</label>                                    
                    			<div class="uk-width-1-1">
                                <button type="submit" class="md-btn md-btn-primary" name="Submit">Submit</button>
                     			</div>
                        	  </div>
                  </form>
            	</div>
            </div>
                
         </div>
              
     </div>  
      
   </div>
                
  </div>
              
 </div>  
      <!--- End of the Page Content    --->      
   <?php include("footersrc.php"); ?>
   
    <!-- JQuery-UI -->
    <link rel="stylesheet" href="assets/skins/jquery-ui/material/jquery-ui.min.css">
    <script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
    
  </body>
</html>