<?php
include('server_con.php');  

$sqlbillno='SELECT totalfees,balance from bf_ind_invoice WHERE billno="' .$_POST['B_no'] . '"';
			
			$resultbillno=mysqli_query($con,$sqlbillno); 
			
			$myrowbillnoajax=mysqli_fetch_array($resultbillno);	
			
			
$economyresult=array();


for($i=0;$i<=1;$i++)
{
$economyresult[$i]=$myrowbillnoajax[$i];
}

echo json_encode($economyresult);



?>  

