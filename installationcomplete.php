 <!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en"> <!--<![endif]--><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>

    <link rel="icon" type="image/png" href="install/assets/img/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="install/assets/img/favicon-32x32.png" sizes="32x32">

    <title>LawPract</title>

    <!-- additional styles for plugins -->
     
    
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
    
    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
    <![endif]-->
    <style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-weight: bold;
}
-->
    </style>
    </head>


<?php 
require_once('config.php');  

	if(isset($_POST['uninstall']))
	{
	  
	 $con=mysqli_connect("localhost","root",$dbpassword);
	  mysqli_select_db($con,"lawpract");
	  
	  $result=mysqli_query($con,"DROP DATABASE lawpract");
	  
	  unlink('lic.txt');
	  
	  echo 'LAWPRACT Uninstalled';
	  
	  header('Location: ../lawpract/install/welcome.php');

	
	}
      
    ?>     
 
<div id="page_content">
        <div id="page_content_inner">
        
           <div class="md-card" >
<div style="text-align:center">
		<p><img src="assets/img/logo_main.png" alt="Logo"/></p>
		<p> <span class="style1">Your email and phone are verified</span> <img src="img/ok.png" width="45" height="38" align="absmiddle" /></p>
		<h2>LawPract Installation is Completed</h2>

<form name="installcomplete" action="../lawpract/installationcomplete.php" method="post">
  <table align="center" style="uk-table">
  <tr><td>
        <font face="Arial" size="3">
                
        <a style="color:#ffffff; font-weight:bold; text-transform:capitalize;" class="md-btn md-btn-block md-btn-primary md-btn-wave-light waves-effect waves-button waves-light" href="index.php" target="_blank" > START </a>
       </td>
       <td>
       
       </td>
       <td>        
        <input type="submit" name="uninstall" id="uninstall" value="Uninstall" accesskey="u" class="md-btn"  />
        
        </td>
        </tr>
        </table>
        </form>
        <h3 id="welcomeLink"><a href="http://www.lawpract.com" target="_blank" tabindex="36">www.lawpract.com</a></h3>
</div>
</div>
</div>
</div>




<?php

	

//echo 'license key=' . generate_key_string();

function generate_key_string() {
 
    $tokens = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $segment_chars = 5;
    $num_segments = 4;
    $key_string = '';
 
    for ($i = 0; $i < $num_segments; $i++) {
 
        $segment = '';
 
        for ($j = 0; $j < $segment_chars; $j++) {
                $segment .= $tokens[rand(0, 35)];
        }
 
        $key_string .= $segment;
 
        if ($i < ($num_segments - 1)) {
                $key_string .= '-';
        }
 
    }
 
    return $key_string;
 
}

?>