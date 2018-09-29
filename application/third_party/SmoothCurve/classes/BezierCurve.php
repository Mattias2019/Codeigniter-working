<?php
/*****************************************************
* Bezier curve approximation class v0.3              *
* (c) Ross Vladislav, 2010-2011                      *
* vladislav.ross@gmail.com http://ross.vc/graph      *
* Based on code by (c) Tolga Birdal:                 *
* http://codeproject.com/KB/recipes/BezirCurves.aspx *
* See README for more information                    *
*****************************************************/

class BezierCurve extends SmoothCurve
{
	private $factorialLookup;
	
	public	function setCoords(&$arCoords, $step = 1, $minX = - 1, $maxX = - 1)
	{
		if(count($arCoords) > 170)
		{
			$this->errMsg = 'Too many arguments: 170 max';
			return false;
		}
		
		if(count($arCoords) < 4)
		{
			$this->errMsg = 'Too few arguments: need 4 points at least.';
			return false;
		}
		
		$this->prepareCoords($arCoords, $step, $minX, $maxX);
	}

	public function process()
	{
		foreach($this->arX as $k => $v)
		{
			$ptind[] = $v;
			$ptind[] = $this->arY[$k];
		}

		$this->Bezier2D($ptind, ($this->maxX - $this->minX) / $this->step, $p);
		for ($i = 0; $i < count($p) / 2; $i++)
		{
			$coords[$p[$i * 2]] = $p[$i * 2 + 1];
		}

		return $coords;
	}

	private function factorial($n)
	{
		if ($n > 170) exit; 
		if (!isset($this->factorialLookup[$n]))
		{
			$f = 1;
			for ($i = 2; $i <= $n; $i++)
			{
				$f*= $i;
			}

			$this->factorialLookup[$n] = $f;
		}

		return $this->factorialLookup[$n]; 
	}

	private function Ni($n, $i)
	{
		$a1 = $this->factorial($n);
		$a2 = $this->factorial($i);
		$a3 = $this->factorial($n - $i);
		$ni = $a1 / ($a2 * $a3);
		return $ni;
	}

	private function Bernstein($n, $i, $t)
	{
		if ($t == 0.0 && $i == 0) $ti = 1.0;
		else $ti = pow($t, $i);
		if ($n == $i && $t == 1.0) $tni = 1.0;
		else $tni = pow((1 - $t) , ($n - $i));

		$basis = $this->Ni($n, $i) * $ti * $tni;
		return $basis;
	}

	private function Bezier2D($b, $cpts, &$p)
	{
		$npts = (count($b)) / 2;

		$icount = 0;
		$t = 0;
		$step = 1.0 / ($cpts - 1);
		for ($i1 = 0; $i1 != $cpts; $i1++)
		{
			if ((1.0 - $t) < 5e-6) $t = 1.0;
			$jcount = 0;
			$p[$icount] = 0.0;
			$p[$icount + 1] = 0.0;
			for ($i = 0; $i != $npts; $i++)
			{
				$basis = $this->Bernstein($npts - 1, $i, $t);
				$p[$icount]+= $basis * $b[$jcount];
				$p[$icount + 1]+= $basis * $b[$jcount + 1];
				$jcount = $jcount + 2;
			}

			$icount+= 2;
			$t+= $step;
		}
	}
}
