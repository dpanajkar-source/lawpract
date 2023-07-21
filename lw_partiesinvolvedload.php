<?php
$PageSecurity = 4;


include('includes/session.php');


$sqlrole='SELECT roleid, role FROM lw_partiesinvolved';
			
			$resultrole=DB_query($sqlrole,$db); 
		
			while($myrowroleajax=DB_fetch_array($resultrole))
			{
			echo '<option value="' .$myrowroleajax['roleid'] . '">' . $myrowroleajax['role'] . "</option>";
			
			}



?>  

