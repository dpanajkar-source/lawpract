<?php
/* $Revision: 1.27 $ */

/*
Call this page with:
				1. A TransID to show the make up and to modify existing allocations.
				2. A DebtorNo to show all outstanding receipts or credits yet to be allocated.
				3. No parameters to show all outstanding credits and receipts yet to be allocated.
*/

include('includes/DefineCustAllocsClass.php');

include('includes/SQL_CommonFunctions.inc');

?>



 	<div class="uk-width-medium-1-1" style="padding-bottom:10px" class="md-input-wrapper">   
    
     
	<div class="uk-grid uk-grid-width-1-2 uk-grid-width-medium-1-2" data-uk-grid-margin="5">	
    
       <?php
         



if(isset($_POST['Searchhiddenbrieffile']))
{
echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">';
echo 'Invoice No: <input type="text" class="md-input" name="Searchhiddeninvoiceno" id="Searchhiddeninvoiceno" value="' . $_POST['Searchhiddeninvoiceno'] . '" ></div>';
echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">';
echo 'Total Fees for Selected Invoice: <input type="text" class="md-input" name="Searchhiddentotalfees" id="Searchhiddentotalfees" value="' . $_POST['Searchhiddentotalfees'] . '" ></div>';

?>
</div></div><script>

var invoice=<?php echo json_encode($_POST['Searchhiddeninvoiceno']); ?>;

</script>



<?php


	$TableHeader = "<tr>
					<th>" . 'ID' . "</th>
		     		<th>" . 'Trans Type' . "</th>
		     		<th>" . 'Customer' . "</th>
		     		<th>" . 'Cust No' . "</th>
		     		<th>" . 'Trans Number' . "</th>
		     		<th> " . 'Date' . "</th>
		     		<th>" . 'Amount Received' . "</th>
		     		<th>" . 'Action' . "</th>
		     	</tr>";

		$SQL = "SELECT lw_partytrans.id,
				lw_partytrans.type,
				lw_partytrans.transno,
				systypes.typename,				
				lw_partytrans.party,
				lw_contacts.name,
				lw_partytrans.receivedt,
				lw_partytrans.narration,
				lw_partytrans.amountreceived				
				FROM lw_partytrans,
				lw_contacts,
				systypes
				WHERE lw_partytrans.brief_file='" . $_POST['Searchhiddenbrieffile'] . "' AND lw_partytrans.invoiceno IS NULL AND lw_partytrans.type=systypes.typeid AND lw_partytrans.party=lw_contacts.id ORDER BY lw_contacts.name ";
		$result = DB_query($SQL,$db);
		$trans = DB_num_rows($result);
		
		echo '<table class="uk-table" id="myTableData">';
		echo $TableHeader;

		while ($myrow = DB_fetch_array($result))
		{
			
			echo "<tr>
					<td>" . $myrow['id'] ."</td>
					<td>" . $myrow['typename'] ."</td>
					<td>" . $myrow['name'] . "</td>
					<td>" . $myrow['party'] . "</td>
					<td>" . $myrow['transno'] . "</td>
					<td>" . ConvertSQLDate($myrow['receivedt']) . "</td>
					<td class=number>" . number_format($myrow['amountreceived'],2) . "</td>";
			echo '<td><input type="button" class="md-btn md-btn-primary" style="width:170px" value="Allocate" onClick="Javascript:deleteRow(this)"></td></tr>';

		
		}
		DB_free_result($result);
		echo '</table><p>';

		if ($trans == 0)
		{
			prnMsg('There are no Receipts to Allocate','info');
		}

echo '</td></tr></table>'; // end Page Border

} //end of update mode
?>

<script>

 function deleteRow(obj) {
					
					var index=obj.parentNode.parentNode.rowIndex;
					var table=document.getElementById("myTableData");
					
					//var invoice=document.getElementById("Searchhiddeninvoiceno");
					
					empid=document.getElementById("myTableData").rows[index].cells[0];
					emp=document.getElementById("myTableData").rows[index].cells[4];
					
					 $.ajax({
							url: 'allocatereceipt.php', // Url to which the request is send
							type: "POST",             // Type of request to be send, called as method
							dataType: "html",
							//data: new FormData(this),// Data sent to server, a set of key/value pairs (i.e. form fields and values	
							data: {
										//'Client': JSON.stringify(Client),
										'invoiceno': invoice,
										'id': empid.textContent		
								  },
							
							success: function(data)   // A function to be called if request succeeds
							{
							alert('Selected Receipt Allocated');
							//$("#message").html(data);
							}
							
							});
					table.deleteRow(index);				
					
					}
					
</script>					