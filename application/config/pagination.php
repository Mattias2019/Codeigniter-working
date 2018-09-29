<?php
 /* ****************************************************************** */
if (!defined('BASEPATH')) exit('No direct script access allowed'); //No Direct Access

/*
|--------------------------------------------------------------------------
| Variables needed for pagination -- affects the whole site
|--------------------------------------------------------------------------
|
*/
$config['per_page'] 		= 10;
$config['uri_segment'] 		= 3;
$config['num_links'] 		= 5;
$config['full_tag_open'] 	= '<div id="paging"><div class="pagingnav"><p>';
$config['full_tag_close'] 	= '</p></div></div>';
$config['cur_tag_open'] 	= '<span class="clsActive">';
$config['cur_tag_close'] 	= '</span>';
$config['num_tag_open']		= '<span>';
$config['num_tag_close'] 	= '</span>';
$config['first_tag_open'] 	= '<span>';
$config['first_tag_close'] 	= '</span>';
$config['first_link'] 	  	= '&lt;&lt;';
$config['prev_link']	 	= '&lt;';
$config['last_tag_open'] 	= '<span>';
$config['last_tag_close'] 	= '</span>';
$config['last_link'] 		= '&gt;&gt;';
$config['next_link'] 		= '&gt;';
$config['next_tag_open'] 	= '<span>';
$config['next_tag_close'] 	= '</span>';
$config['prev_tag_open'] 	= '<span>';
$config['prev_tag_close'] 	= '</span>';
?>