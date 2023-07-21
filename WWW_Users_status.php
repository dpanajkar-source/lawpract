<?php

/* $Revision: 1.35 $ */

$PageSecurity=6;

if (isset($_POST['UserID']) AND isset($_POST['ID'])){
	if ($_POST['UserID'] == $_POST['ID']) {
		$_POST['Language'] = $_POST['UserLanguage'];
	}
}
include('includes/session.php');

$title = _('User Login/out Status');
include('includes/header.php');
include('includes/SQL_CommonFunctions.inc');

echo '<p class="page_title_text"><img src="'.$rootpath.'/css/'.$theme.'/images/group_add.png" title="' . _('Search') . '" alt="">' . ' ' . $title.'<br>';

// Make an array of the security roles
$sql = 'SELECT secroleid, 
		secrolename 
	FROM securityroles ORDER BY secroleid';
$Sec_Result = DB_query($sql, $db);
$SecurityRoles = array();
// Now load it into an array using Key/Value pairs
while( $Sec_row = DB_fetch_row($Sec_Result) ) {
	$SecurityRoles[$Sec_row[0]] = $Sec_row[1];
}
DB_free_result($Sec_Result);

if (isset($_GET['SelectedUser'])){
	$SelectedUser = $_GET['SelectedUser'];
} elseif (isset($_POST['SelectedUser'])){
	$SelectedUser = $_POST['SelectedUser'];
}


if (!isset($SelectedUser)) {

/* If its the first time the page has been displayed with no parameters then none of the above are true and the list of Users will be displayed with links to delete or edit each. These will call the same page again and allow update/input or deletion of the records*/

	$sql = 'SELECT 
			userid,
			realname,
			fullaccess,
			lastvisitdate,
			pagesize,
			loggedin
		FROM www_users';
	$result = DB_query($sql,$db);

	echo '<div id="form_container"><table border=1 align="center">';
	echo "<tr><th>" . _('User Login') . "</th>
		<th>" . _('Real Name') . "</th>
		<th>" . _('Security Role') ."</th>
		<th>" . _('Last Visit') . "</th>
		<th>" . _('Report Size') ."</th>
		<th>" . _('Logged In?') ."</th>
		
	</tr>";

	$k=0; //row colour counter

	while ($myrow = DB_fetch_row($result)) {
		if ($k==1){
			echo '<tr class="EvenTableRows">';
			$k=0;
		} else {
			echo '<tr class="OddTableRows">';
			$k=1;
		}

		$LastVisitDate = ConvertSQLDate($myrow[3]);
		
		/*The SecurityHeadings array is defined in config.php */

		printf("<td>%s</td>
					<td>%s</td>
					<td>%s</td>
					<td>%s</td>
					<td>%s</td>
					<td>%s</td>
					</tr>",
					$myrow[0],
					$myrow[1],
					$SecurityRoles[($myrow[2])],
					$LastVisitDate,
					$myrow[4],
					$myrow[5]);
	} //END WHILE LIST LOOP
	
	echo '</table></div><br>';
} //end of ifs and buts!



?>
