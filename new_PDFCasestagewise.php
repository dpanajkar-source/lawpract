<?php
    $PageSecurity = 2;
     include("includes/session.php");
	
 	
  require('mc_tablenewstagewise.php');
$pdf=new PDF_MC_Table();
$pdf->AddPage('','Legal');

$pdf->SetFont('Helvetica','B',9);
//Table with 5 columns
$pdf->SetWidths(array(10,22,33,19,29,30,30,22));

    $DateString = Date($_SESSION['DefaultDateFormat']);
	
	$date = new DateTime(FormatDateForSQL($DateString));
                   // $date->sub(new DateInterval('P1D'));                         
         	
	/* Now figure out the Transactions data to report for the selections made */
	$sql = "SELECT c.brief_file,
			p1.name AS party,
			p2.name AS oppoparty,
			p1.mobile,
			c.courtcaseno,
			lw_courts.courtname,
			lw_stages.stage
		FROM lw_cases AS c INNER JOIN lw_contacts AS p1 ON c.party=p1.id INNER JOIN lw_contacts AS p2 ON c.oppoparty=p2.id INNER JOIN lw_courts ON c.courtid=lw_courts.courtid INNER JOIN lw_stages ON c.stage=lw_stages.stageid WHERE c.stage = '" . trim($_GET['stagepdf']) . "' AND c.deleted!=1";
			
	$StatementResults=DB_query($sql,$db);	
	
	$StatementResultsnum_rows=DB_query($sql,$db);
		
	$stage=DB_fetch_array($StatementResults);

		
$sqlcompany = 'SELECT * FROM companies WHERE coycode=1';
	$StatementResultcompany=DB_query($sqlcompany,$db);
$Company = DB_fetch_array($StatementResultcompany,$db);		
			
$i=1;

 
	
$pdf->SetXY( 25, 10 );
	$pdf->SetFont('','B','12'); 
	$pdf->Cell(40,20,'Stage : '. $stage['stage'],15);  
	$pdf->Cell(0,10,$Company['advocatename'],0,0,'R',false);
	$pdf->SetFont('','B','9'); 
	$pdf->Cell(0,20,$Company['degree'],0,0,'R',false);
	

	$pdf->Ln(); 
	
	$pdf->SetXY( 10, 30 ); 
	$pdf->SetFont('','B','10'); 
	$pdf->SetFillColor(128,128,128); 
	$pdf->SetTextColor(255); 
	$pdf->SetDrawColor(92,92,92); 
	$pdf->SetLineWidth(.3); 
	
	
	
	
	$pdf->Cell(10,7,"ID",1,0,'C',true); 
	$pdf->Cell(22,7,"Prev Date",1,0,'C',true); 
	$pdf->Cell(33,7,"Brief/ File",1,0,'C',true); 
	$pdf->Cell(19,7,"Court",1,0,'C',true); 
	$pdf->Cell(29,7,"Case No",1,0,'C',true); 
	$pdf->Cell(60,7,"Name Of Parties",1,0,'C',true); 
 	$pdf->Cell(22,7,"Next Date",1,0,'C',true);
	

	$pdf->Ln(); 
	
	$pdf->SetFillColor(224,235,255); 
	$pdf->SetTextColor(0); 
	$pdf->SetFont(''); 
	
	$pdf->Cell(113,7,"",1,0,'C',False); 
 
	$pdf->Cell(30,7,"Party",1,0,'C',true); 
	$pdf->Cell(30,7,"Opposite Party",1,0,'C',true);
	$pdf->Cell(22,7,"",1,0,'C',False); 


	$pdf->Ln(); 
	$fill = false;
 
	while($Contacts=DB_fetch_array($StatementResults))
    {	
	
	
   $sqldates='SELECT lw_trans.prevcourtdate, lw_trans.nextcourtdate FROM lw_trans WHERE lw_trans.brief_file="' . $Contacts['brief_file']  .  '" ORDER BY lw_trans.nextcourtdate DESC LIMIT 1';
	$StatementResultsnextcourtdate=DB_query($sqldates,$db);
	$myrowtransbrieflastcourtdate=DB_fetch_array($StatementResultsnextcourtdate);
	
			if(!empty($myrowtransbrieflastcourtdate['nextcourtdate']))
	{
	$myrowtransbrieflastcourtdate['nextcourtdate']=ConvertSQLDate($myrowtransbrieflastcourtdate['nextcourtdate']);
	}
	
	else
	
	{
	$myrowtransbrieflastcourtdate['nextcourtdate']=$myrowtransbrieflastcourtdate['nextcourtdate'];
	}


if(!empty($myrowtransbrieflastcourtdate['prevcourtdate']))
	{
	$myrowtransbrieflastcourtdate['prevcourtdate']=ConvertSQLDate($myrowtransbrieflastcourtdate['prevcourtdate']);
	}
	
	else
	
	{
	$myrowtransbrieflastcourtdate['prevcourtdate']=$myrowtransbrieflastcourtdate['prevcourtdate'];
	}
	
	$pdf->Row(array($i++,$myrowtransbrieflastcourtdate['prevcourtdate'],$Contacts['brief_file'],$Contacts['courtname'],$Contacts['courtcaseno'],$Contacts['party'],$Contacts['oppoparty'],$myrowtransbrieflastcourtdate['nextcourtdate']));
	}
	
	$pdf->SetXY( 25, 10 );
	$pdf->SetFont('','B','12'); 
$pdf->Cell(40,20,'Stage :'. $Contacts['stage'],15);  


	$pdf->AliasNbpages();
	 $pdfcode = $pdf->output();
	$len = strlen($pdfcode);
	
      if ($len<=20){
		$title = _('Print Stagewise Cases List Error');
	
		echo '<p>';
		prnMsg( _('There were no cases to print out for the selections specified') );
		echo '<br><a href="'. $rootpath.' /index.php?' . SID . '">'. _('Back to the menu'). '</a>';
		
		exit;
	} else {
		header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: inline; filename=CasestagewiseList.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		$pdf->Output('CasestagewiseList.pdf','I');
		

	}
?>
