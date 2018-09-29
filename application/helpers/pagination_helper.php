<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('get_pagination'))
{
	function get_pagination($base_url, $total_rows, $per_page, $cur_page)
	{
		$CI = &get_instance();
		$CI->load->library('pagination');

		$config['base_url'] = $base_url;
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $per_page;
		$config['cur_page'] = $cur_page;

		$config['first_link'] = t('First');
		$config['first_tag_open'] = '<span class="first_tag_open_pagination_cls">';
		$config['first_tag_close'] = '</span>';

		$config['last_link'] = t('Last');
		$config['last_tag_open'] = '<span class="last_tag_open_pagination_cls">';
		$config['last_tag_close'] = '</span>';

		$config['prev_link'] = t('Previous');
		$config['prev_tag_open'] = '<span class="previous_tag_open_pagination_cls">';
		$config['prev_tag_close'] = '</span>';

		$config['next_link'] = t('Next');
		$config['next_tag_open'] = '<span class="next_tag_open_pagination_cls">';
		$config['next_tag_close'] = '</span>';

		$CI->pagination->initialize($config);

		return $CI->pagination->create_links(false);
	}
}

if (!function_exists('get_page'))
{
    function get_page($total_rows, $per_page, $cur_page)
    {
        $page = $cur_page;
        if (ceil($total_rows / $per_page) < $cur_page) {
            $page = $cur_page - 1;
        }

        return $page;
    }
}