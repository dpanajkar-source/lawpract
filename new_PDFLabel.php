<?php

$PageSecurity = 13;
include('includes/session.php');

require('mc_tablenew_cellfitlabel.php');

$PageNumber = 0;

$line_height=20;

$YPos=0;

$pdf = new FPDF_CellFit();
$pdf->AddPage();

$pdf->SetFillColor(255,249,177);

$pdf->SetFont('Helvetica','B',18);

	/* Now figure out the Contact data to report for the selections made */
$sql = "SELECT lw_cases.brief_file,
			lw_cases.party,
			lw_cases.oppoparty,
			lw_cases.courtcaseno,
			lw_cases.courtid,
			lw_cases.stage,
			lw_cases.opendt,			
			lw_cases.closedt
			FROM lw_cases";
			
$result=DB_query($sql,$db);

   $counter=0;

//include('includes/PDFLabelPageHeader.php');

	While ($Contacts = DB_fetch_array($result)){
					
	  $resultparty=DB_query("SELECT name, address, mobile, email FROM lw_contacts WHERE lw_contacts.id='" . $Contacts['party'] . "'",$db);	
				$myrowparty=DB_fetch_array($resultparty);
	  
	  $resultoppoparty=DB_query("SELECT name FROM lw_contacts WHERE lw_contacts.id='" . $Contacts['oppoparty'] . "'",$db);	
				$myrowoppoparty=DB_fetch_array($resultoppoparty);
        			
	$resultstage=DB_query("SELECT stage FROM lw_stages WHERE lw_stages.stageid='" . $Contacts['stage'] . "'",$db);
			$myrowstage=DB_fetch_array($resultstage);
	
    $resultcourt=DB_query("SELECT courtname FROM lw_courts WHERE lw_courts.courtid='" . $Contacts['courtname'] . "'",$db);		
			$myrowcourt=DB_fetch_array($resultcourt);
        
        $brief_file ='Brief_File No = ' . $Contacts[0];
        $caseno ='Case No = ' . $Contacts[3];
        
        $party ='Party = ' . $myrowparty[0];
       // $address ='Address = ' . $myrowparty[1];
        $mobile ='Mobile = ' . $myrowparty[2];
        $email ='Email = ' . $myrowparty[3];
        
        $oppoparty = 'Oppoparty = ' . $myrowoppoparty[0];
      
        
$pdf->SetFont('','B');
//$pdf->Write(10,'CellFitScale');
$pdf->SetFont('');
//$pdf->Write(10,' (horizontal scaling only if necessary)');
//$pdf->Ln();
    
        //$YPos -=$line_height;  
     
        
              if($counter<3)
              {				                       
                   
                $pdf->CellFitScale(150,10,$brief_file,1,1,'L');
                $pdf->CellFitScale(150,10,$caseno,1,1,'L',1);        
                $pdf->CellFitScale(150,10,$party,1,1,'L',1);
                $pdf->CellFitScale(150,10,$oppoparty,1,1,'L',1);  
                $pdf->CellFitScale(150,10,$mobile,1,1,'L',1);
               // $pdf->CellFitScale(150,10,$address,1,1,'L',1);
                $pdf->CellFitScale(150,10,$email,1,1,'L',1);
                  
                $pdf->Ln();
                  
                //$text=str_repeat('this is a word wrap test ',3);
//$nb=$pdf->WordWrap($text,120);
//$pdf->Write(15,"----------------------------------------------------------------------------------------------------------");
        
//$pdf->Write(5,$text);
                                  
                  
              } else
			  {
			  
			  $counter=0;
			  
			  $pdf->AddPage();
              
			  	$pdf->CellFitScale(150,10,$brief_file,1,1,'L');
                $pdf->CellFitScale(150,10,$caseno,1,1,'L',1);        
                $pdf->CellFitScale(150,10,$party,1,1,'L',1);
                $pdf->CellFitScale(150,10,$oppoparty,1,1,'L',1);  
                $pdf->CellFitScale(150,10,$mobile,1,1,'L',1);
               // $pdf->CellFitScale(150,10,$address,1,1,'L',1);
                $pdf->CellFitScale(150,10,$email,1,1,'L',1);
				                  
			  $PageNumber++;
			  $pdf->Ln();
			  }   
			  
			  $counter=$counter+1;        



    }
$pdf->AliasNbPages();
	$pdfcode = $pdf->output();
	$len = strlen($pdfcode);

        header('Content-type: application/pdf');
		header('Content-Length: ' . $len);
		header('Content-Disposition: attachment; filename=pdflabel.pdf');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');

		$pdf->Output('PDFLabel.pdf','I');


?>
