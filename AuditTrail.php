<?php


if (!isset($_POST['FromDate'])){
	$_POST['FromDate'] = Date($_SESSION['DefaultDateFormat'],mktime(0,0,0, Date('m')-$_SESSION['MonthsAuditTrail']));
}
if (!isset($_POST['ToDate'])){
	$_POST['ToDate']= Date($_SESSION['DefaultDateFormat']);
}

if ((!(Is_Date($_POST['FromDate'])) OR (!Is_Date($_POST['ToDate']))) AND (isset($_POST['View']))) {
	prnMsg('Incorrect date format used, please re-enter', error);
	unset($_POST['View']);
}

// Get list of tables
$tableresult = DB_show_tables($db);

// Get list of users
$userresult = DB_query('SELECT userid FROM www_users',$db);

echo '<form action=' . $_SERVER['PHP_SELF'] . '?' . SID . ' method=post>';


		 
		 
echo '<div class="uk-overflow-container">';

echo '<div class="uk-width-medium-2-2" style="padding-bottom:10px" class="md-input-wrapper">';
echo '<div class="uk-grid uk-grid-width-1-2 uk-grid-width-medium-1-2">';
// DIV from here------------------------------------------------------------------------------------------
        
echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">'. 'From Date' . ' ' . $_SESSION['DefaultDateFormat'] .'
	<input tabindex="1" type=text class="md-input" data-uk-datepicker="{format:\'DD/MM/YYYY\'}" name="FromDate" size="11" maxlength="10" value=' .$_POST['FromDate'].'></div>';
	
echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">'. 'To Date' . ' ' . $_SESSION['DefaultDateFormat'] .'<input tabindex="2" type=text class="md-input" data-uk-datepicker="{format:\'DD/MM/YYYY\'}" name="ToDate" size="11" maxlength="10" value=' . $_POST['ToDate'] . '></div>';

// Show user selections
echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">'. 'User ID'. '
		<select tabindex="3" name="SelectedUser" class="md-input">';
echo '<option value=ALL>ALL';
while ($users = DB_fetch_row($userresult)) {
	if (isset($_POST['SelectedUser']) and $users[0]==$_POST['SelectedUser']) {
		echo '<option selected value=' . $users[0] . '>' . $users[0];
	} else {
		echo '<option value=' . $users[0] . '>' . $users[0];
	}
}
echo '</select></div>';

// Show table selections
echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">'. 'Table '. '</td><td><select tabindex="4" name="SelectedTable" class="md-input">';
echo '<option value=ALL>ALL';
while ($tables = DB_fetch_row($tableresult)) {
	if (isset($_POST['SelectedTable']) and $tables[0]==$_POST['SelectedTable']) {
		echo '<option selected value=' . $tables[0] . '>' . $tables[0];
	} else {
		echo '<option value=' . $tables[0] . '>' . $tables[0];
	}
}
echo '</select></div>';

echo "<div class='uk-width-medium-1-2' style='padding-bottom:10px'><input tabindex='5' type=submit name=View value='" . 'View' . "' class='md-btn md-btn-primary' ></div>";
echo '</div>';
echo '</form></div></div>';

// View the audit trail
if (isset($_POST['View'])) {
	
	$FromDate = str_replace('/','-',FormatDateForSQL($_POST['FromDate']).' 00:00:00');
	$ToDate = str_replace('/','-',FormatDateForSQL($_POST['ToDate']).' 23:59:59');
	
	// Find the query type (insert/update/delete)
	function Query_Type($SQLString) {
		$SQLArray = explode(" ", $SQLString);
		return $SQLArray[0];
	}

	function InsertQueryInfo($SQLString) {
		$SQLArray = explode('(', $SQLString);
		$_SESSION['SQLString']['table'] = $SQLArray[0];
		$SQLString = str_replace(')','',$SQLString);
		$SQLString = str_replace('(','',$SQLString);
		$SQLString = str_replace($_SESSION['SQLString']['table'],'',$SQLString);
		$SQLArray = explode('VALUES', $SQLString);
		$fieldnamearray = explode(',', $SQLArray[0]);
		$_SESSION['SQLString']['fields'] = $fieldnamearray;
		if (isset($SQLArray[1])) {
			$FieldValueArray = preg_split("/[[:space:]]*('[^']*'|[[:digit:].]+),/", $SQLArray[1], 0, PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_NO_EMPTY);
			$_SESSION['SQLString']['values'] = $FieldValueArray;
		}
	}

	function UpdateQueryInfo($SQLString) {
		$SQLArray = explode('SET', $SQLString);
		$_SESSION['SQLString']['table'] = $SQLArray[0];
		$SQLString = str_replace($_SESSION['SQLString']['table'],'',$SQLString);
		$SQLString = str_replace('SET','',$SQLString);
		$SQLString = str_replace('WHERE',',',$SQLString);
		$SQLString = str_replace('AND',',',$SQLString);
		$FieldArray = preg_split("/[[:space:]]*([[:alnum:].]+[[:space:]]*=[[:space:]]*(?:'[^']*'|[[:digit:].]+))[[:space:]]*,/", $SQLString, 0, PREG_SPLIT_DELIM_CAPTURE|PREG_SPLIT_NO_EMPTY);		for ($i=0; $i<sizeof($FieldArray); $i++) {
			$Assigment = explode('=', $FieldArray[$i]);
			$_SESSION['SQLString']['fields'][$i] = $Assigment[0];
			if (sizeof($Assigment)>1) {
				$_SESSION['SQLString']['values'][$i] = $Assigment[1];
			}
		}
	}

	function DeleteQueryInfo($SQLString) {
		$SQLArray = explode('WHERE', $SQLString);
		$_SESSION['SQLString']['table'] = $SQLArray[0];
		$SQLString = trim(str_replace($SQLArray[0], '', $SQLString));
		$SQLString = trim(str_replace('DELETE', '', $SQLString));
		$SQLString = trim(str_replace('FROM', '', $SQLString));
		$SQLString = trim(str_replace('WHERE', '', $SQLString));
		$Assigment = explode('=', $SQLString);
		$_SESSION['SQLString']['fields'][0] = $Assigment[0];
		$_SESSION['SQLString']['values'][0] = $Assigment[1];
	}

	if ($_POST['SelectedUser'] == 'ALL') {
		$sql="SELECT transactiondate, 
				userid, 
				querystring,
				transactiontime 
			FROM audittrail 
			WHERE transactiondate 
			BETWEEN '". $FromDate."' AND '".$ToDate."'";
	} else {
		$sql="SELECT transactiondate, 
				userid, 
				querystring,
				transactiontime 
			FROM audittrail 
			WHERE userid='".$_POST['SelectedUser']."' 
			AND transactiondate BETWEEN '".$FromDate."' AND '".$ToDate."'";
	}
	$result = DB_query($sql,$db);

    
    echo '<div  id="form_containercommaster" >';
	echo '<u><h3>Complete User Log</h3></u>';
	echo '<table border=0 width="100%" align="center">';
	echo '<tr><th>' . 'Date' . '</th>
			    <th>' . 'Time' . '</th>
				<th>' . 'User' . '</th>
				<th>' . 'Type' . '</th>
				<th>' . 'Table' . '</th>
				<th>' . 'Field Name' . '</th>
				<th>' . 'Value' . '</th></tr>';
	while ($myrow = DB_fetch_array($result)) {
		if (Query_Type($myrow[2]) == 'INSERT') {
			InsertQueryInfo(str_replace("INSERT INTO",'',$myrow[2]));
			$RowColour = '#a8ff90';
		}
		if (Query_Type($myrow[2]) == 'UPDATE') {
			UpdateQueryInfo(str_replace('UPDATE','',$myrow[2]));
			$RowColour = '#feff90';
		}
		if (Query_Type($myrow[2]) == 'DELETE') {
			DeleteQueryInfo(str_replace('DELETE FROM','',$myrow[2]));
			$RowColour = '#fe90bf';
		}

		if ((trim($_SESSION['SQLString']['table']) == $_POST['SelectedTable'])  ||
			($_POST['SelectedTable'] == 'ALL')) {
			if (!isset($_SESSION['SQLString']['values'])) {
				$_SESSION['SQLString']['values'][0]='';
			}
			echo '<tr style="background-color: '.$RowColour.'">
				<td>' . $myrow['transactiondate'] . '</td>
				<td>' . $myrow['transactiontime'] . '</td>
				<td>' . $myrow['userid'] . '</td>
				<td>' . Query_Type($myrow['querystring']) . '</td>
				
				<td>' . $_SESSION['SQLString']['table'] . '</td>
				<td>' . $_SESSION['SQLString']['fields'][0] . '</td>
				<td>' . htmlentities(trim(str_replace("'","",$_SESSION['SQLString']['values'][0]))) . '</td></tr>';
			for ($i=1; $i<sizeof($_SESSION['SQLString']['fields']); $i++) {
				if (isset($_SESSION['SQLString']['values'][$i]) and (trim(str_replace("'","",$_SESSION['SQLString']['values'][$i])) != "") &
				(trim($_SESSION['SQLString']['fields'][$i]) != 'password') &
				(trim($_SESSION['SQLString']['fields'][$i]) != "www_users.password")) {
					echo '<tr bgcolor='.$RowColour.'>';
					echo '<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>';
					echo '<td>'.$_SESSION['SQLString']['fields'][$i].'</td>
						<td>'.htmlentities(trim(str_replace("'","",$_SESSION['SQLString']['values'][$i])), ENT_QUOTES, 'ISO-8859-1').'</td>';
					echo '</tr>';
				}
			}
			echo '<tr bgcolor=black><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
		}
		unset($_SESSION['SQLString']);
	}
	echo '</table></div>';
}


?>