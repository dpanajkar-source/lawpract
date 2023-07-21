<?php     

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

//$grid->addColumn('currtrandate', '', 'date',NULL,true,NULL,FALSE,true);
$grid->addColumn('id', 'ID', 'string',NULL,false,NULL,FALSE,FALSE); 
$grid->addColumn('brief_file', 'Brief No or File No', 'string',NULL,true,NULL,FALSE,true); 
$grid->addColumn('prevcourtdate', 'Previous Date', 'date',NULL,true); 
$grid->addColumn('currtrandate', 'Current Date', 'date',NULL,true);
$grid->addColumn('nextcourtdate', 'Next Date', 'date',NULL,true); 
$grid->addColumn('courtname', 'Court Name', 'string',fetch_pairs($mysqli,'SELECT courtid,courtname FROM lw_courts'),true);  
$grid->addColumn('courtcaseno', 'Case No.', 'string', NULL,true);  
$grid->addColumn('party', 'Party', 'string',fetch_pairs($mysqli,'SELECT id, name FROM lw_contacts ORDER BY name ASC'),false);
$grid->addColumn('oppoparty', 'Opposite Party', 'string',fetch_pairs($mysqli,'SELECT id, name FROM lw_contacts ORDER BY name ASC'),false);  
$grid->addColumn('stage', 'Stage', 'string',fetch_pairs($mysqli,'SELECT stageid, stage FROM lw_stages'),true);   
$grid->addColumn('action', 'Delete', 'html', NULL, true, 'id'); 

$sql='SELECT lw_trans.id,lw_trans.brief_file,date_format(currtrandate,"%d/%m/%Y") as currtrandate,date_format(prevcourtdate,"%d/%m/%Y") as prevcourtdate,date_format(nextcourtdate,"%d/%m/%Y") as nextcourtdate,lw_trans.courtname,lw_trans.courtcaseno,lw_trans.party,lw_trans.oppoparty,lw_trans.stage FROM lw_trans ORDER BY lw_trans.currtrandate ASC';

$result = $mysqli->query($sql);

$mysqli->close();

// send data to the browser
$grid->renderJSON($result);

?>