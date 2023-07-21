<?php
$PageSecurity =3;
include('server_con.php');

$invoiceno=trim($_POST['invoiceno']);

$id=trim($_POST['id']);


	$sql = "UPDATE lw_partytrans SET invoiceno='" . trim($invoiceno) . "' WHERE id= '" . $id . "'";
	
	$result=mysqli_query($con,$sql);

?>