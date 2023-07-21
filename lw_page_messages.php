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

    <!-- uikit -->
    <link rel="stylesheet" href="bower_components/uikit/css/uikit.almost-flat.min.css" media="all">

       <!-- altair admin -->
    <link rel="stylesheet" href="assets/css/main.css" media="all">
    
    <link rel="stylesheet" type="text/css" href="css/ajaxlivesearch.min.css">
    
   <link rel="stylesheet" type="text/css" href="dist/sweetalert.css">
      
   <script src="dist/sweetalert-dev.js"></script>

    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
    <![endif]-->

</head>
<body class=" sidebar_main_open sidebar_main_swipe">

   <?php 
$PageSecurity = 12;
include('includes/session.php');
include("header.php"); 
 include("menu.php"); 
          
          if (isset($_GET['Delete'])){
          
          	$sqldelete="DELETE FROM lw_messages WHERE messageid='" . $_GET['Delete'] . "'";
          	$result = DB_query($sqldelete,$db);
			
				?>
	
    <script>
		
swal({   title: "Message Deleted!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('lw_page_messages.php'); //will redirect to your page
}, 2000); 


	</script>
                        
       <?php	
                    	 
          }
          
		  //create a new message
          if(isset($_POST['submit']))
          {
		  	  
		  $DateString = Date($_SESSION['DefaultDateFormat']);
          $date = new DateTime(FormatDateForSQL($DateString));
		   
		   
          	$sql = "INSERT INTO lw_messages(
          	messagetitle,
          	message,
          	messagefrom,
          	messageto,
          	messagedate
          	)
          	VALUES ('" . trim($_POST['Messagetitle']) . "',
          	'" . trim($_POST['Message']) . "',
          	'" . trim($_POST['Messagefrom']) . "',
          	'" . trim($_POST['Messageto']) . "',
          	'" .  $date->format('Y-m-d') . "'
          	)";
          
          
          	$result = DB_query($sql,$db);
          	
          		?>
	
<script>
		
swal({   title: "New Message Added!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('lw_page_messages.php'); //will redirect to your page
}, 2000); 


	</script>
                        
       <?php	
          		
          }  
		
       ?>      
                   

    <div id="top_bar">
        <div class="md-top-bar">
            <div class="uk-width-large-8-10 uk-container-center">
                <div class="uk-clearfix">
                    <div class="md-top-bar-actions-left">
                        <div class="md-top-bar-checkbox">
                            <input type="checkbox" name="mailbox_select_all" id="mailbox_select_all" data-md-icheck />
                        </div>
                    </div>
                    <div class="md-top-bar-actions-right">
                        <div class="md-top-bar-icons">
                           <!-- <i id="mailbox_list_split" class=" md-icon material-icons">&#xE8EE;</i>
                            <i id="mailbox_list_combined" class="md-icon material-icons">&#xE8F2;</i>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <div id="page_content">
        <div id="page_content_inner">

            <div class="md-card-list-wrapper" id="mailbox">
    <div class="uk-width-large-8-10 uk-container-center">
                 <?php                         
                    
					$DateString = Date($_SESSION['DefaultDateFormat']);
                    $date = new DateTime(FormatDateForSQL($DateString));
					                                 
                   $sql='SELECT messageid,messagetitle,message,messagefrom,messageto,messagedate from lw_messages WHERE messagefrom="' . $_SESSION['UserID'] . '" OR  messageto="' . $_SESSION['UserID'] . '"';  
				   
				   $result=DB_query($sql,$db);
                    
                    $no_rows=DB_num_rows($result);
                    
                     
                    echo '<div class="md-card-list">';
                    if($no_rows>0){
  echo '<div class="md-card-list-header heading_list"></div>';
         echo '<div class="md-card-list-header md-card-list-header-combined heading_list" style="display: none">All Messages</div>';
                    }
           echo '<ul class="hierarchical_slide">';
					
					
                    	
                    while($myrowmessages = DB_fetch_array($result)){
					
                    	if($myrowmessages[0]!=''){
												
						 ?>
                        <!-- the actual message row starts here -->
                                            
                            <li>
 <div class="md-card-list-item-menu" data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
<a href="#" class="md-icon material-icons">&#xE5D4;</a>
<div class="uk-dropdown uk-dropdown-small">
  <ul class="uk-nav">
  
 <li><a href="<?php echo $_SERVER['PHP_SELF'] . '?' . SID . '&Delete=' . $myrowmessages[0]; ?>"><i class="material-icons">&#xE872;</i> Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                               
<span class="md-card-list-item-date"><?php echo $DateString; ?></span>
 <div class="md-card-list-item-select">
<input type="checkbox" data-md-icheck />
</div>
<div class="md-card-list-item-avatar-wrapper">
<span class="md-card-list-item-avatar md-bg-grey">OW</span>
                                </div>
                                
 <div class="md-card-list-item-sender">
                                 
                                   <span><?php echo $myrowmessages['messagefrom']; ?></span>
                                </div>
                                <div class="md-card-list-item-subject">
                                    <div class="md-card-list-item-sender-small">
                                        <span></span>
                                    </div>
 <span>To <?php echo $myrowmessages['messageto']; ?></span>
                                </div>
                                
                               <div class="md-card-list-item-content-wrapper">
                                    <div class="md-card-list-item-content">
                                                                   
                                       <?php echo $myrowmessages['message']; ?>
                                   
                    
                                </div> <!-- fine till here -->
                                
                                </div>
                                
                                
                            </li>
     <!-- fine till here -->
                              <?php }  } //end of if statement for today ?>
                        </ul>
                    </div>
					             
                  
                    </div>
                </div>
            </div>

     
    </div> <!-- fine till here-->

 <div class="md-fab-wrapper">
        <a class="md-fab md-fab-accent" href="#mailbox_new_message" data-uk-modal="{center:true}">
            <i class="material-icons">&#xE150;</i>
        </a>
    </div>
<br>

    <div class="uk-modal" id="mailbox_new_message">
        <div class="uk-modal-dialog">
            <button class="uk-modal-close uk-close" type="button"></button>
           <?php  echo '<form method="post" action="' . $_SERVER["PHP_SELF"] . '" >'; ?>
                <div class="uk-modal-header">
                    <h3 class="uk-modal-title">Compose Message</h3>
                </div>
                <div class="uk-margin-medium-bottom">
                    <label for="mail_new_to">To</label><br>
                    
                    <?php
           
             
             $result=DB_query("SELECT userid, realname FROM www_users",$db);

echo '<select tabindex="19" name="Messageto" id="Messageto" class="md-input">';

while ($myrow = DB_fetch_array($result)) {
	
		echo "<option VALUE='". $myrow['userid'] . "'>" . $myrow['userid'];
	
} //end while loop

DB_free_result($result);

echo '</select>'; 

 ?>
                  </div>
                  <div class="uk-width-medium-1-1" style="padding-bottom:5px">
                     Message Title
    <input type="text" class="md-input" name="Messagetitle" id="Messagetitle" />
                 </div>
                <div class="uk-margin-large-bottom">
                    <label for="mail_new_message">Message</label>
                    
                    
                    <input type="hidden" name="Messagefrom" id="Messagefrom" value="<?php echo $_SESSION['UserID']; ?>" />
                    
                    <textarea name="Message" id="Message" cols="30" rows="5" class="md-input"></textarea>
                </div>
                
                               
                
                <div class="uk-modal-footer">
                   
                    <input type="submit" name="submit" class="uk-float-right md-btn md-btn-flat md-btn-flat-primary" value="Submit">
                </div> 
            </form>
        </div>
    </div>
     <?php include('footersrc.php'); ?>

    <!--  mailbox functions -->
    <script src="assets/js/pages/page_mailbox.min.js"></script>
    
       
   
</body>
</html>