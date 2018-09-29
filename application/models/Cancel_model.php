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

class Cancel_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
		$this->load->model('messages_model');
	}

	/**
	 * @param $id
	 * @return array|null
	 * @throws Exception
	 */
	function get_case($id)
	{
		$this->db->select('*');
		$this->db->from('job_cases');
		$this->db->where('id', $id);
		$res = $this->db->get();
		if (!$res)
		{
			throw_db_exception();
		}

		$res = $res->row();
		if (isset($res))
		{
			return (array) $res;
		}
		else
		{
			return NULL;
		}
	}

	/**
	 * Get all project cases for current project
	 *
	 * @param $project_id
	 * @return array
	 */
	function get_project_cases($project_id)
	{
		$this->db->select('c.*, j.job_name, t.name as case_type_name');
		$this->db->from('jobs as j');
		$this->db->join('job_cases as c', 'j.id = c.job_id');
		$this->db->join('job_case_type as t', 't.id = c.case_type');
		$this->db->where('j.id', $project_id);
		$this->db->where('c.status', 1);

		$res = $this->db->get()->result_array();
		$count = count($res);
		for ($i = 0; $i < $count; $i++)
		{
			if ($res[$i]['case_type'] == 1)
			{
				$res[$i]['case_type_class'] = 'case-type-dispute';
			}
			elseif ($res[$i]['case_type'] == 2)
			{
				$res[$i]['case_type_class'] = 'case-type-cancelation';
			}
			else
			{
				$res[$i]['case_type_class'] = '';
			}
			$res[$i]['unread_count'] = count($this->messages_model->get_case_messages($this->logged_in_user->id, $res[$i]['id'], TRUE, '', ''));
		}
		return $res;
	}

	/**
	 * Get all project cases for current user
	 *
	 * @return array
	 */
	function get_user_cases()
	{
		$this->db->select('c.*, j.job_name, t.name as case_type_name');
		$this->db->from('jobs as j');
		$this->db->join('job_cases as c', 'j.id = c.job_id');
		$this->db->join('job_case_type as t', 't.id = c.case_type');
		$this->db->where("(j.employee_id = '".$this->logged_in_user->id."' OR j.creator_id = '".$this->logged_in_user->id."')");
		$this->db->where("(c.user_id = '".$this->logged_in_user->id."' OR c.status = 1)");

		$res = $this->db->get()->result_array();
		$count = count($res);
		for ($i = 0; $i < $count; $i++)
		{
			if ($res[$i]['case_type'] == 1)
			{
				$res[$i]['case_type_class'] = 'case-type-dispute';
			}
			elseif ($res[$i]['case_type'] == 2)
			{
				$res[$i]['case_type_class'] = 'case-type-cancelation';
			}
			else
			{
				$res[$i]['case_type_class'] = '';
			}
			$res[$i]['unread_count'] = count($this->messages_model->get_case_messages($this->logged_in_user->id, $res[$i]['id'], TRUE, '', ''));
			$res[$i]['status'] = $this->get_case_status($res[$i]['status']);
		}
		return $res;
	}

	/**
	 * Get all project cases for current user (count for sidebar)
	 *
	 * @param $user_id
	 * @return int
	 */
	function get_user_cases_count($user_id)
	{
		$this->db->select('COUNT(*) AS cnt');
		$this->db->from('jobs as j');
		$this->db->join('job_cases as c', 'j.id = c.job_id');
		$this->db->where("(j.employee_id = '".$user_id."' OR j.creator_id = '".$user_id."')");
		$this->db->where("(c.user_id = '".$user_id."' OR c.status = 1)");
		$res = $this->db->get()->row();
		if (isset($res))
		{
			return $res->cnt;
		}
		else
		{
			return 0;
		}
	}

	/**
	 * @return array
	 */
	function get_admin_cases()
	{
		$this->db->select('c.*, j.job_name, t.name as case_type_name');
		$this->db->from('jobs as j');
		$this->db->join('job_cases as c', 'j.id = c.job_id');
		$this->db->join('job_case_type as t', 't.id = c.case_type');

		$res = $this->db->get()->result_array();
		$count = count($res);
		for ($i = 0; $i < $count; $i++)
		{
			if ($res[$i]['case_type'] == 1)
			{
				$res[$i]['case_type_class'] = 'case-type-dispute';
			}
			elseif ($res[$i]['case_type'] == 2)
			{
				$res[$i]['case_type_class'] = 'case-type-cancelation';
			}
			else
			{
				$res[$i]['case_type_class'] = '';
			}
			$res[$i]['status'] = $this->get_case_status($res[$i]['status']);
		}
		return $res;
	}

	/**
	 * @param $status
	 * @return array|null
	 * @throws Exception
	 */
	function get_case_status($status)
	{
		$this->db->select('name');
		$this->db->from('job_case_status');
		$this->db->where('id', $status);
		$res = $this->db->get();
		if (!$res)
		{
			throw_db_exception();
		}

		$res = $res->row();
		if (isset($res))
		{
			return [
				'id' => $status,
				'text' => $res->name,
				'class' => 'case-status-'.str_replace(' ', '-', strtolower($res->name))
			];
		}
		else
		{
			return NULL;
		}
	}

	/**
	 * Create job case
	 *
	 * @param $data
	 */
	function create_case($data)
	{
		$this->db->insert('job_cases', $data);
		$id = $this->db->insert_id();

		// Insert message
		$this->messages_model->send_case_message($id, $data['user_id'], 'New case created', $data['comments']);
	}

	/**
	 * Get all case types
	 *
	 * @return array
	 */
	function get_case_types()
	{
		$this->db->select('*');
		$this->db->from('job_case_type');
		$this->db->order_by('id', 'ASC');
		return $this->db->get()->result_array();
	}

	/**
	 * Get all case reasons
	 *
	 * @return array
	 */
	function get_case_reasons()
	{
		$this->db->select('*');
		$this->db->from('job_case_reason');
		$this->db->order_by('id', 'ASC');
		return $this->db->get()->result_array();
	}

	/**
	 * Get all review types
	 *
	 * @return array
	 */
	function get_review_types()
	{
		$this->db->select('*');
		$this->db->from('job_review_type');
		$this->db->order_by('id', 'ASC');
		return $this->db->get()->result_array();
	}

	/**
	 * @param $id
	 * @throws Exception
	 */
	function admin_approve_case($id)
	{
		$this->db->select('*');
		$this->db->from('job_cases');
		$this->db->where('id', $id);
		$res = $this->db->get();
		if (!$res)
		{
			throw_db_exception();
		}

		$res = $res->row();
		if (!isset($res))
		{
			throw new Exception(t('Case does not exist'));
		}

		if ($res->status == 0)
		{
			$this->db->update('job_cases', ['status' => 1], ['id' => $id]);
		}
	}

	/**
	 * @param $id
	 * @throws Exception
	 */
	function admin_close_case($id)
	{
		$this->db->select('*');
		$this->db->from('job_cases');
		$this->db->where('id', $id);
		$res = $this->db->get();
		if (!$res)
		{
			throw_db_exception();
		}

		$res = $res->row();
		if (!isset($res))
		{
			throw new Exception(t('Case does not exist'));
		}

		if ($res->status == 1)
		{
			$this->db->update('job_cases', ['status' => 2], ['id' => $id]);
		}
		else
		{
			throw new Exception(t('To be closed, case needs to be open'));
		}
	}

	/**
	 * @param $id
	 * @throws Exception
	 */
	function admin_cancel_case_project($id)
	{
		$this->load->model('project_model');

		$this->db->select('*');
		$this->db->from('job_cases');
		$this->db->where('id', $id);
		$res = $this->db->get();
		if (!$res)
		{
			throw_db_exception();
		}

		$res = $res->row();
		if (!isset($res))
		{
			throw new Exception(t('Case does not exist'));
		}

		if ($res->status == 1 and $res->case_type == 2)
		{
			$this->db->update('job_cases', ['status' => 3], ['id' => $id]);
			$this->project_model->cancel_project($res->job_id);
		}
		else
		{
			throw new Exception(t('Case needs to be open and to be cancelation'));
		}
	}

	/**
	 * @param $id
	 * @throws Exception
	 */
	function admin_escalate_case($id)
	{
		$this->db->select('*');
		$this->db->from('job_cases');
		$this->db->where('id', $id);
		$res = $this->db->get();
		if (!$res)
		{
			throw_db_exception();
		}

		$res = $res->row();
		if (!isset($res))
		{
			throw new Exception(t('Case does not exist'));
		}

		if ($res->status == 1)
		{
			$this->db->update('job_cases', ['status' => 4], ['id' => $id]);
		}
		else
		{
			throw new Exception(t('To be escalated, case needs to be open'));
		}
	}
}