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
 
 <div align="center">
<p><font size="+2" color="blue"><b><u>Address Book</u></b></font></p></div>

 
    <br>
   
<div style="overflow:auto"; align="center">

    <img src="images/addressbook.png"><br />
</div>
<br> 
Address Book is only used to enter contacts. These contacts are displayed in the Case Entry Form  for Party Name and Opposite Party Name as well as all other searches in the system. One can easily select a contact in the respective drop down list in Case Entry Form. Once a case is created these contacts are stored as party or oppo party for that case only. For any new case involving the same contact will be differently treated and their role is specified in the new case. 
<p>The above screen shot shows the address book. The plus '+' sign (red color) is for adding new record. Just click on it to open a pop up window for entering a new contact. There is a facility to suggest next  unique contact number. This is automatically assigned to help the user.
<br />
    <br>
    <font size="+2"><b>Features</b></font>
    
    <br>
    
    </p>

<ul>
<li>A quick view of contacts is provided in a grid format for easy viewing and modifications</li>
<li>It is cautioned to the user that any changes in the address book will change all entries in all related database records immediately. Whether it is case, reports, accounts etc everywhere the new changes will be done permanently.</li>
<li>Every page in the address book will show predefined number of records only. Next set of records will be shown in the next page. Dynamically pages are numbered at the end of the html page for quick traversal. The address book will retain the last viewed page</li>
</ul>

<p>
  <!-- Help Begin: Suppliers -->
  
  <font size="+2"><b>Entering Address Book</b></font>
  <br>
  <div style="overflow:auto"; align="center">
  <img src="images/addressbookadd.png"><br />
  </div>
  <br>
  We have kept the address book very simple to use. To create a row or enter a records, just click the button '+', which pops up a window. In the window enter the contact name for which a new entry needs to be made. Click 'Apply' button to insert a new row. A the new row appears for the new contact. Other contact details can now be entered in the grid itself. The grid is fully editable. The only field non editable ie readable only is 'id' field. This field is system generated and cannot be changed. This id is used to uniquely identify the contact internally so cannot be changed. </p>
<p>A full featured Filter is provided in the address book. One can enter any text in the filter. Sorting of records are done according to the entered text in the Filter text box. The algorithm used is of a dictionary, where record sorting is done with filter text a keyword. So one can liberally enter any text of any field in the address book, whether a first word, middle word or the last word, dates as well to get the records sorted for a quick view. The sorting is very dynamic as every alphabet entered in the filter text box will sort the records on the fly. </p>
<p><font size="+1"><b>Full Name:</b></font> Enter a complete name in this field with only single space between words. you can also add any identifier to that name at the end. (ie Name Middlename Surname - City) if there are similar names to be entered. The Name entered in any format, will be stored in capital letters only, in the database. The reason for doing this is for easy viewing and auto formatting in the Diary or Address Book as well as Reports. The user can enter full name in normal case without worrying about -Sentence Capital, Case Capital etc. This field can accept 100 Characters. Do not enter non English Characters (%,*,$,#, @, ? ,&quot;&quot;, '', ', !, etc.) in This field.</p>
<p><font size="+1"><b>Address:</b></font> You can enter a Landline in this text field. There is no Formatting accepted in this field.<br />
    <font size="+1"><b><br />
      Mobile No 1:</b></font> You can enter a Mobile No of client in this text field. There is no Formatting accepted in this field.<br />
  <font size="+1"><b><br />
    Mobile No 2:</b></font> You can enter a second Mobile No of client in this text field. There is no Formatting accepted in this field.<br />
  <font size="+1"><b><br />
    Email id:</b></font> You can enter a second Email id of client in this text field. There is no Formatting accepted in this field.</p>
<p><font size="+2"><b>Updating Address Book</b></font> <br />
</p>
<br />
<div style="overflow:auto"; align="center">
  <img src="images/addressbookedit.png"><br />
</div>
  <br />
<p>Records can be easily updated by clicking any cell in the grid. Once valid text is entered in the cell the user has to leave the cell and go to another cell or press 'Enter' key on the keyboard to update any cell value. The whole record will flash a green colour if the entered data is valid and updated. If it is an invalid data entered, the row will flash a red colour to let the user know that the data entered is incorrect. </p>

<p><font size="+2"><b>Features</b></font> <br />
</p>
<ul>
  <li>Single entry of a contact can be entered, viewed and modified</li>
  <li>It is cautioned to the user that any changes in the any contact record will change all entries in all related database records immediately. Whether it is case, reports, accounts etc everywhere the new changes will be reflected permanently.</li>
</ul>
<p><font size="+1"><b><br />
  Using Search:</b></font> In Lawpract, We have consistantly provided search fields for almost all forms. In Contact form also there is search provided. At the top of the form there is search or filter field available. One can search contacts by using any value (ie name, mobile, email etc). It is a dynamic search.</p>
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