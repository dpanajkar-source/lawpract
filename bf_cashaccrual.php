
<?php
 //include('includes/DefineReceiptClass.php');
 include('includes/SQL_CommonFunctions.inc');
 
if (isset($_POST['Submitothertran'])) 
{

$PeriodNo = GetPeriod(Date('d/m/Y'),$db);
$TransNo = GetNextTransNo( 12, $db);
							

if ($_POST['RadioOthercash']==1) 
{
//echo 'reached receipt mode  typeno 12';

	$sqlglcode= "SELECT accountcode,accountname FROM chartmaster where accountname='" . trim($_POST['Suppliernamehidden']) . " Ac'";
		
		$result=DB_query($sqlglcode,$db);
		
		$myrowglcode=DB_fetch_array($result);
		
		if($myrowglcode[0]>0)
		{
			$glmanualcode= $myrowglcode['accountcode'];				
			
         }
		 else
		 {
		 	 		 		
		//fetch last GLcode
		
		$gl=explode('-',$_POST['Group']);
		
		$glcode=$gl[0];
		$glname=$gl[1];
		
		$sqlcontactid = "SELECT id FROM lw_contacts_other WHERE name='" . trim($_POST['Suppliernamehidden']) . "'";
		
		$sqlglcode= "SELECT accountcode FROM chartmaster where group_ = '" . trim($glname) . "' ORDER BY accountcode DESC LIMIT 1";
		
			$result=DB_query($sqlglcode,$db);
		
		$myrowglcode=DB_fetch_array($result);		
			
		$myrowglcode['accountcode']=$myrowglcode['accountcode']+1;//Party GL Code		
		 
		$glmanualcode= $myrowglcode['accountcode'];		 
		  
		  //Below is the code to create GL account code for the Party automatically for the first time
				
			$sql = 'INSERT INTO chartmaster (accountcode,
						accountname,
						group_)
					VALUES ('.$glmanualcode.",
						'".strtoupper(trim($_POST['Suppliernamehidden'])). ' Ac'."',
						'" . $glname . "')";
			$result = DB_query($sql,$db);
			
			//Add the new chart details records for existing periods first

		$sql = 'INSERT INTO chartdetails (accountcode, period)
				SELECT chartmaster.accountcode, periods.periodno
					FROM chartmaster
						CROSS JOIN periods
				WHERE ( chartmaster.accountcode, periods.periodno ) NOT
					IN ( SELECT chartdetails.accountcode, chartdetails.period FROM chartdetails )';

		$result = DB_query($sql,$db);

		//prnMsg('The new general ledger account has been added','success');
		
		 }
		 				
		//first check if $_POST['Caseparty'] value is already there in the lw_contacts table
			
			
		if (!empty($_POST['Supplieridhidden']))
		{
		
		//echo 'reached case party update';
		
			$sql = "UPDATE lw_contacts_other SET
			address='".strtoupper(trim($_POST['Address']))."',
			mobile='".trim($_POST['Mobile'])."',
			email='".trim($_POST['Email'])."'
			WHERE id='".$_POST['Supplieridhidden']."'";
			
	$result = DB_query($sql,$db);
					
		}
		 else
		
		{ 		
		
		$sql = "INSERT INTO lw_contacts_other(
			name,
			address,
			mobile,
			email
			)
			VALUES ('".strtoupper(trim($_POST['Suppliernamehidden']))."',
			'".strtoupper(trim($_POST['Address']))."',
			'".trim($_POST['Mobile'])."',
			'".trim($_POST['Email'])."'
			)";
		
		$result = DB_query($sql,$db);
				
		$sqlcontactid = "SELECT id FROM lw_contacts_other WHERE name='" . trim($_POST['Suppliernamehidden']) . "'";
		$resultcontactid = DB_query($sqlcontactid,$db);
		$myrowcontactid = DB_fetch_row($resultcontactid);
		$Supplierid=$myrowcontactid[0];
		
		$_POST['Supplieridhidden']=$Supplierid;	
				
		}			 
		 
		 
$SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount,
						tag) ';
		$SQL= $SQL . 'VALUES (12,
					' . $TransNo . ",
					'" . FormatDateForSQL($_POST['Otherreceiptdate']) . "',
					'" . $PeriodNo . "',
					'204001',
					'" . $_POST['Narration'] . "',
					'" .  $_POST['OtherAmountreceived'] . "',
					0)";
	
		
		$result = DB_query($SQL,$db);

//Second GLentry is to credit Another GL account with Amount Received


$SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount,
						tag) ';
		$SQL= $SQL . 'VALUES (12,
					' . $TransNo . ",
					'" . FormatDateForSQL($_POST['Otherreceiptdate']) . "',
					" . $PeriodNo . ",
					" . $glmanualcode . ",
					'" . $_POST['Narration'] . "',
					" .  '-' . $_POST['OtherAmountreceived'] . ",
					0)";
		
		$result = DB_query($SQL,$db);
		
		//make an entry in the supptrans table to reflect the above transaction
		
		 $sqlinsertsupptrans = "INSERT INTO supptrans(
							 supplierid,
							 glcode,
							 type,
							 transno,
							 amount,
							 date,
							 narration,
							 currcode				
							)
				VALUES (					
					'" . trim($_POST['Supplieridhidden']) ."',
					'" . trim($glmanualcode) ."',
					12,
					'" . $TransNo . "',				
					'" . trim($_POST['OtherAmountreceived']) . "',
					'" . FormatDateForSQL($_POST['Otherreceiptdate']) . "',
					'" . trim($_POST['Narration']) . "',
					'" . $_SESSION['CompanyRecord']['currencydefault'] . "'				
					)";
 

			$result = DB_query($sqlinsertsupptrans,$db); 
			
			?>
	
   <script>
		
swal({   title: "Cash Inserted!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('bf_economy_alt.php'); //will redirect to your page
}, 2000); 


	</script>
                        
       <?php	
		
}
else if ($_POST['RadioOthercash']==0) 
	{
	
	//echo 'reached Payment mode typeno 13';
	
	$sqlglcode= "SELECT accountcode,accountname FROM chartmaster where accountname='" . trim($_POST['Suppliernamehidden']) . " Ac'";
		
		$result=DB_query($sqlglcode,$db);
		
		$myrowglcode=DB_fetch_array($result);		
		
		if($myrowglcode[0]>0)
		{
			$glmanualcode= $myrowglcode['accountcode'];				
			
         }
		 else
		 {		 
		 		 		
		//fetch last GLcode
		
			
		$gl=explode('-',$_POST['Group']);
		
		$glcode=$gl[0];
		$glname=$gl[1];
		
		$sqlcontactid = "SELECT id FROM lw_contacts_other WHERE name='" . trim($_POST['Suppliernamehidden']) . "'";
		
		$sqlglcode= "SELECT accountcode FROM chartmaster where group_ = '" . trim($glname) . "' ORDER BY accountcode DESC LIMIT 1";
		
		$result=DB_query($sqlglcode,$db);
		
		$myrowglcode=DB_fetch_array($result);		
			
		$myrowglcode['accountcode']=$myrowglcode['accountcode']+1;//Party GL Code		
		 
		$glmanualcode= $myrowglcode['accountcode'];
		 
		  
		  //Below is the code to create GL account code for the Party automatically for the first time
				
			$sql = 'INSERT INTO chartmaster (accountcode,
						accountname,
						group_)
					VALUES ('.$glmanualcode.",
						'".strtoupper(trim($_POST['Suppliernamehidden'])). ' Ac'."',
						'" . $glname . "')";
			$result = DB_query($sql,$db);
			
			//Add the new chart details records for existing periods first

		$ErrMsg = 'Could not add the chart details for the new account';

		$sql = 'INSERT INTO chartdetails (accountcode, period)
				SELECT chartmaster.accountcode, periods.periodno
					FROM chartmaster
						CROSS JOIN periods
				WHERE ( chartmaster.accountcode, periods.periodno ) NOT
					IN ( SELECT chartdetails.accountcode, chartdetails.period FROM chartdetails )';

		$result = DB_query($sql,$db,$ErrMsg);
		
		 }
		 				
		//first check if $_POST['Caseparty'] value is already there in the lw_contacts table
					
		if (!empty($_POST['Supplieridhidden']))
		{
		
		//echo 'reached case party update';
		
			$sql = "UPDATE lw_contacts_other SET
			address='".strtoupper(trim($_POST['Address']))."',
			mobile='".trim($_POST['Mobile'])."',
			email='".trim($_POST['Email'])."'
			WHERE id= '".$_POST['Supplieridhidden']."'";
			
		$result=DB_query($sql,$db);		
				
		}
		 else
		
		{ 		
		
		$sql = "INSERT INTO lw_contacts_other(
			name,
			address,
			mobile,
			email
			)
			VALUES ('".strtoupper(trim($_POST['Suppliernamehidden']))."',
			'".strtoupper(trim($_POST['Address']))."',
			'".trim($_POST['Mobile'])."',
			'".trim($_POST['Email'])."'
			)";
		
		$result = DB_query($sql,$db);
		
		$sqlcontactid = "SELECT id FROM lw_contacts_other WHERE name='" . trim($_POST['Suppliernamehidden']) . "'";
		$resultcontactid = DB_query($sqlcontactid,$db);
		$myrowcontactid = DB_fetch_row($resultcontactid);
		$Supplierid=$myrowcontactid[0];
		
		$_POST['Supplieridhidden']=$Supplierid;	
				
		}			 
		 
		 
$SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount,
						tag) ';
		$SQL= $SQL . 'VALUES (13,
					' . $TransNo . ",
					'" . FormatDateForSQL($_POST['Otherreceiptdate']) . "',
					'" . $PeriodNo . "',
					'204001',
					'" . $_POST['Narration'] . "',
					'" . '-' . $_POST['OtherAmountreceived'] . "',
					0)";
		$ErrMsg = 'Cannot insert a cash entry because';
		$DbgMsg = 'The SQL that failed to insert Cash Entry in the Cash Trans record was';
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);

//Second GLentry is to credit Another GL account with Amount Received


$SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount,
						tag) ';
		$SQL= $SQL . 'VALUES (13,
					' . $TransNo . ",
					'" . FormatDateForSQL($_POST['Otherreceiptdate']) . "',
					" . $PeriodNo . ",
					" . $glmanualcode . ",
					'" . $_POST['Narration'] . "',
					" . $_POST['OtherAmountreceived'] . ",
					0)";
		$ErrMsg = 'Cannot insert a cash entry because';
		$DbgMsg = 'The SQL that failed to insert Cash Entry in the Cash Trans record was';
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);
		
		//make an entry in the supptrans table to reflect the above transaction
		
		 $sqlinsertsupptrans = "INSERT INTO supptrans(
							 supplierid,
							 glcode,
							 type,
							 transno,
							 amount,
							 date,
							 narration,
							 currcode					
							)
				VALUES (					
					'" . trim($_POST['Supplieridhidden']) ."',
					'" . trim($glmanualcode) ."',
					13,
					'" . $TransNo . "',				
					'" . $_POST['OtherAmountreceived'] . "',
					'" . FormatDateForSQL($_POST['Otherreceiptdate']) . "',
					'" . trim($_POST['Narration']) . "',
					'" . $_SESSION['CompanyRecord']['currencydefault'] . "'				
					)";

 
			$ErrMsg = 'This Cash Entry could not be added because';
			$result = DB_query($sqlinsertsupptrans,$db,$ErrMsg); 
				?>
						
						  <script>
		
swal({   title: "Payment Inserted!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('bf_economy_alt.php'); //will redirect to your page
}, 2000); 


	</script>
						
	<?php
						
}
}





//****************Main submit section for receipts  accounting****************


if (isset($_POST['Submitcashreceipt'])) 
{
	/* actions to take once the user has clicked the submit button
	ie the page has called itself with some user input */		
	
	// ---------------------------------------receipt based accounting- amount received from Bank------------
	
	$DateString = Date($_SESSION['DefaultDateFormat']);
	
	$PeriodNo = GetPeriod(Date('d/m/Y'),$db);
	$TransNo = GetNextTransNo( 12, $db);		
				
		if(empty($_POST['Receivedt']))
		{
				
		$_POST['Receivedt']="NULL";
		}
		else
		{
		$_POST['Receivedt']=FormatDateForSQL($_POST['Receivedt']);
		
		}			
				
		$stmt= "INSERT INTO bf_bank_receipts (
					type,
					billno,
					transno,
					bank_id,
					glcode,
					billdate, 
					amount,
					particulars
					)
			VALUES (12,
				'" . trim($_POST['Billno']) . "',
				'" . trim($TransNo) . "',
				'" . trim($_POST['Hiddenbank_code']) . "',
				'" . trim($_POST['Code']) . "',
				'" . trim($_POST['Receivedt']) . "',
				'" . trim($_POST['Amountreceived']) . "',
				'" . trim($_POST['Narration']) . "'
				)";
				
 $result=DB_query($stmt,$db);	
						
				//GLentry is debit Cash- 204001 GL account with Amount Received

$SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount,
						tag) ';
		$SQL= $SQL . 'VALUES (12,
					' . $TransNo . ",
					'" . FormatDateForSQL($DateString) . "',
					'" . $PeriodNo . "',
					 '204001', 
					'" . $_POST['Narration'] . "',
					'" .  $_POST['Amountreceived'] . "',
					0)";
			$ErrMsg = 'Cannot insert a cash entry because';
		$DbgMsg = 'The SQL that failed to insert Cash Entry in the Bank Trans record was';
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);

//Second GLentry is to credit party(bank- like DHFL) GL account with Amount Received

$SQL = 'INSERT INTO gltrans (type,
						typeno,
						trandate,
						periodno,
						account,
						narrative,
						amount,
						tag) ';
		$SQL= $SQL . 'VALUES (12,
					' . $TransNo . ",
					'" . FormatDateForSQL($DateString) . "',
					" . $PeriodNo . ",
					'" . $_POST['Code'] . "',
					'" . $_POST['Narration'] . "',
					" .  '-' . $_POST['Amountreceived'] . ",
					0)";
			$ErrMsg = 'Cannot insert a cash entry because';
		$DbgMsg = 'The SQL that failed to insert Cash Entry in the Bank Trans record was';
		
		$result = DB_query($SQL,$db,$ErrMsg,$DbgMsg,true);				
		 
			?>
<script>
		
swal({   title: "Cash entry Updated!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('bf_economy_alt.php'); //will redirect to your page
}, 2000); 


	</script>
    <?php
		
}

if (!isset($_POST['Submitcashreceipt']))
 {

/*If the page was called without $_POST['Brief_File_No'] passed to page then assume a new Economy Entry is to be entered show a form with a Brief_File No field other wise the form showing the fields with the existing entries against the Economy Entry  will show for editing with only a hidden id field*/
  ?>         
     
 		<div class="uk-grid uk-grid-width-large-1-2 uk-grid-width-medium-1-2 uk-grid-medium hierarchical_show"  data-uk-grid-margin>

                
                <div>
                    <div class="md-card">
                        <div class="md-card-content">    
                        
                        <div style="text-align:center"><h3>Cash Received</h3></div>                                                                
<div class="uk-width-large-10-12 uk-container-center">                             
                      
<div class="uk-grid uk-grid-width-1-2 uk-grid-width-medium-1-2">
                                 
<div class="uk-width-medium-1-1" style="padding-bottom:1px">
   <form method="POST" class="receiptsform" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="text" class="mdinputSearchcash_bf" name="mdinputSearchcash_bf" id="mdinputSearchcash_bf" placeholder="Type Bank Name"></div> 
     				 

 <!--<div class="uk-width-medium-1-3" style="padding-top:10px"><button class="header_main_search_btn uk-button-link"><i class="md-icon material-icons"></i></button></div>-->
 </form></div></div>
                           
	<div class="uk-width-medium-1-1" style="padding-bottom:1px" class="md-input-wrapper">
    
     <form method="POST" class="receipts" action="<?php echo $_SERVER['PHP_SELF']; ?>">
         
	<div class="uk-grid uk-grid-width-1-2 uk-grid-width-medium-1-2" data-uk-grid-margin="5">	
    
    		<input type="hidden" name="Hiddenbank_name" id="Hiddenbank_name" >  
       
			<input type="hidden" name="Hiddenbank_code" id="Hiddenbank_code" >       			                   
		    
			<input type="hidden" name="Bank_name" id="Bank_name" >       
        
                  <?php
				  
				echo '<div class="uk-width-medium-1-2" style="padding-bottom:1px">Bill No
			<input tabindex=2 type="Text" name="Billno" id="Billno" class="md-input">
			</div>'; 
			
			echo '<div class="uk-width-medium-1-2" style="padding-bottom:1px">Balance Amount(Read Only)
			<input tabindex=2 type="number" name="Balance" id="Balance" class="md-input"></div>';
			
			echo '<div class="uk-width-medium-1-2" style="padding-bottom:1px">Bill Total
			<input tabindex=3type="Text" name="Bill_total" id="Bill_total" class="md-input">
			</div>';
            
       echo '<input type="hidden" name="Code" id="Code">';
            
       echo '<div class="uk-width-medium-1-2" style="padding-bottom:1px">Date
			<input class="md-input" type="text" id="Receivedt" name="Receivedt" data-uk-datepicker="{format:\'DD/MM/YYYY\'}" readonly></div>';
            ?>
          <div class="uk-width-medium-1-2" style="padding-bottom:1px">Amount
			<input tabindex=2 type="number" name="Amountreceived" id="Amountreceived" class="md-input">
			</div>
        <?php echo '<div class="uk-width-medium-1-1" style="padding-bottom:1px">Narration
			<input tabindex=2 type="Text" name="Narration" id="Narration" class="md-input">
            </div>'; 
                
          echo '<div><input tabindex="24" type="submit" name="Submitcashreceipt" id="Submitcashreceipt" class="md-btn md-btn-primary" value="Save Transaction" onClick="return checkvaliditycashac()"></div>';
    
?>       

              </form>
</div></div></div></div></div>


<script>
function checkvaliditycashac()
{

if($("#Hiddenbrieffile").val()==0 && $("#Hiddenpartyid").val()==0)
	{

alert("Please Select Brief_File No or Partyname from the search input provided and select a case first!!");

return false;
	}

} 

</script>
            
<div>
<div class="md-card">
<div class="md-card-content">
 <form method="POST" class="Otherreceiptsform" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<div style="text-align:center"><h3>Cash Receipts/Payments for Suppliers</h3></div>  
	
	<div class="uk-width-medium-1-1" style="padding-bottom:1px" class="md-input-wrapper">   
     
	<div class="uk-grid uk-grid-width-1-2 uk-grid-width-medium-1-2" data-uk-grid-margin="5">	
    
       <?php
         echo '<div class="uk-width-medium-1-1" style="padding-bottom:1px">';

echo '<input type="text" name="Supplierid" id="Supplierid" class="Supplierid" placeholder="Type to search Contact(Vendor,Supplier) ..." tabindex="13">';
echo '<input type="hidden" name="Supplieridhidden" id="Supplieridhidden">';

echo '<input type="hidden" name="Suppliernamehidden" id="Suppliernamehidden">';
 
echo '</div>';
?>
<div class="uk-width-medium-1-1" style="padding-bottom:1px; padding-top:1px">
	  <label>
	    <input  type="radio" name="RadioOthercash" id="RadioOthercash_0" value="1" checked="checked" />
	    Receipt</label>
	  <label>
	    <input type="radio" name="RadioOthercash"  id="RadioOthercash_1" value="0"/>
	    Payment</label>
  </div>
<?php

echo '<div class="uk-width-medium-1-1" style="padding-bottom:1px; padding-top:1px">Account Group<select name="Group" id="Group" class="md-input">';

	$sql = 'SELECT groupname,sequenceintb FROM accountgroups ORDER BY sequenceintb';
	$result = DB_query($sql, $db);

	while ($myrow = DB_fetch_array($result)){
		if (isset($_POST['Group']) and $myrow[0]==$_POST['Group']){
			echo "<option selected VALUE='";
		} else {
			echo "<option VALUE='";
		}
		echo $myrow[1] . '-' . $myrow[0] . "'>" . $myrow[1] . ' - ' . $myrow[0];
	}
	
	echo '</select></div>';
 
echo '<div class="uk-width-medium-1-2" style="padding-bottom:1px">Address';
echo '<input type="Text" class="md-input" name="Address" id="Address" tabindex="16"></div>'; 
		 
echo '<div class="uk-width-medium-1-2" style="padding-bottom:1px">Mobile'; 
echo '<input class="md-input" tabindex="19" type="Text" name="Mobile" id="Mobile">'; 
echo '</div>';  
echo '<div class="uk-width-medium-1-2" style="padding-bottom:1px">Email'; 
echo '<input class="md-input" tabindex="19" type="email" name="Email" id="Email">'; 
echo '</div>';  
		 
?>
  <input type="hidden" name="GLManualCode" id="GLManualCode"s>
	  
  <input type="hidden" name="GLName" id="GLName">
			
			<div class="uk-width-medium-1-2" style="padding-bottom:1px">
           
		Date<input class="md-input" type="text" name="Otherreceiptdate" id="Otherreceiptdate" data-uk-datepicker="{format:'DD/MM/YYYY'}" ></div>
			
			<div class="uk-width-medium-1-2" style="padding-bottom:1px">Amount
			<input tabindex=2 type="number" name="OtherAmountreceived" id="OtherAmountreceived" class="md-input">
			</div>	
            <div class="uk-width-medium-1-2" style="padding-bottom:1px">Narration
			<input tabindex=2 type="Text" name="Narration" id="Narration" class="md-input"></div>  
              
           <div><input tabindex="24" type="submit" name="Submitothertran" id="Submitothertran" class="md-btn md-btn-primary" value="Save Transaction"></div>
           
   </div></div></div></div>
</form>
            
             <!--<div name="myform" id="myform" style="float:right; margin-top:120px; margin-right:50px">
                   
                   
                       </div>-->
   
</div>

<?php	
	}    
   ?>  


		  	 <!-- Search Form Demo -->

<!-- Placed at the end of the document so the pages load faster -->
<script src="jquery-1.11.1.min.js"></script>

<script src="assets/js/common.js"></script> 

<!-- Live Search Script -->
<script type="text/javascript" src="ajaxlivesearch.js"></script>

   <script>				
	
	//below is for main search for the economy form
	jQuery(".mdinputSearchcash_bf").ajaxlivesearch({
        loaded_at: <?php echo $time; ?>,
        token: <?php echo "'" . $token . "'"; ?>,
        max_input: <?php echo $maxInputLength; ?>,
        onResultClick: function(e, data) {
            // get the index 1 (second column) value
             var selectedbankcode = jQuery(data.selected).find('td').eq('0').text();
			
			var selectedbankname = jQuery(data.selected).find('td').eq('1').text();
			var billno = jQuery(data.selected).find('td').eq('2').text();
			var billtotal = jQuery(data.selected).find('td').eq('3').text();
			
			var balance = jQuery(data.selected).find('td').eq('4').text();
			
			var glcode = jQuery(data.selected).find('td').eq('5').text();
			
			var selectedcontactperson = jQuery(data.selected).find('td').eq('6').text();

            // set the input value
           jQuery('.mdinputSearchcash_bf').val(selectedbankname);
			
			 jQuery('#Hiddenbank_name').val(selectedbankname);
			 jQuery('#Bank_name').val(selectedbankname);			 
			  jQuery('#Hiddenbank_code').val(selectedbankcode);	
			  
			   jQuery('#Billno').val(billno);	
			   jQuery('#Balance').val(billtotal-balance);
			   jQuery('#Bill_total').val(billtotal);			   
			   
			   jQuery('#Code').val(glcode);	   
			   	
			/*		
			$.ajax({
				url: 'bf_client_cash.php', // Url to which the request is send
				type: "POST",             // Type of request to be send, called as method
				dataType: "json",
				//data: new FormData(this),// Data sent to server, a set of key/value pairs (i.e. form fields and values	
				data: {
							//'Client': JSON.stringify(Client),
							'bank_name': $("#Hiddenbank_name").val()			
					  },
				
				success: function(result)   // A function to be called if request succeeds
				{
				 
				// $("#Code").val(result[2]);
				 				
				}
				
				});*/
				
									
			// hide the result
           jQuery(".mdinputSearchcash_bf").trigger('ajaxlivesearch:hide_result');
        },
        onResultEnter: function(e, data) {
            // do whatever you want
            //jQuery(".mySearch").trigger('ajaxlivesearch:search', {query: 'test'});
        },
        onAjaxComplete: function(e, data) {

        }
    });
	
	
	jQuery(".Supplierid").ajaxlivesearch({
        loaded_at: <?php echo $time; ?>,
        token: <?php echo "'" . $token . "'"; ?>,
        max_input: <?php echo $maxInputLength; ?>,
        onResultClick: function(e, data) {
            // get the index 0 (first column) value ie id
            var selectedZero = jQuery(data.selected).find('td').eq('0').text();
			
			// get the index 0 (first column) value ie name
            var selectedone = jQuery(data.selected).find('td').eq('1').text();


            // set the input value
           jQuery('#Supplierid').val(selectedone);
			
			
           // set the partyname hidden value
            jQuery('#Supplieridhidden').val(selectedZero);
			
			jQuery('#Suppliernamehidden').val(selectedone);
			
			 // get the index 1 (second column) value for address
            var selectedtwo = jQuery(data.selected).find('td').eq('2').text();

            // set the input value
            jQuery('#Address').val(selectedtwo);
			
			 // get the index 1 (second column) value for mobile
            var selectedthree = jQuery(data.selected).find('td').eq('3').text();

            // set the input value
            jQuery('#Mobile').val(selectedthree);
			
			jQuery('#Email').val(jQuery(data.selected).find('td').eq('4').text());
			
				
			$.ajax({
				url: 'client_select.php', // Url to which the request is send
				type: "POST",             // Type of request to be send, called as method
				dataType: "json",
				//data: new FormData(this),// Data sent to server, a set of key/value pairs (i.e. form fields and values	
				data: {
							//'Client': JSON.stringify(Client),
							
							'id': $("#Supplieridhidden").val()		
									
					  },
				
				success: function(result)   // A function to be called if request succeeds
				{
				$("#GLManualCode").val(result[0]);
				$("#GLName").val(result[1]);
				
				}
				
				});
						
			// hide the result
            jQuery("#Supplierid").trigger('ajaxlivesearch:hide_result');
        },
        onResultEnter: function(e, data) {
            // do whatever you want
            //jQuery(".mySearch").trigger('ajaxlivesearch:search', {query: 'test'});
        },
        onAjaxComplete: function(e, data) {

        }
    });
	
			$("#mdinputSearch").blur( function() {
						
				if($("#mdinputSearch").val()=="")
				{
				$("#Hiddenbrieffile").val("");
				}  
			});
			
$("#Supplierid").blur(function() {
$("#Supplieridhidden").val('');
$("#Suppliernamehidden").val('');
$("#Address").val('');
$("#Mobile").val('');
$("#Email").val('');

$("#Suppliernamehidden").val($("#Supplierid").val());

});


</script>    	  

