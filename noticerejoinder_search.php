<?php
include('server_con.php');  
 
$result = mysqli_query($con,"SELECT date_format(rejdt,\"%d/%m/%Y\") as rejdt,rejpostrecptno,date_format(rejpostdt,\"%d/%m/%Y\") as rejpostdt,date_format(rejrpadreceiptdt,\"%d/%m/%Y\") as rejrpadreceiptdt,date_format(rejreturnenvelopdt,\"%d/%m/%Y\") as rejreturnenvelopdt,rejreceivedby,date_format(rejhanddeldt,\"%d/%m/%Y\") as rejhanddeldt,rejremark FROM lw_noticerejoinder where noticeno='" . trim($_POST['Notice_nohidden']) . "'");
 
$myrow=mysqli_fetch_array($result);


echo json_encode($myrow);


?>