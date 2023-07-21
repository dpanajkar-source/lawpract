<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>

  <link rel="icon" type="image/png" href="assets/img/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="assets/img/favicon-32x32.png" sizes="32x32">

    <title>LawPract&trade;</title>

    <!-- additional styles for plugins -->
       
    
    <!-- uikit -->
    <link rel="stylesheet" href="bower_components/uikit/css/uikit.almost-flat.min.css" media="all">

    <!-- flag icons -->
    <link rel="stylesheet" href="assets/icons/flags/flags.min.css" media="all">

    <!-- altair admin -->
    <link rel="stylesheet" href="assets/css/main.css" media="all">
    
     <!-- Live Search Styles -->
    <link rel="stylesheet" href="css/fontello.css">
    <link rel="stylesheet" href="css/animation.css">
    <!--[if IE 7]>
    <link rel="stylesheet" href="css/fontello-ie7.css">
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="css/ajaxlivesearch.min.css">

    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
    <![endif]-->

   
</head>
<body class=" sidebar_main_open sidebar_main_swipe">
<?php
    $PageSecurity = 3;
     include('includes/session.php');
	 include("header.php");  
     include("menu.php");   
	 
	 ?>
    <div id="page_content">
        <div id="page_content_inner">
            <div class="md-card">
                <div class="md-card-content">
                
                <?php

if (isset($_POST['Submit'])) 
{

// Enter your MySQL access data  

if(isset($_FILES["Restorefile"]["tmp_name"]))
{ 
	//  50MB maximum file size 
	$MAXIMUM_FILESIZE = 50 * 1024 * 1024; 
	//  Valid file extensions (images, word, excel, powerpoint) 
//$rEFileTypes = "/^\.(sql|jpeg|gif|png|doc|docx|txt|rtf|pdf|xls|xlsx|ppt|pptx|cdr){1}$/i"; 	

$rEFileTypes = "/^\.(sql){1}$/i"; 
	//create folder if it does not exist

	chmod($_SERVER['DOCUMENT_ROOT'] . '/lawpract/upload/',0750);
	   

				$uploadDir='upload/';

				$dir_base = $uploadDir; 
				
				$isFile = is_uploaded_file($_FILES['Restorefile']['tmp_name']);
			 					  
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
							 trim($_FILES['Restorefile']['name']));
							 
						
    			if ($_FILES['Restorefile']['size'] <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))) 
      					{
						  
							$uploadfile = $uploadDir . 'lawpract.sql';
							
							if (move_uploaded_file($_FILES['Restorefile']['tmp_name'], $uploadfile)) {
								echo "File is valid, and was successfully uploaded.\n";
							} else {
								echo "Possible file upload attack! Only use sql dump file for upload\n";
							}

                        }
				 
					} else
					{
					echo "Possible file upload attack! Only use sql dump file for upload\n";
					
					} 			 
	 		
$sqlFileName='upload/lawpract.sql';

$con=mysqli_connect("localhost","root",$dbpassword);
mysqli_select_db($con,"lawpract");

//here have to look for any existing database and delete it first

$sqldeletedatabase="DROP DATABASE lawpract";

$result=mysqli_query($con,$sqldeletedatabase);

 mysqli_query($con, 'CREATE DATABASE IF NOT EXISTS `' . mysqli_real_escape_string($con, 'lawpract') . '`');
		  mysqli_select_db($con, 'lawpract');  		  
		  
		if(file_exists('upload/lawpract.sql'))
		{
		$SQLScriptFile = file('upload/lawpract.sql');
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
}
}

?>
                    <h3 class="heading_a">Restore Previous Database</h3>
                  	<form enctype="multipart/form-data"  action="<?php echo $_SERVER['PHP_SELF'] . '?' . SID; ?>" method="post">
					<div class="uk-width-medium-1-3">
                         <div class="uk-form-row">
                              <div class="uk-grid"><!-- The data encoding type, enctype, MUST be specified as below -->
                                                       
                              <div class="uk-text-center">
                               <br><label> Click Restore to Restore your Database </label>
                               
                   			  <br><label> Please Restore database first from sql dump file(.sql) from physical location (mostly ex C:, D:, E:, F:) or external drive:</label>   <input type="file" name="Restorefile"/>   
                               
                              <br><label>Please be aware that the file to restore will overwrite the existing database. </label>                                         
                    			<div class="uk-width-1-1">
                                <button type="submit" class="md-btn md-btn-primary" name="Submit">Send File</button>
                     			</div>
                        	  </div>
                  </form>
            	</div>
            </div>
                
         </div>
              
     </div>  
      
   </div>
                
  </div>
              
 </div>  
      <!--- End of the Page Content    --->      
            
    <!-- common functions -->
    <?php include('footersrc.php');  ?>s
    
  </body>
</html>