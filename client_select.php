<?php
include('server_con.php');
$result = mysqli_query($con,"SELECT accountcode,accountname FROM chartmaster where accountname='" . trim($_POST['name']) . " Ac'");
 
$myrow=mysqli_fetch_array($result);

echo json_encode($myrow);


?>