<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// ------------------------------------------------------------------------

/**
 * Build side menu
 *
 * @access public
 * @param  string
 * @param  string
 * @return string
 */
function render_sidemenu($upper_menu, $menu, $resource)
{
	$CI =& get_instance();

	$html = '';
	$ul = false;
	$i = 1;

	$count = count($menu);

	foreach ($menu as $key => $value) {

		$isAllowed = menu_isAllowed($value);
		if ($isAllowed) {
			if (!$ul) {
				$html = '<ul class="sub-menu collapse '.(is_resource_here($menu, $resource)?'in':'').'" id="'.$upper_menu.'_submenu">';
				$ul = true;
			}
			$url = isset($value['items'])?"#".$key.'_submenu':site_url($value['resource']);

			$html = $html . '<li class="nav-item'.($value['resource'] == $resource?' active':'').'"> ';
			$html = $html . '<a href="' . $url . '" class="nav-link"'.(isset($value['items'])?' data-toggle="collapse"':'').'> ';
			$html = $html . '<span class="title">' . t($value['label']) . '</span> ';

			if (isset($value['badge_data']) and array_key_exists($value['badge_data'], $CI->outputData) and $CI->outputData[$value['badge_data']] > 0) {
				$html = $html . '<span class="badge navbar-right">'.$CI->outputData[$value['badge_data']].'</span>';
			}

			if (isset($value['items'])) {
				$html = $html . '<span class="fa fa-caret-down navbar-right"></span>';
				$html = $html . '</a> ';
				$html = $html . render_sidemenu($key, $value['items'], $resource);
			}
			else {
				$html = $html . '</a> ';
			}
			$html = $html . '</li> ';
		}

		if ($i == $count) {
			$html = $html . '</ul>';
		}

		$i++;
	}
	return $html;
}

/**
 * Build side menu
 *
 * @access public
 * @param  string
 * @return string
 */
function menu_isAllowed($menu)
{
	$CI =& get_instance();

	$isAllowed = false;

	if (isset($menu['items'])) {

		foreach ($menu['items'] as $key1 => $value1) {

			$isAllowed = menu_isAllowed($value1);
			if ($isAllowed) {
				return $isAllowed;
			}
		}
	}
	else {
		return $isAllowed = $CI->acl->isAllowed($menu['resource'], $menu['privilege']);
	}

	return $isAllowed;
}

function is_resource_here($menu, $resource)
{
	$result = false;

	foreach ($menu as $key => $value) {

		if ($resource == $value['resource'] or (isset($value['additional_resources']) and in_array($resource, $value['additional_resources']))) {
			$result = true;
		}

		if (isset($value['items']) && !$result) {
			$result = is_resource_here($value['items'], $resource);
		}
	}
	return $result;
}

function get_menu_label_by_resource($sidebar_menu, $resource)
{
    $CI =& get_instance();

    $result = '';

    foreach ($sidebar_menu as $key => $value) {

        if ( (  $resource == $value['resource']
                or
                (isset($value['additional_resources']) and in_array($resource, $value['additional_resources']))
             )
             and
             $CI->acl->isAllowed($value['resource'], $value['privilege'])
           )
        {
            $result = $value['label'];
            break;
        }

        if (isset($value['items']) && !$result) {
            $result = get_menu_label_by_resource($value['items'], $resource);
        }
    }
    return $result;
}
/* End of file sidemenu_helper.php */
/* Location: ./application/helpers/sidemenu_helper.php */