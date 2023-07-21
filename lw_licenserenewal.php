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

    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
    <![endif]-->

</head>
<body style="width:700px; margin-left:300px">

  
    <div id="page_content">
        <div id="page_content_inner">
            <div class="md-card">
                <div class="md-card-content">
                
<?php

require_once('config.php');  
			
 if(isset($_POST['Checkrenewal']))

{				
				//here we will send mac of the hardware to our server as well 
ob_start();
//Get the ipconfig details using system commond
system('ipconfig /all');

// Capture the output into a variable
$mycom=ob_get_contents();
// Clean (erase) the output buffer
ob_clean();

$findm = "Physical";
//Search the "Physical" | Find the position of Physical text
$pme = strpos($mycom, $findm);

// Get base
$own=substr($mycom,($pme+36),17);


$con=mysqli_connect("localhost","root",$dbpassword);
mysqli_select_db($con,"lawpract");

//check for subscription

$result=mysqli_query($con,"SELECT useremail,usermobile,uma,subscriptionvalid FROM registration");


$myrow=mysqli_fetch_array($result);


$host = '127.0.0.1'; //dummy. here actual static IP of lawpract site on our server
	
	$method = 'POST';
	$path = '/registration/registrationacquired.php';
	$data = "userEmail=".$myrow['useremail']
			."&userMobile=".$myrow['usermobile']
			."&own=".$myrow['uma']
			."&subscriptionvalid=".$myrow['subscriptionvalid'];
			
			$fp=@fsockopen($host,80);
		
	if(!$fp)
	{
	
		echo '<div style="text-align:center; color:FF0000; font-weight:bold; margin-top:200px">Your pc seems to be offline as There is no Internet connection. Please connect it to internet to complete LAWPRACT installation which is required.</div>';
		
		?>
  <script> 
setTimeout(newDoc, 3000);
function newDoc() {
    window.location.assign("lw_licenserenewal.php");
}


	</script>
                        
       <?php

		return false;
	
	}else
	{
	
	    fputs($fp, "POST $path HTTP/1.1\r\n");
	    fputs($fp, "Host: $host\r\n");
	    fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
	    fputs($fp, "Content-length: " . strlen($data) . "\r\n");
	    fputs($fp, "User-Agent: ".$_SERVER['HTTP_USER_AGENT']."\r\n");
	    fputs($fp, "Connection: close\r\n\r\n");
	    fputs($fp, $data);
						
	    $resp = '';
	    while (!feof($fp)) {
			$resp=fgets($fp,128);
			
			   }
			
		fclose($fp);
			 
	 }
	 
	
	$re=explode(',',$resp);
	
	//echo $myrow['subscriptionvalid'];
	
		if($re['3']>$myrow['subscriptionvalid'])
		{		
		
		echo 'validity extended by another year';
		
		$con=mysqli_connect("localhost","root",$dbpassword);
		mysqli_select_db($con,"lawpract");
		
		$sql = "UPDATE registration SET
					subscriptionvalid='".trim($re['3'])."'";
					
				
		$result=mysqli_query($con,$sql);
		
		
		
	    }else
		{
		echo 'If you have already paid for extended subscription, our server will update your subscription in a short time. Please check your subscription again after a day or two. If you have not paid for extension, kindly do so by visiting www.lawpract.com';
		}	
				

}//end of $_POST['Checkrenewal'] 				
				?>
               
<div style="padding-bottom:10; text-align:center">
  <p><img src="assets/img/logo_main_2x.png" alt="lawpract" longdesc="http://lawpract.com"></p>
  <p><img src="img/certificate Lawpractlapsed.png" width="159" height="216" align="left"></p>
</div>

<div class="uk-width-medium-1-1" style="padding-bottom:0px">
<div class="uk-grid uk-grid-width-1-2 uk-grid-width-large-1-2"> 
<div class="uk-width-medium-1-1" style="padding-bottom:10px; color:#FF0000">
  <p>Your LAWPRACT subscription has expired.Manage, Monitor, Safeguard your office work.</p>
  <p>Act now and extend your subscription at rs. 1000/- only per annum</p>
</div>


<div class="uk-width-medium-1-2" style="padding-bottom:10px"> Software Status  : Expired
</div>
<?php

$con=mysqli_connect("localhost","root",$dbpassword);
mysqli_select_db($con,"lawpract");

//check for subscription

$result=mysqli_query($con,"SELECT useremail,usermobile,uma,subscriptionvalid FROM registration");


$myrow=mysqli_fetch_array($result);


 $DateString =$myrow['subscriptionvalid'];
	
		$date = new DateTime(FormatDateForSQL($DateString));
                //$date->sub(new DateInterval('P1D'));  
				
		$date->add(new DateInterval('P1Y'));
		
		
	
?>

<div class="uk-width-medium-1-2" style="text-align:right"></div>
<div class="uk-width-medium-1-1" style="padding-bottom:10px">

  <p>License: No. of days left : 0</p>
  <p>Activation Date: <?php echo $myrow['subscriptionvalid']; ?> </p>
  <p>Expiration Date: <?php echo $date->format('Y-m-d'); ?> </p>
</div>

<div class="uk-width-medium-1-1" style="padding-bottom:10px; color:#669966"><b>
For Renewal (1 Year Subscription): <a href= "http://www.lawpract.com/shop" target="_blank"> Click here </b></a> </div>

  <form method="post" action="index.php" >
  <input type="submit" class="md-btn md-btn-primary" value="Click after making online Payment" name="Checkrenewal" />
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