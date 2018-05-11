<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        
        // Controller intializations
        $this->validate_token();
        $this->lang->load('dashboard');
        $this->load->model('SC_Dashboard', 'scdashboard');
        $this->load->model('SC_Grading', 'grading');
       
    }
//-------------------Count-----------------------------------

    public function getDepartment_get() {
    	$category = $this->grading->getDepartment();
    	//array_unshift($category, array("id"=>0,"name"=>"All"));
    	
    	$response ['Department'] = $category;
    	$this->set_response($response, REST_Controller::HTTP_OK);
    }
	
	public function getcomp_get() {
    	$company = $this->grading->getcomp();
    	$response ['company'] = $company;
    	$this->set_response($response, REST_Controller::HTTP_OK);
    }
	
	
	public function getDesignation_post() {
		$postData = $this->post();

    	$subcategory = $this->grading->getDesignation($postData['department_id']);
		//$subcategory = $this->grading->getSubCategory($postData);
    //	array_unshift($category, array("id"=>0,"name"=>"All"));
    	
    	$response ['Designation'] = $subcategory;
    	$this->set_response($response, REST_Controller::HTTP_OK);
    }
	
	public function getAllDesignation_get() {
		
    	$subcategory = $this->grading->getAllDesignation();
    	$response ['Designation'] = $subcategory;
    	$this->set_response($response, REST_Controller::HTTP_OK);
    }
	
	
	/////////////////////////////////////////////////////////////////////
	
	public function saveEmployee_post(){
    	$postData = $this->post();
		$userData = $this->scdashboard->saveEmployee($postData);
		
		  	if($userData == "success")
				{
					$response ['status'] = "success";
					$response ['message'] = "Employee added successfully";
				}else{
					$response ['status'] = "error";
					$response ['message'] = $userData;
				}
				$this->set_response($response, REST_Controller::HTTP_OK);
    }

    public function addcompany_post(){
    	$postData = $this->post();
		$userData = $this->scdashboard->addcompany($postData);
		
		  	if($userData == "success")
				{
					$response ['status'] = "success";
					$response ['message'] = "company added successfully";
				}else{
					$response ['status'] = "error";
					$response ['message'] = $userData;
				}
				$this->set_response($response, REST_Controller::HTTP_OK);
    }
	
	public function updateEmployee_post(){
    	$postData = $this->post();
		$userData = $this->scdashboard->updateEmployee($postData);
		
		  	if($userData == "success")
				{
					$response ['status'] = "success";
					$response ['message'] = "Employee details updated successfully.";
				}else{
					$response ['status'] = "error";
					$response ['message'] = $userData;
				}
				$this->set_response($response, REST_Controller::HTTP_OK);
    }
	
	public function getempdetails_get(){
		$EmpDetails = $this->scdashboard->getempdetails();  

		if($EmpDetails){
					$response ['EmpDetails'] = $EmpDetails;
					$response ['status'] = "success";
					$response ['message'] = "Employee fetch successfully";
		}else{
					$response ['status'] = "error";
					$response ['message'] = "failed to fetch";
				}
				$this->set_response($response, REST_Controller::HTTP_OK);
	}
	
	public function getempdetail_post(){
		$postData = $this->post();
		$EmpDetail = $this->scdashboard->getempdetail($postData['id']);  

		if($EmpDetail){
					$response ['EmpDetails'] = $EmpDetail;
					$response ['status'] = "success";
					$response ['message'] = "Employee fetch successfully";
		}else{
					$response ['status'] = "error";
					$response ['message'] = "failed to fetch";
		}
				$this->set_response($response, REST_Controller::HTTP_OK);
	}
	
	
	public function generatepayslip_post(){
		$postData = $this->post();
		$PayslipDetail = $this->scdashboard->generatepayslip($postData);  

		if($PayslipDetail){
					$response ['PayslipDetails'] = $PayslipDetail;
					$response ['status'] = "success";
					$response ['message'] = "Payslip details fetched successfully";
		}else{
					$response ['status'] = "error";
					$response ['message'] = "Please generate Pay using Salary Calculator and come back.";
		}
					$this->set_response($response, REST_Controller::HTTP_OK);
	}
	
	
	/*public function getempdetailforsalary_post(){
		$postData = $this->post();
		$EmpDetail = $this->scdashboard->getempdetailforsalary($postData['id']);  

		if($EmpDetail){
					$response ['EmpDetails'] = $EmpDetail;
					$response ['status'] = "success";
					$response ['message'] = "Salary calculated successfully";
		}else{
					$response ['status'] = "error";
					$response ['message'] = "failed to Calculate";
		}
				$this->set_response($response, REST_Controller::HTTP_OK);
	}*/
	
	public function getempdetailforsalary_post(){
		$postData = $this->post();
		$EmpDetail = $this->scdashboard->getempdetailforsalary($postData);  

		if($EmpDetail){
					$response ['EmpDetails'] = $EmpDetail;
					$response ['status'] = "success";
					$response ['message'] = "Salary calculated successfully";
		}else{
					$response ['status'] = "error";
					$response ['message'] = "failed to Calculate";
		}
				$this->set_response($response, REST_Controller::HTTP_OK);
	}
	
	/////////////////////////////////////////////////////////////////////
    
    public function getDashboard_get() {    
    	$Totaluser = $this->scdashboard->gettotalusercount();
    	//$Totalquestion = $this->scdashboard->getquestioncount();
    	$response ['totalUser'] = $Totaluser ->count;
    	$response ['totalQuestion'] = 0;
		$EmpDetails = $this->scdashboard->getempdetails();  
		//print_r($EmpDetails[0]);
		$listCompany = array();
		for($i=0;$i<count($EmpDetails); $i++)
		{
			$emp = $EmpDetails[$i];
			$listCompany[$emp->company_name][] = $emp;
		}

    	$response ['EmployeeList'] = $listCompany;
    	//$subcategoryDetails = $this->grading->getSubCategory($categoryId);
    	$this->set_response($response, REST_Controller::HTTP_OK);
    }
    public function getUserpiechart_get() {   	
    	$Totalchartuser = $this->scdashboard->getchartusercount();
    	$response ['userChart'] = $Totalchartuser;
    	//$subcategoryDetails = $this->grading->getSubCategory($categoryId);
    	$this->set_response($response, REST_Controller::HTTP_OK);
    }
	
	/*public function getdepartment_get() {   	
    	$Totalchartuser = $this->scdashboard->getchartusercount();
    	$response ['userChart'] = $Totalchartuser;
    	//$subcategoryDetails = $this->grading->getSubCategory($categoryId);
    	$this->set_response($response, REST_Controller::HTTP_OK);
    }*/
	
    public function getQuestionbarchart_post() {
    	$category_id = $this->post("category");
    	
    	$Totalchartuser = $this->scdashboard->getbarchartcount($category_id);
        $label = array();
        $value = array();
    	for($i=0;$i<count($Totalchartuser);$i++)
    	{
    		$label[$i] = $Totalchartuser[$i]->label;
    		$value[$i] = $Totalchartuser[$i]->value;
    	}
    	$data = array(
    			'label' => $label,
    			'value' => $value
    	);
    	 $response ['questionChart'] = $data;
    	//$subcategoryDetails = $this->grading->getSubCategory($categoryId);
    	$this->set_response($response, REST_Controller::HTTP_OK); 
    }
    
           
}
?>