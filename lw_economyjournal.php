<?php
 
/* $Revision: 1.27 $ */

include('includes/DefineJournalClass.php');

	
$PageSecurity = 13;
include('includes/session.php');
?>
<script type="text/javascript">

function calcBalance() {

var tlg=document.getElementById("Total_Legalfees").value;
var cf=document.getElementById("Court_Fees").value;
var mf=document.getElementById("Misc_Fees").value;
var ar=document.getElementById("Amount_Received").value;

balance=parseInt(tlg) + parseInt(cf)+parseInt(mf)-parseInt(ar);

document.getElementById("Balance").value=balance;
}

</script>



<?php
include('includes/header.php');

include('includes/SQL_CommonFunctions.inc'); 

if (isset($Errors)) 
{
	unset($Errors);
}
$Errors = array();

/*ContactId could be set from a post or a get when passed as a parameter to this page */



if (isset($_POST['Brief_File_No'])){
	$Brief_File_No = $_POST['Brief_File_No'];
} elseif (isset($_GET['Brief_File_No'])){
	$Brief_File_No = $_GET['Brief_File_No'];
}

if (isset($_POST['Brief_File_Search'])){
	
	
	$sql="SELECT brief_file from lw_partytrans WHERE brief_file='" . $_POST['Brief_File_Search'] . "' ORDER BY ID DESC LIMIT 1" ;
	
	$result=DB_query($sql,$db);
	$myrowbriefpartytrans=DB_fetch_array($result);

if(	isset($myrowbriefpartytrans[0]))
{

$Brief_File_Search = $_POST['Brief_File_Search'];
}else
{
$Brief_File_Search='';

}
	
} elseif (isset($_GET['Brief_File_Search'])){
	$Brief_File_Search = $_GET['Brief_File_Search'];
}

if (isset($_POST['Partyname_Search'])){
	$SearchName = $_POST['Partyname_Search'];
	
	
	
	
} elseif (isset($_GET['Partyname_Search'])){
	$SearchName = $_GET['Partyname_Search'];
}



if (isset($_POST['submit'])) 
{

	//initialise no input errors assumed initially before we test
	$InputError = 0;
	$i=1;

	/* actions to take once the user has clicked the submit button
	ie the page has called itself with some user input */

	if ($InputError !=1)
	{

		
		
		if (!isset($_POST['New'])) // This is the update mode
		{
		
		 

			  $sql = "INSERT INTO lw_partytrans(
							brief_file,
							courtcaseno,
							glcode,
							totalfees,
							miscfees,
							courtfees,
							amountreceived,
							receivedt,
							chequeno,
							chequedate,
							bankname,
							narration						
							)
				VALUES ('" . trim($_POST['Brief_File_No']) ."',
					'" . trim($_POST['Courtcaseno']) . "',
					'" . trim($_POST['GLcode']) . "',
					'" . trim($_POST['Totalfees']) . "',
					'" . trim($_POST['Miscfees']) . "',
					'" . trim($_POST['Courtfees']) . "',
					'" . trim($_POST['Amountreceived']) . "',
					'" . $_POST['Receivedt'] . "',
					'" . trim($_POST['Chequeno']) . "',
					'" . $_POST['Chequedt'] . "',
					'" . trim($_POST['Bankname']) . "',
					'" . trim($_POST['Narration']) . "'				
					)";

			 			
			// end of if (!isset($_POST['New'])) for update mode

			$ErrMsg = _('The Economy Entry could not be updated because');
			$result = DB_query($sql,$db,$ErrMsg);
			
			prnMsg( _('Economy Entry Inserted'),'success');
			echo '<br>';
			
			

		} //end of (!isset($_POST['New'])) ie update mode if condition ends here
		
		else  //insert mode for new economy starts
		{ //it is a new brief_file economy entry
		
		
		$glcode=$_POST['Brief_File_No'] . $_POST['Courtcaseno'];
		
				
			//below is for inserting data in lw_economy table only once in the beginning			
			 $sql = "INSERT INTO lw_partytrans(
							brief_file,
							courtcaseno,
							glcode,
							totalfees,
							miscfees,
							courtfees,
							amountreceived,
							receivedt,
							chequeno,
							chequedate,
							bankname,
							narration						
							)
				VALUES ('" . trim($_POST['Brief_File_No']) ."',
					'" . trim($_POST['Courtcaseno']) . "',
					'" . $glcode . "',
					'" . trim($_POST['Totalfees']) . "',
					'" . trim($_POST['Miscfees']) . "',
					'" . trim($_POST['Courtfees']) . "',
					'" . trim($_POST['Amountreceived']) . "',
					'" . trim(FormatDateForSQL($_POST['Receivedt'])) . "',
					'" . trim($_POST['Chequeno']) . "',
					'" . trim(FormatDateForSQL($_POST['Chequedt'])) . "',
					'" . trim($_POST['Bankname']) . "',
					'" . trim($_POST['Narration']) . "'				
					)";

			$ErrMsg = _('This Economy Entry could not be added because');
			$result = DB_query($sql,$db,$ErrMsg);
			
			
			 
						
			prnMsg(_('Economy Entry Created'),'Success');
						
			
			
					
			//Below is the code to create GL account code for the Party automatically once the new case is created
			
			/*$sqlnextaccountcode='SELECT accountcode from chartdetails ORDER BY accountcode DESC limit 1';
			
			$resultnew = DB_query($sqlnextaccountcode,$db);
	$myrownew = DB_fetch_array($resultnew);
	
	$nextaccountcode=$myrownew['accountcode']+20;
	
	$accountname=$_POST['Brief_File'] . $_POST['Party'] . $_POST['Oppoparty'];
				
			$sql = 'INSERT INTO chartmaster (accountcode,
						accountname,
						group_)
					VALUES (' . $nextaccountcode . ",
						'" . $accountname . "',
						'Operating Expenses')";
		$result = DB_query($sql,$db,$ErrMsg);

		/*Add the new chart details records for existing periods first

		$ErrMsg = _('Could not add the chart details for the new account');

		$sql = 'INSERT INTO chartdetails (accountcode, period)
				SELECT chartmaster.accountcode, periods.periodno
					FROM chartmaster
						CROSS  JOIN periods
				WHERE ( chartmaster.accountcode, periods.periodno ) NOT
					IN ( SELECT chartdetails.accountcode, chartdetails.period FROM chartdetails )';

		$result = DB_query($sql,$db,$ErrMsg);

		prnMsg(_('The new general ledger account has been added'),'success');*/ 


//From below four GL entries will be done in GLtrans table for every case/bank entry from lw_economyjournal form

$DateString = Date($_SESSION['DefaultDateFormat']);
$PeriodNo = GetPeriod($_SESSION['JournalDetail']->JnlDate,$db);
$TransNo = GetNextTransNo( 0, $db);

$SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount,
						tag) ';
		$SQL= $SQL . 'VALUES (0,
					' . $TransNo . ",
					'" . FormatDateForSQL($DateString) . "',
					" . $PeriodNo . ",
					" . $glcode . ",
					'" . $_POST['Narrative'] . "',
					" .  $_POST['Amountreceived'] . ",
					0)";
		$ErrMsg = _('Cannot insert a GL entry for the journal line because');
		$DbgMsg = _('The SQL that failed to insert the GL Trans record was');
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);



//Second GLentry is credit professional fee GL account with Amount Received

$DateString = Date($_SESSION['DefaultDateFormat']);
$PeriodNo = GetPeriod($_SESSION['JournalDetail']->JnlDate,$db);
$TransNo = GetNextTransNo( 0, $db);

$glcode=7260;

$SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount,
						tag) ';
		$SQL= $SQL . 'VALUES (0,
					' . $TransNo . ",
					'" . FormatDateForSQL($DateString) . "',
					" . $PeriodNo . ",
					" . $glcode . ",
					'" . $_POST['Narrative'] . "',
					" .  '-' . $_POST['Amountreceived'] . ",
					0)";
		$ErrMsg = _('Cannot insert a GL entry for the journal line because');
		$DbgMsg = _('The SQL that failed to insert the GL Trans record was');
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);



//Second GLentry is debit Cash GL account with Amount Received

$DateString = Date($_SESSION['DefaultDateFormat']);
$PeriodNo = GetPeriod($_SESSION['JournalDetail']->JnlDate,$db);
$TransNo = GetNextTransNo( 0, $db);

$glcode=1020;

$SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount,
						tag) ';
		$SQL= $SQL . 'VALUES (0,
					' . $TransNo . ",
					'" . FormatDateForSQL($DateString) . "',
					" . $PeriodNo . ",
					" . $glcode . ",
					'" . $_POST['Narrative'] . "',
					" .  $_POST['Amountreceived'] . ",
					0)";
		$ErrMsg = _('Cannot insert a GL entry for the journal line because');
		$DbgMsg = _('The SQL that failed to insert the GL Trans record was');
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);



//Second GLentry is credit Another GL account with Amount Received

$DateString = Date($_SESSION['DefaultDateFormat']);
$PeriodNo = GetPeriod($_SESSION['JournalDetail']->JnlDate,$db);
$TransNo = GetNextTransNo( 0, $db);

$glcode=7260;

$SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount,
						tag) ';
		$SQL= $SQL . 'VALUES (0,
					' . $TransNo . ",
					'" . FormatDateForSQL($DateString) . "',
					" . $PeriodNo . ",
					" . $glcode . ",
					'" . $_POST['Narrative'] . "',
					" .  '-' . $_POST['Amountreceived'] . ",
					0)";
		$ErrMsg = _('Cannot insert a GL entry for the journal line because');
		$DbgMsg = _('The SQL that failed to insert the GL Trans record was');
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);

















			
		}//end of insert new contact ends
			unset($Brief_File_Search); 
			unset($SearchName);
	} // end of $inputError!=1 if condition first loop
	
else  
{
	prnMsg( _('Validation failed') . '. ' . _('No updates or deletes took place'),'error');
} //end of if ($InputError !=1) condition completely

} // end of if (isset($_POST['submit']))

elseif (isset($_POST['delete']))
 {

//the link to delete a selected record was clicked instead of the submit button

	$CancelDelete = 0;

// PREVENT DELETES IF DEPENDENT RECORDS IN 'lw_Trans'

	$sql= "SELECT COUNT(*) FROM lw_economy WHERE brief_file='" . $_POST['Brief_file'] . "'";
	$result = DB_query($sql,$db);
	$myrow = DB_fetch_row($result);
	if ($myrow[0]>0) 
	{
		$CancelDelete = 1;
		prnMsg( _('This Economy Entry cannot be deleted because there are transactions that refer to it'),'warn');
		echo '<br> ' . _('There are') . ' ' . $myrow[0] . ' ' . _('transactions against this Brief_File No');

	}// end of if ($myrow[0]>0)  condition
	

	if ($CancelDelete==0)
	 { //ie not cancelled the delete as a result of above tests
	 
	
		$sql="DELETE FROM lw_economy WHERE brief_file='" . $_POST['Brief_File'] . "'";
		$result = DB_query($sql,$db);
		$sql="DELETE FROM lw_contacts WHERE id='" . $_POST['ContactId'] . "'";
		$result = DB_query($sql,$db);
		prnMsg( _('Economy Entry') . ' ' . $_POST['ContactId'] . ' ' . _('has been deleted - together with all the associated contacts') . ' !','success');
		
		exit;
	} //end if Delete contact
}//end of if (isset($_POST['delete'])) condition

if(isset($reset))
{
	                unset($_POST['GLcode']);
			        unset( $_POST['Brief_File']);
					unset( $_POST['Courtcaseno']);
					unset($_POST['Total_Fees']);
					unset($_POST['Court_Fees']);
					unset( $_POST['Misc_Fees']);
					unset($_POST['Amount_Received']);
					unset($_POST['Receivedt']);
					unset($_POST['ID']);
						
}


?>

 
<div style="float:center; border:inset; margin-left:200px; width:594px; height:55px; background-color: #FFFF99; margin-top:30px; margin-bottom:1px"  >

<form action="<?php echo $_SERVER['PHP_SELF'] . '?' . SID; ?>" method="post">


<table align="center" style="text-align:center; margin-top:-20px;">


<tr>
<td><label>Brief_File No:</label><br>
<?php 


echo '<input name="Brief_File_Search"  id="Brief_File_Search" list="brief_file_search" >';

echo '<datalist id="brief_file_search">';

$result=DB_query("SELECT brief_file FROM lw_cases",$db);

echo '<select tabindex="15" name=brief_fileno>';

while ($myrow = DB_fetch_array($result)) {
	echo "<option VALUE='". $myrow['brief_file'] . "'>" . $myrow['brief_file'] . '</option>';
	} //end while loop

DB_free_result($result);

echo '</select>&nbsp;&nbsp;'; ?>
</datalist>
	
</td>
<td><label>OR</label></td>
<br>
<td><label>Party Name:</label><br>
<input name="Partyname_Search" id="Partyname_Search" list="partyname_search"></td>
<datalist id="partyname_search">


<?php

$sql="SELECT lw_casedetails.contactnameid,lw_contacts.name from lw_casedetails INNER JOIN lw_contacts
      ON lw_casedetails.contactnameid=lw_contacts.id WHERE lw_casedetails.role='party'";

$result=DB_query("$sql",$db);

echo '<select tabindex="16" name="party">';

while ($myrow = DB_fetch_array($result)) {
	echo "<option VALUE='". $myrow[1] . "'>" . $myrow['name'] . '</option>';
	} //end while loop

DB_free_result($result);

echo '</select>';?>
</datalist>
</td>
<td colspan="6" align="center">

<input type="submit" name="Search" VALUE="<?php echo _('Search Now'); ?>">

</form>
</td>




</table>
</div>


<?php

if (isset($_POST['Search']) ){
	
	if ($_POST['Partyname_Search'] AND $_POST['Brief_File_Search']=="") {
		$msg=_('Search Result: Party Name has been used in search');
		
	}
	if ($_POST['Brief_File_Search'] AND $_POST['Partyname_Search']=="") {
		$msg=_('Search Result:  Brief_File Number has been used in search');
		
	}
	
	} 
	
	

if (!isset($Brief_File_No) AND !isset($SearchName))
 {

/*If the page was called without $_POST['Brief_File_No'] passed to page then assume a new Economy Entry is to be entered show a form with a Brief_File No field other wise the form showing the fields with the existing entries against the Economy Entry  will show for editing with only a hidden id field*/
  
	
	
	
			echo "<form enctype='multipart/form-data' method='post' action=" . $_SERVER['PHP_SELF'] . '>';

			echo "<input type='Hidden' name='New' value='Yes'>";

			$DataError =0; 
			echo '<div  id="form_containereconomy" >';
    	?>
  			<div id="maintop" style="width:90%; float:left; position:relative; margin-top:10px; margin-left:30px">

   			 <label>Enter Payment Received</label>
             
       <?php
			echo '<fieldset>
			<table width="100" border="0" align="left" style="margin-top:0px" >
       		 <tr><td><label>' . _('Brief_File No:') . '</label><br>';
			echo '<input type="Text" name="Brief_File_No"  id="Brief_File_No"></td>';

			echo '<td><label>' . _('Court Case No') . ':</label>
			<input tabindex=2 type="Text" name="Courtcaseno" id="Courtcaseno" size=30 maxlength=28></td></tr><br>';
		
			echo '<tr><td><label>' . _('Party Name') . ':</label>
			<input tabindex=2 type="Text" name="Partyname" id="Partyname" size=45 maxlength=28></td>';
		
			echo '<td><label>' . _('Total Legal Fees') . ':</label>
			<input tabindex=2 type="Text" name="Totalfees" id="Totalfees" class=number size=30 maxlength=28 placeholder="Number"></td></tr>';
		
			echo '<tr><td></td></tr></table></fieldset><br>';
			
			
		?>

  			
            <table width="350" height="20" border="0" align="left" style="margin-left:0px" >
	      	<tr>
		   <label>
              <input type="radio" name="C_Radio" checked="checked" id="Cash_Radio">
              CASH</label>&nbsp;&nbsp;
            <label>
              <input type="radio" name="C_Radio"  id="Cheque_Radio">
              CHEQUE</label>&nbsp;&nbsp;
           <label>
              <input type="radio" name="C_Radio"  id="Neft_Radio">
              NEFT/RTGS </label>

             
      	 	  </tr>
			  </table>	
    		
       	  <div id="leftcenter" style="width:50%; float:left; position:fixed; margin-top:10px; margin-left:10px">
          
   	 <?php 
			
	 $DateString = Date($_SESSION['DefaultDateFormat']);
			echo '<table><tr><td><label>' . _('Cheque No') . ':</label>
			<br><input tabindex=2 type="Text" name="Chequeno" id="Chequeno"  size=30 maxlength=28></td></tr>';
			echo '<tr><td><label>' . _('Cheque Date') . ':</label>
			<br><input tabindex=2 type="Text" name="Chequedt" id="Chequedt" class=date alt="'.$_SESSION['DefaultDateFormat'].'" value="' . $DateString . '"  size=30 maxlength=28></td></tr>';
			echo '<tr><td><label>' . _('Bank Name') . ':</label>
			<br><input tabindex=2 type="Text" name="Bankname" id="Bankname"  size=30 maxlength=28></td></tr>';
			echo '<tr><td><label>' . _('Narration') . ':</label>
			<br><input tabindex=2 type="Text" name="Narration" id="Narration" size=30 maxlength=30 ></td></tr>
			</table>';


	 ?>	
    	</div>
                
        	
        
   		<div id="rightcenter" style="width:50%; float:right; position: fixed; margin-top:10Px; margin-left:270px">
	<?php
		
		
    		echo '<table><tr><td><label>' . _('Received Date') . ':</label>
			<br><input tabindex=2 type="Text" name="Receivedt" id="Receivedt" class=date alt="'.$_SESSION['DefaultDateFormat'].'" value="' . $DateString . '" size=20 maxlength=28></td></tr>';
			 echo '<table><tr><td><label>' . _('Misc. Fees') . ':</label>
			<br><input tabindex=2 type="Text" name="Miscfees" id="Miscfees"  size=30 maxlength=28></td></tr>';
			
			echo '<table><tr><td><label>' . _('Court Fees') . ':</label>
			<br><input tabindex=2 type="Text" name="Courtfees" id="Courtfees"  size=30 maxlength=28></td></tr>';
			
			echo '<table><tr><td><label>' . _('Amount Received') . ':</label>
			<br><input tabindex=2 type="Text" name="Amount" id="Amount" class=number size=30 maxlength=28 placeholder="Number"></td>
			</tr>';
			
			echo '<tr><td><label>' . _('Balance Remaining') . ':</label>
			<br><input tabindex=2 type="Text" name="Balance" id="Balance" disabled="disabled" size=30 maxlength=28 placeholder="Total Balance" 	
			onclick="calcBalance()">
			</td></tr>';
		
		
    	// main div ends here------------------------------------------->---->>
    ?>
      	</table>
		</div></div>
    
    
	<?php
		
	
		if ($DataError ==0)
		{
		echo "<div class='buttonseconomy'><input tabindex=20 type='Submit' name='submit' value='" . _('Save') . "'><input tabindex=21 type=submit 	
		action=RESET VALUE='" . _('Reset') . "'><input tabindex=22 type=submit VALUE='" . _('Back') . "'></div>";
		}
	
		echo '</div></form>';

		} //end of 1st if of showing form fields when page first loads
		else
		{

	//Economy Entry exists - either passed when calling the form or from the form itself- ie Edit mode, form fields will populate with table values


	if (!isset($_POST['New']) OR isset($Brief_File_Search) OR isset($SearchName)) {
	
		if($SearchName) {
		
		$sqlcontactnamefetch="SELECT 
					lw_contacts.id					
			FROM lw_contacts
				WHERE lw_contacts.name LIKE '%" . trim($SearchName) . "%'";
			
			$resultcontactidfetch=DB_query($sqlcontactnamefetch,$db);
			
			$myrowcontactidfetch=DB_fetch_array($resultcontactidfetch);
				
			$sqlpartytrans = "SELECT lw_partytrans.id,
				lw_contacts.name,
				lw_partytrans.brief_file,
				lw_partytrans.courtcaseno,
				lw_partytrans.glcode,
				lw_partytrans.totalfees,
				lw_partytrans.miscfees,
				lw_partytrans.courtfees,
				lw_partytrans.amountreceived,
				lw_partytrans.receivedt,
				lw_partytrans.chequeno,
				lw_partytrans.chequedate,
				lw_partytrans.bankname,
				lw_partytrans.narration
				FROM lw_casedetails INNER JOIN lw_partytrans
				ON lw_casedetails.brief_file=lw_partytrans.brief_file INNER JOIN lw_contacts
				ON lw_casedetails.contactnameid=lw_contacts.id
			WHERE lw_contacts.id = '" . trim($myrowcontactidfetch[0]) . "'
			AND lw_casedetails.role='party'";
						
			} elseif ($Brief_File_Search)
			
			{
			
						
			$sqlpartytrans = "SELECT lw_partytrans.id,
				lw_contacts.name,
				lw_partytrans.brief_file,
				lw_partytrans.courtcaseno,
				lw_partytrans.glcode,
				lw_partytrans.totalfees,
				lw_partytrans.miscfees,
				lw_partytrans.courtfees,
				lw_partytrans.amountreceived,
				lw_partytrans.receivedt,
				lw_partytrans.chequeno,
				lw_partytrans.chequedate,
				lw_partytrans.bankname,
				lw_partytrans.narration
				FROM lw_casedetails INNER JOIN lw_partytrans
				ON lw_casedetails.brief_file=lw_partytrans.brief_file INNER JOIN lw_contacts
				ON lw_casedetails.contactnameid=lw_contacts.id
			WHERE lw_casedetails.brief_file = '" . trim($Brief_File_Search) . "'
			AND lw_casedetails.role='party'";
					
			}
			
			//The above code needs to be completed

		$ErrMsg = _('The Party Transaction details could not be retrieved for editing because');
		$result = DB_query($sqlpartytrans,$db,$ErrMsg);

        $myrow = DB_fetch_array($result);

		
		$_POST['ID'] = $myrow['id'];
		$_POST['Partyname'] = $myrow['name'];
		$_POST['Brief_File_No'] = $myrow['brief_file'];
		$_POST['Courtcaseno'] = $myrow['courtcaseno'];
		$_POST['GLcode'] = $myrow['glcode'];
		$_POST['Totalfees'] = $myrow['totalfees'];
		$_POST['Miscfees'] = $myrow['miscfees'];
		$_POST['Courtfees'] = $myrow['courtfees'];
		$_POST['Amountreceived'] = $myrow['amountreceived'];
		$_POST['Receivedt'] = $myrow['receivedt'];
		$_POST['Chequeno'] = $myrow['chequeno'];
		$_POST['Chequedt'] = $myrow['chequedate'];
		$_POST['Bankname'] = $myrow['bankname'];
		$_POST['Narration'] = $myrow['narration'];
		
			
	
	echo "<form enctype='multipart/form-data' method='post' action=" . $_SERVER['PHP_SELF'] . '>';

			echo '<div  id="form_containereconomy" >';
    	?>
  			<div id="maintop" style="width:90%; float:left; position:relative; margin-top:10px; margin-left:30px">

   			 <label>Enter Payment Received</label>
             
       <?php
			echo '<fieldset>
			<table width="100" border="0" align="left" style="margin-top:0px" >
       		 <tr><td><label>' . _('Brief_File No:') . '</label><br>';
			
			echo '<input type="Text" name="Brief_File_No"  id="Brief_File_No" value="' . $_POST['Brief_File_No']  . '" >';
			
			echo '<tr><td><label>' . _('ID:') . '</label><br>';
			
			echo '<input type="Text" name="ID"  id="ID" value="' . $_POST['ID']  . '" >';


			echo '<td><label>' . _('Court Case No') . ':</label>
			<input tabindex=2 type="Text" name="Courtcaseno" id="Courtcaseno" value="' . $_POST['Courtcaseno']  . '" size=30 maxlength=28></td></tr><br>';
			
			echo '<td><label>' . _('GL Code') . ':</label>
			<input tabindex=2 type="Text" name="GLcode" id="GLcode" value="' . $_POST['GLcode']  . '" size=50 maxlength=50></td></tr><br>';
		
			echo '<tr><td><label>' . _('Party Name') . ':</label>
			<input tabindex=2 type="Text" name="Partyname" id="Partyname" value="' . $_POST['Partyname']  . '" size=45 maxlength=28></td>';
		
			echo '<td><label>' . _('Total Legal Fees') . ':</label>
			<input tabindex=2 type="Text" name="Totalfees" id="Totalfees" class=number value="' . $_POST['Totalfees']  . '" size=30 maxlength=28 placeholder="Number"></td></tr>';
		
			echo '<tr><td></td></tr></table></fieldset>';
			
		
               		
       	 echo '<div id="leftcenter" style="width:50%; float:left; position:absolute; margin-top:0px; margin-left:10px">';
        
	 $DateString = Date($_SESSION['DefaultDateFormat']);
	 
			echo '<td><label>' . _('Amount Received') . ':</label>
			<input tabindex=2 type="Text" name="Amountreceived" id="Amountreceived" class=number value="' . $_POST['Amountreceived']  . '" size=30 maxlength=28 placeholder="Number"></td></tr>';
		
    		echo '<table><tr><td><label>' . _('Received Amount Date') . ':</label>
			<br><input tabindex=2 type="Text" name="Receivedt" id="Receivedt" class=date alt="'.$_SESSION['DefaultDateFormat'].'" value="' . $_POST['Receivedt'] . '" size=20 maxlength=28></td></tr>';
			echo '<tr><td><label>' . _('Cheque No') . ':</label>
			<br><input tabindex=2 type="Text" name="Chequeno" id="Chequeno" value="' . $_POST['Chequeno'] . '"  size=30 maxlength=28></td></tr>';
			echo '<tr><td><label>' . _('Cheque Date') . ':</label>
			<br><input tabindex=2 type="Text" name="Chequedt" id="Chequedt" class=date alt="'.$_SESSION['DefaultDateFormat'].'" value="' . $_POST['Chequedt'] . '"  size=30 maxlength=28></td></tr>';
			echo '<tr><td><label>' . _('Bank Name') . ':</label>
			<br><input tabindex=2 type="Text" name="Bankname" id="Bankname" value="' . $_POST['Bankname'] . '"  size=30 maxlength=28></td></tr>';
			echo '<tr><td><label>' . _('Narration') . ':</label>
			<br><input tabindex=2 type="Text" name="Narration" id="Narration" value="' . $_POST['Narration'] . '" size=82 maxlength=81 ></td></tr>
			</table>';


	 ?>	
    	</div>
                
        	
        
   		<div id="rightcenter" style="width:50%; float:right; position: absolute; margin-top:0px; margin-left:270px">
	<?php
		
		$balance=10;
			
			echo '<table><tr><td><label>' . _('Misc. Fees') . ':</label>
			<br><input tabindex=2 type="Text" name="Miscfees" id="Miscfees" class=number value="' . $_POST['Miscfees']  . '" size=30 maxlength=28 placeholder="Number"></td></tr>';	
			 echo '<tr><td><label>' . _('Court Fees') . ':</label>
			<br><input tabindex=2 type="Text" name="Courtfees" id="Courtfees" class=number value="' . $_POST['Courtfees']  . '" size=30 maxlength=28 placeholder="Number"></td></tr>';
		   	echo '<tr><td><label>' . _('Balance Remaining') . ':</label>
			<br><input tabindex=2 type="Text" name="Balance" id="Balance" value="' . $balance  . '" size=30 maxlength=28 placeholder="Total Balance" 	onclick="calcBalance()">
			</td></tr>';
		
		
    	// main div ends here------------------------------------------->---->>
    ?>
      	</table>
		</div></div>
  		
    <?php

  		echo "<div class='buttonseconomy'><input type='Submit' name='submit' VALUE='" . _('Update') . "' onClick='return checkvalidity()' >";
		echo '<input type="Submit" name="delete" VALUE="' . _('Delete') . '" onclick="return confirm(\'' . _('Are You Sure?') . '\');">';
		
	echo '</form></table></div></div>'; 
     	
	
} // end of main ifs


}













// this is the start of the GLJournal Code. Above code is for lw_economy code merged into GLJournal Code
if (isset($_GET['NewJournal']) and $_GET['NewJournal'] == 'Yes' AND isset($_SESSION['JournalDetail'])){
	unset($_SESSION['JournalDetail']->GLEntries);
	unset($_SESSION['JournalDetail']);
}

if (!isset($_SESSION['JournalDetail'])){
	$_SESSION['JournalDetail'] = new Journal;

	/* Make an array of the defined bank accounts - better to make it now than do it each time a line is added
	Journals cannot be entered against bank accounts GL postings involving bank accounts must be done using
	a receipt or a payment transaction to ensure a bank trans is available for matching off vs statements */

	$SQL = 'SELECT accountcode FROM bankaccounts';
	$result = DB_query($SQL,$db);
	$i=0;
	while ($Act = DB_fetch_row($result)){
		$_SESSION['JournalDetail']->BankAccounts[$i]= $Act[0];
		$i++;
	}
}



if (isset($_POST['CommitBatch']) and $_POST['CommitBatch']==_('Accept and Process Journal')){

 /* once the GL analysis of the journal is entered
  process all the data in the session cookie into the DB
  A GL entry is created for each GL entry
*/

	$PeriodNo = GetPeriod($_SESSION['JournalDetail']->JnlDate,$db);

     /*Start a transaction to do the whole lot inside */
	$result = DB_Txn_Begin($db);

	$TransNo = GetNextTransNo( 0, $db);

	foreach ($_SESSION['JournalDetail']->GLEntries as $JournalItem) {
		$SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount,
						tag) ';
		$SQL= $SQL . 'VALUES (0,
					' . $TransNo . ",
					'" . FormatDateForSQL($_SESSION['JournalDetail']->JnlDate) . "',
					" . $PeriodNo . ",
					" . $JournalItem->GLCode . ",
					'" . $JournalItem->Narrative . "',
					" . $JournalItem->Amount .
					",'".$JournalItem->tag."')";
		$ErrMsg = _('Cannot insert a GL entry for the journal line because');
		$DbgMsg = _('The SQL that failed to insert the GL Trans record was');
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);

		if ($_POST['JournalType']==_('Reversing')){
			$SQL = 'INSERT INTO gltrans (type,
							typeno,
							trandate,
							periodno,
							account,
							narrative,
							amount,
							tag) ';
			$SQL= $SQL . 'VALUES (0,
						' . $TransNo . ",
						'" . FormatDateForSQL($_SESSION['JournalDetail']->JnlDate) . "',
						" . ($PeriodNo + 1) . ",
						" . $JournalItem->GLCode . ",
						'Reversal - " . $JournalItem->Narrative . "',
						" . -($JournalItem->Amount) .
					",'".$JournalItem->tag."')";

			$ErrMsg =_('Cannot insert a GL entry for the reversing journal because');
			$DbgMsg = _('The SQL that failed to insert the GL Trans record was');
			$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);

		}
	}


	$ErrMsg = _('Cannot commit the changes');
	$result= DB_Txn_Begin($db);

	prnMsg(_('Journal').' ' . $TransNo . ' '._('has been successfully entered'),'success');

	unset($_POST['JournalProcessDate']);
	unset($_POST['JournalType']);
	unset($_SESSION['JournalDetail']->GLEntries);
	unset($_SESSION['JournalDetail']);
    /*Set up a newy in case user wishes to enter another */
	echo "<br><a href='" . $_SERVER['PHP_SELF'] . '?' . SID . "&NewJournal=Yes'>"._('Enter Another General Ledger Journal').'</a>';
	/*And post the journal too */
	include ('includes/GLPostings.inc');
	exit;
	

} elseif (isset($_GET['Delete'])){

	/* User hit delete the line from the journal */
	$_SESSION['JournalDetail']->Remove_GLEntry($_GET['Delete']);

} elseif (isset($_POST['Process']) and $_POST['Process']==_('Accept')){ //user hit submit a new GL Analysis line into the journal
	if($_POST['GLCode']!='')
	{
		$extract = explode(' - ',$_POST['GLCode']);
		$_POST['GLCode'] = $extract[0];
	}
	if($_POST['Debit']>0)
	{
		$_POST['GLAmount'] = $_POST['Debit'];
	}
	elseif($_POST['Credit']>0)
	{
		$_POST['GLAmount'] = '-' . $_POST['Credit'];
	}
	if ($_POST['GLManualCode'] != '' AND is_numeric($_POST['GLManualCode'])){
				// If a manual code was entered need to check it exists and isnt a bank account
	$AllowThisPosting = true; //by default
		if ($_SESSION['ProhibitJournalsToControlAccounts'] == 1){
			if ($_SESSION['CompanyRecord']['gllink_debtors'] == '1' AND $_POST['GLManualCode'] == $_SESSION['CompanyRecord']['debtorsact']){
				prnMsg(_('GL Journals involving the debtors control account cannot be entered. The general ledger debtors ledger (AR) integration is enabled so control accounts are automatically maintained by RosERP. This setting can be disabled in System Configuration'),'warn');
				$AllowThisPosting = false;
			}
			if ($_SESSION['CompanyRecord']['gllink_creditors'] == '1' AND $_POST['GLManualCode'] == $_SESSION['CompanyRecord']['creditorsact']){
				prnMsg(_('GL Journals involving the creditors control account cannot be entered. The general ledger creditors ledger (AP) integration is enabled so control accounts are automatically maintained by RosERP. This setting can be disabled in System Configuration'),'warn');
				$AllowThisPosting = false;
			}
		}
		if (in_array($_POST['GLManualCode'], $_SESSION['JournalDetail']->BankAccounts)) {
			prnMsg(_('GL Journals involving a bank account cannot be entered') . '. ' . _('Bank account general ledger entries must be entered by either a bank account receipt or a bank account payment'),'info');
			$AllowThisPosting = false;
		}

		if ($AllowThisPosting) {
			$SQL = 'SELECT accountname
							FROM chartmaster
							WHERE accountcode=' . $_POST['GLManualCode'];
			$Result=DB_query($SQL,$db);

			if (DB_num_rows($Result)==0){
				prnMsg(_('The manual GL code entered does not exist in the database') . ' - ' . _('so this GL analysis item could not be added. Please create GL account first to use'),'warn');
				unset($_POST['GLManualCode']);
			} else {
				$myrow = DB_fetch_array($Result);
				$_SESSION['JournalDetail']->add_to_glanalysis($_POST['GLAmount'], $_POST['GLNarrative'], $_POST['GLManualCode'], $myrow['accountname'], $_POST['tag']);
			}
		}
	} else {
		$AllowThisPosting =true; //by default
		if ($_SESSION['ProhibitJournalsToControlAccounts'] == 1){
			if ($_SESSION['CompanyRecord']['gllink_debtors'] == '1' AND $_POST['GLCode'] == $_SESSION['CompanyRecord']['debtorsact']){
				prnMsg(_('GL Journals involving the debtors control account cannot be entered. The general ledger debtors ledger (AR) integration is enabled so control accounts are automatically maintained by RosERP. This setting can be disabled in System Configuration'),'warn');
				$AllowThisPosting = false;
			}
			if ($_SESSION['CompanyRecord']['gllink_creditors'] == '1' AND $_POST['GLCode'] == $_SESSION['CompanyRecord']['creditorsact']){
				prnMsg(_('GL Journals involving the creditors control account cannot be entered. The general ledger creditors ledger (AP) integration is enabled so control accounts are automatically maintained by RosERP. This setting can be disabled in System Configuration'),'warn');
				$AllowThisPosting = false;
			}
		}

		if (in_array($_POST['GLCode'], $_SESSION['JournalDetail']->BankAccounts)) {
			prnMsg(_('GL Journals involving a bank account cannot be entered') . '. ' . _('Bank account general ledger entries must be entered by either a bank account receipt or a bank account payment'),'warn');
			$AllowThisPosting = false;
		}

		if ($AllowThisPosting){
			if (!isset($_POST['GLAmount'])) {
				$_POST['GLAmount']=0;
			}
			$SQL = 'SELECT accountname FROM chartmaster WHERE accountcode=' . $_POST['GLCode'];
			$Result=DB_query($SQL,$db);
			$myrow=DB_fetch_array($Result);
			$_SESSION['JournalDetail']->add_to_glanalysis($_POST['GLAmount'], $_POST['GLNarrative'], $_POST['GLCode'], $myrow['accountname'], $_POST['tag']);
		}
	}

	/*Make sure the same receipt is not double processed by a page refresh */
	$Cancel = 1;
	unset($_POST['Credit']);
	unset($_POST['Debit']);
	unset($_POST['tag']);
	unset($_POST['GLManualCode']);
	unset($_POST['GLNarrative']);
}

if (isset($Cancel)){
	unset($_POST['Credit']);
	unset($_POST['Debit']);
	unset($_POST['GLAmount']);
	unset($_POST['GLCode']);
	unset($_POST['tag']);
	unset($_POST['GLManualCode']);
}

?>
<div style="float:center; border:inset; margin-left:820px; width:494px; height:55px; background-color: #FFFF99; margin-top:-75px; margin-bottom:15px"<table>
 <img src="trialbalance.png" onClick="wind('GLTrialBalance.php')" align="top" style="cursor:pointer;" />
<tr>

<td>
<img src="profitloss.png" onClick="wind('GLTagProfit_Loss.php')" align="top" style="cursor:pointer;" />
 
</td>


<td>
<img src="balancesheet.png" onClick="wind('GLBalanceSheet.php')" align="top" style="cursor:pointer;" />
</td>

<td>
 <img src="" onClick="wind('')" align="top" style="cursor:pointer;" />

</td>
<td>
 <img src="" onClick="wind('')" align="top" style="cursor:pointer;" />
</td>
</tr>  

</table>


</div>

<?php
echo '<div  id="form_containereconomies" style="float:right" >';

echo '<form action=' . $_SERVER['PHP_SELF'] . '?' . SID . ' method="post" name="form">';


echo '<table>';
	

// A new table in the first column of the main table

if (!Is_Date($_SESSION['JournalDetail']->JnlDate)){
	// Default the date to the last day of the previous month
	$_SESSION['JournalDetail']->JnlDate = Date($_SESSION['DefaultDateFormat'],mktime(0,0,0,date('m'),0,date('Y')));
}

	echo '
	<tr><td><table border=0 width=30% align="left">

	<label><font color=blue>' . _('Journal Entry') . '</font></label>
			
<br>			
			
			
			<tr>
			<td><label><font color=blue>' . _('Date'). ":</font></label></td>
			<td><input type='text' class='date' alt='".$_SESSION['DefaultDateFormat']."' name='JournalProcessDate' maxlength=10 size=11 value='" . $_SESSION['JournalDetail']->JnlDate . "'></td>";
	echo '<td> <label><font color=blue>' . _('Type') . ':</font></label></td>
			<td><select name=JournalType>';

	if ($_POST['JournalType'] == 'Reversing'){
		echo "<option selected value = 'Reversing'>" . _('Reversing');
		echo "<option value = 'Normal'>" . _('Normal');
	} else {
		echo "<option value = 'Reversing'>" . _('Reversing');
		echo "<option selected value = 'Normal'>" . _('Normal');
	}

	echo '</select></td>
			</tr>
		</table>';
	/* close off the table in the first column  */

	echo '<br>';
	echo '<table border=0 width=70% align="left">'; 
	/* Set upthe form for the transaction entry for a GL Payment Analysis item */

	/*now set up a GLCode field to select from avaialble GL accounts */
		echo '<th><label><font color=blue>' . _('Select GL Account') . '</font></label></th></tr>';

/* Set up form for the transaction entry for a GL Payment Analysis item */


	//Select the tag
	echo '<select name="tag" style="visibility:hidden">';
	
	$SQL = 'SELECT tagref,
				tagdescription
		FROM tags
		ORDER BY tagref';

	$result=DB_query($SQL,$db);
	echo '<option value=0>0 - None';
	while ($myrow=DB_fetch_array($result)){
		if (isset($_POST['tag']) and $_POST['tag']==$myrow['tagref']){
			echo '<option selected value=' . $myrow['tagref'] . '>' . $myrow['tagref'].' - ' .$myrow['tagdescription'];
		} else {
			echo '<option value=' . $myrow['tagref'] . '>' . $myrow['tagref'].' - ' .$myrow['tagdescription'];
		}
	}
	echo '</select>';
// End select tag

	if (!isset($_POST['GLManualCode'])) {
		$_POST['GLManualCode']='';
	}
	/*echo '<td><input class="number" type=Text Name="GLManualCode" Maxlength=12 size=12 onChange="inArray(this.value, GLCode.options,'.
		"'".'The account code '."'".'+ this.value+ '."'".' doesnt exist'."'".')"' .
			' VALUE='. $_POST['GLManualCode'] .' > </td>';*/
            
            

	$sql='SELECT accountcode,
				accountname
			FROM chartmaster
			ORDER BY accountcode';

	$result=DB_query($sql, $db);
	
	//for the cases and notices pass array of city,state,email,mobile values as this value in assignComboToInput but trap $myrow values during page load
	//in javascript array
	
	echo '<td><select name="GLCode" /* onChange="return assignComboToInput(this,'.'GLManualCode'.' */)">';
	while ($myrow=DB_fetch_array($result)){
		if (isset($_POST['GLCode']) and $_POST['GLCode']==$myrow['accountcode']){
			echo '<option selected value=' . $myrow['accountcode'] . '>' . $myrow['accountcode'].' - ' .$myrow['accountname'];
		} else {
			echo '<option value=' . $myrow['accountcode'] . '>' . $myrow['accountcode'].' - ' .$myrow['accountname'];
		}
	}
	echo '</select></td>';

	if (!isset($_POST['GLNarrative'])) {
		$_POST['GLNarrative'] = '';
	}
	if (!isset($_POST['Credit'])) {
		$_POST['Credit'] = '';
	}
	if (!isset($_POST['Debit'])) {
		$_POST['Debit'] = '';
	}


	echo '</tr><tr><td><label><font color=blue>' . _('Debit') .'</font></label>&nbsp;&nbsp;<input type=Text class="number" Name = "Debit" ' .
				'onChange="eitherOr(this, '.'Credit'.')"'.
				'Maxlength=12 size=10 value=' . $_POST['Debit'] . '>&nbsp;<label><font color=blue>OR</font></label>&nbsp';
	echo   '<label><font color=blue>' . _('Credit') . '</font></label>&nbsp;&nbsp;<input type=Text class="number" Name = "Credit" ' .
				'onChange="eitherOr(this, '.'Debit'.')"'.
				'Maxlength=12 size=10 value=' . $_POST['Credit'] . '></td>';
		echo '</tr><tr><td><label><font color=blue>' . _('GL Narrative');

	echo '</font></label><input type="text" name="GLNarrative" maxlength=50 size=50 value="' . $_POST['GLNarrative'] . '"></td>';

	echo '</tr></table>'; /*Close the main table */
	echo "<tr><td><input type=submit name=Process value='" . _('Accept') . "'></div><br><hr><br></tr></td>";


	echo "<table border =1 width=85% align='center'><tr><td><table width=100%>
					<tr>
						<th><font color=blue>"._('GL Tag')."</font></th>
						<th><font color=blue>"._('GL Account')."</font></th>
						<th><font color=blue>"._('Debit')."</font></th>
						<th><font color=blue>"._('Credit')."</font></th>
						<th><font color=blue>"._('Narrative'). '</font></th></tr>';

						$debittotal=0;
						$credittotal=0;
						$j=0;

						foreach ($_SESSION['JournalDetail']->GLEntries as $JournalItem) {
								if ($j==1) {
									echo '<tr class="OddTableRows">';
									$j=0;
								} else {
									echo '<tr class="EvenTableRows">';
									$j++;
								}
							$sql='SELECT tagdescription ' .
									'FROM tags ' .
									'WHERE tagref='.$JournalItem->tag;
							$result=DB_query($sql, $db);
							$myrow=DB_fetch_row($result);
							if ($JournalItem->tag==0) {
								$tagdescription='None';
							} else {
								$tagdescription=$myrow[0];
							}
							echo "<td>" . $JournalItem->tag . ' - ' . $tagdescription . "</td>";
							echo "<td>" . $JournalItem->GLCode . ' - ' . $JournalItem->GLActName . "</td>";
								if($JournalItem->Amount>0)
								{
								echo "<td class='number'>" . number_format($JournalItem->Amount,2) . '</td><td></td>';
								$debittotal=$debittotal+$JournalItem->Amount;
								}
								elseif($JournalItem->Amount<0)
								{
									$credit=(-1 * $JournalItem->Amount);
								echo "<td></td>
										<td class='number'>" . number_format($credit,2) . '</td>';
								$credittotal=$credittotal+$credit;
								}

							echo '<td>' . $JournalItem->Narrative  . "</td>
									<td><a href='" . $_SERVER['PHP_SELF'] . '?' . SID . '&Delete=' . $JournalItem->ID . "'>"._('Delete').'</a></td>
							</tr>';
						}

			echo '<tr class="EvenTableRows"><td></td>
					<td align=right><b> Total </b></td>
					<td align=right class="number"><b>' . number_format($debittotal,2) . '</b></td>
					<td align=right class="number"><b>' . number_format($credittotal,2) . '</b></td>';
			if ($debittotal!=$credittotal) {
				echo '<td align=center style="background-color: #fddbdb"><b>Required to balance - ' .
					number_format(abs($debittotal-$credittotal),2);
			}
			if ($debittotal>$credittotal) {echo ' Credit';} else if ($debittotal<$credittotal) {echo ' Debit';}
			echo '</b></td></tr></table></td></tr></table>';

if (ABS($_SESSION['JournalDetail']->JournalTotal)<0.001 AND $_SESSION['JournalDetail']->GLItemCounter > 0){
	echo "<br><br><div class='centre'><input type=submit name='CommitBatch' value='"._('Accept and Process Journal')."'></div></div>";
} elseif(count($_SESSION['JournalDetail']->GLEntries)>0) {
	echo '<br><br>';
	prnMsg(_('The journal must balance ie debits equal to credits before it can be processed'),'warn');
}

if (!isset($_GET['NewJournal']) or $_GET['NewJournal']=='') {
	echo "<script>defaultControl(document.form.GLManualCode);</script>";
} else {
	echo "<script>defaultControl(document.form.JournalProcessDate);</script>";
}

echo '</form>';

?>

<script>

 $("#Brief_File_No").change( function()  {
				  trapartydetails(no_rows);
                  });

</script>