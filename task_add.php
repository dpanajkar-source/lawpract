<?php
include('server_con.php');  

$stmt= "INSERT INTO lw_tasks(taskfrom,
						taskto,
						task,
						taskstatus,
						priority,
						startdate,
						enddate,
						remark
						)
				VALUES ('" . $_POST['taskfrom'] . "',
						'" . $_POST['taskto'] . "',
					'" . $_POST['task'] . "',
					'" . $_POST['taskstatus'] . "',
					'" . $_POST['taskpriority'] . "',
					'" . $_POST['startdate'] . "',
					'" . $_POST['enddate'] . "',
					'" . $_POST['remark'] . "'
						)";

      $result1 = mysqli_query($con,$stmt);

			
unset($result1);
unset($brief_file);
unset($currtrandate);
unset($stmt);
unset($courtcaseno);
unset($brief_file);
unset($stage);


?>