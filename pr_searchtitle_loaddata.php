<?php     


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
                              


/*
 * This script loads data from the database and returns it to the js
 *
 */
       
           

/*
 * fetch_pairs is a simple method that transforms a mysqli_result object in an array.
 * It will be used to generate possible values for some columns.
*/ 
$PageSecurity =3;

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

$grid->addColumn('id', 'ID', 'string',NULL,false,NULL,FALSE,FALSE); 
//$grid->addColumn('brief_file', 'File No', 'date',NULL,FALSE);
 $grid->addColumn('fileno', 'File No', 'string',NULL,FALSE,NULL,true);
$grid->addColumn('property', 'Property Name', 'string',NULL,FALSE,NULL,true);  

$grid->addColumn('propertydetails', 'Property Details', 'string',NULL,FALSE,NULL,true);  

$grid->addColumn('custid', 'Customer', 'string',fetch_pairs($mysqli,'SELECT id, name FROM lw_contacts ORDER BY name ASC'),true);  
$grid->addColumn('status', 'Status', 'string',fetch_pairs($mysqli,'SELECT id, status FROM lw_taskstatus'),true);

$grid->addColumn('agentcharges', 'Agent Charges', 'float',NULL,true,NULL,true);

 $grid->addColumn('searchfees', 'Search Fees', 'float',NULL,true,NULL,true);
 
$grid->addColumn('feescharged', 'Fees Charged', 'float',NULL,true,NULL,true);
  
$grid->addColumn('inward_date', 'Inward Date', 'date',NULL,false);  
$grid->addColumn('outward_date', 'Outward Date', 'date',NULL,TRUE);  

$grid->addColumn('remark', 'Remark', 'string',NULL,true,NULL,true); 
$grid->addColumn('agent', 'Agent', 'string',fetch_pairs($mysqli,'SELECT id, name FROM lw_contacts ORDER BY name ASC'),true);  
$grid->addColumn('', 'Print Receipt', 'boolean'); 

$grid->addColumn('action', 'Delete', 'html', NULL, false, 'id'); 
                                    
	
$sql='SELECT *, date_format(inward_date,"%d/%m/%Y") as inward_date,date_format(outward_date,"%d/%m/%Y") as outward_date';

$filtersearch = trim($_GET['filter']);  // Here, this are little tips to manage date format before updating the table

   /*$date_info = date_parse_from_format('d/m/Y', $filtersearch);
      $filtersearch = "{$date_info['year']}-{$date_info['month']}-{$date_info['day']}";*/
	
                     

if($_GET['filter']) 
{
$sql .= '  from lw_searchtitle WHERE lw_searchtitle.property  LIKE "%'.$filtersearch.'%" OR lw_searchtitle.inward_date LIKE "%'.$filtersearch.'%"';
 }elseif(!$_GET['filter']) 
 {
 $sql .= '  from lw_searchtitle';
 }
 
$result = $mysqli->query($sql);

$mysqli->close();

// send data to the browser
$grid->renderJSON($result);



?>

