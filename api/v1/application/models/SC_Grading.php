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
    
   //---------------------------Tutor type --------------------------

    public function getTutortype() {
    	$this->_table = 'tutor_master';
    	return $this->db->select('id,tutorType as  name')
    	->from($this->_table)
    	->where('isActive', 1)
    	->get()
    	->result();
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
    	return $this->db->select('id, district_name AS name')
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
    	return $this->db->select(' id, school_name AS name')
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
    	->where('school_id=', $school_id)
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
        return $this->db->select('id, grade AS name')
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
    
    public function getSubCategory($categoryId) {
    	$this->_table = 'subcategory';
    	return $this->db->select('id, name')
    	->from($this->_table)
    	->where(array('isActive' => 1, 'category_id' => $categoryId))
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
    
    public function getUserGrades($userId, $subjectId) {
        $this->_table = 'class';
        return $this->db->select('a.id, a.name, b.gradeId')
                        ->from($this->_table. ' AS a')
                        ->join('user_grade AS b', 'a.id = b.classId AND b.userId = '. $userId .' AND b.subjectId = '. $subjectId, 'LEFT')
                        ->get()
                        ->result();
    }

    public function saveUserGrades($userId, $subjectDetails) {
        $this->_table = 'user_grade';
        
        // loop through Grades of each Class and check if we need to "UPDATE" or "INSERT" row
        foreach ($subjectDetails['userGrades'] as $class) {
            // check if gradeId is not null
            if(!is_null($class['gradeId']) && is_numeric($class['gradeId'])) {
                // check if records already exist, then update record, else insert
                $this->_saveGrade($userId, $class, $subjectDetails['subjectId']);
            }
        }
        
        return TRUE;
    }
    
    private function _saveGrade($userId, $class, $subjectId) {
        $this->_table = 'user_grade';
        
        // Check if the User Grade combination is already added for CLASS
        $result = $this->db->select('id')
                    ->from($this->_table)
                    ->where(array('userId' => $userId, 'classId' => $class['id'], 'subjectId' => $subjectId))
                    ->get()
                    ->row();
        
        if(empty($result)) {
            return $this->insert(array(
                'userId' => $userId,
                'classId' => $class['id'],
                'gradeId' => $class['gradeId'],
                'subjectId' => $subjectId
            ));
        } else {
            return $this->update($result->id, array(
                'gradeId' => $class['gradeId']
            ));
        }
    }
    
    public function manage_usergrades($data) {
        $this->_table = 'user_grade';
        $user_id = $data['user_id'];
        $subject_id = $data['subject_id'];

        // loop through Grades of each Class and check if we need to "UPDATE" or "INSERT" row
        foreach ($data['grades'] as $class => $grade) {

            // Check if the User Grade combination is already added for CLASS
            $result = $this->db->select('user_grade_id')
                        ->from($this->_table)
                        ->where('(user_id="' . $user_id . '")')
                        ->where('(subjects_id="' . $subject_id . '")')
                        ->where('(class_id="' . $class . '")')
                        ->get()
                        ->result();

            // Update GRADES as combination is already added in database
            if (count($result)) {
                $update = $this->db->set('grade_id', $grade)
                        ->where('(user_grade_id="' . $result[0]->user_grade_id . '")')
                        ->update($this->_table);
            }

            // INSERT new record in database with data
            else {
                $data = array(
                        'user_id' => $user_id,
                        'subjects_id' => $subject_id,
                        'grade_id' => $grade,
                        'class_id' => $class
                );
                $insert = $this->db->insert($this->_table, $data);
            }
        }
    }

}