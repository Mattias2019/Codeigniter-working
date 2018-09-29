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

class Messages_model extends CI_Model {

	function __construct()
	{
		parent::__construct();

		$this->load->model('project_model');
		$this->load->model('user_model');
	}

	/**
	 * Returns single message
	 *
	 * @param $id
	 * @return array
	 */
	function get_message($id)
	{
		$this->db->select('*');
		$this->db->from('messages');
		$this->db->where('id', $id);
		$res = $this->db->get()->result_array();
		if (isset($res) and count($res) > 0)
		{
			return $res[0];
		}
		else
		{
			return NULL;
		}
	}

	/**
	 * Get inbox messages
	 *
	 * @param $user_id
	 * @param $project_id
	 * @param $unread
	 * @param $limit
	 * @param $order_by
	 * @return array
	 */
	function get_inbox($user_id, $project_id, $unread, $limit, $order_by)
	{
		$this->db->select("*, (select job_name from jobs where id = messages.job_id) as job_name,".
			" (select IF(first_name != '' OR last_name != '', concat(first_name, ' ', last_name), user_name) from users where id = messages.from_id) as from_name");
		$this->db->from('messages');
		$this->db->where('to_id', $user_id);
		if ($project_id != '')
		{
			$this->db->where('job_id', $project_id);
		}
		$this->db->where('to_delete', 0);
		$this->db->where('to_trash_delete', 0);
		if ($unread != '')
		{
			$this->db->where('notification_status', 0);
		}

		if (is_array($limit))
		{
			switch (count($limit))
			{
				case 1:
					$this->db->limit($limit[0]);
					break;
				case 2:
					$this->db->limit($limit[0], $limit[1]);
					break;
				default:
					// Fallback
			}
		}

		if (is_array($order_by) and count($order_by) == 2)
		{
			$this->db->order_by($order_by[0], $order_by[1]);
		}
		else
		{
			$this->db->order_by('created', 'desc');
		}

		$res = $this->db->get()->result_array();
		if (isset($res))
		{
			$count = count($res);
			for ($i = 0; $i < $count; $i++)
			{
				$res[$i]['created'] = date('H:i Y/m/d', $res[$i]['created']);
			}
			return $res;
		}
		else
		{
			return [];
		}
	}

	/**
	 * Get unread inbox messages count
	 *
	 * @param $user_id
	 * @return int
	 */
	function get_inbox_unread_count($user_id)
	{
		$this->db->select('COUNT(*) AS cnt');
		$this->db->from('messages');
		$this->db->where('to_id', $user_id);
		$this->db->where('notification_status', 0);
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
	 * Get outbox messages
	 *
	 * @param $user_id
	 * @param $project_id
	 * @param $unread
	 * @param $limit
	 * @param $order_by
	 * @return array
	 */
	function get_outbox($user_id, $project_id, $unread, $limit, $order_by)
	{
		$this->db->select("*, (select job_name from jobs where id = messages.job_id) as job_name,".
			" (select IF(first_name != '' OR last_name != '', concat(first_name, ' ', last_name), user_name) from users where id = messages.to_id) as to_name");
		$this->db->from('messages');
		$this->db->where('from_id', $user_id);
		if ($project_id != '')
		{
			$this->db->where('job_id', $project_id);
		}
		$this->db->where('from_delete', 0);
		$this->db->where('from_trash_delete', 0);
		if ($unread != '')
		{
			$this->db->where('notification_status', 0);
		}

		if (is_array($limit))
		{
			switch (count($limit))
			{
				case 1:
					$this->db->limit($limit[0]);
					break;
				case 2:
					$this->db->limit($limit[0], $limit[1]);
					break;
				default:
					// Fallback
			}
		}

		if (is_array($order_by) and count($order_by) == 2)
		{
			$this->db->order_by($order_by[0], $order_by[1]);
		}
		else
		{
			$this->db->order_by('created', 'desc');
		}

		$res = $this->db->get()->result_array();
		if (isset($res))
		{
			$count = count($res);
			for ($i = 0; $i < $count; $i++)
			{
				$res[$i]['created'] = date('H:i Y/m/d', $res[$i]['created']);
			}
			return $res;
		}
		else
		{
			return [];
		}
	}

	/**
	 * Get trash messages
	 *
	 * @param $user_id
	 * @param $project_id
	 * @param $unread
	 * @param $limit
	 * @param $order_by
	 * @return array
	 */
	function get_trash($user_id, $project_id, $unread, $limit, $order_by)
	{
		$this->db->select("*, (select job_name from jobs where id = messages.job_id) as job_name,".
			" (select IF(first_name != '' OR last_name != '', concat(first_name, ' ', last_name), user_name) from users where id = messages.from_id) as from_name,".
			" (select IF(first_name != '' OR last_name != '', concat(first_name, ' ', last_name), user_name) from users where id = messages.to_id) as to_name");
		$this->db->from('messages');
		if ($project_id != '')
		{
			$this->db->where('job_id', $project_id);
		}
		$this->db->where('(from_id = '.$user_id.' AND from_delete = 0 AND from_trash_delete = 1) OR (to_id = '.$user_id.' AND to_delete = 0 AND to_trash_delete = 1)');
		if ($unread != '')
		{
			$this->db->where('notification_status', 0);
		}

		if (is_array($limit))
		{
			switch (count($limit))
			{
				case 1:
					$this->db->limit($limit[0]);
					break;
				case 2:
					$this->db->limit($limit[0], $limit[1]);
					break;
				default:
					// Fallback
			}
		}

		if (is_array($order_by) and count($order_by) == 2)
		{
			$this->db->order_by($order_by[0], $order_by[1]);
		}
		else
		{
			$this->db->order_by('created', 'desc');
		}

		$res = $this->db->get()->result_array();
		if (isset($res))
		{
			$count = count($res);
			for ($i = 0; $i < $count; $i++)
			{
				$res[$i]['created'] = date('H:i Y/m/d', $res[$i]['created']);
			}
			return $res;
		}
		else
		{
			return [];
		}
	}

	/**
	 * Get messages for project
	 *
	 * @param $project_id
	 * @param $limit
	 * @param $order_by
	 * @return array
	 */
	function get_project_messages($project_id, $limit, $order_by)
	{
		$this->db->select("*, (select job_name from jobs where id = messages.job_id) as job_name,".
			" (select IF(first_name != '' OR last_name != '', concat(first_name, ' ', last_name), user_name) from users where id = messages.from_id) as from_name,".
			" (select IF(first_name != '' OR last_name != '', concat(first_name, ' ', last_name), user_name) from users where id = messages.to_id) as to_name");
		$this->db->from('messages');
		$this->db->where('job_id', $project_id);
		$this->db->where('to_delete', 0);
		$this->db->where('to_trash_delete', 0);

		if (is_array($limit))
		{
			switch (count($limit))
			{
				case 1:
					$this->db->limit($limit[0]);
					break;
				case 2:
					$this->db->limit($limit[0], $limit[1]);
					break;
				default:
					// Fallback
			}
		}

		if (is_array($order_by) and count($order_by) == 2)
		{
			$this->db->order_by($order_by[0], $order_by[1]);
		}
		else
		{
			$this->db->order_by('created', 'desc');
		}

		$res = $this->db->get()->result_array();
		if (isset($res))
		{
			$count = count($res);
			for ($i = 0; $i < $count; $i++)
			{
				$res[$i]['created'] = date('H:i Y/m/d', $res[$i]['created']);
			}
			return $res;
		}
		else
		{
			return [];
		}
	}

	/**
	 * Mark message as read
	 *
	 * @param $message_id
	 */
	function set_notified($message_id)
	{
		$this->db->update('messages', ['notification_status' => 1], ['id' => $message_id]);
	}

	/**
	 * Delete messages
	 *
	 * @param $message_ids
	 * @param $user_id
	 */
	function delete_messages($message_ids, $user_id)
	{
		if (is_array($message_ids))
		{
			foreach ($message_ids as $message_id)
			{
				$message = $this->get_message($message_id);
				if (isset($message))
				{
					// If message is not from/to user, do nothing
					if ($message['from_id'] == $user_id)
					{
						// If message is already in the trash bin, mark as "permanently deleted"
						if ($message['from_trash_delete'] == 1)
						{
							$this->db->update('messages', ['from_delete' => 1], ['id' => $message_id]);
						}
						else
						{
							$this->db->update('messages', ['from_trash_delete' => 1], ['id' => $message_id]);
						}
					}
					elseif ($message['to_id'] == $user_id)
					{
						// If message is already in the trash bin, mark as "permanently deleted"
						if ($message['to_trash_delete'] == 1)
						{
							$this->db->update('messages', ['to_delete' => 1], ['id' => $message_id]);
						}
						else
						{
							$this->db->update('messages', ['to_trash_delete' => 1], ['id' => $message_id]);
						}
					}
				}
			}
		}
	}

	/**
	 * Restore messages
	 *
	 * @param $message_ids
	 * @param $user_id
	 */
	function restore_messages($message_ids, $user_id)
	{
		if (is_array($message_ids))
		{
			foreach ($message_ids as $message_id)
			{
				$message = $this->get_message($message_id);
				if (isset($message))
				{
					// If message is not from/to user, do nothing
					if ($message['from_id'] == $user_id and $message['from_trash_delete'] == 1)
					{
						$this->db->update('messages', ['from_trash_delete' => 0], ['id' => $message_id]);
					}
					elseif ($message['to_id'] == $user_id and $message['to_trash_delete'] == 1)
					{
						$this->db->update('messages', ['to_trash_delete' => 0], ['id' => $message_id]);
					}
				}
			}
		}
	}

	/**
	 * Post message
	 *
	 * @param $from
	 * @param $to
	 * @param $project
	 * @param $subject
	 * @param $message
	 */
	function send_message($from, $to, $project, $subject, $message)
	{
		if (!is_array($to))
		{
			$to = [$to];
		}
		foreach ($to as $to_user)
		{
			$this->db->insert(
				'messages',
				[
					'from_id' => $from,
					'to_id' => $to_user,
					'job_id' => $project,
					'subject' => $subject,
					'message' => $message,
					'created' => get_est_time()
				]
			);
		}
	}

	/**
	 * Get job case messages
	 *
	 * @param $user_id
	 * @param $case_id
	 * @param $unread
	 * @param $limit
	 * @param $order_by
	 * @return array
	 */
	function get_case_messages($user_id, $case_id, $unread, $limit, $order_by)
	{
		// Case
		$this->db->select('c.*, j.job_name');
		$this->db->from('jobs as j');
		$this->db->join('job_cases as c', 'j.id = c.job_id');
		$this->db->where('c.id', $case_id);
		$this->db->where("(j.employee_id = '".$user_id."' OR j.creator_id = '".$user_id."')");
		$this->db->where("(c.user_id = '".$user_id."' OR c.status = 1)");
		$case = $this->db->get()->row();
		if (!isset($case))
		{
			return [];
		}

		// Case messages
		$this->db->select("*,".
			" (select IF(first_name != '' OR last_name != '', concat(first_name, ' ', last_name), user_name) from users where id = job_case_messages.user_id) as from_name");
		$this->db->from('job_case_messages');
		$this->db->where('case_id', $case->id);
		$this->db->where("(user_id = '".$user_id."' OR admin_approved = 1)");
		if ($unread != '')
		{
			$this->db->where('notification_status', 0);
			$this->db->where('user_id != ', $user_id);
		}

		if (is_array($limit))
		{
			switch (count($limit))
			{
				case 1:
					$this->db->limit($limit[0]);
					break;
				case 2:
					$this->db->limit($limit[0], $limit[1]);
					break;
				default:
					// Fallback
			}
		}

		if (is_array($order_by) and count($order_by) == 2)
		{
			$this->db->order_by($order_by[0], $order_by[1]);
		}
		else
		{
			$this->db->order_by('created', 'desc');
		}

		$res = $this->db->get()->result_array();
		if (isset($res))
		{
			$count = count($res);
			for ($i = 0; $i < $count; $i++)
			{
				$res[$i]['created'] = date('H:i Y/m/d', $res[$i]['created']);
				$res[$i]['job_id'] = $case->job_id;
				$res[$i]['job_name'] = $case->job_name;
				$res[$i]['status'] = $this->get_case_message_status($res[$i]['admin_approved']);
			}
			return $res;
		}
		else
		{
			return [];
		}
	}

	/**
	 * @param $case_id
	 * @param $limit
	 * @param $order_by
	 * @return array
	 */
	function get_admin_case_messages($case_id, $limit, $order_by)
	{
		// Case
		$this->db->select('c.*, j.job_name');
		$this->db->from('jobs as j');
		$this->db->join('job_cases as c', 'j.id = c.job_id');
		$this->db->where('c.id', $case_id);
		$case = $this->db->get()->row();
		if (!isset($case))
		{
			return [];
		}

		// Case messages
		$this->db->select("*,".
			" (select IF(first_name != '' OR last_name != '', concat(first_name, ' ', last_name), user_name) from users where id = job_case_messages.user_id) as from_name,");
		$this->db->from('job_case_messages');
		$this->db->where('case_id', $case->id);

		if (is_array($limit))
		{
			switch (count($limit))
			{
				case 1:
					$this->db->limit($limit[0]);
					break;
				case 2:
					$this->db->limit($limit[0], $limit[1]);
					break;
				default:
					// Fallback
			}
		}

		if (is_array($order_by) and count($order_by) == 2)
		{
			$this->db->order_by($order_by[0], $order_by[1]);
		}
		else
		{
			$this->db->order_by('created', 'desc');
		}

		$res = $this->db->get()->result_array();
		if (isset($res))
		{
			$count = count($res);
			for ($i = 0; $i < $count; $i++)
			{
				$res[$i]['created'] = date('H:i Y/m/d', $res[$i]['created']);
				$res[$i]['job_id'] = $case->job_id;
				$res[$i]['job_name'] = $case->job_name;
				$res[$i]['status'] = $this->get_case_message_status($res[$i]['admin_approved']);
			}
			return $res;
		}
		else
		{
			return [];
		}
	}

	/**
	 * @param $status
	 * @return array|null
	 * @throws Exception
	 */
	function get_case_message_status($status)
	{
		$this->db->select('name');
		$this->db->from('job_case_message_status');
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
				'class' => 'case-message-status-'.str_replace(' ', '-', strtolower($res->name))
			];
		}
		else
		{
			return NULL;
		}
	}

	/**
	 * Mark case message as read
	 *
	 * @param $message_id
	 */
	function set_notified_case($message_id)
	{
		$this->db->update('job_case_messages', ['notification_status' => 1], ['id' => $message_id]);
	}

	/**
	 * Post job case message
	 *
	 * @param $case
	 * @param $from
	 * @param $subject
	 * @param $message
	 */
	function send_case_message($case, $from, $subject, $message)
	{
		$this->db->insert(
			'job_case_messages',
			[
				'case_id' => $case,
				'user_id' => $from,
				'subject' => $subject,
				'message' => $message,
				'created' => get_est_time()
			]
		);
	}

	/**
	 * @param $id
	 * @throws Exception
	 */
	function admin_approve_message($id)
	{
		$this->load->model('cancel_model');

		$this->db->select('*');
		$this->db->from('job_case_messages');
		$this->db->where('id', $id);
		$res = $this->db->get();
		if (!$res)
		{
			throw_db_exception();
		}

		$res = $res->row();
		if (!isset($res))
		{
			throw new Exception(t('Message does not exist'));
		}

		$this->db->update('job_case_messages', ['admin_approved' => 1], ['id' => $id]);
		$this->cancel_model->admin_approve_case($res->case_id);
	}

	/**
	 * @param $id
	 * @throws Exception
	 */
	function admin_reject_message($id)
	{
		$this->db->select('*');
		$this->db->from('job_case_messages');
		$this->db->where('id', $id);
		$res = $this->db->get();
		if (!$res)
		{
			throw_db_exception();
		}

		$res = $res->row();
		if (!isset($res))
		{
			throw new Exception(t('Message does not exist'));
		}
		elseif ($res->admin_approved == 1)
		{
			throw new Exception(t('Message is already approved'));
		}

		$this->db->update('job_case_messages', ['admin_approved' => 2], ['id' => $id]);
	}
}