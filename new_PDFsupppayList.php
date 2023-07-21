<?php
    $PageSecurity = 5;
     include("includes/session.php");
	
    require('mc_tablenew_supppaylist.php');
	
$pdf=new PDF_MC_Table();
$pdf->AddPage('','Legal');

$pdf->SetFont('Helvetica','B',9);
//Table with 5 columns
$pdf->SetWidths(array(10,40,30,30,30,30,30));


$sql = "SELECT lw_contacts_other.name,
				lw_contacts_other.mobile,
				supptrans.transno,
				supptrans.date,
				supptrans.amount,
				supptrans.narration
			FROM supptrans LEFT JOIN lw_contacts_other
		ON supptrans.supplierid=lw_contacts_other.id ";
			$StatementResults=DB_query($sql,$db);
	
$i=1;

$pdf->SetXY( 10, 10 ); 
	$pdf->SetFont('','B','18'); 
	$pdf->Cell(40,10,'Supplier Payment List',15); 
	$pdf->Ln(); 
	
	$pdf->SetXY( 10, 30 ); 
	$pdf->SetFont('','B','10'); 
	$pdf->SetFillColor(128,128,128); 
	$pdf->SetTextColor(255); 
	$pdf->SetDrawColor(92,92,92); 
	$pdf->SetLineWidth(.3); 
		
	$pdf->Cell(10,7,"ID",1,0,'C',true); 
	$pdf->Cell(40,7,"Supplier Name",1,0,'C',true); 
	$pdf->Cell(30,7,"Mobile",1,0,'C',true); 
	$pdf->Cell(30,7,"Trans no",1,0,'C',true); 
	$pdf->Cell(30,7,"Date",1,0,'C',true); 
	$pdf->Cell(30,7,"Amount",1,0,'C',true); 
	$pdf->Cell(30,7,"Narration",1,0,'C',true); 

	$pdf->Ln(); 
	
	$pdf->SetFillColor(224,235,255); 
	$pdf->SetTextColor(0); 
	$pdf->SetFont(''); 
	
	



	$fill = false;

	while($Contacts=DB_fetch_array($StatementResults))
    {			
	$pdf->Row(array($i++,$Contacts['name'],$Contacts['mobile'],$Contacts['transno'],$Contacts['date'],$Contacts['amount'],$Contacts['narration']));
	}
$pdf->AliasNbpages();

    $pdfcode = $pdf->output();
	$len = strlen($pdfcode);

      if ($len<=20){
		$title = _('Print Supplier payment List Error');
	
		echo '<p>';
		prnMsg( _('There were no Supplier payment list to print out for the selections specified') );
		echo '<br><a href="'. $rootpath.' /index.php?' . SID . '">'. _('Back to the menu'). '</a>';
		
		exit;
	} else {
		header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: inline; filename=SupppayList.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		$pdf->Output('SupppayList.pdf','I');
		

	}
?>
