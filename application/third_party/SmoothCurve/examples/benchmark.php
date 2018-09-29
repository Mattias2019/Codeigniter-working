<?php
$arPoints = array(5, 15, 50);
$loops    = 100;
$size     = 500;



$curves['Lagrange polynomial'] = new LagrangePolynomial();
$curves['Cubic spline']        = new CubicSpline();
$curves['Akima spline']        = new AkimaSpline();
$curves['Bezier curve']        = new BezierCurve();

if(isset($_SERVER['REMOTE_ADDR'])) echo '<pre>';

foreach($curves as $name => $curve)
{
	printf("% -20s", $name);
	foreach($arPoints as $points)
	{
		$time = 0;
		for($l = 0; $l < $loops; $l++)
		{
			$testCoords = array();
			$x = 0;
			for($i = 0; $i < $points; $i++) 
			{
				$x += rand(1, $size / $points * 2);
				$y = rand(0, $size);	
				$testCoords[$x] = $y;
			}
			$start = microtime(1);
			$curve->setCoords($testCoords);
			$curve->process();
			$time += microtime(1) - $start;
		}
		printf("\t%3.3f", $time / $points);
	}
	echo "\r\n";
}

if(isset($_SERVER['REMOTE_ADDR'])) echo '</pre>';
?>