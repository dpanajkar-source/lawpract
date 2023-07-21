<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>

   <link rel="icon" type="image/png" href="assets/img/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="assets/img/favicon-32x32.png" sizes="32x32">

    <title>LawPract&trade;</title>

    <!-- additional styles for plugins -->
        <!-- weather icons -->
        <link rel="stylesheet" href="bower_components/weather-icons/css/weather-icons.min.css" media="all">
       
        <!-- chartist -->
        <link rel="stylesheet" href="bower_components/chartist/dist/chartist.min.css">
    
    <!-- uikit -->
    <link rel="stylesheet" href="bower_components/uikit/css/uikit.almost-flat.min.css" media="all">

    <!-- flag icons -->
    <link rel="stylesheet" href="assets/icons/flags/flags.min.css" media="all">

    <!-- altair admin -->
    <link rel="stylesheet" href="assets/css/main.min.css" media="all">
    
     
     <!-- Live Search Styles -->
    <link rel="stylesheet" href="css/fontello.css">
    <link rel="stylesheet" href="css/animation.css">
    <!--[if IE 7]>
    <link rel="stylesheet" href="css/fontello-ie7.css">
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="css/ajaxlivesearch.min.css">


    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
    <![endif]-->

</head>
<?php

/* $Revision: 1.29 $ */

include('includes/SQL_CommonFunctions.inc');

$PageSecurity = 3;

include('includes/session.php');?>

<body class="sidebar_main_open sidebar_main_swipe">

     <?php include("header.php"); 
           include("menu.php"); 

    $title = 'Customer Inquiry';

// always figure out the SQL required from the inputs available

if(!isset($_GET['CustomerID']) AND !isset($_SESSION['CustomerID'])){
	prnMsg('To display the enquiry a customer must first be selected from the customer selection screen','info');
	echo "<br><div class='centre'><a href='". $rootpath . "/SelectCustomer.php?" . SID . "'>" . 'Select a Customer to Inquire On' . '</a><br></div>';
	
	exit;
} else {
	if (isset($_GET['CustomerID'])){
		$_SESSION['CustomerID'] = $_GET['CustomerID'];
	}
	$CustomerID = $_SESSION['CustomerID'];
}


if (!isset($_POST['TransAfterDate'])) {
	$_POST['TransAfterDate'] = Date($_SESSION['DefaultDateFormat'],Mktime(0,0,0,Date('m')-6,Date('d'),Date('Y')));
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

$ErrMsg = 'The customer details could not be retrieved by the SQL because';
$CustomerResult = DB_query($SQL,$db,$ErrMsg);

if (DB_num_rows($CustomerResult)==0){

	/*Because there is no balance - so just retrieve the header information about the customer - the choice is do one query to get the balance and transactions for those customers who have a balance and two queries for those who dont have a balance OR always do two queries - I opted for the former */

	$NIL_BALANCE = True;

	$SQL = "SELECT lw_contacts.name, lw_partyeconomy.totalfees,lw_partyeconomy.balance,currencies.currency
	FROM lw_partyeconomy INNER JOIN lw_contacts ON lw_partyeconomy.party=lw_contacts.id,currencies WHERE lw_partyeconomy.party = '" . $CustomerID . "'";

	$ErrMsg ='The customer details could not be retrieved by the SQL because';
	$CustomerResult = DB_query($SQL,$db,$ErrMsg);

} else {
	$NIL_BALANCE = False;
}

$CustomerRecord = DB_fetch_array($CustomerResult);

if ($NIL_BALANCE==True){
	$CustomerRecord['balance']=0;
	
}  ?>
    
     <div id="page_content">
        <div id="page_content_inner">
                  
            <div class="md-card">
                <div class="md-card-content">
                    
                            
                <i class="md-icon material-icons" id="invoice_print">&#xE8ad;</i>
            
                
              
                  <?php
	echo '<p class="page_title_text"><img src="'.$rootpath.'/img/customer.png" title="' . 
	'Customer' . '" alt="">' . ' ' . 'Customer' . ' : ' . $CustomerRecord['name'] . ' - (' . 'All amounts in' . 
	' ' . $CustomerRecord['currency'] . ')';

echo " <div class='uk-width-medium-1-2' style='padding-bottom:0px'><table class='uk-table'><tr><th>" . 'Total Balance' . "</th></th></tr>";

echo '<tr><td class=number>' . number_format($CustomerRecord['balance'],2) . '</td></tr></table>';


echo "<br><div class='centre'><form action='" . $_SERVER['PHP_SELF'] . "' method=post>";
echo 'Show all transactions after' . ": <input tabindex=1 type=text class='md-input' data-uk-datepicker='{format:'DD.MM.YYYY'}' id='datepicker' name='TransAfterDate' Value='" . $_POST['TransAfterDate'] . "' MAXLENGTH =10 size=12>" .
"<input tabindex=2 type=submit class='md-btn md-btn-primary' name='Refresh Inquiry' value='" . 'Refresh Inquiry' . "'></div></form><br>";

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

$ErrMsg = 'No transactions were returned by the SQL because';
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
		<th>" . 'Type' . "</th>
        <th>" . 'Invoice Number' . "</th>
		<th>" . 'Trans Number' . "</th>
        <th>" . 'Brief File' . "</th>
		<th>" . 'Receive Date' . "</th>
		<th>" . 'Narration' . "</th>
        <th>" . 'Debit' . "</th>
		<th>" . 'Credit' . "</th>
		<th>" . 'More Info' . "</th>
		<th>" . 'More Info' . "</th></tr>";

echo $tableheader;

$j = 1;
$k=0; //row colour counter

$invcounter=0;

if($transresult<=0)
{

while($myrowinvoice=DB_fetch_array($InvoiceResult))
    {
    echo '<tr><td>' . $myrowinvoice['type'] . '</td><td>'.$myrowinvoice['invoiceno'] .'</td><td></td><td>' .$myrowinvoice['brief_file'].'<td>' .ConvertSQLDate($myrowinvoice['t_date']). '</td><td></td><td>'. $myrowinvoice['totalfees'] .'<td></td><td><a href=PDFInvoice.php?Invoiceno='. $myrow['invoiceno'] . '&Transno=' . $myrow['invoiceno'] . ' target="_blank">PDF<IMG SRC="img/pdf.png" title="Click for PDF Invoice"></a></td><td><a href=EmailCustTrans.php?Invoice='. $myrow['invoiceno'] .'&Transno='. $myrow['invoiceno'] .' target="_blank">Email<IMG SRC="img/email.gif" title="Click to email the invoice"></a></td>';
        
        $invcounter++;
    }
    
	

}else//end of if condition if there is no partytrans record to display
{
while ($myrow=DB_fetch_array($TransResult)) {
    
while($myrowinvoice=DB_fetch_array($InvoiceResult))
    {
    echo '<tr><td>' . $myrowinvoice['type'] . '</td><td>'.$myrowinvoice['invoiceno'] .'</td><td></td><td>' .$myrowinvoice['brief_file'].'<td>' .ConvertSQLDate($myrowinvoice['t_date']). '</td><td></td><td>'. $myrowinvoice['totalfees'] .'<td></td><td><a href=PDFInvoice.php?Invoiceno='. $myrow['invoiceno'] . '&Transno=' . $myrow['invoiceno'] . ' target="_blank">PDF<IMG SRC="img/pdf.png" title="Click for PDF Invoice"></a></td><td><a href=EmailCustTrans.php?Invoice='. $myrow['invoiceno'] .'&Transno='. $myrow['invoiceno'] .' target="_blank">Email<IMG SRC="img/email.gif" title="Click to email the invoice"></a></td>';
        
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
                        <td>%s</td>    
                        <td>%s</td>  
                        <td></td>  
                        <td>%s</td>
                        <td>%s</td>
                        <td></td>
                        <td class=number>%s</td>";


	if (in_array(3,$_SESSION['AllowedPageSecurityTokens']) && $myrow['type']==10){ /*Show a link to allow an invoice to be credited */

		if($myrow['type']==10) { /*its an sales invoice but not high enough privileges to credit it */
       // echo 'reached invoice';
		printf($base_formatstr .
			'</tr>',	
            $myrow['type'],
            $myrow['invoiceno'],
			$myrow['transno'],
            ConvertSQLDate($myrow['receivedt']),
			$myrow['narration'],
			number_format($myrow['amountreceived'],2)		
			);

	} /*elseif ($myrow['type']==11) { /*its a credit note 
		if ($_SESSION['CompanyRecord']['gllink_debtors']== 1 AND in_array(8,$_SESSION['AllowedPageSecurityTokens'])){
			printf($base_formatstr .
				$preview_credit_str .
				"<td><a href='%s/CustomerAllocations.php?AllocTrans=%s'>" . 'Allocation' . "<IMG SRC='" .$rootpath."/css/".$theme."/images/allocation.png' title='" . 'Click to allocate funds' . "'></a></td>
				<td><a href='%s/GLTransInquiry.php?%sTypeID=%s&TransNo=%s'>" . 'View GL Entries' . ' <a><IMG SRC="' .$rootpath.'/css/'.$theme.'/images/gl.png" title="' . 'View the GL Entries' . '"></a></td></tr>',
				$myrow['typename'],
				$myrow['transno'],
				ConvertSQLDate($myrow['trandate']),
				$myrow['branchcode'],
				$myrow['reference'],
				$myrow['invtext'],
				$myrow['order_'],
				number_format($myrow['totalamount'],2),
				number_format($myrow['allocated'],2),
				number_format($myrow['totalamount']-$myrow['allocated'],2),
				$rootpath,
				$myrow['transno'],
				$rootpath.'/css/'.$theme.'/images',
				$myrow['transno'],
				$rootpath,
				$myrow['transno'],
				$rootpath.'/css/'.$theme.'/images',
				$rootpath,
				$myrow['id'],
				$rootpath,
				SID,
				$myrow['type'],
				$myrow['transno']);
		} else {
			printf($base_formatstr .
				$preview_credit_str .
				"<td><a href='%s/CustomerAllocations.php?AllocTrans=%s'>" . 'Allocation' . "<IMG SRC='%s/allocation.png' title='" . 'Click to allocate funds' . "'></a></td>
				</tr>",
				$myrow['typename'],
				$myrow['transno'],
				ConvertSQLDate($myrow['trandate']),
				$myrow['branchcode'],
				$myrow['reference'],
				$myrow['invtext'],
				$myrow['order_'],
				number_format($myrow['totalamount'],2),
				number_format($myrow['allocated'],2),
				number_format($myrow['totalamount']-$myrow['allocated'],2),
				$rootpath,
				$myrow['transno'],
				$rootpath.'/css/'.$theme.'/images',
				$rootpath,
                                $myrow['transno'],
                                $rootpath.'/css/'.$theme.'/images',
				$rootpath,
				$myrow['transno'],
				$rootpath.'/css/'.$theme.'/images',
				$rootpath,
				$myrow['id'],
				$rootpath.'/css/'.$theme.'/images');
		} /*
	} elseif ($myrow['type']==12 AND $myrow['totalamount']<0) { /*its a receipt  which could have an allocation
		if ($_SESSION['CompanyRecord']['gllink_debtors']== 1 AND in_array(8,$_SESSION['AllowedPageSecurityTokens'])){
			printf($base_formatstr .
				"<td><a href='%s/CustomerAllocations.php?AllocTrans=%s'>" . 'Allocation' . "<IMG SRC='" .$rootpath."/css/".$theme."/images/allocation.png' title='" . 'Click to allocate funds' . "'></a></td>
				<td><a href='%s/GLTransInquiry.php?%s&TypeID=%s&TransNo=%s'>" . 'View GL Entries' . " <IMG SRC='" .$rootpath."/css/".$theme."/images/gl.png' title='" . 'View the GL Entries' . "'></a></td>
				</tr>",
				$myrow['typename'],
				$myrow['transno'],
				ConvertSQLDate($myrow['trandate']),
				$myrow['branchcode'],
				$myrow['reference'],
				$myrow['invtext'],
				$myrow['order_'],
				number_format($myrow['totalamount'],2),
				number_format($myrow['allocated'],2),
				number_format($myrow['totalamount']-$myrow['allocated'],2),
				$rootpath,
				$myrow['id'],
				$rootpath,
				SID,
				$myrow['type'],
				$myrow['transno']);
		} 
       else {
			printf($base_formatstr .
				"<td><a href='%s/CustomerAllocations.php?AllocTrans=%s'>" . 'Allocation' . "<IMG SRC='" .$rootpath."/css/".$theme."/images/allocation.png' title='" . 'Click to allocate funds' . "'></a></td>
				</tr>",
				$myrow['typename'],
				$myrow['transno'],
				ConvertSQLDate($myrow['trandate']),
				$myrow['branchcode'],
				$myrow['reference'],
				$myrow['invtext'],
				$myrow['order_'],
				number_format($myrow['totalamount'],2),
				number_format($myrow['allocated'],2),
				number_format($myrow['totalamount']-$myrow['allocated'],2),
				$rootpath,
				$myrow['id']);
		}*/
	elseif ($myrow['type']==12 OR $myrow['type']==13 AND $myrow['totalamount']>0) { /*its a receipt */
		if ($_SESSION['CompanyRecord']['gllink_debtors']== 1 AND in_array(8,$_SESSION['AllowedPageSecurityTokens'])){
			printf($base_formatstr .
				"<td><a href='%s/GLTransInquiry.php?%s&TypeID=%s&TransNo=%s'>" . 'View GL Entries' . ' <a></td></tr>',
				$myrow['typename'],
				$myrow['transno'],
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
			printf($base_formatstr . '<td></tr>',
				$myrow['typename'],
				$myrow['transno'],
				ConvertSQLDate($myrow['receivedt']),
				$myrow['narration'],
				number_format($myrow['totalamount'],2),
				number_format($myrow['allocated'],2),
				number_format($myrow['totalamount']-$myrow['allocated'],2));
		}
	} else {
		if ($_SESSION['CompanyRecord']['gllink_debtors']== 1 AND in_array(8,$_SESSION['AllowedPageSecurityTokens'])){
			printf($base_formatstr .
				"<td><a href='%s/GLTransInquiry.php?%s&TypeID=%s&TransNo=%s'>" . 'View GL Entries' . ' <a></td></tr>',
				$myrow['typename'],
				$myrow['transno'],
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
				ConvertSQLDate($myrow['receivedt']),
				$myrow['narration'],
				number_format($myrow['totalamount'],2),
				number_format($myrow['allocated'],2),
				number_format($myrow['totalamount']-$myrow['allocated'],2));
		}
	}
    }

}

}
//end of while loop

echo '</table>';

?>
                          
                </div>
            </div>

        </div>
     </div>


       <!-- common functions -->
    <script src="assets/js/common.min.js"></script>
    <!-- uikit functions -->
    <script src="assets/js/uikit_custom.min.js"></script>
    <!-- altair common functions/helpers -->
    <script src="assets/js/altair_admin_common.min.js"></script>

    <!-- page specific plugins -->
   
        <!-- chartist (charts) -->
        <script src="bower_components/chartist/dist/chartist.min.js"></script>
        <!-- maplace (google maps) -->
        
        <script src="bower_components/maplace.js/src/maplace-0.1.3.js"></script>
        <!-- peity (small charts) -->
        <script src="bower_components/peity/jquery.peity.min.js"></script>
      
        <!-- countUp -->
        <script src="bower_components/countUp.js/countUp.min.js"></script>
        <!-- handlebars.js -->
        <script src="bower_components/handlebars/handlebars.min.js"></script>
        <script src="assets/js/custom/handlebars_helpers.min.js"></script>
            

        <!--  dashbord functions -->
        <script src="assets/js/pages/dashboard.min.js"></script>
    
    <script src="print.js"></script>
    
    

</body>
</html>
