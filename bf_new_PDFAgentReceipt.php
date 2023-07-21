<?php
    $PageSecurity = 2;
     include("includes/session.php");
	
    require('mc_tablenew_bf_agentreceipt.php');

$pdf=new PDF_MC_Table();
$pdf->AddPage('','Legal');

$pdf->SetFont('Helvetica','B',9);

   $DateString = Date($_SESSION['DefaultDateFormat']);
	
	$date = new DateTime(FormatDateForSQL($DateString));

$pdf->SetWidths(array(200));


		$sql = "SELECT 
			lw_searchtitle.id,
			lw_searchtitle.fileno,
			lw_searchtitle.property,
			lw_searchtitle.propertydetails,
			lw_contacts.name,
			lw_searchtitle.agentcharges 
		FROM lw_searchtitle INNER JOIN lw_contacts ON lw_searchtitle.agent=lw_contacts.id WHERE lw_searchtitle.id = '" . $_GET['idnew'] . "'";
		$StatementResults=DB_query($sql,$db);
			$Agentdetails = DB_fetch_array($StatementResults,$db);			

  
$pdf->SetDrawColor(255,255,255);
$pdf->SetFillColor(255,255,255);

$pdf->SetXY( 20,18 );


$pdf->SetXY( 5,25 );	
$pdf->SetWidths(array(10,175,10));
$pdf->SetFont('','B','12'); 
$pdf->Row(array('','To  : ' . $Agentdetails['name'],''));
$pdf->SetXY( 5,33 );
$pdf->Row(array('','Property  ' . ':' . $Agentdetails['property'],''));

$pdf->SetDrawColor(0,0,0);
$pdf->Line(10,30,200,30);
$pdf->SetFont('Helvetica','B',11);
$pdf->SetXY( 15,40 );
$pdf->SetWidths(array(20,110,20,35));

$pdf->Row(array('Property Details',':' . $Agentdetails['propertydetails'],'File No :',$Agentdetails['fileno']));
$pdf->SetXY( 15,50 );
$pdf->SetWidths(array(20,110,20,35));
$pdf->Row(array('','','Date:',$date->format('d-m-Y')));
	
	
	$pdf->SetFillColor(224,235,255); 
	$pdf->SetTextColor(0); 
	$pdf->SetXY(15, 60 ); 
	
	$pdf->SetLineWidth(.3); 
	// // hi mothi line

$pdf->Cell(0,7,"Particulars ",0,0,'L',true);
$pdf->SetXY(180, 60 ); 
$pdf->Cell(10,7,"Rupees ",0,0,'L',true);
	
			$pdf->Ln(); 		
			$pdf->SetXY( 15, 80 );

		$pdf->SetFont('Helvetica','',10);	
			
			
$pdf->SetWidths(array(120,5,5,50));
$pdf->Row(array('Property Search Charges','','',$Agentdetails['agentcharges']));

$pdf->Ln();
$pdf->SetFont('','IU','10'); 
$pdf->SetXY( 15, 120 );
$pdf->SetWidths(array(160,10,60));
$pdf->Row(array('TOTAL ','',$Agentdetails['agentcharges'].'/-'));
$pdf->SetXY( 15, 125 );
$pdf->SetFillColor(224,235,255);

	$pdf->Cell(190,3,"",0,0,'C',true); 
	$pdf->Ln(); 
$pdf->Ln(); 
$pdf->SetXY( 15, 130 );
$pdf->SetWidths(array(180,60));
$pdf->Row(array(number_word($Agentdetails['agentcharges']),'','',''));
$pdf->Ln();

$pdf->SetXY( 15, 140 );
$pdf->SetWidths(array(150,50));
$pdf->Row(array('','Authorized Signatory'));

$pdf->AliasNbpages();

    $pdfcode = $pdf->output();
	$len = strlen($pdfcode);

      if ($len<=20){
		$title = 'Print Receipt List Error';
	
		echo '<p>';
		prnMsg( 'There were no Receipt to print out for the selections specified' );
		echo '<br><a href="'. $rootpath.' /index.php?' . SID . '">'. 'Back to the menu'. '</a>';
		
		exit;
	} else {
		header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: inline; filename=Receipt.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		$pdf->Output('Receipt.pdf','I');
		

	}
?>
