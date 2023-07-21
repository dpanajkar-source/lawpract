<?php
include('server_con.php');  
 
$result = mysqli_query($con,"SELECT date_format(replydt,\"%d/%m/%Y\") as replydt,replypostrecptno,date_format(replypostdt,\"%d/%m/%Y\") as replypostdt,date_format(replyrpadreceiptdt,\"%d/%m/%Y\") as replyrpadreceiptdt,date_format(replyreturnenvelopdt,\"%d/%m/%Y\") as replyreturnenvelopdt,replyreceivedby,date_format(replyhanddeldt,\"%d/%m/%Y\") as replyhanddeldt,replyremark FROM lw_noticereply where noticeno='" . trim($_POST['Notice_nohidden']) . "'");
 
$myrow=mysqli_fetch_array($result);


echo json_encode($myrow);

//date_format(handdeldt,\"%d/%m/%Y\") as


?>