<?php

$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable

	$folder='backup';	
	
	//  5MB maximum file size 
	$MAXIMUM_FILESIZE = 5 * 1024 * 1024; 
	//  Valid file extensions (sql) 
	$rEFileTypes = "/^\.(sql){1}$/i"; 

	//create folder if it does not exist

	chmod($_SERVER['DOCUMENT_ROOT'] . '/lawpract/backup/',0750);

				$uploadDir= $_SERVER['DOCUMENT_ROOT'] . '/lawpract/' . $folder;

				$dir_base = $uploadDir; 
				$isFile = is_uploaded_file($_FILES['file']['tmp_name']);
			 
				if ($isFile)    //  do we have a file? 
					{//  sanitize file name 
						//     - remove extra spaces/convert to _, 
						//     - remove non 0-9a-Z._- characters, 
						//     - remove leading/trailing spaces 
						//  check if under 5MB, 
						//  check file extension for legal file types 
							 $safe_filename = preg_replace( 
							 array("/\s+/", "/[^-\.\w]+/"), 
							 array("_", ""), 
							 trim($_FILES['file']['name']));
					  
    			if ($_FILES['file']['size'] <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))) 
      					{
						
						$isMove = move_uploaded_file ( 
                		 $_FILES['file']['tmp_name'], 
                		 $dir_base .'/'. $safe_filename);
						 
											
				       $existingfile=$dir_base .'/'. $safe_filename;
					   
//here have to look for any existing database and delete it first

include('server_con.php');

$sqldeletedatabase="DROP DATABASE lawpract";

$result=mysqli_query($con,$sqldeletedatabase);

$path_to_root = '..';

$_POST['company_name']='lawpract';

	      mysqli_query($con, 'CREATE DATABASE IF NOT EXISTS `' . mysqli_real_escape_string($con, $_POST['company_name']) . '`');
		  mysqli_select_db($con, $_POST['company_name']);  		  
		  
		if(file_exists('backup/lawpract.sql'))
		{
		$SQLScriptFile = file('backup/lawpract.sql');
        }else
		{
		$SQLScriptFile = file('sql/lawpract.sql');
		}
	$ScriptFileEntries = sizeof($SQLScriptFile);
	$SQL ='';
	$InAFunction = false;
	
	for ($i=0; $i<$ScriptFileEntries; $i++) {
		
		$SQLScriptFile[$i] = trim($SQLScriptFile[$i]);
		//ignore lines that start with -- or USE or /*			
		if (substr($SQLScriptFile[$i], 0, 2) != '--' 
			AND strstr($SQLScriptFile[$i],'/*')==FALSE 
			AND strlen($SQLScriptFile[$i])>1){
				
			$SQL .= ' ' . $SQLScriptFile[$i];

			//check if this line kicks off a function definition - pg chokes otherwise
			if (substr($SQLScriptFile[$i],0,15) == 'CREATE FUNCTION'){
				$InAFunction = true;
			}
			//check if this line completes a function definition - pg chokes otherwise
			if (substr($SQLScriptFile[$i],0,8) == 'LANGUAGE'){
				$InAFunction = false;
			}
			
			ini_set('max_execution_time', '400');
			
			if (strpos($SQLScriptFile[$i],';')>0 AND ! $InAFunction){
				$SQL = substr($SQL,0,strlen($SQL)-1);
				$result = mysqli_query($con,$SQL);
				$SQL='';
			}
		
	} //end of for loop around the lines of the sql script
	
   }          
            // Below is to display message that database is uploaded
					
	echo 'Lawpract Database Uploaded and Installed';

}					
}
?>
