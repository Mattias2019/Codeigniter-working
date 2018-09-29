<?php

define('GRAPH_WIDTH',  490);
define('GRAPH_HEIGHT', 150);


$testCoords[-215] = -24.2705098312;
$testCoords[-180] = 28.5316954889;
$testCoords[-145] = -9.27050983125;
$testCoords[-110] = -17.6335575688;
$testCoords[-75]  = 30;
$testCoords[-40]  = -17.6335575688;
$testCoords[-5]   = -9.27050983125;
$testCoords[30]   = 28.5316954889;
$testCoords[65]   = -24.2705098312;
$testCoords[100]  = 0;
$testCoords[135]  = 24.2705098312;
$testCoords[170]  = -28.5316954889;
$testCoords[205]  = 9.27050983125;
$testCoords[240]  = 17.6335575688;
$testCoords[275]  = -30;

$im = imagecreatetruecolor(GRAPH_WIDTH, GRAPH_HEIGHT);

$bgColor     = imagecolorallocate($im, 224, 223, 223);
$textColor   = imagecolorallocate($im, 0, 0, 0);
$axisColor   = imagecolorallocate($im, 64, 64, 64);
$dotColor    = imagecolorallocate($im, 192, 64, 64);
$graphColor  = imagecolorallocate($im, 64, 64, 192);

imagefill($im, 0, 0, $bgColor);

$testGraph = new Plot($testCoords);
$testGraph->drawDots($im, $dotColor, GRAPH_WIDTH / 2, GRAPH_HEIGHT / 2, 5);


$curve = new CubicSpline();

$curve->setCoords($testCoords, 5);
if(!$curve->getError()) 
{

	$curveCoords = $curve->process();
	if($r)
	{

		$curveGraph = new Plot($curveCoords);

		$curveGraph->drawLine($im, $graphColor, GRAPH_WIDTH / 2, GRAPH_HEIGHT / 2);
	}
}


header("Content-type: image/png");
imagepng($im);
imagedestroy($im);
?>
