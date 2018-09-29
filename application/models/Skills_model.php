<?php

/*
  ****************************************************************************
  ***                                                                      ***
  ***      BIDONN 1.0                                                 	   ***
  ***      File:  skills_model.php                                         ***
  ***      Built: Mon June 06 11:36:45 2012                                ***
  ***      http://www.maventricks.com                                      ***
  ***                                                                      ***
  ****************************************************************************
  
  <Bidonn>
    Copyright (C) <2012> <Maventricks Technologies>.
 
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
	If you want more information, please email me at sathick@maventricks.com or 
    contact us from http://www.maventricks.com/contactus
*/

class Skills_model extends CI_Model
{


	// Constructor 
	function __construct()
	{
		parent::__construct();

		$this->load->helper('db');
	}

	// --------------------------------------------------------------------

	/**
	 * Get groups
	 *
	 * @access    private
	 * @param    array    conditions to fetch data
	 * @return    object    object with result set
	 */
	function getGroups($conditions = array())
	{
		if (count($conditions) > 0)
			$this->db->where($conditions);

		$this->db->select('groups.id, groups.group_name, groups.description, groups.created, 
		                        groups.modified, groups.attachment_url, groups.attachment_name');
		$result = $this->db->get('groups');
		return $result;

	}


	function get_slides($conditions = array())
	{
		if (count($conditions) > 0)
			$this->db->where($conditions);

		$this->db->select('slider.id,slider.group_name,slider.description,slider.created,slider.modified,slider.attachment_url,slider.attachment_name');
		$result = $this->db->get('slider');
		return $result;

	}

	function getGroup($conditions = array(), $fields = '', $like = array(), $limit = array(), $orderby = array())
	{
		//Check For Conditions
		if (is_array($conditions) and count($conditions) > 0) {
            $this->db->where($conditions);
        }

		//Check For like statement
		if (is_array($like) and count($like) > 0) {
            $this->db->like($like);
        }

		//Check For Limit	
		if (is_array($limit)) {
			if (count($limit) == 1) {
                $this->db->limit($limit[0]);
            }
			elseif (count($limit) == 2) {
                $this->db->limit($limit[0], $limit[1]);
            }
		}

		//Check for Order by
		if (is_array($orderby) and count($orderby) > 0) {
            $this->db->order_by($orderby[0], $orderby[1]);
        }

		$this->db->select('groups.id,groups.group_name,groups.description,groups.created,groups.modified,groups.attachment_url,groups.attachment_name');
		$result = $this->db->get('groups');
		return $result;

	}//End of getGroup Function


	function get_slide($conditions = array(), $fields = '', $like = array(), $limit = array(), $orderby = array())
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
		//pr($orderby);
		//Check for Order by
		if (is_array($orderby) and count($orderby) > 0)
			$this->db->order_by($orderby[0], $orderby[1]);

		$this->db->select('slider.id,slider.group_name,slider.description,slider.created,slider.modified,slider.attachment_url,slider.attachment_name');
		$result = $this->db->get('slider');
		return $result;

	}

	// --------------------------------------------------------------------

	/**
	 * Get bookmark
	 *
	 * @access    private
	 * @param    array    conditions to fetch data
	 * @return    object    object with result set
	 */
	function getBookmark($conditions = array(), $fields = '', $like = array(), $limit = array(), $orderby = array())
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
		//pr($orderby);
		//Check for Order by
		if (is_array($orderby) and count($orderby) > 0)
			$this->db->order_by($orderby[0], $orderby[1]);

		$this->db->from('bookmark');
		$this->db->join('jobs', 'bookmark.job_id = jobs.id', 'left');
		if ($fields != '')
			$this->db->select($fields);
		else
			$this->db->select('jobs.id,jobs.job_name,jobs.job_status,jobs.description,jobs.budget_min,jobs.budget_max,jobs.creator_id,jobs.is_feature,jobs.is_urgent,jobs.is_hide_bids,jobs.created,jobs.is_private,jobs.is_private,private_users,jobs.enddate,jobs.employee_id,jobs.job_award_date,jobs.job_award_date,jobs.checkstamp,jobs.owner_rated,jobs.job_paid,jobs.flag,bookmark.id,bookmark.creator_name,bookmark.job_id,bookmark.job_name,bookmark.job_creator');

		$result = $this->db->get();
		return $result;

	}
	// --------------------------------------------------------------------


	/**
	 * Get getGroupsWithCategory
	 *
	 * @access   private
	 * @param    array    conditions to fetch data
	 * @param     string
	 * @param     array
	 * @param     array
	 * @return   array    object with result set
	 */
	function getGroupsWithCategory($conditions = [], $user = '', $category_conditions = [], $category_conditions_in = [])
	{
		//Get Groups
		$query = $this->getGroups($conditions);

		//Return Data
		$data = [];

		if ($query->num_rows() > 0) {
			$i = 0;
			foreach ($query->result() as $row) {

				if ($user != '') {
					$this->load->model('user_model');
					$category_conditions['categories.group_id'] = $row->id;
					$category_conditions['user_categories.user_id'] = $user;
					$query_categories = $this->user_model->getUserCategories($category_conditions);
				} else {
					$category_conditions['categories.group_id'] = $row->id;
					$query_categories = $this->getCategories($category_conditions, '', $category_conditions_in);
				}

				if ($query_categories->num_rows() == 0) {
					continue;
				}

				$data[$i]['group_id'] = $row->id;
				$data[$i]['group_name'] = $row->group_name;
				$data[$i]['description'] = $row->description;
				$data[$i]['created'] = $row->created;
				$data[$i]['modified'] = $row->modified;
				$data[$i]['num_categories'] = $query_categories->num_rows();
				$data[$i]['categories'] = $query_categories->result_array();

				$i++;
			}
		}

		return $data;
	}

	// --------------------------------------------------------------------

	/**
	 * Add group
	 *
	 * @access    private
	 * @param    array    an associative array of insert values
	 * @return    void
	 */
	function addGroup($insertData = array())
	{
        $this->db->insert('groups', $insertData);

        $id = $this->db->insert_id();

        // Logo
        // Check if logo had changed, i.e. file with set name does not exist
        $logo = $this->file_model->get_group_logo_file_path($id, $insertData['attachment_name']);

        if ($logo == '' or $logo == STANDARD_LOGO) {
            $this->file_model->copy_group_logo_from_path($id, $insertData['attachment_url'], $insertData['attachment_name']);
        }

	}//End of addGroup Function


	function add_slide($insertData = array())
	{
		$this->db->insert('slider', $insertData);
	}

	// --------------------------------------------------------------------

	/**
	 * delete jobs
	 *
	 * @access    private
	 * @param    array    an associative array of insert values
	 * @return    void
	 */


	function delete_slide($id = 0, $conditions = array())
	{
		if (is_array($conditions) and count($conditions) > 0)
			$this->db->where($conditions);
		else
			$this->db->where('id', $id);
		$this->db->delete('slider');

	}

	function deleteGroups($id = 0, $conditions = array())
	{
		if (is_array($conditions) and count($conditions) > 0)
			$this->db->where($conditions);
		else
			$this->db->where('id', $id);
		$this->db->delete('groups');

	}//End of deletejobs Function
	// --------------------------------------------------------------------

	/**
	 * Convert Categories Id to name
	 *
	 * @access    private
	 * @param    array    an associative array of insert values
	 * @return    void
	 */
	function convertCategoryIdsToName($categoryIds = array())
	{
		$data = array();
		if (count($categoryIds) > 0) {
			foreach ($categoryIds as $categoryId) {
				$condition = array('categories.id' => $categoryId);
				$fields = 'categories.id,categories.category_name';
				$query = $this->getCategories($condition, $fields);
				$row = $query->row();

				if ($query->num_rows() > 0)
					$data[$categoryId] = $row->category_name;
				//pr($data[$categoryId]);
			}//ForEach End -Traverse Categories		
		}
		return $data;
	}//End of addGroup Function

	// --------------------------------------------------------------------

	/**
	 * Add job
	 *
	 * @access    private
	 * @param    array    an associative array of insert values
	 * @return    void
	 */
	function createProject($insertData = array())
	{
		$this->db->insert('jobs', $insertData);

	}//End of addGroup Function

	/**
	 * Get jobsLists for transfer money
	 *
	 * @access    private
	 * @param    nil
	 * @return    object    object with result set
	 */
	function getpreviewJobs($conditions = array())
	{
		if (count($conditions) > 0)
			$this->db->where($conditions);
		$this->db->from('jobs_preview');
		$this->db->select('jobs_preview.id,jobs_preview.job_name,jobs_preview.job_status,jobs_preview.description,,jobs_preview.country,jobs_preview.state,jobs_preview.city,jobs_preview.budget_min,jobs_preview.budget_max,jobs_preview.job_categories,jobs_preview.creator_id,jobs_preview.is_feature,jobs_preview.is_urgent,jobs_preview.is_hide_bids,jobs_preview.created,jobs_preview.enddate,jobs_preview.employee_id,jobs_preview.job_award_date,jobs_preview.flag,jobs_preview.contact,jobs_preview.salary,jobs_preview.salarytype');

		$result = $this->db->get();
		//pr($result->result());exit;
		return $result;

	}//End of getpreviewJobs Function

	// --------------------------------------------------------------------


	/**
	 * Add job
	 *
	 * @access    private
	 * @param    array    an associative array of insert values
	 * @return    void
	 */
	function previewJob($insertData = array())
	{
		$this->db->insert('jobs_preview', $insertData);

	}//End of addGroup Function

	// --------------------------------------------------------------------

	/**
	 * delete projects
	 *
	 * @access    private
	 * @param    array    an associative array of insert values
	 * @return    void
	 */
	function deletepreviewProject($conditions = array())
	{
		if (is_array($conditions) and count($conditions) > 0)
			$this->db->where($conditions);
		$this->db->delete('jobs_preview');

	}//End of deleteProjects Function

	// --------------------------------------------------------------------

	/**
	 * Add draft Job
	 *
	 * @access    private
	 * @param    array
	 * @return    void
	 */
	function draftJob($insertData = array())
	{
		$this->db->insert('draftjobs', $insertData);

	}//End of draftJob Function

	// --------------------------------------------------------------------

	/**
	 * Add Bids
	 *
	 * @access    private
	 * @param    array    an associative array of insert values
	 * @return    void
	 */
	function createBids($insertData = array())
	{
		$this->db->insert('bids', $insertData);

	}//End of addGroup Function

	// --------------------------------------------------------------------

	/**
	 * Update Bids
	 *
	 * @access    private
	 * @param    array    an associative array of insert values
	 * @return    void
	 */
	function updateBids($id = 0, $updateData = array(), $conditions = array())
	{
		if (count($conditions) > 0 && is_array($conditions))
			$this->db->where($conditions);
		else
			$this->db->where('id', $id);
		$this->db->update('bids', $updateData);

	}//End of addGroup Function

	// --------------------------------------------------------------------

	/**
	 * Edit group
	 *
	 * @access    private
	 * @param    array    an associative array of insert values
	 * @return    void
	 */
	function updateGroup($id = 0, $updateData = array())
	{
        // Logo
        // Check if logo had changed, i.e. file with set name does not exist
        $logo = $this->file_model->get_group_logo_file_path($id, $updateData['attachment_name']);

        if ($logo == '' or $logo == STANDARD_LOGO) {
            $this->file_model->copy_group_logo_from_path($id, $updateData['attachment_url'], $updateData['attachment_name']);
        }
        unset($updateData['attachment_url']);

		$this->db->where('groups.id', $id);
		$this->db->update('groups', $updateData);

	}//End of editGroup Function

    /**
     * Edit group
     *
     * @access    private
     * @param    array    an associative array of insert values
     * @return    int
     */
    function saveGroup($id = 0, $updateData = array())
    {
        if ($id == 0) {
            $updateData['created'] = get_est_time();
            $this->db->insert('groups', $updateData);
            $id = $this->db->insert_id();
        }
        else {
            $this->db->where('groups.id', $id);
            $this->db->update('groups', $updateData);
        }

        return $id;

    }

	function update_slide($id = 0, $updateData = array())
	{
		$this->db->where('slider.id', $id);
		$this->db->update('slider', $updateData);

	}
	// --------------------------------------------------------------------

	/**
	 * Update category
	 *
	 * @access    private
	 * @param    array    an associative array of insert values
	 * @return    void
	 */
	function updateCategory($id = 0, $updateData = array())
	{
        // Logo
        // Check if logo had changed, i.e. file with set name does not exist
        $logo = $this->file_model->get_category_logo_file_path($id, $updateData['attachment_name']);

        if ($logo == '' or $logo == STANDARD_LOGO) {
            $this->file_model->copy_category_logo_from_path($id, $updateData['attachment_url'], $updateData['attachment_name']);
        }
        unset($updateData['attachment_url']);

		$this->db->where('categories.id', $id);
		$this->db->update('categories', $updateData);

	}//End of editGroup Function

	// --------------------------------------------------------------------

	/**
	 * delete projects
	 *
	 * @access    private
	 * @param    array    an associative array of insert values
	 * @return    void
	 */
	function deleteCategory($id = 0, $conditions = array())
	{
		if (is_array($conditions) and count($conditions) > 0)
			$this->db->where($conditions);
		else
			$this->db->where('id', $id);
		$this->db->delete('categories');

	}//End of deleteProjects Function
	// --------------------------------------------------------------------

	/**
	 * Add category
	 *
	 * @access    private
	 * @param    array    an associative array of insert values
	 * @return    void
	 */
	function addCategory($insertData = array())
	{
		$this->db->insert('categories', $insertData);

	}

	// --------------------------------------------------------------------

	/**
	 * Get Categories
	 *
	 * @access    private
	 * @param    array    conditions to fetch data
	 * @return    object    object with result set
	 */
	function getCategories($conditions = array(), $fields = '', $conditions_in = array())
	{
		//Check For Conditions
		if (count($conditions) > 0) {
			$this->db->where($conditions);
		}
		if (count($conditions_in) > 0) {
			foreach ($conditions_in as $conditions_in_key => $conditions_in_value) {
				$this->db->where_in($conditions_in_key, $conditions_in_value);
			}
		}

		$this->db->from('categories');
		$this->db->join('groups', 'groups.id = categories.group_id', 'left');
		//Check For Fields	 
		if ($fields != '')
			$this->db->select($fields);
		else
			$this->db->select('categories.id,categories.group_id,categories.category_name,categories.category_name_encry,groups.group_name, categories.description, categories.attachment_url,categories.attachment_name,categories.page_title, categories.meta_keywords, categories.meta_description, categories.is_active, categories.created, categories.modified,groups.attachment_url as gattach');

		$result = $this->db->get();

		return $result;

	}//End of getCategories Function


	function getCategoriesforurl()
	{
		$this->db->from('categories');
		$this->db->join('groups', 'groups.id = categories.group_id', 'left');

		$this->db->select('categories.id,categories.group_id,categories.category_name,groups.group_name, categories.description, categories.attachment_url,categories.attachment_name,categories.page_title, categories.meta_keywords, categories.meta_description, categories.is_active, categories.created, categories.modified,groups.attachment_url as gattach');

		$result = $this->db->get();
		return $result;
	}

	function getCategory($conditions = array(), $fields = '', $like = array(), $limit = array(), $orderby = array())
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

		$this->db->from('categories');
		$this->db->join('groups', 'groups.id = categories.group_id', 'left');
		//Check For Fields	 
		if ($fields != '')
			$this->db->select($fields);
		else
			$this->db->select('categories.id,categories.group_id,categories.category_name,groups.group_name, categories.description, categories.page_title, categories.meta_keywords, categories.meta_description, categories.is_active, categories.created, categories.modified, categories.attachment_url, categories.attachment_name');

		$result = $this->db->get();
		return $result;

	}//End of getCategories Function

	// --------------------------------------------------------------------

	/**
	 * Get Jobs
	 *
	 * @access    private
	 * @param    array    conditions to fetch data
	 * @return    object    object with result set
	 */
	function getJobs($conditions = [], $fields = '', $like = [], $limit = [], $orderby = [])
	{
		//Check For Conditions
		if (is_array($conditions) and count($conditions) > 0) {
			$this->db->where($conditions);
		}

		//Check For like statement
		if (is_array($like) and count($like) > 0) {
			$this->db->like($like);
		}

		//Check For Limit
		if (is_array($limit)) {
			if (count($limit) == 1) {
				$this->db->limit($limit[0]);
			} else if (count($limit) == 2) {
				$this->db->limit($limit[0], $limit[1]);
			}
		}

        // order by additional payment options
        $this->db->order_by('ifnull(jobs.is_urgent,0) DESC, ifnull(jobs.is_feature,0) DESC');

		//Check for Order by
		if (is_array($orderby) and count($orderby) > 0) {
			$this->db->order_by($orderby[0], $orderby[1]);
		}

		$this->db->from('jobs');
		$this->db->join('users', 'users.id = jobs.creator_id', 'left');

		//Check For Fields
		if ($fields != '') {
			$this->db->select($fields);
		} else {
			$this->db->select('jobs.id,jobs.job_name,jobs.job_status,jobs.description,jobs.country,jobs.state,jobs.city,jobs.milestone,jobs.budget_min,jobs.budget_max,jobs.due_date,jobs.manual_job,jobs.creator_id,jobs.is_feature,jobs.is_urgent,jobs.is_hide_bids,jobs.created,users.user_name,jobs.enddate,jobs.employee_id,jobs.job_award_date,jobs.job_award_date,jobs.contact,jobs.salary,jobs.flag,jobs.escrow_due,users.id as userid,jobs.checkstamp,jobs.owner_rated,jobs.job_paid,jobs.is_private,jobs.private_users,users.user_rating,users.num_reviews,users.email');
		}
		$result = $this->db->get();

		return $result;
	}

	/**
	 * Get Jobs with set categories
	 *
	 * @access    private
	 * @param    array    conditions to fetch data
	 * @return    object    object with result set
	 */
	function getJobsByCategories($categories = [], $conditions = [], $fields = '', $like = [], $limit = [], $orderby = [])
	{
		//Check For Conditions
		if (is_array($conditions) and count($conditions) > 0) {
			$this->db->where($conditions);
		}

		//Check For like statement
		if (is_array($like) and count($like) > 0) {
			$this->db->like($like);
		}

		//Check For Limit
		if (is_array($limit)) {
			if (count($limit) == 1) {
				$this->db->limit($limit[0]);
			} else if (count($limit) == 2) {
				$this->db->limit($limit[0], $limit[1]);
			}
		}

        // order by additional payment options
        $this->db->order_by('ifnull(jobs.is_urgent,0) DESC, ifnull(jobs.is_feature,0) DESC');

		//Check for Order by
		if (is_array($orderby) and count($orderby) > 0) {
			$this->db->order_by($orderby[0], $orderby[1]);
		}

		$this->db->from('jobs');
		$this->db->join('users', 'users.id = jobs.creator_id', 'left');
		$this->db->join('job_categories', 'jobs.id = job_categories.job_id');
		if (is_array($categories) and count($categories) > 0) {
			$this->db->where_in('job_categories.category_id', implode(',', $categories));
		}

		//Check For Fields
		if ($fields != '') {
			$this->db->select($fields);
		} else {
			$this->db->select('jobs.id,jobs.job_name,jobs.job_status,jobs.description,jobs.country,jobs.state,jobs.city,jobs.milestone,jobs.budget_min,jobs.budget_max,jobs.due_date,jobs.manual_job,jobs.creator_id,jobs.is_feature,jobs.is_urgent,jobs.is_hide_bids,jobs.created,users.user_name,jobs.enddate,jobs.employee_id,jobs.job_award_date,jobs.job_award_date,jobs.contact,jobs.salary,jobs.flag,jobs.escrow_due,users.id as userid,jobs.checkstamp,jobs.owner_rated,jobs.job_paid,jobs.is_private,jobs.private_users,users.user_rating,users.num_reviews,users.email');
		}
		$result = $this->db->get();

		return $result;
	}

	/**
	 * Get Jobs with quote requests on them
	 *
	 * @access    private
	 * @param    array    conditions to fetch data
	 * @return    object    object with result set
	 */
	function getRequestedJobs($conditions = [], $fields = '', $like = [], $limit = [], $orderby = [])
	{
		//Check For Conditions
		if (is_array($conditions) and count($conditions) > 0) {
			$this->db->where($conditions);
		}

		//Check For like statement
		if (is_array($like) and count($like) > 0) {
			$this->db->like($like);
		}

		//Check For Limit
		if (is_array($limit)) {
			if (count($limit) == 1) {
				$this->db->limit($limit[0]);
			} else if (count($limit) == 2) {
				$this->db->limit($limit[0], $limit[1]);
			}
		}

        // order by additional payment options
        $this->db->order_by('ifnull(jobs.is_urgent,0) DESC, ifnull(jobs.is_feature,0) DESC');

		//Check for Order by
		if (is_array($orderby) and count($orderby) > 0) {
			$this->db->order_by($orderby[0], $orderby[1]);
		}

		$this->db->from('jobs');
		$this->db->join('users', 'users.id = jobs.creator_id', 'left');
		$this->db->join('quote_requests', 'quote_requests.job_id = jobs.id');

		//Check For Fields
		if ($fields != '') {
			$this->db->select($fields);
		} else {
			$this->db->select('jobs.id,jobs.job_name,jobs.job_status,jobs.description,jobs.country,jobs.state,jobs.city,jobs.budget_min,jobs.budget_max,jobs.due_date,jobs.creator_id,jobs.is_feature,jobs.is_urgent,jobs.is_hide_bids,jobs.created,users.user_name,jobs.enddate,jobs.employee_id,jobs.job_award_date,jobs.job_award_date,jobs.contact,jobs.salary,jobs.flag,jobs.escrow_due,users.id as userid,jobs.checkstamp,jobs.owner_rated,jobs.job_paid,jobs.is_private,jobs.private_users,users.user_rating,users.num_reviews,users.email');
		}
		$result = $this->db->get();

		return $result;
	}

	/**
	 * Get Jobs with set categories and quote requests on them
	 *
	 * @access    private
	 * @param    array    conditions to fetch data
	 * @return    object    object with result set
	 */
	function getRequestedJobsByCategories($categories = [], $conditions = [], $fields = '', $like = [], $limit = [], $orderby = [])
	{
		//Check For Conditions
		if (is_array($conditions) and count($conditions) > 0) {
			$this->db->where($conditions);
		}

		//Check For like statement
		if (is_array($like) and count($like) > 0) {
			$this->db->like($like);
		}

		//Check For Limit
		if (is_array($limit)) {
			if (count($limit) == 1) {
				$this->db->limit($limit[0]);
			} else if (count($limit) == 2) {
				$this->db->limit($limit[0], $limit[1]);
			}
		}

        // order by additional payment options
        $this->db->order_by('ifnull(jobs.is_urgent,0) DESC, ifnull(jobs.is_feature,0) DESC');

		//Check for Order by
		if (is_array($orderby) and count($orderby) > 0) {
			$this->db->order_by($orderby[0], $orderby[1]);
		}

		$this->db->from('jobs');
		$this->db->join('users', 'users.id = jobs.creator_id', 'left');
		$this->db->join('quote_requests', 'quote_requests.job_id = jobs.id');
		$this->db->join('job_categories', 'jobs.id = job_categories.job_id');
		if (is_array($categories) and count($categories) > 0) {
			$this->db->where_in('job_categories.category_id', implode(',', $categories));
		}

		//Check For Fields
		if ($fields != '') {
			$this->db->select($fields);
		} else {
			$this->db->select('jobs.id,jobs.job_name,jobs.job_status,jobs.description,jobs.country,jobs.state,jobs.city,jobs.milestone,jobs.budget_min,jobs.budget_max,jobs.due_date,jobs.manual_job,jobs.creator_id,jobs.is_feature,jobs.is_urgent,jobs.is_hide_bids,jobs.created,users.user_name,jobs.enddate,jobs.employee_id,jobs.job_award_date,jobs.job_award_date,jobs.contact,jobs.salary,jobs.flag,jobs.escrow_due,users.id as userid,jobs.checkstamp,jobs.owner_rated,jobs.job_paid,jobs.is_private,jobs.private_users,users.user_rating,users.num_reviews,users.email');
		}
		$result = $this->db->get();

		return $result;
	}


	function get_jobs($conditions = array(), $fields = '', $like = array(), $limit = array(), $orderby = array())
	{
		$this->db->from('jobs');
		$this->db->join('users', 'users.id = jobs.creator_id', 'left');

		$this->db->select('jobs.id,jobs.job_name,jobs.job_status,jobs.description,jobs.country,jobs.state,jobs.city,jobs.budget_min,jobs.budget_max,jobs.creator_id,jobs.is_feature,jobs.is_urgent,jobs.is_hide_bids,jobs.created,users.user_name,jobs.enddate,jobs.employee_id,jobs.job_award_date,jobs.job_award_date,jobs.contact,jobs.salary,jobs.flag,jobs.escrow_due,users.id as userid,jobs.checkstamp,jobs.owner_rated,jobs.job_paid,jobs.is_private,jobs.private_users,users.user_rating,users.num_reviews,users.email');

        // order by additional payment options
        $this->db->order_by('ifnull(jobs.is_urgent,0) DESC, ifnull(jobs.is_feature,0) DESC');

		$result = $this->db->get();

		return $result;

	}//End of getjobs Function


	// --------------------------------------------------------------------

	/**
	 * Get Projects for RSS
	 *
	 * @access    private
	 * @param    array    conditions to fetch data
	 * @return    object    object with result set
	 */
	function getRssProjects($conditions = array(), $fields = '', $like = array(), $limit = array(), $orderby = array(), $orlike = array(), $extra_where)
	{
		//Check For Conditions
		if (is_array($conditions) and count($conditions) > 0)
			$this->db->where($conditions);

		if ($extra_where != "")
			$this->db->where($extra_where);

		//Check For like statement
		if (is_array($like) and count($like) > 0)
			$this->db->like($like);

		//Check For orlike statement
		if (is_array($orlike) and count($orlike) > 0) {
			$app = '';
			foreach ($orlike as $orl) {
				if ($extra_where == "")
					$this->db->or_like('jobs.job_categories', $orl);
				else
					$this->db->like('jobs.job_categories', $orl);
			}
		}
		//echo $app;
		//exit;

		//Check For Limit	
		if (is_array($limit)) {
			if (count($limit) == 1)
				$this->db->limit($limit[0]);
			else if (count($limit) == 2)
				$this->db->limit($limit[0], $limit[1]);
		}

        // order by additional payment options
        $this->db->order_by('ifnull(jobs.is_urgent,0) DESC, ifnull(jobs.is_feature,0) DESC');

		//Check for Order by
		if (is_array($orderby) and count($orderby) > 0)
			$this->db->order_by($orderby[0], $orderby[1]);

		$this->db->from('jobs');
		$this->db->join('users', 'users.id = jobs.creator_id', 'left');
		//Check For Fields	 
		if ($fields != '')
			$this->db->select($fields);
		else
			$this->db->select('jobs.id,jobs.job_name,jobs.job_status,jobs.description,jobs.country,jobs.state,jobs.city,jobs.budget_min,jobs.budget_max,jobs.creator_id,jobs.is_feature,jobs.is_urgent,jobs.is_hide_bids,jobs.created,users.user_name,jobs.enddate,jobs.employee_id,jobs.job_award_date,users.id as userid,jobs.checkstamp,jobs.owner_rated,jobs.job_paid,users.user_rating,users.num_reviews');

		$result = $this->db->get();
		//pr($result->result());exit;
		//print_r($this->db->last_query());
		return $result;

	}//End of getjobs Function

	// --------------------------------------------------------------------

	/**
	 * Get jobs
	 *
	 * @access    private
	 * @param    array    conditions to fetch data
	 * @return    object    object with result set
	 */
	function getLatestJobs($limit = array())
	{
		//Check For Conditions
		$conditions = array('jobs.job_status' => '0', 'flag' => '0');
		$this->db->where($conditions);

		//Check For Limit	
		if (is_array($limit)) {
			if (count($limit) == 1)
				$this->db->limit($limit[0]);
			else if (count($limit) == 2)
				$this->db->limit($limit[0], $limit[1]);
		}

        // order by additional payment options
        $this->db->order_by('ifnull(jobs.is_urgent,0) DESC, ifnull(jobs.is_feature,0) DESC');

		$this->db->order_by('jobs.created', 'desc');

		$this->db->from('jobs');
		$this->db->join('users', 'users.id = jobs.creator_id', 'left');
		//Check For Fields	 
		$this->db->select('jobs.id,jobs.job_name,jobs.job_status,jobs.description,jobs.country,jobs.state,jobs.city,jobs.budget_min,jobs.budget_max,jobs.creator_id,jobs.is_feature,jobs.is_urgent,jobs.is_hide_bids,jobs.created,users.user_name,jobs.enddate,jobs.employee_id,jobs.job_award_date,jobs.job_award_date,users.id as userid,users.logo as logo,users.user_name as username,jobs.checkstamp,jobs.owner_rated,jobs.job_paid,jobs.is_private,jobs.private_users,users.user_rating,users.num_reviews');
		$this->db->limit(3);
		$result = $this->db->get();

		return $result;

	}//End of getjobs Function

	/**
	 * Update jobs
	 *
	 * @access    private
	 * @param    array    an associative array of insert values
	 * @return    void
	 */
	function updateDraftProject($updateData = array(), $conditions = array())
	{
		// pr($conditions);exit;
		if (is_array($conditions) and count($conditions) > 0)
			$this->db->where($conditions);
		else
			$this->db->where('id', $id);
		$this->db->update('draftjobs', $updateData);

	}//End of updatejobs Function
	// --------------------------------------------------------------------


	// --------------------------------------------------------------------

	/**
	 * delete jobs
	 *
	 * @access    private
	 * @param    array    an associative array of insert values
	 * @return    void
	 */
	function deleteDraftProject($conditions = array())
	{
		if (is_array($conditions) and count($conditions) > 0)
			$this->db->where($conditions);
		else
			$this->db->where('id', $id);
		$this->db->delete('draftprojects');

	}//End of deletejobs Function


	/**
	 * Get Projects
	 *
	 * @access    private
	 * @param    array    conditions to fetch data
	 * @return    object    object with result set
	 */
	function getJobsByEmployee($conditions = array(), $fields = '', $like = array(), $limit = array())
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

		$this->db->from('jobs');
		$this->db->join('users', 'users.id = jobs.employee_id', 'left');


		//Check For Fields	 
		if ($fields != '')
			$this->db->select($fields);
		else
			$this->db->select('jobs.id,jobs.job_name,jobs.job_status,jobs.description,jobs.country,jobs.state,jobs.city,jobs.budget_min,jobs.budget_max,jobs.creator_id,jobs.is_feature,jobs.is_urgent,jobs.is_hide_bids,jobs.created,users.user_name,jobs.enddate,jobs.employee_id,jobs.job_award_date,users.id as userid,jobs.checkstamp,jobs.owner_rated,jobs.job_paid,jobs.is_private,jobs.flag');

		$result = $this->db->get();
		//pr($result->result());exit;
		return $result;

	}//End of getjobs Function

	// --------------------------------------------------------------------

	/**
	 * getReviews
	 *
	 * @access    private
	 * @param    array    conditions to fetch data
	 * @return    object    object with result set
	 */
	function getReviews($conditions = array(), $fields = '', $like = array(), $limit = array())
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

		$this->db->from('reviews');
		$this->db->join('users', 'users.id = reviews.owner_id', 'inner');
		$this->db->join('jobs', 'jobs.id = reviews.job_id', 'inner');
		//Check For Fields	 
		if ($fields != '')
			$this->db->select($fields);
		else
			$this->db->select('reviews.id,users.user_name,jobs.job_name,jobs.id as jobid,jobs.created,reviews.rating,reviews.employee_id,jobs.job_status,reviews.review_time,reviews.owner_id,reviews.comments');

		$result = $this->db->get();
		//pr($result->result());exit;
		return $result;

	}//End of getReviews Function

	// --------------------------------------------------------------------


	/**
	 * Get Top employee List
	 *
	 * @access    private
	 * @param    array    conditions to fetch data
	 * @return    object    object with result set
	 */

	function topEmployees($limit = array())
	{
		$conditions = array('role_id' => '2', 'users.user_status' => '1');
		$users = $this->user_model->getUsers($conditions);

		$uarray = array();
		$i = 0;
		foreach ($users->result() as $user) {
			if ($user->user_rating != 0)
				$uarray[$user->id] = $user->user_rating * $user->num_reviews;
			$i++;
		}
		arsort($uarray);
		return $uarray;
	}//End of topEmployees Function

	// --------------------------------------------------------------------


	/**
	 * Get Top Owner List
	 *
	 * @access    private
	 * @param    array    conditions to fetch data
	 * @return    object    object with result set
	 */
	function topOwners()
	{

		$conditions = array('role_id' => '1', 'users.user_status' => '1');
		$users = $this->user_model->getUsers($conditions);

		$uarray = array();
		$i = 0;
		foreach ($users->result() as $user) {
			if ($user->user_rating != 0)
				$uarray[$user->id] = $user->user_rating * $user->num_reviews;
			$i++;
		}
		arsort($uarray);
		return $uarray;

	}//End of topOwners Function

	// --------------------------------------------------------------------


	/*?>//
	//* Get jobsLists
   // *
	//* @access	private
	//@param	nil
	// @return	object	object with result set

	function getjobslist()
	{
		$this->db->from('jobs');
	   $this->db->select('jobs.id,jobs.job_name,jobs.job_status,jobs.description,jobs.budget_min,jobs.budget_max,jobs.creator_id,jobs.is_feature,jobs.is_urgent,jobs.is_hide_bids,jobs.created,jobs.enddate,jobs.employee_id');

	   $result = $this->db->get();
	   //pr($result->result());exit;
	   return $result;

	}//End of getjobs Function

	// --------------------------------------------------------------------<?php */


	/**
	 * Get jobsLists for transfer money
	 *
	 * @access    private
	 * @param    nil
	 * @return    object    object with result set
	 */
	function getMembersJob($conditions = array())
	{
		if (count($conditions) > 0)
			$this->db->where($conditions);

		$this->db->from('jobs');
		$this->db->join('users', 'users.id = jobs.creator_id', 'inner');
		$this->db->join('bids', 'bids.job_id = jobs.id', 'inner');

		$this->db->select('jobs.id,jobs.job_name,jobs.job_status,jobs.description,jobs.country,jobs.state,jobs.city,jobs.budget_min,jobs.budget_max,jobs.creator_id,jobs.is_feature,jobs.is_urgent,jobs.is_hide_bids,jobs.created,jobs.enddate,jobs.employee_id,jobs.job_award_date,jobs.flag,jobs.contact,jobs.salary,jobs.salarytype,jobs.is_private,jobs.private_users,bids.bid_amount,bids.bid_time,bids.user_id');

		$result = $this->db->get();

		return $result;

	}

	function getMessageProjectList($user_id)
	{
		if ($user_id != '')
			$this->db->where("(messages.from_id='" . $user_id . "' or messages.to_id='" . $user_id . "')");

		$this->db->from('jobs');
		$this->db->join('messages', 'messages.job_id = jobs.id', 'inner');
		//$this->db->group_by('messages.job_id');
		$this->db->select('*');

		$result = $this->db->get();
		return $result;
	}

	// --------------------------------------------------------------------

	function getUsersproject_with($cod)
	{
		if (isset($cod)) {
			$this->db->where($cod);
		}
		$this->db->from('jobs');
		$this->db->select('jobs.id,jobs.job_name,jobs.job_status,jobs.description,jobs.country,jobs.state,jobs.city,jobs.budget_min,jobs.budget_max,jobs.creator_id,jobs.is_feature,jobs.is_urgent,jobs.is_hide_bids,jobs.created,jobs.enddate,jobs.employee_id,jobs.job_award_date,jobs.flag,jobs.contact,jobs.salary,jobs.salarytype,jobs.is_private,jobs.private_users');

        // order by additional payment options
        $this->db->order_by('ifnull(jobs.is_urgent,0) DESC, ifnull(jobs.is_feature,0) DESC');

		$result = $this->db->get();
		return $result;

	}

	/**
	 * Get user wise mail inbox
	 *
	 * @access    private
	 * @param    array    conditions to fetch data
	 * @return    object    object with result set
	 */
	function getInboxmail($conditions = array())
	{
		//Check For Conditions
		if (is_array($conditions) and count($conditions) > 0)
			$this->db->where($conditions);


		$this->db->from('jobs');


		$this->db->select('jobs.id,jobs.job_name,jobs.job_status,jobs.description,jobs.country,jobs.state,jobs.city,jobs.budget_min,jobs.budget_max,jobs.creator_id,jobs.is_feature,jobs.is_urgent,jobs.is_hide_bids,jobs.created,jobs.enddate,jobs.employee_id,jobs.job_award_date');

		$result = $this->db->get();
		//pr($result->result());exit;
		return $result;

	}//End of getjobs Function

	/**
	 * Get Bids
	 *
	 * @access    private
	 * @param    array    conditions to fetch data
	 * @return    object    object with result set
	 */
	function getQuotesproject()
	{
		//Get thebid project details for all jobs
        $this->db->select('q.id,q.job_id,q.machinery_id,q.name,q.description,q.status,q.loop,q.creator_id,q.provider_id,
                           q.amount, q.created, q.escrow_required, q.notify_lower, q.due_date'
        );
		$this->db->from('quotes q');

		$result = $this->db->get();
		return $result;

	}//End of getjobs Function

	// --------------------------------------------------------------------

	/**
	 * Get Bids
	 *
	 * @access    private
	 * @param    array    conditions to fetch data
	 * @return    object    object with result set
	 */
	function getQuotes($conditions = array(), $fields = '', $like = array(), $limit = array(), $orderby = array())
	{
		//Check For Conditions
		if (is_array($conditions) and count($conditions) > 0) {
            $this->db->where($conditions);
        }

		//Check For like statement
		if (is_array($like) and count($like) > 0) {
            $this->db->like($like);
        }

		//Check For Limit	
		if (is_array($limit)) {
			if (count($limit) == 1) {
                $this->db->limit($limit[0]);
            }
			else if (count($limit) == 2) {
                $this->db->limit($limit[0], $limit[1]);
            }
		}

		//Check for Order by
		if (is_array($orderby) and count($orderby) > 0) {
            $this->db->order_by($orderby[0], $orderby[1]);
        }

        //Check For Fields
        if ($fields != '') {
            $this->db->select($fields);
        }
        else {
            $this->db->select('quotes.id, quotes.job_id, quotes.machinery_id, quotes.name, quotes.description, quotes.status, 
                                     quotes.loop, quotes.creator_id, quotes.provider_id, quotes.amount, quotes.created, quotes.escrow_required, 
                                     quotes.notify_lower, quotes.due_date, 
                                     users.user_name, users.id as uid, users.user_rating, users.num_reviews, 
                                     jobs.is_hide_bids, jobs.creator_id, jobs.milestone, jobs.mile_notify');
        }

		$this->db->from('quotes');
		$this->db->join('users', 'users.id = quotes.creator_id', 'inner');
		$this->db->join('jobs', 'jobs.id = quotes.job_id', 'inner');

		$result = $this->db->get();

		return $result;

	}

	/**
	 * getTotalReviews
	 *
	 * @access    private
	 * @param    array    conditions to fetch data
	 * @return    object    object with result set
	 */
	function getSumReviews($conditions = array())
	{

		//Check For Conditions
		if (is_array($conditions) and count($conditions) > 0)
			$this->db->where($conditions);

		$this->db->from('reviews');

		$this->db->select_sum('rating');

		$set = $this->db->get();

		$row = $set->row();

		return $row->rating;

	}//End of getTotalReviews Function

	/**
	 * deleteBid
	 *
	 * @access    private
	 * @param    array    an associative array of insert values
	 * @return    void
	 */
	function deleteBid($conditions = array())
	{
		//Check For Conditions
		if (is_array($conditions) and count($conditions) > 0)
			$this->db->where($conditions);

		$this->db->delete('bids');
		return $this->db->affected_rows();

	}//End of deleteBid Function


	function deleteBids($id = 0, $conditions = array())
	{
		if (is_array($conditions) and count($conditions) > 0)
			$this->db->where($conditions);
		else
			$this->db->where('id', $id);
		$this->db->delete('bids');

	}//End of deletejobs Function

	// --------------------------------------------------------------------

	/**
	 * insert Reviews
	 *
	 * @access    public
	 * @param    string    the type of the flash message
	 * @param    string  flash message
	 * @return    string    flash message with proper style
	 */
	function createReview($insertData = array())
	{
		$this->db->insert('reviews', $insertData);
		return $this->db->insert_id();
	}//End of insertUserContacts Function

	// --------------------------------------------------------------------

	/**
	 * Update jobs
	 *
	 * @access    private
	 * @param    array    an associative array of insert values
	 * @return    void
	 */
	function updateJobs($id = 0, $updateData = array(), $conditions = array())
	{
		//pr($conditions);exit;
		if (is_array($conditions) and count($conditions) > 0)
			$this->db->where($conditions);
		else
			$this->db->where('id', $id);
		$this->db->update('jobs', $updateData);

	}//End of updatejobs Function


	function update_mile($id, $updateData = array())
	{


		$this->db->where('job_id', $id);
		$this->db->update('milestone', $updateData);

	}

	function reduce_amt_own($owner_id, $updateDate = array())
	{


		$this->db->where('user_id', $owner_id);
		$this->db->update('user_balance', $updateDate);

	}


	function update_mile_req($id, $updateData = array())
	{


		$this->db->where('id', $id);
		$this->db->update('milestone', $updateData);

	}

	// --------------------------------------------------------------------

	function update_mile_notify($id, $updateData)
	{
		$this->db->where('id', $id);
		$this->db->update('jobs', $updateData);
	}

	/**
	 * delete jobs
	 *
	 * @access    private
	 * @param    array    an associative array of insert values
	 * @return    void
	 */
	function deleteProjects($id = 0, $conditions = array())
	{
		if (is_array($conditions) and count($conditions) > 0)
			$this->db->where($conditions);
		else
			$this->db->where('id', $id);
		$this->db->delete('jobs');

	}//End of deletejobs Function

	// --------------------------------------------------------------------

	/**
	 * delete jobs
	 *
	 * @access    private
	 * @param    array    an associative array of insert values
	 * @return    void
	 */
	function deletedraftprojects($conditions = array())
	{
		if (is_array($conditions) and count($conditions) > 0)
			$this->db->where($conditions);
		$this->db->delete('draftjobs');

	}//End of deleteProjects Function

	// --------------------------------------------------------------------

	/**
	 * updateUsers
	 *
	 * @access    private
	 * @param    array    an associative array of insert values
	 * @return    void
	 */
	function updateUsers($id = 0, $updateData = array())
	{
		$this->db->where('id', $id);
		$this->db->update('users', $updateData);

	}//End of updateUsers Function

	// --------------------------------------------------------------------

	/**
	 * updateReviews
	 *
	 * @access    private
	 * @param    array    an associative array of insert values
	 * @return    void
	 */
	function updateReviews($id = 0, $updateData = array())
	{
		$this->db->where('id', $id);
		$this->db->update('reviews', $updateData);

	}//End of updateUsers Function

	// --------------------------------------------------------------------

	/**
	 * manageProjects
	 *
	 * @access    private
	 * @param    array    an associative array of insert values
	 * @return    void
	 */
	function manageProjects($updateData = array(), $conditions = array())
	{
		if (count($conditions) > 0)
			$this->db->where($conditions);
		$this->db->update('jobs', $updateData);

	}//End of updateUsers Function

	// --------------------------------------------------------------------

	/**
	 * insert Reviews
	 *
	 * @access    public
	 * @param    string    the type of the flash message
	 * @param    string  flash message
	 * @return    string    flash message with proper style
	 */
	function insertReport($insertData = array())
	{
		$this->db->insert('report_violation', $insertData);
	}//End of insertUserContacts Function

	/**
	 * insert Reviews
	 *
	 * @access    public
	 * @param    string    the type of the flash message
	 * @param    string  flash message
	 * @return    string    flash message with proper style
	 */
	function cr_thumb($filename = '')
	{
		$config['image_library'] = 'gd2';
		$config['source_image'] = $filename;
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = 120;
		$config['height'] = 90;

		$this->load->library('image_lib', $config);


		if (!$this->image_lib->resize()) {
			echo $this->image_lib->display_errors();
		}
	}

	// --------------------------------------------------------------------


	/**
	 * insert Reviews
	 *
	 * @access    public
	 * @param    string    the type of the flash message
	 * @param    string  flash message
	 * @return    string    flash message with proper style
	 */
	function cr_Logo($filename = '')
	{
		$config['image_library'] = 'gd2';
		$config['source_image'] = $filename;
		$config['create_thumb'] = TRUE;
		$config['maintain_ratio'] = TRUE;
		$config['raw_name'] = 'h1_logo.jpg';
		pr($filename);
		exit;
		$this->load->library('image_lib', $config);


		if (!$this->image_lib->resize()) {
			echo $this->image_lib->display_errors();
		}
	}

	// --------------------------------------------------------------------

	/**
	 *
	 * Get number of jobs added
	 * @access    private
	 * @return    favourite and blocked users list
	 */

	function getNumProjectsByMonth($mon, $year)
	{
		$query = "SELECT count(*) as cnt FROM jobs WHERE FROM_UNIXTIME(created, '%c,%Y') = '$mon,$year' ";
		$que = $this->db->query($query);

		$res = $que->row();

		return $res->cnt;
	}//End of flash_message Function

	// --------------------------------------------------------------------

	/**
	 *
	 * lowBidNotification
	 * @access    private
	 * @return    favourite and blocked users list
	 */

	function lowBidNotification($bidamt, $prjid)
	{

		$currency = $this->db->get_where('settings', array('code' => 'CURRENCY_TYPE'))->row()->string_value;
		//echo $bidamt;
		//Check For Conditions
		$conditions = array('bids.job_id' => $prjid, 'bids.lowbid_notify' => '1', 'bids.bid_amount >' => $bidamt);
		if (is_array($conditions) and count($conditions) > 0)
			$this->db->where($conditions);

		$this->db->from('bids');
		$result = $this->db->get();
		if ($result->num_rows() > 0) {
			foreach ($result->result() as $bid) {
				$user = $this->user_model->getUsers(array('users.id' => $bid->user_id), 'users.email,users.user_name');
				$userRow = $user->row();

				$project = $this->getJobs(array('jobs.id' => $bid->job_id), 'jobs.job_name');
				$projectDetails = $project->row();
				//pr($projectDetails);exit;

				//pr($userRow);exit;
				//Send Mail
				$conditionUserMail = array('email_templates.type' => 'lowbid_notify');
				$result = $this->email_model->getEmailSettings($conditionUserMail);
				$rowUserMailConent = $result->row();

				$splVars = array("!project_name" => '<a href="' . site_url('project/view/' . $bid->job_id) . '">' . $projectDetails->job_name . '</a>', "!provider_name" => $userRow->user_name, "!contact_url" => site_url('contact'), '!site_name' => $this->config->item('site_title'), '!bid_amt2' => $currency . $bid->bid_amount, '!bid_amt' => $currency . $bidamt);
				$mailSubject = strtr($rowUserMailConent->mail_subject, $splVars);
				$mailContent = strtr($rowUserMailConent->mail_body, $splVars);
				$toEmail = $userRow->email;
				$fromEmail = $this->config->item('site_admin_mail');
				//echo $mailContent;exit;
				$this->email_model->sendHtmlMail($toEmail, $fromEmail, $mailSubject, $mailContent);
				//exit;

			}
		}
		//pr($result->result());exit;
	}//End of flash_message Function

	// --------------------------------------------------------------------

	/**
	 *
	 * sendTwitter - sending message to twitter
	 * @access    private
	 * @return    true/false
	 */
	function sendTwitter($message = '', $user, $pass, $apiUrl = 'http://twitter.com/statuses/update.xml')
	{
		$curl_handle = curl_init();
		curl_setopt($curl_handle, CURLOPT_URL, "$apiUrl");
		curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl_handle, CURLOPT_POST, 1);
		curl_setopt($curl_handle, CURLOPT_POSTFIELDS, "status=$message");
		curl_setopt($curl_handle, CURLOPT_USERPWD, "$user:$pass");
		//Attempt to send
		$buffer = @curl_exec($curl_handle);
		curl_close($curl_handle);
		if (strpos($buffer, '<error>') !== false) {
			return false;
		} else {
			return true;
		}
	}//End of sendTwitter Function

	function tinyUrl($url)
	{
		$tiny = 'http://tinyurl.com/api-create.php?url=';
		return file_get_contents($tiny . urlencode(trim($url)));
	}

	/**
	 * Get Job Categories
	 *
	 * @access    private
	 * @param    array    conditions to fetch data
	 * @return    object    object with result set
	 */
	function getJobCategories($conditions = array(), $fields = '')
	{
		if (count($conditions) > 0) {
			$this->db->where($conditions);
		}
		$this->db->from('job_categories');
		$this->db->join('categories', 'job_categories.category_id = categories.id');

		if ($fields != '') {
			$this->db->select($fields);
		} else {
			$this->db->select('categories.*');
		}

		$result = $this->db->get();
		return $result;
	}

	function getMilestones($conditions = array(), $fields = '')
	{
		if (count($conditions) > 0) {
			$this->db->where($conditions);
		}
		$this->db->from('employee_milestone');

		if ($fields != '') {
			$this->db->select($fields);
		} else {
			$this->db->select('*');
		}

		$result = $this->db->get();
		return $result;
	}

	/**
	 * Get all groups/categories for user
	 *
	 * @param $user
	 * @return array
	 * @throws Exception
	 */
	function get_user_categories($user)
	{
		$this->db->select('g.id as group_id, g.group_name, c.id as category_id, c.category_name');
		$this->db->from('groups g');
		$this->db->join('categories c', 'c.group_id = g.id');
		$this->db->join('user_categories u', 'u.category_id = c.id');
		$this->db->where('u.user_id', $user);

		$res = $this->db->get();
		if (!$res)
		{
			throw_db_exception();
		}
		return $res->result_array();
	}

	/**
	 * Get all categories for user as one-dimensional array of ids
	 *
	 * @param $user
	 * @return array
	 * @throws Exception
	 */
	function get_user_category_ids($user)
	{
		$this->db->select('c.id');
		$this->db->from('groups g');
		$this->db->join('categories c', 'c.group_id = g.id');
		$this->db->join('user_categories u', 'u.category_id = c.id');
		$this->db->where('u.user_id', $user);

		$res = $this->db->get();
		if (!$res)
		{
			throw_db_exception();
		}
		$res = $res->result_array();
		$count = count($res);
		for ($i = 0; $i < $count; $i++)
		{
			$res[$i] = $res[$i]['id'];
		}
		return $res;
	}

	/**
	 * Get all groups/categories for user, with groups as separate records
	 *
	 * @param $user
	 * @param $limit
	 * @return array
	 * @throws Exception
	 */
	function get_user_categories_with_groups($user, $limit='')
	{
		$query = "SELECT group_id, IF(group_id IS NULL, 'All Projects', group_name) as group_name, category_id, category_name, IF(group_id IS NULL, NULL, category_id_concat) as category_id_concat
				    FROM (SELECT g.id AS group_id,
								 c.id AS category_id,
								 MAX(g.group_name) AS group_name,
								 GROUP_CONCAT(c.id separator ',') AS category_id_concat,
								 IF(COUNT(c.category_name) = 1, MAX(c.category_name), NULL) AS category_name
						    FROM groups AS g
						    JOIN categories AS c ON c.group_id = g.id
						    JOIN user_categories AS u ON u.category_id = c.id
						   WHERE u.user_id = $user
				   GROUP BY g.id, c.id WITH ROLLUP) AS t
				   ORDER BY group_id, category_id";

		if (is_array($limit))
		{
			switch (count($limit))
			{
				case 1:
					$query = $query.' LIMIT '.$limit[0];
					break;
				case 2:
					$query = $query.' LIMIT '.$limit[1].', '.$limit[0];
					break;
				default:
					// Fallback
			}
		}

		$res = $this->db->query($query);
		if (!$res)
		{
			throw_db_exception();
		}
		return $res->result_array();
	}

	/**
	 * Get group/category by name (for SEO)
	 *
	 * @param string $group
	 * @param string $category
	 * @return array
	 * @throws Exception
	 */
	function get_category_by_name($group = '', $category = '')
	{
		if ($group == '' and $category == '')
		{
			return [];
		}

		$this->db->select('g.id as group_id, g.group_name, c.id as category_id, c.category_name');
		$this->db->from('groups as g');
		$this->db->join('categories as c', 'g.id = c.group_id');
		if ($group != '')
		{
			$this->db->where('lower(g.group_name)', strtolower($group));
		}
		if ($category != '')
		{
			$this->db->where('lower(c.category_name)', strtolower($category));
		}

		$res = $this->db->get();
		if (!$res)
		{
			throw_db_exception();
		}
		return $res->result_array();
	}

    /**
     * Get job_status
     *
     * @access    private
     * @param    array    conditions to fetch data
     * @return    object    object with result set
     */
    function getJobStatus($conditions = array())
    {
        if (count($conditions) > 0) {
            $this->db->where($conditions);
        }

        $this->db->select('js.id, js.name');
        $result = $this->db->get('job_status js');
        return $result;

    }//End of getGroups Function
}