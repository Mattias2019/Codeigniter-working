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

class News_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get news
	 *
	 * @param $limit
	 * @return mixed
	 * @throws Exception
	 */
	function get_news($limit)
	{
		$this->db->select('*');
		$this->db->from('news');
		$this->db->order_by('time', 'DESC');

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

		$res = $this->db->get();
		if (!$res) {
			throw_db_exception();
		}
		return $res->result_array();
	}

	/**
	 * Add news
	 *
	 * @param $data
	 * @throws Exception
	 */
	function add_news($data)
	{
		if (!$this->db->insert('news', $data))
		{
			throw_db_exception();
		}
	}
}