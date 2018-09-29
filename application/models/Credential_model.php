<?php 

/*
  ****************************************************************************
  ***                                                                      ***
  ***      BIDONN 1.0                                                      ***
  ***      File:  credential_model.php                                     ***
  ***      Built: Mon June 11 13:25:50 2012                                ***
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


class Credential_model extends CI_Model {
	 
    // constructor
	 public function __construct()
     {
         parent::__construct();
				
      }//Controller End
	 

 /**
	 * Get the package
	 *
	 * @access	private
	 * @param	array data to insert the db.
	 */	 
	 function createPackageUser($insertData)
	 {
	 $this->db->insert('subscriptionuser', $insertData);
	 
	 }//Function createPackage End 
	 //----------------------------------------------------------
	 
	  /**
	 * Get certified user
	 *
	 * @access	private
	 * @param	array	conditions to fetch data
	 * @return	object	object with result set
	 */	 
	 
	 function getCertificateUser($condition=array())
	 {
	 
		 if(count($condition)>0)		
				$this->db->where($condition);
				 
			$this->db->select('subscriptionuser.id,subscriptionuser.user_id,subscriptionuser.package_id,subscriptionuser.valid,subscriptionuser.amount,subscriptionuser.flag,subscriptionuser.created');
			$result = $this->db->get('subscriptionuser');
			
			return $result;
	 }
	 //Function getCertificateUser End
	 //----------------------------------------------------------------------
	 
}
// End certificate_model Class
   
/* End of file credential_model.php */ 
/* Location: ./application/models/credential_model.php */
?>