<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class SC_imageUpdate extends MY_Model {
	public function __construct() {
		parent::__construct ();
		
		// Model intilizations
		$this->_table = 'employee_master';
		// $this->validate = $this->config->item('sdf');
		$this->load->library ( 'subquery' );
	}
	public function profileImage($userdata, $id) {
		$filepath = "uploadImage/" . $userdata;
		
		$this->_table = "employee_master";
		/*if ($userGroup == "user") {
			$this->_table = "user_master";
		} else if ($userGroup == "group") {
			$this->_table = "group_master";
		}*/
		
		//select imagepath from table where id= id
		
		$prevImagepath = $this->db->select('imagepath')
								->from($this->_table)
							->where('id', $id)
							->get()
							->row();
		
		//print_r($prevImagepath);
							
		//echo $_SERVER['DOCUMENT_ROOT'].'/'.$prevImagepath->imagepath;
		if($prevImagepath->imagepath != "uploadImage/default.png")					
		{
			unlink('../../'.$prevImagepath->imagepath);
		}
		
		
		$user = array (
				'imagepath' => $filepath 
		);
		if ($this->update ( $id, $user )) {
			//$result = $this->db->last_query ();
			//return $result;
			 return $filepath;
		} else {
			return FALSE;
		}
	}
}

?>