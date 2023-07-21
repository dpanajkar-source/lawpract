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
 <div  style="margin-left:100px; margin-right:100px"; align="justify">
  <p><a name="AccountsPayable"><font size="+3"><b>Accounts Master</b></font></a>
  <br>
  <br> </p>
<p><font size="+2"><b>Overview</b></font>
    <br>

The primary function of the accounts master is to create sections, groups and general ledgers in the accounts system. Below is the screenshot of accounts section. The sections are broad categories with numbering which appear in Trial Balance, Profit &amp; Loss and Balance Sheet in ascending order. Under sections we have accounts groups. Accounts groups are classifications of general ledgers according to their use and belonging. General ledgers of same nature come under same groups. Lawpract uses OOPS concept. So one can create as many groups and general ledgers as possible. Nested groups are also possible which means one group under another primay group etc. The accounting sections and groups are all created for the system. One has to just use the general ledgers whereever required while data entry. </p>
<p>While creating an accounts group one has to suggest whether it belongs to P &amp; L or balance sheet. This is very important. Also the numbering is of importance as it will appear in the accounting statements as per the numbering and corresponding section numbers. For general use we have populated all the master forms for full use. Just in case something is missing the user can add. Please be mindfull in creating these master form entries as wrong postings can be difficult to trace.</p>
<p align="center"; style="overflow:auto"><img src="images/accountsection.png" width="600" height="292" /></p>
<p align="center">&nbsp;</p>
  <p align="center"; style="overflow:auto"><img src="images/accountgroups.png" width="697" height="341" /></p>
<p align="center">&nbsp;</p>

</div></div>







       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       

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