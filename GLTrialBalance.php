<?php

/* $Revision: 1.20 $ */

/*Through deviousness and cunning, this system allows trial balances for any date range that recalcuates the p & l balances
and shows the balance sheets as at the end of the period selected - so first off need to show the input of criteria screen
while the user is selecting the criteria the system is posting any unposted transactions */

include('includes/AccountSectionsDef.inc'); //this reads in the Accounts Sections array


if (isset($_POST['FromPeriod']) and isset($_POST['ToPeriod']) and $_POST['FromPeriod'] > $_POST['ToPeriod']){
	prnMsg(_('The selected period from is actually after the period to! Please re-select the reporting period'),'error');
	$_POST['SelectADifferentPeriod']=_('Select A Different Period');
}

if ((! isset($_POST['FromPeriod']) AND ! isset($_POST['ToPeriod'])) OR isset($_POST['SelectADifferentPeriod'])){

	//include  ('includes/header.php');
	echo '<form method="POST" action="' . $_SERVER['PHP_SELF'] . '?' . SID . '">';
	
	if (Date('m') > $_SESSION['YearEnd']){
		/*Dates in SQL format */
		$DefaultFromDate = Date ('Y-m-d', Mktime(0,0,0,$_SESSION['YearEnd'] + 2,0,Date('Y')));
		$FromDate = Date($_SESSION['DefaultDateFormat'], Mktime(0,0,0,$_SESSION['YearEnd'] + 2,0,Date('Y')));
	} else {
		$DefaultFromDate = Date ('Y-m-d', Mktime(0,0,0,$_SESSION['YearEnd'] + 2,0,Date('Y')-1));
		$FromDate = Date($_SESSION['DefaultDateFormat'], Mktime(0,0,0,$_SESSION['YearEnd'] + 2,0,Date('Y')-1));
	}
	$period=GetPeriod($FromDate, $db);
	

	/*Show a form to allow input of criteria for TB to show */
   
	echo '<div class="uk-overflow-container">';
   	echo 'Select Period From:<select Name="FromPeriod" data-md-selectize>';
	$nextYear = date("Y-m-d",strtotime("+1 Year"));
	$sql = "SELECT periodno, lastdate_in_period FROM periods where lastdate_in_period < '$nextYear' ORDER BY periodno DESC";
	$Periods = DB_query($sql,$db);


	while ($myrow=DB_fetch_array($Periods,$db)){
		if(isset($_POST['FromPeriod']) AND $_POST['FromPeriod']!=''){
			if( $_POST['FromPeriod']== $myrow['periodno']){
				echo '<option selected VALUE="' . $myrow['periodno'] . '">' .MonthAndYearFromSQLDate($myrow['lastdate_in_period']);
			} else {
				echo '<option VALUE="' . $myrow['periodno'] . '">' . MonthAndYearFromSQLDate($myrow['lastdate_in_period']);
			}
		} else {
			if($myrow['lastdate_in_period']==$DefaultFromDate){
				echo '<option selected VALUE="' . $myrow['periodno'] . '">' . MonthAndYearFromSQLDate($myrow['lastdate_in_period']);
			} else {
				echo '<option VALUE="' . $myrow['periodno'] . '">' . MonthAndYearFromSQLDate($myrow['lastdate_in_period']);
			}
		}
	}

	echo '</select>';
	if (!isset($_POST['ToPeriod']) OR $_POST['ToPeriod']==''){
		$lastDate = date("Y-m-d",mktime(0,0,0,Date('m')+1,0,Date('Y')));
		$sql = "SELECT periodno FROM periods where lastdate_in_period = '$lastDate'";
		$MaxPrd = DB_query($sql,$db);
		$MaxPrdrow = DB_fetch_row($MaxPrd);
		$DefaultToPeriod = (int) ($MaxPrdrow[0]);

	} else {
		$DefaultToPeriod = $_POST['ToPeriod'];
	}

	echo 'Select Period To:<select Name="ToPeriod" data-md-selectize>';

	$RetResult = DB_data_seek($Periods,0);

	while ($myrow=DB_fetch_array($Periods,$db)){

		if($myrow['periodno']==$DefaultToPeriod){
			echo '<option selected VALUE="' . $myrow['periodno'] . '">' . MonthAndYearFromSQLDate($myrow['lastdate_in_period']);
		} else {
			echo '<option VALUE ="' . $myrow['periodno'] . '">' . MonthAndYearFromSQLDate($myrow['lastdate_in_period']);
		}
	}
	echo '</select>';

	echo '<div class="uk-width-1-1"><input type=submit Name="ShowTB" Value="Show Trial Balance" class="md-btn md-btn-primary">';
	echo "</div></div>";

/*Now do the posting while the user is thinking about the period to select */

	include ('includes/GLPostings.inc');

} else {

	echo '<form method="POST" action="' . $_SERVER['PHP_SELF'] . '?' . SID . '">';
	echo '<input type=hidden name="FromPeriod" VALUE="' . $_POST['FromPeriod'] . '"><input type=hidden name="ToPeriod" VALUE="' . $_POST['ToPeriod'] . '">';

	$NumberOfMonths = $_POST['ToPeriod'] - $_POST['FromPeriod'] + 1;

	$sql = 'SELECT lastdate_in_period FROM periods WHERE periodno=' . $_POST['ToPeriod'];
	$PrdResult = DB_query($sql, $db);
	$myrow = DB_fetch_row($PrdResult);
	$PeriodToDate = MonthAndYearFromSQLDate($myrow[0]);

	$RetainedEarningsAct = $_SESSION['CompanyRecord']['retainedearnings'];

	$SQL = 'SELECT accountgroups.groupname,
			accountgroups.parentgroupname,
			accountgroups.pandl,
			chartdetails.accountcode ,
			chartmaster.accountname,
			Sum(CASE WHEN chartdetails.period=' . $_POST['FromPeriod'] . ' THEN chartdetails.bfwd ELSE 0 END) AS firstprdbfwd,
			Sum(CASE WHEN chartdetails.period=' . $_POST['FromPeriod'] . ' THEN chartdetails.bfwdbudget ELSE 0 END) AS firstprdbudgetbfwd,
			Sum(CASE WHEN chartdetails.period=' . $_POST['ToPeriod'] . ' THEN chartdetails.bfwd + chartdetails.actual ELSE 0 END) AS lastprdcfwd,
			Sum(CASE WHEN chartdetails.period=' . $_POST['ToPeriod'] . ' THEN chartdetails.actual ELSE 0 END) AS monthactual,
			Sum(CASE WHEN chartdetails.period=' . $_POST['ToPeriod'] . ' THEN chartdetails.budget ELSE 0 END) AS monthbudget,
			Sum(CASE WHEN chartdetails.period=' . $_POST['ToPeriod'] . ' THEN chartdetails.bfwdbudget + chartdetails.budget ELSE 0 END) AS lastprdbudgetcfwd
		FROM chartmaster INNER JOIN accountgroups ON chartmaster.group_ = accountgroups.groupname
			INNER JOIN chartdetails ON chartmaster.accountcode= chartdetails.accountcode
		GROUP BY accountgroups.groupname,
				accountgroups.pandl,
				accountgroups.sequenceintb,
				accountgroups.parentgroupname,
				chartdetails.accountcode,
				chartmaster.accountname
		ORDER BY accountgroups.pandl desc,
			accountgroups.sequenceintb,
			accountgroups.groupname,
			chartdetails.accountcode';


	$AccountsResult = DB_query($SQL,
				$db,
				 _('No general ledger accounts were returned by the SQL because'),
				 _('The SQL that failed was:'));

	echo '<div class="centre"><font size=4 color=white><b>'. _('Trial Balance for the month of ') . $PeriodToDate . _(' and for the ') . $NumberOfMonths . _(' months to ') . $PeriodToDate .'</b></font></div><br>';

	/*show a table of the accounts info returned by the SQL
	Account Code ,   Account Name , Month Actual, Month Budget, Period Actual, Period Budget */
   
   echo '<div class="uk-overflow-container"><label>Trial Balance</label>'; ?>
   
   <a href='PDFTrialbalance.php?FromPeriod=<?php echo $_POST['FromPeriod']; ?>&ToPeriod=<?php echo $_POST['ToPeriod']; ?>' target='_blank'> <img src='icon_pdf.gif' /></a>
   
   <?php
	echo '<table cellpadding=2 align="center" class="uk-table">';
	$TableHeader = '<thead><tr>
			<th>' . _('Account') . '</th>
			<th>' . _('Account Name') . '</th>
			<th>' . _('Month Actual') . '</th>
			<th>' . _('Month Budget') . '</th>
			<th>' . _('Period Actual') . '</th>
			<th>' . _('Period Budget') .'</th>
			</tr></thead>';

	$j = 1;
	$k=0; //row colour counter
	$ActGrp ='';
	$ParentGroups = array();
	$Level =1; //level of nested sub-groups
	$ParentGroups[$Level]='';
	$GrpActual =array(0);
	$GrpBudget =array(0);
	$GrpPrdActual =array(0);
	$GrpPrdBudget =array(0);
		
	$PeriodProfitLoss = 0;
	$PeriodBudgetProfitLoss = 0;
	$MonthProfitLoss = 0;
	$MonthBudgetProfitLoss = 0;
	$BFwdProfitLoss = 0;
	$CheckMonth = 0;
	$CheckBudgetMonth = 0;
	$CheckPeriodActual = 0;
	$CheckPeriodBudget = 0;

	while ($myrow=DB_fetch_array($AccountsResult)) {

		if ($myrow['groupname']!= $ActGrp ){
			if ($ActGrp !=''){ //so its not the first account group of the first account displayed
				if ($myrow['parentgroupname']==$ActGrp){
					$Level++;
					$ParentGroups[$Level]=$myrow['groupname'];
					$GrpActual[$Level] =0;
					$GrpBudget[$Level] =0;
					$GrpPrdActual[$Level] =0;
					$GrpPrdBudget[$Level] =0;
					$ParentGroups[$Level]='';
				} elseif ($ParentGroups[$Level]==$myrow['parentgroupname']) {
				
				echo 'parentgroup' . $myrow['parentgroupname'];
					printf('<tr>
						<td colspan=2><font size=2><I>%s ' . _('Total') . ' </I></font></td>
						<td class=number><I>%s</I></td>
						<td class=number><I>%s</I></td>
						<td class=number><I>%s</I></td>
						<td class=number><I>%s</I></td>
						</tr>',
						$ParentGroups[$Level],
						number_format($GrpActual[$Level],2),
						number_format($GrpBudget[$Level],2),
						number_format($GrpPrdActual[$Level],2),
						number_format($GrpPrdBudget[$Level],2));
			
					$GrpActual[$Level] =0;
					$GrpBudget[$Level] =0;
					$GrpPrdActual[$Level] =0;
					$GrpPrdBudget[$Level] =0;
					$ParentGroups[$Level]=$myrow['groupname'];
				} else {
					do {
						printf('<tr>
							<td colspan=2><font size=2><I>%s ' . _('Total') . ' </I></font></td>
							<td class=number><I>%s</I></td>
							<td class=number><I>%s</I></td>
							<td class=number><I>%s</I></td>
							<td class=number><I>%s</I></td>
							</tr>',
							$ParentGroups[$Level],
							number_format($GrpActual[$Level],2),
							number_format($GrpBudget[$Level],2),
							number_format($GrpPrdActual[$Level],2),
							number_format($GrpPrdBudget[$Level],2));
			
						$GrpActual[$Level] =0;
						$GrpBudget[$Level] =0;
						$GrpPrdActual[$Level] =0;
						$GrpPrdBudget[$Level] =0;
						$ParentGroups[$Level]='';
						$Level--;
						
						$j++;
					} while ($Level>0 and $myrow['groupname']!=$ParentGroups[$Level]);
					
					if ($Level>0){	
						printf('<tr>
						<td colspan=2><font size=2><I>%s ' . _('Total') . ' </I></font></td>
						<td class=number><I>%s</I></td>
						<td class=number><I>%s</I></td>
						<td class=number><I>%s</I></td>
						<td class=number><I>%s</I></td>
						</tr>',
						$ParentGroups[$Level],
						number_format($GrpActual[$Level],2),
						number_format($GrpBudget[$Level],2),
						number_format($GrpPrdActual[$Level],2),
						number_format($GrpPrdBudget[$Level],2));
			
						$GrpActual[$Level] =0;
						$GrpBudget[$Level] =0;
						$GrpPrdActual[$Level] =0;
						$GrpPrdBudget[$Level] =0;
						$ParentGroups[$Level]='';
					} else {
						$Level=1;
					}
				}
			}
			$ParentGroups[$Level]=$myrow['groupname'];
			$ActGrp = $myrow['groupname'];
			printf('<tr>
				<td colspan=6><font size=4 color=blue><b>%s</b></font></td>
				</tr>',
				$myrow['groupname']);
			echo $TableHeader;
			$j++;
		}

		if ($k==1){
			echo '<tr class="EvenTableRows">';
			$k=0;
		} else {
			echo '<tr class="OddTableRows">';
			$k++;
		}
		/*MonthActual, MonthBudget, FirstPrdBFwd, FirstPrdBudgetBFwd, LastPrdBudgetCFwd, LastPrdCFwd */


		if ($myrow['pandl']==1){

			$AccountPeriodActual = $myrow['lastprdcfwd'] - $myrow['firstprdbfwd'];
			$AccountPeriodBudget = $myrow['lastprdbudgetcfwd'] - $myrow['firstprdbudgetbfwd'];

			$PeriodProfitLoss += $AccountPeriodActual;
			$PeriodBudgetProfitLoss += $AccountPeriodBudget;
			$MonthProfitLoss += $myrow['monthactual'];
			$MonthBudgetProfitLoss += $myrow['monthbudget'];
			$BFwdProfitLoss += $myrow['firstprdbfwd'];
		} else { /*PandL ==0 its a balance sheet account */
			if ($myrow['accountcode']==$RetainedEarningsAct){
				$AccountPeriodActual = $BFwdProfitLoss + $myrow['lastprdcfwd'];
				$AccountPeriodBudget = $BFwdProfitLoss + $myrow['lastprdbudgetcfwd'] - $myrow['firstprdbudgetbfwd'];
			} else {
				$AccountPeriodActual = $myrow['lastprdcfwd'];
				$AccountPeriodBudget = $myrow['firstprdbfwd'] + $myrow['lastprdbudgetcfwd'] - $myrow['firstprdbudgetbfwd'];
			}

		}

		if (!isset($GrpActual[$Level])) {$GrpActual[$Level]=0;}
		if (!isset($GrpBudget[$Level])) {$GrpBudget[$Level]=0;}
		if (!isset($GrpPrdActual[$Level])) {$GrpPrdActual[$Level]=0;}
		if (!isset($GrpPrdBudget[$Level])) {$GrpPrdBudget[$Level]=0;}
		$GrpActual[$Level] +=$myrow['monthactual'];
		$GrpBudget[$Level] +=$myrow['monthbudget'];
		$GrpPrdActual[$Level] +=$AccountPeriodActual;
		$GrpPrdBudget[$Level] +=$AccountPeriodBudget;

		$CheckMonth += $myrow['monthactual'];
		$CheckBudgetMonth += $myrow['monthbudget'];
		$CheckPeriodActual += $AccountPeriodActual;
		$CheckPeriodBudget += $AccountPeriodBudget;

		$ActEnquiryURL = '<a href="'. $rootpath . '/lw_GLAccountInquiry_alt.php?' . SID . 'Period=' . $_POST['ToPeriod'] . '&Account=' . $myrow['accountcode'] . '&Show=Yes">' . $myrow['accountcode'] . '<a>';

		printf('<td>%s</td>
			<td>%s</td>
			<td class=number>%s</td>
			<td class=number>%s</td>
			<td class=number>%s</td>
			<td class=number>%s</td>
			</tr>',
			$ActEnquiryURL,
			$myrow['accountname'],
			number_format($myrow['monthactual'],2),
			number_format($myrow['monthbudget'],2),
			number_format($AccountPeriodActual,2),
			number_format($AccountPeriodBudget,2));

		$j++;
	}
	//end of while loop


	if ($ActGrp !=''){ //so its not the first account group of the first account displayed
		if ($myrow['parentgroupname']==$ActGrp){
			$Level++;
			$ParentGroups[$Level]=$myrow['groupname'];
		} elseif ($ParentGroups[$Level]==$myrow['parentgroupname']) {
			printf('<tr>
				<td colspan=2><font size=2><I>%s ' . _('Total') . ' </I></font></td>
				<td class=number><I>%s</I></td>
				<td class=number><I>%s</I></td>
				<td class=number><I>%s</I></td>
				<td class=number><I>%s</I></td>
				</tr>',
				$ParentGroups[$Level],
				number_format($GrpActual[$Level],2),
				number_format($GrpBudget[$Level],2),
				number_format($GrpPrdActual[$Level],2),
				number_format($GrpPrdBudget[$Level],2));
	
			$GrpActual[$Level] =0;
			$GrpBudget[$Level] =0;
			$GrpPrdActual[$Level] =0;
			$GrpPrdBudget[$Level] =0;
			$ParentGroups[$Level]=$myrow['groupname'];
		} else {
			do {
				printf('<tr>
					<td colspan=2><font size=2><I>%s ' . _('Total') . ' </I></font></td>
					<td class=number><I>%s</I></td>
					<td class=number><I>%s</I></td>
					<td class=number><I>%s</I></td>
					<td class=number><I>%s</I></td>
					</tr>',
					$ParentGroups[$Level],
					number_format($GrpActual[$Level],2),
					number_format($GrpBudget[$Level],2),
					number_format($GrpPrdActual[$Level],2),
					number_format($GrpPrdBudget[$Level],2));
	
				$GrpActual[$Level] =0;
				$GrpBudget[$Level] =0;
				$GrpPrdActual[$Level] =0;
				$GrpPrdBudget[$Level] =0;
				$ParentGroups[$Level]='';
				$Level--;
				
				$j++;
			} while (isset($ParentGroups[$Level]) and ($myrow['groupname']!=$ParentGroups[$Level] and $Level>0));
			
			if ($Level >0){	
				printf('<tr>
				<td colspan=2><font size=2><I>%s ' . _('Total') . ' </I></font></td>
				<td class=number><I>%s</I></td>
				<td class=number><I>%s</I></td>
				<td class=number><I>%s</I></td>
				<td class=number><I>%s</I></td>
				</tr>',
				$ParentGroups[$Level],
				number_format($GrpActual[$Level],2),
				number_format($GrpBudget[$Level],2),
				number_format($GrpPrdActual[$Level],2),
				number_format($GrpPrdBudget[$Level],2));
	
				$GrpActual[$Level] =0;
				$GrpBudget[$Level] =0;
				$GrpPrdActual[$Level] =0;
				$GrpPrdBudget[$Level] =0;
				$ParentGroups[$Level]='';
			} else {
				$Level =1;
			}
		}
	}



	printf('<tr bgcolor="#ffffff">
			<td colspan=2><font color=BLUE><b>' . _('Check Totals') . '</b></font></td>
			<td class=number>%s</td>
			<td class=number>%s</td>
			<td class=number>%s</td>
			<td class=number>%s</td>
		</tr>',
		number_format($CheckMonth,2),
		number_format($CheckBudgetMonth,2),
		number_format($CheckPeriodActual,2),
		number_format($CheckPeriodBudget,2));

	echo '</table>';
	echo '<div class="centre"><input type=submit Name="SelectADifferentPeriod" class="md-btn md-btn-primary" Value="' . _('Select A Different Period') . '"></div>';
}
echo '</form></div></div>';


?>