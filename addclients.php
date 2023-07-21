<?php            

include('server_con.php');

//$client=filter_input(INPUT_POST,'jsarray',FILTER_SANITIZE_STRING);

$Client=trim($_POST['Client']);

$Client=explode(",",$Client);

$brief_file=$_POST['brief_file'];

function stripQuotes($text) {
  $unquote = preg_replace('/&quot;/', '', $text);
  
  $unquote = trim($unquote,"[");
  
  $unquote = trim($unquote,"]");
  
  return $unquote;
} 


if(!empty($Client))
{
for($i=0;$i<count($Client);$i++)
	{
	
	$Client[$i]=stripQuotes($Client[$i]);
	
	//$Client[$i]=trim($Client[$i],"&quot;]");
   
	$stmt= "INSERT INTO lw_otherclients(brief_file,
						name,
						tag
						)
				VALUES ('" . $brief_file . "',
						'" . $Client[$i] . "',
						'C'
						)";

      $result = mysqli_query($con,$stmt);

    
    }
	
}


?>