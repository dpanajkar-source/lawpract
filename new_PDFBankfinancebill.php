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
		
	$result=DB_query("SELECT bf_cases.billno,
						bf_cases.applicationno,
						lw_contacts.name,
						bf_bank_branch.branch_area,
						bf_cases.billdate,
						bf_cases.loanamount,
						bf_cases.fees					
			FROM bf_cases LEFT JOIN bf_bank_branch ON bf_cases.branch_id=bf_bank_branch.id INNER JOIN lw_contacts ON bf_cases.custid=lw_contacts.id WHERE bf_cases.billno='" . $_GET['Billno'] ."'",$db);		
					
	$resultbankname=DB_query("SELECT bf_banks.bank_name, bf_banks.address FROM bf_bills INNER JOIN bf_banks ON bf_bills.bank_id=bf_banks.id WHERE bf_bills.billno='" . $_GET['Billno'] ."'",$db);					
					
	$myrowbankname=DB_fetch_array($resultbankname);	
	
	
	//calculate total fees
		$resultfees=DB_query("SELECT sum(bf_cases.fees) AS totalfees, sum(bf_cases.loanamount) AS totalloan					
			FROM bf_cases LEFT JOIN bf_bills ON bf_cases.billno=bf_bills.billno WHERE bf_bills.billno='" . $_GET['Billno'] ."'",$db);
			$totalfees = DB_fetch_array($resultfees,$db);
		
$sqlcompany = 'SELECT * FROM companies WHERE coycode=1';
	$StatementResultcompany=DB_query($sqlcompany,$db);
$Company = DB_fetch_array($StatementResultcompany,$db);		
			
$i=1;
$pdf->SetXY( 10,10 ); 
		 
$pdf->SetDrawColor(255,255,255);
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Helvetica','B',13);
$pdf->SetWidths(array(20,10,125,30));

$pdf->Row(array($pdf->Image('adv.png',10,12,12,0,'','', false, $maskImg),'',$pdf->Cell(0,7,$Company['advocatename'],0,0,'C',false)),4,'');

$pdf->SetFont('Helvetica','',9);
$pdf->Row(array('','',$pdf->Cell(0,7,$Company['degree'],0,0,'C',false)),'');
$pdf->SetFont('Helvetica','',9);
$pdf->SetWidths(array(195));
	
	$pdf->Row(array('Address : ' . $Company['address']));
$pdf->SetXY( 10,32 );
$pdf->Row(array('','',$pdf->Cell(0,7,'REG. No.' . $Company['barnumber'],0,1,'C',false)),'');
$pdf->SetDrawColor(0,0,0);
$pdf->Line(10,38,200,38);

$pdf->SetDrawColor(248,248,255);
$pdf->SetWidths(array(10,125,30,30));
$pdf->SetFont('Helvetica','',10);
$pdf->SetXY( 10,40 );
$pdf->Row(array('To : ',$myrowbankname['bank_name'],'Bill No. ',$_GET['Billno']));
$pdf->Row(array('',$myrowbankname['address'],'Date:',$date->format('d-m-Y')));
	
	$pdf->SetWidths(array(10,30,30,50,40,30));	
	$pdf->SetXY( 10, 50 ); 
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
	$pdf->Cell(30,7,"Fees Charged",1,0,'C',true); 
	
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
	$pdf->Ln(); 
	
	$pdf->SetFont('','B','9');	
	$pdf->SetDrawColor(255,255,255); 
	$pdf->SetWidths(array(30,30,30,30,40,30));
	$pdf->Row(array('','','','TOTAL -',$totalfees['totalloan'].'/-',$totalfees['totalfees'].'/-'));
$pdf->SetFont('','BI','9');
	$pdf->Cell(0.1,7,'In Words '. number_word($totalfees['totalfees'],0,0,'L',false));
	
	
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
