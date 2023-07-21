<?php


// SOME TEST TO ENSURE THAT AT LEAST INCOME AND Liabilities ARE THERE
	$sql= "SELECT COUNT(*) FROM accountsection WHERE sectionid=1";
	$result = DB_query($sql,$db);
	$myrow = DB_fetch_row($result);
	if( $myrow[0] == 0 ) {
		$sql = "INSERT INTO accountsection (
					sectionid,
					sectionname 
				) VALUES (
					1,
					'Assets'
				)";
		$result = DB_query($sql,$db);
	}

	$sql= "SELECT COUNT(*) FROM accountsection WHERE sectionid=2";
	$result = DB_query($sql,$db);
	$myrow = DB_fetch_row($result);
	if( $myrow[0] == 0 ) {
		$sql = "INSERT INTO accountsection (
					sectionid,
					sectionname 
				) VALUES (
					2,
					'Liabilities'
				)";
		$result = DB_query($sql,$db);
	}
// DONE WITH MINIMUM TESTS	


if (isset($Errors)) {
	unset($Errors);
}
	
$Errors = array();	

if (isset($_POST['submit'])) {

	//initialise no input errors assumed initially before we test

	$InputError = 0;
	$i=1;

	/* actions to take once the user has clicked the submit button
	ie the page has called itself with some user input */

	//first off validate inputs sensible
	if (isset($_POST['SectionID'])) {
		$sql="SELECT count(sectionid) 
			FROM accountsection WHERE sectionid='".$_POST['SectionID']."'";
		$result=DB_query($sql, $db);
		$myrow=DB_fetch_row($result);
		if (($myrow[0]!=0 and !isset($_POST['SelectedSectionID']))) {
			$InputError = 1;
			prnMsg('The account section already exists in the database','error');
			$Errors[$i] = 'SectionID';
			$i++;		
		}
	}
	if (strpos($_POST['SectionName'],'&')>0 OR strpos($_POST['SectionName'],"'")>0) {
		$InputError = 1;
		prnMsg('The account section name cannot contain the character' . " '&' " . 'or the character' ." '",'error');
		$Errors[$i] = 'SectionName';
		$i++;		
	} 
	if (strlen($_POST['SectionName'])==0) {
		$InputError = 1;
		prnMsg('The account section name must contain at least one character' ,'error');
		$Errors[$i] = 'SectionName';
		$i++;		
	}
	if (isset($_POST['SectionID']) and (!is_numeric($_POST['SectionID']))) {
		$InputError = 1;
		prnMsg('The section number must be an integer','error');
		$Errors[$i] = 'SectionID';
		$i++;		
	}
	if (isset($_POST['SectionID']) and strpos($_POST['SectionID'],".")>0) {
		$InputError = 1;
		prnMsg( 'The section number must be an integer','error');
		$Errors[$i] = 'SectionID';
		$i++;		
	}

	if (isset($_POST['SelectedSectionID']) and $_POST['SelectedSectionID']!='' AND $InputError !=1) {

		/*SelectedSectionID could also exist if submit had not been clicked this code would not run in this case cos submit is false of course  see the delete code below*/

		$sql = "UPDATE accountsection
				SET sectionname='" . $_POST['SectionName'] . "'
				WHERE sectionid = " . $_POST['SelectedSectionID'];

		$msg ='Record Updated';
	} elseif ($InputError !=1) {

	/*SelectedSectionID is null cos no item selected on first time round so must be adding a record must be submitting new entries in the new account section form */

		$sql = "INSERT INTO accountsection (
					sectionid,
					sectionname )
			VALUES (
				" . $_POST['SectionID'] . ",
				'" . $_POST['SectionName'] ."'
				)";
		$msg ='Record inserted';
	}

	if ($InputError!=1){
		//run the SQL from either of the above possibilites
		$result = DB_query($sql,$db);
		prnMsg($msg,'success');
		unset ($_POST['SelectedSectionID']);
		unset ($_POST['SectionID']);
		unset ($_POST['SectionName']);
	}

} elseif (isset($_GET['delete'])) {
//the link to delete a selected record was clicked instead of the submit button

// PREVENT DELETES IF DEPENDENT RECORDS IN 'accountgroups'
	$sql= "SELECT COUNT(*) FROM accountgroups WHERE sectioninaccounts='" . $_GET['SelectedSectionID'] . "'";
	$result = DB_query($sql,$db);
	$myrow = DB_fetch_row($result);
	if ($myrow[0]>0) {
		prnMsg('Cannot delete this account section because general ledger accounts groups have been created using this section','warn');
		echo '<br>' . 'There are' . ' ' . $myrow[0] . ' ' . 'general ledger accounts groups that refer to this account section' . '</font>';

	} else {
		//Fetch section name
		$sql = "SELECT sectionname FROM accountsection WHERE sectionid='".$_GET['SelectedSectionID'] . "'";
		$result = DB_query($sql,$db);
		$myrow = DB_fetch_row($result);
		$SectionName = $myrow[0];
		
		$sql="DELETE FROM accountsection WHERE sectionid='" . $_GET['SelectedSectionID'] . "'";
		$result = DB_query($sql,$db);
		prnMsg( $SectionName . ' ' . 'section has been deleted' . '!','success');

	} //end if account group used in GL accounts
	unset ($_GET['SelectedSectionID']);
	unset($_GET['delete']);
	unset ($_POST['SelectedSectionID']);
	unset ($_POST['SectionID']);
	unset ($_POST['SectionName']);
}

 if (!isset($_GET['SelectedSectionID']) OR !isset($_POST['SelectedSectionID'])) {

/* An account section could be posted when one has been edited and is being updated 
  or GOT when selected for modification
  SelectedSectionID will exist because it was sent with the page in a GET .
  If its the first time the page has been displayed with no parameters
  then none of the above are true and the list of account groups will be displayed with
  links to delete or edit each. These will call the same page again and allow update/input
  or deletion of the records*/

	$sql = "SELECT sectionid,
			sectionname
		FROM accountsection
		ORDER BY sectionid";

	$ErrMsg ='Could not get account group sections because';
	$result = DB_query($sql,$db,$ErrMsg);
	  
  
	echo '<div class="uk-overflow-container">';
   
     
	echo "<br> <table align='center'; class='uk-table'>
		<tr>
		<th bgcolor='#FFFFCC'>" . 'Section Number' . "</th>
		<th bgcolor='#FFFFCC'>" . 'Section Description' . "</th>
		<th bgcolor='#FFFFCC'>" . 'Edit ' . "</th>
		<th bgcolor='#FFFFCC'>" . 'Delete' . "</th>
		</tr>";

	$k=0; //row colour counter
	while ($myrow = DB_fetch_row($result)) {

		if ($k==1){
			echo '<tr class="EvenTableRows">';
			$k=0;
		} else {
			echo '<tr class="OddTableRows">';
			$k++;
		}

		echo '<td>' . $myrow[0] . '</td><td>' . $myrow[1] . '</td>';
		echo '<td><a href="' . $_SERVER['PHP_SELF'] . '?' . SID . '&SelectedSectionID=' . $myrow[0] . '">' . 'Edit' . '</a></td>';
		if ( $myrow[0] == '1' || $myrow[0] == '2'  || $myrow[0] == '4' || $myrow[0] == '6' || $myrow[0] == '7'   ) {
			echo '<td><b>'.'Restricted'.'</b></td>';
		} else {
			echo '<td><a href="' . $_SERVER['PHP_SELF'] . '?' . SID . '&SelectedSectionID=' . $myrow[0] . '&delete=1">' . 'Delete' .'</a></td>';
		}

	} //END WHILE LIST LOOP
	echo '</div></table>';
} //end of ifs and buts!


if (isset($_POST['SelectedSectionID']) or isset($_GET['SelectedSectionID'])) {
	echo '<div class="centre"><a href=' . $_SERVER['PHP_SELF'] . '?' . SID .'>' . 'Review Account Sections' . '</a></div>';
}



if (! isset($_GET['delete'])) {

	echo "<form method='post' name='AccountSections' action=" . $_SERVER['PHP_SELF'] . '?' . SID . '>';

	if (isset($_GET['SelectedSectionID'])) {
		//editing an existing section

		$sql = "SELECT sectionid,
				sectionname
			FROM accountsection
			WHERE sectionid='" . $_GET['SelectedSectionID'] ."'";

		$result = DB_query($sql, $db);
		if ( DB_num_rows($result) == 0 ) {
			prnMsg('Could not retrieve the requested section please try again.','warn');
			unset($_GET['SelectedSectionID']);
		} else {
			$myrow = DB_fetch_array($result);

			$_POST['SectionID'] = $myrow['sectionid'];
			$_POST['SectionName']  = $myrow['sectionname'];

			echo "<input type=hidden name='SelectedSectionID' value='" . $_POST['SectionID'] . "'>";
			echo "<table align='center'>
			<td>" . 'Section Number' . ':' . "</td>
			<td>" . $_POST['SectionID'] . "</td>";
		}

	}  else {

		if (!isset($_POST['SelectedSectionID'])){
			$_POST['SelectedSectionID']='';
		}
		if (!isset($_POST['SectionID'])){
			$_POST['SectionID']='';
		}
		if (!isset($_POST['SectionName'])) {
			$_POST['SectionName']='';
		}
		
		
		echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Section Number<input tabindex="1" type="text"  class="md-input" size=4 maxlength=4 value="' . $_POST['SectionID'] . '"></div>';
	}
	echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Section Description<input tabindex="2" type="text" name="SectionName" class="md-input" size=30 maxlength=30 value="' . $_POST['SectionName'] . '"></div>';

	echo '<input tabindex="3" type=Submit name=submit class="md-btn md-btn-primary" value=' . 'Enter Information' . '>';

	if (!isset($_GET['SelectedSectionID']) or $_GET['SelectedSectionID']=='') {
		echo "<script>defaultControl(document.AccountSections.SectionID);</script>";
	} else {
		echo "<script>defaultControl(document.AccountSections.SectionName);</script>";
	}

	echo '</form></div>';

} //end if record deleted no point displaying form to add record


?>