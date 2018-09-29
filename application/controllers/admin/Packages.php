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

class Packages extends MY_Controller
{
    function __construct()
    {
        parent::__construct();

        // loading the lang files
        load_lang(['admin/common', 'admin/setting', 'admin/validation', 'admin/login']);

        //Load Models Common to all the functions in this controller
        $this->load->model('common_model');
        $this->load->model('package_model');
        $this->load->model('user_model');
        $this->outputData['login'] = 'TRUE';

        //Get Logged In user
        $this->logged_in_user = $this->common_model->get_logged_in_user();
        $this->outputData['logged_in_user'] = $this->logged_in_user;
    }

    function viewPackages()
    {
        // Loading CSS/JS
        $this->add_js('application/js/pagination.js');

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

        $packages = $this->package_model->getPackages(FALSE, $max, $order_by);
        $packages_total = count($this->package_model->getPackages(FALSE));

        $this->outputData['packages'] = $packages;
        $this->outputData['pagination'] = get_pagination(admin_url('packages/viewPackages/'), $packages_total, $page_rows, $page);

        if ($this->input->is_ajax_request()) {
            echo response([
                'type' => 'table',
                'data' => $this->load->view('admin/package/viewpackage_table', $this->outputData, TRUE),
                'pagination' => $this->outputData['pagination']
            ]);
        } else {
            $this->load->view('admin/package/viewpackage', $this->outputData);
        }
    }

    function addPackages()
    {
        redirect_admin('packages/editPackage');
    }

    function deletePackage()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->get('id');
            try {
                $this->package_model->deletePackage($id);
                echo response(NULL);
            } catch (Exception $e) {
                echo response($e->getMessage(), TRUE);
            }
        }
    }

    function editPackage()
    {
        $this->add_js([
            'application/js/jquery.inputmask.bundle.min.js',
            'application/js/custom-inputmask.js'
        ]);

        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        // Save
        if ($this->input->post('submit') != '') {
            // Set rules
            $this->form_validation->set_rules('package_name', t('Package Name'), 'required|trim|xss_clean');
            $this->form_validation->set_rules('description', t('Description'), 'trim|xss_clean');
            $this->form_validation->set_rules('amount', t('Amount'), 'required|trim|integer|is_natural|abs|xss_clean');

            if ($this->form_validation->run()) {
                $data = [
                    'id' => $this->input->post('id'),
                    'package_name' => $this->input->post('package_name'),
                    'description' => $this->input->post('description'),
                    'isactive' => ($this->input->post('isactive') == 1) ? 1 : 0,
                    'credits' => $this->input->post('credits'),
                    'total_days' => $this->input->post('total_days'),
                    'amount' => $this->input->post('amount')
                ];

                $this->package_model->savePackage($data);

                redirect_admin('packages/viewPackages');
            }
        } // Cancel
        elseif ($this->input->post('cancel') != '') {
            redirect_admin('packages/viewPackages');
        } // Default
        else {
            $package_id = $this->input->get('id');
            if ($package_id != '') {
                $package = $this->package_model->getPackage($package_id);
                if (isset($package)) {
                    $this->outputData['package'] = $package;
                } else {
                    $this->notify->set(t('Package does not exist'), Notify::ERROR);
                    redirect_back();
                }
            }
        }

        $this->load->view('admin/package/editpackage', $this->outputData);
    }

    function viewSubscriptionUser()
    {
        try {
            $this->load->library('form_validation');
            $this->load->helper('form');
            $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

            // Loading JS
            $this->add_js([
                'application/plugins/select2/js/select2.full.js',
                'application/js/pagination.js',
                'application/js/admin/packages.js'
            ]);

            $this->add_css([
                'application/plugins/select2/css/select2.css',
            ]);

            $this->init_js(["packages.init('" . admin_url() . "');"]);

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

            // Edit user
            $user_id = $this->input->get('id');
            if ($user_id != '') {
                $user = $this->package_model->getSubscriptionUser($user_id);
                if (!isset($user['id'])) {
                    $this->notify->set(t('Subscription user does not exist'), Notify::ERROR);
                } else {
                    $this->outputData['user'] = $user;
                }
            }

            // Search parameters
            $user_name = $this->input->post('name');
            $email = $this->input->post('email');
            $package = $this->input->post('package_id');

            // Post form
            if ($this->input->post('submit') != '') {
                // Set rules
                if ($this->input->post('id') == '') {
                    $this->form_validation->set_rules('user_id', t('User Name'), 'required|trim|xss_clean');
                    $this->form_validation->set_rules('package_id', t('Package'), 'required');
                }
                $this->form_validation->set_rules('valid', t('Valid'), 'required|trim|xss_clean');
                $this->form_validation->set_rules('amount', t('Amount'), 'trim|xss_clean');

                if ($this->form_validation->run()) {
                    if ($this->input->post('id') == '') {
                        $data = [
                            'id' => NULL,
                            'user_id' => $this->input->post('user_id'),
                            'package_id' => $this->input->post('package_id'),
                            'valid' => $this->input->post('valid'),
                            'amount' => $this->input->post('amount'),
                            'balance_credits' => 0,
                            'flag' => 1
                        ];

                        $success_msg = t('User added successfully');

                    } else {
                        $data = [
                            'id' => $this->input->post('id'),
                            'valid' => $this->input->post('valid'),
                            'amount' => $this->input->post('amount'),
                            'balance_credits' => 0,
                            'flag' => 1
                        ];

                        $success_msg = t('User edited successfully');
                    }

                    $this->package_model->saveSubscriptionUser($data);
                    $this->form_validation->reset_validation();

                    $this->notify->set($success_msg, Notify::SUCCESS);
                }
            }

            $users = $this->package_model->getSubscriptionUsers($user_name, $email, $package, $max, $order_by);
            $users_total = count($this->package_model->getSubscriptionUsers($user_name, $email, $package, '', ''));

            $this->outputData['packages'] = $this->package_model->getPackages();
            $this->outputData['users'] = $users;

            $this->outputData['all_users'] = $this->user_model->getUsers(
                array(),
                'users.id, ifnull(users.user_name,concat(users.first_name," ",users.last_name)) as user_name',
                array('roles.role_name'=>array(ROLE_PROVIDER, ROLE_ENTREPRENEUR))
            )->result_array();

            $this->outputData['pagination'] = get_pagination(admin_url('packages/viewSubscriptionUser/'), $users_total, $page_rows, $page);

            if ($this->input->is_ajax_request()) {
                echo response([
                    'type' => 'table',
                    'data' => $this->load->view('admin/package/viewsubscriptionuser_table', $this->outputData, TRUE),
                    'pagination' => $this->outputData['pagination']
                ]);
            } else {
                $this->load->view('admin/package/viewsubscriptionuser', $this->outputData);
            }
        } catch (Exception $e) {
            if ($this->input->is_ajax_request()) {
                echo response($e->getMessage(), TRUE);
            } else {
                $this->notify->set($e->getMessage(), Notify::ERROR);
                redirect('information');
            }
        }
    }

    function deleteSubscriptionUser()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->get('id');
            try {
                $this->package_model->deleteSubscriptionUser($id);
                echo response(NULL);
            } catch (Exception $e) {
                echo response($e->getMessage(), TRUE);
            }
        }
    }

    function viewSubscriptionPayment()
    {
        // Loading CSS/JS
        $this->add_js('application/js/pagination.js');

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

        // Search parameters
        $user_name = $this->input->post('name');
        $email = $this->input->post('email');
        $package = $this->input->post('package_id');

        $payments = $this->package_model->getSubscriptionPayments($user_name, $email, $package, $max, $order_by);
        $payments_total = count($this->package_model->getSubscriptionPayments($user_name, $email, $package, '', ''));

        $this->outputData['packages'] = $this->package_model->getPackages();
        $this->outputData['payments'] = $payments;
        $this->outputData['pagination'] = get_pagination(admin_url('packages/viewSubscriptionUser/'), $payments_total, $page_rows, $page);

        if ($this->input->is_ajax_request()) {
            echo response([
                'type' => 'table',
                'data' => $this->load->view('admin/package/viewsubscriptionpayment_table', $this->outputData, TRUE),
                'pagination' => $this->outputData['pagination']
            ]);
        } else {
            $this->load->view('admin/package/viewsubscriptionpayment', $this->outputData);
        }
    }
}