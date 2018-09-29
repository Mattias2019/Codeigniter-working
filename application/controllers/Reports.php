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

/* TODO Not sure if needed, Highcharts not approved */

class Reports extends MY_Controller {

   
    
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
		
		
		//Load Models Common to all the functions in this controller
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
	
	/**
	 * Loads Report page of the site.
	 *
	 * @access	public
	 * @param	nil
	 * @return	void
	 */	
	function index()
	{
		//Load Language File For this
		load_lang('enduser/reports');
		
		$data_1 = array();
		$data_2 = array();
		$mon = array();
		$bid	= $this->user_model->getRoleId('owner');
		$pid	= $this->user_model->getRoleId('provider');
		for( $i=0; $i<12; $i++ )
		{
		  $lastmonth = mktime(0, 0, 0, date("m")-$i, date("d"),   date("Y"));
		  $month = date('n',$lastmonth);
		  $year = date('Y',$lastmonth);
		  $data_1[] = $this->user_model->getNumUsersByMonth($month,$year,$bid);
		  $data_2[] = $this->user_model->getNumUsersByMonth($month,$year,$pid);
		  $mon[] = "'".date('M',$lastmonth).",".date('y',$lastmonth)."'";
		}
		$this->outputData['owner'] = implode(",",$data_1);
		$this->outputData['emp'] = implode(",",$data_2);
		$this->outputData['months'] = implode(",",$mon);
		
		$data_3 = array();
		for( $j=0; $j<12; $j++ )
		{
		  $lastmonth = mktime(0, 0, 0, date("m")-$j, date("d"),   date("Y"));
		  $month = date('n',$lastmonth);
		  $year = date('Y',$lastmonth);
		  $data_3[] = $this->skills_model->getNumProjectsByMonth($month,$year);
		}
		$this->outputData['jobs'] = implode(",",$data_3);
		
		//Load library Filas and Helper File
		$this->load->view('reports',$this->outputData);
	} //Function Index End
	// --------------------------------------------------------------------
	
}//End  Reports Class

/* End of file Reports.php */
/* Location: ./application/controllers/Reports.php */
?>