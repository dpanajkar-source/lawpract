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
$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 15);
$mysqli->real_connect($config['db_host'],$config['db_user'],$config['db_password'],$config['db_name']); 
                    
// create a new EditableGrid object
$grid = new EditableGrid();

//Each column is typed (string, integer, double, boolean, url, email, date)


//$grid->addColumn('currtrandate', 'Current Date', 'date',NULL,true);

/* 
*  Add columns. The first argument of addColumn is the name of the field in the database. 
*  The second argument is the label that will be displayed in the header
*/

$grid->addColumn('id', 'ID', 'integer', NULL, false);
$grid->addColumn('type', 'Type', 'integer', NULL, false);
$grid->addColumn('typeno', 'Type No', 'integer', NULL, false);
$grid->addColumn('chequeno', 'Cheque', 'float', NULL, false);

$grid->addColumn('trandate', 'Trans Date', 'date'); 

$grid->addColumn('periodno', 'Period No', 'integer', NULL, false);                                         
$grid->addColumn('account', 'GL Code', 'float', NULL, false);
$grid->addColumn('narrative', 'Narrative', 'string',NULL,true,NULL,FALSE,false);

$grid->addColumn('amount', 'Amount', 'float', NULL, false);

//$grid->addColumn('posted', 'Posted', 'integer', NULL, true);

$grid->addColumn('action', 'Delete', 'html', NULL, true, 'id'); 

$mydb_tablename = (isset($_GET['db_tablename'])) ? stripslashes($_GET['db_tablename']) : 'gltrans';                                    
	
$sql='SELECT *, date_format(trandate,"%d/%m/%Y") as trandate from gltrans ORDER BY id ASC';
	
$result = $mysqli->query($sql);

$mysqli->close();

// send data to the browser
$grid->renderJSON($result);


?>

