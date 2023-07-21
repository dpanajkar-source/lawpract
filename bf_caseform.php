 <?php
 $PageSecurity = 3;

include('includes/session.php');


$title='Bank Finance';
 
 ?>
<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>

    <link rel="icon" type="image/png" href="assets/img/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="assets/img/favicon-32x32.png" sizes="32x32">

    <title>LawPract&trade;</title>


    <!-- uikit -->
    <link rel="stylesheet" href="bower_components/uikit/css/uikit.almost-flat.min.css" media="all">

    <!-- flag icons -->
    <link rel="stylesheet" href="assets/icons/flags/flags.min.css" media="all">

    <!-- altair admin -->
    <link rel="stylesheet" href="assets/css/main.css" media="all">
    
     <link rel="stylesheet" href="print.css" type="text/css" media="print" />
    
     <!-- Live Search Styles -->
    <link rel="stylesheet" href="css/fontello.css">
    <link rel="stylesheet" href="css/animation.css">
    <!--[if IE 7]>
    <link rel="stylesheet" href="css/fontello-ie7.css">
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="css/ajaxlivesearch.min.css">

    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
    <![endif]-->
    
    

</head>
<body class=" sidebar_main_open sidebar_main_swipe">
   
    <?php include("header.php"); ?>
    <?php include("menu.php"); ?>    
   
<div id="page_content">
    <div id="page_content_inner">

        <h3 class="heading_b uk-margin-bottom">File Inward Entry</h3>

        <div class="md-card">
            <div class="md-card-content">
            <div class="filtering">
    <form>
    
   
        <div class="uk-width-medium-2-2">
        <div class="md-card-content">
        <div class="uk-grid" style="margin-left:0px">
        
<div class="uk-width-medium-1-2" align="left"><i class="md-icon material-icons" id="invoice_print">&#xE8ad;</i></div>
<div class="uk-width-medium-1-2" style="padding-bottom:10px" align="right"><h1 class="heading_a" id="heading_a"><?php echo date("d-m-Y"); ?></h1> </div>  
   	  
    <div class="uk-width-xLarge-2-10 uk-width-large-3-10">
        <div class="md-card" style="border:groove">
         <div  class="md-card-content">
                        <div> Page Date wise Filtering<br>

<div class="uk-width-medium-1-1" padding-top:10px">
      	<input type="text" data-uk-datepicker="{format:'DD-MM-YYYY'}" class="md-input" name="diarydate" id="diarydate" placeholder="Select Diary Date"/></div>
        

        
<div class="uk-width-medium-1-1 style="padding-bottom:10px"><input type="text" class="md-input" name="srch" id="srch" placeholder="Type Brief/File No or Case No For filtering"/>
</div>
<br>
<div class="uk-width-medium-1-1 style="padding-bottom:10px"><button type="submit" style="visibility:visible" class='md-btn md-btn-primary' id="LoadRecordsButton">Load Page</button> </div>      
        </div>
        </div>
        </div>
        </div>
        	
      
         <div class="uk-width-xLarge-8-10 uk-width-large-7-10">
              <div class="md-card" style="border:groove">
                        <div  class="md-card-content">
                        <div class="uk-grid" data-uk-grid-margin>
                        
                         
        <div class="uk-width-medium-1-1" align="left"> New Record Section :
        <input type="text" name="Courtcaseno" id="Courtcaseno" class="md-input" placeholder="Type Client Name/ Mobile" tabindex="1"></div>
        
        <div class="uk-width-medium-1-5" style="padding-bottom:10px">
      Entry Date: <input class="md-input" data-uk-datepicker="{format:'DD-MM-YYYY'}" name="Otherdate" id="Otherdate" tabindex="3" value="<?php echo date("d-m-Y"); ?>">
     </div> 
		   
          <input type="hidden"  name="Courtcasenohidden" id="Courtcasenohidden">
  <div class="uk-width-medium-2-5" style="padding-bottom:10px">Name of Customer <input type="text" class="md-input" name="Partyhidden" id="Partyhidden"></div> 
  <div class="uk-width-medium-2-5" style="padding-bottom:10px">Application No<input type="text" class="md-input" name="Brief_filehidden" id="Brief_filehidden"></div>
  
 
   <div class="uk-width-medium-3-6" style="padding-bottom:10px">Select Branch:
  
  <?php
  $result=DB_query('SELECT branch_code,branch_area FROM bf_bank_branch',$db);
				echo '<select id="Branchcode" name="Branchcode" class="md-input" tabindex="4">';
					
				while ($myrow = DB_fetch_array($result)) {
				if ($_POST['Branchcode']==$myrow['branch_code']){
					echo '<option selected VALUE='. $myrow['branch_code'] . '>' . $myrow['branch_area'];
				} else {
					echo '<option VALUE='. $myrow['branch_code'] . '>' . $myrow['branch_area'];
				}
				} //end while loop
			
			DB_free_result($result);
			
			echo '</select></div>'; 
  
 ?>
 
 
  <div class="uk-width-medium-3-6" style="padding-bottom:10px">Select Stage:
  
  <?php
  $result=DB_query('SELECT stageid, stage FROM bf_stages',$db);
				echo '<select id="Stage" name="Stage" class="md-input" tabindex="4">';
					
				while ($myrow = DB_fetch_array($result)) {
				if ($_POST['Stage']==$myrow['stageid']){
					echo '<option selected VALUE='. $myrow['stageid'] . '>' . $myrow['stage'];
				} else {
					echo '<option VALUE='. $myrow['stageid'] . '>' . $myrow['stage'];
				}
				} //end while loop
			
			DB_free_result($result);
			
			echo '</select></div>'; 
  
 ?>
 <div class="uk-width-medium-1-6" padding-top:10px">Amount:
      	<input type="text" class="md-input" name="amount" id="amount" placeholder="Charges"/></div>
        
    <div class="uk-width-medium-2-6" style="padding-bottom:10px"> <button type="submit" style="visibility:visible" class='md-btn md-btn-primary' id="AddRecordsButton">Add New Row</button></div>

</div>
</div>
</div>
</div>
</div> 
</div>
</div>
</div> 

<!-- <div class="uk-width-medium-1-3">
    <a class="md-fab md-fab-danger" href="#" id="recordAdd">
	<i class="material-icons">&#xE145;</i>
    </a>
</div>--> 
    
</form>
		<div id="message">
        
        
        </div>
        

        <div style="overflow:auto" id="diarygrid"></div>
        
        
         </div>
        </div>
        </div>
        </div>
        </div>





  <?php include("footersrc.php");      ?>
   
   
     <script src="print.js"></script>
 
    <!-- JQuery-UI -->
    <link rel="stylesheet" href="assets/skins/jquery-ui/material/jquery-ui.min.css">
    <script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
    <!-- jTable -->
    
    <link rel="stylesheet" href="bower_components/jtable/lib/themes/metro/blue/jtable.css">    
    
	<script src="bower_components/jtable/lib/jquery.jtable.js"></script>

    <!--  diff functions -->
    <script src="assets/js/CRUD/bankfinance.js"></script>  
    
    <script>
	//below is for fetching courtcaseno from lw_cases
	jQuery("#Courtcaseno").ajaxlivesearch({
        loaded_at: <?php echo $time; ?>,
        token: <?php echo "'" . $token . "'"; ?>,
        max_input: <?php echo $maxInputLength; ?>,
        onResultClick: function(e, data) {
            // get the index 1 (second column) value
            var courtcaseno = jQuery(data.selected).find('td').eq('3').text();
			
			var stage = jQuery(data.selected).find('td').eq('4').text();
			
			var brief_file = jQuery(data.selected).find('td').eq('0').text();
            
            var partyname = jQuery(data.selected).find('td').eq('1').text();
			
            // set the input value
            jQuery('#Courtcaseno').val(courtcaseno);
			
			jQuery('#Courtcasenohidden').val(courtcaseno);	
        			
			jQuery('#Stage').val(stage);			
			
			jQuery('#Brief_filehidden').val(brief_file);
            
            jQuery('#Partyhidden').val(partyname);
            				
						
			// hide the result
           jQuery("#Courtcaseno").trigger('ajaxlivesearch:hide_result');
        },
        onResultEnter: function(e, data) {
            // do whatever you want
            //jQuery("#Courtcaseno").trigger('ajaxlivesearch:search', {query: 'test'});
        },
        onAjaxComplete: function(e, data) {

        }
    });
	
    
    </script>
  


</body>
</html>