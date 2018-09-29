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

/**
 * Class Team
 *
 * Operations with team
 */
class Team extends MY_Controller
{
    public $logged_in_user;

    function __construct()
    {
        parent::__construct();

        $this->load->model('common_model');
        $this->load->model('team_model');
        $this->load->model('user_model');

        $this->load->helpers('pagination');
        $this->load->helpers('url');
        $this->logged_in_user = $this->common_model->get_logged_in_user();
        load_lang('enduser/account');
        load_lang('enduser/team');
    }

    /**
     * Load team view
     */
    function confirm($key)
    {
        if (empty($key)) {
            redirect('team/index');
        }
        $team = $this->team_model->confirmTeamByKey($key);
        if (!$team) {
            $this->notify->set(t('Some error'), Notify::ERROR);
            redirect('team/index');
        }
        $this->notify->set(t('Confirm success'), Notify::SUCCESS);
        redirect('team/index');
        return;
    }

    /**
     * Load team view
     */
    function index()
    {

        try {
            $this->add_js([
                'application/js/account.js',
                'application/js/pagination.js',
            ]);
            $this->add_css([
                'application/css/jquery-ui.css'
            ]);

            $this->init_js(["account.init('" . site_url() . "', '" . User_model::TYPE_FIND_USER_TEAM_MEMBER . "');"]);

            $this->load->library('form_validation');
            $this->load->helper('form');
            $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));
            $this->load->model('email_model');

            // Loading CSS/JS

            $mail = $this->email_model->get_mail('invite_supplier', [
                "!site_title" => $this->config->item('site_title'),
                "!contact_url" => site_url('home/support')
            ]);
            $mail['subject'] = t('Invite Team Member');
            $mail['custom_message'] = t('invite-supplier-welcome');

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

            // Edit member
            $member_id = $this->input->get('id');
            if ($member_id != '') {
                $member = $this->team_model->get_team_member_by_id($member_id);
                if (!isset($member['id'])) {
                    $this->notify->set('Team member does not exist', Notify::ERROR);
                } elseif ($member['team_leader_id'] != $this->logged_in_user->id and
                    !($member['team_leader_id'] == $this->team_model->get_team_leader($this->logged_in_user->id) and
                        count($this->team_model->get_groups_by_user($this->logged_in_user->id, 1)) == 0)) {
                    $this->notify->set('Only team leader or admin may edit team member information', Notify::ERROR);
                } else {
                    $this->outputData['member'] = $member;
                }
            }

            // Search parameters
            $name = $this->input->post('search_name');
            $group = $this->input->post('search_group');
            $email = $this->input->post('search_email');

            // Post form
            if ($this->input->post('submit') != '') {
                // Set rules
                if ($this->input->post('id') == '') {
                    $this->form_validation->set_rules('user_id', t('Name'), 'required|trim|xss_clean|integer');
                }
                $this->form_validation->set_rules('group_id', t('Group'), 'required');
                $this->form_validation->set_rules('job_title', t('Job Title'), 'required|trim|xss_clean');
                $this->form_validation->set_rules('telephone', t('Telephone'), 'trim|xss_clean');

                if ($this->form_validation->run()) {
                    if ($this->input->post('id') == '' or $this->input->post('id') == NULL) {
                        $data = [
                            'id' => NULL,
                            'user_id' => $this->input->post('user_id'),
                            'team_leader_id' => $this->team_model->get_team_leader($this->logged_in_user->id),
                            'group_id' => $this->input->post('group_id'),
                            'job_title' => $this->input->post('job_title'),
                            'telephone' => $this->input->post('telephone'),
                            'status' => Team_model::STATUS_NEED_ACTIVATE,
                            'token' => Team_model::generateToken(),
                        ];
                        $sendMail = [
                            'token' => $data['token'],
                            'company' => $this->logged_in_user->name,
                            'from' => $this->logged_in_user->full_name,
                            'user_id' => $this->input->post('user_id'),
                            'job_title' => $this->input->post('job_title'),
                            'telephone' => $this->input->post('telephone'),
                        ];


                        $this->team_model->sendEmailToInvitationUserToTeam($sendMail);

                        /*Flash*/
                        $success_msg = t('Invitation sent to ') . $this->user_model->get_name($data['user_id']);
                        $this->notify->set($success_msg, Notify::SUCCESS);
                        /*End Flash*/


                    } else {
                        $data = [
                            'id' => $this->input->post('id'),
                            'group_id' => $this->input->post('group_id'),
                            'job_title' => $this->input->post('job_title'),
                            'telephone' => $this->input->post('telephone'),
                            'status' => Team_model::STATUS_ACTIVE,
                            'token' => Team_model::generateToken(),
                            'user_id' => $this->input->post('user_id')
                        ];

                        /*Flash*/
                        $success_msg = t('You success updated ') . $this->user_model->get_name($this->input->post('user_id'));
                        $this->notify->set($success_msg, Notify::SUCCESS);
                        /*End Flash*/
                    }

                    $this->team_model->save_team_member($data);

                    redirect($this->uri->uri_string());
                }

            }

            // Invite team member
            if ($this->input->post('submit_invite') != '') {
                $this->form_validation->set_rules('invite_email', t('Email'), 'required|trim|valid_email|xss_clean|is_unique[users.email]');
                $this->form_validation->set_rules('invite_group_id', t('Group'), 'required|trim|xss_clean|integer');
                $this->form_validation->set_rules('invite_subject', t('Subject'), 'required|trim|xss_clean');
                $this->form_validation->set_rules('invite_text', t('Invitation'), 'required|trim|xss_clean');
                $this->form_validation->set_message('is_unique', t('The user with this email is already registered in the system. You can\'t send invitation.'));

                if ($this->form_validation->run()) {
                    $insertData = array();
                    $insertData['email'] = $this->input->post('invite_email');
                    $insertData['role_id'] = $this->logged_in_user->role_id;
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

                    $activation_url = '<a href="'.site_url('account/confirm/' . $insertData['activation_key']).'">Click here to continue signup process</a>';
                    $contact_url = '<a href="'.site_url('home/support').'">'.site_url('home/support').'</a>';

                    // Send Mail
                    try {
                        $this->email_model->custom(
                            $new_user_id,
                            $this->input->post('invite_subject'),
                            $mail['body'],
                            [
                                "!site_title" => $this->config->item('site_title'),
                                "!activation_url" => $activation_url,
                                "!custom_body" => $this->input->post('invite_text') . "<br>",
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

                        /*Save team member*/
                        $data = [
                            'id' => NULL,
                            'group_id' => $this->input->post('invite_group_id'),
                            'status' => Team_model::STATUS_ACTIVE,
                            'token' => Team_model::generateToken(),
                            'user_id' => $new_user_id,
                            'team_leader_id' => $this->team_model->get_team_leader($this->logged_in_user->id),
                        ];
                        $this->team_model->save_team_member($data);
                        /*End Save team member*/
                    } catch (Exception $e) {
                        $this->notify->set($e->getMessage(), Notify::ERROR);
                    }
                    redirect($this->uri->uri_string());
                }
            }

            $members = $this->team_model->get_team_members($this->logged_in_user->id, $name, $group, $email, $max, $order_by);
            $members_total = count($this->team_model->get_team_members($this->logged_in_user->id, $name, $group, $email, '', ''));

            $this->outputData['groups'] = $this->team_model->get_groups($this->logged_in_user->id);
            $this->outputData['members'] = $members;
            $this->outputData['pagination'] = get_pagination(site_url('team/index/'), $members_total, $page_rows, $page);
            $this->outputData['user_names'] = $this->user_model->getUsers(['users.role_id' => $this->logged_in_user->role_id], 'users.id, users.first_name, users.last_name', [], ['users.first_name', 'ASC'])->result_array();
            $this->outputData['user_mails'] = $this->user_model->getUsers(['users.role_id' => $this->logged_in_user->role_id], 'users.id, users.email', [], ['users.email', 'ASC'])->result_array();

            if ($members_total == 0) {
                $this->outputData['page_numbers'] = array();
            }

            if ($this->input->is_ajax_request()) {
                echo response([
                    'type' => 'table',
                    'data' => $this->load->view('team/index_table', $this->outputData, TRUE),
                    'pagination' => $this->outputData['pagination']
                ]);
            } else {
                $this->outputData['mail'] = $mail;
                $this->load->view('team/index', $this->outputData);
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

    /**
     * Request to delete team member
     */
    function delete()
    {
        if ($this->input->is_ajax_request()) {
            $member_id = $this->input->get('id');
            $member = $this->team_model->get_team_member_by_id($member_id);
            if (!isset($member['id'])) {
                $result = response('Team member does not exist', TRUE);
            } elseif ($member['team_leader_id'] != $this->logged_in_user->id and
                !($member['team_leader_id'] == $this->team_model->get_team_leader($this->logged_in_user->id) and
                    count($this->team_model->get_groups_by_user($this->logged_in_user->id, 1)) == 0)) {
                $result = response('Only team leader or admin may delete team member', TRUE);
            } else {
                $this->team_model->delete_team_member($member_id);
                $result = response(['id' => $member_id]);
            }
            echo $result;
        }
    }

    /**
     * Groups and permissions
     */
    function groups() {
        try {
            $this->add_css(["application/css/team_groups.css"]);
            $this->add_js(["application/js/team_groups.js"]);
            $this->init_js(["groups.init('" . site_url() . "');"]);


            $groups = $this->team_model->get_user_groups($this->logged_in_user->id);
            $table = $this->load->view('team/groups_table', ["groups" => $groups], true);
            $this->outputData['groups_table'] = $table;
            $this->load->view('team/groups', $this->outputData);

        } catch (Exception $e) {
            $this->notify->set($e->getMessage(), Notify::ERROR);
            redirect('information');
        }
    }

    /**
     * Save and reload group row
     */
    function save_group()
    {
        if ($this->input->is_ajax_request()) {
            $data = $this->input->post();
            if ($this->input->post('group_name') == '') {
                echo response('Name is required', TRUE);
                return;
            }
            $group = $this->team_model->get_group_by_id($data['id']);
            $group = array_merge($group, $data);
            $group = $this->team_model->save_group($group, $this->logged_in_user->id);

            $member = [
                'user_id' => $this->logged_in_user->id,
                'team_leader_id' => $group['team_leader_id'],
                'group_id' => $group['id'],
                'status' => Team_model::STATUS_ACTIVE,
                'token' => Team_model::generateToken(),
            ];
            $this->team_model->save_team_member($member);
            $groups = $this->team_model->get_user_groups($this->logged_in_user->id, $group['id']);
            $table = $this->load->view('team/groups_table_row', ["item" => $groups[0]], true);
            echo response(['html' => $table]);
        }
    }

    /**
     * Reload table
     */
    function refresh_group()
    {
        if ($this->input->is_ajax_request()) {
            $groups = $this->team_model->get_user_groups($this->logged_in_user->id);
            $table = $this->load->view('team/groups_table', ["groups" => $groups], true);
            echo response(['html' => $table]);
        }
    }

    /**
     * Request to delete group
     */
    function delete_group()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $group = $this->team_model->get_group_by_id($id);
            if (count($group) > 0) {
                $this->team_model->delete_group($id);
                $groups = $this->team_model->get_user_groups($this->logged_in_user->id);
                $table = $this->load->view('team/groups_table', ["groups" => $groups], true);
                echo response(['html' => $table]);
            } else {
                echo response('Group does not exist', TRUE);
            }
        }
    }

    /**
     * Request to delete group
     */
    function lock_group()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $group = $this->team_model->get_group_by_id($id);
            if (count($group) > 0) {
                $group['is_locked'] = $this->input->post('locked') == 1 ? 0 : 1;
                $this->team_model->save_group($group, $this->logged_in_user->id);
                $groups = $this->team_model->get_user_groups($this->logged_in_user->id, $id);
                $table = $this->load->view('team/groups_table_row', ["item" => $groups[0]], true);
                echo response(['html' => $table]);
            } else {
                echo response('Group does not exist', TRUE);
            }
        }
    }

    function move_group()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('id');
            $group = $this->team_model->get_group_by_id($id);
            if (count($group) > 0) {
                $this->team_model->move_group_position($group);
                $groups = $this->team_model->get_user_groups($this->logged_in_user->id);
                $table = $this->load->view('team/groups_table', ["groups" => $groups], true);
                echo response(['html' => $table]);
            } else {
                echo response('Group does not exist', TRUE);
            }
        }
    }

    function name_or_email($field)
    {
        if ($this->input->post('name') == '' and $this->input->post('email') == '') {
            $this->form_validation->set_message('name_or_email', t('Either name or email is required.'));
            return FALSE;
        } else {
            return TRUE;
        }
    }


}