<?php 

file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Handler.php') ? require_once __DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Handler.php' : die('There is no such a file: Handler.php');
file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Config.php') ? require_once __DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Config.php' : die('There is no such a file: Config.php');


use AjaxLiveSearch\core\Config;
use AjaxLiveSearch\core\Handler;

if (session_id() == '') {
    session_start();
}

    Handler::getJavascriptAntiBot();
    $token = Handler::getToken();
    $time = time();
    $maxInputLength = Config::getConfig('maxInputLength');

$PageSecurity = 5;
include('includes/session.php');

include('includes/SQL_CommonFunctions.inc');
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

    <title>LawPract</title>
 	<link rel="stylesheet" href="font-awesome-4.1.0/css/font-awesome.min.css" type="text/css" media="screen">
  
    <!-- uikit -->
    <link rel="stylesheet" href="bower_components/uikit/css/uikit.almost-flat.min.css" media="all">

    <!-- flag icons -->
    <link rel="stylesheet" href="assets/icons/flags/flags.min.css" media="all">

    <!-- altair admin -->
    <link rel="stylesheet" href="assets/css/main.css" media="all">
    
     <link rel="stylesheet" href="style.css" media="all">
     
        
     <!-- Live Search Styles -->
    <link rel="stylesheet" href="css/fontello.css">
    <link rel="stylesheet" href="css/animation.css">
    <!--[if IE 7]>
    <link rel="stylesheet" href="css/fontello-ie7.css">
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="css/ajaxlivesearch.min.css">
    
       <link rel="stylesheet" href="print.css" type="text/css" media="print" />
     
       <script src="jquery-1.11.1.min.js"></script>
    
    <script src="editablegrid.js"></script>	
    
     <script src="gltransgrid.js"></script> 

    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
    <![endif]-->

</head>
<body class=" sidebar_main_open sidebar_main_swipe">

    <?php include("header.php"); ?>
    <?php include("menu.php"); ?>

    <div id="page_content">
        <div id="page_content_inner">
          <label style="font-size:16px; font-weight:bold" class="heading_b uk-margin-bottom">General Ledger Transactions List</label><br>
		<label style="font-size:12px; font-weight:bold" class="heading_b uk-margin-bottom">Details of [A] Type-Payment: 12-Received, 13-Payment, 10-Invoice [B] Type no: Specifies Two entries of same Transaction [C] Posted: Shows Payment posted in balancesheet </label>
            <div class="md-card">
                <div class="md-card-content" style="overflow:auto">
                   <h1 class="heading_a">GL Transactions Grid</h1>
                     <i class="md-icon material-icons" id="invoice_print">&#xE8ad;</i>
                    <?php include("lw_gltransgridnew.php"); ?>
                  
            	</div>
            </div>
                
         </div>
              
     </div>  
      
      <!--- End of the Page Content    --->     
     
   <?php include("footersrc.php");      ?>
       
   <script src="print.js"></script>
        
        
</body>
</html>