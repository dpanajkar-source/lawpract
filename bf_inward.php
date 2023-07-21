

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
Filter (Use Application no, Customer name or Branch name )
<input type="text" id="filter" name="filter" class="md-input" tabindex="1" />

</div>
 </div>
  <?php          
  
echo ' <div class="uk-grid uk-grid-medium data-uk-grid-margin">
                <div class="uk-width-medium-2-2 uk-width-medium-2-2">
                <div class="md-card" style="height:220px">
                <div  class="md-card-content">';                     
                     
	
echo '<div class="uk-form-row">
       <div style="border:groove">
	   <div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">';
	                        
 echo '<div class="uk-width-medium-3-5" style="padding-bottom:10px">       
      <input type="text" name="Bank_name" id="Bank_name" class="md-input" placeholder="Type Bank Name" tabindex="1"></div>';
		   
  			
			echo '<input type="hidden" name="Bank_code" id="Bank_code">';
			   
			 echo '<input type="hidden" name="Bank_id" id="Bank_id">';	
			 
			echo '<input type="hidden" name="UserID" id="UserID" value="' . $_SESSION['UserID'] . '">'; 	   
			   
				
				echo '<div class="uk-width-medium-1-5" style="padding-bottom:10px; padding-top:7px">Select Branch:<select name="Bankbranchnolist" id="Bankbranchnolist" class="md-input"></select></div>';
			?>
			  <div class="uk-width-medium-1-5" style="padding-bottom:10px">
      Inward Date:
      <input class="md-input" data-uk-datepicker="{format:'DD/MM/YYYY'}" name="Inward_date" id="Inward_date" tabindex="3" value="<?php echo date("d/m/Y"); ?>">
     </div> 
	 <?php			   
			
			 $sqlcontacts='SELECT id,name from lw_contacts';
  			$resultcontacts=DB_query($sqlcontacts,$db);
			   
			echo '<div class="uk-width-medium-1-5" style="padding-bottom:10px">Application No
			   <input class="md-input" type="text" name="Application_no" id="Application_no"></div>';
			   
			echo '<div class="uk-width-medium-2-5" style="padding-bottom:10px">Name of Customer';
			 
              echo '<input list="Customerlist" name="Customer" id="Customer" class="md-input">';           
              
			   
                ?>
              
                <datalist name="Customerlist" id="Customerlist" style="overflow:visible">
    <?php	
	
	while ($myrowcontacts = DB_fetch_array($resultcontacts)) {
	  {
	  echo '<option VALUE="' . $myrowcontacts['name'] . '">' . $myrowcontacts['name'] . '</option>';
	  }	
			
	} //end while loop</tr>
	DB_data_seek($resultcontacts,0);
        echo '</datalist></div>';		
	
	                              
$sqltask='SELECT userid,realname from www_users WHERE userid <>"' . $_SESSION['UserID'] . '"' ;
  $resulttask=DB_query($sqltask,$db);
  
echo '<div class="uk-width-medium-1-5" style="padding-bottom:10px">Handled By';

	
	echo '<select name="Handledby" tabindex=3 id="Handledby" class="md-input">';

	while ($myrow = DB_fetch_array($resulttask)) {
       
			echo '<option VALUE="' . $myrow['userid'] . '">' . $myrow['realname'] . '</option>';
			
			
	} //end while loop</tr>
	DB_data_seek($resulttask,0);
        echo '</select></div>';
	
	
	
$sqlstage='SELECT id,stage from bf_stages';
  $resultstage=DB_query($sqlstage,$db);
  
echo '<div class="uk-width-medium-1-5" style="padding-bottom:10px">Select Stage :';
	
echo '<select name="Stage" tabindex=3 id="Stage" class="md-input" tabindex="2">';
    
	while ($myrow = DB_fetch_array($resultstage)) {
       
			echo '<option VALUE="' . $myrow['id'] . '">' . $myrow['stage'] . '</option>';
			
			
	} //end while loop</tr>
	DB_data_seek($result,0);
        echo '</select></div>'; 
	
			
			echo '<div class="uk-width-medium-1-5" style="padding-bottom:10px">Loan Amount
			   <input class="md-input" type="number" name="Loanamount" id="Loanamount"></div>';
			   
			   echo '<div class="uk-width-medium-1-5" style="padding-bottom:10px">Fees Charged
			   <input class="md-input" type="number" name="Fees" id="Fees"></div>';		
			   
		
        echo '<div class="uk-width-medium-1-5" style="padding-bottom:10px">Remark
			   <input class="md-input" type="text" name="Remark" id="Remark"></div>';
 ?>
          <div class="uk-width-medium-1-5 row tright" style="padding-bottom:10px">
              <a id="addbutton" class="md-btn md-btn-primary" ><i class="fa fa-save"></i> Add Row</a>    </div>
            
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

  

	//below is for fetching courtcaseno from lw_cases
	jQuery("#Bank_name").ajaxlivesearch({
        loaded_at: <?php echo $time; ?>,
        token: <?php echo "'" . $token . "'"; ?>,
        max_input: <?php echo $maxInputLength; ?>,
        onResultClick: function(e, data) {
            // get the index 1 (second column) value
            var bank_code = jQuery(data.selected).find('td').eq('0').text();
			
			var bank_name = jQuery(data.selected).find('td').eq('1').text();
			
			var contact_person = jQuery(data.selected).find('td').eq('2').text();
			var landline = jQuery(data.selected).find('td').eq('3').text();
			
			var bank_id = jQuery(data.selected).find('td').eq('4').text();
						
            // set the input value
            jQuery('#Bank_name').val(bank_name);
			
			jQuery('#Bank_code').val(bank_code);  
			
			jQuery('#Bank_id').val(bank_id);  
			      					
								
			// hide the result
           jQuery("#Bank_name").trigger('ajaxlivesearch:hide_result');
        },
        onResultEnter: function(e, data) {
            // do whatever you want
            //jQuery("#Courtcaseno").trigger('ajaxlivesearch:search', {query: 'test'});
        },
        onAjaxComplete: function(e, data) {
        jQuery('#Bank_name').val(bank_name);
			
			jQuery('#Bank_code').val(bank_code);
			
			jQuery('#Bank_id').val(bank_id); 
        }
    });
	
	$("#Bankbranchnolist").focus(function(e) { 
				
	 $.ajax({
			url: 'bf_bankbranchnoload.php',
			type: 'POST',
			dataType: "html",
			data: {
			bankid: $("#Bank_id").val()
		},
		
		 success: function (output) 
			{ 
				$("#Bankbranchnolist").html(output);   
				      
			},
			error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + errortext); },
			async: false
		});


});


</script>    