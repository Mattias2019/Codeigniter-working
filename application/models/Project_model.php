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

class Project_model extends CI_Model
{
    public $logged_in_user;

	const PROJECT_STATUS_DRAFT = 0;
	const PROJECT_STATUS_NEW = 1;
	const PROJECT_STATUS_PENDING = 2;
	const PROJECT_STATUS_PLACED = 3;
	const PROJECT_STATUS_ACTIVE = 4;
	const PROJECT_STATUS_COMPLETED = 5;
	const PROJECT_STATUS_CANCELED = 6;
	const PROJECT_STATUS_DECLINED = 7;
	const PROJECT_STATUS_QUOTE_REQUEST = 8;
    const PROJECT_STATUS_ARCHIVE = 9;

    function __construct()
    {
        parent::__construct();

        // Load Language
        load_lang('enduser/job');

        // Load models
        $this->load->model('common_model');
        $this->load->model('cancel_model');
        $this->load->model('file_model');

        $this->load->helper('db');

        $this->logged_in_user = $this->common_model->get_logged_in_user();
    }

    /* Reading projects from database */

    /**
     * Checks if there is project with given name
     *
     * @param $project_name
     * @return bool
     */
    function project_exists($project_name)
    {
        $this->db->select('1');
        $this->db->from('jobs');
        $this->db->where('job_name', $project_name);
        $res = $this->db->get();
        return isset($res);
    }

    /**
     * Returns single project with all fields and child data
     *
     * @param $id
     * @return array
     */
    function get_project_by_id($id, $child = true)
    {
        $this->db->select('*');
        $this->db->from('jobs');
        $this->db->where('id', $id);

        $res = $this->db->get()->result_array();
        if (isset($res) and count($res) > 0) {
            $project = $res[0];
            if ($child) {
                $project['status'] = $this->get_project_status($project['id']);
                $project['country_name'] = $this->common_model->get_country($project['country'])['country_name'];
                $project['attachments'] = $this->get_project_attachments($id, $project['creator_id']);
                $project['milestones'] = $this->get_project_milestones($id, $project['creator_id']);
                $project['categories_all'] = $this->get_project_categories($id);
                $project['categories'] = [];
                $categories_count = count($project['categories_all']);
                for ($i = 0; $i < $categories_count; $i++) {
                    $project['categories'][$i] = $project['categories_all'][$i]['category_id'];
                }
            }
        } else {
            $project = NULL;
        }

        return $project;
    }

    function check_project_access($project_id, $user_id)
    {
        $this->db->select('1');
        $this->db->from('jobs as j');
        $this->db->where('j.id',$project_id);

        $user_id = $this->db->escape($user_id);

        $this->avaible_tender_projects($user_id);

        $res = $this->db->get()->row();
        if (isset($res)) {
            return $res;
        } else {
            return array();
        }
    }

    /**
     * Returns the list of all milestones for project
     *
     * @param $id
     * @return array
     */
    function get_milestone_by_id($id, $child = true)
    {
        $this->db->select('*');
        $this->db->from('milestones');
        $this->db->where('id', $id);

        $res = $this->db->get()->result_array();
        if (isset($res) and count($res) > 0) {
            $milestone = $res[0];
            if ($child) {
                $milestone['attachments'] = $this->get_milestone_attachments($milestone['job_id'], $id, NULL);
            }
        } else {
            $milestone = NULL;
        }

        return $milestone;
    }

    /**
     * Return project name only
     *
     * @param $id
     * @return string
     */
    function get_project_name($id)
    {
        $this->db->select('job_name');
        $this->db->from('jobs');
        $this->db->where('id', $id);
        $res = $this->db->get()->row();
        if (isset($res)) {
            return $res->job_name;
        } else {
            return '';
        }
    }

    /**
     * Returns all projects that user created, works on, or placed quotes upon
     *
     * @param $user_id
     * @param $editable_only
     * @param array $statuses
     * @return array
     */
    function get_user_projects($user_id, $editable_only = FALSE, $statuses = [])
    {
        $this->db->select('*');
        $this->db->from('jobs');
        $user_id = $this->db->escape($user_id);
        $this->db->where('creator_id = ' . $user_id . ' OR employee_id = ' . $user_id .
			' OR exists (select 1 from quotes where job_id = jobs.id and provider_id = ' . $user_id . ') ' .
			' OR exists (select 1 from quote_requests where job_id = jobs.id and requestee_id = ' . $user_id . ')');
        if ($editable_only) {
            $this->db->where('job_status < 3');
        }
        if (is_array($statuses) and count($statuses) > 0) {
            $this->db->where_in('job_status', $statuses);
        }

        // order by additional payment options
        $this->db->order_by('ifnull(is_urgent,0) DESC, ifnull(is_feature,0) DESC');

        $res = $this->db->get()->result_array();
        if (isset($res)) {
            return $res;
        } else {
            return [];
        }
    }

    /**
     * Returns new published projects for supplier
     *
     * @param array $categories
     * @param int $budget_min
     * @param int $budget_max
     * @param array $limit
     * @param array $order_by
     * @param string $project_name
	 * @param int $project_id
     * @return array
     */
    function get_new_projects($categories = [], $budget_min = 0, $budget_max = 0, $limit = [], $order_by = [], $keyword = '', $project_id = NULL)
    {
        $this->load->model('quote_model');

        $this->db->select('j.*, c.country_name, IFNULL(MAX(q.created), j.created) AS last_quote ');
        $this->db->from('jobs as j');
        $this->db->join('users AS u', 'j.creator_id = u.id', 'left');
        $this->db->join('country AS c', 'j.country = c.id', 'left');
        if($this->logged_in_user)
            $this->db->join('quotes AS q', 'q.job_id = j.id AND q.provider_id = ' . $this->logged_in_user->id, 'left');
        else
            $this->db->join('quotes AS q', 'q.job_id = j.id ', 'left');


        if (empty($project_id))
		{
			$this->db->where_in('j.job_status', ['2', '3']);
		}
		else
		{
			$this->db->where('j.id', $project_id);
		}
		$this->db->where('(j.enddate = 0 OR j.enddate > '.get_est_time().')');
        $this->db->group_by('j.id');

        if (is_array($categories) and count($categories) > 0) {
            $this->db->join('job_categories as jc', 'j.id = jc.job_id', 'left');
            $this->db->where_in('jc.category_id', $categories);
        }

        if (isset($budget_min) && $budget_min > 0) {
            $this->db->where('j.budget_min >=', $budget_min);
        }
        if (isset($budget_max) && $budget_max > 0) {
            $this->db->where('j.budget_max <=', $budget_max);
        }

        if ($keyword != '') {
            $this->db->where('
            ( lower(c.country_name) like "%' . strtolower($keyword) . '%" 
             OR
              lower(j.city) like "%' . strtolower($keyword) . '%" 
             OR 
              lower(u.first_name) like "%' . strtolower($keyword) . '%"
             OR 
              lower(u.last_name) like "%' . strtolower($keyword) . '%"
             OR 
              lower(u.user_name) like "%' . strtolower($keyword) . '%"
             OR
              concat(first_name, " ", last_name) like "%' . strtolower($keyword) . '%"
             OR
              lower(j.job_name) like "%' . strtolower($keyword) . '%" 
             OR 
              exists (select 1 
                        from job_categories jc, categories ca, groups g 
                       where jc.category_id = ca.id 
                         and ca.group_id = g.id
                         and jc.job_id = j.id 
                         and ( lower(g.group_name) like "%' . strtolower($keyword) . '%"
                              or 
                               lower(ca.category_name) like "%' . strtolower($keyword) . '%" 
                             )
                       )
            )');
        }

        // private projects
        if($this->logged_in_user) $this->check_is_private($this->logged_in_user->id);

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

        // order by additional payment options
        $this->db->order_by('ifnull(j.is_urgent,0) DESC, ifnull(j.is_feature,0) DESC');

        if (is_array($order_by) and count($order_by) == 2 and $order_by[0] != '') {
            $this->db->order_by($order_by[0], $order_by[1]);
        } else {
            $this->db->order_by('last_quote', 'DESC');
        }

        $res = $this->db->get();
        if (isset($res)) {
            $projects = $res->result_array();
        } else {
            $projects = [];
        }

        // Additional fields
        $projects_count = count($projects);
        for ($i = 0; $i < $projects_count; $i++) {
            $projects[$i]['categories'] = $this->get_project_categories($projects[$i]['id']);
            $status = $this->get_project_status($projects[$i]['id']);
            $projects[$i]['status_name'] = $status['name'];
            $projects[$i]['status_class'] = $status['class'];
            $projects[$i]['quotes'] = $this->quote_model->get_placed_quotes($projects[$i]['id']);
            $projects[$i]['last_quote'] = $this->quote_model->get_latest_quote($projects[$i]['id']);

            // Creator
            $projects[$i]['creator_name'] = $this->user_model->get_name($projects[$i]['creator_id']);
        }

        return $projects;
    }

    /**
     * Get new published projects for supplier (count for sidebar)
     *
     * @param $user_id
     * @return int;
     */
    function get_new_projects_count($user_id)
    {
        $this->db->select('count(DISTINCT j.id) AS cnt');
        $this->db->from('jobs AS j');
		$this->db->join('quotes AS q', 'q.job_id = j.id AND q.provider_id = ' . $this->logged_in_user->id, 'left');
        $this->db->where_in('j.job_status', ['2', '3']);
		$this->db->where('j.enddate = 0 OR j.enddate > '.get_est_time());

        // private projects
        $this->check_is_private($this->logged_in_user->id);

        $res = $this->db->get()->row();
        if (isset($res)) {
            return $res->cnt;
        } else {
            return 0;
        }
    }

    function check_is_private($user_id)
    {

        $this->db->where(
            '( ifnull(j.is_private,0) = 0 ' .
                 'or ' .
                  '(  ifnull(j.is_private,0) = 1 ' .
                   'and ' .
                     'exists (select 1 from job_invitation ji where ji.job_id = j.id and ji.receiver_id = '.$user_id.') ' .
                  ') ' .
                ')'
        );

        return $this;
    }

    /**
     * Returns tender projects for entrepreneur
     *
     * @param $user_id
     * @param array $limit
     * @param array $order_by
	 * @param int $project_id
     * @return array
     */
    function get_tender_projects($user_id, $limit = [], $order_by = [], $project_id = NULL)
    {
        $this->db->select('j.id, j.job_name, j.job_status, j.budget_min, j.budget_max, j.enddate, j.due_date, ' .
            'j.is_feature, is_urgent, is_hide_bids, is_private, ' .
            'j.portfolio_id, count(q.id) as quotes_count, min(q.amount) as quotes_min, avg(q.amount) as quotes_avg, ' .
            'max(q.amount) as quotes_max, IFNULL(max(q.created), j.created) as last_quote'
        );
        $this->db->from('jobs as j');
        $this->db->join('quotes as q', 'j.id = q.job_id and q.status in (2, 3) and loop = (select max(q1.loop) from quotes as q1 where q.job_id = q1.job_id and q.provider_id = q1.provider_id and q1.status in (2, 3))', 'left');
        if (empty($project_id))
		{
			$this->db->where_in('j.job_status', [self::PROJECT_STATUS_DRAFT, self::PROJECT_STATUS_NEW, self::PROJECT_STATUS_PENDING, self::PROJECT_STATUS_QUOTE_REQUEST]);
		}
		else
		{
			$this->db->where('j.id', $project_id);
		}
        $this->avaible_tender_projects($user_id);
//        $this->db->where('( j.creator_id = '.$user_id.' '.
//                              'or ' .
//                               'exists (select 1 '.
//                                         'from team_members tm, team_groups tg '.
//		                                'where tm.group_id = tg.id '.
//                                          'and tm.team_leader_id = j.creator_id '.
//                                          'and tm.user_id = '.$user_id.' '.
//                                          'and (tg.admin = 1 or tg.quotes_edit_all = 1) '.
//                                      ')'.
//                             ') '
//        );
        $this->db->group_by('j.id, j.job_name, j.job_status, j.budget_min, j.budget_max, j.enddate, j.due_date, j.portfolio_id, ' .
            'j.is_feature, is_urgent, is_hide_bids, is_private '
        );

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

        // order by additional payment options
        $this->db->order_by('ifnull(j.is_urgent,0) DESC, ifnull(j.is_feature,0) DESC');

        if (is_array($order_by) and count($order_by) == 2 and $order_by[0] != '') {
            $this->db->order_by($order_by[0], $order_by[1]);
        } else {
            $this->db->order_by('last_quote', 'DESC');
        }

        $res = $this->db->get();

        if (isset($res)) {
            $projects = $res->result_array();
        } else {
            $projects = [];
        }

        // Additional fields
        $projects_count = count($projects);
        for ($i = 0; $i < $projects_count; $i++) {
            $projects[$i]['status'] = $this->get_project_status($projects[$i]['id']);

            // Quotes
            if ($projects[$i]['quotes_count'] > 0) {
                $projects[$i]['quotes'] = $this->quote_model->get_placed_quotes($projects[$i]['id']);
            } else {
                $projects[$i]['quotes'] = [];
            }
        }

        return $projects;
    }

    /**
     * Returns tender projects for entrepreneur
     *
     * @param $user_id
     * @param array $limit
     * @param array $order_by
     * @return array
     */
    function get_tender_projects_all($user_id, $limit = [], $order_by = [])
    {
        $this->db->select('j.id, j.job_name, j.description, j.job_status, j.budget_min, j.budget_max, j.enddate, j.due_date, q.amount');
        $this->db->from('jobs as j');
        $this->db->join('quotes as q', 'j.id = q.job_id and q.status in (2, 3) and loop = (select max(q1.loop) from quotes as q1 where q.job_id = q1.job_id and q.provider_id = q1.provider_id and q1.status in (2, 3))');
		$this->db->where_in('j.job_status', [self::PROJECT_STATUS_DRAFT, self::PROJECT_STATUS_NEW, self::PROJECT_STATUS_PENDING, self::PROJECT_STATUS_QUOTE_REQUEST]);
        $this->db->where('j.creator_id', $user_id);

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

        // order by additional payment options
        $this->db->order_by('ifnull(j.is_urgent,0) DESC, ifnull(j.is_feature,0) DESC');

        if (is_array($order_by) and count($order_by) == 2) {
            $this->db->order_by($order_by[0], $order_by[1]);
        } else {
            $this->db->order_by('j.id', 'desc');
        }

        $res = $this->db->get();
        if (isset($res)) {
            $projects = $res->result_array();
        } else {
            $projects = [];
        }

        // Additional fields
        $projects_count = count($projects);
        for ($i = 0; $i < $projects_count; $i++) {
            $projects[$i]['status'] = $this->get_project_status($projects[$i]['id']);
        }

        return $projects;
    }

    /**
     * Get tender projects for entrepreneur (count for sidebar)
     *
     * @param $user_id
     * @return int;
     */
    function get_tender_projects_count($user_id)
    {
        $this->db->select('count(*) AS cnt');
        $this->db->from('jobs as j');
		$this->db->where_in('j.job_status', [self::PROJECT_STATUS_DRAFT, self::PROJECT_STATUS_NEW, self::PROJECT_STATUS_PENDING, self::PROJECT_STATUS_QUOTE_REQUEST]);
//		$this->db->where('j.creator_id', $user_id);
        $this->avaible_tender_projects($user_id);
        $res = $this->db->get()->row();
        if (isset($res)) {
            return $res->cnt;
        } else {
            return 0;
        }
    }

    /**
     * Get quote requests for current user
     *
     * @param $categories
     * @param $budget_min
     * @param $budget_max
     * @param $limit
     * @param $order_by
     * @return array
     */
    function get_requested_projects($categories, $budget_min, $budget_max, $limit, $order_by, $keyword)
    {
        $this->load->model('quote_model');

        $this->db->select('j.*, c.country_name, q.machinery_id');
        $this->db->from('jobs as j');
        $this->db->join('quote_requests as q', 'j.id = q.job_id');
        $this->db->join('users AS u', 'j.creator_id = u.id', 'left');
        $this->db->join('country AS c', 'j.country = c.id', 'left');
        $this->db->where('j.job_status', self::PROJECT_STATUS_QUOTE_REQUEST);
        $this->db->where('q.requestee_id', $this->logged_in_user->id);

        if (is_array($categories) and count($categories) > 0) {
            $this->db->join('job_categories as jc', 'j.id = jc.job_id');
            $this->db->where_in('jc.category_id', $categories);
        }

        if (isset($budget_min) && $budget_min > 0) {
            $this->db->where('j.budget_min >=', $budget_min);
        }
        if (isset($budget_max) && $budget_max > 0) {
            $this->db->where('j.budget_max <=', $budget_max);
        }

        if ($keyword != '') {
            $this->db->where('
            ( lower(c.country_name) like "%' . strtolower($keyword) . '%" 
             OR
              lower(j.city) like "%' . strtolower($keyword) . '%" 
             OR 
              lower(u.first_name) like "%' . strtolower($keyword) . '%"
             OR 
              lower(u.last_name) like "%' . strtolower($keyword) . '%"
             OR 
              lower(u.user_name) like "%' . strtolower($keyword) . '%"
             OR
              concat(first_name, " ", last_name) like "%' . strtolower($keyword) . '%"
             OR
              lower(j.job_name) like "%' . strtolower($keyword) . '%" 
             OR 
              exists (select 1 
                        from job_categories jc, categories ca, groups g 
                       where jc.category_id = ca.id 
                         and ca.group_id = g.id
                         and jc.job_id = j.id 
                         and ( lower(g.group_name) like "%' . strtolower($keyword) . '%"
                              or 
                               lower(ca.category_name) like "%' . strtolower($keyword) . '%" 
                             )
                       )
            )');
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

        // order by additional payment options
        $this->db->order_by('ifnull(j.is_urgent,0) DESC, ifnull(j.is_feature,0) DESC');

        if (is_array($order_by) and count($order_by) == 2) {
            $this->db->order_by($order_by[0], $order_by[1]);
        } else {
            $this->db->order_by('j.id', 'desc');
        }

        $res = $this->db->get();
        if (isset($res)) {
            $projects = $res->result_array();
            $projects_count = count($projects);
            for ($i = 0; $i < $projects_count; $i++) {
                $projects[$i]['categories'] = $this->get_project_categories($projects[$i]['id']);
                $status = $this->get_project_status($projects[$i]['id']);
                $projects[$i]['status_name'] = $status['name'];
                $projects[$i]['status_class'] = $status['class'];
                $projects[$i]['country_name'] = NULL;
                $projects[$i]['quotes'] = $this->quote_model->get_placed_quotes($projects[$i]['id']);

                // Creator
                $projects[$i]['creator_name'] = $this->user_model->get_name($projects[$i]['creator_id']);
            }
            return $projects;
        } else {
            return [];
        }
    }

    /**
     * Get quote requests for current user (count for sidebar)
     *
     * @param $user_id
     * @return int;
     */
    function get_requested_projects_count($user_id)
    {
        $this->db->select('count(*) AS cnt');
        $this->db->from('jobs as j');
        $this->db->join('quote_requests as q', 'j.id = q.job_id');
        $this->db->where('j.job_status', 8);
        $this->db->where('q.requestee_id', $user_id);
        $res = $this->db->get()->row();
        if (isset($res)) {
            return $res->cnt;
        } else {
            return 0;
        }
    }

    /**
     * Returns users draft projects with thumbnails
     *
     * @param $user_id
     * @return array
     */
    function get_draft_thumbs($user_id)
    {
        $this->db->select('id, job_name');
        $this->db->from('jobs');
        $this->db->where('creator_id', $user_id);
        $this->db->where_in('job_status', [0, 1]);

        // order by additional payment options
        $this->db->order_by('ifnull(is_urgent,0) DESC, ifnull(is_feature,0) DESC');

        $this->db->order_by('id', 'ASC');

        $res = $this->db->get();
        if (isset($res)) {
            $res = $res->result_array();
            $count = count($res);
            for ($i = 0; $i < $count; $i++) {
                $res[$i]['thumbnail'] = '';
                $attachments = $this->get_project_attachments($res[$i]['id'], $user_id);
                if (count($attachments) > 0) {
                    $res[$i]['thumbnail'] = $attachments[0]['img_url'];
                }
            }
            return $res;
        } else {
            return [];
        }
    }

    /**
     * Returns number of active projects for user
     *
     * @param $user
     * @return int
     */
    function get_active_projects_count($user)
    {
        $this->db->select('count(*) as cnt');
        $this->db->from('jobs j');
        $this->db->where('j.job_status', 4);

//		$this->db->where('(j.creator_id = '.$user.' OR j.employee_id = '.$user.')');
        $this->active_projects($user);

        $res = $this->db->get()->row();
        if (isset($res)) {
            return $res->cnt;
        } else {
            return 0;
        }
    }

    /**
     * Returns number of won quotes for user
     *
     * @param $user
     * @return int
     */
    function get_won_quotes_count($user)
    {
        $this->db->select('count(*) as cnt');
        $this->db->from('jobs as j');
        $this->db->join('quotes as q', 'j.id = q.job_id');
        $this->db->where('j.job_status', 3);
        $this->db->where('q.status', 3);
        $this->db->where('q.loop = (select max(q1.loop) from quotes as q1 where q1.job_id = q.job_id and q1.provider_id = q.provider_id and q1.status = 3)');

//		$this->db->where('q.provider_id', $user);

        $this->won_quotes($user);

        $res = $this->db->get()->row();
        if (isset($res)) {
            return $res->cnt;
        } else {
            return 0;
        }
    }

    /**
     * Returns number of pending quotes for user
     *
     * @param $user
     * @return int
     */
    function get_pending_quotes_count($user)
    {
        $this->db->select('count(*) as cnt');
        $this->db->from('jobs as j');
        $this->db->join('quotes as q', 'j.id = q.job_id');
        $this->db->where('j.job_status', 2);
        $this->db->where('q.status', 2);
        $this->db->where('q.loop = (select max(q1.loop) from quotes as q1 where q1.job_id = q.job_id and q1.provider_id = q.provider_id and q1.status = 2)');

        $this->pending_quotes($user);

//		$this->db->where('q.provider_id', $user);

        $res = $this->db->get()->row();
        if (isset($res)) {
            return $res->cnt;
        } else {
            return 0;
        }
    }

    /**
     * Returns number of completed projects for user
     *
     * @param $user
     * @return int
     */
    function get_completed_projects_count($user)
    {
        $this->db->select('count(*) as cnt');
        $this->db->from('jobs j');
        $this->db->where('j.job_status', 5);

        $this->completed_projects($user);

//        $this->db->where('(creator_id = '.$user.' OR employee_id = '.$user.')');

        $res = $this->db->get()->row();
        if (isset($res)) {
            return $res->cnt;
        } else {
            return 0;
        }
    }

    /**
     * Returns number of canceled projects for user
     *
     * @param $user
     * @return int
     */
    function get_canceled_projects_count($user)
    {
        $this->db->select('count(*) as cnt');
        $this->db->from('jobs j');
        $this->db->where_in('j.job_status', [6, 7]);

        $this->cancelled_projects($user);

//        $this->db->where('(creator_id = '.$user.' OR employee_id = '.$user.')');

        $res = $this->db->get()->row();
        if (isset($res)) {
            return $res->cnt;
        } else {
            return 0;
        }
    }

    /**
     * Returns active projects for user
     *
     * @param $user
     * @param $limit
     * @param $order_by
     * @return array
     */
    function get_active_projects($user, $limit = '', $order_by = '')
    {
        $this->load->model('finance_model');

        $this->db->select('j.id, j.job_name, j.enddate, j.due_date, j.budget_min, j.budget_max, j.creator_id, ' .
            ' j.employee_id, j.description, j.is_urgent, is_feature, is_hide_bids, is_private, ' .
            ' (select count(*)+1 from milestones as m where m.job_id = j.id and m.status = 1) as active_milestone,' .
            ' (select count(*) from milestones as m where m.job_id = j.id) as milestone_count,' .
            ' (select sum(amount) from milestones as m where m.job_id = j.id) as milestone_amount,' .
            ' (select sum(completion) from milestones as m where m.job_id = j.id) as milestone_completion');
        $this->db->from('jobs as j');
        $this->db->where('j.job_status', 4);
//		$this->db->where('(j.creator_id = '.$user.' OR j.employee_id = '.$user.')');
        $this->active_projects($user);

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

        // order by additional payment options
        $this->db->order_by('ifnull(j.is_urgent,0) DESC, ifnull(j.is_feature,0) DESC');

        if (is_array($order_by) and count($order_by) == 2) {
            $this->db->order_by($order_by[0], $order_by[1]);
        } else {
            $this->db->order_by('j.id', 'desc');
        }

        $res = $this->db->get();
        if (isset($res)) {
            $res = $res->result_array();
            $count = count($res);
            for ($i = 0; $i < $count; $i++) {
                $res[$i]['job_status'] = $this->get_project_status($res[$i]['id']);
                $employee = $this->user_model->getUsers(['users.id' => $res[$i]['employee_id']], "concat(first_name, ' ', last_name) as name")->row();
                if (isset($employee)) {
                    $res[$i]['employee_id'] = $employee->name;
                } else {
                    $res[$i]['employee_id'] = '';
                }
                $res[$i]['payment'] = $this->finance_model->get_project_payment($res[$i]['id']);
                $res[$i]['attachments'] = $this->get_project_attachments($res[$i]['id'], $res[$i]['creator_id']);
            }
            return $res;
        } else {
            return [];
        }
    }

    /**
     * Returns won quotes for user
     *
     * @param $user
     * @param $limit
     * @param $order_by
     * @return array
     */
    function get_won_quotes($user, $limit = '', $order_by = '')
    {
        $this->db->select('j.id as job_id, q.id as quote_id, j.job_name, j.enddate, j.due_date, ' .
            ' j.budget_min, j.budget_max, q.amount, j.is_urgent, is_feature, is_hide_bids, is_private, ' .
            ' (select count(*) from quote_milestones as m where m.quote_id = q.id) as milestone_count,' .
            ' (select sum(amount) from quote_milestones as m where m.quote_id = q.id) as milestone_amount');
        $this->db->from('jobs as j');
        $this->db->join('quotes as q', 'j.id = q.job_id');
        $this->db->where('j.job_status', 3);
        $this->db->where('q.status', 3);
        $this->db->where('q.loop = (select max(q1.loop) from quotes as q1 where q1.job_id = q.job_id and q1.provider_id = q.provider_id and q1.status = 3)');

//		$this->db->where('q.provider_id', $user);

        $this->won_quotes($user);

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

        // order by additional payment options
        $this->db->order_by('ifnull(j.is_urgent,0) DESC, ifnull(j.is_feature,0) DESC');

        if (is_array($order_by) and count($order_by) == 2) {
            $this->db->order_by($order_by[0], $order_by[1]);
        } else {
            $this->db->order_by('j.id', 'desc');
        }

        $res = $this->db->get();
        if (isset($res)) {
            $res = $res->result_array();
            $count = count($res);
            for ($i = 0; $i < $count; $i++) {
                $res[$i]['job_status'] = $this->get_project_status($res[$i]['job_id']);
            }
            return $res;
        } else {
            return [];
        }
    }

    /**
     * Returns pending quotes for user
     *
     * @param $user
     * @param $limit
     * @param $order_by
     * @return array
     */
    function get_pending_quotes($user, $limit = '', $order_by = '')
    {
        $this->db->select('j.id as job_id, q.id as quote_id, j.job_name, j.enddate, j.due_date, ' .
            ' j.budget_min, j.budget_max, q.amount, j.is_urgent, is_feature, is_hide_bids, is_private, ' .
            ' (select count(*) from quote_milestones as m where m.quote_id = q.id) as milestone_count, ' .
            ' q.status as quote_status, q.creator_id as quote_creator_id');
        $this->db->from('jobs as j');
        $this->db->join('quotes as q', 'j.id = q.job_id');
        $this->db->where('j.job_status', 2);
        $this->db->where('q.status', 2);
        $this->db->where('q.loop = (select max(q1.loop) from quotes as q1 where q1.job_id = q.job_id and q1.provider_id = q.provider_id and q1.status = 2)');

        $this->pending_quotes($user);

//		$this->db->where('q.provider_id', $user);

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

        // order by additional payment options
        $this->db->order_by('ifnull(j.is_urgent,0) DESC, ifnull(j.is_feature,0) DESC');

        if (is_array($order_by) and count($order_by) == 2) {
            $this->db->order_by($order_by[0], $order_by[1]);
        } else {
            $this->db->order_by('j.id', 'desc');
        }

        $res = $this->db->get();
        if (isset($res)) {
            $res = $res->result_array();
            $count = count($res);
            for ($i = 0; $i < $count; $i++) {
                $res[$i]['job_status'] = $this->get_project_status($res[$i]['job_id']);
                $res[$i]['quote_status'] = $this->quote_model->get_quote_status($res[$i]['quote_id']);
            }
            return $res;
        } else {
            return [];
        }
    }

    /**
     * Returns completed projects for user
     *
     * @param $user
     * @param $limit
     * @param $order_by
     * @return array
     */
    function get_completed_projects($user, $limit = '', $order_by = '')
    {
        $this->load->model('finance_model');

        $this->db->select('j.id, j.job_name, j.enddate, j.due_date, j.budget_min, j.budget_max, j.creator_id, ' .
            ' j.employee_id, j.description, j.is_urgent, is_feature, is_hide_bids, is_private, ' .
            ' (select count(*)+1 from milestones as m where m.job_id = j.id and m.status = 1) as active_milestone,' .
            ' (select count(*) from milestones as m where m.job_id = j.id) as milestone_count,' .
            ' (select sum(amount) from milestones as m where m.job_id = j.id) as milestone_amount');
        $this->db->from('jobs as j');
        $this->db->where('j.job_status', 5);

        $this->completed_projects($user);

//		$this->db->where('(j.creator_id = '.$user.' OR j.employee_id = '.$user.')');

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

        // order by additional payment options
        $this->db->order_by('ifnull(j.is_urgent,0) DESC, ifnull(j.is_feature,0) DESC');

        if (is_array($order_by) and count($order_by) == 2) {
            $this->db->order_by($order_by[0], $order_by[1]);
        } else {
            $this->db->order_by('j.id', 'desc');
        }

        $res = $this->db->get();

        if (isset($res)) {
            $res = $res->result_array();
            $count = count($res);
            for ($i = 0; $i < $count; $i++) {
                $res[$i]['job_status'] = $this->get_project_status($res[$i]['id']);
                $employee = $this->user_model->getUsers(['users.id' => $res[$i]['employee_id']], "concat(first_name, ' ', last_name) as name")->row();
                if (isset($employee)) {
                    $res[$i]['employee_id'] = $employee->name;
                } else {
                    $res[$i]['employee_id'] = '';
                }
                $res[$i]['payment'] = $this->finance_model->get_project_payment($res[$i]['id']);
                $res[$i]['attachments'] = $this->get_project_attachments($res[$i]['id'], $res[$i]['creator_id']);
            }
            return $res;

        } else {
            return [];
        }
    }

    /**
     * Returns canceled projects for user
     *
     * @param $user
     * @param $limit
     * @param $order_by
     * @return array
     */
    function get_canceled_projects($user, $limit = '', $order_by = '')
    {
        $this->db->select('j.id, j.job_name, j.enddate, j.due_date, j.budget_min, j.budget_max, j.employee_id,' .
            ' j.is_urgent, is_feature, is_hide_bids, is_private, ' .
            ' (select count(*)+1 from milestones as m where m.job_id = j.id and m.status = 1) as active_milestone,' .
            ' (select count(*) from milestones as m where m.job_id = j.id) as milestone_count,' .
            ' (select sum(amount) from milestones as m where m.job_id = j.id) as milestone_amount');
        $this->db->from('jobs as j');
        $this->db->where_in('j.job_status', [6, 7]);

        $this->cancelled_projects($user);

//		$this->db->where('(j.creator_id = '.$user.' OR j.employee_id = '.$user.')');

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

        // order by additional payment options
        $this->db->order_by('ifnull(j.is_urgent,0) DESC, ifnull(j.is_feature,0) DESC');

        if (is_array($order_by) and count($order_by) == 2) {
            $this->db->order_by($order_by[0], $order_by[1]);
        } else {
            $this->db->order_by('j.id', 'desc');
        }

        $res = $this->db->get();
        if (isset($res)) {
            $res = $res->result_array();
            $count = count($res);
            for ($i = 0; $i < $count; $i++) {
                $res[$i]['job_status'] = $this->get_project_status($res[$i]['id']);
                $employee = $this->user_model->getUsers(['users.id' => $res[$i]['employee_id']], "concat(first_name, ' ', last_name) as name")->row();
                if (isset($employee)) {
                    $res[$i]['employee_id'] = $employee->name;
                } else {
                    $res[$i]['employee_id'] = '';
                }
                $res[$i]['payment'] = $this->finance_model->get_project_payment($res[$i]['id']);
            }
            return $res;
        } else {
            return [];
        }
    }

    /**
     * Get projects to show on dashboard map
     *
     * @param $user
     * @return string
     * @throws Exception
     */
    function get_map_projects($user)
    {
        $this->load->model('city_model');

        $this->db->select('j.job_name, j.job_status, j.start_date, j.enddate, j.city, j.state, c.country_symbol, c.country_name');
        $this->db->from('jobs AS j');
        $this->db->join('country AS c', 'j.country = c.id');
        $this->db->where('creator_id', $user);
        $this->db->or_where('employee_id', $user);
        $this->db->or_where('EXISTS (SELECT 1 FROM quotes AS q WHERE q.job_id = j.id AND q.provider_id = ' . $user . ')');

        $res = $this->db->get();
        if (!$res) {
            throw_db_exception();
        }

        $res = $res->result_array();
        $count = count($res);
        $result = [];
        for ($i = 0; $i < $count; $i++) {
            $city_coords = $this->city_model->get_city_coordinates($res[$i]['city'], $res[$i]['country_symbol'], $res[$i]['state']);
            if ($city_coords != NULL) {
                // Get color
                if ($res[$i]['job_status'] < 4 or $res[$i]['job_status'] == 8) {
                    $color = '#83c145';
                } elseif ($res[$i]['job_status'] == 4) {
                    $color = '#1e88e5';
                } else {
                    $color = '#bdbdbd';
                }

                $result[] = [
                    'title' => $res[$i]['job_name'],
                    'description' => $res[$i]['country_name'] . '<br/>' . date('Y/m/d', $res[$i]['start_date']) . '-' . date('Y/m/d', $res[$i]['enddate']),
                    'latitude' => $city_coords['lat'],
                    'longitude' => $city_coords['lng'],
                    'color' => $color,
                    'type' => 'circle'
                ];
            }
        }
        return json_encode($result);
    }


    /* Reading child data */

    /**
     * Returns the list of all groups/categories for project
     *
     * @param $project_id
     * @return array
     */
    function get_project_categories($project_id)
    {
        $this->db->select('g.id as group_id, g.group_name, c.id as category_id, c.category_name');
        $this->db->from('job_categories as jc');
        $this->db->join('categories as c', 'jc.category_id = c.id');
        $this->db->join('groups as g', 'c.group_id = g.id');
        $this->db->where('jc.job_id', $project_id);
        $this->db->order_by('g.id', 'ASC');
        $this->db->order_by('c.id', 'ASC');
        $res = $this->db->get();
        if (isset($res)) {
            return $res->result_array();
        } else {
            return [];
        }
    }

    /**
     * Returns name and class for project status
     *
     * @param $project_id
     * @return array
     */
    function get_project_status($project_id)
    {
        $result = ['id' => '', 'name' => '', 'class' => ''];

        $this->db->select('job_status, employee_id, due_date');
        $this->db->from('jobs');
        $this->db->where('id', $project_id);

        $res = $this->db->get();
        if (isset($res)) {
            $status = $res->row()->job_status;
            $supplier = $res->row()->employee_id;
            $due_date = $res->row()->due_date;

            $result['id'] = $status;
            $result['p_completion'] = 0;
            if ($status == '0') {
                $result['name'] = t('Draft');
                $result['class'] = 'project-status-draft';
            } elseif ($status == '1') {
                $result['name'] = t('New');
                $result['class'] = 'project-status-new';
            } elseif ($status == '2') {
                $result['name'] = t('Pending');
                $result['class'] = 'project-status-pending';
            } elseif ($status == '3') {
                $result['name'] = t('Placed');
                $result['class'] = 'project-status-placed';
            } elseif (isProvider() and $status > 3 and $status != 8 and $this->logged_in_user->id != $supplier) {
                $result['name'] = t('Assigned to Competition');
                $result['class'] = 'project-status-competition';
            } elseif ($status == '4') {
                if (count($this->cancel_model->get_project_cases($project_id)) > 0) {
                    $result['name'] = t('Dispute');
                    $result['class'] = 'project-status-dispute';
                } elseif ($due_date > 0 && $due_date < get_est_time()) {
                    $result['name'] = t('Project Overdue');
                    $result['class'] = 'project-status-project-overdue';
                } else {
                    $this->db->select('count(*) as milestones_count, sum(completion) as p_completion');
                    $this->db->from('milestones');
                    $this->db->where('job_id', $project_id);
                    $this->db->where('(due_date > 0 AND due_date < '.get_est_time().')');
                    $this->db->where('status', 0);
                    $res = $this->db->get()->row();
                    if (isset($res) and $res->milestones_count > 0) {
                        $result['name'] = ($res->milestones_count) . ' ' . (t('Milestone Overdue'));
                        $result['class'] = 'project-status-milestone-overdue';
                    } elseif ($due_date > 0 && $due_date - WEEK < get_est_time()) {
                        $result['name'] = t('To Be Completed');
                        $result['class'] = 'project-status-tbc';
                    } else {
                        $result['name'] = t('In Progress');
                        $result['class'] = 'project-status-in-progress';
                    }
                }
            } elseif ($status == '5') {
                $result['name'] = t('Completed');
                $result['class'] = 'project-status-completed';
            } elseif ($status == '6') {
                $result['name'] = t('Canceled');
                $result['class'] = 'project-status-canceled';
            } elseif ($status == '7') {
                $result['name'] = t('Declined');
                $result['class'] = 'project-status-declined';
            } elseif ($status == '8') {
                $result['name'] = t('Quote Request');
                $result['class'] = 'project-status-quote-request';
            }
        }

        return $result;
    }

    /**
     * Returns the list of all milestones for project
     *
     * @param $project_id
     * @param $user_id
     * @return array
     */
    function get_project_milestones($project_id, $user_id = '')
    {
        $this->db->select('*');
        $this->db->from('milestones');
        $this->db->where('job_id', $project_id);
        $this->db->order_by('id', 'ASC');
        $res = $this->db->get()->result_array();
        if ($user_id != '') {
            $count = count($res);
            for ($i = 0; $i < $count; $i++) {
                $res[$i]['attachments'] = $this->get_milestone_attachments($project_id, $res[$i]['id'], $user_id);
            }
        }
        return $res;
    }

    /**
     * Returns milestones for project
     *
     * @param $project_id
     * @param $limit
     * @param $order_by
     * @param $user_id
     * @return array
     */
    function get_project_milestones_table($project_id, $limit, $order_by, $user_id = '')
    {
        $this->db->select('*');
        $this->db->from('milestones');
        $this->db->where('job_id', $project_id);
        $this->db->order_by('id', 'ASC');

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
            $this->db->order_by('id', 'ASC');
        }

        $res = $this->db->get()->result_array();
        if ($user_id != '') {
            $count = count($res);
            for ($i = 0; $i < $count; $i++) {
                $res[$i]['attachments'] = $this->get_milestone_attachments($project_id, $res[$i]['id'], $user_id);
            }
        }
        return $res;
    }

    /**
     * Returns the list of all attachments for project
     *
     * @param $project_id
     * @param $user_id
     * @return array
     */
    function get_project_attachments($project_id, $user_id)
    {
        $this->db->select('*');
        $this->db->from('job_attachments');
        $this->db->where('job_id', $project_id);
        $this->db->order_by('id', 'ASC');
        $res = $this->db->get();
        if (isset($res)) {
            $res = $res->result_array();
            $count = count($res);
            for ($i = 0; $i < $count; $i++) {
                $res[$i]['img_url'] = $this->file_model->get_project_file_path($user_id, $res[$i]['url'], $project_id);
            }
            return $res;
        } else {
            return [];
        }
    }

    /**
     * Returns the list of all attachments for milestone
     *
     * @param $project_id
     * @param $milestone_id
     * @param $user_id
     * @return array
     */
    function get_milestone_attachments($project_id, $milestone_id, $user_id)
    {
        $this->db->select('*');
        $this->db->from('milestone_attachments');
        $this->db->where('milestone_id', $milestone_id);
        $this->db->order_by('id', 'ASC');
        $res = $this->db->get();
        if (isset($res)) {
            $res = $res->result_array();
            if ($user_id != NULL and $user_id != '') {
                $count = count($res);
                for ($i = 0; $i < $count; $i++) {
                    $res[$i]['img_url'] = $this->file_model->get_project_file_path($user_id, $res[$i]['url'], $project_id, $milestone_id);
                }
            }
            return $res;
        } else {
            return [];
        }
    }

    /**
     * Return all users connected to project for current user
     *
     * @param $project_id
     * @return array
     */
    function get_connected_users($project_id)
    {
        $users = [];
        if (isEntrepreneur()) {
            $this->db->select('employee_id');
            $this->db->from('jobs');
            $this->db->where('id', $project_id);
            $res = $this->db->get()->row();
            if (isset($res)) {
                if ($res->employee_id != '') {
                    $users[] = [
                        'id' => $res->employee_id,
                        'full_name' => $this->user_model->get_name($res->employee_id)
                    ];
                } else {
                    $this->db->select('provider_id as id');
                    $this->db->from('quotes');
                    $this->db->where('job_id', $project_id);
                    $this->db->where_in('status', [2, 3]);
                    $users = $this->db->get()->result_array();
                    $count = count($users);
                    for ($i = 0; $i < $count; $i++) {
                        $users[$i]['full_name'] = $this->user_model->get_name($users[$i]['id']);
                    }
                }
            }
        } elseif (isProvider()) {
            $this->db->select('creator_id');
            $this->db->from('jobs');
            $this->db->where('id', $project_id);
            $res = $this->db->get()->row();
            if (isset($res)) {
                $users[] = [
                    'id' => $res->creator_id,
                    'full_name' => $this->user_model->get_name($res->creator_id)
                ];
            }
        }

        return $users;
    }

    /**
     * Get user projects without reviews
     *
     * @param $user
     * @return array
     * @throws Exception
     */
    function get_unreviewed_projects($user)
    {
        $esc_user = $this->db->escape($user);

        $this->db->select('*');
        $this->db->from('jobs AS j');
        $this->db->where('(j.creator_id = ' . $esc_user . ' OR j.employee_id = ' . $esc_user . ')');
        $this->db->where_in('j.job_status', [4, 5, 6, 7]);
        $this->db->where('NOT EXISTS (SELECT 1 FROM reviews AS r WHERE r.job_id = j.id)', NULL, FALSE);

        $res = $this->db->get();
        if (!$res) {
            throw_db_exception();
        }
        return $res->result_array();
    }

    /**
     * Get review/rating for project
     *
     * @param $project
	 * @param $reviewer
	 * @param $reviewee
     * @return array
     */
    function get_project_review($project, $reviewer, $reviewee = NULL)
    {
        $this->db->select('r.*');
        $this->db->from('reviews as r');
        $this->db->join('reviews as r1',
                        'r.reviewer_id = r1.reviewee_id and r.reviewee_id = r1.reviewer_id and r.job_id = r1.job_id',
                        'inner');
        $this->db->where('r.job_id', $project);
        if ($reviewee != NULL) {
			$this->db->where('r.reviewee_id', $reviewee);
		} else {
			$this->db->where('r.reviewer_id', $reviewer);
		}
        $res = $this->db->get()->result_array();
        if (count($res) > 0) {
            $res = $res[0];
            // Get ratings
            $this->db->select('r.id, r.rating_category_id, rc.name AS rating_category_name, r.rating');
            $this->db->from('ratings AS r');
            $this->db->join('rating_categories AS rc', 'r.rating_category_id = rc.id');
            $this->db->where('r.review_id', $res['id']);
            $res['ratings'] = $this->db->get()->result_array();
            // Average rating
			$avg = 0;
			foreach ($res['ratings'] as $rating) {
				$avg += $rating['rating'];
			}
			$avg /= count($res['ratings']);
			$res['avg_rating'] = round($avg, 2);
            return $res;
        } else {
            return NULL;
        }
    }


    /* Saving project into database */

    /**
     * Insert/update project and child data, return ids of project and milestones
     *
     * @param $data
     * @return array
     * @throws Exception
     */
    function save_project($data)
    {
        $this->load->model('finance_model');

        // Project fee
        if ($data['job_status'] == 2) {
            $fee = $this->finance_model->get_project_fee($data['id'], $data['is_urgent'], $data['is_feature'], $data['is_hide_bids'], $data['is_private']);
            // Check if there is enough funds
            if ($fee > 0 and $fee > $this->finance_model->get_user_balance()) {
                throw new Exception('Insufficient funds');
            }
        } else {
            $fee = 0;
        }

        // Extract non-db fields
        if (array_key_exists('category', $data)) {
            $categories = $data['category'];
            unset($data['category']);
        }
        if (array_key_exists('milestones', $data)) {
            $milestones = $data['milestones'];
            unset($data['milestones']);
        }
        if (array_key_exists('attachments', $data)) {
            $attachments = $data['attachments'];
            unset($data['attachments']);
        }

        // Open transaction
        $this->db->trans_start();

        // Main table
        if ($data['id'] == NULL) {
            $this->db->insert('jobs', $data);
            $id = $this->db->insert_id();
        } else {
            $id = $data['id'];
            $this->db->where('id', $id);
            $this->db->update('jobs', $data);
        }

        // Categories
        $this->db->where('job_id', $id);
        $this->db->delete('job_categories');
        if (isset($categories)) {
            if (is_array($categories) and count($categories) > 0) {
                foreach ($categories as $category) {
                    if ($category != '') {
                        $job_categories = [
                            'job_id' => $id,
                            'category_id' => $category
                        ];
                        $this->db->insert('job_categories', $job_categories);
                    }
                }
            } elseif ($categories != '') {
                $job_categories = [
                    'job_id' => $id,
                    'category_id' => $categories
                ];
                $this->db->insert('job_categories', $job_categories);
            }
        }

        // Attachments
        if (!isset($attachments) or !is_array($attachments)) {
            $attachments = [];
        }
        // Copy terms and conditions to the project
        if ($data['id'] == NULL) {
            $terms = $this->file_model->get_user_files_list($this->logged_in_user->id, 2);
            foreach ($terms as $term) {
                $attachments[] = [
                    'id' => NULL,
                    'name' => $term['name'],
                    'url' => $term['url'],
                    'description' => $term['description'],
                    'expire_date' => $term['expire_date'],
                    'img_url' => $this->file_model->get_user_common_file_path($this->logged_in_user->id, $term['url'], 2)
                ];
            }
        }
        $this->save_attachments($attachments, $id, $this->logged_in_user->id);

        // Milestones
        $milestone_ids = [];
        if (isset($milestones) and is_array($milestones) and count($milestones) > 0) {
            foreach ($milestones as $milestone) {
                $milestone_ids[] = $this->save_milestone($milestone, $id, $this->logged_in_user->id);
            }
        }
        $this->delete_project_milestones_not_in_list($this->logged_in_user->id, $id, $milestone_ids);

        // Finalize
        $this->db->trans_complete();

        // Project fee
        if ($fee > 0) {
            $transaction = $this->finance_model->project_fee($id);
            $this->finance_model->finalize_transaction($transaction);
        }

        $res = [
            'id' => $id,
            'milestones' => $milestone_ids
        ];

        return $res;
    }

    /**
     * Insert project attachments
     *
     * @param $attachments
     * @param $project_id
     * @param $user_id
     */
    function save_attachments($attachments, $project_id, $user_id)
    {
        $this->delete_project_attachments_not_in_list($user_id, $project_id, $attachments);
        foreach ($attachments as $attachment) {
            if ($attachment['id'] == NULL or $attachment['id'] == '') {
                $this->insert_attachment($attachment, $project_id, $user_id);
            }
        }
    }

    /**
     * Insert project attachment
     *
     * @param $attachment
     * @param $project_id
     * @param $user_id
     * @return int
     */
    function insert_attachment($attachment, $project_id, $user_id)
    {
        $url = '';
        if (array_key_exists('img_url', $attachment)) {
            $url = $attachment['img_url'];
            unset($attachment['img_url']);
        }

        $attachment['id'] = NULL;
        $attachment['job_id'] = $project_id;
        $this->db->insert('job_attachments', $attachment);
        $id = $this->db->insert_id();
        if ($url == '') {
            $this->file_model->move_temp_project_file($user_id, $attachment['url'], $project_id);
        } else {
            $this->file_model->copy_project_file_from_path($user_id, $url, $attachment['url'], $project_id);
        }
        return $id;
    }

    /**
     * Update project attachment
     *
     * @param $attachment
     */
    function update_attachment($attachment)
    {
        $this->db->update(
            'job_attachments',
            [
                'description' => $attachment['description'],
                'expire_date' => $attachment['expire_date']
            ],
            ['id' => $attachment['id']]
        );
    }

    /**
     * Insert/update milestone, return id
     *
     * @param $data
     * @param $project_id
     * @param $user_id
     * @return int
     */
    function save_milestone($data, $project_id, $user_id)
    {
        // Extract non-db fields
        $attachments = [];
        if (array_key_exists('attachments', $data)) {
            $attachments = $data['attachments'];
            unset($data['attachments']);
        }

        if ($data['id'] == NULL) {
            $data['job_id'] = $project_id;
            $data['due_date'] = strval($data['due_date']);
            $this->db->insert('milestones', $data);
            $milestone_id = $this->db->insert_id();
        } else {
            $this->db->where('id', $data['id']);
            $data['due_date'] = strval($data['due_date']);
            $this->db->update('milestones', $data);
            $milestone_id = $data['id'];
        }

        // Milestone attachments
        $this->save_milestone_attachments($attachments, $project_id, $milestone_id, $user_id);

        return $milestone_id;
    }

    /**
     * Insert milestone attachments
     *
     * @param $attachments
     * @param $project_id
     * @param $milestone_id
     * @param $user_id
     */
    function save_milestone_attachments($attachments, $project_id, $milestone_id, $user_id)
    {
        $this->delete_milestone_attachments_not_in_list($user_id, $project_id, $milestone_id, $attachments);
        foreach ($attachments as $attachment) {
            if ($attachment['id'] == NULL or $attachment['id'] == '') {
                $this->insert_milestone_attachment($attachment, $project_id, $milestone_id, $user_id);
            }
        }
    }

    /**
     * Insert milestone attachment
     *
     * @param $attachment
     * @param $project_id
     * @param $milestone_id
     * @param $user_id
     * @return int
     */
    function insert_milestone_attachment($attachment, $project_id, $milestone_id, $user_id)
    {
        $url = '';
        if (array_key_exists('img_url', $attachment)) {
            $url = $attachment['img_url'];
            unset($attachment['img_url']);
        }

        $attachment['id'] = NULL;
        $attachment['milestone_id'] = $milestone_id;
        $this->db->insert('milestone_attachments', $attachment);
        $id = $this->db->insert_id();
        if ($url == '') {
            $this->file_model->move_temp_project_file($user_id, $attachment['url'], $project_id, $milestone_id);
        } else {
            $this->file_model->copy_project_file_from_path($user_id, $url, $attachment['url'], $project_id, $milestone_id);
        }
        return $id;
    }

    /**
     * Update milestone attachment
     *
     * @param $attachment
     */
    function update_milestone_attachment($attachment)
    {
        $this->db->update(
            'milestone_attachments',
            [
                'description' => $attachment['description'],
                'expire_date' => $attachment['expire_date']
            ],
            ['id' => $attachment['id']]
        );
    }

    /**
     * Delete project by id
     *
     * @param $id
     */
    function delete_project($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('jobs');
        $this->file_model->remove_project($this->logged_in_user->id, $id);
    }

    /**
     * Delete project milestone from DB and file system
     *
     * @param $user
     * @param $project
     * @param $id
     */
    function delete_project_milestone($user, $project, $id)
    {
        $this->db->where('id', $id);
        $this->db->delete('milestones');
        $this->file_model->remove_project($user, $project, $id);
    }

    /**
     * Delete all project milestones that are not in list
     *
     * @param $user
     * @param $project
     * @param $milestones
     */
    function delete_project_milestones_not_in_list($user, $project, $milestones)
    {
        $this->db->select('id');
        $this->db->from('milestones');
        $this->db->where('job_id', $project);
        if (isset($milestones) and is_array($milestones) and count($milestones) > 0) {
            $this->db->where_not_in('id', $milestones);
        }
        $res = $this->db->get();
        if (isset($res)) {
            foreach ($res->result_array() as $milestone_to_delete) {
                $this->delete_project_milestone($user, $project, $milestone_to_delete['id']);
            }
        }
    }

    /**
     * Delete project attachment from DB and file system
     *
     * @param $user
     * @param $project
     * @param $id
     * @param $url
     */
    function delete_project_attachment($user, $project, $id, $url)
    {
        $this->db->where('id', $id);
        $this->db->delete('job_attachments');
        $this->file_model->remove_project_attachment($user, $project, '', $url);
    }

    /**
     * Delete all project attachments that are not in list
     *
     * @param $user
     * @param $project
     * @param $attachments
     */
    function delete_project_attachments_not_in_list($user, $project, $attachments)
    {
        $ids = [];
        foreach ($attachments as $attachment) {
            $ids[] = $attachment['id'];
        }

        $this->db->select('id, url');
        $this->db->from('job_attachments');
        $this->db->where('job_id', $project);
        if (isset($ids) and is_array($ids) and count($ids) > 0 and !empty($ids[0])) {
            $this->db->where_not_in('id', $ids);
        }
        $res = $this->db->get();
        if (isset($res)) {
            foreach ($res->result_array() as $attachment_to_delete) {
                $this->delete_project_attachment($user, $project, $attachment_to_delete['id'], $attachment_to_delete['url']);
            }
        }
    }

    /**
     * Delete milestone attachment from DB and file system
     *
     * @param $user
     * @param $project
     * @param $milestone
     * @param $id
     * @param $url
     */
    function delete_milestone_attachment($user, $project, $milestone, $id, $url)
    {
        $this->db->where('id', $id);
        $this->db->delete('milestone_attachments');
        $this->file_model->remove_project_attachment($user, $project, $milestone, $url);
    }

    /**
     * Delete all milestone attachments that are not in list
     *
     * @param $user
     * @param $project
     * @param $milestone
     * @param $attachments
     */
    function delete_milestone_attachments_not_in_list($user, $project, $milestone, $attachments)
    {
        $ids = [];
        foreach ($attachments as $attachment) {
            $ids[] = $attachment['id'];
        }

        $this->db->select('id, url');
        $this->db->from('milestone_attachments');
        $this->db->where('milestone_id', $milestone);
        if (isset($ids) and is_array($ids) and count($ids) > 0) {
            $this->db->where_not_in('id', $ids);
        }
        $res = $this->db->get();
        if (isset($res)) {
            foreach ($res->result_array() as $attachment_to_delete) {
                $this->delete_milestone_attachment($user, $project, $milestone, $attachment_to_delete['id'], $attachment_to_delete['url']);
            }
        }
    }

    /**
     * Close project
     *
     * @param $project_id
     */
    function close_project($project_id)
    {
        $this->db->update('jobs', ['job_status' => self::PROJECT_STATUS_COMPLETED, 'enddate' => get_est_time()], ['id' => $project_id]);

        // Release escrow if necessary
        $this->load->model('finance_model');
        $this->finance_model->escrow_release($project_id, '');

        // Close all milestones
        foreach ($this->get_project_milestones($project_id, NULL) as $milestone) {
            if ($milestone['status'] == 0) {
                $this->close_milestone($project_id, $milestone['id']);
            }
        }

        // Notify
        $project = $this->project_model->get_project_by_id($project_id);
        $this->email_model->prepare(
            'project_completed',
            $project['employee_id'],
            [
                '!username' => $this->user_model->get_name($project['employee_id']),
                '!project' => $project['job_name'],
                '!url' => site_url('project/project_list/4')
            ]
        );
    }

    /**
     * Cancel project
     *
     * @param $project_id
     */
    function cancel_project($project_id)
    {
        $this->db->update('jobs', ['job_status' => self::PROJECT_STATUS_CANCELED], ['id' => $project_id]);

        // Cancel escrow if necessary
        $this->load->model('finance_model');
        $this->finance_model->escrow_cancel($project_id, '');

        // Close all milestones
        foreach ($this->get_project_milestones($project_id, NULL) as $milestone) {
            if ($milestone['status'] == 0) {
                $this->cancel_milestone($project_id, $milestone['id']);
            }
        }

        // Notify
        $project = $this->project_model->get_project_by_id($project_id);
        $this->email_model->prepare(
            'project_canceled',
            $project['creator_id'],
            [
                '!username' => $this->user_model->get_name($project['creator_id']),
                '!project' => $project['job_name'],
                '!url' => site_url('project/project_list/2')
            ]
        );
        $this->email_model->prepare(
            'project_canceled',
            $project['employee_id'],
            [
                '!username' => $this->user_model->get_name($project['employee_id']),
                '!project' => $project['job_name'],
                '!url' => site_url('project/project_list/2')
            ]
        );
    }

    /**
     * Close milestone
     *
     * @param $project_id
     * @param $milestone_id
     * @throws Exception
     */
    function close_milestone($project_id, $milestone_id)
    {
        if (!$this->db->update('milestones', ['status' => 1, 'completion' => 100], ['id' => $milestone_id])) {
            throw_db_exception();
        }

        // Release escrow if necessary
        try {
            $this->load->model('finance_model');
            $this->finance_model->escrow_release($project_id, $milestone_id);
        } catch (Exception $e) {
            //
        }
    }

    /**
     * Cancel milestone
     *
     * @param $project_id
     * @param $milestone_id
     * @throws Exception
     */
    function cancel_milestone($project_id, $milestone_id)
    {
        if (!$this->db->update('milestones', ['status' => 2], ['id' => $milestone_id])) {
            throw_db_exception();
        }

        // Cancel escrow if necessary
        $this->load->model('finance_model');
        $this->finance_model->escrow_cancel($project_id, $milestone_id);
    }

    /**
     * Save completion percent for milestone
     *
     * @param $milestone_id
     * @param $completion
     * @throws Exception
     */
    function save_milestone_completion($milestone_id, $completion)
    {
        if (!$this->db->update('milestones', ['completion' => $completion], ['id' => $milestone_id])) {
            throw_db_exception();
        }
    }

    /**
     * Insert project review and ratings
     *
     * @param $data
     * @throws Exception
     */
    function post_review($data)
    {
        $this->load->model('user_model');

        if (array_key_exists('ratings', $data)) {
            $ratings = $data['ratings'];
            unset($data['ratings']);
        }

        // Start transaction
        $this->db->trans_start();

        // Review
        if (!$this->db->insert('reviews', $data)) {
            throw_db_exception();
        }
        $id = $this->db->insert_id();

        // Ratings
        if (isset($ratings)) {
            foreach ($ratings as $rating) {
                $rating['review_id'] = $id;
                if (!$this->db->insert('ratings', $rating)) {
                    throw_db_exception();
                }
            }
        }

        // Complete transaction
        $this->db->trans_complete();

        // Recalculate user rating
        $this->user_model->recalculate_user_rating($data['reviewee_id']);
    }

    /**
     * invite supplier to project
     *
     * @param $project_id
     * @param $creator_id
     * @param $supplier_id
     * @throws Exception
     */
    function invite_supplier_to_project($project_id, $creator_id, $supplier_id)
    {
        // Check if supplier is already invited
        $this->db->select('*');
        $this->db->from('job_invitation');
        $this->db->where('job_id', $project_id);
        $this->db->where('receiver_id', $supplier_id);
        $res = $this->db->get();
        if (!$res) {
            throw_db_exception();
        }
        $res = $res->row();
        if (isset($res)) {
            // Already invited
            return;
        }

        // Save invitation
        $this->db->insert('job_invitation', [
            'job_id' => $project_id,
            'sender_id' => $creator_id,
            'receiver_id' => $supplier_id,
            'invite_date' => get_est_time()
        ]);
    }

    /**
     * Send invitation
     *
     * @param $project_id
     * @param $creator_id
     * @param $supplier_id
     * @throws Exception
     */
    function send_invitation_to_suppliers($project_id)
    {
        $this->load->model('email_model');
        $this->load->model('user_model');

        $project = $this->get_project_by_id($project_id);

        $this->db->select('ji.sender_id, ji.receiver_id');
        $this->db->from('job_invitation as ji');
        $this->db->where('job_id', $project_id);
        $this->db->where('notification_status', NOTIFICATION_NOT_SENT);
        $res = $this->db->get();

        foreach ($res->result_array() as $item) {

            $this->email_model->prepare(
                'invite_supplier_to_project',
                $item['receiver_id'],
                [
                    '!username' => $this->user_model->get_name($item['receiver_id']),
                    '!entrepreneur' => $this->user_model->get_name($item['sender_id']),
                    '!project_name' => $project['job_name'],
                    '!url' => site_url('project/quote?id=' . $project_id)
                ],
                TRUE
            );

            $this->db->update(
                'job_invitation',
                array('notification_status' => NOTIFICATION_SENT),
                array('job_id' => $project_id, 'receiver_id' => $item['receiver_id'])
            );
        }
    }

    /**
     * get invited suppliers
     *
     * @param $project_id
     * @throws Exception
     */
    function getInvitedSuppliers($project_id = null, $invitedSuppliers = null)
    {

        $invited_suppliers = [];

        if (isset($project_id) && $project_id != "") {

            $this->db->select(
                'u.id, u.user_name, u.first_name, u.last_name, u.name, u.email, u.profile_desc, c.country_name, ' .
                'u.logo, u.last_activity, u.user_rating, u.num_reviews, u.rating_hold, u.tot_rating, 
             concat(u.first_name, " ", u.last_name) as full_name');
            $this->db->from('job_invitation ji');
            $this->db->join('users as u', 'ji.receiver_id = u.id', 'left');
            $this->db->join('country as c', 'c.id = u.country_id', 'left');

            $this->db->where('ji.job_id',$project_id);
            $this->db->where('u.role_id',2);
            $this->db->where('u.user_status',ACTIVE_USER);

            $this->db->order_by('u.user_rating','DESC');

            $result = $this->db->get();

            if (isset($result)) {
                $invited_suppliers = $result->result_array();
            }
        }

        if (isset($invitedSuppliers) && count($invitedSuppliers) > 0) {
            $this->db->select(
                'u.id, u.user_name, u.first_name, u.last_name, u.name, u.email, u.profile_desc, c.country_name, ' .
                'u.logo, u.last_activity, u.user_rating, u.num_reviews, u.rating_hold, u.tot_rating, 
             concat(u.first_name, " ", u.last_name) as full_name');
            $this->db->from('users as u');
            $this->db->join('country as c', 'c.id = u.country_id', 'left');

            $this->db->where_in('u.id',$invitedSuppliers);
            $this->db->where('u.role_id',2);
            $this->db->where('u.user_status',ACTIVE_USER);

            $this->db->order_by('u.user_rating','DESC');

            $result = $this->db->get();

            if (isset($result)) {
                $invited_suppliers = array_merge($invited_suppliers, $result->result_array());
            }
        }

        // Rank and rating
        $suppliers_count = count($invited_suppliers);

        for ($i = 0; $i < $suppliers_count; $i++) {

            $invited_suppliers[$i]['rank'] = $this->user_model->get_user_rank($invited_suppliers[$i]['id']);
            $invited_suppliers[$i]['all_rank'] = $this->user_model->get_user_count();
        }

        return $invited_suppliers;
    }

    function avaible_tender_projects($user_id)
    {

        $this->db->where('( j.creator_id = ' . $user_id . ' ' .
            'or ' .
            'exists (select 1 ' .
            'from team_members tm, team_groups tg ' .
            'where tm.group_id = tg.id ' .
            'and tm.team_leader_id = j.creator_id ' .
            'and tm.user_id = ' . $user_id . ' ' .
            'and (tg.admin = 1 or tg.quotes_edit_own = 1 or tg.quotes_edit_all = 1) ' .
            ')' .
            'or ' .
            'exists (select 1 ' .
            'from team_members tm, team_groups tg, team_members tm1 ' .
            'where tm.group_id = tg.id ' .
            'and tm.user_id = j.creator_id ' .
            'and tm.group_id = tm1.group_id ' .
            'and tm1.user_id = ' . $user_id . ' ' .
            'and (tg.admin = 1 or tg.quotes_edit_all = 1) ' .
            ') ' .
            ') '
        );

        return $this;
    }

    function active_projects($user_id)
    {

        $this->db->where('( (j.creator_id = ' . $user_id . ' OR j.employee_id = ' . $user_id . ') ' .
            'or ' .
            'exists (select 1 ' .
            'from team_members tm, team_groups tg ' .
            'where tm.group_id = tg.id ' .
            'and (tm.team_leader_id = j.creator_id or tm.team_leader_id = j.employee_id)' .
            'and tm.user_id = ' . $user_id . ' ' .
            'and (tg.admin = 1 or tg.projects_own = 1 or tg.projects_all = 1) ' .
            ')' .
            'or ' .
            'exists (select 1 ' .
            'from team_members tm, team_groups tg, team_members tm1 ' .
            'where tm.group_id = tg.id ' .
            'and (tm.user_id = j.creator_id or tm.user_id = j.employee_id)' .
            'and tm.group_id = tm1.group_id ' .
            'and tm1.user_id = ' . $user_id . ' ' .
            'and (tg.admin = 1 or tg.projects_all = 1) ' .
            ') ' .
            ') '
        );

        return $this;
    }

    function completed_projects($user_id)
    {
        return $this->active_projects($user_id);
    }

    function cancelled_projects($user_id)
    {
        return $this->active_projects($user_id);
    }

    function won_quotes($user_id)
    {

        $this->db->where('( q.provider_id = ' . $user_id . ' ' .
            'or ' .
            'exists (select 1 ' .
            'from team_members tm, team_groups tg ' .
            'where tm.group_id = tg.id ' .
            'and tm.team_leader_id = q.provider_id ' .
            'and tm.user_id = ' . $user_id . ' ' .
            'and (tg.admin = 1 or tg.quotes_edit_own = 1 or tg.quotes_edit_all = 1) ' .
            ')' .
            'or ' .
            'exists (select 1 ' .
            'from team_members tm, team_groups tg, team_members tm1 ' .
            'where tm.group_id = tg.id ' .
            'and tm.user_id = q.provider_id ' .
            'and tm.group_id = tm1.group_id ' .
            'and tm1.user_id = ' . $user_id . ' ' .
            'and (tg.admin = 1 or tg.quotes_edit_all = 1) ' .
            ') ' .
            ') '
        );

        return $this;
    }

    function pending_quotes($user_id)
    {

        return $this->won_quotes($user_id);
    }

    function tender_project_is_avaible($user_id)
    {
        $this->db->select('1 as cnt');
        $this->db->from('jobs as j');
        $this->db->where_in('j.job_status', [self::PROJECT_STATUS_DRAFT, self::PROJECT_STATUS_NEW, self::PROJECT_STATUS_PENDING, self::PROJECT_STATUS_QUOTE_REQUEST]);
        $this->avaible_tender_projects($user_id);
        $res = $this->db->get()->row();
        if (isset($res)) {
            return true;
        } else {
            return false;
        }
    }

}