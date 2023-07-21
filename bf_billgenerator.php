<?php

$PageSecurity =3;
      
include('config.php'); 

function GetPeriodnew ($TransDate, &$con) {

	/* Convert the transaction date into a unix time stamp.*/
	
	$sqlprohibit = 'SELECT confvalue from config WHERE confname="ProhibitPostingsBefore"';
	$resultprohibit = mysqli_query($con,$sqlprohibit);
	$myrowprohibit=mysqli_fetch_row($resultprohibit);
	
	$sqldefaultdate = 'SELECT confvalue from config WHERE confname="DefaultDateFormat"';
	$resultdefaultdate = mysqli_query($con,$sqldefaultdate);
	$myrowdefaultdate=mysqli_fetch_row($resultdefaultdate);
	
	$DefaultDateFormat=$myrowdefaultdate[0];
	$ProhibitPostingsBefore=$myrowprohibit[0];
	

	if (strpos($TransDate,'/')) {
		$Date_Array = explode('/',$TransDate);
	} elseif (strpos ($TransDate,'-')) {
		$Date_Array = explode('-',$TransDate);
	} elseif (strpos ($TransDate,'.')) {
		$Date_Array = explode('.',$TransDate);
	}
	if (($DefaultDateFormat=='d/m/Y') or ($DefaultDateFormat=='d.m.Y')){
		$TransDate = mktime(0,0,0,$Date_Array[1],$Date_Array[0],$Date_Array[2]);
	} elseif ($DefaultDateFormat=='m/d/Y'){
		$TransDate = mktime(0,0,0,$Date_Array[0],$Date_Array[1],$Date_Array[2]);
	} elseif ($DefaultDateFormat=='Y/m/d'){
		$TransDate = mktime(0,0,0,$Date_Array[1],$Date_Array[2],$Date_Array[0]);
	}

	if (strlen($ProhibitPostingsBefore)>=8){ //then the ProhibitPostingsBefore configuration is set
		$Date_array = explode('-', $ProhibitPostingsBefore);
	
		$ProhibitPostingsBefore = mktime(0,0,0,$Date_array[1],$Date_array[2],$Date_array[0]);
		
		/* If transaction date is in a closed period use the month end of that period */
		if ($TransDate < $ProhibitPostingsBefore) {
			$TransDate = $ProhibitPostingsBefore;
		}
	}
	/* Find the unix timestamp of the last period end date in periods table */
	$sql = 'SELECT MAX(lastdate_in_period), MAX(periodno) from periods';
	$result = mysqli_query($con,$sql);
	$myrow=mysqli_fetch_row($result);
	if (is_null($myrow[0])){
	$InsertFirstPeriodResult = mysqli_query($con,"INSERT INTO periods VALUES (1,'" . date('Y-m-d',mktime(0,0,0,date('m')+1,0,date('Y'))) . "')");
		//$InsertFirstPeriodResult = DB_query("INSERT INTO periods VALUES (1,'" . Date('Y-m-d',mktime(0,0,0,Date('m')+2,0,Date('Y'))) . "')",$db,'Could not insert second period');
		$LastPeriod=1;
		$LastPeriodEnd = mktime(0,0,0,date('m')+2,0,date('Y'));
	} else {
		$Date_array = explode('-', $myrow[0]);
		$LastPeriodEnd = mktime(0,0,0,$Date_array[1]+2,0,(int)$Date_array[0]);
		$LastPeriod = $myrow[1];
	}
	/* Find the unix timestamp of the first period end date in periods table */
	$sql = 'SELECT MIN(lastdate_in_period), MIN(periodno) from periods';
	$result = mysqli_query($con,$sql);
	$myrow=mysqli_fetch_row($result);
	$Date_array = explode('-', $myrow[0]);
	$FirstPeriodEnd = mktime(0,0,0,$Date_array[1],0,(int)$Date_array[0]);
	$FirstPeriod = $myrow[1];
	
	/* If the period number doesn't exist */
	if (!PeriodExistsnew($TransDate, $con)) {
		/* if the transaction is after the last period */
		echo ($TransDate > $LastPeriodEnd);
		if ($TransDate > $LastPeriodEnd) {
			$PeriodEnd = mktime(0,0,0,date('m', $TransDate)+1, 0, date('Y', $TransDate));
			$Period = $LastPeriod + 1;
			while ($PeriodEnd >= $LastPeriodEnd) {
				CreatePeriodnew($Period, $LastPeriodEnd, $con);
				$Period++;
				if (date('m', $LastPeriodEnd)<=13) {
					$LastPeriodEnd = mktime(0,0,0,date('m', $LastPeriodEnd)+2, 0, date('Y', $LastPeriodEnd));
				} else {
					$LastPeriodEnd = mktime(0,0,0,2, 0, date('Y', $LastPeriodEnd)+1);
				}
			}
			$PeriodEnd = mktime(0,0,0,date('m', $LastPeriodEnd)+1, 0, date('Y', $LastPeriodEnd));
			CreatePeriodnew($Period, $PeriodEnd, $con);
		} else {
		/* The transaction is before the first period */
			$PeriodEnd = mktime(0,0,0,date('m', $TransDate), 0, date('Y', $TransDate));
			$Period = $FirstPeriod - 1;
			while ($FirstPeriodEnd > $PeriodEnd) {
				CreatePeriodnew($Period, $FirstPeriodEnd, $con);
				$Period--;
				if (date('m', $FirstPeriodEnd)>0) {
					$FirstPeriodEnd = mktime(0,0,0,date('m', $FirstPeriodEnd), 0, date('Y', $FirstPeriodEnd));
				} else {
					$FirstPeriodEnd = mktime(0,0,0,13, 0, date('Y', $FirstPeriodEnd));
				}
			}
		}
	} else if (!PeriodExistsnew(mktime(0,0,0,date('m',$TransDate)+1,date('d',$TransDate),date('Y',$TransDate)), $con)) {
		/* Make sure the following months period exists */
		$sql = 'SELECT MAX(lastdate_in_period), MAX(periodno) from periods';
		$result = mysqli_query($con,$sql);
		$myrow=mysqli_fetch_row($result);
		$Date_array = explode('-', $myrow[0]);
		$LastPeriodEnd = mktime(0,0,0,$Date_array[1]+2,0,(int)$Date_array[0]);
		$LastPeriod = $myrow[1];
		CreatePeriodnew($LastPeriod+1, $LastPeriodEnd, $con);
	}

	/* Now return the period number of the transaction */

	$MonthAfterTransDate = mktime(0,0,0,date('m',$TransDate)+1,date('d',$TransDate),date('Y',$TransDate));
	$GetPrdSQL = "SELECT periodno FROM periods WHERE lastdate_in_period < '" .
	date('Y/m/d', $MonthAfterTransDate) . "' AND lastdate_in_period >= '" . date('Y/m/d', $TransDate) . "'";

	$ErrMsg = 'An error occurred in retrieving the period number';
	$GetPrdResult = mysqli_query($con,$GetPrdSQL);
	$myrow = mysqli_fetch_row($GetPrdResult);

	return $myrow[0];
} //end of get periods function

//new functions createperiod and periodexists functions from date functions customized and inserted in this form
function CreatePeriodnew($PeriodNo, $PeriodEnd, &$con) {
				$GetPrdSQL = 'INSERT INTO periods (periodno, lastdate_in_period) VALUES ('
					. $PeriodNo . ", '" . date('Y/m/d', $PeriodEnd) . "')";
				$ErrMsg = 'An error occurred in adding a new period number';
				$GetPrdResult = mysqli_query($con,$GetPrdSQL);

				$sql = 'INSERT INTO chartdetails (accountcode, period)
						SELECT chartmaster.accountcode, periods.periodno
							FROM chartmaster
								CROSS  JOIN periods
						WHERE ( chartmaster.accountcode, periods.periodno ) NOT
							IN ( SELECT chartdetails.accountcode, chartdetails.period FROM chartdetails )';
/*dont trap errors - chart details records created only as required - duplicate messages ignored */
				$InsNewChartDetails = mysqli_query($con,$sql);
}

function PeriodExistsnew($TransDate, &$con) {

	/* Find the date a month on */
	$MonthAfterTransDate = mktime(0,0,0,date('m',$TransDate)+1,date('d',$TransDate),date('Y',$TransDate));

	$GetPrdSQL = "SELECT periodno FROM periods WHERE lastdate_in_period < '" . date('Y/m/d', $MonthAfterTransDate) . "' AND lastdate_in_period >= '" . date('Y/m/d', $TransDate) . "'";

	$GetPrdResult = mysqli_query($con,$GetPrdSQL);

	if (mysqli_num_rows($GetPrdResult)==0) {
		return false;
	} else {
		return true;
	}

}
 

$con=mysqli_connect("localhost","root",$dbpassword);
		mysqli_select_db($con,"lawpract");     

$bank_code=trim($_POST['bank_code']);

$bank_id=trim($_POST['bank_id']);

$bank_name=trim($_POST['bank_name']);

//select bill no

	$sqlbillno='SELECT billno from bf_bills ORDER BY id DESC LIMIT 1';
			
			$resultbillno=mysqli_query($con,$sqlbillno); 
			
			$myrowbillno=mysqli_fetch_array($resultbillno);
			
			if(empty($myrowbillno))
			{
			$myrowbillno['billno']=1;
			}else
			{
			$myrowbillno['billno']+=2;
			}
		
		//now get total loan amount from bf_cases for the selected bill
		$sqltotalamount="SELECT SUM(fees) AS totalfees from bf_cases WHERE billno IS NULL AND bank_id='" .trim($bank_id). "'";		
					
			$resulttotalamount=mysqli_query($con,$sqltotalamount); 
			
			$myrowtotalamount=mysqli_fetch_array($resulttotalamount);
		
$stmt = "UPDATE bf_cases SET billno='" . trim($myrowbillno['billno']) . "',billdate='" . trim(date("Y-m-d")) . "' WHERE billno IS NULL AND bank_id='" .trim($bank_id). "'";	

$result=mysqli_query($con,$stmt);

 $query=$stmt;		
		
	$SQLArray = explode(' ', $stmt);
	
	include('cust_audittrail.php');		
	//for accrual based accounting below is the code
				
		
		$DateString = date('Y-m-d');
	
	 //$date_info = date_parse_from_format('d/m/Y', $DateString);
     // $value = "{$date_info['year']}-{$date_info['month']}-{$date_info['day']}";
	 
	
	$PeriodNo = GetPeriodnew(date('d/m/Y'),$con);	
	
	$TransType=10;	
		
	$SQL = 'UPDATE systypes SET typeno = ' . ($myrowbillno['billno']) . ' WHERE typeid = ' . $TransType;
	
	$UpdTransNoResult=mysqli_query($con,$SQL);	
         			
				 		
		//fetch Client GLcode if already there
		
		$sqlglcode= 'SELECT accountcode,accountname FROM chartmaster where accountname="' . trim($bank_name) . ' AR Debtor-Ac" ORDER BY accountcode DESC LIMIT 1';
		
		$result=mysqli_query($con,$sqlglcode);	
			
		$myrowglcode=mysqli_fetch_array($result);
		
		if($myrowglcode>0)
		{
		$glcode=$myrowglcode[0];
		
		}else
		{
$sqlglcode= "SELECT accountcode,accountname FROM chartmaster where accountname LIKE '% AR Debtor-Ac' ORDER BY accountcode DESC LIMIT 1";

		$result=mysqli_query($con,$sqlglcode);	
		
		$myrowglcode=mysqli_fetch_array($result);
		
		$myrowglcode['accountcode']=$myrowglcode['accountcode']+1;//Party GL Code
		 
		  $glcode= $myrowglcode['accountcode'];
		  
		  //Below is the code to create GL account code for the Party automatically for the first time
				
			$sql = 'INSERT INTO chartmaster (accountcode,
						accountname,
						group_)
					VALUES (' . $glcode . ",
						'".trim($bank_name). ' AR Debtor-Ac'."',
						'Accounts Receivable')";
						
				$result = mysqli_query($con,$sql);	
					
			//Add the new chart details records for existing periods first

		$sql = 'INSERT INTO chartdetails (accountcode, period)
				SELECT chartmaster.accountcode, periods.periodno
					FROM chartmaster
						CROSS JOIN periods
				WHERE ( chartmaster.accountcode, periods.periodno ) NOT
					IN ( SELECT chartdetails.accountcode, chartdetails.period FROM chartdetails )';

		$result = mysqli_query($con,$sql);

		}		
			
$stmt= "INSERT INTO bf_bills (
                            billno,
							bank_id,
							billtotal,
							type,
							billdate,
							glcode	
					)
			VALUES ('" . trim($myrowbillno['billno']) . "',
					'" . trim($bank_id) . "',
					'" . trim($myrowtotalamount['totalfees']) . "',
					10,
					'" . trim(date("Y-m-d")) . "',
					'" . trim($glcode) . "'										
				)";
		
	$result=mysqli_query($con,$stmt);
		
		 $query=$stmt;		
		
	$SQLArray = explode(' ', $stmt);
	
	include('cust_audittrail.php');
				
			//GLentry is debit Cash GL account with total fees for once. check if condition for accrual based accounting
//debit client ar ac
$SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount,
						tag) ';
		$SQL= $SQL . 'VALUES (10,
					'.$myrowbillno['billno'].",
					'".$DateString."',
					'".$PeriodNo."',
					'" .$glcode."',
					'".$_POST['Narration']."',
					'".trim($myrowtotalamount['totalfees'])."',
					0)";		
		
		$result = mysqli_query($con,$SQL);

//Second GLentry is to credit professional fees GL account with Total fees

$SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount,
						tag) ';
		$SQL= $SQL . 'VALUES (10,
					'.$myrowbillno['billno'].",
					'".$DateString."',
					".$PeriodNo.",
					'400011',
					'".$_POST['Narration']."',
					" .  '-' . $myrowtotalamount['totalfees'] . ",
					0)";
					
		$result = mysqli_query($con,$SQL);	
		
		//FINE TILL NOW
		
		
		//create folder for each bank selected in bf_bankfinance.php
		chmod($_SERVER['DOCUMENT_ROOT'].'/lawpract/bills/',0750);			
						
			$dirname=$bank_code;
  
			if(!file_exists('bills/'.$dirname))
			{
						
			mkdir('bills/'.$dirname,0777);	
					 
			}
			//Report Generation	
			 
   require('mc_tablenew_Bankfinancebill.php');

	$pdf=new PDF_MC_Table();
	$pdf->AddPage();
	$pdf->SetFont('Helvetica','B',9);
	//Table with 5 columns
	
	 $result=mysqli_query($con,"SELECT bf_cases.billno,
						bf_cases.applicationno,
						lw_contacts.name,
						bf_banks.bank_name,
						bf_bank_branch.branch_area,
						bf_cases.billdate,
						bf_cases.loanamount,
						bf_cases.fees					
			FROM bf_cases LEFT JOIN bf_bank_branch ON bf_cases.branch_id=bf_bank_branch.id INNER JOIN bf_banks ON bf_cases.bank_id=bf_banks.id INNER JOIN lw_contacts ON bf_cases.custid=lw_contacts.id WHERE bf_cases.bank_id='" . $bank_id ."'");	
			
			$myrowbankname=mysqli_fetch_array($result);						
	
	//calculate total fees
		$resultfees=mysqli_query($con,"SELECT sum(bf_cases.fees) AS totalfees, sum(bf_cases.loanamount) AS totalloan					
			FROM bf_cases WHERE bf_cases.billno='" . $myrowbillno['billno'] ."'");
			$totalfees = mysqli_fetch_array($resultfees);
		
$sqlcompany = 'SELECT * FROM companies WHERE coycode=1';
	$StatementResultcompany=mysqli_query($con,$sqlcompany);
$Company = mysqli_fetch_array($StatementResultcompany);	
			
$i=1;
$pdf->SetXY( 10,10 ); 
		 
$pdf->SetDrawColor(255,255,255);
$pdf->SetFillColor(0,0,0);
$pdf->SetFont('Helvetica','B',13);
$pdf->SetWidths(array(20,10,125,30));

$pdf->Row(array($pdf->Image('adv.png',10,12,12,0,'','', false, $maskImg),'',$pdf->Cell(0,7,$Company['advocatename'],0,0,'C',false)),4,'');

//$pdf->SetFont('Helvetica','',9);
$pdf->Row(array('','',$pdf->Cell(0,7,$Company['degree'],0,0,'C',false)),'');
$pdf->SetFont('Helvetica','',9);
$pdf->SetWidths(array(195));
	
$pdf->Row(array('Address : ' . $Company['address']));
$pdf->SetXY( 10,32 );
$pdf->Row(array('','',$pdf->Cell(0,7,'REG. No.' . $Company['barnumber'],0,1,'C',false)),'');
$pdf->SetDrawColor(0,0,0);
$pdf->Line(10,38,200,38);

$pdf->SetDrawColor(248,248,255);
$pdf->SetWidths(array(10,125,30,30));
$pdf->SetFont('Helvetica','',10);
$pdf->SetXY( 10,40 );
$pdf->Row(array('To : ',$myrowbankname['bank_name'],'Bill No. ',$myrowbillno['billno']));
$pdf->Row(array('',$myrowbankname['address'],'Date:',date('d-m-Y')));
	
	$pdf->SetWidths(array(10,30,30,50,40,30));	
	$pdf->SetXY( 10, 50 ); 
	$pdf->SetFont('','B','10'); 
	$pdf->SetFillColor(128,128,128); 
	$pdf->SetTextColor(255); 
	$pdf->SetDrawColor(169,169,169); 
	$pdf->SetLineWidth(.3); 
	
	$pdf->Cell(10,7,"S.No.",1,0,'C',true); 
	$pdf->Cell(30,7,"Application No.",1,0,'C',true); 
	$pdf->Cell(30,7,"Branch",1,0,'C',true);
	$pdf->Cell(50,7,"Name of Customer",1,0,'C',true); 
	$pdf->Cell(40,7,"Loan Amount",1,0,'C',true); 
	$pdf->Cell(30,7,"Fees Charged",1,0,'C',true); 
	
$pdf->SetFont('','','9');
	$pdf->Ln(); 
	$fill = false;
	
$i=1;	
	
	while($myrow=mysqli_fetch_array($result))
    {
		
	$pdf->Row(array($i++,$myrow['applicationno'],$myrow['branch_area'],$myrow['name'],$myrow['loanamount'].'/-',$myrow['fees'].'/-'));		
	
	}
	
	$pdf->Ln(); 
	
	$pdf->SetFont('','B','9');	
	$pdf->SetDrawColor(255,255,255); 
	$pdf->SetWidths(array(30,30,30,30,40,30));
	$pdf->Row(array('','','','TOTAL -',$totalfees['totalloan'].'/-',$totalfees['totalfees'].'/-'));
    $pdf->SetFont('','BI','9');
	//$pdf->Cell(0.1,7,'In Words '. number_word($totalfees['totalfees'],0,0,'L',false));	
	
	$pdf->AliasNbPages();
	
	//GOOD TILL NOW	
	    		
$pdf->Output('bills/'.$dirname.'/' .'BILL-'.$myrowbillno['billno'].'-'.date("m-Y").'.pdf','F');		
		
			//now create an entry lw_diaryprinted
		$sql = "INSERT INTO bf_billprinted(
			month,
			year,
			billno,
			bank_id
			)
			VALUES ('".trim(date("m"))."',
			'".trim(date("Y"))."',
			'".trim($myrowbillno['billno'])."',
			'".trim($bank_id)."'
			)";
		
$result = mysqli_query($con,$sql);	
	 $query=$sql;		
		
	$SQLArray = explode(' ', $sql);
	
	include('cust_audittrail.php');
?>