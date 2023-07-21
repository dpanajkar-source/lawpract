<?php
    $PageSecurity = 2;
     include("includes/session.php");
	
    require('mc_tablenew_partydetails.php');
	
$pdf=new PDF_MC_Table();
$pdf->AddPage('L','A4');

$pdf->SetFont('Helvetica','B',9);
//Table with 5 columns
$pdf->SetWidths(array(10,20,35,20,40,40,40,50,20));


  $sql = "SELECT c.brief_file,
			p1.name AS party,
			p2.name AS oppoparty,
			p1.mobile,
			c.courtcaseno,
			lw_courts.courtname,
			lw_stages.stage
		FROM lw_cases AS c INNER JOIN lw_contacts AS p1 ON c.party=p1.id INNER JOIN lw_contacts AS p2 ON c.oppoparty=p2.id INNER JOIN lw_courts ON c.courtid=lw_courts.courtid INNER JOIN lw_stages ON c.stage=lw_stages.stageid WHERE c.deleted!=1 AND c.party = '" . trim($_GET['partyid']) . "' OR c.oppoparty = '" . trim($_GET['partyid']) . "'";
					
 $StatementResults=DB_query($sql,$db);
	
$count=1;

	$pdf->SetXY( 10, 20 ); 
	
	$pdf->SetFont('','B','18'); 
	$pdf->Cell(40,10,'Party Details',15); 
	$pdf->Ln(); 

	while($Contacts=DB_fetch_array($StatementResults))
    {		
	
	$pdf->SetFont('','B','10'); 
	$pdf->SetFillColor(128,128,128); 
	$pdf->SetTextColor(255); 
	$pdf->SetDrawColor(92,92,92); 
	$pdf->SetLineWidth(.3); 
	
	$pdf->Cell(10,7,"ID",1,0,'C',true); 
	$pdf->Cell(20,7,"Prev Date",1,0,'C',true); 
	$pdf->Cell(35,7,"Brief File",1,0,'C',true); 
	$pdf->Cell(20,7,"Court",1,0,'C',true); 
	$pdf->Cell(40,7,"Case No",1,0,'C',true); 
	$pdf->Cell(80,7,"Name Of Parties",1,0,'C',true); 
	$pdf->Cell(50,7,"Stage",1,0,'C',true); 
	$pdf->Cell(20,7,"Next Date",1,0,'C',true);
	
	$pdf->Ln(); 
	
	$pdf->SetFillColor(224,235,255); 
	$pdf->SetTextColor(0); 
	$pdf->SetFont(''); 
	
	$pdf->Cell(125,7,"",1,0,'C',False); 
 
	$pdf->Cell(40,7,"Party",1,0,'C',true); 
	$pdf->Cell(40,7,"Opposite Party",1,0,'C',true);
	$pdf->Cell(70,7,"",1,0,'C',False); 


	$pdf->Ln(); 
	$fill = false;
			
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
	
		
	$pdf->Row(array($count++,$myrowtransbrieflastcourtdate['prevcourtdate'],$Contacts['brief_file'],$Contacts['courtname'],$Contacts['courtcaseno'],$Contacts['party'],$Contacts['oppoparty'],$Contacts['stage'],$myrowtransbrieflastcourtdate['nextcourtdate']));
	
	$pdf->Ln(); 
	
	//below is to display other parties
	$sqlotherclients = "SELECT brief_file, name FROM lw_otherclients WHERE brief_file = '" . trim($Contacts['brief_file']) . "' AND tag='C'";
	$StatementResultsotherparties=DB_query($sqlotherclients,$db);
	
	$id=1;
		
	//please create a normal table
	while($Contactsotherparties=DB_fetch_array($StatementResultsotherparties))
    {
	
	if($id==1)
	{	
	//$pdf->SetWidths(array(10,100));
	$pdf->SetFillColor(224,235,255); 
	$pdf->SetTextColor(0); 
	$pdf->SetFont(''); 
	$pdf->Cell(100,7,"Other Parties Names",1,0,'C',true);
	$pdf->Ln(); 
	$fill = false;
	}
	
	$pdf->Rowhorizontal(array($id++,$Contactsotherparties['name']));
	if($id==5)
	$pdf->Ln(); 
	
	}
	
	$sqlotherclients = "SELECT brief_file, name FROM lw_otherclients WHERE brief_file = '" . trim($Contacts['brief_file']) . "' AND tag='O'";
	$StatementResultsotheroppoparties=DB_query($sqlotherclients,$db);
	
	$pdf->Ln(); 
	
	//below is to display other oppo parties
	
	$idoppo=1;
	
	while($Contactsotheroppoparties=DB_fetch_array($StatementResultsotheroppoparties))
    {
	$pdf->Ln();
	
	if($idoppo==1)
	{
	$pdf->SetFillColor(224,235,255); 
	$pdf->SetTextColor(0); 
	$pdf->SetFont(''); 
	$pdf->Cell(100,7,"Other Opposite Parties Names",1,0,'C',true);
	$pdf->Ln(); 
	$fill = false;
	}
		
	$pdf->Rowhorizontal(array($idoppo++,$Contactsotheroppoparties['name']));
	
	//if($idoppo==3)
	$pdf->Ln(); 
	
	}
	$pdf->Ln();
		
	}//end of while loop
	
$pdf->AliasNbpages();

    $pdfcode = $pdf->output();
	$len = strlen($pdfcode);

      if ($len<=20){
		$title = _('Print Party details Error');
	
		echo '<p>';
		prnMsg( _('There were no details to print out for the selections specified') );
		echo '<br><a href="'. $rootpath.' /index.php?' . SID . '">'. _('Back to the menu'). '</a>';
		
		exit;
	} else {
		header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: inline; filename=Partydetails.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		$pdf->Output('Partydetails.pdf','I');
		

	}
?>
