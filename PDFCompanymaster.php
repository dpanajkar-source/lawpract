<?php
/* $Revision: 1.12 $ */

$PageSecurity = 2;
include('includes/session.php');
include('includes/SQL_CommonFunctions.inc');

include('includes/PDFStarter.php');

	$PageNumber = 0;
	$FontSize=11;
	$pdf->addinfo('Title', _('Company Master') );
	$pdf->addinfo('Subject', _('Company Master') );

	$line_height=12;

	/* Now figure out the Contact data to report for the selections made */
$sql = 'SELECT * FROM companies WHERE coycode=1';
	$StatementResults=DB_query($sql,$db, $ErrMsg);

	
	if (DB_error_no($db) !=0) {
	  $title = _('Company Master') . ' - ' . _('Problem Report') . '....';
	  	   prnMsg( _('The Company Master could not be retrieved by the SQL because') . ' - ' . DB_error_msg($db) );
	   echo '<br><a href="' .$rootpath .'/index.php?' . SID . '">'. _('Back to the menu'). '</a>';
	   if ($debug==1){
	      echo '<br>'. $sql;
	   }
	   
	   exit;
	}

	include('includes/PDFCompanyMasterPageHeader.php');

	$Contacts = DB_fetch_array($StatementResults,$db);		
			
				$FontSize=10;
				$YPos -=$line_height;
				if ($YPos < ($Bottom_Margin + 80)){
					include('includes/PDFCompanyMasterPageHeader.php');
				}
				$pdf->selectFont('./fonts/Helvetica-Bold.afm');
				$LeftOvers = $pdf->addTextWrap(150,$YPos+35,260-$Left_Margin,$FontSize,$Contacts['coycode']);
				$pdf->selectFont('./fonts/Helvetica.afm');
				$FontSize=10;
				$YPos -=$line_height;
	
			$LeftOvers = $pdf->addTextWrap(150,$YPos+30,200,$FontSize,$Contacts['advocatename']);
			$LeftOvers = $pdf->addTextWrap(150,$YPos+10,200,$FontSize,$Contacts['companynumber']);
			$LeftOvers = $pdf->addTextWrap(150,$YPos-10,200,$FontSize,$Contacts['barnumber']);
			$LeftOvers = $pdf->addTextWrap(150,$YPos-30,700,$FontSize,$Contacts['regoffice1']);
			$LeftOvers = $pdf->addTextWrap(150,$YPos-50,700,$FontSize,$Contacts['regoffice2']);
			$LeftOvers = $pdf->addTextWrap(150,$YPos-70,700,$FontSize,$Contacts['regoffice3']);
			$LeftOvers = $pdf->addTextWrap(150,$YPos-90,700,$FontSize,$Contacts['regoffice4']);
			$LeftOvers = $pdf->addTextWrap(150,$YPos-110,700,$FontSize,$Contacts['regoffice5']);
			$LeftOvers = $pdf->addTextWrap(150,$YPos-135,700,$FontSize,$Contacts['regoffice6']);
			$LeftOvers = $pdf->addTextWrap(150,$YPos-154,100,$FontSize,$Contacts['telephone']);
			$LeftOvers = $pdf->addTextWrap(500,$YPos+48,100,$FontSize,$Contacts['mobile']);
			$LeftOvers = $pdf->addTextWrap(500,$YPos+10,100,$FontSize,$Contacts['email']);
			$LeftOvers = $pdf->addTextWrap(500,$YPos-10,100,$FontSize,$Contacts['website']);
			$LeftOvers = $pdf->addTextWrap(500,$YPos-30,100,$FontSize,$Contacts['idcard']);
			$LeftOvers = $pdf->addTextWrap(500,$YPos-50,100,$FontSize,$Contacts['passport']);
			$LeftOvers = $pdf->addTextWrap(500,$YPos-70,100,$FontSize,$Contacts['drivinglicense']);
			$LeftOvers = $pdf->addTextWrap(500,$YPos-90,100,$FontSize,$Contacts['bloodgroup']);
			$LeftOvers = $pdf->addTextWrap(500,$YPos-110,100,$FontSize,ConvertSQLDate($Contacts['dob']));				

			//$pdf->line($Page_Width-$Right_Margin, $YPos-32,$Left_Margin, $YPos-32);

			$YPos -=40;
			if ($YPos < ($Bottom_Margin +30)){
				include('includes/PDFCompanyMasterPageHeader.php');
			}
		
	$pdfcode = $pdf->output();
	$len = strlen($pdfcode);	

      if ($len<=20){
		$title = _('Print Company Master Error');
		echo '<p>';
		prnMsg( _('There were no Company Master Record to print out for the selections specified') );
		echo '<br><br><a href="'. $rootpath.' /index.php?' . SID . '">'. _('Back to the menu'). '</a>';
		
		exit;
	} else {
		header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: inline; filename="Companymaster.pdf"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');

		$pdf->Output('Companymaster.pdf','I');

	}
	exit;



	
?>
