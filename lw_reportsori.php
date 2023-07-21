<?php 

file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Handler.php') ? require_once __DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Handler.php' : die('There is no such a file: Handler.php');
file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Config.php') ? require_once __DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Config.php' : die('There is no such a file: Config.php');


use AjaxLiveSearch\core\Config;
use AjaxLiveSearch\core\Handler;

if (session_id() == '') {
    session_start();
}
    Handler::getJavascriptAntiBot();
    $token = Handler::getToken();
    $time = time();
    $maxInputLength = Config::getConfig('maxInputLength');
	
$PageSecurity = 2;

include('includes/session.php');

?>
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


    <!-- uikit -->
    <link rel="stylesheet" href="bower_components/uikit/css/uikit.almost-flat.min.css" media="all">

    <!-- flag icons -->
    <link rel="stylesheet" href="assets/icons/flags/flags.min.css" media="all">

    <!-- altair admin -->
    <link rel="stylesheet" href="assets/css/main.css" media="all">
    
      <!-- Live Search Styles -->
    <link rel="stylesheet" href="css/fontello.css">
    <link rel="stylesheet" href="css/animation.css">
    <!--[if IE 7]>
    <link rel="stylesheet" href="css/fontello-ie7.css">
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="css/ajaxlivesearch.min.css">
  <link rel="stylesheet" href="print.css" type="text/css" media="print" />
    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
    <![endif]-->
     <style type="text/css">
            .a {color: green;}
            .b {color: blue;}
            .printMe {display: block;}
            @media print {
                div {display: block;}
				.buttons {display:none;}
                .printMe {display:block;}
            }
        </style>
   

</head>
<body class=" sidebar_main_open sidebar_main_swipe">
     <?php include("header.php"); ?>
    <?php include("menu.php"); ?>
    
    
    
    <div id="page_content">
        <div id="page_content_inner">
    <!-- new table for report options ------------------------------------------------------------------>
         
       
            <div class="md-card ">
                <div class="md-card-content">
               
							
<?php echo '<form method="post" action="' . $_SERVER["PHP_SELF"] . '" >'; ?>

                    <div class="uk-overflow-container">
                    <div class="buttons">
                        <table class="uk-table uk-table-condensed" style="border:#e0e0e0 1px solid">
                          

<tr>
<td><center><h3 style="margin-bottom:0px; margin-top:5px">Cases</h3></center></td>
<td><center><h3 style="margin-bottom:0px; margin-top:5px">Diary</h3></center></td>
<td><center><h3 style="margin-bottom:0px; margin-top:5px">Diary</h3></center></td>
<td><center><h3 style="margin-bottom:0px; margin-top:5px">Accounts</h3></center></td>
<td><center><h3 style="margin-bottom:0px; margin-top:5px">Other</h3></center></td>
</tr>

<tr>  

<td><input type="submit" value="Cases List" name="Partylist" style="color:#ffffff; font-weight:bold; text-transform:capitalize;" class="md-btn md-btn-block md-bg-orange-900 md-btn-wave-light waves-effect waves-button waves-light"/></td>

 
<td><input type="submit" value="Today's Cases" name="Todaycases" style="color:#ffffff; font-weight:bold; text-transform:capitalize;" class="md-btn md-btn-block md-bg-purple-300 md-btn-wave-light waves-effect waves-button waves-light"/></td>
    
   
<td><input type="submit" value="Daywise Cases" name="Daywisecases" style="color:#ffffff; font-weight:bold; text-transform:capitalize;" class="md-btn md-btn-block md-bg-purple-300 md-btn-wave-light waves-effect waves-button waves-light" /></td>
   
    
<td><a style="color:#ffffff; font-weight:bold; text-transform:capitalize" class="md-btn md-btn-block md-bg-green-600 md-btn-wave-light waves-effect waves-button waves-light" href="new_PDFPartyDuesList.php" target="_blank">All Parties Dues</a></td>


<td><a style="color:#ffffff; font-weight:bold; text-transform:capitalize;" class="md-btn md-btn-block md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="new_PDFLabel.php" target="_blank">Print Labels</a></td></tr>


<tr>
<td><input type="submit" value="Courtwise Cases" name="Courtwisecases" style="color:#ffffff; font-weight:bold; text-transform:capitalize;" class="md-btn md-btn-block md-bg-orange-900 md-btn-wave-light waves-effect waves-button waves-light"/></td>
 
<td><a style="color:#ffffff; font-weight:bold; text-transform:capitalize;"class="md-btn md-btn-block md-bg-purple-300 md-btn-wave-light waves-effect waves-button waves-light" href="new_PDFCasescurrentmonth.php" target="_blank">Current Month's Cases</a></td>
  
<td><input type="submit" value="Daily Diary" name="Dailydiary" style="color:#ffffff; font-weight:bold; text-transform:capitalize;" class="md-btn md-btn-block md-bg-purple-300 md-btn-wave-light waves-effect waves-button waves-light"/></td>
   
<td><input type="submit" value="Any Party's All Dues" name="Partydues" style="color:#ffffff; font-weight:bold; text-transform:capitalize;" class="md-btn md-btn-block md-bg-green-600 md-btn-wave-light waves-effect waves-button waves-light"/></td>

<td><a style="color:#ffffff; font-weight:bold; text-transform:capitalize" class="md-btn md-btn-block md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="new_PDFContactList.php" target="_blank">Contact List</a></td>
</tr>
    
<tr>
<td><input type="submit" value="Any Parties All Cases" name="Partydetails" style="color:#ffffff; font-weight:bold; text-transform:capitalize;" class="md-btn md-btn-block md-bg-orange-900 md-btn-wave-light waves-effect waves-button waves-light"/></td>

<!--<td><input type="submit" value="Client Categorywise Cases" name="Categorywisecases" style="color:#ffffff; font-weight:bold; text-transform:capitalize;" class="md-btn md-btn-block md-bg-orange-900 md-btn-wave-light waves-effect waves-button waves-light"/></td>-->

<td><input type="submit" value="Periodwise Cases" name="Periodwisecases" style="color:#ffffff; font-weight:bold; text-transform:capitalize;" class="md-btn md-btn-block md-bg-purple-300 md-btn-wave-light waves-effect waves-button waves-light"/></td>

<!--<td><input type="submit" value="Notices Reply Sent" name="Noticereplysent" style="color:#ffffff; font-weight:bold; text-transform:capitalize;" class="md-btn md-btn-block md-btn-warning md-btn-wave-light waves-effect waves-button waves-light"/></td>
 
<td><input type="submit" value="Blank Next Date" name="Caseswithnonextdate" style="color:#ffffff; font-weight:bold; text-transform:capitalize;" class="md-btn md-btn-block md-bg-purple-900 md-btn-wave-light waves-effect waves-button waves-light"/></td>-->

<td><input type="submit" value="Case No History" name="Casehistory" style="color:#ffffff; font-weight:bold; text-transform:capitalize;" class="md-btn md-btn-block md-bg-purple-300 md-btn-wave-light waves-effect waves-button waves-light"/></td>
     
<td><a style="color:#ffffff; font-weight:bold; text-transform:capitalize;" class="md-btn md-btn-block md-bg-green-600 md-btn-wave-light waves-effect waves-button waves-light" href="new_PDFCreditorsList.php" target="_blank">Creditors List</a></td>
 
<td><a style="color:#ffffff; font-weight:bold; text-transform:capitalize" class="md-btn md-btn-block md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="new_PDFContactList-briefno.php" target="_blank">Contact List-Brief no</a></td>

 </tr>
                            
<tr>

<!--<td><input type="submit" value="Notices Reply Received" name="Noticereplyreceived" style="color:#ffffff; font-weight:bold; text-transform:capitalize;" class="md-btn md-btn-block md-btn-warning md-btn-wave-light waves-effect waves-button waves-light"/></td>-->

<td><input type="submit" value="Stagewise Cases" name="Stagewisecases" style="color:#ffffff; font-weight:bold; text-transform:capitalize;" class="md-btn md-btn-block md-bg-orange-900 md-btn-wave-light waves-effect waves-button waves-light"/></td>

 <td><a style="color:#ffffff; font-weight:bold; text-transform:capitalize;"class="md-btn md-btn-block md-bg-purple-300 md-btn-wave-light waves-effect waves-button waves-light" href="new_PDFCasesnextmonth.php" target="_blank">Next Month's Cases</a></td>

<td><input type="submit" value="Complete Diary" name="Comdiary" style="color:#ffffff; font-weight:bold; text-transform:capitalize;" class="md-btn md-btn-block md-bg-grey-600 md-btn-wave-light waves-effect waves-button waves-light"/></td>



<td><a style="color:#ffffff; font-weight:bold; text-transform:capitalize;" class="md-btn md-btn-block md-bg-green-600 md-btn-wave-light waves-effect waves-button waves-light" href="new_PDFGLCodesList.php" target="_blank">GL Codes List</a></td>

<td><input type="submit" value="Error Finder Report" name="Errorfinder" style="color:#ffffff; font-weight:bold; text-transform:capitalize;" class="md-btn md-btn-block md-btn-primary md-btn-wave-light waves-effect waves-button waves-light"/></td>
</tr>



<tr>
<td><a style="color:#ffffff; font-weight:bold; text-transform:capitalize;" class="md-btn md-btn-block md-btn md-btn-block md-bg-orange-900 waves-effect waves-button waves-light" href="new_PDFOldCasesList.php" target="_blank">Old Cases List</a></td>

<td><input type="submit" value="This Week Cases with SMS" name="Thisweekcases" style="color:#ffffff; font-weight:bold; text-transform:capitalize;" class="md-btn md-btn-block md-bg-purple-300 md-btn-wave-light waves-effect waves-button waves-light"/></td> 
   
<td><a style="color:#ffffff; font-weight:bold; text-transform:capitalize" class="md-btn md-btn-block md-bg-purple-300 md-btn-wave-light waves-effect waves-button waves-light" href="new_PDFSMShistory.php" target="_blank">SMS Sent</a></td>

<td><a style="color:#ffffff; font-weight:bold; text-transform:capitalize" class="md-btn md-btn-block md-bg-green-600 md-btn-wave-light waves-effect waves-button waves-light" href="new_PDFsupppayList.php" target="_blank">Suppliers Payments</a></td>


<td><a style="color:#ffffff; font-weight:bold; text-transform:capitalize" class="md-btn md-btn-block md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="new_PDFSuppList.php" target="_blank">Suppliers List</a></td>

</tr>

<tr>


<td><a style="color:#ffffff; font-weight:bold; text-transform:capitalize;" class="md-btn md-btn-block md-btn md-btn-block md-bg-orange-900 waves-effect waves-button waves-light" href="new_PDFCloseCasesList.php" target="_blank">Closed cases List</a></td>

<td><input type="submit" value="Next Week Cases with SMS" name="Nextweekcases" style="color:#ffffff; font-weight:bold; text-transform:capitalize;" class="md-btn md-btn-block md-bg-purple-300 md-btn-wave-light waves-effect waves-button waves-light"/></td>
<td></td><td></td>
   <td> <a style="color:#ffffff; font-weight:bold; text-transform:capitalize;" class="md-btn md-btn-block md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="new_PDFNoticesList.php" target="_blank">Notice List</a>
   </td>

</tr>

                        </table>
                        
                        </div>
                  </div>
                </div>
            </div>
<!-- Table ends -->
            
             
                
           <!-- kept for future use -> <td><input type="submit" value="STATUSWISE CASES" name="Statuswisecases" class="uk-float-left md-btn md-btn-flat md-btn-flat-primary"/></td> -->
           
                <?php
				
if(isset($_POST['Categorywisecases']))
		{
				 //---------------------------------- Categorywisecases Cases----------------------------------
	
	    echo '<div class="uk-form-row">';
		echo '<form action=' . $_SERVER['PHP_SELF'] . ' method="POST">';
		/*-----------------------------------------------------------------------------*/
		$result=DB_query("SELECT clientcatid, category FROM lw_clientcat",$db);
	  echo '<br><label><b>Select Client Category</b></label><br>';
		
		echo '<div class="md-input-wrapper">';
 		echo '<div class="uk-width-medium-1-1" style="padding-bottom:0px">';
        echo '<div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">';
       echo '<div class="uk-grid">';
		
		echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px">';
			
	echo '<select tabindex="14" Name="Clientcat" class="md-input">';
	
	while ($myrow = DB_fetch_array($result)) {
		
		echo "<option VALUE='". $myrow[0] . "'>" . $myrow[1];
		
	} //end while loop
	
	DB_free_result($result);
	
		echo '</select></div>';
	
		echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px">';
		echo '<input type="Submit" Name="Categorywisereport" class="md-btn md-btn-primary" Value="'. _('View categorywise Cases'). '"></div></div></div>';
	
	} 
	
	if(isset($_POST['Categorywisereport']))
	{
	
	 $sql = 'SELECT c.brief_file,
			p1.name AS party,
			p2.name AS oppoparty,
			lw_casecat.casecat,
			c.courtcaseno,
			lw_courts.courtname,
			lw_clientcat.category,
			lw_case_status.casestatusdesc
		FROM lw_cases AS c INNER JOIN lw_contacts AS p1 ON c.party=p1.id INNER JOIN lw_contacts AS p2 ON c.oppoparty=p2.id INNER JOIN lw_courts ON c.courtid=lw_courts.courtid INNER JOIN lw_casecat ON c.casecatid=lw_casecat.casecatid INNER JOIN lw_clientcat ON c.clientcatid=lw_clientcat.clientcatid INNER JOIN lw_case_status ON c.casestatus=lw_case_status.casestatusid WHERE c.clientcatid="' . $_POST['Clientcat']  .  '" AND c.deleted!=1';
		
					
	$StatementResults=DB_query($sql,$db);
		
				
		?>
        
        
    <br>
     <a href="new_PDFClientcategorywiselist.php?Clientcat=<?php echo $_POST['Clientcat']; ?>" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> <img src="icon_pdf.gif" /></a>
     
   
   <label style="color:#0000FF">CLIENT CATEGORY WISE CASES</label>
<br><br>
            <div class="md-card uk-margin-medium-bottom" style="padding-top:10px">
                <div class="md-card-content">
                
                    <div class="uk-overflow-container">
                        <table class="uk-table uk-table-condensed">
                <thead>  
                <?php 
	$TableHeader = "<tr>
	
			<th>" . _('ID') . "</th>
			<th>" . _('Prev. Date') . "</th>
			<th>" . _('Court') . "</th>
			<th>" . _('Case No') . "</th>
			<th>" . _('Brief_File') . "</th>
			<th>" . _('Party Name') . "</th>
			<th>" . _('Opposite Party') . "</th>
			<th>" . _('Client Category') . "</th>
			<th>" . _('Next Date') . "</th>
		   </tr></thead>";

                           
	echo $TableHeader;
	$today=date('d-m-Y');

	$id=1;
	
	if(DB_num_rows($StatementResults)<=0)
	{
	echo 'No Records Found';
	
	}
	
		while($Contacts=DB_fetch_array($StatementResults))
		{
		
		$sqldates='SELECT lw_trans.prevcourtdate, lw_trans.nextcourtdate FROM lw_trans WHERE lw_trans.brief_file="' . $Contacts['brief_file']  .  '"   ORDER BY lw_trans.nextcourtdate DESC LIMIT 1';
	$StatementResultsnextcourtdate=DB_query($sqldates,$db);
	$myrowtransbrieflastcourtdate=DB_fetch_array($StatementResultsnextcourtdate);
	
	
	if(!empty($myrowtransbrieflastcourtdate['nextcourtdate']))
	{
	$myrowtransbrieflastcourtdate['nextcourtdate']=ConvertSQLDate($myrowtransbrieflastcourtdate['nextcourtdate']);
	}
	
	else
	
	{
	$myrowtransbrieflastcourtdate['nextcourtdate']=$myrowtransbrieflastcourtdate['nextcourtdate'];
	}


if(!empty($myrowtransbrieflastcourtdate['prevcourtdate']))
	{
	$myrowtransbrieflastcourtdate['prevcourtdate']=ConvertSQLDate($myrowtransbrieflastcourtdate['prevcourtdate']);
	}
	
	else
	
	{
	$myrowtransbrieflastcourtdate['prevcourtdate']=$myrowtransbrieflastcourtdate['prevcourtdate'];
	}
		

      		printf("<tr><td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td style='color:#FFFFFF; background-color:#1976d2; font-weight:bold; text-align:center'>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			</tr>",		
			$id++,
			$myrowtransbrieflastcourtdate['prevcourtdate'],
			$Contacts['courtname'],
			$Contacts['courtcaseno'],
			$Contacts['brief_file'],
			$Contacts['party'],
			$Contacts['oppoparty'],
			$Contacts['category'],	
			$myrowtransbrieflastcourtdate['nextcourtdate']);		
		
		
		}
	        echo '</table>'; 
				
				}
				
				if(isset($_POST['Allbcc']))
{	
$tag="BC_";

$sql = "SELECT lw_cases.brief_file,
			lw_cases.party,
			lw_cases.oppoparty,
			lw_cases.courtcaseno,
			lw_cases.opendt
	FROM lw_cases WHERE brief_file " . LIKE . " '%" . $tag . "%' AND lw_cases.deleted!=1";
					
		$StatementResults=DB_query($sql,$db);
		
		
		?>
     
    <a href="PDFBCCList.php" target="_blank"> <img src="icon_pdf.gif" /></a>
   <label style="color:#0000FF">BC LIST</label>

            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                
                    <div class="uk-overflow-container">
                        <table class="uk-table uk-table-condensed">
                <thead>  
                <?php 
	$TableHeader = "<tr>
		
				<th>" . _('ID') . "</th>
				<th>" . _('Brief_File No') . "</th>
				<th>" . _('Mobile') . "</th>			
				<th>" . _('Party Name') . "</th>			
				<th>" . _('Opposite Party') . "</th>
				<th>" . _('Case No') . "</th>
				<th>" . _('Open Date') . "</th>
				<th>" . _('Prev Date') . "</th>
				<th>" . _('Next Date') . "</th>
				</tr></thead>";


                           
	echo $TableHeader;
		
		$id=1;

			
		while($Contacts=DB_fetch_array($StatementResults))
		{
		
		$resultparty=DB_query("SELECT name,mobile FROM lw_contacts WHERE lw_contacts.id='" . $Contacts['party'] . "'",$db);	
				$myrowparty=DB_fetch_array($resultparty);
	  
	  $resultoppoparty=DB_query("SELECT name FROM lw_contacts WHERE lw_contacts.id='" . $Contacts['oppoparty'] . "'",$db);	
				$myrowoppoparty=DB_fetch_array($resultoppoparty);
			
	$resultstage=DB_query("SELECT stage FROM lw_stages WHERE lw_stages.stageid='" . $Contacts['stage'] . "'",$db);
			$myrowstage=DB_fetch_array($resultstage);
	
  	$resultcourt=DB_query("SELECT courtname FROM lw_courts WHERE lw_courts.courtid='" . $Contacts['courtid'] . "'",$db);		
			$myrowcourt=DB_fetch_array($resultcourt);
			
			$sqldates='SELECT lw_trans.prevcourtdate, lw_trans.nextcourtdate FROM lw_trans WHERE lw_trans.brief_file="' . $Contacts['brief_file']  .  '"   ORDER BY lw_trans.nextcourtdate DESC LIMIT 1';
	$StatementResultsnextcourtdate=DB_query($sqldates,$db);
	$myrowtransbrieflastcourtdate=DB_fetch_array($StatementResultsnextcourtdate);
	
			if(!empty($myrowtransbrieflastcourtdate['nextcourtdate']))
	{
	$myrowtransbrieflastcourtdate['nextcourtdate']=ConvertSQLDate($myrowtransbrieflastcourtdate['nextcourtdate']);
	}
	
	else
	
	{
	$myrowtransbrieflastcourtdate['nextcourtdate']=$myrowtransbrieflastcourtdate['nextcourtdate'];
	}


if(!empty($myrowtransbrieflastcourtdate['prevcourtdate']))
	{
	$myrowtransbrieflastcourtdate['prevcourtdate']=ConvertSQLDate($myrowtransbrieflastcourtdate['prevcourtdate']);
	}
	
	else
	
	{
	$myrowtransbrieflastcourtdate['prevcourtdate']=$myrowtransbrieflastcourtdate['prevcourtdate'];
	}
		

if(!empty($Contacts['opendt']))
	{
	$Contacts['opendt']=ConvertSQLDate($Contacts['opendt']);
	}
	
	else
	
	{
	$Contacts['opendt']=$Contacts['opendt'];
	}	
		
		printf("<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				</tr>",
				$id++,
				$Contacts['brief_file'],
				$myrowparty['mobile'],
				$myrowparty['name'],
				$myrowoppoparty['name'],
				$Contacts['courtcaseno'],
				$Contacts['opendt'],
				$myrowtransbrieflastcourtdate['prevcourtdate'],
				$myrowtransbrieflastcourtdate['nextcourtdate']);	
	
	}
	 echo '</table>';

}
			
				
				//---------------Blank Next Date starts
	if(isset($_POST['Caseswithnonextdate']))
{	

	$sql = "SELECT brief_file,
				lw_trans.courtcaseno,
				lw_trans.courtname,
				lw_trans.party,
				lw_trans.oppoparty,
				lw_trans.stage,
				lw_trans.prevcourtdate,
				lw_trans.nextcourtdate
		FROM lw_trans WHERE lw_trans.nextcourtdate IS NULL GROUP BY(brief_file)";
	
	$StatementResults=DB_query($sql,$db);	
	
	
	?>
	
	
	 <a href="new_PDFBlanknextdate.php" target="_blank"> <img src="icon_pdf.gif" /></a>
   <label style="color:#0000FF">BLANK NEXT COURT DATE CASES</label>

            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                
                    <div class="uk-overflow-container">
                        <table class="uk-table uk-table-condensed">
                <thead>  
   
    <?php
	$TableHeader = "<tr>
	
			<th>" . _('ID') . "</th>
			<th>" . _('Prev. Date') . "</th>
			<th>" . _('Brief_File') . "</th>
			<th>" . _('Case No') . "</th>
			<th>" . _('Court') . "</th>
			<th>" . _('Party Name') . "</th>
			<th>" . _('Opposite Party') . "</th>
			<th>" . _('Mobile') . "</th>
			<th>" . _('Next Date') . "</th>		
			</tr> </thead>";

	echo $TableHeader;

	$id=1;
	
	
	while($Contacts=DB_fetch_array($StatementResults))
	{
	
	$resultparty=DB_query("SELECT name,mobile FROM lw_contacts WHERE lw_contacts.id='" . $Contacts['party'] . "'",$db);	
				$myrowparty=DB_fetch_array($resultparty);
	  
	  $resultoppoparty=DB_query("SELECT name FROM lw_contacts WHERE lw_contacts.id='" . $Contacts['oppoparty'] . "'",$db);	
				$myrowoppoparty=DB_fetch_array($resultoppoparty);
			
	$resultstage=DB_query("SELECT stage FROM lw_stages WHERE lw_stages.stageid='" . $Contacts['stage'] . "'",$db);
			$myrowstage=DB_fetch_array($resultstage);
	
      $resultcourt=DB_query("SELECT courtname FROM lw_courts WHERE lw_courts.courtid='" . $Contacts['courtname'] . "'",$db);		
			$myrowcourt=DB_fetch_array($resultcourt);
	
	if($Contacts['prevcourtdate']!="")
	{
	$Contacts['prevcourtdate']=ConvertSQLDate($Contacts['prevcourtdate']);
	}
	
	else
	
	{
	$Contacts['prevcourtdate']=$Contacts['prevcourtdate'];
	}


if($Contacts['nextcourtdate']!="")
	{
	$Contacts['nextcourtdate']=ConvertSQLDate($Contacts['nextcourtdate']);
	}
	
	else
	
	{
	$Contacts['nextcourtdate']=$Contacts['nextcourtdate'];
	}
		
		printf("<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td style='color:#FFFFFF; background-color:#1976d2; font-weight:bold; text-align:center'>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>			
			</tr>",
			$id++,
			$Contacts['prevcourtdate'],
			$Contacts['brief_file'],
			$Contacts['courtcaseno'],
			$myrowcourt['courtname'],
			$myrowparty['name'],
			$myrowoppoparty['name'],
			$myrowparty['mobile'],
			$Contacts['nextcourtdate']);	
				
	}
	 
		echo '</table>';


}		
		
	
		// ---------------------This week cases starts here---------------------
if(isset($_POST['Thisweekcases']))
{
	

$now = time();
$num = date("w");

if ($num == 0)//sunday
{ $sub = 6; }
else { $sub = ($num-1); }
$WeekMon  = mktime(0, 0, 0, date("m", $now)  , date("d", $now)-$sub, date("Y", $now));   

$todayh = getdate($WeekMon); //monday week begin reconvert

$d = $todayh[mday];
$m = $todayh[mon];
$y = $todayh[year];
//echo "$d-$m-$y"; //monday- this week

if($m<10)
{
$m='0' . $m;
}

if($d<10)
{
$d= '0' . $d;

}


$weekstart="$y-$m-$d";

	$date = new DateTime($weekstart);
	
	$date->add(new DateInterval('P6D'));  
		

$weekend=$date->format('Y-m-d');

//echo 'weekstart' . $weekstart;
//echo date("Y-m-d", strtotime("+1 week"));

//$today  = date("l");

//echo ' weekend' . $weekend;
//if($Contacts['nextcourtdate']!="")
  //  {
 	$sql = 'SELECT lw_trans.id,lw_trans.brief_file,
				lw_trans.courtcaseno,
				lw_trans.courtname,
				lw_trans.party,
				lw_trans.stage,
				lw_trans.prevcourtdate,
				lw_trans.currtrandate,
				lw_trans.nextcourtdate
		FROM lw_trans WHERE nextcourtdate >="' . $weekstart . '" AND nextcourtdate <"' . $weekend .'" ORDER BY nextcourtdate ASC';
	
	$StatementResults=DB_query($sql,$db);
/*	} else if($Contacts['nextcourtdate']=="")
	{
	
	$sql = 'SELECT brief_file,
				lw_trans.courtcaseno,
				lw_trans.courtname,
				lw_trans.party,
				lw_trans.stage,
				lw_trans.prevcourtdate,
				lw_trans.currtrandate,
				lw_trans.nextcourtdate
		FROM lw_trans WHERE currtrandate >="' . $weekstart . '" AND currtrandate <"' . $weekend .'" ORDER BY nextcourtdate ASC';
	
	$StatementResults=DB_query($sql,$db);*/
	//}
	?>
	

		<br> 
   		<label style="color:#0000FF">THIS WEEK'S CASES</label>

            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                
                    <div class="uk-overflow-container">
                        <table class="uk-table uk-table-condensed">
                <thead>  
    <?php
	$TableHeader = "<tr'>
	
			<th>" . _('ID') . "</th>
			<th>" . _('Prev. Date') . "</th>
			<th>" . _('Brief_File') . "</th>
			<th>" . _('Case No') . "</th>
			<th>" . _('Court') . "</th>
			<th>" . _('Party Name') . "</th>
			<th>" . _('Mobile') . "</th>
			<th>" . _('Next Date') . "</th>
		<th>" . _('SMS For Court Date') . "</th>
		</tr> </thead>";

	echo $TableHeader;

	
	while($Contacts=DB_fetch_array($StatementResults))
	{
	
	$resultparty=DB_query("SELECT name,mobile FROM lw_contacts WHERE lw_contacts.id='" . $Contacts['party'] . "'",$db);	
				$myrowparty=DB_fetch_array($resultparty);
	  
	 // $resultoppoparty=DB_query("SELECT name FROM lw_contacts WHERE lw_contacts.id='" . $Contacts['oppoparty'] . "'",$db);	
				//$myrowoppoparty=DB_fetch_array($resultoppoparty);
			
	$resultstage=DB_query("SELECT stage FROM lw_stages WHERE lw_stages.stageid='" . $Contacts['stage'] . "'",$db);
			$myrowstage=DB_fetch_array($resultstage);
	
    $resultcourt=DB_query("SELECT courtname FROM lw_courts WHERE lw_courts.courtid='" . $Contacts['courtname'] . "'",$db);		
			$myrowcourt=DB_fetch_array($resultcourt);
	
	if($Contacts['prevcourtdate']!="")
	{
	$Contacts['prevcourtdate']=ConvertSQLDate($Contacts['prevcourtdate']);
	}
	
	else
	
	{
	$Contacts['prevcourtdate']=$Contacts['prevcourtdate'];
	}


if($Contacts['nextcourtdate']!="")
	{
	$Contacts['nextcourtdate']=ConvertSQLDate($Contacts['nextcourtdate']);
	
	$Contacts[6]=$Contacts['nextcourtdate'];
	}
	
	else
	
	{
	$Contacts['nextcourtdate']=$Contacts['nextcourtdate'];
	}
	
	/*<td><a href=\"%s&SelectedUser=%s&mobile=$myrowparty[1]&courtcaseno=$Contacts[1]&nextdate=$Contacts[7]&courtname=$myrowcourt[0]\" target='_blank' onclick='MM_openbrwindow(\"sms_gate.php\",200,300)'>" . _('Send SMS') . "</a></td>*/
		
		printf("<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td style='color:#FFFFFF; background-color:#1976d2; font-weight:bold; text-align:center'>%s</td>
			<td>%s</td>
			
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td><input type='button' name='btn' class='md-btn md-btn-primary' value='Send SMS' onClick='MM_openbrwindow(\"sms_gate.php?SelectedUser=$Contacts[1]&id=$Contacts[0]&mobile=$myrowparty[1]&courtcaseno=$Contacts[1]&nextdate=$Contacts[6]&courtname=$myrowcourt[0]\",600,500)'></td>
			</tr>",
			$Contacts['id'],
			$Contacts['prevcourtdate'],
			$Contacts['brief_file'],
			$Contacts['courtcaseno'],
			$myrowcourt['courtname'],
			$myrowparty['name'],
			$myrowparty['mobile'],
			$Contacts['nextcourtdate'],
			$Contacts[0]);					
	}
	 
		echo '</table>';


	}
	
			
		// ---------------------Next week cases starts here---------------------
if(isset($_POST['Nextweekcases']))
{
	

$now = time();
$num = date("w");

if ($num == 0)//sunday
{ $sub = 6; }
else { $sub = ($num-1); }
$WeekMon  = mktime(0, 0, 0, date("m", $now)  , date("d", $now)-$sub, date("Y", $now));   

$todayh = getdate($WeekMon); //monday week begin reconvert

$d = $todayh[mday];
$m = $todayh[mon];
$y = $todayh[year];
//echo "$d-$m-$y"; //monday- this week


if($m<10)
{
$m='0' . $m;
}

if($d<10)
{
$d= '0' . $d;

}


$weekstart="$y-$m-$d"; //this monday

	$date = new DateTime($weekstart);
	
	$date->add(new DateInterval('P5D'));  
		

$weekend=$date->format('Y-m-d');

$nextmon = new DateTime($weekend);
	
$date->add(new DateInterval('P2D')); 


$nextmonday=$date->format('Y-m-d'); //next monday

$nextsat = new DateTime($nextmonday);
	
$date->add(new DateInterval('P5D')); 

$nextsaturday=$date->format('Y-m-d'); //next saturday

    
 	$sql = 'SELECT brief_file,
				lw_trans.courtcaseno,
				lw_trans.courtname,
				lw_trans.party,
				
				lw_trans.stage,
				lw_trans.prevcourtdate,
				lw_trans.nextcourtdate
		FROM lw_trans WHERE nextcourtdate >="' . $nextmonday . '" AND nextcourtdate <="' . $nextsaturday .'" ORDER BY nextcourtdate ASC';
	
	$StatementResults=DB_query($sql,$db);	
	?>
		<br>
   		<label style="color:#0000FF">NEXT WEEK'S CASES</label>

            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                     <div class="uk-overflow-container">
                        <table class="uk-table uk-table-condensed">
                <thead>  
    <?php
	$TableHeader = "<tr'>
	
			<th>" . _('ID') . "</th>
			<th>" . _('Prev. Date') . "</th>
			<th>" . _('Brief_File') . "</th>
			<th>" . _('Case No') . "</th>
			<th>" . _('Court') . "</th>
			<th>" . _('Party Name') . "</th>
			<th>" . _('Mobile') . "</th>
			<th>" . _('Next Date') . "</th>
		<th>" . _('SMS For Court Date') . "</th>
		</tr> </thead>";

	echo $TableHeader;

	$id=1;
	
	
	while($Contacts=DB_fetch_array($StatementResults))
	{
	
	$resultparty=DB_query("SELECT name,mobile FROM lw_contacts WHERE lw_contacts.id='" . $Contacts['party'] . "'",$db);	
				$myrowparty=DB_fetch_array($resultparty);
	  
	  //$resultoppoparty=DB_query("SELECT name FROM lw_contacts WHERE lw_contacts.id='" . $Contacts['oppoparty'] . "'",$db);	
				//$myrowoppoparty=DB_fetch_array($resultoppoparty);
			
	$resultstage=DB_query("SELECT stage FROM lw_stages WHERE lw_stages.stageid='" . $Contacts['stage'] . "'",$db);
			$myrowstage=DB_fetch_array($resultstage);
	
      $resultcourt=DB_query("SELECT courtname FROM lw_courts WHERE lw_courts.courtid='" . $Contacts['courtname'] . "'",$db);		
			$myrowcourt=DB_fetch_array($resultcourt);
	
	if($Contacts['prevcourtdate']!="")
	{
	$Contacts['prevcourtdate']=ConvertSQLDate($Contacts['prevcourtdate']);
	}
	
	else
	
	{
	$Contacts['prevcourtdate']=$Contacts['prevcourtdate'];
	}


if($Contacts['nextcourtdate']!="")
	{
	$Contacts['nextcourtdate']=ConvertSQLDate($Contacts['nextcourtdate']);
	}
	
	else
	
	{
	$Contacts['nextcourtdate']=$Contacts['nextcourtdate'];
	}
		
		printf("<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td style='color:#FFFFFF; background-color:#1976d2; font-weight:bold; text-align:center'>%s</td>
			<td>%s</td>
		
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td><input type='button' name='btn' class='md-btn md-btn-primary' value='Send SMS' onClick='MM_openbrwindow(\"sms_gate.php?SelectedUser=$Contacts[0]&mobile=$myrowparty[1]&courtcaseno=$Contacts[1]&nextdate=$Contacts[7]&courtname=$myrowcourt[0]\",600,500)'></td>
			</tr>",
			$id++,
			$Contacts['prevcourtdate'],
			$Contacts['brief_file'],
			$Contacts['courtcaseno'],
			$myrowcourt['courtname'],
			$myrowparty['name'],
			$myrowparty['mobile'],
			$Contacts['nextcourtdate'],
			$Contacts[0]);
				
	}
	 
		echo '</table>';


	}

	
	// ---------------------Next month cases starts here---------------------
if(isset($_POST['Nextmonthcases']))
{
$DateString = Date($_SESSION['DefaultDateFormat']);
	
		$date = new DateTime(FormatDateForSQL($DateString));
                //$date->sub(new DateInterval('P1D'));  
				
		$date->add(new DateInterval('P1M'));  
    
    
 	$sql = "SELECT DISTINCT brief_file,
				lw_trans.courtcaseno,
				lw_trans.courtname,
				lw_trans.party,
				lw_trans.oppoparty,
				lw_trans.stage,
				lw_trans.prevcourtdate,
				lw_trans.nextcourtdate
		FROM lw_trans WHERE lw_trans.nextcourtdate LIKE '%" . $date->format('Y-m') . "%' ORDER BY lw_trans.nextcourtdate ASC";
	
	$StatementResults=DB_query($sql,$db);	
	
	
	?>
	

		<br> <a href="new_PDFCasesnextmonth.php" target="_blank"> <img src="icon_pdf.gif" /></a>
   		<label style="color:#0000FF">NEXT MONTH'S CASES</label>

            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                
                    <div class="uk-overflow-container">
                        <table class="uk-table uk-table-condensed">
                <thead>  
    <?php
	$TableHeader = "<tr'>
	
			<th>" . _('ID') . "</th>
			<th>" . _('Prev. Date') . "</th>
			<th>" . _('Brief_File') . "</th>
			<th>" . _('Case No') . "</th>
			<th>" . _('Court') . "</th>
			<th>" . _('Party Name') . "</th>
			<th>" . _('Opposite Party') . "</th>
			<th>" . _('Mobile') . "</th>
			<th>" . _('Next Date') . "</th>
		</tr> </thead>";

	echo $TableHeader;

	$id=1;
	
	
	while($Contacts=DB_fetch_array($StatementResults))
	{
	
	$resultparty=DB_query("SELECT name,mobile FROM lw_contacts WHERE lw_contacts.id='" . $Contacts['party'] . "'",$db);	
				$myrowparty=DB_fetch_array($resultparty);
	  
	  $resultoppoparty=DB_query("SELECT name FROM lw_contacts WHERE lw_contacts.id='" . $Contacts['oppoparty'] . "'",$db);	
				$myrowoppoparty=DB_fetch_array($resultoppoparty);
			
	$resultstage=DB_query("SELECT stage FROM lw_stages WHERE lw_stages.stageid='" . $Contacts['stage'] . "'",$db);
			$myrowstage=DB_fetch_array($resultstage);
	
      $resultcourt=DB_query("SELECT courtname FROM lw_courts WHERE lw_courts.courtid='" . $Contacts['courtname'] . "'",$db);		
			$myrowcourt=DB_fetch_array($resultcourt);
	
	if($Contacts['prevcourtdate']!="")
	{
	$Contacts['prevcourtdate']=ConvertSQLDate($Contacts['prevcourtdate']);
	}
	
	else
	
	{
	$Contacts['prevcourtdate']=$Contacts['prevcourtdate'];
	}


if($Contacts['nextcourtdate']!="")
	{
	$Contacts['nextcourtdate']=ConvertSQLDate($Contacts['nextcourtdate']);
	}
	
	else
	
	{
	$Contacts['nextcourtdate']=$Contacts['nextcourtdate'];
	}
		
		printf("<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td style='color:#FFFFFF; background-color:#1976d2; font-weight:bold; text-align:center'>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			</tr>",
			$id++,
			$Contacts['prevcourtdate'],
			$Contacts['brief_file'],
			$Contacts['courtcaseno'],
			$myrowcourt['courtname'],
			$myrowparty['name'],
			$myrowoppoparty['name'],
			$myrowparty['mobile'],
			$Contacts['nextcourtdate']);	
				
	}
	 
		echo '</table>';


	}
 //---------------------------------- Search for Daily Diary Cases----------------------------------
 
   if(isset($_POST['submittodaysms']))
{
echo '<div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">';
echo 'Sent SMS to clients for today\'s received Court\'s dates'; 

$DateString = Date($_SESSION['DefaultDateFormat']);
	
	$date = new DateTime(FormatDateForSQL($DateString));	
	
	/* Now figure out the Transactions data to report for the selections made */
	$sql = 'SELECT lw_trans.courtcaseno,
				lw_trans.party,
				lw_trans.courtname,
				lw_trans.nextcourtdate
		FROM lw_trans WHERE lw_trans.currtrandate="' . $date->format('Y-m-d') . '" ORDER BY lw_trans.nextcourtdate';
		
	
	$StatementResults=DB_query($sql,$db);
	
	while($Contacts=DB_fetch_array($StatementResults))
	{
	
	$resultparty=DB_query("SELECT name,mobile FROM lw_contacts WHERE lw_contacts.id='" . $Contacts['party'] . "'",$db);	
				$myrowparty=DB_fetch_array($resultparty);
	  
	$resultcourt=DB_query("SELECT courtname FROM lw_courts WHERE lw_courts.courtid='" . $Contacts['courtname'] . "'",$db);		
			$myrowcourt=DB_fetch_array($resultcourt);
	
		
error_reporting (E_ALL ^ E_NOTICE);
$username="dinesh700";
$password ="2911008";

$number=$myrowparty['mobile'];

$courtcaseno=$Contacts['courtcaseno'];

$courtname=$myrowcourt['courtname'];

$nextdate=$Contacts['nextcourtdate'];

$sender="LAWPRT";

$message="Case No :" . $courtcaseno . " Next Court Date : " . $nextdate . " At Court : " . $courtname . '. Please be present without Fail';


if(empty($number))
{
echo '<div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">';
echo ' SMS to blank mobile number is not possible for Case No : ' . $courtcaseno;
 echo '</div></div>'; 
continue;
   
}else
{
$url="login.bulksmsgateway.in/sendmessage.php?user=".urlencode($username)."&password=".urlencode($password)."&mobile=".urlencode($number)."&sender=".urlencode($sender)."&message=".urlencode($_POST['message'])."&type=".urlencode('3'); 

/*$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);

$curl_scraped_page = curl_exec($ch);

curl_close($ch); */
  

}	

}//end of while statement

} // end of send sms to today's cases
     


 if(isset($_POST['Todaycases']))
{

	$DateString = Date($_SESSION['DefaultDateFormat']);
	
	$date = new DateTime(FormatDateForSQL($DateString));	

	
	/* Now figure out the Transactions data to report for the selections made */
	$sql = 'SELECT lw_trans.brief_file,
				lw_trans.courtcaseno,
				lw_trans.currtrandate,
				lw_trans.party,
	
				lw_trans.courtname,
				lw_trans.prevcourtdate,
				lw_trans.nextcourtdate
			
		FROM lw_trans LEFT JOIN lw_courts ON lw_trans.courtname=lw_courts.courtid LEFT JOIN lw_cases ON lw_trans.brief_file=lw_cases.brief_file WHERE currtrandate="' . $date->format('Y-m-d') . '" ORDER BY lw_trans.courtname ASC';
	$StatementResults=DB_query($sql,$db);	
			
	
	?>
	 
	 <br>
     
    <a href="new_PDFCasestoday.php" target="_blank"> <img src="icon_pdf.gif" /></a>
   <label style="color:#0000FF">TODAY'S CASES</label>

            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                
                    <div class="uk-overflow-container">                   
                        
                        <table class="uk-table uk-table-condensed">
                        
                        
                <thead>  
                <?php 
	$TableHeader = "<tr>
	
			<th>" . _('ID') . "</th>
			<th>" . _('Prev Date') . "</th>
			<th>" . _('Brief_File') . "</th>
			<th>" . _('Case No') . "</th>
			<th>" . _('Court') . "</th>
			<th>" . _('Party Name') . "</th>
			
			<th>" . _('Mobile') . "</th>
			<th>" . _('Next Date') . "</th>
		   </tr></thead>";

                           
     echo $TableHeader;
	
	$id=1;
	
	while($Contacts=DB_fetch_array($StatementResults))
	{
	
	$resultparty=DB_query("SELECT name,mobile FROM lw_contacts WHERE lw_contacts.id='" . $Contacts['party'] . "'",$db);	
				$myrowparty=DB_fetch_array($resultparty);
	  
	
			
	$resultstage=DB_query("SELECT stage FROM lw_stages WHERE lw_stages.stageid='" . $Contacts['stage'] . "'",$db);
			$myrowstage=DB_fetch_array($resultstage);
	
      $resultcourt=DB_query("SELECT courtname FROM lw_courts WHERE lw_courts.courtid='" . $Contacts['courtname'] . "'",$db);		
			$myrowcourt=DB_fetch_array($resultcourt);
	
	if($Contacts['prevcourtdate']!="")
	{
	$Contacts['prevcourtdate']=ConvertSQLDate($Contacts['prevcourtdate']);
	}
	
	else
	
	{
	$Contacts['prevcourtdate']=$Contacts['prevcourtdate'];
	}


if($Contacts['nextcourtdate']!="")
	{
	$Contacts['nextcourtdate']=ConvertSQLDate($Contacts['nextcourtdate']);
	}
	
	else
	
	{
	$Contacts['nextcourtdate']=$Contacts['nextcourtdate'];
	}
		
		printf("<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td style='color:#FFFFFF; background-color:#1976d2; font-weight:bold; text-align:center'>%s</td>
			<td>%s</td>
			<td>%s</td>			
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>	
			</tr>",
			$id++,
			
			$Contacts['prevcourtdate'],
			$Contacts['brief_file'],
			$Contacts['courtcaseno'],
			$myrowcourt['courtname'],
			$myrowparty['name'],

			$myrowparty['mobile'],
		$Contacts['nextcourtdate']
			)
			;	
				
	}
	                             
       echo '</table>';  
                           
                      
             
      }//end while loop 
	  
 //---------------------------------- Search for Tomorrow's Cases----------------------------------

     if(isset($_POST['Tomorrowcases']))
	{
	
		$DateString = Date($_SESSION['DefaultDateFormat']);
	
		$date = new DateTime(FormatDateForSQL($DateString));
                //$date->sub(new DateInterval('P1D'));  
				
		$date->add(new DateInterval('P1D'));  
         
        	
	
		/* Now figure out the Transactions data to report for the selections made */
		$sql = 'SELECT lw_trans.brief_file,
				lw_trans.courtcaseno,
				lw_trans.party,
				lw_trans.oppoparty,
				lw_trans.courtname,
				lw_trans.stage,
				lw_trans.prevcourtdate,
				lw_trans.nextcourtdate
		FROM lw_trans WHERE lw_trans.currtrandate="' . $date->format('Y-m-d') . '" ORDER BY lw_trans.currtrandate';
	
	$StatementResults=DB_query($sql,$db);		     
     
	 	?>
     	<br>
	
	    <a href="new_PDFCasestomorrow.php" target="_blank"> <img src="icon_pdf.gif" /></a>
        <label style="color:#0000FF">TOMORROW'S CASES</label>
     
                 <div class="md-card uk-margin-medium-bottom">
                     <div class="md-card-content">
                     
                         <div class="uk-overflow-container">
                             <table class="uk-table uk-table-condensed">
                     <thead>  
                     <?php 
     
     	$TableHeader = "<tr>
	
			<th>" . _('ID') . "</th>
			<th>" . _('Prev Date') . "</th>
			<th>" . _('Brief_File') . "</th>
			<th>" . _('Case No') . "</th>
			<th>" . _('Court') . "</th>
			<th>" . _('Party Name') . "</th>
			<th>" . _('Opposite Party') . "</th>
			<th>" . _('Mobile') . "</th>
			<th>" . _('Next Date') . "</th>
		   </tr></thead>";
                     
                                
         echo $TableHeader;
		
			$id=1;
			
     	
	while($myrow=DB_fetch_array($StatementResults))
		{
		
		$resultparty=DB_query("SELECT name,mobile FROM lw_contacts WHERE lw_contacts.id='" . $myrow['party'] . "'",$db);	
				$myrowparty=DB_fetch_array($resultparty);
	  
	  $resultoppoparty=DB_query("SELECT name FROM lw_contacts WHERE lw_contacts.id='" . $myrow['oppoparty'] . "'",$db);	
				$myrowoppoparty=DB_fetch_array($resultoppoparty);
			
	$resultstage=DB_query("SELECT stage FROM lw_stages WHERE lw_stages.stageid='" . $myrow['stage'] . "'",$db);
			$myrowstage=DB_fetch_array($resultstage);
	
      $resultcourt=DB_query("SELECT courtname FROM lw_courts WHERE lw_courts.courtid='" . $myrow['courtname'] . "'",$db);		
			$myrowcourt=DB_fetch_array($resultcourt);
	
	if($myrow['prevcourtdate']!="")
	{
	$myrow['prevcourtdate']=ConvertSQLDate($myrow['prevcourtdate']);
	}
	
	else
	
	{
	$myrow['prevcourtdate']=$myrow['prevcourtdate'];
	}


if($myrow['nextcourtdate']!="")
	{
	$myrow['nextcourtdate']=ConvertSQLDate($myrow['nextcourtdate']);
	}
	
	else
	
	{
	$myrow['nextcourtdate']=$myrow['nextcourtdate'];
	}
		
		printf("<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td style='color:#FFFFFF; background-color:#1976d2; font-weight:bold; text-align:center'>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			</tr>",
			$id++,
			$myrow['nextcourtdate'],
			$myrow['brief_file'],
			$myrow['courtcaseno'],
			$myrowcourt['courtname'],
			$myrowparty['name'],
			$myrowoppoparty['name'],
			$myrowparty['mobile'],
			null)
			;	
				
	}
	                             
       echo '</table></div></div></div>';  
                           
     	                             
                 }//end while loop ?>
                                
                             </table><!-- Table ends -->
                             
  <?php
 //---------------------------------- Search for Daywise Cases----------------------------------
  if(isset($_POST['Daywisecases']))
  {
  
  	echo '<form action=' . $_SERVER['PHP_SELF'] . ' method="POST"><div>';
  	/*-----------------------------------------------------------------------------*/
	?>
  	
  		<br>	<div class="md-input-wrapper">
          <div class="uk-width-medium-1-1" style="padding-bottom:0px">
        <div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">
        <div class="uk-grid">
  	
  			<div class="uk-width-medium-1-1" style="padding-bottom:10px">
  				<br><label for="uk_Nextdate">Select date</label></div>
  				<div class="uk-width-medium-1-3" style="padding-bottom:10px">
  				<input class="md-input" type="text" name="Nextdate" id="uk_Nextdate" data-uk-datepicker="{format:'DD/MM/YYYY'}">
  				</div>
  	
<?php 			
echo '<input type="submit" name="uk_Daywisereport" class="md-btn md-btn-primary" value="'. _('View Report new'). '">'; ?>

  		</div></div></div></div>
  		</form>
 <?php

  }
  

  	if(isset($_POST['uk_Daywisereport']))
  	{	
	

	$date = new DateTime(FormatDateForSQL($_POST['Nextdate']));	
  		 
	$dateforpdf=$date->format('Y-m-d');
		
	 	?>
     	<br>
	
	   
      <a href="new_PDFCasesdaywise.php?nextdate=<?php echo $dateforpdf; ?>" target="_blank"> <img src="icon_pdf.gif" /><label style="color:#0000FF"> CLICK TO OPEN PDF REPORT</label></a>
 

                 <?php
	   }			 
 //---------------------------------- Search for Daily Diary----------------------------------
         
    if(isset($_POST['Dailydiary']))
	{
	 
		$DateString = Date($_SESSION['DefaultDateFormat']);
	
	$date = new DateTime(FormatDateForSQL($DateString));
           
		
		$sql = 'SELECT lw_trans.brief_file,
				lw_trans.courtcaseno,
				lw_trans.party,
				lw_trans.oppoparty,
				lw_trans.courtname,
				lw_trans.stage,
				lw_trans.prevcourtdate,
				lw_trans.nextcourtdate 
				FROM lw_trans WHERE lw_trans.currtrandate="' . $date->format('Y-m-d') . '"';
		
	$StatementResults=DB_query($sql,$db);			
	
	  	?> <br>
     
    <a href="new_PDFDailydiary.php" target="_blank"> <img src="icon_pdf.gif" /></a>
   	<label style="color:#0000FF">Daily Diary</label>

            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                
                    <div class="uk-overflow-container">
                     <i class='md-icon material-icons' id='invoice_print'>&#xE8ad;</i>
                        <div class="uk-width-medium-1-1"  align="left" style="padding-bottom:10px"> Please update all client's numbers before clicking here -> 
                        <input type="submit" name="submittodaysms" value="Send SMS TO Clients" class="md-btn md-btn-primary" style="text-align:center" />
                        </div>
                        <table class="uk-table uk-table-condensed">
                <thead>  
                <?php 
	$TableHeader = "<tr>	
				<th>" . _('ID') . "</th>
			<th>" . _('Prev Date') . "</th>
			<th>" . _('Brief_File') . "</th>
			<th>" . _('Court Case No') . "</th>
			<th>" . _('Court') . "</th>
			<th>" . _('Party Name') . "</th>
			<th>" . _('Mobile No') . "</th>
			<th>" . _('Next Date') . "</th>
		   </tr></thead>";                     
                                
         echo $TableHeader;
		
			$id=1;			
     	
	while($Contacts=DB_fetch_array($StatementResults))
		{
			$resultparty=DB_query("SELECT name,mobile FROM lw_contacts WHERE lw_contacts.id='" . $Contacts['party'] . "'",$db);	
				$myrowparty=DB_fetch_array($resultparty);
	  
	  $resultoppoparty=DB_query("SELECT name FROM lw_contacts WHERE lw_contacts.id='" . $Contacts['oppoparty'] . "'",$db);	
				$myrowoppoparty=DB_fetch_array($resultoppoparty);
			
	$resultstage=DB_query("SELECT stage FROM lw_stages WHERE lw_stages.stageid='" . $Contacts['stage'] . "'",$db);
			$myrowstage=DB_fetch_array($resultstage);
	
      $resultcourt=DB_query("SELECT courtname FROM lw_courts WHERE lw_courts.courtid='" . $Contacts['courtname'] . "'",$db);		
			$myrowcourt=DB_fetch_array($resultcourt);
	
	if(!empty($Contacts['prevcourtdate']))
	{
	$Contacts['prevcourtdate']=ConvertSQLDate($Contacts['prevcourtdate']);
	}
	
	else
	
	{
	$Contacts['prevcourtdate']=$Contacts['prevcourtdate'];
	}
	
	


if(!empty($Contacts['nextcourtdate']))
	{
	$Contacts['nextcourtdate']=ConvertSQLDate($Contacts['nextcourtdate']);
	}
	
	else
	
	{
	$Contacts['nextcourtdate']=$Contacts['nextcourtdate'];
	}
	
		
		printf("<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td style='color:#FFFFFF; background-color:#1976d2; font-weight:bold; text-align:center'>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			</tr>",
			$id++,
			$Contacts['prevcourtdate'],
			$Contacts['brief_file'],
			$Contacts['courtcaseno'],
			$myrowcourt['courtname'],
			$myrowparty['name'],
			$myrowparty['mobile'],
			$Contacts['nextcourtdate']);	
				
	}
     	         echo '</table>';
		 }//end while loop

 //--------------------------- Search to find similar partynames in lw_contacts and lw_cases leading to ERRORS----------------------------
         
     if(isset($_POST['Errorfinder']))
	{
	
		$sql = "SELECT lw_cases.brief_file,
			lw_cases.party,
			lw_cases.oppoparty,
			lw_cases.courtcaseno
	FROM lw_cases WHERE lw_cases.deleted!=1 ORDER BY lw_cases.party ASC,lw_cases.oppoparty DESC,lw_cases.courtcaseno ASC";
					
		$StatementResults=DB_query($sql,$db);
		
		
     ?>
     
    <a href="new_PDFErrorList.php" target="_blank"> <img src="icon_pdf.gif" />
   <label style="color:#0000FF"> ERROR FINDER LIST </label></a>

            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                
                    <div class="uk-overflow-container">
                        <table class="uk-table uk-table-condensed">
                <thead>  
                <?php 
	$TableHeader = "<tr>
		
				<th>" . _('ID') . "</th>
				<th>" . _('Brief_File No') . "</th>
				<th>" . _('Check Party ID Duplication') . "</th>
				<th>" . _('Party') . "</th>
                <th>" . _('Check Oppo Party ID Duplication') . "</th>
				<th>" . _('Opposite Party') . "</th>
				<th>" . _('Case No') . "</th>
                <th>" . _('Mobile') . "</th>
				</tr></thead>";
                           
	echo $TableHeader;
		
		$id=1;

			
		while($Contacts=DB_fetch_array($StatementResults))
		{
		
		$resultparty=DB_query("SELECT id,name,mobile FROM lw_contacts WHERE lw_contacts.id='" . $Contacts['party'] . "'",$db);	
				$myrowparty=DB_fetch_array($resultparty);
	  
	    $resultoppoparty=DB_query("SELECT id,name FROM lw_contacts WHERE lw_contacts.id='" . $Contacts['oppoparty'] . "'",$db);	
				$myrowoppoparty=DB_fetch_array($resultoppoparty);
				
		
		printf("<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
                <td>%s</td>
                <td>%s</td>
				</tr>",
				$id++,
				$Contacts['brief_file'],
                $myrowparty['id'],
                $myrowparty['name'],
                $myrowoppoparty['id'],
                $myrowoppoparty['name'],
                $Contacts['courtcaseno'],
                $myrowparty['mobile']				
				);	
	
	}
	 echo '</table>';
		 
			
		 }//end while loop

 //---------------------------------- Search for Party List----------------------------------
         
     if(isset($_POST['Partylist']))
	{
	
		$sql = "SELECT c.brief_file,
			p1.name AS party,
            p1.mobile,
			p2.name AS oppoparty,
			c.courtcaseno,
			c.opendt
	FROM lw_cases AS c INNER JOIN lw_contacts AS p1 ON c.party=p1.id INNER JOIN lw_contacts AS p2 ON c.oppoparty=p2.id WHERE c.deleted!=1 ORDER BY c.brief_file";
					
		$StatementResults=DB_query($sql,$db);
       	
		
		?>
     
    <a href="new_PDFCasesList.php" target="_blank"> <img src="icon_pdf.gif" /></a>
   <label style="color:#0000FF">CASES LIST</label>

            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                
                    <div class="uk-overflow-container">
                        <table class="uk-table uk-table-condensed">
                <thead>  
                <?php 
	$TableHeader = "<tr>
		
				<th>" . _('ID') . "</th>
				<th>" . _('Brief_File No') . "</th>
				<th>" . _('Case No') . "</th>
				<th>" . _('Mobile') . "</th>			
				<th>" . _('Party Name') . "</th>			
				<th>" . _('Opposite Party') . "</th>				
				<th>" . _('Open Date') . "</th>
				<th>" . _('Next Date') . "</th>
				</tr></thead>";


                           
	echo $TableHeader;
		
		$id=1;

			
		while($Contacts=DB_fetch_array($StatementResults))
		{
		
				
	$sqldates='SELECT lw_trans.prevcourtdate, lw_trans.nextcourtdate FROM lw_trans WHERE lw_trans.brief_file="' . $Contacts['brief_file']  .  '" ORDER BY lw_trans.nextcourtdate DESC LIMIT 1';
	
    $StatementResultsnextcourtdate=DB_query($sqldates,$db);
	
    $myrowtransbrieflastcourtdate=DB_fetch_array($StatementResultsnextcourtdate);
	
  if(!empty($myrowtransbrieflastcourtdate['nextcourtdate']))
	{
	$myrowtransbrieflastcourtdate['nextcourtdate']=ConvertSQLDate($myrowtransbrieflastcourtdate['nextcourtdate']);
	}
	
	else
	
	{
	$myrowtransbrieflastcourtdate['nextcourtdate']=$myrowtransbrieflastcourtdate['nextcourtdate'];
	}


if(!empty($myrowtransbrieflastcourtdate['prevcourtdate']))
	{
	$myrowtransbrieflastcourtdate['prevcourtdate']=ConvertSQLDate($myrowtransbrieflastcourtdate['prevcourtdate']);
	}
	
	else
	
	{
	$myrowtransbrieflastcourtdate['prevcourtdate']=$myrowtransbrieflastcourtdate['prevcourtdate'];
	}
		

if(!empty($Contacts['opendt']))
	{
	$Contacts['opendt']=ConvertSQLDate($Contacts['opendt']);
	}
	
	else
	
	{
	$Contacts['opendt']=$Contacts['opendt'];
	}	
		
		printf("<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				</tr>",
				$id++,
				$Contacts['brief_file'],
				$Contacts['courtcaseno'],
				$Contacts['mobile'],
				$Contacts['party'],
				$Contacts['oppoparty'],				
				$Contacts['opendt'],
				$myrowtransbrieflastcourtdate['nextcourtdate']);	
	
	}
	 echo '</table>';
		 
			
		 }//end while loop                                 
                                 

 //---------------------------------- Search for Courtwise Cases----------------------------------
         
   if(isset($_POST['Courtwisecases']))
	{	   

		echo '<form action=' . $_SERVER['PHP_SELF'] . ' method="POST">';
		/*-----------------------------------------------------------------------------*/
		$result=DB_query("SELECT courtid, courtname FROM lw_courts ",$db);
         echo '<br><label><b>Select Court Name</b></label>';?>
		<div class="md-input-wrapper">
		<div class="uk-width-medium-1-1" style="padding-bottom:0px">
        <div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">
        <div class="uk-grid">
		<div class="uk-width-medium-1-4" style="padding-bottom:10px">
		
		
		<?php echo '<select tabindex="14" Name="Courts" class="md-input">';
	
	while ($myrow = DB_fetch_array($result)) {
		
		echo "<option VALUE='". $myrow[0] . "'>" . $myrow[1];
		
	} //end while loop
	
	DB_free_result($result);
	 
		echo '</select></div>';
		
		echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px"><input type="Submit" Name="Courtwisereport" class="md-btn md-btn-primary" Value="'. _('View Courtwise Report'). '"></div></div>';

	} 
	if(isset($_POST['Courtwisereport']))
	{
	//courtname to be added now
        $sql = 'SELECT c.brief_file,
			lw_courts.courtname,
			p1.name AS party,
            p1.mobile,
			p2.name AS oppoparty,
			c.courtcaseno,
			c.opendt
	FROM lw_cases AS c INNER JOIN lw_contacts AS p1 ON c.party=p1.id INNER JOIN lw_contacts AS p2 ON c.oppoparty=p2.id INNER JOIN lw_courts ON c.courtid=lw_courts.courtid WHERE c.courtid="' . $_POST['Courts']  .  '" AND c.deleted!=1';
					
     				
	$StatementResults=DB_query($sql,$db);				
	$courtforpdf=$_POST['Courts'];
	?>
    
	 <a href="new_PDFCasescourtwise.php?courtpdf=<?php echo $courtforpdf; ?>" target="_blank"> <img src="icon_pdf.gif" /></a>
  	 <label style="color:#0000FF">COURTWISE DETAILS</label>
 


            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                
                    <div class="uk-overflow-container">
                        <table class="uk-table uk-table-condensed">
                <thead>  
                <?php 
	$TableHeader = "<tr>
	
			<th>" . _('ID') . "</th>
			<th>" . _('Prev Date') . "</th>
			<th>" . _('Court') . "</th>
			<th>" . _('Case No') . "</th>
			<th>" . _('Brief_File') . "</th>
			<th>" . _('Party Name') . "</th>
			<th>" . _('Opposite Party') . "</th>
			<th>" . _('Mobile') . "</th>
			<th>" . _('Next Date') . "</th>
		   </tr></thead>";
	
                           
	echo $TableHeader;
		
		$today=date('d-m-Y');
		$i=0;
		$id=1;
		$n=0;
		
		while($Contacts=DB_fetch_array($StatementResults))
		{				
		
		$sqlcourtdates='SELECT lw_trans.prevcourtdate,lw_trans.nextcourtdate FROM lw_trans WHERE lw_trans.brief_file="' . $Contacts['brief_file']  .  '"  ORDER BY lw_trans.nextcourtdate DESC LIMIT 1';
		$StatementResultscourtdates=DB_query($sqlcourtdates,$db);
		$myrowtransbrieflastcourtdates=DB_fetch_array($StatementResultscourtdates);
		
		if(!empty($myrowtransbrieflastcourtdates[0]))
		{
		$myrowtransbrieflastcourtdates[0]=ConvertSQLDate($myrowtransbrieflastcourtdates[0]);
		}
		
		else
		
		{
		$myrowtransbrieflastcourtdates[0]=$myrowtransbrieflastcourtdates[0];
		}
	
	
	if(!empty($myrowtransbrieflastcourtdates[1]))
		{
		$myrowtransbrieflastcourtdates[1]=ConvertSQLDate($myrowtransbrieflastcourtdates[1]);
		}
		
		else
		
		{
		$myrowtransbrieflastcourtdates[1]=$myrowtransbrieflastcourtdates[1];
		}
	
			printf("<tr><td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td style='color:#FFFFFF; background-color:#1976d2; font-weight:bold; text-align:center'>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>	
			<td>%s</td>			
			</tr>",
		
			$id++,
			$myrowtransbrieflastcourtdates[0],
			$Contacts['courtname'],
			$Contacts['courtcaseno'],
			$Contacts['brief_file'],
			$Contacts['party'],
			$Contacts['oppoparty'],
			$Contacts['mobile'],
			$myrowtransbrieflastcourtdates[1]);
				
		}
	                             
            }//end while loop ?>
                           
                        </table>
              <!-- Table ends -->
              
                                  
  <?php
 //---------------------------------- Search for Stagewise Cases----------------------------------
         
   if(isset($_POST['Stagewisecases']))
	{
	   

		echo '<form action=' . $_SERVER['PHP_SELF'] . ' method="POST">';
		/*-----------------------------------------------------------------------------*/
		$result=DB_query("SELECT stageid, stage FROM lw_stages ",$db);
         echo '<br><label><b>Select Stage</b></label>';?>
		<div class="md-input-wrapper">
				<div class="uk-width-medium-1-1" style="padding-bottom:0px">
        <div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">
       <div class="uk-grid">
		<div class="uk-width-medium-1-4" style="padding-bottom:10px">
		
		
		<?php echo '<select tabindex="14" Name="Stage" class="md-input">';
	
	while ($myrow = DB_fetch_array($result)) {
		
		echo "<option VALUE='". $myrow[0] . "'>" . $myrow[1];
		
	} //end while loop
	
	DB_free_result($result);
	 
		echo '</select></div>';
		
		echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px"><input type="Submit" Name="Stagewisereport" class="md-btn md-btn-primary" Value="'. _('View Stagewise Report'). '"></div></div>';

	} 
	if(isset($_POST['Stagewisereport']))
	{
        $sql = 'SELECT c.brief_file,
			lw_courts.courtname,
			lw_stages.stage,
			p1.name AS party,
            p1.mobile,
			p2.name AS oppoparty,
			c.courtcaseno,
			c.opendt
	FROM lw_cases AS c INNER JOIN lw_contacts AS p1 ON c.party=p1.id INNER JOIN lw_contacts AS p2 ON c.oppoparty=p2.id INNER JOIN lw_courts ON c.courtid=lw_courts.courtid INNER JOIN lw_stages ON c.stage=lw_stages.stageid WHERE c.stage="' . $_POST['Stage']  .  '" AND c.deleted!=1';
					
     				
	$StatementResults=DB_query($sql,$db);				
	$stageforpdf=$_POST['Stage'];
	?>
    
	 <a href="new_PDFCasestagewise.php?stagepdf=<?php echo $stageforpdf; ?>" target="_blank"> <img src="icon_pdf.gif" /></a>
  	 <label style="color:#0000FF">STAGEWISE DETAILS</label>
            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                
                    <div class="uk-overflow-container">
                        <table class="uk-table uk-table-condensed">
                <thead>  
                <?php 
	$TableHeader = "<tr>
	
			<th>" . _('ID') . "</th>
			<th>" . _('Prev Date') . "</th>
			<th>" . _('Court') . "</th>
			<th>" . _('Stage') . "</th>
			<th>" . _('Case No') . "</th>
			<th>" . _('Brief_File') . "</th>
			<th>" . _('Party Name') . "</th>
			<th>" . _('Opposite Party') . "</th>
			<th>" . _('Mobile') . "</th>
			<th>" . _('Next Date') . "</th>
		   </tr></thead>";
	
                           
	echo $TableHeader;
		
		$today=date('d-m-Y');
		$i=0;
		$id=1;
		$n=0;
		
		while($Contacts=DB_fetch_array($StatementResults))
		{				
		
		$sqlcourtdates='SELECT lw_trans.prevcourtdate,lw_trans.nextcourtdate FROM lw_trans WHERE lw_trans.brief_file="' . $Contacts['brief_file']  .  '"  ORDER BY lw_trans.nextcourtdate DESC LIMIT 1';
		$StatementResultscourtdates=DB_query($sqlcourtdates,$db);
		$myrowtransbrieflastcourtdates=DB_fetch_array($StatementResultscourtdates);
		
		if(!empty($myrowtransbrieflastcourtdates[0]))
		{
		$myrowtransbrieflastcourtdates[0]=ConvertSQLDate($myrowtransbrieflastcourtdates[0]);
		}
		
		else
		
		{
		$myrowtransbrieflastcourtdates[0]=$myrowtransbrieflastcourtdates[0];
		}
	
	
	if(!empty($myrowtransbrieflastcourtdates[1]))
		{
		$myrowtransbrieflastcourtdates[1]=ConvertSQLDate($myrowtransbrieflastcourtdates[1]);
		}
		
		else
		
		{
		$myrowtransbrieflastcourtdates[1]=$myrowtransbrieflastcourtdates[1];
		}
	
			printf("<tr><td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td style='color:#FFFFFF; background-color:#1976d2; font-weight:bold; text-align:center'>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>	
			<td>%s</td>			
			</tr>",
		
			$id++,
			$myrowtransbrieflastcourtdates[0],
			$Contacts['courtname'],
			$Contacts['stage'],
			$Contacts['courtcaseno'],
			$Contacts['brief_file'],
			$Contacts['party'],
			$Contacts['oppoparty'],
			$Contacts['mobile'],
			$myrowtransbrieflastcourtdates[1]);
				
		}
	                             
            }//end while loop ?>
                           
                        </table>
              <!-- Table ends -->
                           
          <?php
  //---------------------------------- Statuswise Cases----------------------------------
	         
	   if(isset($_POST['Statuswisecases']))
	{
	    echo '<div class="uk-form-row">';
		echo '<form action=' . $_SERVER['PHP_SELF'] . ' method="POST">';
		/*-----------------------------------------------------------------------------*/
		$result=DB_query("SELECT casestatusid, casestatusdesc FROM lw_case_status",$db);
	  
		
		echo '<div class="md-input-wrapper">';
		
		echo '<br><label for="uk_Nextdate">Select Status</label>';
		echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px">';
			
	echo '<select tabindex="14" Name="CaseStatus" class="md-input">';
	
	while ($myrow = DB_fetch_array($result)) {
		
		echo "<option VALUE='". $myrow[0] . "'>" . $myrow[1];
		
	} //end while loop
	
	DB_free_result($result);
	
		echo '</select>';
	
		
		echo '<input type="Submit" Name="Casestatusreport" class="md-btn md-btn-primary" Value="'. _('View Statuswise Cases'). '"></div>';
	
	} 
	
	if(isset($_POST['Casestatusreport']))
	{
	
	 $sql = 'SELECT c.brief_file,
			p1.name AS party,
			p2.name AS oppoparty,
			lw_casecat.casecat,
			c.courtcaseno,
			lw_courts.courtname,
			lw_stages.stage,
			lw_case_status.casestatusdesc
		FROM lw_cases AS c INNER JOIN lw_contacts AS p1 ON c.party=p1.id INNER JOIN lw_contacts AS p2 ON c.oppoparty=p2.id INNER JOIN lw_courts ON c.courtid=lw_courts.courtid INNER JOIN lw_casecat ON c.casecatid=lw_casecat.casecatid INNER JOIN lw_stages ON c.stage=lw_stages.stageid INNER JOIN lw_case_status ON c.casestatus=lw_case_status.casestatusid WHERE c.casestatus="' . $_POST['CaseStatus']  .  '" AND c.deleted!=1';
	
			
	$StatementResults=DB_query($sql,$db);
		
				
		?>
     
    <a href="PDFCasestatuslist.php" target="_blank"> <img src="icon_pdf.gif" /></a>
   <label style="color:#0000FF">STATUS WISE CASES</label>

            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                
                    <div class="uk-overflow-container">
                        <table class="uk-table uk-table-condensed">
                <thead>  
                <?php 
	$TableHeader = "<tr>
	
			<th>" . _('ID') . "</th>
			<th>" . _('Prev. Date') . "</th>
			<th>" . _('Court') . "</th>
			<th>" . _('Case No') . "</th>
			<th>" . _('Brief_File') . "</th>
			<th>" . _('Party Name') . "</th>
			<th>" . _('Opposite Party') . "</th>
			<th>" . _('Status') . "</th>
			<th>" . _('Next Date') . "</th>
		   </tr></thead>";

                           
	echo $TableHeader;
	$today=date('d-m-Y');

	$id=1;

	
		while($Contacts=DB_fetch_array($StatementResults))
		{
		
		 $sqldates='SELECT lw_trans.prevcourtdate, lw_trans.nextcourtdate FROM lw_trans WHERE lw_trans.brief_file="' . $Contacts['brief_file']  .  '"   ORDER BY lw_trans.nextcourtdate DESC LIMIT 1';
	$StatementResultsnextcourtdate=DB_query($sqldates,$db);
	$myrowtransbrieflastcourtdate=DB_fetch_array($StatementResultsnextcourtdate);
	
	
	if(!empty($myrowtransbrieflastcourtdate['nextcourtdate']))
	{
	$myrowtransbrieflastcourtdate['nextcourtdate']=ConvertSQLDate($myrowtransbrieflastcourtdate['nextcourtdate']);
	}
	
	else
	
	{
	$myrowtransbrieflastcourtdate['nextcourtdate']=$myrowtransbrieflastcourtdate['nextcourtdate'];
	}


if(!empty($myrowtransbrieflastcourtdate['prevcourtdate']))
	{
	$myrowtransbrieflastcourtdate['prevcourtdate']=ConvertSQLDate($myrowtransbrieflastcourtdate['prevcourtdate']);
	}
	
	else
	
	{
	$myrowtransbrieflastcourtdate['prevcourtdate']=$myrowtransbrieflastcourtdate['prevcourtdate'];
	}
		

      		printf("<tr><td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td style='color:#FFFFFF; background-color:#1976d2; font-weight:bold; text-align:center'>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			</tr>",		
			$id++,
			$myrowtransbrieflastcourtdate['prevcourtdate'],
			$Contacts['courtname'],
			$Contacts['courtcaseno'],
			$Contacts['brief_file'],
			$Contacts['party'],
			$Contacts['oppoparty'],
			$Contacts['casestatusdesc'],	
			$myrowtransbrieflastcourtdate['nextcourtdate']);		
		
		
		}
	        echo '</table>';            
        }//end while loop ?>
                           
                       
              <!-- Table ends -->               
         
  
  <?php 
  
  
  	 //---------------------------------- Notice  List----------------------------------

     
     if(isset($_POST['Noticelist']))
	{
		$sql = "SELECT cr.noticeid,
			cr.notice_no,
			p1.name AS party,
			p2.name AS oppoparty,
			lw_notices.noticedt,
			lw_notices.sendmode,
			lw_notices.postrecptno,
			lw_notices.receiptdt,
			lw_notices.claimdate,
			lw_notices.returnenvelopdt,
			lw_notices.receivedby,
			lw_notices.noticefees,
			lw_notices.postage,
			lw_notices.othercharges,
			lw_notices.remark
			FROM lw_noticecr AS cr INNER JOIN lw_notices ON cr.noticeid=lw_notices.id INNER JOIN lw_contacts AS p1 ON cr.party=p1.id INNER JOIN lw_contacts AS p2 ON cr.oppoparty=p2.id";
		$StatementResults=DB_query($sql,$db);
		
			
		
		?>
	
	 
	 <br>
     
    	<a href="new_PDFNoticesList.php" target="_blank"> <img src="icon_pdf.gif" /></a>
  		 <label style="color:#0000FF">Notice List</label>

            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                
                    <div class="uk-overflow-container">
                        <table class="uk-table uk-table-condensed">
                <thead>  
                <?php 
				
				$id=1;
                
		$TableHeader = "<tr>

				<th>" . _('ID') . "</th>
				<th>" . _('Notice Number') . "</th>
				<th>" . _('Party') . "</th>
				<th>" . _('Opposite Party') . "</th>
				<th>" . _('Notice Date') . "</th>
				<th>" . _('Send By') . "</th>
				<th>" . _('Receipt Number') . "</th>
				<th>" . _('Receipt Date') . "</th>
				<th>" . _('Claim Date') . "</th>
				<th>" . _('Returned Envelope Date') . "</th>
				<th>" . _('Received By') . "</th>
				<th>" . _('Fees') . "</th>
				<th>" . _('Postage') . "</th>
				<th>" . _('Other Charges') . "</th>
				<th>" . _('Remark') . "</th>
			   </tr>";
	
		echo $TableHeader;
		
		while($myrow=DB_fetch_array($StatementResults))
		{		
		
	if(!empty($myrow['noticedt']))
	{
	$myrow['noticedt']=ConvertSQLDate($myrow['noticedt']);
	}	
	else	
	{
	$myrow['noticedt']=$myrow['noticedt'];
	}
		
	if(!empty($myrow['claimdate']))
	{
	$myrow['claimdate']=ConvertSQLDate($myrow['claimdate']);
	}	
	else	
	{
	$myrow['claimdate']=$myrow['claimdate'];
	}	
	
	if(!empty($myrow['receiptdt']))
	{
	$myrow['receiptdt']=ConvertSQLDate($myrow['receiptdt']);
	}	
	else	
	{
	$myrow['receiptdt']=$myrow['receiptdt'];
	}
	

	if(!empty($myrow['returnenvelopdt']))
	{
	$myrow['returnenvelopdt']=ConvertSQLDate($myrow['returnenvelopdt']);
	}	
	else	
	{
	$myrow['returnenvelopdt']=$myrow['returnenvelopdt'];
	}
	

		
			printf("
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				</tr>",
				$id++,
				$myrow['notice_no'],
				$myrow['party'],
				$myrow['oppoparty'],
				$myrow['noticedt'],
				$myrow['sendmode'],
				$myrow['postrecptno'],
				$myrow['receiptdt'],
				$myrow['claimdate'],
				$myrow['returnenvelopdt'],
				$myrow['receivedby'],
				$myrow['noticefees'],
				$myrow['postage'],
				$myrow['othercharges'],
				$myrow['remark']);		
		  	}
		 
			echo '</table></div>';
			
		}
		                        
            //end while loop ?>
                           
                        </table> <!-- Table ends -->
                        <?php 
      //---------------------------------- Party Details----------------------------------
	         
	  if(isset($_POST['Partydetails']))
	{
	echo '<br><label><b>Enter Name for Party Details Report</b></label>';
	echo '<div class="uk-form-row">';
		echo '<form action=' . $_SERVER['PHP_SELF'] . ' method="POST">';
		
		/*-----------------------------------------------------------------------------*/
		
		echo '<div class="md-input-wrapper">';
		echo '<div class="uk-width-medium-1-1" style="padding-bottom:0px">';
        echo '<div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">';
       echo '<div class="uk-grid">';		
		echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">';              
        echo '<input type="text" name="Casepartyname" id="Casepartyname" class="Casepartyname"  tabindex="2" ></div>';
        echo '<input type="hidden" name="ClientIdhidden" id="ClientIdhidden" tabindex="2" >'; 
	echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">';
	echo '<input type=Submit Name="Partydetailsreport" class="md-btn md-btn-primary" Value="'. _('View Party Details Report'). '"></div></div></div></div>';
		
		
	}
		
		if(isset($_POST['Partydetailsreport']))
	{			
		$sql = "SELECT c.brief_file,
			p1.name AS party,
			p2.name AS oppoparty,
			p1.mobile,
			c.courtcaseno,
			lw_courts.courtname
		FROM lw_cases AS c INNER JOIN lw_contacts AS p1 ON c.party=p1.id INNER JOIN lw_contacts AS p2 ON c.oppoparty=p2.id INNER JOIN lw_courts ON c.courtid=lw_courts.courtid WHERE c.deleted!=1 AND c.party = '" . trim($_POST['ClientIdhidden']) . "' OR c.oppoparty = '" . trim($_POST['ClientIdhidden']) . "'";
					
		$StatementResults=DB_query($sql,$db);
		
		$partyidforpdf=$_POST['ClientIdhidden'];		
		
		?>
     
    <a href="new_PDFPartyDetails.php?partyid=<?php echo $partyidforpdf; ?>" target="_blank"> <img src="icon_pdf.gif" /></a>
   <label style="color:#0000FF">PARTY DETAILS</label>

            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                
                    <div class="uk-overflow-container">
                        <table class="uk-table uk-table-condensed">
                <thead>  
                <?php 
	$TableHeader = "<tr>
		
				<th>" . _('ID') . "</th>
				<th>" . _('Prev. Date') . "</th>
				<th>" . _('Brief_File No') . "</th>
				<th>" . _('Case No') . "</th>
				<th>" . _('Court') . "</th>			
				<th>" . _('Party Name') . "</th>			
				<th>" . _('Opposite Party') . "</th>
				<th>" . _('Mobile') . "</th>
				<th>" . _('Next Date') . "</th>
				</tr></thead>";


                           
	echo $TableHeader;
		
		$id=1;

			
		while($Contacts=DB_fetch_array($StatementResults))
		{
		
					
			$sqldates='SELECT lw_trans.prevcourtdate, lw_trans.nextcourtdate FROM lw_trans WHERE lw_trans.brief_file="' . $Contacts['brief_file']  .  '" ORDER BY lw_trans.nextcourtdate DESC LIMIT 1';
	$StatementResultsnextcourtdate=DB_query($sqldates,$db);
	$myrowtransbrieflastcourtdate=DB_fetch_array($StatementResultsnextcourtdate);
	
			if(!empty($myrowtransbrieflastcourtdate['nextcourtdate']))
	{
	$myrowtransbrieflastcourtdate['nextcourtdate']=ConvertSQLDate($myrowtransbrieflastcourtdate['nextcourtdate']);
	}
	
	else
	
	{
	$myrowtransbrieflastcourtdate['nextcourtdate']=$myrowtransbrieflastcourtdate['nextcourtdate'];
	}


if(!empty($myrowtransbrieflastcourtdate['prevcourtdate']))
	{
	$myrowtransbrieflastcourtdate['prevcourtdate']=ConvertSQLDate($myrowtransbrieflastcourtdate['prevcourtdate']);
	}
	
	else
	
	{
	$myrowtransbrieflastcourtdate['prevcourtdate']=$myrowtransbrieflastcourtdate['prevcourtdate'];
	}
		
	
		printf("<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td style='color:#FFFFFF; background-color:#1976d2; font-weight:bold; text-align:center'>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>			
				<td>%s</td>
				</tr>",
				$id++,
				$myrowtransbrieflastcourtdate['prevcourtdate'],
				$Contacts['brief_file'],
				$Contacts['courtcaseno'],
				$Contacts['courtname'],
				$Contacts['party'],
				$Contacts['oppoparty'],
				$Contacts['mobile'],
				$myrowtransbrieflastcourtdate['nextcourtdate']);	
	
	}
	 echo '</table>';
	}
	
	
      //---------------------------------- Case Hitory----------------------------------
	         
	  if(isset($_POST['Casehistory']))
	{
	
	echo '<div class="uk-form-row">';
		echo '<form action=' . $_SERVER['PHP_SELF'] . ' method="POST">';
		
		/*-----------------------------------------------------------------------------*/
		
		echo '<div class="md-input-wrapper">';
		echo '<div class="uk-width-medium-1-1" style="padding-bottom:0px">';
        echo '<div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">';
      echo '<div class="uk-grid">';
					echo '<div class="uk-grid uk-grid-width-1-2 uk-grid-width-large-1-2">';            
								
					echo '<div class="uk-width-medium-1-1" style="padding-bottom:10px">';
					echo '<label><b>' . _('Enter Court Case No') . '</b></label></div>';
                    echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">';
                    echo '<input name="Courtcaseno" id="Courtcaseno" class="Courtcaseno"  tabindex="2"></div>';
                    echo '<input type="hidden" name="Courtcasenohidden" id="Courtcasenohidden" class="Courtcasenohidden"  tabindex="2" >';        
                   echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">';
				   
                echo '<input type="submit" value="Search Client Info" name="Clientid" class="md-btn md-btn-primary"/>
				
				
				</div></div></div></div>';
		
		
	}
		
		if(isset($_POST['Clientid']))
	{			
					
		$Courtcasenumforpdf=$_POST['Courtcasenohidden'];
	
	
	?>
	<br> <a href="new_PDFCasehistory.php?Courtcasenum=<?php echo $Courtcasenumforpdf; ?>" target="_blank"> <img src="icon_pdf.gif" />
   <label style="color:#0000FF">CLICK TO VIEW CASE HISTORY REPORT</label></a>

           <?php

	}
          //---------------------------------- Party Label----------------------------------
	         
	  if(isset($_POST['Partylabel']))
	{
	echo '<label>Enter Name of Party to Print Label</label>';
	echo '<div class="uk-form-row">';
		echo '<form action=' . $_SERVER['PHP_SELF'] . ' method="POST">';
		
		/*-----------------------------------------------------------------------------*/
		
		echo '<div class="md-input-wrapper">';
		
		
		echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">';
              
        echo '<input type="text" name="Casepartyname" id="Casepartyname" class="Casepartyname"  tabindex="2" >';
        echo '<input type="hidden" name="ClientIdhidden" id="ClientIdhidden" tabindex="2" >'; 
	
	echo '<input type=Submit Name="Printlabel" class="md-btn md-btn-primary" Value="'. _('View Party Details Report'). '"></div>';
		
		
	}
		
		if(isset($_POST['Printlabel']))
	{
		
		$sql = "SELECT c.brief_file,
			p1.name AS party,
			p2.name AS oppoparty,
			p1.mobile,
			c.courtcaseno,
			lw_courts.courtname,
		FROM lw_cases AS c INNER JOIN lw_contacts AS p1 ON c.party=p1.id INNER JOIN lw_contacts AS p2 ON c.oppoparty=p2.id INNER JOIN lw_courts ON c.courtid=lw_courts.courtid WHERE c.party = '" . trim($_POST['ClientIdhidden']) . "' OR c.oppoparty = '" . trim($_POST['ClientIdhidden']) . "'  AND c.deleted!=1";
					
		$StatementResults=DB_query($sql,$db);
		
		$partyidforpdf=$_POST['ClientIdhidden'];
		
		
		?>
     
    <a href="PDFPartyDetails_inline.php?partyid=<?php echo $partyidforpdf; ?>" target="_blank"> <img src="icon_pdf.gif" /></a>
   <label style="color:#0000FF">Print Label</label>

            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                
                    <div class="uk-overflow-container">
                        <table class="uk-table uk-table-condensed">
                <thead>  
                <?php 
	$TableHeader = "<tr>
		
				<th>" . _('ID') . "</th>
				<th>" . _('Brief_File No') . "</th>
				<th>" . _('Mobile') . "</th>			
				<th>" . _('Party Name') . "</th>			
				<th>" . _('Opposite Party') . "</th>
				<th>" . _('Court No') . "</th>
				<th>" . _('Court') . "</th>			
				<th>" . _('Prev. Date') . "</th>
				<th>" . _('Next Date') . "</th>
				</tr></thead>";


                           
	echo $TableHeader;
		
		$id=1;

			
		while($Contacts=DB_fetch_array($StatementResults))
		{
		
		$sqldates='SELECT lw_trans.prevcourtdate, lw_trans.nextcourtdate FROM lw_trans WHERE lw_trans.brief_file="' . $Contacts['brief_file']  .  '" ORDER BY lw_trans.nextcourtdate DESC LIMIT 1';
	$StatementResultsnextcourtdate=DB_query($sqldates,$db);
	$myrowtransbrieflastcourtdate=DB_fetch_array($StatementResultsnextcourtdate);
	
			if(!empty($myrowtransbrieflastcourtdate['nextcourtdate']))
	{
	$myrowtransbrieflastcourtdate['nextcourtdate']=ConvertSQLDate($myrowtransbrieflastcourtdate['nextcourtdate']);
	}
	
	else
	
	{
	$myrowtransbrieflastcourtdate['nextcourtdate']=$myrowtransbrieflastcourtdate['nextcourtdate'];
	}


if(!empty($myrowtransbrieflastcourtdate['prevcourtdate']))
	{
	$myrowtransbrieflastcourtdate['prevcourtdate']=ConvertSQLDate($myrowtransbrieflastcourtdate['prevcourtdate']);
	}
	
	else
	
	{
	$myrowtransbrieflastcourtdate['prevcourtdate']=$myrowtransbrieflastcourtdate['prevcourtdate'];
	}
		
	
		printf("<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>			
				<td>%s</td>
				</tr>",
				$id++,
				$Contacts['brief_file'],
				$Contacts['mobile'],
				$Contacts['party'],
				$Contacts['oppoparty'],
				$Contacts['courtcaseno'],
				$Contacts['courtname'],				
				$myrowtransbrieflastcourtdate['prevcourtdate'],
				$myrowtransbrieflastcourtdate['nextcourtdate']);	
	
	}
	 echo '</table>';
	}
	
	
      //---------------------------------- One Party Dues (Multiple Cases)----------------------------------
	         
	   if(isset($_POST['Partydues']))
	{
	
		echo '<label><b>Enter Name</b></label>';
	echo '<div class="uk-form-row">';
		echo '<form action=' . $_SERVER['PHP_SELF'] . ' method="POST">';
		
		/*-----------------------------------------------------------------------------*/
		
		echo '<div class="md-input-wrapper">';
		
			echo '<div class="uk-width-medium-1-1" style="padding-bottom:0px">';
        echo '<div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">';
      echo '<div class="uk-grid">';
		echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">';
              
        echo '<input type="text" name="Casepartyname" id="Casepartyname" class="Casepartyname"  tabindex="2" ></div>';
        echo '<input type="hidden" name="ClientIdhidden" id="ClientIdhidden" tabindex="2" >'; 
	echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">';
	echo '<div class="centre"><input type=Submit Name="partyduesreport" class="md-btn md-btn-primary" Value="'. _('View Party Dues'). '"></div></div></div></div>';
		}
		
		if(isset($_POST['partyduesreport']))
	
	{			
		$sql = "SELECT c.brief_file,
			p1.name AS party,
			p2.name AS oppoparty,
			p1.mobile,
			c.courtcaseno,
			lw_courts.courtname,
			 lw_partyeconomy.totalfees,
			 lw_partyeconomy.balance
		FROM lw_cases AS c INNER JOIN lw_contacts AS p1 ON c.party=p1.id INNER JOIN lw_contacts AS p2 ON c.oppoparty=p2.id LEFT JOIN lw_courts ON c.courtid=lw_courts.courtid LEFT JOIN  lw_partyeconomy ON c.brief_file= lw_partyeconomy.brief_file WHERE c.party = '" . trim($_POST['ClientIdhidden']) . "' OR c.oppoparty = '" . trim($_POST['ClientIdhidden']) . "'  AND c.deleted!=1 ORDER BY lw_partyeconomy.balance DESC";
					
		$StatementResults=DB_query($sql,$db);
		
		$partyidforpdf=$_POST['ClientIdhidden'];
		
		
		?>
     
   <a href="new_PDFPartyDues.php?partydueid=<?php echo $partyidforpdf; ?>" target="_blank" > <img src="icon_pdf.gif" />
   
   <label style="color:#0000FF; cursor:default; padding-top:20px"> Party Dues (Multi Cases) </label></a>

            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                
                    <div class="uk-overflow-container">
                        <table class="uk-table uk-table-condensed">
                <thead>  
                <?php 
	$TableHeader = "<tr>
				<th>" . _('ID') . "</th>
				<th>" . _('Brief_File') . "</th>
				<th>" . _('Case No') . "</th>
				<th>" . _('Party Name') . "</th>
				<th>" . _('Opposite Party Name') . "</th>
				<th>" . _('Mobile') . "</th>
				<th>" . _('Total Fees') . "</th>
				<th>" . _('Balance') . "</th>				
			   </tr></thead>";
                           
	echo $TableHeader;
		
		$i=0;
		$id=1;
		
		while($myrow=DB_fetch_array($StatementResults))
		{
		
			printf("<td>%s</td>
				<td>%s</td>
				<td style='color:#FFFFFF; background-color:#1976d2; font-weight:bold; text-align:center'>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>		
				</tr>",
				$id++,
				$myrow['brief_file'],
				$myrow['courtcaseno'],
				$myrow['party'],
				$myrow['oppoparty'],
				$myrow['mobile'],				
				$myrow['totalfees'],
				$myrow['balance']);		
				  	}
		 
			
	}
	
	?>
                           
                        </table>
              <!-- Table ends -->  
  
        
         <?php
  //---------------------------------- Periodwise Cases----------------------------------
	         
	  if(isset($_POST['Periodwisecases']))
	{
	
	echo '<div class="uk-form-row">';
	 
		echo '<br><label>Periodwise Cases</label><br>';
		echo '<br><form action=' . $_SERVER['PHP_SELF'] . ' method="POST">';
		
		/*------$result=DB_query("SELECT casestatusid, casestatusdesc FROM lw_case_status ",$db);-----------------------------------------------------------------------*/
		
	  
		
		echo '<div class="md-input-wrapper">';
		
		
		echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px">';
		?>	
	<div class="md-input-wrapper">From Date<input class="md-input" type="text" name="FromDate" id="FromDate" data-uk-datepicker="{format:'DD/MM/YYYY'}"><span class="md-input-bar"></span>		</div>
		
<div class="md-input-wrapper">To Date<input class="md-input" type="text" name="ToDate" id="ToDate" data-uk-datepicker="{format:'DD/MM/YYYY'}"><span class="md-input-bar"></span>		</div>
		
<?php 
		echo '<input type=Submit Name="Periodwisereport" class="md-btn md-btn-primary" Value="' . _('View Report'). '"></div>';
		
		}
	
	if(isset($_POST['Periodwisereport']))
	{
	
	$fromdate=FormatDateForSQL($_POST['FromDate']);
	$todate=FormatDateForSQL($_POST['ToDate']);
	
     $sql = 'SELECT lw_trans.brief_file,
				lw_trans.courtcaseno,
				lw_trans.party,
				lw_trans.oppoparty,
				lw_trans.courtname,
				lw_trans.stage,
				lw_trans.prevcourtdate,
				lw_trans.nextcourtdate 
				FROM lw_trans WHERE lw_trans.currtrandate >="' . FormatDateForSQL($_POST['FromDate']) . '" AND lw_trans.currtrandate <="' . FormatDateForSQL($_POST['ToDate']) . '" ORDER BY lw_trans.currtrandate ASC';
		
	$StatementResults=DB_query($sql,$db);			
	
	  	?> <br>
      <a href="new_PDFPeriodwiseCases.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>" target="_blank"> <img src="icon_pdf.gif" />
   &nbsp;<label style="color:#0000FF">Periodwise Cases</label> </a><br><br> 

            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                
                    <div class="uk-overflow-container">
                        <table class="uk-table uk-table-condensed">
                <thead>  
                <?php 
	$TableHeader = "<tr>	
				<th>" . _('ID') . "</th>
			<th>" . _('Prev Date') . "</th>
			<th>" . _('Brief_File') . "</th>
			<th>" . _('Case No') . "</th>
			<th>" . _('Court') . "</th>
			<th>" . _('Party Name') . "</th>
			<th>" . _('Opposite Party') . "</th>			
			<th>" . _('Next Date') . "</th>
		   </tr></thead>";                     
                                
         echo $TableHeader;
		
			$id=1;
			
     	
	while($Contacts=DB_fetch_array($StatementResults))
		{
		
		$resultparty=DB_query("SELECT name,mobile FROM lw_contacts WHERE lw_contacts.id='" . $Contacts['party'] . "'",$db);	
				$myrowparty=DB_fetch_array($resultparty);
	  
	  $resultoppoparty=DB_query("SELECT name FROM lw_contacts WHERE lw_contacts.id='" . $Contacts['oppoparty'] . "'",$db);	
				$myrowoppoparty=DB_fetch_array($resultoppoparty);
			
	$resultstage=DB_query("SELECT stage FROM lw_stages WHERE lw_stages.stageid='" . $Contacts['stage'] . "'",$db);
			$myrowstage=DB_fetch_array($resultstage);
	
      $resultcourt=DB_query("SELECT courtname FROM lw_courts WHERE lw_courts.courtid='" . $Contacts['courtname'] . "'",$db);		
			$myrowcourt=DB_fetch_array($resultcourt);
	
	if(!empty($Contacts['prevcourtdate']))
	{
	$Contacts['prevcourtdate']=ConvertSQLDate($Contacts['prevcourtdate']);
	}
	
	else
	
	{
	$Contacts['prevcourtdate']=$Contacts['prevcourtdate'];
	}


if(!empty($Contacts['nextcourtdate']))
	{
	$Contacts['nextcourtdate']=ConvertSQLDate($Contacts['nextcourtdate']);
	}
	
	else
	
	{
	$Contacts['nextcourtdate']=$Contacts['nextcourtdate'];
	}
		
		printf("<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td style='color:#FFFFFF; background-color:#1976d2; font-weight:bold; text-align:center'>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			</tr>",
			$id++,
			$Contacts['prevcourtdate'],
			$Contacts['brief_file'],
			$Contacts['courtcaseno'],
			$myrowcourt['courtname'],
			$myrowparty['name'],
			$myrowoppoparty['name'],
			$Contacts['nextcourtdate']);	
				
	}
     	         echo '</table>';
	                             
            }//end while loop ?>
                           
                        </table>              <!-- Table ends -->   
                        
                        <?php 
//---------------------------------- All Parties Full Fees Paid List----------------------------------
         
  if(isset($_POST['Allpartiesfullfee']))
	{
	$sqlpartyeconomy = "SELECT lw_partyeconomy.brief_file,
				lw_contacts.name,
				lw_contacts.mobile,
				lw_partyeconomy.courtcaseno,
				lw_partyeconomy.totalfees,
				lw_partyeconomy.balance
			FROM lw_partyeconomy INNER JOIN lw_contacts
		ON lw_partyeconomy.party=lw_contacts.id Where lw_partyeconomy.balance = 0";
		
		$StatementResults=DB_query($sqlpartyeconomy,$db);		
		
	?> <br>
     
    <a href="PDFFullfeespaidlist.php" target="_blank"> <img src="icon_pdf.gif" /></a>
   	<label style="color:#0000FF">Full Fees Received List</label>

            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                
                    <div class="uk-overflow-container">
                        <table class="uk-table uk-table-condensed">
                <thead>  
                <?php 
	$TableHeader = "<tr>
				<th>" . _('ID') . "</th>
				<th>" . _('Brief_File') . "</th>
				<th>" . _('Case No') . "</th>
				<th>" . _('Party Name') . "</th>
				<th>" . _('Mobile') . "</th>
				<th>" . _('Total Fees') . "</th>
				<th>" . _('Balance') . "</th>
				
			   </tr></thead>";

                           
	echo $TableHeader;
		
		$i=0;
		$id=1;
		
	while($myrow=DB_fetch_array($StatementResults))
		{
		
			printf("<td>%s</td>
				<td>%s</td>
				<td style='color:#FFFFFF; background-color:#1976d2; font-weight:bold; text-align:center'>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>
				<td>%s</td>		
				</tr>",
				$id++,
				$myrow['brief_file'],
				$myrow['courtcaseno'],
				$myrow['name'],
				$myrow['mobile'],
				$myrow['totalfees'],
				$myrow['balance']);		
				  	}
					
					echo ' </table>';
		 }//end while loop
		 
		?>
       <?php 
        	// Month wise diary display---------------------//
			   if(isset($_POST['Comdiary']))
{
echo '<div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">';			
echo '<label><b>Displaying Mothwise PDF of Diary Click to Open and View </b> </label>';


		$sqldiarydate = 'SELECT month,year FROM lw_diaryprinted ORDER BY id ASC';
							$StatementResultsdiarydate=DB_query($sqldiarydate,$db);
						
						$TableHeaderresult = "<form method='post' id='deleteuploads' action='' enctype='multipart/form-data'>                        					
						     <table class='uk-table' id='myTableData'><tr bgcolor='#82A2C6'>
									<th>" . _('Year') . "</th> 
									<th>" . _('Months') . "</th>
									</tr>";

									echo $TableHeaderresult;					
									$flag=1;
							
									while($myrowdiary=DB_fetch_array($StatementResultsdiarydate))
											{
														
								if($flag)
								{								
							    printf("<tr><td>");	
								printf($myrowdiary['year'] . '</td>');
								$flag=0;
								}
								
								if($myrowdiary['month']=='Jan')
								{
							    printf("<tr><td>");	
								printf($myrowdiary['year'] . '</td>');
								}
								
					printf("<td><a href='diary/" . $myrowdiary["month"] . '-' . $myrowdiary["year"] .'.pdf' . "' target='_blank'>%s</a></td>",
						$myrowdiary['month']);
								
								}	
							echo '</tr></table></div></div></div></form>';
}
		?>
        
        <?php
		 //---------------------------------- Search for client name from courtcase no.----------------------------------
         
   if(isset($_POST['Caseinfo']))
{

 	$sql = "SELECT c.brief_file,
			p1.name AS party,
			p2.name AS oppoparty,
			p1.mobile,
			p1.address,
			c.courtcaseno,
			c.firnumber,
			c.firdate,
			c.firtime,
			c.policestation,
			lw_courts.courtname,
			lw_stages.stage
	FROM lw_cases AS c INNER JOIN lw_contacts AS p1 ON c.party=p1.id INNER JOIN lw_contacts AS p2 ON c.oppoparty=p2.id INNER JOIN lw_courts ON c.courtid=lw_courts.courtid INNER JOIN lw_stages ON c.stage=lw_stages.stageid WHERE c.deleted!=1 AND c.courtcaseno = '" . trim($_POST['Courtcasenohidden']) . "'";
	$StatementResults=DB_query($sql,$db, $ErrMsg);
	
	$StatementResultsfilesattach=DB_query($sql,$db);	
	$Contactsfilesattached=DB_fetch_array($StatementResultsfilesattach);
	
	

	?>
	 
	 <br>  

            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                
                    <div class="uk-overflow-container">
                    <div class="printMe">
                        <table class="uk-table uk-table-condensed">
                        
                        
                <thead>  
     <?php
	$TableHeader = "<tr>	
			<th><b>" . _('Selected Case Details') . "</b></th>
			<th><i class='md-icon material-icons' id='invoice_print'>&#xE8ad;</i></th>
			</tr></thead><tr>";

	echo $TableHeader;
	
	$id=1;
	
	while($Contacts=DB_fetch_array($StatementResults))
	{
			
$sqldates='SELECT lw_trans.prevcourtdate, lw_trans.nextcourtdate FROM lw_trans WHERE lw_trans.brief_file="' . $Contacts['brief_file']  .  '"   ORDER BY lw_trans.nextcourtdate DESC LIMIT 1';

	$StatementResultsnextcourtdate=DB_query($sqldates,$db);
	$myrowtransbrieflastcourtdate=DB_fetch_array($StatementResultsnextcourtdate);
	
	$dirname="contactimages";
	
	$party=trim($Contacts['party']);	
	 
	$imagepath=$dirname."/".$party.".png" ;
		
	$url=str_replace(" ","",$imagepath);
		
	if(file_exists($url))
	{
	$url="<img name='client_photo_preview' id='client_photo_preview' src='$url' width='150' height='150'/>";
	}else
	{
	$url='';
	}
	
	if(!empty($myrowtransbrieflastcourtdate['nextcourtdate']))
	{
	$myrowtransbrieflastcourtdate['nextcourtdate']=ConvertSQLDate($myrowtransbrieflastcourtdate['nextcourtdate']);
	}
	
	else
	
	{
	$myrowtransbrieflastcourtdate['nextcourtdate']=$myrowtransbrieflastcourtdate['nextcourtdate'];
	}
	

		printf("<tr><td><b>ID</b></td><td>%s</td><td rowspan='8' align='center'><b>Client's Photo</b><br>$url</td></tr>
			<tr><td><b>Brief_File</b></td><td>%s</td></tr>
			<tr><td><b>Case No</b></td><td style='color:#FFFFFF; background-color:#1976d2; font-weight:bold'>%s</td></tr>
			<tr><td><b>Party Name</b></td><td>%s</td></tr>
			<tr><td><b>Opposite Party</b></td><td>%s</td></tr>
			<tr><td><b>Mobile</b></td><td>%s</td></tr>
			<tr><td><b>Court</b></td><td>%s</td></tr>
			<tr><td><b>Next Date</b></td><td>%s</td>				
			</tr>",
			$id++,
			$Contacts['brief_file'],
			$Contacts['courtcaseno'],
			$Contacts['party'],
			$Contacts['oppoparty'],			
			$Contacts['mobile'],
			$Contacts['courtname'],
			$myrowtransbrieflastcourtdate['nextcourtdate']);			
		

	echo '</tr></table></div>';
		
		?>
		
		
		 <table class="uk-table uk-table-condensed">
                        
                        
                <thead>  
     <?php
	 
	 //below is for displaying FIR related details
	 
	$TableHeader = "<tr>
	
			<th><b>" . _('FIR Number') . "</b></th>
			<th><b>" . _('FIR DATE') . "</b></th>
			<th><b>" . _('FIR TIME') . "</b></th>
			<th><b>" . _('Policestation') . "</b></th>		
			</tr></thead>";

	echo $TableHeader;
	
	
			
	if(!empty($Contacts['firdate']))
	{
	$Contacts['firdate']=ConvertSQLDate($Contacts['firdate']);
	}
	
	else
	
	{
	$Contacts['firdate']=$Contacts['firdate'];
	}
		printf("<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>				
			</tr>",			
			$Contacts['firnumber'],
			$Contacts['firdate'],
			$Contacts['firtime'],
			$Contacts['policestation']);
		 
		echo '</table>';
		
		}// end of while loop
				
				
				
echo '<br><label><b>Displaying Files attached to the case</b> </label>';
		$sql = 'SELECT lw_filesattached.id,lw_filesattached.brief_file,
									lw_filesattached.courtcaseno,
									lw_filesattached.file_name
									FROM lw_filesattached WHERE brief_file="' . $Contactsfilesattached['brief_file'] . '"';
							$StatementResultsfilesattach=DB_query($sql,$db);
					
							$TableHeaderresult = "<form method='post' id='deleteuploads' action='' enctype='multipart/form-data'>                             <table class='uk-table' id='myTableData'><tr bgcolor='#82A2C6'>
									<th>" . _('ID') . "</th>
									<th>" . _('Brief_File') . "</th>
									<th>" . _('Court Case No') . "</th>
									<th>" . _('File Name') . "</th>
									<th>" . _('Delete File') . "</th>
									</tr>";

									echo $TableHeaderresult;
							
									$i=0;
							
									while($myrowfilesattach=DB_fetch_array($StatementResultsfilesattach))
											{
							
									//$file_name=explode("/",$myrow["file_name"]);
									
									$casenonew=str_replace("/","-",$myrowfilesattach['courtcaseno']);
	
									$folder='lpt-'. $casenonew;	
			
																	
									printf("<tr><td>%s</td>
									<td>%s</td>
									<td>%s</td>
									<td><a href='cases/" . $folder .'/'. $myrowfilesattach["file_name"] . "' target='_blank'>%s</a></td>
									<td>%s</td>
									</tr>",
									$myrowfilesattach['id'],
									$myrowfilesattach['brief_file'],
									$myrowfilesattach['courtcaseno'],
									$myrowfilesattach["file_name"],
									'<input type="button" class="md-btn md-btn-primary" style="width:170px" value="DELETE" onClick="Javascript:deleteRow(this)">');
						  
											}	
							echo '</table></div></form>';

		}  
          
		   if(isset($_POST['Casenodetails']))
			{         
			
					      ?>  
         <div class="uk-width-medium-1-1" style="padding-bottom:0px">
        <div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">
        <div class="uk-grid">

					<?php 
					echo '<div class="uk-width-medium-1-1" style="padding-top:10px">';
					echo '<b>Enter Court Case No</b></div>';
                    echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">';
                    echo '<input name="Courtcaseno" id="Courtcaseno" class="Courtcaseno"  tabindex="2" ></div>';
                  
                  echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px"><input type="submit" value="View Case Info" name="Caseinfo" class="md-btn md-btn-primary"/></div>';
				    echo '<input type="hidden" name="Courtcasenohidden" id="Courtcasenohidden" class="Courtcasenohidden"  tabindex="2">';        
                   
				    
       } ?>
       </div></div> </div></div></div>
              
                         </div> <!-- MAIN ENDS-->
                      </div>
                 </div>
       
    <!-- /Search Form Demo -->

<!-- Placed at the end of the document so the pages load faster -->
<script src="jquery-1.11.1.min.js"></script>

<script src="assets/js/common.js"></script> 

<!-- Live Search Script -->
<script type="text/javascript" src="ajaxlivesearch.js"></script>
  
  <script>
  function deleteRow(obj) {
					
					var index=obj.parentNode.parentNode.rowIndex;
					var table=document.getElementById("myTableData");
					emp=document.getElementById("myTableData").rows[index].cells[0];
					fname=document.getElementById("myTableData").rows[index].cells[1];
					table.deleteRow(index);	
						
										
					$.ajax({
						url: 'deletefile.php', // Url to which the request is send
						type: "POST",             // Type of request to be send, called as method
						dataType: "html",
						data: {
									'fileid': emp.textContent,	
									'courtcaseno': $("#Courtcaseno").val(),	
									'party': $("#Party").val(),								
						    		'brief_file': fname.textContent
							  },// Data sent to server, a set of key/value pairs (i.e. form fields and values	
						
						success: function(data)   // A function to be called if request succeeds
						{
						
						//$("#message").html(data);
							
						}
						
						});		
					
					
					}					
					
					
					</script>

<script>


	jQuery(".Casepartyname").ajaxlivesearch({
        loaded_at: <?php echo $time; ?>,
        token: <?php echo "'" . $token . "'"; ?>,
        max_input: <?php echo $maxInputLength; ?>,
        onResultClick: function(e, data) {
            // get the index 0 (first column) value ie id
            var selectedZero = jQuery(data.selected).find('td').eq('0').text();

            // set the input value
           jQuery('#ClientIdhidden').val(selectedZero);
			
			// get the index 0 (first column) value ie name
            var selectedone = jQuery(data.selected).find('td').eq('1').text();

            // set the input value
            jQuery('.Casepartyname').val(selectedone);
		
						
			// hide the result
            jQuery(".Casepartyname").trigger('ajaxlivesearch:hide_result');
        },
        onResultEnter: function(e, data) {
            // do whatever you want
            //jQuery(".mySearch").trigger('ajaxlivesearch:search', {query: 'test'});
        },
        onAjaxComplete: function(e, data) {

        }
    });
	
	// For Party Details by case no
	jQuery(".Courtcaseno").ajaxlivesearch({
        loaded_at: <?php echo $time; ?>,
        token: <?php echo "'" . $token . "'"; ?>,
        max_input: <?php echo $maxInputLength; ?>,
        onResultClick: function(e, data) {
            // get the index 0 (first column) value ie id
            var selectedZero = jQuery(data.selected).find('td').eq('3').text();

            // set the input value
           jQuery('#Courtcaseno').val(selectedZero);
			
			// get the index 0 (first column) value ie name
            var selectedone = jQuery(data.selected).find('td').eq('3').text();

            // set the input value
            jQuery('.Courtcasenohidden').val(selectedZero);
		
						
			// hide the result
            jQuery(".Courtcaseno").trigger('ajaxlivesearch:hide_result');
        },
        onResultEnter: function(e, data) {
            // do whatever you want
            //jQuery(".Courtcaseno").trigger('ajaxlivesearch:search', {query: 'test'});
        },
        onAjaxComplete: function(e, data) {

        }
    });
	
	
	//below is for main search for the lw_casenewajax form
	jQuery(".HeaderinputSearch").ajaxlivesearch({
        loaded_at: <?php echo $time; ?>,
        token: <?php echo "'" . $token . "'"; ?>,
        max_input: <?php echo $maxInputLength; ?>,
        onResultClick: function(e, data) {
            // get the index 1 (second column) value
            var selectedsearch = jQuery(data.selected).find('td').eq('0').text();

            // set the input value
            jQuery('.HeaderinputSearch').val(selectedsearch);
			
			jQuery('#Searchheaderhidden').val(selectedsearch);
			
			
			 /*// get the index 1 (second column) value for address
            var selectedtwo = jQuery(data.selected).find('td').eq('1').text();

            // set the input value
            jQuery('.md-inputaddress').val(selectedtwo);
			
			 // get the index 1 (second column) value for mobile
            var selectedthree = jQuery(data.selected).find('td').eq('2').text();

            // set the input value
            jQuery('.md-inputmobile').val(selectedthree);*/
						
			// hide the result
           jQuery(".HeaderinputSearch").trigger('ajaxlivesearch:hide_result');
        },
        onResultEnter: function(e, data) {
            // do whatever you want
            //jQuery(".HeaderinputSearch").trigger('ajaxlivesearch:search', {query: 'test'});
        },
        onAjaxComplete: function(e, data) {

        }
    });
	</script>
    <script src="print.js"></script>
    <script src="assets/js/uikit_custom.min.js"></script>
    <!-- altair common functions/helpers -->
    <script src="assets/js/altair_admin_common.min.js"></script>
    
     <!--  notifications functions -->
    <script src="assets/js/pages/components_notifications.min.js"></script>

    <!-- page specific plugins -->
        
        <!-- handlebars.js -->
        <script src="bower_components/handlebars/handlebars.min.js"></script>
        <script src="assets/js/custom/handlebars_helpers.min.js"></script>
       
        <!-- fitvids 
        <script src="bower_components/fitvids/jquery.fitvids.js"></script>-->

        <!--  dashbord functions -->
        <script src="assets/js/pages/dashboard.min.js"></script>

   
   <script src="dist/sweetalert.min.js"></script>
   
     
    <script>
    
function MM_openbrwindow(x,width,height){
var smswindow=window.open(x,'popup','width=' + width + ',height=' + height + ',scrollbars=0,resizable=no,toolbar=no,directories=no,location=no,menubar=no,status=yes,left=180,top=30');
}
    
    </script>

   
            
    
</body>
</html>