<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EducationMaster extends MY_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        
        // Controller intializations
        $this->validate_token();
        $this->lang->load('dashboard');
        $this->load->model('SC_educationMaster', 'eduMaster');
        $this->load->model('SC_Grading', 'grading');
    }
//--------------------School---------------------------------------------------------
    
    public function addSchool_Post() 
    {
    	$postData = $this->post();
    	$this->form_validation->set_data($postData);
    	if($this->form_validation->run('schoolform'))
    	{
    	$school = $this->eduMaster->addSchool($postData);
    	
    	if( is_numeric($school)) {
    		$school1 = $this->eduMaster->getaddedSchool($school);
   			$countryid = $this->grading->getCountrybyId($school1->country_id);
   			$school1->country= $countryid;
    		$state = $this->grading->getStatebyId($school1->state_id);
    		$school1->state= $state;
    		$city = $this->grading->getCitybyId($school1->city_id);
    		$school1->city= $city;
    		$county = $this->grading->getCountybyId($school1->county_id);
   			$school1->county= $county;
   			$district = $this->grading->getDistrictbyId($school1->district_id);
   			$school1->district= $district;
    		
    		
    		$response ['status'] = "success";
    		$response ['message'] = 'School  added successfully.';
    		$response ['newSchool'] = $school1;
    		$this->set_response($response, REST_Controller::HTTP_OK);
    	}
    	else
    	{
    		$response ['status'] = "error";
    		$response ['message'] = $school;
    		$this->set_response($response, REST_Controller::HTTP_OK);
    	}
    	}
    	else
    	{
    		$this->set_response(getErrorMessages(validation_errors()), REST_Controller::HTTP_EXPECTATION_FAILED);
    	}
   	}
   	
    public function updateSchool_post() 
    {
    	$postData = $this->post();
    	$this->form_validation->set_data($postData);
    	if($this->form_validation->run('schoolupdateform'))
    	{
    		$school = $this->eduMaster->updateSchool($postData);
    	   //print_r($category); return ;

    		if($school != False && $school != "OK")
    		{
    			$school1 = $this->eduMaster->getaddedSchool($school);
    			$countryid = $this->grading->getCountrybyId($school1->country_id);
    			$school1->country= $countryid;
    			$state = $this->grading->getStatebyId($school1->state_id);
    			$school1->state= $state;
    			$city = $this->grading->getCitybyId($school1->city_id);
    			$school1->city= $city;
    			$county = $this->grading->getCountybyId($school1->county_id);
    			$school1->county= $county;
    			$district = $this->grading->getDistrictbyId($school1->district_id);
    			$school1->district= $district;
    			 
    		$response ['status'] = "success";
    		$response ['message'] = $this->lang->line('Schoolinfo_success');
    		$response['country'] = $school;
    		$this->set_response($response, REST_Controller::HTTP_OK);
    		
    		}
    		else if($school == "OK")
    		{
    			$response ['status'] = "error";
    			$response ['message'] = 'School Already Exist';
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
    public function getSchool_get()
    {
    	$country = $this->grading->getCountryList();
    	for ($i=0; $i< count($country); $i++)
    	{
    		$countryRow = $country[$i];
    		$statesInfo = $this->grading->getStatesList($countryRow->id);
    		for($j=0; $j< count($statesInfo); $j++)
    		{
    			$stateRow = $statesInfo[$j];
    			$districtInfo = $this->grading->getDistrictList($stateRow->id);
    			$cityInfo = $this->grading->getCityList($stateRow->id);
    			$countyInfo = $this->grading->getCountyList($stateRow->id);
    			 
    			$stateRow->district = $districtInfo;
    			$stateRow->city = $cityInfo;
    			$stateRow->county = $countyInfo;
    		}
    		$countryRow->states= $statesInfo;
    	}
    	$school = $this->eduMaster->getSchool();
    	for ($i=0; $i< count($school); $i++)
    	{
    		$schoolRow = $school[$i];
    		$countryid = $this->grading->getCountrybyId($schoolRow->country_id);
    		$schoolRow->country= $countryid;
    		$state = $this->grading->getStatebyId($schoolRow->state_id);
    		$schoolRow->state= $state;
    		$city = $this->grading->getCitybyId($schoolRow->city_id);
    		$schoolRow->city= $city;
    		$county = $this->grading->getCountybyId($schoolRow->county_id);
    		$schoolRow->county= $county;
    		$district = $this->grading->getDistrictbyId($schoolRow->district_id);
    		$schoolRow->district= $district;
    	}
    	$response = array(
    			"Country"=>$country,
    			"school" => $school
    	);
    	$this->set_response($response, REST_Controller::HTTP_OK);
    
    }
    
    
    //------------------------------------------City-------------------------------------------------
    
    public function getCityCountyDistrict_post()
    {
    	$state_id = $this->post("state_id");
    	
    	$districtInfo = $this->grading->getDistrictList($state_id);
    	$cityInfo = $this->grading->getCityList($state_id);
    	$countyInfo = $this->grading->getCountyList($state_id);
    	 
    	
    	$response = array(
    			"district" => $districtInfo,
    			"city" => $cityInfo,
    			"county" => $countyInfo
    	);
    	$this->set_response($response, REST_Controller::HTTP_OK);
    }
     
   
    
}
?>