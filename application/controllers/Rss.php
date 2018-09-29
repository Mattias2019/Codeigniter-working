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

class Rss extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->library('settings');

        //Get Config Details From Db
        $this->settings->db_config_fetch();

        //Manage site Status
        if ($this->config->item('site_status') == 1)
            redirect('offline');

        //Load Models
        $this->load->model('common_model');
        $this->load->model('rss_model');
        $this->load->model('skills_model');
        $this->load->model('user_model');

        $this->load->helper('url');
        $this->load->helper('xml');
        $this->load->helper('text');

        //language file
        load_lang('enduser/rss');

        //Rss Feed Limit - can be modified by user input
        $this->outputData['limit_feed'] = 15;
    }

    /**
     * Loads RSS page
     *
     * @param $segment
     */
    function index($segment = '')
    {
        try {
            $this->load->library('form_validation');
            $this->load->helper('form');
            $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

            $this->add_css([
                'application/css/css/rssfeed.css',
                'application/css/css/build.css',
                'application/css/css/multiselect.css?v='.time(),
                'application/css/css/themes/smoothness/jquery-ui.min.css',
                'application/css/css/custom-slider.css'
            ]);

            $this->add_js([
                'application/js/dropdown.js',
                'application/js/jquery.inputmask.bundle.min.js',
                'application/js/custom-slider.js',
                'application/js/pagination.js',
                'application/js/rss.js'
            ]);

            $options['budget_min'] = 0;
            $options['budget_max'] = 0;

            $this->init_js("rss.init('" . site_url() . "'," . json_encode($options) . ")");

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

            // Segment
            if ($this->input->is_ajax_request()) {
                $segment = $this->input->post('segment');
            } elseif ($segment == '') {
                $segment = $this->uri->segment(2);
            }

            // Get existing feed
            $post_id = $this->input->post('id');
            if ($post_id != '') {
                $feed = $this->rss_model->get_custom_feed($post_id);
                if (!isset($feed)) {
                    /*Flash*/
                    $success_msg = t('RSS feed does not exist.');
                    $this->notify->set($success_msg, Notify::ERROR);
                    /*End Flash*/
                    redirect_back();
                } elseif ($feed['user_id'] != $this->logged_in_user->id) {
                    /*Flash*/
                    $success_msg = t('RSS feed can only be edited by its creator.');
                    $this->notify->set($success_msg, Notify::ERROR);
                    /*End Flash*/
                    redirect_back();
                } else {
                    $this->outputData['feed'] = $feed;
                }
            }

            // Submit form
            if ($this->input->post('submit') != '') {
                $this->form_validation->set_rules('limit_feed', t('No of projects to display'), 'required|trim|integer|is_natural|abs|xss_clean');
                $this->form_validation->set_rules('type', t('Info to display'), 'required|trim|integer|is_natural|abs|xss_clean');

                if ($this->form_validation->run()) {
                    $data = [
                        'id' => $this->input->post('id'),
                        'user_id' => $this->logged_in_user->id,
                        'type' => $this->input->post('type'),
                        'budget_min' => ($this->input->post('budget_min') == '') ? 0 : $this->input->post('budget_min'),
                        'budget_max' => ($this->input->post('budget_max') == '') ? 0 : $this->input->post('budget_max'),
                        'limit_feed' => $this->input->post('limit_feed'),
                        'categories' => explode(',', $this->input->post('categories'))
                    ];

                    try {
                        $id = $this->rss_model->save_custom_feed($data);

                        unset($this->outputData['feed']);

                    } catch (Exception $e) {
                        $this->notify->set($e->getMessage(), Notify::ERROR);
                    }
                }
            }

            // Load data
            if ($segment == '' or $segment == '1') {
                $feeds = $this->skills_model->get_user_categories_with_groups($this->logged_in_user->id, $max);
                $feeds_count = count($this->skills_model->get_user_categories_with_groups($this->logged_in_user->id));
                $view = 'rss/index_all';
            } elseif ($segment == '2') {
                $feeds = $this->rss_model->get_user_custom_feeds($this->logged_in_user->id, $max, $order_by);
                $feeds_count = count($this->rss_model->get_user_custom_feeds($this->logged_in_user->id, '', ''));
                $view = 'rss/index_custom';
            } else {
                // Fallback
                return;
            }

            $this->outputData['view'] = $view;
            $this->outputData['feeds'] = $feeds;
            $this->outputData['pagination'] = get_pagination(site_url('project/project_list'), $feeds_count, $page_rows, $page);
            $this->outputData['groups_with_categories'] = $this->skills_model->getGroupsWithCategory([], $this->logged_in_user->id);

            if ($feeds_count == 0) {
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
                $this->load->view('rss/index', $this->outputData);
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
     * Loads Custom RSS page
     */
    function custom()
    {
        $this->index(2);
    }

    /**
     * Loads right list in Custom Rss page
     */
    function custom_select()
    {
        if ($this->input->is_ajax_request()) {
            $categories = $this->input->post('categories');
            if ($categories != null and is_array($categories)) {
                $conditions = [
                    'categories.id' => $categories
                ];
                $this->outputData['groups_with_categories'] = $this->skills_model->getGroupsWithCategory([], '', [], $conditions);
            } else {
                $this->outputData['groups_with_categories'] = [];
            }
            $this->outputData['multiselect_id'] = 's2_';
            $this->outputData['multiselect_dropdown'] = FALSE;

            echo response(['data' => $this->load->view('multiselect', $this->outputData, TRUE)]);
        }
    }

    /**
     * Request to delete feed
     */
    function delete()
    {
        if ($this->input->is_ajax_request()) {
            $feed_id = $this->input->get('id');
            $feed = $this->rss_model->get_custom_feed($feed_id);
            if (!isset($feed['id'])) {
                $result = response('RSS feed does not exist', TRUE);
            } elseif ($feed['user_id'] != $this->logged_in_user->id) {
                $result = response('RSS feed may only be deleted by its creator', TRUE);
            } else {
                $this->rss_model->delete_custom_feed($feed_id);
                $result = response(['id' => $feed_id]);
            }
            echo $result;
        }
    }

    /**
     * Show standard RSS feed
     */
    function show()
    {
        $this->load->model('project_model');

        $this->outputData['rss_title'] = $this->config->item('site_title') . ' ' . t('Jobs');
        $this->outputData['rss_description'] = t('The newest jobs posted on') . ' ' . $this->config->item('site_title');

        $type = $this->input->get('type');
        $categories = $this->input->get('cat');
        if ($categories != '') {
            $categories = explode(',', $categories);
        }

        $this->outputData['type'] = $type;
        $this->outputData['projects'] = $this->project_model->get_new_projects($categories, 0, 0, [$this->outputData['limit_feed']]);

        header("Content-Type: application/rss+xml");
        $this->load->view('rss/feeds', $this->outputData);
    }

    /**
     * Show custom RSS feed
     */
    function show_custom()
    {
        $this->load->model('project_model');

        $this->outputData['rss_title'] = $this->config->item('site_title') . ' ' . t('Jobs');
        $this->outputData['rss_description'] = t('The newest jobs posted on') . ' ' . $this->config->item('site_title');

        $id = $this->input->get('id');
        $feed = $this->rss_model->get_custom_feed($id);

        $this->outputData['type'] = $feed['type'];
        $this->outputData['projects'] = $this->project_model->get_new_projects($feed['categories'], $feed['budget_min'], $feed['budget_max'], [$feed['limit_feed']]);

        header("Content-Type: application/rss+xml");
        $this->load->view('rss/feeds', $this->outputData);
    }

    /**
     * Edit custom RSS feed
     */
    function edit_custom()
    {
        if ($this->input->is_ajax_request()) {

            $this->load->library('form_validation');
            $this->load->helper('form');
            $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

            $data1 = '';
            $data2 = '';

            // Get existing feed
            $id = $this->input->post('id');
            if ($id != '') {
                $feed = $this->rss_model->get_custom_feed($id);
                if ($feed['user_id'] != $this->logged_in_user->id) {
                    /*Flash*/
                    $success_msg = t('RSS feed can only be edited by its creator.');
                    $this->notify->set($success_msg, Notify::ERROR);
                    /*End Flash*/
                    redirect_back();
                } else {
                    $this->outputData['feed'] = $feed;

                    $this->outputData['groups_with_categories'] = $this->skills_model->getGroupsWithCategory([], $this->logged_in_user->id);
                    $this->outputData['multiselect_id'] = 's1_';
                    $this->outputData['multiselect_dropdown'] = FALSE;
                    $data1 = $this->load->view('multiselect', $this->outputData, TRUE);

                    $categories = $feed['categories'];
                    if ($categories != null and is_array($categories)) {
                        $conditions = [
                            'categories.id' => $categories
                        ];
                        $this->outputData['groups_with_categories'] = $this->skills_model->getGroupsWithCategory([], '', [], $conditions);
                    } else {
                        $this->outputData['groups_with_categories'] = [];
                    }
                    $this->outputData['multiselect_id'] = 's2_';
                    $this->outputData['multiselect_dropdown'] = FALSE;

                    $data2 = $this->load->view('multiselect', $this->outputData, TRUE);
                }
            }
            echo response([
                'html' => $this->load->view('rss/index_custom_form', $this->outputData, TRUE),
                'data1' => $data1,
                'data2' => $data2
            ]);
        }
    }
}