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
                              


/*
 * This script loads data from the database and returns it to the js
 *
 */
       
           

/*
 * fetch_pairs is a simple method that transforms a mysqli_result object in an array.
 * It will be used to generate possible values for some columns.
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

$grid->addColumn('id', 'ID', 'string',NULL,false,NULL,FALSE,FALSE); 
$grid->addColumn('brief_file', 'Brief File', 'string',NULL,FALSE,NULL,true); 
$grid->addColumn('courtcaseno', 'Case No', 'date',NULL,FALSE);
 
$grid->addColumn('documentname', 'Document Name', 'string',NULL,FALSE,NULL,true);  

$grid->addColumn('courtid', 'Court Name', 'string',fetch_pairs($mysqli,'SELECT courtid, courtname FROM lw_courts'),false);        
$grid->addColumn('requiredfor', 'Required For', 'string',NULL,true,NULL,true);     
                              
$grid->addColumn('handledby', 'Handled By', 'string',NULL,true,NULL,true); 

$grid->addColumn('status', 'Status', 'string',fetch_pairs($mysqli,'SELECT id, status FROM lw_taskstatus'),true);

$grid->addColumn('currentstage', 'Current Stage', 'string',NULL,true,NULL,true);   
$grid->addColumn('c_date', 'Start Date', 'date',NULL,FALSE);  
$grid->addColumn('priority', 'Priority', 'string',array('Low','Normal','High'),true);  

$grid->addColumn('remark', 'Remark', 'string',NULL,true,NULL,true);  

$grid->addColumn('action', 'Delete', 'html', NULL, false, 'id'); 
                                    
	
$sql='SELECT *, date_format(c_date,"%d/%m/%Y") as c_date from lw_certification ORDER BY lw_certification.id ASC';

$result = $mysqli->query($sql);

$mysqli->close();

// send data to the browser
$grid->renderJSON($result);

?>

