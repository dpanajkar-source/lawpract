<?php
/* $Revision: 1.12 $ */
$PageSecurity = 9;
include('includes/session.php');

	include('includes/PDFStarter.php');
	$PageNumber = 0;
	$FontSize = 10;
	$pdf->addinfo('Title', _('Balance Sheet') );
	$pdf->addinfo('Subject', _('Balance Sheet') );
	$line_height = 10;

	$RetainedEarningsAct = $_SESSION['CompanyRecord']['retainedearnings'];
		
	$_POST['Detail']='Detailed';

	//$sql = 'SELECT lastdate_in_period FROM periods WHERE periodno=' . $_POST['BalancePeriodEnd'];
	
	//$periodno=GetPeriod(Date($_SESSION['DefaultDateFormat']), $db);
	
	$periodno=$_GET['perioddate'];
	
	$sql = 'SELECT lastdate_in_period FROM periods WHERE periodno=' . $periodno;
	$PrdResult = DB_query($sql, $db);
	$myrow = DB_fetch_row($PrdResult);
	$BalanceDate = ConvertSQLDate($myrow[0]);

	/*Calculate B/Fwd retained earnings */

	$SQL = 'SELECT Sum(CASE WHEN chartdetails.period=' . $periodno . ' THEN chartdetails.bfwd + chartdetails.actual ELSE 0 END) AS accumprofitbfwd,
			Sum(CASE WHEN chartdetails.period=' . ($periodno - 12) . " THEN chartdetails.bfwd + chartdetails.actual ELSE 0 END) AS lyaccumprofitbfwd
		FROM chartmaster INNER JOIN accountgroups
		ON chartmaster.group_ = accountgroups.groupname INNER JOIN chartdetails
		ON chartmaster.accountcode= chartdetails.accountcode
		WHERE accountgroups.pandl=1";

	$AccumProfitResult = DB_query($SQL,$db);
	if (DB_error_no($db) !=0) {
		$title = _('Balance Sheet') . ' - ' . _('Problem Report') . '....';
		
		prnMsg( _('The accumulated profits brought forward (Profit & Loss Statement) could not be calculated by the SQL because') . ' - ' . DB_error_msg($db) );
		echo '<br><a href="' .$rootpath .'/index.php?' . SID . '">'. _('Back to the menu'). '</a>';
		if ($debug==1){
			echo '<br>'. $SQL;
		}
		
		exit;
	}

	$AccumProfitRow = DB_fetch_array($AccumProfitResult); /*should only be one row returned */

//left hand side- Equities DISPLAY 
	$SQL = 'SELECT accountgroups.sectioninaccounts,
			accountgroups.groupname,
			accountgroups.parentgroupname,
			chartdetails.accountcode ,
			chartmaster.accountname,
			Sum(CASE WHEN chartdetails.period=' . $periodno . ' THEN chartdetails.bfwd + chartdetails.actual ELSE 0 END) AS balancecfwd,
			Sum(CASE WHEN chartdetails.period=' . ($periodno - 12) . ' THEN chartdetails.bfwd + chartdetails.actual ELSE 0 END) AS lybalancecfwd
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

	$AccountsResult = DB_query($SQL,$db);	
	

	if (DB_error_no($db) !=0) {
		$title = _('Balance Sheet') . ' - ' . _('Problem Report') . '....';
	
		prnMsg( _('No general ledger accounts were returned by the SQL because') . ' - ' . DB_error_msg($db) );
		echo '<br><a href="' .$rootpath .'/index.php?' . SID . '">'. _('Back to the menu'). '</a>';
		if ($debug==1){
			echo '<br>'. $SQL;
		}
		
		exit;
	}

	include('includes/PDFBalanceSheetPageHeader.inc');

  
   $YPos = $Page_Height - 25;
	
	$YPos -= $line_height;
	$YPos=$YPos-20;

	$k=0; //row colour counter
	$Section='';
	$SectionBalance = 0;
	$SectionBalanceLY = 0;

	$LYCheckTotal = 0;
	$CheckTotal = 0;

	$ActGrp ='';
	$Level =0;
	$ParentGroups = array();
	$ParentGroups[$Level]='';
	$GroupTotal = array(0);
	$LYGroupTotal = array(0);

	while ($myrow=DB_fetch_array($AccountsResult)) {
		$AccountBalance = $myrow['balancecfwd'];
		$LYAccountBalance = $myrow['lybalancecfwd'];

		if ($myrow['accountcode'] == $RetainedEarningsAct){
			$AccountBalance += $AccumProfitRow['accumprofitbfwd'];
			$LYAccountBalance += $AccumProfitRow['lyaccumprofitbfwd'];
		}
		if ($ActGrp !=''){
        		if ($myrow['groupname']!=$ActGrp){
				$FontSize = 8;
				$pdf->selectFont('./fonts/Helvetica-Bold.afm');
        			while ($myrow['groupname']!= $ParentGroups[$Level] AND $Level>0) {
        				$YPos -= $line_height;
        				$LeftOvers = $pdf->addTextWrap($Left_Margin+(10 * ($Level+1))+30,$YPos,200,$FontSize,_('Total') . ' ' . $ParentGroups[$Level]);
        				$LeftOvers = $pdf->addTextWrap($Left_Margin+170,$YPos,100,$FontSize,number_format($GroupTotal[$Level]),'right');
        				$LeftOvers = $pdf->addTextWrap($Left_Margin+250,$YPos,100,$FontSize,number_format($LYGroupTotal[$Level]),'right');
        				$ParentGroups[$Level]='';
        				$GroupTotal[$Level]=0;
        				$LYGroupTotal[$Level]=0;
        				$Level--;
        			}
        			$YPos -= $line_height;
        			$LeftOvers = $pdf->addTextWrap($Left_Margin+(10 * ($Level+1))+30,$YPos,200,$FontSize,_('Total') . ' ' . $ParentGroups[$Level]);
        			$LeftOvers = $pdf->addTextWrap($Left_Margin+170,$YPos,100,$FontSize,number_format($GroupTotal[$Level]),'right');
        			$LeftOvers = $pdf->addTextWrap($Left_Margin+250,$YPos,100,$FontSize,number_format($LYGroupTotal[$Level]),'right');
        			$ParentGroups[$Level]='';
        			$GroupTotal[$Level]=0;
        			$LYGroupTotal[$Level]=0;
        			$YPos -= $line_height;
        		}
                }

		if ($myrow['sectioninaccounts']!= $Section){

			if ($Section !=''){
				$FontSize = 8;
				$pdf->selectFont('./fonts/Helvetica-Bold.afm');
				$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,200,$FontSize,$Sections[$Section]);
				$LeftOvers = $pdf->addTextWrap($Left_Margin+170,$YPos,100,$FontSize,number_format($SectionBalance),'right');
				$LeftOvers = $pdf->addTextWrap($Left_Margin+250,$YPos,100,$FontSize,number_format($SectionBalanceLY),'right');
				$YPos -= (2 * $line_height);
			}
			$SectionBalanceLY = 0;
			$SectionBalance = 0;

			$Section = $myrow['sectioninaccounts'];
			if ($_POST['Detail']=='Detailed'){
				$pdf->SetTextColor(0, 0, 102);
				$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos-10,250,$FontSize,_('Section') . ' ' . $myrow['sectioninaccounts']);
				$YPos -= (2 * $line_height);

			}
		}
	$pdf->SetTextColor(0, 0, 0);
		if ($myrow['groupname']!= $ActGrp){
                        $FontSize =8;
                        $pdf->selectFont('./fonts/Helvetica-Bold.afm');
			if ($myrow['parentgroupname']==$ActGrp AND $ActGrp!=''){
				$Level++;
			}
			$ActGrp = $myrow['groupname'];
			$ParentGroups[$Level] = $ActGrp;
			if ($_POST['Detail']=='Detailed'){
				$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,250,$FontSize,$myrow['groupname']);
				$YPos -= $line_height;
			}
			$GroupTotal[$Level]=0;
			$LYGroupTotal[$Level]=0;
		}

		$SectionBalanceLY +=	$LYAccountBalance;
		$SectionBalance	  +=	$AccountBalance;

		for ($i=0;$i<=$Level;$i++){
			$LYGroupTotal[$i]  +=	$LYAccountBalance;
			$GroupTotal[$i]	  +=	$AccountBalance;
		}
		$LYCheckTotal 	  +=	$LYAccountBalance;
		$CheckTotal  	  +=	$AccountBalance;


		if ($_POST['Detail']=='Detailed'){
		        $FontSize =8;
			$pdf->selectFont('./fonts/Helvetica.afm');
			$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,50,$FontSize,$myrow['accountcode']);
			$LeftOvers = $pdf->addTextWrap($Left_Margin+55,$YPos,200,$FontSize,$myrow['accountname']);
			$LeftOvers = $pdf->addTextWrap($Left_Margin+170,$YPos,100,$FontSize,number_format($AccountBalance),'right');
			$LeftOvers = $pdf->addTextWrap($Left_Margin+250,$YPos,100,$FontSize,number_format($LYAccountBalance),'right');
			$YPos -= $line_height;
		}
		if ($YPos < ($Bottom_Margin)){
			include('includes/PDFBalanceSheetPageHeader.inc');
            //$pdf->AddPage();
		}
          



    }//end of main while loop for assets

     $FontSize = 8;
	$pdf->selectFont('./fonts/Helvetica-Bold.afm');
	while ($Level>0) {
        	$YPos -= $line_height;
        	$LeftOvers = $pdf->addTextWrap($Left_Margin+(10 * ($Level+1))+90,$YPos,200,$FontSize,_('Total') . ' ' . $ParentGroups[$Level]);
        	$LeftOvers = $pdf->addTextWrap($Left_Margin+170,$YPos,100,$FontSize,number_format($GroupTotal[$Level]),'right');
        	$LeftOvers = $pdf->addTextWrap($Left_Margin+250,$YPos,100,$FontSize,number_format($LYGroupTotal[$Level]),'right');
        	$ParentGroups[$Level]='';
        	$GroupTotal[$Level]=0;
        	$LYGroupTotal[$Level]=0;
        	$Level--;
        }
        $YPos -= $line_height;
		//below is for misc exps.
        $LeftOvers = $pdf->addTextWrap($Left_Margin+(10 * ($Level+1))+30,$YPos,200,$FontSize,_('Total') . ' ' . $ParentGroups[$Level]);
        $LeftOvers = $pdf->addTextWrap($Left_Margin+170,$YPos,100,$FontSize,number_format($GroupTotal[$Level]),'right');
        $LeftOvers = $pdf->addTextWrap($Left_Margin+250,$YPos,100,$FontSize,number_format($LYGroupTotal[$Level]),'right');
        $ParentGroups[$Level]='';
        $GroupTotal[$Level]=0;
        $LYGroupTotal[$Level]=0;
        $YPos -= $line_height;

        if ($SectionBalanceLY+$SectionBalance !=0){
	        $FontSize =9;
			$pdf->SetTextColor(0, 128, 0);
		$pdf->selectFont('./fonts/Helvetica-Bold.afm');
		$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,200,$FontSize,_('Section Total') . ' ' . $Sections[$Section]);
		$LeftOvers = $pdf->addTextWrap($Left_Margin+170,$YPos,100,$FontSize,number_format($SectionBalance),'right');
		$LeftOvers = $pdf->addTextWrap($Left_Margin+250,$YPos,100,$FontSize,number_format($SectionBalanceLY),'right');
		//$YPos -= $line_height;
	}

	$YPos -= $line_height;
	$pdf->SetTextColor(0,0,255);
	$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,200,$FontSize,_('Check Total'));
	$LeftOvers = $pdf->addTextWrap($Left_Margin+170,$YPos,100,$FontSize,number_format($CheckTotal),'right');
	$LeftOvers = $pdf->addTextWrap($Left_Margin+250,$YPos,100,$FontSize,number_format($LYCheckTotal),'right');

	$pdf->SetTextColor(0,0,0);

$PageNumber = 0;	
	

//Right side- Equities and Liabilities sql

	$SQLequities = 'SELECT accountgroups.sectioninaccounts,
			accountgroups.groupname,
			accountgroups.parentgroupname,
			chartdetails.accountcode,
			chartmaster.accountname,
			Sum(CASE WHEN chartdetails.period=' . $periodno . ' THEN chartdetails.bfwd + chartdetails.actual ELSE 0 END) AS balancecfwd,
			Sum(CASE WHEN chartdetails.period=' . ($periodno - 12) . ' THEN chartdetails.bfwd + chartdetails.actual ELSE 0 END) AS lybalancecfwd
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

	$AccountsResultequities = DB_query($SQLequities,$db);

	if (DB_error_no($db) !=0) {
		$title = _('Balance Sheet') . ' - ' . _('Problem Report') . '....';
		//include('includes/header.php');
		prnMsg( _('No general ledger accounts were returned by the SQL because') . ' - ' . DB_error_msg($db) );
		echo '<br><a href="' .$rootpath .'/index.php?' . SID . '">'. _('Back to the menu'). '</a>';
		if ($debug==1){
			echo '<br>'. $SQLequities;
		}
		
		exit;
	}

	//include('includes/PDFBalanceSheetPageHeader.inc');


	 
	$PageNumber++;
	if ($PageNumber>1){
		$pdf->newPage();
	}
	
	$FontSize = 8;
	$YPos = $Page_Height - 25;
	
	$YPos -= $line_height;
	$YPos=$YPos-20;

	$k=0; //row colour counter
	$Section='';
	$SectionBalance = 0;
	$SectionBalanceLY = 0;

	$LYCheckTotal = 0;
	$CheckTotal = 0;

	$ActGrp ='';
	$Level =0;
	$ParentGroups = array();
	$ParentGroups[$Level]='';
	$GroupTotal = array(0);
	$LYGroupTotal = array(0);

	while ($myrowequities=DB_fetch_array($AccountsResultequities)) {
		$AccountBalance = $myrowequities['balancecfwd'];
		$LYAccountBalance = $myrowequities['lybalancecfwd'];

		if ($myrowequities['accountcode'] == $RetainedEarningsAct){
			$AccountBalance += $AccumProfitRow['accumprofitbfwd'];
			$LYAccountBalance += $AccumProfitRow['lyaccumprofitbfwd'];
		}
		if ($ActGrp !=''){
        		if ($myrowequities['groupname']!=$ActGrp){
				$FontSize = 8;
				$pdf->selectFont('./fonts/Helvetica-Bold.afm');
        			while ($myrowequities['groupname']!= $ParentGroups[$Level] AND $Level>0) {
        				$YPos -= $line_height;
        				$LeftOvers = $pdf->addTextWrap($Left_Margin+(10 * ($Level+1)+430),$YPos,200,$FontSize,_('Total') . ' ' . $ParentGroups[$Level]);
        				$LeftOvers = $pdf->addTextWrap($Left_Margin+570,$YPos,100,$FontSize,number_format($GroupTotal[$Level]),'right');
        				$LeftOvers = $pdf->addTextWrap($Left_Margin+650,$YPos,100,$FontSize,number_format($LYGroupTotal[$Level]),'right');
        				$ParentGroups[$Level]='';
        				$GroupTotal[$Level]=0;
        				$LYGroupTotal[$Level]=0;
        				$Level--;
        			}
        			$YPos -= $line_height;
        			$LeftOvers = $pdf->addTextWrap($Left_Margin+(10 * ($Level+1)+430),$YPos,200,$FontSize,_('Total') . ' ' . $ParentGroups[$Level]);
        			$LeftOvers = $pdf->addTextWrap($Left_Margin+570,$YPos,100,$FontSize,number_format($GroupTotal[$Level]),'right');
        			$LeftOvers = $pdf->addTextWrap($Left_Margin+650,$YPos,100,$FontSize,number_format($LYGroupTotal[$Level]),'right');
        			$ParentGroups[$Level]='';
        			$GroupTotal[$Level]=0;
        			$LYGroupTotal[$Level]=0;
        			$YPos -= $line_height;
					
        		}
                }

		if ($myrowequities['sectioninaccounts']!= $Section){

			if ($Section !=''){
				$FontSize = 8;
				$pdf->selectFont('./fonts/Helvetica-Bold.afm');
				$LeftOvers = $pdf->addTextWrap($Left_Margin,$YPos,200,$FontSize,$Sections[$Section]);
				$LeftOvers = $pdf->addTextWrap($Left_Margin+570,$YPos,100,$FontSize,number_format($SectionBalance),'right');
				$LeftOvers = $pdf->addTextWrap($Left_Margin+650,$YPos,100,$FontSize,number_format($SectionBalanceLY),'right');
				$YPos -= (2 * $line_height);
			}
			$SectionBalanceLY = 0;
			$SectionBalance = 0;

			$Section = $myrowequities['sectioninaccounts'];
			if ($_POST['Detail']=='Detailed'){
				$pdf->SetTextColor(0, 0, 102);
				$LeftOvers = $pdf->addTextWrap($Left_Margin+400,$YPos-10,250,$FontSize,_('Section') . ' ' . $myrowequities['sectioninaccounts']);
				$YPos -= (2 * $line_height);

			}
		}
$pdf->SetTextColor(0, 0, 0);
		if ($myrowequities['groupname']!= $ActGrp){
                        $FontSize =8;
                        $pdf->selectFont('./fonts/Helvetica-Bold.afm');
			if ($myrowequities['parentgroupname']==$ActGrp AND $ActGrp!=''){
				$Level++;
			}
			$ActGrp = $myrowequities['groupname'];
			$ParentGroups[$Level] = $ActGrp;
			if ($_POST['Detail']=='Detailed'){
				$LeftOvers = $pdf->addTextWrap($Left_Margin+400,$YPos,200,$FontSize,$myrowequities['groupname']);
				$YPos -= $line_height;
			}
			$GroupTotal[$Level]=0;
			$LYGroupTotal[$Level]=0;
		}

		$SectionBalanceLY +=	$LYAccountBalance;
		$SectionBalance	  +=	$AccountBalance;

		for ($i=0;$i<=$Level;$i++){
			$LYGroupTotal[$i]  +=	$LYAccountBalance;
			$GroupTotal[$i]	  +=	$AccountBalance;
		}
		$LYCheckTotal 	  +=	$LYAccountBalance;
		$CheckTotal  	  +=	$AccountBalance;


		if ($_POST['Detail']=='Detailed'){
		        $FontSize =8;
			$pdf->selectFont('./fonts/Helvetica.afm');
			$LeftOvers = $pdf->addTextWrap($Left_Margin+400,$YPos,50,$FontSize,$myrowequities['accountcode']);
			$LeftOvers = $pdf->addTextWrap($Left_Margin+455,$YPos,200,$FontSize,$myrowequities['accountname']);
			$LeftOvers = $pdf->addTextWrap($Left_Margin+570,$YPos,100,$FontSize,number_format($AccountBalance),'right');
			$LeftOvers = $pdf->addTextWrap($Left_Margin+650,$YPos,100,$FontSize,number_format($LYAccountBalance),'right');
			$YPos -= $line_height;
		}
		if ($YPos < ($Bottom_Margin)){
			include('includes/PDFBalanceSheetPageHeader.inc');
		}
	}//end of loop

        $FontSize = 8;
	$pdf->selectFont('./fonts/Helvetica-Bold.afm');
	while ($Level>0) {
        	$YPos -= $line_height;
        	$LeftOvers = $pdf->addTextWrap($Left_Margin+(10 * ($Level+1)+430),$YPos,200,$FontSize,_('Total') . ' ' . $ParentGroups[$Level]);
        	$LeftOvers = $pdf->addTextWrap($Left_Margin+570,$YPos,100,$FontSize,number_format($GroupTotal[$Level]),'right');
        	$LeftOvers = $pdf->addTextWrap($Left_Margin+650,$YPos,100,$FontSize,number_format($LYGroupTotal[$Level]),'right');
        	$ParentGroups[$Level]='';
        	$GroupTotal[$Level]=0;
        	$LYGroupTotal[$Level]=0;
        	$Level--;
        }
        $YPos -= $line_height;
        $LeftOvers = $pdf->addTextWrap($Left_Margin+(10 * ($Level+1)+430),$YPos,200,$FontSize,_('Total') . ' ' . $ParentGroups[$Level]);
        $LeftOvers = $pdf->addTextWrap($Left_Margin+570,$YPos,100,$FontSize,number_format($GroupTotal[$Level]),'right');
        $LeftOvers = $pdf->addTextWrap($Left_Margin+650,$YPos,100,$FontSize,number_format($LYGroupTotal[$Level]),'right');
        $ParentGroups[$Level]='';
        $GroupTotal[$Level]=0;
        $LYGroupTotal[$Level]=0;
        $YPos -= $line_height;

        if ($SectionBalanceLY+$SectionBalance !=0){
	          $FontSize =9;
			$pdf->SetTextColor(0, 128, 0);
		$pdf->selectFont('./fonts/Helvetica-Bold.afm');
		$LeftOvers = $pdf->addTextWrap($Left_Margin+400,$YPos,200,$FontSize,_('Section Total') . ' ' . $Sections[$Section]);
		$LeftOvers = $pdf->addTextWrap($Left_Margin+570,$YPos,100,$FontSize,number_format($SectionBalance),'right');
		$LeftOvers = $pdf->addTextWrap($Left_Margin+650,$YPos,100,$FontSize,number_format($SectionBalanceLY),'right');
		//$YPos -= $line_height;
	}
	

	$YPos -= $line_height;
	
	$pdf->SetTextColor(0, 0, 255);

	$LeftOvers = $pdf->addTextWrap($Left_Margin+400,$YPos,200,$FontSize,_('Check Total'));
	$LeftOvers = $pdf->addTextWrap($Left_Margin+570,$YPos,100,$FontSize,number_format($CheckTotal),'right');
	$LeftOvers = $pdf->addTextWrap($Left_Margin+650,$YPos,100,$FontSize,number_format($LYCheckTotal),'right');

	
	$pdfcode = $pdf->output();
	$len = strlen($pdfcode);
	
      
		header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: inline; filename=BalanceSheetIndian.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		
		$pdf->Output('BalanceSheetIndian.pdf','I');
	exit;

?>
