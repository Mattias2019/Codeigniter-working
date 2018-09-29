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

class Machinery_model extends CI_Model
{
    public $logged_in_user;

    function __construct()
    {
        parent::__construct();

        // Load helpers
        $this->load->helper('date');

        // Load models
        $this->load->model('common_model');
        $this->load->model('file_model');

        $this->logged_in_user = $this->common_model->get_logged_in_user();
    }

    /* Reading machinery from database */

    /**
     * Returns machinery (portfolio) with all fields and child data
     *
     * @param $id
     * @return array
     */
    function get_machinery_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('portfolio');
        $this->db->where('id', $id);

        $res = $this->db->get();
        if (isset($res)) {
            $machinery = $res->result_array()[0];
            $machinery['attachments'] = $this->get_machinery_attachments($id, $machinery['user_id']);
            $machinery['categories'] = $this->get_machinery_categories($id);
            $categories_count = count($machinery['categories']);
            for ($i = 0; $i < $categories_count; $i++) {
                $machinery['categories'][$i] = $machinery['categories'][$i]['category_id'];
            }
            $machinery['standard_items'] = $this->get_machinery_standard_items($id, $machinery['categories']);
            $machinery['custom_items'] = $this->get_machinery_custom_items($id);
        } else {
            $machinery = NULL;
        }

        return $machinery;
    }

    /**
     * Return machinery (portfolio) info with first image
     *
     * @param array $categories
     * @param int $budget_min
     * @param int $budget_max
     * @param array $limit
     * @param string $name
     * @return mixed
     */
    function get_machinery($categories = [], $budget_min = 0, $budget_max = 0, $limit = [], $keyword = '')
    {
        $this->db->select('p.*');
        $this->db->from('portfolio as p');
        $this->db->order_by('p.id', 'DESC');

        if (is_array($categories) and count($categories) > 0) {
            $this->db->join('portfolio_categories as pc', 'p.id = pc.portfolio_id');
            $this->db->where_in('pc.category_id', $categories);
        }

        if ($budget_min > 0 or $budget_max > 0) {
            $this->db->where('p.price >=', $budget_min);
            $this->db->where('p.price <=', $budget_max);
        }

        if ($keyword != '') {
            $this->db->where('(LOWER(p.title) LIKE "%' . strtolower($keyword) . '%" OR LOWER(p.machine_description) LIKE "%' . strtolower($keyword) . '%")');
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

        $res = $this->db->get();
        if (isset($res)) {
            $machinery = $res->result_array();
        } else {
            $machinery = [];
        }
        $machinery_count = count($machinery);
        for ($i = 0; $i < $machinery_count; $i++) {
            $attachments = $this->get_machinery_attachments($machinery[$i]['id'], $machinery[$i]['user_id']);
            if (count($attachments) > 0) {
                $machinery[$i]['url'] = $attachments[0]['url'];
            } else {
                $machinery[$i]['url'] = '';
            }

            $machinery[$i]['items'] = [];
        }
        return $machinery;
    }

    /**
     * Return machinery (portfolio) info of user with first image
     *
     * @param $user
     * @param array $limit
     * @return mixed
     */
    function get_machinery_by_user($user, $limit = [])
    {
        $this->db->select('*');
        $this->db->from('portfolio as p');
        $this->db->order_by('p.id', 'DESC');
        $this->db->where('p.user_id', $user);

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

        $res = $this->db->get();
        if (isset($res)) {
            $machinery = $res->result_array();
        } else {
            $machinery = [];
        }
        $machinery_count = count($machinery);
        for ($i = 0; $i < $machinery_count; $i++) {
            $attachments = $this->get_machinery_attachments($machinery[$i]['id'], $machinery[$i]['user_id']);
            if (count($attachments) > 0) {
                $machinery[$i]['url'] = $attachments[0]['url'];
            } else {
                $machinery[$i]['url'] = [];
            }

            $machinery[$i]['items'] = [];
        }
        return $machinery;
    }

    /**
     * Return machinery (portfolio) extended info for compare machinery view
     *
     * @param array $ids
     * @return array
     */
    function get_machinery_for_compare($ids = [])
    {
        if (!is_array($ids) or count($ids) == 0) {
            return [];
        }

        $this->db->select('*');
        $this->db->from('portfolio as p');
        $this->db->where_in('p.id', $ids);
        $this->db->order_by('p.id', 'DESC');

        $res = $this->db->get();
        if (isset($res)) {
            $machinery = $res->result_array();
        } else {
            $machinery = [];
        }
        $machinery_count = count($machinery);
        for ($i = 0; $i < $machinery_count; $i++) {
            $attachments = $this->get_machinery_attachments($machinery[$i]['id'], $machinery[$i]['user_id']);
            if (count($attachments) > 0) {
                $machinery[$i]['url'] = $attachments[0]['url'];
            } else {
                $machinery[$i]['url'] = [];
            }

            $machinery[$i]['categories'] = $this->get_machinery_categories($machinery[$i]['id']);
            $category_array = [];
            foreach ($machinery[$i]['categories'] as $category) {
                $category_array[] = $category['category_id'];
            }
            $machinery[$i]['items'] = array_merge(
                $this->get_machinery_standard_items($machinery[$i]['id'], $category_array),
                $this->get_machinery_custom_items($machinery[$i]['id'])
            );
        }
        return $machinery;
    }

    /**
     * Returns users portfolios with thumbnails
     *
     * @param $user_id
     * @return array
     */
    function get_portfolio_thumbs($user_id)
    {
        $this->db->select('p.id, p.title, p.user_id');
        $this->db->from('portfolio p');

        $this->avaible_portfolio($user_id);
//		$this->db->where('p.user_id', $user_id);

        $this->db->order_by('p.id', 'ASC');
        $res = $this->db->get();
        if (isset($res)) {
            $res = $res->result_array();
            $count = count($res);
            for ($i = 0; $i < $count; $i++) {
                $res[$i]['thumbnail'] = '';
                $attachments = $this->get_machinery_attachments($res[$i]['id'], $res[$i]['user_id']);

                foreach ($attachments as $attachment) {
                    if ($this->file_model->is_image($attachment['url'])) {
                        $res[$i]['thumbnail'] = $attachment['url'];
                        break;
                    }
                }
            }
            return $res;
        } else {
            return [];
        }
    }


    /* Reading child data */

    /**
     * Returns the list of all groups/categories for machinery
     *
     * @param $portfolio_id
     * @return array
     */
    function get_machinery_categories($portfolio_id)
    {
        $this->db->select('g.id as group_id, g.group_name, c.id as category_id, c.category_name');
        $this->db->from('portfolio_categories as pc');
        $this->db->join('categories as c', 'pc.category_id = c.id');
        $this->db->join('groups as g', 'c.group_id = g.id');
        $this->db->where('pc.portfolio_id', $portfolio_id);
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
     * Returns all standard items and values for given machinery
     *
     * @param $machinery_id
     * @param $categories
     * @return mixed
     */
    function get_machinery_standard_items($machinery_id, $categories)
    {
        $this->db->select('item_id');
        $this->db->from('machinery_standard_item_categories');
        $this->db->where_in('category_id', $categories);
        $res = $this->db->get();
        if (isset($res)) {
            $items = $res->result_array();
            $count = count($items);
            for ($i = 0; $i < $count; $i++) {
                $items[$i] = $items[$i]['item_id'];
            }
        } else {
            return [];
        }

        $this->db->select('miv.id, mi.id as item_id, mi.name, mi.unit, miv.value, miv.remarks');
        $this->db->from('machinery_standard_items as mi');
        $this->db->join('machinery_standard_item_values as miv', 'mi.id = miv.item_id AND miv.machinery_id = ' . $machinery_id, 'left');
        $this->db->where_in('mi.id', $items);
        $res = $this->db->get();
        if (isset($res)) {
            return $res->result_array();
        } else {
            return [];
        }
    }

    /*
     * list all items
     * */
    function getMachineryStandardItemsList($conditions = array(), $fields = '', $like = array(), $limit = array(), $orderby = array())
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

        $this->db->from('machinery_standard_items as i');

        if ($fields != '')
        {
            $this->db->select($fields);
        }
        else
        {
            $this->db->select('i.id, i.name, i.unit');
        }

        $result = $this->db->get();
        return $result;
    }

    function countMachineryStandardItems($conditions = array(), $like = array())
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

        $this->db->from('machinery_standard_items as i');

        $this->db->select('count(i.id) as count');

        $result = $this->db->get();
        return $result;
    }

    /**
     * Returns all custom items and values for given machinery
     *
     * @param $machinery_id
     * @return mixed
     */
    function get_machinery_custom_items($machinery_id)
    {
        $this->db->select('id, name, unit, value, remarks');
        $this->db->from('machinery_custom_item_values');
        $this->db->where('machinery_id', $machinery_id);
        $res = $this->db->get();
        if (isset($res)) {
            return $res->result_array();
        } else {
            return [];
        }
    }

    /**
     * Returns all standard items for given category
     *
     * @param $categories
     * @return mixed
     */
    function get_machinery_items_by_category($categories = array())
    {
        $this->db->select('item_id');
        $this->db->from('machinery_standard_item_categories');
        $this->db->where_in('category_id', $categories);
        $res = $this->db->get();
        if (isset($res) && count($res->result_array()) > 0) {
            $items = $res->result_array();
            $count = count($items);
            for ($i = 0; $i < $count; $i++) {
                $items[$i] = $items[$i]['item_id'];
            }
        } else {
            return [];
        }

        $this->db->select('id as item_id, name, unit');
        $this->db->from('machinery_standard_items');
        $this->db->where_in('id', $items);
        $res = $this->db->get();
        if (isset($res)) {
            return $res->result_array();
        } else {
            return [];
        }
    }

    /**
     * Returns all standard items for given category
     *
     * @param $categories
     * @return mixed
     */
    function get_items_by_category($category_id)
    {
        $category_items = array();

        $this->db->select('item_id');
        $this->db->from('machinery_standard_item_categories');
        $this->db->where_in('category_id', $category_id);
        $res = $this->db->get();

        if (isset($res) && count($res->result_array()) > 0) {
            $items = $res->result_array();
            $category_items = array_column($items, 'item_id');
        }
        return $category_items;
    }

    function updateMachineryStandardItemCategories($category_id, $category_items)
    {
        // Open transaction
        $this->db->trans_start();

        // delete items
        $this->db->where('category_id', $category_id);
        $this->db->where_not_in('item_id', $category_items);
        $delete = $this->db->delete('machinery_standard_item_categories');

        if ($delete) {
            // insert items
            foreach ($category_items as $key => $value) {
                $this->db->select('1');
                $this->db->from('machinery_standard_item_categories');
                $this->db->where('category_id', $category_id);
                $this->db->where('item_id', $value);
                $res = $this->db->get();
                if (isset($res)) {
                    $res = $res->result_array();
                    if (count($res) == 0) {
                        $machinery_standard_item_categories_row = [
                            'category_id' => $category_id,
                            'item_id' => $value
                        ];
                        $insert = $this->db->insert('machinery_standard_item_categories', $machinery_standard_item_categories_row);
                        if (!$insert) {
                            return $insert;
                        }
                    }
                }
            }
        }
        else {
            return $delete;
        }

        // Finalize
        $this->db->trans_complete();

        return true;
    }

    public function generateAtachSession($portfolio_attachments)
    {
        $attachments = [];
        foreach ($portfolio_attachments as $index => $portfolio_attachment) {
            foreach ($portfolio_attachment as $str => $item) {
                $attachments[$str][$index] = $item;
            }
        }
        return $attachments;
    }

    /**
     * Returns all attachments for given machinery
     *
     * @param $machinery_id
     * @param $user_id
     * @return mixed
     */
    function get_machinery_attachments($machinery_id, $user_id)
    {
        $this->db->select('*');
        $this->db->from('portfolio_uploads');
        $this->db->where('portfolio_id', $machinery_id);
        $this->db->order_by('id', 'ASC');
        $res = $this->db->get();
        if (isset($res)) {
            $res = $res->result_array();
            $count = count($res);
            for ($i = 0; $i < $count; $i++) {
                $res[$i]['url'] = $this->file_model->get_portfolio_file_path($user_id, $res[$i]['name'] . $res[$i]['ext'], $machinery_id);
            }
            return $res;
        } else {
            return [];
        }
    }


    /* Saving machinery into database */

    /**
     * Insert/update machinery (portfolio) data, return id
     *
     * @param $data
     * @return array
     */
    function save_machinery($data)
    {
        // Extract non-db fields
        if (array_key_exists('categories', $data)) {
            $categories = $data['categories'];
            unset($data['categories']);
        }
        if (array_key_exists('attachments', $data)) {
            $attachments = $data['attachments'];
            unset($data['attachments']);
        }
        if (array_key_exists('standard_items', $data)) {
            $standard_items = $data['standard_items'];
            unset($data['standard_items']);
        }
        if (array_key_exists('custom_items', $data)) {
            $custom_items = $data['custom_items'];
            unset($data['custom_items']);
        }

        // Open transaction
        $this->db->trans_start();

        // Main table
        if ($data['id'] == NULL) {
            $this->db->insert('portfolio', $data);
            $id = $this->db->insert_id();
        } else {
            $id = $data['id'];
            $this->db->where('id', $id);
            $this->db->update('portfolio', $data);
        }

        // Categories
        $this->db->where('portfolio_id', $id);
        $this->db->delete('portfolio_categories');
        if (isset($categories)) {
            if (is_array($categories) and count($categories) > 0) {
                foreach ($categories as $category) {
                    $portfolio_categories = [
                        'portfolio_id' => $id,
                        'category_id' => $category
                    ];
                    $this->db->insert('portfolio_categories', $portfolio_categories);
                }
            } else {
                $portfolio_categories = [
                    'portfolio_id' => $id,
                    'category_id' => $categories
                ];
                $this->db->insert('portfolio_categories', $portfolio_categories);
            }
        }

        // Attachments
        if (!isset($attachments) or !is_array($attachments)) {
            $attachments = [];
        }
        $this->delete_attachments_not_in_list($this->logged_in_user->id, $id, $attachments);
        foreach ($attachments as $attachment) {
            if ($attachment['id'] == NULL or $attachment['id'] == '') {
                unset($attachment['url']);
                $attachment['id'] = NULL;
                $attachment['portfolio_id'] = $id;
                $attachment['date'] = get_est_time();
                $this->db->insert('portfolio_uploads', $attachment);
                $this->file_model->move_temp_portfolio_file($this->logged_in_user->id, $attachment['name'] . $attachment['ext'], $id);
            }
        }

        // Items
        if (isset($standard_items) and is_array($standard_items) and count($standard_items) > 0) {
            foreach ($standard_items as $standard_item) {
                $this->save_standard_item($standard_item, $id);
            }
        }
        if (isset($custom_items) and is_array($custom_items) and count($custom_items) > 0) {
            foreach ($custom_items as $custom_item) {
                $this->save_custom_item($custom_item, $id);
            }
        }

        // Finalize
        $this->db->trans_complete();

        return $id;
    }

    /**
     * Delete machinery by id
     *
     * @param $id
     */
    function delete_machinery($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('portfolio');
        $this->file_model->remove_portfolio($this->logged_in_user->id, $id);
    }

    /**
     * Delete portfolio attachment from DB and file system
     *
     * @param $user
     * @param $portfolio
     * @param $id
     * @param $url
     */
    function delete_attachment($user, $portfolio, $id, $url)
    {
        $this->db->where('id', $id);
        $this->db->delete('portfolio_uploads');
        $this->file_model->remove_portfolio_attachment($user, $portfolio, $url);
    }

    /**
     * Delete all portfolio attachments that are not in list
     *
     * @param $user
     * @param $portfolio
     * @param $attachments
     */
    function delete_attachments_not_in_list($user, $portfolio, $attachments)
    {
        $ids = [];
        foreach ($attachments as $attachment) {
            $ids[] = $attachment['id'];
        }

        $this->db->select('id, concat(name, ext) as url');
        $this->db->from('portfolio_uploads');
        $this->db->where('portfolio_id', $portfolio);
        if (isset($ids) and is_array($ids) and count($ids) > 0) {
            $this->db->where_not_in('id', $ids);
        }
        $res = $this->db->get();
        if (isset($res)) {
            foreach ($res->result_array() as $attachment_to_delete) {
                $this->delete_attachment($user, $portfolio, $attachment_to_delete['id'], $attachment_to_delete['url']);
            }
        }
    }

    /**
     * Insert/update machinery item, return id
     *
     * @param $data
     * @param $machinery_id
     * @return int
     */
    function save_standard_item($data, $machinery_id)
    {
        unset($data['name']);
        unset($data['unit']);
        if ($data['id'] == NULL or $data['id'] == '') {
            $data['id'] = NULL;
            $data['machinery_id'] = $machinery_id;
            $this->db->insert('machinery_standard_item_values', $data);
            $id = $this->db->insert_id();
        } else {
            $this->db->where('id', $data['id']);
            $this->db->update('machinery_standard_item_values', $data);
            $id = $data['id'];
        }

        return $id;
    }

    /**
     * Insert/update machinery item, return id
     *
     * @param $data
     * @param $machinery_id
     * @return int
     */
    function save_custom_item($data, $machinery_id)
    {
        if ($data['id'] == NULL or $data['id'] == '') {
            $data['id'] = NULL;
            $data['machinery_id'] = $machinery_id;
            $this->db->insert('machinery_custom_item_values', $data);
            $id = $this->db->insert_id();
        } else {
            $this->db->where('id', $data['id']);
            $this->db->update('machinery_custom_item_values', $data);
            $id = $data['id'];
        }

        return $id;
    }

    function avaible_portfolio($user_id)
    {

        $this->db->where('( p.user_id = ' . $user_id . ' ' .
            'or ' .
            'exists (select 1 ' .
            'from team_members tm, team_groups tg ' .
            'where tm.group_id = tg.id ' .
            'and tm.team_leader_id = p.user_id ' .
            'and tm.user_id = ' . $user_id . ' ' .
            'and ( tg.admin = 1 
                                            or 
                                             tg.portfolio_view = 1 
                                            or 
                                             tg.portfolio_edit_own = 1 
                                            or 
                                             tg.portfolio_edit_all = 1
                                           ) ' .
            ')' .
            'or ' .
            'exists (select 1 ' .
            'from team_members tm, team_groups tg, team_members tm1 ' .
            'where tm.group_id = tg.id ' .
            'and tm.user_id = p.user_id ' .
            'and tm.group_id = tm1.group_id ' .
            'and tm1.user_id = ' . $user_id . ' ' .
            'and ( tg.admin = 1
                                            or 
                                             tg.portfolio_view = 1
                                            or 
                                             tg.portfolio_edit_all = 1
                                           ) ' .
            ') ' .
            ') '
        );

        return $this;
    }

    /*
     * @param $portfolio_id
     * @param $user_id
     * @param $access view, edit, delete
     * */
    function portfolio_access($portfolio_id, $user_id, $access)
    {

        $this->db->select('1 as cnt');
        $this->db->from('portfolio p');
        $this->db->where('p.id', $portfolio_id);

        if ($access == VIEW) {

            $this->db->where('( p.user_id = ' . $user_id . ' ' .
                'or ' .
                'exists (select 1 ' .
                'from team_members tm, team_groups tg ' .
                'where tm.group_id = tg.id ' .
                'and tm.team_leader_id = p.user_id ' .
                'and tm.user_id = ' . $user_id . ' ' .
                'and ( tg.admin = 1 
                                                    or 
                                                     tg.portfolio_view = 1 
                                                    or 
                                                     tg.portfolio_edit_own = 1 
                                                    or 
                                                     tg.portfolio_edit_all = 1
                                                   ) ' .
                ')' .
                'or ' .
                'exists (select 1 ' .
                'from team_members tm, team_groups tg, team_members tm1 ' .
                'where tm.group_id = tg.id ' .
                'and tm.user_id = p.user_id ' .
                'and tm.group_id = tm1.group_id ' .
                'and tm1.user_id = ' . $user_id . ' ' .
                'and ( tg.admin = 1
                                                      or 
                                                       tg.portfolio_view = 1
                                                      or 
                                                       tg.portfolio_edit_all = 1
                                                     ) ' .
                ') ' .
                ') '
            );
        } elseif ($access == EDIT) {

            $this->db->where('( p.user_id = ' . $user_id . ' ' .
                'or ' .
                'exists (select 1 ' .
                'from team_members tm, team_groups tg ' .
                'where tm.group_id = tg.id ' .
                'and tm.team_leader_id = p.user_id ' .
                'and tm.user_id = ' . $user_id . ' ' .
                'and ( tg.admin = 1 
                                                    or 
                                                     tg.portfolio_edit_own = 1 
                                                    or 
                                                     tg.portfolio_edit_all = 1
                                                   ) ' .
                ')' .
                'or ' .
                'exists (select 1 ' .
                'from team_members tm, team_groups tg, team_members tm1 ' .
                'where tm.group_id = tg.id ' .
                'and tm.user_id = p.user_id ' .
                'and tm.group_id = tm1.group_id ' .
                'and tm1.user_id = ' . $user_id . ' ' .
                'and ( tg.admin = 1
                                                    or 
                                                     tg.portfolio_edit_all = 1
                                                   ) ' .
                ') ' .
                ') '
            );
        } elseif ($access == DELETE) {

            $this->db->where('p.user_id', $user_id);
        }

        $res = $this->db->get()->row();
        if (isset($res)) {
            return true;
        } else {
            return false;
        }
    }

    function portfolio_view_allowed($portfolio_id, $user_id)
    {
        return $this->portfolio_access($portfolio_id, $user_id, VIEW);
    }

    function portfolio_edit_allowed($portfolio_id, $user_id)
    {
        return $this->portfolio_access($portfolio_id, $user_id, EDIT);
    }

    function portfolio_delete_allowed($portfolio_id, $user_id)
    {
        return $this->portfolio_access($portfolio_id, $user_id, DELETE);
    }

    function portfolio_is_avaible($user_id)
    {
        $this->db->select('1 as cnt');
        $this->db->from('portfolio p');

        $this->avaible_portfolio($user_id);

        $res = $this->db->get()->row();
        if (isset($res)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Save item
     *
     * @access    private
     * @param    array    an associative array of insert values
     * @return    int
     */
    function saveItem($id = 0, $updateData = array())
    {
        if ($id == 0) {
            $this->db->insert('machinery_standard_items', $updateData);
            $id = $this->db->insert_id();
        }
        else {
            $this->db->where('i.id', $id);
            $this->db->update('machinery_standard_items as i', $updateData);
        }

        return $id;
    }

    function deleteItem($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('machinery_standard_items');
    }

    function deleteItemFromCategory($category_id, $item_id)
    {
        $this->db->where(array('category_id' => $category_id, 'item_id' => $item_id));
        $this->db->delete('machinery_standard_item_categories');
    }
}