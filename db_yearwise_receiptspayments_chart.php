<?php

/* $Revision: 1.83 $ */
$PageSecurity = 2;

include('includes/session.php');

$title='LawPract';

//Include the code
require_once 'includes/phplot/phplot.php';

$data=array();
$j=1;//cal counter

$cal=array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');

$currmonth=date("m");
$curryear=date("Y");

$DateStringnnew= date("Y-m-d", mktime(0, 0, 0, 1, 1, 2017));

$datenew = new DateTime($DateStringnnew);

$totalreceived=array();
$totalpaid=array();

for($m=0;$m<12;$m++)
{
$Statementclientreceipts= "SELECT SUM(amountreceived) FROM lw_partytrans WHERE type=12 AND receivedt LIKE '%" . $curryear .'-' . $datenew->format('m') . '-' . "%' ";
$resultclientreceipts=DB_query($Statementclientreceipts,$db);

$myrowclientreceipts=DB_fetch_row($resultclientreceipts);

$totalclientreceipts=$myrowclientreceipts[0];

//now find total payments to clients
$Statementclientpayments= "SELECT SUM(amountreceived) FROM lw_partytrans WHERE type=13 AND receivedt LIKE '%" . $curryear .'-' . $datenew->format('m') . '-' . "%' ";
$resultclientpayments=DB_query($Statementclientpayments,$db);

$myrowclientpayments=DB_fetch_row($resultclientpayments);

$totalclientpayments=$myrowclientpayments[0];


//now find total receipts from suppliers
$Statementsuppreceipts= "SELECT SUM(amount) FROM supptrans WHERE type=12 AND date LIKE '%" . $curryear .'-' . $datenew->format('m') . '-' . "%' ";
$resultsuppreceipts=DB_query($Statementsuppreceipts,$db);

$myrowsuppreceipts=DB_fetch_row($resultsuppreceipts);

$totalsuppreceipts=$myrowsuppreceipts[0];

//now find total payments from suppliers
$Statementsupppayments= "SELECT SUM(amount) FROM supptrans WHERE type=13 AND date LIKE '%" . $curryear .'-' . $datenew->format('m') . '-' . "%' ";
$resultsupppayments=DB_query($Statementsupppayments,$db);

$myrowsupppayments=DB_fetch_row($resultsupppayments);

$totalsupppayments=$myrowsupppayments[0];


$totalreceived[$m]=$totalclientreceipts+$totalsuppreceipts;

$totalpaid[$m]=$totalclientpayments+$totalsupppayments;

$datenew->add(new DateInterval('P1M'));

}



for($m=0;$m<12;$m++)
{
$data[$m]=array($cal[$m],$totalreceived[$m],$totalpaid[$m]);

}
	
//var_dump($data);
$plot = new PHPlot(580, 310);
$plot->SetImageBorderType('plain');
$plot->SetPlotType('bars');
$plot->SetDataType('text-data');
$plot->SetDataValues($data);

$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');

# Main plot title:
$plot->SetTitle('Yearly Cash Receipts & Payments - (Current Year)');
# Colors are significant to this data:
$plot->SetDataColors(array('blue', 'red'));

$plot->SetLegend(array('Receipts', 'Payments'));
# Make legend lines go bottom to top, like the bar segments (PHPlot > 5.4.0)
//$plot->SetLegendReverse(True);
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');
# Turn on Y Data Labels: Both total and segment labels:
//$plot->SetYDataLabelPos('plotstack');

$plot->DrawGraph();



?>
