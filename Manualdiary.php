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
  <p><a name="AccountsPayable"><font size="+3"><b>Diary</b></font></a>
  <br>
  <p align="center"; style="overflow:auto"><img src="images/diary1.png"/><br>
  <br> </p>
<p><font size="+2"><b>Overview</b></font>
  <br>

Diary forms a statutory requirement for a lawyer or advocate and is the most crucial book of entry. It is also widely used as evidence in the court of law. A full fledged Digital Diary is provided in the Software.</p>


  <font size="+2"><b>Features</b></font>
  <br>

</p>
<ul>
<li>Case details record can be easily viewed from a diary entry</li>
<li>
  <div >Which contains facilities like live Dictionary search, Sorting, accidental wrong data entry Deletions, Updations  and smooth record creation without data entry. 
  Only we have to enter Court dates. Back dated data entry is possible. 
  A facility to view a specific date related Diary entries.All possible diary entry errors and manipulations are avoided by keeping diary entry mostly Readable. One cannot make any changes in the records reflected in the daily diary because, these entries are furnished as evidence in the court of law. So no manipulations are allowed. </li>
  
<li>Every page in the Diary will show all cases of that day.</li>
<li>Search By Diary Date option in the Diary will show all cases of selected date.</li> 

<li>eCourts Link- External option in the Diary will open ecourts site in new window you can view updated dates or data here</li>
<li>Print option is provided to print page content. e.g. if you have filtered any case details you can print it</li>
<li>In Full diary an overriding feature is provided for the user to delete a record if there is an accidental new record entry or manual errors if atall, which can be corrected by deleting a specific record using delete the record icon for each row. Row will be deleted after pressing the delete button. Please use this feature with utmost caution. As it is not possible to retrive the deleted records</div>
</li>

</ul>

<p>
  <!-- Help Begin: Diary entry -->
  
  <font size="+2"><b>Entering Diary</b></font>
  <br>
  <br>
  We have kept the diary very simple to use. To create a row or enter a record for old data or missing date entry, just click the button 'Add New Row', which pops up a window. In the window select the case no from the drop down list for which a new entry needs to be made. Click 'Apply' button to insert a new row.
   A new row appears and one will notice that all the fields are automatically entered for the user. The only data entry in the Diary will be the next court date. Once the next court date is entered, all future diary entries for the case no will carry forward Next Court Date into Previous Date. So logically Next Court Date Becomes Previous Date for repeated case entries for the same court case. The Next Court Date will always be blank after next row entry to allow entry of the next court date given by the court. One can readily print daily Diary Report from the Reports main Menu on a daily basis and take it to the court.</p>
 
 <p>There is a facility for the user to change the Current Stage of a case from the same pop up window in the Diary. This facility is provided so that during diary entries sometimes there is a need to change the Current Stage. A drop down list is provided for the same. This change will be reflected in all records and reports for the case automatically.</p>
<p>A full featured Filter is provided in the diary. One can enter any text in the filter. Sorting of records are done according to the entered text in the Filter text box. The algorithm used is of a dictionary, where record sorting is done with filter text a keyword. So one can liberally enter any text of any field in the diary, whether a first word, middle word or the last word, dates as well to get the records sorted for a quick view. The sorting is very dynamic as every alphabet entered in the filter text box will sort the records on the fly. </p>
<p>There is a facility to enter todays' all diary entries (if case date fall for today) in a single click. The user doesn't even have to manually select each and every case. </p> 

<p>
There is also a new feature available to update next court dates directly from Internet corraborating ecourts data. If next court date is available for all the diary entries, this feature may update next court date. This is just for convenience so that next court dates available on ecourts website are visible in Lawpract for use.

</p>
<br />
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