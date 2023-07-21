

<div class="uk-width-medium-1-1" style="padding-bottom:0px; padding-left:10px; padding-right:10px">
<div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">
<form method='POST' name='caseform' action="<?php echo $_SERVER['PHP_SELF']  . '?' . SID ; ?>">
<div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-2-2">
        <div class="uk-form-row">
        <div class="uk-grid">

<div class="uk-width-medium-3-4" style="padding-bottom:10px"><h1 class="heading_a">Outward - Bank Bill Generation</h1></div>
                      <div class="uk-width-medium-1-4" align="right" style="padding-bottom:10px"><i class="md-icon material-icons" id="invoice_print">&#xE8ad;</i> <span class="menu_title" style="text-decoration:underline; cursor:pointer" 

onclick="javascript:MM_openbrwindow('Manualbankfinance.php',600,400);">
<i class="material-icons md-color-green-500">&#xE887;</i></span></div>
           
<div class="uk-width-medium-2-4" style="padding-bottom:10px">
Filter (Use Application no, Customer name or Branch name )
<input type="text" id="filter" name="filter" class="md-input" tabindex="1" /></div>
<div class="uk-width-medium-2-4" style="padding-bottom:10px"></div>

<div class="uk-width-medium-2-5" style="padding-bottom:5px; padding-top:5px">Bank Name       
      <input type="text" name="Bank_name" id="Bank_name" class="md-input" placeholder="Select Bank Name to Generate Bill For" tabindex="1"></div>
		   
  			
		<input type="hidden" name="Bank_code" id="Bank_code">	
			   
			<input type="hidden" name="Bank_id" id="Bank_id">	
            
            <input type="hidden" name="Bank_namehidden" id="Bank_namehidden">  
            
             <input type="hidden" name="UserID" id="UserID" value="<?php echo $_SESSION['UserID']; ?>">            
	
        
 <div class="uk-width-medium-1-5 row tright" style="padding-bottom:10px; padding-top:32px">
              <a id="addbutton" class="md-btn md-btn-primary">Generate Bill</a>    </div>

 </div>
       

   <?php	
/*         
             echo '<div class="md-card">
                <div  class="md-card-content">';                    
                     
    
echo '<div class="uk-form-row">

	   <div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">';
	                        
 echo '<div class="uk-width-medium-3-5" style="padding-bottom:10px">       
      <input type="text" name="Bank_name" id="Bank_name" class="md-input" placeholder="Type to search(Banking or Finance Institution name)" tabindex="1"></div>';
		   
  			
			echo '<input type="hidden" name="Bank_code" id="Bank_code">';
			   
			 echo '<input type="hidden" name="Bank_id" id="Bank_id">';		   
			   
			   
			   //select bill no automatically after 25 rows
			/*$sqlbillno='SELECT billno,status from bf_bills ORDER BY id DESC LIMIT 1';
			
			$resultbillno=DB_query($sqlbillno,$db); 
			
			$myrowbillno=DB_fetch_array($resultbillno);
			
			if(empty($myrowbillno))
			{
			$myrowbillno['billno']=1;
			}			
			
			if($myrowbillno['status']==1)
			{
			$myrowbillno['billno']=$myrowbillno['billno']+1;
			}
			
			
			
			echo '<div class="uk-width-medium-1-5" style="padding-bottom:10px; padding-top:7px">Current Bill No
			   <input class="md-input" type="text" name="Bill_no" id="Bill_no" value="'.$myrowbillno['billno'].'" readonly></div>';
			   
		
  	echo '</div></div></div></div>';               

  



           
           */
			
              ?>        
 </form>
 
        
<!-- Feedback message zone -->
<div id="message">


</div>
</div>

</div>
            
    
              
			<!-- Grid contents -->
			<div class="uk-overflow-container" style="padding-bottom:10px; margin-left:10px" id="tablecontent"></div>
           <!-- Close Current Bill <input type="checkbox" id="closebill" />-->
            
           		
			<!-- Paginator control -->
			<div  id="paginator"></div>
		</div>  
	 
		
        <!-- EditableGrid test if jQuery UI is present. If present, a datepicker is automatically used for date type -->
  
<script type="text/javascript">
		
            var datagrid = new DatabaseGrid();
			window.onload = function() {   
			
			/*$("#closebill").click(function() {
			  
			  var i=$('#Bill_no').val();
			  
			  i=i++;
			  			  			  			  
			$('#Bill_no').val(i+1); 
									
			$('#closebill').attr('disabled', true);
			
			$.ajax({
			url: 'bf_changebillstatus.php',
			type: 'POST',
			dataType: "html",
			data: {
			billno: $('#Bill_no').val()
				   },
		
		 success: function (output) 
			{ 
			
				$("#bankbranchnolist").html(output);   
				      
			},
			error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + errortext); },
			async: false
		});
			
			location.reload();
			                   
                });	 */
			
					
			
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
			jQuery('#Bank_namehidden').val(bank_name);
			
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
	
	$("#bankbranchnolist").focus(function(e) { 
			
	 $.ajax({
			url: 'bf_bankbranchnoload.php',
			type: 'POST',
			dataType: "html",
			data: {
			bankbranchcode: $("#Bank_id").val()
		},
		
		 success: function (output) 
			{ 
				$("#bankbranchnolist").html(output);   
				      
			},
			error: function(XMLHttpRequest, textStatus, exception) { alert("Ajax failure\n" + errortext); },
			async: false
		});


});


</script>    