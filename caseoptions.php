<?php

include('server_con.php');

if($_GET["act"] == "courtname")
	{

$result = mysqli_query($con,"SELECT courtid,courtname FROM lw_courts");

        //Add all records to an array
        $rows = array();
		$element = array();
		while($row = mysqli_fetch_array($result)) {
		$element["DisplayText"]= $row['courtname'];
		$element["Value"]= $row['courtid'];
		$rows[] = $element;
		}
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options']=$rows;
		echo json_encode($jTableResult);

        //Return result to jTable
       // $options = json_encode($rows);

}


if($_GET["act"] == "bankname")
	{

$result = mysqli_query($con,"SELECT id,bank_name FROM bf_banks");

        //Add all records to an array
        $rows = array();
		$element = array();
		while($row = mysqli_fetch_array($result)) {
		$element["DisplayText"]= $row['bank_name'];
		$element["Value"]= $row['id'];
		$rows[] = $element;
		}
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options']=$rows;
		echo json_encode($jTableResult);

        //Return result to jTable
       // $options = json_encode($rows);

}

if($_GET["act"] == "role")
	{

$result = mysqli_query($con,"SELECT roleid,role FROM lw_partiesinvolved");

        //Add all records to an array
        $rows = array();
		$element = array();
		while($row = mysqli_fetch_array($result)) {
		$element["DisplayText"]= $row[1];
		$element["Value"]= $row[1];
		$rows[] = $element;
		}
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options']=$rows;
		echo json_encode($jTableResult);

        //Return result to jTable
       // $options = json_encode($rows);

}

if($_GET["act"] == "opporole")
	{

$result = mysqli_query($con,"SELECT roleid,role FROM lw_partiesinvolved");

        //Add all records to an array
        $rows = array();
		$element = array();
		while($row = mysqli_fetch_array($result)) {
		$element["DisplayText"]= $row[1];
		$element["Value"]= $row[1];
		$rows[] = $element;
		}
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options']=$rows;
		echo json_encode($jTableResult);

        //Return result to jTable
       // $options = json_encode($rows);

}

if($_GET["act"] == "clientcat")
	{

$result = mysqli_query($con,"SELECT clientcatid,category FROM lw_clientcat");

        //Add all records to an array
        $rows = array();
		$element = array();
		while($row = mysqli_fetch_array($result)) {
		$element["DisplayText"]= $row[1];
		$element["Value"]= $row[1];
		$rows[] = $element;
		}
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options']=$rows;
		echo json_encode($jTableResult);

        //Return result to jTable
       // $options = json_encode($rows);

}

if($_GET["act"] == "casecat")
	{

$result = mysqli_query($con,"SELECT casecatid,casecat FROM lw_casecat");

        //Add all records to an array
        $rows = array();
		$element = array();
		while($row = mysqli_fetch_array($result)) {
		$element["DisplayText"]= $row[1];
		$element["Value"]= $row[1];
		$rows[] = $element;
		}
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options']=$rows;
		echo json_encode($jTableResult);

        //Return result to jTable
       // $options = json_encode($rows);

}

if($_GET["act"] == "stage")
	{

$result = mysqli_query($con,"SELECT stageid,stage FROM lw_stages");

        //Add all records to an array
        $rows = array();
		$element = array();
		while($row = mysqli_fetch_array($result)) {
		$element["DisplayText"]= $row['stage'];
		$element["Value"]= $row['stageid'];
		$rows[] = $element;
		}
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options']=$rows;
		echo json_encode($jTableResult);

        //Return result to jTable
       // $options = json_encode($rows);

}

if($_GET["act"] == "status")
	{

$result = mysqli_query($con,"SELECT casestatusid,casestatusdesc FROM lw_case_status");

        //Add all records to an array
        $rows = array();
		$element = array();
		while($row = mysqli_fetch_array($result)) {
		$element["DisplayText"]= $row[1];
		$element["Value"]= $row[1];
		$rows[] = $element;
		}
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options']=$rows;
		echo json_encode($jTableResult);

        //Return result to jTable
       // $options = json_encode($rows);

}

if($_GET["act"] == "party")
	{

$result = mysqli_query($con,"SELECT id,name FROM lw_contacts");

        //Add all records to an array
        $rows = array();
		$element = array();
		while($row = mysqli_fetch_array($result)) {		
		$element["Value"]= $row['name'];
		$element["DisplayText"]= $row['name'];
		$rows[] = $element;
		}
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options']=$rows;
		print json_encode($jTableResult);

        //Return result to jTable
       // $options = json_encode($rows);

}

if($_GET["act"] == "oppoparty")
	{

$result = mysqli_query($con,"SELECT id,name FROM lw_contacts");

        //Add all records to an array
        $rows = array();
		$element = array();
		while($row = mysqli_fetch_array($result)) {
		$element["DisplayText"]= $row[1];
		$element["Value"]= $row[1];
		$rows[] = $element;
		}
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options']=$rows;
		echo json_encode($jTableResult);

        //Return result to jTable
       // $options = json_encode($rows);

}

if($_GET["act"] == "brief_file")
	{

$result = mysqli_query($con,"SELECT brief_file FROM lw_cases");

        //Add all records to an array
        $rows = array();
		$element = array();
		while($row = mysqli_fetch_array($result)) {
		$element["DisplayText"]= trim($row[0]);
		$element["Value"]= $row[0];
		$rows[] = $element;
		}
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options']=$rows;
		echo json_encode($jTableResult);
}

if($_GET["act"] == "courtcaseno")
	{

$result = mysqli_query($con,"SELECT courtcaseno FROM lw_cases");

        //Add all records to an array
        $rows = array();
		$element = array();
		while($row = mysqli_fetch_array($result)) {
		$element["DisplayText"]= $row[0];
		$element["Value"]= $row[0];
		$rows[] = $element;
		}
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options']=$rows;
		echo json_encode($jTableResult);
}

if($_GET["act"] == "caseclose")
	{

$result = mysqli_query($con,"SELECT id,result FROM lw_casecloseresult");

        //Add all records to an array
        $rows = array();
		$element = array();
		while($row = mysqli_fetch_array($result)) {
		$element["DisplayText"]= $row[1];
		$element["Value"]= $row[1];
		$rows[] = $element;
		}
		
		$jTableResult = array();
		$jTableResult['Result'] = "OK";
		$jTableResult['Options']=$rows;
		echo json_encode($jTableResult);
}



?>