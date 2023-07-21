

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

    <!-- flag icons -->
    <link rel="stylesheet" href="assets/icons/flags/flags.min.css" media="all">

    <!-- altair admin -->
    <link rel="stylesheet" href="assets/css/main.css" media="all">
    
     
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
    ?>
                     

    <div id="top_bar">
        <div class="md-top-bar">
            <div class="uk-width-large-8-10 uk-container-center">
                
            </div>
        </div>
    </div>
    
     				<?php
                        
                        if (isset($_GET['Delete'])){
                        
                        $sqldelete="DELETE FROM lw_alerts WHERE alertid='" . $_GET['Delete'] . "'";
						$result = DB_query($sqldelete,$db);
						
                            	?>
	
    <script>
		
swal({   title: "Alert Deleted!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('lw_page_alerts.php'); //will redirect to your page
}, 2000); 


	</script>
                        
       <?php
                        	
                        } ?>

    <div id="page_content">
        <div id="page_content_inner">

            <div class="md-card-list-wrapper" id="mailbox">
                <div class="uk-width-large-8-10 uk-container-center">
                    <div class="md-card-list">
                        
                        <div class="md-card-list-header md-card-list-header-combined heading_list" style="display: none">All ALERTS</div>
                        <ul class="hierarchical_slide">
                        
                        
                        <!-- the actual alert row start here -->
                        
                         <?php
                                        $sql="SELECT alertid,alerttitle,alertdesc,alertperformedby,startdate,duedate from lw_alerts ORDER BY duedate DESC";
										
										$result=DB_query($sql,$db);
																			
										while($myrowalert = DB_fetch_array($result)){
										
						 ?>
                            <li>
                                <div class="md-card-list-item-menu" data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
                                    <a href="#" class="md-icon material-icons">&#xE5D4;</a>
                                    <div class="uk-dropdown uk-dropdown-small">
                                        <ul class="uk-nav">
                                           <!--  <li><a href="#"><i class="material-icons">&#xE15E;</i> Reply</a></li>
                                             <li><a href="#"><i class="material-icons">&#xE149;</i> Archive</a></li>-->
                                            <li><a href="<?php echo $_SERVER['PHP_SELF'] . '?' . SID . '&Delete=' . $myrowalert[0]; ?>"><i class="material-icons">&#xE872;</i> Delete</a></li>
                                            
                                        </ul>
                                    </div>
                                </div>
                                <span class="md-card-list-item-date"><?php $DateString = Date($_SESSION['DefaultDateFormat']); echo ConvertSQLDate($myrowalert[4]); ?></span>
                                <div class="md-card-list-item-select">
                                    <input type="checkbox" data-md-icheck />
                                </div>
                                <div class="md-card-list-item-avatar-wrapper">
                                <?php
										if($_SESSION['AccessLevel']==1)
													{
													echo '<span class="md-user-letters md-bg-cyan">OW</span>';
													}
													elseif($_SESSION['AccessLevel']==5)
													{
													echo '<span class="md-user-letters md-bg-light-green">DO</span>';
													}
													elseif($_SESSION['AccessLevel']==2)
													{
														echo '<span class="md-user-letters md-bg-light-green">SA</span>';
													}
													elseif($_SESSION['AccessLevel']==3)
													{
														echo '<span class="md-user-letters md-bg-light-green">AC/span>';
													}
													elseif($_SESSION['AccessLevel']==4)
													{
														echo '<span class="md-user-letters md-bg-light-green">JL</span>';
													}
													elseif($_SESSION['AccessLevel']==6)
													{
													//echo '<img class="md-user-image md-list-addon-avatar" src="assets/img/avatars/avatar_07_tn.png" alt=""/>';
													}
													
									?>
                                   <!--    <span class="md-card-list-item-avatar md-bg-grey">OW</span>-->
                                   <!--    <span class="md-card-list-item-avatar md-bg-cyan">yb</span>-->
                                </div>
                                <span style="color:#FF0000; font-weight:bold"></span>
                                <div class="md-card-list-item-sender">
                                    <span><?php echo $myrowalert[3]; ?></span>
                                </div>
                                
                                    <div class="md-card-list-item-content">
            <?php echo $myrowalert[1] .'-<span style="color:#FF0000; font-weight:bold">'. $myrowalert[2] . '</span>'; ?></div>
                            </li><!-- the actual alert row ends here -->
                            
                            <?php } ?>
                           
                       </ul>
                    </div>               
                   
                                  
                   
                </div>
            </div>

        </div>
    </div>

<div class="md-fab-wrapper">
        <a class="md-fab md-fab-accent" href="#mailbox_new_message" data-uk-modal="{center:true}">
            <i class="material-icons">&#xE150;</i>
        </a>
    </div>

    <div class="uk-modal" id="mailbox_new_message" style="z-index:auto; margin-top:40px">
        <div class="uk-modal-dialog">
            <button class="uk-modal-close uk-close" type="button"></button>
           <?php include('lw_alerts.php'); ?>
                 
        </div>
    </div>
    <?php include('footersrc.php'); ?>

    <!--  mailbox functions -->
    <script src="assets/js/pages/page_mailbox.min.js"></script>



   
</body>
</html>