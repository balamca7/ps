<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class SC_Dashboard extends MY_Model {
	public function __construct() {
		parent::__construct ();
		
		// Model intilizations
		//$this->_table = 'postquestion';
		// $this->validate = $this->config->item('sdf');
		$this->load->library ( 'subquery' );
	}
	
	
	public function gettotalusercount() {
		$this->_table = "employee_master";
		return $this->db->select ( 'count(*) as count' )
		                ->from ( $this->_table ) 
		                ->get ()->row ();
	}
	public function getquestioncount() {
		$this->_table = "postquestion";
		return $this->db->select ( 'count(*) as count' )
		->from ( $this->_table )
		->get ()->row ();
	}
	public function getchartusercount() {
		$this->_table = "user_master";
		$result = $this->db->query('select company_id, (SELECT name from company where id = company_id) AS label ,COUNT(ID) as value, (CASE WHEN company_id = "1" THEN "red" WHEN company_id = 2 THEN "green" END) as color FROM employee_master GROUP By company_id')->result ();
		return $result;
	}

	public function addcompany($userData) {
		
		$this->_table = 'company';

		$user = array (
				'name' => $userData ['name'],
				'imagepath' => $userData ['imagepath']
		);
		
		$insert = $this->db->insert($this->_table, $user);
		$msg = "success";
		return $msg;
	}
	
	public function saveEmployee($userData) {
		$insert_val = 0;
		$this->_table = "employee_master";
		$result = $this->db->select ( 'email' )
		        ->from ( $this->_table )
		        ->where ( 'email="' . $userData ['email'] . '"' )
		        ->get ()
		        ->row ();
				
				if (count ( $result ) > 0) {
					return "user already exist";
				}else{
						if(!isset($userData['mname']))
						{
							$userData['mname'] = NULL;
						}
						if(!isset($userData['dob']))
						{
							$userData['dob'] = NULL;
						}

					   $user = array(
							'fname' => $userData['fname'],
							'mname' => $userData['mname'],
							'lname' => $userData['lname'],
							'pre_address' => $userData['pre_address'],
							'per_address' => $userData['per_address'],
							'dob' => $userData['dob'],
							'pan_no' => $userData['pan_no'],
							'email' => $userData['email'],
							'mobile' => $userData['mobile'],
							// 'auth_string'=>  'Welcome@123',
							'auth_string' => $this->_generatePassword('Welcome@123'),
							'imagepath'=>  'uploadImage/default.png',
							'company_id'=> $userData['company_id'],
							'doj' => $userData['doj'],
							//'department' => $userData ['department'],
							'department_id' => $userData ['department_id'],
							'designation_id' => $userData ['designation_id'],
							'bank_acc_no' => $userData ['bank_acc_no'],
							'bank_name' => $userData ['bank_name'],
							'annual_ctc' => $userData ['annual_ctc'],
							'monthly_ctc' => $userData ['monthly_ctc']
						);
					$insert = $this->db->insert($this->_table, $user);
					$insert_val = $this->db->insert_id();
					//$msg = "success";
					//return $msg;
				}
				
				$this->_table_salary = "salary_master";
				
				$basic = (($userData['annual_ctc'])*(35/100));
				$hra = ($basic/2);
				$conveyance_allowance = (1600*12);
				$medical_allowance = (1250*12);
				$special_allowance = ((($userData['annual_ctc']))-$basic-$hra-$medical_allowance);
				
				$rentention_bonus = 0;
				$variable_incentive = 0;
				$notice_buyout = 0;
				$retirals = 0;
				$pf = 0;
				$gratuity = 0;
				$medical_insurance_pre = 0;
				$house_allowance = 0;
				$year_end_bonus = 0;
				$gross_ctc = 0;
				
				
				$salary = array(
							'ctc' => $userData['annual_ctc'],
							'basic' => $basic,
							'hra' => $hra,
							'conveyance' => $conveyance_allowance,
							'medical_allowance' => $medical_allowance,
							'retention_bonus' => $rentention_bonus,
							'variable_incentive' => $variable_incentive,
							'notice_buyout' => $notice_buyout,
							'pf' => $pf,
							'gratuity'=> $gratuity,
							'medical_insurance' => $medical_insurance_pre,
							'special_allowance' => $special_allowance,
							'house_allowance' => $house_allowance,
							'year_end_bonus' => $year_end_bonus,
							'total_cross_ctc' => $gross_ctc,
							'emp_id' => $insert_val
				
				);
				
				$insert_sal_details = $this->db->insert($this->_table_salary, $salary);
				$msgg = "success";
				return $msgg;
    }
	
	public function updateEmployee($userData) {
	$this->_table = "employee_master";
	
	$result = $this->db->select ( 'email' )
		        ->from ( $this->_table )
		        ->where ( 'id', $userData ['id'] )
		        ->get ()
		        ->row ();
				
				if (count ( $result ) == 0) {
					return "Employee data not found!";
				}else{
					   $user = array(
							'fname' => $userData['fname'],
							'mname' => $userData['mname'],
							'lname' => $userData['lname'],
							'pre_address' => $userData['pre_address'],
							'per_address' => $userData['per_address'],
							'dob' => $userData['dob'],
							'pan_no' => $userData['pan_no'],
							'email' => $userData['email'],
							'mobile' => $userData['mobile'],
							'company_id'=> $userData['company_id'],
							'doj' => $userData['doj'],
							'department_id' => $userData ['department_id'],
							'designation_id' => $userData ['designation_id'],
							'bank_acc_no' => $userData ['bank_acc_no'],
							'bank_name' => $userData ['bank_name'],
							'annual_ctc' => $userData ['annual_ctc'],
							'monthly_ctc' => $userData ['monthly_ctc']
						);
					//$insert = $this->db->update($this->_table, $user);
					$insert = $this->update($userData['id'], $user);
					$msg = "success";
					return $msg;
				}
    }
	
	public function getempdetails() {
		$this->_table = "employee_master";
		
		return $this->db->select ( '*,(select name from company where id = employee_master.company_id) as company_name, (select name from department where id = employee_master.department_id) as department, (select name from designation where id = employee_master.designation_id) as designation' )
		->from ( $this->_table )
		->get ()->result ();
		}
		
	public function getempdetail($id) {
		$this->_table = "employee_master";
		
		return $this->db->select ( '*, (select name from company where id = employee_master.company_id) as company_name, (select name from department where id = employee_master.department_id) as department, (select name from designation where id = employee_master.designation_id) as designation' )
		->from ( $this->_table )
		->where ( 'id="' . $id . '"' )
		->get ()
		 ->row ();
		}
		
	public function generatepayslip($userData) {
		//print_r($userData);
		$this->_table_emp = "employee_master";
		$this->_table_salary = "salary_month";
		
		$getmonth = $userData ['month'];
		$month = explode("-",$getmonth);
		$cur_month = $month[1]*1;
		$cur_year = $month[0]*1;
		
		/*$this->db->select('employee_master.*,(select name from company where id = employee_master.company_id) as company_name,(select imagepath from company where id = employee_master.company_id) as company_logo , (select name from department where id = employee_master.department_id) as department, (select name from designation where id = employee_master.designation_id) as designation,salary_month.*');
		$this->db->from('employee_master,salary_month');
		$this->db->where('employee_master.id = salary_month.emp_id AND salary_month.month="' .$cur_month. '"');
		$this->db->where('salary_month.emp_id', $userData['id']);
		$data=$this->db->get()->row();
		*/
		       $subject =  $_SERVER['SCRIPT_NAME'];
$subArr = explode("/", $subject);
//array_pop($subArr);
$subArr = array_slice($subArr, 0, -3);
  $path = implode("/",$subArr);
       //   $path = "http://".$_SERVER['SERVER_ADDR'].$path."/dist/img/";
     $path = "../dist/img/";
        
    /*    $this->db->select('employee_master.*,(select name from company where id = employee_master.company_id) as company_name,(select CONCAT("'.$path.'", imagepath) as imagepath from company where id = employee_master.company_id) as company_logo , (select name from department where id = employee_master.department_id) as department, (select name from designation where id = employee_master.designation_id) as designation,salary_month.*, Date_FORMAT(CONCAT(salary_month.Year, "-", salary_month.month, "-", 1), "%M , %Y") as monthName');
        $this->db->from('employee_master,salary_month');
        $this->db->where('employee_master.id = salary_month.emp_id AND salary_month.month="' .$cur_month. '"');
        $this->db->where('salary_month.emp_id', $userData['id']);
        $data=$this->db->get()->row();*/


        $this->db->select('A.*,  (select name from department where id = A.department_id) as department, (select name from designation where id = A.designation_id) as designation, B.*, Date_FORMAT(CONCAT(B.Year, "-", B.month, "-", 1), "%M %Y") as monthName, C.name as company_name, CONCAT("../dist/img/", C.imagepath) as company_logo, C.address, C.city, C.zip_code, C.phone');
         $this->db->from('employee_master AS A,salary_month AS B, company AS C');
         $this->db->where('A.id = B.emp_id');
         $this->db->where('A.company_id=C.id');
          $this->db->where('B.emp_id', $userData['id']);
           $this->db->where('B.month', $cur_month);
          $data=$this->db->get()->row();
       // print_r($this->db->last_query());
        //$data= $query->row_array();


		return $data;
		
		}
		
	/*public function getempdetailforsalary($id) {
		$this->_table = "employee_master";
		
		$result = $this->db->select ( 'monthly_ctc' )
		->from ( $this->_table )
		->where ( 'id="' . $id . '"' )
		->get ()
		->row ();
		
		$tot_days = 30;
		
		$monthly_ctc = $result->monthly_ctc;
		$one_day_salary = $monthly_ctc/tot_days;
		return $result;
		}*/
		
		public function getempdetailforsalary($userData) {
		$this->_table = "employee_master";
		
		$result = $this->db->select ( 'monthly_ctc' )
		->from ( $this->_table )
		->where ( 'id="' . $userData ['id'] . '"' )
		->get ()
		->row ();		
		
		$getmonth = $userData ['month'];
		$month = explode("-",$getmonth);
		$cur_month = $month[1]*1;
		$cur_year = $month[0]*1;
		$tot_days = $userData ['tot_days'];
		$lop = $userData ['lop'];
		$tot_working_days = $tot_days - $lop;
		$monthly_ctc = $result->monthly_ctc;
		$one_day_salary = $monthly_ctc/$tot_days;
		$con_salary = $tot_working_days * $one_day_salary;
		
		$basic = (($con_salary)*(35/100));
		$hra = ($basic/2);
		$conveyance_allowance = (1600);
		$medical_allowance = (1250);
		$special_allowance = (($con_salary)-$basic-$hra-$medical_allowance);
		
		$rentention_bonus = 0;
		$variable_incentive = 0;
		$notice_buyout = 0;
		$pf = (($con_salary)*(0/100));
		$gratuity = 0;
		$medical_insurance_pre = 0;
		$house_allowance = 0;
		$year_end_bonus = 0;
		$gross_ctc = 0;
		
		$this->_tablee = "salary_month";
		
		$result = $this->db->select ( 'month' )
		        ->from ( $this->_tablee )
		        ->where ( 'emp_id="' . $userData ['id']. '"' )
				->where ( 'month="' . $cur_month. '"' )
				->where ( 'year="' . $cur_year. '"' )
		        ->get ()
		        ->result ();
				//$query = $this->db->last_query();
				//print_r( $query );return;
				$mon_salary = array(
							'ctc' => $con_salary,
							'total_working_days' => $tot_working_days,
							'lop' => $lop,
							'basic' => $basic,
							'hra' => $hra,
							'conveyance' => $conveyance_allowance,
							'medical_allowance' => $medical_allowance,
							'retention_bonus' => $rentention_bonus,
							'variable_incentive' => $variable_incentive,
							'notice_buyout' => $notice_buyout,
							'pf' => $pf,
							'gratuity'=> $gratuity,
							'medical_insurance' => $medical_insurance_pre,
							'special_allowance' => $special_allowance,
							'house_allowance' => $house_allowance,
							'year_end_bonus' => $year_end_bonus,
							'total_cross_ctc' => $gross_ctc,
							'emp_id' => $userData ['id'],
							'month' => $cur_month,
							'year' => $cur_year
							);
				
				if (count ( $result ) > 0) {
					$this->_tablee = "salary_month";
					//print_r($mon_salary);return;
					 $this->db->where('emp_id', $userData['id']);
					$this->db->where ( 'month', $cur_month);
					$this->db->where ( 'year', $cur_year);
					$insert = $this->db->update($this->_tablee, $mon_salary);
					$msgg = "success";
				}else{
					$insert_sal_details = $this->db->insert($this->_tablee, $mon_salary);
					$msgg = "success";
				}
				
				if($msgg == "success"){				
				$this->_table_month_salary = "salary_month";	
				$result = $this->db->select ( '*' )
				->from ( $this->_table_month_salary )
				->where ( 'emp_id', $userData ['id'])
				->where ( 'month', $cur_month )
				->where ( 'year', $cur_year)
				->get ()
				->row ();
				return $result;
			}else{
				return('Failed');
			}				
		}

	private function _generatePassword($password) {
        //return md5($password . base64_decode($this->config->item('password_hash')));
    	return md5($password);
    	}
	
	public function getbarchartcount($category_id) {
		$this->_table = "user_master";
		if($category_id == 0)
		{
			$result = $this->db->query('Select a.name as label, ifnull( b.cnt,0) as value  from category as a Left join (SELECT count(post_Id) as cnt,subject_id FROM `postquestion` group by subject_id) as b on  b.subject_id = a.id order by a.id')->result ();
			return $result;
		}
		else if($category_id != 0) 
		{
			$result = $this->db->query('Select a.name as label, ifnull( b.cnt,0) as value  from subcategory as a Left join (SELECT count(post_Id) as cnt, sub_subject_id FROM `postquestion` group by sub_subject_id) as b on  b.sub_subject_id = a.id  where a.category_id = '.$category_id.' order by a.id')->result ();
			return $result;
		}
	}
}
?>