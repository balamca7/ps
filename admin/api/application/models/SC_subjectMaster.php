<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class SC_subjectMaster extends MY_Model {
	public function __construct() {
		parent::__construct ();
	}
	public function addCategory($userdata) {
		$this->_table = 'department';
		$result = $this->db->select ( 'id,name,isActive' )->from ( $this->_table )->where ( 'name', $userdata ['name'] )->get ()->row ();
		// print_r($result); return ;
		
		if ($result) {
			return "Department Already Exist";
		} else {
			$user = array (
					'name' => $userdata ['name'] 
			)
			;
			
			return $this->insert ( $user );
		}
	}
	public function getaddedCategory($userdata) {
		$this->_table = 'department';
		return $this->db->select ( 'id,name,isActive' )->from ( $this->_table )->where ( 'id', $userdata )->get ()->row ();
	}
	public function getCategory() {
		$this->_table = 'department';
		return $this->db->select ( 'id,name,isActive' )->from ( $this->_table )->get ()->result ();
	}
	public function updateCategory($userdata) {
		$this->_table = 'department';
		$result = $this->db->select ( 'id,name,isActive' )->from ( $this->_table )->where ( 'id', $userdata ['id'] )->get ()->row ();
		
		
		if ($result) {
			$result2 = $this->db->select ( 'id,name,isActive' )->from ( $this->_table )->where ( 'name', $userdata ['name'] )->where ( 'id !='. $userdata ['id'] )->get ()->row ();
			//print_r($result2);return ;
			if($result2)
			{
				return "OK";
			}
	    	else
	    	{
					$user = array (
							
							'name' => $userdata ['name'],
							'isActive' => $userdata ['isActive'] 
					);
					
					// return $userdata;
					if ($this->update ( $userdata ['id'], $user )) {
						return $user;
					} else {
						return FALSE;
					}
				}
		} else {
			return "Data not found";
		}
	}
	public function addsubCategory($userdata) {
		$this->_table = 'designation';
		$result = $this->db->select ( 'id,name,isActive' )->from ( $this->_table )->where ( 'name', $userdata ['name'] )->where ( 'category_id', $userdata ['category_id'] )->get ()->row ();
		// print_r($result); return ;
		
		if ($result) {
			return "Designation Already Exist";
		} else {
			$user = array (
					'name' => $userdata ['name'],
					'category_id' => $userdata ['category_id'] 
			)
			;
			
			return $this->insert ( $user );
		}
	}
	public function getcategoryById($userdata) {
		$this->_table = 'department';
		return $this->db->select ( 'id,name' )->from ( $this->_table )->where ( 'id', $userdata )->get ()->row();
	}
	public function getaddsubCategory($userdata) {
		$this->_table = 'designation';
		return $this->db->select ( 'id,name,department_id,isActive' )->from ( $this->_table )->where ( 'id', $userdata )->get ()->row ();
	}
	public function getallCategory() {
		$this->_table = 'department';
		return $this->db->select ( 'id,name,isActive' )->from ( $this->_table )->where ( 'isActive', 1 )->get ()->result ();
	}
	public function getsubCategory() {
		$this->_table = 'designation';
		return $this->db->select ( 'id,name,department_id, , (select name from department where id= department_id) AS department,isActive' )->from ( $this->_table )->get ()->result ();
	}
	
	
	public function updatesubCategory($userdata) {
		$this->_table = 'designation';
		$result = $this->db->select ( 'id,name,isActive' )->from ( $this->_table )->where ( 'id', $userdata ['id'] )->get ()->row ();
	
	
		if ($result) {
			$result2 = $this->db->select ( 'id,name,isActive' )->from ( $this->_table )->where ( 'name', $userdata ['name'] )->where ( 'id !='. $userdata ['id'] )->get ()->row ();
			//print_r($result2);return ;
			if($result2)
			{
				return "OK";
			}
			else
			{
				$user = array (
							
						'name' => $userdata ['name'],
						'department_id' => $userdata ['department_id'],
						'isActive' => $userdata ['isActive']
				);
					
				// return $userdata;
				if ($this->update ( $userdata ['id'], $user )) {
					return $user;
				} else {
					return FALSE;
				}
			}
		} else {
			return "Data not found";
		}
	}
	//---------------------------Grade----------------------------------------
	
	public function getGrades() {
		$this->_table = 'grades';
		return $this->db->select ( ' id,grade as name,percentage_from as from ,percentage_to as to,isActive' )->from ( $this->_table )->get ()->result ();
	}
	
	public function addGrade($userdata) {
	$this->_table = 'grades';
		$result = $this->db->select ( ' id,grade as name,percentage_from,percentage_to,isActive' )->from ( $this->_table )
				
		->where ( 'grade= "'. $userdata ['name'].'" or percentage_from ='. $userdata ['from'].' and  percentage_to ='. $userdata ['to'] )->get ()->row ();
		// print_r($result); return ;
	
		if ($result) {
			return "Grade Already Exist";
		} else {
			$user = array (
					'grade' => $userdata ['name'],
					'percentage_from' => $userdata ['from'],
					'percentage_to' => $userdata ['to']
			)
			;
				
			return $this->insert ( $user );
		}
	}
	public function getaddedgrade($userdata) {
		$this->_table = 'grades';
		return $this->db->select ( ' id,grade as name,percentage_from as from,percentage_to as to,isActive' )->from ( $this->_table )->where ( 'id', $userdata )->get ()->row ();
	}
	public function updateGrade($userdata) {
		$this->_table = 'grades';
		$result = $this->db->select ( 'id,grade as name,percentage_from,percentage_to,isActive' )->from ( $this->_table )->where ( 'id', $userdata ['id'] )->get ()->row ();
	
	
		if ($result) {
			$result2 = $this->db->select ( 'id,grade as name,percentage_from,percentage_to,isActive' )->from ( $this->_table )->where ( 'grade', $userdata ['name'] )->where ( 'id !='. $userdata ['id'] )->get ()->row ();
			//print_r($result2);return ;
			if($result2)
			{
				return "OK";
			}
			else
			{
				$user = array (
							
						'grade' => $userdata ['name'],
						'percentage_from' => $userdata ['from'],
						'percentage_to' => $userdata ['to'],
						'isActive' => $userdata ['isActive']
				);
					
				// return $userdata;
				if ($this->update ( $userdata ['id'], $user )) {
					return $user;
				} else {
					return FALSE;
				}
			}
		} else {
			return "Data not found";
		}
	}
}
?>