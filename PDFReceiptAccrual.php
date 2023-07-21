<?php
/* $Revision: 1.12 $ */

$PageSecurity = 13;
include('includes/session.php');
include('includes/PDFStarter.php');


	$PageNumber = 0;
	$FontSize=10;
	$pdf->addinfo('Title', _('Bank Receipt'));
	$pdf->addinfo('Subject', _('Bank Receipt'));

	$line_height=12;


$sqlpartytrans = "SELECT 
			lw_partytrans.brief_file,
			lw_partytrans.party,
			lw_partytrans.transno,
            lw_partytrans.invoiceno,
			lw_partytrans.amountreceived,
			lw_partytrans.receivedt,
			lw_partytrans.chequeno,
			lw_partytrans.ourbankcode,	
			lw_partytrans.narration
	FROM lw_partytrans WHERE lw_partytrans.transno = '" . $_GET['transno'] . "'";
	$StatementResultspartytrans=DB_query($sqlpartytrans,$db);
	$myrowpartytransdetails=DB_fetch_array($StatementResultspartytrans);
	
	$brief_file=$myrowpartytransdetails['brief_file'];
	$resultparty=DB_query("SELECT name,address,mobile FROM lw_contacts WHERE lw_contacts.id='".$myrowpartytransdetails['party']."'",$db);	
	$myrowpartydetails=DB_fetch_array($resultparty);

	
	$brief_file=$myrowpartytransdetails['brief_file'];
	
	$sqltotalreceivedamt = "SELECT SUM(lw_partytrans.amountreceived) AS totalreceived
			FROM lw_partytrans WHERE lw_partytrans.transno <= '" . $_GET['transno'] . "' AND lw_partytrans.brief_file = '" . $brief_file . "'";
	
	$StatementResulttotalreceived=DB_query($sqltotalreceivedamt,$db);
	$myrowtotalreceived=DB_fetch_array($StatementResulttotalreceived);
	
	
	$resultparty=DB_query("SELECT name,address,mobile FROM lw_contacts WHERE lw_contacts.id='" . $myrowpartytransdetails['party'] . "'",$db);	
	$myrowpartydetails=DB_fetch_array($resultparty);

	$sqlpartyeconomy = "SELECT lw_partyeconomy.courtcaseno,lw_partyeconomy.totalfees,lw_partyeconomy.balance FROM lw_partyeconomy WHERE lw_partyeconomy.brief_file ='" . $brief_file . "'";
	$StatementResultsEconomy=DB_query($sqlpartyeconomy,$db);	
	
	$myrowpartyeconomydetails=DB_fetch_array($StatementResultsEconomy);
	
	$tilldatebalance=$myrowpartyeconomydetails['totalfees']-$myrowtotalreceived['totalreceived'];
	
	if (DB_error_no($db) !=0) {
	  $title = _('Transaction Details') . ' - ' . _('Problem Report') . '....';
	    prnMsg( _('The Transaction Details could not be retrieved by the SQL because') . ' - ' . DB_error_msg($db) );
	   echo '<br><a href="' .$rootpath .'/index.php?' . SID . '">'. _('Back to the menu'). '</a>';
	   if ($debug==1){
	      echo '<br>'. $sql;
	   }
	   
	   exit;
	}	

			include('includes/PDFBankReceiptPageHeader.php');
			$FontSize=10;
			
			

	//upper and middle horizontal line
$pdf->line($Page_Width-$Right_Margin-70, $YPos+50,$Left_Margin+70, $YPos+50);	
//main vertical line
$pdf->line($Page_Width-$Right_Margin-702, $YPos+$line_height-298,$Page_Width-$Right_Margin-702, $YPos+50);
$pdf->line($Page_Width-$Right_Margin-70, $YPos+$line_height-298,$Page_Width-$Right_Margin-70, $YPos+50);

//$pdf->line($Page_Width-$Right_Margin-80, $YPos+50,$Left_Margin, $YPos+50);	
	$id=1;
				
	 			
				$FontSize=9;
				$YPos -=$line_height;
				if ($YPos < ($Bottom_Margin + 80)){
					include('includes/PDFBankReceiptPageHeader.php');
				}
				$FontSize=10;
				$YPos -=$line_height;
				if ($YPos < ($Bottom_Margin + 80)){
					include('includes/PDFBankReceiptPageHeader.php');
				}
				$pdf->selectFont('./fonts/Helvetica-Bold.afm');
				
				
				$FontSize=9;
				$YPos -=$line_height;



            $LeftOvers = $pdf->addTextWrap(570,$YPos+70,150,$FontSize, _('TRANSACTION NO'),'left');
	        $LeftOvers = $pdf->addTextWrap(665,$YPos+70,260-$Left_Margin,$FontSize,': ' . $myrowpartytransdetails['transno']);
            $LeftOvers = $pdf->addTextWrap(570,$YPos+50,150,$FontSize,_('DATE'),'left');
            $LeftOvers = $pdf->addTextWrap(570,$YPos+30,150,$FontSize, _('INVOICE NO'),'left');
            $LeftOvers = $pdf->addTextWrap(665,$YPos+30,260-$Left_Margin,$FontSize,': ' . $myrowpartytransdetails['invoiceno']);

				 $LeftOvers = $pdf->addTextWrap(665,$YPos+50,200,$FontSize,': ' . ConvertSQLDate($myrowpartytransdetails['receivedt']));
				 
		
				 $pdf->SetFont('Helvetica','BI',16);
				$LeftOvers = $pdf->addTextWrap(120,$YPos+10,200,$FontSize, _('RECEIVED WITH THANKS FROM'),'left');	
$pdf->selectFont('./fonts/Helvetica.afm');
				$LeftOvers = $pdf->addTextWrap(261,$YPos+10,1000,$FontSize,': ' . $myrowpartydetails['name']);
			
				//$LeftOvers = $pdf->addTextWrap(120,$YPos-30,150,$FontSize, _('MOBILE NO'),'left');
				///$LeftOvers = $pdf->addTextWrap(300,$YPos-30,150,$FontSize,': ' . $myrowpartydetails['mobile']);
				$FontSize=9;
				//$LeftOvers = $pdf->addTextWrap(120,$YPos-60,200,$FontSize, _('ADDRESS'),'left');
	            //$LeftOvers = $pdf->addTextWrap(300,$YPos-60,900,$FontSize,': ' . $myrowpartydetails['address']);
$pdf->selectFont('./fonts/Helvetica-Bold.afm');
                $LeftOvers = $pdf->addTextWrap(120,$YPos-10,300,$FontSize, _('THE SUM OF RUPEES'),'left');
$pdf->selectFont('./fonts/Helvetica.afm');
                $LeftOvers = $pdf->addTextWrap(261,$YPos-10,300,$FontSize,': ' . number_word($myrowpartytransdetails['amountreceived']));
 $pdf->SetFont('Helvetica','BI',16);
                $LeftOvers = $pdf->addTextWrap(120,$YPos-40,400,$FontSize, _('By CHEQUE / DRAFT / CASH IN FULL / PART / ADVANCE PAYMENT FOR :'),'left');

		        $LeftOvers = $pdf->addTextWrap(120,$YPos-70,150,$FontSize, _('BRIEF_FILE'),'left');
$pdf->selectFont('./fonts/Helvetica.afm');
				$LeftOvers = $pdf->addTextWrap(261,$YPos-70,300,$FontSize,': ' . $myrowpartytransdetails['brief_file']);
$pdf->SetFont('Helvetica','BI',16);			 
				$LeftOvers = $pdf->addTextWrap(120,$YPos-100,150,$FontSize, _('CASE NO'),'left');
$pdf->selectFont('./fonts/Helvetica.afm');
				$LeftOvers = $pdf->addTextWrap(261,$YPos-100,200,$FontSize,': ' . $myrowpartyeconomydetails['courtcaseno']);
 $pdf->SetFont('Helvetica','BI',16);
				$LeftOvers = $pdf->addTextWrap(120,$YPos-130,900,$FontSize, _('PURPOSE OF PAYMENT'),'left');
$pdf->selectFont('./fonts/Helvetica.afm');
				$LeftOvers = $pdf->addTextWrap(261,$YPos-130,900,$FontSize,': ' . $myrowpartytransdetails['narration']);
				$LeftOvers = $pdf->addTextWrap(500,$YPos-40,150,$FontSize,_('CHEQUE NO'),'left');
                $LeftOvers = $pdf->addTextWrap(500,$YPos-70,150,$FontSize,_('RECEIVED DATE'),'left');
                $LeftOvers = $pdf->addTextWrap(500,$YPos-100,150,$FontSize,_('BANK NAME'),'left');
                
              
				 $LeftOvers = $pdf->addTextWrap(600,$YPos-40,150,$FontSize,': ' . $myrowpartytransdetails['chequeno']);
                $LeftOvers = $pdf->addTextWrap(600,$YPos-70,200,$FontSize,': ' . ConvertSQLDate($myrowpartytransdetails['receivedt']));
				// $LeftOvers = $pdf->addTextWrap(600,$YPos-100,150,$FontSize,': ' . $myrowpartytransdetails['ourbankcode']);
                $LeftOvers = $pdf->addTextWrap(600,$YPos-100,150,$FontSize,': ' . $myrowpartytransdetails['custbankname']);
			//	 $LeftOvers = $pdf->addTextWrap(600,$YPos-160,200,$FontSize,': ' . $myrowpartytransdetails['amountreceived']);
			//	 $LeftOvers = $pdf->addTextWrap(600,$YPos-200,200,$FontSize,': ' . ConvertSQLDate($myrowpartytransdetails['receivedt']));
				// $LeftOvers = $pdf->addTextWrap(600,$YPos-210,150,$FontSize,$myrowpartytransdetails['ourbankcode']);
				
				// $LeftOvers = $pdf->addTextWrap($Page_Width-$Right_Margin-510,$YPos-150,200,$FontSize,': ' . $myrowpartyeconomydetails['totalfees']); 
				// $LeftOvers = $pdf->addTextWrap($Page_Width-$Right_Margin-510,$YPos-170,200,$FontSize,': ' . $myrowtotalreceived['totalreceived']);
				
				//  $LeftOvers = $pdf->addTextWrap($Page_Width-$Right_Margin-510,$YPos-200,300,$FontSize,': ' . $tilldatebalance);	
				// $pdf->line($Page_Width-$Right_Margin, $YPos+10,$Left_Margin, $YPos+10);
			$YPos -=100;
				
			if ($YPos < ($Bottom_Margin +30)){
				include('includes/PDFBankReceiptPageHeader.php');
				
			}
		//	HORIZONTAL LOWER LINE
		//	$pdf->line($Page_Width-$Right_Margin-70, $YPos+14,$Left_Margin+70, $YPos+14);
			$pdf->line($Page_Width-$Right_Margin-70, $YPos-150,$Left_Margin+70, $YPos-150);
		//SIGN LINE
            $pdf->line($Page_Width-$Right_Margin-90, $YPos-115,$Left_Margin+540, $YPos-115);

            $pdf->Text(600, $YPos+70, $_SESSION['CompanyRecord']['coyname']);
        //middle horizontal line
			$pdf->line($Page_Width-$Right_Margin-70, $YPos-60,$Left_Margin+70, $YPos-60);
			
$LeftOvers = $pdf->addTextWrap(150,$YPos-80,300,$FontSize,'','left');
 $pdf->SetFont('Helvetica','BI',14);
$pdf->Cell(130);

$pdf->Cell(180,30,$myrowpartytransdetails['amountreceived'] . ' /- ',1,0,'R');

$pdf->AddFont('RupeeForadian','','Rupee_Foradian.php');

$pdf->SetFont('RupeeForadian','',35);

$LeftOvers = $pdf->addTextWrap(135,$YPos-105,300,$FontSize+10,'`','left');  
$LeftOvers = $pdf->addTextWrap(120,$YPos-130,300,$FontSize, _('This receipt is valid subject to Realisation of Cheque if Applicable.'),'left');
    
	//Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, boolean fill [, mixed link]]]]]]])
	





	$pdfcode = $pdf->output();
	$len = strlen($pdfcode);

      if ($len<=20){
		$title = _('Print Bank Receipt Error');
		echo '<p>';
		prnMsg( _('There were no Bank Receipt to print out for the selections specified') );
		echo '<br><a href="'. $rootpath.' /index.php?' . SID . '">'. _('Back to the menu'). '</a>';
		
		exit;
	} else {
		header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: inline; filename=Bankreceipt.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');

		$pdf->Output('PDFBankReceipt.pdf','I');

	}
	exit;


?>