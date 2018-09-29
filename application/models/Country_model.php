<?php

/**
 * Created by PhpStorm.
 * User: geymur-vs
 * Date: 10.08.17
 * Time: 18:00
 */
    class Country_model extends CI_Model
    {

        /**
         * Constructor
         *
         */
        public function __construct()
        {
            parent::__construct();

        }//Controller End

        // --------------------------------------------------------------------

        /**
         * Set Style for the flash messages
         *
         * @access	public
         * @param	string	the type of the flash message
         * @param	string  flash message
         * @return	string	flash message with proper style
         */

        function getCountries()
        {
            $this->db->select('id, country_name');
            $query = $this->db->get('country');
            return $query->result();
        }

        function find_by_id($id)
        {
            $query = $this->db->get_where('country', ['id'=>$id]);
            if(count($query->result_array()) >0){
                return $query->result_array()[0];
            }
            return null;

        }
    }
?>