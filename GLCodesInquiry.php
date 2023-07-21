<?php

/* $Revision: 1.9 $ */


$SQL = 'SELECT group_,
		accountcode ,
		accountname
	FROM chartmaster INNER JOIN accountgroups ON chartmaster.group_ = accountgroups.groupname
	ORDER BY sequenceintb,
		accountcode';

$ErrMsg = _('No general ledger accounts were returned by the SQL because');
$AccountsResult = DB_query($SQL,$db,$ErrMsg);

/*show a table of the orders returned by the SQL */



echo "<div class='uk-overflow-container'><table cellpadding=2 colspan=2 align='center' class='uk-table'><thead>
<tr><td></td><td><label><u>General Ledgers and their Groups Listing</u></label> </tr></td>
		<tr>
			<th>"._('Group')."</font></th>
			<th>"._('Code')."</font></th>
			<th>"._('Account Name').'</font></th>
		</tr></thead>';

$j = 1;
$k=0; //row colour counter
$ActGrp ='';

while ($myrow=DB_fetch_array($AccountsResult)) {
       if ($k==1){
              echo '<tr class="EvenTableRows">';
              $k=0;
       } else {
              echo '<tr class="OddTableRows">';
              $k++;
       }

       if ($myrow['group_']== $ActGrp){
              printf("<td></td>
	      		<td><font size=2>%s</font></td>
			<td><font size=2>%s</font></td>
			</tr>",
			$myrow['accountcode'],
			$myrow['accountname']);
       } else {
              $ActGrp = $myrow['group_'];
              printf("<td><font size=2>%s</font></td>
	      		<td><font size=2>%s</font></td>
			<td><font size=2>%s</font></td>
			</tr>",
			$myrow['group_'],
			$myrow['accountcode'],
			$myrow['accountname']);
       }
}
//end of while loop

echo '</table></div>';



?>
