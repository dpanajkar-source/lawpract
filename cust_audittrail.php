<?php
		if (($SQLArray[0] == 'INSERT')
			OR ($SQLArray[0] == 'UPDATE')
			OR ($SQLArray[0] == 'DELETE')) {

			if ($SQLArray[2]!='audittrail'){ // to ensure the auto delete of audit trail history is not logged
				$AuditSQL = "INSERT INTO audittrail (transactiondate,
									userid,
									querystring)
						VALUES('" . date('Y-m-d H:i:s') . "',
							'" . trim($_POST['user_id']) . "',
							'" . mysqli_escape_string($query) . "')";
				$AuditResult = mysqli_query($con,$AuditSQL); 
				}
				}		
		
?>