<?php
    $PageSecurity = 2;
    include("includes/session.php");
	
    require('mc_tablenew_SMShistory.php');
	
	$pdf=new PDF_MC_Table();
	$pdf->AddPage('','Legal');

	$pdf->SetFont('Helvetica','B',9);
	//Table with 5 columns
	$pdf->SetWidths(array(7,21,30,100,30));

   	$currmonth=date("m");
    $curryear=date("Y");
      	
	/* Now figure out the Transactions data to report for the selections made */
$sql = "SELECT * FROM lw_smshistory INNER JOIN lw_contacts ON lw_smshistory.party=lw_contacts.id WHERE lw_smshistory.smsdate LIKE '%" . $curryear .'-' .$currmonth . '-' . "%'  ORDER BY lw_smshistory.smsdate ASC";
	$StatementResults=DB_query($sql,$db);	
					
	$sqlcompany = 'SELECT * FROM companies WHERE coycode=1';
	$StatementResultcompany=DB_query($sqlcompany,$db);
	$Company = DB_fetch_array($StatementResultcompany,$db);		
			
	$pdf->SetXY( 25, 10 );
	$pdf->SetFont('','B','10'); 
	$pdf->Cell(40,20,date('d-m-Y'),15);
	$pdf->Cell(0,10,$Company['advocatename'],0,0,'R',false);
	$pdf->SetFont('','B','9'); 
	$pdf->Cell(0,20,$Company['degree'],0,0,'R',false);

	$pdf->Ln(); 
	
	$pdf->SetXY( 10, 28 ); 
	$pdf->SetFont('','B','10'); 
	$pdf->SetFillColor(128,128,128); 
	$pdf->SetTextColor(255); 
	$pdf->SetDrawColor(92,92,92); 
	$pdf->SetLineWidth(.3); 
	
	$pdf->Cell(7,7,"ID",1,0,'C',true); 
	$pdf->Cell(21,7,"Date",1,0,'C',true); 
	$pdf->Cell(30,7,"Name of Party",1,0,'C',true); 
	$pdf->Cell(100,7,"Message",1,0,'C',true); 
	$pdf->Cell(30,7,"Mobile",1,0,'C',true); 
	
	$pdf->Ln(); 
	$fill = false;
	
	while($Contacts=DB_fetch_array($StatementResults))
    {
				$resultparty=DB_query("SELECT name,mobile FROM lw_contacts WHERE lw_contacts.id='" . $Contacts['party'] . "'",$db);	
				$myrowparty=DB_fetch_array($resultparty);
	  			if($Contacts['smsdate']!="")
				{
				$Contacts['smsdate']=ConvertSQLDate($Contacts['smsdate']);
				}
				else
				{
				$Contacts['smsdate']=$Contacts['smsdate'];
				}
				//role based display below
				$pdf->Row(array($Contacts['id'],$Contacts['smsdate'],$myrowparty['name'],$Contacts['message'],$myrowparty['mobile']));
	}
	
		$pdf->AliasNbPages();
		$pdf = $pdf->Output();
		$len = strlen($pdf);
	
		header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: inline; filename=SmsList.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		$pdf->Output('SmsList.pdf','I');

?>
