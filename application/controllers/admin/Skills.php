<?php

/*
  ****************************************************************************
  ***                                                                      ***
  ***      BIDONN 1.0                                                      ***
  ***      File:  skills.php                                               ***
  ***      Built: Mon June 25 17:25:45 2012                                ***
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


class skills extends MY_Controller
{

    //Global variable
    public $outputData;
    public $logged_in_user;

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
            'admin/skills',
            'admin/validation'));

        //Load Models
        $this->load->model('common_model');
        $this->load->model('admin_model');
        $this->load->model('skills_model');

        //Get Logged In user
        $this->logged_in_user = $this->common_model->get_logged_in_user();
        $this->outputData['logged_in_user'] = $this->logged_in_user;

    }//Controller End

    // --------------------------------------------------------------------

    /**
     * Loads skills settings page.
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function viewGroups()
    {
        $this->add_js([
            'application/js/admin/view_groups.js',
            'application/js/pagination.js'
        ]);

        $this->init_js(["view_groups.init('" . admin_url() . "');"]);

        //Load Form Helper
        $this->load->helper('form');

        // Get page
        $page_rows = $this->input->post('page_rows');
        if ($page_rows == NULL) {
            $page_rows = 10;
        }
        $this->outputData['page_rows'] = $page_rows;

        //
        $groups = $this->skills_model->getGroups();
        $total_rows = $groups->num_rows();
        //

        $page = $this->input->post('page');
        if ($page == NULL) {
            $page = 1;
        }
        // get correct page
        $page = get_page($total_rows, $page_rows, $page);
        $this->outputData['page'] = $page;

        $limit = [$page_rows, ($page - 1) * $page_rows];

        // Get Sorting order
        if ($this->input->post('field')) {
            $field = $this->input->post('field');
        } else {
            $field = 'groups.id';
        }
        if ($this->input->post('order')) {
            $order = $this->input->post('order');
        } else {
            $order = 'ASC';
        }
        $orderby = [$field, $order];

        $where = array();
        $like = array();

        $groups_arr = $this->skills_model->getGroup($where, NULL, $like, $limit, $orderby);
        $this->outputData['groups'] = $groups_arr;

        //Pagination
        $this->load->library('pagination');

        $this->outputData['pagination'] = get_pagination(admin_url('skills/viewGroups'), $total_rows, $page_rows, $page);

        if ($this->input->is_ajax_request()) {
            if ($this->input->post('table_only') == 'true') {
                echo response([
                    'type' => 'table',
                    'data' => $this->load->view('admin/skills/viewGroupsTableBody', $this->outputData, TRUE),
                    'pagination' => $this->outputData['pagination']
                ]);
            } else {
                echo response([
                    'type' => 'all',
                    'data' => $this->load->view('admin/skills/viewGroups', $this->outputData, TRUE),
                    'pagination' => $this->outputData['pagination']
                ]);
            }
        } else {
            $this->load->view('admin/skills/viewGroups', $this->outputData);
        }

    }//End of groups function

    // --------------------------------------------------------------------
    function delete_slide()
    {
        //Load model
        $this->load->helper('form');
        $groupid = $this->uri->segment(4, '0');

        if ($groupid == 0) {
            //Load Form Helper
            $this->load->helper('form');
            $getgroups = $this->skills_model->get_slides();
            $grouplist = $this->input->post('grouplist');
            if (!empty($grouplist)) {
                foreach ($grouplist as $res) {

                    $condition = array('slider.id' => $res);
                    $this->skills_model->delete_slide(NULL, $condition);
                }
            } else {
                $this->notify->set(t('Please select Group'), Notify::ERROR);
                redirect_admin('skills/view_slide');
            }
        } else {
            $condition = array('slider.id' => $groupid);
            $this->skills_model->delete_slide(NULL, $condition);
        }

        $this->notify->set(t('delete_success'), Notify::SUCCESS);
        redirect_admin('skills/view_slide');

    }

    /**
     * Loads skills settings page.
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function deleteGroup_old()
    {
        //Load model
        $this->load->helper('form');
        $groupid = $this->uri->segment(4, '0');

        if ($groupid == 0) {
            //Load Form Helper
            $this->load->helper('form');
            $getgroups = $this->skills_model->getGroups();
            $grouplist = $this->input->post('grouplist');
            if (!empty($grouplist)) {
                foreach ($grouplist as $res) {

                    $condition = array('groups.id' => $res);
                    $this->skills_model->deleteGroups(NULL, $condition);
                }
            } else {
                $this->notify->set(t('Please select Group'), Notify::ERROR);
                redirect_admin('skills/viewGroups');
            }
        } else {
            $condition = array('groups.id' => $groupid);
            $this->skills_model->deleteGroups(NULL, $condition);
        }

        $this->notify->set(t('delete_success'), Notify::SUCCESS);
        redirect_admin('skills/viewGroups');

    }//End of delete groups function

    // --------------------------------------------------------------------

    /**
     * Add Group.
     *
     * @access    private
     * @param    nil
     * @return    void
     */

    function view_slide()
    {
        //Load model

        //Load Form Helper
        $this->load->helper('form');

        //Get Groups
        $groups = $this->skills_model->get_slides();

        $start = $this->uri->segment(4, 0);
        //Get the inbox mail list
        $page_rows = $this->config->item('mail_limit');

        $limit[0] = $page_rows;
        if ($start > 0)
            $limit[1] = ($start - 1) * $page_rows;
        else
            $limit[1] = $start * $page_rows;

        $order[0] = 'id';
        $order[1] = 'desc';

        //Get Groups
        $categoryies = $this->skills_model->get_slide(NULL, NULL, NULL, $limit, $order);
        $this->outputData['groups'] = $categoryies;

        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = admin_url('skills/view_slide');
        $config['total_rows'] = $groups->num_rows();
        $config['per_page'] = $page_rows;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $this->outputData['pagination'] = $this->pagination->create_links2(false, 'view_slide');

        //Load View
        $this->load->view('admin/skills/view_slide', $this->outputData);

    }//End of groups function

    function add_slide()
    {
        //Load model
        $this->load->model('skills_model');

        //load validation library
        $this->load->library('form_validation');

        //Load Form Helper
        $this->load->helper('form');

        //Intialize values for library and helpers
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        if ($this->input->post('addGroup')) {
            //Set rules
            $this->form_validation->set_rules('group_name', 'lang:group_name_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('descritpion', 'lang:descritpion_validation');

            if ($this->form_validation->run()) {
                $config['upload_path'] = 'files/site_logo/';
                $config['max_size'] = $this->config->item('max_upload_size');
                $config['max_width'] = '1100';
                $config['max_height'] = '500';

                $config['encrypt_name'] = TRUE;
                $config['remove_spaces'] = TRUE;
                $config['allowed_types'] = 'jpeg|jpg|png|gif|JPEG|JPG|PNG|GIF';


                $this->load->library('upload', $config);

                if ($this->upload->do_upload('logo')) {
                    $insertData = array();
                    $insertData['group_name'] = $this->input->post('group_name');
                    $insertData['description'] = $this->input->post('descritpion');
                    $insertData['created'] = get_est_time();
                    $insertData['modified'] = get_est_time();

                    $this->outputData['file'] = $this->upload->data();

                    $insertData['attachment_url'] = $this->outputData['file']['file_name'];

                    $insertData['attachment_name'] = $this->outputData['file']['orig_name'];


                    $this->skills_model->add_slide($insertData);
                }
                //Add Groups


                //Notification message
                $this->notify->set(t('added_success'), Notify::SUCCESS);
                redirect_admin('skills/view_slide');
            }
        } //If - Form Submission End


        $this->load->view('admin/skills/add_slide', $this->outputData);

    }//End of addGroup function

    function edit_slide()
    {
        //Get id of the group
        $id = is_numeric($this->uri->segment(4)) ? $this->uri->segment(4) : 0;

        //Load model
        $this->load->model('skills_model');

        //load validation library
        $this->load->library('form_validation');

        //Load Form Helper
        $this->load->helper('form');

        //Intialize values for library and helpers
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        if ($this->input->post('editGroup')) {

            //Set rules
            $this->form_validation->set_rules('group_name', 'lang:group_name_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('descritpion', 'lang:descritpion_validation');


            if ($this->form_validation->run()) {

                $config['upload_path'] = 'files/site_logo/';
                $config['max_size'] = $this->config->item('max_upload_size');
                $config['max_width'] = '1100';
                $config['max_height'] = '500';

                $config['encrypt_name'] = TRUE;
                $config['remove_spaces'] = TRUE;
                $config['allowed_types'] = 'jpeg|jpg|png|gif|JPEG|JPG|PNG|GIF';
                $this->load->library('upload', $config);


                if (empty($_FILES['logo']['name'])) {
                    //prepare update data
                    $updateData = array();
                    $updateData['group_name'] = $this->input->post('group_name');
                    $updateData['description'] = $this->input->post('descritpion');
                    $updateData['modified'] = get_est_time();


                    $updateData['attachment_url'] = $this->input->post('attachment_url');
                    $updateData['attachment_name'] = $this->input->post('attachment_name');
                    $this->skills_model->update_slide($id, $updateData);
                }

                if ($this->upload->do_upload('logo')) {
                    //prepare update data
                    $updateData = array();
                    $updateData['group_name'] = $this->input->post('group_name');
                    $updateData['description'] = $this->input->post('descritpion');
                    $updateData['modified'] = get_est_time();

                    $this->outputData['file'] = $this->upload->data();
                    $updateData['attachment_url'] = $this->outputData['file']['file_name'];
                    $updateData['attachment_name'] = $this->outputData['file']['orig_name'];
                    $this->skills_model->update_slide($id, $updateData);
                }


                //Notification message
                $this->notify->set(t('updated_success'), Notify::SUCCESS);
                redirect_admin('skills/view_slide');
            }
        } //If - Form Submission End

        //Set Condition To Fetch The Group
        $condition = array('slider.id' => $id);

        //Get Groups
        $this->outputData['groups'] = $this->skills_model->get_slides($condition);

        //Load View
        $this->load->view('admin/skills/edit_slide', $this->outputData);

    }//End of addGroup function


    function addGroup()
    {
        $this->add_css([
            'application/css/css/dropzone.css',
            'application/css/admin/edit_group.css'
        ]);

        $this->add_js([
            'application/js/dropzone.js',
            'application/js/admin/edit_group.js'
        ]);

        $this->init_js(["edit_group.init('" . admin_url() . "');"]);

        //Load model
        $this->load->model('skills_model');

        //load validation library
        $this->load->library('form_validation');

        //Load Form Helper
        $this->load->helper('form');

        //Intialize values for library and helpers
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        if ($this->input->post('addGroup')) {
            //Set rules
            $this->form_validation->set_rules('group_name', 'lang:group_name_validation', 'required|trim|xss_clean|callback_groupNameCheck');
            $this->form_validation->set_rules('description', 'lang:description_validation');

            if ($this->form_validation->run()) {

                //prepare insert data
                $insertData = array();
                $insertData['group_name'] = $this->input->post('group_name');
                $insertData['description'] = $this->input->post('description');
                $insertData['created'] = get_est_time();
                $insertData['modified'] = get_est_time();

                $insertData['attachment_url'] = $this->input->post('attachment_url');
                $insertData['attachment_name'] = $this->input->post('attachment_name');

                //Add Groups
                $this->skills_model->addGroup($insertData);

                //Notification message
                $this->notify->set(t('added_success'), Notify::SUCCESS);
                redirect_admin('skills/viewGroups');
            }
        } //If - Form Submission End

        //Get Groups
//        $this->outputData['groups'] = $this->skills_model->getGroups();

        //Load View
        $this->load->view('admin/skills/addGroup', $this->outputData);

    }//End of addGroup function

    // --------------------------------------------------------------------

    /**
     * Edit Group.
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function editGroup()
    {
        $this->add_css([
            'application/css/css/dropzone.css',
            'application/css/admin/edit_group.css'
        ]);

        $this->add_js([
            'application/js/dropzone.js',
            'application/js/admin/edit_group.js'
        ]);

        $this->init_js(["edit_group.init('" . admin_url() . "');"]);

        //Get id of the group
        $id = $this->uri->segment(3, 0);

        //Load model
        $this->load->model('skills_model');

        //load validation library
        $this->load->library('form_validation');

        //Load Form Helper
        $this->load->helper('form');

        //Intialize values for library and helpers
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        if ($this->input->post('editGroup')) {

            //Set rules
            $this->form_validation->set_rules('group_name', 'lang:group_name_validation', 'required|trim|xss_clean|callback_groupNameCheck');
            $this->form_validation->set_rules('description', 'lang:description_validation');

            if ($this->form_validation->run()) {

                //prepare update data
                $updateData = array();
                $updateData['group_name'] = $this->input->post('group_name');
                $updateData['description'] = $this->input->post('description');
                $updateData['modified'] = get_est_time();

                $updateData['attachment_url'] = $this->input->post('attachment_url');
                $updateData['attachment_name'] = $this->input->post('attachment_name');

                //Add Groups
                $this->skills_model->updateGroup($this->input->post('id', true), $updateData);

                //Notification message
                $this->notify->set(t('updated_success'), Notify::SUCCESS);
                redirect_admin('skills/viewGroups');
            }
        } //If - Form Submission End

        //Set Condition To Fetch The Group
        $condition = array('groups.id' => $id);

        //Get Groups
        $this->outputData['groups'] = $this->skills_model->getGroups($condition);

        //Load View
        $this->load->view('admin/skills/editGroup', $this->outputData);

    }//End of addGroup function


    // --------------------------------------------------------------------

    /**
     * View Categories
     *
     * @access    private
     * @param    nil
     * @return    void
     */

    function update_img()
    {
        $path = $this->uri->segment(6);
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $f1 = basename($path, $ext);

        $updateData = array();
        $updateData['attachment_url'] = md5($f1) . '.' . $ext;
        $updateData['attachment_name'] = $this->uri->segment(6);
        $updateData['modified'] = get_est_time();
        $this->skills_model->updateCategory($this->uri->segment(7), $updateData);

        //Notification message
        $this->notify->set(t('updated_success'), Notify::SUCCESS);
        redirect_admin('skills/view_cate');
    }

    function viewCategories()
    {

        $this->add_js([
            'application/js/admin/view_categories.js',
            'application/js/pagination.js'
        ]);

        //Load Form Helper
        $this->load->helper('form');

        //Load model
        $this->load->model('skills_model');

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
            $field = 'groups.id';
        }
        if ($this->input->post('order')) {
            $order = $this->input->post('order');
        } else {
            $order = 'ASC';
        }
        $orderby = [$field, $order];

        $where = array();
        $like = array();

        //Get Categories
        $categories = $this->skills_model->getCategories();

        //Get Groups
        $categories_arr = $this->skills_model->getCategory($where, NULL, $like, $limit, $orderby);
        $this->outputData['categories'] = $categories_arr;

        $total_rows = $categories->num_rows();

        //Pagination
        $this->load->library('pagination');

        $this->outputData['base_url'] = admin_url('skills/viewCategories');

        $this->outputData['pagination'] = get_pagination(admin_url('skills/viewCategories'), $total_rows, $page_rows, $page);

        if ($this->input->is_ajax_request()) {
            if ($this->input->post('table_only') == 'true') {
                echo response([
                    'type' => 'table',
                    'data' => $this->load->view('admin/skills/viewCategoriesTableBody', $this->outputData, TRUE),
                    'pagination' => $this->outputData['pagination']
                ]);
            } else {
                echo response([
                    'type' => 'all',
                    'data' => $this->load->view('admin/skills/viewCategories', $this->outputData, TRUE),
                    'pagination' => $this->outputData['pagination']
                ]);
            }
        } else {
            $this->load->view('admin/skills/viewCategories', $this->outputData);
        }

    }

    function view_cat()
    {
        $categoryies = $this->skills_model->getCategories();
        $this->outputData['categories'] = $categoryies;

        $this->load->view('admin/skills/view_cat', $this->outputData);

    }

    function view_cate()
    {
        $categoryies = $this->skills_model->getCategories();
        $this->outputData['categories'] = $categoryies;
        //print_r( $this->outputData['categories']) ;
        $this->load->view('admin/skills/view_cate', $this->outputData);
    }

    // --------------------------------------------------------------------

    function editCategory()
    {

        $this->add_css([
            'application/css/css/dropzone.css',
            'application/css/admin/edit_category.css'
        ]);

        $this->add_js([
            'application/js/dropzone.js',
            'application/js/admin/edit_category.js'
        ]);

        $this->init_js(["edit_category.init('" . admin_url() . "');"]);

        //Get id of the category
        $id = $this->uri->segment(3, 0);

        //Load model
        $this->load->model('skills_model');

        //load validation library
        $this->load->library('form_validation');

        //Load Form Helper
        $this->load->helper('form');

        //Intialize values for library and helpers
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        if ($this->input->post('editCategory')) {

            //Set rules
            $this->form_validation->set_rules('category_name', 'lang:category_name_validation', 'required|trim|xss_clean|callback_categoryNameCheck');
            $this->form_validation->set_rules('group_id', 'lang:group_id_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('is_active', 'lang:is_active_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('description', 'lang:description_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('page_title', 'lang:page_title_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('meta_keywords', 'lang:meta_keywords_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('meta_description', 'lang:meta_description_validation', 'required|trim|xss_clean');

            if ($this->form_validation->run()) {

                //prepare update data
                $updateData = array();
                $updateData['category_name'] = $this->input->post('category_name');
                $updateData['group_id'] = $this->input->post('group_id');
                $updateData['is_active'] = $this->input->post('is_active');
                $updateData['description'] = $this->input->post('description');
                $updateData['page_title'] = $this->input->post('page_title');
                $updateData['meta_keywords'] = $this->input->post('meta_keywords');
                $updateData['meta_description'] = $this->input->post('meta_description');
                $updateData['modified'] = get_est_time();

                $updateData['attachment_url'] = $this->input->post('attachment_url');
                $updateData['attachment_name'] = $this->input->post('attachment_name');

                //Add Groupss
                $this->skills_model->updateCategory($this->input->post('id', true), $updateData);

                //Notification message
                $this->notify->set(t('updated_success'), Notify::SUCCESS);
                redirect_admin('skills/viewCategories');

            }

        }//If - Form Submission End

        //Get Groups
        $this->outputData['groups'] = $this->skills_model->getGroups();

        //Set Condition To Fetch The Category
        $condition = array('categories.id' => $id);

        //Get Categories
        $this->outputData['categories'] = $this->skills_model->getCategories($condition);

        //Load View
        $this->load->view('admin/skills/editCategory', $this->outputData);

    }//End of editCategory function

    // --------------------------------------------------------------------

    /**
     * checks whether group name already exists or not.
     *
     * @access    private
     * @param    string Name of group
     * @return    bool true or false
     */
    function cate_edit()
    {
        $this->load->model('skills_model');

        $updateData = array();
        $updateData['category_name'] = $this->input->post('catname');
        $updateData['category_name_encry'] = md5($this->input->post('catname'));
        $updateData['group_id'] = $this->input->post('group');
        $updateData['is_active'] = $this->input->post('name');
        $updateData['description'] = $this->input->post('des');
        $updateData['page_title'] = $this->input->post('pg_ti');
        $updateData['meta_keywords'] = $this->input->post('meta_key');
        $updateData['meta_description'] = $this->input->post('meta_des');
        $updateData['modified'] = get_est_time();

        //Add Groupss
        $this->skills_model->updateCategory($this->input->post('id'), $updateData);

        //Notification message
        $this->notify->set(t('updated_success'), Notify::SUCCESS);
        redirect_admin('skills/view_cate');
    }

    function upload()
    {
        $result = 0;

        $path = $_FILES['myfile']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $f1 = basename($path, $ext);
        $target_path = GROUP_LOGO_FOLDER . md5($f1) . '.' . $ext;

        if (@move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path)) {

            $result = 1;


        }

        sleep(1);
        echo ' <script language="javascript" type="text/javascript">window.top.window.stopUpload(' . $result . ');</script> ';

    }

    /**
     * Upload group logo
     */
    function upload_file()
    {
        if (isset($_FILES) and is_array($_FILES) and array_key_exists('file', $_FILES)) {
            $this->load->library('upload');
            $this->load->library('image_lib');

            $config['upload_path'] = $this->file_model->get_public_temp_dir();

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
                if ($data['is_image']) {
                    $resize = [
                        'source_image' => $data['full_path'],
                        'maintain_ratio' => FALSE,
                        'width' => 128,
                        'height' => 128
                    ];
                    $this->image_lib->initialize($resize);
                    $this->image_lib->resize();
                }
                echo json_encode([
                    'attachment_name' => $data['file_name'],
                    'attachment_url' => '/' . $config['upload_path'] . $data['file_name']
                ]);
            }
        }
    }

    function re_im()
    {
        $updateData = array();
        $updateData['attachment_url'] = $this->uri->segment(4);

        $updateData['modified'] = get_est_time();
        $this->skills_model->updateCategory($this->uri->segment(5), $updateData);

        //Notification message
        $this->notify->set(t('updated_success'), Notify::SUCCESS);
        redirect_admin('skills/view_cate');
    }

    /**
     * Loads skills settings page.
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function deleteCategory()
    {
        //Load model

        //Load Form Helper

        $this->load->helper('form');
        $categoryid = $this->uri->segment(4, '0');

        if ($categoryid == 0) {

            $getgroups = $this->skills_model->getCategories();
            $categoryList = $this->input->post('categoryList');
            if (!empty($categoryList)) {
                foreach ($categoryList as $res) {

                    $condition = array('categories.id' => $res);
                    $this->skills_model->deleteCategory(NULL, $condition);
                }
            } else {
                $this->notify->set(t('Please select category'), Notify::ERROR);
                redirect_admin('skills/view_cate');
            }
        } else {
            $condition = array('categories.id' => $categoryid);
            $this->skills_model->deleteCategory(NULL, $condition);
        }
        $this->notify->set(t('delete_success'), Notify::SUCCESS);
        redirect_admin('skills/view_cate');

    }//End of groups function

    // --------------------------------------------------------------------


    /**
     * Add Category.
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function addCategory()
    {
        $this->add_css([
            'application/css/css/dropzone.css',
            'application/css/admin/edit_category.css'
        ]);

        $this->add_js([
            'application/js/dropzone.js',
            'application/js/admin/edit_category.js'
        ]);

        $this->init_js(["edit_category.init('" . admin_url() . "');"]);

        //Load model
        $this->load->model('skills_model');

        //load validation library
        $this->load->library('form_validation');

        //Load Form Helper
        $this->load->helper('form');

        //Intialize values for library and helpers
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        if ($this->input->post('addCategory')) {
            //Set rules
            $this->form_validation->set_rules('category_name', 'lang:category_name_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('group_id', 'lang:group_id_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('is_active', 'lang:is_active_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('description', 'lang:description_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('page_title', 'lang:page_title_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('meta_keywords', 'lang:meta_keywords_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('meta_description', 'lang:meta_description_validation', 'required|trim|xss_clean');

            if ($this->form_validation->run()) {

                $insertData = array();
                $insertData['category_name'] = $this->input->post('category_name');
                $insertData['category_name_encry'] = md5($this->input->post('category_name'));
                $insertData['group_id'] = $this->input->post('group_id');
                $insertData['is_active'] = $this->input->post('is_active');
                $insertData['description'] = $this->input->post('description');
                $insertData['page_title'] = $this->input->post('page_title');
                $insertData['meta_keywords'] = $this->input->post('meta_keywords');
                $insertData['meta_description'] = $this->input->post('meta_description');
                $insertData['created'] = get_est_time();
                $insertData['modified'] = get_est_time();

                $insertData['attachment_url'] = $this->input->post('attachment_url');
                $insertData['attachment_name'] = $this->input->post('attachment_name');

                //Add Category
                $this->skills_model->addCategory($insertData);

                //Notification message
                $this->notify->set(t('added_success'), Notify::SUCCESS);
                redirect_admin('skills/viewCategories');

            }
        } //If - Form Submission End

        //Get Categories
        $this->outputData['categories'] = $this->skills_model->getCategories();

        //Get Groups
        $this->outputData['groups'] = $this->skills_model->getGroups();

        //Load View
        $this->load->view('admin/skills/addCategory', $this->outputData);

    }//End of addCategory function

    // --------------------------------------------------------------------

    /**
     * Edit Category.
     *
     * @access    private
     * @param    nil
     * @return    void
     */

    function groupNameCheck($group_name)
    {

        //Condition to check
        if ($this->input->post('operation') !== false and $this->input->post('operation') == 'edit') {
            $condition = array('group_name' => $group_name, 'id <>' => $this->input->post('id'));
        }
        else {
            $condition = array('group_name' => $group_name);
        }

        //Check with table
        $resultGroupName = $this->skills_model->getGroups($condition);

        if ($resultGroupName->num_rows() > 0) {
            $this->form_validation->set_message('groupNameCheck', t('group_name_unique'));
            return FALSE;
        } else {
            return TRUE;
        }
    }//End of groupNameCheck function

    // --------------------------------------------------------------------

    /**
     * checks whether category name already exists or not.
     *
     * @access    private
     * @param    string name of category
     * @return    bool true or false
     */

    function categoryNameCheck($category_name)
    {
        //Condition to check
        if ($this->input->post('operation') !== false and $this->input->post('operation') == 'edit') {
            $condition = array(
                'categories.category_name' => $category_name,
                'categories.id <>' => $this->input->post('id'),
                'categories.group_id =' => $this->input->post('group_id')
            );
        }
        else {
            $condition = array('categories.category_name' => $category_name);
        }

        //Check with table
        $resultCategoryName = $this->skills_model->getCategories($condition);

        if ($resultCategoryName->num_rows() > 0) {
            $this->form_validation->set_message('categoryNameCheck', t('category_name_unique'));
            return FALSE;
        } else {
            return TRUE;
        }
    }//End of groupNameCheck function


    /**
     * Add Group.
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function viewQuotes()
    {
        $this->add_js([
            'application/js/admin/view_quotes.js',
            'application/js/pagination.js'
        ]);

        $this->init_js(["view_quotes.init('" . admin_url() . "');"]);

        //Load Form Helper
        $this->load->helper('form');

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
            $field = 'quotes.id';
        }
        if ($this->input->post('order')) {
            $order = $this->input->post('order');
        } else {
            $order = 'ASC';
        }
        $orderby = [$field, $order];

        // filter
        $id = null;
        $name = null;
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
        }
        elseif (isset($_SESSION["view_quotes_filter"]["id"])) {
            $id = $_SESSION["view_quotes_filter"]["id"];
        }

        if ($this->input->post('name')) {
            $name = $this->input->post('name');
        }
        elseif (isset($_SESSION["view_quotes_filter"]["name"])) {
            $name = $_SESSION["view_quotes_filter"]["name"];
        }

        $_SESSION["view_quotes_filter"] =
            array(
                "id" => $id,
                "name" => $name
            );

        $where = array();
        if (isset($id) && $id != "") {
            $where = array('jobs.id' => $id);
        }

        $like = array();
        if (isset($name) && $name != "") {
            $like = array('quotes.name' => $name);
        }

        $this->outputData['view_quotes_filter'] = $_SESSION["view_quotes_filter"];

        //Load model
        $this->load->model('skills_model');

        //Get bidJobs
        $quotes = $this->skills_model->getQuotes();
        $total_rows = $quotes->num_rows();

        $this->outputData['jobs'] = $this->skills_model->getJobs();

        $quotes_arr = $this->skills_model->getQuotes($where, NULL, $like, $limit, $orderby);
        $this->outputData['quotes'] = $quotes_arr;

        //Pagination
        $this->load->library('pagination');

        $this->outputData['pagination'] = get_pagination(admin_url('skills/viewQuotes'), $total_rows, $page_rows, $page);

        if ($this->input->is_ajax_request()) {
            if ($this->input->post('table_only') == 'true') {
                echo response([
                    'type' => 'table',
                    'data' => $this->load->view('admin/skills/viewQuotesTableBody', $this->outputData, TRUE),
                    'pagination' => $this->outputData['pagination']
                ]);
            } else {
                echo response([
                    'type' => 'all',
                    'data' => $this->load->view('admin/skills/viewQuotes', $this->outputData, TRUE),
                    'pagination' => $this->outputData['pagination']
                ]);
            }
        } else {
            $this->load->view('admin/skills/viewQuotes', $this->outputData);
        }

    }//End of addGroup function

    /**
     * manageBids
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function searchBids()
    {
        if ($this->input->post('projectid')) {
            //Load model
            $this->load->model('skills_model');
            //Get bidJobs
            $bidProjects1 = $this->skills_model->getBids();
            $this->outputData['jobs'] = $this->skills_model->getJobs();

            $jobid = $this->input->post('projectid');

            $condition = array('bids.job_id' => $jobid);
            $list = $this->skills_model->getBids($condition);
            $count = count($list);
            if ($count > 0)
                $this->outputData['bidJobs'] = $list;
            //Load View
            $this->load->view('admin/skills/viewQuotes', $this->outputData);
        } else {
            //Load View
            $this->load->view('admin/skills/searchBids', $this->outputData);
        }
    }//End of addGroup function


    /**
     * manageQuotes
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function manageQuotes()
    {
        //Load model
        $this->load->model('skills_model');

        //Get id of the quote
        $id = $this->uri->segment(3, 0);

        $this->outputData['jobs'] = $this->skills_model->getJobs();

        $condition = array('quotes.id' => $id);
        $quotes = $this->skills_model->getQuotes($condition);

        $this->outputData['quotes'] = $quotes;

        //Load View
        $this->load->view('admin/skills/editQuotes', $this->outputData);

    }

    /**
     * manageBids to edit the bid amounts
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function editBids()
    {
        //Load model
        $this->load->model('skills_model');

        //Get bidJobs
        $project = $this->input->post('bidid');
        $amount = $this->input->post('amount');
        $count = count($project);
        for ($i = 0; $i < $count; $i++) {
            //update the amount value
            $condition = array('bids.id' => $project[$i]);
            $updateKey = array('bids.bid_amount' => $amount[$i]);
            $this->skills_model->updateBids(NULL, $updateKey, $condition);
        }
        $this->notify->set(t('Update Succesfully Completed'), Notify::SUCCESS);
        redirect_admin('skills/viewQuotes');

    }//End of addGroup function


    /**
     * deleteBids
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function deleteBids()
    {
        //Load model

        $this->load->model('skills_model');
        $this->load->helper('form');

        //Get bidJobs
        $bidProjects1 = $this->skills_model->getBids();
        $this->outputData['projects'] = $this->skills_model->getJobs();
        $projectList = $this->input->post('projectList');
        if (!empty($projectList)) {
            foreach ($projectList as $res) {
                //update the amount value
                $condition = array('bids.id' => $res);
                $this->skills_model->deleteBids(NULL, $condition);
            }
        } else {
            $this->notify->set(t('Please Select Bid Job'), Notify::ERROR);
            redirect_admin('skills/viewQuotes');
        }
        $this->notify->set(t('deleted_success'), Notify::SUCCESS);
        redirect_admin('skills/viewQuotes');

    }//End of addGroup function

    /**
     * viewJobs
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function viewJobs()
    {
        $this->add_js([
            'application/js/admin/view_jobs.js',
            'application/js/pagination.js'
        ]);

        $this->init_js(["view_jobs.init('" . admin_url() . "');"]);

        //Load model
        $this->load->model('skills_model');

        $page_rows = $this->input->post('page_rows');
        if ($page_rows == NULL) {
            $page_rows = 10;
        }
        $this->outputData['page_rows'] = $page_rows;

        //Get Jobs
        $jobs = $this->skills_model->getJobs();
        $total_rows = $jobs->num_rows();

        // Get page
        $page = $this->input->post('page');
        if ($page == NULL) {
            $page = 1;
        }
        // get correct page
        $page = get_page($total_rows, $page_rows, $page);

        $this->outputData['page'] = $page;

        $limit = [$page_rows, ($page - 1) * $page_rows];

        // Get Sorting order
        if ($this->input->post('field')) {
            $field = $this->input->post('field');
        } else {
            $field = 'jobs.id';
        }
        if ($this->input->post('order')) {
            $order = $this->input->post('order');
        } else {
            $order = 'ASC';
        }
        $orderby = [$field, $order];

        // filter
        $id = null;
        $job_name = null;
        if ($this->input->post('id')) {
            $id = $this->input->post('id');
        }
        elseif (isset($_SESSION["view_projects_filter"]["id"])) {
            $id = $_SESSION["view_projects_filter"]["id"];
        }

        if ($this->input->post('job_name')) {
            $job_name = $this->input->post('job_name');
        }
        elseif (isset($_SESSION["view_projects_filter"]["job_name"])) {
            $job_name = $_SESSION["view_projects_filter"]["job_name"];
        }

        $_SESSION["view_projects_filter"] =
            array(
                "id" => $id,
                "job_name" => $job_name
            );

        $where = array();
        if (isset($id) && $id != "") {
            $where = array('jobs.id' => $id);
        }

        $like = array();
        if (isset($job_name) && $job_name != "") {
            $like = array('jobs.job_name' => $job_name);
        }

        $this->outputData['view_projects_filter'] = $_SESSION["view_projects_filter"];

        $jobs_arr = $this->skills_model->getJobs($where, NULL, $like, $limit, $orderby);
        $this->outputData['jobs'] = $jobs_arr;

        //Pagination
        $this->load->library('pagination');

        $this->outputData['pagination'] = get_pagination(admin_url('skills/viewJobs'), $total_rows, $page_rows, $page);

        if ($this->input->is_ajax_request()) {
            if ($this->input->post('table_only') == 'true') {
                echo response([
                    'type' => 'table',
                    'data' => $this->load->view('admin/skills/viewJobsTableBody', $this->outputData, TRUE),
                    'pagination' => $this->outputData['pagination']
                ]);
            } else {
                echo response([
                    'type' => 'all',
                    'data' => $this->load->view('admin/skills/viewJobs', $this->outputData, TRUE),
                    'pagination' => $this->outputData['pagination']
                ]);
            }
        } else {
            $this->load->view('admin/skills/viewJobs', $this->outputData);
        }

    }//End of viewJobs function


    function viewJobs1()
    {
        //Load model
        $this->load->model('admin_model');
        $this->outputData['users'] = $this->admin_model->getUsers();

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
        //Get total jobs
        $days = date('W,m,Y', time());
        $cond1 = '%u,%m,%Y';
        $cond2 = $days;

        $projects1 = $this->admin_model->getProjects(NULL, NULL);
        $projects = $this->admin_model->getProjects(NULL, NULL, $limit, $order);
        $this->outputData['jobs'] = $projects;

        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = admin_url('skills/viewjobs1');
        $config['total_rows'] = $projects1->num_rows();
        $config['per_page'] = $page_rows;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $this->outputData['pagination'] = $this->pagination->create_links2(false, 'viewjobs1');
        //assign some value to check the job type


        //Load View
        $this->load->view('admin/skills/viewJobs1', $this->outputData);

    }//End of viewJobs1 function

    function jobDetails()
    {
        $prid = $this->uri->segment(4, 0);
        $cond = array('jobs.id' => $prid);
        $projects = $this->skills_model->getJobs($cond);

        $this->outputData['jobs'] = $projects;
        //Load View
        $this->load->view('admin/skills/viewJobs', $this->outputData);
    }

    /**
     * viewjobs
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function openJobs()
    {
        //Load model
        $this->load->model('skills_model');
        //Get Jobs
        $condition = array('jobs.job_status' => '0');
        $projects1 = $this->skills_model->getJobs($condition);
        //pr($projects1);
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
        $condition = array('jobs.job_status' => '0');
        $jobs = $this->skills_model->getJobs($condition, NULL, NULL, $limit, $order);

        $this->outputData['jobs'] = $jobs;

        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = admin_url('skills/openJobs');
        $config['total_rows'] = $projects1->num_rows();
        $config['per_page'] = $page_rows;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $this->outputData['pagination'] = $this->pagination->create_links2(false, 'viewJobs');
        $this->outputData['namefunct'] = 'openjobs';

        //Load View
        $this->load->view('admin/skills/viewJobs', $this->outputData);

    }//End of viewJobs function


    /**
     * viewJobs
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function closedJobs()
    {
        //Load model
        $this->load->model('skills_model');
        //Get Jobs
        $condition = array('jobs.job_status' => '2');
        $projects1 = $this->skills_model->getJobs($condition);

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
        $condition = array('jobs.job_status' => '2');
        $jobs = $this->skills_model->getJobs($condition, NULL, NULL, $limit, $order);

        $this->outputData['jobs'] = $jobs;

        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = admin_url('skills/closedJobs');
        $config['total_rows'] = $projects1->num_rows();
        $config['per_page'] = $page_rows;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $this->outputData['pagination'] = $this->pagination->create_links2(false, 'viewJobs');
        $this->outputData['namefunct'] = 'closedjobs';

        //Load View
        $this->load->view('admin/skills/viewJobs', $this->outputData);

    }//End of viewJobs function


    /**
     * manageJobs
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function manageJobs()
    {
        //Load model
        $this->load->model('skills_model');

        //Get id of the project
        $id = $this->uri->segment(3, 0);

        $this->outputData['project_statuses'] = $this->skills_model->getJobStatus();

        $condition = array('jobs.id' => $id);
        $this->outputData['projects'] = $this->skills_model->getJobs($condition);

        //Load View
        $this->load->view('admin/skills/editJobs', $this->outputData);

    }

    /**
     * editJobs to edit the bid amounts
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function editJobs()
    {
        //Get id of the project
        $job_id = $this->uri->segment(3, 0);

        //Load model
        $this->load->model('skills_model');

        //load validation library
        $this->load->library('form_validation');

        //Load Form Helper
        $this->load->helper('form');

        //Intialize values for library and helpers
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        if ($this->input->post('manageProject')) {

            //Set rules
            $this->form_validation->set_rules('job_name', 'lang:job_name_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('job_status', 'lang:job_status_validation', 'required|trim|xss_clean');

            if ($this->form_validation->run()) {

                $job_id = $this->input->post('job_id', TRUE);

                $updateKey = array();
                $updateKey['job_name'] = $this->input->post('job_name', TRUE);
                $updateKey['job_status'] = $this->input->post('job_status', TRUE);
                $updateKey['description'] = $this->input->post('description', TRUE);
                $updateKey['budget_min'] = $this->input->post('budget_min', TRUE);
                $updateKey['budget_max'] = $this->input->post('budget_max', TRUE);
                $updateKey['is_feature'] = $this->input->post('is_feature', TRUE)?$this->input->post('is_feature', TRUE):0;
                $updateKey['is_urgent'] = $this->input->post('is_urgent', TRUE)?$this->input->post('is_urgent', TRUE):0;
                $updateKey['is_hide_bids'] = $this->input->post('is_hide_bids', TRUE)?$this->input->post('is_hide_bids', TRUE):0;

                $condition = array('jobs.id' => $job_id);

                $this->skills_model->updateJobs(NULL, $updateKey, $condition);

                //Notification message
                $this->notify->set(t('Update Succesfully Completed'), Notify::SUCCESS);
                redirect_admin('skills/viewJobs');
            }
        }

        $this->outputData['project_statuses'] = $this->skills_model->getJobStatus();

        $condition = array('jobs.id' => $job_id);
        $this->outputData['projects'] = $this->skills_model->getJobs($condition);

        //Load View
        $this->load->view('admin/skills/editJobs', $this->outputData);
    }


    /**
     * deleteJobs
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function deleteJobs()
    {
        if ($this->input->is_ajax_request()) {

            $job_id = $this->uri->segment(3, '0');

            //Load model
            $this->load->model('skills_model');

            if ($job_id > 0 ) {

                $condition = array('jobs.id' => $job_id);
                $this->skills_model->deleteProjects(NULL, $condition);
            }

            echo response([
                'error' => false,
                'message' => t('deleted_success')
            ]);
        }
    }

    /**
     * searchJobs
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function searchJobs()
    {
        if ($this->input->post('projectid')) {
            //Load model
            $this->load->model('skills_model');

            //Get Jobs
            if ($this->input->post('projectid')) {
                $id = $this->input->post('projectid');
                $condition = array('jobs.id' => $id);
            }

            $this->outputData['jobs'] = $this->skills_model->getJobs($condition);

            //Load View
            $this->load->view('admin/skills/viewJobs', $this->outputData);
        } else if ($this->input->post('projectname')) {
            //Load model
            $this->load->model('skills_model');

            //Get Jobs
            if ($this->input->post('projectname')) {
                $id = $this->input->post('projectname');
                $like = array('jobs.job_name' => $id);
            }

            $this->outputData['jobs'] = $this->skills_model->getJobs(NULL, NULL, $like);

            //Load View
            $this->load->view('admin/skills/viewJobs', $this->outputData);
        } else {
            //Load View
            $this->load->view('admin/skills/searchJobs', $this->outputData);
        }
    }//End of searchJobs function

    /**
     * Get Today open jobs
     *
     * @access    public
     * @param    nil
     * @return    void
     */
    function todayJobs()
    {
        //Get total users
        $this->load->model('admin_model');
        $this->outputData['users'] = $this->admin_model->getUsers();

        //Get total jobs
        $days = date('d,m,Y', time());
        $cond1 = '%d,%m,%Y';
        $cond2 = $days;

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

        $projects1 = $this->admin_model->gettodayProjects($cond1, $cond2);
        $projects = $this->admin_model->gettodayProjects($cond1, $cond2, $limit, $order);
        $this->outputData['jobs'] = $projects;

        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = admin_url('skills/todayJobs');
        $config['total_rows'] = $projects1->num_rows();
        $config['per_page'] = $page_rows;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $this->outputData['pagination'] = $this->pagination->create_links2(false, 'today');
        //assign some value to check the job type
        $this->outputData['namefunct'] = 'today';

        $this->load->view('admin/skills/viewJobs1', $this->outputData);

    } //Function Index End
//--------------------------------------------------------------------------------------

    /**
     * Get Today open jobs
     *
     * @access    public
     * @param    nil
     * @return    void
     */
    function todayOpen()
    {
        //Get total users
        $this->load->model('admin_model');
        $this->outputData['users'] = $this->admin_model->getUsers();
        $days = date('d,m,Y', time());
        $cond1 = '%d,%m,%Y';
        $cond2 = $days;
        $status = '0';
        $projects1 = $this->admin_model->getProjectsdetails($cond1, $cond2, NULL, $status = '0');

        $start = $this->uri->segment(4, 0);
        //Get the inbox mail list
        $page_rows = $this->config->item('mail_limit');

        $limit[0] = $page_rows;
        if ($start > 0)
            $limit[1] = ($start - 1) * $page_rows;
        else
            $limit[1] = $start * $page_rows;
        //Get total jobs
        $order[0] = 'id';
        $order[1] = 'asc';

        $projects = $this->admin_model->getProjectsdetails($cond1, $cond2, $limit, $status = '0', $order);
        $this->outputData['jobs'] = $projects;

        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = admin_url('skills/todayOpen');
        $config['total_rows'] = $projects1->num_rows();
        $config['per_page'] = $page_rows;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $this->outputData['pagination'] = $this->pagination->create_links2(false, 'todayOpen');
        //assign some value to check the project type
        $this->outputData['namefunct'] = 'todayOpen';

        $this->load->view('admin/skills/viewJobs1', $this->outputData);


    } //Function Index End
//---------------------------------------------------------------------------------------


    /**
     * Get Today open jobs
     *
     * @access    public
     * @param    nil
     * @return    void
     */
    function todayClosed()
    {
        //Get total users
        $this->load->model('admin_model');
        $this->outputData['users'] = $this->admin_model->getUsers();
        $days = date('d,m,Y', time());
        $cond1 = '%d,%m,%Y';
        $cond2 = $days;
        $status = '2';
        $projects1 = $this->admin_model->getProjectsdetails($cond1, $cond2, NULL, $status = '2');

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
        //Get total jobs

        $projects = $this->admin_model->getProjectsdetails($cond1, $cond2, $limit, $status = '2', $order);
        $this->outputData['jobs'] = $projects;

        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = admin_url('skills/todayClosed');
        $config['total_rows'] = $projects1->num_rows();
        $config['per_page'] = $page_rows;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $this->outputData['pagination'] = $this->pagination->create_links2(false, 'todayClosed');
        //assign some value to check the job type
        $this->outputData['namefunct'] = 'todayClosed';

        $this->load->view('admin/skills/viewJobs1', $this->outputData);

    } //Function Index End
//---------------------------------------------------------------------------------------

    /**
     * Get Today open jobs
     *
     * @access    public
     * @param    nil
     * @return    void
     */
    function thisMonth()
    {
        //Get total users
        $this->load->model('admin_model');
        $this->outputData['users'] = $this->admin_model->getUsers();

        //Get total jobs
        $days = date('m,Y', time());
        $cond1 = '%m,%Y';
        $cond2 = $days;

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

        $projects1 = $this->admin_model->getProjects($cond1, $cond2);
        $projects = $this->admin_model->getProjects($cond1, $cond2, $limit, $order);

        $this->outputData['jobs'] = $projects;
        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = admin_url('skills/thisMonth');
        $config['total_rows'] = $projects1->num_rows();
        $config['per_page'] = $page_rows;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $this->outputData['pagination'] = $this->pagination->create_links2(false, 'thisMonth');
        //assign some value to check the job type
        $this->outputData['namefunct'] = 'thisMonth';

        $this->load->view('admin/skills/viewJobs1', $this->outputData);

    } //Function Index End
//---------------------------------------------------------------------------------------

    /**
     * Get Today open jobs
     *
     * @access    public
     * @param    nil
     * @return    void
     */
    function thisWeek()
    {
        //Get total users
        $this->load->model('admin_model');
        $this->outputData['users'] = $this->admin_model->getUsers();

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
        //Get total jobs
        $days = date('W,m,Y', time());
        $cond1 = '%u,%m,%Y';
        $cond2 = $days;

        $projects1 = $this->admin_model->getProjects($cond1, $cond2);
        $projects = $this->admin_model->getProjects($cond1, $cond2, $limit, $order);
        $this->outputData['jobs'] = $projects;

        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = admin_url('skills/thisWeek');
        $config['total_rows'] = $projects1->num_rows();
        $config['per_page'] = $page_rows;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $this->outputData['pagination'] = $this->pagination->create_links2(false, 'thisWeek');
        //assign some value to check the job type
        $this->outputData['namefunct'] = 'thisWeek';

        $this->load->view('admin/skills/viewJobs1', $this->outputData);


    } //Function Index End
//---------------------------------------------------------------------------------------

    /**
     * Get Today open jobs
     *
     * @access    public
     * @param    nil
     * @return    void
     */
    function thisYear()
    {
        //Get total users
        $this->load->model('admin_model');
        $start = $this->uri->segment(4, 0);
        $this->outputData['users'] = $this->admin_model->getUsers();

        //Get total jobs
        $days = date('Y', time());
        $cond1 = '%Y';
        $cond2 = $days;


        //Get the inbox mail list
        $page_rows = $this->config->item('mail_limit');

        $limit[0] = $page_rows;


        if ($start > 0)
            $limit[1] = ($start - 1) * $page_rows;
        else
            $limit[1] = $start * $page_rows;


        $order[0] = 'id';
        $order[1] = 'asc';

        $projects1 = $this->admin_model->getProjects($cond1, $cond2);
        $projects = $this->admin_model->getProjects($cond1, $cond2, $limit, $order);
        $this->outputData['jobs'] = $projects;

        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = admin_url('skills/thisYear');
        $config['total_rows'] = $projects1->num_rows();
        $config['per_page'] = $page_rows;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $this->outputData['pagination'] = $this->pagination->create_links2(false, 'thisYear');
        //assign some value to check the job type
        $this->outputData['namefunct'] = 'thisYear';

        $this->load->view('admin/skills/viewJobs1', $this->outputData);

    } //Function Index End
//---------------------------------------------------------------------------------------

    /* Search keyword
    */
    function search()
    {

        if ($this->input->post('id')) { ?>
            <div class="clsTable">
                <form name="searchTransaction" action="<?php echo admin_url('skills/searchJobs'); ?>" method="post">
                    <input type="hidden" name="name" id="name"/>
                    <tr>
                        <td><label><?= t('Enter Job Id'); ?></label></td>
                        <td><input type="text" name="projectid" id="projectid"/></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="search" value="<?= t('search'); ?>" class="clsSubmitBt1"/>
                        </td>
                    </tr>
                </form>
            </div>    <?php
        }
        if ($this->input->post('name')) { ?>
            <div class="clsTable">
                <form name="searchTransaction" action="<?php echo admin_url('skills/searchJobs'); ?>" method="post">
                    <input type="hidden" name="id" id="id"/>
                    <tr>
                        <td><label><?= t('Enter Job Name'); ?></label></td>
                        <td><input type="text" name="projectname" id="projectname"/></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="search" value="<?= t('search'); ?>" class="clsSubmitBt1"/>
                        </td>
                    </tr>
                </form>
            </div> <?php
        }
    }//Function end

    /* Job Report Violation
    / Param nil
    */
    function reportViolation()
    {
        //Get total users
        $this->outputData['users'] = $this->admin_model->getUsers();

        //Get total Report Violation
        $reports1 = $this->admin_model->getReports();


        $start = $this->uri->segment(4, 0);
        //Get the inbox mail list
        $page_rows = $this->config->item('mail_limit');

        $limit[0] = $page_rows;
        if ($start > 0)
            $limit[1] = ($start - 1) * $page_rows;
        else
            $limit[1] = $start * $page_rows;

        $order[0] = 'id';
        $order[1] = 'desc';

        $reports = $this->admin_model->getReports(NULL, NULL, NULL, $limit, $order);
        $this->outputData['reportViolation'] = $reports;
        //Pagination
        $this->load->library('pagination');
        $config['base_url'] = admin_url('skills/reportViolation');
        $config['total_rows'] = $reports1->num_rows();
        $config['per_page'] = $page_rows;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $this->outputData['pagination'] = $this->pagination->create_links2(false, 'reportViolation');

        $this->load->view('admin/skills/viewReports', $this->outputData);
    }

    /* delete Job Report Violation
    / Param id
    */
    function deleteReport()
    {
        $id = $this->uri->segment(4, 0);
        $condition = array('report_violation.id' => $id);
        $this->admin_model->deleteReport($condition);

        $this->notify->set(t('delete_success'), Notify::SUCCESS);
        redirect_admin('skills/reportViolation');
    }

    /**
     * Loads attachment_check
     *
     * @access    public
     * @param    nil
     * @return    void
     */
    function attachment_check()
    {

        if (isset($_FILES) and $_FILES['logo']['name'] == '')
            return true;

        $config['upload_path'] = 'files/category_logo/';
        $config['allowed_types'] = 'jpeg|jpg|png|gif|JPEG|JPG|PNG|GIF';
        $config['max_size'] = $this->config->item('max_upload_size');
        $config['encrypt_name'] = TRUE;
        $config['remove_spaces'] = TRUE;
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('logo')) {

            $this->data['file'] = $this->upload->data();
            return true;
        } else {
            $this->form_validation->set_message('attachment_check', $this->upload->display_errors($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag')));
            return false;
        }//If end
    }

    /**
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function editGroupRow()
    {
        if ($this->input->is_ajax_request()) {

            $id = $this->input->post('id', true);

            //Set Condition To Fetch The Faq
            $condition = array('groups.id' => $id);

            //Get Categories
            $this->outputData['groups'] = $this->skills_model->getGroups($condition);

            $this->outputData['mode'] = 'update';

            echo response([
                'html' => $this->load->view('admin/skills/viewGroupRow', $this->outputData, TRUE)
            ]);
        }
    }

    /**
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function refreshGroupRow()
    {
        if ($this->input->is_ajax_request()) {

            $id = $this->input->post('id', true);

            //Set Condition To Fetch The Faq
            $condition = array('groups.id' => $id);

            //Get Categories
            $this->outputData['mode'] = 'view';
            $this->outputData['groups'] = $this->skills_model->getGroups($condition);

            echo response([
                'html' => $this->load->view('admin/skills/viewGroupRow', $this->outputData, TRUE)
            ]);
        }
    }

    /**
     * Edit Faq
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function saveGroup()
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
            $this->form_validation->set_rules('group_name', 'lang:group_name_validation', 'required|trim|xss_clean|callback_groupNameCheck');
            $this->form_validation->set_rules('description', 'lang:description_validation');

            if ($this->form_validation->run()) {

                //prepare update data
                $updateData = array();
                $updateData['group_name'] = $this->input->post('group_name');
                $updateData['description'] = $this->input->post('description');
                $updateData['modified'] = get_est_time();

//                $updateData['attachment_url'] = $this->input->post('attachment_url');
//                $updateData['attachment_name'] = $this->input->post('attachment_name');

                //Add Groups
                $id = $this->skills_model->saveGroup($id, $updateData);

                //Notification message
                $this->notify->set(t('updated_success'), Notify::SUCCESS);
            }
            else {
                echo response([
                    'error' => true,
                    'message' => ""
                ]);
            }

            //Set Condition To Fetch The Faq
            $condition = array('groups.id' => $id);

            //Get Categories
            $this->outputData['mode'] = 'view';
            $this->outputData['groups'] = $this->skills_model->getGroups($condition);

            echo response([
                'html' => $this->load->view('admin/skills/viewGroupRow', $this->outputData, TRUE)
            ]);
        }
    }

    function deleteGroup()
    {
        if ($this->input->is_ajax_request()) {

            $id = $this->input->post('id', true);

            $condition = array('groups.id' => $id);
            $this->skills_model->deleteGroups(NULL, $condition);

            echo response([
                'error' => false,
                'message' => t('delete_success')
            ]);
        }
    }
}

?>