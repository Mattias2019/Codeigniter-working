<?php

class SiteSettings extends MY_Controller
{
    // Constructor
    function __construct()
    {
        parent::__construct();

        $this->load->library('settings');

        // Get Config Details From Db
        $this->settings->db_config_fetch();

        // loading the lang files
        load_lang(array(
            'admin/common',
            'admin/setting',
            'admin/validation'));

        // Load Models
        $this->load->model('common_model');
        $this->load->model('skills_model');

        //Get Logged In user
        $this->logged_in_user = $this->common_model->get_logged_in_user();
        $this->outputData['logged_in_user'] = $this->logged_in_user;
    }
    // Controller End

    // --------------------------------------------------------------------

    /**
     * Loads site settings page.
     *
     * @access private
     * @param
     *            nil
     * @return void
     */
    function index()
    {
        $this->add_js([
            'application/js/admin/site_settings.js'
        ]);

        $this->load->model('settings_model');

        // load validation library
        $this->load->library('form_validation');

        // Load Form Helper
        $this->load->helper('form');
        $this->load->helper('security');

        // Intialize values for library and helpers
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        // Get Form Details
        if ($this->input->post('siteSettings')) {
            // Set rules
            $this->form_validation->set_rules('site_title', 'lang:site_title_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('site_slogan', 'lang:site_slogan_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('site_admin_mail', 'lang:site_admin_mail_validation', 'required|trim|valid_email|xss_clean');
            $this->form_validation->set_rules('site_language', 'lang:site_language_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('offline_message', 'lang:offline_message_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('file_manager_limit', 'lang:file_manager_limit_validation', 'numeric|required|trim|xss_clean');
            $this->form_validation->set_rules('base_url', 'lang:base_url_validation', 'required|trim|xss_clean');

            $this->form_validation->set_rules('facebook', 'lang:url_validation', 'trim|valid_url|xss_clean');
            $this->form_validation->set_rules('twitter', 'lang:url_validation', 'trim|valid_url|xss_clean');
            $this->form_validation->set_rules('rss', 'lang:url_validation', 'trim|valid_url|xss_clean');
            $this->form_validation->set_rules('linkedin', 'lang:url_validation', 'trim|valid_url|xss_clean');

            if ($this->form_validation->run()) {
                $updateData = array();
                $updateData['site_title'] = $this->input->post('site_title');
                $updateData['site_language'] = $this->input->post('site_language');
                $updateData['twitter_username'] = $this->input->post('twitter_username');
                $updateData['twitter_password'] = $this->input->post('twitter_password');
                $updateData['site_slogan'] = $this->input->post('site_slogan');
                $updateData['site_admin_mail'] = $this->input->post('site_admin_mail');
                $updateData['site_status'] = ($this->input->post('site_status') == 1) ? 1 : 0;
                $updateData['offline_message'] = $this->input->post('offline_message');
                $updateData['provider_commission_amount'] = $this->input->post('employee_commission_amount');

                $updateData['facebook'] = $this->input->post('facebook');
                $updateData['twitter'] = $this->input->post('twitter');
                $updateData['rss'] = $this->input->post('rss');
                $updateData['linkedin'] = $this->input->post('linkedin');

                $updateData['currency'] = $this->input->post('currency');
                $updateData['time_zone'] = $this->input->post('timezones');
                $updateData['daylight'] = $this->input->post('daylight');

                $updateData['file_manager_limit'] = $this->input->post('file_manager_limit');
                $updateData['base_url'] = $this->input->post('base_url');
                $updateData['created'] = get_est_time();
                if (isset($this->outputData['file'])) {
                    $this->load->helper('file');
                    $Data['file'] = $this->outputData['file']['file_name'];
                    $thumb1 = $this->outputData['file']['file_path'] . 'h1_logo.jpg';
                    createLogo($this->outputData['file']['full_path'], $thumb1, 276, 79);
                }
                // pr($updateData);
                // Update Site Settings

                $this->settings_model->updateSiteSettings($updateData);

                // Notification message
                $this->notify->set(t('updated_success'), Notify::SUCCESS);
            }
        } // If - Form Submission End

        $this->outputData['base_url'] = admin_url('siteSettings/Index');

        $this->outputData['settings'] = $this->settings_model->getSiteSettings();
        $this->outputData['currency'] = $this->settings_model->setCurrency();

        $this->load->view('admin/settings/view_siteSettings', $this->outputData);
    }
    // End of index Function

    // --------------------------------------------------------------------

    /**
     * upload_file for both buyer and programmer
     *
     * @access private
     * @param
     *            nil
     * @return void
     */
    function upload_file()
    {
        // pr($_FILES);
        $config['upload_path'] = 'app/css/images';
        $config['allowed_types'] = 'jpeg|jpg|png|gif|JPEG|JPG|PNG|GIF|';
        $config['max_size'] = '100';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('file')) {
            $this->outputData['file'] = $this->upload->data();
            return true;
        } else {
            $this->form_validation->set_message('upload_file', $this->upload->display_errors($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag')));
            return false;
        } // If end
    }
    // Function upload_file End

    // --------------------------------------------------------------------

    /**
     * Get database backup.
     *
     * @access private
     * @param
     *            nil
     * @return void
     */
    function dbBackup()
    {
        $this->load->dbutil();
        $this->load->helper(array(
            'file',
            'download'));

        $prefs = array(
            'format' => 'zip',
            'filename' => 'db_backup_' . date("Ymd") . '.zip');

        // Backup your entire database and assign it to a variable
        $backup = &$this->dbutil->backup($prefs);
        write_file('temp/db/' . $prefs['filename'], $backup);
        force_download($prefs['filename'], $backup);
    }
    // End of database_backup Function

    // --------------------------------------------------------------------

    /**
     * Get Social Networks.
     *
     * @access private
     * @param
     *            nil
     * @return void
     */
    function networks()
    {
        $this->load->model('settings_model');

        // load validation library
        $this->load->library('form_validation');

        // Load Form Helper
        $this->load->helper('form');

        // Intialize values for library and helpers
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        // Get Form Details
        if ($this->input->post('networks')) {
            // Set rules
            $this->form_validation->set_rules('facebook', 'lang:facebook_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('twitter', 'lang:twitter_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('rss', 'lang:rss_validation', 'required|trim|xss_clean');
            $this->form_validation->set_rules('linkedin', 'lang:linkedin_validation', 'required|trim|xss_clean');

            if ($this->form_validation->run()) {

                $updateData = array();
                $updateData['Facebook'] = $this->input->post('facebook');
                $updateData['Twitter'] = $this->input->post('twitter');
                $updateData['RSS'] = $this->input->post('rss');
                $updateData['linkedin'] = $this->input->post('linkedin');

                // pr($updateData);
                // Update Site Settings

                $this->settings_model->updateNetworks($updateData);

                // Notification message
                $this->notify->set(t('updated_success'), Notify::SUCCESS);
                redirect_admin('siteSettings/networks');
            }
        } // If - Form Submission End

        $this->outputData['facebook'] = $this->db->get_where('social_networks', array(
            'site_name' => 'Facebook'))->row()->site_url;
        $this->outputData['twitter'] = $this->db->get_where('social_networks', array(
            'site_name' => 'Twitter'))->row()->site_url;
        $this->outputData['rss'] = $this->db->get_where('social_networks', array(
            'site_name' => 'RSS'))->row()->site_url;
        $this->outputData['linkedin'] = $this->db->get_where('social_networks', array(
            'site_name' => 'linkedin'))->row()->site_url;
        $this->load->view('admin/settings/view_networkSettings', $this->outputData);
    } // End of networks Function
}

// End SiteSettings Class

/* End of file siteSettings.php */
/* Location: ./application/controllers/administration/siteSettings.php */
?>