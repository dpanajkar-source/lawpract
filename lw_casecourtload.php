<?php
$PageSecurity = 4;


include('includes/session.php');


$sqlcourt='SELECT courtid,courtname from lw_courts';
			
			$resultcourt=DB_query($sqlcourt,$db); 
		
			while($myrowcourtajax=DB_fetch_array($resultcourt))
			{
			echo '<option value="' .$myrowcourtajax['courtid'] . '">' . $myrowcourtajax['courtname'] . "</option>";
			
			}



?>  

