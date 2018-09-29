<?php
/*****************************************************
* Lagrange polynomial interpolation class v0.3       *
* (c) Ross Vladislav, 2010-2011                      *
* vladislav.ross@gmail.com http://ross.vc/graph      *
* Based on code from wikipedia                       *
* See README for more information                    *
******************************************************/
class CubicSpline extends SmoothCurve

{
	private $splines = array();
	
	public function setCoords(&$arCoords, $step = 1, $minX = -1, $maxX = -1)
	{
		$this->splines = array();
		
		if(count($arCoords) < 4)
		{
			$this->errMsg = 'Too few arguments: need 4 points at least.';
			return false;
		}
		
		$this->prepareCoords($arCoords, $step, $minX, $maxX);
		$this->buildSpline($this->arX, $this->arY, count($this->arX));
	}

	public function process()
	{
		for ($x = $this->minX; $x <= $this->maxX; $x += $this->step)
		{
			$this->arCoords[$x] = $this->funcInterp($x);
		}

		return $this->arCoords;
	}

	private	function buildSpline($x, $y, $n)
	{
		for ($i = 0; $i < $n; ++$i)
		{
			$this->splines[$i]['x'] = $x[$i];
			$this->splines[$i]['a'] = $y[$i];
		}

		$this->splines[0]['c'] = $this->splines[$n - 1]['c'] = 0;
		$alpha[0] = $beta[0] = 0;
		for ($i = 1; $i < $n - 1; ++$i)
		{
			$h_i = $x[$i] - $x[$i - 1];
			$h_i1 = $x[$i + 1] - $x[$i];
			$A = $h_i;
			$C = 2.0 * ($h_i + $h_i1);
			$B = $h_i1;
			$F = 6.0 * (($y[$i + 1] - $y[$i]) / $h_i1 - ($y[$i] - $y[$i - 1]) / $h_i);
			$z = ($A * $alpha[$i - 1] + $C);
			$alpha[$i] = - $B / $z;
			$beta[$i] = ($F - $A * $beta[$i - 1]) / $z;
		}

		for ($i = $n - 2; $i > 0; --$i)
		{
			$this->splines[$i]['c'] = $alpha[$i] * $this->splines[$i + 1]['c'] + $beta[$i];
		}

		for ($i = $n - 1; $i > 0; --$i)
		{
			$h_i = $x[$i] - $x[$i - 1];
			$this->splines[$i]['d'] = ($this->splines[$i]['c'] - $this->splines[$i - 1]['c']) / $h_i;
			$this->splines[$i]['b'] = $h_i * (2.0 * $this->splines[$i]['c'] + $this->splines[$i - 1]['c']) / 6.0 + ($y[$i] - $y[$i - 1]) / $h_i;
		}
	}

	private	function funcInterp($x)
	{
		$n = count($this->splines);
		if ($x <= $this->splines[0]['x']) 
		$s = $this->splines[1];
		else
		if ($x >= $this->splines[$n - 1]['x'])
		{
			$s = $this->splines[$n - 1];
		}
		else
		{
			$i = 0;
			$j = $n - 1;
			while ($i + 1 < $j)
			{
				$k = $i + ($j - $i) / 2;
				if ($x <= $this->splines[$k]['x']) $j = $k;
				else $i = $k;
			}

			$s = $this->splines[$j];
		}

		$dx = ($x - $s['x']);
		return $s['a'] + ($s['b'] + ($s['c'] / 2.0 + $s['d'] * $dx / 6.0) * $dx) * $dx;
	}
}

?>