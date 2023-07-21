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
 
<div style="margin-left:20px; margin-right:20px"; align="justify">
<br><br>
<a name="CreatingNewSystem"><font size="+3"><b>Creating a New System</b></font></a>
<br><br>
<font size="+2"><b>Running the Database</b></font>
<br><br>
The system has critical data already entered so that the features of the system can be explored without creating data from scratch. There is certain base Data that determines how the system works. This base information is defined from the System Setup tab of the main menu. <br>
<br>

<!-- Help Begin: CompanyPreferences -->

<font size="+2"><b>Setting Up A System</b></font>
<br><br>
<font size="+2"><b>The Chart Of Accounts</b></font>
<br><br>
A default chart of accounts is set completely for use from day one. Chart of accounts maintenance - deletion of accounts and adding of new accounts is done from the Accounts  menu tab (left menu) and then click Gl Accounts link. This would be a starting point for data input. Where the GL integration features are to be used, setting up the chart of accounts will be a necessary first step. Once a general ledger account has a posting to it then it will not be allowed to be deleted.
<br>
<br>
In the General Ledger there is a hierarchy of Account Section > Account Group > GL Account. General ledger accounts - the chart of accounts, Account Groups and Account Sections can be added or modified from Accounts Master tab. You can't delete accounts with postings made to them.
<br>
<br>
<font size="+2"><b>Company Parameters</b></font>
<br><br>
Company parameters need to be set correctly from the company set up screen. Most of these parameters are self -explanatory and they are by default set so user does not have to set. Company name, company number, postal address, physical address etc. Also the default home currency of the business. If the default currency is not already set up, then from the main menu system set up tab, the link to the currency maintenance form allows new currencies to be defined and for default rates to be updated. There is a section to enter and store important phone numbers.
<br>
<br>
The company record also provides a convenient place to store default GL codes for:
<br><br>
<ul>
<li>Debtors Control GL Account:</li>
<li>Creditors Control GL Account:</li>
</ul>
<font size="+2"><b>System Configuration</b></font>
<br>
From the setup tab the main system configuration parameters can be set from the link "System Preferences". Narrative is shown alongside each parameter to give the user an idea of where the setting is used.
 
<br>
<br>
<font size="+1"><b>Reconciling the Debtors Ledger Control Account</b></font>
<br><br>
It is important to check that the balance on all customers accounts from the aged listing agrees to the control account in the old system, in both local and overseas currency. The balance in the general ledger (of all customer balances) would normally be entered as a manual journal, but the amount of this journal should agree to the amount as per the customer listing. Of course balances entered in different currencies will have a different local value depending upon the rate at which they were entered. There is a facility to value all the currency balances in local currency looking at the rate at which each transaction was entered. This is the script Z_CurrencyDebtorBalances.php. A similar facility is available for suppliers balances. A double check should be done account by account before going live. Once all customer accounts are reconciled and entered (and double checked) the General Ledger interface should be re-enabled from the Company preferences screen (System Setup Tab). The system will then maintain the control account in the general ledger which should always agree to the list of balances.
<br><br>
<font size="+1"><b>Bank Account Balances and Other General Ledger Balances</b></font>
<br><br>
General ledger is the accounting hub - and an understanding of the accounting concepts is important in grasping what needs to be done to setup Lawpract correctly. This document is not a text on general accounting but a brief introduction is necessary.
<br><br>
The general ledger like accounts receivable is made up of many accounts although unlike accounts receivable the balances are not related to how much customers owe you - they represent the amounts that the business has:
<br>
<UL>
<LI>in the bank</LI>
<LI>in total clients balances</LI>
<LI>had contributed to it as loans or sharecapital from investors</LI>
</UL>
When these accounts are all listed the report is called a <i>"Balance Sheet"</I> since the value of all of these items will be equal to the accumulated profits net of any drawings or dividends paid to the investors.
<br><br>
The general ledger also keeps track of how much is spent on expenses and is charged out to customers as sales - whether or not the amounts are actually paid to the supplier of the expense or the sale has been paid by the customer. It is really only interesting to look at these accounts over a period to see what the income and expenses of the business have been and produce the <i>"Profit and Loss Statement"</I>. However, in bringing a business on to LawPract it is the balances that collectively represent the total worth of the business (in historical terms) that are important to record - these are called balance sheet accounts (the expense and revenue accounts are called profit and loss accounts). 
<br>
<br>
<B>Double Entry Bookkeeping</B>
<br><br>
When the balance of every account in the general ledger is added together the net result should always be zero - that's because every entry into the general ledger is made up of two parts a <strong>debit (a positive amount</strong>) and a <strong>credit (a negative amount)</strong>. <br>
Literally every entry is recorded twice once with the account that increases and once with the account that is reduced. This is why when the debit balances are added together with the credit balances the result should always be zero. Historically when accountants checked their manual books to ensure that every entry was recorded correctly they listed all the balances and added them up on a report called a "Trial Balance" - to check that the general ledger did in fact balance. Today a trial balance off the computer is a list of all the general ledger balances - with a check total at the end to show that the computer has done its job recording journals correctly.
<br><br>
As a simple example consider a trial balance with the entries:
<br><br>
<TABLE>
<TR><TD>Account</TD><TD>Amount</TD></TR>
<TR><TD>Bank Account</TD><TD ALIGN=RIGHT>1,000.00</TD></TR>
<TR><TD>Debtors Control</TD><TD ALIGN=RIGHT>5,000.00</TD></TR>
<TR><TD>Creditors Control</TD><TD ALIGN=RIGHT>(2,000.00)</TD></TR>
<TR><TD>Motor Vehicles</TD><TD ALIGN=RIGHT>10,000.00</TD></TR>
<TR><TD>Loan</TD><TD ALIGN=RIGHT>(3,000.00)</TD></TR>
<TR><TD>Accum Profits</TD><TD ALIGN=RIGHT>(11,000.00)</TD></TR>
<TR><TD></TD><TD><HR></TD></TR>
<TR><TD>Check Total</TD><TD ALIGN=RIGHT>0.00</TD></TR>
<TR><TD></TD><TD><HR></TD></TR>
</TABLE>
 <br><br>     
The system stops the user from entering journals to general ledger accounts defined as bank accounts. The Bank Account must be defined as such first - from the setup tab - Bank Accounts.
<br><br>
However, under general ledger - Bank Account Receipts - it is possible to enter general ledger receipts - a button to enter "Bank Account" allows receipts to be entered without selecting a customer account. The analysis of the other side of the general ledger entries that make up the receipt can then be entered. This is how general ledger balances should be brought on. 
<br>
<br>
Create a general ledger receipt for 1,000.00 to make the opening bank account balance correct. When creating this receipt the user must select the general ledger accounts that the deposit represents you can enter as many general ledger accounts with different amounts against each.  However in the case of entering the opening balances the 1,000 deposit in our example is actually
<br>
<br>
<TABLE>
<TR><TD>Debtors Control</TD><TD ALIGN=RIGHT>5,000.00</TD></TR>
<TR><TD>Creditors Control</TD><TD ALIGN=RIGHT>(2,000.00)</TD></TR>
<TR><TD>Motor Vehicles</TD><TD ALIGN=RIGHT>10,000.00</TD></TR>
<TR><TD>Loan</TD><TD ALIGN=RIGHT>(3,000.00)</TD></TR>
<TR><TD>Accum Profits</TD><TD ALIGN=RIGHT>(11,000.00)</TD></TR>
<TR><TD></TD></TR>
<TR><TD>Total bank deposit</TD>
<TD ALIGN=RIGHT>1,000</TD>
</TR>
</TABLE>
<br>
So entering in the receipt the analysis as above - -5,000 Debtors control, 2,000 Creditors control, -10,000 Motor vehicles, 3,000 loan and 11,000 accumulated profits will agree then to the 1,000 received into the bank account. It is important to date the receipt in the month prior to when the new LawPract system will commence activity. In this way the brought forward balances for the new period will be correct.
<br>
<br>
Where there are several bank accounts each defined with different general ledger accounts, then a receipt should be entered to each bank account with a  balance (or a payment if the bank account is overdrawn) - these balances can be cleared through postings to a suspense account.
<br><br>
<font size="+1"><b>Finally</b></font>
<br><br>
Once all entries are made to reconcile the customers accounts with the general ledger debtors account the system should be backed up. 
<!-- Help End: BaseInformation -->
<br />
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