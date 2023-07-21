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
          
          
           <!-- new--->
            <div class="uk-grid" data-uk-grid-margin">
                <div class="uk-width-medium-2-4">
                <div class="md-card">
                        <div class="md-card-content">
                        <h4 class="heading_c uk-margin-bottom" align="center"><b>Banks</b></h4>
                        
                         <!-- new--->
                        
<div class="uk-grid uk-grid-width-large-1-3 uk-grid-width-medium-1-3 uk-grid-medium uk-sortable sortable-handler hierarchical_show" data-uk-grid-margin>

             <div>
                   <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <span class="uk-text-muted uk-text-large" style="text-decoration:underline"><b><a href="bf_inward_alt.php" style="color:#000000" target="_blank"><i class="material-icons md-color-yellow-900" style="font-size:48px;cursor: pointer; vertical-align:middle">assignment_turned_in</i></span><br>Inward</b></a>
                         
                        </div>
                    </div>
               
                 </div>
                 <div>
                    <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <span class="uk-text-muted uk-text-large" style="text-decoration:underline"><b><a href="bf_bankfinance_alt.php" style="color:#000000" target="_blank" ><i class="material-icons md-color-red-900" style="font-size:48px;cursor: pointer; vertical-align:middle">account_balance</i></span><br>Outward</b></a>
                            
                        </div>
                    </div>
                </div>
              
                
            <div>
                   <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <span class="uk-text-muted uk-text-large" style="text-decoration:underline"><b><a href="bf_viewbill_alt.php" style="color:#000000" target="_blank" ><i class="material-icons md-color-blue-900" style="font-size:48px;cursor: pointer; vertical-align:middle">print</i></span>View/Print Bills</b></a>
                          </h2>
                        </div>
                    </div>
                </div>
  
  <!-- <div>
                   <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <span class="uk-text-muted uk-text-large" style="text-decoration:underline"><b><a href="bf_bankfinance_individual_alt.php" style="color:#000000" target="_blank" ><i class="material-icons md-color-green-900" style="font-size:48px;cursor: pointer; vertical-align:middle">view_headline</i></span>Individual Trans (Kachhi Receipt)</b></a>
                          </h2>
                        </div>
                    </div>
                </div>    -->               
         
     
               
              </div>  </div> </div></div>
              


 <!-- new --------------------------------------------------------------------------------->
 <div class="uk-width-medium-1-4">
                <div class="md-card">
                        <div class="md-card-content">
                        <h4 class="heading_c uk-margin-bottom" align="center"><b>Enter Receipts</b></h4>
                        
                         <!-- new--->
                        
<div class="uk-grid uk-grid-width-large-1-2 uk-grid-width-medium-1-2 uk-grid-medium uk-sortable sortable-handler hierarchical_show" data-uk-grid-margin>

 <div>
                    <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <i class="material-icons md-color-red-600" style="font-size:48px;cursor: pointer; vertical-align:middle">receipt</i><span class="uk-text-muted uk-text-large" style="text-decoration:underline"><b><a href="bf_economy_alt.php" style="color:#000000" target="_blank" ></span><br>Cash Receipts</b></a>
                          
                        </div>
                    </div>
                    
                </div>
         
            
          <div>
                   <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
   <i class="material-icons md-color-blue-600" style="font-size:48px;cursor: pointer; vertical-align:middle">credit_card</i><span class="uk-text-muted uk-text-large" style="text-decoration:underline"><b><a href="bf_bankreceipt_alt.php" style="color:#000000" target="_blank" ></span><br>Bank Receipts</b></a>
                          
                        </div>
                    </div>
                </div>     

</div>  </div> </div></div>

 <!-- new --------------------------------------------------------------------------------->
           
         <div class="uk-width-medium-1-4">
           <div class="md-card">
            <div class="md-card-content">
                       <h4 class="heading_c uk-margin-bottom" align="center"><b>Bank Accounts Setting</b></h4>  <!-- new--->
             <div class="uk-grid uk-grid-width-large-1-2 uk-grid-width-medium-1-2 uk-grid-medium uk-sortable sortable-handler hierarchical_show" data-uk-grid-margin>  
               
                <div>
                   <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <span class="uk-text-muted uk-text-large" style="text-decoration:underline"><b><a href="bf_bankform_grid.php" style="color:#000000" target="_blank" ><i class="material-icons md-color-red-900" style="font-size:48px;cursor: pointer; vertical-align:middle">dns</i></span><br>Banks</b></a>
                            
                        </div>
                    </div>
                </div> 
                
          <div>
                     <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
   <span class="uk-text-muted uk-text-large" style="text-decoration:underline"><b><a href="bf_branchform_grid.php" style="color:#000000" target="_blank" ><i class="material-icons md-color-blue-900" style="font-size:48px;cursor: pointer; vertical-align:middle">credit_card</i></span>Branches</b></a>
                          
                        </div>
                    </div>
                </div>
             
                
             
            
                
                
          <!-- new--->
           </div>
           </div>
           </div>
          	</div>
         	</div>
          
           <!-- new line--->
          
          

  
 
          

    
         
          
             
      
              
                  <!---first set end --> 
              
            
              
  <!-- new --------------------------------------------------------------------------------->

     <div class="uk-grid" data-uk-grid-margin"> 
         <div class="uk-width-medium-1-4">
                <div class="md-card">
                        <div class="md-card-content">
                        <h4 class="heading_c uk-margin-bottom" align="center"><b>Individuals</b></h4>
                        
                         <!-- new--->
                        
            <div class="uk-grid uk-grid-width-large-1-1 uk-grid-width-medium-1-1 uk-grid-medium uk-sortable sortable-handler hierarchical_show" data-uk-grid-margin>
             <div>
                   <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <span class="uk-text-muted uk-text-medium" style="text-decoration:underline"><b><a href="bf_bankfinance_individual_alt.php" style="color:#000000" target="_blank" ><i class="material-icons md-color-green-900" style="font-size:48px;cursor: pointer; vertical-align:middle">view_headline</i></span>Individual Trans</b></a>
                          </h2>
                        </div>
                    </div>
			  </div>   
  
 
  </div> </div></div></div>        
              
              
       <!---second set end -->
   
              
     
 <!-- new --------------------------------------------------------------------------------->
           
    
     <div class="uk-width-medium-1-4">
           <div class="md-card">
            <div class="md-card-content">
             <h4 class="heading_c uk-margin-bottom" align="center"><b>Stages and Address Book</b></h4>  <!-- new--->
             <div class="uk-grid uk-grid-width-large-1-2 uk-grid-width-medium-1-2 uk-grid-medium uk-sortable sortable-handler hierarchical_show" data-uk-grid-margin>  
         
         <div>
              <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                             <span class="uk-text-muted uk-text-large" style="text-decoration:underline"><b><a href="bf_stage_grid.php" style="color:#000000" target="_blank" ><i class="material-icons md-color-puple-900" style="font-size:48px;cursor: pointer; vertical-align:middle">assignment</i></span><br>Stages</b></a>
                        </div>
                    </div>
                </div>
                
                <div>
                   <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <span class="uk-text-muted uk-text-large" style="text-decoration:underline"><b><a href="bf_bankclients_grid.php" style="color:#000000" target="_blank"><i class="material-icons md-color-yellow-300" style="font-size:48px;cursor: pointer; vertical-align:middle">dns</i></span>Contacts</b></a>
                          </h2>
                        </div>
                    </div>
                </div>            
            
                
                
          <!-- new--->
          
           </div>
           </div>
           </div>
        </div>
        
        
        
      <!-- new --------------------------------------------------------------------------------->
 
         <div class="uk-width-medium-1-4">
                <div class="md-card">
                        <div class="md-card-content">
                        <h4 class="heading_c uk-margin-bottom" align="center"><b>File Upload</b></h4>
                        
                         <!-- new--->
                        
<div class="uk-grid uk-grid-width-large-1-1 uk-grid-width-medium-1-1 uk-grid-medium uk-sortable sortable-handler hierarchical_show" data-uk-grid-margin>
                 <div>
                   <div class="md-card">
                        <div class="md-card-content" style="cursor: pointer">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"></div>
                            <span class="uk-text-muted uk-text-medium" style="text-decoration:underline"><b><a href="bf_filesattach_alt.php" style="color:#000000" target="_blank" ><i class="material-icons md-color-green-900" style="font-size:48px;cursor: pointer; vertical-align:middle">view_headline</i></span>Select File</b></a>
                          </h2>
                        </div>
                    </div>
                </div>     

 
</div>  </div> </div>  </div>

    <!-- new------------------------------------------------------------->

            <div class="uk-width-medium-1-4">
                <div class="md-card">
                        <div class="md-card-content">
                        <h4 class="heading_c uk-margin-bottom" align="center"><b>Reports</b></h4>
                        
                         <!-- new--->
                         
		<div class="uk-grid uk-grid-width-large-1-3 uk-grid-width-medium-1-3 uk-grid-medium uk-sortable sortable-handler hierarchical_show" data-uk-grid-margin>

             
              <div>
               <div class="md-card">
          <span class="uk-text-muted uk-text-mediam"><b><a href="bf_new_PDFpendinginward.php"  target="_blank">Pending Files</b></span></a>
                 </div>
               </div> 
               
              <div>
               <div class="md-card">
          <span class="uk-text-muted uk-text-mediam"><b><a href="bf_new_PDFPartyDuesList.php"  target="_blank">Client Dues Report</b></span></a>
                 </div>
               </div>  
               
               <div>
               <div class="md-card">
          <span class="uk-text-muted uk-text-mediam"><b><a href="bf_new_PDFBankDuesList.php"  target="_blank">Bank Dues Report</b></span></a>
                 </div>
               </div>  
               
              </div>  </div> </div></div>
</div>
       
                        
<?php include('footersrc.php');    ?>
</body>
</html>