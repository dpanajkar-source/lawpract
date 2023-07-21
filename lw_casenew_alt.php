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
    
    <link rel="stylesheet" type="text/css" href="dist/sweetalert.css">
      
   <script src="dist/sweetalert-dev.js"></script>
    <script src="javascripts/MiscFunctions.js"></script>

    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
    <![endif]-->
  
    <!-- <script language="javascript" type="text/javascript">
$(function(){
  $('#Brief_File').bind('input', function(){
    $(this).val(function(_, v){
      return v.replace(/\s+/g, ' ');
    });
  });
});
</script>-->


</head>
<body class=" sidebar_main_open sidebar_main_swipe" onLoad="init(); hdclose();">

  <?php 
    $PageSecurity = 3;
     include('includes/session.php');
     include("header.php"); 
     include("menu.php");    
      
    ?>     				  
                           
     <div id="top_bar" style="height:43px">
        <div class="md-top-bar">
        
        
            <div class="uk-width-large-10-12 uk-container-center">                             
                      
                 			<div class="uk-grid uk-grid-width-1-3 uk-grid-width-large-1-2">
                                 
                              <div class="uk-width-medium-2-3">
               <form method="POST" class="casesform" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="text" class="mdinputSearch" name="mdinputSearch" id="mdinputSearch" placeholder="Type to search Party, Brief File No, Mobile No for Update mode"></div> 
      <input type="hidden"  name="Searchhidden" id="Searchhidden">								 


                                    <div class="uk-width-medium-1-3" style="padding-top:10px">
                                        
                                     <button class="header_main_search_btn uk-button-link"><i class="md-icon material-icons"></i></button>
                                    </div>
           </form>
                            </div> 
            </div>
        </div>
    </div>
   
    
    
    <div id="page_content">
          <div id="page_content_inner">
                  
            <div class="md-card">
                <div class="md-card-content">
                
              <?php 
    					include("lw_casenewajax.php"); 
              ?>
                               
                </div>
            </div>

        </div>
     </div>

 
<!-- uikit functions 
     common functions -->
    
    <script src="assets/js/uikit_custom.min.js"></script>
    <!-- altair common functions/helpers -->
    <script src="assets/js/altair_admin_common.min.js"></script>
    
     <!--  notifications functions -->
    <script src="assets/js/pages/components_notifications.min.js"></script>

    <!-- page specific plugins -->
        
        <!-- handlebars.js -->
        <script src="bower_components/handlebars/handlebars.min.js"></script>
        <script src="assets/js/custom/handlebars_helpers.min.js"></script>
       
        <!-- fitvids 
        <script src="bower_components/fitvids/jquery.fitvids.js"></script>-->

        <!--  dashbord functions -->
        <script src="assets/js/pages/dashboard.min.js"></script>
        
       <script defer src = "script.js"></script>
   <script defer src = "lw_cases.js"></script>
   
   <script src="sweetalert.min.js"></script>
    
     <script>
        window.onbeforeunload = function (e) {
// Your logic to prepare for 'Stay on this Page' goes here 

    return "Please click 'Stay on this Page'";
};
    
     </script>
</body>

  
    
   
</html>