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
<p><a name="Companymaster" id="Companymaster"><font size="+3"><b>Cash Receipt</b></font></a><br />
    <br />
</p>
<p>  This is the most important accounts entry form. Just type to search party, brief file no or mobile no and the search field throws a table showing relevant search results. Just select a case you wish to enter cash receipt for. Click one of the radio buttons to suggest whether the user wishes to enter cash receipt or cash payment. As soon as user selects a case from the search box (Result) the client name, total legal fees, balance amount, and invoice no. if created will all get populated automatically. The user has to just enter date of cash receipt, amount and narration and then press save transaction to create a general ledger transaction. Automatically the results are available in the trial balance, P &amp; L and Balance sheets where applicable. Cash entry or payment entry is made very simple for use. </p>
<p>In the below screen one can see two windows. Left hand side Window is for entering all receipts and payments for clients of the advocate. The right hand side window is to be used for cash receipts and payments for other than clients ex. Suppliers of vendors, MSEB, Telephone, furniture, office stationary, computer stationary, printing etc. Here there is an added feature to create a new vendor as well. Existing vendor can be searched as usual from the type to search contact field but if the user enters a new name which is not there in the database, the system will create a new contact on the fly from this window only. There is no need to create a contact in the address book separately. One can also create general ledger entry for cash receipt or payment by just selecting account group. Just select relevant account group in the right side window as depicted below. </p>
<p>Address, email and mobile number of the new vendor can also be supplied here itself. There are again two radio buttons to select receipt or payment mode and then enter amount, narration, date values to save a new transaction.</p>
<p align="center"; style="overflow:auto"><img src="images/cashbankreceipt.png"/><br />
</p>
<p>&nbsp;</p>
<p><a name="Companymaster" id="Companymaster2"><font size="+3"><b>Bank Receipt</b></font></a></p>
<p align="center"; style="overflow:auto"><img src="images/bankreceipt.png" /></p>
<p>Similar to cash receipts, there is bank receipt form. All bank transactions need to be entered in this form. Only difference is here check no, check date, bank account, client's bank name are extra fields which need to be entered. Rest of the fields are same</p>
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