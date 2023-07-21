<?php
include('server_con.php');   
		
function GetNextTransNonew ($TransType, &$con){

	mysqli_query("LOCK TABLES systypes WRITE",$con);

	$SQL = "SELECT typeno FROM systypes WHERE typeid = " . $TransType;

	$GetTransNoResult = mysqli_query($SQL,$con);

	$myrow = mysqli_fetch_row($GetTransNoResult);

	$SQL = 'UPDATE systypes SET typeno = ' . ($myrow[0] + 1) . ' WHERE typeid = ' . $TransType;

	$UpdTransNoResult = mysqli_query($SQL,$con);

	mysqli_query("UNLOCK TABLES",$con);

	return $myrow[0] + 1;
}



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
		//$InsertFirstPeriodResult = DB_query("INSERT INTO periods VALUES (1,'" . Date('Y-m-d',mktime(0,0,0,Date('m')+2,0,Date('Y'))) . "')",$db,_('Could not insert second period'));
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

	$ErrMsg = _('An error occurred in retrieving the period number');
	$GetPrdResult = mysqli_query($con,$GetPrdSQL);
	$myrow = mysqli_fetch_row($GetPrdResult);

	return $myrow[0];
} //end of get periods function

//new functions createperiod and periodexists functions from date functions customized and inserted in this form
function CreatePeriodnew($PeriodNo, $PeriodEnd, &$con) {
				$GetPrdSQL = 'INSERT INTO periods (periodno, lastdate_in_period) VALUES ('
					. $PeriodNo . ", '" . date('Y/m/d', $PeriodEnd) . "')";
				$ErrMsg = _('An error occurred in adding a new period number');
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
    
$fileno=trim($_POST['fileno']);

$property=trim($_POST['property']);

$propertydetails=trim($_POST['propertydetails']);

$status=trim($_POST['status']);
$agentcharges=trim($_POST['agentcharges']);
$agent=trim($_POST['agent']);
$searchfees=trim($_POST['searchfees']);
$feescharged=trim($_POST['feescharged']);
$customer=trim($_POST['customer']);
	
$inward_date=trim($_POST['inward_date']);	
$outward_date=trim($_POST['outward_date']);	
$remark=trim($_POST['remark']);		   
	   
			
		
 if ($inward_date === "") 
  	 $inward_date = "NULL";
   else {
      $date_info = date_parse_from_format('d/m/Y', $inward_date);
      $inward_date = "{$date_info['year']}-{$date_info['month']}-{$date_info['day']}";
	  $inward_date="'\ " . $inward_date . "\" . '";
   }   
 
   
   	$result=mysqli_query($con,"SELECT id FROM lw_contacts where name='" . trim($customer) ."'");	
	$myrowclientid=mysqli_fetch_array($result);	
	
	if(empty($myrowclientid[0]))
	{   
	  	//first insert client in lw_contacts table
	$stmtcustomer= "INSERT INTO lw_contacts (name
					)
			VALUES ('" . strtoupper(trim($customer)) . "'
				)";
		
		$resultcustomer=mysqli_query($con,$stmtcustomer);
		
	$result=mysqli_query($con,"SELECT id FROM lw_contacts where name='" . trim($customer) ."'");	
	$myrowclientid=mysqli_fetch_array($result);	
	}
	
	// Fetch agent from lw_contacts
	
	$result=mysqli_query($con,"SELECT id FROM lw_contacts where name='" . trim($agent) ."'");	
	$myrowagentid=mysqli_fetch_array($result);	
	
	if(empty($myrowagentid[0]))
	{   
	  	//first insert agent in lw_contacts table
	$stmtagent="INSERT INTO lw_contacts (name
					)
			VALUES ('" . strtoupper(trim($agent)) . "'
				)";
		
		$resultagent=mysqli_query($con,$stmtagent);
		
	$result=mysqli_query($con,"SELECT id FROM lw_contacts where name='" . trim($agent) ."'");	
	$myrowagentid=mysqli_fetch_array($result);	
	}
	   	
		$stmt= "INSERT INTO lw_searchtitle (fileno,
					property,
					propertydetails,
					custid,
					status,
					agent,
					agentcharges,
					searchfees,
					feescharged,
					inward_date,
					remark
					)
			VALUES ('" . trim($fileno) . "',
				'" . trim($property) . "',
				'" . trim($propertydetails) . "',
				'" . $myrowclientid[0] . "',
				'" . trim($status) . "',
				'" . $myrowagentid[0] . "',				
				'" . trim($agentcharges) . "',
				'" . trim($searchfees) . "',
				'" . trim($feescharged) . "',
				$inward_date,
				'" . trim($remark) . "'
				)";
		
	$result=mysqli_query($con,$stmt);
	
	$TransType=12;	
	
	$TransNo = GetNextTransNonew(12, $con);	


if($cust_id=='')
{	
	//first insert client in bf_bank_clients table
	$stmtcustomer= "INSERT INTO lw_contacts (name
					)
			VALUES ('" . strtoupper(trim($_POST['cust_namehidden'])) . "'
				)";
		
		$resultcustomer=mysqli_query($con,$stmtcustomer);
		
		// select id of last inserted row
		$result=mysqli_query($con,"SELECT id FROM lw_contacts where name='" . $_POST['cust_namehidden'] ."'");	
	$myrowclientid=mysqli_fetch_array($result);		
	
	$cust_id=$myrowclientid[0];
	
}	  
  
  //insert gltrans entries
	
	 //$date_info = date_parse_from_format('d/m/Y', $DateString);
     // $value = "{$date_info['year']}-{$date_info['month']}-{$date_info['day']}";
	 
	$PeriodNo = GetPeriodnew(date('d/m/Y'),$con);	
		
	$SQL = 'UPDATE systypes SET typeno = ' . ($myrowbillno['billno']) . ' WHERE typeid = ' . $TransType;
	
	$UpdTransNoResult=mysqli_query($con,$SQL);	         			
				 		
		//fetch Client GLcode if already there
		
$sqlglcode= 'SELECT accountcode,accountname FROM chartmaster where accountname="' . trim($cust_namehidden) . '" ORDER BY accountcode DESC LIMIT 1';
		
		$result=mysqli_query($con,$sqlglcode);	
			
		$myrowglcode=mysqli_fetch_array($result);
		
		if($myrowglcode>0)
		{
		$glcode=$myrowglcode[0];
		
		}else
		{
		$glname="Professional Fees";
		
		$sqlglcode= "SELECT accountcode FROM chartmaster where group_ = '" . trim($glname) . "' ORDER BY accountcode DESC LIMIT 1";

		$result=mysqli_query($con,$sqlglcode);	
		
		$myrowglcode=mysqli_fetch_array($result);
		
		$myrowglcode['accountcode']=$myrowglcode['accountcode']+1;//Party GL Code
		 
		  $glcode= $myrowglcode['accountcode'];
		  
		  //Below is the code to create GL account code for the Party automatically for the first time
				
			$sql = 'INSERT INTO chartmaster (accountcode,
						accountname,
						group_)
					VALUES (' . $glcode . ",
						'".strtoupper($cust_namehidden). ' Ac'."',
						'Professional Fees')";
						
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
		
		$stmt= "INSERT INTO bf_receipts (
					type,
					billno,
					transno,
					custid,
					glcode,
					billdate,
					amount,
					particulars
					)
			VALUES (12,
				'" . trim($billno) . "',
				'" . trim($TransNo) . "',
				'" . trim($cust_id) . "',
				'" . trim($glcode) . "',
				'" . trim($billdate) . "',
				'" . trim($feescharged) . "',
				'" . trim($particulars) . "'
				)";
				
		
  $result=mysqli_query($con,$stmt);	
				
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
		$SQL= $SQL . 'VALUES (12,
					'.$billno.",
					'".$billdate."',
					'".$PeriodNo."',
					'204001',
					'".$particulars."',
					'".trim($feescharged)."',
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
		$SQL= $SQL . 'VALUES (12,
					'.$billno.",
					'".$billdate."',
					".$PeriodNo.",
					'".$glcode."',
					'".$particulars."',
					" .  '-' . $feescharged . ",
					0)";
					
		$result = mysqli_query($con,$SQL); 	
		
			
?>