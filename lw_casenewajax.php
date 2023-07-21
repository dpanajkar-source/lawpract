<?php 
 
if (isset($Errors)) 
{
	unset($Errors);
}
$Errors = array();

/*brief_file could be set from a post or a get when passed as a parameter to this page */

if (isset($_POST['Searchhidden'])){
	$_SESSION['Searchhidden'] = trim($_POST['Searchhidden']);
	
	$brief_file= trim($_POST['Searchhidden']);
	
} elseif (isset($_GET['Searchhidden'])){
	$_SESSION['Searchhidden'] = trim($_GET['Searchhidden']);
	
	$brief_file= trim($_GET['Searchhidden']);
}

//below is for searching record for updation

if(isset($brief_file))
{

$sql = "SELECT lw_cases.id,
 					lw_cases.brief_file,
					lw_cases.notice_no,
					lw_cases.govt_dept_no,
					lw_cases.clientcatid,
					lw_cases.casecatid,
					lw_cases.opendt,
					lw_cases.closedt,
					lw_cases.stage,
					lw_cases.remark,
					lw_cases.courtcaseno,
					lw_cases.courtid,
					lw_cases.party,
					lw_cases.oppoparty,
					lw_cases.counselparty,
					lw_cases.counseloppoparty,
					lw_cases.partyrole,
					lw_cases.oppopartyrole,
					lw_cases.firnumber,
					lw_cases.firdate,
					lw_cases.firtime,
					lw_cases.policestation,
					lw_cases.casehistoryid,
					lw_cases.judgename,
					lw_cases.cnrnumber				
					FROM lw_cases WHERE lw_cases.brief_file = '" . $brief_file . "' AND lw_cases.deleted!=1";
					
			$ErrMsg = _('The case could not be retrieved for editing because');
		
			$resultparty = DB_query($sql,$db,$ErrMsg); 
			
    	    $myrowparty = DB_fetch_array($resultparty);		  	
			
}			


if (isset($_POST['Submit'])) 
{

		if (!isset($_POST['New'])) // This is the update mode ie user is editing a Contact
		{
			
			//first check if $_POST['Caseparty'] value is already there in the lw_contacts table
            
            
              $_POST['Casepartynameupdate'] = preg_replace('/\s+/', ' ', $_POST['Casepartynameupdate']);
            
              $_POST['Caseoppopartynameupdate'] = preg_replace('/\s+/', ' ', $_POST['Caseoppopartynameupdate']);
                      					
			
		if ($_POST['Casepartyid']>0)
		{
			$sql = "UPDATE lw_contacts SET
			name='".strtoupper(trim($_POST['Casepartynameupdate']))."',
			address='".strtoupper(trim($_POST['Addressupdate']))."',
			mobile='".trim($_POST['Mobileupdate'])."'
			WHERE id= '".$_POST['Casepartyid']."'";
			$result=DB_query($sql,$db);
		
		} 			
		
		//first check if $_POST['Caseoppoparty'] value is already there in the lw_contacts table
			
		if ($_POST['Caseoppopartyid']>0)
		{
			$sql = "UPDATE lw_contacts SET
			name='".strtoupper(trim($_POST['Caseoppopartynameupdate']))."',
			address='".strtoupper(trim($_POST['Addressoppoupdate']))."',
			mobile='".trim($_POST['Mobileoppoupdate'])."'
			WHERE id='".$_POST['Caseoppopartyid']."'";
			$result=DB_query($sql,$db);
		
		}        
            
            //make necessary changes in all the tables if brief_file is changed by the user
			           
            if($_POST['Brief_Fileupdate']!=$_POST['Brief_Filebeforechange'])
			
			  {
			  
			  //make changes in lw_trans
			    $sqlbrief_file = "UPDATE lw_trans SET
                          brief_file='".trim($_POST['Brief_Fileupdate'])."'
                         WHERE brief_file= '".$_POST['Brief_Filebeforechange']."'";
                  $resultsqlbrief_file=DB_query($sqlbrief_file,$db);
				  
				$sqlcourtcaseno = "UPDATE lw_trans SET
                          courtcaseno='".trim($_POST['Courtcasenoupdate'])."'
                         WHERE courtcaseno= '".$_POST['Courtcasenobeforeupdate']."'";
                  $resultsqlcourtcaseno=DB_query($sqlcourtcaseno,$db);  
				  	
				  
                //make changes for brief_file in lw_filesattached table
                
      $sqlfilesattached = "SELECT id FROM lw_filesattached WHERE brief_file='" . trim($_POST['Brief_Filebeforechange']) . "'";
		$resultfilesattached = DB_query($sqlfilesattached,$db);
		
		$myrowfilesattached=DB_fetch_array($resultfilesattached); 
                 $sql = "UPDATE lw_filesattached SET
                          brief_file='".trim($_POST['Brief_Fileupdate'])."'
                         WHERE id= '".$myrowfilesattached[0]."'";
                  $result=DB_query($sql,$db);

                
                //make changes for brief_file in lw_otherclients table
                
                  $clients=array();
                 $i=0;
    
            $resultclients=DB_query("SELECT id FROM lw_otherclients WHERE brief_file='".$_POST['Brief_Filebeforechange']."'",$db);	
			while($myrowotherclients=DB_fetch_array($resultclients))
                      {
                         $clients[$i++]= $myrowotherclients[0];
                      }
                                
                $countclients=count($clients);
				
              for($i=0;$i<$countclients;$i++)
                {
                     $sql = "UPDATE lw_otherclients SET
                          brief_file='".trim($_POST['Brief_Fileupdate'])."'
                         WHERE id= '".$clients[$i]."'";
                  $result=DB_query($sql,$db);	                    
                    
                }      
                
                 //make changes for brief_file in lw_citations table
                
              $resultpartycitation=DB_query("SELECT citationid FROM lw_citations WHERE brief_file='".$_POST['Brief_Filebeforechange']."'",$db);  
              $myrowcitation=DB_fetch_array($resultpartycitation);
                
                $sql = "UPDATE lw_citations SET
                          brief_file='".trim($_POST['Brief_Fileupdate'])."'
                         WHERE citationid= '".$myrowcitation[0]."'";
                  $result=DB_query($sql,$db);	
                
                //make changes for brief_file in lw_partyeconomy table
                
              $resultpartyeconomy=DB_query("SELECT id FROM lw_partyeconomy WHERE brief_file='".$_POST['Brief_Filebeforechange']."'",$db);  
              $myrowpartyeconomy=DB_fetch_array($resultpartyeconomy);
                
                $sql = "UPDATE lw_partyeconomy SET
                          brief_file='".trim($_POST['Brief_Fileupdate'])."'
                         WHERE id= '".$myrowpartyeconomy[0]."'";
                   $result=DB_query($sql,$db);	
                
                
                //make changes for brief_file in lw_partytrans table
                
                 $partytrans=array();
                 $i=0;
    
            $resultpartytrans=DB_query("SELECT id FROM lw_partytrans WHERE brief_file='".$_POST['Brief_Filebeforechange']."'",$db);	
				while($myrowpartytrans=DB_fetch_array($resultpartytrans))
                      {
                         $partytrans[$i++]= $myrowpartytrans[0];
                      }
    
                            
                $countpartytrans=count($partytrans);
                
                for($i=0;$i<$countpartytrans;$i++)
                {
                     $sql = "UPDATE lw_partytrans SET
                          brief_file='".trim($_POST['Brief_Fileupdate'])."'
                         WHERE id='".$countpartytrans[$i]."'";
                  $result=DB_query($sql,$db);	
                    
                    
                }  
                
                           
            } //end of $_POST['Brief_Fileupdate']!=$_POST['Brief_Filebeforechange'] conditional statement
               
 $sql='Select casehistoryid from lw_casehistory ORDER BY casehistoryid DESC LIMIT 1';
		
		$result=DB_query($sql,$db);
		
		$myrowcasehistory = DB_fetch_array($result);   
		
		$myrowcasehistory[0]=$myrowcasehistory[0]+1;
		
		$_POST['Casehistoryid']=0;
				
		if($_POST['Closecase'])
		{
		//insert statement for lw_casehistory
		
		$closecase=37;
		
		 if ($_POST['Casereopendate'] === "") 
   		{
   
  		 $Casereopendate = "NULL";
  		 }else {
  		 $Casereopendate=FormatDateForSQL($_POST['Casereopendate']);
       
        $Casereopendate="'\ " . $Casereopendate . "\" . '";
        }
		
		if ($_POST['Closedateupdate'] === "") 
   		{
  		 $Closedateupdate = "NULL";
  		 }else {
  		 $Closedateupdate=FormatDateForSQL($_POST['Closedateupdate']);
       
        $Closedateupdate="'\ " . $Closedateupdate . "\" . '";
        }
		
		
		$sql = "INSERT INTO lw_casehistory(
			casehistoryid,
			brief_file,
			party,
			oppoparty,
			result,
			caseclosedate,
			courtcaseno,
			courtid,
			coram,
			judgement,
			remark
			)
			VALUES ('".trim($myrowcasehistory[0])."',
			'".trim($_POST['Brief_Fileupdate'])."',
			'".trim($_POST['Casepartyid'])."',
			'".trim($_POST['Caseoppopartyid'])."',
			'".trim($_POST['Result'])."',
			$Closedateupdate,
			'".trim($_POST['Courtcasenoupdate'])."',
			'".trim($_POST['Courtidupdate'])."',
			'".trim($_POST['Coram'])."',
			'".trim($_POST['Judgementorder'])."',
			'".trim($_POST['Casecloseremark'])."'	
			)";
			
					
		$result = DB_query($sql,$db);
		
			
		  $sql = "UPDATE lw_cases SET
			 		deleted=1 WHERE id = '".trim($_POST['ID'])."'";	
					 
		$resultcase=DB_query($sql,$db); 
				
		}       
		       
  
    if ($_POST['FIRdateupdate'] === "") 
   {
    $Firdateupdate = "NULL";
   }else {
   $Firdateupdate=FormatDateForSQL($_POST['FIRdateupdate']);
       
       $Firdateupdate="'\ " . $Firdateupdate . "\" . '";
       
   }
   
   //Notice update section
      
   if($_POST['Notice_no_id_update']=="")
   {
    if(!empty($_POST['Notice_noupdate']))
   {
   	
    $sqlnoticeid="SELECT noticeid from lw_noticecr WHERE notice_no='" .$_POST['Notice_noupdate']. "'";
			$result = DB_query($sqlnoticeid,$db);
			
			$myrownoticeid=DB_fetch_array($result);
			//if notice no is selected allocate the noticeno as below			
					
			if(!empty($myrownoticeid[0]))
			{
			$sqlnotice = "UPDATE lw_noticecr SET allocated=1 WHERE noticeid='".$myrownoticeid[0]."'";			
			$resultnotice=DB_query($sqlnotice,$db);	
			
			$_POST['Notice_noupdate']=$myrownoticeid[0];
			}elseif($myrownoticeid[0]=="")
			{
			$stmtnotice= "INSERT INTO lw_noticecr (notice_no,
			allocated
					)
			VALUES ('" . trim($_POST['Notice_noupdate']) . "',
					1
					)";
		
			$result=DB_query($stmtnotice,$db);
			
			
			
			$sqlnoticeid="SELECT noticeid from lw_noticecr WHERE notice_no='" .$_POST['Notice_noupdate']. "'";
			$result = DB_query($sqlnoticeid,$db);
			
			$myrownoticeid=DB_fetch_array($result);
			
			$_POST['Notice_noupdate']=$myrownoticeid[0];
			
			//now insert entry 
			
			$stmtnotice= "INSERT INTO lw_notices (noticeno
					)
			VALUES ('" . trim($_POST['Notice_noupdate']) . "'
					)";
		
			$result=DB_query($stmtnotice,$db);			
				
			}//end of notice
			
   
   } 
   
   } else
   {
   $_POST['Notice_noupdate']=$_POST['Notice_no_id_update'];
   
   }
   
   if(isset($closecase))
   {
   
   $_POST['Stageupdate']=$closecase;
   
   }
   
    			 if(empty($_POST['Courtcasenoupdate']))
				   {
				   $_POST['Courtcasenoupdate']="null";  
				   $_POST['Courtcasenoupdate']=trim($_POST['Courtcasenoupdate']);
				   
				   $sql = "UPDATE lw_cases SET
			 		brief_file='".trim($_POST['Brief_Fileupdate'])."',
			  		notice_no='".trim($_POST['Notice_noupdate'])."',
					govt_dept_no='".trim($_POST['Govt_dept_noupdate'])."',
			  		counselparty='".trim($_POST['Counselpartyupdate'])."',
					counseloppoparty='".trim($_POST['Counseloppopartyupdate'])."',
			  		partyrole='".trim($_POST['Partyroleupdate'])."',
			  		oppopartyrole='".trim($_POST['Oppopartyroleupdate'])."',
			  		clientcatid='".trim($_POST['Clientcatidupdate'])."',
					casecatid='".trim($_POST['Casecatidupdate'])."',					
					opendt='".FormatDateForSQL(trim($_POST['Opendateupdate']))."',					
					closedt='".FormatDateForSQL(trim($_POST['Closedateupdate']))."',
					stage='".trim($_POST['Stageupdate'])."',
					remark='".strtoupper(trim($_POST['Remarkupdate']))."',
					courtcaseno='".strtoupper(trim($_POST['Courtcasenoupdate']))."',
					courtid='".trim($_POST['Courtidupdate'])."',					
					firnumber='".trim($_POST['FIRnumberupdate'])."',
					firdate=$Firdateupdate,
					firtime='".trim($_POST['FIRtime'])."',
					policestation='".trim($_POST['Policestationupdate'])."',
					casehistoryid='".trim($myrowcasehistory[0])."',				
					judgename='".trim($_POST['Judgenameupdate'])."',
					cnrnumber='".trim($_POST['Cnrupdate'])."'
					WHERE id = '".$_POST['ID']."'";	
                   }else
				   {					 
					 $sql = "UPDATE lw_cases SET
			 		brief_file='".trim($_POST['Brief_Fileupdate'])."',
			  		notice_no='".trim($_POST['Notice_noupdate'])."',
					govt_dept_no='".trim($_POST['Govt_dept_noupdate'])."',
			  		counselparty='".trim($_POST['Counselpartyupdate'])."',
					counseloppoparty='".trim($_POST['Counseloppopartyupdate'])."',
			  		partyrole='".trim($_POST['Partyroleupdate'])."',
			  		oppopartyrole='".trim($_POST['Oppopartyroleupdate'])."',
			  		clientcatid='".trim($_POST['Clientcatidupdate'])."',
					casecatid='".trim($_POST['Casecatidupdate'])."',					
					opendt='".FormatDateForSQL(trim($_POST['Opendateupdate']))."',					
					closedt='".FormatDateForSQL(trim($_POST['Closedateupdate']))."',
					stage='".trim($_POST['Stageupdate'])."',
					remark='".strtoupper(trim($_POST['Remarkupdate']))."',
					courtcaseno='".strtoupper(trim($_POST['Courtcasenoupdate']))."',
					courtid='".trim($_POST['Courtidupdate'])."',					
					firnumber='".trim($_POST['FIRnumberupdate'])."',
					firdate=$Firdateupdate,
					firtime='".trim($_POST['FIRtime'])."',
					policestation='".trim($_POST['Policestationupdate'])."',
					casehistoryid='".trim($myrowcasehistory[0])."',				
					judgename='".trim($_POST['Judgenameupdate'])."',
					cnrnumber='".trim($_POST['Cnrupdate'])."'
					WHERE id = '".$_POST['ID']."'";	
				   }		  
					 
			$resultcase=DB_query($sql,$db); 		
				
			//Save Courtcaseno history as well if courtcaseno is changed
			
			if($_POST['Oldcaseno']!=$_POST['Courtcasenoupdate'])
			{
			
			//update caseno in diary if the entry has blank courtcaseno
		$sqlupdatecourtcaseno = 'UPDATE lw_trans SET courtcaseno="'.$_POST['Courtcasenoupdate'].'" WHERE brief_file="'.$_POST['Brief_Fileupdate'].'"';			
		$resultupdatecourtcaseno=DB_query($sqlupdatecourtcaseno,$db);	
				 
				/*		
				 if($_POST['Caseno_Radio']==0) //means correction in case no
				 {
				 
				 //update caseno in diary if the entry has blank courtcaseno
		$sqlupdatecourtcaseno = 'UPDATE lw_trans SET courtcaseno="'.$_POST['Courtcasenoupdate'].'" WHERE brief_file="'.$_POST['Brief_Fileupdate'].'"';			
		$resultupdatecourtcaseno=DB_query($sqlupdatecourtcaseno,$db);	
				 
				 }else if($_POST['Caseno_Radio']==1) //new case no
				 {
				 
							
		$sql = "INSERT INTO lw_casenohistory(
			brief_file,
			casenodate,
			oldcourtcaseno,
			casenoremark
			)
			VALUES ('".trim($_POST['Brief_Fileupdate'])."',
			'".trim(date("Y-m-d"))."',
			'".trim($_POST['Courtcasenobeforeupdate'])."',
			'".trim($_POST['casenoremark'])."'	
			)";
		
		$result = DB_query($sql,$db);
		
		
		//make blank entry in diary
			
		// first entry in the diary
		
		$nextdate="NULL";			  		
			
		$stmt= "INSERT INTO lw_trans (brief_file,
					currtrandate,
					courtname,
					courtcaseno,
					party,
					oppoparty,
					stage,
					nextcourtdate
					)
			VALUES ('" . trim($_POST['Brief_Fileupdate']) . "',
				'".trim(date("Y-m-d"))."',
				'" . trim($_POST['Courtidupdate']) . "',
				'" . trim($_POST['Courtcasenoupdate']) . "',
				'" . trim($_POST['Casepartyid']) . "',
				'" . trim($_POST['Caseoppopartyid']) . "',
				'" . trim($_POST['Stageupdate']) . "',
				$nextdate
				)";			
		
		$result=DB_query($stmt,$db);				
		
		//new diary entry end			
				 
				 }	 */	 			
				
			}			
			
			//Save Judges history as well if judge is changed
					
			if($_POST['Oldjudgename']!=$_POST['Judgenameupdate'])
			{
		$sql = "INSERT INTO lw_judgehistory(
			brief_file,
			namechangedate,
			oldjudgename,
			judgeremark
			)
			VALUES ('".trim($_POST['Brief_Fileupdate'])."',
			'".trim(date("Y-m-d"))."',
			'".trim($_POST['Oldjudgename'])."',
			'".trim($_POST['Judgeremarkupdate'])."'	
			)";
		
		$result = DB_query($sql,$db);	
			}		
			
		?>
	
<script>
		
swal({   title: "Case Updated!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('lw_casenew_alt.php'); //will redirect to your page
}, 2000); 

	</script>
                      
       <?php
	 
		}
		
	else  //insert mode for new case starts
		{ //it is a new case	
		
		###############################################################################################						
					
		//first check if $_POST['Caseparty'] value is already there in the lw_contacts table			
					
		if (!empty($_POST['Casepartyid']))
		{
		
		$sql = "UPDATE lw_contacts SET
			address='".strtoupper(trim($_POST['Address']))."',
			mobile='".trim($_POST['Mobile'])."'
			WHERE id= '".$_POST['Casepartyid']."'";			
		$result=DB_query($sql,$db);		
				
		}
		 else		
		{ 		
		
		//put an sql statement to check id from $_POST['Casepartynamehidden'] value
		
		$sqlcontactid = "SELECT id FROM lw_contacts WHERE name='".trim($_POST['Casepartynamehidden'])."'";
		$resultcontactid = DB_query($sqlcontactid,$db);
		$myrowcontactid = DB_fetch_row($resultcontactid);
		$Casepartyid=$myrowcontactid[0];		
		
		if ($Casepartyid>0)
		{
		//echo 'reached case party update for old party';
		
			$sql = "UPDATE lw_contacts SET
			address='".strtoupper(trim($_POST['Address']))."',
			mobile='".trim($_POST['Mobile'])."'
			WHERE id='".$Casepartyid."'";
			
		$result=DB_query($sql,$db);
		
		$_POST['Casepartyid']=$Casepartyid;		
				
		}
		else
		{		
		//echo 'reached case party insert for new party insert';
		
			$sql = "INSERT INTO lw_contacts(
			name,
			address,
			mobile
			)
			VALUES ('".strtoupper(trim($_POST['Casepartynamehidden']))."',
			'".strtoupper(trim($_POST['Address']))."',
			'".trim($_POST['Mobile'])."'
			)";
		
	$result = DB_query($sql,$db);
		
		$sqlcontactid = "SELECT id FROM lw_contacts WHERE name='".trim($_POST['Casepartynamehidden'])."'";
		$resultcontactid = DB_query($sqlcontactid,$db);
		$myrowcontactid = DB_fetch_row($resultcontactid);
		$Casepartyid=$myrowcontactid[0];
		
		$_POST['Casepartyid']=$Casepartyid;
	
				
		}
			
		}				
		
		//first check if $_POST['Caseoppoparty'] value is already there in the lw_contacts table
		
							
		if (!empty($_POST['Caseoppopartyid']))
		{
		
			$sql = "UPDATE lw_contacts SET
			address='".strtoupper(trim($_POST['Addressoppo']))."',
			mobile='".trim($_POST['Mobileoppo'])."'
			WHERE id='".$_POST['Caseoppopartyid']."'";
			
			$result=DB_query($sql,$db);
				
		} else
				
		{
		
		//echo 'reached case oppo party insert for new oppo party ';
		
		//put an sql statement to check id from $_POST['Casepartynamehidden'] value
		
		$sqlcontactid = "SELECT id FROM lw_contacts WHERE name='".trim($_POST['Caseoppopartynamehidden'])."'";
		$resultcontactid = DB_query($sqlcontactid,$db);
		$myrowcontactid = DB_fetch_row($resultcontactid);
		$Caseoppopartyid=$myrowcontactid[0];
		
		if (!empty($Caseoppopartyid))
		{
			$sql = "UPDATE lw_contacts SET
			address='".strtoupper(trim($_POST['Addressoppo']))."',
			mobile='".trim($_POST['Mobileoppo'])."'
			WHERE id='".$Caseoppopartyid."'";
			
		$result=DB_query($sql,$db);
		
		$_POST['Caseoppopartyid']=$Caseoppopartyid;
						
		}
		else
		{
		 //echo 'reached insert of case oppo party contact-reached safely';
                      
			$sql = "INSERT INTO lw_contacts(
			name,
			address,
			mobile			
			)
			VALUES ('".strtoupper(trim($_POST['Caseoppopartynamehidden']))."',
			'".strtoupper(trim($_POST['Addressoppo']))."',
			'".trim($_POST['Mobileoppo'])."'
			)";
				
		$result = DB_query($sql,$db);
		
		$sqlcontactid = "SELECT id FROM lw_contacts WHERE name='".trim($_POST['Caseoppopartynamehidden'])."'";
		$resultcontactid = DB_query($sqlcontactid,$db);
		$myrowcontactid = DB_fetch_row($resultcontactid);
		$Caseoppopartyid=$myrowcontactid[0];
		
		$_POST['Caseoppopartyid']=$Caseoppopartyid;
    		
		}
		
		}

		/*while(substr_count($_POST['Courtcaseno']," ") != 0){
       $_POST['Courtcaseno'] = str_replace(" ","",$_POST['Courtcaseno']);
    	}	*/
		
		       
        if ($_POST['Opendate'] === "") 
   {
    // echo 'reaching Opendateupdate null';
  	 $Opendate = "NULL";
   }else {
   $Opendate=FormatDateForSQL($_POST['Opendate']);
       
      // $Opendate="'$Opendate'";
       
   }
   
      if ($_POST['FIRdate'] === "") 
   {
    // echo 'reaching Firdate null';
  	 $Firdate = "NULL";
   }else {
   $Firdate=FormatDateForSQL($_POST['FIRdate']);
       
       $Firdate="'\ " . $Firdate . "\" . '";
       
   }  
   
   
   if($_POST['Notice_nohidden']=="")
     {
   $_POST['Notice_no']="NULL";  
     }else
	 {
	 $_POST['Notice_no']="'\ " . $_POST['Notice_no'] . "\" . '";
	 }
   
   if(!empty($_POST['Notice_nohidden']))
   
   {
   			//if notice no is selected allocate the noticeno as below			
					
			if(!empty($_POST['Notice_no_id']))
			{
			$sqlnotice = "UPDATE lw_noticecr SET allocated=1 WHERE noticeid='".$_POST['Notice_no_id']."'";			
			$resultnotice=DB_query($sqlnotice,$db);	
			
			$_POST['Notice_no']=$_POST['Notice_no_id'];
			}elseif($_POST['Notice_no_id']=="")
			{
			$stmtnotice= "INSERT INTO lw_noticecr (notice_no,
			allocated,
			party,
			oppoparty
					)
			VALUES ('" . trim($_POST['Notice_nohidden']) . "',
					1,
					'".$_POST['Casepartyid']."',
					'".$_POST['Caseoppopartyid']."'					
					)";
		
			$result=DB_query($stmtnotice,$db);
			
			$sqlnoticeid="SELECT noticeid from lw_noticecr WHERE notice_no='" .$_POST['Notice_nohidden']. "'";
			$result = DB_query($sqlnoticeid,$db);
			
			$myrownoticeid=DB_fetch_array($result);
			
			$_POST['Notice_no']=$myrownoticeid[0];
				
			}//end of notice
			
   
   }   				
   
				   if(empty($_POST['Courtcaseno']))
				   {
				   $_POST['Courtcaseno']="null";  
				   $_POST['Courtcaseno']=trim($_POST['Courtcaseno']);
                   }else
				   {
					 $_POST['Courtcaseno']="'" . $_POST['Courtcaseno'] . "'";
				   }
				   			 
					$sqlcase = "INSERT INTO lw_cases(
					brief_file,
					notice_no,
					govt_dept_no,
					party,
					oppoparty,
					counselparty,
					counseloppoparty,
					partyrole,
					oppopartyrole,
     				clientcatid,
					casecatid,
					opendt,
					stage,
					remark,
					courtcaseno,
					courtid,
					firnumber,
					firdate,
					firtime,
					policestation,
					judgename,
					cnrnumber
						)
				VALUES ('".trim($_POST['Brief_File'])."',
					".trim($_POST['Notice_no']).",
					'".trim($_POST['Gov_department_no'])."',
					'".$_POST['Casepartyid']."',
					'".$_POST['Caseoppopartyid']."',
					'".trim($_POST['Counselparty'])."',
					'".trim($_POST['Counseloppoparty'])."',
					'".$_POST['Selectedroleparty']."',
				    '".$_POST['Selectedroleoppoparty']."',
					'".$_POST['Clientcat']."',
					'".$_POST['Casecat']."',
					'".$Opendate."',
					'".$_POST['Stage']."',
					'".trim($_POST['Remark'])."',
					".$_POST['Courtcaseno'].",
					'".$_POST['Court']."',
					'".trim($_POST['FIRnumber'])."',
					$Firdate,
					'".trim($_POST['FIRtime'])."',
					'".trim($_POST['Policestation'])."',
					'".trim($_POST['Judgename'])."',
					'".trim($_POST['Cnrinsert'])."'
					)";					
															
			$ErrMsg = _('This case could not be added because');
			$result = DB_query($sqlcase,$db,$ErrMsg);	
			
			//$lastclientname=DB_Last_Insert_ID($db,"lw_cases", "id");
			                      
			$lastclientname=strtoupper(trim($_POST['Casepartynamehidden']));
        					
			//Create a directory in the name of the Party in cases folder
						
			chmod($_SERVER['DOCUMENT_ROOT'].'/lawpract/cases/',0750);
			
						
			$dirname="lpt_".$lastclientname;
  
			if(!file_exists('cases/'.$dirname))
			{
						
			mkdir('cases/'.$dirname,0777);	
					 
			}
			
			 
   // start of code for first entry in the diary as soon as new case is created
			
	$result=DB_query("SELECT * FROM lw_trans WHERE brief_file='" . trim($_POST['Brief_File']) . "' ORDER BY currtrandate DESC LIMIT 1",$db);
	
	$myrownew=DB_fetch_array($result);
		
	if (!empty($myrownew[0])) 
		{ 		
	    		  

		}
		else 
		{	
		// first entry in the diary
			  		
	if(empty($_POST['Nextdate']))
	{
	 $nextdate = "NULL";
  		 }else {	
		 
	    $nextdate=FormatDateForSQL($_POST['Nextdate']);	
		$nextdate="'\ " . $nextdate. "\" . '";
				 
	     }
				 
	if(empty($_POST['Currdate']))
	{
	 $otherdate = "NULL";
  		 }else {	
    $otherdate=FormatDateForSQL($_POST['Currdate']);
	$otherdate="'\ " . $otherdate . "\" . '";
	     }
			
		$stmt= "INSERT INTO lw_trans (brief_file,
					currtrandate,
					courtname,
					courtcaseno,
					party,
					oppoparty,
					stage,
					nextcourtdate
					)
			VALUES ('" . trim($_POST['Brief_File']) . "',
				$otherdate,
				'" . trim($_POST['Court']) . "',
				" . trim($_POST['Courtcaseno']) . ",
				'" . trim($_POST['Casepartyid']) . "',
				'" . trim($_POST['Caseoppopartyid']) . "',
				'" . trim($_POST['Stage']) . "',
				$nextdate
				)";
		
		$result=DB_query($stmt,$db);
		
						// for next date diary entry 
			if (!empty($nextdate) && strlen($nextdate)==18) 
				{
				
	$result=DB_query("SELECT * FROM lw_trans WHERE brief_file='" . trim($_POST['Brief_File']) . "' ORDER BY currtrandate DESC LIMIT 1",$db);
	
	$myrownew=DB_fetch_array($result);
			$stmtnextdiary= "INSERT INTO lw_trans (brief_file,
					currtrandate,
					prevcourtdate,
					courtname,
					courtcaseno,
					party,
					oppoparty,
					stage					
					)
			VALUES ('" . trim($_POST['Brief_File']) . "',
				$nextdate,
				'" . trim($myrownew['currtrandate']) . "',
				'" . trim($_POST['Court']) . "',
				 " . trim($_POST['Courtcaseno']) . ",
				'" . trim($_POST['Casepartyid']) . "',
				'" . trim($_POST['Caseoppopartyid']) . "',
				'" . trim($_POST['Stage']) . "'				
				)";
		
			$result=DB_query($stmtnextdiary,$db);	
				}
		}				
			//end of diary entry			
							
		?>

<script> 
		
swal({   title: "Case Inserted!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('lw_casenew_alt.php'); //will redirect to your page
}, 2000); 


 </script>
                        
       <?php		
	
	}
 
}

if (empty($myrowparty))
 {

//below is the code to fetch $final values for all the radio buttons on page load
    
    if($_SESSION['Brief_File_Numbering']==0)
    {
			
	$sqllastvaluebcc= "SELECT brief_file FROM lw_cases";			
				
				$bccarray=array();
				$i=0;		 
				$resultlast = DB_query($sqllastvaluebcc,$db);
				while($myrowlast= DB_fetch_array($resultlast))
				{
				  $pieces = explode("/", $myrowlast[0]);
			      $piecesfirstcode = explode("_", $pieces[0]);			  
				  $bccarray[$i++]=$piecesfirstcode[1];
												
				}
				
			   rsort($bccarray);
		
				$last=$bccarray[0];
				
				$last++;
				    
    	if ($last>=0 && $last<=9) 
			{		  
				
			  $finalvaluebcc='000'.$last.'/'.date('Y');
			
		    }  elseif ($last>9 && $last<=99) 
			{		  
				
			  $finalvaluebcc='00'.$last.'/'.date('Y');
			
		    }  elseif ($last>=100 && $last<=999) 
			{		  
				
			  $finalvaluebcc='0'.$last.'/'.date('Y');
			
		    } elseif ($last>999) 
			{		  
				
			  $finalvaluebcc=$last.'/'.date('Y');
			
		    } 	// end of bcc	
				
			
	?>
                         

<script>
var finalvaluebcc=new Array(1);

finalvaluebcc=<?php echo json_encode($finalvaluebcc); ?>;

var finalvaluefcc=new Array(1);

finalvaluefcc=<?php echo json_encode($finalvaluefcc); ?>;

var finalvalueboc=new Array(1);

finalvalueboc=<?php echo json_encode($finalvalueboc); ?>;

var finalvaluefoc=new Array(1);

finalvaluefoc=<?php echo json_encode($finalvaluefoc); ?>;

</script>


<?php

}//if not $_SESSION['Brief_File_Numbering']==1
    
?>


<form method='POST' name='caseform' action="<?php echo $_SERVER['PHP_SELF']  . '?' . SID ; ?>">
<?php


/*If the page was called without $_POST['Brief_File'] passed to page then assume a new case is to be entered show a form with a Case Code field other wise the form showing the fields with the existing entries against the case will show for editing with only a hidden brief_file field*/

	echo "<input type='Hidden' name='New' value='Yes'>";
	
	$DateString = Date($_SESSION['DefaultDateFormat']);

	$DataError =0; 
    ?>  
    
	<div class="md-input-wrapper">
        
        <?php

     if($_SESSION['Brief_File_Numbering']==0)
    { ?>

        <!-- insert mode here-->               
    <div class="uk-grid uk-grid-width-3-5 uk-grid-width-medium-1-2" style="margin-left:5px; border-bottom:1px solid rgba(0,0,0,.12)">
    <div class="uk-width-medium-1-4"></div>
     <div class="uk-width-medium-1-4"></div>
    <div class="uk-width-medium-1-4"></div>
    <div class="uk-width-medium-1-4"></div>
    
			  <div class="uk-width-medium-1-4">		                                    
		   	  <input type="radio" name="BF_Radio" value="BR_" id="Bcc_Radio" tabindex="1" checked="checked">Brief Court Case</div>
              <div class="uk-width-medium-1-4"> 
              <input type="radio" name="BF_Radio" value="FL_" id="Fcc_Radio" tabindex="2">File Court Case</div> 
              <div class="uk-width-medium-1-4"></div>
              <div class="uk-width-medium-1-4" align="right" style="padding-right:30px"> <span class="menu_title" style="text-decoration:underline; cursor:pointer" onclick="javascript:MM_openbrwindow('Manualcases.php',600,400);"><i class="material-icons md-color-green-500">&#xE887;</i></span>
              </div>
                
              <div class="uk-width-medium-1-4">
              <input type="radio" name="BF_Radio" value="BO_" id="Boc_Radio" tabindex="3">Brief Other than Court</div>
          	   <div class="uk-width-medium-1-4">
               <input type="radio" name="BF_Radio" value="FO_" id="Foc_Radio" tabindex="4">File Other than Court</div>
                <div class="uk-width-medium-1-4"></div>
                <div class="uk-width-medium-1-4">   
   
               </div>           
				       
         </div>
       
         <br />
        <?php
            
        }
    
    ?>
        
        <div class="uk-width-medium-1-1" style="padding-bottom:0px">
        <div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">
         
        <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-2-2">
        <div class="uk-form-row">
        <div class="uk-grid">
               
        <!--data-uk-tooltip="{pos:'bottom'}"-->
        
        <!--data-uk-tooltip="{cls:'long-text'}"-->        
        
        <div class="uk-width-medium-1-3" style="padding-bottom:10px">Brief_File No*
          <input type="Text" name="Brief_File" id="Brief_File" class="md-input" data-uk-tooltip="{cls:'long-text',pos:'bottom'}" title="Select radio buttons" tabindex="5" value="<?php echo 'BR_'. $finalvaluebcc; ?>">
       </div>           
     
     <div class="uk-width-medium-1-3" style="padding-bottom:0px">Case No 
	  <input tabindex="6" type="Text" name="Courtcaseno" id="Courtcaseno" class="md-input" data-uk-tooltip="{cls:'long-text',pos:'bottom'}"  title="Format: CA/111/2018"></div>
	    
	   <?php
      
 $result=DB_query('SELECT casecatid, casecat FROM lw_casecat',$db); ?>
	
  <div class="uk-width-medium-1-3" style="padding-bottom:10px">Case/Matter Type
		<select name="Casecat" id="Casecat" tabindex="7" class="md-input">
        <!--<option selected VALUE=""></option>-->
		<?php
	while ($myrow = DB_fetch_array($result)) {

		if ($_POST['Casecat']==$myrow['casecatid']){
			echo '<option selected VALUE='. $myrow['casecatid'] . '>' . $myrow['casecat'];
		} else {
			echo '<option VALUE='. $myrow['casecatid'] . '>' . $myrow['casecat'];
		}

	} //end while loop
	DB_data_seek($result,0);
        echo '</select></div>';
	  	     echo '<div class="uk-width-medium-1-3" style="padding-bottom:10px">';
  echo '<input type="text"  id="Notice_no" name="Notice_no" tabindex="8" class="md-input" placeholder="Type here Notice No"></div>';
	
	echo '<input type="hidden" id="Notice_nohidden" name="Notice_nohidden">';
	
	echo '<input type="hidden" id="Notice_no_id" name="Notice_no_id">'; 
	   
	 echo'<div class="uk-width-medium-1-3" style="padding-bottom:10px">Judge Name
      <input tabindex="9" type="Text" name="Judgename" id="Judgename" class="md-input"></div> ';  
	   
	  $result=DB_query("SELECT courtid,courtname FROM lw_courts ORDER BY courtid ASC",$db);

			echo '<div class="uk-width-medium-1-3" style="padding-bottom:10px">Designation/Court';
			echo '<select tabindex="10" name="Court" id="Court" class="md-input">';
			
			while ($myrow = DB_fetch_array($result)) {
					echo "<option VALUE='". $myrow['courtid'] . "'>" . $myrow['courtname'];
				} //end while loop
			
			DB_free_result($result);
			echo '</select></div>'; 		
	
		?>  
            </div></div></div></div>		
           			 </div>      
                </div>
            </div>
            </div>
            </div><!-- end of md-input-wrapper -->
                  
       <?php   
         //New md-card for party and oppo party
echo '<div class="md-input-wrapper"><div class="md-card"><div class="md-card-content">';

echo '<div class="uk-width-medium-1-1" style="padding-bottom:0px">';
echo '<div class="uk-grid uk-grid-width-1-2 uk-grid-width-large-1-2">';
  
echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Party Name:*';

echo '<input type="text" name="Casepartyname" id="Casepartyname" class="Casepartyname" placeholder="Type New Party Name or Select From List..." tabindex="11">';
 echo '<input type="hidden" name="Casepartyid" id="Casepartyid">';
 echo '<input type="hidden" name="Casepartynamehidden" id="Casepartynamehidden">'; 
echo '</div>'; 	
echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Opposition Party Name:*';
echo '<input type="text" class="Caseoppopartyname" name="Caseoppopartyname" id="Caseoppopartyname" placeholder="Type New Opposite Party Name or Select From List..." tabindex="16"/>';
echo '<input type="hidden" name="Caseoppopartyid" id="Caseoppopartyid">';
echo '<input type="hidden"  name="Caseoppopartynamehidden" id="Caseoppopartynamehidden">';
echo '</div>'; 

$result=DB_query("SELECT roleid, role FROM lw_partiesinvolved",$db);

echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px">Role Party';
echo '<select tabindex="12" name="Selectedroleparty" id="Selectedroleparty" class="md-input">';

while ($myrow = DB_fetch_array($result)) {
	echo "<option VALUE='". $myrow['roleid'] . "'>" . $myrow['role'];
	} //end while loop

DB_free_result($result);

echo '</select></div>';   
    
		 echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px">Address Party';
         echo '<input type="Text" class="md-input" name="Address" id="Address"  tabindex="13"></div>'; 
		 
             $result=DB_query("SELECT roleid, role FROM lw_partiesinvolved",$db);

echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px">Role Opposite Party';
echo '<select tabindex="17" name="Selectedroleoppoparty" id="Selectedroleoppoparty" class="md-input">';

while ($myrow = DB_fetch_array($result)) {
	
		echo "<option VALUE='". $myrow['roleid'] . "'>" . $myrow['role'];
	
} //end while loop

DB_free_result($result);

echo '</select></div>'; 
?>
         <div class="uk-width-medium-1-4" style="padding-bottom:10px">
                                       Address Opposite Party
                                        <input class="md-input" tabindex="18" type="Text" name="Addressoppo" id="Addressoppo">
             </div>
        <div class="uk-width-medium-1-4" style="padding-bottom:10px">
                                       Mobile Party
                                        <input class="md-input" tabindex="14" type="Text" name="Mobile" id="Mobile">
                                    </div>                                    
                                  <div class="uk-width-medium-1-4" style="padding-bottom:10px">
                                        Appearing Lawyer
                                        <input class="md-input" tabindex="15" type="text" name="Counselparty" id="Counselparty">
                                    </div>
                                    
                  <div class="uk-width-medium-1-4" style="padding-bottom:10px">Mobile No Opposite Party
                  <input class="md-input" tabindex="19" type="Text" name="Mobileoppo" id="Mobileoppo">
                  </div>
                 <div class="uk-width-medium-1-4" style="padding-bottom:10px">Opposite Party  Lawyer
                 <input class="md-input" tabindex="20" type="Text" name="Counseloppoparty" id="Counseloppoparty" />
                                    </div>                  
          
          </div>
                   </div>
            </div>
            
            </div><!-- end of md-input-wrapper -->
      
                                                                     
<?php   
    	echo '<div class="md-input-wrapper"><div class="md-card"><div class="md-card-content">';

echo '<div class="uk-width-medium-1-1" style="padding-bottom:0px">';
echo '<div class="uk-grid uk-grid-width-1-2 uk-grid-width-large-1-2">';

	 echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px">Case Open Date
  
    <input class="md-input" type="text" name="Opendate" id="Opendate" tabindex="21" data-uk-datepicker="{format:\'DD/MM/YYYY\'}"  >
    
     </div>';
	
     echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px">Government Dept. No. :
      <input tabindex="22" type="Text" name="Gov_department_no" id="Gov_department_no" class="md-input"></div>';  
	 
	  $result=DB_query("SELECT clientcatid, category FROM lw_clientcat",$db);

				echo '<div class="uk-width-medium-2-4" style="padding-bottom:10px">Client Category';
				echo '<select tabindex="23" name="Clientcat" id="Clientcat" class="md-input">';
				
				while ($myrow = DB_fetch_array($result)) { 
							echo "<option VALUE='". $myrow['clientcatid'] . "'>" . $myrow['category'];
					
				} //end while loop
				
				DB_free_result($result);
				
				echo '</select></div>';  		
        
     echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px">FIR Number
         <input tabindex="24" type="Text" name="FIRnumber" id="FIRnumber" class="md-input"></div>';
         	           
         			  echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px">FIR Date
            <input class="md-input" data-uk-datepicker="{format:\'DD/MM/YYYY\'}" name="FIRdate" tabindex="25"></div>';
             
               echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px">FIR Time';
            
      echo '<input class="md-input" data-uk-timepicker="" value="' . date("H:i:s") . '" autocomplete="off" name="FIRtime" tabindex="26"></div>';		
                      
   echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px">Police Station    
   <input class="md-input" type="text" tabindex="10" name="Policestation" id="Policestation" tabindex="27">
</div> ';
          echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">CNR No
<input class="md-input" type="Text" name="Cnrinsert" id="Cnrinsert" style="background-color:#CCFFFF" placeholder="Enter CNR No. here e.g. MHAU019999992018" tabindex="28" ></div>';
					 
		echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Narration
         <input tabindex="29" type="Text" name="Remark" id="Remark" class="md-input" ></div>';    
        	$result=DB_query('SELECT stageid, stage FROM lw_stages',$db);  
			
			echo '<div class="uk-width-medium-2-5" style="padding-bottom:10px">Stage';
			echo '<select tabindex="30" name="Stage" id="Stage" class="md-input">';
			while ($myrow = DB_fetch_array($result)) {
						echo '<option VALUE="' . $myrow['stageid'] . '">' . $myrow['stage'];
					} //end while loop
			
			DB_free_result($result);
			echo '</select></div>';	             
     ?>         
    <div class="uk-width-medium-1-5" style="padding-bottom:10px">
      Diary Page Date:
      <input class="md-input" data-uk-datepicker="{format:'DD/MM/YYYY'}" name="Currdate" id="Currdate" tabindex="31" value="<?php echo date("d/m/Y"); ?> ">
     </div>               
     
      <div class="uk-width-medium-1-5" style="padding-bottom:10px">
      Next Court Date:
     
            <input class="md-input" data-uk-datepicker="{format:'DD/MM/YYYY'}" name="Nextdate" id="Nextdate" tabindex="32">
     </div> 
            
         <?php
echo "<div class='uk-width-medium-1-5' style='padding-bottom:10px'><input tabindex='33' type='submit' name='Submit' id='Submit' class='md-btn md-btn-primary' value='Save Case' onClick='return checkvalidity()'></div> </div>	</form>";
// insert case form ends here
?>
</div></div>          			     
                </div>
            </div>
            
            </div><!-- end of md-input-wrapper -->
         
       <?php   
         //New md-card for Photo
echo '<div class="md-input-wrapper"><div class="md-card"><div class="md-card-content">';

echo '<div class="uk-width-medium-1-1" style="padding-bottom:0px">';
echo '<div class="uk-grid uk-grid-width-1-2 uk-grid-width-large-1-2">';
 ?>

<div class="uk-width-medium-1-4" style="padding-bottom:10px"><h4><b>Client's Photo section</b></h4></div>

  <div class="uk-width-medium-1-4" style="padding-bottom:10px">  <button onClick="startWebcam();" class="md-btn md-btn-flat md-btn-flat-danger">Start WebCam</button></div>
   <div class="uk-width-medium-1-4" style="padding-bottom:10px"> <button class="md-btn md-btn-flat md-btn-flat-danger" onClick="stopWebcam();">Stop WebCam</button></div>
   <div class="uk-width-medium-1-4" style="padding-bottom:10px"> <button class="md-btn md-btn-flat md-btn-flat-danger" onClick="snapshot();">Take Photo & Save</button> 
 	</div>

	<div class="uk-width-medium-1-4"><b>Preview of Client</b><br><img name="client_photo_preview" id="client_photo_preview" width="150" height="150" alt="" onerror="imgError()"/></div>

  
   <div class="uk-width-medium-1-4"><b>Live Video Stream</b><br><video onclick="snapshot(this);" width="200" height="200" id="video" controls autoplay></video></div>
   <div class="uk-width-medium-1-4"><form method="post" accept-charset="utf-8" name="form1"></div>
   
   <div class="uk-width-medium-1-4"><canvas id="myCanvas" width="150" height="150"></canvas></div>
  
       <input name="hidden_data" id='hidden_data' type="hidden"/>
       
       <input name="client_name" id='client_name' type="hidden"/>

 </form> 
 </div>

</div>
</div>
</div>

 <script>
  
         //--------------------
      // GET USER MEDIA CODE
      //--------------------
          navigator.getUserMedia = ( navigator.getUserMedia ||
                             navigator.webkitGetUserMedia ||
                             navigator.mozGetUserMedia ||
                             navigator.msGetUserMedia);

      var video;
      var webcamStream;

      function startWebcam() {
	  
	    if (navigator.getUserMedia) {
           navigator.getUserMedia (

              {
                 video: true,
                 audio: false
              },

              // successCallback
              function(localMediaStream) {
                  video = document.querySelector('video');
                 video.src = window.URL.createObjectURL(localMediaStream);
                 webcamStream = localMediaStream;
				 				 
              },
			  
			 // errorCallback
              function(err) {
                 console.log("The following error occured: " + err);
              }
           );
        } else {
           console.log("getUserMedia not supported");
        }  
      }

      function stopWebcam() {
      	  
	  var video = document.querySelector('video');
      video.pause();
	  video.src="";
	  webcamStream.getTracks()[0].stop();
	  //console.log("Vid off");
	   	  
  		}
		
      //---------------------
      // TAKE A SNAPSHOT CODE
      //---------------------
      var canvas, ctx;

      function init() {
        // Get the canvas and obtain a context for
        // drawing in it
        canvas = document.getElementById("myCanvas");
        ctx = canvas.getContext('2d');
		 }

      function snapshot() {
	  
	 if($("#Casepartynamehidden").val()!='')
	 {
	 			 var x=$("#Casepartynamehidden").val();  
				 
				   var f=x.replace(/ /g, "");			
			          
            jQuery('#client_name').val(f);
				 
			 // Draws current image from the video element into the canvas
        ctx.drawImage(video, 0,0, canvas.width, canvas.height);
		
		    // var canvas = document.getElementById("canvas");
                var dataURL = canvas.toDataURL("image/png");
                document.getElementById('hidden_data').value = dataURL;
				
				var fd = new FormData(document.forms["form1"]);
 
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'upload_photo.php', true);
 
                xhr.upload.onprogress = function(e) {
                    if (e.lengthComputable) {
                        var percentComplete = (e.loaded / e.total) * 100;
                        console.log(percentComplete + '% uploaded');
                        alert('Succesfully uploaded');				
						
			var image = document.getElementById("client_photo_preview");		          
           
          
            
            var url = 'contactimages/'+f+ '.png'; 
			
            jQuery('#client_photo_preview').attr('src', url); 
   	 

setTimeout(updateImage,3000);

 function updateImage() {
       image.src = image.src.split("?")[0] + "?" + new Date().getTime();
    }

                    }
                };
 
                xhr.onload = function() {
 
                };
                xhr.send(fd);
			
		//below is to clear canvas rectangle
		ctx.clearRect(0, 0, canvas.width, canvas.height);	   
			
			           
      }else
	  {
	  
	  if($("#client_name").val()=='')
	  {
	  
	  alert('Please select Party Name or enter new name First. The photo is saved in contact images folder as partyname.png');
	  
	  }else
	  {
	     
	 // Draws current image from the video element into the canvas
        ctx.drawImage(video, 0,0, canvas.width, canvas.height);
		
		    // var canvas = document.getElementById("canvas");
                var dataURL = canvas.toDataURL("image/png");
                document.getElementById('hidden_data').value = dataURL;
				
				var fd = new FormData(document.forms["form1"]);
 
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'upload_photo.php', true);
 
                xhr.upload.onprogress = function(e) {
                    if (e.lengthComputable) {
                        var percentComplete = (e.loaded / e.total) * 100;
                        console.log(percentComplete + '% uploaded');
                        alert('Succesfully uploaded');				
						
			var image = document.getElementById("client_photo_preview");

 			var x=$("#client_name").val();  
            
            var f=x.replace(/ /g, "");
                        
            var url = 'contactimages/'+f+ '.png';
            
            jQuery('#client_photo_preview').attr('src', url);  

setTimeout(updateImage,3000);

 function updateImage() {
       image.src = image.src.split("?")[0] + "?" + new Date().getTime();
    }

                    }
                };
 
                xhr.onload = function() {
 
                };
                xhr.send(fd);
			
		//below is to clear canvas rectangle
		ctx.clearRect(0, 0, canvas.width, canvas.height);			
		
}
	
	} //end of if condition if $("#client_name").val()=null
	      }
	
</script>


<!-- start of new md cards for other parties and oppo parties--->
     </div>
             <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-medium-1-2">
                    <div class="md-card">
                        <div class="md-card-content">                     
                    
                     <div class="uk-width-medium-1-1" style="margin-left:2px; font-weight:bold"><i class="material-icons md-color-blue-800" style="font-size:30px;cursor: pointer; vertical-align:middle; padding-left:0px">group_add</i> &nbsp;&nbsp;<label>Add Other Party Names</label> 
                             
                    <div class="uk-overflow-container">        
    
		 <div name="myform" id="myform" style="padding-top:0px; float:left; margin-left:10px; margin-top:10px;">                
                            
                   <table id="myTableData" class="" align="left" border-color:#CCCCCC" border="1" cellspacing="0">
                     <tr>
                     <td><input class="md-input" tabindex="34" type="text" name="Addclient" id="Addclient" placeholder="Enter Party here"></td>
                   
                   <td>
          <input class="md-btn md-btn-flat md-btn-flat-danger" name="add" id="add" tabindex="35" type="button"  value="Add Party" onclick="javascript: return addRow()">
                     
                        </td> 
                      </tr>
                                       
                       <tr>                       
                        <td width="370"><b>Client Name</b></td>
                         <td width="80"><b>Action</b></td>
                       </tr>
                       </table>
                        
                       </div>
                                                                                  
                       </div>
                                     
                      </div>
                    </div>
              </div>
          </div>
               <!-- Other opposite parties names -->   
                <div class="uk-width-large-1-2">
                    <div class="md-card">
                     <div class="md-card-content">
                 <div class="uk-width-medium-1-1" style="margin-left:0px; font-weight:bold"><i class="material-icons md-color-blue-800" style="font-size:30px;cursor: pointer; vertical-align:middle; padding-left:0px">group_add</i> &nbsp;&nbsp; <label>Add Other Opposite Party Names</label><div name="myformoppoupdate" id="myformoppoupdate"> 
                                   
                    <div class="uk-overflow-container">
                    
                                       
                   <div name="myformoppoparty" id="myformoppoparty">
                   
                   
                   <table id="myTableDataoppoparty" class="" style="margin-top:10px; border-color:#CCCCCC;" border="1" cellspacing="0">
                     <tr>
                     <td><input class="md-input" tabindex="36" type="text" name="Addclientoppoparty" id="Addclientoppoparty" placeholder="Enter Opposite Party here"></td>
                   
                   <td>
          <input class="md-btn md-btn-flat md-btn-flat-danger" name="addoppoparty" id="addoppoparty" tabindex="37" type="button"  value="Add Oppo Party" onclick="javascript: return addRowoppoparty()">
                     
                        </td> 
                      </tr>
                                       
                       <tr>                       
                        <td width="370"><b>Opposite Party</b></td>
                         <td width="80"><b>Action</b></td>
                       </tr>
                       </table>
                                         
                       </div>
                       
                    <!--   <div id="myDynamicTable">
                       <input type="button" id="create" value="Click here" onclick="javascript:addTable()"  />
                       to create a Table and add some data using javascript
                       </div>-->
                                                                  
                       </div>
                       
                   </div>
                </div>  <!--mytableoppoparty ends here -->
                    
        </div>
        </div>        
                                     
  </div>        


<!-- end of new md cards for other parties and other oppo parties--->

                     <script>
											
                    function addRow() {
					 var myName=document.getElementById("Addclient");
					 var table=document.getElementById("myTableData");
					 var rowCount=table.rows.length;
					 var row=table.insertRow(rowCount);
															 
					/*  var jsarray= ["dinesh","anand","ram","rupesh","Raghu"];
										
					 myName.value=jsarray;	*/				
										
					/*row.insertCell(0).innerHTML='<input type="button" value="DELETE" onClick="Javascript:deleteRow(this)">';
	row.insertCell(1).innerHTML="<input type='text' name='Addname[]' id='Addname'" + counter + "' value='" + myName.value + "'>";*/
	
	
	if($("#Addclient").val()==0)
  {
  alert("Please Enter Client Name!!");
  
  return false;
  } else{  
	
	row.insertCell(0).innerHTML= myName.value;
	row.insertCell(1).innerHTML='<input type="button" class="md-btn md-btn-flat md-btn-flat-danger" style="width:170px" value="DELETE" onClick="Javascript:deleteRow(this)">';
	//row.insertCell(1).innerHTML="<input type='text' name='clientnew' id='clientnew' class='md-input' value='" + myName.value + "'>";	
	
					/*var tbody = table.tBodies[0]; // First <tbody>; may be implicitly created
						var rows = tbody.getElementsByTagName("tr"); // All rows in the tbody
						rows = Array.prototype.slice.call(rows,0); // Snapshot in a true array
						// Now sort the rows based on the text in the nth <td> element
						rows.sort(function(row1,row2) {
						var cell1 = row1.getElementsByTagName("td")[n]; // Get nth cell
						var cell2 = row2.getElementsByTagName("td")[n]; // of both rows
						var val1 = cell1.textContent || cell1.innerText; // Get text content
						var val2 = cell2.textContent || cell2.innerText; // of the two cells
						if (comparator) return comparator(val1, val2); // Compare them!
						if (val1 < val2) return -1;
						else if (val1 > val2) return 1;
						else return 0;
					
					var x=selCol();
					
					alert(x);*/
										   
					  // alert(myName.value);
										
					 myName.value=null;	
			}		
					}
					
					
					function deleteRow(obj) {
					
					var index=obj.parentNode.parentNode.rowIndex;
					var table=document.getElementById("myTableData");
					table.deleteRow(index);	
					
					//alert(index);					
					
					}					
					
					/*function addTable() {
					
					var myTableDiv=document.getElementById("myDynamicTable");
					var table=document.createElement('TABLE');
					table.border='1';
					
					var tableBody=document.createElement('TBODY');
					
					table.appendChild(tableBody);
					
					for(var i=0; i<3;i++){
					
					 var tr=document.createElement('TR');
					   tableBody.appendChild(tr);
					
					for(var j=0; j<4;j++){
					  var td=document.createElement('TD');
					  td.width='75';
					  td.appendChild(document.createTextNode("Cell" + i + "," + j));
					  tr.appendChild(td);
					     }
					  
					  }
					  
					  myTableDiv.appendChild(table);					
					
					} 
					*/						
					
					</script>


<!----- below is code for oppo party table to add and delete row     ---> 

   <script>											
                    function addRowoppoparty() {
					 var myName=document.getElementById("Addclientoppoparty");
					 var table=document.getElementById("myTableDataoppoparty");
					 var rowCount=table.rows.length;
					 var row=table.insertRow(rowCount);
			
	
	if($("#Addclientoppoparty").val()==0)
  {
  alert("Please Enter Opposite Party Name!!");
  
  return false;
  } else{
  
	
	row.insertCell(0).innerHTML= myName.value;
	row.insertCell(1).innerHTML='<input type="button" class="md-btn md-btn-flat md-btn-flat-danger" style="width:170px" value="DELETE" onClick="Javascript:deleteRowoppoparty(this)">';
	//row.insertCell(1).innerHTML="<input type='text' name='clientnew' id='clientnew' class='md-input' value='" + myName.value + "'>";	
	
										
					 myName.value=null;	
			}		
					}
					
					
					function deleteRowoppoparty(obj) {
					
					var index=obj.parentNode.parentNode.rowIndex;
					var table=document.getElementById("myTableDataoppoparty");
					table.deleteRow(index);	
					
					//alert(index);				
					
					}
		
					</script>
                    <br />
       

       <div class="md-fab-wrapper">
        <a class="md-fab md-fab-danger" href="#mailbox_new_message" data-uk-modal="{center:true}">
            <i class="material-icons">&#xE8F4;</i>
        </a>
    </div>
    
    <div class="uk-modal" id="mailbox_new_message" >
        <div class="uk-modal-dialog" style="z-index:auto; width:1300px; margin-top:10px">
            <button class="uk-modal-close uk-close" type="button"></button>
                <div class="uk-modal-header">
                    <h3 class="uk-modal-title">Preview of Last 10 NEW Cases Entered</h3>
                </div>
                <div class="uk-margin-medium-bottom">
                
                <?php
            $sql = 'SELECT lw_cases.id,
	        lw_cases.brief_file,
			lw_cases.notice_no,
			lw_cases.party,
			lw_cases.oppoparty,
			lw_cases.courtcaseno,
			lw_cases.courtid,
			lw_cases.stage,
			lw_cases.opendt			
			FROM lw_cases ORDER BY lw_cases.id DESC LIMIT 10';
	$StatementResults=DB_query($sql,$db);
	
	echo '<table class="uk-table">';   

	$TableHeader = "<tr bgcolor='#82A2C6'>
	
			<th>" . _('ID') . "</th>
			<th>" . _('Brief_File') . "</th>
			<th>" . _('Court Case No') . "</th>
			<th>" . _('Notice No') . "</th>
			<th>" . _('Party Name') . "</th>
			<th>" . _('Oppo Party') . "</th>			
			<th>" . _('Court Name') . "</th>
			<th>" . _('Stage') . "</th>
			<th>" . _('Open Date') . "</th>
			</tr>";

	echo $TableHeader;	
		
	while($Contacts=DB_fetch_array($StatementResults))
	{
	
	 $resultparty=DB_query("SELECT name FROM lw_contacts WHERE lw_contacts.id='" . $Contacts['party'] . "'",$db);	
				$myrowparty=DB_fetch_array($resultparty);
	  
	  $resultoppoparty=DB_query("SELECT name FROM lw_contacts WHERE lw_contacts.id='" . $Contacts['oppoparty'] . "'",$db);	
				$myrowoppoparty=DB_fetch_array($resultoppoparty);
			
	$resultstage=DB_query("SELECT stage FROM lw_stages WHERE lw_stages.stageid='" . $Contacts['stage'] . "'",$db);
			$myrowstage=DB_fetch_array($resultstage);
	
      $resultcourt=DB_query("SELECT courtname FROM lw_courts WHERE lw_courts.courtid='" . $Contacts['courtid'] . "'",$db);		
			$myrowcourt=DB_fetch_array($resultcourt);			
	
	if($Contacts['opendt']!="")
	{
	$Contacts['opendt']=ConvertSQLDate($Contacts['opendt']);
	}
	
	else	
	{
	$Contacts['opendt']=$Contacts['opendt'];
	}
		
		printf("<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			</tr>",
			$Contacts['id'],
			$Contacts['brief_file'],
			$Contacts['courtcaseno'],
			$Contacts['notice_no'],
			$myrowparty['name'],
			$myrowoppoparty['name'],
			$myrowcourt['courtname'],
			$myrowstage['stage'],
			$Contacts['opendt']			
			);	  
	  }
	
	?>
        </div>
    </div>
    </div>            
         
<?php    	

} //end of insert mode

else if(!empty($myrowparty))
 {

//case exists - either passed when calling the form or from the form itself- ie Update mode, form fields will populate with table values
  
	echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . '?' . SID ."'>";			
				
				if(empty($myrowparty['opendt']) AND empty($myrowparty['closedt']))
					{ 
					//echo 'reaching both dates empty';
					
					 $opendateupdate=$myrowparty['opendt']="";
					 $closedateupdate=$myrowparty['closedt']="";
					
					 }
					 else if(!empty($myrowparty['opendt']) AND !empty($myrowparty['closedt']))
					 {
					 
					 //echo 'reaching both dates Filled';
					 
					 $opendateupdate=ConvertSQLDate($myrowparty['opendt']);
					 $closedateupdate=ConvertSQLDate($myrowparty['closedt']);					 					
					
					 }
					  else if(!empty($myrowparty['opendt']) AND empty($myrowparty['closedt']))
					 {
					 
					 //echo 'reaching open date not empty but close date empty';
					
					$opendateupdate=ConvertSQLDate($myrowparty['opendt']);
					$closedateupdate=$myrowparty['closedt']="";
					
				
					}else if(empty($myrowparty['opendt']) AND !empty($myrowparty['closedt']))
					 {
					 
					  //echo 'reaching open date empty but close date not empty';
					  
					 $opendateupdate=$myrowparty['opendt']="";
					 $closedateupdate=ConvertSQLDate($myrowparty['closedt']);
					
				}						
					
					if(empty($myrowparty['firdate']))
					{ 
					
					 $firdateupdate=$myrowparty['firdate']="";
									 }
					 else 
					 {
					 $firdateupdate=ConvertSQLDate($myrowparty['firdate']);
					}
					
							
				
					$_POST['ID']=$myrowparty['id'];
					$_POST['Brief_Fileupdate']=$myrowparty['brief_file'];    
					$_POST['Notice_noupdate']=$myrowparty['notice_no'];
					$_POST['Govt_dept_noupdate']=$myrowparty['govt_dept_no'];
					$_POST['Clientcatidupdate']=$myrowparty['clientcatid'];
					$_POST['Casecatidupdate']=$myrowparty['casecatid'];					
					$_POST['Stageupdate']=$myrowparty['stage'];
					$_POST['Remarkupdate']=$myrowparty['remark'];
					$_POST['Courtcasenoupdate']=$myrowparty['courtcaseno'];
					$_POST['Courtidupdate']=$myrowparty['courtid'];
					$_POST['Casepartyid']=$myrowparty['party'];
					$_POST['Caseoppopartyid']=$myrowparty['oppoparty'];
					$_POST['Counselpartyupdate']=$myrowparty['counselparty'];
					$_POST['Counseloppopartyupdate']=$myrowparty['counseloppoparty'];
					$_POST['Partyroleupdate']=$myrowparty['partyrole'];
		 			$_POST['Oppopartyroleupdate']=$myrowparty['oppopartyrole'];
					
					$_POST['FIRnumberupdate']=$myrowparty['firnumber'];
							
					$_POST['FIRtimeupdate']=$myrowparty['firtime'];
					$_POST['Policestationupdate']=$myrowparty['policestation'];
					$_POST['Casehistoryid']=$myrowparty['casehistoryid'];
					
					$_POST['Judgenameupdate']=$myrowparty['judgename'];
					$_POST['Cnrupdate']=$myrowparty['cnrnumber'];
														
								 								
				
									//UPDATE MODE starts here
	   echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . '?' . SID ."'>";
	  
	   
	  
	   
	   ?>
<h3 class="heading_a">UPDATE MODE </h3> <div style="color:#CCCCCC"></div>
   <div class="uk-width-medium-1-1" style="padding-bottom:0px">
        <div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">
         
        <div class="uk-grid" data-uk-grid-margin style="color:#666666">
        <div class="uk-width-medium-2-2">
        <div class="uk-form-row">
        <div class="uk-grid">
                       
		
       
	<?php    
 
		 
	 
		echo '<div class="uk-width-medium-1-4" style="padding-top:20px">';
		echo 'Brief_file No.: '; 
		
		echo '<input tabindex="1" type="Text" name="Brief_Fileupdate" id="Brief_Fileupdate" value="' . $_POST['Brief_Fileupdate'] . '" class="md-input" data-uk-tooltip="{cls:\'long-text\'}" ></div>';
	
       echo '<input type="hidden" name="Brief_Filebeforechange" id="Brief_Filebeforechange" value="' . $_POST['Brief_Fileupdate'] . '">';
    
		echo '<input type="hidden" name="ID" id="ID" value="' . $_POST['ID'] . '">';
		   
       
		echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px; padding-top:20px">Case No <input tabindex="2" type="Text" name="Courtcasenoupdate" id="Courtcasenoupdate" value="' . $_POST['Courtcasenoupdate'] . '" class="md-input" ></div>';
		
	echo '<input type="hidden" name="Courtcasenobeforeupdate" id="Courtcasenobeforeupdate" value="' . $_POST['Courtcasenoupdate'] . '">';	
	
	/* echo '<div class="uk-width-medium-1-4" style="padding-top:30px"><input type="radio" name="Caseno_Radio" id="Casenochange_Radio" value=0>Correction in case no</div>';
         echo '<div class="uk-width-medium-1-4" style="padding-top:30px"><input type="radio" name="Caseno_Radio" id="Casenonew_Radio" value=1>New case no</div>';	 */
		
	   
		
				 $result=DB_query('SELECT casecatid, casecat FROM lw_casecat',$db); ?>
				
			<div class="uk-width-medium-1-4" style="padding-top:20px">Case Type
            
            
					<select name="Casecatidupdate" id="Casecatidupdate" tabindex="3" class="md-input">
					<?php
				while ($myrow = DB_fetch_array($result)) {
			
					if ($_POST['Casecatidupdate']==$myrow['casecatid']){
						echo '<option selected VALUE='. $myrow['casecatid'] . '>' . $myrow['casecat'];
					} else {
						echo '<option VALUE='. $myrow['casecatid'] . '>' . $myrow['casecat'];
					}
			
				} //end while loop
				DB_data_seek($result,0);
			        echo '</select></div>';
		
						
		$sqlnotice='SELECT notice_no from lw_noticecr WHERE noticeid="' .trim($_POST['Notice_noupdate']). '"';
  $resultnotice=DB_query($sqlnotice,$db);
  
  $myrownotice=DB_fetch_array($resultnotice);
  
  if(empty($_POST['Notice_noupdate']))
  {
  $sqlnoticearray='SELECT noticeid,notice_no from lw_noticecr WHERE allocated!=1';
  $resultnoticearray=DB_query($sqlnoticearray,$db);
  
  }
  
  
  
  ?>
  
               <div class="uk-width-medium-1-4" style="padding-top:20px">Notice No
               <?php
			   
               
               if(!empty($_POST['Notice_noupdate']))
               {
              echo '<input list="Notice_noupdate1" name="Notice_noupdate" class="md-input" value="' . $myrownotice[0] . '" readonly>';
               
               }else
               {
              echo '<input list="Notice_noupdate1" name="Notice_noupdate" class="md-input">';           
               }
			   
                ?>
              
                <datalist name="Notice_noupdate1" id="Notice_noupdate1" style="overflow:visible">
    <?php
	
	
	
	
	while ($myrownoticearray = DB_fetch_array($resultnoticearray)) {
	  {
	  echo '<option VALUE="' . $myrownoticearray['notice_no'] . '">' . $myrownoticearray['notice_no'] . '</option>';
	  }	
			
	} //end while loop</tr>
	DB_data_seek($resultnoticearray,0);
        echo '</datalist></div>';
		
	echo '<input type="hidden" name="Notice_no_id_update" id="Notice_no_id_update" value="' . $_POST['Notice_noupdate'] . '">';		
		
			 		
			
			echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px ">';
    		echo 'Date<input class="md-input" type="text" name="Opendateupdate" id="Opendateupdate" value="' . $opendateupdate . '" tabindex="5" data-uk-datepicker="{format:\'DD/MM/YYYY\'}"></div>';
					
		echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px">';
		
		echo 'Government Dept. No. : <input tabindex="6" type="Text" name="Govt_dept_noupdate" id="Govt_dept_noupdate" value="' . $_POST['Govt_dept_noupdate'] . '" class="md-input" ></div>';
		
			 echo'<div class="uk-width-medium-1-4" style="padding-bottom:10px">Judge Name
      <input tabindex="6" type="Text" name="Judgenameupdate" id="Judgenameupdate" class="md-input" value="' . $_POST['Judgenameupdate'] . '" ></div> ';  
		
		echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px">Designation/Court';
							
					$result=DB_query("SELECT courtid,courtname FROM lw_courts ORDER BY courtid ASC",$db);	
			echo '<select id="Courtidupdate" name="Courtidupdate" class="md-input" tabindex="7">';
					
			while ($myrow = DB_fetch_array($result)) {
				if ($_POST['Courtidupdate']==$myrow['courtid']){
					echo '<option selected VALUE='. $myrow['courtid'] . '>' . $myrow['courtname'];
				} else {
					echo '<option VALUE='. $myrow['courtid'] . '>' . $myrow['courtname'];
				}
				} //end while loop
			
			DB_free_result($result);
			
			echo '</select></div>';

				echo '<div class="uk-width-medium-2-4" style="padding-bottom:10px">Stage';
				$result=DB_query('SELECT stageid, stage FROM lw_stages',$db);
				echo '<select id="Stageupdate" name="Stageupdate" class="md-input" tabindex="8">';
					
				while ($myrow = DB_fetch_array($result)) {
				if ($_POST['Stageupdate']==$myrow['stageid']){
					echo '<option selected VALUE='. $myrow['stageid'] . '>' . $myrow['stage'];
				} else {
					echo '<option VALUE='. $myrow['stageid'] . '>' . $myrow['stage'];
				}
				} //end while loop
			
			DB_free_result($result);
			
			echo '</select></div>'; 						 
			     
				 
				 $result=DB_query("SELECT clientcatid, category FROM lw_clientcat",$db);
			
			echo '<div class="uk-width-medium-2-4" style="padding-bottom:10px">Client Category';
			echo '<select tabindex="9" name="Clientcatidupdate" id="Clientcatidupdate" class="md-input">';
			
			while ($myrow = DB_fetch_array($result)) { 
				if ($_POST['Clientcatidupdate']==$myrow['clientcatid']){
					echo "<option selected VALUE='". $myrow['clientcatid'] . "'>" . $myrow['category'];
				} else {
					echo "<option VALUE='". $myrow['clientcatid'] . "'>" . $myrow['category'];
				}
			} //end while loop
			
			DB_free_result($result);
			
			
			echo '</select></div>';				          
					
			
								
				/* echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px">
			        Closing Date<input class="md-input" tabindex="10" type="text" id="Closedateupdate" name="Closedateupdate" value="' . $closedateupdate . '" data-uk-datepicker="{format:\'DD/MM/YYYY\'}"></div>';*/
								  
				
					
		      ?>                   
                  
                    <div class="uk-width-medium-1-4" style="padding-bottom:10px">FIR Number
         <input tabindex="11" type="Text" name="FIRnumberupdate" id="FIRnumberupdate" class="md-input" data-uk-tooltip="{pos:'bottom'}" title="Only for criminal case" value="<?php echo $_POST['FIRnumberupdate']; ?> "></div>	
         	             
                           <div class="uk-width-medium-1-4" style="padding-bottom:10px">FIR Date    
   <input class="md-input" type="text" tabindex="12" name="FIRdateupdate" id="FIRdateupdate"  data-uk-tooltip="{pos:'bottom'}" title="Only for criminal case"  value="<?php echo $firdateupdate; ?> "data-uk-datepicker="{format:'DD/MM/YYYY'}" >
</div>
 <div class="uk-width-medium-1-4" style="padding-bottom:10px">FIR Time
   <input class="md-input" type="text" tabindex="13" name="FIRtimeupdate" id="FIRtimeupdate"  data-uk-tooltip="{pos:'bottom'}" title="Only for criminal case"  value="<?php echo $_POST['FIRtimeupdate']; ?> " data-uk-timepicker="" autocomplete="off" >
</div>
  <div class="uk-width-medium-1-4" style="padding-bottom:10px">Police Station    
   <input class="md-input" type="text" tabindex="14" name="Policestationupdate"  id="Policestationupdate"  data-uk-tooltip="{pos:'bottom'}" title="Only for criminal case" value="<?php echo $_POST['Policestationupdate']; ?> ">
</div> 

 <?php  echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">CNR No';
			         echo '<input tabindex="15" type="Text" name="Cnrupdate" id="Cnrupdate" style="background-color:#CCFFFF" placeholder="Enter CNR No. here e.g. MHAU019999992018"  value="' . $_POST['Cnrupdate'] . '" class="md-input"  ></div>';
					 
                  echo '<div class="uk-width-medium-1-1" style="padding-bottom:10px">Narration';
			         echo '<input tabindex="15" type="Text" name="Remarkupdate" id="Remarkupdate"  data-uk-tooltip="{pos:\'bottom\'}" title="Enter extra information here"  value="' . $_POST['Remarkupdate'] . '" class="md-input"  ></div>';?>
                   </div><!-- End of md-input-wrapper -->
			         
			         					</div>
			           			 </div>      
			                </div>
			            </div>
			         </div>
			           			   
			                </div>
			            </div>     
			             
			       <?php   
				   
				   
				$sqlcontactname="SELECT name,address,mobile FROM lw_contacts WHERE lw_contacts.id='" . $_POST['Casepartyid'] . "'";
					
				$resultcontactname=DB_query($sqlcontactname,$db);
					
				$myrowcontactpartyname=DB_fetch_array($resultcontactname);	
				
				
				$lastclientname=strtoupper(trim($myrowcontactpartyname[0]));
        					
			//Create a directory in the name of the Party in cases folder
						
			chmod($_SERVER['DOCUMENT_ROOT'].'/lawpract/cases/',0750);
			
			if(!file_exists("cases/lpt_".$lastclientname))
			{			
			$dirname="lpt_".$lastclientname;
			}	   
		
		 $result = DB_query($sql,$db);
		 
		
		 
			         //New md-card for party and oppo party
			echo '<div class="md-input-wrapper"><div class="md-card"><div class="md-card-content">';
			
			echo '<div class="uk-width-medium-1-1" style="padding-bottom:0px">';
			echo '<div class="uk-grid uk-grid-width-1-2 uk-grid-width-large-1-2">';		
			  
			echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px"><label>Party Name:</label>';
			echo '<input class="md-input" tabindex="16" type="text" name="Casepartynameupdate" id="Casepartynameupdate"  data-uk-tooltip="{cls:\'long-text\'}" title="Name can be edited here but cannot select new name from addressbook"  value="' . $myrowcontactpartyname[0] . '" >';	
			
			echo '<input type="hidden" name="Casepartyid" id="Casepartyid" value="' . $_POST['Casepartyid'] . '" >';	
			
			echo '</div>';			
					  
			 echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px"><label>Opposition Party Name:</label>';
			 
			 $sqlcontactname="SELECT name,address,mobile FROM lw_contacts WHERE lw_contacts.id='" . $_POST['Caseoppopartyid'] . "'";
					
				$resultcontactname=DB_query($sqlcontactname,$db);
					
				$myrowcontactoppopartyname=DB_fetch_array($resultcontactname);				
			
			
			echo '<input class="md-input" tabindex="17" type="text" name="Caseoppopartynameupdate" id="Caseoppopartynameupdate"  data-uk-tooltip="{cls:\'long-text\'}" title="Name can be edited here but cannot select new name from addressbook" value="' . $myrowcontactoppopartyname[0] . '">';		
			
			echo '<input type="hidden" name="Caseoppopartyid" id="Caseoppopartyid" value="' . $_POST['Caseoppopartyid'] . '" >';
			echo '</div>';			
		  	  
			$result=DB_query("SELECT roleid, role FROM lw_partiesinvolved",$db);
			
			echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px"><label>Role Party</label>';
			echo '<select tabindex="18" name="Partyroleupdate" id="Partyroleupdate" class="md-input">';
			
			while ($myrow = DB_fetch_array($result)) {
				if ($_POST['Partyroleupdate']==$myrow['roleid']){
					echo '<option selected VALUE='. $myrow['roleid'] . '>' . $myrow['role'];
				} else {
					echo '<option VALUE="' . $myrow['roleid'] . '">' . $myrow['role'] . '</option>';
				
				}
				
				} //end while loop
			
			DB_free_result($result);
			
			echo '</select></div>';
							
			echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px"><label>Address Party</label>';
			echo '<input class="md-input" tabindex="19" type="text"  name="Addressupdate" id="Addressupdate" value="' . $myrowcontactpartyname[1] . '" /></div>';
			    
			$resultoppo=DB_query("SELECT roleid, role FROM lw_partiesinvolved",$db);
					           	
			echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px"><label>Role Oppo Party</label>';
			echo '<select tabindex="20" name="Oppopartyroleupdate" id="Oppopartyroleupdate" class="md-input">';
			
			while ($myrowoppo = DB_fetch_array($resultoppo)) {
				if ($_POST['Oppopartyroleupdate']==$myrowoppo['roleid']){
					echo '<option selected VALUE='. $myrowoppo['roleid'] . '>' . $myrowoppo['role'];
				} else {
					echo '<option VALUE="' . $myrowoppo['roleid'] . '">' . $myrowoppo['role'] . '</option>';
				
				}
			} //end while loop
			
			DB_free_result($resultoppo);
			
			echo '</select></div>'; 
			?>
		
			       <div class="uk-width-medium-1-4" style="padding-bottom:10px">
			                                        <label>Address Oppo Party</label>
			                                        <input class="md-input" tabindex="21" type="text" name="Addressoppoupdate" id="Addressoppoupdate"  value="<?php echo $myrowcontactoppopartyname[1]; ?>" />
			             </div> 
			         <div class="uk-width-medium-1-4" style="padding-bottom:10px">
			                                        <label>Mobile Party</label>
			                                        <input class="md-input" tabindex="22" type="text" name="Mobileupdate" id="Mobileupdate" value="<?php echo $myrowcontactpartyname[2]; ?>" />
			                                    </div>
                                                 <div class="uk-width-medium-1-4" style="padding-bottom:10px">
			                                        <label>Appearing Lawyer</label>
			                                        <input class="md-input" tabindex="23" type="text" name="Counselpartyupdate" id="Counselpartyupdate" value="<?php echo $_POST['Counselpartyupdate']; ?>" />
			                                    </div>
			        
			        <div class="uk-width-medium-1-4" style="padding-bottom:10px">
			                                        <label>Mobile Oppo</label>
			                                        <input class="md-input" tabindex="24" type="text" name="Mobileoppoupdate" id="Mobileoppoupdate"  value="<?php echo $myrowcontactoppopartyname[2]; ?>" />
			                                    </div>
			                                    
			                                   
			                 <div class="uk-width-medium-1-4" style="padding-bottom:10px">
			                                        <label>Oppo Party Lawyer</label>
			                                        <input class="md-input" tabindex="25" type="text" name="Counseloppopartyupdate" id="Counseloppopartyupdate"  value="<?php echo $_POST['Counseloppopartyupdate']; ?>" />
			                                    </div>                    
			       
                                 <!--end of md-input-wrapper -->
			                              
            <script> 

             var di=<?php echo json_encode($dirname); ?>;
			  
			</script>
            
				<?php   
			echo '<div class="uk-width-medium-1-1" style="padding-bottom:10px">';
				
			echo "<input type='Submit' name='Submit' class='md-btn md-btn-primary' tabindex='26' VALUE='" . _('Update') . "' onClick='checkvalidityupdate()' >";
				
			/*echo '<input type="Submit" name="DeletePermanent" id="DeletePermanent" class="md-btn md-btn-flat md-btn-flat-danger" tabindex="27" VALUE="' . _('Delete Case Permanently') . '" onClick=\'return checkdelete()\'>';
			*/
			echo '</div><br>';
			
			$client_name=trim($myrowcontactpartyname[0]);

			chmod($_SERVER['DOCUMENT_ROOT'].'/lawpract/contactimages/',0750);
							
			$filename=trim(str_replace(" ","",$client_name));
			
			?>   
            
             <div class="uk-width-medium-1-2" style="padding-top:10px"> 
                        <span class="menu_icon"><i class="material-icons md-color-green-500">&#xE03B;</i></span>
                        <span class="menu_title" style="text-decoration:underline; cursor:pointer" onclick="javascript:MM_openbrwindow('lw_citations_alt.php',600,400);">Create Citation</span>
                    </div>
             
                <div class="uk-width-medium-1-2" style="padding-top:10px"> 
                        <span class="menu_icon"><i class="material-icons md-color-green-500">&#xE03B;</i></span>
                        <span class="menu_title" style="text-decoration:underline; cursor:pointer" onclick="javascript:MM_openbrwindow('lw_judgement_alt.php',600,400);">Create Judgement</span>
                    </div>
</div></div>

<script>
function MM_openbrwindow(x,width,height,brief_file=$("#Brief_Fileupdate").val()){
var smswindow=window.open(x + '?brief_file=' + brief_file,'popup','width=' + width + ',height=' + height + ',scrollbars=0,resizable=no,toolbar=no,directories=no,location=no,menubar=no,status=no,left=180,top=30');
}


</script>
	
      
		
           			     
                </div>
            </div>
            
            </div><!-- end of md-input-wrapper -->  
          
            <!-- New md-card for case close -->
              <?php
			echo '<div class="md-input-wrapper"><div class="md-card"><div class="md-card-content">';
			
			echo '<div class="uk-width-medium-1-1" style="padding-bottom:0px">';
			echo '<div class="uk-grid uk-grid-width-1-1 uk-grid-width-large-1-1">';		
			
			echo '<input type="hidden"  name="Casehistoryid" id="Casehistoryid" value="' . $_POST['Casehistoryid'] . '" />';
			  
			?>	
           
            
             
            
            
    	 	 <div class="uk-grid uk-grid-medium data-uk-grid-margin">
                <div class="uk-width-medium-2-6 uk-width-medium-2-6">
                   <div class="md-input-wrapper"> <div class="md-card" style="overflow:auto">
                        <div  class="md-card-content"> <div class="uk-grid uk-grid-width-1-2 uk-grid-width-large-1-2">		
                         <div class="uk-width-medium-1-1" style="padding-bottom:10px">Close Case
    
    <input type="checkbox" name="Closecase" id="Closecase" tabindex="11">
    		</div>		
			
			<?php 
			
			
			echo '<div class="uk-width-medium-2-4" style="padding-bottom:10px"><label>Coram</label>';
			echo '<input class="md-input" tabindex="20" type="text"  name="Coram" id="Coram" /></div>';
			    ?>
	<div class="uk-width-medium-2-4" style="padding-bottom:10px">Close Date
    
    <input class="md-input" type="text" name="Closedateupdate" id="Closedateupdate" tabindex="11" data-uk-datepicker="{format:'DD/MM/YYYY'}" >
    </div>
    			
		<?php			    
			$resultcaseclose=DB_query("SELECT id, result FROM lw_casecloseresult",$db);
					           	
			echo '<div class="uk-width-medium-2-4" style="padding-bottom:10px"><label>Result</label>';
			echo '<select tabindex="19" name="Result" id="Result" class="md-input">';
			
			while ($myrowcaseclose = DB_fetch_array($resultcaseclose)) {
					echo '<option VALUE="' . $myrowcaseclose['id'] . '">' . $myrowcaseclose['result'] . '</option>';
					} //end while loop
			
			DB_free_result($resultcaseclose);
			
			echo '</select></div>'; ?>
		
		<div class="uk-width-medium-2-4" style="padding-bottom:10px">
			                                        <label>Remark</label>
		<input class="md-input" tabindex="23" type="text" name="Casecloseremark" id="Casecloseremark" />
			                                    </div>
             <div class="uk-width-medium-1-1" style="padding-bottom:10px">
			  <label>Judgement/Order</label>
              <input class="md-input" type="text" name="Judgementorder" id="Judgementorder">
			   </div> 

         </div></div></div></div>
         
         </div>
         
          <div class="uk-width-medium-2-6 uk-width-medium-2-6">
          
            <div class="md-card" style="overflow:auto">
                        <div class="md-card-content">
                        <h3> Details for Changed Case no</h3>
        <div class="uk-grid uk-grid-width-1-2 uk-grid-width-large-1-2">
        
        <div class="uk-width-medium-1-2" ><label>Old Case No</label></div>
		 <div class="uk-width-medium-1-2"><input class="md-input" type="text" name="Oldcaseno" id="Oldcaseno" value="<?php echo $_POST['Courtcasenoupdate']; ?>" readonly/>
			                                    </div>
         
        <div class="uk-width-medium-1-1"><label>Reason for Change</label>
		<input class="md-input" tabindex="23" type="text" name="casenoremark" id="casenoremark" />
		</div>
                                   
           <div class="uk-width-medium-1-2" style="padding-top:10px"> <label>View Details</label>
        <a  href="#mailbox_old_courtcaseno" data-uk-modal="{center:true}"><i class="material-icons">&#xE8F4;</i></a>
        </div>  
     
		</div></div></div></div>
        
      
                    
            <div class="uk-width-medium-2-6 uk-width-medium-2-6">
          
            <div class="md-card" style="overflow:auto">
                        <div class="md-card-content">
                        <h3> Details for Changed Judge name</h3>
        <div class="uk-grid uk-grid-width-1-2 uk-grid-width-large-1-2">
        <div class="uk-width-medium-1-2" style="padding-bottom:10px"><label>Old Judge name</label></div>
		 <div class="uk-width-medium-1-2" style="padding-bottom:10px"><input class="md-input" type="text" name="Oldjudgename" id="Oldjudgename" value="<?php echo $_POST['Judgenameupdate']; ?>" readonly/>
		</div>
        <div class="uk-width-medium-1-1" style="padding-bottom:15px; padding-top:10px"><label>Reason for Change</label>
		<input class="md-input" tabindex="23" type="text" name="Judgeremarkupdate" id="Judgeremarkupdate" />
		</div> 
                                  
            <div class="uk-width-medium-1-2" style="padding-bottom:10px"> <label>View Details</label>
         <a  href="#mailbox_old_judgename" data-uk-modal="{center:true}"><i class="material-icons">&#xE8F4;</i></a>
         </div>
          
		</div></div></div></div>
</div>
                                                
                
                             
</div></div>
		     
            </div>
            </div>
            
            </div>
            
        <div class="uk-modal" id="mailbox_old_courtcaseno" >
        <div class="uk-modal-dialog" style="overflow:auto">
            <button class="uk-modal-close uk-close" type="button"></button>
                <div class="uk-modal-header uk-margin-medium-bottom">
                    <h3 class="uk-modal-title">Old case no with remarks</h3>
                </div>
                <div class="uk-margin-medium-bottom">
                
                <?php
            $sql = "SELECT * FROM lw_casenohistory WHERE brief_file='" . $_POST['Brief_Fileupdate'] . "'";
	$StatementResults=DB_query($sql,$db);
	
	echo '<table class="uk-table">';
   

	$TableHeader = "<tr bgcolor='#82A2C6'>
	
			<th>" . _('ID') . "</th>
			<th>" . _('Brief_File') . "</th>
			<th>" . _('Date') . "</th>
			<th>" . _('Old Case No') . "</th>
			<th>" . _('Remark') . "</th>
			</tr>";

	echo $TableHeader;
	
		
	while($Casenos=DB_fetch_array($StatementResults))
	{
						
	if($Casenos['casenodate']!="")
	{
	$Casenos['casenodate']=ConvertSQLDate($Casenos['casenodate']);
	}
	
	else	
	{
	$Casenos['casenodate']=$Casenos['casenodate'];
	}
		
		printf("<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			
			</tr>",
			$Casenos['id'],
			$Casenos['brief_file'],
			$Casenos['casenodate'],
			$Casenos['oldcourtcaseno'],
			$Casenos['casenoremark']			
			);
	  
	  }
	echo '</table>';
	?>
        </div>
    </div>
    </div> 
    <br />
              <div class="uk-modal" id="mailbox_old_judgename" >
        <div class="uk-modal-dialog" style="overflow:auto">
            <button class="uk-modal-close uk-close" type="button"></button>
                <div class="uk-modal-header uk-margin-medium-bottom">
                    <h3 class="uk-modal-title">Old Judge name with remarks</h3>
                </div>
                <div class="uk-margin-medium-bottom">
                
                <?php
            $sqljudge = "SELECT * FROM lw_judgehistory WHERE brief_file='" . $_POST['Brief_Fileupdate'] . "'";
	$StatementResultsjudge=DB_query($sqljudge,$db);
	
	echo '<table class="uk-table">';
   

	$TableHeader = "<tr bgcolor='#82A2C6'>
	
			<th>" . _('ID') . "</th>
			<th>" . _('Brief_File') . "</th>
			<th>" . _('Date') . "</th>
			<th>" . _('Old Judge Name') . "</th>
			<th>" . _('Remark') . "</th>
			</tr>";

	echo $TableHeader;
	
		
	while($Judges=DB_fetch_array($StatementResultsjudge))
	{
						
	if($Judges['namechangedate']!="")
	{
	$Judges['namechangedate']=ConvertSQLDate($Judges['namechangedate']);
	}
	
	else	
	{
	$Judges['namechangedate']=$Judges['namechangedate'];
	}
		
		printf("<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			
			</tr>",
			$Judges['id'],
			$Judges['brief_file'],
			$Judges['namechangedate'],
			$Judges['oldjudgename'],
			$Judges['judgeremark']			
			);
	  
	  }
	echo '</table>';
	?>
        </div>
    </div>
    </div> 
            
               
            <!-- end of md-card for case closed -->            
           </form> 
            
            <div class="uk-grid uk-grid-medium data-uk-grid-margin">
                <div class="uk-width-medium-1-2 uk-width-medium-1-2">
                                  <div class="md-card" style="overflow:auto; height:300px">
                        <div  class="md-card-content">                       
                     
                        <h4 class="heading_c uk-margin-bottom" align="center"><b>Case Stage History</b></h4>
  <?php           
        $sql = "SELECT lw_trans.id,lw_trans.brief_file,lw_trans.courtcaseno,lw_stages.stage,lw_trans.nextcourtdate FROM lw_trans INNER JOIN lw_stages ON lw_trans.stage=lw_stages.stageid WHERE lw_trans.brief_file='". $_POST['Brief_Fileupdate'] ."' ORDER BY lw_trans.currtrandate ASC";
	
	$StatementResults=DB_query($sql,$db);	
	
	          echo '<table class="uk-table uk-table-condensed">';

	$TableHeader = "<thead><tr>
			<th>" . _('Id') . "</th>
			<th>" . _('Brief-File') . "</th>
			<th>" . _('Case No') . "</th>
			<th>" . _('Stage') . "</th>
			<th>" . _('Next Date') . "</th>
	</tr> </thead>";

	echo $TableHeader;

	$id=1;
	
	
	while($Stagehistory=DB_fetch_array($StatementResults))
	{
     
if($Stagehistory['nextcourtdate']!="")
	{
	$Stagehistory['nextcourtdate']=ConvertSQLDate($Stagehistory['nextcourtdate']);
	}
	
	else
	
	{
	$Stagehistory['nextcourtdate']=$Stagehistory['nextcourtdate'];
	}
		
		printf("<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>	
			<td>%s</td>	
			</tr>",
			$Stagehistory['id'],
			$Stagehistory['brief_file'],
			$Stagehistory['courtcaseno'],
			$Stagehistory['stage'],
			$Stagehistory['nextcourtdate']);			
			}
	 echo '</table>';
?>
                            
							

                        
                 </div>   
            </div>
            </div>
            
                        
             <div class="uk-width-medium-1-2 uk-width-medium-1-2">
             
                    <div class="md-card" style="overflow:auto; height:300px">
                        <div class="md-card-content">
                        
                            <h4 class="heading_c uk-margin-bottom" align="center"><b>Case Close/Re-open History</b></h4>
                           
                            <?php

 $sql = "SELECT lw_casehistory.id,
lw_casehistory.brief_file,
lw_casehistory.courtcaseno,
lw_casehistory.caseclosedate,
lw_casehistory.casereopendate,
lw_casehistory.result,
lw_casehistory.coram,
lw_casehistory.judgement,
lw_casehistory.remark,
lw_casecloseresult.result 
FROM lw_casehistory INNER JOIN lw_casecloseresult ON lw_casehistory.result=lw_casecloseresult.id WHERE lw_casehistory.brief_file='". $_POST['Brief_Fileupdate'] ."'";
	
	$StatementResults=DB_query($sql,$db);	
	
	          echo '<table class="uk-table uk-table-condensed">';

	$TableHeader = "<thead><tr>
			<th>" . _('Id') . "</th>
			<th>" . _('Brief-File') . "</th>
			<th>" . _('Case No') . "</th>
			<th>" . _('Close Date') . "</th>
			<th>" . _('Re-open Date') . "</th>
			<th>" . _('Result') . "</th>
			<th>" . _('Coram') . "</th>
			<th>" . _('Judgement') . "</th>
			<th>" . _('Remark') . "</th>
	</tr> </thead>";

	echo $TableHeader;

	$id=1;
	
	
	while($Closehistory=DB_fetch_array($StatementResults))
	{
     
if($Closehistory['caseclosedate']!="")
	{
	$Closehistory['caseclosedate']=ConvertSQLDate($Closehistory['caseclosedate']);
	}
	
	else
	
	{
	$Closehistory['caseclosedate']=$Closehistory['caseclosedate'];
	}
	
if($Closehistory['casereopendate']!="")
	{
	$Closehistory['casereopendate']=ConvertSQLDate($Closehistory['casereopendate']);
	}
	
	else
	
	{
	$Closehistory['casereopendate']=$Closehistory['casereopendate'];
	}
		
	

		printf("<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>	
			<td>%s</td>	
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>	
			<td>%s</td>	
			</tr>",
			$Closehistory['id'],
			$Closehistory['brief_file'],
			$Closehistory['courtcaseno'],
			$Closehistory['caseclosedate'],
			$Closehistory['casereopendate'],
			$Closehistory['result'],
			$Closehistory['coram'],
			$Closehistory['judgement'],
			$Closehistory['remark']);			
			}
	 echo '</table>';
?>
                            

                        </div>
                 </div>   
            </div>
         </div>
         
             <?php   
         //New md-card for Photo --- here starts  photo update mode
echo '<div class="md-input-wrapper"><div class="md-card"><div class="md-card-content">';

echo '<div class="uk-width-medium-1-1" style="padding-bottom:0px">';
echo '<div class="uk-grid uk-grid-width-1-2 uk-grid-width-large-1-2">';
 ?>
            
    <div class="uk-width-medium-1-4" style="padding-bottom:10px"><h4><b>Client's Photo section</b></h4></div>
<div class="uk-width-medium-1-4" style="padding-bottom:10px">
    <button class="md-btn md-btn-flat md-btn-flat-danger" onClick="startWebcam();" >Start WebCam</button></div>
  <div class="uk-width-medium-1-4" style="padding-bottom:10px">  <button class="md-btn md-btn-flat md-btn-flat-danger" onClick="stopWebcam();" >Stop WebCam</button></div>
<div class="uk-width-medium-1-4" style="padding-bottom:10px">    <button class="md-btn md-btn-flat md-btn-flat-danger" onClick="snapshot();" >Take Photo & Save</button> 
</div>
   
 
   
   	<div class="uk-width-medium-1-4"><b>Preview of Client</b><br><img name="client_photo_preview_update" id="client_photo_preview_update" src="<?php echo 'contactimages/'.$filename.'.png' ; ?>" width="150" height="150" alt="" /></div>

  
   <div class="uk-width-medium-1-4"><b>Live Video Stream</b><br><video onclick="snapshot(this);" width=150 height=150 id="video" controls autoplay></video></div>
   

  <div class="uk-width-medium-1-4"><form method="post" accept-charset="utf-8" name="form1"></div>
       
  <div class="uk-width-medium-1-4"> <canvas id="myCanvas" width="200" height="200"></canvas></div>
  
       <input name="hidden_data" id='hidden_data' type="hidden" />
       
       <input name="client_name" id='client_name' type="hidden" value="<?php echo trim($filename); ?>" />

 </form>

 <script>
  
         //--------------------
      // GET USER MEDIA CODE
      //--------------------
          navigator.getUserMedia = ( navigator.getUserMedia ||
                             navigator.webkitGetUserMedia ||
                             navigator.mozGetUserMedia ||
                             navigator.msGetUserMedia);

      var video;
      var webcamStream;

      function startWebcam() {
	  
	    if (navigator.getUserMedia) {
           navigator.getUserMedia (

              // constraints
              {
                 video: true,
                 audio: false
              },

              // successCallback
              function(localMediaStream) {
                  video = document.querySelector('video');
                 video.src = window.URL.createObjectURL(localMediaStream);
                 webcamStream = localMediaStream;
				 				 
              },
			  
			 // errorCallback
              function(err) {
                 console.log("The following error occured: " + err);
              }
           );
        } else {
           console.log("getUserMedia not supported");
        }  
      }

      function stopWebcam() {
      	  
	  var video = document.querySelector('video');
      video.pause();
	  video.src="";
	  webcamStream.getTracks()[0].stop();
	  //console.log("Vid off");
	   	  
  		}
		
      //---------------------
      // TAKE A SNAPSHOT CODE
      //---------------------
      var canvas, ctx;

      function init() {
        // Get the canvas and obtain a context for
        // drawing in it
        canvas = document.getElementById("myCanvas");
        ctx = canvas.getContext('2d');
		 }

      function snapshot() {
	  
	   if($("#client_name").val()=='')
	  {
	  
	  alert('Please select Party Name First. The photo is saved in "Contact Images folder /" as partyname.png');
	  
	  }else
	  {
         // Draws current image from the video element into the canvas
        ctx.drawImage(video, 0,0, canvas.width, canvas.height);
		
		    // var canvas = document.getElementById("canvas");
                var dataURL = canvas.toDataURL("image/png");
                document.getElementById('hidden_data').value = dataURL;
				
				//document.getElementById('client_name').value = 'dp';				
				
                var fd = new FormData(document.forms["form1"]);
 
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'upload_photo.php', true);
 
                xhr.upload.onprogress = function(e) {
                    if (e.lengthComputable) {
                        var percentComplete = (e.loaded / e.total) * 100;
                        console.log(percentComplete + '% uploaded');
                        alert('Succesfully uploaded');				
						
						var image = document.getElementById("client_photo_preview_update");
						
													  
//image.src="cases/lpt_"+$("#client_name").val()+"/"+$("#client_name").val() + ".png";

			var url = "contactimages/"+$("#client_name").val() + ".png";
     
			var image = document.getElementById("client_photo_preview_update");

 			var x=$("#client_name").val();  
            
            var f=x.replace(/ /g, "");
                        
            var url = 'contactimages/'+f+ '.png';
            
            jQuery('#client_photo_preview_update').attr('src', url);
	 	 

setTimeout(updateImage,3000);

 function updateImage() {
       image.src = image.src.split("?")[0] + "?" + new Date().getTime();
    }



                    }
                };
 
                xhr.onload = function() {
 
                };
                xhr.send(fd);
			
		//below is to clear canvas rectangle
		ctx.clearRect(0, 0, canvas.width, canvas.height);	
		
		
		//var image = document.createElement("img");
	//image.src = canvas.toDataURL('image/png');
  }
	
	}
		  
</script>
        </div>
      </div>  
      </div> 
      </div>
      </div>      
        
<!-- start of new md cards for other parties and oppo parties in update mode--->
     
             <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-medium-1-2">
                    <div class="md-card">
                        <div class="md-card-content" style="text-align:left; font-weight:bolder">
                        
                                   
                    <div class="uk-overflow-container">
                    
                     <div class="uk-width-medium-1-1" style="margin-left:0px"><i class="material-icons md-color-blue-800" style="font-size:30px;cursor: pointer; vertical-align:middle; padding-left:0px">group_add</i> &nbsp;&nbsp;<label>Add Other Party Names</label> 
        
    <div name="myformupdate" id="myformupdate">
                   <table id="myTableDataupdate" class="uk-table" style="border-color:#CCCCCC;" border="1" cellspacing="0">
                     <tr>
                     <td><input class="md-input" tabindex="29" type="text" name="Addclientupdate" id="Addclientupdate" placeholder="Enter Party here"></td>
                   
                   <td>
          <input class="md-btn md-btn-flat md-btn-flat-danger" style="width:150px" name="add" id="add" tabindex="30" type="button"  value="Add" onclick="javascript: return addRowupdate()">
                     
                        </td> 
                      </tr>
                                       
                       <tr>                       
                        <td width="370"><b>Name</b></td>
                         <td width="80"><b>Action</b></td>
                       </tr>
                       </table>
                       </div>
                                                                                  
                       </div>
                                     
                      </div>
                    </div>
              </div>
          </div>
          
          
          
               <!-- Add Other Opposite Party's Names in update mode -->   
                <div class="uk-width-large-1-2">
                    <div class="md-card">
                     <div class="md-card-content" style="text-align:left; font-weight:bolder">
                       
                                   
                    <div class="uk-overflow-container">
                    
                     <div class="uk-width-medium-1-1" style="margin-left:0px"><i class="material-icons md-color-blue-800" style="font-size:30px;cursor: pointer; vertical-align:middle; padding-left:0px">group_add</i> &nbsp;&nbsp; <label>Add Other Opposite Party Names</label><div name="myformoppoupdate" id="myformoppoupdate"> 
                   <table id="myTableDataoppoupdate" class="uk-table" border-color:#CCCCCC;" border="1" cellspacing="0">
                     <tr>
                     <td><input class="md-input" tabindex="31" type="text" name="Addclientoppoupdate" id="Addclientoppoupdate" placeholder="Enter Opposite Party here"></td>
                   
                   <td>
          <input class="md-btn md-btn-flat md-btn-flat-danger" style="width:150px" name="add" id="add" tabindex="32" type="button"  value="Add" onclick="javascript: return addRowoppoupdate()">
                     
                        </td> 
                      </tr>
                                       
                       <tr>                       
                        <td width="370"><b>Name</b></td>
                         <td width="80"><b>Action</b></td>
                       </tr>
                       </table>
                             
                       </div>
                     
                                                                                 
                       </div>
                       
                   </div>
                </div>  <!--mytableoppoparty ends here -->
                    
        </div>
        </div>
       </div> 
 
             


<!-- end of new md cards for other parties and other oppo parties--->
            
            
                               
                     <script>
									
                    function addRowupdate() {
					 var myName=document.getElementById("Addclientupdate");
					 var table=document.getElementById("myTableDataupdate");
					 var rowCount=table.rows.length;
					 var row=table.insertRow(rowCount);
		
		
	if($("#Addclientupdate").val()==0)
  {
  alert("Please Enter Client Name!!");
  
  return false;
  } else{
  
	
	row.insertCell(0).innerHTML= myName.value;
	row.insertCell(1).innerHTML='<input type="button" class="md-btn md-btn-flat md-btn-flat-danger" style="width:170px" value="DELETE" onClick="Javascript:deleteRowUpdate(this)">';
																
					 myName.value=null;	
		}			
					} //end of addRowupdate
					
					function deleteRowUpdate(obj) {
          			
					var index=obj.parentNode.parentNode.rowIndex;
					var table=document.getElementById("myTableDataupdate");
					emp=document.getElementById("myTableDataupdate").rows[index].cells[0];
                    
					table.deleteRow(index);	
										
					} //end of deleteRowUpdate
					</script>
                    
                    
           <!----- for adding opposite party update mode---->
    
			
                     
		 <script>
									
                    function addRowoppoupdate() {
                 
					 var myName=document.getElementById("Addclientoppoupdate");
					 var table=document.getElementById("myTableDataoppoupdate");
					 var rowCount=table.rows.length;
					 var row=table.insertRow(rowCount);
															 
					
	if($("#Addclientoppoupdate").val()==0)
  {
  alert("Please Enter Opposite Client Name!!");
  
  return false;
  } else{
  
	
	row.insertCell(0).innerHTML= myName.value;
	row.insertCell(1).innerHTML='<input type="button" class="md-btn md-btn-flat md-btn-flat-danger" style="width:170px" value="DELETE" onClick="Javascript:deleteRowOppoUpdate(this)">';
	
															
					 myName.value=null;	
		}			
					}
                    
                    function deleteRowOppoUpdate(obj) {
          			
					var index=obj.parentNode.parentNode.rowIndex;
					var table=document.getElementById("myTableDataoppoupdate");
					emp=document.getElementById("myTableDataoppoupdate").rows[index].cells[0];
                    
					table.deleteRow(index);	
										
					} //end of deleteRowUpdate
						
									
					
					</script>  
                   
		
		
		<?php      
		
		    
                       	//select attached clients with this case
			$sqlclients = "SELECT lw_otherclients.id,lw_otherclients.brief_file,
					lw_otherclients.name
					FROM lw_otherclients WHERE lw_otherclients.brief_file = '" . $brief_file . "' AND tag='C'";
					
			$resultclients = DB_query($sqlclients,$db); 
		
		
		// BELOW ARE THE RESULTS FOR ATTACHED PARTIES AND OPPO CLIENTS			 
					 
					 
		//Put md cards below to seperate			 
					 ?>
                     <br>
                     
                <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-medium-1-2">
                    <div class="md-card">
                        <div class="md-card-content" style="text-align:left; font-weight:bolder">
                         
                                   
                    <div class="uk-overflow-container">
   <div class="uk-width-medium-1-1" style="margin-left:0px"><i class="material-icons md-color-blue-800" style="font-size:30px;cursor: pointer; vertical-align:middle; padding-left:0px">group_add</i>&nbsp;&nbsp;<label>Existing Parties</label>                  
                                 
    	<table id="partyresult" class="uk-table" border="1" cellspacing="0">
   
    
<?php
	$TableHeader = "<tr>
	
			<th>" . _('ID') . "</th>
			<th>" . _('Brief_File') . "</th>
			<th>" . _('Party') . "</th>
			<th>" . _('Action') . "</th>
			</tr>";

	echo $TableHeader;
	
	$i=0;
	
	while($myrowclients = DB_fetch_array($resultclients))
	{
	
			
		printf("<tr><td width='20'>%s</td>
			<td width='120'>%s</td>
			<td width='180'>%s</td>
			<td>
			<input type='button' class='md-btn md-btn-flat md-btn-flat-danger' style='width:80px' value='DELETE' onClick='Javascript:deleteRowResult(this)'/>
			</td></tr>",
			$myrowclients['id'],
			$myrowclients['brief_file'],
			$myrowclients['name']);
	  
	  }	
echo '</table>';
?>                                     
                                               
                       </div>  <!-- end of party table for clients  -->
                       
   
                   
                   
                       </div>
                                                    
                      </div>
                    </div>
              
         </div>
          
    
          
               
                <div class="uk-width-medium-1-2">
                    <div class="md-card">
                        <div class="md-card-content" style="text-align:left; font-weight:bolder">
                
                    <div class="uk-overflow-container">
                     <div class="uk-width-medium-1-1" style="margin-left:0px"><i class="material-icons md-color-blue-800" style="font-size:30px;cursor: pointer; vertical-align:middle; padding-left:0px">group_add</i>&nbsp;&nbsp;<label>Existing Opposite Parties</label>
                       <?php          
   //select attached opposite clients with this case
						
			$sqlclients = "SELECT lw_otherclients.id,lw_otherclients.brief_file,
					lw_otherclients.name
					FROM lw_otherclients WHERE lw_otherclients.brief_file = '" . $brief_file . "' AND tag='O'";
					
			$resultclients = DB_query($sqlclients,$db); 
			
                       ?>
                                              
                 <!--    Right hand side of oppo parties fetched  --->   
              
    	<table id="partyresultoppo" class="uk-table" border="1" cellspacing="0">
   
    
<?php
	$TableHeader = "<tr>	
			<th>" . _('ID') . "</th>
			<th>" . _('Brief_File') . "</th>
			<th>" . _('Opposite Party') . "</th>
			<th>" . _('Action') . "</th>
			</tr>";

	echo $TableHeader;
	
	$i=0;
	
	while($myrowclients = DB_fetch_array($resultclients))
	{
	
			
		printf("<tr><td width='20'>%s</td>
			<td width='120'>%s</td>
			<td width='180'>%s</td>
			<td>
			<input type='button' class='md-btn md-btn-flat md-btn-flat-danger' style='width:80px' value='DELETE' onClick='Javascript:deleteRowOppoResult(this)'/>
			</td></tr>",
			$myrowclients['id'],
			$myrowclients['brief_file'],
			$myrowclients['name']);
	  
	  }	
echo '</table>';
?>     </form>
            
                             
                       </div>
                     
                                        
                                                                                  
                       </div>
                       
                   </div>
                </div> 
                    
        </div>
        </div>
               
                     
                     <!-- End of md cards for displaying existing parties and opposite parties  --->
                    
               
  <script>
  
  function deleteRowResult(obj) {
          					
					var index=obj.parentNode.parentNode.rowIndex;
					var table=document.getElementById("partyresult");
					emp=document.getElementById("partyresult").rows[index].cells[0];
                    
					table.deleteRow(index);	
								
					
					$.ajax({
						url: 'deleteclient.php', // Url to which the request is send
						type: "POST",             // Type of request to be send, called as method
						dataType: "html",
						data: {
									'clientid': emp.textContent			
							  },// Data sent to server, a set of key/value pairs (i.e. form fields and values	
						
						success: function(data)   // A function to be called if request succeeds
						{
						
						$("#message").html(data);
						}
						
						});					
					
					}
									
                   
									
					function deleteRowOppoResult(obj) {
          					
					var index=obj.parentNode.parentNode.rowIndex;
					var table=document.getElementById("partyresultoppo");
					emp=document.getElementById("partyresultoppo").rows[index].cells[0];
                    
					table.deleteRow(index);	
								
					
					$.ajax({
						url: 'deleteclient.php', // Url to which the request is send
						type: "POST",             // Type of request to be send, called as method
						dataType: "html",
						data: {
									'clientid': emp.textContent			
							  },// Data sent to server, a set of key/value pairs (i.e. form fields and values	
						
						success: function(data)   // A function to be called if request succeeds
						{
						
						$("#message").html(data);
						}
						
						});					
					
					}
									
					
					</script>  
   
   
   
                </div>
                <div class="uk-margin-medium-bottom"></div>
    </div>
    </div>
    
    
    <!--  md card should end here  --->
    
    
    

           
       <div class="md-fab-wrapper">
        <!--<a class="md-fab md-fab-primary" href="#" data-uk-modal="{target:'#modal_search_notice'}">
        <i class="material-icons">&#xE8B6;</i>
        </a>-->
        <a class="md-fab md-fab-danger" href="#mailbox_new_message" data-uk-modal="{center:true}">
           <i class="material-icons">&#xE8F4;</i>
        </a>
    </div>
<br>

    <div class="uk-modal" id="mailbox_new_message" >
        <div class="uk-modal-dialog" style="z-index:auto; width:1300px">
            <button class="uk-modal-close uk-close" type="button"></button>
                <div class="uk-modal-header">
                    <h3 class="uk-modal-title">Preview of Last 10 NEW Cases Entered</h3>
                </div>
                <div class="uk-margin-medium-bottom">
                
                <?php
			
                  $sql = 'SELECT lw_cases.id,
	        lw_cases.brief_file,
			lw_cases.notice_no,
			lw_cases.party,
			lw_cases.oppoparty,
			lw_cases.courtcaseno,
			lw_cases.courtid,
			lw_cases.stage,
			lw_cases.opendt			
			FROM lw_cases ORDER BY lw_cases.id DESC LIMIT 10';
	$StatementResults=DB_query($sql,$db);
		
	echo '<table class="uk-table">';
   

	$TableHeader = "<tr bgcolor='#82A2C6'>
	
			<th>" . _('ID') . "</th>
			<th>" . _('Brief_File') . "</th>
			<th>" . _('Court Case No') . "</th>
			<th>" . _('Notice No') . "</th>
			<th>" . _('Party Name') . "</th>
			<th>" . _('Oppo Party') . "</th>
			<th>" . _('Case Status') . "</th>
			<th>" . _('Court Name') . "</th>
			<th>" . _('Stage') . "</th>
			<th>" . _('Open Date') . "</th>
			</tr>";

	echo $TableHeader;
	
	while($Contacts=DB_fetch_array($StatementResults))
	{
	
	$resultparty=DB_query("SELECT name FROM lw_contacts WHERE lw_contacts.id='" . $Contacts['party'] . "'",$db);	
				$myrowparty=DB_fetch_array($resultparty);
	  
	  $resultoppoparty=DB_query("SELECT name FROM lw_contacts WHERE lw_contacts.id='" . $Contacts['oppoparty'] . "'",$db);	
				$myrowoppoparty=DB_fetch_array($resultoppoparty);
			
	$resultstage=DB_query("SELECT stage FROM lw_stages WHERE lw_stages.stageid='" . $Contacts['stage'] . "'",$db);
			$myrowstage=DB_fetch_array($resultstage);
	
  	 $resultcourt=DB_query("SELECT courtname FROM lw_courts WHERE lw_courts.courtid='" . $Contactscourt['courtid'] . "'",$db);		
			$myrowcourt=DB_fetch_array($resultcourt);
		
		
		printf("<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			</tr>",
			$Contacts['id'],
			$Contacts['brief_file'],
			$Contacts['courtcaseno'],
			$Contacts['notice_no'],
			$myrowparty['name'],
			$myrowoppoparty['name'],
			$myrowcourt['courtname'],
			$myrowstage['stage'],
			ConvertSQLDate($Contacts["opendt"])			
			);
	  
	  }
	
	?>
        </div>
    </div>
    </div>
    
				  

<?php } ?>


  <!-- Search Form Demo -->

<!-- Placed at the end of the document so the pages load faster -->
<script src="jquery-1.11.1.min.js"></script>

<script src="assets/js/common.js"></script> 

<!-- Live Search Script -->
<script type="text/javascript" src="ajaxlivesearch.js"></script>


<script>

$("#Stage").change( function() {

if($("#Stage").val()==37)
{
$("#Coramcard").show();
}else
{
$("#Coramcard").hide();
}
  
});



$("#Closecase").click( function() {
alert("Please fill Coram, Close Date, Remark and Judgement Below before updating the case!!!");		

document.getElementById('Coram').style.backgroundColor="#FFFF66";
document.getElementById('Closedateupdate').style.backgroundColor="#FFFF66";
document.getElementById('Casecloseremark').style.backgroundColor="#FFFF66";
document.getElementById('Judgementorder').style.backgroundColor="#FFFF66";
  
});

//below is for notices search for the lw_noticecr
	jQuery("#Notice_no").ajaxlivesearch({
        loaded_at: <?php echo $time; ?>,
        token: <?php echo "'" . $token . "'"; ?>,
        max_input: <?php echo $maxInputLength; ?>,
        onResultClick: function(e, data) {
             // get the index 1 (second column) value
            var noticeno = jQuery(data.selected).find('td').eq('0').text();     
			var noticeid = jQuery(data.selected).find('td').eq('1').text();  
			
			var party = jQuery(data.selected).find('td').eq('2').text(); 
			var oppoparty = jQuery(data.selected).find('td').eq('3').text();   
			var partyid = jQuery(data.selected).find('td').eq('4').text(); 
			var oppopartyid = jQuery(data.selected).find('td').eq('5').text();   
			 
           // set the input value           
                    
           jQuery('#Notice_no').val(noticeno);
           
           jQuery('#Notice_no_id').val(noticeid);          
        
			jQuery('#Casepartyid').val(partyid);	
			
			jQuery('#Caseoppopartyid').val(oppopartyid);
			
			jQuery('#Casepartyname').val(party);	
			
			jQuery('#Caseoppopartyname').val(oppoparty);
			
			jQuery('#Casepartynamehidden').val(party);	
			
			jQuery('#Caseoppopartynamehidden').val(oppoparty);
						
			// hide the result
           jQuery("#Notice_no").trigger('ajaxlivesearch:hide_result');
        },
        onResultEnter: function(e, data) {
            // do whatever you want
            //jQuery("#Notice_no").trigger('ajaxlivesearch:search', {query: 'test'});
        },
        onAjaxComplete: function(e, data) {

        }
    });



	jQuery(".Casepartyname").ajaxlivesearch({
        loaded_at: <?php echo $time; ?>,
        token: <?php echo "'" . $token . "'"; ?>,
        max_input: <?php echo $maxInputLength; ?>,
        onResultClick: function(e, data) {
                
            // get the index 0 (first column) value ie id
            var selectedZero = jQuery(data.selected).find('td').eq('0').text();
                         
         if(selectedZero){
         if ( confirm('Are you sure you want to select Existing contact from address book ') ) {
         // set the input value
           jQuery('#Casepartyid').val(selectedZero);
			
			// get the index 0 (first column) value ie name
            var selectedone = jQuery(data.selected).find('td').eq('1').text();           

            // set the input value
            jQuery('.Casepartyname').val(selectedone);
            
            var x=jQuery(data.selected).find('td').eq('1').text(); 
            
            var f=x.replace(/ /g, "");
            
            jQuery('#client_name').val(f);
            
            var url = 'contactimages/'+f+ '.png';            
            
            jQuery('#client_photo_preview').attr('src', url);                     
            
			 // set the partyname hidden value
            jQuery('#Casepartynamehidden').val(selectedone);
			
			 // get the index 1 (second column) value for address
            var selectedtwo = jQuery(data.selected).find('td').eq('2').text();
            
            // set the input value
            jQuery('#Address').val(selectedtwo);
			
			 // get the index 1 (second column) value for mobile
            var selectedthree = jQuery(data.selected).find('td').eq('3').text();

            // set the input value
            jQuery('#Mobile').val(selectedthree);          
            
            
        }else {
        
        	return false;           
               
        }        
        
                        }
						
			// hide the result
            jQuery(".Casepartyname").trigger('ajaxlivesearch:hide_result');      
            
        
        },
        onResultEnter: function(e, data) {
               
            // do whatever you want
            //jQuery(".Casepartyname").trigger('ajaxlivesearch:search', {query: 'test'});
            
                   
        },
        
             
        onAjaxComplete: function(e, data) {
                
           	
        }
    });
	
	//below is for main search for the lw_casenewajax form
	jQuery(".mdinputSearch").ajaxlivesearch({
        loaded_at: <?php echo $time; ?>,
        token: <?php echo "'" . $token . "'"; ?>,
        max_input: <?php echo $maxInputLength; ?>,
        onResultClick: function(e, data) {
            // get the index 1 (second column) value
            var selectedsearch = jQuery(data.selected).find('td').eq('0').text();

            // set the input value
            jQuery('.mdinputSearch').val(selectedsearch + '  Click icon --->');
			
			jQuery('#Searchhidden').val(selectedsearch);
			 
			
			 /*// get the index 1 (second column) value for address
            var selectedtwo = jQuery(data.selected).find('td').eq('1').text();

            // set the input value
            jQuery('#Address').val(selectedtwo);
			
			 // get the index 1 (second column) value for mobile
            var selectedthree = jQuery(data.selected).find('td').eq('2').text();

            // set the input value
            jQuery('.mobile').val(selectedthree);*/
						
			// hide the result
           jQuery(".mdinputSearch").trigger('ajaxlivesearch:hide_result');
        },
        onResultEnter: function(e, data) {
            // do whatever you want
            //jQuery(".mdinputSearch").trigger('ajaxlivesearch:search', {query: 'test'});
        },
        onAjaxComplete: function(e, data) {

        }
    });
	
	
	//below is for main search for the lw_casenewajax form
	jQuery(".HeaderinputSearch").ajaxlivesearch({
        loaded_at: <?php echo $time; ?>,
        token: <?php echo "'" . $token . "'"; ?>,
        max_input: <?php echo $maxInputLength; ?>,
        onResultClick: function(e, data) {
            // get the index 1 (second column) value
            var selectedsearch = jQuery(data.selected).find('td').eq('0').text();

            // set the input value
            jQuery('.HeaderinputSearch').val(selectedsearch);
			
			jQuery('#Searchheaderhidden').val(selectedsearch);
			
			
			 /*// get the index 1 (second column) value for address
            var selectedtwo = jQuery(data.selected).find('td').eq('1').text();

            // set the input value
            jQuery('.md-inputaddress').val(selectedtwo);
			
			 // get the index 1 (second column) value for mobile
            var selectedthree = jQuery(data.selected).find('td').eq('2').text();

            // set the input value
            jQuery('.md-inputmobile').val(selectedthree);*/
						
			// hide the result
           jQuery(".HeaderinputSearch").trigger('ajaxlivesearch:hide_result');
        },
        onResultEnter: function(e, data) {
            // do whatever you want
            //jQuery(".HeaderinputSearch").trigger('ajaxlivesearch:search', {query: 'test'});
        },
        onAjaxComplete: function(e, data) {

        }
    });
	
	
	
	jQuery(".Caseoppopartyname").ajaxlivesearch({
        loaded_at: <?php echo $time; ?>,
        token: <?php echo "'" . $token . "'"; ?>,
        max_input: <?php echo $maxInputLength; ?>,
        onResultClick: function(e, data) {
		
		// get the index 0 (second column) value ie id
            var selectedZero = jQuery(data.selected).find('td').eq('0').text();
        
         if(selectedZero){
         if ( confirm('Are you sure you want to select Existing contact from address book ') ) {

            // set the input value
            jQuery('#Caseoppopartyid').val(selectedZero);
			
            // get the index 1 (second column) value ie name
            var selectedOne = jQuery(data.selected).find('td').eq('1').text();

            // set the input value
            jQuery('.Caseoppopartyname').val(selectedOne);
			
			jQuery('#Caseoppopartynamehidden').val(selectedOne);		
			
			
			 // get the index 1 (second column) value for address
            var selectedtwo = jQuery(data.selected).find('td').eq('2').text();

            // set the input value
            jQuery('#Addressoppo').val(selectedtwo);
			
			 // get the index 1 (second column) value for mobile
            var selectedthree = jQuery(data.selected).find('td').eq('3').text();

            // set the input value
            jQuery('#Mobileoppo').val(selectedthree);
        
           
            
        }else {
            return false;
               
        }        
                        }
                                                
            // hide the result
           jQuery(".Caseoppopartyname").trigger('ajaxlivesearch:hide_result');
                                                
                                                
                                                
        },
        onResultEnter: function(e, data) {
            // do whatever you want
            // jQuery(".Caseoppopartyname").trigger('ajaxlivesearch:search', {query: 'test'});
        },
        onAjaxComplete: function(e, data) {

        }
    });
    
function imgError()
{
var image = document.getElementById("client_photo_preview");
image.src='contactimages/noimage.jpg'; 
}
    
  
</script>    
