
<?php

include('includes/SQL_CommonFunctions.inc');

if (isset($_GET['SelectedCurrency'])){
    $SelectedCurrency = $_GET['SelectedCurrency'];
} elseif (isset($_POST['SelectedCurrency'])){
    $SelectedCurrency = $_POST['SelectedCurrency'];
}

$ForceConfigReload = true;
include('includes/GetConfig.php');

$FunctionalCurrency = $_SESSION['CompanyRecord']['currencydefault'];

if (isset($Errors)) {
	unset($Errors);
}

$Errors = array();

if (isset($_POST['submit'])) {

    //initialise no input errors assumed initially before we test
    $InputError = 0;

    /* actions to take once the user has clicked the submit button
    ie the page has called itself with some user input */

    //first off validate inputs are sensible
	$i=1;

	$sql="SELECT count(currabrev)
			FROM currencies WHERE currabrev='".$_POST['Abbreviation']."'";
	$result=DB_query($sql, $db);
	$myrow=DB_fetch_row($result);

	if ($myrow[0]!=0 and !isset($SelectedCurrency)) {
		$InputError = 1;
		prnMsg( 'The currency already exists in the database','error');
		$Errors[$i] = 'Abbreviation';
		$i++;
	}
    if (strlen($_POST['Abbreviation']) > 3) {
        $InputError = 1;
        prnMsg('The currency abbreviation must be 3 characters or less long and for automated currency updates to work correctly be one of the ISO4217 currency codes','error');
		$Errors[$i] = 'Abbreviation';
		$i++;
    }
	if (!is_numeric($_POST['ExchangeRate'])){
        $InputError = 1;
       prnMsg('The exchange rate must be numeric','error');
		$Errors[$i] = 'ExchangeRate';
		$i++;
    }
    if (strlen($_POST['CurrencyName']) > 20) {
        $InputError = 1;
        prnMsg('The currency name must be 20 characters or less long','error');
		$Errors[$i] = 'CurrencyName';
		$i++;
    }
    if (strlen($_POST['Country']) > 50) {
        $InputError = 1;
        prnMsg('The currency country must be 50 characters or less long','error');
		$Errors[$i] = 'Country';
		$i++;
    }
    if (strlen($_POST['HundredsName']) > 15) {
        $InputError = 1;
        prnMsg('The hundredths name must be 15 characters or less long','error');
		$Errors[$i] = 'HundredsName';
		$i++;
    }
    if (($FunctionalCurrency != '') and (isset($SelectedCurrency) and $SelectedCurrency==$FunctionalCurrency)){
        $InputError = 1;
        prnMsg('The functional currency cannot be modified or deleted','error');
    }
    if (strstr($_POST['Abbreviation'],"'") OR strstr($_POST['Abbreviation'],'+') OR strstr($_POST['Abbreviation'],"\"") OR strstr($_POST['Abbreviation'],'&') OR strstr($_POST['Abbreviation'],' ') OR strstr($_POST['Abbreviation'],"\\") OR strstr($_POST['Abbreviation'],'.') OR strstr($_POST['Abbreviation'],'"')) {
		$InputError = 1;
		prnMsg( 'The currency code cannot contain any of the following characters' . " . - ' & + \" " . 'or a space','error');
		$Errors[$i] = 'Abbreviation';
		$i++;
	}

    if (isset($SelectedCurrency) AND $InputError !=1) {

        /*SelectedCurrency could also exist if submit had not been clicked this code would not run in this case cos submit is false of course  see the delete code below*/
        $sql = "UPDATE currencies SET
					currency='" . $_POST['CurrencyName'] . "',
					country='". $_POST['Country']. "',
					hundredsname='" . $_POST['HundredsName'] . "',
					rate=" .$_POST['ExchangeRate'] . "
					WHERE currabrev = '" . $SelectedCurrency . "'";

        $msg = 'The currency definition record has been updated';
    } else if ($InputError !=1) {

    /*Selected currencies is null cos no item selected on first time round so must be adding a record must be submitting new entries in the new payment terms form */
    	$sql = "INSERT INTO currencies (currency,
    					currabrev,
						country,
						hundredsname,
						rate)
				VALUES ('" . $_POST['CurrencyName'] . "',
					'" . $_POST['Abbreviation'] . "',
					'" . $_POST['Country'] . "',
					'" . $_POST['HundredsName'] .  "',
					" . $_POST['ExchangeRate'] . ")";

    	$msg = 'The currency definition record has been added';
    }
    //run the SQL from either of the above possibilites
    $result = DB_query($sql,$db);
    if ($InputError!=1){
    	prnMsg( $msg,'success');
    }
    unset($SelectedCurrency);
    unset($_POST['CurrencyName']);
    unset($_POST['Country']);
    unset($_POST['HundredsName']);
    unset($_POST['ExchangeRate']);
    unset($_POST['Abbreviation']);

} elseif (isset($_GET['delete'])) {
//the link to delete a selected record was clicked instead of the submit button

// PREVENT DELETES IF DEPENDENT RECORDS IN DebtorsMaster

    $sql= "SELECT COUNT(*) FROM debtorsmaster WHERE debtorsmaster.currcode = '" . $SelectedCurrency . "'";
    $result = DB_query($sql,$db);
    $myrow = DB_fetch_row($result);
    if ($myrow[0] > 0)
    {
        prnMsg('Cannot delete this currency because customer accounts have been created referring to this currency' .
         	'<br>' . 'There are' . ' ' . $myrow[0] . ' ' . 'customer accounts that refer to this currency','warn');
    } else {
        $sql= "SELECT COUNT(*) FROM suppliers WHERE suppliers.currcode = '$SelectedCurrency'";
        $result = DB_query($sql,$db);
        $myrow = DB_fetch_row($result);
        if ($myrow[0] > 0)
        {
            prnMsg(_('Cannot delete this currency because supplier accounts have been created referring to this currency')
             . '<br>' . 'There are' . ' ' . $myrow[0] . ' ' . 'supplier accounts that refer to this currency','warn');
        } else {
            $sql= "SELECT COUNT(*) FROM banktrans WHERE banktrans.currcode = '" . $SelectedCurrency . "'";
            $result = DB_query($sql,$db);
            $myrow = DB_fetch_row($result);
            if ($myrow[0] > 0){
                prnMsg('Cannot delete this currency because there are bank transactions that use this currency' .
                '<br>' . ' ' . 'There are' . ' ' . $myrow[0] . ' ' . 'bank transactions that refer to this currency','warn');
            } elseif ($FunctionalCurrency==$SelectedCurrency){
                prnMsg('Cannot delete this currency because it is the functional currency of the company','warn');
            } else {
                //only delete if used in neither customer or supplier, comp prefs, bank trans accounts
                $sql="DELETE FROM currencies WHERE currabrev='" . $SelectedCurrency . "'";
                $result = DB_query($sql,$db);
                prnMsg('The currency definition record has been deleted','success');
            }
        }
    }
    //end if currency used in customer or supplier accounts
}

if (!isset($SelectedCurrency)) {

/* It could still be the second time the page has been run and a record has been selected for modification - SelectedCurrency will exist because it was sent with the new call. If its the first time the page has been displayed with no parameters
then none of the above are true and the list of payment terms will be displayed with
links to delete or edit each. These will call the same page again and allow update/input
or deletion of the records*/

    $sql = 'SELECT currency, currabrev, country, hundredsname, rate FROM currencies';
    $result = DB_query($sql, $db);
    
    echo '<div class="uk-overflow-container">';
 	echo '<table align="center" class="uk-table">';
    echo '<tr><td></td>
    		<th>' . 'ISO4217 Code' . '</th>
    		<th>' . 'Currency' . '</th>
			<th>' . 'Country' . '</th>
			<th>' . 'Hundredth Name' . '</th>
			<th>' . 'Exchange Rate' . '</th>
			<th>' . 'Ex Rate - European Central Bank' .'</th>
			</tr>';

    $k=0; //row colour counter
    /*Get published currency rates from Eurpoean Central Bank */
    $CurrencyRatesArray = GetECBCurrencyRates();

    while ($myrow = DB_fetch_row($result)) {
        if ($myrow[1]==$FunctionalCurrency){
            echo '<tr bgcolor=#FFbbbb>';
        } elseif ($k==1){
            echo '<tr class="EvenTableRows">';
            $k=0;
        } else {
            echo  '<tr class="OddTableRows">';;
            $k++;
        }
        // Lets show the country flag
        $ImageFile = 'flags/' . strtoupper($myrow[1]) . '.gif';

		if(!file_exists($ImageFile)){
			$ImageFile =  'flags/blank.gif';
		}

        if ($myrow[1]!=$FunctionalCurrency){
            printf("<td><img src=\"%s\"></td>
            		<td>%s</td>
	    			<td>%s</td>
					<td>%s</td>
					<td>%s</td>
					<td class=number>%s</td>
					<td class=number>%s</td>
					<td><a href=\"%s&SelectedCurrency=%s\">%s</a></td>
					<td><a href=\"%s&SelectedCurrency=%s&delete=1\">%s</a></td>
					<td><a href=\"%s/ExchangeRateTrend.php?%s\">" . 'Graph' . "</a></td>
					</tr>",
					$ImageFile,
					$myrow[1],
					$myrow[0],
					$myrow[2],
					$myrow[3],
					number_format($myrow[4],5),
					number_format(GetCurrencyRate($myrow[1],$CurrencyRatesArray),5),
					$_SERVER['PHP_SELF'] . '?' . SID,
					$myrow[1],
					'Edit',
					$_SERVER['PHP_SELF'] . '?' . SID,
					$myrow[1],
					'Delete',
					$rootpath,
					SID . '&CurrencyToShow=' . $myrow[1]);
        } else {
            printf("<td><img src=\"%s\"></td>
            		<td>%s</td>
	    			<td>%s</td>
					<td>%s</td>
					<td>%s</td>
					<td class=number>%s</td>
					<td colspan=4>%s</td>
					</tr>",
					$ImageFile,
					$myrow[1],
					$myrow[0],
					$myrow[2],
					$myrow[3],
					1,
					'Functional Currency');
        }

    } //END WHILE LIST LOOP
    echo '</table></div>';
} //end of ifs and buts!


if (isset($SelectedCurrency)) {
    echo '<div class="centre"  style="margin-top:80px;"><a href=' .$_SERVER['PHP_SELF']  . '?' . SID. '>'.'Show all currency definitions'.'</a></div>';
}

echo '<br>';

if (!isset($_GET['delete'])) {

    echo "<form method='post' action=" . $_SERVER['PHP_SELF'] . '?' . SID . '>';

    if (isset($SelectedCurrency) AND $SelectedCurrency!='') {
        //editing an existing payment terms

        $sql = "SELECT currency,
				currabrev,
				country,
				hundredsname,
				rate
				FROM currencies
				WHERE currabrev='" . $SelectedCurrency . "'";

        $ErrMsg = 'An error occurred in retrieving the currency information';;
		$result = DB_query($sql, $db, $ErrMsg);

        $myrow = DB_fetch_array($result);

        $_POST['Abbreviation'] = $myrow['currabrev'];
        $_POST['CurrencyName']  = $myrow['currency'];
        $_POST['Country']  = $myrow['country'];
        $_POST['HundredsName']  = $myrow['hundredsname'];
        $_POST['ExchangeRate']  = $myrow['rate'];



        echo '<input type="hidden" name="SelectedCurrency" VALUE="' . $SelectedCurrency . '">';
        echo '<input type="hidden" name="Abbreviation" VALUE="' . $_POST['Abbreviation'] . '">';
        echo '<table  style="margin-top:50px;" align="center" class="uk-table"><tr>
			<td>' . 'ISO 4217 Currency Code'.':</td>
			<td>';
        echo $_POST['Abbreviation'] . '</td></tr>';

    } else { //end of if $SelectedCurrency only do the else when a new record is being entered
		if (!isset($_POST['Abbreviation'])) {$_POST['Abbreviation']='';}
        echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Currency Abbreviation
			<input type="Text" name="Abbreviation" value="' . $_POST['Abbreviation'] . '" class="md-input" size=4 maxlength=3></div>';
    	   }

    echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Currency Name';
    if (!isset($_POST['CurrencyName'])) {$_POST['CurrencyName']='';}
    echo '<input ' . (in_array('CurrencyName',$Errors) ?  'class="inputerror"' : '' ) .' type="text" name="CurrencyName" class="md-input" size=20 maxlength=20 VALUE="' . $_POST['CurrencyName'] . '"></div>';
    echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Country';
    
	echo '<select name="Country" onChange="return assignComboToInput(this,'.'Country'.')" class="md-input">
  <option value="" selected="selected">Select a Country</option>
  <option value="af">Afghanistan</option>
  <option value="ax">Akrotiri</option>
  <option value="al">Albania</option>
  <option value="ag">Algeria</option>
  <option value="aq">American Samoa</option>
  <option value="an">Andorra</option>
  <option value="ao">Angola</option>
  <option value="av">Anguilla</option>
  <option value="ay">Antarctica</option>
  <option value="ac">Antigua and Barbuda</option>
  <option value="xq">Arctic Ocean</option>
  <option value="ar">Argentina</option>
  <option value="am">Armenia</option>
  <option value="aa">Aruba</option>
  <option value="at">Ashmore Islands</option>
  <option value="zh">Atlantic Ocean</option>
  <option value="as">Australia</option>
  <option value="au">Austria</option>
  <option value="aj">Azerbaijan</option>
  <option value="bf">Bahamas, The</option>
  <option value="ba">Bahrain</option>
  <option value="fq">Baker Island</option>
  <option value="bg">Bangladesh</option>
  <option value="bb">Barbados</option>
  <option value="bs">Bassas da India</option>
  <option value="bo">Belarus</option>
  <option value="be">Belgium</option>
  <option value="bh">Belize</option>
  <option value="bn">Benin</option>
  <option value="bd">Bermuda</option>
  <option value="bt">Bhutan</option>
  <option value="bl">Bolivia</option>
  <option value="bk">Bosnia</option>
  <option value="bc">Botswana</option>
  <option value="bv">Bouvet Island</option>
  <option value="br">Brazil</option>
  <option value="vi">British Virgin Islands</option>
  <option value="bx">Brunei</option>
  <option value="bu">Bulgaria</option>
  <option value="uv">Burkina Faso</option>
  <option value="bm">Burma</option>
  <option value="by">Burundi</option>
  <option value="cb">Cambodia</option>
  <option value="cm">Cameroon</option>
  <option value="ca">Canada</option>
  <option value="cv">Cape Verde</option>
  <option value="cj">Cayman Islands</option>
  <option value="ct">Central African Republic</option>
  <option value="cd">Chad</option>
  <option value="ci">Chile</option>
  <option value="ch">China</option>
  <option value="kt">Christmas Island</option>
  <option value="ip">Clipperton Island</option>
  <option value="ck">Cocos (Keeling) Islands</option>
  <option value="co">Colombia</option>
  <option value="cn">Comoros</option>
  <option value="cg">Congo, Democratic Republic of the</option>
  <option value="cf">Congo, Republic of the</option>
  <option value="cw">Cook Islands</option>
  <option value="cr">Coral Sea Islands</option>
  <option value="cs">Costa Rica</option>
  <option value="iv">Cote dIvoire</option>
  <option value="hr">Croatia</option>
  <option value="cu">Cuba</option>
  <option value="cy">Cyprus</option>
  <option value="ez">Czech Republic</option>
  <option value="da">Denmark</option>
  <option value="dx">Dhekelia</option>
  <option value="dj">Djibouti</option>
  <option value="do">Dominica</option>
  <option value="dr">Dominican Republic</option>
  <option value="tt">East Timor</option>
  <option value="ec">Ecuador</option>
  <option value="eg">Egypt</option>
  <option value="es">El Salvador</option>
  <option value="ek">Equatorial Guinea</option>
  <option value="er">Eritrea</option>
  <option value="en">Estonia</option>
  <option value="et">Ethiopia</option>
  <option value="eu">Europa Island</option>
  <option value="fk">Falkland Islands (Islas Malvinas)</option>
  <option value="fo">Faroe Islands</option>
  <option value="fj">Fiji</option>
  <option value="fi">Finland</option>
  <option value="fr">France</option>
  <option value="fg">French Guiana</option>
  <option value="fp">French Polynesia</option>
  <option value="fs">French Southern and Antarctic Lands</option>
  <option value="gb">Gabon</option>
  <option value="ga">Gambia, The</option>
  <option value="gz">Gaza Strip</option>
  <option value="gg">Georgia</option>
  <option value="gm">Germany</option>
  <option value="gh">Ghana</option>
  <option value="gi">Gibraltar</option>
  <option value="go">Glorioso Islands</option>
  <option value="gr">Greece</option>
  <option value="gl">Greenland</option>
  <option value="gj">Grenada</option>
  <option value="gp">Guadeloupe</option>
  <option value="gq">Guam</option>
  <option value="gt">Guatemala</option>
  <option value="gk">Guernsey</option>
  <option value="gv">Guinea</option>
  <option value="pu">Guinea-Bissau</option>
  <option value="gy">Guyana</option>
  <option value="ha">Haiti</option>
  <option value="hm">Heard Island and McDonald Islands</option>
  <option value="vt">Holy See (Vatican City)</option>
  <option value="ho">Honduras</option>
  <option value="hk">Hong Kong</option>
  <option value="hq">Howland Island</option>
  <option value="hu">Hungary</option>
  <option value="ic">Iceland</option>
  <option value="in">India</option>
  <option value="xo">Indian Ocean</option>
  <option value="id">Indonesia</option>
  <option value="ir">Iran</option>
  <option value="iz">Iraq</option>
  <option value="ei">Ireland</option>
  <option value="is">Israel</option>
  <option value="it">Italy</option>
  <option value="jm">Jamaica</option>
  <option value="jn">Jan Mayen</option>
  <option value="ja">Japan</option>
  <option value="dq">Jarvis Island</option>
  <option value="je">Jersey</option>
  <option value="jq">Johnston Atoll</option>
  <option value="jo">Jordan</option>
  <option value="ju">Juan de Nova Island</option>
  <option value="kz">Kazakhstan</option>
  <option value="ke">Kenya</option>
  <option value="kq">Kingman Reef</option>
  <option value="kr">Kiribati</option>
  <option value="kn">Korea, North</option>
  <option value="ks">Korea, South</option>
  <option value="ku">Kuwait</option>
  <option value="kg">Kyrgyzstan</option>
  <option value="la">Laos</option>
  <option value="lg">Latvia</option>
  <option value="le">Lebanon</option>
  <option value="lt">Lesotho</option>
  <option value="li">Liberia</option>
  <option value="ly">Libya</option>
  <option value="ls">Liechtenstein</option>
  <option value="lh">Lithuania</option>
  <option value="lu">Luxembourg</option>
  <option value="mc">Macau</option>
  <option value="mk">Macedonia</option>
  <option value="ma">Madagascar</option>
  <option value="mi">Malawi</option>
  <option value="my">Malaysia</option>
  <option value="mv">Maldives</option>
  <option value="ml">Mali</option>
  <option value="mt">Malta</option>
  <option value="im">Man, Isle of</option>
  <option value="rm">Marshall Islands</option>
  <option value="mb">Martinique</option>
  <option value="mr">Mauritania</option>
  <option value="mp">Mauritius</option>
  <option value="mf">Mayotte</option>
  <option value="mx">Mexico</option>
  <option value="fm">Micronesia, Federated States of</option>
  <option value="mq">Midway Islands</option>
  <option value="md">Moldova</option>
  <option value="mn">Monaco</option>
  <option value="mg">Mongolia</option>
  <option value="mj">Montenegro</option>
  <option value="mh">Montserrat</option>
  <option value="mo">Morocco</option>
  <option value="mz">Mozambique</option>
  <option value="wa">Namibia</option>
  <option value="nr">Nauru</option>
  <option value="bq">Navassa Island</option>
  <option value="np">Nepal</option>
  <option value="nl">Netherlands</option>
  <option value="nt">Netherlands Antilles</option>
  <option value="nc">New Caledonia</option>
  <option value="nz">New Zealand</option>
  <option value="nu">Nicaragua</option>
  <option value="ng">Niger</option>
  <option value="ni">Nigeria</option>
  <option value="ne">Niue</option>
  <option value="nf">Norfolk Island</option>
  <option value="cq">Northern Mariana Islands</option>
  <option value="no">Norway</option>
  <option value="mu">Oman</option>
  <option value="zn">Pacific Ocean</option>
  <option value="pk">Pakistan</option>
  <option value="ps">Palau</option>
  <option value="lq">Palmyra Atoll</option>
  <option value="pm">Panama</option>
  <option value="pp">Papua New Guinea</option>
  <option value="pf">Paracel Islands</option>
  <option value="pa">Paraguay</option>
  <option value="pe">Peru</option>
  <option value="rp">Philippines</option>
  <option value="pc">Pitcairn Islands</option>
  <option value="pl">Poland</option>
  <option value="po">Portugal</option>
  <option value="rq">Puerto Rico</option>
  <option value="qa">Qatar</option>
  <option value="re">Reunion</option>
  <option value="ro">Romania</option>
  <option value="rs">Russia</option>
  <option value="rw">Rwanda</option>
  <option value="sh">Saint Helena</option>
  <option value="sc">Saint Kitts and Nevis</option>
  <option value="st">Saint Lucia</option>
  <option value="sb">Saint Pierre and Miquelon</option>
  <option value="vc">Saint Vincent and the Grenadines</option>
  <option value="ws">Samoa</option>
  <option value="sm">San Marino</option>
  <option value="tp">Sao Tome and Principe</option>
  <option value="sa">Saudi Arabia</option>
  <option value="sg">Senegal</option>
  <option value="sr">Serbia</option>
  <option value="se">Seychelles</option>
  <option value="sl">Sierra Leone</option>
  <option value="sn">Singapore</option>
  <option value="lo">Slovakia</option>
  <option value="si">Slovenia</option>
  <option value="bp">Solomon Islands</option>
  <option value="so">Somalia</option>
  <option value="sf">South Africa</option>
  <option value="sx">South Georgia and the South Sandwich Islands</option>
  <option value="oo">Southern Ocean</option>
  <option value="sp">Spain</option>
  <option value="pg">Spratly Islands</option>
  <option value="ce">Sri Lanka</option>
  <option value="su">Sudan</option>
  <option value="ns">Suriname</option>
  <option value="sv">Svalbard</option>
  <option value="wz">Swaziland</option>
  <option value="sw">Sweden</option>
  <option value="sz">Switzerland</option>
  <option value="sy">Syria</option>
  <option value="ti">Tajikistan</option>
  <option value="tz">Tanzania</option>
  <option value="th">Thailand</option>
  <option value="to">Togo</option>
  <option value="tl">Tokelau</option>
  <option value="tn">Tonga</option>
  <option value="td">Trinidad and Tobago</option>
  <option value="te">Tromelin Island</option>
  <option value="ts">Tunisia</option>
  <option value="tu">Turkey</option>
  <option value="tx">Turkmenistan</option>
  <option value="tk">Turks and Caicos Islands</option>
  <option value="tv">Tuvalu</option>
  <option value="ug">Uganda</option>
  <option value="up">Ukraine</option>
  <option value="ae">United Arab Emirates</option>
  <option value="uk">United Kingdom</option>
  <option value="us">United States</option>
  <option value="um">United States Pacific Island Wildlife Refuges</option>
  <option value="uy">Uruguay</option>
  <option value="uz">Uzbekistan</option>
  <option value="nh">Vanuatu</option>
  <option value="ve">Venezuela</option>
  <option value="vm">Vietnam</option>
  <option value="vq">Virgin Islands</option>
  <option value="wq">Wake Island</option>
  <option value="wf">Wallis and Futuna</option>
  <option value="we">West Bank</option>
  <option value="wi">Western Sahara</option>
  <option value="ym">Yemen</option>
  <option value="za">Zambia</option>
  <option value="zi">Zimbabwe</option>
  <option value="tw">Taiwan</option>
</select></div>';
     
    echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Hundredths Name';
    if (!isset($_POST['HundredsName'])) {$_POST['HundredsName']='';}
    echo '<input ' . (in_array('HundredsName',$Errors) ?  'class="inputerror"' : '' ) .' type="text" name="HundredsName" class="md-input" size=10 maxlength=15 VALUE="'. $_POST['HundredsName'].'"></div>';
    echo '<div class="uk-width-medium-1-2" style="padding-bottom:10px">Exchange Rate';
	if (!isset($_POST['ExchangeRate'])) {$_POST['ExchangeRate']='';}
    echo '<input ' . (in_array('ExchangeRate',$Errors) ?  'class="inputerror"' : '' ) .' type="text" class="md-input" name="ExchangeRate" size=10 maxlength=9 VALUE='. $_POST['ExchangeRate'].'></div>';
    echo '<div class="centre"><input type="Submit" name="submit" value='.'Enter Information'.' class="md-btn md-btn-primary">';
	echo '<input type="button" Name="back" value="' . 'Back' . '"  onclick="document.location.href=\'index.php\';" class="md-btn md-btn-primary"></div>';
    echo '</form></div>';

} //end if record deleted no point displaying form to add record


?>
