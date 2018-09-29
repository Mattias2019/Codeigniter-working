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

class Account extends MY_Controller
{

    private $user_id;

    // Constructor
    function __construct()
    {
        parent::__construct();

        //Manage site Status
        if ($this->config->item('site_status') == 1) redirect('offline');

        //Load Models Common
        $this->load->model('skills_model');
        $this->load->model('messages_model');
        $this->load->model('file_model');
        $this->load->model('user_model');
        $this->load->model('machinery_model');
        $this->load->model('ban_model');

        //language file
        load_lang('enduser/account');

        $this->load->helper('file');
        $this->load->helper('captcha');
    }

    function set_notified($id)
    {
        if ($this->input->is_ajax_request())
        {
            $this->load->model('notification_model');
            $this->notification_model->set_notified($id);
        }
    }

    /**
     * Signup page
     */
    function signup()
    {
        load_lang(['enduser/employee', 'enduser/owners']);

        $this->add_css([
            'application/css/css/login.css'
        ]);

        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        if ($this->logged_in_user) {
            $this->logout();
        }

        $this->outputData['type'] = $this->input->get('type');

        // Get Form Data
        if ($this->input->post('submit') != '') {
            $this->ban_model->findEmailBan($this->input->post('email'));

            // Set rules
            //$this->form_validation->set_rules('email', 'lang:Email', 'required|trim|valid_email|xss_clean|is_unique[users.email]');
            $this->form_validation->set_rules('email', 'lang:Email', 'required|trim|valid_email|xss_clean');

            if ($this->form_validation->run()) {

                $checkBan = $this->ban_model->findEmailBan($this->input->post('email'));
                if (empty($checkBan)) {
                    $error_msg = t('Your email is in the banned list');
                    $this->notify->set($error_msg, Notify::ERROR);
                    redirect('account/signup');
                }

                $user = $this->user_model->getUsers(['users.email' => $this->input->post('email')])->row();

                if(isset($user)) {
                    // user exist
                    if ($user->user_status == 0) {

                        $updateData['activation_key'] = md5(time());

                        $updateKey = array('users.id' => $user->id);

                        //update activation key
                        $this->user_model->updateUser($updateKey, $updateData);

                        // Send mail
                        $this->load->model('email_model');

                        $activation_url = '<a href="'.site_url('account/confirm/' . $updateData['activation_key']).'">Click here to continue signup process</a>';
                        $contact_url = '<a href="'.site_url('home/support').'">'.site_url('home/support').'</a>';

                        try {
                            $this->email_model->prepare(
                                'employees_signup',
                                $user->id,
                                [
                                    "!site_title" => $this->config->item('site_title'),
                                    "!activation_url" => $activation_url,
                                    "!contact_url" => $contact_url
                                ],
                                TRUE
                            );

                        } catch (Exception $e) {
                            $this->notify->set($e->getMessage(), Notify::ERROR);

                        }
                        $error_msg = t('This email already exists but not active, please check new email to continue the signup process.');
                        $this->notify->set($error_msg, Notify::ERROR);
                        redirect('account/signup');

                    }else{
                        $error_msg = t('This email already exists, Please login or forgot password!');
                        $this->notify->set($error_msg, Notify::ERROR);
                        redirect('account/signup');
                    }
                }
                $insertData = [
                    'email' => $this->input->post('email'),
                    'role_id' => $this->input->post('acc_type'),
                    'activation_key' => md5(time()),
                    'created' => get_est_time(),
                    'name' => '',
                    'user_name' => '',
                    'last_activity' => get_est_time(),
                    'user_rating' => 0,
                    'num_reviews' => 0,
                    'rating_hold' => 0,
                    'tot_rating' => 0
                ];

                // Create User
                $this->user_model->createUser($insertData);
                $new_user_id = $this->db->insert_id();

                // Send mail
                $this->load->model('email_model');

                $activation_url = '<a href="'.site_url('account/confirm/' . $insertData['activation_key']).'">Click here to continue signup process</a>';
                $contact_url = '<a href="'.site_url('home/support').'">'.site_url('home/support').'</a>';

                try {
                    $this->email_model->prepare(
                        'employees_signup',
                        $new_user_id,
                        [
                            "!site_title" => $this->config->item('site_title'),
                            "!activation_url" => $activation_url,
                            "!contact_url" => $contact_url
                        ],
                        TRUE
                    );

                    $success_msg = t('confirmation_text') . $insertData['email'] . t('follow_the_link');
                    $this->notify->set($success_msg, Notify::SUCCESS);

                    // Create user balance
                    $insertBalance['user_id'] = $new_user_id;
                    $insertBalance['amount'] = '0';
                    $this->user_model->createUserBalance($insertBalance);
                } catch (Exception $e) {
                    $this->notify->set($e->getMessage(), Notify::ERROR);

                }
//
            }
            redirect('account/signup');
            return;
        }
        $this->load->view('account/signup', $this->outputData);
    }

    /**
     * @return void
     */
    function logout()
    {
        $this->user_model->clear_remember_cookie($this->logged_in_user->user_name);
        $this->auth_model->clearUserSession();
		unset($_SESSION['workflow_id']);
        unset($_SESSION['workflow']);

        redirect('home');
    }

    /**
     * Loads Account page
     */
    function index()
    {
        try {
            $this->load->model('project_model');
            $this->load->model('team_model');

            load_lang(['enduser/account', 'enduser/search']);

            // Loading CSS/JS
            $this->add_css([
                'application/css/css/jquery.rateyo.min.css',
                'application/css/css/machinery.css',
                'application/js/amcharts/ammap.css',
                'application/plugins/slick/slick.css',
                'application/plugins/slick/slick-theme.css'
            ]);

            $this->add_js([
                'application/js/jquery.rateyo.min.js',
                'application/js/year-select.js',
                'application/js/amcharts/ammap.js',
                'application/js/amcharts/worldLow.js',
                'application/plugins/slick/slick.min.js'
            ]);

            // Get user
            $user_id = $this->input->get('id');
            if ($user_id == '') {
                $user = $this->logged_in_user;
            } else {
                $user = $this->user_model->getUsers(['users.id' => $user_id])->row();
                if (!isset($user)) {
                    /*Flash*/
                    $success_msg = t('User does not exist');
                    $this->notify->set($success_msg, Notify::ERROR);
                    /*End Flash*/
                    redirect_back();
                }
                if ($user->first_name != '' or $user->last_name != '') {
                    $user->full_name = $user->first_name . ' ' . $user->last_name;
                } else {
                    $user->full_name = $user->user_name;
                }
                $user->img_logo = $this->file_model->get_user_logo_path($user->id, $user->logo);
            }
            $this->outputData['user'] = (array)$user;

            // Rank and rating
            $this->outputData['rank'] = $this->user_model->get_user_rank($user->id);
            $this->outputData['all_rank'] = $this->user_model->get_user_count();

            $rating_categories = $this->user_model->get_rating_categories($user->role_id);
            $count = count($rating_categories);
            for ($i = 0; $i < $count; $i++) {
                $rating_categories[$i]['rating'] = $this->user_model->get_user_rating($user->id, $rating_categories[$i]['id']);
            }
            $this->outputData['rating_categories'] = $rating_categories;

            // Reviews
            $this->outputData['reviews'] = $this->user_model->get_user_reviews($user->id);

            // Team
            $this->outputData['team_members'] = $this->team_model->get_team_members($user->id, '', '', '', '', '', TRUE);

            // Map
            $this->outputData['map_projects'] = $this->project_model->get_map_projects($user->id);

            // Projects
            // Get number of items already shown
            $offset = $this->input->post('offset');
            if ($offset == NULL) {
                $offset = 0;
            }
            $page_rows = 4;
            $max = [$page_rows, $offset];

            $this->outputData['active_projects_count'] = $this->project_model->get_active_projects_count($user->id);
            $this->outputData['active_projects'] = $this->project_model->get_active_projects($user->id, $max);
            $this->outputData['active_projects_load_all'] = (count($this->outputData['active_projects']) == $this->outputData['active_projects_count']);

            $this->outputData['completed_projects_count'] = $this->project_model->get_completed_projects_count($user->id);
            $this->outputData['completed_projects'] = $this->project_model->get_completed_projects($user->id, $max);
            $this->outputData['completed_projects_load_all'] = (count($this->outputData['completed_projects']) == $this->outputData['completed_projects_count']);

            // Load view
            if ($this->input->is_ajax_request()) {
                if ($this->input->post('part') == 'active') {
                    $this->outputData['projects'] = $this->outputData['active_projects'];
                    $count_all = $this->outputData['active_projects_count'];
                } else {
                    $this->outputData['projects'] = $this->outputData['completed_projects'];
                    $count_all = $this->outputData['completed_projects_count'];
                }
                echo response([
                    'table' => $this->load->view('account/index_projects', $this->outputData, TRUE),
                    'count_all' => $count_all
                ]);
            } else {
                $this->load->view('account/index', $this->outputData);
            }
        } catch (Exception $e) {
            $this->notify->set($e->getMessage(), Notify::ERROR);
            redirect_back();
        }
    }

    /**
     * Load dashboard
     */
    function dashboard()
    {
        $this->load->model('cancel_model');
        $this->load->model('finance_model');
        $this->load->model('news_model');
        $this->load->model('project_model');

        load_lang(['enduser/dashboard']);

        // Loading CSS/JS
        $this->add_css([
            'application/css/css/machinery.css',
            'application/css/css/jquery.rateyo.min.css',
            'application/js/amcharts/ammap.css',
            'application/plugins/slick/slick.css',
            'application/plugins/slick/slick-theme.css'
        ]);

        $this->add_js([
            'application/js/jquery.rateyo.min.js',
            'application/js/year-select.js',
            'application/js/amcharts/ammap.js',
            'application/js/amcharts/worldLow.js',
            'application/plugins/slick/slick.min.js'
        ]);

        $this->outputData['user'] = (array)$this->logged_in_user;

        $year = $this->input->post('year');
        if ($year == '') {
            $year = date('Y', get_est_time());
        }
        $this->outputData['year'] = $year;
        $first_day = strtotime($year . '-01-01');
        $last_day = strtotime($year . '-12-31');

        // Finance
        $this->outputData['invoices'] = 0;
        $this->outputData['invoice_paid'] = 0;
        $this->outputData['invoice_due'] = 0;
        $this->outputData['invoice_overdue'] = 0;
        $this->outputData['invoice_escrow'] = 0;
        $this->outputData['invoice_dispute'] = 0;
        $invoices = $this->finance_model->get_invoices($this->logged_in_user->id, $first_day, $last_day);
        foreach ($invoices as $invoice) {
            if ($invoice['payment_status']['class'] == 'payment-status-escrow') {
                $this->outputData['invoice_escrow'] += $invoice['payment_status']['amount'];
            } elseif ($invoice['payment_status']['class'] == 'payment-status-dispute') {
                $this->outputData['invoice_dispute'] += $invoice['payment_status']['amount'];
            } elseif ($invoice['payment_status']['class'] == 'payment-status-overdue') {
                $this->outputData['invoice_overdue'] += $invoice['payment_status']['due'];
            } else {
                $this->outputData['invoice_paid'] += $invoice['payment_status']['amount'];
                $this->outputData['invoice_due'] += $invoice['payment_status']['due'];
            }
        }
        $this->outputData['invoices'] = $invoices;

        $this->outputData['balance'] = $this->finance_model->get_user_balance();

        // Projects
        $quotes = $this->project_model->get_tender_projects_all($this->logged_in_user->id);
        $projects = $this->project_model->get_active_projects($this->logged_in_user->id);
        $this->outputData['quotes'] = $quotes;
        $this->outputData['projects'] = $projects;
        $this->outputData['active_milestones'] = 0;
        $this->outputData['due_milestones'] = 0;
        foreach ($projects as $project) {
            $due_milestones = $project['milestone_count'] - $project['active_milestone'];
            $this->outputData['active_milestones'] += $project['active_milestone'];
            $this->outputData['due_milestones'] += ($due_milestones < 0) ? 0 : $due_milestones;
        }

        // Disputes
        $this->outputData['cases'] = $this->cancel_model->get_user_cases();

        // Reviews
        $this->outputData['to_review'] = count($this->project_model->get_unreviewed_projects($this->logged_in_user->id));
        $this->outputData['reviews'] = $this->user_model->get_user_reviews($this->logged_in_user->id, [10, 0]);

        // Map
        $this->outputData['map_projects'] = $this->project_model->get_map_projects($this->logged_in_user->id);

        // Rank and rating
        $this->outputData['rank'] = $this->user_model->get_user_rank($this->logged_in_user->id);
        $this->outputData['all_rank'] = $this->user_model->get_user_count();

        $this->outputData['total_rating'] = $this->user_model->get_user_rating($this->logged_in_user->id);

        $rating_categories = $this->user_model->get_rating_categories($this->logged_in_user->role_id);
        $count = count($rating_categories);
        for ($i = 0; $i < $count; $i++) {
            $rating_categories[$i]['rating'] = $this->user_model->get_user_rating($this->logged_in_user->id, $rating_categories[$i]['id']);
        }
        $this->outputData['rating_categories'] = $rating_categories;

        // News
        $this->outputData['news'] = $this->news_model->get_news([8, 0]);

        $this->load->view('account/dashboard', $this->outputData);
    }

    /**
     * Load more news on dashboard
     */
    function dashboard_load_news()
    {
        if ($this->input->is_ajax_request()) {
            $this->load->model('news_model');

            $offset = $this->input->post('offset');
            if ($offset == '') {
                $offset = 0;
            }
            $this->outputData['news'] = $this->news_model->get_news([8, $offset]);
            echo response(['news' => $this->load->view('account/dashboard_news', $this->outputData, TRUE)]);
        }
    }

    /**
     * Load more reviews on dashboard
     */
    function dashboard_load_reviews()
    {
        if ($this->input->is_ajax_request()) {
            $this->load->model('user_model');

            $offset = $this->input->post('offset');
            if ($offset == '') {
                $offset = 0;
            }
            $this->outputData['reviews'] = $this->user_model->get_user_reviews($this->logged_in_user->id, [8, $offset]);
            echo response(['reviews' => $this->load->view('account/dashboard_reviews', $this->outputData, TRUE)]);
        }
    }

    /**
     * Edit account
     * @param int $segment
     */
    function edit($segment=1)
    {
        load_lang('enduser/edit_account_lang');

        $this->add_css([
            "application/plugins/fancybox/source/jquery.fancybox.css",
            "application/css/css/build.css",
            "application/css/css/multiselect.css?v=".time(),
            "application/css/css/dropzone.css",
            "application/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css",
            "application/plugins/cropper/cropper.css",
            "application/css/css/round_cropper.css",
        ]);

        $this->add_js([
            "application/plugins/fancybox/source/jquery.fancybox.pack.js",
            'application/js/dropdown.js',
            'application/js/dropzone.js',
            'application/js/account_edit.js',
            "application/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js",
            "application/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js",
            "application/js/jquery.wysihtml5_size_matters.js",
            "application/plugins/cropper/cropper.js",
        ]);

        $this->init_js(["account_edit.init('" . site_url() . "');"]);

        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        // define segment
        if ($this->input->post('segment')){
            $segment = $this->input->post('segment');
        }

        switch ($segment){
            case '1':
                $this->edit_user_account();
                break;
            case "2":
                $this->edit_bank_account();
                break;
            case "3":
                $this->edit_paypal_account();
                break;
        }

        if ($this->input->is_ajax_request()) {
            $html = $this->load->view($this->outputData['view'], $this->outputData, TRUE);
            echo json_encode([
                'error' => FALSE,
                'html' => $html,
            ]);
            return;
        }else {
            $this->load->view('account/edit', $this->outputData);
        }
    }

    /**
     * Edit user account
     */
    function edit_user_account()
    {
        load_lang('enduser/editProfile');

        if ($this->input->post('submit') != '') {
            // Set rules
            $this->form_validation->set_rules('logo', 'lang:logo_validation', 'trim|xss_clean');
            $this->form_validation->set_rules('name', 'lang:name_confirm_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('first_name', 'First Name', 'required|trim|max_length[125]|xss_clean');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim|max_length[125]|xss_clean');
            $this->form_validation->set_rules('company_address', 'Company Address', 'trim|max_length[255]|xss_clean');
            if (isProvider()) {
                $this->form_validation->set_rules('vat_id', 'VAT/TIN ID', 'required|trim|max_length[100]|xss_clean');
            }
            $this->form_validation->set_rules('categories', 'lang:categories_validation', 'required|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'required|trim|min_length[5]|xss_clean');
            // This field only for "Consultant Marketplace".  Please look at Issue #17 on GitLab in PDF doc.
            //$this->form_validation->set_rules('rate', 'lang:rate_validation', 'required|trim|integer|xss_clean|abs');
            $this->form_validation->set_rules('country_id', 'lang:country_validation', 'required');
            $this->form_validation->set_rules('state', 'lang:state_validation', 'trim|xss_clean');
            $this->form_validation->set_rules('city', 'lang:city_validation', 'trim|xss_clean');
            $this->form_validation->set_rules('zip_code', 'lang:ZIP Code', 'trim|xss_clean');
            $this->form_validation->set_rules('pick_password', 'lang:Password', 'trim|xss_clean');
            $this->form_validation->set_rules('profile_desc', 'lang:Profile', 'trim|xss_clean');
            if ($this->input->post('pick_password') != '') {
                $this->form_validation->set_rules('repeat_password', 'lang:Repeat Password', 'required|trim|xss_clean|matches[pick_password]');
            }

            if ($this->form_validation->run()) {
                $data = [];

                $data['id'] = $this->logged_in_user->id;
                $data['logo'] = $this->input->post('logo');
                $data['img_logo'] = $this->input->post('img_logo');
                $data['first_name'] = $this->input->post('first_name');
                $data['last_name'] = $this->input->post('last_name');
                $data['name'] = $this->input->post('name');
                $data['vat_id'] = $this->input->post('vat_id');
                $data['email'] = $this->input->post('email');
                $data['company_address'] = $this->input->post('company_address');
                $data['city'] = $this->input->post('city');
                $data['state'] = $this->input->post('state');
                $data['zip_code'] = $this->input->post('zip_code');
                $data['country_id'] = $this->input->post('country_id');
                $data['rate'] = empty($this->input->post('rate')) ? null : $this->input->post('rate');
                $data['profile_desc'] = $this->input->post('profile_desc');

                if ($this->input->post('pick_password') != '') {
                    $data['password'] = password_hash($this->input->post('pick_password'), PASSWORD_DEFAULT);
                }
                if ($this->input->post('categories') != '') {
                    $data['categories'] = explode(',', $this->input->post('categories'));
                }

                $this->user_model->update_user($data);
                /*Flash*/
                $success_msg = t('Changes to profile are saved successfully.');
                $this->notify->set($success_msg, Notify::SUCCESS);
                /*End Flash*/
            }
        }

        $this->outputData['user'] = (array)$this->logged_in_user;
        $this->outputData['countries'] = $this->common_model->get_countries();
        $this->outputData['groups_with_categories'] = $this->skills_model->getGroupsWithCategory();
        $this->outputData['view'] = 'account/settings/user_account';

    }

    /**
     * Edit bank info and bank account information
     */
    function edit_bank_account()
    {
        load_lang('enduser/edit_bank_info');

        $this->load->model('user_bank_account_model');
        $this->load->model('user_bank_model');
        $this->load->model('currency_model');

        $this->outputData['countries'] = $this->common_model->get_countries();
        $this->outputData['currencies'] = $this->currency_model->find_all();

        $this->outputData['bank'] = $this->user_bank_model->find_one_by_attributes(['user_id' => $this->logged_in_user->id]);
        if ($this->outputData['bank']) {
            $this->outputData['bank_account'] = $this->user_bank_account_model->find_one_by_attributes(['bank_id' => $this->outputData['bank']['id']]);
        } else {
            $this->outputData['bank_account'] = NULL;
        }

        if ($this->input->post('submit') != '')
        {
            $this->form_validation->set_rules('user_bank[swift_code]', 'lang:swift_code', 'trim|xss_clean|required|min_length[8]|max_length[11]');
            $this->form_validation->set_rules('user_bank[name]', 'lang:name', 'trim|xss_clean|required');
            $this->form_validation->set_rules('user_bank[address]', 'lang:address', 'trim|xss_clean|required');
            $this->form_validation->set_rules('user_bank[city]', 'lang:city', 'trim|xss_clean|required');
            $this->form_validation->set_rules('user_bank[country_id]', 'lang:country', 'required');
            $this->form_validation->set_rules('user_bank[currency_id]', 'lang:currency', 'required');

            $this->form_validation->set_rules('user_bank_account[account_number]', 'lang:account_number', 'trim|xss_clean|required|min_length[34]|max_length[34]');
            $this->form_validation->set_rules('user_bank_account[name_on_account]', 'lang:name_on_account', 'trim|xss_clean|required');
            $this->form_validation->set_rules('user_bank_account[address]', 'lang:address', 'trim|xss_clean|required');
            $this->form_validation->set_rules('user_bank_account[city]', 'lang:city', 'trim|xss_clean|required');
            $this->form_validation->set_rules('user_bank_account[country_id]', 'lang:country', 'required');

            if ($this->form_validation->run())
            {
                $this->outputData['bank']['swift_code'] = $this->input->post('user_bank')['swift_code'];
                $this->outputData['bank']['name'] = $this->input->post('user_bank')['name'];
                $this->outputData['bank']['address'] = $this->input->post('user_bank')['address'];
                $this->outputData['bank']['city'] = $this->input->post('user_bank')['city'];
                $this->outputData['bank']['country_id'] = $this->input->post('user_bank')['country_id'];
                $this->outputData['bank']['currency_id'] = $this->input->post('user_bank')['currency_id'];
                $this->outputData['bank']['user_id'] = $this->logged_in_user->id;

                $this->outputData['bank_account']['account_number'] = $this->input->post('user_bank_account')['account_number'];
                $this->outputData['bank_account']['name_on_account'] = $this->input->post('user_bank_account')['name_on_account'];
                $this->outputData['bank_account']['address'] = $this->input->post('user_bank_account')['address'];
                $this->outputData['bank_account']['city'] = $this->input->post('user_bank_account')['city'];
                $this->outputData['bank_account']['country_id'] = $this->input->post('user_bank_account')['country_id'];
                try
                {
                    $this->db->trans_start();

                    if($this->user_bank_model->is_new_record)
                    {
                        $this->user_bank_model->insert($this->outputData['bank']);
                        $this->outputData['bank_account']['bank_id'] = $this->db->insert_id();
                        $this->user_bank_account_model->insert($this->outputData['bank_account']);
                        $this->notify->set(t('message_saved'), Notify::SUCCESS);
                    } else {

                        $this->user_bank_model->update($this->outputData['bank'], ['id'=>$this->outputData['bank']['id']]);
                        $this->user_bank_account_model->update($this->outputData['bank_account'], ['id'=>$this->outputData['bank_account']['id']]);
                        $this->notify->set(t('message_saved'), Notify::SUCCESS);
                    }
                    $this->db->trans_complete();
                }
                catch (Exception $e)
                {
                    $this->notify->set($e->getMessage(), Notify::ERROR);
                }
            }
        }
        $this->outputData['view'] = 'account/settings/bank_info';
    }

    /**
     * Edit PayPal account information
     */
    function edit_paypal_account()
    {
        load_lang('enduser/edit_paypal_info');

        $this->load->model('user_paypal_model');
        $this->outputData['paypal'] = $this->user_paypal_model->find_one_by_attributes(['user_id' => $this->logged_in_user->id]);

        if ($this->input->post('submit') != '')
        {
            $this->form_validation->set_rules('email', 'lang:email', 'required|trim|valid_email|xss_clean');

            if ($this->form_validation->run())
            {
                $this->outputData['paypal']['email'] = $this->input->post('email');
                $this->outputData['paypal']['user_id'] = $this->logged_in_user->id;
                try
                {
                    if($this->user_paypal_model->is_new_record)
                    {
                        $this->user_paypal_model->insert($this->outputData['paypal']);
                        $this->notify->set(t('message_saved'), Notify::SUCCESS);
                    } else {
                        $this->user_paypal_model->update($this->outputData['paypal'], ['id'=>$this->outputData['paypal']['id']]);
                        $this->notify->set(t('message_saved'), Notify::SUCCESS);
                    }
                }
                catch (Exception $e)
                {
                    $this->notify->set($e->getMessage(), Notify::ERROR);
                }
            }
        }

        $this->outputData['view'] = 'account/settings/paypal';
    }

    public function username_check($str)
    {
        if ($str == 'test')
        {
            $this->form_validation->set_message('username_check', 'The {field} field can not be the word "test"');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }


    /**
     * Upload user logo
     */
    function upload_file()
    {
        if (isset($_FILES) and is_array($_FILES) and array_key_exists('file', $_FILES)) {
            $this->load->library('upload');
            $this->load->library('image_lib');

            if (isset($this->logged_in_user->id)) {
                $config['upload_path'] = $this->file_model->temp_dir($this->logged_in_user->id);
            } else {
                $config['upload_path'] = $this->file_model->temp_dir(0);
            }
            /* For some reason, listing MIME types do not work */
            $config['allowed_types'] = 'bmp|BMP|gif|GIF|jpg|JPG|jpeg|JPEG|png|PNG';
            $config['max_size'] = $this->config->item('max_upload_size');
            $config['encrypt_name'] = TRUE;
            $config['file_ext_tolower'] = TRUE;

            $this->upload->initialize($config);

            $file = $_FILES['file'];
            $_FILES['file'] = $file;
            $this->upload->do_upload('file');
            $data = $this->upload->data();

            // Check if file is uploaded
            if ($data['file_name'] != '' and $data['orig_name'] != '') {
                // Resize image
                /*if ($data['is_image']) {
                    $resize = [
                        'source_image' => $data['full_path'],
                        'maintain_ratio' => FALSE,
                        'width' => 128,
                        'height' => 128
                    ];
                    $this->image_lib->initialize($resize);
                    $this->image_lib->resize();
                }*/
                echo json_encode([
                    'logo' => $data['file_name'],
                    'img_logo' => '/' . $config['upload_path'] . $data['file_name']
                ]);
            }
        }
    }

    /**
     * Manage banned members
     */
    function favorite_members()
    {
        $this->member_list(1, User_model::TYPE_FIND_USER_FAVORITE_MEMBER);
    }

    /**
     * Manage favorite/banned members
     *
     * @param $mode
     */
    function member_list($mode, $type)
    {
        try {


            load_lang('enduser/memberList');

            $this->load->library('form_validation');
            $this->load->helper('form');
            $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

            // Loading CSS/JS
            $this->add_css([
                'application/css/css/build.css',
                'application/css/css/multiselect.css?v='.time(),
                'application/css/jquery-ui.css',
            ]);

            $this->add_js([
                'application/js/dropdown.js',
                'application/js/pagination.js',
                'application/js/account.js',
                'application/js/pagination.js',
            ]);
            $this->init_js(["account.init('" . site_url() . "', '" . $type . "');"]);
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
            $rating = $this->input->post('rating');
            $categories = $this->input->post('categories');

            // Post form
            if ($this->input->post('submit') != '') {
                $this->form_validation->set_rules('user_id', t('Name'), 'required|trim|xss_clean|integer');
                if ($this->form_validation->run()) {
                    try {
                        if ($mode == 1) {
                            $this->user_model->add_favorite_user($this->logged_in_user->id, $this->input->post('user_id'));
                            $this->notify->set(t('You success add user to favorite'), Notify::SUCCESS);
                        } else {
                            $this->user_model->add_banned_user($this->logged_in_user->id, $this->input->post('user_id'));
                            $this->notify->set(t('You success add user to banned'), Notify::SUCCESS);
                        }
                        redirect($this->uri->uri_string());
                    } catch (Exception $e) {
                        $this->notify->set($e->getMessage(), Notify::ERROR);
                    }
                }
            }

            if ($mode == 1) {
                $members = $this->user_model->get_favorite_users($this->logged_in_user->id, $rating, $categories, $max, $order_by);
                $members_total = count($this->user_model->get_favorite_users($this->logged_in_user->id, $rating, $categories, '', ''));
            } else {
                $members = $this->user_model->get_banned_users($this->logged_in_user->id, $rating, $categories, $max, $order_by);
                $members_total = count($this->user_model->get_banned_users($this->logged_in_user->id, $rating, $categories, '', ''));
            }
            foreach ($members as $k => $member) {
                $portfolios_total = $this->machinery_model->get_machinery_by_user($member['id']);
                $members[$k]['portfolios_total'] = $portfolios_total;
            }
            $this->outputData['members'] = $members;
            $this->outputData['pagination'] = get_pagination(site_url(($mode == 1) ? 'account/favorite_members/' : 'account/banned_members/'), $members_total, $page_rows, $page);

            if ($members_total == 0) {
                $this->outputData['page_numbers'] = array();
            }

            $this->outputData['groups_with_categories'] = $this->skills_model->getGroupsWithCategory();

            $this->outputData['mode'] = ($mode == 1) ? 'favorite' : 'banned';

            if ($this->input->is_ajax_request()) {
                echo response([
                    'type' => 'table',
                    'data' => $this->load->view('account/member_list_table', $this->outputData, TRUE),
                    'pagination' => $this->outputData['pagination']
                ]);
            } else {
                $this->load->view('account/member_list', $this->outputData);
            }
        } catch (Exception $e) {
            $this->notify->set($e->getMessage(), Notify::ERROR);
            redirect('information');
        }
    }

    /**
     * Manage banned members
     */
    function banned_members()
    {
        $this->member_list(2, User_model::TYPE_FIND_USER_BANNED_MEMBER);
    }

    /**
     * Request to delete favorite member
     */
    function delete_favorite_member()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->get('id');
            $member = $this->user_model->get_favorite_user($this->logged_in_user->id, $id);
            if (!isset($member['id'])) {
                $result = response('User does not exist', TRUE);
            } else {
                $this->user_model->delete_favorite_user($this->logged_in_user->id, $id);
                $result = response(['id' => $id]);
            }
            echo $result;
        }
    }

    /**
     * Request to delete banned member
     */
    function delete_banned_member()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->get('id');
            $member = $this->user_model->get_banned_user($this->logged_in_user->id, $id);
            if (!isset($member['id'])) {
                $result = response('User does not exist', TRUE);
            } else {
                $this->user_model->delete_banned_user($this->logged_in_user->id, $id);
                $result = response(['id' => $id]);
            }
            echo $result;
        }
    }

    /**
     * Invite supplier by email
     */
    function invite_supplier()
    {

        // load validation library
        $this->load->library('form_validation');

        // Load Form Helper
        $this->load->helper('form');

        $this->load->model('email_model');
        $this->load->model('page_model');

        // Intialize values for library and helpers
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));
        $this->form_validation->set_message('is_unique', t('The user with this email is already registered in the system. You can\'t send invitation.'));

        $mail = $this->email_model->get_mail('invite_supplier', [
            "!site_title" => $this->config->item('site_title'),
            "!contact_url" => site_url('home/support')
        ]);
        $mail['custom_message'] = t('invite-supplier-welcome');
        $this->outputData = array_merge($this->outputData, $mail);

        // Get Form Data
        if ($this->input->post('accountSignup')) {
            // Set rules
            $this->form_validation->set_rules('email', 'email', 'required|trim|valid_email|xss_clean|is_unique[users.email]');
            $this->form_validation->set_rules('mail_subject', 'subject', 'required|trim|xss_clean');
            $this->form_validation->set_rules('mail_content', 'content', 'required|trim|xss_clean');
            if ($this->form_validation->run()) {
//				/*if (check_form_token() === false)
//				{
//					$this->notify->set( t('token_error'), Notify::ERROR);
//					redirect('entrepreneur/inviteSupplier');
//					return;
//				}*/
                $insertData = array();
                $insertData['email'] = $this->input->post('email');
                //$role_name = $this->input->post('acc_type');
                $insertData['role_id'] = '2';
                $insertData['activation_key'] = md5(time());
                $insertData['created'] = get_est_time();
                $insertData['name'] = '';
                $insertData['user_name'] = '';
                $insertData['last_activity'] = get_est_time();
                $insertData['user_rating'] = 0;
                $insertData['num_reviews'] = 0;
                $insertData['rating_hold'] = 0;
                $insertData['tot_rating'] = 0;

                // Create User
                $this->user_model->createUser($insertData);
                $new_user_id = $this->db->insert_id();

                // Send Mail
                $this->load->model('email_model');

                $activation_url = '<a href="'.site_url('account/confirm/' . $insertData['activation_key']).'">Click here to continue signup process</a>';
                $contact_url = '<a href="'.site_url('home/support').'">'.site_url('home/support').'</a>';

                try {
                    $this->email_model->custom(
                        $new_user_id,
                        $this->input->post('mail_subject'),
                        $mail['body'],
                        [
                            "!site_title" => $this->config->item('site_title'),
                            "!activation_url" => $activation_url,
                            "!custom_body" => $this->input->post('mail_content') . "<br>",
                            "!contact_url" => $contact_url
                        ],
                        TRUE
                    );

                    $success_msg = t('Invitation sent to ') . $insertData['email'];
                    $this->notify->set($success_msg, Notify::SUCCESS);

                    // Create user balance
                    $insertBalance['user_id'] = $new_user_id;
                    $insertBalance['amount'] = '0';
                    $this->user_model->createUserBalance($insertBalance);
                } catch (Exception $e) {
                    $this->notify->set($e->getMessage(), Notify::ERROR);
                }
            }
        }

        $this->load->view('account/invite_supplier', $this->outputData);
    }

    /**
     * Confirm registration
     */
    function confirm()
    {
        // language file
        load_lang(['enduser/employee', 'enduser/owners']);

        $code = $this->uri->segment(2, $this->input->post('activation_key'));
        if (empty($code)) {

            /*Flash*/
            $success_msg = t('error-no-activation-code');
            $this->notify->set($success_msg, Notify::ERROR);
            /*End Flash*/
            redirect('information');
        }

        // check if user is already logged in
        if ($this->logged_in_user) {
            //logout current user
            $this->user_model->clear_remember_cookie($this->logged_in_user->user_name);
            $this->auth_model->clearUserSession();

            /*Flash*/
            $success_msg = t('previous-session-closed');
            $this->notify->set($success_msg, Notify::SUCCESS);
            /*End Flash*/
        }

        $this->add_css([
            'application/css/css/build.css',
            'application/css/css/multiselect.css?v='.time(),
            'application/css/css/dropzone.css'
        ]);

        $this->add_js([
            'application/js/dropdown.js',
            'application/js/dropzone.js',
            'application/js/jquery.inputmask.bundle.min.js',
            'application/js/custom-inputmask.js',
        ]);

        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        // Post data
        if ($this->input->post('submit') != '') {
            $loginName = $this->input->post('user_name');

            // Set rules
            $this->form_validation->set_rules('user_name', t('User Name'), 'required|trim|min_length[5]|xss_clean|callback__unique_user_name');
            $this->form_validation->set_rules('first_name', t('First Name'), 'required|trim|xss_clean');
            $this->form_validation->set_rules('last_name', t('Last Name'), 'required|trim|xss_clean');
            $this->form_validation->set_rules('password', t('Password'), 'required|trim|min_length[5]|max_length[16]|xss_clean');
            $this->form_validation->set_rules('confirm_password', t('Repeat Password'), 'required|trim|xss_clean|matches[password]');
            $this->form_validation->set_rules('name', t('Company Name'), 'required|trim|xss_clean');
            $this->form_validation->set_rules('company_address', t('Company Address'), 'trim|xss_clean');
            // This field only for "Consultant Marketplace".  Please look at Issue #17 on GitLab in PDF doc.
//			if ($this->input->post('role_id') == 2)
//			{
//				$this->form_validation->set_rules('rate', t('Hourly Rate'), 'required|trim|is_natural_no_zero|xss_clean|abs');
//			}
            $this->form_validation->set_rules('profile_desc', t('Profile Description'), 'trim|xss_clean');
            $this->form_validation->set_rules('country_id', t('Country'), 'required');
            $this->form_validation->set_rules('state', t('State/Province'), 'trim|xss_clean');
            $this->form_validation->set_rules('city', t('City'), 'trim|xss_clean');
            $this->form_validation->set_rules('zip_code', t('ZIP Code'), 'trim|xss_clean');
            $this->form_validation->set_rules('categories', t('Categories'), 'required');
            $this->form_validation->set_rules('notify_bid', t('Notify of New Quote'), 'trim|xss_clean');
            $this->form_validation->set_rules('notify_message', t('Notify of New Message'), 'trim|xss_clean');
            $this->form_validation->set_rules('signup_agree_terms', t('signup_agree_terms_validation'), 'callback__terms_required');
            $this->form_validation->set_rules('activation_key', t('Confirmation Key'), 'callback__check_activation_key');

            if ($this->form_validation->run()) {
                $data = [];

                $data['id'] = $this->input->post('id');
                $data['user_name'] = $this->input->post('user_name');
                $data['first_name'] = $this->input->post('first_name');
                $data['last_name'] = $this->input->post('last_name');
                $data['name'] = $this->input->post('name');
                $data['company_address'] = $this->input->post('company_address');
                $data['logo'] = $this->input->post('logo');
                $data['img_logo'] = $this->input->post('img_logo');
                $data['profile_desc'] = $this->input->post('profile_desc');
                $data['country_id'] = $this->input->post('country_id');
                $data['state'] = $this->input->post('state');
                $data['city'] = $this->input->post('city');
                $data['zip_code'] = $this->input->post('zip_code');

                $notify_bid = $this->input->post('notify_bid');
                if (isset($notify_bid) && $notify_bid != '') {
                    $data['bid_notify'] = $notify_bid;
                }
                $notify_message = $this->input->post('notify_message');
                if (isset($notify_message) && $notify_message != '') {
                    $data['message_notify'] = $notify_message;
                }
                $data['user_status'] = 1;
                $data['activation_key'] = NULL;

                if ($this->input->post('password') != '') {
                    $data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
                }
                if ($this->input->post('categories') != '') {
                    $data['categories'] = explode(',', $this->input->post('categories'));
                }
                // This field only for "Consultant Marketplace".  Please look at Issue #17 on GitLab in PDF doc.
//				if ($this->input->post('role_id') == 2)
//				{
//					$data['rate'] = $this->input->post('rate');
//				}

                $this->user_model->update_user($data);


                /*Flash*/
                $success_msg = t('You have successfully registered');
                $this->notify->set($success_msg, Notify::SUCCESS);
                /*End Flash*/

                redirect('account/login');
            }
        }

        $this->outputData['countries'] = $this->common_model->get_countries();
        $this->outputData['groups_with_categories'] = $this->skills_model->getGroupsWithCategory();

        ///
        $user = $this->user_model->getUsers(['users.activation_key' => $code])->row();
        if (isset($user)) {
            $this->outputData['id'] = $user->id;
            $this->outputData['role_id'] = $user->role_id;
            $this->outputData['confirmed_mail'] = $user->email;
        } else {

            /*Flash*/
            $success_msg = t('emp_activationkey_error');
            $this->notify->set($success_msg, Notify::ERROR);
            /*End Flash*/

            redirect('account/signup');
        }

        $this->load->view('account/confirm_signup', $this->outputData);
    }

    /**
     * Callback for activation key
     *
     * @param int $activation_key
     * @return bool
     */
    function _check_activation_key($activation_key = 0)
    {
        $query = $this->user_model->getUsers(['users.activation_key' => $activation_key]);
        if ($query->num_rows() > 0) {
            return true;
        } else {
            $this->form_validation->set_message('_check_activation_key', t('activation_key_validation'));
            return false;
        }
    }

    /**
     * @param $field
     * @return bool
     */
    function _terms_required($field)
    {
        if ($field == '') {
            $this->form_validation->set_message('_terms_required', 'You need to accept our <a class="text-primary" href="' . site_url('home/page/condition') . '" target="_blank">terms and conditions</a> in order to use our service.');
            return false;
        }
        return true;
    }

    /**
     * @param $field
     * @return mixed
     */
    function _unique_user_name($field)
    {
        $loginName = $this->user_model->checkUsername($field);
        $this->form_validation->set_message('_unique_user_name', 'User ' . $field . ' is already registered on our site. You can use this name: ' . $loginName);
        return $loginName === $field; //$this->form_validation->is_unique($field, 'users.user_name');
    }

    /**
     * Subscription page
     */
    function subscribe()
    {
        $this->load->model('package_model');
        $this->outputData['packages'] = $this->package_model->getPackages();
        $this->load->view('account/subscribe', $this->outputData);
    }

    /**
     * Loads Home page of the site.
     *
     * @access    public
     * @param    nil
     * @return    void
     */
    function login()
    {
        load_lang('enduser/register');

        $this->add_css([
            'application/css/css/login.css'
        ]);

        $this->load->library('encrypt');
        $this->load->library('form_validation');

        $this->load->helper('cookie');
        $this->load->helper('form');

        $this->load->model('auth_model');
        $this->load->model('email_model');
        $this->load->model('user_model');

        //Intialize values for library and helpers
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        // Remember me
        if ($this->auth_model->getUserCookie('login_series') != '' && $this->auth_model->getUserCookie('login_token') != '') {
            $user_name = $this->user_model->check_remember_cookie();
            if (!$user_name) {
                $this->user_model->save_login_attempt($this->input->post('username'), 0, 5);
                redirect('account/login', 'location');
            } else {
                $user = $this->user_model->getUsers(['user_name' => $user_name])->row();

                $default_url = $this->config->item('roles')[$user->role_name]['url'];

                $this->auth_model->setUserSession($user);
                $this->user_model->add_remember_cookie($user_name, DAY * 100);

                $this->user_model->save_login_attempt($this->input->post('username'), 1);
                redirect($default_url);
            }
        }

        //Get Form Data
        if ($this->input->post('usersLogin')) {
            //Set rules
            $this->form_validation->set_rules('username', 'lang:user_name_validation', 'required|trim|min_length[5]|xss_clean');
            $this->form_validation->set_rules('pwd', 'lang:password_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('captcha_code', 'captcha_code', 'callback__check_captcha');

            if ($this->form_validation->run()) {
                // Check if user exists
                $user = $this->user_model->get_user_at_login($this->input->post('username'), $this->input->post('pwd'));
                if (!$user) {
                    // Log unsuccessful login attempt
                    $user = $this->user_model->getUsers(['users.user_name' => $this->input->post('username')])->row();
                    if (!isset($user)) {
                        $this->user_model->save_login_attempt($this->input->post('username'), 0, 0);
                    } else {
                        $this->user_model->save_login_attempt($this->input->post('username'), 0, 1);
                    }

                    //Notification message

                    /*Flash*/
                    $this->notify->set(t('Login failed! Incorrect username or password'), Notify::ERROR);
                    /*End Flash*/
                    redirect('account/login', 'location');
                }

                $default_url = $this->config->item('roles')[$user->role_name]['url'];

                // Check if user is not activated
                if ($user->user_status != 1) {
                    // Log unsuccessful login attempt
                    $this->user_model->save_login_attempt($this->input->post('username'), 0, 3);

                    //Notification message

                    /*Flash*/
                    $this->notify->set(t('Login failed! User is not activated'), Notify::ERROR);
                    /*End Flash*/
                    redirect('account/login', 'location');
                }

                // Check if user is banned
                if (getBanStatus($this->input->post('username'))) {
                    // Log successful login attempt
                    $this->user_model->save_login_attempt($this->input->post('username'), 0, 4);


                    /*Flash*/
                    $this->notify->set(t('Ban Error'), Notify::ERROR);
                    /*End Flash*/
                    redirect('account/login', 'location');
                }

                // Proceed with login
                /*$this->email_model->prepare(
                    'user_login',
                    $user->id,
                    [
                        '!username' => $user->first_name . ' ' . $user->last_name,
                        '!email' => $user->email,
                        '!browser' => $this->getBrowser(),
                        '!os' => $this->getOS()
                    ]
                );*/

                // Set Session For User
                $this->auth_model->setUserSession($user);

                // Remember me
                if ($this->input->post('remember')) {
                    $this->user_model->add_remember_cookie($this->input->post('username'), DAY * 100);
                }

                // Log successful login attempt
                $this->user_model->save_login_attempt($this->input->post('username'), 1);

                $last_url = $this->session->userdata('last_url');

                $this->session->unset_userdata('last_url');

                if($last_url) redirect($last_url);
                redirect($default_url);
            } else {
                // Log unsuccessful login attempt
                if ($this->form_validation->error('username') != '') {
                    $this->user_model->save_login_attempt($this->input->post('username'), 0, 0);
                } elseif ($this->form_validation->error('pwd') != '') {
                    $this->user_model->save_login_attempt($this->input->post('username'), 0, 1);
                } elseif ($this->form_validation->error('captcha_code') != '') {
                    $this->user_model->save_login_attempt($this->input->post('username'), 0, 2);
                }
            }
        }

        $captcha_info = $this->simple_php_captcha();
        $this->session->set_userdata('captcha_code', $captcha_info['code']);
        $this->outputData['captcha'] = $captcha_info;

        $this->load->view('account/login', $this->outputData);
    }
    /**
     * Login Ajax
     *
     * @access    public
     * @param    nil
     * @return    void
     */
    public function login_ajax(){
        $dataResponse= array(
            'success' => false,
            'message' => ''
        );
        load_lang('enduser/register');

        $this->add_css([
            'application/css/css/login.css'
        ]);

        $this->load->library('encrypt');
        $this->load->library('form_validation');

        $this->load->helper('cookie');
        $this->load->helper('form');

        $this->load->model('auth_model');
        $this->load->model('email_model');
        $this->load->model('user_model');

        //Intialize values for library and helpers
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

            //Set rules
            $this->form_validation->set_rules('username', 'lang:user_name_validation', 'required|trim|min_length[5]|xss_clean');
            $this->form_validation->set_rules('pwd', 'lang:password_validation', 'required|trim|xss_clean');

            if ($this->form_validation->run()) {
                // Check if user exists
                $user = $this->user_model->get_user_at_login($this->input->post('username'), $this->input->post('pwd'));
                if (!$user) {
                    // Log unsuccessful login attempt
                    $user = $this->user_model->getUsers(['users.user_name' => $this->input->post('username')])->row();
                    if (!isset($user)) {
                        $this->user_model->save_login_attempt($this->input->post('username'), 0, 0);
                    } else {
                        $this->user_model->save_login_attempt($this->input->post('username'), 0, 1);
                    }

                    //Notification message
                    /*Flash*/
                 //   $this->notify->set(t('Login failed! Incorrect username or password'), Notify::ERROR);
                    /*End Flash*/
//                    redirect('account/login', 'location');
                    $dataResponse= array(
                        'success' => false,
                        'message' => t('Login failed! Incorrect username or password'),
                        'data'=> '',
                    );
                    $this->ajax_out($dataResponse);
                }

                $default_url =$this->config->item('roles')[$user->role_name]['url'];

                // Check if user is not activated
                if ($user->user_status != 1) {
                    // Log unsuccessful login attempt
                    $this->user_model->save_login_attempt($this->input->post('username'), 0, 3);

                    //Notification message

                    /*Flash*/
            //        $this->notify->set(t('Login failed! User is not activated'), Notify::ERROR);
                    /*End Flash*/
//                    redirect('account/login', 'location');
                    $dataResponse= array(
                        'success' => false,
                        'message' => t('Login failed! User is not activated'),
                        'data'=> '',
                    );
                    $this->ajax_out($dataResponse);
                }

                // Check if user is banned
                if (getBanStatus($this->input->post('username'))) {
                    // Log successful login attempt
                    $this->user_model->save_login_attempt($this->input->post('username'), 0, 4);


                    /*Flash*/
           //         $this->notify->set(t('Ban Error'), Notify::ERROR);
                    /*End Flash*/
//                    redirect('account/login', 'location');
                    $dataResponse= array(
                        'success' => false,
                        'message' => 'Ban Error',
                        'data'=> '',
                    );
                    $this->ajax_out($dataResponse);
                }

                // Set Session For User
                $this->auth_model->setUserSession($user);

                // Remember me
                if ($this->input->post('remember')) {
                    $this->user_model->add_remember_cookie($this->input->post('username'), DAY * 100);
                }

                // Log successful login attempt
                $this->user_model->save_login_attempt($this->input->post('username'), 1);

                $last_url = $this->session->userdata('last_url');
                $this->session->unset_userdata('last_url');

                $dataResponse= array(
                    'success' => true,
                    'message' => '',
                    'data'=> $last_url?$last_url:site_url($default_url),
                );
                $this->ajax_out($dataResponse);
            } else {
                // Log unsuccessful login attempt
                $dataResponse= array(
                    'success' => false,
                    'message' => t('Login failed! Incorrect username or password'),
                    'data'=> '',
                );
                $this->ajax_out($dataResponse);
            }

    }
    public function check_session_login(){
        $this->session->set_userdata('last_url', $this->input->post('url'));
        $dataResponse= array(
            'is_login' => !empty($this->logged_in_user)
        );
        $this->ajax_out($dataResponse);
    }
    protected function ajax_out($dataResponse){
        header('Content-type: application/json');
        echo json_encode($dataResponse);
        exit();
    }
    /**
     * @param array $config
     * @return array
     */
    function simple_php_captcha($config = array())
    {
        $bg_path = image_url('backgrounds/');
        $font_path = APPPATH . 'fonts/';

        // Default values
        $captcha_config = array(
            'code' => '',
            'min_length' => 5,
            'max_length' => 5,
            'backgrounds' => array(
                $bg_path . '45-degree-fabric.png',
                $bg_path . 'cloth-alike.png',
                $bg_path . 'grey-sandbag.png',
                $bg_path . 'kinda-jean.png',
                $bg_path . 'polyester-lite.png',
                $bg_path . 'stitched-wool.png',
                $bg_path . 'white-carbon.png',
                $bg_path . 'white-wave.png'
            ),
            'fonts' => array(
                $font_path . 'times_new_yorker.ttf'
            ),
            'characters' => 'ABCDEFGHJKLMNPRSTUVWXYZabcdefghjkmnprstuvwxyz23456789',
            'min_font_size' => 28,
            'max_font_size' => 28,
            'color' => '#666',
            'angle_min' => 0,
            'angle_max' => 10,
            'shadow' => true,
            'shadow_color' => '#fff',
            'shadow_offset_x' => -1,
            'shadow_offset_y' => 1
        );

        // Overwrite defaults with custom config values
        if (is_array($config)) {
            foreach ($config as $key => $value) $captcha_config[$key] = $value;
        }

        // Restrict certain values
        if ($captcha_config['min_length'] < 1) $captcha_config['min_length'] = 1;
        if ($captcha_config['angle_min'] < 0) $captcha_config['angle_min'] = 0;
        if ($captcha_config['angle_max'] > 10) $captcha_config['angle_max'] = 10;
        if ($captcha_config['angle_max'] < $captcha_config['angle_min']) $captcha_config['angle_max'] = $captcha_config['angle_min'];
        if ($captcha_config['min_font_size'] < 10) $captcha_config['min_font_size'] = 10;
        if ($captcha_config['max_font_size'] < $captcha_config['min_font_size']) $captcha_config['max_font_size'] = $captcha_config['min_font_size'];

        // Generate CAPTCHA code if not set by user
        if (empty($captcha_config['code'])) {
            $captcha_config['code'] = '';
            $length = mt_rand($captcha_config['min_length'], $captcha_config['max_length']);
            while (strlen($captcha_config['code']) < $length) {
                $captcha_config['code'] .= substr($captcha_config['characters'], mt_rand() % (strlen($captcha_config['characters'])), 1);
            }
        }

        $this->session->set_userdata('captcha_config', $captcha_config);

        return array(
            'code' => $captcha_config['code'],
            'image_src' => site_url('account/captcha_image') . '?_CAPTCHA&amp;t=' . urlencode(microtime())
        );
    }

    /**
     * @param $captcha_code
     * @return bool
     */
    function _check_captcha($captcha_code)
    {
        $captcha_code_in_session = $this->session->userdata('captcha_code');
        if ($captcha_code_in_session != $captcha_code) {
            $this->form_validation->set_message('_check_captcha', 'Captcha Mismatch');
            return false;
        }
        return true;
    }

    /**
     * @throws Exception
     */
    function captcha_image()
    {
        // Draw the image
        if ($this->input->get('_CAPTCHA') == "") {
            $captcha_config = $this->session->userdata('captcha_config');
            if (!$captcha_config) exit();

            // Pick random background, get info, and start captcha
            $background = $captcha_config['backgrounds'][mt_rand(0, count($captcha_config['backgrounds']) - 1)];
            list($bg_width, $bg_height, $bg_type, $bg_attr) = getimagesize($background);

            $captcha = imagecreatefrompng($background);

            $color = hex2rgb($captcha_config['color']);
            $color = imagecolorallocate($captcha, $color['r'], $color['g'], $color['b']);

            // Determine text angle
            $angle = mt_rand($captcha_config['angle_min'], $captcha_config['angle_max']) * (mt_rand(0, 1) == 1 ? -1 : 1);

            // Select font randomly
            $font = $captcha_config['fonts'][mt_rand(0, count($captcha_config['fonts']) - 1)];

            // Verify font file exists
            if (!file_exists($font)) throw new Exception('Font file not found: ' . $font);

            //Set the font size.
            $font_size = mt_rand($captcha_config['min_font_size'], $captcha_config['max_font_size']);
            $text_box_size = imagettfbbox($font_size, $angle, $font, $captcha_config['code']);

            // Determine text position
            $box_width = abs($text_box_size[6] - $text_box_size[2]);
            $box_height = abs($text_box_size[5] - $text_box_size[1]);
            $text_pos_x_min = 0;
            $text_pos_x_max = ($bg_width) - ($box_width);
            $text_pos_x = mt_rand($text_pos_x_min, $text_pos_x_max);
            $text_pos_y_min = $box_height;
            $text_pos_y_max = ($bg_height) - ($box_height / 2);
            if ($text_pos_y_min > $text_pos_y_max) {
                $temp_text_pos_y = $text_pos_y_min;
                $text_pos_y_min = $text_pos_y_max;
                $text_pos_y_max = $temp_text_pos_y;
            }
            $text_pos_y = mt_rand($text_pos_y_min, $text_pos_y_max);

            // Draw shadow
            if ($captcha_config['shadow']) {
                $shadow_color = hex2rgb($captcha_config['shadow_color']);
                $shadow_color = imagecolorallocate($captcha, $shadow_color['r'], $shadow_color['g'], $shadow_color['b']);
                imagettftext($captcha, $font_size, $angle, $text_pos_x + $captcha_config['shadow_offset_x'], $text_pos_y + $captcha_config['shadow_offset_y'], $shadow_color, $font, $captcha_config['code']);
            }

            // Draw text
            imagettftext($captcha, $font_size, $angle, $text_pos_x, $text_pos_y, $color, $font, $captcha_config['code']);

            // Output image
            header("Content-type: image/png");
            imagepng($captcha);
        }
    }

    /**
     * @return string
     */
    function getOS()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $os_platform = "Unknown OS Platform";

        $os_array = array(
            '/windows nt 6.2/i' => 'Windows 8',
            '/windows nt 6.1/i' => 'Windows 7',
            '/windows nt 6.0/i' => 'Windows Vista',
            '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i' => 'Windows XP',
            '/windows xp/i' => 'Windows XP',
            '/windows nt 5.0/i' => 'Windows 2000',
            '/windows me/i' => 'Windows ME',
            '/win98/i' => 'Windows 98',
            '/win95/i' => 'Windows 95',
            '/win16/i' => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i' => 'Mac OS 9',
            '/linux/i' => 'Linux',
            '/ubuntu/i' => 'Ubuntu',
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile'
        );

        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $os_platform = $value;
            }
        }

        return $os_platform;
    }

    /**
     * @return string
     */
    function getBrowser()
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $browser = "Unknown Browser";

        $browser_array = array(
            '/msie/i' => 'Internet Explorer',
            '/firefox/i' => 'Firefox',
            '/safari/i' => 'Safari',
            '/chrome/i' => 'Chrome',
            '/opera/i' => 'Opera',
            '/netscape/i' => 'Netscape',
            '/maxthon/i' => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
            '/mobile/i' => 'Handheld Browser'
        );

        foreach ($browser_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) {
                $browser = $value;
            }
        }

        return $browser;
    }

    /**
     * @return string
     */
    function getIp()
    {
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }

    /**
     * @return void
     */
    function forgot_password()
    {
        load_lang('enduser/forgot');

        $this->add_css([
            'application/css/css/login.css'
        ]);

        $this->load->model('email_model');

        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        // Get Form Data - Forgot Password
        if ($this->input->post('submit')) {
            // Set rules
            $this->form_validation->set_rules('email', 'lang:Email', 'required|trim|valid_email|xss_clean|callback_find_email');

            if ($this->form_validation->run()) {
                $user_id = $this->user_id;

                // Generate activation key
                $activation_key = md5(time());
                $this->user_model->update_user(['id' => $user_id, 'activation_key' => $activation_key]);

                // Send mail
                try {
                    $this->email_model->prepare(
                        'forgot_password',
                        $user_id,
                        [
                            '!username' => $this->user_model->get_name($user_id),
                            '!url' => site_url('account/reset_password?key=' . $activation_key),
                            "!site_title" => $this->config->item('site_title'),
                            "!contact_url" => site_url('home/support')
                        ],
                        TRUE
                    );
                    /*Flash*/
                    $success_msg = t('Please follow instructions sent to your e-mail.');
                    $this->notify->set($success_msg, Notify::SUCCESS);
                    /*End Flash*/
                    redirect('account/forgot_password');
                } catch (Exception $e) {
                    $this->notify->set($e->getMessage(), Notify::ERROR);
                }
            }
        }

        $this->load->view('account/forgot', $this->outputData);
    }

    /**
     * @return void
     */
    function reset_password()
    {
        $this->add_css([
            'application/css/css/login.css'
        ]);

        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        $activation_key = $this->input->get('key');
        if (!isset($activation_key)) {
            $activation_key = $this->input->post('activation_key');
        }
        $this->outputData['activation_key'] = $activation_key;

        $user = $this->user_model->getUsers(['users.activation_key' => $activation_key])->row();
        if (isset($activation_key) and isset($user)) {
            $this->outputData['user_name'] = $user->user_name;
            if ($this->input->post('submit')) {
                $this->form_validation->set_rules('password', t('Password'), 'required|trim|min_length[5]|max_length[16]|xss_clean');
                $this->form_validation->set_rules('repeat_password', t('Repeat Password'), 'required|trim|xss_clean|matches[password]');

                if ($this->form_validation->run()) {
                    $this->user_model->update_user([
                        'id' => $user->id,
                        'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                        'activation_key' => NULL
                    ]);
                    /*Flash*/
                    $success_msg = t('Your password was successfully changed');
                    $this->notify->set($success_msg, Notify::SUCCESS);
                    /*End Flash*/
                    redirect('account/login');
                }
            }
        } else {
            /*Flash*/
            $success_msg = t('Incorrect activation key');
            $this->notify->set($success_msg, Notify::ERROR);
            /*End Flash*/
        }

        $this->load->view('account/reset', $this->outputData);
    }

    /**
     * Find user by email
     *
     * @param $field
     * @return bool
     */
    function find_email($field)
    {
        $user = $this->user_model->getUsers(['users.email' => $field])->row();
        // Check if user exists
        if (isset($user)) {
            $this->user_id = $user->id;
            return TRUE;
        } else {
            $this->form_validation->set_message('find_email', t('User with this email is not registered.'));
            return FALSE;
        }
    }

    function feedback()
    {
        $this->load->library('user_agent');
        $this->load->model('support_model');

        $insertFeedback = array();

        $insertFeedback['user_id'] = $this->logged_in_user->id;
        $insertFeedback['memo_text'] = $this->input->post('message', TRUE);
        $insertFeedback['browser'] = $this->agent->browser() . '-' . $this->agent->version();
        $insertFeedback['feedback_type'] = $this->input->post('radio_list_value', TRUE);
        $insertFeedback['language'] = $this->config->item('language');
        $insertFeedback['geo_location'] = $this->input->ip_address();
        $insertFeedback['page_reference'] = $this->input->post('current_url', TRUE);

        $this->support_model->feedback($insertFeedback);
    }

    function findUserByNameOrEmail()
    {
        if ($this->input->is_ajax_request() && !empty($name = $this->input->post('name')) && !empty($type = $this->input->post('type'))) {
            $datas = $this->user_model->findUserByNameOrEmail($name, $this->logged_in_user->id, $type);
            echo response($datas);
            return;
        }
        echo response('Error', true);
        return;

    }

    function notify()
    {
        if ($this->input->is_ajax_request()) {
            $this->load->model('notification_model');
            $id = $this->input->post('id');
            $this->notification_model->set_notified($id);
            echo response(NULL);
        }
    }

    function crop_image() {

        if ($this->input->is_ajax_request()) {

            $this->outputData['image_file'] = $this->input->post('image_file');

            echo response([
                'html' => $this->load->view('account/crop_image', $this->outputData, TRUE),
            ]);
        }
    }
}