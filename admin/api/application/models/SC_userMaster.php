<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class SC_userMaster extends MY_Model {
	public function __construct() {
		parent::__construct ();
	}

	//----------------------------UserDetails---------------------------------------
	
	public function getUserdetails() {
		$this->_table = 'user_master';
		
		$this->db->select ( 'id, user_id, concat(f_name,l_name) AS Name,email_1 as Email,telephone,tutor_type, Date_format(created_on, "%d-%b-%y") as Date,if(status = "Active",1,0) as isActive ' );
		$sub = $this->subquery->start_subquery ( 'select' );
		$sub->select ( 'school_name' )->from ( 'school' );
		$sub->where ( $this->_table . '.school_id = school.id' );
		$this->subquery->end_subquery ( 'school' );
		$this->db->from ( $this->_table );
		$this->db->order_by ( 'id', 'Asc' );		
		return $this->db->get ()->result ();
		
	}
	public function updateUserdetails($userdata) {
		$this->_table = 'user_master';
		$result = $this->db->select ( 'id,status' )->from ( $this->_table )->where ( 'id', $userdata ['id'] )->get ()->row ();
			if($result)
			{
				$user = array (
									
						'status' => ( $userdata ['isActive'] == 1 ? "Active" : "In Active" )
						
				);
					
				// return $userdata;
				if ($this->update ( $userdata ['id'], $user )) {
					return $userdata;
				} else {
					return FALSE;
				}
			
	    	
		} else {
			return "Data not found";
		}
	}
	
	public function getaddedDetails($userdata) {
		//print_r($userdata);return ;
		$this->_table = 'user_master';
		$this->db->select ( 'id, user_id, concat(f_name,l_name) AS Name,email_1 as Email,telephone,tutor_type,created_on as Date,if(status = "Active",1,0) as isActive ' );
		$sub = $this->subquery->start_subquery ( 'select' );
		$sub->select ( 'school_name' )->from ( 'school' );
		$sub->where ( $this->_table . '.school_id = school.id' );
		$this->subquery->end_subquery ( 'school' );
		$this->db->from ( $this->_table );
		$this->db->where ( 'id', $userdata['id']);
		return $this->db->get ()->row();
	}

	
}
?>