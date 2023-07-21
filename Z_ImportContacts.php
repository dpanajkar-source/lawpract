<?php

if (isset($_POST['update'])) {
	$fp = fopen($_FILES['ImportFile']['tmp_name'], "r");
   	$buffer = fgets($fp, 4096);
   	$FieldNames = explode(',', $buffer);	
	
   	while (!feof ($fp)) {
    	$buffer = fgets($fp, 4096);
    	$FieldValues = explode(',', $buffer);
		
		
    	if ($FieldValues[0]!='') {
    		for ($i=0; $i<sizeof($FieldValues); $i++) {
    			$Contacts[$FieldNames[$i]]=$FieldValues[$i];
    		}
			
			
			
$sql = "INSERT INTO lw_contacts(
			name,
			address,
			landline,
			mobile,
			mobile1,
			email
			)
			VALUES ('".$Contacts[$FieldNames[0]]."',
			'".$Contacts[$FieldNames[1]]."',
			'".$Contacts[$FieldNames[2]]."',
			'".$Contacts[$FieldNames[3]]."',
			'".$Contacts[$FieldNames[4]]."',
			'".$Contacts[$FieldNames[5]]."'
			)";
		$result = DB_query($sql,$db);	
		
		}
			
	}	
	
	fclose ($fp);
	
		?>
	
    <script>
		
swal({   title: "Address Book Updated!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('lw_import_alt.php'); //will redirect to your page
}, 2000); 


	</script>
                        
       <?php
	
} else {
	prnMsg( _('Select a csv file containing the details of contacts that you wish to import into Lawpract. '). '<br>' .
		 _('The first line must contain the field names that you wish to import.').
		 '<a href ="Z_DescribeTable.php?table=lw_contacts" target="_blank">' . _('The field names can be found here'). '</a>', 'info');
	echo '<form name="ItemForm" enctype="multipart/form-data" method="post" action="' . $_SERVER['PHP_SELF'] . '?' .SID .'">';
	 echo '<div id="file_upload-drop" style="padding-bottom:20px">
                                <p class="uk-text">File to import</p>
                                <a class="uk-form-file md-btn">choose file<input id="ImportFile" type="file"></a>
                            </div>';
	echo '<div class="centre"><input type="submit" class="md-btn md-btn-primary" name="update" value="Process"></div>';
	echo '</form>';
}


?>
       
     
