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

class Language_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get DB ID of current language
	 *
	 * @return null
	 * @throws Exception
	 */
	function get_current_language_id()
	{
		$this->db->select('id');
		$this->db->from('languages');
		$this->db->where('name', $this->config->item('language'));
		$res = $this->db->get();
		if (!isset($res))
		{
			throw_db_exception();
		}

		$res = $res->row();
		if (isset($res))
		{
			return $res->id;
		}
		else
		{
			return NULL;
		}
	}
}