<?php     

$PageSecurity = 1;

require_once('config.php');      
require_once('EditableGrid.php'); 


function fetch_pairs($mysqli,$query){
	if (!($res = $mysqli->query($query)))return FALSE;
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

/* 
*  Add columns. The first argument of addColumn is the name of the field in the database. 
*  The second argument is the label that will be displayed in the header
*/

$grid->addColumn('id', 'ID', 'integer',NULL,false); 
$grid->addColumn('brief_file', 'BRIEF FILE NO', 'string',NULL,false); 
$grid->addColumn('courtcaseno','COURT CASE NO','string',NULL,false);  
$grid->addColumn('name','PARTY', 'string',NULL,false); 
$grid->addColumn('deleted', 'ARCHIVE-Insert 1 to Archive', 'string',NULL,true); 

$grid->addColumn('action', 'Delete Case Permanently', 'html', NULL, true, 'id'); 


                                                                       
$result = $mysqli->query('SELECT lw_cases.id,lw_cases.brief_file,lw_cases.courtcaseno,lw_contacts.name,lw_cases.deleted FROM 
                          lw_cases INNER JOIN lw_contacts
						   ON lw_cases.party=lw_contacts.id
						 ');

$mysqli->close();

// send data to the browser
//$grid->renderJSON($brief_file);
$grid->renderJSON($result);


?>

