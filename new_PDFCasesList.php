<?php
    $PageSecurity = 2;
     include("includes/session.php");
     
    
   require('mc_tablenew_CasesList.php');

	$pdf=new PDF_MC_Table();
	$pdf->AddPage('','Legal');
	

	$pdf->SetFont('Helvetica','B',9);
	//Table with 5 columns
$pdf->SetWidths(array(8,17,29,20,27,25,25,25,20));
	$sqlcompany = 'SELECT * FROM companies WHERE coycode=1';
	$StatementResultcompany=DB_query($sqlcompany,$db);
$Company = DB_fetch_array($StatementResultcompany,$db);		
			
$i=1;
$DateString = Date($_SESSION['DefaultDateFormat']);
	
	$date = new DateTime(FormatDateForSQL($DateString));
	

$pdf->SetXY( 25, 10 );
	$pdf->SetFont('','B','14'); 
	$pdf->Cell(40,20,'Cases List ',15); 
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
	

	
		$pdf->Cell(8,7,"ID",1,0,'C',true); 
	$pdf->Cell(17,7,"Prev Date",1,0,'C',true); 
	$pdf->Cell(29,7,"Brief/ File",1,0,'C',true); 
	$pdf->Cell(20,7,"Court",1,0,'C',true); 
	$pdf->Cell(27,7,"Case No",1,0,'C',true); 
	$pdf->Cell(50,7,"Name Of Parties",1,0,'C',true); 
	$pdf->Cell(25,7,"Stage",1,0,'C',true); 
	$pdf->Cell(20,7,"Next Date",1,0,'C',true);
	
	
	$pdf->Ln(); 
	
	$pdf->SetFillColor(224,235,255); 
	$pdf->SetTextColor(0); 
	$pdf->SetFont(''); 
	
	$pdf->Cell(101,7,"",1,0,'C',False); 
 
	$pdf->Cell(25,7,"Party",1,0,'C',true); 
	$pdf->Cell(25,7,"Opposite Party",1,0,'C',true);
	$pdf->Cell(45,7,"",1,0,'C',False); 
$pdf->SetFont('','','9'); 

	$pdf->Ln(); 
	$fill = false;
	
	$sql = "SELECT c.brief_file,
			p1.name AS party,
			p2.name AS oppoparty,
			p1.mobile,
			c.courtcaseno,
			lw_courts.courtname,
			lw_stages.stage,
			c.partyrole,
			c.oppopartyrole			
		FROM lw_cases AS c INNER JOIN lw_contacts AS p1 ON c.party=p1.id INNER JOIN lw_contacts AS p2 ON c.oppoparty=p2.id INNER JOIN lw_courts ON c.courtid=lw_courts.courtid INNER JOIN lw_stages ON c.stage=lw_stages.stageid WHERE c.deleted!=1 ORDER BY lw_courts.courtname ASC";
	
	$result=DB_query($sql,$db);
	
	$StatementResultsnum_rows=DB_query($sql,$db);	

$i=1;
 
	$myrownum_rows=DB_num_rows($StatementResultsnum_rows);
	
	while($Contacts=DB_fetch_array($result))
    {
	
	$resultpartyrole=DB_query("SELECT role,tag FROM lw_partiesinvolved WHERE lw_partiesinvolved.roleid='" . $Contacts['partyrole'] . "'",$db);		
			$myrowpartyrole=DB_fetch_array($resultpartyrole);
			
	$resultoppopartyrole=DB_query("SELECT role,tag FROM lw_partiesinvolved WHERE lw_partiesinvolved.roleid='" . $Contacts['oppopartyrole'] . "'",$db);		
			$myrowoppopartyrole=DB_fetch_array($resultoppopartyrole);
			
	$resultdate=DB_query("SELECT prevcourtdate,currtrandate,nextcourtdate FROM lw_trans WHERE lw_trans.brief_file='" . $Contacts['brief_file'] . "' ORDER BY nextcourtdate DESC LIMIT 1",$db);	
		
			$myrowtrandate=DB_fetch_array($resultdate);		
			
	if($myrowtrandate['prevcourtdate']!="")
	{
	$myrowtrandate['prevcourtdate']=ConvertSQLDate($myrowtrandate['prevcourtdate']);
	}
	
	else
	
	{
	$myrowtrandate['prevcourtdate']=$myrowtrandate['prevcourtdate'];
	}


if($myrowtrandate['nextcourtdate']!="")
	{
	$myrowtrandate['nextcourtdate']=ConvertSQLDate($myrowtrandate['nextcourtdate']);
	}
	
	else
	
	{
	$myrowtrandate['nextcourtdate']=$myrowtrandate['nextcourtdate'];
	}
if($myrowtrandate['currtrandate']!="")
	{
	$myrowtrandate['currtrandate']=ConvertSQLDate($myrowtrandate['currtrandate']);
	}
	
	else
	
	{
	$myrowtrandate['currtrandate']=$myrowtrandate['currtrandate'];
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
	$party=$Contacts['oppoparty'] . ' , ' . $myrowoppopartyrole['role'];
	$oppoparty='*'.$Contacts['party'] . ' , ' . $myrowpartyrole['role'];
	}	
		
	$pdf->Row(array($i++,$myrowtrandate['currtrandate'],$Contacts['brief_file'],$Contacts['courtname'],$Contacts['courtcaseno'],$party,$oppoparty,$Contacts['stage'],$myrowtrandate['nextcourtdate']));
	}
	
	
	$pdf->AliasNbPages();
   	//$pdf = $pdf->Output();
	$len = strlen($pdf);
	
	if ($myrownum_rows>0){
   	
	$pdf = $pdf->Output();
	$len = strlen($pdf);
	
		header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: inline; filename=CasesList.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		$pdf->Output('CasesList.pdf','I');

		
	} else {
		
		$title = _('Print Cases List Error'); ?>
		<div style="text-align:center; font-weight:bold">There were no cases to print
		<?php echo '<br><a href="'. $rootpath.'/index.php?'.SID.'">'. _('Back to Home Page'). '</a></div>';
		
		exit;

	}	
?>
