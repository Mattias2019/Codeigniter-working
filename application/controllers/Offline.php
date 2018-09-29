<?php

/** 
 *      ____  ____  _________  _________  ____ 
 *     / __ \/ __ \/ ___/ __ \/ ___/ __ \/ __ \
 *    / /_/ / /_/ / /  / /_/ / /__/ /_/ / / / /
 *    \____/ .___/_/   \____/\___/\____/_/ /_/ 
 *        /_/                                  
 *          
 *          Copyright (C) 2016 Oprocon
 *          
 *          You aren't allowed to share any parts of this script!
 *          All rights reserved.
 *          
 *          Changelog:
 *              15.04.2016 - Prepare the CI3 integration, initial release of the header
 *              
 *          (Please update this any time you edit this script, newest first)
 *
 * @package	    Consultant Marketplace
 * @author	    Oprocon Dev Team
 * @copyright	Copyright (c) 2015 - 2016, Oprocon (https://consultant-marketplace.com/)
 * @link	    https://consultant-marketplace.com
 * @version     1.0.0
 */

/* TODO Not sure if needed */

class Offline extends MY_Controller {

   
    /**
	 * Constructor 
	 *
	 * Loads language files and models needed for this controller
	 */
	function __construct()
	{
		parent::__construct();
		
		$this->load->library('settings');
		
        //Get Config Details From Db
		$this->settings->db_config_fetch();
		
		//Debug Tool
	   	//$this->output->enable_profiler=true;
	} //Controller End 
	
	// --------------------------------------------------------------------
	
	/**
	 * Loads Home page of the site.
	 *
	 * @access	public
	 * @param	nil
	 * @return	void
	 */
	function index()
	{
		//Site Offline Message
		$this->outputData['message'] = $this->config->item('offline_message');
		$this->load->view('offline',$this->outputData);
	}

}