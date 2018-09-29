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


class Feedback extends My_Controller
{

    //Constructor

    function __construct()
    {
        parent::__construct();

        $this->load->library('settings');
        $this->load->library('session');

        //Get Config Details From Db
        $this->settings->db_config_fetch();

        // loading the lang files
        load_lang(array(
            'admin/common',
            'admin/setting',
            'admin/validation',
            'admin/login'));

        //Load Models
        $this->load->model('common_model');
        $this->load->model('support_model');
        $this->outputData['login'] = 'TRUE';

        //Get Logged In user
        $this->logged_in_user = $this->common_model->get_logged_in_user();
        $this->outputData['logged_in_user'] = $this->logged_in_user;

    }

    // --------------------------------------------------------------------

    /**
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function index()
    {
        redirect_admin('feedback');

    }//End of index Function

    /**
     * View feedbacks
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function viewFeedbacks()
    {
        $this->add_js([
            'application/js/admin/view_feedback.js',
            'application/js/pagination.js'
        ]);

        $this->init_js(["view_feedback.init('" . admin_url() . "');"]);

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
            $field = 'f.feedback_id';
        }
        if ($this->input->post('order')) {
            $order = $this->input->post('order');
        } else {
            $order = 'ASC';
        }
        $orderby = [$field, $order];

        // filter
        $feedback_type_id = null;
        if ($this->input->post("feedback_type_id")) {
            $feedback_type_id = $this->input->post('feedback_type_id');
        } elseif (isset($_SESSION["view_feedback_filter"]["feedback_type_id"])) {
            $feedback_type_id = $_SESSION["view_feedback_filter"]["feedback_type_id"];
        }

        $_SESSION["view_feedback_filter"] =
            array(
                "feedback_type_id" => $feedback_type_id
            );

        $like = array();
        $where = array();
        if (isset($feedback_type_id) && $feedback_type_id != "") {
            $where = array('f.feedback_type' => $feedback_type_id);
        }

        //Get feedbacks
        $feedbacks = $this->support_model->getFeedback($where, '', $like, $limit, $orderby);

        $this->outputData['feedbacks'] = $feedbacks;

        $this->outputData['view_feedback_filter'] = $_SESSION["view_feedback_filter"];

        $this->outputData['feedback_types'] = $this->support_model->getFeedbackTypes();

        $total_rows = $this->support_model->countFeedbacks($where, $like)->row()->count;

        //Pagination
        $this->load->library('pagination');

        $this->outputData['pagination'] = get_pagination(admin_url('feedback/viewFeedbacks/'), $total_rows, $page_rows, $page);

        if ($this->input->is_ajax_request()) {
            if ($this->input->post('table_only') == 'true') {
                echo response([
                    'type' => 'table',
                    'data' => $this->load->view('admin/feedback/view_feedbacksTableBody', $this->outputData, TRUE),
                    'pagination' => $this->outputData['pagination']
                ]);
            } else {
                echo response([
                    'type' => 'all',
                    'data' => $this->load->view('admin/feedback/view_feedbacksTable', $this->outputData, TRUE),
                    'pagination' => $this->outputData['pagination']
                ]);
//                echo response([
//                    'html' => $this->load->view('admin/users/view_usersTable',$this->outputData,TRUE),
//                    'pagination' => $this->outputData['pagination']
//                ]);
            }
        } else {
            $this->load->view('admin/feedback/view_feedbacks', $this->outputData);
        }
    }

    public function exportFeedbackToExcel()
    {

        $xls = new PHPExcel();

        // filter
        $feedback_type_id = null;
        if ($this->input->get("feedback_type_id") != "") {
            $feedback_type_id = $this->input->get('feedback_type_id');
        } elseif (isset($_SESSION["view_feedback_filter"]["feedback_type_id"])) {
            $feedback_type_id = $_SESSION["view_feedback_filter"]["feedback_type_id"];
        }

        $where = array();
        if (isset($feedback_type_id) && $feedback_type_id != "") {
            $where = array('f.feedback_type' => $feedback_type_id);
        }

        // Get Sorting order
        if ($this->input->post('field')) {
            $field = $this->input->post('field');
        } else {
            $field = 'f.feedback_id';
        }
        if ($this->input->post('order')) {
            $order = $this->input->post('order');
        } else {
            $order = 'ASC';
        }
        $orderby = [$field, $order];

        $feedbacks = $this->support_model->getFeedback($where, '', '', '', $orderby);

        $xls->getProperties()
            ->setCreator($feedbacks->row()->user_name)
            ->setLastModifiedBy($feedbacks->row()->user_name)
            ->setTitle("Feedback")
            ->setSubject("Feedback")
            ->setDescription("Feedback")
            ->setKeywords("Feedback")
            ->setCategory("Feedback");

        $xls->getActiveSheet()->setTitle('Feedback');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $xls->setActiveSheetIndex(0);

        $ext = "xlsx";

        $random = random_string('numeric');
        $fileName = "feedback" . $random . "." . $ext;

        $i = 1;
        $str_list = null;
        $header = array();
        foreach ($feedbacks->result_array() as $fields) {
            // header
            if ($i == 1) {

                $xls->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, t('Feedback ID'))
                    ->setCellValue('B' . $i, t('Username'))
                    ->setCellValue('C' . $i, t('Feedback time'))
                    ->setCellValue('D' . $i, t('Browser'))
                    ->setCellValue('E' . $i, t('Language'))
                    ->setCellValue('F' . $i, t('Feedback type'))
                    ->setCellValue('G' . $i, t('Memo text'))
                    ->setCellValue('H' . $i, t('Page reference'))
                    ->setCellValue('I' . $i, t('Geo location'));

                $xls->getActiveSheet()->getStyle('A1:I1')->getFill()->setFillType(
                    PHPExcel_Style_Fill::FILL_NONE);

                $xls->getActiveSheet()->getStyle('A1:I1')->getAlignment()->setHorizontal(
                    PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }

            $xls->setActiveSheetIndex(0)
                ->setCellValue('A' . ($i + 1), $fields['feedback_id'])
                ->setCellValue('B' . ($i + 1), $fields['user_name'])
                ->setCellValue('C' . ($i + 1), $fields['time_stamp'])
                ->setCellValue('D' . ($i + 1), $fields['browser'])
                ->setCellValue('E' . ($i + 1), $fields['language'])
                ->setCellValue('F' . ($i + 1), $fields['feedback_type_name'])
                ->setCellValue('G' . ($i + 1), $fields['memo_text'])
                ->setCellValue('H' . ($i + 1), $fields['page_reference'])
                ->setCellValue('I' . ($i + 1), $fields['geo_location']);

            $i++;
        }

        foreach (range('A', 'I') as $columnID) {
            $xls->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
        }

        $path = 'files/';

        $objWriter = PHPExcel_IOFactory::createWriter($xls, 'Excel2007');
        $objWriter->save($path . $fileName);

        $file_content = file_get_contents($path . $fileName); // Read the file's contents
        if (file_exists($path . $fileName)) {
            unlink($path . $fileName);
        }

        $this->load->helper('download');
        force_download($fileName, $file_content, true);
    }
}

?>