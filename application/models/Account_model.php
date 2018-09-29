<?php

/*
 ****************************************************************************
 ***                                                                      ***
 ***      BIDONN 1.0                                                      ***
 ***      File:  account_model.php                                        ***
 ***      Built: Mon June 14 11:20:12 2012                                ***
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

class Account_model extends CI_Model
{


    // Constructor

    function __construct()
    {

        parent::__construct();
    }//Controller End


    //-----------------------------------------

    /**
     * Get adminbalance
     *
     * @access    private
     * @param    nil
     * @return    result set
     */

    function adminBalance($condition = array())
    {
        if (isset($condition) and count($condition) > 0)
            $this->db->where($condition);

        $this->db->select_sum('amount');
        $result = $this->db->get('user_balance');
        return $result;

    }//Funciton adminBalance end
    //-----------------------------------------

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

        $this->db->select('users.id,roles.role_name,users.user_name,users.name,users.role_id,country.country_name,users.message_notify,users.password,users.email,users.city,users.state,users.profile_desc,users.rate,users.job_notify,users.user_status,users.activation_key,users.created');

        $result = $this->db->get();
        return $result;

    }//End of getUserslist Function


    // --------------------------------------------------------------------

    /**
     * Add Transaction
     *
     * @access    private
     * @param    array    an associative array of insert values
     * @return    void
     */
    function addTransaction($insertData = array())
    {
        $this->db->insert('transactions', $insertData);

    }//End of addTransaction Function

    // --------------------------------------------------------------------

    /**
     * delete Escrowrelease list
     *
     * @access    private
     * @param    array    an associative array of delete values
     * @return    void
     */
    function deleteTransaction($conditions = array())
    {
        if (count($conditions) > 0)
            $this->db->where($conditions);
        $this->db->delete('transactions');

    }//End of deleteEscrowrelease Function

    // --------------------------------------------------------------------

    /**
     * /**
     * Add escrow releaseTransaction
     *
     * @access    private
     * @param    array    an associative array of insert values
     * @return    void
     */
    function addescorwRelease($insertData = array())
    {
        $this->db->insert('escrow_release_request', $insertData);

    }//End of addTransaction Function

    // --------------------------------------------------------------------


    /**
     * delete Escrowrelease list
     *
     * @access    private
     * @param    array    an associative array of delete values
     * @return    void
     */
    function deleteEscrowrelease($conditions = array())
    {
        if (count($conditions) > 0)
            $this->db->where($conditions);
        $this->db->delete('escrow_release_request');

    }//End of deleteEscrowrelease Function

    // --------------------------------------------------------------------

    /**
     * Add escrowrelease
     *
     * @access    private
     * @param    array    an associative array of insert values
     * @return    void
     */
    function getescrowRelease($conditions = array(), $fields = '', $like = array(), $limit = array(), $order = array())
    {
        // pr($conditions);exit;
        if (count($conditions) > 0)
            $this->db->where($conditions);

        if (is_array($like) and count($like) > 0)
            $this->db->like($like);

        //Check For Limit
        if (is_array($limit)) {
            if (count($limit) == 1)
                $this->db->limit($limit[0]);
            else if (count($limit) == 2)
                $this->db->limit($limit[0], $limit[1]);
        }
        if (is_array($order) and count($order) > 0)
            $this->db->orderby($order[0], $order[1]);
        else
            $this->db->orderby('request_date', 'desc');

        $this->db->join('transactions', 'transactions.id = escrow_release_request.transaction_id', 'left');
        //Check For Fields
        if ($fields != '')
            $this->db->select($fields);
        else
            $this->db->select('escrow_release_request.id,escrow_release_request.transaction_id,escrow_release_request.status,escrow_release_request.request_date,transactions.type,transactions.sender_id,transactions.amount,transactions.reciever_id');
        $result = $this->db->get('escrow_release_request');
        return $result;
    }//End of getescrowRelease Function

    // --------------------------------------------------------------------


    /**
     * Get getallTransactions
     *
     * @access    private
     * @param    array    conditions to fetch data
     * @return    object with result set
     */
    function getallTransactions($conditions = array(), $fields = '', $like = array(), $limit = array(), $order = array())
    {
        if (count($conditions) > 0)
            $this->db->or_where($conditions);

        if (is_array($like) and count($like) > 0)
            $this->db->like($like);

        //Check For Limit
        if (is_array($limit)) {
            if (count($limit) == 1)
                $this->db->limit($limit[0]);
            else if (count($limit) == 2)
                $this->db->limit($limit[0], $limit[1]);
        }
        if (is_array($order) and count($order) > 0)
            $this->db->order_by($order[0], $order[1]);
        else
            $this->db->order_by('transactions.id', 'desc');


        //$this->db->orderby('transactions.transaction_time','desc');


        //Check For Fields
        if ($fields != '')
            $this->db->select($fields);
        else
            $this->db->select('transactions.id,transactions.type,transactions.sender_id,transactions.paypal_address,transactions.reciever_id,transactions.transaction_time,transactions.job_id,transactions.amount,transactions.status,transactions.description');
        $result = $this->db->get('transactions');
        return $result;
    }//End of getallTransactions Function


    // --------------------------------------------------------------------


    /**
     * Get getTransactions
     *
     * @access    private
     * @param    array    conditions to fetch data
     * @return    object with result set
     */
    function getTransactions($conditions = array(), $fields = '', $like = array(), $limit = array(), $order = array())
    {
        //pr($conditions);
        if (count($conditions) > 0)
            $this->db->where($conditions);

        if (is_array($like) and count($like) > 0)
            $this->db->like($like);

        //Check For Limit
        if (is_array($limit)) {
            if (count($limit) == 1)
                $this->db->limit($limit[0]);
            else if (count($limit) == 2)
                $this->db->limit($limit[0], $limit[1]);
        }
        if (is_array($order) and count($order) > 0)
            $this->db->order_by($order[0], $order[1]);
        else
            $this->db->order_by('transaction_time', 'asc');


        //Check For Fields
        if ($fields != '')
            $this->db->select($fields);
        else
            $this->db->select('transactions.id,transactions.type,transactions.paypal_address,transactions.transaction_time,transactions.job_id,transactions.update_flag,transactions.status,transactions.description');
        $result = $this->db->get('transactions');

        return $result;

    }


    /**
     * Get getTransactions_with
     *
     * @access    private
     * @param    array    conditions to fetch data
     * @return    object with result set
     */
    function getTransactions_with($conditions = array(), $fields = '', $like = array(), $limit = array(), $order = array())
    {
        //pr($conditions);
        if (count($conditions) > 0)
            $this->db->or_where($conditions);

        if (is_array($like) and count($like) > 0)
            $this->db->like($like);

        //Check For Limit
        if (is_array($limit)) {
            if (count($limit) == 1)
                $this->db->limit($limit[0]);
            else if (count($limit) == 2)
                $this->db->limit($limit[0], $limit[1]);
        }
        if (is_array($order) and count($order) > 0)
            $this->db->orderby($order[0], $order[1]);
        else
            $this->db->orderby('transaction_time', 'desc');


        //Check For Fields
        if ($fields != '')
            $this->db->select($fields);
        else
            $this->db->select('transactions.id,transactions.type,transactions.sender_id,transactions.paypal_address,transactions.reciever_id,transactions.transaction_time,transactions.job_id,transactions.amount,transactions.update_flag,transactions.status,transactions.description');
        $result = $this->db->get('transactions');

        return $result;
    }//End of getTransactions Function


    // --------------------------------------------------------------------
    /**
     * Get getBalance
     *
     * @access    private
     * @param    array    conditions to fetch data
     * @return    result
     */
    function getBalance($conditions = array())
    {
        if (count($conditions) > 0)
            $this->db->where($conditions);

        $this->db->select('user_balance.id,user_balance.user_id,user_balance.amount');
        $result = $this->db->get('user_balance');
        return $result;

    }//End of getBalance Function

    // --------------------------------------------------------------------

    /**
     * Update balance of a user
     *
     * @access    private
     * @param    array    an associative array of insert values
     * @return    void
     */
    function updateBalance($updateKey = array(), $updateData = array())
    {
        $this->db->update('user_balance', $updateData, $updateKey);

    }//End of updateBalance Function


    /**
     * add balance of a user
     *
     * @access    private
     * @param    array    an associative array of insert values
     * @return    void
     */
    function addBalance($insertData = array())
    {
        $res = $this->db->insert('user_balance', $insertData);
        pr($res);
        return $res;

    }//End of updateBalance Function


    // --------------------------------------------------------------------

    /**
     * Update Transaction
     *
     * @access    private
     * @param    array    an associative array of insert values
     * @return    void
     */
    function updateTransaction($updateKey = array(), $updateData = array())
    {
        $this->db->update('transactions', $updateData, $updateKey);

    }//End of updateTransaction Function


    /*
    * find users id, who in favorite
    */

    public function findUserIdOnFavoriteMembers($teamLead)
    {
        $datas = [];
        $this->db->select("*");
        $this->db->from('favorite_users');
        $this->db->where('owner_id', $teamLead);
        $rows = $this->db->get()->result_array();
        $datas = [];
        foreach ($rows as $k => $r) {
            $datas[(int)$r['user_id']] = (int)$r['user_id'];
        }

        return $datas;
    }

    /*
    * find users id, who in banned
    */

    public function findUserIdOnBannedMembers($teamLead)
    {
        $datas = [];
        $this->db->select("*");
        $this->db->from('banned_users');
        $this->db->where('owner_id', $teamLead);
        $rows = $this->db->get()->result_array();
        $datas = [];
        foreach ($rows as $k => $r) {
            $datas[(int)$r['user_id']] = (int)$r['user_id'];
        }

        return $datas;
    }

}
// End account_model Class

/* End of file account_model.php */
/* Location: ../application/models/account_model.php */