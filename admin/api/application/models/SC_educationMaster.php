<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class SC_educationMaster extends MY_Model {
	public function __construct() {
		parent::__construct ();
	}
	
	
	public function addSchool($userdata) {
		$this->_table = 'school';
		$result = $this->db->select ( 'id,school_name as name,district_id,city_id,county_id,state_id,country_id,isActive' )->from ( $this->_table )->where ( 'school_name', $userdata ['name'] )->get ()->row ();
		// print_r($result); return ;
		
		if ($result) {
			return "School Already Exist";
		} else {
			$user = array (
					'school_name' => $userdata ['name'],
					'district_id' => $userdata ['district_id'],
					'city_id' => $userdata ['city_id'],
					'county_id' => $userdata ['county_id'],
					'state_id' => $userdata ['state_id'],
					'country_id' => $userdata ['country_id']
					
			);
			
			return $this->insert ( $user );
		}
	}
	
	
	public function updateSchool($userdata) {
		$this->_table = 'school';
		$result = $this->db->select ( 'id,school_name as name,district_id,city_id,county_id,state_id,country_id,isActive' )->from ( $this->_table )->where ( 'id', $userdata ['id'] )->get ()->row ();
	
	
		if ($result) {
			$result2 = $this->db->select ( 'id,school_name as name,district_id,city_id,county_id,state_id,country_id,isActive' )->from ( $this->_table )->where ( 'school_name ', $userdata ['name'] )->where ( 'id !='. $userdata ['id'] )->get ()->row ();
			//print_r($result2);return ;
			if($result2)
			{
				return "OK";
			}
			else
			{
				$user = array (
							
						'school_name' => $userdata ['name'],
						'district_id' => $userdata ['district_id'],
						'city_id' => $userdata ['city_id'],
						'county_id' => $userdata ['county_id'],
						'state_id' => $userdata ['state_id'],
						'country_id' => $userdata ['country_id'],
						'isActive' => $userdata ['isActive']
				);
					
				// return $userdata;
				if ($this->update ( $userdata ['id'], $user )) {
					return $userdata ['id'];
				} else {
					return FALSE;
				}
			}
		} else {
			return "Data not found";
		}
	}
	
	public function getSchool() {
		$this->_table = 'school';
		return $this->db->select ( 'id,school_name as name,district_id,city_id,county_id,state_id,country_id,isActive' )
				->from ( $this->_table )
				
				->get ()->result ();
	}
	
	
	public function getaddedSchool($userdata) {
		$this->_table = 'school';
		return $this->db->select ( 'id,school_name as name,district_id,city_id,county_id,state_id,country_id,isActive' )->from ( $this->_table )->where ( 'id', $userdata )->get ()->row ();
	}
	public function getallCountry() {
		$this->_table = 'country';
		return $this->db->select ( 'id,country_name as name,isActive' )->from ( $this->_table )->where ( 'isActive', 1 )->get ()->result ();
	}
}
?>