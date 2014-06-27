<?php
Class User extends CI_Model {
    function login($username, $password) {
        $this->db->select('id, username, type, can_upload');
        $this->db->from('users');
        $this->db->where(" ( `username` = '". $username ."' OR  `email` = '". $username ."' )", NULL, FALSE);
        $this->db->where('password', MD5($password));
        $this->db->where('status', '1');
        $this->db->limit(1);
        
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }
	function saveUser(){
		$post = $this->input->post();
		$post['type'] = 2; $post['status'] = 1; 
		unset($post['addUser']);
		$this->db->insert('users', $post);
		return $this->db->insert_id();
		
	}
	function getAllUsers(){
		$this->db->select('*');
        $this->db->from('users');
		$this->db->where('type', '2');
		$query = $this->db->get();
        return $query->result();
	}
	function getTheUser($id){
		$this->db->select('*');
        $this->db->from('users');
		$this->db->where('id', $id);
		$this->db->where('type', '2');
		$this->db->limit(1);
		$query = $this->db->get();
        return $query->row();
	}
	function getTheUserState($id){
		$this->db->select('status');
        $this->db->from('users');
		$this->db->where('id', $id);
		$this->db->where('type', '2');
		$this->db->limit(1);
		$query = $this->db->get();
        return $query->row();
	}
	function getTheUploadState($id){
		$this->db->select('can_upload');
        $this->db->from('users');
		$this->db->where('id', $id);
		$this->db->where('type', '2');
		$this->db->limit(1);
		$query = $this->db->get();
        return $query->row();
	}
	function editUser(){
		$post = $this->input->post();
		$post['remarks'] = nl2br($post['remarks']);
		$userId = $post['userId'];
		if(isset($post['npassword']) && !empty($post['npassword'])){
			$post['password'] = $post['npassword'];
		}
		unset($post['EditUser']); unset($post['npassword']); unset($post['userId']);  
		$this->db->where('id', $userId);
		$this->db->update('users', $post); 
		return $userId; 
	}
	function setStatus($id){
		$prevState = $this->getTheUserState($id);
		$status = 1;
		if( $prevState->status == 1 ){
			$status = 0;
		}
		$post['status'] = $status;
		$this->db->where('id', $id);
		$this->db->update('users', $post); 
		return true;
 	}
 	function setUploadStatus($id){
		$prevState = $this->getTheUploadState($id);
		$status = 1;
		if( $prevState->can_upload == 1 ){
			$status = 0;
		}
		$post['can_upload'] = $status;
		$this->db->where('id', $id);
		$this->db->update('users', $post); 
		return true;
 	}
 	function getAllUploadableUsers(){
		$this->db->select('id, name');
        $this->db->from('users');
		$this->db->where('type', '2');
		$this->db->where('can_upload', '1');
		$query = $this->db->get();
        return $query->result();
	}
}
?>
