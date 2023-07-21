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
	$pdf->Cell(40,10,'Notice Reply Sent List',15); 
	$pdf->Ln(); 
	$pdf->SetLineWidth(.3);

	$pdf->SetXY( 10, 30 ); 
	
		$pdf->SetFont('','B','10');
		$pdf->SetFillColor(128,128,128);  
		$pdf->SetTextColor(255);
	 
		$pdf->SetDrawColor(92,92,92);
	 
	$currmonth=date("m");
    $curryear=date("Y");	
	
$pdf->Row(array('ID','Notice Reply No','Party','Opposite Party','Reply Date','Send by','Recpt No','Recpt Dt','Claim Dt','Ret. Envelope Date','Received By','Fees','Postage','Other Charges','Remark'));	

	$fill = false;
	
	$result=DB_query("SELECT cr.noticeid,
			cr.notice_no,
			p1.name AS party,
			p2.name AS oppoparty,
			lw_noticereply.replydt,
			lw_noticereply.replysendmode,
			lw_noticereply.replypostrecptno,
			lw_noticereply.replyreceiptdt,
			lw_noticereply.replyclaimdate,
			lw_noticereply.replyreturnenvelopdt,
			lw_noticereply.replyreceivedby,
			lw_noticereply.replynoticefees,
			lw_noticereply.replypostage,
			lw_noticereply.replyothercharges,
			lw_noticereply.replyremark
			FROM lw_noticecr AS cr INNER JOIN lw_noticereply ON cr.noticeid=lw_noticereply.noticeno INNER JOIN lw_contacts AS p1 ON cr.party=p1.id INNER JOIN lw_contacts AS p2 ON cr.oppoparty=p2.id WHERE cr.allocated=0 AND lw_noticereply.replydt IS NOT NULL",$db);			
			
			
		$resulttotalfees=DB_query("SELECT SUM(lw_noticereply.replynoticefees) AS totalfees,SUM(lw_noticereply.replypostage) AS totalpostage,SUM(lw_noticereply.replyothercharges) AS totalothercharges FROM lw_noticereply WHERE replydt IS NOT NULL",$db);
		
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
	//below is to display reply details
	$sqlnoticereply = "SELECT * FROM lw_noticereply WHERE noticeno = '" . $myrow['noticeid'] . "'";
	$StatementResultsreply=DB_query($sqlnoticereply,$db);
	
	$myrowreply=DB_fetch_array($StatementResultsreply);
	
	if(!empty($myrowreply['replydt']))
	{
	$myrowreply['replydt']=ConvertSQLDate($myrowreply['replydt']);
	}	
	else	
	{
	$myrowreply['replydt']="";
	}
	
	if(!empty($myrowreply['replyreceiptdt']))
	{
	$myrowreply['replyreceiptdt']=ConvertSQLDate($myrowreply['replyreceiptdt']);
	}	
	else	
	{
	$myrowreply['replyreceiptdt']="";
	}
	
	if(!empty($myrowreply['replyclaimdate']))
	{
	$myrowreply['replyclaimdate']=ConvertSQLDate($myrowreply['replyclaimdate']);
	}	
	else	
	{
	$myrowreply['replyclaimdate']="";
	}
	if(!empty($myrowreply['replyreturnenvelopdt']))
	{
	$myrowreply['replyreturnenvelopdt']=ConvertSQLDate($myrowreply['replyreturnenvelopdt']);
	}	
	else	
	{
	$myrowreply['replyreturnenvelopdt']="";
	}
	
	$pdf->Row(array('',$myrow['notice_no'],$myrow['party'],$myrow['oppoparty'],$myrowreply['replydt'],$myrowreply['replysendmode'],$myrowreply['replypostrecptno'],$myrowreply['replyreceiptdt'],$myrowreply['replyclaimdate'],$myrowreply['replyreturnenvelopdt'],$myrowreply['replyreceivedby'],$myrowreply['replynoticefees'],$myrowreply['replypostage'],$myrowreply['replyothercharges'],$myrowreply['replyremark']));	
	
	
	}	
	
	$pdf->Row(array('','TOTAL','','','','','','','','','',$myrowtotalfees[0],$myrowtotalfees[1],$myrowtotalfees[2],''));		

	$pdf->AliasNbPages();
    $pdfcode = $pdf->output();
	$len = strlen($pdfcode);

      if ($len<=20){
		$title = _('Print Notice Reply Sent List Error');
	
		echo '<p>';
		prnMsg( _('There were no Notice Reply Sen to print out for the selections specified') );
		echo '<br><a href="'. $rootpath.' /index.php?' . SID . '">'. _('Back to the menu'). '</a>';
		
		exit;
	} else {
		header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: inline; filename=Noticesreceived.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		$pdf->Output('Noticesreceived.pdf','I');		

	}
?>
