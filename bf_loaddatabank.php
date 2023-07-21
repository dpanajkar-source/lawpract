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
//$grid->addColumn('billno', 'Bill No', 'string',NULL,false,NULL,FALSE,FALSE); 
//$grid->addColumn('billdate', 'Date', 'date',NULL,true); 
$grid->addColumn('bank_id', 'Bank Name', 'string',fetch_pairs($mysqli,'SELECT id,bank_name FROM bf_banks'),true);  
$grid->addColumn('applicationno', 'Application Number', 'string',NULL,false,NULL,FALSE,FALSE); 
$grid->addColumn('branch_id', 'Branch Name', 'string',fetch_pairs($mysqli,'SELECT id,branch_area FROM bf_bank_branch'),true);  
  
$grid->addColumn('custid', 'Customer', 'string',fetch_pairs($mysqli,'SELECT id, name FROM lw_contacts ORDER BY name ASC'),true);
 
$grid->addColumn('stage', 'Stage', 'string',fetch_pairs($mysqli,'SELECT id, stage FROM bf_stages'),true);   

$grid->addColumn('outward_date', 'Outward Date', 'date',NULL,true);   
$grid->addColumn('loanamount', 'Loan Amount', 'float', NULL, true);
$grid->addColumn('fees', 'Fees', 'float', NULL, true);
//$grid->addColumn('remark', 'Remark', 'string',NULL,false,NULL,FALSE,false); 

//$grid->addColumn('action', 'Delete', 'html', NULL, true, 'id'); 

$mydb_tablename = (isset($_GET['db_tablename'])) ? stripslashes($_GET['db_tablename']) : 'bf_cases';

$sql='SELECT *,bf_cases.loanamount,date_format(outward_date,"%d/%m/%Y") AS outward_date';

$filtersearch = trim($_GET['filter']);  // Here, this are little tips to manage date format before updating the table

   /*$date_info = date_parse_from_format('d/m/Y', $filtersearch);
      $filtersearch = "{$date_info['year']}-{$date_info['month']}-{$date_info['day']}";*/
                     

if($_GET['filter']) 
{
$sql .= '  from bf_cases LEFT JOIN bf_stages ON bf_cases.stage=bf_stages.id 
 LEFT JOIN bf_banks ON bf_cases.bank_id=bf_banks.bank_id
 LEFT JOIN bf_bank_branch ON bf_cases.branch_id=bf_bank_branch.branch_id 
 LEFT JOIN lw_contacts ON bf_cases.customer=lw_contacts.name WHERE billno IS NULL';
 }elseif(!$_GET['filter']) 
 {
 $sql .= '  from bf_cases INNER JOIN bf_inward ON bf_cases.applicationno=bf_inward.applicationno WHERE bf_cases.billno IS NULL';
 }

$result = $mysqli->query($sql);

$mysqli->close();

// send data to the browser
$grid->renderJSON($result);

?>