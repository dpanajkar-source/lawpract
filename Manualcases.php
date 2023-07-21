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
 
<div  style="margin-left:10px; margin-right:10px"; align="justify">
  <p><a name="AccountsPayable"><font size="+3"><b>Cases</b></font></a>
  </p>
<p><font size="+2"><b>Overview</b></font>
    <br>

A primary function of the system is to enter new cases and update existing records. Once basic system is setup in the Lawpract, this form is the first and most important entry point to start creating new cases of clients.</p>
  <p>&nbsp;</p>
  <p align="center" style="overflow:auto"><img src="images/cases.png" alt=""/><br>
    <br>
    <font size="+2"><b>Features</b></font>
    <br>
    <br>
</p>
<ul>
<li>Client details record can be easily viewed</li>
<li>Full on-screen inquiry on a client's account, complete with a general ledger breakdown of how each entry was posted. Inquiries on how receipts are entered are also available</li>
<li>Full analysis of the outstanding balance is maintained</li>
<li>Any number of case's contacts can be maintained against the Party</li>
<li>Fully integrated to rest of the system</li>
<li>The system tracks n number of cases created for a single Party</li>
<li>On the fly creation of Party and Oppo Party from the same case window to facilitate address book entries for the same</li>
<li>Dynamically update master records during case record entry</li>
<li>Option for full integration with accounts available. Manual general ledger entry also can be done</li>
<li>Auto Brief_File No. incrementing is done by the system so user does not need to remember last case entry details for the same</li>
<li>Comprehensive search available using Brief_File no. or Party name for selecting previous entered records</li>
<li>Last 10 entered records are visible to the user at any time</li>
<li><strong>When a case is created using this form, an entry in the diary is automatically done. So entering next date for that specific case can be done in diary by searching for that case in the diary and updating the next date in the data grid. </strong></li>
</ul>

<p>
  <!-- Help Begin: Suppliers -->
  
  <font size="+2"><b>Entering Court Cases (Party and Opposition Party)</b></font>
  <br>
  <br>
  From the main menu click on "Cases". The new details entered are only committed to the database as a new case once the user clicks on the button to "Insert New Case". If the user moves to another screen without clicking this button any entries are lost. </p>
<p><font size="+1"><b>Radio Buttons</b></font></p>
<p>There are four radio buttons available. The user has to select only one button to mention the category of the case being entered. The selection of a radio button dynamically generates Brief_File number on the fly and is entered in the Brief_File No. Input field which is unique utility for the user. The user does not have to remember the previously entered number of Brief_File Number which aids quick case creation<br>
  <br>
  <font size="+1"><b>Brief_File Number</b></font>
  <br>
  <br>
  This field is used as a unique identifier for the case by the advocate internally in their office (maximum of 25 characters of text - letters or numbers). Brief_File no. is critically used to search a case physically as well as in the software system every where. This allows faster searches for cases - rather than the full text of the Party name - and keeps the size of the database at a minimum since it is referenced on all case transactions, accounts, and case contacts.The system will force this code to be in capitals and will not allow the use of spaces, the ampersand (&), * or hypen - or inverted commas ("). <br>
  <br>
Note: A brief_file code can be altered because of the large scale of the changes required to the system to update transactions, accounts, case contacts and it could present a significant drain on resources. The option to change a brief_file code is therefore in the utility menu Z_index.php - which must be entered as a manual URL and is only accessible by the system administrator. Such changes should only be undertaken when there are no other users on the system.</p>
<p>The first two alphabets represent the type of category of the new case for easy identification and classification. then comes the underscore. The numbers (typically 4 digits) are the case ids which increment by one automatically everytime a new case is entered.  After that another forward slash followed by four digits which represent current year. Month and year are automatically taken from the system date of the server where Advocate Office system is installed.</p>
<p>Example- BR_0230/2018 meaning brief creation<br>
  <br>
  <font size="+1"><b>Case Type</b></font></p>
<p>The case type is a drop down list which identifies the type of the new case being entered. It is important to record a new case type. There is an icon available for quick addition, updation in the master table for case types. One can readily use the feature during case entry. As soon as master records are updated, the new data is instantly available for the user without page refresh so the entered data in other input fields are retained for further operations.</p>
<p><font size="+1"><b>Case No</b></font>
  <br>
  <br>
  The number of the Case is used extensively in lookups and reports. This is a unique number used in the court where the case is lodged. Proper capitalisation and use of the full name of the case no is recommended. The maximum length of the name is 40 characters. Please ensure that there is no space between any of the characters otherwise this can directly affect Daily Diary data entry and lookups.<br>
  <br>
  <font size="+1"><b>Party Name</b></font>
  <br>
  <br>
  This is the name of the Party. One can select a Party from Address book if it is entered there prior to Case creation. If the contacts are not entered in the address book one can just enter the Party name in this field to automatically create contacts in the address book and also refer the contact as Party in the case being entered. These fields will allow a maximum of 100 characters and are compulsory. The system warns the user if the field is empty when user clicks Insert New Case Button. This feature is deliberately included so that cases are not entered without Party Name. Additional fields like address, mobile is also provided here for inclusion in the address book. One compulsory drop down list is provided (Select Role). Which is needed to identify the role of the Party in the case. Manually one has to select this.<br>
  <br>
  <font size="+1"><b>Opposition Party Name</b></font>
  <br>
  <br>
This is the name of the Opposition Party. One can select a Opposition Party from Address book if it is entered there prior to Case creation. If the contacts are not entered in the address book one can just enter the Party name in this field to automatically create contacts in the address book and also refer the contact as Opposition Party in the case being entered. These fields will allow a maximum of 100 characters and are compulsory. The system warns the user if the field is empty when user clicks Insert New Case Button. This feature is deliberately included so that cases are not entered without Opposition Party Name. Additional fields like address, mobile is also provided here for inclusion in the address book. One compulsory drop down list is provided (Select Role). Which is needed to identify the role of the OppositionParty in the case. Manually one has to select this. </p>
<p>An important point to remember is that only single entry is made in the address book for each Party and Oppo Party.
<p>There is facility to add multiple clients and opposite clients names as well. 
<p><strong>Photo feature is provided to click clients' photo for verification etc.</strong><br>
  <br>
  <font size="+1"><b>Party Category</b></font>
  <br>
  <br>
  In this field select the appropriate category from the drop down list. This field denotes the start category of the File or Brief, suggesting whether a new case is filed or notice is sent etc. There is an icon available for quick addition, updation in the master table for case Category. One can readily use the feature during case entry. As soon as master records are updated, the new data is instantly available for the user without page refresh so the entered data in other input fields are retained for further operations.<br>
  <br>
  <font size="+1"><b>Court Name</b></font>
  <br>
  <br>
  In this field select the court name from the drop down list where the case is officially lodged. There is an icon available for quick addition, updation in the master table for Court Name. One can readily use the feature during case entry. As soon as master records are updated, the new data is instantly available for the user without page refresh so the entered data in other input fields are retained for further operations.<br>
  <br>
  <font size="+1"><b>Current Stage</b></font>
  <br>
  <br>
  Please select the stage from the drop down list which is basically listed in chronological order as per Indian laws for particular case types. Typically for every new case being created the current stage will be the first option from the drop down list. There is an icon available for quick addition, updation in the master table for Current Stage. One can readily use the feature during case entry. As soon as master records are updated, the new data is instantly available for the user without page refresh so the entered data in other input fields are retained for further operations. <BR>
  <br>
  Note: that the New stage entered will reflect at the end of the drop down list. so enter and set current and next stage accordingly. Or call us for rearranging the stages because it will also reflect in other cases.<br>
  
  <BR>
  <font size="+1"><b>Next Stage</b></font>
  <br>
  <br />
  There is a facility to populate this field automatically after selecting current stage. The user does not need to enter any value manually in this field. By this facility the system prompts the user about the next stage in general. <br>
  <br />
  <font size="+1"><b>Narration</b></font>
  <br>
  <br>
  This field used to add any additional information pertaining to a case.
<p><font size="+1"><b>CNR No</b></font> <br>
    <br>
This field is an important one if one wishes to fetch next date automatically online corraborating ecourts website data<br />
      <br>
    <font size="+1"><b>Case Status</b></font>
      <br>
      <br>
    This reflects the status of a case. One can change case's status any time in Update mode. There are four types of status. 
  <ul><li> In process : All typical ongoing cases are come under this status.</li><li>  Inactive : Cases which are not active for any reason will be termed as inactive.</li><li> On hold : Cases which are temporarily withheld can be put on hold. For example if a case comes to a stand still for some reasons like court stay order, disappearance of witness party or opposite party, failure to comply with court regulations or defaults in court fee payments etc. </li>
   <li> Discarded : The cases which are adjoined or judgement is passed by the Honourable Court or death of Party or Opposite Party or case is amicably solved through out of court settlement can all be termed as Discarded Cases. </li>
   </ul>
   <p><BR>
     
       <font size="+2"><b>Opening Date</b></font>
        <br>
        <br>
     Here one needs to enter opening date when Brief or File was created.  
     <BR>
      <br>
      <font size="+2"><b>Closing Date</b></font>
      <br>
      <br>
     Here one needs to enter closing date when case was discarded.     </p>
   <p><br>
     <font size="+2"><b>Diary Date</b></font> <br>
     <br>
Here one needs to enter diary date ie there will be an entry for this caseno in our digital diary corresponding to that day of diary entry</p>
   <p><br>
     <font size="+2"><b>Next Date</b></font> <br>
     <br>
Here one needs to enter next court date ifatall the user has one. If next date is not provided NO entry will be done in the diary<BR>
       <BR>
     </p>
   <p><font size="+2"><b>Integrate into Accounts</b></font></p>
<p>This feature is available for user to create records in accounts automatically. Chart masters are created for the new case if 'yes' option is selected. Chart details are created for all the periods mentioned in the system for the case. General Ledger Code is created and are inserted in the chart masters under appropriate Accounting Group automatically.</p>
<p>&nbsp;</p>
<p><font size="+2"><b>Update Mode</b></font></p>
<p>This form in update mode will give lot of information to the user like stage history, caseno history, judge name history, closed cases facility with judgename and coram etc are also provided. One can edit the party name or oppo party name but this will change the name only from address book so it will change the same for all references of party and oppo parties in the entire software. You cannot allocate new party or oppo party here.</p>
</p>
<br>

 
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