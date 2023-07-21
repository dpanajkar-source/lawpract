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
       
<a name="GeneralLedger"><font size="+3"><b>General Ledger</b></font></a>
<br>
<font size="+2"><b>Overview</b></font>
<br><br>
The general ledger is the accounting hub that is central to the "sub" ledgers for suppliers (Accounts Payable), debtors or clients(Accounts Receivable). All entries in the sub ledgers are also represented by entries in the general ledger. It is the integration set-up that determines how entries in the sub-ledgers are reflected in the general ledger. Most activity in the general ledger will be automatically created from the activity in the sub-ledgers with receivables, payables.
<br><br>
However, there are also facilities to:
<br><br>
<ul>
<li>Enter general ledger receipts against a pre-defined bank accounts.
<li>Enter general ledger payments against pre-defined bank accounts.
<li>Enter general ledger journals between any general ledger accounts - except bank accounts. These can also be made to reverse automatically in the following period. Further journals can be posted to any period future or previously - the period is determined by reference to the date entered.
<li>Inquire on general ledger account activity and from any entry in this inquiry drill down to the journals created to produce the entry.
<li>Inquire on the general ledger trial balance for any period end in history or currently.
</ul>

<p>
  <!-- Help Begin: AccountGroups -->
  
  <font size="+2"><b>Account Groups</b></font>
  <br>
  <br>
  The account group is the parent object of a general ledger account. Child accounts created inherit the properties of the account group - ie the account will be a profit and loss account if it belongs to an account group that is a balance sheet account, the child accounts will display in the trial balance (TB) together in the sequence determined by the account groups sequence in the trial balance (TB).
  <br>
  <br>
  Account groups require the sequence in the trial balance to be specified and also whether the accounts in that group will be profit and loss accounts or balance sheet accounts. <br>
  <br>
  <!-- Help Begin: BankAccounts -->
  
  <font size="+2"><b>Bank Accounts</b></font>
  <br>
  <br>
  Certain general ledger accounts can be defined as bank accounts - as many bank accounts as needed can be defined. At the time of defining a general ledger account as bank account the currency of the bank account must also be specified. General ledger accounts defined as bank accounts can be reconciled to bank statements using the matching facilities - all receipts and payments show in the currency of the bank account for easy matching off statments. Entries made to bank accounts using receipts or payments, also create a total receipt or payment, which is retained for the purposes of matching off the bank statements. Using the bank payments page, general ledger payments can be analysed to any number of other general ledger accounts, but only one entry to the bank account is made. This page also allows payments to supplier accounts to be created. Similarly, using the receipt entry page, a series of receipts from customers which may all have been banked together can be deposited as one amount to a bank account. There is only one amount appearing on the statement as the total of all these receipts, this bank account transaction is created and available for matching deposits off the bank statements. <br>
  <br>
  Bank accounts are defined from the Accounts tab from the link to Bank Accounts. There is facility to enter the name of the account, the currency of the account, the bank account number and the address of the bank if required, as well as selecting the general ledger account to which it refers. There are links to edit existing bank account records and to delete them. However, once defined as referring to a particular general ledger code it is not possible to change the general ledger code of the bank account. This is because there would be entries made to this account. Similarly, if bank transactions have been created using this bank account it is not possible to delete it. The bank account transactions must be purged first (but currently no facility exists to purge bank transactions). It is not possible to change the currency of a bank account once there are transactions against it. <br>
  <br>
  Once all receipts and payments are matched to bank statements, the bank reconciliation statement can be printed which should show how the current general ledger balance reconciles to the bank statement for this account. The reconciliation also has an option available for bank accounts set up in other than the functional currency of the business (local currency), to post differences in exchange. The balance of the account is maintained in local currency in the general ledger and for the purposes of the bank reconciliation this is converted to the bank account currency at the exchange rate in the currencies table (see Setup -> Currency Maintenance) - this rate can be changed manually to the rate of the day and the foreign currency balance on the account will change - to correct this balance an exchange difference needs to be recorded. Having worked through the matching of receipts and payments to the bank statements - the bank statment balance can be entered to compare against the system balance - a correcting entry is then made to the GL to post the difference on exchange. The posting to the general ledger is back dated to the end of the preceeding month - since it is assumed that the reconciliation may be a few days or a week behind the current date.
  <!-- Help End: BankAccounts -->
  
  <br>
  <br>
  
  <!-- Help Begin: Payments -->
  
  <font size="+1"><b>Bank Account Payments</b></font>
  <br>
  <br>
  From the general ledger tab, the first link under transactions is Bank Account Payments. <br>
  <br>
  The following data is required: <br>
  <br>
</p>
<ul>
<li>The bank account from which the payment has been (or is to be) made. A select box allows this to be selected from the list of defined bank accounts.</li>
<li>The date on which it was paid. This is important since the accounting period in which the payment is entered is determined from the date. The system will default to today's date - this must be changed where bank payments are being entered retrospectively.</li>
<li>The currency which is being paid. Payment to suppliers may be made in foreign currency being purchased in the currency of the bank account at the exchange rate entered - see below.</li>
<li>The exchange rate - this is the exchange rate between the currency being paid and the currency of the bank account. If the currency being paid is the same as the currency of the bank account then this rate should be 1. If another currency is being purchased with the payment then the rate at which it is being purchased should be entered.</li>
<li>The functional exchange rate - this the exchange rate between the currency of the bank account and the functional currency of the business as defined in the company preferences (ie the reporting currency of the business). Where the bank account is in the same currency as the functional (reporting) currency of the business then this value should be 1. The functional currency entry will only be required when the bank account currency is different to the the functional currency and will default to 1 automatically if they are the same.</li>
<li>Narrative - applicable to the whole payment. Narrative applicable to individual general ledger entries can be entered separately.
</ul>
Payments can take two forms - either it is a general ledger payment or it is a payment to a supplier. General ledger payments require an analysis of how the payment should be posted to the general ledger. General ledger accounts can be specified either as the account code directly (if the account code is known) or by selecting from the select box. Any narrative applicable to the general ledger amount can be entered too - and the amount to be posted to the selected/entered account. The total payment is taken as being the sum of all the entries made. If the total of all entries made is negative then this is entered as a negative payment - these are accepted to allow for correction of data entry errors. Payments are always entered in the curreny of the payment - the conversions are handled by the system for general ledger postings etc.

<!-- Help End: Payments -->

<br><br>
<font size="+2"><b>General Ledger Integration Setup</b></font>
<br><br>
Bank Accounts are automatically integrated with the general ledger and cannot exist separately without the GL being used. 
Every transaction is recorded in two places (double entry) eg. A bank account payment reflects in the bank account and also in the expense account that is was paid for - eg. stationery, fuel, entertaining, advertising or whatever. One entry goes as a debit on the left and the other as a credit on the right - when you look at the trial balance the debits should tie up with the credits ie the trial balance - a list of the general ledger balances should have balancing debit total and credit totals.
<br><br>
With respect to the clients (AR) and suuplier (AP) ledgers, general ledger postings can be turned off in the company preferences screen by setting each of the flags to No. 
<br><br>
<br>Integrated general ledger postings do provide a good way of building up the business's accounts from activity in these sub ledgers.
<br>
<br>You can choose between two levels of integration:
<br>
<br>1. Integrate GL at the debtors and sales level only
<br>
<br>This creates general ledger journals for each sale as follows: 
<br>
<br>DR the debtors control account - defined in the company preferences screen
<br>CR the sales account - defined with reference to the customer sales area, stock category of the item being sold and the sales type (price list) of the customer. This provides great flexibility as to how sales should be posted
<br>
CR the tax to the taxgl account defined in the tax authorities (ie the general ledger code of the tax authority of the customer branch).<br>
The reverse takes place for a credit note.
<br>
When cash is received:
<br>
CR the debtors control - defined in company preferences
DR the bank account - defined in the bank account setup.
<br>
There are also general ledger entries for discounts and differences on exchange which have been ignored for the purposes of this introduction.
<br>
This level of integration ensures that the list of balances of all customer accounts (in local currency) always ties up with the general ledger debtors control account.
<br>
<br>
The general ledger accounts that are used in this level of integration are determined from several inputs. 
<br><br>
<ul>
<li>Sales Area of the customer being invoiced/credited
<li>Sales Type (or price list) of the customer being invoiced/credited
</ul>
<br><br>
Since the logic of how the general ledger account is determined is defined in this function it is relatively simple to change this to what is most appropriate for the business.
<br><br>
The tax account used is the account defined in the tax authorities definition used for the customer being invoiced.






       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       
       

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