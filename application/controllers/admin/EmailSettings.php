<?php

class EmailSettings extends MY_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->library('settings');

        //Get Config Details From Db
        $this->settings->db_config_fetch();

        // loading the lang files
        load_lang(array(
            'admin/common',
            'admin/setting',
            'admin/validation'));

        //Load Models
        $this->load->model('common_model');

        //Get Logged In user
        $this->logged_in_user = $this->common_model->get_logged_in_user();
        $this->outputData['logged_in_user'] = $this->logged_in_user;
    }

    /**
     * Loads Email settings page.
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function index()
    {
        $this->add_js([
            'application/js/admin/view_emailTemplates.js',
            'application/js/pagination.js'
        ]);

        $this->init_js(["view_emailTemplates.init('" . admin_url() . "');"]);

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

        //Load model
        $this->load->model('email_model');

        //Get All Email Termplates List
        $this->outputData['email_settings'] = $this->email_model->getEmailSettings(null, $limit, $orderby);

        $total_rows = $this->email_model->countEmailTemplates()->row()->count;

        //Pagination
        $this->load->library('pagination');

        $this->outputData['pagination'] = get_pagination(admin_url('emailSettings/index'), $total_rows, $page_rows, $page);

        if ($this->input->is_ajax_request()) {
            if ($this->input->post('table_only') == 'true') {
                echo response([
                    'type' => 'table',
                    'data' => $this->load->view('admin/settings/view_emailTemplatesTableBody', $this->outputData, TRUE),
                    'pagination' => $this->outputData['pagination']
                ]);
            } else {
                echo response([
                    'type' => 'all',
                    'data' => $this->load->view('admin/settings/view_emailTemplatesTable', $this->outputData, TRUE),
                    'pagination' => $this->outputData['pagination']
                ]);
            }
        } else {
            $this->load->view('admin/settings/view_emailSettings', $this->outputData);
        }

    }

    function _emailtemplatesFrm()
    {
        $rules['template_subject'] = 'trim|required|alphanumeric';
        $rules['template_content'] = 'trim|required|alphanumeric';
        $fields['template_subject'] = t('emailtemplates_mail_subject');
        $fields['template_content'] = t('emailtemplates_mail_content');
        $this->validation->set_rules($rules);
        $this->validation->set_fields($fields);
    }

    /**
     * Edit EmailSettings.
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function edit()
    {
        $this->add_css([
            "application/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css",
            "application/css/admin/inbox.css",
            "application/plugins/fancybox/source/jquery.fancybox.css"
        ]);
        $this->add_js([
            "application/js/admin/inbox.js",
            "application/plugins/fancybox/source/jquery.fancybox.pack.js",
            "application/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js",
            "application/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js",
            "application/js/jquery.wysihtml5_size_matters.js"
        ]);

        $this->init_js(["inbox.init('" . admin_url() . "');"]);

        //Get id of the category
        $id = $this->uri->segment(3, 0);

        //Load model
        $this->load->model('email_model');

        //load validation library
        $this->load->library('form_validation');

        //Load Form Helper
        $this->load->helper('form');

        //Intialize values for library and helpers
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        if ($this->input->post('editEmailSetting')) {

            //Set rules
            $this->form_validation->set_rules('email_subject', 'lang:email_subject_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('email_body', 'lang:email_body_validation', 'required|trim|xss_clean');

            if ($this->form_validation->run()) {

                //prepare update data
                $updateData = array();
                $updateData['mail_subject '] = $this->input->post('email_subject');
                $updateData['mail_body'] = $this->input->post('email_body');


                //Update Email Settings
                $this->email_model->updateEmailSettings($id, $updateData);
                //Notification message
                $this->notify->set(t('updated_success'), Notify::SUCCESS);
                redirect_admin('emailSettings');
            }
        } //If - Form Submission End


        //Set Condition To Fetch The Email Settings info
        $condition = array('id' => $id);

        //Get Email Settings
        $this->outputData['emailSettings'] = $this->email_model->getEmailSettings($condition);


        //Load View
        $this->load->view('admin/settings/view_editEmailSettings', $this->outputData);

    }//End of editEmailSettings function

    /* Add new email settings

    /**
     * delete EmailSettings.
     *
     * @access	private
     * @param	nil
     * @return	void
     */
    function delete()
    {
        //Load model
        $this->load->model('email_model');
        //Get id of the category
        $id = is_numeric($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $condition = array('email_templates.id' => $id);
        $this->email_model->deleteEmailSettings($condition);
        //Notification message
        $this->notify->set(t('delete_success'), Notify::SUCCESS);
        redirect_admin('emailSettings');
    }    //function end
//---------------------------------------------

    /**
     * add EmailSettings.
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function addemailSettings()
    {
        $this->add_css([
            "application/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css",
            "application/css/admin/inbox.css",
            "application/plugins/fancybox/source/jquery.fancybox.css"
        ]);
        $this->add_js([
            "application/js/admin/inbox.js",
            "application/plugins/fancybox/source/jquery.fancybox.pack.js",
            "application/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js",
            "application/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js",
            "application/js/jquery.wysihtml5_size_matters.js"
        ]);

        $this->init_js(["inbox.init('" . admin_url() . "');"]);

        //Load model
        $this->load->model('email_model');

        //load validation library
        $this->load->library('form_validation');

        //Load Form Helper
        $this->load->helper('form');

        //Intialize values for library and helpers
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        if ($this->input->post('addEmailSettings')) {

            //Set rules
            $this->form_validation->set_rules('email_title', 'lang:email_title_validation', 'required|trim|xss_clean|callback_categoryNameCheck');
            $this->form_validation->set_rules('email_subject', 'lang:email_subject_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('email_body', 'lang:email_body_validation', 'required|trim|xss_clean');

            if ($this->form_validation->run()) {

                //prepare update data
                $insertData = array();
                $insertData['id'] = '';
                $insertData['type'] = $this->input->post('email_type');
                $insertData['title'] = $this->input->post('email_title');
                $insertData['mail_subject '] = $this->input->post('email_subject');
                $insertData['mail_body'] = $this->input->post('email_body');

                //add Email Settings
                $this->email_model->addEmailSettings($insertData);
                //Notification message
                $this->notify->set(t('updated_success'), Notify::SUCCESS);
                redirect_admin('emailSettings');
            }
        } //If - Form Submission End
        //Load View
        $this->load->view('admin/settings/view_addEmailSettings', $this->outputData);

    }

}
//End  EmailSettings Class

/* End of file EmailSettings.php */
/* Location: ./application/controllers/administration/EmailSettings.php */