<?php
//Create a directory in the name of the Party in cases folder

$client_name=$_POST['client_name'];

			chmod($_SERVER['DOCUMENT_ROOT'].'/lawpract/contactimages/',0750);
							
			$filename=trim($client_name);
  
			
$upload_dir = "contactimages";
$img = $_POST['hidden_data'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);

$file = $upload_dir . '/' . str_replace(" ","",trim($client_name)) . ".png";
$success = file_put_contents($file, $data);
print $success ? $file : 'Unable to save the file.';



?>