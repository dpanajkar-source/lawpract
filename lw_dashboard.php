 <?php
 $PageSecurity = 13;

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

    <!-- additional styles for plugins -->
    
        <!-- chartist -->
        <link rel="stylesheet" href="bower_components/chartist/dist/chartist.min.css">
    
    <!-- uikit -->
    <link rel="stylesheet" href="bower_components/uikit/css/uikit.almost-flat.min.css" media="all">

    <!-- flag icons -->
    <link rel="stylesheet" href="assets/icons/flags/flags.min.css" media="all">

    <!-- altair admin -->
    <link rel="stylesheet" href="assets/css/main.min.css" media="all">
    
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
    
     <link rel="stylesheet" type="text/css" href="dist/sweetalert.css">
      
   <script src="dist/sweetalert-dev.js"></script>

</head>
<body class=" sidebar_main_open sidebar_main_swipe">

    <?php include("header.php"); 
  include("menu.php"); 	 ?> 
	

    <div id="page_content">
        <div id="page_content_inner">

            <!-- statistics (small charts) -->
            <div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-medium uk-sortable sortable-handler hierarchical_show" data-uk-sortable data-uk-grid-margin>
                <div>
                    <div class="md-card">
                        <div class="md-card-content">
     <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_visitors peity_data">5,3,9,6,5,9,7</span></div>
        <span class="uk-text-muted uk-text-small"><b>New Cases this Month</b></span>
                            <h2 class="uk-margin-remove"><span class="countUpMe">
                            
                   
						
                            <?php
							
	$currmonth=date("m");
    $curryear=date("Y");
	
	$query="INSERT INTO lw_cases";
                         
         	
	/* Now figure out the current months data to report for the selections made */
	$sqlaudittrail = "SELECT COUNT(*) from audittrail WHERE querystring LIKE '%" . $query . "%' AND transactiondate LIKE '%" . $curryear .'-' . $currmonth . '-' . "%'";
	
	$StatementResultsaudittrail=DB_query($sqlaudittrail,$db);
		
	while($audits=DB_fetch_array($StatementResultsaudittrail))
	{	
	
	echo $audits[0];
                            
    }                        
             ?>                     
                            
                            </span></h2>
                        </div>
                    </div>
                </div>
                 <div>
                   <div class="md-card">
                        <div class="md-card-content">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_orders peity_data">64/100</span></div>
                            <span class="uk-text-muted uk-text-small"><b>New Contacts Added</b></span>
                            <h2 class="uk-margin-remove"><span class="countUpMe">
                               <?php 
                          	$currmonth=date("m");
    $curryear=date("Y");
	
	$query="INSERT INTO lw_contacts";
                         
         	
	/* Now figure out the current months data to report for the selections made */
	$sqlaudittrail = "SELECT COUNT(*) from audittrail WHERE querystring LIKE '%" . $query . "%' AND transactiondate LIKE '%" . $curryear .'-' . $currmonth . '-' . "%'";
	
	$StatementResultsaudittrailcontact=DB_query($sqlaudittrail,$db);
		
	while($auditscontact=DB_fetch_array($StatementResultsaudittrailcontact))
	{	
	
	echo $auditscontact[0];
                            
    }  
                            ?>                           
                            
                            </span></h2>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="md-card">
                        <div class="md-card-content">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_sale peity_data">5,3,9,6,5,9,7,3,5,2</span></div>
                            <span class="uk-text-muted uk-text-small"><b><a href="new_PDFBlanknextdate.php" target="_blank">Next Date not Entered this Month</a></b>
                            <h2 class="uk-margin-remove"><span class="countUpMe">
                             <?php 
                        $DateString = Date($_SESSION['DefaultDateFormat']);
	
	$date = new DateTime(FormatDateForSQL($DateString));
                //$date->sub(new DateInterval('P1D'));  
				
				
$date->add(new DateInterval('P1M'));  
	
$Statementblank = "SELECT COUNT(*) FROM lw_trans WHERE nextcourtdate IS NULL AND currtrandate LIKE '%" . $curryear .'-' . $currmonth . '-' . "%' ";

														
								$resultblank=DB_query($Statementblank,$db);
								
								$myrowblankcases=DB_fetch_row($resultblank);
                            
                            echo $myrowblankcases[0];
                            ?>
                                              
                            </span></h2>
                        </div>
                    </div>
                </div>
               
                <div>
                    <div class="md-card">
                        <div class="md-card-content">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right">
       
                          </div>
                             <?php 
                                $currmonth=date("m");
    							$curryear=date("Y");
                        
        
		
$Statementcurrmonth = "SELECT COUNT(id) FROM lw_trans WHERE lw_trans.currtrandate LIKE '%" . $curryear .'-' . $currmonth . '-' . "%'";
                						   
								$resultcurrmonth=DB_query($Statementcurrmonth,$db);
								
								$myrowresultcurrmonth=DB_fetch_row($resultcurrmonth);
								
								$DateString = Date($_SESSION['DefaultDateFormat']);
	
								$date = new DateTime(FormatDateForSQL($DateString));
              
								$date->add(new DateInterval('P1M'));  
															  
 $Statementnextmonth = "SELECT COUNT(id) FROM lw_trans WHERE lw_trans.currtrandate LIKE '%" . $date->format('Y-m') . "%'";
                										
								$resultnextmonth=DB_query($Statementnextmonth,$db);
								
								$myrowresultnextmonth=DB_fetch_row($resultnextmonth);
							
							echo '<table>';
                            echo '<tr><td><span class="uk-text-muted uk-text-small"><b><a href="new_PDFCasescurrentmonth.php" target="_blank"> Cases in Courts This Month  : </a></b></span></td><td>';
							echo '<h5 class="uk-margin-remove"><span class="countUpMe"><b>';
							echo $myrowresultcurrmonth[0]; echo '</b></h5></td></tr>';
							echo '<tr><td><span class="uk-text-muted uk-text-small"><b><a href="new_PDFCasesnextmonth.php" target="_blank"> Cases in Courts Next Month  : </a></b></span></td><td>';
							echo '<h5 class="uk-margin-remove"><span class="countUpMe"><b>';
							echo $myrowresultnextmonth[0]; echo '</b></h5></td></tr></table>';
                                  
                           ?> 
                        </div>
                    </div>
                </div>
            </div>
            
      
                    
			<div class="uk-grid uk-grid-medium" data-uk-grid-margin>
                <div class="uk-width-xLarge-2-10 uk-width-large-3-10">
                             <div class="md-card" style="height:400px">
                        <div  class="md-card-content">
                        <div> 
                        <h4 class="heading_c uk-margin-bottom" style="margin-top:10px"><b>Client's Transactions of this Month</b></h4>
  <?php           
       $DateString = Date($_SESSION['DefaultDateFormat']);
	
	$date = new DateTime(FormatDateForSQL($DateString));
                //$date->sub(new DateInterval('P1D'));  

$Statementcash= "SELECT SUM(amountreceived) FROM lw_partytrans WHERE type=12 AND receivedt LIKE '%" . $curryear .'-' . $currmonth . '-' . "%' ";
								$resultcash=DB_query($Statementcash,$db);
								
								$myrowcash=DB_fetch_row($resultcash);
								
									echo '<table class="uk-table" style="margin-top:20px">';
									echo '<tr><td>Cash Received  : </td><td style="text-align:right">' . $myrowcash[0] . '</td></tr>';
								
$Statementcashp= "SELECT SUM(amountreceived) FROM lw_partytrans WHERE type=13 AND receivedt LIKE '%" . $curryear .'-' . $currmonth . '-' . "%' ";
								$resultcashp=DB_query($Statementcashp,$db);
								
								$myrowcashp=DB_fetch_row($resultcashp);
								
								echo '<tr><td>Cash Paid  : </td><td style="text-align:right">' . $myrowcashp[0] . '</td></tr>';
								
// for bank transactions ---------------------------------------------


$Statementbank= "SELECT SUM(amount) FROM banktrans WHERE type=12 AND transdate LIKE '%" . $curryear .'-' . $currmonth . '-' . "%' ";

								$resultbank=DB_query($Statementbank,$db);
								
								$myrowbank=DB_fetch_row($resultbank);
								
								echo '<tr><td>Bank Received  : </td><td style="text-align:right">' . $myrowbank[0] . '</td></tr>';
							

$Statementbankp= "SELECT SUM(amount) FROM banktrans WHERE type=13 AND transdate LIKE '%" . $curryear .'-' . $currmonth . '-' . "%' ";

								$resultbankp=DB_query($Statementbankp,$db);
								
								$myrowbankp=DB_fetch_row($resultbankp);
								
								echo '<tr><td>Bank Paid  : </td><td style="text-align:right">' . $myrowbankp[0] . '</td></tr></table>';	
								
// for total and balance  ---------------------------------------------


$Statementfees= "SELECT SUM(totalfees), SUM(balance) FROM lw_partyeconomy";

								$resultfees=DB_query($Statementfees,$db);
								
								$myrowfees=DB_fetch_row($resultfees);
								
								echo '<table class="uk-table" style="margin-top:20px"><tr><td>Total Receivable  : </td><td style="text-align:right">' . $myrowfees[0] . '</td></tr>';
								
								$totalreceived=$myrowcash[0] + $myrowbank[0];
								
								if($totalreceived==0)
								{
								$totalreceived='';
								}
								
								echo '<tr><td>Total Received  : </td><td style="text-align:right">' . $totalreceived . '</td></tr>';
							
								echo '<tr><td>Total Balance  : </td><td style="text-align:right">' . $myrowfees[1] . '</td></tr></table>';
	?>
                            
						</div>
                 </div>   
            </div>
            </div>
           
             <div class="uk-width-xLarge-8-10 uk-width-large-7-10">
             
                    <div class="md-card" style="overflow:auto; height:400px">
                        <div  align="center" class="md-card-content">
                        
                            <h4 class="heading_c uk-margin-bottom" align="center"><b>Current Year's Transactions Chart</b></h4>
                            <img src="db_yearwise_receiptspayments_chart.php" style="margin-top:0px; margin-bottom:0px">
                        </div>
                 </div>   
            </div>
         
            <div class="uk-width-xLarge-2-10 uk-width-large-3-10">
                               <div class="md-card" style="overflow:auto; height:400px">
                        <div  class="md-card-content">
                        <div> 
                            <h4 class="heading_c uk-margin-bottom" align="center"><b>Current Bank Balances</b></h4>
                                                    
                            <?php
							
			/*Is the account a balance sheet or a profit and loss account */
	
		$PandLAccount = false;	
		
		//first fetch bank accounts
		$sqlbank= "SELECT accountcode,
			bankaccountname
		FROM bankaccounts ORDER BY accountcode ASC";
	 $TransResult = DB_query($sqlbank,$db);	
	 
	 $no_rows_banks=DB_num_rows($TransResult);
	  
	  $banks=array();
	  $i=0;	  
	  
	 while($myrowbankaccounts=DB_fetch_array($TransResult))
	 {
	 $bankaccount[$i]=$myrowbankaccounts['accountcode'];
	 
	 $bankname[$i++]=$myrowbankaccounts['bankaccountname'];
	 
	
	 }//end of while loop to fetch bank accounts from bankaccounts table
	
	
	$j=0;
	while($j<$no_rows_banks)
	{	 
	 $SelectedAccount=$bankaccount[$j];
		 	 
		$sql= "SELECT type,
			typename,
			gltrans.typeno,
			trandate,
			narrative,
			amount,
			periodno
		FROM gltrans, systypes
		WHERE gltrans.account = $SelectedAccount
		AND systypes.typeid=gltrans.type
		AND posted=1 ORDER BY periodno, gltrans.trandate, id";

	$ErrMsg = _('The transactions for account') . ' ' . $SelectedAccount . ' ' . _('could not be retrieved because') ;
	$TransResult = DB_query($sql,$db,$ErrMsg);
		
        echo '<table class="uk-table">';
 
	$TableHeader = "<tr>
			<th colspan=2>" . _('Bank') . "</th>
			<th></th>
			<th></th>
			<th colspan=4>" . _('Current Balance') . "</th>			
			</tr>";

	echo $TableHeader;

	       // added to fix bug with Brought Forward Balance always being zero
					$sql = "SELECT bfwd,
						actual,
						period
					FROM chartdetails
					WHERE chartdetails.accountcode= $SelectedAccount";

				$ErrMsg = _('The chart details for account') . ' ' . $SelectedAccount . ' ' . _('could not be retrieved');
				$ChartDetailsResult = DB_query($sql,$db,$ErrMsg);
				$ChartDetailRow = DB_fetch_array($ChartDetailsResult);
				// --------------------

		$RunningTotal =$ChartDetailRow['bfwd'];
		
	$PeriodTotal = 0;
	$PeriodNo = -9999;
	$ShowIntegrityReport = False;    
    
	while ($myrow=DB_fetch_array($TransResult)) {       

		$RunningTotal += $myrow['amount'];
		$PeriodTotal += $myrow['amount'];

		if($myrow['amount']>=0){
			$DebitAmount = number_format($myrow['amount'],2);
			$CreditAmount = '';
		} else {
			$CreditAmount = number_format(-$myrow['amount'],2);
			$DebitAmount = '';
		}

		$FormatedTranDate = ConvertSQLDate($myrow['trandate']);
		
			}// end of second while loop for fetching balance brought forward for bank accounts
			
		
		
		echo '<td align=left colspan=2>' . $bankname[$j++] . '</td><td colspan=2></td>';

	if ($RunningTotal >0){
		echo '<td align=right style="color:#006633"><b>' . number_format(($RunningTotal),2) . '</b></td><td></td><td></td></tr>';
	}else {
		echo '<td></td><td align=right colspan=2 style="color:#006633"><b>' . number_format((-$RunningTotal),2) . '</b></td><td colspan=2></td></tr>';
	}	
	
	
	}
	
	echo '</table>';
?>  
                        </div>
                 </div>   
            </div>
  </div>
                    
 <div class="uk-width-xLarge-8-10 uk-width-large-7-10">
             		<div class="md-card" style="height:400px; overflow:auto">
                    <div  align="center" class="md-card-content">
                    <div class="uk-overflow-container">
                            <h4 class="heading_c uk-margin-bottom" align="center"><b>Payment Dues Till Date</b></h4>
                           
                            <?php
$sqlpartyeconomy = "SELECT lw_partyeconomy.brief_file,
				lw_contacts.name,
				lw_contacts.mobile,
				lw_partyeconomy.courtcaseno,
				lw_partyeconomy.totalfees,
				lw_partyeconomy.balance
			FROM lw_partyeconomy INNER JOIN lw_contacts
		ON lw_partyeconomy.party=lw_contacts.id WHERE balance >0";
		$StatementResults=DB_query($sqlpartyeconomy,$db);		
	?> 
     
  
      <table class="uk-table uk-table-condensed">
                <?php 
	$TableHeader = "<thead><tr>
				<th>" . _('ID') . "</th>
				<th>" . _('Brief_File') . "</th>
				<th>" . _('Case No') . "</th>
				<th>" . _('Party Name') . "</th>
				<th>" . _('Mobile') . "</th>
				<th>" . _('Total Fees') . "</th>
				<th>" . _('Balance') . "</th>
				
			    </tr></thead>";

                           
	echo $TableHeader;
		
		$i=0;
		$id=1;
		
		
	while($myrow=DB_fetch_array($StatementResults))
		{
		
			printf("<td>%s</td>
				<td>%s</td>
				<td style='color:#FFFFFF; background-color:#1976d2; font-weight:bold; text-align:center'>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>		
				</tr>",
				$id++,
				$myrow['brief_file'],
				$myrow['courtcaseno'],
				$myrow['name'],
				$myrow['mobile'],
				$myrow['totalfees'],
				$myrow['balance']);		
				  			
			}
?>
			</table>				<!--<img src="db_clientcat_cases_chart.php" style="margin-top:0px">-->
</div>
                        </div>
                 </div>   
            </div>
          
          </div>
          
          
            <div class="uk-grid" data-uk-grid-margin">
                <div class="uk-width-medium-1-2">
                <div class="md-card" style="overflow:auto; height:500px">
                        <div class="md-card-content">
                        <h4 class="heading_c uk-margin-bottom" align="center"><b>Working Days of All Users</b></h4>
                          <?php            
                   
                       $sqlusers = "SELECT DISTINCT(transactiondate),userid FROM audittrail ORDER BY userid ASC";
		$Statementusers=DB_query($sqlusers,$db); ?>
     
  
      <table class="uk-table uk-table-condensed">
                <?php 
	$TableHeader = "<thead><tr>
				<th>" . _('ID') . "</th>
				<th>" . _('Date') . "</th>
				<th style='text-align:center'>" . _('User') . "</th>
				</tr></thead>";

                           
	echo $TableHeader;
		
		$i=0;
		$id=1;
		
		
	while($myrow=DB_fetch_array($Statementusers))
		{
		
			printf("<td>%s</td>
				<td>%s</td>
				<td style='color:#FFFFFF; background-color:#1976d2; font-weight:bold; text-align:center'>%s</td>
				</tr>",
				$id++,
				$myrow['transactiondate'],
				$myrow['userid']);
				  			
		}
?>
			</table>	
              
				
	 			             
               
                      </div>
                    </div>
              </div>
       
           
                <div class="uk-width-medium-1-2">
           <div class="md-card" style="overflow:auto; height:500px">
                        <div class="md-card-content">
                       <h4 class="heading_c uk-margin-bottom" align="center"><b>Other Transactions of this Month - Received</b></h4>
                                   
     <?php 
				 
$sqlpartyeconomy = "SELECT 
				lw_contacts_other.name,
				supptrans.date,
				supptrans.amount,
				supptrans.narration
			FROM supptrans INNER JOIN lw_contacts_other
		ON supptrans.supplierid=lw_contacts_other.id WHERE type=12";
		$StatementResults=DB_query($sqlpartyeconomy,$db);		
	?> 
     
  
      <table class="uk-table uk-table-condensed">
                <?php 
	$TableHeader = "<thead><tr>
				<th>" . _('ID') . "</th>
				<th>" . _('Name') . "</th>
				<th>" . _('Date') . "</th>
				<th>" . _('Narration') . "</th>
				<th>" . _('Amount') . "</th>
				 </tr></thead>";

                           
	echo $TableHeader;
		
		
		$id=1;
		
		
	while($myrow=DB_fetch_array($StatementResults))
		{
		
			printf("<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td style='color:#FFFFFF; background-color:#1976d2; font-weight:bold; text-align:center'>%s</td>	
				</tr>",
				$id++,
				$myrow['name'],
				$myrow['date'],
				$myrow['narration'],
				$myrow['amount']);		
						
			}
?>
			</table>	
             
              <br><br>
              <h4 class="heading_c uk-margin-bottom" align="center"><b>Other Transactions of this Month - Paid</b></h4>
                                   
     <?php 
				 
$sqlpartyeconomy = "SELECT 
				lw_contacts_other.name,
				supptrans.date,
				supptrans.amount,
				supptrans.narration
			FROM supptrans INNER JOIN lw_contacts_other
		ON supptrans.supplierid=lw_contacts_other.id WHERE type=13";
		$StatementResults=DB_query($sqlpartyeconomy,$db);		
	?> 
     
  
      <table class="uk-table uk-table-condensed">
                <?php 
	$TableHeader = "<thead><tr>
				<th>" . _('ID') . "</th>
				<th>" . _('Name') . "</th>
				<th>" . _('Date') . "</th>
				<th>" . _('Narration') . "</th>
				<th>" . _('Amount') . "</th>
				 </tr></thead>";

                           
	echo $TableHeader;
		
		
		$id=1;
		
		
	while($myrow=DB_fetch_array($StatementResults))
		{
		
			printf("<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td style='color:#FFFFFF; background-color:#1976d2; font-weight:bold; text-align:center'>%s</td>	
				</tr>",
				$id++,
				$myrow['name'],
				$myrow['date'],
				$myrow['narration'],
				$myrow['amount']);		
						
			}
?>
			</table>	 
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