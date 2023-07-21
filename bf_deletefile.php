<?php
include('server_con.php');

//$courtcasenonew=str_replace("/","-",$courtcaseno);

$id=$_POST['id'];
			
$result = mysqli_query($con,"SELECT file_name FROM bf_filesattached WHERE bf_filesattached.id= '" . $_POST['id'] . "'");

$myrowfile=mysqli_fetch_array($result);

$filename=$_SERVER['DOCUMENT_ROOT'] .'/lawpract/bf_files/lpt_'.$_POST['cust_name'].'/'.$myrowfile[0];

unlink($filename);

//Delete from database
$result = mysqli_query($con,"DELETE FROM bf_filesattached WHERE bf_filesattached.id= '" . $_POST['id'] . "'");

 	//Close database connection
	mysqli_close($con);
	
	
	?>