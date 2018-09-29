<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!defined('PAYPAL_URL'))
{
	if (ENVIRONMENT == 'production')
	{
		define('PAYPAL_URL', 'https://www.paypal.com/cgi-bin/webscri');
	}
	else
	{
		define('PAYPAL_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscri');
	}
}