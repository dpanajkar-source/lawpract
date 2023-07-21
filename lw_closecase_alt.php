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

</head>
<body class=" sidebar_main_open sidebar_main_swipe">
<?php
    $PageSecurity = 3;
     include('includes/session.php');
	 include("header.php");  
     include("menu.php");   

if (isset($_POST['Submit'])) 
{

$sql='Select * from lw_trans WHERE brief_file="' . $_POST['Brief_File'] . '" ORDER BY currtrandate DESC LIMIT 1';
		
		$result=DB_query($sql,$db);
		
		$myrowdiaryrec = DB_fetch_array($result);   
		
		
		$sqlcasehistoryid='Select casehistoryid from lw_casehistory ORDER BY casehistoryid DESC LIMIT 1';
		
		$resultcasehistoryid=DB_query($sqlcasehistoryid,$db);
		
		$myrowcasehistory = DB_fetch_array($resultcasehistoryid);   
		
		$myrowcasehistory[0]=$myrowcasehistory[0]+1;
				
		if ($_POST['Closedateupdate'] === "") 
   		{
  		 $Closedateupdate = "NULL";
  		 }else {
  		 $Closedateupdate=FormatDateForSQL($_POST['Closedateupdate']);
       
        $Closedateupdate="'\ " . $Closedateupdate . "\" . '";
        }
		
		
		$sql = "INSERT INTO lw_casehistory(
			casehistoryid,
			brief_file,
			party,
			oppoparty,
			result,
			caseclosedate,
			courtcaseno,
			courtid,
			coram,
			judgement,
			remark
			)
			VALUES ('".trim($myrowcasehistory[0])."',
			'".trim($_POST['Brief_File'])."',
			'".trim($myrowdiaryrec['party'])."',
			'".trim($myrowdiaryrec['oppoparty'])."',
			'".trim($_POST['Result'])."',
			$Closedateupdate,
			'".trim($myrowdiaryrec['courtcaseno'])."',
			'".trim($myrowdiaryrec['courtname'])."',
			'".trim($_POST['Coram'])."',
			'".trim($_POST['Judgementorder'])."',
			'".trim($_POST['Casecloseremark'])."'	
			)";
		
		$result = DB_query($sql,$db);
		
			
		  $sqlcases = "UPDATE lw_cases SET
			 		deleted=1 WHERE brief_file = '".trim($_POST['Brief_File'])."'";						
					 
		$resultcase=DB_query($sqlcases,$db); 
		
		if(isset($result))
		{
		echo 'Case inserted in Case Close History!!!';
		
		?>
		<script>
		
		setTimeout(function () {
			  window.close();}, 2000); 		
		
		</script>
		<?php
        
		}
	}
?>
    <div id="page_content">
        <div id="page_content_inner">
            <div class="md-card">
                <div class="md-card-content">
                    <h3 class="heading_a">Close Case-  <?php echo $_GET['brief_file'];  ?></h3><br>
                  
                  <form action="<?php echo $_SERVER['PHP_SELF'] . '?' . SID; ?>" method="post">
					<div class="uk-width-medium-1-3">
                         <div class="uk-form-row">
                              <div class="uk-grid">
                    <?php 	
			
			echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px">Coram/Judge';
			echo '<input class="md-input" tabindex="1" type="text"  name="Coram" id="Coram" /></div>';
			
			echo '<input type="hidden"  name="Brief_File" id="Brief_File" value="' . $_GET['brief_file'] . '" />';
			    ?>
  <div class="uk-width-medium-1-4" style="padding-bottom:10px">Close Date
    
    <input class="md-input" type="text" name="Closedateupdate" id="Closedateupdate" tabindex="2" data-uk-datepicker="{format:'DD/MM/YYYY'}" >
    </div>
    			
		<?php			    
			$resultcaseclose=DB_query("SELECT id, result FROM lw_casecloseresult",$db);
					           	
			echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px">Result';
			echo '<select tabindex="3" name="Result" id="Result" class="md-input">';
			
			while ($myrowcaseclose = DB_fetch_array($resultcaseclose)) {
					echo '<option VALUE="' . $myrowcaseclose['id'] . '">' . $myrowcaseclose['result'] . '</option>';
					} //end while loop
			
			DB_free_result($resultcaseclose);
			
			echo '</select></div>'; ?>
		
		<div class="uk-width-medium-1-4" style="padding-bottom:10px">
			                                        Remark
		<input class="md-input" tabindex="4" type="text" name="Casecloseremark" id="Casecloseremark" />
              </div>
             <div class="uk-width-medium-1-4" style="padding-bottom:10px">
			  Judgement/Order
              <input class="md-input" tabindex="5" type="text" name="Judgementorder" id="Judgementorder">
		      </div> 
             
                                
              <div class="uk-width-medium-1-4" style="padding-bottom:10px">                  
              <button type="submit" class="md-btn md-btn-primary" name="Submit">Submit</button>
              </div>
                  </form>
            	</div>
            </div>
                
         </div>
              
     </div>  
      
   </div>
                
  </div>
              
 </div>  
      <!--- End of the Page Content    --->      
   <?php include("footersrc.php"); ?>
   
    <!-- JQuery-UI -->
    <link rel="stylesheet" href="assets/skins/jquery-ui/material/jquery-ui.min.css">
    <script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
    
  </body>
</html>