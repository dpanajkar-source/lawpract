<?php
    $PageSecurity = 2;
     include("includes/session.php");
     
    
   require('mc_tablenew_ErrorList.php');

	$pdf=new PDF_MC_Table();
	$pdf->AddPage('L','A4');
	

	$pdf->SetFont('Helvetica','B',9);
	//Table with 5 columns
$pdf->SetWidths(array(12,40,30,40,11,50,11,50,28));
	
	$pdf->SetXY( 10, 10 ); 
	$pdf->SetFont('','B','18'); 
	$pdf->Cell(40,10,'Error List',15); 
	$pdf->Ln(); 
	
	$pdf->SetXY( 10, 30 ); 
	$pdf->SetFont('','B','10'); 
	$pdf->SetFillColor(128,128,128); 
	$pdf->SetTextColor(255); 
	$pdf->SetDrawColor(92,92,92); 
	$pdf->SetLineWidth(.3); 
	

	
	$pdf->Cell(12,7,"ID",1,0,'C',true); 
	$pdf->Cell(40,7,"Brief File",1,0,'C',true); 
	$pdf->Cell(30,7,"Court",1,0,'C',true); 
	$pdf->Cell(40,7,"Case No",1,0,'C',true); 
	$pdf->Cell(122,7,"Name Of Parties",1,0,'C',true); 
	
	$pdf->Cell(28,7,"Mobile",1,0,'C',true); 

	
	$pdf->Ln(); 
	
	$pdf->SetFillColor(224,235,255); 
	$pdf->SetTextColor(0); 
	$pdf->SetFont(''); 
	
	$pdf->Cell(122,7,"",1,0,'C',False); 
		$pdf->Cell(11,7,"ID",1,0,'C',true);  
	$pdf->Cell(50,7,"Party",1,0,'C',true); 
		$pdf->Cell(11,7,"ID",1,0,'C',true); 
	$pdf->Cell(50,7,"Opposite Party",1,0,'C',true);
	$pdf->Cell(28,7,"",1,0,'C',False); 


	$pdf->Ln(); 
	$fill = false;
	
	$sql = "SELECT c.brief_file,
			p1.id AS partyid,
			p2.id AS oppopartyid,
			p1.name AS party,
			p2.name AS oppoparty,
			p1.mobile,
			c.courtcaseno,
			lw_courts.courtname
		FROM lw_cases AS c INNER JOIN lw_contacts AS p1 ON c.party=p1.id INNER JOIN lw_contacts AS p2 ON c.oppoparty=p2.id INNER JOIN lw_courts ON c.courtid=lw_courts.courtid WHERE c.deleted!=1 ORDER BY c.party ASC,c.oppoparty DESC,c.courtcaseno ASC";
	
	$result=DB_query($sql,$db);

$i=1;

	
	while($Contacts=DB_fetch_array($result))
    {
	
	$pdf->Row(array($i++,$Contacts['brief_file'],$Contacts['courtname'],$Contacts['courtcaseno'],$Contacts['partyid'],$Contacts['party'],$Contacts['oppopartyid'],$Contacts['oppoparty'],$Contacts['mobile']));
	}
	
	
	$pdf->AliasNbPages();
    $pdfcode = $pdf->output();
	$len = strlen($pdfcode);

      if ($len<=20){
		$title = _('Print Old Cases List Error');
	
		echo '<p>';
		prnMsg( _('There were no Old Cases to print out for the selections specified') );
		echo '<br><a href="'. $rootpath.' /index.php?' . SID . '">'. _('Back to the menu'). '</a>';
		
		exit;
	} else {
		header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: inline; filename=OldCasesList.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		$pdf->Output('OldCasesList.pdf','I');
		

	}
?>
