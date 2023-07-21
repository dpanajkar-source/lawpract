<div class="uk-width-medium-1-1" style="padding-bottom:0px; padding-left:10px; padding-right:10px">
<div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">
<form method='POST' name='caseform' action="<?php echo $_SERVER['PHP_SELF']  . '?' . SID ; ?>">
<div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-2-2">
        <div class="uk-form-row">
        <div class="uk-grid">

<div class="uk-width-medium-1-4" style="padding-bottom:10px">
Search By Diary Date new
<input type="text" data-uk-datepicker="{format:'DD/MM/YYYY'}" name="srchdate" id="srchdate" class="md-input"/></div>
<div class="uk-width-medium-1-4" style="padding-bottom:10px;  text-align:center">
                        
</div> 

           
<div class="uk-width-medium-2-4" style="padding-bottom:10px">
Filter (Use brief_file no or Caseno or Party Name)
<input type="text" id="filter" name="filter" class="md-input" />

</div>


 </div>
  
           
                        
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
				
				var srch_date=$("#srchdate").val().split("/");
				
				var sum1=srch_date[2]+'-'+srch_date[1]+'-'+srch_date[0];  
                //var record1 = new Date(sum1);
							
			        datagrid.editableGrid.filter(sum1, [2]);
					
					datagrid.editableGrid.clearFilter(); 

                    // To filter on some columns, you can set an array of column index 
                    //datagrid.editableGrid.filter1( $(this).val(), [0,3,5]);
                  });
				  
				  $("#addbuttonnextdate").click(function() {
				
				alert('Online Integration work is going on..');
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

 <script src="bower_components/jquery-ui/jquery-ui.js" ></script>
	
 <!--== <script>  	
			function showAddForm() {
			  if ( $("#addform").is(':visible') ) 
				  $("#addform").hide();
			  else
				  $("#addform").show();
            }
			}
		
</script>-->
