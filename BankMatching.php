<?php
/* $Revision: 1.23 $ */

echo '<div id="form_containerbankmatch">';

echo '<form method="post" action=' . $_SERVER['PHP_SELF'] . '>';

if ((isset($_GET["Type"]) and $_GET["Type"]=='Receipts') OR (isset($_POST["Type"]) and $_POST["Type"]=='Receipts')){
	$Type = 'Receipts';
	$TypeName ='Receipts';
echo '<p><label2>'. 'Bank Account Matching - Receipts' . '</label2></p>';
} elseif ((isset($_GET["Type"]) and $_GET["Type"]=='Payments') OR (isset($_POST["Type"]) and $_POST["Type"]=='Payments')) {
	$Type = 'Payments';
	$TypeName ='Payments';
echo '<p><label2>' . 'Bank Account Matching - Payments' . '</label2></p>';
} else {
	prnMsg('This page must be called with a bank transaction type' . '. ' . 'It should not be called directly','error');
	
	exit;
}

if (isset($_POST['Update']) AND $_POST['RowCounter']>1){
	for ($Counter=1;$Counter <= $_POST['RowCounter']; $Counter++){
		if (isset($_POST["Clear_" . $Counter]) and $_POST["Clear_" . $Counter]==True){
			/*Get amount to be cleared */
			$sql = "SELECT amount, 
						exrate 
					FROM banktrans
					WHERE banktransid=" . $_POST["BankTrans_" . $Counter];
			$ErrMsg =  'Could not retrieve transaction information';
			$result = DB_query($sql,$db,$ErrMsg);
			$myrow=DB_fetch_array($result);
			$AmountCleared = round($myrow[0] / $myrow[1],2);
			/*Update the banktrans recoord to match it off */
			$sql = "UPDATE banktrans SET amountcleared= ". $AmountCleared .
					" WHERE banktransid=" . $_POST["BankTrans_" . $Counter];
			$ErrMsg =  'Could not match off this payment because';
			$result = DB_query($sql,$db,$ErrMsg);

		} elseif (isset($_POST["AmtClear_" . $Counter]) and is_numeric((float) $_POST["AmtClear_" . $Counter]) AND 
			((isset($_POST["AmtClear_" . $Counter]) and $_POST["AmtClear_" . $Counter]<0 AND $Type=='Payments') OR 
			($Type=='Receipts' AND (isset($_POST["AmtClear_" . $Counter]) and $_POST["AmtClear_" . $Counter]>0)))){
			/*if the amount entered was numeric and negative for a payment or positive for a receipt */
			$sql = "UPDATE banktrans SET amountcleared=" .  $_POST["AmtClear_" . $Counter] . "
					 WHERE banktransid=" . $_POST["BankTrans_" . $Counter];

			$ErrMsg = 'Could not update the amount matched off this bank transaction because';
			$result = DB_query($sql,$db,$ErrMsg);

		} elseif (isset($_POST["Unclear_" . $Counter]) and $_POST["Unclear_" . $Counter]==True){
			$sql = "UPDATE banktrans SET amountcleared = 0
					 WHERE banktransid=" . $_POST["BankTrans_" . $Counter];
			$ErrMsg =  'Could not unclear this bank transaction because';
			$result = DB_query($sql,$db,$ErrMsg);
		}
	}
	/*Show the updated position with the same criteria as previously entered*/
	$_POST["ShowTransactions"] = True;
}
 ?>
 <div class="uk-width-medium-1-1" style="padding-bottom:0px">
        <div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">
         
        <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-2-2">
        <div class="uk-form-row">
        <div class="uk-grid">
		<?php

echo '<div class="uk-width-medium-1-1" style="padding-bottom:10px">Check your bank statement and click the check-box when you find the matching transaction</div>';

echo "<form action='". $_SERVER['PHP_SELF'] . "?" . SID . "' method=post><input type=hidden Name=Type Value=$Type>";

echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px">Bank Account</div>';
echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px"><select tabindex="1" name="BankAccount" class="md-input">';

$sql = "SELECT accountcode, bankaccountname FROM bankaccounts";
$resultBankActs = DB_query($sql,$db);
while ($myrow=DB_fetch_array($resultBankActs)){
	if (isset($_POST['BankAccount']) and $myrow["accountcode"]==$_POST['BankAccount']){
		echo "<option selected Value='" . $myrow['accountcode'] . "'>" . $myrow['bankaccountname'];
	} else {
		echo "<option Value='" . $myrow['accountcode'] . "'>" . $myrow['bankaccountname'];
	}
}

echo '</select></div>';

if (!isset($_POST['BeforeDate']) OR !Is_Date($_POST['BeforeDate'])){
	$_POST['BeforeDate'] = Date($_SESSION['DefaultDateFormat']);
}
if (!isset($_POST['AfterDate']) OR !Is_Date($_POST['AfterDate'])){
	$_POST['AfterDate'] = Date($_SESSION['DefaultDateFormat'], Mktime(0,0,0,Date("m")-3,Date("d"),Date("y")));
}

// Change to allow input of FROM DATE and then TO DATE, instead of previous back-to-front method, add datepicker

echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px; padding-top:10px"></div>';
echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px; padding-top:10px"></div>';
//echo '<h3>' . 'Show' . ' ' . $TypeName . ' ' . 'from' . ':</h3>';

		echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px">After Date </div><div class="uk-width-medium-1-4" style="padding-bottom:10px"><input class="md-input" tabindex="10" type="text" id="AfterDate" name="AfterDate" value="' . $_POST['AfterDate'] . '" data-uk-datepicker="{format:\'DD/MM/YYYY\'}"</div></div>';
		

		

		
		
		
		
echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px">' . 'Choose outstanding' . ' ' . $TypeName . ' ' . 'Options' . '</div>'; 
echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px"><select tabindex="4" name="Ostg_or_All" class="md-input">';

if ($_POST["Ostg_or_All"]=='All'){
	echo '<option selected Value="All">' . 'Show all' . ' ' . $TypeName . ' ' . 'in the date range';
	echo '<option Value="Ostdg">' . 'Show unmatched' . ' ' . $TypeName . ' ' . 'only';
} else {
	echo '<option Value="All">' . 'Show all' . ' ' . $TypeName . ' ' . 'in the date range';
	echo '<option selected Value="Ostdg">' . 'Show unmatched' . ' ' . $TypeName . ' ' . 'only';
}
echo '</select></div>';

echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px">Before Date </div><div class="uk-width-medium-1-4" style="padding-bottom:10px"><input class="md-input" tabindex="10" type="text" id="BeforeDate" name="BeforeDate" value="' . $_POST['BeforeDate'] . '" data-uk-datepicker="{format:\'DD/MM/YYYY\'}"></div>';


echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px">' . 'Choose only first 20' . ' ' . $TypeName . ' ' .
	'or all' . '</div>';
	echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px"><select tabindex="5" name="First20_or_All" class="md-input">';
if ($_POST["First20_or_All"]=='All'){
	echo '<option selected Value="All">' . 'Show all' . ' ' . $TypeName . ' ' . 'in the date range';
	echo '<option Value="First20">' . 'Show only the first 20' . ' ' . $TypeName;
} else {
	echo '<option Value="All">' . 'Show all' . ' ' . $TypeName . ' ' . 'in the date range';
	echo '<option selected Value="First20">' . 'Show only the first 20' . ' ' . $TypeName;
}
echo '</select></div>';


echo '<div class="uk-width-medium-1-2" style="padding-bottom:20px; padding-top:20px"><input tabindex="6" type=submit name="ShowTransactions" class="md-btn md-btn-primary" VALUE="' . 'Show selected' . ' ' . $TypeName . '"></div>';

echo '</div></div></div></div></div></div>';


$InputError=0;
if (!Is_Date($_POST['BeforeDate'])){
	$InputError =1;
	prnMsg('The date entered for the field to show' . ' ' . $TypeName . ' ' . 'before' . ', ' .
		'is not entered in a recognised date format' . '. ' . 'Entry is expected in the format' . ' ' .
		$_SESSION['DefaultDateFormat'],'error');
}
if (!Is_Date($_POST['AfterDate'])){
	$InputError =1;
	prnMsg( 'The date entered for the field to show' . ' ' . $Type . ' ' . 'after' . ', ' . 
		'is not entered in a recognised date format' . '. ' . 'Entry is expected in the format' . ' ' .
		$_SESSION['DefaultDateFormat'],'error');
}

if ($InputError !=1 AND isset($_POST["BankAccount"]) AND $_POST["BankAccount"]!="" AND isset($_POST["ShowTransactions"])){

	$SQLBeforeDate = FormatDateForSQL($_POST['BeforeDate']);
	$SQLAfterDate = FormatDateForSQL($_POST['AfterDate']);

	if ($_POST["Ostg_or_All"]=='All'){
		if ($Type=='Payments'){
			$sql = "SELECT banktransid,
					ref,
					amountcleared,
					transdate,
					amount/exrate as amt,
					banktranstype,
					chequeno
				FROM banktrans
				WHERE type=13
				AND transdate >= '". $SQLAfterDate . "'
				AND transdate <= '" . $SQLBeforeDate . "'
				AND bankact=" .$_POST["BankAccount"] . "
				ORDER BY transdate";

		} else { /* Type must == Receipts */
			$sql = "SELECT banktransid,
					ref,
					amountcleared,
					transdate,
					amount/exrate as amt,
					banktranstype,
					chequeno
				FROM banktrans
				WHERE type=12
				AND transdate >= '". $SQLAfterDate . "'
				AND transdate <= '" . $SQLBeforeDate . "'
				AND bankact=" .$_POST['BankAccount'] . "
				ORDER BY transdate";
		}
	} else { /*it must be only the outstanding bank trans required */
		if ($Type=='Payments'){
			$sql = "SELECT banktransid,
					ref,
					amountcleared,
					transdate,
					amount/exrate as amt,
					banktranstype,
					chequeno
				FROM banktrans
				WHERE type=13
				AND transdate >= '". $SQLAfterDate . "'
				AND transdate <= '" . $SQLBeforeDate . "'
				AND bankact=" .$_POST["BankAccount"] . "
				AND  ABS(amountcleared - (amount / exrate)) > 0.009
				ORDER BY transdate";
		} else { /* Type must == Receipts */
			$sql = "SELECT banktransid,
					ref,
					amountcleared,
					transdate,
					amount/exrate as amt,
					banktranstype,
					chequeno
				FROM banktrans
				WHERE type=12
				AND transdate >= '". $SQLAfterDate . "'
				AND transdate <= '" . $SQLBeforeDate . "'
				AND bankact=" .$_POST["BankAccount"] . "
				AND  ABS(amountcleared - (amount / exrate)) > 0.009
				ORDER BY transdate";
		}
	}
	if ($_POST["First20_or_All"]!='All'){
		$sql = $sql . " LIMIT 20";
	}

	$ErrMsg = 'The payments with the selected criteria could not be retrieved because';
	$PaymentsResult = DB_query($sql, $db, $ErrMsg);

	$TableHeader = '<tr><th>'. 'Ref'. '</th>
			<th>' . $TypeName . '</th>
			<th>' . 'Cheque No' . '</th>
			<th>' . 'Date' . '</th>
			<th>' . 'Amount' . '</th>
			<th>' . 'Outstanding' . '</th>
			<th colspan=3>' . 'Clear' . ' / ' . 'Unclear' . '</th>
		</tr>';
		
	echo '<div style="overflow:auto; height=100px"><table class="uk-table" style="margin-left:0px">' . $TableHeader;


	$j = 1;  //page length counter
	$k=0; //row colour counter
	$i = 1; //no of rows counter

	while ($myrow=DB_fetch_array($PaymentsResult)) {

		$DisplayTranDate = ConvertSQLDate($myrow['transdate']);
		$Outstanding = $myrow['amt']- $myrow['amountcleared'];
		if (ABS($Outstanding)<0.009){ /*the payment is cleared dont show the check box*/

			printf("<tr bgcolor='#CCCEEE'>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td class=number>%s</td>
				<td class=number>%s</td>
				<td class=number>%s</td>
				<td colspan=2>%s</td>
				<td><input type='checkbox' name='Unclear_%s'><input type=hidden name='BankTrans_%s' VALUE=%s></td>
				</tr>",
				$myrow['ref'],
				$myrow['banktranstype'],
				$myrow['chequeno'],
				$DisplayTranDate,
				number_format($myrow['amt'],2),
				number_format($Outstanding,2),
				'Unclear',
				$i,
				$i,
				$myrow['banktransid']);

		} else{
			if ($k==1){
				echo '<tr class="EvenTableRows">';
				$k=0;
			} else {
				echo '<tr class="OddTableRows">';
				$k=1;
			}

			printf("<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td class=number>%s</td>
				<td class=number>%s</td>
				<td class=number>%s</td>
				<td><input type='checkbox' name='Clear_%s'><input type=hidden name='BankTrans_%s' VALUE=%s></td>
				<td colspan=2><input type='text' class='md-input' name='AmtClear_%s' placeholder='Enter Amount to clear'></td>
				</tr>",
				$myrow['ref'],
				$myrow['banktranstype'],
				$myrow['chequeno'],
				$DisplayTranDate,
				number_format($myrow['amt'],2),
				number_format($Outstanding,2),
				$i,
				$i,
				$myrow['banktransid'],
				$i
			);
		}

		$j++;
		If ($j == 12){
			$j=1;
			echo $TableHeader;
		}
	//end of page full new headings if
		$i++;
	}
	//end of while loop

echo '</table>';
	
echo '<div class="uk-width-medium-1-2" style="padding-bottom:20px; padding-top:20px"><input type=hidden name="RowCounter" value=' . $i . '><input type=submit name="Update" class="md-btn md-btn-primary" VALUE="' . 'Update Matching' . '"></div>';

}
echo '<div class="uk-width-medium-1-2" style="padding-bottom:20px; padding-top:20px">';
echo '<a href="lw_bankreconciliation_alt.php?"' . SID . "'>" . 'Show Reconciliation' . '</a>';
echo '</div>';
echo '</form>';


?>