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
 * @package        Consultant Marketplace
 * @author        Oprocon Dev Team
 * @copyright    Copyright (c) 2015 - 2016, Oprocon (https://consultant-marketplace.com/)
 * @link        https://consultant-marketplace.com
 * @version     1.0.0
 */

class User_model extends CI_Model
{
    const ROLE_ENTREPRENEUR = 1;
    const ROLE_SUPPLIER = 2;
    const ROLE_ADMIN = 3;

    const TYPE_FIND_USER_TEAM_MEMBER = 'team_member';
    const TYPE_FIND_USER_FAVORITE_MEMBER = 'favorite_member';
    const TYPE_FIND_USER_BANNED_MEMBER = 'banned_member';
    const TYPE_FIND_USER_ENTREPRENEUR = 'enterpreneur';
    const TYPE_FIND_USER_SUPPLIER = 'supplier';

    /**
     * Constructor
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('db');
        $this->load->model('team_model');
        $this->load->model('account_model');
    }

    // --------------------------------------------------------------------

    /**
     * Set Style for the flash messages
     *
     * @access    public
     * @param    string    the type of the flash message
     * @param    string  flash message
     * @return    string    flash message with proper style
     */

    function getRoleId($role_name = '')
    {
        $conditions = array('role_name' => $role_name);
        $this->db->where($conditions);
        $this->db->select('id');
        $query = $this->db->get('roles');
        $row = $query->row();
        return $row->id;
    }//End of flash_message Function

    // --------------------------------------------------------------------

    function getRoles()
    {

        $this->db->select('id,role_name');
        $query = $this->db->get('roles');
        return $query;
    }

    // --------------------------------------------------------------------

    /**
     * create user
     *
     * @access    public
     * @param    string    the type of the flash message
     * @param    string  flash message
     * @return    string    flash message with proper style
     */
    function createUser($insertData = array())
    {
        $this->db->insert('users', $insertData);
    }//End of createUser Function

    /**
     * insert Portfolios
     *
     * @access    public
     * @param    string    the type of the flash message
     * @param    string  flash message
     * @return    string    flash message with proper style
     */
    function insertPortfolio($insertData = array())
    {
        $this->db->insert('portfolio', $insertData);
    }//End of insertUserContacts Function

    // --------------------------------------------------------------------

    /**
     * Update Portfolio
     *
     * @access    private
     * @param    array    an associative array of insert values
     * @return    void
     */
    function updatePortfolio($updateKey = array(), $updateData = array())
    {
        $this->db->update('portfolio', $updateData, $updateKey);

    }//End of updatePortfolio Function

    // --------------------------------------------------------------------

    /**
     * insert User Categorys
     *
     * @access    public
     * @param    string    the type of the flash message
     * @param    string  flash message
     * @return    string    flash message with proper style
     */
    function insertUserCategories($insertData = array())
    {
        $this->db->insert('user_categories', $insertData);
    }//End of insertUserContacts Function


    // --------------------------------------------------------------------

    /**
     * create userBalanceAccount
     *
     * @access    public
     * @param    string    the type of the flash message
     * @param    string  flash message
     * @return    string    flash message with proper style
     */
    function createUserBalance($insertBalance = array())
    {
        $this->db->insert('user_balance', $insertBalance);
    }


    function milestone($insertData = array())
    {
        $this->db->insert('milestone', $insertData);
    }

    //End of createUser Function

    // --------------------------------------------------------------------

    /**
     * Update users
     *
     * @access    private
     * @param    array    an associative array of insert values
     * @return    void
     */
    function updateUser($updateKey = array(), $updateData = array())
    {
        $this->db->update('users', $updateData, $updateKey);

    }//End of editGroup Function

    // --------------------------------------------------------------------

    /**
     * Update bans
     *
     * @access    private
     * @param    array    an associative array of insert values
     * @return    void
     */
    function updateBan($updateKey = array(), $updateData = array())
    {
        $this->db->update('bans', $updateData, $updateKey);

    }//End of editGroup Function

    /**
     * Update faq category
     *
     * @access    private
     * @param    array    an associative array of insert values
     * @return    int
     */
    function saveBan($id = 0, $updateData = array())
    {
        $updateData['ban_time'] = get_est_time();
        if ($id == 0) {
            $this->db->insert('bans', $updateData);
            $id = $this->db->insert_id();
        }
        else {
            $this->db->where('bans.id', $id);
            $this->db->update('bans', $updateData);
        }

        return $id;

    }

    // --------------------------------------------------------------------

    /**
     * Update usersCategories
     *
     * @access    private
     * @param    array    an associative array of insert values
     * @return    void
     */
    function updateCategories($updateKey = array(), $updateData1 = array())
    {
        $this->db->update('user_categories', $updateData1, $updateKey);

    }//End of editGroup Function

    /**
     * Get Userslist
     *
     * @access    private
     * @param    nil
     * @return    object    object with result set
     */
    function getUserslist($conditions = array())
    {
        if (count($conditions) > 0)
            $this->db->where($conditions);

        $this->db->from('users');
        $this->db->join('roles', 'roles.id = users.role_id', 'left');
        $this->db->join('country', 'country.id = users.country_id', 'left');

        $this->db->select('users.id,roles.role_name,users.user_name,users.name,users.role_id,country.country_name,users.message_notify,users.password,users.email,users.city,users.state,users.profile_desc,users.rate,users.job_notify,users.user_status,users.activation_key,users.created,users.first_name,users.last_name');
        $result = $this->db->get();
        return $result;

    }

    /**
     * Get Users
     *
     * @access    private
     * @param    array    conditions to fetch data
     * @return    object    object with result set
     */
    function getUsers($conditions = array(), $fields = '', $whereinconditions = array(), $order_by = array())
    {

        if (count($conditions) > 0)
            $this->db->where($conditions);

        if (count($whereinconditions) > 0) {
            foreach($whereinconditions as $key => $value) {
                $this->db->where_in($key, $value);
            }
//            $this->db->where_in('users.id', $whereinconditions);
        }

        if (count($order_by) == 2)
            $this->db->order_by($order_by[0], $order_by[1]);

        //print_r($conditions);

        $this->db->from('users');
        $this->db->join('roles', 'roles.id = users.role_id', 'left');
        $this->db->join('country', 'country.id = users.country_id', 'left');

        if ($fields != '')
            $this->db->select($fields);
        else
            $this->db->select('users.id, users.refid, users.user_name, users.first_name, users.last_name, users.name, users.company_address, users.vat_id, users.role_id, users.email, users.language, users.profile_desc, users.user_status, users.activation_key, users.country_id, country.country_name, users.state, users.city, users.zip_code, users.job_notify, users.bid_notify, users.message_notify, users.rate, users.logo, users.created, users.last_activity, users.user_rating, users.num_reviews, users.rating_hold, users.tot_rating, users.suspend_status, users.ban_status, users.team_owner, users.online, users.login_status, roles.role_name,  CONCAT(users.first_name, \' \', users.last_name) as full_name ');

        $result = $this->db->get();
        return $result;

    }

    /**
     * Get Suppliers
     *
     * @access    private
     * @param    array    conditions to fetch data
     * @return    array    object with result set
     */
    function getSuppliers($conditions = array(), $like = array(), $limit = array(), $order_by = array(), $invited_suppliers = null)
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

        //Check For Limit
        if (is_array($limit)) {
            if (count($limit) == 1)
                $this->db->limit($limit[0]);
            else if (count($limit) == 2)
                $this->db->limit($limit[0], $limit[1]);
        }

        //Check for Order by
        if (is_array($order_by) and count($order_by) > 0) {
            $this->db->order_by($order_by[0], $order_by[1]);
        }

        $invitedSuppliersArr = array();
        if (isset($invited_suppliers)) {
            foreach ($invited_suppliers as $key => $value) {
                $invitedSuppliersArr[] = $value['id'];
            }
        }

        $this->db->select(
            'u.id, u.user_name, u.first_name, u.last_name, u.name, u.email, u.profile_desc, c.country_name, ' .
            'u.logo, u.last_activity, u.user_rating, u.num_reviews, u.rating_hold, u.tot_rating, 
             concat(u.first_name, " ", u.last_name) as full_name');
        $this->db->from('users as u');
        $this->db->join('country as c', 'c.id = u.country_id', 'left');

        $this->db->where('u.role_id',2);
        $this->db->where('u.user_status',ACTIVE_USER);

        if (count($invitedSuppliersArr) > 0) {
            $this->db->where_not_in('u.id',$invitedSuppliersArr);
        }

        $result = $this->db->get();

        if (isset($result)) {
            $suppliers = $result->result_array();
        } else {
            $suppliers = [];
        }

        // Rank and rating
        $suppliers_count = count($suppliers);

        for ($i = 0; $i < $suppliers_count; $i++) {

            $suppliers[$i]['rank'] = $this->user_model->get_user_rank($suppliers[$i]['id']);
            $suppliers[$i]['all_rank'] = $this->user_model->get_user_count();
        }

        return $suppliers;

    }

    function countSuppliers($conditions = array(), $like = array(), $invited_suppliers = null)
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

        $invitedSuppliersArr = array();
        foreach ($invited_suppliers as $key => $value) {
            $invitedSuppliersArr[] = $value['id'];
        }

        $this->db->select('count(u.id) as count');
        $this->db->from('users as u');
        $this->db->join('country as c', 'c.id = u.country_id', 'left');

        $this->db->where('u.role_id',2);
        $this->db->where('u.user_status',ACTIVE_USER);

        if (count($invitedSuppliersArr) > 0) {
            $this->db->where_not_in('u.id',$invitedSuppliersArr);
        }

        $result = $this->db->get();
        return $result;
    }

    function getUsers_bal($conditions = array(), $fields = '')
    {
        if (count($conditions) > 0)
            $this->db->where($conditions);

        $this->db->from('users');
        $this->db->join('roles', 'roles.id = users.role_id', 'left');
        $this->db->join('user_balance', 'users.id = user_balance.user_id', 'left');

        if ($fields != '')
            $this->db->select($fields);
        else
            $this->db->select('users.id, roles.role_name, roles.label_color, users.user_name, users.name, users.role_id, 
	 		                   users.country_id, users.message_notify, users.password, users.email, users.city, users.state, 
	 		                   users.profile_desc, users.rate, users.job_notify, users.user_status, users.activation_key, 
	 		                   users.created, users.last_activity, users.num_reviews, users.user_rating, users.logo,
	 		                   users.rating_hold, users.tot_rating, user_balance.amount, 
	 		                   users.refid'
            );

        $result = $this->db->get();
        return $result;

    }

    function getUsers_balance($conditions = array(), $fields = '', $like = array(), $limit = array(), $orderby = array())
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


        $this->db->from('users');
        $this->db->join('roles', 'roles.id = users.role_id', 'left');
        $this->db->join('country', 'country.id = users.country_id', 'left');
        $this->db->join('user_balance', 'users.id = user_balance.user_id', 'left');

        if ($fields != '')
		{
			$this->db->select($fields);
		}
        else
		{
			$this->db->select('users.id,roles.role_name,roles.label_color,users.user_name,users.name,users.role_id,country.country_name,users.message_notify,users.password,users.email,users.city,users.state,users.profile_desc,users.rate,users.job_notify,users.user_status,users.activation_key,users.created,users.last_activity,users.num_reviews,users.user_rating,users.logo,user_balance.amount');
		}

        $result = $this->db->get();
        return $result;

    }

    function countUsers($conditions = array(), $like = array())
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

        $this->db->from('users');
        $this->db->join('roles', 'roles.id = users.role_id', 'left');
        $this->db->join('user_balance', 'users.id = user_balance.user_id', 'left');

        $this->db->select('count(users.id) as count');

        $result = $this->db->get();
        return $result;
    }

    // --------------------------------------------------------------------

    /**
     * Get Portfolio
     *
     * @access    private
     * @param    array    conditions to fetch data
     * @return    object    object with result set
     */
    function getPortfolioList($conditions = [], $fields = '', $like = [], $where_in = [], $limit = [], $orderby = [])
    {
        //Check For Conditions
        if (count($conditions) > 0) {
            $this->db->where($conditions);
        }

        //Check For like statement
        if (is_array($like) and count($like) > 0) {
            $this->db->like($like);
        }

        //Check For where ... in statement
        if (is_array($where_in) and count($where_in) > 0) {
            foreach ($where_in as $where_in_key => $where_in_value) {
                $this->db->where_in($where_in_key, $where_in_value);
            }
        }

        //Check For Limit
        if (is_array($limit)) {
            if (count($limit) == 1) {
                $this->db->limit($limit[0]);
            } else if (count($limit) == 2) {
                $this->db->limit($limit[0], $limit[1]);
            }
        }

        //Check for Order by
        if (is_array($orderby) and count($orderby) > 0) {
            $this->db->order_by($orderby[0], $orderby[1]);
        }

        $this->db->from('portfolio');
        $this->db->join('users', 'users.id = portfolio.user_id');

        if ($fields != '') {
            $this->db->select($fields);
        } else {
            $this->db->select('users.id as userid,users.user_name,portfolio.title,portfolio.id,portfolio.machine_description,portfolio.price');
        }

        $result = $this->db->get();

        return $result;
    }

    /**
     * Get Portfolio
     *
     * @access    private
     * @param    array    conditions to fetch data
     * @return    object    object with result set
     */
    function getPortfolioListByCategories($categories = [], $conditions = [], $fields = '', $like = [], $where_in = [], $limit = [], $orderby = [])
    {
        //Check For Conditions
        if (count($conditions) > 0) {
            $this->db->where($conditions);
        }

        //Check For like statement
        if (is_array($like) and count($like) > 0) {
            $this->db->like($like);
        }

        //Check For where ... in statement
        if (is_array($where_in) and count($where_in) > 0) {
            foreach ($where_in as $where_in_key => $where_in_value) {
                $this->db->where_in($where_in_key, $where_in_value);
            }
        }

        //Check For Limit
        if (is_array($limit)) {
            if (count($limit) == 1) {
                $this->db->limit($limit[0]);
            } else if (count($limit) == 2) {
                $this->db->limit($limit[0], $limit[1]);
            }
        }

        //Check for Order by
        if (is_array($orderby) and count($orderby) > 0) {
            $this->db->order_by($orderby[0], $orderby[1]);
        }

        $this->db->from('portfolio');
        $this->db->join('users', 'users.id = portfolio.user_id');
        $this->db->join('portfolio_categories', 'portfolio.id = portfolio_categories.portfolio_id');
        if (is_array($categories) and count($categories) > 0) {
            $this->db->where_in('portfolio_categories.category_id', $categories);
        }

        if ($fields != '') {
            $this->db->select($fields);
        } else {
            $this->db->select('users.id as userid,users.user_name,portfolio.title,portfolio.id,portfolio.machine_description,portfolio.main_img,portfolio.attachment1,portfolio.characteristics,portfolio.value,portfolio.remarks,portfolio.attachment2,portfolio.price');
        }

        $result = $this->db->get();

        return $result;
    }

    function getPortfolio($conditions = [], $fields = '', $like = [], $where_in = [], $limit = [], $orderby = [])
    {
        //Check For Conditions
        if (count($conditions) > 0) {
            $this->db->where($conditions);
        }

        //Check For like statement
        if (is_array($like) and count($like) > 0) {
            $this->db->like($like);
        }

        //Check For where ... in statement
        if (is_array($where_in) and count($where_in) > 0) {
            foreach ($where_in as $where_in_key => $where_in_value) {
                $this->db->where_in($where_in_key, $where_in_value);
            }
        }

        //Check For Limit
        if (is_array($limit)) {
            if (count($limit) == 1) {
                $this->db->limit($limit[0]);
            } else if (count($limit) == 2) {
                $this->db->limit($limit[0], $limit[1]);
            }
        }

        //Check for Order by
        if (is_array($orderby) and count($orderby) > 0) {
            $this->db->order_by($orderby[0], $orderby[1]);
        }

        $this->db->from('portfolio');
        $this->db->join('users', 'users.id = portfolio.user_id');
        $this->db->join('portfolio_uploads', 'portfolio_uploads.portfolio_id = portfolio.id', 'left');

        if ($fields != '') {
            $this->db->select($fields);
        } else {
            $this->db->select('users.id as userid,users.user_name,portfolio.title,portfolio.price,portfolio.id,portfolio.machine_description,portfolio_uploads.name,portfolio_uploads.ori_name,portfolio_uploads.date,portfolio_uploads.ext,portfolio_uploads.filesize,portfolio_uploads.description');
        }

        $result = $this->db->get();
        return $result;
    }

    function getPortfolioByCategories($categories = [], $conditions = [], $fields = '', $like = [], $where_in = [], $limit = [], $orderby = [])
    {
        //Check For Conditions
        if (count($conditions) > 0) {
            $this->db->where($conditions);
        }

        //Check For like statement
        if (is_array($like) and count($like) > 0) {
            $this->db->like($like);
        }

        //Check For where ... in statement
        if (is_array($where_in) and count($where_in) > 0) {
            foreach ($where_in as $where_in_key => $where_in_value) {
                $this->db->where_in($where_in_key, $where_in_value);
            }
        }

        //Check For Limit
        if (is_array($limit)) {
            if (count($limit) == 1) {
                $this->db->limit($limit[0]);
            } else if (count($limit) == 2) {
                $this->db->limit($limit[0], $limit[1]);
            }
        }

        //Check for Order by
        if (is_array($orderby) and count($orderby) > 0) {
            $this->db->order_by($orderby[0], $orderby[1]);
        }

        $this->db->from('portfolio');
        $this->db->join('users', 'users.id = portfolio.user_id');
        $this->db->join('portfolio_uploads', 'portfolio_uploads.portfolio_id = portfolio.id', 'left');
        $this->db->join('portfolio_categories', 'portfolio.id = portfolio_categories.portfolio_id');
        if (is_array($categories) and count($categories) > 0) {
            $this->db->where_in('portfolio_categories.category_id', $categories);
        }

        if ($fields != '') {
            $this->db->select($fields);
        } else {
            $this->db->select('users.id as userid,users.user_name,portfolio.title,portfolio.price,portfolio.id,portfolio.machine_description,portfolio.main_img,portfolio.attachment1,portfolio.characteristics,portfolio.value,portfolio.remarks,portfolio.attachment2,portfolio_uploads.name,portfolio_uploads.ori_name,portfolio_uploads.date,portfolio_uploads.ext,portfolio_uploads.filesize,portfolio_uploads.description');
        }

        $result = $this->db->get();
        return $result;
    }

    function geteditPortfolio($conditions = array(), $fields = '')
    {
        if (count($conditions) > 0)
            $this->db->where($conditions);


        $this->db->from('portfolio_uploads');
        $this->db->join('portfolio', 'portfolio.id = portfolio_uploads.portfolio_id', 'right');

        //$this->db->from('portfolio');
        //$this->db->join('portfolio_uploads', 'portfolio_uploads.portfolio_id = portfolio.id','left');

        if ($fields != '')
            $this->db->select($fields);
        else
            $this->db->select('*');

        $result = $this->db->get();
        return $result;

    }

    function insertPortfolioAttachment($insertData = array())
    {
        $this->db->insert('portfolio_uploads', $insertData);
    }

    function getPortfolioAttachment($conditions = array(), $fields = '')
    {
        if (count($conditions) > 0) {
            $this->db->where($conditions);
        }
        $this->db->from('portfolio_uploads');
        if ($fields != '') {
            $this->db->select($fields);
        } else {
            $this->db->select('*');
        }
        return $this->db->get();
    }

    function deletePortfolioAttachment($id, $conditions = array())
    {
        if (count($conditions) > 0) {
            $this->db->where($conditions);
        } else {
            $this->db->where('id', $id);
            $this->db->delete('portfolio_uploads');
        }

    }
    // --------------------------------------------------------------------

    /**
     * Get Bans
     *
     * @access    private
     * @param    array    conditions to fetch data
     * @return    object    object with result set
     */
    function getBans($conditions = array(), $fields = '')
    {
        if (count($conditions) > 0) {
            $this->db->where($conditions);
        }

        $this->db->from('bans');
        $this->db->join('ban_types', 'ban_types.id = bans.ban_type_id');

        if ($fields != '')
            $this->db->select($fields);
        else
            $this->db->select('ban_types.type as ban_type, bans.ban_value, bans.id, bans.ban_time, bans.ban_type_id');

        $result = $this->db->get();
        return $result;

    }

    function getBansuser($conditions = array(), $fields = '', $like = array(), $limit = array(), $orderby = array())
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
            if (count($limit) == 1)
                $this->db->limit($limit[0]);
            else if (count($limit) == 2)
                $this->db->limit($limit[0], $limit[1]);
        }

        //Check for Order by
        if (is_array($orderby) and count($orderby) > 0) {
            $this->db->order_by($orderby[0], $orderby[1]);
        }

        $this->db->from('bans b');
        $this->db->join('ban_types bt', 'bt.id = b.ban_type_id');

        if ($fields != '')
            $this->db->select($fields);
        else
            $this->db->select('b.id, bt.type as ban_type, b.ban_value, b.ban_time, b.ban_type_id');

        $result = $this->db->get();
        return $result;

    }//End of getBans Function


    function getSuspenduser($conditions = array(), $fields = '', $like = array(), $limit = array(), $orderby = array())
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


        $this->db->from('suspend');

        if ($fields != '')
            $this->db->select($fields);
        else
            $this->db->select('suspend.suspend_type,suspend.suspend_value,suspend.id');

        $result = $this->db->get();
        return $result;

    }//End of getBans Function

    function getSuspend($conditions = array(), $fields = '')
    {
        if (count($conditions) > 0)
            $this->db->where($conditions);


        $this->db->from('suspend');

        if ($fields != '')
            $this->db->select($fields);
        else
            $this->db->select('suspend.suspend_type,suspend.suspend_value,suspend.id');

        $result = $this->db->get();
        return $result;

    }//End of getBans Function

    //---------------------------------------------------------------------------------------------------------------//

    /**
     * Get User Categories
     *
     * @access    private
     * @param    array    conditions to fetch data
     * @return    object    object with result set
     */
    function getUserCategories($conditions = array(), $fields = '')
    {
        if (count($conditions) > 0) {
            $this->db->where($conditions);
        }
        $this->db->from('user_categories');
        $this->db->join('categories', 'user_categories.category_id = categories.id');

        if ($fields != '') {
            $this->db->select($fields);
        } else {
            $this->db->select('categories.*');
        }

        $result = $this->db->get();
        return $result;
    }

    //---------------------------------------------------------------------------------------------------------------//

    /**
     * Get User Categories
     *
     * @access    private
     * @param    array    conditions to fetch data
     * @return    object    object with result set
     */
    function getUsersWithCategories($conditions = array(), $fields = '')
    {
        if (count($conditions) > 0)
            $this->db->where($conditions);

        $this->db->from('users');
        $this->db->join('user_categories', 'user_categories.user_id = users.id', 'left');

        if ($fields != '')
            $this->db->select($fields);
        else
            $this->db->select('users.id,users.email,user_categories.user_categories,users.user_name');

        $result = $this->db->get();
        return $result;

    }//End of getUserContacts Function

    /**
     * Loads userslist for transfer money
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function userProjectdata($conditions = array())
    {
        if (count($conditions) > 0)
            $this->db->where($conditions);

        $this->db->select('users.id,users.user_name,users.role_id');
        $result = $this->db->get('users');
        return $result;

    } //Function logout End

    /**
     * delete portfolios
     *
     * @access    private
     * @param    array    an associative array of delete values
     * @return    void
     */
    function deletePortfolio($conditions = array())
    {
        if (count($conditions) > 0)
            $this->db->where($conditions);
        $this->db->delete('portfolio');

    }//End of editGroup Function

    // --------------------------------------------------------------------

    /**
     * delete ban list
     *
     * @access    private
     * @param    array    an associative array of delete values
     * @return    void
     */
    function deleteBan($id = 0, $conditions = array())
    {
        if (count($conditions) > 0)
            $this->db->where($conditions);
        else
            $this->db->where('id', $id);
        $this->db->delete('bans');

    }//End of deleteBan Function

    function deleteSuspend($id = 0, $conditions = array())
    {
        if (count($conditions) > 0)
            $this->db->where($conditions);
        else
            $this->db->where('id', $id);
        $this->db->delete('suspend');

    }//End of deleteBan Function
    // --------------------------------------------------------------------

    /**
     * delete user
     *
     * @access    private
     * @param    array    an associative array of delete values
     * @return    void
     */
    function deleteUser($id = 0, $conditions = array())
    {
        if (count($conditions) > 0)
            $this->db->where($conditions);
        else
            $this->db->where('id', $id);
        $this->db->delete('users');
    }//End of editGroup Function


    function deleteBookmark($id = 0, $conditions = array())
    {
        if (count($conditions) > 0)
            $this->db->where($conditions);
        else
            $this->db->where('id', $id);
        $this->db->delete('bookmark');
    }//End of editGroup Function

    function deleteFile($id = 0, $conditions = array())
    {
        if (count($conditions) > 0)
            $this->db->where($conditions);
        else
            $this->db->where('id', $id);
        $this->db->delete('files');
    }//End of editGroup Function

    function deleteBalance($id = 0, $conditions = array())
    {
        if (count($conditions) > 0)
            $this->db->where($conditions);
        else
            $this->db->where('id', $id);
        $this->db->delete('user_balance');
    }//End of editGroup Function

    function deleteCategory($id = 0, $conditions = array())
    {
        if (count($conditions) > 0)
            $this->db->where($conditions);
        else
            $this->db->where('id', $id);
        $this->db->delete('user_categories');
    }//End of editGroup Function

    function deleteContact($id = 0, $conditions = array())
    {
        if (count($conditions) > 0)
            $this->db->where($conditions);
        else
            $this->db->where('id', $id);
        $this->db->delete('user_contacts');
    }//End of editGroup Function

    function deleteSubscription($id = 0, $conditions = array())
    {
        if (count($conditions) > 0)
            $this->db->where($conditions);
        else
            $this->db->where('id', $id);
        $this->db->delete('subscriptionuser');
    }//End of deleteSubscription Function

    function deleteUserlist($id = 0, $conditions = array())
    {
        if (count($conditions) > 0)
            $this->db->where($conditions);
        else
            $this->db->where('id', $id);
        $this->db->delete('user_list');
    }//End of editGroup Function
    // --------------------------------------------------------------------

    /**
     * create ban
     *
     * @access    public
     * @param    string    the type of the flash message
     * @param    string  flash message
     * @return    string    flash message with proper style
     */
    function insertBan($insertData = array())
    {
        $this->db->insert('bans', $insertData);
    }//End of createUser Function

    // --------------------------------------------------------------------

    /**
     *
     * Get the favourite and blocked users list from user_list atable
     * @access    private
     * @return    favourite and blocked users list
     */

    function getNumUsersByMonth($mon, $year, $rid)
    {
        $query = "SELECT count(*) as cnt FROM users WHERE role_id = $rid AND FROM_UNIXTIME(created, '%c,%Y') = '$mon,$year' ";
        $que = $this->db->query($query);

        $res = $que->row();

        return $res->cnt;
    }//End of flash_message Function

    function getUsersfromusername($condition = '')
    {

        $query = 'SELECT * FROM `users` WHERE ' . $condition;
        //$this->db->where($condition);
        //$this->db->select('id,email,user_name');
        //$this->db->from('users');
        $result = $this->db->query($query);
        return ($result);
    }


    function insertMsg($insertData = array())
    {
        $this->db->insert('chat_messages', $insertData);
    }


    public function getUnreadChatMsg($id, $from)
    {
        $count = $this->db->where('to', $id)
            ->where('from', $from)
            ->where('is_read', '0')
            ->count_all_results('chat_messages');
        return $count;
    }

    public function conversation($user, $chatbuddy, $limit = 5)
    {
        $this->db->where('from', $user);
        $this->db->where('to', $chatbuddy);
        $this->db->or_where('from', $chatbuddy);
        $this->db->where('to', $user);
        $this->db->order_by('id', 'desc');
        $messages = $this->db->get('chat_messages', $limit);

        $this->db->where('to', $user)->where('from', $chatbuddy)->update('chat_messages', array('is_read' => '1'));
        return $messages->result();
    }

    public function thread_len($user, $chatbuddy)
    {
        $this->db->where('from', $user);
        $this->db->where('to', $chatbuddy);
        $this->db->or_where('from', $chatbuddy);
        $this->db->where('to', $user);
        $this->db->order_by('id', 'desc');
        $messages = $this->db->count_all_results('chat_messages');
        return $messages;
    }

    public function insertChatMsg($insertData = array())
    {
        $this->db->insert('chat_messages', $insertData);
        return $this->db->insert_id();
    }

    public function getNewInsertMsg($msgId)
    {
        $this->db->where('id', $msgId);
        $this->db->from('chat_messages');

        $this->db->select('id,from,to,message,is_read,time');
        $messages = $this->db->get();

        return $messages;
    }

    public function getChatLastSeen_by($userId)
    {
        $this->db->where('user_id', $userId);
        $this->db->from('chat_last_seen');

        $this->db->select('id,user_id,message_id');
        $lastone = $this->db->get();

        return $lastone;
    }

    public function latest_Chatmessage($user, $last_seen)
    {
        $message = $this->db->where('to', $user)
            ->where('id  > ', $last_seen)
            ->order_by('time', 'desc')
            ->get('chat_messages', 1);

        if ($message->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function ChatUnread($user)
    {
        $messages = $this->db->where('to', $user)
            ->where('is_read', '0')
            ->order_by('time', 'asc')
            ->get('chat_messages');

        return $messages->result();
    }

    public function updateChat_lastSeen($user = 0)
    {
        $last_msg = $this->db->where('to', $user)->order_by('time', 'desc')->get('chat_messages', 1)->row();
        $msg = !empty($last_msg) ? $last_msg->id : 0;

        $record = $this->db->where('user_id', $user)->get('chat_last_seen');

        $details = array('user_id' => $user, 'message_id' => $msg);
        if (empty($record)) {
            $this->db->insert('chat_last_seen', $details);
        } else {
            $updateKey = array('user_id' => $user);
            $this->db->update('chat_last_seen', $details, $updateKey);
        }
    }

    public function mark_readChatMsg()
    {
        $id = $this->input->post('id');
        $this->db->where('id', $id)->update('chat_messages', array('is_read' => '1'));
    }

    /* chat igniter end */

    /**
     * create user
     *
     * @access    public
     * @param    string    the type of the flash message
     * @param    string  flash message
     * @return    string    flash message with proper style
     */

    /**
     * Sets users last activity time
     *
     * @param $user_id
     */
    function set_last_activity($user_id)
    {
        $this->db->update('users', ['last_activity' => get_est_time()], ['id' => $user_id]);
        //$q = $this->db->last_query();
    }

    /**
     * Checks if user is online
     *
     * @param $user_id
     * @return bool
     */
    function is_online($user_id)
    {
        $this->db->select('last_activity');
        $this->db->from('users');
        $this->db->where('id', $user_id);
        $res = $this->db->get()->row();
        if (isset($res)) {
            $time = get_est_time();
            $diff = $time - $res->last_activity;
            return ($diff < MAX_USER_INACTIVE_TIME); /* 30 seconds */
        } else {
            return FALSE;
        }
    }

    /**
     * Count online users
     *
     * @param $role_id
     * @return
     */
    function count_online_users($role_name = null)
    {
        $time = get_est_time();

        $this->db->select('count(*) as count_online_users');
        $this->db->from('users');
        $this->db->join('roles', 'roles.id = users.role_id', 'inner');

        if (isset($role_name)) {
            $this->db->where('roles.role_name', $role_name);
        }
        $this->db->where($time." - last_activity < ", MAX_USER_INACTIVE_TIME, FALSE);

        $res = $this->db->get();

        return $res;
    }

    /**
     * Get user name
     *
     * @param $user_id
     * @return string
     */
    function get_name($user_id)
    {
        $this->db->select("IF(first_name != '' OR last_name != '', concat(first_name, ' ', last_name), user_name) as name");
        $this->db->from('users');
        $this->db->where('id', $user_id);
        $res = $this->db->get()->row();
        if (isset($res)) {
            return $res->name;
        } else {
            return '';
        }
    }

    /**
     * Get path to user logo
     *
     * @param $user_id
     * @return string
     */
    function get_logo($user_id)
    {
        $this->load->model('file_model');
        $this->db->select('logo');
        $this->db->from('users');
        $this->db->where('id', $user_id);
        $res = $this->db->get()->row();
        if (isset($res)) {
            return $this->file_model->get_user_logo_path($user_id, $res->logo);
        } else {
            return '';
        }
    }

    /**
     * Update user data
     *
     * @param $data
     */
    function update_user($data)
    {
        $this->load->model('file_model');

        // Open transaction
        $this->db->trans_start();

        // Categories
        $this->db->where('user_id', $data['id']);
        $this->db->delete('user_categories');
        if (array_key_exists('categories', $data)) {
            foreach ($data['categories'] as $category) {
                if ($category != '') {
                    $user_categories = [
                        'user_id' => $data['id'],
                        'category_id' => $category
                    ];
                    $this->db->insert('user_categories', $user_categories);
                }
            }
            unset($data['categories']);
        }

        // Logo
        // Check if logo had changed, i.e. file with set name does not exist
        $logo = $this->file_model->get_user_logo_path($data['id'], $data['logo']);
        if ($logo == '' or $logo == STANDARD_LOGO) {
            $this->file_model->copy_logo_from_path($data['id'], $data['img_logo'], $data['logo']);
        }
        unset($data['img_logo']);

        // Update
        $this->db->update('users', $data, ['id' => $data['id']]);

        // Finalize
        $this->db->trans_complete();
    }

    /**
     * Get rating categories
     *
     * @param $role
     * @return array
     */
    function get_rating_categories($role)
    {
        $this->db->select('*');
        $this->db->from('rating_categories');
        $this->db->where('role_id', $role);
        return $this->db->get()->result_array();
    }

    /**
     * Get user rank by rating
     *
     * @param $user
     * @return int
     */
    function get_user_rank($user)
    {
        $res = $this->db->query('SELECT rank
							       FROM (SELECT u.id, @curRank := @curRank + 1 AS rank 
							               FROM users as u, (SELECT @curRank := 0) as r 
							              ORDER BY u.user_rating desc) as t
						          WHERE id = ?', $user)->row();

        if (isset($res)) {
            return $res->rank;
        } else {
            return NULL;
        }
    }

    /**
     * Get count of all users
     *
     * @return int
     */
    function get_user_count()
    {
        $this->db->select('count(*) as cnt');
        $this->db->from('users');
        $res = $this->db->get()->row();
        if (isset($res)) {
            return $res->cnt;
        } else {
            return 0;
        }
    }

    /**
     * Get average user rating
     *
     * @param $user
     * @param $category
     * @return float
     */
    function get_user_rating($user, $category = '')
    {
        $this->db->select('IFNULL(AVG(r.rating), 0) AS rating');
        $this->db->from('ratings as r');
        $this->db->join('reviews AS rv', 'r.review_id = rv.id', 'inner');
        $this->db->join('reviews as rv1',
                        'rv.reviewer_id = rv1.reviewee_id and rv.reviewee_id = rv1.reviewer_id and rv.job_id = rv1.job_id',
                        'inner');

        $this->db->where('r.user_id', $user);
        if ($category != '') {
            $this->db->where('r.rating_category_id', $category);
        }
        $res = $this->db->get()->row();
        if (isset($res)) {
            return $res->rating;
        } else {
            return 0;
        }
    }

    /**
     * Recalculate saved user rating for rank calculation
     *
     * @param $user
     * @throws Exception
     */
    function recalculate_user_rating($user)
    {
        $rating = $this->get_user_rating($user);
        if (!$this->db->update('users', ['user_rating' => $rating], ['id' => $user])) {
            throw_db_exception();
        }
    }

    /**
     * Get all user reviews
     *
     * @param $user
     * @param $limit
     * @return array
     */
    function get_user_reviews($user, $limit = '')
    {
        $this->db->select('rv.reviewer_id, rv.comments, AVG(rt.rating) AS rating, rv.review_time');
        $this->db->from('reviews AS rv');
        $this->db->join('reviews as rv1',
                        'rv.reviewer_id = rv1.reviewee_id and rv.reviewee_id = rv1.reviewer_id and rv.job_id = rv1.job_id',
                        'inner');
        $this->db->join('ratings AS rt', 'rt.review_id = rv.id');
        $this->db->where('rv.reviewee_id', $user);
        $this->db->group_by(['rv.reviewer_id', 'rv.comments', 'rv.review_time']);
        $this->db->order_by('review_time', 'DESC');

        if (is_array($limit)) {
            switch (count($limit)) {
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

        $res = $this->db->get()->result_array();
        $count = count($res);
        for ($i = 0; $i < $count; $i++) {
            $res[$i]['reviewer_name'] = $this->get_name($res[$i]['reviewer_id']);
            $res[$i]['reviewer_logo'] = $this->get_logo($res[$i]['reviewer_id']);
        }
        return $res;
    }

    /**
     * Get favorite members
     *
     * @param $user
     * @param $rating
     * @param $categories
     * @param $limit
     * @param $order_by
     * @return array
     * @throws Exception
     */
    function get_favorite_users($user, $rating = '', $categories = '', $limit = '', $order_by = '')
    {
        $this->db->select("u.id, IF(u.first_name != '' OR u.last_name != '', concat(u.first_name, ' ', u.last_name), u.user_name) as name, u.user_rating, u.logo");
        $this->db->from('users u');
        $this->db->join('favorite_users f', 'f.user_id = u.id');
        $this->db->where('f.owner_id', $user);
        if ($rating != '') {
            $this->db->where('u.user_rating >= ', $rating);
        }
        if (is_array($categories) and count($categories) > 0) {
            $this->db->join('user_categories as c', 'c.user_id = u.id');
            $this->db->where_in('c.category_id', $categories);
            $this->db->group_by(['u.id', 'u.first_name', 'u.last_name', 'u.user_name', 'u.user_rating', 'u.logo']);
        }

        if (is_array($limit)) {
            switch (count($limit)) {
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

        if (is_array($order_by) and count($order_by) == 2) {
            $this->db->order_by($order_by[0], $order_by[1]);
        } else {
            $this->db->order_by('f.id', 'DESC');
        }

        $res = $this->db->get();
        if (!$res) {
            throw_db_exception();
        }

        $res = $res->result_array();
        $count = count($res);
        for ($i = 0; $i < $count; $i++) {
            $res[$i]['categories'] = $this->get_user_categories($res[$i]['id']);
        }
        return $res;
    }

    /**
     * Get banned members
     *
     * @param $user
     * @param $rating
     * @param $categories
     * @param $limit
     * @param $order_by
     * @return array
     * @throws Exception
     */
    function get_banned_users($user, $rating, $categories, $limit, $order_by)
    {
        $this->db->select("u.id, IF(u.first_name != '' OR u.last_name != '', concat(u.first_name, ' ', u.last_name), u.user_name) as name, u.user_rating");
        $this->db->from('users u');
        $this->db->join('banned_users b', 'b.user_id = u.id');
        $this->db->where('b.owner_id', $user);
        if ($rating != '') {
            $this->db->where('u.user_rating >= ', $rating);
        }
        if (is_array($categories) and count($categories) > 0) {
            $this->db->join('user_categories as c', 'c.user_id = u.id');
            $this->db->where_in('c.category_id', $categories);
        }

        if (is_array($limit)) {
            switch (count($limit)) {
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

        if (is_array($order_by) and count($order_by) == 2) {
            $this->db->order_by($order_by[0], $order_by[1]);
        } else {
            $this->db->order_by('b.id', 'DESC');
        }

        $res = $this->db->get();
        if (!$res) {
            throw_db_exception();
        }

        $res = $res->result_array();
        $count = count($res);
        for ($i = 0; $i < $count; $i++) {
            $res[$i]['categories'] = $this->get_user_categories($res[$i]['id']);
        }
        return $res;
    }

    /**
     * Get single favorite user
     *
     * @param $owner
     * @param $user
     * @return array
     * @throws Exception
     */
    function get_favorite_user($owner, $user)
    {
        $this->db->select('*');
        $this->db->from('favorite_users');
        $this->db->where('owner_id', $owner);
        $this->db->where('user_id', $user);
        $res = $this->db->get();
        if (!$res) {
            throw_db_exception();
        }
        if (count($res->result_array()) > 0) {
            return $res->result_array()[0];
        } else {
            return NULL;
        }
    }

    /**
     * Get single banned user
     *
     * @param $owner
     * @param $user
     * @return array
     * @throws Exception
     */
    function get_banned_user($owner, $user)
    {
        $this->db->select('*');
        $this->db->from('banned_users');
        $this->db->where('owner_id', $owner);
        $this->db->where('user_id', $user);
        $res = $this->db->get();
        if (!$res) {
            throw_db_exception();
        }
        if (count($res->result_array()) > 0) {
            return $res->result_array()[0];
        } else {
            return NULL;
        }
    }

    /**
     * Add favorite user
     *
     * @param $owner
     * @param $user
     * @throws Exception
     */
    function add_favorite_user($owner, $user)
    {
        if (!$this->db->insert('favorite_users', ['owner_id' => $owner, 'user_id' => $user])) {
            throw_db_exception();
        }
    }

    /**
     * Add banned user
     *
     * @param $owner
     * @param $user
     * @throws Exception
     */
    function add_banned_user($owner, $user)
    {
        if (!$this->db->insert('banned_users', ['owner_id' => $owner, 'user_id' => $user])) {
            throw_db_exception();
        }

        $this->team_model->deleteTeamMemberByMyGroups($user);
    }

    /**
     * Delete favorite user
     *
     * @param $owner
     * @param $user
     * @throws Exception
     */
    function delete_favorite_user($owner, $user)
    {
        if (!$this->db->delete('favorite_users', ['owner_id' => $owner, 'user_id' => $user])) {
            throw_db_exception();
        }
    }

    /**
     * Delete banned user
     *
     * @param $owner
     * @param $user
     * @throws Exception
     */
    function delete_banned_user($owner, $user)
    {
        if (!$this->db->delete('banned_users', ['owner_id' => $owner, 'user_id' => $user])) {
            throw_db_exception();
        }
    }

    /**
     * Returns the list of all groups/categories for user
     *
     * @param $user
     * @return array
     * @throws Exception
     */
    function get_user_categories($user)
    {
        $this->db->select('g.id as group_id, g.group_name, c.id as category_id, c.category_name');
        $this->db->from('user_categories as uc');
        $this->db->join('categories as c', 'uc.category_id = c.id');
        $this->db->join('groups as g', 'c.group_id = g.id');
        $this->db->where('uc.user_id', $user);
        $this->db->order_by('g.id', 'ASC');
        $this->db->order_by('c.id', 'ASC');
        $res = $this->db->get();
        if (isset($res)) {
            return $res->result_array();
        } else {
            throw_db_exception();
        }
    }

    /**
     * Get user with given name and password
     *
     * @param $user_name
     * @param $password
     * @return object|bool
     */
    function get_user_at_login($user_name, $password)
    {
        $this->db->select('u.*, r.role_name');
        $this->db->from('users AS u');
        $this->db->join('roles AS r', 'u.role_id = r.id');
        $this->db->where('u.user_name', $user_name);
        $res = $this->db->get()->row();
        if (isset($res)) {
            if (password_verify($password, $res->password)) {
                // Unset sensitive data
                $res->password = NULL;
                $res->login_series = NULL;
                $res->login_token = NULL;
                return $res;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Log user login attempt into database
     *
     * @param string $user
     * @param int $success
     * @param int|null $failure_reason
     */
    function save_login_attempt($user, $success, $failure_reason = NULL)
    {
        $this->load->library('user_agent');

        $this->db->insert(
            'user_logins',
            [
                'user_name' => $user,
                'success' => $success,
                'time' => get_est_time(),
                'failure_reason' => $failure_reason,
                'user_agent' => $this->agent->browser() . '-' . $this->agent->version(),
                'ip' => $this->input->ip_address()
            ]
        );
    }

    /**
     * Set secure cookie for "remember me"
     *
     * @param $user_name
     * @param $expire
     */
    function add_remember_cookie($user_name, $expire)
    {
        $login_series = openssl_random_pseudo_bytes(10);
        $login_token = openssl_random_pseudo_bytes(10);

        // Save in cookies
        $this->auth_model->setUserCookie('login_series', $login_series, $expire);
        $this->auth_model->setUserCookie('login_token', $login_token, $expire);

        // Save in db
        $this->db->update('users', ['login_series' => $login_series, 'login_token' => password_hash($login_token, PASSWORD_DEFAULT)], ['user_name' => $user_name]);
    }

    /**
     * Get and check cookies for "remember me"
     *
     * @return bool
     */
    function check_remember_cookie()
    {
        $login_series = $this->auth_model->getUserCookie('login_series');
        $login_token = $this->auth_model->getUserCookie('login_token');

        // Check against database
        $this->db->select('user_name, login_token');
        $this->db->from('users');
        $this->db->where('login_series', $login_series);
        $res = $this->db->get()->row();
        if (isset($res)) {
            if (password_verify($login_token, $res->login_token)) {
                $user_name = $res->user_name;
            } else {
                $user_name = FALSE;
            }
        } else {
            $user_name = FALSE;
        }

        $this->clear_remember_cookie($user_name);

        return $user_name;
    }

    /**
     * Clear cookies for "remember me"
     *
     * @param $user_name
     */
    function clear_remember_cookie($user_name)
    {
        // Clear cookies
        $this->auth_model->clearUserCookie(['login_series', 'login_token']);

        // Clear database
        $this->db->update('users', ['login_series' => NULL, 'login_token' => NULL], ['user_name' => $user_name]);
    }

    /**
     * @param $limit
     * @param $order_by
     * @return array
     * @throws Exception
     */
    function get_failed_logins($limit = '', $order_by = '')
    {
        $this->db->select('l.*, r.name AS reason');
        $this->db->from('user_logins AS l');
        $this->db->join('login_failure_reason AS r', 'l.failure_reason = r.id', 'left');
        $this->db->where('l.success', 0);

        if (is_array($limit)) {
            switch (count($limit)) {
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

        if (is_array($order_by) and count($order_by) == 2 and $order_by[0] != '') {
            $this->db->order_by($order_by[0], $order_by[1]);
        } else {
            $this->db->order_by('l.time', 'DESC');
        }

        $res = $this->db->get();
        if (!$res) {
            throw_db_exception();
        }
        return $res->result_array();
    }

    /**
     * Contacts for sidebar/chat
     *
     * @param int $user
     * @param bool $show_support
     * @return array
     * @throws Exception
     */
    function get_contacts($user, $show_support = FALSE)
    {
        $this->load->model('file_model');
        $this->load->model('team_model');
        $this->load->helper('form');

        // Team
        $res = $this->team_model->get_team_online($user);

        // Favourites
        $favorites = $this->get_favorite_users($user);
        foreach ($favorites as $favorite) {
            if (!in_array_subitem($favorite['id'], 'id', $res) and $favorite['id'] != $user) {
                $res[] = [
                    'id' => $favorite['id'],
                    'name' => $favorite['name'],
                    'logo' => $favorite['logo'],
                    'img_logo' => $this->file_model->get_user_logo_path($favorite['id'], $favorite['logo']),
                    'is_online' => $this->is_online($favorite['id'])
                ];
            }
        }

        // Partners - projects
        $this->db->select("u.id, IF(u.first_name != '' OR u.last_name != '', CONCAT(u.first_name, ' ', u.last_name), u.user_name) AS name, u.logo");
        $this->db->from('users AS u');
        $this->db->join('jobs AS j', '(j.creator_id = u.id AND j.employee_id = ' . $user . ' OR j.creator_id = ' . $user . ' AND j.employee_id = u.id)');
        $this->db->where('j.job_status < 5');
        $partners = $this->db->get();
        if (!$partners) {
            throw_db_exception();
        }
        $partners = $partners->result_array();
        foreach ($partners as $partner) {
            if (!in_array_subitem($partner['id'], 'id', $res) and $partner['id'] != $user) {
                $res[] = [
                    'id' => $partner['id'],
                    'name' => $partner['name'],
                    'logo' => $partner['logo'],
                    'img_logo' => $this->file_model->get_user_logo_path($partner['id'], $partner['logo']),
                    'is_online' => $this->is_online($partner['id'])
                ];
            }
        }

        // Partners - quotes
        $this->db->select("u.id, IF(u.first_name != '' OR u.last_name != '', CONCAT(u.first_name, ' ', u.last_name), u.user_name) AS name, u.logo");
        $this->db->from('users AS u');
        $this->db->join('quotes AS q', '(q.creator_id = u.id AND q.provider_id = ' . $user . ' OR q.creator_id = ' . $user . ' AND q.provider_id = u.id)');
        $this->db->where('NOT EXISTS (SELECT 1 FROM jobs j WHERE j.id = q.job_id AND j.job_status in (4, 5, 6, 7))');
        $partners = $this->db->get();
        if (!$partners) {
            throw_db_exception();
        }
        $partners = $partners->result_array();
        foreach ($partners as $partner) {
            if (!in_array_subitem($partner['id'], 'id', $res) and $partner['id'] != $user) {
                $res[] = [
                    'id' => $partner['id'],
                    'name' => $partner['name'],
                    'logo' => $partner['logo'],
                    'img_logo' => $this->file_model->get_user_logo_path($partner['id'], $partner['logo']),
                    'is_online' => $this->is_online($partner['id'])
                ];
            }
        }

        // Site support
        if ($show_support) {
            $this->db->select('id, name');
            $this->db->from('users');
            $this->db->where('is_site_support', 1);
            $support = $this->db->get();
            if (!$support) {
                throw_db_exception();
            }
            $support = $support->result_array();
            foreach ($support as $support_user) {
                $res[] = [
                    'id' => $support_user['id'],
                    'name' => $support_user['name'],
                    'logo' => '',
                    'img_logo' => $this->file_model->get_user_logo_path($support_user['id'], ''),
                    'is_online' => $this->is_online($support_user['id'])
                ];
            }
        }

        return $res;
    }

    /**
     * Checks a given name exists at the users table
     * and returns possible alternatives
     * or an empty string if no alternatives can be found
     */
    function checkUsername($name)
    {
        $this->db->select('user_name');
        $this->db->from('users');
        $this->db->where("user_name REGEXP '" . $name . "[0-9]{0,2}'");
        $this->db->order_by('user_name');
        $rows = $this->db->get()->result_array();

        if (count($rows) <= 0) {
            // no rows found, return the original name
            return $name;
        } else {
            // found multiple rows
            if (strtolower($rows[0]['user_name']) != strtolower($name)) {
                return $name;
            } else {
                // else go through each number until we find a good username
                $counter = 0;
                while ($counter < count($rows)) {
                    $test = sprintf("%s%02d", $name, $counter + 1);
                    if ($rows[$counter]['user_name'] != $test) {
                        return $test;
                    }
                    $counter++;
                }
            }
        }
        return $name;
    }

    /*
     * For find user
     */
    function findUserByNameOrEmail($name, $teamLeadId, $type = self::TYPE_FIND_USER_TEAM_MEMBER)
    {
        $usersIds = [];
        $usersBannedId = $this->account_model->findUserIdOnBannedMembers((int)$teamLeadId);

        switch ($type) {
            case self::TYPE_FIND_USER_TEAM_MEMBER:
                $usersId = $this->team_model->findUserIdOnTeamLead((int)$teamLeadId);
                break;
            case self::TYPE_FIND_USER_FAVORITE_MEMBER:
                $usersId = $this->account_model->findUserIdOnFavoriteMembers((int)$teamLeadId);
                break;
            case self::TYPE_FIND_USER_BANNED_MEMBER:
                $usersId = $this->account_model->findUserIdOnBannedMembers((int)$teamLeadId);
                break;
            case self::TYPE_FIND_USER_ENTREPRENEUR:
                $usersId = [];
                break;
            case self::TYPE_FIND_USER_SUPPLIER:
                $usersId = [];
                break;
        }
        /*array merge*/
        foreach ($usersId as $userId) {
            $usersIds[$userId] = $userId;
        }
        foreach ($usersBannedId as $userId) {
            $usersIds[$userId] = $userId;
        }
        $usersIds = array_values($usersIds);
        /*end array merge*/


        $this->db->select("u.*, CONCAT(u.first_name, ' ', u.last_name) as full_name ");
        $this->db->from('users AS u');
        $this->db->where('u.first_name != ""');
        $this->db->where('u.last_name != ""');
        $this->db->where('u.id != ' . (int)$teamLeadId . '');
        if (!empty($usersIds)) {
            $this->db->where_not_in('u.id', $usersIds);
        }

        if ( $type == self::TYPE_FIND_USER_ENTREPRENEUR
             ||
             ($type == self::TYPE_FIND_USER_TEAM_MEMBER && $this->session->userdata('role_id') == self::ROLE_ENTREPRENEUR)
        )
        {
            $this->db->where('u.role_id', self::ROLE_ENTREPRENEUR);
        }

        if ( $type == self::TYPE_FIND_USER_SUPPLIER
            ||
            ($type == self::TYPE_FIND_USER_TEAM_MEMBER && $this->session->userdata('role_id') == self::ROLE_SUPPLIER)
        )
        {
            $this->db->where('u.role_id', self::ROLE_SUPPLIER);
        }

        $this->db->where('(CONCAT(u.first_name, \' \', u.last_name) LIKE \'%' . $name . '%\' OR email LIKE \'%' . $name . '%\')');
        $this->db->limit(10);
        $rows = $this->db->get()->result_array();
        $datas = [];
        foreach ($rows as $k => $r) {
            $datas[] = ['value' => $r['id'], 'label' => $r['full_name'] . ' "' . $r['email'] . '"'];
        }
        return $datas;
    }

    function countBans($conditions = array(), $like = array())
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

        $this->db->select('count(*) as count');
        $this->db->from('bans');

        $result = $this->db->get();
        return $result;
    }

    function getBanTypes()
    {
        $this->db->select('bt.id, bt.type');
        $this->db->from('ban_types bt');

        $result = $this->db->get();
        return $result;
    }

    /**
     * Get User country
     *
     * @access    private
     * @param    $user_id    integer
     * @return    object    object with result set
     */
    function getUserCountry($user_id)
    {

        $this->db->select('u.country_id');
        $this->db->from('users as u');
        $this->db->where('u.id', $user_id);

        $result = $this->db->get()->row();

        return $result;
    }
}