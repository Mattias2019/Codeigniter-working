<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('currency'))
{
	/**
	 * Get currency symbol
	 *
	 * @return string
	 */
	function currency()
	{
		$CI = &get_instance();
		$CI->load->model('settings_model');

		$currency_type = $CI->settings_model->getSiteSettings()['CURRENCY_TYPE'];
		$currency = $CI->settings_model->setCurrency(['currency_type' => $currency_type])->row();
		if (isset($currency))
		{
			if ($currency->currency_symbol != '')
			{
				return $currency->currency_symbol;
			}
			else
			{
				return $currency_type;
			}
		}
		else
		{
			return $currency_type;
		}
	}
}