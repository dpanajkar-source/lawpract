<?php
    $PageSecurity = 2;
     include("includes/session.php");
     
    require('mc_tablenew_certification.php');  

	$pdf=new PDF_MC_Table();
	$pdf->AddPage('L','A4');
	$pdf->SetFont('Helvetica','B',9);
	//Table with 5 columns
	$pdf->SetWidths(array(8,20,20,30,30,25,30,28,23,20,20,20));

	$pdf->SetXY( 10, 10 ); 
	$pdf->SetFont('','B','18'); 
	$pdf->Cell(40,10,'Certification of Documents List',15); 
	$pdf->Ln(); 
	$pdf->SetLineWidth(.3);
	$pdf->SetXY( 10, 30 ); 
	
		$pdf->SetFont('','B','10');
		$pdf->SetFillColor(128,128,128);  
		$pdf->SetTextColor(255);	 
		$pdf->SetDrawColor(92,92,92);	 
		
$pdf->Row(array('ID','Brief File','Date','Party','Opposite Party','Courtcase No','Document Name','Req. For','Handled By','Status','Stage','Remark'));	

	$fill = false;
	
	$result=DB_query("SELECT lw_certification.brief_file,
			lw_certification.courtcaseno,
			lw_certification.documentname,
			lw_courts.courtname,
			lw_certification.requiredfor,
			lw_certification.handledby,
			lw_taskstatus.status,
			lw_certification.currentstage,
			lw_certification.c_date,
			lw_certification.remark			
			FROM lw_certification INNER JOIN lw_courts ON lw_certification.courtid=lw_courts.courtid 
			 INNER JOIN lw_taskstatus ON lw_certification.status=lw_taskstatus.id",$db);	
 
	$i=1;
		$pdf->SetFillColor(255,255,255);  
		$pdf->SetTextColor(0);
		$fill = false;	 
	
	while($myrow=DB_fetch_array($result))
    {
	
	$resultpartyoppoparty=DB_query("SELECT p1.name AS party,p2.name AS oppoparty FROM lw_cases AS c INNER JOIN lw_contacts AS p1 ON c.party=p1.id INNER JOIN lw_contacts AS p2 ON c.oppoparty=p2.id WHERE c.brief_file='" . $myrow['brief_file'] . "'",$db);	
			
$myrowpartyoppoparty=DB_fetch_array($resultpartyoppoparty);	  
	
			
	if(!empty($myrow['c_date']))
	{
	$myrow['c_date']=ConvertSQLDate($myrow['c_date']);
	}	
	else	
	{
	$myrowr['c_date']="NULL";
	}
	
		$pdf->SetFont('','','10');
	
	$pdf->Row(array($i++,$myrow['brief_file'],$myrow['c_date'],$myrowpartyoppoparty['party'],$myrowpartyoppoparty['oppoparty'],$myrow['courtcaseno'],$myrow['documentname'],$myrow['requiredfor'],$myrow['handledby'],$myrow['status'],$myrow['currentstage'],$myrow['remark']));		
	
	}		
		

	$pdf->AliasNbPages();
    $pdfcode = $pdf->output();
	$len = strlen($pdfcode);

      if ($len<=20){
		$title = _('Print Certification List Error');
	
		echo '<p>';
		prnMsg( _('There were no Certifications to print out for the selections specified') );
		echo '<br><a href="'. $rootpath.' /index.php?' . SID . '">'. _('Back to the menu'). '</a>';
		
		exit;
	} else {
		header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: inline; filename=Certification.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		$pdf->Output('Certification.pdf','I');		

	}
?>
