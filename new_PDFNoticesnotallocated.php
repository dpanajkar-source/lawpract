<?php
    $PageSecurity = 2;
     include("includes/session.php");
     
    require('mc_tablenew_noticesnotallocated.php');
  

	$pdf=new PDF_MC_Table();
	$pdf->AddPage('L','A4');
	$pdf->SetFont('Helvetica','B',9);
	//Table with 5 columns
	$pdf->SetWidths(array(8,20,30,30,23,12,15,21,21,20,20,20));

	$pdf->SetXY( 10, 10 ); 
	$pdf->SetFont('','B','18'); 
	$pdf->Cell(40,10,'Notice List',15); 
	$pdf->Ln(); 
	$pdf->SetLineWidth(.3);

	$pdf->SetXY( 10, 30 ); 
	
		$pdf->SetFont('','B','10');
		$pdf->SetFillColor(128,128,128);  
		$pdf->SetTextColor(255);
	 
		$pdf->SetDrawColor(92,92,92);
	 
		
	
$pdf->Row(array('ID','Notice No','Party','Opposite Party','Notice Date','Send by','Recpt No','Recpt Dt','Claim Dt','Ret. Envelope Date','Received By','Remark'));	

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
			lw_notices.remark
			FROM lw_noticecr AS cr INNER JOIN lw_notices ON cr.noticeid=lw_notices.noticeno INNER JOIN lw_contacts AS p1 ON cr.party=p1.id INNER JOIN lw_contacts AS p2 ON cr.oppoparty=p2.id INNER JOIN lw_noticereply ON cr.noticeid=lw_noticereply.noticeno WHERE cr.allocated=0 ORDER BY cr.notice_no DESC",$db);			
		
		
			
 
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
		
		
	$pdf->Row(array($i++,$myrow['notice_no'],$myrow['party'],$myrow['oppoparty'],$myrow['noticedt'],$myrow['sendmode'],$myrow['postrecptno'],$myrow['receiptdt'],$myrow['claimdate'],$myrow['returnenvelopdt'],$myrow['receivedby'],$myrow['remark']));	
	
	
	//below is to display reply details
	$sqlnoticereply = "SELECT * FROM lw_noticereply WHERE noticeno = '" . $myrow['noticeid'] . "' AND replydt IS NOT NULL";
	$StatementResultsreply=DB_query($sqlnoticereply,$db);
	
	$myrowreply=DB_fetch_array($StatementResultsreply);
	if(!empty($myrowreply['replydt']))
	{
	
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
	
	$pdf->Row(array('','Reply','','',$myrowreply['replydt'],$myrowreply['replysendmode'],$myrowreply['replypostrecptno'],$myrowreply['replyreceiptdt'],$myrowreply['replyclaimdate'],$myrowreply['replyreturnenvelopdt'],$myrowreply['replyreceivedby'],$myrowreply['replyremark']));	
				}
				
		//below is to display rejoinder details
	$sqlnoticerej = "SELECT * FROM lw_noticerejoinder WHERE noticeno = '" . $myrow['noticeid'] . "'";
	$StatementResultsrej=DB_query($sqlnoticerej,$db);
	
	$myrowrej=DB_fetch_array($StatementResultsrej);
	if(!empty($myrowrej['rejdt']))
	{
	
					if(!empty($myrowrej['rejdt']))
					{
					$myrowrej['rejdt']=ConvertSQLDate($myrowrej['rejdt']);
					}	
					else	
					{
					$myrowrej['rejdt']="";
					}
						if(!empty($myrowrej['rejreceiptdt']))
					{
					$myrowrej['rejreceiptdt']=ConvertSQLDate($myrowrej['rejreceiptdt']);
					}	
					else	
					{
					$myrowrej['rejreceiptdt']="";
					}
						if(!empty($myrowrej['rejclaimdate']))
					{
					$myrowrej['rejclaimdate']=ConvertSQLDate($myrowrej['rejclaimdate']);
					}	
					else	
					{
					$myrowrej['rejclaimdate']="";
					}
						if(!empty($myrowrej['rejreturnenvelopdt']))
					{
					$myrowrej['rejreturnenvelopdt']=ConvertSQLDate($myrowrej['rejreturnenvelopdt']);
					}	
					else	
					{
					$myrowrej['rejreturnenvelopdt']="";
					}
	$pdf->Row(array('','Rejoinder','','',$myrowrej['rejdt'],$myrowrej['rejsendmode'],$myrowrej['rejpostrecptno'],$myrowrej['rejreceiptdt'],$myrowrej['rejclaimdate'],$myrowrej['rejreturnenvelopdt'],$myrowrej['rejreceivedby'],$myrowrej['rejremark']));	
	
					}	
					
	} // end of while loop for lw_notices
	

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
