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

class Bookmark extends MY_Controller {

	
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
 		
		//Load Models required for this controller
		$this->load->model('common_model');
		$this->load->model('skills_model');
		$this->load->model('bookmark_model');
		
		//load validation libraray
		$this->load->library('form_validation');
		
		//Load Form Helper
		$this->load->helper('form');
		
		//Intialize values for library and helpers	
		$this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

		//Get Footer content
		$this->outputData['pages']	= $this->common_model->getPages();	

	} //Controller End 
	
	// --------------------------------------------------------------------
	
	/**
	 * Logged user can bookmark the particular job for feature reference
	 *
	 * @access	private
	 * @param	nil
	 * @return	void
	 */ 
	function index()
	{	
		//Get the bookmark job details
		$job_id = $this->uri->segment(2);
		$conditions   = array('bookmark.job_id'=>$job_id,'bookmark.creator_id'=>$this->logged_in_user->id);
		$bookMarks    = $this->bookmark_model->getBookmark($conditions);
		$res  =  $bookMarks->num_rows();
		
		if($res <= 0)
		{
			$conditions   = array('jobs.id'=>$job_id);
			$jobList  = $this->skills_model->getJobs($conditions);
			foreach($jobList->result() as $res)
			  {
				$insertData['id']               = '';
				$insertData['creator_id']       = $this->logged_in_user->id;
				$insertData['creator_name']     = $this->logged_in_user->user_name;
				$insertData['job_creator']  = $res->creator_id;
				$insertData['job_id']       = $res->id;
				$insertData['job_name']     = $res->job_name;			
				$this->bookmark_model->createBookmark($insertData);

                  /*Flash*/
                  $success_msg = t('The Job "'.$res->job_name.'" is bookmarked successfully');
                  $this->notify->set($success_msg, Notify::SUCCESS);
                  /*End Flash*/
				redirect($this->common_model->get_logged_in_user()->role_name.'/viewProjectDetails?job_id='.$job_id);
			  }
        }
		else
		{
            /*Flash*/
            $success_msg = t('Job already Bookmarked');
            $this->notify->set($success_msg, Notify::ERROR);
            /*End Flash*/
			redirect($this->common_model->get_logged_in_user()->role_name.'/viewProjectDetails?job_id='.$job_id);
		}
	} //Function index End
	
	
	
}

//End  bookmark Class

/* End of file bookmark.php */ 
/* Location: ./application/controllers/bookmark.php */