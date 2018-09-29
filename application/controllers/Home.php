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
 * @package        Consultant Marketplace
 * @author        Oprocon Dev Team
 * @copyright    Copyright (c) 2015 - 2016, Oprocon (https://consultant-marketplace.com/)
 * @link        https://consultant-marketplace.com
 * @version     1.0.0
 */

class Home extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->library('settings');
		$this->load->helper('cookie');

		//Get Config Details From Db
		$this->settings->db_config_fetch();
		//Manage site Status 
		if ($this->config->item('site_status') == 1)
			redirect('offline');
		$this->load->model('credential_model');

		//Load Models
		$this->load->model('common_model');
		$this->load->model('skills_model');
		$this->load->model('page_model');
		$this->load->model('admin_model');


		//Get Latest Jobs
		$limit_latest = $this->config->item('latest_projects_limit');
		$limit3 = array($limit_latest);
		$this->outputData['latestJobs'] = $this->skills_model->getLatestJobs($limit3);

		//Get total open jobs
		//$this->load->model('skills_model');
		$openjob_condition = array('jobs.job_status' => '0');
		$open_jobs = $this->skills_model->getJobs($openjob_condition);
		$this->outputData['open_jobs'] = $open_jobs->num_rows();

		//Get total closed jobs
		$closedjob_condition = array('jobs.job_status' => '2');
		$closed_jobs = $this->skills_model->getJobs($closedjob_condition);
		$this->outputData['closed_jobs'] = $closed_jobs->num_rows();

		$this->outputData['facebook'] = $this->db->get_where('settings', array('code' => 'FACEBOOK'))->row()->string_value;
		$this->outputData['twitter'] = $this->db->get_where('settings', array('code' => 'TWITTER'))->row()->string_value;
		$this->outputData['rss'] = $this->db->get_where('settings', array('code' => 'RSS'))->row()->string_value;
		$this->outputData['linkedin'] = $this->db->get_where('settings', array('code' => 'LINKEDIN'))->row()->string_value;

		load_lang(['enduser/home', 'enduser/common']);

		$this->outputData['current_page'] = 'home';

		$this->load->helper('file');
		//$this->load->library('facebook');

		$categories = $this->skills_model->getCategories();
		$this->outputData['categories'] = $categories;

		$this->outputData['top_skills'] = $this->skills_model->get_jobs();
	}

	public function index()
	{
		$this->add_css([
			'application/plugins/slick/slick.css',
			'application/plugins/slick/slick-theme.css'
		]);

		$this->add_js([
			'application/plugins/slick/slick.min.js'
		]);

		//Get Categories
		$this->outputData['categories'] = $this->skills_model->getCategories();

		//Get Featured Jobs
		$feature_conditions = array('is_feature' => 1, 'jobs.job_status' => '0');
		$this->outputData['featuredJobs'] = $this->skills_model->getJobs($feature_conditions);

		//Get Urgent Jobs
		$urgent_conditions = array('is_urgent' => 1);
		$this->outputData['urgentProjects'] = $this->skills_model->getJobs($urgent_conditions);

		$this->outputData['groups'] = $this->skills_model->getGroups();
		$this->outputData['groups_num'] = $this->outputData['groups']->num_rows();
		$this->outputData['groups_row'] = $this->outputData['groups']->row();

		$limit = array('4');
		$this->outputData['topEmployees'] = $this->skills_model->topEmployees();
		$this->outputData['topOwners'] = $this->skills_model->topOwners();

		//Get total owner 
		$owner_condtition = array('users.role_id' => '1');
		$owner = $this->admin_model->getUsers($owner_condtition);
		$this->outputData['owners'] = $owner->num_rows();

		//Get total employee
		$employee_condtition = array('users.role_id' => '2');
		$employee = $this->admin_model->getUsers($employee_condtition);
		$this->outputData['employees'] = $employee->num_rows();

		//Get Footer content
		$conditions = array('page.is_active' => 1);
		$this->outputData['pages'] = $this->page_model->getPages($conditions);
		$categories = $this->skills_model->getCategories(array('is_active' => 1));
		$this->outputData['categories'] = $categories->result_array();

		$this->load->view('home', $this->outputData);
	}

	/**
	 * Load FAQ
	 */
	function faq()
	{
		$this->load->model('faq_model');
		$this->outputData['faq'] = $this->faq_model->get_faq();
		$this->load->view('faqs/index', $this->outputData);
	}

	/**
	 * Load static page
	 */
	function page()
	{
		$this->load->model('page_model');
		$page_url = $this->uri->segment(2);
		$page = $this->page_model->get_page($page_url);
		if (!isset($page))
		{


            /*Flash*/
            $success_msg = t('Page does not exist');
            $this->notify->set($success_msg, Notify::ERROR);
            /*End Flash*/
			redirect_back();
		}
		$this->outputData['page'] = $page;
		$this->load->view('page', $this->outputData);
	}

	/**
	 * Sitemap (?)
	 */
	function sitemap()
	{
		$this->outputData['groups_with_categories'] = $this->skills_model->getGroupsWithCategory();
		$this->load->view('sitemap', $this->outputData);
	}

	/**
	 * Send question to support
	 */
	function support()
	{
		$this->load->model('support_model');
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

		if ($this->input->post('submit') != '')
		{
			// Set rules
			if (!$this->logged_in_user)
			{
				$this->form_validation->set_rules('email', t('E-mail'), 'required|trim|valid_email|xss_clean');
			}
			$this->form_validation->set_rules('subject', t('Subject'), 'required|trim|xss_clean');
			$this->form_validation->set_rules('description', t('Description'), 'required|trim|xss_clean');

			if ($this->form_validation->run())
			{
				try
				{
					$data = [];
					$data['subject'] = $this->input->post('subject');
					$data['description'] = $this->input->post('description');
					if ($this->logged_in_user)
					{
						$data['user_id'] = $this->logged_in_user->id;
						$data['email'] = $this->logged_in_user->email;
					}
					else
					{
						$data['email'] = $this->input->post('email');
					}

					$this->support_model->send_question($data);

                    /*Flash*/
                    $success_msg = t('Thank you! We will contact you about your question.');
                    $this->notify->set($success_msg, Notify::SUCCESS);
                    /*End Flash*/
					redirect(current_url());
				}
				catch (Exception $e)
				{
					$this->notify->set($e->getMessage(), Notify::ERROR);
				}
			}
		}

		$this->load->view('support', $this->outputData);
	}
}