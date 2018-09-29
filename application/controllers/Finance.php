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

use Dompdf\Dompdf;

/**
 * Class Finance
 *
 * Financial information and operations
 */
class Finance extends MY_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('common_model');
        $this->load->model('finance_model');
        $this->load->model('payment_model');
        $this->load->model('project_model');
        $this->load->model('user_model');

        $this->load->helper('finance');
        $this->load->helper('form');
        $this->load->helper('pagination');
        $this->load->helper('url');

        load_lang('enduser/finance');
    }

    /**
     * Spending calendar for entrepreneur
     */
    function spending()
    {
        $this->index(1);
    }

    /**
     * Hub for finance pages
     *
     * @param $segment
     */
    function index($segment = '')
    {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        $this->add_css([
            'application/css/css/tmpl-css/bootstrap-datepicker.css',
            'application/css/css/finance.css'
        ]);

        $this->add_js([
            'application/js/tmpl-js/bootstrap-datepicker.js',
            'application/js/jquery.inputmask.bundle.min.js',
            'application/js/custom-inputmask.js',
            'application/js/amcharts/amcharts.js',
            'application/js/amcharts/serial.js',
            'application/js/pagination.js',
            'application/js/finance.js'
        ]);

        $this->init_js(["finance.init('" . site_url() . "');"]);

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
        $order_by = [$field, $order];

        // Segments
        if ($segment == '') {
            if ($this->input->post('segment') != '') {
                $segment = $this->input->post('segment');
            } elseif ($this->uri->segment(2) != '') {
                $segment = $this->uri->segment(2);
            }
        }

        // Parameters
        $date_begin = $this->input->post('date_begin');
        if ($date_begin == '') {
            $date_begin = strtotime('first day of previous month', get_est_time());
            $_POST['date_begin'] = $date_begin;
        }
        $date_end = $this->input->post('date_end');
        if ($date_end == '') {
            $date_end = get_est_time();
            $_POST['date_end'] = $date_end;
        }
        $_POST['date_diff'] = ceil(($date_end - $date_begin) / DAY) + 1;

        $project = $this->input->get('project');
        if (!empty($project) && empty($_POST['job_id'])) {
            $_POST['job_id'] = $project;
        }

        if ($segment == '' or $segment == 1) {
            $transactions = $this->finance_model->get_invoices($this->logged_in_user->id, $date_begin, $date_end);
            $transactions_all = $this->finance_model->get_invoice_report($this->logged_in_user->id, $date_begin, $date_end, TRUE, '');
            $transactions_count = count($transactions_all);
            $this->outputData['total_amount'] = end($transactions_all)['amount'];
            $this->outputData['months'] = $this->finance_model->get_month_report($this->logged_in_user->id, $date_begin, $date_end);
            $view = 'finance/calendar';
        } elseif ($segment == 2) {
            $transactions = $this->finance_model->get_invoice_report($this->logged_in_user->id, $date_begin, $date_end, TRUE, $max);
            $transactions_all = $this->finance_model->get_invoice_report($this->logged_in_user->id, $date_begin, $date_end, TRUE, '');
            $transactions_count = count($transactions_all);
            $this->outputData['total_amount'] = end($transactions_all)['amount'];
            $view = 'finance/invoice';
        } elseif ($segment == 3) {
            $transactions = $this->finance_model->get_invoice_report($this->logged_in_user->id, $date_begin, $date_end, FALSE, $max);
            $transactions_all = $this->finance_model->get_invoice_report($this->logged_in_user->id, $date_begin, $date_end, FALSE, '');
            $transactions_count = count($transactions_all);
            $this->outputData['total_amount'] = end($transactions_all)['vat'];
            $view = 'finance/tax';
        } elseif ($segment == 4) {

            $transactions = $this->finance_model->get_user_transactions(0, $max, $order_by, FALSE, $project);
            $transactions_count = count($this->finance_model->get_user_transactions(0, '', '', FALSE, $project));
            $view = 'finance/deposit';
        } elseif ($segment == 5) {
            $transactions = $this->finance_model->get_user_transactions(3, $max, $order_by, FALSE, $project);
            $transactions_count = count($this->finance_model->get_user_transactions(3, '', '', FALSE, $project));
            $this->outputData['projects'] = $this->project_model->get_user_projects($this->logged_in_user->id, FALSE, [4, 5]);
            $view = 'finance/transfer';
        } elseif ($segment == 6) {
            $transactions = $this->finance_model->get_user_transactions(1, $max, $order_by, FALSE, $project);
            $transactions_count = count($this->finance_model->get_user_transactions(1, '', '', FALSE, $project));
            $this->load->model('user_bank_model');
            $this->load->model('user_bank_account_model');
            $this->load->model('user_paypal_model');
            $this->load->model('country_model');

            $this->outputData['bank'] = $this->user_bank_model->find_one_by_attributes(['user_id' => $this->logged_in_user->id]);
            if($this->outputData['bank'] !== NULL){
                $this->outputData['bank_account'] = $this->user_bank_account_model->find_one_by_attributes(['bank_id' => $this->outputData['bank']['id']]);
                $this->outputData['bank_country'] = $this->country_model->find_by_id($this->outputData['bank']['country_id']);
            } else {
                $this->outputData['bank_account'] = NULL;
                $this->outputData['bank_country'] = NULL;
            }

            $this->outputData['paypal'] = $this->user_paypal_model->find_one_by_attributes(['user_id' => $this->logged_in_user->id]);

            $view = 'finance/withdraw';
        } elseif ($segment == 7) {
            $transactions = $this->finance_model->get_user_transactions([4, 5, 6], $max, $order_by, FALSE, $project);
            $transactions_count = count($this->finance_model->get_user_transactions([4, 5, 6], '', '', FALSE, $project));
            $this->outputData['projects'] = $this->project_model->get_user_projects($this->logged_in_user->id, FALSE, [3, 4]);
            $view = 'finance/escrow';
            $this->escrow_account(true);
        } elseif ($segment == 8) {
            // Ajax only
            $this->escrow_account();
            return;
        } else {
            // Fallback
            return;
        }

        $this->outputData['view'] = $view;

        $this->outputData['transactions'] = $transactions;
        $this->outputData['pagination'] = get_pagination(site_url('finance/index/' . $segment), $transactions_count, $page_rows, $page);

        if ($transactions_count == 0) {
            $this->outputData['page_numbers'] = array();
        }

        $this->outputData['balance'] = $this->finance_model->get_user_balance();

        $this->outputData['payment_methods'] = $this->payment_model->getPaymentSettings(['id', 'DESC']);
        $this->outputData['milestones'] = [];
        $this->outputData['recievers'] = [];
        $this->outputData['payment_method_credentials'] = $this->payment_model->getPaymentCredentials(2);
        $this->outputData['segment'] = $segment;

        // Submit form
        if ($this->input->post('submit') != '') {

            if ($this->input->post('operation') == 'deposit' or $this->input->post('operation') == 'withdraw') {
                $this->form_validation->set_rules('payment_method', t('Payment Method'), 'required|callback_operation_enabled');
                $this->form_validation->set_rules('amount', t('Amount'), 'required|trim|integer|is_natural|abs|xss_clean|callback_enough_funds|callback_min_amount');

                if ($this->input->post('payment_method') == 2 && $this->input->post('operation') == 'withdraw') {
                    $this->form_validation->set_rules('recipient', t('Recipient'), 'required|trim|xss_clean');
                    $this->form_validation->set_rules('bank_account_number', t('Bank account number'), 'required|trim|xss_clean');
                    $this->form_validation->set_rules('bic_swift_code_aba', t('BIC/Swift-Code/ABA'), 'required|trim|xss_clean');
                    $this->form_validation->set_rules('credit_institution', t('Credit institution'), 'required|trim|xss_clean');
                    $this->form_validation->set_rules('target_country', t('Target country'), 'required|trim|xss_clean');
                }


                if ($this->input->post('payment_method') == 2 && $this->input->post('operation') == 'deposit') {
                    $this->form_validation->set_rules('user_transaction_id', t('Bank Transaction-ID'), 'required|trim|xss_clean');
                    $this->form_validation->set_rules('user_description', t('Purpose of payment'), 'required|trim|xss_clean');
                }

            } elseif ($this->input->post('operation') == 'transfer' or $this->input->post('operation') == 'escrow') {
                $this->form_validation->set_rules('job_id', 'lang:Project', 'required');
                $this->form_validation->set_rules('amount', t('Amount'), 'required|trim|integer|is_natural|abs|xss_clean|callback_enough_funds');
            }

            if ($this->input->post('operation') == 'withdraw' and $this->input->post('payment_method') == 1) {
                $this->form_validation->set_rules('paypal_email', t('PayPal Email address'), 'required|trim|valid_email|xss_clean');
            }


            if ($this->form_validation->run()) {

                $customDataArr = [
                    'recipient' => $this->input->post('recipient'),
                    'bank_account_number' => $this->input->post('bank_account_number'),
                    'bic_swift_code_aba' => $this->input->post('bic_swift_code_aba'),
                    'credit_institution' => $this->input->post('credit_institution'),
                    'target_country' => $this->input->post('target_country'),

                    'user_transaction_id' => $this->input->post('user_transaction_id'),
                    'user_description' => $this->input->post('user_description'),
                ];
                try {
                    if ($this->input->post('operation') == 'deposit') {
                        if ($this->input->post('payment_method') == 1) {
                            $this->paypal_submit($this->input->post('amount'), t('Deposit'), site_url('finance/deposit'));
                            return;
                        } // Not PayPal - processed by admin
                        else {
                            $this->finance_model->deposit($this->input->post('amount'), $this->input->post('payment_method'), '', '', '', $customDataArr);
                        }
                    } elseif ($this->input->post('operation') == 'withdraw') {
                        if ($this->input->post('payment_method') == 1) {
                            $this->paypal_withdraw($this->input->post('amount'), $this->input->post('paypal_email'));
                        } // Not PayPal - processed by admin
                        else {
                            $this->finance_model->withdraw($this->input->post('amount'), $this->input->post('payment_method'), '', $customDataArr);
                        }
                    } elseif ($this->input->post('operation') == 'transfer') {
                        $id = $this->finance_model->transfer($this->input->post('job_id'), $this->input->post('milestone_id'), $this->input->post('reciever_id'), $this->input->post('amount'));
                        $this->finance_model->finalize_transaction($id);
                    } elseif ($this->input->post('operation') == 'escrow') {
                        // Escrow is always processed by admin
                        $this->finance_model->escrow_request($this->input->post('job_id'), $this->input->post('milestone_id'), $this->input->post('amount'));
                    }
                    $this->notify->set(t('Success'), Notify::SUCCESS);
                    redirect(site_url('finance/index/' . $segment));
                } catch (Exception $e) {
                    $this->notify->set($e->getMessage(), Notify::ERROR);
                }
            }
        }

        if ($this->input->is_ajax_request()) {
            if ($this->input->post('table_only') == 'true') {
                echo response([
                    'type' => 'table',
                    'data' => $this->load->view($view . '_table', $this->outputData, TRUE),
                    'pagination' => $this->outputData['pagination']
                ]);
            } else {
                echo response([
                    'type' => 'all',
                    'data' => $this->load->view($view, $this->outputData, TRUE)
                ]);
            }
        } else {
            $this->load->view('finance/index', $this->outputData);
        }
    }

    /**
     * Additional table for index
     */
    function escrow_account($from_index = false)
    {
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
        $order_by = [$field, $order];

        $transactions = $this->finance_model->get_escrow_account($max, $order_by);
        $transactions_count = count($this->finance_model->get_escrow_account('', ''));

        $this->outputData['transactions_account'] = $transactions;
        $this->outputData['pagination_account'] = get_pagination(site_url('finance/escrow_account/'), $transactions_count, $page_rows, $page);

        if ($transactions_count == 0) {
            $this->outputData['page_numbers_account'] = array();
        }

        if ($this->input->is_ajax_request() and !$from_index) {
            echo response([
                'type' => 'table',
                'data' => $this->load->view('finance/escrow_account_table', $this->outputData, TRUE),
                'pagination' => $this->outputData['pagination_account']
            ]);
        }
    }

    /**
     * @param $userId
     * @return bool
     */
    function send_reminder($userId, $project)
    {
        $this->load->model('notification_model');
        $this->load->model('email_model');
        $this->load->model('messages_model');
        $this->load->model('email_template_model');

        $full_name = $this->user_model->get_name($userId);
        $data['is_send'] = FALSE;
        $data['message'] = '';
        try
        {
            // send notification
            $notification_url = site_url() . '/messages/index';
            $this->notification_model->add(INVOICE_REMINDER, $userId, $notification_url);

            // send message - from
            $email_template = $this->email_template_model->find_one_by_attributes(['type' => INVOICE_REMINDER]);
            $from = $this->outputData['logged_in_user']->id;
            $link = '<a target="_blank" href="'.site_url() . '/finance/invoice_print/'.$project. '">#' . $project . '</a>';
            $parameters = ['!link' => $link];

            $email_template = $this->email_template_model->prepare_message($parameters, $email_template);
            $this->messages_model->send_message($from, $userId, $project, $email_template['mail_subject'], $email_template['mail_body']);

            // send email
            $this->email_model->prepare(INVOICE_REMINDER, $userId, $parameters, TRUE);

            $data['is_send'] = TRUE;
            $data['message'] = 'Email and notification has been successfully sent to ' . $full_name;
        }
        catch (Exception $e)
        {
            $data['message'] = $e->getMessage();
        }

        $this->output->set_content_type('application/json');

        echo json_encode($data);
        return;
    }

    /**
     * Send PayPal payment
     *
     * @param $amount
     * @param $operation
     * @param $back_url
     */
    function paypal_submit($amount, $operation, $back_url)
    {
        $paypal = $this->payment_model->getPayment('paypal');
        if ($paypal == NULL) {
            return;
        }

        $data = [
            'paypal_url' => PAYPAL_URL,
            'paypal_mail' => $paypal['credentials']['mail']['value'],
            'operation' => $operation,
            'currency' => $this->config->item('currency_type'),
            'back_url' => $back_url,
            'amount' => $amount
        ];

        $this->load->view('finance/paypal_submit', $data);
    }

    /**
     * Withdraw amount via PayPal
     *
     * @param $amount
     * @param $email
     */
    function paypal_withdraw($amount, $email)
    {
        $this->load->library('paypal');

        // Create transaction
        $transaction_id = $this->finance_model->withdraw($amount, 1);

        // Create payment
        try {
            $key = $this->paypal->send($amount, $email);
        } catch (Exception $e) {
            $this->finance_model->cancel_transaction($transaction_id, $email . ': ' . $e->getMessage());
            $this->notify->set($e->getMessage(), Notify::ERROR);
            return;
        }

        $this->finance_model->finalize_transaction($transaction_id, $email, $key);
        $this->notify->set('Your transaction has been completed, and a receipt for your purchase has been emailed to you. You may log into your account at www.paypal.com to view details of this transaction.');
    }

    /**
     * Revenue calendar for provider
     */
    function revenue()
    {
        $this->index(1);
    }

    /**
     * Invoices list
     */
    function invoice()
    {
        $this->index(2);
    }

    /**
     * Tax manager
     */
    function tax()
    {
        $this->index(3);
    }

    /**
     * Deposit funds
     */
    function deposit()
    {
        $this->index(4);
    }

    /**
     * Transfer funds
     */
    function transfer()
    {
        $this->index(5);
    }

    /**
     * Withdraw funds
     */
    function withdraw()
    {
        $this->index(6);
    }

    /**
     * Escrow funds
     */
    function escrow()
    {
        $this->index(7);
    }

    /**
     * Check if operation is enabled for specified payment method
     *
     * @param $field
     * @return bool
     */
    function operation_enabled($field)
    {
        $payment = $this->payment_model->getPayment($field);
        if (!isset($payment)) {
            $this->form_validation->set_message('operation_enabled', t('Incorrect payment method.'));
            return FALSE;
        }

        $this->form_validation->set_message('operation_enabled', ucfirst($this->input->post('operation')) . ' by ' . ucfirst($payment['title'] . ' is not allowed.'));
        if ($this->input->post('operation') == 'deposit') {
            return ($payment['is_deposit_enabled'] == 1);
        } elseif ($this->input->post('operation') == 'withdraw') {
            return ($payment['is_withdraw_enabled'] == 1);
        } else {
            return TRUE;
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
        $this->form_validation->set_message('enough_funds', t('Insufficient funds.'));
        if ($this->input->post('operation') == 'deposit') {
            return TRUE;
        } elseif ($this->input->post('operation') == 'escrow') {
            return ($this->finance_model->get_user_balance() >= ($field + $this->finance_model->get_fee($field, Finance_model::FEE_ESCROW)));
        } else {
            return ($this->finance_model->get_user_balance() >= $field);
        }
    }

    /**
     * Check if amount is more then minimum
     *
     * @param $field
     * @return bool
     */
    function min_amount($field)
    {
        $payment = $this->payment_model->getPayment($this->input->post('payment_method'));
        if (!isset($payment)) {
            $this->form_validation->set_message('min_amount', t('Incorrect payment method.'));
            return FALSE;
        }

        if ($this->input->post('operation') == 'deposit') {
            $min = $payment['deposit_minimum'];
        } elseif ($this->input->post('operation') == 'withdraw') {
            $min = $payment['withdraw_minimum'];
        } else {
            return TRUE;
        }
        $this->form_validation->set_message('min_amount', 'Minimum amount of ' . $this->input->post('operation') . ' by ' . ucfirst($payment['title'] . ' is ' . currency() . number_format($min)));
        return ($field >= $min);
    }

    /**
     * Project info for transfer/escrow
     */
    function get_project_info()
    {
        if ($this->input->is_ajax_request()) {
            $this->load->model('project_model');
            $this->load->model('quote_model');

            $id = $this->input->post('project');

            $due = 0;
            $project = $this->project_model->get_project_by_id($id);
            if (isset($project)) {
                // Active project
                if ($project['job_status'] == 4 || $project['job_status'] == 5) {
                    $this->outputData['milestones'] = $this->project_model->get_project_milestones($id);
                    if (isEntrepreneur()) {
                        $this->outputData['recievers'] = $this->user_model->getUsers(['users.id' => $project['employee_id']], "users.id, CONCAT(users.first_name, ' ', users.last_name) AS name")->result_array();
                    } elseif (isProvider()) {
                        $this->outputData['recievers'] = $this->user_model->getUsers(['users.id' => $project['creator_id']], "users.id, CONCAT(users.first_name, ' ', users.last_name) AS name")->result_array();
                    } else {
                        $this->outputData['recievers'] = [];
                    }
                    $due = $this->finance_model->get_project_payment_due($id)['due'];
                } // Won quote
                elseif ($project['job_status'] == 3) {
                    $quote = $this->quote_model->get_won_quote($id);
                    if (isset($quote)) {
                        $this->outputData['milestones'] = $this->quote_model->get_quote_milestones($id, $quote['id'], $this->logged_in_user->id);
                        $this->outputData['recievers'] = $this->user_model->getUsers(['users.id' => $quote['provider_id']], "users.id, CONCAT(users.first_name, ' ', users.last_name) AS name")->result_array();
                        $due = $this->finance_model->get_quote_escrow_due($id, $quote['id']) - $this->finance_model->get_project_payment_escrow($id);
                    }
                }
            }

            $milestones = $this->load->view('finance/milestones', $this->outputData, TRUE);
            $recievers = $this->load->view('finance/recievers', $this->outputData, TRUE);
            echo response([
                'milestones' => $milestones,
                'recievers' => $recievers,
                'due' => currency() . number_format($due)
            ]);
        }
    }

    /**
     * Milestone info for transfer/escrow
     */
    function get_milestone_info()
    {
        if ($this->input->is_ajax_request()) {
            $this->load->model('project_model');
            $due = $this->finance_model->get_project_payment($this->input->post('project'), $this->input->post('milestone'));
            echo response([
                'due' => currency() . number_format($due['due'])
            ]);
        }
    }

    /**
     * Get escrow fee for selected amount
     */
    function get_escrow_total()
    {
        if ($this->input->is_ajax_request()) {
            $amount = $this->input->post('amount');
            $total = $amount + $this->finance_model->get_fee($amount, Finance_model::FEE_ESCROW);
            if ($total > 0) {
                echo response(['data' => currency() . number_format($total)]);
            } else {
                echo response(['data' => '']);
            }
        }
    }

    /**
     * Auto return from PayPal
     */
    function paypal_return()
    {
        if ($this->input->get('tx') != NULL and $this->input->get('tx') != '') {
            // Verify transaction
            $response = $this->validate_paypal_transaction($this->input->get('tx'));

            $payment_methods = $this->payment_model->getPaymentSettings();
            foreach ($payment_methods as $payment_method) {
                if ($payment_method['title'] == 'paypal') {
                    $paypal_address = $payment_method['credentials']['mail']['value'];
                }
            }

            if ($response['receiver_email'] != $paypal_address) {

                /*Flash*/
                $success_msg = t('Error processing transaction.');
                $this->notify->set($success_msg, Notify::ERROR);
                /*End Flash*/
                redirect(base_url('information'));
            }

            // Write transaction into database
            try {
                $id = $this->finance_model->deposit($response['payment_gross'], 1, $response['txn_id'], $response['first_name'] . ' ' . $response['last_name']);
                $this->finance_model->finalize_transaction($id);
            } catch (Exception $e) {
                $this->notify->set($e->getMessage(), Notify::ERROR);
                redirect(base_url('information'));
            }

            /*Flash*/
            $success_msg = t('Thank you for your payment. Your transaction has been completed, and a receipt for your purchase has been emailed to you. You may log into your account at www.paypal.com to view details of this transaction.');
            $this->notify->set($success_msg, Notify::SUCCESS);
            /*End Flash*/
            redirect(base_url('information'));
        } else {
            /*Flash*/
            $success_msg = t('Error processing transaction.');
            $this->notify->set($success_msg, Notify::ERROR);
            /*End Flash*/
            redirect(base_url('information'));
        }
    }

    /**
     * Validate PayPal transaction returned by PDT
     *
     * @param $tx
     * @return array|mixed|string
     */
    function validate_paypal_transaction($tx)
    {
        // Init cURL
        $request = curl_init();

        // Set request options
        curl_setopt_array($request, [
            CURLOPT_URL => 'https://www.sandbox.paypal.com/cgi-bin/webscr',
            CURLOPT_POST => TRUE,
            CURLOPT_POSTFIELDS => http_build_query([
                'cmd' => '_notify-synch',
                'tx' => $tx,
                'at' => '574UPwYDNxp9JJAlhfQtxrsy12ZlI0CswAdNjIVbcoL1VWhVTqzAFvqnQmi', // Token for account identification
            ]),
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_HEADER => FALSE,
            // CURLOPT_SSL_VERIFYPEER => TRUE,
            // CURLOPT_CAINFO => 'cacert.pem',
        ]);

        // Execute request and get response and status code
        $response = curl_exec($request);
        $status = curl_getinfo($request, CURLINFO_HTTP_CODE);

        // Close connection
        curl_close($request);

        if ($status != 200 OR strpos($response, 'SUCCESS') !== 0) {
            return NULL;
        }

        // Remove SUCCESS part (7 characters long)
        $response = substr($response, 7);

        // URL decode
        $response = urldecode($response);

        // Turn into associative array
        preg_match_all('/^([^=\s]++)=(.*+)/m', $response, $m, PREG_PATTERN_ORDER);
        $response = array_combine($m[1], $m[2]);

        // Fix character encoding if different from UTF-8 (in my case)
        if (isset($response['charset']) AND strtoupper($response['charset']) !== 'UTF-8') {
            foreach ($response as $key => &$value) {
                $value = mb_convert_encoding($value, 'UTF-8', $response['charset']);
            }
            $response['charset_original'] = $response['charset'];
            $response['charset'] = 'UTF-8';
        }

        // Sort on keys for readability (handy when debugging)
        ksort($response);

        return $response;
    }

    /**
     * All invoices in PDF
     */
    function invoice_all_pdf()
    {
        $date_begin = $this->input->get('date_begin');
        $date_end = $this->input->get('date_end');
        $invoices = $this->finance_model->get_invoices($this->logged_in_user->id, $date_begin, $date_end);

        if (count($invoices) > 0) {

            $invoice_filename = 'files/tmp/invoices.zip';

            $za = new ZipArchive;
            $za->open($invoice_filename,ZipArchive::CREATE|ZipArchive::OVERWRITE);

            foreach ($invoices as $invoice) {

                $pdf_filename = $this->invoice_pdf($invoice['job_id'], true);

                $za->addFile($pdf_filename);
            }

            $za->close();

            $file_name = basename($invoice_filename);

            header("Content-Type: application/zip");
            header("Content-Disposition: attachment; filename=$file_name");
            header("Content-Length: " . filesize($invoice_filename));

            readfile($invoice_filename);
        }
    }



    /**
     * Invoice in PDF
     *
     * @param $project
     */
    function invoice_pdf($project = '', $save_to_file = false, $open_in_browser = false)
    {
        try {
            if ($project == '') {
                $project = $this->input->get('project');
                $milestone = $this->input->get('milestone');
            } else {
                $milestone = '';
            }

            $invoice = $this->finance_model->get_invoice($project, $milestone);
            if (count($invoice) == 0 or ($invoice[0]['sender_id'] != $this->logged_in_user->id and $invoice[0]['reciever_id'] != $this->logged_in_user->id)) {

                /*Flash*/
                $success_msg = t('Invoice is unavailable');
                $this->notify->set($success_msg, Notify::ERROR);
                /*End Flash*/
                redirect_back();
            }
            $this->outputData['invoice'] = $invoice;
            $this->outputData['billing_from'] = $this->user_model->getUsers(['users.id' => $invoice[0]['sender_id']])->row()->name;
            $this->outputData['billing_to'] = $this->user_model->getUsers(['users.id' => $invoice[0]['reciever_id']])->row()->name;
            $this->outputData['logo'] = FCPATH. 'application/css/images/images/logo.png';

            $view = $this->load->view('finance/invoice_pdf', NULL, TRUE);

            // Generate PDF
            $dompdf = new Dompdf();
            $dompdf->loadHtml($view);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            if ($save_to_file) {
                $filename = 'files/tmp/invoice' . $invoice[0]['id'] . '.pdf';
                $output = $dompdf->output();
                file_put_contents($filename, $output);
                return $filename;
            }
            elseif ($open_in_browser) {
                    $filename = 'files/tmp/invoice'.$invoice[0]['id'].'.pdf';
                    $output = $dompdf->output();
                    file_put_contents($filename, $output);
                    $dompdf->stream($filename, array("Attachment" => false));
            }
            else {
                $dompdf->stream();
            }

        } catch (Exception $e) {
            $this->notify->set($e->getMessage(), Notify::ERROR);
            redirect_back();
        }

        return null;
    }

    /**
     * Invoice report in CSV
     */
    function invoice_print($job_id)
    {
        $this->invoice_pdf($job_id, false, true);
    }

    /**
     * Tax report in CSV
     */
    function tax_csv()
    {
        $date_begin = $this->input->get('date_begin');
        $date_end = $this->input->get('date_end');
        $this->outputData['transactions'] = $this->finance_model->get_invoice_report($this->logged_in_user->id, $date_begin, $date_end, FALSE, '');
        $this->load->view('finance/tax_csv');
    }

    public function exportInvoiceToExcelAction()
    {

        $xls = new PHPExcel();

        $users = $this->user_model->getUsers(array('users.id' => $this->logged_in_user->id));

        $xls->getProperties()
            ->setCreator($users->row()->user_name)
            ->setLastModifiedBy($users->row()->user_name)
            ->setTitle("Invoice")
            ->setSubject("Invoice")
            ->setDescription("Invoice")
            ->setKeywords("Invoice")
            ->setCategory("Invoice");

        $xls->getActiveSheet()->setTitle('Invoice');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $xls->setActiveSheetIndex(0);

        $date_begin = $this->input->get('date_begin');
        $date_end = $this->input->get('date_end');

        $invoices = $this->finance_model->get_invoice_report($this->logged_in_user->id, $date_begin, $date_end, TRUE, '');

        $ext = "xlsx";

        $random = random_string('numeric');
        $fileName = "invoice" . $random . "." . $ext;

        $i = 1;
        $str_list = null;
        $header = array();
        foreach ($invoices as $fields) {
            // header
            if ($i == 1) {

                $xls->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, t('Status'))
                    ->setCellValue('B' . $i, t('Client'))
                    ->setCellValue('C' . $i, t('Project Name'))
                    ->setCellValue('D' . $i, t('Fiscal Year Report'))
                    ->setCellValue('E' . $i, t('Payment Overview'))
                    ->setCellValue('F' . $i, t('Vat'))
                    ->setCellValue('G' . $i, t('Payments Due Date'));

                $xls->getActiveSheet()->getStyle('A1:G1')->getFill()->setFillType(
                    PHPExcel_Style_Fill::FILL_NONE);

                $xls->getActiveSheet()->getStyle('A1:G1')->getAlignment()->setHorizontal(
                    PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }

            if ($fields['job_id'] != '') {
                $xls->setActiveSheetIndex(0)
                    ->setCellValue('A' . ($i + 1), $fields['payment_status']['status'])
                    ->setCellValue('B' . ($i + 1), $fields['client_name'])
                    ->setCellValue('C' . ($i + 1), $fields['job_name'])
                    ->setCellValue('D' . ($i + 1), $fields['fiscal_year'])
                    ->setCellValue('E' . ($i + 1), currency() . number_format($fields['amount']))
                    ->setCellValue('F' . ($i + 1), currency() . number_format($fields['vat']))
                    ->setCellValue('G' . ($i + 1), date('Y/m/d', $fields['due_date']));
            } elseif ($fields['fiscal_year'] != '') {

                $xls->setActiveSheetIndex(0)
                    ->setCellValue('A' . ($i + 1), t('Total amount for') . ' ' . $fields['fiscal_year'])
                    ->setCellValue('E' . ($i + 1), currency() . number_format($fields['amount']));

                $xls->getActiveSheet()->getStyle('A' . ($i + 1) . ':' . 'E' . ($i + 1))->getFont()->setBold(true);
            } else {

                $xls->setActiveSheetIndex(0)
                    ->setCellValue('A' . ($i + 1), t('Total'))
                    ->setCellValue('E' . ($i + 1), currency() . number_format($fields['amount']));

                $xls->getActiveSheet()->getStyle('A' . ($i + 1) . ':' . 'E' . ($i + 1))->getFont()->setBold(true);
            }

            $i++;
        }

//        $num_rows = $xls->getActiveSheet()->getHighestRow();
//        $xls->setActiveSheetIndex(0)->insertNewRowBefore($num_rows-1, 1);

        foreach (range('A', 'G') as $columnID) {
            $xls->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
        }

        $path = 'files/';

        $objWriter = PHPExcel_IOFactory::createWriter($xls, 'Excel2007');
        $objWriter->save($path . $fileName);

        $file_content = file_get_contents($path . $fileName); // Read the file's contents
        if (file_exists($path . $fileName)) {
            unlink($path . $fileName);
        }

        $this->load->helper('download');
        force_download($fileName, $file_content, true);
    }

    public function exportTaxToExcelAction()
    {

        $xls = new PHPExcel();

        $users = $this->user_model->getUsers(array('users.id' => $this->logged_in_user->id));

        $xls->getProperties()
            ->setCreator($users->row()->user_name)
            ->setLastModifiedBy($users->row()->user_name)
            ->setTitle("Invoice")
            ->setSubject("Invoice")
            ->setDescription("Invoice")
            ->setKeywords("Invoice")
            ->setCategory("Invoice");

        $xls->getActiveSheet()->setTitle('Invoice');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $xls->setActiveSheetIndex(0);

        $date_begin = $this->input->get('date_begin');
        $date_end = $this->input->get('date_end');

        $taxes = $this->finance_model->get_invoice_report($this->logged_in_user->id, $date_begin, $date_end, FALSE, '');

        $ext = "xlsx";

        $random = random_string('numeric');
        $fileName = "tax" . $random . "." . $ext;

        $i = 1;
        $str_list = null;
        $header = array();
        foreach ($taxes as $fields) {
            // header
            if ($i == 1) {

                $xls->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, t('Status'))
                    ->setCellValue('B' . $i, t('Client'))
                    ->setCellValue('C' . $i, t('Project Name'))
                    ->setCellValue('D' . $i, t('Country'))
                    ->setCellValue('E' . $i, t('Fiscal Year Report'))
                    ->setCellValue('F' . $i, t('Payment Overview'))
                    ->setCellValue('G' . $i, t('Vat'))
                    ->setCellValue('H' . $i, t('Payments Due Date'));

                $xls->getActiveSheet()->getStyle('A1:H1')->getFill()->setFillType(
                    PHPExcel_Style_Fill::FILL_NONE);

                $xls->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal(
                    PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }

            if ($fields['job_id'] != '') {
                $xls->setActiveSheetIndex(0)
                    ->setCellValue('A' . ($i + 1), $fields['payment_status']['status'])
                    ->setCellValue('B' . ($i + 1), $fields['client_name'])
                    ->setCellValue('C' . ($i + 1), $fields['job_name'])
                    ->setCellValue('D' . ($i + 1), $fields['country_name'])
                    ->setCellValue('E' . ($i + 1), $fields['fiscal_year'])
                    ->setCellValue('F' . ($i + 1), currency() . number_format($fields['amount']))
                    ->setCellValue('G' . ($i + 1), currency() . number_format($fields['vat']))
                    ->setCellValue('H' . ($i + 1), date('Y/m/d', $fields['due_date']));
            } elseif ($fields['country'] != '') {

                $xls->setActiveSheetIndex(0)
                    ->setCellValue('A' . ($i + 1), t('Total VAT for') . ' ' . $fields['country_name'])
                    ->setCellValue('G' . ($i + 1), currency() . number_format($fields['vat']));

                $xls->getActiveSheet()->getStyle('A' . ($i + 1) . ':' . 'G' . ($i + 1))->getFont()->setBold(true);
            } elseif ($fields['fiscal_year'] != '') {

                $xls->setActiveSheetIndex(0)
                    ->setCellValue('A' . ($i + 1), t('Total VAT for') . ' ' . $fields['fiscal_year'])
                    ->setCellValue('G' . ($i + 1), currency() . number_format($fields['vat']));

                $xls->getActiveSheet()->getStyle('A' . ($i + 1) . ':' . 'G' . ($i + 1))->getFont()->setBold(true);
            } else {

                $xls->setActiveSheetIndex(0)
                    ->setCellValue('A' . ($i + 1), t('Total'))
                    ->setCellValue('G' . ($i + 1), currency() . number_format($fields['vat']));

                $xls->getActiveSheet()->getStyle('A' . ($i + 1) . ':' . 'G' . ($i + 1))->getFont()->setBold(true);
            }
            $i++;
        }

//        $num_rows = $xls->getActiveSheet()->getHighestRow();
//        $xls->setActiveSheetIndex(0)->insertNewRowBefore($num_rows-1, 1);

        foreach (range('A', 'H') as $columnID) {
            $xls->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
        }

        $path = 'files/';
        $objWriter = PHPExcel_IOFactory::createWriter($xls, 'Excel2007');
        $objWriter->save($path . $fileName);

        $file_content = file_get_contents($path . $fileName); // Read the file's contents
        if (file_exists($path . $fileName)) {
            unlink($path . $fileName);
        }

        $this->load->helper('download');
        force_download($fileName, $file_content, true);
    }
}