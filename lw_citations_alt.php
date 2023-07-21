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

    <title id="tit">Citaion for Brif_File No. : <?php echo $_GET['brief_file']; ?></title>


    <!-- uikit -->
    <link rel="stylesheet" href="bower_components/uikit/css/uikit.almost-flat.min.css" media="all">

    <!-- flag icons -->
    <link rel="stylesheet" href="assets/icons/flags/flags.min.css" media="all">

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
 <script src="javascripts/MiscFunctions.js"></script> 

    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
    <![endif]-->
      <script src="tinymce/tinymce.min.js"></script>
<script language="javascript" type="text/javascript">
  tinyMCE.init({
    theme : "modern",
    mode: "textareas",
    elements : "elm1",
    theme_advanced_toolbar_location : "top",
    theme_advanced_buttons1 : "bold,italic,underline,strikethrough,separator,"
    + "justifyleft,justifycenter,justifyright,justifyfull,formatselect,"
    + "bullist,numlist,outdent,indent",
    theme_advanced_buttons2 : "undo,redo,cleanup,code,separator,sub,sup,charmap",
    theme_advanced_buttons3 : "",
   plugins : ["advlist autolink lists charmap print preview anchor","searchreplace visualblocks code fullscreen"," contextmenu paste"],
  //  save_onsavecallback : "saveContent",
  selector: "textarea",  // change this value according to your HTML
   
 menubar: "file,edit,view,format",
  toolbar:"undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent "
});
    
    function ajaxLoad() {
    var ed = tinyMCE.get('content');

    // Do you ajax call here, window.setTimeout fakes ajax call
    ed.setProgressState(1); // Show progress
    window.setTimeout(function() {
        ed.setProgressState(0); // Hide progress
        ed.setContent('HTML content that got passed from server.');
    }, 3000);
}

function ajaxSave() {
    var ed = tinyMCE.get('content');

    // Do you ajax call here, window.setTimeout fakes ajax call
    ed.setProgressState(1); // Show progress
    window.setTimeout(function() {
        ed.setProgressState(0); // Hide progress
        alert(ed.getContent());
    }, 3000);
}

</script>  


</head>
<body class=" sidebar_main_open sidebar_main_swipe">
    <!-- main header -->
    <?php
    $PageSecurity = 2;
     include("includes/session.php");
     ?>
   
            
            <?php
			
			$brieffile=$_GET['brief_file'];
			
            $allowedTags='&nbsp<p><strong><em><u><h1><h2><h3><h4><h5><h6><img>';
 $allowedTags.='<li><ol><ul><span><div><br><del>';  
 
 $sql='SELECT citation FROM lw_citations WHERE brief_file="' . $brieffile. '"';
 
 $result=DB_query($sql,$db);
 
 $myrow=DB_fetch_array($result);
 
 /*$order   = array("\r\n", "\n", "\r", " rn ", "rnrn", "<p>&nbsp;</p>");
 
 $Content=str_replace($order,'',html_entity_decode($myrow[0], ENT_COMPAT, $charset)); */ 

$patterns = array();
$patterns[0] = '/rn/';
$patterns[1] = '/rnrn/';
$replacements = array(); 
$replacements[0] = '';
$replacements[1] = '';

$Content=preg_replace($patterns, $replacements, html_entity_decode($myrow[0], ENT_COMPAT)); 
 
 
            
if(isset($_POST['Save']))
{
   // Should use some proper HTML filtering here.
if($_POST['elm1']!='') 
{

/*$order   = array("\r\n", "\n", "\r", " rn ", "rnrn", "<p>&nbsp;</p>");*/
    
  $Content = strip_tags(stripslashes($_POST['elm1']),$allowedTags);
  
 /* $Content=str_replace('rn','',html_entity_decode($Content, ENT_COMPAT, $charset));  */ 
  

$patterns = array();
$patterns[0] = '/rn/';
$patterns[1] = '/rnrn/';
$replacements = array(); 
$replacements[0] = '';
$replacements[1] = '';

$Content=preg_replace($patterns, $replacements, html_entity_decode($Content, ENT_COMPAT)); 

   //echo 'reached citation';		
		   $sqlcitation = "SELECT citationid FROM lw_citations WHERE brief_file='".trim($_POST['Brief_File'])."'";
		$resultcitation = DB_query($sqlcitation,$db);
		
		$myrowcitation=DB_fetch_array($resultcitation); 
		
      //echo 'reached citation insert if there is no entry of citation in lw_citations            
              
            if(empty($myrowcitation[0]))
               {		               
              
        $sqlcitation = "INSERT INTO lw_citations(
		brief_file,
		citation
		)
		VALUES ('".trim($_POST['Brief_File'])."',
		'".$Content."'
		)";
		
		$result = DB_query($sqlcitation,$db);
                
               }else
               {         
                
        //make all changes in brief_file no if brief_file is changed in lw_cases
        $sql = "UPDATE lw_citations SET
              citation='".$Content."',
			brief_file='".trim($_POST['Brief_File'])."'
			 WHERE citationid='".$myrowcitation[0]."'";
		$result=DB_query($sql,$db);
                       
           }
    
		?>
	
<script>
		
swal({   title: "Citation Saved!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
 // window.location.assign('lw_citations_alt.php'); //will redirect to your page
 
 window.close();
  
}, 2000); 

window.close();


	</script>
                        
       <?php
	 
    
}
    
}
            
?>      

	
    <div id="page_content">
        <div id="page_content_inner">
       <div class="md-card"> 
      
        <div class="uk-width-medium-2-2" style="padding-left:10px; padding-right:10px">
        <div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">
          <div class="uk-width-medium-2-2">
             
   <div class="uk-width-medium-1-2" style="padding-left:10px">          
 <h2>Citation Editor</h2></div>
  <div class="uk-width-medium-1-2" style="padding-right:10px"><span class="menu_title" style="text-decoration:underline; cursor:pointer" onClick="javascript:MM_openbrwindow('Manualcreatecitations.php',600,400);"><i class="material-icons md-color-green-500">&#xE887;</i></span></div>
 
 <form method='POST' name='citationsform' action="<?php echo $_SERVER['PHP_SELF']  . '?' . SID ; ?>">
     
    
 <div style="padding-bottom:10px; padding-top:10px; padding-left:10px">
  <textarea id="elm1" name="elm1" ><?php  echo str_replace(' rn ','',html_entity_decode($Content, ENT_COMPAT)); ?></textarea>
  </div>
     
     <input type="hidden"  name="Brief_File" id="Brief_File"  value="<?php echo $brieffile; ?>">
<br />
<input type="submit" name="Save" id="Save" class="md-btn md-btn-primary" value="Save & Close" />

</form>
  <div style="padding-bottom:10px; padding-top:10px; padding-left:10px">
  <!--<h4>For information on Supreme Court Judgements click on following links</h4>
<a href="http://judis.nic.in/supremecourt/chejudis.asp" target="_blank">Judgement Information system of Supreme Court</a><br>
<a href="http://judis.nic.in/supremecourt/caseno.asp" target="_blank">CASE NUMBER WISE QUERY FOR SCR NOTES AND CITATION</a><br>
<a href="http://judis.nic.in/supremecourt/citation.aspx" target="_blank">Judgment Information system</a><br>-->
      </div>
    </div>
</div>
    </div>
</div>

  <!-- Search Form Demo -->

   
    
    <!-- JQuery-UI -->
    <link rel="stylesheet" href="assets/skins/jquery-ui/material/jquery-ui.min.css">
    <script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
   

<script>
   
/*    
$("#Save").on('submit',(function(e) {	

e.preventDefault();
    
    ajaxLoad();

$.ajax({
//url: 'ajax_php_file.php', // Url to which the request is send
type: "POST",             // Type of request to be send, called as method
dataType: "html",
data: new FormData(this), //Data sent to server, a set of key/value pairs (i.e. form fields and values	

/*data: {
		Brief_File:$("#Brief_File").val(),
		Courtcaseno:$("#Courtcaseno").val(),
		Party:$("#Party").val()
	
	  },

contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false
success: function(data)   
{
$("#myform").html(data);
}

});
}));*/
	
	
</script>    
   
</body>
</html>