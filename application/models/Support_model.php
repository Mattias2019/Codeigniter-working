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

class Support_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

    function getFeedback($conditions = array(), $fields = '', $like = array(), $limit = array(), $orderby = array())
    {
        if (is_array($conditions) and count($conditions) > 0)
            $this->db->where($conditions);

        //Check For like statement
        if (is_array($like) and count($like) > 0) {
            if (count($like) == 1) {
                $this->db->like($like);
            } elseif (count($like) > 1) {
                $this->db->group_start();
                $this->db->or_like($like);
                $this->db->group_end();
            }
        }

        //Check For Limit
        if (is_array($limit)) {
            if (count($limit) == 1)
                $this->db->limit($limit[0]);
            else if (count($limit) == 2)
                $this->db->limit($limit[0], $limit[1]);
        }
        //pr($orderby);
        //Check for Order by
        if (is_array($orderby) and count($orderby) > 0)
            $this->db->order_by($orderby[0], $orderby[1]);


        $this->db->from('feedback as f');
        $this->db->join('feedback_type as ft', 'ft.feedback_type_id = f.feedback_type');
        $this->db->join('users as u', 'u.id = f.user_id', 'left');

        if ($fields != '')
        {
            $this->db->select($fields);
        }
        else
        {
            $this->db->select('f.feedback_id, concat(u.first_name," ",u.last_name) as user_name, f.time_stamp, f.browser, 
                               f.language, f.feedback_type, ft.feedback_type_name, f.memo_text, f.page_reference, 
                               f.geo_location');
        }

        $result = $this->db->get();
        return $result;

    }

    function countFeedbacks($conditions = array(), $like = array())
    {
        if (is_array($conditions) and count($conditions) > 0) {
            $this->db->where($conditions);
        }

        //Check For like statement
        if (is_array($like) and count($like) > 0) {
            if (count($like) == 1) {
                $this->db->like($like);
            } elseif (count($like) > 1) {
                $this->db->group_start();
                $this->db->or_like($like);
                $this->db->group_end();
            }
        }

        $this->db->from('feedback as f');

        $this->db->select('count(f.feedback_id) as count');

        $result = $this->db->get();
        return $result;
    }

    function getFeedbackTypes()
    {

        $this->db->select('ft.feedback_type_id, ft.feedback_type_name');
        $query = $this->db->get('feedback_type ft');
        return $query;
    }

	/**
	 * @param $data
	 * @throws Exception
	 */
	function send_question($data)
	{
		if (!$this->db->insert('support', $data))
		{
			throw_db_exception();
		}
	}

	/**
	 * @param $data
	 */
	function feedback($data)
	{
		if (!$this->db->insert('feedback', $data))
		{
			throw_db_exception();
		}
	}

	function getTicketswithUsers($conditons = array(), $limit)
	{
		if (count($conditons) > 0) {
			$this->db->where($conditons);
		}
		if (is_array($limit)) {
			if (count($limit) == 1)
				$this->db->limit($limit[0]);
			else if (count($limit) == 2)
				$this->db->limit($limit[0], $limit[1]);
		}
		$this->db->from('support');
		$this->db->join('users', 'users.id=support.user_id');
		$this->db->join('roles', 'users.role_id=roles.id');
		$this->db->join('country', 'users.country_id=country.id', 'left');
		$this->db->select('support.id,roles.role_name,users.user_name,users.name,users.role_id,country.country_name,users.message_notify,users.password,users.email,users.city,users.state,users.profile_desc,users.rate,users.job_notify,users.user_status,users.activation_key,users.created,support.callid,support.subject,support.category,support.description,support.priority,support.status,support.user_id,support.reply');
		$result = $this->db->get();

		//pr($result);
		return $result;
	}
}