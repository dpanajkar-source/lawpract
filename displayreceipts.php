<?php
include('server_con.php');
 

$brief_file=$_POST['brief_file'];

 if($_SESSION['AccountType']==0)
 {
$sql = 'SELECT lw_partytrans.id,lw_partytrans.transno,lw_partytrans.receivedt,
									lw_partytrans.narration
									FROM lw_partytrans WHERE lw_partytrans.brief_file="'.$brief_file.'" AND lw_partytrans.type=12 AND lw_partytrans.invoiceno IS NULL';
							$StatementResults=mysqli_query($con,$sql);
     
 }else if($_SESSION['AccountType']==1)
 {
     $sql = 'SELECT lw_partytrans.id,lw_partytrans.transno,lw_partytrans.receivedt,
									lw_partytrans.narration
									FROM lw_partytrans WHERE lw_partytrans.brief_file="'.$brief_file.'" AND lw_partytrans.type=12 AND lw_partytrans.invoiceno IS NOT NULL';
							$StatementResults=mysqli_query($con,$sql);         
     
 }
					
							$TableHeader = "<form method='post' id='receipts' action='' enctype='multipart/form-data'>                             <table style='width:1000px' class='uk-table' id='myTableData'><tr bgcolor='#82A2C6'>
									<th>" . 'ID' . "</th>
									<th>" . 'Transaction No' . "</th>
									<th>" . 'Date of Creation' . "</th>
									<th>" . 'Narration' . "</th>
									<th>" . 'Print Preview' . "</th>
									</tr>";

									echo $TableHeader;
							
									$i=0;
							
								/*	while($myrow=DB_fetch_array($StatementResults))
											{
								
									printf("<tr><td>%s</td>
									<td>%s</td>
									<td>%s</td>
									<td>%s</td>
									<td><a href=\"%s&transno=%s\" target=\"_blank\">" . 'Print Receipt' . "</a></td>
									<td>%s</td>
									</tr>",
									$myrow['id'],
									$myrow['transno'],
									$myrow['receivedt'],
									$myrow["narration"],
									"PDFReceipt.php?" . SID,
									$myrow['transno'],
									'<input type="button" class="md-btn md-btn-primary" style="width:170px" value="DELETE" onClick="Javascript:deleteRow(this)">');						  
											}	*/
											
											while($myrow=mysqli_fetch_array($StatementResults))
											{
                                               								
									printf("<tr><td>%s</td>
									<td>%s</td>
									<td>%s</td>
									<td>%s</td>									
									<td><a href=\"%s&transno=%s\" target=\"_blank\">" . 'View PDF' . "</a></td>
									</tr>",									
									$myrow['id'],
                                    $myrow['transno'],
									$myrow['receivedt'],
									$myrow['narration'],
									"new_PDFReceipt.php?" . SID,
									$myrow['transno']);						  
											}	
							echo '</table></form>';
                                                
                                     													
							