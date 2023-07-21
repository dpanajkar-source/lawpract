	<div class="md-input-wrapper">
    <form method="POST" action="" name="Uploadimage" id="Uploadimage" enctype="multipart/form-data">
 
	<div class="uk-grid uk-grid-medium" data-uk-grid-margin>
                <div class="uk-width-xLarge-1-2 uk-width-large-1-2">
                             <div class="md-card" style="height:400px">
                        <div  class="md-card-content">
                        <div> 
     
		
        <div class="uk-width-medium-2-3" style="padding-bottom:10px"><label>Customer Name</label>
          <input type="Text" name="C_name"  id="C_name" class="md-input" readonly >
       </div>
     	 
    <input  type="hidden" name="cust_id" id="cust_id">
			
			<input  type="hidden" name="cust_name" id="cust_name">			
		   

	<div class="uk-form-file md-btn md-btn-primary">Select File Here
          <input tabindex="2" type="file" name="file"  id="file" class="md-input">
       </div>   
       
<div style="padding-bottom:10px; padding-top:10px">
<input tabindex="3" type="submit" name="upload" id="upload" class="md-btn md-btn-primary" value="Upload Files"></div>
</form>    
 </div>  
 </div> 
</div>
 </div>

             
          <div class="uk-width-xLarge-5-10 uk-width-large-5-10">
             
                    <div class="md-card" style="overflow:auto; height:400px">
                        <div  align="center" class="md-card-content">
                         
                   <div name="myform" id="myform">
                   
                   
                       </div>
                       
                                                                                    
                       </div>
                       
                   </div>
             
                              
               
          <div>File Types accepted for Upload are:(jpg, jpeg, png, doc, docx, txt, pdf, xls, xlsx)</div>

		      
   
</div>              
               
                     <script>
									
					function deleteRow(obj) {
					
					
					var index=obj.parentNode.parentNode.rowIndex;
					var table=document.getElementById("myTableData");
					emp=document.getElementById("myTableData").rows[index].cells[0];
					fname=document.getElementById("myTableData").rows[index].cells[1];
					table.deleteRow(index);	
					
					alert($('#cust_name').val());
					
																			
					$.ajax({
						url: 'bf_deletefile.php', // Url to which the request is send
						type: "POST",             // Type of request to be send, called as method
						dataType: "html",
						data: {
									'id': emp.textContent,								
						    		'file_name': fname.textContent,
									'cust_name': $('#cust_name').val()									
									
							  },// Data sent to server, a set of key/value pairs (i.e. form fields and values	
						
						success: function(data)   // A function to be called if request succeeds
						{
						
						//$("#message").html(data);
							
						}
						
						});		
					
					
					}					
					
					
					</script>
                    
                </div>
                <div class="uk-margin-medium-bottom"></div>
    </div>
    </div>

	
					
			                
 </div> <!-- end of file upload md-card for insert -->
 

    <!-- uikit functions 
     common functions -->
      <?php include("footersrc.php");      ?>
   
           
       <script defer src = "bf_script_fileuploads.js"></script>
            
<script>

	//below is for main search for the lw_casenewajax form
	jQuery("#Cust_name").ajaxlivesearch({
        loaded_at: <?php echo $time; ?>,
        token: <?php echo "'" . $token . "'"; ?>,
        max_input: <?php echo $maxInputLength; ?>,
        onResultClick: function(e, data) {
            
			var cust_id = jQuery(data.selected).find('td').eq('0').text();
			var cust_name = jQuery(data.selected).find('td').eq('1').text();
			
            // set the input value
			           						
			jQuery('#cust_id').val(cust_id);  	
			
			jQuery('#cust_name').val(cust_name);  
			
			jQuery('#C_name').val(cust_name);		
			
			jQuery('#Cust_namehidden').val(cust_name); 
			
		 //here we will select all attached documents from filesattached table and display here
		      $.ajax({
				url: 'bf_ajax_file_upload.php', // Url to which the request is sent
				type: "POST",             // Type of request to be send, called as method
				dataType: "html",
				data: { 
					    cust_id:$("#cust_id").val(),
						cust_name:$("#cust_name").val()				
						  
					  },// Data sent to server, a set of key/value pairs (i.e. form fields and values	
					
				
				success: function(data)   // A function to be called if request succeeds
				{
				 $("#myform").html(data);
				}
				
				});
						
			// hide the result
           jQuery("#Cust_name").trigger('ajaxlivesearch:hide_result');
        },
        onResultEnter: function(e, data) {
            // do whatever you want
            //jQuery(".mySearch").trigger('ajaxlivesearch:search', {query: 'test'});
        },
        onAjaxComplete: function(e, data) {

        }
    });
	
	
</script>    

