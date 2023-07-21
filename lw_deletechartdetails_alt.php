<?php
$PageSecurity = 5;
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
        <!-- weather icons -->
       
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
    
    
    <!-- Live Search Styles -->
    <link rel="stylesheet" href="css/fontello.css">
    <link rel="stylesheet" href="css/animation.css">
    <!--[if IE 7]>
    <link rel="stylesheet" href="css/fontello-ie7.css">
    <![endif]-->
   
</head>
<body class=" sidebar_main_open sidebar_main_swipe">

    <?php
       include("header.php"); ?>
    <?php include("menu.php"); 
    
    
    ?>

    <div id="page_content">
        <div id="page_content_inner">
            <div class="md-card">
                <div class="md-card-content">
                    <h3 class="heading_a">Delete Chart Details</h3>
                    <div class="uk-width-medium-1-1" style="padding-bottom:10px" class="md-input-wrapper">
    
	<div class="uk-grid uk-grid-width-1-4 uk-grid-width-medium-1-2" data-uk-grid-margin="5">	
    
    	
            
            <div class="uk-width-medium-1-1" style="padding-bottom:10px"><label>Case Number</label>
			<label>Chart Details are the backbone of the account system. For all periods defined, chart details contain all the actual and brought forward balances of all General Ledger Accounts. This table contains vital data to print P & L, Trial Balance and Balance Sheet. In case the user wishes to delete the chart details table due to serious accouting entry errors (which the user is not able to revert back to last perfect working version), they can use this utility to delete chart details. The chart detail entries are automatically created when user tries to view any of the accounting reports. So it is safe to delete chart details and system will restore it to working condition automatically. </label></div>
            
            <?php
            
            echo "<form method='POST' action=" . $_SERVER['PHP_SELF'] . '?' . SID . '>';?>
            
           <div class='centre'><input type='submit' name='Show' class='md-btn md-btn-primary' VALUE='Delete Chart Details'></div></form>
			
		       
</div></div></div></div></div>
            
<div>
                   

      
      <!--- End of the Page Content    --->      
    <?php
	
	include('footersrc.php');
	
	
	?>        
    
    
</body>
</html>

<?php


/* End of the Form  rest of script is what happens if the show button is hit*/

if (isset($_POST['Show'])){

$sql=DB_query('TRUNCATE chartdetails',$db);

$sql = "UPDATE gltrans SET posted=0";
		$result=DB_query($sql,$db);
}


?>