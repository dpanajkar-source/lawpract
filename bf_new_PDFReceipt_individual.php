<?php
    $PageSecurity = 2;
     include("includes/session.php");
	
    require('mc_bf_tablenew_receipt_individual.php');

$pdf=new PDF_MC_Table();
$pdf->AddPage('','Legal');

$pdf->SetFont('Helvetica','B',9);
//Table with 5 columns


$pdf->SetWidths(array(200));


		$sql = "SELECT 
			bf_ind_receipts.billno,
			lw_contacts.name,
			bf_ind_receipts.billdate,
			bf_ind_receipts.amount,
			bf_ind_receipts.particulars
	FROM bf_ind_receipts INNER JOIN lw_contacts ON bf_ind_receipts.custid=lw_contacts.id WHERE bf_ind_receipts.id = '" . $_GET['id'] . "'";
		
		$StatementResults=DB_query($sql,$db);
				
$sqlcompany = 'SELECT * FROM companies WHERE coycode=1';
	$StatementResultcompany=DB_query($sqlcompany,$db);
$Company = DB_fetch_array($StatementResultcompany,$db);		
			
$i=1;
  
$pdf->SetDrawColor(255,255,255);

$pdf->SetFont('Helvetica','',12);


$pdf->SetWidths(array(195));
$pdf->SetXY( 15,25 );	
//$pdf->SetWidths(array(175,10));

//	$pdf->Row(array('Address : ' . $Company['address'],''));
$pdf->SetXY( 10,33 );
//$pdf->Row(array('','',$pdf->Cell(0,7,'REG. No.' . $Company['barnumber'],0,1,'C',false)),'');
$pdf->SetDrawColor(0,0,0);
//$pdf->Line(10,30,200,30);

	while($Contacts=DB_fetch_array($StatementResults))
    {			
			
				$pdf->SetFont('','','10');
			
			
			//$pdf->Cell(262,7,"",0,0,'C',true); 	

			$pdf->Ln(); 
		//	$pdf->Ln();
			 //	$pdf->SetXY( 15, 50 );
			//	$pdf->SetFillColor(224,235,255); 
  


$pdf->SetDrawColor(248,248,255);
$pdf->SetWidths(array(10,120,30,30));
$pdf->SetFont('Helvetica','',11);
$pdf->SetXY( 15,30 );
$pdf->Row(array('To:',$Contacts['name'],'Bill No.',$Contacts['billno']));
$pdf->SetXY( 15,40 );
$pdf->Row(array('','','Date:',ConvertSQLDate($Contacts['billdate'])));

 
	$pdf->SetFont('','','9'); 
	
	$pdf->SetFillColor(224,235,255); 
	$pdf->SetTextColor(0); 
	$pdf->SetXY(15, 50 ); 
	
	$pdf->SetLineWidth(.3); 
	// // hi mothi line
$pdf->Cell(0,7,"PARTICULARS",0,0,'L',true);
$pdf->SetXY(188, 50 ); 
$pdf->Cell(10,7,"RUPEES",0,0,'L',true);
	
			$pdf->Ln(); 		
			$pdf->SetXY( 15, 70 );			
			
$pdf->SetWidths(array(125,5,8,50));
$pdf->Row(array($Contacts['particulars'],'','',$Contacts['amount']));
$pdf->Ln(); 

$pdf->SetFillColor(224,235,255);
$pdf->SetX(15);
	$pdf->Cell(190,2,"",0,0,'C',true);
	$pdf->Ln();
	$pdf->SetX(15);
$pdf->SetWidths(array(120,5,5,50));
$pdf->Row(array(number_word($Contacts['amount']),'','',''));
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('','IU','10'); 

$pdf->SetWidths(array(158,43));
$pdf->Row(array('','Authorized Signatory'));	


	$pdf->Ln(); 
	
	


	}
$pdf->AliasNbpages();

    $pdfcode = $pdf->output();
	$len = strlen($pdfcode);

      if ($len<=20){
		$title = _('Print Receipt List Error');
	
		echo '<p>';
		prnMsg( _('There were no Receipt to print out for the selections specified') );
		echo '<br><a href="'. $rootpath.' /index.php?' . SID . '">'. _('Back to the menu'). '</a>';
		
		exit;
	} else {
		header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: inline; filename=bf_Receipt.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		$pdf->Output('bf_Receipt.pdf','I');
		

	}
?>
