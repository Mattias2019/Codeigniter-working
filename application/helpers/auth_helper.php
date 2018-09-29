<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// ------------------------------------------------------------------------

/**
 * Check Whether the user is an admin
 *
 * @access	public
 * @param	string
 * @return	string
 */
	function isAdmin()
	{
		$CI 	=& get_instance();
		return $CI->session->userdata ('admin_role') == 'admin'? TRUE: FALSE;
	}

// ------------------------------------------------------------------------

/**
 * Check Whether the user is an employee
 *
 * @access	public
 * @param	string
 * @return	string
 */
	function isProvider()
	{
		$CI 	=& get_instance();
		return  $CI->session->userdata('role') == 'provider'?TRUE:FALSE;
	}
	
// ------------------------------------------------------------------------

/**
 * Check Whether the user is logged in
 *
 * @access	public
 * @param	string
 * @return	string
 */
	function isLoggedIn()
	{
		$CI 	=& get_instance();
		return  $CI->session->userdata('logged_in') == '1'?TRUE:FALSE;
	}
	
// ------------------------------------------------------------------------

/**
 * Check Whether the user is Owner
 *
 * @access	public
 * @param	string
 * @return	string
 */
	function isEntrepreneur()
	{
		$CI 	=& get_instance();
		return  $CI->session->userdata('role') == 'entrepreneur'?TRUE:FALSE;
	}	
	
	// ------------------------------------------------------------------------

	/**
	 * Check ban status of the user
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	function  getBanStatus($uname)
	{
	
		$CI 	=& get_instance();
		$CI->load->model('common_model');
		$condition =array('users.user_name'=>$uname);
		$sus_status= $CI->common_model->getTableData('users',$condition,'users.ban_status');
		$sus_status = $sus_status->row();
		if(isset($sus_status->ban_status))		
			return $sus_status->ban_status;
		else
		 	return false;
		
	}
	

/* End of file auth_helper.php */
/* Location: ./application/helpers/auth_helper.php */