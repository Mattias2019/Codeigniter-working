<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * This MY_date_helper is used for date and time references.
 *
 * @access	public
 * @param	string
 * @return	string
 */

if (!defined('DAY'))
{
	define('DAY', 24*60*60);
}
if (!defined('WEEK'))
{
	define('WEEK', 7*DAY);
}
if (!defined('MONTH'))
{
	define('MONTH', 30*DAY);
}

if ( ! function_exists('get_est_time'))
{
	function get_est_time()
	{
		$CI = &get_instance();

		$now = time();
		$gmt = local_to_gmt($now);

		$timezone = $CI->config->item('time_zone');
		$daylight_saving = ($CI->config->item('daylight') == 1);

		$tt = gmt_to_local($gmt, $timezone, $daylight_saving);
		
		return $tt;
	}
}

if ( ! function_exists('get_datetime'))
{
	function get_datetime($timestamp)
	{
		$CI =& get_instance();
		load_lang('enduser/common');
		if(date('d/M/Y') == date('d/M/Y',$timestamp))
		$date = t('Today at')." ".date('H:i',$timestamp);
		else
		$date = date('d-M-Y H:i',$timestamp);		
		return $date;
	}
}

if ( ! function_exists('get_date'))
{
	function get_date($timestamp)
	{
		$CI =& get_instance();
		load_lang('enduser/common');
		if(date('d/M/Y') == date('d/M/Y',$timestamp))
		$date = t('Today at')." ".date('H:i',$timestamp);
		else 
		$date = date('d-M-Y',$timestamp);		
		return $date;
	}
}

if ( ! function_exists('current_date'))
{
	function current_date($timestamp)
	{
		$CI =& get_instance();
		load_lang('enduser/common');
		if(date('d/M/Y') == date('d/M/Y',$timestamp))
		$date = date('d/M/Y',$timestamp);
		else 
		$date = date('d-M-Y',$timestamp);		
		return $date;
	}
}


if ( ! function_exists('show_date'))
{
	function show_date($timestamp)
	{
		$CI =& get_instance();
		load_lang('enduser/common');
		if(date('d/M/Y') == date('d/M/Y',$timestamp))
		    $date = date('D, d M Y H:i:s',$timestamp);
		else 
		   $date = date('D, d M Y H:i:s',$timestamp);		
		return $date;
	}
}


if ( ! function_exists('days_left'))
{
	function days_left($endtime,$prjid)
	{
		//echo date('d-m-Y',$endtime);exit;
		$CI =& get_instance();
		load_lang('enduser/viewJob');
		$mod = $CI->load->model('skills_model');
		$today = get_est_time();
		$lastday = $endtime;
		$left = $lastday - $today;
		//echo $left;exit;
		if($left >= 0)
		{
			$val =  ceil($left / 86400);
			if(date('d-m-Y',time()) == date('d-m-Y',$endtime))
				$rem = 'Ending today';
			else{
			if($val > 1) 
				$rem = $val." ".t('days');
			else 
				$rem = $val." ".t('day');
			}
			
			return $rem." ".t('left');
		}
		else{
			$conditions =array('jobs.job_status'=>'3');
			$CI->skills_model->updateJobs($prjid,$conditions);
			return t('Closed');
		}
	}
}

if ( ! function_exists('dispute_time_left'))
{
	function dispute_time_left($time,$hrs)
	{
		//echo date('d-m-Y',$time);exit;
		$CI =& get_instance();
		load_lang('enduser/cancel');
		$mod = $CI->load->model('skills_model');
		$today = get_est_time();
		$lastday = $time;
		$difference = $today - $lastday;
		
		$day = floor($difference / 84600);
		$difference -= 84600 * floor($difference / 84600);
		$hours = floor($difference / 3600);
		$difference -= 3600 * floor($difference / 3600);
		$min = floor($difference / 60);
		$sec = $difference -= 60 * floor($difference / 60);
		//echo $min;
		if($day == 0 && $hours == 0){
		$resp_mins = $hrs * 60 ;
		$rem = ($resp_mins - $min ) +0.1;
			return "<b>".round_up($rem/60,2)." ".t('hours left to respond')."</b>";
		}
		elseif($day == 0 && $hours < $hrs){
			$rem = $hrs - $hours;
			return "<b>".round_up($rem,2)." ".t('hours left to respond')."</b>";
		}
		else
			return "<b>".t('response time').' ('.$hrs.' hrs) '.t('is over')."</b>";
		
		//return "$day days $hours hours $min minutes, and $difference seconds ago.";
	}
}

if ( ! function_exists('count_days'))
{
	function count_days($starttime,$endtime)

	{
		$CI =& get_instance();
		load_lang('enduser/viewJob');
		$today = $starttime;
		$lastday = $endtime;
		$left = $lastday - $today;
		if($left >= 0)
		{
			$val = date('j',$left);
			if($val > 1) 
				$rem = $val; 
			else 
				$rem = $val;
			return $rem;
		}
		else
		   return t('Closed');
		
	}
}

if ( ! function_exists('round_up'))
{
	function round_up($value, $precision = 0)
	{

		$sign = (0 <= $value) ? +1 : -1;
		$amt = explode('.', $value);
		$precision = (int)$precision;

		if (strlen($amt[1]) > $precision) {
			$next = (int)substr($amt[1], $precision);
			$amt[1] = (float)(('.' . substr($amt[1], 0, $precision)) * $sign);

			if (0 != $next) {
				if (+1 == $sign) {
					$amt[1] = $amt[1] + (float)(('.' . str_repeat('0', $precision - 1) . '1') * $sign);
				}
			}
		} else {
			$amt[1] = (float)(('.' . $amt[1]) * $sign);
		}

		return $amt[0] + $amt[1];
	}
}