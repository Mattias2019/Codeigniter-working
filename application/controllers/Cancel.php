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

class Cancel extends MY_Controller {

	function __construct()
	{
	    parent::__construct();
	   
	    $this->load->library('settings');
		
        //Get Config Details From Db
		$this->settings->db_config_fetch();
		
		 //Manage site Status 
		if($this->config->item('site_status') == 1)
		{
			redirect('offline');
		}
	
		//Load Models
		$this->load->model('common_model');
		$this->load->model('skills_model');
		$this->load->model('cancel_model');
		$this->load->model('email_model');
		$this->load->model('project_model');
		$this->load->model('user_model');
		$this->load->model('messages_model');
		
         //Get Footer content
		$this->outputData['pages']	= $this->common_model->getPages();
		
		//Get Latest Jobs
		$limit_latest = $this->config->item('latest_projects_limit');
		$limit3 = array($limit_latest);
		$this->outputData['latestJobs']	= $this->skills_model->getLatestJobs($limit3);
		
		//language file
		load_lang(['enduser/cancel', 'enduser/job', 'enduser/messages']);
		
		$this->outputData['project_period']    =  $this->config->item('project_period');
	}

	/**
	 * View open cases
	 */
	function index()
	{
		load_lang('enduser/messages');

		$this->add_js([
			'application/js/pagination.js'
		]);

		// Get page
		$page = $this->input->post('page');
		if ($page == NULL) {
			$page = 1;
		}
		$this->outputData['page'] = $page;

		$page_rows = $this->input->post('page_rows');
		if ($page_rows == NULL) {
			$page_rows = 10;
		}
		$this->outputData['page_rows'] = $page_rows;
		$max = [$page_rows, ($page - 1) * $page_rows];

		// Get Sorting order
		if ($this->input->post('field'))
		{
			$field = $this->input->post('field');
		}
		else
		{
			$field = '';
		}
		if ($this->input->post('order'))
		{
			$order = $this->input->post('order');
		}
		else
		{
			$order = '';
		}
		$order_by = [$field, $order];

		$this->outputData['cases'] = $this->cancel_model->get_user_cases();

		// Parameters
		if ($this->input->post('segment'))
		{
			$current_case = $this->input->post('segment');
		}
		elseif (count($this->outputData['cases']) > 0)
		{
			$current_case = $this->outputData['cases'][0]['id'];
		}
		else
		{
			$current_case = '';
		}
		$this->outputData['current_case'] = $current_case;

		$messages = $this->messages_model->get_case_messages($this->logged_in_user->id, $current_case, '', $max, $order_by);
		$messages_count = count($this->messages_model->get_case_messages($this->logged_in_user->id, $current_case, '', '', ''));

		$this->outputData['messages'] = $messages;

		$this->outputData['pagination'] = get_pagination(site_url('cancel'), $messages_count, $page_rows, $page);

        if ($messages_count == 0) {
            $this->outputData['page_numbers'] = array();
        }

		if ($this->input->is_ajax_request())
		{
			echo response([
				'type' => 'table',
				'data' => $this->load->view('cancel/view_table', $this->outputData, TRUE),
				'pagination' => $this->outputData['pagination']
			]);
		}
		else
		{
			$this->load->view('cancel/view', $this->outputData);
		}
	}

	/**
	 * Create new case
	 */
	function create()
	{
		$this->load->library('form_validation');
		$this->load->helpers('form');
		$this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

		// Loading CSS/JS
		$this->add_js([
			'application/js/jquery.inputmask.bundle.min.js',
			'application/js/custom-inputmask.js'
		]);

		if ($this->input->post('submit') != NULL)
		{
			$this->form_validation->set_rules('comments', 'lang:"Comments (Public)"', 'trim|xss_clean|no_email|no_phone_number');
			$this->form_validation->set_rules('private_comments', 'lang:"Comments (Private)"', 'trim|xss_clean|no_email|no_phone_number');
			$this->form_validation->set_rules('payment', 'lang:"Payment need"', 'required|trim|integer|is_natural|abs|xss_clean');

			if ($this->form_validation->run())
			{
				$data = $this->input->post();
				unset($data['submit']);
				$data['user_id'] = $this->logged_in_user->id;
				$data['created'] = get_est_time();

				$this->cancel_model->create_case($data);
				redirect('cancel/index');
			}
		}

		$project_id = $this->input->get('id');
		if ($project_id == '')
		{
			$project_id = $this->input->post('job_id');
		}
		$project = $this->project_model->get_project_by_id($project_id);
		if ($project['id'] == NULL)
		{
            /*Flash*/
            $success_msg = t('Project does not exist');
            $this->notify->set($success_msg, Notify::ERROR);
            /*End Flash*/
			redirect('information');
		}
		elseif ($project['creator_id'] != $this->logged_in_user->id and $project['employee_id'] != $this->logged_in_user->id)
		{
            /*Flash*/
            $success_msg = t('Project cannot be edited');
            $this->notify->set($success_msg, Notify::ERROR);
            /*End Flash*/

			redirect('information');
		}

		$project['creator_name'] = $this->user_model->get_name($project['creator_id']);
		$project['employee_name'] = $this->user_model->get_name($project['employee_id']);

		$this->outputData['case_types'] = $this->cancel_model->get_case_types();
		$this->outputData['case_reasons'] = $this->cancel_model->get_case_reasons();
		$this->outputData['review_types'] = $this->cancel_model->get_review_types();

		$this->outputData['project'] = $project;
		$this->load->view('cancel/create', $this->outputData);
	}

	/**
	 * Post message
	 */
	function message()
	{
		$this->load->library('form_validation');
		$this->load->helper('form');

		// Initialize values for library and helpers
		$this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

		$case_id = $this->input->get('id');
		if ($case_id == '')
		{
			$case_id = $this->input->post('case_id');
		}
		$messages = $this->messages_model->get_case_messages($this->logged_in_user->id, $case_id, '', 1, '');
		if ($messages[0]['id'] == NULL)
		{

            /*Flash*/
            $success_msg = t('Case does not exist');
            $this->notify->set($success_msg, Notify::ERROR);
            /*End Flash*/
			redirect('information');
		}
		$this->outputData['case_id'] = $case_id;
		$this->outputData['project_name'] = $messages[0]['job_name'];

		// Post
		if ($this->input->post('submit') != NULL) {

			//Set rules
			$this->form_validation->set_rules('subject', 'lang:Subject', 'required|trim|xss_clean|no_email|no_phone_number');
			$this->form_validation->set_rules('message', 'lang:Message', 'required|trim|xss_clean|no_email|no_phone_number');

			if ($this->form_validation->run()) {

				$data = $this->input->post();

				$this->messages_model->send_case_message($case_id, $this->logged_in_user->id, $data['subject'], $data['message']);

				redirect(base_url('cancel'));
			}
		}

		$this->load->view('cancel/message', $this->outputData);
	}

	/**
	 * Mark message as read
	 */
	function set_notified()
	{
		if ($this->input->is_ajax_request())
		{
			$this->messages_model->set_notified_case($this->input->get('id'));
		}
	}
}