<?php
    $PageSecurity = 2;
     include("includes/session.php");
	 	
  require('mc_tablenewcategorywise.php');
  
$pdf=new PDF_MC_Table();
$pdf->AddPage('','Legal');

$pdf->SetFont('Helvetica','B',9);
//Table with 5 columns
$pdf->SetWidths(array(8,17,29,19,25,25,25,28,19));

    $DateString = Date($_SESSION['DefaultDateFormat']);
	
	$date = new DateTime(FormatDateForSQL($DateString));
                   // $date->sub(new DateInterval('P1D'));                         
         	
	/* Now figure out the Transactions data to report for the selections made */
	 $sql = 'SELECT c.brief_file,
			p1.name AS party,
			p2.name AS oppoparty,
			lw_casecat.casecat,
			c.courtcaseno,
			lw_stages.stage,
			lw_clientcat.category,
			lw_courts.courtname,
			lw_case_status.casestatusdesc
		FROM lw_cases AS c 
		INNER JOIN lw_contacts AS p1 ON c.party=p1.id 
		INNER JOIN lw_contacts AS p2 ON c.oppoparty=p2.id 
		INNER JOIN lw_courts ON c.courtid=lw_courts.courtid
		INNER JOIN lw_stages ON c.stage=lw_stages.stageid
		INNER JOIN lw_casecat ON c.casecatid=lw_casecat.casecatid 
		LEFT JOIN lw_clientcat ON c.clientcatid=lw_clientcat.clientcatid 
		INNER JOIN lw_case_status ON c.casestatus=lw_case_status.casestatusid 
		WHERE c.clientcatid="' . $_GET['Clientcat']  .  '" AND c.deleted!=1';
		
$StatementResults=DB_query($sql,$db);	

$sqlcompany = 'SELECT * FROM companies WHERE coycode=1';
	$StatementResultcompany=DB_query($sqlcompany,$db);
$Company = DB_fetch_array($StatementResultcompany,$db);		
			
$i=1;

 $sqlclientcat = 'SELECT category FROM lw_clientcat WHERE clientcatid="' . $_GET['Clientcat']  .  '"';
		
$StatementResultsclientcat=DB_query($sqlclientcat,$db);	

$Casecategory=DB_fetch_array($StatementResultsclientcat);

$pdf->SetXY( 10,5 ); 
	$pdf->SetFont('','B','12'); 
	$pdf->Cell(40,10,$date->format('d-m-Y'),15); 
	//$pdf->Cell(40,10,'Day Wise Cases List',15); 
	$pdf->SetXY(10, 10 );

	$pdf->Cell(40,20,$Company['coyname'],15); 

	$pdf->SetXY( 10, 10 ); 
	$pdf->SetFont('','B','11'); 
	
	$pdf->Cell(28,10,'CATEGORY - ',10); 
	$pdf->SetTextColor(0,0,111);
	$pdf->Cell(40,10,$Casecategory['category'],15);
	$pdf->Ln(); 	 
	
	$pdf->SetXY( 10, 30 ); 
	$pdf->SetFont('','B','10'); 
	$pdf->SetFillColor(128,128,128); 
	$pdf->SetTextColor(255); 
	$pdf->SetDrawColor(92,92,92); 
	$pdf->SetLineWidth(.3); 
	
	$pdf->Cell(8,7,"ID",1,0,'C',true); 
	$pdf->Cell(17,7,"Prev Date",1,0,'C',true); 
	$pdf->Cell(29,7,"Brief/ File",1,0,'C',true); 
	$pdf->Cell(19,7,"Court",1,0,'C',true); 
	$pdf->Cell(25,7,"Case No",1,0,'C',true); 
	$pdf->Cell(50,7,"Name Of Parties",1,0,'C',true); 
	$pdf->Cell(28,7,"Stage",1,0,'C',true); 
	$pdf->Cell(19,7,"Next Date",1,0,'C',true);
	
	$pdf->Ln(); 
	
	$pdf->SetFillColor(224,235,255); 
	$pdf->SetTextColor(0); 
	$pdf->SetFont(''); 
	
	$pdf->Cell(98,7,"",1,0,'C',False); 
 
	$pdf->Cell(25,7,"Party",1,0,'C',true); 
	$pdf->Cell(25,7,"Opposite Party",1,0,'C',true);
	$pdf->Cell(47,7,"",1,0,'C',False); 
	
	$pdf->Ln(); 
	$fill = false;
 	
	
	
	$cat=0;
	while($Contacts=DB_fetch_array($StatementResults))
		{
		
		$sqldates='SELECT lw_trans.prevcourtdate, lw_trans.nextcourtdate FROM lw_trans WHERE lw_trans.brief_file="' . $Contacts['brief_file']  .  '"   ORDER BY lw_trans.nextcourtdate DESC LIMIT 1';
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
	
	
	$pdf->Row(array($i++,$myrowtransbrieflastcourtdate['prevcourtdate'],$Contacts['brief_file'],$Contacts['courtname'],$Contacts['courtcaseno'],$Contacts['party'],$Contacts['oppoparty'],$Contacts['stage'],$myrowtransbrieflastcourtdate['nextcourtdate']));
	
	
	}
	
	 
	
	
$pdf->AliasNbpages();

    $pdfcode = $pdf->output();
	$len = strlen($pdfcode);
      if ($len<=20){
		$title = _('Print Client Category Error');
	
		echo '<p>';
		prnMsg( _('There were no Client Category to print out for the selections specified') );
		echo '<br><a href="'. $rootpath.' /index.php?' . SID . '">'. _('Back to the menu'). '</a>';
		
		exit;
	} else {
		header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: inline; filename=ClientCategorywiseCasesList.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		$pdf->Output('ClientCategorywiseCasesList.pdf','I');
		

	}
?>
