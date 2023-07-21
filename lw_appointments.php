<?php

if(isset($_POST['submitappointment']))
{

if(!empty($_POST['Idhidden']))
{
//Old contact and new appointment
$sql = "UPDATE lw_contacts SET
			name='".strtoupper(trim($_POST['party']))."',
			address='".strtoupper(trim($_POST['Address']))."',
			landline='" . trim($_POST['Phone']) . "',
			mobile='".trim($_POST['Mobile'])."',
			email='" . trim($_POST['Email']) . "'
			WHERE id= '".(trim($_POST['Idhidden']))."'";
			$result=DB_query($sql,$db);				

$stmt= "INSERT INTO lw_appointments(appdate,
						apptime,
						party,
						handledby,
						status,
						reason
						)
				VALUES ('" .FormatDateForSQL($_POST['Appdate']). "',
						'" .$_POST['Apptime']. "',
					'" . trim($_POST['Idhidden']) . "',
					'" . trim($_POST['Handledby']) . "',
					'" . trim($_POST['appstatus']) . "',
					'" . trim($_POST['reason']) . "'
						)";

    $result1 = DB_query($stmt,$db);
	
	 $sqlappointid = "SELECT id FROM lw_appointments WHERE party='".trim($_POST['Idhidden'])."' ORDER BY id DESC LIMIT 1";
		$resultappointid = DB_query($sqlappointid,$db);
		$myrowappointid = DB_fetch_row($resultappointid);
		$appointid=$myrowappointid[0];
	  
	  $sqlfindings= "INSERT INTO lw_findings(
						appointid
						)
				VALUES (
					'" . trim($appointid) . "'
						)";

      $resultfindings = DB_query($sqlfindings,$db);  	  
	  
	  }elseif($_POST['Idhidden']=='')
	  {
	  //New contact and new appointment
	  $sql = "INSERT INTO lw_contacts(
			name,
			address,
			landline,
			mobile,
			email
			)
			VALUES ('".strtoupper(trim($_POST['party']))."',
			'".strtoupper(trim($_POST['Address']))."',
			'" . trim($_POST['Phone']) . "',
			'".trim($_POST['Mobile'])."',
			'" . trim($_POST['Email']) . "'
			)";
		
	$result = DB_query($sql,$db);
		
		$sqlcontactid = "SELECT id FROM lw_contacts WHERE name='".trim($_POST['party'])."'";
		$resultcontactid = DB_query($sqlcontactid,$db);
		$myrowcontactid = DB_fetch_row($resultcontactid);
		$partyid=$myrowcontactid[0];
				
		$stmt= "INSERT INTO lw_appointments(appdate,
						apptime,
						party,
						handledby,
						status,
						reason
						)
				VALUES ('" .FormatDateForSQL($_POST['Appdate']). "',
						'" .$_POST['Apptime']. "',
					'" . trim($partyid) . "',
					'" . trim($_POST['Handledby']) . "',
					'" . trim($_POST['appstatus']) . "',
					'" . trim($_POST['reason']) . "'
						)";

      $result1 = DB_query($stmt,$db);
	  
	  $sqlappointid = "SELECT id FROM lw_appointments WHERE party='".trim($partyid)."' ORDER BY id DESC LIMIT 1";
		$resultappointid = DB_query($sqlappointid,$db);
		$myrowappointid = DB_fetch_row($resultappointid);
		$appointid=$myrowappointid[0];
	  
	   $sqlfindings= "INSERT INTO lw_findings(
						appointid
						)
				VALUES (
					'" . trim($appointid) . "'
						)";

      $resultfindings = DB_query($sqlfindings,$db);		
	  
	  }  
	  
	  ?>
<script>
	
swal({   title: "Appointment Inserted!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('lw_appointments_alt.php'); //will redirect to your page
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
<input type="text" data-uk-datepicker="{format:'DD/MM/YYYY'}" name="srchdate" id="srchdate" style="font-weight:bold" class="md-input" value="<?php echo date("d-M-Y"); ?>"/></div>
<div class="uk-width-medium-2-4" align="right" style="padding-bottom:10px"></div>
<div class="uk-width-medium-1-4" align="right" style="padding-bottom:10px">
<input type="text" id="filter" name="filter" class="md-input" placeholder="Type to search" /></div>
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
			
			 $("#srchdate").change(function() {
				
				var srch_date=$("#srchdate").val().split("/");
				
				var sum1=srch_date[2]+'-'+srch_date[1]+'-'+srch_date[0];  
                //var record1 = new Date(sum1);
							
			        datagrid.editableGrid.filter(sum1, [2]);
					
					datagrid.editableGrid.clearFilter(); 

                    // To filter on some columns, you can set an array of column index 
                    //datagrid.editableGrid.filter1( $(this).val(), [0,3,5]);
                  });
			         // key typed in the filter field
                $("#filter").keyup(function() {
				
                    datagrid.editableGrid.filter( $(this).val());

                    // To filter on some columns, you can set an array of column index 
                    //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);
					
                  });
				datagrid.editableGrid.clearFilter();    
                     
			}; 
		</script>
        
            

              
                <!-- /Search Form Demo -->

<div class="md-fab-wrapper">

   <a class="md-fab md-fab-danger" href="#newappointment" data-uk-modal="{center:true}">
        <i class="material-icons">&#xE145;</i>
    </a>
</div>

<?php
						$DateString = Date($_SESSION['DefaultDateFormat']);
	
						$datetoday = new DateTime(FormatDateForSQL($DateString));   ?>

  <div class="uk-modal" id="newappointment" >
        <div class="uk-modal-dialog" style="margin-top:50px">
            <button class="uk-modal-close uk-close" type="button"></button>
                <div class="uk-modal-header">
                    <h3 class="uk-modal-title">Schedule New Appointment</h3>
                </div>             
                
                 <div class="uk-margin-medium-bottom">
                
                <form method='post' name='appointmentform' action="<?php echo $_SERVER['PHP_SELF']  . '?' . SID ; ?>">               
                <?php                                
$sqlappointment='SELECT id,name from lw_contacts' ;
  $resultappointment=DB_query($sqlappointment,$db);
  ?>
  
                <div class="uk-margin-bottom" style="color:#006633; font-weight:bold">Party Name
                <input list="Party" name="party" id="party" class="md-input">
                <input type="hidden" name="Idhidden" id="Idhidden" >
              
                <datalist name="Party" id="Party">
    <?php
	while ($myrow = DB_fetch_array($resultappointment)) {
       
			echo '<option VALUE="' . $myrow['name'] . '">' . $myrow['id'] . '</option>';
			
			
	} //end while loop</tr>
	DB_data_seek($resultappointment,0);
        echo '</datalist></div>';		
			                           
$sqluser='SELECT userid,realname from www_users' ;
  $resultuser=DB_query($sqluser,$db);
  
echo '<div class="uk-margin-bottom" style="color:#006633; font-weight:bold; padding-bottom:20px">Handled by';
?>
	
	<select name="Handledby" tabindex=3 id="Handledby" class="md-input">
    <?php
	while ($myrow = DB_fetch_array($resultuser)) {
       
			echo '<option VALUE="' . $myrow['userid'] . '">' . $myrow['realname'] . '</option>';
			
			
	} //end while loop</tr>
	DB_data_seek($resultuser,0);
        echo '</select></div>'; ?>
        
        
<div class="uk-width-medium-1-1" style="padding-bottom:0px">
<div class="uk-grid uk-grid-width-1-2 uk-grid-width-large-1-2">
  
<div class="uk-width-medium-1-2" style="padding-bottom:10px">Appointment Status

<select name="appstatus" tabindex=3 id="appstatus" class="md-input">
  <option VALUE="0">Pending</option>
  <option VALUE="1">Postponed</option>
  <option VALUE="2">Handled</option>
 </select></div>
        
                           
                                          
		<div class="uk-width-medium-1-2" style="padding-bottom:10px">
		Appointment Date<input class="md-input" type="text" id="Appdate" name="Appdate" data-uk-datepicker="{format:'DD/MM/YYYY', addClass: 'dropdown-modal'}" value="<?php echo date("d/m/Y"); ?>"></div>
        
		<div class="uk-width-medium-1-2" style="padding-bottom:10px">Appointment Time
 		<input class="md-input" type="text" id="Apptime" name="Apptime" data-uk-timepicker="{start:<?php echo date("H"); ?> }" value="<?php echo date("h:i"); ?>">
		</div>
        <div class="uk-width-medium-1-2" style="padding-bottom:10px">
		Address<input class="md-input" type="text" id="Address" name="Address"></div>
        
		<div class="uk-width-medium-1-2" style="padding-bottom:10px">Phone
 		<input class="md-input" type="text" id="Phone" name="Phone">
		</div>
        
        <div class="uk-width-medium-1-2" style="padding-bottom:10px">
		Mobile<input class="md-input" type="text" id="Mobile" name="Mobile"></div>
        
		<div class="uk-width-medium-1-2" style="padding-bottom:10px">Email
 		<input class="md-input" type="text" id="Email" name="Email">
		</div>
                                
        <div class="uk-width-medium-1-1" style="padding-bottom:10px">Reason
        <input type="text" class="md-input" id="reason" name="reason" />
        </div>
                                   
        <div class="uk-width-medium-1-2" style="padding-bottom:10px">                               
        <input type="submit" class="md-btn md-btn-primary" id="submitappointment" name="submitappointment" value="Save Appointment">
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

<script>
			
	$("#party").change( function() {
	
	$("#Idhidden").val('');
	
	$.ajax({
	url: 'addappointmentcontacts.php', // Url to which the request is send
	type: "POST",             // Type of request to be send, called as method
	dataType: "json",
	//data: new FormData(this),// Data sent to server, a set of key/value pairs (i.e. form fields and values	
	data: {
				'contact': $("#party").val()			
		  },
	
	success: function(response)   // A function to be called if request succeeds
	{
	$("#Idhidden").val(response[0]);
	$("#Address").val(response[2]);
	$("#Phone").val(response[3]);
	$("#Mobile").val(response[4]);
	$("#Email").val(response[6]);
	//$("#message").html(data);
	}
	
	});//end of ajax		
  
		});	
	
	</script>
        

 

	

