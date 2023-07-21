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
    <!-- altair admin -->
    <link rel="stylesheet" href="assets/css/main.css" media="all">   
   

</head>
<body class=" sidebar_main_open sidebar_main_swipe">
    <!-- main header -->
    <?php
    $PageSecurity = 3;
     include("includes/session.php");
     include("header.php"); 
     include("menu.php"); 
   ?>
   
    <div id="page_content">
    <div id="page_content_inner">
            
               

<div class="md-input-wrapper"><div class="md-card"><div class="md-card-content">
<div class="uk-width-medium-1-1" style="padding-bottom:0px">
<div class="uk-grid uk-grid-width-1-1 uk-grid-width-large-1-1">
<div class="uk-width-medium-1-1" style="padding-bottom:10px; padding-top:10px; padding-right:10px"><h2>Lawpract Header Help</h2>
       
<div  style="margin-left:10px; margin-right:10px"; align="justify">
    <p align="center"><br>
      <br>
      
        <a name="Requirements"><font size="+3"><b>Import Contacts</b></font></a>
      
      <br>
      <br>
      <img src="images/importcontacts.png" width="778" height="716"><br>
      </p>
    <p align="left">Importing of Contacts is possible in the Lawpract at this point of time. The user has to create an excel sheet (.csv) format with column names exactly mentioned as above. Click the filed names can be found here to obtain more information. Once the user creates an excel sheet with column names as above and then create contact names in the excel sheet, the excel sheet can then be imported into Lawpract. Please make sure that the id field is auto incremental and unique field in Lawpract. So the user has to take care that id's mentioned in the excel sheet are also unique and incremental and they do not collide with id's in lawpract. In the Lawpract software one can click address book to find out the next incremental id for new contact. Go to last page in the address book grid to find the last id used. As the user imports data in the address book the imported data will append to the existing address book in Lawpract.</p>
  </div>






       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       

        </div> </div>
 </div> </div> </div> </div>

  <!-- Search Form Demo -->
  <?php include("footersrc.php");      ?>
   
   
     <script src="print.js"></script>
 
    <!-- JQuery-UI -->
    <link rel="stylesheet" href="assets/skins/jquery-ui/material/jquery-ui.min.css">
    <script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
    <!-- jTable -->
    

   
</body>
</html>