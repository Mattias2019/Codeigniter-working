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


class Users extends My_Controller
{

    //Constructor

    function __construct()
    {
        parent::__construct();

        $this->load->library('settings');
        $this->load->library('session');

        //Get Config Details From Db
        $this->settings->db_config_fetch();

        // loading the lang files
        load_lang(array(
            'admin/common',
            'admin/setting',
            'admin/validation',
            'admin/login'));

        //Load Models
        $this->load->model('common_model');
        $this->load->model('country_model');
        $this->load->model('ban_model');
        $this->outputData['login'] = 'TRUE';

        //Get Logged In user
        $this->logged_in_user = $this->common_model->get_logged_in_user();
        $this->outputData['logged_in_user'] = $this->logged_in_user;

    } //Controller End

    // --------------------------------------------------------------------

    /**
     * Loads site settings page.
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function index()
    {
        redirect_admin('users');

    }//End of index Function

    /**
     * Add bans for users
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function addBan()
    {
        //load validation library
        $this->load->library('form_validation');

        //Load Form Helper
        $this->load->helper('form');

        //Intialize values for library and helpers
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        if ($this->input->post('addBan')) {

            //Set rules


            if ($this->input->post('type') == 'EMAIL')
                $this->form_validation->set_rules('value', 'lang:ban_value_validation', 'required|trim|valid_email|xss_clean|callback__check_email|callback__check_email_ban ');


            if ($this->input->post('type') == 'USERNAME')
                $this->form_validation->set_rules('value', 'lang:ban_value_validation', 'required|trim|xss_clean|callback__check_email|callback__check_username_ban');


            if ($this->form_validation->run()) {
                $insertData = array();
                $insertData['ban_type'] = $this->input->post('type');
                $insertData['ban_value'] = $this->input->post('value');
                $insertData['ban_time'] = get_est_time();
                if (strtolower($insertData['ban_type']) == 'email') {
                    $condition = array('users.email' => $insertData['ban_value']);
                    $user = $this->user_model->getUsers($condition);
                    $type = $insertData['ban_type'];
                }
                if (strtolower($insertData['ban_type']) == 'username') {
                    $condition = array('users.user_name' => $insertData['ban_value']);
                    $user = $this->user_model->getUsers($condition);
                    $type = $insertData['ban_type'];
                }
                if (isset($user) and count($user->result()) > 0) {
                    $user = $user->row();
                    $conditionUserMail = array('email_templates.type' => 'email_banned');
                    $this->load->model('email_model');
                    $result = $this->email_model->getEmailSettings($conditionUserMail);
                    $rowUserMailConent = $result->row();
                    //echo $records;
                    //Update the details
                    $splVars = array("!username" => $user->user_name, "!contact_url" => site_url('contact'), "!site_url" => site_url(), "!type" => $type, '!site_name' => $this->config->item('site_title'));
                    //pr($splVars);
                    $mailSubject = strtr($rowUserMailConent->mail_subject, $splVars);
                    $mailContent = strtr($rowUserMailConent->mail_body, $splVars);
                    $toEmail = $user->email;
                    $fromEmail = $this->config->item('site_admin_mail');
                    $mailContent;
                    $this->email_model->sendHtmlMail($toEmail, $fromEmail, $mailSubject, $mailContent);
                }
                //Insert bans
                $this->user_model->insertBan($insertData);

                if (strtolower($insertData['ban_type']) == 'username') {
                    $condition = array('users.user_name' => $insertData['ban_value']);
                    $data = array('users.ban_status' => '1');
                    $this->common_model->updateTableData('users', NULL, $data, $condition);
                } else if (strtolower($insertData['ban_type']) == 'email') {
                    $condition = array('users.email' => $insertData['ban_value']);
                    $data = array('users.ban_status' => '1');
                    $this->common_model->updateTableData('users', NULL, $data, $condition);
                }

                //Notification message
                $this->notify->set(t('added_success'), Notify::SUCCESS);
                redirect_admin('users/editBans');
            }
        }
        $this->load->view('admin/users/viewAddBan', $this->outputData);
    }//End of addBans Function

    /**
     * Edit bans for users
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function viewBans()
    {
        $this->add_js([
            'application/js/admin/view_bans.js',
            'application/js/pagination.js'
        ]);

        $this->init_js(["view_bans.init('" . admin_url() . "');"]);

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
        $limit = [$page_rows, ($page - 1) * $page_rows];

        // Get Sorting order
        if ($this->input->post('field')) {
            $field = $this->input->post('field');
        } else {
            $field = 'id';
        }
        if ($this->input->post('order')) {
            $order = $this->input->post('order');
        } else {
            $order = 'ASC';
        }
        $orderby = [$field, $order];

        $total_rows = $this->user_model->countBans()->row()->count;

        //Get Groups
        $banDetails = $this->user_model->getBansuser(NULL, NULL, NULL, $limit, $orderby);
        $this->outputData['banDetails'] = $banDetails;

        //Pagination
        $this->load->library('pagination');

        $this->outputData['pagination'] = get_pagination(admin_url('users/viewBans/'), $total_rows, $page_rows, $page);

        if ($this->input->is_ajax_request()) {
            if ($this->input->post('table_only') == 'true') {
                echo response([
                    'type' => 'table',
                    'data' => $this->load->view('admin/users/viewBansTableBody', $this->outputData, TRUE),
                    'pagination' => $this->outputData['pagination']
                ]);
            } else {
                echo response([
                    'type' => 'all',
                    'data' => $this->load->view('admin/users/viewBansTable', $this->outputData, TRUE),
                    'pagination' => $this->outputData['pagination']
                ]);
            }
        } else {
            $this->load->view('admin/users/view_bans', $this->outputData);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Edit bans for users
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function viewBan()
    {

        //load validation library
        $this->load->library('form_validation');

        //Load Form Helper
        $this->load->helper('form');

        //Intialize values for library and helpers
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        if ($this->input->post('addBan')) {
            //Set rules
            if ($this->input->post('type') == 'EMAIL')
                $this->form_validation->set_rules('value', 'lang:ban_value_validation', 'required|trim|valid_email|xss_clean|callback__check_email|callback__check_email_ban ');


            if ($this->input->post('type') == 'USERNAME')
                $this->form_validation->set_rules('value', 'lang:ban_value_validation', 'required|trim|xss_clean|callback__check_email|callback__check_username_ban');


            if ($this->form_validation->run()) {
                $updateData = array();
                $updateData['ban_type'] = $this->input->post('type', true);
                $updateData['ban_value'] = $this->input->post('value', true);

                $condition = array('bans.id' => $this->input->post('banid', true));

                $suspend_before_update = $this->common_model->getTableData('bans', $condition, 'ban_value');
                $suspend_before_update = $suspend_before_update->row();
                $sus_value_before = $suspend_before_update->ban_value;


                $updateKey = array('bans.id' => $this->input->post('banid', true));

                //pr($updateKey);exit;
                //Insert bans
                $this->user_model->updateBan($updateKey, $updateData);

                if (strtolower($updateData['ban_type']) == 'username') {

                    $condition = array('users.user_name' => $sus_value_before);
                    $data = array('users.ban_status' => '0');
                    $this->common_model->updateTableData('users', NULL, $data, $condition);

                    $condition = array('users.user_name' => $updateData['ban_value']);
                    $data = array('users.ban_status' => '1');
                    $this->common_model->updateTableData('users', NULL, $data, $condition);

                } else if (strtolower($updateData['ban_type']) == 'email') {

                    $condition = array('users.email' => $sus_value_before);
                    $data = array('users.ban_status' => '0');
                    $this->common_model->updateTableData('users', NULL, $data, $condition);

                    $condition = array('users.email' => $updateData['ban_value']);
                    $data = array('users.ban_status' => '1');
                    $this->common_model->updateTableData('users', NULL, $data, $condition);

                }


                //Notification message
                $this->notify->set(t('updated_success'), Notify::SUCCESS);
                redirect_admin('users/editBans');
            }
        }
        $banid = $this->uri->segment(4, '0');
        $condition = array('bans.id' => $banid);
        $bans = $this->user_model->getBans($condition);
        $this->outputData['banDetails'] = $bans->row();
        //pr($bans->num_rows());exit;
        $this->load->view('admin/users/view_ban', $this->outputData);
    }//End of addBans Function

    // --------------------------------------------------------------------

    /**
     * Add users
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function addUser()
    {
        $this->add_css([
            'application/css/admin/bootstrap-switch.min.css'
        ]);

        $this->add_js([
            'application/js/tmpl-js/bootstrap-switch.min.js',
            'application/js/admin/add_user.js'
        ]);

        //load validation library
        $this->load->library('form_validation');

        //Load Form Helper
        $this->load->helper('form');

        //Intialize values for library and helpers
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        if ($this->input->post()) {
            //Set rules
            $this->form_validation->set_rules('first_name', 'lang:username_validation', 'required|trim|xss_clean|callback__check_username');
            $this->form_validation->set_rules('last_name', 'lang:username_validation', 'required|trim|xss_clean|callback__check_username');
            $this->form_validation->set_rules('username', 'lang:username_validation', 'required|trim|xss_clean|callback__check_username');
            $this->form_validation->set_rules('password', 'lang:password_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('role_id', 'lang:role_validation', 'required');
            $this->form_validation->set_rules('email', 'lang:email_validation', 'required|trim|valid_email|xss_clean|callback__check_email');
            $this->form_validation->set_rules('company_name', 'lang:name_validation', 'required|trim|xss_clean');

            if ($this->form_validation->run()) {
                $insertData = array();

                $insertData['first_name'] = $this->input->post('first_name');
                $insertData['last_name'] = $this->input->post('last_name');
                $insertData['user_name'] = $this->input->post('username');
                $insertData['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
                $insertData['email'] = $this->input->post('email');
                $insertData['name'] = $this->input->post('company_name');
                $insertData['role_id'] = $this->input->post('role_id');
                $insertData['created'] = get_est_time();
                $insertData['user_status'] = '1'; // TODO: create a constant

                //Insert User
                $this->user_model->createUser($insertData);

                //Create user balance
                $insertBalance['user_id'] = $this->db->insert_id();
                $insertBalance['amount'] = '0';
                $this->user_model->createUserBalance($insertBalance);

                //Notification message
                $this->notify->set(t('added_success'), Notify::SUCCESS);

                redirect_admin('users/viewUsers');
            } else {
                $this->data['error'] = true; //Triggers the jQuery error callback
                $this->data['message'] = validation_errors();
            }
        }

        $this->outputData['userRoles'] = $this->user_model->getRoles();

        $this->load->view('admin/users/view_addUsers', $this->outputData);
    }

    // --------------------------------------------------------------------

    /**
     * View users
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function viewUsers()
    {
        $this->add_js([
            'application/js/admin/view_users.js',
            'application/js/pagination.js'
        ]);

        $this->init_js(["view_users.init('" . admin_url() . "');"]);

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
        $limit = [$page_rows, ($page - 1) * $page_rows];

        // Get Sorting order
        if ($this->input->post('field')) {
            $field = $this->input->post('field');
        } else {
            $field = 'users.id';
        }
        if ($this->input->post('order')) {
            $order = $this->input->post('order');
        } else {
            $order = 'ASC';
        }
        $orderby = [$field, $order];

        // Segment
        if ($this->input->is_ajax_request()) {
            $segment = $this->input->post('segment');
        } else {
            $segment = $this->uri->segment(3, 0);
        }

        // filter
        $username = null;
        $role_id = null;

        $post = $this->input->post();

        if (isset($post['username'])) {
            $username = $this->input->post('username');
        } elseif (isset($_SESSION["view_users_filter"]["username"])) {
            $username = $_SESSION["view_users_filter"]["username"];
        }

        if (isset($post['role_id'])) {
            $role_id = $this->input->post('role_id');
        } elseif (isset($_SESSION["view_users_filter"]["role_id"])) {
            $role_id = $_SESSION["view_users_filter"]["role_id"];
        }

        $_SESSION["view_users_filter"] =
            array(
                "username" => $username,
                "role_id" => $role_id
            );

        $like = array();
        if (isset($username) && $username != "") {
            $like = array('users.first_name' => $username,
                'users.last_name' => $username,
                'users.user_name' => $username
            );
        }
        $where = array();
        if (isset($role_id) && $role_id != "") {
            $where = array('users.role_id' => $role_id);
        }

        //Get Groups
        $users = $this->user_model->getUsers_balance($where, '', $like, $limit, $orderby);

        $this->outputData['userDetails'] = $users;

        $this->outputData['countUsers'] = $this->user_model->countUsers(NULL, NULL);

        $this->outputData['countOnlineUsers'] = $this->user_model->count_online_users(NULL);
        $this->outputData['countOnlineEntrepreneur'] = $this->user_model->count_online_users(ROLE_ENTREPRENEUR);
        $this->outputData['countOnlineProvider'] = $this->user_model->count_online_users(ROLE_PROVIDER);

        $this->outputData['view_users_filter'] = $_SESSION["view_users_filter"];

        $this->outputData['roles'] = $this->user_model->getRoles();

        $total_rows = $this->user_model->countUsers($where, $like)->row()->count;

        //Pagination
        $this->load->library('pagination');

        $this->outputData['pagination'] = get_pagination(admin_url('users/viewUsers/'), $total_rows, $page_rows, $page);

        if ($this->input->is_ajax_request()) {
            if ($this->input->post('table_only') == 'true') {
                echo response([
                    'type' => 'table',
                    'data' => $this->load->view('admin/users/view_usersTableBody', $this->outputData, TRUE),
                    'pagination' => $this->outputData['pagination']
                ]);
            } else {
                echo response([
                    'type' => 'all',
                    'data' => $this->load->view('admin/users/view_usersTable', $this->outputData, TRUE),
                    'pagination' => $this->outputData['pagination']
                ]);
//                echo response([
//                    'html' => $this->load->view('admin/users/view_usersTable',$this->outputData,TRUE),
//                    'pagination' => $this->outputData['pagination']
//                ]);
            }
        } else {
            $this->load->view('admin/users/view_users', $this->outputData);
        }
    }

    function resetSearchFilter() {
        if ($this->input->is_ajax_request()) {
            $_SESSION["view_users_filter"] = array();
        }
        echo response([
            'error' => false,
            'message' => ''
        ]);
    }

    function owner()
    {

        $condition = array('users.role_id' => 1);
        $userDetail = $this->user_model->getUsers_bal($condition);
        $start = $this->uri->segment(4, 0);
        //Get the inbox mail list
        $page_rows = $this->config->item('mail_limit');

        $limit[0] = $page_rows;
        if ($start > 0)
            $limit[1] = ($start - 1) * $page_rows;
        else
            $limit[1] = $start * $page_rows;

        $order[0] = 'id';
        $order[1] = 'asc';

        //Get Groups
        $userbalance = $this->user_model->getUsers_balance($condition, NULL, NULL, $limit, $order);
        $this->outputData['userDetails'] = $userbalance;

        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = admin_url('users/owner');
        $config['total_rows'] = $userDetail->num_rows();
        $config['per_page'] = $page_rows;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $this->outputData['pagination'] = $this->pagination->create_links2(false, 'owner');

        $this->load->view('admin/users/view_users', $this->outputData);

    }

    function employee()
    {

        $condition = array('users.role_id' => 2);
        $userDetail = $this->user_model->getUsers_bal($condition);
        $start = $this->uri->segment(4, 0);
        //Get the inbox mail list
        $page_rows = $this->config->item('mail_limit');

        $limit[0] = $page_rows;
        if ($start > 0)
            $limit[1] = ($start - 1) * $page_rows;
        else
            $limit[1] = $start * $page_rows;

        $order[0] = 'id';
        $order[1] = 'asc';

        //Get Groups
        $userbalance = $this->user_model->getUsers_balance($condition, NULL, NULL, $limit, $order);
        $this->outputData['userDetails'] = $userbalance;

        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = admin_url('users/employee');
        $config['total_rows'] = $userDetail->num_rows();
        $config['per_page'] = $page_rows;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $this->outputData['pagination'] = $this->pagination->create_links2(false, 'employee');

        $this->load->view('admin/users/view_users', $this->outputData);

    }

    function userDetails()
    {
        $uid = $this->uri->segment(4, 0);
        $condition = array('users.id' => $uid);
        $this->outputData['userDetails'] = $this->user_model->getUsers_balance($condition, NULL, NULL);
        $this->load->view('admin/users/view_users', $this->outputData);
    }

    /**
     * edit user
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function editUser()
    {

        $this->add_css([
            'application/css/admin/bootstrap-switch.min.css'
        ]);

        $this->add_js([
            'application/js/tmpl-js/bootstrap-switch.min.js',
            'application/js/admin/edit_user.js'
        ]);

        $result['messaage'] = '';
        $result['error'] = false;

        //load validation library
        $this->load->library('form_validation');
        //Load Form Helper
        $this->load->helper('form');
        //Intialize values for library and helpers
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        if ($this->input->post()) {
            //Set rules
            $this->form_validation->set_rules('username', 'lang:username_validation', 'required|trim|xss_clean|callback__check_username');

            if ($this->input->post('password') != "") {
                $this->form_validation->set_rules('password', 'lang:password_validation', 'required|trim|min_length[5]|max_length[16]|xss_clean');
            }

            $this->form_validation->set_rules('role_id', 'lang:role_validation', 'required');
            $this->form_validation->set_rules('email', 'lang:email_validation', 'required|trim|valid_email|xss_clean|callback__check_email');
            $this->form_validation->set_rules('company_name', 'lang:name_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('balance', 'lang:balamount_validation', 'required|trim|xss_clean|numeric|abs|is_natural');

            if ($this->form_validation->run()) {

                $updateData = array();

                $updateData['user_name'] = $this->input->post('username');

                if ($this->input->post('password') != "") {
                    $updateData['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
                } else {
                    $updateData['password'] = $this->input->post('passwordold');
                }

                $updateData['email'] = $this->input->post('email');
                $updateData['name'] = $this->input->post('company_name');
                $updateData['role_id'] = $this->input->post('role_id');
                $balamount = $this->input->post('balance');
                $updateData['last_activity'] = get_est_time();

                // extended
                $country_id = $this->input->post('country_id');
                if (isset($country_id) && ($country_id != '')) {
                    $updateData['country_id'] = $country_id;
                }
                $updateData['state'] = $this->input->post('state');
                $updateData['city'] = $this->input->post('city');
                $updateData['rate'] = $this->input->post('rate') ? $this->input->post('rate') : null;
                $updateData['user_rating'] = $this->input->post('user_rating') ? $this->input->post('user_rating') : 0;
                $updateData['num_reviews'] = $this->input->post('num_reviews') ? $this->input->post('num_reviews') : null;
                $updateData['rating_hold'] = $this->input->post('rating_hold') ? $this->input->post('rating_hold') : null;
                $updateData['tot_rating'] = $this->input->post('tot_rating') ? $this->input->post('tot_rating') : null;
                //$updateData['refid'] = $this->input->post('refid') ? $this->input->post('refid') : null;

                $updateKey = array('users.id' => $this->input->post('user_id', true));

                //Edit user
                $this->user_model->updateUser($updateKey, $updateData);

                $result = $this->common_model->save('user_balance',
                    $this->input->post('user_id', true),
                    array('user_id' => $this->input->post('user_id', true), 'amount' => $balamount),
                    array('amount' => $balamount)
                );

                if ($result) {
                    //Notification message
                    $this->notify->set(t('updated_success'), Notify::SUCCESS);

//                      $this->data['error'] = false; //Triggers the jQuery error callback
//                      $this->data['message'] = '';
//
//                      $this->output->set_output(json_encode($this->data));
//
//                      $toast = array('toast' array('type' => 'success',
//                                                      'title' => 'Congratulation',
//                                                      'message' => 'User updated successfully'
//                      ));
//
//                      $this->session->set_userdata($toast);

                    redirect_admin('users/viewUsers');
                } else {
                    // error
                }
            } else {
                $this->data['error'] = true; //Triggers the jQuery error callback
                $this->data['message'] = validation_errors();
            }
        }

        $userid = $this->uri->segment(3, '0');
        $condition = null;
//        if ($userid != 0) {
        $condition = array('users.id' => $userid);
//        }
        $this->outputData['userDetails'] = $this->user_model->getUsers_bal($condition);
        $this->outputData['userRoles'] = $this->user_model->getRoles();
        $this->outputData['countries'] = $this->country_model->getCountries();

        if ($this->input->is_ajax_request()) {
            echo response([
                'error' => false,
                'html' => $this->load->view('admin/users/view_editUsers', $this->outputData, TRUE)
            ]);
        } else {
            $this->load->view('admin/users/view_editUsers', $this->outputData);
        }
    }

    /**
     * Delete user
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function deleteUser()
    {

        $userid = $this->uri->segment(3, '0');

        if ($userid == 0) {

            $userlist = $this->input->post('userlist');

            if (!empty($userlist)) {

                foreach ($userlist as $res) {

                    $condition = array('users.id' => $res);
                    $this->user_model->deleteUser(NULL, $condition);

                    $condition = array('bookmark.creator_id' => $res);
                    $this->user_model->deleteBookmark(NULL, $condition);

                    $condition = array('files.user_id' => $res);
                    $this->user_model->deleteFile(NULL, $condition);

                    $condition = array('user_balance.user_id' => $res);
                    $this->user_model->deleteBalance(NULL, $condition);

                    $condition = array('user_categories.user_id' => $res);
                    $this->user_model->deleteCategory(NULL, $condition);

                    $condition = array('user_contacts.user_id' => $res);
                    $this->user_model->deleteContact(NULL, $condition);

                    $condition = array('subscriptionuser.user_id' => $res);
                    $this->user_model->deleteSubscription(NULL, $condition);

                    $condition = array('user_list.user_id' => $res);
                    $this->user_model->deleteUserlist(NULL, $condition);
                }
            } else {
                $this->notify->set(t('Please select the Users'), Notify::ERROR);
            }
        } else {

            $condition = array('users.id' => $userid);
            $this->user_model->deleteUser(NULL, $condition);

            $condition = array('bookmark.id' => $userid);
            $this->user_model->deleteBookmark(NULL, $condition);

            $condition = array('files.user_id' => $userid);
            $this->user_model->deleteFile(NULL, $condition);

            $condition = array('user_balance.user_id' => $userid);
            $this->user_model->deleteBalance(NULL, $condition);

            $condition = array('user_categories.user_id' => $userid);
            $this->user_model->deleteCategory(NULL, $condition);

            $condition = array('user_contacts.user_id' => $userid);
            $this->user_model->deleteContact(NULL, $condition);

            $condition = array('subscriptionuser.user_id' => $userid);
            $this->user_model->deleteSubscription(NULL, $condition);

            $condition = array('user_list.user_id' => $userid);
            $this->user_model->deleteUserlist(NULL, $condition);
        }

        //Notification message
        $this->notify->set(t('deleted_success'), Notify::SUCCESS);

        echo response([
            'error' => false,
            'message' => ''
        ]);

    }

    // --------------------------------------------------------------------
    function _check_username($username)
    {
        $role_id = $this->input->post('type');

        //Conditions
        if ($this->input->post('userid'))
            $conditions = array('users.user_name' => $username, 'users.role_id' => $role_id, 'users.id !=' => $this->input->post('userid'));
        else
            $conditions = array('users.user_name' => $username, 'users.role_id' => $role_id);
        //pr($conditions);exit;
        $result = $this->user_model->getUsers($conditions);

        $conditions2 = array('bans.ban_value' => $username, 'ban_types.type' => 'USERNAME');
        $result2 = $this->user_model->getBans($conditions2);

        if ($result->num_rows() == 0 && $result2->num_rows() == 0) {
            return true;

        } else {

            $this->form_validation->set_message('_check_username', t('username_check'));

            return false;

        }
    }

    // --------------------------------------------------------------------

    /**
     * Check for employee mail id
     *
     * @access    public
     * @param    nil
     * @return    void
     */

    function _check_email($mail)
    {
        //Get Role Id For Buyers

        $role_id = $this->input->post('type');
        //echo $this->input->post('userid');

        //Conditions
        if ($this->input->post('userid'))
            $conditions = array('users.email' => $mail, 'users.role_id' => $role_id, 'users.id !=' => $this->input->post('userid'));
        else
            $conditions = array('users.email' => $mail, 'users.role_id' => $role_id);
        //pr($conditions);exit;
        $result = $this->user_model->getUsers($conditions);

        $conditions2 = array('bans.ban_value' => $mail, 'bans.ban_type_id' => EMAIL);
        $result2 = $this->user_model->getBans($conditions2);
        //pr($result->row());exit;
        if ($result->num_rows() == 0 && $result2->num_rows() == 0) {
            return true;

        } else {

            $this->form_validation->set_message('_check_email', t('email_check'));

            return false;

        }//If end

    }//Function  _check_usernam End

    function addSuspend()
    {
        $this->load->library('form_validation');

        //Load Form Helper
        $this->load->helper('form');

        //Intialize values for library and helpers
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));


        if ($this->input->post('addBan')) {

            if ($this->input->post('type') == 'EMAIL')
                $this->form_validation->set_rules('value', 'lang:Suspend Value', 'required|trim|xss_clean|callback__check_email|callback__check_email_suspend');

            if ($this->input->post('type') == 'USERNAME')
                $this->form_validation->set_rules('value', 'lang:Suspend Value', 'required|trim|xss_clean|callback__check_email|callback__check_username_suspend');

            if ($this->form_validation->run()) {
                $insertData = array();
                $insertData['suspend_type'] = $this->input->post('type');
                $insertData['suspend_value'] = $this->input->post('value');
                $insertData['suspend_time'] = get_est_time();

                if (strtolower($insertData['suspend_type']) == 'email') {
                    $condition = array('users.email' => $insertData['suspend_value']);
                    $user = $this->user_model->getUsers($condition);
                    $type = $insertData['suspend_type'];
                }
                if (strtolower($insertData['suspend_type']) == 'username') {
                    $condition = array('users.user_name' => $insertData['suspend_value']);
                    $user = $this->user_model->getUsers($condition);
                    $type = $insertData['suspend_type'];
                }

                if (isset($user) and count($user->result()) > 0) {
                    $user = $user->row();
                    $conditionUserMail = array('email_templates.type' => 'email_suspended');
                    $this->load->model('email_model');
                    $result = $this->email_model->getEmailSettings($conditionUserMail);
                    $rowUserMailConent = $result->row();
                    //echo $records;
                    //Update the details
                    $splVars = array("!username" => $user->user_name, "!contact_url" => site_url('contact'), "!site_url" => site_url(), "!type" => $type, '!site_name' => $this->config->item('site_title'));
                    //pr($splVars);
                    $mailSubject = strtr($rowUserMailConent->mail_subject, $splVars);
                    $mailContent = strtr($rowUserMailConent->mail_body, $splVars);
                    $toEmail = $user->email;
                    $fromEmail = $this->config->item('site_admin_mail');
                    $mailContent;
                    $this->email_model->sendHtmlMail($toEmail, $fromEmail, $mailSubject, $mailContent);
                }


                $stat = $this->common_model->insertData('suspend', $insertData);

                if (strtolower($insertData['suspend_type']) == 'username') {
                    $condition = array('users.user_name' => $insertData['suspend_value']);
                    $data = array('users.suspend_status' => '1');
                    $this->common_model->updateTableData('users', NULL, $data, $condition);
                } else if (strtolower($insertData['suspend_type']) == 'email') {
                    $condition = array('users.email' => $insertData['suspend_value']);
                    $data = array('users.suspend_status' => '1');
                    $this->common_model->updateTableData('users', NULL, $data, $condition);
                }


                $this->notify->set(t('added_success'), Notify::SUCCESS);
                redirect_admin('users/editSuspend');

            }


        }
        $this->load->view('admin/users/view_addSuspend', $this->outputData);
    }


    function editSuspend()
    {

        //load validation library
        $this->load->library('form_validation');

        //Load Form Helper
        $this->load->helper('form');

        //Intialize values for library and helpers
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        //Get Groups
        $getsuspend = $this->user_model->getSuspend();

        $start = $this->uri->segment(4, 0);
        //Get the inbox mail list
        $page_rows = $this->config->item('mail_limit');

        $limit[0] = $page_rows;
        if ($start > 0)
            $limit[1] = ($start - 1) * $page_rows;
        else
            $limit[1] = $start * $page_rows;

        $order[0] = 'id';
        $order[1] = 'asc';

        //Get Groups
        $suspenduser = $this->user_model->getSuspenduser(NULL, NULL, NULL, $limit, $order);
        $this->outputData['suspend'] = $suspenduser;

        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = admin_url('users/editSuspend');
        $config['total_rows'] = $getsuspend->num_rows();
        $config['per_page'] = $page_rows;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $this->outputData['pagination'] = $this->pagination->create_links2(false, 'editSuspend');

        //$this->outputData['suspend'] =$this->common_model->getTableData('suspend');

        $this->load->view('admin/users/view_editSuspend', $this->outputData);
    }//End of addBans Function


    function deleteSuspend()
    {


        //pr($condition);exit;
        $this->load->helper('form');
        $userid = $this->uri->segment(4, '0');

        if ($userid == 0) {
            $getsuspend = $this->user_model->getSuspend();
            $suspendlist = $this->input->post('suspendlist');
            if (!empty($suspendlist)) {
                foreach ($suspendlist as $res) {

                    $condition = array('suspend.id' => $res);
                    $fields = array('suspend_value', 'suspend_type');
                    $suspend_before_update = $this->common_model->getTableData('suspend', $condition, $fields);
                    $suspend_before_update = $suspend_before_update->row();

                    if (strtolower($suspend_before_update->suspend_type) == 'username') {

                        $condition = array('users.user_name' => $suspend_before_update->suspend_value);
                        $data = array('users.suspend_status' => '0');
                        $this->common_model->updateTableData('users', NULL, $data, $condition);


                    } else if (strtolower($suspend_before_update->suspend_type) == 'email') {

                        $condition = array('users.email' => $suspend_before_update->suspend_value);
                        $data = array('users.suspend_status' => '0');
                        $this->common_model->updateTableData('users', NULL, $data, $condition);

                    }

                    $condition = array('suspend.id' => $res);
                    $this->user_model->deleteSuspend(NULL, $condition);
                }
            } else {
                $this->notify->set(t('Please select the Users'), Notify::ERROR);
                redirect_admin('users/editSuspend');
            }
        } else {
            $conditions = array('suspend.id' => $userid);
            $this->user_model->deleteSuspend(NULL, $conditions);
        }
        //Notification message
        $this->notify->set(t('deleted_success'), Notify::SUCCESS);
        redirect_admin('users/editSuspend');
    }//End of deleteBan Function


    function viewSuspend()
    {

        //load validation library
        $this->load->library('form_validation');

        //Load Form Helper
        $this->load->helper('form');

        //Intialize values for library and helpers
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        if ($this->input->post('suspend')) {
            //Set rules
            $this->form_validation->set_rules('suspend_value', 'lang:ban_value_validation', 'required|trim|xss_clean');

            if ($this->form_validation->run()) {
                $updateData = array();
                $updateData['suspend_type'] = $this->input->post('type', true);
                $updateData['suspend_value'] = $this->input->post('suspend_value', true);

                $condition = array('suspend.id' => $this->input->post('banid', true));

                $suspend_before_update = $this->common_model->getTableData('suspend', $condition, 'suspend_value');
                $suspend_before_update = $suspend_before_update->row();
                $sus_value_before = $suspend_before_update->suspend_value;

                $updateKey = array('suspend.id' => $this->input->post('banid', true));
                $this->common_model->updateTableData('suspend', NULL, $updateData, $updateKey);


                if (strtolower($updateData['suspend_type']) == 'username') {

                    $condition = array('users.user_name' => $sus_value_before);
                    $data = array('users.suspend_status' => '0');
                    $this->common_model->updateTableData('users', NULL, $data, $condition);

                    $condition = array('users.user_name' => $updateData['suspend_value']);
                    $data = array('users.suspend_status' => '1');
                    $this->common_model->updateTableData('users', NULL, $data, $condition);

                } else if (strtolower($updateData['suspend_type']) == 'email') {

                    $condition = array('users.email' => $sus_value_before);
                    $data = array('users.suspend_status' => '0');
                    $this->common_model->updateTableData('users', NULL, $data, $condition);

                    $condition = array('users.email' => $updateData['suspend_value']);
                    $data = array('users.suspend_status' => '1');
                    $this->common_model->updateTableData('users', NULL, $data, $condition);

                }


                //Notification message
                $this->notify->set(t('updated_success'), Notify::SUCCESS);
                redirect_admin('users/editSuspend');
            }
        }
        $banid = $this->uri->segment(4, '0');
        $condition = array('suspend.id' => $banid);
        $bans = $this->user_model->getSuspend($condition);
        $this->outputData['suspendDetails'] = $bans->row();
        //pr($bans->num_rows());exit;

        $this->load->view('admin/users/viewSuspend', $this->outputData);

    }//End of addBans Function


    function _check_username_suspend($username)
    {

        $conditions = array('suspend_type' => 'USERNAME', 'suspend_value' => $username);
        $result = $this->common_model->getTableData('suspend', $conditions);
        if ($result->num_rows() > 0) {
            $this->form_validation->set_message('_check_username_suspend', t('username_check'));
            return false;

        } else
            return true;

    }

    function _check_username_ban($username)
    {

        $conditions = array('ban_type_id' => USERNAME, 'ban_value' => $username);
        $result = $this->common_model->getTableData('bans', $conditions);
        if ($result->num_rows() > 0) {
            $this->form_validation->set_message('_check_username_ban', t('username_check'));
            return false;

        } else
            return true;

    }

    function _check_email_suspend($mail)
    {
        $conditions = array('suspend_type' => 'EMAIL', 'suspend_value' => $mail);
        $result = $this->common_model->getTableData('suspend', $conditions);
        if ($result->num_rows() > 0) {
            $this->form_validation->set_message('_check_email_suspend', t('email_check'));
            return false;

        } else
            return true;

    }

    function _check_email_ban($mail)
    {
        $conditions = array('ban_type_id' => EMAIL, 'ban_value' => $mail);
        $result = $this->common_model->getTableData('bans', $conditions);
        if ($result->num_rows() > 0) {
            $this->form_validation->set_message('_check_email_ban', t('email_check'));
            return false;

        } else
            return true;
    }

    /**
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function addBanRow()
    {
        if ($this->input->is_ajax_request()) {

//            $condition = array('bans.id' => $banid);
//            $bans = $this->user_model->getBans($condition);

            $this->outputData['banTypes'] = $this->user_model->getBanTypes();

            $this->outputData['mode'] = 'insert';
            echo response([
                'html' => $this->load->view('admin/users/viewBanRow', $this->outputData, TRUE)
            ]);
        }
    }

    /**
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function refreshBanRow()
    {
        if ($this->input->is_ajax_request()) {

            $id = $this->input->post('id', true);

            //Set Condition To Fetch The Faq Category
            $condition = array('bans.id' => $id);

            //Get Categories
            $this->outputData['mode'] = 'view';
            $this->outputData['banDetails'] = $this->user_model->getBans($condition);

            echo response([
                'html' => $this->load->view('admin/users/viewBanRow', $this->outputData, TRUE)
            ]);
        }
    }

    /**
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function saveBan()
    {
        //load validation library
        $this->load->library('form_validation');

        //Load Form Helper
        $this->load->helper('form');

        //Intialize values for library and helpers
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        if ($this->input->is_ajax_request()) {

            $id = $this->input->post('id', true);

            //Set rules
            if ($this->input->post('ban_type_id') == EMAIL) {
                $this->form_validation->set_rules('ban_value', 'lang:ban_value_validation', 'required|trim|xss_clean|callback__check_email|callback__check_email_ban');
            }

            if ($this->input->post('ban_type_id') == USERNAME) {
                $this->form_validation->set_rules('ban_value', 'lang:ban_value_validation', 'required|trim|xss_clean|callback__check_email|callback__check_username_ban');
            }

            if (!$this->form_validation->run()) {//not valid
                echo response([
                    'error' => true,
                    'message' => ""
                ]);
                return;
            }

            //prepare update data
            $updateData = array();
            $updateData['ban_type_id'] = $this->input->post('ban_type_id', true);
            $updateData['ban_value'] = $this->input->post('ban_value', true);

            $condition = array('bans.id' => $id);

            $sus_value_before = null;
            $suspend_before_update = $this->common_model->getTableData('bans', $condition, 'ban_value');
            $suspend_before_update = $suspend_before_update->row();
            if (isset($suspend_before_update)) {
                $sus_value_before = $suspend_before_update->ban_value;
            }


            if ($updateData['ban_type_id'] == USERNAME) {
                $this->ban_model->setUserBan($updateData['ban_value'], Ban_model::TYPE_USERNAME, Ban_model::STATUS_BUN);
            } else if ($updateData['ban_type_id'] == EMAIL) {
                $this->ban_model->setUserBan($updateData['ban_value'], Ban_model::TYPE_EMAIL, Ban_model::STATUS_BUN);
            }

            //Insert bans
            $id = $this->user_model->saveBan($id, $updateData);

            //Notification message
            $this->notify->set(t('updated_success'), Notify::SUCCESS);


            //Set Condition To Fetch The Faq
            $condition = array('bans.id' => $id);

            //Get Categories
            $this->outputData['mode'] = 'view';
            $this->outputData['banDetails'] = $this->user_model->getBans($condition);
            echo response([
                'html' => $this->load->view('admin/users/viewBanRow', $this->outputData, TRUE)
            ]);
            return;
        }
    }

    function deleteBan()
    {
        if ($this->input->is_ajax_request()) {

            $id = $this->input->post('id', true);

            $condition = array('bans.id' => $id);
            $fields = array('bans.ban_value', 'bans.ban_type_id');

            $suspend_before_update = $this->common_model->getTableData('bans', $condition, $fields);

            $suspend_before_update = $suspend_before_update->row();


            if ($suspend_before_update->ban_type_id == USERNAME) {
                $this->ban_model->setUserBan($suspend_before_update->ban_value, Ban_model::TYPE_USERNAME, Ban_model::STATUS_UNBUN);
            } else if ($suspend_before_update->ban_type_id == EMAIL) {
                $this->ban_model->setUserBan($suspend_before_update->ban_value, Ban_model::TYPE_EMAIL, Ban_model::STATUS_UNBUN);
            }

            $this->user_model->deleteBan($id);

            $this->notify->set(t('delete_success'), Notify::SUCCESS);

            echo response([
                'error' => false,
                'message' => t('delete_success')
            ]);
        }
    }

    /**
     * Delete ban
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function deleteBan_()
    {
        $this->load->helper('form');
        $userid = $this->uri->segment(4, '0');
        if ($userid == 0) {
            $getbans = $this->user_model->getBans();
            $banlist = $this->input->post('banlist');
            if (!empty($banlist)) {
                foreach ($banlist as $res) {

                    $condition = array('bans.id' => $res);

                    $fields = array('bans.ban_value', 'bans.ban_type');

                    $suspend_before_update = $this->common_model->getTableData('bans', $condition, $fields);

                    $suspend_before_update = $suspend_before_update->row();


                    if (strtolower($suspend_before_update->ban_type) == 'username') {

                        $condition = array('users.user_name' => $suspend_before_update->ban_value);
                        $data = array('users.ban_status' => '0');
                        $this->common_model->updateTableData('users', NULL, $data, $condition);


                    } else if (strtolower($suspend_before_update->ban_type) == 'email') {

                        $condition = array('users.email' => $suspend_before_update->ban_value);
                        $data = array('users.ban_status' => '0');
                        $this->common_model->updateTableData('users', NULL, $data, $condition);

                    }
                    $condition = array('bans.id' => $res);
                    $this->user_model->deleteBan(NULL, $condition);
                }
            } else {
                $this->notify->set(t('Please select the Users'), Notify::ERROR);
                redirect_admin('users/editBans');
            }
        } else {
            $condition = array('bans.id' => $userid);
            $fields = array('bans.ban_value', 'bans.ban_type');

            $suspend_before_update = $this->common_model->getTableData('bans', $condition, $fields);

            $suspend_before_update = $suspend_before_update->row();


            if (strtolower($suspend_before_update->ban_type) == 'username') {

                $condition1 = array('users.user_name' => $suspend_before_update->ban_value);
                $data = array('users.ban_status' => '0');
                $this->common_model->updateTableData('users', NULL, $data, $condition1);


            } else if (strtolower($suspend_before_update->ban_type) == 'email') {

                $condition1 = array('users.email' => $suspend_before_update->ban_value);
                $data = array('users.ban_status' => '0');
                $this->common_model->updateTableData('users', NULL, $data, $condition1);

            }
        }
        $this->user_model->deleteBan(NULL, $condition);
        //Notification message
        $this->notify->set(t('deleted_success'), Notify::SUCCESS);
        redirect_admin('users/editBans');
    }

    /**
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function editBanRow()
    {
        if ($this->input->is_ajax_request()) {

            $id = $this->input->post('id', true);

            //Set Condition To Fetch The Faq
            $condition = array('bans.id' => $id);

            //Get Categories
            $this->outputData['banDetails'] = $this->user_model->getBans($condition);

            $this->outputData['mode'] = 'update';

            $this->outputData['banTypes'] = $this->user_model->getBanTypes();

            echo response([
                'html' => $this->load->view('admin/users/viewBanRow', $this->outputData, TRUE)
            ]);
        }
    }
}

?>