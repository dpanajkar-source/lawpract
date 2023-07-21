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
   
   <script src = "javascripts/MiscFunctions.js"></script>
    

    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
    <![endif]-->
    
 
</head>
<body class=" sidebar_main_open sidebar_main_swipe">

    <?php include("header.php"); ?>
    <?php include("menu.php"); 
    
   
    ?>

    <div id="page_content">
        <div id="page_content_inner">       
       
<!-- Main php code goes below -->
             
<?php     

//below is submit for notice
if (isset($_POST['Submit'])) 
{
    
    if (empty($_POST['Noticedt']))
   {
    // echo 'reaching noticedt null';
  	 $Noticedt = "NULL";
   }else {
   $Noticedt=FormatDateForSQL($_POST['Noticedt']);
       
       $Noticedt="'\ " . $Noticedt . "\" . '";
       
   }
	 
           
if (empty($_POST['Receiptdt'])) 
   {
     //echo 'reaching receiptdt null';
  	 $Receiptdt = "NULL";
   }else {
   $Receiptdt=FormatDateForSQL($_POST['Receiptdt']);
       
       $Receiptdt="'\ " . $Receiptdt . "\" . '";       
    
   }

if (empty($_POST['Noticereturnenvelopdt'])) 
   {
     //echo 'reaching Noticereturnenvelopdt null';
  	 $Noticereturnenvelopdt = "NULL";
   }else {
   $Noticereturnenvelopdt=FormatDateForSQL($_POST['Noticereturnenvelopdt']);
       
       $Noticereturnenvelopdt="'\ " . $Noticereturnenvelopdt . "\" . '";
       
   }   


 if (empty($_POST['Claimdate'])) 
   {
    // echo 'reaching Handdeldt null';
  	 $Claimdate = "NULL";
   }else {
   $Claimdate=FormatDateForSQL($_POST['Claimdate']);
       
       $Claimdate="'\ " . $Claimdate . "\" . '";
      
}   
    
    //below are date values formatting for notice reply
    
    if (empty($_POST['Replydt'])) 
   {
   //  echo 'reaching noticedt null';
  	 $Replydt = "NULL";
   }else {
   $Replydt=FormatDateForSQL($_POST['Replydt']);
       
       $Replydt="'\ " . $Replydt . "\" . '";
     
   }
	 
           
if (empty($_POST['Replyreceiptdt'])) 
   {
    // echo 'reaching Receiptdt null';
  	 $Replyreceiptdt = "NULL";
   }else {
   $Replyreceiptdt=FormatDateForSQL($_POST['Replyreceiptdt']);
       
       $Replyreceiptdt="'\ " . $Replyreceiptdt . "\" . '";       
    
   }

if (empty($_POST['Replyreturnenvelopdt'])) 
   {
    // echo 'reaching Noticereturnenvelopdt null';
  	 $Replyreturnenvelopdt = "NULL";
   }else {
   $Replyreturnenvelopdt=FormatDateForSQL($_POST['Replyreturnenvelopdt']);
       
       $Replyreturnenvelopdt="'\ " . $Replyreturnenvelopdt . "\" . '";      
   }



if (empty($_POST['Replyclaimdate'])) 
   {
    // echo 'reaching Handdeldt null';
  	 $Replyclaimdate = "NULL";
   }else {
   $Replyclaimdate=FormatDateForSQL($_POST['Replyclaimdate']);
       
       $Replyclaimdate="'\ " . $Replyclaimdate . "\" . '";
      
}
   //below are date values formatting for notice rejoinder
    
     if (empty($_POST['Rejdt'])) 
   {
     //echo 'reaching noticedt null';
  	 $Rejdt = "NULL";
   }else {
   $Rejdt=FormatDateForSQL($_POST['Rejdt']);
       
       $Rejdt="'\ " . $Rejdt . "\" . '";
       
    }
	 
           
if (empty($_POST['Rejreceiptdt'])) 
   {
    // echo 'reaching Receiptdt null';
  	 $Rejreceiptdt = "NULL";
   }else {
   $Rejreceiptdt=FormatDateForSQL($_POST['Rejreceiptdt']);
       
       $Rejreceiptdt="'\ " . $Rejreceiptdt . "\" . '";
       
   }

if (empty($_POST['Rejreturnenvelopdt'])) 
   {
    // echo 'reaching Noticereturnenvelopdt null';
  	 $Rejreturnenvelopdt = "NULL";
   }else {
   $Rejreturnenvelopdt=FormatDateForSQL($_POST['Rejreturnenvelopdt']);
       
       $Rejreturnenvelopdt="'\ " . $Rejreturnenvelopdt . "\" . '";
       
   }


if (empty($_POST['Rejclaimdate'])) 
   {
    // echo 'reaching Handdeldt null';
  	 $Rejclaimdate = "NULL";
   }else {
   $Rejclaimdate=FormatDateForSQL($_POST['Rejclaimdate']);
       
       $Rejclaimdate="'\ " . $Rejclaimdate . "\" . '";
      
	}

//first check if $_POST['Caseparty'] value is already there in the lw_contacts table

					
		if (empty($_POST['Casepartyid']))
		{
		
		$sql = "INSERT INTO lw_contacts(
			name
			)
			VALUES ('".strtoupper(trim($_POST['Casepartynamehidden']))."'
			)";
		$result = DB_query($sql,$db);
		
		$sqlcontactid = "SELECT id FROM lw_contacts WHERE name='".trim($_POST['Casepartynamehidden'])."'";
		$resultcontactid = DB_query($sqlcontactid,$db);
		$myrowcontactid = DB_fetch_row($resultcontactid);
		$_POST['Casepartyid']=$myrowcontactid[0];
						
		}		
		
		
		//first check if $_POST['Caseoppoparty'] value is already there in the lw_contacts table
		
							
		if (empty($_POST['Caseoppopartyid']))
		{
		$sql = "INSERT INTO lw_contacts(
			name		
			)
			VALUES ('".strtoupper(trim($_POST['Caseoppopartynamehidden']))."'
			)";
				
		$result = DB_query($sql,$db);
		
		$sqlcontactid = "SELECT id FROM lw_contacts WHERE name='".trim($_POST['Caseoppopartynamehidden'])."'";
		$resultcontactid = DB_query($sqlcontactid,$db);
		$myrowcontactid = DB_fetch_row($resultcontactid);
		$_POST['Caseoppopartyid']=$myrowcontactid[0];
			
		}
   

if(empty($_POST['Notice_idhidden']))
               {		
			     
    $sqlnoticecr = "INSERT INTO lw_noticecr(
		notice_no,
		party,
		oppoparty
		)
		VALUES ('".trim($_POST['Notice_cr'])."',
				'".trim($_POST['Casepartyid'])."',
				'".trim($_POST['Caseoppopartyid'])."'
		)";
		
		$result = DB_query($sqlnoticecr,$db);
		
		$sqlnoticecrid="SELECT noticeid,notice_no from lw_noticecr WHERE notice_no='" . trim($_POST['Notice_cr']) . "'";
		
		$resultnoticecrid = DB_query($sqlnoticecrid,$db);
		
		$myrownoticecrid=DB_fetch_array($resultnoticecrid);
  
 			 }


    
		if (!empty($_POST['Notice_idhidden'])) // This is the update mode for lw_notices
		{			 
		            
			  $sql = "UPDATE lw_notices SET	
					noticedt=$Noticedt,
					sendmode='" . $_POST['Sendmode'] . "',
					postrecptno='" . $_POST['Noticepostrecptno'] . "',
					receiptdt=$Receiptdt,					
					claimdate=$Claimdate,
					returnenvelopdt=$Noticereturnenvelopdt,
			  		receivedby='" . $_POST['Receivedby'] . "',			  	
					noticefees='" . $_POST['Noticefees'] . "',
					postage='" . $_POST['Postage'] . "',
					othercharges='" . $_POST['Othercharges'] . "',
			  		remark='" . $_POST['Remark'] . "'					
					WHERE noticeno = '" . $_POST['Notice_idhidden'] . "'";		
            
            $ErrMsg = _('This Notice could not be updated because');
			$result = DB_query($sql,$db,$ErrMsg);
								
			// end of if (!isset($_POST['New'])) for update mode
   					

		}else  //insert mode for new notice info starts
		{ //it is a new notice info				 
               
			$sql = "INSERT INTO lw_notices(
					noticeno,
					noticedt,
					sendmode,					
					postrecptno,
					receiptdt,				
					claimdate,
					returnenvelopdt,
			  		receivedby,			  	
					noticefees,
					postage,
					othercharges,
					remark)
				VALUES ('" . $myrownoticecrid[0] . "',
					$Noticedt,
					'" . $_POST['Sendmode'] . "',
					'" . $_POST['Noticepostrecptno'] . "',
					$Receiptdt,					
					$Claimdate,
					$Noticereturnenvelopdt,
			  		'" . $_POST['Receivedby'] . "',			  	
					'" . $_POST['Noticefees'] . "',
					'" . $_POST['Postage'] . "',
					'" . $_POST['Othercharges'] . "',
					'" . $_POST['Remark'] . "'					
					)";
					
			$result = DB_query($sql,$db);			
   
		
	//create notice due date now
	if(!empty($_POST['Noticedt']))
	{
		 $Noticeduedate=FormatDateForSQL($_POST['Noticedt']);
			 
		$duedate = new DateTime($Noticeduedate);
		$duedate->add(new DateInterval('P30D')); 
		
  		 $SQL_duedate=$duedate->format('Y-m-d');       
       	 $SQL_duedate="'\ " . $SQL_duedate . "\" . '";   	
		
	$_POST['Alerttitle']='Notice '.$myrownoticecrid[1];
	$_POST['Alertdesc']='15 Days Completed';		
	$_POST['Recurrence']=15;
	$_POST['Alertperformedby']="SYSTEM";		
		
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
					$Noticedt,
					$SQL_duedate,
					'" . $_POST['Recurrence'] . "'
					)";

			$result = DB_query($sql,$db);
			
		}	
			
				
		}//end of insert
        
        //update and insert for notice reply
			
		if (!empty($_POST['Notice_idhidden'])) // This is the update mode ie user is editing a notice reply
		{
				
				$sql = "UPDATE lw_noticereply SET
				replydt=$Replydt,
				replysendmode='" . $_POST['Replysendmode'] . "',
				replypostrecptno='" . $_POST['Replypostrecptno'] . "',
				replyreceiptdt=$Replyreceiptdt,				
				replyclaimdate=$Replyclaimdate,
				replyreturnenvelopdt=$Replyreturnenvelopdt,
				replyreceivedby='" . $_POST['Replyreceivedby'] . "',			
				replynoticefees='" . $_POST['Replynoticefees'] . "',
				replypostage='" . $_POST['Replypostage'] . "',
				replyothercharges='" . $_POST['Replyothercharges'] . "',
				replyremark='" . $_POST['Replyremark'] . "'
				WHERE noticeno = '" . $_POST['Notice_idhidden'] . "'";
					
			
            $ErrMsg = _('This Notice could not be updated because');
			$result = DB_query($sql,$db,$ErrMsg);
				
		
        }
      else  //insert mode for new notice reply info starts
		{ //it is a new notice reply info		
		
			$sql = "INSERT INTO lw_noticereply(
			noticeno,
			replydt,
			replysendmode,
			replypostrecptno,
			replyreceiptdt,			
			replyclaimdate,
			replyreturnenvelopdt,
			replyreceivedby,		
			replynoticefees,
			replypostage,
			replyothercharges,
			replyremark
            )
			VALUES (
			'" . $myrownoticecrid[0] . "',
			$Replydt,
			'" . $_POST['Replyendmode'] . "',
			'" . $_POST['Replypostrecptno'] . "',
			$Replyreceiptdt,		
			$Replyclaimdate,
			$Replyreturnenvelopdt,
			'" . $_POST['Replyreceivedby'] . "',		
			'" . $_POST['Replynoticefees'] . "',
			'" . $_POST['Replypostage'] . "',
			'" . $_POST['Replyothercharges'] . "',
			'" . $_POST['Replyremark'] . "'
			)";

			$ErrMsg = _('This Notice Reply could not be added because');
			$result = DB_query($sql,$db,$ErrMsg);	
			
				
	//create notice due date now
	if(!empty($Replydt))
	{
		 $Noticeduedate=FormatDateForSQL($Replydt);
			 
		$duedate = new DateTime($Noticeduedate);
		$duedate->add(new DateInterval('P30D')); 
		
  		 $SQL_duedate=$duedate->format('Y-m-d');       
       	 $SQL_duedate="'\ " . $SQL_duedate . "\" . '";   	
		
	$_POST['Alerttitle']='Notice '.$myrownoticecrid[1];
	$_POST['Alertdesc']='15 Days Completed';		
	$_POST['Recurrence']=15;
	$_POST['Alertperformedby']="SYSTEM";		
		
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
					$Replydt,
					$SQL_duedate,
					'" . $_POST['Recurrence'] . "'
					)";

			$result = DB_query($sql,$db);
			
		}			

				
		}//end of insert new notice reply info ends
        
        
    //put update and insert for notice rejoinder
 	
		if (!empty($_POST['Notice_idhidden'])) // This is the update mode ie user is editing a notice rejoinder
		{
		            
            $sql = "UPDATE lw_noticerejoinder SET
				rejdt=$Rejdt,
				rejsendmode='" . $_POST['Rejsendmode'] . "',
				rejpostrecptno='" . $_POST['Rejpostrecptno'] . "',
				rejreceiptdt=$Rejreceiptdt,				
				rejclaimdate=$Rejclaimdate,
				rejreturnenvelopdt=$Rejreturnenvelopdt,
				rejreceivedby='" . $_POST['Rejreceivedby'] . "',			
				rejnoticefees='" . $_POST['Rejnoticefees'] . "',
				rejpostage='" . $_POST['Rejpostage'] . "',
				rejothercharges='" . $_POST['Rejothercharges'] . "',
				rejremark='" . $_POST['Rejremark'] . "'
				WHERE noticeno = '" . $_POST['Notice_idhidden'] . "'";
		
			$ErrMsg = _('The Notice Rejoinder could not be updated because');
			$result = DB_query($sql,$db,$ErrMsg);
					

		} //end of (!isset($_POST['New'])) ie update mode if condition ends here

		else  //insert mode for new notice rejoinder info starts
		{ //it is a new notice rejoinder	
									
		$sql = "INSERT INTO lw_noticerejoinder(
			noticeno,
			rejdt,
			rejsendmode,
			rejpostrecptno,
			rejreceiptdt,			
			rejclaimdate,
			rejreturnenvelopdt,
			rejreceivedby,			
			rejnoticefees,
			rejpostage,
			rejothercharges,
			rejremark)
			VALUES (
			'" . $myrownoticecrid[0] . "',
			$Rejdt,
			'" . $_POST['Rejsendmode'] . "',
			'" . $_POST['Rejpostrecptno'] . "',
			$Rejreceiptdt,	
			$Rejclaimdate,
			$Rejreturnenvelopdt,
			'" . $_POST['Rejreceivedby'] . "',
			'" . $_POST['Rejnoticefees'] . "',
			'" . $_POST['Rejpostage'] . "',
			'" . $_POST['Rejothercharges'] . "',
			'" . $_POST['Rejremark'] . "'
			)";

			$ErrMsg = _('This Notice rejoinder could not be added because');
			$result = DB_query($sql,$db,$ErrMsg);
			
	}//end of rejoinder					
					?>	
                    
<script>
		
swal({   title: "Notice/Reply/Rejoinder Details Entered!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('lw_notices_alt.php'); //will redirect to your page
}, 2000); 


	</script>
						
	<?php		        
        
	} // end of submit
	

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
		prnMsg( _('This task cannot be deleted because there are transactions that refer to it'),'warn');
		echo '<br> ' . _('There are') . ' ' . $myrow[0] . ' ' . _('transactions against this case');


	}// end of if ($myrow[0]>0)  condition */
	
	if ($CancelDelete==0)
	 { //ie not cancelled the delete as a result of above tests
		$sql="DELETE FROM lw_notices WHERE noticeno='" . $_POST['Notice_nohidden'] . "'";
		$result = DB_query($sql,$db);
		prnMsg( _('Notice No:') . ' ' . $_POST['Notice_nohidden'] . ' ' . _('has been deleted') . ' !','success');
		
		exit;
	} //end if Delete notice record
}//end of if (isset($_POST['delete'])) condition


?>

  <div id="top_bar" style="height:48px">
        <div class="md-top-bar">
        
        
            <div class="uk-width-large-10-12 uk-container-center">                             
                      
                 			<div class="uk-grid uk-grid-width-1-3 uk-grid-width-large-1-2">
                                 
                              <div class="uk-width-medium-2-3">
               <form method="POST" class="casesform" action="<?php echo $_SERVER['PHP_SELF']; ?>">
               
    <input type="text" class="md-input" id="Notice_no" name="Notice_no" placeholder="Type here Notice No for Update Mode">  </div>           
                                    
           </form>
                            </div> 
            </div>
        </div>
    </div>
                     	<!-- Main code ends -->                   
                          
                         <?php echo "<form method='post' action=" . $_SERVER['PHP_SELF'] . '>'; ?>
                             
  <!----------------------------notice sent div here-------------->
 
     					
<!-- <label>Notice No.</label>   --> 
       <?php   
	   
         //New md-card for party and oppo party
echo '<div class="md-input-wrapper"><div class="md-card"><div class="md-card-content">';


echo '<div class="uk-grid uk-grid-width-1-2 uk-grid-width-large-1-2" style="margin-right:15px">';

  echo '<div class="uk-width-medium-1-2"><h4 class="heading_a">CREATE NOTICE NO</h4></div>';
  
echo '<div class="uk-width-medium-1-2" align="right" style="padding-right:30px"> <span class="menu_title" style="text-decoration:underline; cursor:pointer" onclick="javascript:MM_openbrwindow(\'Manualnoticecreationmaintenance.php\',600,400);"><i class="material-icons md-color-green-500">&#xE887;</i></span>
              </div>';                
  
  
echo '<div class="uk-width-medium-1-5" style="padding-bottom:10px; padding-top:35px">Notice No new
   <input class="md-input" tabindex="1" type="text" name="Notice_cr" id="Notice_cr" placeholder="Type New notice no here"> </div>
    ';	
  
echo '<div class="uk-width-medium-2-5" style="padding-bottom:10px; padding-top:10px">Party Name:*';
echo '<input type="text" name="Casepartyname" id="Casepartyname" class="Casepartyname" placeholder="Type New Party Name or Select From List..." tabindex="2">';

 echo '<input type="hidden" name="Casepartyid" id="Casepartyid">';
 echo '<input type="hidden" name="Casepartynamehidden" id="Casepartynamehidden">'; 
echo '</div>'; 

echo '<div class="uk-width-medium-2-5" style="padding-bottom:10px; padding-top:10px">Opposition Party Name:*';
echo '<input type="text" class="Caseoppopartyname" name="Caseoppopartyname" id="Caseoppopartyname" placeholder="Type New Opposite Party Name or Select From List..." tabindex="3"/>';

echo '<input type="hidden" name="Caseoppopartyid" id="Caseoppopartyid">';
echo '<input type="hidden"  name="Caseoppopartynamehidden" id="Caseoppopartynamehidden">';
echo '</div></div></div></div></div>'; 
		 
                            
                      
          
 $DateString = Date($_SESSION['DefaultDateFormat']); 
 ?>

     <div class="md-card">
                          <div class="md-card-content">
        					 <div class="md-input-wrapper">
                            
   
  <!----------------------------notice SEND div here-------------->
 
       
   <h4 class="heading_a">NOTICE SEND</h4>
    
                             
 <div class="uk-width-medium-1-1" style="padding-bottom:0px; padding-top:20px">
        <div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">    
        <?php      
/*$Statementsent= "SELECT count(id) FROM lw_notices";
								$resultsent=DB_query($Statementsent,$db);
								$myrowsent=DB_num_rows($resultsent);
							
								
								
									echo '<div class="uk-width-medium-2-6" style="padding-bottom:3px; padding-top:10px">Notice Sent Last No: </td><td style="text-align:right">' . $myrowsent . '</div>';
								
$Statementreply= "SELECT count(replydt) FROM lw_noticereply WHERE lw_noticereply.replydt LIKE '%" . $curryear .'-' . $currmonth . '-' . "%' ";
								$resultreply=DB_query($Statementreply,$db);
								$myrowsreply=DB_num_rows($resultreply);
								
								echo '<div class="uk-width-medium-2-6" style="padding-bottom:3px; padding-top:10px">Notice Received Last No  : ' . $myrowsreply . '</div>';
								
                                 <div class="uk-width-medium-2-6" style="padding-bottom:3px; padding-top:10px"></div> */?>
                                 
  <div class="uk-width-medium-2-6" style="padding-bottom:3px; padding-top:10px"><label>Notice No</label> 
  <input class="md-input" type="TEXT" name="Notice_send" id="Notice_send" readonly>
  
   <input class="md-input" type="hidden" name="Notice_idhidden" id="Notice_idhidden" readonly></div>
  
          
    <div class="uk-width-medium-1-6" style="padding-bottom:3px; padding-top:10px"><label>Notice Date</label>
<input class="md-input" tabindex="4" type="text" name="Noticedt" id="Noticedt" data-uk-datepicker="{format:'DD/MM/YYYY'}">
    </div>
    
     <div class="uk-width-medium-1-6" style="padding-bottom:3px; padding-top:10px">Send Mode
		<select name="Sendmode" id="Sendmode" tabindex="5" class="md-input">
 		<option VALUE="NULL"></option>
 		<option VALUE="RPAD">RPAD</option>
 		<option VALUE="UPC">UPC</option>
        <option VALUE="RPAD+UPC">RPAD + UPC</option>
        <option VALUE="By Hand">By Hand</option>
        <option VALUE="Courier">Courier</option>
 		</select></div> 


            <div class="uk-width-medium-1-6" style="padding-bottom:3px; padding-top:10px"><label>Receipt Date</label>
      <input class="md-input" type="text" tabindex="6" name="Receiptdt" id="Receiptdt" data-uk-datepicker="{format:'DD/MM/YYYY'}"></div>       

        
     <div class="uk-width-medium-1-6" style="padding-bottom:3px; padding-top:10px"><label>Receipt No </label>
     <input type="text" name="Noticepostrecptno" tabindex="7" id="Noticepostrecptno" class="md-input" />
     </div>
     

    <div class="uk-width-medium-1-6" style="padding-bottom:3px; padding-top:10px"><label>Claim Date</label>
     <input class="md-input" type="text" tabindex="8" name="Claimdate" id="Claimdate" data-uk-datepicker="{format:'DD/MM/YYYY'}"> </div>
     
<div class="uk-width-medium-1-6" style="padding-bottom:3px; padding-top:10px"><label>Received By </label>
    <input class="md-input" type="text" tabindex="9" name="Receivedby" id="Receivedby"/>
     </div>
  
  
    
  <div class="uk-width-medium-1-6" style="padding-bottom:3px; padding-top:10px"><label>Returned Env. Date</label>
  <input class="md-input" type="text" tabindex="10" name="Noticereturnenvelopdt" id="Noticereturnenvelopdt" data-uk-datepicker="{format:'DD/MM/YYYY'}"></div>
    

    <div class="uk-width-medium-1-6" style="padding-bottom:3px; padding-top:10px">Notice fees
   <input class="md-input" type="text" tabindex="11" name="Noticefees" id="Noticefees"> </div>
   
      <div class="uk-width-medium-1-6" style="padding-bottom:3px; padding-top:10px">Postage Charges
   <input class="md-input" type="text" tabindex="12" name="Postage" id="Postage"> </div>
   
      <div class="uk-width-medium-1-6" style="padding-bottom:3px; padding-top:10px">Other Charges
   <input class="md-input" type="text" tabindex="13" name="Othercharges" id="Othercharges"> </div>
   
     <div class="uk-width-medium-1-1" style="padding-bottom:3px; padding-top:10px">Remark
     <input type="text" name="Remark" tabindex="14" id="Remark" class="md-input"/></div>
     
</div></div></div>
                   
                                           
                         
                </div></div>  <!-- end of notice  --> 
                    
                    
                    <!-- Notice Reply -->
                        <div class="md-card">
                          <div class="md-card-content">
        					 <div class="md-input-wrapper">
                            
   
  <!----------------------------notice reply div here-------------->
 
       
   <h4 class="heading_a">NOTICE RECEIVED AND REPLY SEND</h4>
    
                             
 <div class="uk-width-medium-1-1" style="padding-bottom:0px; padding-top:20px">
        <div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">
         
        <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-2-2">
        <div class="uk-form-row">
        <div class="uk-grid">
       
 
 <div class="uk-width-medium-2-6" style="padding-bottom:3px; padding-top:10px"> <label>Notice Reply No</label> 
<input  type="text" id="RPNotice_no" name="RPNotice_no" class="md-input"  readonly/>
 </div>
 
   
   <div class="uk-width-medium-1-6" style="padding-bottom:3px; padding-top:10px">Reply Date 
   <input class="md-input" type="text" tabindex="15" name="Replydt" id="Replydt" data-uk-datepicker="{format:'DD/MM/YYYY'}">
    </div>
     
     <div class="uk-width-medium-1-6" style="padding-bottom:3px; padding-top:10px">Send Mode
		<select name="Replyendmode" id="Replyendmode" tabindex="16" class="md-input">
 		<option VALUE="NULL"></option>
 		<option VALUE="RPAD">RPAD</option>
 		<option VALUE="UPC">UPC</option>
        <option VALUE="RPAD+UPC">RPAD + UPC</option>
        <option VALUE="By Hand">By Hand</option>
        <option VALUE="Courier">Courier</option>
 		</select></div> 


   
     <div class="uk-width-medium-1-6" style="padding-bottom:3px; padding-top:10px"><label>Reply Receipt Date</label><input class="md-input" type="text" name="Replyreceiptdt" tabindex="17" id="Replyreceiptdt" data-uk-datepicker="{format:'DD/MM/YYYY'}"></div>
     
          <div class="uk-width-medium-1-6" style="padding-bottom:3px; padding-top:10px"><label>Receipt No</label> 
     <input type="text" name="Replypostrecptno" id="Replypostrecptno" tabindex="18" class="md-input" />  </div>
     
     
      <div class="uk-width-medium-1-6" style="padding-bottom:3px; padding-top:10px"><label>Claim Date</label>
     <input class="md-input" type="text" tabindex="19" name="Replyclaimdt" id="Replyclaimdt" data-uk-datepicker="{format:'DD/MM/YYYY'}"> </div>
    
       <div class="uk-width-medium-1-6" style="padding-bottom:3px; padding-top:10px"> <label>Received By</label>
     <input type="text" name="Replyreceivedby" tabindex="20" id="Replyreceivedby" class="md-input" />
     </div>
     
<div class="uk-width-medium-1-6" style="padding-bottom:3px; padding-top:10px">Returned Env. Date
<input class="md-input" type="text" name="Replyreturnenvelopdt" tabindex="21" id="Replyreturnenvelopdt" data-uk-datepicker="{format:'DD/MM/YYYY'}">
    </div>
    
    <div class="uk-width-medium-1-6" style="padding-bottom:3px; padding-top:10px">Notice Reply fees
   <input class="md-input" type="text" name="Replynoticefees" tabindex="22" id="Replynoticefees"> </div>
   
      <div class="uk-width-medium-1-6" style="padding-bottom:3px; padding-top:10px">Postage Charges
   <input class="md-input" type="text" name="Replypostage" tabindex="23" id="Replypostage"> </div>
   
      <div class="uk-width-medium-1-6" style="padding-bottom:3px; padding-top:10px">Other Charges
   <input class="md-input" type="text" name="Replyothercharges" tabindex="24" id="Replyothercharges"> </div>
   
     <div class="uk-width-medium-1-1" style="padding-bottom:3px; padding-top:10px">Reply Remark
     <input type="text" name="Replyremark" id="Replyremark" tabindex="25" class="md-input" />
     </div>


                                                </div>

                                            </div>
                                        </div>

                                   </div>
                                </div>
                                                   
                            </div>
                        </div>
                    </div>
             </div>
                    
          <!----------------------------notice rejoinder div here-------------->
             <div class="md-card">
                          <div class="md-card-content">
        					 <div class="md-input-wrapper">
    
       
   <h4 class="heading_a">NOTICE REJOINDER</h4>
                             
 <div class="uk-width-medium-1-1" style="padding-bottom:0px">
        <div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">
         
        <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-2-2">
        <div class="uk-form-row">
        <div class="uk-grid">
        
  <div class="uk-width-medium-2-6" style="padding-bottom:3px; padding-top:10px">Notice Rejoinder No
<input  type="text" id="RJNotice_no" name="RJNotice_no" tabindex="26" class="md-input" readonly/></div>

  <div class="uk-width-medium-1-6" style="padding-bottom:3px; padding-top:10px">Rejoinder Date
  <input class="md-input" type="text" name="Rejdt" tabindex="27" id="Rejdt" data-uk-datepicker="{format:'DD/MM/YYYY'}"></div>
    
          <div class="uk-width-medium-1-6" style="padding-bottom:3px; padding-top:10px">Send Mode
		<select name="Rejendmode" id="Rejendmode" tabindex="28" class="md-input">
 		<option VALUE="NULL"></option>
 		<option VALUE="RPAD">RPAD</option>
 		<option VALUE="UPC">UPC</option>
        <option VALUE="RPAD+UPC">RPAD + UPC</option>
        <option VALUE="By Hand">By Hand</option>
        <option VALUE="Courier">Courier</option>
 		</select></div>        
  
     
 <div class="uk-width-medium-1-6" style="padding-bottom:3px; padding-top:10px">Rej. Receipt Date
   <input class="md-input" type="text" name="Rejrpadreceiptdt" tabindex="29" id="Rejrpadreceiptdt" data-uk-datepicker="{format:'DD/MM/YYYY'}">
    </div>
    
      <div class="uk-width-medium-1-6" style="padding-bottom:3px; padding-top:10px">Postal Recpt. No
      <input type="text" name="Rejpostrecptno" id="Rejpostrecptno" tabindex="30" class="md-input" />
     </div>
     
      <div class="uk-width-medium-1-6" style="padding-bottom:3px; padding-top:10px">Claim Date
     <input class="md-input" type="text" name="Rejclaimdt" tabindex="31" id="Rejclaimdt" data-uk-datepicker="{format:'DD/MM/YYYY'}"> </div>
     
      <div class="uk-width-medium-1-6" style="padding-bottom:3px; padding-top:10px">Received By
     <input type="text" name="Rejreceivedby" id="Rejreceivedby" tabindex="31" class="md-input" />  </div>
   
      <div class="uk-width-medium-1-6" style="padding-bottom:3px; padding-top:10px">Returned Env. Date<input class="md-input" type="text" name="Rejreturnenvelopdt" id="Rejreturnenvelopdt" tabindex="31" data-uk-datepicker="{format:'DD/MM/YYYY'}">
    </div>
    
    <div class="uk-width-medium-1-6" style="padding-bottom:3px; padding-top:10px">Notice Rejoin. fees
   <input class="md-input" type="text" name="Rejnoticefees" tabindex="32" id="Rejnoticefees"> </div>
   
      <div class="uk-width-medium-1-6" style="padding-bottom:3px; padding-top:10px">Postage Charges
   <input class="md-input" type="text" name="Rejpostage" tabindex="33" id="Rejpostage"> </div>
   
      <div class="uk-width-medium-1-6" style="padding-bottom:3px; padding-top:10px">Other Charges
   <input class="md-input" type="text" name="Rejothercharges" tabindex="34" id="Rejothercharges"> </div>
   
     <div class="uk-width-medium-1-1" style="padding-bottom:3px; padding-top:10px; padding-bottom:10px">Rejoinder Remark
     <input type="text" name="Rejremark" id="Rejremark" tabindex="35" class="md-input" />  </div>
   

  <div class="uk-form-row">
<input type="submit" name="Submit" tabindex="36" class="md-btn md-btn-primary" value="Save Details">
</div>
</form>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                    
                  
            	</div>
            </div><!-- here new form load elements end -->
                
     </div>  
      
      <!--- End of the Page Content    --->      
                                    
                             
                                
                            </div>
                            
<?php include("footersrc.php");      ?>
 
<script>

$("#Casepartyname").blur(function() {
$("#Casepartyid").val('');

$("#Casepartynamehidden").val($("#Casepartyname").val());

});

$("#Caseoppopartyname").blur(function() {										  
$("#Caseoppopartyid").val('');
$("#Caseoppopartynamehidden").val($("#Caseoppopartyname").val());
});

$("#Notice_cr").keyup(function() {	
//$("#Notice_idhidden").val($("#Notice_cr").val());	
$("#Notice_send").val($("#Notice_cr").val());								  
$("#RPNotice_no").val($("#Notice_cr").val());
$("#RJNotice_no").val($("#Notice_cr").val());
});

	//below is for fetching notice_no from lw_noticecr
	jQuery("#Notice_no").ajaxlivesearch({
        loaded_at: <?php echo $time; ?>,
        token: <?php echo "'" . $token . "'"; ?>,
        max_input: <?php echo $maxInputLength; ?>,
        onResultClick: function(e, data) {
            // get the index 1 (second column) value
            var noticeno = jQuery(data.selected).find('td').eq('0').text();     
			var noticeid = jQuery(data.selected).find('td').eq('1').text();  
			
			var party = jQuery(data.selected).find('td').eq('2').text(); 
			var oppoparty = jQuery(data.selected).find('td').eq('3').text();   
			var partyid = jQuery(data.selected).find('td').eq('4').text(); 
			var oppopartyid = jQuery(data.selected).find('td').eq('5').text();   
			 
           // set the input value
		   
		    jQuery('#Notice_send').val(noticeno);
            jQuery('#Notice_cr').val(noticeno);			
			jQuery('#Notice_idhidden').val(noticeid);
            jQuery('#RPNotice_no').val(noticeno);	
            jQuery('#RJNotice_no').val(noticeno);	

			jQuery('#Casepartyid').val(partyid);	
			
			jQuery('#Caseoppopartyid').val(oppopartyid);
			
			jQuery('#Casepartyname').val(party);	
			
			jQuery('#Caseoppopartyname').val(oppoparty);
			
			jQuery('#Casepartynamehidden').val(party);	
			
			jQuery('#Caseoppopartynamehidden').val(oppoparty);
			
		   $.ajax({
				url: 'notice_search.php', // Url to which the request is send
				type: "POST",             // Type of request to be send, called as method
				dataType: "json",
				//data: new FormData(this),// Data sent to server, a set of key/value pairs (i.e. form fields and values	
				data: {
							//'Client': JSON.stringify(Client),
							'Notice_nohidden': $("#Notice_idhidden").val()			
					  },
				
				success: function(result)   // A function to be called if request succeeds
				{
				
      
				
				 $("#Noticedt").val(result[1]);
				  $("#Sendmode").val(result[2]);
				  $("#Noticepostrecptno").val(result[3]);
				 $("#Receiptdt").val(result[4]);
			
				 $("#Noticereturnenvelopdt").val(result[5]);
                 $("#Receivedby").val(result[6]);
				 
			
				 
				 $("#Remark").val(result[7]);
				 
				  $("#Claimdate").val(result[8]);
				  $("#Noticefees").val(result[9]);
				   $("#Postage").val(result[10]);
				    $("#Othercharges").val(result[11]);
				}
				
				});
    
    $.ajax({
				url: 'noticereply_search.php', // Url to which the request is send
				type: "POST",             // Type of request to be send, called as method
				dataType: "json",
				//data: new FormData(this),// Data sent to server, a set of key/value pairs (i.e. form fields and values	
				data: {
							//'Client': JSON.stringify(Client),
							'Notice_nohidden': $("#Notice_idhidden").val()			
					  },
				
				success: function(result)   // A function to be called if request succeeds
				{
                    
				
				 $("#Replydt").val(result[1]);
				   $("#Replysendmode").val(result[2]);
				 $("#Replypostrecptno").val(result[3]);
                 $("#Replyreceiptdt").val(result[4]);
				 $("#Replyreturnenvelopdt").val(result[5]);
				 
				 $("#Replyreceivedby").val(result[6]);
               
				 $("#Replyremark").val(result[7]);
				$("#Replyclaimdate").val(result[8]);
				  $("#Replynoticefees").val(result[9]);
				   $("#Replypostage").val(result[10]);
				    $("#Replyothercharges").val(result[11]);
				}
				
				});
    
    $.ajax({
				url: 'noticerejoinder_search.php', // Url to which the request is send
				type: "POST",             // Type of request to be send, called as method
				dataType: "json",
				//data: new FormData(this),// Data sent to server, a set of key/value pairs (i.e. form fields and values	
				data: {
							//'Client': JSON.stringify(Client),
							'Notice_nohidden': $("#Notice_idhidden").val()			
					  },
				
				success: function(result)   // A function to be called if request succeeds
				{
                $("#Rejdt").val(result[1]);
				  $("#Rejsendmode").val(result[2]);
				 $("#Rejpostrecptno").val(result[3]);
				 $("#rejreceiptdt").val(result[4]);
			 $("#Rejreturnenvelopdt").val(result[5]);
                 $("#Rejreceivedby").val(result[6]);
				 $("#Rejremark").val(result[7]);
				$("#Rejclaimdate").val(result[8]);
				  $("#Rejnoticefees").val(result[9]);
				   $("#Rejpostage").val(result[10]);
				    $("#Rejothercharges").val(result[11]);
				
				}
				
				});
			
						
			// hide the result
           jQuery("#Notice_no").trigger('ajaxlivesearch:hide_result');
        },
        onResultEnter: function(e, data) {
            // do whatever you want
            //jQuery("#Notice_no").trigger('ajaxlivesearch:search', {query: 'test'});
        },
        onAjaxComplete: function(e, data) {

        }
    });
	
	// this part taken from casenewajax 
	
	

	jQuery(".Casepartyname").ajaxlivesearch({
        loaded_at: <?php echo $time; ?>,
        token: <?php echo "'" . $token . "'"; ?>,
        max_input: <?php echo $maxInputLength; ?>,
        onResultClick: function(e, data) {
                
            // get the index 0 (first column) value ie id
            var selectedZero = jQuery(data.selected).find('td').eq('0').text();
                         
         if(selectedZero){
         if ( confirm('Are you sure you want to select Existing contact from address book ') ) {
         // set the input value
           jQuery('#Casepartyid').val(selectedZero);
			
			// get the index 0 (first column) value ie name
            var selectedone = jQuery(data.selected).find('td').eq('1').text();           

            // set the input value
            jQuery('.Casepartyname').val(selectedone);
            
            var x=jQuery(data.selected).find('td').eq('1').text(); 
            
            var f=x.replace(/ /g, "");
            
            jQuery('#client_name').val(f);
            
            var url = 'contactimages/'+f+ '.png';            
            
            jQuery('#client_photo_preview').attr('src', url);                     
            
			 // set the partyname hidden value
            jQuery('#Casepartynamehidden').val(selectedone);
			
			 // get the index 1 (second column) value for address
            var selectedtwo = jQuery(data.selected).find('td').eq('2').text();
            
            // set the input value
            jQuery('#Address').val(selectedtwo);
			
			 // get the index 1 (second column) value for mobile
            var selectedthree = jQuery(data.selected).find('td').eq('3').text();

            // set the input value
            jQuery('#Mobile').val(selectedthree);          
            
            
        }else {
        
        	return false;           
               
        }        
        
                        }
						
			// hide the result
            jQuery(".Casepartyname").trigger('ajaxlivesearch:hide_result');      
            
        
        },
        onResultEnter: function(e, data) {
               
            // do whatever you want
            //jQuery(".Casepartyname").trigger('ajaxlivesearch:search', {query: 'test'});
            
                   
        },
        
             
        onAjaxComplete: function(e, data) {
                
           	
        }
    });
	
	//below is for main search for the lw_casenewajax form
	jQuery(".mdinputSearch").ajaxlivesearch({
        loaded_at: <?php echo $time; ?>,
        token: <?php echo "'" . $token . "'"; ?>,
        max_input: <?php echo $maxInputLength; ?>,
        onResultClick: function(e, data) {
            // get the index 1 (second column) value
            var selectedsearch = jQuery(data.selected).find('td').eq('0').text();

            // set the input value
            jQuery('.mdinputSearch').val(selectedsearch + '  Click icon --->');
			
			jQuery('#Searchhidden').val(selectedsearch);
			 
			// hide the result
           jQuery(".mdinputSearch").trigger('ajaxlivesearch:hide_result');
        },
        onResultEnter: function(e, data) {
            // do whatever you want
            //jQuery(".mdinputSearch").trigger('ajaxlivesearch:search', {query: 'test'});
        },
        onAjaxComplete: function(e, data) {

        }
    });
	
	jQuery(".Caseoppopartyname").ajaxlivesearch({
        loaded_at: <?php echo $time; ?>,
        token: <?php echo "'" . $token . "'"; ?>,
        max_input: <?php echo $maxInputLength; ?>,
        onResultClick: function(e, data) {
		
		// get the index 0 (second column) value ie id
            var selectedZero = jQuery(data.selected).find('td').eq('0').text();
        
         if(selectedZero){
         if ( confirm('Are you sure you want to select Existing contact from address book ') ) {

            // set the input value
            jQuery('#Caseoppopartyid').val(selectedZero);
			
            // get the index 1 (second column) value ie name
            var selectedOne = jQuery(data.selected).find('td').eq('1').text();

            // set the input value
            jQuery('.Caseoppopartyname').val(selectedOne);
			
			jQuery('#Caseoppopartynamehidden').val(selectedOne);		
			
			
			 // get the index 1 (second column) value for address
            var selectedtwo = jQuery(data.selected).find('td').eq('2').text();

            // set the input value
            jQuery('#Addressoppo').val(selectedtwo);
			
			 // get the index 1 (second column) value for mobile
            var selectedthree = jQuery(data.selected).find('td').eq('3').text();

            // set the input value
            jQuery('#Mobileoppo').val(selectedthree);
        
           
            
        }else {
            return false;
               
        }        
                        }
                                                
            // hide the result
           jQuery(".Caseoppopartyname").trigger('ajaxlivesearch:hide_result');
                                                
                                                
                                                
        },
        onResultEnter: function(e, data) {
            // do whatever you want
            // jQuery(".Caseoppopartyname").trigger('ajaxlivesearch:search', {query: 'test'});
        },
        onAjaxComplete: function(e, data) {

        }
    });
    
</script>    
  
       <div class="md-fab-wrapper">
        <a class="md-fab md-fab-danger" href="#mailbox_new_message" data-uk-modal="{center:true}">
            <i class="material-icons">&#xE8F4;</i>
        </a>
    </div>
    
    <div class="uk-modal" id="mailbox_new_message" >
        <div class="uk-modal-dialog" style="z-index:auto; width:1300px; margin-top:10px">
            <button class="uk-modal-close uk-close" type="button"></button>
                <div class="uk-modal-header">
                    <h3 class="uk-modal-title">Preview of Last 10 NEW Notices Entered</h3>
                </div>
                <div class="uk-margin-medium-bottom">
                
                <?php
            $sql = 'SELECT lw_noticecr.notice_no,
	    			lw_noticecr.party,
					lw_noticecr.oppoparty
					FROM lw_noticecr ORDER BY lw_noticecr.noticeid DESC LIMIT 10';
	$StatementResults=DB_query($sql,$db);
	
	echo '<table class="uk-table">';
   

	$TableHeader = "<tr bgcolor='#82A2C6'>
	
			<th>" . _('ID') . "</th>
			<th>" . _('Notice No') . "</th>
			<th>" . _('Party Name') . "</th>
			<th>" . _('Oppo Party') . "</th>			
			</tr>";

	echo $TableHeader;
	
		
	while($Contacts=DB_fetch_array($StatementResults))
	{
	
	 $resultparty=DB_query("SELECT name FROM lw_contacts WHERE lw_contacts.id='" . $Contacts['party'] . "'",$db);	
				$myrowparty=DB_fetch_array($resultparty);
	  
	  $resultoppoparty=DB_query("SELECT name FROM lw_contacts WHERE lw_contacts.id='" . $Contacts['oppoparty'] . "'",$db);	
				$myrowoppoparty=DB_fetch_array($resultoppoparty);
			
	
	
	
		
		printf("<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			
			</tr>",
			$Contacts['id'],
		
			$Contacts['notice_no'],
			$myrowparty['name'],
			$myrowoppoparty['name']
					
			);
	  
	  }
	
	?>
        </div>
    </div>
    </div>               
         
           
 