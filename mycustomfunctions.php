<?php

 $PageSecurity = 5;
     include('includes/session.php');
	 
	 //synchronizes two similar tables on same server

/*$sql = 'INSERT INTO lw_transnew (lw_transnew.id,lw_transnew.brief_file, lw_transnew.nextcourtdate)
						SELECT lw_trans.id,lw_trans.brief_file, lw_trans.nextcourtdate FROM lw_trans
						WHERE ( lw_trans.id) NOT
							IN ( SELECT lw_transnew.id FROM lw_transnew )';
				$comparecontacts = DB_query($sql,$db);	*/	
				
				//basically below we can fetch data from any remote server or another database
				
				$sql='SELECT lw_transnew.id FROM lw_transnew';
				$comparecontacts = DB_query($sql,$db);					
				$myrowresult=DB_fetch_array($comparecontacts);					
				
				$sql = 'INSERT INTO lw_transnew (lw_transnew.id,lw_transnew.brief_file, lw_transnew.nextcourtdate)
						SELECT lw_trans.id,lw_trans.brief_file, lw_trans.nextcourtdate FROM lw_trans
						WHERE ( lw_trans.id) NOT
							IN ( "' . $myrowresult . '")';
				$comparecontacts = DB_query($sql,$db);	





?>
<script>
window.onbeforeunload = function (e) {
// Your logic to prepare for 'Stay on this Page' goes here 

    return "Please click 'Stay on this Page'";
};
</script>