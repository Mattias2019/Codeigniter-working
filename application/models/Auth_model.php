<?php
/*
  ****************************************************************************
  ***                                                                      ***
  ***      BIDONN 1.0                                                      ***
  ***      File:  auth_model.php                                           ***
  ***      Built: Mon June 15 13:25:50 2012                                ***
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


class Auth_model extends CI_Model {
	 
	 
	  // Constructor 
	
	  public function __construct() 
	  {
		parent::__construct();
				
      }//Controller End
	 
	// --------------------------------------------------------------------
		
	/**
	 * Get Users
	 *
	 * @access	private
	 * @param	array	conditions to fetch data
	 * @return	object	object with result set
	 */
	 function loginAsAdmin($conditions=array())
	 {
	 	if(count($conditions)>0)		
	 		$this->db->where($conditions);
			 
	 	$this->db->select('admins.id');
		$result = $this->db->get('admins');
		if($result->num_rows()>0)
			return true;
		else 
			return false;	
	 }//End of loginAsAdmin Function
	 
 	// --------------------------------------------------------------------
		
	/**
	 * Get Users
	 *
	 * @access	private
	 * @param	array	conditions to fetch data
	 * @return	object	object with result set
	 */
	 function setAdminSession($conditions=array())
	 {
	 	if(count($conditions)>0)		
	 		$this->db->where($conditions);
			 
	 	$this->db->select('admins.id,admins.admin_name');
		$result = $this->db->get('admins');
		if($result->num_rows()>0)
		{
			$row = $result->row();
			$values = array ('admin_id'=>$row->id,'logged_in'=>TRUE,'admin_role'=>'admin'); 
			$this->session->set_userdata($values);
		}
		
	 }//End of setAdminSession Function
	 
	    // --------------------------------------------------------------------
		
	/**
	 * Get Users
	 *
	 * @access	private
	 * @param	array	conditions to fetch data
	 * @return	object	object with result set
	 */
	 function setUserSession($row=NULL)
	 {
         $role = $row->role_name;
	     switch($role)
		 {
             case 'admin':

                 // TODO: rename role to role_name
                 $values = array('user_id'=>$row->id,
                                 'logged_in'=>TRUE,
                                 'role_id' => $row->role_id,
                                 'role' => $role, // role_name
                                 'name' => $row->user_name,
                                 'email' => $row->email,
                                 'url' => isset($this->config->roles->$role->url)?$this->config->roles->$role->url:""
                 );
                 $this->session->set_userdata($values);
                 break;

             case 'entrepreneur':

                 // TODO: rename role to role_name
				 $values = array('user_id'=>$row->id,
                                 'logged_in'=>TRUE,
                                 'role_id' => $row->role_id,
                                 'role' => $role, // role_name
                                 'name' => $row->user_name,
                                 'email' => $row->email,
                                 'url' => isset($this->config->roles->$role->url)?$this->config->roles->$role->url:""
                 );
				 $this->session->set_userdata($values);
				 break;

			 case 'provider':
                 if(isset($row->team_member_id) || (!empty($row->team_owner) && isset($row->status))) {
                     if($row->status == 0) {
                         $values = array('user_id'=>$row->team_owner,
                                         'logged_in'=>TRUE,
                                         'role_id' => $row->role_id,
                                         'role' => $role, // role_name
                                         'name' => $row->user_name,
                                         'email' => $row->email,
                                         'url' => isset($this->config->roles->$role->url)?$this->config->roles->$role->url:"",
                                         'access_team_owner'=>'0'
                         );
				     }
				     else {
				         $values = array('user_id'=>$row->team_owner,
                                         'logged_in'=>TRUE,
                                         'role_id' => $row->role_id,
                                         'role' => $role, // role_name
                                         'name' => $row->user_name,
                                         'email' => $row->email,
                                         'url' => isset($this->config->roles->$role->url)?$this->config->roles->$role->url:"",
                                         'admin'=>$row->admin,
                                         'new_quotes'=>$row->new_quotes,
                                         'edit_all_quotes'=>$row->edit_all_quotes,
                                         'edit_own_quotes'=>$row->edit_own_quotes,
                                         'view_all_project'=>$row->view_all_project,
                                         'view_assigned_project'=>$row->view_assigned_project,
                                         'new_portfolio'=>$row->new_portfolio,
                                         'view_portfolio'=>$row->view_portfolio,
                                         'edit_all_portfolio'=>$row->edit_all_portfolio,
                                         'edit_own_portfolio'=>$row->edit_own_portfolio,
                                         'team_member_id'=>$row->id
                         );
				     }
				     $this->session->set_userdata($values);
				 }
				 else {
                     $values = array('user_id'=>$row->id,
                                     'logged_in'=>TRUE,
                                     'role_id' => $row->role_id,
                                     'role' => $role, // role_name
                                     'name' => $row->user_name,
                                     'email' => $row->email,
                                     'url' => isset($this->config->roles->$role->url)?$this->config->roles->$role->url:"",
                     );
                     $this->session->set_userdata($values);
				 }
				 break;
		 }
	 	
	 }//End of setUserSession Function

     function setUserCookie($name='',$value ='',$expire = '',$domain='',$path = '/',$prefix ='') {

	 		 $cookie = array(
                   'name'   =>$name,
                   'value'  => $value,
                   'expire' => $expire,
                   'domain' => $domain,
                   'path'   => $path,
                   'prefix' => $prefix,
               );
			  set_cookie($cookie); 
      }//End of setUserCookie Function

		
		
	 function getUserCookie($name='')
	 {
		 $val=get_cookie($name,TRUE); 
		return $val;
	 }//End of getUserCookie Function		
	 
 
	  function clearUserCookie($name=array())
	 {
	 	foreach($name as $val)
		{
			delete_cookie($val);
		}	
	 }//End of clearSession Function*/
	 
	 
	// --------------------------------------------------------------------
		
	/**
	 * clearSession
	 *
	 * @access	private
	 * @param	array	conditions to fetch data
	 * @return	object	object with result set
	 */
	 function clearAdminSession()
	 {
	 
	 	$array_items = array ('admin_id' => '','logged_in_admin'=>'','admin_role'=>'');
	    $this->session->unset_userdata($array_items);
		
	 }//End of clearSession Function
	 
	// --------------------------------------------------------------------
		
	/**
	 * clearUserSession
	 *
	 * @access	private
	 * @param	array	conditions to fetch data
	 * @return	object	object with result set
	 */
	 function clearUserSession()
	 {
	 	$array_items = array('user_id','logged_in','role');
		$this->session->unset_userdata($array_items);
	 }
	 
}
// End Auth_model Class
   
/* End of file Auth_model.php */ 
/* Location: ./application/models/Auth_model.php */