<?php 
include('includes/DefineJournalClass.php');

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

    <title>LawPract&trade;</title>

    <!-- additional styles for plugins -->
              
        <!-- chartist
        <link rel="stylesheet" href="bower_components/chartist/dist/chartist.min.css"> -->
		    
    <!-- uikit -->
     <link rel="stylesheet" href="bower_components/uikit/css/uikit.almost-flat.min.css" media="all">

   <!-- altair admin -->
    <link rel="stylesheet" href="assets/css/main.css" media="all">
    
     <!-- Live Search Styles -->
    <link rel="stylesheet" href="css/fontello.css">
    <link rel="stylesheet" href="css/animation.css">
	
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
                    <h3 class="heading_a">GL Journal</h3>
                    <?php include("GLJournal.php"); ?>
                  
            	</div>
            </div>
                
         </div>
              
     </div>  
      
      <!--- End of the Page Content    --->      
    

    <!-- common functions -->
    <script src="assets/js/common.min.js"></script>
    <!-- uikit functions -->
    <script src="assets/js/uikit_custom.min.js"></script>
    <!-- altair common functions/helpers -->
    <script src="assets/js/altair_admin_common.min.js"></script>
<script src="javascripts/MiscFunctions.js"></script>
    <!-- page specific plugins -->
        
        <!-- chartist (charts)
        <script src="bower_components/chartist/dist/chartist.min.js"></script> -->
        
        <!--  <script src="bower_components/maplace.js/src/maplace-0.1.3.js"></script>-->
        <!-- peity (small charts) -->
        <script src="bower_components/peity/jquery.peity.min.js"></script>
       
        <!-- countUp -->
        <script src="bower_components/countUp.js/countUp.min.js"></script>
        <!-- handlebars.js -->
        <script src="bower_components/handlebars/handlebars.min.js"></script>
        <script src="assets/js/custom/handlebars_helpers.min.js"></script>
        <!-- CLNDR -->
        <script src="bower_components/clndr/src/clndr.js"></script>
        
        <!--  dashbord functions 
        <script src="assets/js/pages/dashboard.min.js"></script>-->
    
       

</body>
</html>