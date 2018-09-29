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

class Payment_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get list of all payment methods
	 *
	 * @param $order_by
	 * @return array
	 * @throws Exception
	 */
	function getPaymentSettings($order_by = [])
	{
		$this->db->select('*');
		$this->db->from('payment_methods');

		if (is_array($order_by) and count($order_by) > 0)
		{
			if (count($order_by) == 2)
			{
				$this->db->order_by($order_by[0], $order_by[1]);
			}
			elseif (count($order_by) == 1)
			{
				$this->db->order_by($order_by[0], 'ASC');
			}
			else
			{
				$this->db->order_by('id', 'ASC');
			}
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

		$res = $res->result_array();
		$count = count($res);
		for ($i = 0; $i < $count; $i++)
		{
			$res[$i]['credentials'] = $this->getPaymentCredentials($res[$i]['id']);
		}
		return $res;
	}

	/**
	 * Get single payment method
	 *
	 * @param $payment
	 * @return array|null
	 * @throws Exception
	 */
	function getPayment($payment)
	{
		$this->db->select('*');
		$this->db->from('payment_methods');
		if (is_numeric($payment))
		{
			$this->db->where('id', $payment);
		}
		else
		{
			$this->db->where('title', $payment);
		}
		$res = $this->db->get();
		if (!$res)
		{
			throw_db_exception();
		}
		$res = $res->row();
		if (isset($res))
		{
			$res = (array)$res;
			$res['credentials'] = $this->getPaymentCredentials($res['id']);
			return $res;
		}
		else
		{
			return NULL;
		}
	}

	/**
	 * Get single payment method credentials
	 *
	 * @param $payment_id
	 * @return array
	 * @throws Exception
	 */
	function getPaymentCredentials($payment_id)
	{
		$credentials = [];

		$this->db->select('*');
		$this->db->from('payment_method_credentials');
		$this->db->where('payment_method_id', $payment_id);
		$res = $this->db->get();
		if (!$res)
		{
			throw_db_exception();
		}
		$res = $res->result_array();
		foreach ($res as $credential)
		{
			$credentials[$credential['credential_key']] = [
				'name' => $credential['credential_name'],
				'value' => $credential['credential_value']
			];
		}
		return $credentials;
	}

	/**
	 * Save payment method data
	 *
	 * @param $data
	 * @return int
	 */
	function savePayment($data)
	{
		$credentials = [];
		if (array_key_exists('credentials', $data))
		{
			$credentials = $data['credentials'];
			unset($data['credentials']);
		}

		if ($data['id'] == NULL)
		{
			$this->db->insert('payment_methods', $data);
			$id = $this->db->insert_id();
		}
		else
		{
			$this->db->update('payment_methods', $data, ['id' => $data['id']]);
			$id = $data['id'];
		}

		foreach ($credentials as $credential)
		{
			$this->db->update('payment_method_credentials', ['credential_value' => $credential['value']], ['payment_method_id' => $data['id'], 'credential_key' => $credential['key']]);
			$q = $this->db->last_query();
		}

		return $id;
	}
}