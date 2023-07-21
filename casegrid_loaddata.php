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
$mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 15);
$mysqli->real_connect($config['db_host'],$config['db_user'],$config['db_password'],$config['db_name']); 
                    
// create a new EditableGrid object
$grid = new EditableGrid();

$grid->addColumn('id', 'ID', 'integer', NULL, false);
$grid->addColumn('brief_file', 'Brief-File', 'string',NULL,false,NULL,FALSE,true);
$grid->addColumn('courtid', 'Court', 'string',fetch_pairs($mysqli,'SELECT courtid,courtname FROM lw_courts'),true); 
$grid->addColumn('courtcaseno', 'Case No.','string',NULL,false,NULL,FALSE,true);
//$grid->addColumn('brief_file', 'Brief No or File No', 'string',NULL,false,NULL,FALSE,TRUE);  

/* The column id_country and id_continent will show a list of all available countries and continents. So, we select all rows from the tables */
//$grid->addColumn('notice_no', 'Notice No','string',NULL,true,NULL,FALSE,false);  

$grid->addColumn('party', 'Party     VS', 'string',fetch_pairs($mysqli,'SELECT id, name FROM lw_contacts ORDER BY name ASC'),false);                                         
$grid->addColumn('oppoparty', 'Opposite Party', 'string',fetch_pairs($mysqli,'SELECT id, name FROM lw_contacts ORDER BY name ASC'),false);  
//$grid->addColumn('govt_dept_no', 'Govt. Dept.', 'string',NULL,true,NULL,FALSE,false); 
$grid->addColumn('stage', 'Stage', 'string',fetch_pairs($mysqli,'SELECT stageid, stage FROM lw_stages'),false);  

//$grid->addColumn('partyrole', 'Party Role', 'string',fetch_pairs($mysqli,'SELECT roleid, role FROM lw_partiesinvolved'),true);  
//$grid->addColumn('oppopartyrole', 'Oppo Party Role', 'string',fetch_pairs($mysqli,'SELECT roleid, role FROM lw_partiesinvolved'),true);  
 //$grid->addColumn('clientcatid', 'Client Category', 'string',fetch_pairs($mysqli,'SELECT clientcatid, category FROM lw_clientcat'),true);  
    
//$grid->addColumn('casecatid', 'Case Category', 'string',fetch_pairs($mysqli,'SELECT casecatid, casecat FROM lw_casecat'),true); 
//$grid->addColumn('casestatus', 'Case Status', 'string',fetch_pairs($mysqli,'SELECT casestatusid, casestatusdesc FROM lw_case_status'),true);   
$grid->addColumn('opendt', 'Open Date', 'date');  
//$grid->addColumn('closedt', 'Close Date', 'date'); 
//$grid->addColumn('counselparty', 'Counsel Party','string',NULL,true,NULL,FALSE,false);
//$grid->addColumn('counseloppoparty', 'Counsel Opposite','string',NULL,true,NULL,FALSE,false);
//$grid->addColumn('firnumber', 'FIR Number','string',NULL,true,NULL,FALSE,false);
//$grid->addColumn('firdate', 'FIR Date', 'date');  
//$grid->addColumn('firtime', 'FIR Time', 'date');  
//$grid->addColumn('policestation', 'Police Station','string',NULL,true,NULL,FALSE,false);
//$grid->addColumn('remark', 'Remark','string',NULL,true,NULL,FALSE,false);

$grid->addColumn('judgename', 'Judgename','string',NULL,true,NULL,FALSE,false);

$grid->addColumn(' ', 'Other Details', 'boolean');

//$grid->addColumn('deleted', 'Archive','string',NULL,true,NULL,FALSE,false);
$grid->addColumn('action', 'Delete', 'html', NULL, true, 'id'); 

$mydb_tablename = (isset($_GET['db_tablename'])) ? stripslashes($_GET['db_tablename']) : 'lw_cases';                                    
	
$sql='SELECT *, date_format(opendt,"%d/%m/%Y") as opendt, date_format(closedt,"%d/%m/%Y") as closedt, date_format(firdate,"%d/%m/%Y") as firdate from lw_cases WHERE deleted!=1 AND stage!=37 ORDER BY id ASC';
	
$result = $mysqli->query($sql);

$mysqli->close();

// send data to the browser
$grid->renderJSON($result);


?>

