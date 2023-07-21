<?php
$PageSecurity = 4;

include('config.php');  

include('server_con.php'); 


$sqlbankbranchno='SELECT id,branch_area from bf_bank_branch WHERE bank_id="' .$_POST['bankid'] . '"';
			
			$resultbranchno=mysqli_query($con,$sqlbankbranchno); 
			
			while($myrowbranchnoajax=mysqli_fetch_array($resultbranchno))
			{
			echo '<option value="' . $myrowbranchnoajax['id'] . '">' . $myrowbranchnoajax['branch_area'] . "</option>";
			
			}

?>  