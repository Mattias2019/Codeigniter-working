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

class PaymentSettings extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

        $this->load->library('settings');

        //Get Config Details From Db
        $this->settings->db_config_fetch();

        // loading the lang files
        load_lang(['admin/common', 'admin/setting', 'admin/validation']);

        //Load Models Common to all the functions in this controller
        $this->load->model('common_model');
		$this->load->model('finance_model');
        $this->load->model('payment_model');

        //Get Logged In user
        $this->logged_in_user = $this->common_model->get_logged_in_user();
        $this->outputData['logged_in_user'] = $this->logged_in_user;

    }

    /**
     * Loads payment settings page
     */
    function index()
    {
        $this->add_js([
            'application/js/jquery.inputmask.bundle.min.js',
            'application/js/custom-inputmask.js'
        ]);

        $this->outputData['settings'] = $this->payment_model->getPaymentSettings();
        $this->load->view('admin/settings/payment', $this->outputData);
    }

    /**
     * Save and reload payment row
     */
    function savePayment()
    {
        if ($this->input->is_ajax_request()) {
            $data = [
                'id' => $this->input->post('id'),
                'title' => strip_tags($this->input->post('title')),
                'is_deposit_enabled' => $this->input->post('is_deposit_enabled'),
                'deposit_description' => strip_tags($this->input->post('deposit_description')),
                'deposit_minimum' => $this->input->post('deposit_minimum'),
                'is_withdraw_enabled' => $this->input->post('is_withdraw_enabled'),
                'withdraw_description' => strip_tags($this->input->post('withdraw_description')),
                'withdraw_minimum' => $this->input->post('withdraw_minimum'),
                'commission' => $this->input->post('commission'),
                'credentials' => $this->input->post('credentials')
            ];

            $id = $this->payment_model->savePayment($data);
            $payment = $this->payment_model->getPayment($id);
            if (isset($payment)) {
                echo response(['data' => $this->load->view('admin/settings/payment_row', ['payment' => $payment], TRUE)]);
            } else {
                echo response('Error saving data', TRUE);
            }
        }
    }

    /**
     * Reload one row
     */
    function refreshPayment()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            if ($id != '') {
                $payment = $this->payment_model->getPayment($id);
                if (isset($payment)) {
                    echo response(['data' => $this->load->view('admin/settings/payment_row', ['payment' => $payment], TRUE)]);
                } else {
                    echo response('Error loading data', TRUE);
                }
            } else {
                echo response('Error loading data', TRUE);
            }
        }
    }

    /**
     * Pricing cockpit form
     */
    function pricingCockpit()
    {
        load_lang('date');

        $this->load->model('settings_model');

        // load validation library
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        // Get Form Details
        if ($this->input->post('siteSettings')) {
            // Set rules
            $this->form_validation->set_rules('payment_settings', 'lang:payment_settings_validation', 'numeric|required|trim|xss_clean');
            $this->form_validation->set_rules('featured_jobs_limit', 'lang:featured_projects_limit_validation', 'numeric|required|trim|xss_clean');
            $this->form_validation->set_rules('urgent_jobs_limit', 'lang:urgent_projects_limit_validation', 'numeric|required|trim|xss_clean');
            $this->form_validation->set_rules('latest_jobs_limit', 'lang:latest_projects_limit_validation', 'numeric|required|trim|xss_clean');
            $this->form_validation->set_rules('provider_commission_amount', 'lang:provider_commission_amount_validation', 'numeric|required|trim|xss_clean');
            $this->form_validation->set_rules('employee_free_credits', 'lang:employee_free_credits_validation', 'numeric|required|trim|xss_clean');
            $this->form_validation->set_rules('featured_jobs_amount', 'lang:featured_projects_amount_validation', 'numeric|required|trim|xss_clean');
            $this->form_validation->set_rules('urgent_jobs_amount', 'lang:urgent_projects_amount_validation', 'numeric|required|trim|xss_clean');
            $this->form_validation->set_rules('hide_jobs_amount', 'lang:hide_projects_amount_validation', 'numeric|required|trim|xss_clean');
            $this->form_validation->set_rules('private_job_amount', 'lang:private_project_amount_validation', 'numeric|required|trim|xss_clean');

            if ($this->form_validation->run()) {
                $updateData = [];
				$updateData['disable_escrow'] = ($this->input->post('disable_escrow') == 1) ? 1 : 0;
                $updateData['forced_escrow'] = ($this->input->post('forced_escrow') == 1) ? 1 : 0;
                $updateData['payment_settings'] = $this->input->post('payment_settings');
                $updateData['featured_projects_limit'] = $this->input->post('featured_jobs_limit');
                $updateData['urgent_projects_limit'] = $this->input->post('urgent_jobs_limit');
                $updateData['latest_projects_limit'] = $this->input->post('latest_jobs_limit');
                $updateData['provider_commission_amount'] = $this->input->post('provider_commission_amount');
                $updateData['employee_free_credits'] = $this->input->post('employee_free_credits');
                $updateData['featured_projects_amount'] = $this->input->post('featured_jobs_amount');
                $updateData['urgent_projects_amount'] = $this->input->post('urgent_jobs_amount');
                $updateData['hide_projects_amount'] = $this->input->post('hide_jobs_amount');
                $updateData['private_project_amount'] = $this->input->post('private_job_amount');
                $updateData['currency'] = $this->input->post('currency');
                $updateData['time_zone'] = $this->input->post('time_zone');
                $updateData['daylight'] = ($this->input->post('daylight') == 1) ? 1 : 0;

                $this->settings_model->updateSiteSettings($updateData);

                // Notification message
                $this->notify->set(t('updated_success'), Notify::SUCCESS);
            }
        }

        $this->outputData['settings'] = $this->settings_model->getSiteSettings();
        $this->outputData['currency'] = $this->settings_model->setCurrency();
        $this->outputData['timezones'] = timezones();

        $this->load->view('admin/settings/pricing', $this->outputData);
    }

	/**
	 * Escrow fee modulator
	 */
	function escrowFee()
	{
		$this->fee(Finance_model::FEE_ESCROW);
	}

	/**
	 * Platform fee modulator
	 */
	function platformFee()
	{
		$this->fee(Finance_model::FEE_PLATFORM);
	}

	/**
	 * Fee modulator
	 *
	 * @param $fee_type
	 */
	function fee($fee_type)
	{
		$this->load->model('finance_model');

        $this->add_js([
            'application/js/amcharts/amcharts.js',
            'application/js/amcharts/xy.js'
        ]);

        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

		if ($this->input->post('submit'))
		{
			$data = [];
			foreach ($this->input->post('fee') as $i => $fee)
			{
				$data[] = [
					'id' => $i,
					'min_amount' => array_key_exists('amount', $fee)?$fee['amount']:NULL,
					'fee_percent' => $fee['percent']
				];
			}

			$this->finance_model->save_fees($data, $fee_type);
		}

		$this->outputData['fees'] = $this->finance_model->get_fees($fee_type);
		$this->outputData['chart_data'] = $this->finance_model->get_fees_for_chart($fee_type);
		$this->outputData['base_controller'] = ($fee_type == Finance_model::FEE_ESCROW) ? 'paymentSettings/escrowFee' : 'paymentSettings/platformFee';

		$this->load->view('admin/settings/fee', $this->outputData);
	}
}