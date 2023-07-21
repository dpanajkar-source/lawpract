<div class="uk-width-medium-1-1" style="padding-bottom:0px; padding-left:10px; padding-right:10px">
<div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">
<form method='POST' name='caseform' action="<?php echo $_SERVER['PHP_SELF']  . '?' . SID ; ?>">
<div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-2-2">
        
        <div class="uk-form-row">
        <div class="uk-grid">

<!--<div class="uk-width-medium-1-4" style="padding-bottom:10px">
Search By Date
<input type="text" data-uk-datepicker="{format:'YYYY-MM-DD'}" name="srchdate" id="srchdate" class="md-input"/></div>-->
<div class="uk-width-medium-1-2"><h1 class="heading_a">Search Title</h1></div>
<div class="uk-width-medium-1-2" align="right"><i class="md-icon material-icons" id="invoice_print">&#xE8ad;</i>
<span class="menu_title" style="text-decoration:underline; cursor:pointer" onclick="javascript:MM_openbrwindow('Manualsearchtitle.php',600,400);"><i class="material-icons md-color-green-500">&#xE887;</i></span></div>
<div class="uk-width-medium-1-2">
Filter (Use Customer Name, Property, Agent Name)
<input type="text" id="filter" name="filter" class="md-input" tabindex="1"/>

</div>
 </div>
        
 						
    <?php  
  
echo ' <div class="uk-grid uk-grid-medium data-uk-grid-margin">
                <div class="uk-width-medium-2-2 uk-width-medium-2-2">
                <div class="md-card" height:200px">
                <div  class="md-card-content">';    
echo '<div class="uk-form-row">
     <div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">';
	 
	                        
 echo '<div class="uk-width-medium-1-5" style="padding-bottom:10px">File No         
    <input class="md-input" type="text" name="File_no" id="File_no" tabindex="1"></div>';
	
	 $sqlcontacts='SELECT id,name from lw_contacts';
  			$resultcontacts=DB_query($sqlcontacts,$db);
			   
						   
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
	
echo'<div class="uk-width-medium-2-5" style="padding-bottom:5px"> Property Name:
     <input class="md-input" type="text" name="Property" id="Property" tabindex="3"></div>'; 
		
	       echo'<div class="uk-width-medium-1-5" style="padding-bottom:2px">
      Inward Date :
      <input class="md-input" data-uk-datepicker="{format:\'DD/MM/YYYY\'}" name="Inward_date" id="Inward_date" tabindex="3" ></div>'; 	
		                            
$sqlstatus='SELECT id,status from lw_taskstatus WHERE id <>"' . $_SESSION['ID'] . '"' ;
  $resultstatus=DB_query($sqlstatus,$db);
  
	echo '<div class="uk-width-medium-1-5" style="padding-bottom:2px">Search Status';
	?>
	<select name="Status" tabindex=3 id="Status" class="md-input">
    <?php
	while ($myrowstatus = DB_fetch_array($resultstatus)) {
     echo '<option VALUE="' . $myrowstatus['id'] . '">' . $myrowstatus['status'] . '</option>';
			
	} //end while loop</tr>
		DB_data_seek($resulttaskstatus,0);
        echo '</select></div>'; 
	
      $sqlcontacts='SELECT id,name from lw_contacts';
  			$resultcontacts=DB_query($sqlcontacts,$db);
			   
						   
			echo '<div class="uk-width-medium-2-5" style="padding-bottom:10px">Name of Agent';
			 
              echo '<input list="Agentlist" name="Agent" id="Agent" class="md-input">';           
              
			   
                ?>
              
                <datalist name="Agentlist" id="Agentlist" style="overflow:visible">
    <?php	
	
	while ($myrowcontacts = DB_fetch_array($resultcontacts)) {
	  {
	  echo '<option VALUE="' . $myrowcontacts['name'] . '">' . $myrowcontacts['name'] . '</option>';
	  }	
			
	} //end while loop</tr>
	DB_data_seek($resultcontacts,0);
        echo '</datalist></div>';	
		
		
       echo '<div class="uk-width-medium-1-5" style="padding-bottom:5px">Property Details:
     <input class="md-input" type="text" name="Details" id="Details" tabindex="3"> </div>';
   
       	 
	echo '<div class="uk-width-medium-2-5" style="padding-bottom:2px">Remark :
	<input name="Remark"  id="Remark" class="md-input" tabindex="4"></div>';


                      
 echo '<div class="uk-width-medium-1-5" style="padding-bottom:5px">Agent Charges:
     <input class="md-input" type="number" name="Agentcharges" id="Agentcharges" tabindex="3">
     </div>';
	     
echo '<div class="uk-width-medium-1-5" style="padding-bottom:5px">Search Fees:
      <input class="md-input" type="number" name="Searchfees" id="Searchfees" tabindex="3">
     </div>'; 
	 
echo '<div class="uk-width-medium-1-5" style="padding-bottom:5px">Advocate Fees Charged:
     <input class="md-input" type="number" name="Feescharged" id="Feescharged" tabindex="3">
     </div>'; 

             
 ?>
        

          <div class="uk-width-medium-1-5 row tright" style="padding-bottom:2px">
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
    
              
			<!-- Grid contents -->
            <div style="overflow:auto">
			<div style="padding-top:20px; margin-left:0px" id="tablecontent"></div>
            </div>
           		
			<!-- Paginator control -->
			<div  id="paginator"></div>
		</div>  
	 
		
        <!-- EditableGrid test if jQuery UI is present. If present, a datepicker is automatically used for date type -->
        


<script type="text/javascript">
		
            var datagrid = new DatabaseGrid();
			window.onload = function() {    			
							  
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