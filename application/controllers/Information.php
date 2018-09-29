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

/* TODO terms/privacy have no view */

class Information extends MY_Controller {

	// Constructor 
	
	function __construct()
	{
	   parent::__construct();
	   
	    $this->load->library('settings');
		
        //Get Config Details From Db
		$this->settings->db_config_fetch();
		
	   //Manage site Status 
		if($this->config->item('site_status') == 1)
		redirect('offline');
 		
		//Load Models
		$this->load->model('common_model');
		$this->load->model('skills_model');
		
	    //Get Footer content
		$this->outputData['pages']	= $this->common_model->getPages();
		
		//Get Latest jobs
		$limit_latest = $this->config->item('latest_projects_limit');
		$limit3 = array($limit_latest);
		$this->outputData['latestJobs']	= $this->skills_model->getLatestJobs($limit3);
		
	} //Controller End
	// --------------------------------------------------------------------

	function index()
	{
		load_lang('enduser/common');
	    $this->load->view('information',$this->outputData);
	}
	
 	
	function terms()
	{
	   // get the page uri name	   
	   $like = array('page.url'=>'%ter%');
	   $like1 = array('page.url'=>'%cond%');
	   $this->outputData['page_content']	=	$this->page_model->getPages(NULL,$like,$like1);	
		
		/*	
	  pr($this->outputData['page_content']);
	  exit();
	  */
	   //Load View	
	   $this->load->view('termspage',$this->outputData);
	} //End terms function 
	
	function privacy()
	{
	   // get the page uri name	   
	   $like = array('page.url'=>'%privacy%');
	   $this->outputData['page_content']	=	$this->page_model->getPages(NULL,$like,NULL);	
		
	   $this->load->view('termspage',$this->outputData);
	} //End privacy function 

	
} //End Class Information

/* End of file information.php */ 
/* Location: ./application/controllers/information.php */