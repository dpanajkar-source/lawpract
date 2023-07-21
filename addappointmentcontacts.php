<?php
$PageSecurity =3;      

include('server_con.php');

//$client=filter_input(INPUT_POST,'jsarray',FILTER_SANITIZE_STRING);

$Name=trim($_POST['contact']);

$sql= "SELECT * FROM lw_contacts WHERE name='" . trim($Name) . "'";
	$result = mysqli_query($con,$sql);
	$myrow = mysqli_fetch_array($result);
	
	echo json_encode($myrow);  
	 

?>