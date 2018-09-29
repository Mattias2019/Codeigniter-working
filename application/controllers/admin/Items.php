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


class Items extends My_Controller
{

    //Constructor

    function __construct()
    {
        parent::__construct();

        $this->load->library('settings');
        $this->load->library('session');

        //Get Config Details From Db
        $this->settings->db_config_fetch();

        // loading the lang files
        load_lang(array(
            'admin/common',
            'admin/setting',
            'admin/validation',
            'admin/login'));

        //Load Models
        $this->load->model('common_model');
        $this->load->model('machinery_model');
        $this->load->model('skills_model');
        $this->outputData['login'] = 'TRUE';

        //Get Logged In user
        $this->logged_in_user = $this->common_model->get_logged_in_user();
        $this->outputData['logged_in_user'] = $this->logged_in_user;

    }

    // --------------------------------------------------------------------

    /**
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function index()
    {
        redirect_admin('items');

    }//End of index Function

    /**
     * View items
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function viewItems()
    {

        $this->add_css([
            'application/plugins/jstree/dist/themes/default/style.min.css',
            'application/plugins/lou-multi-select/css/multi-select.css',
        ]);

        $this->add_js([
            'application/js/admin/items.js',
            'application/js/pagination.js',
            'application/plugins/jstree/dist/jstree.min.js',
            'application/plugins/lou-multi-select/js/jquery.multi-select.js',
        ]);

        $this->init_js(["items.init('" . admin_url() . "');"]);

        // Get page
        $page = $this->input->post('page');
        if ($page == NULL) {
            $page = 1;
        }
        $this->outputData['page'] = $page;

        $page_rows = $this->input->post('page_rows');
        if ($page_rows == NULL) {
            $page_rows = 10;
        }
        $this->outputData['page_rows'] = $page_rows;
        $limit = [$page_rows, ($page - 1) * $page_rows];

        // Get Sorting order
        if ($this->input->post('field')) {
            $field = $this->input->post('field');
        } else {
            $field = 'i.id';
        }
        if ($this->input->post('order')) {
            $order = $this->input->post('order');
        } else {
            $order = 'ASC';
        }
        $orderby = [$field, $order];

        $like = array();
        $where = array();

        //Get items
        $items = $this->machinery_model->getMachineryStandardItemsList($where, '', $like, $limit, $orderby);

        $this->outputData['items'] = $items;

        //Get groups
        $groups = $this->skills_model->getGroups();

        $this->outputData['groups'] = $groups;

        $total_rows = $this->machinery_model->countMachineryStandardItems($where, $like)->row()->count;

        //Pagination
        $this->load->library('pagination');

        $this->outputData['pagination'] = get_pagination(admin_url('items/viewItems/'), $total_rows, $page_rows, $page);

        if ($this->input->is_ajax_request()) {
            if ($this->input->post('table_only') == 'true') {
                echo response([
                    'type' => 'table',
                    'data' => $this->load->view('admin/items/view_itemsTableBody', $this->outputData, TRUE),
                    'pagination' => $this->outputData['pagination']
                ]);
            } else {
                echo response([
                    'type' => 'all',
                    'data' => $this->load->view('admin/items/view_itemsTable', $this->outputData, TRUE),
                    'pagination' => $this->outputData['pagination']
                ]);
            }
        } else {
            $this->load->view('admin/items/view_items', $this->outputData);
        }
    }

    /**
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function addItemRow()
    {
        if ($this->input->is_ajax_request()) {

            $this->outputData['mode'] = 'insert';
            echo response([
                'html' => $this->load->view('admin/items/viewItemRow', $this->outputData, TRUE)
            ]);
        }
    }

    /**
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function editItemRow()
    {
        if ($this->input->is_ajax_request()) {

            $id = $this->input->post('id', true);

            //Set Condition To Fetch The Faq
            $condition = array('i.id' => $id);

            //Get Categories
            $this->outputData['items'] = $this->machinery_model->getMachineryStandardItemsList($condition);

            $this->outputData['mode'] = 'update';

            echo response([
                'html' => $this->load->view('admin/items/viewItemRow', $this->outputData, TRUE)
            ]);
        }
    }

    /**
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function refreshItemRow()
    {
        if ($this->input->is_ajax_request()) {

            $id = $this->input->post('id', true);

            //Set Condition To Fetch The Faq
            $condition = array('i.id' => $id);

            //Get Categories
            $this->outputData['mode'] = 'view';
            $this->outputData['items'] = $this->machinery_model->getMachineryStandardItemsList($condition);

            echo response([
                'html' => $this->load->view('admin/items/viewItemRow', $this->outputData, TRUE)
            ]);
        }
    }

    /**
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function saveItemRow()
    {
        //load validation library
        $this->load->library('form_validation');

        //Load Form Helper
        $this->load->helper('form');

        //Intialize values for library and helpers
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        if ($this->input->is_ajax_request()) {

            $id = $this->input->post('id', true);
            $isNew = ($id == null)?true:false;

            //Set rules
            $this->form_validation->set_rules('name', 'lang:item_name_validation', 'required|trim|xss_clean|callback_itemNameUnique');
            $this->form_validation->set_rules('unit', 'lang:unit_validation', 'required|trim|xss_clean');

            if ($this->form_validation->run()) {

                //prepare update data
                $updateData = array();
                $updateData['name'] = $this->input->post('name');
                $updateData['unit'] = $this->input->post('unit');

                //Edit Item
                $id = $this->machinery_model->saveItem($id, $updateData);

                //Set Condition To Fetch The Item
                $condition = array('i.id' => $id);

                //Get Categories
                $this->outputData['mode'] = 'view';
                $this->outputData['items'] = $this->machinery_model->getMachineryStandardItemsList($condition);

                $message = $isNew?t('added_success'):t('updated_success');

                echo response([
                    'html' => $this->load->view('admin/items/viewItemRow', $this->outputData, TRUE),
                    'message' => $message
                ]);
            }
            else {
                $errors_arr = $this->form_validation->error_array();
                echo response([
                    'message' => array_shift($errors_arr)
                ], true);
            }
        }
    }

    function deleteItemFromCategory()
    {
        if ($this->input->is_ajax_request()) {

            $category_id = $this->input->post('category_id', true);
            $item_id = $this->input->post('item_id', true);

            $this->machinery_model->deleteItemFromCategory($category_id, $item_id);

            echo response([
                'error' => false,
                'message' => t('delete_success')
            ]);
        }
    }

    function deleteItem()
    {
        if ($this->input->is_ajax_request()) {

            $id = $this->input->post('id', true);

            $this->machinery_model->deleteItem($id);

            echo response([
                'error' => false,
                'message' => t('delete_success')
            ]);
        }
    }

    /**
     * Add/Edit Item.
     *
     * @access    private
     * @param    nil
     * @return    void
     */
    function editItem()
    {

        //load validation library
        $this->load->library('form_validation');

        //Load Form Helper
        $this->load->helper('form');

        //Intialize values for library and helpers
        $this->form_validation->set_error_delimiters($this->config->item('field_error_start_tag'), $this->config->item('field_error_end_tag'));

        if ($this->input->post('saveItem')) {

            $id = $this->input->post('id', true);

            //Set rules
            $this->form_validation->set_rules('name', 'lang:item_name_validation', 'required|trim|xss_clean|callback_itemNameUnique');

            if ($this->form_validation->run()) {
                //prepare insert data
                $insertData = array();
                $insertData['name'] = $this->input->post('name');
                $insertData['unit'] = $this->input->post('unit');;

                //Add Item
                $this->machinery_model->saveItem($insertData);

                //Notification message
                $this->notify->set(t('added_success'), Notify::SUCCESS);
                redirect_admin('faq/viewFaqCategories');
            }
        } //If - Form Submission End

        $id = $this->uri->segment(3, '0');

        //Set Condition To Fetch The Item
        $condition = array('i.id' => $id);

        //Get Items
        $this->outputData['items'] = $this->machinery_model->getMachineryStandardItemsList($condition);

        //Load View
        $this->load->view('admin/items/editItem', $this->outputData);

    }

    function populateGroupsTree()
    {
        $tree = array();
        $groups = $this->skills_model->getGroups();
        foreach ($groups->result() as $group) {
            $tree[] = array('id' => $group->id,
                            'text' => $group->group_name,
                            'attr' => array('id' => $group->id),
                            'data' => array('id' => $group->id, 'name' => 'group', 'attr' => array('id' => $group->id)),
                            'metadata' => array('id' => $group->id),
                            'type' => 'root',
                            'children' => '');

            $condition = array('group_id' => $group->id);
            $categories = $this->skills_model->getCategories($condition);

            foreach ($categories->result() as $category) {
                $tree[count($tree)-1]['children'][] = array('text' => $category->category_name,
                                                            'data' => array('id' => $category->id, 'name' => 'category'),
                                                            'type' => 'child',
                                                            'children' => '');

                // machinery_standard_item_categories
                $items = $this->machinery_model->get_machinery_items_by_category($category->id);
                foreach ($items as $item) {
                    $tree[count($tree)-1]['children'][count($tree[count($tree)-1]['children'])-1]['children'][] = array('text' => $item['name'],
                                                                                                                        'data' => array('id' => $item['item_id'], 'name' => 'item'),
                                                                                                                        'type' => 'child'
                    );
                }
            }
        }
        echo json_encode($tree);
    }

    function manageCategoryItems() {

        $result = ['data' => '', 'error' => false];

        if ($this->input->is_ajax_request()) {

            $category_id = $this->input->post('category_id', true);

            $all_items = $this->machinery_model->getMachineryStandardItemsList();
            $category_items = $this->machinery_model->get_items_by_category($category_id);

            $this->outputData['all_items'] = $all_items;

            $result = [
                'data' => [
                    'html' => $this->load->view('admin/items/view_categoryItems', $this->outputData, TRUE),
                    'category_items' => $category_items
                    ],

                'error' => false];
        }

        echo response($result['data'], $result['error']);
    }

    function updateMachineryStandardItemCategories() {

        $result = ['data' => '', 'error' => false];

        if ($this->input->is_ajax_request()) {

            $category_id = $this->input->post('category_id', true);
            $category_items = $this->input->post('category_items', true);

            $update = $this->machinery_model->updateMachineryStandardItemCategories($category_id, $category_items);

            if ($update) {

                $result = [
                    'data' => [
                        'message' => t('updated_success')
                    ],

                    'error' => false];
            }
            else {

                $result = [
                    'data' => [
                        'message' => t('Error')
                    ],

                    'error' => true];
            }
        }

        echo response($result['data'], $result['error']);
    }

    /**
     * checks whether item name already exists or not.
     *
     * @access    private
     * @param    string name of item
     * @return    bool true or false
     */
    function itemNameUnique($name)
    {
        //Condition to check
        $condition = array('i.name' => $name, 'i.id <>' => $this->input->post('id'));

        //Check with table
        $resultCategoryName = $this->machinery_model->getMachineryStandardItemsList($condition);

        if ($resultCategoryName->num_rows() > 0) {
            $this->form_validation->set_message('itemNameUnique', t('item_name_unique'));
            return FALSE;
        } else {
            return TRUE;
        }
    }
}

?>