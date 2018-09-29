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

class Page_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param $url
	 * @return array|null
	 * @throws Exception
	 */
	function get_page($url)
	{
		$this->db->select('*');
		$this->db->from('page');
		$this->db->where('url', strtolower($url));
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
	 * @param string $limit
	 * @param string $order_by
	 * @return array
	 * @throws Exception
	 */
	function get_pages($limit='', $order_by='')
	{
		$this->db->select('*');
		$this->db->from('page');

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
		return $res->result_array();
	}

	/**
	 * @param $data
	 * @return int
	 * @throws Exception
	 */
	function save_page($data)
	{
		if ($data['id'] == NULL or $data['id'] == '')
		{
			$data['id'] = NULL;
			$data['created'] = get_est_time();
			if (!$this->db->insert('page', $data))
			{
				throw_db_exception();
			}
			return $this->db->insert_id();
		}
		else
		{
			if (!$this->db->update('page', $data, ['id' => $data['id']]))
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
	function delete_page($id)
	{
		if (!$this->db->delete('page', ['id' => $id]))
		{
			throw_db_exception();
		}
	}


	/**
	 * Add Pages
	 *
	 * @access	private
	 * @param	array	an associative array of insert values
	 * @return	void
	 */
	 function addpage($insertData=array())
	 {
	 	$this->db->insert('page', $insertData);
		 
	 }//End of addpages Function	
	 
	 // --------------------------------------------------------------------
	 
	 
	 /**
	 * Get Pages
	 *
	 * @access	private
	 * @param	array	conditions to fetch data
	 * @return	object	object with result set
	 */
	
	 function getPages($conditions=array(),$like=array(),$like_or=array())
	 {
	 	//Check For like statement
	 	if(is_array($like) and count($like)>0)		
	 		$this->db->like($like);
			
		//Check For like statement
	 	if(is_array($like_or) and count($like_or)>0)		
	 		$this->db->or_like($like_or);
	
	 	if(count($conditions)>0)		
	 		$this->db->where($conditions);
		
		$this->db->from('page');
	 	$this->db->select('page.id,page.url,page.created,page.name,page.page_title,page.content,page.is_active');
		$result = $this->db->get();
		return $result;
		
	 }//End of getPages Function
   
	 
	 // --------------------------------------------------------------------
		
	/**
	 * Update Static Page
	 *
	 * @access	private
	 * @param	array	an associative array - for update key values
	 * @param	array	an associative array of update data
	 * @return	void
	 */
	 function updatePage($updateKey=array(),$updateData=array())
	 {
	 	 $this->db->update('page',$updateData,$updateKey);
		 
	 }//End of updateFaq Function 
	 
	 
	// --------------------------------------------------------------------
	
	
	/**
	 * delete page
	 *
	 * @access	private
	 * @param	array	an associative array of remove values
	 * @return	void
	 */
	 function deletePage($id=0,$conditions=array())
	 {
	 	if(is_array($conditions) and count($conditions)>0)		
	 		$this->db->where($conditions);
		else	
		    $this->db->where('id', $id);
		 $this->db->delete('page');
		 
	 }//End of deletePage Function
	 
	// --------------------------------------------------------------------

}
