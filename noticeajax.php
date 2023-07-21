<?php

$Notice_no=$_POST['Notice_no'];

if(isset($Notice_no))
{ 

$sql = 'SELECT lw_noticecr.noticetxt FROM lw_noticecr WHERE notice_no="' . $Notice_no . '"';
							$StatementResults=mysqli_query($con,$sql);
    
                            $myrow=mysqli_fetch_array($StatementResults);
							
				        //echo htmlentities($myrow[0], ENT_QUOTES, "UTF-8");
                        echo html_entity_decode($myrow[0], ENT_COMPAT, $charset);						
}


?>