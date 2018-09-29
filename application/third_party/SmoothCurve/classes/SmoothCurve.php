<?php
/*****************************************************
* Smooth curve drawing abstract class v0.3           *
* (c) Ross Vladislav, 2010-2011                      *
* vladislav.ross@gmail.com http://ross.vc/graph      *
* See README for more information                    *
******************************************************/

abstract class SmoothCurve 
{
	protected $minX;
	protected $maxX;
	protected $coordsN;
	protected $arX;
	protected $arY;
	protected $step;
	protected $arCoords;
	protected $errMsg = false;
	
	abstract public function setCoords(&$arCoords, $step, $minX=-1, $maxX=-1);
	abstract public function process();
	
	protected function prepareCoords(&$arCoords, $step, $minX=-1, $maxX=-1)
	{
		$this->arX      = array();
		$this->arY      = array();
		$this->arCoords = array();
		
		/*try
		{
			if(count($arCoords) < 5)
			{
				throw new Exception('Too few coordinates (' . count($arCoords) . ', min: 5.');
			}			
		}
		catch (Exception $e)
		{
			die('Bad arguments: ' . $e->getMessage() . "\n");
		}*/
		
		ksort($arCoords);
		foreach($arCoords as $x => $y)
		{
			$this->arX[] = $x;
			$this->arY[] = $y;
		}
		
		$this->coordsN = count($this->arX);
		
		$this->minX = $minX;
		$this->maxX = $maxX;
		
		if($this->minX == -1) $this->minX = min($this->arX);
		if($this->maxX == -1) $this->maxX = max($this->arX);
		$this->step = $step;
	}
	
	public function getError()
	{
		return $this->errMsg;
	}
}