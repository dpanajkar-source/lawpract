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
	
?>
   <!-- main header -->
    <header id="header_main">
        <div class="header_main_content">
            <nav class="uk-navbar">                            
                
                <!-- main sidebar switch -->
                <a href="#" id="sidebar_main_toggle" class="sSwitch sSwitch_left">
                    <span class="sSwitchIcon"></span>
                </a>

                <!-- secondary sidebar switch -->
                <a href="#" id="sidebar_secondary_toggle" class="sSwitch sSwitch_right sidebar_secondary_check">
                    <span class="sSwitchIcon"></span>
                </a>
                
                    <div id="menu_top_dropdown" class="uk-float-left uk-hidden-small">
                        <div class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">
                            <a href="#" class="top_menu_toggle"><i class="material-icons md-24">&#xE01f;</i>&nbsp;ACTS & DEEDS</a>
                            <div class="uk-dropdown uk-dropdown-width-2">
                                <div class="uk-grid uk-dropdown-grid" data-uk-grid-margin>
                                    <div class="uk-width-2">
                                        <div class="uk-grid uk-grid-width-medium-1-3 uk-margin-top uk-margin-bottom uk-text-center" data-uk-grid-margin>
                                            <a href="lw_acts_alt.php">
                                                <i class="material-icons md-36 md-color-green-600">&#xE0B9;</i>
                                                <span class="uk-text-muted uk-display-block">Basic Acts</span>
                                            </a>
                                            <a href="lw_deeds_alt.php">
                                                <i class="material-icons md-36 md-color-blue-600">&#xE85d;</i>
                                                <span class="uk-text-muted uk-display-block">Deeds &amp; Docs</span>
                                            </a>
                                            <a href="lw_courtfees_alt.php">
                                                <i class="material-icons md-36 md-color-blue-600">&#xE85d;</i>
                                                <span class="uk-text-muted uk-display-block">Court Fees</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                                
 <div id="menu_top_dropdown" class="uk-float-left uk-hidden-small">
                        <div class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">
                            <a href="#" class="top_menu_toggle"><i class="material-icons md-24">&#xE8F0;</i>&nbsp;REPORTS</a>
                            <div class="uk-dropdown uk-dropdown-width-3">
                                <div class="uk-grid uk-dropdown-grid" data-uk-grid-margin>
                                    <div class="uk-width-3">
                                        <div class="uk-grid uk-grid-width-medium-1-6 uk-margin-top uk-margin-bottom uk-text-center" data-uk-grid-margin>
                                     <!--   <a href="#" data-uk-modal="{target:'#modal_casecat_new'}">
                                               <span class="uk-text-muted uk-display-block">Blank Next Date</span>
                                            </a>-->
                                             <a href="lw_searchcases.php"  target="_blank">
                                 
                                                <span class="uk-text-muted uk-display-block">Search Cases</span>
                                            </a>
                                            <a href="new_PDFBlanknextdate.php" target="_blank">
                                               <span class="uk-text-muted uk-display-block">Blank Next Date</span>
                                            </a>
                                            <a href="new_PDFCasestoday.php" target="_blank">
                                             
                                                <span class="uk-text-muted uk-display-block">Today's Cases</span>
                                            </a>
                                            <a href="new_PDFCasestomorrow.php" target="_blank">
                                              
                                                <span class="uk-text-muted uk-display-block">Tommorow's Cases</span>
                                            </a>
                                           
                                            <a href="new_PDFDailydiary.php" target="_blank">
                                 				<span class="uk-text-muted uk-display-block">Daily Diary</span>
                                            </a>
                                            <a href="lw_reports.php" target="_parent">
                                 				<span class="uk-display-block" style="color:#FF0000">All Reports</span>
                                            </a>
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                         
                    <div id="menu_top_dropdown" class="uk-float-left uk-hidden-small">
 
  <a href="lw_dashboard.php" class="top_menu_toggle"><i class="material-icons md-24">&#xE8F0;</i>DASHBOARD</a>
                   </div> 
                    <div id="menu_top_dropdown" class="uk-float-left uk-hidden-small">
   <a href="lw_appointments_alt.php" class="top_menu_toggle"><i class="material-icons md-24">&#xE0cf;</i></span>
                        APPOINTMENTS                      
                        <?php
						$sql='SELECT COUNT(id) from lw_appointments WHERE appdate="' . date('Y-m-d') . '"';
										
										$result=DB_query($sql,$db);
										
										$myrowappointments=DB_fetch_array($result,$db);
										
										$appointments=$myrowappointments[0];
										
						echo '[' . $appointments . ']';
						
						?>
                    </a>
                </div>
           <div id="menu_top_dropdown" class="uk-float-left uk-hidden-small">
 
  <a href="lw_tasks_alt.php" class="top_menu_toggle"><i class="material-icons md-24">&#xE8DF;</i></span>
                          TASKS              
                        <?php
						$sqltask='SELECT COUNT(id) from lw_tasks' ;
										
										$resulttask=DB_query($sqltask,$db);
										
										$myrowtask=DB_fetch_array($resulttask,$db);
										
										$tasks=$myrowtask[0];
										
						echo '[' . $tasks . ']';
						?>
                    </a>
                </div>
                    
                <div class="uk-navbar-flip">
                    <ul class="uk-navbar-nav user_actions">                      
                                            
<li><a href="#" id="full_screen_toggle" class="user_action_icon uk-visible-large" title="Full Screen Toggle"><i class="material-icons md-24 md-light">&#xE5D0;</i></a></li>
  <li> <a href="lw_howtouse.php" class="user_action_icon uk-visible-large" title="How to Start Entering data"><i class="material-icons md-24 md-light">&#xE88E;</i></a></li>
<li> <div id="menu_top_dropdown" class="uk-float-left uk-hidden-small">
 
  <a href="http://localhost/lawpract/roundmail/index.php" class="top_menu_toggle" title="Roundmail" target="_blank"><i class="material-icons md-24">mail</i></span></a>
                        </div>  </li>                      
<li data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
                         <?php
										$DateString = Date($_SESSION['DefaultDateFormat']);
										$sql='SELECT COUNT(message) from lw_messages WHERE messagefrom="' . $_SESSION['UserID'] . '" OR  messageto="' . $_SESSION['UserID'] . '"';
										
										$result=DB_query($sql,$db);
										
										$myrowmessages=DB_fetch_array($result,$db);
										
										$messages=$myrowmessages[0];
																				
										$sql="SELECT COUNT(alertdesc) from lw_alerts";
										
										$result=DB_query($sql,$db);
										
										$myrowalerts=DB_fetch_array($result,$db);
										
										$alerts=$myrowalerts[0];
										
										$total=$messages+$alerts;
										
										
										?>
                                        
<li><a href="#" id="main_search_btn" class="user_action_icon" title="Search Case Details" accesskey="s"><i class="material-icons md-24 md-light">&#xE8B6;</i></a></li>



<li data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
 <a href="#" class="user_action_icon" title="Messages and Alerts"><i class="material-icons md-24 md-light">&#xE7F4;</i><span class="uk-badge">
  <?php echo $total; ?></span></a>
  

  
 
 <div class="uk-dropdown uk-dropdown-xlarge">
 <div class="md-card-content">
<ul class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#header_alerts',animation:'slide-horizontal'}">
<li class="uk-width-1-2 uk-active"><a href="#" class="js-uk-prevent uk-text-small">Messages (<?php echo $messages; ?>)</a></li>
<li class="uk-width-1-2 uk-active"><a href="#" class="js-uk-prevent uk-text-small">Alerts (<?php echo $alerts; ?>)</a></li>

                                    </ul>
                                   <ul id="header_alerts" class="uk-switcher uk-margin">
                                        <li>
                                            <ul class="md-list md-list-addon">
                                                <?php
                                                
                                   //     $sql="SELECT messagetitle,message,messagefrom from lw_messages ORDER BY messagedate DESC LIMIT 10";
								   
										$sql='SELECT messagetitle,message,messagefrom from lw_messages WHERE messagefrom="' . $_SESSION['UserID'] . '" OR  messageto="' . $_SESSION['UserID'] . '" ORDER BY messagedate DESC LIMIT 10 ';  
										
										$result=DB_query($sql,$db);
																			
										while($myrow = DB_fetch_array($result)){
										
												?>
                                                <li>
                                                    <div class="md-list-addon-element">
                                                     
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
                                                                                                      
                                                    </div>
                                                    
                                                    <div class="md-list-content">
                                                        <span class="md-list-heading"><a href="lw_page_messages.php"><?php echo $myrow[0]; ?></a></span>
                                                        <span class="uk-text-small uk-text-muted"><?php echo $myrow[1]; ?></span>
                                                    </div>
                                                </li>
                                              <?php } ?>  
                                              </ul>
                                              
                                            <!-- messages display according to recurrrence -->
            <div class="uk-text-center uk-margin-top uk-margin-small-bottom">
                     <a href="lw_page_messages.php" class="md-btn md-btn-flat md-btn-flat-primary js-uk-prevent">Show All Messages</a>
                                             </div>
                                        </li>
                                        
                                       
                                        <li>
                                         <!-- Below starts the alerts section  --->
                                            <ul class="md-list md-list-addon">
                                            
                                             <?php
                                            // alerts will be dislayed as below

										$DateString = Date($_SESSION['DefaultDateFormat']);
	
									$DateToday = new DateTime(FormatDateForSQL($DateString));
											                     
            $sqlalerts="SELECT alerttitle,alertdesc,alertperformedby,startdate,duedate,recurrence from lw_alerts";
                                            
                                            $resultalert=DB_query($sqlalerts,$db);
                                               
                                            
                                   while($myrowalerts = DB_fetch_array($resultalert)){
                                            
                                            	$startdate = new DateTime($myrowalerts['startdate']);
												
												$duedate = new DateTime($myrowalerts['duedate']);
                                            	
                                            	//echo $startdate->format('Y-m-d');
                                                                                        
                                                                                                                                   
                                            $recurrence=$myrowalerts['recurrence'];   	
											
											$datetime1 = new DateTime($startdate->format('Y-m-d'));
											$datetime2 = new DateTime($duedate->format('Y-m-d'));
											$interval = $datetime1->diff($datetime2);
											$noofdays=$interval->format('%R%a days');
											
											$intervalloop=(int)($noofdays/$recurrence);
											
											$alertarray=array();
											$i=0;
											$j=0;
											
											while($j<=$intervalloop)
											{
											$alertarray[$i++]=$datetime1->format('Y-m-d');
											
											$datetime1->add(new DateInterval('P' . $recurrence . 'D'));
											
											$datetime1 = new DateTime($datetime1->format('Y-m-d'));
											
											$j++;
											
											}
											
											if (in_array($DateToday->format('Y-m-d'), $alertarray)) {
													             
                                            	// show alert
												
                                            	?>
												
                                                <li>
                                                    <div class="md-list-addon-element">
                                                        <i class="md-list-addon-icon material-icons uk-text-warning">&#xE8B2;</i>
                                                    </div>
                                                    <div class="md-list-content">
                                                        <span class="md-list-heading"><?php echo $myrowalerts['alerttitle'] . '-' . $myrowalerts['alertdesc'];   ?></span>
                                                    </div>
                                                 </li>   
                                                 
                                                                                          	
<?php 

}//end of inarray condition
                                            	                                                                          
}                                           
                                           ?>                                   
                                               
                                            </ul>
                                            
                                            <div class="uk-text-center uk-margin-top uk-margin-small-bottom">
               <a href="lw_page_alerts.php" class="md-btn md-btn-flat md-btn-flat-primary js-uk-prevent">Show All Alerts</a>
                                             </div>
                                       
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                         
                         
                         
                         
                         
                          <li data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
               <a href="#" class="user_action" style="padding-top:3px"><i class="material-icons md-24 md-light">&#xE5C6;</i></a>
                            <div class="uk-dropdown uk-dropdown-small">
                                <ul class="uk-nav js-uk-prevent">
                                    <li><a href="lw_companymaster.php">Advocate's Information</a></li>
                                    <li><a href="lw_systemsettings.php">System Settings</a></li>
                                   
                                     <li><a href="lw_users_alt.php">Manage Users</a></li>
                                      <li><a href="lw_access_alt.php">Manage Roles</a></li>
                                      
                                        <li><a href="lw_license.php">My License</a></li>
                                      
                                       <li><a href="lw_updates_alt.php">Check Updates</a></li>
                                        
                       				 <li><a href="lw_credits.php">About LawPract</a></li>
                              
                                    <li><a href="<?php echo $rootpath . '\Logout.php?'; ?>">Logout</a></li>
                                    
                                 <?php   
                                  //  echo '<li><img src="img/user-in.png" TITLE="User" ALT="' . _('User') . '"> ' . stripslashes($_SESSION['UserID']) . '-in</li>';  ?>
                                    
                         		 </ul>
                                 
                            </div>
                            
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
                       
                   
        
       <div class="header_main_search_form">
            <i class="md-icon header_main_search_close material-icons">&#xE5CD;</i>
            <form class="uk-form">
               <input type="text" class="HeaderinputSearch" name="HeaderinputSearch" id="HeaderinputSearch" style="width:1000px" />
                <input type="hidden"  name="Searchheaderhidden" id="Searchheaderhidden">
                <button class="header_main_search_btn uk-button-link"><i class="md-icon material-icons">&#xE8B6;</i></button>
            </form>
        </div>
    </header><!-- main header end -->
    
                
                           
                         
