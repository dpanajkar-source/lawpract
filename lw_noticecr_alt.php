<?php 

file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Handler.php') ? require_once __DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Handler.php' : die('There is no such a file: Handler.php');
file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Config.php') ? require_once __DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Config.php' : die('There is no such a file: Config.php');


use AjaxLiveSearch\core\Config;
use AjaxLiveSearch\core\Handler;

if (session_id() == '') {
    session_start();
}

    Handler::getJavascriptAntiBot();
    $token = Handler::getToken();
    $time = time();
    $maxInputLength = Config::getConfig('maxInputLength');   



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

    <title id="tit">Notice No. : - </title>


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

    <!-- matchMedia polyfill for testing media queries in JS -->
    <!--[if lte IE 9]>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.js"></script>
        <script type="text/javascript" src="bower_components/matchMedia/matchMedia.addListener.js"></script>
    <![endif]-->
      <script src="tinymce/tinymce.min.js"></script>
<script language="javascript" type="text/javascript">
  tinyMCE.init({
    theme : "modern",
    mode: "exact",
    elements : "elm1",
    theme_advanced_toolbar_location : "top",
    theme_advanced_buttons1 : "bold,italic,underline,strikethrough,separator,"
    + "justifyleft,justifycenter,justifyright,justifyfull,formatselect,"
    + "bullist,numlist,outdent,indent",
    theme_advanced_buttons2 : "link,unlink,anchor,image,separator,"
    +"undo,redo,cleanup,code,separator,sub,sup,charmap",
    theme_advanced_buttons3 : "",
   plugins : ["advlist autolink lists link image charmap print preview anchor","searchreplace visualblocks code fullscreen","insertdatetime media table contextmenu paste"],
      
    save_onsavecallback : "saveContent",
    height:"300px",
    width:"1000px",
 //plugins: "save, print,fullscreen,paste,visualchars,advlist",
  menubar: "file,edit,insert,view,format,table,media",
  toolbar:"insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
});

</script>
    


</head>
<body class=" sidebar_main_open sidebar_main_swipe">
    <!-- main header -->
    <?php
    $PageSecurity = 3;
     include("includes/session.php");
     include("header.php"); 
     include("menu.php"); 
   ?>
   
    <div id="page_content">
        <div id="page_content_inner">
            
            <?php
            $allowedTags='$nbsp<p><strong><em><u><h1><h2><h3><h4><h5><h6><img>';
 $allowedTags.='<li><ol><ul><span><div><br><ins><del>';  

if(isset($_POST['save']))
{
    
    
// Should use some proper HTML filtering here.
if($_POST['elm1']!='') 
{
    
    $Content = strip_tags(stripslashes($_POST['elm1']),$allowedTags);
    
      $sqlnotice = "SELECT noticeid FROM lw_noticecr WHERE notice_no='".trim($_POST['Notice_no'])."'";
		$resultnotice = DB_query($sqlnotice,$db);
		
		$myrownotice=DB_fetch_array($resultnotice); 
    
if(empty($myrownotice[0]))
               {	
    $sqlnoticetxt = "INSERT INTO lw_noticecr(
		notice_no,
		noticetxt
		)
		VALUES ('".trim($_POST['Notice_no'])."',
		'".$Content."'
		)";
		
		$result = DB_query($sqlnoticetxt,$db);
		
		?>
	
<script>
		
swal({   title: "Notice created!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('lw_noticecr_alt.php'); //will redirect to your page
}, 2000); 


	</script>
                      
       <?php
    
} else 
{
    //make all changes in brief_file no if brief_file is changed in lw_cases
        $sql = "UPDATE lw_noticecr SET
                 noticetxt='".$Content."'
			 WHERE noticeid='".$myrownotice[0]."'";
		$result=DB_query($sql,$db);
		
		?>
		
		<script>
		
swal({   title: "Notice updated!",   text: "Will close in 2 seconds.",   timer: 2000,   showConfirmButton: false });

setTimeout(function () {
  window.location.assign('lw_noticecr_alt.php'); //will redirect to your page
}, 2000); 


	</script>
                      
       <?php
 }
    
}
}
            
?>       

<div class="md-input-wrapper"><div class="md-card"><div class="md-card-content">

<div class="uk-width-medium-1-1" style="padding-bottom:0px">
<div class="uk-grid uk-grid-width-1-1 uk-grid-width-large-1-1">



        <div class="uk-width-medium-1-1" style="padding-bottom:10px; padding-top:10px; margin-left:20px"><h2>Notice Editor</h2></div>
        <form method="POST" class="casesform" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <div class="uk-width-medium-1-2" style="padding-bottom:10px; padding-top:10px; margin-left:20px"><input type="text" class="md-input" name="Notice_no" id="Notice_no" placeholder="Type here notice no. ex- N0001/02/2018 or N(BR_0001/2018)/02/2018"></div>
           <div class="uk-width-medium-1-2" style="padding-bottom:10px; padding-top:10px; margin-left:20px"></div>
                </form>
                   

            
            
 <form method='POST' name='noticeform' action="<?php echo $_SERVER['PHP_SELF']  . '?' . SID ; ?>">
     
       
      <!--<div class="uk-width-medium-1-4" style="padding-bottom:0px">

     <input type="hidden" name="Notice_noinsert" id="Notice_noinsert" class="md-input" tabindex="2"></div> -->

 <div class="uk-width-medium-1-1" style="padding-bottom:10px; padding-top:10px; padding-left:10px; padding-right:10px; overflow:scroll"><textarea  id="elm1" name="elm1"><?php echo $Content;?></textarea></div>
  
<br />
 <div class="uk-width-medium-1-2" style="padding-bottom:10px; padding-top:10px; margin-left:20px"><input type="submit" name="save" class="md-btn md-btn-primary" value="Save" /></div>
 <div class="uk-width-medium-1-2" style="padding-bottom:10px; padding-top:10px; margin-left:20px"><input type="reset" name="reset" class="md-btn md-btn-primary" value="Reset" /></div>
</form>

        </div>
 </div> </div> </div> </div>

  <!-- Search Form Demo -->
  <?php include("footersrc.php");      ?>
   
   
     <script src="print.js"></script>
 
    <!-- JQuery-UI -->
    <link rel="stylesheet" href="assets/skins/jquery-ui/material/jquery-ui.min.css">
    <script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
    <!-- jTable -->
    <link rel="stylesheet" href="assets/skins/jtable/jtable.css">
    <script src="bower_components/jtable/lib/jquery.jtable.js"></script>
    
 <script src="sweetalert.min.js"></script>
   
</body>
</html>