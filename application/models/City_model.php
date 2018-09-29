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

// Database source
// http://simplemaps.com/data/world-cities

class City_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * Get city coordinates by name
	 *
	 * @param $city
	 * @param $country
	 * @param $state
	 * @return array|null
	 * @throws Exception
	 */
	function get_city_coordinates($city, $country, $state)
	{
		// First try to get direct match
		$this->db->select('lat, lng, province');
		$this->db->from('cities');
		$this->db->where("(LOWER(city) = '".strtolower($city)."' OR LOWER(city_ascii) = '".strtolower($city)."')", NULL, FALSE);
		$this->db->where('iso2', $country);
		$this->db->order_by('pop', 'DESC'); // Biggest first

		$res1 = $this->db->get();
		if (!$res1)
		{
			throw_db_exception();
		}

		$res1 = $res1->result_array();
		$count = count($res1);
		if ($count == 1)
		{
			// One and only one match found
			return ['lat' => $res1[0]['lat'], 'lng' => $res1[0]['lng']];
		}
		elseif ($count > 1)
		{
			// Try to limit by state/province
			for ($i = 0; $i < $count; $i++)
			{
				if (strtolower($res1[$i]['province']) == strtolower($state))
				{
					return ['lat' => $res1[$i]['lat'], 'lng' => $res1[$i]['lng']];
				}
			}
			// If not found, just return biggest
			return ['lat' => $res1[0]['lat'], 'lng' => $res1[0]['lng']];
		}
		else
		{
			// If everything else fails, return the biggest city in country
			return $this->get_biggest_city_in_country($country);
		}
	}

	/**
	 * Get coordinates of the biggest city in country (more often than not it's capital)
	 *
	 * @param $country
	 * @return array|null
	 * @throws Exception
	 */
	function get_biggest_city_in_country($country)
	{
		$this->db->select('lat, lng');
		$this->db->from('cities');
		$this->db->where('iso2', $country);
		$this->db->order_by('pop', 'DESC');

		$res = $this->db->get();
		if (!$res)
		{
			throw_db_exception();
		}

		$res = $res->result_array();
		if (count($res) > 0)
		{
			return $res[0];
		}
		else
		{
			return NULL;
		}
	}
}