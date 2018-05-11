<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends MY_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        
        // Controller intializations
        $this->validate_token();
        $this->lang->load('dashboard');
        $this->load->model('SC_Master', 'master');
        $this->load->model('SC_Grading', 'grading');
    }
//-------------------Country-----------------------------------
    public function getCountry_get() {
    
    	$Country = $this->master->getCountry();
    	//$subcategoryDetails = $this->grading->getSubCategory($categoryId);
    	$this->set_response($Country, REST_Controller::HTTP_OK);
    }
    public function addCountry_Post() {
    	$postData = $this->post();
    	$this->form_validation->set_data($postData);
    	if($this->form_validation->run('countryform'))
    	{
    	$country = $this->master->addCountry($postData);
    	
    	if( is_numeric($country)) {
    		$country1 = $this->master->getaddedCountry($country);
    		$response ['status'] = "success";
    		$response ['message'] = 'Category name added successfully.';
    		$response ['newCountry'] = $country1;
    		$this->set_response($response, REST_Controller::HTTP_OK);
    	}
    	else
    	{
    		$response ['status'] = "error";
    		$response ['message'] = $country;
    		$this->set_response($response, REST_Controller::HTTP_OK);
    	}
    	}
    	else
    	{
    		$this->set_response(getErrorMessages(validation_errors()), REST_Controller::HTTP_EXPECTATION_FAILED);
    	}
   	}
   	
    public function updateCountry_post() 
    {
    	$postData = $this->post();
    	$this->form_validation->set_data($postData);
    	if($this->form_validation->run('countryupdateform'))
    	{
    		$country = $this->master->updateCountry($postData);
    	   //print_r($category); return ;

    		if($country != False && $country != "OK")
    		{
    		$response ['status'] = "success";
    		$response ['message'] = $this->lang->line('Countryinfo_success');
    		$response['country'] = $country;
    		$this->set_response($response, REST_Controller::HTTP_OK);
    		
    		}
    		else if($country == "OK")
    		{
    			$response ['status'] = "error";
    			$response ['message'] = 'Country Already Exist';
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
    
//-------------------State-----------------------------------
    
    public function addState_Post() {
    	$postData = $this->post();
    	$this->form_validation->set_data($postData);
    	if($this->form_validation->run('stateform'))
    	{
    		$state = $this->master->addstate($postData);
    		 
    		if( is_numeric($state)) {
    			$state1 = $this->master->getaddstate($state);
    			$response ['status'] = "success";
    			$response ['message'] = 'State added successfully.';
    			$response ['newState'] = $state1;
    			$this->set_response($response, REST_Controller::HTTP_OK);
    		}
    		else
    		{
    			$response ['status'] = "error";
    			$response ['message'] = $state;
    			$this->set_response($response, REST_Controller::HTTP_OK);
    		}
    		
    	}
    	else
    	{
    		$this->set_response(getErrorMessages(validation_errors()), REST_Controller::HTTP_EXPECTATION_FAILED);
    	}
    	 
    	 
    }
  
    public function getState_get() 
    {
    	$Country = $this->master->getallCountry();
    	$state = $this->master->getstate();
    	$response = array(
    	
    			"Country"=> $Country,
    			"states"=>$state
    	
    	);
    	$this->set_response($response, REST_Controller::HTTP_OK);
    }
    
    public function updateState_post() {
    	$postData = $this->post();
    	$this->form_validation->set_data($postData);
    	if($this->form_validation->run('stateupdateform'))
    	{
    		$state = $this->master->updateState($postData);
    		//print_r($category); return ;
    
    		if($state != False && $state != "OK")
    		{
    			$response ['status'] = "success";
    			$response ['message'] = $this->lang->line('stateinfo_success');
    			$response['state'] = $state;
    			$this->set_response($response, REST_Controller::HTTP_OK);
    
    		}
    		else if($state == "OK")
    		{
    			$response ['status'] = "error";
    			$response ['message'] = 'State Already Exist';
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
    

//-------------------City-----------------------------------

  public function getCity_get()
    {
    	$country = $this->grading->getCountryList();
    	for ($i=0; $i< count($country); $i++)
    	{
    		$countryRow = $country[$i];
    		$statesInfo = $this->grading->getStatesList($countryRow->id);
    		$countryRow->states= $statesInfo;
    	}
    	 
    	//$state = $this->master->getallState();
    	$city = $this->master->getcity();
    	for ($i=0; $i< count($city); $i++)
    	{
    		$cityRow = $city[$i];
    		$countryid = $this->grading->getCountrybyId($cityRow->country_id);
    		$cityRow->country= $countryid;
    		$state = $this->grading->getStatebyId($cityRow->state_id);
    		$cityRow->state= $state;
    	}
    	$response = array(
    			"Country"=>$country,
    			//"state" => $state,
    			"city"=> $city
    	);
    	$this->set_response($response, REST_Controller::HTTP_OK);
    
    }
    
    public function addCity_Post() {
    	$postData = $this->post();
    	$this->form_validation->set_data($postData);
    	if($this->form_validation->run('cityform'))
    	{
    		$city = $this->master->addcity($postData);
    		 
    		if( is_numeric($city)) {
    			$city1 = $this->master->getaddedcity($city);
    			$countryid = $this->grading->getCountrybyId($city1->country_id);
    			$city1->country= $countryid;
    			$state = $this->grading->getStatebyId($city1->state_id);
    			$city1->state= $state;
    			
    			$response ['status'] = "success";
    			$response ['message'] = 'City added successfully.';
    			$response ['newCity'] = $city1;
    			$this->set_response($response, REST_Controller::HTTP_OK);
    		}
    		else
    		{
    			$response ['status'] = "error";
    			$response ['message'] = $city;
    			$this->set_response($response, REST_Controller::HTTP_OK);
    		}
    	}
    	else
    	{
    		$this->set_response(getErrorMessages(validation_errors()), REST_Controller::HTTP_EXPECTATION_FAILED);
    	}
    }
    
    public function updateCity_post() {
    	$postData = $this->post();
    	//print_r($postData); return ;
    	$this->form_validation->set_data($postData);
    	if($this->form_validation->run('cityupdateform'))
    	{
    		$city = $this->master->updatecity($postData);
    		if($city != False && $city != "OK")
    		{
    			$city1 = $this->master->getaddedcity($city);
    			$countryid = $this->grading->getCountrybyId($city1->country_id);
    			$city1->country= $countryid;
    			$state = $this->grading->getStatebyId($city1->state_id);
    			$city1->state= $state;
    			 
    			
    			$response ['status'] = "success";
    			$response ['message'] = $this->lang->line('cityinfo_success');
    			$response['city'] = $city1;
    			$this->set_response($response, REST_Controller::HTTP_OK);
    		}
    		else if($city == "OK")
    		{
    			$response ['status'] = "error";
    			$response ['message'] = 'City Already Exist';
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

//-------------------County-----------------------------------
    
    public function getCounty_get()
    {
    	$country = $this->grading->getCountryList();
    	for ($i=0; $i< count($country); $i++)
    	{
    		$countryRow = $country[$i];
    		$statesInfo = $this->grading->getStatesList($countryRow->id);
    		$countryRow->states= $statesInfo;
    	}
    
    	//$state = $this->master->getallState();
    	$county = $this->master->getcounty();
    	for ($i=0; $i< count($county); $i++)
    	{
    		$countyRow = $county[$i];
    		$countryid = $this->grading->getCountrybyId($countyRow->country_id);
    		$countyRow->country= $countryid;
    		$state = $this->grading->getStatebyId($countyRow->state_id);
    		$countyRow->state= $state;
    	}
    	$response = array(
    			"Country"=>$country,
    			"county"=> $county
    	);
    	$this->set_response($response, REST_Controller::HTTP_OK);
    
    }
    
    public function addCounty_Post() {
    	$postData = $this->post();
    	$this->form_validation->set_data($postData);
    	if($this->form_validation->run('countyform'))
    	{
    		$County = $this->master->addCounty($postData);
    		if( is_numeric($County)) {
    			$County1 = $this->master->getaddedcounty($County);
    			$countryid = $this->grading->getCountrybyId($County1->country_id);
    			$County1->country= $countryid;
    			$state = $this->grading->getStatebyId($County1->state_id);
    			$County1->state= $state;
    			$response ['status'] = "success";
    			$response ['message'] = 'County added successfully.';
    			$response ['newCounty'] = $County1;
    			$this->set_response($response, REST_Controller::HTTP_OK);
    		}
    		else
    		{
    			$response ['status'] = "error";
    			$response ['message'] = $County;
    			$this->set_response($response, REST_Controller::HTTP_OK);
    		}
    	}
    	else
    	{
    		$this->set_response(getErrorMessages(validation_errors()), REST_Controller::HTTP_EXPECTATION_FAILED);
    	}
    }
    
    public function updateCounty_post() {
    	$postData = $this->post();
    	$this->form_validation->set_data($postData);
    	if($this->form_validation->run('countyupdateform'))
    	{
    		$County = $this->master->updateCounty($postData);
    		//print_r($category); return ;
    
    		if($County != False && $County != "OK")
    		{
    			$County1 = $this->master->getaddedcounty($County);
    			$countryid = $this->grading->getCountrybyId($County1->country_id);
    			$County1->country= $countryid;
    			$state = $this->grading->getStatebyId($County1->state_id);
    			$County1->state= $state;
    			
    			$response ['status'] = "success";
    			$response ['message'] = $this->lang->line('countyinfo_success');
    			$response['county'] = $County1;
    			$this->set_response($response, REST_Controller::HTTP_OK);
    		}
    		else if($County == "OK")
    		{
    			$response ['status'] = "error";
    			$response ['message'] = 'County Already Exist';
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

//-------------------District-----------------------------------

    public function getdistrict_get()
    {
    	$country = $this->grading->getCountryList();
    	for ($i=0; $i< count($country); $i++)
    	{
    		$countryRow = $country[$i];
    		$statesInfo = $this->grading->getStatesList($countryRow->id);
    		$countryRow->states= $statesInfo;
    	}
    	 
    	//$state = $this->master->getallState();
    	$district = $this->master->getdistrict();
    	 
    	for ($i=0; $i< count($district); $i++)
    	{
    		$districtRow = $district[$i];
    		$countryid = $this->grading->getCountrybyId($districtRow->country_id);
    		$districtRow->country= $countryid;
    		$state = $this->grading->getStatebyId($districtRow->state_id);
    		$districtRow->state= $state;
    	}
    	 
    	$response = array(
    			"Country"=>$country,
    			"district"=> $district
    
    	);
    	$this->set_response($response, REST_Controller::HTTP_OK);
    
    }
    
    public function addDistrict_Post() {
    	$postData = $this->post();
    	$this->form_validation->set_data($postData);
    	if($this->form_validation->run('districtform'))
    	{
    		$district = $this->master->adddistrict($postData);
    		 
    		if( is_numeric($district)) {
    			$district1 = $this->master->getadddistrict($district);
    			$countryid = $this->grading->getCountrybyId($district1->country_id);
    			$district1->country= $countryid;
    			$state = $this->grading->getStatebyId($district1->state_id);
    			$district1->state= $state;
    			$response ['status'] = "success";
    			$response ['message'] = 'District added successfully.';
    			$response ['newDistrict'] = $district1;
    			$this->set_response($response, REST_Controller::HTTP_OK);
    		}
    		else
    		{
    			$response ['status'] = "error";
    			$response ['message'] = $district;
    			$this->set_response($response, REST_Controller::HTTP_OK);
    		}
    	}
    	else
    	{
    		$this->set_response(getErrorMessages(validation_errors()), REST_Controller::HTTP_EXPECTATION_FAILED);
    	}
    }
    
    public function updateDistrict_post() {
    	$postData = $this->post();
    	$this->form_validation->set_data($postData);
    	if($this->form_validation->run('districtupdateform'))
    	{
    		$district = $this->master->updateDistrict($postData);
    		//print_r($category); return ;
    
    		if($district != False && $district != "OK")
    		{
    			$district1 = $this->master->getadddistrict($district);
    			$countryid = $this->grading->getCountrybyId($district1->country_id);
    			$district1->country= $countryid;
    			$state = $this->grading->getStatebyId($district1->state_id);
    			$district1->state= $state;
    			 
    			$response ['status'] = "success";
    			$response ['message'] = $this->lang->line('districtinfo_success');
    			$response['district'] = $district1;
    			$this->set_response($response, REST_Controller::HTTP_OK);
    		}
    		else if($district == "OK")
    		{
    			$response ['status'] = "error";
    			$response ['message'] = 'District Already Exist';
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
    
    //-------------------------//Tutor------------------------------------------------------------
    public function getTutor_get() {
    
    	$Tutor = $this->master->getTutortype();
    	//$subcategoryDetails = $this->grading->getSubCategory($categoryId);
    	$this->set_response($Tutor, REST_Controller::HTTP_OK);
    }
    public function addTutor_Post() {
    	$postData = $this->post();
    	$this->form_validation->set_data($postData);
    	if($this->form_validation->run('tutorform'))
    	{
    		$Tutor = $this->master->addTutortype($postData);
    		 
    		if( is_numeric($Tutor)) {
    			$Tutor1 = $this->master->getaddedTutortype($Tutor);
    			$response ['status'] = "success";
    			$response ['message'] = 'Tutor added successfully.';
    			$response ['newTutor'] = $Tutor1;
    			$this->set_response($response, REST_Controller::HTTP_OK);
    		}
    		else
    		{
    			$response ['status'] = "error";
    			$response ['message'] = $Tutor;
    			$this->set_response($response, REST_Controller::HTTP_OK);
    		}
    	}
    	else
    	{
    		$this->set_response(getErrorMessages(validation_errors()), REST_Controller::HTTP_EXPECTATION_FAILED);
    	}
    }
    
    public function updateTutor_post()
    {
    	$postData = $this->post();
    	$this->form_validation->set_data($postData);
    	if($this->form_validation->run('tutorupdateform'))
    	{
    		$Tutor = $this->master->updateTutortype($postData);
    		//print_r($category); return ;
    
    		if($Tutor != False && $Tutor != "OK")
    		{
    			$response ['status'] = "success";
    			$response ['message'] = $this->lang->line('tutorinfo_success');
    			$response['tutor'] = $Tutor;
    			$this->set_response($response, REST_Controller::HTTP_OK);
    
    		}
    		else if($country == "OK")
    		{
    			$response ['status'] = "error";
    			$response ['message'] = 'Tutor Already Exist';
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