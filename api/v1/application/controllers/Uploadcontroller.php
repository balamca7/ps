<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Uploadcontroller extends MY_Controller

{

	function __construct()

	{

		parent::__construct();
		$this->validate_token();
		$this->load->helper('form');
		$this->lang->load('profile');
		$this->load->helper('url');
		$this->load->model('SC_imageUpdate', 'imageUpdate');
	}


	//Upload Image function

	function uploadImage_post()
	{
		$postData = $this->post();
		$this->form_validation->set_data($postData);
		// if ($this->form_validation->run('updateUserImage')) 
		// {
			if(!empty($_FILES))
			{
					$user_id =  $this->user->id;
					$user_name =  $this->user->id;

					$today = date("Y_m_d_H_i_s");
				
					$imagename =  $user_name.$today.'.jpg';
				
					$_FILES['imagePath']['name'] = $imagename;
					$path = '../../uploadImage/' . $_FILES['imagePath']['name'];
					if(move_uploaded_file($_FILES['imagePath']['tmp_name'], $path))
					{
						$profile = $this->imageUpdate->profileImage($imagename,$user_id);
						$response ['status'] = "success";
						$response ['message'] = $this->lang->line('uploadImage_success');
						$response["image"] = $profile;
						$this->set_response($response, REST_Controller::HTTP_OK);
					}
					else {
						$response ['status'] = "error";
						$response ['message'] = $this->lang->line('uploadImage_success');
						
						$this->set_response($response, REST_Controller::HTTP_OK);
					}
			}
			else
			{
				$response ['status'] = "error";
				$response ['message'] = $this->lang->line('uploadImageselect_error');
				
				$this->set_response($response, REST_Controller::HTTP_EXPECTATION_FAILED);
			}
		
	}



}

?>