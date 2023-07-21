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
$grid->addColumn('name', 'Name', 'string',NULL,false); 
//$grid->addColumn('address','Address','string',NULL,false);  
$grid->addColumn('mobile', 'Mobile 1', 'string',NULL,false); 
$grid->addColumn('action', 'Delete Contact', 'html', NULL, true, 'id'); 


$mydb_tablename = (isset($_GET['db_tablename'])) ? stripslashes($_GET['db_tablename']) : 'lw_contacts';
                                                                       
$result = $mysqli->query('SELECT id,name,mobile FROM lw_contacts');

$mysqli->close();

// send data to the browser
$grid->renderJSON($result);


?>

