<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('throw_db_exception'))
{
	/**
	 * Get exception from DB error
	 *
	 * @throws Exception
	 */
	function throw_db_exception()
	{
		$CI = &get_instance();
		$error = $CI->db->error();
		if (isset($error['message']))
		{
			throw new Exception($error['message']);
		}
		else
		{
			throw new Exception('Database error');
		}
	}
}