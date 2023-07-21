<?php
include('server_con.php');

$group=$_POST['Group'];


if($group=='Sundry Creditors')
{
$group='Accounts Payable';
}

$sqlglcode= 'SELECT accountcode FROM chartmaster where group_="' . trim($group) . '" ORDER BY accountcode DESC LIMIT 1';
	
		$result=mysqli_query($con,$sqlglcode);
		
		$myrowglcode=mysqli_fetch_array($result);
		
		echo $myrowglcode[0]+1;

?>
