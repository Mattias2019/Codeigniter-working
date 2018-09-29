<?php
/************************************************
* Plot draw sample class for SmoothCurve v0.3   *
* (c) Ross Vladislav, 2010-2011                 *
* vladislav.ross@gmail.com http://ross.vc/graph *
* See README for more information               *
************************************************/

class Plot
{
	private $arCoords;

	function __construct(&$arCoords)
	{
		$this->arCoords = &$arCoords;
	}
	
	public function drawLine($im, $color, $xPos = 0, $yPos = false)
	{
		
		if($yPos === false) $yPos = imagesy($im);
		
		reset($this->arCoords);
		list($prevX, $prevY) = each($this->arCoords);
		
		while(list($x, $y) = each($this->arCoords))
		{
			imageline($im, $xPos + round($prevX), $yPos - round($prevY), $xPos + round($x), $yPos - round($y), $color);
			$prevX = $x;
			$prevY = $y;
		}
	}
	
	private function fpart($x)
	{
		return  $x = abs($x) - floor(abs($x));
	}
	
	private function drawAAPoint($im, $x, $y, $color, $i, $swap = false)
	{
		$arColor = imagecolorsforindex($im, $color);
		$AAcolor = imagecolorallocatealpha($im, $arColor['red'], $arColor['green'], $arColor['blue'], (1-$i) * 127);
		if($swap) imagesetpixel($im, $y, $x, $AAcolor);
		else imagesetpixel($im, $x, $y, $AAcolor);
		imagecolordeallocate($im, $AAcolor);
	}
	
	public function drawAALine($im, $color, $xPos = 0, $yPos = false)
	{
		if($yPos === false) $yPos = imagesy($im);
		
		reset($this->arCoords);
		list($prevX, $prevY) = each($this->arCoords);
		
		$n = round(log(PHP_INT_MAX, 2)) + 1;
		
		$t1 = imagecolorallocate($im, 255, 0, 0);
		
		while(list($x2, $y2) = each($this->arCoords))
		{			
			$x1 = $prevX;
			$y1 = $prevY;			
			$prevX = $x2;
			$prevY = $y2;  
			
			$x1 += $xPos;
			$y1 = $yPos -$y1;
			$x2 += $xPos;
			$y2 = $yPos - $y2;
			
			$dx = $x2 - $x1;
			$dy = $y2 - $y1;			
			@$gradient = $dy  / $dx;
			
			if(abs($gradient) > 1)
			{
				$tmp = $x2;
				$x2 = $y2;
				$y2 = $tmp;
				$tmp = $x1;
				$x1 = $y1;
				$y1 = $tmp;
				
				if($x2 < $x1)
				{
					$tmp = $x2;
					$x2 = $x1;
					$x1 = $tmp;
					$tmp = $y2;
					$y2 = $y1;
					$y1 = $tmp;
				}
				
				$dx = $x2 - $x1;
				$dy = $y2 - $y1;			
				$gradient = $dy / $dx;
				$swap = true;
			}
			else
			{
				$swap = false;
			}
			
			$xend = round($x1);
			$yend = $y1 + $gradient * ($xend - $x1);
			$xgap = 1 - $this->fpart($x2 + 0.5);
			$xpxl1 = $xend;
			$ypxl1 = floor($yend);
			
			$this->drawAAPoint($im, $xpxl1, $ypxl1, $color, 1 - $this->fpart($yend) * $xgap, $swap);
			$this->drawAAPoint($im, $xpxl1, $ypxl1 + 1, $color, $this->fpart($yend) * $xgap, $swap);   
			$intery = $yend + $gradient;


			$xend = round($x2);
			$yend = $y2 + $gradient * ($xend - $x2);
			$xgap = $this->fpart($x2 + 0.5);
			$xpxl2 = $xend;
			$ypxl2 = floor($yend);
			
			$this->drawAAPoint($im, $xpxl2, $ypxl2, $color, 1 - $this->fpart($yend) * $xgap, $swap);
			$this->drawAAPoint($im, $xpxl2, $ypxl2 + 1, $color, $this->fpart($yend) * $xgap, $swap); 

			for($xc = $xpxl1 + 1; $xc < $xpxl2; $xc++)
			{
				$this->drawAAPoint($im, $xc, floor($intery), $color, 1 - $this->fpart($intery), $swap);
				$this->drawAAPoint($im, $xc, floor($intery) + 1, $color, $this->fpart($intery), $swap); 
				$intery += $gradient;				
			}
		}
	}
	
	public function drawDots($im, $color, $xPos = 0, $yPos = false, $dotSize = 1)
	{	
		if($yPos === false) $yPos = imagesy($im);
		
		$borderColor = imagecolorallocate($im, 0, 0, 0);
		
		foreach($this->arCoords as $x => $y)
		{
			imagefilledellipse($im, $xPos + round($x), $yPos - round($y), $dotSize, $dotSize, $color);
			imageellipse($im, $xPos + round($x), $yPos - round($y), $dotSize, $dotSize, $borderColor);
		}
	}
	
	public function drawAxis($im, $color, $xPos = 0, $yPos = false, $fq = true)
	{
		if($yPos === false) $yPos = imagesy($im);
		$imWidth = imagesx($im);
		
		if($fq)
		{
			imageline($im, $xPos, $yPos, $xPos, 0, $color);
			imageline($im, $xPos, $yPos, $imWidth, $yPos, $color);
		}
		else
		{
			imageline($im, $xPos, imagesy($im), $xPos, 0, $color);
			imageline($im, 0, $yPos, $imWidth, $yPos, $color);
		}
		
		imagefilledpolygon($im, array($xPos, 0, $xPos - 3, 5, $xPos + 3, 5), 3, $color);
		imagefilledpolygon($im, array($imWidth, $yPos, $imWidth - 5, $yPos - 3, $imWidth - 5, $yPos + 3), 3, $color);
	}
}
