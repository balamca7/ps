<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class SubjectMaster extends MY_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        
        // Controller intializations
        $this->validate_token();
        $this->lang->load('dashboard');
        $this->load->model('SC_subjectMaster', 'subjectmaster');
    }
//-----------------------------------Category------------------------------------
    public function getCategory_get() {
    
    	$category = $this->subjectmaster->getCategory();
    	//$subcategoryDetails = $this->grading->getSubCategory($categoryId);
    	$this->set_response($category, REST_Controller::HTTP_OK);
    }
    public function addCategory_Post() {
    	$postData = $this->post();
    	$this->form_validation->set_data($postData);
    	if($this->form_validation->run('categoryform'))
    	{
    	$category = $this->subjectmaster->addCategory($postData);
    	
    	if( is_numeric($category)) {
    		$category1 = $this->subjectmaster->getaddedCategory($category);
    		$response ['status'] = "success";
    		$response ['message'] = 'Department added successfully.';
    		$response ['newCategory'] = $category1;
    		$this->set_response($response, REST_Controller::HTTP_OK);
    	}
    	else
    	{
    		$response ['status'] = "error";
    		$response ['message'] = $category;
    		$this->set_response($response, REST_Controller::HTTP_OK);
    		
    	}
    	
    	}
    	else
    	{
    		$this->set_response(getErrorMessages(validation_errors()), REST_Controller::HTTP_EXPECTATION_FAILED);
    	}
    	
    	
   	}
    
    
    
    public function updateCategory_post() {
    	$postData = $this->post();
    	$this->form_validation->set_data($postData);
    	if($this->form_validation->run('categoryupdateform'))
    	{
    		$category = $this->subjectmaster->updateCategory($postData);
    	   //print_r($category); return ;

    		if($category != False && $category != "OK")
    		{
    		$response ['status'] = "success";
    		$response ['message'] = "Department updated successfully.";
    		$response['category'] = $category;
    		$this->set_response($response, REST_Controller::HTTP_OK);
    		
    		}
    		else if($category == "OK")
    		{
    			$response ['status'] = "error";
    			$response ['message'] = 'Department Already Exist';
    			$this->set_response($response, REST_Controller::HTTP_OK);
    		}
    		else
    		{
    			$response ['status'] = "error";
    			$response ['message'] = 'Data not found.';
    			$this->set_response($response, REST_Controller::HTTP_OK);
    		}
    		
    	}
    	else {
     
    		$this->set_response(getErrorMessages(validation_errors()), REST_Controller::HTTP_EXPECTATION_FAILED);
    	}
    }
    
//-------------------------------SubCategory-------------------------------------   
    
    public function addSubCategory_Post() {
    	$postData = $this->post();
    	$this->form_validation->set_data($postData);
    	if($this->form_validation->run('subcategoryform'))
    	{
    		$subcategory = $this->subjectmaster->addsubCategory($postData);
    		 
    		if( is_numeric($subcategory)) {
    			$subcategory1 = $this->subjectmaster->getaddsubCategory($subcategory);
    			$response ['status'] = "success";
    			$response ['message'] = 'Designation added successfully.';
    			$response ['newSubCategory'] = $subcategory1;
    			$this->set_response($response, REST_Controller::HTTP_OK);
    		}
    		else
    		{
    			$response ['status'] = "error";
    			$response ['message'] = $subcategory;
    			$this->set_response($response, REST_Controller::HTTP_OK);
    
    		}
    		
    	}
    	else
    	{
    		$this->set_response(getErrorMessages(validation_errors()), REST_Controller::HTTP_EXPECTATION_FAILED);
    	}
    	 
    	 
    }
  
    public function getSubCategory_get() {
    
    	
    	$Category = $this->subjectmaster->getallCategory();
    	$subCategory = $this->subjectmaster->getsubcategory();
    	
    	
    /* 	for ($i=0; $i< count($subCategory); $i++)
    	{
    		$subcategory1 = $subCategory[$i];
    		$category = $this->subjectmaster->getcategoryById($subcategory1->category_id);
    		
    		$subcategory1->Category= $category;
    	} */
    	$response = array(
    	
    			"Category"=> $Category,
    			"subCategories"=>$subCategory
    	
    	);
    	$this->set_response($response, REST_Controller::HTTP_OK);
    	
    }
    
    public function updateSubCategory_post() {
    	$postData = $this->post();
    	$this->form_validation->set_data($postData);
    	if($this->form_validation->run('subcategoryupdateform'))
    	{
    		$subcategory = $this->subjectmaster->updatesubCategory($postData);
    		//print_r($category); return ;
    
    		if($subcategory != False && $subcategory != "OK")
    		{
    			$response ['status'] = "success";
    			$response ['message'] = 'Designation updated successfully.';
    			$response['subcategory'] = $subcategory;
    			$this->set_response($response, REST_Controller::HTTP_OK);
    
    		}
    		else if($subcategory == "OK")
    		{
    			$response ['status'] = "error";
    			$response ['message'] = 'Designation Already Exist';
    			$this->set_response($response, REST_Controller::HTTP_OK);
    		}
    		else
    		{
    			$response ['status'] = "error";
    			$response ['message'] = 'Data not found.';
    			$this->set_response($response, REST_Controller::HTTP_OK);
    		}
    
    	}
    	else {
    		 
    		$this->set_response(getErrorMessages(validation_errors()), REST_Controller::HTTP_EXPECTATION_FAILED);
    	}
    }
  //------------------------------------grades----------------------------------------------
  
    public function getGrades_get() {
    
    	$grades = $this->subjectmaster->getGrades();
    	//$subcategoryDetails = $this->grading->getSubCategory($categoryId);
    	$this->set_response($grades, REST_Controller::HTTP_OK);
    }
    
    public function addGrade_Post() {
    	$postData = $this->post();
    	$this->form_validation->set_data($postData);
    	if($this->form_validation->run('gradeform'))
    	{
    		$Grade = $this->subjectmaster->addGrade($postData);
    		 
    		if( is_numeric($Grade)) {
    			$grade1 = $this->subjectmaster->getaddedGrade($Grade);
    			$response ['status'] = "success";
    			$response ['message'] = 'Sub category added successfully.';
    			$response ['newGrade'] = $grade1;
    			$this->set_response($response, REST_Controller::HTTP_OK);
    		}
    		else
    		{
    			$response ['status'] = "error";
    			$response ['message'] = $Grade;
    			$this->set_response($response, REST_Controller::HTTP_OK);
    
    		}
    
    	}
    	else
    	{
    		$this->set_response(getErrorMessages(validation_errors()), REST_Controller::HTTP_EXPECTATION_FAILED);
    	}
    
    
    }
    public function updateGrade_post() {
    	$postData = $this->post();
    	
    	$this->form_validation->set_data($postData);
    	if($this->form_validation->run('gradeupdateform'))
    	{
    		$Grade = $this->subjectmaster->updateGrade($postData);
    		//print_r($Grade); return ;
    
    		if($Grade != False && $Grade != "OK")
    		{
    			$response ['status'] = "success";
    			$response ['message'] = $this->lang->line('gradeinfo_success');
    			$response['Grade'] = $Grade;
    			$this->set_response($response, REST_Controller::HTTP_OK);
    
    		}
    		else if($Grade == "OK")
    		{
    			$response ['status'] = "error";
    			$response ['message'] = 'Grade Already Exist';
    			$this->set_response($response, REST_Controller::HTTP_OK);
    		}
    		else
    		{
    			$response ['status'] = "error";
    			$response ['message'] = 'Data not found.';
    			$this->set_response($response, REST_Controller::HTTP_OK);
    		}
    
    	}
    	else {
    		 
    		$this->set_response(getErrorMessages(validation_errors()), REST_Controller::HTTP_EXPECTATION_FAILED);
    	}
    }
       
}
?>