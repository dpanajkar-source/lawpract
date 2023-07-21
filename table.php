<?php
    $PageSecurity = 2;
     include("includes/session.php");
     
    require('mc_tablenew.php');
  

$pdf=new PDF_MC_Table();
$pdf->AddPage();
$pdf->SetFont('Helvetica','B',9);
//Table with 5 columns
$pdf->SetWidths(array(10,50,60,30,40));

            
$result=DB_query("SELECT name,address,landline,mobile FROM lw_contacts ORDER BY name ASC",$db);

$i=1;

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
	$pdf->Cell(50,7,"Party",1,0,'C',true); 
	$pdf->Cell(60,7,"Address",1,0,'C',true); 
	$pdf->Cell(30,7,"Landline",1,0,'C',true); 
	$pdf->Cell(40,7,"Mobile",1,0,'C',true); 	
	$pdf->Ln(); 
	$pdf->SetFillColor(224,235,255); 
	$pdf->SetTextColor(0); 
	$pdf->SetFont(''); 
	$fill = false;
	
	while($myrow=DB_fetch_array($result))
    {
	$pdf->Row(array($i++,$myrow['name'],$myrow['address'],$myrow['landline'],$myrow['mobile']));
	}

    $pdfcode = $pdf->output();
	$len = strlen($pdfcode);

      if ($len<=20){
		$title = _('Print Contacts List Error');
	
		echo '<p>';
		prnMsg( _('There were no contacts to print out for the selections specified') );
		echo '<br><a href="'. $rootpath.' /index.php?' . SID . '">'. _('Back to the menu'). '</a>';
		
		exit;
	} else {
		header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: inline; filename=ContactsList.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		$pdf->Output('ContactsList.pdf','I');
		

	}
?>
