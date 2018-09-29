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

class Pages extends MY_Controller
{
	function __construct()
	{
		parent::__construct();

		if($this->config->item('site_status') == 1)
		{
			redirect('offline');
		}

		$this->load->model('page_model');
	}

	function index()
	{
		$this->outputData['pages'] = $this->page_model->get_pages();
		$this->load->view('admin/page/index', $this->outputData);
	}

	/**
	 * Save and reload row
	 */
	function save_row()
	{
		if ($this->input->is_ajax_request())
		{
			if ($this->input->post('url') == '')
			{
				echo response(t('URL is required'), TRUE);
				return;
			}
			elseif ($this->input->post('name') == '')
			{
				echo response(t('Name is required'), TRUE);
				return;
			}
			elseif ($this->input->post('page_title') == '')
			{
				echo response(t('Title is required'), TRUE);
				return;
			}
			elseif ($this->input->post('content') == '')
			{
				echo response(t('Page content is required'), TRUE);
				return;
			}

			$data = [
				'id' => (($this->input->post('id') == '')?NULL:$this->input->post('id')),
				'url' => $this->input->post('url'),
				'name' => $this->input->post('name'),
				'page_title' => $this->input->post('page_title'),
				'content' => $this->input->post('content'),
				'is_active' => (($this->input->post('is_active') == '')?0:$this->input->post('is_active'))
			];

			try
			{
				$this->page_model->save_page($data);
			}
			catch (Exception $e)
			{
				echo response($e->getMessage(), TRUE);
				return;
			}

			$page = $this->page_model->get_page($this->input->post('url'));
			if (isset($page))
			{
				$this->outputData['page'] = $page;
				echo response(['data' => $this->load->view('admin/page/index_table', $this->outputData, TRUE)]);
			}
			else
			{
				echo response('Error saving data', TRUE);
			}
		}
	}

	/**
	 * Reload one row
	 */
	function refresh_row()
	{
		if ($this->input->is_ajax_request())
		{
			$url = $this->input->post('url');
			if ($url != '')
			{
				$page = $this->page_model->get_page($url);
				if (isset($page))
				{
					$this->outputData['page'] = $page;
					echo response(['data' => $this->load->view('admin/page/index_table', $this->outputData, TRUE)]);
				}
				else
				{
					echo response('Page does not exist', TRUE);
				}
			}
			else
			{
				$this->outputData['page'] = NULL;
				echo response(['data' => $this->load->view('admin/page/index_table', $this->outputData, TRUE)]);
			}
		}
	}

	/**
	 * Request to delete row
	 */
	function delete_row()
	{
		if ($this->input->is_ajax_request())
		{
			$id = $this->input->post('id');
			$this->page_model->delete_page($id);
			echo response(NULL);
		}
	}
}