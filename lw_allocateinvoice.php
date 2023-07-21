<?php	

$PageSecurity = 5;

include('includes/session.php');

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
    <link rel="stylesheet" href="assets/css/main.min.css" media="all">
    
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
     <div id="top_bar" style="height:50px">
        <div class="md-top-bar">
        
        
            <div class="uk-width-large-10-12 uk-container-center">                             
                      
                 			<div class="uk-grid uk-grid-width-1-1 uk-grid-width-large-1-2">
                                 
                              <div class="uk-width-medium-1-1" style="width:710px">
               <form method="POST" class="casesform" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="text" class="mdinputinvalloc" name="mdinputinvalloc" id="mdinputinvalloc" data-uk-tooltip="{cls:'long-text', pos:'right'}"  title="If you have any cash or bank entry of customer and invoices to be allocated then you can select it here for allocation"   placeholder="Type to search Party, Brief File No, Mobile No and click the search icon" ></div> 
      <input type="hidden"  name="Searchhiddenbrieffile" id="Searchhiddenbrieffile">		
       <input type="hidden"  name="Searchhiddeninvoiceno" id="Searchhiddeninvoiceno">	
        <input type="hidden"  name="Searchhiddencourtcaseno" id="Searchhiddencourtcaseno">	
         <input type="hidden"  name="Searchhiddenparty" id="Searchhiddenparty">	
          <input type="hidden"  name="Searchhiddentotalfees" id="Searchhiddentotalfees">	
           <input type="hidden"  name="Searchhiddenbalance" id="Searchhiddenbalance">		
           
                                    <div class="uk-width-medium-1-3" style="padding-top:10px">
                                        
                                     <button class="header_main_search_btn uk-button-link"><i class="md-icon material-icons"></i></button></form>
                                    </div>
           
                            </div> 
            </div>
        </div>
   </div>
    
    
    <div id="page_content">
        <div id="page_content_inner">
             
            <div class="md-card ">
                <div class="md-card-content">
                
		           <div class="uk-overflow-container">
                   
                        <?php 
						   if($_SESSION['AccountType']==0)
				 {
					 echo 'You have selected Accounting type as Receipt. If you want to use Invoice based accounting, select accounting type as Accrual in System Preferences.';
				 
				 }elseif($_SESSION['AccountType']==1)
				 {	
						echo '<b>Please select Client name from above search and click the search icon. This will display all Receipts which are yet to be allocated to any invoice</b>';
						include('CustomerAllocations.php');  
						
				 }  
						
						?>
                  </div>
                </div>
            </div><!-- Table ends -->
            
<?php include('footersrc.php');    ?>


<!-- Placed at the end of the document so the pages load faster -->
<script src="jquery-1.11.1.min.js"></script>

<script src="assets/js/common.js"></script> 

<!-- Live Search Script -->
<script type="text/javascript" src="ajaxlivesearch.js"></script>


<script>

	//below is for main search for the lw_casenewajax form
	jQuery(".mdinputinvalloc").ajaxlivesearch({
        loaded_at: <?php echo $time; ?>,
        token: <?php echo "'" . $token . "'"; ?>,
        max_input: <?php echo $maxInputLength; ?>,
        onResultClick: function(e, data) {
            // get the index 1 (second column) value
            var selectedbrieffile = jQuery(data.selected).find('td').eq('0').text();
			var selectedinvoiceno = jQuery(data.selected).find('td').eq('1').text();
			var selectedcourtcaseno = jQuery(data.selected).find('td').eq('2').text();
			 var selectedparty = jQuery(data.selected).find('td').eq('3').text();
			 var selectedtotalfees = jQuery(data.selected).find('td').eq('4').text();
			 var selectedbalance = jQuery(data.selected).find('td').eq('5').text();

            // set the input value
            jQuery('.mdinputinvalloc').val(selectedbrieffile);
			
			jQuery('#Searchhiddenbrieffile').val(selectedbrieffile);
			jQuery('#Searchhiddeninvoiceno').val(selectedinvoiceno);
			jQuery('#Searchhiddencourtcaseno').val(selectedcourtcaseno);
			jQuery('#Searchhiddenparty').val(selectedparty);
			jQuery('#Searchhiddentotalfees').val(selectedtotalfees);
			jQuery('#Searchhiddenbalance').val(selectedbalance);			
									
			// hide the result
           jQuery(".mdinputinvalloc").trigger('ajaxlivesearch:hide_result');
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