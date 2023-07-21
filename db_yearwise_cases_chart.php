<?php

/* $Revision: 1.83 $ */
$PageSecurity = 2;

include('includes/session.php');

$title='LawPract';

//Include the code
require_once 'includes/phplot/phplot.php';

/*$data = array(
array('Jan', 40,60),
array('Feb', 10,50),
array('Mar', 10,20),
array('Apr', 18,45),
array('May', 40,10),
array('Jun', 12,30),
array('Jul', 22,64),
array('Aug', 19,43),
array('Sep', 41,9),
array('Oct', 55,47),
array('Nov', 63,16),
array('Dec', 7,80),

);*/

$data=array();
$i=0;//cal counter

$cal=array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');

$currmonth=date("m");
$curryear=date("Y");

 $DateString = Date($_SESSION['DefaultDateFormat']);
	
		$date = new DateTime(FormatDateForSQL($DateString));
                //$date->sub(new DateInterval('P1D'));  
				
		//$date->add(new DateInterval('P1M'));  

$a=array();

for($j=0;$j<12;$j++)
{		
//count cases

$sqlcases = "SELECT COUNT(*) FROM lw_trans WHERE lw_trans.nextcourtdate LIKE '%" . $date->format('Y') .'-' . $date->format('m') . '-' . "%'";
	
	$Resultcases=DB_query($sqlcases,$db);
	
	$myrowcases=DB_fetch_row($Resultcases);
	
	$a[$j]=$myrowcases[0];
	
	$date->add(new DateInterval('P1M')); 
}


for($m=0;$m<12;$m++)
{
$data[$m]=array($cal[0],$a[$m]);
}

//var_dump($a);

//var_dump($data);
$plot = new PHPlot(580, 310);
$plot->SetImageBorderType('raised');
$plot->SetPlotType('bars');
$plot->SetDataType('text-data');
$plot->SetDataValues($data);

$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');

# Main plot title:
$plot->SetTitle('Month Wise Cases - (Current Year)');

$plot->SetLegend(array('Cases', 'Matters'));
# Make legend lines go bottom to top, like the bar segments (PHPlot > 5.4.0)
$plot->SetLegendReverse(True);
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');
# Turn on Y Data Labels: Both total and segment labels:
$plot->SetYDataLabelPos('plotstack');

$plot->DrawGraph();



?>
