<?php
    $PageSecurity = 1;
     include("includes/session.php");
	
    require('mc_bf_tablenew_pendinginword.php');
	

$pdf=new PDF_MC_Table();
$pdf->AddPage('','Legal');

$pdf->SetFont('Helvetica','B',9);

//Table with 5 columns
$pdf->SetWidths(array(9,17,26,19,19,18,25,25,15,28));

   	$DateString = Date($_SESSION['DefaultDateFormat']);
	
	$date = new DateTime(FormatDateForSQL($DateString));
                //$date->sub(new DateInterval('P1D'));  

		$sql = 'SELECT 
		bf_banks.bank_name,
		applicationno,
		lw_contacts.name,
		bf_bank_branch.branch_area,
		inward_date,
		handledby,
		bf_stages.stage,
		fees,
		remark
		FROM  bf_inward 
		INNER JOIN bf_banks ON bf_inward.bank_id=bf_banks.id 
		INNER JOIN lw_contacts ON bf_inward.custid=lw_contacts.id
		 INNER JOIN bf_bank_branch ON bf_inward.branch_id=bf_bank_branch.id 
		INNER JOIN bf_stages ON bf_inward.stage=bf_stages.id
		WHERE bf_inward.outward_date IS NULL ORDER BY bf_inward.id';

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
	$pdf->Cell(40,10,'File Pending List',15); 
	$pdf->SetFont('','','10'); 
	
	$pdf->Ln(); 
	
	$pdf->SetXY( 10, 30 ); 
	$pdf->SetFont('','B','9'); 
	$pdf->SetFillColor(128,128,128); 
	$pdf->SetTextColor(255); 
	$pdf->SetDrawColor(92,92,92); 
	$pdf->SetLineWidth(.3); 

		
	$pdf->Cell(9,7,"ID",1,0,'C',true); 
	$pdf->Cell(17,7,"App. No",1,0,'C',true); 
	$pdf->Cell(26,7,"Customer",1,0,'C',true); 
	$pdf->Cell(19,7,"Branch",1,0,'C',true); 
	$pdf->Cell(19,7,"Bank",1,0,'C',true); 
	$pdf->Cell(18,7,"Inward",1,0,'C',true); 
	$pdf->Cell(25,7,"Names",1,0,'C',true); 
	$pdf->Cell(25,7,"Stage",1,0,'C',true); 
	$pdf->Cell(15,7,"Fees",1,0,'C',true);
	$pdf->Cell(28,7,"Remark",1,0,'C',true);
	$pdf->Ln(); 
	
$fill = false;
	
	while($Contacts=DB_fetch_array($StatementResults))
    {
	
	if($Contacts['inward_date']!="")
	{
	$Contacts['inward_date']=ConvertSQLDate($Contacts['inward_date']);
	}
	
	else
	{
	$Contacts['inward_date']=$Contacts['inward_date'];
	}
	
if($Contacts['outward_date']!="")
	{
	$Contacts['outward_date']=ConvertSQLDate($Contacts['outward_date']);
	}
	
	else
	
	{
	$Contacts['outward_date']=$Contacts['outward_date'];
	}
	
	$pdf->Row(array($i++,$Contacts['applicationno'],$Contacts['name'],$Contacts['branch_area'],$Contacts['bank_name'],$Contacts['inward_date'],$Contacts['handledby'],$Contacts['stage'],$Contacts['fees'],$Contacts['remark']));
	}
	
$pdf->AliasNbPages();
   $pdf = $pdf->Output();
	$len = strlen($pdf);
	
	

	
		header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: inline; filename=PendingfilesList.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		$pdf->Output('PendingfilesList.pdf','I');

		
	

    ?>
