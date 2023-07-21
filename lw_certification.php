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
<div class="uk-width-medium-1-2"><h1 class="heading_a">Documents Certification</h1></div>
<div class="uk-width-medium-1-2" align="right"><i class="md-icon material-icons" id="invoice_print">&#xE8ad;</i>
<span class="menu_title" style="text-decoration:underline; cursor:pointer" onclick="javascript:MM_openbrwindow('Manualcertification.php',600,400);"><i class="material-icons md-color-green-500">&#xE887;</i></span>
              </div>
<div class="uk-width-medium-1-2">
Filter (Use brief_file no or Caseno or handledby or status)
<input type="text" id="filter" name="filter" class="md-input" tabindex="1"/>

</div>
 </div>
        
 						
    <?php  
  
echo ' <div class="uk-grid uk-grid-medium data-uk-grid-margin">
                <div class="uk-width-medium-2-2 uk-width-medium-2-2">
                <div class="md-card" height:225px">
                <div  class="md-card-content">';                     
                     
	
echo '<div class="uk-form-row">
     
	   <div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">';
	                        
 echo '<div class"uk-width-medium-1-1" style="padding-bottom:5px">       
      <input type="text" name="Courtcaseno" id="Courtcaseno" class="md-input" placeholder="Type to search(brief_file,name,mobile,courtcaseno)" tabindex="1" ></div>';
		    
						
            echo '<input type="hidden"  name="Courtcasenohidden" id="Courtcasenohidden">';
  
		 echo '<div class="uk-width-medium-1-6" style="padding-bottom:5px">Brief_file No
			<input type="text" class="md-input" name="Brief_filehidden" id="Brief_filehidden" readonly></div>';	
			
			echo '<div class="uk-width-medium-2-6" style="padding-bottom:5px">Party
			   <input class="md-input" type="text" name="Partyhidden" id="Partyhidden" readonly></div>';	
			   
			echo '<div class="uk-width-medium-2-6" style="padding-bottom:5px">Oppoparty
				  <input class="md-input" type="text" name="Oppopartyhidden" id="Oppopartyhidden" readonly></div>';	
			echo '<input type="hidden" name="Currentdate" id="Currentdate">';	
			
 
 echo '<div class="uk-width-medium-1-6" style="padding-bottom:5px">Court
			<input type="text" class="md-input" name="Court" id="Court" readonly></div>';	
			
     echo '<input type="hidden" name="Courtidhidden" id="Courtidhidden">';
   
     echo'<div class="uk-width-medium-1-6" style="padding-bottom:5px">
      Document Name
      <input class="md-input" type="text" name="Documentname" id="Documentname" tabindex="3">
     </div>'; 
     
  
     
     echo '<div class="uk-width-medium-2-6" style="padding-bottom:5px">
      Certified Copy Required For
      <input class="md-input" type="text" name="Requiredfor" id="Requiredfor" tabindex="3">
     </div>';
 
 $sqluser='SELECT userid,realname from www_users' ;
  $resultuser=DB_query($sqluser,$db);
  
echo '<div class="uk-width-medium-2-6" style="padding-bottom:5px">Handled by';
?>
	
	<select name="Handledby" tabindex=4 id="Handledby" class="md-input">
    <?php
	while ($myrow = DB_fetch_array($resultuser)) {
       
			echo '<option VALUE="' . $myrow['userid'] . '">' . $myrow['realname'] . '</option>';
			
			
	} //end while loop</tr>
	DB_data_seek($resultuser,0);
        echo '</select></div>'; 
 
					

echo '<div class="uk-width-medium-1-6" style="padding-bottom:5px">Stage
<input name="Stage" id="Stage" class="md-input" tabindex="4">';
echo '</div>'; 


	 ?>					
     
      <div class="uk-width-medium-1-6" style="padding-bottom:2px">
      Date
      <input class="md-input" data-uk-datepicker="{format:'DD/MM/YYYY'}" name="C_date" id="C_date" tabindex="3" value="<?php echo date("d/m/Y"); ?>">
     </div> 
            
 
    <?php
                            
$sqlstatus='SELECT id,status from lw_taskstatus WHERE id <>"' . $_SESSION['ID'] . '"' ;
  $resultstatus=DB_query($sqlstatus,$db);
  
echo '<div class="uk-width-medium-1-6" style="padding-bottom:2px">Certification Status';
?>
	
	<select name="Status" tabindex=3 id="Status" class="md-input">
    <?php
	while ($myrowstatus = DB_fetch_array($resultstatus)) {
       
			echo '<option VALUE="' . $myrowstatus['id'] . '">' . $myrowstatus['status'] . '</option>';
			
			
	} //end while loop</tr>
	DB_data_seek($resulttaskstatus,0);
        echo '</select></div>'; 
                      
     echo '<div class="uk-width-medium-1-6" style="padding-bottom:2px">Priority
		<select name="Priority" tabindex=6 id="Priority" class="md-input">
 		<option VALUE="0">Low</option>
 		<option VALUE="1">Normal</option>
 		<option VALUE="2">High</option>
 		</select></div>'; 

echo '<div class="uk-width-medium-2-6" style="padding-bottom:2px">Remark
<input name="Remark"  id="Remark" class="md-input" tabindex="4">';
echo '</div>';
             
 ?>
        

          <div class="uk-width-medium-1-6 row tright" style="padding-bottom:2px">
              <a id="addbutton" class="md-btn md-btn-primary" ><i class="fa fa-save"></i> Add Row</a>    </div>
            
        </div></div></div> </div></div>
           
           
                <!-- /Search Form Demo 
<div class="uk-width-medium-1-2 uk-width-medium-1-2">
             
                    <div class="md-card" style="overflow:auto; height:290px">
                        <div class="md-card-content">
                        
                            <h5 align="center"><b>Ecourts Case Details</b></h5>                           
                           
                           <iframe src="http://services.ecourts.gov.in/ecourtindia/cases/case_no.php?state=D&state_cd=1&dist_cd=25" width="600" height="250" style="margin-left:-50px"></iframe>
                           
                           
               </div></div></div></div>     
             
                -->
                
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
			<div class="uk-overflow-container" style="padding-top:20px; margin-left:10px" id="tablecontent"></div>
            
           		
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
			var court = jQuery(data.selected).find('td').eq('7').text();
			var courtid = jQuery(data.selected).find('td').eq('6').text();
			var brief_file = jQuery(data.selected).find('td').eq('0').text();
			var party = jQuery(data.selected).find('td').eq('1').text();
			var oppoparty = jQuery(data.selected).find('td').eq('5').text();
			
            // set the input value
            jQuery('#Courtcaseno').val(courtcaseno);
			
			jQuery('#Courtcasenohidden').val(courtcaseno);	
        			
			jQuery('#Court').val(court);	
			jQuery('#Courtidhidden').val(courtid);	
			
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
