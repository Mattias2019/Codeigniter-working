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
 * @package	    Consultant Marketplace
 * @author	    Oprocon Dev Team
 * @copyright	Copyright (c) 2015 - 2016, Oprocon (https://consultant-marketplace.com/)
 * @link	    https://consultant-marketplace.com
 * @version     1.0.0
 */

class Settings_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get site settings
	 *
	 * @param $use_default_language
	 * @return array
	 * @throws Exception
	 */
	function getSiteSettings($use_default_language = TRUE)
	{
		$data = [];

		$res = $this->db->query("SELECT * FROM settings WHERE setting_type = 'S'");

		if (!$res) {
			throw_db_exception();
		}
		foreach ($res->result_array() as $setting) {
			switch ($setting['value_type']) {
				case 'I':
					$data[$setting['code']] = $setting['int_value'];
					break;
				case 'S':
					$data[$setting['code']] = $setting['string_value'];
					break;
				case 'T':
					// Get translation
					$data[$setting['code']] = $this->getSettingTranslation($setting['id'], $use_default_language);
					break;
				default:
					// Fallback
			}
		}
		return $data;
	}

	/**
	 * Set site settings
	 *
	 * @param array $data
	 * @throws Exception
	 */
	function updateSiteSettings($data = [])
	{
		$this->load->model('language_model');

		// Get current site settings
		$this->db->select('*');
		$this->db->from('settings');
		$this->db->where('setting_type', 'S');
		$res = $this->db->get();
		if (!$res) {
			throw_db_exception();
		}
		$current_data = $res->result_array();

		// Generate update array
		$update_data = [];
		$lang = $this->language_model->get_current_language_id();
		foreach ($current_data as $setting) {
			$code = strtolower($setting['code']);
			if (array_key_exists($code, $data)) {
				switch ($setting['value_type']) {
					case 'I':
						$update_data[] = ['code' => $setting['code'], 'int_value' => $data[$code], 'created' => get_est_time()];
						break;
					case 'S':
						$update_data[] = ['code' => $setting['code'], 'string_value' => $data[$code], 'created' => get_est_time()];
						break;
					case 'T':
						$update_data[] = ['code' => $setting['code'], 'created' => get_est_time()];
						$this->db->update('settings_translations', ['text_value' => $data[$code]], ['setting_id' => $setting['id'], 'language_id' => $lang]);
						break;
					default:
						// Fallback
				}
			}
		}

		// Update data
		$this->db->update_batch('settings', $update_data, 'code');
	}

	/**
	 * @param $setting_id
	 * @param $use_default_language
	 * @return string
	 */
	private function getSettingTranslation($setting_id, $use_default_language)
	{
		$lang = $this->config->item('language');
		$res = $this->db->select('t.text_value')->
			join('languages AS l', 't.language_id = l.id')->
			where('t.setting_id', $setting_id)->
			where('l.name', $lang)->
			get('settings_translations AS t')->
			row();

		if (isset($res))
		{
			return $res->text_value;
		}
		elseif ($use_default_language)
		{
			$res = $this->db->select('t.text_value')->
				join('languages AS l', 't.language_id = l.id')->
				where('t.setting_id', $setting_id)->
				where('l.default_language', 1)->
				get('settings_translations AS t')->
				row();

			if (isset($res))
			{
				return $res->text_value;
			}
			else
			{
				return '';
			}
		}
		else
		{
			return '';
		}
	}



	// --------------------------------------------------------------------
	/**
	 * Get Social Networks Information.
	 *
	 * @access    private
	 * @param    array    update information related to site
	 * @return    void
	 */
	function updateNetworks($updateData = array())
	{
		$data = array('site_url' => $updateData['Facebook']);
		$this->db->where('site_name', 'Facebook');
		$this->db->update('social_networks', $data);

		$data = array('site_url' => $updateData['Twitter']);
		$this->db->where('site_name', 'Twitter');
		$this->db->update('social_networks', $data);

		$data = array('site_url' => $updateData['RSS']);
		$this->db->where('site_name', 'RSS');
		$this->db->update('social_networks', $data);

		$data = array('site_url' => $updateData['linkedin']);
		$this->db->where('site_name', 'linkedin');
		$this->db->update('social_networks', $data);
	}

	// --------------------------------------------------------------------
	/**
	 * Get Social Networks Information.
	 *
	 * @access    private
	 * @param    array    update information related to site
	 * @return    void
	 */
	function setCurrency($conditions = array())
	{
		if (count($conditions) > 0)
			$this->db->where($conditions);

		$this->db->from('currency');
		$this->db->select('currency.id,currency.currency_name,currency.currency_type,currency.currency_symbol');
		$result = $this->db->get();
		return $result;
	}

}