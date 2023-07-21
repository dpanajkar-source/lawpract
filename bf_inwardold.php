<?php 

file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Handler.php') ? require_once __DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Handler.php' : die('There is no such a file: Handler.php');
file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Config.php') ? require_once __DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Config.php' : die('There is no such a file: Config.php');


use AjaxLiveSearch\core\Config;
use AjaxLiveSearch\core\Handler;

if (session_id() == '') {
    session_start();
}

    Handler::getJavascriptAntiBot();
    $token = Handler::getToken();
    $time = time();
    $maxInputLength = Config::getConfig('maxInputLength');

$PageSecurity = 3;
include('includes/session.php');

?>

<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>

     <link rel="icon" type="image/png" href="assets/img/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="assets/img/favicon-32x32.png" sizes="32x32">

    <title>LawPract&trade;</title>


   <!-- additional styles for plugins -->
    
        <!-- chartist -->
        <link rel="stylesheet" href="bower_components/chartist/dist/chartist.min.css">
    
    <!-- uikit -->
    <link rel="stylesheet" href="bower_components/uikit/css/uikit.almost-flat.min.css" media="all">

    <!-- flag icons -->
    <link rel="stylesheet" href="assets/icons/flags/flags.min.css" media="all">

    <!-- altair admin -->
    <link rel="stylesheet" href="assets/css/main.css" media="all">
    
    <!-- Live Search Styles -->
    <link rel="stylesheet" href="css/fontello.css">
    <link rel="stylesheet" href="css/animation.css">
    <!--[if IE 7]>
    <link rel="stylesheet" href="css/fontello-ie7.css">
    <![endif]-->
       
    <link rel="stylesheet" type="text/css" href="css/ajaxlivesearch.min.css">
    
    <link rel="stylesheet" type="text/css" href="dist/sweetalert.css">
      
   <script src="dist/sweetalert-dev.js"></script>
    
  <script src="javascripts/MiscFunctions.js"></script>
    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
    <![endif]-->
    
 
</head>
<body class=" sidebar_main_open sidebar_main_swipe">

    <?php include("header.php"); ?>
    <?php include("menu.php"); 
    
   // echo '<script src = "' . $rootpath . '/javascripts/MiscFunctions.js"></script>';
    ?>

    <div id="page_content">
        <div id="page_content_inner">       
       
<!-- Main php code goes below -->
             
<?php     

//below is submit for notice
if (isset($_POST['Submit'])) 
{
    
				 if ($_POST['Inwarddt'] === "") 
			   {
				// echo 'reaching inwarddt null';
				 $Inwarddt = "NULL";
			   }else {
			   $Inwarddt=FormatDateForSQL($_POST['Inwarddt']);
				   
				   $Inwarddt="'\ " . $Inwarddt . "\" . '";
				   } 
  
	 	
			$sql = "INSERT INTO bf_inward(
					fileno,
					clientname,					
					inwarddt,
					inwardby,				
					remark)
				VALUES (
					
					'" . $_POST['Fileno'] . "',
					'" . $_POST['Clientname'] . "',
					$inwarddt,		  	
					'" . $_POST['Inwardby'] . "',
					'" . $_POST['Remark'] . "'					
					)";
					
		
			$result = DB_query($sql,$db);
				
			 		 $query=$sql;		
		
	$SQLArray = explode(' ', $sql);
	
	include('cust_audittrail.php');	
					
					?>	
                    
<script>
		
swal({   title: "Inward Details Entered!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('bf_inward.php'); //will redirect to your page
}, 2000); 


	</script>
						
	<?php		
		
        	}//end of insert
        

	

if (isset($_POST['delete']))
 {

//the link to delete a selected record was clicked instead of the submit button

	$CancelDelete = 0;

// PREVENT DELETES IF DEPENDENT RECORDS IN 'lw_Trans'

	/* $sql= "SELECT COUNT(*) FROM lw_trans WHERE brief_file='" . $_POST['Brief_File'] . "'";
	$result = DB_query($sql,$db);
	$myrow = DB_fetch_row($result);
	if ($myrow[0]>0) 
	{
		$CancelDelete = 1;
		prnMsg( 'This task cannot be deleted because there are transactions that refer to it','warn');
		echo '<br> ' . 'There are' . ' ' . $myrow[0] . ' ' . 'transactions against this case';


	}// end of if ($myrow[0]>0)  condition */
	
	if ($CancelDelete==0)
	 { //ie not cancelled the delete as a result of above tests
		$sql="DELETE FROM bf_inward WHERE fileno='" . $_POST['filenohidden'] . "'";
		$result = DB_query($sql,$db);
			 		 $query=$sql;		
		
	$SQLArray = explode(' ', $sql);
	
	include('cust_audittrail.php');	
	
		prnMsg( 'File No:' . ' ' . $_POST['filenohidden'] . ' ' . 'has been deleted' . ' !','success');
		
		exit;
	} //end if Delete notice record
}//end of if (isset($_POST['delete'])) condition


?>

  <div id="top_bar" style="height:48px">
        <div class="md-top-bar">
        
        <!--
            <div class="uk-width-large-10-12 uk-container-center">                             
                      
                 			<div class="uk-grid uk-grid-width-1-3 uk-grid-width-large-1-2">
                                 
                              <div class="uk-width-medium-2-3">
               <form method="POST" class="casesform" action="<?php echo $_SERVER['PHP_SELF']; ?>">
               
    <input type="text" class="md-input" id="Notice_no" name="Notice_no" placeholder="Type here Notice No for Update Mode">  </div>           
                                    
           </form>
                            </div> 
            </div>-->
        </div>
    </div>
	  
                     	<!-- Main code ends   -->               
                          
                      <?php echo "<form method='post' action=" . $_SERVER['PHP_SELF'] . '>'; 
					
         //New md-card for party and oppo party
echo '<div class="md-input-wrapper"><div class="md-card"><div class="md-card-content">';

  echo '<h4 class="heading_a">File Inward / Outward</h4>';  
echo '<div class="uk-grid uk-grid-width-1-2 uk-grid-width-large-1-2">';   
  
echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Inward No
   <input class="md-input" type="text" name="Inwardno" id="Inwardno" placeholder="Type New file no here"> </div>';
  
		
echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Client Name*';
echo '<input type="text" name="Clientname" id="Clientname" class="md-input" placeholder="Type New Client Name" tabindex="8"></div>';
 echo '<input type="hidden" name="Casepartyid" id="Casepartyid">';
 echo '<input type="hidden" name="Casepartynamehidden" id="Casepartynamehidden">'; ?> 
 
<div class="uk-width-medium-1-2" style="padding-bottom:10px">Work Type
  
   <select name="Worktype" id="Worktype" class="md-input">
   <option>Property Related</option>
   <option>Bank/Finance</option>
   <option>Search Title</option>  
   <option>Court Matters</option> 
   </select>
    </div>
   
  
<?php
 echo '<div class="uk-width-medium-1-2" style="padding-bottom:3px"><label>Inward Date</label>
     <input class="md-input" type="text" name="Inwarddt" id="Inwarddt" data-uk-datepicker="{format:"DD/MM/YYYY"}"></div>';         
   
echo '<div class="uk-width-medium-1-2" style="padding-bottom:3px"><label>Attention To </label>';
    echo '<input class="md-input" type="text" name="Attentionto" id="Attentionto"/>';
     echo '</div>';
  
     echo '<div class="uk-width-medium-1-2" style="padding-bottom:3px">Remark';
     echo '<input type="text" name="Remark" id="Remark" class="md-input"/></div>';


  echo '<div class="uk-form-row">
<input tabindex=20 type="submit" name="Submit" class="md-btn md-btn-primary" value="Save">
</div>';
echo '</div></div></div></div></div>'; 
		 
      ?>

                           
         
<script>  

	//below is for fetching courtcaseno from lw_cases
	jQuery("#Bank_name").ajaxlivesearch({
        loaded_at: <?php echo $time; ?>,
        token: <?php echo "'" . $token . "'"; ?>,
        max_input: <?php echo $maxInputLength; ?>,
        onResultClick: function(e, data) {
            // get the index 1 (second column) value
            var bank_code = jQuery(data.selected).find('td').eq('0').text();
			
			var bank_name = jQuery(data.selected).find('td').eq('1').text();
			
			var contact_person = jQuery(data.selected).find('td').eq('2').text();
			var landline = jQuery(data.selected).find('td').eq('3').text();
			
			var bank_id = jQuery(data.selected).find('td').eq('4').text();
						
            // set the input value
            jQuery('#Bank_name').val(bank_name);
			
			jQuery('#Bank_code').val(bank_code);  
			
			jQuery('#Bank_id').val(bank_id);  
			      					
								
			// hide the result
           jQuery("#Bank_name").trigger('ajaxlivesearch:hide_result');
        },
        onResultEnter: function(e, data) {
            // do whatever you want
            //jQuery("#Courtcaseno").trigger('ajaxlivesearch:search', {query: 'test'});
        },
        onAjaxComplete: function(e, data) {
        jQuery('#Bank_name').val(bank_name);
			
			jQuery('#Bank_code').val(bank_code);
			
			jQuery('#Bank_id').val(bank_id); 
        }
    });
	</script>          
               
               
               
       
      <!--- End of the Page Content    --->      

                            
<?php include("footersrc.php");      ?>
 


	
 