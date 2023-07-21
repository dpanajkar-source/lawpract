<?php
    $PageSecurity = 5;
     include("includes/session.php");
	
    require('mc_tablenew_partydues.php');
	
$pdf=new PDF_MC_Table();
$pdf->AddPage('','Legal');

$pdf->SetFont('Helvetica','B',9);
//Table with 5 columns
$pdf->SetWidths(array(10,25,25,20,25,25,22,23,23));

 $sql = "SELECT c.brief_file,
			p1.name AS party,
			p2.name AS oppoparty,
			p1.mobile,
			c.courtcaseno,
			lw_courts.courtname,
			 lw_partyeconomy.totalfees,
			 lw_partyeconomy.balance
		FROM lw_cases AS c INNER JOIN lw_contacts AS p1 ON c.party=p1.id LEFT JOIN lw_contacts AS p2 ON c.oppoparty=p2.id LEFT JOIN lw_courts ON c.courtid=lw_courts.courtid LEFT JOIN  lw_partyeconomy ON c.brief_file= lw_partyeconomy.brief_file WHERE c.party = '" . trim($_GET['partydueid']) . "' OR c.oppoparty = '" . trim($_GET['partydueid']) . "'  AND c.deleted!=1 ORDER BY lw_partyeconomy.balance DESC";
					
		$StatementResults=DB_query($sql,$db);
	
$i=1;

$pdf->SetXY( 10, 10 ); 
	$pdf->SetFont('','B','18'); 
	$pdf->Cell(40,10,'Party Dues',15); 
	$pdf->Ln(); 
	
	$pdf->SetXY( 10, 30 ); 
	$pdf->SetFont('','B','10'); 
	$pdf->SetFillColor(128,128,128); 
	$pdf->SetTextColor(255); 
	$pdf->SetDrawColor(92,92,92); 
	$pdf->SetLineWidth(.3); 
	
	$pdf->Cell(10,7,"ID",1,0,'C',true); 
	$pdf->Cell(25,7,"Brief File",1,0,'C',true); 
	$pdf->Cell(25,7,"Case No",1,0,'C',true); 
	$pdf->Cell(20,7,"Court",1,0,'C',true); 
	$pdf->Cell(50,7,"Name Of Parties",1,0,'C',true); 
	$pdf->Cell(22,7,"Mobile",1,0,'C',true); 
	$pdf->Cell(23,7,"Total Fees",1,0,'C',true); 
	$pdf->Cell(23,7,"Balance",1,0,'C',true);
	
	$pdf->Ln(); 
	
	$pdf->SetFillColor(224,235,255); 
	$pdf->SetTextColor(0); 
	$pdf->SetFont(''); 
	
	$pdf->Cell(80,7,"",1,0,'C',False); 
 
	$pdf->Cell(25,7,"Party",1,0,'C',true); 
	$pdf->Cell(25,7,"Opposite Party",1,0,'C',true);
	$pdf->Cell(68,7,"",1,0,'C',False); 


	$pdf->Ln(); 
	$fill = false;
	

 
	while($Contacts=DB_fetch_array($StatementResults))
    {			
			
	$pdf->Row(array($i++,$Contacts['brief_file'],$Contacts['courtcaseno'],$Contacts['courtname'],$Contacts['party'],$Contacts['oppoparty'],$Contacts['mobile'],$Contacts['totalfees'],$Contacts['balance']));
	}
$pdf->AliasNbpages();

    $pdfcode = $pdf->output();
	$len = strlen($pdfcode);

      if ($len<=20){
		$title = _('Print Party Dues List Error');
	
		echo '<p>';
		prnMsg( _('There were no Party Dues to print out for the selections specified') );
		echo '<br><a href="'. $rootpath.' /index.php?' . SID . '">'. _('Back to the menu'). '</a>';
		
		exit;
	} else {
		header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: inline; filename=PartyDuesList.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		$pdf->Output('PartyDuesList.pdf','I');
		

	}
?>
