	<div class="md-input-wrapper">
    <form method="POST" action="" name="Uploadimage" id="Uploadimage" enctype="multipart/form-data">
 
	<div class="uk-grid uk-grid-medium" data-uk-grid-margin>
                <div class="uk-width-xLarge-1-2 uk-width-large-1-2">
                             <div class="md-card" style="height:400px">
                        <div  class="md-card-content">
                        <div> 
     
		
        <div class="uk-width-medium-2-3" style="padding-bottom:10px"><label>Brief_File No</label>
          <input type="Text" name="Brief_File"  id="Brief_File" class="md-input" readonly >
       </div>
     	 
     <div class="uk-width-medium-2-3" style="padding-bottom:0px"><label>Case No/Document No</label> 
	  <input type="Text" name="Courtcaseno" id="Courtcaseno" class="md-input" readonly></div>
      
      <div class="uk-width-medium-2-3" style="padding-bottom:10px"><label>Party Name</label> 
	  <input  type="Text" name="Party" id="Party" class="md-input" readonly> </div> 
      
            <input type="hidden" name="Partyid" id="Partyid">
            
       <div class="uk-width-medium-2-3" style="padding-bottom:10px"><label>Opposite Party Name</label> 
	  <input  type="Text" name="Oppoparty" id="Oppoparty" class="md-input"  readonly> </div>           

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
                    
                </div>
                <div class="uk-margin-medium-bottom"></div>
    </div>
    </div>

	
					
			                
 </div> <!-- end of file upload md-card for insert -->
 

    <!-- uikit functions 
     common functions -->
      <?php include("footersrc.php");      ?>
   
           
       <script defer src = "script.js"></script>
       
<script>

	//below is for main search for the lw_casenewajax form
	jQuery(".mdinputSearch").ajaxlivesearch({
        loaded_at: <?php echo $time; ?>,
        token: <?php echo "'" . $token . "'"; ?>,
        max_input: <?php echo $maxInputLength; ?>,
        onResultClick: function(e, data) {
            // get the index 1 (second column) value
             var selectedsearch = jQuery(data.selected).find('td').eq('0').text();
			var selectedparty = jQuery(data.selected).find('td').eq('2').text();
			var selectedoppoparty = jQuery(data.selected).find('td').eq('3').text();
			var selectedcaseno = jQuery(data.selected).find('td').eq('5').text();
            var selectedpartyid = jQuery(data.selected).find('td').eq('6').text();
            //var selectedcaseid = jQuery(data.selected).find('td').eq('5').text();

            // set the input value
            jQuery('.mdinputSearch').val(selectedsearch);
			
			jQuery('#Brief_File').val(selectedsearch);
			
			jQuery('#Party').val(selectedparty);
        
            jQuery('#Partyid').val(selectedpartyid);
			
			jQuery('#Oppoparty').val(selectedoppoparty);			
			
			jQuery('#Courtcaseno').val(selectedcaseno);
			
		 //here we will select all attached documents from filesattached table and display here
		      $.ajax({
				url: 'ajax_php_file.php', // Url to which the request is sent
				type: "POST",             // Type of request to be send, called as method
				dataType: "html",
				data: {
				      brief_file: selectedsearch, 
					  Brief_File:$("#Brief_File").val(),
						Courtcaseno:$("#Courtcaseno").val(),
						Party:$("#Party").val(),
						Partyid:$("#Partyid").val()						
						
					  },// Data sent to server, a set of key/value pairs (i.e. form fields and values	
					
				
				success: function(data)   // A function to be called if request succeeds
				{
				 $("#myform").html(data);
				}
				
				});
						
			// hide the result
           jQuery(".mdinputSearch").trigger('ajaxlivesearch:hide_result');
        },
        onResultEnter: function(e, data) {
            // do whatever you want
            //jQuery(".mySearch").trigger('ajaxlivesearch:search', {query: 'test'});
        },
        onAjaxComplete: function(e, data) {

        }
    });
	
	
</script>    

