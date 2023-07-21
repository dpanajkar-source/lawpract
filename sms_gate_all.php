<?php
error_reporting (E_ALL ^ E_NOTICE);
$username="dinesh700";
$password ="7083696700";

include('server_con.php');

//search for all cases whose next dates fall this week
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

$sql = 'SELECT lw_trans.id,lw_contacts.name,lw_contacts.mobile,lw_trans.courtcaseno,lw_trans.nextcourtdate,lw_trans.party,lw_courts.courtname FROM lw_trans INNER JOIN lw_contacts ON lw_trans.party=lw_contacts.id INNER JOIN lw_courts ON lw_trans.courtname=lw_courts.courtid WHERE lw_trans.nextcourtdate >="' . date("Y-M-d") . '" AND lw_trans.nextcourtdate <"' . $weekend .'" AND lw_trans.smssent!=1 ORDER BY lw_trans.nextcourtdate ASC';
	
$StatementResults=mysqli_query($con,$sql);

while($myrow=mysqli_fetch_array($StatementResults))
	{

$number=$myrow['mobile'];
$name=$myrow['name'];

$partyid=$myrow['party'];

$courtcaseno=$myrow['courtcaseno'];

$courtname=$myrow['courtname'];

$nextdate=$myrow['nextcourtdate'];

if ($nextdate === "") 
  	 $nextdate = NULL;
   else {
      $date_info = date_parse_from_format('Y/m/d', $nextdate);
      $nextdate = "{$date_info['day']}-{$date_info['month']}-{$date_info['year']}";
   }

 $sender="LAWPRT";
 //$message=$_POST['message'];  // will be predefined...
 
$message="Mr./Mrs.". $name . ", Your next hearing date is " . $nextdate . " At Court : " . $courtname . " For Case No:" . $courtcaseno . '. Please be present without Fail'; 

if(empty($number))
{
continue;

}else
{
$url="login.bulksmsgateway.in/sendmessage.php?user=".urlencode($username)."&password=".urlencode($password)."&mobile=".urlencode($number)."&sender=".urlencode($sender)."&message=".urlencode($message)."&type=".urlencode('3'); 

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);

$curl_scraped_page = curl_exec($ch);

curl_close($ch); 

$stmtsms= "INSERT INTO lw_smshistory (message,
					smsdate,
					party
					)
			VALUES ('" .$message . "',
					'" . date('Y-m-d') . "',
					'" .$myrow['id'] . "'	 
					)";
		
			$result=mysqli_query($con,$stmtsms);	
			
//make smssent=1 in lw_trans for the updated row			

$sqlsmssent = "UPDATE lw_trans SET smssent=1 WHERE id= '".$myrow['id']."'";
                	
			$result=mysqli_query($con,$sqlsmssent);	
			
  }//end of else statement if mobile number is valid for the client
}//end of while loop for sending sms to all cases for this week



echo 'All SMS\'s have been Sent Successfully!!!';

?>