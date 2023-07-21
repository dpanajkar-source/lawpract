<?php
/* $Revision: 1.12 $ */

$PageSecurity = 2;
include('includes/session.php');

include('includes/PDFStarter.php');

	$PageNumber = 0;

	$FontSize=10;
	$pdf->addinfo('Title', _('GL Codes Listing') );
	$pdf->addinfo('Subject', _('GL Codes Listing') );

	$line_height=12;

	/* Now figure out the Contact data to report for the selections made */
$SQL = 'SELECT group_,
		accountcode,
		accountname
	FROM chartmaster INNER JOIN accountgroups ON chartmaster.group_ = accountgroups.groupname
	ORDER BY sequenceintb,
		accountcode';

$ErrMsg = _('No general ledger accounts were returned by the SQL because');
$AccountsResult = DB_query($SQL,$db,$ErrMsg);

	
	if (DB_error_no($db) !=0) {
	  $title = _('GL Codes Listing') . ' - ' . _('Problem Report') . '....';
	  
	   prnMsg( _('The GL Codes List could not be retrieved by the SQL because') . ' - ' . DB_error_msg($db) );
	   echo '<br><a href="' .$rootpath .'/index.php?' . SID . '">'. _('Back to the menu'). '</a>';
	   if ($debug==1){
	      echo '<br>'. $sql;
	   }
	   
	   exit;
	}

	include('includes/PDFGLCodesListPageHeader.php');
$id=1;
	While ($Contacts = DB_fetch_array($AccountsResult,$db)){		
			
				$FontSize=10;
				$YPos -=$line_height;
				if ($YPos < ($Bottom_Margin + 60)){
					include('includes/PDFGLCodesListPageHeader.php');
				}
				$pdf->selectFont('./fonts/Helvetica.afm');
        
				$LeftOvers = $pdf->addTextWrap(50,$YPos,260-$Left_Margin,$FontSize,$id++);	
			

			$LeftOvers = $pdf->addTextWrap(100,$YPos,350,$FontSize,$Contacts['accountcode']);
			$LeftOvers = $pdf->addTextWrap(300,$YPos,900,$FontSize,$Contacts['accountname']);
			$LeftOvers = $pdf->addTextWrap(650,$YPos,150,$FontSize,$Contacts['group_']);
			
			$pdf->line($Page_Width-$Right_Margin, $YPos-2,$Left_Margin, $YPos-2);

			$YPos -=5;
			if ($YPos < ($Bottom_Margin + 30)){
				include('includes/PDFGLCodesListPageHeader.php');
			}
		
	} /*end while loop */

$pdf->AliasNbPages();
	$pdfcode = $pdf->output();
	$len = strlen($pdfcode);

      if ($len<=20){
		$title = _('Print GL Codes Enquiry List Error');
		
		echo '<p>';
		prnMsg( _('There were no GL Codes Enquiry to print out for the selections specified') );
		echo '<br><a href="'. $rootpath.' /index.php?' . SID . '">'. _('Back to the menu'). '</a>';
		
		exit;
	} else {
		header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: inline; filename=GLCodesenquiryList.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');

		$pdf->Output('GLCodesenquiryList.pdf','I');
	}
	exit;

?>
