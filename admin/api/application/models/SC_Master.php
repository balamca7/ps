<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class SC_Master extends MY_Model {
	public function __construct() {
		parent::__construct ();
	}

	//----------------------------Country---------------------------------------
	public function addCountry($userdata) {
		$this->_table = 'country';
		$result = $this->db->select ( 'id,country_name as name,isActive' )->from ( $this->_table )->where ( 'country_name', $userdata ['name'] )->get ()->row ();
		// print_r($result); return ;
		
		if ($result) {
			return "Country Already Exist";
		} else {
			$user = array (
					'country_name' => $userdata ['name'] 
			)
			;
			
			return $this->insert ( $user );
		}
	}
	public function getaddedCountry($userdata) {
		$this->_table = 'country';
		return $this->db->select ( 'id,country_name as name,isActive' )->from ( $this->_table )->where ( 'id', $userdata )->get ()->row ();
	}
	public function getCountry() {
		$this->_table = 'country';
		return $this->db->select ( 'id,	country_name as name,isActive' )->from ( $this->_table )->get ()->result ();
	}
	public function updateCountry($userdata) {
		$this->_table = 'country';
		$result = $this->db->select ( 'id,country_name as name,isActive' )->from ( $this->_table )->where ( 'id', $userdata ['id'] )->get ()->row ();
		
		
		if ($result) {
			$result2 = $this->db->select ( 'id,country_name as name,isActive' )->from ( $this->_table )->where ( 'country_name ', $userdata ['name'] )->where ( 'id !='. $userdata ['id'] )->get ()->row ();
			//print_r($result2);return ;
			if($result2)
			{
				return "OK";
			}
	    	else
	    	{
					$user = array (
							
							'country_name' => $userdata ['name'],
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
	
	//----------------------------State---------------------------------------
	
	public function addstate($userdata) {
		$this->_table = 'states';
		$result = $this->db->select ( 'id,state,isActive,statecode' )->from ( $this->_table )->where ( 'state', $userdata ['name'] )->where ( 'country_id', $userdata ['country_id'] )->get ()->row ();
		// print_r($result); return ;
		
		if ($result) {
			return "State Already Exist";
		} else {
			$user = array (
					'state' => $userdata ['name'],
					'statecode' => $userdata ['code'],
					'country_id' => $userdata ['country_id'] 
			)
			;
			
			return $this->insert ( $user );
		} 
	}
	
	public function getaddstate($userdata) {
		$this->_table = 'states';
		return $this->db->select ( 'id,state as name,statecode as code,country_id,isActive' )->from ( $this->_table )->where ( 'id', $userdata )->get ()->row ();
	}
	public function getallCountry() {
		$this->_table = 'country';
		return $this->db->select ( 'id,country_name as name,isActive' )->from ( $this->_table )->where ( 'isActive', 1 )->get ()->result ();
	}
	public function getallState() {
		$this->_table = 'states';
		return $this->db->select ( 'id,state as name,statecode as code ,country_id,isActive' )->from ( $this->_table )->where ( 'isActive', 1 )->get ()->result ();
	}
	public function getState() {
		$this->_table = 'states';
		return $this->db->select ( 'id,state as name,statecode as code ,country_id,isActive' )->from ( $this->_table )->get ()->result ();
	}
	
	public function updateState($userdata) {
		$this->_table = 'states';
		$result = $this->db->select ( 'id,state as name,isActive' )->from ( $this->_table )->where ( 'id', $userdata ['id'] )->get ()->row ();
	
	
		if ($result) {
			$result2 = $this->db->select ( 'id,state as name,statecode as code ,country_id,isActive' )->from ( $this->_table )->where ( 'state', $userdata ['name'] )->where ( 'id !='. $userdata ['id'] )->get ()->row ();
			//print_r($result2);return ;
			if($result2)
			{
				return "OK";
			}
			else
			{
				$user = array (
							
						'state' => $userdata ['name'],
						'statecode'=> $userdata ['code'],
						'country_id' => $userdata ['country_id'],
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
	
	
	//----------------------------District---------------------------------------
	public function getdistrict() {
		$this->_table = 'district_master';
		$this->db->select ( 'id,district_name as name,state_id ,isActive' );
		$sub = $this->subquery->start_subquery ( 'select' );
		$sub->select ( 'country_id' )->from ( 'states' );
		$sub->where ( $this->_table . '.state_id = id' );
		$this->subquery->end_subquery ( 'country_id' );
		$this->db->from ( $this->_table );
		return $this->db->get ()->result ();
			}
			
			public function adddistrict($userdata) {
				$this->_table = 'district_master';
				$result = $this->db->select ( 'id,district_name as name,state_id ,isActive' )->from ( $this->_table )->where ( 'district_name', $userdata ['name'] )->where ( 'state_id', $userdata ['state_id'] )->get ()->row ();
				// print_r($result); return ;
			
				if ($result) {
					return "District Already Exist";
				} else {
					$user = array (
							'district_name' => $userdata ['name'],
							'state_id' => $userdata ['state_id']
					)
					;
			
					return $this->insert ( $user );
				}
			}
			
			
			public function getadddistrict($userdata) {
				$this->_table = 'district_master';
				$this->db->select ( 'id,district_name as name,state_id ,isActive' );
				$sub = $this->subquery->start_subquery ( 'select' );
				$sub->select ( 'country_id' )->from ( 'states' );
				$sub->where ( $this->_table . '.state_id = id' );
				$this->subquery->end_subquery ( 'country_id' );
				$this->db->from ( $this->_table );
				$this->db-> where('id',$userdata);
				return $this->db->get ()->row ();
			}
			
			public function updatedistrict($userdata) {
				$this->_table = 'district_master';
				$result = $this->db->select('id,district_name as name,state_id,isActive')->from ( $this->_table )->where ( 'id', $userdata ['id'] )->get ()->row ();
				if ($result)
				{
					$result2 = $this->db->select('id,district_name as name,state_id,isActive' )->from ( $this->_table )->where ( 'district_name', $userdata ['name'] )->where ( 'id !='. $userdata ['id'] )->get ()->row ();
					//print_r($result2);return ;
					if($result2)
					{
						return "OK";
					}
					else
					{
						$user = array (
								'district_name' => $userdata ['name'],
								'state_id'=> $userdata ['state_id'],
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
				
	//----------------------------City---------------------------------------
	public function getcity() {
				$this->_table = 'cities';
				$this->db->select ('id,city_name as name,state_id,isActive');
				$sub = $this->subquery->start_subquery ( 'select' );
				$sub->select ( 'country_id' )->from ( 'states' );
				$sub->where ( $this->_table . '.state_id = id' );
				$this->subquery->end_subquery ( 'country_id' );
				$this->db->from ( $this->_table );
				return $this->db->get ()->result ();
			}
			
	public function addcity($userdata) {
		$this->_table = 'cities';
		$result = $this->db->select ( 'id,city_name as name,state_id,isActive' )->from ( $this->_table )->where ( 'city_name', $userdata ['name'] )->where ( 'state_id', $userdata ['state_id'] )->get ()->row ();
		// print_r($result); return ;
	
		if ($result) {
			return "City Already Exist";
		} else {
			$user = array (
					'city_name' => $userdata ['name'],
					'state_id' => $userdata ['state_id']
			)
			;
	
			return $this->insert ( $user );
		}
	}
	
	public function getaddedcity($userdata) {
		
		$this->_table = 'cities';
		$this->db->select ( 'id,city_name as name,state_id,isActive' );
		$sub = $this->subquery->start_subquery ( 'select' );
		$sub->select ( 'country_id' )->from ( 'states' );
		$sub->where ( $this->_table . '.state_id = id' );
		$this->subquery->end_subquery ( 'country_id' );
		$this->db->from ( $this->_table );
		$this->db-> where('id',$userdata);
		return $this->db->get ()->row ();
		
	}
	
	public function updatecity($userdata) {
		$this->_table = 'cities';
		$result = $this->db->select('id,city_name as name,state_id,isActive')->from ( $this->_table )->where ( 'id', $userdata ['id'] )->get ()->row ();
		if ($result)
		{
			$result2 = $this->db->select('id,city_name as name,state_id,isActive' )->from ( $this->_table )->where ( 'city_name', $userdata ['name'] )->where ( 'id !='. $userdata ['id'] )->get ()->row ();
			//print_r($result2);return ;
			if($result2)
			{
				return "OK";
			}
			else
			{
				$user = array (
						'city_name' => $userdata ['name'],
						'state_id'=> $userdata ['state_id'],
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
	//----------------------------County---------------------------------------
	
	public function getaddedcounty($userdata) {
		$this->_table = 'county';
		$this->db->select ( 'id,county_name as name,state_id ,isActive' );
		$sub = $this->subquery->start_subquery ( 'select' );
		$sub->select ( 'country_id' )->from ( 'states' );
		$sub->where ( $this->_table . '.state_id = id' );
		$this->subquery->end_subquery ( 'country_id' );
		$this->db->from ( $this->_table );
		$this->db-> where('id',$userdata);
		return $this->db->get ()->row ();
	}
	public function getcounty() {
		$this->_table = 'county';
		$this->db->select ('id,county_name as name,state_id,isActive');
		$sub = $this->subquery->start_subquery ( 'select' );
		$sub->select ( 'country_id' )->from ( 'states' );
		$sub->where ( $this->_table . '.state_id = id' );
		$this->subquery->end_subquery ( 'country_id' );
		$this->db->from ( $this->_table );
		return $this->db->get ()->result ();
	}
		
	
	
	public function addCounty($userdata) {
		$this->_table = 'county';
		$result = $this->db->select ( 'id,county_name as name,state_id,isActive' )->from ( $this->_table )->where ( 'county_name', $userdata ['name'] )->where ( 'state_id', $userdata ['state_id'] )->get ()->row ();
		// print_r($result); return ;
	
		if ($result) {
			return "County Already Exist";
		} else {
			$user = array (
					'county_name' => $userdata ['name'],
					'state_id' => $userdata ['state_id']
			)
			;
	
			return $this->insert ( $user );
		}
	}
	
	public function updateCounty($userdata) {
		$this->_table = 'county';
		$result = $this->db->select('id,county_name as name,state_id,isActive')->from ( $this->_table )->where ( 'id', $userdata ['id'] )->get ()->row ();
		if ($result)
		{
			$result2 = $this->db->select('id,county_name as name,state_id,isActive' )->from ( $this->_table )->where ( 'county_name', $userdata ['name'] )->where ( 'id !='. $userdata ['id'] )->get ()->row ();
			//print_r($result2);return ;
			if($result2)
			{
				return "OK";
			}
			else
			{
				$user = array (
						'county_name' => $userdata ['name'],
						'state_id'=> $userdata ['state_id'],
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
	
	//------------------------------------------//Tutor---------------------------------------
	
	public function addTutortype($userdata) {
		$this->_table = 'tutor_master';
		$result = $this->db->select ( 'id,tutorType as name,isActive' )->from ( $this->_table )->where ( 'tutorType', $userdata ['name'] )->get ()->row ();
		// print_r($result); return ;
	
		if ($result) {
			return "Tutor Already Exist";
		} else {
			$user = array (
					'tutorType' => $userdata ['name']
			)
			;
				
			return $this->insert ( $user );
		}
	}
	public function getaddedTutortype($userdata) {
		$this->_table = 'tutor_master';
		return $this->db->select ( 'id,tutorType as name,isActive' )->from ( $this->_table )->where ( 'id', $userdata )->get ()->row ();
	}
	public function getTutortype() {
		$this->_table = 'tutor_master';
		return $this->db->select ( 'id,	tutorType as name,isActive' )->from ( $this->_table )->get ()->result ();
	}
	public function updateTutortype($userdata) {
		$this->_table = 'tutor_master';
		$result = $this->db->select ( 'id,tutorType as name,isActive' )->from ( $this->_table )->where ( 'id', $userdata ['id'] )->get ()->row ();
	
	
		if ($result) {
			$result2 = $this->db->select ( 'id,tutorType as name,isActive' )->from ( $this->_table )->where ( 'tutorType ', $userdata ['name'] )->where ( 'id !='. $userdata ['id'] )->get ()->row ();
			//print_r($result2);return ;
			if($result2)
			{
				return "OK";
			}
			else
			{
				$user = array (
							
						'tutorType' => $userdata ['name'],
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
	
	
	/* 
	public function getCountryList() {
		$this->_table = 'country';
		return $this->db->select ( 'id, country_name AS name' )->from ( $this->_table )->where ( 'isActive', 1 )->get ()->result ();
	}
	public function getCountryName($id) {
		$this->_table = 'country';
		return $this->db->select ( 'id, country_name AS name' )->from ( $this->_table )->where ( 'isActive', 1 )->where ( 'id', $id )->get ()->row ();
	}
	public function getStatesList($country_id) {
		if ($country_id == "All") {
			$where = array (
					'isActive' => 1,
					"country_id IS NOT NULL" 
			);
		} else {
			$where = array (
					'isActive' => 1,
					'country_id' => $country_id 
			);
		}
		
		$this->_table = 'states';
		return $this->db->select ( 'id, state AS name' )->from ( $this->_table )->where ( $where )->get ()->result ();
	}
	public function getStateName($id) {
		$this->_table = 'states';
		return $this->db->select ( 'id, state AS name' )->from ( $this->_table )->where ( 'isActive', 1 )->where ( 'id', $id )->get ()->row ();
	}
	public function getDistrictList($state_id) {
		if ($state_id == "All") {
			$where = array (
					'isActive' => 1,
					"state_id IS NOT NULL" 
			);
		} else {
			$where = array (
					'isActive' => 1,
					'state_id' => $state_id 
			);
		}
		
		$this->_table = 'district_master';
		return $this->db->select ( 'id, district_name AS name' )->from ( $this->_table )->where ( $where )->get ()->result ();
	}
	public function getDistrictName($id) {
		$this->_table = 'district_master';
		return $this->db->select ( 'id, district_name AS name' )->from ( $this->_table )->where ( 'isActive', 1 )->where ( 'id', $id )->get ()->row ();
	}
	public function getSchoolList($district_id) {
		if ($district_id == "All") {
			$where = array (
					'isActive' => 1,
					"district_id IS NOT NULL" 
			);
		} else {
			$where = array (
					'isActive' => 1,
					'district_id' => $district_id 
			);
		}
		
		$this->_table = 'school1';
		return $this->db->select ( 'school_id AS id, school_name AS name' )->from ( $this->_table )->where ( $where )->get ()->result ();
	}
	public function getSchoolName($id) {
		$this->_table = 'school1';
		return $this->db->select ( 'school_id AS id, school_name AS name' )->from ( $this->_table )->where ( 'isActive', 1 )->where ( 'school_id', $id )->get ()->row ();
	}
	public function getCityName($id) {
		$this->_table = 'cities';
		return $this->db->select ( 'id, city_name AS name' )->from ( $this->_table )->
		// ->where('isActive', 1)
		where ( 'id', $id )->get ()->row ();
	}
	public function getCountyName($id) {
		$this->_table = 'county';
		return $this->db->select ( 'id, county_name AS name' )->from ( $this->_table )->where ( 'isActive', 1 )->where ( 'id', $id )->get ()->row ();
	}
	public function getCityCountyName($school_id) {
		$this->_table = 'school1';
		$result = $this->db->select ( '(select City_name FROM cities where id=city_id) As city, (select county_name FROM county where id=county_id) As county' )->from ( $this->_table )->where ( 'school_id=', $school_id )->get ()->row ();
		return $result;
	}
	public function getUserDetails($userID) {
		$this->_table = "user_master";
		$result = $this->db->select ( 'id, user_id, CONCAT(f_name, " " ,l_name) AS name, email_1 AS email, mobile_num AS mobile, telephone as phone, imagepath as image' )->from ( $this->_table )->where ( 'user_id', $userID )->get ()->row ();
		// $result->image = "data:image/jpeg;base64," . base64_encode ( $result->image );
		
		return $result;
	}
	public function getimage($userID) {
		$query2 = $this->db->query ( "SELECT image FROM user_master WHERE user_id = '$userID'" )->row ();
		return "data:image/jpeg;base64," . base64_encode ( $query2->image );
	}
	public function getGrades() {
		$this->_table = 'grades';
		return $this->db->select ( 'grades AS id, grade AS name' )->from ( $this->_table )->where ( 'isActive', 1 )->get ()->result ();
	}
	public function getAllUsersGroups() {
		
		// $result = $this->db->query("(SELECT 'All' AS id, 'All' AS user_id, 'User' ) UNION ALL (SELECT user_id AS id, user_id, 'User' FROM user_master) UNION ALL (SELECT id, group_name AS user_id, 'Group' FROM group_master)")
		$result = $this->db->query ( "(SELECT 'All' AS id, 'All' AS user_id, '' AS image, 'User' ) UNION ALL (SELECT id, user_id, imagepath as image, 'User' FROM user_master)  UNION ALL (SELECT id, group_name AS user_id, imagepath as image, 'Group' FROM group_master)" )->result ();
		
		/*
		 * foreach ($result as $userGroups) {
		 * if($userGroups->image != null && $userGroups->image != "")
		 * {
		 * $userGroups->image = "data:image/jpeg;base64," . base64_encode ( $userGroups->image );
		 * }
		 * else {
		 * if($userGroups->User == "User")
		 * {
		 * $userGroups->image = "dist/img/user.png";
		 * }
		 * else
		 * {
		 * $userGroups->image = "dist/img/user_group.png";
		 * }
		 * }
		 * }
		 
		return $result;
	}
	public function getSubjectById($subjectId) {
		$this->_table = 'category';
		return $this->db->select ( 'id, name' )->from ( $this->_table )->where ( 'id', $subjectId )->get ()->row ();
	}
	public function getSubCategoryById($subjectId) {
		$this->_table = 'subcategory';
		return $this->db->select ( 'id, name' )->from ( $this->_table )->where ( 'id', $subjectId )->get ()->row ();
	}
	public function getUserGrades($userId, $subjectId) {
		$this->_table = 'class';
		return $this->db->select ( 'a.id, a.name, b.gradeId' )->from ( $this->_table . ' AS a' )->join ( 'user_grade AS b', 'a.id = b.classId AND b.userId = ' . $userId . ' AND b.subjectId = ' . $subjectId, 'LEFT' )->get ()->result ();
	}
	public function saveUserGrades($userId, $subjectDetails) {
		$this->_table = 'user_grade';
		
		// loop through Grades of each Class and check if we need to "UPDATE" or "INSERT" row
		foreach ( $subjectDetails ['userGrades'] as $class ) {
			// check if gradeId is not null
			if (! is_null ( $class ['gradeId'] ) && is_numeric ( $class ['gradeId'] )) {
				// check if records already exist, then update record, else insert
				$this->_saveGrade ( $userId, $class, $subjectDetails ['subjectId'] );
			}
		}
		
		return TRUE;
	}
	private function _saveGrade($userId, $class, $subjectId) {
		$this->_table = 'user_grade';
		
		// Check if the User Grade combination is already added for CLASS
		$result = $this->db->select ( 'id' )->from ( $this->_table )->where ( array (
				'userId' => $userId,
				'classId' => $class ['id'],
				'subjectId' => $subjectId 
		) )->get ()->row ();
		
		if (empty ( ( array ) $result )) {
			return $this->insert ( array (
					'userId' => $userId,
					'classId' => $class ['id'],
					'gradeId' => $class ['gradeId'],
					'subjectId' => $subjectId 
			) );
		} else {
			return $this->update ( $result->id, array (
					'gradeId' => $class ['gradeId'] 
			) );
		}
	}
	public function manage_usergrades($data) {
		$this->_table = 'user_grade';
		$user_id = $data ['user_id'];
		$subject_id = $data ['subject_id'];
		
		// loop through Grades of each Class and check if we need to "UPDATE" or "INSERT" row
		foreach ( $data ['grades'] as $class => $grade ) {
			
			// Check if the User Grade combination is already added for CLASS
			$result = $this->db->select ( 'user_grade_id' )->from ( $this->_table )->where ( '(user_id="' . $user_id . '")' )->where ( '(subjects_id="' . $subject_id . '")' )->where ( '(class_id="' . $class . '")' )->get ()->result ();
			
			// Update GRADES as combination is already added in database
			if (count ( $result )) {
				$update = $this->db->set ( 'grade_id', $grade )->where ( '(user_grade_id="' . $result [0]->user_grade_id . '")' )->update ( $this->_table );
			} 			

			// INSERT new record in database with data
			else {
				$data = array (
						'user_id' => $user_id,
						'subjects_id' => $subject_id,
						'grade_id' => $grade,
						'class_id' => $class 
				);
				$insert = $this->db->insert ( $this->_table, $data );
			}
		}
	} */
}
?>