
<?php
 //include('includes/DefineReceiptClass.php');
 include('includes/SQL_CommonFunctions.inc');
 
if (isset($_POST['Submitothertran'])) 
{

$PeriodNo = GetPeriod(Date('d/m/Y'),$db);
$TransNo = GetNextTransNo( 12, $db);
							

if ($_POST['RadioOthercash']==1) 
{
//echo 'reached receipt mode  typeno 12';

	$sqlglcode= "SELECT accountcode,accountname FROM chartmaster where accountname='" . trim($_POST['Suppliernamehidden']) . " Ac'";
		
		$result=DB_query($sqlglcode,$db);
		
		$myrowglcode=DB_fetch_array($result);
		
		if($myrowglcode[0]>0)
		{
			$glmanualcode= $myrowglcode['accountcode'];				
			
         }
		 else
		 {
		 	 		 		
		//fetch last GLcode
		
		$gl=explode('-',$_POST['Group']);
		
		$glcode=$gl[0];
		$glname=$gl[1];
		
		$sqlcontactid = "SELECT id FROM lw_contacts_other WHERE name='" . trim($_POST['Suppliernamehidden']) . "'";
		
		$sqlglcode= "SELECT accountcode FROM chartmaster where group_ = '" . trim($glname) . "' ORDER BY accountcode DESC LIMIT 1";
		
		$result=DB_query($sqlglcode,$db);
		
		$myrowglcode=DB_fetch_array($result);		
			
		$myrowglcode['accountcode']=$myrowglcode['accountcode']+1;//Party GL Code		
		 
		$glmanualcode= $myrowglcode['accountcode'];
		 
		  
		  //Below is the code to create GL account code for the Party automatically for the first time
				
			$sql = 'INSERT INTO chartmaster (accountcode,
						accountname,
						group_)
					VALUES ('.$glmanualcode.",
						'".strtoupper(trim($_POST['Suppliernamehidden'])). ' Ac'."',
						'" . $glname . "')";
			$result = DB_query($sql,$db);
			
			//Add the new chart details records for existing periods first

		$ErrMsg = _('Could not add the chart details for the new account');

		$sql = 'INSERT INTO chartdetails (accountcode, period)
				SELECT chartmaster.accountcode, periods.periodno
					FROM chartmaster
						CROSS JOIN periods
				WHERE ( chartmaster.accountcode, periods.periodno ) NOT
					IN ( SELECT chartdetails.accountcode, chartdetails.period FROM chartdetails )';

		$result = DB_query($sql,$db,$ErrMsg);

		//prnMsg(_('The new general ledger account has been added'),'success');
		
		 }
		 				
		//first check if $_POST['Caseparty'] value is already there in the lw_contacts table
			
			
		if (!empty($_POST['Supplieridhidden']))
		{
		
		//echo 'reached case party update';
		
			$sql = "UPDATE lw_contacts_other SET
			address='".strtoupper(trim($_POST['Address']))."',
			mobile='".trim($_POST['Mobile'])."',
			email='".trim($_POST['Email'])."'
			WHERE id='".$_POST['Supplieridhidden']."'";
			
		$result=DB_query($sql,$db);		
				
		}
		 else
		
		{ 		
		
		$sql = "INSERT INTO lw_contacts_other(
			name,
			address,
			mobile,
			email
			)
			VALUES ('".strtoupper(trim($_POST['Suppliernamehidden']))."',
			'".strtoupper(trim($_POST['Address']))."',
			'".trim($_POST['Mobile'])."',
			'".trim($_POST['Email'])."'
			)";
		
		$result = DB_query($sql,$db);
		
		$sqlcontactid = "SELECT id FROM lw_contacts_other WHERE name='" . trim($_POST['Suppliernamehidden']) . "'";
		$resultcontactid = DB_query($sqlcontactid,$db);
		$myrowcontactid = DB_fetch_row($resultcontactid);
		$Supplierid=$myrowcontactid[0];
		
		$_POST['Supplieridhidden']=$Supplierid;	
				
		}			 
		 
		 
$SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount,
						tag) ';
		$SQL= $SQL . 'VALUES (12,
					' . $TransNo . ",
					'" . FormatDateForSQL($_POST['Otherreceiptdate']) . "',
					'" . $PeriodNo . "',
					'204001',
					'" . $_POST['Narration'] . "',
					'" .  $_POST['OtherAmountreceived'] . "',
					0)";
		$ErrMsg = _('Cannot insert a cash entry because');
		$DbgMsg = _('The SQL that failed to insert Cash Entry in the Cash Trans record was');
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);

//Second GLentry is to credit Another GL account with Amount Received


$SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount,
						tag) ';
		$SQL= $SQL . 'VALUES (12,
					' . $TransNo . ",
					'" . FormatDateForSQL($_POST['Otherreceiptdate']) . "',
					" . $PeriodNo . ",
					" . $glmanualcode . ",
					'" . $_POST['Narration'] . "',
					" .  '-' . $_POST['OtherAmountreceived'] . ",
					0)";
		$ErrMsg = _('Cannot insert a cash entry because');
		$DbgMsg = _('The SQL that failed to insert Cash Entry in the Cash Trans record was');
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);
		
		//make an entry in the supptrans table to reflect the above transaction
		
		 $sqlinsertsupptrans = "INSERT INTO supptrans(
							 supplierid,
							 glcode,
							 type,
							 transno,
							 amount,
							 date,
							 narration,
							 currcode				
							)
				VALUES (					
					'" . trim($_POST['Supplieridhidden']) ."',
					'" . trim($glmanualcode) ."',
					12,
					'" . $TransNo . "',				
					'" . trim($_POST['OtherAmountreceived']) . "',
					'" . FormatDateForSQL($_POST['Otherreceiptdate']) . "',
					'" . trim($_POST['Narration']) . "',
					'" . $_SESSION['CompanyRecord']['currencydefault'] . "'				
					)";

 
			$ErrMsg = _('This Cash Entry could not be added because');
			$result = DB_query($sqlinsertsupptrans,$db,$ErrMsg); 
			
			?>
	
   <script>
		
swal({   title: "Cash Inserted!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('lw_economy_alt.php'); //will redirect to your page
}, 2000); 


	</script>
                        
       <?php	
		
}
else if ($_POST['RadioOthercash']==0) 
	{
	
	//echo 'reached Payment mode typeno 13';
	
	$sqlglcode= "SELECT accountcode,accountname FROM chartmaster where accountname='" . trim($_POST['Suppliernamehidden']) . " Ac'";
		
		$result=DB_query($sqlglcode,$db);
		
		$myrowglcode=DB_fetch_array($result);
		
		
		if($myrowglcode[0]>0)
		{
			$glmanualcode= $myrowglcode['accountcode'];				
			
         }
		 else
		 {		 
		 		 		
		//fetch last GLcode
		
			
		$gl=explode('-',$_POST['Group']);
		
		$glcode=$gl[0];
		$glname=$gl[1];
		
		$sqlcontactid = "SELECT id FROM lw_contacts_other WHERE name='" . trim($_POST['Suppliernamehidden']) . "'";
		
		$sqlglcode= "SELECT accountcode FROM chartmaster where group_ = '" . trim($glname) . "' ORDER BY accountcode DESC LIMIT 1";
		
		$result=DB_query($sqlglcode,$db);
		
		$myrowglcode=DB_fetch_array($result);		
			
		$myrowglcode['accountcode']=$myrowglcode['accountcode']+1;//Party GL Code		
		 
		$glmanualcode= $myrowglcode['accountcode'];
		 
		  
		  //Below is the code to create GL account code for the Party automatically for the first time
				
			$sql = 'INSERT INTO chartmaster (accountcode,
						accountname,
						group_)
					VALUES ('.$glmanualcode.",
						'".strtoupper(trim($_POST['Suppliernamehidden'])). ' Ac'."',
						'" . $glname . "')";
			$result = DB_query($sql,$db);
			
			//Add the new chart details records for existing periods first

		$ErrMsg = _('Could not add the chart details for the new account');

		$sql = 'INSERT INTO chartdetails (accountcode, period)
				SELECT chartmaster.accountcode, periods.periodno
					FROM chartmaster
						CROSS JOIN periods
				WHERE ( chartmaster.accountcode, periods.periodno ) NOT
					IN ( SELECT chartdetails.accountcode, chartdetails.period FROM chartdetails )';

		$result = DB_query($sql,$db,$ErrMsg);

		
		 }
		 				
		//first check if $_POST['Caseparty'] value is already there in the lw_contacts table
		
		
			
		if (!empty($_POST['Supplieridhidden']))
		{
		
		//echo 'reached case party update';
		
			$sql = "UPDATE lw_contacts_other SET
			address='".strtoupper(trim($_POST['Address']))."',
			mobile='".trim($_POST['Mobile'])."',
			email='".trim($_POST['Email'])."'
			WHERE id= '".$_POST['Supplieridhidden']."'";
			
		$result=DB_query($sql,$db);		
				
		}
		 else
		
		{ 		
		
		$sql = "INSERT INTO lw_contacts_other(
			name,
			address,
			mobile,
			email
			)
			VALUES ('".strtoupper(trim($_POST['Suppliernamehidden']))."',
			'".strtoupper(trim($_POST['Address']))."',
			'".trim($_POST['Mobile'])."',
			'".trim($_POST['Email'])."'
			)";
		
		$result = DB_query($sql,$db);
		
		$sqlcontactid = "SELECT id FROM lw_contacts_other WHERE name='" . trim($_POST['Suppliernamehidden']) . "'";
		$resultcontactid = DB_query($sqlcontactid,$db);
		$myrowcontactid = DB_fetch_row($resultcontactid);
		$Supplierid=$myrowcontactid[0];
		
		$_POST['Supplieridhidden']=$Supplierid;	
				
		}			 
		 
		 
$SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount,
						tag) ';
		$SQL= $SQL . 'VALUES (13,
					' . $TransNo . ",
					'" . FormatDateForSQL($_POST['Otherreceiptdate']) . "',
					'" . $PeriodNo . "',
					'204001',
					'" . $_POST['Narration'] . "',
					'" . '-' . $_POST['OtherAmountreceived'] . "',
					0)";
		$ErrMsg = _('Cannot insert a cash entry because');
		$DbgMsg = _('The SQL that failed to insert Cash Entry in the Cash Trans record was');
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);

//Second GLentry is to credit Another GL account with Amount Received


$SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount,
						tag) ';
		$SQL= $SQL . 'VALUES (13,
					' . $TransNo . ",
					'" . FormatDateForSQL($_POST['Otherreceiptdate']) . "',
					" . $PeriodNo . ",
					" . $glmanualcode . ",
					'" . $_POST['Narration'] . "',
					" . $_POST['OtherAmountreceived'] . ",
					0)";
		$ErrMsg = _('Cannot insert a cash entry because');
		$DbgMsg = _('The SQL that failed to insert Cash Entry in the Cash Trans record was');
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);
		
		//make an entry in the supptrans table to reflect the above transaction
		
		 $sqlinsertsupptrans = "INSERT INTO supptrans(
							 supplierid,
							 glcode,
							 type,
							 transno,
							 amount,
							 date,
							 narration,
							 currcode					
							)
				VALUES (					
					'" . trim($_POST['Supplieridhidden']) ."',
					'" . trim($glmanualcode) ."',
					13,
					'" . $TransNo . "',				
					'" . $_POST['OtherAmountreceived'] . "',
					'" . FormatDateForSQL($_POST['Otherreceiptdate']) . "',
					'" . trim($_POST['Narration']) . "',
					'" . $_SESSION['CompanyRecord']['currencydefault'] . "'				
					)";

 
			$ErrMsg = _('This Cash Entry could not be added because');
			$result = DB_query($sqlinsertsupptrans,$db,$ErrMsg); 
				?>
						
						  <script>
		
swal({   title: "Payment Inserted!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('lw_economy_alt.php'); //will redirect to your page
}, 2000); 


	</script>
						
	<?php
						
}
}

//Main submit section for receipts  accounting


if (isset($_POST['Submitcashreceipt'])) 
{
	/* actions to take once the user has clicked the submit button
	ie the page has called itself with some user input */	
	
	if($_POST['Radiorpt']==0)
	{
	// ---------------------------------------receipt based accounting- amount received from client---------------
	
	//First check if there is a record in lw_partyeconomy for the search Hiddenbrieffile
	$DateString = Date($_SESSION['DefaultDateFormat']);
	
	$PeriodNo = GetPeriod(Date('d/m/Y'),$db);
	$TransNo = GetNextTransNo( 12, $db);	
	
				
		if(empty($_POST['Receivedt']))
		{
				
		$_POST['Receivedt']="NULL";
		}
		else
		{
		$_POST['Receivedt']=FormatDateForSQL($_POST['Receivedt']);
		
		}
	
		

 $sqlsearchbriefineconomy='SELECT brief_file,glcode,totalfees from lw_partyeconomy WHERE brief_file="' . $_POST['Hiddenbrieffile'] . '"';//receipt
		
		$resultbriefineconomy = DB_query($sqlsearchbriefineconomy,$db);
		
		$myrowbriefineconomy=DB_fetch_array($resultbriefineconomy);	
		
						
		if($myrowbriefineconomy[0]) //There is already an entry of the brief_file in lw_partyeconomy which is only once
		{	
		//echo 'entered update mode';		
		
		$totalfees=$_POST['Totalfees']+$myrowbriefineconomy[0];
		
		 $sqlupdatepartyeconomy = "UPDATE lw_partyeconomy SET
					totalfees='" . trim($totalfees) . "'
				WHERE brief_file = '" . $_POST['Hiddenbrieffile'] . "'";

						
			$ErrMsg = _('The Cash Entry could not be updated because');
			$result = DB_query($sqlupdatepartyeconomy,$db,$ErrMsg);
			
		 //below is for inserting data in lw_partytrans table when party starts paying fees	
		 
	if($_POST['Amountreceived']!=NULL)
				{					
											 
			  $sqlinsertpartytrans = "INSERT INTO lw_partytrans(
			  				type,
			  				transno,
							brief_file,
							party,
							glcode,
							amountreceived,
							receivedt,
							narration						
							)
				VALUES (12,
					'".$TransNo . "',
					'".trim($_POST['Hiddenbrieffile'])."',
					'".trim($_POST['Hiddenpartyid'])."',
					'" . $myrowbriefineconomy['glcode'] . "',
					'" . $_POST['Amountreceived'] . "',
					'".trim($_POST['Receivedt'])."',
					'".trim($_POST['Narration'])."'				
					)";

 
			$ErrMsg = _('This Cash Entry could not be added because');
			$result = DB_query($sqlinsertpartytrans,$db,$ErrMsg); 
			
						
				//GLentry is debit Cash GL account with Amount Received

$SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount,
						tag) ';
		$SQL= $SQL . 'VALUES (12,
					' . $TransNo . ",
					'" . FormatDateForSQL($DateString) . "',
					'" . $PeriodNo . "',
					 '204001',
					'" . $_POST['Narration'] . "',
					'" .  $_POST['Amountreceived'] . "',
					0)";
			$ErrMsg = _('Cannot insert a cash entry because');
		$DbgMsg = _('The SQL that failed to insert Cash Entry in the Cash Trans record was');
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);

//Second GLentry is to credit party GL account with Amount Received

//Same amount is credited to party Gl code (Mr. X)-----------------------------------
$SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount,
						tag) ';
		$SQL= $SQL . 'VALUES (12,
					' . $TransNo . ",
					'" . FormatDateForSQL($DateString) . "',
					" . $PeriodNo . ",
					" . $myrowbriefineconomy['glcode'] . ",
					'" . $_POST['Narration'] . "',
					" .  '-' . $_POST['Amountreceived'] . ",
					0)";
			$ErrMsg = _('Cannot insert a cash entry because');
		$DbgMsg = _('The SQL that failed to insert Cash Entry in the Cash Trans record was');
		
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);
		
		
		}
		
		 //Below is for updating lw_partyeconomy with balace amount		
		
		//count total received amount till now from lw_partytrans for given brief_file
		
		$sqltotalreceivedfetch='SELECT type,brief_file,sum(amountreceived) from lw_partytrans WHERE brief_file="' . $_POST['Hiddenbrieffile'] . '" 		AND type=12';
		
		$resulttotalreceived = DB_query($sqltotalreceivedfetch,$db);
		
		$myrowtotalreceived=DB_fetch_array($resulttotalreceived);
		
		//count total paid amount till now from lw_partytrans for given brief_file
		
		$sqltotalpaidfetch='SELECT type,brief_file,sum(amountreceived) from lw_partytrans WHERE brief_file="' . $_POST['Hiddenbrieffile'] . '" AND type=13';
		
		$resulttotalpaid = DB_query($sqltotalpaidfetch,$db);
		
		$myrowtotalpaid=DB_fetch_array($resulttotalpaid);
		
		
		//Balance calculated below- Difference of Totalfees from lw_partyeconomy and sum of totalreceived from lw_partytrans
		
		$balance= $totalfees-($myrowtotalreceived[2]-$myrowtotalpaid[2]);		
		
				 			
		//below is for updating data in lw_partyeconomy table when party starts paying fees			
		
		 $sqlupdatepartyeconomy = "UPDATE lw_partyeconomy SET				
					balance='" . $balance . "'
				WHERE brief_file = '" . $_POST['Hiddenbrieffile'] . "'";

						
			$ErrMsg = _('The Cash Entry could not be updated because');
			$result = DB_query($sqlupdatepartyeconomy,$db,$ErrMsg);
		
		
			
		
			?>
	<script>
		
swal({   title: "Cash entry Updated!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('lw_economy_alt.php'); //will redirect to your page
}, 2000); 


	</script>
    <?php
	
		}
		else  //insert mode for new economy starts
		{ //it is a new brief_file economy entry
				
		$sqlglcode= "SELECT accountcode,accountname FROM chartmaster where accountname='" . trim($_POST['Party']) . " Ac'";
		
		$result=DB_query($sqlglcode,$db);
		
		$myrowglcode=DB_fetch_array($result);
		
		
		if($myrowglcode[0]>0)
		{
			$glcode= $myrowglcode['accountcode'];				
			
         }
		 else
		 {		 
		 		
		//fetch last GLcode
		
		$sqlglcode= "SELECT accountcode,accountname FROM chartmaster where accountcode LIKE '4%' ORDER BY accountcode DESC LIMIT 1";
		
		$result=DB_query($sqlglcode,$db);
		
		$myrowglcode=DB_fetch_array($result);
		
			
		 $myrowglcode['accountcode']=$myrowglcode['accountcode']+1;//Party GL Code
		 
		  $glcode= $myrowglcode['accountcode'];
		 
		  
		  //Below is the code to create GL account code for the Party automatically for the first time
				
			$sql = 'INSERT INTO chartmaster (accountcode,
						accountname,
						group_)
					VALUES (' . $glcode . ",
						'".trim($_POST['Party']) . ' Ac'."',
						'Professional Fees')";
			$result = DB_query($sql,$db);
			
			//Add the new chart details records for existing periods first

		$ErrMsg = _('Could not add the chart details for the new account');

		$sql = 'INSERT INTO chartdetails (accountcode, period)
				SELECT chartmaster.accountcode, periods.periodno
					FROM chartmaster
						CROSS JOIN periods
				WHERE ( chartmaster.accountcode, periods.periodno ) NOT
					IN ( SELECT chartdetails.accountcode, chartdetails.period FROM chartdetails )';

		$result = DB_query($sql,$db,$ErrMsg);

		
		 }			 
				 
		  $balance= $_POST['Totalfees']-$_POST['Amountreceived'];
		  
		  if(empty($_POST['Totalfees']))
		  {
		  $_POST['Totalfees']=0;				
					 $sql = "INSERT INTO lw_partyeconomy(
			 				brief_file,
							party,
							courtcaseno,
							glcode,
							totalfees,
							balance,
							t_date,
							currcode						
							)
				VALUES ('".trim($_POST['Hiddenbrieffile'])."',
					'".trim($_POST['Hiddenpartyid'])."',
					'".$_POST['Hiddencaseno']."',
					'".$glcode."',
					'".trim($_POST['Totalfees'])."',
					'".trim($balance)."',
					'".$_POST['Receivedt']."',
					'" . $_SESSION['CompanyRecord']['currencydefault'] . "'			
					)";

			$ErrMsg = _('This Economy Entry could not be added because');
			$result = DB_query($sql,$db,$ErrMsg);
			}else
			{
			 $sql = "INSERT INTO lw_partyeconomy(
			 				brief_file,
							party,
							courtcaseno,
							glcode,
							totalfees,
							balance,
							t_date,
							currcode						
							)
				VALUES ('".trim($_POST['Hiddenbrieffile'])."',
					'".trim($_POST['Hiddenpartyid'])."',
					'".$_POST['Hiddencaseno']."',
					'".$glcode."',
					'".trim($_POST['Totalfees'])."',
					'".trim($balance)."',
					'".$_POST['Receivedt']."',
					'" . $_SESSION['CompanyRecord']['currencydefault'] . "'			
					)";

			$ErrMsg = _('This Economy Entry could not be added because');
			$result = DB_query($sql,$db,$ErrMsg);
			
			
			}
			
			  if(!empty($_POST['Amountreceived']))
		  {
					
			//below is for inserting data in lw_partytrans table once in the beginning if party pays some amount as advance	
	
	//this is the only transaction if the software uses Case Receipt based system
										
			 $sql = "INSERT INTO lw_partytrans(
                            type,
			 				transno,
							brief_file,
							party,
							glcode,
							amountreceived,
							receivedt,
							narration					
							)
					VALUES (12,
                        '" . $TransNo ."',
						'".trim($_POST['Hiddenbrieffile'])."',				
						'".trim($_POST['Hiddenpartyid'])."',
						'".$glcode."',				
						'" . $_POST['Amountreceived'] . "',
						'".$_POST['Receivedt']."',
						'".trim($_POST['Narration'])."'				
						)";

			$result = DB_query($sql,$db);
		
			
			//GLentry is debit Cash GL account with Amount Received


     $SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount,
						tag) ';
		$SQL= $SQL . 'VALUES (12,
					' . $TransNo . ",
					'" . FormatDateForSQL($DateString) . "',
					'" . $PeriodNo . "',
					'204001',
					'" . $_POST['Narration'] . "',
					'" .  $_POST['Amountreceived'] . "',
					0)";
       $result = DB_query($SQL,$db);		
		
//Second GLentry is to credit Another GL account with Amount Received


//Same amount is credited to party Gl code-----------------------------------
$SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount,
						tag) ';
		$SQL= $SQL . 'VALUES (12,
					' . $TransNo . ",
					'" . FormatDateForSQL($DateString) . "',
					" . $PeriodNo . ",
					" . $glcode . ",
					'" . $_POST['Narration'] . "',
					" .  '-' . $_POST['Amountreceived'] . ",
					0)";
		$ErrMsg = _('Cannot insert a cash entry because');
		$DbgMsg = _('The SQL that failed to insert Cash Entry in the Cash Trans record was');
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);
					
			 
			
			}		
		
			
		?>
			 <script>
		
swal({   title: "Cash Received!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('lw_economy_alt.php'); //will redirect to your page
}, 2000); 


	</script>
    <?php	
			
		}//end of insert new economy transaction (Cash Receipt) ends
		
	
	}else if($_POST['Radiorpt']==1)
	{
	
	//cash payment mode
	$DateString = Date($_SESSION['DefaultDateFormat']);
	
	$PeriodNo = GetPeriod(Date('d/m/Y'),$db);
	$TransNo = GetNextTransNo(13, $db);	
	
				
		if(empty($_POST['Receivedt']))
		{
				
		$_POST['Receivedt']="NULL";
		}
		else
		{
		$_POST['Receivedt']=FormatDateForSQL($_POST['Receivedt']);
		
		}
			
 
 $sqlsearchbriefineconomy='SELECT brief_file,glcode,totalfees from lw_partyeconomy WHERE brief_file="' . $_POST['Hiddenbrieffile'] . '"';//receipt
		
		$resultbriefineconomy = DB_query($sqlsearchbriefineconomy,$db);
		
		$myrowbriefineconomy=DB_fetch_array($resultbriefineconomy);	
		
						
		if($myrowbriefineconomy[0]) //There is already an entry of the brief_file in lw_partyeconomy which is only once
		{	
		//echo 'entered cash payment update mode';		
		
		$totalfees=$_POST['Totalfees']+$myrowbriefineconomy[0];
		
		 $sqlupdatepartyeconomy = "UPDATE lw_partyeconomy SET
					totalfees='" . trim($totalfees) . "'
				WHERE brief_file = '" . $_POST['Hiddenbrieffile'] . "'";

						
			$ErrMsg = _('The Cash Entry could not be updated because');
			$result = DB_query($sqlupdatepartyeconomy,$db,$ErrMsg);
			
		 //below is for inserting data in lw_partytrans table when party starts paying fees	
		 
	if($_POST['Amountreceived']!=NULL)
				{					
											 
			 $sqlinsertpartytrans = "INSERT INTO lw_partytrans(
					 		type,
			  				transno,
							brief_file,
							party,
							glcode,
							amountreceived,
							receivedt,
							narration						
							)
				VALUES (13,
				'".$TransNo . "',
					'".trim($_POST['Hiddenbrieffile'])."',
					'".trim($_POST['Hiddenpartyid'])."',
					'".trim($myrowbriefineconomy['glcode'])."',
					'" . $_POST['Amountreceived'] . "',
					'".trim($_POST['Receivedt'])."',
					'".trim($_POST['Narration'])."'				
					)";
 
			$ErrMsg = _('This Cash Entry could not be added because');
			$result = DB_query($sqlinsertpartytrans,$db,$ErrMsg); 
			
						
		//GLentry is debit Cash GL account with Amount Received

$SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount,
						tag) ';
		$SQL= $SQL . 'VALUES (13,
					' . $TransNo . ",
					'" . FormatDateForSQL($DateString) . "',
					'" . $PeriodNo . "',
					 '204001',
					'" . $_POST['Narration'] . "',
					" .  '-' . $_POST['Amountreceived'] . ",
					0)";
		$ErrMsg = _('Cannot insert a cash payment entry because');
		$DbgMsg = _('The SQL that failed to insert Cash Payment Entry in the Cash Trans record was');
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);

//Second GLentry is to credit party GL account with Amount Received

//Same amount is credited to party Gl code (Mr. X)-----------------------------------
$SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount,
						tag) ';
		$SQL= $SQL . 'VALUES (13,
					' . $TransNo . ",
					'" . FormatDateForSQL($DateString) . "',
					" . $PeriodNo . ",
					'" . $myrowbriefineconomy['glcode'] . "',
					'" . $_POST['Narration'] . "',
					'" . $_POST['Amountreceived'] . "',
					0)";
		$ErrMsg = _('Cannot insert a cash payment entry because');
		$DbgMsg = _('The SQL that failed to insert Cash Payment Entry in the Cash Trans record was');
		
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);
		
		
		}
		
		 //Below is for updating lw_partyeconomy with balace amount		
		
		//count total received amount till now from lw_partytrans for given brief_file
		
		$sqltotalreceivedfetch='SELECT type,brief_file,sum(amountreceived) from lw_partytrans WHERE brief_file="' . $_POST['Hiddenbrieffile'] . '" 		AND type=12';
		
		$resulttotalreceived = DB_query($sqltotalreceivedfetch,$db);
		
		$myrowtotalreceived=DB_fetch_array($resulttotalreceived);
		
		//count total paid amount till now from lw_partytrans for given brief_file
		
		$sqltotalpaidfetch='SELECT type,brief_file,sum(amountreceived) from lw_partytrans WHERE brief_file="' . $_POST['Hiddenbrieffile'] . '" AND type=13';
		
		$resulttotalpaid = DB_query($sqltotalpaidfetch,$db);
		
		$myrowtotalpaid=DB_fetch_array($resulttotalpaid);
		
		
		//Balance calculated below- Difference of Totalfees from lw_partyeconomy and sum of totalreceived from lw_partytrans
		
		$balance= $totalfees-($myrowtotalreceived[2]-$myrowtotalpaid[2]);		
		
				 			
		//below is for updating data in lw_partyeconomy table when party starts paying fees			
		
		 $sqlupdatepartyeconomy = "UPDATE lw_partyeconomy SET				
					balance='" . $balance . "'
				WHERE brief_file = '" . $_POST['Hiddenbrieffile'] . "'";

						
			$ErrMsg = _('The Cash Entry could not be updated because');
			$result = DB_query($sqlupdatepartyeconomy,$db,$ErrMsg);
			

			?>
			 <script>
		
swal({   title: "Cash Payment Entered!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('lw_economy_alt.php'); //will redirect to your page
}, 2000); 


	</script>
    <?php
	
		}
		else  //insert mode for new economy starts
		{ //it is a new brief_file economy entry
		
		
		$sqlglcode= "SELECT accountcode,accountname FROM chartmaster where accountname='" . trim($_POST['Party']) . " Ac'";
		
		$result=DB_query($sqlglcode,$db);
		
		$myrowglcode=DB_fetch_array($result);
		
		
		if($myrowglcode[0]>0)
		{
			$glcode= $myrowglcode['accountcode'];				
			
         }
		 else
		 {
		 
		 		
		//fetch last GLcode
		
		$sqlglcode= "SELECT accountcode,accountname FROM chartmaster where accountcode LIKE '4%' ORDER BY accountcode DESC LIMIT 1";
		
		$result=DB_query($sqlglcode,$db);
		
		$myrowglcode=DB_fetch_array($result);
		
			
		 $myrowglcode['accountcode']=$myrowglcode['accountcode']+1;//Party GL Code
		 
		  $glcode= $myrowglcode['accountcode'];
		 
		  
		  //Below is the code to create GL account code for the Party automatically for the first time
				
			$sql = 'INSERT INTO chartmaster (accountcode,
						accountname,
						group_)
					VALUES (' . $glcode . ",
						'".trim($_POST['Party']) . ' Ac'."',
						'Professional Fees')";
			$result = DB_query($sql,$db);
			
			//Add the new chart details records for existing periods first

		$ErrMsg = _('Could not add the chart details for the new account');

		$sql = 'INSERT INTO chartdetails (accountcode, period)
				SELECT chartmaster.accountcode, periods.periodno
					FROM chartmaster
						CROSS JOIN periods
				WHERE ( chartmaster.accountcode, periods.periodno ) NOT
					IN ( SELECT chartdetails.accountcode, chartdetails.period FROM chartdetails )';

		$result = DB_query($sql,$db,$ErrMsg);

	//	prnMsg(_('The new general ledger account has been added'),'success');
		
		 }
						
		
	  $balance= $_POST['Totalfees']-$_POST['Amountreceived'];
		  
		  if(empty($_POST['Totalfees']))
		  {
		  $_POST['Totalfees']=0;				
					 $sql = "INSERT INTO lw_partyeconomy(
			 				brief_file,
							party,
							courtcaseno,
							glcode,
							totalfees,
							balance,
							t_date,
							currcode						
							)
				VALUES ('".trim($_POST['Hiddenbrieffile'])."',
					'".trim($_POST['Hiddenpartyid'])."',
					'".$_POST['Hiddencaseno']."',
					'".$glcode."',
					'".trim($_POST['Totalfees'])."',
					'".trim($balance)."',
					'".$_POST['Receivedt']."',
					'" . $_SESSION['CompanyRecord']['currencydefault'] . "'			
					)";

			$ErrMsg = _('This Economy Entry could not be added because');
			$result = DB_query($sql,$db,$ErrMsg);
			}else
			{
			 $sql = "INSERT INTO lw_partyeconomy(
			 				brief_file,
							party,
							courtcaseno,
							glcode,
							totalfees,
							balance,
							t_date,
							currcode						
							)
				VALUES ('".trim($_POST['Hiddenbrieffile'])."',
					'".trim($_POST['Hiddenpartyid'])."',
					'".$_POST['Hiddencaseno']."',
					'".$glcode."',
					'".trim($_POST['Totalfees'])."',
					'".trim($balance)."',
					'".$_POST['Receivedt']."',
					'" . $_SESSION['CompanyRecord']['currencydefault'] . "'			
					)";

			$ErrMsg = _('This Economy Entry could not be added because');
			$result = DB_query($sql,$db,$ErrMsg);
			
			
			}
			
			  if(!empty($_POST['Amountreceived']))
		  {
					
			//below is for inserting data in lw_partytrans table once in the beginning if party pays some amount as advance	
	
	//this is the only transaction if the software uses Case Receipt based system
										
			 $sql = "INSERT INTO lw_partytrans(
                            type,
			 				transno,
							brief_file,
							party,
							glcode,
							amountreceived,
							receivedt,
							narration					
							)
					VALUES (13,
                        '" . $TransNo ."',
						'".trim($_POST['Hiddenbrieffile'])."',				
						'".trim($_POST['Hiddenpartyid'])."',
						'".$glcode."',				
						'" . $_POST['Amountreceived'] . "',
						'".$_POST['Receivedt']."',
						'".trim($_POST['Narration'])."'				
						)";

			$result = DB_query($sql,$db);
		
			
			 $SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount,
						tag) ';
		$SQL= $SQL . 'VALUES (13,
					' . $TransNo . ",
					'" . FormatDateForSQL($DateString) . "',
					'" . $PeriodNo . "',
					'204001',
					'" . $_POST['Narration'] . "',
					'" .  $_POST['Amountreceived'] . "',
					0)";
       $result = DB_query($SQL,$db);		
		
//Second GLentry is to credit Another GL account with Amount Received


//Same amount is credited to party Gl code-----------------------------------
$SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount,
						tag) ';
		$SQL= $SQL . 'VALUES (13,
					' . $TransNo . ",
					'" . FormatDateForSQL($DateString) . "',
					" . $PeriodNo . ",
					" . $glcode . ",
					'" . $_POST['Narration'] . "',
					" .  '-' . $_POST['Amountreceived'] . ",
					0)";
		$ErrMsg = _('Cannot insert a cash entry because');
		$DbgMsg = _('The SQL that failed to insert Cash Entry in the Cash Trans record was');
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);
					
}
			
		?>
			 <script>
		
swal({   title: "Cash Payment Created!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('lw_economy_alt.php'); //will redirect to your page
}, 2000); 


	</script>
    <?php	
			
		}//end of insert new economy transaction (Cash Receipt) ends

	}			
			
}

if (!isset($brief_file))
 {

/*If the page was called without $_POST['Brief_File_No'] passed to page then assume a new Economy Entry is to be entered show a form with a Brief_File No field other wise the form showing the fields with the existing entries against the Economy Entry  will show for editing with only a hidden id field*/
  ?>         
     
 		<div class="uk-grid uk-grid-width-large-1-2 uk-grid-width-medium-1-2 uk-grid-medium hierarchical_show"  data-uk-grid-margin>

                
                <div>
                    <div class="md-card" style="width:500px">
                        <div class="md-card-content">    
                        
                        <div style="text-align:center"><h3>Cash Receipts/Payments for Client</h3></div>                                                                
                        <div class="uk-width-large-10-12 uk-container-center">                             
                      
                 			<div class="uk-grid uk-grid-width-1-2 uk-grid-width-medium-1-2">
                                 
                                 <div class="uk-width-medium-1-1" style="padding-bottom:10px">
                               
                                  
               <form method="POST" class="receiptsform" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="text" class="mdinputSearchcash" name="mdinputSearchcash" id="mdinputSearchcash" placeholder="Type to search Party, Brief File No, Mobile No"></div> 
     				 

 <!--<div class="uk-width-medium-1-3" style="padding-top:10px"><button class="header_main_search_btn uk-button-link"><i class="md-icon material-icons"></i></button></div>-->
 </form></div></div>
                           
	<div class="uk-width-medium-1-1" style="padding-bottom:10px" class="md-input-wrapper">
    
     <form method="POST" class="receipts" action="<?php echo $_SERVER['PHP_SELF']; ?>">
         
	<div class="uk-grid uk-grid-width-1-2 uk-grid-width-medium-1-2" data-uk-grid-margin="5">	
    
    		<div class="uk-width-medium-1-1" style="padding-bottom:10px; padding-top:12px">
      					 <label>
                        <input  type="radio" name="Radiorpt" id="Radioreceipt" value="0" checked="checked" />
                        Cash Receipt</label>
                      <label>
                        <input type="radio" name="Radiorpt"  id="Radiopayment" value="1"/>
                        Cash Payment</label>
                        </div> 

			<input tabindex=2 type="hidden" name="Hiddenbrieffile" id="Hiddenbrieffile" >          
            
       
			<input tabindex=2 type="hidden" name="Hiddencaseno" id="Hiddencaseno" >  	
            
        
			<input tabindex=2 type="hidden" name="Hiddenpartyid" id="Hiddenpartyid" >  		
			
		    <div class="uk-width-medium-1-1" style="padding-bottom:10px">Client Name(Read Only)
			<input tabindex=2 type="Text" name="Party" id="Party" class="md-input" size=45 maxlength=100 readonly data-uk-tooltip="{cls:'long-text'}"  title="Cannot Edit. First search brie_file above">
            </div> 
        
                  <?php
  		
       echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Total Legal Fees-Receipts<input tabindex=2 type="number" name="Totalfees" id="Totalfees" class="md-input" data-uk-tooltip="{cls:\'long-text\'}"  title="Enter Total tentative fees here. This is only for user information. Will not affect accounts. As this is a receipt based accounts system you have selected, this total amount is only as a reference."></div>';
        
       echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Balance Amount(Read Only)
			<input tabindex=2 type="number" name="Balance" id="Balance" class="md-input" readonly data-uk-tooltip="{cls:\'long-text\'}"  title="Cannot Edit. Balance is automatically calculated. Total fees minus total receipts"></div>';	
            
       echo '<input tabindex=2 type="hidden" name="Code" id="Code" readonly>';
            
       echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Date
			<input class="md-input" type="text" id="Receivedt" name="Receivedt" data-uk-datepicker="{format:\'DD/MM/YYYY\'}" readonly data-uk-tooltip="{cls:\'long-text\'}"  title="Enter cash receipt date here. This date is important as it is reflected in all accounts sections according to date."></div>';
            ?>
          <div class="uk-width-medium-1-2" style="padding-bottom:10px">Amount
			<input tabindex=2 type="Text" name="Amountreceived" id="Amountreceived" class="md-input" data-uk-tooltip="{cls:'long-text'}"  title="Enter cash amount received in this text box">
		  </div>
        <?php echo '<div class="uk-width-medium-1-1" style="padding-bottom:10px">Narration
			<input tabindex=2 type="Text" name="Narration" id="Narration" class="md-input">
            </div>'; 
                
          echo '<div><input tabindex="24" type="submit" name="Submitcashreceipt" id="Submitcashreceipt" class="md-btn md-btn-primary" value="Save Transaction" onClick="return checkvaliditycashac()"></div>';
    
	
	}    
   ?>         

              </form>
</div></div></div></div></div>


<script>
function checkvaliditycashac()
{

if($("#Hiddenbrieffile").val()==0 && $("#Hiddenpartyid").val()==0)
	{

alert("Please Select Brief_File No or Partyname from the search input provided and select a case first!!");

return false;
	}

} 

</script>
            
<div>
<div class="md-card" style="width:500px">
<div class="md-card-content">
 <form method="POST" class="Otherreceiptsform" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<div style="text-align:center"><h3>Cash Receipts/Payments for Suppliers</h3></div> 
	
	<div class="uk-width-medium-1-1" style="padding-bottom:10px" class="md-input-wrapper">   
     
	<div class="uk-grid uk-grid-width-1-2 uk-grid-width-medium-1-2" data-uk-grid-margin="5">	
    
       <?php
         echo '<div class="uk-width-medium-1-1" style="padding-bottom:10px">';

echo '<input type="text" name="Supplierid" id="Supplierid" class="Supplierid" placeholder="Type to search Contact(Vendor,Supplier) ..." tabindex="13">';
echo '<input type="hidden" name="Supplieridhidden" id="Supplieridhidden">';

echo '<input type="hidden" name="Suppliernamehidden" id="Suppliernamehidden">';
 
echo '</div>';
?>
<div class="uk-width-medium-1-1" style="padding-bottom:10px; padding-top:10px">
	  <label>
	    <input  type="radio" name="RadioOthercash" id="RadioOthercash_0" value="1" checked="checked" />
	    Receipt</label>
	  <label>
	    <input type="radio" name="RadioOthercash"  id="RadioOthercash_1" value="0"/>
	    Payment</label>
  </div>
<?php

echo '<div class="uk-width-medium-1-1" style="padding-bottom:10px; padding-top:10px">Account Group<select name="Group" id="Group" class="md-input">';

	$sql = 'SELECT groupname,sequenceintb FROM accountgroups ORDER BY sequenceintb';
	$result = DB_query($sql, $db);

	while ($myrow = DB_fetch_array($result)){
		if (isset($_POST['Group']) and $myrow[0]==$_POST['Group']){
			echo "<option selected VALUE='";
		} else {
			echo "<option VALUE='";
		}
		echo $myrow[1] . '-' . $myrow[0] . "'>" . $myrow[1] . ' - ' . $myrow[0];
	}
	
	echo '</select></div>';
 
echo '<div class="uk-width-medium-1-1" style="padding-bottom:10px">Address';
echo '<input type="Text" class="md-input" name="Address" id="Address" tabindex="16" data-uk-tooltip="{cls:\'long-text\'}"  title="Enter address of the contact here. There is a provision to enter new contact here if required. One can enter the address of the same. This is optional"></div>'; 
		 
echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Mobile'; 
echo '<input class="md-input" tabindex="19" type="Text" name="Mobile" id="Mobile" data-uk-tooltip="{cls:\'long-text\'}"  title="Enter supplier mobile no. This is optional so you can enter it later when you can">'; 
echo '</div>';  
echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Email'; 
echo '<input class="md-input" tabindex="19" type="email" name="Email" id="Email" data-uk-tooltip="{cls:\'long-text\'}"  title="Enter supplier email. This is optional so you can enter it later when you can">'; 
echo '</div>';  
		 
?>
  <input tabindex=2 type="hidden" name="GLManualCode" id="GLManualCode"s>
	  
  <input tabindex=2 type="hidden" name="GLName" id="GLName">
			
			<div class="uk-width-medium-1-2" style="padding-bottom:10px">
           
			Date<input class="md-input" type="text" name="Otherreceiptdate" id="Otherreceiptdate" data-uk-datepicker="{format:'DD/MM/YYYY'}" data-uk-tooltip="{cls:'long-text'}"  title="Enter cash receipt date. This is compulsory field"></div>
			
			<div class="uk-width-medium-1-2" style="padding-bottom:10px">Amount
			<input tabindex=2 type="number" name="OtherAmountreceived" id="OtherAmountreceived" class="md-input" size=21 maxlength=18 data-uk-tooltip="{cls:'long-text'}"  title="Enter cash received from the supplier here. This is a rare case. ex- you receive interest from Fixed Deposit or share dividends etc">
			</div>	
            <div class="uk-width-medium-1-1" style="padding-bottom:10px">Narration
			<input tabindex=2 type="Text" name="Narration" id="Narration" class="md-input" size=45 maxlength=100></div>  
              
           <div><input tabindex="24" type="submit" name="Submitothertran" id="Submitothertran" class="md-btn md-btn-primary" value="Save Transaction"></div>
           
   </div></div></div></div>
</form>
            
             <div name="myform" id="myform" style="float:right; margin-top:120px; margin-right:50px">
                   
                   
                       </div>
   
</div>

		  	 <!-- Search Form Demo -->

<!-- Placed at the end of the document so the pages load faster -->
<script src="jquery-1.11.1.min.js"></script>

<script src="assets/js/common.js"></script> 

<!-- Live Search Script -->
<script type="text/javascript" src="ajaxlivesearch.js"></script>

   <script>
									
					function deleteRow(obj) {
					
					var index=obj.parentNode.parentNode.rowIndex;
					var table=document.getElementById("myTableData");
					emp=document.getElementById("myTableData").rows[index].cells[0];
					fname=document.getElementById("myTableData").rows[index].cells[1];
					table.deleteRow(index);							
										
					$.ajax({
						url: 'deletefile.php', // Url to which the request is send
						type: "POST",             // Type of request to be send, called as method
						dataType: "html",
						data: {
									'fileid': emp.textContent,	
									'party': $("#Party").val(),	
						    		'brief_file': fname.textContent
							  },// Data sent to server, a set of key/value pairs (i.e. form fields and values	
						
						success: function(data)   // A function to be called if request succeeds
						{
						
						//$("#message").html(data);
							
						}
						
						});				
					}	
	//below is for main search for the economy form
	jQuery(".mdinputSearchcash").ajaxlivesearch({
        loaded_at: <?php echo $time; ?>,
        token: <?php echo "'" . $token . "'"; ?>,
        max_input: <?php echo $maxInputLength; ?>,
        onResultClick: function(e, data) {
            // get the index 1 (second column) value
            var selectedsearch = jQuery(data.selected).find('td').eq('0').text();
			
			var selectedone = jQuery(data.selected).find('td').eq('2').text();
			
			var selectedtwo = jQuery(data.selected).find('td').eq('3').text();
			
			var selectedthree = jQuery(data.selected).find('td').eq('4').text();
			
			var selectedcourtcase = jQuery(data.selected).find('td').eq('5').text();
			
			var selectedsix = jQuery(data.selected).find('td').eq('6').text();

            // set the input value
            jQuery('.mdinputSearchcash').val(selectedsearch);
			
			jQuery('#Searchhidden').val(selectedsearch);			
			
			jQuery('#Hiddenbrieffile').val(selectedsearch);
			
			jQuery('#Hiddencaseno').val(selectedcourtcase);
			
			jQuery('#Party').val(selectedone);
			
			jQuery('#Hiddenpartyid').val(selectedsix);
						
						
			
			$.ajax({
				url: 'client_cash.php', // Url to which the request is send
				type: "POST",             // Type of request to be send, called as method
				dataType: "json",
				//data: new FormData(this),// Data sent to server, a set of key/value pairs (i.e. form fields and values	
				data: {
							//'Client': JSON.stringify(Client),
							'brief_file': $("#Hiddenbrieffile").val()			
					  },
				
				success: function(result)   // A function to be called if request succeeds
				{
				
				 $("#Totalfees").val(result[0]);
				 
				 $("#Balance").val(result[1]);
				 
				 $("#Code").val(result[2]);
				 				
				}
				
				});
				
				//below is to fetch table of customer receipts till date
	
			$.ajax({
				url: 'displayreceipts.php', // Url to which the request is send
				type: "POST",             // Type of request to be sent, called as method
				dataType: "html",
				//data: new FormData(this),// Data sent to server, a set of key/value pairs (i.e. form fields and values	
				data: {
							'brief_file': $("#Hiddenbrieffile").val()			
					  },
				
				success: function(data)   // A function to be called if request succeeds
				{				
				$("#myform").html(data);
				}
				
				});
									
			// hide the result
           jQuery(".mdinputSearchcash").trigger('ajaxlivesearch:hide_result');
        },
        onResultEnter: function(e, data) {
            // do whatever you want
            //jQuery(".mySearch").trigger('ajaxlivesearch:search', {query: 'test'});
        },
        onAjaxComplete: function(e, data) {

        }
    });
	
	
	jQuery(".Supplierid").ajaxlivesearch({
        loaded_at: <?php echo $time; ?>,
        token: <?php echo "'" . $token . "'"; ?>,
        max_input: <?php echo $maxInputLength; ?>,
        onResultClick: function(e, data) {
            // get the index 0 (first column) value ie id
            var selectedZero = jQuery(data.selected).find('td').eq('0').text();
			
			// get the index 0 (first column) value ie name
            var selectedone = jQuery(data.selected).find('td').eq('1').text();


            // set the input value
           jQuery('#Supplierid').val(selectedone);
			
			
           // set the partyname hidden value
            jQuery('#Supplieridhidden').val(selectedZero);
			
			jQuery('#Suppliernamehidden').val(selectedone);
			
			 // get the index 1 (second column) value for address
            var selectedtwo = jQuery(data.selected).find('td').eq('2').text();

            // set the input value
            jQuery('#Address').val(selectedtwo);
			
			 // get the index 1 (second column) value for mobile
            var selectedthree = jQuery(data.selected).find('td').eq('3').text();

            // set the input value
            jQuery('#Mobile').val(selectedthree);
			
			jQuery('#Email').val(jQuery(data.selected).find('td').eq('4').text());
			
				
			$.ajax({
				url: 'client_select.php', // Url to which the request is send
				type: "POST",             // Type of request to be send, called as method
				dataType: "json",
				//data: new FormData(this),// Data sent to server, a set of key/value pairs (i.e. form fields and values	
				data: {
							//'Client': JSON.stringify(Client),
							
							'id': $("#Supplieridhidden").val()		
									
					  },
				
				success: function(result)   // A function to be called if request succeeds
				{
				$("#GLManualCode").val(result[0]);
				$("#GLName").val(result[1]);
				
				}
				
				});
						
			// hide the result
            jQuery("#Supplierid").trigger('ajaxlivesearch:hide_result');
        },
        onResultEnter: function(e, data) {
            // do whatever you want
            //jQuery(".mySearch").trigger('ajaxlivesearch:search', {query: 'test'});
        },
        onAjaxComplete: function(e, data) {

        }
    });
	
			$("#mdinputSearch").blur( function() {
						
				if($("#mdinputSearch").val()=="")
				{
				$("#Hiddenbrieffile").val("");
				}  
			});
			
$("#Supplierid").blur(function() {
$("#Supplieridhidden").val('');
$("#Suppliernamehidden").val('');
$("#Address").val('');
$("#Mobile").val('');
$("#Email").val('');

$("#Suppliernamehidden").val($("#Supplierid").val());

});


</script>    	  

