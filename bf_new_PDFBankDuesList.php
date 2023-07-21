<?php
    $PageSecurity = 13;
     include("includes/session.php");
	
    require('mc_bf_tablenew_bankdues.php');
	
$pdf=new PDF_MC_Table();
$pdf->AddPage('','Legal');

$pdf->SetFont('Helvetica','B',9);
//Table with 5 columns
$pdf->SetWidths(array(15,25,55,25,25,25,25));

 $sql = "SELECT 
 		bf_bills.billno,
 		bf_banks.bank_name,
		bf_banks.landline,
		bf_bills.billtotal,
	 	SUM(bf_bank_receipts.amount) AS amt
		FROM bf_bills
		 LEFT JOIN bf_bank_receipts ON bf_bills.billno=bf_bank_receipts.billno 
		 INNER JOIN bf_banks ON bf_bills.bank_id=bf_banks.id 
		 ORDER BY bf_banks.bank_name ASC";
					
		$StatementResults=DB_query($sql,$db);
	
$i=1;
			
$sqlcompany = 'SELECT * FROM companies WHERE coycode=1';
	$StatementResultcompany=DB_query($sqlcompany,$db);
$Company = DB_fetch_array($StatementResultcompany,$db);		
			
$i=1;
	$pdf->SetXY( 25, 10 );
	$pdf->SetFont('','B','12'); 
	
	$pdf->Cell(0,10,$Company['advocatename'],0,0,'R',false);
	$pdf->SetFont('','B','9'); 
	$pdf->Cell(0,20,$Company['degree'],0,0,'R',false);
	
	$pdf->SetXY( 25, 15 ); 
	$pdf->SetFont('','','12'); 
	$pdf->Cell(40,10,'Bank Dues List',15); 
	$pdf->SetFont('','','10'); 
	
	$pdf->Ln(); 
	
	$pdf->SetXY( 10, 30 ); 
	$pdf->SetFont('','B','9'); 
	$pdf->SetFillColor(128,128,128); 
	$pdf->SetTextColor(255); 
	$pdf->SetDrawColor(92,92,92); 
	$pdf->SetLineWidth(.3); 

	$pdf->Cell(15,7,"ID",1,0,'C',true);
	 $pdf->Cell(25,7,"Bill No",1,0,'C',true); 
	$pdf->Cell(55,7,"Bank Name",1,0,'C',true); 
	$pdf->Cell(25,7,"Phone no",1,0,'C',true); 
	$pdf->Cell(25,7,"Bill Total",1,0,'C',true); 	
	$pdf->Cell(25,7,"Amt Received",1,0,'C',true); 
	$pdf->Cell(25,7,"Balance",1,0,'C',true);
	
	$pdf->Ln(); 
	
	
	
	
$fill = false;
	while($Contacts=DB_fetch_array($StatementResults))
    {	
	$balance=$Contacts['billtotal']-$Contacts['amt'];
			
	$pdf->Row(array($i++,$Contacts['billno'],$Contacts['bank_name'],$Contacts['landline'],
$Contacts['billtotal'],$Contacts['amt'],$balance));
	}
$pdf->AliasNbpages();

    $pdfcode = $pdf->output();
	$len = strlen($pdfcode);

      if ($len<=20){
		$title = 'Print Bank Dues List Error';
	
		echo '<p>';
		prnMsg( 'There were no Bank Dues  to print out for the selections specified' );
		echo '<br><a href="'. $rootpath.' /index.php?' . SID . '">'. 'Back to the menu'. '</a>';
		
		exit;
	} else {
		header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: inline; filename=BankDuesList.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		$pdf->Output('BankDuesList.pdf','I');
		

	}
?>
