<?php
 //include('includes/DefineReceiptClass.php');
 include('includes/SQL_CommonFunctions.inc');
 
if (isset($_POST['Submitothertran'])) 
{

if ($_POST['RadioOthercash']==1) 
{
//echo 'reached receipt mode of supplier';

$PeriodNo = GetPeriod(Date('d/m/Y'),$db);
$TransNo = GetNextTransNo(12, $db);
							

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

		$ErrMsg = 'Could not add the chart details for the new account';

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
			//make an entry in the supptrans table to reflect the above transaction
			
			$DateString = Date($_SESSION['DefaultDateFormat']);
	
		$date = new DateTime(FormatDateForSQL($DateString));
	
	//make an entry in the supptrans table to reflect the above transaction
		
		 $sqlinsertsupptrans = "INSERT INTO supptrans(
							 supplierid,
							 glcode,
							 type,
							 transno,
							 amount,
							 date,
							 ourbankcode,
							 chequeno,
							 chequedate,
							 suppbankname,
							 narration,
							 currcode						
							)
				VALUES (					
					'" . trim($_POST['Supplieridhidden']) ."',
					'" . trim($glmanualcode) ."',
					12,
					'" . $TransNo . "',				
					'" . trim($_POST['OtherAmountreceived']) . "',
					'" . $date->format('Y-m-d') . "',
					'" . $_POST['BankAccount'] . "',
					'" . $_POST['Chequeno'] . "',
					'" . FormatDateForSQL($_POST['Otherreceiptdate']) . "',
					'" . trim($_POST['Custbankname']) . "',					
					'" . trim($_POST['Narration']) . "',
					'" . $_SESSION['CompanyRecord']['currencydefault'] . "'					
					)";
		
		 	$ErrMsg = 'This Bank Entry could not be added because';
			$result = DB_query($sqlinsertsupptrans,$db,$ErrMsg); 
			
  //insert bank entry in banktrans table
            
            $SQL="INSERT INTO banktrans (type,
					transno,
					bankact,
					ref,
					exrate,
					functionalexrate,
					transdate,
					banktranstype,
					chequeno,
					amount,
					currcode)
				VALUES (12,
					'" . $TransNo . "',
					'" . $_POST['BankAccount'] . "',
					'" . trim($_POST['Narration']) . "',
					'" . $_SESSION['ReceiptBatch']->ExRate . "',
					'" . $_SESSION['ReceiptBatch']->FunctionalExRate . "',
					'" . $date->format('Y-m-d') . "',
					'" . $_POST['ReceiptType'] . "',
					'" . trim($_POST['Chequeno']) . "',
					'" . (trim($_POST['Amountreceived']) * $_SESSION['ReceiptBatch']->FunctionalExRate * $_SESSION['ReceiptBatch']->ExRate) . "',
					'" . $_SESSION['CompanyRecord']['currencydefault'] . "'	
				)";
			$DbgMsg = 'The SQL that failed to insert the bank transaction was';
			$ErrMsg = 'Cannot insert bank transaction';
			$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);	
			
				 
		 
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
					'" . $_POST['BankAccount'] . "',
					'" . $_POST['Narration'] . "',
					'" .  $_POST['OtherAmountreceived'] . "',
					0)";
					
		$ErrMsg = 'Cannot insert a bank entry because';
		$DbgMsg = 'The SQL that failed to insert Bank Entry in the Bank Trans record was';
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
					'130002',
					'" . $_POST['Narration'] . "',
					" .  '-' . $_POST['OtherAmountreceived'] . ",
					0)";
					
		$ErrMsg = 'Cannot insert a bank entry because';
		$DbgMsg = 'The SQL that failed to insert Bank Entry in the Bank Trans record was';
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);
		
	
			
			?>
	
    <script>
		
swal({   title: "Supplier Receipt Entry Inserted!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('lw_bankreceipt_alt.php'); //will redirect to your page
}, 2000); 


	</script>
                        
       <?php	
		
}
else if ($_POST['RadioOthercash']==0) 
	{
	
	$PeriodNo = GetPeriod(Date('d/m/Y'),$db);
	$TransNo = GetNextTransNo(13, $db);
		
	// Supplier Bank payment mode
		
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

		$ErrMsg = 'Could not add the chart details for the new account';

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
		
		$DateString = Date($_SESSION['DefaultDateFormat']);
	
		$date = new DateTime(FormatDateForSQL($DateString));
	
	//make an entry in the supptrans table to reflect the above transaction
		
		 $sqlinsertsupptrans = "INSERT INTO supptrans(
							 supplierid,
							 glcode,
							 type,
							 transno,
							 amount,
							 date,
							 ourbankcode,
							 chequeno,
							 chequedate,
							 suppbankname,
							 narration,
							 currcode						
							)
				VALUES (					
					'" . trim($_POST['Supplieridhidden']) ."',
					'" . trim($glmanualcode) ."',
					13,
					'" . $TransNo . "',				
					'" . $_POST['OtherAmountreceived'] . "',
					'" . $date->format('Y-m-d') . "',
					'" . $_POST['BankAccount'] . "',
					'" . $_POST['Chequeno'] . "',
					'" . FormatDateForSQL($_POST['Otherreceiptdate']) . "',
					'" . trim($_POST['Custbankname']) . "',					
					'" . trim($_POST['Narration']) . "',
					'" . $_SESSION['CompanyRecord']['currencydefault'] . "'					
					)";

  			$ErrMsg = 'This Bank Payment Entry could not be added because';
			$result = DB_query($sqlinsertsupptrans,$db,$ErrMsg); 	 
		
  //insert bank entry in banktrans table
            
            $SQL="INSERT INTO banktrans (type,
					transno,
					bankact,
					ref,
					exrate,
					functionalexrate,
					transdate,
					banktranstype,
					chequeno,
					amount,
					currcode)
				VALUES (13,
					'" . $TransNo . "',
					'" . $_POST['BankAccount'] . "',
					'" . trim($_POST['Narration']) . "',
					'" . $_SESSION['ReceiptBatch']->ExRate . "',
					'" . $_SESSION['ReceiptBatch']->FunctionalExRate . "',
					'" . $date->format('Y-m-d') . "',
					'" . $_POST['ReceiptType'] . "',
					'" . trim($_POST['Chequeno']) . "',
					'".(trim($_POST['Amountreceived']) * $_SESSION['ReceiptBatch']->FunctionalExRate * $_SESSION['ReceiptBatch']->ExRate)."',
					'" . $_SESSION['CompanyRecord']['currencydefault']."'	
				)";
			$DbgMsg = 'The SQL that failed to insert the bank payment transaction was';
			$ErrMsg = 'Cannot insert a bank transaction';
			$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);
		 
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
					'" . $_POST['BankAccount'] . "',
					'" . $_POST['Narration'] . "',
					'" . '-' . $_POST['OtherAmountreceived'] . "',
					0)";
		$ErrMsg = 'Cannot insert a bank payment entry because';
		$DbgMsg = 'The SQL that failed to insert bank Entry in the bank trans record was';
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
					'220001',
					'" . $_POST['Narration'] . "',
					" . $_POST['OtherAmountreceived'] . ",
					0)";
		$ErrMsg = 'Cannot insert a bank payment entry because';
		$DbgMsg = 'The SQL that failed to insert the bank trans record was';
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);
		
		
				?>
						
						  <script>
		
swal({   title: "Supplier Bank Payment Inserted!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('lw_bankreceipt_alt.php'); //will redirect to your page
}, 2000); 


	</script>
						
	<?php
	
							
}
} //good till now

//Main submit section for accrual bases accounting

//ACCRUAL BASED ACCOUNTING

if (isset($_POST['Submitaccrual'])) 
{	
	 // It is accrual based accounting	 
	
	$DateString = Date($_SESSION['DefaultDateFormat']);
	$date = new DateTime(FormatDateForSQL($DateString));
	
if ($_POST['RadioAR']==1) //receipt mode for accrual based accounting
{

	$PeriodNo = GetPeriod(Date('d/m/Y'),$db);
	$TransNo = GetNextTransNo(12, $db);

				
		if(empty($_POST['Receivedt']))
		{				
		$_POST['Receivedt']="NULL";
		}
		else
		{
		$_POST['Receivedt']=FormatDateForSQL($_POST['Receivedt']);
		
		}
		
		//First check if there is a record in lw_partyeconomy for the search Hiddenbrieffile
	 
	 $sqlsearchbriefineconomy='SELECT brief_file,glcode,totalfees from lw_partyeconomy WHERE brief_file="' . $_POST['Hiddenbrieffile'] . '" AND type=10';
		
		$resultbriefineconomy = DB_query($sqlsearchbriefineconomy,$db);
		
		$myrowbriefineconomy=DB_fetch_array($resultbriefineconomy);
	 
	 if($myrowbriefineconomy[0])
	 {
	 //update mode for accrual
	 
	 		
		 //below is for updating data in lw_partytrans table when party starts paying fees	
			
			if($_POST['Amountreceived']!=NULL)
				{					
											 
			  $sqlinsertpartytrans = "INSERT INTO lw_partytrans(
			  				type,
			  				invoiceno,
			  				transno,
							brief_file,
							party,
							glcode,
							amountreceived,
							receivedt,
							ourbankcode,
							chequeno,
							custbankname,
							narration						
							)
				VALUES (12,
					'".trim($_POST['Invoiceno'])."',
					'".$TransNo . "',
					'".trim($_POST['Hiddenbrieffile'])."',
					'".trim($_POST['Hiddenpartyid'])."',
					'".trim($myrowbriefineconomy[1])."',					
					'".trim($_POST['Amountreceived'])."',
					'".trim($_POST['Receivedt'])."',
					'" . $_POST['BankAccount'] . "',
					'" . $_POST['Chequeno'] . "',
					'" . trim($_POST['Custbankname']) . "',	
					'".trim($_POST['Narration'])."'				
					)";
						 
			$result = DB_query($sqlinsertpartytrans,$db);
			
 			 $_SESSION['ReceiptBatch']->FunctionalExRate=1;
             $_SESSION['ReceiptBatch']->ExRate=1;
			
  //insert bank entry in banktrans table
  
            
            $sqlbank="INSERT INTO banktrans (type,
					transno,
					bankact,
					ref,
					exrate,
					functionalexrate,
					transdate,
					banktranstype,
					chequeno,
					amount,
					currcode)
				VALUES (12,
					'" . $TransNo . "',
					'" . $_POST['BankAccount'] . "',
					'" . trim($_POST['Narration']) . "',
					'" . $_SESSION['ReceiptBatch']->ExRate . "',
					'" . $_SESSION['ReceiptBatch']->FunctionalExRate . "',
					'" . $date->format('Y-m-d') . "',
					'" . $_POST['ReceiptType'] . "',
					'" . trim($_POST['Chequeno']) . "',
					'" . (trim($_POST['Amountreceived']) * $_SESSION['ReceiptBatch']->FunctionalExRate * $_SESSION['ReceiptBatch']->ExRate) . "',
					'" . $_SESSION['CompanyRecord']['currencydefault'] . "'	
				)";
			
			
			$result = DB_query($sqlbank,$db);
									
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
					'" . $_POST['BankAccount'] . "',
					'" . $_POST['Narration'] . "',
					'" .  $_POST['Amountreceived'] . "',
					0)";
		
		$result = DB_query($SQL,$db);

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
					'220001',
					'" . $_POST['Narration'] . "',
					" .  '-' . $_POST['Amountreceived'] . ",
					0)";
			
		$result = DB_query($SQL,$db);

	}		
		 //Below is for updating lw_partyeconomy with balace amount		
			
		//count total received amount till now from lw_partytrans for given brief_file
		
	$sqltotalreceivedfetch='SELECT type,brief_file,sum(amountreceived) from lw_partytrans WHERE brief_file="' . $_POST['Hiddenbrieffile'] . '" AND type=12';
		
		$resulttotalreceived = DB_query($sqltotalreceivedfetch,$db);
		
		$myrowtotalreceived=DB_fetch_array($resulttotalreceived);
		
		//count total paid amount till now from lw_partytrans for given brief_file
		
		$sqltotalpaidfetch='SELECT type,brief_file,sum(amountreceived) from lw_partytrans WHERE brief_file="' . $_POST['Hiddenbrieffile'] . '" AND type=13';
		
		$resulttotalpaid = DB_query($sqltotalpaidfetch,$db);
		
		$myrowtotalpaid=DB_fetch_array($resulttotalpaid);
		
		
		//Balance calculated below- Difference of Totalfees from lw_partyeconomy and sum of totalreceived from lw_partytrans
		
		$balance= $myrowbriefineconomy['totalfees']-($myrowtotalreceived[2]-$myrowtotalpaid[2]);
				
				
		//below is for updating data in lw_partyeconomy table when party starts paying fees	
		
		
		 $sqlupdatepartyeconomy = "UPDATE lw_partyeconomy SET
					balance='" . $balance . "'
				WHERE brief_file = '" . $_POST['Hiddenbrieffile'] . "' AND invoiceno='" . $_POST['Invoiceno'] . "'";
						
				$ErrMsg = _('The Bank Entry could not be updated because');
			$result = DB_query($sqlupdatepartyeconomy,$db,$ErrMsg);
			

			?>
    <script>
		
swal({   title: "Bank Payment Inserted!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('lw_bankreceipt_alt.php'); //will redirect to your page
}, 2000); 


	</script>
    
    <?php
   	 
	 }else
	 {
	 //insert mode for accrual based received accounting- Invoicing
	 
	
	 $DateString = Date($_SESSION['DefaultDateFormat']);
	 $date = new DateTime(FormatDateForSQL($DateString));
	
	$PeriodNo = GetPeriod(Date('d/m/Y'),$db);
		
	//pass sys typeid to GetNextTransNo- here it is invoice no
	
	$Invoiceno = GetNextTransNo(12, $db);	         			
					 		
		//fetch Client GLcode if already there
		
		$sqlglcode= 'SELECT accountcode,accountname FROM chartmaster where accountname="' . trim($_POST['Party']) . ' AR Debtor-Ac" ORDER BY accountcode DESC LIMIT 1';
	
		$result=DB_query($sqlglcode,$db);
		
		$myrowglcode=DB_fetch_array($result);
		
		if($myrowglcode>0)
		{
		$glcode=$myrowglcode[0];
		
		}else
		{
$sqlglcode= "SELECT accountcode,accountname FROM chartmaster where accountname LIKE '% AR Debtor-Ac' ORDER BY accountcode DESC LIMIT 1";
		$result=DB_query($sqlglcode,$db);
		
		$myrowglcode=DB_fetch_array($result);
		
		$myrowglcode['accountcode']=$myrowglcode['accountcode']+1;//Party GL Code
		 
		  $glcode= $myrowglcode['accountcode'];
		  
		  //Below is the code to create GL account code for the Party automatically for the first time
				
			$sql = 'INSERT INTO chartmaster (accountcode,
						accountname,
						group_)
					VALUES (' . $glcode . ",
						'".trim($_POST['Party']). ' AR Debtor-Ac'."',
						'Accounts Receivable')";
		   $result = DB_query($sql,$db);
			
			//Add the new chart details records for existing periods first

		$ErrMsg = 'Could not add the chart details for the new account';

		$sql = 'INSERT INTO chartdetails (accountcode, period)
				SELECT chartmaster.accountcode, periods.periodno
					FROM chartmaster
						CROSS JOIN periods
				WHERE ( chartmaster.accountcode, periods.periodno ) NOT
					IN ( SELECT chartdetails.accountcode, chartdetails.period FROM chartdetails )';

		$result = DB_query($sql,$db,$ErrMsg);

		}	        
		
				
		if($_POST['Amountreceived']!=NULL)
				{					
											 
			  $sqlinsertpartytrans = "INSERT INTO lw_partytrans(
			  				type,
			  				invoiceno,
			  				transno,
							brief_file,
							party,
							glcode,
							amountreceived,
							receivedt,
							ourbankcode,
							chequeno,
							custbankname,
							narration						
							)
				VALUES (12,
					'".trim($_POST['Invoiceno'])."',
					'".$TransNo . "',
					'".trim($_POST['Hiddenbrieffile'])."',
					'".trim($_POST['Hiddenpartyid'])."',
					'".trim($myrowbriefineconomy[0])."',					
					'".trim($_POST['Amountreceived'])."',
					'".trim($_POST['Receivedt'])."',
					'" . $_POST['BankAccount'] . "',
					'" . $_POST['Chequeno'] . "',
					'" . trim($_POST['Custbankname']) . "',	
					'".trim($_POST['Narration'])."'				
					)";

 
			$ErrMsg = 'This Bank Entry could not be added because';
			$result = DB_query($sqlinsertpartytrans,$db,$ErrMsg);
			
  //insert bank entry in banktrans table
            
            $SQL="INSERT INTO banktrans (type,
					transno,
					bankact,
					ref,
					exrate,
					functionalexrate,
					transdate,
					banktranstype,
					chequeno,
					amount,
					currcode)
				VALUES (12,
					'" . $ReceiptTransNo . "',
					'" . $_POST['BankAccount'] . "',
					'" . trim($_POST['Narration']) . "',
					'" . $_SESSION['ReceiptBatch']->ExRate . "',
					'" . $_SESSION['ReceiptBatch']->FunctionalExRate . "',
					'" . $date->format('Y-m-d') . "',
					'" . $_POST['ReceiptType'] . "',
					'" . trim($_POST['Chequeno']) . "',
					'" . (trim($_POST['Amountreceived']) * $_SESSION['ReceiptBatch']->FunctionalExRate * $_SESSION['ReceiptBatch']->ExRate) . "',
					'" . $_SESSION['CompanyRecord']['currencydefault'] . "'	
				)";
			$DbgMsg = 'The SQL that failed to insert the bank account transaction was';
			$ErrMsg = 'Cannot insert a bank transaction';
			$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true); 
									
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
					'" . $_POST['BankAccount'] . "',
					'" . $_POST['Narration'] . "',
					'" .  $_POST['Amountreceived'] . "',
					0)";
		$ErrMsg = 'Cannot insert a Bank entry because';
		$DbgMsg = 'The SQL that failed to insert the Bank Trans record was';
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);

//Second GLentry is to credit party GL account with Amount Received

//Same amount is credited to party Gl code (Mr. X )-----------------------------------
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
					'220001',
					'" . $_POST['Narration'] . "',
					" .  '-' . $_POST['Amountreceived'] . ",
					0)";
		$ErrMsg = 'Cannot insert a bank entry because';
		$DbgMsg = 'The SQL that failed to insert the bank trans record was';
		
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);

		}		          				
		/*	//below is for inserting data in lw_economy table only once in the beginning when party decides the total fee payment		
			 $sql = "INSERT INTO lw_partyeconomy(
                            type,
                            invoiceno,
							brief_file,
							party,
							courtcaseno,
							glcode,
							totalfees,
							balance,
							t_date,
							currcode						
							)
				VALUES (10,
				    '". $Invoiceno ."',              
                    '".trim($_POST['brieffilehidden'])."',
					'".trim($_POST['partyidhidden'])."',
					'".$_POST['casenohidden']."',
					'".$glcode."',
					'".trim($_POST['Totalfees'])."',
					'".trim($balance)."',
					'".trim($_POST['Receivedt'])."',
					'".$_SESSION['CompanyRecord']['currencydefault']."'								
					)";


			$ErrMsg = _('This Bank Entry could not be added because');
			$result = DB_query($sql,$db,$ErrMsg);
				
				
			//GLentry is debit Cash GL account with total fees for once. check if condition for accrual based accounting
//debit client ar ac
$SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount,
						tag) ';
		$SQL= $SQL . 'VALUES (10,
					'.$Invoiceno.",
					'".FormatDateForSQL($DateString)."',
					'".$PeriodNo."',
					'220001',
					'".$_POST['Narration']."',
					'".trim($fees_total)."',
					0)";
		$ErrMsg = _('Cannot insert a GL entry for the journal line because');
		$DbgMsg = _('The SQL that failed to insert the GL Trans record was');
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);
//try other code



//Second GLentry is to credit professional fees GL account with Total fees

$SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount,
						tag) ';
		$SQL= $SQL . 'VALUES (10,
					'.$Invoiceno.",
					'".FormatDateForSQL($DateString)."',
					".$PeriodNo.",
					'400011',
					'".$_POST['Narration']."',
					" .  '-' . $fees_total . ",
					0)";
		$ErrMsg = _('Cannot insert a bank entry because');
		$DbgMsg = _('The SQL that failed to insert the bank Trans record was');
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);                    			
	*/
		?>
			 <script>
		
swal({   title: "Bank Receipt Entry Created!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('lw_bankreceipt_alt.php'); //will redirect to your page
}, 2000); 


	</script>
    <?php	
			
}//end of accrual based accounting


}else if ($_POST['RadioAR']==0) //payments
{
//Payments for accrual based accounting
 	 $DateString = Date($_SESSION['DefaultDateFormat']);
	 $date = new DateTime(FormatDateForSQL($DateString));
	 
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
		
		//First check if there is a record in lw_partyeconomy for the search Hiddenbrieffile
	 
	 $sqlsearchbriefineconomy='SELECT brief_file,glcode,totalfees from lw_partyeconomy WHERE brief_file="' . $_POST['Hiddenbrieffile'] . '" AND type=10';
		
		$resultbriefineconomy = DB_query($sqlsearchbriefineconomy,$db);
		
		$myrowbriefineconomy=DB_fetch_array($resultbriefineconomy);
	 
	 if($myrowbriefineconomy[0])
	 {
	 //update mode for accrual
	 
			
		 //below is for updating data in lw_partytrans table when party starts paying fees	
			
			if($_POST['Amountreceived']!=NULL)
				{					
											 
			 $sqlinsertpartytrans = "INSERT INTO lw_partytrans(
			  				type,
			  				invoiceno,
			  				transno,
							brief_file,
							party,
							glcode,
							amountreceived,
							receivedt,
							ourbankcode,
							chequeno,
							custbankname,
							narration						
							)
				VALUES (13,
					'".trim($_POST['Invoiceno'])."',
					'".$TransNo."',
					'".trim($_POST['Hiddenbrieffile'])."',
					'".trim($_POST['Hiddenpartyid'])."',
					'".trim($myrowbriefineconomy[0])."',					
					'".trim($_POST['Amountreceived'])."',
					'".trim($_POST['Receivedt'])."',
					'".$_POST['BankAccount']."',
					'".$_POST['Chequeno']."',
					'".trim($_POST['Custbankname'])."',	
					'".trim($_POST['Narration'])."'				
					)";

 
			$ErrMsg = 'This Bank Entry could not be added because';
			$result = DB_query($sqlinsertpartytrans,$db,$ErrMsg);
			
  //insert bank entry in banktrans table
            
            $SQL="INSERT INTO banktrans (type,
					transno,
					bankact,
					ref,
					exrate,
					functionalexrate,
					transdate,
					banktranstype,
					chequeno,
					amount,
					currcode)
				VALUES (13,
					'" . $TransNo . "',
					'" . $_POST['BankAccount'] . "',
					'" . trim($_POST['Narration']) . "',
					'" . $_SESSION['ReceiptBatch']->ExRate . "',
					'" . $_SESSION['ReceiptBatch']->FunctionalExRate . "',
					'" . $date->format('Y-m-d') . "',
					'" . $_POST['ReceiptType'] . "',
					'" . trim($_POST['Chequeno']) . "',
					'" . (trim($_POST['Amountreceived']) * $_SESSION['ReceiptBatch']->FunctionalExRate * $_SESSION['ReceiptBatch']->ExRate) . "',
					'" . $_SESSION['CompanyRecord']['currencydefault'] . "'	
				)";
			$DbgMsg = 'The SQL that failed to insert the bank transaction was';
			$ErrMsg = 'Cannot insert a bank transaction';
			$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true); 
									
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
					'" . $_POST['BankAccount'] . "',
					'" . $_POST['Narration'] . "',
					 " .  '-' . trim($_POST['Amountreceived']).",
					0)";
		$ErrMsg = 'Cannot insert a bank entry because';
		$DbgMsg = 'The SQL that failed to insert the bank Trans record was';
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
					'220001',
					'" . $_POST['Narration'] . "',
					" . $_POST['Amountreceived'] . ",
					0)";
		$ErrMsg = 'Cannot insert a bank entry because';
		$DbgMsg = 'The SQL that failed to insert the Bank Trans record was';
		
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);

		}
		
		 //Below is for updating lw_partyeconomy with balace amount		
		//count total received amount till now from lw_partytrans for given brief_file
		
	$sqltotalreceivedfetch='SELECT type,brief_file,sum(amountreceived) from lw_partytrans WHERE brief_file="' . $_POST['Hiddenbrieffile'] . '" AND type=12';
		
		$resulttotalreceived = DB_query($sqltotalreceivedfetch,$db);
		
		$myrowtotalreceived=DB_fetch_array($resulttotalreceived);
		
		//count total paid amount till now from lw_partytrans for given brief_file
		
		$sqltotalpaidfetch='SELECT type,brief_file,sum(amountreceived) from lw_partytrans WHERE brief_file="' . $_POST['Hiddenbrieffile'] . '" AND type=13';
		
		$resulttotalpaid = DB_query($sqltotalpaidfetch,$db);
		
		$myrowtotalpaid=DB_fetch_array($resulttotalpaid);
		
		
		//Balance calculated below- Difference of Totalfees from lw_partyeconomy and sum of totalreceived from lw_partytrans
		
		$balance= $myrowbriefineconomy['totalfees']-($myrowtotalreceived[2]-$myrowtotalpaid[2]);
						
		//below is for updating data in lw_partyeconomy table when party starts paying fees	
		
		
		 $sqlupdatepartyeconomy = "UPDATE lw_partyeconomy SET
					balance='" . $balance . "'
				WHERE brief_file = '" . $_POST['Hiddenbrieffile'] . "' AND invoiceno='" . $_POST['Invoiceno'] . "'";
						
				$ErrMsg = 'The Bank Entry could not be updated because';
			$result = DB_query($sqlupdatepartyeconomy,$db,$ErrMsg);
			

			?>
			 <script>
		
swal({   title: "Bank Payment Transaction updated now!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('lw_bankreceipt_alt.php'); //will redirect to your page
}, 2000); 


	</script>
    
    <?php
   	 
	 }else
	 {
	 //insert mode for accrual based accounting- Invoicing
	 
	 $DateString = Date($_SESSION['DefaultDateFormat']);
	 $date = new DateTime(FormatDateForSQL($DateString));
	
	$PeriodNo = GetPeriod(Date('d/m/Y'),$db);
		
	//pass sys typeid to GetNextTransNo- here it is invoice no
	
	$Invoiceno = GetNextTransNo(13, $db);	         			
					 		
		//fetch Client GLcode if already there
		
		$sqlglcode= 'SELECT accountcode,accountname FROM chartmaster where accountname="' . trim($_POST['Party']) . ' AR Debtor-Ac" ORDER BY accountcode DESC LIMIT 1';
	
		$result=DB_query($sqlglcode,$db);
		
		$myrowglcode=DB_fetch_array($result);
		
		if($myrowglcode>0)
		{
		$glcode=$myrowglcode[0];
		
		}else
		{
$sqlglcode= "SELECT accountcode,accountname FROM chartmaster where accountname LIKE '% AR Debtor-Ac' ORDER BY accountcode DESC LIMIT 1";
		$result=DB_query($sqlglcode,$db);
		
		$myrowglcode=DB_fetch_array($result);
		
		$myrowglcode['accountcode']=$myrowglcode['accountcode']+1;//Party GL Code
		 
		  $glcode= $myrowglcode['accountcode'];
		  
		  //Below is the code to create GL account code for the Party automatically for the first time
				
			$sql = 'INSERT INTO chartmaster (accountcode,
						accountname,
						group_)
					VALUES (' . $glcode . ",
						'".trim($_POST['Party']). ' AR Debtor-Ac'."',
						'Accounts Receivable')";
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
							ourbankcode,
							chequeno,
							custbankname,
							narration						
							)
				VALUES (13,
					'".$TransNo."',
					'".trim($_POST['Hiddenbrieffile'])."',
					'".trim($_POST['Hiddenpartyid'])."',
					'".trim($myrowbriefineconomy[0])."',					
					'".trim($_POST['Amountreceived'])."',
					'".trim($_POST['Receivedt'])."',
					'".$_POST['BankAccount']."',
					'".$_POST['Chequeno']."',
					'".trim($_POST['Custbankname'])."',	
					'".trim($_POST['Narration'])."'				
					)";

 
			$ErrMsg = 'This Bank Entry could not be added because';
			$result = DB_query($sqlinsertpartytrans,$db,$ErrMsg);
			
  //insert bank entry in banktrans table
            
            $SQL="INSERT INTO banktrans (type,
					transno,
					bankact,
					ref,
					exrate,
					functionalexrate,
					transdate,
					banktranstype,
					chequeno,
					amount,
					currcode)
				VALUES (13,
					'" . $TransNo . "',
					'" . $_POST['BankAccount'] . "',
					'" . trim($_POST['Narration']) . "',
					'" . $_SESSION['ReceiptBatch']->ExRate . "',
					'" . $_SESSION['ReceiptBatch']->FunctionalExRate . "',
					'" . $date->format('Y-m-d') . "',
					'" . $_POST['ReceiptType'] . "',
					'" . trim($_POST['Chequeno']) . "',
					'".(trim($_POST['Amountreceived']) * $_SESSION['ReceiptBatch']->FunctionalExRate * $_SESSION['ReceiptBatch']->ExRate)."',
					'".$_SESSION['CompanyRecord']['currencydefault']."'	
				)";
			$DbgMsg = 'The SQL that failed to insert the bank transaction was';
			$ErrMsg = 'Cannot insert a bank transaction';
			$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true); 
									
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
					 '220001',
					'" . $_POST['Narration'] . "',
					'" .  $_POST['Amountreceived'] . "',
					0)";
					
		$ErrMsg = 'Cannot insert a Bank entry because';
		$DbgMsg = 'The SQL that failed to insert the Bank Trans record was';
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
					'" . $_POST['BankAccount'] . "',
					'" . $_POST['Narration'] . "',
					" .  '-' . $_POST['Amountreceived'] . ",
					0)";
		$ErrMsg = 'Cannot insert a bank entry because';
		$DbgMsg = 'The SQL that failed to insert the Bank Trans record was';
		
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);

		}		          				
			                   			
	
		?>
			 <script>
		
swal({   title: "Payment Entry Created!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('lw_bankreceipt_alt.php'); //will redirect to your page
}, 2000); 


	</script>
    <?php	
			
}//end of accrual based payment accounting


}
	 
	
    
}//end of submit accrual

	
if (!isset($brief_file))
 {

/*If the page was called without $_POST['Brief_File_No'] passed to page then assume a new Economy Entry is to be entered show a form with a Brief_File No field other wise the form showing the fields with the existing entries against the Economy Entry  will show for editing with only a hidden id field*/
  ?>         
     
 		<div class="uk-grid uk-grid-width-large-1-2 uk-grid-width-medium-1-2 uk-grid-medium hierarchical_show"  data-uk-grid-margin>

                
                <div>
                    <div class="md-card" style="width:500px">
                        <div class="md-card-content">
                        
                                                                     
                        <div class="uk-width-large-10-12 uk-container-center">                             
                      
                 			<div class="uk-grid uk-grid-width-1-2 uk-grid-width-medium-1-2">
                                 
                                 <div class="uk-width-medium-1-1" style="padding-bottom:10px">
                                 <h3 class="heading_a" style="text-align:center">Bank Entry for Client- Accrual Base</h3></div>
                           <div class="uk-width-medium-1-1" style="padding-bottom:10px">       
               <form method="POST" class="receiptsform" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        
        <input type="text" class="mdinputSearch" name="mdinputSearch" id="mdinputSearch" placeholder="Type to search Party, Brief File No, Mobile No"></div> 
     				 

 <!--<div class="uk-width-medium-1-3" style="padding-top:10px"><button class="header_main_search_btn uk-button-link"><i class="md-icon material-icons"></i></button></div>-->
 </form></div></div>
                           
	<div class="uk-width-medium-1-1" style="padding-bottom:10px; padding-top:10px" class="md-input-wrapper">
    
     <form method="POST" class="receipts" action="<?php echo $_SERVER['PHP_SELF']; ?>">
     
       <?php
                     
                    
						
						echo '<p>
                      <label>
                        <input type="radio" name="RadioAR" id="RadioARreceipt" value="1" checked="checked" />
                       Receipt</label>
                      <label>
                        <input type="radio" name="RadioAR"  id="RadioARpayment" value="0"/>
                        Payment</label>
                   </p>';
                      
                            ?>
    
	<div class="uk-grid uk-grid-width-1-2 uk-grid-width-medium-1-2" data-uk-grid-margin="5">	
    
    	
			<input tabindex=2 type="hidden" name="Hiddenbrieffile" id="Hiddenbrieffile" >           
            
        
			<input tabindex=2 type="hidden" name="Hiddencaseno" id="Hiddencaseno" >   	
            
             
			<input tabindex=2 type="hidden" name="Hiddenpartyid" id="Hiddenpartyid" > 		
			
		    <div class="uk-width-medium-1-1" style="padding-bottom:10px">Client Name(Read Only)
			<input tabindex=2 type="Text" name="Party" id="Party" class="md-input" readonly">
            </div> 
        
                  <?php
				  
				  //--------------------
$SQL = 'SELECT bankaccountname,
			bankaccounts.accountcode,
			bankaccounts.currcode
		FROM bankaccounts,
			chartmaster
		WHERE bankaccounts.accountcode=chartmaster.accountcode';

		$ErrMsg = 'The bank accounts could not be retrieved because';
		$DbgMsg = 'The SQL used to retrieve the bank accounts was';
		$AccountsResults = DB_query($SQL,$db,$ErrMsg,$DbgMsg);

		echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Total Legal Fees<input type="number" name="Totalfees" id="Totalfees" class="md-input" readonly "></div>';
			/*data-uk-tooltip="{cls:\'long-text\',pos:\'right\'}"  title="Cannot Edit. Just select an invoice number from above search for previously entered invoice. Automatically all relevant field values like Total Fees, Balance, Invoice No etc will be selected, you have to just enter cash receipt amount and date. If you have not yet entered any invoices, you can do so by going into accounts section menu (right side of the screen) and then click invoices to start creating an invoice against a brief_file. Then you can again come to this form for further receipt entries*/
        
       echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Balance Amount(Read Only)
			<input tabindex=2 type="number" name="Balance" id="Balance" class="md-input" readonly"></div>';	
			/* data-uk-tooltip="{cls:\'long-text\',pos:\'right\'}"  title="Cannot Edit. Just select a previously entered invoice, automatically calculated balance amount will be selected in this field */
            

		echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Bank Account<select tabindex=1 name="BankAccount" onChange="ReloadForm(form1.BatchInput)" class="md-input">';

		while ($myrow=DB_fetch_array($AccountsResults)){
		
		echo '<option value="' . $myrow['accountcode'] . '">' . $myrow['bankaccountname']. ' - ' . $myrow['currcode'] . '</option>';
		}
	
		echo '</select></div>';

		//------------

	echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Payment Mode<select tabindex=6 name=ReceiptType class="md-input">';

	include('includes/GetPaymentMethods.php');
	/* The array ReceiptTypes is defined from the setup tab of the main menu under payment methods - the array is populated from the include file GetPaymentMethods.php */

		foreach ($ReceiptTypes as $RcptType) {
			if (isset($_POST['ReceiptType']) and $_POST['ReceiptType']==$RcptType){
				echo "<option selected Value='$RcptType'>$RcptType";
			} else {
				echo "<option Value='$RcptType'>$RcptType";
			}
		}
	echo '</select></div>';
     
    echo '<input type="hidden" name="Code" id="Code">';	
    echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Client\'s Bank (NEFT/RTGS)
			<input tabindex=2 type="Text" name="Custbankname" id="Custbankname" class="md-input">
           </div>';
	echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Cheque/NEFT/RTGS No
			<input tabindex=2 type="number" name="Chequeno" id="Chequeno" class="md-input"></div>';
			       
    echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Date
			<input class="md-input" type="text" id="Receivedt" name="Receivedt" data-uk-datepicker="{format:\'DD/MM/YYYY\'}"></div>';
            
    echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Amount
			<input tabindex=2 type="number" name="Amountreceived" id="Amountreceived" class="md-input">
			</div>';
			/*data-uk-tooltip="{cls:\'long-text\',pos:\'right\'}"  title="Enter receipt amount here. All receipts saved against an invoice will later be available for receipt allocations. All non allocated cash receipts can be allocated for invoice*/
			
    echo '<div class="uk-width-medium-1-1" style="padding-bottom:10px">Narration
			<input tabindex=2 type="Text" name="Narration" id="Narration" class="md-input" ">
            </div>'; 
			
			/*data-uk-tooltip="{cls:\'long-text\',pos:\'right\'}"  title="For any given cash entry this narration is an important field. Narration will give statement for each of the cash receipt entry which is again visible in accounts statements */
			
	echo '<div class="uk-width-medium-1-2">Invoice No
			<input tabindex=2 type="Text" name="Invoiceno" id="Invoiceno" class="md-input" readonly">
            </div>'; 
            /* data-uk-tooltip="{cls:\'long-text\',pos:\'right\'}" readonly  title="Cannot Edit. Just select a previously entered invoice, automatically invoice number will be selected in this field */ 
			
    echo '<div class="uk-width-medium-1-2" style="padding-top:15px"><input tabindex="24" type="submit" 		name="Submitaccrual" id="Submitaccrual" class="md-btn md-btn-primary" value="Save Transaction" onClick="return checkvaliditycashac()"></div>';
        
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
		<div style="text-align:center"><h3>Bank Receipts/Payments for other than Clients</h3></div>
		<div class="uk-width-medium-1-1" style="padding-bottom:10px" class="md-input-wrapper">   
    	<div class="uk-grid uk-grid-width-1-2 uk-grid-width-medium-1-2" data-uk-grid-margin="5">	
    
       <?php
        echo '<div class="uk-width-medium-1-1" style="padding-bottom:10px">';

		echo '<input type="text" name="Supplierid" id="Supplierid" class="Supplierid" placeholder="Type to search Contact ..." tabindex="13">';

		/*data-uk-tooltip="{cls:\'long-text\',pos:\'bottom\'}"  title="first select a contact from the search to enter cash receipt for. This contact should not be from contact created for cases. Contacts created from suppliers can only be selected in this search. If there are no contacts to search, you can start creating a contact by just typing the name in the search field above. When Select Account Group from below drop down list. This will be the group under which the new general ledger will be created for the contact(supplier). Select from below radio buttons if you wish to enter cash receipt or cash payment. It is important to select this as it will affect accouts immediately after saving the transaction*/

		echo '<input type="hidden" name="Supplieridhidden" id="Supplieridhidden">';

		echo '<input type="hidden" name="Suppliernamehidden" id="Suppliernamehidden">';
 
		echo '</div>'; 

		//--------------------
?>
	<div class="uk-width-medium-1-1" style="padding-bottom:10px; padding-top:10px">
		<p>
	  <label>
	    <input  type="radio" name="RadioOthercash" id="RadioOthercash_0" value="1" checked="checked" />
	    Receipt</label>
	  <label>
	    <input type="radio" name="RadioOthercash"  id="RadioOthercash_1" value="0"/>
	    Payment</label>
   </p>
</div>

<?php


		echo '<div class="uk-width-medium-1-1" style="padding-top:2px">Account Group<select name="Group" id="Group" class="md-input">';

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

		$SQL = 'SELECT bankaccountname,
					bankaccounts.accountcode,
					bankaccounts.currcode
				FROM bankaccounts,
					chartmaster
				WHERE bankaccounts.accountcode=chartmaster.accountcode';


		$ErrMsg ='The bank accounts could not be retrieved because';
		$DbgMsg ='The SQL used to retrieve the bank accounts was';
		$AccountsResults = DB_query($SQL,$db,$ErrMsg,$DbgMsg);


		echo '<div class="uk-width-medium-1-2" style="padding-top:2px">Bank Account<select tabindex=1 name="BankAccount" onChange="ReloadForm(form1.BatchInput)" class="md-input">';

		while ($myrow=DB_fetch_array($AccountsResults)){
		
		echo '<option value="' . $myrow['accountcode'] . '">' . $myrow['bankaccountname']. ' - ' . $myrow['currcode'] . '</option>';
		}
		echo '</select></div>';

	//------------

		echo '<div class="uk-width-medium-1-2" style="padding-top:2px">Payment Mode<select tabindex=6 name=ReceiptType class="md-input">';

		include('includes/GetPaymentMethods.php');
		/* The array ReceiptTypes is defined from the setup tab of the main menu under payment methods - the array is populated from the include file GetPaymentMethods.php */

			foreach ($ReceiptTypes as $RcptType) 
				{
				if (isset($_POST['ReceiptType']) and $_POST['ReceiptType']==$RcptType){
					echo "<option selected Value='$RcptType'>$RcptType";
				} else {
					echo "<option Value='$RcptType'>$RcptType";
				}
				}
		echo '</select></div>';

     	
		echo '<div class="uk-width-medium-1-1" style="padding-bottom:2px">Address';
		echo '<input type="Text" class="md-input" name="Address" id="Address" tabindex="16"></div>'; 
			/*data-uk-tooltip="{cls:\'long-text\',pos:\'left\'}"  title="For the new supplier being created now, you can enter address for the same*/
		echo '<div class="uk-width-medium-1-2" style="padding-bottom:2px">Mobile'; 
		echo '<input class="md-input" tabindex="19" type="Text" name="Mobile" id="Mobile">'; 
		/*data-uk-tooltip="{cls:\'long-text\',pos:\'left\'}"  title="For the new supplier being created now, you can enter mobile number for the same"*/
		echo '</div>';  
		echo '<div class="uk-width-medium-1-2" style="padding-bottom:2px">Email'; 
		echo '<input class="md-input" tabindex="19" type="email" name="Email" id="Email">'; 
		/*data-uk-tooltip="{cls:\'long-text\',pos:\'left\'}"  title="For the new supplier being created now, you can enter email for the same"*/
		echo '</div>';  
				 
?>

   
		<input tabindex=2 type="hidden" name="GLManualCode" id="GLManualCode">
			  
		<input tabindex=2 type="hidden" name="GLName" id="GLName">

			  
		<div class="uk-width-medium-1-2" style="padding-bottom:2px">Client\'s Bank (NEFT/RTGS)
					<input tabindex=2 type="Text" name="Custbankname" id="Custbankname" class="md-input">
				   </div>
		<div class="uk-width-medium-1-2" style="padding-bottom:2px">Cheque/NEFT/RTGS No
					<input tabindex=2 type="number" name="Chequeno" id="Chequeno" class="md-input"></div>
		<div class="uk-width-medium-1-2" style="padding-bottom:2px">Date<input class="md-input" type="text" name="Otherreceiptdate" id="Otherreceiptdate" data-uk-datepicker="{format:'DD.MM.YYYY'}" ></div>
					<!--data-uk-tooltip="{cls:'long-text',pos:'left'}"  title="Enter the bank receipt date here" -->
					
		<div class="uk-width-medium-1-2" style="padding-bottom:2px">Amount
					<input tabindex=2 type="number" name="OtherAmountreceived" id="OtherAmountreceived" class="md-input">
					<!-- data-uk-tooltip="{cls:'long-text',pos:'left'}"  title="Enter the cash receipt amount here"-->
		</div>	
		<div class="uk-width-medium-1-1" style="padding-bottom:3px">Narration
					<input tabindex=2 type="Text" name="Narration" id="Narration" class="md-input"></div>  
					<!-- data-uk-tooltip="{cls:'long-text',pos:'left'}"  title="Enter narration here which will appear in the accounts statements"-->
					  
		<div class="uk-width-medium-1-2" style="padding-top:12px"><input tabindex="24" type="submit" name="Submitothertran" id="Submitothertran" class="md-btn md-btn-primary" value="Save Transaction"></div>
				   
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
	jQuery(".mdinputSearch").ajaxlivesearch({
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
            jQuery('.mdinputSearch').val(selectedsearch);
			
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
				 
				  $("#Invoiceno").val(result[3]);
				
				}
				
				});
				
				//below is to fetch table of customer receipts till date
	
			$.ajax({
				url: 'displaybankreceipts.php', // Url to which the request is send
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
           jQuery(".mdinputSearch").trigger('ajaxlivesearch:hide_result');
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

