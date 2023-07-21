<?php
      
include('server_con.php');  
		
$date_info = date_parse_from_format('d/m/Y', $_POST['c_date']);
$value = "{$date_info['year']}-{$date_info['month']}-{$date_info['day']}";
    
$stmt= "INSERT INTO lw_certification(
						brief_file,
						courtcaseno,
						documentname,
						courtid,
						requiredfor,
						handledby,
						status,
						currentstage,
						priority,
						c_date,
						remark
						)
				VALUES ('" . trim($_POST['brief_file']) . "',
					'" . trim($_POST['courtcasenohidden']) . "',
						'" . trim($_POST['documentname']) . "',
					'" . trim($_POST['courtid']) . "',
					'" . trim($_POST['requiredfor']) . "',
					'" . trim($_POST['handledby']) . "',
					'" . trim($_POST['status']) . "',
					'" . trim($_POST['stage']) . "',
					'" . trim($_POST['priority']) . "',
					'" . trim($value) . "',
					'" . trim($_POST['remark']) . "'
						)";
  
	  $result=mysqli_query($con,$stmt);
	  
	  $query=$stmt;	

	$SQLArray = explode(' ', $stmt);
	
	include('cust_audittrail.php');

?>