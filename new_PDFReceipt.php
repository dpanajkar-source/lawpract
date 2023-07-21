<?php
    $PageSecurity = 2;
     include("includes/session.php");
	
    require('mc_tablenew_receipt.php');

$pdf=new PDF_MC_Table();
$pdf->AddPage('L','A4');

$pdf->SetFont('Helvetica','B',9);
//Table with 5 columns


$pdf->SetWidths(array(200));


		$sql = "SELECT 
			lw_partytrans.brief_file,
			lw_partytrans.party,
			lw_partytrans.transno,
            lw_partytrans.invoiceno,
			lw_partytrans.amountreceived,
			lw_partytrans.receivedt,
			lw_partytrans.chequeno,
			lw_partytrans.custbankname,	
			lw_partytrans.narration
	FROM lw_partytrans WHERE lw_partytrans.transno = '" . $_GET['transno'] . "'";
		
		$StatementResults=DB_query($sql,$db);
	
$i=1;

$pdf->SetXY( 15, 10 ); 
	$pdf->SetFont('','B','20');
	
	$pdf->Ln(); 
	
	$pdf->SetXY( 15, 30 ); 
	$pdf->SetFont('','BU','16'); 
	//$pdf->SetFillColor(128,128,128); 
	$pdf->SetFillColor(224,235,255); 
	$pdf->SetTextColor(0); 
	 
	
	$pdf->SetLineWidth(.3); 
	$pdf->SetWidths(array(60,60,65,65));
	$pdf->Cell(262,13,"Receipt",0,0,'C',true); 
	$pdf->Ln(); 
	$pdf->SetXY( 15, 40 ); 
	//$pdf->Cell(262,2,"",0,0,'C',true); 
	$pdf->Ln(); 
	
	$pdf->SetFillColor(255,255,255); 
	$pdf->SetTextColor(0); 

	$fill = false;
	
	$pdf->SetXY( 15, 45 ); 
 
	$pdf->SetTextColor(0);	

	while($Contacts=DB_fetch_array($StatementResults))
    {			
	$resultparty=DB_query("SELECT name,address,mobile FROM lw_contacts WHERE lw_contacts.id='" . $Contacts['party'] . "'",$db);	
	$myrowpartydetails=DB_fetch_array($resultparty);
	
	$sqlpartyeconomy = "SELECT lw_partyeconomy.courtcaseno FROM lw_partyeconomy WHERE lw_partyeconomy.brief_file ='" . $Contacts['brief_file'] . "'";
	$StatementResultsEconomy=DB_query($sqlpartyeconomy,$db);
	$myrowpartyeconomydetails=DB_fetch_array($StatementResultsEconomy);		
				
			
				$pdf->SetFont('','','10');
			 if($_SESSION['AccountType']==1)
 			{
	
			$pdf->Cell(140,7,"",0,0,'l',true); 
			$pdf->Cell(60,7,"INVOICE NO",0,0,'L',true); 
			
			$pdf->Cell(2,7,":",0,0,'C',true); 
 			$pdf->Row(array($Contacts['invoiceno']));
			
			}else
			{
			
			$pdf->Cell(262,7,"",0,0,'C',true); 	

			
			}
			$pdf->Ln(); 
		//	$pdf->Ln();
			 	$pdf->SetXY( 15, 50 );
			//	$pdf->SetFillColor(224,235,255); 
 
			$pdf->Cell(170,7,"",0,0,'l',true); 
			$pdf->Cell(60,7,"Date",0,0,'L',true);
			$pdf->Cell(2,7,":",0,0,'C',true); 
			$pdf->Row(array($Contacts['receivedt']));
			$pdf->Ln(); 
		
		
		$pdf->SetXY( 15, 55 );
		//$pdf->SetFillColor(224,235,255); 
		$pdf->SetTextColor(0); 
			
			$pdf->Cell(170,7,"",0,0,'l',true); 
			$pdf->Cell(60,7,"Transaction No",0,0,'L',true); 
			$pdf->Cell(2,7,":",0,0,'C',true); 
			$pdf->Row(array($Contacts['transno']));	

			$pdf->Ln(); 
	$pdf->SetWidths(array(200));
			$pdf->SetXY( 15, 65 );
	//$pdf->SetFillColor(224,235,255); 
	$pdf->SetTextColor(0); 
	$pdf->Cell(60,7,"Amount received with thanks from",0,0,'L',true);		
	$pdf->Cell(2,7,":",0,0,'C',true); 
	$pdf->Row(array($myrowpartydetails['name']));	
	$pdf->Ln(); 
//	$pdf->Ln(); 
	
		//$pdf->Cell(120,7,"",1,0,'l',true); 
	$pdf->SetXY( 15, 75 );
//		$pdf->SetFillColor(224,235,255); 
	$pdf->SetTextColor(0); 
			$pdf->Cell(60,7,"Case No",0,0,'L',true); 
			$pdf->Cell(2,7,":",0,0,'C',true); 
			$pdf->Row(array($myrowpartyeconomydetails[0]));
			$pdf->Ln(); 
	//		$pdf->Ln();
	$pdf->SetXY( 15, 85 );
//			$pdf->SetFillColor(224,235,255); 
	$pdf->SetTextColor(0); 
			$pdf->Cell(60,7,"Brief File No",0,0,'L',true); 
			$pdf->Cell(2,7,":",0,0,'C',true); 
			$pdf->Row(array($Contacts['brief_file']));
			$pdf->Ln(); 
		
		$pdf->SetXY( 15, 95 );
		
			$pdf->SetTextColor(0); 
			$pdf->Cell(60,7,"Cheque/NEFT/RTGS No.",0,0,'L',true);
			$pdf->Cell(2,7,":",0,0,'C',true); 
			$pdf->Row(array($Contacts['chequeno']));
			$pdf->Ln(); 
			 
			$pdf->SetXY( 15, 105 );

			$pdf->SetTextColor(0); 
			$pdf->Cell(60,7,"Bank Name",0,0,'L',true);
			$pdf->Cell(2,7,":",0,0,'C',true); 
			$pdf->Row(array($Contacts['custbankname']));
			$pdf->Ln(); 
		
			$pdf->SetXY( 15, 115 );
			
			$pdf->SetTextColor(0); 
			$pdf->Cell(60,7,"Narration",0,0,'L',true); 
			$pdf->Cell(2,7,":",0,0,'C',true); 
			$pdf->Row(array($Contacts['narration']));
			$pdf->Ln(); 
			
			$pdf->SetXY( 15, 120 );
//	$pdf->SetFillColor(224,235,255); 
				$pdf->SetTextColor(0); 
			$pdf->Cell(262,7,"",0,0,'C',true); 	
			$pdf->Ln();
			$pdf->SetXY( 15, 130 );
			
			$pdf->SetFont('','B','12'); 
			$pdf->SetWidths(array(200));
			$pdf->Ln(); 


$pdf->SetXY( 15, 135 );
$pdf->Cell(60,7,"Rs.  ",0,0,'L',true);
$pdf->Cell(2,7,":",0,0,'C',true); 
$pdf->Row(array($Contacts['amountreceived']));
$pdf->Ln(); 
$pdf->SetXY( 15, 140 );

$pdf->Ln(); 
$pdf->SetXY( 15, 145 );
$pdf->Cell(212,7,"This receipt is valid subject to Realisation of Cheque if Applicable.",0,0,'L',true);
$pdf->Ln();
$pdf->SetXY( 213, 145 );

$pdf->Cell(40,7,"---------------------------------",0,0,'C',true); 

$pdf->Ln();
$pdf->SetXY( 213, 150 );

$pdf->Cell(40,7,"Authorised Signatory",0,0,'C',true);
$pdf->Cell(10,7,"",0,0,'C',true);
										
$pdf->SetXY( 15, 165 );
$pdf->SetFillColor(224,235,255);
//$pdf->SetFillColor(128,128,128); 
	$pdf->Cell(262,3,"",0,0,'C',true); 
	$pdf->Ln(); 
	
	// first embed mask image (w, h, x and y will be ignored, the image will be scaled to the target image's size)-------------
//$maskImg = $pdf->Image('logo_mainmask.png', 0,0,0,0, '', '', true); 
// embed image, masked with previously embedded mask
//$pdf->Image('logo_main.png',230,10,50,0,'','', false, $maskImg);

// B) use alpha channel from PNG (alpha channel converted to 7-bit by GD, lower quality)
//$pdf->ImagePngWithAlpha('image_with_alpha.png',55,100,100);

// C) same as B), but using Image() method that recognizes the alpha channel
//$pdf->Image('image_with_alpha.png',55,190,100);

//------------------------------------------------------------------
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
		header('Content-Disposition: inline; filename=Receipt.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		$pdf->Output('Receipt.pdf','I');
		

	}
?>
