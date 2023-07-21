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

    <title>LawPract&trade;</title>
 	<link rel="stylesheet" href="font-awesome-4.1.0/css/font-awesome.min.css" type="text/css" media="screen">
  
    <!-- uikit -->
    <link rel="stylesheet" href="bower_components/uikit/css/uikit.almost-flat.min.css" media="all">

    <!-- flag icons -->
    <link rel="stylesheet" href="assets/icons/flags/flags.min.css" media="all">

    <script src="jquery-1.11.1.min.js"></script>    
    <script src="editablegrid.js"></script>	
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
      <link rel="stylesheet" href="print.css" type="text/css" media="print" />
   
     <script src="trans.js"></script> 
 
    <script>
function MM_openbrwindow(x,width,height){
var smswindow=window.open(x,'popup','width=' + width + ',height=' + height + ',scrollbars=0,resizable=no,toolbar=no,directories=no,location=no,menubar=no,status=no,left=180,top=30');
}


</script>
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
            <div class="md-card">
                <div class="md-card-content">
                   <!--<h1 class="heading_a"></h1>-->
                   <div class="uk-width-medium-2-2">
        <div class="uk-form-row">
        <div class="uk-grid">
        <div class="uk-width-medium-1-5" style="padding-bottom:10px"><h1 class="heading_a">DIARY</h1>
        </div>
        <div class="uk-width-medium-1-5" style="padding-bottom:10px"><a href="lw_transactionsfull_alt.php" target="_blank">
            <span class="menu_icon"><i class="material-icons md-color-pink-600">&#xE30d;</i></span>
            <span class="menu_title">Click here for Full Diary</span></a> 
        </div>
        <div class="uk-width-medium-1-5" style="padding-bottom:10px">
         	<i class="material-icons md-color-green-500">&#xE03B;</i>
<span style="text-decoration:underline; cursor:pointer" onClick="javascript:MM_openbrwindow('http://ecourts.gov.in/index.php',600,400);"> eCourts Link - External</span>
        </div>  
        
        <div class="uk-width-medium-1-5" style="padding-bottom:10px">
         	<i class="material-icons md-color-green-500">add_circle_outline</i>
<span style="text-decoration:underline; cursor:pointer" onClick="javascript:MM_openbrwindow('lw_transactions_addnewrow_alt.php',900,400);">Add New Row</span>
        </div>  
        
                      
         <div class="uk-width-medium-1-5" align="right" style="padding-bottom:10px"><i class="md-icon material-icons" id="invoice_print">&#xE8ad;</i>	&nbsp;&nbsp; <span  style="text-decoration:underline; cursor:pointer" onClick="javascript:MM_openbrwindow('Manualdiary.php',600,400);"><i class="material-icons md-color-green-500">&#xE887;</i></span>
        </div>             
               </div></div></div>
                    <?php include("lw_transactions.php"); ?>
                  
            	</div>
            </div>
                
         </div>
              
     </div>  
      
      <!--- End of the Page Content    --->     
      
         <script src="print.js"></script>
         
         
     
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
      <script>  
       	//below is for main search for the lw_casenewajax form
	jQuery(".HeaderinputSearch").ajaxlivesearch({
        loaded_at: <?php echo $time; ?>,
        token: <?php echo "'" . $token . "'"; ?>,
        max_input: <?php echo $maxInputLength; ?>,
        onResultClick: function(e, data) {
            // get the index 1 (second column) value
            var selectedsearch = jQuery(data.selected).find('td').eq('0').text();

            // set the input value
            jQuery('.HeaderinputSearch').val(selectedsearch);
			
			jQuery('#Searchheaderhidden').val(selectedsearch);
			
			
			 /*// get the index 1 (second column) value for address
            var selectedtwo = jQuery(data.selected).find('td').eq('1').text();

            // set the input value
            jQuery('.md-inputaddress').val(selectedtwo);
			
			 // get the index 1 (second column) value for mobile
            var selectedthree = jQuery(data.selected).find('td').eq('2').text();

            // set the input value
            jQuery('.md-inputmobile').val(selectedthree);*/
						
			// hide the result
           jQuery(".HeaderinputSearch").trigger('ajaxlivesearch:hide_result');
        },
        onResultEnter: function(e, data) {
            // do whatever you want
            //jQuery(".mySearch").trigger('ajaxlivesearch:search', {query: 'test'});
        },
        onAjaxComplete: function(e, data) {

        }
    });
	
	
        </script>
    
     
        
</body>
</html>