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
	

$PageSecurity = 2;

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
    <link rel="stylesheet" href="assets/css/main.css" media="all">
    
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
    <style type="text/css">
<!--
.style1 {
	color: #000000;
	font-style: italic;
}
.style2 {
	font-size: 16px;
	font-weight: bold;
}
-->
    </style>
</head>
<body class=" sidebar_main_open sidebar_main_swipe">
     <?php include("header.php"); ?>
    <?php include("menu.php"); ?>
    
    
    
    <div id="page_content">
        <div id="page_content_inner">
    <!-- new table for report options ------------------------------------------------------------------>
         
            <div class="md-card ">
                <div class="md-card-content">
                
							
<?php echo '<form method="post" action="' . $_SERVER["PHP_SELF"] . '" >'; ?>

                    <div class="uk-overflow-container">
                        <table class="uk-table uk-table-condensed">
                          
<tr>
<td><input type="submit" value="1. Theory and Practice of Documentation" name="part1" class="uk-float-left md-btn md-btn-flat md-btn-flat-primary"/></td>
<td>
<a class="md-btn md-btn-flat md-btn-flat-primary" href="deeds/8.docx">8. ADDRESS FORM</a>
</td>


</tr>

<tr>
<td><input type="submit" value="2. Deeds relating to Immoveable Property" name="part2" class="uk-float-left md-btn md-btn-flat md-btn-flat-primary"/>
</td>
<td><a class="md-btn md-btn-flat md-btn-flat-primary" href="deeds/9.docx">9. MEMO OF APPEARANCE</a>
</td>
</tr>

<tr>
<td><input type="submit" value="3. Documents Relating to Moveable Property" name="part3" class="uk-float-left md-btn md-btn-flat md-btn-flat-primary"/>
</td>
<td><a class="md-btn md-btn-flat md-btn-flat-primary" href="deeds/10.docx">10. VAKALATNAMA</a></td>
</tr>

<tr>
<td><input type="submit" value="4. Documents Relating to Contracts" name="part4" class="uk-float-left md-btn md-btn-flat md-btn-flat-primary"/>
</td>
<td><a class="md-btn md-btn-flat md-btn-flat-primary" href="deeds/11.docx">11. PROCESS FEE</a></td>
</tr>

<tr>
<td><input type="submit" value="5. Company, Corporation and Society" name="part5" class="uk-float-left md-btn md-btn-flat md-btn-flat-primary"/>
</td>

<td><a class="md-btn md-btn-flat md-btn-flat-primary" href="deeds/12.docx">12. DOCUMENT FILLED BY PLAINTIFF AND DEFENDANT</a></td>

</tr>

<tr>
<td><input type="submit" value="6. Shipping Documents" name="part6" class="uk-float-left md-btn md-btn-flat md-btn-flat-primary"/>
</td>
<td><a class="md-btn md-btn-flat md-btn-flat-primary" href="deeds/13.docx">13. COPY FORM</a></td>
</tr>

<tr>
<td><input type="submit" value="7. Non Contractual Documents or Deeds Poll" name="part7" class="uk-float-left md-btn md-btn-flat md-btn-flat-primary" />
</td>
</tr>
</table>
                    </div>
                </div>
            </div><!-- Table ends -->
            
                <?php
				
if(isset($_POST['part1']))
		{
				 //----------------------------------Part 1----------------------------------
	
	   ?>
    
    
   <label style="color:#0000FF">PART I</label>

            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                
                  <div class="uk-overflow-container">
                 		<h2> Theory and Practice of Documentation</h2>
                        <h3>Chapter 4</h3>
                       <h3> Form, Parties & Contents of Deeds</h3>
                                               
			 
			            <table width="446" border="0"  class="uk-table uk-table-condensed">
                          <tr>
                            <td width="12">1.</td>
                            <td width="390">Certificate of Title</td>
                            <td width="30"><a href="deeds/Part I/77.doc">77</a></td>
                          </tr>
                          <tr>
                            <td>2.</td>
                            <td>Certificate of Title (Simple form)</td>
                            <td><a href="deeds/Part I/78.doc">78</a></td>
                          </tr>
                          <tr>
                            <td>3.</td>
                            <td>Certificate of Title (another sample)</td>
                            <td><a href="deeds/Part I/79.doc">79</a></td>
                          </tr>
                          <tr>
                            <td>4.</td>
                            <td>Certificate as to title and other matters (English form)</td>
                            <td><a href="deeds/Part I/80.doc">80</a></td>
                          </tr>
                        </table>
			          
                        <p>
                          <?php	
				}
			?>
                          
 <?php
				
if(isset($_POST['part2']))
		{
				 //----------------------------------Part 2----------------------------------
	
	   ?>
                     </p>
                        <p>
                          <label style="color:#0000FF">PART II</label>

                          <div class="md-card uk-margin-medium-bottom">
                          <div class="md-card-content">
                
                          <div class="uk-overflow-container">
                 		</p>
<h2>Deeds relating to Immoveable Property</h2>
                        <h3>Chapter 2 - Sale of Immoveable Property</h3>
<table width="446" border="0"  class="uk-table uk-table-condensed">
<tr>
                            <td width="50">1.</td>
    <td width="510">Agreement for sale of freehold property</td>
                            <td width="50"><a href="deeds/Part II/137.docx">137</a></td>
    <td width="50">15.</td>
                            <td width="510">Deed of Conveyance by a Mortgagee</td>
    <td width="50"><a href="deeds/Part II/175.docx">175</a></td>
  </tr>
                          <tr>
                            <td width="50">2.</td>
                            <td width="510">Another form of Agreement for Sale of free hold property</td>
                            <td width="50"><a href="deeds/Part II/140.docx">140</a></td>
                            <td width="50">16.</td>
                            <td width="510">Deed of Conveyance in favour of a Mortgagee</td>
                            <td width="50"><a href="deeds/Part II/178.docx">178</a></td>
  </tr>
                          <tr>
                            <td width="50">3.</td>
                            <td width="510">Agreement for sale of leasehold property</td>
                            <td width="50"><a href="deeds/Part II/143.docx">143</a></td>
                            <td width="50">17.</td>
                            <td width="510">Deed of Conveyance of an interest in property</td>
                            <td width="50"><a href="deeds/Part II/181.docx">181</a></td>
  </tr>
                          <tr>
                            <td width="50">4.</td>
                            <td width="510">Agreement for sale of plot in a development layout</td>
                            <td width="50"><a href="deeds/Part II/146.docx">146</a></td>
                            <td width="50">18</td>
                            <td width="510"> Deed of Conveyance of a part of the building</td>
                            <td width="50"><a href="deeds/Part II/183.docx">183</a></td>
  </tr>
                          <tr>
                            <td width="50">5.</td>
                            <td width="510">Agreement of Sub Sale</td>
                            <td width="50"><a href="deeds/Part II/149.docx">149</a></td>
                            <td width="50">19.</td>
                            <td width="510">Deed of Conveyance of a property exclusive of a flat or floor in the building - 187</td>
                            <td width="50"><a href="deeds/Part II/187.docx">187</a></td>
  </tr>
                          <tr>
                            <td width="50">6.</td>
                            <td width="510">Assignment of an agreement for sale</td>
                            <td width="50"><a href="deeds/Part II/152.docx">152</a></td>
                            <td width="50">20.</td>
                            <td width="510">Deed of sale of a plot of land in a lay out </td>
                            <td width="50"><a href="deeds/Part II/192.docx">192</a></td>
  </tr>
                          <tr>
                            <td width="50">7.</td>
                            <td width="510">Lockout Agreement</td>
                            <td width="50"><a href="deeds/Part II/154.docx">154</a></td>
                            <td width="50">21.</td>
                            <td width="510">Deed of Conveyance of a building with four flats to four purchasers as tenants in common </td>
                            <td width="50"><a href="deeds/Part II/196.docx">196</a></td>
  </tr>
                          <tr>
                            <td width="50">8.</td>
                            <td width="510">Agreement for right of pre-emption</td>
                            <td width="50"><a href="deeds/Part II/155.docx">155</a></td>
                            <td width="50">22.</td>
                            <td width="510">Deed of Conveyance of a flat in a building on apartment ownership but without a condominium </td>
                            <td width="50"><a href="deeds/Part II/199.docx">199</a></td>
  </tr>
                          <tr>
                            <td width="50">9.</td>
                            <td width="510">Particulars and conditions of sale by auction of immoveable property</td>
                            <td width="50"><a href="deeds/Part II/157.docx">157</a></td>
                            <td width="50">23.</td>
                            <td width="510">Deed of Conveyance by a legal guardian of a minor</td>
                            <td width="50"><a href="deeds/Part II/202.docx">202</a></td>
  </tr>
                          <tr>
                            <td width="50">10.</td>
                            <td width="510">Deed of Conveyance of freehold Property</td>
                            <td width="50"><a href="deeds/Part II/161.docx">161</a></td>
                            <td width="50">24.</td>
                            <td width="510">Deed of Conveyance by a lunatic through his Legal Guardian or Manager </td>
                            <td width="50"><a href="deeds/Part II/204.docx">204</a></td>
  </tr>
                          <tr>
                            <td width="50">11.</td>
                            <td width="510">Deed of Conveyance (where consideration is payable by instalments) </td>
                            <td width="50"><a href="deeds/Part II/163.docx">163</a></td>
                            <td width="50">25.</td>
                            <td width="510">Deed of Conveyance by the Official Liquidator of a Limited Company (in liquidation) </td>
                            <td width="50"><a href="deeds/Part II/206.docx">206</a></td>
  </tr>
                          <tr>
                            <td width="50">12.</td>
                            <td width="510">Deed of Conveyance subject to mortgage</td>
                            <td width="50"><a href="deeds/Part II/166.docx">166</a></td>
                            <td width="50">26.</td>
                            <td width="510">Deed of Conveyance by an Administrator of the estate of a deceased person</td>
                            <td width="50"><a href="deeds/Part II/208.docx">208</a></td>
  </tr>
                          <tr>
                            <td width="50">13.</td>
                            <td width="510">Deed of Conveyance of the Reversion</td>
                            <td width="50"><a href="deeds/Part II/169.docx">169</a></td>
                            <td width="50">27.</td>
                            <td width="510"> Deed of Conveyance (a sample of English Practice)</td>
                            <td width="50"><a href="deeds/Part II/210.docx">210</a></td>
  </tr>
                          <tr>
                            <td width="50">14.</td>
                            <td width="510">Deed of Conveyance subject to Right of Way</td>
                            <td width="50"><a href="deeds/Part II/172.docx">172</a></td>
                            <td width="50">&nbsp;</td>
                            <td width="510">&nbsp;</td>
                            <td width="50">&nbsp;</td>
  </tr>
                        </table>
			          
                        <h3>Chapter 3 - Mortgages</h3>
            <table width="446" border="0"  class="uk-table uk-table-condensed">
              <tr>
                            <td width="50">1.</td>
                            <td width="510">Agreement to Mortgage</td>
                <td width="50"><a href="deeds/Part II/250.docx">250</a></td>
                <td width="50">16.</td>
                <td width="510">Deed of Second Mortgage (Simple)</td>
                            <td width="50"><a href="deeds/Part II/325.docx">325</a></td>
              </tr>
                          <tr>
                            <td width="50">2.</td>
                            <td width="510">Agreement to Mortgage in letter form</td>
                            <td width="50"><a href="deeds/Part II/253.docx">253</a></td>
                            <td width="50">17.</td>
                            <td width="510">Deed of Transfer of Mortgage and Further charge</td>
                            <td width="50"><a href="deeds/Part II/328.docx">328</a></td>
              </tr>
                          <tr>
                            <td width="50">3.</td>
                            <td width="510">Deed of Simple Mortgage</td>
                            <td width="50"><a href="deeds/Part II/256.docx">256</a></td>
                            <td width="50">18.</td>
                            <td width="510">Deed of Transfer of Mortgage by Mortgagee</td>
                            <td width="50"><a href="deeds/Part II/332.docx">332</a></td>
              </tr>
                          <tr>
                            <td width="50">4.</td>
                            <td width="510">Deed of English Mortgage between an individual and a Firm of money lenders</td>
                            <td width="50"><a href="deeds/Part II/258.docx">258</a></td>
                            <td width="50">19</td>
                            <td width="510">Deed of Transfer of Mortgage at the instance of the Mortgagor</td>
                            <td width="50"><a href="deeds/Part II/334.docx">334</a></td>
              </tr>
                          <tr>
                            <td width="50">5.</td>
                            <td width="510">Deed of English Mortgage of leasehold property by Guarantor</td>
                            <td width="50"><a href="deeds/Part II/270.docx">270</a></td>
                            <td width="50">20..</td>
                            <td width="510">Transfer of Mortgage by one of the Consortium Mortgagees</td>
                            <td width="50"><a href="deeds/Part II/337.docx">337</a></td>
              </tr>
                          <tr>
                            <td width="50">6.</td>
                            <td width="510">Deed of English Mortgage for corporate sector</td>
                            <td width="50"><a href="deeds/Part II/277.docx">277</a></td>
                            <td width="50">21.</td>
                            <td width="510">Deed of Sub Mortgage</td>
                            <td width="50"><a href="deeds/Part II/344.docx">344</a></td>
              </tr>
                          <tr>
                            <td width="50">7.</td>
                            <td width="510">Short form of an English Mortgage</td>
                            <td width="50"><a href="deeds/Part II/294.docx">294</a></td>
                            <td width="50">22.</td>
                            <td width="510">Deed of Charge (for a debt)</td>
                            <td width="50"><a href="deeds/Part II/348.docx">348</a></td>
              </tr>
                          <tr>
                            <td width="50">8.</td>
                            <td width="510">Pari Passu Agreement</td>
                            <td width="50"><a href="deeds/Part II/297.docx">297</a></td>
                            <td width="50">23.</td>
                            <td width="510">Deed of Contingent Charge</td>
                            <td width="50"><a href="deeds/Part II/350.docx">350</a></td>
              </tr>
                          <tr>
                            <td width="50">9.</td>
                            <td width="510">Record of mortgage by deposit of title deeds</td>
                            <td width="50"><a href="deeds/Part II/307.docx">307</a></td>
                            <td width="50">24.</td>
                            <td width="510">Deed of Charge</td>
                            <td width="50"><a href="deeds/Part II/351.docx">351</a></td>
              </tr>
                          <tr>
                            <td width="50">10.</td>
                            <td width="510">Memorandum of agreement of equitable mortgage</td>
                            <td width="50"><a href="deeds/Part II/308.docx">308</a></td>
                            <td width="50">25.</td>
                            <td width="510">Deed of Reconveyance</td>
                            <td width="50"><a href="deeds/Part II/352.docx">352</a></td>
              </tr>
                          <tr>
                            <td width="50">11.</td>
                            <td width="510">Deed of Mortgage by conditional Sale</td>
                            <td width="50"><a href="deeds/Part II/310.docx">310</a></td>
                            <td width="50">26.</td>
                            <td width="510">Deed of Reconveyance by a substituted Mortgagee</td>
                            <td width="50"><a href="deeds/Part II/354.docx">354</a></td>
              </tr>
                          <tr>
                            <td width="50">12.</td>
                            <td width="510">Deed of usufructuary mortgage</td>
                            <td width="50"><a href="deeds/Part II/312.docx">312</a></td>
                            <td width="50">27.</td>
                            <td width="510">Deed of Release</td>
                            <td width="50"><a href="deeds/Part II/356.docx">356</a></td>
              </tr>
                          <tr>
                            <td width="50">13.</td>
                            <td width="510">Deed of Anomalous mortgage</td>
                            <td width="50"><a href="deeds/Part II/315.docx">315</a></td>
                            <td width="50">28.</td>
                            <td width="510">Deed of Release of a Charge</td>
                            <td width="50"><a href="deeds/Part II/357.docx">357</a></td>
              </tr>
                          <tr>
                            <td width="50">14.</td>
                            <td width="510">Deed of Mortgage by way of Substituted Security</td>
                            <td width="50"><a href="deeds/Part II/319.docx">319</a></td>
                            <td width="50">29.</td>
                            <td width="510">Agreement to modify Deed of Mortgage</td>
                            <td width="50"><a href="deeds/Part II/358.docx">358</a></td>
              </tr>
                          <tr>
                            <td width="50">15.</td>
                            <td width="510">Deed of Mortgage by way of Additional Security</td>
                            <td width="50"><a href="deeds/Part II/322.docx">322</a></td>
                            <td width="50">&nbsp;</td>
                            <td width="510">&nbsp;</td>
                            <td width="50">&nbsp;</td>
              </tr>
                        </table>
            <h3>Chapter 4 - 
Leases</h3>
            <table width="446" border="0"  class="uk-table uk-table-condensed">
              <tr>
                <td width="50">1.</td>
                <td width="510">Agreement for letting furnished dwelling house or flat on short period tenancy</td>
                <td width="50"><a href="deeds/Part II/393.docx">393</a> </td>
                <td width="50">11.</td>
                <td width="510">Mining Lease for quarrying stones</td>
                <td width="50"><a href="deeds/Part II/427.docx">427</a></td>
              </tr>
              <tr>
                <td width="50">2.</td>
                <td width="510">Agreement to lease for a long period</td>
                <td width="50"><a href="deeds/Part II/396.docx">396</a></td>
                <td width="50">12.</td>
                <td width="510">Deed of lease for Plantation</td>
                <td width="50"><a href="deeds/Part II/431.docx">431</a></td>
              </tr>
              <tr>
                <td width="50">3.</td>
                <td width="510">Agreement for Building lease</td>
                <td width="50"><a href="deeds/Part II/398.docx">398</a></td>
                <td width="50">13.</td>
                <td width="510">Agreement of lease of an orchard</td>
                <td width="50"><a href="deeds/Part II/435.docx">435</a></td>
              </tr>
              <tr>
                <td width="50">4.</td>
                <td width="510">Deed of Lease for a term of years</td>
                <td width="50"><a href="deeds/Part II/401.docx">401</a></td>
                <td width="50">14.</td>
                <td width="510">Deed of Sub-Lease or under lease</td>
                <td width="50"><a href="deeds/Part II/437.docx">437</a></td>
              </tr>
              <tr>
                <td width="50">5.</td>
                <td width="510">Deed of Lease for a term in Perpetuity</td>
                <td width="50"><a href="deeds/Part II/404.docx">404</a></td>
                <td width="50">15..</td>
                <td width="510"> Agreement to Modify Lease</td>
                <td width="50"><a href="deeds/Part II/440.docx">440</a></td>
              </tr>
              <tr>
                <td width="50">6.</td>
                <td width="510">Deed of Lease for Life time of the Lessee</td>
                <td width="50"><a href="deeds/Part II/408.docx">408</a></td>
                <td width="50">16.</td>
                <td width="510">Deed of Assignment of Lease</td>
                <td width="50"><a href="deeds/Part II/441.docx">441</a></td>
              </tr>
              <tr>
                <td width="50">7.</td>
                <td width="510">Deed of Building Lease</td>
                <td width="50"><a href="deeds/Part II/411.docx">411</a></td>
                <td width="50">17.</td>
                <td width="510">Deed of surrender of lease of the whole property</td>
                <td width="50"><a href="deeds/Part II/444.docx">444</a></td>
              </tr>
              <tr>
                <td width="50">8.</td>
                <td width="510">Deed of Lease by Tenant Ownership Co-operative Housing Society to its members</td>
                <td width="50"><a href="deeds/Part II/415.docx">415</a></td>
                <td width="50">18.</td>
                <td width="510">Deed of Surrender of Lease of a part of property</td>
                <td width="50"><a href="deeds/Part II/446.docx">446</a></td>
              </tr>
              <tr>
                <td width="50">9.</td>
                <td width="510">Lease of a floor premises</td>
                <td width="50"><a href="deeds/Part II/420.docx">420</a></td>
                <td width="50">19.</td>
                <td width="510">Deed of Sureender of a Part of the Premises in consideration of grant of Lease of some other Premises</td>
                <td width="50"><a href="deeds/Part II/448.docx">448</a></td>
              </tr>
              <tr>
                <td width="50">10.</td>
                <td width="510">Deed of Lease of space for advertisement</td>
                <td width="50"><a href="deeds/Part II/424.docx">424</a></td>
                <td width="50">20.</td>
                <td width="510">Agreement for splitting up of lease</td>
                <td width="50"><a href="deeds/Part II/451.docx">451</a></td>
              </tr>
            </table>
            <h3>Chapter 5 - Gift</h3>
            <table width="446" border="0"  class="uk-table uk-table-condensed">
              <tr>
                <td width="50">1.</td>
                <td width="510">Deed of Gift of moveable property</td>
                <td width="50"><a href="deeds/Part II/461.docx">461</a></td>
                <td width="50">5.</td>
                <td width="510">Revokable deed of Gift</td>
                <td width="50"><a href="deeds/Part II/467.docx">467</a></td>
              </tr>
              <tr>
                <td width="50">2.</td>
                <td width="510">Record of a Gift of moveables</td>
                <td width="50"><a href="deeds/Part II/462.docx">462</a></td>
                <td width="50">6.</td>
                <td width="510">Deed of Gift to a universal Donee</td>
                <td width="50"><a href="deeds/Part II/469.docx">469</a></td>
              </tr>
              <tr>
                <td width="50">3.</td>
                <td width="510">Deed of Gift of immoveable property</td>
                <td width="50"><a href="deeds/Part II/463.docx">463</a></td>
                <td width="50">7.</td>
                <td width="510">Deed of Gift of shares and securities</td>
                <td width="50"><a href="deeds/Part II/471.docx">471</a></td>
              </tr>
              <tr>
                <td width="50">4.</td>
                <td width="510">Deed of Conditional Gift</td>
                <td width="50"><a href="deeds/Part II/465.docx">465</a></td>
                <td width="50">&nbsp;</td>
                <td width="510">&nbsp;</td>
                <td width="50">&nbsp;</td>
              </tr>
            </table>
<h3>Chapter 6 - Exchange of Properties</h3>
            <table width="446" border="0"  class="uk-table uk-table-condensed">
              <tr>
                <td width="50">1.</td>
                <td width="510">Agreement for Exchange of Properties</td>
                <td width="50"><a href="deeds/Part II/476.docx">476</a></td>
                <td width="50">5.</td>
                <td width="510">Deed of Exchange of properties one being subject to mortgage &amp; other subject to lease</td>
                <td width="50"><a href="deeds/Part II/489.docx">489</a></td>
              </tr>
              <tr>
                <td width="50">2.</td>
                <td width="510">Deed of Exchange of two Properties</td>
                <td width="50"><a href="deeds/Part II/478.docx">478</a></td>
                <td width="50">6.</td>
                <td width="510">Deed of Exchange in the nature of partition</td>
                <td width="50"><a href="deeds/Part II/493.docx">493</a></td>
              </tr>
              <tr>
                <td width="50">3.</td>
                <td width="510">Deed of Exchange for Adjustment of boundaries</td>
                <td width="50"><a href="deeds/Part II/482.docx">482</a></td>
                <td width="50">7.</td>
                <td width="510">Deed of Exchange of mortgaged properties</td>
                <td width="50"><a href="deeds/Part II/497.docx">497</a></td>
              </tr>
              <tr>
                <td width="50">4.</td>
                <td width="510">Deed of Exchange of moveable &amp; immoveable properties</td>
                <td width="50"><a href="deeds/Part II/486.docx">486</a></td>
                <td width="50">&nbsp;</td>
                <td width="510">&nbsp;</td>
                <td width="50">&nbsp;</td>
              </tr>
            </table>
            <h3>Chapter 7 - 
              Trusts</h3>
            <table width="446" border="0"  class="uk-table uk-table-condensed">
              <tr>
                <td width="50">1.</td>
                <td width="510">Declaration of Trust (Private)</td>
                <td width="50"><a href="deeds/Part II/520.docx">520</a></td>
                <td width="50">8.</td>
                <td width="510">Deed of Trust of temple property</td>
                <td width="50"><a href="deeds/Part II/566.docx">566</a></td>
              </tr>
              <tr>
                <td width="50">2.</td>
                <td width="510">Declaration of Trust (Public)</td>
                <td width="50"><a href="deeds/Part II/524.docx">524</a></td>
                <td width="50">9.</td>
                <td width="510">Deed of Family Trust</td>
                <td width="50"><a href="deeds/Part II/573.docx">573</a></td>
              </tr>
              <tr>
                <td width="50">3.</td>
                <td width="510">Deed of Private Trust</td>
                <td width="50"><a href="deeds/Part II/531.docx">531</a></td>
                <td width="50">10.</td>
                <td width="510">Trust Deed of A Rotary Club</td>
                <td width="50"><a href="deeds/Part II/577.docx">577</a></td>
              </tr>
              <tr>
                <td width="50">4.</td>
                <td width="510">Deed of Public Trust</td>
                <td width="50"><a href="deeds/Part II/537.docx">537</a></td>
                <td width="50">11.</td>
                <td width="510">Deed of Revokable Trust</td>
                <td width="50"><a href="deeds/Part II/589.docx">589</a></td>
              </tr>
              <tr>
                <td width="50">5.</td>
                <td width="510">Deed of Public Trust for educational objects</td>
                <td width="50"><a href="deeds/Part II/547.docx">547</a></td>
                <td width="50">12..</td>
                <td width="510">Deed of Revokation of Trust</td>
                <td width="50"><a href="deeds/Part II/592.docx">592</a></td>
              </tr>
              <tr>
                <td width="50">6.</td>
                <td width="510">Deed of Trust (partly private and partly public) with power to carry on business</td>
                <td width="50"><a href="deeds/Part II/554.docx">554</a></td>
                <td width="50">13.</td>
                <td width="510">Deed of Appointment of New Trustees</td>
                <td width="50"><a href="deeds/Part II/593.docx">593</a></td>
              </tr>
              <tr>
                <td width="50">7.</td>
                <td width="510">Wakf Alal Aulad</td>
                <td width="50"><a href="deeds/Part II/564.docx">564</a></td>
                <td width="50">14.</td>
                <td width="510">Deed of Appointment of New Trustee without transfer of property</td>
                <td width="50"><a href="deeds/Part II/595.docx">595</a></td>
              </tr>
            </table>
            <h3>Chapter 8 - 
              Partition</h3>
            <table width="446" border="0"  class="uk-table uk-table-condensed">
              <tr>
                <td width="50">1.</td>
                <td width="510">Deed of Partition between two co-owners</td>
                <td width="50"><a href="deeds/Part II/610.docx">610</a></td>
                <td width="50">7.</td>
                <td width="510">Deed of separation of one party from the H.U.F.</td>
                <td width="50"><a href="deeds/Part II/631.docx">631</a></td>
              </tr>
              <tr>
                <td width="50">2.</td>
                <td width="510">Deed of Partition in consideration of owelty</td>
                <td width="50"><a href="deeds/Part II/613.docx">613</a></td>
                <td width="50">8.</td>
                <td width="510">Deed of partition of a common house and relinquishment</td>
                <td width="50"><a href="deeds/Part II/633.docx">637</a></td>
              </tr>
              <tr>
                <td width="50">3.</td>
                <td width="510">Deed of Partition ( notional )</td>
                <td width="50"><a href="deeds/Part II/615.docx">615</a></td>
                <td width="50">9.</td>
                <td width="510">Memorandum of oral partition</td>
                <td width="50"><a href="deeds/Part II/637.docx">637</a></td>
              </tr>
              <tr>
                <td width="50">4.</td>
                <td width="510">Deed of Partition reserving claim for maintenance and residence</td>
                <td width="50"><a href="deeds/Part II/618.docx">618</a></td>
                <td width="50">10.</td>
                <td width="510">Deed of Partition of properties subject to mortgage and lease</td>
                <td width="50"><a href="deeds/Part II/638.docx">638</a></td>
              </tr>
              <tr>
                <td width="50">5.</td>
                <td width="510">Deed of Partition between members of H.U.F.</td>
                <td width="50"><a href="deeds/Part II/622.docx">622</a></td>
                <td width="50">11..</td>
                <td width="510">Memorandum of Family Arrangement</td>
                <td width="50"><a href="deeds/Part II/641.docx">641</a></td>
              </tr>
              <tr>
                <td width="50">6.</td>
                <td width="510">Deed of partial partition</td>
                <td width="50"><a href="deeds/Part II/628.docx">628</a></td>
                <td width="50">&nbsp;</td>
                <td width="510">&nbsp;</td>
                <td width="50">&nbsp;</td>
              </tr>
            </table>
<h3>Chapter 9 - Leave and Licence</h3>
            <table width="446" border="0"  class="uk-table uk-table-condensed">
              <tr>
                <td width="50">1.</td>
                <td width="510">Leave and Licence Agreement</td>
                <td width="50"><a href="deeds/Part II/661.docx">661</a></td>
                <td width="50">5.</td>
                <td width="510">Licence of premises for holding a trade exhibition</td>
                <td width="50"><a href="deeds/Part II/672.docx">672</a></td>
              </tr>
              <tr>
                <td width="50">2.</td>
                <td width="510">Leave and Licence Agreement to a Company for residence of its officers</td>
                <td width="50"><a href="deeds/Part II/664.docx">664</a></td>
                <td width="50">6.</td>
                <td width="510">Licence to Occupy Premises</td>
                <td width="50"><a href="deeds/Part II/674.docx">674</a></td>
              </tr>
              <tr>
                <td width="50">3.</td>
                <td width="510">Leave and Licence Agreement in respect of a part of the premises</td>
                <td width="50"><a href="deeds/Part II/667.docx">667</a></td>
                <td width="50">7.</td>
                <td width="510">Agreement for leave and licence (for commercial use)</td>
                <td width="50"><a href="deeds/Part II/676.docx">676</a></td>
              </tr>
              <tr>
                <td width="50">4.</td>
                <td width="510">Agreement of Licence of Godown for storage</td>
                <td width="50"><a href="deeds/Part II/670.docx">670</a></td>
                <td width="50">&nbsp;</td>
                <td width="510">&nbsp;</td>
                <td width="50">&nbsp;</td>
              </tr>
            </table>
            <h3>Chapter 10 - Ownership Flats and Development Agreements</h3>
            <table width="446" border="0"  class="uk-table uk-table-condensed">
              <tr>
                <td width="50">1.</td>
                <td width="510">Agreement for purchase of flat with builder</td>
                <td width="50"><a href="deeds/Part II/724.docx">724</a></td>
                <td width="50">15.</td>
                <td width="510">Development Agreement for extension to the existing building</td>
                <td width="50"><a href="deeds/Part II/802.docx">802</a></td>
              </tr>
              <tr>
                <td width="50">2.</td>
                <td width="510">Flat purchase Agreement</td>
                <td width="50"><a href="deeds/Part II/732.docx">732</a></td>
                <td width="50">16.</td>
                <td width="510">Agreement between Developer and tenant</td>
                <td width="50"><a href="deeds/Part II/807.docx">807</a></td>
              </tr>
              <tr>
                <td width="50">3.</td>
                <td width="510">Agreement for sale of flat between original buyer<br>
and new purchaser</td>
                <td width="50"><a href="deeds/Part II/733.docx">733</a></td>
                <td width="50">17.</td>
                <td width="510">Agreement of sub-development</td>
                <td width="50"><a href="deeds/Part II/811.docx">811</a></td>
              </tr>
              <tr>
                <td width="50">4.</td>
                <td width="510">Agreement for sale of flat by member of Co-op.<br>
Housing Society to a purchaser</td>
                <td width="50"><a href="deeds/Part II/735.docx">735</a></td>
                <td width="50">18.</td>
                <td width="510">Deed of Conveyance from the Owner of the Land direct in favour of the Co-op. Society of Flat Purchasers without the intervention of the Promoters</td>
                <td width="50"><a href="deeds/Part II/816.docx">816</a></td>
              </tr>
              <tr>
                <td width="50">5.</td>
                <td width="510">Agreement for sale of Apartment</td>
                <td width="50"><a href="deeds/Part II/738.docx">738</a></td>
                <td width="50">19.</td>
                <td width="510">Agreement for Removal of Apartment Ownership</td>
                <td width="50"><a href="deeds/Part II/822.docx">822</a></td>
              </tr>
              <tr>
                <td width="50">6.</td>
                <td width="510">Declaration of Apartment Ownership</td>
                <td width="50"><a href="deeds/Part II/746.docx">746</a></td>
                <td width="50">20.</td>
                <td width="510">Agreement for Substituting Security of an Apartment</td>
                <td width="50"><a href="deeds/Part II/825.docx">825</a></td>
              </tr>
              <tr>
                <td width="50">7.</td>
                <td width="510">Deed of (Transfer of) Apartment</td>
                <td width="50"><a href="deeds/Part II/752.docx">752</a></td>
                <td width="50">21.</td>
                <td width="510">Deed of Lease of a flat by Co-operative society to its member</td>
                <td width="50"><a href="deeds/Part II/828.docx">828</a></td>
              </tr>
              <tr>
                <td width="50">8.</td>
                <td width="510">Simple Mortgage of an ownership flat</td>
                <td width="50"><a href="deeds/Part II/757.docx">757</a></td>
                <td width="50">22.</td>
                <td width="510">Deed of Transfer (for conversion of Society into<br>
                Apartment Ownership)</td>
                <td width="50"><a href="deeds/Part II/832.docx">832</a></td>
              </tr>
              <tr>
                <td width="50">9.</td>
                <td width="510">Lease of ownership flat</td>
                <td width="50"><a href="deeds/Part II/760.docx">760</a></td>
                <td width="50"><p>23.</p>                </td>
                <td width="510">Deed of Trasnsfer (From Apartment ownership to the Society)</td>
                <td width="50"><a href="deeds/Part II/835.docx">835</a></td>
              </tr>
              <tr>
                <td width="50">10.</td>
                <td width="510">Bye-laws of a condominium</td>
                <td width="50"><a href="deeds/Part II/763.docx">763</a></td>
                <td width="50">24.</td>
                <td width="510">Declaration of Condominium of xyz, (under American System)</td>
                <td width="50"><a href="deeds/Part II/838.docx">838</a></td>
              </tr>
              <tr>
                <td width="50">11.</td>
                <td width="510">Development Agreement between Owner &amp; Developer</td>
                <td width="50"><a href="deeds/Part II/777.docx">777</a></td>
                <td width="50">25.</td>
                <td width="510">Articles of Incorporation of Condominium Association, Inc.</td>
                <td width="50"><a href="deeds/Part II/853.docx">853</a></td>
              </tr>
              <tr>
                <td width="50">12.</td>
                <td width="510">Development Agreement of vacant land within ceiling limit</td>
                <td width="50"><a href="deeds/Part II/783.docx">783</a></td>
                <td width="50">26.</td>
                <td width="510">Condominium Purchase agreement</td>
                <td width="50"><a href="deeds/Part II/864.docx">864</a></td>
              </tr>
              <tr>
                <td width="50">13.</td>
                <td width="510">Development Agreement of land with building</td>
                <td width="50"><a href="deeds/Part II/789.docx">789</a></td>
                <td width="50">27.</td>
                <td width="510">Form of Warranty Deed</td>
                <td width="50"><a href="deeds/Part II/869.docx">869</a></td>
              </tr>
              <tr>
                <td>14.</td>
                <td>Development Agreement in respect of vacant land held in excess of ceiling limit</td>
                <td><a href="deeds/Part II/794.docx">794</a></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
<h3>Chapter 11 - Easements - MODEL FORMS</h3>
            <table width="1016" border="0"  class="uk-table uk-table-condensed">
              <tr>
                <td width="50">1.</td>
                <td width="510">Deed of Grant of Right of way</td>
                <td width="50"><a href="deeds/Part II/877.docx">877</a></td>
                <td width="50">10.</td>
                <td width="510">Agreement for sharing riparian rights</td>
                <td width="50"><a href="deeds/Part II/895.docx">895</a></td>
              </tr>
              <tr>
                <td width="50">2.</td>
                <td width="510">Deed of Grant of Limited Right of Way by Way of Licence</td>
                <td width="50"><a href="deeds/Part II/879.docx">879</a></td>
                <td width="50">11.</td>
                <td width="510">Agreement for Licence to draw water from well</td>
                <td width="50">897</td>
              </tr>
              <tr>
                <td width="50">3.</td>
                <td width="510">Agreement of Easement of Air &amp; Light</td>
                <td width="50"><a href="deeds/Part II/881.docx">881</a></td>
                <td width="50">12.</td>
                <td width="510">Agreement as to right of Eaves Dropping </td>
                <td width="50"><a href="deeds/Part II/899.docx">899</a></td>
              </tr>
              <tr>
                <td width="50">4.</td>
                <td width="510">Grant of an Easement of Light &amp; Air</td>
                <td width="50"><a href="deeds/Part II/883.docx">883</a></td>
                <td width="50">13.</td>
                <td width="510">Agreement for easement of support</td>
                <td width="50"><a href="deeds/Part II/900.docx">900</a></td>
              </tr>
              <tr>
                <td width="50">5.</td>
                <td width="510">5. Agreement for limited Light &amp; Air</td>
                <td width="50"><a href="deeds/Part II/885.docx">885</a></td>
                <td width="50">14.</td>
                <td width="510">Grant of right of sewage &amp; drainage</td>
                <td width="50"><a href="deeds/Part II/902.docx">902</a></td>
              </tr>
              <tr>
                <td width="50">6.</td>
                <td width="510">Agreement between two adjoining owners for Air &amp; light</td>
                <td width="50"><a href="deeds/Part II/887.docx">887</a></td>
                <td width="50">15.</td>
                <td width="510">Agreement of release of right of way</td>
                <td width="50"><a href="deeds/Part II/904.docx">904</a></td>
              </tr>
              <tr>
                <td width="50">7.</td>
                <td width="510">Licence to use light &amp; air</td>
                <td width="50"><a href="deeds/Part II/889.docx">889</a></td>
                <td width="50">16.</td>
                <td width="510">Agreement of release of easement of air and light</td>
                <td width="50"><a href="deeds/Part II/905.docx">905</a></td>
              </tr>
              <tr>
                <td width="50">8.</td>
                <td width="510">Agreement to remove obstruction to light and air</td>
                <td width="50"><a href="deeds/Part II/890.docx">890</a></td>
                <td width="50">17.</td>
                <td width="510">Deed of exchange of one right of way for another</td>
                <td width="50"><a href="deeds/Part II/907.docx">907</a></td>
              </tr>
              <tr>
                <td width="50">9.</td>
                <td width="510">Agreement of Lease of riparian right to draw water</td>
                <td width="50"><a href="deeds/Part II/892.docx">892</a></td>
                <td width="50">18.</td>
                <td width="510">Agreement of Party wall</td>
                <td width="50"><a href="deeds/Part II/909.docx">909</a></td>
              </tr>
            </table>
            <h3>Chapter 12 - <span class="style1">Anicillary Documents</span><span class="style2"> - 911</span></h3>
            <h1 class="style2">Section 1 - Convenant for Production Of Documents</h1>
<table width="518" border="0"  class="uk-table uk-table-condensed">
              <tr>
                <td width="50">1.</td>
                <td width="510">Deed of Covenant for Production of Documents</td>
                <td width="50"><a href="deeds/Part II/914.docx">914</a></td>
                <td width="50">2.</td>
                <td width="510">Deed of Substituted Covenant for Production of the Title Deeds</td>
                <td width="50"><a href="deeds/Part II/916.docx">916</a></td>
              </tr>
            </table>
<p><span class="style2">Section 2 - Deeds of Confirmation, Rectification and Cancellation</span></p>
<table width="1246" border="0"  class="uk-table uk-table-condensed">
  <tr>
    <td width="50">1.</td>
    <td width="510">Deed of Confirmation by Vendor</td>
    <td width="50"><a href="deeds/Part II/923.docx">923</a></td>
    <td width="50">7.</td>
    <td width="510">Deed of Confirmation by Owner of Conveyance by Attorney</td>
    <td width="50"><a href="deeds/Part II/935.docx">935</a></td>
  </tr>
  <tr>
    <td width="50">2.</td>
    <td width="510">Deed of Confirmation of Sale by Trustees</td>
    <td width="50"><a href="deeds/Part II/925.docx">925</a></td>
    <td width="50">8.</td>
    <td width="510">Deed of Confirmation by HUF, Members</td>
    <td width="50"><a href="deeds/Part II/937.docx">937</a></td>
  </tr>
  <tr>
    <td width="50">3.</td>
    <td width="510">Deed of Confirmation by Lessor of Assignment</td>
    <td width="50"><a href="deeds/Part II/927.docx">927</a></td>
    <td width="50">9.</td>
    <td width="510">Deed of Rectification of mistakes</td>
    <td width="50"><a href="deeds/Part II/939.docx">939</a></td>
  </tr>
  <tr>
    <td>4.</td>
    <td width="510">Deed of Confirmation by a trustee of Lease Granted by other Trustees</td>
    <td width="50">928</td>
    <td>10.</td>
    <td>Deed of Rectification of a Lease</td>
    <td><a href="deeds/Part II/941.docx">941</a></td>
  </tr>
  <tr>
    <td>5.</td>
    <td width="510">Deed of Confirmation of a Deed with a Wrong Schedule</td>
    <td width="50"><a href="deeds/Part II/931.docx">931</a></td>
    <td>11.</td>
    <td>Deed of Cancellation</td>
    <td><a href="deeds/Part II/943.docx">943</a></td>
  </tr>
  <tr>
    <td>6.</td>
    <td width="510">Deed of Confirmation and Transfer by a Benamindar in Favour of the Real Owner</td>
    <td width="50"><a href="deeds/Part II/933.docx">933</a></td>
    <td>12.</td>
    <td>Deed of Cancellation (of Covenant for Production)</td>
    <td><a href="deeds/Part II/945.docx">945</a></td>
  </tr>
</table>
<p><span class="style2">Section 3 - Declaration</span></p>
<table width="1246" border="0"  class="uk-table uk-table-condensed">
  <tr>
    <td width="50">1.</td>
    <td width="510">Declaration as to Birth Date</td>
    <td width="50"><a href="deeds/Part II/950.docx">950</a></td>
    <td width="50">7.</td>
    <td width="510">Declaration as to alterations</td>
    <td width="50"><a href="deeds/Part II/955.docx">955</a></td>
  </tr>
  <tr>
    <td width="50">2.</td>
    <td width="510">Declaration of Execution of Will</td>
    <td width="50"><a href="deeds/Part II/951.docx">951</a></td>
    <td width="50">8.</td>
    <td width="510">Declaration of no interest in property</td>
    <td width="50"><a href="deeds/Part II/956.docx">956</a></td>
  </tr>
  <tr>
    <td width="50">3.</td>
    <td width="510">Declaration as to heirship</td>
    <td width="50"><a href="deeds/Part II/952.docx">952</a></td>
    <td width="50">9.</td>
    <td width="510">Declaration of legal necessity</td>
    <td width="50"><a href="deeds/Part II/957.docx">957</a></td>
  </tr>
  <tr>
    <td>4.</td>
    <td width="510">Declaration for lost deed</td>
    <td width="50"><a href="deeds/Part II/953.docx">953</a></td>
    <td>10.</td>
    <td>Declaration claiming no interest in property</td>
    <td><a href="deeds/Part II/958.docx">958</a></td>
  </tr>
  <tr>
    <td>5.</td>
    <td width="510">Declaration for title deeds, destroyed by fire</td>
    <td width="50"><a href="deeds/Part II/954.docx">954</a></td>
    <td>11.</td>
    <td>Declaration about a person unheard of for seven years</td>
    <td><a href="deeds/Part II/959.docx">959</a></td>
  </tr>
</table>
<p><span class="style2">Section 4 - Releases</span></p>
<table width="1246" border="0"  class="uk-table uk-table-condensed">
  <tr>
    <td width="50">1.</td>
    <td width="510">Mutual Releases ( General Clause )</td>
    <td width="50"><a href="deeds/Part II/965.docx">965</a></td>
    <td width="50">8.</td>
    <td width="510">Release of an easement</td>
    <td width="50"><a href="deeds/Part II/973.docx">973</a></td>
  </tr>
  <tr>
    <td width="50">2.</td>
    <td width="510">Release of an interest in Immoveable property</td>
    <td width="50"><a href="deeds/Part II/966.docx">966</a></td>
    <td width="50">9.</td>
    <td width="510">Release of a restrictive covenant in a lease</td>
    <td width="50"><a href="deeds/Part II/974.docx">974</a></td>
  </tr>
  <tr>
    <td width="50">3.</td>
    <td width="510">Release of a share for Consideration</td>
    <td width="50"><a href="deeds/Part II/967.docx">967</a></td>
    <td>10.</td>
    <td width="510">Release of trustees on distribution of trust property</td>
    <td width="50"><a href="deeds/Part II/975.docx">975</a></td>
  </tr>
  <tr>
    <td>4.</td>
    <td width="510">Release of a claim for maintenance</td>
    <td width="50"><a href="deeds/Part II/968.docx">968</a></td>
    <td>11.</td>
    <td>Release of a guardian by his Ward</td>
    <td><a href="deeds/Part II/977.docx">977</a></td>
  </tr>
  <tr>
    <td>5.</td>
    <td width="510">Release of a life estate</td>
    <td width="50"><a href="deeds/Part II/969.docx">969</a></td>
    <td>12.</td>
    <td>Release of a contractor from his contract</td>
    <td><a href="deeds/Part II/978.docx">978</a></td>
  </tr>
  <tr>
    <td>6.</td>
    <td width="510">Release of a legacy</td>
    <td width="50"><a href="deeds/Part II/970.docx">970</a></td>
    <td>13.</td>
    <td>Release of a debtor by creditor</td>
    <td><a href="deeds/Part II/979.docx">979</a></td>
  </tr>
  <tr>
    <td>7.</td>
    <td>Release of Executors by residuary legatee</td>
    <td><a href="deeds/Part II/971.docx">971</a></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="1246" border="0"  class="uk-table uk-table-condensed">
  <tr>
    <td width="50">1.</td>
    <td width="510">Transfer from Executor to Legatee</td>
    <td width="50"><a href="deeds/Part II/982.docx">982</a></td>
    <td width="50">4.</td>
    <td width="510">Transfer by Trustees to Beneficiary</td>
    <td width="50"><a href="deeds/Part II/987.docx">987</a></td>
  </tr>
  <tr>
    <td width="50">2.</td>
    <td width="510">Transfer by Executor to a Residuary Legatee</td>
    <td width="50"><a href="deeds/Part II/983.docx">983</a></td>
    <td width="50">5.</td>
    <td width="510">Transfer by a benamidar to real owner</td>
    <td width="50"><a href="deeds/Part II/988.docx">988</a></td>
  </tr>
  <tr>
    <td width="50">3.</td>
    <td width="510">Transfer by Trustees to Charity</td>
    <td width="50"><a href="deeds/Part II/985.docx">985</a></td>
    <td>&nbsp;</td>
    <td width="510">&nbsp;</td>
    <td width="50">&nbsp;</td>
  </tr>
</table>
<p>
             <?php	
				}
			?>
</p>
            <p>
                          
            <?php
				
			if(isset($_POST['part3']))
			{
					 //----------------------------------Part 3----------------------------------
		
		   ?>
                          
                          
</p>
            <p>
             <label style="color:#0000FF">PART III</label>
            
            <div class="md-card uk-margin-medium-bottom">
            <div class="md-card-content">
                            
            <div class="uk-overflow-container">
            </p>
                       
                        
                        <h2>Documents Relating to Moveable Property</h2>
                        <h3>Chapter 2 - Sale of Goods or Moveable Property</h3>
                        <table width="446" border="0"  class="uk-table uk-table-condensed">
                          <tr>
                            <td width="50">1.</td>
                            <td width="510">Agreement for sale of ready goods</td>
                            <td width="50"><a href="deeds/Part III/1002.docx">1002</a></td>
                            <td width="50">5.</td>
                            <td width="510">Agreement for sale of goods under the buyer’s Trade Mark</td>
                            <td width="50"><a href="deeds/Part III/1010.docx">1010</a></td>
                          </tr>
                          <tr>
                            <td width="50">2.</td>
                            <td width="510">Agreement for sale of future goods</td>
                            <td width="50"><a href="deeds/Part III/1004.docx">1004</a></td>
                            <td width="50">6.</td>
                            <td width="510">Agreement for sale of technical equipment</td>
                            <td width="50"><a href="deeds/Part III/1013.docx">1013</a></td>
                          </tr>
                          <tr>
                            <td width="50">3.</td>
                            <td width="510">Agreement for sale of goods ( F. O. B. basis )</td>
                            <td width="50"><a href="deeds/Part III/1006.docx">1006</a></td>
                            <td width="50">7.</td>
                            <td width="510">Particulars of Conditions of sale by Auction of<br>
                            moveable property</td>
                            <td width="50"><a href="deeds/Part III/1016.docx">1016</a></td>
                          </tr>
                          <tr>
                            <td>4.</td>
                            <td>Agreement for sale of goods ( C.I.F. basis )</td>
                            <td><a href="deeds/Part III/1008.docx">1008</a></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                        </table>
                        <h3>Chapter 3 - Sale of Business</h3>
                        <table width="446" border="0"  class="uk-table uk-table-condensed">
                          <tr>
                            <td width="50">1.</td>
                            <td width="510">Agreement for Sale of Retail business with goodwill, book debts, equipment and Stock in Trade</td>
                            <td width="50"><a href="deeds/Part III/1024.docx">1024</a></td>
                            <td width="50">6.</td>
                            <td width="510">Agreement for sale and purchase of business</td>
                            <td width="50"><a href="deeds/Part III/1038.docx">1038</a></td>
                          </tr>
                          <tr>
                            <td width="50">2.</td>
                            <td width="510">Deed of assignment of business with tenancy right</td>
                            <td width="50"><a href="deeds/Part III/1026.docx">1026</a></td>
                            <td width="50">7.</td>
                            <td width="510">Agreement for sale of business between two Companies</td>
                            <td width="50"><a href="deeds/Part III/1041.docx">1041</a></td>
                          </tr>
                          <tr>
                            <td width="50">3.</td>
                            <td width="510">Deed of Assignment of business and premises held on ownership</td>
                            <td width="50"><a href="deeds/Part III/1029.docx">1029</a></td>
                            <td width="50">8.</td>
                            <td width="510">Shop conducting agreement</td>
                            <td width="50"><a href="deeds/Part III/1043.docx">1043</a></td>
                          </tr>
                          <tr>
                            <td width="50">4.</td>
                            <td width="510">Deed of Assignment of business and premises held on lease</td>
                            <td width="50"><a href="deeds/Part III/1032.docx">1032</a></td>
                            <td width="50">9.</td>
                            <td width="510">Agreement for sale of a secret process</td>
                            <td width="50"><a href="deeds/Part III/1046.docx">1046</a></td>
                          </tr>
                          <tr>
                            <td width="50">5.</td>
                            <td width="510">Assignment of Business to a Limited Company taking over without Premises</td>
                            <td width="50"><a href="deeds/Part III/1035.docx">1035</a></td>
                            <td width="50"><p>&nbsp;</p>
                            </td>
                            <td width="510">&nbsp;</td>
                            <td width="50">&nbsp;</td>
                          </tr>
                        </table>
                        <h3>Chapter 4 - Hypothecation and Pledge</h3>
                        <table width="446" border="0"  class="uk-table uk-table-condensed">
                          <tr>
                            <td width="50">1.</td>
                            <td width="510">Hypothecation of Goods to secure cash credit facility</td>
                            <td width="50"><a href="deeds/Part III/1055.docx">1055</a></td>
                            <td width="50">6.</td>
                            <td width="510">Agreement of Pledge</td>
                            <td width="50"><a href="deeds/Part III/1076.docx">1076</a></td>
                          </tr>
                          <tr>
                            <td width="50">2.</td>
                            <td width="510">Hypothecation of property to be imported</td>
                            <td width="50"><a href="deeds/Part III/1064.docx">1064</a></td>
                            <td width="50">7.</td>
                            <td width="510">Simple writing of pledge</td>
                            <td width="50"><a href="deeds/Part III/1082.docx">1082</a></td>
                          </tr>
                          <tr>
                            <td width="50">3.</td>
                            <td width="510">Deed of hypothecation of a vehicle</td>
                            <td width="50"><a href="deeds/Part III/1066.docx">1066</a></td>
                            <td width="50">8.</td>
                            <td width="510">Stock/Shares Pledge Agreement</td>
                            <td width="50"><a href="deeds/Part III/1083.docx">1083</a></td>
                          </tr>
                          <tr>
                            <td width="50">4.</td>
                            <td width="510">Simple writing of Hypothecation</td>
                            <td width="50"><a href="deeds/Part III/1069.docx">1069</a></td>
                            <td width="50">9.</td>
                            <td width="510">Trust Receipt</td>
                            <td width="50"><a href="deeds/Part III/1086.docx">1086</a></td>
                          </tr>
                          <tr>
                            <td width="50">5.</td>
                            <td width="510">Deed of Hypothecation</td>
                            <td width="50"><a href="deeds/Part III/1070.docx">1070</a></td>
                            <td width="50"><p>10.</p></td>
                            <td width="510">Agreement for Pleadge of Shares</td>
                            <td width="50"><a href="deeds/Part III/1087.docx">1087</a></td>
                          </tr>
                        </table>
                        <h3>Chapter 5 - Hire and Purchase Agreements</h3>
                        <table width="446" border="0"  class="uk-table uk-table-condensed">
                          <tr>
                            <td width="50">1.</td>
                            <td width="510">Agreement for hire</td>
                            <td width="50"><a href="deeds/Part III/1098.docx">1098</a></td>
                            <td width="50">8.</td>
                            <td width="510">Hire purchase agreement with vesting rights</td>
                            <td width="50"><a href="deeds/Part III/1126.docx">1126</a></td>
                          </tr>
                          <tr>
                            <td width="50">2.</td>
                            <td width="510">Hire purchase agreement</td>
                            <td width="50"><a href="deeds/Part III/1101.docx">1101</a></td>
                            <td width="50">9.</td>
                            <td width="510">Hire purchase agreement for live stock</td>
                            <td width="50"><a href="deeds/Part III/1129.docx">1129</a></td>
                          </tr>
                          <tr>
                            <td width="50">3.</td>
                            <td width="510">Hire purchase agreement for securing finance with guarantee</td>
                            <td width="50"><a href="deeds/Part III/1106.docx">1106</a></td>
                            <td width="50">10.</td>
                            <td width="510">Agreement of hire purchase of a Motor Truck</td>
                            <td width="50"><a href="deeds/Part III/1132.docx">1132</a></td>
                          </tr>
                          <tr>
                            <td width="50">4.</td>
                            <td width="510">Finance lease agreement of Plant and Machinery (with no option to Purchase)</td>
                            <td width="50"><a href="deeds/Part III/1112.docx">1112</a></td>
                            <td width="50">11.</td>
                            <td width="510">Agreement of daily hire of a Motor Car or Rickshaw</td>
                            <td width="50"><a href="deeds/Part III/1136.docx">1136</a></td>
                          </tr>
                          <tr>
                            <td width="50">5.</td>
                            <td width="510">Lease Finance agreement</td>
                            <td width="50"><a href="deeds/Part III/1117.docx">1117</a></td>
                            <td width="50">12.</td>
                            <td width="510">Assignment of hire purchase agreement</td>
                            <td width="50"><a href="deeds/Part III/1138.docx">1138</a></td>
                          </tr>
                          <tr>
                            <td width="50">6.</td>
                            <td width="510">Hire purchase agreement for furniture</td>
                            <td width="50"><a href="deeds/Part III/1123.docx">1123</a></td>
                            <td width="50">13.</td>
                            <td width="510">Agreement to guarantee payment under a hire purchase Agreement</td>
                            <td width="50"><a href="deeds/Part III/1140.docx">1140</a></td>
                          </tr>
                          <tr>
                            <td width="50">7.</td>
                            <td width="510">Hire purchase of a refrigerator</td>
                            <td width="50"><a href="deeds/Part III/1125.docx">1125</a></td>
                            <td width="50">&nbsp;</td>
                            <td width="510">&nbsp;</td>
                            <td width="50">&nbsp;</td>
                          </tr>
                        </table>

                        <h3>Chapter 6 - Copyrights</h3>
                        <table width="446" border="0"  class="uk-table uk-table-condensed">
                          <tr>
                            <td width="50">1.</td>
                            <td width="510">Assignment of a Copyright for Lumpsum</td>
                            <td width="50"><a href="deeds/Part III/1150.docx">1150</a></td>
                            <td width="50">12.</td>
                            <td width="510">Assignment of copyright for a specific territory</td>
                            <td width="50"><a href="deeds/Part III/1174.docx">1174</a></td>
                          </tr>
                          <tr>
                            <td width="50">2.</td>
                            <td width="510">Licence in the nature of Assignment of<br>
                            Copyright with Royalty</td>
                            <td width="50"><a href="deeds/Part III/1152.docx">1152</a></td>
                            <td width="50">13.</td>
                            <td width="510">Licence to translate book in another language</td>
                            <td width="50"><a href="deeds/Part III/1176.docx">1176</a></td>
                          </tr>
                          <tr>
                            <td width="50">3.</td>
                            <td width="510">Agreement to write a book and to sell copyright</td>
                            <td width="50"><a href="deeds/Part III/1154.docx">1154</a></td>
                            <td width="50">14.</td>
                            <td width="510">Reassignment of copyrights to the author</td>
                            <td width="50"><a href="deeds/Part III/1178.docx">1178</a></td>
                          </tr>
                          <tr>
                            <td width="50">4.</td>
                            <td width="510">Agreement of licence to publish on lump sum consideration</td>
                            <td width="50"><a href="deeds/Part III/1157.docx">1157</a></td>
                            <td width="50">15.</td>
                            <td width="510">Licence to dramatise a novel</td>
                            <td width="50"><a href="deeds/Part III/1179.docx">1179</a></td>
                          </tr>
                          <tr>
                            <td width="50">5.</td>
                            <td width="510">Agreement of Licence to publish on royalty basis</td>
                            <td width="50"><a href="deeds/Part III/1159.docx">1159</a></td>
                            <td width="50">16.</td>
                            <td width="510">Licence to perform a play</td>
                            <td width="50"><a href="deeds/Part III/1181.docx">1181</a></td>
                          </tr>
                          <tr>
                            <td width="50">6.</td>
                            <td width="510">Agreement for assignment of copyright for lumpsum payment and royalty</td>
                            <td width="50"><a href="deeds/Part III/1162.docx">1162</a></td>
                            <td width="50">17.</td>
                            <td width="510">Agreement to assign rights in music composition</td>
                            <td width="50"><a href="deeds/Part III/1183.docx">1183</a></td>
                          </tr>
                          <tr>
                            <td width="50">7.</td>
                            <td width="510">Assignment of a copyright by publisher</td>
                            <td width="50"><a href="deeds/Part III/1164.docx">1164</a></td>
                            <td width="50">18.</td>
                            <td width="510">Assignment of copyright in a novel for film,<br>
                            broadcasting and other rights</td>
                            <td width="50"><a href="deeds/Part III/1185.docx">1185</a></td>
                          </tr>
                          <tr>
                            <td>8.</td>
                            <td>Agreement between author and new publisher</td>
                            <td><a href="deeds/Part III/1165.docx">1165</a></td>
                            <td>19.</td>
                            <td>Agreement for writing a cinema script</td>
                            <td><a href="deeds/Part III/1188.docx">1188</a></td>
                          </tr>
                          <tr>
                            <td>9.</td>
                            <td>Agreement with publisher for publishing on commission basis</td>
                            <td><a href="deeds/Part III/1167.docx">1167</a></td>
                            <td>20.</td>
                            <td>Licence to publish a novel serially in a periodical</td>
                            <td><a href="deeds/Part III/1190.docx">1190</a></td>
                          </tr>
                          <tr>
                            <td>10.</td>
                            <td>Agreement between publisher and editor for re-editing a Book</td>
                            <td><a href="deeds/Part III/1170.docx">1170</a></td>
                            <td>21.</td>
                            <td>Assignment of copyright in a building plan and design</td>
                            <td><a href="deeds/Part III/1192.docx">1192</a></td>
                          </tr>
                          <tr>
                            <td>11.</td>
                            <td>Agreement between Publishers and Editor</td>
                            <td><a href="deeds/Part III/1172.docx">1172</a></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                        </table>
                        <h3>Chapter 7 - Trade Mark</h3>
                        <table width="446" border="0"  class="uk-table uk-table-condensed">
                          <tr>
                            <td width="50">1.</td>
                            <td width="510">Assignment of trade mark with goodwill</td>
                            <td width="50"><a href="deeds/Part III/1201.docx">1201</a></td>
                            <td width="50">4.</td>
                            <td width="510">Agreement of Licence to use a trade mark</td>
                            <td width="50"><a href="deeds/Part III/1208.docx">1208</a></td>
                          </tr>
                          <tr>
                            <td width="50">2.</td>
                            <td width="510">Assignment of trade mark without goodwill</td>
                            <td width="50"><a href="deeds/Part III/1203.docx">1203</a></td>
                            <td width="50">5.</td>
                            <td width="510">Agreement of Licence between trade mark owner and a manufacturer</td>
                            <td width="50"><a href="deeds/Part III/1210.docx">1210</a></td>
                          </tr>
                          <tr>
                            <td width="50">3.</td>
                            <td width="510">Assignment of application for registration of a trade mark</td>
                            <td width="50"><a href="deeds/Part III/1205.docx">1205</a></td>
                            <td width="50">&nbsp;</td>
                            <td width="510">&nbsp;</td>
                            <td width="50">&nbsp;</td>
                          </tr>
                        </table>
                        <h3>Chapter 8 - Patents</h3>
                        <table width="446" border="0"  class="uk-table uk-table-condensed">
                          <tr>
                            <td width="50">1.</td>
                            <td width="510">Agreement between joint patentees</td>
                            <td width="50"><a href="deeds/Part III/1222.docx">1222</a></td>
                            <td width="50">5.</td>
                            <td width="510">Assignment by a co patentee of his share</td>
                            <td width="50"><a href="deeds/Part III/1231.docx">1231</a></td>
                          </tr>
                          <tr>
                            <td width="50">2.</td>
                            <td width="510">Agreement for exploitation or assignment of a patent</td>
                            <td width="50"><a href="deeds/Part III/1224.docx">1224</a></td>
                            <td width="50">6.</td>
                            <td width="510">Licence to use a patent</td>
                            <td width="50"><a href="deeds/Part III/1232.docx">1232</a></td>
                          </tr>
                          <tr>
                            <td width="50">3.</td>
                            <td width="510">Deed of Assignment of patent</td>
                            <td width="50"><a href="deeds/Part III/1227.docx">1227</a></td>
                            <td width="50">7.</td>
                            <td width="510">Mortgage of a Patent</td>
                            <td width="50"><a href="deeds/Part III/1234.docx">1234</a></td>
                          </tr>
                          <tr>
                            <td>4.</td>
                            <td>Assignment of a patent for a particular area</td>
                            <td><a href="deeds/Part III/1229.docx">1229</a></td>
                            <td>8.</td>
                            <td>Assignment of License</td>
                            <td><a href="deeds/Part III/1237.docx">1237</a></td>
                          </tr>
                        </table>
                        <h3>Chapter 9 - Industrial Designs</h3>
                        <table width="446" border="0"  class="uk-table uk-table-condensed">
                          <tr>
                            <td width="50">1.</td>
                            <td width="510">Assignment of a design</td>
                            <td width="50"><a href="deeds/Part III/1243.docx">1243</a></td>
                          </tr>
                        </table>
                        <h3>Chapter 10 </h3>
                        <table width="446" border="0"  class="uk-table uk-table-condensed">
                          <tr>
                            <td width="50">1.</td>
                            <td width="510">Agreement for Grant of Know how</td>
                            <td width="50">1245</td>
                          </tr>
                        </table>
                        <h3>Chapter 11 - Actionable Claim</h3>
                        <table width="1246" border="0"  class="uk-table uk-table-condensed">
                          <tr>
                            <td width="50">1.</td>
                            <td width="510">Transfer of actionable claim by letter</td>
                            <td width="50"><a href="deeds/Part III/1256.docx">1256</a></td>
                            <td width="50">10.</td>
                            <td width="510">Assignment of decretal claim</td>
                            <td width="50"><a href="deeds/Part III/1269.docx">1269</a></td>
                          </tr>
                          <tr>
                            <td width="50">2.</td>
                            <td width="510">Transfer of actionable claim by letter</td>
                            <td width="50"><a href="deeds/Part III/1257.docx">1257</a></td>
                            <td width="50">11.</td>
                            <td width="510">Assignment of a money decree</td>
                            <td width="50"><a href="deeds/Part III/1270.docx">1270</a></td>
                          </tr>
                          <tr>
                            <td width="50">3.</td>
                            <td width="510">Assignment of a debt</td>
                            <td width="50"><a href="deeds/Part III/1258.docx">1258</a></td>
                            <td width="50">12.</td>
                            <td width="510">Assignment of book debts in favour of a Bank</td>
                            <td width="50"><a href="deeds/Part III/1272.docx">1272</a></td>
                          </tr>
                          <tr>
                            <td width="50">4.</td>
                            <td width="510">Assignment of a claim under a contract</td>
                            <td width="50"><a href="deeds/Part III/1260.docx">1260</a></td>
                            <td width="50">13.</td>
                            <td width="510">Assignment of Life policy by deed</td>
                            <td width="50"><a href="deeds/Part III/1274.docx">1274</a></td>
                          </tr>
                          <tr>
                            <td width="50">5.</td>
                            <td width="510">Assignment of a debt as security</td>
                            <td width="50"><a href="deeds/Part III/1262.docx">1262</a></td>
                            <td width="50">14.</td>
                            <td width="510">Assignment of policy by endorsement</td>
                            <td width="50"><a href="deeds/Part III/1275.docx">1275</a></td>
                          </tr>
                          <tr>
                            <td width="50">6.</td>
                            <td width="510">Assignment of arrears of rent</td>
                            <td width="50"><a href="deeds/Part III/1264.docx">1264</a></td>
                            <td width="50">15.</td>
                            <td width="510">Assignment of a Life policy as security by Deed</td>
                            <td width="50"><a href="deeds/Part III/1276.docx">1276</a></td>
                          </tr>
                          <tr>
                            <td width="50">7.</td>
                            <td width="510">Assignment of book debts</td>
                            <td width="50"><a href="deeds/Part III/1266.docx">1266</a></td>
                            <td width="50">16.</td>
                            <td width="510">Mortgage of Life Policy (another form)</td>
                            <td width="50"><a href="deeds/Part III/1278.docx">1278</a></td>
                          </tr>
                          <tr>
                            <td>8.</td>
                            <td>Assignment of debt on trust</td>
                            <td><a href="deeds/Part III/1267.docx">1267</a></td>
                            <td>17.</td>
                            <td>Assignment of Fire policy on Completion of Sale of Property</td>
                            <td width="50"><a href="deeds/Part III/1280.docx">1280</a></td>
                          </tr>
                          <tr>
                            <td>9.</td>
                            <td>Assignment of moveable property not in possession</td>
                            <td><a href="deeds/Part III/1268.docx">1268</a></td>
                            <td>18.</td>
                            <td>Assignment of a debt with a novatio</td>
                            <td><a href="deeds/Part III/1281.docx">1281</a></td>
                          </tr>
                        </table>

                 
<p>
            <?php	
                            }
            ?>
            
            <?php
                            
                if(isset($_POST['part4']))
                    {
                //----------------------------------Part4----------------------------------
                
            ?>
</p>
             <div class="md-card uk-margin-medium-bottom">
            <div class="md-card-content">
              <div class="uk-overflow-container">
                <p>
                  <label style="color:#0000FF"></label>
                  <label style="color:#0000FF">PART IV</label>
                <h2>Documents Relating to Contracts</h2>
                <h3>Chapter 2 - Bailment</h3>
                <h3>&nbsp;</h3>
                <table width="446" border="0"  class="uk-table uk-table-condensed">
                  <tr>
                    <td width="50">1.</td>
                    <td width="510">Agreement of bailment</td>
                    <td width="50"><a href="deeds/Part IV/1294.docx">1294</a></td>
                  </tr>
                </table>
                <p>&nbsp;</p>
                <h3>Chapter 3 - Indemnity and Guarantee</h3>
                <table width="446" border="0"  class="uk-table uk-table-condensed">
                  <tr>
                    <td width="50">1.</td>
                    <td width="510">Indemnity by a landowner whose title is in dispute</td>
                    <td width="50"><a href="deeds/Part IV/1302.docx">1302</a></td>
                    <td width="50">13.</td>
                    <td width="510">Guarantee for sale of goods</td>
                    <td width="50"><a href="deeds/Part IV/1317.docx">1317</a></td>
                  </tr>
                  <tr>
                    <td width="50">2.</td>
                    <td width="510">Indemnity by legatee to the executor</td>
                    <td width="50"><a href="deeds/Part IV/1303.docx">1303</a></td>
                    <td width="50">14.</td>
                    <td width="510">Guarantee by more than one person with limited liability</td>
                    <td width="50"><a href="deeds/Part IV/1319.docx">1319</a></td>
                  </tr>
                  <tr>
                    <td width="50">3.</td>
                    <td width="510">Indeminity for loss of title deeds</td>
                    <td width="50"><a href="deeds/Part IV/1304.docx">1304</a></td>
                    <td width="50">15.</td>
                    <td width="510">Guarantee for promising not to sue</td>
                    <td width="50"><a href="deeds/Part IV/1321.docx">1321</a></td>
                  </tr>
                  <tr>
                    <td>4.</td>
                    <td>Indemnity for a minor’s claim in the property</td>
                    <td><a href="deeds/Part IV/1305.docx">1305</a></td>
                    <td>16.</td>
                    <td>Guarantee for withdrawing legal proceedings</td>
                    <td><a href="deeds/Part IV/1322.docx">1322</a></td>
                  </tr>
                  <tr>
                    <td>5.</td>
                    <td>Indemnity by debtor to his guarantor</td>
                    <td><a href="deeds/Part IV/1306.docx">1306</a></td>
                    <td>17.</td>
                    <td>Guarantee for performance of a contract</td>
                    <td><a href="deeds/Part IV/1323.docx">1323</a></td>
                  </tr>
                  <tr>
                    <td>6.</td>
                    <td>Indemnity for loss of share certificate</td>
                    <td><a href="deeds/Part IV/1307.docx">1307</a></td>
                    <td>18.</td>
                    <td>Guarantee for payment of rent</td>
                    <td><a href="deeds/Part IV/1325.docx">1325</a></td>
                  </tr>
                  <tr>
                    <td>7.</td>
                    <td>Indemnity for loss of deposit receipt</td>
                    <td><a href="deeds/Part IV/1308.docx">1308</a></td>
                    <td>19.</td>
                    <td>Continuing guarantee to a bank to secure amount<br>
                      payable under cash credit facility</td>
                    <td><a href="deeds/Part IV/1326.docx">1326</a></td>
                  </tr>
                  <tr>
                    <td>8.</td>
                    <td>Indemnity for title</td>
                    <td><a href="deeds/Part IV/1309.docx">1309</a></td>
                    <td>20.</td>
                    <td>Guarantee for a debt secured by a mortgage</td>
                    <td><a href="deeds/Part IV/1328.docx">1328</a></td>
                  </tr>
                  <tr>
                    <td>9.</td>
                    <td>Indemnity by heirs of a deceased</td>
                    <td><a href="deeds/Part IV/1310.docx">1310</a></td>
                    <td>21.</td>
                    <td>Guarantee for payment of earnest money/ security deposit</td>
                    <td><a href="deeds/Part IV/1330.docx">1330</a></td>
                  </tr>
                  <tr>
                    <td>10.</td>
                    <td>Indemnity for loss of allotment letter</td>
                    <td><a href="deeds/Part IV/1311.docx">1311</a></td>
                    <td>22.</td>
                    <td>Guarantee to Secure Banking Account of a Firm</td>
                    <td><a href="deeds/Part IV/1332.docx">1332</a></td>
                  </tr>
                  <tr>
                    <td>11.</td>
                    <td> Deed of guarantee</td>
                    <td><a href="deeds/Part IV/1312.docx">1312</a></td>
                    <td>23.</td>
                    <td>Guarantee &amp; Indemnity</td>
                    <td><a href="deeds/Part IV/1334.docx">1334</a></td>
                  </tr>
                  <tr>
                    <td>12.</td>
                    <td>Fidelity guarantee</td>
                    <td>1313</td>
                    <td>24.</td>
                    <td>Counter Indemnity</td>
                    <td><a href="deeds/Part IV/1354.docx">1335</a></td>
                  </tr>
                </table>
                <p>&nbsp;</p>
                <h3>Chapter 4 - Agency Agreements</h3>
                <table width="446" border="0"  class="uk-table uk-table-condensed">
                  <tr>
                    <td width="50">1.</td>
                    <td width="510">Agreement between principal and sole selling agent</td>
                    <td width="50"><a href="deeds/Part IV/1344.docx">1344</a></td>
                    <td width="50">13.</td>
                    <td width="510">Agreement with commission agent</td>
                    <td width="50"><a href="deeds/Part IV/1363.docx">1363</a></td>
                  </tr>
                  <tr>
                    <td width="50">2.</td>
                    <td width="510">Agreement between manufacturer and a distributor</td>
                    <td width="50"><a href="deeds/Part IV/1350.docx">1350</a></td>
                    <td width="50">14.</td>
                    <td width="510">Agreement for appointment of an auctioneer</td>
                    <td width="50"><a href="deeds/Part IV/1366.docx">1366</a></td>
                  </tr>
                  <tr>
                    <td width="50">3.</td>
                    <td width="510">Agreement of Agency on del-credere basis</td>
                    <td width="50"><a href="deeds/Part IV/1354.docx">1354</a></td>
                    <td width="50">15.</td>
                    <td width="510">Agreement with a clearing agent</td>
                    <td width="50"><a href="deeds/Part IV/1368.docx">1368</a></td>
                  </tr>
                  <tr>
                    <td>4.</td>
                    <td>Agreement of Agency for purchase of goods from a specified area</td>
                    <td><a href="deeds/Part IV/1358.docx">1358</a></td>
                    <td>16.</td>
                    <td>Agreement of sub agency</td>
                    <td><a href="deeds/Part IV/1372.docx">1372</a></td>
                  </tr>
                  <tr>
                    <td>5.</td>
                    <td>Agreement with estate broker</td>
                    <td><a href="deeds/Part IV/1362.docx">1362</a></td>
                    <td>17.</td>
                    <td>Deed of assignment of an agency agreement</td>
                    <td><a href="deeds/Part IV/1375.docx">1375</a></td>
                  </tr>
                </table>
                <p>&nbsp;</p>
                <h3>Chapter 5 - Apprenticeship</h3>
                <table width="446" border="0"  class="uk-table uk-table-condensed">
                  <tr>
                    <td width="50">1.</td>
                    <td width="510">Apprenticeship agreement under Apprentice Act of 1961</td>
                    <td width="50"><a href="deeds/Part IV/1384.docx">1384</a></td>
                    <td width="50">5.</td>
                    <td width="510">Transfer of Apprenticeship agreement by employer</td>
                    <td width="50"><a href="deeds/Part IV/1394.docx">1394</a></td>
                  </tr>
                  <tr>
                    <td width="50">2.</td>
                    <td width="510">Ordinary Apprenticeship agreement</td>
                    <td width="50"><a href="deeds/Part IV/1387.docx">1387</a></td>
                    <td width="50">6.</td>
                    <td width="510">Appendice Agreement with an Engineering Company</td>
                    <td width="50"><a href="deeds/Part IV/1396.docx">1396</a></td>
                  </tr>
                  <tr>
                    <td width="50">3.</td>
                    <td width="510">Articles of clerkship with a solicitor</td>
                    <td width="50"><a href="deeds/Part IV/1390.docx">1390</a></td>
                    <td width="50">7.</td>
                    <td width="510">Agreement of Apprenticeship</td>
                    <td width="50"><a href="deeds/Part IV/1397.docx">1397</a></td>
                  </tr>
                  <tr>
                    <td>4.</td>
                    <td>Articles of Apprenticeship with Chartered Accountant</td>
                    <td><a href="deeds/Part IV/1392.docx">1392</a></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
                <h3>Chapter 6 - Service Contracts</h3>
                <table width="446" border="0"  class="uk-table uk-table-condensed">
                  <tr>
                    <td width="48">1.</td>
                    <td width="510">1. Contract of service with a Technician</td>
                    <td width="50"><a href="deeds/Part IV/1405.docx">1405</a></td>
                    <td width="50">6.</td>
                    <td width="510">Contract for service for lift maintenance</td>
                    <td width="50"><a href="deeds/Part IV/1421.docx">1421</a></td>
                  </tr>
                  <tr>
                    <td width="48">2.</td>
                    <td width="510">Contract of service with a cashier</td>
                    <td width="50"><a href="deeds/Part IV/1409.docx">1409</a></td>
                    <td width="50">7.</td>
                    <td width="510">Contract for service with a medical representative</td>
                    <td width="50"><a href="deeds/Part IV/1423.docx">1423</a></td>
                  </tr>
                  <tr>
                    <td width="48">3.</td>
                    <td width="510">Contract for service with consultant</td>
                    <td width="50"><a href="deeds/Part IV/1412.docx">1412</a></td>
                    <td width="50">8.</td>
                    <td width="510">Agreement for providing security guards</td>
                    <td width="50"><a href="deeds/Part IV/1426.docx">1426</a></td>
                  </tr>
                  <tr>
                    <td>4.</td>
                    <td width="510">Contract for service between printer and publisher</td>
                    <td width="50"><a href="deeds/Part IV/1417.docx">1417</a></td>
                    <td width="50">9</td>
                    <td width="510">Agreement between Solicitor and Client for Remuneration<br>
                      of Conveyancing Work</td>
                    <td width="50"><a href="deeds/Part IV/1429.docx">1429</a></td>
                  </tr>
                  <tr>
                    <td>5.</td>
                    <td width="510">Contract for service between printer and publisher</td>
                    <td width="50"><a href="deeds/Part IV/1419.docx">1419</a></td>
                    <td width="50">&nbsp;</td>
                    <td width="510">&nbsp;</td>
                    <td width="50">&nbsp;</td>
                  </tr>
                </table>
                <h3>Chapter 7 - Bonds</h3>
                <table width="446" border="0"  class="uk-table uk-table-condensed">
                  <tr>
                    <td width="50">1.</td>
                    <td width="510"> Simple bond</td>
                    <td width="50"><a href="deeds/Part IV/1438.docx">1438</a></td>
                    <td width="50">9.</td>
                    <td width="510">Bond to secure the performance of a contract</td>
                    <td width="50"><a href="deeds/Part IV/1447.docx">1447</a></td>
                  </tr>
                  <tr>
                    <td width="50">2.</td>
                    <td width="510">Simple bond by a Company</td>
                    <td width="50"><a href="deeds/Part IV/1439.docx">1439</a></td>
                    <td width="50">10.</td>
                    <td width="510">Bond to account for rents</td>
                    <td width="50"><a href="deeds/Part IV/1448.docx">1448</a></td>
                  </tr>
                  <tr>
                    <td width="50">3.</td>
                    <td width="510">Simple bond with two sureties</td>
                    <td width="50"><a href="deeds/Part IV/1440.docx">1440</a></td>
                    <td width="50">11.</td>
                    <td width="510">Bond by a vendor to indemnify loss of title deeds</td>
                    <td width="50"><a href="deeds/Part IV/1449.docx">1449</a></td>
                  </tr>
                  <tr>
                    <td>4.</td>
                    <td>Conditional bond</td>
                    <td><a href="deeds/Part IV/1441.docx">1441</a></td>
                    <td>12.</td>
                    <td>Bond by a employee for not engaging himself<br>
                      with a Competitor</td>
                    <td><a href="deeds/Part IV/1450.docx">1450</a></td>
                  </tr>
                  <tr>
                    <td>5.</td>
                    <td>Bond by a legal guardian</td>
                    <td><a href="deeds/Part IV/1442.docx">1442</a></td>
                    <td>13.</td>
                    <td>Bond for securing earnest money</td>
                    <td><a href="deeds/Part IV/1451.docx">1451</a></td>
                  </tr>
                  <tr>
                    <td>6.</td>
                    <td>Bond by a legal guardian</td>
                    <td><a href="deeds/Part IV/1443.docx">1443</a></td>
                    <td>14.</td>
                    <td>Bond for maintenance guarantee</td>
                    <td><a href="deeds/Part IV/1452.docx">1452</a></td>
                  </tr>
                  <tr>
                    <td>7.</td>
                    <td>Security Bond</td>
                    <td><a href="deeds/Part IV/1444.docx">1444</a></td>
                    <td>15.</td>
                    <td>Bottomry Bond</td>
                    <td><a href="deeds/Part IV/1453.docx">1453</a></td>
                  </tr>
                  <tr>
                    <td>8.</td>
                    <td>Security bond by a surety</td>
                    <td><a href="deeds/Part IV/1445.docx">1445</a></td>
                    <td>16.</td>
                    <td>Bond for Payment of debet</td>
                    <td><a href="deeds/Part IV/1454.docx">1454</a></td>
                  </tr>
                </table>
                <h3>Chapter 8 - Partnership Agreements</h3>
                <table width="446" border="0"  class="uk-table uk-table-condensed">
                  <tr>
                    <td width="50">1.</td>
                    <td width="510">Partnership agreement between two individuals</td>
                    <td width="50"><a href="deeds/Part IV/1471.docx">1471</a></td>
                    <td width="50">11.</td>
                    <td width="510">Agreement admitting a new partner</td>
                    <td width="50"><a href="deeds/Part IV/1514.docx">1514</a></td>
                  </tr>
                  <tr>
                    <td width="50">2.</td>
                    <td width="510">Partnership agreement between four partners</td>
                    <td width="50"><a href="deeds/Part IV/1475.docx">1475</a></td>
                    <td width="50">12.</td>
                    <td width="510">Deed of Retirement</td>
                    <td width="50"><a href="deeds/Part IV/1516.docx">1516</a></td>
                  </tr>
                  <tr>
                    <td width="50">3.</td>
                    <td width="510">Partnership agreement between two partnership firms</td>
                    <td width="50" background="Drag to a file to choose it."><a href="deeds/Part IV/1480.docx">1480</a></td>
                    <td width="50">13.</td>
                    <td width="510">Retirement of two partners (with liberty to continuing partners to carry on the business)</td>
                    <td width="50"><a href="deeds/Part IV/1518.docx">1518</a></td>
                  </tr>
                  <tr>
                    <td>4.</td>
                    <td>Partnership agreement for a single venture</td>
                    <td><a href="deeds/Part IV/1485.docx">1485</a></td>
                    <td>14.</td>
                    <td>Deed of Retirement of One Partner and admission of<br>
                    a new partner</td>
                    <td><a href="deeds/Part IV/1520.docx">1520</a></td>
                  </tr>
                  <tr>
                    <td>5.</td>
                    <td>Partnership agreement between a partnership firm and a Hindu joint family</td>
                    <td><a href="deeds/Part IV/1489.docx">1489</a></td>
                    <td>15.</td>
                    <td>Agreement for Dissolution of Partnership (By Sale of goodwill)</td>
                    <td><a href="deeds/Part IV/1524.docx">1524</a></td>
                  </tr>
                  <tr>
                    <td>6.</td>
                    <td>Partnership agreement between two Limited Companies</td>
                    <td><a href="deeds/Part IV/1494.docx">1494</a></td>
                    <td>16.</td>
                    <td>Agreement for Dissolution of Partnership (By Sale of goodwill)</td>
                    <td><a href="deeds/Part IV/1526.docx">1526</a></td>
                  </tr>
                  <tr>
                    <td>7.</td>
                    <td>Partnership agreement between an individual and a Limited Company</td>
                    <td><a href="deeds/Part IV/1498.docx">1498</a></td>
                    <td>17.</td>
                    <td>Deed of Dissolution of Partnership</td>
                    <td><a href="deeds/Part IV/1529.docx">1529</a></td>
                  </tr>
                  <tr>
                    <td>8.</td>
                    <td>Partnership agreement between an individual, a partnership Firm and a company</td>
                    <td><a href="deeds/Part IV/1502.docx">1502</a></td>
                    <td>18.</td>
                    <td>Agreement of Dissolution of partnership through an Attorney</td>
                    <td><a href="deeds/Part IV/1534.docx">1534</a></td>
                  </tr>
                  <tr>
                    <td>9.</td>
                    <td>Deed of partnership of H. U. F. business</td>
                    <td><a href="deeds/Part IV/1507.docx">1507</a></td>
                    <td>19.</td>
                    <td>Agreement for Conversion of a Private Limited Company into<br>
                    a Partnership</td>
                    <td><a href="deeds/Part IV/1538.docx">1538</a></td>
                  </tr>
                  <tr>
                    <td>10.</td>
                    <td>Memorandum of partnership of H. U. F. business</td>
                    <td><a href="deeds/Part IV/1511.docx">1511</a></td>
                    <td>20.</td>
                    <td>Deed of Sub Partnership</td>
                    <td><a href="deeds/Part IV/1540.docx">1540</a></td>
                  </tr>
                </table>
                <h3>Chapter 9 - Building Agreements</h3>
                <table width="446" border="0"  class="uk-table uk-table-condensed">
                  <tr>
                    <td width="50">1.</td>
                    <td width="510">Invitation to Tenderers</td>
                    <td width="50"><a href="deeds/Part IV/1554.docx">1554</a></td>
                    <td width="50">7.</td>
                    <td width="510">Agreement with Architect</td>
                    <td width="50"><a href="deeds/Part IV/1601.docx">1601</a></td>
                  </tr>
                  <tr>
                    <td width="50">2.</td>
                    <td width="510">General Conditions of Contract</td>
                    <td width="50"><a href="deeds/Part IV/1558.docx">1558</a></td>
                    <td width="50">8.</td>
                    <td width="510">Assignment of building contract by contractor</td>
                    <td width="50"><a href="deeds/Part IV/1604.docx">1604</a></td>
                  </tr>
                  <tr>
                    <td width="50">3.</td>
                    <td width="510">Letter of Intent</td>
                    <td width="50"><a href="deeds/Part IV/1578.docx">1578</a></td>
                    <td width="50">9.</td>
                    <td width="510">Assignment of building contract by owner</td>
                    <td width="50"><a href="deeds/Part IV/1606.docx">1606</a></td>
                  </tr>
                  <tr>
                    <td width="50">4.</td>
                    <td width="510">Work order</td>
                    <td width="50"><a href="deeds/Part IV/1580.docx">1580</a></td>
                    <td width="50">10.</td>
                    <td width="510">Agreement for demolition of building and sale of Building Material</td>
                    <td width="50"><a href="deeds/Part IV/1608.docx">1608</a></td>
                  </tr>
                  <tr>
                    <td width="50">5.</td>
                    <td width="510">Formal Building Agreement between the Owner and Contractor</td>
                    <td width="50"><a href="deeds/Part IV/1583.docx">1583</a></td>
                    <td width="50">11.</td>
                    <td width="510">Agreement with labour contractor</td>
                    <td width="50"><a href="deeds/Part IV/1610.docx">1610</a></td>
                  </tr>
                  <tr>
                    <td width="50">6.</td>
                    <td width="510">Building contract</td>
                    <td width="50"><a href="deeds/Part IV/1585.docx">1585</a></td>
                    <td width="50">12.</td>
                    <td width="510">Agreement for Transfer of Development Right (TDR)</td>
                    <td width="50"><a href="deeds/Part IV/1612.docx">1612</a></td>
                  </tr>
                </table>
                <h3>Chapter 10 - Foreign Collaboration Agreements</h3>
                <table width="446" border="0"  class="uk-table uk-table-condensed">
                  <tr>
                    <td width="50">1.</td>
                    <td width="510">Form of Foreign collaboration agreement</td>
                    <td width="50"><a href="deeds/Part IV/1727.docx">1727</a></td>
                    <td width="50">7.</td>
                    <td width="510">Agreement for use of trade mark</td>
                    <td width="50"><a href="deeds/Part IV/1759.docx">1759</a></td>
                  </tr>
                  <tr>
                    <td width="50">2.</td>
                    <td width="510">Agreement of Collaboration to establish a factory</td>
                    <td width="50"><a href="deeds/Part IV/1733.docx">1733</a></td>
                    <td width="50">8.</td>
                    <td width="510">Memorandum of Understanding and Confidentiality Agreement</td>
                    <td width="50"><a href="deeds/Part IV/1763.docx">1763</a></td>
                  </tr>
                  <tr>
                    <td width="50">3.</td>
                    <td width="510">Collaboration agreement between an Indian Company and oreign Company</td>
                    <td width="50"><a href="deeds/Part IV/1740.docx">1740</a></td>
                    <td width="50">9.</td>
                    <td width="510">Foreign Collaboration agreement granting Licence and know how of products</td>
                    <td width="50"><a href="deeds/Part IV/1772.docx">1772</a></td>
                  </tr>
                  <tr>
                    <td>4.</td>
                    <td>Agreement to act as technical or management adviser</td>
                    <td><a href="deeds/Part IV/1745.docx">1745</a></td>
                    <td>10.</td>
                    <td>Confidentiality Agreement</td>
                    <td><a href="deeds/Part IV/1777.docx">1777</a></td>
                  </tr>
                  <tr>
                    <td>5.</td>
                    <td>Agreement to help an Indian Industry for putting<br>
                    up plant and machinery</td>
                    <td><a href="deeds/Part IV/1749.docx">1749</a></td>
                    <td>11.</td>
                    <td>Joint Venture Agreement</td>
                    <td><a href="deeds/Part IV/1781.docx">1781</a></td>
                  </tr>
                  <tr>
                    <td>6.</td>
                    <td>Agreement to supply technical know-how</td>
                    <td><a href="deeds/Part IV/1753.docx">1753</a></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
                <h3>Chapter 11 - Franchise Agreement</h3>
                <table width="446" border="0"  class="uk-table uk-table-condensed">
                  <tr>
                    <td width="50">1.</td>
                    <td width="510">Franchise Agreement for sale of Motor Cars</td>
                    <td width="50"><a href="deeds/Part IV/1812.docx">1812</a></td>
                    <td width="50">3.</td>
                    <td width="510">Franchise Agreement</td>
                    <td width="50"><a href="deeds/Part IV/1829.docx">1829</a></td>
                  </tr>
                  <tr>
                    <td width="50">2.</td>
                    <td width="510">Franchise Agreement between Indian Parties </td>
                    <td width="50"><a href="deeds/Part IV/1818.docx">1818</a></td>
                    <td width="50">&nbsp;</td>
                    <td width="510">&nbsp;</td>
                    <td width="50">&nbsp;</td>
                  </tr>
                </table>
                <h3>Chapter 12 - Advertisement Contracts</h3>
                <table width="446" border="0"  class="uk-table uk-table-condensed">
                  <tr>
                    <td width="50">1.</td>
                    <td width="510">Agreement between owner of a site and Advertising Agency</td>
                    <td width="50"><a href="deeds/Part IV/1836.docx">1836</a></td>
                    <td width="50">7.</td>
                    <td width="510">Agreement between advertising agent and individual<br>
                    lending his name</td>
                    <td width="50"><a href="deeds/Part IV/1853.docx">1853</a></td>
                  </tr>
                  <tr>
                    <td width="50">2.</td>
                    <td width="510">Agreement of Licence between the owner of a building and<br>
                    the Advertising agent</td>
                    <td width="50"><a href="deeds/Part IV/1839.docx">1839</a></td>
                    <td width="50">8.</td>
                    <td width="510">Agreement between the Owner of a Hoarding and<br>
                    the Advertiser</td>
                    <td width="50"><a href="deeds/Part IV/1855.docx">1855</a></td>
                  </tr>
                  <tr>
                    <td width="50">3.</td>
                    <td width="510">Agreement between owner and the advertiser</td>
                    <td width="50"><a href="deeds/Part IV/1842.docx">1842</a></td>
                    <td width="50">9.</td>
                    <td width="510">Agreement between Photographer and a Model</td>
                    <td width="50"><a href="deeds/Part IV/1857.docx">1857</a></td>
                  </tr>
                  <tr>
                    <td width="50">4.</td>
                    <td width="510">Agreement between advertiser and advertising agency</td>
                    <td width="50"><a href="deeds/Part IV/1845.docx">1845</a></td>
                    <td width="50">10.</td>
                    <td width="510">Agreement between a Celebrity and Advertising Company</td>
                    <td width="50"><a href="deeds/Part IV/1859.docx">1859</a></td>
                  </tr>
                  <tr>
                    <td width="50">5.</td>
                    <td width="510">Agreement between advertiser agent and cinema theatre owner</td>
                    <td width="50"><a href="deeds/Part IV/1848.docx">1848</a></td>
                    <td width="50">11.</td>
                    <td width="510">Agreement regarding Online Retailing Business</td>
                    <td width="50"><a href="deeds/Part IV/1860.docx">1860</a></td>
                  </tr>
                  <tr>
                    <td width="50">6.</td>
                    <td width="510">Agreement between proprietor of newspaper and<br>
                    advertising agency</td>
                    <td width="50"><a href="deeds/Part IV/1850.docx">1850</a></td>
                    <td width="50">&nbsp;</td>
                    <td width="510">&nbsp;</td>
                    <td width="50">&nbsp;</td>
                  </tr>
                </table>
                <h3>Chapter 13 - Transport Contract</h3>
                <table width="446" border="0"  class="uk-table uk-table-condensed">
                  <tr>
                    <td width="50">1.</td>
                    <td width="510">Transport agreement for one consignment</td>
                    <td width="50"><a href="deeds/Part IV/1872.docx">1872</a></td>
                    <td width="50">6.</td>
                    <td width="510">Consignment note for road carriage</td>
                    <td width="50"><a href="deeds/Part IV/1887.docx">1887</a></td>
                  </tr>
                  <tr>
                    <td width="50">2.</td>
                    <td width="510">Transport agreement for continuous consignments</td>
                    <td width="50"><a href="deeds/Part IV/1876.docx">1876</a></td>
                    <td width="50">7.</td>
                    <td width="510">Combined Transport Contract</td>
                    <td width="50"><a href="deeds/Part IV/1888.docx">1888</a></td>
                  </tr>
                  <tr>
                    <td width="50">3.</td>
                    <td width="510">Agreement with private carrier for carriage of goods in a specific area</td>
                    <td width="50"><a href="deeds/Part IV/1881.docx">1881</a></td>
                    <td width="50">8.</td>
                    <td width="510">Combined Transport Contract (for Containerised exportation)</td>
                    <td width="50"><a href="deeds/Part IV/1890.docx">1890</a></td>
                  </tr>
                  <tr>
                    <td>4.</td>
                    <td>Contract of carriage at owner’s risk</td>
                    <td><a href="deeds/Part IV/1883.docx">1883</a></td>
                    <td>9.</td>
                    <td>Contract of Carriage for Courier Services</td>
                    <td><a href="deeds/Part IV/1893.docx">1893</a></td>
                  </tr>
                  <tr>
                    <td>5.</td>
                    <td>Contract of carriage at carrier’s risk</td>
                    <td><a href="deeds/Part IV/1885.docx">1885</a></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
                <h3>Chapter 14 - Information Technology and Computer Contracts</h3>
                <table width="446" border="0"  class="uk-table uk-table-condensed">
                  <tr>
                    <td width="50">1.</td>
                    <td width="510">Computer (Hardware) Hire Agreement</td>
                    <td width="50"><a href="deeds/Part IV/1906.docx">1906</a></td>
                    <td width="50">9.</td>
                    <td width="510">Agreement between an Internet Company and Web Site Owner</td>
                    <td width="50"><a href="deeds/Part IV/1947.docx">1947</a></td>
                  </tr>
                  <tr>
                    <td width="50">2.</td>
                    <td width="510">Agreement of licence for software package</td>
                    <td width="50"><a href="deeds/Part IV/1912.docx">1912</a></td>
                    <td width="50">10.</td>
                    <td width="510">Agreement for developing and hosting Web Site</td>
                    <td width="50"><a href="deeds/Part IV/1950.docx">1950</a></td>
                  </tr>
                  <tr>
                    <td width="50">3.</td>
                    <td width="510">Software development agreement</td>
                    <td width="50"><a href="deeds/Part IV/1919.docx">1919</a></td>
                    <td>11.</td>
                    <td>Software Services and Maintenance Contract</td>
                    <td><a href="deeds/Part IV/1958.docx">1958</a></td>
                  </tr>
                  <tr>
                    <td>4.</td>
                    <td>Turnkey Agreement</td>
                    <td><a href="deeds/Part IV/1924.docx">1924</a></td>
                    <td>12.</td>
                    <td>Hardware Marketing Agreement</td>
                    <td><a href="deeds/Part IV/1962.docx">1962</a></td>
                  </tr>
                  <tr>
                    <td>5.</td>
                    <td>Software distribution agreement</td>
                    <td><a href="deeds/Part IV/1930.docx">1930</a></td>
                    <td>13.</td>
                    <td>Website Purchase Agreement</td>
                    <td><a href="deeds/Part IV/1966.docx">1966</a></td>
                  </tr>
                  <tr>
                    <td>6.</td>
                    <td>Shrink-wrap licence</td>
                    <td><a href="deeds/Part IV/1937.docx">1937</a></td>
                    <td>14.</td>
                    <td>Software Installation Agreement</td>
                    <td><a href="deeds/Part IV/1969.docx">1969</a></td>
                  </tr>
                  <tr>
                    <td>7.</td>
                    <td>Another form of shrink-wrap licence agreement</td>
                    <td><a href="deeds/Part IV/1941.docx">1941</a></td>
                    <td>15.</td>
                    <td>Master Services Agreement</td>
                    <td><a href="deeds/Part IV/1974.docx">1974</a></td>
                  </tr>
                  <tr>
                    <td>8.</td>
                    <td>Consultancy agreement</td>
                    <td><a href="deeds/Part IV/1944.docx">1944</a></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
                <h3>Chapter 15 - Labour Laws and Documentation</h3>
                <table width="446" border="0"  class="uk-table uk-table-condensed">
                  <tr>
                    <td width="50">1.</td>
                    <td width="510">Contract for Supply of Labour</td>
                    <td width="50"><a href="deeds/Part IV/1982.docx">1982</a></td>
                    <td width="50">3.</td>
                    <td width="510">Agreement to refer labour disputes to Arbitrator under Sec. 10A of the Industrial Disputes Act, 1947</td>
                    <td width="50"><a href="deeds/Part IV/1989.docx">1989</a></td>
                  </tr>
                  <tr>
                    <td width="50">2.</td>
                    <td width="510">Agreement of indemnity by a Labour Contractor</td>
                    <td width="50"><a href="deeds/Part IV/1987.docx">1987</a></td>
                    <td width="50">&nbsp;</td>
                    <td width="510">&nbsp;</td>
                    <td width="50">&nbsp;</td>
                  </tr>
                </table>
              </div>
            </div>
             </div>	        <?php	
                            }
            ?>
            
            <?php
                            
                if(isset($_POST['part5']))
                    {
                //----------------------------------Part5----------------------------------
                
            ?>
 <div class="md-card uk-margin-medium-bottom">
            <div class="md-card-content">
                            
            <div class="uk-overflow-container">
            
			</p>
            <p>
            <label style="color:#0000FF"></label>
            <label style="color:#0000FF">PART V</label>
             <h2>Company, Corporation and Society</h2>
             <h3>Chapter 1 - Company Documents</h3>
             <h3>&nbsp;</h3>
             <table width="446" border="0"  class="uk-table uk-table-condensed">
               <tr>
                 <td width="50">1.</td>
                 <td width="510">Preliminary agreement to take over business</td>
                 <td width="50"><a href="deeds/Part V/2035.docx">2035</a></td>
                 <td width="50">28.</td>
                 <td width="510">Debenture Trust Deed in respect of Single Debenture Holder</td>
                 <td width="50"><a href="deeds/Part V/2226.docx">2226</a></td>
               </tr>
               <tr>
                 <td width="50">2.</td>
                 <td width="510">Preliminary agreement to form a company to purchase and develop property</td>
                 <td width="50"><a href="deeds/Part V/2038.docx">2038</a></td>
                 <td width="50">29.</td>
                 <td width="510">SEBI debenture trust deed</td>
                 <td width="50"><a href="deeds/Part V/2223.docx">2223</a></td>
               </tr>
               <tr>
                 <td width="50">3.</td>
                 <td width="510">Formation agreement to convert a partnership into a limited company</td>
                 <td width="50"><a href="deeds/Part V/2041.docx">2041</a></td>
                 <td width="50">30.</td>
                 <td width="510">Mutual Fund Deed of trust</td>
                 <td width="50"><a href="deeds/Part V/2265.docx">2265</a></td>
               </tr>
               <tr>
                 <td width="50">4.</td>
                 <td width="510">Agreement to adopt the preliminary agreement</td>
                 <td width="50"><a href="deeds/Part V/2044.docx">2044</a></td>
                 <td width="50">31.</td>
                 <td width="510">Agreement for appointment of a Managing Director</td>
                 <td width="50"><a href="deeds/Part V/2279.docx">2279</a></td>
               </tr>
               <tr>
                 <td width="50">5.</td>
                 <td width="510">Declaration under S. 33(2) of the Companies Act</td>
                 <td width="50"><a href="deeds/Part V/2046.docx">2046</a></td>
                 <td width="50">32.</td>
                 <td width="510">Managing Director’s Agreement</td>
                 <td width="50"><a href="deeds/Part V/2283.docx">2283</a></td>
               </tr>
               <tr>
                 <td width="50">6.</td>
                 <td width="510">Memorandum of Association of a Company limited by shares</td>
                 <td width="50"><a href="deeds/Part V/2047.docx">2047</a></td>
                 <td width="50">33.</td>
                 <td width="510">Agreement for Appointment of Company Secretary</td>
                 <td width="50"><a href="deeds/Part V/2290.docx">2290</a></td>
               </tr>
               <tr>
                 <td width="50">7</td>
                 <td width="510">Memorandum of Association of a Company limited by guarantee and not having a share capital</td>
                 <td width="50"><a href="deeds/Part V/2053.docx">2053</a></td>
                 <td width="50">34.</td>
                 <td width="510">Abridged Prospectus or Memorandum containing salient features of prospectus</td>
                 <td width="50"><a href="deeds/Part V/2294.docx">2294</a></td>
               </tr>
               <tr>
                 <td width="50">8.</td>
                 <td width="510">Memorandum of Association of a company limited by guarantee and having a share capital</td>
                 <td width="50"><a href="deeds/Part V/2054.docx">2054</a></td>
                 <td width="50">35.</td>
                 <td width="510">Matters to be Specified in Prospectus and Reports to be Setout therein</td>
                 <td width="50"><a href="deeds/Part V/2297.docx">2297</a></td>
               </tr>
               <tr>
                 <td width="50">9.</td>
                 <td width="510">Memorandum of Association of an unlimited Company</td>
                 <td width="50"><a href="deeds/Part V/2055.docx">2055</a></td>
                 <td width="50">36.</td>
                 <td width="510">Form of Statement in Lieu of Prospectus to be delivered to Registrar by a Company which does not issue a Prospectus or which does not go to Allotment on a Prospectus issued and Reports to be set out therein</td>
                 <td width="50"><a href="deeds/Part V/2306.docx">2306</a></td>
               </tr>
               <tr>
                 <td width="50">10.</td>
                 <td width="510">Memorandum of Association of Charitable Company under Sec. 25.</td>
                 <td width="50"><a href="deeds/Part V/2056.docx">2056</a></td>
                 <td width="50">37.</td>
                 <td width="510">Prospectus (Inviting Subscription for Convertible Debentures)</td>
                 <td width="50"><a href="deeds/Part V/2312.docx">2312</a></td>
               </tr>
               <tr>
                 <td width="50">11.</td>
                 <td width="510">Memorandum of Assoication of a Company Registered under sec. 25 of the Companies Act</td>
                 <td width="50"><a href="deeds/Part V/2060.docx">2060</a></td>
                 <td width="50">38.</td>
                 <td width="510">Specimen of Affidavit (to be given individually by each Applicant)</td>
                 <td width="50"><a href="deeds/Part V/2330.docx">2330</a></td>
               </tr>
               <tr>
                 <td width="50">12.</td>
                 <td width="510">Memorandum of Association</td>
                 <td width="50"><a href="deeds/Part V/2062.docx">2062</a></td>
                 <td width="50">39.</td>
                 <td width="510">Letter of Offer</td>
                 <td width="50"><a href="deeds/Part V/2332.docx">2332</a></td>
               </tr>
               <tr>
                 <td width="50">13.</td>
                 <td width="510">Articles of Association of a Public Limited Company</td>
                 <td width="50"><a href="deeds/Part V/2064.docx">2064</a></td>
                 <td width="50">40.</td>
                 <td width="510">Declaration of Solvency</td>
                 <td width="50"><a href="deeds/Part V/2340.docx">2340</a></td>
               </tr>
               <tr>
                 <td width="50">14.</td>
                 <td width="510">Articles of Association adopting Table ‘A’ To The Companies Act (Regulation for Management of a Company limited by Shares)</td>
                 <td width="50"><a href="deeds/Part V/2124.docx">2124</a></td>
                 <td width="50">41.</td>
                 <td width="510">Shareholders’ Agreement</td>
                 <td width="50"><a href="deeds/Part V/2342.docx">2342</a></td>
               </tr>
               <tr>
                 <td width="50">15.</td>
                 <td width="510">Articles of Association of a Private Company limited by shares</td>
                 <td width="50"><a href="deeds/Part V/2143.docx">2143</a></td>
                 <td width="50">42.</td>
                 <td width="510">Schedule XIII to the Companies Act</td>
                 <td width="50"><a href="deeds/Part V/2366.docx">2366</a></td>
               </tr>
               <tr>
                 <td width="50">16.</td>
                 <td width="510">Articles of Association of a company limited by guarantee and not having a share capital</td>
                 <td width="50"><a href="deeds/Part V/2157.docx">2157</a></td>
                 <td width="50">43.</td>
                 <td width="510">Schedule XIII—Amendments Issued by Ministry of Law Justice and Company Affairs in the Schedule</td>
                 <td width="50"><a href="deeds/Part V/2375.docx">2375</a></td>
               </tr>
               <tr>
                 <td width="50">17.</td>
                 <td width="510">Articles of Association of a Company limited by guarantee and having a share capital</td>
                 <td width="50"><a href="deeds/Part V/2161.docx">2161</a></td>
                 <td width="50">44.</td>
                 <td width="510">Schedule IV to the Companies Act Schedule IV to the Companies Act</td>
                 <td width="50"><a href="deeds/Part V/2381.docx">2381</a></td>
               </tr>
               <tr>
                 <td width="50">18.</td>
                 <td width="510">Articles of Association of an unlimited company</td>
                 <td width="50"><a href="deeds/Part V/2162.docx">2162</a></td>
                 <td width="50">45.</td>
                 <td width="510">Agreement to Take over Company by Transfer of Shares</td>
                 <td width="50"><a href="deeds/Part V/2389.docx">2389</a></td>
               </tr>
               <tr>
                 <td width="50">19.</td>
                 <td width="510">Memorandum of Association</td>
                 <td width="50"><a href="deeds/Part V/2163.docx">2163</a></td>
                 <td width="50">46.</td>
                 <td width="510">Specimen Schemes of Demerger</td>
                 <td width="50"><a href="deeds/Part V/2392.docx">2392</a></td>
               </tr>
               <tr>
                 <td width="50">20.</td>
                 <td width="510">OTC Exchange of India (Receipt and Transfer Form)</td>
                 <td width="50"><a href="deeds/Part V/2165.docx">2165</a></td>
                 <td width="50">47.</td>
                 <td width="510">Scheme of Arrangement and Amalgamation</td>
                 <td width="50"><a href="deeds/Part V/2417.docx">2417</a></td>
               </tr>
               <tr>
                 <td width="50">21.</td>
                 <td width="510">Nomination Form</td>
                 <td width="50"><a href="deeds/Part V/2169.docx">2169</a></td>
                 <td width="50">48.</td>
                 <td width="510">The Scheme of Amalgamation</td>
                 <td width="50"><a href="deeds/Part V/2427.docx">2427</a></td>
               </tr>
               <tr>
                 <td width="50">22.</td>
                 <td width="510">Underwriting agreement in a letter form</td>
                 <td width="50"><a href="deeds/Part V/2171.docx">2171</a></td>
                 <td width="50">49.</td>
                 <td width="510">Specimen of Application for striking off the name of the Company u/s 560 of the Companies Act, 1956</td>
                 <td width="50"><a href="deeds/Part V/2429.docx">2429</a></td>
               </tr>
               <tr>
                 <td width="50">23.</td>
                 <td width="510">Underwriting agreement for issue of right shares</td>
                 <td width="50"><a href="deeds/Part V/2173.docx">2173</a></td>
                 <td width="50">50.</td>
                 <td width="510">Consultancy Agreement</td>
                 <td width="50"><a href="deeds/Part V/2431.docx">2431</a></td>
               </tr>
               <tr>
                 <td width="50">24.</td>
                 <td width="510">SEBI’S model underwriting agreement</td>
                 <td width="50"><a href="deeds/Part V/2175.docx">2175</a></td>
                 <td width="50">51.</td>
                 <td width="510">Export Agency Agreement</td>
                 <td width="50"><a href="deeds/Part V/2433.docx">2433</a></td>
               </tr>
               <tr>
                 <td width="50">25.</td>
                 <td width="510">Debenture</td>
                 <td width="50"><a href="deeds/Part V/2181.docx">2181</a></td>
                 <td width="50">52.</td>
                 <td width="510">Research &amp; Development Agreement</td>
                 <td width="50"><a href="deeds/Part V/2437.docx">2437</a></td>
               </tr>
               <tr>
                 <td width="50">26.</td>
                 <td width="510">Debenture Trust Deed</td>
                 <td width="50"><a href="deeds/Part V/2184.docx">2184</a></td>
                 <td width="50">53.</td>
                 <td width="510">Business Service Centre Agreement</td>
                 <td width="50"><a href="deeds/Part V/2440.docx">2440</a></td>
               </tr>
               <tr>
                 <td width="50">27.</td>
                 <td width="510">Supplemental debenture Trust Deed (for securing further debentures)</td>
                 <td width="50"><a href="deeds/Part V/2222.docx">2222</a></td>
                 <td width="50">54.</td>
                 <td width="510">Training Services Agreement</td>
                 <td width="50"><a href="deeds/Part V/2448.docx">2448</a></td>
               </tr>
             </table>
             </p>
             <p><strong>Chapter 2 - Other Corporate Bodies and Societies</strong></p>
             <table width="446" border="0"  class="uk-table uk-table-condensed">
               <tr>
                 <td width="50">1.</td>
                 <td width="510">Memorandum of Association of society</td>
                 <td width="50"><a href="deeds/Part V/2476.docx">2476</a></td>
                 <td width="50">3.</td>
                 <td width="510">Constitution of a Music Society</td>
                 <td width="50"><a href="deeds/Part V/2486.docx">2486</a></td>
               </tr>
               <tr>
                 <td width="50">2.</td>
                 <td width="510">Rules and Regulations of a Institution</td>
                 <td width="50"><a href="deeds/Part V/2477.docx">2477</a></td>
                 <td width="50">4.</td>
                 <td width="510">Objects of a Sports Club</td>
                 <td width="50"><a href="deeds/Part V/2489.docx">2489</a></td>
               </tr>
             </table>
             <p>&nbsp;</p>
             <p>&nbsp;</p>
             <p>&nbsp;</p>
            </div>
   </div></div>			 <?php	
                            }
							
if(isset($_POST['part6']))
		{
				 //----------------------------------Part 1----------------------------------
	
	   ?>
    
    
 
            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                  <label style="color:#0000FF"><br>
   PART VI</label><br>

                  <div class="uk-overflow-container">
                 		<h2> Shipping Documents</h2>
                        <h3>Chapter 1</h3>
                        <h3> Shipping Documents</h3>
                                               
			 
			            <table width="446" border="0"  class="uk-table uk-table-condensed">
                          <tr>
                            <td width="50">1.</td>
                            <td width="500">Agreement for Sale of ship</td>
                            <td width="50"><a href="deeds/Part VI/2501.docx">2501</a></td>
                            <td width="50">7.</td>
                            <td width="500">Bill of Lading</td>
                            <td width="50"><a href="deeds/Part VI/2519.docx">2519</a></td>
                          </tr>
                          <tr>
                            <td width="50">2.</td>
                            <td width="500">Deed of sale of Ship (whole)</td>
                            <td width="50"><a href="deeds/Part VI/2504.docx">2504</a></td>
                            <td width="50">8.</td>
                            <td width="500">Bottomry Bond</td>
                            <td width="50"><a href="deeds/Part VI/2520.docx">2520</a></td>
                          </tr>
                          <tr>
                            <td width="50">3.</td>
                            <td width="500">Deed of Sale of Ship (some shares)</td>
                            <td width="50"><a href="deeds/Part VI/2505.docx">2505</a></td>
                            <td width="50">9.</td>
                            <td width="500">Respondentia Bond</td>
                            <td width="50"><a href="deeds/Part VI/2521.docx">2521</a></td>
                          </tr>
                          <tr>
                            <td width="50">4.</td>
                            <td width="500">Mortgage of a ship by body Corporate to secure a loan</td>
                            <td width="50"><a href="deeds/Part VI/2506.docx">2506</a></td>
                            <td width="50">10.</td>
                            <td width="500">Dock Warrant</td>
                            <td width="50"><a href="deeds/Part VI/2522.docx">2522</a></td>
                          </tr>
                          <tr>
                            <td width="50">5.</td>
                            <td width="500">Deed of covenant to Accompany Statutory Mortgage of ship</td>
                            <td width="50"><a href="deeds/Part VI/2508.docx">2508</a></td>
                            <td width="50">11.</td>
                            <td width="500">Warehouse keeper's Certificate</td>
                            <td width="50"><a href="deeds/Part VI/2523.docx">2523</a></td>
                          </tr>
                          <tr>
                            <td width="50">6.</td>
                            <td width="500">Charter for the period of a voyage</td>
                            <td width="50"><a href="deeds/Part VI/2515.docx">2515</a></td>
                            <td width="50">12.</td>
                            <td width="500">Form of Marine Insurance Policy</td>
                            <td width="50"><a href="deeds/Part VI/2524.docx">2524</a></td>
                          </tr>
                        </table>
		    <?php	
				}
				
				if(isset($_POST['part7']))
		{
				 //----------------------------------Part 1----------------------------------
	
	   ?>
    
    
   <label style="color:#0000FF">PART VII</label>

            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content">
                
                  <div class="uk-overflow-container">
                 		<h2> Non Contractual Documents or Deeds Poll</h2>
                        <h3>Chapter 1</h3>
                        <h3> Power of Attorney</h3>
                                               
			 
			            <table width="446" border="0"  class="uk-table uk-table-condensed">
                          <tr>
                            <td width="50">1.</td>
                            <td width="510">General power attorney</td>
                            <td width="50"><a href="deeds/Part VII/2544.docx">2544</a></td>
                            <td width="50">9.</td>
                            <td width="510">Power of attorney to obtain letters of administration</td>
                            <td width="50"><a href="deeds/Part VII/2565.docx">2565</a></td>
                          </tr>
                          <tr>
                            <td width="50">2.</td>
                            <td width="510">Special power of Attorney for admitting execution</td>
                            <td width="50"><a href="deeds/Part VII/2551.docx">2551</a></td>
                            <td width="50">10.</td>
                            <td width="510">Power of attorney by a Company to its Branch Manager</td>
                            <td width="50"><a href="deeds/Part VII/2567.docx">2567</a></td>
                          </tr>
                          <tr>
                            <td width="50">3.</td>
                            <td width="510">Power of attorney to collect debts</td>
                            <td width="50"><a href="deeds/Part VII/2552.docx">2552</a></td>
                            <td width="50">11.</td>
                            <td width="510">Power of attorney by the partners of a firm to one of them</td>
                            <td width="50"><a href="deeds/Part VII/2570.docx">2570</a></td>
                          </tr>
                          <tr>
                            <td width="50">4.</td>
                            <td width="510">Power of attorney to sell shares</td>
                            <td width="50"><a href="deeds/Part VII/2554.docx">2554</a></td>
                            <td width="50">12.</td>
                            <td width="510">Substituted power of attorney</td>
                            <td width="50"><a href="deeds/Part VII/2574.docx">2574</a></td>
                          </tr>
                          <tr>
                            <td width="50">5.</td>
                            <td width="510">Power of attorney to execute a deed of sale</td>
                            <td width="50"><a href="deeds/Part VII/2556.docx">2556</a></td>
                            <td width="50">13.</td>
                            <td width="510">Power of attorney to execute a document</td>
                            <td width="50"><a href="deeds/Part VII/2575.docx">2575</a></td>
                          </tr>
                          <tr>
                            <td width="50">6.</td>
                            <td width="510">Power of attorney to prepare a layout and sell plots</td>
                            <td width="50"><a href="deeds/Part VII/2558.docx">2558</a></td>
                            <td width="50">14.</td>
                            <td width="510">Power of Attorney for Doing Ministerial Acts Relating to Development of property in favour of Developers</td>
                            <td width="50"><a href="deeds/Part VII/2576.docx">2576</a></td>
                          </tr>
                          <tr>
                            <td width="50">7.</td>
                            <td width="510">Power of attorney to raise money and mortgage property</td>
                            <td width="50"><a href="deeds/Part VII/2560.docx">2560</a></td>
                            <td width="50">15.</td>
                            <td width="510">Power of attorney for development of Property by the owner</td>
                            <td width="50"><a href="deeds/Part VII/2579.docx">2579</a></td>
                          </tr>
                          <tr>
                            <td width="50">8.</td>
                            <td width="510">Power of attorney to recover rents</td>
                            <td width="50"><a href="/lawpract/lawpract/deeds/Part VII/2562.docx">2562</a></td>
                            <td width="50">16.</td>
                            <td width="510">&nbsp;</td>
                            <td width="50">&nbsp;</td>
                          </tr>
                        </table>
		                <h3>Chapter 2</h3>
		                <h3> Banking and Negotiable Instruments</h3>
		                <table width="446" border="0"  class="uk-table uk-table-condensed">
                          <tr>
                            <td width="50">1.</td>
                            <td width="510">Nominations form for FDR</td>
                            <td width="50"><a href="deeds/Part VII/2599.docx">2598</a></td>
                            <td width="50">19.</td>
                            <td width="510">Bill of Exchange payable on demand</td>
                            <td width="50"><a href="deeds/Part VII/2612.docx">2612</a></td>
                          </tr>
                          <tr>
                            <td width="50">2.</td>
                            <td width="510">Nomination Form for Locker</td>
                            <td width="50"><a href="deeds/Part VII/2600.docx">2600</a></td>
                            <td width="50">20.</td>
                            <td width="510">Bill of Exchange payable on presentment</td>
                            <td width="50"><a href="deeds/Part VII/2613.docx">2613</a></td>
                          </tr>
                          <tr>
                            <td width="50">3.</td>
                            <td width="510">Nomination Form for Safety Locker</td>
                            <td width="50"><a href="deeds/Part VII/2601.docx">2601</a></td>
                            <td width="50">21.</td>
                            <td width="510">Bill of Exchange payable to bearer</td>
                            <td width="50"><a href="deeds/Part VII/2613.docx">2613</a></td>
                          </tr>
                          <tr>
                            <td width="50">4.</td>
                            <td width="510">Nomination Form for Safe Custody</td>
                            <td width="50"><a href="deeds/Part VII/2602.docx">2602</a></td>
                            <td width="50">22.</td>
                            <td width="510">Bill of Exchange after date</td>
                            <td width="50"><a href="deeds/Part VII/2614.docx">2614</a></td>
                          </tr>
                          <tr>
                            <td width="50">5.</td>
                            <td width="510">Letter of Guidance by Directors</td>
                            <td width="50"><a href="deeds/Part VII/2603.docx">2603</a></td>
                            <td width="50">23.</td>
                            <td width="510">Foreign Bill of Exchange in three sets</td>
                            <td width="50"><a href="deeds/Part VII/2614.docx">2614</a></td>
                          </tr>
                          <tr>
                            <td width="50">6.</td>
                            <td width="510">Letter of lien for cash credit facility</td>
                            <td width="50"><a href="deeds/Part VII/2604.docx">2604</a></td>
                            <td width="50">24.</td>
                            <td width="510">Shahjog Hundi</td>
                            <td width="50"><a href="deeds/Part VII/2615.docx">2615</a></td>
                          </tr>
                          <tr>
                            <td width="50">7.</td>
                            <td width="510">Agreement for a cash/credit account</td>
                            <td width="50"><a href="deeds/Part VII/2605.docx">2605</a></td>
                            <td width="50">25.</td>
                            <td width="510">Darshani Hundi</td>
                            <td width="50"><a href="deeds/Part VII/2615.docx">2615</a></td>
                          </tr>
                          <tr>
                            <td width="50">8.</td>
                            <td width="510">Promissory Note on demand</td>
                            <td width="50"><a href="deeds/Part VII/2607.docx">2607</a></td>
                            <td width="50">26.</td>
                            <td width="510">Mudati Hundi</td>
                            <td width="50"><a href="deeds/Part VII/2615.docx">2615</a></td>
                          </tr>
                          <tr>
                            <td width="50">9.</td>
                            <td width="510">Promissory Note payable after a period</td>
                            <td width="50"><a href="deeds/Part VII/2607.docx">2607</a></td>
                            <td width="50">27.</td>
                            <td width="510">Bill of drawn by seller of goods</td>
                            <td width="50"><a href="deeds/Part VII/2616.docx">2616</a></td>
                          </tr>
                          <tr>
                            <td width="50">10.</td>
                            <td width="510">Promissory Note in favour of payee or his order</td>
                            <td width="50"><a href="deeds/Part VII/2608.docx">2608</a></td>
                            <td width="50">28.</td>
                            <td width="510">Agreement between a Bank &amp; R. B. I.</td>
                            <td width="50"><a href="deeds/Part VII/2617.docx">2617</a></td>
                          </tr>
                          <tr>
                            <td width="50">11.</td>
                            <td width="510">Promissory Note payable by instalments</td>
                            <td width="50"><a href="deeds/Part VII/2608.docx">2608</a></td>
                            <td width="50">29.</td>
                            <td width="510">Letter of Credit (Foreign)</td>
                            <td width="50"><a href="deeds/Part VII/2620.docx">2620</a></td>
                          </tr>
                          <tr>
                            <td width="50">12.</td>
                            <td width="510">Promissory Note payable at sight</td>
                            <td width="50"><a href="deeds/Part VII/2609.docx">2609</a></td>
                            <td width="50">30.</td>
                            <td width="510">Letter of Credit (Inland)</td>
                            <td width="50"><a href="deeds/Part VII/2620.docx">2620</a></td>
                          </tr>
                          <tr>
                            <td width="50">13.</td>
                            <td width="510">Promissory Note payable at specified place</td>
                            <td width="50"><a href="deeds/Part VII/2609.docx">2609</a></td>
                            <td width="50">31.</td>
                            <td width="510">Another Form of Letter of Credit</td>
                            <td width="50"><a href="deeds/Part VII/2621.docx">2621</a></td>
                          </tr>
                          <tr>
                            <td width="50">14.</td>
                            <td width="510">Joint promissory Note by drawers</td>
                            <td width="50"><a href="deeds/Part VII/2609.docx">2609</a></td>
                            <td width="50">32.</td>
                            <td width="510">Clean Letter of Credit</td>
                            <td width="50"><a href="deeds/Part VII/2621.docx">2621</a></td>
                          </tr>
                          <tr>
                            <td width="50">15.</td>
                            <td width="510">Promissory Note in favour of joint promisees</td>
                            <td width="50"><a href="deeds/Part VII/2610.docx">2610</a></td>
                            <td width="50">33.</td>
                            <td width="510">Agreement relating to opening of an inland irrevocable (without recourse) letter of credit</td>
                            <td width="50"><a href="deeds/Part VII/2622.docx">2622</a></td>
                          </tr>
                          <tr>
                            <td width="50">16.</td>
                            <td width="510">Usance promissory note</td>
                            <td width="50"><a href="deeds/Part VII/2610.docx">2610</a></td>
                            <td width="50">34.</td>
                            <td width="510">Agreement relating to opening of an irrevocable (without recourse ) import letter of credit</td>
                            <td width="50"><a href="deeds/Part VII/2627.docx">2627</a></td>
                          </tr>
                          <tr>
                            <td width="50">17.</td>
                            <td width="510">Promissory Note (Commericial paper)</td>
                            <td width="50"><a href="deeds/Part VII/2611.docx">2611</a></td>
                            <td width="50">35.</td>
                            <td width="510">Facility Agreement</td>
                            <td width="50"><a href="deeds/Part VII/2633.docx">2633</a></td>
                          </tr>
                          <tr>
                            <td width="50">18.</td>
                            <td width="510">Bill of Exchange payable at sight</td>
                            <td width="50"><a href="deeds/Part VII/2612.docx">2612</a></td>
                            <td width="50">36.</td>
                            <td width="510">Performance Bank Guarantee</td>
                            <td width="50"><a href="deeds/Part VII/2641.docx">2641</a></td>
                          </tr>
                        </table>
                        <h3>Chapter 3</h3>
                        <h3> Acknowledgements &amp; Receipts</h3>
                        <table width="446" border="0"  class="uk-table uk-table-condensed">
                          <tr>
                            <td width="26">1.</td>
                            <td width="285">Receipt for money</td>
                            <td width="45"><a href="deeds/Part VII/2650.docx">2650</a></td>
                            <td width="38">10.</td>
                            <td width="208">Receipt by retiring partner</td>
                            <td width="44"><a href="deeds/Part VII/2654.docx">2654</a></td>
                          </tr>
                          <tr>
                            <td>2.</td>
                            <td>Receipt for goods</td>
                            <td><a href="deeds/Part VII/2650.docx">2650</a></td>
                            <td>11.</td>
                            <td>Receipt by mortgagee</td>
                            <td><a href="deeds/Part VII/2655.docx">2655</a></td>
                          </tr>
                          <tr>
                            <td>3.</td>
                            <td>Receipt for document</td>
                            <td><a href="deeds/Part VII/2651.docx">2651</a></td>
                            <td>12.</td>
                            <td>Accountable receipt</td>
                            <td><a href="deeds/Part VII/2655.docx">2655</a></td>
                          </tr>
                          <tr>
                            <td>4.</td>
                            <td>Receipt for rent</td>
                            <td><a href="deeds/Part VII/2651.docx">2651</a></td>
                            <td>13.</td>
                            <td>Acknowledgements</td>
                            <td><a href="deeds/Part VII/2656.docx">2656</a></td>
                          </tr>
                          <tr>
                            <td>5.</td>
                            <td>Receipt for salary</td>
                            <td><a href="deeds/Part VII/2652.docx">2652</a></td>
                            <td>14.</td>
                            <td>Acknowledgement to save limitation</td>
                            <td><a href="deeds/Part VII/2656.docx">2656</a></td>
                          </tr>
                          <tr>
                            <td>6.</td>
                            <td>Receipt for repairs</td>
                            <td><a href="deeds/Part VII/2652.docx">2652</a></td>
                            <td>15.</td>
                            <td>Acknowledgement to save limitation</td>
                            <td><a href="deeds/Part VII/2657.docx">2657</a></td>
                          </tr>
                          <tr>
                            <td>7.</td>
                            <td>Receipt for legacy</td>
                            <td><a href="deeds/Part VII/2653.docx">2653</a></td>
                            <td>16.</td>
                            <td>Acknowledgement of prescriptive right</td>
                            <td><a href="deeds/Part VII/2657.docx">2657</a></td>
                          </tr>
                          <tr>
                            <td>8.</td>
                            <td>Receipt by residuary legatee</td>
                            <td><a href="deeds/Part VII/2653.docx">2653</a></td>
                            <td>17.</td>
                            <td>Acknowledgement of prescriptive right</td>
                            <td><a href="deeds/Part VII/2658.docx">2658</a></td>
                          </tr>
                          <tr>
                            <td>9.</td>
                            <td>Receipt by beneficiary</td>
                            <td><a href="deeds/Part VII/2654.docx">2654</a></td>
                            <td>18.</td>
                            <td>Acknowledgement of liability by part payment</td>
                            <td><a href="deeds/Part VII/2658.docx">2658</a></td>
                          </tr>
                        </table>
            <p>&nbsp;</p>
                        <h3>Chapter 4</h3>
                        <h3> Adoption</h3>
                        <table width="446" border="0"  class="uk-table uk-table-condensed">
                          <tr>
                            <td width="26">1.</td>
                            <td width="285">Deed of Adoption of a son</td>
                            <td width="45"><a href="deeds/Part VII/2663.docx">2663</a></td>
                            <td width="38">3.</td>
                            <td width="208">Adoption by an unmarried woman, of a daughter</td>
                            <td width="44"><a href="deeds/Part VII/2667.docx">2667</a></td>
                          </tr>
                          <tr>
                            <td>2.</td>
                            <td>Adoption by a widow, of a son</td>
                            <td><a href="deeds/Part VII/2665.docx">2665</a></td>
                            <td>4.</td>
                            <td>Adoption of an orphan</td>
                            <td><a href="deeds/Part VII/2669.docx">2669</a></td>
                          </tr>
                        </table>
                        <p>&nbsp;</p>
                        <h3>Chapter 5</h3>
                        <h3> Arbitration Agreement</h3>
                        <table width="446" border="0"  class="uk-table uk-table-condensed">
                          <tr>
                            <td width="26">1.</td>
                            <td width="285">Agreement of reference to a common arbitrator</td>
                            <td width="45"><a href="deeds/Part VII/2679.docx">2679</a></td>
                            <td width="38">6.</td>
                            <td width="208">Arbitration clause in a partnership agreement</td>
                            <td width="44"><a href="deeds/Part VII/2687.docx">2687</a></td>
                          </tr>
                          <tr>
                            <td>2.</td>
                            <td>Arbitration Agreement between three partners</td>
                            <td><a href="deeds/Part VII/2681.docx">2681</a></td>
                            <td>7.</td>
                            <td>Arbitration clause in a building contract</td>
                            <td><a href="deeds/Part VII/2688.docx">2688</a></td>
                          </tr>
                          <tr>
                            <td>3.</td>
                            <td>Agreement of reference to arbitration by members of a H.U.F.</td>
                            <td><a href="deeds/Part VII/2683.docx">2683</a></td>
                            <td>8.</td>
                            <td>Arbitration clause where the Arbitrator is to be nominated by a third Person</td>
                            <td><a href="deeds/Part VII/2688.docx">2688</a></td>
                          </tr>
                          <tr>
                            <td>4.</td>
                            <td>Agreement for reference to Arbitration between the Executor and Legatees</td>
                            <td><a href="deeds/Part VII/2686.docx">2686</a></td>
                            <td>9.</td>
                            <td>Award by an Arbitrator</td>
                            <td><a href="deeds/Part VII/2689.docx">2689</a></td>
                          </tr>
                          <tr>
                            <td>5.</td>
                            <td>Arbitration clause in common form</td>
                            <td><a href="deeds/Part VII/2687.docx">2687</a></td>
                            <td>10.</td>
                            <td>Award by a Majority</td>
                            <td><a href="deeds/Part VII/2690.docx">2690</a></td>
                          </tr>
                        </table>
                        <h3>Chapter 6</h3>
                        <h3> Testamentary Documents</h3>
                        <table width="446" border="0"  class="uk-table uk-table-condensed">
                          <tr>
                            <td width="26">1.</td>
                            <td width="285">Common form of a will</td>
                            <td width="45"><a href="deeds/Part VII/2708.docx">2708</a></td>
                            <td width="38">5.</td>
                            <td width="208">Joint will</td>
                            <td width="44"><a href="deeds/Part VII/2715.docx">2715</a></td>
                          </tr>
                          <tr>
                            <td>2.</td>
                            <td>Detail will</td>
                            <td><a href="deeds/Part VII/2710.docx">2710</a></td>
                            <td>6.</td>
                            <td>Codicil (correcting errors)</td>
                            <td><a href="deeds/Part VII/2716.docx">2716</a></td>
                          </tr>
                          <tr>
                            <td>3.</td>
                            <td>Mutual will</td>
                            <td><a href="deeds/Part VII/2712.docx">2712</a></td>
                            <td>7.</td>
                            <td>Codicil (amending the will)</td>
                            <td><a href="deeds/Part VII/2717.docx">2717</a></td>
                          </tr>
                          <tr>
                            <td>4.</td>
                            <td>Another (simpler) form of mutual will</td>
                            <td><a href="deeds/Part VII/2714.docx">2714</a></td>
                            <td>8.</td>
                            <td>Will reviving a revoked will</td>
                            <td><a href="deeds/Part VII/2718.docx">2718</a></td>
                          </tr>
                        </table>
                        <h3>Chapter 7</h3>
                        <h3> Power of Appointment</h3>
                        <table width="446" border="0"  class="uk-table uk-table-condensed">
                          <tr>
                            <td width="26">1.</td>
                            <td width="285">Deed of Appointment under a will</td>
                            <td width="45"><a href="deeds/Part VII/2723.docx">2723</a></td>
                            <td width="38">2.</td>
                            <td width="208">Deed of Appointment under a Deed of Trust</td>
                            <td width="44"><a href="deeds/Part VII/2724.docx">2724</a></td>
                          </tr>
                        </table>
                        <h3>Chapter 8</h3>
                        <h3> Change in Name</h3>
                        <table width="370" border="0"  class="uk-table uk-table-condensed">
                          <tr>
                            <td width="26">1.</td>
                            <td width="285">Deed poll for Change in Name</td>
                            <td width="45">2726</td>
                          </tr>
                        </table>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
            <p>&nbsp;</p>
<p>&nbsp;</p>
		                <p>
		                  <?php	
				}
		
						?>
                         <?php
	        include('footersrc.php');    
			?>
                                                </p>
		                <p>&nbsp;</p>
</body>
</html>
    
                       