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

class Notification_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get latest notifications
	 *
	 * @param $receiver_id
	 * @param $unread_only
	 * @param $limit
	 * @return array
	 * @throws Exception
	 */
	function get_latest($receiver_id, $unread_only = FALSE, $limit = 10)
	{
		$this->db->select('*');
		$this->db->from('notifications');
		$this->db->where('receiver_id', $receiver_id);
		if ($unread_only)
		{
			$this->db->where('notified = 0');
		}
		$this->db->limit($limit);
		$res = $this->db->get();
		if (!$res)
		{
			throw_db_exception();
		}
		return $res->result_array();
	}

	/**
	 * Add notification
	 *
	 * @param $key
	 * @param $receiver_id
	 * @param string $url
	 * @param array $params
	 * @throws Exception
	 */
	function add($key, $receiver_id, $url = NULL, $params = [])
	{
		// Get notification type
		$this->db->select('*');
		$this->db->from('notification_types');
		$this->db->where('notification_key', $key);
		$type = $this->db->get();
		if (!$type)
		{
			throw_db_exception();
		}
		$type = $type->row();
		if (!isset($type))
		{
			return;
		}

		// Get message
		$message = $type->message;
		if (isset($params) and is_array($params))
		{
			foreach ($params as $key => $value)
			{
				$message = str_replace($key, $value, $message);
			}
		}

		// Set notification
		$this->db->insert('notifications', [
			'type' => $type->id,
			'receiver_id' => $receiver_id,
			'message' => $message,
			'url' => $url,
			'time' => get_est_time()
		]);
	}

	/**
	 * Mark notification as read
	 *
	 * @param $id
	 * @throws Exception
	 */
	function set_notified($id)
	{
		if (!$this->db->update('notifications', ['notified' => 1], ['id' => $id]))
		{
			throw_db_exception();
		}
	}
}