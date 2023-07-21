
<div class="uk-width-medium-1-1" style="padding-bottom:0px; padding-left:10px; padding-right:10px">
<div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">
<form method='POST' name='caseform' action="<?php echo $_SERVER['PHP_SELF']  . '?' . SID ; ?>">
<div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-2-2">
        <div class="uk-form-row">
        <div class="uk-grid">

<div class="uk-width-medium-1-4" style="padding-bottom:10px">
Search By Date
<input type="text" data-uk-datepicker="{format:'YYYY-MM-DD'}" name="srchdate" id="srchdate" class="md-input"/></div>
<div class="uk-width-medium-1-4" style="padding-bottom:10px"></div> 
           
<div class="uk-width-medium-2-4" style="padding-bottom:10px">
Filter (Use Bill no, Customer name)
<input type="text" id="filter" name="filter" class="md-input" tabindex="1" />

</div>
 </div>
  <?php          
  
echo ' <div class="uk-grid uk-grid-medium data-uk-grid-margin">
                <div class="uk-width-medium-2-2 uk-width-medium-2-2">
                <div class="md-card">
                <div  class="md-card-content">';                     
                     
	
echo '<div class="uk-form-row">
       <div >
	   <div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">';
	                        
 echo '<div class="uk-width-medium-3-5" style="padding-bottom:10px">       
      <input type="text" name="Cust_name" id="Cust_name" class="md-input" placeholder="Type to Search (Customer Name)" tabindex="1"></div>';
		   
  			//select bill no automatically after 25 rows
			$sqlbillno='SELECT billno from bf_ind_receipts ORDER BY id DESC LIMIT 1';
			
			$resultbillno=DB_query($sqlbillno,$db); 
			
			$myrowbillno=DB_fetch_array($resultbillno);			
						
			if($myrowbillno=='')
			{
			$myrowbillno['billno']=1;
			}else
			{
			$myrowbillno['billno']=$myrowbillno['billno']+1;
			}			

			   
			   echo '<div class="uk-width-medium-1-5" style="padding-bottom:10px">Select Bill No';
			   echo '<select name="B_no" id="B_no" class="md-input">';			   
			   if ($myrowbillno['billno']){
			echo '<option selected VALUE='. $myrowbillno['billno'] . '>' . $myrowbillno['billno'];
				}
			   echo '</select></div>';
				
			/*echo '<div class="uk-width-medium-1-5" style="padding-bottom:10px; padding-top:7px">Current Bill No
			   <input class="md-input" type="text" name="Bill_no" id="Bill_no" value="'.$myrowbillno['billno'].'" readonly></div>';*/
					   			
			echo '<input  type="hidden" name="Cust_id" id="Cust_id">';
			
			echo '<input  type="hidden" name="Cust_namehidden" id="Cust_namehidden">';
			
			echo '<input type="hidden" name="UserID" id="UserID" value="' . $_SESSION['UserID'] . '">'; 
						
              ?>
      <div class="uk-width-medium-1-5" style="padding-bottom:10px">
      Bill Date:
      <input class="md-input" data-uk-datepicker="{format:'DD/MM/YYYY'}" name="Billdate" id="Billdate" tabindex="3" value="<?php echo date("d/m/Y"); ?>">
     </div> 
 
            
   <?php           		  
			   
			   echo '<div class="uk-width-medium-2-5" style="padding-bottom:10px">Particulars
			   <input class="md-input" type="text" name="Particulars" id="Particulars" placeholder="Type Particulars for each Receipt"></div>';
			   
			   
			   	  
$SQL = 'SELECT bankaccountname,
			bankaccounts.accountcode,
			bankaccounts.currcode
		FROM bankaccounts,
			chartmaster
		WHERE bankaccounts.accountcode=chartmaster.accountcode';

$ErrMsg = 'The bank accounts could not be retrieved because';
$DbgMsg = 'The SQL used to retrieve the bank accounts was';
$AccountsResults = DB_query($SQL,$db,$ErrMsg,$DbgMsg);

			  
	 echo '<div class="uk-width-medium-1-5" style="padding-bottom:10px">Our Bank Account<select tabindex=1 name="BankAccount" onChange="ReloadForm(form1.BatchInput)" class="md-input">';

	while ($myrow=DB_fetch_array($AccountsResults)){
		
		echo '<option value="' . $myrow['accountcode'] . '">' . $myrow['bankaccountname']. ' - ' . $myrow['currcode'] . '</option>';
		}
	
	echo '</select></div>';
   
        
echo '<div class="uk-width-medium-1-5" style="padding-bottom:10px">Client\'s Bank (NEFT/RTGS)
			<input tabindex=2 type="Text" name="Custbankname" id="Custbankname" class="md-input">
           </div>';
echo '<div class="uk-width-medium-1-5" style="padding-bottom:10px">Cheque/NEFT/RTGS No
			<input tabindex=2 type="number" name="Chequeno" id="Chequeno" class="md-input"></div>';		  		  
			   
			 	echo '<div class="uk-width-medium-1-5" style="padding-bottom:10px">Amount Received
			   <input class="md-input" type="number" name="Amount" id="Amount"></div>';	
			   
			    echo '<div class="uk-width-medium-1-5" style="padding-bottom:10px">Total Fees Charged
			   <input class="md-input" type="text" name="Totalfees" id="Totalfees"></div>';
				 echo '<div class="uk-width-medium-1-5" style="padding-bottom:10px">Balance
			   <input class="md-input" type="text" name="Balance" id="Balance" readonly></div>';  
			   
			
           echo '<div class="uk-width-medium-1-5 row tright" style="padding-bottom:10px">
              <a id="addbutton" class="md-btn md-btn-primary" ><i class="fa fa-save"></i> Enter Receipt</a>  </div>';
			  
		
			  
           ?>   
        </div></div></div> </div></div>
           
                   
 </form>
 
        
<!-- Feedback message zone -->
<div id="message">


</div>
</div>

</div>
</div>                  

  </div>

</div>
</div>            
    
              
			<!-- Grid contents -->
			<div class="uk-overflow-container" style="padding-top:20px; margin-left:10px" id="tablecontent"></div>
                       		
			<!-- Paginator control -->
			<div  id="paginator"></div>
		</div>  
	 
		
        <!-- EditableGrid test if jQuery UI is present. If present, a datepicker is automatically used for date type -->
  
<script type="text/javascript">
		
            var datagrid = new DatabaseGrid();
			window.onload = function() {   
	
	 $("#Cust_name").change(function() {
		$("#Cust_id").val('');
		
		$("#Cust_namehidden").val($("#Cust_name").val());
		
		});
		
	 
			         // key typed in the filter field
                $("#srchdate").change(function() {
                    datagrid.editableGrid.filter( $(this).val(), [2]);
					
					datagrid.editableGrid.clearFilter(); 

                    // To filter on some columns, you can set an array of column index 
                    //datagrid.editableGrid.filter1( $(this).val(), [0,3,5]);
                  });
				  
				  
				  // key typed in the filter field for specific page diary filter 
              $("#filter").keyup(function() {
				
                    datagrid.editableGrid.filter( $(this).val());

                    // To filter on some columns, you can set an array of column index 	
					
				//datagrid.editableGrid.filter($(this).val());
				datagrid.editableGrid.clearFilter(); 			
				
					
                  });
			  
				$("#addbutton").click(function() {
                  datagrid.addRow();
                });
				  
           	 datagrid.editableGrid.clearFilter();   
   
                      
			}; 
		</script>
        

<!-- Placed at the end of the document so the pages load faster -->

<script src="assets/js/common.js"></script> 

<!-- Live Search Script -->
<script type="text/javascript" src="ajaxlivesearch.js"></script>


<script>


	
$("#B_no").focus(function(e) { 		
			 
	 $.ajax({
			url: 'bf_ind_billnoload.php',
			type: 'POST',
			dataType: "html",
			data: {
			custid: $("#Cust_id").val()
		},
		
		 success: function (output) 
			{ 		
			           
				$("#B_no").html(output);   
				      
			},
			error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + errortext); },
			async: false
		});


});

$("#B_no").change(function(e) { 

			 
	 $.ajax({
			url: 'bf_ind_totalfeesload.php',
			type: 'POST',
			dataType: "html",
			data: {
			B_no: $("#B_no").val()
		},
		
		 success: function (output) 
			{ 
			var record_day1=JSON.stringify(output);			
			 
			var record_day1=output.split(",");
			
			var x=record_day1[0].replace("[","");
			x=x.replace("\"","");
			x=x.replace("\"","");
					
			var y=record_day1[1].replace("]","");
			y=y.replace("\"","");
			y=y.replace("\"","");
					
			 $("#Totalfees").val(x); 						 					
			 $("#Balance").val(y);  	  
				      
			},
			error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + errortext); },
			async: false
		});


});

  

	//below is for fetching customer names from lw_contacts
	jQuery("#Cust_name").ajaxlivesearch({
        loaded_at: <?php echo $time; ?>,
        token: <?php echo "'" . $token . "'"; ?>,
        max_input: <?php echo $maxInputLength; ?>,
        onResultClick: function(e, data) {
            // get the index 1 (second column) value
			
            var cust_id = jQuery(data.selected).find('td').eq('0').text();
			
			var cust_name = jQuery(data.selected).find('td').eq('1').text();
			
            // set the input value
			           						
			jQuery('#Cust_id').val(cust_id);  	
			
			jQuery('#Cust_name').val(cust_name);  
			
			jQuery('#Cust_namehidden').val(cust_name);  		
			
				$.ajax({
				url: 'bf_client_cash.php', // Url to which the request is send
				type: "POST",             // Type of request to be send, called as method
				dataType: "json",
				//data: new FormData(this),// Data sent to server, a set of key/value pairs (i.e. form fields and values	
				data: {
							//'Client': JSON.stringify(Client),
							'bill_no': $("#Bill_no").val()			
					  },
				
				success: function(result)   // A function to be called if request succeeds
				{		
				  $("#Bill_no").val(result[0]);
				  $("#Custidhidden").val(result[1]);
				  $("#Totalfees").val(result[2]);			 
				  $("#Balance").val(result[3]);				 
				 				
				}
				
				});
				      					
								
			// hide the result
           jQuery("#Cust_name").trigger('ajaxlivesearch:hide_result');
        },
        onResultEnter: function(e, data) {
            // do whatever you want
            //jQuery("#Courtcaseno").trigger('ajaxlivesearch:search', {query: 'test'});
        },
        onAjaxComplete: function(e, data) {
       // jQuery('#Cust_name').val(cust_name);
						
		//	jQuery('#Cust_id').val(cust_id); 
        }
    });
	


</script>    