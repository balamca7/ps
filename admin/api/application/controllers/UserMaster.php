<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class UserMaster extends MY_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        
        // Controller intializations
        $this->validate_token();
        $this->lang->load('dashboard');
        $this->load->model('SC_userMaster', 'usermaster');
        $this->load->model('SC_Grading', 'grading');
    }
//-------------------User Details-----------------------------------
    public function getUserdetails_get() {
    
    	$Country = $this->usermaster->getUserdetails();
    	//$subcategoryDetails = $this->grading->getSubCategory($categoryId);
    	$this->set_response($Country, REST_Controller::HTTP_OK);
    }
   
   	
    public function updateUserdetails_post() 
    {
    	$postData = $this->post();
    	$this->form_validation->set_data($postData);
    	if($this->form_validation->run('userdetailsupdateform'))
    	{
    		$Userdetails = $this->usermaster->updateUserdetails($postData);
    	   //print_r($category); return ;

    		if($Userdetails != False )
    		{
    			$Userdetails1 = $this->usermaster->getaddedDetails($Userdetails);
    		$response ['status'] = "success";
    		$response ['message'] = $this->lang->line('Userdetailsinfo_success');
    		$response['Userdetails'] = $Userdetails1;
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