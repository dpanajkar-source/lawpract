

<div class="uk-width-medium-1-1" style="padding-bottom:0px; padding-left:10px; padding-right:10px">
<div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">
<div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-2-2">
        <div class="uk-form-row">
        <div class="uk-grid">
		
            
<div class="uk-width-medium-2-4" style="padding-bottom:10px">
<input type="text" id="filter" name="filter" class="md-input" placeholder="Filter : Type any text here for Filtering" tabindex="1"  /></div>
            
     
        
<!-- Feedback message zone -->
<div id="message"></div>
</div>

</div>
</div>                  

  </div>

</div>
</div>            
    
              
			<!-- Grid contents -->
                 
        <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-2-2">
        <div class="uk-form-row">
        <div class="uk-grid">
        
			<div id="tablecontent"></div>
            
           		
			<!-- Paginator control -->
			<div id="paginator"></div>
		</div>
            </div>
            </div>
            </div>
            
	 
		
        <!-- EditableGrid test if jQuery UI is present. If present, a datepicker is automatically used for date type -->
        


<script type="text/javascript">
		
            var datagrid = new DatabaseGrid();
			window.onload = function() { 

                // key typed in the filter field
                $("#filter").keyup(function() {
                    datagrid.editableGrid.filter( $(this).val());

 				datagrid.editableGrid.clearFilter();   
                    // To filter on some columns, you can set an array of column index 
                    //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);
                  });

                      
			}; 
		</script>

                 
                <!-- /Search Form Demo -->

<!-- Placed at the end of the document so the pages load faster -->

<script src="assets/js/common.js"></script> 

<!-- Live Search Script -->
<script type="text/javascript" src="ajaxlivesearch.js"></script>
  
  