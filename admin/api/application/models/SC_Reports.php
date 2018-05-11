<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class SC_Reports extends MY_Model {
	public function __construct() {
		parent::__construct ();
	}
	
	
	public function getVolunteerhourReports($monthYear) {
		
		$monthYear["From"] = str_replace("/","-",$monthYear["From"]);
		$monthYear["To"] = str_replace("/","-",$monthYear["To"]);
		
		$newfrom = date("Y-m-d", strtotime($monthYear["From"]));
		$newto = date("Y-m-d", strtotime($monthYear["To"]));
		$this->_table = 'user_master';
		
		$this->db->select ( 'id, user_id, concat(f_name,l_name) AS name' );		
		$sub = $this ->subquery->start_subquery ('select');
		$sub-> select ('school_name')-> from('school')	;
		$sub-> where($this->_table. '.school_id = school.id');
		$this->subquery->end_subquery ( 'school_name' );
		$sub = $this->subquery->start_subquery ( 'select' );
		$sub->select ( 'ifnull(CONCAT(FLOOR(SUM(volunteerHours)/60),"Hr(s) ",MOD(SUM(volunteerHours),60),"min(s)"),0)' )->from ( 'postquestion_comment' );
		$sub->where ( $this->_table . '.user_id = postquestion_comment.user_id' );
		$sub->where('datetime >=', $newfrom);
		$sub->where('datetime <=', $newto);
		$this->subquery->end_subquery ( 'volunteerHours' );
		$this->db->from ( $this->_table );
		$this->db->order_by ( 'id', 'Asc' );
		return $this->db->get ()->result ();
	}
	
	public function getUserPostReports($monthYear) {
		$monthYear["From"] = str_replace("/","-",$monthYear["From"]);
		$monthYear["To"] = str_replace("/","-",$monthYear["To"]);
	
		$newfrom = date("Y-m-d", strtotime($monthYear["From"]));
		$newto = date("Y-m-d", strtotime($monthYear["To"]));
		$this->_table = 'user_master';
	
		$this->db->select ( 'id, user_id, concat(f_name,l_name) AS name' );
		$sub = $this->subquery->start_subquery ( 'select' );
		$sub->select ( 'count(post_Id) as count')->from ( 'postquestion' );
		$sub->where ( $this->_table . '.user_id = postquestion.user_Id' );
		$sub->where('datetime >=', $newfrom);
		$sub->where('datetime <=', $newto);
	    $this->subquery->end_subquery ( 'Count' );		
		$sub = $this ->subquery->start_subquery ('select');
		$sub-> select ('school_name')-> from('school')	;
		$sub-> where($this->_table. '.school_id = school.id');
		$this->subquery->end_subquery ( 'school_name' );		
		$this->db->from ( $this->_table );
		$this->db->order_by ( 'id', 'Asc' );
		return $this->db->get ()->result ();
		
		
	}
	//------------------------------------ Tutor Type -----------------------------
	
	public function getTutorreport() {
		$this->_table = "user_master";
		$result = $this->db->query('select id,if((tutorType = "Not interested" or tutorType is NULL), "Others", tutorType ) as label, ifnull(b.value,0) as value from tutor_master as a left join (select tutor_id ,count(tutor_id) as value from user_master GROUP BY tutor_id) as b on a.id = b.tutor_id')->result ();
	    
		return $result;
	}
	
	//------------------------------------ Tutor Type Details-----------------------------
	
	public function getTutorreportdetails($userdata) {
		
	
		$this->_table = "user_master";
		$this->db->select('id,user_id as name, tutor_id ');
		$sub = $this ->subquery->start_subquery ('select');
		 $sub-> select ('ifnull(school_name,"Null")')-> from('school')	;
		 $sub-> where($this->_table.'.school_id = school.id');
		 $this->subquery->end_subquery ( 'school_name' );
		$sub = $this->subquery->start_subquery ( 'select' );
		$sub->select ( 'tutorType as value' )->from ( 'tutor_master' );
		$sub->where ( $this->_table . '.tutor_id = tutor_master.id' );
		$this->subquery->end_subquery ( 'tutorType' );
		$this->db->from ( $this->_table )->where ( 'tutor_id', $userdata );
		// $query = $this->db->last_query();
		// echo ($query);
	//	return $result;
		return $this->db->get ()->result ();
	}
	//------------------------------------ User Rating Details-----------------------------
	
	public function getoverallRating() {		
		$this->_table = "user_master";
		$result = $this->db->query('select A.id, A.user_id, concat(A.f_name,A.l_name) AS name,ifnull(round(sum(B.rating) / count(B.id)),0) as rating from user_master as A LEFT JOIN postquestion_comment as B ON A.user_id =B.user_id where B.post_Id NOT IN(select post_Id from postquestion where user_Id =A.user_id ) group by A.user_id')->result ();
		return $result;
	}
	
}
?>