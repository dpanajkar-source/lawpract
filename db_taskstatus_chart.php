<?php

/* $Revision: 1.83 $ */
$PageSecurity = 2;

include('includes/session.php');

$title='LawPract';

//Include the code
include('includes/phplot/phplot.php');

/*$data = array(
array('Jan', 40),
array('Feb', 10),
array('Mar', 10),
array('Apr', 18),
array('May', 40),
array('Jun', 12),
array('Jul', 22),
array('Aug', 19),
array('Sep', 41),
array('Oct', 55),
array('Nov', 63),
array('Dec', 7)
);*/

$data=array();

$a=array();
$j=0;

for($i=1;$i<=5;$i++)
{

$sqltasks = "SELECT COUNT(*) FROM lw_tasks WHERE taskstatus='" . $i . "'";
	
	$Resulttasks=DB_query($sqltasks,$db);
	
	$myrowtasks=DB_fetch_row($Resulttasks);
	
	$a[$j++]=$myrowtasks[0];
	
}

for($i=0;$i<=4;$i++)
{
$data[$i]=array('',$a[$i]);
}

$plot = new PHPlot(130,130);
$plot->SetImageBorderType('none');
$plot->SetDataType('text-data-single');
$plot->SetDataValues($data);
$plot->SetPlotType('pie');
$plot->SetRGBArray('large');
$colors = array('yellow', 'sky bluenew', 'red', 'purple', 'SpringGreen');
$plot->SetDataColors($colors);
//$plot->SetDrawPieBorders(); //creating issue with chart rendering
//$plot->SetLegend($colors);
//$plot->SetLegend(array('Not Started', 'In Progress','Completed','Deferred'));
$plot->SetShading(0);
$plot->SetLabelScalePosition(0.2);
$plot->DrawGraph();


?>
