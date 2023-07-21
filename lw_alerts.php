<?php


include('includes/SQL_CommonFunctions.inc');

if (isset($_POST['Alertid'])){
	$alertid = $_POST['Alertid'];
} elseif (isset($_GET['Alertid'])){
	$alertid = $_GET['Alertid'];
} else {
	$alertid=NULL;
	
}

if (isset($_POST['Submit'])) 
{
	 
	  if ($_POST['Startdate'] === "") 
   		{   
  		 $SQL_startdate = "NULL";
  		 }else {
  		 $SQL_startdate=FormatDateForSQL($_POST['Startdate']);
       
        $SQL_startdate="'\ " . $SQL_startdate . "\" . '";
        }
		 
	 if ($_POST['Duedate'] === "") 
   		{   
  		 $SQL_duedate = "NULL";
  		 }else {
  		 $SQL_duedate=FormatDateForSQL($_POST['Duedate']);
       
        $SQL_duedate="'\ " . $SQL_duedate . "\" . '";
        }
		
		
	
		
			$sql = "INSERT INTO lw_alerts(
					alerttitle,
					alertdesc,
					alertperformedby,
					startdate,
					duedate,
					recurrence
					)
				VALUES ('" . $_POST['Alerttitle'] . "',
				    '" . $_POST['Alertdesc'] . "',
					'" . $_POST['Alertperformedby'] . "',
					$SQL_startdate,
					$SQL_duedate,
					'" . $_POST['Recurrence'] . "'
					)";

			$ErrMsg = _('This Alert could not be added because');
			$result = DB_query($sql,$db,$ErrMsg);
						
				?>
	
    <script>
		
swal({   title: "Alert Inserted!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('lw_page_alerts.php'); //will redirect to your page
}, 2000); 


	</script>
                        
       <?php
                        	
			

} // end of if (isset($_POST['submit']))


if (isset($_POST['delete']))
 {

//the link to delete a selected record was clicked instead of the submit button

	$CancelDelete = 0;

	if ($CancelDelete==0)
	 { //ie not cancelled the delete as a result of above tests
		$sql="DELETE FROM lw_alerts WHERE alertid='" . $_POST['Alertid'] . "'";
		$result = DB_query($sql,$db);
		prnMsg( _('Alert') . ' ' . $_POST['Alertid'] . ' ' . _('has been deleted') . ' !','success');
		
		exit;
	} //end if Delete contact
}//end of if (isset($_POST['delete'])) condition

	
	// This is the start of the alerts on page load
	
	echo "<form method='post' action=" . $_SERVER['PHP_SELF'] . '>';

	?>
     <div class='uk-width-1-2' style="padding-bottom:10px">Alert Title
     <input tabindex=2  type="Text" name="Alerttitle" class="md-input" ></div>
	<div class='uk-width-1-2' style="padding-bottom:10px">Alert Description
     <input tabindex=2  type="Text" name="Alertdesc" class="md-input" ></div>
          
      <div class='uk-width-1-2' style="padding-bottom:10px">Alert Performed By
      <input tabindex=2  type="Text" name="Alertperformedby" class="md-input" ></div>
        
    <div class="uk-width-medium-2-1" style="padding-bottom:10px">
    <div class="uk-input-group">
    <div class="md-input-wrapper">Start Date<input class="md-input" type="text" name="Startdate" id="Startdate" data-uk-datepicker="{format:'DD/MM/YYYY'}"><span class="md-input-bar"></span></div>
    </div>
    
       
    <div class="uk-width-medium-2-1" style="padding-bottom:10px">
    <div class="uk-input-group">
    <div class="md-input-wrapper">Due Date<input class="md-input" type="text" name="Duedate" id="Duedate" data-uk-datepicker="{format:'DD/MM/YYYY'}"><span class="md-input-bar"></span></div>
    </div>
    
    <div style="float:right; position:absolute; margin-left:400px; top:75px">
       <fieldset><legend>Recurrence Frequency</legend>
      <input type="radio" name="Recurrence" id="daily" checked="checked" value=1 /> <label> Daily </label><br>
        <input type="radio" name="Recurrence" id="threedays" value=3 /><label> After 3 Days </label><br>
         <input type="radio" name="Recurrence" id="sevendays" value=7 /><label> After 7 Days </label><br>
          <input type="radio" name="Recurrence" id="fifteendays" value=15 /><label> After 15 Days </label><br>
           <input type="radio" name="Recurrence" id="onemonth" value=30 /><label> After 1 Month </label><br>
           <input type="radio" name="Recurrence" id="oneyear" value=365 /><label> After 1 Year </label><br>
        
       </fieldset>
    	 </div>
       
     
<?php

		echo "<div class='center'><input tabindex=20 type='submit' name='Submit' class='md-btn md-btn-primary' value='" . _('Save New') . "'>";
		echo '</div></form>';

?>

</body> 
</html>