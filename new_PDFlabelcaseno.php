<?php
    $PageSecurity = 2;
     include("includes/session.php");
	
 	
  require('mc_labelcaseno.php');
$pdf=new PDF_MC_Table();
$pdf->AddPage('','Legal');


//Table with 5 columns
$pdf->SetWidths(array(150,45));

    $DateString = Date($_SESSION['DefaultDateFormat']);
	
	$date = new DateTime(FormatDateForSQL($DateString));
                   // $date->sub(new DateInterval('P1D'));                         
         	
	/* Now figure out the Transactions data to report for the selections made */
	$sql = "SELECT c.brief_file,
			p1.name AS party,
			p2.name AS oppoparty,
			p1.mobile,
			p1.address,
			c.courtcaseno,
			c.opendt,
			r1.role AS partyrole,
			r2.role AS oppopartyrole,
			c.policestation,
			lw_courts.courtname,
			lw_stages.stage
	FROM lw_cases AS c INNER JOIN lw_contacts AS p1 ON c.party=p1.id 
	INNER JOIN lw_contacts AS p2 ON c.oppoparty=p2.id 
	LEFT JOIN lw_courts ON c.courtid=lw_courts.courtid
	LEFT JOIN lw_partiesinvolved AS r1 ON c.partyrole=r1.roleid
	LEFT JOIN lw_partiesinvolved  AS r2 ON c.oppopartyrole=r2.roleid
	 LEFT JOIN lw_stages ON c.stage=lw_stages.stageid
	 WHERE c.courtcaseno = '" . trim($_GET['labelcaseno']) . "'";
			
	$StatementResults=DB_query($sql,$db);	
		
$sqlcompany = 'SELECT * FROM companies WHERE coycode=1';
	$StatementResultcompany=DB_query($sqlcompany,$db);
$Company = DB_fetch_array($StatementResultcompany,$db);		
			
$i=1;
$DateString = Date($_SESSION['DefaultDateFormat']);
	
	$date = new DateTime(FormatDateForSQL($DateString));
		
//$pdf->SetXY( 25, 35 );
	//$pdf->SetFillColor(128,128,128); 
	$pdf->SetTextColor(255); 
	$pdf->SetDrawColor(92,92,92); 
	$pdf->SetLineWidth(.3); 

$fill = false; 
	
	$Contacts=DB_fetch_array($StatementResults);
	
	if($Contacts['opendt']!="")
	{
	$Contacts['opendt']=ConvertSQLDate($Contacts['opendt']);
	}
	
	else
	
	{
	$Contacts['opendt']=$Contacts['opendt'];
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

$pdf->SetDrawColor(255,255,255);
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Helvetica','B',18);
$pdf->SetWidths(array(100,95));

	$pdf->Row(array('Brief File No. : ' . $Contacts['brief_file'],'Case No :' . $Contacts['courtcaseno']));
	
	$pdf->Row(array('Court : ' . $Contacts['courtname']));
	

	$pdf->Row(array('Registration Date : ' . $Contacts['opendt']));
	$pdf->Row(array('CNR No. : '));
	
	$pdf->SetXY( 10, 130 );
		$pdf->SetFont('','B','24');
		$pdf->SetWidths(array(120,75));
	
	$pdf->Row(array($Contacts['party'],'Role :' . $Contacts['partyrole']));
	$pdf->SetXY( 10, 160 );
	$pdf->Cell(0,7,'VERSUS',0,0,'C',false);
	
	$pdf->SetXY( 10, 190 );
	$pdf->Row(array($Contacts['oppoparty'], 'Role :' . $Contacts['oppopartyrole']));
		
		
$pdf->SetXY( 10, 250 );
	$pdf->SetFont('','B','18'); 
	$pdf->SetWidths(array(150,45));
	
$pdf->Row(array($Company['advocatename']));
$pdf->SetFont('','B','10'); 
$pdf->Row(array($Company['degree']));
	$pdf->SetWidths(array(195));
	
	$pdf->Row(array('Address : ' . $Company['address']));
	$pdf->SetXY( 10, 285 );
	$pdf->Row(array('Telephone : ' . $Company['telephone']));
	$pdf->Row(array('Mobile : ' . $Company['mobile']));
	$pdf->Row(array('Email : ' . $Company['email']));	
	
	
	
	
	$pdf->Ln(); 
	
	
$pdf->AliasNbPages();
   //$pdf = $pdf->Output();
	$len = strlen($pdf);
   	
	$pdf = $pdf->Output();
	$len = strlen($pdf);
	
		header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: inline; filename=Label.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		$pdf->Output('Label.pdf','I');	
	
?>
