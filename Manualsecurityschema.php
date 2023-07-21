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

<p><a name="SecuritySchema"><font size="+3"><b>Security Schema</b></font></a></p>
<p align="center"><img src="images/ovalheader.png" width="214" height="203"></p>
<p align="center"><img src="images/accessmanagement.png" width="500" height="198"></p>
<p align="left">The LAWPRACT security schema consists of the following parts:</p>
<ol><li><strong>Users</strong>:<br>
  A separate account should be created for each user.
  User accounts may be added or removed by an administrator or owner at:<br> 
  Users link as above in the header.<br>
  <br>
  Each user is assigned a 'Security Role' by selecting a choice 
  from the drop down list labeled 'Security Role'.<br>
  See below for a list of the default Security Roles available.<br> 
  I. Owner<br>
  II. System Administrator<br>
  III. Accountant<br>
  IV. Junior Lawyer<br>
  V. Data entry Operator<br>
  <br>
</li>
  <li><strong> Security Roles</strong>:<br>
    Security Roles may be added or removed by an administrator at:<br>
    Roles<br>
  </li>
</ol>
Page level security is maintained in the software. Every user is given a security role and this security role determines what area, tools, page and functionality a user can access in the software.<br>







       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       

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