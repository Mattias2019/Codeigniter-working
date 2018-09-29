<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!defined('DEFAULT_LANGUAGE'))
{
	define('DEFAULT_LANGUAGE', 'english');
}

if (!function_exists('load_lang'))
{
	function load_lang($files)
	{
		$CI = &get_instance();
		$lan = $CI->config->item('language');
		if (is_array($files))
		{
			foreach ($files as $file)
			{
				$CI->lang->load($file, $lan);
			}
		}
		else
		{
			$CI->lang->load($files, $lan);
		}
	}
}

if (!function_exists('t'))
{
	function t($line)
	{
		global $LANG;
		return ($t = $LANG->line($line, FALSE)) ? $t : $line;
	}
}