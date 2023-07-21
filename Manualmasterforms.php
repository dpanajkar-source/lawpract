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
<div align="justify"><br>
  <br>
<font size="+3"><b>Using Master Forms</b></font>


  <br>
  <br>
</div>
 
<div align="center">
  <p><img src="images/masterform.png"></p>
  <p><img src="images/masterform1.png" width="525" height="254"></p>
</div>

<p align="justify">Master forms can be managed by clicking master forms menu tab on the right hand side of the software layout. These master forms already have respective data filled for the user to directly use them. The master forms data can be selected when creating a new case or updating an existing case. When creating a new case all the drop down lists available in the user data entry form are actually master forms. For example drop downs like case types, stages, courts, roles etc. These master form data can be manipulated. Although basic data is entered one can alter the master forms contain relevant data. Just go to any master form and you will find a data grid with entries populated. Just click an edit icon for any row and you can change the row data and click save to make changes. There is a plus sign in a circle which will open a popup to create a new record. Also an existing record can be deleted provided the entry is not used in any previous saved cases. </p>
<p align="justify">The Grid is a full featured CRUD operations table. ie one can change, read, delete and insert data as required. The changes made in the master forms are readily available throughout the system to be used. As you can see one of the master forms is displayed as above. Grid tables like above are easy ways to view, edit, delete and add records. Now you might be familiar about the icons used in Lawpract. The plus sign as shown in the above image is for creating new row or data.</p>





       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       

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