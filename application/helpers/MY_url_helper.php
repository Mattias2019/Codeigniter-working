<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!defined('STANDARD_LOGO'))
{
	define('STANDARD_LOGO', '/application/css/images/noImageblue.jpg');
}

// ------------------------------------------------------------------------




if ( ! function_exists('admin_url'))

{

	function admin_url($uri = '')

	{
		$CI =& get_instance();

		$admin_folder_name	=  $CI->config->config['admin_controllers_folder'];

		$uri = $admin_folder_name.'/'.$uri ;

		return $CI->config->site_url($uri);
	}

}



// ------------------------------------------------------------------------



/**

 * Images URL

 *

 * Create a admin URL based on the admin folder path mentioned in config file. Segments can be passed via the

 * first parameter either as a string or an array.

 *

 * @access	public

 * @param	string

 * @return	string

 */

if ( ! function_exists('image_url')) {
	function image_url($image_name = '') {
		$CI =& get_instance();
		$uri = str_replace($CI->config->item('index_page'),"",$CI->config->site_url()).'application/css/images/'.$image_name;
		return $uri;
	}
}


// ------------------------------------------------------------------------



/**

 * Portfolio Images URL

 *

 * Create a admin URL based on the admin folder path mentioned in config file. Segments can be passed via the

 * first parameter either as a string or an array.

 *

 * @access	public

 * @param	string

 * @return	string

 */

if ( ! function_exists('pimage_url')) {
	function pimage_url($image_name = '') {

		$CI =& get_instance();

		$uri = str_replace($CI->config->item('index_page'),"",$CI->config->site_url()).'files/portfolios/'.$image_name;

		return $uri;
	}
}

// ------------------------------------------------------------------------



/**

 * Categories Images URL

 *

 * Create a admin URL based on the admin folder path mentioned in config file. Segments can be passed via the

 * first parameter either as a string or an array.

 *

 * @access	public

 * @param	string

 * @return	string

 */

if ( ! function_exists('cimage_url'))

{

	function cimage_url($image_name = '')

	{

		
 		$CI =& get_instance();

		$uri = str_replace($CI->config->item('index_page'),"",$CI->config->site_url()).'files/category_logo/'.$image_name;

		return $uri;

	}

}

// ------------------------------------------------------------------------

if ( ! function_exists('prfile_url'))

{

	function prfile_url($image_name = '')

	{

		

		$CI =& get_instance();

		$uri = str_replace($CI->config->item('index_page'),"",$CI->config->site_url()).'files/job_attachment/'.$image_name;

		return $uri;

	}

}


// ------------------------------------------------------------------------



/**

 * Header Redirect Admin

 *

 * Header redirect in two flavors

 * For very fine grained control over headers, you could use the Output

 * Library's set_header() function.

 *

 * @access	public

 * @param	string	the URL

 * @param	string	the method: location or redirect

 * @return	string

 */

if ( ! function_exists('redirect_admin'))

{

	function redirect_admin($uri = '', $method = 'location', $http_response_code = 302)

	{

		switch($method)

		{

			

			case 'refresh'	: header("Refresh:0;url=".admin_url($uri));

				break;

			default			: header("Location: ".admin_url($uri), TRUE, $http_response_code);

				break;

		}

		exit;

	}

}



// ------------------------------------------------------------------------



/**

 * Header Redirect Admin

 *

 * Header redirect in two flavors

 * For very fine grained control over headers, you could use the Output

 * Library's set_header() function.

 *

 * @access	public

 * @param	string	the URL

 * @param	string	the method: location or redirect

 * @return	string

 */

if ( ! function_exists('replaceSpaceWithUnderscore'))

{

	function replaceSpaceWithUnderscore($text='')

	{

		$text = str_replace(' ','_',$text);

		return $text;

		

	} //Function replaceSpaceWithUnderscore End

}



// ------------------------------------------------------------------------



/**

 * Header Redirect Admin

 *

 * Header redirect in two flavors

 * For very fine grained control over headers, you could use the Output

 * Library's set_header() function.

 *

 * @access	public

 * @param	string	the URL

 * @param	string	the method: location or redirect

 * @return	string

 */

if ( ! function_exists('replaceUnderscoreWithSpace'))

{

	function replaceUnderscoreWithSpace($text = '')

	{

		$text = str_replace('_',' ',$text);

		return $text;

	}//Function replaceUnderscoreWithSpace End

}



// ------------------------------------------------------------------------



/**

 * Header Redirect Admin

 *

 * Header redirect in two flavors

 * For very fine grained control over headers, you could use the Output

 * Library's set_header() function.

 *

 * @access	public

 * @param	string	the URL

 * @param	string	the method: location or redirect

 * @return	string

 */

if ( ! function_exists('linksToCategories'))

{

	function linksToCategories($string='')

	{

		if($string!='')

		{

			$categories = explode(',',$string);

			if(count($categories)>0)

			{

					

			}

			

		} 

		return false;

		

	}

}

if (!function_exists('svg'))
{
	/**
	 * Display SVG
	 *
	 * @param $name
	 * @param bool $inline
	 * @return string
	 */
	function svg($name, $inline=FALSE)
	{
		if ($inline)
		{
			return file_get_contents(image_url('svg/'.$name.'.svg'));
		}
		else
		{
			return base_url('application/css/svg-icon/'.$name.'.svg');
		}
	}
}

if (!function_exists('response'))
{
	/**
	 * Prepare response for standard Ajax request
	 *
	 * @param $data
	 * @param bool $error
	 * @return string
	 */
	function response($data, $error=FALSE)
	{
		$response = ['error' => $error];
		if (is_array($data))
		{
			$response['result'] = $data;
		}
		else
		{
			$response['result'] = ['message' => $data];
		}
		return json_encode($response);
	}
}

if (!function_exists('redirect_back'))
{
	/**
	 * Redirect page to caller; if impossible, to information page
	 *
	 * @param $method
	 * @param $code
	 */
	function redirect_back($method = 'auto', $code = NULL)
	{
		$CI = &get_instance();
		$CI->load->library('user_agent');

		$url = $CI->agent->referrer();
		if ($url == '')
		{
			$url = base_url('information');
		}

		redirect($url, $method, $code);
	}
}

if (!function_exists('site_logo'))
{
	/**
	 * Get site logo
	 *
	 * @param bool $small
	 * @return string
	 */
	function site_logo($small = FALSE)
	{
		if ($small)
		{
			return image_url('logo-small.png');
		}
		else
		{
			return image_url('logo.png');
		}
	}
}

if (!function_exists('flash_message'))
{
	function flash_message()
	{
		$CI = &get_instance();
		$msg = $CI->session->flashdata('flash_message');
		if ($msg)
		{
            echo $msg;
		}
	}
}