<?php
    $PageSecurity = 13;
     include("includes/session.php");
	
    require('mc_bf_tablenew_partydues.php');
	
$pdf=new PDF_MC_Table();
$pdf->AddPage('','Legal');

$pdf->SetFont('Helvetica','B',9);
//Table with 5 columns
$pdf->SetWidths(array(15,20,55,25,25,25,25));

 $sql = "SELECT 
 		bf_ind_invoice.billno,
 		lw_contacts.name,
		lw_contacts.mobile,
		bf_ind_invoice.totalfees,
	 	bf_ind_invoice.balance
		FROM bf_ind_invoice INNER JOIN lw_contacts ON bf_ind_invoice.custid=lw_contacts.id  ORDER BY lw_contacts.name ASC";					
		$StatementResults=DB_query($sql,$db);			
$i=0;
			
$sqlcompany = 'SELECT * FROM companies WHERE coycode=1';
	$StatementResultcompany=DB_query($sqlcompany,$db);
$Company = DB_fetch_array($StatementResultcompany);		
			
$i=1;
	$pdf->SetXY( 25, 10 );
	$pdf->SetFont('','B','12'); 
	
	$pdf->Cell(0,10,$Company['advocatename'],0,0,'R',false);
	$pdf->SetFont('','B','9'); 
	$pdf->Cell(0,20,$Company['degree'],0,0,'R',false);
	
	$pdf->SetXY( 25, 15 ); 
	$pdf->SetFont('','','12'); 
	$pdf->Cell(40,10,'Client Dues List',15); 
	$pdf->SetFont('','','10'); 
	
	$pdf->Ln(); 
	
	$pdf->SetXY( 10, 30 ); 
	$pdf->SetFont('','B','9'); 
	$pdf->SetFillColor(128,128,128); 
	$pdf->SetTextColor(255); 
	$pdf->SetDrawColor(92,92,92); 
	$pdf->SetLineWidth(.3); 
	
	$pdf->Cell(15,7,"ID",1,0,'C',true);
	 $pdf->Cell(20,7,"Bill No",1,0,'C',true); 
	$pdf->Cell(55,7,"Customer",1,0,'C',true); 
	$pdf->Cell(25,7,"Mobile",1,0,'C',true); 
	$pdf->Cell(25,7,"Total Fees",1,0,'C',true); 	
	$pdf->Cell(25,7,"Amt Received",1,0,'C',true); 
	$pdf->Cell(25,7,"Balance",1,0,'C',true);
	
	$pdf->Ln(); 	
	
$fill = false;

$sql = "SELECT SUM(bf_ind_receipts.amount) AS amt
		FROM bf_ind_invoice INNER JOIN bf_ind_receipts ON bf_ind_invoice.billno=bf_ind_receipts.billno";					
		$StatementResultsamount=DB_query($sql,$db);
		
		$myrowamount=DB_fetch_array($StatementResultsamount);
		
	while($Contacts=DB_fetch_array($StatementResults))
    {				
	$pdf->Row(array($i++,$Contacts['billno'],$Contacts['name'],$Contacts['mobile'],
$Contacts['totalfees'],$$myrowamount['amt'],$Contacts['balance']));
	}
	
$pdf->AliasNbpages();

    $pdfcode = $pdf->output();
	$len = strlen($pdfcode);

      if ($len<=20){
		$title = 'Print Client Dues List Error';
	
		echo '<p>';
		prnMsg( 'There were no Client Dues  to print out for the selections specified' );
		echo '<br><a href="'. $rootpath.' /index.php?' . SID . '">'. 'Back to the menu'. '</a>';
		
		exit;
	} else {
		header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: inline; filename=ClientDuesList.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		$pdf->Output('ClientDuesList.pdf','I');
		

	}
?>
