<?php

/*
  ****************************************************************************
  ***                                                                      ***
  ***      BIDONN 1.0                                                      ***
  ***      File:  skills_model.php                                         ***
  ***      Built: Mon June 06 11:36:45 2012                                ***
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

class Support extends CI_Controller
{

    //Global variable
    public $outputData;


    // Constructor

    function __construct()
    {
        parent::__construct();

        //Check For Admin Logged in
        if (!isAdmin())
            redirect_admin('login');

        //Get Config Details From Db
        $this->load->library('settings');
        $this->settings->db_config_fetch();

        //Debug Tool
        //$this->output->enable_profiler=true;

        // loading the lang files
        load_lang(array(
            'admin/common',
            'admin/validation'));


        //Load Models Common to all the functions in this controller
        $this->load->model('common_model');
        $this->load->model('support_model');

        $this->load->helper('form');
        //$this->load->library('validation');
        $this->load->library('form_validation');

    }//Controller End

    // --------------------------------------------------------------------

    /**
     * Loads viewSupport
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function viewSupport()
    {

        // loading the lang files
        load_lang(array(
            'admin/support'));

        //load model
        $this->load->model('common_model');

        $start = $this->uri->segment(4, 0);

        //Get the inbox mail list
        $page_rows = $this->config->item('mail_limit');
        if ($this->uri->segment(5))
            $limit[0] = $this->uri->segment(5, 0);
        else
            $limit[0] = $page_rows;
        $this->outputData['limit'] = $limit[0];

        if ($start > 0)
            $limit[1] = ($start - 1) * $page_rows;
        else
            $limit[1] = $start * $page_rows;

        $this->outputData['limit'] = $limit[0];

        $support = $this->support_model->getTicketswithUsers(NULL, NULL);
        $this->outputData['support'] = $this->support_model->getTicketswithUsers(NULL, $limit);


        $order[0] = 'id';
        $order[1] = 'desc';

        $this->load->library('pagination');
        $config['base_url'] = admin_url('support/viewSupport');
        $config['total_rows'] = $support->num_rows();
        $config['per_page'] = $page_rows;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $this->outputData['pagination'] = $this->pagination->create_links2(false, 'viewSupport');
        //Load View
        $this->load->view('admin/support/view_support', $this->outputData);

    }//End of 	// --------------------------------------------------------------------

    // --------------------------------------------------------------------

    /**
     * delete Faq.
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function deleteSupport()
    {
        $id = $this->uri->segment(4, 0);
        //delete Faq Category
        $condition = array('support.id' => $id);
        $this->common_model->deleteTableData('support', $condition);
        //Notification message
        $this->notify->set(t('deleted_success'), Notify::SUCCESS);
        redirect_admin('support/viewSupport');
    }
    //Function end

    /**
     * pageNameCheck
     * checks whether page name already exists or not.
     *
     * @access    private
     * @param    string name of category
     * @return    bool true or false
     */
    function pageNameCheck()
    {
        //Condition to check

        if ($this->input->post('page_operation') !== false and $this->input->post('page_operation') == 'edit')
            $condition = array('page.name' => $this->input->post('page_name'), 'page.url' => $this->input->post('page_url'));
        else
            $condition = array('page.name' => $this->input->post('page_name'));

        //Check with table
        $resultPageName = $this->page_model->getPages($condition);

        if ($resultPageName->num_rows() > 0) {
            $this->form_validation->set_message('pageNameCheck', t('page_unique'));
            return FALSE;
        } else {
            return TRUE;
        }
    }//End of pageNameCheck function

    /**
     * checks whether page url already exists or not.
     *
     * @access    private
     * @param    string name of category
     * @return    bool true or false
     */
    function pageUrlCheck()
    {
        //Condition to check
        if ($this->input->post('page_operation') !== false and $this->input->post('page_operation') == 'edit')
            $condition = array('page.url' => $this->input->post('page_url'));
        else
            $condition = array('page.url' => $this->input->post('page_url'));

        //Check with table
        $resultPageName = $this->page_model->getPages($condition);

        if ($resultPageName->num_rows() > 0) {
            $this->form_validation->set_message('pageUrlCheck', t('url_unique'));
            return FALSE;
        } else {
            return TRUE;
        }
    }//End of pageUrlValid function

    /**
     * checks whether the url is in correct format or not.
     *
     * @access    private
     * @param    string name of category
     * @return    bool true or false
     */
    function pageUrlValid()
    {
        //Condition to check the url
        if ($this->input->post('page_operation') !== false and $this->input->post('page_operation') == 'add') {
            $str = $this->input->post('page_url');
            $pattern = '/^([-a-z0-9_])+$/i';
            if (!preg_match($pattern, $str)) {
                $this->form_validation->set_message('pageUrlValid', t('page_url_check'));
                return false;
            } else {
                return TRUE;
            }

        }

    }//End of pageUrlValid function


    function sendMail()
    {


        if ($this->uri->segment(4, 0)) {
            $this->outputData['to_mail'] = $this->uri->segment(4, 0);
        }
        if ($this->uri->segment(5, 0)) {
            $id = $this->uri->segment(5, 0);
            $conditions = array('id' => $id);
            $user = $this->common_model->getTableData('support', $conditions);
            $user = $user->row();
            $conditions = array('id' => $user->user_id);
            $user_data = $this->common_model->getTableData('users', $conditions);
            $user_data = $user_data->row();

        }
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));
        $this->form_validation->set_rules('to', 'lang:to', 'required|trim|xss_clean');
        $this->form_validation->set_rules('subject', 'lang:subject', 'required|trim|xss_clean');
        $this->form_validation->set_rules('content', 'lang:content', 'required|trim|xss_clean');

        if ($this->input->post('email_to_all', TRUE)) {

            $condition = array('support.id' => $this->uri->segment(5, 0));
            $updateData['reply'] = $this->input->post('content');

            $this->common_model->updateTableData('support', NULL, $updateData, $condition);

            if ($this->form_validation->run()) {
                $this->load->library('email');
                $this->load->model('email_model');
                $toEmail = $this->uri->segment(4, 0);
                $mailSubject = $this->input->post('subject');
                $fromEmail = $this->config->item('site_admin_mail');
                $mailContent = $this->input->post('content');

                $conditionPostticketMail = array('email_templates.type' => 'response_ticket');
                $resultPostticketMail = $this->email_model->getEmailSettings($conditionPostticketMail);
                $resultPostticketMail = $resultPostticketMail->row();

                $splVars_postticket = array("!username" => $user_data->user_name, "!site_name" => $this->config->item('site_title'), "!callid" => $user->callid, "!subject" => $user->subject, "!description" => $user->description, "!response" => $mailContent, "!question" => $mailSubject);

                $mailSubject = strtr($resultPostticketMail->mail_subject, $splVars_postticket);
                $mailContent = strtr($resultPostticketMail->mail_body, $splVars_postticket);
                $this->email_model->sendHtmlMail($toEmail, $fromEmail, $mailSubject, $mailContent);
                $this->notify->set(t('mail_success'), Notify::SUCCESS);
                redirect_admin('support/viewSupport');
            }
        }

        $this->load->view('admin/support/view_replyMail', $this->outputData);
    }

    function open()
    {

        if ($this->uri->segment(4, 0)) {
            $condition = array('id' => $this->uri->segment(4, 0));
            $updateData['status'] = 1;
            $this->common_model->updateTableData('support', NULL, $updateData, $condition);
        }
        $this->notify->set(t('success'), Notify::SUCCESS);
        redirect_admin('support/viewSupport');
    }

    function close()
    {
        if ($this->uri->segment(4, 0)) {
            $condition = array('id' => $this->uri->segment(4, 0));
            $updateData['status'] = 0;
            $this->common_model->updateTableData('support', NULL, $updateData, $condition);
        }
        $this->notify->set(t('success'), Notify::SUCCESS);
        redirect_admin('support/viewSupport');
    }


}
//End  Support Class

/* End of file support.php */
/* Location: ./application/controllers/administration/support.php */