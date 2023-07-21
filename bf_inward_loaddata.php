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

$grid->addColumn('bank_id', 'Bank', 'string',fetch_pairs($mysqli,'SELECT id, bank_name FROM bf_banks ORDER BY id ASC'),false);
//$grid->addColumn('billno', 'Bill No', 'string',NULL,false,NULL,FALSE,FALSE); 
//$grid->addColumn('billdate', 'Date', 'date',NULL,true); 
//$grid->addColumn('bank_id', 'Bank Code', 'string',fetch_pairs($mysqli,'SELECT id,bank_code FROM bf_banks'),true);  
$grid->addColumn('branch_id', 'Branch Name', 'string',fetch_pairs($mysqli,'SELECT id,branch_area FROM bf_bank_branch'),true); 
$grid->addColumn('applicationno', 'Application Number', 'string',NULL,false,NULL,FALSE,FALSE); 
$grid->addColumn('custid', 'Customer', 'string',fetch_pairs($mysqli,'SELECT id, name FROM lw_contacts ORDER BY name ASC'),true);  
$grid->addColumn('inward_date', 'Inward Date', 'date',NULL,false); 
$grid->addColumn('outward_date', 'Outward Date', 'date',NULL,true);   
$grid->addColumn('handledby', 'Handled By', 'string',fetch_pairs($mysqli,'SELECT userid,realname FROM www_users ORDER BY userid ASC'),true);  

$grid->addColumn('stage', 'Stage', 'string',fetch_pairs($mysqli,'SELECT id, stage FROM bf_stages'),true);   
$grid->addColumn('loanamount', 'Loan Amount', 'float', NULL, true);
$grid->addColumn('fees', 'Fees', 'float', NULL, true);
$grid->addColumn('remark', 'Remark', 'string',NULL,false,NULL,FALSE,true); 


//$grid->addColumn('action', 'Delete', 'html', NULL, true, 'id'); 

$mydb_tablename = (isset($_GET['db_tablename'])) ? stripslashes($_GET['db_tablename']) : 'bf_inward';

$sql='SELECT *,date_format(inward_date,"%d/%m/%Y") AS inward_date,date_format(outward_date,"%d/%m/%Y") AS outward_date ';

$filtersearch = trim($_GET['filter']);  // Here, this are little tips to manage date format before updating the table

   /*$date_info = date_parse_from_format('d/m/Y', $filtersearch);
      $filtersearch = "{$date_info['year']}-{$date_info['month']}-{$date_info['day']}";*/
	
                     

if($_GET['filter']) 
{
$sql .= '  from bf_inward LEFT JOIN bf_stages ON bf_inward.stage=bf_stages.id 
 LEFT JOIN bf_banks ON bf_inward.bank_id=bf_banks.bank_id
 LEFT JOIN bf_bank_branch ON bf_inward.branch_id=bf_bank_branch.branch_id 
 LEFT JOIN lw_contacts ON bf_inward.customer=lw_contacts.name WHERE bf_inward.outward_date IS NULL';
 }elseif(!$_GET['filter']) 
 {
 $sql .= '  from bf_inward WHERE bf_inward.outward_date IS NULL';
 }

$result = $mysqli->query($sql);

$mysqli->close();

// send data to the browser
$grid->renderJSON($result);

?>