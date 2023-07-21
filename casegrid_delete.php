<?php
 $PageSecurity =3;
/*
 * 
 * http://editablegrid.net
 *
 * Copyright (c) 2011 Webismymind SPRL
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://editablegrid.net/license
 */
      
require_once('config.php');      

// Database connection                                   
$mysqli = mysqli_init();
$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);
$mysqli->real_connect($config['db_host'],$config['db_user'],$config['db_password'],$config['db_name']); 

// Get all parameter provided by the javascript
$id = $mysqli->real_escape_string(strip_tags($_POST['id']));
$tablename = $mysqli->real_escape_string(strip_tags($_POST['tablename']));

// This very generic. So this script can be used to update several tables.
$return=false;
/*if ( $stmt = $mysqli->prepare("DELETE FROM lw_cases WHERE id = ?")) {
	$stmt->bind_param("i", $id);
	//$return = $stmt->execute();
	
	$stmt->close();
}  */  

if ( $stmt = $mysqli->prepare("DELETE FROM lw_cases WHERE id = ?")) {
	$stmt->bind_param("i", $id);
	$return = $stmt->execute();
	
	$stmt->close();
	
	$stmtdelete = "DELETE FROM lw_cases WHERE id ='" .$id . "'";
	
	$query=$stmtdelete;		
	$SQLArray = explode(' ', $stmtdelete);
	include('cust_audittrail.php');	
	
}

$sql="SELECT brief_file FROM lw_cases WHERE id='" .$_POST['id'] . "'";

include('server_con.php');  

$result=mysqli_query($con,$sql);
	
$row=mysqli_fetch_array($result);
     

            $sql="DELETE FROM lw_filesattached WHERE brief_file='".$row[0]."'";
		  $result = mysqli_query($con,$sql);	
    $query=$sql;		
		
	$SQLArray = explode(' ', $sql);
	
	include('cust_audittrail.php');	
	
            $sql="DELETE FROM lw_citations WHERE brief_file='".$row[0]."'";
		   $result = mysqli_query($con,$sql);
						$query=$sql;		
							
						$SQLArray = explode(' ', $sql);
						
						include('cust_audittrail.php');			
    
            $sql="DELETE FROM lw_otherclients WHERE brief_file='".$row[0]."'";
		 $result = mysqli_query($con,$sql);	
						$query=$sql;		
							
						$SQLArray = explode(' ', $sql);
						
						include('cust_audittrail.php');	
		
			 $sql="DELETE FROM lw_casehistory WHERE brief_file='".$row[0]."'";
		   $result = mysqli_query($con,$sql);	
						$query=$sql;		
							
						$SQLArray = explode(' ', $sql);
						
						include('cust_audittrail.php');	
			
			$sql="DELETE FROM lw_casenohistory WHERE brief_file='".$row[0]."'";
		$result = mysqli_query($con,$sql);	
						$query=$sql;		
							
						$SQLArray = explode(' ', $sql);
						
						include('cust_audittrail.php');	
			
			$sql="DELETE FROM lw_judgehistory WHERE brief_file='".$row[0]."'";
		  $result = mysqli_query($con,$sql);	
						$query=$sql;		
							
						$SQLArray = explode(' ', $sql);
						
						include('cust_audittrail.php');	
			
			  
$mysqli->close();        

echo $return ? "ok" : "error";
      

