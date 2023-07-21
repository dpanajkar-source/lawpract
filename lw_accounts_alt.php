<?php	

$PageSecurity = 5;

include('includes/session.php');

?>
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

    <!-- flag icons -->
    <link rel="stylesheet" href="assets/icons/flags/flags.min.css" media="all">

    <!-- altair admin -->
    <link rel="stylesheet" href="assets/css/main.css" media="all">
    
      <!-- Live Search Styles -->
    <link rel="stylesheet" href="css/fontello.css">
    <link rel="stylesheet" href="css/animation.css">
    <!--[if IE 7]>
    <link rel="stylesheet" href="css/fontello-ie7.css">
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="css/ajaxlivesearch.min.css">

    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
    <![endif]-->

</head>
<body class=" sidebar_main_open sidebar_main_swipe">
     <?php include("header.php"); ?>
    <?php include("menu.php"); ?>
    
    
    
    <div id="page_content">
        <div id="page_content_inner">
    <!-- new table for report options ------------------------------------------------------------------>
         
         <!-- for movement 
         <div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-medium uk-sortable sortable-handler hierarchical_show" data-uk-sortable data-uk-grid-margin>-->
         
          <!-- fisrt set start -->
            <div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-medium uk-sortable sortable-handler hierarchical_show" data-uk-grid-margin>
            
            
                <div>
                    <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <i class="material-icons md-color-red-600" style="font-size:48px;cursor: pointer; vertical-align:middle">receipt</i><span class="uk-text-muted uk-text-large" style="text-decoration:underline"><b><a href="lw_economy_alt.php" style="color:#000000" target="_blank" ></span>Cash Receipt</b></a>
                            
                        </div>
                    </div>
                </div>
         
            
          <div>
                   <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
<div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
   <i class="material-icons md-color-blue-600" style="font-size:48px;cursor: pointer; vertical-align:middle">credit_card</i><span class="uk-text-muted uk-text-large" style="text-decoration:underline"><b><a href="lw_bankreceipt_alt.php" style="color:#000000" target="_blank" ></span>Bank Receipt</b></a>
                          
                        </div>
                    </div>
                </div>
          
                <div>
                   <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <i class="material-icons md-color-green-600" style="font-size:48px;cursor: pointer; vertical-align:middle">assignment</i> <span class="uk-text-muted uk-text-large" style="text-decoration:underline"><b><a href="lw_accountsentries.php" style="color:#000000" target="_blank" ></span>Accounts Entries</b></a>
                        </div>
                    </div>
                </div>
                
                <div>
                   <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <i class="material-icons md-color-yellow-600" style="font-size:48px;cursor: pointer; vertical-align:middle">chrome_reader_mode</i><span class="uk-text-muted uk-text-large" style="text-decoration:underline"><b><a href="lw_gljournal.php" style="color:#000000" target="_blank"></span>GL Journal</b></a>
                          </h2>
                        </div>
                    </div>
                </div>
            </div>    
          <!--first set end-->
                
         <!---second set start -->
         
         <div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-medium uk-sortable sortable-handler hierarchical_show" data-uk-grid-margin>
                <div>
                    <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                           <i class="material-icons md-color-red-600" style="font-size:48px;cursor: pointer; vertical-align:middle">dns</i> <span class="uk-text-muted uk-text-large" style="text-decoration:underline"><b><a href="lw_selectcustomer_alt.php" style="color:#000000" target="_blank" ></span>Customer Ledger</b></a>
                            
                        </div>
                    </div>
                </div>
         	
          <div>
                   <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <i class="material-icons md-color-blue-600" style="font-size:48px;cursor: pointer; vertical-align:middle">swap_vertical_circle</i><span class="uk-text-muted uk-text-large" style="text-decoration:underline"><b><a href="lw_selectsupplier_alt.php" style="color:#000000" target="_blank" ></span>Supplier Ledger</b></a>
                          </h2>
                        </div>
                    </div>
                </div>
          
                <div>
                   <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <i class="material-icons md-color-green-600" style="font-size:48px;cursor: pointer; vertical-align:middle">view_headline</i><span class="uk-text-muted uk-text-large" style="text-decoration:underline"><b><a href="lw_bankstatement_alt.php" style="color:#000000" target="_blank" ></span>Bank Statement</b></a>
                          </h2>
                        </div>
                    </div>
                </div>
                
                <div>
                   <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <i class="material-icons md-color-yellow-600" style="font-size:48px;cursor: pointer; vertical-align:middle">live_help</i><span class="uk-text-muted uk-text-large" style="text-decoration:underline"><b><a href="lw_glaccountinquiry_alt.php" style="color:#000000" target="_blank"></span>GL Account Enquiry</b></a>
                          </h2>
                        </div>
                    </div>
                </div>
           </div>    
              
            <!---second set end -->
            
            
            <!---third set start -->
            
             <div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-medium uk-sortable sortable-handler hierarchical_show" data-uk-grid-margin>
                <div>
                    <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <i class="material-icons md-color-red-600" style="font-size:48px;cursor: pointer; vertical-align:middle">view_day</i><span class="uk-text-muted uk-text-large" style="text-decoration:underline"><b><a href="lw_bankreconciliation_alt.php" style="color:#000000" target="_blank"></span>Bank Reconciliation</b></a>
                            
                        </div>
                    </div>
                </div>
         	
          <div>
                   <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <i class="material-icons md-color-blue-600" style="font-size:48px;cursor: pointer; vertical-align:middle">view_column</i><span class="uk-text-muted uk-text-large" style="text-decoration:underline" ><b><a href="lw_trialbalance_alt.php" style="color:#000000" target="_blank"></span>Trial Balance</b></a>
                          </h2>
                        </div>
                    </div>
                </div>
          
                <div>
                   <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                        <i class="material-icons md-color-green-600" style="font-size:48px;cursor: pointer; vertical-align:middle">thumbs_up_down</i>    <span class="uk-text-muted uk-text-large"><b><a href="lw_profitloss_alt.php" style="color:#000000" target="_blank">Profit &amp; Loss</b></span></a>
                          </h2>
                        </div>
                    </div>
                </div>
                
                <div>
                   <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <i class="material-icons md-color-yellow-600" style="font-size:48px;cursor: pointer; vertical-align:middle">compare</i><span class="uk-text-muted uk-text-large"><b><a href="lw_balancesheet_alt.php" style="color:#000000" target="_blank">Balance Sheet</b></span></a>
                          </h2>
                        </div>
                    </div>
                </div>
           </div>    
              
            <!---third set end -->
            
            
            <!---fourth set start -->
            
             <div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-medium uk-sortable sortable-handler hierarchical_show" data-uk-grid-margin>
                <div>
                    <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                  <i class="material-icons md-color-red-600" style="font-size:48px;cursor: pointer; vertical-align:middle">description</i>          <span class="uk-text-muted uk-text-large"><b><a href="lw_invoice_alt.php" style="color:#000000" target="_blank">Invoices</b></span></a>
                            
                        </div>
                    </div>
                </div>
         	
          <div>
                   <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                         <i class="material-icons md-color-blue-600" style="font-size:48px;cursor: pointer; vertical-align:middle">open_with</i>   <span class="uk-text-muted uk-text-large"><b><a href="lw_allocateinvoice.php" style="color:#000000" target="_blank">Allocate Invoices</b></span></a>
                          </h2>
                        </div>
                    </div>
                </div>
          
                <div>
                   <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                       <i class="material-icons md-color-green-600" style="font-size:48px;cursor: pointer; vertical-align:middle">subtitles</i>     <span class="uk-text-muted uk-text-large"><b><a href="lw_gltransgridnew_alt.php" style="color:#000000" target="_blank">GL Trans Grid</b></span></a>
                          </h2>
                        </div>
                    </div>
                </div>
                
                <div>
                   <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                           <i class="material-icons md-color-yellow-600" style="font-size:48px;cursor: pointer; vertical-align:middle">delete</i> <span class="uk-text-muted uk-text-large "><b><a href="lw_deletechartdetails_alt.php" style="color:#000000" target="_blank">Delete Chart Details</b></span></a>
                          </h2>
                        </div>
                    </div>
                </div>
           </div>    
              
            <!---fourth set end -->
            
            
            <!---fifth set start -->
            
             <div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-medium uk-sortable sortable-handler hierarchical_show" data-uk-grid-margin>
                <div>
                    <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                 <i class="material-icons md-color-red-600" style="font-size:48px;cursor: pointer; vertical-align:middle">supervisor_account</i>           <span class="uk-text-muted uk-text-large"><b><a href="lw_glaccounts_alt.php" style="color:#000000" target="_blank">GL Account</b></span></a>
                            
                        </div>
                    </div>
                </div>
         	
          <div>
                   <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                   <i class="material-icons md-color-blue-600" style="font-size:48px;cursor: pointer; vertical-align:middle">account_balance</i>         <span class="uk-text-muted uk-text-large"><b><a href="lw_bankaccounts_alt.php" style="color:#000000" target="_blank">Bank Account</b></span></a>
                          </h2>
                        </div>
                    </div>
                </div>
          
                <div>
                   <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
             <i class="material-icons md-color-green-600" style="font-size:48px;cursor: pointer; vertical-align:middle">swap_horiz</i>               <span class="uk-text-muted uk-text-large"><b><a href="lw_contraentry.php" style="color:#000000" target="_blank">Contra Entry</b></span></a>
                          </h2>
                        </div>
                    </div>
                </div>
                <div>
                   <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                       <i class="material-icons md-color-yellow-600" style="font-size:48px;cursor: pointer; vertical-align:middle">border_all</i     ><span class="uk-text-muted uk-text-large"><b><a href="lw_accountsection_alt.php" style="color:#000000" target="_blank">Accounts Section</b>></span></a>
                          </h2>
                        </div>
                    </div>
                </div>
                
           </div>    
              
            <!---fifth set end -->
              <!---Six set start -->
        
             <div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-medium uk-sortable sortable-handler hierarchical_show" data-uk-grid-margin>
                <div>
                    <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                       <i class="material-icons md-color-red-600" style="font-size:48px;cursor: pointer; vertical-align:middle">account_balance_wallet</i>     <span class="uk-text-muted uk-text-large"><b><a href="lw_accountsgroups_alt.php" style="color:#000000" target="_blank">Accounts Groups</b></span></a>
                            
                        </div>
                    </div>
                </div>
         	
          <div>
                   <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                    <i class="material-icons md-color-blue-600" style="font-size:48px;cursor: pointer; vertical-align:middle">attach_money</i>        <span class="uk-text-muted uk-text-large"><b><a href="lw_currencies_alt.php" style="color:#000000" target="_blank">Currencies</b></span></a>
                          </h2>
                        </div>
                    </div>
                </div>
         
               
                
           </div>   
               <!---Six set ends -->
           
           
              <!---old table
            <div class="md-card ">
                <div class="md-card-content">
                
		           <div class="uk-overflow-container">
                        <table class="uk-table uk-table-condensed">
                                              
                    <tr>
                    <td><a href="lw_economy_alt.php" target="_blank">Cash Receipts</a></td>
                    <td><a href="lw_bankreceipt_alt.php" target="_blank">Bank Receipts</a></td>
                    <td><a href="lw_accountsentries.php" target="_blank">Accounts Entries</a></td>
                    <td><a href="lw_gljournal.php" target="_blank">GL Journal</a></td>
                    </tr>
                     
                    <tr>
                    <td><a href="lw_selectcustomer_alt.php" target="_blank">Customer Ledger</a></td>
                    <td><a href="lw_selectsupplier_alt.php" target="_blank">Supplier Ledger</a></td>
                    <td><a href="lw_bankstatement_alt.php" target="_blank">Bank Statement</a></td>
                    <td><a href="lw_glaccountinquiry_alt.php" target="_blank">GL Account Enquiry</a></td>
                    </tr>
                    
                    <tr>
                    <td><a href="lw_bankreconciliation_alt.php" target="_blank">Bank Reconciliation</a></td>
                    <td><a href="lw_trialbalance_alt.php" target="_blank">Trial Balance</a></td>
                    <td><a href="lw_profitloss_alt.php" target="_blank">Profit &amp; Loss</a></td>
                    <td><a href="lw_balancesheet_alt.php" target="_blank">Balance Sheet</a></td>
                  
                    </tr> 
                    <tr>   
                      <td><a href="lw_invoice_alt.php" target="_blank">Invoices</a></td>
                    <td><a href="lw_allocateinvoice.php" target="_blank">Allocate Invoices</a></td>                             
                       <td><a href="lw_gltransgrid_alt.php" target="_blank">GL Trans Grid</a></td>
                    <td><a href="lw_deletechartdetails_alt.php" target="_blank">Delete Chart Details</a></td>
                    

                    </tr> 
                    
                      <tr>   
                      <td><a href="lw_glaccounts_alt.php" target="_blank">GL Account</a></td>
                    <td><a href="lw_bankaccounts_alt.php" target="_blank">Bank Account</a></td>                             
                       <td><a href="lw_contraentry.php" target="_blank">Contra Entry Voucher</a></td>
                    

                    </tr> 
                   
                    </table>
                    
                  </div>
                </div>
            </div><!-- Table ends -->
            
            
                        
<?php include('footersrc.php');    ?>
</body>
</html>