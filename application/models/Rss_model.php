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

class Rss_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper('db');
	}

	/**
	 * Get RSS feed with categories
	 *
	 * @param $id
	 * @return array|null
	 * @throws Exception
	 */
	function get_custom_feed($id)
	{
		$this->db->select('*');
		$this->db->from('custom_rss_feeds');
		$this->db->where('id', $id);

		$res = $this->db->get();
		if (!$res)
		{
			throw_db_exception();
		}

		$res = $res->row();
		if (isset($res))
		{
			$res = (array) $res;

			// Categories
			$res['categories'] = [];
			foreach ($this->get_feed_categories($res['id']) as $category)
			{
				$res['categories'][] = $category['category_id'];
			}

			return $res;
		}
		else
		{
			return NULL;
		}
	}

	/**
	 * Get RSS feeds for user
	 *
	 * @param $user
	 * @param $limit
	 * @param $order_by
	 * @return array
	 * @throws Exception
	 */
	function get_user_custom_feeds($user, $limit, $order_by)
	{
		$this->db->select('*');
		$this->db->from('custom_rss_feeds');
		$this->db->where('user_id', $user);

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
			$res[$i]['categories'] = $this->get_feed_categories($res[$i]['id']);
		}
		return $res;
	}

	/**
	 * Returns the list of all groups/categories for feed
	 *
	 * @param $feed_id
	 * @return array
	 * @throws Exception
	 */
	function get_feed_categories($feed_id)
	{
		$this->db->select('g.id as group_id, g.group_name, c.id as category_id, c.category_name');
		$this->db->from('custom_rss_feed_categories as fc');
		$this->db->join('categories as c', 'fc.category_id = c.id');
		$this->db->join('groups as g', 'c.group_id = g.id');
		$this->db->where('fc.feed_id', $feed_id);
		$this->db->order_by('g.id', 'ASC');
		$this->db->order_by('c.id', 'ASC');

		$res = $this->db->get();
		if (!$res)
		{
			throw_db_exception();
		}
		return $res->result_array();
	}

	/**
	 * Insert/update custom RSS feed
	 *
	 * @param $data
	 * @return int
	 * @throws Exception
	 */
	function save_custom_feed($data)
	{
		// Remove non-DB fields
		if (array_key_exists('categories', $data))
		{
			$categories = $data['categories'];
			unset($data['categories']);
		}

		$this->db->trans_start();

		// Main table
		if ($data['id'] == '' or $data['id'] == NULL)
		{
			$data['id'] = NULL;
			if (!$this->db->insert('custom_rss_feeds', $data))
			{
				$this->db->trans_rollback();
				throw_db_exception();
			}
			$id = $this->db->insert_id();
		}
		else
		{
			if (!$this->db->update('custom_rss_feeds', $data, array('id' => $data['id'])))
			{
				$this->db->trans_rollback();
				throw_db_exception();
			}
			$id = $data['id'];
		}

		// Categories
		if (!$this->db->delete('custom_rss_feed_categories', ['feed_id' => $id]))
		{
			$this->db->trans_rollback();
			throw_db_exception();
		}
		if (isset($categories) and is_array($categories))
		{
			foreach ($categories as $category)
			{
				if (!$this->db->insert('custom_rss_feed_categories', ['feed_id' => $id, 'category_id' => $category]))
				{
					$this->db->trans_rollback();
					throw_db_exception();
				}
			}
		}

		// Finalize
		$this->db->trans_complete();

		return $id;
	}

	/**
	 * Delete custom RSS feed
	 *
	 * @param $id
	 */
	function delete_custom_feed($id)
	{
		$this->db->delete('custom_rss_feeds', ['id' => $id]);
	}
}