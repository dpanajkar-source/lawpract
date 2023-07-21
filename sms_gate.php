<?php
error_reporting (E_ALL ^ E_NOTICE);
$username="dinesh700";
$password ="3820736";
//$number=$_POST['number'];
$sender="LAWPRT";
//$message='Adv.Hemant Pathak :- Mr/Mrs. 123, Your next hearing date is 234 At Court : 89 For Case No : 90. Please be present without Fail';
//$template_id='1507162581390457226';
// $template_id = '1507165562272539465';

$template_id='1507167162426002167';
include('server_con.php');

$sql="SELECT lw_contacts.name,lw_contacts.mobile,lw_trans.brief_file,lw_trans.courtcaseno,lw_trans.nextcourtdate,lw_trans.party,lw_courts.courtname FROM lw_trans INNER JOIN lw_contacts ON lw_trans.party=lw_contacts.id INNER JOIN lw_courts ON lw_trans.courtname=lw_courts.courtid WHERE lw_trans.id='".$_GET['id']."' AND lw_trans.smssent!=1";

$result=mysqli_query($con,$sql);

$myrow=mysqli_fetch_array($result);

//$number=$myrow['mobile'];
$number='7083696700';

$name=$myrow['name'];

$partyid=$myrow['party'];

//$brief_file=$_GET['SelectedUser'];

$courtcaseno=$myrow['courtcaseno'];

$courtname=$myrow['courtname'];

$nextdate=$myrow['nextcourtdate'];
//$nextdate='18/10/2022';

if ($nextdate === "")  {
  	$nextdate = NULL;
} else {
	$date_info = date_parse_from_format('Y/m/d', $nextdate);
	$nextdate = "{$date_info['day']}-{$date_info['month']}-{$date_info['year']}";
}
   
	$sqlcompany = 'SELECT advocatename FROM companies WHERE coycode=1';
	$StatementResultcompany=mysqli_query($con,$sqlcompany);
	$Company = mysqli_fetch_array($StatementResultcompany);	
	// Adv.Hemant Pathak :-  To {#var#}, Next date {#var#}, Court : {#var#}, Case No : {#var#}. Please be present
 /*$message="Adv.Hemant Pathak :- Mr/Mrs. " .  $name .", Your next hearing date is " . $nextdate . ", At Court : " . $courtname . ", For Case No : " . $courtcaseno . '. Please be present without Fail';*/
 
$message = $name .", Next date " . $nextdate . ", Court: " . $courtname . ", Case No: " . $courtcaseno . '. Adv. Pathak';

if($_POST['submitted']=='true')
{ 
if(empty($_POST['number']))
{
echo 'Please enter Mobile number of the Client in the address book first. SMS to blank mobile number is not possible!!!';
exit;

}else
{	

$message = trim($_POST['name']) .", Next date " . trim($_POST['nextdate']) . ", Court: " . trim($_POST['courtname']) . ", Case No: " . trim($_POST['courtcaseno']) . '. Adv. Pathak';

	$url="http://api.bulksmsgateway.in/sendmessage.php?user=".urlencode($username)."&password=".urlencode($password)."&mobile=".urlencode($_POST['number'])."&sender=".urlencode($sender)."&message=".urlencode($message)."&type=".urlencode('3')."&template_id=".urlencode($template_id);
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//echo $curl_scraped_page = curl_exec($ch);
	//curl_close($ch); 
	echo ' The SMS is Sent Successfully!!!';
	

$stmtsms= "INSERT INTO lw_smshistory (brief_file,
					message,
					smsdate,
					party
					)
			VALUES ('" .$_POST['brief_file'] . "',
					'" .$_POST['message'] . "',
					'" . date('Y-m-d') . "',
					'" .$_POST['partyid'] . "'	 
					)";
		
			$result=mysqli_query($con,$stmtsms);	
			
//make smssent=1 in lw_trans for the updated row			

$sqlsmssent = "UPDATE lw_trans SET smssent=1 WHERE id= '".$_POST['id']."'";
                	
			$result=mysqli_query($con,$sqlsmssent);	
			
			// $jsonData = json_decode($curl_scraped_page,true);
//echo "=-=-=-=-=-=-=-=-". $url; //print_r($jsonData);
// echo "=-=-=-=-response=-=-=-=-"; //print_r($curl_scraped_page); exit;

?>

<script>
//window.opener.location.reload();
//window.opener.document.getElementById("smssent").checked=false;

var uncheck=window.opener.document.getElementsByTagName('input');
 for(var i=0;i<uncheck.length;i++)
 {
  if(uncheck[i].type=='checkbox')
  {
   uncheck[i].checked=false;
  }
 }
 
window.close();
</script>
<?php }

}

?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>

    <link rel="icon" type="image/png" href="assets/img/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="assets/img/favicon-32x32.png" sizes="32x32">

    <title>LAWPRACT Ver-1.2.0</title>
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
    
    <script defer src = "jquery-1.11.1.min.js" defer></script>
   

    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
    <![endif]-->

</head>
<body style="background-color:#FFFFFF">

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="sms_gate" >

		<div style="margin-left:50px; background-color:#9ABDD1; margin-right:30px"><h2>SMS Management</h2></div>

  		<div class="uk-width-medium-1-1" style="padding-bottom:0px; padding-left:50px">
        <div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">
         
        <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-2-2">
        <div class="uk-form-row">
        <div class="uk-grid">
        
<!--<div class="uk-width-medium-1-2" style="padding-bottom:10px">
<b>Brief File : </b></div>

<div class="uk-width-medium-1-2" style="padding-bottom:10px">
<input type="text" name="brief_file" value="<?php  //echo $brief_file; ?>" class="md-input" readonly/>
</div>-->
<div class="uk-width-medium-1-2" style="padding-bottom:10px">
<b>Name</b></div>
<div class="uk-width-medium-1-2" style="padding-bottom:10px">
<input type="text" name="partyname" value="<?php  echo $name; ?>" class="md-input" readonly/>
<input type="hidden" name="partyid" id="partyid" value="<?php  echo $partyid; ?>" />
</div>

<div class="uk-width-medium-1-2" style="padding-bottom:10px">
<b>Court Case No : </b></div>
<div class="uk-width-medium-1-2" style="padding-bottom:10px">
<input type="text" name="courtcaseno" value="<?php  echo $courtcaseno; ?>" class="md-input" readonly/>
</div>

<div class="uk-width-medium-1-2" style="padding-bottom:10px">
<b>Court Name : </b></div>
<div class="uk-width-medium-1-2" style="padding-bottom:10px">
<input type="text" name="courtname" value="<?php  echo $courtname; ?>" class="md-input" readonly/>
</div>

<div class="uk-width-medium-1-2" style="padding-bottom:10px">
<b>Number : </b></div>
<div class="uk-width-medium-1-2" style="padding-bottom:10px">
<input type="text" name="number" value="<?php  echo $number; ?>" class="md-input" readonly/>
</div>

<div class="uk-width-medium-1-2" style="padding-bottom:10px">
<b>Message:</b></div>
<div class="uk-width-medium-1-1" style="padding-bottom:10px"><textarea name="message" class="md-input" style="border-color:#006699" ><?php echo $message; ?></textarea></div>

<input type="hidden" name="submitted" value="true" />
<input type="hidden" name="sender" value="<?php echo $sender; ?>" />
<input type="hidden" name="username" value="<?php echo $username; ?>" />
<input type="hidden" name="name" value="<?php echo $name; ?>" />
<input type="hidden" name="courtcaseno" value="<?php echo $courtcaseno; ?>" />
<input type="hidden" name="courtname" value="<?php echo $courtname; ?>" />
<input type="hidden" name="nextdate" value="<?php echo $nextdate; ?>" />
<input type="hidden" name="password" value="<?php echo $password; ?>" />
<input type="hidden" name="id" id="id" value="<?php echo $_GET['id']; ?>">
<input type="hidden" name="brief_file" id="brief_file" value="<?php echo $myrow['brief_file']; ?>">




<div class="uk-width-medium-1-1"  align="left" style="padding-bottom:10px">
<input type="submit" name="submit" value="Send SMS" class="md-btn md-btn-primary" style="text-align:center" />
</div>

</div>
</div>

</div>
</div>
</form>

<script>

window.onbeforeunload = function (e) {

var uncheck=window.opener.document.getElementsByTagName('input');
 for(var i=0;i<uncheck.length;i++)
 {
  if(uncheck[i].type=='checkbox' && uncheck[i].disabled==false)
  {
   uncheck[i].checked=false;
  }
 }
 
};

</script>
</body>
</html>