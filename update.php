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
                                                
// Here, these are little tips to manage date format before updating the table
if ($coltype == 'date') {
   if ($value === "") 
  	 $value = NULL;
   else {
      $date_info = date_parse_from_format('d/m/Y', $value);
      $value = "{$date_info['year']}-{$date_info['month']}-{$date_info['day']}";
   }
}                      

// This very generic. So this script can be used to update several tables.

$stage=$_GET['stageval'];
$brief_file=$_GET['brief_file'];

$tablename='lw_trans';

if ( $stmt = $mysqli->prepare("UPDATE lw_trans SET ".$colname." = ? WHERE id = ?")) {
	$stmt->bind_param("ss",$value, $id);
	$return = $stmt->execute();
	$stmt->close();
	
}

$return=false;

if($colname=='nextcourtdate' && $value!='')
		{
		
		$con=mysqli_connect("localhost","root",$dbpassword);
		mysqli_select_db($con,"lawpract");
		
	$resultmatch=mysqli_query($con,'SELECT currtrandate FROM lw_trans WHERE brief_file="' . trim($brief_file) . '" AND currtrandate="' .trim($value). '"');
	
	$myrowmatch=mysqli_fetch_array($resultmatch);
	
	if(empty($myrowmatch[0]))
	{		
	
	$result=mysqli_query($con,'SELECT * FROM lw_trans WHERE brief_file="' . trim($brief_file) . '" ORDER BY currtrandate DESC LIMIT 1');
	
	$myrownew=mysqli_fetch_array($result);
	
		  
		   if ($myrownew['prevcourtdate'] === "") 
		   {
			  $prevcourtdate = "NULL";
		   }else {
			  $prevcourtdate=$myrownew['prevcourtdate'];       
		   }
		   
		    if ($myrownew['currtrandate'] === "") 
		   {
			  $lastcurrtrandate = "NULL";
		   }else {
			  $lastcurrtrandate=$myrownew['currtrandate'];       
		   }	  
		   
		   if($lastcurrtrandate!=$value)
		   {
		   
		  $stmt= "INSERT INTO lw_trans (brief_file,
						currtrandate,
						prevcourtdate,
						courtname,
						courtcaseno,
						party,
						oppoparty,
						stage
						)
				VALUES ('" . trim($brief_file) . "',
						'" . trim($value) . "',
					'" . trim($lastcurrtrandate) . "',
					'" . trim($myrownew['courtname']) . "',
					'" . trim($myrownew['courtcaseno']) . "',
					'" . trim($myrownew['party']) . "',
					'" . trim($myrownew['oppoparty']) . "',
					'" . trim($myrownew['stage']) . "'				
						)";

	$result=mysqli_query($con,$stmt);
	
			}
			
	}     //end of if condition for matching ie if currtrandate entry is already	there no entry	will be done
	 
	}	
	

$return=false;

if ( $stmt = $mysqli->prepare("UPDATE lw_cases SET stage= ? WHERE brief_file = ?")) {
	$stmt->bind_param("ss",$stage, $brief_file);
	$return = $stmt->execute(); 
	$stmt->close();
	
}
             
$mysqli->close();        

echo $return ? "ok" : "error";