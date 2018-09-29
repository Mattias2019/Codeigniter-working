<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (! function_exists('form_token'))
{
	/*
	 * @method string form_csrf($varlen, $str_to_shuffer) returns a constructed hidden input field of the csrf token
	 * @param int $varlen the length of the input field name that will be generated
	 * @param string $str_to_shuffer the string that will be used to generate the input field name
	 * @return string the hidden input field
	 */
	function form_token($varlen = 6, $str_to_shuffer = "abcdefghijklmnopqrstuvwxyz0123456789_")
	{
		$start_pos 		= mt_rand(0, (strlen($str_to_shuffer) - $varlen));
		$token_name		= substr(str_shuffle($str_to_shuffer), $start_pos, $varlen);
		$token_value	= do_hash(microtime() . mt_rand());
		
		$CI =& get_instance();
    	if ($CI->session) {
     		 $CI->load->library('session');
   		}
		$CI->session->set_userdata('token_name',$token_name);
		$CI->session->set_userdata('token_value',$token_value);
		
		//pr($CI->input);
		//exit;
		return form_hidden($token_name,$token_value);
	}
}

if (! function_exists('check_form_token'))
{
	/*
	 * @method string form_csrf($varlen, $str_to_shuffer) returns a constructed hidden input field of the csrf token
	 * @param int $varlen the length of the input field name that will be generated
	 * @param string $str_to_shuffer the string that will be used to generate the input field name
	 * @return string the hidden input field
	 */
	function check_form_token()
	{
		//load codeigniter object
		$CI =& get_instance();
		
		//Load Session Object
    	if ($CI->session) {
     		 $CI->load->library('session');
   		}
		
		//Load  Input Object
		if ($CI->input) {
//     		 $CI->load->library('input');
   		}

		if($CI->input->post($CI->session->userdata('token_name')) and ($CI->input->post($CI->session->userdata('token_name')) == $CI->session->userdata('token_value')))
		{
			return true;
		} else {
			return false;
		}

	}
	
}

if (! function_exists('alpha_space'))
{
	function alpha_space($username)
	{
		return true;
	}
}

if (! function_exists('invert_array')) {
	/**
	 * Changes array [A][B] to [B][A]
	 *
	 * @param $array
	 * @return array
	 */
	function invert_array($array)
	{
		$res = [];
		if (isset($array) and is_array($array)) {
			foreach (array_keys($array) as $fieldKey) {
				foreach ($array[$fieldKey] as $key => $value) {
					$res[$key][$fieldKey] = $value;
				}
			}
		}
		return $res;
	}
}

if (!function_exists('in_array_subitem'))
{
	/**
	 * @param $value
	 * @param $subitem
	 * @param $array
	 * @return bool
	 */
	function in_array_subitem($value, $subitem, $array)
	{
		if (is_array($array))
		{
			foreach ($array as $item)
			{
				if (is_array($item) and array_key_exists($subitem, $item) and $item[$subitem] == $value)
				{
					return TRUE;
				}
			}
		}
		return FALSE;
	}
}