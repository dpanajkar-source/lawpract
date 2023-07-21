<?php

require_once('server_con.php'); 
 
$result = mysqli_query($con,"SELECT noticeno,
date_format(noticedt,\"%d/%m/%Y\") as noticedt,
sendmode,
postrecptno,
date_format(receiptdt,\"%d/%m/%Y\") as receiptdt,
date_format(returnenvelopdt,\"%d/%m/%Y\") as returnenvelopdt,
receivedby,
remark,
date_format(claimdate,\"%d/%m/%Y\") as claimdate,
noticefees,
postage,
othercharges FROM lw_notices where noticeno='" . trim($_POST['Notice_nohidden']) . "'");

 
$myrow=mysqli_fetch_array($result);


echo json_encode($myrow);

//date_format(noticedt,"%d/%m/%Y")  noticeno,date_format(noticedt,\"%d/%m/%Y\") as noticedt,postrecptno,noticepostdt,rpadreceiptdt,returnenvelopdt,receivedby,handdeldt,remark



?>