<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta name="" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>    

     <link rel="icon" type="image/png" href="assets/img/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="assets/img/favicon-32x32.png" sizes="32x32">

    <title>LawPract&trade;</title>

     <!-- additional styles for plugins -->
       
        <!-- chartist -->
        <link rel="stylesheet" href="bower_components/chartist/dist/chartist.min.css">
    
    <!-- uikit -->
    <link rel="stylesheet" href="bower_components/uikit/css/uikit.almost-flat.min.css" media="all">

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
  
  <script src = "javascripts/MiscFunctions.js"></script>


</head>
<body class="sidebar_main_open sidebar_main_swipe">

  <?php 
    $PageSecurity = 3;
     include('includes/session.php');
     include("header.php"); 
     include("menu.php");    
      
    ?>     				  
       
    
    <div id="page_content">
        <div id="page_content_inner">
                  
            <div class="md-card">
                <div class="md-card-content"> <form method="POST" class="casesform" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                     <div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">         
        <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-2-2">
       
        <div class="uk-grid">
                 <div class="uk-width-medium-3-4" style="padding-bottom:0px">
              
         <input type="text" class="mdinputSearch" tabindex="1" name="mdinputSearch" id="mdinputSearch" placeholder="Type to search Party, Brief File No, Mobile No first and select the brief_file"></div> 
         <div class="uk-width-medium-1-4" align="right" style="padding-right:30px"> <span class="menu_title" style="text-decoration:underline; cursor:pointer" onClick="javascript:MM_openbrwindow('Manualfileuploads.php',600,400);"><i class="material-icons md-color-green-500">&#xE887;</i></span>
              </div></div></div></div>
           
      <input type="hidden" name="Searchparty" id="Searchparty">
      							 
						 


                                   <!-- <div class="uk-width-medium-1-3" style="padding-top:10px">
                                        
                                        <button class="header_main_search_btn uk-button-link"><i class="md-icon material-icons"></i></button>
                                    </div>--></form>
                                  
                	<h3 class="heading_a">Case Details </h3>
                      

              <?php 
    					include("lw_filesattach.php"); 
              ?>
                               
                </div>
            </div>

        </div>
     </div>

 
    
      
</body>
   
</html>