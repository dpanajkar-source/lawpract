<?php

$PageSecurity =3;
      
include('config.php');  

 include('server_con.php');     

$billno=trim($_POST['billno']);

$stmt = "UPDATE bf_bills SET status=1 WHERE billno = '" . trim($billno) . "'";
					
	$result=mysqli_query($con,$stmt);


$billno=$billno+1;
	
	$stmt= "INSERT INTO bf_bills (billno,
					bank_id,
					status
					)
			VALUES ('" . trim($billno) . "',
			'" . trim($bank_id) . "',
				0
				)";
				
		$result=mysqli_query($con,$stmt);
		 $query=$stmt;		
		
	$SQLArray = explode(' ', $stmt);
	
	include('cust_audittrail.php');	
			
				/*$stmt = "UPDATE lw_cases SET
			  		stage='" . trim($myrownew['stage']) . "'
					WHERE brief_file = '" . trim($brief_file) . "'";*/	
	
?>