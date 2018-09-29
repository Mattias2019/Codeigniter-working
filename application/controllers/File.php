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
 * @package	    Consultant Marketplace
 * @author	    Oprocon Dev Team
 * @copyright	Copyright (c) 2015 - 2016, Oprocon (https://consultant-marketplace.com/)
 * @link	    https://consultant-marketplace.com
 * @version     1.0.0
 */

/* TODO Workable */

class File extends MY_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->library('settings');

		$this->settings->db_config_fetch();

		if ($this->config->item('site_status') == 1)
		{
			redirect('offline');
		}

		ini_set('upload_max_filesize', '100M');

		$this->load->model('common_model');
		$this->load->model('skills_model');
		$this->load->model('file_model');
		$this->load->model('credential_model');
		$this->load->model('project_model');

		$this->load->helpers('file');
		$this->load->helpers('url');

		load_lang('enduser/file');

		$maximum = $this->config->item('upload_limit');
		$this->outputData['maximum_size'] = $maximum;
	}

	/**
	 * File manager page
	 */
	function index()
	{
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

		$this->add_css([
			'application/css/css/tmpl-css/bootstrap-datepicker.css',
			'application/css/css/dropzone.css',
            "application/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css",
		]);

		$this->add_js([
			'application/js/tmpl-js/bootstrap-datepicker.js',
			'application/js/dropzone.js',
			'application/js/pagination.js',
			'application/js/file.js',
            "application/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js",
            "application/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js",
            "application/js/jquery.wysihtml5_size_matters.js"
		]);

		$this->init_js(["file.init('" . site_url() . "');"]);

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

		$copy = ($this->input->get('action') == 'copy');

		// Segments
		if ($this->input->post('segment') != '')
		{
			$segment = $this->input->post('segment');
		}
		elseif (isEntrepreneur() and $copy)
		{
			$segment = 1;
		}
		elseif ($this->uri->segment(2) != '')
		{
			$segment = $this->uri->segment(2);
		}
		else
		{
			if (isEntrepreneur())
			{
				$segment = 1;
			}
			elseif (isProvider())
			{
				$segment = 2;
			}
			else
			{
				// Fallback
				$segment = 0;
			}
		}

		// File id
		$file_id = $this->input->post('id');
		$project_id = $this->input->post('job_id');
		$milestone_id = $this->input->post('milestone_id');

		if ($this->input->post('submit') != '')
		{
			// Set rules
			$this->form_validation->set_rules('img_url', 'lang:File', 'required|trim|xss_clean');
			$this->form_validation->set_rules('description', 'lang:Description', 'trim|xss_clean|no_email|no_phone_number');
			$this->form_validation->set_rules('expire_date', 'lang:Description', 'trim|xss_clean');
			if ($segment == 1)
			{
				$this->form_validation->set_rules('job_id', 'lang:Project', 'required');
			}

			if ($this->form_validation->run())
			{
				$data = ['id' => ''];

                if ($this->input->post('copy') == 1) {
                    $id = NULL;
                }
                else {
                    $id = $this->input->post('id');
                }

				if ($segment == 1 and $this->input->post('milestone_id') == '')
				{
					$data = [
						'id' => $id,
						'job_id' => $this->input->post('job_id'),
						'name' => $this->input->post('name'),
						'url' => $this->input->post('url'),
						'img_url' => $this->input->post('img_url'),
						'description' => $this->input->post('description'),
						'expire_date' => $this->input->post('expire_date')
					];

					if ($data['id'] == '')
					{
						$data['id'] = $this->project_model->insert_attachment($data, $data['job_id'], $this->logged_in_user->id);
					}
					else
					{
						$this->project_model->update_attachment($data);
					}
				}
				elseif ($segment == 1 and $this->input->post('milestone_id') != '')
				{
					$data = [
						'id' => $id,
						'milestone_id' => $this->input->post('milestone_id'),
						'name' => $this->input->post('name'),
						'url' => $this->input->post('url'),
						'img_url' => $this->input->post('img_url'),
						'description' => $this->input->post('description'),
						'expire_date' => $this->input->post('expire_date')
					];

					if ($data['id'] == '')
					{
						$data['id'] = $this->project_model->insert_milestone_attachment($data, $this->input->post('job_id'), $data['milestone_id'], $this->logged_in_user->id);
					}
					else
					{
						$this->project_model->update_milestone_attachment($data);
					}
				}
				elseif ($segment == 2 or $segment == 3)
				{
					$data = [
						'id' => $id,
						'user_id' => $this->logged_in_user->id,
						'file_type' => ($segment == 2)?1:2,
						'name' => $this->input->post('name'),
						'url' => $this->input->post('url'),
						'img_url' => $this->input->post('img_url'),
						'description' => $this->input->post('description'),
						'expire_date' => $this->input->post('expire_date')
					];

					if ($data['id'] == '')
					{
						$data['id'] = $this->file_model->insert_file($data, $this->logged_in_user->id);
					}
					else
					{
						$this->file_model->update_file($data);
					}
				}

				$file_id = $data['id'];
			}
		}

		if ($segment == 1)
		{
			$files = $this->file_model->get_project_files_list($this->logged_in_user->id, $max, $order_by);
			$files_count = count($this->file_model->get_project_files_list($this->logged_in_user->id, '', '', ''));

			if ($file_id != '')
			{
				if ($copy and $this->uri->segment(2) != '')
				{
					$this->outputData['file'] = $this->file_model->get_user_file_by_id($file_id);
				}
				else
				{
					$this->outputData['file'] = $this->file_model->get_project_file_by_id($file_id, $this->logged_in_user->id, $project_id, $milestone_id);
				}

				if ($copy)
				{
					$this->outputData['copy'] = 1;
				}
			}
			$this->outputData['projects'] = $this->project_model->get_user_projects($this->logged_in_user->id, TRUE);
			if ($project_id == '')
			{
				$this->outputData['milestones'] = [];
			}
			else
			{
				$this->outputData['milestones'] = $this->project_model->get_project_milestones($project_id);
			}
			$this->outputData['project'] = $project_id;
			$this->outputData['milestone'] = $milestone_id;
			$view = 'file/projects';
		}
		elseif ($segment == 2)
		{
			$files = $this->file_model->get_user_files_list($this->logged_in_user->id, 1, $max, $order_by);
			$files_count = count($this->file_model->get_user_files_list($this->logged_in_user->id, 1, '', '', ''));

			if ($file_id != '')
			{
				$this->outputData['file'] = $this->file_model->get_user_file_by_id($file_id);
			}
			$view = 'file/templates';
		}
		elseif ($segment == 3)
		{
			$files = $this->file_model->get_user_files_list($this->logged_in_user->id, 2, $max, $order_by);
			$files_count = count($this->file_model->get_user_files_list($this->logged_in_user->id, 2, '', '', ''));

			if ($file_id != '')
			{
				$this->outputData['file'] = $this->file_model->get_user_file_by_id($file_id);
			}
			$view = 'file/terms';
		}
		else
		{
			// Fallback
			return;
		}

		$this->outputData['view'] = $view;

		$this->outputData['files'] = $files;
		$this->outputData['pagination'] = get_pagination(site_url('file/index/'.$segment), $files_count, $page_rows, $page);

        if ($files_count == 0) {
            $this->outputData['page_numbers'] = array();
        }

        if ($this->input->is_ajax_request())
		{
			if ($this->input->post('table_only') == 'true')
			{
				echo response([
					'type' => 'table',
					'data' => $this->load->view($view.'_table', $this->outputData, TRUE),
					'pagination' => $this->outputData['pagination']
				]);
			}
			else {
                if ($this->input->post('action') == 'edit' or $this->input->post('action') == 'copy') {
                    $this->outputData['tab'] = $this->input->post('tab');
                    echo response([
                        'data' => $this->load->view('file/upload', $this->outputData, TRUE)
                    ]);
                } else {
                    echo response([
                        'type' => 'all',
                        'data' => $this->load->view($view, $this->outputData, TRUE)
                    ]);
                }
			}
		}
		else
		{
			$this->load->view('file/index', $this->outputData);
		}
	}

	/**
	 * Store file from dropzone.js
	 */
	function upload()
	{
		if(isset($_FILES) and is_array($_FILES) and array_key_exists('file', $_FILES))
		{
			$this->load->library('upload');
			$this->load->library('image_lib');

            set_time_limit(300);
            $this->config->set_item('max_upload_size', 25*1024);

			$config['upload_path'] 	    = $this->file_model->temp_dir($this->logged_in_user->id);
			/* For some reason, listing MIME types do not work */
			$config['allowed_types']    = 'bmp|BMP|gif|GIF|jpg|JPG|jpeg|JPEG|png|PNG|txt|TXT|doc|DOC|docx|DOCX|xls|XLS|xlsx|XLSX|ppt|PPT|pptx|PPTX|rar|RAR|zip|ZIP|pdf|PDF';
			$config['max_size'] 	    = $this->config->item('max_upload_size');
			$config['encrypt_name']     = TRUE;
			$config['file_ext_tolower'] = TRUE;

			$this->upload->initialize($config);

			$file = $_FILES['file'];
			$_FILES['file'] = $file;
			$this->upload->do_upload('file');
			$data = $this->upload->data();

			// Check if file is uploaded
			if ($data['file_name'] != '' and $data['orig_name'] != '')
			{
				// Resize image
				if ($data['is_image'])
				{
					$resize = [
						'source_image' => $data['full_path'],
						'maintain_ratio' => FALSE,
						'width' => 640,
						'height' => 480
					];
					$this->image_lib->initialize($resize);
					$this->image_lib->resize();
				}
				// Load attachment view
				$this->outputData['file'] = [
					'id' => NULL,
					'name' => $data['orig_name'],
					'url' => $data['file_name'],
					'img_url' => '/'.$config['upload_path'].$data['file_name']
				];
				$this->load->view('file/attachment', $this->outputData);
			}
		}
	}

	/**
	 * Get milestones for selected project
	 */
	function get_milestones()
	{
		if ($this->input->is_ajax_request())
		{
			$project = $this->input->get_post('id');
			$this->outputData['milestones'] = $this->project_model->get_project_milestones($project);
			if (count($this->outputData['milestones']) == 0)
			{
				$this->outputData['milestones'] = NULL;
			}
			$this->outputData['milestone'] = NULL;
			echo response($this->load->view('file/milestone_list', $this->outputData, TRUE));
		}
	}

	/**
	 * Request to delete file
	 */
	function delete()
	{
		if ($this->input->is_ajax_request())
		{
			$segment = $this->uri->segment(2);
			$id = $this->input->get('id');
			$project_id = $this->input->get('project_id');
			$milestone_id = $this->input->get('milestone_id');

			if ($segment == '' or $segment == 1)
			{
				$project = $this->project_model->get_project_by_id($project_id);
				if (!isset($project))
				{
					echo response(t('Project does not exist'), TRUE);
					return;
				}
				elseif ($project['job_status'] >= 3 and $project['job_status'] != 8)
				{
					echo response(t('Project cannot be edited if there are quotes placed'), TRUE);
					return;
				}
				$file = $this->file_model->get_project_file_by_id($id, $this->logged_in_user->id, $project_id, $milestone_id);
			}
			else
			{
				$file = $this->file_model->get_user_file_by_id($id);
			}

			if (!isset($file))
			{
				echo response(t('File does not exist'), TRUE);
				return;
			}

			if ($milestone_id != '')
			{
				$this->project_model->delete_milestone_attachment($this->logged_in_user->id, $project_id, $milestone_id, $id, $file['url']);
			}
			elseif ($project_id != '')
			{
				$this->project_model->delete_project_attachment($this->logged_in_user->id, $project_id, $id, $file['url']);
			}
			else
			{
				$this->file_model->delete_file($id);
			}

			echo response(NULL);
		}
	}
}