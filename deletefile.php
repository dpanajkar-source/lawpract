<?php
include('server_con.php');

$brief_file=explode("/",$_POST['brief_file']);
$courtcaseno=$_POST['courtcaseno'];

//$courtcasenonew=str_replace("/","-",$courtcaseno);

$party=$_POST['party'];
			
$result = mysqli_query($con,"SELECT file_name FROM lw_filesattached WHERE lw_filesattached.id= '" . $_POST['fileid'] . "'");

$myrowfile=mysqli_fetch_array($result);

$filename=$_SERVER['DOCUMENT_ROOT'] .'/lawpract/cases/lpt_'.$party.'/'.$myrowfile[0];

unlink($filename);

//Delete from database
$result = mysqli_query($con,"DELETE FROM lw_filesattached WHERE lw_filesattached.id= '" . $_POST['fileid'] . "'");

 	//Close database connection
	mysqli_close($con);
	
	
	?>