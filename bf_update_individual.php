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

// This very generic. So this script can be used to update several tables.

$tablename='bf_ind_receipts';

$return=false;

if ( $stmt = $mysqli->prepare("UPDATE bf_ind_receipts SET ".$colname." = ? WHERE id = ?")) {
	$stmt->bind_param("ss",$value, $id);
	$return = $stmt->execute();
	$stmt->close();
	$query=$stmt;		
		
	$SQLArray = explode(' ', $stmt);
	
	include('cust_audittrail.php');	
}

            
$mysqli->close();        

echo $return ? "ok" : "error";