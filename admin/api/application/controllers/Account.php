<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends MY_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        
        // Controller intializations
        $this->lang->load('account');
        $this->load->library('email');
        $this->load->model('SC_User', 'user');
        $this->load->model('SC_Grading', 'grading');
    }
    
    public function login_post() {
        // To authenticate user and return JWT token
        $postData = $this->post();
        //print_r($postData);return;
        $this->form_validation->set_data($postData);
        if ($this->form_validation->run('loginForm')) {
            $userData = $this->user->authorize($postData);
            //print_r($userData->image);return;
            if($userData && is_numeric($userData->id)) {
            	$response ['status'] = "success";
            	$response ['message'] = 'Logged in successfully.';
            	$response ['token'] = $this->generate_token($userData);
            	
            	
            	$response ['name'] = $userData->name;
            	$response ['uid'] = $userData->user_id;
            	$response ['email'] = $userData->email;
            	$response ['image'] = $userData->image;
            	session_start();
            	$_SESSION["user_id"] = $userData->id;
            		
                $this->set_response($response, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
            } else {
                // Wrong username/password
            	$response ['status'] = "error";
            	$response ['message'] = $this->lang->line('invalid_credentials');
            	
                $this->set_response($response, REST_Controller::HTTP_OK);
            }
        } else {
            // form validation errors
            $this->set_response(getErrorMessages(validation_errors()), REST_Controller::HTTP_EXPECTATION_FAILED);
        }
    }
    
    public function register_put() {
    	// To register new user
    	$postData = $this->put();
    	//print_r($postData);return ;
    	$this->form_validation->set_data($postData);
    	//print_r($postData);return;
    	if ($this->form_validation->run('registerForm')) {
    		$insertId = $this->user->register($postData);
    		if($insertId) {
    			
    			 $this->email->from('no-reply@studycollab.com', 'Studycollb');
    			 //  $this->email->reply_to('you@example.com', 'Your Name');
    			 $this->email->to($postData->emailAddress);
    			
    			 $this->email->subject('Study Collab Account Activation');
    			
    			 $this->email->message("Dear ".$postData->username.",\nPlease click on below URL active your account for Study Collab \n\n http://http://www.studycollab.com/#!/UserActivation/".$postData->username."\n"."\n\nThanks\nAdmin Team");
    			
    			 if($this->email->send()){
    			 $this->set_response("User data registered successfully!. Please check your email to Activation link!.", REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
    			 } else {
    			 $this->set_response("Email sending failed...", REST_Controller::HTTP_BAD_REQUEST);
    			 }	
    			
    		}   else {
    			$response ['status'] = "error";
    			$response ['message'] = $this->lang->line('register_error');
    			$this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
    		}
    	} else {
    		// form validation errors
    		$response ['status'] = "error";
    		$response ['message'] = implode(", ", getErrorMessages(validation_errors()));
    		
    		$this->set_response($response, REST_Controller::HTTP_EXPECTATION_FAILED);
    	}
    
    }
    
    public function UserActivation_post()
    {
    	$postData = $this->post();
    	
    	$userData = $this->user->UserActivation($postData);
    
    	if($userData == "status updated" )
    	{
    		$response ["status"] = "success";
    		$response ["message"] = "Your account activated sucessfully.";
    		$response ['userID']  = $postData ['userID'] ;
    	}
    	else if($userData == "status not updated")
    	{
    		$response ["status"] = "error";
    		$response ["message"] = "Your account already activated.";
    		$response ['userID']  = $postData ['userID'] ;
    	}
    	else if($userData == "user not found")
    	{
    		$response ["status"] = "error";
    		$response ["message"] = "User not available in our database.";
    		$response ['userID']  = $postData ['userID'] ;
    	}
    	$this->set_response($response, REST_Controller::HTTP_OK);
    }
    
    
    public function forgotpasswordlinkcheck_post()
    {
    	$postData = $this->post();
    	$userData = $this->user->forgotpasswordlinkcheck($postData);
    	 
    	if($userData == "Not Expried")
    	{
    		$response ["status"] = "Not Expried";
    		//$response ["message"] = "Your account activated sucessfully.";
    	}
    	else if ($userData == "Expried")
    	{
    		$response ["status"] = "error";
    		$response ["message"] = "Your link Expried.";
    
    	}
    	$this->set_response($response, REST_Controller::HTTP_OK);
    }
    
    
    public function isEmailUnique_put() {
        // To check if user with the same email already exists
        $postData = $this->put();
        $this->form_validation->set_data($postData);
        if ($this->form_validation->run('emailUnique')) {
            $this->set_response(TRUE, REST_Controller::HTTP_OK);
        } else {
            $this->set_response(FALSE, REST_Controller::HTTP_OK);
        }
    }
    
    public function isUsernameUnique_put() {
        // To check if user with the same username already exists
        $postData = $this->put();
        $this->form_validation->set_data($postData);
        if ($this->form_validation->run('usernameUnique')) {
            $this->set_response(TRUE, REST_Controller::HTTP_OK);
        } else {
            $this->set_response(FALSE, REST_Controller::HTTP_OK);
        }
    }
    
    public function forgotPassword_post() {
    	// To check if user with the same username already exists
    	$postData = $this->post();
    	//print_r($postData);return ;
    	$this->form_validation->set_data($postData);
    	if ($this->form_validation->run('passwordForm')) {
    		$userData = $this->user->doesUserExist($postData);
    		if($userData && is_numeric($userData->id)) {
    			$password = $this->user->updatePassword($userData);
    			$this->set_response("Password mailed successfully.", REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
    	/*		if($password) {
    				$this->email->from('no-reply@studycollab.com', 'Studycollb');
    				//  $this->email->reply_to('you@example.com', 'Your Name');
    				$this->email->to($userData->emailAddress);
    
    				$this->email->subject('Password Reset');
    
    				$this->email->message("Dear User,\nPlease click on below URL or paste into your browser to  Recovery Your password\n\n http://www.studycollab.com/#!/resetpassword/".$userData->username."\n"."\n\nThanks\nAdmin Team");
    
    				if($this->email->send()){
    					$response ["status"] = "success";
    					$response ["message"] = "Password mailed successfully.";
    					$this->set_response($response, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
    				} else {
    					$response ["status"] = "error";
    					$response ["message"] = "Email sending failed...";
    					
    					$this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
    				}
    			} else {
    					$response ["status"] = "error";
    					$response ["message"] = "Update failed...";

    				$this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
    			} */
    		} else {
    			// Wrong username, no user exist with the entered username
    			$this->set_response($this->lang->line('invalid_credentials'), REST_Controller::HTTP_BAD_REQUEST);
    		}
    	} else {
    		$this->set_response(getErrorMessages(validation_errors()), REST_Controller::HTTP_EXPECTATION_FAILED);
    	}
    }
    
    public function resetPassword_post() 
    {
    	$postData = $this->post();
    //	print_r($postData); return ;
    	$this->form_validation->set_data($postData);
    	if ($this->form_validation->run('resetpassword')) 
    	{
    		if($postData["newpassword"] == $postData["confirmpassword"])
    		{
    		$password = $this->user->resetPassword($postData);
    		$response ["status"] = "success";
    		$response ["message"] = "Password reset successfully";
    		$this->set_response($response, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
    	    }
    	    else {
    	    	$response ["status"] = "error";
    	    	$response ["message"] = $this->lang->line('Worngcredentials');
    	    	$this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
    	    }
    	}
    	    else 
    	    {
    	    	$response ["status"] = "error";
    	    	$response ["message"] = $this->lang->line('invalid_credentials');
    	    	$this->set_response($response, REST_Controller::HTTP_BAD_REQUEST);
    	}
    	
    	
    }
    
    
    
}
