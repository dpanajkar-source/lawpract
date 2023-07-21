<?php

/* $Revision: 1.27 $ */


$title = 'General Ledger Account Inquiry';

include('includes/GLPostings.inc');

if (isset($_POST['BankAccount'])){
	$SelectedAccount = $_POST['BankAccount'];
} elseif (isset($_GET['BankAccount'])){
	$SelectedAccount = $_GET['BankAccount'];
}

if (isset($_POST['Period'])){
	$SelectedPeriod = $_POST['Period'];
} elseif (isset($_GET['Period'])){
	$SelectedPeriod = $_GET['Period'];
}


if (empty($_POST['Show'])){

echo '<div class="page_help_text">' . 'Use the keyboard Shift key to select multiple periods' . '</div><br>';

echo "<form method='POST' action=" . $_SERVER['PHP_SELF'] . '?' . SID . '>';

/*Dates in SQL format for the last day of last month*/
$DefaultPeriodDate = Date ('Y-m-d', Mktime(0,0,0,Date('m'),0,Date('Y')));

/*Show a form to allow input of criteria for TB to show */
 $SQL = 'SELECT bankaccountname,
			bankaccounts.accountcode,
			bankaccounts.currcode
		FROM bankaccounts,
			chartmaster
		WHERE bankaccounts.accountcode=chartmaster.accountcode';

$ErrMsg = 'The bank accounts could not be retrieved because';
$DbgMsg = 'The SQL used to retrieve the bank accounts was';
$AccountsResults = DB_query($SQL,$db,$ErrMsg,$DbgMsg);

 echo '<div class="uk-width-medium-1-3" style="padding-bottom:10px">Bank Account <select tabindex=1 name="BankAccount" onChange="ReloadForm(form1.BatchInput)" class="md-input">';

	while ($myrow=DB_fetch_array($AccountsResults)){
		
		echo '<option value="' . $myrow['accountcode'] . '">' . $myrow['bankaccountname']. ' - ' . $myrow['currcode'] . '</option>';
		}
	
	echo '</select></div>';

         echo '<div>'.'For Period range'.':
         <select Name=Period[] multiple class="md-input">';
	 $sql = 'SELECT periodno, lastdate_in_period FROM periods ORDER BY periodno DESC';
	 $Periods = DB_query($sql,$db);
         $id=0;
         while ($myrow=DB_fetch_array($Periods,$db)){

            if(isset($SelectedPeriod[$id]) and $myrow['periodno'] == $SelectedPeriod[$id]){
              echo '<option selected VALUE=' . $myrow['periodno'] . '>' . _(MonthAndYearFromSQLDate($myrow['lastdate_in_period']));
            $id++;
            } else {
              echo '<option VALUE=' . $myrow['periodno'] . '>' . _(MonthAndYearFromSQLDate($myrow['lastdate_in_period']));
            }

         }
         echo "</select></div>";

echo "<br><div><input type=submit class='md-btn md-btn-primary' name='Show' VALUE='".'Show Account Transactions'."'></div></form>";


}

/* End of the Form  rest of script is what happens if the show button is hit*/

if (isset($_POST['Show'])){

	if (!isset($SelectedPeriod)){
		prnMsg('A period or range of periods must be selected from the list box','info');		
		exit;
	}
	/*Is the account a balance sheet or a profit and loss account */
	$result = DB_query("SELECT pandl
				FROM accountgroups
				INNER JOIN chartmaster ON accountgroups.groupname=chartmaster.group_
				WHERE chartmaster.accountcode=$SelectedAccount",$db);
	$PandLRow = DB_fetch_row($result);
	if ($PandLRow[0]==1){
		$PandLAccount = True;
	}else{
		$PandLAccount = False; /*its a balance sheet account */
	}

	$FirstPeriodSelected = min($SelectedPeriod);
	$LastPeriodSelected = max($SelectedPeriod);

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
		AND posted=1
		AND periodno>=$FirstPeriodSelected
		AND periodno<=$LastPeriodSelected
		ORDER BY periodno, gltrans.trandate, id";


	$ErrMsg = 'The transactions for account' . ' ' . $SelectedAccount . ' ' . 'could not be retrieved because' ;
	$TransResult = DB_query($sql,$db,$ErrMsg);
	
	//select bank account name
	$sqlbankname= "SELECT bankaccountname
		FROM bankaccounts
		WHERE accountcode ='" . $SelectedAccount  ."'";
      $bankaccountnameResult = DB_query($sqlbankname,$db);
	  
	  $mybankname=DB_fetch_array($bankaccountnameResult);
	  
	  
	  
echo '<i class="md-icon material-icons" id="invoice_print">&#xE8ad;</i>';

echo '<b>' . strtoupper($mybankname['bankaccountname']) . '</b>';

echo '<table class="uk-table">';
 
	$TableHeader = "<tr>
			<th>" . 'Type' . "</th>
			<th>" . 'Trans No' . "</th>
			<th>" . 'Date' . "</th>
			<th>" . 'Debit' . "</th>
			<th>" . 'Credit' . "</th>
			<th>" . 'Narrative' . "</th>
			
			</tr>";

	echo $TableHeader;

	if ($PandLAccount==True) {
		$RunningTotal = 0;
	} else {
	       // added to fix bug with Brought Forward Balance always being zero
					$sql = "SELECT bfwd,
						actual,
						period
					FROM chartdetails
					WHERE chartdetails.accountcode= $SelectedAccount
					AND chartdetails.period=" . $FirstPeriodSelected;

				$ErrMsg = 'The chart details for account' . ' ' . $SelectedAccount . ' ' . 'could not be retrieved';
				$ChartDetailsResult = DB_query($sql,$db,$ErrMsg);
				$ChartDetailRow = DB_fetch_array($ChartDetailsResult);
				// --------------------

		$RunningTotal =$ChartDetailRow['bfwd'];
		if ($RunningTotal < 0 ){ //its a credit balance b/fwd
			echo "<tr bgcolor='#FDFEEF'>
				<td colspan=3><b>" . 'Brought Forward Balance' . '</b><td>
				</td></td>
				</td></td>
				</td></td>
				<td class=number><b>' . number_format(-$RunningTotal,2) . '</b></td>
				<td></td>
				</tr>';
		} else { //its a debit balance b/fwd
			echo "<tr bgcolor='#FDFEEF'>
				<td colspan=3><b>" . 'Brought Forward Balance' . '</b></td>
				</td></td>
				</td></td>
				</td></td>
				<td class=number><b>' . number_format($RunningTotal,2) . '</b></td>
				<td colspan=2></td>
				</tr>';
		}
	}
	$PeriodTotal = 0;
	$PeriodNo = -9999;
	$ShowIntegrityReport = False;
	$j = 1;
	$k=0; //row colour counter
    
    
	while ($myrow=DB_fetch_array($TransResult)) {
        
       

		if ($myrow['periodno']!=$PeriodNo){
			if ($PeriodNo!=-9999){ //ie its not the first time around
				/*Get the ChartDetails balance b/fwd and the actual movement in the account for the period as recorded in the chart details - need to ensure integrity of transactions to the chart detail movements. Also, for a balance sheet account it is the balance carried forward that is important, not just the transactions*/

				$sql = "SELECT bfwd,
						actual,
						period
					FROM chartdetails
					WHERE chartdetails.accountcode= $SelectedAccount
					AND chartdetails.period=" . $PeriodNo;

				$ErrMsg = 'The chart details for account' . ' ' . $SelectedAccount . ' ' . 'could not be retrieved';
				$ChartDetailsResult = DB_query($sql,$db,$ErrMsg);
				$ChartDetailRow = DB_fetch_array($ChartDetailsResult);

				echo "<tr bgcolor='#FDFEEF'>
					<td colspan=3><b>" . 'Total for period' . ' ' . $PeriodNo . '</b></td>';
				if ($PeriodTotal < 0 ){ //its a credit balance b/fwd
					echo '<td></td>
						<td class=number><b>' . number_format(-$PeriodTotal,2) . '</b></td>
						<td></td>
						</tr>';
				} else { //its a debit balance b/fwd
					echo '<td class=number><b>' . number_format($PeriodTotal,2) . '</b></td>
						<td colspan=2></td>
						</tr>';
				}
				$IntegrityReport .= '<br>' . 'Period' . ': ' . $PeriodNo  . 'Account movement per transaction' . ': '  . number_format($PeriodTotal,2) . ' ' . 'Movement per ChartDetails record' . ': ' . number_format($ChartDetailRow['actual'],2) . ' ' . 'Period difference' . ': ' . number_format($PeriodTotal -$ChartDetailRow['actual'],3);

				if (ABS($PeriodTotal -$ChartDetailRow['actual'])>0.01){
					$ShowIntegrityReport = True;
				}
			}
			$PeriodNo = $myrow['periodno'];
			$PeriodTotal = 0;
		}

		if ($k==1){
			echo '<tr class="EvenTableRows">';
			$k=0;
		} else {
			echo '<tr class="OddTableRows">';
			$k++;
		}

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
		$URL_to_TransDetail = $rootpath . '/lw_gltransinquiry_alt.php?' . SID . '&TypeID=' . $myrow['type'] . '&TransNo=' . $myrow['typeno'];

	
	
		
		printf("<td>%s</td>
			<td class=number><b><a href='%s'>%s</a></b></td>
			<td>%s</td>
			<td class=number>%s</td>
			<td class=number>%s</td>
			<td>%s</td>
			
			</tr>",
			$myrow['typename'],
			$URL_to_TransDetail,
			$myrow['typeno'],
			$FormatedTranDate,
			$DebitAmount,
			$CreditAmount,
			$myrow['narrative']);

	}

	echo "<tr bgcolor='#FDFEEF'><td colspan=3><b>";
	if ($PandLAccount==True){
		echo 'Total Period Movement';
	} else { /*its a balance sheet account*/
		echo 'Balance C/Fwd';
	}
	echo '</b></td>';

	if ($RunningTotal >0){
		echo '<td align=right colspan=3><b>' . number_format(($RunningTotal),2) . '</b></td><td colspan=2></td></tr>';
	}else {
		echo '<td></td><td align=right colspan=3><b>' . number_format((-$RunningTotal),2) . '</b></td><td colspan=2></td></tr>';
	}
	echo '</table>';
} /* end of if Show button hit */



if (isset($ShowIntegrityReport) and $ShowIntegrityReport==True){
	if (!isset($IntegrityReport)) {$IntegrityReport='';}
	prnMsg( 'There are differences between the sum of the transactions and the recorded movements in the ChartDetails table' . '. ' . 'A log of the account differences for the periods report shows below','warn');
	echo '<p>'.$IntegrityReport;
}

?>
