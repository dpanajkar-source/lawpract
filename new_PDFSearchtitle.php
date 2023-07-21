<?php
    $PageSecurity = 2;
     include("includes/session.php");
     
    require('mc_tablenew_searchtitle.php');  

	$pdf=new PDF_MC_Table();
	$pdf->AddPage('','Legal');
	$pdf->SetFont('Helvetica','B',9);
	//Table with 5 columns
	$pdf->SetWidths(array(8,20,20,25,25,25,25,28,23));

	$pdf->SetXY( 10, 10 ); 
	$pdf->SetFont('','B','18'); 
	$pdf->Cell(40,10,'Search Titles List',15); 
	$pdf->Ln(); 
	$pdf->SetLineWidth(.3);
	$pdf->SetXY( 10, 30 ); 
	
		$pdf->SetFont('','B','10');
		$pdf->SetFillColor(128,128,128);  
		$pdf->SetTextColor(255);	 
		$pdf->SetDrawColor(92,92,92);	 
		
$pdf->Row(array('ID','File No','Inward Date','Property','Details','Party Name','Agent','Status','Remark'));	

	//$fill = false;
	
	$result=DB_query("SELECT 
			lw_searchtitle.fileno,
			lw_searchtitle.property,
			lw_searchtitle.propertydetails,
			p1.name AS client,
			p2.name AS agent,
			lw_taskstatus.status,
			lw_searchtitle.inward_date,
			lw_searchtitle.remark			
			FROM lw_searchtitle INNER JOIN lw_contacts AS p1 ON lw_searchtitle.custid=p1.id 
			INNER JOIN lw_contacts AS p2 ON lw_searchtitle.agent=p2.id 
			INNER JOIN lw_taskstatus ON lw_searchtitle.status=lw_taskstatus.id WHERE lw_taskstatus.status!=3",$db);	
 
	$i=1;
		$pdf->SetFillColor(255,255,255);  
		$pdf->SetTextColor(0);
		$fill = false;	 
	
	while($myrow=DB_fetch_array($result)) 
    {
		
	if(!empty($myrow['inward_date']))
	{
	$myrow['inward_date']=ConvertSQLDate($myrow['inward_date']);
	}	
	else	
	{
	$myrowr['inward_date']="NULL";
	}
	
		$pdf->SetFont('','','10');
		
	$pdf->Row(array($i++,$myrow['fileno'],$myrow['inward_date'],$myrow['client'],$myrow['property'],$myrow['propertydetails'],$myrow['agent'],$myrow['status'],$myrow['remark']));		
	
	}		
		

	$pdf->AliasNbPages();
    $pdfcode = $pdf->output();
	$len = strlen($pdfcode);

      if ($len<=20){
		$title = _('Print Search Titles List Error');
	
		echo '<p>';
		prnMsg( _('There were no Search Titles to print out for the selections specified') );
		echo '<br><a href="'. $rootpath.' /index.php?' . SID . '">'. _('Back to the menu'). '</a>';
		
		exit;
	} else {
		header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: inline; filename=Searchtitles.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		$pdf->Output('Searchtitles.pdf','I');		

	}
?>
