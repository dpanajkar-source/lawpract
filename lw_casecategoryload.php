<?php
$PageSecurity = 4;


include('includes/session.php');


$sqlcasecat='SELECT casecatid,casecat from lw_casecat';
			
			$resultcasecat=DB_query($sqlcasecat,$db); 
			
			while($myrowcasecatajax=DB_fetch_array($resultcasecat))
			{
			echo '<option value="' . $myrowcasecatajax['casecatid'] . '">' . $myrowcasecatajax['casecat'] . "</option>";
			
			}



?>  

