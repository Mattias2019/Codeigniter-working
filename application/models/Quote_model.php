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

class Quote_model extends CI_Model
{
    public $logged_in_user;

    function __construct()
    {
        parent::__construct();

        // Load models
        $this->load->model('common_model');
        $this->load->model('email_model');
        $this->load->model('file_model');
        //$this->load->model('notification_model');
        $this->load->model('project_model');
        $this->load->model('user_model');

        $this->logged_in_user = $this->common_model->get_logged_in_user();
    }

    /* Reading quotes from database */

    /**
     * Get won quote on project
     *
     * @param $project_id
     * @return null
     */
    function get_won_quote($project_id)
    {
        $this->db->select('*');
        $this->db->from('quotes');
        $this->db->where('job_id', $project_id);
        $this->db->where('status', 3);

        $res = $this->db->get();
        if (isset($res)) {
            $quote = $res->result_array()[0];
            $quote['attachments'] = $this->get_quote_attachments($quote['job_id'], $quote['id'], $quote['creator_id']);
            $quote['milestones'] = $this->get_quote_milestones($quote['job_id'], $quote['id'], $quote['creator_id']);
        } else {
            $quote = NULL;
        }

        return $quote;
    }

    /**
     * Returns the list of all attachments for quote
     *
     * @param $project_id
     * @param $quote_id
     * @param $user_id
     * @return array
     */
    function get_quote_attachments($project_id, $quote_id, $user_id)
    {
        $this->db->select('*');
        $this->db->from('quote_attachments');
        $this->db->where('quote_id', $quote_id);
        $this->db->order_by('id', 'ASC');
        $res = $this->db->get();
        if (isset($res)) {
            $res = $res->result_array();
            $count = count($res);
            for ($i = 0; $i < $count; $i++) {
                $res[$i]['img_url'] = $this->file_model->get_quote_file_path($user_id, $res[$i]['url'], $project_id, $quote_id);
            }
            return $res;
        } else {
            return [];
        }
    }

    /**
     * Returns the list of all milestones for quote
     *
     * @param $project_id
     * @param $quote_id
     * @param $user_id
     * @return array
     */
    function get_quote_milestones($project_id, $quote_id, $user_id)
    {
        $this->db->select('*');
        $this->db->from('quote_milestones');
        $this->db->where('quote_id', $quote_id);
        $this->db->order_by('id', 'ASC');
        $res = $this->db->get();
        if (isset($res)) {
            $res = $res->result_array();
            $count = count($res);
            for ($i = 0; $i < $count; $i++) {
                $res[$i]['attachments'] = $this->get_quote_milestone_attachments($project_id, $quote_id, $res[$i]['id'], $user_id);
            }
            return $res;
        } else {
            return [];
        }
    }

    /**
     * Returns the list of all attachments for quote milestone
     *
     * @param $project_id
     * @param $quote_id
     * @param $milestone_id
     * @param $user_id
     * @return array
     */
    function get_quote_milestone_attachments($project_id, $quote_id, $milestone_id, $user_id)
    {
        $this->db->select('*');
        $this->db->from('quote_milestone_attachments');
        $this->db->where('quote_milestone_id', $milestone_id);
        $this->db->order_by('id', 'ASC');
        $res = $this->db->get();
        if (isset($res)) {
            $res = $res->result_array();
            $count = count($res);
            for ($i = 0; $i < $count; $i++) {
                $res[$i]['img_url'] = $this->file_model->get_quote_file_path($user_id, $res[$i]['url'], $project_id, $quote_id, $milestone_id);
            }
            return $res;
        } else {
            return [];
        }
    }

    /**
     * Returns sum and description of quote with costs
     *
     * @param $project_id
     * @param $provider_id
     * @return null
     */
    function get_latest_quote($project_id, $provider_id = '')
    {
        $this->load->model('finance_model');

        // For entrepreneur, attempt to get latest quote by provider, return NULL if there is no quote
        if (isEntrepreneur()) {
            $quote_id = $this->get_latest_quote_id($project_id, $provider_id);
            if ($quote_id == NULL OR $quote_id == -1) {
                return NULL;
            }
        } // For provider, get latest quote by themselves or project info if there is no quote
        elseif (isProvider()) {
            $quote_id = $this->get_latest_quote_id($project_id, $this->logged_in_user->id);
            if ($quote_id == NULL) {
                return NULL;
            }
        } // Fallback
        else {
            return NULL;
        }

        // Get project information
        $project = $this->project_model->get_project_by_id($project_id);
        if ($project['id'] == '') {
            return [];
        }
        $project['job_status'] = $this->project_model->get_project_status($project_id);

        if (isEntrepreneur()) {
            $client_id = $provider_id;
        } elseif (isProvider()) {
            $client_id = $project['creator_id'];
        } else {
            // Fallback
            $client_id = NULL;
        }
        $client = $this->user_model->getUsers(['users.id' => $client_id], "concat(first_name, ' ', last_name) as name")->row();
        if (isset($client)) {
            $client = $client->name;
        }

        // If there is no quote, get information from the project/milestones
        if ($quote_id == -1) {
            // Project
            $quote = [
                'id' => NULL,
                'job_id' => $project_id,
                'machinery_id' => NULL,
                'provider_id' => $this->logged_in_user->id, /* Unattainable for entrepreneur */
                'name' => $project['job_name'],
                'description' => $project['description'],
                'status' => NULL,
                'creator_id' => $project['creator_id'],
                'loop' => 1,
                'due_date' => $project['due_date'],
                'due_date_format' => $project['due_date'] > 0 ? date('Y-m-d', $project['due_date']) : '',
                'amount' => $project['budget_min'],
                'created' => NULL,
                'client' => $client,
                'job_status' => $this->project_model->get_project_status($project_id),
                'costs' => NULL,
                'attachments' => $this->project_model->get_project_attachments($project_id, $project['creator_id']),
                'escrow_required' => NULL,
                'notify_lower' => NULL,
                'escrow_fee' => 0
            ];
            // Set attachment IDs to NULL
            foreach ($quote['attachments'] as $i => $val) {
                $quote['attachments'][$i]['id'] = NULL;
            }

            // Milestones
            $this->db->select('id, name, description, due_date, amount');
            $this->db->from('milestones');
            $this->db->where('job_id', $project_id);
            $this->db->order_by('id', 'ASC');
            $res = $this->db->get();
            if (isset($res)) {
                $quote['milestones'] = $res->result_array();
                $count = count($quote['milestones']);
                for ($i = 0; $i < $count; $i++) {
                    $quote['milestones'][$i]['quote_id'] = NULL;
                    $quote['milestones'][$i]['is_added'] = 0;
                    $quote['milestones'][$i]['is_deleted'] = 0;
                    $quote['milestones'][$i]['is_added_cur'] = 0;
                    $quote['milestones'][$i]['is_deleted_cur'] = 0;
                    $quote['milestones'][$i]['escrow_required'] = NULL;
                    $quote['milestones'][$i]['notify_lower'] = NULL;
                    $quote['milestones'][$i]['escrow_fee'] = 0;
                    $quote['milestones'][$i]['costs'] = NULL;
                    $quote['milestones'][$i]['attachments'] = $this->project_model->get_milestone_attachments($project_id, $quote['milestones'][$i]['id'], $project['creator_id']);
                    $quote['milestones'][$i]['id'] = NULL;
                    $quote['milestones'][$i]['due_date_format'] = $quote['milestones'][$i]['due_date'] > 0 ? date('Y-m-d', $quote['milestones'][$i]['due_date']) : '';


                    // Set attachment IDs to NULL
                    foreach ($quote['milestones'][$i]['attachments'] as $j => $val) {
                        $quote['milestones'][$i]['attachments'][$j]['id'] = NULL;
                    }
                }
            } else {
                $quote['milestones'] = NULL;
            }
        } // If there is quote, get information from it
        else {
            // Quote
            $this->db->select('*');
            $this->db->from('quotes');
            $this->db->where('id', $quote_id);
            $res = $this->db->get();
            if (isset($res)) {
                $quote = $res->result_array()[0];

                $quote['client'] = $client;
                $quote['due_date_format'] = $project['due_date'] > 0 ? date('Y-m-d', $project['due_date']) : '';
                $quote['job_status'] = $this->project_model->get_project_status($project_id);
                $quote['costs']['labor'] = $this->get_quote_cost($quote['id'], NULL, 1);
                $quote['costs']['material'] = $this->get_quote_cost($quote['id'], NULL, 2);
                $quote['costs']['third_party'] = $this->get_quote_cost($quote['id'], NULL, 3);
                $quote['costs']['travel'] = $this->get_quote_cost($quote['id'], NULL, 4);
                $quote['costs_total'] = $quote['costs']['labor']['total'] + $quote['costs']['material']['total'] +
                    $quote['costs']['third_party']['total'] + $quote['costs']['travel']['total'];

                $quote['attachments'] = $this->get_quote_attachments($project_id, $quote['id'], $quote['creator_id']);
                if ($quote['escrow_required'] == 1) {
                    $quote['escrow_fee'] = $this->finance_model->get_fee($quote['amount'], Finance_model::FEE_ESCROW);
                } else {
                    $quote['escrow_fee'] = 0;
                }

                if ($quote['platform_required'] == 1) {
                    $quote['platform_fee'] = $this->finance_model->get_fee($quote['amount'], Finance_model::FEE_PLATFORM);
                } else {
                    $quote['platform_fee'] = 0;
                }
                if ($quote['status'] == 2) {
                    $quote['id'] = NULL;
                    $quote['loop']++;
                    foreach ($quote['attachments'] as $i => $val) {
                        $quote['attachments'][$i]['id'] = NULL;
                    }
                }
            } else {
                return [];
            }

            // Milestones
            $this->db->select('*');
            $this->db->from('quote_milestones');
            $this->db->where('quote_id', $quote_id);
            $this->db->order_by('id', 'ASC');
            $res = $this->db->get();
            if (isset($res)) {
                $quote['milestones'] = $res->result_array();
                $count = count($quote['milestones']);
                for ($i = 0; $i < $count; $i++) {
                    $quote['milestones'][$i]['due_date'] = $quote['milestones'][$i]['due_date'];
                    $quote['milestones'][$i]['due_date_format'] = $quote['milestones'][$i]['due_date'] > 0 ? date('Y-m-d', $quote['milestones'][$i]['due_date']) : '';
                    $quote['milestones'][$i]['costs']['labor'] = $this->get_quote_cost($quote['milestones'][$i]['quote_id'], $quote['milestones'][$i]['id'], 1);
                    $quote['milestones'][$i]['costs']['material'] = $this->get_quote_cost($quote['milestones'][$i]['quote_id'], $quote['milestones'][$i]['id'], 2);
                    $quote['milestones'][$i]['costs']['third_party'] = $this->get_quote_cost($quote['milestones'][$i]['quote_id'], $quote['milestones'][$i]['id'], 3);
                    $quote['milestones'][$i]['costs']['travel'] = $this->get_quote_cost($quote['milestones'][$i]['quote_id'], $quote['milestones'][$i]['id'], 4);

                    $quote['milestones'][$i]['costs_total'] =
                        $quote['milestones'][$i]['costs']['labor']['total'] +
                        $quote['milestones'][$i]['costs']['material']['total'] +
                        $quote['milestones'][$i]['costs']['third_party']['total'] +
                        $quote['milestones'][$i]['costs']['travel']['total'];


                    $quote['milestones'][$i]['attachments'] = $this->get_quote_milestone_attachments($project_id, $quote['milestones'][$i]['quote_id'], $quote['milestones'][$i]['id'], $quote['creator_id']);
                    if ($quote['milestones'][$i]['escrow_required'] == 1) {
                        $quote['milestones'][$i]['escrow_fee'] = $this->finance_model->get_fee($quote['milestones'][$i]['amount'], Finance_model::FEE_ESCROW);
                    } else {
                        $quote['milestones'][$i]['escrow_fee'] = 0;
                    }

                    if ($quote['milestones'][$i]['platform_required'] == 1) {
                        $quote['milestones'][$i]['platform_fee'] = $this->finance_model->get_fee($quote['milestones'][$i]['amount'], Finance_model::FEE_PLATFORM);
                    } else {
                        $quote['milestones'][$i]['platform_fee'] = 0;
                    }
                    if ($quote['status'] == 2) {
                        $quote['milestones'][$i]['id'] = NULL;
                        foreach ($quote['milestones'][$i]['attachments'] as $j => $val) {
                            $quote['milestones'][$i]['attachments'][$j]['id'] = NULL;
                        }
                    }
                }
            } else {
                $quote['milestones'] = NULL;
            }
        }

        // Change zero-based milestones array to one-based
        if (is_array($quote['milestones'])) {
            array_unshift($quote['milestones'], NULL);
            unset($quote['milestones'][0]);
        }

        return $quote;
    }

    /**
     * Returns id of last quote by given provider for project
     *
     * @param $project_id
     * @param $provider_id
     * @return int
     */
    function get_latest_quote_id($project_id, $provider_id)
    {;
        $this->db->select('loop');
        $this->db->from('quotes');
        $this->db->where('job_id', $project_id);
        $this->db->where('provider_id', $provider_id);
        $this->db->order_by('loop', 'DESC');
        $res = $this->db->get()->row();
        if (isset($res)) {
            $loop = $res->loop;
            $this->db->select('id');
            $this->db->from('quotes');
            $this->db->where('job_id', $project_id);
            $this->db->where('provider_id', $provider_id);
            $this->db->where('loop', $loop);
            $this->db->where('(status < 2 AND creator_id = ' . $this->logged_in_user->id . ' OR status = 2 AND creator_id != ' . $this->logged_in_user->id . ')');
            $res = $this->db->get()->row();
            if (isset($res)) {
                return $res->id;
            } else {
                return NULL;
            }
        } else {
            return -1;
        }
    }

    /**
     * Returns the list of all costs for quote/milestone
     *
     * @param $quote
     * @param $milestone
     * @param $cost_type
     * @return array
     */
    function get_quote_cost($quote, $milestone, $cost_type)
    {
        $this->db->select('*');
        $this->db->from('quote_milestone_cost');
        $this->db->where('quote_id', $quote);
        $this->db->where('quote_milestone_id', $milestone);
        $this->db->where('cost_type', $cost_type);
        $res = $this->db->get()->result_array();
        if (isset($res) and count($res) > 0) {
            $res = $res[0];

            $amount = floatval($res['amount']);
            $price = floatval($res['price']);
            $vat = floatval($res['vat']);
            $sum = $amount * $price;
            $vat_sum = $sum * $vat / 100;
            $total = $sum + $vat_sum;

            $res['vat_sum'] = $vat_sum;
            $res['total'] = $total;

            return $res;
        } else {
            return NULL;
        }
    }

    /**
     * Return all placed quotes for project
     *
     * @param $project_id
     * @return array
     */
    function get_placed_quotes($project_id)
    {
        $this->db->select('*');
        $this->db->from('quotes as q');
        $this->db->where('job_id', $project_id);
        $this->db->where('status >=', 2);
        $this->db->where('q.loop = (select max(q1.loop) from quotes as q1 where q1.job_id = q.job_id and q1.provider_id = q.provider_id and q1.status >= 2)');
        $res = $this->db->get();
        if (isset($res)) {
            $res = $res->result_array();
            $count = count($res);
            for ($i = 0; $i < $count; $i++) {
                $supplier = $this->user_model->getUsers(['users.id' => $res[$i]['creator_id']], "concat(first_name, ' ', last_name) as name, country_name, city")->row();
                $res[$i]['supplier'] = $supplier->name;
                $res[$i]['country'] = $supplier->country_name;
                $res[$i]['city'] = $supplier->city;
                $res[$i]['status'] = $this->get_quote_status($res[$i]['id']);
            }
            return $res;
        } else {
            return NULL;
        }
    }

    /**
     * Returns name and class for quote status
     *
     * @param $quote_id
     * @return array
     */
    function get_quote_status($quote_id)
    {
        $result = ['id' => '', 'name' => '', 'class' => ''];

        $this->db->select('status');
        $this->db->from('quotes');
        $this->db->where('id', $quote_id);

        $res = $this->db->get();
        if (isset($res)) {
            $status = $res->row()->status;

            $result['id'] = $status;
            if ($status == '0') {
                $result['name'] = t('Draft');
                $result['class'] = 'quote-status-draft';
            } elseif ($status == '1') {
                $result['name'] = t('New');
                $result['class'] = 'quote-status-new';
            } elseif ($status == '2') {
                $result['name'] = t('Active');
                $result['class'] = 'quote-status-active';
            } elseif ($status == '3') {
                $result['name'] = t('Accepted');
                $result['class'] = 'quote-status-accepted';
            } elseif ($status == '4') {
                $result['name'] = t('Rejected');
                $result['class'] = 'quote-status-rejected';
            }
        }

        return $result;
    }

    /**
     * Returns single quote milestone with all fields and child data
     *
     * @param $id
     * @return array
     */
    function get_quote_milestone_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('quote_milestones');
        $this->db->where('id', $id);

        $res = $this->db->get();
        if (isset($res)) {
            $quote_milestone = $res->result_array()[0];
            $quote = $this->db->select('job_id, creator_id')->where('id', $quote_milestone['quote_id'])->get('quotes')->row();
            $quote_milestone['attachments'] = $this->get_quote_milestone_attachments($quote['job_id'], $quote_milestone['quote_id'], $id, $quote['creator_id']);
        } else {
            $quote_milestone = NULL;
        }

        return $quote_milestone;
    }

    /**
     * Insert/update quote and child data, return ids of quote and milestones
     *
     * @param $data
     * @return array
     */
    function save_quote($data)
    {

        // Extract non-db fields
        if (array_key_exists('milestones', $data)) {
            $milestones = $data['milestones'];
            unset($data['milestones']);
        }
        if (array_key_exists('attachments', $data)) {
            $attachments = $data['attachments'];
            unset($data['attachments']);
        }
        if (array_key_exists('costs', $data)) {
            $costs = $data['costs'];
            unset($data['costs']);
        }

        // Open transaction
        $this->db->trans_start();

        // Main table
        if (empty($data['id'])) {
            $data['creator_id'] = $this->logged_in_user->id;
            $data['created'] = get_est_time();
            $data['id'] = NULL;

            $this->db->insert('quotes', $data);
            $id = $this->db->insert_id();
        } else {
            $id = $data['id'];
            $this->db->where('id', $id);
            $this->db->update('quotes', $data);
        }

        // If submitting for dummy project, change project type to pending
        if ($data['status'] == 2 and $data['loop'] == 1) {
            $this->db->where('id', $data['job_id']);
            $this->db->update('jobs', ['job_status' => 2]);
        }

        // Attachments
        if (!isset($attachments) or !is_array($attachments)) {
            $attachments = [];
        }
        $this->delete_quote_attachments_not_in_list($this->logged_in_user->id, $data['job_id'], $id, $attachments);
        foreach ($attachments as $attachment) {
            if (empty($attachment['id'])) {
                $url = '';
                if (array_key_exists('img_url', $attachment)) {
                    $url = $attachment['img_url'];
                    unset($attachment['img_url']);
                }
                $attachment['id'] = NULL;
                $attachment['quote_id'] = $id;
                $this->db->insert('quote_attachments', $attachment);
                if ($url == '') {
                    $this->file_model->move_temp_quote_file($this->logged_in_user->id, $attachment['url'], $data['job_id'], $id);
                } else {
                    $this->file_model->copy_quote_file_from_path($this->logged_in_user->id, $url, $attachment['url'], $data['job_id'], $id);
                }
            }
        }

        // Milestones
        $milestone_ids = [];
        if (isset($milestones) and is_array($milestones) and count($milestones) > 0) {
            foreach ($milestones as $milestone) {
                $milestone_ids[] = $this->save_milestone($milestone, $data['job_id'], $id, ($data['status'] == 2));
            }
        }
        $this->delete_quote_milestones_not_in_list($this->logged_in_user->id, $data['job_id'], $id, $milestone_ids);

        // Costs
        if (isset($costs) and is_array($costs) and array_key_exists('labor', $costs)) {
            $costs['labor']['quote_id'] = $id;
            $costs['labor']['cost_type'] = 1;
            $this->save_cost($costs['labor']);
        }
        if (isset($costs) and is_array($costs) and array_key_exists('material', $costs)) {
            $costs['material']['quote_id'] = $id;
            $costs['material']['cost_type'] = 2;
            $this->save_cost($costs['material']);
        }
        if (isset($costs) and is_array($costs) and array_key_exists('third_party', $costs)) {
            $costs['third_party']['quote_id'] = $id;
            $costs['third_party']['cost_type'] = 3;
            $this->save_cost($costs['third_party']);
        }
        if (isset($costs) and is_array($costs) and array_key_exists('travel', $costs)) {
            $costs['travel']['quote_id'] = $id;
            $costs['travel']['cost_type'] = 4;
            $this->save_cost($costs['travel']);
        }

        // Finalize
        $this->db->trans_complete();

        $res = [
            'id' => $id,
            'milestones' => $milestone_ids
        ];

        // Notify
        $project = $this->project_model->get_project_by_id($data['job_id']);
        $receiver = isEntrepreneur() ? $data['provider_id'] : (isProvider() ? $project['creator_id'] : '');
        if ($data['status'] == 2) {
            $this->email_model->prepare(
                $data['loop'] == 1 ? 'quote_placed' : 'quote_revised',
                $receiver,
                [
                    '!username' => $this->user_model->get_name($receiver),
                    '!user' => $this->logged_in_user->full_name,
                    '!project' => $project['job_name'],
                    '!url' => site_url('project/quote?id=' . $data['job_id'] . (isProvider() ? ('&provider=' . $this->logged_in_user->id) : ''))
                ]
            );
        }

        return $res;
    }


    /* Saving quote into database */

    /**
     * Delete all quote attachments that are not in list
     *
     * @param $user
     * @param $project
     * @param $quote
     * @param $attachments
     */
    function delete_quote_attachments_not_in_list($user, $project, $quote, $attachments)
    {
        $ids = [];
        foreach ($attachments as $attachment) {
            $ids[] = $attachment['id'];
        }

        $this->db->select('id, url');
        $this->db->from('quote_attachments');
        $this->db->where('quote_id', $quote);
        if (isset($ids) and is_array($ids) and count($ids) > 0) {
            $this->db->where_not_in('id', $ids);
        }
        $res = $this->db->get();
        if (isset($res)) {
            foreach ($res->result_array() as $attachment_to_delete) {
                $this->delete_quote_attachment($user, $project, $quote, $attachment_to_delete['id'], $attachment_to_delete['url']);
            }
        }
    }

    /**
     * Delete quote attachment from DB and file system
     *
     * @param $user
     * @param $project
     * @param $quote
     * @param $id
     * @param $url
     */
    function delete_quote_attachment($user, $project, $quote, $id, $url)
    {
        $this->db->where('id', $id);
        $this->db->delete('quote_attachments');
        $this->file_model->remove_quote_attachment($user, $project, $quote, '', $url);
    }

    /**
     * Insert/update milestone, return id
     *
     * @param $data
     * @param $project_id
     * @param $quote_id
     * @param $publish
     * @return int
     */
    function save_milestone($data, $project_id, $quote_id, $publish = FALSE)
    {
        // Extract non-db fields
        $attachments = [];
        if (array_key_exists('attachments', $data)) {
            $attachments = $data['attachments'];
            unset($data['attachments']);
        }
        if (array_key_exists('costs', $data)) {
            $costs = $data['costs'];
            unset($data['costs']);
        }

        // When publishing, set milestones added/deleted at current loop as added/deleted at previous loop
        if ($publish) {
            // Delete milestone if it was marked for deletion and not restored
            if ($data['is_deleted'] == 1 and $data['is_deleted_cur'] == 1) {
                $this->db->where('id', $data['id']);
                $this->db->delete('quote_milestones');
                return NULL;
            }
            $data['is_added'] = $data['is_added_cur'];
            $data['is_deleted'] = $data['is_deleted_cur'];
            $data['is_added_cur'] = 0;
            $data['is_deleted_cur'] = 0;
        }

        if (empty($data['id'])) {
            $data['id'] = NULL;
            $data['quote_id'] = $quote_id;
            $this->db->insert('quote_milestones', $data);
            $milestone_id = $this->db->insert_id();
        } else {
            $this->db->where('id', $data['id']);
            $this->db->update('quote_milestones', $data);
            $milestone_id = $data['id'];
        }

        // Milestone attachments
        $this->delete_quote_milestone_attachments_not_in_list($this->logged_in_user->id, $project_id, $quote_id, $milestone_id, $attachments);
        foreach ($attachments as $attachment) {
            if ($attachment['id'] == NULL or $attachment['id'] == '') {
                $url = '';
                if (array_key_exists('img_url', $attachment)) {
                    $url = $attachment['img_url'];
                    unset($attachment['img_url']);
                }

                $attachment['id'] = NULL;
                $attachment['quote_milestone_id'] = $milestone_id;
                $this->db->insert('quote_milestone_attachments', $attachment);
                if ($url == '') {
                    $this->file_model->move_temp_quote_file($this->logged_in_user->id, $attachment['url'], $project_id, $quote_id, $milestone_id);
                } else {
                    $this->file_model->copy_quote_file_from_path($this->logged_in_user->id, $url, $attachment['url'], $project_id, $quote_id, $milestone_id);
                }
            }
        }

        // Costs
        if (isset($costs) and is_array($costs) and array_key_exists('labor', $costs)) {
            $costs['labor']['quote_id'] = $quote_id;
            $costs['labor']['quote_milestone_id'] = $milestone_id;
            $costs['labor']['cost_type'] = 1;
            $this->save_cost($costs['labor']);
        }
        if (isset($costs) and is_array($costs) and array_key_exists('material', $costs)) {
            $costs['material']['quote_id'] = $quote_id;
            $costs['material']['quote_milestone_id'] = $milestone_id;
            $costs['material']['cost_type'] = 2;
            $this->save_cost($costs['material']);
        }
        if (isset($costs) and is_array($costs) and array_key_exists('third_party', $costs)) {
            $costs['third_party']['quote_id'] = $quote_id;
            $costs['third_party']['quote_milestone_id'] = $milestone_id;
            $costs['third_party']['cost_type'] = 3;
            $this->save_cost($costs['third_party']);
        }
        if (isset($costs) and is_array($costs) and array_key_exists('travel', $costs)) {
            $costs['travel']['quote_id'] = $quote_id;
            $costs['travel']['quote_milestone_id'] = $milestone_id;
            $costs['travel']['cost_type'] = 4;
            $this->save_cost($costs['travel']);
        }

        return $milestone_id;
    }

    /**
     * Delete all milestone attachments that are not in list
     *
     * @param $user
     * @param $project
     * @param $quote
     * @param $milestone
     * @param $attachments
     */
    function delete_quote_milestone_attachments_not_in_list($user, $project, $quote, $milestone, $attachments)
    {
        $ids = [];
        foreach ($attachments as $attachment) {
            $ids[] = $attachment['id'];
        }

        $this->db->select('id, url');
        $this->db->from('quote_milestone_attachments');
        $this->db->where('quote_milestone_id', $milestone);
        if (isset($ids) and is_array($ids) and count($ids) > 0) {
            $this->db->where_not_in('id', $ids);
        }
        $res = $this->db->get();
        if (isset($res)) {
            foreach ($res->result_array() as $attachment_to_delete) {
                $this->delete_quote_milestone_attachment($user, $project, $quote, $milestone, $attachment_to_delete['id'], $attachment_to_delete['url']);
            }
        }
    }

    /**
     * Delete milestone attachment from DB and file system
     *
     * @param $user
     * @param $project
     * @param $quote
     * @param $milestone
     * @param $id
     * @param $url
     */
    function delete_quote_milestone_attachment($user, $project, $quote, $milestone, $id, $url)
    {
        $this->db->where('id', $id);
        $this->db->delete('quote_milestone_attachments');
        $this->file_model->remove_quote_attachment($user, $project, $quote, $milestone, $url);
    }

    /**
     * Insert/update quote/milestone cost
     *
     * @param $data
     */
    function save_cost($data)
    {
        unset($data['vat_sum']);
        unset($data['total']);
        if ($data['amount'] == '') {
            $data['amount'] = 0;
        }
        if ($data['price'] == '') {
            $data['price'] = 0;
        }
        if ($data['vat'] == '') {
            $data['vat'] = 0;
        }
        if ($data['id'] == NULL or $data['id'] == '') {
            $data['id'] = NULL;
            $this->db->insert('quote_milestone_cost', $data);
        } else {
            $this->db->where('id', $data['id']);
            $this->db->update('quote_milestone_cost', $data);
        }
    }

    /**
     * Delete all quote milestones that are not in list
     *
     * @param $user
     * @param $project
     * @param $quote
     * @param $milestones
     */
    function delete_quote_milestones_not_in_list($user, $project, $quote, $milestones)
    {
        $this->db->select('id');
        $this->db->from('quote_milestones');
        $this->db->where('quote_id', $quote);
        if (isset($milestones) and is_array($milestones) and count($milestones) > 0) {
            $this->db->where_not_in('id', $milestones);
        }
        $res = $this->db->get();
        if (isset($res)) {
            foreach ($res->result_array() as $milestone_to_delete) {
                $this->delete_quote_milestone($user, $project, $quote, $milestone_to_delete['id']);
            }
        }
    }

    /**
     * Delete quote milestone from DB and file system
     *
     * @param $user
     * @param $project
     * @param $quote
     * @param $id
     */
    function delete_quote_milestone($user, $project, $quote, $id)
    {
        $this->db->where('id', $id);
        $this->db->delete('quote_milestones');
        $this->file_model->remove_quote($user, $project, $quote, $id);
    }

    /**
     * Delete quote by id
     *
     * @param $project
     * @param $id
     */
    function delete_quote($project, $id)
    {
        $this->db->where('id', $id);
        $this->db->delete('quotes');
        $this->file_model->remove_quote($this->logged_in_user->id, $project, $id);
    }

    /**
     * Sent quote request on machinery
     *
     * @param $machinery_id
     * @return int
     * @throws Exception
     */
    function send_quote_request($machinery_id)
    {
        $this->load->model('machinery_model');

        // Get provider
        $machinery = $this->machinery_model->get_machinery_by_id($machinery_id);
        if ($machinery == NULL) {
            throw new Exception(t('Machinery is not found'));
        }

        // Check if there is a request already
        $this->db->select('id');
        $this->db->from('quote_requests');
        $this->db->where('requester_id', $this->logged_in_user->id);
        $this->db->where('machinery_id', $machinery_id);
        $res = $this->db->get()->row();
        if (isset($res)) {
            throw new Exception(t('Quote request for this machinery already exists'));
        }

        // Create dummy project
        $data = [
            'id' => NULL,
            'job_name' => $machinery['title'],
            'job_status' => 8,
            'description' => $machinery['machine_description'],
            'creator_id' => $this->logged_in_user->id,
            'created' => get_est_time(),
			'due_date' => 0,
            'category' => $machinery['categories'],
            'portfolio_id' => $machinery['id'],
			'budget_min' => $machinery['price'],
			'budget_max' => $machinery['price']
        ];
        // Attachments
        if (array_key_exists('attachments', $machinery) and is_array($machinery['attachments'])) {
            $data['attachments'] = [];
            foreach ($machinery['attachments'] as $attachment) {
                $data['attachments'][] = [
                    'id' => NULL,
                    'job_id' => NULL,
                    'name' => $attachment['ori_name'],
                    'url' => $attachment['name'] . $attachment['ext'],
                    'img_url' => $attachment['url']
                ];
            }
        }
        $job = $this->project_model->save_project($data);

        // Send request
        $data = [
            'job_id' => $job['id'],
            'machinery_id' => $machinery_id,
            'requester_id' => $this->logged_in_user->id,
            'requestee_id' => $machinery['user_id'],
            'created' => get_est_time()
        ];
        $this->db->insert('quote_requests', $data);
        $id = $this->db->insert_id();

        // Notify
        $this->email_model->prepare(
            'quote_request',
            $machinery['user_id'],
            [
                '!username' => $this->user_model->get_name($machinery['user_id']),
                '!entrepreneur' => $this->logged_in_user->full_name,
                '!machinery_title' => $machinery['title'],
                '!url' => site_url('project/quote?id=' . $job['id'])
            ]
        );
        /*$this->notification_model->add(
            'quote_request',
            $machinery['user_id'],
            site_url('project/quote?id='.$job['id']),
            [
                '!entrepreneur' => $this->logged_in_user->full_name
            ]
        );*/

        return $id;
    }

    /**
     * Assign tender to provider
     *
     * @param $project_id
     * @param $provider_id
     * @return bool
     */
    function assign_quote($project_id, $provider_id)
    {
        $quote_id = $this->get_latest_quote_id($project_id, $provider_id);
        if ($quote_id == NULL or $quote_id == -1) {
            return FALSE;
        }

        // Check that there are no assigned quotes for this project
        $this->db->select('count(*) as cnt');
        $this->db->from('quotes');
        $this->db->where('job_id', $project_id);
        $this->db->where('status', 3);
        $res = $this->db->get()->row();
        if (isset($res) and $res->cnt > 0) {
            return FALSE;
        }

        // Check that quote can be assigned
        $this->db->select('job_status, creator_id');
        $this->db->from('jobs');
        $this->db->where('id', $project_id);
        $res = $this->db->get()->row();
        if (!isset($res) or $res->job_status != 2 or $res->creator_id != $this->logged_in_user->id) {
            return FALSE;
        }

        $this->db->select('creator_id');
        $this->db->from('quotes');
        $this->db->where('id', $quote_id);
        $res = $this->db->get()->row();
        if (!isset($res) or $res->creator_id == $this->logged_in_user->id) {
            return FALSE;
        }

        // Update quote
        $this->db->where('id', $quote_id);
        $this->db->update('quotes', ['status' => 3]);

        // Update project
        $this->db->where('id', $project_id);
        $this->db->update('jobs', ['job_status' => 3]);

        // Notify
        $project = $this->project_model->get_project_by_id($project_id);
        $this->email_model->prepare(
            'quote_accepted',
            $provider_id,
            [
                '!username' => $this->user_model->get_name($provider_id),
                '!project' => $project['job_name'],
                '!url' => site_url('project/project_list/2')
            ]
        );

        return TRUE;
    }

    /**
     * Accept quote
     *
     * @param $quote_id
     * @return bool
     * @throws Exception
     */
    function accept_quote($quote_id)
    {
        $this->load->model('finance_model');

        // Check that quote can be accepted
        $quote = $this->get_quote_by_id($quote_id);
        if (!isset($quote) or $quote['status'] != 3 or $quote['provider_id'] != $this->logged_in_user->id) {
            return FALSE;
        }
        // Check that escrow is paid if necessarily
        $escrow_due = $this->finance_model->get_quote_escrow_due($quote['job_id'], $quote_id, '', TRUE);
        $escrow_paid = $this->finance_model->get_project_payment_escrow($quote['job_id']);
        if ($escrow_paid < $escrow_due) {
            throw new Exception('Cannot start project: ' . currency() . number_format($escrow_due) . ' escrow required, ' . currency() . number_format($escrow_paid) . ' paid.');
        }

        $project = $this->project_model->get_project_by_id($quote['job_id']);

        // Open transaction
        $this->db->trans_start();

        // Update project
        $this->db->update(
            'jobs',
            [
                'job_name' => $quote['name'],
                'job_status' => 4,
                'description' => $quote['description'],
                'start_date' => get_est_time(),
                'due_date' => $quote['due_date'],
                'budget_min' => $quote['amount'],
                'budget_max' => $quote['amount'],
                'employee_id' => $this->logged_in_user->id
            ],
            ['id' => $quote['job_id']]
        );

        // Replace attachments
        $attachments = [];
        foreach ($quote['attachments'] as $attachment) {
            $attachments[] = [
                'id' => NULL,
                'name' => $attachment['name'],
                'url' => $attachment['url'],
                'img_url' => $attachment['img_url']
            ];
        }
        $this->project_model->save_attachments($attachments, $quote['job_id'], $project['creator_id']);

        // Replace milestones
        $this->db->where('job_id', $quote['job_id']);
        $this->db->delete('milestones');

        $prev_milestone = NULL;
        foreach ($quote['milestones'] as $quote_milestone) {
            $milestone = [
                'id' => NULL,
                'name' => $quote_milestone['name'],
                'description' => $quote_milestone['description'],
                'due_date' => $quote_milestone['due_date'],
                'amount' => $quote_milestone['amount'],
                'attachments' => []
            ];

            if ($prev_milestone == NULL) {
                $milestone['start_date'] = get_est_time();
            } else {
                $milestone['start_date'] = $prev_milestone['due_date'];
            }

            // Milestone attachments
            foreach ($quote_milestone['attachments'] as $attachment) {
                $milestone['attachments'][] = [
                    'id' => NULL,
                    'name' => $attachment['name'],
                    'url' => $attachment['url'],
                    'img_url' => $attachment['img_url']
                ];
            }

            // Save
            $this->project_model->save_milestone($milestone, $quote['job_id'], $project['creator_id']);

            $prev_milestone = $quote_milestone;
        }

        // Finalize
        $this->db->trans_complete();

        // Notify
        $this->email_model->prepare(
            'project_started',
            $project['creator_id'],
            [
                '!username' => $this->user_model->get_name($project['creator_id']),
                '!provider' => $this->logged_in_user->full_name,
                '!project' => $quote['name'],
                '!url' => site_url('project/view?id=' . $project['id'])
            ]
        );

        return TRUE;
    }

    /**
     * Returns single quote with all fields and child data
     *
     * @param $id
     * @return array
     */
    function get_quote_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('quotes');
        $this->db->where('id', $id);

        $res = $this->db->get();
        if (isset($res)) {
            $quote = $res->result_array()[0];
            $quote['attachments'] = $this->get_quote_attachments($quote['job_id'], $id, $quote['creator_id']);
            $quote['milestones'] = $this->get_quote_milestones($quote['job_id'], $id, $quote['creator_id']);
        } else {
            $quote = NULL;
        }

        return $quote;
    }

    /**
     * Reject quote
     *
     * @param $quote_id
     * @return bool
     */
    function reject_quote($quote_id)
    {
        // Check that quote can be rejected
        $this->db->select('job_id, status, provider_id');
        $this->db->from('quotes');
        $this->db->where('id', $quote_id);
        $res = $this->db->get()->row();
        if (!isset($res) or $res->status != 3 or $res->provider_id != $this->logged_in_user->id) {
            return FALSE;
        }

        // Update quote
        $this->db->where('id', $quote_id);
        $this->db->update('quotes', ['status' => 4]);

        // Update project
        $this->db->where('id', $res->job_id);
        $this->db->update('jobs', ['job_status' => 2]);

        // Notify
        $project = $this->project_model->get_project_by_id($res->job_id);
        $this->email_model->prepare(
            'quote_declined',
            $project['creator_id'],
            [
                '!username' => $this->user_model->get_name($project['creator_id']),
                '!provider' => $this->logged_in_user->full_name,
                '!project' => $project['job_name'],
            ]
        );

        return TRUE;
    }

    /**
     * Notify all users with higher quotes on this project and set "notify_lower"
     *
     * @param $project_id
     * @param $provider_id
     * @param $amount
     */
    function notify_lower($project_id, $provider_id, $amount)
    {
        $this->db->select('provider_id');
        $this->db->distinct();
        $this->db->from('quotes');
        $this->db->where('job_id', $project_id);
        $this->db->where('provider_id != ', $provider_id);
        $this->db->where('notify_lower = 1');
        $this->db->where('amount > ', $amount);
        $res = $this->db->get()->result_array();
        $project = $this->project_model->get_project_by_id($project_id);
        foreach ($res as $user) {
            $this->email_model->prepare(
                'quote_lower',
                $user['provider_id'],
                [
                    '!username' => $this->user_model->get_name($user['provider_id']),
                    '!project' => $project['job_name']
                ]
            );
        }
    }
}