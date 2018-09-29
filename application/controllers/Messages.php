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

class Messages extends MY_Controller
{

    // Constructor
    function __construct()
    {
        parent::__construct();

        $this->load->library('settings');

        //Get Config Details From Db
        $this->settings->db_config_fetch();

        //Manage site Status
        if ($this->config->item('site_status') == 1) {
            redirect('offline');
        }

        //Load Models
        $this->load->model('common_model');
        $this->load->model('skills_model');
        $this->load->model('messages_model');
        $this->load->model('credential_model');
        $this->load->model('project_model');

        //Get Footer content
        $this->outputData['pages'] = $this->common_model->getPages();

        //Get Latest Jobs
        $limit_latest = $this->config->item('latest_projects_limit');
        $limit3 = array($limit_latest);
        $this->outputData['latestJobs'] = $this->skills_model->getLatestJobs($limit3);

        //language file
        load_lang('enduser/messages');

        //load Helpers
        $this->load->helpers('pagination');

        //Innermenu tab selection
        $this->outputData['innerClass1'] = '';
        $this->outputData['innerClass1'] = 'selected';

        //Get Users details
        $this->outputData['Users'] = $this->user_model->getUserslist();
        $this->outputData['jobs'] = $this->skills_model->getJobs();

        //Load the session liberary
        $this->load->library('session');

        //Currency Type
        $this->outputData['currency'] = $this->db->get_where('settings', array('code' => 'CURRENCY_TYPE'))->row()->string_value;
    }

    /**
     * View all mail for user
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

        // Parameters
        if ($this->input->post('project')) {
            $project = $this->input->post('project');
        } else {
            $project = '';
        }

        // Segment
        if ($this->input->is_ajax_request()) {
            $segment = $this->input->post('segment');
        } else {
            $segment = '';
        }

        $this->outputData['inbox_count'] = count($this->messages_model->get_inbox($this->logged_in_user->id, $project, TRUE, '', ''));

        if ($segment == '' or $segment == '1') {
            $messages = $this->messages_model->get_inbox($this->logged_in_user->id, $project, FALSE, $max, $order_by);
            $messages_count = count($this->messages_model->get_inbox($this->logged_in_user->id, $project, FALSE, '', ''));
            $view = 'messages/view_inbox';
        } elseif ($segment == '2') {
            $messages = $this->messages_model->get_outbox($this->logged_in_user->id, $project, FALSE, $max, $order_by);
            $messages_count = count($this->messages_model->get_outbox($this->logged_in_user->id, $project, FALSE, '', ''));
            $view = 'messages/view_outbox';
        } elseif ($segment == '3') {
            $messages = $this->messages_model->get_trash($this->logged_in_user->id, $project, FALSE, $max, $order_by);
            $messages_count = count($this->messages_model->get_trash($this->logged_in_user->id, $project, FALSE, '', ''));
            $view = 'messages/view_trash';
        } else {
            // Fallback
            return;
        }

        $this->outputData['projects'] = $this->project_model->get_user_projects($this->logged_in_user->id);
        $this->outputData['view'] = $view;
        $this->outputData['messages'] = $messages;
        $this->outputData['pagination'] = get_pagination(site_url('messages/index'), $messages_count, $page_rows, $page);

        if ($messages_count == 0) {
            $this->outputData['page_numbers'] = array();
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
                    'data' => $this->load->view($view, $this->outputData, TRUE),
                    'inbox_count' => $this->outputData['inbox_count']
                ]);
            }
        } else {
            $this->load->view('messages/view', $this->outputData);
        }
    }

    /**
     * Mark message as read
     */
    function set_notified()
    {
        if ($this->input->is_ajax_request()) {
            $this->messages_model->set_notified($this->input->get('id'));
        }
    }

    /**
     * Delete messages
     */
    function delete()
    {
        if ($this->input->is_ajax_request()) {
            $this->messages_model->delete_messages($this->input->get('id'), $this->logged_in_user->id);
        }
    }

    /**
     * Restore messages
     */
    function restore()
    {
        if ($this->input->is_ajax_request()) {
            $this->messages_model->restore_messages($this->input->get('id'), $this->logged_in_user->id);
        }
    }

    /**
     * Post message
     */
    function create()
    {
        $this->load->library('form_validation');
        $this->load->helper('form');

        // Initialize values for library and helpers
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        // Loading CSS/JS
        $this->add_js([
            'application/js/pagination.js'
        ]);

        // Post
        if ($this->input->post('submit') != NULL) {

            //Set rules
            $this->form_validation->set_rules('job_id', 'lang:Project', 'required|integer|trim|xss_clean');
            $this->form_validation->set_rules('to_id', 'lang:To', 'trim|xss_clean');
            $this->form_validation->set_rules('subject', 'lang:Subject', 'required|trim|xss_clean|no_email|no_phone_number');
            $this->form_validation->set_rules('message', 'lang:Message', 'required|trim|xss_clean|no_email|no_phone_number');

            if ($this->form_validation->run()) {

                $data = $this->input->post();

                if ($data['to_id'] == '') {
                    $data['to_id'] = [];
                    foreach ($this->project_model->get_connected_users($this->input->post('job_id')) as $user) {
                        $data['to_id'][] = $user['id'];
                    }
                }

                $this->messages_model->send_message($this->logged_in_user->id, $data['to_id'], $data['job_id'], $data['subject'], $data['message']);

                redirect(base_url('messages'));
            }
        }

        $this->outputData['projects'] = $this->project_model->get_user_projects($this->logged_in_user->id);
        if ($this->input->post('job_id') != NULL) {
            $this->outputData['to'] = $this->project_model->get_connected_users($this->input->post('job_id'));
        }
        $this->outputData['addressees'] = [];

        $this->load->view('messages/create', $this->outputData);
    }

    /**
     * Get users for project
     */
    function get_connected_users()
    {
        if ($this->input->is_ajax_request() and $this->input->get('id') != NULL) {
            echo json_encode($this->project_model->get_connected_users($this->input->get('id')));
        }
    }
}