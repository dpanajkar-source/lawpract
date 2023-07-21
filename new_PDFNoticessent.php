<?php
    $PageSecurity = 2;
     include("includes/session.php");
     
    require('mc_tablenew_notices.php');
  

	$pdf=new PDF_MC_Table();
	$pdf->AddPage('L','A4');
	$pdf->SetFont('Helvetica','B',9);
	//Table with 5 columns
	$pdf->SetWidths(array(8,20,30,30,23,12,15,21,21,20,20,15,15,13,20));

	$pdf->SetXY( 10, 10 ); 
	$pdf->SetFont('','B','18'); 
	$pdf->Cell(40,10,'Notice Sent List',15); 
	$pdf->Ln(); 
	$pdf->SetLineWidth(.3);

	$pdf->SetXY( 10, 30 ); 
	
		$pdf->SetFont('','B','10');
		$pdf->SetFillColor(128,128,128);  
		$pdf->SetTextColor(255);
	 
		$pdf->SetDrawColor(92,92,92);
	 
	$currmonth=date("m");
    $curryear=date("Y");	
	
$pdf->Row(array('ID','Notice No','Party','Opposite Party','Notice Date','Send by','Recpt No','Recpt Dt','Claim Dt','Ret. Envelope Date','Received By','Fees','Postage','Other Charges','Remark'));	

	$fill = false;
	
	$result=DB_query("SELECT cr.noticeid,
			cr.notice_no,
			p1.name AS party,
			p2.name AS oppoparty,
			lw_notices.noticedt,
			lw_notices.sendmode,
			lw_notices.postrecptno,
			lw_notices.receiptdt,
			lw_notices.claimdate,
			lw_notices.returnenvelopdt,
			lw_notices.receivedby,
			lw_notices.noticefees,
			lw_notices.postage,
			lw_notices.othercharges,
			lw_notices.remark
			FROM lw_noticecr AS cr INNER JOIN lw_notices ON cr.noticeid=lw_notices.noticeno INNER JOIN lw_contacts AS p1 ON cr.party=p1.id INNER JOIN lw_contacts AS p2 ON cr.oppoparty=p2.id WHERE cr.allocated=0 AND lw_notices.noticedt IS NOT NULL",$db);			
			 
		$resulttotalfees=DB_query("SELECT SUM(lw_notices.noticefees) AS totalfees,SUM(lw_notices.postage) AS totalpostage,SUM(lw_notices.othercharges) AS totalothercharges FROM lw_notices WHERE noticedt IS NOT NULL",$db);
		
		$myrowtotalfees=DB_fetch_array($resulttotalfees);	
			
 
	$i=1;
		$pdf->SetFillColor(255,255,255);  
		$pdf->SetTextColor(0);
		$fill = false;
	 
	
	while($myrow=DB_fetch_array($result))
    {
		if(!empty($myrow['noticedt']))
	{
	$myrow['noticedt']=ConvertSQLDate($myrow['noticedt']);
	}	
	else	
	{
	$myrow['noticedt']="";
	}	
	
	if(!empty($myrow['receiptdt']))
	{
	$myrow['receiptdt']=ConvertSQLDate($myrow['receiptdt']);
	}	
	else	
	{
	$myrow['receiptdt']="";
	}
	
	if(!empty($myrow['returnenvelopdt']))
	{
	$myrow['returnenvelopdt']=ConvertSQLDate($myrow['returnenvelopdt']);
	}	
	else	
	{
	$myrow['returnenvelopdt']="";
	}
	
	if(!empty($myrow['claimdate']))
	{
	$myrow['claimdate']=ConvertSQLDate($myrow['claimdate']);
	}	
	else	
	{
	$myrow['claimdate']="";
	}	
		$pdf->SetFont('','','10');
		
	$pdf->Row(array($i++,$myrow['notice_no'],$myrow['party'],$myrow['oppoparty'],$myrow['noticedt'],$myrow['sendmode'],$myrow['postrecptno'],$myrow['receiptdt'],$myrow['claimdate'],$myrow['returnenvelopdt'],$myrow['receivedby'],$myrow['noticefees'],$myrow['postage'],$myrow['othercharges'],$myrow['remark']));	
	
	
	
	}	
	
	$pdf->Row(array('','TOTAL','','','','','','','','','',$myrowtotalfees[0],$myrowtotalfees[1],$myrowtotalfees[2],''));		

	$pdf->AliasNbPages();
    $pdfcode = $pdf->output();
	$len = strlen($pdfcode);

      if ($len<=20){
		$title = _('Print Notices This Month List Error');
	
		echo '<p>';
		prnMsg( _('There were no Notices sent to print out for the selections specified') );
		echo '<br><a href="'. $rootpath.' /index.php?' . SID . '">'. _('Back to the menu'). '</a>';
		
		exit;
	} else {
		header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: inline; filename=NoticesentthismonthList.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		$pdf->Output('NoticesentthismonthList.pdf','I');		

	}
?>
