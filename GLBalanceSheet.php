<?php

/* $Revision: 1.18 $ */

/*Through deviousness and cunning, this system allows shows the balance sheets as at the end of any period selected - so first off need to show the input of criteria screen while the user is selecting the period end of the balance date meanwhile the system is posting any unposted transactions */

include('includes/AccountSectionsDef.inc'); // This loads the $Sections variable

if (! isset($_POST['BalancePeriodEnd']) or isset($_POST['SelectADifferentPeriod'])){

	/*Show a form to allow input of criteria for TB to show */
	//include('includes/header.php');
	   
	echo '<div class="uk-overflow-container">';
	echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px"><h3 class="heading_a">GL Balance Sheet</h3></div>';
	echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">';
	echo "<form method='POST' action=" . $_SERVER['PHP_SELF'] . '?' . SID . '>';
	echo "<label>Select the balance date</label><select Name='BalancePeriodEnd' class='md-input'></div>";

	$periodno=GetPeriod(Date($_SESSION['DefaultDateFormat']), $db);
	
	$sql = 'SELECT lastdate_in_period FROM periods WHERE periodno='.$periodno;
	$result = DB_query($sql,$db);
	$myrow=DB_fetch_array($result, $db);
	$lastdate_in_period=$myrow[0];
	
	$sql = 'SELECT periodno, lastdate_in_period FROM periods ORDER BY periodno DESC';
	$Periods = DB_query($sql,$db);

	while ($myrow=DB_fetch_array($Periods,$db)){
		if( $myrow['periodno']== $periodno){
			echo '<option selected VALUE=' . $myrow['periodno'] . '>' . ConvertSQLDate($lastdate_in_period);
		} else {
			echo '<option VALUE=' . $myrow['periodno'] . '>' . ConvertSQLDate($myrow['lastdate_in_period']);
		}
	}

	echo '</select>';

	echo "Detail Or Summary<select Name='Detail' class='md-input' >";
	echo "<option selected VALUE='Summary'>"._('Summary');
	echo "<option selected VALUE='Detailed'>"._('All Accounts');
	echo '</select>';

	
	echo "<div class='uk-width-1-1'><input type=submit Name='ShowBalanceSheet' class='md-btn md-btn-primary' Value='"._('Show Balance Sheet')."'>";
	
	echo "</div></div>";
//-------------------------------------------------End of first part------------------------------------------------


	/*Now do the posting while the user is thinking about the period to select */
	include ('includes/GLPostings.inc');

} else {
	
	echo "<form method='POST' action=" . $_SERVER['PHP_SELF'] . '?' . SID . '>';
	echo "<input type=hidden name='BalancePeriodEnd' VALUE=" . $_POST['BalancePeriodEnd'] . '>';

	$RetainedEarningsAct = $_SESSION['CompanyRecord']['retainedearnings'];

	$sql = 'SELECT lastdate_in_period FROM periods WHERE periodno=' . $_POST['BalancePeriodEnd'];
	$PrdResult = DB_query($sql, $db);
	$myrow = DB_fetch_row($PrdResult);
	$BalanceDate = ConvertSQLDate($myrow[0]);

	/*Calculate B/Fwd retained earnings- Total of Profit and Loss Statement */

	$SQL = 'SELECT Sum(CASE WHEN chartdetails.period=' . $_POST['BalancePeriodEnd'] . ' THEN chartdetails.bfwd + chartdetails.actual ELSE 0 END) AS accumprofitbfwd,
			Sum(CASE WHEN chartdetails.period=' . ($_POST['BalancePeriodEnd'] - 12) . " THEN chartdetails.bfwd + chartdetails.actual ELSE 0 END) AS lyaccumprofitbfwd
		FROM chartmaster INNER JOIN accountgroups
		ON chartmaster.group_ = accountgroups.groupname INNER JOIN chartdetails
		ON chartmaster.accountcode= chartdetails.accountcode
		WHERE accountgroups.pandl=1";

	$AccumProfitResult = DB_query($SQL,$db,_('The accumulated profits brought forward could not be calculated by the SQL because'));

	$AccumProfitRow = DB_fetch_array($AccumProfitResult); /*should only be one row returned */
	
	//left hand side equities

	$SQLequities = 'SELECT accountgroups.sectioninaccounts, 
			accountgroups.groupname,
			accountgroups.parentgroupname,
			chartdetails.accountcode,
			chartmaster.accountname,
			Sum(CASE WHEN chartdetails.period=' . $_POST['BalancePeriodEnd'] . ' THEN chartdetails.bfwd + chartdetails.actual ELSE 0 END) AS balancecfwd,
			Sum(CASE WHEN chartdetails.period=' . ($_POST['BalancePeriodEnd'] - 12) . ' THEN chartdetails.bfwd + chartdetails.actual ELSE 0 END) AS lybalancecfwd
		FROM chartmaster INNER JOIN accountgroups
		ON chartmaster.group_ = accountgroups.groupname INNER JOIN chartdetails
		ON chartmaster.accountcode= chartdetails.accountcode
		WHERE accountgroups.pandl=0 AND accountgroups.sectioninaccounts=1
		GROUP BY accountgroups.groupname,
			chartdetails.accountcode,
			chartmaster.accountname,
			accountgroups.parentgroupname,
			accountgroups.sequenceintb,
			accountgroups.sectioninaccounts
		ORDER BY accountgroups.sectioninaccounts,
			accountgroups.sequenceintb,
			accountgroups.groupname,
			chartdetails.accountcode';

	$AccountsResultequities = DB_query($SQLequities,$db,_('No general ledger accounts were returned by the SQL because'));
	
	echo '<b>BALANCE AS ON - ' . $BalanceDate . '</b>'; ?>
	
	<a href='PDFBalanceSheetbackup.php?perioddate=<?php echo $_POST['BalancePeriodEnd']; ?>' target='_blank'> <img src='icon_pdf.gif' /></a>
    
    <a href='PDFBalanceSheeteuro.php?perioddate=<?php echo $_POST['BalancePeriodEnd']; ?>' target='_blank'> <img src='icon_pdf.gif' /></a>
        
          
                            
          <div class="uk-grid" data-uk-grid-margin">
                <div class="uk-width-medium-1-2">
                    <div class="md-card" style="margin-top:10px">
                   <div class="md-card-content uk-overflow-container">


 <?php 

	echo '<table class="uk-table">';


// printing of the html balance sheet starts from here
	if ($_POST['Detail']=='Detailed'){
		$TableHeader = "<thead><tr>
				<th>"._('Account')."</td>
				<th>"._('Account Name')."</td>
				<th colspan=2>$BalanceDate</th>
				<th colspan=2>"._('Last Year').'</th>
				</tr></thead>';
	} else { /*summary */
		$TableHeader = "<thead><tr>
				<th colspan=2></th>
				<th colspan=2>$BalanceDate</th>
				<th colspan=2>"._('Last Year').'</th>
				</tr></thead>';
	}


	$k=0; //row colour counter
	$Section='';
	$SectionBalance = 0;
	$SectionBalanceLY = 0;

	$LYCheckTotal = 0;
	$CheckTotal = 0;

	$ActGrp ='';
	$Level=0;
	$ParentGroups=array();
	$ParentGroups[$Level]='';
	$GroupTotal = array(0);
	$LYGroupTotal = array(0);

	echo $TableHeader;
	$j=0; //row counter

	while ($myrowequities=DB_fetch_array($AccountsResultequities)) {
		$AccountBalanceequities = $myrowequities['balancecfwd'];
		$LYAccountBalanceequities = $myrowequities['lybalancecfwd'];

		if ($myrowequities['accountcode'] == $RetainedEarningsAct){
			$AccountBalanceequities += $AccumProfitRow['accumprofitbfwd'];
			$LYAccountBalanceequities += $AccumProfitRow['lyaccumprofitbfwd'];
		}

		if ($myrowequities['groupname']!= $ActGrp AND $ActGrp != '') {
			if ($myrowequities['parentgroupname']!=$ActGrp){
				while ($myrowequities['groupname']!=$ParentGroups[$Level] AND $Level>0){
					if ($_POST['Detail']=='Detailed'){
						echo '<tr>
							<td colspan=2></td>
      						<td><hr></td>
							<td></td>
							<td><hr></td>
							<td></td>
							</tr>';
					}
					printf('<td colspan=2><I>%s</I></td>
						<td class=number>%s</td>
						<td></td>
						<td class=number>%s</td>
						</tr>',
						$ParentGroups[$Level],
						number_format($GroupTotal[$Level]),
						number_format($LYGroupTotal[$Level])
						);
					$GroupTotal[$Level] = 0;
					$LYGroupTotal[$Level] = 0;
					$ParentGroups[$Level]='';
					$Level--;
					$j++;
				}
				if ($_POST['Detail']=='Detailed'){
					echo '<tr>
						<td colspan=2></td>
						<td><hr></td>
						<td></td>
						<td><hr></td>
						<td></td>
						</tr>';
				}

				printf('<td colspan=2>%s</td>
					<td class=number>%s</td>
					<td></td>
					<td class=number>%s</td>
					</tr>',
					$ParentGroups[$Level],
					number_format($GroupTotal[$Level]),
					number_format($LYGroupTotal[$Level])
					);
				$GroupTotal[$Level] = 0;
				$LYGroupTotal[$Level] = 0;
				$ParentGroups[$Level]='';
				$j++;
			}
		}
		
		
		//below statement displays section headings in the balance sheet
		if ($myrowequities['sectioninaccounts']!= $Section ){
		
			if ($Section!=''){
				if ($_POST['Detail']=='Detailed'){
					echo '<tr>
					<td colspan=2>dollar</td>
					<td><hr></td>
					<td></td>
					<td><hr></td>
					<td></td>
					</tr>';
				} else {
				
					echo '<tr>
					<td colspan=3></td>
					<td><hr></td>
					<td></td>
					<td><hr></td>
					</tr>';
				}
	
				printf('<tr>
					<td colspan=3><font size=4 color=RED>%s</font></td>
					<td class=number>%s</td>
					<td></td>
					<td class=number>%s</td>
				</tr>',
				$Sections[$Section],
				number_format($SectionBalance),
				number_format($SectionBalanceLY));
				$j++;
			}
			
			$SectionBalanceLY = 0;
			$SectionBalance = 0;
			$Section = $myrowequities['sectioninaccounts'];
			

			if ($_POST['Detail']=='Detailed'){
				printf('<tr>
					<td colspan=6><font size=4 color=BLUE><b>%s</b></font></td>
					</tr>',
					$Sections[$myrowequities['sectioninaccounts']]);
			}
		}//ends here

		if ($myrowequities['groupname']!= $ActGrp){

			if ($ActGrp!='' AND $myrowequities['parentgroupname']==$ActGrp){
				$Level++;
			}
		
			if ($_POST['Detail']=='Detailed'){
				$ActGrp = $myrowequities['groupname'];
				printf('<tr>
				<td colspan=6><font size=2 color=BLUE><b>%s</b></font></td>
				</tr>',
				$myrowequities['groupname']);
				echo $TableHeader;
			}
			$GroupTotal[$Level]=0;
			$LYGroupTotal[$Level]=0;
			$ActGrp = $myrowequities['groupname'];
			$ParentGroups[$Level]=$myrowequities['groupname'];
			$j++;
		}

		$SectionBalanceLY +=	$LYAccountBalance;
		$SectionBalance	  +=	$AccountBalance;
		for ($i=0;$i<=$Level;$i++){
			$LYGroupTotal[$i] += $LYAccountBalance;
			$GroupTotal[$i] += $AccountBalance;
		}
		$LYCheckTotal	  +=	$LYAccountBalance;
		$CheckTotal  	  +=	$AccountBalance;


		if ($_POST['Detail']=='Detailed'){

			if ($k==1){
				echo '<tr class="EvenTableRows">';
				$k=0;
			} else {
				echo '<tr class="EvenTableRows">';
				$k++;
			}

			$ActEnquiryURL = "<a href='$rootpath/lw_GLAccountInquiry_alt.php?" . SID . "Period=" . $_POST['BalancePeriodEnd'] . '&Account=' . $myrowequities['accountcode'] . "'>" . $myrowequities['accountcode'] . '<a>';

			$PrintString = '<td>%s</td>
					<td>%s</td>
					<td class=number>%s</td>
					<td></td>
					<td class=number>%s</td>
					<td></td>
					</tr>';

			printf($PrintString,
				$ActEnquiryURL,
				$myrowequities['accountname'],
				number_format($AccountBalance),
				number_format($LYAccountBalance)
				);
			$j++;
			
		}
		
	}
	//end of loop


	while ($myrowequities['groupname']!=$ParentGroups[$Level] AND $Level>0){
		if ($_POST['Detail']=='Detailed'){
			echo '<tr>
				<td colspan=2></td>
				<td><hr></td>
				<td></td>
				<td><hr></td>
				<td></td>
				</tr>';
		}
		printf('<td colspan=2><I>%s</I></td>
			<td class=number>%s</td>
			<td></td>
			<td class=number>%s</td>
			</tr>',
			$ParentGroups[$Level],
			number_format($GroupTotal[$Level]),
			number_format($LYGroupTotal[$Level])
			);
		$Level--;
	}
	if ($_POST['Detail']=='Detailed'){
		echo '<tr>
			<td colspan=2></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			</tr>';
	}

	printf('<td colspan=2>%s</td>
		<td class=number>%s</td>
		<td></td>
		<td class=number>%s</td>
		</tr>',
		$ParentGroups[$Level],
		number_format($GroupTotal[$Level]),
		number_format($LYGroupTotal[$Level])
		);
		
		echo '</table>';
		
		echo '</div></div></div>';
		
		
		
		/////////////////////////////////////////////
	
	
	 //------------------------------------------------------end here-----------------------------------------------------------------------
	 
	 //below starts assets right side section
	 
    $SQLAssets = 'SELECT accountgroups.sectioninaccounts, 
			accountgroups.groupname,
			accountgroups.parentgroupname,
			chartdetails.accountcode,
			chartmaster.accountname,
			Sum(CASE WHEN chartdetails.period=' . $_POST['BalancePeriodEnd'] . ' THEN chartdetails.bfwd + chartdetails.actual ELSE 0 END) AS balancecfwd,
			Sum(CASE WHEN chartdetails.period=' . ($_POST['BalancePeriodEnd'] - 12) . ' THEN chartdetails.bfwd + chartdetails.actual ELSE 0 END) AS lybalancecfwd
		FROM chartmaster INNER JOIN accountgroups
		ON chartmaster.group_ = accountgroups.groupname INNER JOIN chartdetails
		ON chartmaster.accountcode= chartdetails.accountcode
		WHERE accountgroups.pandl=0 AND accountgroups.sectioninaccounts=2
		GROUP BY accountgroups.groupname,
			chartdetails.accountcode,
			chartmaster.accountname,
			accountgroups.parentgroupname,
			accountgroups.sequenceintb,
			accountgroups.sectioninaccounts
		ORDER BY accountgroups.sectioninaccounts,
			accountgroups.sequenceintb,
			accountgroups.groupname,
			chartdetails.accountcode';

	$AccountsResultAssets = DB_query($SQLAssets,$db,_('No general ledger accounts were returned by the SQL because'));
?>

   <?php /*?> <div class="md-card" style="float:right; width:500px; height:2155px; overflow:scroll;">
    <div class="md-card-content">
    

	
<?php */?>
<!-- --------------------------------------------------------------------------------------------- ha right cha ahe ASSET cha-->

    <div class="uk-width-medium-1-2">
                    <div class="md-card" style="margin-top:10px">
                        <div class="md-card-content uk-overflow-container">                  
              
		
   <?php                 
		echo '<div class="md-input-wrapper">';
		
		echo '<table class="uk-table">';
		
// printing of the html balance sheet starts from here
	if ($_POST['Detail']=='Detailed'){
		$TableHeader = "<thead><tr>
				<th>"._('Account')."</td>
				<th>"._('Account Name')."</td>
				<th colspan=2>$BalanceDate</th>
				<th colspan=2>"._('Last Year').'</th>
				</tr></thead>';
	} else { /*summary */
		$TableHeader = "<thead><tr>
				<th colspan=2></th>
				<th colspan=2>$BalanceDate</th>
				<th colspan=2>"._('Last Year').'</th>
				</tr></thead>';
	}


	$k=0; //row colour counter
	$Section='';
	$SectionBalance = 0;
	$SectionBalanceLY = 0;

	$LYCheckTotal = 0;
	$CheckTotal = 0;

	$ActGrp ='';
	$Level=0;
	$ParentGroups=array();
	$ParentGroups[$Level]='';
	$GroupTotal = array(0);
	$LYGroupTotal = array(0);

	echo $TableHeader;
	$j=0; //row counter

	while ($myrowAssets=DB_fetch_array($AccountsResultAssets)) {
		$AccountBalanceAssets = $myrowAssets['balancecfwd'];
		$LYAccountBalanceAssets = $myrowAssets['lybalancecfwd'];

		if ($myrowAssets['accountcode'] == $RetainedEarningsAct){
			$AccountBalanceAssets += $AccumProfitRow['accumprofitbfwd'];
			$LYAccountBalanceAssets += $AccumProfitRow['lyaccumprofitbfwd'];
		}

		if ($myrowAssets['groupname']!= $ActGrp AND $ActGrp != '') {
			if ($myrowAssets['parentgroupname']!=$ActGrp){
				while ($myrowAssets['groupname']!=$ParentGroups[$Level] AND $Level>0){
					if ($_POST['Detail']=='Detailed'){
						echo '<tr>
							<td colspan=2></td>
      						<td><hr></td>
							<td></td>
							<td><hr></td>
							<td></td>
							</tr>';
					}
					printf('<td colspan=2><I>%s</I></td>
						<td class=number>%s</td>
						<td></td>
						<td class=number>%s</td>
						</tr>',
						$ParentGroups[$Level],
						number_format($GroupTotal[$Level]),
						number_format($LYGroupTotal[$Level])
						);
					$GroupTotal[$Level] = 0;
					$LYGroupTotal[$Level] = 0;
					$ParentGroups[$Level]='';
					$Level--;
					$j++;
				}
				if ($_POST['Detail']=='Detailed'){
					echo '<tr>
						<td colspan=2></td>
						<td><hr></td>
						<td></td>
						<td><hr></td>
						<td></td>
						</tr>';
				}

				printf('<td colspan=2>%s</td>
					<td class=number>%s</td>
					<td></td>
					<td class=number>%s</td>
					</tr>',
					$ParentGroups[$Level],
					number_format($GroupTotal[$Level]),
					number_format($LYGroupTotal[$Level])
					);
				$GroupTotal[$Level] = 0;
				$LYGroupTotal[$Level] = 0;
				$ParentGroups[$Level]='';
				$j++;
			}
		}
		
		
		//below statement displays section headings in the balance sheet
		if ($myrowAssets['sectioninaccounts']!= $Section ){

			if ($Section!=''){
				if ($_POST['Detail']=='Detailed'){
					echo '<tr>
					<td colspan=2></td>
					<td><hr></td>
					<td></td>
					<td><hr></td>
					<td></td>
					</tr>';
				} else {
					echo '<tr>
					<td colspan=3></td>
					<td><hr></td>
					<td></td>
					<td><hr></td>
					</tr>';
				}
	
				printf('<tr>
					<td colspan=3><font size=4 color=RED>%s Total</font></td>
					<td class=number>%s</td>
					<td></td>
					<td class=number>%s</td>
				</tr>',
				$Sections[$Section],
				number_format($SectionBalance),
				number_format($SectionBalanceLY));
				$j++;
			}
			$SectionBalanceLY = 0;
			$SectionBalance = 0;
			$Section = $myrowAssets['sectioninaccounts'];
			

			if ($_POST['Detail']=='Detailed'){
					printf('<tr>
					<td colspan=6><font size=4 color=BLUE><b>%s</b></font></td>
					</tr>',
					$Sections[$myrowAssets['sectioninaccounts']]);
			}
		}

		if ($myrowAssets['groupname']!= $ActGrp){

			if ($ActGrp!='' AND $myrowAssets['parentgroupname']==$ActGrp){
				$Level++;
			}
		
			if ($_POST['Detail']=='Detailed'){
				$ActGrp = $myrowAssets['groupname'];
				printf('<tr>
				<td colspan=6><font size=2 color=BLUE><b>%s</b></font></td>
				</tr>',
				$myrowAssets['groupname']);
				echo $TableHeader;
			}
			$GroupTotal[$Level]=0;
			$LYGroupTotal[$Level]=0;
			$ActGrp = $myrowAssets['groupname'];
			$ParentGroups[$Level]=$myrowAssets['groupname'];
			$j++;
		}

		$SectionBalanceLY +=	$LYAccountBalance;
		$SectionBalance	  +=	$AccountBalance;
		for ($i=0;$i<=$Level;$i++){
			$LYGroupTotal[$i] += $LYAccountBalance;
			$GroupTotal[$i] += $AccountBalance;
		}
		$LYCheckTotal	  +=	$LYAccountBalance;
		$CheckTotal  	  +=	$AccountBalance;


		if ($_POST['Detail']=='Detailed'){

			if ($k==1){
				echo '<tr class="EvenTableRows">';
				$k=0;
			} else {
				echo '<tr class="EvenTableRows">';
				$k++;
			}

			$ActEnquiryURL = "<a href='$rootpath/lw_GLAccountInquiry_alt.php?" . SID . "Period=" . $_POST['BalancePeriodEnd'] . '&Account=' . $myrowAssets['accountcode'] . "'>" . $myrowAssets['accountcode'] . '<a>';

			$PrintString = '<td>%s</td>
					<td>%s</td>
					<td class=number>%s</td>
					<td></td>
					<td class=number>%s</td>
					<td></td>
					</tr>';

			printf($PrintString,
				$ActEnquiryURL,
				$myrowAssets['accountname'],
				number_format($AccountBalance),
				number_format($LYAccountBalance)
				);
			$j++;
			
		}
		
	}
	//end of loop


	while ($myrowAssets['groupname']!=$ParentGroups[$Level] AND $Level>0){
		if ($_POST['Detail']=='Detailed'){
			echo '<tr>
				<td colspan=2></td>
				<td><hr></td>
				<td></td>
				<td><hr></td>
				<td></td>
				</tr>';
		}
		printf('<td colspan=2><I>%s</I></td>
			<td class=number>%s</td>
			<td></td>
			<td class=number>%s</td>
			</tr>',
			$ParentGroups[$Level],
			number_format($GroupTotal[$Level]),
			number_format($LYGroupTotal[$Level])
			);
		$Level--;
	}
	if ($_POST['Detail']=='Detailed'){
		echo '<tr>
			<td colspan=3></td>
			<td></td>
			<td></td>
			<td></td>
			</tr>';
	}

	printf('<td colspan=2>%s</td>
		<td class=number>%s</td>
		<td></td>
		<td class=number>%s</td>
		<td></td>
		</tr>',
		$ParentGroups[$Level],
		number_format($GroupTotal[$Level]),
		number_format($LYGroupTotal[$Level])
		);
		
		echo '</table>';
		
		echo '</div></div></div></div></div>';		
		
		
		//ithe equities and liabilities main group chya  baher padla aahe ------++++++++
	
	if ($_POST['Detail']=='Detailed'){
			
		?>
		     <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-medium-1-2">
                    <div class="md-card">
                        <div class="md-card-content">
                   <div class="uk-width-medium-1-1" style="margin-left:10px">
	<?php	echo '<table class="uk-table">
		<td colspan=2></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		</tr></table>';
       } else {
		echo '<table><tr>
		<td colspan=3></td>
		<td></td>
		<td></td>
		<td></td>
		</tr></table>';
		
	}
				//Equity ithe ahe++++++++++++++++++++++++++++++++
			
			printf('<table class="uk-table"><tr>
		<td colspan=4><font size=4 color=GREEN>Total Equity</font></td> 
		<td class=number><font size=4 color=GREEN>%s</font></td>
		<td colspan=4><font size=4 color=GREEN>%s</font></td>
		<td class=number>%s</td>
	</tr>',
	$Sections[$Section],
	number_format($SectionBalance),
	number_format($SectionBalanceLY));
	
	$Section = $myrowAssets['sectioninaccounts'];

	if (isset($myrowAssets['sectioninaccounts']) and $_POST['Detail']=='Detailed'){
		printf('<tr>
			<td colspan=6><font size=4 color=BLUE><b>%s</b></font></td>
			</tr>',
			$Sections[$myrowAssets['sectioninaccounts']]);
	}
	
		printf('<tr>
		<td colspan=6><font size=4 color=GREEN>'._('Check Total').'</font></td>
		<td class=number><font size=4 color=GREEN>%s</font></td>
		<td class=number colspan=6>%s</td>
		</tr>',
		number_format($CheckTotal),
		number_format($LYCheckTotal).'Tu');								
																		
																		
																		
																	

	echo '</table></div></div></div></div>';
	     //split below table

  
	if ($_POST['Detail']=='Detailed'){ ?>
    
  <div class="uk-width-large-1-2">
                    <div class="md-card">
                     <div class="md-card-content">              
   <?php      
      
   echo '<table class="uk-table"><tr>
		<td colspan=2></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		</tr></table>';
	} else {
	echo '<div class="uk-width-medium-1-1" style="margin-left:400px">';
	    echo '<div class="uk-width-large-1-2">
                    <div class="md-card">
                     <div class="md-card-content">
               <div class="uk-width-medium-1-1" style="margin-left:10px">';
	
		echo '<table class="uk-table"><tr>
		<td colspan=2></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		</tr></table>';
	
	}
																			//Asset ithe ahe+++++++++++++++++++++++++++++
		printf('<table class="uk-table"><tr>
		<td colspan=3><font size=4 color=GREEN>Total Assets %s</font></td> 
		<td class=number><font size=4 color=GREEN>%s</font></td>
		<td></td>
		<td class=number>%s</td>
	</tr>',
	$Sections[$Section],
	number_format($SectionBalance),
	number_format($SectionBalanceLY));
	
	$Section = $myrow['sectioninaccounts'];

	if (isset($myrow['sectioninaccounts']) and $_POST['Detail']=='Detailed'){
		printf('<tr>
			<td colspan=6><font size=4 color=BLUE><b>%s</b></font></td>
			</tr>',
			$Sections[$myrow['sectioninaccounts']]);
	}
	
	echo '<tr>
		
		</tr>';

	printf('<tr>
		<td colspan=3><font size=4 color=GREEN>'._('Check Total').'</font></td>
		<td class=number><font size=4 color=GREEN>%s</font></td>
		<td></td>
		<td class=number>%s</td>
		</tr>',
		number_format($CheckTotal),
		number_format($LYCheckTotal).'mi');

	echo '</table></div></div></div></div></div></div>';
		
		 
   
// For new ----------------------------------
    echo "<div style='padding-bottom:10px; margin-left:600px'><input type=submit Name='SelectADifferentPeriod' class='md-btn md-btn-primary' Value='"._('Select A Different Balance Date')."'></div>";
}

echo '</form>';

?>
