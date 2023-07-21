<?php
    $PageSecurity = 2;
    include("includes/session.php");	 
?>

<!doctype html>
<html lang="en">
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
   
    
      <!-- Live Search Styles -->
    <link rel="stylesheet" href="css/fontello.css">
    <link rel="stylesheet" href="css/animation.css">
    <!--[if IE 7]>
    <link rel="stylesheet" href="css/fontello-ie7.css">
    <![endif]-->
   
  <link rel="stylesheet" href="print.css" type="text/css" media="print" />
 
  <link rel="stylesheet" href="tabs/jquery-ui.css">
  
 <script src="tabs/jquery-1.12.4.js"></script>
  <script src="tabs/jquery-ui.js"></script>
  <script>
  $( function() {
    $( "#tabs" ).tabs();
  } );
  </script>
  
  <style>
  .md-btn {
  background: #fff;
  border: none;
  border-radius: 2px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
  min-height: 31px;
  min-width: 70px;
  padding: 2px 16px;
  text-align: center;
  text-shadow: none;
  text-transform: uppercase;
  -webkit-transition: all 280ms cubic-bezier(0.4, 0, 0.2, 1);
  transition: all 280ms cubic-bezier(0.4, 0, 0.2, 1);
  color: #212121;
  box-sizing: border-box;
  cursor: pointer;
  -webkit-appearance: none;
  display: inline-block;
  vertical-align: middle;
  font: 500 14px / 31px "Roboto", sans-serif !important;
}
.md-btn-primary,
.md-btn-primary:hover,
.md-btn-primary:focus,
.md-btn-primary:active {
  background: #2196f3;
  color: #fff;
}
  
  
  </style>
</head>
<body>
 
<div id="tabs">
  <ul>
    <li><a href="#tabs-1">Case details</a></li>
    <li><a href="#tabs-2">Financial Dues</a></li>
    <li><a href="#tabs-3">Correspondence</a></li>
    <li><a href="#tabs-4">Case Stage History</a></li>
     <li><a href="#tabs-5">Case Close History</a></li>
     <li><a href="#tabs-6">Uploaded Documents</a></li>
     
  </ul>
  <div id="tabs-1">
   <?php
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
	FROM lw_cases AS c INNER JOIN lw_contacts AS p1 ON c.party=p1.id INNER JOIN lw_contacts AS p2 ON c.oppoparty=p2.id INNER JOIN lw_courts ON c.courtid=lw_courts.courtid LEFT JOIN lw_noticecr ON c.notice_no=lw_noticecr.notice_no INNER JOIN lw_stages ON c.stage=lw_stages.stageid WHERE c.id = '" . $_GET['id'] . "'";
	$StatementResults=DB_query($sql,$db);
	
	$StatementResultsfilesattach=DB_query($sql,$db);	
	$Contactsfilesattached=DB_fetch_array($StatementResultsfilesattach);
	
	$StatementResultsclients=DB_query($sql,$db);
	?>
	
	 
        
                        <table class="uk-table uk-table-condensed">
                        
                   
                <thead>  
     <?php
	$TableHeader = "<tr>	
			<th><b>" . 'Selected Case Details' . "</b></th>
			<th><i class='md-icon material-icons' id='invoice_print'>&#xE8ad;</i></th>
			</tr></thead><tr>";

	echo $TableHeader;
	
	$id=1;
	
	while($Contacts=DB_fetch_array($StatementResults))
	{
	
$sqldates='SELECT lw_trans.prevcourtdate,lw_trans.courtcaseno,lw_trans.nextcourtdate FROM lw_trans WHERE lw_trans.brief_file="' . $Contacts['brief_file']  .  '"   ORDER BY lw_trans.nextcourtdate ASC';

	$StatementResultsnextcourtdate=DB_query($sqldates,$db);
	$myrowtransbrieflastcourtdate=DB_fetch_array($StatementResultsnextcourtdate);
	
	$dirname="contactimages";
	
	$party=trim($Contacts['party']);
	$brieffile=trim($Contacts['brief_file']);	
	
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
	echo '</tr></table>';
	?>
		<table class="uk-table uk-table-condensed">
                       
                <thead>  
     <?php
	 
	 //below is for displaying FIR related details
	 
	$TableHeader = "<tr>
	
			<th><b>" . 'FIR Number' . "</b></th>
			<th><b>" . 'FIR DATE' . "</b></th>
			<th><b>" . 'FIR TIME' . "</b></th>
			<th><b>" . 'Policestation' . "</b></th>		
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
		} // end of while loop	 
		echo '</table>';
	
		
		
		?>
  </div>
  
  <div id="tabs-2">
    <h4 class="heading_c uk-margin-bottom" align="center"><b>Financial Dues of Client</b></h4>
           
      <?php
	  
	 $sql = "SELECT c.brief_file,
			p1.name AS party,
			p2.name AS oppoparty,
			p1.mobile,
			c.courtcaseno,
			lw_courts.courtname,
			 lw_partyeconomy.totalfees,
			 lw_partyeconomy.balance
		FROM lw_cases AS c INNER JOIN lw_contacts AS p1 ON c.party=p1.id INNER JOIN lw_contacts AS p2 ON c.oppoparty=p2.id LEFT JOIN lw_courts ON c.courtid=lw_courts.courtid LEFT JOIN  lw_partyeconomy ON c.brief_file= lw_partyeconomy.brief_file WHERE c.brief_file = '". $brieffile ."' ORDER BY lw_partyeconomy.balance DESC";
					
		$StatementResults=DB_query($sql,$db);
		
		echo '<table class="uk-table uk-table-condensed" border=1>';
		
		
		$TableHeader = "<thead><tr>
			<th>" . 'Id' . "</th>
			<th>" . 'Brief-File' . "</th>
			<th>" . 'Message' . "</th>
			<th>" . 'Date' . "</th>
	</tr> </thead>";

           
	$TableHeader = "<tr>
				<th>" . 'ID' . "</th>
				<th>" . 'Brief_File' . "</th>
				<th>" . 'Case No' . "</th>
				<th>" . 'Party Name' . "</th>
				<th>" . 'Opposite Party Name' . "</th>
				<th>" . 'Mobile' . "</th>
				<th>" . 'Total Fees' . "</th>
				<th>" . 'Balance' . "</th>				
			   </tr></thead>";
                           
	echo $TableHeader;
		
	
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
				 } // end of while loop	 
		echo '</table>';
		
	  ?>
  </div>
    <div id="tabs-3">

   <h4 class="heading_c uk-margin-bottom" align="center"><b>Sent SMS History</b></h4>
           
      <?php
    $sql = "SELECT lw_smshistory.brief_file,lw_smshistory.message,lw_smshistory.smsdate,lw_smshistory.party FROM lw_smshistory INNER JOIN lw_contacts ON lw_smshistory.party=lw_contacts.id WHERE lw_smshistory.brief_file='". $brieffile ."' ORDER BY lw_smshistory.smsdate ASC";
	
	$StatementResultssms=DB_query($sql,$db);	
	
	echo '<table class="uk-table uk-table-condensed" border=1>';

	$TableHeader = "<thead><tr>
			<th>" . 'Id' . "</th>
			<th>" . 'Brief-File' . "</th>
			<th>" . 'Message' . "</th>
			<th>" . 'Date' . "</th>
	</tr> </thead>";

	echo $TableHeader;

	$id=1;
	
	while($Contactsms=DB_fetch_array($StatementResultssms))
	{
        
if($Contactsms['smsdate']!="")
	{
	$Contactsms['smsdate']=ConvertSQLDate($Contactsms['smsdate']);
	}
	
	else
	
	{
	$Contactsms['smsdate']=$Contactsms['smsdate'];
	}
		
		printf("<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>	
			</tr>",
			$id++,
			$Contactsms['brief_file'],
			$Contactsms['message'],
			$Contactsms['smsdate']);			
		} // end of while loop
		echo '</table>';
	
		?>
	
  </div>
  
  <div id="tabs-4"> <!----------------------------------------------------------- Tab - 4-------------------------------------------------->
 <h4 class="heading_c uk-margin-bottom" align="center"><b>Case Stage History</b></h4>
     <?php	  
$sql = "SELECT lw_trans.id,lw_trans.brief_file,lw_trans.courtcaseno,lw_stages.stage,lw_trans.currtrandate,lw_trans.nextcourtdate FROM lw_trans JOIN lw_stages ON lw_trans.stage=lw_stages.stageid WHERE lw_trans.brief_file='". $brieffile ."' ORDER BY lw_trans.currtrandate ASC";
	
	$StatementResultscasestage=DB_query($sql,$db);	
	
	echo '<table class="uk-table uk-table-condensed" border=1>';

	$TableHeader = "<thead><tr>
			<th>" . 'Id' . "</th>
			<th>" . 'Brief-File' . "</th>
			<th>" . 'Case No' . "</th>
			<th>" . 'Stage' . "</th>
			<th>" . 'Next Date' . "</th>
	</tr> </thead>";

	echo $TableHeader;

	$id=1;
	
	while($Contacts=DB_fetch_array($StatementResultscasestage))
	{
     
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
			<td>%s</td>	
			<td>%s</td>	
			</tr>",
			$id++,
			$Contacts['brief_file'],
			$Contacts['courtcaseno'],
			$Contacts['stage'],
			$Contacts['nextcourtdate']);			
			}
	 echo '</table>';
?>
  </div>
    <div id="tabs-5"><!----------------------------------------------------------- Tab - 5-------------------------------------------------->
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
FROM lw_casehistory INNER JOIN lw_casecloseresult ON lw_casehistory.result=lw_casecloseresult.id WHERE lw_casehistory.brief_file='". $brieffile ."' ORDER BY lw_casehistory.caseclosedate ASC";
	
	$StatementResults=DB_query($sql,$db);	
	  echo '<table class="uk-table uk-table-condensed" border=1>';

	$TableHeader = "<thead><tr>
			<th>" . 'Id' . "</th>
			<th>" . 'Case No' . "</th>
			<th>" . 'Result' . "</th>
			<th>" . 'Coram' . "</th>
			<th>" . 'Judgement' . "</th>
			<th>" . 'Close' . "</th>
			<th>" . 'Re-open' . "</th>
			<th>" . 'Remark' . "</th>
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
			$Closehistory['result'],
			$Closehistory['coram'],
			$Closehistory['judgement'],
			$Closehistory['caseclosedate'],
			$Closehistory['casereopendate'],
			$Closehistory['remark']);			
			}
	 echo '</table>';

?>
 </div>
  
    <div id="tabs-6"><!----------------------------------------------------------- Tab - 6-------------------------------------------------->
      <h4 class="heading_c uk-margin-bottom" align="center"><b>Files Attached</b></h4>
             <?php
		$sql = 'SELECT lw_filesattached.id,lw_filesattached.brief_file,
									lw_filesattached.courtcaseno,
									lw_filesattached.file_name
									FROM lw_filesattached WHERE brief_file="' . $Contactsfilesattached['brief_file'] . '"';
							$StatementResultsfilesattach=DB_query($sql,$db);
					
							$TableHeaderresult = "<form method='post' id='deleteuploads' action='' enctype='multipart/form-data'>                              <table class='uk-table uk-table-condensed' border=1 id='myTableData'><tr>
									<th>" . 'ID' . "</th>
									<th>" . 'Brief_File' . "</th>
									<th>" . 'Court Case No' . "</th>
									<th>" . 'File Name' . "</th>
									<th>" . 'Delete File' . "</th>
									</tr>";

									echo $TableHeaderresult;
							
									$i=0;
							
									while($myrowfilesattach=DB_fetch_array($StatementResultsfilesattach))
											{
							
									//$file_name=explode("/",$myrow["file_name"]);
									
									$casenonew=str_replace("/","-",$myrowfilesattach['courtcaseno']);
	
									$folder='lpt_'. $party;			
																	
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
							'<input type="button" class="md-btn md-btn-primary" value="DELETE" onClick="Javascript:deleteRow(this)">');
											}	
							echo '</table></div></div>';
                            ?>
</div>
</div>
</body>
</html>
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
                    
                    
 <!---------------All Other Scripts here ---------------------------------------------------------------------------------->
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
       
     
   