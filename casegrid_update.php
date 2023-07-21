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
$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 15);

$mysqli->real_connect($config['db_host'],$config['db_user'],$config['db_password'],$config['db_name']); 

$partyid=$_GET['partyid']; //new party id

$oppopartyid=$_GET['oppopartyid']; //new party id

$brief_file=$_GET['brief_file'];

$courtcaseno=$_GET['courtcaseno'];

$colindex=$_GET['columnindex'];

// Get all parameters provided by the javascript
$colname = $mysqli->real_escape_string(strip_tags($_POST['colname']));
$id = $mysqli->real_escape_string(strip_tags($_POST['id']));
$coltype = $mysqli->real_escape_string(strip_tags($_POST['coltype']));
$value = $mysqli->real_escape_string(strip_tags($_POST['newvalue']));
$tablename = $mysqli->real_escape_string(strip_tags($_POST['tablename']));

/*
if($colindex==3)
{
$return=false;

//update lw_trans for the courtcaseno

if( $stmt1 = $mysqli->prepare("UPDATE lw_trans SET courtcaseno = ? WHERE brief_file = ?")) {
	$stmt1->bind_param("ss", $courtcaseno, $brief_file);
	 //$return = $stmt1->execute();
	
	// $SQL="UPDATE lw_trans SET courtcaseno ='" . $courtcaseno . "' WHERE brief_file ='" . $brief_file . "'";
	 	
	//DB_querygrid($SQL,$db);
	$stmt1->close();
	 }
}*/

//if($colindex==5 || $colindex==6)
if($colname=='party' || $colname=='oppoparty')
{
//update all below tables with new party id

$return=false;
if ( $stmt = $mysqli->prepare("UPDATE lw_trans SET party = ?,oppoparty= ? WHERE brief_file = ?")) {
	$stmt->bind_param("sss", $partyid,$oppopartyid, $brief_file);
	
    $return = $stmt->execute();
	$stmt->close();
	
}  

/*$return=false;
if ( $stmt = $mysqli->prepare("UPDATE lw_trans SET oppoparty = ? WHERE brief_file = ?")) {
	$stmt->bind_param("ss", $oppopartyid, $brief_file);
	$return = $stmt->execute();
	$stmt->close();
	
}   */

}

                      

                                                
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
$return=false;
if ( $stmt = $mysqli->prepare("UPDATE lw_cases SET ".$colname." = ? WHERE id = ?")) {
	$stmt->bind_param("ss",$value, $id);
	$return = $stmt->execute();
	
 $stmt->close();
	
}    

$mysqli->close();
echo $return ? "ok" : "error";
