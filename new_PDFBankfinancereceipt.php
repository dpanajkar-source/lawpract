<?php
    $PageSecurity = 2;
     include("includes/session.php");
     
    
   require('mc_tablenew_Bankfinancebill.php');

	$pdf=new PDF_MC_Table();
	$pdf->AddPage();
	$pdf->SetFont('Helvetica','B',9);
	//Table with 5 columns

	
	
	
	 $DateString = Date($_SESSION['DefaultDateFormat']);
	
	$date = new DateTime(FormatDateForSQL($DateString));
		
	$result=DB_query("SELECT bf_cases.id,
						bf_cases.billno,
						bf_cases.applicationno,
						bf_bank_clients.name,
						bf_bank_branch.branch_area,
						bf_cases.billdate,
						bf_cases.loanamount,
						bf_cases.fees					
			FROM bf_cases LEFT JOIN bf_bank_branch ON bf_cases.branch_id=bf_bank_branch.id INNER JOIN bf_bank_clients ON bf_cases.custid=bf_bank_clients.id WHERE bf_bank_clients.name='" . $_GET['customer'] ."'",$db);		
					
	$resultbankname=DB_query("SELECT bf_banks.bank_name, bf_banks.address FROM bf_bills INNER JOIN bf_banks ON bf_bills.bank_id=bf_banks.id WHERE bf_bills.billno='" . $_GET['Billno'] ."'",$db);					
					
	$myrowbankname=DB_fetch_array($resultbankname);	
	
	
	//calculate total fees
		$resultfees=DB_query("SELECT sum(bf_cases.fees) AS totalfees, sum(bf_cases.loanamount) AS totalloan					
			FROM bf_cases WHERE bf_bills.billno='" . $_GET['Billno'] ."'",$db);
			$totalfees = DB_fetch_array($resultfees,$db);
		
$sqlcompany = 'SELECT * FROM companies WHERE coycode=1';
	$StatementResultcompany=DB_query($sqlcompany,$db);
$Company = DB_fetch_array($StatementResultcompany,$db);		
			
$i=1;
$pdf->SetXY( 10,10 ); 
	//$pdf->SetFont('','B','13'); 
	//$pdf->Cell(40,10,$Company['coyname'],15); 
// $pdf->SetFont('','B','10'); 
	//$pdf->Cell(40,10,'Day Wise Cases List',15); 
//	$pdf->SetXY(120, 5 );
	//$pdf->Cell(40,30,$Company['barnumber'],15);
	
	
	//$pdf->SetXY(152, 10 );
//	$pdf->Cell(40,30,$Company['email'],15);
	//$pdf->SetFont('','B','9');
	//$pdf->SetXY(12, 16 );
	//$pdf->Cell(40,30,$Company['address'],15);
	
	
//$pdf->SetXY( 10, 32 ); 
	//$pdf->SetFont('','B','14'); 
	//$pdf->Cell(40,11,'To: ' . $myrowbankname['bank_name'],15); 
	//$pdf->Ln(); 
	
//$pdf->SetXY( 10, 35 ); 
	//$pdf->SetFont('','B','10'); 
	//$pdf->Cell(40,20,15); 
	//$pdf->Ln(); 
	//$pdf->SetWidths(array(40,30,50,75)); 
	 
$pdf->SetDrawColor(255,255,255);
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Helvetica','',12);
$pdf->SetWidths(array(20,10,125,30));

$pdf->Row(array($pdf->Image('adv.png',10,12,12,0,'','', false, $maskImg),'',$pdf->Cell(0,7,$Company['coyname'],0,0,'C',false)),4,'');
$pdf->SetFont('Helvetica','',9);
$pdf->Row(array('','',$pdf->Cell(0,7,'BAR NO - ' . $Company['barnumber'],0,0,'C',false)),'');
$pdf->SetFont('Helvetica','',9);
$pdf->SetWidths(array(195));
$pdf->Row(array('','',$pdf->Cell(0,7,$Company['address'],0,1,'C',false)),'');
$pdf->SetDrawColor(0,0,0);
$pdf->Line(10,30,200,30);

$pdf->SetDrawColor(248,248,255);
$pdf->SetWidths(array(10,125,30,30));
$pdf->SetFont('Helvetica','',10);
$pdf->SetXY( 10,32 );
$pdf->Row(array('To : ',$myrowbankname['bank_name'],'Bill No. ',$_GET['Billno']));
$pdf->Row(array('',$myrowbankname['address'],'Date:',$date->format('d-m-Y')));
	//$pdf->Ln(); 
	
	//get bill no
	//$pdf->SetXY( 10,5 ); 

	//$pdf->Cell(40,10,'Day Wise Cases List',15); 
	
//$pdf->SetXY(170, 20 );
	//$pdf->Cell(40,35,'Bill No. ' . $_GET['Billno'],15); 
	//$pdf->SetXY(170, 40 );
	//$pdf->Cell(40,10,'Date: '.$date->format('d-m-Y'),15);

	$pdf->SetWidths(array(10,30,30,50,40,35));	
	$pdf->SetXY( 10, 43 ); 
	$pdf->SetFont('','B','10'); 
	$pdf->SetFillColor(128,128,128); 
	$pdf->SetTextColor(255); 
	$pdf->SetDrawColor(169,169,169); 
	$pdf->SetLineWidth(.3); 
	
	$pdf->Cell(10,7,"S.No.",1,0,'C',true); 
	$pdf->Cell(30,7,"Application No.",1,0,'C',true); 
	$pdf->Cell(30,7,"Branch",1,0,'C',true);
	$pdf->Cell(50,7,"Name of Customer",1,0,'C',true); 
	$pdf->Cell(40,7,"Loan Amount",1,0,'C',true); 
	$pdf->Cell(35,7,"Fees Charged",1,0,'C',true); 
	
	//$pdf->Ln(); 
	
//	$pdf->SetFillColor(224,235,255); 
	//$pdf->SetTextColor(0); 
	//$pdf->SetFont(''); 

$pdf->SetFont('','','9');
	$pdf->Ln(); 
	$fill = false;
	
$i=1;
	
	
	while($myrow=DB_fetch_array($result))
    {
		
	$pdf->Row(array($i++,$myrow['applicationno'],$myrow['branch_area'],$myrow['name'],$myrow['loanamount'].'/-',$myrow['fees'].'/-'));		
	
	}
	$pdf->SetFont('','B','9');	
	$pdf->Row(array('',number_word($totalfees['totalloan']),'TOTAL ',$totalfees['totalloan'].'/-',$totalfees['totalfees'].'/-'));
		

	$pdf->AliasNbPages();
    $pdfcode = $pdf->output();
	$len = strlen($pdfcode);

      if ($len<=20){
		$title = _('Print Records List Error');
	
		echo '<p>';
		prnMsg( _('There were no records to print out for the selections specified') );
		echo '<br><a href="'. $rootpath.' /index.php?' . SID . '">'. _('Back to the menu'). '</a>';
		
		exit;
	} else {
		header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: inline; filename=bf_Bankbill.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		$pdf->Output('bf_Bankbill.pdf','I');
		

	}
?>
