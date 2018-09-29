<?php 

/*
  ****************************************************************************
  ***                                                                      ***
  ***      BIDONN 1.0                                                      ***
  ***      File:  bookmark_model.php                                       ***
  ***      Built: Mon June 19 11:41:24 2012                                ***
  ***      http://www.maventricks.com                                      ***
  ***                                                                      ***
  ****************************************************************************
  
   <Bidonn>
    Copyright (C) <2012> <Maventricks Technologies>.
 
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
	If you want more information, please email me at sathick@maventricks.com or 
    contact us from http://www.maventricks.com/contactus
*/

	 class bookmark_model extends CI_Model {
	 
	
	  // Constructor 
	 
	  function __construct() 
	  {
		parent::__construct();
				
      }//Controller End
	  
	// --------------------------------------------------------------------
	
		
	/**
	 * create Bookmark
	 *
	 * @access	public
	 * @param	string	the type of the flash message
	 * @param	string  flash message 
	 * @return	string	flash message with proper style
	 */
	 function createBookmark($insertData=array())
	 {
	 	$this->db->insert('bookmark', $insertData);
	 }//End of createBookmark Function
	 
	 // --------------------------------------------------------------------
	
	
	/**
	 * Get bookmark details
	 *
	 * @access	private
	 * @param	array	conditions to fetch data
	 * @return	object	object with result set
	 */
	 function getBookmark($conditions=array())
	 {
	 	if(count($conditions)>0)		
	 		$this->db->where($conditions);
			
		$this->db->from('bookmark');
			
	 	$this->db->select('bookmark.id,bookmark.creator_id,bookmark.creator_name,bookmark.job_id,bookmark.job_name,bookmark.job_creator');
		 
		$result = $this->db->get();
		return $result;
		
	 }//End of getBookmark Function
	 //-------------------------------------------------------------------------
}
// End bookmark_model Class
   
/* End of file bookmark_model.php */ 
/* Location: ./application/models/bookmark_model.php */