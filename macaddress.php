<!--<!DOCTYPE html><html><head>
</head><body>
<div class="fbbg">
<p>Your MAc Address is</p>-->
<?php


	class hashing {
    public static function filehash($file,$hash) {
        if (file_exists($file)) {
            return hash($hash,file_get_contents($file));
        }
        else {
            return "Error Occurred: File Does Not Exist";
        }
    }
}


// Turn on output buffering
ob_start();
//Get the ipconfig details using system commond
system('ipconfig /all');

// Capture the output into a variable
$mycom=ob_get_contents();
// Clean (erase) the output buffer
ob_clean();

$findme = "Physical";
//Search the "Physical" | Find the position of Physical text
$pmac = strpos($mycom, $findme);

// Get Physical Address
$mac=substr($mycom,($pmac+36),17);
//Display Mac Address

echo $mac .'<br>';
echo '<h1>'.sha1($mac).'</h1>';

$path_to_root = '..';

$hfile=hashing::filehash('../lawpract/bower_components/jtable/lib/themes/basic/lwtables.php',"sha256");

$lfile=hashing::filehash('../lawpract/lic.txt',"sha256");

echo 'hfile='.$hfile .'  <br> lfile='.$lfile;
?>
<!--</div></body></html> -->

<br>

<?php

$wifiaddress=GetMAC();

function GetMAC(){
    ob_start();
    system('getmac');
    $Content = ob_get_contents();
    ob_clean();
    return substr($Content, strpos($Content,'\\')-20, 17);
}

?>