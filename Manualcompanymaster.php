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
<div class="uk-width-medium-1-1" style="padding-bottom:10px; padding-top:10px; padding-right:10px">
       
       
 <div  style="margin-left:10px; margin-right:10px"; align="justify">
 
<div style="margin-left:20px; margin-right:20px"; align="justify">
<p><a name="Companymaster" id="Companymaster"><font size="+3"><b>Company Master</b></font></a><br />
    <br />
</p>
<p><font size="+2"><b>Overview</b></font> <br /> 
  This form is the most Basic form containing all information of the Organization using the software. This is the only form which maintains data regarding the Organization. The record is used vitally in all the reports so the first and foremost work of an Organization is to fill all the text boxes with relevant values.</p>
<p align="center"; style="overflow:auto"><img src="images/companymaster.png" alt="" /><br />
</p>
<p>
  <font size="+2"><b>Entering Company Information</b></font> <br />
  <br />
From the main menu click on System and then from the drop down select Master Form. The above form appears. The Company details entered during Lawpract installation are stored in the database as a single record. Barrister Number is the Number provided by the Government to the Advocate to identify himself uniquely in the Legal Industry. It is the Bar Council accredition Number.</p>
<p>The next section is the Financial details section. Here debtors control and Creditors control accounts are provided. This is used only in accounts (Accrual Based accounting). Accounts Receivable is officially the Debtors control account. One cannot change these settings as they can adversely reflect in accounts</p>
<p>The are general contact information which can be readily be made available as a report for the office use.</p>
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