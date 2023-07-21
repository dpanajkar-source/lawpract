<?php 
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
      
    
    <!-- uikit -->
    <link rel="stylesheet" href="bower_components/uikit/css/uikit.almost-flat.min.css" media="all">
    <!-- altair admin -->
    <link rel="stylesheet" href="assets/css/main.css" media="all">

    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
    <![endif]-->

</head>
<body class=" sidebar_main_open sidebar_main_swipe">

    <?php include("header.php"); ?>
    <?php include("menu.php"); ?>

    <div id="page_content">
        <div id="page_content_inner">
            <div class="md-card">
                <div class="md-card-content">
               
<div style="padding-bottom:10; text-align:center">
  <p><img src="assets/img/logo_main_2x.png" alt="lawpract" longdesc="http://lawpract.com"></p>
  <p align="left"><img src="img/certificate Lawpract.png" width="190" height="238" align="left"></p>
</div>
<?php

$sql='SELECT subscriptionvalid FROM registration';

$result=DB_query($sql,$db);

$myrow=DB_fetch_array($result);

if($myrow['subscriptionvalid']<Date('Y-m-d'))
{

echo '<p>&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp&nbsp;&nbspYour LAWPRACT subscription has expired. Please renew it by clicking on the following link</p>'; 

}

$datetime2 = new DateTime($myrow['subscriptionvalid']);
$datetime1 = new DateTime(Date('Y-m-d'));
$interval = $datetime1->diff($datetime2);


?>


<div class="uk-width-medium-1-1" style="padding-bottom:0px">
<div class="uk-grid uk-grid-width-1-2 uk-grid-width-large-1-2"> 

<div class="uk-width-medium-1-2" style="padding-bottom:10px"><b>Software Status</b>  : Active
</div>
<div class="uk-width-medium-1-2" style="text-align:right"></div>
<div class="uk-width-medium-1-1" style="padding-bottom:10px">

  <p><b>License:No. of days left</b> - <?php echo $interval->format('%R%a days');  ?></p>
  <p><b>Activation Date</b>: <?php echo Date('d/m/Y'); ?>  </p>
  <p><b>Expiration Date</b>: <?php echo ConvertSQLDate($myrow['subscriptionvalid']); ?> </p>
</div>

<div class="uk-width-medium-1-1" style="padding-bottom:10px">
<b>Links</b> : www.lawpract.com/shop</div>

<div class="uk-width-medium-1-1" style="padding-bottom:10px; text-align:justify; color:#FF0000">
Warning: Please renew your license before expiration date. The software will start alerting the user one month prior to expiry.</div>

  <form method="post" action="index.php" >
  <input type="submit" class="md-btn md-btn-primary" value="Close" name="ok" />
  </form>




</html>
                  
            	</div>
            </div>
                
         </div>
              
     </div>  
      
      <!--- End of the Page Content    --->      
            

<?php include('footersrc.php')   ?>
    
   
</body>
</html>