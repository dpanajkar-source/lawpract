<?php
$PageSecurity = 4;

include('server_con.php');

$sqlbillno='SELECT billno from bf_ind_invoice WHERE custid="' .$_POST['custid'] . '"';
			
			$resultbillno=mysqli_query($con,$sqlbillno); 
			
			while($myrowbillnoajax=mysqli_fetch_array($resultbillno))
			{
			echo '<option value="' . $myrowbillnoajax['billno'] . '">' . $myrowbillnoajax['billno'] . "</option>";
			
			}


?>  

