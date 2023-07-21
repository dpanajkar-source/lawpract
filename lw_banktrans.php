<?php
 include('includes/DefineJournalClass.php');
 include('includes/DefineReceiptClass.php');
/* $Revision: 1.27 $ */
$PageSecurity = 13;
include('includes/session.php');
echo '<link href="'.$rootpath. '/style.css" rel="stylesheet" type="text/css" />';
include('includes/SQL_CommonFunctions.inc'); 

echo '<script src="jquery-1.11.1.min.js" ></script>';

$_SESSION['ReceiptBatch']->Account = '1204';


?>


<script type="text/javascript" defer="defer">



function trapartyeconomydetails(no_rowspartyeconomytable) {

var ar=<?php echo json_encode($_SESSION['partyeconomytable']); ?>;

var economyparty=$("#Brief_File_Fetched").val();

var totalfees=$("#Totalfees");
var balance=$("#Balance");

var fin=new Array(6);
for(var i=0;i<no_rowspartyeconomytable;i++)
{
if(ar[i][0]==economyparty)
{
for(var j=0;j<=5;j++)
	{
fin[j]=ar[i][j];
//console.log('array ar elements=' + ar);
	}


}
}
if(fin[1])
	{
totalfees.val(fin[4]);
balance.val(fin[5]);

alert(fin[5]);


	}else
	{
$("#Totalfees").val('');
$("#Balance").val('');
	}

}






$(document).ready(function() {
window.onload = function() { 
			
$("#Chequeform").hide();
$("#Directcredit").hide();

      
 $("#Brief_File_Fetched").change( function() {

trapartyeconomydetails(no_rowspartyeconomytable);

 });
   	    
			
	};
	
	 

function showAddForm() {
        $("#Chequeform").show();
		$("#Directcredit").hide();
 }
 
 function showAddFormDirectCredit() {
 $("#Directcredit").show();
 $("#Chequeform").hide();
 
 }

$("#ReceiptType").change( function()  {


				 
				if($("#ReceiptType").val()=="Cheque")
				{
				showAddForm();
				}
				else if($("#ReceiptType").val()=="DirectCredit")
				{
				showAddFormDirectCredit();
				}else if($("#ReceiptType").val()=="NEFT/RTGS")
				{
				showAddForm();
				}
				else 
				{
				$("#Chequeform").hide();
				$("#Directcredit").hide();
				}
						 
                  });
				  
		});
	</script>	





<?php

if($_POST['Brief_File_Search']=='')
{
$_POST['Brief_File_Search']=NULL;
}

if($_POST['Partyname_Search']=='')
{
$_POST['Partyname_Search']=NULL;
}


if (isset($_POST['Brief_File_No'])){
	$Brief_File_No = $_POST['Brief_File_No'];
} elseif (isset($_GET['Brief_File_No'])){
	$Brief_File_No = $_GET['Brief_File_No'];
}

if (isset($_POST['Brief_File_Search'])){
		
	$Brief_File_Search=$_POST['Brief_File_Search'];
		
	}


if (isset($_POST['Partyname_Search'])){
	$SearchName = $_POST['Partyname_Search'];
}


//Below we are trapping total fees and balance from lw_partyeconomy so user can select brief_file after partyname search and these values will fill the inputs
$resultfillpartyeconomytable=DB_query("SELECT brief_file,party,courtcaseno,glcode,totalfees,balance from lw_partyeconomy",$db);

$no_rowspartyeconomytable=DB_num_rows($resultfillpartyeconomytable); //to be passed to javascript function as no. of rows value



$_SESSION['partyeconomytable']=array();

$j=0;
while ($myrowpartyeconomytablefetch = DB_fetch_array($resultfillpartyeconomytable)) {

	for($i=0;$i<=5;$i++)
    {
	$_SESSION['partyeconomytable'][$j][$i]=$myrowpartyeconomytablefetch[$i];
	
	}
	$j++;
}	
	


?>

<script> 

var no_rowspartyeconomytable=<?php echo json_encode($no_rowspartyeconomytable); ?>;


</script>



<?php

if (isset($_POST['submit'])) 
{



	/* actions to take once the user has clicked the submit button
	ie the page has called itself with some user input */

				
		//First check if there is a record in lw_partyeconomy for the search brief_File_search
		
		$sqlsearchbriefineconomy='SELECT brief_file from lw_partyeconomy WHERE brief_file="' . $_POST['Brief_File_Fetched'] . '"';
		
		$resultbriefineconomy = DB_query($sqlsearchbriefineconomy,$db,$ErrMsg);
		
		$myrowbriefineconomy=DB_fetch_array($resultbriefineconomy);
		
		//get glcode for the brief_file fetched
		
	$sqlglcodefetch='SELECT glcode,courtcaseno from lw_cases WHERE brief_file="' . $_POST['Brief_File_Fetched'] . '"';
		
		$resultglcodefetch = DB_query($sqlglcodefetch,$db,$ErrMsg);
		
		$myrowglcode=DB_fetch_array($resultglcodefetch);
		
		
		if(Is_Date($_POST['Chequedt']))
		{
				
		$chequedt=FormatDateForSQL($_POST['Chequedt']);
				
		}
		else
		{
		
		$chequedt="00/00/0000";
		}
						
		if(isset($myrowbriefineconomy[0])) //There is already an entry of the brief_file in lw_partyeconomy which is only once
		{	
		
		
		
		 //below is for updating data in lw_partytrans table when party starts paying fees	
			
			if($_POST['Amountreceived']!=NULL)
				{	
				
			$sqlcontactnamefetch="SELECT 
					lw_contacts.id					
			FROM lw_contacts WHERE lw_contacts.name='" . trim($_POST['Partyname']) . "'  AND lw_contacts.deleted!=1";
			
						
			$resultcontactidfetch=DB_query($sqlcontactnamefetch,$db);
			
			$myrowcontactidfetch=DB_fetch_array($resultcontactidfetch);
									 
			  $sqlinsertpartytrans = "INSERT INTO lw_partytrans(
							brief_file,
							party,
							glcode,
							amountreceived,
							receivedt,
							ourbankcode,
							chequeno,
							chequedate,
							custbankname,
							narration						
							)
				VALUES ('" . trim($_POST['Brief_File_Fetched']) ."',
					'" . trim($myrowcontactidfetch[0]) . "',
					'" . trim($myrowglcode['glcode']) . "',
					'" . trim($_POST['Amountreceived']) . "',
					'" . trim(FormatDateForSQL($_POST['Receivedt'])) . "',
					'" . trim($_POST['Ourbankcode']) . "',
					'" . trim($_POST['Chequeno']) . "',
					'" . trim($chequedt) . "',
					'" . trim($_POST['Custbankname']) . "',
					'" . trim($_POST['Narration']) . "'				
					)";

 
			$ErrMsg = _('This Economy Entry could not be added because');
			$result = DB_query($sqlinsertpartytrans,$db,$ErrMsg); //
			prnMsg( _('Party Transaction Inserted'),'success');
			
				//GLentry is debit Cash GL account with Amount Received

$DateString = Date($_SESSION['DefaultDateFormat']);
$PeriodNo = GetPeriod($_SESSION['JournalDetail']->JnlDate,$db);
$TransNo = GetNextTransNo( 0, $db);




if(isset($_POST['ReceiptType'])) //this is when user selects payment mode
{
if($_POST['ReceiptType']=="Cash")
{
	$accountcode=1202; 
} elseif($_POST['ReceiptType']=="Cheque")
{
	$accountcode=1203;
}elseif($_POST['ReceiptType']=="NEFT/RTGS")
	$accountcode=1203;
}
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
					'" . $PeriodNo . "',
					'" . $accountcode . "',
					'" . $_POST['Narration'] . "',
					'" .  $_POST['Amountreceived'] . "',
					0)";
		$ErrMsg = _('Cannot insert a GL entry for the journal line because');
		$DbgMsg = _('The SQL that failed to insert the GL Trans record was');
		//$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);



//Second GLentry is to credit Another GL account with Amount Received

$DateString = Date($_SESSION['DefaultDateFormat']);
$PeriodNo = GetPeriod($_SESSION['JournalDetail']->JnlDate,$db);
$TransNo = GetNextTransNo( 0, $db);

//Same amount is credited to party Gl code (Mr. X)-----------------------------------
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
					" . $myrowglcode[0] . ",
					'" . $_POST['Narrative'] . "',
					" .  '-' . $_POST['Amountreceived'] . ",
					0)";
		$ErrMsg = _('Cannot insert a GL entry for the journal line because');
		$DbgMsg = _('The SQL that failed to insert the GL Trans record was');
		
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);

			
		}//end of insert new economy transaction ends
			unset($Brief_File_Search); 
		
		
		 //Below is for updating lw_partyeconomy with balace amount		
		
		
		
		//count total received amount till now from lw_partytrans for given brief_file
		
		$sqltotalreceivedfetch='SELECT brief_file,sum(amountreceived) from lw_partytrans WHERE brief_file="' . $_POST['Brief_File_Fetched'] . '"';
		
		$resulttotalreceived = DB_query($sqltotalreceivedfetch,$db,$ErrMsg);
		
		$myrowtotalreceived=DB_fetch_array($resulttotalreceived);
		
		
		//Balance calculated below- Difference of Totalfees from lw_partyeconomy and sum of totalreceived from lw_partytrans
		
		$balance=$_POST['Totalfees']-$myrowtotalreceived[1];
		
				
		//below is for updating data in lw_partyeconomy table when party starts paying fees	
		
		
		 $sqlupdatepartyeconomy = "UPDATE lw_partyeconomy SET
			  		courtcaseno='" . trim($myrowglcode['courtcaseno']) . "',
					glcode='" . trim($myrowglcode['glcode']) . "',
					totalfees='" . trim($_POST['Totalfees']) . "',
					balance='" . $balance . "'
				WHERE brief_file = '" . $_POST['Brief_File_Fetched'] . "'";

						
			$ErrMsg = _('This Economy Entry could not be added because');
			$result = DB_query($sqlupdatepartyeconomy,$db,$ErrMsg);
			
			prnMsg( _('Economy balance updated now'),'success');

				$ErrMsg = _('The Economy Entry could not be updated because');
		
			echo '<br>';
		}
		else  //insert mode for new economy starts
		{ //it is a new brief_file economy entry
		
		if(Is_Date($_POST['Chequedt']))
		{
				
		$chequedt=FormatDateForSQL($_POST['Chequedt']);
				
		}
		else
		{
		
		$chequedt="000/00/00";
		}
		
		$sqlglcodefetch='SELECT glcode,courtcaseno from lw_cases WHERE brief_file="' . $_POST['Brief_File_Fetched'] . '"' ;
		
		$resultglcodefetch = DB_query($sqlglcodefetch,$db,$ErrMsg);
		
		$myrowglcode=DB_fetch_array($resultglcodefetch);
	
		
		$balance=$_POST['Totalfees']-$_POST['Amountreceived'];
		
		
		// fetch contactid
		
		$sqlcontactnamefetch="SELECT 
					lw_contacts.id					
			FROM lw_contacts WHERE lw_contacts.name='" . trim($_POST['Partyname']) . "'  AND lw_contacts.deleted!=1";
			
			$resultcontactidfetch=DB_query($sqlcontactnamefetch,$db);
			
			$myrowcontactidfetch=DB_fetch_array($resultcontactidfetch);
			
			if(!$_POST['Totalfees'])
			{
			$_POST['Totalfees']=0;
			}
		
		
		//below is for inserting data in lw_economy table only once in the beginning when party decides the total fee payment		
			 $sql = "INSERT INTO lw_partyeconomy(
							brief_file,
							party,
							courtcaseno,
							glcode,
							totalfees,
							balance						
							)
				VALUES ('" . trim($_POST['Brief_File_Fetched']) ."',
					'" . trim($myrowcontactidfetch[0]) ."',
					'" . $myrowglcode['courtcaseno'] . "',
					'" . $myrowglcode['glcode'] . "',
					'" . trim($_POST['Totalfees']) . "',
					'" . trim($balance) . "'			
					)";

			$ErrMsg = _('This Economy Entry could not be added because');
			$result = DB_query($sql,$db,$ErrMsg);
			prnMsg( _('Economy Entry Inserted'),'success');
			
			//GLentry is debit Cash GL account with Amount Received

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
					'" . $PeriodNo . "',
					'" . $myrowglcode['glcode'] . "',
					'" . $_POST['Narration'] . "',
					'" .  $_POST['Totalfees'] . "',
					0)";
		$ErrMsg = _('Cannot insert a GL entry for the journal line because');
		$DbgMsg = _('The SQL that failed to insert the GL Trans record was');
		//$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);




//Second GLentry is to credit Another GL account with Amount Received

$DateString = Date($_SESSION['DefaultDateFormat']);
$PeriodNo = GetPeriod($_SESSION['JournalDetail']->JnlDate,$db);
$TransNo = GetNextTransNo( 0, $db);

$glcode=6101;

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
					" .  '-' . $_POST['Totalfees'] . ",
					0)";
		$ErrMsg = _('Cannot insert a GL entry for the journal line because');
		$DbgMsg = _('The SQL that failed to insert the GL Trans record was');
		//$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);

			
		}//end of insert new economy transaction ends
			unset($Brief_File_Search); 
			unset($SearchName);
			
			
			
			//below is for inserting data in lw_partytrans table once in the beginning if party pays some amount as advance	
				if($_POST['Amountreceived']!=NULL)
				{	
				
										
			 $sql = "INSERT INTO lw_partytrans(
							brief_file,
							glcode,
							amountreceived,
							receivedt,
							ourbankcode,
							chequeno,
							chequedate,
							custbankname,
							narration						
							)
				VALUES ('" . trim($_POST['Brief_File_Fetched']) ."',
					'" . $myrowglcode['glcode'] . "',
					'" . trim($_POST['Amountreceived']) . "',
					'" . trim(FormatDateForSQL($_POST['Receivedt'])) . "',
					'" . trim($_POST['Ourbankcode']) . "',
					'" . trim($_POST['Chequeno']) . "',
					'" . trim($chequedt) . "',
					'" . trim($_POST['Custbankname']) . "',
					'" . trim($_POST['Narration']) . "'				
					)";

			$ErrMsg = _('This Economy Entry could not be added because');
			$result = DB_query($sql,$db,$ErrMsg);
								
			prnMsg(_('Economy Entry Created'),'Success');
			
			//GLentry is debit Cash GL account with Amount Received

$DateString = Date($_SESSION['DefaultDateFormat']);
$PeriodNo = GetPeriod($_SESSION['JournalDetail']->JnlDate,$db);
$TransNo = GetNextTransNo( 0, $db);




if(isset($_POST['ReceiptType'])) //this is when user selects payment mode
{
if($_POST['ReceiptType']=="Cash")
{
	$accountcode=1202; 
	
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
					'" . $PeriodNo . "',
					'" . $accountcode . "',
					'" . $_POST['Narration'] . "',
					'" .  $_POST['Amountreceived'] . "',
					0)";
					
		
		
//Second GLentry is to credit Another GL account with Amount Received

$DateString = Date($_SESSION['DefaultDateFormat']);
$PeriodNo = GetPeriod($_SESSION['JournalDetail']->JnlDate,$db);
$TransNo = GetNextTransNo( 0, $db);

//Same amount is credited to party Gl code-----------------------------------
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
					" . $myrowglcode[0] . ",
					'" . $_POST['Narrative'] . "',
					" .  '-' . $_POST['Amountreceived'] . ",
					0)";
		$ErrMsg = _('Cannot insert a GL entry for the journal line because');
		$DbgMsg = _('The SQL that failed to insert the GL Trans record was');
		//$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);
					
} elseif($_POST['ReceiptType']=="Cheque")
{
	$accountcode=1203;
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
					'" . $PeriodNo . "',
					'" . $accountcode . "',
					'" . $_POST['Narration'] . "',
					'" .  $_POST['Amountreceived'] . "',
					0)";
					
					
//Second GLentry is to credit Another GL account with Amount Received

$DateString = Date($_SESSION['DefaultDateFormat']);
$PeriodNo = GetPeriod($_SESSION['JournalDetail']->JnlDate,$db);
$TransNo = GetNextTransNo( 0, $db);

//Same amount is credited to party Gl code-----------------------------------
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
					" . $myrowglcode[0] . ",
					'" . $_POST['Narrative'] . "',
					" .  '-' . $_POST['Amountreceived'] . ",
					0)";
		$ErrMsg = _('Cannot insert a GL entry for the journal line because');
		$DbgMsg = _('The SQL that failed to insert the GL Trans record was');
		//$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);
					
					//Below is code for inserting entry into banktrans for bank entry
					
					/*Get the currency and rate of the bank account transferring to*/
				$SQLcurr = 'SELECT currcode, rate
							FROM bankaccounts INNER JOIN currencies
							ON bankaccounts.currcode = currencies.currabrev
							WHERE accountcode=' . $ReceiptItem->GLCode;
				$TrfFromAccountResult = DB_query($SQLcurr,$db);
				$TrfFromBankRow = DB_fetch_array($TrfFromAccountResult) ;
				$TrfFromBankCurrCode = $TrfFromBankRow['currcode'];
				$TrfFromBankExRate = $TrfFromBankRow['rate'];
					
					$_SESSION['ReceiptBatch']->DateBanked = $_POST['DateBanked'];
					
					
	if (!isset($_POST['Currency'])){
		$_POST['Currency']=$_SESSION['CompanyRecord']['currencydefault'];
	}

	$_SESSION['ReceiptBatch']->Currency=$_POST['Currency'];
					
	$PaymentTransNo = GetNextTransNo( 1, $db);
				$SQLbankaccountentry='INSERT INTO banktrans (transno,
							type,
							bankact,
							ref,
							exrate,
							functionalexrate,
							transdate,
							banktranstype,
							amount,
							currcode)
			      VALUES (' . $PaymentTransNo . ',
						1,
						' . $_POST['Outbankcode'] . ",
						'" . _('Act Transfer') .' - ' . $_POST['Narrative'] . "',
						" . (($_SESSION['ReceiptBatch']->ExRate * $_SESSION['ReceiptBatch']->FunctionalExRate)/$TrfFromBankExRate). ',
						' . $TrfFromBankExRate . ",
						'" . FormatDateForSQL($_SESSION['ReceiptBatch']->DateBanked) . "',
						'" . $_POST['ReceiptType'] . "',
						" . $_POST['Amountreceived'] . ",
						'" . $_SESSION['ReceiptBatch']->Currency . "'
					)";			
					
					
}elseif($_POST['ReceiptType']=="NEFT/RTGS")
	$accountcode=1203;
	
	$SQLNEFT = 'INSERT INTO gltrans (type,
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
					'" . $PeriodNo . "',
					'" . $accountcode . "',
					'" . $_POST['Narration'] . "',
					'" .  $_POST['Amountreceived'] . "',
					0)";
					
					
//Second GLentry is to credit Another GL account with Amount Received

$DateString = Date($_SESSION['DefaultDateFormat']);
$PeriodNo = GetPeriod($_SESSION['JournalDetail']->JnlDate,$db);
$TransNo = GetNextTransNo( 0, $db);

//Same amount is credited to party Gl code-----------------------------------
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
					" . $myrowglcode[0] . ",
					'" . $_POST['Narrative'] . "',
					" .  '-' . $_POST['Amountreceived'] . ",
					0)";
		$ErrMsg = _('Cannot insert a GL entry for the journal line because');
		$DbgMsg = _('The SQL that failed to insert the GL Trans record was');
		//$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);
		
			//Below is code for inserting entry into banktrans for bank entry
					
					/*Get the currency and rate of the bank account transferring to*/
				$SQLcurr = 'SELECT currcode, rate
							FROM bankaccounts INNER JOIN currencies
							ON bankaccounts.currcode = currencies.currabrev
							WHERE accountcode=' . $ReceiptItem->GLCode;
				$TrfFromAccountResult = DB_query($SQLcurr,$db);
				$TrfFromBankRow = DB_fetch_array($TrfFromAccountResult) ;
				$TrfFromBankCurrCode = $TrfFromBankRow['currcode'];
				$TrfFromBankExRate = $TrfFromBankRow['rate'];
					
					$_SESSION['ReceiptBatch']->DateBanked = $_POST['DateBanked'];
					
					
	if (!isset($_POST['Currency'])){
		$_POST['Currency']=$_SESSION['CompanyRecord']['currencydefault'];
	}

	$_SESSION['ReceiptBatch']->Currency=$_POST['Currency'];
					
	$PaymentTransNo = GetNextTransNo( 1, $db);
				$SQLbankaccountentry='INSERT INTO banktrans (transno,
							type,
							bankact,
							ref,
							exrate,
							functionalexrate,
							transdate,
							banktranstype,
							amount,
							currcode)
			      VALUES (' . $PaymentTransNo . ',
						1,
						' . $_POST['Outbankcode'] . ",
						'" . _('Act Transfer') .' - ' . $_POST['Narrative'] . "',
						" . (($_SESSION['ReceiptBatch']->ExRate * $_SESSION['ReceiptBatch']->FunctionalExRate)/$TrfFromBankExRate). ',
						' . $TrfFromBankExRate . ",
						'" . FormatDateForSQL($_SESSION['ReceiptBatch']->DateBanked) . "',
						'" . $_POST['ReceiptType'] . "',
						" . -$_POST['Amountreceived'] . ",
						'" . $_SESSION['ReceiptBatch']->Currency . "'
					)";			
					//$result = DB_query($SQLbankaccountentry,$db,$ErrMsg,$DbgMsg,true);
}

		

			
		}//end of insert new economy transaction ends
			unset($Brief_File_Search); 
			unset($SearchName);
						
	    }//if condition ends for $_POST['Amountreceived'] value
		

		 //end of (!isset($_POST['New'])) ie update mode if condition ends here
		
		
			


?>

 
<div style="float:center; margin-left:250px; width:60%; height:55px; background-color: #FFFF99; margin-top:50px; margin-bottom:1px"  >




<table align="center" style="text-align:center; margin-top:-20px;">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

<tr>
<td><label>Brief_File No:</label><br>
<?php 


echo '<input name="Brief_File_Search"  id="Brief_File_Search"  list="brief_file_search" >';

echo '<datalist id="brief_file_search">';

$result=DB_query("SELECT brief_file FROM lw_cases WHERE deleted!='1'",$db);

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

<input name="Partyname_Search" id="Partyname_Search"  list="partyname_search" >
<datalist id="partyname_search">


<?php

$sql="SELECT DISTINCT lw_cases.party,lw_contacts.name from lw_cases INNER JOIN lw_contacts
      ON lw_cases.party=lw_contacts.id AND lw_cases.deleted!=1";

$result=DB_query($sql,$db);

echo '<select tabindex="16" name="party">';

while ($myrow = DB_fetch_array($result)) {
	echo "<option VALUE='". $myrow[1] . "'>" . $myrow['name'] . '</option>';
	} //end while loop

DB_free_result($result);

echo '</select>';?>
</datalist>
</td>
<td colspan="6" align="center"">
<br>
<input type="submit" name="Search" VALUE="<?php echo _('Search Now'); ?>">

</form>
</td>
</form>
</table>
</div>


<?php

	

if (!isset($Brief_File_Search) AND !isset($SearchName))
 {

/*If the page was called without $_POST['Brief_File_No'] passed to page then assume a new Economy Entry is to be entered show a form with a Brief_File No field other wise the form showing the fields with the existing entries against the Economy Entry  will show for editing with only a hidden id field*/
  
		echo '<div  id="form_containereconominy">';
   			echo '<table width="600" height="20" border="0" align="left" style="margin-left:0px" >';
			echo '<tr><td><label>First Select Brief_File or Party name from above search utility  </label><img src="arrowup.png"></td><tr>';
    
	 include('includes/GetPaymentMethods.php');
  	
			echo '<tr><td>' . _('Receipt Type') . ":<select tabindex=6 name='ReceiptType' id='ReceiptType'>";

		
/* The array ReceiptTypes is defined from the setup tab of the main menu under payment methods - the array is populated from the include file GetPaymentMethods.php */

foreach ($ReceiptTypes as $RcptType) {
	if (isset($_POST['ReceiptType']) and $_POST['ReceiptType']==$RcptType){
		echo "<option selected Value='$RcptType'>$RcptType";
	} else {
		echo "<option Value='$RcptType'>$RcptType";
	}
}
echo '</select></td></tr></table>	';   
			
	  ?>
       <div name="Chequeform" id="Chequeform" style="position:static; float:left; margin-top:100px; margin-left:-550px; width:100px">
	
    <?php
	 $DateString = Date($_SESSION['DefaultDateFormat']);
    		
			$SQL = 'SELECT bankaccountname,
			bankaccounts.accountcode,
			bankaccounts.currcode
		FROM bankaccounts,
			chartmaster
		WHERE bankaccounts.accountcode=chartmaster.accountcode';


$ErrMsg = 'The bank accounts could not be retrieved because';
$DbgMsg = 'The SQL used to retrieve the bank accounts was';
$AccountsResults = DB_query($SQL,$db,$ErrMsg,$DbgMsg);

echo '<br><table align="left"><tr><td><label>Select Our Bank:</label><select tabindex=1 name="Ourbankcode">';

	while ($myrow=DB_fetch_array($AccountsResults)){
				
			echo '<option value="' . $myrow['accountcode'] . '">' . $myrow['bankaccountname']. ' - ' . $myrow['currcode'] . '</option>';
		}
	
	echo '</select></td></tr>';
	
			echo '<tr><td><label>Cheque/NEFT-RTGS No:</label>
			<br><input tabindex=2 type="Text" name="Chequeno" id="Chequeno" size=15 maxlength=14></td></tr>';
			echo '<tr><td><label>Cheque/NEFT-RTGS Date:</label>
			<br><input tabindex=2 type="Text" name="Chequedt" id="Chequedt"  class=date alt="'.$_SESSION['DefaultDateFormat'].'" value="' . $DateString . '"  size=15 maxlength=14></td></tr>';
			
			echo '<tr><td><label>Cheque from Bank:</label>
			<br><input tabindex=2 type="Text" name="Custbankname" id="Custbankname"  size=15 maxlength=14></td></tr>';
			echo '<tr><td><label>Narration:</label>
			<br><input tabindex=2 type="Text" name="Narration" id="Narration" size=50 maxlength=49 ></td></tr>
			</table></div>';
			
			?>
     <div name="Directcredit" id="Directcredit" style="position:static; float:left; margin-top:120px; margin-left:-550px; width:100px">
	
    <?php
	 $DateString = Date($_SESSION['DefaultDateFormat']);
    		
			echo '<table align="center"><tr><td><label>Our Bank Name:</label>';
			
$SQL = 'SELECT bankaccountname,
			bankaccounts.accountcode,
			bankaccounts.currcode
		FROM bankaccounts,
			chartmaster
		WHERE bankaccounts.accountcode=chartmaster.accountcode';


$ErrMsg = 'The bank accounts could not be retrieved because';
$DbgMsg = 'The SQL used to retrieve the bank accounts was';
$AccountsResults = DB_query($SQL,$db,$ErrMsg,$DbgMsg);

echo '<br><select tabindex=1 name="Ourbankcode">';

	while ($myrow=DB_fetch_array($AccountsResults)){
				
			echo '<option value="' . $myrow['accountcode'] . '">' . $myrow['bankaccountname']. ' - ' . $myrow['currcode'] . '</option>';
		}
	
	echo '</select></td></tr>';

			echo '<tr><td><label>Narration:</label>
			<br><input tabindex=2 type="Text" name="Narration" id="Narration" size=50 maxlength=49 ></td></tr>
			</table></div>';          
  					//end of direct credit form elements
					
			echo '<div style="position:fixed; float:right; margin-top:30px;  margin-left:550px; width:50px">
			
			<table><tr><td><label>Total Legal Fees:</label>
			<input tabindex=2 type="Text" name="Totalfees" id="Totalfees" class=number size=30 maxlength=28 placeholder="Number" value=0></td></tr>';
		 
			echo '<tr><td>&nbsp;<label>Balance Amt:</label>
			<br><input tabindex=2 type="Text" name="Balance" id="Balance" size=30 maxlength=28 placeholder="Total Balance" </td></tr>';
    		
			echo '<td><label>Received Date:</label>
			<br><input tabindex=2 type="Text" name="Receivedt" id="Receivedt"  class=date alt="'.$_SESSION['DefaultDateFormat'].'" size=30 maxlength=28></td></tr>';
						
			echo '<tr><td><label>Amount Received:</label>
			<br><input tabindex=2 type="Text" name="Amountreceived" id="Amount" class=number size=30 maxlength=28 placeholder="Number"></td>
			</tr>';
			
	
		echo '</td></tr></table></div></div>';

		} //end of 1st if of showing form fields when page first loads
		else
		{

	//Economy Entry exists - either passed when calling the form or from the form itself- ie Edit mode, form fields will populate with table values
 
	if (isset($Brief_File_Search) OR isset($SearchName)) {
	   
		if (isset($SearchName)) {
		
		$sqlcontactnamefetch="SELECT 
					lw_contacts.id					
			FROM lw_contacts WHERE lw_contacts.name LIKE '%" . trim($SearchName) . "%'  AND lw_contacts.deleted!=1";
			
						
			$resultcontactidfetch=DB_query($sqlcontactnamefetch,$db);
			
			$myrowcontactidfetch=DB_fetch_array($resultcontactidfetch);
			
								
			$sqlpartytrans = "SELECT 
				lw_contacts.name,
				lw_cases.brief_file,
				lw_cases.courtcaseno,
			    lw_cases.glcode
				FROM lw_cases INNER JOIN lw_contacts
				ON lw_cases.party=lw_contacts.id
			WHERE lw_contacts.id = '" . trim($myrowcontactidfetch[0]) . "'  AND lw_contacts.deleted!=1";
			
			$resultnew = DB_query($sqlpartytrans,$db);
			$myrow = DB_fetch_array($resultnew);
			
			
			
		//	echo 'brief_file fetch=' . $myrow[1];

//if Brief_file entry is found in lw_partyeconomy then fetch total fees and balance from the table as pass on to the text boxes

			$sqltotalfees = "SELECT lw_partyeconomy.totalfees,lw_partyeconomy.balance
				FROM lw_partyeconomy WHERE lw_partyeconomy.brief_file = '" . $myrow[1] . "'";
											
			$resulttotalfees = DB_query($sqltotalfees,$db);
			$myrowtotalfees = DB_fetch_array($resulttotalfees);

		if($myrowtotalfees>0)
		{
		$_POST['Totalfees'] = $myrowtotalfees['totalfees'];
		$_POST['Balance'] = $myrowtotalfees['balance'];
        }
						
			} elseif (isset($Brief_File_Search))
			
			{
			
			
			$sqlpartytrans = "SELECT 
				 lw_contacts.name,
				 lw_cases.brief_file,
				 lw_cases.courtcaseno,
				 lw_cases.glcode				
				FROM lw_cases INNER JOIN lw_contacts
				ON lw_cases.party=lw_contacts.id
			WHERE lw_cases.brief_file = '" . $Brief_File_Search . "'";
			
						
			$resultnew = DB_query($sqlpartytrans,$db);
			$myrow = DB_fetch_array($resultnew);
		
//if Brief_file entry is found in lw_partyeconomy then fetch total fees and balance from the table as pass on to the text boxes

			$sqltotalfees = "SELECT lw_partyeconomy.totalfees,lw_partyeconomy.balance
				FROM lw_partyeconomy WHERE lw_partyeconomy.brief_file = '" . $Brief_File_Search . "'";
						
			$resulttotalfees = DB_query($sqltotalfees,$db);
			$myrowtotalfees = DB_fetch_array($resulttotalfees);
			
			if($myrowtotalfees>0)
			{
			$_POST['Totalfees'] = $myrowtotalfees['totalfees'];
			$_POST['Balance'] = $myrowtotalfees['balance'];
			}
			
			//if Brief_file entry is found in lw_partyeconomy then fetch total fees and balance from the table as pass on to the text boxes

			$sqlamtreceived = "SELECT Sum(lw_partytrans.amountreceived) FROM lw_partytrans WHERE lw_partytrans.brief_file = '" . $Brief_File_Search . "'";
						
			$resultamtreceived = DB_query($sqlamtreceived,$db);
			$myrowamtreceived = DB_fetch_array($resultamtreceived);
			
			if($myrowtotalfees>0)
			{
			$_POST['Totalfees'] = $myrowtotalfees['totalfees'];
			$_POST['Balance'] = $myrowtotalfees['balance'];
			}
				
		
}

			
		$_POST['ID'] = $myrow['id'];
		$_POST['Partyname'] = $myrow['name'];
		$_POST['Brief_File_No'] = $myrow['brief_file'];
		$_POST['Courtcaseno'] = $myrow['courtcaseno'];
		$_POST['Receivedt'] = $myrow['receivedt'];
		$_POST['Chequeno'] = $myrow['chequeno'];
		$_POST['Chequedt'] = $myrow['chequedate'];
		$_POST['Bankname'] = $myrow['bankname'];
		$_POST['Narration'] = $myrow['narration'];
		
		
			echo "<form enctype='multipart/form-data' method='post' action=" . $_SERVER['PHP_SELF'] . '>';

			$DataError =0; 
			
    		?>
      
       
  			<?php echo '<div id="leftcenter" style="width:100%; float:left; position:relative; margin-top:0px; margin-left:0px">';

            echo '<div  id="form_containereconominy" >';
		   
		  
		   
   			echo '<table width="330" height="20" border="0" align="left" style="margin-left:0px" >';
		
			echo '<tr><td><label>Party Name :&nbsp;&nbsp; </label><input type="text" style="background-color:#D4D4D4" name="Partyname" value="' . $_POST['Partyname'] . '"  size=35></td>';
			
			
			$result = DB_query($sqlpartytrans,$db);
        
	
		
			echo '<tr><td><label>Brief_file No.: </label><select tabindex="16" name="Brief_File_Fetched" id="Brief_File_Fetched" >';

			while ($myrow = DB_fetch_array($result)) {
			echo "<option VALUE='". $myrow[1] . "'>" . $myrow[1] . '</option>';
				} //end while loop

			DB_free_result($result);

			echo '</select></td></tr>';
			
			
						
			echo '<tr><td><label>Receipt Type:</label>&nbsp;&nbsp;<select tabindex=6 name="ReceiptType" id="ReceiptType">';

		include('includes/GetPaymentMethods.php');
/* The array ReceiptTypes is defined from the setup tab of the main menu under payment methods - the array is populated from the include file GetPaymentMethods.php */

foreach ($ReceiptTypes as $RcptType) {
	if (isset($_POST['ReceiptType']) and $_POST['ReceiptType']==$RcptType){
		echo "<option selected Value='$RcptType'>$RcptType";
	} else {
		echo "<option Value='$RcptType'>$RcptType";
	}
}
echo '</select></td></tr></table>	';   
			
	 $DateString = Date($_SESSION['DefaultDateFormat']);  ?>
     <div name="Chequeform" id="Chequeform" style="position:static; float:left; margin-top:100px; margin-left:-250px; width:100px">

    <?php
	
		
			echo '<table align="center"><tr><td><label>Our Bank Name:</label>';
			
$SQL = 'SELECT bankaccountname,
			bankaccounts.accountcode,
			bankaccounts.currcode
		FROM bankaccounts,
			chartmaster
		WHERE bankaccounts.accountcode=chartmaster.accountcode';


$ErrMsg = 'The bank accounts could not be retrieved because';
$DbgMsg = 'The SQL used to retrieve the bank accounts was';
$AccountsResults = DB_query($SQL,$db,$ErrMsg,$DbgMsg);

echo '<br><select tabindex=1 name="Ourbankcode">';

	while ($myrow=DB_fetch_array($AccountsResults)){
				
			echo '<option value="' . $myrow['accountcode'] . '">' . $myrow['bankaccountname']. ' - ' . $myrow['currcode'] . '</option>';
		}
	
	echo '</select></td></tr>';
    		echo '<br><table><tr><td><label>Cheque/NEFT-RTGS No:</label>
			<br><input tabindex=2 type="Text" name="Chequeno" id="Chequeno" value="' . $_POST['Chequeno'] . '"  size=15 maxlength=14></td></tr>';
			echo '<tr><td><label>Cheque/NEFT-RTGS Date:</label>
			<br><input tabindex=2 type="Text" name="Chequedt" id="Chequedt" class=date alt="' . $_SESSION['DefaultDateFormat'] . '" value="00/00/000" size=15 maxlength=14></td></tr>';
			echo '<tr><td><label>Cheque from Bank:</label>
			<br><input tabindex=2 type="Text" name="Custbankname" id="Custbankname" value="' .$_POST['Bankname'] . '"   size=15 maxlength=14></td></tr>';
			echo '<tr><td><label>Narration:</label>
			<br><input tabindex=2 type="Text" name="Narration" id="Narration" value="' .$_POST['Narration'] . '"  size=50 maxlength=49 ></td></tr>
			</table></div>'; ?>
			
<div name="Directcredit" id="Directcredit" style="position:static; float:left; margin-top:120px; margin-left:-250px; width:100px">

<?php
	 $DateString = Date($_SESSION['DefaultDateFormat']);
    		
			echo '<table align="center"><tr><td><label>Our Bank Name:</label>';
			
$SQL = 'SELECT bankaccountname,
			bankaccounts.accountcode,
			bankaccounts.currcode
		FROM bankaccounts,
			chartmaster
		WHERE bankaccounts.accountcode=chartmaster.accountcode';


$ErrMsg = 'The bank accounts could not be retrieved because';
$DbgMsg = 'The SQL used to retrieve the bank accounts was';
$AccountsResults = DB_query($SQL,$db,$ErrMsg,$DbgMsg);

echo '<br><select tabindex=1 name="Ourbank">';

	while ($myrow=DB_fetch_array($AccountsResults)){
				
			echo '<option value="' . $myrow['accountcode'] . '">' . $myrow['bankaccountname']. ' - ' . $myrow['currcode'] . '</option>';
		}
	
	echo '</select></td></tr>';

			echo '<tr><td><label>Narration:</label>
			<br><input tabindex=2 type="Text" name="Narration" id="Narration" size=50 maxlength=49 ></td></tr>
			</table></div>';          
  					//end of direct credit form elements

	
		echo '<div style="position:fixed; float:right; margin-top:30px;  margin-left:600px; width:50px"><table><tr><td><label>Total Legal Fees:</label>
			<input tabindex=2 type="Text" name="Totalfees" id="Totalfees" class=number value="' . $_POST['Totalfees'] . '"  size=30 maxlength=28 placeholder="Number"></td></tr>';

		 
			echo '<tr><td>&nbsp;<label>Balance Amt:</label>
			<br><input tabindex=2 type="Text" name="Balance" id="Balance" value="' . $_POST['Balance'] . '"  size=18 maxlength=16 placeholder="Total Balance">
			</td></tr>';
			
    		echo '<td><label>Received Date:</label>
			<br><input tabindex=2 type="Text" name="Receivedt" id="Receivedt" class=date alt="' . $_SESSION['DefaultDateFormat'] . '" value="' . $DateString . '" size=15 maxlength=14></td></tr>';
			
			
			echo '<tr><td><label>Amount Received:</label>
			<br><input tabindex=2 type="Text" name="Amountreceived" id="Amountreceived" class=number size=15 maxlength=14 placeholder="Number"></td>
			</tr>';
			
	
		echo "<tr><td><input tabindex=20 type='Submit' name='submit' value=Save><input tabindex=22 type=submit VALUE='Back'>";
			
		echo '</td></tr></table></div></div></form>';

} // end of main ifs


}


?>


</div>