<?php
    $PageSecurity = 2;
     include("includes/session.php");     
    
   require('mc_tablenew_OldCasesList.php');

	$pdf=new PDF_MC_Table();
	$pdf->AddPage('L','A4');
	$pdf->SetFont('Helvetica','B',9);
	//Table with 5 columns
$pdf->SetWidths(array(10,40,25,35,45,45,30,50));
	
	$pdf->SetXY( 30, 15 ); 
	$pdf->SetFont('','B','18'); 
	$pdf->Cell(40,10,'Pending Cases List',15); 
	$pdf->Ln(); 
	
	$pdf->SetXY( 10, 30 ); 
	$pdf->SetFont('','B','10'); 
	$pdf->SetFillColor(128,128,128); 
	$pdf->SetTextColor(255); 
	$pdf->SetDrawColor(92,92,92); 
	$pdf->SetLineWidth(.3); 	
	$pdf->Cell(10,7,"ID",1,0,'C',true); 
	$pdf->Cell(40,7,"Brief File",1,0,'C',true); 
	$pdf->Cell(25,7,"Court",1,0,'C',true); 
	$pdf->Cell(35,7,"Case No",1,0,'C',true); 
	$pdf->Cell(90,7,"Name Of Parties",1,0,'C',true); 

	$pdf->Cell(30,7,"Mobile",1,0,'C',true); 
	$pdf->Cell(50,7,"Duration",1,0,'C',true); 
	
	$pdf->Ln(); 
	
	$pdf->SetFillColor(224,235,255); 
	$pdf->SetTextColor(0); 
	$pdf->SetFont(''); 
	
	$pdf->Cell(110,7,"",1,0,'C',False); 
 
	$pdf->Cell(45,7,"Party",1,0,'C',true); 
	$pdf->Cell(45,7,"Opposite Party",1,0,'C',true);
	$pdf->Cell(80,7,"",1,0,'C',False); 
	$pdf->Ln(); 
	$fill = false;
	
	$sql = "SELECT c.brief_file,
			p1.name AS party,
			p2.name AS oppoparty,
			p1.mobile,
			c.courtcaseno,
			lw_courts.courtname,
			c.opendt
		FROM lw_cases AS c INNER JOIN lw_contacts AS p1 ON c.party=p1.id INNER JOIN lw_contacts AS p2 ON c.oppoparty=p2.id INNER JOIN lw_courts ON c.courtid=lw_courts.courtid WHERE c.deleted!=1 AND c.stage!=51 OR c.stage!=36 OR c.stage!=37 OR c.stage!=38 OR c.stage!=39 OR c.stage!=40 OR c.stage!=49 OR c.stage!=50 ORDER BY opendt ASC";
	
	$result=DB_query($sql,$db);
	
	$datetime1 = new DateTime("now");
	
	$i=1;

	while($Contacts=DB_fetch_array($result))
    {	       
        $datetime2 = new DateTime($Contacts['opendt']);
        $interval = date_diff($datetime2,$datetime1);
            
        $year=$interval->format('%a');
		
	$pdf->Row(array($i++,$Contacts['brief_file'],$Contacts['courtname'],$Contacts['courtcaseno'],$Contacts['party'],$Contacts['oppoparty'],$Contacts['mobile'],'In Years-   ' . round($year/365) . '          In no of days  ' . $interval->format('%a days')));
	}	
	
	$pdf->AliasNbPages();
    $pdfcode = $pdf->output();
	$len = strlen($pdfcode);

      if ($len<=20){
		$title = _('Print Pending Cases List Error');
	
		echo '<p>';
		prnMsg( _('There were no Pending Cases to print out for the selections specified') );
		echo '<br><a href="'. $rootpath.' /index.php?' . SID . '">'. _('Back to the menu'). '</a>';
		
		exit;
	} else {
		header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: inline; filename=PendingCasesList.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		$pdf->Output('PendingCasesList.pdf','I');
		

	}
?>
