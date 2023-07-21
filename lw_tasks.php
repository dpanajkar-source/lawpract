<?php

if(isset($_POST['submittask']))
{

$currtrandate=date("Ymd");

$DateString = Date($_SESSION['DefaultDateFormat']);
	
$date = new DateTime(FormatDateForSQL($DateString));

$stmt= "INSERT INTO lw_tasks(taskfrom,
						taskto,
						task,
						taskstatus,
						priority,
						startdate,
						enddate,
						remark
						)
				VALUES ('" . $_POST['taskfrom'] . "',
						'" . $_POST['taskto'] . "',
					'" . $_POST['task'] . "',
					'" . $_POST['taskstatus'] . "',
					'" . $_POST['taskpriority'] . "',
					'" . FormatDateForSQL($_POST['startdate']) . "',
					'" . FormatDateForSQL($_POST['enddate']) . "',
					'" . $_POST['remark'] . "'
						)";

      $result1 = DB_query($stmt,$db);
	  ?>
    <script>
	
swal({   title: "Task Inserted!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('lw_tasks_alt.php'); //will redirect to your page
}, 2000); 
	
	</script>
    
<?php


}

?>





<div class="uk-width-medium-1-1" style="padding-bottom:0px; padding-left:10px; padding-right:10px">
<div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">
<form method='POST' name='caseform' action="<?php echo $_SERVER['PHP_SELF']  . '?' . SID ; ?>">
<div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-2-2">
        <div class="uk-form-row">
        <div class="uk-grid">

<div class="uk-width-medium-1-4" style="padding-bottom:10px">
<input type="text" name="CurrDate" style="font-weight:bold" class="md-input" value="<?php echo date("d M Y"); ?>" readonly="readonly" /></div>
   
<div class="uk-width-medium-1-4" style="padding-bottom:10px">
<input type="text" id="filter" name="filter" class="md-input" placeholder="Filter : Type for Filtering" tabindex="1"  /></div>
</form>
 
        
<!-- Feedback message zone -->
<div id="message"></div>
</div>

</div>
</div>                  

  </div>

</div>
</div>            
    
              
			<!-- Grid contents -->
			<div id="tablecontent"></div>
            
           		
			<!-- Paginator control -->
			<div id="paginator"></div>
		</div>  
	 
		
        <!-- EditableGrid test if jQuery UI is present. If present, a datepicker is automatically used for date type -->       


<script type="text/javascript">
		
            var datagrid = new DatabaseGrid();
			window.onload = function() {    
			         // key typed in the filter field
                $("#filter").keyup(function() {
                    datagrid.editableGrid.filter( $(this).val());

                    // To filter on some columns, you can set an array of column index 
                    //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);
                  });
				  
           	 datagrid.editableGrid.clearFilter();   
   
                     
			}; 
		</script>
        
      

        <!-- simple form, used to add a new row 
        <div id="addform">
            <div class="uk-width-medium-1-1" >
             <div class="uk-width-large-10-12 uk-container-center">  
            <div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">
            <div class="uk-grid" data-uk-grid-margin >

            <div class="uk-width-medium-1-1" style="padding-bottom:10px">
           
            echo '<input type="text" name="Courtcaseno" id="Courtcaseno" class="Courtcaseno" placeholder="Type to search(brief_file,name,mobile,courtcaseno)" tabindex="1">';
            echo '<input type="hidden"  name="Courtcasenohidden" id="Courtcasenohidden">';	  
            echo '<input type="hidden" class="md-input" name="Brief_filehidden" id="Brief_filehidden"></div>';	
 
$sqlstage='SELECT stageid,stage from lw_stages';
  $resultstage=DB_query($sqlstage,$db);
  
echo '<div class="uk-width-medium-1-1" style="padding-bottom:20px"><label>Stage:</label>';
?>
	
	
            <div class="row tright">
              <a id="addbutton" class="button green" ><i class="fa fa-save"></i> Apply</a>
              <a id="cancelbutton" class="button delete">Cancel</a>
            </div>
        </div>
                </div>
                </div>
                </div>
                </div>
        

              
                <!-- /Search Form Demo -->

<div class="md-fab-wrapper">
   <a class="md-fab md-fab-danger" href="#newtask" data-uk-modal="{center:true}">
        <i class="material-icons">&#xE145;</i>
    </a>
</div>

<?php
						$DateString = Date($_SESSION['DefaultDateFormat']);
	
						$datetoday = new DateTime(FormatDateForSQL($DateString));   ?>

  <div class="uk-modal" id="newtask" >
        <div class="uk-modal-dialog" style="margin-top:50px">
            <button class="uk-modal-close uk-close" type="button"></button>
                <div class="uk-modal-header">
                    <h3 class="uk-modal-title">Enter New Task</h3>
                </div>
                <div class="uk-margin-medium-bottom">
                
                <form method='post' name='taskform' action="<?php echo $_SERVER['PHP_SELF']  . '?' . SID ; ?>">               
                
                <div class="uk-margin-bottom" style="color:#006633; font-weight:bold">Task From
             <input type="text" class="md-input" id="taskfrom" name="taskfrom" value="<?php  echo  $_SESSION['UserID']; ?>" readonly="readonly" />
                  </div>
                
<?php                                
$sqltask='SELECT userid,realname from www_users WHERE userid <>"' . $_SESSION['UserID'] . '"' ;
  $resulttask=DB_query($sqltask,$db);
  
echo '<div class="uk-margin-bottom" style="padding-bottom:20px">Assign Task To';
?>
	
	<select name="taskto" tabindex=3 id="taskto" class="md-input">
    <?php
	while ($myrow = DB_fetch_array($resulttask)) {
       
			echo '<option VALUE="' . $myrow['userid'] . '">' . $myrow['realname'] . '</option>';
			
			
	} //end while loop</tr>
	DB_data_seek($resulttask,0);
        echo '</select></div>'; ?>
        
              <div class="uk-margin-medium-bottom">
                                    Task Description
                                    <input type="text" class="md-input" id="task" name="task" />
                                </div>

  


<?php    
 echo '<div class="uk-width-medium-1-1" style="padding-bottom:0px">';
echo '<div class="uk-grid uk-grid-width-1-2 uk-grid-width-large-1-2">';
                            
$sqltaskstatus='SELECT id,status from lw_taskstatus WHERE id <>"' . $_SESSION['ID'] . '"' ;
  $resulttaskstatus=DB_query($sqltaskstatus,$db);
  
echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Task Status';
?>
	
	<select name="taskstatus" tabindex=3 id="taskstatus" class="md-input">
    <?php
	while ($myrowstatus = DB_fetch_array($resulttaskstatus)) {
       
			echo '<option VALUE="' . $myrowstatus['id'] . '">' . $myrowstatus['status'] . '</option>';
			
			
	} //end while loop</tr>
	DB_data_seek($resulttaskstatus,0);
        echo '</select></div>'; ?>
        
            
                        
     <div class="uk-width-medium-1-2" style="padding-bottom:10px">Priority
<select name="taskpriority" tabindex=6 id="taskpriority" class="md-input">
 <option VALUE="0">Low</option>
  <option VALUE="1">Normal</option>
  <option VALUE="2">High</option>
 </select></div>                            
                                          
		<div class="uk-width-medium-1-2" style="padding-bottom:10px">
		Start Date<input class="md-input" type="text" id="startdate" name="startdate" data-uk-datepicker="{format:'DD/MM/YYYY', addClass: 'dropdown-modal'}"></div>
        
		<div class="uk-width-medium-1-2" style="padding-bottom:10px">Due Date
 		<input class="md-input" type="text" id="enddate" name="enddate" data-uk-datepicker="{format:'DD/MM/YYYY', addClass: 'dropdown-modal'}">
		</div>

                                
        <div class="uk-width-medium-1-1" style="padding-bottom:10px">Remark
        <input type="text" class="md-input" id="remark" name="remark" />
        </div>
                                   
        <div class="uk-width-medium-1-2" style="padding-bottom:10px">                               
        <input type="submit" class="md-btn md-btn-primary" id="submittask" name="submittask" value="Save Task">
        </div>
          <div class="uk-width-medium-1-2" style="padding-bottom:10px">
         <input type="submit" class="md-btn md-btn-flat uk-modal-close" value="Close Window">
        </div>
    
                                     
        </div>
    </div>
    </div>

                    
<!-- Placed at the end of the document so the pages load faster -->

<script src="assets/js/common.js"></script> 

<!-- Live Search Script -->
<script type="text/javascript" src="ajaxlivesearch.js"></script>

	

