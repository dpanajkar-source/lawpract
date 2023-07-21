<?php

$PageSecurity = 6;

include('includes/session.php');
$title = _('Database table details');

$sql='DESCRIBE '.$_GET['table'];
//$sql='DESCRIBE accountgroups';
$result=DB_query($sql, $db);

echo '<table><tr>';
echo '<th>'._('Field name').'</th>';
echo '<th>'._('Field type').'</th>';
echo '<th>'._('Can field be null').'</th>';
echo '<th>'._('Default').'</th>';
while ($myrow=DB_fetch_row($result)) {
	echo '<tr><td>' .$myrow[0] .'</td><td>';
	echo $myrow[1] .'</td><td>';
	echo $myrow[2] .'</td><td>';
	echo $myrow[4] .'</td></tr>';
}
echo '</table>';



?>