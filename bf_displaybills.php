<?php
include('server_con.php');  
      										
							/*printf("<a style=\"color:#ffffff; font-weight:bold; text-transform:capitalize\" class=\"md-btn md-btn-block md-btn-primary md-btn-wave-light waves-effect waves-button waves-light\" href=\"%s&Billno=%s\" target=\"_blank\">" . 'View Bill in PDF' . "</a>",
									"new_PDFBankfinancebill.php?" . SID,
									$_POST['Billno']);                
                     */					 

        	// Month wise and Bank wise Bills display---------------------//


echo '<div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">';			
echo '<label><b>Displaying Mothwise PDF of Bills Click to Open and View - '.$_POST["Bankcode"]. '</b> </label>';

		$sqlbilldate = 'SELECT * FROM bf_billprinted WHERE bank_id="'.$_POST['Bankid'] .'"';
							$StatementResultsbilldate=mysqli_query($con,$sqlbilldate);
						
						$TableHeaderresult = "<form method='post' id='deleteuploads' action='' enctype='multipart/form-data'>                        					
						     <table class='uk-table' id='myTableData'><tr bgcolor='#82A2C6'>
									<th>" . 'Year' . "</th> 
									<th>" . 'Bill No-Month' . "</th>
									</tr>";

									echo $TableHeaderresult;					
									$flag=1;
							
									while($myrowbills=mysqli_fetch_array($StatementResultsbilldate))
											{																							
								if($flag)
								{								
							    printf("<tr><td>");	
								printf($myrowbills['year'] . '</td>');
								$flag=0;
								}
								
								if($myrowbills['month']=='Jan')
								{							   
								printf("<tr><td>");	
								printf($myrowbills['year'] . '</td>');
								}													
																
					printf("<td><a href='bills/".$_POST['Bankcode'].'/BILL-'.$myrowbills['billno'].'-'.$myrowbills["month"].'-'.$myrowbills["year"].'.pdf' . "' target='_blank'>%s</a></td>",
						'BILL-'.$myrowbills['billno'].'-'.$myrowbills['month']);
								
								}	
							echo '</tr></table></div></div></div></form>';

		?>
              <!-- here table ends --> 