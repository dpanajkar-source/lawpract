 <?php
 $PageSecurity = 2;

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

    <!-- flag icons 
    <link rel="stylesheet" href="assets/icons/flags/flags.min.css" media="all">-->

    <!-- altair admin -->
    <link rel="stylesheet" href="assets/css/main.min.css" media="all">
    
     <!-- Live Search Styles -->
    <link rel="stylesheet" href="css/fontello.css">
    <link rel="stylesheet" href="css/animation.css">
    <!--[if IE 7]>
    <link rel="stylesheet" href="css/fontello-ie7.css">
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="css/ajaxlivesearch.min.css">

    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
    <![endif]-->
    
     <link rel="stylesheet" type="text/css" href="dist/sweetalert.css">
      
   <script src="dist/sweetalert-dev.js"></script>

</head>
<body class=" sidebar_main_open sidebar_main_swipe">

    <?php include("header.php"); ?>
    <?php include("menu.php"); 	  ?>
	
	
    <div id="page_content">
        <div id="page_content_inner">

            <!-- statistics (small charts) -->
            <div class="uk-grid uk-grid-width-large-1-6 uk-grid-width-medium-1-2 uk-grid-medium uk-sortable sortable-handler hierarchical_show" data-uk-sortable data-uk-grid-margin>
                <div>
                    <div class="md-card">
                        <div class="md-card-content">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"><!--<span class="peity_visitors peity_data">5,3,9,6,5,9,7</span>--></div>
                            <span class="uk-text-muted uk-text-small"><b><a href="new_PDFCasesList.php" target="_blank">Total Cases</a></b></span>
                            <h2 class="uk-margin-remove"><span class="countUpMe">
                            
                           <?php

                            $sql="SELECT COUNT(brief_file) from lw_cases";
                            
                            $result=DB_query($sql,$db);
                            
                            $myrow=DB_fetch_row($result);
                            
                       			echo $myrow[0];	?>
								
						</span></h2>
                        </div>
                    </div>
                </div>
                 <div>
                   <div class="md-card">
                        <div class="md-card-content">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_orders peity_data">64/100</span></div>
                            <span class="uk-text-muted uk-text-small"><b><a href="new_PDFContactList.php" target="_blank">Total Contacts</a></b></span>
                            <h2 class="uk-margin-remove"><span class="countUpMe">
                               <?php 
                           $sql="SELECT COUNT(name) from lw_contacts";

									$result=DB_query($sql,$db);
									
									$myrowcontacts=DB_fetch_row($result);
                            
                            echo $myrowcontacts[0];
                            ?>                           
                            
                            </span></h2>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="md-card">
                        <div class="md-card-content">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_sale peity_data">5,3,9,6,5,9,7,3,5,2</span></div>
                            <span class="uk-text-muted uk-text-small"><b><a href="new_PDFCasestoday.php" target="_blank">Today's Cases</a></b>
                            <h2 class="uk-margin-remove"><span class="countUpMe">
                             <?php 
                                
                                $DateString = Date($_SESSION['DefaultDateFormat']);
	
						       $datetoday = new DateTime(FormatDateForSQL($DateString));  
                           
                           $sqltoday="SELECT COUNT(*) AS counter from lw_trans WHERE currtrandate='" . $datetoday->format('Y-m-d') . "'";
                									
								$resulttoday=DB_query($sqltoday,$db);
								
								$myrowtodaycases=DB_fetch_row($resulttoday);
                            
                            echo $myrowtodaycases[0];
                            ?>
                                              
                            </span></h2>
                        </div>
                    </div>
                </div>
               
                <div>
                    <div class="md-card">
                        <div class="md-card-content">
                            <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_live peity_data">5,3,9,6,5,9,7,3,5,2,5,3,9,6,5,9,7,3,5,2</span></div>
        <span class="uk-text-muted uk-text-small"><b><a href="new_PDFCasestomorrow.php" target="_blank">Tomorrow's Cases</a></b></span>
                            <h2 class="uk-margin-remove"><span class="countUpMe">
                             <?php 
                                
                     $DateString = Date($_SESSION['DefaultDateFormat']);
	
                       $datetomorrow = new DateTime(FormatDateForSQL($DateString));
                                            //$date->sub(new DateInterval('P1D'));  

                          $datetomorrow->add(new DateInterval('P1D'));  
                           
                            $sqltomorrow="SELECT COUNT(*) AS counter from lw_trans WHERE currtrandate='" . $datetomorrow->format('Y-m-d') . "'";
                						   
														
								$resulttomorrow=DB_query($sqltomorrow,$db);
								
								$myrowtomorrowcases=DB_fetch_row($resulttomorrow);
                            
                            	echo $myrowtomorrowcases[0];
                            ?>
                            
                            </span></h2>
                        </div>
                    </div>
                </div>
          
            
            <div>
            <div class="md-card">
            <div class="md-card-content">
                                  <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_live peity_data">5,3,9,6,5,9,7,3,5,2,5,3,9,6,5,9,7,3,5,2</span></div>
        <span class="uk-text-muted uk-text-small"><b><a href="new_PDFCertificationcopy.php" target="_blank">Certified copy</a></b></span>
                            <h2 class="uk-margin-remove"><span class="countUpMe">
                      <?php 
                       $sqlcerti="SELECT COUNT(*) AS counter from lw_certification WHERE lw_certification.status!=2";
                		$resultcerti=DB_query($sqlcerti,$db);
						$myrowcerti=DB_fetch_row($resultcerti);
                   echo $myrowcerti[0] . '</b><br>';?>
					</div>
                    </div>
                </div>
                
                
		<div>
            <div class="md-card">
            <div class="md-card-content">
                                  <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_live peity_data">5,3,9,6,5,9,7,3,5,2,5,3,9,6,5,9,7,3,5,2</span></div>
        <span class="uk-text-muted uk-text-small"><b><a href="new_PDFSearchtitle.php" target="_blank">Search Title</a></b></span>
                            <h2 class="uk-margin-remove"><span class="countUpMe">
                      <?php 			
									
						$sqlsearch="SELECT COUNT(*) AS counter from lw_searchtitle WHERE lw_searchtitle.status!=2";
                		$resultsearch=DB_query($sqlsearch,$db);
				 			$myrowsearch=DB_fetch_row($resultsearch);

                             echo $myrowsearch[0] . '</b>'; ?>
                           
                            </span>
                        </div>
                    </div>
                </div>
            
              </div>
            <?php
	// for task count
	$DateString = Date($_SESSION['DefaultDateFormat']);
	
	$date = new DateTime(FormatDateForSQL($DateString));
	               
    $sql = 'SELECT COUNT(id) FROM bf_inward WHERE bf_inward.outward_date IS NULL';
	
	$StatementResultpendinginward=DB_query($sql,$db);
	
	$no_pendinginward=DB_num_rows($StatementResultpendinginward);
	//select notice nos not used in lw_cases
								
								/*$sql='SELECT lw_noticecr.noticeid
									FROM lw_noticecr 
									LEFT OUTER 
									JOIN lw_cases 
									ON lw_noticecr.noticeid=lw_cases.notice_no  
									WHERE lw_cases.notice_no IS NULL';*/
									
									$sql='SELECT lw_noticecr.notice_no FROM lw_noticecr WHERE lw_noticecr.allocated=0';
							
							 $result=DB_query($sql,$db);
							 $nos=DB_num_rows($result);						                         

							
			?>

                    
			<div class="uk-grid uk-grid-medium" data-uk-grid-margin>
                <div class="uk-width-xLarge-2-10 uk-width-large-3-10">
                       <div class="md-card" style="overflow:auto; height:380px">
                        <div  class="md-card-content">
                        <div>                                           


  <?php           
    /*       
     $DateString = Date($_SESSION['DefaultDateFormat']);
	
	$date = new DateTime(FormatDateForSQL($DateString));
                //$date->sub(new DateInterval('P1D'));  

$Statementsent= "SELECT notice_no FROM lw_noticecr INNER JOIN lw_notices ON lw_noticecr.noticeid=lw_notices.noticeno WHERE lw_noticecr.allocated=0 AND lw_notices.noticedt IS NOT NULL";
								$resultsent=DB_query($Statementsent,$db);
								$myrowsent=DB_num_rows($resultsent);								
																
								echo '<table class="uk-table" style="margin-top:2px">';
								echo '<tr><td><a href="new_PDFNoticesnotallocated.php" target="_blank" ">Notices not Allocated in case : </a></td><td style="text-align:right">' . $nos . '</td></tr>';								
								
								
								  echo '<tr><td><label>View Details</label>
        <a  href="#mailbox_noticeno" data-uk-modal="{center:true}"><i class="material-icons">&#xE8F4;</i></a></td></tr>';							
								
								
								echo '<tr><td><a href="new_PDFNoticessent.php" target="_blank" ">Notice Sent : </a></td><td style="text-align:right">' . $myrowsent . '</td></tr>';								
								
$Statementreply= "SELECT notice_no FROM lw_noticecr INNER JOIN lw_noticereply ON lw_noticecr.noticeid=lw_noticereply.noticeno WHERE lw_noticecr.allocated=0 AND lw_noticereply.replydt IS NOT NULL";
								$resultreply=DB_query($Statementreply,$db);
								$myrowsreply=DB_num_rows($resultreply);
								
								echo '<tr><td><a href="new_PDFNoticesreceived.php" target="_blank" ">Notice Received  : </td><td style="text-align:right">' . $myrowsreply . '</td></tr></table>';*/
								?>
                                
<!-- tasks starts here    -->  
 
 
<!-- <b><a href="bf_new_PDFpendinginward.php" target="_blank">Banking/ Finance Loan Pending Files -   <?php   //echo $no_pendinginward;  ?></a></b>-->
  
      
   <div class="uk-modal" id="mailbox_noticeno" >
        <div class="uk-modal-dialog" style="overflow:auto">
            <button class="uk-modal-close uk-close" type="button"></button>
               <!-- <div class="uk-modal-header uk-margin-medium-bottom">
                    <h3 class="uk-modal-title">Notices Not Allocated in Cases</h3>
                </div>
                <div class="uk-margin-medium-bottom">-->
                
         <?php      
        /*$sqlnoticeno="SELECT cr.noticeid,
			cr.notice_no,
			p1.name AS party,
			p2.name AS oppoparty,
			lw_notices.noticedt
			FROM lw_noticecr AS cr INNER JOIN lw_notices ON cr.noticeid=lw_notices.noticeno INNER JOIN lw_contacts AS p1 ON cr.party=p1.id INNER JOIN lw_contacts AS p2 ON cr.oppoparty=p2.id WHERE cr.allocated=0 ORDER BY cr.notice_no DESC";			
		
		$StatementResultsnoticeno=DB_query($sqlnoticeno,$db); 					
	
	echo '<table class="uk-table">';
	
	$i=1;
   

	$TableHeader = "<tr bgcolor='#82A2C6'>
	
			<th>" . _('ID') . "</th>
			<th>" . _('Notice No') . "</th>
			<th>" . _('Party') . "</th>
			<th>" . _('Opposite Party') . "</th>
			<th>" . _('Date') . "</th>
			</tr>";

	echo $TableHeader;
	while($Noticeno=DB_fetch_array($StatementResultsnoticeno))
	{
						
	if(!empty($Noticeno['noticedt']))
	{
	$Noticeno['noticedt']=ConvertSQLDate($Noticeno['noticedt']);
	}	
	else	
	{
	$Noticeno['noticedt']="";
	}	
		
		printf("<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>			
			</tr>",
			$i++,
			$Noticeno['notice_no'],
			$Noticeno['party'],
			$Noticeno['oppoparty'],
			$Noticeno['noticedt']			
			);
	  
	  }
	echo '</table>';*/
	echo '</div></div> ';
	
	echo '<div align="left">';
	echo '<table><tr><img src="yellow.png"> Not Started';
	echo '&nbsp;<img src="Skyblue.png"> In Progress';
	echo '&nbsp;<img src="red.png"> Pending';
	echo '&nbsp;<img src="purple.png"> Deferred</tr>';
	echo '&nbsp;<img src="lightgreen.png"> Completed</tr></table></div>';
	
	echo '<div align="center">Task Status<img src="db_taskstatus_chart.php" style="margin-top:0px"></div>';
	
	/*
	    
       $sql = 'SELECT id,taskfrom,taskto,enddate FROM lw_tasks WHERE taskstatus!=3';
	
	$StatementResults=DB_query($sql,$db);	

	echo '<h4 class="heading_c"><b>Pending Tasks</b></h4>';
	echo '<table class="uk-table uk-table-condensed">';

	$TableHeader = "<thead><tr>
			<th>" . _('ID') . "</th>
			<th>" . _('From') . "</th>
			<th>" . _('To') . "</th>
			<th>" . _('End Date') . "</th>
	</tr> </thead>";

	echo $TableHeader;

	$id=1;
	
	
	while($Contacts=DB_fetch_array($StatementResults))
	{
     
if($Contacts['enddate']!="")
	{
	$Contacts['enddate']=ConvertSQLDate($Contacts['enddate']);
	}
	
	else
	
	{
	$Contacts['enddate']=$Contacts['enddate'];
	}
		
		printf("<td>%s</td>
			<td>%s</td>
			<td>%s</td>	
			<td>%s</td>	
			</tr>",
			$id++,
			$Contacts['taskfrom'],
			$Contacts['taskto'],
			$Contacts['enddate']);			
			}
	 echo '</table>';
?>*/
             ?>           

                        </div>
                 </div>   
            </div>
            </div>
           
             <div class="uk-width-xLarge-8-10 uk-width-large-7-10">
             
                    <div class="md-card" style="overflow:auto; height:380px">
                        <div align="center" class="md-card-content">
                        
                            <h4 class="heading_c"><b>This weeks Cases</b></h4>
                                                    
                            <?php
							
							
$now = time();
$num = date("w");

if ($num == 0)//sunday
{ $sub = 6; }
else { $sub = ($num-1); }
$WeekMon  = mktime(0, 0, 0, date("m", $now)  , date("d", $now)-$sub, date("Y", $now));   

$todayh = getdate($WeekMon); //monday week begin reconvert

$d = $todayh[mday];
$m = $todayh[mon];
$y = $todayh[year];
//echo "$d-$m-$y"; //monday- this week

if($m<10)
{
$m='0' . $m;
}

if($d<10)
{
$d= '0' . $d;

}


$weekstart="$y-$m-$d";

	$date = new DateTime($weekstart);
	
	$date->add(new DateInterval('P5D'));  
		

$weekend=$date->format('Y-m-d');

//echo 'weekstart' . $weekstart;
//echo date("Y-m-d", strtotime("+1 week"));

//$today  = date("l");

//echo ' weekend' . $weekend;

    
 	$sql = 'SELECT brief_file,
				lw_trans.currtrandate,
				lw_trans.courtcaseno,
				lw_trans.prevcourtdate,
				lw_trans.nextcourtdate
		FROM lw_trans WHERE nextcourtdate >="' . $weekstart . '" AND nextcourtdate <="' . $weekend .'" ORDER BY nextcourtdate ASC';
	
	$StatementResults=DB_query($sql,$db);	
	
	
	?>
	           <table class="uk-table uk-table-condensed">
                <thead>  
    <?php
	$TableHeader = "<tr>
			<th>" . _('Prev Date') . "</th>
			<th>" . _('Brief_File') . "</th>
			<th>" . _('Case No') . "</th>
			<th>" . _('Next Date') . "</th>
	</tr> </thead>";

	echo $TableHeader;
	
		while($Contacts=DB_fetch_array($StatementResults))
	{
     
if($Contacts['prevcourtdate']!="")
	{
	$Contacts['prevcourtdate']=ConvertSQLDate($Contacts['prevcourtdate']);
	}
	
	else
	
	{
	$Contacts['prevcourtdate']=$Contacts['prevcourtdate'];
	}
	
if($Contacts['currtrandate']!="")
	{
	$Contacts['currtrandate']=ConvertSQLDate($Contacts['currtrandate']);
	}
	
	else
	
	{
	$Contacts['currtrandate']=$Contacts['currtrandate'];
	}
     
if($Contacts['nextcourtdate']!="")
	{
	$Contacts['nextcourtdate']=ConvertSQLDate($Contacts['nextcourtdate']);
	}
	
	else
	
	{
	$Contacts['nextcourtdate']=$Contacts['nextcourtdate'];
	}
		
		printf("<td>%s</td>
			<td>%s</td>
			<td>%s</td>	
			<td>%s</td>	
			</tr>",
			$Contacts['prevcourtdate'],
			$Contacts['brief_file'],
			$Contacts['courtcaseno'],
			$Contacts['nextcourtdate']);			
			}
	 echo '</table>';
?>
							<!--<img src="db_clientcat_cases_chart.php" style="margin-top:0px">-->

                        </div>
                 </div>   
            </div>
         
                <div class="uk-width-xLarge-2-10 uk-width-large-3-10">
                               <div class="md-card" style="overflow:auto; height:350px">
                        <div  class="md-card-content">
                        <div> 
                           <h4 class="heading_c uk-margin-bottom" align="center"><b>Total Cases of Each Type</b></h4>
             
                             <?php           
  

		
	echo '<table class="uk-table">';
	

    
$sqlcasetype='SELECT casecatid,casecat from lw_casecat';
$resultcasetype=DB_query($sqlcasetype,$db);


while($myrowcasestype=DB_fetch_array($resultcasetype))
{
	
	$sql='SELECT COUNT(*) from lw_cases WHERE casecatid="' . $myrowcasestype[0] . '"';
	$resultcasescount=DB_query($sql,$db);
	
	$myrowcasesnocount=DB_fetch_array($resultcasescount);
		
	echo '<tr><td>' . $myrowcasestype[1] . '</td><td>' . $myrowcasesnocount[0] . '</td></tr>';
	
	
}
echo '</table>';

    ?>
    
                          
                        </div>
                 </div>   
            </div>
  </div>
            <!--  <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-medium-1-1">
                    <div class="md-card">
                        <div class="md-card-content">
                            <h4 class="heading_c uk-margin-bottom">Case Typewise</h4>
                             <img src="db_casetypewise_chart.php" style="margin-top:0px">
                        </div>
                    </div>
                 </div>
            </div>-->
                    
 <div class="uk-width-xLarge-8-10 uk-width-large-7-10">
             
                    <div class="md-card" style="overflow:auto; height:350px">
                        <div  align="center" class="md-card-content">
                        
                            <h4 class="heading_c uk-margin-bottom"><b>Next weeks Cases</b></h4>
                           
                            <?php
													
$now = time();
$num = date("w");

if ($num == 0)//sunday
{ $sub = 6; }
else { $sub = ($num-1); }
$WeekMon  = mktime(0, 0, 0, date("m", $now)  , date("d", $now)-$sub, date("Y", $now));   

$todayh = getdate($WeekMon); //monday week begin reconvert

$d = $todayh[mday];
$m = $todayh[mon];
$y = $todayh[year];
//echo "$d-$m-$y"; //monday- this week


if($m<10)
{
$m='0' . $m;
}

if($d<10)
{
$d= '0' . $d;

}


$weekstart="$y-$m-$d"; //this monday

	$date = new DateTime($weekstart);
	
	$date->add(new DateInterval('P5D'));  
		

$weekend=$date->format('Y-m-d');

$nextmon = new DateTime($weekend);
	
$date->add(new DateInterval('P2D')); 


$nextmonday=$date->format('Y-m-d'); //next monday

$nextsat = new DateTime($nextmonday);
	
$date->add(new DateInterval('P5D')); 

$nextsaturday=$date->format('Y-m-d'); //next saturday
    
 	$sql = 'SELECT brief_file,
				lw_trans.currtrandate,
				lw_trans.courtcaseno,
				lw_trans.prevcourtdate,
				lw_trans.nextcourtdate
		FROM lw_trans WHERE nextcourtdate >="' . $nextmonday . '" AND nextcourtdate <="' . $nextsaturday .'" ORDER BY nextcourtdate ASC';
	
	$StatementResults=DB_query($sql,$db);	
	
	
	?>
	           <table class="uk-table uk-table-condensed">
                <thead>  
    <?php
	$TableHeader = "<tr'>
			<th>" . _('Prev Date') . "</th>
			<th>" . _('Brief_File') . "</th>
			<th>" . _('Case No') . "</th>
			<th>" . _('Next Date') . "</th>
	</tr> </thead>";

	echo $TableHeader;

	
	
	
	while($Contacts=DB_fetch_array($StatementResults))
	{
   if($Contacts['prevcourtdate']!="")
	{
	$Contacts['prevcourtdate']=ConvertSQLDate($Contacts['prevcourtdate']);
	}
	
	else
	
	{
	$Contacts['prevcourtdate']=$Contacts['prevcourtdate'];
	}
	 if($Contacts['currtrandate']!="")
	{
	$Contacts['currtrandate']=ConvertSQLDate($Contacts['currtrandate']);
	}
	
	else
	
	{
	$Contacts['currtrandate']=$Contacts['currtrandate'];
	}
	  
if($Contacts['nextcourtdate']!="")
	{
	$Contacts['nextcourtdate']=ConvertSQLDate($Contacts['nextcourtdate']);
	}
	
	else
	
	{
	$Contacts['nextcourtdate']=$Contacts['nextcourtdate'];
	}
		
		printf("<td>%s</td>
			<td>%s</td>
			<td>%s</td>	
			<td>%s</td>	
			</tr>",
		
			$Contacts['prevcourtdate'],
			$Contacts['brief_file'],
			$Contacts['courtcaseno'],
			$Contacts['nextcourtdate']);			
			}
	 echo '</table>';
?>
							<!--<img src="db_clientcat_cases_chart.php" style="margin-top:0px">-->
</div>
                        </div>
                 </div>   
            </div>
            
            <!-- old elements below  -->
             <div class="uk-grid" data-uk-grid-margin data-uk-grid-match="{target:'.md-card-content'}">
                <div class="uk-width-medium-1-1">
                    <div class="md-card">
                        <div class="md-card-content" style="height:300px; overflow:auto; text-align:center; font-weight:bolder">
                        <label>DECISION SUPPORT CENTER</label>
                                   
                    <div class="uk-overflow-container">
                    <?php
                     //var_dump($msgarray);  ?>
                     
                        <table class="uk-table uk-table-condensed" style="text-align:justify; font-weight:normal">
                <thead>  
                <?php 
					
	$TableHeader = "<tr>
				<th>" . _('DESCRIPTION') . "</th>
				</tr></thead>";
               
	//echo $TableHeader;
	
		$rand=1;
		
		for($i=1;$i<=rand(6, 6);$i++)
		{
				
		 $sqldecisions= "SELECT id,description FROM lw_decisions WHERE lw_decisions.id = '" . $rand . "'";					
		
		$DecisionResults=DB_query($sqldecisions,$db);
		
	$myrowdecisions=DB_fetch_array($DecisionResults);
	
	$rand =  $rand + rand(1, 6); 
                        
            if($myrowdecisions['id']==3)
            {
                		
		 $sqlvals= "SELECT COUNT(*) FROM lw_messages";					
		
		$Resultvals=DB_query($sqlvals,$db);
		
	$myrowvals=DB_fetch_array($Resultvals);
                
                if($myrowvals[0]>10)
                {
                    printf("<td>%s</td></tr>",
				$myrowdecisions['description']);	
                    
                }              
                
            } elseif($myrowdecisions['id']==4)
            {
                		
		 $sqlvals= "SELECT COUNT(*) FROM lw_alerts";					
		
		$Resultvals=DB_query($sqlvals,$db);
		
	$myrowvals=DB_fetch_array($Resultvals);
                
                if($myrowvals[0]>10)
                {
                    printf("<td>%s</td></tr>",
				$myrowdecisions['description']);	
                    
                }               
                
            }else
            {
	
			printf("<tr><td>%s</td>
				</tr>",
				$myrowdecisions['description']);		
            }
			
		}
		echo '</table>';
		
		//see if there are next dates falling this week
		
$now = time();
$num = date("w");

if ($num == 0)//sunday
{ $sub = 6; }
else { $sub = ($num-1); }
$WeekMon  = mktime(0, 0, 0, date("m", $now)  , date("d", $now)-$sub, date("Y", $now));   

$todayh = getdate($WeekMon); //monday week begin reconvert

$d = $todayh[mday];
$m = $todayh[mon];
$y = $todayh[year];
//echo "$d-$m-$y"; //monday- this week

if($m<10)
{
$m='0' . $m;
}

if($d<10)
{
$d= '0' . $d;

}

$weekstart="$y-$m-$d";

	$date = new DateTime($weekstart);
	
	$date->add(new DateInterval('P6D'));  	

$weekend=$date->format('Y-m-d');
		
		$sql = 'SELECT lw_trans.id,lw_trans.brief_file,
				lw_trans.courtcaseno,
				lw_trans.courtname,
				lw_trans.party,
				lw_trans.stage,
				lw_trans.prevcourtdate,
				lw_trans.currtrandate,
				lw_trans.nextcourtdate
		FROM lw_trans WHERE nextcourtdate >="' . $weekstart . '" AND nextcourtdate <"' . $weekend .'" AND lw_trans.smssent!=1 ORDER BY nextcourtdate ASC';
	
	$StatementResults=DB_query($sql,$db);
	
	$myrowsmscases=DB_num_rows($StatementResults);
	
	//myrowsmscases=DB_fetch_array($StatementResults);
		
   //  echo 'Send these SMS\'s on every Monday to cover weekly cases';
		
        
	 echo '<div class="md-card"><div class="md-card-content">';
						echo '<div class="uk-width-medium-1-1" style="padding-bottom:0px">';
echo '<div class="uk-grid uk-grid-width-1-2 uk-grid-width-large-1-2">';
	echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">SMS to be sent for Cases this week = ' .$myrowsmscases;	
	echo '</div>';
		
	 ?>  
    <!-- <form method='POST' name='sendsms' id='sendsms' action="<?php //echo $_SERVER['PHP_SELF']  . '?' . SID ; ?>">            
     <div class="uk-width-medium-1-2" style="padding-bottom:10px"><input type="submit" class="md-btn md-btn-primary" name="submit" id="submit" value="Click to Send SMS to All Clients Now" /></div>
     
     </form> -->
                
                      </div>
                    </div>
              </div>
          </div>
                      
                    
             </form>
                
             
            

  <?php include('footersrc.php'); ?> 
  
   <script> 
             
$("#sendsms").on('submit',(function(e) {	
e.preventDefault();
$.ajax({
url: 'sms_gate_all.php', // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
dataType: "html",
data: new FormData(this),// Data sent to server, a set of key/value pairs (i.e. form fields and values	
	
contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false
success: function(data)   // A function to be called if request succeeds
{
//alert(data);

//$("#message").html(data);
}

});
}));  
   
</script>
  
</body>
</html>