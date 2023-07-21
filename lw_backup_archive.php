<?php

/* $Revision: 1.42 $ */

$PageSecurity = 15;

include('includes/session.php');
//include('includes/header.php');
 
$title = _('Backup Database Maintenance');

ob_start();

// Enter your MySQL access data  
  $host= 'localhost';         
  $user= 'root';               
  $pass= 'ros123is';
  $db=   'roserplaw';


  $sqlFileName="c:/ros.sql";
  
  $mysqlDumpCommand = "\"C:\\Program Files\\Zend\\MySQL51\\bin\\mysqldump.exe\" -u ".$user.' -p'.$pass.' --databases ' . $db . '>' . $sqlFileName;
system(sprintf($mysqlDumpCommand)); 


$results=$mysqlDumpCommand;  
 

$dump=ob_get_contents();
ob_end_clean();


//send dump file to the output

$filename="roserplaw";

header('Content-Description:File Transfer');
header('Content-Type:application/octet-stream');
header('Content-Disposition: attachment; filename=' . $filename . ".sql");

flush();
echo $dump;
	
	
?>

