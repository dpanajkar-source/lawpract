<?php

$con=mysqli_connect('lawpract.com.mysql', 'lawpract_com_lawpract_com', 'K4EgMvpo', 'lawpract_com_lawpract_com');


//mysqli_select_db($con,"lawpract_com");

//below we will only update the registration details and not insert

$datasent=1;


 $DateString = $_POST['subscriptionvalid'];
	
		$date = new DateTime($DateString);
                //$date->sub(new DateInterval('P1D'));  
				
		$date->add(new DateInterval('P3M'));  		
		
		
/*
$sql = "UPDATE registration SET
			uma='".trim($_POST['own'])."',
			subscriptionvalid='".trim($date->format('Y-m-d'))."',
			datareceived='". $datasent ."'
			WHERE useremail='".$_POST['userEmail']."'";
			
			$sql = "INSERT INTO registration(
			id,
			useremail,
			usermobile,
			uma,
			product,
			currentversion,
			subscriptionvalid,
			datareceived
			)
			VALUES ('".trim($_POST['id'])."',
			'".trim($_POST['userEmail'])."',
			'".trim($_POST['userMobile'])."',
			'". sha1($_POST['own']) ."',
			'". $re[5] ."',
			'". $re[4] ."',
			'". $date->format('Y-m-d') ."',
			'". $datasent ."')";
			
		
$result=mysqli_query($con,$sql);*/

//now make an entry in regisration2 table as well
	$sql = "INSERT INTO registration2(
			useremail,
			usermobile,
			ownername,
			uma,
			subscriptionvaild
			)
			VALUES ('".trim($_POST['userEmail'])."',
			'".trim($_POST['userMobile'])."',
			'".trim($_POST['ownername'])."',
			'". $_POST['own'] ."',
			'".trim($date->format('Y-m-d'))."')";
			
		
$result=mysqli_query($con,$sql);


$sql="SELECT * from registration2 WHERE userEmail='".trim($_POST['userEmail'])."'";
		
$result=mysqli_query($con,$sql);

$resp=mysqli_num_rows($result);

echo $resp;
		
	
	//$row=mysqli_fetch_array($result);
	
	//echo $row['user_activation_key'];



?>





?>