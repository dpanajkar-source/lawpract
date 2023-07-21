 <?php
 $PageSecurity = 2;

include('includes/session.php');

$title=_('Home');
				
 
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

    <!-- additional styles for plugins -->
    
        <!-- chartist -->
        <link rel="stylesheet" href="bower_components/chartist/dist/chartist.min.css">
    
    <!-- uikit -->
    <link rel="stylesheet" href="bower_components/uikit/css/uikit.almost-flat.min.css" media="all">

    <!-- flag icons -->
    <link rel="stylesheet" href="assets/icons/flags/flags.min.css" media="all">

    <!-- altair admin -->
    <link rel="stylesheet" href="assets/css/main.css" media="all">

    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
    <![endif]-->
    
     <link rel="stylesheet" type="text/css" href="css/ajaxlivesearch.min.css">

</head>
<body class=" sidebar_main_open sidebar_main_swipe">

    <?php include("header.php"); 
    include("menu.php"); 	
	?>

    <div id="page_content">
        <div id="page_content_inner">
           <div class="md-card" style="height:130px; margin-top:-10px" >
             <div class="md-card-content">                 
                    <table class="uk-table"  style="margin-top:-20px" >
                      <tr>
                        <td style="text-align:justify"><img src="greenbtn.png">  Green bullet means the form is <b>PRE-FILLED</b> with some data to use. The user can start using the form or grid. Please click the appropriate links to directly visit the required form or grid</td>
                        <td style="text-align:justify"><img src="redbtn.png">  Red bullet indicates the form or grid is <b>FULLY EMPTY</b>. LAWPRACT strongly recommends the USER to start filling data whereever the user finds a red bullet starting from <b>STEP 1</b></td>
                      </tr>
                      <tr>
                        <td colspan="2" style="text-align:justify"> This system comprises of 15 easy steps for the user to start using the software and quickly adopt it. wherever possible we have included images to help identify the locations of MENU items. The System is very flexible in the sense one can go to any step and use it</td>
                      </tr>
                    </table>
             </div>
           </div>
        

            <!-- statistics (small charts) -->
            <div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-medium hierarchical_show"  data-uk-grid-margin>
                
                <div>
                    <div class="md-card" style="width:250px">
                        <div class="md-card-content">
                        <h3>STEP 1</h3>
                         <b>Start here with System Setup</b>
                           <table>
                           <tr>
                           <td width="30">
                            <img src="greenbtn.png"></td>
                           <td width="220">
                            <a href="lw_companymaster.php" target="_blank"> <span class="uk-text-muted uk-text-small">Company Master</span></a></td>
                            </tr>
                           <tr><td width="30">
                            <img src="greenbtn.png"></td>
                            <td width="220"><a href="lw_systemsettings.php"> <span class="uk-text-muted uk-text-small">System Preferences</span></a></td>									
                            </tr>
                           <tr><td width="30">
                           <?php
						    $sql = "SELECT COUNT(*) as recordcount FROM www_users";
						    echo emptyfilled($sql);						
						   
						   ?>
                            </td>
                            <td width="220"><a href="lw_users_alt.php"> <span class="uk-text-muted uk-text-small">Users</span></a></td></tr>
                            <tr><td width="30">
                            <?php
						    $sql = "SELECT COUNT(*) as recordcount FROM securityroles";
						    echo emptyfilled($sql);						
						   
						   ?></td>
                            <td width="220"><a href="lw_access_alt.php"> <span class="uk-text-muted uk-text-small">Roles</span></a></td></tr>
                           </table>
                      </div>
                    </div>
                </div>
                
               <div>
                    <div class="md-card" style="width:250px">
                        <div class="md-card-content">
                        <h3>STEP 2</h3>
                          <b>Accounts Master Forms</b>
                           <table>
                           <tr>
                           <td width="30">
                            <?php
						    $sql = "SELECT COUNT(*) as recordcount FROM accountsection";
						    echo emptyfilled($sql);						
						   
						   ?></td>
                           <td width="220">
                            <a href="lw_accountsection_alt.php" target="_blank"> <span class="uk-text-muted uk-text-small">Accounts Section</span></a></td>
                            </tr>
                           <tr><td width="30">
                            <?php
						    $sql = "SELECT COUNT(*) as recordcount FROM accountgroups";
						    echo emptyfilled($sql);						
						   
						   ?></td>
                            <td width="220"><a href="lw_accountsgroups_alt.php"> <span class="uk-text-muted uk-text-small">Accounts Groups</span></a></td>									
                            </tr>
                           <tr><td width="30">
                            <?php
						    $sql = "SELECT COUNT(*) as recordcount FROM chartmaster";
						    echo emptyfilled($sql);						
						   
						   ?></td>
                            <td width="220"><a href="lw_glaccounts_alt.php"> <span class="uk-text-muted uk-text-small">GL Accounts</span></a></td></tr>
                            <tr><td width="30">
                            <?php
						    $sql = "SELECT COUNT(*) as recordcount FROM bankaccounts";
						    echo emptyfilled($sql);						
						   
						   ?></td>
                            <td width="220"><a href="lw_bankaccounts_alt.php"> <span class="uk-text-muted uk-text-small">Bank Accounts</span></a></td></tr>
                            <tr><td width="30">
                           <?php
						    $sql = "SELECT COUNT(*) as recordcount FROM currencies";
						    echo emptyfilled($sql);						
						   
						   ?></td>
                            <td width="220"><a href="lw_currencies_alt.php"> <span class="uk-text-muted uk-text-small">Currencies</span></a></td></tr>
                           </table>
                      </div>
                    </div>
                </div>
                
             <div>
                    <div class="md-card" style="width:250px">
                        <div class="md-card-content">
                        <h3>STEP 3</h3>
                        <b>Case Master forms</b>
                           <table>
                           <tr>
                           <td width="30">
                            <?php
						    $sql = "SELECT COUNT(*) as recordcount FROM lw_casecat";
						    echo emptyfilled($sql);						
						   
						   ?></td>
                           <td width="220">
                            <a href="lw_casecat_grid.php" target="_blank"> <span class="uk-text-muted uk-text-small">Case Categories</span></a></td>
                            </tr>
                           <tr><td width="30">
                            <?php
						    $sql = "SELECT COUNT(*) as recordcount FROM lw_clientcat";
						    echo emptyfilled($sql);						
						   
						   ?></td>
                            <td width="220"><a href="lw_partycat_grid.php"> <span class="uk-text-muted uk-text-small">Party Categories</span></a></td>									
                            </tr>
                           <tr><td width="30">
                            <?php
						    $sql = "SELECT COUNT(*) as recordcount FROM lw_partiesinvolved";
						    echo emptyfilled($sql);						
						   
						   ?></td>
                            <td width="220"><a href="lw_partyroles_grid.php"> <span class="uk-text-muted uk-text-small">Party Roles</span></a></td></tr>
                            <tr><td width="30">
                            <?php
						    $sql = "SELECT COUNT(*) as recordcount FROM lw_courts";
						    echo emptyfilled($sql);						
						   
						   ?></td>
                            <td width="220"><a href="lw_court_grid.php"> <span class="uk-text-muted uk-text-small">Courts</span></a></td></tr>
                            <tr><td width="30">
                            <?php
						    $sql = "SELECT COUNT(*) as recordcount FROM lw_stages";
						    echo emptyfilled($sql);						
						   
						   ?></td>
                            <td width="220"><a href="lw_stage_grid.php"> <span class="uk-text-muted uk-text-small">Stages</span></a></td></tr>
                           </table>
                      </div>
                    </div>
                </div>
                
                <div>
                    <div class="md-card" style="width:250px">
                        <div class="md-card-content">
                        <h3>STEP 4</h3>
                        <b>Miscellaneous Entries</b>
                           <table>
                           <tr>
                           <td width="30">
                            <?php
						    $sql = "SELECT COUNT(*) as recordcount FROM lw_contacts";
						    echo emptyfilled($sql);						
						   
						   ?></td>
                           <td width="220">
                            <a href="lw_addressbook_alt.php" target="_blank"> <span class="uk-text-muted uk-text-small">Address Book</span></a></td>
                            </tr>
                             <tr>
                           <td width="30">
                            <img src="greenbtn.png"></td>
                           <td width="220">
                            <a href="lw_acts_alt.php" target="_blank"> <span class="uk-text-muted uk-text-small">ACTS- PDF downloads available</span></a></td>
                            </tr>
                             <tr>
                           <td width="30">
                            <img src="greenbtn.png"></td>
                           <td width="220">
                            <a href="lw_deeds_alt.php" target="_blank"> <span class="uk-text-muted uk-text-small">Deeds & Docs</span></a></td>
                            </tr>
                            <tr>
                           <td width="30">
                           <?php
						    $sql = "SELECT COUNT(*) as recordcount FROM lw_alerts";
						    echo emptyfilled($sql);						
						   
						   ?></td>
                           <td width="220">
                            <a href="lw_page_alerts.php" target="_blank"> <span class="uk-text-muted uk-text-small">Manage Alerts</span></a></td>
                            </tr>
                             <tr>
                           <td width="30">
                            <?php
						    $sql = "SELECT COUNT(*) as recordcount FROM lw_messages";
						    echo emptyfilled($sql);						
						   
						   ?></td>
                           <td width="220">
                            <a href="lw_page_messages.php" target="_blank"> <span class="uk-text-muted uk-text-small">Manage Messages</span></a></td>
                            </tr>
                           </table>
                      </div>
                    </div>
                </div>
                
                </div>
       
                        
                    
<div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-medium hierarchical_show"  data-uk-grid-margin>
    
             	 <div>
              		<div class="md-card" style="width:250px">
                    	<div class="md-card-content">
                        	<h3>STEP 5</h3>
                        	<b>Case Entries</b>
                           <table>
                          	<tr><td width="30">
                            <?php
						    $sql = "SELECT COUNT(*) as recordcount FROM lw_cases";
						    echo emptyfilled($sql);						
						   
						   ?></td>
                            <td width="220"><a href="lw_casenew_alt.php"> <span class="uk-text-muted uk-text-small">Case/Matter Entry-Notice No Creation</span></a></td>									
                            </tr>
                            
                           
                          	<tr><td width="30">
                            <?php
						    $sql = "SELECT COUNT(*) as recordcount FROM lw_cases";
						    echo emptyfilled($sql);						
						   
						   ?></td>
                            <td width="220"><a href="lw_casegrid_alt.php"> <span class="uk-text-muted uk-text-small">Cases Grid</span></a></td>									
                            </tr>
                       	   </table>
                      </div>
                    </div>
                </div>
                
    
      			 <div>
              		<div class="md-card" style="width:250px">
                    	<div class="md-card-content">
                        	<h3>STEP 6</h3>
                        	<b>Notice Details</b>
                           <table>
                          	<tr><td width="30">
                            <?php
						    $sql = "SELECT COUNT(*) as recordcount FROM lw_notices";
						    echo emptyfilled($sql);						
						   
						   ?></td>
                            <td width="220"><a href="lw_notices_alt.php"> <span class="uk-text-muted uk-text-small">Enter Notice Details</span></a></td>									
                            </tr>
                       	   </table>
                      </div>
                    </div>
                </div>
    
               <div>
              		<div class="md-card" style="width:250px">
                    	<div class="md-card-content">
                        	<h3>STEP 7</h3>
                        	<b>Daily Diary *</b>
                           <table> 
                          	<tr><td width="30">
                            <?php
						    $sql = "SELECT COUNT(*) as recordcount FROM lw_trans";
						    echo emptyfilled($sql);						
						   
						   ?></td>
                            <td width="220"><a href="lw_diary_grid.php"> <span class="uk-text-muted uk-text-small">Diary Entry</span></a></td>									
                            </tr>
                       	   </table>
                      </div>
                    </div>
                </div>
   				 <div>
              		<div class="md-card" style="width:250px">
                    	<div class="md-card-content">
                        	<h3>STEP 8</h3>
                        	<b>Files Upload</b>
                           <table>
                          	<tr><td width="30">
                            <?php
						    $sql = "SELECT COUNT(*) as recordcount FROM lw_filesattached";
						    echo emptyfilled($sql);						
						   
						   ?></td>
                            <td width="220"><a href="lw_filesattach_alt.php"> <span class="uk-text-muted uk-text-small">Upload Any File for Briefs</span></a></td>									
                            </tr>
                       	   </table>
                      </div>
                    </div>
                </div>
                            
     </div>
                      
 <div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-medium hierarchical_show"  data-uk-grid-margin>
                 <div>
              		<div class="md-card" style="width:250px">
                    	<div class="md-card-content">
                        	<h3>STEP 9</h3>
                        	<b>Accounts</b>
                           <table>
                          	<tr><td width="30">
                            <?php
						    $sql = "SELECT COUNT(*) as recordcount FROM lw_partyeconomy";
						    echo emptyfilled($sql);						
						   
						   ?></td>
                            <td width="220"><a href="lw_economy_alt.php"> <span class="uk-text-muted uk-text-small">Cash Receipts</span></a></td>									
                            </tr>
                            <tr><td width="30">
                            <?php
						    $sql = "SELECT COUNT(*) as recordcount FROM banktrans";
						    echo emptyfilled($sql);						
						   
						   ?></td>
                            <td width="220"><a href="lw_bankreceipt_alt.php"> <span class="uk-text-muted uk-text-small">Bank Receipts</span></a></td>									
                            </tr>
                           <tr><td width="30">
                            <?php
						    $sql = "SELECT COUNT(*) as recordcount FROM gltrans";
						    echo emptyfilled($sql);						
						   
						   ?></td>
                            <td width="220"><a href="lw_gljournal.php"> <span class="uk-text-muted uk-text-small">GL Journal</span></a></td></tr>
                            
                       	   </table>
                      </div>
                    </div>
                </div>
               
                 <div>
              		<div class="md-card" style="width:250px">
                    	<div class="md-card-content">
                        	<h3>STEP 10</h3>
                        	<b>GL Enquiries </b>
                           <table>
                          	<tr><td width="30">
                            <?php
						    $sql = "SELECT COUNT(*) as recordcount FROM gltrans";
						    echo emptyfilled($sql);						
						   
						   ?></td>
                            <td width="220"><a href="lw_gltransgrid_alt.php"> <span class="uk-text-muted uk-text-small">GL Trans Grid</span></a></td>									
                            </tr>
                            <tr><td width="30">
                            <?php
						    $sql = "SELECT COUNT(*) as recordcount FROM gltrans";
						    echo emptyfilled($sql);						
						   
						   ?></td>
                            <td width="220"><a href="lw_glaccountinquiry_alt.php"> <span class="uk-text-muted uk-text-small">GL Account Enquiry</span></a></td>									
                            </tr>
                           <tr><td width="30">
                            <?php
						    $sql = "SELECT COUNT(*) as recordcount FROM chartmaster";
						    echo emptyfilled($sql);						
						   
						   ?></td>
                            <td width="220"><a href="lw_glcodesinquiry_alt.php"> <span class="uk-text-muted uk-text-small">GL Codes Enquiry</span></a></td></tr>
                            
                       	   </table>
                      </div>
                    </div>
                </div>
                 <div>
              		<div class="md-card" style="width:250px">
                    	<div class="md-card-content">
                        	<h3>STEP 11</h3>
                        	<b>Reconcilation</b>
                           <table>
                          	<tr><td width="30">
                           <?php
						    $sql = "SELECT COUNT(*) as recordcount FROM banktrans";
						    echo emptyfilled($sql);						
						   
						   ?></td>
                         <td width="220"><a href="lw_bankreconciliation_alt.php"> <span class="uk-text-muted uk-text-small">Reconcilation of Banks</span></a></td>							
                         </tr>
                       	 </table>
                      </div>
                    </div>
                </div>
                 <div>
              		<div class="md-card" style="width:250px">
                    	<div class="md-card-content">
                        	<h3>STEP 12</h3>
                        	<b>Accounts Final Reports</b>
                           <table>
                          	<tr><td width="30">
                           <?php
						    $sql = "SELECT COUNT(*) as recordcount FROM gltrans";
						    echo emptyfilled($sql);						
						   
						   ?></td>
                            <td width="220"><a href="lw_trialbalance_alt.php"> <span class="uk-text-muted uk-text-small">Trial Balance</span></a></td>									
                            </tr>
                            <tr><td width="30">
                            <?php
						    $sql = "SELECT COUNT(*) as recordcount FROM gltrans";
						    echo emptyfilled($sql);						
						   
						   ?></td>
                            <td width="220"><a href="lw_profitloss_alt.php"> <span class="uk-text-muted uk-text-small">Profit and Loss</span></a></td>									
                            </tr>
                           <tr><td width="30">
                            <?php
						    $sql = "SELECT COUNT(*) as recordcount FROM gltrans";
						    echo emptyfilled($sql);						
						   
						   ?></td>
                            <td width="220"><a href="lw_balancesheet_alt.php"> <span class="uk-text-muted uk-text-small">Balance Sheet</span></a></td></tr>
                           </table>
                      </div>
                    </div>
                </div>
                <div>
              		<div class="md-card" style="width:250px">
                    	<div class="md-card-content">
                        	<h3>STEP 13</h3>
                        	<b>Reports</b>
                           <table>
                           <tr><td width="30">
                            <img src="greenbtn.png"></td>
                <td width="220"><a href="lw_reports.php"> <span class="uk-text-muted uk-text-small">View &amp; Print Reports (PDF)</span></a></td>									
                            </tr>
                      	   </table>
                      </div>
                    </div>
                </div>
     			<div>
              		<div class="md-card" style="width:250px">
                    	<div class="md-card-content">
                        	<h3>STEP 14</h3>
                        	<b>Tools</b>
                           <table>
                          	<tr><td width="30">
                            <img src="redbtn.png"></td>
                            <td width="220"><a href="lw_backup_alt.php"> <span class="uk-text-muted uk-text-small">Backup Entire Database</span></a></td>									
                            </tr>
                            <tr><td width="30">
                            <img src="redbtn.png"></td>
                            <td width="220"><a href="lw_export_alt.php"> <span class="uk-text-muted uk-text-small">Export Data</span></a></td>									
                            </tr>
                            <tr><td width="30">
                            <img src="redbtn.png"></td>
                            <td width="220"><a href="#"> <span class="uk-text-muted uk-text-small">Import Data</span></a></td>									
                            </tr>
                            <tr><td width="30">
                            <img src="greenbtn.png"></td>
                            <td width="220"><a href="lw_audittrail_alt.php"> <span class="uk-text-muted uk-text-small">Audit Trail</span></a></td>									
                            </tr>
                       	   </table>
                      </div>
                    </div>
                </div>
                 <div>
              		<div class="md-card" style="width:250px">
                    	<div class="md-card-content">
                        	<h3>STEP 15</h3>
                        	<b>Help</b>
                           <table>
                           <tr><td width="30">
                            <img src="redbtn.png"></td>
                            <td width="220"><a href="doc/Manual/ManualContents.php"> <span class="uk-text-muted uk-text-small">Offline Help</span></a></td>									
                            </tr>
                          	<tr><td width="30">
                            <img src="redbtn.png"></td>
                            <td width="220"><a href="http://www.lawpract.com"> <span class="uk-text-muted uk-text-small">Check Updates</span></a></td>									
                            </tr>
                       	   </table>
                      </div>
                    </div>
                </div>
        </div>
                                          
 
</div>
     </div>     
          </div>           
          

 
             </form>
             <?php
			 
		
						  
	
	include('footersrc.php');
	
         
						 
	
	?>        
 
    
   


</body>
</html>