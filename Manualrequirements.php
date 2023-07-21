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
 
<div align="justify"><br>
  <br>

  <a name="Requirements"><font size="+3"><b>Requirements</b></font></a>

  <br>
  <br>

  <font size="+2"><b>Hardware Requirements</b></font>

  <br>
  <br>

There are many possible configurations that could run this application. The scale of operations obviously will have a significant bearing on the final configuration

<br>
<br>

The operating system and the database engine chosen will have the largest bearing on System requirements. Each client connection to the web server and database engine will also consume RAM so the more connections the larger the RAM requirement. Similarly disk space required is a function of the volume of contacts, cases and transactions. Suffice it to say that due to the efficiency of the components of the system the demands on the hardware are exceptionally light. Total size of software is around 600MB which is very small in todays world.

<br>
<br>

As a guide, an installation for up to 50 simultaneous users could consist of the following: a Linux operating system/Windows operating system, an Apache web server, an entry level server/desktop system with 1024 MB RAM and a 10 Megabit network card.  This would provide more than adequate performance. 100 Megabit network cards are now entry level. RAID SCSI swappable disks are preferred in any mission critical environment where disk access is intensive. 1 GB of hard disk space is more than enough for software ine.stallation and future anticipated us
 
<br>
<br>

With multiple servers with SMP, load balancing, a separate database server, and large amounts of RAM the limit on database size and the number can be scaled to the most demanding businesses.

<br>
</div>
<ul>
</ul>

<div align="justify"><font size="+2"><b>Software Requirements</b></font>
  
  <br>
  <br>
  LAWPRACT basically runs on any platform. This version is typically installed in windows environment. This software is built using cutting edge web technologies compatible with all versions of windows operating systems, Linux. Also XAMPP server is installed which is required for LAWPRACT to install and work on. XAMPP stands for Apache web server, M for MySQL database P for PHP scripting engine. On windows operating systems it is mandatory to install Microsoft Visual C++ 2008 or above redistributable -x86 installed on your pc. Otherwise Lawpract will not install. Latest version Google Chrome browser is needed to use Lawpract. If not installed, it can be downloaded easily from internet. Lawpract offers best user experience in Google Chrome. 
  
  Adobe Acrobat reader should be installed in your pc so all reports generated in .pdf format can be readily viewed and printed. Please install a good anti virus software in your pc and keep it updated and regular scan should be a routine to keep your pc or laptop virus free and your all important database will be safe and sound.  <br>
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