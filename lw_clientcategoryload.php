<?php
$PageSecurity = 4;


include('includes/session.php');


$sqlclientcat='SELECT clientcatid,category from lw_clientcat';
			
			$resultclientcat=DB_query($sqlclientcat,$db); 
			
			while($myrowclientcatajax=DB_fetch_array($resultclientcat))
			{
			echo '<option value="' . $myrowclientcatajax['clientcatid'] . '">' . $myrowclientcatajax['category'] . "</option>";
			
			}



?>  

