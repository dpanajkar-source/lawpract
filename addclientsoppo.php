<?php
$PageSecurity =3;
include('server_con.php');
      
//below is for oppo party clients
$Clientoppoparty=$_POST['Clientoppoparty'];

$Clientoppoparty=explode(",",$Clientoppoparty);

$brief_fileoppoparty=$_POST['brief_fileoppoparty'];

function stripQuotes($text) {
  $unquote = preg_replace('/&quot;/', '', $text);
  
  $unquote = trim($unquote,"[");
  
  $unquote = trim($unquote,"]");
  
  return $unquote;
} 

if(!empty($Clientoppoparty))
{
for($i=0;$i<count($Clientoppoparty);$i++)
	{
	
	$Clientoppoparty[$i]=stripQuotes($Clientoppoparty[$i]);
   
	$stmt= "INSERT INTO lw_otherclients(brief_file,
						name,
						tag
						)
				VALUES ('" . $brief_fileoppoparty . "',
						'" . $Clientoppoparty[$i] . "',
						'O'
						)";

     $result = mysqli_query($con,$stmt);

    
    }
	
}

?>