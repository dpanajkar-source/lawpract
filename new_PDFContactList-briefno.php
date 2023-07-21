<?php
    $PageSecurity = 2;
     include("includes/session.php");
     
    
   require('mc_tablenew_ContactList-brief.php');

	$pdf=new PDF_MC_Table();
	$pdf->AddPage();
	$pdf->SetFont('Helvetica','B',9);
	//Table with 5 columns
	$pdf->SetWidths(array(10,30,27,40,37,22,25));
	
	$pdf->SetXY( 10, 10 ); 
	$pdf->SetFont('','B','18'); 
	$pdf->Cell(40,10,'Contact List',15); 
	$pdf->Ln(); 
	
	$pdf->SetXY( 10, 30 ); 
	$pdf->SetFont('','B','10'); 
	$pdf->SetFillColor(128,128,128); 
	$pdf->SetTextColor(255); 
	$pdf->SetDrawColor(92,92,92); 
	$pdf->SetLineWidth(.3); 
	
	$pdf->Cell(10,7,"ID",1,0,'C',true); 
	$pdf->Cell(30,7,"Brief/ File",1,0,'C',true); 
	$pdf->Cell(27,7,"Case No",1,0,'C',true);
	$pdf->Cell(40,7,"Name",1,0,'C',true); 
	$pdf->Cell(37,7,"Address",1,0,'C',true); 
	$pdf->Cell(22,7,"Mobile",1,0,'C',true); 
	$pdf->Cell(25,7,"Email",1,0,'C',true);	
	$pdf->Ln(); 
	$pdf->SetFillColor(224,235,255); 
	$pdf->SetTextColor(0); 
	$pdf->SetFont(''); 
	$fill = false;
	
		
	$result=DB_query("SELECT lw_contacts.name,
						lw_contacts.address,
						lw_contacts.landline,
						lw_contacts.mobile,
						lw_contacts.email,
						lw_cases.brief_file,
						lw_cases.courtcaseno
	FROM lw_contacts INNER JOIN lw_cases ON lw_contacts.id=lw_cases.party ORDER BY name ASC",$db);

$i=1;
$arr=array();
	
	while($myrow=DB_fetch_array($result))
    {
	
	$pdf->Row(array($i++,$myrow['brief_file'],$myrow['courtcaseno'],$myrow['name'],$myrow['address'],$myrow['mobile'],$myrow['email']));	
	
	
	}

	$pdf->AliasNbPages();
    $pdfcode = $pdf->output();
	$len = strlen($pdfcode);

      if ($len<=20){
		$title = _('Print Contacts-brief List Error');
	
		echo '<p>';
		prnMsg( _('There were no contacts to print out for the selections specified') );
		echo '<br><a href="'. $rootpath.' /index.php?' . SID . '">'. _('Back to the menu'). '</a>';
		
		exit;
	} else {
		header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: inline; filename=ContactsList-brief.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		$pdf->Output('ContactsList-brief.pdf','I');
		

	}
?>
