<?php

 include('includes/SQL_CommonFunctions.inc'); 


if (isset($_GET['SelectedBankAccount'])) {
	$SelectedBankAccount=$_GET['SelectedBankAccount'];
} elseif (isset($_POST['SelectedBankAccount'])) {
	$SelectedBankAccount=$_POST['SelectedBankAccount'];
}

if (isset($Errors)) {
	unset($Errors);
}

$Errors = array();	

if (isset($_POST['submit'])) {

	//initialise no input errors assumed initially before we test
	$InputError = 0;

	/* actions to take once the user has clicked the submit button
	ie the page has called itself with some user input */

	//first off validate inputs sensible
	$i=1;

	$sql="SELECT count(accountcode) 
			FROM bankaccounts WHERE accountcode='".$_POST['AccountCode']."'";
	$result=DB_query($sql, $db);
	$myrow=DB_fetch_row($result);
	
	/*if ($myrow[0]!=0) {
		$InputError = 1;
		prnMsg('The bank account code already exists in the database','error');
		$Errors[$i] = 'AccountCode';
		$i++;		
	}*/
	if (strlen($_POST['BankAccountName']) >50) {
		$InputError = 1;
		prnMsg('The bank account name must be fifty characters or less long','error');
		$Errors[$i] = 'AccountName';
		$i++;		
	}
	if ( trim($_POST['BankAccountName']) == '' ) {
		$InputError = 1;
		prnMsg('The bank account name may not be empty.','error');
		$Errors[$i] = 'AccountName';
		$i++;		
	}
	
	if (strlen($_POST['BankAccountNumber']) >50) {
		$InputError = 1;
		prnMsg('The bank account number must be fifty characters or less long','error');
		$Errors[$i] = 'AccountNumber';
		$i++;		
	}
	if (strlen($_POST['BankAddress']) >50) {
		$InputError = 1;
		prnMsg('The bank address must be fifty characters or less long','error');
		$Errors[$i] = 'BankAddress';
		$i++;		
	}

	if (isset($SelectedBankAccount) AND $InputError !=1) {
		//EDIT MODE
		/*Check if there are already transactions against this account - cant allow change currency if there are*/
		
		$sql = 'SELECT * FROM banktrans WHERE bankact=' . $SelectedBankAccount;
		$BankTransResult = DB_query($sql,$db);
		if (DB_num_rows($BankTransResult)>0) {
			$sql = "UPDATE bankaccounts
				SET bankaccountname='" . $_POST['BankAccountName'] . "',
				bankaccountcode='" . $_POST['BankAccountCode'] . "',
				bankaccountnumber='" . $_POST['BankAccountNumber'] . "',
				bankaddress='" . $_POST['BankAddress'] . "',
				invoice ='" . $_POST['DefAccount'] . "',
				bankbalance ='" . $_POST['BankBalance'] . "'
			WHERE accountcode = '" . $SelectedBankAccount . "'";
			prnMsg('Note that it is not possible to change the currency of the account once there are transactions against it','warn');
	echo '<br>';
		} else {
			$sql = "UPDATE bankaccounts
				SET bankaccountname='" . $_POST['BankAccountName'] . "',
				bankaccountcode='" . $_POST['BankAccountCode'] . "',
				bankaccountnumber='" . $_POST['BankAccountNumber'] . "',
				bankaddress='" . $_POST['BankAddress'] . "',
				currcode ='" . $_POST['CurrCode'] . "',
				invoice ='" . $_POST['DefAccount'] . "',
				bankbalance ='" . $_POST['BankBalance'] . "'
				WHERE accountcode = '" . $SelectedBankAccount . "'";
		}

		$msg = 'The bank account details have been updated';
		
		$ErrMsg = 'Cannot update bank account because';
		$DbgMsg = 'The SQL that failed to update bank account record was';
		$result = DB_query($sql,$db,$ErrMsg,$DbgMsg,true);
		
		
		
		
		///////////////////////////////////////////////////
		
	$PeriodNo = GetPeriod(Date('d/m/Y'),$db);
	
	$TransNo = GetNextTransNo(2, $db);
	
			
		//make an entry in gltrans as well for opening balance
		$SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount) ';
		$SQL= $SQL . 'VALUES (0,
					' . $TransNo . ",
					'" . date('Y-m-d') . "',
					" . $PeriodNo . ",
					" . $_POST['SourceGLcode'] . ",
					'Opening Balance',
					" . -($_POST['BankBalance']) . ")"; 
					
		$ErrMsg = 'Cannot insert a Accounts entry for the GL line because';
		$DbgMsg = 'The SQL that failed to insert the GL Trans record was';
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);
					
				$SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount) ';
		$SQL= $SQL . 'VALUES (0,
					' . $TransNo . ",
					'" . date('Y-m-d') . "',
					" . $PeriodNo . ",
					" . $SelectedBankAccount . ",
					'Opening Balance',
					" . $_POST['BankBalance'] . ")"; 
				
		$ErrMsg = 'Cannot insert a Accounts entry for the GL line because';
		$DbgMsg = 'The SQL that failed to insert the GL Trans record was';
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);
		
		
				?>
						
						  <script>
		
swal({   title: "Success!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('lw_bankaccounts_alt.php'); //will redirect to your page
}, 2000); 


	</script>
						
	<?php
			
		
		//////////////////////////////////////////////////
	} elseif ($InputError !=1) {		
	

	/*Selectedbank account is null cos no item selected on first time round so must be adding a record must be submitting new entries in the new bank account form */
	
	//create new glcode for bank
	
	//fetch last GLcode
							
		$glc=2030; //set the series for Glcode
		
		$sqlglcode= "SELECT accountcode FROM chartmaster where accountcode " . LIKE . " '%" . $glc . "%' ORDER BY accountcode DESC LIMIT 1";
		
		$result=DB_query($sqlglcode,$db);
		
		$myrowglcode=DB_fetch_array($result);
		
		if($myrowglcode[0]>0)
		{
			$myrowglcode['accountcode']=$myrowglcode['accountcode']+1;//Party GL Code
         }
		 else
		 {
		 $myrowglcode['accountcode']=203002;
		 }
		 
	//Below is the code to create GL account code for the Party automatically for the first time
		
	 $glcode= $myrowglcode['accountcode'];
	 
	$PeriodNo = GetPeriod(date(),$db);

	$TransNo = GetNextTransNo( 0, $db);
	
	 
	 $sql = 'INSERT INTO chartmaster (accountcode,
						accountname,
						group_)
					VALUES (' . $glcode . ",
						'" . trim($_POST['BankAccountName']) . "',
						'Cash at Bank')";
		$result = DB_query($sql,$db);
	
		$sql = "INSERT INTO bankaccounts (
						accountcode,
						bankaccountname,
						bankaccountcode,
						bankaccountnumber,
						bankaddress,
						currcode,
						invoice,
						bankbalance)
				VALUES ('" . $glcode . "',
					'" . $_POST['BankAccountName'] . "',
					'" . $_POST['BankAccountCode'] . "',
					'" . $_POST['BankAccountNumber'] . "',					
					'" . $_POST['BankAddress'] . "', 
					'" . $_POST['CurrCode'] . "',
					'" . $_POST['DefAccount'] . "',
					'" . $_POST['BankBalance'] . "'
					)";
		
		$result = DB_query($sql,$db);
		
		//make an entry in gltrans as well for opening balance
		$SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount) ';
		$SQL= $SQL . 'VALUES (0,
					' . $TransNo . ",
					'" . date('Y-m-d') . "',
					" . $PeriodNo . ",
					" . $_POST['SourceGLcode'] . ", 
					'Opening Balance',
					" . -($_POST['BankBalance']) . ")"; 
					
		$ErrMsg = 'Cannot insert a Accounts entry for the GL line because';
		$DbgMsg = 'The SQL that failed to insert the GL Trans record was';
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);
					
					//debit the bank account ie current asset with the opening balance
				$SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount) ';
		$SQL= $SQL . 'VALUES (0,
					' . $TransNo . ",
					'" . date('Y-m-d') . "',
					" . $PeriodNo . ",
					" . $glcode . ",
					'Opening Balance',
					" . $_POST['BankBalance'] . ")"; 
				
		$ErrMsg = 'Cannot insert a Accounts entry for the GL line because';
		$DbgMsg = 'The SQL that failed to insert the GL Trans record was';
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);
		
		
		unset($_POST['AccountCode']);
		unset($_POST['BankAccountName']);
		unset($_POST['BankAccountNumber']);
		unset($_POST['BankAddress']);
		unset($_POST['CurrCode']);
		unset($_POST['DefAccount']);
		unset($_POST['BankBalance']);
		unset($SelectedBankAccount);
		
			?>
						
						  <script>
		
swal({   title: "Success!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('lw_bankaccounts_alt.php'); //will redirect to your page
}, 2000); 


	</script>
						
	<?php
		
	}

	
} elseif (isset($_GET['delete'])) {
//the link to delete a selected record was clicked instead of the submit button

	$CancelDelete = 0;

// PREVENT DELETES IF DEPENDENT RECORDS IN 'BankTrans'

	$sql= "SELECT COUNT(*) FROM banktrans WHERE banktrans.bankact='$SelectedBankAccount'";
	$result = DB_query($sql,$db);
	$myrow = DB_fetch_row($result);
	if ($myrow[0]>0) {
		$CancelDelete = 1;
		prnMsg('Cannot delete this bank account because transactions have been created using this account','warn');
		echo '<br> ' . 'There are' . ' ' . $myrow[0] . ' ' . 'transactions with this bank account code';

	}
	if (!$CancelDelete) {
	//delete chartmaster for this account
	
		$sql="DELETE FROM chartmaster WHERE accountcode='$SelectedBankAccount'";
		$result = DB_query($sql,$db);	
	
		$sql="DELETE FROM bankaccounts WHERE accountcode='$SelectedBankAccount'";
		$result = DB_query($sql,$db);
		prnMsg('Bank account deleted','success');
	} //end if Delete bank account
	
	unset($_GET['delete']);
	unset($SelectedBankAccount);
}////////////////



/* Always show the list of accounts */
If (!isset($SelectedBankAccount)) {
	$sql = "SELECT bankaccounts.accountcode,
			bankaccounts.bankaccountcode,
			chartmaster.accountname,
			bankaccountnumber,
			bankaddress,
			currcode,
			invoice,
			bankbalance
		FROM bankaccounts,
			chartmaster
		WHERE bankaccounts.accountcode = chartmaster.accountcode";
	
	$ErrMsg = 'The bank accounts set up could not be retrieved because';
	$DbgMsg = 'The SQL used to retrieve the bank account details was' . '<br>' . $sql;
	$result = DB_query($sql,$db,$ErrMsg,$DbgMsg);
	
	

	echo '<div class="uk-overflow-container">';
	
	echo '<table align="center" class="uk-table">';

	echo "<thead><tr bgcolor='#FFFFCC'><th>" . 'GL Account Code' . "</th>
		<th>" . 'Name' . "</th>
		<th>" . 'Type' . "</th>
		<th>" . 'Account No' . "</th>
		<th>" . 'Address' . "</th>
		<th>" . 'Currency' . "</th>
		<th>" . 'For Invoice' . "</th>
		<th style='text-align:right'>" . 'Balance' . "</th>
		<th></th>
		<th>" . 'Edit' . "</th>
		<th>" . 'Delete' . "</th>
	</tr></thead>";

	$k=0; //row colour counter
	while ($myrow = DB_fetch_row($result)) {
	if ($k==1){
		echo '<tr class="EvenTableRows">';
		$k=0;
	} else {
		echo '<tr class="OddTableRows">';
		$k++;
	}
	if ($myrow[7]==0) {
		//$defacc='No';
	} else {
		//$defacc='Yes';
	}
	
	if ($myrow[1]==0) {
		$bankcode='Current';
	} else {
		$bankcode='Savings';
	}
		
	printf("<td><font size=2>%s</font></td>
		<td>%s</td>
		<td>%s</td>
		<td>%s</td>
		<td>%s</td>
		<td>%s</td>
		<td>%s</td>
		<td style='text-align:right'>%s</td>
		<td>%s</td>
		<td><a href=\"%s?SelectedBankAccount=%s\">" . 'Edit' . "</td>
		<td><a href=\"%s?SelectedBankAccount=%s&delete=1\">" . 'Delete' . "</td>
		</tr>",
		$myrow[0],
		$myrow[2],
		$myrow[1],
		$myrow[3],
		$myrow[4],
		$myrow[5],
		$myrow[6],
		$defacc,
		$myrow[7],
		$_SERVER['PHP_SELF'],
		$myrow[0],
		$_SERVER['PHP_SELF'],
		$myrow[0]);

	}
	//END WHILE LIST LOOP


	echo '</table></div><br><br><br>';
}

if (isset($SelectedBankAccount)) {
	echo '<div><p><a href="' . $_SERVER['PHP_SELF'] . '?' . SID . '">' . 'Show All Bank Accounts Defined' . '</a></p></div>';
	}

echo "<form method='post' action=" . $_SERVER['PHP_SELF'] . ">";

if (isset($SelectedBankAccount) AND !isset($_GET['delete'])) {
	//editing an existing bank account  - not deleting

	$sql = "SELECT accountcode,
			bankaccountname,
			bankaccountcode,
			bankaccountnumber,
			bankaddress,
			currcode,
			invoice,
			bankbalance
		FROM bankaccounts
		WHERE bankaccounts.accountcode='$SelectedBankAccount'";

	$result = DB_query($sql, $db);
	$myrow = DB_fetch_array($result);

	$_POST['AccountCode'] = $myrow['accountcode'];
	$_POST['BankAccountName']  = $myrow['bankaccountname'];
	$_POST['BankAccountCode']  = $myrow['bankaccountcode'];
	$_POST['BankAccountNumber'] = $myrow['bankaccountnumber'];
	$_POST['BankAddress'] = $myrow['bankaddress'];
	$_POST['CurrCode'] = $myrow['currcode'];
	$_POST['DefAccount'] = $myrow['invoice'];
	$_POST['BankBalance'] = $myrow['bankbalance'];

	echo '<input type=hidden name=SelectedBankAccount VALUE=' . $SelectedBankAccount . '>'; //this is selected hidden value
	echo '<input type=hidden name=AccountCode VALUE=' . $_POST['AccountCode'] . '>';//this is selected hidden value
	
	echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Bank Account GL Code selected for Editing  :-  ';
	echo $_POST['AccountCode'];
echo '<br><br>';
// Check if details exist, if not set some defaults
if (!isset($_POST['BankAccountName'])) {
	$_POST['BankAccountName']='';
}
if (!isset($_POST['BankAccountNumber'])) {
	$_POST['BankAccountNumber']='';
}
if (!isset($_POST['BankAccountCode'])) {
        $_POST['BankAccountCode']='';
}
if (!isset($_POST['BankAddress'])) {
	$_POST['BankAddress']='';
}


       
     

}

//fetch last GLcode
							
		$glc=2030; //set the series for Glcode
		
		$sqlglcode= "SELECT accountcode FROM chartmaster where accountcode " . LIKE . " '%" . $glc . "%' ORDER BY accountcode DESC LIMIT 1";
		
		$result=DB_query($sqlglcode,$db);
		
		$myrowglcode=DB_fetch_array($result);
		
		if($myrowglcode[0]>0)
		{
			$myrowglcode['accountcode']=$myrowglcode['accountcode']+1;//Party GL Code
         }
		 else
		 {
		 $myrowglcode['accountcode']=203002;
		 }
						
			//Below is the code to create GL account code for the Party automatically for the first time

echo '<h3 style="color:#39f">Add New Bank Account</h3>';
echo '<div class="uk-width-medium-2-2" style="padding-bottom:10px" class="md-input-wrapper">';
echo '<div class="uk-grid uk-grid-width-2-2 uk-grid-width-medium-2-2">';

echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Bank Account Name';

echo '<input tabindex="2" type="Text" name="BankAccountName" value="' . $_POST['BankAccountName'] . '" class="md-input"></div>';
							
echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Bank Account Type no this
	<select tabindex="5" name="BankAccountCode" class="md-input">';
	if ($_POST['BankAccountCode']==1) {		
		echo '<option selected VALUE=savings>'.'Savings'.'</option><option value=current>'.'Current'.'</option>';		
	  }else
	  {
	  echo '<option selected VALUE=current>'.'Current'.'</option><option value=savings>'.'Savings'.'</option>';
	  }

echo '</select></div>';
		
echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Bank Account Number';		
echo '<input tabindex="3" type="Text" name="BankAccountNumber" value="' . $_POST['BankAccountNumber'] . '" class="md-input"></div>';
		
echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Bank Address';		
echo '<input tabindex="4" type="Text" name="BankAddress" value="' . $_POST['BankAddress'] . '" class="md-input"></div>';
		
echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Currency of Account
	<select tabindex="5" name="CurrCode" class="md-input">';

if (!isset($_POST['CurrCode']) OR $_POST['CurrCode']==''){
	$_POST['CurrCode'] = $_SESSION['CompanyRecord']['currencydefault'];
}
$result = DB_query('SELECT currabrev, currency FROM currencies',$db);
while ($myrow = DB_fetch_array($result)) {
	if ($myrow['currabrev']==$_POST['CurrCode']) {
		echo '<option selected VALUE=';
	} else {
		echo '<option VALUE=';
	}
	echo $myrow['currabrev'] . '>' . $myrow['currabrev'];
} //end while loop

echo '</select></div>';

echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Default for Invoices
		<select tabindex="6" name="DefAccount" class="md-input">';

if (!isset($_POST['DefAccount']) OR $_POST['DefAccount']==''){
        $_POST['DefAccount'] = $_SESSION['CompanyRecord']['currencydefault'];
}

if (isset($SelectedBankAccount)) {
	$result = DB_query('SELECT invoice FROM bankaccounts where accountcode =' . $SelectedBankAccount ,$db);
	while ($myrow = DB_fetch_array($result)) {
		if ($myrow['invoice']== 1) {
			echo '<option selected VALUE=1>'.'Yes'.'</option><option value=0>'.'No'.'</option>';
		} else {
			echo '<option selected VALUE=0>'.'No'.'</option><option value=1>'.'Yes'.'</option>';
		}
	}//end while loop
} else {
	echo '<option VALUE=1>'.'Yes'.'</option><option value=0>'.'No'.'</option>';
}

echo '</select></div>';

$SQL = 'SELECT bankaccountname,
			bankaccounts.accountcode,
			bankaccounts.currcode
		FROM bankaccounts,
			chartmaster
		WHERE bankaccounts.accountcode=chartmaster.accountcode';

$ErrMsg = _('The bank accounts could not be retrieved because');
$DbgMsg = _('The SQL used to retrieve the bank accounts was');
$AccountsResults = DB_query($SQL,$db,$ErrMsg,$DbgMsg);

echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Opening Balance Amount';		
echo '<input tabindex="4" type="Text" name="BankBalance" value="' . $_POST['BankBalance'] . '" class="md-input"></div>';

 echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Debit to<select tabindex=1 name="SourceGLcode" onChange="ReloadForm(form1.BatchInput)" class="md-input">';
		echo '<option value="204000">Cash in Hand - INR</option>';
		echo '<option value="100020">Proprietors Capital</option>';
	while ($myrow=DB_fetch_array($AccountsResults)){
		echo '<option value="' . $myrow['accountcode'] . '">' . $myrow['bankaccountname']. ' - ' . $myrow['currcode'] . '</option>';
		}
	
	echo '</select></div>';

//echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Opening Balance Amount';		
//echo '<input tabindex="4" type="Text" name="BankBalance" value="' . $_POST['BankBalance'] . '" class="md-input"></div>';

echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px"><input tabindex="7" type="Submit" name="submit" value="Save" class="md-btn md-btn-primary"></div>';

echo '</form></div></div>';

?>
