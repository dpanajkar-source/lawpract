<?php

$PageSecurity=6;


include('includes/session.php');


function stripcomma($str) { //because we're using comma as a delimiter
    $str = trim($str);
    $str = str_replace('"', '""', $str);
    $str = str_replace("\r", "", $str);
    $str = str_replace("\n", '\n', $str);
    if($str == "" )
        return $str;
    else
        return '"'.$str.'"';
}

function NULLToZero( &$Field ) {
    if( is_null($Field) )
        return '0';
    else
        return $Field;
}

function NULLToPrice( &$Field ) {
    if( is_null($Field) )
        return '-1';
    else
        return $Field;
}

// EXPORT FOR CONTACT LIST
if ( isset($_POST['Contactlist']) ) {

		$SQL = "SELECT * FROM lw_contacts";
		$ContactsResult = DB_query($SQL,$db);
			
	if (DB_error_no($db) !=0) {
		$title = _('Contacts List Export Problem ....');
		prnMsg( _('The Contacts List could not be retrieved by the SQL because'). ' - ' . DB_error_msg($db), 'error');
		echo '<br><a href="' .$rootpath .'/index.php?' . SID . '">'.  _('Back to the menu'). '</a>';
		if ($debug==1){
			echo '<br>'. $SQL;
		}
		
		exit;
	}
	
	While ($ContactList = DB_fetch_array($ContactsResult,$db)){
						
		$CSVContent .= (stripcomma($ContactList['id']) . ',' . 
			stripcomma($ContactList['name']) . ',' . 
			stripcomma($ContactList['address']) . ',' .
			stripcomma($ContactList['landline']) . ',' .
			stripcomma($ContactList['mobile']) . ',' .
			stripcomma($ContactList['mobile1']) . ',' .
			stripcomma($ContactList['email']) . "\n"
			);
	}
	
	
	header('Content-type: application/csv');
	header('Content-Length: ' . strlen($CSVContent));
	header('Content-Disposition: inline; filename=ContactList.csv');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	echo $CSVContent;
	exit;
		
} elseif ( isset($_POST['casesexportlist']) ) {

//CASES EXPORT LIST
	$sql = "SELECT lw_cases.brief_file,
			lw_contacts.name,
			lw_cases.courtcaseno,
			lw_courts.courtname,
			lw_stages.stage,
			lw_cases.opendt,			
			lw_cases.closedt
			FROM lw_cases INNER JOIN lw_contacts
			ON lw_cases.party=lw_contacts.id INNER JOIN lw_stages
			ON lw_cases.stage = lw_stages.stageid INNER JOIN lw_courts
			ON lw_cases.courtid=lw_courts.courtid AND lw_cases.deleted!=1";
$resultparty=DB_query($sql,$db,'','',false,false);

$no_rows=DB_num_rows($resultparty);


//Oppoparty details are fetched below

$_SESSION['myrowoppoparty']=array();
$k=0;


$sqloppoparty = "SELECT
	lw_contacts.name
	FROM lw_cases INNER JOIN lw_contacts
	ON lw_cases.oppoparty=lw_contacts.id
    AND lw_cases.deleted!=1 ";

	$resultoppoparty=DB_query($sqloppoparty,$db,'','',false,false);

	while ($myrowoppoparty=DB_fetch_array($resultoppoparty)) {
			for($m=0;$m<1;$m++)
			{
			$_SESSION['myrowoppoparty'][$k++]=$myrowoppoparty[$m];
			}
			
	
			}
	
	if (DB_error_no($db) !=0) {
		$title = _('Cases Export List Export Problem ....');
		
		prnMsg( _('The Cases Export  List could not be retrieved by the SQL because'). ' - ' . DB_error_msg($db), 'error');
		echo '<br><a href="' .$rootpath .'/index.php?' . SID . '">'.  _('Back to the menu'). '</a>';
		if ($debug==1){
			echo '<br>'. $SQL;
		}
		
		exit;
	}
	
	$k=0;
	
	While ($CasesList = DB_fetch_array($resultparty,$db)){
		
		$CSVCasesContent .= (stripcomma($CasesList['brief_file']) . ',' . 
			stripcomma($CasesList['name']) . ',' . 
			stripcomma($_SESSION['myrowoppoparty'][$k++]) . ',' . 
			stripcomma($CasesList['courtcaseno']) . ',' .
			stripcomma($CasesList['courtname']) . ',' .
			stripcomma($CasesList['stage']) . ',' .
			stripcomma($CasesList['opendt']) . ',' .
			stripcomma($CasesList['closedt']) . "\n");
	}
	header('Content-type: application/csv');
	header('Content-Length: ' . strlen($CSVCasesContent));
	header('Content-Disposition: inline; filename=CasesList.csv');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	echo $CSVCasesContent;
	exit;
} elseif ( isset($_POST['diarylist']) ) {

	
	$DateString = Date($_SESSION['DefaultDateFormat']);
	
	$date = new DateTime(FormatDateForSQL($DateString));
                   // $date->sub(new DateInterval('P1D'));
	
	/* Now figure out the Transactions data to report for the selections made */
	$sql = 'SELECT lw_trans.currtrandate,lw_trans.prevcourtdate,
					lw_trans.brief_file,
					lw_trans.courtname,
					lw_trans.courtcaseno,
					lw_trans.party,
					lw_trans.oppoparty,
					lw_trans.stage,
					lw_trans.nextcourtdate
					FROM lw_trans WHERE lw_trans.currtrandate="' . $date->format('Y-m-d') . '" ';
		
	$StatementResults=DB_query($sql,$db);

	While ($DiaryList = DB_fetch_array($StatementResults,$db)){
	
	$resultparty=DB_query("SELECT name FROM lw_contacts WHERE lw_contacts.id='" . $DiaryList['party'] . "'",$db);	
				$myrowparty=DB_fetch_array($resultparty);
	  
	  $resultoppoparty=DB_query("SELECT name FROM lw_contacts WHERE lw_contacts.id='" . $DiaryList['oppoparty'] . "'",$db);	
				$myrowoppoparty=DB_fetch_array($resultoppoparty);
			
	$resultstage=DB_query("SELECT stage FROM lw_stages WHERE lw_stages.stageid='" . $DiaryList['stage'] . "'",$db);
			$myrowstage=DB_fetch_array($resultstage);
	
      $resultcourt=DB_query("SELECT courtname FROM lw_courts WHERE lw_courts.courtid='" . $DiaryList['courtname'] . "'",$db);		
			$myrowcourt=DB_fetch_array($resultcourt);
		
		$CSVDiaryContent .= (stripcomma($DiaryList['prevcourtdate']) . ',' . 
			stripcomma($DiaryList['brief_file']) . ',' .
			stripcomma($myrowcourt['courtname']) . ',' .
			stripcomma($DiaryList['courtcaseno']) . ',' .
			stripcomma($myrowparty['name']) . ',' . 
			stripcomma($myrowoppoparty['name']) . ',' . 
			stripcomma($myrowstage['stage']) . ',' .
			stripcomma($DiaryList['nextcourtdate']) . "\n");
	}
	
	header('Content-type: application/csv');
	header('Content-Length: ' . strlen($CSVCasesContent));
	header('Content-Disposition: inline; filename=DiaryList.csv');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	echo $CSVDiaryContent;
	exit;;	
} else { 

	$title = _('Data Exports');
		
	echo '<div class="md-card" style="padding-left:20px; padding-top:20px" >';
		   
	// SELECT EXPORT FOR CONTACTS LIST
	
	echo "<form method='post' action=" . $_SERVER['PHP_SELF'] . "?" . SID . ">";
	// start here  ---------------------------------------------------------------------------------------
	echo '<div class="uk-width-medium-2-2" style="padding-bottom:10px" class="md-input-wrapper">';
  	echo '<div class="uk-grid uk-grid-width-1-2 uk-grid-width-medium-1-2">';
echo '<h3 class="heading_a">Export Data</h3>';
	echo "<div class='uk-width-medium-1-1' style='padding-bottom:10px; padding-yop:10px'>Contacts List Export this</div>";
	
$sql = "SELECT id,
			name,
			address,
			landline,
			mobile,
			email
		FROM lw_contacts";
	$StatementResults=DB_query($sql,$db, $ErrMsg);	
	

	
	echo "<div class='uk-width-medium-1-3' style='padding-bottom:10px'><input type='Submit' name='Contactlist' class='md-btn md-btn-primary' value='" . _('Export now') . "'></div>";
	echo "</form>";

	
	// SELECT EXPORT FOR CASES
	

	// Export Cases
	echo "<form method='post' action=" . $_SERVER['PHP_SELF'] . "?" . SID . ">";
	

	
	echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">' . _('CASES List Export') . '</div>';
	
	echo "<div class='uk-width-medium-1-2' style='padding-bottom:10px'><input type='Submit' name='casesexportlist' class='md-btn md-btn-primary' value='" . _('Export') . "'></div>";
	echo "</form>";

	
	// SELECT EXPORT FOR DIARY TRANSACTIONS
	echo "<form method='post' action=" . $_SERVER['PHP_SELF'] . "?" . SID . ">";

	echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">' . _('Today\'s Entered DIARY Transactions Export');
	echo "</div>";
	echo "<div class='uk-width-medium-1-2' style='padding-bottom:10px'><input type='Submit' name='diarylist' class='md-btn md-btn-primary' value='" . _('Export') . "'></div>";
	echo "</form></div></div></div>";

	}
	
	include('footersrc.php');
?>

