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

class Common_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');
        $this->load->model('page_model');
        $this->load->model('auth_model');
        $this->load->model('file_model');
    }

    /**
     * Set Style for the flash messages
     *
     * @param $type
     * @param $message
     * @return string
     */
    function flash_message($type, $message)
    {
        if ($message == '') {
            return '';
        }

        switch ($type) {
            case 'success':
                $class = 'alert-success';
                break;
            case 'error':
                $class = 'alert-danger';
                break;
            default:
                $class = 'alert-info';
        }
        $data = '<div class="alert ' . $class . '"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>' . $message . '</div>';

        return $data;
    }

    /**
     * Set page Title And Meta Tags For The Entire Site
     *
     * @return    array    page title and meta tags content
     */
    function get_head()
    {
        $data['page_title'] = $this->config->item('site_title');
        $data['meta_keywords'] = 'Consultant_marketplace, Consultancy, Consultant, Coach, Expert360, Hourlynerd, Skillbridge, Projjix ';
        $data['meta_description'] = 'Outsource your jobs to freelance programmers and designers at cheap prices. Freelancers will compete for your business. Get programming done for your site in php, mysql, xml, perl/cgi, javascript, asp, plus web design, search engine optimization, marketing, writing, job listings and so much more.';

        return $data;
    }

    /**
     * Returns the list of all countries in database
     *
     * @return array
     */
    function get_countries()
    {
        $this->db->select('*');
        $this->db->from('country');
        //$this->db->where('active', 1);
        $this->db->order_by('country_name', 'ASC');
        $res = $this->db->get();
        if (isset($res)) {
            return $res->result_array();
        } else {
            return [];
        }
    }

    /**
     * Returns country by id
     *
     * @param $id
     * @return array
     */
    function get_country($id)
    {
        $this->db->select('*');
        $this->db->from('country');
        $this->db->where('id', $id);
        $res = $this->db->get();
        if (isset($res)) {
            $res = $res->result_array();
            if (count($res) > 0) {
                return $res[0];
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    /**
     * Get get_logged_in_user
     *
     * @access    private
     * @param    array    conditions to fetch data
     * @return    object    object with result set
     */
    function get_logged_in_user()
    {
        $user = '';

        if ($this->session->userdata('role')) {
            $condition = array('users.id' => $this->session->userdata('user_id'));
            $fields = 'users.id, users.refid, users.user_name, users.first_name, users.last_name, users.name, users.company_address, users.vat_id, users.role_id, users.email, users.language, users.profile_desc, users.user_status, users.activation_key, users.country_id, country.country_name, users.state, users.city, users.zip_code, users.job_notify, users.bid_notify, users.message_notify, users.rate, users.logo, users.created, users.last_activity, users.user_rating, users.num_reviews, users.rating_hold, users.tot_rating, users.suspend_status, users.ban_status, users.team_owner, users.online, users.login_status, roles.role_name';
            $query = $this->user_model->getUsers($condition, $fields);
            if ($query->num_rows() > 0) {
                $user = $query->row();
            }
        } elseif ($this->auth_model->getUserCookie('user_name') && $this->auth_model->getUserCookie('user_password')) {
            $this->auth_model->getUserCookie('user_name');
            $this->auth_model->getUserCookie('user_password');

            $conditions = array('user_name' => $this->auth_model->getUserCookie('user_name'), 'password' => $this->auth_model->getUserCookie('user_password'), 'users.user_status' => '1');

            $query = $this->user_model->getUsers($conditions);

            //pr($query);
            if ($query->num_rows() > 0) {
                $user = $query->row();
                $this->auth_model->setUserSession($user);
            }
        }

        if (isset($user) and $user != '') {
            if ($user->first_name != '' or $user->last_name != '') {
                $user->full_name = $user->first_name . ' ' . $user->last_name;
            } else {
                $user->full_name = $user->user_name;
            }
            $categories = $this->user_model->getUserCategories(['user_categories.user_id' => $user->id])->result_array();
            $user->categories = [];
            foreach ($categories as $category) {
                $user->categories[] = $category['id'];
            }
            $user->img_logo = $this->file_model->get_user_logo_path($user->id, $user->logo);
        }

        return $user;
    }

    /**
     * Get getPages
     *
     * @access    public
     * @param    array    conditions to fetch data
     * @return    object    object with result set
     */
    function getPages()
    {
        $conditions = array('page.is_active' => 1);
        $pages = array();
        $pages['staticPages'] = $this->page_model->getPages($conditions);
        return $pages['staticPages'];
    }

    function getTableData($table = '', $conditions = array(), $fields = '', $like = array(), $limit = array(), $orderby = array(), $like1 = array(), $order = array(), $conditions1 = array())
    {
        //Check For Conditions
        if (is_array($conditions) and count($conditions) > 0)
            $this->db->where($conditions);

        //Check For Conditions
        if (is_array($conditions1) and count($conditions1) > 0)
            $this->db->or_where($conditions1);

        //Check For like statement
        if (is_array($like) and count($like) > 0)
            $this->db->like($like);

        if (is_array($like1) and count($like1) > 0)

            $this->db->or_like($like1);

        //Check For Limit
        if (is_array($limit)) {
            if (count($limit) == 1)
                $this->db->limit($limit[0]);
            else if (count($limit) == 2)
                $this->db->limit($limit[0], $limit[1]);
        }


        //Check for Order by
        if (is_array($orderby) and count($orderby) > 0)
            $this->db->order_by('id', 'desc');

        //Check for Order by
        if (is_array($order) and count($order) > 0)
            $this->db->order_by($order[0], $order[1]);

        $this->db->from($table);

        //Check For Fields
        if ($fields != '')

            $this->db->select($fields);

        else
            $this->db->select();

        $result = $this->db->get();

        //pr($result->result());
        return $result;

    }

    function deleteTableData($table = '', $conditions = array())
    {
        //Check For Conditions
        if (is_array($conditions) and count($conditions) > 0)
            $this->db->where($conditions);

        $this->db->delete($table);
        return $this->db->affected_rows();

    }

    function insertData($table = '', $insertData = array())
    {
        return $this->db->insert($table, $insertData);
    }


    function updateTableData($table = '', $id = 0, $updateData = array(), $conditions = array())
    {
        if (is_array($conditions) and count($conditions) > 0) {
            $this->db->where($conditions);
        } else {
            $this->db->where('id', $id);
        }
        $this->db->update($table, $updateData);
    }

    function save($table, $id, $insertData = array(), $updateData = array())
    {

        $this->db->where('user_id', $id);

        $query = $this->db->get($table);
        if ($query->result()) {

            $this->db->where('user_id', $id);

            $result = $this->db->update($table, $updateData);
        } else {
            if (is_null($insertData)) {
                $insertData = $updateData;
            }
            $result = $this->db->insert($table, $insertData);
        }
        return $result;
    }

    function getSubscription($conditions = array())
    {

        if (count($conditions) > 0)

            $this->db->where($conditions);

        $this->db->from('packages');

        $this->db->select('packages.id,packages.package_name,packages.description,packages.credits,packages.isactive,packages.total_days,packages.created_date ,packages.updated_date ,packages.amount');

        $result = $this->db->get();

        return $result;

    }

    function createUserSubscription($insertData)
    {
        $this->db->insert('subscriptionuser', $insertData);
    }

    function getUserSubscription($conditions = array())
    {

        if (count($conditions) > 0)

            $this->db->where($conditions);

        $this->db->from('subscriptionuser');

        $this->db->join('packages', 'subscriptionuser.package_id=packages.id', 'left');

        $this->db->select('subscriptionuser.id,subscriptionuser.user_id,subscriptionuser.package_id,subscriptionuser.valid,subscriptionuser.balance_credits,subscriptionuser.amount,subscriptionuser.created,subscriptionuser.flag,subscriptionuser.updated_date,packages.package_name');

        $result = $this->db->get();

        return $result;

    }

    function updateUserSubscription($id, $updateData = array())
    {
        $this->db->where('subscriptionuser.id', $id);
        $this->db->update('subscriptionuser', $updateData);

    }

    function updateUserSubscription_1($updateKey = array(), $updateData = array())
    {
        $this->db->update('subscriptionuser', $updateData, $updateKey);

    }
}