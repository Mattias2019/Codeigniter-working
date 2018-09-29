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

class Search extends MY_Controller
{
	
	// Constructor
	function __construct()
	{
		parent::__construct();

		$this->load->library('cart');
		$this->load->library('settings');

		$this->load->helper('pagination');

		// Get Config Details From Db
		$this->settings->db_config_fetch();

		// Manage site Status
		if ($this->config->item('site_status') == 1) redirect('offline');

		// Load Models
		$this->load->model('common_model');
		$this->load->model('quote_model');
		$this->load->model('skills_model');
		$this->load->model('user_model');

		// Get Footer content
		$this->outputData['pages'] = $this->common_model->getPages();

		// Currency Type
		$this->outputData['currency'] = $this->db->get_where('settings', array(
			'code' => 'CURRENCY_TYPE'
		))->row()->string_value;

		// Get Latest Jobs
		$limit_latest = $this->config->item('latest_projects_limit');
		$limit3 = array(
			$limit_latest
		);
		$this->outputData['latestJobs'] = $this->skills_model->getLatestJobs($limit3);

		// language file
		load_lang('enduser/search');

	$this->add_js([
        'application/js/jquery.bootstrap-dropdown-hover.min.js'
    ]);

		$categories = $this->skills_model->getCategories();
		$this->outputData['categories'] = $categories;
	}
	
	/**
	 * Search tendered projects
	 */
	function tender()
	{
		// Load Language
		load_lang('enduser/job');

		$this->add_css([
            'application/css/css/tmpl-css/jQuery-plugin-progressbar.css',
			'application/css/css/build.css',
			'application/css/css/multiselect.css?v='.time(),
			'application/css/css/themes/smoothness/jquery-ui.min.css',
			'application/css/css/custom-slider.css',
            'application/css/css/projects.css'
		]);

		$this->add_js([
            'application/js/tmpl-js/jQuery-plugin-progressbar.js',
			'application/js/dropdown.js',
			'application/js/jquery.inputmask.bundle.min.js',
			'application/js/custom-slider.js',
			'application/js/pagination.js',
            'application/js/amcharts/amcharts.js',
            'application/js/amcharts/serial.js',
            'application/js/search_tender.js'
        ]);

        $options = [
            "show_more" => t('Show More'),
            "show_less" => t('Show Less')
        ];
        $this->init_js(["tender.init('".site_url()."',".json_encode($options).")"]);

		// Load model
		$this->load->model('project_model');

		// Search Parameters
		$keyword = $this->input->post('keyword');

		$categories = $this->input->post('categories');
		if ($categories == NULL) {
			$categories = [];
		}

		$budget_min = $this->input->post('budget_min');
		$budget_max = $this->input->post('budget_max');

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
		if ($this->input->post('field')) {
			$field = $this->input->post('field');
		} else {
			$field = '';
		}
		if ($this->input->post('order')) {
			$order = $this->input->post('order');
		} else {
			$order = '';
		}
		$orderby = [$field, $order];

		// Id
		$id = $this->input->get('id');

		$jobs = $this->project_model->get_new_projects($categories, $budget_min, $budget_max, $max, $orderby, $keyword, $id);
		$jobs_total = $this->project_model->get_new_projects($categories, $budget_min, $budget_max, [], $orderby, $keyword, $id);

		$this->outputData['jobs'] = $jobs;

		$this->outputData['pagination'] = get_pagination(site_url('search/tender/'), count($jobs_total), $page_rows, $page);

        if ($jobs_total == 0) {
            $this->outputData['page_numbers'] = array();
        }

		// Get all groups/categories for select
		$this->outputData['groups_with_categories'] = $this->skills_model->getGroupsWithCategory([], $this->logged_in_user->id);

		$this->outputData['parent_controller'] = 'search/tender';

		if ($this->input->is_ajax_request()) {
			echo response([
				'type' => 'table',
				'data' => $this->load->view('search/project_table', $this->outputData, TRUE),
				'pagination' => $this->outputData['pagination']
			]);
		} else {
			$this->load->view('search/project', $this->outputData);
		}
	}

	/**
	 * Search machinery page and search results for Owner
	 */
	function machinery()
	{
		// Load Models
		$this->load->model('machinery_model');

		$this->add_css([
			'application/css/css/build.css',
			'application/css/css/multiselect.css?v='.time(),
			'application/css/css/themes/smoothness/jquery-ui.min.css',
			'application/css/css/custom-slider.css',
			'application/css/css/machinery.css'
		]);

		$this->add_js([
			'application/js/dropdown.js',
			'application/js/jquery.inputmask.bundle.min.js',
			'application/js/custom-slider.js',
            'application/js/search_machinery.js'
		]);

        $this->init_js(["machinery.init('".site_url()."',".json_encode('').")"]);

		// Search Parameters
		$keyword = $this->input->post('keyword');

		$categories = $this->input->post('categories');
		if ($categories == NULL) {
			$categories = [];
		}

		// Search GET parameters for SEO
		if (count($categories) == 0)
		{
			$get_group = $this->input->get('group');
			$get_category = $this->input->get('category');
			if ($get_group != NULL or $get_category != NULL)
			{
				$get_res = $this->skills_model->get_category_by_name($get_group, $get_category);
				foreach ($get_res as $get_item)
				{
					$categories[] = $get_item['category_id'];
				}
			}
			$this->outputData['selectedCategories'] = $categories;
		}

		$budget_min = $this->input->post('budget_min');
		$budget_max = $this->input->post('budget_max');

		if ($this->input->get('compare') != '')
		{
			$compare = explode(',', $this->input->get('compare'));
		}
		else
		{
			$compare = $this->input->post('compare');
			if ($compare == NULL) {
				$compare = [];
			}
		}

		// Get number of items already shown
		$offset = $this->input->post('offset');
		if ($offset == NULL) {
			$offset = 0;
		}
		$page_rows = 12;
		$max = [$page_rows, $offset];

		// Base view
		if (count($compare) == 0)
		{
			$portfolios = $this->machinery_model->get_machinery($categories, $budget_min, $budget_max, $max, $keyword);
			$portfolios_total = $this->machinery_model->get_machinery($categories, $budget_min, $budget_max, $keyword);
			$this->outputData['compare'] = FALSE;
			$this->outputData['load_all'] = (count($portfolios) == count($portfolios_total));
			$this->outputData['count_all'] = (count($portfolios_total));
		}
		// Compare machinery
		else
		{
			$portfolios = $this->machinery_model->get_machinery_for_compare($compare);
			$this->outputData['compare'] = TRUE;
			$this->outputData['load_all'] = TRUE;
			$this->outputData['count_all'] = (count($portfolios));
		}
		$this->outputData['portfolios'] = $portfolios;

		// Get all groups/categories for select
		$this->outputData['groups_with_categories'] = $this->skills_model->getGroupsWithCategory([], $this->logged_in_user->id);
		$this->outputData['parent_controller'] = 'search/machinery';

		if ($this->input->is_ajax_request()) {
			echo response([
				'table' => $this->load->view('search/machinery_table', $this->outputData, TRUE),
				'count_all' => $this->outputData['count_all']
			]);
		} else {
			$this->load->view('search/machinery', $this->outputData);
		}
	}

	/**
	 * Send quote request for machinery
	 */
	function send_quote_request()
	{
		if ($this->input->is_ajax_request())
		{
			$machinery_id = $this->input->get('id');
			if ($machinery_id == NULL)
			{
				echo response(t('Machinery is not found'), TRUE);
				return;
			}

			try
			{
				$this->quote_model->send_quote_request($machinery_id);
				echo response(t('Quote request sent successfully'));
			}
			catch (Exception $e)
			{
				echo response($e->getMessage(), TRUE);
			}
		}
	}

	/**
	 * Load quote request page
	 */
	function quote_request()
	{
		// Load Language
		load_lang('enduser/job');

		$this->add_css([
            'application/css/css/tmpl-css/jQuery-plugin-progressbar.css',
			'application/css/css/build.css',
			'application/css/css/multiselect.css?v='.time(),
			'application/css/css/themes/smoothness/jquery-ui.min.css',
			'application/css/css/custom-slider.css'
		]);

		$this->add_js([
            'application/js/tmpl-js/jQuery-plugin-progressbar.js',
			'application/js/dropdown.js',
			'application/js/jquery.inputmask.bundle.min.js',
			'application/js/custom-slider.js',
			'application/js/pagination.js',
            'application/js/amcharts/amcharts.js',
            'application/js/amcharts/serial.js',
            'application/js/quote_request.js'
		]);

        $this->init_js(["quote_request.init('".site_url()."')"]);

        // Search Parameters
        $keyword = $this->input->post('keyword');

        $categories = $this->input->post('categories');
        if ($categories == NULL) {
            $categories = [];
        }

        // Search GET parameters for SEO
        if (count($categories) == 0)
        {
            $get_group = $this->input->get('group');
            $get_category = $this->input->get('category');
            if ($get_group != NULL or $get_category != NULL)
            {
                $get_res = $this->skills_model->get_category_by_name($get_group, $get_category);
                foreach ($get_res as $get_item)
                {
                    $categories[] = $get_item['category_id'];
                }
            }
            $this->outputData['selectedCategories'] = $categories;
        }

		$budget_min = $this->input->post('budget_min');
		$budget_max = $this->input->post('budget_max');

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
		if ($this->input->post('field')) {
			$field = $this->input->post('field');
		} else {
			$field = 'j.id';
		}
		if ($this->input->post('order')) {
			$order = $this->input->post('order');
		} else {
			$order = 'desc';
		}
		$order_by = [$field, $order];

		$jobs = $this->project_model->get_requested_projects($categories, $budget_min, $budget_max, $max, $order_by, $keyword);
		$jobs_total = $this->project_model->get_requested_projects($categories, $budget_min, $budget_max, [], $order_by, $keyword);

		$this->outputData['jobs'] = $jobs;

		$this->outputData['pagination'] = get_pagination(site_url('search/tender/'), count($jobs_total), $page_rows, $page);

		// Get all groups/categories for select
		$this->outputData['groups_with_categories'] = $this->skills_model->getGroupsWithCategory([], $this->logged_in_user->id);

		$this->outputData['parent_controller'] = 'search/quote_request';

		if ($this->input->is_ajax_request()) {
			echo response([
				'type' => 'table',
				'data' => $this->load->view('search/project_table', $this->outputData, TRUE),
				'pagination' => $this->outputData['pagination']
			]);
		} else {
			$this->load->view('search/project', $this->outputData);
		}
	}
}