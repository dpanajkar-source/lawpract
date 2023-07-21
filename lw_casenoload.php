<?php
$PageSecurity = 4;


include('includes/session.php');


$sqlcaseno='SELECT courtcaseno from lw_cases WHERE party="' .$_POST['clientid'] . '"';
			
			$resultcaseno=DB_query($sqlcaseno,$db); 
			
			while($myrowcasenoajax=DB_fetch_array($resultcaseno))
			{
			echo '<option value="' . $myrowcasenoajax['courtcaseno'] . '">' . $myrowcasenoajax['courtcaseno'] . "</option>";
			
			}


?>  

