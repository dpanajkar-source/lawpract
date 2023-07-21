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

    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
    <![endif]-->
    
    <link rel="stylesheet" type="text/css" href="dist/sweetalert.css">
      
   <script src="dist/sweetalert-dev.js"></script>

    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
    <![endif]-->

</head>
<body class=" sidebar_main_open sidebar_main_swipe">

    <div id="page_content">
        <div id="page_content_inner">
            <div class="md-card">
                <div class="md-card-content">
                    
    <?php
    $PageSecurity = 3;
     include('includes/session.php');
	 include("header.php");  
     include("menu.php");   


if (isset($_POST['Submit'])) 
{

    $sql = "UPDATE lw_contacts SET
			name=TRIM(name),
			address=TRIM(address),
            landline=TRIM(landline),
			mobile=TRIM(mobile),
            mobile1=TRIM(mobile1),
            email=TRIM(email)";
    
     $result=DB_query($sql,$db);	
    
    
		?>
	
    <script>
		
swal({   title: "Database Repaired!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('index.php'); //will redirect to your page
}, 2000); 


	</script>
                        
       <?php
	 

}

?>
                    <h3 class="heading_a">Repair Database</h3>
                  	<form action="<?php echo $_SERVER['PHP_SELF'] . '?' . SID; ?>" method="post">
					<div class="uk-width-medium-1-3">
                         <div class="uk-form-row">
                              <div class="uk-grid" style="overflow: visible; text-align: left">
                              
                              <div >
                                <img class="md-user-image" src="databackup.png" alt=""/>
                                <br><label> Click Submit to repair your Database </label>
                   				<br><label> We recommend that Save your Lawpract Database First using backup wizard</label>
                    			<br><label> on another drive than C drive( ex D:, E:, F:) or external drive.</label> 
                                <br><p>It is highly recommended to Repair Database regularly perhaps every week. </p>
                                  <p>During data saving and database related transactions, frequently data stored in the database tables also contain empty spaces or characters unknowningly. </p>
                                  <p>Using this tool will remove all trailing spaces from data stored thereby cleaning the database. </p>
                                  <p>This is very important for getting desired results with respect to reports, data sorting and searches. </p>                                    
                    			<div class="uk-width-1-1" style="text-align: center">
                                <button type="submit" class="md-btn md-btn-primary" name="Submit">Submit</button>
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
  <?php include('footersrc.php');  ?>
    
  </body>
</html>