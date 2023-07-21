<?php

/* $Revision: 1.27 $ */


$title = _('Customer Ledger');

include('includes/GLPostings.inc');

echo '<br>';

echo "<form method='POST' action=" . $_SERVER['PHP_SELF'] . '?' . SID . '>';

/*Dates in SQL format for the last day of last month*/
$DefaultPeriodDate = Date ('Y-m-d', Mktime(0,0,0,Date('m'),0,Date('Y')));

/*Show a form to allow input of criteria for TB to show */
echo '<table>';
        
// End select tag
         echo '<tr>
         <td>'._('Select Period range with Shift Key').':</td>
         <td><select Name=Period[] multiple class="md-input" style="width:220px; height:200px">';
	 $sql = 'SELECT periodno, lastdate_in_period FROM periods ORDER BY periodno DESC';
	 $Periods = DB_query($sql,$db);
         $id=0;
         while ($myrow=DB_fetch_array($Periods,$db)){

            if(isset($SelectedPeriod[$id]) and $myrow['periodno'] == $SelectedPeriod[$id]){
              echo '<option selected VALUE=' . $myrow['periodno'] . '>' . _(MonthAndYearFromSQLDate($myrow['lastdate_in_period']));
            $id++;
            } else {
              echo '<option VALUE=' . $myrow['periodno'] . '>' . _(MonthAndYearFromSQLDate($myrow['lastdate_in_period']));
            }

         }
         echo "</select></td>
        </tr>
</table>";

 	echo '<input type="hidden"  name="Brief_File" id="Brief_File">';
      
    echo '<input type="hidden"  name="Party" id="Party">';
      
    echo '<input type="hidden"  name="CustomerID" id="CustomerID">';
	  
echo "<div><input type='submit' name='Show' class='md-btn md-btn-primary' VALUE='"._('Show Account Transactions')."' onClick='return checkvalidity()'></div></form>";

/* End of the Form  rest of script is what happens if the show button is hit*/

if (isset($_POST['Show'])){

if (isset($_POST['Account'])){
	$SelectedAccount = $_POST['Account'];
} elseif (isset($_GET['Account'])){
	$SelectedAccount = $_GET['Account'];
}

if (isset($_POST['Period'])){
	$SelectedPeriod = $_POST['Period'];
} elseif (isset($_GET['Period'])){
	$SelectedPeriod = $_GET['Period'];
}

if (isset($_POST['CustomerID'])){
	$CustomerID = $_POST['CustomerID'];
} elseif (isset($_GET['CustomerID'])){
	$CustomerID = $_GET['CustomerID'];
}


	if (!isset($SelectedPeriod)){
		prnMsg(_('A period or range of periods must be selected from the list box'),'info');
		
		exit;
	}
	 $title = _('Customer Inquiry');

// always figure out the SQL required from the inputs available

if(!isset($CustomerID)){
	prnMsg(_('To display the enquiry a customer must first be selected from the customer selection screen'),'info');
	echo "<br><div class='centre'><a href='". $rootpath . "/SelectCustomer.php?" . SID . "'>" . _('Select a Customer to Inquire On') . '</a><br></div>';
	
	exit;
} else {
	if (isset($CustomerID)){
		$_SESSION['CustomerID'] = $CustomerID;
	}
	$CustomerID = $_SESSION['CustomerID'];
}


if (!isset($_POST['TransAfterDate'])) {
	$_POST['TransAfterDate'] = Date($_SESSION['DefaultDateFormat'],Mktime(0,0,0,Date('m')-1,Date('d'),Date('Y')));
}

$SQL = "SELECT lw_contacts.name,
		currencies.currency,
        lw_partyeconomy.invoiceno,
        lw_partyeconomy.brief_file,
        lw_partyeconomy.courtcaseno,
        lw_partyeconomy.totalfees,
		lw_partyeconomy.balance,
        lw_partyeconomy.currcode
		FROM lw_partyeconomy INNER JOIN  lw_contacts
        ON lw_partyeconomy.party=lw_contacts.id INNER JOIN currencies
     	ON 	lw_partyeconomy.currcode=currencies.currabrev	               
		WHERE lw_partyeconomy.party = '" . $CustomerID . "'";

$ErrMsg = _('The customer details could not be retrieved by the SQL because');
$CustomerResult = DB_query($SQL,$db,$ErrMsg);

if (DB_num_rows($CustomerResult)==0){

	/*Because there is no balance - so just retrieve the header information about the customer - the choice is do one query to get the balance and transactions for those customers who have a balance and two queries for those who dont have a balance OR always do two queries - I opted for the former */

	$NIL_BALANCE = True;

	$SQL = "SELECT lw_contacts.name, lw_partyeconomy.totalfees,lw_partyeconomy.balance,currencies.currency
	FROM lw_partyeconomy INNER JOIN lw_contacts ON lw_partyeconomy.party=lw_contacts.id,currencies WHERE lw_partyeconomy.party = '" . $CustomerID . "'";

	$ErrMsg =_('The customer details could not be retrieved by the SQL because');
	$CustomerResult = DB_query($SQL,$db,$ErrMsg);

} else {
	$NIL_BALANCE = False;
}

$CustomerRecord = DB_fetch_array($CustomerResult);

if ($NIL_BALANCE==True){
	$CustomerRecord['balance']=0;
	
} 
	echo '<p style="text-align:center"><img src="'.$rootpath.'/selectclient.png" title="' . 
	_('Customer') . '" alt="">' . ' ' . _('Client Name') . ' : ' . $CustomerRecord['name'] . ' - (' . _('All amounts in') . 
	' ' . $CustomerRecord['currency'] . ')';



echo "<br><div class='uk-width-medium-1-2' style='padding-bottom:0px'><form action='" . $_SERVER['PHP_SELF'] . "' method=post>";
echo _('Show all transactions after') . ": <input tabindex=1 type=text class='md-input' data-uk-datepicker='{format:'DD.MM.YYYY'}' id='datepicker' name='TransAfterDate' Value='" . $_POST['TransAfterDate'] . "' MAXLENGTH =10 size=12>" .
"<input tabindex=2 type=submit class='md-btn md-btn-primary' name='Refresh Inquiry' value='" . _('Refresh Inquiry') . "'></div></form><br>";

$DateAfterCriteria = FormatDateForSQL($_POST['TransAfterDate']);


$SQL = "SELECT 
		lw_partytrans.type,
        lw_partytrans.invoiceno,
		lw_partytrans.transno,
        lw_partytrans.brief_file,
		lw_partytrans.receivedt,
		lw_partytrans.narration,
        lw_partytrans.amountreceived		
	FROM lw_partytrans WHERE lw_partytrans.party = '" . $CustomerID . "'
	AND lw_partytrans.receivedt >= '$DateAfterCriteria'
	ORDER BY lw_partytrans.id"; 

$ErrMsg = _('No transactions were returned by the SQL because');
$TransResult = DB_query($SQL,$db,$ErrMsg);

$TransResultanother = DB_query($SQL,$db);

$myrowanothertrans=DB_fetch_array($TransResultanother);

$transresult=$myrowanothertrans;

$SQLinvoice = "SELECT 
		lw_partyeconomy.type,  
		lw_partyeconomy.invoiceno, 
		lw_partyeconomy.brief_file,     		
        lw_partyeconomy.totalfees,
		lw_partyeconomy.t_date        		
	FROM lw_partyeconomy WHERE lw_partyeconomy.party = '" . $CustomerID . "'"; 

$InvoiceResult = DB_query($SQLinvoice,$db);

/*show a table of the invoices returned by the SQL*/

echo '<table class="uk-table">';

$tableheader = "<tr>
		<th>" . _('Type') . "</th>
        <th>" . _('Invoice Number') . "</th>
		<th>" . _('Trans Number') . "</th>
        <th>" . _('Brief File') . "</th>
		<th>" . _('Receive Date') . "</th>
		<th>" . _('Narration') . "</th>
        <th>" . _('Debit') . "</th>
		<th>" . _('Credit') . "</th>
		</tr>";

echo $tableheader;

$j = 1;
$k=0; //row colour counter

$invcounter=0;

if($transresult<=0)
{

while($myrowinvoice=DB_fetch_array($InvoiceResult))
    {
    echo '<tr><td>' . $myrowinvoice['type'] . '</td><td>'.$myrowinvoice['invoiceno'] .'</td><td></td><td>' .$myrowinvoice['brief_file'].'<td>' .ConvertSQLDate($myrowinvoice['t_date']). '</td><td></td><td>'. $myrowinvoice['totalfees'] .'<td></td>';
	
	//echo '<tr><td>' . $myrowinvoice['type'] . '</td><td>'.$myrowinvoice['invoiceno'] .'</td><td></td><td>' .$myrowinvoice['brief_file'].'<td>' .ConvertSQLDate($myrowinvoice['t_date']). '</td><td></td><td>'. $myrowinvoice['totalfees'] .'<td></td><td><a href=PDFInvoice.php?Invoiceno='. $myrow['invoiceno'] . '&Transno=' . $myrow['invoiceno'] . ' target="_blank">PDF<IMG SRC="img/pdf.png" title="Click for PDF Invoice"></a></td><td><a href=EmailCustTrans.php?Invoice='. $myrow['invoiceno'] .'&Transno='. $myrow['invoiceno'] .' target="_blank">Email<IMG SRC="img/email.gif" title="Click to email the invoice"></a></td>';
        
        $invcounter++;
    }
    
	

}else//end of if condition if there is no partytrans record to display
{
//there are partytransaction records to display
while ($myrow=DB_fetch_array($TransResult)) {

    
while($myrowinvoice=DB_fetch_array($InvoiceResult))
    {
    echo '<tr><td>' . $myrowinvoice['type'] . '</td><td>'.$myrowinvoice['invoiceno'] .'</td><td></td><td>' .$myrowinvoice['brief_file'].'<td>' .ConvertSQLDate($myrowinvoice['t_date']). '</td><td></td><td>'. $myrowinvoice['totalfees'] .'<td></td>';
        
        $invcounter++;
    }
	
    
	if ($k==1){ 
		echo '<tr class="EvenTableRows">';
		$k=0;
	} else {
		echo '<tr class="OddTableRows">';
		$k=1;
	}

 
	$FormatedTranDate = ConvertSQLDate($myrow['trandate']);
 	$base_formatstr = "<td>%s</td>
						<td></td>  
                        <td>%s</td>  						
                        <td>%s</td>  
						<td>%s</td> 
                        <td class=number>%s</td>
                        <td class=number>%s</td>
						<td class=number>%s</td>
                       ";
					
if (in_array(3,$_SESSION['AllowedPageSecurityTokens']) && $myrow['type']==10){ /*Show a link to allow an invoice to be credited */

		if($myrow['type']==10) { /*its an sales invoice but not high enough privileges to credit it */
       // echo 'reached invoice';
		printf($base_formatstr .
			'</tr>',	
            $myrow['type'],
            $myrow['invoiceno'],
			$myrow['transno'],
			$myrow['brief_file'],
            ConvertSQLDate($myrow['receivedt']),
			$myrow['narration'],
			number_format($myrow['amountreceived'],2)		
			);

	}
	}
	
	//echo 'reached party transaction' . $CustomerID .''.$myrow['type'];
	
	if ($myrow['type']==12) { /*its a negative receipt */		
		
		if ($_SESSION['CompanyRecord']['gllink_debtors']== 1 AND in_array(8,$_SESSION['AllowedPageSecurityTokens'])){
			printf($base_formatstr .
				"<td><a href='%s/GLTransInquiry.php?%s&TypeID=%s&TransNo=%s'>" . _('View GL Entries') . ' <a></td></tr>',
				$myrow['typename'],
				$myrow['transno'],
				$myrow['brief_file'],
				ConvertSQLDate($myrow['receivedt']),
				$myrow['narration'],
				number_format($myrow['totalamount'],2),
				number_format($myrow['allocated'],2),
				number_format($myrow['totalamount']-$myrow['allocated'],2),
				$rootpath,
				SID,
				$myrow['type'],
				$myrow['transno']);
		} else {
		
		/*if($myrow['amountreceived']>=0){
			$DebitAmount = number_format($myrow['amountreceived'],2);
			$CreditAmount = '';
		} else {
		
			$CreditAmount = number_format(-$myrow['amountreceived'],2);
			$DebitAmount = '';	
		}*/
		
		if($myrow['type']==13){
			$DebitAmount = $myrow['amountreceived'];
			$CreditAmount = '';
		} else if($myrow['type']==12){
		
			$CreditAmount = $myrow['amountreceived'];
			$DebitAmount = '';	
		}
				
		//party trans for cash and bank receipts
			printf($base_formatstr . '<td></tr>',
				$myrow['type'],
				$myrow['transno'],
				$myrow['brief_file'],
				ConvertSQLDate($myrow['receivedt']),
				$myrow['narration'],
				$DebitAmount,
				$CreditAmount
				);
		}
	} else {
	
		if ($_SESSION['CompanyRecord']['gllink_debtors']== 1 AND in_array(8,$_SESSION['AllowedPageSecurityTokens'])){
			printf($base_formatstr .
				"<td><a href='%s/GLTransInquiry.php?%s&TypeID=%s&TransNo=%s'>" . _('View GL Entries') . ' <a></td></tr>',
				$myrow['typename'],
				$myrow['transno'],
				$myrow['brief_file'],
				ConvertSQLDate($myrow['receivedt']),
				$myrow['narration'],
				number_format($myrow['totalamount'],2),
				number_format($myrow['allocated'],2),
				number_format($myrow['totalamount']-$myrow['allocated'],2),
				$rootpath,
				SID,
				$myrow['type'],
				$myrow['transno']);
		} else {
			printf($base_formatstr . '</tr>',
				$myrow['typename'],
				$myrow['transno'],
				$myrow['brief_file'],
				ConvertSQLDate($myrow['receivedt']),
				$myrow['narration'],
				number_format($myrow['totalamount'],2),
				number_format($myrow['allocated'],2),
				number_format($myrow['totalamount']-$myrow['allocated'],2));
		}
	}
    }

}

//end of while loop

echo '</table>';?>

       
         
        
        <div class="uk-width-medium-2-2">

        <div class="uk-grid">
		<?php
echo "<div class='uk-width-medium-1-2' style='padding-bottom:10px'>Total Balance</div>";
echo "<div class='uk-width-medium-1-2' style='padding-bottom:10px; padding-right:50px' align='right'>". number_format($CustomerRecord['balance'],2) . "</div>";
?>
           
      
            </div>

        </div>
 
      

    
                
                </div>
            </div>

        </div>
     </div>
<?php
} /* end of if Show button hit */


if (isset($ShowIntegrityReport) and $ShowIntegrityReport==True){
	if (!isset($IntegrityReport)) {$IntegrityReport='';}
	prnMsg( _('There are differences between the sum of the transactions and the recorded movements in the ChartDetails table') . '. ' . _('A log of the account differences for the periods report shows below'),'warn');
	echo '<p>'.$IntegrityReport;
}

?>
 <!-- Search Form Demo -->

<!-- Placed at the end of the document so the pages load faster -->
<script src="jquery-1.11.1.min.js"></script>

<script src="assets/js/common.js"></script> 

<!-- Live Search Script -->
<script type="text/javascript" src="ajaxlivesearch.js"></script>


<script>

	//below is for main search for the lw_casenewajax form
	jQuery(".mdinputinvalloc").ajaxlivesearch({
        loaded_at: <?php echo $time; ?>,
        token: <?php echo "'" . $token . "'"; ?>,
        max_input: <?php echo $maxInputLength; ?>,
        onResultClick: function(e, data) {
            // get the index 1 (second column) value
            var selectedsearch = jQuery(data.selected).find('td').eq('0').text();
			var selectedparty = jQuery(data.selected).find('td').eq('3').text();			
			var selectedpartyid = jQuery(data.selected).find('td').eq('6').text();
			

            // set the input value
            jQuery('.mdinputinvalloc').val(selectedsearch);
			
			jQuery('#Brief_File').val(selectedsearch);
			
			jQuery('#Party').val(selectedparty);        
			
			jQuery('#CustomerID').val(selectedpartyid);      
		 						
			// hide the result
           jQuery(".mdinputinvalloc").trigger('ajaxlivesearch:hide_result');
        },
        onResultEnter: function(e, data) {
            // do whatever you want
            //jQuery(".mySearch").trigger('ajaxlivesearch:search', {query: 'test'});
        },
        onAjaxComplete: function(e, data) {

        }
    });
	
	function checkvalidity()
{


if($("#Brief_File").val()==0 || $("#Party").val()==0)
	{

alert("Please search and select Brief_File No or Partyname and also select Period range!!");

return false;
	}

}

	
</script>    
