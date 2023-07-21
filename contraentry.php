<?php

	if (isset($_GET['NewJournal']) and $_GET['NewJournal'] == 'Yes' AND isset($_SESSION['JournalDetail'])){
	unset($_SESSION['JournalDetail']->GLEntries);
	unset($_SESSION['JournalDetail']);
}

	if (!isset($_SESSION['JournalDetail'])){
	$_SESSION['JournalDetail'] = new Journal;

	/* Make an array of the defined bank accounts - better to make it now than do it each time a line is added
	Journals cannot be entered against bank accounts GL postings involving bank accounts must be done using
	a receipt or a payment transaction to ensure a bank trans is available for matching off vs statements */

	$SQL = 'SELECT accountcode FROM bankaccounts';
	$result = DB_query($SQL,$db);
	$i=0;
	while ($Act = DB_fetch_row($result))
	{
		$_SESSION['JournalDetail']->BankAccounts[$i]= $Act[0];
		$i++;
	}
	}
	
	

	if (isset($_POST['JournalProcessDate'])){
	$_SESSION['JournalDetail']->JnlDate=$_POST['JournalProcessDate'];
	

	if (!isset($_POST['JournalProcessDate'])){

prnMsg('The date entered was not valid please enter the date to process the entry in the format'. $_SESSION['DefaultDateFormat'],'warn');
		$_POST['CommitBatch']='Do not do it the date is wrong';
	}
	}
	

	if (isset($_POST['JournalType'])){
	$_SESSION['JournalDetail']->JournalType = $_POST['JournalType'];
	}
	$msg='';

	if (isset($_POST['CommitBatch']) and $_POST['CommitBatch']=='Accept and Process Entry'){

 	/* once the GL analysis of the journal is entered
 	 process all the data in the session cookie into the DB
  	A GL entry is created for each GL entry
	*/

	/*Start a transaction to do the whole lot inside */
	$result = DB_Txn_Begin($db);

	$TransNo = GetNextTransNo( 0, $db);
	
	$PeriodNo = GetPeriod(Date('d/m/Y'),$db);
	
	foreach ($_SESSION['JournalDetail']->GLEntries as $JournalItem) {
		$SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount,
						tag) ';
		$SQL= $SQL . 'VALUES (0,
					' . $TransNo . ",
					'" . FormatDateForSQL($_SESSION['JournalDetail']->JnlDate) . "',
					" . $PeriodNo . ",
					" . $JournalItem->GLCode . ",
					'" . $JournalItem->Narrative . "',
					" . $JournalItem->Amount . ",'".$JournalItem->tag."')"; 
		$ErrMsg = 'Cannot insert a Accounts entry for the GL line because';
		$DbgMsg = 'The SQL that failed to insert the GL Trans record was';
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);

		if ($_POST['JournalType']=='Reversing'){
			$SQL = 'INSERT INTO gltrans (type,
							typeno,
							trandate,
							periodno,
							account,
							narrative,
							amount,
							tag)';
			$SQL= $SQL . 'VALUES (0,
						' . $TransNo . ",
						'" . FormatDateForSQL($_SESSION['JournalDetail']->JnlDate) . "',
						" . ($PeriodNo + 1) . ",
						" . $JournalItem->GLCode . ",
						'Reversal - " . $JournalItem->Narrative . "',
						" . -($JournalItem->Amount) .
					",'".$JournalItem->tag."')";

			$ErrMsg ='Cannot insert a Accounts entry for the reversing because';
			$DbgMsg = 'The SQL that failed to insert the GL Trans record was';
			$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);

		}
	}


	$ErrMsg = 'Cannot commit the changes';
	$result= DB_Txn_Begin($db);

	prnMsg('Entry'.' ' . $TransNo . ' '.'has been successfully entered','success');

	unset($_POST['JournalProcessDate']);
	unset($_POST['JournalType']);
	unset($_SESSION['JournalDetail']->GLEntries);
	unset($_SESSION['JournalDetail']);

	/*Set up a newy in case user wishes to enter another */
	echo "<br><a href='" . $_SERVER['PHP_SELF'] . '?' . SID . "&NewJournal=Yes'>".'Enter Another General Ledger Transaction'.'</a>';
	/*And post the journal too */
	include ('includes/GLPostings.inc');
	exit;

	} elseif (isset($_GET['Delete'])){

	/* User hit delete the line from the journal */
	$_SESSION['JournalDetail']->Remove_GLEntry($_GET['Delete']);

	} elseif (isset($_POST['Process']) and $_POST['Process']=='Accept'){ //user hit submit a new GL Analysis line into the journal
	if($_POST['GLCode']!='')
	{
		$extract = explode(' - ',$_POST['GLCode']);
		$_POST['GLCode'] = $extract[0];
	}
	if($_POST['Debit']>0)
	{
		$_POST['GLAmount'] = $_POST['Debit'];
	}
	elseif($_POST['Credit']>0)
	{
		$_POST['GLAmount'] = '-' . $_POST['Credit'];
	}
	if ($_POST['GLManualCode'] != '' AND is_numeric($_POST['GLManualCode'])){
				// If a manual code was entered need to check it exists and isnt a bank account
        //we need to do this for cash also as CA said that cash entry cannot be done in journal
	$AllowThisPosting = true; //by default
		
		if ($AllowThisPosting) {
			$SQL = 'SELECT accountname
							FROM chartmaster
							WHERE accountcode=' . $_POST['GLManualCode'];
			$Result=DB_query($SQL,$db);

			if (DB_num_rows($Result)==0){
			prnMsg('The manual GL code entered does not exist in the database' . ' - ' . 'so this GL analysis item could not be added. Please
			create GL account first to use','warn');
			unset($_POST['GLManualCode']);
			} else {
				$myrow = DB_fetch_array($Result);
				$_SESSION['JournalDetail']->add_to_glanalysis($_POST['GLAmount'], $_POST['GLNarrative'], $_POST['GLManualCode'], $myrow['accountname'],	$_POST['tag']);
			}
		}
	} else {
		$AllowThisPosting =true; //by default
		
		if ($AllowThisPosting){
			if (!isset($_POST['GLAmount'])) {
				$_POST['GLAmount']=0;
			}
			$SQL = 'SELECT accountname FROM chartmaster WHERE accountcode=' . $_POST['GLCode'];
			$Result=DB_query($SQL,$db);
			$myrow=DB_fetch_array($Result);
			$_SESSION['JournalDetail']->add_to_glanalysis($_POST['GLAmount'], $_POST['GLNarrative'], $_POST['GLCode'], $myrow['accountname'], $_POST['tag']);
		}
	}

	/*Make sure the same receipt is not double processed by a page refresh */
	$Cancel = 1;
	unset($_POST['Credit']);
	unset($_POST['Debit']);
	unset($_POST['tag']);
	unset($_POST['GLManualCode']);
	unset($_POST['GLNarrative']);
}

if (isset($Cancel)){
	unset($_POST['Credit']);
	unset($_POST['Debit']);
	unset($_POST['GLAmount']);
	unset($_POST['GLCode']);
	unset($_POST['tag']);
	unset($_POST['GLManualCode']);
}

// set up the form whatever


echo '<form action=' . $_SERVER['PHP_SELF'] . '?' . SID . ' method="post" name="form">';

// below table changes style of complete form ------------------------------------------>

echo '<div class="uk-form-row">
        <div class="uk-grid">';
	echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px">';
	?>Enter Date
<input type='text' class='md-input' name='JournalProcessDate' id='JournalProcessDate' data-uk-datepicker="{format:'DD/MM/YYYY'}" value="<?php echo $_SESSION['JournalDetail']->JnlDate; ?>"></div>
	<?php

		echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px"></div><div class="uk-width-medium-1-4" style="padding-bottom:10px"></div><div class="uk-width-medium-1-4" style="padding-bottom:10px"></div>';
	
	/* close off the table in the first column  */
	echo '<table border=0 width=10% align="left">';
	/* Set upthe form for the transaction entry for a GL Payment Analysis item */

	/*now set up a GLCode field to select from avaialble GL accounts */
	//echo '<tr><th>' . 'GL Tag' . '</th>';


/* Set up form for the transaction entry for a GL Payment Analysis item */


	//Select the tag
	echo '<tr><td><select name="tag" style="visibility:hidden">';

	$SQL = 'SELECT tagref,
				tagdescription
		FROM tags
		ORDER BY tagref';

	$result=DB_query($SQL,$db);
	echo '<option value=0>0 - None';
	while ($myrow=DB_fetch_array($result)){
		if (isset($_POST['tag']) and $_POST['tag']==$myrow['tagref']){
			echo '<option selected value=' . $myrow['tagref'] . '>' . $myrow['tagref'].' - ' .$myrow['tagdescription'];
		} else {
			echo '<option value=' . $myrow['tagref'] . '>' . $myrow['tagref'].' - ' .$myrow['tagdescription'];
		}
	}
	echo '</select></td></tr>';
// End select tag


	$sql='SELECT accountcode,
				accountname
			FROM chartmaster WHERE accountcode!="203001" AND group_="Cash at Bank" OR group_="Cash in Hand" ORDER BY accountcode';

	$result=DB_query($sql, $db);
	echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">A/c Name';
	echo '<select name="GLCode" onChange="return assignComboToInput(this,'.'GLManualCode'.')" class="md-input">';
	while ($myrow=DB_fetch_array($result)){
		if (isset($_POST['tag']) and $_POST['tag']==$myrow['accountcode']){
			echo '<option selected value=' . $myrow['accountcode'] . '>' . $myrow['accountcode'].' - ' .$myrow['accountname'];
		} else {
			echo '<option value=' . $myrow['accountcode'] . '>' . $myrow['accountcode'].' - ' .$myrow['accountname'];
		}
	}
	echo '</select></div>';
		echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px"></div>';
	if (!isset($_POST['GLNarrative'])) {
		$_POST['GLNarrative'] = '';
	}
	if (!isset($_POST['Credit'])) {
		$_POST['Credit'] = '';
	}
	if (!isset($_POST['Debit'])) {
		$_POST['Debit'] = '';
	}
	
	


	echo ' <div class="uk-width-medium-1-3" style="padding-bottom:10px">
	Debit<input type=Text class="md-input" Name = "Debit" ' . 'onChange="eitherOr(this, '.'Credit'.')"'.' value=' . $_POST['Debit'] . '></div>';
				
echo '<div class="uk-width-medium-1-3" style="text-align:center; margin-top:20px"><h3>OR</h3></div>';

	echo ' <div class="uk-width-medium-1-3" style="padding-bottom:10px">Credit<input type=Text class="md-input" Name = "Credit" ' . 'onChange="eitherOr(this, '.'Debit'.')"'.' value=' . $_POST['Credit'] . '></div>';
	
	echo ' <div class="uk-width-medium-2-2" style="padding-bottom:10px">Narrative<input type="text" name="GLNarrative" class="md-input" maxlength=60 size=60 value="' . $_POST['GLNarrative'] . '"></div>';

		
	echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px"><input type=submit name=Process  class="md-btn md-btn-primary" value="Accept"></div></div></div>';


echo "<table style='text-align:center; margin-left:50px; width:1000px' border=1 class='uk-table'>
					<tr>
						<th>".'GL Tag'."</th>
						<th>".'GL Account'."</th>
						<th>".'Debit'."</th>
						<th>".'Credit'."</th>
						<th>".'Narrative'.'</th><td></td></tr>';

						$debittotal=0;
						$credittotal=0;
						$j=0;

						foreach ($_SESSION['JournalDetail']->GLEntries as $JournalItem) {
								if ($j==1) {
									echo '<tr class="OddTableRows">';
									$j=0;
								} else {
									echo '<tr class="EvenTableRows">';
									$j++;
								}
							$sql='SELECT tagdescription ' .
									'FROM tags ' .
									'WHERE tagref='.$JournalItem->tag;
							$result=DB_query($sql, $db);
							$myrow=DB_fetch_row($result);
							if ($JournalItem->tag==0) {
								$tagdescription='None';
							} else {
								$tagdescription=$myrow[0];
							}
							echo "<td>" . $JournalItem->tag . ' - ' . $tagdescription . "</td>";
							echo "<td>" . $JournalItem->GLCode . ' - ' . $JournalItem->GLActName . "</td>";
								if($JournalItem->Amount>0)
								{
								echo "<td class='number'>" . number_format($JournalItem->Amount,2) . '</td><td></td>';
								$debittotal=$debittotal+$JournalItem->Amount;
								}
								elseif($JournalItem->Amount<0)
								{
									$credit=(-1 * $JournalItem->Amount);
								echo "<td></td>
										<td class='number'>" . number_format($credit,2) . '</td>';
								$credittotal=$credittotal+$credit;
								}

							echo '<td>' . $JournalItem->Narrative  . "</td>
									<td><a href='" . $_SERVER['PHP_SELF'] . '?' . SID . '&Delete=' . $JournalItem->ID . "'>".'Delete'.'</a></td>
							</tr>';
						}

			echo '<tr class="EvenTableRows"><td></td>
					<td align=right><b> Total </b></td>
					<td align=right class="number"><b>' . number_format($debittotal,2) . '</b></td>
					<td align=right class="number"><b>' . number_format($credittotal,2) . '</b></td>';
			if ($debittotal!=$credittotal) {
				echo '<td align=center style="background-color: #fddbdb"><b>Required to balance - ' .
					number_format(abs($debittotal-$credittotal),2);
			}
			if ($debittotal>$credittotal) {echo ' Credit';} else if ($debittotal<$credittotal) {echo ' Debit';}
			echo '</b></td><td></td><td></td></table></td></table>';

if (ABS($_SESSION['JournalDetail']->JournalTotal)<0.001 AND $_SESSION['JournalDetail']->GLItemCounter > 0){
	echo "<br><br><div class='centre'><input type=submit name='CommitBatch' value='".'Accept and Process Entry'."' class='md-btn md-btn-primary'></div></div>";
} elseif(count($_SESSION['JournalDetail']->GLEntries)>0) {
	echo '<br><br>';
	prnMsg('The Entry must balance ie debits equal to credits before it can be processed','warn');
}

if (!isset($_GET['NewJournal']) or $_GET['NewJournal']=='') {
	echo "<script>defaultControl(document.form.GLManualCode);</script>";
} else {
	echo "<script>defaultControl(document.form.JournalProcessDate);</script>";
}

echo '</form>';

?>