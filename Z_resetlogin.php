<?php

$PageSecurity = 6;
include('config.php');  

$rootpath = dirname($_SERVER['PHP_SELF']);

$con=mysqli_connect("localhost","root",$dbpassword);
mysqli_select_db($con,"lawpract");

$result=mysqli_query($con,"UPDATE www_users SET blocked=0 WHERE www_users.userid='owner' OR www_users.userid='" .trim($_SESSION['UserID']). "'");

header('Location:' . $rootpath . '/index.php');

?>