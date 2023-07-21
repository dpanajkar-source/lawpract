<?php


if (isset($Errors)) {
	unset($Errors);
}

//initialise no input errors assumed initially before we test
$InputError = 0;
$Errors = array();
$i=1;


if (isset($_POST['submit'])) {


	/* actions to take once the user has clicked the submit button
	ie the page has called itself with some user input */

	if ($InputError !=1){

		$sql = "UPDATE companies SET
				coyname='" . $_POST['CoyName'] . "',
				barnumber = '" . $_POST['BarNumber'] . "',
				address='" . $_POST['Address'] . "',
				country='" . $_POST['Country'] . "',
				telephone='" . $_POST['Telephone'] . "',
				mobile='" . $_POST['Mobile'] . "',			
				email='" . $_POST['Email'] . "',
				website='" . $_POST['website'] . "',
				currencydefault='" . $_POST['CurrencyDefault'] . "',
				debtorsact='" . $_POST['DebtorsAct'] . "',
				creditorsact='" . $_POST['CreditorsAct'] . "',
				retainedearnings='" . $_POST['RetainedEarnings'] . "'
				WHERE coycode=1";
			
			$ErrMsg =  'The company preferences could not be updated because';
			//$result = DB_query($sql,$db,$ErrMsg);
			//prnMsg( 'Company preferences updated','success');
			echo '<br>';

			/* Alter the exchange rates in the currencies table */

			/* Get default currency rate */
			$sql='SELECT rate from currencies WHERE currabrev="'.$_POST['CurrencyDefault'].'"';
			$result = DB_query($sql,$db);
			$myrow = DB_fetch_row($result);
			$NewCurrencyRate=$myrow[0];

			/* Set new rates */
			$sql='UPDATE currencies SET rate=rate/'.$NewCurrencyRate;
			$ErrMsg =  _('Could not update the currency rates');
			$result = DB_query($sql,$db,$ErrMsg);

			/* End of update currencies */

			$ForceConfigReload = True; // Required to force a load even if stored in the session vars
			include('includes/GetConfig.php');
			$ForceConfigReload = False;

	} else {
		prnMsg( 'Validation failed' . ', ' . 'no updates or deletes took place','warn');
	}

} /* end of if submit */
?>

  <?php
   
if ($InputError != 1) {
	$sql = "SELECT coyname,
		barnumber,
		address,
		country,
		telephone,
		mobile,	
		email,
		website,
		currencydefault,
		debtorsact,
		creditorsact,
		retainedearnings
	FROM companies
	WHERE coycode=1";


	$ErrMsg =  'The company preferences could not be retrieved because';
	$result = DB_query($sql, $db,$ErrMsg);


	$myrow = DB_fetch_array($result);

	$_POST['CoyName'] = $myrow['coyname'];
	$_POST['BarNumber']  = $myrow['barnumber'];
	$_POST['Address']  = $myrow['address'];
	$_POST['Country']  = $myrow['country'];
	$_POST['Telephone']  = $myrow['telephone'];
	$_POST['Mobile']  = $myrow['mobile'];	
	$_POST['Email']  = $myrow['email'];
	$_POST['website']  = $myrow['website'];
	$_POST['CurrencyDefault']  = $myrow['currencydefault'];
	$_POST['DebtorsAct']  = $myrow['debtorsact'];
	$_POST['CreditorsAct']  = $myrow['creditorsact'];	
	$_POST['RetainedEarnings'] = $myrow['retainedearnings'];
	
	
}?>
<?php 
echo '<form method="post" action=' . $_SERVER['PHP_SELF'] . '>'; ?>
 <div class="uk-width-medium-1-1" style="padding-bottom:10px">
        <div class="uk-grid uk-grid-width-2-2 uk-grid-width-large-2-2">
         
        <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-2-2">
        <div class="uk-form-row">
        <div class="uk-grid">
		
        <div class="uk-width-medium-1-4" style="padding-bottom:10px">Company Name
<input tabindex="1" type="Text" Name="CoyName" class="md-input" value="<?php echo stripslashes($_POST['CoyName']); ?>" size=30 maxlength=29>
	
</div>
 
<div class="uk-width-medium-1-4" style="padding-bottom:10px">
Barrister Number
<input tabindex="3" type="Text" Name="BarNumber" class="md-input" value="<?php echo $_POST['BarNumber']; ?>" size=30 maxlength=29>

</div>

<div class="uk-width-medium-1-4" style="padding-bottom:10px">
Address
<input tabindex="7" type="Text" Name="Address" class="md-input" size=30 maxlength=29 value="<?php echo stripslashes($_POST['Address']); ?>">
</div>

<!--<div class="uk-width-medium-1-4" style="padding-bottom:10px">
TelePhone
<input tabindex="18" type="Text" Name="Telephone" class="md-input" size=30 maxlength=29 value="">
</div>-->



<div class="uk-width-medium-1-4" style="padding-bottom:10px">
Email
<input tabindex="20" type="Text" Name="Email" class="md-input" size=30 maxlength=29 value="<?php echo $_POST['Email']; ?>">
</div>

<div class="uk-width-medium-1-4" style="padding-bottom:10px">
Mobile
<input tabindex="21" type="Text" Name="Mobile" class="md-input" size=30 maxlength=29 value="<?php echo $_POST['Mobile']; ?>">
</div>

<div class="uk-width-medium-1-4" style="padding-bottom:10px">
Country
<input tabindex="22" type="Text" Name="Country" class="md-input" size=30 maxlength=29 value="<?php echo stripslashes($_POST['Country']); ?>">
</div>

<!--<div class="uk-width-medium-1-4" style="padding-bottom:10px">
Website
<input tabindex="23" type="Text" Name="website" class="md-input" size=30 maxlength=29 value=">">
</div>-->

<?php        
  $result=DB_query("SELECT accountcode,
			accountname
		FROM chartmaster,
			accountgroups
		WHERE chartmaster.group_=accountgroups.groupname
		AND accountgroups.pandl=0
		ORDER BY chartmaster.accountcode",$db);

?>
<div class="uk-width-medium-1-4" style="padding-bottom:10px">Debtors Control

<select tabindex="27" Name="DebtorsAct" class="md-input">
<?php 
while ($myrow = DB_fetch_row($result)) {
	if ($_POST['DebtorsAct']==$myrow[0]){
		echo "<option selected VALUE='". $myrow[0] . "'>" . $myrow[1] . ' ('.$myrow[0].')';
	} else {
		echo "<option  VALUE='". $myrow[0] . "'>" . $myrow[1] . ' ('.$myrow[0].')';
	}
} //end while loop

DB_data_seek($result,0);  ?>
</select></div>


<?php 
 
echo '<div class="uk-width-medium-1-4" style="padding-bottom:10px">Creditors Control';
echo '<select tabindex="31" Name="CreditorsAct" class="md-input">';

while ($myrow = DB_fetch_row($result)) {
	if ($_POST['CreditorsAct']==$myrow[0]){
		echo "<option selected VALUE='". $myrow[0] . "'>" . $myrow[1] . ' ('.$myrow[0].')';
	} else {
		echo "<option  VALUE='". $myrow[0] . "'>" . $myrow[1] . ' ('.$myrow[0].')';
	}
} //end while loop
echo '</select></div>'; 


DB_data_seek($result,0); ?>

<div class="uk-width-medium-1-4" style="padding-bottom:10px">Retained Earnings
<select tabindex="32" Name="RetainedEarnings" class="md-input">

<?php
while ($myrow = DB_fetch_row($result)) {
	if ($_POST['RetainedEarnings']==$myrow[0]){
		echo "<option selected VALUE='". $myrow[0] . "'>" . $myrow[1] . ' ('.$myrow[0].')';
	} else {
		echo "<option  VALUE='". $myrow[0] . "'>" . $myrow[1] . ' ('.$myrow[0].')';
	}
} //end while loop


echo '</select></div>'; ?>

<div class="uk-width-medium-1-4" style="padding-bottom:10px">

Home Currency
<?php 
$result=DB_query("SELECT currabrev, currency FROM currencies",$db);

echo '<select tabindex="30" Name="CurrencyDefault" class="md-input">';

while ($myrow = DB_fetch_array($result)) {
	if ($_POST['CurrencyDefault']==$myrow['currabrev']){
		echo "<option selected VALUE='". $myrow['currabrev'] . "'>" . $myrow['currency'];
	} else {
		echo "<option VALUE='". $myrow['currabrev'] . "'>" . $myrow['currency'];
	}
} //end while loop
DB_free_result($result); ?>
</select></div>


</div></div>


<!--<div class="uk-form-row">
-->
<?php 
//echo '<input tabindex="49" type="submit" Name="submit" class="md-btn md-btn-primary" value="' . 'Update' . '">';
//echo '</div></div></div></div></div>';
  ?>
   





