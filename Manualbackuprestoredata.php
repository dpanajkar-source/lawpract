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
  <p><a name="Archivecases"><font size="+3"><b>Back up and Restore Data</b></font></a>
  <br>
  </p>
<p>Data backup is an important tool. Periodically the user should take backup of the entire data of Lawpract. Click on Back up entire database tab in Tools to open the window. Click on backup button to take complete backup of the data. The file created will be .sql format. It will be downloaded in the downloads folder of the browser. Please keep this file safe by copying it (right click and click copy) and place it in another drive of the hard disk or USB drive for further use. In case the system malfunctions or the computer of laptop stops functioning or crashes, the user can restore this backed up data through Restore Database tool. </p>
<p>Back up of database should be a regular feature for the user. Weekly backup should be fine. If there is heavy data entry every day it is advised to take database backup everyday ideally. Please keep in mind that backup and restoration of data is only for latest backed up data. There are no restore points in Lawpract in this current version. Restoring Lawpract database backup means that entire (installed) Lawpract database will be overwritten with the database which is being restored. This is a critical aspect one has to consider before restoring any backedup Lawpract database. Lawpract provides auto backup feature in which one will get latest database backup in lawpract/backup folder. You can then restore this database in Lawpract software.</p>
<p><br>

A brief information about auto backup facility- It is strongly advised to backup your database regularly. In principle, database backup is needed once you enter data regularly and everyday. You can take regular backups as mentioned about. But Lawpract also has an internal backup routine to safeguard your database. This database backup is saved as lawpract.sql file which resides in your Lawpract root folder with windows path as below. 

'C:\xampp\htdocs\lawpract\backup' 

Please copy this file by right clicking it and selecting copy from the context menu (windows) and save it on another drie like D: or E: and also USB drive to save your data in case your pc crashes or hard disk fails. This way you can retrieve your data to its latest state. In case of system failures etc, one has to install LAWPRACT again. During this re-installation lawpract will create a basic database to run the system. After starting the Lawpract post installation, it is important to restore your previously saved lawpract database with all your entered data. For this we have a restore database utility in the tools menu on the left hand side of Lawpract screen. Please use this tool to restore your database. 

 </p>
<BR>
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