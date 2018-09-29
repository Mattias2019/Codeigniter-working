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

class Package_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param $active_only
	 * @param $limit
	 * @param $order_by
	 * @return array
	 * @throws Exception
	 */
	function getPackages($active_only = TRUE, $limit='', $order_by='')
	{
		$this->db->select('*');
		$this->db->from('packages');
		if ($active_only)
		{
			$this->db->where('isactive', 1);
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

		if (is_array($order_by) and count($order_by) == 2 and $order_by[0] != '')
		{
			$this->db->order_by($order_by[0], $order_by[1]);
		}
		else
		{
			$this->db->order_by('id', 'ASC');
		}

		$res = $this->db->get();
		if (!$res)
		{
			throw_db_exception();
		}
		return $res->result_array();
	}

	/**
	 * @param $id
	 * @return array|null
	 * @throws Exception
	 */
	function getPackage($id)
	{
		$this->db->select('*');
		$this->db->from('packages');
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
	 * @param $data
	 * @return int
	 * @throws Exception
	 */
	function savePackage($data)
	{
		if (!isset($data['id']) or $data['id'] == '')
		{
			$data['id'] = NULL;
			$data['created_date'] = get_est_time();
			$data['updated_date'] = get_est_time();
			if (!$this->db->insert('packages', $data))
			{
				throw_db_exception();
			}
			return $this->db->insert_id();
		}
		else
		{
			$data['updated_date'] = get_est_time();
			if (!$this->db->update('packages', $data, ['id' => $data['id']]))
			{
				throw_db_exception();
			}
			return $data['id'];
		}
	}

	/**
	 * @param $id
	 * @throws Exception
	 */
	function deletePackage($id)
	{
		if (!$this->db->delete('packages', ['id' => $id]))
		{
			throw_db_exception();
		}
	}

	/**
	 * @param $user_name
	 * @param $email
	 * @param $package
	 * @param $limit
	 * @param $order_by
	 * @return array
	 * @throws Exception
	 */
	function getSubscriptionUsers($user_name='', $email='', $package='', $limit='', $order_by='')
	{
		$this->db->select('s.*, p.package_name, u.id AS user_id, u.user_name');
		$this->db->from('subscriptionuser AS s');
		$this->db->join('packages AS p', 'p.id = s.package_id');
		$this->db->join('users AS u', 'u.id = s.user_id');
		if ($user_name != '')
		{
			$this->db->like('u.user_name', $user_name);
		}
		if ($email != '')
		{
			$this->db->like('u.email', $email);
		}
		if ($package != '')
		{
			$this->db->where('s.package_id', $package);
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

		if (is_array($order_by) and count($order_by) == 2 and $order_by[0] != '')
		{
			$this->db->order_by($order_by[0], $order_by[1]);
		}
		else
		{
			$this->db->order_by('s.id', 'ASC');
		}

		$res = $this->db->get();
		if (!$res)
		{
			throw_db_exception();
		}
		return $res->result_array();
	}

	/**
	 * @param $id
	 * @return array|null
	 * @throws Exception
	 */
	function getSubscriptionUser($id)
	{
		$this->db->select('s.*, u.user_name, u.email');
		$this->db->from('subscriptionuser AS s');
		$this->db->join('users AS u', 'u.id = s.user_id');
		$this->db->where('s.id', $id);
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
	 * @param $data
	 * @return int
	 * @throws Exception
	 */
	function saveSubscriptionUser($data)
	{
		if (!isset($data['id']) or $data['id'] == '')
		{
			$data['id'] = NULL;
			$data['created'] = get_est_time();
			$data['updated_date'] = get_est_time();
			if (!$this->db->insert('subscriptionuser', $data))
			{
				throw_db_exception();
			}
			return $this->db->insert_id();
		}
		else
		{
			$data['updated_date'] = get_est_time();
			if (!$this->db->update('subscriptionuser', $data, ['id' => $data['id']]))
			{
				throw_db_exception();
			}
			return $data['id'];
		}
	}

	/**
	 * @param $id
	 * @throws Exception
	 */
	function deleteSubscriptionUser($id)
	{
		if (!$this->db->delete('subscriptionuser', ['id' => $id]))
		{
			throw_db_exception();
		}
	}

	/**
	 * @param string $user_name
	 * @param string $email
	 * @param string $package
	 * @param string $limit
	 * @param string $order_by
	 * @return array
	 * @throws Exception
	 */
	function getSubscriptionPayments($user_name='', $email='', $package='', $limit='', $order_by='')
	{
		$this->db->select('s.*, p.package_name, u.id AS user_id, u.user_name, i.amount');
		$this->db->from('subscriptionuser AS s');
		$this->db->join('packages AS p', 'p.id = s.package_id');
		$this->db->join('users AS u', 'u.id = s.user_id');
		$this->db->join('transactions AS t', 'p.id = t.package_id');
		$this->db->join('transaction_items AS i', 'i.transaction_id = t.id');
		$this->db->join('user_balance AS b', 'b.id = i.account_id AND b.user_id = u.id');
		if ($user_name != '')
		{
			$this->db->like('u.user_name', $user_name);
		}
		if ($email != '')
		{
			$this->db->like('u.email', $email);
		}
		if ($package != '')
		{
			$this->db->where('s.package_id', $package);
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

		if (is_array($order_by) and count($order_by) == 2 and $order_by[0] != '')
		{
			$this->db->order_by($order_by[0], $order_by[1]);
		}
		else
		{
			$this->db->order_by('s.id', 'ASC');
		}

		$res = $this->db->get();
		if (!$res)
		{
			throw_db_exception();
		}
		return $res->result_array();
	}
}