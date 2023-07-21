<?php
    $PageSecurity = 2;
     include("includes/session.php");
	
    require('mc_tablenew_invoice.php');

$pdf=new PDF_MC_Table();
$pdf->AddPage('P','A4');

$pdf->SetFont('Helvetica','B',9);
//Table with 5 columns

$pdf->SetWidths(array(100));


		$sql = "SELECT 
			lw_partyeconomy.brief_file,
			lw_partyeconomy.party,
			lw_partyeconomy.type,
            lw_partyeconomy.invoiceno,
			lw_partyeconomy.totalfees,
			lw_partyeconomy.t_date,
			lw_partyeconomy.courtcaseno
	FROM lw_partyeconomy WHERE lw_partyeconomy.invoiceno = '" . $_GET['Invoiceno'] . "'";
		
		$StatementResults=DB_query($sql,$db);
	
$i=1;

	$sqlmycomp = "SELECT coyname, address FROM companies";
	$Statementcompy=DB_query($sqlmycomp,$db);
	$mycompany=DB_fetch_array($Statementcompy);
	
	
	while($Contacts=DB_fetch_array($StatementResults))
    {			
	$resultparty=DB_query("SELECT name,address,mobile FROM lw_contacts WHERE lw_contacts.id='" . $Contacts['party'] . "'",$db);	
	$myrowpartydetails=DB_fetch_array($resultparty);
	
	
	
	$sqlpartyeconomy = "SELECT lw_partyeconomy.courtcaseno FROM lw_partyeconomy WHERE lw_partyeconomy.brief_file ='" . $Contacts['brief_file'] . "'";
	$StatementResultsEconomy=DB_query($sqlpartyeconomy,$db);
	$myrowpartyeconomydetails=DB_fetch_array($StatementResultsEconomy);		
	
	
	$resultbreakup=DB_query("SELECT servicename,fees FROM lw_inv_breakup WHERE lw_inv_breakup.invoiceno = '" . $_GET['Invoiceno'] ."'",$db);	
	$resultbkp=array();
	

$fill = false;

	
	$pdf->SetTextColor(0); 
	 
$pdf->SetXY( 125, 30 ); 
 	 $pdf->SetLineWidth(.3); 
			 	$pdf->SetXY( 15, 15 );	
			 $pdf->SetFillColor(128,128,128); 
			 $pdf->SetTextColor(255);
			 	$pdf->Cell(50,7,"Company Name",0,0,'L',true);
				
	$pdf->SetXY( 13, 25 );
	$pdf->SetFillColor(255,255,255); 
	$pdf->SetTextColor(255); 
	$pdf->Cell(1,7,"",0,0,'C',true);  
	$pdf->Row(array($mycompany['coyname']));
	$pdf->Ln();
	
	$pdf->SetXY( 13, 30 );
	$pdf->Cell(1,7,"",0,0,'C',true);  
	$pdf->Row(array($mycompany['address']));
	
	$pdf->SetXY( 125, 40 );
	$pdf->SetFont('','BU','16'); 

	$pdf->SetTextColor(0); 
	 
	$pdf->SetFillColor(224,235,255); 
	$pdf->Cell(70,13,"INVOICE",0,0,'C',true); 
			
	

	$pdf->SetFont('','B','10'); 
	$pdf->SetWidths(array(50,50,55,55));		

		$pdf->SetXY( 15, 55 );	

	$pdf->SetFillColor(128,128,128); 
	$pdf->SetTextColor(255); 
	$pdf->Cell(40,7,"Bill To : ",0,0,'L',true);	
	$pdf->SetFillColor(255,255,255);
	$pdf->Ln();
	
	$pdf->SetFont('','','8');
	$pdf->SetXY( 13, 65 );
	$pdf->Cell(1,7,"",0,0,'C',true);  
	$pdf->Row(array($myrowpartydetails['name']));
	$pdf->Ln();
	
	$pdf->SetXY( 13, 70 );
	$pdf->Cell(1,7,"",0,0,'C',true);  
	$pdf->Row(array($myrowpartydetails['address']));	
	 
	
	$pdf->SetXY( 125, 55 );
 	$pdf->SetTextColor(0); 
	$pdf->Cell(50,7,"INVOICE NO",0,0,'L',true); 
	$pdf->Cell(1,7,":",0,0,'C',true); 
	$pdf->Cell(10,7,'',0,0,'L',true); 
	$pdf->Row(array($Contacts['invoiceno']));
	$pdf->SetXY( 125, 60 );		
	//$pdf->Cell(150,7,"",0,0,'l',true); 
			$pdf->Cell(50,7,"Date",0,0,'L',true);
			$pdf->Cell(1,7,":",0,0,'C',true); 
		
			$pdf->Cell(1,7,'',0,0,'L',true); 
			$pdf->Row(array(ConvertSQLDate($Contacts['t_date'])));
			$pdf->Ln(); 
			
	
	$pdf->SetXY( 15, 95 );
//	$pdf->SetFillColor(224,235,255); 
	//$pdf->SetTextColor(0); 
	$pdf->Cell(30,7,"Case No",0,0,'L',true); 
	$pdf->Cell(2,7,":",0,0,'C',true); 
	$pdf->Row(array($myrowpartyeconomydetails[0]));
	
	$pdf->SetXY( 15, 100 );
//	$pdf->SetFillColor(224,235,255); 
	$pdf->SetTextColor(0); 
	$pdf->Cell(30,7,"Brief File No",0,0,'L',true); 
	$pdf->Cell(2,7,":",0,0,'C',true); 
	$pdf->Row(array($Contacts['brief_file']));
	$pdf->Ln(); 
	$pdf->SetXY( 15, 110 );
	$pdf->SetFillColor(224,235,255);
	$pdf->Cell(100,7,"DESCRIPTION",0,0,'L',true); 
	$pdf->Cell(56,7,"FEES",0,0,'R',true); 
	$pdf->SetXY( 10, 115 );
//	$pdf->SetFillColor(224,235,255); 
				
$y=115;	
while($myrowinvoicedetails=DB_fetch_array($resultbreakup))
{
//$resultbkp=$myrowinvoicedetails[][];
$pdf->SetFillColor(255,255,255);
$x=15;
$y=$y+7;
$pdf->SetXY( $x, $y );
	$pdf->Cell(1,7,"",0,0,'L',true);
	//$pdf->Row(array($myrowinvoicedetails['servicename']));
	
		
	//$pdf->SetXY($x+170, $y);
		
	//$pdf->Cell(10,7,$pdf->Row(array($myrowinvoicedetails['fees'])),0,0,'R',true);
	//$pdf->Row(array($myrowinvoicedetails['fees']));
	
	
	$pdf->Row(array($i++,$myrowinvoicedetails['servicename'],$myrowinvoicedetails['fees']));

}			

$pdf->SetFillColor(224,235,255);
$pdf->SetXY( 15, 255 );
$pdf->Cell(60,7,"Total Amount : ",0,0,'L',true);
$pdf->SetXY( 135, 255 );
$pdf->Cell(10,7,$pdf->Row(array($Contacts['totalfees'])),0,0,'R',true);
//$pdf->Row(array($Contacts['totalfees']));
$pdf->Ln(); 


//$pdf->Ln(); 
//$pdf->SetXY( 15, 145 );
//$pdf->Cell(212,7,"This receipt is valid subject to Realisation of Cheque if Applicable.",0,0,'L',true);

$pdf->SetXY( 15, 265 );

$pdf->Cell(170,7,"This is computerized Invoice does not requird signature",0,0,'C',true);
$pdf->Cell(10,7,"",0,0,'C',true);
										

	
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
