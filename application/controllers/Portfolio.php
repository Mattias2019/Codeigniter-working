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

class Portfolio extends MY_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->library('pagination');
        $this->load->library('settings');

        //Get Config Details From Db
        $this->settings->db_config_fetch();

        //Manage site Status
        if ($this->config->item('site_status') == 1) {
            redirect('offline');
        }

        //Load the helper file
        $this->load->helper('form');

        //language file
        load_lang('enduser/portfolio');

        //Load Models
        $this->load->model('common_model');
        $this->load->model('file_model');
        $this->load->model('machinery_model');
        $this->load->model('skills_model');
    }

    /**
     * Show user portfolio
     */
    function user()
    {

        try {
            load_lang('enduser/search');

            $this->add_css([
                'application/css/css/machinery.css'
            ]);

            // User
            $user_id = $this->input->get('id');

            // Get number of items already shown
            $offset = $this->input->post('offset');
            if ($offset == NULL) {
                $offset = 0;
            }
            $page_rows = 12;
            $max = [$page_rows, $offset];

            $portfolios = $this->machinery_model->get_machinery_by_user($user_id, $max);
            $portfolios_total = $this->machinery_model->get_machinery_by_user($user_id);

            if (count($portfolios_total) == 0) {
                $this->notify->set(t('Member has no portfolio'), Notify::ERROR);
                redirect('information');
            }

            $this->outputData['compare'] = FALSE;
            $this->outputData['load_all'] = (count($portfolios) == count($portfolios_total));
            $this->outputData['count_all'] = (count($portfolios_total));
            $this->outputData['portfolios'] = $portfolios;

            $this->outputData['parent_controller'] = 'portfolio/user';

            if ($this->input->is_ajax_request()) {
                echo response([
                    'type' => 'table',
                    'data' => $this->load->view('search/machinery_table', $this->outputData, TRUE),
                    'count_all' => $this->outputData['count_all']
                ]);
            } else {
                $this->load->view('search/machinery_user', $this->outputData);
            }
        } catch (Exception $e) {
            $this->notify->set(t('Somme error'), Notify::ERROR);
            redirect('information');
        }
    }

    /**
     * Load portfolio details
     */
    function view()
    {
        $this->outputData['false'] = true;
        $this->add_css([
            'application/plugins/bxslider/src/css/jquery.bxslider.css',
            'application/css/css/jquery.rateyo.min.css',
        ]);

        $this->add_js([
            'application/plugins/bxslider/src/js/jquery.bxslider.js',
            'application/js/jquery.rateyo.min.js',
            'application/js/readmore.js',
        ]);

        // language file
        load_lang('enduser/editProfile');


        if ($this->session->userdata('view_portfolio') == '0') {
            $this->notify->set('You do not have the permission to view portfolio', Notify::ERROR);
            redirect('information');
        }

        $portfolio_id = $this->input->get('id');
        if (!is_numeric($portfolio_id) && empty($this->session->userdata('portfolio'))) {
            $this->notify->set('You can not access to this page', Notify::ERROR);
            redirect('information');
        }

        if (empty($this->session->userdata('portfolio'))) {
            $this->outputData['portfolio'] = $this->machinery_model->get_machinery_by_id($portfolio_id);
        } else {
            $this->outputData['portfolio'] = $this->session->userdata('portfolio');
            $this->outputData['preview'] = true;
        }

        $this->outputData['supplier'] = $this->user_model->getUsers(['users.id' => $this->outputData['portfolio']['user_id']])->row_array();
        $rating_categories = $this->user_model->get_rating_categories($this->outputData['supplier']['role_id']);
        $count = count($rating_categories);
        for ($i = 0; $i < $count; $i++) {
            $rating_categories[$i]['rating'] = $this->user_model->get_user_rating($this->outputData['supplier']['id'], $rating_categories[$i]['id']);
        }
        $this->outputData['rating_categories'] = $rating_categories;
        $this->outputData['supplier']['img_logo'] = $this->file_model->get_user_logo_path($this->outputData['supplier']['id'], $this->outputData['supplier']['logo']);
        // Get Categories
        $this->outputData['categories'] = $this->skills_model->getCategories();

        $this->load->view('portfolio/view', $this->outputData);
    }

    /**
     * Manage portfolio/machinery
     */
    function manage()
    {
        // Load validation library
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        $this->add_css([
            'application/css/css/dropzone.css',
            'application/css/css/build.css',
            'application/css/css/multiselect.css?v='.time(),
            "application/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css",
        ]);

        $this->add_js([
            'application/js/dropzone.js',
            'application/js/dropdown.js',
            'application/js/jquery.inputmask.bundle.min.js',
            'application/js/custom-inputmask.js',
            'application/js/portfolio_manage.js',
            "application/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js",
            "application/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js",
            "application/js/jquery.wysihtml5_size_matters.js"
        ]);

        $this->init_js(["portfolio_manage.init('" . site_url() . "');"]);

        // Check id if supplied, and if portfolio is eligible for editing
        $portfolio_id = $this->input->get('id');
        if ($portfolio_id != NULL) {
            $portfolio = $this->machinery_model->get_machinery_by_id($portfolio_id);
            if ($portfolio['id'] == NULL) {
                $this->notify->set('Portfolio does not exist', Notify::ERROR);
                redirect('information');
            } elseif (!$this->machinery_model->portfolio_is_avaible($this->logged_in_user->id)) {
                $this->notify->set('Portfolio can only be edited by its creator', Notify::ERROR);
                redirect('information');
            } else {
                $this->outputData['portfolio'] = $portfolio;
            }
        }

        // Submit
        if ($this->input->post('submit')) {

            // Set rules
            $this->form_validation->set_rules('title', 'lang:Title', 'required|trim|xss_clean|no_email|no_phone_number');
            $this->form_validation->set_rules('machine_description', 'lang:Description', 'required|trim|xss_clean|no_email|no_phone_number');
            $this->form_validation->set_rules('payment_method', 'lang:"Payment Method"', 'required');
            $this->form_validation->set_rules('price', 'lang:Price', 'required|trim|integer|is_natural|abs|xss_clean');
            $this->form_validation->set_rules('categories', 'lang:Category', 'required');
            // Items
            if ($this->input->post('standard_items')) {
                foreach ($this->input->post('standard_items') as $i => $val) {
                    $this->form_validation->set_rules('standard_items[' . $i . '][value]', 'lang:Value', 'required|trim|xss_clean|no_email|no_phone_number');
                }
            }
            if ($this->input->post('custom_items')) {

                foreach ($this->input->post('custom_items') as $i => $val) {
                    $this->form_validation->set_rules('custom_items[' . $i . '][name]', 'lang:Name', 'required|trim|xss_clean|no_email|no_phone_number');
                    $this->form_validation->set_rules('custom_items[' . $i . '][value]', 'lang:Value', 'required|trim|xss_clean|no_email|no_phone_number');
                }
            }

            if ($this->form_validation->run()) {

                // Preparing data
                $data = [];
                $data['id'] = $this->input->post('id');
                if ($data['id'] == '') {
                    $data['id'] = NULL;
                }
                $data['title'] = $this->input->post('title');
                $data['machine_description'] = $this->input->post('machine_description');
                $data['price'] = $this->input->post('price');
                if ($data['price'] == '') {
                    $data['price'] = 0;
                }
                $data['payment_method'] = $this->input->post('payment_method');

                $data['user_id'] = $this->input->post('user_id');
                if ($data['user_id'] == '') {
                    $data['user_id'] = $this->logged_in_user->id;
                }

                $data['categories'] = $this->input->post('categories');

                $data['attachments'] = invert_array($this->input->post('attachments'));
                $data['standard_items'] = $this->input->post('standard_items');
                $data['custom_items'] = $this->input->post('custom_items');

                $this->machinery_model->save_machinery($data);

                /*Flash*/
                $success_msg = t('Success');
                $this->notify->set($success_msg, Notify::SUCCESS);
                /*End Flash*/
                $this->session->unset_userdata('portfolio'); //unset session
                redirect($this->uri->uri_string());
                // Clean up
                //$this->file_model->clear_temp($this->logged_in_user->id);
            }
        }
        else if ($this->input->post('reset')) {

            $this->session->unset_userdata('portfolio'); //unset session
            $this->session->unset_userdata('attachments'); //unset session

            $success_msg = t('Reset success');
            $this->notify->set($success_msg, Notify::SUCCESS);

            redirect($this->uri->uri_string());
        }
        else if ($this->input->post('preview')) {

            if (empty($this->input->post('id'))) {

                $success_msg = t('Fill out the form for portfolio preview');
                $this->notify->set($success_msg, Notify::ERROR);

                redirect('portfolio/manage');
            }

            $this->session->set_userdata(['portfolio' => $this->input->post()]);

            $sessionPortfolio = $this->session->userdata('portfolio');
            if (!empty($sessionPortfolio['attachments'])) {
                $sessionPortfolio['attachments'] = $this->machinery_model->generateAtachSession($sessionPortfolio['attachments']);
            }
            $sessionPortfolio['user_id'] = $this->logged_in_user->id;
            $this->session->set_userdata(['portfolio' => $sessionPortfolio]);
            redirect('portfolio/view');
        }

        /*set session*/
        if (!empty($this->session->userdata('portfolio'))) {
            $this->outputData['portfolio'] = $this->session->userdata('portfolio');
        }
        /*end set session*/

        $this->outputData['groups_with_categories'] = $this->skills_model->getGroupsWithCategory([], $this->logged_in_user->id);
        $this->outputData['search_type'] = '1';
        $this->outputData['my_portfolios'] = $this->machinery_model->get_portfolio_thumbs($this->logged_in_user->id);

        $this->outputData['user_id'] = $this->logged_in_user->id;

        $this->load->view('portfolio/manage', $this->outputData);
    }

    /**
     * Get items for selected category
     */
    function get_standard_items()
    {
        if ($this->input->is_ajax_request()) {
            $view = '';
            $categories = $this->input->post('categories');
            $this->outputData['portfolio_standard_items'] = $this->machinery_model->get_machinery_items_by_category($categories);
            if (is_array($this->outputData['portfolio_standard_items'])) {
                $this->outputData['standard_item_number'] = 0;
                foreach ($this->outputData['portfolio_standard_items'] as $item) {
                    $this->outputData['standard_item_value'] = $item;
                    $view = $view . ($this->load->view('portfolio/manage_standard_items', $this->outputData, TRUE));
                    $this->outputData['standard_item_number']++;
                }
                echo response($view);
            } else {
                echo response('');
            }
        }
    }

    /**
     * View of custom item for AJAX request from Create project page
     */
    function create_custom_item()
    {
        if ($this->input->is_ajax_request()) {

            $this->outputData['custom_item_number'] = $this->input->post('item');
            $this->outputData['custom_item_value'] = [];
            echo response($this->load->view('portfolio/manage_custom_items', $this->outputData, TRUE));
        }
    }

    /**
     * Store files from dropzone.js
     */
    function upload_files()
    {
        if (isset($_FILES) and is_array($_FILES) and array_key_exists('file', $_FILES)) {
            $this->load->library('upload');
            $this->load->library('image_lib');

            $config['upload_path'] = $this->file_model->temp_dir($this->logged_in_user->id);
            /* For some reason, listing MIME types do not work */
            $config['allowed_types'] = 'bmp|BMP|gif|GIF|jpg|JPG|jpeg|JPEG|png|PNG|pdf|PDF|docx|DOCX|doc|DOC|XLS|xls|XLSX|xlsx|ZIP|zip';
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
                if ($data['is_image']) {
                    $resize = [
                        'source_image' => $data['full_path'],
                        'maintain_ratio' => true,
//                        'width' => 640,
//                        'height' => 480
                    ];
                    $this->image_lib->initialize($resize);
                    $this->image_lib->resize();
                }
                // Load attachment view
                $this->outputData['attachment'] = [
                    'id' => NULL,
                    'name' => $data['raw_name'],
                    'ori_name' => $data['orig_name'],
                    'ext' => $data['file_ext'],
                    'filesize' => filesize($data['full_path']),
                    'url' => '/' . $config['upload_path'] . $data['file_name']
                ];
                $this->load->view('portfolio/manage_attachment', $this->outputData);
            }
        }
    }

    /**
     * AJAX request to delete portfolio
     */
    function delete()
    {
        if ($this->input->is_ajax_request()) {
            //Check id if supplied, and if project is eligible for editing
            $machinery_id = $this->input->get('id');
            if ($machinery_id != NULL) {
                $machinery = $this->machinery_model->get_machinery_by_id($machinery_id);
                if ($machinery['id'] == NULL) {

                    echo response('Machinery does not exist', TRUE);
                    return;
                } elseif ($machinery['user_id'] != $this->logged_in_user->id) {

                    echo response('Machinery can only be edited by its creator', TRUE);
                    return;
                }
            } else {
                echo response('Machinery does not exist', TRUE);
                return;
            }

            $this->machinery_model->delete_machinery($machinery_id);
            echo response(NULL);
        }
    }
}