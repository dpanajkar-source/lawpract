<?php

$PageSecurity =3;
      
include('config.php');   
    
include('includes/session.php');

//delete 

$file=$_POST['filetodelete'];
$brief_file=$_POST['brief_file'];


if (isset($file)) {
//the link to delete a selected record was clicked instead of the submit button

/*
		$sql='SELECT file_name FROM lw_filesattached where file_name="'. $file .'"';
		$result=DB_query($sql, $db);
		
		$myrowfilename=DB_fetch_array($result,$db);*/
		
			//chmod($_SERVER['DOCUMENT_ROOT'] . '/roserplaw/cases' .  $myrowfilename[0],0666);
	
			unlink($_SERVER['DOCUMENT_ROOT'] . '/roserplaw/cases/' . $file);
		
	  if(!file_exists($_SERVER['DOCUMENT_ROOT'] . '/roserplaw/cases/' . $file))
		{
		
		
			$sql="DELETE FROM lw_filesattached WHERE file_name='" . $file . "'";
			$ErrMsg = _('The File could not be deleted because');
			$result = DB_query($sql,$db,$ErrMsg);
			echo '<div class="uk-width-medium-1-1" style="text-align:center">';
			prnMsg(_('File Deleted and file information also removed from Database'),'info');
			echo '</div>';
			
		}		
			
			// Below is to display files list for the selected brief_file or Partyname once searched and functionality to delete the file and its row in the table lw_filesattached	



							$sql = 'SELECT lw_filesattached.id,lw_filesattached.brief_file,
									lw_filesattached.courtcaseno,
									lw_filesattached.file_name
									FROM lw_filesattached WHERE brief_file="' . $brief_file . '"';
							$StatementResults=DB_query($sql,$db, $ErrMsg);
					
							$TableHeader = "<form method='post' id='deleteuploads' action='' enctype='multipart/form-data'>                             <table style='margin-left:-100px'><tr bgcolor='#82A2C6'>
									<th>" . _('ID') . "</th>
									<th>" . _('Brief_Filegood') . "</th>
									<th>" . _('Court Case No') . "</th>
									<th>" . _('File Name') . "</th>
									<th>" . _('Delete File') . "</th>
									</tr>";

									echo $TableHeader;
							
									$i=0;
							
									while($myrow=DB_fetch_array($StatementResults))
											{
							
									$file_name=explode("/",$myrow["file_name"]);
			
											printf("<tr><td>%s</td>
											<td>%s</td>
											<td>%s</td>
											<td>%s</td>
											<td><input type='button' id='delete' value='delete' onclick='delete_post()'/></td>
											</tr>",
											$myrow['id'],
											$myrow['brief_file'],
											$myrow['courtcaseno'],
											'<a id="filetodelete" name="filetodelete" >' . $myrow["file_name"] . '</a>',	
											$_SERVER['PHP_SELF'] . "?" . SID,
											$myrow[0]);
						  
											}	
											
							echo '<tr><td><input type="hidden" id="bf" name="bf" value="' . $brief_file . '"></td></tr>';
							echo '</table></div></form>';
							
							
							

}

?>

