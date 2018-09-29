<?php 

/*
  ****************************************************************************
  ***                                                                      ***
  ***      BIDONN 1.0                                                      ***
  ***      File:  admin_model.php                                          ***
  ***      Built: Mon June 25 10:34:30 2012                                ***
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

	 class Admin_model extends CI_Model {
	 
	/**
	 * Constructor 
	 *
	 */
	  function __construct() 
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
	 function getUsers($conditions=array(),$fields='')
	 {
	 	if(count($conditions)>0)		
	 		$this->db->where($conditions);
			
		
		$this->db->from('users');
		$this->db->join('user_balance', 'user_balance.id = users.id','left');
		 $this->db->join('country', 'country.id = users.country_id','left');
		
		if($fields!='')
				$this->db->select($fields);
		else 		
	 		$this->db->select('users.id,user_balance.amount,user_balance.user_id,users.user_name,users.name,users.role_id,country.country_name,users.message_notify,users.password,users.email,users.city,users.state,users.profile_desc,users.rate,users.job_notify,users.user_status,users.activation_key,users.created,users.last_activity,users.num_reviews,users.user_rating,users.logo');
		 
		$result = $this->db->get();
		return $result;
		
	 }//End of getUsers Function
	 
	 // --------------------------------------------------------------------
	 
	  /**
	 * Get Jobs
	 *	
	 * @access	private
	 * @param	array	conditions to fetch data
	 * @return	object	object with result set
	 */
	 function getProjectsdetails1($cond1='',$cond2='',$limit=array(),$status='')
	 {
		$query = "SELECT * FROM jobs WHERE job_status='$status' and FROM_UNIXTIME(created, '$cond1') = '$cond2'";
		$res = $this->db->query($query);
		return $res;
	 }//End of getProjects Function
	 
	 // --------------------------------------------------------------------
	 
	 
	 
	 
	 /**
	 * Get Projects
	 *	
	 * @access	private
	 * @param	array	conditions to fetch data
	 * @return	object	object with result set
	 */
	 function getProjectsdetails($cond1='',$cond2='',$limit=array(),$status='',$orderby = array())
	 {
	 
	 	if(is_array($limit))		
		{
			if(count($limit)==1)
	 			$this->db->limit($limit[0]);
			else if(count($limit)==2)
				$this->db->limit($limit[0],$limit[1]);
		}	
	 if(is_array($orderby) and count($orderby)>0)
			$this->db->order_by($orderby[0], $orderby[1]);
			
		$query = "SELECT * FROM jobs WHERE job_status='$status' and FROM_UNIXTIME(created, '$cond1') = '$cond2'";
	  	$res = $this->db->query($query);
		
		return $res;
	 }//End of getProjects Function
	 
	 // --------------------------------------------------------------------
	 
	 /**
	 * Get Projects
	 *	
	 * @access	private
	 * @param	array	conditions to fetch data
	 * @return	object	object with result set
	 */
	 function getProjects1($cond1='',$cond2='',$cond3='')
	 {
		$query = "SELECT * FROM jobs WHERE FROM_UNIXTIME(created, '$cond1') = '$cond2' AND '$cond3'";
		
	  	$res = $this->db->query($query);
		return $res;
	 }//End of getProjects Function
	 
	 // --------------------------------------------------------------------
	 
	  /**
	 * Get Projects
	 *	
	 * @access	private
	 * @param	array	conditions to fetch data
	 * @return	object	object with result set
	 */
	 
	  function gettodayProjects($cond1='',$cond2='',$limit = array(),$orderby = array())
	 {
			$from= strtotime(date("Y-m-d 00:00:00"));
		    $to=strtotime(date("Y-m-d 23:59:59"));
				

		//$query = "SELECT * FROM jobs WHERE FROM_UNIXTIME(created, '$cond1') = '$cond2' limit $limit[1],$limit[0]";
		//$query = "SELECT * FROM jobs WHERE FROM_UNIXTIME(created, '$cond1') = '$cond2'";
		$query = "SELECT * FROM jobs WHERE created >= '$from' and created<='$to' ";

		if(is_array($orderby) and count($orderby)>0)
		{$query.=' order by '.$orderby[0].' '.$orderby[1];
			}
			
		if(is_array($limit))		
		{
			if(count($limit)==1)
	 			$query.=' limit '.$limit[0];
		else if(count($limit)==2)
			$query.=' limit '.$limit[1] .','. $limit[0];
		}	

			$res = $this->db->query($query);
		return $res;
	 }//End of getProjects Function
	 
	 function getProjects($cond1='',$cond2='',$limit = array(),$orderby = array())
	 {
			
			

		//$query = "SELECT * FROM jobs WHERE FROM_UNIXTIME(created, '$cond1') = '$cond2' limit $limit[1],$limit[0]";
		$query = "SELECT * FROM jobs WHERE FROM_UNIXTIME(created, '$cond1') = '$cond2'";

		if(is_array($orderby) and count($orderby)>0)
		{$query.=' order by '.$orderby[0].' '.$orderby[1];
			}
			
		if(is_array($limit))		
		{
			if(count($limit)==1)
	 			$query.=' limit '.$limit[0];
		else if(count($limit)==2)
			$query.=' limit '.$limit[1] .','. $limit[0];
		}	

			$res = $this->db->query($query);
		return $res;
	 }//End of getProjects Function
	 
	 // --------------------------------------------------------------------
	 
	 /**
	 * Get Projects report violation
	 *	
	 * @access	private
	 * @param	array	conditions to fetch data
	 * @return	object	object with result set
	 */
	 function getReports($conditions=array(),$fields='',$like=array(),$limit=array(),$orderby = array())
	 {
	 	//Check For Conditions
	 	if(is_array($conditions) and count($conditions)>0)		
	 		$this->db->where($conditions);
			
		//Check For like statement
	 	if(is_array($like) and count($like)>0)		
	 		$this->db->like($like);	
			
		//Check For Limit	
		if(is_array($limit))		
		{
			if(count($limit)==1)
	 			$this->db->limit($limit[0]);
			else if(count($limit)==2)
				$this->db->limit($limit[0],$limit[1]);
		}	
		//pr($orderby);
		//Check for Order by
		if(is_array($orderby) and count($orderby)>0)
			$this->db->order_by($orderby[0], $orderby[1]);
			
		$this->db->from('report_violation');
		$this->db->join('jobs', 'jobs.id = report_violation.job_id','left');
		//Check For Fields	 
		if($fields!='')
				$this->db->select($fields);
		else 		
	 		$this->db->select('report_violation.id,report_violation.job_id,report_violation.job_name,report_violation.post_id,report_violation.report_type,report_violation.comment,report_violation.report_date,jobs.job_name,jobs.creator_id');
			
		$result = $this->db->get();
		//pr($result->result());exit;
		return $result;
		
	 }//End of getProjects Function
	 // --------------------------------------------------------------------
	 
	  /**
	 * delete report violation
	 *	
	 * @access	private
	 * @param	array	conditions to fetch data
	 * @return	object	object with result set
	 */
	 function deleteReport($conditions=array())
	 {
	 	if(isset($conditions) and count($conditions) > 0)
		  $this->db->where($conditions);
		$this->db->delete('report_violation');  
	 }
}	
	
// End Admin_model Class
   
/* End of file Admin_model.php */ 
/* Location: ./application/models/Admin_model.php */
?>