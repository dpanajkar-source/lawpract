<?php
$PageSecurity = 5;
include('includes/session.php');

$brief_file=$_POST['brief_file'];

 if($_SESSION['AccountType']==1)
 {
     $sql = 'SELECT lw_partyeconomy.id,lw_partyeconomy.invoiceno,lw_partyeconomy.t_date
			FROM lw_partyeconomy WHERE lw_partyeconomy.brief_file="'.$brief_file.'" AND lw_partyeconomy.invoiceno IS NOT NULL';
							$StatementResults=DB_query($sql,$db);         
     
 }
					
							$TableHeader = "<form method='post' id='receipts' action='' enctype='multipart/form-data'>                             <table style='width:1000px' class='uk-table' id='myTableData'><tr bgcolor='#82A2C6'>
									<th>" . 'ID' . "</th>
									<th>" . 'Invoice No' . "</th>
									<th>" . 'Date of Creation' . "</th>
									<th>" . 'Print Preview' . "</th>
									</tr>";

									echo $TableHeader;
									while($myrow=DB_fetch_array($StatementResults))
											{
                                               								
									printf("<tr><td>%s</td>
									<td>%s</td>
									<td>%s</td>
									<td><a href=\"%s&Invoiceno=%s\" target=\"_blank\">" . 'View PDF New' . "</a></td>
									</tr>",
									$myrow['id'],
									$myrow['invoiceno'],
									$myrow['t_date'],
									"new_PDFInvoice.php?" . SID,
									$myrow['invoiceno']);						  
											}	
							echo '</table></form>';
                                                
                                     													
							