<?php
$PageSecurity =3;
include('server_con.php');

//belows values come from uploads form after user selects a new file to upload and presses submit button

$cust_id=$_POST['cust_id'];

$cust_name=$_POST['cust_name'];

if(isset($cust_id))
{ 

$sql = 'SELECT file_name FROM bf_filesattached WHERE cust_id="' . $cust_id . '" ORDER BY file_name ASC';
							$StatementResults=mysqli_query($con,$sql);
					
							$TableHeader = "<form method='post' id='deleteuploads' action='' enctype='multipart/form-data'>                             <table class='uk-table' id='myTableData'><tr bgcolor='#82A2C6'>
									<th>" . 'ID' . "</th>
									<th>" . 'File Name' . "</th>
									<th>" . 'Delete File' . "</th>
									</tr>";

									echo $TableHeader;
							
									$i=1;
							
									while($myrow=mysqli_fetch_array($StatementResults))
											{
							
									$folder='lpt_'. $cust_name;
									
									$fname=explode(".",$myrow["file_name"]);
									
									$icon=$fname[1];
									
									if($icon=='doc')
									{
									$icons='icons/doc.png';
									
									}elseif($icon=='docx')
									{
									$icons='icons/docx.png';
									
									}elseif($icon=='jpg')
									{
									$icons='icons/jpg.png';
									
									}elseif($icon=='jpeg')
									{
									$icons='icons/jpeg.png';
									
									}elseif($icon=='pdf')
									{
									$icons='icons/pdf.png';
									}	
									elseif($icon=='png')
									{
									$icons='icons/png.png';
									
									}elseif($icon=='txt')
									{
									$icons='icons/txt.png';
									
									}elseif($icon=='xls')
									{
									$icons='icons/xls.png';
									
									}elseif($icon=='xlsx')
									{
									$icons='icons/xlsx.png';
									}	
																	
						printf("<tr><td>%s</td>
						<td><img src='".$icons."'>&nbsp;<a href='bf_files/" . $folder .'/'. $myrow["file_name"] . "' target='_blank'>%s</a></td>
									<td>%s</td>
									</tr>",
									$i++,
									$myrow["file_name"],
									'<input type="button" class="md-btn md-btn-primary" style="width:170px" value="DELETE" onClick="Javascript:deleteRow(this)">');
						  
											}	
							echo '</table></div></form>';

}


if(isset($_FILES['file']['tmp_name']))
{ 

	$folder='lpt_'. $cust_name;
	
	//  5MB maximum file size 
	$MAXIMUM_FILESIZE = 5 * 1024 * 1024; 
	//  Valid file extensions (images, word, excel, powerpoint) 
	$rEFileTypes = "/^\.(jpg|jpeg|png|doc|docx|txt|pdf|xls|xlsx){1}$/i"; 

	//create folder if it does not exist

	chmod($_SERVER['DOCUMENT_ROOT'] . '/lawpract/bf_files/',0750);


		if(!file_exists('bf_files/' . $folder))//check if folder exists
			{
			
			//insert mode
			
				mkdir('bf_files/' . $folder,0700);	
		 
				$uploadDir= $_SERVER['DOCUMENT_ROOT'] . '/lawpract/bf_files/' . $folder;

				$dir_base = $uploadDir; 
			}else {
			$uploadDir= $_SERVER['DOCUMENT_ROOT'] . '/lawpract/bf_files/' . $folder;
			$dir_base = $uploadDir; 
				  }			

				$isFile = is_uploaded_file( $_FILES['file']['tmp_name']);
			 
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
											
						$sql= "SELECT file_name FROM bf_filesattached WHERE file_name='" . $safe_filename . "' AND cust_id='" . $cust_id . "' ORDER BY file_name ASC";
						$result = mysqli_query($con,$sql);
						$myrow = mysqli_fetch_row($result);
                    
                    $existingfile=$dir_base .'/'. $safe_filename;
                    
                    if(file_exists($dir_base .'/'. $safe_filename))// database la upload karel
						{
						if ($myrow[0]>0) 
							{
			
							$sql = "UPDATE bf_filesattached SET
									file_name='" . trim($safe_filename) . "'
								WHERE file_name= '" . $safe_filename . "'";
							$result=mysqli_query($con,$sql);
			
							}
							else
							{	
							$sql = "INSERT INTO bf_filesattached(
							cust_id,
							file_name
							)
							VALUES ('" . strtoupper(trim($cust_id)) . "',
								'" . trim($safe_filename) . "'
								)";

						$result = mysqli_query($con,$sql);
						    }	
		
// Below is to display files list for the selected brief_file or Partyname once searched and functionality to delete the file and its row in the table lw_filesattached	
							$sql = 'SELECT bf_filesattached.file_name
									FROM bf_filesattached WHERE cust_id="' . $cust_id . '" ORDER BY file_name ASC';
							$StatementResults=mysqli_query($con,$sql);
					
							$TableHeader = "<form method='post' id='deleteuploads' action='' enctype='multipart/form-data'>                             <table class='uk-table uk-table-hover' id='myTableData'><tr bgcolor='#82A2C6'>
									<th>" . 'ID' . "</th>
									<th>" . 'File Name' . "</th>
									<th>" . 'Delete File' . "</th>
									</tr>";

									echo $TableHeader;
							
									$i=0;									
							
									while($myrow=mysqli_fetch_array($StatementResults))
											{
							$fname=explode(".",$myrow["file_name"]);
									
									$icon=$fname[1];
									
									if($icon=='doc')
									{
									$icons='icons/doc.png';
									
									}elseif($icon=='docx')
									{
									$icons='icons/docx.png';
									
									}elseif($icon=='jpg')
									{
									$icons='icons/jpg.png';
									
									}elseif($icon=='jpeg')
									{
									$icons='icons/jpeg.png';
									
									}elseif($icon=='pdf')
									{
									$icons='icons/pdf.png';
									}	
									elseif($icon=='png')
									{
									$icons='icons/png.png';
									
									}elseif($icon=='txt')
									{
									$icons='icons/txt.png';
									
									}elseif($icon=='xls')
									{
									$icons='icons/xls.png';
									
									}elseif($icon=='xlsx')
									{
									$icons='icons/xlsx.png';
									}	
									//$file_name=explode("/",$myrow["file_name"]);
									
												
									printf("<tr><td>%s</td>
						<td><img src='".$icons."' >&nbsp;<a href='bf_files/" . $folder .'/'. $myrow["file_name"] . "' target='_blank'>%s</a></td>
									<td>%s</td>
									</tr>",
									$i++,
									$myrow["file_name"],
									'<input type="button" class="md-btn md-btn-primary" style="width:170px" value="DELETE" onClick="Javascript:deleteRow(this)">');						  
											}	
							echo '</table></div></form>';

  	                           }
						 }
						 else
						 { 
						 echo '<div style="text-align:center; color:#FF0000"><b>Not a valid file to upload</b></div>';
						 // Below is to display files list for the selected brief_file or Partyname once searched and functionality to delete the file and its row in the table lw_filesattached	
							$sql = 'SELECT bf_filesattached.file_name
									FROM bf_filesattached WHERE cust_id="' . $cust_id . '" ORDER BY file_name ASC';
							$StatementResults=mysqli_query($con,$sql);
												
							$TableHeader = "<form method='post' id='deleteuploads' action='' enctype='multipart/form-data'>                             <table class='uk-table uk-table-hover' id='myTableData'><tr bgcolor='#82A2C6'>
									<th>" . 'ID' . "</th>
									<th>" . 'File Name' . "</th>
									<th>" . 'Delete File' . "</th>
									</tr>";

									echo $TableHeader;
							
									$i=0;
									
									while($myrow=mysqli_fetch_array($StatementResults))
											{
											$fname=explode(".",$myrow["file_name"]);
									
									$icon=$fname[1];
									
									if($icon=='doc')
									{
									$icons='icons/doc.png';
									
									}elseif($icon=='docx')
									{
									$icons='icons/docx.png';
									
									}elseif($icon=='jpg')
									{
									$icons='icons/jpg.png';
									
									}elseif($icon=='jpeg')
									{
									$icons='icons/jpeg.png';
									
									}elseif($icon=='pdf')
									{
									$icons='icons/pdf.png';
									}	
									elseif($icon=='png')
									{
									$icons='icons/png.png';
									
									}elseif($icon=='txt')
									{
									$icons='icons/txt.png';
									
									}elseif($icon=='xls')
									{
									$icons='icons/xls.png';
									
									}elseif($icon=='xlsx')
									{
									$icons='icons/xlsx.png';
									}	
							
									//$file_name=explode("/",$myrow["file_name"]);
			
									printf("<tr><td>%s</td>
						<td><img src='".$icons."' >&nbsp;<a href='bf_files/" . $folder .'/'. $myrow["file_name"] . "' target='_blank'>%s</a></td>
									<td>%s</td>
									</tr>",
									$i++,
									$myrow["file_name"],
									'<input type="button" class="md-btn md-btn-primary" style="width:170px" value="DELETE" onClick="Javascript:deleteRow(this)">');						  
											}	
							echo '</table></div></form>';
						 }
				 
					} //$isFile	
					
							 		
					
}
?>
