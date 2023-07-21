<?php


if (isset($_POST['UserID']) AND isset($_POST['ID'])){
	if ($_POST['UserID'] == $_POST['ID']) {
		$_POST['Language'] = $_POST['UserLanguage'];
	}
}



include('includes/SQL_CommonFunctions.inc');


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

if (isset($_POST['submit'])) {

	//initialise no input errors assumed initially before we test
	$InputError = 0;

	/* actions to take once the user has clicked the submit button
	ie the page has called itself with some user input */

	//first off validate inputs sensible
	if (strlen($_POST['UserID'])<3){
		$InputError = 1;
		prnMsg(_('The user ID entered must be at least 4 characters long'),'error');
	} elseif (ContainsIllegalCharacters($_POST['UserID'])) {
		$InputError = 1;
		prnMsg(_('User names cannot contain any of the following characters') . " - ' & + \" \\ " . _('or a space'),'error');
	} elseif (strlen($_POST['Password'])<5){
		if (!$SelectedUser){
			$InputError = 1;
			prnMsg(_('The password entered must be at least 5 characters long'),'error');
		}
	} elseif (strstr($_POST['Password'],$_POST['UserID'])!= False){
		$InputError = 1;
		prnMsg(_('The password cannot contain the user id'),'error');
	} 
	//comment out except for demo!  Do not want anyone modifying demo user.
	/*
	  elseif ($_POST['UserID'] == 'demo') {
		prnMsg(_('The demonstration user called demo cannot be modified.'),'error');
		$InputError = 1;
	}
	*/
	

	if ($SelectedUser AND $InputError !=1) {

/*SelectedUser could also exist if submit had not been clicked this code would not run in this case cos submit is false of course  see the delete code below*/
		
		$UpdatePassword = "";
		if ($_POST['Password'] != ""){
			$UpdatePassword = "password='" . CryptPass($_POST['Password']) . "',";
		}

		$sql = "UPDATE www_users SET realname='" . $_POST['RealName'] . "',
						" . $UpdatePassword . "
						fullaccess=" . $_POST['Access'] . ",
						pagesize='" . $_POST['PageSize'] . "',
						blocked=" . $_POST['Blocked'] . "
					WHERE userid = '$SelectedUser'";
					
		
		$msg = _('The selected user record has been updated');
	} elseif ($InputError !=1) {

		$sql = "INSERT INTO www_users (userid,
						realname,
						password,
						pagesize,
						fullaccess,
						displayrecordsmax)
					VALUES ('" . $_POST['UserID'] . "',
						'" . $_POST['RealName'] ."',
						'" . CryptPass($_POST['Password']) ."',
						'" . $_POST['PageSize'] ."',
						" . $_POST['Access'] . ",
						" . $_SESSION['DefaultDisplayRecordsMax'] . "
						)";
		$msg = _('A new user record has been inserted');
	}

	if ($InputError!=1){
		//run the SQL from either of the above possibilites
		$ErrMsg = _('The user alterations could not be processed because');
		$DbgMsg = _('The SQL that was used to update the user and failed was');
		$result = DB_query($sql,$db,$ErrMsg,$DbgMsg);
		
		prnMsg(_('The User information is Entered Successfully'), 'Success');

		unset($_POST['UserID']);
		unset($_POST['RealName']);
		unset($_POST['Password']);
		unset($_POST['PageSize']);
		unset($_POST['Access']);
		unset($_POST['Blocked']);
		unset($SelectedUser);
	}

} elseif (isset($_GET['delete'])) {
//the link to delete a selected record was clicked instead of the submit button

	// comment out except for demo!  Do not want anyopne deleting demo user.
	/*
	if ($SelectedUser == 'demo') {
		prnMsg(_('The demonstration user called demo cannot be deleted'),'error');
	} else {
	*/
		$sql='SELECT userid FROM audittrail where userid="'. $SelectedUser .'"';
		$result=DB_query($sql, $db);
		if (DB_num_rows($result)!=0) {
			prnMsg(_('Cannot delete user as entries already exist in the audit trail'), 'warn');
		} else {

			$sql="DELETE FROM www_users WHERE userid='$SelectedUser'";
			$ErrMsg = _('The User could not be deleted because');;
			$result = DB_query($sql,$db,$ErrMsg);
			prnMsg(_('User Deleted'),'info');
		}
		unset($SelectedUser);
	// }

}

if (!isset($SelectedUser)) {

/* If its the first time the page has been displayed with no parameters then none of the above are true and the list of Users will be displayed with links to delete or edit each. These will call the same page again and allow update/input or deletion of the records*/

} //end of ifs and buts!

    
   
	echo '<div class="uk-overflow-container">';
if (isset($SelectedUser)) {
	echo "<br><a href='" . $_SERVER['PHP_SELF'] ."?" . SID . "'>" . _('Review Existing Users') . '</a>';
}

echo "<form method='post' action=" . $_SERVER['PHP_SELF'] . "?" . SID . ">";

if (isset($SelectedUser)) {
	//editing an existing User

	$sql = "SELECT userid,
			realname,
			password,
			pagesize,
			fullaccess,
			blocked		
		FROM www_users
		WHERE userid='" . $SelectedUser . "'";

	$result = DB_query($sql, $db);
	$myrow = DB_fetch_array($result);
	
	
	$_POST['UserID'] = $myrow['userid'];
	$_POST['RealName'] = $myrow['realname'];
	$_POST['PageSize'] = $myrow['pagesize'];
	$_POST['Access'] = $myrow['fullaccess'];
	$_POST['Blocked'] = $myrow['blocked'];
	
	
	echo "<input type='hidden' name='SelectedUser' value='" . $SelectedUser . "'>";
	echo "<input type='hidden' name='UserID' value='" . $_POST['UserID'] . "'>";
	
		echo '<div class="md-input-wrapper"><div><div class="md-card-content">';
		echo '<div class="uk-grid uk-grid-width-1-3 uk-grid-width-large-1-2">';

echo '<div class="uk-width-medium-1-3" style="padding-bottom:10px"><h4>' . _('Selected User Name - ');
	echo $_POST['UserID'] . '</h4></div>';


} else { //end of if $SelectedUser only do the else when a new record is being entered
		echo '<div class="md-input-wrapper"><div><div class="md-card-content">';
		echo '<div class="uk-grid uk-grid-width-1-3 uk-grid-width-large-1-2">';
		
		echo '<div class="uk-width-medium-1-3" style="padding-bottom:10px">Enter User Login Name
			<input type="text" tabindex="1" name="UserID" class=md-input data-uk-tooltip="{cls:\'long-text\'}"  title="Enter a unique user name in this field. This will be used by the user to login into Lawpract"></div>';
	
		
	/*set the default modules to show to all
	this had trapped a few people previously*/
	
}

if (!isset($_POST['Password'])) {
	$_POST['Password']='';
}
if (!isset($_POST['RealName'])) {
	$_POST['RealName']='';
}




echo "<div class='uk-width-medium-1-3' style='padding-bottom:10px'>Real Name
	<input type='text' name='RealName' class='md-input' tabindex='2' value='" . $_POST['RealName'] . "' data-uk-tooltip=\"{cls:'long-text'}\"  title=\"Enter your full name here. This is only for administrative purpose \"></div>";
	
echo "<div class='uk-width-medium-1-3' style='padding-bottom:10px'>Password <input type='password' name='Password' class='md-input' tabindex='3' value='" . $_POST['Password'] . "' data-uk-tooltip=\"{cls:'long-text'}\"  title=\"Enter a secure password consisting of at least 6 alphabets. It should contain a capital letter,a number, any other characters like $,#,@,%,*,! etc. Please keep this password secure. Do not give this password to any other person. Not even to your colleagues\"></div>";


echo "<div class='uk-width-medium-1-3' style='padding-bottom:10px'>Security Role <select name='Access' tabindex='4' class='md-input'>";

foreach ($SecurityRoles as $SecKey => $SecVal) {
	if (isset($_POST['Access']) and $SecKey == $_POST['Access']){
		echo "<option selected value=" . $SecKey . ">" . $SecVal;
	} else {
		echo "<option value=" . $SecKey . ">" . $SecVal;
	}
}
echo '</select></div>';
echo '<input type="hidden" name="ID" value="'.$_SESSION['UserID'].'">';


echo "<div class='uk-width-medium-1-3' style='padding-bottom:10px'>Reports Page Size <select name='PageSize' tabindex='5' class='md-input'>";

if(isset($_POST['PageSize']) and $_POST['PageSize']=='A4'){
	echo "<option selected value='A4'>" . _('A4');
} else {
	echo "<option value='A4'>A4";
}

if(isset($_POST['PageSize']) and $_POST['PageSize']=='A3'){
	echo "<option selected Value='A3'>" . _('A3');
} else {
	echo "<option value='A3'>A3";
}

if(isset($_POST['PageSize']) and $_POST['PageSize']=='A3_landscape'){
	echo "<option selected Value='A3_landscape'>" . _('A3') . ' ' . _('landscape');
} else {
	echo "<option value='A3_landscape'>" . _('A3') . ' ' . _('landscape');
}

if(isset($_POST['PageSize']) and $_POST['PageSize']=='letter'){
	echo "<option selected Value='letter'>" . _('Letter');
} else {
	echo "<option value='letter'>" . _('Letter');
}

if(isset($_POST['PageSize']) and $_POST['PageSize']=='letter_landscape'){
	echo "<option selected Value='letter_landscape'>" . _('Letter') . ' ' . _('landscape');
} else {
	echo "<option value='letter_landscape'>" . _('Letter') . ' ' . _('landscape');
}

if(isset($_POST['PageSize']) and $_POST['PageSize']=='legal'){
	echo "<option selected value='legal'>" . _('Legal');
} else {
	echo "<option Value='legal'>" . _('Legal');
}
if(isset($_POST['PageSize']) and $_POST['PageSize']=='legal_landscape'){
	echo "<option selected value='legal_landscape'>" . _('Legal') . ' ' . _('landscape');
} else {
	echo "<option value='legal_landscape'>" . _('Legal') . ' ' . _('landscape');
}

echo '</select></div>';


echo "<div class='uk-width-medium-1-3' style='padding-bottom:10px'>Account Status <select name='Blocked' tabindex='6' class='md-input'>";
if ($_POST['Blocked']==0){
	echo '<option selected value=0>' . _('Open');
	echo '<option value=1>' . _('Blocked');
} else {
 	echo '<option selected value=1>' . _('Blocked');
	echo '<option value=0>' . _('Open');
}
echo '</select></div>';

echo '<br><div style="margin-bottom:20px; margin-top:20px"><input type="submit" name="submit" value="' . _('Enter Information') . '" class="md-btn md-btn-primary"></div></div></div></form>';
	
	
	if($_SESSION['AccessLevel']==1)
	{
	$sql = 'SELECT 
			userid,
			realname,			
			date_format(lastvisitdate,"%d/%m/%Y %H:%i:%S") as lastvisitdate,
			fullaccess,
			pagesize
		FROM www_users';
	
	}else
	
	{

	$sql = 'SELECT 
			userid,
			realname,
			date_format(lastvisitdate,"%d/%m/%Y %H:%i:%S") as lastvisitdate,
			fullaccess,
			pagesize
		FROM www_users WHERE userid="' . $_SESSION['UserID'] . '"';
		
	}
	$result = DB_query($sql,$db);

    echo '<div class="uk-overflow-container"><table border=1 align="center" class="uk-table">';
	echo "<thead><tr><th>" . _('User Login') . "</th>
		<th>" . _('Full Name') . "</th>
		<th>" . _('Last Visit') . "</th>
		<th>" . _('Security Role') ."</th>
		<th>" . _('Report Size') ."</th>
		</tr></thead>";

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
					<td><a href=\"%s&SelectedUser=%s\">" . _('Edit') . "</a></td>
					<td><a href=\"%s&SelectedUser=%s&delete=1\">" . _('Delete') . "</a></td>
					</tr>",
					$myrow[0],
					$myrow[1],
					$myrow[2],
					$myrow[3],
					$myrow[4],
					$_SERVER['PHP_SELF']  . "?" . SID,
					$myrow[0],
					$_SERVER['PHP_SELF'] . "?" . SID,
					$myrow[0]);

	} //END WHILE LIST LOOP
	echo '</table></div></div>';

if (isset($_GET['SelectedUser'])) {
	echo '<script  type="text/javascript">defaultControl(document.forms[0].Password);</script>';
} else {
	echo '<script  type="text/javascript">defaultControl(document.forms[0].UserID);</script>';
}
?>
