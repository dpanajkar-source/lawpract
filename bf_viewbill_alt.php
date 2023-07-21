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
	
$PageSecurity = 8;
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
  <link rel="stylesheet" href="print.css" type="text/css" media="print" />

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
         
         <?php
		        echo '<form action=' . $_SERVER['PHP_SELF'] . ' method="POST"><div>';
  	/*-----------------------------------------------------------------------------*/
	?>
  	
  		<br><div class="md-input-wrapper">
        <div class="uk-width-medium-1-1" style="padding-bottom:0px">
        <div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">
        <div class="uk-grid">
  	
                
        <div class="uk-width-medium-1-1" style="padding-bottom:10px">
  		<br><label for="billno">Select Bank</label></div>
 
                
  				<div class="uk-width-medium-1-2" style="padding-bottom:10px">
  				<input class="md-input" type="text" name="Bank_name" id="Bank_name">
  				</div>
  				 
                 <input  type="hidden" name="Banknamehidden" id="Banknamehidden">  
                 <input  type="hidden" name="Bankidhidden" id="Bankidhidden">
                   <input  type="hidden" name="Bankcode" id="Bankcode">   
                   
                  <!--   
                    <div class="uk-width-medium-1-5" style="padding-bottom:10px">
                    <a style="color:#ffffff; font-weight:bold; text-transform:capitalize" class="md-btn md-btn-block md-btn-primary md-btn-wave-light waves-effect waves-button waves-light">View Bills</a></div>-->
                  
                <div class="uk-width-medium-1-1" style="padding-bottom:10px" id="billview">
                </div>
            
                </div></div>              
           
                </form>               
                       
                </div>
            </div>

        </div>
     </div>
      
      <!--- End of the Page Content    --->      
  
<!-- Placed at the end of the document so the pages load faster -->
<script src="jquery-1.11.1.min.js"></script>

<script src="assets/js/common.js"></script> 

<!-- Live Search Script -->
<script type="text/javascript" src="ajaxlivesearch.js"></script>

<script>

	jQuery("#Bank_name").ajaxlivesearch({
        loaded_at: <?php echo $time; ?>,
        token: <?php echo "'" . $token . "'"; ?>,
        max_input: <?php echo $maxInputLength; ?>,
        onResultClick: function(e, data) {
            // get the index 1 (second column) value
            var bank_name = jQuery(data.selected).find('td').eq('1').text();
					
			var bankid = jQuery(data.selected).find('td').eq('4').text();
			
			var bank_code = jQuery(data.selected).find('td').eq('0').text();					
							
			$("#Banknamehidden").val(bank_name);	
		
			$("#Bankidhidden").val(bankid);		
			
			$("#Bankcode").val(bank_code);			 		   					
			
							
			// hide the result
           jQuery("#Bank_name").trigger('ajaxlivesearch:hide_result');
		  
		   $.ajax({
			url: 'bf_displaybills.php',
			type: 'POST',
			dataType: "html",
			data: {			
			'Bankname': $("#Banknamehidden").val(),
			'Bankid': $("#Bankidhidden").val(),		
			'Bankcode': $("#Bankcode").val()	
	  		},		
		 success: function (response) 
			{ 
				$("#billview").html(response);         
			},
			error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + errortext); },
			async: false
				});					
		
        },
        onResultEnter: function(e, data) {            
			
			
        },
        onAjaxComplete: function(e, data) {
       // jQuery('#Bank_name').val(bank_name);
			
			//jQuery('#Bank_code').val(bank_code);		
		
			
        }
    });
	
	</script>
    <script src="print.js"></script>
    <script src="assets/js/uikit_custom.min.js"></script>
    <!-- altair common functions/helpers -->
    <script src="assets/js/altair_admin_common.min.js"></script>
    
     <!--  notifications functions -->
    <script src="assets/js/pages/components_notifications.min.js"></script>

    <!-- page specific plugins -->
        
        <!-- handlebars.js -->
        <script src="bower_components/handlebars/handlebars.min.js"></script>
        <script src="assets/js/custom/handlebars_helpers.min.js"></script>     

        <!--  dashbord functions -->
        <script src="assets/js/pages/dashboard.min.js"></script>
    
            

</body>
</html>