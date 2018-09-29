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

class Payments extends MY_Controller {

	// Constructor
	function __construct()
	{
		parent::__construct();

		$this->load->library('settings');

		//Get Config Details From Db
		$this->settings->db_config_fetch();

		// loading the lang files
		load_lang(['admin/common', 'admin/payments', 'admin/setting', 'admin/validation']);

		//Load Models
		$this->load->model('common_model');
		$this->load->model('payment_model');
		$this->load->model('user_model');
		$this->load->model('settings_model');
		$this->load->model('finance_model');

		//Load users list
		$usersList = $this->user_model->getUserslist();
		$this->outputData['usersList'] = $usersList;

		//Load users roles
		$roles = $this->user_model->getRoles();
		$this->outputData['roles'] = $roles;

		//load validation library
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

		//Load Form Helper
		$this->load->helper('form');

		$paymentGateways = $this->payment_model->getPaymentSettings();
		$this->outputData['paymentGateways'] = $paymentGateways;

	}

	/**
	 * Main transaction manager page
	 */
	function transaction()
	{
		$this->add_js([
			'application/js/jquery.inputmask.bundle.min.js',
			'application/js/custom-inputmask.js',
			'application/js/pagination.js',
            'application/plugins/select2/js/select2.full.js',
            'application/js/admin/transactions.js',
		]);

        $this->add_css([
            'application/plugins/select2/css/select2.css',
        ]);

        $this->init_js(["transactions.init('" . admin_url() . "');"]);

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

		// Segment
		if ($this->input->is_ajax_request())
		{
			$segment = $this->input->post('segment');
		}
		else
		{
			$segment = $this->uri->segment(4);
		}

		// Submit
		if ($this->input->post('submit') != '')
		{
			// Set rules
			$this->form_validation->set_rules('type', 'Type', 'required|trim|xss_clean');

			if ($this->input->post('type') == 0 or $this->input->post('type') == 1)
			{
				$this->form_validation->set_rules('payment_method', 'Payment Method', 'required|trim|xss_clean');
			}
			elseif ($this->input->post('type') > 1)
			{
				$this->form_validation->set_rules('job_id', 'Project', 'required|trim|xss_clean');
				$this->form_validation->set_rules('milestone_id', 'Milestone', 'trim|xss_clean');
			}

			if ($this->input->post('type') != 2 and $this->input->post('type') != 5 and $this->input->post('type') != 6)
			{
				$this->form_validation->set_rules('amount', 'Amount', 'required|trim|integer|is_natural|abs|xss_clean|callback_enough_funds');
			}

			if ($this->form_validation->run())
			{
				try
				{
					if ($this->input->post('type') == 0) // Deposit
					{
						$this->finance_model->deposit($this->input->post('amount'), $this->input->post('payment_method'), '', '', $this->input->post('user_id'));
					}
					elseif ($this->input->post('type') == 1) // Withdraw
					{
						$this->finance_model->withdraw($this->input->post('amount'), $this->input->post('payment_method'), $this->input->post('user_id'));
					}
					elseif ($this->input->post('type') == 2) // Project fee
					{
						$this->finance_model->project_fee($this->input->post('job_id'), $this->input->post('amount'));
					}
					elseif ($this->input->post('type') == 3) // Transfer
					{
						$this->finance_model->transfer($this->input->post('job_id'), $this->input->post('milestone_id'), null, $this->input->post('amount'), $this->input->post('user_id'));
					}
					elseif ($this->input->post('type') == 4) // Escrow request
					{
						$this->finance_model->escrow_request($this->input->post('job_id'), $this->input->post('milestone_id'), $this->input->post('amount'), $this->input->post('user_id'));
					}
					elseif ($this->input->post('type') == 5) // Escrow release
					{
						$this->finance_model->escrow_release($this->input->post('job_id'), $this->input->post('milestone_id'));
					}
					elseif ($this->input->post('type') == 6) // Escrow cancel
					{
						$this->finance_model->escrow_cancel($this->input->post('job_id'), $this->input->post('milestone_id'));
					}

					redirect(admin_url('payments/transaction'));
				}
				catch (Exception $e)
				{
					$this->notify->set($e->getMessage(), Notify::ERROR);
				}
			}
		}

		// Parameters
		$id = $this->input->post('id');
		$type = $this->input->post('type');

		// Get data
		if ($segment == 1 or $segment == '')
		{
			$transactions = $this->finance_model->get_all_transactions($id, $type, $max, $orderby);
			$transactions_count = $this->finance_model->get_all_transactions_count($id, $type);
			$view = 'admin/payments/transaction_all';

			$this->outputData['transaction_types'] = $this->finance_model->get_transaction_types();
			$this->outputData['transactions'] = $transactions;
			$this->outputData['pagination'] = get_pagination(site_url('admin/payments/transaction/'), $transactions_count, $page_rows, $page);
		}
		elseif ($segment == 2)
		{
			$this->outputData['transaction_types'] = $this->finance_model->get_transaction_types();
			$this->outputData['payment_methods'] = $this->finance_model->get_payment_methods();

			$this->outputData['users'] = $this->user_model->getUsers(
			    array(),
                'users.id, ifnull(users.user_name,concat(users.first_name," ",users.last_name)) as user_name',
                array('roles.role_name'=>array(ROLE_PROVIDER, ROLE_ENTREPRENEUR))
            )->result_array();

			$this->outputData['projects'] = [];
			$this->outputData['milestones'] = [];
			$view = 'admin/payments/transaction_add';
		}
		else
		{
			// Fallback
			return;
		}
		$this->outputData['view'] = $view;

		if ($this->input->is_ajax_request()) {
			if ($this->input->post('table_only') == 'true')
			{
				echo response([
					'type' => 'table',
					'data' => $this->load->view($view.'_table', $this->outputData, TRUE),
					'pagination' => $this->outputData['pagination']
				]);
			}
			else
			{
				echo response([
					'type' => 'all',
					'data' => $this->load->view($view, $this->outputData, TRUE)
				]);
			}
		} else {
			$this->load->view('admin/payments/transaction', $this->outputData);
		}
	}

	/**
	 * User info for "Add transaction" form
	 */
	function get_user_info()
	{
		if ($this->input->is_ajax_request())
		{
			$this->load->model('project_model');

			$user_id = $this->input->post('user_id');
			$user = $this->user_model->getUsers(['users.id' => $user_id])->row();
			if (isset($user))
			{
				$this->outputData['projects'] = $this->project_model->get_user_projects($user->id);
				$balance = currency().number_format($this->finance_model->get_user_balance($user->id));
			}
			else
			{
				$this->outputData['projects'] = [];
				$balance = '';
			}
			echo response([
				'projects' => $this->load->view('admin/payments/transaction_add_projects', $this->outputData, TRUE),
				'balance' => $balance
			]);
		}
	}

	/**
	 * Project info for "Add transaction" form
	 */
	function get_project_info()
	{
		if ($this->input->is_ajax_request())
		{
			$this->load->model('project_model');

			$id = $this->input->post('id');
			$this->outputData['milestones'] = $this->project_model->get_project_milestones($id);

			$project = $this->project_model->get_project_by_id($id);
			if (isset($project))
			{
				$fee = currency().number_format($this->finance_model->get_project_fee($id, $project['is_urgent'], $project['is_feature'], $project['is_hide_bids'], $project['is_private']));
			}
			else
			{
				$fee = '';
			}

			echo response([
				'milestones' => $this->load->view('admin/payments/transaction_add_milestones', $this->outputData, TRUE),
				'fee' => $fee
			]);
		}
	}

	/**
	 * Escrow fee for "Add transaction" form
	 */
	function get_escrow_fee()
	{
		if ($this->input->is_ajax_request())
		{
			$amount = $this->input->post('amount');
			if ($amount != '')
			{
				try
				{
					echo response(['fee' => currency().number_format($this->finance_model->get_fee($amount, Finance_model::FEE_ESCROW))]);
				}
				catch (Exception $e)
				{
					echo response($e->getMessage(), TRUE);
				}
			}
			else
			{
				echo response(['fee' => '']);
			}
		}
	}

	/**
	 * Check if there is enough funds for operation
	 *
	 * @param $field
	 * @return bool
	 */
	function enough_funds($field)
	{
		$this->form_validation->set_message('enough_funds', 'Insufficient funds.');
		if ($this->input->post('type') == 0)
		{
			return TRUE;
		}
		elseif ($this->input->post('type') == 1 or $this->input->post('type') == 3)
		{
			return ($this->finance_model->get_user_balance($this->input->post('user_id')) >= $field);
		}
		else
		{
			return ($this->finance_model->get_user_balance($this->input->post('user_id')) >= ($field + $this->finance_model->get_fee($field, Finance_model::FEE_ESCROW)));
		}
	}

	/**
	 * Confirm transaction
	 */
	function confirm()
	{
		if ($this->input->is_ajax_request())
		{
			$id = $this->input->get('id');
			try
			{
				$this->finance_model->finalize_transaction($id);
				echo response(null);
			}
			catch (Exception $e)
			{
				echo response($e->getMessage(), TRUE);
			}
		}
	}

	/**
	 * Cancel transaction
	 */
	function cancel()
	{
		if ($this->input->is_ajax_request())
		{
			$id = $this->input->get('id');
			try
			{
				$this->finance_model->cancel_transaction($id);
				echo response(null);
			}
			catch (Exception $e)
			{
				echo response($e->getMessage(), TRUE);
			}
		}
	}

	/**
	 * VAT compliance matrix
	 */
	function vat()
	{
		if ($this->input->post('submit') != '')
		{
			foreach ($this->input->post('vat') as $i => $val)
			{
				foreach ($this->input->post('vat')[$i] as $j => $val)
				{
					$this->form_validation->set_rules('vat['.$i.']['.$j.']', 'VAT', 'trim|decimal|greater_than_equal_to[0]|less_than[100]|xss_clean');
				}
			}

			if ($this->form_validation->run())
			{
				try
				{
					$this->finance_model->save_vat_matrix($this->input->post('vat'));
				}
				catch (Exception $e)
				{
					$this->notify->set($e->getMessage(), Notify::ERROR);
				}
			}
		}

		$this->outputData['vat'] = $this->finance_model->get_vat_matrix();
		$this->load->view('admin/payments/vat', $this->outputData);
	}

	/**
	 * Import tax compliance matrix
	 */
	function import()
	{
		if ($this->input->post('submit') != '')
		{
			foreach ($this->input->post('import') as $i => $val)
			{
				foreach ($this->input->post('import')[$i] as $j => $val)
				{
					$this->form_validation->set_rules('import['.$i.']['.$j.']', 'Import tax', 'trim|decimal|greater_than_equal_to[0]|less_than[100]|xss_clean');
				}
			}

			if ($this->form_validation->run())
			{
				try
				{
					$this->finance_model->save_import_matrix($this->input->post('import'));
				}
				catch (Exception $e)
				{
					$this->notify->set($e->getMessage(), Notify::ERROR);
				}
			}
		}

		$this->outputData['import'] = $this->finance_model->get_import_matrix();
		$this->load->view('admin/payments/import', $this->outputData);
	}
}