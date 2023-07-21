<?php            

$con=mysqli_connect("localhost","root","Server!00@#$");
		mysqli_select_db($con,"lawpract"); 
		
		$sql='SELECT lw_contacts.name,lw_contacts.email FROM lw_contacts';
		
		$resultcontacts = mysqli_query($con,$sql);
		
		$contacts=array();
		$i=0;
		
		while($myrowcontacts=mysqli_fetch_array($resultcontacts))
		{
		
		$contacts[$i++]=$myrowcontacts[0].','.$myrowcontacts[1];
		}	
		
		mysqli_close($con);
			

/*$sql = 'INSERT INTO contacts (name, email)
						SELECT lw_contacts.name,lw_contacts.email FROM lw_contacts IN "lawpract"
						WHERE ( lw_contacts.name,lw_contacts.email ) NOT
							IN ( SELECT contacts.name, contacts.email FROM contacts )';
				$InsNewChartDetails = mysqli_query($con,$sql);	*/		
				
$con=mysqli_connect("localhost","root","Server!00@#$");
		mysqli_select_db($con,"roundcubemail"); 
		
		$sqlroundmailcontacts='SELECT contacts.name,contacts.email FROM contacts';
		
		$resultroundmailcontacts = mysqli_query($con,$sqlroundmailcontacts);
		
		$roundmailcontacts=array();
		$i=0;
		
		while($myrowroundmailcontacts=mysqli_fetch_array($resultroundmailcontacts))
		{		
		$roundmailcontacts[$i++]=$myrowroundmailcontacts[0].','.$myrowroundmailcontacts[1];
		}
		
		$result = array_diff($contacts, $roundmailcontacts);
		
		$i=0;		
			
		foreach ($result as $value) {
    			
		$exp=explode(",",$value);	
			
		if($exp[1]!=='')
			{		
				 $sql = "INSERT INTO contacts(name,email,user_id) 
		        VALUES ('".strtoupper(trim($exp[0]))."',
				'".trim($exp[1])."',
				1
				)";
				$result = mysqli_query($con,$sql);	
			}
		
		}		
		
		
?>