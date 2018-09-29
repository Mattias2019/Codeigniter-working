<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('not_yet_active'))
{
	/**
	 * Check by status if project is not activated yet
	 *
	 * @param int $status
	 * @return bool
	 */
	function not_yet_active($status)
	{
		return (
			$status == Project_model::PROJECT_STATUS_QUOTE_REQUEST ||
			$status == Project_model::PROJECT_STATUS_DRAFT ||
			$status == Project_model::PROJECT_STATUS_NEW ||
			$status == Project_model::PROJECT_STATUS_PENDING ||
			$status == Project_model::PROJECT_STATUS_PLACED
		);
	}
}

if (!function_exists('is_editable'))
{
	/**
	 * Check by status if project is editable
	 *
	 * @param int $status
	 * @return bool
	 */
	function is_editable($status)
	{
		return (
			$status == Project_model::PROJECT_STATUS_QUOTE_REQUEST ||
			$status == Project_model::PROJECT_STATUS_DRAFT ||
			$status == Project_model::PROJECT_STATUS_NEW ||
			$status == Project_model::PROJECT_STATUS_PENDING
		);
	}
}