<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends MY_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        
        // Controller intializations
        $this->validate_token();
        $this->lang->load('dashboard');
        $this->load->model('SC_Reports', 'reports');
        $this->load->model('SC_Grading', 'grading');
    }
//--------------------Volunteer Hour Reports---------------------------------------------------------
    
    
    public function getVolunteerhourReports_post()
    {
    	$monthYear = $this->post("monthYear");
    	
    	$reportsInfo = $this->reports->getVolunteerhourReports($monthYear);
    	$this->set_response($reportsInfo, REST_Controller::HTTP_OK);
    }
    
    //--------------------User Post Reports---------------------------------------------------------
     
    public function getUserPostReports_post()
    {
    	$monthYear = $this->post("monthYear");    	 
    	$reportsInfo = $this->reports->getUserPostReports($monthYear);
    	$this->set_response($reportsInfo, REST_Controller::HTTP_OK);
    }
     
    //-------------------------------------Tutor Report -------------------------------
     
    public function getTutorreport_get() {
    	$Tutor = $this->reports->getTutorreport();
    	//$subcategoryDetails = $this->grading->getSubCategory($categoryId);
    	$this->set_response($Tutor, REST_Controller::HTTP_OK);
    }
    //-------------------------------------Tutor Details -------------------------------
     
    public function getTutorreportdetails_post() {
    	$Tutortype = $this->post("Tutortype");
    	 	$Tutordetils = $this->reports->getTutorreportdetails($Tutortype);
    	$this->set_response($Tutordetils, REST_Controller::HTTP_OK);
    }
    //-------------------------------------User Rating --------------------------------
    
    public function getoverallRating_get() {
    
    	$ratingDetails = $this->reports->getoverallRating();
        $this->set_response($ratingDetails, REST_Controller::HTTP_OK);
    }
}
?>