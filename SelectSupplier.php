<?php

/* $Revision: 1.27 $ */

if (empty($_POST['Show'])){
include('includes/GLPostings.inc');

echo "<form method='POST' action=" . $_SERVER['PHP_SELF'] . '?' . SID . '>';

/*Dates in SQL format for the last day of last month*/
$DefaultPeriodDate = Date ('Y-m-d', Mktime(0,0,0,Date('m'),0,Date('Y')));

/*Show a form to allow input of criteria for TB to show */
// End select tag
        ?>

 <div class="uk-width-medium-2-2">

        <div class="uk-grid">
		<?php
echo "<div class='uk-width-medium-1-1' style='padding-bottom:20px'><h4>Select Date range and click on Show Accounts</h4></div>";
echo '<div class="uk-width-medium-1-3" style="padding-bottom:10px">
           
From <input class="md-input" type="text" name="fromdate" id="fromdate" data-uk-datepicker="{format:\'DD/MM/YYYY\'}"></div>';

echo '<div class="uk-width-medium-1-3" style="padding-bottom:10px">
           
To <input class="md-input" type="text" name="todate" id="todate" data-uk-datepicker="{format:\'DD/MM/YYYY\'}"></div>';

      
    //echo '<input type="hidden"  name="Transno" id="Transno">';
      
    echo '<input type="hidden"  name="Supplierid" id="Supplierid">';
	
	echo '<input type="hidden"  name="Suppliername" id="Suppliername">';
	  
echo "<div class='uk-width-medium-1-3' style='padding-bottom:20px'><input type='submit' name='Show' class='md-btn md-btn-primary' VALUE='"._('Show Accounts')."' onClick='return checkvalidity()'></div></form>";

}elseif(isset($_POST['Show'])){

if (isset($_POST['Supplierid'])){
	$Supplierid = $_POST['Supplierid'];
} elseif (isset($_GET['Supplierid'])){
	$Supplierid = $_GET['Supplierid'];
}


 $title = _('Supplier Inquiry');

// always figure out the SQL required from the inputs available

if(!isset($Supplierid)){
	prnMsg(_('To display the enquiry a supplier must first be selected from the supplier selection screen'),'info');
	echo "<br><div class='centre'><a href='". $rootpath . "/lw_Selectsupplier_alt.php?" . SID . "'>" . _('Select a Supplier to Inquire On') . '</a><br></div>';
	
	exit;
} else {
	if (isset($Supplierid)){
		$_SESSION['Supplierid'] = $Supplierid;
	}
	$Supplierid = $_SESSION['Supplierid'];
}



if (!isset($_POST['TransAfterDate'])) {
	$_POST['TransAfterDate'] = Date($_SESSION['DefaultDateFormat'],Mktime(0,0,0,Date('m')-1,Date('d'),Date('Y')));
}


$SQL = "SELECT lw_contacts_other.name,
		currencies.currency,
        supptrans.supplierid,
        supptrans.currcode
		FROM supptrans INNER JOIN lw_contacts_other
        ON supptrans.supplierid=lw_contacts_other.id INNER JOIN currencies
     	ON 	supptrans.currcode=currencies.currabrev	               
		WHERE supptrans.supplierid= '" . $Supplierid . "'";

$ErrMsg = _('The Supplier details could not be retrieved by the SQL because');
$SupplierResult = DB_query($SQL,$db,$ErrMsg);

	
$SupplierRecord = DB_fetch_array($SupplierResult);



echo "<br><div class='centre'><form action='" . $_SERVER['PHP_SELF'] . "' method=post>";
echo "</div></form><br>";

$DateAfterCriteria = FormatDateForSQL($_POST['TransAfterDate']);

$fromdate=FormatDateForSQL($_POST['fromdate']);
$todate=FormatDateForSQL($_POST['todate']);
$td=($_POST['todate']);
echo "<div class='uk-width-medium-2-2'><div class='uk-grid'>";


echo "<div class='uk-width-medium-1-2' style='text-align:left'><h4>Name : " . $SupplierRecord['name'] . ' - All amounts in' . ' ' . $SupplierRecord['currency'] . "</h4></div>";
echo "<div class='uk-width-medium-1-2' style='text-align:right; padding-right:50px'><b>$td</b></div></div></div>";


$SQL = 'SELECT lw_contacts_other.name,
		currencies.currency,
        supptrans.supplierid,
        supptrans.glcode,
        supptrans.type,
		supptrans.transno,
        supptrans.amount,
		supptrans.date,
		supptrans.narration,
        supptrans.currcode
		FROM supptrans INNER JOIN lw_contacts_other
        ON supptrans.supplierid=lw_contacts_other.id INNER JOIN currencies
     	ON 	supptrans.currcode=currencies.currabrev	               
		WHERE supptrans.supplierid= "' . $Supplierid . '"
		AND supptrans.date >= "' . $fromdate . '" AND supptrans.date <="' . $todate . '"
		ORDER BY supptrans.id'; 

$ErrMsg = _('No transactions were returned by the SQL because');
$TransResult = DB_query($SQL,$db,$ErrMsg);

/*show a table of the invoices returned by the SQL*/
echo '<i class="md-icon material-icons" id="invoice_print">&#xE8ad;</i>';
echo '<table class="uk-table" style="margin-top:10px">';

$tableheader = "<tr>
		<th>" . _('Type') . "</th>
		<th>" . _('Trans Number') . "</th>
        <th>" . _('Date') . "</th>
		<th>" . _('Narration') . "</th>
        <th>" . _('Debit') . "</th>
		<th>" . _('Credit') . "</th></tr>";

echo $tableheader;

$j = 1;
$k=0; //row colour counter

//there are partytransaction records to display
while ($myrow=DB_fetch_array($TransResult)) {

  if ($k==1){ 
		echo '<tr class="EvenTableRows">';
		$k=0;
	} else {
		echo '<tr class="OddTableRows">';
		$k=1;
	}

	$FormatedTranDate = ConvertSQLDate($myrow['trandate']);
 	$base_formatstr = "<td>%s</td>
                        <td>%s</td>  
						<td>%s</td> 
                        <td class=number>%s</td>
                        <td class=number>%s</td>
						<td class=number>%s</td>
                       ";
					
if (in_array(3,$_SESSION['AllowedPageSecurityTokens']) && $myrow['type']==10){ /*Show a link to allow an invoice to be credited */

		printf($base_formatstr .
			'</tr>',	
            $myrow['type'],
            $myrow['transno'],
			ConvertSQLDate($myrow['date']),
			$myrow['narration'],
			$DebitAmount,
			$CreditAmount	
			);
	}
	
	if ($myrow['type']==12) { /*its a receipt */	
	
			
		if ($_SESSION['CompanyRecord']['gllink_debtors']== 1 AND in_array(8,$_SESSION['AllowedPageSecurityTokens'])){
			printf($base_formatstr .
				"<td><a href='%s/GLTransInquiry.php?%s&TypeID=%s&TransNo=%s'>" . _('View GL Entries') . ' <a></td></tr>',
				$myrow['typename'],
				$myrow['transno'],
				$myrow['brief_file'],
				ConvertSQLDate($myrow['date']),
				$myrow['narration'],
				number_format($myrow['amount'],2),
				$rootpath,
				SID,
				$myrow['type'],
				$myrow['transno']);
		} else {
		
		if($myrow['type']==13){
			$DebitAmount = $myrow['amount'];
			$CreditAmount = '';
		} elseif($myrow['type']==12) {		
			$CreditAmount = $myrow['amount'];
			$DebitAmount = '';	
		}	
				
		
				
		//party trans for cash and bank receipts
			printf($base_formatstr . '<td></tr>',
				$myrow['type'],
				$myrow['transno'],
				ConvertSQLDate($myrow['date']),
				$myrow['narration'],
				$DebitAmount,
				$CreditAmount
				);
		}
	}//end of if statement for receipt
	
	if ($myrow['type']==13) { /*its a payment */	
	
			
		if ($_SESSION['CompanyRecord']['gllink_debtors']== 1 AND in_array(8,$_SESSION['AllowedPageSecurityTokens'])){
			printf($base_formatstr .
				"<td><a href='%s/GLTransInquiry.php?%s&TypeID=%s&TransNo=%s'>" . _('View GL Entries') . ' <a></td></tr>',
				$myrow['typename'],
				$myrow['transno'],
				$myrow['brief_file'],
				ConvertSQLDate($myrow['date']),
				$myrow['narration'],
				number_format($myrow['amount'],2),
				$rootpath,
				SID,
				$myrow['type'],
				$myrow['transno']);
		} else {
		
		if($myrow['type']==13){
			$DebitAmount = $myrow['amount'];
			$CreditAmount = '';
		} 		
				
		//party trans for cash and bank receipts
			printf($base_formatstr . '<td></tr>',
				$myrow['type'],
				$myrow['transno'],
				ConvertSQLDate($myrow['date']),
				$myrow['narration'],
				$DebitAmount,
				$CreditAmount
				);
		}
	}//end of if statement for payment
	
  
}

//end of while loop

echo '</table>';

?>
                          
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
 <script src="print.js"></script>


<script>

	//below is for main search for the lw_casenewajax form
	jQuery(".selectsupplier").ajaxlivesearch({
        loaded_at: <?php echo $time; ?>,
        token: <?php echo "'" . $token . "'"; ?>,
        max_input: <?php echo $maxInputLength; ?>,
        onResultClick: function(e, data) {
            // get the index 1 (second column) value
            var selectedsearchsupplierid = jQuery(data.selected).find('td').eq('0').text();
			var selectedsuppliername = jQuery(data.selected).find('td').eq('1').text();
			

            // set the input value
            jQuery('.selectsupplier').val(selectedsuppliername);
			
			jQuery('#Supplierid').val(selectedsearchsupplierid);
			
			//jQuery('#Transno').val(selectedtransno);
			
			jQuery('#Suppliername').val(selectedsuppliername);			
			
		// hide the result
           jQuery(".selectsupplier").trigger('ajaxlivesearch:hide_result');
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


if($("#Supplierid").val()==0)
	{

alert("Please search and select supplier name!!");

return false;
	}
	
	

}

	
	
</script>    
