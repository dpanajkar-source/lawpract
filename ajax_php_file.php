<?php

include('config.php');
include('server_con.php');

$brief=$_POST['brief_file'];

$brief_file=$_POST['Brief_File'];
$caseno=$_POST['Courtcaseno'];
$partyid=$_POST['Partyid'];

$Party=$_POST['Party'];

if(isset($brief))
{ 

$sql = 'SELECT * FROM lw_filesattached WHERE brief_file="' . $brief . '" ORDER BY file_name ASC';
							$StatementResults=mysqli_query($con,$sql);
					
							$TableHeader = "<form method='post' id='deleteuploads' action='' enctype='multipart/form-data'>                             <table class='uk-table' id='myTableData'><tr bgcolor='#82A2C6'>
									<th>" . 'ID' . "</th>
									<th>" . 'File Name' . "</th>
									<th>" . 'Delete File' . "</th>
									</tr>";

									echo $TableHeader;
														
									while($myrow=mysqli_fetch_array($StatementResults))
											{
																
									$folder='lpt_'. $Party;
									
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
						<td><img src='".$icons."'>&nbsp;<a href='cases/" . $folder .'/'. $myrow["file_name"] . "' target='_blank'>%s</a></td>
									<td>%s</td>
									</tr>",
									$myrow["id"],
									$myrow["file_name"],
									'<input type="button" class="md-btn md-btn-primary" style="width:170px" value="DELETE" onClick="Javascript:deleteRow(this)">');
						  
											}	
							echo '</table></div></form>';

}


$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable


if(isset($brief_file))
{ 

	$folder='lpt_'. $Party;
	
	//  5MB maximum file size 
	$MAXIMUM_FILESIZE = 5 * 1024 * 1024; 
	//  Valid file extensions (images, word, excel, powerpoint) 
	$rEFileTypes = "/^\.(jpg|jpeg|png|doc|docx|txt|pdf|xls|xlsx){1}$/i"; 

	//create folder if it does not exist

	chmod($_SERVER['DOCUMENT_ROOT'] . '/lawpract/cases/',0750);

		if(!file_exists('cases/' . $folder))//check if folder exists
			{			
			//insert mode			
				mkdir('cases/' . $folder,0700);	
		 
				$uploadDir= $_SERVER['DOCUMENT_ROOT'] . '/lawpract/cases/' . $folder;

				$dir_base = $uploadDir; 
			}else
			{
			$uploadDir= $_SERVER['DOCUMENT_ROOT'] . '/lawpract/cases/' . $folder;
			$dir_base = $uploadDir; 
			}			

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
						
						if(file_exists($dir_base .'/'. $safe_filename))
							{
							echo 'A file with this name already exists. Please upload another file or rename this file and then upload';
							// Below is to display files list for the selected brief_file or Partyname once searched and functionality to delete the file and its row in the table lw_filesattached	
							$sql = 'SELECT * FROM lw_filesattached WHERE brief_file="' . $brief_file . '" ORDER BY file_name ASC';
							$StatementResults=mysqli_query($con,$sql);
					
							$TableHeader = "<form method='post' id='deleteuploads' action='' enctype='multipart/form-data'>                             <table class='uk-table uk-table-hover' id='myTableData'><tr bgcolor='#82A2C6'>
									<th>" . 'ID' . "</th>
									<th>" . 'File Name' . "</th>
									<th>" . 'Delete File' . "</th>
									</tr>";

									echo $TableHeader;
													
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
												
									printf("<tr><td>%s</td>
						<td><img src='".$icons."' >&nbsp;<a href='cases/" . $folder .'/'. $myrow["file_name"] . "' target='_blank'>%s</a></td>
									<td>%s</td>
									</tr>",
									$myrow["id"],
									$myrow["file_name"],
									'<input type="button" class="md-btn md-btn-primary" style="width:170px" value="DELETE" onClick="Javascript:deleteRow(this)">');						  
											}	//end of while loop
							echo '</table></div></form>';
							}
							
							
						
						if(!file_exists($dir_base .'/'. $safe_filename))
							{
						
						$isMove = move_uploaded_file ( 
                		 $_FILES['file']['tmp_name'], 
                		 $dir_base .'/'. $safe_filename);						 
											
						$sql= "SELECT file_name FROM lw_filesattached WHERE file_name='" . $safe_filename . "' AND brief_file='" . $brief_file . "' ORDER BY file_name ASC";
						$result = mysqli_query($con,$sql);
						$myrow = mysqli_fetch_row($result);
                    
                    $existingfile=$dir_base .'/'. $safe_filename;
					
					//code taken from if(file_exists($dir_base .'/'. $safe_filename))// database la upload karel
					
					
					if ($myrow[0]>0) 
							{
			
							$sql = "UPDATE lw_filesattached SET
									file_name='" . trim($safe_filename) . "'
								WHERE file_name= '" . $safe_filename . "'";
							$result=mysqli_query($con,$sql);
			
							}
							else
							{	
							
							$sql = "INSERT INTO lw_filesattached(
							brief_file,
							courtcaseno,
							file_name
							)
							VALUES ('" . strtoupper(trim($brief_file)) . "',
								'" . strtoupper(trim($caseno)) . "',
								'" . trim($safe_filename) . "'
								)";

							$result = mysqli_query($con,$sql);
						    }	
		
// Below is to display files list for the selected brief_file or Partyname once searched and functionality to delete the file and its row in the table lw_filesattached	
							$sql = 'SELECT * FROM lw_filesattached WHERE brief_file="' . $brief_file . '" ORDER BY file_name ASC';
							$StatementResults=mysqli_query($con,$sql);
					
							$TableHeader = "<form method='post' id='deleteuploads' action='' enctype='multipart/form-data'>                             <table class='uk-table uk-table-hover' id='myTableData'><tr bgcolor='#82A2C6'>
									<th>" . 'ID' . "</th>
									<th>" . 'File Name' . "</th>
									<th>" . 'Delete File' . "</th>
									</tr>";

									echo $TableHeader;
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
												
									printf("<tr><td>%s</td>
						<td><img src='".$icons."' >&nbsp;<a href='cases/" . $folder .'/'. $myrow["file_name"] . "' target='_blank'>%s</a></td>
									<td>%s</td>
									</tr>",
									$myrow["id"],
									$myrow["file_name"],
									'<input type="button" class="md-btn md-btn-primary" style="width:170px" value="DELETE" onClick="Javascript:deleteRow(this)">');						  
											}	//end of while loop
							echo '</table></div></form>';

  	                           }							 
					
						} //if ($_FILES['file']['size']						
						
				 
					} //if ($isFile)  					
							 		
					
}//if(isset($brief_file))
?>
