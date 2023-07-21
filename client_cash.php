<?php
include('server_con.php');
 

//$client=filter_input(INPUT_POST,'jsarray',FILTER_SANITIZE_STRING);

$brief_file=$_POST['brief_file'];

//fetch total money and balance from lw_partyeconomy	
$result = mysqli_query($con,"SELECT totalfees,balance,glcode,invoiceno FROM lw_partyeconomy WHERE lw_partyeconomy.brief_file='".$brief_file."'");

$myroweconomy=mysqli_fetch_array($result);

//fetch money received till date from lw_partytrans

//$resulttrans = mysqli_query($con,"SELECT COUNT(amountreceived) FROM lw_partytrans WHERE lw_partytrans.brief_file='".$brief_file."'");

//$myrowtrans=mysqli_fetch_array($resulttrans);

$economyresult=array();

//$transresult=array();

for($i=0;$i<=3;$i++)
{
$economyresult[$i]=$myroweconomy[$i];
}

echo json_encode($economyresult);



?>