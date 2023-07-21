    
 <?php
 
 
if (isset($Errors)) 
{
	unset($Errors);
}
$Errors = array();

/*brief_file could be set from a post or a get when passed as a parameter to this page */

if (isset($_POST['Searchhidden'])){
	$_SESSION['Searchhidden'] = trim($_POST['Searchhidden']);
	
	$brief_file= trim($_POST['Searchhidden']);
	
	
	
} elseif (isset($_GET['Searchhidden'])){
	$_SESSION['Searchhidden'] = trim($_GET['Searchhidden']);
	
	$brief_file= trim($_GET['Searchhidden']);
}

if (isset($_POST['Submit'])) 
{
		 //insert mode for new invoice starts
		 
		
 	 //for accrual based accounting below is the code
				
		
	$DateString = Date($_SESSION['DefaultDateFormat']);
	
	$PeriodNo = GetPeriod(Date('d/m/Y'),$db);	
		
	$TransType=10;	
		
	$SQL = 'UPDATE systypes SET typeno = ' . ($_POST['Invoiceno']) . ' WHERE typeid = ' . $TransType;
	
	$UpdTransNoResult = DB_query($SQL,$db);
         			
		if(empty($_POST['Invoicedt']))
		{
				
		$_POST['Invoicedt']="NULL";
		}
		else
		{
		$_POST['Invoicedt']=FormatDateForSQL($_POST['Invoicedt']);
		
		}

			 		
		//fetch Client GLcode if already there
		
		$sqlglcode= 'SELECT accountcode,accountname FROM chartmaster where accountname="' . trim($_POST['Casepartyname']) . ' AR Debtor-Ac" ORDER BY accountcode DESC LIMIT 1';
	
		$result=DB_query($sqlglcode,$db);
		
		$myrowglcode=DB_fetch_array($result);
		
		if($myrowglcode>0)
		{
		$glcode=$myrowglcode[0];
		
		}else
		{
$sqlglcode= "SELECT accountcode,accountname FROM chartmaster where accountname LIKE '% AR Debtor-Ac' ORDER BY accountcode DESC LIMIT 1";
		$result=DB_query($sqlglcode,$db);
		
		$myrowglcode=DB_fetch_array($result);
		
		$myrowglcode['accountcode']=$myrowglcode['accountcode']+1;//Party GL Code
		 
		  $glcode= $myrowglcode['accountcode'];
		  
		  //Below is the code to create GL account code for the Party automatically for the first time
				
			$sql = 'INSERT INTO chartmaster (accountcode,
						accountname,
						group_)
					VALUES (' . $glcode . ",
						'".trim($_POST['Casepartyname']). ' AR Debtor-Ac'."',
						'Accounts Receivable')";
		   $result = DB_query($sql,$db);
			
			//Add the new chart details records for existing periods first

		$ErrMsg = _('Could not add the chart details for the new account');

		$sql = 'INSERT INTO chartdetails (accountcode, period)
				SELECT chartmaster.accountcode, periods.periodno
					FROM chartmaster
						CROSS JOIN periods
				WHERE ( chartmaster.accountcode, periods.periodno ) NOT
					IN ( SELECT chartdetails.accountcode, chartdetails.period FROM chartdetails )';

		$result = DB_query($sql,$db,$ErrMsg);

		}	       //end of else 
          	
			//below is for inserting data in lw_economy table only once in the beginning when party decides the total fee payment		
			 $sql = "INSERT INTO lw_partyeconomy(
                            type,
                            invoiceno,
							brief_file,
							party,
							courtcaseno,
							glcode,
							totalfees,
							balance,
							t_date,
							currcode,
							narration							
							)
				VALUES (10,
				    '". $_POST['Invoiceno'] ."',              
                    '".trim($_POST['Brief_File'])."',
					'".trim($_POST['Casepartyid'])."',
					'".$_POST['Courtcaseno']."',
					'".$glcode."',
					'".trim($_POST['Total'])."',
					'".trim($_POST['Total'])."',
					'".trim($_POST['Invoicedt'])."',
					'".$_SESSION['CompanyRecord']['currencydefault']."',
					'".trim($_POST['Narration'])."'					
					)";
					
     		$ErrMsg = _('This Invoice Entry could not be added because');
			$result = DB_query($sql,$db,$ErrMsg);
				
				
			//GLentry is debit Cash GL account with total fees for once. check if condition for accrual based accounting
//debit client ar ac
$SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount,
						posted,
						tag) ';
		$SQL= $SQL . 'VALUES (10,
					'.$_POST['Invoiceno'].",
					'".FormatDateForSQL($DateString)."',
					'".$PeriodNo."',
					'220001',
					'".$_POST['Narration']."',
					'".trim($_POST['Total'])."',
					0,
					0)";
		$ErrMsg = _('Cannot insert a GL entry for the journal line because');
		$DbgMsg = _('The SQL that failed to insert the GL Trans record was');
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);

//Second GLentry is to credit professional fees GL account with Total fees

$SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount,
						posted,
						tag) ';
		$SQL= $SQL . 'VALUES (10,
					'.$_POST['Invoiceno'].",
					'".FormatDateForSQL($DateString)."',
					".$PeriodNo.",
					'400011',
					'".$_POST['Narration']."',
					" .  '-' . $_POST['Total'] . ",
					0,
					0)";
		$ErrMsg = _('Cannot insert a GL entry for the journal line because');
		$DbgMsg = _('The SQL that failed to insert the GL Trans record was');
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);       			
	
		?>
		
<script>

swal({   title: "Invoice Created!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('lw_invoice_alt.php'); //will redirect to your page
}, 2000);
</script>
    <?php	
			
}//end of accrual based accounting



if(isset($_POST['DeletePermanent']))
				
			{
    
  
			 $sql="DELETE FROM lw_cases WHERE brief_file='".$_POST['Brief_Filebeforechange']."'";
		    $result = DB_query($sql,$db);	
    
           		  
    
    		?>
	
  <script> 

		
swal({   title: "Invoice and records associated with the case are permanently deleted!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('lw_invoice_alt.php'); //will redirect to your page
}, 2000); 

	</script>
                        
       <?php

			}//end if Delete case and (isset($_POST['delete'])) condition
			//	$Invoiceno = GetNextTransNo(10, $db);	
	
if (empty($myrowparty))
 {
 
 $result=DB_query("SELECT typeno FROM systypes WHERE typeid='10'",$db);
 
 $myrowinvno=DB_fetch_array($result);
 
 	$Invoiceno =  $myrowinvno[0]+1;	
	
	$TransType=10;
	
	
	

?>
<form method='POST' name='invoiceform' action="<?php echo $_SERVER['PHP_SELF']  . '?' . SID ; ?>">
<?php


/*If the page was called without $_POST['Brief_File'] passed to page then assume a new case is to be entered show a form with a Case Code field other wise the form showing the fields with the existing entries against the case will show for editing with only a hidden brief_file field*/

	echo "<input type='Hidden' name='New' value='Yes'>";
	
	$DateString = Date($_SESSION['DefaultDateFormat']);

	$DataError =0; 	
	
    ?>  
    
	<div class="md-input-wrapper">
        
        <div class="uk-width-medium-1-1" style="padding-left:60px; padding-right:60px">
        <div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">
        <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-2-2">
        <div class="uk-form-row">
        <div class="uk-grid">
    
    
               <?php
	
		echo '<div class="uk-width-medium-2-4" style="padding-bottom:1px"><label>Bill To</label>';

echo '<input type="text" name="Casepartyname" id="Casepartyname" class="Casepartyname" readonly data-uk-tooltip="{cls:\'long-text\'}" title="Cannot Edit. Just select a brief_file from above search to create invoice for..">';
 echo '<input type="hidden" name="Casepartyid" id="Casepartyid">';
 echo '<input type="hidden" name="Casepartynamehidden" id="Casepartynamehidden">';

echo '<label>Opposition Name:*</label>';
echo '<input type="text" class="Caseoppopartyname" name="Caseoppopartyname" id="Caseoppopartyname"readonly data-uk-tooltip="{cls:\'long-text\'}" title="Cannot Edit. Just select a brief_file from above search to create invoice for.." />';
echo '<input type="hidden" name="Caseoppopartyid" id="Caseoppopartyid">';
echo '<input type="hidden"  name="Caseoppopartynamehidden" id="Caseoppopartynamehidden">';
echo '</div>'; ?> 
       <div class="uk-width-medium-1-4" style="padding-bottom:10px">
        </div> 
        <div class="uk-width-medium-1-4" style="padding-bottom:10px; float:right"><label>Invoice No</label>
        <input class="md-input" type="text" name="Invoiceno" id="Invoiceno" value="<?php echo $Invoiceno; ?>" tabindex="5">
        <label>Invoice Date*</label>
        <input class="md-input" type="text" name="Invoicedt" id="Invoicedt" tabindex="5" data-uk-datepicker="{format:'DD/MM/YYYY'}">
        </div> 


        <div class="uk-width-medium-1-4" style="padding-bottom:10px"><label>Brief_File No*</label>
        <input tabindex="1" type="Text" name="Brief_File"  id="Brief_File" class="md-input" readonly data-uk-tooltip="{cls:'long-text'}" title="Cannot Edit. Just select a brief_file from above search to create invoice for..">
        </div>
            
        <div class="uk-width-medium-1-4" style="padding-bottom:0px"><label>Case No/Document No*</label> 
        <input tabindex="3" type="Text" name="Courtcaseno" id="Courtcaseno" class="md-input" readonly data-uk-tooltip="{cls:'long-text'}" title="Cannot Edit. Just select a brief_file from above search to create invoice for..">
        </div>
	    
          <div class="uk-width-medium-1-2" style="padding-bottom:10px"><label>Narration</label> 
        <input tabindex="3" type="Text" name="Narration" id="Narration" class="md-input" data-uk-tooltip="{cls:'long-text'}" title="Enter any narration here. This will appear in all accounts related sections including reports">
        </div> 
          
      <?php 

		 

?>  
   
	  
	
		</div></div></div></div>
        
      
		
           			 </div>      
                </div>
            </div>
            
            </div><!-- end of md-input-wrapper -->
         
        
        <!-- //New md-card for party and oppo party-->
                <div class="md-input-wrapper">
                <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-medium-1-1" style="padding-top:0px; float:right; margin-left:10px">
                <div class="uk-width-medium-1-1" style="padding-left:60px; padding-right:60px">
                <div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">
                <div class="uk-width-medium-2-2">
                
                <!-- <img src="addclient.png"> -->                 
                 <div name="myform" id="myform">
				
				<?php  echo '<input type="hidden" name="Casepartynamehidden" id="Casepartynamehidden">'; ?>
                <table id="myTableData" class="uk-table" style="width:500px; border-color:#CCCCCC;" border="1" cellspacing="0">
                <tr>
                <td><input class="md-input"  type="text" name="Addservices" id="Addservices" placeholder="ADD NEW SERVICE"></td>
                <td><input class="md-input" type="number" name="Addfees" id="Addfees" placeholder="ADD FEES"></td>
                <td>
                <input class="md-btn md-btn-primary" style="width:170px" name="add" id="add" tabindex="21" type="button"  value="Add" onclick="javascript: return addRow()">
        
                        </td> 
                         <tr>                       
                        <td width="370"><b>Service Name</b></td>
                        <td width="370"><b>Fees</b></td>
                         <td width="80"><b>Action</b></td>
                       </tr>
                       </table>
                                         
                       &nbsp;<br />
                       </div>
                        <div class="uk-grid" data-uk-grid-margin>
               
        
<div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">
<div class="uk-width-medium-1-2" style="padding-bottom:50px"><label><b>TOTAL</b></label>
<input tabindex="1" type="Text" name="Total"  id="Total" class="md-input" value=0>
</div>
<div class="uk-width-medium-1-2"> 
<input tabindex='24' type='submit' name='Submit' id='Submit' class='md-btn md-btn-primary' value='Save Invoice' onClick='return checkvalidity()'></div></div></div></div> </form><br />

<script>
function caltotal()
{
	
	//alert(document.getElementById("Addfees").value);
 var table=document.getElementById("myTableData");
					 
					 var rowCount=document.getElementById("myTableData").rows.length;
					 
					  var tot=document.getElementById("Total");
					 let subtotal = parseInt(tot.value);
					 			 
					 var fees = [];
					 var totalfees ='';
					 fees.push(document.getElementById("Addfees").value);
					 				 
					 var j=0;
					 for(var x=0; x<rowCount; x++)
					 	{    
					     totalfees=subtotal + parseInt(fees[0]);                   
					 	}		
						tot.value=totalfees;		

}

function deltotal()
{
	
 var table=document.getElementById("myTableData");
 var input = document.getElementsByName('Addfees[]');
  var tot=document.getElementById("Total");
 var k = "";
    
            for (var i = 0; i < input.length; i++) {
                var a = input[i];
                k = k + a.value;
            }
 
 alert(k);
 tot.value=k;		
		}


</script>
                       
                         <div name="invoicedisplay" id="invoicedisplay">
                         
                         </div>
                       
                    <!--   <div id="myDynamicTable">
                       <input type="button" id="create" value="Click here" onclick="javascript:addTable()"  />
                       to create a Table and add some data using javascript
                       </div>-->
                                                                  
                       </div>
                       
                   </div>
                </div>  
                </div>             
	


</div>


</div></div></div>
               
               
                     <script>					
									
                    function addRow() {
					 var service=document.getElementById("Addservices");
					 var fees=document.getElementById("Addfees");
					 var table=document.getElementById("myTableData");
					 var rowCount=table.rows.length;
					 var row=table.insertRow(rowCount);				
				
															 
					/*   var jsarray= ["dinesh","anand","ram","rupesh","Raghu"];
										
					 myName.value=jsarray;	*/			 
			
										
					/*row.insertCell(0).innerHTML='<input type="button" value="DELETE" onClick="Javascript:deleteRow(this)">';
	row.insertCell(1).innerHTML="<input type='text' name='Addname[]' id='Addname'" + counter + "' value='" + myName.value + "'>";*/
	
	
	if($("#Addservice").val()==0 | $("#Addfees").val()==0)
  {
  alert("Please Enter Service and fees!!");
  
  return false;
  } else{
  	
	//row.insertCell(0).innerHTML="<input type='text' name='Services[]' id='Services' value='" + service.value + "'>";
	row.insertCell(0).innerHTML=service.value;
	row.insertCell(1).innerHTML= fees.value;
	/*row.insertCell(0).innerHTML="<input type='text' readonly class='md-input' name='Addservice[]' id='Addservice' value='" + service.value + "'>";
	row.insertCell(1).innerHTML="<input type='text' readonly class='md-input' name='Addfee[]' id='Addfee' value='" + fees.value + "' >";*/
	row.insertCell(2).innerHTML='<input type="button" class="md-btn md-btn-primary" style="width:170px" value="DELETE" onClick="Javascript:deleteRow(this)">';
	 caltotal();
	 
	fees.value=null;	
										
	 service.value=null;	
	 
	}		
	
			}
					
					
					function deleteRow(obj) {
					
					var index=obj.parentNode.parentNode.rowIndex;
					var table=document.getElementById("myTableData");
					table.deleteRow(index);	
					
					deltotal();
										
					
					}			
					
						
					</script>
                    
                </div>
                <div class="uk-margin-medium-bottom"></div>
    </div>
    </div>

                
<?php    	

} //end of insert mode

?>

