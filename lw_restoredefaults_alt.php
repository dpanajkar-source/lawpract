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
       
        <link rel="stylesheet" href="bower_components/chartist/dist/chartist.min.css">
    
    <!-- uikit -->
    <link rel="stylesheet" href="bower_components/uikit/css/uikit.almost-flat.min.css" media="all">

    <!-- flag icons -->
    <link rel="stylesheet" href="assets/icons/flags/flags.min.css" media="all">

    <!-- altair admin -->
    <link rel="stylesheet" href="assets/css/main.css" media="all">

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
	 
	 ?>
    <div id="page_content">
        <div id="page_content_inner">
            <div class="md-card">
                <div class="md-card-content">
                
                <?php

if (isset($_POST['Submit'])) 
{

// Enter your MySQL access data  
    
    
        
        //first delete the lawpract database completely
        
        $sql = "TRUNCATE lawpract";
		$result=DB_query($sql,$db);

	
$sqlFileName='sql/lawpract.sql';

echo $sqlFileName;

$mysqlDumpCommand = 'C:\xampp\mysql\bin\mysql --user=root --host=localhost --password="" lawpract'.' < '.$sqlFileName;
system($mysqlDumpCommand);     
    
			?>
	
    <script>
		
swal({   title: "System Restored to its Factory Defaults!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('index.php'); //will redirect to your page
}, 2000); 


	</script>
                        
       <?php	
		
}

?>
                    <h3 class="heading_a">Restore to System Defaults</h3>
                  	<form enctype="multipart/form-data"  action="<?php echo $_SERVER['PHP_SELF'] . '?' . SID; ?>" method="post">
					<div class="uk-width-medium-1-3">
                         <div class="uk-form-row">
                              <div class="uk-grid"><!-- The data encoding type, enctype, MUST be specified as below -->
                                                       
                              <div class="uk-text-center">
                               <br><label> Click Restore the software to its Factory Defaults </label>
                               
                   			                                
                              <br><label>Please be aware that this Operation will overwrite the existing database. You will loose all your data entered till date and the system will be setup with factory defaults.   </label>                                         
                    			<div class="uk-width-1-1">
                                <button type="submit" class="md-btn md-btn-primary" name="Submit">Restore System Defaults</button>
                     			</div>
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
            
    <!-- common functions -->
    <script src="assets/js/common.min.js"></script>
    <!-- uikit functions -->
    <script src="assets/js/uikit_custom.min.js"></script>
    <!-- altair common functions/helpers -->
    <script src="assets/js/altair_admin_common.min.js"></script>

    <!-- page specific plugins -->
     
        <!-- metrics graphics (charts) -->
       
        <!-- handlebars.js -->
        <script src="bower_components/handlebars/handlebars.min.js"></script>
        <script src="assets/js/custom/handlebars_helpers.min.js"></script>
       

        <!--  dashbord functions -->
        <script src="assets/js/pages/dashboard.min.js"></script>
    
  </body>
</html>