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

class Faq_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * @return array
	 * @throws Exception
	 */
	function get_faq()
	{
		$this->db->select('*');
		$this->db->from('faq_categories');
		$res = $this->db->get();
		if (!$res)
		{
			throw_db_exception();
		}

		$res = $res->result_array();
		$count = count($res);
		for ($i = 0; $i < $count; $i++)
		{
			$this->db->select('*');
			$this->db->from('faqs');
			$this->db->where('faq_category_id', $res[$i]['id']);
			$res2 = $this->db->get();
			if (!$res2)
			{
				throw_db_exception();
			}
			$res[$i]['questions'] = $res2->result_array();
		}

		return $res;
	}



	/**
	 * Get Users
	 *
	 * @access    private
	 * @param    array    conditions to fetch data
	 * @return    object    object with result set
	 */
	function getFaqs($conditions = array(), $like = array())
	{
		if (count($conditions) > 0)
			$this->db->where($conditions);

		//Check For like statement
		if (is_array($like) and count($like) > 0)
			$this->db->or_like($like);

		$this->db->from('faqs');
		$this->db->join('faq_categories', 'faq_categories.id = faqs.faq_category_id', 'left');
		$this->db->select('faqs.id,faqs.faq_category_id,faq_categories.category_name,faqs.question,faqs.is_frequent,faqs.answer,faqs.created');
		$result = $this->db->get();
		return $result;

	}//End of getFaqs Function

	function getFaq($conditions = array(), $fields = '', $like = array(), $limit = array(), $orderby = array())
	{
		//Check For Conditions
		if (is_array($conditions) and count($conditions) > 0)
			$this->db->where($conditions);

		//Check For like statement
		if (is_array($like) and count($like) > 0)
			$this->db->like($like);

		//Check For Limit	
		if (is_array($limit)) {
			if (count($limit) == 1)
				$this->db->limit($limit[0]);
			else if (count($limit) == 2)
				$this->db->limit($limit[0], $limit[1]);
		}

		//Check for Order by
		if (is_array($orderby) and count($orderby) > 0)
			$this->db->order_by($orderby[0], $orderby[1]);

		$this->db->from('faqs');
		$this->db->join('faq_categories', 'faq_categories.id = faqs.faq_category_id', 'left');

		if ($fields != '')
			$this->db->select($fields);
		else
			$this->db->select('faqs.id,faqs.faq_category_id,faq_categories.category_name,faqs.question,faqs.is_frequent,faqs.answer,faqs.created');

		$result = $this->db->get();
		return $result;

	}//End of getFaqs Function


	// --------------------------------------------------------------------

	/**
	 * Get getFaqCategoriesWithFaqs
	 *
	 * @access    private
	 * @param    array    conditions to fetch data
	 * @return    object    object with result set
	 */
	function getFaqCategoriesWithFaqs()
	{
		//Get Faq Categories
		$query = $this->getFaqCategories();

		//Return Data
		$data = array();

		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $row) {
				$data[$i]['faq_category_id'] = $row->id;
				$data[$i]['faq_category_name'] = $row->category_name;
				$data[$i]['num_faqs'] = 0;

				$conditions = array('faq_category_id' => $row->id);
				$query_faqs = $this->getFaqs($conditions);

				//Check for query categories availability
				if ($query_faqs->num_rows() > 0) {
					$data[$i]['num_faqs'] = $query_faqs->num_rows();
					$data[$i]['faqs'] = $query_faqs;
				} //If End - Checks For categories availability
				$i++;
			}
		}//If End - check for group avaliability
		return $data;
	}//End of getFaqCategoriesWithFaqs Function

	// --------------------------------------------------------------------

	/**
	 * Add faq
	 *
	 * @access    private
	 * @param    array    an associative array of insert values
	 * @return    void
	 */
	function addFaq($insertData = array())
	{
		$this->db->insert('faqs', $insertData);

	}//End of addFaqCategory Function

	// --------------------------------------------------------------------

	/**
	 * delete faq
	 *
	 * @access    private
	 * @param    array    an associative array of insert values
	 * @return    void
	 */
	function deleteFaq_($id = 0, $conditions = array())
	{
		if (is_array($conditions) and count($conditions) > 0)
			$this->db->where($conditions);
		else
			$this->db->where('id', $id);
		$this->db->delete('faqs');

	}//End of deleteFaqCategory Function


	function deleteFaqCat($id = 0, $conditions = array())
	{
		if (is_array($conditions) and count($conditions) > 0)
			$this->db->where($conditions);
		else
			$this->db->where('id', $id);
		$this->db->from('faq_categories');
		$this->db->select('faq_categories.id,faq_categories.category_name,faq_categories.created');

		$query = $this->db->get();
		//Return Data
		$data = array();

		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $row) {
				$data[$i]['faq_category_id'] = $row->id;
				$data[$i]['faq_category_name'] = $row->category_name;
				$data[$i]['num_faqs'] = 0;

				$conditions = array('faq_category_id' => $row->id);
				$query_faqs = $this->getFaqs($conditions);

				$this->db->where($conditions);

				$this->db->delete('faqs');
				$i++;
			}

		}

	}//End of deleteFaqCategory Function

	function deleteFaqCategory($id)
	{
        $this->db->where('id', $id);
		$this->db->delete('faq_categories');
	}

    function deleteFaq($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('faqs');
    }

	/**
	 * Add faq category
	 *
	 * @access    private
	 * @param    array    an associative array of insert values
	 * @return    void
	 */
	function addFaqCategory($insertData = array())
	{
		$this->db->insert('faq_categories', $insertData);

	}//End of addFaqCategory Function

	// --------------------------------------------------------------------

	/**
	 * Update faq category
	 *
	 * @access    private
	 * @param    array    an associative array of insert values
	 * @return    int
	 */
	function saveFaqCategory($id = 0, $updateData = array())
	{
	    if ($id == 0) {
            $updateData['created'] = get_est_time();
            $this->db->insert('faq_categories', $updateData);
            $id = $this->db->insert_id();
        }
        else {
            $this->db->where('faq_categories.id', $id);
            $this->db->update('faq_categories', $updateData);
        }

        return $id;

	}

	// --------------------------------------------------------------------

	/**
	 * Update faq
	 *
	 * @access    private
	 * @param    array    an associative array of insert values
	 * @return    int
	 */
	function saveFaq($id = 0, $updateData = array())
	{
        if ($id == 0) {
            $updateData['created'] = get_est_time();
            $this->db->insert('faqs', $updateData);
            $id = $this->db->insert_id();
        }
        else {
            $this->db->where('faqs.id', $id);
            $this->db->update('faqs', $updateData);
        }

        return $id;
	}


	// --------------------------------------------------------------------

	/**
	 * Get Faq Categories
	 *
	 * @access    private
	 * @param    array    conditions to fetch data
	 * @return    object    object with result set
	 */
	function getFaqCategories($conditions = array(), $fields = '')
	{
		//Check For Conditions
		if (count($conditions) > 0)
			$this->db->where($conditions);

		$this->db->from('faq_categories');

		//Check For Fields	 
		if ($fields != '')
			$this->db->select($fields);
		else
			$this->db->select('faq_categories.id,faq_categories.category_name,faq_categories.created');

		$result = $this->db->get();
		return $result;

	}//End of getCategories Function

	function getFaqCategory($conditions = array(), $fields = '', $like = array(), $limit = array(), $orderby = array())
	{
		//Check For Conditions
		if (is_array($conditions) and count($conditions) > 0)
			$this->db->where($conditions);

		//Check For like statement
		if (is_array($like) and count($like) > 0)
			$this->db->like($like);

		//Check For Limit	
		if (is_array($limit)) {
			if (count($limit) == 1)
				$this->db->limit($limit[0]);
			else if (count($limit) == 2)
				$this->db->limit($limit[0], $limit[1]);
		}

		//Check for Order by
		if (is_array($orderby) and count($orderby) > 0)
			$this->db->order_by($orderby[0], $orderby[1]);

		$this->db->from('faq_categories');
		//Check For Fields	 
		if ($fields != '')
			$this->db->select($fields);
		else
			$this->db->select('faq_categories.id,faq_categories.category_name,faq_categories.created');

		$result = $this->db->get();
		return $result;

	}//End of getCategories Function
}