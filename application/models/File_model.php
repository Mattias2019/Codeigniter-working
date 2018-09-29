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

class File_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
    }

    function is_image($filename)
    {
        $filename = $_SERVER['DOCUMENT_ROOT'] . $filename;
        $is = @getimagesize($filename);

        if (!$is) {
            return false;
        } elseif (!in_array($is[2], array(1, 2, 3))) {
            return false;
        } else {
            return true;
        }
    }

    function getImageByExt($type)
    {
        $folder = "/application/css/images/file/";
        switch ($type) {
            case '.zip':
                return $folder . "zip.png";
                break;
            case '.doc':
                return $folder . "doc.png";
                break;
            case '.docx':
                return $folder . "docx.png";
                break;
            case '.pdf':
                return $folder . "pdf.png";
                break;
            case '.txt':
                return $folder . "txt.png";
                break;
            case '.xls':
                return $folder . "xls.png";
                break;
            case '.xlsx':
                return $folder . "xlsx.png";
                break;
            default:
                return $folder . "other.png";
        }
    }

    /**
     * Returns file path for current user
     *
     * @param $user_id
     * @param $subdir
     * @param $create_if_not_exists
     * @return string
     */
    function get_user_file_path($user_id, $subdir = '', $create_if_not_exists = TRUE)
    {
        $user_pad = str_pad($user_id, 8, '0', STR_PAD_LEFT);
        $dir = 'files/' . implode('/', str_split($user_pad));

        if ($subdir != '') {
            $dir = $dir . '/' . $subdir;
        }

        if ($create_if_not_exists and !is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        return $dir . '/';
    }

    /**
     * Returns full path to user logo
     *
     * @param $user_id
     * @param $file_name
     * @return string
     */
    function get_user_logo_path($user_id, $file_name)
    {
        $file_path = $this->get_user_file_path($user_id, 'logo', FALSE) . $file_name;
        if (is_file($file_path)) {
            return '/' . $file_path;
        } else {
            return STANDARD_LOGO;
        }
    }

    /**
     * Returns full path to user-specific file
     *
     * @param $user_id
     * @param $file_name
     * @param $type
     * @return string
     */
    function get_user_common_file_path($user_id, $file_name, $type)
    {
        if ($type == 1) {
            $file_path = $this->get_user_file_path($user_id, 'templates', FALSE) . $file_name;
        } elseif ($type == 2) {
            $file_path = $this->get_user_file_path($user_id, 'terms', FALSE) . $file_name;
        } else {
            $file_path = '';
        }

        if (is_file($file_path)) {
            return '/' . $file_path;
        } else {
            return '';
        }
    }

    /**
     * Returns full path for project file
     *
     * @param $user_id
     * @param $file_name
     * @param $project
     * @param string $milestone
     * @return string
     */
    function get_project_file_path($user_id, $file_name, $project, $milestone = '')
    {
        if ($milestone == '') {
            $folder = $this->get_user_file_path($user_id, 'projects/' . $project, FALSE);
        } else {
            $folder = $this->get_user_file_path($user_id, 'projects/' . $project . '/milestones/' . $milestone, FALSE);
        }
        $file_path = $folder . $file_name;

        if (is_file($file_path)) {
            return '/' . $file_path;
        } else {
            return '';
        }
    }

    /**
     * Returns full path for project file
     *
     * @param $user_id
     * @param $file_name
     * @param $project
     * @param $quote
     * @param string $milestone
     * @return string
     */
    function get_quote_file_path($user_id, $file_name, $project, $quote, $milestone = '')
    {
        if ($milestone == '') {
            $folder = $this->get_user_file_path($user_id, 'projects/' . $project . '/quotes/' . $quote, FALSE);
        } else {
            $folder = $this->get_user_file_path($user_id, 'projects/' . $project . '/quotes/' . $quote . '/milestones/' . $milestone, FALSE);
        }
        $file_path = $folder . $file_name;

        if (is_file($file_path)) {
            return '/' . $file_path;
        } else {
            return '';
        }
    }

    /**
     * Returns full path for portfolio file
     *
     * @param $user_id
     * @param $file_name
     * @param $portfolio
     * @return string
     */
    function get_portfolio_file_path($user_id, $file_name, $portfolio)
    {
        $folder = $this->get_user_file_path($user_id, 'portfolios/' . $portfolio, FALSE);
        $file_path = $folder . $file_name;

        if (is_file($file_path)) {
            return '/' . $file_path;
        } else {
            return '';
        }
    }

    /**
     * Copy user logo in indicated path to final directory
     *
     * @param $user_id
     * @param $path
     * @param $file_name
     */
    function copy_logo_from_path($user_id, $path, $file_name)
    {
        $logo_folder = $this->get_user_file_path($user_id, 'logo');
        // Delete previous logo
        $objects = scandir($logo_folder);
        foreach ($objects as $object) {
            if (is_file($logo_folder . "/" . $object)) {
                unlink($logo_folder . "/" . $object);
            }
        }
        // Insert new logo
        $path = substr($path, 1);
        if (is_file($path) && $file_name != '') {
            copy($path, $logo_folder . $file_name);
        }
    }

    /**
     * Move user file from temporary to final directory
     *
     * @param $user_id
     * @param $file_name
     * @param $file_type
     */
    function move_temp_user_file($user_id, $file_name, $file_type)
    {
        $temp_folder = $this->temp_dir($user_id, FALSE);
        if (is_dir($temp_folder) and is_file($temp_folder . '/' . $file_name)) {
            if ($file_type == 1) {
                $new_folder = $this->get_user_file_path($user_id, 'templates');
            } elseif ($file_type == 2) {
                $new_folder = $this->get_user_file_path($user_id, 'terms');
            } else {
                return;
            }
            rename($temp_folder . '/' . $file_name, $new_folder . $file_name);
        }
    }

    /**
     * Copy user file in indicated path to final directory
     *
     * @param $user_id
     * @param $path
     * @param $file_name
     * @param $file_type
     */
    function copy_user_file_from_path($user_id, $path, $file_name, $file_type)
    {
        $path = substr($path, 1);
        if (is_file($path)) {
            if ($file_type == 1) {
                $new_folder = $this->get_user_file_path($user_id, 'templates');
            } elseif ($file_type == 2) {
                $new_folder = $this->get_user_file_path($user_id, 'terms');
            } else {
                return;
            }
            copy($path, $new_folder . $file_name);
        }
    }

    /**
     * Move project file from temporary to final directory
     *
     * @param $user_id
     * @param $file_name
     * @param $project
     * @param string $milestone
     */
    function move_temp_project_file($user_id, $file_name, $project, $milestone = '')
    {
        $temp_folder = $this->temp_dir($user_id, FALSE);
        if (is_dir($temp_folder) and is_file($temp_folder . '/' . $file_name)) {
            if ($milestone == '') {
                $new_folder = $this->get_user_file_path($user_id, 'projects/' . $project);
            } else {
                $new_folder = $this->get_user_file_path($user_id, 'projects/' . $project . '/milestones/' . $milestone);
            }
            rename($temp_folder . '/' . $file_name, $new_folder . $file_name);
        }
    }

    /**
     * Copy project file in indicated path to final directory
     *
     * @param $user_id
     * @param $path
     * @param $file_name
     * @param $project
     * @param string $milestone
     */
    function copy_project_file_from_path($user_id, $path, $file_name, $project, $milestone = '')
    {
        $path = substr($path, 1);
        if (is_file($path)) {
            if ($milestone == '') {
                $new_folder = $this->get_user_file_path($user_id, 'projects/' . $project);
            } else {
                $new_folder = $this->get_user_file_path($user_id, 'projects/' . $project . '/milestones/' . $milestone);
            }
            copy($path, $new_folder . $file_name);
        }
    }

    /**
     * Move quote file from temporary to final directory
     *
     * @param $user_id
     * @param $file_name
     * @param $project
     * @param $quote
     * @param string $milestone
     */
    function move_temp_quote_file($user_id, $file_name, $project, $quote, $milestone = '')
    {
        $temp_folder = $this->temp_dir($user_id, FALSE);
        if (is_dir($temp_folder) and is_file($temp_folder . '/' . $file_name)) {
            if ($milestone == '') {
                $new_folder = $this->get_user_file_path($user_id, 'projects/' . $project . '/quotes/' . $quote);
            } else {
                $new_folder = $this->get_user_file_path($user_id, 'projects/' . $project . '/quotes/' . $quote . '/milestones/' . $milestone);
            }
            rename($temp_folder . '/' . $file_name, $new_folder . $file_name);
        }
    }

    /**
     * Copy quote file in indicated path to final directory
     *
     * @param $user_id
     * @param $path
     * @param $file_name
     * @param $project
     * @param $quote
     * @param string $milestone
     */
    function copy_quote_file_from_path($user_id, $path, $file_name, $project, $quote, $milestone = '')
    {
        $path = substr($path, 1);
        if (is_file($path)) {
            if ($milestone == '') {
                $new_folder = $this->get_user_file_path($user_id, 'projects/' . $project . '/quotes/' . $quote);
            } else {
                $new_folder = $this->get_user_file_path($user_id, 'projects/' . $project . '/quotes/' . $quote . '/milestones/' . $milestone);
            }
            copy($path, $new_folder . $file_name);
        }
    }

    /**
     * Move portfolio file from temporary to final directory
     *
     * @param $user_id
     * @param $file_name
     * @param $portfolio
     */
    function move_temp_portfolio_file($user_id, $file_name, $portfolio)
    {
        $temp_folder = $this->temp_dir($user_id, FALSE);
        if (is_dir($temp_folder) and is_file($temp_folder . '/' . $file_name)) {
            $new_folder = $this->get_user_file_path($user_id, 'portfolios/' . $portfolio);

            rename($temp_folder . '/' . $file_name, $new_folder . $file_name);
        }
    }

    /**
     * Removes user project or milestone attachment
     *
     * @param $user_id
     * @param $url
     * @param $type
     */
    function remove_user_common_file($user_id, $url, $type)
    {
        if ($type == 1) {
            $file = $this->get_user_file_path($user_id, 'templates', FALSE) . $url;
        } else {
            $file = $this->get_user_file_path($user_id, 'terms', FALSE) . $url;
        }
        if (is_file($file)) {
            unlink($file);
        }
    }

    /**
     * Removes user project or milestone folder
     *
     * @param $user_id
     * @param $project
     * @param string $milestone
     */
    function remove_project($user_id, $project, $milestone = '')
    {
        if ($milestone == '') {
            $dir = $this->get_user_file_path($user_id, 'projects/' . $project, FALSE);
        } else {
            $dir = $this->get_user_file_path($user_id, 'projects/' . $project . '/milestones/' . $milestone, FALSE);
        }
        if (is_dir($dir)) {
            $this->remove_dir($dir);
        }
    }

    /**
     * Removes user project or milestone attachment
     *
     * @param $user_id
     * @param $project
     * @param $milestone
     * @param $url
     */
    function remove_project_attachment($user_id, $project, $milestone, $url)
    {
        if ($milestone == '') {
            $file = $this->get_user_file_path($user_id, 'projects/' . $project, FALSE) . $url;
        } else {
            $file = $this->get_user_file_path($user_id, 'projects/' . $project . '/milestones/' . $milestone, FALSE) . $url;
        }
        if (is_file($file)) {
            unlink($file);
        }
    }

    /**
     * Removes user quote or milestone folder
     *
     * @param $user_id
     * @param $project
     * @param $quote
     * @param string $milestone
     */
    function remove_quote($user_id, $project, $quote, $milestone = '')
    {
        if ($milestone == '') {
            $dir = $this->get_user_file_path($user_id, 'projects/' . $project . '/quotes/' . $quote, FALSE);
        } else {
            $dir = $this->get_user_file_path($user_id, 'projects/' . $project . '/quotes/' . $quote . '/milestones/' . $milestone, FALSE);
        }
        if (is_dir($dir)) {
            $this->remove_dir($dir);
        }
    }

    /**
     * Removes user quote or milestone attachment
     *
     * @param $user_id
     * @param $project
     * @param $quote
     * @param $milestone
     * @param $url
     */
    function remove_quote_attachment($user_id, $project, $quote, $milestone, $url)
    {
        if ($milestone == '') {
            $file = $this->get_user_file_path($user_id, 'projects/' . $project . '/quotes/' . $quote, FALSE) . $url;
        } else {
            $file = $this->get_user_file_path($user_id, 'projects/' . $project . '/quotes/' . $quote . '/milestones/' . $milestone, FALSE) . $url;
        }
        if (is_file($file)) {
            unlink($file);
        }
    }

    /**
     * Removes user portfolio folder
     *
     * @param $user_id
     * @param $portfolio
     */
    function remove_portfolio($user_id, $portfolio)
    {
        $dir = $this->get_user_file_path($user_id, 'portfolios/' . $portfolio, FALSE);
        if (is_dir($dir)) {
            $this->remove_dir($dir);
        }
    }

    /**
     * Removes user portfolio attachment
     *
     * @param $user_id
     * @param $portfolio
     * @param $url
     */
    function remove_portfolio_attachment($user_id, $portfolio, $url)
    {
        $file = $this->get_user_file_path($user_id, 'portfolios/' . $portfolio, FALSE) . $url;
        if (is_file($file)) {
            unlink($file);
        }
    }

    /**
     * Returns users temp folder
     *
     * @param $user_id
     * @param bool $create_if_not_exists
     * @return string
     */
    function temp_dir($user_id, $create_if_not_exists = TRUE)
    {
        return $this->get_user_file_path($user_id, 'temp', $create_if_not_exists);
    }

    /**
     * Removes users temp folder
     *
     * @param $user_id
     */
    function clear_temp($user_id)
    {
        $temp_folder = $this->temp_dir($user_id, FALSE);
        if (is_dir($temp_folder)) {
            $this->remove_dir($temp_folder);
        }
    }

    /**
     * Remove directory recursively
     *
     * @param $dir
     */
    function remove_dir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir . "/" . $object)) {
                        $this->remove_dir($dir . "/" . $object);
                    } else {
                        unlink($dir . "/" . $object);
                    }
                }
            }
            rmdir($dir);
        }
    }

    /**
     * Get project/milestone file
     *
     * @param $id
     * @param $user
     * @param $job_id
     * @param $milestone_id
     * @return null
     */
    function get_project_file_by_id($id, $user, $job_id, $milestone_id)
    {
        $this->db->select('*');
        if ($milestone_id == '') {
            $this->db->from('job_attachments');
            $this->db->where('job_id', $job_id);
        } else {
            $this->db->from('milestone_attachments');
            $this->db->where('milestone_id', $milestone_id);
        }
        $this->db->where('id', $id);
        $res = $this->db->get()->result_array();
        if (count($res) > 0) {
            $res = $res[0];
            $url = $this->get_project_file_path($user, $res['url'], $job_id, $milestone_id);
            $res['img_url'] = $url;
            $res['size'] = filesize(substr($url, 1));
            if ($res['expire_date'] == 0) {
                $res['expire_date'] = NULL;
            } else {
                $res['expire_date'] = date('Y-m-d', $res['expire_date']);
            }
            return $res;
        } else {
            return NULL;
        }
    }

    /**
     * Get list of all files for all user projects/milestones
     *
     * @param $user
     * @param $limit
     * @param $order_by
     * @return array
     */
    function get_project_files_list($user, $limit, $order_by)
    {
        $this->load->model('project_model');

        // Project files
        $this->db->select("f.id, f.job_id, j.job_name, '' AS milestone_id, '' AS milestone_name, f.name, f.url, f.description, f.expire_date, j.job_status");
        $this->db->from('jobs AS j');
        $this->db->join('job_attachments AS f', 'f.job_id = j.id');
        $this->db->where('j.creator_id', $user);
        $query1 = $this->db->get_compiled_select();

        // Milestone files
        $this->db->select("f.id, j.id AS job_id, j.job_name, f.milestone_id, m.name AS milestone_name, f.name, f.url, f.description, f.expire_date, j.job_status");
        $this->db->from('jobs AS j');
        $this->db->join('milestones AS m', 'm.job_id = j.id');
        $this->db->join('milestone_attachments AS f', 'f.milestone_id = m.id');
        $this->db->where('j.creator_id', $user);

        // Only add limit/order to second query
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
            $this->db->order_by('job_id', 'ASC');
            $this->db->order_by('milestone_id', 'ASC');
            $this->db->order_by('id', 'ASC');
        }

        $query2 = $this->db->get_compiled_select();

        // Union
        $res = $this->db->query($query1 . ' UNION ' . $query2)->result_array();
        $count = count($res);
        for ($i = 0; $i < $count; $i++) {
            $res[$i]['job_status'] = $this->project_model->get_project_status($res[$i]['job_id']);
            $url = $this->get_project_file_path($user, $res[$i]['url'], $res[$i]['job_id'], $res[$i]['milestone_id']);
            $res[$i]['img_url'] = $url;
            $res[$i]['size'] = filesize(substr($url, 1));
        }
        return $res;
    }

    /**
     * Get user-scope file
     *
     * @param $id
     * @return null
     */
    function get_user_file_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('user_files');
        $this->db->where('id', $id);
        $res = $this->db->get()->result_array();
        if (count($res) > 0) {
            $res = $res[0];
            $url = $this->get_user_common_file_path($res['user_id'], $res['url'], $res['file_type']);
            $res['img_url'] = $url;
            $res['size'] = filesize(substr($url, 1));
            return $res;
        } else {
            return NULL;
        }
    }

    /**
     * Get list of all user-scope files for user
     *
     * @param $user
     * @param $type
     * @param $limit
     * @param $order_by
     * @return array
     */
    function get_user_files_list($user, $type, $limit = '', $order_by = '')
    {
        $this->db->select("*");
        $this->db->from('user_files');
        $this->db->where('user_id', $user);
        $this->db->where('file_type', $type);

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
            $this->db->order_by('id', 'ASC');
        }

        $res = $this->db->get()->result_array();
        $count = count($res);
        for ($i = 0; $i < $count; $i++) {
            $url = $this->get_user_common_file_path($user, $res[$i]['url'], $type);
            $res[$i]['img_url'] = $url;
            $res[$i]['size'] = filesize(substr($url, 1));
        }
        return $res;
    }

    /**
     * Insert user file
     *
     * @param $file
     * @param $user_id
     * @return int
     */
    function insert_file($file, $user_id)
    {
        $url = '';
        if (array_key_exists('img_url', $file)) {
            $url = $file['img_url'];
            unset($file['img_url']);
        }

        $file['id'] = NULL;
        $this->db->insert('user_files', $file);
        $id = $this->db->insert_id();
        if ($url == '') {
            $this->move_temp_user_file($user_id, $file['url'], $file['file_type']);
        } else {
            $this->copy_user_file_from_path($user_id, $url, $file['url'], $file['file_type']);
        }
        return $id;
    }

    /**
     * Update user file
     *
     * @param $file
     */
    function update_file($file)
    {
        $this->db->update(
            'user_files',
            [
                'description' => $file['description'],
                'expire_date' => $file['expire_date']
            ],
            ['id' => $file['id']]
        );
    }

    /**
     * @param $id
     */
    function delete_file($id)
    {
        $file = $this->get_user_file_by_id($id);
        if (isset($file)) {
            $this->db->delete('user_files', ['id' => $id]);
            $this->remove_user_common_file($file['user_id'], $file['url'], $file['file_type']);
        }
    }

    /**
     * Returns file path for current group
     *
     * @param $group_id
     * @param $create_if_not_exists
     * @return string
     */
    function get_group_logo_file_path($group_id, $file_name, $create_if_not_exists = TRUE)
    {
        $dir = $this->get_group_logo_dir($group_id);

        if ($create_if_not_exists and !is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $file_path = $dir . "/" . $file_name;
        if (is_file($file_path)) {
            return '/' . $file_path;
        } else {
            return STANDARD_LOGO;
        }
    }

    /**
     * Returns file path for current category
     *
     * @param $category_id
     * @param $create_if_not_exists
     * @return string
     */
    function get_category_logo_file_path($category_id, $file_name, $create_if_not_exists = TRUE)
    {
        $dir = $this->get_category_logo_dir($category_id);

        if ($create_if_not_exists and !is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $file_path = $dir . "/" . $file_name;
        if (is_file($file_path)) {
            return '/' . $file_path;
        } else {
            return STANDARD_LOGO;
        }
    }

    /**
     * Copy logo in indicated path to final directory
     *
     * @param $group_id
     * @param $path
     * @param $file_name
     */
    function copy_group_logo_from_path($group_id, $path, $file_name)
    {
        $logo_folder = $this->get_group_logo_dir($group_id);

        // Delete previous logo
        $objects = scandir($logo_folder);
        foreach ($objects as $object) {
            if (is_file($logo_folder . "/" . $object)) {
                unlink($logo_folder . "/" . $object);
            }
        }
        // Insert new logo
        $path = substr($path, 1);
        if (is_file($path) && $file_name != '') {
            copy($path, $logo_folder . "/" . $file_name);
        }
    }

    /**
     * Copy logo in indicated path to final directory
     *
     * @param $group_id
     * @param $path
     * @param $file_name
     */
    function copy_category_logo_from_path($category_id, $path, $file_name)
    {
        $logo_folder = $this->get_category_logo_dir($category_id);

        // Delete previous logo
        $objects = scandir($logo_folder);
        foreach ($objects as $object) {
            if (is_file($logo_folder . "/" . $object)) {
                unlink($logo_folder . "/" . $object);
            }
        }
        // Insert new logo
        $path = substr($path, 1);
        if (is_file($path) && $file_name != '') {
            copy($path, $logo_folder . "/" . $file_name);
        }
    }

    /**
     * Returns temp folder
     *
     * @param bool $create_if_not_exists
     * @return string
     */
    function get_public_temp_dir($create_if_not_exists = TRUE)
    {
        $dir = TMP_FOLDER;
        if ($create_if_not_exists and !is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        return $dir;
    }

    /**
     * Returns temp folder
     *
     * @param bool $create_if_not_exists
     * @return string
     */
    function get_group_logo_dir($group_id, $create_if_not_exists = TRUE)
    {
        $dir = GROUP_LOGO_FOLDER . $group_id;
        if ($create_if_not_exists and !is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        return $dir;
    }

    /**
     * Returns temp folder
     *
     * @param bool $create_if_not_exists
     * @return string
     */
    function get_category_logo_dir($category_id, $create_if_not_exists = TRUE)
    {
        $dir = CATEGORY_LOGO_FOLDER . $category_id;
        if ($create_if_not_exists and !is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        return $dir;
    }
}