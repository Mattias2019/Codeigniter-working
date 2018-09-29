<?php
set_time_limit(15);

define('GRAPH_WIDTH',  500);
define('GRAPH_HEIGHT', 200);


if (isset($_GET['pn']) && in_array($_GET['pn'], array(5, 15, 50)))
{
	$pointsN = $_GET['pn'];
}
else
{
	$pointsN = 15;
}

if (isset($_GET['type']) && $_GET['type'] > 0 && $_GET['type'] < 6)
{
	$type = $_GET['type'];
}
else
{
	$type = 1;
}

$x = rand(10, 20);
$dx = (GRAPH_WIDTH - 40) / ($pointsN - 1);

for ($i = 0; $i < $pointsN; $i++)
{
	switch ($type)
	{
	case 1:
		if ($i == round(($pointsN - 1) / 2))
		{
			$y = GRAPH_HEIGHT - 20 - rand(0, 10);
		}
		else
		{
			$y = rand(GRAPH_HEIGHT / 2 - 50, GRAPH_HEIGHT / 2 - 45);
		}

		break;

	case 2:
		$y = rand(20, GRAPH_HEIGHT - 20);
		break;

	case 3:
		$y = $x / GRAPH_WIDTH * GRAPH_HEIGHT + rand(-15, 15);
		break;

	case 4:
		$y = sin($x * 2 * pi() / GRAPH_HEIGHT) * (GRAPH_HEIGHT / 2 - 20) + GRAPH_HEIGHT / 2;
		break;
	}

	$testCoords[$x] = $y;
	if ($_GET['xd'])
	{
		$x+= $dx;
	}
	else
	{
		$x+= rand(0, $dx * 2);
	}
}

$imgHeight = ($_GET['pl'] + $_GET['lp'] + $_GET['cs'] + $_GET['as'] + $_GET['bc']) * 20 + GRAPH_HEIGHT + 10;
$im = imagecreatetruecolor(GRAPH_WIDTH + 50, $imgHeight);

$bgColor   = imagecolorallocate($im, 224, 223, 223);
$textColor = imagecolorallocate($im, 0, 0, 0);
$axisColor = imagecolorallocate($im, 64, 64, 64);
$dotColor  = imagecolorallocate($im, 192, 64, 64);
imagefill($im, 0, 0, $bgColor);
$testGraph = new Plot($testCoords);
$testGraph->drawDots($im, $dotColor, 10, GRAPH_HEIGHT, 5);
$curves = array();

if ($_GET['pl'])
{
	$curves[] = false;
	$colors[] = imagecolorallocate($im, 192, 64, 64);
	$titles[] = 'Piecewise-linear    ';
}

if ($_GET['lp'] && $pointsN <= 15)
{
	$curves[] = new LagrangePolynomial();
	$colors[] = imagecolorallocate($im, 64, 192, 64);
	$titles[] = 'Lagrange polynomial ';
}

if ($_GET['cs'])
{
	$curves[] = new CubicSpline();
	$colors[] = imagecolorallocate($im, 64, 64, 192);
	$titles[] = 'Cubic spline        ';
}

if ($_GET['as'])
{
	$curves[] = new AkimaSpline();
	$colors[] = imagecolorallocate($im, 192, 64, 192);
	$titles[] = 'Akima spline        ';
}

if ($_GET['bc'])
{
	$curves[] = new BezierCurve();
	$colors[] = imagecolorallocate($im, 64, 192, 192);
	$titles[] = 'Bezier curve        ';
}

if ($_GET['pl'])
{
	$start = microtime(1);
	if ($_GET['aa'])
	{
		$testGraph->drawAALine($im, $color[0], 10, GRAPH_HEIGHT);
	}
	else
	{
		$testGraph->drawLine($im, $color[0], 10, GRAPH_HEIGHT);
	}

	$times[] = sprintf("%1.4f", microtime(1) - $start);
}

foreach($curves as $k => $curve)
{
	$start = microtime(1);
	if ($curve)
	{
		$curve->setCoords($testCoords, 1);
		$r = $curve->process();
		if($r) $curveGraph = new Plot($r);
		else continue;
	}
	else
	{
		$curveGraph = $testGraph;
	}

	if ($_GET['aa'])
	{
		$curveGraph->drawAALine($im, $colors[$k], 10, GRAPH_HEIGHT);
	}
	else
	{
		$curveGraph->drawLine($im, $colors[$k], 10, GRAPH_HEIGHT);
	}

	unset($curve);
	$times[$k] = sprintf("%1.4f", microtime(1) - $start);
}

imagefilledrectangle($im, 0, GRAPH_HEIGHT, GRAPH_WIDTH + 50, $imgHeight, $bgColor);
$testGraph->drawAxis($im, $axisColor, 10, GRAPH_HEIGHT);
$panelY = GRAPH_HEIGHT;

foreach($curves as $k => $curve)
{
	imagefilledrectangle($im, 10, $panelY + 10, 20, $panelY + 20, $colors[$k]);
	imagerectangle($im, 10, $panelY + 10, 20, $panelY + 20, $axisColor);
	imagettftext($im, 10, 0, 30, $panelY + 20, $textColor, 'lucon.ttf', $titles[$k] . $times[$k] . ' s');
	$panelY+= 20;
}

header("Content-type: image/png");
imagepng($im);
imagedestroy($im);
?>
