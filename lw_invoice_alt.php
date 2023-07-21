<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta name="" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>    
    

      <link rel="icon" type="image/png" href="assets/img/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="assets/img/favicon-32x32.png" sizes="32x32">

    <title>LawPract&trade;</title>

     <!-- additional styles for plugins -->
       
        <!-- chartist -->
        <link rel="stylesheet" href="bower_components/chartist/dist/chartist.min.css">
    
    <!-- uikit -->
    <link rel="stylesheet" href="bower_components/uikit/css/uikit.almost-flat.min.css" media="all">

   <!-- altair admin -->
    <link rel="stylesheet" href="assets/css/main.css" media="all">
    
     <!-- Live Search Styles -->
    <link rel="stylesheet" href="css/fontello.css">
    <link rel="stylesheet" href="css/animation.css">
    <!--[if IE 7]>
    <link rel="stylesheet" href="css/fontello-ie7.css">
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="css/ajaxlivesearch.min.css">
    
    <link rel="stylesheet" type="text/css" href="dist/sweetalert.css">
      
   <script src="dist/sweetalert-dev.js"></script>

    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
    <![endif]-->
  
  


</head>
<body class=" sidebar_main_open sidebar_main_swipe">

  <?php 
    $PageSecurity = 5;
     include('includes/session.php');
     include("header.php"); 
     include("menu.php");    
      
    ?>     				  
                           
     <div id="top_bar" style="height:50px">
        <div class="md-top-bar">
        
        
            <div class="uk-width-large-10-12 uk-container-center">                             
                      
                 			<div class="uk-grid uk-grid-width-1-2 uk-grid-width-large-1-2">
                                 
                              <div class="uk-width-medium-1-2" style="width:710px">
               <form method="POST" class="casesform" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="text" class="mdinputSearch" name="mdinputSearch" id="mdinputSearch" placeholder="Type to search Party, Brief File No, Mobile No" ></div> 
      <input type="hidden"  name="Searchhidden" id="Searchhidden">								 


                                    <div class="uk-width-medium-1-3" style="padding-top:10px">
                                        
                                     <!--<button class="header_main_search_btn uk-button-link"><i class="md-icon material-icons"></i></button>--></form>
                                    </div>
           
                            </div> 
            </div>
        </div>
    </div>
   
    
    
    <div id="page_content">
        <div id="page_content_inner">
                  
            <div class="md-card">
                <div class="md-card-content">
                	<h1 align="right" style="margin-right:95px; margin-top:30px; color:#3333FF"><b>INVOICE</b></h1><br>
              <?php 
			     if($_SESSION['AccountType']==0)
				 {
				 echo 'You have selected Accounting type as Receipt. If you want to use Invoice based accounting, select accounting type as Accrual in System Preferences.';
				 
				 }elseif($_SESSION['AccountType']==1)
				 {
    					include("invoice.php"); 						
				 }
              ?>
              </div>
                </div>hello dinesh
            </div><!-- Table ends -->
            </div>
			
	<!--   copied from casenewajax file ----------> 
			
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
                    <h3 class="uk-modal-title">Preview of Last 10 NEW Invoices Entered</h3>
                </div>
                <div class="uk-margin-medium-bottom">
                
                <?php
			
                  $sql = 'SELECT 
			lw_partyeconomy.id,
			lw_partyeconomy.invoiceno,
			lw_partyeconomy.t_date,
	        lw_partyeconomy.brief_file,
			lw_partyeconomy.party,
			lw_partyeconomy.courtcaseno,
			lw_partyeconomy.totalfees
			FROM lw_partyeconomy ORDER BY lw_partyeconomy.id DESC LIMIT 10';
	$StatementResults=DB_query($sql,$db);
		
	echo '<table class="uk-table">';
   

	$TableHeader = "<tr bgcolor='#82A2C6'>
	
			<th>" . _('ID') . "</th>
			<th>" . _('Invoice No') . "</th>
			<th>" . _('Invoice Date') . "</th>
			<th>" . _('Brief_File') . "</th>
			<th>" . _('Party Name') . "</th>
			<th>" . _('Court Case No') . "</th>
			<th>" . _('Total Fees') . "</th>
			</tr>";

	echo $TableHeader;
	
	while($Contacts=DB_fetch_array($StatementResults))
	{
	
	$resultparty=DB_query("SELECT name FROM lw_contacts WHERE lw_contacts.id='" . $Contacts['party'] . "'",$db);	
				$myrowparty=DB_fetch_array($resultparty);
					
		printf("<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			<td>%s</td>
			</tr>",
			$Contacts['id'],
			$Contacts['invoiceno'],
			ConvertSQLDate($Contacts["t_date"]),
			$Contacts['brief_file'],
			$myrowparty['name'],
			$Contacts['courtcaseno'],
			$Contacts['totalfees']
						
			);
	  
	  }
	
	?>
        </div>
    </div>
    </div>
    
				  


   
    <!-- uikit functions -->

    <script src="assets/js/common.min.js"></script>
    <!-- uikit functions -->
    <script src="assets/js/uikit_custom.min.js"></script>
    <!-- altair common functions/helpers -->
    <script src="assets/js/altair_admin_common.min.js"></script>

    <!-- page specific plugins -->
    <!-- JQuery-UI -->
    <script src="bower_components/jquery-ui/jquery-ui.min.js"></script>

    <!-- page specific plugins -->
      
       
        <!-- countUp 
        <script src="bower_components/countUp.js/countUp.min.js"></script>-->
        <!-- handlebars.js -->
        <script src="bower_components/handlebars/handlebars.min.js"></script>
        <script src="assets/js/custom/handlebars_helpers.min.js"></script>

        <!-- fitvids 
        <script src="bower_components/fitvids/jquery.fitvids.js"></script>-->

        <!--  dashbord functions -->
        <script src="assets/js/pages/dashboard.min.js"></script>  
      
   
   
     <!-- Search Form Demo -->

<!-- Placed at the end of the document so the pages load faster -->
<script src="jquery-1.11.1.min.js"></script>

<script src="assets/js/common.js"></script> 

<!-- Live Search Script -->
<script type="text/javascript" src="ajaxlivesearch.js"></script>

  
        <script>
   
    function checkvalidity()
  {
  
  if($("#Brief_File").val()==0)
  {
  alert("Please Enter Brief_File No!!");
  
  return false;
  }else if($("#Courtcaseno").val()==0)
  {
  alert("Please Enter Court Case No!!");
  
  return false;
  }else if($("#Casepartyname").val()==0)
  {
  alert("Please Select/Enter Party Name from Drop Down List");
  
  return false;
  } 
  else if($("#Invoicedt").val()==0)
  {
  alert("Please Enter Invoice Date");
  
  return false;
  } 
  
  										 
					  function service() {		
					  
					 var table=document.getElementById("myTableData");
					 
					 var rowCount=document.getElementById("myTableData").rows.length;
					 			 
					 var services = [];
					 var filledservices = [];					 
					
					 services=document.getElementById("myTableData").rows[1].cells[0];
										 
					 var j=0;
					 for(var x=2; x<rowCount; x++)
					 	{ 						 
					       services[x]=document.getElementById("myTableData").rows[x].cells[0];
						                              
                               if(services[x].textContent!='')
                                   {								
								filledservices[j++]=services[x].textContent;					
                                   }
					 	}		
						
						return filledservices;						
					
					}
					
					  var services=service();
					  
					 
  					
					
					 function fees() {		
					  
					 var table=document.getElementById("myTableData");
					 
					 var rowCount=document.getElementById("myTableData").rows.length;
					 			 
					 var fees = [];
					 var filledfees = [];
					 fees=document.getElementById("myTableData").rows[1].cells[1];
					 
					 var j=0;
					 for(var x=2; x<rowCount; x++)
					 	{ 
						    fees[x]=document.getElementById("myTableData").rows[x].cells[1];
                            
                               if(fees[x].textContent!='')
                                   {
									filledfees[j++]=fees[x].textContent;					
                                   }
					 	}		
						
						return filledfees;		
						
					}
					
  var fees=fees();  
  
 if(services<1)
      {           
        return true;  
      }//condition for client array not empty
      else{
		  // send data from to addinv_breakup.php
		  
	$.ajax({
url: 'addinv_breakup.php', // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
dataType: "html",
//data: new FormData(this),// Data sent to server, a set of key/value pairs (i.e. form fields and values	
data: {
			'services': JSON.stringify(services),
			'fees': JSON.stringify(fees),
			'brief_file': $("#Brief_File").val(),
			'casepartyid': $("#Casepartyid").val(),
			'invoicedt': $("#Invoicedt").val(),
			'invoiceno': $("#Invoiceno").val()		
					
	  },

success: function(data)   // A function to be called if request succeeds
{	

}

});
          
      }
  
  }
    
   </script>   


<script>

	//below is for main search for the economy form
	jQuery(".mdinputSearch").ajaxlivesearch({
        loaded_at: <?php echo $time; ?>,
        token: <?php echo "'" . $token . "'"; ?>,
        max_input: <?php echo $maxInputLength; ?>,
        onResultClick: function(e, data) {
            // get the index 1 (second column) value
            var selectedsearch = jQuery(data.selected).find('td').eq('0').text();
			
			var partyname = jQuery(data.selected).find('td').eq('2').text();
			
			var oppopartyname = jQuery(data.selected).find('td').eq('3').text();
			
			var selectedthree = jQuery(data.selected).find('td').eq('4').text();
			
			var courtcaseno = jQuery(data.selected).find('td').eq('5').text();
			
			var partyid = jQuery(data.selected).find('td').eq('6').text();
			
			var oppopartyid = jQuery(data.selected).find('td').eq('7').text();
			
            // set the input value
            jQuery('.mdinputSearch').val(selectedsearch);
			
			jQuery('#Searchhidden').val(selectedsearch);			
			
			jQuery('#Brief_File').val(selectedsearch);
			
			
			
			
			alert(courtcaseno);
			
			jQuery('#Courtcaseno').val(courtcaseno);
			
			jQuery('#Casepartyname').val(partyname);
			
			jQuery('#Casepartynamehidden').val(partyname);
			
			jQuery('#Casepartyid').val(partyid);
			
			jQuery('#Caseoppopartyname').val(oppopartyname);
			
			jQuery('#Caseoppopartynamehidden').val(oppopartyname);
			
			jQuery('#Caseoppopartyid').val(oppopartyid);
			
				//below is to fetch table of customer receipts till date
	
			$.ajax({
				url: 'displayinvoices.php', // Url to which the request is send
				type: "POST",             // Type of request to be sent, called as method
				dataType: "html",
				//data: new FormData(this),// Data sent to server, a set of key/value pairs (i.e. form fields and values	
				data: {
							'brief_file': $("#Brief_File").val()			
					  },
				
				success: function(data)   // A function to be called if request succeeds
				{				
				$("#invoicedisplay").html(data);
				}
				
				});
									
			// hide the result
           jQuery(".mdinputSearch").trigger('ajaxlivesearch:hide_result');
        },
        onResultEnter: function(e, data) {
            // do whatever you want
            //jQuery(".mySearch").trigger('ajaxlivesearch:search', {query: 'test'});
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
            //jQuery(".mySearch").trigger('ajaxlivesearch:search', {query: 'test'});
        },
        onAjaxComplete: function(e, data) {

        }
    });
	
  
</script>    
</body>
   
</html>