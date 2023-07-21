	   
<?php	  

		 
   // start of code for first entry in the diary as soon as new case is created
			
	$result=DB_query("SELECT * FROM lw_trans WHERE brief_file='" . trim($_POST['Brief_File']) . "' ORDER BY currtrandate DESC LIMIT 1",$db);
	
	$myrownew=DB_fetch_array($result);
		
	if (!empty($myrownew[0])) 
		{ 		
	    		  
 
		}
		else 
		{	
		// first entry in the diary
		   
		  		
	if($_POST['Nextdate']=="NULL")
	{
	 $nextdate = "NULL";
  		 }else {
		 
    $nextdate=FormatDateForSQL($_POST['Nextdate']);	
	$nextdate="'\ " . $nextdate. "\" . '";
	     }
		 
	if($_POST['Currdate']=="NULL")
	{
	 $otherdate = "NULL";
  		 }else {	
    $otherdate=FormatDateForSQL($_POST['Currdate']);
	$otherdate="'\ " . $otherdate . "\" . '";
	     }
			
		$stmt= "INSERT INTO lw_trans (brief_file,
					currtrandate,
					prevcourtdate,
					courtname,
					courtcaseno,
					party,
					oppoparty,
					stage,
					nextcourtdate
					)
			VALUES ('" . trim($_POST['Brief_File']) . "',
				$otherdate,
				 NULL,
				'" . trim($_POST['Court']) . "',
				'" . trim($_POST['Courtcaseno']) . "',
				'" . trim($_POST['Casepartyid']) . "',
				'" . trim($_POST['Caseoppopartyid']) . "',
				'" . trim($_POST['Stage']) . "',
				$nextdate
				)";
		
		$result=DB_query($stmt,$db);
		
		
				
				// for next date diary entry 
			if ($nextdate!="NULL") 
				{
				
	$result=DB_query("SELECT * FROM lw_trans WHERE brief_file='" . trim($_POST['Brief_File']) . "' ORDER BY currtrandate DESC LIMIT 1",$db);
	
	$myrownew=DB_fetch_array($result);
			$stmtnextdiary= "INSERT INTO lw_trans (brief_file,
					currtrandate,
					prevcourtdate,
					courtname,
					courtcaseno,
					party,
					oppoparty,
					stage					
					)
			VALUES ('" . trim($_POST['Brief_File']) . "',
				$nextdate,
				'" . trim($myrownew['currtrandate']) . "',
				'" . trim($_POST['Court']) . "',
				'" . trim($_POST['Courtcaseno']) . "',
				'" . trim($_POST['Casepartyid']) . "',
				'" . trim($_POST['Caseoppopartyid']) . "',
				'" . trim($_POST['Stage']) . "'				
				)";
		
			$result=DB_query($stmtnextdiary,$db);	
				}
		}
		
			
			//end of diary entry		
			
							
		?>