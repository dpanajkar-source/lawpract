<?php
$PageSecurity =3;
      
include('config.php');  

function Dateconvert($dt)
{
if (strpos($dt,'/')) {
		$Date_Array = explode('/',$dt);
	} elseif (strpos ($dt,'-')) {
		$Date_Array = explode('-',$dt);
	} elseif (strpos ($dt,'.')) {
		$Date_Array = explode('.',$dt);
	} elseif (strlen($dt)==6) {
		$Date_Array[0]= substr($dt,0,2);
		$Date_Array[1]= substr($dt,2,2);
		$Date_Array[2]= substr($dt,4,2);
	} elseif (strlen($dt)==8) {
		$Date_Array[0]= substr($dt,0,4);
		$Date_Array[1]= substr($dt,4,2);
		$Date_Array[2]= substr($dt,6,2);
	}
	
	//to modify assumption in 2030

	if ((int)$Date_Array[2] <60) {
		$Date_Array[2] = '20'.$Date_Array[2];
	} elseif ((int)$Date_Array[2] >59 AND (int)$Date_Array[2] <100) {
		$Date_Array[0] = '19'.$Date_Array[2];
	} elseif ((int)$Date_Array[2] >9999) {
		$Date_Array=0;
	}

		$dt=$Date_Array[2].'-'.$Date_Array[1].'-'.$Date_Array[0];  //date is converted to mysql format!!!	
		
return $dt;

}

$con=mysqli_connect("localhost","root","Server!00@#$");
		mysqli_select_db($con,"lawpract"); 
    
$courtcaseno=trim($_POST['courtcaseno']);

$stage=trim($_POST['stage']);

$brief_file=trim($_POST['brief_file']);

$nextdate=trim($_POST['nextdate']);	
$otherdate=trim($_POST['otherdate']);



 if ($nextdate=="") 
		   {
			  $nextdate ="NULL";
		   }		   	   
		   
		// Otherdate will be converted to sql format	   

	
	if ($otherdate=="") 
		   {
			  $otherdate ="NULL";
		   }
		   
		   	
	if ($otherdate!="NULL") 
		   {		
	
		$otherdate=Dateconvert($otherdate);  //Otherdate is converted!!!		
		
		   }//end of other date condition   	

	
	$result=mysqli_query($con,"SELECT * FROM lw_trans WHERE brief_file='" . trim($brief_file) . "' ORDER BY currtrandate DESC LIMIT 1");
	
	$myrownew=mysqli_fetch_array($result);
		
	if (!empty($myrownew[0])) 
	{ 		
	    $onerow=1;
		
		echo $myrownew[0];		  

		}
		else 
		{	
		// first entry in the diary
	$result=mysqli_query($con,"SELECT * FROM lw_cases where brief_file='" . trim($brief_file) ."'");	
	$myrownew=mysqli_fetch_array($result);	
	
	// nextdate will be converted to sql format
	
		
	if ($nextdate!="NULL") 
		   {		   
		$nextdate=Dateconvert($nextdate); //nextdate is converted!!!
		
           }//end of next date condition
		   
		  		
	if($nextdate=="NULL")
	{
	 $nextdate = "NULL";
  		 }else {	
	$nextdate="'\ " . $nextdate . "\" . '";
	     }
		 
	if($otherdate=="NULL")
	{
	 $otherdate = "NULL";
  		 }else {	
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
			VALUES ('" . trim($brief_file) . "',
				$otherdate,
				 NULL,
				'" . trim($myrownew['courtid']) . "',
				'" . trim($courtcaseno) . "',
				'" . trim($myrownew['party']) . "',
				'" . trim($myrownew['oppoparty']) . "',
				'" . trim($stage) . "',
				$nextdate
				)";
		
		$result=mysqli_query($con,$stmt);
				
				// for next date diary entry 
			if ($nextdate!="NULL") 
				{
				
	$result=mysqli_query($con,"SELECT * FROM lw_trans WHERE brief_file='" . trim($brief_file) . "' ORDER BY currtrandate DESC LIMIT 1");
	
	$myrownew=mysqli_fetch_array($result);
			$stmtnextdiary= "INSERT INTO lw_trans (brief_file,
					currtrandate,
					prevcourtdate,
					courtname,
					courtcaseno,
					party,
					oppoparty,
					stage					
					)
			VALUES ('" . trim($brief_file) . "',
				$nextdate,
				'" . trim($myrownew['currtrandate']) . "',
				'" . trim($myrownew['courtname']) . "',
				'" . trim($courtcaseno) . "',
				'" . trim($myrownew['party']) . "',
				'" . trim($myrownew['oppoparty']) . "',
				'" . trim($myrownew['stage']) . "'				
				)";
		
			$result=mysqli_query($con,$stmtnextdiary);	
				}
		}
		
		
			$stmt = "UPDATE lw_cases SET
			  		stage='" . trim($_POST['stage']) . "'
					WHERE brief_file = '" . trim($brief_file) . "'";
	
	$result=mysqli_query($con,$stmt);
	
	
?>