

<div class="uk-width-medium-1-1" style="padding-bottom:0px; padding-left:10px; padding-right:10px">
<div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">
<form method='POST' name='caseform' action="<?php echo $_SERVER['PHP_SELF']  . '?' . SID ; ?>">
<div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-2-2">
        <div class="uk-form-row">
        <div class="uk-grid">

<!--<div class="uk-width-medium-1-4" style="padding-bottom:10px">
Search Date
<input type="text" data-uk-datepicker="{format:'YYYY-MM-DD'}" name="srchdate" id="srchdate" class="md-input"/></div>
<div class="uk-width-medium-1-4" style="padding-bottom:10px"></div> -->
           
<div class="uk-width-medium-1-4" style="padding-bottom:10px">
Filter
<input type="text" id="filter" name="filter" class="md-input" tabindex="1" />

</div>
 </div>

 
        
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
					
					//datagrid.editableGrid.clearFilter(); 

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
	jQuery("#Courtcaseno").ajaxlivesearch({
        loaded_at: <?php echo $time; ?>,
        token: <?php echo "'" . $token . "'"; ?>,
        max_input: <?php echo $maxInputLength; ?>,
        onResultClick: function(e, data) {
            // get the index 1 (second column) value
            var courtcaseno = jQuery(data.selected).find('td').eq('3').text();
			
			var stage = jQuery(data.selected).find('td').eq('4').text();
			
			var brief_file = jQuery(data.selected).find('td').eq('0').text();
			var party = jQuery(data.selected).find('td').eq('1').text();
			var oppoparty = jQuery(data.selected).find('td').eq('5').text();
			
            // set the input value
            jQuery('#Courtcaseno').val(courtcaseno);
			
			jQuery('#Courtcasenohidden').val(courtcaseno);	
        			
			jQuery('#Stage').val(stage);			
			
			jQuery('#Brief_filehidden').val(brief_file);
			
			jQuery('#Partyhidden').val(party);
			
			jQuery('#Oppopartyhidden').val(oppoparty);				
						
			// hide the result
           jQuery("#Courtcaseno").trigger('ajaxlivesearch:hide_result');
        },
        onResultEnter: function(e, data) {
            // do whatever you want
            //jQuery("#Courtcaseno").trigger('ajaxlivesearch:search', {query: 'test'});
        },
        onAjaxComplete: function(e, data) {

        }
    });
	
	


</script>    
	
 <!--== <script>  	
			function showAddForm() {
			  if ( $("#addform").is(':visible') ) 
				  $("#addform").hide();
			  else
				  $("#addform").show();
            }
			}
		
</script>-->
