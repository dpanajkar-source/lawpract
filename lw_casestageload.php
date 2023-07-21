<?php
$PageSecurity = 4;

   
include('includes/session.php');


$sqlstage='SELECT stageid,stage from lw_stages';
			
			$resultstage=DB_query($sqlstage,$db); 
			
		while($myrowstageajax=DB_fetch_array($resultstage))
			{
			echo '<option value="' .$myrowstageajax['stageid'] . '">' . $myrowstageajax['stage'] . "</option>";
			
			}



?>  