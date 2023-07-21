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
 
$sql = 'SELECT lw_trans.brief_file,
			lw_trans.party,
			lw_trans.oppoparty,
			lw_trans.currtrandate,
			lw_trans.prevcourtdate,
			lw_trans.nextcourtdate,
			lw_trans.courtname,
			lw_trans.courtcaseno,
			lw_trans.stage,
			lw_cases.judgename,
			lw_cases.partyrole,
			lw_cases.oppopartyrole
			FROM lw_trans LEFT JOIN lw_courts ON lw_trans.courtname=lw_courts.courtid LEFT JOIN lw_cases ON lw_trans.brief_file=lw_cases.brief_file WHERE lw_trans.courtcaseno="' . $_GET['Courtcasenum'] . '" ORDER BY lw_trans.currtrandate ASC';
			
			
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
	
	$pdf->SetXY( 10, 30 ); 
	$pdf->SetFont('','B','10'); 
	$pdf->SetFillColor(128,128,128); 
	$pdf->SetTextColor(255); 
	$pdf->SetDrawColor(92,92,92); 
	$pdf->SetLineWidth(.3); 
	
	$pdf->Cell(6,7,"ID",1,0,'C',true); 
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
	
	$pdf->Cell(96,7,"",1,0,'C',False); 
 
	$pdf->Cell(25,7,"Party",1,0,'C',true); 
	$pdf->Cell(25,7,"Opposite Party",1,0,'C',true);
	$pdf->Cell(47,7,"",1,0,'C',False); 


	$pdf->Ln(); 
	$fill = false;
	
	$myrownum_rows=DB_num_rows($StatementResultsnum_rows);
 
	while($Contacts=DB_fetch_array($StatementResults))
    {
	
	
	$resultparty=DB_query("SELECT name FROM lw_contacts WHERE lw_contacts.id='" . $Contacts['party'] . "'",$db);	
			$myrowparty=DB_fetch_array($resultparty);
	  
	$resultoppoparty=DB_query("SELECT name FROM lw_contacts WHERE lw_contacts.id='" . $Contacts['oppoparty'] . "'",$db);	
			$myrowoppoparty=DB_fetch_array($resultoppoparty);
			
	$resultstage=DB_query("SELECT stage FROM lw_stages WHERE lw_stages.stageid='" . $Contacts['stage'] . "'",$db);
			$myrowstage=DB_fetch_array($resultstage);
	
    $resultcourt=DB_query("SELECT courtname FROM lw_courts WHERE lw_courts.courtid='" . $Contacts['courtname'] . "'",$db);		
			$myrowcourt=DB_fetch_array($resultcourt);
	
	$resultpartyrole=DB_query("SELECT role,tag FROM lw_partiesinvolved WHERE lw_partiesinvolved.roleid='" . $Contacts['partyrole'] . "'",$db);		
			$myrowpartyrole=DB_fetch_array($resultpartyrole);
			
	$resultoppopartyrole=DB_query("SELECT role,tag FROM lw_partiesinvolved WHERE lw_partiesinvolved.roleid='" . $Contacts['oppopartyrole'] . "'",$db);		
			$myrowoppopartyrole=DB_fetch_array($resultoppopartyrole);
	
	if($Contacts['prevcourtdate']!="")
	{
	$Contacts['prevcourtdate']=ConvertSQLDate($Contacts['prevcourtdate']);
	}
	
	else
	
	{
	$Contacts['prevcourtdate']=$Contacts['prevcourtdate'];
	}


if($Contacts['nextcourtdate']!="")
	{
	$Contacts['nextcourtdate']=ConvertSQLDate($Contacts['nextcourtdate']);
	}
	
	else
	
	{
	$Contacts['nextcourtdate']=$Contacts['nextcourtdate'];
	}
if($Contacts['currtrandate']!="")
	{
	$Contacts['currtrandate']=ConvertSQLDate($Contacts['currtrandate']);
	}
	
	else
	
	{
	$Contacts['currtrandate']=$Contacts['currtrandate'];
	}
	
		//role based display below
	
if($myrowpartyrole['tag']=='L')

	{
	$party='*'.$myrowparty['name'] . ' , ' . $myrowpartyrole['role'];	
	$oppoparty=$myrowoppoparty['name'] . ' , ' . $myrowoppopartyrole['role'];	
	}
	
	else if($myrowpartyrole['tag']=='R')
	
	{
	// this is for party role 2,4,6,9,13
	$party=$myrowoppoparty['name'] . ' , ' . $myrowoppopartyrole['role'];
	$oppoparty='*'.$myrowparty['name'] . ' , ' . $myrowpartyrole['role'];
	}
	
	
	$pdf->Row(array($i++,$Contacts['prevcourtdate'],$Contacts['brief_file'],$myrowcourt['courtname'] . ' , ' . $Contacts['judgename'],$Contacts['courtcaseno'],$party,$oppoparty,$myrowstage['stage'],$Contacts['nextcourtdate']));
	}	
	
	$pdf->AliasNbPages();
    
	//$pdf = $pdf->Output();
	$len = strlen($pdf);
	
	if ($myrownum_rows>0){
   	
	$pdf = $pdf->Output();
	$len = strlen($pdf);
	
		header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: inline; filename=CaseshistoryList.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		$pdf->Output('CaseshistoryList.pdf','I');

		
	} else {
		
		$title = _('Print Cases History List Error'); ?>
		<div style="text-align:center; font-weight:bold">There were no cases history to print out for the selections specified
		<?php echo '<br><a href="'. $rootpath.'/index.php?'.SID.'">'. _('Back to Home Page'). '</a></div>';
		
		exit;

	}	
?>
