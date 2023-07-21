 <?php
 $PageSecurity = 3;

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
    
       <link rel="stylesheet" href="print.css" type="text/css" media="print" />
    
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
   
    <?php include("header.php"); ?>
    <?php include("menu.php"); ?>    
    
<div id="page_content">
    <div id="page_content_inner">

        <h3 class="heading_b uk-margin-bottom">Stages List</h3>

        <div class="md-card">
            <div class="md-card-content">
             <div class="filtering">
    <form>
   		<div class="uk-width-medium-1-1" style="padding-bottom:0px">
        <div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">
         
        <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-2-2">
        
        <div class="uk-grid">
        
		<div class="uk-width-medium-1-3" style="padding-bottom:10px">
      	<input type="text" class="md-input" name="stagename" id="stagename" placeholder="Type Stage and Enter"/></div>
        <div class="uk-width-medium-1-3" style="padding-bottom:0px">
       	<button type="submit" style="visibility:hidden" class='md-btn md-btn-primary' id="LoadRecordsButton">Load records</button>  </div> 
      
        </div>
        </div>
        </div>
        </div>
        </div>      
    </form>
            <div id="stagegrid"></div>
            </div>
        </div>

    </div>
</div>

<div class="md-fab-wrapper">
    <a class="md-fab md-fab-danger" href="#" id="recordAdd">
        <i class="material-icons">&#xE145;</i>
    </a>
</div>

  <?php include("footersrc.php");      ?>
   
   
     <script src="print.js"></script>
 
    <!-- JQuery-UI -->
    <link rel="stylesheet" href="assets/skins/jquery-ui/material/jquery-ui.min.css">
    <script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
    <!-- jTable -->
    <link rel="stylesheet" href="assets/skins/jtable/jtable.css">
    <script src="bower_components/jtable/lib/jquery.jtable.js"></script>

    <!--  diff functions -->
    <script src="assets/js/CRUD/stage.js"></script>
    
  


</body>
</html>