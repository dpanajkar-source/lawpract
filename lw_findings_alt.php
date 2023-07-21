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

     <!-- uikit -->
    <link rel="stylesheet" href="bower_components/uikit/css/uikit.almost-flat.min.css" media="all">

    <!-- flag icons -->
    <link rel="stylesheet" href="assets/icons/flags/flags.min.css" media="all">

    <!-- altair admin -->
    <link rel="stylesheet" href="assets/css/main.css" media="all">
    
   
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
  
  selector: "textarea",  // change this value according to your HTMLSSSSS   

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
	include('includes/session.php');
  include('server_con.php');
 
 $allowedTags='$nbsp<p><strong><em><u><h1><h2><h3><h4><h5><h6><img>';
 $allowedTags.='<li><ol><ul><span><div><br><ins><del>';  
            
if(isset($_POST['Save']))
{
   // Should use some proper HTML filtering here.
if($_POST['elm1']!='') 
{
    
  $Content = strip_tags(stripslashes($_POST['elm1']),$allowedTags);
    
   // $Content = str_replace(array("\r\n", "\r"), "\n", $Content);
    		
        $sql = "UPDATE lw_findings SET
              findings='".$Content."'
			 WHERE appointId='".$_POST['appointId']."'";
		$result=mysqli_query($con,$sql);                      

}		   
    
		?>
	
   <script>
		
swal({   title: "Findings Saved!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
 window.close();
}, 2000); 


	</script>
                        
       <?php

    
}


 $sqlfindings = "SELECT findings FROM lw_findings WHERE appointid='".trim($_GET['id'])."'";
		$resultfindings = mysqli_query($con,$sqlfindings);
		
		$myrowfindings=mysqli_fetch_array($resultfindings); 
		
		$Content=$myrowfindings[0]; 
		           
?>      

    <div id="page_content">
        <div id="page_content_inner">
       <div class="md-card"> 
      
        <div class="uk-width-medium-2-2" style="padding-left:10px; padding-right:10px">
        <div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">
          <div class="uk-width-medium-2-2">
              
   <div class="uk-width-medium-1-2" style="padding-left:10px">          
 <h2>Findings</h2></div>
 
 <form method='POST' name='findingsform' action="<?php echo $_SERVER['PHP_SELF']  . '?' . SID ; ?>">
    
 <div style="padding-bottom:10px; padding-top:10px; padding-left:10px">
  <textarea id="elm1" name="elm1" ><?php  echo html_entity_decode($Content); ?></textarea>
  </div>
     
     <input type="hidden"  name="appointId" id="appointId" value="<?php echo $_GET['id']; ?>">
<br />
<input type="submit" name="Save" id="Save" class="md-btn md-btn-primary" value="Save" />
<input type="reset" name="reset" class="md-btn md-btn-primary" value="Reset" />
</form>
  
    </div>
</div>
    </div>
</div>

  <!-- Search Form Demo -->

  <?php include("footersrc.php");      ?>
   
    <!-- JQuery-UI -->
    <link rel="stylesheet" href="assets/skins/jquery-ui/material/jquery-ui.min.css">
    <script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
   
</body>
</html>