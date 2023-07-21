<?php
$PageSecurity =3;

include('server_con.php');

$courtcaseno=trim($_POST['courtcaseno']);

$stage=trim($_POST['stage']);

$brief_file=trim($_POST['brief_file']);
$otherdate=trim($_POST['otherdate']);

$nextdate=trim($_POST['nextdate']);	
	
	$sql= "SELECT * FROM lw_trans WHERE brief_file='" . trim($brief_file) . "'";
	$result = mysqli_query($con,$sql);
	$myrow = mysqli_fetch_array($result);
		
	if (!empty($myrow[0])) 
	{
    $sqlnew= 'SELECT * FROM lw_trans WHERE brief_file="' . trim($brief_file) . '" ORDER BY id DESC LIMIT 1';
	$resultnew = mysqli_query($con,$sqlnew);
	$myrownew = mysqli_fetch_array($resultnew);
	
		   /*if ($myrownew['nextcourtdate'] === "") 
		   {
			  $nextcourtdate = "NULL";
		   }else {
			  $nextcourtdate=$myrownew['nextcourtdate'];       
		   }*/
		   
		   if ($myrownew['prevcourtdate'] === "") 
		   {
			  $prevcourtdate = "NULL";
		   }else {
			  $prevcourtdate=$myrownew['prevcourtdate'];       
		   }
		   
		    if ($myrownew['currtrandate'] === "") 
		   {
			  $lastcurrtrandate = "NULL";
		   }else {
			  $lastcurrtrandate=$myrownew['currtrandate'];       
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
						'" . trim(FormatDateForSQL($otherdate)) . "',
					'" . trim($myrownew['currtrandate']) . "',
					'" . trim($myrownew['courtname']) . "',
					'" . trim($courtcaseno) . "',
					'" . trim($myrownew['party']) . "',
					'" . trim($myrownew['oppoparty']) . "',
					'" . trim($stage) . "',
					'" . trim(FormatDateForSQL($nextdate)) . "'					
						)";

     $result = mysqli_query($con,$stmt);	
	  $query=$stmt;		
		
	$SQLArray = explode(' ', $stmt);
	
	include('cust_audittrail.php');
	
	 // for next date diary entry 
				if(isset($nextdate))
				{
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
				'" . trim(FormatDateForSQL($nextdate)) . "',
				'" . trim($myrownew['opendt']) . "',
				'" . trim($myrownew['courtid']) . "',
				'" . trim($courtcaseno) . "',
				'" . trim($myrownew['party']) . "',
				'" . trim($myrownew['oppoparty']) . "',
				'" . trim($stage) . "'				
				)";

		$resultnextdiary = mysqli_query($con,$stmtnextdiary);
		 $query=$stmtnextdiary;		
		
	$SQLArray = explode(' ', $stmtnextdiary);
	
	include('cust_audittrail.php');		
				}

		}
		else 
		{	
		
	$sqlnew= "SELECT * FROM lw_cases where brief_file='" . trim($brief_file) ."'";
	$resultnew = mysqli_query($con,$sqlnew);
	$myrownew = mysqli_fetch_array($resultnew);

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
				'" . trim(FormatDateForSQL($otherdate)) . "',
				'" . trim($myrownew['opendt']) . "',
				'" . trim($myrownew['courtid']) . "',
				'" . trim($courtcaseno) . "',
				'" . trim($myrownew['party']) . "',
				'" . trim($myrownew['oppoparty']) . "',
				'" . trim($stage) . "',
				'" . trim(FormatDateForSQL($nextdate)) . "'
				)";

		$result1 = mysqli_query($con,$stmt);
					 $query=$stmt;		
		
	$SQLArray = explode(' ', $stmt);
	
	include('cust_audittrail.php');
	
				// for next date diary entry 
				if(isset($nextdate))
				{
				
				  $date_info = date_parse_from_format('d/m/Y', $nextdate);
      $value = "{$date_info['year']}-{$date_info['month']}-{$date_info['day']}";
				
				
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
				'" . trim($value) . "',
				'" . trim($myrownew['opendt']) . "',
				'" . trim($myrownew['courtid']) . "',
				'" . trim($courtcaseno) . "',
				'" . trim($myrownew['party']) . "',
				'" . trim($myrownew['oppoparty']) . "',
				'" . trim($stage) . "'				
				)";

		$resultnextdiary = mysqli_query($con,$stmtnextdiary);	
			 $query=$stmtnextdiary;		
		
	$SQLArray = explode(' ', $stmtnextdiary);
	
	include('cust_audittrail.php');	
				}
		}

			$stmt = "UPDATE lw_cases SET
			  		stage='" . trim($stage) . "'
					WHERE brief_file = '" . trim($brief_file) . "'";
			
	$resultstage = mysqli_query($con,$stmt);
			 $query=$stmt;		
		
	$SQLArray = explode(' ', $stmt);
	
	include('cust_audittrail.php');	
?>