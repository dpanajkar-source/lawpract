<?php

/* $Revision: 1.19 $ */

include('includes/AccountSectionsDef.inc'); // This loads the $Sections variable

if (isset($_POST['FromPeriod']) and ($_POST['FromPeriod'] > $_POST['ToPeriod'])){
	prnMsg(_('The selected period from is actually after the period to') . '! ' . _('Please reselect the reporting period'),'error');
	$_POST['SelectADifferentPeriod']='Select A Different Period';
}

if ((!isset($_POST['FromPeriod']) AND !isset($_POST['ToPeriod'])) OR isset($_POST['SelectADifferentPeriod'])){


 // form container here----------------------------------------------------------------------------->
   
	echo '<div class="uk-overflow-container">';
	
	echo "<form method='POST' action=" . $_SERVER['PHP_SELF'] . '?' . SID . '>';
	
	if (Date('m') > $_SESSION['YearEnd']){
		/*Dates in SQL format */
		$DefaultFromDate = Date ('Y-m-d', Mktime(0,0,0,$_SESSION['YearEnd'] + 2,0,Date('Y')));
		$FromDate = Date($_SESSION['DefaultDateFormat'], Mktime(0,0,0,$_SESSION['YearEnd'] + 2,0,Date('Y')));
	} else {
		$DefaultFromDate = Date ('Y-m-d', Mktime(0,0,0,$_SESSION['YearEnd'] + 2,0,Date('Y')-1));
		$FromDate = Date($_SESSION['DefaultDateFormat'], Mktime(0,0,0,$_SESSION['YearEnd'] + 2,0,Date('Y')-1));
	}
	$period=GetPeriod($FromDate, $db);
	
	
	
	/*Show a form to allow input of criteria for profit and loss to show */
	echo 'Select Period From <select Name="FromPeriod" class="md-input">';

	$sql = 'SELECT periodno, lastdate_in_period FROM periods ORDER BY periodno DESC';
	$Periods = DB_query($sql,$db);


	while ($myrow=DB_fetch_array($Periods,$db)){
		if(isset($_POST['FromPeriod']) AND $_POST['FromPeriod']!=''){
			if( $_POST['FromPeriod']== $myrow['periodno']){
				echo '<option selected VALUE=' . $myrow['periodno'] . '>' .MonthAndYearFromSQLDate($myrow['lastdate_in_period']);
			} else {
				echo '<option VALUE=' . $myrow['periodno'] . '>' . MonthAndYearFromSQLDate($myrow['lastdate_in_period']);
			}
		} else {
			if($myrow['lastdate_in_period']==$DefaultFromDate){
				echo '<option selected VALUE=' . $myrow['periodno'] . '>' . MonthAndYearFromSQLDate($myrow['lastdate_in_period']);
			} else {
				echo '<option VALUE=' . $myrow['periodno'] . '>' . MonthAndYearFromSQLDate($myrow['lastdate_in_period']);
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
	
	echo "Select Period To <select Name='ToPeriod' class='md-input'>";

	$RetResult = DB_data_seek($Periods,0);

	while ($myrow=DB_fetch_array($Periods,$db)){

		if($myrow['periodno']==$DefaultToPeriod){
			echo '<option selected VALUE=' . $myrow['periodno'] . '>' . MonthAndYearFromSQLDate($myrow['lastdate_in_period']);
		} else {
			echo '<option VALUE =' . $myrow['periodno'] . '>' . MonthAndYearFromSQLDate($myrow['lastdate_in_period']);
		}
	}
	echo '</select>';

	echo "Detail Or Summary <select Name='Detail' class='md-input'>";
		echo "<option selected VALUE='Summary'>"._('Summary');
		echo "<option selected VALUE='Detailed'>"._('All Accounts');
	echo '</select>';
	echo "<div class='uk-width-1-1'><input type=submit Name='ShowPL' class='md-btn md-btn-primary' Value='Show on Screen (HTML)'>";
	echo "</div></div>";

	/*Now do the posting while the user is thinking about the period to select */

	include ('includes/GLPostings.inc');

} else {

	echo "<form method='POST' action=" . $_SERVER['PHP_SELF'] . '?' . SID . '>';
	echo "<input type=hidden name='FromPeriod' VALUE=" . $_POST['FromPeriod'] . "><input type=hidden name='ToPeriod' VALUE=" . $_POST['ToPeriod'] . '>';

	$NumberOfMonths = $_POST['ToPeriod'] - $_POST['FromPeriod'] + 1;
	
	if ($NumberOfMonths >12){
		echo '<p>';
		prnMsg(_('A period up to 12 months in duration can be specified') . ' - ' . _('the system automatically shows a comparative for the same period from the previous year') . ' - ' . _('it cannot do this if a period of more than 12 months is specified') . '. ' . _('Please select an alternative period range'),'error');
		
		exit;
	}

	$sql = 'SELECT lastdate_in_period FROM periods WHERE periodno=' . $_POST['ToPeriod'];
	$PrdResult = DB_query($sql, $db);
	$myrow = DB_fetch_row($PrdResult);
	$PeriodToDate = MonthAndYearFromSQLDate($myrow[0]);


	$SQL = 'SELECT accountgroups.sectioninaccounts,
			accountgroups.parentgroupname,
			accountgroups.groupname,
			chartdetails.accountcode,
			chartmaster.accountname,
			Sum(CASE WHEN chartdetails.period=' . $_POST['FromPeriod'] . ' THEN chartdetails.bfwd ELSE 0 END) AS firstprdbfwd,
			Sum(CASE WHEN chartdetails.period=' . $_POST['FromPeriod'] . ' THEN chartdetails.bfwdbudget ELSE 0 END) AS firstprdbudgetbfwd,
			Sum(CASE WHEN chartdetails.period=' . $_POST['ToPeriod'] . ' THEN chartdetails.bfwd + chartdetails.actual ELSE 0 END) AS lastprdcfwd,
			Sum(CASE WHEN chartdetails.period=' . ($_POST['FromPeriod'] - 12) . ' THEN chartdetails.bfwd ELSE 0 END) AS lyfirstprdbfwd,
			Sum(CASE WHEN chartdetails.period=' . ($_POST['ToPeriod']-12) . ' THEN chartdetails.bfwd + chartdetails.actual ELSE 0 END) AS lylastprdcfwd,
			Sum(CASE WHEN chartdetails.period=' . $_POST['ToPeriod'] . ' THEN chartdetails.bfwdbudget + chartdetails.budget ELSE 0 END) AS lastprdbudgetcfwd
		FROM chartmaster INNER JOIN accountgroups
		ON chartmaster.group_ = accountgroups.groupname INNER JOIN chartdetails
		ON chartmaster.accountcode= chartdetails.accountcode
		WHERE accountgroups.pandl=1
		GROUP BY accountgroups.sectioninaccounts,
			accountgroups.parentgroupname,
			accountgroups.groupname,
			chartdetails.accountcode,
			chartmaster.accountname,
			accountgroups.sequenceintb
		ORDER BY accountgroups.sectioninaccounts,
			accountgroups.sequenceintb,
			accountgroups.groupname,
			accountgroups.sequenceintb,
			chartdetails.accountcode';

	$AccountsResult = DB_query($SQL,$db,_('No general ledger accounts were returned by the SQL because'),_('The SQL that failed was'));

	/*show a table of the accounts info returned by the SQL
	Account Code ,   Account Name , Month Actual, Month Budget, Period Actual, Period Budget */

    
	echo '<div class="uk-overflow-container">';  ?>
	<a href='PDFProfitloss.php?FromPeriod=<?php echo $_POST['FromPeriod']; ?>&ToPeriod=<?php echo $_POST['ToPeriod']; ?>' target='_blank'> <img src='icon_pdf.gif' /></a>
	
    <?php
	echo '<table cellpadding=2 align="center" class="uk-table">';

	if ($_POST['Detail']=='Detailed'){
		$TableHeader = "<thead><tr>
				<th>"._('Account')."</th>
				<th>"._('Account Name')."</th>
				<th colspan=2>"._('Period Actual')."</th>
				<th colspan=2>"._('Period Budget')."</th>
				<th colspan=2>"._('Last Year')."</th>
				</tr></thead>";
	} else { /*summary */
		$TableHeader = "<thead><tr>
				<th colspan=2></th>
				<th colspan=2>"._('Period Actual')."</th>
				<th colspan=2>"._('Period Budget')."</th>
				<th colspan=2>"._('Last Year')."</th>
				</tr></thead>";
	}


	$j = 1;
	$k=0; //row colour counter
	$Section='';
	$SectionPrdActual= 0;
	$SectionPrdLY 	 = 0;
	$SectionPrdBudget= 0;
	
	$PeriodProfitLoss = 0;
	$PeriodProfitLoss = 0;
	$PeriodLYProfitLoss = 0;
	$PeriodBudgetProfitLoss = 0;
	

	$ActGrp ='';
	$ParentGroups = array();
	$Level = 0;
	$ParentGroups[$Level]='';
	$GrpPrdActual = array(0);
	$GrpPrdLY = array(0);
	$GrpPrdBudget = array(0);


	while ($myrow=DB_fetch_array($AccountsResult)) {


		if ($myrow['groupname']!= $ActGrp){
			if ($myrow['parentgroupname']!=$ActGrp AND $ActGrp!=''){
					while ($myrow['groupname']!=$ParentGroups[$Level] AND $Level>0) {
					if ($_POST['Detail']=='Detailed'){
						echo '<tr>
							<td colspan=2></td>
							<td colspan=6><hr></td>
						</tr>';
						$ActGrpLabel = str_repeat('___',$Level) . $ParentGroups[$Level] . ' ' . _('total');
					} else {
						$ActGrpLabel = str_repeat('___',$Level) . $ParentGroups[$Level];
					}
				if ($Section ==1){ /*Income */
						printf('<tr>
							<td colspan=2><font size=2><I>%s </I></font></td>
							<td></td>
							<td class=number>%s</td>
							<td></td>
							<td class=number>%s</td>
							<td></td>
							<td class=number>%s</td>
							</tr>',
							$ActGrpLabel,
							number_format(-$GrpPrdActual[$Level]),
							number_format(-$GrpPrdBudget[$Level]),
							number_format(-$GrpPrdLY[$Level]));
					} else { /*Costs */
						printf('<tr>
							<td colspan=2><font size=2><I>%s </I></font></td>
							<td class=number>%s</td>
							<td></td>
							<td class=number>%s</td>
							<td></td>
							<td class=number>%s</td>
							<td></td>
							</tr>',
							$ActGrpLabel,
							number_format($GrpPrdActual[$Level]),
							number_format($GrpPrdBudget[$Level]),
							number_format($GrpPrdLY[$Level]));
					}
					$GrpPrdLY[$Level] = 0;
					$GrpPrdActual[$Level] = 0;
					$GrpPrdBudget[$Level] = 0;
					$ParentGroups[$Level] ='';
					$Level--;
				}//end while
				//still need to print out the old group totals
				if ($_POST['Detail']=='Detailed'){
						echo '<tr>
							<td colspan=2></td>
							<td colspan=6><hr></td>
						</tr>';
						$ActGrpLabel = str_repeat('___',$Level) . $ParentGroups[$Level] . ' ' . _('total');
					} else {
						$ActGrpLabel = str_repeat('___',$Level) . $ParentGroups[$Level];
					}

				if ($Section ==1){ /*Income */
					printf('<tr>
						<td colspan=2><font size=2><I>%s </I></font></td>
						<td></td>
						<td class=number>%s</td>
						<td></td>
						<td class=number>%s</td>
						<td></td>
						<td class=number>%s</td>
						</tr>',
						$ActGrpLabel,
						number_format(-$GrpPrdActual[$Level]),
						number_format(-$GrpPrdBudget[$Level]),
						number_format(-$GrpPrdLY[$Level]));
				} else { /*Costs */
					printf('<tr>
						<td colspan=2><font size=2><I>%s </I></font></td>
						<td class=number>%s</td>
						<td></td>
						<td class=number>%s</td>
						<td></td>
						<td class=number>%s</td>
						<td></td>
						</tr>',
						$ActGrpLabel,
						number_format($GrpPrdActual[$Level]),
						number_format($GrpPrdBudget[$Level]),
						number_format($GrpPrdLY[$Level]));
				}
				$GrpPrdLY[$Level] = 0;
				$GrpPrdActual[$Level] = 0;
				$GrpPrdBudget[$Level] = 0;
				$ParentGroups[$Level] ='';
			}
			$j++;
		}

		if ($myrow['sectioninaccounts']!= $Section){

			if ($SectionPrdLY+$SectionPrdActual+$SectionPrdBudget !=0){
				if ($Section==1) { /*Income*/

					echo '<tr>
						<td colspan=3></td>
      						<td><hr></td>
						<td></td>
						<td><hr></td>
						<td></td>
						<td><hr></td>
					</tr>';

					printf('<tr>
					<td colspan=2><font size=4>%s</font></td>
					<td></td>
					<td class=number>%s</td>
					<td></td>
					<td class=number>%s</td>
					<td></td>
					<td class=number>%s</td>
					</tr>',
					$Sections[$Section],
					number_format(-$SectionPrdActual),
					number_format(-$SectionPrdBudget),
					number_format(-$SectionPrdLY));
					$TotalIncome = -$SectionPrdActual;
					$TotalBudgetIncome = -$SectionPrdBudget;
					$TotalLYIncome = -$SectionPrdLY;
				} else {
					echo '<tr>
					<td colspan=2></td>
      					<td><hr></td>
					<td></td>
					<td><hr></td>
					<td></td>
					<td><hr></td>
					</tr>';
					printf('<tr>
					<td colspan=2><font size=4>%s</font></td>
					<td></td>
					<td class=number>%s</td>
					<td></td>
					<td class=number>%s</td>
					<td></td>
					<td class=number>%s</td>
					</tr>',
					$Sections[$Section],
					number_format($SectionPrdActual),
					number_format($SectionPrdBudget),
					number_format($SectionPrdLY));
				}
				if ($Section==2){ /*Cost of Sales - need sub total for Gross Profit*/
					echo '<tr>
						<td colspan=2></td>
						<td colspan=6><hr></td>
					</tr>';
					printf('<tr>
						<td colspan=2><font size=4>'._('Gross Profit').'</font></td>
						<td></td>
						<td class=number>%s</td>
						<td></td>
						<td class=number>%s</td>
						<td></td>
						<td class=number>%s</td>
						</tr>',
					number_format($TotalIncome - $SectionPrdActual),
					number_format($TotalBudgetIncome - $SectionPrdBudget),
					number_format($TotalLYIncome - $SectionPrdLY));

					if ($TotalIncome !=0){
						$PrdGPPercent = 100*($TotalIncome - $SectionPrdActual)/$TotalIncome;
					} else {
						$PrdGPPercent =0;
					}
					if ($TotalBudgetIncome !=0){
						$BudgetGPPercent = 100*($TotalBudgetIncome - $SectionPrdBudget)/$TotalBudgetIncome;
					} else {
						$BudgetGPPercent =0;
					}
					if ($TotalLYIncome !=0){
						$LYGPPercent = 100*($TotalLYIncome - $SectionPrdLY)/$TotalLYIncome;
					} else {
						$LYGPPercent = 0;
					}
					echo '<tr>
						<td colspan=2></td>
						<td colspan=6><hr></td>
					</tr>';
					printf('<tr>
						<td colspan=2><font size=2><I>'._('Gross Profit Percent').'</I></font></td>
						<td></td>
						<td class=number><I>%s</I></td>
						<td></td>
						<td class=number><I>%s</I></td>
						<td></td>
						<td class=number><I>%s</I></td>
						</tr><tr><td colspan=6> </td></tr>',
						number_format($PrdGPPercent,1) . '%',
						number_format($BudgetGPPercent,1) . '%',
						number_format($LYGPPercent,1). '%');
					$j++;
				}
			}
			$SectionPrdLY =0;
			$SectionPrdActual =0;
			$SectionPrdBudget =0;

			$Section = $myrow['sectioninaccounts'];

			if ($_POST['Detail']=='Detailed'){
				printf('<tr>
					<td colspan=6><font size=4 color=BLUE><b>%s</b></font></td>
					</tr>',
					$Sections[$myrow['sectioninaccounts']]);
			}
			$j++;

		}



		if ($myrow['groupname']!= $ActGrp){

			if ($myrow['parentgroupname']==$ActGrp AND $ActGrp !=''){ //adding another level of nesting
				$Level++;
			}
			
			$ParentGroups[$Level] = $myrow['groupname'];
			$ActGrp = $myrow['groupname'];
			if ($_POST['Detail']=='Detailed'){
				printf('<tr>
					<td colspan=6><font size=2 color=BLUE><b>%s</b></font></td>
					</tr>',
					$myrow['groupname']);
					echo $TableHeader;
			}
		}

		$AccountPeriodActual = $myrow['lastprdcfwd'] - $myrow['firstprdbfwd'];
		$AccountPeriodLY = $myrow['lylastprdcfwd'] - $myrow['lyfirstprdbfwd'];
		$AccountPeriodBudget = $myrow['lastprdbudgetcfwd'] - $myrow['firstprdbudgetbfwd'];
		$PeriodProfitLoss += $AccountPeriodActual;
		$PeriodBudgetProfitLoss += $AccountPeriodBudget;
		$PeriodLYProfitLoss += $AccountPeriodLY;

		for ($i=0;$i<=$Level;$i++){
			if (!isset($GrpPrdLY[$i])) {$GrpPrdLY[$i]=0;}
			$GrpPrdLY[$i] +=$AccountPeriodLY;
			if (!isset($GrpPrdActual[$i])) {$GrpPrdActual[$i]=0;}
			$GrpPrdActual[$i] +=$AccountPeriodActual;
			if (!isset($GrpPrdBudget[$i])) {$GrpPrdBudget[$i]=0;}
			$GrpPrdBudget[$i] +=$AccountPeriodBudget;
		}
		$SectionPrdLY +=$AccountPeriodLY;
		$SectionPrdActual +=$AccountPeriodActual;
		$SectionPrdBudget +=$AccountPeriodBudget;

		if ($_POST['Detail']==_('Detailed')){

			if ($k==1){
				echo '<tr class="EvenTableRows">';
				$k=0;
			} else {
				echo '<tr class="OddTableRows">';
				$k++;
			}

			$ActEnquiryURL = "<a href='$rootpath/lw_GLAccountInquiry_alt.php?" . SID . '&Period=' . $_POST['ToPeriod'] . '&Account=' . $myrow['accountcode'] . "&Show=Yes'>" . $myrow['accountcode'] . '<a>';

			if ($Section ==1){
				 printf('<td>%s</td>
					<td>%s</td>
					<td></td>
					<td class=number>%s</td>
					<td></td>
					<td class=number>%s</td>
					<td></td>
					<td class=number>%s</td>
					</tr>',
					$ActEnquiryURL,
					$myrow['accountname'],
					number_format(-$AccountPeriodActual),
					number_format(-$AccountPeriodBudget),
					number_format(-$AccountPeriodLY));
			} else {
				printf('<td>%s</td>
					<td>%s</td>
					<td class=number>%s</td>
					<td></td>
					<td class=number>%s</td>
					<td></td>
					<td class=number>%s</td>
					<td></td>
					</tr>',
					$ActEnquiryURL,
					$myrow['accountname'],
					number_format($AccountPeriodActual),
					number_format($AccountPeriodBudget),
					number_format($AccountPeriodLY));
			}

			$j++;
		}
	}
	//end of loop


	if ($myrow['groupname']!= $ActGrp){
		if ($myrow['parentgroupname']!=$ActGrp AND $ActGrp!=''){
			while ($myrow['groupname']!=$ParentGroups[$Level] AND $Level>0) {
				if ($_POST['Detail']=='Detailed'){
					echo '<tr>
						<td colspan=2></td>
						<td colspan=6><hr></td>
					</tr>';
					$ActGrpLabel = str_repeat('___',$Level) . $ParentGroups[$Level] . ' ' . _('total');
				} else {
					$ActGrpLabel = str_repeat('___',$Level) . $ParentGroups[$Level];
				}
				if ($Section ==1){ /*Income */
					printf('<tr>
						<td colspan=2><font size=2><I>%s </I></font></td>
						<td></td>
						<td class=number>%s</td>
						<td></td>
						<td class=number>%s</td>
						<td></td>
						<td class=number>%s</td>
						</tr>',
						$ActGrpLabel,
						number_format(-$GrpPrdActual[$Level]),
						number_format(-$GrpPrdBudget[$Level]),
						number_format(-$GrpPrdLY[$Level]));
				} else { /*Costs */
					printf('<tr>
						<td colspan=2><font size=2><I>%s </I></font></td>
						<td class=number>%s</td>
						<td></td>
						<td class=number>%s</td>
						<td></td>
						<td class=number>%s</td>
						<td></td>
						</tr>',
						$ActGrpLabel,
						number_format($GrpPrdActual[$Level]),
						number_format($GrpPrdBudget[$Level]),
						number_format($GrpPrdLY[$Level]));
				}
				$GrpPrdLY[$Level] = 0;
				$GrpPrdActual[$Level] = 0;
				$GrpPrdBudget[$Level] = 0;
				$ParentGroups[$Level] ='';
				$Level--;
			}//end while
			//still need to print out the old group totals
			if ($_POST['Detail']=='Detailed'){
					echo '<tr>
						<td colspan=2></td>
						<td colspan=6><hr></td>
					</tr>';
					$ActGrpLabel = str_repeat('___',$Level) . $ParentGroups[$Level] . ' ' . _('total');
				} else {
					$ActGrpLabel = str_repeat('___',$Level) . $ParentGroups[$Level];
				}

			if ($Section ==1){ /*Income */
				printf('<tr>
					<td colspan=2><font size=2><I>%s </I></font></td>
					<td></td>
					<td class=number>%s</td>
					<td></td>
					<td class=number>%s</td>
					<td></td>
					<td class=number>%s</td>
					</tr>',
					$ActGrpLabel,
					number_format(-$GrpPrdActual[$Level]),
					number_format(-$GrpPrdBudget[$Level]),
					number_format(-$GrpPrdLY[$Level]));
			} else { /*Costs */
				printf('<tr>
					<td colspan=2><font size=2><I>%s </I></font></td>
					<td class=number>%s</td>
					<td></td>
					<td class=number>%s</td>
					<td></td>
					<td class=number>%s</td>
					<td></td>
					</tr>',
					$ActGrpLabel,
					number_format($GrpPrdActual[$Level]),
					number_format($GrpPrdBudget[$Level]),
					number_format($GrpPrdLY[$Level]));
			}
			$GrpPrdLY[$Level] = 0;
			$GrpPrdActual[$Level] = 0;
			$GrpPrdBudget[$Level] = 0;
			$ParentGroups[$Level] ='';
		}
		$j++;
	}

	if ($myrow['sectioninaccounts']!= $Section){

		if ($Section==1) { /*Income*/

			echo '<tr>
				<td colspan=3></td>
				<td><hr></td>
				<td></td>
				<td><hr></td>
				<td></td>
				<td><hr></td>
			</tr>';

			printf('<tr>
			<td colspan=2><font size=4>%s</font></td>
			<td></td>
			<td class=number>%s</td>
			<td></td>
			<td class=number>%s</td>
			<td></td>
			<td class=number>%s</td>
			</tr>',
			$Sections[$Section],
			number_format(-$SectionPrdActual),
			number_format(-$SectionPrdBudget),
			number_format(-$SectionPrdLY));
			$TotalIncome = -$SectionPrdActual;
			$TotalBudgetIncome = -$SectionPrdBudget;
			$TotalLYIncome = -$SectionPrdLY;
		} else {
			echo '<tr>
			<td colspan=2></td>
			<td><hr></td>
			<td></td>
			<td><hr></td>
			<td></td>
			<td><hr></td>
			</tr>';
			printf('<tr>
			<td colspan=2><font size=4>%s</font></td>
			<td></td>
			<td class=number>%s</td>
			<td></td>
			<td class=number>%s</td>
			<td></td>
			<td class=number>%s</td>
			</tr>',
			$Sections[$Section],
			number_format($SectionPrdActual),
			number_format($SectionPrdBudget),
			number_format($SectionPrdLY));
		}
		if ($Section==2){ /*Cost of Sales - need sub total for Gross Profit*/
			echo '<tr>
				<td colspan=2></td>
				<td colspan=6><hr></td>
			</tr>';
			printf('<tr>
				<td colspan=2><font size=4>'._('Gross Profit').'</font></td>
				<td></td>
				<td class=number>%s</td>
				<td></td>
				<td class=number>%s</td>
				<td></td>
				<td class=number>%s</td>
				</tr>',
			number_format($TotalIncome - $SectionPrdActual),
			number_format($TotalBudgetIncome - $SectionPrdBudget),
			number_format($TotalLYIncome - $SectionPrdLY));

			if ($TotalIncome !=0){
				$PrdGPPercent = 100*($TotalIncome - $SectionPrdActual)/$TotalIncome;
			} else {
				$PrdGPPercent =0;
			}
			if ($TotalBudgetIncome !=0){
				$BudgetGPPercent = 100*($TotalBudgetIncome - $SectionPrdBudget)/$TotalBudgetIncome;
			} else {
				$BudgetGPPercent =0;
			}
			if ($TotalLYIncome !=0){
				$LYGPPercent = 100*($TotalLYIncome - $SectionPrdLY)/$TotalLYIncome;
			} else {
				$LYGPPercent = 0;
			}
			echo '<tr>
				<td colspan=2></td>
				<td colspan=6><hr></td>
			</tr>';
			printf('<tr>
				<td colspan=2><font size=2><I>'._('Gross Profit Percent').'</I></font></td>
				<td></td>
				<td class=number><I>%s</I></td>
				<td></td>
				<td class=number><I>%s</I></td>
				<td></td>
				<td class=number><I>%s</I></td>
				</tr><tr><td colspan=6> </td></tr>',
				number_format($PrdGPPercent,1) . '%',
				number_format($BudgetGPPercent,1) . '%',
				number_format($LYGPPercent,1). '%');
			$j++;
		}
	
		$SectionPrdLY =0;
		$SectionPrdActual =0;
		$SectionPrdBudget =0;

		$Section = $myrow['sectioninaccounts'];

		if ($_POST['Detail']=='Detailed' and isset($Sections[$myrow['sectioninaccounts']])){
			printf('<tr>
				<td colspan=6><font size=4 color=BLUE><b>%s</b></font></td>
				</tr>',
				$Sections[$myrow['sectioninaccounts']]);
		}
		$j++;

	}

	echo '<tr>
		<td colspan=2></td>
		<td colspan=6><hr></td>
		</tr>';

	printf("<tr bgcolor='#ffffff'>
		<td colspan=2><font size=4 color=BLUE><b>"._('Profit').' - '._('Loss')."</b></font></td>
		<td></td>
		<td class=number>%s</td>
		<td></td>
		<td class=number>%s</td>
		<td></td>
		<td class=number>%s</td>
		</tr>",
		number_format(-$PeriodProfitLoss),
		number_format(-$PeriodBudgetProfitLoss),
		number_format(-$PeriodLYProfitLoss)
		);

	echo '<tr>
		<td colspan=2></td>
		<td colspan=6><hr></td>
		</tr>';

	echo '</table>';
	echo "<div class='centre'><input type=submit Name='SelectADifferentPeriod' Value='Select A Different Period' class='md-btn md-btn-primary'></div>";
}
echo '</form><div>';


?>
