<?php     

$PageSecurity =3;
/*
 * examples/mysql/loaddata.php
 * 
 * This file is part of EditableGrid.
 * http://editablegrid.net
 *
 * Copyright (c) 2011 Webismymind SPRL
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://editablegrid.net/license
 */
 

require_once('config.php');      
require_once('EditableGrid.php'); 

function fetch_pairs($mysqli,$query){
	if (!($res = $mysqli->query($query)))return true;
	$rows = array();
	while ($row = $res->fetch_assoc()) {
		$first = true;
		$key = $value = null;
		foreach ($row as $val) {
			if ($first) { $key = $val; $first = false; }
			else { $value = $val; break; } 
		}
		$rows[$key] = $value;
	}
	return $rows;
}


// Database connection
$mysqli = mysqli_init();
$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);
$mysqli->real_connect($config['db_host'],$config['db_user'],$config['db_password'],$config['db_name']); 
                    
// create a new EditableGrid object
$grid = new EditableGrid();


//$grid->addColumn('currtrandate', 'Current Date', 'date',NULL,true);

/* 
*  Add columns. The first argument of addColumn is the name of the field in the database. 
*  The second argument is the label that will be displayed in the header
*/

$grid->addColumn('id', 'ID', 'integer', NULL, false);
$grid->addColumn('appdate', 'Appointment Date', 'date',NULL,FALSE);
$grid->addColumn('apptime', 'Appointment Time', 'date',NULL,FALSE);
 
$grid->addColumn('party', 'Party Name', 'string',fetch_pairs($mysqli,'SELECT id,name FROM lw_contacts'),true);    
$grid->addColumn('handledby', 'Handled By', 'string',fetch_pairs($mysqli,'SELECT userid,realname FROM www_users'),true);    

$grid->addColumn('status', 'Status', 'string', array('Pending','Postponed','Handled'), true);

$grid->addColumn('reason', 'Reason', 'string',NULL,true,NULL,true);  

$grid->addColumn(' ', 'Findings', 'boolean');

$grid->addColumn('action', 'Delete Record', 'html', NULL, true, 'id'); 

$mydb_tablename = (isset($_GET['db_tablename'])) ? stripslashes($_GET['db_tablename']) : 'lw_appointments';                                   
	
$sql='SELECT *, date_format(appdate,"%d/%m/%Y") as appdate';

$filtersearch = trim($_GET['filter']);  // Here, this are little tips to manage date format before updating the table                     

if($_GET['filter']) 
{
$sql .= '  from lw_appointments INNER JOIN lw_contacts ON lw_appointments.party=lw_contacts.id WHERE lw_contacts.name LIKE "%'.$filtersearch.'%" OR lw_appointments.handledby LIKE "%'.$filtersearch.'%" OR lw_appointments.appdate LIKE "%'.$filtersearch.'%"';
 }elseif(!$_GET['filter']) 
 {
 $sql .= '  from lw_appointments WHERE lw_appointments.appdate="' .date("Y-m-d"). '" ORDER BY lw_appointments.appdate ASC';
 }

$result = $mysqli->query($sql);

$mysqli->close();

// send data to the browser
$grid->renderJSON($result);


?>

