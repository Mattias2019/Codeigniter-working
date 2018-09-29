<?php

class Dashboard extends My_Controller
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
        redirect_admin('marketing_dashboard');

    }//End of index Function

    // --------------------------------------------------------------------

    /**
     * View users
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function marketingDashboard()
    {
        // Loading CSS/JS
        $this->add_css([
            'application/js/amcharts/ammap.css',
            'application/css/admin/marketing_dashboard.css'
        ]);

        $this->add_js([
            'application/js/jquery-easypiechart/jquery.easypiechart.js',
            'application/js/amcharts/ammap.js',
            'application/js/amcharts/worldLow.js',
            'application/js/amcharts/amcharts.js',
            'application/js/amcharts/serial.js',
            'application/js/amcharts/themes/light.js',
            'application/js/admin/dashboard.js'
        ]);

        $start = $this->uri->segment(4, 0);

        $this->load->model('project_model');

        // filter
        $username = $this->input->post('username');
        $role_id = $this->input->post('role_id');

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

        //Get the inbox mail list
        $page_rows = $this->config->item('mail_limit');

        $limit[0] = $page_rows;
        if ($start > 0) {
            $limit[1] = ($start - 1) * $page_rows;
        } else {
            $limit[1] = $start * $page_rows;
        }

        $order[0] = 'users.id';
        $order[1] = 'asc';

        //Get Groups
        $userbalance = $this->user_model->getUsers_balance($where, NULL, $like, $limit, $order);

        $this->outputData['userDetails'] = $userbalance;

        $this->outputData['countUsers'] = $this->user_model->countUsers(NULL, NULL);

        $this->outputData['roles'] = $this->user_model->getRoles();

        $total_rows = $this->user_model->countUsers($where, $like);

        // Map
        $this->outputData['map_projects'] = $this->project_model->get_map_projects($this->logged_in_user->id);

        $this->load->view('admin/dashboard/marketing_dashboard', $this->outputData);
    }

    // --------------------------------------------------------------------

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
                    // $updateData['password']    	= md5($this->input->post('password'));
                    $updateData['password'] = hash('sha384', $this->input->post('password'));
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
                $updateData['user_rating'] = $this->input->post('user_rating') ? $this->input->post('user_rating') : null;
                $updateData['num_reviews'] = $this->input->post('num_reviews') ? $this->input->post('num_reviews') : null;
                $updateData['rating_hold'] = $this->input->post('rating_hold') ? $this->input->post('rating_hold') : null;
                $updateData['tot_rating'] = $this->input->post('tot_rating') ? $this->input->post('tot_rating') : null;
                $updateData['refid'] = $this->input->post('refid') ? $this->input->post('refid') : null;

                $updateKey = array('users.id' => $this->input->post('user_id', true));


                //pr($updateData);exit;
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

                $this->output->set_output(json_encode($this->data));

            }
        }

        $userid = $this->uri->segment(4, '0');
        $condition = array('users.id' => $userid);
        $this->outputData['userDetails'] = $this->user_model->getUsers_bal($condition);
        $this->outputData['userRoles'] = $this->user_model->getRoles();
        $this->outputData['countries'] = $this->country_model->getCountries();

        $this->load->view('admin/users/view_editUsers', $this->outputData);
    }

    // --------------------------------------------------------------------

    /**
     * Search users
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function searchUsers()
    {

        //load validation library
        $this->load->library('form_validation');

        //Load Form Helper
        $this->load->helper('form');

        //Intialize values for library and helpers
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        if ($this->input->post('searchUsers')) {
            //Set rules
            if ($this->input->post('email') == '')
                $this->form_validation->set_rules('username', 'lang:username_validation', 'required|trim|xss_clean');
            if ($this->input->post('username') == '')
                $this->form_validation->set_rules('email', 'lang:email_validation', 'trim|xss_clean');
            if ($this->form_validation->run()) {
                $uname = $this->input->post('username');
                $email = $this->input->post('email');
                $role_id = $this->input->post('type');
                if ($this->input->post('username')) {
                    $conditions = array('users.role_id' => $role_id);
                    $like = array('users.user_name' => $uname);
                    $result = $this->user_model->getUsers_balance($conditions, NULL, $like, NULL, NULL);
                    $this->outputData['userDetails'] = $result;
                    $this->load->view('admin/users/view_users', $this->outputData);
                } elseif ($this->input->post('email')) {

                    $conditions = array('users.role_id' => $role_id);
                    $like = array('users.email' => $email);
                    $result = $this->user_model->getUsers_balance($conditions, NULL, $like, NULL, NULL);

                    $this->outputData['userDetails'] = $result;
                    $this->load->view('admin/users/view_users', $this->outputData);
                }

            } else {
                $this->notify->set(t('Please select the Users'), Notify::ERROR);
                redirect_admin('users/searchUsers');
            }
        } else
            $this->load->view('admin/users/view_searchUsers', $this->outputData);
    }//End of addBans Function

    // --------------------------------------------------------------------

    /**
     * Delete ban
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function deleteBan()
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
    }//End of deleteBan Function

    // --------------------------------------------------------------------

    /**
     * Delete ban
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function deleteUser()
    {
        $userid = $this->uri->segment(4, '0');
        $getUser = $this->user_model->getUsers();

        if ($userid == 0) {
            $getUsers = $this->user_model->getUsers();
            $userlist = $this->input->post('userlist');
            if (!empty($userlist)) {
                foreach ($userlist as $res) {
                    $condition = array('users.id' => $res);
                    $getUser = $this->user_model->getUsers($condition);
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
                redirect_admin('users/viewUsers');
            }
        } else {
            $condition = array('users.id' => $userid);
            $getUser = $this->user_model->getUsers($condition);

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
        redirect_admin('users/viewUsers');
    }//End of deleteBan Function

    // --------------------------------------------------------------------
    /**
     * Check Password
     *
     *
     */


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

        $conditions2 = array('bans.ban_value' => $username, 'bans.ban_type' => 'USERNAME');
        $result2 = $this->user_model->getBans($conditions2);

        if ($result->num_rows() == 0 && $result2->num_rows() == 0) {
            return true;

        } else {

            $this->form_validation->set_message('_check_username', t('username_check'));

            return false;

        }//If end

    }//Function  _check_usernam End

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

        $conditions2 = array('bans.ban_value' => $mail, 'bans.ban_type' => 'EMAIL');
        $result2 = $this->user_model->getBans($conditions2);
        //pr($result->row());exit;
        if ($result->num_rows() == 0 && $result2->num_rows() == 0) {
            return true;

        } else {

            $this->form_validation->set_message('_check_email', t('email_check'));

            return false;

        }//If end

    }//Function  _check_usernam End

    // --------------------------------------------------------------------
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

        $conditions = array('ban_type' => 'USERNAME', 'ban_value' => $username);
        $result = $this->common_model->getTableData('bans', $conditions);
        if ($result->num_rows() > 0) {
            $this->form_validation->set_message('_check_username_ban', t('username_check'));
            return false;

        } else
            return true;

    }

    function _check_email_suspend($mail)
    {
        $this->output->enable_profiler(TRUE);
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
        $this->output->enable_profiler(TRUE);
        $conditions = array('ban_type' => 'EMAIL', 'ban_value' => $mail);
        $result = $this->common_model->getTableData('ban', $conditions);
        if ($result->num_rows() > 0) {
            $this->form_validation->set_message('_check_email_ban', t('email_check'));
            return false;

        } else
            return true;

    }


}

//End  SiteSettings Class

/* End of file siteSettings.php */
/* Location: ./application/controllers/administration/users.php */
?>