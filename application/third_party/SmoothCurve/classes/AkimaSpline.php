<?php
/************************************************
* Akima spline interpolation class v0.3         *
* (c) Ross Vladislav, 2010-2011                 *
* vladislav.ross@gmail.com http://ross.vc/graph *
* Based on aspline.c code by (c) David Frey:    *
* http://homepage.hispeed.ch/david.frey/        *
* See README for more information               *
************************************************/


class AkimaSpline extends SmoothCurve
{
	public function setCoords(&$arCoords, $step = 1, $minX = - 1, $maxX = - 1)
	{
		if(count($arCoords) < 2)
		{
			$this->errMsg = 'Too few arguments: need 2 points at least.';
			return false;
		}
		$this->prepareCoords($arCoords, $step, $minX, $maxX);
	}

	public function process()
	{
		return $this->calcspline($this->arX, $this->arY, $this->coordsN, $this->step, $this->minX, $this->maxX);
	}

	private	function calcspline($x, $y, $n, $xstep, $llimit, $ulimit)
	{
		if ($n == 2)
		{ 
			$dx = $x[1] - $x[0];
			$dy = $y[1] - $y[0];

			//$xstep = ($ulimit - $llimit) / $d;
			$d = round(($ulimit - $llimit) / $xstep);
			$m = $dy / $dx; 
			for ($i = 0; $i <= $d; $i++)
			{
				$r[$x[0] + $i * $xstep] = $y[0] + $i * $m * $xstep;
			}
		}
		else
		{ 
			array_unshift($x, $x[0], $x[1]);
			$x[] = 0;
			$x[] = 0;
			array_unshift($y, $y[0], $y[1]);
			$y[] = 0;
			$y[] = 0;
			$n+= 4;

			$dx = array();
			$dy = array();
			$m = array();
			$t = array();
			
			for ($i = 2; $i <= ($n - 3); $i++)
			{
				$dx[$i] = $x[$i + 1] - $x[$i];
				$dy[$i] = $y[$i + 1] - $y[$i];
				$m[$i] = $dy[$i] / $dx[$i]; 
			}

			$x[1] = $x[2] + $x[3] - $x[4];
			$dx[1] = $x[2] - $x[1];
			$y[1] = $dx[1] * ($m[3] - 2 * $m[2]) + $y[2];
			$dy[1] = $y[2] - $y[1];
			$m[1] = $dy[1] / $dx[1];
			$x[0] = 2 * $x[2] - $x[4];
			$dx[0] = $x[1] - $x[0];
			$y[0] = $dx[0] * ($m[2] - 2 * $m[1]) + $y[1];
			$dy[0] = $y[1] - $y[0];
			$m[0] = $dy[0] / $dx[0];
			$x[$n - 2] = $x[$n - 3] + $x[$n - 4] - $x[$n - 5];
			$y[$n - 2] = (2 * $m[$n - 4] - $m[$n - 5]) * ($x[$n - 2] - $x[$n - 3]) + $y[$n - 3];
			$x[$n - 1] = 2 * $x[$n - 3] - $x[$n - 5];

			$y[$n - 1] = (2 * $m[$n - 3] - $m[$n - 4]) * ($x[$n - 1] - $x[$n - 2]) + $y[$n - 2];
			for ($i = $n - 3; $i < $n - 1; $i++)
			{
				$dx[$i] = $x[$i + 1] - $x[$i];
				$dy[$i] = $y[$i + 1] - $y[$i];
				$m[$i] = $dy[$i] / $dx[$i];
			}

			$t[0] = 0.0;
			$t[1] = 0.0; 
			for ($i = 2; $i < $n - 2; $i++)
			{
				$num = abs($m[$i + 1] - $m[$i]) * $m[$i - 1] + abs($m[$i - 1] - $m[$i - 2]) * $m[$i];
				$den = abs($m[$i + 1] - $m[$i]) + abs($m[$i - 1] - $m[$i - 2]);
				if ($den != 0) $t[$i] = $num / $den;
				else $t[$i] = 0.0;
			}

			for ($i = 2; $i < $n - 2; $i++)
			{
				@$C[$i] = (3 * $m[$i] - 2 * $t[$i] - $t[$i + 1]) / $dx[$i];
				@$D[$i] = ($t[$i] + $t[$i + 1] - 2 * $m[$i]) / ($dx[$i] * $dx[$i]);
			}

			$d = round(($ulimit - $llimit) / $xstep);
			$p = 2;

			for ($xv = $llimit; $xv < $ulimit + $xstep; $xv+= $xstep)
			{
				while ($xv >= $x[$p] && isset($x[$p]))
				{
					$r[$x[$p]] = $y[$p];
					$p++;
				}

				if ((($xv - $x[$p - 1]) > $xstep / 100.0) && (($x[$p] - $xv) > $xstep / 100.0))
				{
					$xd = ($xv - $x[$p - 1]);
					$r[$xv] = $y[$p - 1] + ($t[$p - 1] + ($C[$p - 1] + $D[$p - 1] * $xd) * $xd) * $xd;
				}
			}
		}
		return $r;
	}
	
}
