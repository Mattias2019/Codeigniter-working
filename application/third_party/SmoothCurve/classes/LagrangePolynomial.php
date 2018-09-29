<?php
/*****************************************************
* Lagrange polynomial interpolation class v0.3       *
* (c) Ross Vladislav, 2010-2011                      *
* vladislav.ross@gmail.com http://ross.vc/graph      *
* See README for more information                    *
******************************************************/

class LagrangePolynomial extends SmoothCurve 
{
	
	public function setCoords(&$arCoords, $step, $minX=-1, $maxX=-1)
	{
		
		if(count($arCoords) < 4)
		{
			$this->errMsg = 'Too few arguments: need 4 points at least.';
			return false;
		}
		
		$this->prepareCoords($arCoords, $step, $minX, $maxX);
	}
	
	public function process()
	{
		$n = count($this->arX);
		for($x = $this->minX; $x <= $this->maxX; $x += $this->step)
		{
			$this->arCoords[$x] = $this->LP($x);
		}
		return $this->arCoords;
	}
	
	private function LP($x)
	{
		$S = 0;
		for($k = 0; $k < $this->coordsN; $k++)
		{
			$l = 1;
			for($m = 0; $m < $this->coordsN; $m++)
			{
				if($m == $k) continue;
				$l *= ($x - $this->arX[$m]) / ($this->arX[$k] - $this->arX[$m]);
			}
			$S += $this->arY[$k] * $l;
		}
		return $S;
	}

}
