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

class Dispute extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		if($this->config->item('site_status') == 1)
		{
			redirect('offline');
		}

		$this->load->model('cancel_model');
		$this->load->model('messages_model');

		load_lang(['enduser/cancel', 'enduser/job', 'enduser/messages']);
	}

	/**
	 * View open cases
	 */
	function index()
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

		$this->outputData['cases'] = $this->cancel_model->get_admin_cases();

		// Parameters
		if ($this->input->post('segment'))
		{
			$current_case = $this->cancel_model->get_case($this->input->post('segment'));
		}
		elseif (count($this->outputData['cases']) > 0)
		{
			$current_case = $this->outputData['cases'][0];
		}
		else
		{
			$current_case = NULL;
		}

		// Operations
		try
		{
			if ($this->input->post('close'))
			{
				$this->cancel_model->admin_close_case($current_case['id']);
				$current_case = $this->cancel_model->get_case($this->input->post($current_case['id']));
			}
			elseif ($this->input->post('cancel'))
			{
				$this->cancel_model->admin_cancel_case_project($current_case['id']);
				$current_case = $this->cancel_model->get_case($this->input->post($current_case['id']));
			}
			elseif ($this->input->post('escalate'))
			{
				$this->cancel_model->admin_escalate_case($current_case['id']);
				$current_case = $this->cancel_model->get_case($this->input->post($current_case['id']));
			}
		}
		catch (Exception $e)
		{
			$this->notify->set($e->getMessage(), Notify::ERROR);
		}

		$messages = $this->messages_model->get_admin_case_messages($current_case['id'], $max, $order_by);
		$messages_count = count($this->messages_model->get_admin_case_messages($current_case['id'], '', ''));

		$this->outputData['current_case'] = $current_case;
		$this->outputData['messages'] = $messages;
		$this->outputData['pagination'] = get_pagination(site_url('cancel'), $messages_count, $page_rows, $page);

		if ($this->input->is_ajax_request())
		{
			if ($this->input->post('table_only') == 'true')
			{
				echo response([
					'type' => 'table',
					'data' => $this->load->view('admin/dispute/view_table', $this->outputData, TRUE),
					'pagination' => $this->outputData['pagination']
				]);
			}
			else
			{
				echo response([
					'type' => 'all',
					'data' => $this->load->view('admin/dispute/view_tab', $this->outputData, TRUE)
				]);
			}
		}
		else
		{
			$this->load->view('admin/dispute/view', $this->outputData);
		}
	}

	/**
	 * Approve message
	 */
	function approve_message()
	{
		if ($this->input->is_ajax_request())
		{
			$id = $this->input->get('id');
			try
			{
				$this->messages_model->admin_approve_message($id);
				echo response(null);
			}
			catch (Exception $e)
			{
				echo response($e->getMessage(), TRUE);
			}
		}
	}

	/**
	 * Cancel message
	 */
	function reject_message()
	{
		if ($this->input->is_ajax_request())
		{
			$id = $this->input->get('id');
			try
			{
				$this->messages_model->admin_reject_message($id);
				echo response(null);
			}
			catch (Exception $e)
			{
				echo response($e->getMessage(), TRUE);
			}
		}
	}
}