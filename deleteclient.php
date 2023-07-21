<?php
/*
 * 
 * http://editablegrid.net
 *
 * Copyright (c) 2011 Webismymind SPRL
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://editablegrid.net/license
 */
      
include('server_con.php');

//Delete from database
$result = mysqli_query($con,"DELETE FROM lw_otherclients WHERE lw_otherclients.id= '" . $_POST['clientid'] . "'");     

	//Close database connection
	mysqli_close($con);	
	
	?>