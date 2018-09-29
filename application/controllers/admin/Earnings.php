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

class Earnings extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		// Models
		$this->load->model('finance_model');
	}

	/**
	 * Load earnings chart
	 */
	function index()
	{
		$this->add_js([
			'application/js/amcharts/amcharts.js',
			'application/js/amcharts/serial.js',
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
			$field = 'transaction_time';
		}
		if ($this->input->post('order')) {
			$order = $this->input->post('order');
		} else {
			$order = 'DESC';
		}
		$orderby = [$field, $order];

		$period = $this->input->post('period');
		if ($period == '')
		{
			$period = 'day';
		}

		try
		{
			switch ($period)
			{
				case 'day':
					$this->outputData['date_format'] = 'JJ';
					$this->outputData['min_period'] = 'hh';
					break;
				case 'week':
					$this->outputData['date_format'] = 'YYYYMMDD';
					$this->outputData['min_period'] = 'DD';
					break;
				case 'month':
					$this->outputData['date_format'] = 'YYYYMMDD';
					$this->outputData['min_period'] = 'DD';
					break;
				case 'quarter':
					$this->outputData['date_format'] = 'YYYYMM';
					$this->outputData['min_period'] = 'MM';
					break;
				case 'year':
					$this->outputData['date_format'] = 'YYYYMM';
					$this->outputData['min_period'] = 'MM';
					break;
				default:
					throw new Exception('Incorrect period');
			}

			$earnings = $this->finance_model->get_earnings($period, $max, $orderby);
			$earnings_total = count($this->finance_model->get_earnings($period));
			$earnings_chart = $this->finance_model->get_earnings_chart($period);

			$this->outputData['earnings'] = $earnings;
			$this->outputData['pagination'] = get_pagination(admin_url('earnings/index/'), $earnings_total, $page_rows, $page);
			$this->outputData['earnings_chart'] = json_encode($earnings_chart);
		}
		catch (Exception $e)
		{
			$this->notify->set($e->getMessage(), Notify::ERROR);
		}

		if ($this->input->is_ajax_request()) {
			echo response([
				'type' => 'table',
				'data' => $this->load->view('admin/earnings/index_table', $this->outputData, TRUE),
				'pagination' => $this->outputData['pagination'],
				'earnings_chart' => $this->outputData['earnings_chart'],
				'date_format' => $this->outputData['date_format'],
				'min_period' => $this->outputData['min_period']
			]);
		} else {
			$this->load->view('admin/earnings/index', $this->outputData);
		}
	}
}