<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SC_Grading extends MY_Model {
    
    public function __construct() {
        parent::__construct();
    }

    public function getCountryList() {
        $this->_table = 'country';
        return $this->db->select('id, country_name AS name')
                        ->from($this->_table)
                        ->where('isActive', 1)
                        ->get()
                        ->result();
    }

    public function getCountryName($id) {
    	$this->_table = 'country';
    	return $this->db->select('id, country_name AS name')
    	->from($this->_table)
    	->where('isActive', 1)
    	->where('id', $id)
    	->get()
    	->row();
    }
    
    
    public function getStatesList($country_id){
    	
    	if($country_id == "All")
    	{
    		$where = array('isActive' => 1, "country_id IS NOT NULL");
    	}
    	else {
    		$where = array('isActive' => 1, 'country_id' => $country_id);
    	}
    	
    	$this->_table = 'states';
    	return $this->db->select('id, state AS name')
    	->from($this->_table)
    	->where($where)
    	->get()
    	->result();
    }
    
    public function getStateName($id){
    	 
    	$this->_table = 'states';
    	return $this->db->select('id, state AS name')
    	->from($this->_table)
    	->where('isActive', 1)
    	->where('id', $id)
    	 ->get()
    	->row();
    }
    public function getDistrictList($state_id){
    	if($state_id == "All")
    	{
    		$where = array('isActive' => 1, "state_id IS NOT NULL");
    	}
    	else {
    		$where = array('isActive' => 1, 'state_id' => $state_id);
    	}
    	
    	$this->_table = 'district_master';
    	$result = $this->db->select('id, district_name AS name')
    	->from($this->_table)
    	->where($where)
    	->get()
    	->result();
    	
    	//echo $this->db->last_query();
    	return $result;
    }
    
    public function getCityList($state_id){
    	if($state_id == "All")
    	{
    		$where = array('isActive' => 1, "state_id IS NOT NULL");
    	}
    	else {
    		$where = array('isActive' => 1, 'state_id' => $state_id);
    	}
    	 
    	$this->_table = 'cities';
    	return $this->db->select('id, city_name AS name')
    	->from($this->_table)
    	->where($where)
    	->get()
    	->result();
    }
    public function getCountyList($state_id){
    	if($state_id == "All")
    	{
    		$where = array('isActive' => 1, "state_id IS NOT NULL");
    	}
    	else {
    		$where = array('isActive' => 1, 'state_id' => $state_id);
    	}
    	 
    	$this->_table = 'county';
    	return $this->db->select('id, county_name AS name')
    	->from($this->_table)
    	->where($where)
    	->get()
    	->result();
    }
    
    public function getDistrictName($id){
    	 
    	$this->_table = 'district_master';
    	return $this->db->select('id, district_name AS name')
    	->from($this->_table)
    	->where('isActive', 1)
    	->where('id', $id)
    	 ->get()
    	->row();
    }
    public function getSchoolList($district_id){
    	
    	if($district_id == "All")
    	{
    		$where = array('isActive' => 1, "district_id IS NOT NULL");
    	}
    	else {
    		$where = array('isActive' => 1, 'district_id' => $district_id);
    	}
    	 
    	
    	$this->_table = 'school';
    	return $this->db->select('id, school_name AS name')
    	->from($this->_table)
    	->where($where)
    	->get()
    	->result();
    }
 
    public function getSchoolName($id){
    	 
    	$this->_table = 'school';
    	return $this->db->select('id, school_name AS name')
    	->from($this->_table)
    	->where('isActive', 1)
    	->where('id', $id)
    	->get()
    	->row();
    	}
    	public function getCityName($id){
    	
    		$this->_table = 'cities';
    		return $this->db->select('id, city_name AS name')
    		->from($this->_table)
    		//->where('isActive', 1)
    		->where('id', $id)
    		->get()
    		->row();
    	}
    	public function getCountyName($id){
    		 
    		$this->_table = 'county';
    		return $this->db->select('id, county_name AS name')
    		->from($this->_table)
    		->where('isActive', 1)
    		->where('id', $id)
    		->get()
    		->row();
    	}
   
    public function getCityCountyName($school_id){
    	$this->_table = 'school';
    	$result = $this->db->select('(select City_name FROM cities where id=city_id) As city, (select county_name FROM county where id=county_id) As county')
    	->from($this->_table)
    	->where('id=', $school_id)
    	->get()
    	->row();
		return $result;    	 
    }
    
    public function getUserDetails($userID)
    {
    	$this->_table = "user_master";
    	$result = $this->db->select('id, user_id, CONCAT(f_name, " " ,l_name) AS name, email_1 AS email, mobile_num AS mobile, telephone as phone, imagepath as image')
    	->from($this->_table)
    	->where('user_id', $userID)
    	->get()
    	->row();
    	//$result->image = "data:image/jpeg;base64," . base64_encode ( $result->image );
    	return $result;
    }
    
    public function getimage($userID){
    	$query2 = $this->db->query("SELECT image FROM user_master WHERE user_id = '$userID'")->row();
    	return "data:image/jpeg;base64," . base64_encode ( $query2->image );
    }
    
    public function getGrades() {
        $this->_table = 'grades';
        return $this->db->select(' id, grade AS name')
                        ->from($this->_table)
                        ->where('isActive', 1)
                        ->get()
                        ->result();
    }

    public function getCategory() {
        $this->_table = 'category';
        return $this->db->select('id, name')
                        ->from($this->_table)
                        ->where('isActive', 1)
                        ->get()
                        ->result();
    }
	  public function getDepartment() {
        $this->_table = 'department';
        return $this->db->select('id, name')
                        ->from($this->_table)
                        ->where('isActive', 1)
                        ->get()
                        ->result();
    }
	
	 public function getDesignation($department_id) {
    	$this->_table = 'designation';
    	return $this->db->select('id, name')
    	->from($this->_table)
    	->where(array('isActive' => 1, 'department_id' => $department_id))
    	->get()
    	->result();
    }
	
	public function getAllDesignation() {
    	$this->_table = 'designation';
    	return $this->db->select('id, name')
    	->from($this->_table)
    	->get()
    	->result();
    }
	

	
	public function getcomp() {
        $this->_table = 'company';
        // return $this->db->select('id,name')
        return $this->db->select('*')
                        ->from($this->_table)
						->where('status',1)
                        ->get()
                        ->result();
    }
    
    public function getSubCategory($category_id) {
    	$this->_table = 'subcategory';
    	return $this->db->select('id, name')
    	->from($this->_table)
    	->where(array('isActive' => 1, 'category_id' => $category_id))
    	->get()
    	->result();
    }
    
    public function getAllUsersGroups()
    {
    	
//    	$result = $this->db->query("(SELECT 'All' AS id, 'All' AS user_id, 'User' ) UNION ALL (SELECT user_id AS id, user_id, 'User' FROM user_master)  UNION ALL (SELECT id, group_name AS user_id, 'Group' FROM group_master)")
    	$result = $this->db->query("(SELECT 'All' AS id, 'All' AS user_id, '' AS image, 'User' ) UNION ALL (SELECT id, user_id, imagepath as image, 'User' FROM user_master)  UNION ALL (SELECT id, group_name AS user_id, imagepath as image, 'Group' FROM group_master)")
    				->result();
    	
/*     	foreach ($result as $userGroups) {
    		if($userGroups->image != null && $userGroups->image != "")
    		{
    			$userGroups->image = "data:image/jpeg;base64," . base64_encode ( $userGroups->image );
    		}
    		else {
    			if($userGroups->User == "User")
    			{
    				$userGroups->image = "dist/img/user.png";
    			}
    			else 
    			{
    				$userGroups->image = "dist/img/user_group.png";
    			}
    		}
    	}
 */		return $result;    				
    	 
    }
    
    public function getSubjectById($subjectId) {
        $this->_table = 'category';
        return $this->db->select('id, name')
                        ->from($this->_table)
                        ->where('id', $subjectId)
                        ->get()
                        ->row();
    }
    
    public function getSubCategoryById($subjectId) {
    	$this->_table = 'subcategory';
    	return $this->db->select('id, name')
    	->from($this->_table)
    	->where('id', $subjectId)
    	->get()
    	->row();
    }
 
    public function getCountrybyId($id) {
    	$this->_table = 'country';
    	return $this->db->select ( 'id,country_name as name' )->from ( $this->_table )->where ( 'id', $id )->get ()->row ();
    }
    
    
    public function getStatebyId($id) {
    	$this->_table = 'states';
    	return $this->db->select ( 'id,state as name' )->from ( $this->_table )->where ( 'id', $id )->get ()->row ();
    }
    
    public function getCitybyId($id) {
    	$this->_table = 'cities';
    	return $this->db->select ( 'id,city_name as name' )->from ( $this->_table )->where ( 'id', $id )->get ()->row ();
    }
    public function getCountybyId($id) {
    	$this->_table = 'county';
    	return $this->db->select ( 'id, county_name as name' )->from ( $this->_table )->where ( 'id', $id )->get ()->row ();
    }
    
    public function getDistrictbyId($id) {
    	$this->_table = 'district_master';
    	return $this->db->select ( 'id, district_name as name' )->from ( $this->_table )->where ( 'id', $id )->get ()->row ();
    }
    
    
}
?>