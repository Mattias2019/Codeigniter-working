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

class Team_model extends CI_Model
{
//    public $logged_in_user;
    const STATUS_ACTIVE = 1;
    const STATUS_NEED_ACTIVATE = 0;

    function __construct()
    {
        parent::__construct();

        // Load models
        $this->load->model('common_model');
        $this->load->model('file_model');
        $this->load->model('user_model');
        $this->load->model('email_model');

        // Load helpers
        $this->load->helper('url');

//        $this->logged_in_user = $this->common_model->get_logged_in_user();
    }

    /**
     * Get team for leader/admin
     *
     * @param $user_id
     * @param $name
     * @param $group
     * @param $email
     * @param $limit
     * @param $order_by
     * @param $leader_only
     * @return array
     */
    function get_team_members($user_id, $name = '', $group = '', $email = '', $limit = '', $order_by = '', $leader_only = FALSE)
    {
        $admin_groups = $this->get_groups_by_user($user_id);

        $this->db->select("m.id, m.user_id, IF(u.first_name != '' OR u.last_name != '', concat(u.first_name, ' ', u.last_name), u.user_name) as full_name, u.logo, u.email, g.group_name, m.telephone, m.job_title");
        $this->db->from('team_members as m');
        $this->db->join('team_groups as g', 'm.group_id = g.id');
        $this->db->join('users as u', 'm.user_id = u.id');
        // User is admin
        if (!$leader_only and count($admin_groups) > 0) {
            $this->db->where_in('g.id', $admin_groups);
        } // User is team leader
        else {
            $this->db->where('m.team_leader_id', $user_id);
            $this->db->where('g.team_leader_id', $user_id);
        }

        $this->db->where('m.status', self::STATUS_ACTIVE);
        if ($name != '') {
            $this->db->like("IF(u.first_name != '' OR u.last_name != '', concat(u.first_name, ' ', u.last_name), u.user_name)", $name);
        }
        if ($group != '') {
            $this->db->where('g.id', $group);
        }
        if ($email != '') {
            $this->db->like('u.email', $email);
        }
        $this->db->where('m.user_id !=' . $this->logged_in_user->id);
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
            $this->db->order_by('full_name', 'asc');
        }

        $res = $this->db->get()->result_array();

        $sql = $this->db->last_query();
        $count = count($res);
        for ($i = 0; $i < $count; $i++) {
            $res[$i]['img_logo'] = $this->file_model->get_user_logo_path($res[$i]['user_id'], $res[$i]['logo']);
        }
        return $res;
    }

    /**
     * Get single member info
     *
     * @param $id
     * @return array
     */
    function get_team_member_by_id($id)
    {
        $this->db->select("m.id, m.user_id,IF(u.first_name != '' OR u.last_name != '', concat(u.first_name, ' ', u.last_name), u.user_name) as name, m.team_leader_id, m.group_id, u.email, m.telephone, m.job_title");
        $this->db->from('team_members as m');
        $this->db->join('users as u', 'm.user_id = u.id');
        $this->db->where('m.id', $id);
        $res = $this->db->get()->result_array();
        if (count($res) > 0) {
            return $res[0];
        } else {
            return NULL;
        }
    }

    /**
     * Get single member info
     *
     * @param $id
     * @return array
     */
    function get_team_member_by_user_id($id)
    {
        $this->db->select("m.id, IF(u.first_name != '' OR u.last_name != '', concat(u.first_name, ' ', u.last_name), u.user_name) as name, m.team_leader_id, m.group_id, u.email, m.telephone, m.job_title");
        $this->db->from('team_members as m');
        $this->db->join('users as u', 'm.user_id = u.id');
        $this->db->where('m.user_id', $id);
        $res = $this->db->get()->result_array();
        if (count($res) > 0) {
            return $res[0];
        } else {
            return NULL;
        }
    }

    /**
     * Get team online for sidebar
     *
     * @param $user
     * @return array
     * @throws Exception
     */
    function get_team_online($user)
    {
        $leader = $this->get_team_leader($user);

        $this->db->select("u.id, IF(u.first_name != '' OR u.last_name != '', CONCAT(u.first_name, ' ', u.last_name), u.user_name) AS name, u.logo");
        $this->db->from('team_members AS t');
        $this->db->join('users AS u', 'u.id = t.user_id');
        $this->db->where('t.team_leader_id', $leader);
        $this->db->where('t.user_id != ', $user);
        $res = $this->db->get();
        if (!$res) {
            throw_db_exception();
        }
        $res = $res->result_array();
        $count = count($res);
        for ($i = 0; $i < $count; $i++) {
            if ($res[$i]['id'] == $user) {
                unset($res[$i]);
            }
            $res[$i]['img_logo'] = $this->file_model->get_user_logo_path($res[$i]['id'], $res[$i]['logo']);
            $res[$i]['is_online'] = $this->user_model->is_online($res[$i]['id']);
        }

        return $res;
    }

    function get_group_by_id($group_id)
    {
        $group = [];
        $rows = $this->db->get_where('team_groups', ['id' => $group_id])->result_array();
        if (count($rows) > 0) {
            $group = $rows[0];
        }
        return $group;
    }

    function get_user_groups($user_id, $group_id = null)
    {

        // Get all groups where USER_ID is team lead
        $this->db->select('c.*')
            ->from('team_groups c')
            ->where('c.team_leader_id', $user_id);
        if (!empty($group_id)) {
            $this->db->where('c.id', $group_id);
        }
        $select1 = $this->db->get_compiled_select();


        // Get all team_leaders where USER_ID is admin
        $this->db
            ->select('a.team_leader_id')
            ->from('team_members b, team_groups a')
            ->where('b.group_id = a.id')
            ->where('b.user_id', $user_id)
            ->where('a.admin', 1);
        if (!empty($group_id)) {
            $this->db->where('a.id', $group_id);
        }
        $select2 = $this->db->get_compiled_select();

        // Get all groups of all team_leaders where USER_ID is admin
        $this->db->select('c.*')
            ->from('team_groups c')
            ->where("c.team_leader_id in ($select2)", null, false);
        $select3 = $this->db->get_compiled_select();

        $items = $this->db->query($select1 . " UNION " . $select3 . " ORDER BY position")->result_array();

        $sql = $this->db->last_query();
        $result = [];
        foreach ($items as $item) {
            $groupId = $item['id'];
            $this->db->select('count(*) as cnt')
                ->from('team_members')
                ->where('group_id', $groupId)
                ->where('user_id !=' . $this->logged_in_user->id);
            $count = $this->db->get()->row()->cnt;

            $member = $this->find_group_members_by_group($groupId, $user_id);

            $result[] = [
                "id" => $groupId,
                "team_leader_id" => $item['team_leader_id'],
                "count_members" => $count,
                "group_name" => $item['group_name'],
                "is_locked" => ifset($item, 'is_locked', 0),
                "lock_class" => $item['is_locked'] == 1 ? 'locked' : '',
                "is_i_team_lead" => $member == null ? false : $member['team_leader_id'] == $member['user_id'],
                "options" => [
                    "admin" => ifset($item, 'admin', 0),
                    "quotes_create" => ifset($item, 'quotes_create', 0),
                    "quotes_edit_all" => ifset($item, 'quotes_edit_all', 0),
                    "quotes_edit_own" => ifset($item, 'quotes_edit_own', 0),
                    "projects_all" => ifset($item, 'projects_all', 0),
                    "projects_assigned" => ifset($item, 'projects_assigned', 0),
                    "projects_own" => ifset($item, 'projects_own', 0),
                    "portfolio_create" => ifset($item, 'portfolio_create', 0),
                    "portfolio_edit_all" => ifset($item, 'portfolio_edit_all', 0),
                    "portfolio_edit_own" => ifset($item, 'portfolio_edit_own', 0),
                    "portfolio_view" => ifset($item, 'portfolio_view', 0)
                ]
            ];
        }
        return $result;
    }

    function move_group_position($group)
    {
        $this->db->select('*');
        $this->db->from('team_groups');
        $this->db->where('team_leader_id', $group['team_leader_id']);
        $this->db->order_by('position DESC');
        $items = $this->db->get()->result_array();

        for ($i = 0; $i < count($items); $i++) {
            $item = $items[$i];
            $nextItem = $i + 1 >= count($items) ? $items[0] : $items[$i + 1];
            if ($item['position'] == $group['position']) {
                $nextIndex = $nextItem['position'];
                $nextItem['position'] = $group['position'];
                $group['position'] = $nextIndex;
                $this->db->update('team_groups', $group, ['id' => $group['id']]);
                $this->db->update('team_groups', $nextItem, ['id' => $nextItem['id']]);
                break;
            }
        }
    }


    /**
     * Get groups for leader/admin
     *
     * @param $user_id
     * @param $id
     * @return array
     */
    function get_groups($user_id, $id = '')
    {
        // Leader
        $this->db->select('*');
        $this->db->from('team_groups');
        $this->db->where('team_leader_id', $user_id);
        $this->db->order_by('position, id');
        if ($id != '') {
            $this->db->where('id', $id);
        }
        $res = $this->db->get()->result_array();
        if (count($res) == 0) {
            // Admin
            $this->db->select('g.*');
            $this->db->from('team_members as m');
            $this->db->join('team_groups as g', 'm.group_id = g.id');
            $this->db->where('m.user_id', $user_id);
            $this->db->where('g.admin', 1);
            $this->db->order_by('g.position, g.id');
            if ($id != '') {
                $this->db->where('g.id', $id);
            }
            $res = $this->db->get()->result_array();
        }

        $count = count($res);
        for ($i = 0; $i < $count; $i++) {
            $this->db->select('count(*) as cnt');
            $this->db->from('team_members');
            $this->db->where('group_id', $res[$i]['id']);
            $res2 = $this->db->get()->row();
            if (isset($res2)) {
                $res[$i]['members'] = $res2->cnt;
            } else {
                $res[$i]['members'] = 0;
            }
        }

        return $res;
    }

    /**
     * Get all groups with specific permissions which user is member of
     *
     * @param $user_id
     * @param $admin
     * @param $quotes
     * @param $projects
     * @param $portfolio
     * @return array
     */
    function get_groups_by_user($user_id, $admin = '', $quotes = '', $projects = '', $portfolio = '')
    {
        $this->db->select('g.id');
        $this->db->from('team_members as m');
        $this->db->join('team_groups as g', 'm.group_id = g.id');
        $this->db->where('m.user_id', $user_id);
        $this->db->order_by('g.position, g.id');
        if ($admin != '') {
            $this->db->where('g.admin', $admin);
        }
        if ($quotes != '') {
            $this->db->where('g.quotes', $quotes);
        }
        if ($projects != '') {
            $this->db->where('g.projects', $projects);
        }
        if ($portfolio != '') {
            $this->db->where('g.portfolio', $portfolio);
        }
        $res = $this->db->get()->result_array();
        $groups = [];
        foreach ($res as $group) {
            $groups[] = $group['id'];
        }
        return $groups;
    }

    /**
     * Get team leader for user, or user if there is not one
     *
     * @param $user
     * @return int
     */
    function get_team_leader($user)
    {
        // Check for team leader
        $this->db->select('team_leader_id');
        $this->db->from('team_members');
        $this->db->where('user_id', $user);
        $res = $this->db->get()->row();
        if (isset($res)) {
            return $res->team_leader_id;
        } else {
            return $user;
        }
    }

    function find_group_members_by_group($group_id, $user_id)
    {
        $this->db->select('*');
        $this->db->from('team_members');
        $this->db->where('group_id', $group_id);
        $this->db->where('user_id', $user_id);
        $res = $this->db->get()->result_array();
        if (count($res) > 0) {
            return $res[0];
        }
        return null;
    }

    /**
     * Insert/update team member
     *
     * @param $data
     * @return int
     */
    function save_team_member($data)
    {
        $member = $this->find_group_members_by_group($data['group_id'], $data['user_id']);
        if (empty($member)) {
            $this->db->insert('team_members', $data);
            return $this->db->insert_id();
        } else {
            $this->db->update('team_members', $data, ['id' => $member['id']]);
            return $member['id'];
        }
    }

    /**
     * Delete team member
     *
     * @param $id
     */
    function deleteTeamMemberByMyGroups($user_id)
    {
        $this->db->delete('team_members', ['user_id' => $user_id, 'team_leader_id' => $this->logged_in_user->id]);
    }

    /**
     * Delete team member
     *
     * @param $id
     */
    function delete_team_member($id)
    {
        $this->db->delete('team_members', ['id' => $id]);
    }

    /**
     * Insert/update group
     *
     * @param $data
     * @param $user_id team leader id
     * @return int
     */
    function save_group($data, $user_id)
    {
        if (empty($data['id'])) {
            $data['team_leader_id'] = $user_id;
            $this->db->select('max(position) as maxPosition, count(id) as cnt')
                ->from('team_groups')
                ->where('team_leader_id', $user_id);
            $row = $this->db->get()->row();
            $data['position'] = $row->cnt == 0 ? 1 : $row->maxPosition + 1;
            $this->db->insert('team_groups', $data);
            $data['id'] = $this->db->insert_id();
        } else {
            $this->db->update('team_groups', $data, ['id' => $data['id']]);
        }
        return $data;
    }

    /**
     * Delete group
     *
     * @param $id
     */
    function delete_group($id)
    {
        $this->db->delete('team_groups', ['id' => $id]);
    }

    public static function generateToken()
    {
        return sha1(uniqid() . time());
    }


    /*
     * send email to invite user
     *
     */
    public function sendEmailToInvitationUserToTeam($data = array())
    {

        $activation_url = '<a href="'.site_url('team/confirm/' . $data['token']).'">Click here to continue signup process</a>';
        $contact_url = '<a href="'.site_url('home/support').'">'.site_url('home/support').'</a>';

        $mail = $this->email_model->get_mail('invite_supplier_user', [
            "!site_title" => $this->config->item('site_title'),
            "!from" => $data['from'],
            "!company" => $data['company'],
            "!activation_url" => $activation_url,
            "!contact_url" => $contact_url,
            "!job_title" => $data['job_title'],
            "!telephone" => $data['telephone'],
        ]);

        $this->email_model->custom(
            $data['user_id'],
            $mail['subject'],
            $mail['body'],
            [],
            true
        );
        return;
    }

    /*
     * find users id, who in team
     */

    public function findUserIdOnTeamLead($teamLead)
    {
        $datas = [];
        $this->db->select("*");
        $this->db->from('team_members');
        $this->db->where('team_leader_id', $teamLead);
        $rows = $this->db->get()->result_array();
        $datas = [];
        foreach ($rows as $k => $r) {
            $datas[(int)$r['user_id']] = (int)$r['user_id'];
        }

        return $datas;
    }

    public function confirmTeamByKey($key)
    {
        $this->db->select("*");
        $this->db->from('team_members');
        $this->db->where('token', $key);
        $result = $this->db->get()->row_array();
        if (empty($result['id'])) {
            return false;
        }
        $data = array(
            'status' => Team_model::STATUS_ACTIVE,
        );

        $this->db->where('id', $result['id']);
        $this->db->update('team_members', $data);
        return true;
    }
}