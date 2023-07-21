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
$grid->addColumn('id', 'ID', 'string',NULL,false,NULL,FALSE,FALSE); 
$grid->addColumn('billno', 'Bill No', 'string',NULL,false,NULL,FALSE,FALSE); 
$grid->addColumn('billdate', 'Date', 'date',NULL,true);   
$grid->addColumn('name', 'Customer', 'string',fetch_pairs($mysqli,'SELECT id, name FROM lw_contacts ORDER BY name ASC'),true);
$grid->addColumn('amount', 'Amount', 'float', NULL, true);
$grid->addColumn('', 'Print Receipt', 'boolean');  
$grid->addColumn(' ', 'Plain Receipt', 'boolean');
$grid->addColumn('action', 'Action', 'html', NULL, false, 'id'); 

$mydb_tablename = (isset($_GET['db_tablename'])) ? stripslashes($_GET['db_tablename']) : 'bf_ind_receipts';

$sql='SELECT bf_ind_receipts.id,bf_ind_receipts.billno,lw_contacts.name,date_format(bf_ind_receipts.billdate,"%d/%m/%Y") as billdate,bf_ind_receipts.amount,bf_ind_receipts.particulars';

$filtersearch = trim($_GET['filter']);  // Here, this are little tips to manage date format before updating the table

   /*$date_info = date_parse_from_format('d/m/Y', $filtersearch);
      $filtersearch = "{$date_info['year']}-{$date_info['month']}-{$date_info['day']}";*/
	
                     

if($_GET['filter']) 
{
$sql .= '  from bf_ind_receipts LEFT JOIN lw_contacts ON bf_ind_receipts.custid=lw_contacts.name WHERE lw_contacts.name  LIKE "%'.$filtersearch.'%" OR bf_ind_receipts.billdate LIKE "%'.$filtersearch.'%"';
 }elseif(!$_GET['filter']) 
 {
 $sql .= '  from bf_ind_receipts INNER JOIN lw_contacts ON bf_ind_receipts.custid=lw_contacts.id ORDER BY bf_ind_receipts.id ASC';
 }
 
$result = $mysqli->query($sql);

$mysqli->close();

// send data to the browser
$grid->renderJSON($result);

?>