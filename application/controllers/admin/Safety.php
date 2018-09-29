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

class Safety extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		if($this->config->item('site_status') == 1)
		{
			redirect('offline');
		}

		$this->load->model('user_model');
	}

	function failed_logins()
	{
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

		$logins = $this->user_model->get_failed_logins($max, $orderby);
		$logins_total = count($this->user_model->get_failed_logins());

		$this->outputData['logins'] = $logins;
		$this->outputData['pagination'] = get_pagination(admin_url('safety/failed_logins/'), $logins_total, $page_rows, $page);

		if ($this->input->is_ajax_request()) {
			echo response([
				'type' => 'table',
				'data' => $this->load->view('admin/safety/failed_logins_table', $this->outputData, TRUE),
				'pagination' => $this->outputData['pagination']
			]);
		} else {
			$this->load->view('admin/safety/failed_logins', $this->outputData);
		}
	}
}