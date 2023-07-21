<?php
$PageSecurity=1;
include('includes/session.php');

$title=_('Address Book');

include('includes/header.php');

include('includes/SQL_CommonFunctions.inc');

echo '<link href="'.$rootpath. '/style.css" rel="stylesheet" type="text/css" />';
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

<!--
/*
 * examples/mysql/index.html
 * 
 * This file is part of EditableGrid.
 * http://editablegrid.net
 *
 * Copyright (c) 2011 Webismymind SPRL
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://editablegrid.net/license
 */
-->

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		
		<link rel="stylesheet" href="style.css" type="text/css" media="screen">
		<link rel="stylesheet" href="responsive.css" type="text/css" media="screen">

       	<link rel="stylesheet" href="font-awesome-4.1.0/css/font-awesome.min.css" type="text/css" media="screen">
        	</head>
	
	<body>
    <div style="float:right; position:static; margin-right:20px; text-decoration:none"><a href="index.php"><img src="home.png" /><br /><label>Home</label></a></div>
		<div id="wrap">
		<label style="font-size:24px; font-weight:bold;">Address Book - Permanent Deletion </label> 
        <label style="font-size:12px; font-weight:bold;">  (Please take utmost caution while deleting a contact as their associated Cases will fail to load and operate if deleted)</label> 
         <div align="right" style="float:right"> <img src="help-over.png" onClick="MM_openbrwindow('doc/manual/Manualdeletecontacts.php',800,300)"  style="cursor:pointer;" />
     </div>
		
			<!-- Feedback message zone -->
			<div id="message"></div>

            <div id="toolbar">
              <input type="text" id="filter" name="filter" placeholder="Filter :type any text here"  />
              
            </div>
			<!-- Grid contents -->
			<div id="tablecontent"></div>
		
			<!-- Paginator control -->
			<div id="paginator"></div>
		</div>  
		
		<script src="editablegrid-2.1.0-b25.js"></script>   
		<script src="jquery-1.11.1.min.js" ></script>
        <!-- EditableGrid test if jQuery UI is present. If present, a datepicker is automatically used for date type -->
        
		<script src="lw_deletecontact.js" ></script>

		<script type="text/javascript">
		
            var datagrid = new DatabaseGrid();
			window.onload = function() { 

                // key typed in the filter field
                $("#filter").keyup(function() {
                    datagrid.editableGrid.filter( $(this).val());

                    // To filter on some columns, you can set an array of column index 
                    //datagrid.editableGrid.filter( $(this).val(), [0,3,5]);
                  });

                     
			}; 
            
            
        </script>
			
			  
	  
 
        
	</body>

</html>
