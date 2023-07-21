<?php
$PageSecurity =5;
include('includes/session.php');

//$client=filter_input(INPUT_POST,'jsarray',FILTER_SANITIZE_STRING);

$services=trim($_POST['services']);

$services=explode(",",$services);

$fees=trim($_POST['fees']);

$fees=explode(",",$fees);

$invoicedt=FormatDateForSQL($_POST['invoicedt']);
       
$invoicedt="'\ " . $invoicedt . "\" . '";

$invoiceno=$_POST['invoiceno'];

$casepartyid=$_POST['casepartyid'];

$brief_file=$_POST['brief_file'];

for($i=0;$i<count($services);$i++)
	{
	
	 $sql = "INSERT INTO lw_inv_breakup(
                            invoiceno,
                            invdate,
							brief_file,
							party,
							servicename,
							fees					
							)
				VALUES ('".trim($invoiceno)."',
                    $invoicedt,
                    '".trim($brief_file)."',
					'".trim($casepartyid)."',
					'" . trim($services[$i],"[&quot;..&quot;]") . "',
					'" . trim($fees[$i],"[&quot;..&quot;]") . "'		
					)";

      $result = DB_query($sql,$db);  

    }
    
	