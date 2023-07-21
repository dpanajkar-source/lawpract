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
/*$mysqli = mysqli_init();
$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);
$mysqli->real_connect($config['db_host'],$config['db_user'],$config['db_password'],$config['db_name']); */

// Get all parameter provided by the javascript
$id = strip_tags($_POST['id']);
//$tablename = $mysqli->real_escape_string(strip_tags($_POST['tablename']));

// This very generic. So this script can be used to update several tables.
$sql='SELECT typeno FROM gltrans WHERE id="' . $id . '"';
$return=false;
$con=mysqli_connect("localhost","root",$dbpassword);
mysqli_select_db($con,"lawpract");

$result = mysqli_query($con,$sql);
$rowtypeno = mysqli_fetch_array($result);

$returnpartytrans = mysqli_query($con,'DELETE FROM lw_partytrans WHERE transno="' . $rowtypeno['typeno'] . '"');

$returnbanktrans = mysqli_query($con,'DELETE FROM banktrans WHERE transno="' . $rowtypeno['typeno'] . '"');

$returnsupptrans = mysqli_query($con,'DELETE FROM supptrans WHERE transno="' . $rowtypeno['typeno'] . '"');

$returnchartdetails = mysqli_query($con,'DELETE FROM chartdetails');

$return = mysqli_query($con,'DELETE FROM gltrans WHERE typeno="' . $rowtypeno['typeno'] . '"');

echo $return ? "ok" : "error";