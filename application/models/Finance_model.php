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

class Finance_model extends CI_Model
{
    const FEE_ESCROW = 'escrow';
    const FEE_PLATFORM = 'platform';

    public $logged_in_user;

    function __construct()
    {
        parent::__construct();

        // Load helpers
        $this->load->helper('date');
        $this->load->helper('db');

        // Load models
        $this->load->model('common_model');
        $this->load->model('email_model');
        $this->load->model('file_model');
        $this->load->model('user_model');

        $this->logged_in_user = $this->common_model->get_logged_in_user();
    }

    /**
     * Get all transactions of certain type for current user
     *
     * @param $type
     * @param $limit
     * @param $order_by
     * @param $completed_only
	 * @param $project
     * @return array
     */
    function get_user_transactions($type, $limit, $order_by, $completed_only = FALSE, $project = NULL)
    {
        $account = $this->get_account($this->logged_in_user->id);
        if (!isset($account)) {
            return [];
        }

        $this->db->select("t.*, i.direction, i.amount, j.job_name, m.name as milestone_name, " .
            "IF(u.first_name != '' OR u.last_name != '', concat(u.first_name, ' ', u.last_name), u.user_name) as client_name");
        $this->db->from('transactions as t');
        $this->db->join('transaction_items as i', 'i.transaction_id = t.id');
        $this->db->join('jobs as j', 't.job_id = j.id', 'left');
        $this->db->join('milestones as m', 't.milestone_id = m.id', 'left');
        $this->db->join('users as u', (isEntrepreneur() ? 'j.employee_id' : 'j.creator_id') . ' = u.id', 'left');
        $this->db->where('i.account_id', $account->id);

        if ($completed_only) {
            $this->db->where_in('t.status', [1]);
        }
		if ($project != NULL) {
			$this->db->where_in('t.job_id', $project);
		}

        if (is_array($type)) {
            $this->db->where_in('t.type', $type);
        } else {
            $this->db->where('t.type', $type);
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

        if (!empty($order_by[0])) {
            $this->db->order_by($order_by[0], $order_by[1]);
        } else {
            $this->db->order_by('t.id', 'DESC');
        }

        $res = $this->db->get()->result_array();
        $count = count($res);
        for ($i = 0; $i < $count; $i++) {
            $res[$i]['status'] = $this->get_transaction_status($res[$i]['status']);
        }
        return $res;
    }

    /**
     * Get user account
     *
     * @param $user
     * @return object
     */
    private function get_account($user)
    {
        $this->db->select('*');
        $this->db->from('user_balance');
        $this->db->where('user_id', $user);
        $res = $this->db->get()->row();
        if (isset($res)) {
            return $res;
        } else {
            return NULL;
        }
    }

    /**
     * Get transaction status info
     *
     * @param $status
     * @return array|null
     */
    function get_transaction_status($status)
    {
        switch ($status) {
            case 0:
                return ['id' => $status, 'text' => 'Pending', 'class' => 'transaction-status-pending'];
            case 1:
                return ['id' => $status, 'text' => 'Success', 'class' => 'transaction-status-success'];
            case 2:
                return ['id' => $status, 'text' => 'Canceled', 'class' => 'transaction-status-failure'];
            default:
                return NULL;
        }
    }

    /**
     * Get all transactions for admin
     *
     * @param $id
     * @param $type
     * @param $limit
     * @param $order_by
     * @return array
     * @throws Exception
     */
    function get_all_transactions($id, $type, $limit, $order_by)
    {
        $this->load->model('user_model');

        $account_fee = $this->get_internal_account_fee();
        if (!isset($account_fee)) {
            return [];
        }

        if ($id != '') {
            $where = 'WHERE t.id = ' . $id;
        } elseif ($type != '') {
            $where = 'WHERE t.type = ' . $type;
        } else {
            $where = '';
        }

        $res = $this->db->query("SELECT t.user_transaction_id, t.user_bank_information, t.user_description, t.id, tt.name AS type, p.title AS payment_method, t.job_name, t.transaction_time, t.status,
									   CASE WHEN type = 0 THEN NULL
											WHEN type IN (1, 2) THEN MAX(user_id)
											ELSE MAX(creator_id)
										END AS sender_id,
									   CASE WHEN type IN (1, 2) THEN NULL
											WHEN type = 0 THEN MAX(user_id)
											ELSE MAX(employee_id)
										END AS receiver_id,
									   CASE WHEN type IN (0, 1) THEN SUM(amount)
											WHEN type = 2 THEN NULL
											ELSE SUM(IF(direction = 2 AND account_id != " . $account_fee->id . ", amount, NULL))
										END AS amount,
									   SUM(IF(account_id = " . $account_fee->id . ", amount, NULL)) AS fee
								  FROM (SELECT t.user_bank_information, t.user_transaction_id, t.user_description, t.id, t.type, t.payment_method, t.transaction_time, t.status, i.account_id, i.direction, i.amount, b.user_id, j.job_name, j.creator_id, j.employee_id
										  FROM transactions AS t
										  JOIN transaction_items AS i ON t.id = i.transaction_id
										  JOIN user_balance AS b ON b.id = i.account_id
										  LEFT JOIN jobs AS j ON j.id = t.job_id
										 " . $where . "
										 ORDER BY t.id ASC) AS t
								  JOIN transaction_type AS tt ON tt.id = t.type
								  LEFT JOIN payment_methods AS p ON p.id = t.payment_method
								  GROUP BY t.id, tt.name, p.title, t.job_name, t.transaction_time, t.status
								  ORDER BY " . $order_by[0] . " " . $order_by[1] . "
								  LIMIT " . $limit[1] . ", " . $limit[0]);
        if (!$res) {
            throw_db_exception();
        }

        $res = $res->result_array();
        $count = count($res);
        for ($i = 0; $i < $count; $i++) {
            if ($res[$i]['sender_id'] != NULL) {
                $res[$i]['sender_name'] = $this->user_model->getUsers(['users.id' => $res[$i]['sender_id']])->row()->user_name;
                $res[$i]['sender_balance'] = $this->get_user_balance($res[$i]['sender_id']);
            } else {
                $res[$i]['sender_name'] = '';
                $res[$i]['sender_balance'] = '';
            }
            if ($res[$i]['receiver_id'] != NULL) {
                $res[$i]['receiver_name'] = $this->user_model->getUsers(['users.id' => $res[$i]['receiver_id']])->row()->user_name;
                $res[$i]['receiver_balance'] = $this->get_user_balance($res[$i]['receiver_id']);
            } else {
                $res[$i]['receiver_name'] = '';
                $res[$i]['receiver_balance'] = '';
            }
            $res[$i]['status'] = $this->get_transaction_status($res[$i]['status']);
        }
        return $res;
    }

    /**
     * Get internal account for fees
     *
     * @return object
     */
    private function get_internal_account_fee()
    {
        $this->db->select('*');
        $this->db->from('user_balance');
        $this->db->where('internal_account_fee', 1);
        $res = $this->db->get()->row();
        if (isset($res)) {
            return $res;
        } else {
            return NULL;
        }
    }

    /**
     * Get user balance
     *
     * @param $user
     * @return int
     */
    function get_user_balance($user = '')
    {
        if ($user == '') {
            $user = $this->logged_in_user->id;
        }

        $balance = $this->get_account($user);
        if (isset($balance)) {
            return $balance->amount;
        } else {
            return 0;
        }
    }

    /**
     * Get number of all transactions for admin
     *
     * @param $id
     * @param $type
     * @return int
     * @throws Exception
     */
    function get_all_transactions_count($id, $type)
    {
        $this->db->select('count(*) AS cnt');
        $this->db->from('transactions');
        if ($id != '') {
            $this->db->where('id', $id);
        }
        if ($type != '') {
            $this->db->where('type', $type);
        }
        $res = $this->db->get();
        if (!$res) {
            throw_db_exception();
        }
        return $res->row()->cnt;
    }

    /**
     * Get deposits for admin
     *
     * @param $limit
     * @param $order_by
     * @return array
     */
    function get_deposits($limit, $order_by)
    {
        $this->db->select('t.id, t.status, tt.name AS type, p.title AS payment_method, u.id AS user_id, u.user_name, i.amount, t.transaction_time');
        $this->db->from('transactions AS t');
        $this->db->join('transaction_type AS tt', 'tt.id = t.type');
        $this->db->join('payment_methods AS p', 'p.id = t.payment_method');
        $this->db->join('transaction_items AS i', 't.id = i.transaction_id');
        $this->db->join('user_balance AS b', 'b.id = i.account_id');
        $this->db->join('users AS u', 'u.id = b.user_id');
        $this->db->where('t.type', 0);

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
            $this->db->order_by('t.transaction_time', 'DESC');
        }

        $res = $this->db->get()->result_array();
        $count = count($res);
        for ($i = 0; $i < $count; $i++) {
            $res[$i]['status'] = $this->get_transaction_status($res[$i]['status']);
        }
        return $res;
    }

    /**
     * Get escrow requests for admin
     *
     * @param $limit
     * @param $order_by
     * @return array
     */
    function get_escrow_requests($limit, $order_by)
    {
        $account = $this->get_internal_account_escrow();
        if (!isset($account)) {
            return [];
        }

        $this->db->select('t.id, t.status, tt.name AS type, u1.id AS sender_id, u1.user_name AS sender_name, u2.id AS receiver_id, u2.user_name AS receiver_name, i.amount, t.transaction_time');
        $this->db->from('transactions AS t');
        $this->db->join('transaction_type AS tt', 'tt.id = t.type');
        $this->db->join('jobs AS j', 'j.id = t.job_id');
        $this->db->join('users AS u1', 'u1.id = j.creator_id');
        $this->db->join('users AS u2', 'u2.id = j.employee_id');
        $this->db->join('transaction_items AS i', 't.id = i.transaction_id AND i.account_id = ' . $account->id);
        $this->db->where('t.type', 4);

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
            $this->db->order_by('t.transaction_time', 'DESC');
        }

        $res = $this->db->get()->result_array();
        $count = count($res);
        for ($i = 0; $i < $count; $i++) {
            $res[$i]['status'] = $this->get_transaction_status($res[$i]['status']);
        }
        return $res;
    }

    /**
     * Get internal account for escrow
     *
     * @return object
     */
    private function get_internal_account_escrow()
    {
        $this->db->select('*');
        $this->db->from('user_balance');
        $this->db->where('internal_account_escrow', 1);
        $res = $this->db->get()->row();
        if (isset($res)) {
            return $res;
        } else {
            return NULL;
        }
    }

    /**
     * Get escrow releases for admin
     *
     * @param $limit
     * @param $order_by
     * @return array
     */
    function get_escrow_release($limit, $order_by)
    {
        $account = $this->get_internal_account_escrow();
        if (!isset($account)) {
            return [];
        }

        $this->db->select('t.id, t.status, tt.name AS type, u1.id AS sender_id, u1.user_name AS sender_name, u2.id AS receiver_id, u2.user_name AS receiver_name, i.amount, t.transaction_time');
        $this->db->from('transactions AS t');
        $this->db->join('transaction_type AS tt', 'tt.id = t.type');
        $this->db->join('jobs AS j', 'j.id = t.job_id');
        $this->db->join('users AS u1', 'u1.id = j.creator_id');
        $this->db->join('users AS u2', 'u2.id = j.employee_id');
        $this->db->join('transaction_items AS i', 't.id = i.transaction_id AND i.account_id = ' . $account->id);
        $this->db->where('t.type', 5);

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
            $this->db->order_by('t.transaction_time', 'DESC');
        }

        $res = $this->db->get()->result_array();
        $count = count($res);
        for ($i = 0; $i < $count; $i++) {
            $res[$i]['status'] = $this->get_transaction_status($res[$i]['status']);
        }
        return $res;
    }

    /**
     * Get withdrawals for admin
     *
     * @param $limit
     * @param $order_by
     * @return array
     */
    function get_withdraws($limit, $order_by)
    {
        $this->db->select('t.id, t.status, tt.name AS type, p.title AS payment_method, u.id AS user_id, u.user_name, i.amount, t.transaction_time');
        $this->db->from('transactions AS t');
        $this->db->join('transaction_type AS tt', 'tt.id = t.type');
        $this->db->join('payment_methods AS p', 'p.id = t.payment_method');
        $this->db->join('transaction_items AS i', 't.id = i.transaction_id');
        $this->db->join('user_balance AS b', 'b.id = i.account_id');
        $this->db->join('users AS u', 'u.id = b.user_id');
        $this->db->where('t.type', 1);

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
            $this->db->order_by('t.transaction_time', 'DESC');
        }

        $res = $this->db->get()->result_array();
        $count = count($res);
        for ($i = 0; $i < $count; $i++) {
            $res[$i]['status'] = $this->get_transaction_status($res[$i]['status']);
        }
        return $res;
    }

    /**
     * Get amount to escrow for quote w/all milestones or for milestone, only if "force escrow" is set on quote/milestone or as global parameter
     *
     * @param $project_id
     * @param $quote_id
     * @param $quote_milestone_id
     * @param $is_required
     * @return int
     */
    function get_quote_escrow_due($project_id, $quote_id, $quote_milestone_id = '', $is_required = FALSE)
    {
        $amount = 0;

		if (!empty($this->config->item('disable_escrow'))) {
			return $amount;
		}

        $this->load->model('project_model');
        $this->load->model('quote_model');

        // Get project
        $project = $this->project_model->get_project_by_id($project_id);
        if (!isset($project)) {
            return $amount;
        }
        // Placed, not active
        if ($project['job_status'] != 3) {
            return $amount;
        }

        // Get quote
        $quote = $this->quote_model->get_quote_by_id($quote_id);
        if (!isset($quote)) {
            return $amount;
        }

        // Get quote milestone
        if ($quote_milestone_id != '' and $quote_milestone_id != NULL) {
            $quote_milestone = $this->quote_model->get_quote_milestone_by_id($quote_milestone_id);
            if (!isset($quote_milestone['id'])) {
                return $amount;
            } else {
                if (!$is_required or $quote_milestone['escrow_required'] == 1 or $this->config->item('forced_escrow') == 1) {
                    return $quote_milestone['amount'];
                } else {
                    return $amount;
                }
            }
        }

        if (!$is_required or $quote['escrow_required'] == 1 or $this->config->item('forced_escrow') == 1) {
            $amount = $quote['amount'];
        }
        // Get milestones, too
        if (!isset($quote_milestone_id) or $quote_milestone_id != '') {
            $quote_milestones = $this->quote_model->get_quote_milestones($project_id, $quote_id, $quote['creator_id']);
            foreach ($quote_milestones as $quote_milestone) {
                $amount += $this->get_quote_escrow_due($project_id, $quote_id, $quote_milestone['id'], $is_required);
            }
        }

        return $amount;
    }

    /**
     * Get escrow account for current user's projects
     *
     * @param $limit
     * @param $order_by
     * @return array
     */
    function get_escrow_account($limit, $order_by)
    {
        $escrow_account = $this->get_internal_account_escrow();
        if (!isset($escrow_account)) {
            return [];
        }

        $this->db->select("t.*, i.direction, i.amount, j.job_name, m.name as milestone_name, " .
            "IF(u.first_name != '' OR u.last_name != '', concat(u.first_name, ' ', u.last_name), u.user_name) as client_name");
        $this->db->from('transactions as t');
        $this->db->join('transaction_items as i', 'i.transaction_id = t.id');
        $this->db->join('jobs as j', 't.job_id = j.id');
        $this->db->join('milestones as m', 't.milestone_id = m.id', 'left');
        $this->db->join('users as u', 'j.employee_id = u.id', 'left');
        $this->db->where('j.creator_id', $this->logged_in_user->id);
        $this->db->where('i.account_id', $escrow_account->id);
        $this->db->where('t.type', 4);
        $this->db->where('t.status', 1);
        $this->db->where('not exists (select 1 from transactions as t1 where t1.job_id = t.job_id and t1.milestone_id = t.milestone_id ' .
            'and t1.type in (5, 6) and t1.status = 1)');

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
            $this->db->order_by('t.transaction_time', 'DESC');
        }

        $res = $this->db->get()->result_array();
        $count = count($res);
        for ($i = 0; $i < $count; $i++) {
            $res[$i]['status'] = $this->get_transaction_status($res[$i]['status']);
        }
        return $res;
    }

    /**
     * Get all escrow/platform fee rules
     *
     * @param $type
     * @return array
     * @throws Exception
     */
    function get_fees_for_chart($type)
    {
        $res = [];
        $fees = $this->get_fees($type);
        $min_amount = $fees[0]['min_amount'];
        $max_amount = $fees[count($fees) - 2]['min_amount'] * 2;

        for ($amount = $min_amount; $amount <= $max_amount; $amount *= 2) {
            $val = $this->get_fee($amount, $type);
            $res[] = [
                "x" => $amount,
                "y_percent" => ($amount == 0) ? 0 : ($val / $amount * 100),
                "y_value" => $val
            ];
        }

        return $res;
    }

    /**
     * Get all escrow/platform fee rules
     *
     * @param $type
     * @return array
     * @throws Exception
     */
    function get_fees($type)
    {
        $this->db->select('*');
        $this->db->from($type == self::FEE_ESCROW ? 'escrow_fee' : 'platform_fee');
        $this->db->order_by('(0 - min_amount) DESC'); /* nulls last */
        $res = $this->db->get();
        if (!$res) {
            throw_db_exception();
        }
        return $res->result_array();
    }

    /**
     * Calculate escrow/platform fee
     *
     * @param $amount
     * @param $type
     * @return float
     * @throws Exception
     */
    function get_fee($amount, $type)
    {
        if ($amount == 0) return 0;

		if ($type == self::FEE_ESCROW && !empty($this->config->item('disable_escrow'))) {
			return 0;
		}

        $fees = $this->get_fees($type);

        $fee = $fees[0]['min_amount'] * $fees[0]['fee_percent'] / 100;
        $count = count($fees);
        for ($i = 0; $i < $count; $i++) {
            if ($amount < $fees[$i]['min_amount'] or $fees[$i]['min_amount'] == NULL) {
                return $fee;
            } elseif ($amount < $fees[$i + 1]['min_amount'] or $fees[$i + 1]['min_amount'] == NULL) {
                return $fee + ($amount - $fees[$i]['min_amount']) * $fees[$i + 1]['fee_percent'] / 100;
            } else {
                $fee += ($fees[$i + 1]['min_amount'] - $fees[$i]['min_amount']) * $fees[$i + 1]['fee_percent'] / 100;
            }
        }
        return $fee;
    }

    /**
     * Get all invoices for user
     *
     * @param $user
     * @param $start_date
     * @param $end_date
     * @return array
     * @throws Exception
     */
    function get_invoices($user, $start_date = '', $end_date = '')
    {
        $this->load->model('project_model');

        $esc_user = $this->db->escape($user);
        $esc_start_date = $this->db->escape($start_date);
        $esc_end_date = $this->db->escape($end_date);

        $this->db->select('job_id, sum(amount) AS amount, max(billing_date) AS billing_date');
        $this->db->from('invoice');
        $this->db->where('(sender_id = ' . $esc_user . ' OR reciever_id = ' . $esc_user . ')');
        if ($start_date != '' and $end_date != '') {
            $this->db->where('billing_date BETWEEN ' . $esc_start_date . ' AND ' . $esc_end_date);
        }
        $this->db->group_by('job_id');
        $res = $this->db->get();
        if (!$res) {
            throw_db_exception();
        }

        $res = $res->result_array();
        $count = count($res);
        for ($i = 0; $i < $count; $i++) {
            $project = $this->project_model->get_project_by_id($res[$i]['job_id']);
            $res[$i]['job_name'] = $project['job_name'];
            $res[$i]['start_date'] = $project['start_date'];
            $res[$i]['enddate'] = $project['enddate'];
            $res[$i]['payment_status'] = $this->get_project_payment($res[$i]['job_id']);
        }
        return $res;
    }

    /**
     * Get payment with status for project/milestone
     *
     * @param $project_id
     * @param $milestone_id
     * @return array
     */
    function get_project_payment($project_id, $milestone_id = '')
    {
        $this->load->model('project_model');
        $result = ['amount' => 0, 'due' => 0, 'status' => '', 'class' => ''];

        // Get project
        $project = $this->project_model->get_project_by_id($project_id);
        if (!isset($project['id'])) {
            return $result;
        }
        if ($project['job_status'] < 4 or $project['job_status'] == 8) {
            return $result;
        }

        // Get milestone
        if ($milestone_id != '' and $milestone_id != NULL) {
            $milestone = $this->project_model->get_milestone_by_id($milestone_id);
            if (!isset($milestone['id'])) {
                return $result;
            }
        }

        // Project canceled
        if ($project['job_status'] == 6 or $project['job_status'] == 7) {
            $result['status'] = t('Canceled');
            $result['class'] = 'payment-status-canceled';
            return $result;
        }

        $paid = $this->get_project_payment_paid($project_id, $milestone_id);
        $due = $this->get_project_payment_due($project_id, $milestone_id);
        $escrow = $this->get_project_payment_escrow($project_id, $milestone_id);

        // Check if there are open cases
        $this->db->select('count(*) as num');
        $this->db->from('job_cases');
        $this->db->where('job_id', $project_id);
        $this->db->where('status', 1);
        $res = $this->db->get()->row();

        if (isset($res) and $res->num > 0) {
            $result['status'] = t('Dispute');
            $result['class'] = 'payment-status-dispute';
            return $result;
        }

		$result['amount'] = $paid;
        $result['due'] = $due - ($paid + $escrow);

		if ($paid >= $due + $escrow) {
			$result['status'] = t('Paid');
			$result['class'] = 'payment-status-paid';
			return $result;
		}

		if ($escrow >= $due) {
			$result['status'] = t('Escrow');
			$result['class'] = 'payment-status-escrow';
			return $result;
		}

        // Check if payment is overdue
        if (isset($milestone)) {
            $due_date = $milestone['due_date'];
        } else {
            $due_date = $project['due_date'];
        }

        if ($due_date > 0 && $due_date < get_est_time()) {
            $result['status'] = t('Overdue');
            $result['class'] = 'payment-status-overdue';
            return $result;
        }

        // Check if invoice is sent
        $invoice = $this->get_invoice($project_id, $milestone_id);
        if (count($invoice) > 0) {
            $result['status'] = t('Invoice Sent');
            $result['class'] = 'payment-status-invoice-sent';
        } else {
            $result['status'] = t('Invoice Due');
            $result['class'] = 'payment-status-invoice-due';
        }

        return $result;
    }

    /**
     * Get amount paid for project w/all milestones or for milestone, via transfer or escrow release
     *
     * @param $project_id
     * @param string $milestone_id
     * @return int
     */
    function get_project_payment_paid($project_id, $milestone_id = '')
    {
        $amount = 0;

        $this->load->model('project_model');

        // Get project
        $project = $this->project_model->get_project_by_id($project_id, false);
        if (!isset($project['id'])) {
            return $amount;
        }
        if ($project['job_status'] < 4 or $project['job_status'] == 8) {
            return $amount;
        }

        // Get milestone
        if ($milestone_id != '' and $milestone_id != NULL) {
            $milestone = $this->project_model->get_milestone_by_id($milestone_id, false);
            if (!isset($milestone['id'])) {
                return $amount;
            }
        }

        // Get receiver account
        $account = $this->get_account($project['employee_id']);
        if (!isset($account)) {
            return $amount;
        }
        // Get full payment
        $this->db->select('sum(i.amount) as amount');
        $this->db->from('transactions as t');
        $this->db->join('transaction_items as i', 'i.transaction_id = t.id');
        $this->db->where('t.job_id', $project_id);
        if ($milestone_id == '' or $milestone_id == NULL) {
            $this->db->where('t.milestone_id IS NULL');
        } else {
            $this->db->where('t.milestone_id', $milestone_id);
        }
        $this->db->where_in('t.type', [3, 5]);
        $this->db->where('t.status', 1);
        $this->db->where('i.account_id', $account->id);
        $res = $this->db->get()->row();
        if (isset($res)) {
            $amount += $res->amount;
        }
        // Get milestones, too
        if (!isset($milestone_id) or $milestone_id == '') {
            $milestones = $this->project_model->get_project_milestones($project_id);
            foreach ($milestones as $milestone) {
                $amount += $this->get_project_payment_paid($project_id, $milestone['id']);
            }
        }
        return $amount;
    }

    /**
     * Get amount to pay for project w/all milestones or for milestone
     *
     * @param $project_id
     * @param string $milestone_id
     * @return int
     */
    function get_project_payment_due($project_id, $milestone_id = '')
    {
        $amount = 0;

        $this->load->model('project_model');

        // Get project
        $project = $this->project_model->get_project_by_id($project_id, false);
        if (!isset($project['id'])) {
            return $amount;
        }
        if ($project['job_status'] < 4 or $project['job_status'] == 8) {
            return $amount;
        }

        // Get milestone
        if ($milestone_id != '' and $milestone_id != NULL) {
            $milestone = $this->project_model->get_milestone_by_id($milestone_id, false);
            if (!isset($milestone['id'])) {
                return $amount;
            } else {
                return $milestone['amount'] * ($milestone['vat_percent'] / 100 + 1);
            }
        }

        $amount = $project['budget_min'] * ($project['vat_percent'] / 100 + 1);
        // Get milestones, too
        if (!isset($milestone_id) or $milestone_id == '') {
            $milestones = $this->project_model->get_project_milestones($project_id);
            foreach ($milestones as $milestone) {
                $amount += $this->get_project_payment_due($project_id, $milestone['id']);
            }
        }

        return $amount;
    }

    /**
     * Get amount in escrow for project w/all milestones or for milestone
     *
     * @param $project_id
     * @param string $milestone_id
     * @return int
     */
    function get_project_payment_escrow($project_id, $milestone_id = '')
    {
        $amount = 0;

        $this->load->model('project_model');

        // Get project
        $project = $this->project_model->get_project_by_id($project_id, false);
        if (!isset($project['id'])) {
            return $amount;
        }
        if ($project['job_status'] < 3 or $project['job_status'] == 8) {
            return $amount;
        }

        // Get milestone
        if ($milestone_id != '' and $milestone_id != NULL) {
            $milestone = $this->project_model->get_milestone_by_id($milestone_id, false);
            if (!isset($milestone['id'])) {
                return $amount;
            }
        }

        // Get receiver account
        $account = $this->get_account($project['employee_id']);
        if (!isset($account)) {
            return $amount;
        }

        $this->db->select('sum(i.amount) as amount');
        $this->db->from('transactions as t');
        $this->db->join('transaction_items as i', 'i.transaction_id = t.id');
        $this->db->where('t.job_id', $project_id);
        if ($milestone_id == '' or $milestone_id == NULL) {
            $this->db->where('t.milestone_id IS NULL');
        } else {
            $this->db->where('t.milestone_id', $milestone_id);
        }
        $this->db->where('t.type', 4);
        $this->db->where('t.status', 1);
        $this->db->where('i.account_id', $account->id);
        $res = $this->db->get()->row();
        if (isset($res)) {
            $amount = $res->amount;
        }

        // Get milestones, too
        if (!isset($milestone_id) or $milestone_id == '') {
            $milestones = $this->project_model->get_project_milestones($project_id);
            foreach ($milestones as $milestone) {
                $amount += $this->get_project_payment_escrow($project_id, $milestone['id']);
            }
        }

        return $amount;
    }

    /**
     * Get invoice for project/milestone
     *
     * @param $job_id
     * @param $milestone_id
     * @return array
     * @throws Exception
     */
    function get_invoice($job_id, $milestone_id = '')
    {
        $this->load->model('project_model');
        $project = $this->project_model->get_project_by_id($job_id);
        if (!isset($project)) {
            throw new Exception('Project does not exist');
        }

        $this->db->select('*');
        $this->db->from('invoice');
        $this->db->where('job_id', $job_id);
        if ($milestone_id != '') {
            $this->db->where('milestone_id', $milestone_id);
        }
        $this->db->order_by('milestone_id', 'ASC');
        $res = $this->db->get();
        if (!$res) {
            throw_db_exception();
        }
        $res = $res->result_array();
        $count = count($res);
        for ($i = 0; $i < $count; $i++) {
            if ($res[$i]['milestone_id'] == NULL) {
                $res[$i]['job_name'] = $project['job_name'];
                $res[$i]['milestone_name'] = '';
                $res[$i]['description'] = $project['description'];
                $res[$i]['due_date'] = $project['due_date'];
            } else {
                $milestone = $this->project_model->get_milestone_by_id($res[$i]['milestone_id']);
                if (!isset($milestone)) {
                    throw new Exception('Milestone does not exist');
                }
                $res[$i]['job_name'] = $project['job_name'];
                $res[$i]['milestone_name'] = $milestone['name'];
                $res[$i]['description'] = $milestone['description'];
                $res[$i]['due_date'] = $milestone['due_date'];
            }
            $res[$i]['total'] = $res[$i]['amount'] * (1 + $res[$i]['vat_percent'] / 100 - $res[$i]['discount_percent'] / 100);
        }
        return $res;
    }

    /**
     * Get invoice report for user
     *
     * @param $user
     * @param $start_date
     * @param $end_date
     * @param $no_country
     * @param $limit
     * @return array
     * @throws Exception
     */
    function get_invoice_report($user, $start_date, $end_date, $no_country, $limit)
    {
        $this->load->model('common_model');
        $this->load->model('project_model');

        $esc_user = $this->db->escape($user);
        $esc_start_date = $this->db->escape($start_date);
        $esc_end_date = $this->db->escape($end_date);

        $res = $this->db->query("SELECT job_id, country, fiscal_year, SUM(amount) AS amount, vat_percent, SUM(vat) AS vat
							       FROM (SELECT j.id AS job_id, 
							                    j.country, 
							                    FROM_UNIXTIME(i.billing_date, '%Y') AS fiscal_year, 
							                    i.amount, 
							                    i.vat_percent, 
							                    i.amount * i.vat_percent AS vat
							               FROM invoice AS i
									       JOIN jobs AS j ON i.job_id = j.id
									       JOIN country AS c ON j.country = c.id
								          WHERE (j.creator_id = " . $esc_user . " OR j.employee_id = " . $esc_user . ")
									        AND i.billing_date BETWEEN " . $esc_start_date . " AND " . $esc_end_date . ") AS t
						          GROUP BY fiscal_year, country, job_id WITH ROLLUP" .
            ($limit == '' ? '' : ' LIMIT ' . $limit[1] . ',' . $limit[0]));

        if (!$res) {
            throw_db_exception();
        }

        $res = $res->result_array();
        $count = count($res);
        for ($i = 0; $i < $count; $i++) {
            $project = $this->project_model->get_project_by_id($res[$i]['job_id']);
            if (isset($project)) {
                $res[$i]['job_name'] = $project['job_name'];
                if ($user == $project['creator_id']) {
                    $res[$i]['client_id'] = $project['employee_id'];
                } elseif ($user == $project['employee_id']) {
                    $res[$i]['client_id'] = $project['creator_id'];
                } else {
                    $res[$i]['client_id'] = '';
                }
                $res[$i]['client_name'] = $this->user_model->get_name($res[$i]['client_id']);
                $res[$i]['due_date'] = $project['due_date'];
                $res[$i]['payment_status'] = $this->get_project_payment($project['id']);
                $res[$i]['country_name'] = $this->common_model->get_country($res[$i]['country'])['country_name'];
            } else {
                if ($no_country and $res[$i]['country'] != '') {
                    unset($res[$i]);
                } else {
                    $res[$i]['job_name'] = '';
                    $res[$i]['client_id'] = '';
                    $res[$i]['client_name'] = '';
                    $res[$i]['due_date'] = '';
                    $res[$i]['payment_status'] = '';
                    if ($res[$i]['country'] == '') {
                        $res[$i]['country_name'] = '';
                    } else {
                        $res[$i]['country_name'] = $this->common_model->get_country($res[$i]['country'])['country_name'];
                    }
                }
            }
        }

        return $res;
    }

    /**
     * Get payments overview per month
     *
     * @param $user
     * @param $start_date
     * @param $end_date
     * @return array
     * @throws Exception
     */
    function get_month_report($user, $start_date, $end_date)
    {
        $esc_user = $this->db->escape($user);
        $esc_start_date = $this->db->escape($start_date);
        $esc_end_date = $this->db->escape($end_date);

        $this->db->select('job_id, sum(amount) AS amount, max(billing_date) AS billing_date');
        $this->db->from('invoice');
        $this->db->where('(sender_id = ' . $esc_user . ' OR reciever_id = ' . $esc_user . ')');
        $this->db->where('billing_date BETWEEN ' . $esc_start_date . ' AND ' . $esc_end_date);
        $this->db->group_by('job_id');
        $this->db->order_by('billing_date');
        $res = $this->db->get();
        if (!$res) {
            throw_db_exception();
        }

        $res = $res->result_array();
        $months = [];
        foreach ($res as $invoice) {
            $month = date('Ym', $invoice['billing_date']);
            if (!array_key_exists($month, $months)) {
                $months[$month] = [
                    "contracted" => 0,
                    "escrow" => 0,
                    "pending" => 0,
                    "paid" => 0,
                    "delayed" => 0,
                    "disputed" => 0,
                    "total" => 0
                ];
            }

            $payment = $this->get_project_payment($invoice['job_id']);

            if ($payment['class'] == 'payment-status-dispute') {
                $months[$month]['disputed'] += $invoice['amount'];
                $months[$month]['total'] += $invoice['amount'];
            } elseif ($payment['class'] == 'payment-status-canceled') {
                $months[$month]['delayed'] += $invoice['amount'];
                $months[$month]['total'] += $invoice['amount'];
            } elseif ($payment['class'] == 'payment-status-paid') {
                $months[$month]['paid'] += $invoice['amount'];
                $months[$month]['total'] += $invoice['amount'];
            } elseif ($payment['class'] == 'payment-status-escrow') {
                $months[$month]['escrow'] += $invoice['amount'];
                $months[$month]['total'] += $invoice['amount'];
            } elseif ($payment['class'] == 'payment-status-overdue' or $payment['class'] == 'payment-status-invoice-sent') {
                $months[$month]['paid'] += $payment['amount'];
                $months[$month]['pending'] += $payment['due'];
                $months[$month]['total'] += $payment['amount'] + $payment['due'];
            } else {
                $months[$month]['contracted'] += $invoice['amount'];
                $months[$month]['total'] += $invoice['amount'];
            }
        }

        return $months;
    }

    /**
     * Get VAT matrix
     */
    function get_vat_matrix()
    {
        $vat = [];

        // Get countries
        $this->db->select('id, country_name');
        $this->db->from('country');
        $this->db->where('active', 1);
        $res = $this->db->get();
        if (!$res) {
            throw_db_exception();
        }
        foreach ($res->result_array() as $country) {
            $vat[$country['id']] = [
                'name' => $country['country_name'],
                'vat' => []
            ];
        }

        // Get matrix
        $this->db->select('c1.id AS id1, c2.id AS id2, v.percent');
        $this->db->from('country AS c1');
        $this->db->join('country AS c2', 'c1.active = 1 AND c2.active = 1');
        $this->db->join('vat_matrix AS v', 'c1.id = v.country1 AND c2.id = v.country2', 'left');
        $this->db->order_by('id1', 'ASC');
        $this->db->order_by('id2', 'ASC');
        $res = $this->db->get();
        if (!$res) {
            throw_db_exception();
        }
        foreach ($res->result_array() as $item) {
            $vat[$item['id1']]['vat'][$item['id2']] = $item['percent'];
        }

        return $vat;
    }

    /**
     * Get import tax matrix
     */
    function get_import_matrix()
    {
        $import = [];

        // Get countries
        $this->db->select('id, country_name');
        $this->db->from('country');
        $this->db->where('active', 1);
        $res = $this->db->get();
        if (!$res) {
            throw_db_exception();
        }
        foreach ($res->result_array() as $country) {
            $import[$country['id']] = [
                'name' => $country['country_name'],
                'import' => []
            ];
        }

        // Get matrix
        $this->db->select('c1.id AS id1, c2.id AS id2, i.percent');
        $this->db->from('country AS c1');
        $this->db->join('country AS c2', 'c1.active = 1 AND c2.active = 1');
        $this->db->join('import_matrix AS i', 'c1.id = i.country1 AND c2.id = i.country2', 'left');
        $this->db->order_by('id1', 'ASC');
        $this->db->order_by('id2', 'ASC');
        $res = $this->db->get();
        if (!$res) {
            throw_db_exception();
        }
        foreach ($res->result_array() as $item) {
            $import[$item['id1']]['import'][$item['id2']] = $item['percent'];
        }

        return $import;
    }


    // Operations

    /**
     * Get platform earnings for period
     *
     * @param $period
     * @param $limit
     * @param $order_by
     * @return array
     * @throws Exception
     */
    function get_earnings($period, $limit = '', $order_by = '')
    {
        $account = $this->get_internal_account_fee();
        if (!isset($account)) {
            throw new Exception('Account access error');
        }

        switch ($period) {
            case 'day':
                $time = strtotime('today', get_est_time());
                break;
            case 'week':
                $time = strtotime('-' . date('w') . ' days', get_est_time());
                break;
            case 'month':
                $time = strtotime('first day of this month', get_est_time());
                break;
            case 'quarter':
                $quarter_month = floor((date('m') - 1) / 3) + 1;
                $time = strtotime(date('Y') . '-' . $quarter_month . '-1', get_est_time());
                break;
            case 'year':
                $time = strtotime('first day of January this year', get_est_time());
                break;
            default:
                throw new Exception('Incorrect period');
        }

        $this->db->select("t.*, i1.amount, u.user_name, tt.name AS type_name");
        $this->db->from('transactions AS t');
        $this->db->join('transaction_items AS i1', 't.id = i1.transaction_id');
        $this->db->join('transaction_items AS i2', 't.id = i2.transaction_id');
        $this->db->join('user_balance AS b', 'b.id = i2.account_id');
        $this->db->join('users AS u', 'u.id = b.user_id');
        $this->db->join('transaction_type AS tt', 'tt.id = t.type');
        $this->db->where('i1.account_id', $account->id);
        $this->db->where('i2.direction', 1);
        $this->db->where('t.status', 1);
        $this->db->where('t.transaction_time >= ', $time);

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
            $this->db->order_by('t.transaction_time', 'DESC');
        }

        $res = $this->db->get();
        if (!$res) {
            throw_db_exception();
        }
        return $res->result_array();
    }

    /**
     * Get platform earnings for period
     *
     * @param $period
     * @return array
     * @throws Exception
     */
    function get_earnings_chart($period)
    {
        $account = $this->get_internal_account_fee();
        if (!isset($account)) {
            throw new Exception('Account access error');
        }

        switch ($period) {
            case 'day':
                $time = strtotime('today', get_est_time());
                $group = '%H';
                break;
            case 'week':
                $time = strtotime('-' . date('w') . ' days', get_est_time());
                $group = '%Y%m%d';
                break;
            case 'month':
                $time = strtotime('first day of this month', get_est_time());
                $group = '%Y%m%d';
                break;
            case 'quarter':
                $quarter_month = floor((date('m') - 1) / 3) + 1;
                $time = strtotime(date('Y') . '-' . $quarter_month . '-1', get_est_time());
                $group = '%Y%m';
                break;
            case 'year':
                $time = strtotime('first day of January this year', get_est_time());
                $group = '%Y%m';
                break;
            default:
                throw new Exception('Incorrect period');
        }

        $this->db->select("DATE_FORMAT(FROM_UNIXTIME(t.transaction_time), '" . $group . "') AS time, SUM(i.amount) AS amount");
        $this->db->from('transactions AS t');
        $this->db->join('transaction_items AS i', 't.id = i.transaction_id');
        $this->db->where('i.account_id', $account->id);
        $this->db->where('t.transaction_time >= ', $time);
        $this->db->where('t.status', 1);
        $this->db->group_by("DATE_FORMAT(FROM_UNIXTIME(t.transaction_time), '" . $group . "')");

        $res = $this->db->get();
        if (!$res) {
            throw_db_exception();
        }
        return $res->result_array();
    }

    /**
     * Deposit funds to current user account
     *
     * @param $amount
     * @param $method
     * @param $paypal_transaction_id
     * @param $description
     * @param $user
     * @return int
     * @throws Exception
     */
    function deposit($amount, $method, $paypal_transaction_id = '', $description = '', $user = '', $customDataArr = [])
    {
        if ($user == '') {
            $user = $this->logged_in_user->id;
        }

        // Checks
        if (!isset($amount) or !is_numeric($amount) or $amount <= 0) {
            throw new Exception('Wrong amount specified');
        }
        $account = $this->get_account($user);
        if (!isset($account)) {
            throw new Exception('User does not have account');
        }

        $this->db->trans_start();

        // Create transaction
        $this->db->insert(
            'transactions',
            [
                'type' => 0,
                'payment_method' => $method,
                'transaction_time' => get_est_time(),
                'paypal_address' => $paypal_transaction_id,
                'description' => $description,
                'status' => 0,
                'user_transaction_id' => !empty($customDataArr['user_transaction_id']) ? $customDataArr['user_transaction_id'] : '',
                'user_description' => !empty($customDataArr['user_description']) ? $customDataArr['user_description'] : '',
                'creator_id' => $this->logged_in_user->id
            ]
        );
        $transaction_id = $this->db->insert_id();

        // Increase account
        $this->db->insert(
            'transaction_items',
            [
                'transaction_id' => $transaction_id,
                'account_id' => $account->id,
                'amount' => $amount,
                'direction' => 2
            ]
        );

        $this->db->trans_complete();

        return $transaction_id;
    }

    /**
     * Withdraw funds from current user account
     *
     * @param $amount
     * @param $method
     * @param $user
     * @return int
     * @throws Exception
     */
    function withdraw($amount, $method, $user = '', $customDataArr = [])
    {
        if ($user == '') {
            $user = $this->logged_in_user->id;
        }

        // Checks
        if (!isset($amount) or !is_numeric($amount) or $amount <= 0) {
            throw new Exception('Wrong amount specified');
        }
        $account = $this->get_account($user);
        if (!isset($account)) {
            throw new Exception('User does not have account');
        } elseif ($account->amount < $amount) {
            throw new Exception('Insufficient funds');
        }

        $this->db->trans_start();

        // Create transaction
        $this->db->insert(
            'transactions',
            [
                'type' => 1,
                'payment_method' => $method,
                'transaction_time' => get_est_time(),
                'status' => 0,
                'user_bank_information' => $this->setUserBankInformation($customDataArr),
                'creator_id' => $this->logged_in_user->id
            ]
        );
        $transaction_id = $this->db->insert_id();

        // Decrease account
        $this->db->insert(
            'transaction_items',
            [
                'transaction_id' => $transaction_id,
                'account_id' => $account->id,
                'amount' => $amount,
                'direction' => 1
            ]
        );

        $this->db->trans_complete();

        return $transaction_id;
    }

    function setUserBankInformation($customDataArr = [])
    {
        if (empty($customDataArr['recipient'])) {
            return '';
        }
        $str = '<div>';
        $str .= '<div>';
        $str .= '<b>';
        $str .= 'Recipient:';
        $str .= '</b>';
        $str .= '<br>';
        $str .= $customDataArr['recipient'];
        $str .= '</div>';
        $str .= '<div>';
        $str .= '<b>';
        $str .= 'Bank account number:';
        $str .= '</b>';
        $str .= '<br>';
        $str .= $customDataArr['bank_account_number'];
        $str .= '</div>';
        $str .= '<div>';
        $str .= '<b>';
        $str .= 'BIC/Swift-Code/ABA:';
        $str .= '</b>';
        $str .= '<br>';
        $str .= $customDataArr['bic_swift_code_aba'];
        $str .= '</div>';
        $str .= '<div>';
        $str .= '<b>';
        $str .= 'Credit institution:';
        $str .= '</b>';
        $str .= '<br>';
        $str .= $customDataArr['credit_institution'];
        $str .= '</div>';
        $str .= '<div>';
        $str .= '<b>';
        $str .= 'Target country:';
        $str .= '</b>';
        $str .= '<br>';
        $str .= $customDataArr['target_country'];
        $str .= '</div>';
        $str .= '</div>';
        return $str;
    }

    /**
     * Transfer funds for project/milestone from current user account
     *
     * @param $project
     * @param $milestone
     * @param $reciever
     * @param $amount
     * @param $user
     * @return int
     * @throws Exception
     */
    function transfer($project, $milestone, $reciever, $amount, $user = '')
    {
        if ($user == '') {
            $user = $this->logged_in_user->id;
        }

        $this->load->model('project_model');
        if (!isset($reciever) or $reciever == '') {
            $reciever = $this->project_model->get_project_by_id($project)['employee_id'];
            if (!isset($reciever)) {
                throw new Exception('Recieving user not specified');
            }
        }

        if (!isset($amount) or !is_numeric($amount) or $amount <= 0) {
            throw new Exception('Wrong amount specified');
        }
        $account_sender = $this->get_account($user);
        if (!isset($account_sender)) {
            throw new Exception('User does not have account');
        } elseif ($account_sender->amount < $amount) {
            throw new Exception('Insufficient funds');
        }
        $account_reciever = $this->get_account($reciever);
        if (!isset($account_reciever)) {
            throw new Exception('Recieving user does not have account');
        }

        if ($milestone == '') {
            $milestone = NULL;
        }

        $this->db->trans_start();

        // Create transaction
        $this->db->insert(
            'transactions',
            [
                'type' => 3,
                'job_id' => $project,
                'milestone_id' => $milestone,
                'transaction_time' => get_est_time(),
                'status' => 0,
                'creator_id' => $this->logged_in_user->id
            ]
        );
        $transaction_id = $this->db->insert_id();

        // Decrease account
        $this->db->insert(
            'transaction_items',
            [
                'transaction_id' => $transaction_id,
                'account_id' => $account_sender->id,
                'amount' => $amount,
                'direction' => 1
            ]
        );

        // Increase account
        $this->db->insert(
            'transaction_items',
            [
                'transaction_id' => $transaction_id,
                'account_id' => $account_reciever->id,
                'amount' => $amount,
                'direction' => 2
            ]
        );

        $this->db->trans_complete();

        return $transaction_id;
    }

    /**
     * Escrow request for project/milestone
     *
     * @param $project
     * @param $milestone
     * @param $amount
     * @param $user
     * @return int
     * @throws Exception
     */
    function escrow_request($project, $milestone, $amount, $user = '')
    {
		if (!empty($this->config->item('disable_escrow'))) {
			return NULL;
		}

        if ($user == '') {
            $user = $this->logged_in_user->id;
        }

        // Check that project is active
        $project_data = $this->project_model->get_project_by_id($project);
        if (!isset($project_data) or $project_data['job_status'] < 3 or $project_data['job_status'] == 8) {
            throw new Exception('Project must be active or assigned to provider');
        }

        // Check that there is no escrow requests/releases/cancels for this project/milestone
        $this->db->select('count(*) as num');
        $this->db->from('transactions');
        $this->db->where('job_id', $project);
        if ($milestone == NULL or $milestone == '') {
            $this->db->where('milestone_id IS NULL');
        } else {
            $this->db->where('milestone_id', $milestone);
        }
        $this->db->where_in('type', [4, 5, 6]);
        $this->db->where_in('status', [0, 1]);
        $res = $this->db->get()->row();
        if (isset($res) and $res->num > 0) {
            throw new Exception('There already is escrow request for this project/milestone');
        }

        $fee = $this->get_fee($amount, self::FEE_ESCROW);

        if (!isset($amount) or !is_numeric($amount) or $amount <= 0) {
            throw new Exception('Wrong amount specified');
        }
        $account_sender = $this->get_account($user);
        if (!isset($account_sender)) {
            throw new Exception('User does not have account');
        } elseif ($account_sender->amount < ($amount + $fee)) {
            throw new Exception('Insufficient funds');
        }
        $account_escrow = $this->get_internal_account_escrow();
        if (!isset($account_escrow)) {
            throw new Exception('Internal error');
        }
        $account_fee = $this->get_internal_account_fee();
        if (!isset($account_fee)) {
            throw new Exception('Internal error');
        }

        if ($milestone == '') {
            $milestone = NULL;
        }

        $this->db->trans_start();

        // Create transaction
        $this->db->insert(
            'transactions',
            [
                'type' => 4,
                'job_id' => $project,
                'milestone_id' => $milestone,
                'transaction_time' => get_est_time(),
                'status' => 0,
                'creator_id' => $this->logged_in_user->id
            ]
        );
        $transaction_id = $this->db->insert_id();

        // Decrease account
        $this->db->insert(
            'transaction_items',
            [
                'transaction_id' => $transaction_id,
                'account_id' => $account_sender->id,
                'amount' => ($amount + $fee),
                'direction' => 1
            ]
        );

        // Increase account
        $this->db->insert(
            'transaction_items',
            [
                'transaction_id' => $transaction_id,
                'account_id' => $account_escrow->id,
                'amount' => $amount,
                'direction' => 2
            ]
        );

        // Fee
        $this->db->insert(
            'transaction_items',
            [
                'transaction_id' => $transaction_id,
                'account_id' => $account_fee->id,
                'amount' => $fee,
                'direction' => 2
            ]
        );

        $this->db->trans_complete();

        return $transaction_id;
    }

    /**
     * Escrow release for project/milestone
     *
     * @param $project
     * @param $milestone
     * @return int
     * @throws Exception
     */
    function escrow_release($project, $milestone)
    {
		if (!empty($this->config->item('disable_escrow'))) {
			return NULL;
		}

        // Check that escrow request exists
        $this->db->select('count(*) as num');
        $this->db->from('transactions');
        $this->db->where('job_id', $project);
        if ($milestone == NULL or $milestone == '') {
            $this->db->where('milestone_id IS NULL');
        } else {
            $this->db->where('milestone_id', $milestone);
        }
        $this->db->where_in('type', [4]);
        $this->db->where_in('status', [0, 1]);
        $res = $this->db->get()->row();
        if (isset($res) or $res->num == 0) {
            return NULL;
        }

        $this->load->model('project_model');
        $reciever = $this->project_model->get_project_by_id($project)['employee_id'];
        if (!isset($reciever)) {
            throw new Exception('Recieving user not specified');
        }

        // Check that there is no escrow releases/cancels for this project/milestone
        $this->db->select('count(*) as num');
        $this->db->from('transactions');
        $this->db->where('job_id', $project);
        if ($milestone == NULL or $milestone == '') {
            $this->db->where('milestone_id IS NULL');
        } else {
            $this->db->where('milestone_id', $milestone);
        }
        $this->db->where_in('type', [5, 6]);
        $this->db->where_in('status', [0, 1]);
        $res = $this->db->get()->row();
        if (isset($res) and $res->num > 0) {
            throw new Exception('There already is escrow request for this project/milestone');
        }

        $account_escrow = $this->get_internal_account_escrow();
        if (!isset($account_escrow)) {
            throw new Exception('Internal error');
        }
        // Get amount
        $this->db->select('sum(i.amount) as amount');
        $this->db->from('transactions as t');
        $this->db->join('transaction_items as i', 'i.transaction_id = t.id');
        $this->db->where('t.job_id', $project);
        if ($milestone == NULL or $milestone == '') {
            $this->db->where('t.milestone_id IS NULL');
        } else {
            $this->db->where('t.milestone_id', $milestone);
        }
        $this->db->where('t.type', 4);
        $this->db->where('t.status', 1);
        $this->db->where('i.account_id', $account_escrow->id);
        $res = $this->db->get()->row();
        if (isset($res)) {
            $amount = $res->amount;
            if ($amount == NULL) $amount = 0;
        } else {
            throw new Exception('Wrong amount specified');
        }

        if ($account_escrow->amount < $amount) {
            throw new Exception('Internal error');
        }
        $account_reciever = $this->get_account($reciever);
        if (!isset($account_reciever)) {
            throw new Exception('Recieving user does not have account');
        }

        if ($milestone == '') {
            $milestone = NULL;
        }

        $this->db->trans_start();

        // Create transaction
        $this->db->insert(
            'transactions',
            [
                'type' => 5,
                'job_id' => $project,
                'milestone_id' => $milestone,
                'transaction_time' => get_est_time(),
                'status' => 0,
                'creator_id' => $this->logged_in_user->id
            ]
        );
        $transaction_id = $this->db->insert_id();

        // Decrease account
        $this->db->insert(
            'transaction_items',
            [
                'transaction_id' => $transaction_id,
                'account_id' => $account_escrow->id,
                'amount' => $amount,
                'direction' => 1
            ]
        );

        // Increase account
        $this->db->insert(
            'transaction_items',
            [
                'transaction_id' => $transaction_id,
                'account_id' => $account_reciever->id,
                'amount' => $amount,
                'direction' => 2
            ]
        );

        $this->db->trans_complete();

        return $transaction_id;
    }

    /**
     * Escrow cancel for project/milestone
     *
     * @param $project
     * @param $milestone
     * @return int
     * @throws Exception
     */
    function escrow_cancel($project, $milestone)
    {
		if (!empty($this->config->item('disable_escrow'))) {
			return NULL;
		}

        // Check that escrow request exists
        $this->db->select('count(*) as num');
        $this->db->from('transactions');
        $this->db->where('job_id', $project);
        if ($milestone == NULL or $milestone == '') {
            $this->db->where('milestone_id IS NULL');
        } else {
            $this->db->where('milestone_id', $milestone);
        }
        $this->db->where_in('type', [4]);
        $this->db->where_in('status', [0, 1]);
        $res = $this->db->get()->row();
        if (isset($res) or $res->num == 0) {
            return NULL;
        }

        $this->load->model('project_model');
        $reciever = $this->project_model->get_project_by_id($project)['creator_id'];
        if (!isset($reciever)) {
            throw new Exception('Recieving user not specified');
        }

        // Check that there is no escrow releases/cancels for this project/milestone
        $this->db->select('count(*) as num');
        $this->db->from('transactions');
        $this->db->where('job_id', $project);
        if ($milestone == NULL or $milestone == '') {
            $this->db->where('milestone_id IS NULL');
        } else {
            $this->db->where('milestone_id', $milestone);
        }
        $this->db->where_in('type', [5, 6]);
        $this->db->where_in('status', [0, 1]);
        $res = $this->db->get()->row();
        if (isset($res) and $res->num > 0) {
            throw new Exception('There already is escrow request for this project/milestone');
        }

        $account_escrow = $this->get_internal_account_escrow();
        if (!isset($account_escrow)) {
            throw new Exception('Internal error');
        }
        // Get amount
        $this->db->select('sum(i.amount) as amount');
        $this->db->from('transactions as t');
        $this->db->join('transaction_items as i', 'i.transaction_id = t.id');
        $this->db->where('t.job_id', $project);
        if ($milestone == NULL or $milestone == '') {
            $this->db->where('t.milestone_id IS NULL');
        } else {
            $this->db->where('t.milestone_id', $milestone);
        }
        $this->db->where('t.type', 4);
        $this->db->where('t.status', 1);
        $this->db->where('i.account_id', $account_escrow->id);
        $res = $this->db->get()->row();
        if (isset($res)) {
            $amount = $res->amount;
            if ($amount == NULL) $amount = 0;
        } else {
            throw new Exception('Wrong amount specified');
        }

        if ($account_escrow->amount < $amount) {
            throw new Exception('Internal error');
        }
        $account_reciever = $this->get_account($reciever);
        if (!isset($account_reciever)) {
            throw new Exception('Recieving user does not have account');
        }

        if ($milestone == '') {
            $milestone = NULL;
        }

        $this->db->trans_start();

        // Create transaction
        $this->db->insert(
            'transactions',
            [
                'type' => 6,
                'job_id' => $project,
                'milestone_id' => $milestone,
                'transaction_time' => get_est_time(),
                'status' => 0,
                'creator_id' => $this->logged_in_user->id
            ]
        );
        $transaction_id = $this->db->insert_id();

        // Decrease account
        $this->db->insert(
            'transaction_items',
            [
                'transaction_id' => $transaction_id,
                'account_id' => $account_escrow->id,
                'amount' => $amount,
                'direction' => 1
            ]
        );

        // Increase account
        $this->db->insert(
            'transaction_items',
            [
                'transaction_id' => $transaction_id,
                'account_id' => $account_reciever->id,
                'amount' => $amount,
                'direction' => 2
            ]
        );

        $this->db->trans_complete();

        return $transaction_id;
    }

    /**
     * Fees for project
     *
     * @param $project_id
     * @param $user
     * @return int|null
     * @throws Exception
     */
    function project_fee($project_id, $user = '')
    {
        if ($user == '') {
            $user = $this->logged_in_user->id;
        }

        $this->load->model('project_model');
        $project = $this->project_model->get_project_by_id($project_id);
        if (!isset($project)) {
            throw new Exception('Project is not specified');
        }

        $fee = $this->get_project_fee($project['id'], $project['is_urgent'], $project['is_feature'], $project['is_hide_bids'], $project['is_private']);

        if (!isset($fee) or !is_numeric($fee) or $fee <= 0) {
            // No fee
            return NULL;
        }
        $account_sender = $this->get_account($user);
        if (!isset($account_sender)) {
            throw new Exception('User does not have account');
        } elseif ($account_sender->amount < $fee) {
            throw new Exception('Insufficient funds');
        }
        $account_fee = $this->get_internal_account_fee();
        if (!isset($account_fee)) {
            throw new Exception('Internal error');
        }

        $this->db->trans_start();

        // Create transaction
        $this->db->insert(
            'transactions',
            [
                'type' => 2,
                'job_id' => $project_id,
                'transaction_time' => get_est_time(),
                'status' => 0,
                'creator_id' => $this->logged_in_user->id
            ]
        );
        $transaction_id = $this->db->insert_id();

        // Decrease account
        $this->db->insert(
            'transaction_items',
            [
                'transaction_id' => $transaction_id,
                'account_id' => $account_sender->id,
                'amount' => $fee,
                'direction' => 1
            ]
        );

        // Fee
        $this->db->insert(
            'transaction_items',
            [
                'transaction_id' => $transaction_id,
                'account_id' => $account_fee->id,
                'amount' => $fee,
                'direction' => 2
            ]
        );

        $this->db->trans_complete();

        return $transaction_id;
    }

    /**
     * Calculate project fee
     *
     * @param $project_id
     * @param $is_urgent
     * @param $is_featured
     * @param $is_hide_bids
     * @param $is_private
     * @return int
     */
    function get_project_fee($project_id, $is_urgent, $is_featured, $is_hide_bids, $is_private)
    {
        // Check if fee is already collected
        if ($project_id != '' and $project_id != NULL) {
            $this->db->select('count(*) as num');
            $this->db->from('transactions');
            $this->db->where('job_id', $project_id);
            $this->db->where('type', 2);
            $this->db->where_in('status', [0, 1]);
            $res = $this->db->get()->row();
            if (isset($res) and $res->num > 0) {
                return 0;
            }
        }

        // Calculate fee
        $fee = 0;
        $this->load->model('settings_model');
        $paymentSettings = $this->settings_model->getSiteSettings();
        if ($is_urgent != '') {
            $fee += $paymentSettings['URGENT_PROJECT_AMOUNT'];
        }
        if ($is_featured != '') {
            $fee += $paymentSettings['FEATURED_PROJECT_AMOUNT'];
        }
        if ($is_hide_bids != '') {
            $fee += $paymentSettings['HIDE_PROJECT_AMOUNT'];
        }
        if ($is_private != '') {
            $fee += $paymentSettings['PRIVATE_PROJECT_AMOUNT'];
        }

        return $fee;
    }

    /**
     * Finalize transaction and update accounts
     *
     * @param $id
     * @param $description
     * @param $key
     * @throws Exception
     */
    function finalize_transaction($id, $description = '', $key = '')
    {
        $this->db->select('t.id, t.type, t.status, i.account_id, i.direction, i.amount');
        $this->db->from('transactions AS t');
        $this->db->join('transaction_items AS i', 'i.transaction_id = t.id');
        $this->db->where('t.id', $id);
        $this->db->where('t.status', 0);
        $res = $this->db->get();
        if (!isset($res)) {
            throw_db_exception();
        }
        $res = $res->result_array();
        if (count($res) == 0) {
            throw new Exception('Transaction is not available');
        }

        // Start updating
        $this->db->trans_start();

        foreach ($res as $item) {
            $account = $this->get_account_by_id($item['account_id']);
            if (!isset($account)) {
                $this->db->trans_rollback();
                throw new Exception('Internal error');
            } elseif ($item['direction'] == 1 and $item['amount'] > $account->amount) {
                $this->db->trans_rollback();
                throw new Exception('Insufficient funds');
            }

            if ($item['direction'] == 1) {
                $account->amount -= $item['amount'];
            } elseif ($item['direction'] == 2) {
                $account->amount += $item['amount'];
            }
            if (!$this->db->update('user_balance', ['amount' => $account->amount], ['id' => $account->id])) {
                $this->db->trans_rollback();
                throw_db_exception();
            }
        }

        if (!$this->db->update(
            'transactions',
            [
                'status' => 1,
                'closing_id' => $this->logged_in_user->id,
                'closing_date' => get_est_time(),
                'description' => $description,
                'paypal_address' => $key
            ],
            ['id' => $id]
        )) {
            $this->db->trans_rollback();
            throw_db_exception();
        }

        $this->db->trans_complete();

        // Notify
        switch ($res[0]['type']) {
            case 0: // Deposit
                $account = $this->get_account_by_id($res[0]['account_id']);
                $this->email_model->prepare(
                    'deposit',
                    $account->user_id,
                    [
                        '!username' => $this->user_model->get_name($account->user_id),
                        '!site_name' => $this->config->item('site_title'),
                        '!amount' => currency() . number_format($res[0]['amount']),
                        '!balance' => currency() . number_format($account->amount),
                        '!url' => site_url('finance/deposit')
                    ]
                );
                break;
        }
    }

    /**
     * Get user account
     *
     * @param $id
     * @return object
     */
    private function get_account_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('user_balance');
        $this->db->where('id', $id);
        $res = $this->db->get()->row();
        if (isset($res)) {
            return $res;
        } else {
            return NULL;
        }
    }

    /**
     * Cancel transaction
     *
     * @param $id
     * @param $description
     * @throws Exception
     */
    function cancel_transaction($id, $description = '')
    {
        $this->db->select('t.id, t.status, i.account_id, i.direction, i.amount');
        $this->db->from('transactions AS t');
        $this->db->join('transaction_items AS i', 'i.transaction_id = t.id');
        $this->db->where('t.id', $id);
        $this->db->where('t.status', 0);
        $res = $this->db->get();
        if (!isset($res)) {
            throw_db_exception();
        }
        $res = $res->result_array();
        if (count($res) == 0) {
            throw new Exception('Transaction is not available');
        }

        if (!$this->db->update(
            'transactions',
            [
                'status' => 2,
                'closing_id' => $this->logged_in_user->id,
                'closing_date' => get_est_time(),
                'description' => $description
            ],
            ['id' => $id]
        )) {
            throw_db_exception();
        }
    }

    /**
     * Save invoice for project/milestone
     *
     * @param $project_id
     * @param $milestone_id
     * @throws Exception
     */
    function save_invoice($project_id, $milestone_id = '')
    {
        $this->load->model('project_model');

        // Get data
        $project = $this->project_model->get_project_by_id($project_id);
        if (!isset($project)) {
            throw new Exception('Project does not exist');
        }

        // Project level
        if ($milestone_id == '') {
            if (!$this->db->insert(
                'invoice',
                [
                    'job_id' => $project_id,
                    'sender_id' => $project['employee_id'],
                    'reciever_id' => $project['creator_id'],
                    'amount' => $project['budget_min'],
                    'vat_percent' => $project['vat_percent'],
                    'billing_date' => get_est_time()
                ]
            )) {
                throw_db_exception();
            }

            // Get milestones that are not invoiced yet
            $this->db->select('id, amount, vat_percent');
            $this->db->from('milestones');
            $this->db->where('job_id', $project_id);
            $this->db->where('NOT EXISTS (SELECT 1 FROM invoice WHERE invoice.job_id = milestones.job_id AND invoice.milestone_id = milestones.id)');
            $res = $this->db->get();
            if (!$res) {
                throw_db_exception();
            }
            foreach ($res->result_array() as $milestone) {
                if (!$this->db->insert(
                    'invoice',
                    [
                        'job_id' => $project_id,
                        'milestone_id' => $milestone['id'],
                        'sender_id' => $project['employee_id'],
                        'reciever_id' => $project['creator_id'],
                        'amount' => $milestone['amount'],
                        'vat_percent' => $milestone['vat_percent'],
                        'billing_date' => get_est_time()
                    ]
                )) {
                    throw_db_exception();
                }
            }
        } // Milestone level
        else {
            $milestone = $this->project_model->get_milestone_by_id($milestone_id);
            if (!isset($milestone)) {
                throw new Exception('Milestone does not exist');
            }

            if (!$this->db->insert(
                'invoice',
                [
                    'job_id' => $project_id,
                    'milestone_id' => $milestone_id,
                    'sender_id' => $project['employee_id'],
                    'reciever_id' => $project['creator_id'],
                    'amount' => $milestone['amount'],
                    'vat_percent' => $milestone['vat_percent'],
                    'billing_date' => get_est_time()
                ]
            )) {
                throw_db_exception();
            }
        }
    }

    /**
     * Get list of all transaction types
     *
     * @return array
     * @throws Exception
     */
    function get_transaction_types()
    {
        $this->db->select('*');
        $this->db->from('transaction_type');
        $this->db->order_by('id', 'ASC');
        $res = $this->db->get();
        if (!$res) {
            throw_db_exception();
        }
        return $res->result_array();
    }

    // Working with account

    /**
     * Get list of all payment methods
     *
     * @return array
     * @throws Exception
     */
    function get_payment_methods()
    {
        $this->db->select('*');
        $this->db->from('payment_methods');
        $this->db->order_by('id', 'ASC');
        $res = $this->db->get();
        if (!$res) {
            throw_db_exception();
        }
        return $res->result_array();
    }

    /**
     * Save VAT matrix
     *
     * @param $data
     * @throws Exception
     */
    function save_vat_matrix($data)
    {
        $this->db->trans_start();

        foreach ($data as $i => $row) {
            foreach ($row as $j => $val) {
                if ($val === '') {
                    $this->db->delete('vat_matrix', ['country1' => $i, 'country2' => $j]);
                } else {
                    $this->db->query('INSERT INTO vat_matrix (country1, country2, percent) VALUES (' . $i . ', ' . $j . ', ' . $val . ') ON DUPLICATE KEY UPDATE percent = ' . $val);
                }
            }
        }

        $this->db->trans_complete();
    }

    /**
     * Save import tax matrix
     *
     * @param $data
     * @throws Exception
     */
    function save_import_matrix($data)
    {
        $this->db->trans_start();

        foreach ($data as $i => $row) {
            foreach ($row as $j => $val) {
                if ($val === '') {
                    $this->db->delete('import_matrix', ['country1' => $i, 'country2' => $j]);
                } else {
                    $this->db->query('INSERT INTO import_matrix (country1, country2, percent) VALUES (' . $i . ', ' . $j . ', ' . $val . ') ON DUPLICATE KEY UPDATE percent = ' . $val);
                }
            }
        }

        $this->db->trans_complete();
    }

    /**
     * Save escrow fees
     *
     * @param $data
     * @param $type
     */
    function save_fees($data, $type)
    {
        $this->db->update_batch($type == self::FEE_ESCROW ? 'escrow_fee' : 'platform_fee', $data, 'id');
    }
}