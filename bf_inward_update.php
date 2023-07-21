<?php
 $PageSecurity =3;
/*
 * 
 * This file is part of EditableGrid.
 * http://editablegrid.net
 *
 * Copyright (c) 2011 Webismymind SPRL
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://editablegrid.net/license
 */
      
include('config.php');  

include('server_con.php');   
       
// Database connection                                   
$mysqli = mysqli_init();
$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);
$mysqli->real_connect($config['db_host'],$config['db_user'],$config['db_password'],$config['db_name']); 
                      
// Get all parameters provided by the javascript
$colname = $mysqli->real_escape_string(strip_tags($_POST['colname']));
$id = $mysqli->real_escape_string(strip_tags($_POST['id']));
$coltype = $mysqli->real_escape_string(strip_tags($_POST['coltype']));
$value = $mysqli->real_escape_string(strip_tags($_POST['newvalue']));
$tablename = $mysqli->real_escape_string(strip_tags($_POST['tablename']));
                                                
// Here, this are little tips to manage date format before updating the table
if ($coltype == 'date') {
   if ($value === "") 
  	 $value = NULL;
   else {
      $date_info = date_parse_from_format('d/m/Y', $value);
      $value = "{$date_info['year']}-{$date_info['month']}-{$date_info['day']}";
   }
}     

if($colname=='outward_date')
{

 //select bill no
			/*$sqlbillno='SELECT id,status from bf_bills ORDER BY id DESC LIMIT 1';
			
			$resultbillno=mysqli_query($con,$sqlbillno); 
			
			$myrowbillno=mysqli_fetch_array($resultbillno);
			
			if(empty($myrowbillno))
			{
			$myrowbillno['billno']=1;
			}else
			{
			$myrowbillno['billno']=$myrowbillno['billno']+1;
			}			*/
			

// select record details from bf_inward 
	$result1=mysqli_query($con,"SELECT * FROM bf_inward where id='" . $id ."'");	
	$myrowinwarddetails=mysqli_fetch_array($result1);	
		
 $stmt= "INSERT INTO bf_cases (bank_id,
					applicationno,
					custid,
					branch_id,
					stage,
					loanamount,
					fees
					)
			VALUES ('" . trim($myrowinwarddetails['bank_id']) . "',
				'" . trim($myrowinwarddetails['applicationno']) . "',
				'" . trim($myrowinwarddetails['custid']) . "',
				'" . trim($myrowinwarddetails['branch_id']) . "',
				'" . trim($myrowinwarddetails['stage']) . "',
				'" . trim($myrowinwarddetails['loanamount']) . "',
				'" . trim($myrowinwarddetails['fees']) . "'
				)";				
		
    $result=mysqli_query($con,$stmt);	
			 $query=$stmt;		
		
	$SQLArray = explode(' ', $stmt);
	
	//include('cust_audittrail.php');	 
	 
}                

// This very generic. So this script can be used to update several tables.

$return=false;

if ( $stmt = $mysqli->prepare("UPDATE bf_inward SET ".$colname." = ? WHERE id = ?")) {
	$stmt->bind_param("ss",$value, $id);
	$return = $stmt->execute();
	$stmt->close();
	
}

            
$mysqli->close();        

echo $return ? "ok" : "error";