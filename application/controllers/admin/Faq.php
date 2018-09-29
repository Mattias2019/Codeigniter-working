<?php

/*
  ****************************************************************************
  ***                                                                      ***
  ***      BIDONN 1.0                                                      ***
  ***      File:  faq.php                                                  ***
  ***      Built: Mon June 25 11:35:30 2012                                ***
  ***      http://www.maventricks.com                                      ***
  ***                                                                      ***
  ****************************************************************************
  
   <Bidonn>
    Copyright (C) <2012> <Maventricks Technologies>.
 
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
	If you want more information, please email me at sathick@maventricks.com or 
    contact us from http://www.maventricks.com/contactus
*/

class Faq extends MY_Controller
{

    // Constructor

    function __construct()
    {
        parent::__construct();

        $this->load->library('settings');

        //Get Config Details From Db
        $this->settings->db_config_fetch();

        // loading the lang files
        load_lang(array(
            'admin/common',
            'admin/faq',
            'admin/validation'));

        //Load Models
        $this->load->model('common_model');
        $this->load->model('faq_model');

        //Get Logged In user
        $this->logged_in_user = $this->common_model->get_logged_in_user();
        $this->outputData['logged_in_user'] = $this->logged_in_user;

    }//Controller End

    // --------------------------------------------------------------------

    /**
     * Loads Faqs settings page.
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function addFaq()
    {
        //load validation library
        $this->load->library('form_validation');

        //Load Form Helper
        $this->load->helper('form');

        //Intialize values for library and helpers
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        if ($this->input->post('addFaq')) {
            //Set rules
            $this->form_validation->set_rules('faq_category_id', 'lang:faq_category_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('question', 'lang:question_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('answer', 'lang:answer_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('is_frequent', 'lang:frequent_validation', 'xss_clean');

            if ($this->form_validation->run()) {
                //prepare insert data
                $insertData = array();
                $insertData['question'] = $this->input->post('question');
                $insertData['answer'] = $this->input->post('answer');
                $insertData['is_frequent'] = $this->input->post('is_frequent', 'N');
                $insertData['faq_category_id'] = $this->input->post('faq_category_id');
                $insertData['created'] = get_est_time();

                //Add Groups
                $this->faq_model->addFaq($insertData);

                //Notification message
                $this->notify->set(t('added_success'), Notify::SUCCESS);
                redirect_admin('faq/viewFaqs');
            }
        } //If - Form Submission End

        //Get Faq Categories
        $this->outputData['faqCategories'] = $this->faq_model->getFaqCategories();

        //Load View
        $this->load->view('admin/faq/addFaq', $this->outputData);
    }//End of addFaqs function

    // --------------------------------------------------------------------

    /**
     * delete Faq.
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function deleteFaq_()
    {
        $id = $this->uri->segment(4, 0);
        //delete Faq Category
        if ($id == 0) {
            $gerfaq = $this->faq_model->getFaqs();
            $faqlist = $this->input->post('faqlist');
            if (!empty($faqlist)) {
                foreach ($faqlist as $res) {
                    $condition = array('faqs.id' => $res);
                    $this->faq_model->deleteFaq(NULL, $condition);
                }
            } else {
                $this->notify->set(t('Please select FAQ'), Notify::ERROR);
                redirect_admin('faq/viewFaqs');
            }

        } else {
            $condition = array('faqs.id' => $id);
            $this->faq_model->deleteFaq(NULL, $condition);
        }
        $this->notify->set(t('delete_success'), Notify::SUCCESS);
        redirect_admin('faq/viewFaqs');
    }

    //Function end


    function deleteFaqCat()
    {
        $id = $this->uri->segment(4, 0);
        //delete Faq Category
        if ($id == 0) {
            $gerfaqcat = $this->faq_model->getFaqCategory();
            $faqlist = $this->input->post('faqlist');
            if (!empty($faqlist)) {
                foreach ($faqlist as $res) {
                    $condition = array('faq_categories.id' => $res);
                    $condition1 = array('faqs.faq_category_id' => $res);
                    $this->faq_model->deleteFaqCat(NULL, $condition, $condition1);
                }
                /* foreach($faqlist as $res)
                 {
                    $condition = array('faq_categories.id'=>$res);
                 $this->faq_model->deleteFaqCat1(NULL,$condition);
                 }*/
            } else {
                $this->notify->set(t('Please select FAQ'), Notify::ERROR);
                redirect_admin('faq/viewFaqCategories');
            }

        } else {
            $condition = array('faq_categories.id' => $id);
            // $condition1=array('faqs.faq_category_id'=>$id);
            // $this->faq_model->deleteFaqCat(NULL,$condition,$condition1);

            $this->faq_model->deleteFaqCat1(NULL, $condition);
        }
        $this->notify->set(t('delete_success'), Notify::SUCCESS);
        redirect_admin('faq/viewFaqCategories');
    }


    /**
     * Edit Faq.
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function editFaq()
    {
        //Get id of the category
        $id = is_numeric($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        //load validation library
        $this->load->library('form_validation');

        //Load Form Helper
        $this->load->helper('form');

        //Intialize values for library and helpers
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        if ($this->input->post('editFaq')) {

            //Set rules
            $this->form_validation->set_rules('faq_category_id', 'lang:faq_category_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('question', 'lang:question_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('answer', 'lang:answer_validation', 'required|trim|xss_clean');

            if ($this->form_validation->run()) {
                //prepare update data
                $updateData = array();
                $updateData['faq_category_id'] = $this->input->post('faq_category_id');
                $updateData['question'] = $this->input->post('question');
                $updateData['answer'] = $this->input->post('answer');
                $updateData['is_frequent'] = $this->input->post('is_frequent', 'N');

                //Edit Faq Category
                $this->faq_model->updateFaq($this->input->post('id', true), $updateData);

                //Notification message
                $this->notify->set(t('updated_success'), Notify::SUCCESS);
                redirect_admin('faq/viewFaqs');
            }
        } //If - Form Submission End

        //Set Condition To Fetch The Faq Category
        $condition = array('faqs.id' => $id);

        //Get Categories
        $this->outputData['faqs'] = $this->faq_model->getFaqs($condition);

        //Get Faq Categories
        $this->outputData['faqCategories'] = $this->faq_model->getFaqCategories();

        //Load View
        $this->load->view('admin/faq/editFaq', $this->outputData);

    }//End of editFaqCategory function

    // --------------------------------------------------------------------

    /**
     * Loads Faqs settings page.
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function viewFaqs()
    {
        $this->add_js([
            'application/js/admin/faq.js',
            'application/js/pagination.js'
        ]);

        $this->init_js(["faq.init('" . admin_url() . "');"]);

        //Load model
        $this->load->model('faq_model');

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

        // Segment
        if ($this->input->is_ajax_request()) {
            $segment = $this->input->post('segment');
        } else {
            $segment = $this->uri->segment(3, 0);
        }

        $faqCategories = $this->faq_model->getFaqCategories();
        $faqs = $this->faq_model->getFaqs();

        $total_faq_categories_rows = $faqCategories->num_rows();
        $total_faqs_rows = $faqs->num_rows();

        $faq_categories_detail = $this->faq_model->getFaqCategory(NULL, NULL, NULL, $limit, $orderby);
        $this->outputData['faqCategories'] = $faq_categories_detail;

        $faqs_detail = $this->faq_model->getFaq(NULL, NULL, NULL, $limit, $orderby);
        $this->outputData['faqs'] = $faqs_detail;

        //Pagination
        $this->load->library('pagination');
        $this->outputData['pagination_faq_categories'] = get_pagination(admin_url('faq/viewFaqs/'), $total_faq_categories_rows, $page_rows, $page);
        $this->outputData['pagination_faqs'] = get_pagination(admin_url('faq/viewFaqs/'), $total_faqs_rows, $page_rows, $page);

        if ($this->input->is_ajax_request()) {
            if ($this->input->post('table_only') == 'true') {

                if ($this->input->post('table_id') == 'faq_categories_table') {
                    echo response([
                        'type' => 'table',
                        'data' => $this->load->view('admin/faq/viewFaqCategoriesTableBody', $this->outputData, TRUE),
                        'pagination' => $this->outputData['pagination_faq_categories']
                    ]);
                }
                elseif ($this->input->post('table_id') == 'faqs_table') {
                    echo response([
                        'type' => 'table',
                        'data' => $this->load->view('admin/faq/viewFaqsTableBody', $this->outputData, TRUE),
                        'pagination' => $this->outputData['pagination_faqs']
                    ]);
                }
            } else {
                echo response([
                    'type' => 'all',
                    'data' => $this->load->view('admin/faq/viewFaqs', $this->outputData, TRUE),
                    'pagination' => $this->outputData['pagination_faq_categories']
                ]);
            }
        } else {
            //Load View
            $this->load->view('admin/faq/viewFaqs', $this->outputData);
        }
    }

    // --------------------------------------------------------------------

    /**
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function refreshFaqCategoryRow()
    {
        if ($this->input->is_ajax_request()) {

            $id = $this->input->post('id', true);

            //Set Condition To Fetch The Faq Category
            $condition = array('faq_categories.id' => $id);

            //Get Categories
            $this->outputData['mode'] = 'view';
            $this->outputData['faqCategories'] = $this->faq_model->getFaqCategories($condition);

            echo response([
                'html' => $this->load->view('admin/faq/viewFaqCategoryRow', $this->outputData, TRUE)
            ]);
        }
    }

    /**
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function refreshFaqRow()
    {
        if ($this->input->is_ajax_request()) {

            $id = $this->input->post('id', true);

            //Set Condition To Fetch The Faq
            $condition = array('faqs.id' => $id);

            //Get Categories
            $this->outputData['mode'] = 'view';
            $this->outputData['faqs'] = $this->faq_model->getFaqs($condition);

            echo response([
                'html' => $this->load->view('admin/faq/viewFaqRow', $this->outputData, TRUE)
            ]);
        }
    }

    // --------------------------------------------------------------------

    /**
     * Add Faq Category.
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function addFaqCategory()
    {

        //load validation library
        $this->load->library('form_validation');

        //Load Form Helper
        $this->load->helper('form');

        //Intialize values for library and helpers
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        if ($this->input->post('addFaqCategory')) {
            //Set rules
            $this->form_validation->set_rules('faq_category_name', 'lang:faq_category_name_validation', 'required|trim|xss_clean|callback_faqCategoryNameCheck');

            if ($this->form_validation->run()) {
                //prepare insert data
                $insertData = array();
                $insertData['category_name'] = $this->input->post('faq_category_name');
                $insertData['created'] = get_est_time();

                //Add Category
                $this->faq_model->addFaqCategory($insertData);

                //Notification message
                $this->notify->set(t('added_success'), Notify::SUCCESS);
                redirect_admin('faq/viewFaqCategories');
            }
        } //If - Form Submission End

        //Load View
        $this->load->view('admin/faq/addFaqCategory', $this->outputData);

    }//End of addFaqCategory function

    /**
     * Add Faq Category.
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function editFaqCategory()
    {

        //load validation library
        $this->load->library('form_validation');

        //Load Form Helper
        $this->load->helper('form');

        //Intialize values for library and helpers
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        if ($this->input->post('addFaqCategory')) {
            //Set rules
            $this->form_validation->set_rules('faq_category_name', 'lang:faq_category_name_validation', 'required|trim|xss_clean|callback_faqCategoryNameCheck');

            if ($this->form_validation->run()) {
                //prepare insert data
                $insertData = array();
                $insertData['category_name'] = $this->input->post('faq_category_name');
                $insertData['created'] = get_est_time();

                //Add Category
                $this->faq_model->addFaqCategory($insertData);

                //Notification message
                $this->notify->set(t('added_success'), Notify::SUCCESS);
                redirect_admin('faq/viewFaqCategories');
            }
        } //If - Form Submission End

        //Load View
        $this->load->view('admin/faq/addFaqCategory', $this->outputData);

    }//End of addFaqCategory function

    // --------------------------------------------------------------------

    /**
     * Edit Faq Category.
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function saveFaqCategory()
    {
        //load validation library
        $this->load->library('form_validation');

        //Load Form Helper
        $this->load->helper('form');

        //Intialize values for library and helpers
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        if ($this->input->is_ajax_request()) {

            $id = $this->input->post('id', true);
            $isNew = ($id == null)?true:false;

            //Set rules
            $this->form_validation->set_rules('category_name', 'lang:faq_category_name_validation', 'required|trim|xss_clean|callback_faqCategoryNameCheck');

            if ($this->form_validation->run()) {
                //prepare update data
                $updateData = array();
                $updateData['category_name'] = $this->input->post('category_name');

                //Edit Faq Category
                $id = $this->faq_model->saveFaqCategory($id, $updateData);

                //Set Condition To Fetch The Faq Category
                $condition = array('faq_categories.id' => $id);

                //Get Categories
                $this->outputData['mode'] = 'view';
                $this->outputData['faqCategories'] = $this->faq_model->getFaqCategories($condition);

                $message = $isNew?t('added_success'):t('updated_success');

                echo response([
                    'html' => $this->load->view('admin/faq/viewFaqCategoryRow', $this->outputData, TRUE),
                    'message' => $message
                ]);
            }
            else {
                $errors_arr = $this->form_validation->error_array();
                echo response([
                    'message' => array_shift($errors_arr)
                ], true);
            }
        }
    }

    /**
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function saveFaq()
    {
        //load validation library
        $this->load->library('form_validation');

        //Load Form Helper
        $this->load->helper('form');

        //Intialize values for library and helpers
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        if ($this->input->is_ajax_request()) {

            $id = $this->input->post('id', true);
            $isNew = ($id == null)?true:false;

            //Set rules
            $this->form_validation->set_rules('faq_category_id', 'lang:faq_category_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('question', 'lang:question_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('answer', 'lang:answer_validation', 'required|trim|xss_clean');

            if ($this->form_validation->run()) {
                //prepare update data
                $updateData = array();
                $updateData['faq_category_id'] = $this->input->post('faq_category_id');
                $updateData['question'] = $this->input->post('question');
                $updateData['answer'] = $this->input->post('answer');
                $updateData['is_frequent'] = $this->input->post('is_frequent');

                //Edit Faq
                $id = $this->faq_model->saveFaq($id, $updateData);

                //Set Condition To Fetch The Faq
                $condition = array('faqs.id' => $id);

                //Get Categories
                $this->outputData['mode'] = 'view';
                $this->outputData['faqs'] = $this->faq_model->getFaqs($condition);

                $message = $isNew?t('added_success'):t('updated_success');

                echo response([
                    'html' => $this->load->view('admin/faq/viewFaqRow', $this->outputData, TRUE),
                    'message' => $message
                ]);
            }
            else {
                $errors_arr = $this->form_validation->error_array();
                echo response([
                    'error' => true,
                    'message' => $errors_arr
                ]);
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * checks whether category name already exists or not.
     *
     * @access    private
     * @param    string name of category
     * @return    bool true or false
     */
    function faqCategoryNameCheck($name)
    {
        //Condition to check
        $condition = array('faq_categories.category_name' => $name, 'faq_categories.id <>' => $this->input->post('id'));

        //Check with table
        $resultCategoryName = $this->faq_model->getFaqCategories($condition);

        if ($resultCategoryName->num_rows() > 0) {
            $this->form_validation->set_message('faqCategoryNameCheck', t('faq_category_name_unique'));
            return FALSE;
        } else {
            return TRUE;
        }
    }//End of groupNameCheck function

    /**
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function addFaqCategoryRow()
    {
        if ($this->input->is_ajax_request()) {

            $this->outputData['mode'] = 'insert';
            echo response([
                'html' => $this->load->view('admin/faq/viewFaqCategoryRow', $this->outputData, TRUE)
            ]);
        }
    }

    /**
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function addFaqRow()
    {
        if ($this->input->is_ajax_request()) {

            $this->outputData['faqCategories'] = $this->faq_model->getFaqCategories();

            $this->outputData['mode'] = 'insert';
            echo response([
                'html' => $this->load->view('admin/faq/viewFaqRow', $this->outputData, TRUE)
            ]);
        }
    }

    /**
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function editFaqCategoryRow()
    {
        if ($this->input->is_ajax_request()) {

            $id = $this->input->post('id', true);

            //Set Condition To Fetch The Faq Category
            $condition = array('faq_categories.id' => $id);

            //Get Categories
            $this->outputData['faqCategories'] = $this->faq_model->getFaqCategories($condition);

            $this->outputData['mode'] = 'update';

            echo response([
                'html' => $this->load->view('admin/faq/viewFaqCategoryRow', $this->outputData, TRUE)
            ]);
        }
    }

    /**
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function editFaqRow()
    {
        if ($this->input->is_ajax_request()) {

            $id = $this->input->post('id', true);

            //Set Condition To Fetch The Faq
            $condition = array('faqs.id' => $id);

            //Get Categories
            $this->outputData['faqs'] = $this->faq_model->getFaqs($condition);

            $this->outputData['mode'] = 'update';

            $this->outputData['faqCategories'] = $this->faq_model->getFaqCategories();

            echo response([
                'html' => $this->load->view('admin/faq/viewFaqRow', $this->outputData, TRUE)
            ]);
        }
    }

    function deleteFaqCategory()
    {
        if ($this->input->is_ajax_request()) {

            $id = $this->input->post('id', true);

            $this->faq_model->deleteFaqCategory($id);

            $this->notify->set(t('delete_success'), Notify::SUCCESS);

            echo response([
                'error' => false,
                'message' => t('delete_success')
            ]);
        }
    }

    function deleteFaq()
    {
        if ($this->input->is_ajax_request()) {

            $id = $this->input->post('id', true);

            $this->faq_model->deleteFaq($id);

            $this->notify->set(t('delete_success'), Notify::SUCCESS);

            echo response([
                'error' => false,
                'message' => t('delete_success')
            ]);
        }
    }
}
