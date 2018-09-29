<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * start the session just in case it has not already been started.
 * suppress any warning message if it has already been started.
 */
@session_start();  

if (! function_exists('csrf_is_token_valid'))
{
	/**
	 * @method bool csrf_is_token_valid() checks if a csrf token is valid
	 * @return bool true if token is valid. false if token is invalid.
	 */
	function csrf_is_token_valid()
	{
		$result = false;
		if (isset($_POST[csrf_varname()]))
		{
			$result = ((strcmp(csrf_value(), $_POST[csrf_varname()])) == 0);
		}
		return $result;
	}
}  

if (! function_exists('csrf_token'))
{
	/**
	 * @method void csrf_token($varlen, $str_to_shuffer) construct a random input field name and assign the token to it.
	 * @param int $varlen the length of the input field name that will be generated
	 * @param string $str_to_shuffer the string that will be used to generate the input field name
	 */
	function csrf_token($varlen = 6, $str_to_shuffer = "abcdefghijklmnopqrstuvwxyz0123456789_")
	{
		$start_pos = mt_rand(0, (strlen($str_to_shuffer) - $varlen));
		$_SESSION["CSRF_NONCE_VARNAME_{$_SERVER["REQUEST_URI"]}"] = substr(str_shuffle($str_to_shuffer), $start_pos, $varlen);
		$_SESSION["CSRF_NONCE_VALUE_{$_SERVER["REQUEST_URI"]}"]	= dohash(microtime() . mt_rand());
	}
}  

if (! function_exists('csrf_varname'))
{
	/**
	 * @method string csrf_varname($varlen, $str_to_shuffer) return the generated input field name
	 * @param int $varlen the length of the input field name that will be generated
	 * @param string $str_to_shuffer the string that will be used to generate the input field name
	 * @return string the generated input field name
	 */
	function csrf_varname($varlen = 6, $str_to_shuffer = "abcdefghijklmnopqrstuvwxyz0123456789_")
	{
		if (!isset($_SESSION["CSRF_NONCE_VARNAME_{$_SERVER["REQUEST_URI"]}"]))
		{
			csrf_token($varlen, $str_to_shuffer);
		}
		return $_SESSION["CSRF_NONCE_VARNAME_{$_SERVER["REQUEST_URI"]}"];
	}
}  

if (! function_exists('csrf_value'))
{
	/**
	 * @method string csrf_value($varlen, $str_to_shuffer) return the token
	 * @param int $varlen the length of the input field name that will be generated
	 * @param string $str_to_shuffer the string that will be used to generate the input field name
	 * @return string the token
	 */
	function csrf_value($varlen = 6, $str_to_shuffer = "abcdefghijklmnopqrstuvwxyz0123456789_")
	{
		if (!isset($_SESSION["CSRF_NONCE_VALUE_{$_SERVER["REQUEST_URI"]}"]))
		{
			csrf_token($varlen, $str_to_shuffer);
		}
		return $_SESSION["CSRF_NONCE_VALUE_{$_SERVER["REQUEST_URI"]}"];
	}
}  

if (! function_exists('csrf_clean'))
{
	/*
	 * @method void csrf_clean() clears the session variables that store the csrf token
	 */
	function csrf_clean()
	{
		session_unregister("CSRF_NONCE_VARNAME_{$_SERVER["REQUEST_URI"]}");
		session_unregister("CSRF_NONCE_VALUE_{$_SERVER["REQUEST_URI"]}");
	}
}  
?>