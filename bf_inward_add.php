<?php

$PageSecurity =3;
      
include('server_con.php');      

$bank_code=trim($_POST['bank_code']);
$bank_id=trim($_POST['bank_id']);
$applicationno=trim($_POST['applicationno']);
$customer=trim($_POST['customer']);
$branch_code=trim($_POST['branch_code']);
$inward_date=trim($_POST['inward_date']);
$handledby=trim($_POST['handledby']);
$stage=trim($_POST['stage']);
$loanamount=trim($_POST['loanamount']);
$fees=trim($_POST['fees']);
$remark=trim($_POST['remark']);


if ($inward_date === "") 
  	 $inward_date = NULL;
   else {
      $inward_date_info = date_parse_from_format('d/m/Y', $inward_date);
      $inward_date = "{$inward_date_info['year']}-{$inward_date_info['month']}-{$inward_date_info['day']}";
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
	$query=$stmtcustomer;		
		
	$SQLArray = explode(' ', $stmtcustomer);
	
	include('cust_audittrail.php');	
	
	$result=mysqli_query($con,"SELECT id FROM lw_contacts where name='" . trim($customer) ."'");	
	$myrowclientid=mysqli_fetch_array($result);	
	}
   
  /* if ($outward_date === "") 
  	 $outward_date = NULL;
   else {
      $outward_date_info = date_parse_from_format('d/m/Y', $outward_date);
      $outward_date = "{$outward_date_info['year']}-{$outward_date_info['month']}-{$outward_date_info['day']}";
	  	  	   */
			   
					  
	 $stmt= "INSERT INTO bf_inward (bank_id,
					applicationno,
					custid,
					branch_id,
					inward_date,
					handledby,
					stage,
					loanamount,
					fees,
					remark
					)
			VALUES ('" . trim($bank_id) . "',
				'" . trim($applicationno) . "',
				'" . trim($myrowclientid[0]) . "',
				'" . trim($branch_code) . "',
				'" . trim($inward_date) . "',
				'" . trim($handledby) . "',
				'" . trim($stage) . "',
				'" . trim($loanamount) . "',
				'" . trim($fees) . "',
				'" . trim($remark) . "'
				)";				
		
  $result=mysqli_query($con,$stmt);		
	$query=$stmt;		
		
	$SQLArray = explode(' ', $stmt);
	
	include('cust_audittrail.php');	
			/*$stmt = "UPDATE lw_cases SET
			  		stage='" . trim($myrownew['stage']) . "'
					WHERE brief_file = '" . trim($brief_file) . "'";*/	
	
?>