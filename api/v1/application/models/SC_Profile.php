<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SC_Profile extends MY_Model {
    
    public function __construct() {
        parent::__construct();
        
        // Model intilizations
        $this->_table = 'user_master';
        //$this->validate = $this->config->item('sdf');
        $this->load->library('subquery');
    }

    public function getUserSalaryMonth($emp_id)
    {
       $this->_table = "salary_month";
        $result = $this->db->select("Date_FORMAT(CONCAT(Year, '-', month, '-', 1), '%b - %Y') as name, CONCAT(Year, '-', month) as id")
        ->from($this->_table) 
        ->where('emp_id', $emp_id)
        ->order_by('Year desc, month desc')
        ->get()
        ->result();
        return $result;
    }
    
    public function getUserDetails($userID)
    {
    	$this->_table = "employee_master";
    	$result = $this->db->select('*')
    	->from($this->_table) 
    	->where('id', $userID)
    	->get()
    	->row();
    	return $result;
    }

    public function generatepayslip($userData) {
        //print_r($userData);
        $this->_table_emp = "employee_master";
        $this->_table_salary = "salary_month";
        
        $getmonth = $userData ['month'];
        $month = explode("-",$getmonth);
        $cur_month = $month[1]*1;
        $cur_year = $month[0]*1;

        $subject =  $_SERVER['SCRIPT_NAME'];
$subArr = explode("/", $subject);
//array_pop($subArr);
$subArr = array_slice($subArr, 0, -3);
  $path = implode("/",$subArr);
          //$path = "http://".$_SERVER['SERVER_ADDR'].$path."/dist/img/";

   $path = "dist/img/";
        
        $this->db->select('employee_master.*,(select name from company where id = employee_master.company_id) as company_name,(select address from company where id = employee_master.company_id) as address,(select city from company where id = employee_master.company_id) as city,(select zip_code from company where id = employee_master.company_id) as zip_code,(select phone from company where id = employee_master.company_id) as phone,(select CONCAT("'.$path.'", imagepath) as imagepath from company where id = employee_master.company_id) as company_logo , (select name from department where id = employee_master.department_id) as department, (select name from designation where id = employee_master.designation_id) as designation,salary_month.*, Date_FORMAT(CONCAT(salary_month.Year, "-", salary_month.month, "-", 1), "%M %Y") as monthName');
        $this->db->from('employee_master,salary_month');
        $this->db->where('employee_master.id = salary_month.emp_id AND salary_month.month="' .$cur_month. '"');
        $this->db->where('salary_month.emp_id', $userData['user_id']);
        $data=$this->db->get()->row();
        //print_r($this->db->last_query());
        //$data= $query->row_array();
        
        return $data;
        
        }


    public function getProfile($userID) {
    	$this->_table = "user_master";
//    	$result = $this->db->select('id, user_id, CONCAT(f_name, " " ,l_name) AS name, f_name, m_name, l_name, email_1 AS email, email_2 as altEmail, mobile_num AS mobile, telephone,  screen_name, school_id,tutor_type')
//    	->from($this->_table)
//    	->where('user_id', $userID)
//    	->get()
//    	->row();

    		$this->db->select ( 'id, user_id, CONCAT(f_name, " " ,l_name) AS name, f_name, m_name, l_name, email_1 AS email, email_2 as altEmail, mobile_num AS mobile, telephone,  screen_name, school_id,tutor_type, tutor_id');
		$sub = $this->subquery->start_subquery ( 'select' );
		$sub->select ( 'count(group_id) ' )->from ( 'group_member' );
		$sub->where ( $this->_table . '.user_id = group_member.user_id' );
		$this->subquery->end_subquery ( 'groupCount' );
		$this->db->from ( $this->_table );
		$this->db->where ( $this->_table . '.user_id', $userID );
		$result = $this->db->get ()->row ();
		return $result;

    	//$result->image = "data:image/jpeg;base64," . base64_encode ( $result->image );

    	return $result;

    }
    
    public function getSchoolDetails($school_id)
    {
    	//$query1 = "SELECT *,(select City_name FROM cities where id=city_id) As city, (select county_name FROM county where id=county_id) As county FROM school1 WHERE school_id='$school_id'";
    	$this->_table = "school";
    	$result = $this->db->select('country_id, state_id, district_id, id as school_id, city_id, county_id')
    	->from($this->_table)
    	->where('id', $school_id)
    	->get()
    	->row();
    	 
    	return $result;
    }
    
    public function getEducationDetails($user_id)
    {
    	$this->_table = "user_subjects";
    	$result = $this->db->select('subject_id, grade_id')
    	->from($this->_table)
    	->where('user_id', $user_id)
    	->get()
    	->result();
    	
    	$total_len = count($result);
    	if($total_len<5)
    	{
	    	for($i=$total_len;$i<5;$i++)
	    	{
	    		$result[$i] = array('subject_id'=>null, 'grade_id'=>null);
	    	}
    	}
    	
    	return $result;
    }
    
    public function updateUserInfo($userdata)
    {
    	$this->_table = 'user_master';
    	$result = $this->db->select ( 'tutorType as name' )->from ('tutor_master' )->where ( 'id', $userdata ['tutor_id'] )->get ()->row ();
    	$userdata['tutor_type'] = $result->name;
   
    	$user = array(
    
    			'f_name' => $userdata['f_name'],
    			'm_name' => $userdata['m_name'],
    			'l_name' => $userdata['l_name'],
    			'telephone' => $userdata['telephone'],
    			'mobile_num' => $userdata['mobile'],
    			'screen_name' => $userdata['screen_name'],
    		    'tutor_type' => $userdata['tutor_type'],
    			'tutor_id' => $userdata['tutor_id']
    
    	);
//return  $userdata;
    	if($this->update($userdata["id"], $user)) {
    		return $userdata;
    	} else {
    		return FALSE;
    	}
    
    }
    
    public function updateSchoolInfo($userdata)
    {
    	$this->_table = 'user_master';
    
    	$user = array(
    			'school_id' => $userdata['school_id'],
    	);
    	//return  $userdata;
    	if($this->update($userdata["id"], $user)) {
			return $user;
    	} else {
    		return FALSE;
    	}
    
    }
    
    
    public function saveEduInfo($user_id,$data)
    {
    	
    	//print_r($data);return;
    	$this->_table = 'user_subjects';
    
    	//$subject_id = $data;
    	foreach ($data as $key => $value) {
    			
    		$subject_id = $value["id"];
    		$grade_id= $value["selectedGrade"];
    		$result = $this->db->select('grade_id')
    		->from($this->_table)
    		->where('(user_id="' . $user_id . '")')
    		->where('(subject_id="' . $subject_id . '")')
    		//->where('(grade_id="' . $grade_id . '")')
    		->get()
    		->row();
    		//$query = $this->db->last_query();
    		//echo ($query);

    		if (count($result)) {
    			$update = $this->db->set('grade_id', $grade_id)
    			->where('(user_id="' . $user_id . '")')
    			->where('(subject_id="' . $subject_id . '")')
    			->update($this->_table);
    		}
    		// INSERT new record in database with data
    		else {
    			if($grade_id != "" || $grade_id != null)
    			{
    				$data = array(
    						'user_id' => $user_id,
    						'subject_id' => $subject_id,
    						'grade_id' => $grade_id
    				
    				);
    				$insert = $this->db->insert($this->_table, $data);
    			}
    		}
    	}
    }
    
    public function getcategory() {
    	$this->_table = 'category';
    	return $this->db->select('id, name')
    	->from($this->_table)
    	->where('isActive', 1)
    	->get()
    	->result();
    }
    
    public function getgradeById($subject_Id,$userId) {
    	$this->_table = 'subcategory';
    	return $this->db->select('id, name, (Select grade_id from user_subjects where subject_id = subcategory.id and user_id="'.$userId.'") as selectedGrade')
    	->from($this->_table)
    	->where('category_id', $subject_Id)
    	->get()
    	->result();
    }
    
    public function getGrades() {
    	$this->_table = 'grades';
    	return $this->db->select('id, grade as name')
    	->from($this->_table)
    	->where('isActive', 1)
    	->get()
    	->result();
    }
    
    public function saveGrades($user_id,$data)
    {
    	$this->_table = 'user_subjects';
    
    	$subject_id = $data;
    	foreach ($data as $key => $value) {
    			
    		$subject_id = $value["id"];
    		$grade_id= $value["selectedGrade"];
    		$result = $this->db->select('grade_id')
    		->from($this->_table)
    		->where('(user_id="' . $user_id . '")')
    		->where('(subject_id="' . $subject_id . '")')
    		//->where('(grade_id="' . $grade_id . '")')
    		->get()
    		->row();
    
    		if (count($result)) {
    			$update = $this->db->set('grade_id', $grade_id)
    			->where('(user_id="' . $user_id . '")')
    			->where('(subject_id="' . $subject_id . '")')
    			->update($this->_table);
    		}
    
    		// INSERT new record in database with data
    		else {
    			$data = array(
    					'user_id' => $user_id,
    					'subject_id' => $subject_id,
    					'grade_id' => $grade_id
    						
    			);
    			$insert = $this->db->insert($this->_table, $data);
    		}
    	}
    }
    
    
    
}