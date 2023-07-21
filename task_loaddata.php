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

$grid->addColumn('id', 'ID', 'integer', NULL, false);
$grid->addColumn('startdate', 'StartDate', 'date',NULL,FALSE);
 
$grid->addColumn('taskfrom', 'Task from', 'string',NULL,FALSE,NULL,true);  
$grid->addColumn('taskto', 'Task to','string',NULL,FALSE,NULL,true);       
$grid->addColumn('task', 'Task Description', 'string',NULL,true,NULL,true);     
                              
$grid->addColumn('taskstatus', 'Task Status', 'string',fetch_pairs($mysqli,'SELECT id, status FROM lw_taskstatus'),true);  
$grid->addColumn('enddate', 'DueDate', 'date',NULL,FALSE);  
$grid->addColumn('priority', 'Priority', 'string',array('Low','Normal','High'),true);  

$grid->addColumn('remark', 'Remark', 'string',NULL,true,NULL,true);  

$grid->addColumn('action', 'Delete Record', 'html', NULL, true, 'id'); 

$mydb_tablename = (isset($_GET['db_tablename'])) ? stripslashes($_GET['db_tablename']) : 'lw_tasks';
                                       
	
$sql='SELECT *, date_format(startdate,"%d/%m/%Y") as startdate, date_format(enddate,"%d/%m/%Y") as enddate from lw_tasks ORDER BY id ASC';

$result = $mysqli->query($sql);

$mysqli->close();

// send data to the browser
$grid->renderJSON($result);


?>

