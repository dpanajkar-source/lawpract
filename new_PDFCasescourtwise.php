<?php
    $PageSecurity = 2;
     include("includes/session.php");
	
  require('mc_tablenew.php');
	

	$pdf=new PDF_MC_Table();
	$pdf->AddPage('','Legal');

	$pdf->SetFont('Helvetica','B',9);
	//Table with 5 columns
	$pdf->SetWidths(array(7,17,27,21,26,25,25,27,19));

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
		FROM lw_cases AS c INNER JOIN lw_contacts AS p1 ON c.party=p1.id INNER JOIN lw_contacts AS p2 ON c.oppoparty=p2.id INNER JOIN lw_courts ON c.courtid=lw_courts.courtid INNER JOIN lw_stages ON c.stage=lw_stages.stageid WHERE c.courtid = '" . trim($_GET['courtpdf']) . "' AND c.deleted!=1";
			
	$StatementResults=DB_query($sql,$db);	
	
	$StatementResultsnum_rows=DB_query($sql,$db);	

		
$sqlcompany = 'SELECT * FROM companies WHERE coycode=1';
	$StatementResultcompany=DB_query($sqlcompany,$db);
$Company = DB_fetch_array($StatementResultcompany,$db);		
			
$i=1;


	//$pdf->Cell(40,10,$date->format('d-m-Y'),15); 
	//$pdf->Cell(40,10,'Day Wise Cases List',15); 
	$pdf->SetXY( 25, 10 );
	$pdf->SetFont('','B','10'); 
	$pdf->Cell(40,20,$date->format('d-m-Y'),15);
	$pdf->Cell(0,10,$Company['advocatename'],0,0,'R',false);
	$pdf->SetFont('','B','9'); 
	$pdf->Cell(0,20,$Company['degree'],0,0,'R',false);

	$pdf->Ln(); 
	
	$pdf->SetXY( 10, 28 ); 
	$pdf->SetFont('','B','10'); 
	$pdf->SetFillColor(128,128,128); 
	$pdf->SetTextColor(255); 
	$pdf->SetDrawColor(92,92,92); 
	$pdf->SetLineWidth(.3); 
	
	$pdf->Cell(7,7,"ID",1,0,'C',true); 
	$pdf->Cell(17,7,"Prev Date",1,0,'C',true); 
	$pdf->Cell(27,7,"Brief/File",1,0,'C',true); 
	$pdf->Cell(21,7,"Court|Judge",1,0,'C',true); 
	$pdf->Cell(26,7,"Case No",1,0,'C',true); 
	$pdf->Cell(50,7,"Name Of Parties",1,0,'C',true); 
	$pdf->Cell(27,7,"Stage",1,0,'C',true); 
	$pdf->Cell(19,7,"Next Date",1,0,'C',true);
	
	$pdf->Ln(); 
	
	$pdf->SetFillColor(224,235,255); 
	$pdf->SetTextColor(0); 
	$pdf->SetFont(''); 
	
	$pdf->Cell(98,7,"",1,0,'C',False); 
 
	$pdf->Cell(25,7,"Party",1,0,'C',true); 
	$pdf->Cell(25,7,"Opposite Party",1,0,'C',true);
	$pdf->Cell(46,7,"",1,0,'C',False); 


	$pdf->Ln(); 
	$fill = false;
	
$myrownum_rows=DB_num_rows($StatementResultsnum_rows);
 
	while($Contacts=DB_fetch_array($StatementResults))
    {		
   $sqldates='SELECT lw_trans.prevcourtdate, lw_trans.nextcourtdate, lw_trans.currtrandate FROM lw_trans WHERE lw_trans.brief_file="' . $Contacts['brief_file']  .  '" ORDER BY lw_trans.nextcourtdate DESC LIMIT 1';
	$StatementResultsnextcourtdate=DB_query($sqldates,$db);
	$myrowtransbrieflastcourtdate=DB_fetch_array($StatementResultsnextcourtdate);
	//role ids fetch from lw_cases
				
$resultroleid=DB_query("SELECT partyrole,oppopartyrole FROM lw_cases WHERE lw_cases.brief_file='" . $Contacts['brief_file'] . "'",$db);	
			$myrowroleid=DB_fetch_array($resultroleid);			
			
			//roles fetch from lw_partiesinvolved
			
$resultpartyrole=DB_query("SELECT role,tag FROM lw_partiesinvolved WHERE lw_partiesinvolved.roleid='" . $myrowroleid['partyrole'] . "'",$db);	
			$myrowpartyrole=DB_fetch_array($resultpartyrole);
			
$resultoppopartyrole=DB_query("SELECT role,tag FROM lw_partiesinvolved WHERE lw_partiesinvolved.roleid='" . $myrowroleid['oppopartyrole'] . "'",$db);	
			$myrowoppopartyrole=DB_fetch_array($resultoppopartyrole);
			
			
	if($myrowtransbrieflastcourtdate['prevcourtdate']!="")
	{
	$myrowtransbrieflastcourtdate['prevcourtdate']=ConvertSQLDate($myrowtransbrieflastcourtdate['prevcourtdate']);
	}
	
	else
	
	{
	$myrowtransbrieflastcourtdate['prevcourtdate']=$myrowtransbrieflastcourtdate['prevcourtdate'];
	}


if($myrowtransbrieflastcourtdate['nextcourtdate']!="")
	{
	$myrowtransbrieflastcourtdate['nextcourtdate']=ConvertSQLDate($myrowtransbrieflastcourtdate['nextcourtdate']);
	}
	
	else
	
	{
	$myrowtransbrieflastcourtdate['nextcourtdate']=$myrowtransbrieflastcourtdate['nextcourtdate'];
	}
	
	if($myrowtransbrieflastcourtdate['currtrandate']!="")
	{
	$myrowtransbrieflastcourtdate['currtrandate']=ConvertSQLDate($myrowtransbrieflastcourtdate['currtrandate']);
	}
	
	else
	
	{
	$myrowtransbrieflastcourtdate['currtrandate']=$myrowtransbrieflastcourtdate['currtrandate'];
	}
	
	//role based display below
	
if($myrowpartyrole['tag']=='L')

	{
	$party='*'.$Contacts['party'] . ' , ' . $myrowpartyrole['role'];	
	$oppoparty=$Contacts['oppoparty'] . ' , ' . $myrowoppopartyrole['role'];	
	}
	
	else if($myrowpartyrole['tag']=='R')
	
	{
	// this is for party role 2,4,6,9,13
	$party=$Contacts['party'] . ' , ' . $myrowoppopartyrole['role'];
	$oppoparty='*'.$Contacts['oppoparty'] . ' , ' . $myrowpartyrole['role'];
	}
			
	
	
	$pdf->Row(array($i++,$myrowtransbrieflastcourtdate['prevcourtdate'],$Contacts['brief_file'],$Contacts['courtname'] . ' , ' . $Contacts['judgename'],$Contacts['courtcaseno'],$party,$oppoparty,$Contacts['stage'],$myrowtransbrieflastcourtdate['currtrandate']));
	}
	
$pdf->AliasNbPages();
   //$pdf = $pdf->Output();
	$len = strlen($pdf);
	
	if ($myrownum_rows>0){
   	
	$pdf = $pdf->Output();
	$len = strlen($pdf);
	
		header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: inline; filename=CourtwisecasesList.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		$pdf->Output('CourtwisecasesList.pdf','I');

		
	} else {
		
		$title = _('Print Courtwise Cases List Error'); ?>
		<div style="text-align:center; font-weight:bold">There were no records to print out for the selections specified
		<?php echo '<br><a href="'. $rootpath.' /index.php?' . SID . '">'. _('Back to Home Page'). '</a></div>';
		
		exit;

	}	
?>
