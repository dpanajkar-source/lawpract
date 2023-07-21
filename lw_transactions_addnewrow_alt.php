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

$PageSecurity = 10;
include('includes/session.php');

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
 	<link rel="stylesheet" href="font-awesome-4.1.0/css/font-awesome.min.css" type="text/css" media="screen">
  
    <!-- uikit -->
    <link rel="stylesheet" href="bower_components/uikit/css/uikit.almost-flat.min.css" media="all">

   <script src="jquery-1.11.1.min.js"></script>
    
    <link rel="stylesheet" href="assets/css/main.css" media="all">
    
     <link rel="stylesheet" href="style.css" media="all">
     
     <link rel="stylesheet" href="bower_components/jquery-ui/themes/base/jquery-ui.css">  
     
        
     <!-- Live Search Styles -->
    <link rel="stylesheet" href="css/fontello.css">
    <link rel="stylesheet" href="css/animation.css">
    <!--[if IE 7]>
    <link rel="stylesheet" href="css/fontello-ie7.css">
    <![endif]-->
   <link rel="stylesheet" type="text/css" href="css/ajaxlivesearch.min.css">  
    
<script src="dist/sweetalert-dev.js"></script> 
    
   </head>
<body>

     <div id="page_content">
        <div id="page_content_inner">
            <div class="md-card">
                <div class="md-card-content">
                   <!--<h1 class="heading_a"></h1>-->
                   <div class="uk-width-medium-2-2">
        <div class="uk-form-row">
        <div class="uk-grid">
        <div class="uk-width-medium-1-2" style="padding-bottom:0px"><h1 class="heading_a">DIARY- Add a New Row</h1>
        </div>
               
                      
         <div class="uk-width-medium-1-2" align="right" style="padding-bottom:10px"><span  style="text-decoration:underline; cursor:pointer" onClick="javascript:MM_openbrwindow('Manualdiary_addnewrow.php',600,400);"><i class="material-icons md-color-green-500">&#xE887;</i></span>
        </div>             
               </div></div></div>
                    <?php 
					
					include("lw_transactions_addnewrow.php"); ?>
                  
            	</div>
            </div>
                
         </div>
              
     </div>  
      
      <!--- End of the Page Content    --->     
     
    <!-- uikit functions -->
    <script src="assets/js/uikit_custom.min.js"></script>
    <!-- altair common functions/helpers -->
    <script src="assets/js/altair_admin_common.min.js"></script>

    <!-- page specific plugins -->
      <!-- countUp -->
        <script src="bower_components/countUp.js/countUp.min.js"></script>
        <!-- handlebars.js -->
        <script src="bower_components/handlebars/handlebars.min.js"></script>
        <script src="assets/js/custom/handlebars_helpers.min.js"></script>
        
        <!--  dashbord functions -->
        <script src="assets/js/pages/dashboard.min.js"></script>
         
        
</body>
</html>