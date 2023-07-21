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

                    <div>
                    <div class="buttons">
                        <table class="uk-table uk-table-condensed" style="border:#e0e0e0 1px solid">
                          


 <div class="uk-width-medium-1-2" style="padding-bottom:10px">To Search Case details type Clients name or case no</div>

 <?php
  	echo '<label><b>Enter Name for Party Details Report</b></label>';
	echo '<div class="uk-form-row">';
		echo '<form action=' . $_SERVER['PHP_SELF'] . ' method="POST">';
		
		/*-----------------------------------------------------------------------------*/
		
		echo '<div class="md-input-wrapper">';
		echo '<div class="uk-width-medium-1-1" style="padding-bottom:0px">';
        echo '<div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">';
       echo '<div class="uk-grid">';
		
		echo '<div class="uk-width-medium-2-4" style="padding-bottom:10px">';
              
        echo '<input type="text" name="casepartysearch" id="casepartysearch" class="md-input" tabindex="1"></div>';
        echo '<input type="hidden" name="ClientIdhidden" id="ClientIdhidden">'; 
	
	echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px">Case No';
	                               


   echo '<select name="casenolist" id="casenolist" class="md-input">';



echo '</select></div>';
		
		
	echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px">';
	echo '<input type=Submit Name="Partydetailsreport" class="md-btn md-btn-primary" tabindex="2" Value="'. _('View Party Details Report'). '"></div></div></div></div>';
    ?>

<!-- <div class="uk-width-medium-1-3" style="padding-bottom:10px"><input type="submit" value="Any Party's all cases" name="Partydetails" style="color:#ffffff; font-weight:bold; text-transform:capitalize;" class="md-btn md-btn-block md-bg-orange-900 md-btn-wave-light waves-effect waves-button waves-light"/></div>-->
                          
                        </div>
                  </div>
             
<!-- Table ends -->
            
 	
	<?php
		if(isset($_POST['Partydetailsreport']))
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
			c.judgename,
			lw_courts.courtname,
			lw_stages.stage,
			lw_noticecr.notice_no
	FROM lw_cases AS c INNER JOIN lw_contacts AS p1 ON c.party=p1.id INNER JOIN lw_contacts AS p2 ON c.oppoparty=p2.id INNER JOIN lw_courts ON c.courtid=lw_courts.courtid LEFT JOIN lw_noticecr ON c.notice_no=lw_noticecr.notice_no INNER JOIN lw_stages ON c.stage=lw_stages.stageid WHERE c.courtcaseno = '" . trim($_POST['casenolist']) . "'";
	$StatementResults=DB_query($sql,$db);
	
	$StatementResultsfilesattach=DB_query($sql,$db);	
	$Contactsfilesattached=DB_fetch_array($StatementResultsfilesattach);
	
	$StatementResultsclients=DB_query($sql,$db);
	?>
	
	 
              <div class="md-card-content">
                
                    <div class="uk-overflow-container">
                    <div class="printMe">
                        <table class="uk-table uk-table-condensed">
                        
                        <div class="uk-overflow-container">
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
	$url="<img name='client_photo_preview' id='client_photo_preview' src='contactimages/noimage.jpg' width='150' height='150'/>";
	}
	
	if(!empty($myrowtransbrieflastcourtdate['prevcourtdate']))
	{
	$myrowtransbrieflastcourtdate['prevcourtdate']=ConvertSQLDate($myrowtransbrieflastcourtdate['prevcourtdate']);
	}
	
	else
	
	{
	$myrowtransbrieflastcourtdate['prevcourtdate']=$myrowtransbrieflastcourtdate['prevcourtdate'];
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
			<tr><td><b>Brief_File</b></td> <td>%s</td></tr>
			<tr><td><b>Case No</b></td> <td style='color:#FFFFFF; background-color:#1976d2; font-weight:bold'>%s</td></tr>
			<tr><td><b>Party Name</b></td> <td>%s</td></tr>
			<tr><td><b>Opposite Party</b></td> <td>%s</td></tr>
			<tr><td><b>Mobile</b></td> <td>%s</td></tr>
			<tr><td><b>Notice no</b></td> <td>%s</td></tr>
			<tr><td><b>Stage</b></td> <td>%s</td></tr>
			<tr><td><b>Judge Name</b></td> <td>%s</td>
			<td><b>Court</b></td> <td>%s</td></tr>
			<td><b>Previous Date</b> </td><td>%s</td>
			<td><b>Next Date</b></td> <td>%s</td></tr>
			</tr>",
			$id++,
			$Contacts['brief_file'],
			$Contacts['courtcaseno'],
			$Contacts['party'],
			$Contacts['oppoparty'],			
			$Contacts['mobile'],
			$Contacts['notice_no'],
			$Contacts['stage'],
			$Contacts['judgename'],
			$Contacts['courtname'],
			$myrowtransbrieflastcourtdate['prevcourtdate'],
			$myrowtransbrieflastcourtdate['nextcourtdate']
			);			
	echo '</tr></table></div>';
		
		?>
		<div class="uk-grid uk-grid-medium data-uk-grid-margin">
                              
                <div class="uk-width-medium-1-2 uk-width-medium-1-2" style="padding-left:40px">
                                  <div class="md-card" style="overflow:auto; height:300px">
                        <div  class="md-card-content">                       
                     
                        <h4 class="heading_c uk-margin-bottom" align="center"><b>Case Stage History</b></h4>
           
      <?php
$sql = "SELECT lw_trans.id,lw_trans.brief_file,lw_trans.courtcaseno,lw_stages.stage,lw_trans.nextcourtdate FROM lw_trans JOIN lw_stages ON lw_trans.stage=lw_stages.stageid WHERE lw_trans.courtcaseno='". $_POST['casenolist'] ."'";
	
	$StatementResults=DB_query($sql,$db);	
	
	echo '<table class="uk-table uk-table-condensed">';

	$TableHeader = "<thead><tr>
			<th>" . _('Id') . "</th>
			<th>" . _('Brief-File') . "</th>
			<th>" . _('Case No') . "</th>
			<th>" . _('Stage') . "</th>
			<th>" . _('Next Date') . "</th>
	</tr> </thead>";

	echo $TableHeader;

	$id=1;
	
	
	while($Stagehistory=DB_fetch_array($StatementResults))
	{
     
if($Stagehistory['nextcourtdate']!="")
	{
	$Stagehistory['nextcourtdate']=ConvertSQLDate($Stagehistory['nextcourtdate']);
	}
	
	else
	
	{
	$Stagehistory['nextcourtdate']=$Stagehistory['nextcourtdate'];
	}
		
		printf("<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>	
			<td>%s</td>	
			</tr>",
			$id++,
			$Stagehistory['brief_file'],
			$Stagehistory['courtcaseno'],
			$Stagehistory['stage'],
			$Stagehistory['nextcourtdate']);			
			}
	 echo '</table>';
?>
                            
							

                        
                 </div>   
            </div>
            </div>
            
                        
             <div class="uk-width-medium-1-2 uk-width-medium-1-2" style="padding-right:20px">
             
                    <div class="md-card" style="overflow:auto; height:300px">
                        <div class="md-card-content">
                        
                            <h4 class="heading_c uk-margin-bottom" align="center"><b>Case Close/Re-open History</b></h4>
                           
                            <?php
							
							

 $sql = "SELECT lw_casehistory.id,

lw_casehistory.courtcaseno,
lw_casehistory.caseclosedate,
lw_casehistory.casereopendate,
lw_casehistory.result,
lw_casehistory.coram,
lw_casehistory.judgement,
lw_casehistory.remark,
lw_casecloseresult.result 
FROM lw_casehistory INNER JOIN lw_casecloseresult ON lw_casehistory.result=lw_casecloseresult.id WHERE lw_casehistory.brief_file='". $Contacts['brief_file'] ."'";
	
	$StatementResults=DB_query($sql,$db);	
	
	          echo '<table class="uk-table uk-table-condensed">';

	$TableHeader = "<thead><tr>
			<th>" . _('Id') . "</th>
			
			<th>" . _('Case No') . "</th>
			<th>" . _('Close Date') . "</th>
			<th>" . _('Re-open Date') . "</th>
			<th>" . _('Result') . "</th>
			<th>" . _('Coram') . "</th>
			<th>" . _('Judgement') . "</th>
			<th>" . _('Remark') . "</th>
	</tr> </thead>";

	echo $TableHeader;

	$id=1;
	
	
	while($Closehistory=DB_fetch_array($StatementResults))
	{
     
if($Closehistory['caseclosedate']!="")
	{
	$Closehistory['caseclosedate']=ConvertSQLDate($Closehistory['caseclosedate']);
	}
	
	else
	
	{
	$Closehistory['caseclosedate']=$Closehistory['caseclosedate'];
	}
	
if($Closehistory['casereopendate']!="")
	{
	$Closehistory['casereopendate']=ConvertSQLDate($Closehistory['casereopendate']);
	}
	
	else
	
	{
	$Closehistory['casereopendate']=$Closehistory['casereopendate'];
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
			$Closehistory['id'],			
			$Closehistory['courtcaseno'],
			$Closehistory['caseclosedate'],
			$Closehistory['casereopendate'],
			$Closehistory['result'],
			$Closehistory['coram'],
			$Closehistory['judgement'],
			$Closehistory['remark']);			
			}
	 echo '</table>';

?>


                            

                        </div>
                 </div>   
            </div>
         </div>
       
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
							echo '</table></div></div>';
						
					$myrowcts=DB_fetch_array($StatementResultsclients);
		echo '<div class="uk-width-medium-1-1 uk-width-medium-1-1" style="padding-right:20px; padding-left:20px; padding-bottom:20px">';
		echo '<br><label><b>Displaying Other clients attached to the case</b> </label><br>';
		$sql = 'SELECT lw_otherclients.id,lw_otherclients.brief_file,
									lw_otherclients.name,
									lw_otherclients.tag
									FROM lw_otherclients WHERE brief_file="' .  $myrowcts[0] . '"';
							$StatementResultsotherclients=DB_query($sql,$db);						
					
							$TableHeaderresult = "<table class='uk-table' id='myTableData'><tr bgcolor='#82A2C6'>
									<th>" . _('ID') . "</th>
									<th>" . _('Brief_File') . "</th>
									<th>" . _('Name') . "</th>
									<th>" . _('Type') . "</th>								
									</tr>";

									echo $TableHeaderresult;
							
									$i=0;
							
									while($myrowclients=DB_fetch_array($StatementResultsotherclients))
											{
											
											if ($myrowclients['tag']=='C')
											 {
											 $val="Party";
											 }else
											 {
											 $val="Opposite Party";
											 }
																							
												printf("<tr><td>%s</td>
												<td>%s</td>
												<td>%s</td>
												<td>%s</td>
												</tr>",
												$myrowclients['id'],
												$myrowclients['brief_file'],
												$myrowclients['name'],
												$val
												);
						  
												}	
											
							echo '</table></div>';				
					
	$sqlcitation = 'SELECT * FROM lw_citations WHERE brief_file="' .  $myrowcts[0] . '"';
							$StatementResultscitation=DB_query($sqlcitation,$db);
							
							$myrowcitation=DB_fetch_array($StatementResultscitation);
							
							$Content=$myrowcitation[2];
							
							$Content= strip_tags(html_entity_decode($Content));
							         
		 ?>
         
     <div class="uk-width-medium-1-1 uk-width-medium-1-1" style="padding-right:20px; padding-left:20px; padding-bottom:20px"><b>Citations</b>
         <textarea id="elm1" name="elm1" class="md-input"><?php  echo $Content; ?>  </textarea></div>
         
         <?php
		 
         $sqljudgement = 'SELECT * FROM lw_judgement WHERE brief_file="' .  $myrowcts[0] . '"';
							$StatementResultsjudgement=DB_query($sqljudgement,$db);
							
							$myrowjudgement=DB_fetch_array($StatementResultsjudgement);
							
							$Content1=$myrowjudgement[2];
							
							$Content1= strip_tags(html_entity_decode($Content1));
							
							         
		 ?>
         
     <div class="uk-width-medium-1-1 uk-width-medium-1-1" style="padding-right:20px; padding-left:20px; padding-bottom:20px"><b>Judgement</b>
         <textarea id="elm1" name="elm1" class="md-input"><?php  echo $Content1; ?>  </textarea></div>
         
         
         </div></div>
         
             </div>
             <?php
             
      	}  ?>
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

	jQuery("#casepartysearch").ajaxlivesearch({
        loaded_at: <?php echo $time; ?>,
        token: <?php echo "'" . $token . "'"; ?>,
        max_input: <?php echo $maxInputLength; ?>,
        onResultClick: function(e, data) {
            // get the index 0 (first column) value ie id
            var selectedZero = jQuery(data.selected).find('td').eq('5').text();
			
			var selectedTwo = jQuery(data.selected).find('td').eq('1').text();

            // set the input value
           jQuery('#ClientIdhidden').val(selectedZero);	
		   
		   jQuery('#casepartysearch').val(selectedTwo);		   	
						
			// hide the result
            jQuery("#casepartysearch").trigger('ajaxlivesearch:hide_result');
        },
        onResultEnter: function(e, data) {
            // do whatever you want
            //jQuery(".mySearch").trigger('ajaxlivesearch:search', {query: 'test'});
        },
        onAjaxComplete: function(e, data) {

        }
    });
	
	// For Party Details by Case no
	jQuery("#Courtcaseno").ajaxlivesearch({
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
            jQuery('#Courtcasenohidden').val(selectedZero);
		
						
			// hide the result
            jQuery("#Courtcaseno").trigger('ajaxlivesearch:hide_result');
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
	
	
	
	
$("#casenolist").focus(function(e) { 
		
			 
	 $.ajax({
			url: 'lw_casenoload.php',
			type: 'POST',
			dataType: "html",
			data: {
			clientid: $("#ClientIdhidden").val()
		},
		
		 success: function (output) 
			{ 
				$("#casenolist").html(output);   
				      
			},
			error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + errortext); },
			async: false
		});


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

   
   <script src="sweetalert.min.js"></script>
   
     
    <script>
    
function MM_openbrwindow(x,width,height){
var smswindow=window.open(x,'popup','width=' + width + ',height=' + height + ',scrollbars=0,resizable=no,toolbar=no,directories=no,location=no,menubar=no,status=yes,left=180,top=30');
}
    
    </script>

   
            
    
</body>
</html>