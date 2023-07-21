<?php     

$PageSecurity =3;   

require_once('config.php');      
require_once('EditableGrid.php'); 

function fetch_pairs($mysqli,$query){
	if (!($res = $mysqli->query($query)))return false;
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

$name, $label, $type, $values = NULL, $editable = true, $field = NULL, $bar = true, $hidden = false
*/
//$grid->addColumn('currtrandate', '', 'date',NULL,true,NULL,FALSE,true);
$grid->addColumn('id', 'ID', 'string',NULL,false,NULL,FALSE,FALSE); 
$grid->addColumn('brief_file', 'Brief No or File No', 'string',NULL,false,NULL,FALSE,true); 
$grid->addColumn('prevcourtdate', 'Previous Date', 'date',NULL,false); 
$grid->addColumn('currtrandate', 'Current Date', 'date',NULL,false);
$grid->addColumn('nextcourtdate', 'Next Date', 'date',NULL,true); 
$grid->addColumn('courtname', 'Court Name', 'string',fetch_pairs($mysqli,'SELECT courtid,courtname FROM lw_courts'),false);  
$grid->addColumn('courtcaseno', 'Case No.', 'string', NULL,true);  
$grid->addColumn('party', 'Party', 'string',fetch_pairs($mysqli,'SELECT id, name FROM lw_contacts'),false);
$grid->addColumn('oppoparty', 'Opposite Party', 'string',fetch_pairs($mysqli,'SELECT id, name FROM lw_contacts'),false); 
$grid->addColumn('stage', 'Stage', 'string',fetch_pairs($mysqli,'SELECT stageid, stage FROM lw_stages'),true);  
 $grid->addColumn('smssent', 'SEND SMS', 'boolean',NULL,true);  
 
//$grid->addColumn('website', 'email', 'html', NULL, false, 'id');


//$mydb_tablename = (isset($_GET['db_tablename'])) ? stripslashes($_GET['db_tablename']) : 'lw_trans';
$mydb_tablename = 'lw_trans';

$sql='SELECT lw_trans.id,lw_trans.brief_file,date_format(currtrandate,"%d/%m/%Y") as currtrandate,date_format(prevcourtdate,"%d/%m/%Y") as prevcourtdate, lw_trans.courtname,lw_trans.courtcaseno,lw_trans.party,lw_trans.oppoparty,lw_trans.stage,date_format(nextcourtdate,"%d/%m/%Y") as nextcourtdate,smssent';

$filtersearch = trim($_GET['filter']);  // Here, this are little tips to manage date format before updating the table 


if($_GET['filter']) 
{
$sql .= '  from lw_trans JOIN lw_contacts ON lw_trans.party=lw_contacts.id WHERE lw_trans.brief_file LIKE "%'.$filtersearch.'%" OR lw_trans.courtcaseno LIKE "%'.$filtersearch.'%" OR lw_contacts.name LIKE "%'.$filtersearch.'%" OR lw_trans.currtrandate LIKE "%'.$filtersearch.'%" ORDER BY lw_trans.currtrandate ASC';
 }elseif(!$_GET['filter']) 
 {
 $sql .= '  from lw_trans WHERE lw_trans.currtrandate="' .date("Y-m-d"). '" ORDER BY lw_trans.currtrandate ASC';
 }

$result = $mysqli->query($sql);

$mysqli->close();

// send data to the browser
$grid->renderJSON($result);

?>