<?php

if(isset($_POST['Submit']))
{

include('server_con.php');

function Dateconvert($dt)
{
if (strpos($dt,'/')) {
		$Date_Array = explode('/',$dt);
	} elseif (strpos ($dt,'-')) {
		$Date_Array = explode('-',$dt);
	} elseif (strpos ($dt,'.')) {
		$Date_Array = explode('.',$dt);
	} elseif (strlen($dt)==6) {
		$Date_Array[0]= substr($dt,0,2);
		$Date_Array[1]= substr($dt,2,2);
		$Date_Array[2]= substr($dt,4,2);
	} elseif (strlen($dt)==8) {
		$Date_Array[0]= substr($dt,0,4);
		$Date_Array[1]= substr($dt,4,2);
		$Date_Array[2]= substr($dt,6,2);
	}
	
	//to modify assumption in 2030

	if ((int)$Date_Array[2] <60) {
		$Date_Array[2] = '20'.$Date_Array[2];
	} elseif ((int)$Date_Array[2] >59 AND (int)$Date_Array[2] <100) {
		$Date_Array[0] = '19'.$Date_Array[2];
	} elseif ((int)$Date_Array[2] >9999) {
		$Date_Array=0;
	}

		$dt=$Date_Array[2].'-'.$Date_Array[1].'-'.$Date_Array[0];  //date is converted to mysql format!!!	
		
return $dt;

}

$courtcaseno=trim($_POST['Courtcasenohidden']);

$stage=trim($_POST['Stage']);

$brief_file=trim($_POST['Brief_filehidden']);

$nextdate=trim($_POST['Nextdate']);	
$otherdate=trim($_POST['Otherdate']);

$party=trim($_POST['Partyhidden']);

$oppoparty=trim($_POST['Oppopartyhidden']);	
$currentdate=trim($_POST['Currentdate']);

// Otherdate will be converted to sql format		
	if ($currentdate=="") 
		   {
			  $currentdate ="NULL";
		   }
		   
		   	
	if ($currentdate!="NULL") 
		   {		
	
		$currentdate=Dateconvert($currentdate);  //Otherdate is converted!!!		
		
		   }//end of other date condition   
		   

 if ($nextdate=="") 
		   {
			  $nextdate ="NULL";
		   }		   	   
		   
		// Otherdate will be converted to sql format		
	if ($otherdate=="") 
		   {
			  $otherdate ="NULL";
		   }
		   
		   	
	if ($otherdate!="NULL") 
		   {		
	
		$otherdate=Dateconvert($otherdate);  //Otherdate is converted!!!		
		
		   }//end of other date condition   	

	
	$result=mysqli_query($con,"SELECT * FROM lw_trans WHERE brief_file='" . trim($brief_file) . "' ORDER BY currtrandate DESC LIMIT 1");
	
	$myrownew=mysqli_fetch_array($result);
		
	if (!empty($myrownew[0])) 
	{ 				
echo '<span style="color:#FF0000; font-weight:bold"> Cannot enter this record as atleast one entry is already entered in the Diary. Please filter the diary or use full diary to view the record</span>';	

		}
		else 
		{	
		// first entry in the diary
	$result=mysqli_query($con,"SELECT * FROM lw_cases where brief_file='" . trim($brief_file) ."'");	
	$myrownew=mysqli_fetch_array($result);	
	
	// nextdate will be converted to sql format	
		
	if ($nextdate!="NULL") 
		   {		   
		$nextdate=Dateconvert($nextdate); //nextdate is converted!!!
		
           }//end of next date condition
		   
		  		
	if($nextdate=="NULL")
	{
	 $nextdate = "NULL";
  		 }else {	
	$nextdate="'\ " . $nextdate . "\" . '";
	     }
		 
	if($otherdate=="NULL")
	{
	 $otherdate = "NULL";
  		 }else {	
	$otherdate="'\ " . $otherdate . "\" . '";
	     }
	
		
		$stmt= "INSERT INTO lw_trans (brief_file,
					currtrandate,
					prevcourtdate,
					courtname,
					courtcaseno,
					party,
					oppoparty,
					stage,
					nextcourtdate
					)
			VALUES ('" . trim($brief_file) . "',
				$otherdate,
				 NULL,
				'" . trim($myrownew['courtid']) . "',
				'" . trim($courtcaseno) . "',
				'" . trim($myrownew['party']) . "',
				'" . trim($myrownew['oppoparty']) . "',
				'" . trim($stage) . "',
				$nextdate
				)";
		
		$result=mysqli_query($con,$stmt);
				
				// for next date diary entry 
			if ($nextdate!="NULL") 
				{
				
	$result=mysqli_query($con,"SELECT * FROM lw_trans WHERE brief_file='" . trim($brief_file) . "' ORDER BY currtrandate DESC LIMIT 1");
	
	$myrownew=mysqli_fetch_array($result);
			$stmtnextdiary= "INSERT INTO lw_trans (brief_file,
					currtrandate,
					prevcourtdate,
					courtname,
					courtcaseno,
					party,
					oppoparty,
					stage					
					)
			VALUES ('" . trim($brief_file) . "',
				$nextdate,
				'" . trim($myrownew['currtrandate']) . "',
				'" . trim($myrownew['courtname']) . "',
				'" . trim($courtcaseno) . "',
				'" . trim($myrownew['party']) . "',
				'" . trim($myrownew['oppoparty']) . "',
				'" . trim($myrownew['stage']) . "'				
				)";
		
			$result=mysqli_query($con,$stmtnextdiary);	
				}
		}		
		
			$stmt = "UPDATE lw_cases SET
			  		stage='" . trim($_POST['stage']) . "'
					WHERE brief_file = '" . trim($brief_file) . "'";
	
	$result=mysqli_query($con,$stmt);
	
		?>
        	
<script>		
swal({   title: "",   text: "Will close in 10 seconds.",   timer: 10000,   showConfirmButton: false });

setTimeout(function () {
 window.close();
}, 10000);  
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

</div>
  <?php           
  
echo ' <div class="uk-grid uk-grid-medium data-uk-grid-margin">
                <div class="uk-width-medium-2-2 uk-width-medium-2-2">
                <div class="md-card" style="overflow:auto">
                <div  class="md-card-content">';                      
	
echo '<div class="uk-form-row">
       <div>
	   <div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">';
	                        
 echo '<div class="uk-width-medium-1-1" style="padding-bottom:10px">          
      <input type="text" name="Courtcaseno" id="Courtcaseno" class="md-input" placeholder="Type to search(brief_file,name,mobile,courtcaseno)" tabindex="1"></div>';
		   
            echo '<input type="hidden"  name="Courtcasenohidden" id="Courtcasenohidden">';
  
		 echo '<div class="uk-width-medium-1-5" style="padding-bottom:10px">Brief_file No
			<input type="text" class="md-input" name="Brief_filehidden" id="Brief_filehidden" readonly></div>';	
			
			echo '<div class="uk-width-medium-2-5" style="padding-bottom:10px">Party
			   <input class="md-input" type="text" name="Partyhidden" id="Partyhidden" readonly></div>';	
			   
			echo '<div class="uk-width-medium-2-5" style="padding-bottom:10px">Opposite Party
				  <input class="md-input" type="text" name="Oppopartyhidden" id="Oppopartyhidden" readonly></div>';	
			echo '<input type="hidden" name="Currentdate" id="Currentdate">';	
			
 ?>
      <div class="uk-width-medium-1-5" style="padding-bottom:10px">
      Select Diary Date:
      <input class="md-input" data-uk-datepicker="{format:'DD/MM/YYYY'}" name="Otherdate" id="Otherdate" tabindex="3" value="<?php echo date("d/m/Y"); ?>">
     </div> 
            
     
      <div class="uk-width-medium-1-5" style="padding-bottom:10px">
      Select Next Court Date:
     
            <input class="md-input" data-uk-datepicker="{format:'DD/MM/YYYY'}" name="Nextdate" id="Nextdate" tabindex="4">
     </div> 
     
 
 
 <?php
$sqlstage='SELECT stageid,stage from lw_stages';
  $resultstage=DB_query($sqlstage,$db);
  
echo '<div class="uk-width-medium-2-5" style="padding-bottom:10px">Change Stage :';
?>
	
	<select name="Stage" tabindex="5" id="Stage" class="md-input" >
    <?php
	while ($myrow = DB_fetch_array($resultstage)) {
       
			echo '<option VALUE="' . $myrow['stageid'] . '">' . $myrow['stage'] . '</option>';
			
			
	} //end while loop</tr>
	DB_data_seek($result,0);
        echo '</select></div>'; 
             
		 ?>
        

          <div class="uk-width-medium-1-5 row tright" style="padding-bottom:10px">
              <input type="submit" name="Submit" id="Submit" tabindex="6" class="md-btn md-btn-primary" value="Add New Row">   </div>
            
        </div></div></div> </div></div>
        
                        
 </form>
 
  
</div>

</div>
</div>                  

  </div>

</div>
</div>            
              
			
<script type="text/javascript">
		
            var datagrid = new DatabaseGrid();
			window.onload = function() {   		       
			  
				$("#addbutton").click(function() {
                  
                });
			  
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

 <script src="bower_components/jquery-ui/jquery-ui.js" ></script>