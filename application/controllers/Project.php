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

class Project extends MY_Controller
{
    function __construct()
    {
        parent::__construct();

        //Get Config Details From Db
        $this->settings->db_config_fetch();

        //Manage site Status
        if ($this->config->item('site_status') == 1) {
            redirect('offline');
        }

        //Load the helper file
        $this->load->helper('form');
        $this->load->helper('pagination');

        //language file
        load_lang('enduser/job');

        //Load Models
        $this->load->model('common_model');
        $this->load->model('skills_model');
        $this->load->model('user_model');
        $this->load->model('settings_model');
        $this->load->model('file_model');
        $this->load->model('messages_model');
        $this->load->model('cancel_model');
        $this->load->model('project_model');
        $this->load->model('quote_model');
        $this->load->model('finance_model');

        //Get Countries
        $this->outputData['countries'] = $this->common_model->get_countries();

        //Currency Type
        $this->outputData['currency'] = $this->db->get_where('settings', array('code' => 'CURRENCY_TYPE'))->row()->string_value;

        //Get Footer content
        $this->outputData['pages'] = $this->common_model->getPages();

        //Post the maximum size of memory limit
        $maximum = $this->config->item('upload_limit');
        $this->outputData['maximum_size'] = $maximum;

        //Get Certificate User
        if ($this->logged_in_user) {
            $paymentSettings = $this->settings_model->getSiteSettings();
            $this->outputData['feature_project'] = $paymentSettings['FEATURED_PROJECT_AMOUNT'];
            $this->outputData['urgent_project'] = $paymentSettings['URGENT_PROJECT_AMOUNT'];
            $this->outputData['hide_project'] = $paymentSettings['HIDE_PROJECT_AMOUNT'];
            $this->outputData['private_project'] = $paymentSettings['PRIVATE_PROJECT_AMOUNT'];
        }

        $this->load->helper('download');

    }


    function feeCount()
    {
        if ($this->input->is_ajax_request()) {
            $this->outputData['amount'] = $this->input->post('amount');
            $type = $this->input->post('type');
            $this->outputData['feeCount'] = $this->finance_model->get_fee($this->outputData['amount'], $type);
            echo response(['data' => $this->outputData]);
        }

        return;

    }

    /**
     * Create/edit tender project
     */
    function create()
    {
        //Load Language
        load_lang(['enduser/withdraw', 'enduser/bid', 'enduser/job']);

        // Load validation library
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        $this->add_css([
            'application/css/css/jquery.rateyo.min.css',
            "application/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css",
            'application/css/css/tmpl-css/bootstrap-datepicker.css',
            'application/css/css/dropzone.css',
            'application/css/css/build.css',
            'application/css/css/multiselect.css?v='.time(),
            'application/css/css/projects.css'
        ]);

        $this->add_js([
            'application/js/jquery.rateyo.min.js',
            'application/js/tmpl-js/bootstrap-datepicker.js',
            'application/js/dropzone.js',
            'application/js/dropdown.js',
            'application/js/jquery.inputmask.bundle.min.js',
            'application/js/custom-inputmask.js',
            'application/js/pagination.js',
            'application/js/project.js',
            "application/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js",
            "application/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js",
            "application/js/jquery.wysihtml5_size_matters.js"
        ]);

        $this->init_js(["project.init('" . site_url() . "', '" . User_model::TYPE_FIND_USER_SUPPLIER . "');"]);

        $user_country = $this->user_model->getUserCountry($this->logged_in_user->id);

        // Check id if supplied, and if project is eligible for editing
        $project_id = $this->input->get('id');
        if ($project_id != NULL) {
            $project = $this->project_model->get_project_by_id($project_id);
            if ($project['id'] == NULL) {
                /*Flash*/
                $success_msg = t('Project does not exist');
                $this->notify->set($success_msg, Notify::ERROR);
                /*End Flash*/
                redirect('information');
            } elseif (!$this->project_model->tender_project_is_avaible($this->logged_in_user->id)) {
                /*Flash*/
                $success_msg = t('Project can only be edited by its creator');
                $this->notify->set($success_msg, Notify::ERROR);
                /*End Flash*/
                redirect('information');
            } elseif (!is_editable($project['job_status'])) {
                /*Flash*/
                $success_msg = t('Project cannot be edited if there are quotes placed');
                $this->notify->set($success_msg, Notify::ERROR);
                /*End Flash*/
                redirect('information');
            } else {
                if ($this->input->post('submit') == NULL) {
                    //restore changes from session
                    $sess_files = $this->session->userdata('proj_files');
                    $sess_form_data = $this->session->userdata('proj_form_data');

                    if (!empty($sess_form_data[$project_id])) {
                        $sess_form_data = $sess_form_data[$project_id];
                        unset($sess_form_data['attachments']);
                        foreach ($sess_form_data['milestones'] as $sm_key => $sm_val) {
                            unset($sess_form_data['milestones'][$sm_key]['attachments']);
                        }
                        $project = $sess_form_data + $project;
                    }

                    if (!empty($sess_files[$project_id])) {
                        $sess_files = $sess_files[$project_id];
                        $project['attachments'] = $project['attachments'] +
                            array_filter($sess_files, function ($el) {
                                return empty($el['milestone']);
                            });
                        foreach ($project['milestones'] as $pm_idx => $pm_val) {
                            $this->pm_idx = $pm_idx;
                            if (empty($project['milestones'][$pm_idx]['attachments'])) {
                                $project['milestones'][$pm_idx]['attachments'] = [];
                            }
                            $project['milestones'][$pm_idx]['attachments'] = $project['milestones'][$pm_idx]['attachments'] +
                                array_filter($sess_files, function ($el) {
                                    return $el['milestone'] == $this->pm_idx;
                                });
                        }
                    }
                }

                $this->outputData['project'] = $project;
            }
        }
        else {
            unset($_SESSION['workflow_id']);
            unset($_SESSION['workflow']);

            unset($this->outputData['project']);
        }

        // Submit
        if ($this->input->post('submit') != NULL) {
            // Set rules
            $this->form_validation->set_rules('job_name', 'lang:Name', 'required|trim|xss_clean|no_email|no_phone_number|callback_is_unique_if_insert[jobs.job_name]');
            $this->form_validation->set_rules('description', 'lang:Description', 'callback_required_if_not_draft|trim|xss_clean|no_email|no_phone_number');
            $this->form_validation->set_rules('country', 'lang:Country', 'callback_required_if_not_draft');
            $this->form_validation->set_rules('city', 'lang:City', 'alpha|callback_required_if_not_draft');
            $this->form_validation->set_rules('is_feature', 'lang:Featured', 'trim|callback_enough_funds');
            $this->form_validation->set_rules('is_private', 'lang:Private', 'trim|callback_enough_funds');
            $this->form_validation->set_rules('is_urgent', 'lang:Urgent', 'trim|callback_enough_funds');
            $this->form_validation->set_rules('is_hide_bids', 'lang:Hide Bids', 'trim|callback_enough_funds');
            $this->form_validation->set_rules('open_days', '"Open for bidding(days)"', 'required|trim|integer|xss_clean');
            $this->form_validation->set_rules('budget_min', 'Budget from', 'trim|integer|is_natural|abs|xss_clean');
            $this->form_validation->set_rules('budget_max', 'Budget to', 'trim|integer|is_natural|abs|xss_clean|callback_exceed_funds|callback_wrong_budget');
            $this->form_validation->set_rules('due_date', 'Due Date', 'callback_wrong_due_date');
            /*if ($this->input->post('is_private'))
            {
                $this->form_validation->set_rules('private_list','lang:private_list','callback_required_if_not_draft');
            }*/
            // Milestones
            if ($this->input->post('milestones')) {
                foreach ($this->input->post('milestones') as $i => $val) {
                    $this->form_validation->set_rules('milestones[' . $i . '][name]', 'lang:Name', 'required|trim|xss_clean|no_email|no_phone_number');
                    $this->form_validation->set_rules('milestones[' . $i . '][description]', 'lang:Description', 'callback_required_if_not_draft|trim|xss_clean|no_email|no_phone_number');
                }
            }

            if ($this->form_validation->run()) {
                // Preparing data
                $data = [];
                $data['id'] = $this->input->post('id');
                if ($data['id'] == '') {
                    $data['id'] = NULL;
                }
                $data['job_name'] = $this->input->post('job_name');
                $data['description'] = $this->input->post('description');
                $data['country'] = $this->input->post('country');
                $data['state'] = $this->input->post('state');
                $data['city'] = $this->input->post('city');
                $data['budget_min'] = $this->input->post('budget_min');
                if ($data['budget_min'] == '') {
                    $data['budget_min'] = 0;
                }
                $data['budget_max'] = $this->input->post('budget_max');
                if ($data['budget_max'] == '') {
                    $data['budget_max'] = 0;
                }

                $data['is_feature'] = $this->input->post('is_feature');
                $data['is_urgent'] = $this->input->post('is_urgent');
                $data['is_hide_bids'] = $this->input->post('is_hide_bids');
                $data['is_private'] = $this->input->post('is_private');

                $data['creator_id'] = $this->logged_in_user->id;
                $data['created'] = get_est_time();

                if ($this->input->post('open_days_changed') > 0) {
                    $data['enddate'] = get_est_time() + ($this->input->post('open_days') * DAY);
                } else {
                    $data['enddate'] = $this->input->post('enddate');
                }

                if ($data['enddate'] == '') {
                    $data['enddate'] = 0;
                }

                $data['due_date'] = $this->input->post('due_date');
                if (empty($data['due_date'])) {
                    $data['due_date'] = 0;
                }

                switch ($this->input->post('submit')) {
                    case 'draft':
                        $data['job_status'] = 0;
                        break;
                    case 'new':
                        $data['job_status'] = 1;
                        break;
                    case 'publish':
                        $data['job_status'] = 2;
                        break;
                }

                $data['category'] = $this->input->post('category');

                // Attachments
                $data['attachments'] = invert_array($this->input->post('attachments'));

                // Milestones
                $milestones = $this->input->post('milestones');
                if (isset($milestones) and is_array($milestones) and count($milestones) > 0) {
                    foreach ($milestones as $i => $val) {
                        if ($milestones[$i]['id'] == '') {
                            $milestones[$i]['id'] = NULL;
                        }
                        if ($milestones[$i]['due_date'] == '') {
                            $milestones[$i]['due_date'] = 0;
                        }
                        if ($milestones[$i]['amount'] == '') {
                            $milestones[$i]['amount'] = 0;
                        }
                        // Attachments
                        if (array_key_exists('attachments', $milestones[$i])) {
                            $milestones[$i]['attachments'] = invert_array($milestones[$i]['attachments']);
                        }
                    }
                    $data['milestones'] = $milestones;
                }

                try {

                    $res = $this->project_model->save_project($data);

                    $_POST['id'] = $res['id'];
                    $_POST['job_status'] = $data['job_status'];

                    /*Flash*/
                    $success_msg = t('Saved changes to project.');
                    $this->notify->set($success_msg, Notify::SUCCESS);
                    /*End Flash*/

                    // insert invited suppliers
                    if (isset($_SESSION["invitedSuppliers"])) {

                        foreach ($_SESSION["invitedSuppliers"] as $key => $supplier_id) {
                            $this->project_model->invite_supplier_to_project($res['id'], $this->logged_in_user->id, $supplier_id);
                        }
                        unset($_SESSION["invitedSuppliers"]);
                    }

                    // send invitation to the invited suppliers when project is published
                    if ($data['job_status'] == 2) {

                        $this->project_model->send_invitation_to_suppliers($res['id']);
                    }

                } catch (Exception $e) {
                    $this->notify->set($e->getMessage(), Notify::ERROR);
                }

                // Clean up
                //$this->file_model->clear_temp($this->logged_in_user->id);
                $this->session->unset_userdata('proj_files');
                $this->session->unset_userdata('proj_form_data');
            }
        }

        $this->outputData['user_country'] = $user_country;

        // suppliers table
        $this->getSuppliersList($project_id?$project_id:$this->input->post('id'));

        $this->outputData['countries'] = $this->common_model->get_countries();
        $this->outputData['drafts'] = $this->project_model->get_draft_thumbs($this->logged_in_user->id);
        $this->outputData['groups_with_categories'] = $this->skills_model->getGroupsWithCategory([], $this->logged_in_user->id);
        $this->outputData['search_type'] = '1';

        $this->load->view('project/create', $this->outputData);
    }

    // populate suppliers table on the Create Project page
    function getSuppliersList($project_id = null) {

        $invitedSuppliersArr = array();
        if (isset($_SESSION["invitedSuppliers"])) {
            $invitedSuppliersArr = $_SESSION["invitedSuppliers"];
        }
        $invited_suppliers = $this->project_model->getInvitedSuppliers($project_id, $invitedSuppliersArr);
        $this->outputData['invited_suppliers'] = $invited_suppliers;

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
            $field = '';
        }
        if ($this->input->post('order')) {
            $order = $this->input->post('order');
        } else {
            $order = '';
        }
        $order_by = [$field, $order];

        // filter
        $supplier_name = $this->input->post('supplier_name');

        $where = array();

        $like = array();
        if (isset($supplier_name) && $supplier_name != "") {
            $like = array('u.first_name' => $supplier_name,
                'u.last_name' => $supplier_name,
                'u.user_name' => $supplier_name,
                'u.email' => $supplier_name
            );
        }

        $suppliers = $this->user_model->getSuppliers($where, $like, $limit, $order_by, $invited_suppliers);
        $total_suppliers = $this->user_model->countSuppliers($where, $like, $invited_suppliers)->row()->count;

        $this->outputData['suppliers'] = $suppliers;
        $this->outputData['pagination'] = get_pagination(site_url('project/getSuppliersList'), $total_suppliers, $page_rows, $page);

        if ($this->input->is_ajax_request()) {
            echo response([
                'type' => 'table',
                'data' => $this->load->view('project/suppliers_table', $this->outputData, TRUE),
                'pagination' => $this->outputData['pagination']
            ]);
        }
    }

    function inviteSupplier() {

        $suppliersList = array();

        if ($this->input->is_ajax_request()) {

            if ($this->input->post("suppliersList")) {

                $project_id = $this->input->post("project_id");

                $invitedSuppliersSess = array();
                if (isset($_SESSION["invitedSuppliers"])) {
                    $invitedSuppliersSess = $_SESSION["invitedSuppliers"];
                }

                $suppliersList = array_unique(array_merge($suppliersList, $this->input->post('suppliersList'), $invitedSuppliersSess));

                $_SESSION["invitedSuppliers"] = $suppliersList;

                $invited_suppliers = $this->project_model->getInvitedSuppliers($project_id, $_SESSION["invitedSuppliers"]);
                $this->outputData['invited_suppliers'] = $invited_suppliers;

                echo response([
                    'html' => $this->load->view('project/invited_suppliers_list', $this->outputData, TRUE),
                    'message' => t('Invitation sent')
                ]);
            }
            else {
                echo response([
                    'message' => t('Select suppliers to invite'),
                ], true);
            }
        }

    }

    //
    function getSupplierInfo() {

        $result = ['data' => '', 'error' => false];

        if ($this->input->is_ajax_request()) {

            if ($this->input->post("supplier_id")) {

                $supplier_id = $this->input->post("supplier_id");
                $supplier = $this->user_model->getUsers(['users.id' => $supplier_id])->row();

                $supplier->img_logo = $this->file_model->get_user_logo_path($supplier->id, $supplier->logo);

                $this->outputData['supplier'] = (array)$supplier;

                // Rank and rating
                $this->outputData['rank'] = $this->user_model->get_user_rank($supplier->id);
                $this->outputData['all_rank'] = $this->user_model->get_user_count();

                $result = ['data' => ['html' => $this->load->view('project/supplierInfo', $this->outputData, TRUE)], 'error' => false];
            }
        }

        echo response($result['data'], $result['error']);
    }

    /**
     * Field is required if not saving project as draft
     *
     * @param $field
     * @return bool
     */
    function required_if_not_draft($field)
    {
        if ($this->input->post('submit') != 'draft') {

            $this->form_validation->set_message('required_if_not_draft', 'The {field} field is required.');
            return $this->form_validation->required($field);
        } else {
            return TRUE;
        }
    }

    /**
     * Check if there is enough funds to publish project
     *
     * @return bool
     */
    function exceed_funds()
    {
        if ($this->input->post('submit') == 'publish') {

            $this->form_validation->set_message('exceed_funds', 'The amount of the project exceeds the budget.');

            // Milestones
            $sum_milestones = 0;
            if ($this->input->post('milestones')) {
                foreach ($this->input->post('milestones') as $i => $val) {
                    $sum_milestones = $sum_milestones + $val['amount'];
                }
            }
            return ($this->input->post('budget_max') > $sum_milestones);
        } else {
            return TRUE;
        }
    }

    /**
     * Check from & to values
     *
     * @return bool
     */
    function wrong_budget()
    {
        $this->form_validation->set_message('wrong_budget', '"Budget From" value should be less than "Budget To" value.');

        if ( $this->input->post('budget_min') > $this->input->post('budget_max') ) {
            return false;
        }
        else {
            return true;
        }
    }

    /**
     * Check Due Date
     *
     * @return bool
     */
    function wrong_due_date()
    {
        $this->form_validation->set_message('wrong_due_date', 'Due Date should be in the future');

        if ( $this->input->post('due_date') < time() ) {
            return false;
        }
        else {
            return true;
        }
    }

    /**
     * Check if there is enough funds to publish project
     *
     * @param $field
     * @return bool
     */
    function enough_funds($field)
    {
        if ($this->input->post('submit') == 'publish') {

            $this->form_validation->set_message('enough_funds', 'Insufficient funds.');
            $fee = $this->finance_model->get_project_fee(
                $this->input->post('id'),
                $this->input->post('is_urgent'),
                $this->input->post('is_feature'),
                $this->input->post('is_hide_bids'),
                $this->input->post('is_private')
            );
            return ($fee <= $this->finance_model->get_user_balance());
        } else {
            return TRUE;
        }
    }

    /**
     * Field must be unique if project is new
     *
     * @param $field
     * @param $db
     * @return bool
     */
    function is_unique_if_insert($field, $db)
    {
        if ($this->input->post('id') == NULL) {

            $this->form_validation->set_message('is_unique_if_insert', 'The {field} field must contain a unique value.');
            return $this->form_validation->is_unique($field, $db);
        } else {
            return TRUE;
        }
    }

    /**
     * View of milestone for AJAX request from Create project page
     */
    function create_milestone()
    {
        if ($this->input->is_ajax_request()) {
            $this->outputData['milestone_number'] = $this->input->post('milestone');

            $proj_form_data = empty($this->session->userdata('proj_form_data')) ? [] : $this->session->userdata('proj_form_data');
            $post_form_data = $this->input->post('form_data');
            parse_str($post_form_data, $post_form_data);
            if ($post_form_data) {
                $proj_id = empty($post_form_data['id']) ? 0 : $post_form_data['id'];
                $proj_form_data[$proj_id] = $post_form_data;
            }
            $this->session->set_userdata('proj_form_data', $proj_form_data);

            echo response(['data' => $this->load->view('project/create_milestone', $this->outputData, TRUE)]);
        }
    }

    /**
     * Store files from dropzone.js
     */
    function upload_files($project_id = 0)
    {
        $this->outputData['milestone_number'] = $this->input->get('milestone');
        if (isset($_FILES) and is_array($_FILES) and array_key_exists('file', $_FILES)) {
            $this->load->library('upload');
            $this->load->library('image_lib');

            $config['upload_path'] = $this->file_model->temp_dir($this->logged_in_user->id);
            /* For some reason, listing MIME types do not work */
            $config['allowed_types'] = 'bmp|BMP|gif|GIF|jpg|JPG|jpeg|JPEG|png|PNG|txt|TXT|doc|DOC|docx|DOCX|xls|XLS|xlsx|XLSX|ppt|PPT|pptx|PPTX|rar|RAR|zip|ZIP|pdf|PDF';
            $config['max_size'] = $this->config->item('max_upload_size');
            $config['encrypt_name'] = TRUE;
            $config['file_ext_tolower'] = TRUE;

            $this->upload->initialize($config);

            $file = $_FILES['file'];
            $_FILES['file'] = $file;
            $this->upload->do_upload('file');
            $data = $this->upload->data();

            //store file info in session
            if ($data) {

                $data['id'] = null;
                $data['name'] = $data['orig_name'];
                $data['url'] = $data['file_name'];
                $data['img_url'] = '/' . $config['upload_path'] . $data['file_name'];
                $data['milestone'] = $milestone = $this->input->get('milestone');

                $proj_files_sess = $this->session->userdata('proj_files');
                $proj_files_sess[$project_id][] = $data;
                $this->session->set_userdata('proj_files', $proj_files_sess);
            }

            // Check if file is uploaded
            if ($data['file_name'] != '' and $data['orig_name'] != '') {
                // Resize image
                if ($data['is_image']) {
                    $resize = [
                        'source_image' => $data['full_path'],
                        'maintain_ratio' => true,
                        'quality' => 90,
                    ];
                    $this->image_lib->initialize($resize);
                    $this->image_lib->resize();
                }
                // Load attachment view
                $this->outputData['attachment'] = [
                    'id' => NULL,
                    'name' => $data['orig_name'],
                    'url' => $data['file_name'],
                    'img_url' => '/' . $config['upload_path'] . $data['file_name']
                ];
                $this->load->view('project/create_attachment', $this->outputData);
            }
        }
    }

    /**
     * AJAX request to delete project
     */
    function delete()
    {
        if ($this->input->is_ajax_request()) {

            //Check  id if supplied, and if project is eligible for editing
            $project_id = $this->input->get('id');
            if ($project_id != NULL) {

                $project = $this->project_model->get_project_by_id($project_id);
                if ($project['id'] == NULL) {

                    echo response('Project does not exist', TRUE);
                    return;
                } elseif ($project['creator_id'] != $this->logged_in_user->id) {

                    echo response('Project can only be edited by its creator', TRUE);
                    return;
                } elseif ($project['job_status'] > 2) {

                    echo response('Project cannot be edited if there are quotes placed', TRUE);
                    return;
                }
            } else {
                echo response('Project does not exist', TRUE);
                return;
            }

            $this->project_model->delete_project($project_id);
            echo response(['id' => $project_id, 'message' => 'Project ' . $project['job_name'] . ' is deleted']);
        }
    }

    /**
     * Place quote on project
     */
    function quote()
    {
        //Load Language
        load_lang('enduser/quote');

        // Load validation library
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        $this->add_css([
            'application/css/css/tmpl-css/bootstrap-datepicker.css',
            'application/css/css/dropzone.css',
            'application/css/css/projects.css',
            'application/css/css/project_quote.css',
            "application/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css",
        ]);

        $this->add_js([
            'application/js/tmpl-js/jquery.inputmask.js',
            'application/js/tmpl-js/bootstrap-datepicker.js',
            'application/js/dropzone.js',
            'application/js/jquery.inputmask.bundle.min.js',
            'application/js/custom-inputmask.js',
            'application/js/project_quote.js',
            "application/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js",
            "application/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js",
            "application/js/jquery.wysihtml5_size_matters.js"
        ]);

        $options = [
            'drop-your-file-here' => t('Drop your files here')
        ];

        // Submit
        if ($this->input->post('submit') != '') {
            //if ($this->form_validation->run())
            {
                $data = $this->input->post();

                $submit = $data['submit'];
                unset($data['submit']);
                unset($data['client']);
                unset($data['job_status']);

                switch ($submit) {
                    case 'draft':
                        $data['status'] = 0;
                        break;
                    case 'new':
                        $data['status'] = 1;
                        break;
                    case 'publish':
                        $data['status'] = 2;
                        break;
                }

                if ($data['machinery_id'] == '') {
                    $data['machinery_id'] = NULL;
                }

                if (array_key_exists('escrow_required', $data)) {
                    $data['escrow_required'] = 1;
                }
                if (array_key_exists('platform_required', $data)) {
                    $data['platform_required'] = 1;
                }
                if (array_key_exists('notify_lower', $data)) {
                    $data['notify_lower'] = 1;
                }

                if (array_key_exists('attachments', $data)) {
                    $data['attachments'] = invert_array($data['attachments']);
                }

                // specially for wysihtml5
                if (array_key_exists('_wysihtml5_mode', $data)) {
                    unset($data['_wysihtml5_mode']);
                }

                if (array_key_exists('milestones', $data) and is_array($data['milestones'])) {
                    foreach ($data['milestones'] as $i => $val) {
                        if ($data['milestones'][$i]['amount'] == '') $data['milestones'][$i]['amount'] = 0;
                        if ($data['milestones'][$i]['is_added'] == '') $data['milestones'][$i]['is_added'] = 0;
                        if ($data['milestones'][$i]['is_deleted'] == '') $data['milestones'][$i]['is_deleted'] = 0;
                        if ($data['milestones'][$i]['is_added_cur'] == '') $data['milestones'][$i]['is_added_cur'] = 0;
                        if ($data['milestones'][$i]['is_deleted_cur'] == '') $data['milestones'][$i]['is_deleted_cur'] = 0;
                        if (array_key_exists('escrow_required', $data['milestones'][$i])) {
                            $data['milestones'][$i]['escrow_required'] = 1;
                        }
                        if (array_key_exists('platform_required', $data['milestones'][$i])) {
                            $data['milestones'][$i]['platform_required'] = 1;
                        }
                        if (array_key_exists('notify_lower', $data['milestones'][$i])) {
                            $data['milestones'][$i]['notify_lower'] = 1;
                        }
                        if (array_key_exists('attachments', $data['milestones'][$i])) {
                            $data['milestones'][$i]['attachments'] = invert_array($data['milestones'][$i]['attachments']);
                        }
                    }
                }
                $res = $this->quote_model->save_quote($data);

                // Clean up
                /*if ($res['id'] != '')
                {
                    $this->file_model->clear_temp($this->logged_in_user->id);
                }*/

                // If quote was published, redirect to other page as this quote cannot be edited anymore
                if ($submit == 'publish' and $res['id'] != '') {
                    $this->notify->set(t('Quote was successfully published'), Notify::SUCCESS);
                    if (isEntrepreneur()) {
                        redirect('project/tender');
                    } elseif (isProvider()) {
                        redirect('project/project_list/3');
                    } else {
                        // Fallback
                        redirect('information');
                    }
                }

                // Get project/milestones ID
                $_POST['id'] = $res['id'];
                $i = 0;
                $milestones = $this->input->post('milestones');
                if (isset($milestones)) {
                    foreach ($milestones as $j => $val) {
                        $_POST['milestones'][$j]['id'] = $res['milestones'][$i];
                        $i++;
                    }
                }
            }
        }

        $project_id = $this->input->get('id');
        if ($project_id == '') {
            $this->notify->set(t('Project does not exist'), Notify::ERROR);
            redirect('information');
        }

        $this->outputData['project_id'] = $project_id;

        if (isEntrepreneur()) {

            // check entrepreneur rights to revise quote
            if (!$this->project_model->check_project_access($project_id, $this->logged_in_user->id)) {

                $this->notify->set(t('revise_quote_access'), Notify::ERROR);

                redirect('information');
            }

            $provider_id = $this->input->get('provider');
            $quote = $this->quote_model->get_latest_quote($project_id, $provider_id);
            $this->outputData['provider_id'] = $provider_id;

        } elseif (isProvider()) {
            $quote = $this->quote_model->get_latest_quote($project_id, $this->logged_in_user->id);
            $this->outputData['provider_id'] = $this->logged_in_user->id;
        } else {
            // Fallback
            $quote = NULL;
        }

        if (!is_array($quote) or count($quote) == 0) {
            $this->notify->set(t('You cannot place quote on this project'), Notify::ERROR);
            redirect('information');
        }

        $this->outputData['quote'] = $quote;
        if ($this->input->get('machinery')) {
            $this->outputData['quote']['machinery_id'] = $this->input->get('machinery');
        }

        $options['milestone-added'] = t('Added at loop') . ' ' . ($this->outputData['quote']['loop'] - 1);
        $options['milestone-deleted'] = t('Deleted at loop') . ' ' . ($this->outputData['quote']['loop'] - 1);
        $options['deleted'] = t('Deleted');
        $options['restore'] = t('Restore');
        $options['currency'] = currency();

        $this->init_js("projectQuote.init('" . site_url() . "'," . json_encode($options) . ")");

        $this->load->view('project/quote', $this->outputData);
    }

    /**
     * View of milestone for AJAX request from Quote page
     */
    function quote_milestone()
    {
        if ($this->input->is_ajax_request()) {
            //Load Language
            load_lang('enduser/quote');

            $this->outputData['quote_milestone_number'] = $this->input->post('milestone');
            $this->outputData['quote_milestone'] = NULL;
            $this->outputData['milestone_new'] = TRUE;

            $res['summary'] = $this->load->view('project/quote_milestone_cost_summary', $this->outputData, TRUE);
            $this->outputData['cost_type'] = 'labor';
            $res['labor'] = $this->load->view('project/quote_milestone_cost', $this->outputData, TRUE);
            $this->outputData['cost_type'] = 'material';
            $res['material'] = $this->load->view('project/quote_milestone_cost', $this->outputData, TRUE);
            $this->outputData['cost_type'] = 'third_party';
            $res['third_party'] = $this->load->view('project/quote_milestone_cost', $this->outputData, TRUE);
            $this->outputData['cost_type'] = 'travel';
            $res['travel'] = $this->load->view('project/quote_milestone_cost', $this->outputData, TRUE);

            echo response($res);
        }
    }

    /**
     * Calculate escrow fee
     */
    function get_escrow_fee()
    {
        if ($this->input->is_ajax_request()) {
            $row = $this->input->get('row');
            $amount = $this->input->get('amount');
            if ($amount > 0) {
                $amount = $this->finance_model->get_fee($amount, Finance_model::FEE_ESCROW);
            }
            $amount = currency() . number_format($amount);
            echo response([
                'row' => $row,
                'amount' => $amount
            ]);
        }
    }

    /**
     * Assign quote to provider
     */
    function assign_quote()
    {
        $project_id = $this->input->get('id');
        $provider_id = $this->input->get('provider');
        $this->quote_model->assign_quote($project_id, $provider_id);
        redirect('project/tender');
    }

    /**
     * Accept quote
     */
    function accept_quote()
    {
        $quote_id = $this->input->get('id');
        try {
            $this->quote_model->accept_quote($quote_id);
        } catch (Exception $e) {
            $this->notify->set($e->getMessage(), Notify::ERROR);
        }
        redirect('project/project_list/2');
    }

    /**
     * Reject quote
     */
    function reject_quote()
    {
        $quote_id = $this->input->get('id');
        $this->quote_model->reject_quote($quote_id);
        redirect('project/project_list/2');
    }

    /**
     * Show entrepreneurs tendered projects
     */
    function tender()
    {
        $this->add_css([
            'application/css/css/projects.css'
        ]);

        $this->add_js([
            'application/js/pagination.js',
            'application/js/project_tender.js'
        ]);

        $options = [];
        $this->init_js(["tender.init('" . site_url() . "'," . json_encode($options) . ")"]);

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
        $orderby = [$field, $order];

        // Specific project
		$id = $this->input->get('id');

        $projects = $this->project_model->get_tender_projects($this->logged_in_user->id, $max, $orderby, $id);
        $projects_total = $this->project_model->get_tender_projects($this->logged_in_user->id, [], $orderby, $id);

        $this->outputData['projects'] = $projects;

        $this->outputData['pagination'] = get_pagination(site_url('project/tender/'), count($projects_total), $page_rows, $page);

        if (count($projects_total) == 0) {
            $this->outputData['page_numbers'] = array();
        }

        if ($this->input->is_ajax_request()) {
            echo response([
                'type' => 'table',
                'data' => $this->load->view('project/tender_table', $this->outputData, TRUE),
                'pagination' => $this->outputData['pagination']
            ]);
        } else {
            $this->load->view('project/tender', $this->outputData);
        }
    }

    /**
     * Loads My Projects page
     */
    function project_list()
    {
        // Loading CSS/JS
        $this->add_css([
            'application/css/css/tmpl-css/jQuery-plugin-progressbar.css',
            'application/css/css/projects.css'
        ]);

        $this->add_js([
            'application/js/tmpl-js/jQuery-plugin-progressbar.js',
            'application/js/pagination.js',
            'application/js/project_list.js'
        ]);

        $this->init_js(["project_list.init('" . site_url() . "')"]);

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

        $this->outputData['number_active'] = $this->project_model->get_active_projects_count($this->logged_in_user->id);
        $this->outputData['number_won'] = $this->project_model->get_won_quotes_count($this->logged_in_user->id);
        $this->outputData['number_pending'] = $this->project_model->get_pending_quotes_count($this->logged_in_user->id);
        $this->outputData['number_completed'] = $this->project_model->get_completed_projects_count($this->logged_in_user->id);
        $this->outputData['number_canceled'] = $this->project_model->get_canceled_projects_count($this->logged_in_user->id);

        // Segment
        if ($this->input->is_ajax_request()) {
            $segment = $this->input->post('segment');
        } else {
            $segment = $this->uri->segment(2);
        }

        if ($segment == '' or $segment == '1') {
            $jobs = $this->project_model->get_active_projects($this->logged_in_user->id, $max, $order_by);
            $jobs_count = $this->outputData['number_active'];
            $view = 'project/list_active';
        } elseif ($segment == '2') {
            $jobs = $this->project_model->get_won_quotes($this->logged_in_user->id, $max, $order_by);
            $jobs_count = $this->outputData['number_won'];
            $view = 'project/list_won';
        } elseif ($segment == '3') {
            $jobs = $this->project_model->get_pending_quotes($this->logged_in_user->id, $max, $order_by);
            $jobs_count = $this->outputData['number_pending'];
            $view = 'project/list_pending';
        } elseif ($segment == '4') {
            $jobs = $this->project_model->get_completed_projects($this->logged_in_user->id, $max, $order_by);
            $jobs_count = $this->outputData['number_completed'];
            $view = 'project/list_completed';
        } elseif ($segment == '5') {
            $jobs = $this->project_model->get_canceled_projects($this->logged_in_user->id, $max, $order_by);
            $jobs_count = $this->outputData['number_canceled'];
            $view = 'project/list_canceled';
        } else {
            // Fallback
            return;
        }

        $this->outputData['view'] = $view;
        $this->outputData['projects'] = $jobs;
        $this->outputData['pagination'] = get_pagination(site_url('project/project_list'), $jobs_count, $page_rows, $page);

        if ($jobs_count == 0) {
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
                    'data' => $this->load->view($view, $this->outputData, TRUE)
                ]);
            }
        } else {
            $this->load->view('project/list', $this->outputData);
        }
    }

    /**
     * View project details
     */
    function view()
    {
        load_lang('enduser/messages');

        $this->add_css([
            'application/css/css/tmpl-css/jQuery-plugin-progressbar.css',
            'application/css/css/projects.css'
        ]);

        $this->add_js([
            'application/js/tmpl-js/jQuery-plugin-progressbar.js',
            'application/js/amcharts/amcharts.js',
            'application/js/amcharts/serial.js',
            'application/js/pagination.js'
        ]);

        $segment = $this->input->post('segment');

        // Project
        $project_id = $this->input->get('id');
        if ($project_id == '') {
            $project_id = $this->input->post('id');
        }
        $project = $this->project_model->get_project_by_id($project_id);
        if ($project['id'] == NULL) {
            $this->notify->set('Project does not exist', Notify::ERROR);
            redirect('information');
        } elseif (!not_yet_active($project['job_status']) and $project['creator_id'] != $this->logged_in_user->id and $project['employee_id'] != $this->logged_in_user->id) {
            $this->notify->set('You cannot view this project', Notify::ERROR);
            redirect('information');
        }
        $this->outputData['project'] = $project;

        // Client
        if (isEntrepreneur()) {
            $this->outputData['client'] = $this->user_model->get_name($project['employee_id']);
        } elseif (isProvider()) {
            $this->outputData['client'] = $this->user_model->get_name($project['creator_id']);
        } else {
            // Fallback
            $this->outputData['client'] = '';
        }

        $this->outputData['view_mode'] = 'false';

        // Additional data
        if (!$this->input->is_ajax_request()) {
            $this->view_milestones($project_id);
            $this->view_messages($project_id);

            // Portfolio
            if (isset($project['portfolio_id']) and $project['portfolio_id'] != '') {
                $this->load->model('machinery_model');
                $this->outputData['portfolio'] = $this->machinery_model->get_machinery_by_id($project['portfolio_id']);
            }

            // Timeline
            $milestones_chart = [];
            foreach ($project['milestones'] as $milestone) {
                $milestones_chart[] = [
                    'category' => $milestone['name'],
                    'open' => date('Y/m/d', $milestone['start_date']),
                    'close' => date('Y/m/d', $milestone['due_date'])
                ];
            }
            $this->outputData['milestones_chart'] = json_encode($milestones_chart);

            // Cases
            $this->load->model('cancel_model');
            $this->outputData['cases'] = $this->cancel_model->get_project_cases($project_id);

            // Invoices
            $this->load->model('finance_model');
            $this->outputData['invoices'] = $this->finance_model->get_invoice($project_id);

            $paid = $this->finance_model->get_project_payment_paid($project_id);
            $due = $this->finance_model->get_project_payment_due($project_id);
            $escrow = $this->finance_model->get_project_payment_escrow($project_id);

            $this->outputData['payment_due'] = $due - ($paid + $escrow);

            // Reviews
            $this->outputData['reviews'] = $this->project_model->get_project_review($project_id, $this->logged_in_user->id);
			$this->outputData['reverse_reviews'] = $this->project_model->get_project_review($project_id, NULL, $this->logged_in_user->id);

            $this->load->view('project/view', $this->outputData);
        } elseif ($segment == 1) {
            $this->view_milestones($project_id);
        } elseif ($segment == 2) {
            $this->view_messages($project_id);
        }
    }

    /**
     * Milestones table for project details
     *
     * @param $project_id
     */
    function view_milestones($project_id = '', $view_mode = false)
    {
        if ($this->input->is_ajax_request()) {
            $project_id = $this->input->post('id');
        }

        $project = $this->project_model->get_project_by_id($project_id);

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

        $milestones = $this->project_model->get_project_milestones_table($project_id, $max, $order_by, $project['creator_id']);
        $milestones_total = $this->project_model->get_project_milestones_table($project_id, '', '');

        $this->outputData['milestones'] = $milestones;
        $this->outputData['milestones_pagination'] = get_pagination(site_url('project/view'), count($milestones_total), $page_rows, $page);

        if (!$view_mode) {
            if ($this->input->is_ajax_request()) {
                echo response([
                    'type' => 'table',
                    'data' => $this->load->view('project/view_milestone_table', $this->outputData, TRUE),
                    'pagination' => $this->outputData['milestones_pagination']
                ]);
            }
        }
    }

    /**
     * Messages for project details
     *
     * @param $project_id
     */
    function view_messages($project_id = '', $view_mode = false)
    {
        if ($this->input->is_ajax_request()) {
            $project_id = $this->input->post('id');
        }

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

        $messages = $this->messages_model->get_project_messages($project_id, $max, $order_by);
        $messages_total = $this->messages_model->get_project_messages($project_id, '', '');

        $this->outputData['messages'] = $messages;
        $this->outputData['messages_pagination'] = get_pagination(site_url('project/view_messages'), count($messages_total), $page_rows, $page);

        if (!$view_mode) {
            if ($this->input->is_ajax_request()) {
                echo response([
                    'type' => 'table',
                    'data' => $this->load->view('project/view_messages', $this->outputData, TRUE),
                    'pagination' => $this->outputData['messages_pagination']
                ]);
            }
        }
    }

    /**
     * Close project
     */
    function close()
    {
        $project_id = $this->input->get('id');
        $project = $this->project_model->get_project_by_id($project_id);
        if ($project['id'] == NULL) {
            /*Flash*/
            $success_msg = t('Project does not exist');
            $this->notify->set($success_msg, Notify::ERROR);
            /*End Flash*/
            redirect('information');
        } elseif ($project['creator_id'] != $this->logged_in_user->id) {
            /*Flash*/
            $success_msg = t('Project can only be closed by its creator');
            $this->notify->set($success_msg, Notify::ERROR);
            /*End Flash*/
            redirect('information');
        } elseif ($project['job_status'] != 4) {
            /*Flash*/
            $success_msg = t('Project cannot be closed');
            $this->notify->set($success_msg, Notify::ERROR);
            /*End Flash*/
            redirect('information');
        }

        try {
            $this->project_model->close_project($project_id);
        } catch (Exception $e) {
            $this->notify->set($e->getMessage(), Notify::ERROR);
            redirect('information');
        }

        redirect('project/project_list/4');
    }

    /**
     * Close project
     */
    function close_milestone()
    {
        if ($this->input->is_ajax_request()) {
            $milestone_id = $this->input->get('id');
            $milestone = $this->project_model->get_milestone_by_id($milestone_id);
            $project = $this->project_model->get_project_by_id($milestone['job_id']);
            if ($milestone['id'] == NULL) {
                echo response('Milestone does not exist', TRUE);
                return;
            } elseif ($project['creator_id'] != $this->logged_in_user->id) {
                echo response('Milestone can only be closed by its creator', TRUE);
                return;
            } elseif ($project['job_status'] != 4 or $milestone['status'] != 0) {
                echo response('Milestone cannot be closed', TRUE);
                return;
            }

            try {
                $this->project_model->close_milestone($project['id'], $milestone_id);
                echo response(NULL);
            } catch (Exception $e) {
                echo response($e->getMessage(), TRUE);
                return;
            }
        }
    }

    /**
     * Set milestone completion
     */
    function save_milestone_completion()
    {
        if ($this->input->is_ajax_request()) {
            $milestone_id = $this->input->get('id');
            $milestone = $this->project_model->get_milestone_by_id($milestone_id);
            $project = $this->project_model->get_project_by_id($milestone['job_id']);
            if ($milestone['id'] == NULL) {
                echo response('Milestone does not exist', TRUE);
                return;
            } elseif ($project['creator_id'] != $this->logged_in_user->id and $project['employee_id'] != $this->logged_in_user->id) {
                echo response('Milestone can only be edited by its creator or by supplier', TRUE);
                return;
            } elseif ($project['job_status'] != 4 or $milestone['status'] != 0) {
                echo response('Milestone cannot be edited', TRUE);
                return;
            }

            $completion = $this->input->post('completion');
            if (!isset($completion) or !is_numeric($completion) or $completion < 0 or $completion > 100) {
                echo response('Wrong parameter', TRUE);
                return;
            }

            try {
                $this->project_model->save_milestone_completion($milestone_id, $completion);
                echo response(NULL);
            } catch (Exception $e) {
                echo response($e->getMessage(), TRUE);
                return;
            }
        }
    }

    /**
     * Review/rate project
     */
    function review()
    {
        try {
            $this->add_css([
                'application/css/css/jquery.rateyo.min.css'
            ]);

            $this->add_js([
                'application/js/jquery.rateyo.min.js'
            ]);

            $project_id = $this->input->get('id');
            if ($project_id == '') {
                $project_id = $this->input->post('project_id');
            }

            $paid = $this->finance_model->get_project_payment_paid($project_id);
            $due = $this->finance_model->get_project_payment_due($project_id);
            $escrow = $this->finance_model->get_project_payment_escrow($project_id);

            $due = $due - ($paid + $escrow);

            $project = $this->project_model->get_project_by_id($project_id);
            if (!isset($project['id'])) {
                /*Flash*/
                $success_msg = t('Project does not exist.');
                $this->notify->set($success_msg, Notify::ERROR);
                /*End Flash*/
                redirect_back();
            } elseif ($project['creator_id'] != $this->logged_in_user->id and $project['employee_id'] != $this->logged_in_user->id) {
                /*Flash*/
                $success_msg = t('Project can only be reviewed by its creator or assigned supplier.');
                $this->notify->set($success_msg, Notify::ERROR);
                /*End Flash*/
                redirect_back();
            } elseif (!in_array($project['job_status'], [Project_model::PROJECT_STATUS_COMPLETED, Project_model::PROJECT_STATUS_CANCELED])) {
				/*Flash*/
				$success_msg = t('Project must be closed to be rated.');
				$this->notify->set($success_msg, Notify::ERROR);
				/*End Flash*/
				redirect_back();
			} elseif ($project['job_status'] == Project_model::PROJECT_STATUS_COMPLETED && $due > 0) {
				$success_msg = t('Project is not fully paid.');
				$this->notify->set($success_msg, Notify::ERROR);
				redirect_back();
			}
            $this->outputData['project_id'] = $project_id;

            $review = $this->project_model->get_project_review($project_id, $this->logged_in_user->id);
            if (isset($review)) {

                /*Flash*/
                $success_msg = t('Project is already reviewed.');
                $this->notify->set($success_msg, Notify::ERROR);
                /*End Flash*/
                redirect_back();
            }

            // Post form
            if ($this->input->post('submit') != '') {
                $ratings = NULL;
                if ($this->input->post('ratings') != '') {
                    $ratings = $this->input->post('ratings');
                    foreach ($ratings as $i => $val) {
                        $ratings[$i]['user_id'] = isEntrepreneur() ? $project['employee_id'] : $project['creator_id'];
                        if ($ratings[$i]['rating'] == '') {
                            $ratings[$i]['rating'] = 0;
                        }
                    }
                }

                $data = [
                    'reviewer_id' => $this->logged_in_user->id,
                    'reviewee_id' => isEntrepreneur() ? $project['employee_id'] : $project['creator_id'],
                    'job_id' => $project['id'],
                    'comments' => $this->input->post('comments'),
                    'review_time' => get_est_time(),
                    'ratings' => $ratings
                ];

                try {
                    $this->project_model->post_review($data);
                    /*Flash*/
                    $success_msg = t('Project is successfully reviewed.');
                    $this->notify->set($success_msg, Notify::SUCCESS);
                    /*End Flash*/
                    redirect(site_url('project/view?id=' . $project_id));
                } catch (Exception $e) {
                    $this->notify->set($e->getMessage(), Notify::ERROR);
                }
            }

            $role = isEntrepreneur() ? 2 : 1;
            $this->outputData['rating_categories'] = $this->user_model->get_rating_categories($role);

            // Pre-rate delivery time
            if ($project['job_status'] == 5) {
                $time = $project['enddate'] - $project['due_date'];
                if ($time <= 0) {
                    $time_rating = 5;
                } elseif ($time <= DAY) {
                    $time_rating = 4;
                } elseif ($time <= 3 * DAY) {
                    $time_rating = 3;
                } elseif ($time <= 5 * DAY) {
                    $time_rating = 2;
                } elseif ($time <= 2 * WEEK) {
                    $time_rating = 1;
                } else {
                    $time_rating = 0;
                }
            } else {
                $time_rating = 0;
            }
            $this->outputData['time_rating'] = $time_rating;

            $this->load->view('project/review', $this->outputData);
        } catch (Exception $e) {
            $this->notify->set($e->getMessage(), Notify::ERROR);
            redirect_back();
        }
    }

    /**
     * Save invoice
     */
    function invoice()
    {
        try {
            $this->load->model('finance_model');

            $project_id = $this->input->get('project');
            $milestone_id = $this->input->get('milestone');

            $project = $this->project_model->get_project_by_id($project_id);
            if (!isset($project)) {
                /*Flash*/
                $success_msg = t('Project does not exist');
                $this->notify->set($success_msg, Notify::ERROR);
                /*End Flash*/
                redirect_back();
            } elseif ($project['employee_id'] != $this->logged_in_user->id) {
                /*Flash*/
                $success_msg = t('Only assigned supplier may send invoice');
                $this->notify->set($success_msg, Notify::ERROR);
                /*End Flash*/
                redirect_back();
            }

            $this->finance_model->save_invoice($project_id, $milestone_id);
            /*Flash*/
            $success_msg = t('Invoice sent');
            $this->notify->set($success_msg, Notify::SUCCESS);
            /*End Flash*/
            redirect_back();
        } catch (Exception $e) {
            $this->notify->set($e->getMessage(), Notify::ERROR);
            redirect_back();
        }
    }

    /**
     * Get project info for additional data (popover)
     */
    function project_info()
    {
        $result = ['data' => '', 'error' => false];

        if ($this->input->is_ajax_request()) {

            // Project
            $project_id = $this->input->get('id');
            if ($project_id == '') {
                $project_id = $this->input->post('id');
            }

            $project = $this->project_model->get_project_by_id($project_id);

            if ($project['id'] == NULL) {
                $result = ['data' => 'Project does not exist', 'error' => true];

            } elseif (!not_yet_active($project['job_status']) and $project['creator_id'] != $this->logged_in_user->id and $project['employee_id'] != $this->logged_in_user->id) {
                $result = ['data' => 'You cannot view this project', 'error' => true];
            } else {
                $this->outputData['project'] = $project;

                // Client
                if (isEntrepreneur()) {
                    $this->outputData['client'] = $this->user_model->get_name($project['employee_id']);
                } elseif (isProvider()) {
                    $this->outputData['client'] = $this->user_model->get_name($project['creator_id']);
                } else {
                    // Fallback
                    $this->outputData['client'] = '';
                }

                $this->outputData['view_mode'] = 'true';

                $this->view_milestones($project_id, true);
                $this->view_messages($project_id, true);

                // Portfolio
                if (isset($project['portfolio_id']) and $project['portfolio_id'] != '') {
                    $this->load->model('machinery_model');
                    $this->outputData['portfolio'] = $this->machinery_model->get_machinery_by_id($project['portfolio_id']);
                }

                // Timeline
                $milestones_chart = [];
                foreach ($project['milestones'] as $milestone) {
                    $milestones_chart[] = [
                        'category' => $milestone['name'],
                        'open' => date('Y/m/d', $milestone['start_date']),
                        'close' => date('Y/m/d', $milestone['due_date'])
                    ];
                }
                $this->outputData['milestones_chart'] = json_encode($milestones_chart);

                // Cases
                $this->load->model('cancel_model');
                $this->outputData['cases'] = $this->cancel_model->get_project_cases($project_id);

                // Invoices
                $this->load->model('finance_model');
                $this->outputData['invoices'] = $this->finance_model->get_invoice($project_id);
                $this->outputData['payment_due'] = $this->finance_model->get_project_payment_due($project_id);

                // Reviews
                $this->outputData['reviews'] = $this->project_model->get_project_review($project_id, $this->logged_in_user->id);
                $this->outputData['reverse_reviews'] = $this->project_model->get_project_review($project_id, NULL, $this->logged_in_user->id);

                $result = ['data' => ['html' => $this->load->view('project/view_modal', $this->outputData, TRUE)], 'error' => false];
            }
        }

        echo response($result['data'], $result['error']);
    }

    public function reset_form($project_id = 0)
    {

        $this->session->unset_userdata('proj_files');
        $this->session->unset_userdata('proj_form_data');

        redirect('/project/create' . ($project_id ? '?id=' . $project_id : ''));
    }

	/**
	 * Get workflow breadcrumbs
	 */
    public function workflow()
	{
		$id = $this->input->get('id');
		if (empty($id)) {
			echo response('Incorrect key', TRUE);
		}
        $_SESSION['show_workflow'] = true;
		$_SESSION['workflow_id'] = $id;

		$res = $this->get_workflow($id);
		$_SESSION['workflow'] = $res['view'];
		redirect($res['url']);
	}



    /**
     * @return null
     */
    public function export_pdf()
    {

        $project_id = $this->input->get('id');
        if ($project_id == '') {
            $this->notify->set(t('Project does not exist'), Notify::ERROR);
            redirect('information');
        }

        $this->outputData['project_id'] = $project_id;

        if (isEntrepreneur()) {
            $provider_id = $this->input->get('provider');
            $quote = $this->quote_model->get_latest_quote($project_id, $provider_id);
            $this->outputData['provider_id'] = $provider_id;

        } elseif (isProvider()) {
            $quote = $this->quote_model->get_latest_quote($project_id, $this->logged_in_user->id);
            $this->outputData['provider_id'] = $this->logged_in_user->id;
        } else {
            // Fallback
            $quote = NULL;
        }
        if(!$quote){
            $this->notify->set(t('Project does not exist'), Notify::ERROR);
            redirect('information');
        }
        $this->outputData['quote'] = $quote;

        $view =  $this->load->view('project/export_pdf', $this->outputData,true);

        // Generate PDF
        $dompdf = new Dompdf();
        $dompdf->loadHtml($view);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('project_'.$project_id.".pdf", array("Attachment" => 1));

    }

    public function download_attachments(){
        $project_id = $this->input->get('id');
        if ($project_id == '') {
            $this->notify->set(t('Project does not exist'), Notify::ERROR);
            redirect('information');
        }

        if (isEntrepreneur()) {
            $provider_id = $this->input->get('provider');
            $quote = $this->quote_model->get_latest_quote($project_id, $provider_id);
            $this->outputData['provider_id'] = $provider_id;

        } elseif (isProvider()) {
            $quote = $this->quote_model->get_latest_quote($project_id, $this->logged_in_user->id);
            $this->outputData['provider_id'] = $this->logged_in_user->id;
        } else {
            // Fallback
            $quote = NULL;
        }

        if(!$quote){
            $this->notify->set(t('Project does not exist'), Notify::ERROR);
            redirect('information');
        }

        # create new zip object
        $zip = new ZipArchive();
        # create a temp file & open it
        $tmp_file = tempnam(FCPATH.'files/', '');
        $zip->open($tmp_file, ZipArchive::CREATE);

        # loop through each file
        foreach ($quote['attachments'] as $this->outputData['attachment']) {
            $file = $this->outputData['attachment']['img_url'];
            # download file
            $download_file = file_get_contents(FCPATH.$file);
            #add it to the zip
            $zip->addFromString(basename($file), $download_file);
        }

        # close zip
        $zip->close();
        $file_name = 'project_'.$project_id.'_attachments.zip';
        # send the file to the browser as a download
        header('Content-disposition: attachment; filename="'.$file_name.'"');
        header('Content-type: application/zip');
        readfile($tmp_file);
        unlink($tmp_file);
    }

}