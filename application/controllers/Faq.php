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

class Faq extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->library('settings');

		//Get Config Details From Db
		$this->settings->db_config_fetch();

		//Check site Status
		if ($this->config->item('site_status') == 1)
			redirect('offline');

		//Load Models
		$this->load->model('common_model');
		$this->load->model('faq_model');
		$this->load->model('skills_model');
		$this->load->model('email_model');

		//Get Footer content
		$this->outputData['pages'] = $this->common_model->getPages();

		//Get Latest jobs
		$limit_latest = $this->config->item('latest_projects_limit');
		$limit3 = array($limit_latest);
		$this->outputData['latestJobs'] = $this->skills_model->getLatestJobs($limit3);

		//language file
		load_lang('enduser/faq');

		//GeT current Page
		$this->outputData['current_page'] = 'faq';

	}

	/**
	 * Loads Faqs page.
	 *
	 * @access    private
	 * @param    nil
	 * @return    void
	 */
	function index_old()
	{
		//load validation library
		$this->load->library('form_validation');

		//Load Form Helper
		$this->load->helper('form');

		//Intialize values for library and helpers	
		$this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

		//Get Form Data	
		if ($this->input->post('faqPosts')) {
			//Set rules
			$this->form_validation->set_rules('faq_email', 'lang:faq_email_id', 'required|trim|valid_email|xss_clean');
			$this->form_validation->set_rules('faq_subject', 'lang:faq_subject', 'required|trim|xss_clean');
			$this->form_validation->set_rules('faq_comments', 'lang:faq_comments', 'required|trim|xss_clean|min_length[25]');

			if ($this->form_validation->run()) {
				//Insert the faq into table
				$enduser_id = $this->input->post('faq_email');
				$subject = $this->input->post('faq_subject');
				$comments = $this->input->post('faq_comments');
				$from = $this->config->item('site_admin_mail');

				$insertData = array();
				$insertData['email_id'] = $this->input->post('faq_email');
				$insertData['subject'] = $this->input->post('faq_subject');
				$insertData['comments'] = $this->input->post('faq_comments');
				$insertData['created'] = get_est_time();

				//Create User
				//$this->contact_model->insertContactPost($insertData);

				$sent_email = $this->email_model->sendHtmlMail($from, $enduser_id, $subject, $comments);

				//Set the Success Message
				$success_msg = t('confirmation_text');

				//Notification message
				$this->notify->set($success_msg, Notify::SUCCESS);
				redirect('information');
			}  //Form Validation End

		} //If - Form Submission End

		//Get Frequent Asked Questions
		$conditions = array('is_frequent' => 'Y');

		$this->outputData['frequentFaqs'] = $this->faq_model->getFaqs($conditions);

		//Load View
		$this->load->view('faqs/viewFaqs', $this->outputData);

	}//End of faq index function

	// --------------------------------------------------------------------

	/**
	 * Loads Faqs settings page.
	 *
	 * @access    private
	 * @param    nil
	 * @return    void
	 */
	function view()
	{
		//Get id of the group	
		$id = is_numeric($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		//Get Question and answer
		$conditions = array('faqs.id' => $id);

		//Get a particular faq
		$this->outputData['faqs'] = $this->faq_model->getFaqs($conditions);

		//Load View
		$this->load->view('faqs/viewFaq', $this->outputData);

	}//End of view function

	// --------------------------------------------------------------------

	/**
	 * Loads Faqs settings page.
	 *
	 * @access    private
	 * @param    nil
	 * @return    void
	 */
	function all()
	{
		//Get Groups
		$this->outputData['FaqCategoriesWithFaqs'] = $this->faq_model->getFaqCategoriesWithFaqs();

		//Load View
		$this->load->view('faqs/viewFaqByCategories', $this->outputData);

	}//End of all function

	/**
	 * Loads Faqs for the search faq.
	 *
	 * @access    private
	 * @param    nil
	 * @return    void
	 */
	function search()
	{

		$keyword = $this->input->get('keywords');
		$match = $this->input->get('match');
		$like = array('faqs.question' => $keyword);
		$object = $this->faq_model->getFaqs(NULL, $like);
		$this->outputData['faqs'] = $object;
		$this->outputData['keyword'] = $keyword;
		//Load View
		$this->load->view('faqs/searchFaqs', $this->outputData);

	}//End of search function
}