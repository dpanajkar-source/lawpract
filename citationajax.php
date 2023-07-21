<?php
include('server_con.php');

$brief=$_POST['brief_file'];

if(isset($brief))
{ 

$sql = 'SELECT lw_citations.citation FROM lw_citations WHERE brief_file="' . $brief . '"';
							$StatementResults=mysqli_query($con,$sql);
    
                            $myrow=mysqli_fetch_array($StatementResults);
							
				        //echo htmlentities($myrow[0], ENT_QUOTES, "UTF-8");
                        echo html_entity_decode($myrow[0], ENT_COMPAT, $charset);
							
}
?>